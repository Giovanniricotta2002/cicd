--
-- PostgreSQL database dump
--

-- Dumped from database version 10.23 (Ubuntu 10.23-0ubuntu0.18.04.2)
-- Dumped by pg_dump version 10.23 (Ubuntu 10.23-0ubuntu0.18.04.2)

-- SET statement_timeout = 0;
-- SET lock_timeout = 0;
-- SET idle_in_transaction_session_timeout = 0;
-- SET client_encoding = 'UTF8';
-- SET standard_conforming_strings = on;
-- SELECT pg_catalog.set_config('search_path', '', false);
-- SET check_function_bodies = false;
-- SET xmloption = content;
-- SET client_min_messages = warning;
-- SET row_security = off;

--
-- Name: openads; Type: SCHEMA; Schema: -; Owner: -
--

-- CREATE SCHEMA openads;


--
-- Name: lien_dossier_dossier_type_lien; Type: TYPE; Schema: openads; Owner: -
--

CREATE TYPE lien_dossier_dossier_type_lien AS ENUM (
    'manuel',
    'auto_recours'
);


--
-- Name: adresse(text, text, text, text, text, text, text, text, text, text); Type: FUNCTION; Schema: openads; Owner: -
--

CREATE FUNCTION adresse(numero text, voie text, complement text, lieu_dit text, bp text, code_postal text, localite text, cedex text, pays text DEFAULT ''::text, separateur text DEFAULT '<br>'::text) RETURNS text
    LANGUAGE sql
    AS $$

    SELECT TRIM(CONCAT(
        CASE WHEN COALESCE(numero, '') != '' THEN CONCAT(numero, ' ') END,
        CASE WHEN COALESCE(voie, '') != '' THEN CONCAT(voie, separateur) END,
        CASE WHEN COALESCE(complement, '') != '' THEN CONCAT(complement, separateur) END,
        CASE WHEN COALESCE(lieu_dit, '') != '' THEN CONCAT('Lieu-dit ', lieu_dit, separateur) END,
        CASE WHEN COALESCE(bp, '') != '' THEN CONCAT('BP ', bp, separateur) END, 
        CASE WHEN COALESCE(code_postal, '') != '' THEN CONCAT(code_postal, ' ') END,
        CASE WHEN COALESCE(localite, '') != '' THEN CONCAT(localite, ' ') END,
        CASE WHEN COALESCE(cedex, '') != '' THEN CONCAT('CEDEX ', cedex) END,
        CASE WHEN COALESCE(pays, '') != '' AND LOWER(TRIM(pays)) != 'france' THEN CONCAT(separateur, pays) END
    ))
$$;


--
-- Name: check_validite_unique(); Type: FUNCTION; Schema: openads; Owner: -
--

CREATE FUNCTION check_validite_unique() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
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
            document_numerise_type
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
$$;


--
-- Name: fn_traitement_existant_filtre_da(); Type: FUNCTION; Schema: openads; Owner: -
--

CREATE FUNCTION fn_traitement_existant_filtre_da() RETURNS integer
    LANGUAGE plpgsql
    AS $$
DECLARE
om_parametre_var VARCHAR;
code_var varchar;
BEGIN

    -- Récupère le contenu du paramètre contenant la liste des codes filtrés
    om_parametre_var := (SELECT valeur FROM om_parametre WHERE libelle = 'da_listing_pieces_filtre')::VARCHAR;

    -- Si le paramètre de filtre des pièces dans le contexte des DA existe
    IF om_parametre_var != ''
    THEN
        -- Pour chaque code
        FOR code_var IN SELECT regexp_split_to_table(om_parametre_var, E';') AS code
        LOOP
            -- Met à jour les types de pièce
            UPDATE document_numerise_type
            SET aff_da = 't'
            WHERE code = code_var;
        END LOOP;
    END IF;

    --
    RETURN 0;
END;
$$;


-- SET default_tablespace = '';

-- SET default_with_oids = false;

--
-- Name: action; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE action (
    action character varying(150) NOT NULL,
    libelle character varying(60) NOT NULL,
    regle_etat character varying(60),
    regle_delai character varying(60),
    regle_accord_tacite character varying(60),
    regle_avis character varying(60),
    regle_date_limite character varying(60),
    regle_date_notification_delai character varying(60),
    regle_date_complet character varying(60),
    regle_date_validite character varying(60),
    regle_date_decision character varying(60),
    regle_date_chantier character varying(60),
    regle_date_achevement character varying(60),
    regle_date_conformite character varying(60),
    regle_date_rejet character varying(60),
    regle_date_dernier_depot character varying(60),
    regle_date_limite_incompletude character varying(60),
    regle_delai_incompletude character varying(60),
    regle_autorite_competente character varying(60),
    regle_date_cloture_instruction character varying(60),
    regle_date_premiere_visite character varying(60),
    regle_date_derniere_visite character varying(60),
    regle_date_contradictoire character varying(60),
    regle_date_retour_contradictoire character varying(60),
    regle_date_ait character varying(60),
    regle_date_transmission_parquet character varying(60),
    regle_donnees_techniques1 character varying(60),
    regle_donnees_techniques2 character varying(60),
    regle_donnees_techniques3 character varying(60),
    regle_donnees_techniques4 character varying(60),
    regle_donnees_techniques5 character varying(60),
    cible_regle_donnees_techniques1 character varying(250),
    cible_regle_donnees_techniques2 character varying(250),
    cible_regle_donnees_techniques3 character varying(250),
    cible_regle_donnees_techniques4 character varying(250),
    cible_regle_donnees_techniques5 character varying(250),
    regle_dossier_instruction_type character varying(60) DEFAULT NULL::character varying,
    regle_date_affichage character varying(30),
    regle_pec_metier character varying(60),
    regle_a_qualifier character varying(60),
    regle_incompletude character varying(60),
    regle_incomplet_notifie character varying(60),
    regle_etat_pendant_incompletude character varying(60),
    regle_evenement_suivant_tacite_incompletude character varying(60)
);


--
-- Name: TABLE action; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE action IS 'Action effectuée lors de l''ajout d''un événement d''instruction';


--
-- Name: COLUMN action.action; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.action IS 'Identifiant unique';


--
-- Name: COLUMN action.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.libelle IS 'Libellé de l''action';


--
-- Name: COLUMN action.regle_etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_etat IS 'Règle de calcul de l''état des dossiers d''instruction';


--
-- Name: COLUMN action.regle_delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_delai IS 'Règle de calcul du délai des dossiers d''instruction';


--
-- Name: COLUMN action.regle_accord_tacite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_accord_tacite IS 'Règle de calcul de l''accord tacite des dossiers d''instruction';


--
-- Name: COLUMN action.regle_avis; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_avis IS 'Règle de calcul de l''avis des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_limite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_limite IS 'Règle de calcul de la date limite des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_notification_delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_notification_delai IS 'Règle de calcul de la date de notification de délai des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_complet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_complet IS 'Règle de calcul de la date de complétude des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_validite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_validite IS 'Règle de calcul de date de validité des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_decision IS 'Règle de calcul de date de décision des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_chantier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_chantier IS 'Règle de calcul de date d''ouverture de chantier chantier';


--
-- Name: COLUMN action.regle_date_achevement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_achevement IS 'Règle de calcul de date d''achèvement de travaux';


--
-- Name: COLUMN action.regle_date_conformite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_conformite IS 'Règle de calcul de date de conformité des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_rejet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_rejet IS 'Règle de calcul de la date de rejet des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_dernier_depot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_dernier_depot IS 'Règle de calcul de la date de dernier dépôt des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_limite_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_limite_incompletude IS 'Règle de calcul de la date limite d''incomplétude des dossiers d''instruction';


--
-- Name: COLUMN action.regle_delai_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_delai_incompletude IS 'Règle de calcul du délai d''incomplétude des dossiers d''instruction';


--
-- Name: COLUMN action.regle_autorite_competente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_autorite_competente IS 'Règle de calcul de l''autorité compétente des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_cloture_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_cloture_instruction IS 'Règle de calcul de la date de cloture de l''instruction des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_premiere_visite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_premiere_visite IS 'Règle de calcul de la date de première visite des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_derniere_visite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_derniere_visite IS 'Règle de calcul de la date de dernière visite des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_contradictoire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_contradictoire IS 'Règle de calcul de la date de contradictoire des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_retour_contradictoire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_retour_contradictoire IS 'Règle de calcul de la date de retour de contradictoire des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_ait; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_ait IS 'Règle de calcul de la date d''AIT des dossiers d''instruction';


--
-- Name: COLUMN action.regle_date_transmission_parquet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_transmission_parquet IS 'Règle de calcul de la date de transmission au parquet des dossiers d''instruction';


--
-- Name: COLUMN action.regle_donnees_techniques1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_donnees_techniques1 IS 'Règle de calcul d''un champ des données techniques';


--
-- Name: COLUMN action.regle_donnees_techniques2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_donnees_techniques2 IS 'Règle de calcul d''un champ des données techniques';


--
-- Name: COLUMN action.regle_donnees_techniques3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_donnees_techniques3 IS 'Règle de calcul d''un champ des données techniques';


--
-- Name: COLUMN action.regle_donnees_techniques4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_donnees_techniques4 IS 'Règle de calcul d''un champ des données techniques';


--
-- Name: COLUMN action.regle_donnees_techniques5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_donnees_techniques5 IS 'Règle de calcul d''un champ des données techniques';


--
-- Name: COLUMN action.cible_regle_donnees_techniques1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.cible_regle_donnees_techniques1 IS 'Champ des données techniques ciblé par la règle 1';


--
-- Name: COLUMN action.cible_regle_donnees_techniques2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.cible_regle_donnees_techniques2 IS 'Champ des données techniques ciblé par la règle 2';


--
-- Name: COLUMN action.cible_regle_donnees_techniques3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.cible_regle_donnees_techniques3 IS 'Champ des données techniques ciblé par la règle 3';


--
-- Name: COLUMN action.cible_regle_donnees_techniques4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.cible_regle_donnees_techniques4 IS 'Champ des données techniques ciblé par la règle 4';


--
-- Name: COLUMN action.cible_regle_donnees_techniques5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.cible_regle_donnees_techniques5 IS 'Champ des données techniques ciblé par la règle 5';


--
-- Name: COLUMN action.regle_dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_dossier_instruction_type IS 'Règle de modification du type de dossier d''instruction';


--
-- Name: COLUMN action.regle_date_affichage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_date_affichage IS 'Règle de calcul de la date d''affichage de l''avis de dépôt du dossier d''instruction';


--
-- Name: COLUMN action.regle_pec_metier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_pec_metier IS 'Règle de calcul de la prise en compte métier d''un dossier d''instruction';


--
-- Name: COLUMN action.regle_a_qualifier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_a_qualifier IS 'Règle de calcul de la qualification d''un dossier d''instruction';


--
-- Name: COLUMN action.regle_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_incompletude IS 'Règle de calcul de l''incomplétude d''un dossier d''instruction';


--
-- Name: COLUMN action.regle_incomplet_notifie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_incomplet_notifie IS 'Règle de calcul de l''incomplétude notifiée d''un dossier d''instruction';


--
-- Name: COLUMN action.regle_etat_pendant_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_etat_pendant_incompletude IS 'Règle de calcul de l''état d''un dossier d''instruction pendant son incomplétude';


--
-- Name: COLUMN action.regle_evenement_suivant_tacite_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN action.regle_evenement_suivant_tacite_incompletude IS 'Règle de calcul pour définir si l''événement suivant tacite paramétré sur l''événement concerne l''incomplétude du dossier d''instruction';


--
-- Name: affectation_automatique; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE affectation_automatique (
    affectation_automatique integer NOT NULL,
    arrondissement integer,
    quartier integer,
    section character varying(2),
    instructeur integer,
    dossier_autorisation_type_detaille integer,
    om_collectivite integer NOT NULL,
    instructeur_2 integer,
    communes character varying(2000),
    affectation_manuelle character varying(100),
    dossier_instruction_type integer
);


--
-- Name: TABLE affectation_automatique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE affectation_automatique IS 'Les dossiers d''instruction sont affectés aux instructeurs en fonction du type détaillé de dossier d''autorisation, arrondissement, quartier et section (dans cette priorité)';


--
-- Name: COLUMN affectation_automatique.affectation_automatique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.affectation_automatique IS 'Identifiant unique';


--
-- Name: COLUMN affectation_automatique.arrondissement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.arrondissement IS 'Arrondissement affecté à l''instructeur';


--
-- Name: COLUMN affectation_automatique.quartier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.quartier IS 'Quartier affecté à l''instructeur';


--
-- Name: COLUMN affectation_automatique.section; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.section IS 'Section affectée à l''instructeur';


--
-- Name: COLUMN affectation_automatique.instructeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.instructeur IS 'Identifiant du premier instructeur ';


--
-- Name: COLUMN affectation_automatique.dossier_autorisation_type_detaille; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.dossier_autorisation_type_detaille IS 'Type détaillé de dossier d''autorisation affectés à l''instructeur';


--
-- Name: COLUMN affectation_automatique.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.om_collectivite IS 'lien vers la collectivité concernée';


--
-- Name: COLUMN affectation_automatique.instructeur_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.instructeur_2 IS 'Identifiant du second instructeur';


--
-- Name: COLUMN affectation_automatique.communes; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.communes IS 'Communes associées';


--
-- Name: COLUMN affectation_automatique.affectation_manuelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.affectation_manuelle IS 'Affectation manuelle';


--
-- Name: COLUMN affectation_automatique.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN affectation_automatique.dossier_instruction_type IS 'Type de dossier d''instruction affecté à l''instructeur';


--
-- Name: affectation_automatique_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE affectation_automatique_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: affectation_automatique_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE affectation_automatique_seq OWNED BY affectation_automatique.affectation_automatique;


--
-- Name: architecte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE architecte (
    architecte integer NOT NULL,
    nom character varying(50) NOT NULL,
    prenom character varying(50) DEFAULT ''::character varying NOT NULL,
    adresse1 character varying(50) DEFAULT ''::character varying NOT NULL,
    adresse2 character varying(50) DEFAULT ''::character varying NOT NULL,
    cp character varying(5) DEFAULT ''::character varying NOT NULL,
    ville character varying(50) DEFAULT ''::character varying NOT NULL,
    pays character varying(40) DEFAULT ''::character varying NOT NULL,
    inscription character varying(20) DEFAULT ''::character varying NOT NULL,
    telephone character varying(20) DEFAULT ''::character varying NOT NULL,
    fax character varying(14) DEFAULT ''::character varying NOT NULL,
    email character varying(60) DEFAULT ''::character varying NOT NULL,
    note text,
    frequent boolean,
    nom_cabinet character varying(100),
    conseil_regional character varying(100),
    lieu_dit character varying(39),
    boite_postale character varying(5),
    cedex character varying(5),
    titre_obt_diplo_spec text,
    date_obt_diplo_spec date,
    lieu_obt_diplo_spec text
);


--
-- Name: TABLE architecte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE architecte IS 'Coordonnées d''un architecte';


--
-- Name: COLUMN architecte.architecte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.architecte IS 'Identifiant unique';


--
-- Name: COLUMN architecte.nom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.nom IS 'Nom de famille de l''architecte';


--
-- Name: COLUMN architecte.prenom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.prenom IS 'Prénom de l''architecte';


--
-- Name: COLUMN architecte.adresse1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.adresse1 IS 'Adresse de l''architecte';


--
-- Name: COLUMN architecte.adresse2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.adresse2 IS 'Complément d''adresse de l''architecte';


--
-- Name: COLUMN architecte.cp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.cp IS 'Code postal de l''adresse de l''architecte';


--
-- Name: COLUMN architecte.ville; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.ville IS 'Ville de l''adresse de l''architecte';


--
-- Name: COLUMN architecte.pays; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.pays IS 'Pays de résidence de l''architecte';


--
-- Name: COLUMN architecte.inscription; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.inscription IS 'Numéro d''inscription au conseil national de l''ordre des architectes de l''architecte';


--
-- Name: COLUMN architecte.telephone; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.telephone IS 'Téléphone de l''architecte';


--
-- Name: COLUMN architecte.fax; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.fax IS 'Fax de l''architecte';


--
-- Name: COLUMN architecte.email; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.email IS 'Email de l''architecte';


--
-- Name: COLUMN architecte.note; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.note IS 'Note à propos de l''architecte';


--
-- Name: COLUMN architecte.frequent; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.frequent IS 'Permet de faire apparaître l''architecte dans la recherche sur les architectes dans les données techniques';


--
-- Name: COLUMN architecte.nom_cabinet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.nom_cabinet IS 'Nom du cabinet dans lequel travail l''architecte';


--
-- Name: COLUMN architecte.conseil_regional; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.conseil_regional IS 'Conseil régional de l''architecte';


--
-- Name: COLUMN architecte.lieu_dit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.lieu_dit IS 'Lieu-dit de l''adresse';


--
-- Name: COLUMN architecte.boite_postale; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.boite_postale IS 'Boîte postale de l''adresse';


--
-- Name: COLUMN architecte.cedex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.cedex IS 'Cedex de l''adresse';


--
-- Name: COLUMN architecte.titre_obt_diplo_spec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.titre_obt_diplo_spec IS 'Titre d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';


--
-- Name: COLUMN architecte.date_obt_diplo_spec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.date_obt_diplo_spec IS 'Date d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';


--
-- Name: COLUMN architecte.lieu_obt_diplo_spec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN architecte.lieu_obt_diplo_spec IS 'Établissement / ville / pays d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';


--
-- Name: architecte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE architecte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: architecte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE architecte_seq OWNED BY architecte.architecte;


--
-- Name: arrondissement; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE arrondissement (
    arrondissement integer NOT NULL,
    libelle character varying(3) NOT NULL,
    code_postal character varying(5) NOT NULL,
    code_impots character varying(3) NOT NULL
);


--
-- Name: TABLE arrondissement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE arrondissement IS 'Division territoriale, administrative de la ville';


--
-- Name: COLUMN arrondissement.arrondissement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN arrondissement.arrondissement IS 'Identifiant unique';


--
-- Name: COLUMN arrondissement.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN arrondissement.libelle IS 'Libellé de l''arrondissement';


--
-- Name: COLUMN arrondissement.code_postal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN arrondissement.code_postal IS 'Code postal de l''arrondissement';


--
-- Name: COLUMN arrondissement.code_impots; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN arrondissement.code_impots IS 'Code impôt de l''arrondissement, notamment utilisé pour les références cadastrales afin de récupérer l''adresse depuis un SIG';


--
-- Name: arrondissement_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE arrondissement_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: arrondissement_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE arrondissement_seq OWNED BY arrondissement.arrondissement;


--
-- Name: autorite_competente; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE autorite_competente (
    autorite_competente integer NOT NULL,
    code character varying(20),
    libelle character varying(100),
    description text,
    autorite_competente_sitadel integer NOT NULL
);


--
-- Name: TABLE autorite_competente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE autorite_competente IS 'Autorité compétente pour rendre une décision sur une instruction';


--
-- Name: COLUMN autorite_competente.autorite_competente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN autorite_competente.autorite_competente IS 'Identifiant unique';


--
-- Name: COLUMN autorite_competente.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN autorite_competente.code IS 'Code de l''autorité compétente';


--
-- Name: COLUMN autorite_competente.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN autorite_competente.libelle IS 'Libellé de l''autorité compétente';


--
-- Name: COLUMN autorite_competente.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN autorite_competente.description IS 'Description de l''autorité compétente';


--
-- Name: COLUMN autorite_competente.autorite_competente_sitadel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN autorite_competente.autorite_competente_sitadel IS 'Code sitadel de l''autorité compétente';


--
-- Name: autorite_competente_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE autorite_competente_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: autorite_competente_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE autorite_competente_seq OWNED BY autorite_competente.autorite_competente;


--
-- Name: avis_consultation; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE avis_consultation (
    libelle character varying(50) NOT NULL,
    abrege character varying(10),
    om_validite_debut date,
    om_validite_fin date,
    avis_consultation integer NOT NULL,
    code character varying(10)
);


--
-- Name: TABLE avis_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE avis_consultation IS 'Avis décidé après une consultation';


--
-- Name: COLUMN avis_consultation.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_consultation.libelle IS 'Libellé de l''avis';


--
-- Name: COLUMN avis_consultation.abrege; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_consultation.abrege IS 'Abréviation de l''avis';


--
-- Name: COLUMN avis_consultation.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_consultation.om_validite_debut IS 'Date de début de validité de l''avis';


--
-- Name: COLUMN avis_consultation.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_consultation.om_validite_fin IS 'Date de fin de validité de l''avis';


--
-- Name: COLUMN avis_consultation.avis_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_consultation.avis_consultation IS 'Identifiant unique';


--
-- Name: COLUMN avis_consultation.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_consultation.code IS 'Code unique de l''avis de consultation';


--
-- Name: avis_consultation_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE avis_consultation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: avis_consultation_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE avis_consultation_seq OWNED BY avis_consultation.avis_consultation;


--
-- Name: avis_decision; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE avis_decision (
    libelle character varying(50) NOT NULL,
    typeavis character(1) DEFAULT ''::bpchar NOT NULL,
    sitadel character(1) DEFAULT ''::bpchar NOT NULL,
    sitadel_motif character(1) DEFAULT ''::bpchar NOT NULL,
    avis_decision integer NOT NULL,
    tacite boolean DEFAULT false,
    avis_decision_type integer,
    avis_decision_nature integer,
    prescription boolean DEFAULT false
);


--
-- Name: TABLE avis_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE avis_decision IS 'Avis décidé après l''instruction d''un dossier d''instruction';


--
-- Name: COLUMN avis_decision.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision.libelle IS 'Libellé de l''avis';


--
-- Name: COLUMN avis_decision.typeavis; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision.typeavis IS 'Type d''avis à rendre';


--
-- Name: COLUMN avis_decision.sitadel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision.sitadel IS 'Type de mouvement sitadel';


--
-- Name: COLUMN avis_decision.sitadel_motif; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision.sitadel_motif IS 'Motif de refus sitadel';


--
-- Name: COLUMN avis_decision.avis_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision.avis_decision IS 'Identifiant unique';


--
-- Name: COLUMN avis_decision.tacite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision.tacite IS 'Indique si l''avis de décision est appliqué par tacicité';


--
-- Name: COLUMN avis_decision.avis_decision_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision.avis_decision_type IS 'Type de l''avis de décision';


--
-- Name: COLUMN avis_decision.avis_decision_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision.avis_decision_nature IS 'Nature de l''avis de décision';


--
-- Name: COLUMN avis_decision.prescription; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision.prescription IS 'Identifie si l''avis de décision concerne une prescription archéologique';


--
-- Name: avis_decision_nature; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE avis_decision_nature (
    avis_decision_nature integer NOT NULL,
    code character varying(10),
    libelle character varying(255) NOT NULL,
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE avis_decision_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE avis_decision_nature IS 'Nature d''avis décision';


--
-- Name: COLUMN avis_decision_nature.avis_decision_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_nature.avis_decision_nature IS 'Identifiant technique de la nature d''avis décision';


--
-- Name: COLUMN avis_decision_nature.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_nature.code IS 'Code de la nature d''avis décision';


--
-- Name: COLUMN avis_decision_nature.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_nature.libelle IS 'Libellé de la nature d''avis décision';


--
-- Name: COLUMN avis_decision_nature.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_nature.description IS 'Description de la nature d''avis décision';


--
-- Name: COLUMN avis_decision_nature.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_nature.om_validite_debut IS 'Date de validité (début) de la nature d''avis décision';


--
-- Name: COLUMN avis_decision_nature.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_nature.om_validite_fin IS 'Date de validité (fin) de la nature d''avis décision';


--
-- Name: avis_decision_nature_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE avis_decision_nature_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: avis_decision_nature_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE avis_decision_nature_seq OWNED BY avis_decision_nature.avis_decision_nature;


--
-- Name: avis_decision_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE avis_decision_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: avis_decision_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE avis_decision_seq OWNED BY avis_decision.avis_decision;


--
-- Name: avis_decision_type; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE avis_decision_type (
    avis_decision_type integer NOT NULL,
    code character varying(10),
    libelle character varying(255) NOT NULL,
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE avis_decision_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE avis_decision_type IS 'Type d''avis décision';


--
-- Name: COLUMN avis_decision_type.avis_decision_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_type.avis_decision_type IS 'Identifiant technique du type d''avis décision';


--
-- Name: COLUMN avis_decision_type.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_type.code IS 'Code du type d''avis décision';


--
-- Name: COLUMN avis_decision_type.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_type.libelle IS 'Libellé du type d''avis décision';


--
-- Name: COLUMN avis_decision_type.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_type.description IS 'Description du type d''avis décision';


--
-- Name: COLUMN avis_decision_type.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_type.om_validite_debut IS 'Date de validité (début) du type d''avis décision';


--
-- Name: COLUMN avis_decision_type.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN avis_decision_type.om_validite_fin IS 'Date de validité (fin) du type d''avis décision';


--
-- Name: avis_decision_type_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE avis_decision_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: avis_decision_type_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE avis_decision_type_seq OWNED BY avis_decision_type.avis_decision_type;


--
-- Name: bible; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE bible (
    bible integer NOT NULL,
    libelle character varying(60) NOT NULL,
    evenement integer,
    contenu text NOT NULL,
    complement integer,
    automatique character(3) DEFAULT ''::bpchar NOT NULL,
    dossier_autorisation_type integer,
    om_collectivite integer NOT NULL
);


--
-- Name: TABLE bible; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE bible IS 'Bible qui regroupe des textes applicables sur les événements d''instruction';


--
-- Name: COLUMN bible.bible; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN bible.bible IS 'Identifiant unique';


--
-- Name: COLUMN bible.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN bible.libelle IS 'Libellé du texte de la bible';


--
-- Name: COLUMN bible.evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN bible.evenement IS 'Événement sur lequel le texte de la bible est applicable';


--
-- Name: COLUMN bible.contenu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN bible.contenu IS 'Texte de la bible';


--
-- Name: COLUMN bible.complement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN bible.complement IS 'Complément de l''événement d''instruction sur lequel s''applique le texte de la bible';


--
-- Name: COLUMN bible.automatique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN bible.automatique IS 'Applique automatiquement le texte de la bible sur la lettre type';


--
-- Name: COLUMN bible.dossier_autorisation_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN bible.dossier_autorisation_type IS 'Type du dossier d''autorisation sur lequel le texte de la bible est applicable';


--
-- Name: COLUMN bible.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN bible.om_collectivite IS 'Lien vers la collectivité concernée.';


--
-- Name: bible_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE bible_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: bible_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE bible_seq OWNED BY bible.bible;


--
-- Name: blocnote; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE blocnote (
    blocnote integer NOT NULL,
    categorie character varying(20) NOT NULL,
    note text NOT NULL,
    dossier character varying(30)
);


--
-- Name: TABLE blocnote; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE blocnote IS 'Annotation concernant le dossier d''instruction lié';


--
-- Name: COLUMN blocnote.blocnote; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN blocnote.blocnote IS 'Identifiant unique';


--
-- Name: COLUMN blocnote.categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN blocnote.categorie IS 'Catégorie de la note';


--
-- Name: COLUMN blocnote.note; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN blocnote.note IS 'Contenu de la note';


--
-- Name: COLUMN blocnote.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN blocnote.dossier IS 'Dossier d''instruction lié';


--
-- Name: blocnote_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE blocnote_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: blocnote_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE blocnote_seq OWNED BY blocnote.blocnote;


--
-- Name: categorie_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE categorie_tiers_consulte (
    categorie_tiers_consulte integer NOT NULL,
    code character varying(50),
    description text,
    libelle character varying(255) NOT NULL,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: COLUMN categorie_tiers_consulte.categorie_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN categorie_tiers_consulte.categorie_tiers_consulte IS 'Identifiant unique';


--
-- Name: COLUMN categorie_tiers_consulte.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN categorie_tiers_consulte.code IS 'Code de la catégorie du tiers consulté';


--
-- Name: COLUMN categorie_tiers_consulte.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN categorie_tiers_consulte.description IS 'Description de la catégorie du tiers consulté';


--
-- Name: COLUMN categorie_tiers_consulte.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN categorie_tiers_consulte.libelle IS 'Libellé de la catégorie du tiers consulté';


--
-- Name: COLUMN categorie_tiers_consulte.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN categorie_tiers_consulte.om_validite_debut IS 'Date de début de validité de catégorie du tiers consulté';


--
-- Name: COLUMN categorie_tiers_consulte.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN categorie_tiers_consulte.om_validite_fin IS 'Date de fin de validité de catégorie du tiers consulté';


--
-- Name: categorie_tiers_consulte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE categorie_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: categorie_tiers_consulte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE categorie_tiers_consulte_seq OWNED BY categorie_tiers_consulte.categorie_tiers_consulte;


--
-- Name: cerfa; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE cerfa (
    cerfa integer NOT NULL,
    libelle character varying(200),
    code character varying(20),
    om_validite_debut date,
    om_validite_fin date,
    am_lotiss boolean,
    am_autre_div boolean,
    am_camping boolean,
    am_caravane boolean,
    am_carav_duree boolean,
    am_statio boolean,
    am_statio_cont boolean,
    am_affou_exhau boolean,
    am_affou_exhau_sup boolean,
    am_affou_prof boolean,
    am_exhau_haut boolean,
    am_coupe_abat boolean,
    am_prot_plu boolean,
    am_prot_muni boolean,
    am_mobil_voyage boolean,
    am_aire_voyage boolean,
    am_rememb_afu boolean,
    am_parc_resid_loi boolean,
    am_sport_moto boolean,
    am_sport_attrac boolean,
    am_sport_golf boolean,
    am_mob_art boolean,
    am_modif_voie_esp boolean,
    am_plant_voie_esp boolean,
    am_chem_ouv_esp boolean,
    am_agri_peche boolean,
    am_crea_voie boolean,
    am_modif_voie_exist boolean,
    am_crea_esp_sauv boolean,
    am_crea_esp_class boolean,
    am_projet_desc boolean,
    am_terr_surf boolean,
    am_tranche_desc boolean,
    am_lot_max_nb boolean,
    am_lot_max_shon boolean,
    am_lot_cstr_cos boolean,
    am_lot_cstr_plan boolean,
    am_lot_cstr_vente boolean,
    am_lot_fin_diff boolean,
    am_lot_consign boolean,
    am_lot_gar_achev boolean,
    am_lot_vente_ant boolean,
    am_empl_nb boolean,
    am_tente_nb boolean,
    am_carav_nb boolean,
    am_mobil_nb boolean,
    am_pers_nb boolean,
    am_empl_hll_nb boolean,
    am_hll_shon boolean,
    am_periode_exploit boolean,
    am_exist_agrand boolean,
    am_exist_date boolean,
    am_exist_num boolean,
    am_exist_nb_avant boolean,
    am_exist_nb_apres boolean,
    am_coupe_bois boolean,
    am_coupe_parc boolean,
    am_coupe_align boolean,
    am_coupe_ess boolean,
    am_coupe_age boolean,
    am_coupe_dens boolean,
    am_coupe_qual boolean,
    am_coupe_trait boolean,
    am_coupe_autr boolean,
    co_archi_recours boolean,
    co_cstr_nouv boolean,
    co_cstr_exist boolean,
    co_cloture boolean,
    co_elec_tension boolean,
    co_div_terr boolean,
    co_projet_desc boolean,
    co_anx_pisc boolean,
    co_anx_gara boolean,
    co_anx_veran boolean,
    co_anx_abri boolean,
    co_anx_autr boolean,
    co_anx_autr_desc boolean,
    co_tot_log_nb boolean,
    co_tot_ind_nb boolean,
    co_tot_coll_nb boolean,
    co_mais_piece_nb boolean,
    co_mais_niv_nb boolean,
    co_fin_lls_nb boolean,
    co_fin_aa_nb boolean,
    co_fin_ptz_nb boolean,
    co_fin_autr_nb boolean,
    co_fin_autr_desc boolean,
    co_mais_contrat_ind boolean,
    co_uti_pers boolean,
    co_uti_vente boolean,
    co_uti_loc boolean,
    co_uti_princ boolean,
    co_uti_secon boolean,
    co_resid_agees boolean,
    co_resid_etud boolean,
    co_resid_tourism boolean,
    co_resid_hot_soc boolean,
    co_resid_soc boolean,
    co_resid_hand boolean,
    co_resid_autr boolean,
    co_resid_autr_desc boolean,
    co_foyer_chamb_nb boolean,
    co_log_1p_nb boolean,
    co_log_2p_nb boolean,
    co_log_3p_nb boolean,
    co_log_4p_nb boolean,
    co_log_5p_nb boolean,
    co_log_6p_nb boolean,
    co_bat_niv_nb boolean,
    co_trx_exten boolean,
    co_trx_surelev boolean,
    co_trx_nivsup boolean,
    co_demont_periode boolean,
    co_sp_transport boolean,
    co_sp_enseign boolean,
    co_sp_act_soc boolean,
    co_sp_ouvr_spe boolean,
    co_sp_sante boolean,
    co_sp_culture boolean,
    co_statio_avt_nb boolean,
    co_statio_apr_nb boolean,
    co_statio_adr boolean,
    co_statio_place_nb boolean,
    co_statio_tot_surf boolean,
    co_statio_tot_shob boolean,
    co_statio_comm_cin_surf boolean,
    tab_surface integer,
    dm_constr_dates boolean,
    dm_total boolean,
    dm_partiel boolean,
    dm_projet_desc boolean,
    dm_tot_log_nb boolean,
    tax_surf_tot boolean,
    tax_surf boolean,
    tax_surf_suppr_mod boolean,
    tab_tax_su_princ integer,
    tab_tax_su_heber integer,
    tab_tax_su_secon integer,
    tab_tax_su_tot integer,
    tax_ext_pret boolean,
    tax_ext_desc boolean,
    tax_surf_tax_exist_cons boolean,
    tax_log_exist_nb boolean,
    tax_trx_presc_ppr boolean,
    tax_monu_hist boolean,
    tax_comm_nb boolean,
    tab_tax_su_non_habit_surf integer,
    tab_tax_am integer,
    vsd_surf_planch_smd boolean,
    vsd_unit_fonc_sup boolean,
    vsd_unit_fonc_constr_sup boolean,
    vsd_val_terr boolean,
    vsd_const_sxist_non_dem_surf boolean,
    vsd_rescr_fisc boolean,
    pld_val_terr boolean,
    pld_const_exist_dem boolean,
    pld_const_exist_dem_surf boolean,
    code_cnil boolean,
    terr_juri_titul boolean,
    terr_juri_lot boolean,
    terr_juri_zac boolean,
    terr_juri_afu boolean,
    terr_juri_pup boolean,
    terr_juri_oin boolean,
    terr_juri_desc boolean,
    terr_div_surf_etab boolean,
    terr_div_surf_av_div boolean,
    doc_date boolean,
    doc_tot_trav boolean,
    doc_tranche_trav boolean,
    doc_tranche_trav_desc boolean,
    doc_surf boolean,
    doc_nb_log boolean,
    doc_nb_log_indiv boolean,
    doc_nb_log_coll boolean,
    doc_nb_log_lls boolean,
    doc_nb_log_aa boolean,
    doc_nb_log_ptz boolean,
    doc_nb_log_autre boolean,
    daact_date boolean,
    daact_date_chgmt_dest boolean,
    daact_tot_trav boolean,
    daact_tranche_trav boolean,
    daact_tranche_trav_desc boolean,
    daact_surf boolean,
    daact_nb_log boolean,
    daact_nb_log_indiv boolean,
    daact_nb_log_coll boolean,
    daact_nb_log_lls boolean,
    daact_nb_log_aa boolean,
    daact_nb_log_ptz boolean,
    daact_nb_log_autre boolean,
    am_div_mun boolean,
    co_perf_energ boolean,
    architecte boolean,
    co_statio_avt_shob boolean DEFAULT false,
    co_statio_apr_shob boolean DEFAULT false,
    co_statio_avt_surf boolean DEFAULT false,
    co_statio_apr_surf boolean DEFAULT false,
    co_trx_amgt boolean DEFAULT false,
    co_modif_aspect boolean DEFAULT false,
    co_modif_struct boolean DEFAULT false,
    co_ouvr_elec boolean DEFAULT false,
    co_ouvr_infra boolean DEFAULT false,
    co_trx_imm boolean DEFAULT false,
    co_cstr_shob boolean DEFAULT false,
    am_voyage_deb boolean DEFAULT false,
    am_voyage_fin boolean DEFAULT false,
    am_modif_amgt boolean DEFAULT false,
    am_lot_max_shob boolean DEFAULT false,
    mod_desc boolean DEFAULT false,
    tr_total boolean DEFAULT false,
    tr_partiel boolean DEFAULT false,
    tr_desc boolean DEFAULT false,
    avap_co_elt_pro boolean DEFAULT false,
    avap_nouv_haut_surf boolean DEFAULT false,
    avap_co_clot boolean DEFAULT false,
    avap_aut_coup_aba_arb boolean DEFAULT false,
    avap_ouv_infra boolean DEFAULT false,
    avap_aut_inst_mob boolean DEFAULT false,
    avap_aut_plant boolean DEFAULT false,
    avap_aut_auv_elec boolean DEFAULT false,
    tax_dest_loc_tr boolean DEFAULT false,
    ope_proj_desc boolean DEFAULT false,
    tax_surf_tot_cstr boolean DEFAULT false,
    tax_surf_loc_stat boolean DEFAULT false,
    tax_log_ap_trvx_nb boolean DEFAULT false,
    tax_am_statio_ext_cr boolean DEFAULT false,
    tax_sup_bass_pisc_cr boolean DEFAULT false,
    tax_empl_ten_carav_mobil_nb_cr boolean DEFAULT false,
    tax_empl_hll_nb_cr boolean DEFAULT false,
    tax_eol_haut_nb_cr boolean DEFAULT false,
    tax_pann_volt_sup_cr boolean DEFAULT false,
    tax_surf_loc_arch boolean DEFAULT false,
    tax_surf_pisc_arch boolean DEFAULT false,
    tax_am_statio_ext_arch boolean DEFAULT false,
    tab_tax_su_parc_statio_expl_comm integer,
    tax_empl_ten_carav_mobil_nb_arch boolean DEFAULT false,
    tax_empl_hll_nb_arch boolean DEFAULT false,
    tax_eol_haut_nb_arch boolean DEFAULT false,
    ope_proj_div_co boolean DEFAULT false,
    ope_proj_div_contr boolean DEFAULT false,
    tax_desc boolean DEFAULT false,
    erp_cstr_neuve boolean DEFAULT false,
    erp_trvx_acc boolean DEFAULT false,
    erp_extension boolean DEFAULT false,
    erp_rehab boolean DEFAULT false,
    erp_trvx_am boolean DEFAULT false,
    erp_vol_nouv_exist boolean DEFAULT false,
    tab_erp_eff integer,
    erp_class_cat boolean DEFAULT false,
    erp_class_type boolean DEFAULT false,
    tax_surf_abr_jard_pig_colom boolean DEFAULT false,
    tax_su_non_habit_abr_jard_pig_colom boolean DEFAULT false,
    dia_imm_non_bati boolean DEFAULT false,
    dia_imm_bati_terr_propr boolean DEFAULT false,
    dia_imm_bati_terr_autr boolean DEFAULT false,
    dia_imm_bati_terr_autr_desc boolean DEFAULT false,
    dia_bat_copro boolean DEFAULT false,
    dia_bat_copro_desc boolean DEFAULT false,
    dia_lot_numero boolean DEFAULT false,
    dia_lot_bat boolean DEFAULT false,
    dia_lot_etage boolean DEFAULT false,
    dia_lot_quote_part boolean DEFAULT false,
    dia_us_hab boolean DEFAULT false,
    dia_us_pro boolean DEFAULT false,
    dia_us_mixte boolean DEFAULT false,
    dia_us_comm boolean DEFAULT false,
    dia_us_agr boolean DEFAULT false,
    dia_us_autre boolean DEFAULT false,
    dia_us_autre_prec boolean DEFAULT false,
    dia_occ_prop boolean DEFAULT false,
    dia_occ_loc boolean DEFAULT false,
    dia_occ_sans_occ boolean DEFAULT false,
    dia_occ_autre boolean DEFAULT false,
    dia_occ_autre_prec boolean DEFAULT false,
    dia_mod_cess_prix_vente boolean DEFAULT false,
    dia_mod_cess_prix_vente_mob boolean DEFAULT false,
    dia_mod_cess_prix_vente_cheptel boolean DEFAULT false,
    dia_mod_cess_prix_vente_recol boolean DEFAULT false,
    dia_mod_cess_prix_vente_autre boolean DEFAULT false,
    dia_mod_cess_commi boolean DEFAULT false,
    dia_mod_cess_commi_ttc boolean DEFAULT false,
    dia_mod_cess_commi_ht boolean DEFAULT false,
    dia_acquereur_nom_prenom boolean DEFAULT false,
    dia_acquereur_adr_num_voie boolean DEFAULT false,
    dia_acquereur_adr_ext boolean DEFAULT false,
    dia_acquereur_adr_type_voie boolean DEFAULT false,
    dia_acquereur_adr_nom_voie boolean DEFAULT false,
    dia_acquereur_adr_lieu_dit_bp boolean DEFAULT false,
    dia_acquereur_adr_cp boolean DEFAULT false,
    dia_acquereur_adr_localite boolean DEFAULT false,
    dia_observation boolean DEFAULT false,
    tab_surface2 integer,
    dia_occ_sol_su_terre boolean DEFAULT false,
    dia_occ_sol_su_pres boolean DEFAULT false,
    dia_occ_sol_su_verger boolean DEFAULT false,
    dia_occ_sol_su_vigne boolean DEFAULT false,
    dia_occ_sol_su_bois boolean DEFAULT false,
    dia_occ_sol_su_lande boolean DEFAULT false,
    dia_occ_sol_su_carriere boolean DEFAULT false,
    dia_occ_sol_su_eau_cadastree boolean DEFAULT false,
    dia_occ_sol_su_jardin boolean DEFAULT false,
    dia_occ_sol_su_terr_batir boolean DEFAULT false,
    dia_occ_sol_su_terr_agr boolean DEFAULT false,
    dia_occ_sol_su_sol boolean DEFAULT false,
    dia_bati_vend_tot boolean DEFAULT false,
    dia_bati_vend_tot_txt boolean DEFAULT false,
    dia_su_co_sol boolean DEFAULT false,
    dia_su_util_hab boolean DEFAULT false,
    dia_nb_niv boolean DEFAULT false,
    dia_nb_appart boolean DEFAULT false,
    dia_nb_autre_loc boolean DEFAULT false,
    dia_vente_lot_volume boolean DEFAULT false,
    dia_vente_lot_volume_txt boolean DEFAULT false,
    dia_lot_nat_su boolean DEFAULT false,
    dia_lot_bat_achv_plus_10 boolean DEFAULT false,
    dia_lot_bat_achv_moins_10 boolean DEFAULT false,
    dia_lot_regl_copro_publ_hypo_plus_10 boolean DEFAULT false,
    dia_lot_regl_copro_publ_hypo_moins_10 boolean DEFAULT false,
    dia_indivi_quote_part boolean DEFAULT false,
    dia_design_societe boolean DEFAULT false,
    dia_design_droit boolean DEFAULT false,
    dia_droit_soc_nat boolean DEFAULT false,
    dia_droit_soc_nb boolean DEFAULT false,
    dia_droit_soc_num_part boolean DEFAULT false,
    dia_droit_reel_perso_grevant_bien_oui boolean DEFAULT false,
    dia_droit_reel_perso_grevant_bien_non boolean DEFAULT false,
    dia_droit_reel_perso_nat boolean DEFAULT false,
    dia_droit_reel_perso_viag boolean DEFAULT false,
    dia_mod_cess_adr boolean DEFAULT false,
    dia_mod_cess_sign_act_auth boolean DEFAULT false,
    dia_mod_cess_terme boolean DEFAULT false,
    dia_mod_cess_terme_prec boolean DEFAULT false,
    dia_mod_cess_bene_acquereur boolean DEFAULT false,
    dia_mod_cess_bene_vendeur boolean DEFAULT false,
    dia_mod_cess_paie_nat boolean DEFAULT false,
    dia_mod_cess_design_contr_alien boolean DEFAULT false,
    dia_mod_cess_eval_contr boolean DEFAULT false,
    dia_mod_cess_rente_viag boolean DEFAULT false,
    dia_mod_cess_mnt_an boolean DEFAULT false,
    dia_mod_cess_mnt_compt boolean DEFAULT false,
    dia_mod_cess_bene_rente boolean DEFAULT false,
    dia_mod_cess_droit_usa_hab boolean DEFAULT false,
    dia_mod_cess_droit_usa_hab_prec boolean DEFAULT false,
    dia_mod_cess_eval_usa_usufruit boolean DEFAULT false,
    dia_mod_cess_vente_nue_prop boolean DEFAULT false,
    dia_mod_cess_vente_nue_prop_prec boolean DEFAULT false,
    dia_mod_cess_echange boolean DEFAULT false,
    dia_mod_cess_design_bien_recus_ech boolean DEFAULT false,
    dia_mod_cess_mnt_soulte boolean DEFAULT false,
    dia_mod_cess_prop_contre_echan boolean DEFAULT false,
    dia_mod_cess_apport_societe boolean DEFAULT false,
    dia_mod_cess_bene boolean DEFAULT false,
    dia_mod_cess_esti_bien boolean DEFAULT false,
    dia_mod_cess_cess_terr_loc_co boolean DEFAULT false,
    dia_mod_cess_esti_terr boolean DEFAULT false,
    dia_mod_cess_esti_loc boolean DEFAULT false,
    dia_mod_cess_esti_imm_loca boolean DEFAULT false,
    dia_mod_cess_adju_vol boolean DEFAULT false,
    dia_mod_cess_adju_obl boolean DEFAULT false,
    dia_mod_cess_adju_fin_indivi boolean DEFAULT false,
    dia_mod_cess_adju_date_lieu boolean DEFAULT false,
    dia_mod_cess_mnt_mise_prix boolean DEFAULT false,
    dia_prop_titu_prix_indique boolean DEFAULT false,
    dia_prop_recherche_acqu_prix_indique boolean DEFAULT false,
    dia_acquereur_prof boolean DEFAULT false,
    dia_indic_compl_ope boolean DEFAULT false,
    dia_vente_adju boolean DEFAULT false,
    am_terr_res_demon boolean DEFAULT false,
    am_air_terr_res_mob boolean DEFAULT false,
    ctx_objet_recours boolean DEFAULT false,
    ctx_moyen_souleve boolean DEFAULT false,
    ctx_moyen_retenu_juge boolean DEFAULT false,
    ctx_reference_sagace boolean DEFAULT false,
    ctx_nature_travaux_infra_om_html boolean DEFAULT false,
    ctx_synthese_nti boolean DEFAULT false,
    ctx_article_non_resp_om_html boolean DEFAULT false,
    ctx_synthese_anr boolean DEFAULT false,
    ctx_reference_parquet boolean DEFAULT false,
    ctx_element_taxation boolean DEFAULT false,
    ctx_infraction boolean DEFAULT false,
    ctx_regularisable boolean DEFAULT false,
    ctx_reference_courrier boolean DEFAULT false,
    ctx_date_audience boolean DEFAULT false,
    ctx_date_ajournement boolean DEFAULT false,
    exo_facul_1 boolean DEFAULT false,
    exo_facul_2 boolean DEFAULT false,
    exo_facul_3 boolean DEFAULT false,
    exo_facul_4 boolean DEFAULT false,
    exo_facul_5 boolean DEFAULT false,
    exo_facul_6 boolean DEFAULT false,
    exo_facul_7 boolean DEFAULT false,
    exo_facul_8 boolean DEFAULT false,
    exo_facul_9 boolean DEFAULT false,
    exo_ta_1 boolean DEFAULT false,
    exo_ta_2 boolean DEFAULT false,
    exo_ta_3 boolean DEFAULT false,
    exo_ta_4 boolean DEFAULT false,
    exo_ta_5 boolean DEFAULT false,
    exo_ta_6 boolean DEFAULT false,
    exo_ta_7 boolean DEFAULT false,
    exo_ta_8 boolean DEFAULT false,
    exo_ta_9 boolean DEFAULT false,
    exo_rap_1 boolean DEFAULT false,
    exo_rap_2 boolean DEFAULT false,
    exo_rap_3 boolean DEFAULT false,
    exo_rap_4 boolean DEFAULT false,
    exo_rap_5 boolean DEFAULT false,
    exo_rap_6 boolean DEFAULT false,
    exo_rap_7 boolean DEFAULT false,
    exo_rap_8 boolean DEFAULT false,
    mtn_exo_ta_part_commu boolean DEFAULT false,
    mtn_exo_ta_part_depart boolean DEFAULT false,
    mtn_exo_ta_part_reg boolean DEFAULT false,
    mtn_exo_rap boolean DEFAULT false,
    dpc_type boolean DEFAULT false,
    dpc_desc_actv_ex boolean DEFAULT false,
    dpc_desc_ca boolean DEFAULT false,
    dpc_desc_aut_prec boolean DEFAULT false,
    dpc_desig_comm_arti boolean DEFAULT false,
    dpc_desig_loc_hab boolean DEFAULT false,
    dpc_desig_loc_ann boolean DEFAULT false,
    dpc_desig_loc_ann_prec boolean DEFAULT false,
    dpc_bail_comm_date boolean DEFAULT false,
    dpc_bail_comm_loyer boolean DEFAULT false,
    dpc_actv_acqu boolean DEFAULT false,
    dpc_nb_sala_di boolean DEFAULT false,
    dpc_nb_sala_dd boolean DEFAULT false,
    dpc_nb_sala_tc boolean DEFAULT false,
    dpc_nb_sala_tp boolean DEFAULT false,
    dpc_moda_cess_vente_am boolean DEFAULT false,
    dpc_moda_cess_adj boolean DEFAULT false,
    dpc_moda_cess_prix boolean DEFAULT false,
    dpc_moda_cess_adj_date boolean DEFAULT false,
    dpc_moda_cess_adj_prec boolean DEFAULT false,
    dpc_moda_cess_paie_comp boolean DEFAULT false,
    dpc_moda_cess_paie_terme boolean DEFAULT false,
    dpc_moda_cess_paie_terme_prec boolean DEFAULT false,
    dpc_moda_cess_paie_nat boolean DEFAULT false,
    dpc_moda_cess_paie_nat_desig_alien boolean DEFAULT false,
    dpc_moda_cess_paie_nat_desig_alien_prec boolean DEFAULT false,
    dpc_moda_cess_paie_nat_eval boolean DEFAULT false,
    dpc_moda_cess_paie_nat_eval_prec boolean DEFAULT false,
    dpc_moda_cess_paie_aut boolean DEFAULT false,
    dpc_moda_cess_paie_aut_prec boolean DEFAULT false,
    dpc_ss_signe_demande_acqu boolean DEFAULT false,
    dpc_ss_signe_recher_trouv_acqu boolean DEFAULT false,
    dpc_notif_adr_prop boolean DEFAULT false,
    dpc_notif_adr_manda boolean DEFAULT false,
    dpc_obs boolean DEFAULT false,
    co_peri_site_patri_remar boolean DEFAULT false,
    co_abo_monu_hist boolean DEFAULT false,
    co_inst_ouvr_trav_act_code_envir boolean DEFAULT false,
    co_trav_auto_env boolean DEFAULT false,
    co_derog_esp_prot boolean DEFAULT false,
    ctx_reference_dsj boolean DEFAULT false NOT NULL,
    co_piscine boolean DEFAULT false,
    co_fin_lls boolean DEFAULT false,
    co_fin_aa boolean DEFAULT false,
    co_fin_ptz boolean DEFAULT false,
    co_fin_autr boolean DEFAULT false,
    dia_ss_date boolean DEFAULT false,
    dia_ss_lieu boolean DEFAULT false,
    enga_decla_lieu boolean DEFAULT false,
    enga_decla_date boolean DEFAULT false,
    co_archi_attest_honneur boolean DEFAULT false,
    co_bat_niv_dessous_nb boolean DEFAULT false,
    co_install_classe boolean DEFAULT false,
    co_derog_innov boolean DEFAULT false,
    co_avis_abf boolean DEFAULT false,
    tax_surf_tot_demo boolean DEFAULT false,
    tax_surf_tax_demo boolean DEFAULT false,
    tax_terrassement_arch boolean DEFAULT false,
    tax_adresse_future_numero boolean DEFAULT false,
    tax_adresse_future_voie boolean DEFAULT false,
    tax_adresse_future_lieudit boolean DEFAULT false,
    tax_adresse_future_localite boolean DEFAULT false,
    tax_adresse_future_cp boolean DEFAULT false,
    tax_adresse_future_bp boolean DEFAULT false,
    tax_adresse_future_cedex boolean DEFAULT false,
    tax_adresse_future_pays boolean DEFAULT false,
    tax_adresse_future_division boolean DEFAULT false,
    co_bat_projete boolean DEFAULT false,
    co_bat_existant boolean DEFAULT false,
    co_bat_nature boolean DEFAULT false,
    terr_juri_titul_date boolean DEFAULT false,
    co_autre_desc boolean DEFAULT false,
    co_trx_autre boolean DEFAULT false,
    co_autre boolean DEFAULT false,
    erp_modif_facades boolean DEFAULT false,
    erp_trvx_adap boolean DEFAULT false,
    erp_trvx_adap_numero boolean DEFAULT false,
    erp_trvx_adap_valid boolean DEFAULT false,
    erp_prod_dangereux boolean DEFAULT false,
    co_trav_supp_dessus boolean DEFAULT false,
    co_trav_supp_dessous boolean DEFAULT false,
    tax_su_habit_abr_jard_pig_colom boolean DEFAULT false,
    enga_decla_donnees_nomi_comm boolean DEFAULT false,
    x1l_legislation boolean DEFAULT false,
    x1p_precisions boolean DEFAULT false,
    x1u_raccordement boolean DEFAULT false,
    x2m_inscritmh boolean DEFAULT false,
    s1na1_numero boolean DEFAULT false,
    s1va1_voie boolean DEFAULT false,
    s1wa1_lieudit boolean DEFAULT false,
    s1la1_localite boolean DEFAULT false,
    s1pa1_codepostal boolean DEFAULT false,
    s1na2_numero boolean DEFAULT false,
    s1va2_voie boolean DEFAULT false,
    s1wa2_lieudit boolean DEFAULT false,
    s1la2_localite boolean DEFAULT false,
    s1pa2_codepostal boolean DEFAULT false,
    e3c_certification boolean DEFAULT false,
    e3a_competence boolean DEFAULT false,
    a4d_description boolean DEFAULT false,
    m2b_abf boolean DEFAULT false,
    m2j_pn boolean DEFAULT false,
    m2r_cdac boolean DEFAULT false,
    m2r_cnac boolean DEFAULT false,
    u3a_voirieoui boolean DEFAULT false,
    u3f_voirienon boolean DEFAULT false,
    u3c_eauoui boolean DEFAULT false,
    u3h_eaunon boolean DEFAULT false,
    u3g_assainissementoui boolean DEFAULT false,
    u3n_assainissementnon boolean DEFAULT false,
    u3m_electriciteoui boolean DEFAULT false,
    u3b_electricitenon boolean DEFAULT false,
    u3t_observations boolean DEFAULT false,
    u1a_voirieoui boolean DEFAULT false,
    u1v_voirienon boolean DEFAULT false,
    u1q_voirieconcessionnaire boolean DEFAULT false,
    u1b_voirieavant boolean DEFAULT false,
    u1j_eauoui boolean DEFAULT false,
    u1t_eaunon boolean DEFAULT false,
    u1e_eauconcessionnaire boolean DEFAULT false,
    u1k_eauavant boolean DEFAULT false,
    u1s_assainissementoui boolean DEFAULT false,
    u1d_assainissementnon boolean DEFAULT false,
    u1l_assainissementconcessionnaire boolean DEFAULT false,
    u1r_assainissementavant boolean DEFAULT false,
    u1c_electriciteoui boolean DEFAULT false,
    u1u_electricitenon boolean DEFAULT false,
    u1m_electriciteconcessionnaire boolean DEFAULT false,
    u1f_electriciteavant boolean DEFAULT false,
    u2a_observations boolean DEFAULT false,
    f1ts4_surftaxestation boolean DEFAULT false,
    f1ut1_surfcree boolean DEFAULT false,
    f9d_date boolean DEFAULT false,
    f9n_nom boolean DEFAULT false,
    dia_droit_reel_perso_grevant_bien_desc boolean DEFAULT false,
    dia_mod_cess_paie_nat_desc boolean DEFAULT false,
    dia_mod_cess_rente_viag_desc boolean DEFAULT false,
    dia_mod_cess_echange_desc boolean DEFAULT false,
    dia_mod_cess_apport_societe_desc boolean DEFAULT false,
    dia_mod_cess_cess_terr_loc_co_desc boolean DEFAULT false,
    dia_mod_cess_esti_imm_loca_desc boolean DEFAULT false,
    dia_mod_cess_adju_obl_desc boolean DEFAULT false,
    dia_mod_cess_adju_fin_indivi_desc boolean DEFAULT false,
    dia_cadre_titul_droit_prempt boolean DEFAULT false,
    dia_mairie_prix_moyen boolean DEFAULT false,
    dia_propri_indivi boolean DEFAULT false,
    dia_situa_bien_plan_cadas_oui boolean DEFAULT false,
    dia_situa_bien_plan_cadas_non boolean DEFAULT false,
    dia_notif_dec_titul_adr_prop boolean DEFAULT false,
    dia_notif_dec_titul_adr_prop_desc boolean DEFAULT false,
    dia_notif_dec_titul_adr_manda boolean DEFAULT false,
    dia_notif_dec_titul_adr_manda_desc boolean DEFAULT false,
    dia_dia_dpu boolean DEFAULT false,
    dia_dia_zad boolean DEFAULT false,
    dia_dia_zone_preempt_esp_natu_sensi boolean DEFAULT false,
    dia_dab_dpu boolean DEFAULT false,
    dia_dab_zad boolean DEFAULT false,
    dia_mod_cess_commi_mnt boolean DEFAULT false,
    dia_mod_cess_commi_mnt_ttc boolean DEFAULT false,
    dia_mod_cess_commi_mnt_ht boolean DEFAULT false,
    dia_mod_cess_prix_vente_num boolean DEFAULT false,
    dia_mod_cess_prix_vente_mob_num boolean DEFAULT false,
    dia_mod_cess_prix_vente_cheptel_num boolean DEFAULT false,
    dia_mod_cess_prix_vente_recol_num boolean DEFAULT false,
    dia_mod_cess_prix_vente_autre_num boolean DEFAULT false,
    dia_su_co_sol_num boolean DEFAULT false,
    dia_su_util_hab_num boolean DEFAULT false,
    dia_mod_cess_mnt_an_num boolean DEFAULT false,
    dia_mod_cess_mnt_compt_num boolean DEFAULT false,
    dia_mod_cess_mnt_soulte_num boolean DEFAULT false,
    dia_comp_prix_vente boolean DEFAULT false,
    dia_comp_surface boolean DEFAULT false,
    dia_comp_total_frais boolean DEFAULT false,
    dia_comp_mtn_total boolean DEFAULT false,
    dia_comp_valeur_m2 boolean DEFAULT false,
    dia_esti_prix_france_dom boolean DEFAULT false,
    dia_prop_collectivite boolean DEFAULT false,
    dia_delegataire_denomination boolean DEFAULT false,
    dia_delegataire_raison_sociale boolean DEFAULT false,
    dia_delegataire_siret boolean DEFAULT false,
    dia_delegataire_categorie_juridique boolean DEFAULT false,
    dia_delegataire_representant_nom boolean DEFAULT false,
    dia_delegataire_representant_prenom boolean DEFAULT false,
    dia_delegataire_adresse_numero boolean DEFAULT false,
    dia_delegataire_adresse_voie boolean DEFAULT false,
    dia_delegataire_adresse_complement boolean DEFAULT false,
    dia_delegataire_adresse_lieu_dit boolean DEFAULT false,
    dia_delegataire_adresse_localite boolean DEFAULT false,
    dia_delegataire_adresse_code_postal boolean DEFAULT false,
    dia_delegataire_adresse_bp boolean DEFAULT false,
    dia_delegataire_adresse_cedex boolean DEFAULT false,
    dia_delegataire_adresse_pays boolean DEFAULT false,
    dia_delegataire_telephone_fixe boolean DEFAULT false,
    dia_delegataire_telephone_mobile boolean DEFAULT false,
    dia_delegataire_telephone_mobile_indicatif boolean DEFAULT false,
    dia_delegataire_courriel boolean DEFAULT false,
    dia_delegataire_fax boolean DEFAULT false,
    dia_entree_jouissance_type boolean DEFAULT false,
    dia_entree_jouissance_date boolean DEFAULT false,
    dia_entree_jouissance_date_effet boolean DEFAULT false,
    dia_entree_jouissance_com boolean DEFAULT false,
    dia_remise_bien_date_effet boolean DEFAULT false,
    dia_remise_bien_com boolean DEFAULT false,
    c2zp1_crete boolean DEFAULT false,
    c2zr1_destination boolean DEFAULT false,
    mh_design_appel_denom boolean DEFAULT false,
    mh_design_type_protect boolean DEFAULT false,
    mh_design_elem_prot boolean DEFAULT false,
    mh_design_ref_merimee_palissy boolean DEFAULT false,
    mh_design_nature_prop boolean DEFAULT false,
    mh_loc_denom boolean DEFAULT false,
    mh_pres_intitule boolean DEFAULT false,
    mh_trav_cat_1 boolean DEFAULT false,
    mh_trav_cat_2 boolean DEFAULT false,
    mh_trav_cat_3 boolean DEFAULT false,
    mh_trav_cat_4 boolean DEFAULT false,
    mh_trav_cat_5 boolean DEFAULT false,
    mh_trav_cat_6 boolean DEFAULT false,
    mh_trav_cat_7 boolean DEFAULT false,
    mh_trav_cat_8 boolean DEFAULT false,
    mh_trav_cat_9 boolean DEFAULT false,
    mh_trav_cat_10 boolean DEFAULT false,
    mh_trav_cat_11 boolean DEFAULT false,
    mh_trav_cat_12 boolean DEFAULT false,
    mh_trav_cat_12_prec boolean DEFAULT false
);


--
-- Name: TABLE cerfa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE cerfa IS 'Configuration de l''affichage des formulaires CERFA';


--
-- Name: COLUMN cerfa.cerfa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.cerfa IS 'Identifiant unique';


--
-- Name: COLUMN cerfa.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.libelle IS 'Libellé du formulaire CERFA';


--
-- Name: COLUMN cerfa.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.code IS 'Code du formulaire CERFA';


--
-- Name: COLUMN cerfa.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.om_validite_debut IS 'Début de validité du formulaire CERFA';


--
-- Name: COLUMN cerfa.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.om_validite_fin IS 'Fin de validité du formulaire CERFA';


--
-- Name: COLUMN cerfa.am_lotiss; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lotiss IS 'Va afficher le champ am_lotiss';


--
-- Name: COLUMN cerfa.am_autre_div; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_autre_div IS 'Va afficher le champ am_autre_div';


--
-- Name: COLUMN cerfa.am_camping; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_camping IS 'Va afficher le champ am_camping';


--
-- Name: COLUMN cerfa.am_caravane; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_caravane IS 'Va afficher le champ am_caravane';


--
-- Name: COLUMN cerfa.am_carav_duree; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_carav_duree IS 'Va afficher le champ am_carav_duree';


--
-- Name: COLUMN cerfa.am_statio; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_statio IS 'Va afficher le champ am_statio';


--
-- Name: COLUMN cerfa.am_statio_cont; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_statio_cont IS 'Va afficher le champ am_statio_cont';


--
-- Name: COLUMN cerfa.am_affou_exhau; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_affou_exhau IS 'Va afficher le champ am_affou_exhau';


--
-- Name: COLUMN cerfa.am_affou_exhau_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_affou_exhau_sup IS 'Va afficher le champ am_affou_exhau_sup';


--
-- Name: COLUMN cerfa.am_affou_prof; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_affou_prof IS 'Va afficher le champ am_affou_prof';


--
-- Name: COLUMN cerfa.am_exhau_haut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_exhau_haut IS 'Va afficher le champ am_exhau_haut';


--
-- Name: COLUMN cerfa.am_coupe_abat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_abat IS 'Va afficher le champ am_coupe_abat';


--
-- Name: COLUMN cerfa.am_prot_plu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_prot_plu IS 'Va afficher le champ am_prot_plu';


--
-- Name: COLUMN cerfa.am_prot_muni; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_prot_muni IS 'Va afficher le champ am_prot_muni';


--
-- Name: COLUMN cerfa.am_mobil_voyage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_mobil_voyage IS 'Va afficher le champ am_mobil_voyage';


--
-- Name: COLUMN cerfa.am_aire_voyage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_aire_voyage IS 'Va afficher le champ am_aire_voyage';


--
-- Name: COLUMN cerfa.am_rememb_afu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_rememb_afu IS 'Travaux ayant pour effet de modifier l''aménagement des espaces non bâtis autour d''un bâtiment existant situé dans le périmètre d''un site patrimonial remarquable ou abords d''un monument historique';


--
-- Name: COLUMN cerfa.am_parc_resid_loi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_parc_resid_loi IS 'Va afficher le champ am_parc_resid_loi';


--
-- Name: COLUMN cerfa.am_sport_moto; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_sport_moto IS 'Va afficher le champ am_sport_moto';


--
-- Name: COLUMN cerfa.am_sport_attrac; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_sport_attrac IS 'Va afficher le champ am_sport_attrac';


--
-- Name: COLUMN cerfa.am_sport_golf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_sport_golf IS 'Va afficher le champ am_sport_golf';


--
-- Name: COLUMN cerfa.am_mob_art; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_mob_art IS 'Va afficher le champ am_mob_art';


--
-- Name: COLUMN cerfa.am_modif_voie_esp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_modif_voie_esp IS 'Va afficher le champ am_modif_voie_esp';


--
-- Name: COLUMN cerfa.am_plant_voie_esp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_plant_voie_esp IS 'Va afficher le champ am_plant_voie_esp';


--
-- Name: COLUMN cerfa.am_chem_ouv_esp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_chem_ouv_esp IS 'Va afficher le champ am_chem_ouv_esp';


--
-- Name: COLUMN cerfa.am_agri_peche; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_agri_peche IS 'Va afficher le champ am_agri_peche';


--
-- Name: COLUMN cerfa.am_crea_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_crea_voie IS 'Va afficher le champ am_crea_voie';


--
-- Name: COLUMN cerfa.am_modif_voie_exist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_modif_voie_exist IS 'Va afficher le champ am_modif_voie_exist';


--
-- Name: COLUMN cerfa.am_crea_esp_sauv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_crea_esp_sauv IS 'Va afficher le champ am_crea_esp_sauv';


--
-- Name: COLUMN cerfa.am_crea_esp_class; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_crea_esp_class IS 'Va afficher le champ am_crea_esp_class';


--
-- Name: COLUMN cerfa.am_projet_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_projet_desc IS 'Va afficher le champ am_projet_desc';


--
-- Name: COLUMN cerfa.am_terr_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_terr_surf IS 'Va afficher le champ am_terr_surf';


--
-- Name: COLUMN cerfa.am_tranche_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_tranche_desc IS 'Va afficher le champ am_tranche_desc';


--
-- Name: COLUMN cerfa.am_lot_max_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_max_nb IS 'Va afficher le champ am_lot_max_nb';


--
-- Name: COLUMN cerfa.am_lot_max_shon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_max_shon IS 'Va afficher le champ am_lot_max_shon';


--
-- Name: COLUMN cerfa.am_lot_cstr_cos; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_cstr_cos IS 'Va afficher le champ am_lot_cstr_cos';


--
-- Name: COLUMN cerfa.am_lot_cstr_plan; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_cstr_plan IS 'Va afficher le champ am_lot_cstr_plan';


--
-- Name: COLUMN cerfa.am_lot_cstr_vente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_cstr_vente IS 'Va afficher le champ am_lot_cstr_vente';


--
-- Name: COLUMN cerfa.am_lot_fin_diff; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_fin_diff IS 'Va afficher le champ am_lot_fin_diff';


--
-- Name: COLUMN cerfa.am_lot_consign; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_consign IS 'Va afficher le champ am_lot_consign';


--
-- Name: COLUMN cerfa.am_lot_gar_achev; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_gar_achev IS 'Va afficher le champ am_lot_gar_achev';


--
-- Name: COLUMN cerfa.am_lot_vente_ant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_vente_ant IS 'Va afficher le champ am_lot_vente_ant';


--
-- Name: COLUMN cerfa.am_empl_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_empl_nb IS 'Va afficher le champ am_empl_nb';


--
-- Name: COLUMN cerfa.am_tente_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_tente_nb IS 'Va afficher le champ am_tente_nb';


--
-- Name: COLUMN cerfa.am_carav_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_carav_nb IS 'Va afficher le champ am_carav_nb';


--
-- Name: COLUMN cerfa.am_mobil_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_mobil_nb IS 'Va afficher le champ am_mobil_nb';


--
-- Name: COLUMN cerfa.am_pers_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_pers_nb IS 'Va afficher le champ am_pers_nb';


--
-- Name: COLUMN cerfa.am_empl_hll_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_empl_hll_nb IS 'Va afficher le champ am_empl_hll_nb';


--
-- Name: COLUMN cerfa.am_hll_shon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_hll_shon IS 'Va afficher le champ am_hll_shon';


--
-- Name: COLUMN cerfa.am_periode_exploit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_periode_exploit IS 'Va afficher le champ am_periode_exploit';


--
-- Name: COLUMN cerfa.am_exist_agrand; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_exist_agrand IS 'Va afficher le champ am_exist_agrand';


--
-- Name: COLUMN cerfa.am_exist_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_exist_date IS 'Va afficher le champ am_exist_date';


--
-- Name: COLUMN cerfa.am_exist_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_exist_num IS 'Va afficher le champ am_exist_num';


--
-- Name: COLUMN cerfa.am_exist_nb_avant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_exist_nb_avant IS 'Va afficher le champ am_exist_nb_avant';


--
-- Name: COLUMN cerfa.am_exist_nb_apres; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_exist_nb_apres IS 'Va afficher le champ am_exist_nb_apres';


--
-- Name: COLUMN cerfa.am_coupe_bois; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_bois IS 'Va afficher le champ am_coupe_bois';


--
-- Name: COLUMN cerfa.am_coupe_parc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_parc IS 'Va afficher le champ am_coupe_parc';


--
-- Name: COLUMN cerfa.am_coupe_align; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_align IS 'Va afficher le champ am_coupe_align';


--
-- Name: COLUMN cerfa.am_coupe_ess; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_ess IS 'Va afficher le champ am_coupe_ess';


--
-- Name: COLUMN cerfa.am_coupe_age; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_age IS 'Va afficher le champ am_coupe_age';


--
-- Name: COLUMN cerfa.am_coupe_dens; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_dens IS 'Va afficher le champ am_coupe_dens';


--
-- Name: COLUMN cerfa.am_coupe_qual; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_qual IS 'Va afficher le champ am_coupe_qual';


--
-- Name: COLUMN cerfa.am_coupe_trait; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_trait IS 'Va afficher le champ am_coupe_trait';


--
-- Name: COLUMN cerfa.am_coupe_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_coupe_autr IS 'Va afficher le champ am_coupe_autr';


--
-- Name: COLUMN cerfa.co_archi_recours; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_archi_recours IS 'Va afficher le champ co_archi_recours';


--
-- Name: COLUMN cerfa.co_cstr_nouv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_cstr_nouv IS 'Va afficher le champ co_cstr_nouv';


--
-- Name: COLUMN cerfa.co_cstr_exist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_cstr_exist IS 'Va afficher le champ co_cstr_exist';


--
-- Name: COLUMN cerfa.co_cloture; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_cloture IS 'Va afficher le champ co_cloture';


--
-- Name: COLUMN cerfa.co_elec_tension; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_elec_tension IS 'Va afficher le champ co_elec_tension';


--
-- Name: COLUMN cerfa.co_div_terr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_div_terr IS 'Va afficher le champ co_div_terr';


--
-- Name: COLUMN cerfa.co_projet_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_projet_desc IS 'Va afficher le champ co_projet_desc';


--
-- Name: COLUMN cerfa.co_anx_pisc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_anx_pisc IS 'Va afficher le champ co_anx_pisc';


--
-- Name: COLUMN cerfa.co_anx_gara; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_anx_gara IS 'Va afficher le champ co_anx_gara';


--
-- Name: COLUMN cerfa.co_anx_veran; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_anx_veran IS 'Va afficher le champ co_anx_veran';


--
-- Name: COLUMN cerfa.co_anx_abri; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_anx_abri IS 'Va afficher le champ co_anx_abri';


--
-- Name: COLUMN cerfa.co_anx_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_anx_autr IS 'Va afficher le champ co_anx_autr';


--
-- Name: COLUMN cerfa.co_anx_autr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_anx_autr_desc IS 'Va afficher le champ co_anx_autr_desc';


--
-- Name: COLUMN cerfa.co_tot_log_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_tot_log_nb IS 'Va afficher le champ co_tot_log_nb';


--
-- Name: COLUMN cerfa.co_tot_ind_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_tot_ind_nb IS 'Va afficher le champ co_tot_ind_nb';


--
-- Name: COLUMN cerfa.co_tot_coll_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_tot_coll_nb IS 'Va afficher le champ co_tot_coll_nb';


--
-- Name: COLUMN cerfa.co_mais_piece_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_mais_piece_nb IS 'Va afficher le champ co_mais_piece_nb';


--
-- Name: COLUMN cerfa.co_mais_niv_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_mais_niv_nb IS 'Va afficher le champ co_mais_niv_nb';


--
-- Name: COLUMN cerfa.co_fin_lls_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_fin_lls_nb IS 'Va afficher le champ co_fin_lls_nb';


--
-- Name: COLUMN cerfa.co_fin_aa_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_fin_aa_nb IS 'Va afficher le champ co_fin_aa_nb';


--
-- Name: COLUMN cerfa.co_fin_ptz_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_fin_ptz_nb IS 'Va afficher le champ co_fin_ptz_nb';


--
-- Name: COLUMN cerfa.co_fin_autr_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_fin_autr_nb IS 'Répartition du nombre total de logement créés par type de financement : Autres financements [SUPPRIMÉ]';


--
-- Name: COLUMN cerfa.co_fin_autr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_fin_autr_desc IS 'Va afficher le champ co_fin_autr_desc';


--
-- Name: COLUMN cerfa.co_mais_contrat_ind; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_mais_contrat_ind IS 'Va afficher le champ co_mais_contrat_ind';


--
-- Name: COLUMN cerfa.co_uti_pers; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_uti_pers IS 'Va afficher le champ co_uti_pers';


--
-- Name: COLUMN cerfa.co_uti_vente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_uti_vente IS 'Va afficher le champ co_uti_vente';


--
-- Name: COLUMN cerfa.co_uti_loc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_uti_loc IS 'Va afficher le champ co_uti_loc';


--
-- Name: COLUMN cerfa.co_uti_princ; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_uti_princ IS 'Va afficher le champ co_uti_princ';


--
-- Name: COLUMN cerfa.co_uti_secon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_uti_secon IS 'Va afficher le champ co_uti_secon';


--
-- Name: COLUMN cerfa.co_resid_agees; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_resid_agees IS 'Va afficher le champ co_resid_agees';


--
-- Name: COLUMN cerfa.co_resid_etud; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_resid_etud IS 'Va afficher le champ co_resid_etud';


--
-- Name: COLUMN cerfa.co_resid_tourism; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_resid_tourism IS 'Va afficher le champ co_resid_tourism';


--
-- Name: COLUMN cerfa.co_resid_hot_soc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_resid_hot_soc IS 'Va afficher le champ co_resid_hot_soc';


--
-- Name: COLUMN cerfa.co_resid_soc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_resid_soc IS 'Va afficher le champ co_resid_soc';


--
-- Name: COLUMN cerfa.co_resid_hand; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_resid_hand IS 'Va afficher le champ co_resid_hand';


--
-- Name: COLUMN cerfa.co_resid_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_resid_autr IS 'Va afficher le champ co_resid_autr';


--
-- Name: COLUMN cerfa.co_resid_autr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_resid_autr_desc IS 'Va afficher le champ co_resid_autr_desc';


--
-- Name: COLUMN cerfa.co_foyer_chamb_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_foyer_chamb_nb IS 'Va afficher le champ co_foyer_chamb_nb';


--
-- Name: COLUMN cerfa.co_log_1p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_log_1p_nb IS 'Va afficher le champ co_log_1p_nb';


--
-- Name: COLUMN cerfa.co_log_2p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_log_2p_nb IS 'Va afficher le champ co_log_2p_nb';


--
-- Name: COLUMN cerfa.co_log_3p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_log_3p_nb IS 'Va afficher le champ co_log_3p_nb';


--
-- Name: COLUMN cerfa.co_log_4p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_log_4p_nb IS 'Va afficher le champ co_log_4p_nb';


--
-- Name: COLUMN cerfa.co_log_5p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_log_5p_nb IS 'Va afficher le champ co_log_5p_nb';


--
-- Name: COLUMN cerfa.co_log_6p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_log_6p_nb IS 'Va afficher le champ co_log_6p_nb';


--
-- Name: COLUMN cerfa.co_bat_niv_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_bat_niv_nb IS 'Le nombre de niveaux du bâtiment le plus élevé : au-dessus du sol';


--
-- Name: COLUMN cerfa.co_trx_exten; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_trx_exten IS 'Va afficher le champ co_trx_exten';


--
-- Name: COLUMN cerfa.co_trx_surelev; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_trx_surelev IS 'Va afficher le champ co_trx_surelev';


--
-- Name: COLUMN cerfa.co_trx_nivsup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_trx_nivsup IS 'Va afficher le champ co_trx_nivsup';


--
-- Name: COLUMN cerfa.co_demont_periode; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_demont_periode IS 'Va afficher le champ co_demont_periode';


--
-- Name: COLUMN cerfa.co_sp_transport; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_sp_transport IS 'Va afficher le champ co_sp_transport';


--
-- Name: COLUMN cerfa.co_sp_enseign; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_sp_enseign IS 'Va afficher le champ co_sp_enseign';


--
-- Name: COLUMN cerfa.co_sp_act_soc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_sp_act_soc IS 'Va afficher le champ co_sp_act_soc';


--
-- Name: COLUMN cerfa.co_sp_ouvr_spe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_sp_ouvr_spe IS 'Va afficher le champ co_sp_ouvr_spe';


--
-- Name: COLUMN cerfa.co_sp_sante; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_sp_sante IS 'Va afficher le champ co_sp_sante';


--
-- Name: COLUMN cerfa.co_sp_culture; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_sp_culture IS 'Va afficher le champ co_sp_culture';


--
-- Name: COLUMN cerfa.co_statio_avt_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_avt_nb IS 'Va afficher le champ co_statio_avt_nb';


--
-- Name: COLUMN cerfa.co_statio_apr_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_apr_nb IS 'Va afficher le champ co_statio_apr_nb';


--
-- Name: COLUMN cerfa.co_statio_adr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_adr IS 'Adresse(s) des aires de stationnement [SUPPRIMÉ]';


--
-- Name: COLUMN cerfa.co_statio_place_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_place_nb IS 'Va afficher le champ co_statio_place_nb';


--
-- Name: COLUMN cerfa.co_statio_tot_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_tot_surf IS 'Va afficher le champ co_statio_tot_surf';


--
-- Name: COLUMN cerfa.co_statio_tot_shob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_tot_shob IS 'Va afficher le champ co_statio_tot_shob';


--
-- Name: COLUMN cerfa.co_statio_comm_cin_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_comm_cin_surf IS 'Va afficher le champ co_statio_comm_cin_surf';


--
-- Name: COLUMN cerfa.tab_surface; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_surface IS 'Va afficher le champ tab_surface';


--
-- Name: COLUMN cerfa.dm_constr_dates; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dm_constr_dates IS 'Va afficher le champ dm_constr_dates';


--
-- Name: COLUMN cerfa.dm_total; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dm_total IS 'Va afficher le champ dm_total';


--
-- Name: COLUMN cerfa.dm_partiel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dm_partiel IS 'Va afficher le champ dm_partiel';


--
-- Name: COLUMN cerfa.dm_projet_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dm_projet_desc IS 'Va afficher le champ dm_projet_desc';


--
-- Name: COLUMN cerfa.dm_tot_log_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dm_tot_log_nb IS 'Va afficher le champ dm_tot_log_nb';


--
-- Name: COLUMN cerfa.tax_surf_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_tot IS 'Va afficher le champ tax_surf_tot';


--
-- Name: COLUMN cerfa.tax_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf IS 'Va afficher le champ tax_surf';


--
-- Name: COLUMN cerfa.tax_surf_suppr_mod; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_suppr_mod IS 'Va afficher le champ tax_surf_suppr_mod';


--
-- Name: COLUMN cerfa.tab_tax_su_princ; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_tax_su_princ IS 'Tableau : Locaux à usage d’habitation principale et leurs annexes';


--
-- Name: COLUMN cerfa.tab_tax_su_heber; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_tax_su_heber IS 'Va afficher le champ tab_tax_su_heber';


--
-- Name: COLUMN cerfa.tab_tax_su_secon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_tax_su_secon IS 'Va afficher le champ tab_tax_su_secon';


--
-- Name: COLUMN cerfa.tab_tax_su_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_tax_su_tot IS 'Va afficher le champ tab_tax_su_tot';


--
-- Name: COLUMN cerfa.tax_ext_pret; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_ext_pret IS 'Va afficher le champ tax_ext_pret';


--
-- Name: COLUMN cerfa.tax_ext_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_ext_desc IS 'Va afficher le champ tax_ext_desc';


--
-- Name: COLUMN cerfa.tax_surf_tax_exist_cons; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_tax_exist_cons IS 'Va afficher le champ tax_surf_tax_exist_cons';


--
-- Name: COLUMN cerfa.tax_log_exist_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_log_exist_nb IS 'Va afficher le champ tax_log_exist_nb';


--
-- Name: COLUMN cerfa.tax_trx_presc_ppr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_trx_presc_ppr IS 'Va afficher le champ tax_trx_presc_ppr';


--
-- Name: COLUMN cerfa.tax_monu_hist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_monu_hist IS 'Va afficher le champ tax_monu_hist';


--
-- Name: COLUMN cerfa.tax_comm_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_comm_nb IS 'Nombre de commerces de détail dont la surface de vente est inférieure à 400 m²';


--
-- Name: COLUMN cerfa.tab_tax_su_non_habit_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_tax_su_non_habit_surf IS 'Va afficher le champ tab_tax_su_non_habit_surf';


--
-- Name: COLUMN cerfa.tab_tax_am; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_tax_am IS 'Va afficher le champ tab_tax_am';


--
-- Name: COLUMN cerfa.vsd_surf_planch_smd; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.vsd_surf_planch_smd IS 'Va afficher le champ vsd_surf_planch_smd';


--
-- Name: COLUMN cerfa.vsd_unit_fonc_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.vsd_unit_fonc_sup IS 'Va afficher le champ vsd_unit_fonc_sup';


--
-- Name: COLUMN cerfa.vsd_unit_fonc_constr_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.vsd_unit_fonc_constr_sup IS 'Va afficher le champ vsd_unit_fonc_constr_sup';


--
-- Name: COLUMN cerfa.vsd_val_terr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.vsd_val_terr IS 'Va afficher le champ vsd_val_terr';


--
-- Name: COLUMN cerfa.vsd_const_sxist_non_dem_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.vsd_const_sxist_non_dem_surf IS 'Va afficher le champ vsd_const_sxist_non_dem_surf';


--
-- Name: COLUMN cerfa.vsd_rescr_fisc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.vsd_rescr_fisc IS 'Va afficher le champ vsd_rescr_fisc';


--
-- Name: COLUMN cerfa.pld_val_terr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.pld_val_terr IS 'Va afficher le champ pld_val_terr';


--
-- Name: COLUMN cerfa.pld_const_exist_dem; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.pld_const_exist_dem IS 'Va afficher le champ pld_const_exist_dem';


--
-- Name: COLUMN cerfa.pld_const_exist_dem_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.pld_const_exist_dem_surf IS 'Va afficher le champ pld_const_exist_dem_surf';


--
-- Name: COLUMN cerfa.code_cnil; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.code_cnil IS 'Va afficher le champ code_cnil';


--
-- Name: COLUMN cerfa.terr_juri_titul; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_juri_titul IS 'Va afficher le champ terr_juri_titul';


--
-- Name: COLUMN cerfa.terr_juri_lot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_juri_lot IS 'Va afficher le champ terr_juri_lot';


--
-- Name: COLUMN cerfa.terr_juri_zac; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_juri_zac IS 'Va afficher le champ terr_juri_zac';


--
-- Name: COLUMN cerfa.terr_juri_afu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_juri_afu IS 'Va afficher le champ terr_juri_afu';


--
-- Name: COLUMN cerfa.terr_juri_pup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_juri_pup IS 'Va afficher le champ terr_juri_pup';


--
-- Name: COLUMN cerfa.terr_juri_oin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_juri_oin IS 'Va afficher le champ terr_juri_oin';


--
-- Name: COLUMN cerfa.terr_juri_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_juri_desc IS 'Va afficher le champ terr_juri_desc';


--
-- Name: COLUMN cerfa.terr_div_surf_etab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_div_surf_etab IS 'Va afficher le champ terr_div_surf_etab';


--
-- Name: COLUMN cerfa.terr_div_surf_av_div; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_div_surf_av_div IS 'Va afficher le champ terr_div_surf_av_div';


--
-- Name: COLUMN cerfa.doc_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_date IS 'Va afficher le champ doc_date';


--
-- Name: COLUMN cerfa.doc_tot_trav; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_tot_trav IS 'Va afficher le champ doc_tot_trav';


--
-- Name: COLUMN cerfa.doc_tranche_trav; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_tranche_trav IS 'Va afficher le champ doc_tranche_trav';


--
-- Name: COLUMN cerfa.doc_tranche_trav_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_tranche_trav_desc IS 'Va afficher le champ doc_tranche_trav_desc';


--
-- Name: COLUMN cerfa.doc_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_surf IS 'Va afficher le champ doc_surf';


--
-- Name: COLUMN cerfa.doc_nb_log; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_nb_log IS 'Va afficher le champ doc_nb_log';


--
-- Name: COLUMN cerfa.doc_nb_log_indiv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_nb_log_indiv IS 'Va afficher le champ doc_nb_log_indiv';


--
-- Name: COLUMN cerfa.doc_nb_log_coll; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_nb_log_coll IS 'Va afficher le champ doc_nb_log_coll';


--
-- Name: COLUMN cerfa.doc_nb_log_lls; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_nb_log_lls IS 'Va afficher le champ doc_nb_log_lls';


--
-- Name: COLUMN cerfa.doc_nb_log_aa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_nb_log_aa IS 'Accession Aidée (hors prêt à taux zéro)';


--
-- Name: COLUMN cerfa.doc_nb_log_ptz; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_nb_log_ptz IS 'Va afficher le champ doc_nb_log_ptz';


--
-- Name: COLUMN cerfa.doc_nb_log_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.doc_nb_log_autre IS 'Va afficher le champ doc_nb_log_autre';


--
-- Name: COLUMN cerfa.daact_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_date IS 'Va afficher le champ daact_date';


--
-- Name: COLUMN cerfa.daact_date_chgmt_dest; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_date_chgmt_dest IS 'Va afficher le champ daact_date_chgmt_dest';


--
-- Name: COLUMN cerfa.daact_tot_trav; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_tot_trav IS 'Va afficher le champ daact_tot_trav';


--
-- Name: COLUMN cerfa.daact_tranche_trav; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_tranche_trav IS 'Va afficher le champ daact_tranche_trav';


--
-- Name: COLUMN cerfa.daact_tranche_trav_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_tranche_trav_desc IS 'Va afficher le champ daact_tranche_trav_desc';


--
-- Name: COLUMN cerfa.daact_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_surf IS 'Surface de plancher créée (en m2)';


--
-- Name: COLUMN cerfa.daact_nb_log; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_nb_log IS 'Va afficher le champ daact_nb_log';


--
-- Name: COLUMN cerfa.daact_nb_log_indiv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_nb_log_indiv IS 'Va afficher le champ daact_nb_log_indiv';


--
-- Name: COLUMN cerfa.daact_nb_log_coll; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_nb_log_coll IS 'Va afficher le champ daact_nb_log_coll';


--
-- Name: COLUMN cerfa.daact_nb_log_lls; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_nb_log_lls IS 'Va afficher le champ daact_nb_log_lls';


--
-- Name: COLUMN cerfa.daact_nb_log_aa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_nb_log_aa IS 'Va afficher le champ daact_nb_log_aa';


--
-- Name: COLUMN cerfa.daact_nb_log_ptz; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_nb_log_ptz IS 'Va afficher le champ daact_nb_log_ptz';


--
-- Name: COLUMN cerfa.daact_nb_log_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.daact_nb_log_autre IS 'Va afficher le champ daact_nb_log_autre';


--
-- Name: COLUMN cerfa.am_div_mun; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_div_mun IS 'Va afficher le champ am_div_mun';


--
-- Name: COLUMN cerfa.co_perf_energ; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_perf_energ IS 'Va afficher le champ co_perf_energ';


--
-- Name: COLUMN cerfa.architecte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.architecte IS 'Va afficher le champ architecte';


--
-- Name: COLUMN cerfa.co_statio_avt_shob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_avt_shob IS 'Va afficher le champ co_statio_avt_shob';


--
-- Name: COLUMN cerfa.co_statio_apr_shob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_apr_shob IS 'Va afficher le champ co_statio_apr_shob';


--
-- Name: COLUMN cerfa.co_statio_avt_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_avt_surf IS 'Va afficher le champ co_statio_avt_surf';


--
-- Name: COLUMN cerfa.co_statio_apr_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_statio_apr_surf IS 'Va afficher le champ co_statio_apr_surf';


--
-- Name: COLUMN cerfa.co_trx_amgt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_trx_amgt IS 'Va afficher le champ co_trx_amgt';


--
-- Name: COLUMN cerfa.co_modif_aspect; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_modif_aspect IS 'Va afficher le champ co_modif_aspect';


--
-- Name: COLUMN cerfa.co_modif_struct; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_modif_struct IS 'Va afficher le champ co_modif_struct';


--
-- Name: COLUMN cerfa.co_ouvr_elec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_ouvr_elec IS 'Va afficher le champ co_ouvr_elec';


--
-- Name: COLUMN cerfa.co_ouvr_infra; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_ouvr_infra IS 'Va afficher le champ co_ouvr_infra';


--
-- Name: COLUMN cerfa.co_trx_imm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_trx_imm IS 'Va afficher le champ co_trx_imm';


--
-- Name: COLUMN cerfa.co_cstr_shob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_cstr_shob IS 'Va afficher le champ co_cstr_shob';


--
-- Name: COLUMN cerfa.am_voyage_deb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_voyage_deb IS 'Va afficher le champ am_voyage_deb';


--
-- Name: COLUMN cerfa.am_voyage_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_voyage_fin IS 'Va afficher le champ am_voyage_fin';


--
-- Name: COLUMN cerfa.am_modif_amgt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_modif_amgt IS 'Va afficher le champ am_modif_amgt';


--
-- Name: COLUMN cerfa.am_lot_max_shob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_lot_max_shob IS 'Va afficher le champ am_lot_max_shob';


--
-- Name: COLUMN cerfa.mod_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mod_desc IS 'Va afficher le champ mod_desc';


--
-- Name: COLUMN cerfa.tr_total; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tr_total IS 'Va afficher le champ tr_total';


--
-- Name: COLUMN cerfa.tr_partiel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tr_partiel IS 'Va afficher le champ tr_partiel';


--
-- Name: COLUMN cerfa.tr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tr_desc IS 'Va afficher le champ tr_desc';


--
-- Name: COLUMN cerfa.avap_co_elt_pro; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.avap_co_elt_pro IS 'Va afficher le champ avap_co_elt_pro';


--
-- Name: COLUMN cerfa.avap_nouv_haut_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.avap_nouv_haut_surf IS 'Va afficher le champ avap_nouv_haut_surf';


--
-- Name: COLUMN cerfa.avap_co_clot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.avap_co_clot IS 'Va afficher le champ avap_co_clot';


--
-- Name: COLUMN cerfa.avap_aut_coup_aba_arb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.avap_aut_coup_aba_arb IS 'Va afficher le champ avap_aut_coup_aba_arb';


--
-- Name: COLUMN cerfa.avap_ouv_infra; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.avap_ouv_infra IS 'Va afficher le champ avap_ouv_infra';


--
-- Name: COLUMN cerfa.avap_aut_inst_mob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.avap_aut_inst_mob IS 'Va afficher le champ avap_aut_inst_mob';


--
-- Name: COLUMN cerfa.avap_aut_plant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.avap_aut_plant IS 'Va afficher le champ avap_aut_plant';


--
-- Name: COLUMN cerfa.avap_aut_auv_elec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.avap_aut_auv_elec IS 'Va afficher le champ avap_aut_auv_elec';


--
-- Name: COLUMN cerfa.tax_dest_loc_tr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_dest_loc_tr IS 'Va afficher le champ tax_dest_loc_tr';


--
-- Name: COLUMN cerfa.ope_proj_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ope_proj_desc IS 'Va afficher le champ ope_proj_desc';


--
-- Name: COLUMN cerfa.tax_surf_tot_cstr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_tot_cstr IS 'Surface taxable totale créée de la ou des construction(s), hormis les surfaces de stationnement closes et couvertes (en m²)';


--
-- Name: COLUMN cerfa.tax_surf_loc_stat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_loc_stat IS 'Surface taxable des locaux clos et couverts à usage de stationnement [SUPPRIMÉ]';


--
-- Name: COLUMN cerfa.tax_log_ap_trvx_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_log_ap_trvx_nb IS 'Quel est le nombre de logements après travaux ?';


--
-- Name: COLUMN cerfa.tax_am_statio_ext_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_am_statio_ext_cr IS 'Nombre de places de stationnement non couvertes ou non closes';


--
-- Name: COLUMN cerfa.tax_sup_bass_pisc_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_sup_bass_pisc_cr IS 'Superficie du bassin intérieur ou extérieur de la piscine';


--
-- Name: COLUMN cerfa.tax_empl_ten_carav_mobil_nb_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_empl_ten_carav_mobil_nb_cr IS 'Nombre d’emplacements de tentes, de caravanes et de résidences mobiles de loisirs';


--
-- Name: COLUMN cerfa.tax_empl_hll_nb_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_empl_hll_nb_cr IS 'Nombre d’emplacements pour les habitations légères de loisirs';


--
-- Name: COLUMN cerfa.tax_eol_haut_nb_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_eol_haut_nb_cr IS 'Nombre d’éoliennes dont la hauteur est supérieure à 12 m';


--
-- Name: COLUMN cerfa.tax_pann_volt_sup_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_pann_volt_sup_cr IS 'Superficie des panneaux photo-voltaïques posés au sol';


--
-- Name: COLUMN cerfa.tax_surf_loc_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_loc_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre des locaux';


--
-- Name: COLUMN cerfa.tax_surf_pisc_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_pisc_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre de la piscine';


--
-- Name: COLUMN cerfa.tax_am_statio_ext_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_am_statio_ext_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre des emplacements de stationnement';


--
-- Name: COLUMN cerfa.tab_tax_su_parc_statio_expl_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_tax_su_parc_statio_expl_comm IS 'Tableau : Parcs de stationnement couverts faisant l’objet d’une exploitation commerciale';


--
-- Name: COLUMN cerfa.tax_empl_ten_carav_mobil_nb_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_empl_ten_carav_mobil_nb_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre des emplacements de tentes, de caravanes et de résidences mobiles de loisirs';


--
-- Name: COLUMN cerfa.tax_empl_hll_nb_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_empl_hll_nb_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre des emplacements pour les habitations légères de loisirs';


--
-- Name: COLUMN cerfa.tax_eol_haut_nb_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_eol_haut_nb_arch IS 'Nombre d’éoliennes dont la hauteur est supérieure à 12 m concernées';


--
-- Name: COLUMN cerfa.ope_proj_div_co; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ope_proj_div_co IS 'Division en vue de construire';


--
-- Name: COLUMN cerfa.ope_proj_div_contr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ope_proj_div_contr IS 'Division dans une commune qui a institué le contrôle des divisions dans le cadre de l’article L.115-3 du code de l’urbanisme.';


--
-- Name: COLUMN cerfa.tax_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_desc IS 'Informations/Explications complémentaires pouvant vous permettre de bénéficier d’impositions plus favorables.';


--
-- Name: COLUMN cerfa.erp_cstr_neuve; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_cstr_neuve IS 'Nature des travaux : Construction neuve';


--
-- Name: COLUMN cerfa.erp_trvx_acc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_trvx_acc IS 'Nature des travaux : Travaux de mise en conformité totale aux règles d’accessibilité';


--
-- Name: COLUMN cerfa.erp_extension; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_extension IS 'Nature des travaux : Extension';


--
-- Name: COLUMN cerfa.erp_rehab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_rehab IS 'Nature des travaux : Réhabilitation';


--
-- Name: COLUMN cerfa.erp_trvx_am; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_trvx_am IS 'Nature des travaux : Travaux d’aménagement (remplacement de revêtements, rénovation électrique, création d’une rampe, par exemple)';


--
-- Name: COLUMN cerfa.erp_vol_nouv_exist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_vol_nouv_exist IS 'Nature des travaux : Création de volumes nouveaux dans des volumes existants (modification du cloisonnement, par exemple)';


--
-- Name: COLUMN cerfa.tab_erp_eff; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_erp_eff IS 'Tableau : Effectif';


--
-- Name: COLUMN cerfa.erp_class_cat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_class_cat IS 'Classement sécurité incendie de l’ERP : Catégorie';


--
-- Name: COLUMN cerfa.erp_class_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_class_type IS 'Classement sécurité incendie de l’ERP : Type';


--
-- Name: COLUMN cerfa.tax_surf_abr_jard_pig_colom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_abr_jard_pig_colom IS '1.2.3 Création d’abris de jardin, de pigeonniers et colombiers - Quelle est la surface taxable créée (en m²) ?';


--
-- Name: COLUMN cerfa.tax_su_non_habit_abr_jard_pig_colom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_su_non_habit_abr_jard_pig_colom IS 'Parmi les surfaces déclarées ci-dessus, quelle est la surface affectée à la catégorie des abris de jardin, pigeonniers et colombiers (en m²) ?';


--
-- Name: COLUMN cerfa.dia_imm_non_bati; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_imm_non_bati IS 'Immeuble : Non bâti';


--
-- Name: COLUMN cerfa.dia_imm_bati_terr_propr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_imm_bati_terr_propr IS 'Immeuble : Bâti sur terrain propre';


--
-- Name: COLUMN cerfa.dia_imm_bati_terr_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_imm_bati_terr_autr IS 'Immeuble : Bâti sur terrain d’autrui, dans ce cas indiquer nom et adresse du propriétaire';


--
-- Name: COLUMN cerfa.dia_imm_bati_terr_autr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_imm_bati_terr_autr_desc IS 'Nom et adresse du propriétaire dans le cas ''Bâti sur terrain d’autrui''';


--
-- Name: COLUMN cerfa.dia_bat_copro; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_bat_copro IS 'Locaux dans un bâtiment en copropriété';


--
-- Name: COLUMN cerfa.dia_bat_copro_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_bat_copro_desc IS 'Description du champ ''Locaux dans un bâtiment en copropriété''';


--
-- Name: COLUMN cerfa.dia_lot_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_lot_numero IS 'N° du lot';


--
-- Name: COLUMN cerfa.dia_lot_bat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_lot_bat IS 'Bâtiment';


--
-- Name: COLUMN cerfa.dia_lot_etage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_lot_etage IS 'Étage';


--
-- Name: COLUMN cerfa.dia_lot_quote_part; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_lot_quote_part IS 'Quote-part des parties communes';


--
-- Name: COLUMN cerfa.dia_us_hab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_us_hab IS 'Usage : habitation';


--
-- Name: COLUMN cerfa.dia_us_pro; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_us_pro IS 'Usage : professionnel';


--
-- Name: COLUMN cerfa.dia_us_mixte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_us_mixte IS 'Usage : mixte';


--
-- Name: COLUMN cerfa.dia_us_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_us_comm IS 'Usage : commercial';


--
-- Name: COLUMN cerfa.dia_us_agr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_us_agr IS 'Usage : agricole';


--
-- Name: COLUMN cerfa.dia_us_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_us_autre IS 'Usage : autre (préciser)';


--
-- Name: COLUMN cerfa.dia_us_autre_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_us_autre_prec IS 'Précision de l''usage ''autre''';


--
-- Name: COLUMN cerfa.dia_occ_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_prop IS 'Occupation : par le(s) propriétaire(s)';


--
-- Name: COLUMN cerfa.dia_occ_loc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_loc IS 'Occupation : par un (des) locataire(s)';


--
-- Name: COLUMN cerfa.dia_occ_sans_occ; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sans_occ IS 'Occupation : sans occupant';


--
-- Name: COLUMN cerfa.dia_occ_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_autre IS 'Occupation : autre (préciser)';


--
-- Name: COLUMN cerfa.dia_occ_autre_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_autre_prec IS 'Précision de l''occupation ''autre''';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente IS 'Prix de vente ou évaluation (en lettres et en chiffres)';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente_mob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_mob IS 'Dont éventuellement inclus : Mobilier';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente_cheptel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_cheptel IS 'Dont éventuellement inclus : Cheptel';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente_recol; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_recol IS 'Dont éventuellement inclus : Récoltes';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_autre IS 'Dont éventuellement inclus : Autres';


--
-- Name: COLUMN cerfa.dia_mod_cess_commi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_commi IS 'Si commission, montant';


--
-- Name: COLUMN cerfa.dia_mod_cess_commi_ttc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_commi_ttc IS 'Le montant de la commission est TTC';


--
-- Name: COLUMN cerfa.dia_mod_cess_commi_ht; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_commi_ht IS 'Le montant de la commission est HT';


--
-- Name: COLUMN cerfa.dia_acquereur_nom_prenom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_acquereur_nom_prenom IS 'Nom, prénom de l’acquéreur';


--
-- Name: COLUMN cerfa.dia_acquereur_adr_num_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_acquereur_adr_num_voie IS 'N° voie';


--
-- Name: COLUMN cerfa.dia_acquereur_adr_ext; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_acquereur_adr_ext IS 'Extension';


--
-- Name: COLUMN cerfa.dia_acquereur_adr_type_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_acquereur_adr_type_voie IS 'Type de voie';


--
-- Name: COLUMN cerfa.dia_acquereur_adr_nom_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_acquereur_adr_nom_voie IS 'Nom de voie';


--
-- Name: COLUMN cerfa.dia_acquereur_adr_lieu_dit_bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_acquereur_adr_lieu_dit_bp IS 'Lieu-dit ou boite postale';


--
-- Name: COLUMN cerfa.dia_acquereur_adr_cp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_acquereur_adr_cp IS 'Code postal';


--
-- Name: COLUMN cerfa.dia_acquereur_adr_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_acquereur_adr_localite IS 'Localité';


--
-- Name: COLUMN cerfa.dia_observation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_observation IS 'Observation';


--
-- Name: COLUMN cerfa.tab_surface2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tab_surface2 IS 'Tableau : Destination, sous-destination des constructions et tableau des surfaces';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_terre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_terre IS 'Occupation du sol en superficie (m²) : Terres';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_pres; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_pres IS 'Occupation du sol en superficie (m²) : Près';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_verger; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_verger IS 'Occupation du sol en superficie (m²) : Vergers';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_vigne; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_vigne IS 'Occupation du sol en superficie (m²) : Vignes';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_bois; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_bois IS 'Occupation du sol en superficie (m²) : Bois';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_lande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_lande IS 'Occupation du sol en superficie (m²) : Landes';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_carriere; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_carriere IS 'Occupation du sol en superficie (m²) : Carrières';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_eau_cadastree; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_eau_cadastree IS 'Occupation du sol en superficie (m²) : Eaux cadastrées';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_jardin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_jardin IS 'Occupation du sol en superficie (m²) : Jardins';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_terr_batir; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_terr_batir IS 'Occupation du sol en superficie (m²) : Terrains à bâtir';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_terr_agr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_terr_agr IS 'Occupation du sol en superficie (m²) : Terrains d''agrément';


--
-- Name: COLUMN cerfa.dia_occ_sol_su_sol; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_occ_sol_su_sol IS 'Occupation du sol en superficie (m²) : Sol';


--
-- Name: COLUMN cerfa.dia_bati_vend_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_bati_vend_tot IS 'Bâtiments vendus en totalité';


--
-- Name: COLUMN cerfa.dia_bati_vend_tot_txt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_bati_vend_tot_txt IS 'Bâtiments vendus en totalité (texte)';


--
-- Name: COLUMN cerfa.dia_su_co_sol; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_su_co_sol IS 'Surface construite au sol (m2)';


--
-- Name: COLUMN cerfa.dia_su_util_hab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_su_util_hab IS 'Surface utile ou habitable (m2)';


--
-- Name: COLUMN cerfa.dia_nb_niv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_nb_niv IS 'Nombre de : Niveaux';


--
-- Name: COLUMN cerfa.dia_nb_appart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_nb_appart IS 'Nombre de : Appartements';


--
-- Name: COLUMN cerfa.dia_nb_autre_loc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_nb_autre_loc IS 'Nombre de : Autres locaux';


--
-- Name: COLUMN cerfa.dia_vente_lot_volume; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_vente_lot_volume IS 'Vente en lot de volumes';


--
-- Name: COLUMN cerfa.dia_vente_lot_volume_txt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_vente_lot_volume_txt IS 'Vente en lot de volumes (texte)';


--
-- Name: COLUMN cerfa.dia_lot_nat_su; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_lot_nat_su IS 'Nature et surface utile ou habitable';


--
-- Name: COLUMN cerfa.dia_lot_bat_achv_plus_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_lot_bat_achv_plus_10 IS 'Le bâtiment est achevé depuis : Plus de 10 ans';


--
-- Name: COLUMN cerfa.dia_lot_bat_achv_moins_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_lot_bat_achv_moins_10 IS 'Le bâtiment est achevé depuis : Moins de 10 ans';


--
-- Name: COLUMN cerfa.dia_lot_regl_copro_publ_hypo_plus_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_lot_regl_copro_publ_hypo_plus_10 IS 'Le règlement de copropriété a été publié aux hypothèques depuis : Plus de 10 ans';


--
-- Name: COLUMN cerfa.dia_lot_regl_copro_publ_hypo_moins_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_lot_regl_copro_publ_hypo_moins_10 IS 'Le règlement de copropriété a été publié aux hypothèques depuis : Moins de 10 ans';


--
-- Name: COLUMN cerfa.dia_indivi_quote_part; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_indivi_quote_part IS 'En cas d’indivision, quote-part du bien vendu';


--
-- Name: COLUMN cerfa.dia_design_societe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_design_societe IS 'Désignation de la société';


--
-- Name: COLUMN cerfa.dia_design_droit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_design_droit IS 'Désignation des droits';


--
-- Name: COLUMN cerfa.dia_droit_soc_nat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_droit_soc_nat IS 'Nature';


--
-- Name: COLUMN cerfa.dia_droit_soc_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_droit_soc_nb IS 'Nombre';


--
-- Name: COLUMN cerfa.dia_droit_soc_num_part; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_droit_soc_num_part IS 'Numéro des parts';


--
-- Name: COLUMN cerfa.dia_droit_reel_perso_grevant_bien_oui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_droit_reel_perso_grevant_bien_oui IS 'Grevant les biens : OUI';


--
-- Name: COLUMN cerfa.dia_droit_reel_perso_grevant_bien_non; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_droit_reel_perso_grevant_bien_non IS 'Grevant les biens : NON';


--
-- Name: COLUMN cerfa.dia_droit_reel_perso_nat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_droit_reel_perso_nat IS 'Préciser la nature';


--
-- Name: COLUMN cerfa.dia_droit_reel_perso_viag; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_droit_reel_perso_viag IS 'Indiquer si rente viagère antérieure';


--
-- Name: COLUMN cerfa.dia_mod_cess_adr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_adr IS 'Si vente indissociable d’autres biens : Adresse précise du bien';


--
-- Name: COLUMN cerfa.dia_mod_cess_sign_act_auth; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_sign_act_auth IS 'Modalités de paiement : comptant à la signature de l’acte authentique';


--
-- Name: COLUMN cerfa.dia_mod_cess_terme; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_terme IS 'Modalités de paiement : à terme';


--
-- Name: COLUMN cerfa.dia_mod_cess_terme_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_terme_prec IS 'Modalités de paiement : à terme (préciser)';


--
-- Name: COLUMN cerfa.dia_mod_cess_bene_acquereur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_bene_acquereur IS 'Bénéficiaire : acquéreur';


--
-- Name: COLUMN cerfa.dia_mod_cess_bene_vendeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_bene_vendeur IS 'Bénéficiaire : vendeur';


--
-- Name: COLUMN cerfa.dia_mod_cess_paie_nat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_paie_nat IS 'Paiement en nature';


--
-- Name: COLUMN cerfa.dia_mod_cess_design_contr_alien; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_design_contr_alien IS 'Désignation de la contrepartie de l’aliénation';


--
-- Name: COLUMN cerfa.dia_mod_cess_eval_contr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_eval_contr IS 'Evaluation de la contrepartie';


--
-- Name: COLUMN cerfa.dia_mod_cess_rente_viag; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_rente_viag IS 'Rente viagère';


--
-- Name: COLUMN cerfa.dia_mod_cess_mnt_an; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_an IS 'Montant annuel';


--
-- Name: COLUMN cerfa.dia_mod_cess_mnt_compt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_compt IS 'Montant comptant';


--
-- Name: COLUMN cerfa.dia_mod_cess_bene_rente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_bene_rente IS 'Bénéficiaire(s) de la rente';


--
-- Name: COLUMN cerfa.dia_mod_cess_droit_usa_hab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_droit_usa_hab IS 'Droit d’usage et d’habitation';


--
-- Name: COLUMN cerfa.dia_mod_cess_droit_usa_hab_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_droit_usa_hab_prec IS 'Droit d’usage et d’habitation (à préciser)';


--
-- Name: COLUMN cerfa.dia_mod_cess_eval_usa_usufruit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_eval_usa_usufruit IS 'Evaluation de l’usage ou de l’usufruit';


--
-- Name: COLUMN cerfa.dia_mod_cess_vente_nue_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_vente_nue_prop IS 'Vente de la nue-propriété';


--
-- Name: COLUMN cerfa.dia_mod_cess_vente_nue_prop_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_vente_nue_prop_prec IS 'Vente de la nue-propriété (à préciser)';


--
-- Name: COLUMN cerfa.dia_mod_cess_echange; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_echange IS 'Echange';


--
-- Name: COLUMN cerfa.dia_mod_cess_design_bien_recus_ech; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_design_bien_recus_ech IS 'Désignation des biens reçus en échange';


--
-- Name: COLUMN cerfa.dia_mod_cess_mnt_soulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_soulte IS 'Montant de la soulte le cas échéant';


--
-- Name: COLUMN cerfa.dia_mod_cess_prop_contre_echan; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prop_contre_echan IS 'Propriétaires contre-échangistes';


--
-- Name: COLUMN cerfa.dia_mod_cess_apport_societe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_apport_societe IS 'Apport en société';


--
-- Name: COLUMN cerfa.dia_mod_cess_bene; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_bene IS 'Bénéficiaire';


--
-- Name: COLUMN cerfa.dia_mod_cess_esti_bien; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_esti_bien IS 'Estimation du bien apporté';


--
-- Name: COLUMN cerfa.dia_mod_cess_cess_terr_loc_co; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_cess_terr_loc_co IS 'Cession de tantième de terrains contre remise de locaux à construire';


--
-- Name: COLUMN cerfa.dia_mod_cess_esti_terr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_esti_terr IS 'Estimation du terrain';


--
-- Name: COLUMN cerfa.dia_mod_cess_esti_loc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_esti_loc IS 'Estimation des locaux à remettre';


--
-- Name: COLUMN cerfa.dia_mod_cess_esti_imm_loca; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_esti_imm_loca IS 'Location-accession – Estimation de l’immeuble objet de la location-accession';


--
-- Name: COLUMN cerfa.dia_mod_cess_adju_vol; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_adju_vol IS 'Volontaire';


--
-- Name: COLUMN cerfa.dia_mod_cess_adju_obl; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_adju_obl IS 'Rendue obligatoire par une disposition législative ou réglementaire';


--
-- Name: COLUMN cerfa.dia_mod_cess_adju_fin_indivi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_adju_fin_indivi IS 'Mettant fin à une indivision ne résultant pas d’une donation-partage';


--
-- Name: COLUMN cerfa.dia_mod_cess_adju_date_lieu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_adju_date_lieu IS 'Date et lieu de l’adjudication';


--
-- Name: COLUMN cerfa.dia_mod_cess_mnt_mise_prix; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_mise_prix IS 'Montant de la mise à prix';


--
-- Name: COLUMN cerfa.dia_prop_titu_prix_indique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_prop_titu_prix_indique IS 'Que le(s) propriétaire(s) nommé(s) à la rubrique 1 : Demande(nt) au titulaire du droit de préemption d’acquérir les biens désignés à la rubrique 3 aux prix et conditions indiqués';


--
-- Name: COLUMN cerfa.dia_prop_recherche_acqu_prix_indique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_prop_recherche_acqu_prix_indique IS 'Que le(s) propriétaire(s) nommé(s) à la rubrique 1 : A (ont) recherché un acquéreur disposé à acquérir les biens désignés à la rubrique 3 aux prix et conditions indiqués';


--
-- Name: COLUMN cerfa.dia_acquereur_prof; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_acquereur_prof IS 'Profession (facultatif)';


--
-- Name: COLUMN cerfa.dia_indic_compl_ope; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_indic_compl_ope IS 'Indications complémentaires concernant l’opération envisagée par l’acquéreur (facultatif)';


--
-- Name: COLUMN cerfa.dia_vente_adju; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_vente_adju IS 'Qu’il est chargé de procéder à la vente par voie d’adjudication comme indiqué à la rubrique F-2 des biens désignés à la rubrique C appartenant a(ux) propriétaire(s) nommé(s) en A';


--
-- Name: COLUMN cerfa.am_terr_res_demon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_terr_res_demon IS 'Aménagement d’un terrain pour au moins 2 résidences démontables, créant une surface de plancher totale supérieure à 40M², constituant l’habitat permanent de leurs utilisateurs';


--
-- Name: COLUMN cerfa.am_air_terr_res_mob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.am_air_terr_res_mob IS 'Aménagement d’une aire d’accueil ou d’un terrain familial des gens du voyage recevant plus de deux résidences mobiles';


--
-- Name: COLUMN cerfa.ctx_objet_recours; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_objet_recours IS 'Objet du recours';


--
-- Name: COLUMN cerfa.ctx_moyen_souleve; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_moyen_souleve IS 'Moyens soulevés';


--
-- Name: COLUMN cerfa.ctx_moyen_retenu_juge; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_moyen_retenu_juge IS 'Moyens retenus par le juge';


--
-- Name: COLUMN cerfa.ctx_reference_sagace; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_reference_sagace IS 'Références sagaces';


--
-- Name: COLUMN cerfa.ctx_nature_travaux_infra_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_nature_travaux_infra_om_html IS 'Nature des travaux en infraction (NTI)';


--
-- Name: COLUMN cerfa.ctx_synthese_nti; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_synthese_nti IS 'Synthèse des NTI';


--
-- Name: COLUMN cerfa.ctx_article_non_resp_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_article_non_resp_om_html IS 'Article(s) non respecté(s) (ANR)';


--
-- Name: COLUMN cerfa.ctx_synthese_anr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_synthese_anr IS 'Synthèse (ANR)';


--
-- Name: COLUMN cerfa.ctx_reference_parquet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_reference_parquet IS 'Références Parquet';


--
-- Name: COLUMN cerfa.ctx_element_taxation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_element_taxation IS 'Éléments de taxation';


--
-- Name: COLUMN cerfa.ctx_infraction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_infraction IS 'Infraction';


--
-- Name: COLUMN cerfa.ctx_regularisable; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_regularisable IS 'Régularisable';


--
-- Name: COLUMN cerfa.ctx_reference_courrier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_reference_courrier IS 'Référence(s) courrier';


--
-- Name: COLUMN cerfa.ctx_date_audience; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_date_audience IS 'Date d''audience';


--
-- Name: COLUMN cerfa.ctx_date_ajournement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_date_ajournement IS 'Date d''ajournement';


--
-- Name: COLUMN cerfa.exo_facul_1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_facul_1 IS 'Les locaux d''habitation et d''hébergement mentionnés au 1° de l''article L. 331-12 qui ne bénéficient pas de l''exonération prévue au 2° de l''article L. 331-7.';


--
-- Name: COLUMN cerfa.exo_facul_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_facul_2 IS 'Dans la limite de 50 % de leur surface, les surfaces des locaux à usage d''habitation principale qui ne bénéficient pas de l''abattement mentionné au 2° de l''article L. 331-12 et qui sont financés à l''aide du prêt ne portant pas intérêt prévu à l''article L. 31-10-1 du code de la construction et de l''habitation.';


--
-- Name: COLUMN cerfa.exo_facul_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_facul_3 IS 'Les locaux à usage industriel et artisanal mentionnés au 3° de l''article L. 331-12 du présent code.';


--
-- Name: COLUMN cerfa.exo_facul_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_facul_4 IS 'Les commerces de détail d''une surface de vente inférieure à 400 mètres carrés.';


--
-- Name: COLUMN cerfa.exo_facul_5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_facul_5 IS 'Les immeubles classés parmi les monuments historiques ou inscrits à l''inventaire supplémentaire des monuments historiques.';


--
-- Name: COLUMN cerfa.exo_facul_6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_facul_6 IS 'Les surfaces annexes à usage de stationnement des locaux mentionnés au 1° et ne bénéficiant pas de l''exonération totale.';


--
-- Name: COLUMN cerfa.exo_facul_7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_facul_7 IS 'Les surfaces des locaux annexes à usage de stationnement des immeubles autres que d''habitations individuelles.';


--
-- Name: COLUMN cerfa.exo_facul_8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_facul_8 IS 'Les abris de jardin, les pigeonniers et colombiers soumis à déclaration préalable.';


--
-- Name: COLUMN cerfa.exo_facul_9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_facul_9 IS 'Les maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique, pour les communes maîtres d''ouvrage.';


--
-- Name: COLUMN cerfa.exo_ta_1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_ta_1 IS 'Les constructions et aménagements destinés à être affectés à un service public ou d''utilité publique, dont la liste est fixée par un décret en Conseil d''Etat.';


--
-- Name: COLUMN cerfa.exo_ta_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_ta_2 IS 'Les constructions de locaux d''habitation et d''hébergement mentionnés aux articles 278 sexies et 296 ter du code général des impôts et, en Guyane et à Mayotte, les constructions de mêmes locaux, dès lors qu''ils sont financés dans les conditions du II de l''article R. 331-1 du code de la construction et de l''habitation ou du b du 2 de l''article R. 372-9 du même code.';


--
-- Name: COLUMN cerfa.exo_ta_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_ta_3 IS 'Dans les exploitations et coopératives agricoles, les surfaces de plancher des serres de production, celles des locaux destinés à abriter les récoltes, à héberger les animaux, à ranger et à entretenir le matériel agricole, celles des locaux de production et de stockage des produits à usage agricole, celles des locaux de transformation et de conditionnement des produits provenant de l''exploitation et, dans les centres équestres de loisir, les surfaces des bâtiments affectées aux activités équestres.';


--
-- Name: COLUMN cerfa.exo_ta_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_ta_4 IS 'Les constructions et aménagements réalisés dans les périmètres des opérations d''intérêt national prévues à l''article L. 102-12 lorsque le coût des équipements, dont la liste est fixée par décret en Conseil d''Etat, a été mis à la charge des constructeurs ou des aménageurs.';


--
-- Name: COLUMN cerfa.exo_ta_5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_ta_5 IS 'Les constructions et aménagements réalisés dans les zones d''aménagement concerté mentionnées à l''article L. 311-1 lorsque le coût des équipements publics, dont la liste est fixée par un décret en Conseil d''Etat, a été mis à la charge des constructeurs ou des aménageurs. Cette liste peut être complétée par une délibération du conseil municipal ou de l''organe délibérant de l''établissement public de coopération intercommunale valable pour une durée minimale de trois ans.';


--
-- Name: COLUMN cerfa.exo_ta_6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_ta_6 IS 'Les constructions et aménagements réalisés dans les périmètres délimités par une convention de projet urbain partenarial prévue par l''article L. 332-11-3, dans les limites de durée prévues par cette convention, en application de l''article L. 332-11-4.';


--
-- Name: COLUMN cerfa.exo_ta_7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_ta_7 IS 'Les aménagements prescrits par un plan de prévention des risques naturels prévisibles, un plan de prévention des risques technologiques ou un plan de prévention des risques miniers sur des biens construits ou aménagés conformément aux dispositions du présent code avant l''approbation de ce plan et mis à la charge des propriétaires ou exploitants de ces biens.';


--
-- Name: COLUMN cerfa.exo_ta_8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_ta_8 IS 'La reconstruction à l''identique d''un bâtiment détruit ou démoli depuis moins de dix ans dans les conditions prévues au premier alinéa de l''article L. 111-15, sous réserve des dispositions du 4° de l''article L. 331-30, ainsi que la reconstruction sur d''autres terrains de la même commune ou des communes limitrophes des bâtiments de même nature que les locaux sinistrés dont le terrain d''implantation a été reconnu comme extrêmement dangereux et classé inconstructible, pourvu que le contribuable justifie que les indemnités versées en réparation des dommages occasionnés à l''immeuble ne comprennent pas le montant de la taxe d''aménagement normalement exigible sur les reconstructions.';


--
-- Name: COLUMN cerfa.exo_ta_9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_ta_9 IS 'Les constructions dont la surface est inférieure ou égale à 5 mètres carrés.';


--
-- Name: COLUMN cerfa.exo_rap_1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_rap_1 IS 'Travaux et aménagements dont la surface au sol est inférieure à 3 000 m².';


--
-- Name: COLUMN cerfa.exo_rap_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_rap_2 IS 'Les constructions de locaux d''habitation et d''hébergement mentionnés aux articles 278 sexies et 296 ter du code général des impôts et, en Guyane et à Mayotte, les constructions de mêmes locaux, dès lors qu''ils sont financés dans les conditions du II de l''article R. 331-1 du code de la construction et de l''habitation ou du b du 2 de l''article R. 372-9 du même code.';


--
-- Name: COLUMN cerfa.exo_rap_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_rap_3 IS 'Travaux n''affectant pas le sous-sol : surélévation d''un bâtiment existant, emplacement sans fondation (emplacement de tente, caravane et résidence mobile de loisirs sur un terrain de camping, panneau photovoltaïque fixé au sol, aire de stationnement extérieure...).';


--
-- Name: COLUMN cerfa.exo_rap_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_rap_4 IS 'Dans les exploitations et coopératives agricoles, les surfaces de plancher des serres de production, celles des locaux destinés à abriter les récoltes, à héberger les animaux, à ranger et à entretenir le matériel agricole, celles des locaux de production et de stockage des produits à usage agricole, celles des locaux de transformation et de conditionnement des produits provenant de l''exploitation et, dans les centres équestres de loisir, les surfaces des bâtiments affectées aux activités équestres.';


--
-- Name: COLUMN cerfa.exo_rap_5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_rap_5 IS 'Les constructions et aménagements destinés à être affectés à un service public ou d''utilité publique, dont la liste est fixée par un décret en Conseil d''Etat.';


--
-- Name: COLUMN cerfa.exo_rap_6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_rap_6 IS 'La reconstruction à l''identique d''un bâtiment détruit ou démoli depuis moins de dix ans dans les conditions prévues au premier alinéa de l''article L. 111-15, sous réserve des dispositions du 4° de l''article L. 331-30, ainsi que la reconstruction sur d''autres terrains de la même commune ou des communes limitrophes des bâtiments de même nature que les locaux sinistrés dont le terrain d''implantation a été reconnu comme extrêmement dangereux et classé inconstructible, pourvu que le contribuable justifie que les indemnités versées en réparation des dommages occasionnés à l''immeuble ne comprennent pas le montant de la taxe d''aménagement normalement exigible sur les reconstructions.';


--
-- Name: COLUMN cerfa.exo_rap_7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_rap_7 IS 'Les aménagements prescrits par un plan de prévention des risques naturels prévisibles, un plan de prévention des risques technologiques ou un plan de prévention des risques miniers sur des biens construits ou aménagés conformément aux dispositions du présent code avant l''approbation de ce plan et mis à la charge des propriétaires ou exploitants de ces biens.';


--
-- Name: COLUMN cerfa.exo_rap_8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.exo_rap_8 IS 'Les constructions dont la surface est inférieure ou égale à 5 mètres carrés.';


--
-- Name: COLUMN cerfa.mtn_exo_ta_part_commu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mtn_exo_ta_part_commu IS 'Montant de l''exonération de la taxe d’aménagement sur la part communale.';


--
-- Name: COLUMN cerfa.mtn_exo_ta_part_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mtn_exo_ta_part_depart IS 'Montant de l''exonération de la taxe d’aménagement sur la part départementale.';


--
-- Name: COLUMN cerfa.mtn_exo_ta_part_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mtn_exo_ta_part_reg IS 'Montant de l''exonération de la taxe d’aménagement sur la part régionale.';


--
-- Name: COLUMN cerfa.mtn_exo_rap; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mtn_exo_rap IS 'Montant de l''exonération de la redevance d''archéologie préventive.';


--
-- Name: COLUMN cerfa.dpc_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_type IS 'Type de droit de préemption commercial';


--
-- Name: COLUMN cerfa.dpc_desc_actv_ex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_desc_actv_ex IS 'Activité exercée';


--
-- Name: COLUMN cerfa.dpc_desc_ca; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_desc_ca IS 'Chiffre d’affaires';


--
-- Name: COLUMN cerfa.dpc_desc_aut_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_desc_aut_prec IS 'Autres précisions';


--
-- Name: COLUMN cerfa.dpc_desig_comm_arti; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_desig_comm_arti IS 'Bien à usage uniquement commercial ou artisanal';


--
-- Name: COLUMN cerfa.dpc_desig_loc_hab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_desig_loc_hab IS 'Bien comportant un local accessoire d’habitation';


--
-- Name: COLUMN cerfa.dpc_desig_loc_ann; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_desig_loc_ann IS 'Bien comportant d’autres locaux annexes (entrepôts, ateliers, etc.)';


--
-- Name: COLUMN cerfa.dpc_desig_loc_ann_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_desig_loc_ann_prec IS 'Préciser la composition de ces autres locaux';


--
-- Name: COLUMN cerfa.dpc_bail_comm_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_bail_comm_date IS 'Date de signature du bail';


--
-- Name: COLUMN cerfa.dpc_bail_comm_loyer; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_bail_comm_loyer IS 'Montant du loyer';


--
-- Name: COLUMN cerfa.dpc_actv_acqu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_actv_acqu IS 'Activité de l’acquéreur pressenti';


--
-- Name: COLUMN cerfa.dpc_nb_sala_di; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_nb_sala_di IS 'À durée indéterminée';


--
-- Name: COLUMN cerfa.dpc_nb_sala_dd; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_nb_sala_dd IS 'À durée déterminée';


--
-- Name: COLUMN cerfa.dpc_nb_sala_tc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_nb_sala_tc IS 'À temps complet';


--
-- Name: COLUMN cerfa.dpc_nb_sala_tp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_nb_sala_tp IS 'À temps partiel';


--
-- Name: COLUMN cerfa.dpc_moda_cess_vente_am; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_vente_am IS 'Vente amiable';


--
-- Name: COLUMN cerfa.dpc_moda_cess_adj; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_adj IS 'Adjudication';


--
-- Name: COLUMN cerfa.dpc_moda_cess_prix; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_prix IS 'Prix de vente ou évaluation (en lettres et chiffres)';


--
-- Name: COLUMN cerfa.dpc_moda_cess_adj_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_adj_date IS 'En cas d’adjudication, précisez la date';


--
-- Name: COLUMN cerfa.dpc_moda_cess_adj_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_adj_prec IS 'En cas d’adjudication, précisez les modalités de la vente';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_comp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_comp IS 'Comptant à la signature de l’acte authentique';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_terme; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_terme IS 'À terme';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_terme_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_terme_prec IS 'À terme, précisez';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_nat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_nat IS 'Paiement en nature';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_nat_desig_alien; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_nat_desig_alien IS 'Désignation de la contrepartie de l’aliénation';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_nat_desig_alien_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_nat_desig_alien_prec IS 'Désignation de la contrepartie de l’aliénation, précisez';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_nat_eval; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_nat_eval IS 'Évaluation de la contrepartie';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_nat_eval_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_nat_eval_prec IS 'Évaluation de la contrepartie, précisez';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_aut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_aut IS 'Autre : échange, apport en société...';


--
-- Name: COLUMN cerfa.dpc_moda_cess_paie_aut_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_moda_cess_paie_aut_prec IS 'Autre : échange, apport en société... Précisez';


--
-- Name: COLUMN cerfa.dpc_ss_signe_demande_acqu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_ss_signe_demande_acqu IS 'Demande au titulaire du droit de préemption d’acquérir le bien désigné à la rubrique 3';


--
-- Name: COLUMN cerfa.dpc_ss_signe_recher_trouv_acqu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_ss_signe_recher_trouv_acqu IS 'A recherché et trouvé un acquéreur disposé à acheter le bien désigné à la rubrique 3 aux prix et conditions indiqués';


--
-- Name: COLUMN cerfa.dpc_notif_adr_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_notif_adr_prop IS 'À l’adresse du propriétaire ou du titulaire du bail désigné à la rubrique 1';


--
-- Name: COLUMN cerfa.dpc_notif_adr_manda; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_notif_adr_manda IS 'À l’adresse du mandataire désigné à la rubrique 6';


--
-- Name: COLUMN cerfa.dpc_obs; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dpc_obs IS 'Observations éventuelles';


--
-- Name: COLUMN cerfa.co_peri_site_patri_remar; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_peri_site_patri_remar IS 'Indiquez si votre projet se situe dans les périmètres de protection suivants : se situe dans le périmètre d''un site patrimonial remarquable';


--
-- Name: COLUMN cerfa.co_abo_monu_hist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_abo_monu_hist IS 'Indiquez si votre projet se situe dans les périmètres de protection suivants : se situe dans les abords d''un monument historique';


--
-- Name: COLUMN cerfa.co_inst_ouvr_trav_act_code_envir; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_inst_ouvr_trav_act_code_envir IS 'Indiquez si votre projet : porte sur une installation, un ouvrage, des travaux ou une activité soumis à déclaration en application du code de l''environnement (IOTA)';


--
-- Name: COLUMN cerfa.co_trav_auto_env; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_trav_auto_env IS 'Indiquez si votre projet : porte sur des travaux soumis à autorisation environnementale en application du L.181-1 du code de l''environnement';


--
-- Name: COLUMN cerfa.co_derog_esp_prot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_derog_esp_prot IS 'Indiquez si votre projet : fait l''objet d’une dérogation au titre du L.411-2 4° du code de l''environnement (dérogation espèces protégées)';


--
-- Name: COLUMN cerfa.ctx_reference_dsj; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.ctx_reference_dsj IS 'Référence DSJ';


--
-- Name: COLUMN cerfa.co_piscine; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_piscine IS 'Piscine [SUPPRIMÉ]';


--
-- Name: COLUMN cerfa.co_fin_lls; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_fin_lls IS 'Mode de financement du projet : Logement Locatif Social';


--
-- Name: COLUMN cerfa.co_fin_aa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_fin_aa IS 'Mode de financement du projet : Accession Sociale (hors prêt à taux zéro)';


--
-- Name: COLUMN cerfa.co_fin_ptz; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_fin_ptz IS 'Mode de financement du projet : Prêt à taux zéro';


--
-- Name: COLUMN cerfa.co_fin_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_fin_autr IS 'Mode de financement du projet : Autres financements';


--
-- Name: COLUMN cerfa.dia_ss_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_ss_date IS 'Document signé le';


--
-- Name: COLUMN cerfa.dia_ss_lieu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_ss_lieu IS 'Document signé à';


--
-- Name: COLUMN cerfa.enga_decla_lieu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.enga_decla_lieu IS 'Engagement du déclarant : lieu de signature';


--
-- Name: COLUMN cerfa.enga_decla_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.enga_decla_date IS 'Engagement du déclarant : date de signature';


--
-- Name: COLUMN cerfa.co_archi_attest_honneur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_archi_attest_honneur IS 'Je déclare sur l''honneur que mon projet entre dans l''une des situations pour lesquelles le recours à l''architecte n''est pas obligatoire';


--
-- Name: COLUMN cerfa.co_bat_niv_dessous_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_bat_niv_dessous_nb IS 'Le nombre de niveaux du bâtiment le plus élevé : au-dessous du sol';


--
-- Name: COLUMN cerfa.co_install_classe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_install_classe IS 'porte sur une installation classée soumise à enregistrement en application de l''article L. 512-7 du code de l''environnement';


--
-- Name: COLUMN cerfa.co_derog_innov; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_derog_innov IS 'déroge à certaines règles de construction et met en œuvre une solution d''effet équivalent au titre de l''ordonnance n° 2018-937 du 30 octobre 2018 visant à faciliter la réalisation de projets de construction et à favoriser l''innovation';


--
-- Name: COLUMN cerfa.co_avis_abf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_avis_abf IS 'relève de l''article L.632-2-1 du code du patrimoine (avis simple de l''architecte des Bâtiments de France pour les antennes-relais et les opérations liées au traitement de l''habitat indigne)';


--
-- Name: COLUMN cerfa.tax_surf_tot_demo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_tot_demo IS 'Surface taxable démolie de la (ou des) construction(s)';


--
-- Name: COLUMN cerfa.tax_surf_tax_demo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_surf_tax_demo IS 'Quelle est la surface taxable démolie ?';


--
-- Name: COLUMN cerfa.tax_terrassement_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_terrassement_arch IS 'Votre projet fait-il l''objet d''un (ou de) terrassement(s) ?';


--
-- Name: COLUMN cerfa.tax_adresse_future_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_adresse_future_numero IS 'Adresse à échéance des taxes : Numéro';


--
-- Name: COLUMN cerfa.tax_adresse_future_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_adresse_future_voie IS 'Adresse à échéance des taxes : Voie';


--
-- Name: COLUMN cerfa.tax_adresse_future_lieudit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_adresse_future_lieudit IS 'Adresse à échéance des taxes : Lieu-dit';


--
-- Name: COLUMN cerfa.tax_adresse_future_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_adresse_future_localite IS 'Adresse à échéance des taxes : Localité';


--
-- Name: COLUMN cerfa.tax_adresse_future_cp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_adresse_future_cp IS 'Adresse à échéance des taxes : Code postal';


--
-- Name: COLUMN cerfa.tax_adresse_future_bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_adresse_future_bp IS 'Adresse à échéance des taxes : BP';


--
-- Name: COLUMN cerfa.tax_adresse_future_cedex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_adresse_future_cedex IS 'Adresse à échéance des taxes : Cedex';


--
-- Name: COLUMN cerfa.tax_adresse_future_pays; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_adresse_future_pays IS 'Adresse à échéance des taxes : Pays';


--
-- Name: COLUMN cerfa.tax_adresse_future_division; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_adresse_future_division IS 'Adresse à échéance des taxes : Division territoriale';


--
-- Name: COLUMN cerfa.co_bat_projete; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_bat_projete IS 'Indiquez la destination, la sous-destination et la localisation approximative des bâtiments projetés dans l''unité foncière';


--
-- Name: COLUMN cerfa.co_bat_existant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_bat_existant IS 'Indiquez la destination et la sous-destination des bâtiments à conserver ou à démolir';


--
-- Name: COLUMN cerfa.co_bat_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_bat_nature IS 'Vous pouvez compléter cette note par des feuilles supplémentaires, des plans, des croquis, des photos. Dans ce cas, précisez ci-dessous la nature et le nombre des pièces fournies';


--
-- Name: COLUMN cerfa.terr_juri_titul_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.terr_juri_titul_date IS 'Si oui, à quelle date a t-il été délivré ?';


--
-- Name: COLUMN cerfa.co_autre_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_autre_desc IS 'Autres travaux envisagés (précisez) [SUPPRIMÉ]';


--
-- Name: COLUMN cerfa.co_trx_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_trx_autre IS 'Travaux comprennent notamment : Autre (précisez)';


--
-- Name: COLUMN cerfa.co_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_autre IS 'Autres travaux envisagés [SUPPRIMÉ]';


--
-- Name: COLUMN cerfa.erp_modif_facades; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_modif_facades IS 'Modification des accès en façades';


--
-- Name: COLUMN cerfa.erp_trvx_adap; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_trvx_adap IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement';


--
-- Name: COLUMN cerfa.erp_trvx_adap_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_trvx_adap_numero IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement : Ad''AP n°';


--
-- Name: COLUMN cerfa.erp_trvx_adap_valid; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_trvx_adap_valid IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement : validé le';


--
-- Name: COLUMN cerfa.erp_prod_dangereux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.erp_prod_dangereux IS 'Cette demande fait l''objet d''une déclaration ou autorisation au titre du code de l''environnement (produits dangereux stockés ou utilisés)';


--
-- Name: COLUMN cerfa.co_trav_supp_dessus; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_trav_supp_dessus IS 'Création de niveaux supplémentaires : au-dessus du sol';


--
-- Name: COLUMN cerfa.co_trav_supp_dessous; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.co_trav_supp_dessous IS 'Création de niveaux supplémentaires : au-dessous du sol';


--
-- Name: COLUMN cerfa.tax_su_habit_abr_jard_pig_colom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.tax_su_habit_abr_jard_pig_colom IS 'Création de locaux destinés à l''habitation : Parmi les surfaces déclarées ci-dessus, quelle est la surface affectée à la catégorie des abris de jardin, pigeonniers et colombiers (en m²) ?';


--
-- Name: COLUMN cerfa.enga_decla_donnees_nomi_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.enga_decla_donnees_nomi_comm IS 'Pour permettre l''utilisation des informations nominatives comprises dans ce formulaire à des fins commerciales, cochez la case ci-contre [SUPPRIMÉ]';


--
-- Name: COLUMN cerfa.x1l_legislation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.x1l_legislation IS 'Indiquez si votre projet : a déjà fait l''objet d''une demande d''autorisation ou d''une déclaration au titre d''une autre législation que celle du code de l''urbanisme';


--
-- Name: COLUMN cerfa.x1p_precisions; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.x1p_precisions IS 'Indiquez si votre projet : a déjà fait l''objet d''une demande d''autorisation ou d''une déclaration au titre d''une autre législation que celle du code de l''urbanisme (Précisez laquelle)';


--
-- Name: COLUMN cerfa.x1u_raccordement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.x1u_raccordement IS 'Indiquez si votre projet : est soumis à une obligation de raccordement à un réseau de chaleur et de froid prévue à l''article L.712-3 du code de l''énergie';


--
-- Name: COLUMN cerfa.x2m_inscritmh; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.x2m_inscritmh IS 'Indiquez si votre projet : porte sur un immeuble inscrit au titre des monuments historiques';


--
-- Name: COLUMN cerfa.s1na1_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1na1_numero IS 'Adresse 1 des aires de stationnement : numéro';


--
-- Name: COLUMN cerfa.s1va1_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1va1_voie IS 'Adresse 1 des aires de stationnement : voie';


--
-- Name: COLUMN cerfa.s1wa1_lieudit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1wa1_lieudit IS 'Adresse 1 des aires de stationnement : lieu-dit';


--
-- Name: COLUMN cerfa.s1la1_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1la1_localite IS 'Adresse 1 des aires de stationnement : localité';


--
-- Name: COLUMN cerfa.s1pa1_codepostal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1pa1_codepostal IS 'Adresse 1 des aires de stationnement : code postal';


--
-- Name: COLUMN cerfa.s1na2_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1na2_numero IS 'Adresse 2 des aires de stationnement : numéro';


--
-- Name: COLUMN cerfa.s1va2_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1va2_voie IS 'Adresse 2 des aires de stationnement : voie';


--
-- Name: COLUMN cerfa.s1wa2_lieudit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1wa2_lieudit IS 'Adresse 2 des aires de stationnement : lieu-dit';


--
-- Name: COLUMN cerfa.s1la2_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1la2_localite IS 'Adresse 2 des aires de stationnement : localité';


--
-- Name: COLUMN cerfa.s1pa2_codepostal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.s1pa2_codepostal IS 'Adresse 2 des aires de stationnement : code postal';


--
-- Name: COLUMN cerfa.e3c_certification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.e3c_certification IS 'En application de l''article L.441-4 du code de l''urbanisme, je certifie avoir fait appel aux compétences nécessaires en matière d''architecture, d''urbanisme et de paysage pour l''établissement du projet architectural, paysager et environnemental.';


--
-- Name: COLUMN cerfa.e3a_competence; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.e3a_competence IS 'Si la surface du terrain à aménager est supérieure à 2 500 m², je certifie qu''un architecte au sens de l''article 9 de la loi n° 77-2 du 3 janvier 1977 sur l''architecture, ou qu''un paysagiste-concepteur au sens de l''article 174 de la loi n° 2016-1087 du 8 août 2016 pour la reconquête de la biodiversité, de la nature et des paysages, a participé à l''établissement du projet architectural, paysager et environnemental.';


--
-- Name: COLUMN cerfa.a4d_description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.a4d_description IS 'Courte description du lieu concerné';


--
-- Name: COLUMN cerfa.m2b_abf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.m2b_abf IS 'Dossier transmis : Coche à l''Architecte des Bâtiments de France';


--
-- Name: COLUMN cerfa.m2j_pn; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.m2j_pn IS 'Dossier transmis : Coche au Directeur du Parc National';


--
-- Name: COLUMN cerfa.m2r_cdac; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.m2r_cdac IS 'Dossier transmis : Coche au Secrétaire de la Commission Départementale d''Aménagement Commercial ';


--
-- Name: COLUMN cerfa.m2r_cnac; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.m2r_cnac IS 'Dossier transmis : Coche au Secrétaire de la Commission Nationale d''Aménagement Commercial';


--
-- Name: COLUMN cerfa.u3a_voirieoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u3a_voirieoui IS 'Voirie : Coche Oui';


--
-- Name: COLUMN cerfa.u3f_voirienon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u3f_voirienon IS 'Voirie : Coche Non';


--
-- Name: COLUMN cerfa.u3c_eauoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u3c_eauoui IS 'Eau potable : Coche Oui';


--
-- Name: COLUMN cerfa.u3h_eaunon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u3h_eaunon IS 'Eau potable : Coche Non';


--
-- Name: COLUMN cerfa.u3g_assainissementoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u3g_assainissementoui IS 'Assainissement : Coche Oui';


--
-- Name: COLUMN cerfa.u3n_assainissementnon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u3n_assainissementnon IS 'Assainissement : Coche Non';


--
-- Name: COLUMN cerfa.u3m_electriciteoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u3m_electriciteoui IS 'Électricité : Coche Oui';


--
-- Name: COLUMN cerfa.u3b_electricitenon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u3b_electricitenon IS 'Électricité : Coche Non';


--
-- Name: COLUMN cerfa.u3t_observations; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u3t_observations IS 'Observations';


--
-- Name: COLUMN cerfa.u1a_voirieoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1a_voirieoui IS 'Équipements, Voirie : Coche Oui';


--
-- Name: COLUMN cerfa.u1v_voirienon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1v_voirienon IS 'Équipements, Voirie : Coche Non';


--
-- Name: COLUMN cerfa.u1q_voirieconcessionnaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1q_voirieconcessionnaire IS 'Équipements, Voirie : Par quel service ou concessionnaire ?';


--
-- Name: COLUMN cerfa.u1b_voirieavant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1b_voirieavant IS 'Équipements, Voirie : Avant le';


--
-- Name: COLUMN cerfa.u1j_eauoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1j_eauoui IS 'Équipements, Eau potable : Coche Oui';


--
-- Name: COLUMN cerfa.u1t_eaunon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1t_eaunon IS 'Équipements, Eau potable : Coche Non';


--
-- Name: COLUMN cerfa.u1e_eauconcessionnaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1e_eauconcessionnaire IS 'Équipements, Eau potable : Par quel service ou concessionnaire ?';


--
-- Name: COLUMN cerfa.u1k_eauavant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1k_eauavant IS 'Équipements, Eau potable : Avant le';


--
-- Name: COLUMN cerfa.u1s_assainissementoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1s_assainissementoui IS 'Équipements, Assainissement : Coche Oui';


--
-- Name: COLUMN cerfa.u1d_assainissementnon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1d_assainissementnon IS 'Équipements, Assainissement : Coche Non';


--
-- Name: COLUMN cerfa.u1l_assainissementconcessionnaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1l_assainissementconcessionnaire IS 'Équipements, Assainissement : Par quel service ou concessionnaire ?';


--
-- Name: COLUMN cerfa.u1r_assainissementavant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1r_assainissementavant IS 'Équipements, Assainissement : Avant le';


--
-- Name: COLUMN cerfa.u1c_electriciteoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1c_electriciteoui IS 'Équipement Électricité : Coche Oui';


--
-- Name: COLUMN cerfa.u1u_electricitenon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1u_electricitenon IS 'Équipement Électricité : Coche Non';


--
-- Name: COLUMN cerfa.u1m_electriciteconcessionnaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1m_electriciteconcessionnaire IS 'Équipement Électricité : Par quel service ou concessionnaire ?';


--
-- Name: COLUMN cerfa.u1f_electriciteavant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u1f_electriciteavant IS 'Équipement Électricité : Avant le';


--
-- Name: COLUMN cerfa.u2a_observations; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.u2a_observations IS 'Observations';


--
-- Name: COLUMN cerfa.f1ts4_surftaxestation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.f1ts4_surftaxestation IS 'Surface taxable créée des parcs de stationnement couverts faisant l''objet d''une exploitation commerciale, ainsi que des locaux clos et couverts à usage de stationnement non situés dans la verticalité du bâti (en m²)';


--
-- Name: COLUMN cerfa.f1ut1_surfcree; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.f1ut1_surfcree IS 'Surface taxable créée des locaux clos et couverts à usage de stationnement situés dans la verticalité du bâti (en m²)';


--
-- Name: COLUMN cerfa.f9d_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.f9d_date IS 'Déclaration des éléments nécessaires au calcul des impositions : Date de la déclaration';


--
-- Name: COLUMN cerfa.f9n_nom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.f9n_nom IS 'Déclaration des éléments nécessaires au calcul des impositions : Nom du déclarant';


--
-- Name: COLUMN cerfa.dia_droit_reel_perso_grevant_bien_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_droit_reel_perso_grevant_bien_desc IS 'Grevant les biens : description';


--
-- Name: COLUMN cerfa.dia_mod_cess_paie_nat_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_paie_nat_desc IS 'Paiement en nature : description';


--
-- Name: COLUMN cerfa.dia_mod_cess_rente_viag_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_rente_viag_desc IS 'Rente viagère : description';


--
-- Name: COLUMN cerfa.dia_mod_cess_echange_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_echange_desc IS 'Echange : description';


--
-- Name: COLUMN cerfa.dia_mod_cess_apport_societe_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_apport_societe_desc IS 'Apport en société : description';


--
-- Name: COLUMN cerfa.dia_mod_cess_cess_terr_loc_co_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_cess_terr_loc_co_desc IS 'Cession de tantième de terrains contre remise de locaux à construire : description';


--
-- Name: COLUMN cerfa.dia_mod_cess_esti_imm_loca_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_esti_imm_loca_desc IS 'Location-accession – Estimation de l''immeuble objet de la location-accession : description';


--
-- Name: COLUMN cerfa.dia_mod_cess_adju_obl_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_adju_obl_desc IS 'Rendue obligatoire par une disposition législative ou réglementaire : description';


--
-- Name: COLUMN cerfa.dia_mod_cess_adju_fin_indivi_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_adju_fin_indivi_desc IS 'Mettant fin à une indivision ne résultant pas d''une donation-partage : description';


--
-- Name: COLUMN cerfa.dia_cadre_titul_droit_prempt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_cadre_titul_droit_prempt IS 'Cadre réservé au titulaire du droit de préemption';


--
-- Name: COLUMN cerfa.dia_mairie_prix_moyen; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mairie_prix_moyen IS 'Prix moyen au m²';


--
-- Name: COLUMN cerfa.dia_propri_indivi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_propri_indivi IS 'Si le bien est en indivision, indiquer le(s) nom(s)de l''(des) autres co-indivisaires et sa (leur) quote-part (7)';


--
-- Name: COLUMN cerfa.dia_situa_bien_plan_cadas_oui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_situa_bien_plan_cadas_oui IS 'Plan(s) cadastral(aux) joint(s) : OUI';


--
-- Name: COLUMN cerfa.dia_situa_bien_plan_cadas_non; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_situa_bien_plan_cadas_non IS 'Plan(s) cadastral(aux) joint(s) : NON';


--
-- Name: COLUMN cerfa.dia_notif_dec_titul_adr_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_notif_dec_titul_adr_prop IS 'A l''adresse du (des) propriétaire(s) mentionné(s) à la rubrique A';


--
-- Name: COLUMN cerfa.dia_notif_dec_titul_adr_prop_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_notif_dec_titul_adr_prop_desc IS 'A l''adresse du (des) propriétaire(s) mentionné(s) à la rubrique A : description';


--
-- Name: COLUMN cerfa.dia_notif_dec_titul_adr_manda; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_notif_dec_titul_adr_manda IS 'A l''adresse du mandataire mentionnée à la rubrique H, adresse où le(s) propriétaire(s) a (ont) fait élection de domicile';


--
-- Name: COLUMN cerfa.dia_notif_dec_titul_adr_manda_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_notif_dec_titul_adr_manda_desc IS 'A l''adresse du mandataire mentionnée à la rubrique H, adresse où le(s) propriétaire(s) a (ont) fait élection de domicile : description';


--
-- Name: COLUMN cerfa.dia_dia_dpu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_dia_dpu IS 'Soumis au droit de préemption urbain (D.P.U) (articles L. 211-1 et suivants du Code de l''urbanisme (2))';


--
-- Name: COLUMN cerfa.dia_dia_zad; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_dia_zad IS 'Compris dans une zone d''aménagement différé (Z.A.D.) (articles L.212-1- et suivants du Code de l''urbanisme (3))';


--
-- Name: COLUMN cerfa.dia_dia_zone_preempt_esp_natu_sensi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_dia_zone_preempt_esp_natu_sensi IS 'Compris dans une zone de préemption délimitée au titre des espaces naturels sensibles de départements (articles L. 142-1- et suivants du Code de l''urbanisme(4))';


--
-- Name: COLUMN cerfa.dia_dab_dpu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_dab_dpu IS 'Soumis au droit de préemption urbain (D.P.U.) (2)';


--
-- Name: COLUMN cerfa.dia_dab_zad; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_dab_zad IS 'Compris dans une zone d''aménagement différé (Z.A.D.) (3)';


--
-- Name: COLUMN cerfa.dia_mod_cess_commi_mnt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_commi_mnt IS 'Montant de la commision';


--
-- Name: COLUMN cerfa.dia_mod_cess_commi_mnt_ttc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_commi_mnt_ttc IS 'Le montant de la commission est TTC';


--
-- Name: COLUMN cerfa.dia_mod_cess_commi_mnt_ht; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_commi_mnt_ht IS 'Le montant de la commission est HT';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_num IS 'Prix de vente ou évaluation (chiffres)';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente_mob_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_mob_num IS 'Dont éventuellement inclus : Mobilier (chiffres)';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente_cheptel_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_cheptel_num IS 'Dont éventuellement inclus : Cheptel (chiffres)';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente_recol_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_recol_num IS 'Dont éventuellement inclus : Récoltes (chiffres)';


--
-- Name: COLUMN cerfa.dia_mod_cess_prix_vente_autre_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_autre_num IS 'Dont éventuellement inclus : Autres (chiffres)';


--
-- Name: COLUMN cerfa.dia_su_co_sol_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_su_co_sol_num IS 'Surface construite au sol (m2) (chiffres)';


--
-- Name: COLUMN cerfa.dia_su_util_hab_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_su_util_hab_num IS 'Surface utile ou habitable (m2) (chiffres)';


--
-- Name: COLUMN cerfa.dia_mod_cess_mnt_an_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_an_num IS 'Montant annuel (chiffres)';


--
-- Name: COLUMN cerfa.dia_mod_cess_mnt_compt_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_compt_num IS 'Montant comptant (chiffres)';


--
-- Name: COLUMN cerfa.dia_mod_cess_mnt_soulte_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_soulte_num IS 'Montant de la soulte le cas échéant (chiffres)';


--
-- Name: COLUMN cerfa.dia_comp_prix_vente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_comp_prix_vente IS 'Correspondant au prix détaillé par le vendeur dans le cadre F';


--
-- Name: COLUMN cerfa.dia_comp_surface; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_comp_surface IS 'correspondant aux champs du cerfa "surface utile ou habitable du bien" et/ou "surface au sol" tel que déclarée dans le cadre C';


--
-- Name: COLUMN cerfa.dia_comp_total_frais; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_comp_total_frais IS 'en l''absence de données saisies dans le cerfa sur les frais de notaire notamment, ce champ correspond au montant saisi dans le champ commission  situé dans le cadre F';


--
-- Name: COLUMN cerfa.dia_comp_mtn_total; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_comp_mtn_total IS 'Montant total (en €) (correspondant à l''addition du champ prix de vente et du champ total des frais)';


--
-- Name: COLUMN cerfa.dia_comp_valeur_m2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_comp_valeur_m2 IS 'Valeur au m² (en €) (modélisation du prix au m² correspondant au champ surface divisé par le champ total)';


--
-- Name: COLUMN cerfa.dia_esti_prix_france_dom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_esti_prix_france_dom IS 'Estimation du prix de vente par France Domaine';


--
-- Name: COLUMN cerfa.dia_prop_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_prop_collectivite IS 'Proposition d''acquisition de la collectivité';


--
-- Name: COLUMN cerfa.dia_delegataire_denomination; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_denomination IS 'Délégataire à l''instruction de la demande : Dénomination';


--
-- Name: COLUMN cerfa.dia_delegataire_raison_sociale; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_raison_sociale IS 'Délégataire à l''instruction de la demande : Raison sociale';


--
-- Name: COLUMN cerfa.dia_delegataire_siret; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_siret IS 'Délégataire à l''instruction de la demande : Siret';


--
-- Name: COLUMN cerfa.dia_delegataire_categorie_juridique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_categorie_juridique IS 'Délégataire à l''instruction de la demande : Catégorie juridique';


--
-- Name: COLUMN cerfa.dia_delegataire_representant_nom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_representant_nom IS 'Délégataire à l''instruction de la demande : Nom du représentant';


--
-- Name: COLUMN cerfa.dia_delegataire_representant_prenom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_representant_prenom IS 'Délégataire à l''instruction de la demande : Prénom du représentant';


--
-- Name: COLUMN cerfa.dia_delegataire_adresse_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_adresse_numero IS 'Délégataire à l''instruction de la demande : Adresse : Numéro';


--
-- Name: COLUMN cerfa.dia_delegataire_adresse_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_adresse_voie IS 'Délégataire à l''instruction de la demande : Adresse : Voie';


--
-- Name: COLUMN cerfa.dia_delegataire_adresse_complement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_adresse_complement IS 'Délégataire à l''instruction de la demande : Adresse : Complément';


--
-- Name: COLUMN cerfa.dia_delegataire_adresse_lieu_dit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_adresse_lieu_dit IS 'Délégataire à l''instruction de la demande : Adresse : Lieu-dit';


--
-- Name: COLUMN cerfa.dia_delegataire_adresse_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_adresse_localite IS 'Délégataire à l''instruction de la demande : Adresse : Localité';


--
-- Name: COLUMN cerfa.dia_delegataire_adresse_code_postal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_adresse_code_postal IS 'Délégataire à l''instruction de la demande : Adresse : Code postal';


--
-- Name: COLUMN cerfa.dia_delegataire_adresse_bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_adresse_bp IS 'Délégataire à l''instruction de la demande : Adresse : BP';


--
-- Name: COLUMN cerfa.dia_delegataire_adresse_cedex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_adresse_cedex IS 'Délégataire à l''instruction de la demande : Adresse : Cedex';


--
-- Name: COLUMN cerfa.dia_delegataire_adresse_pays; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_adresse_pays IS 'Délégataire à l''instruction de la demande : Adresse : Pays';


--
-- Name: COLUMN cerfa.dia_delegataire_telephone_fixe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_telephone_fixe IS 'Délégataire à l''instruction de la demande : Téléphone fixe';


--
-- Name: COLUMN cerfa.dia_delegataire_telephone_mobile; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_telephone_mobile IS 'Délégataire à l''instruction de la demande : Téléphone mobile';


--
-- Name: COLUMN cerfa.dia_delegataire_telephone_mobile_indicatif; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_telephone_mobile_indicatif IS 'Délégataire à l''instruction de la demande : Indicatif';


--
-- Name: COLUMN cerfa.dia_delegataire_courriel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_courriel IS 'Délégataire à l''instruction de la demande : Courriel';


--
-- Name: COLUMN cerfa.dia_delegataire_fax; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_delegataire_fax IS 'Délégataire à l''instruction de la demande : Fax';


--
-- Name: COLUMN cerfa.dia_entree_jouissance_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_entree_jouissance_type IS 'Entrée en jouissance : Type';


--
-- Name: COLUMN cerfa.dia_entree_jouissance_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_entree_jouissance_date IS 'Entrée en jouissance : Date';


--
-- Name: COLUMN cerfa.dia_entree_jouissance_date_effet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_entree_jouissance_date_effet IS 'Entrée en jouissance : Date d''effet';


--
-- Name: COLUMN cerfa.dia_entree_jouissance_com; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_entree_jouissance_com IS 'Entrée en jouissance : Commentaire';


--
-- Name: COLUMN cerfa.dia_remise_bien_date_effet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_remise_bien_date_effet IS 'Remise du bien: Date d''effet';


--
-- Name: COLUMN cerfa.dia_remise_bien_com; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.dia_remise_bien_com IS 'Remise du bien: Commentaire';


--
-- Name: COLUMN cerfa.c2zp1_crete; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.c2zp1_crete IS '[Si votre projet est un ouvrage de production d''électricité à partir de l''énergie solaire installé sur le sol] Indiquez sa puissance crête';


--
-- Name: COLUMN cerfa.c2zr1_destination; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.c2zr1_destination IS '[Si votre projet est un ouvrage de production d''électricité à partir de l''énergie solaire installé sur le sol] Indiquez la destination principale de l''énergie solaire';


--
-- Name: COLUMN cerfa.mh_design_appel_denom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_design_appel_denom IS 'Appellation / dénomination';


--
-- Name: COLUMN cerfa.mh_design_type_protect; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_design_type_protect IS 'Type de protection : classé, inscrit, classé et inscrit';


--
-- Name: COLUMN cerfa.mh_design_elem_prot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_design_elem_prot IS 'Élément(s) protégé(s)';


--
-- Name: COLUMN cerfa.mh_design_ref_merimee_palissy; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_design_ref_merimee_palissy IS 'Référence Mérimée';


--
-- Name: COLUMN cerfa.mh_design_nature_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_design_nature_prop IS 'Nature de la propriété : privée, publique, privée et publique';


--
-- Name: COLUMN cerfa.mh_loc_denom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_loc_denom IS 'Dénomination de l’immeuble';


--
-- Name: COLUMN cerfa.mh_pres_intitule; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_pres_intitule IS 'Intitulé de l’opération';


--
-- Name: COLUMN cerfa.mh_trav_cat_1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_1 IS 'Catégorie des travaux prévus : Fondations, sous-sol';


--
-- Name: COLUMN cerfa.mh_trav_cat_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_2 IS 'Catégorie des travaux prévus : Structure, maçonnerie, gros-œuvre';


--
-- Name: COLUMN cerfa.mh_trav_cat_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_3 IS 'Catégorie des travaux prévus : Parements, enduits, restauration de façades';


--
-- Name: COLUMN cerfa.mh_trav_cat_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_4 IS 'Catégorie des travaux prévus : Charpente, couverture';


--
-- Name: COLUMN cerfa.mh_trav_cat_5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_5 IS 'Catégorie des travaux prévus : Menuiseries, métallerie, vitraux';


--
-- Name: COLUMN cerfa.mh_trav_cat_6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_6 IS 'Catégorie des travaux prévus : Cloisons, revêtements intérieurs, décors';


--
-- Name: COLUMN cerfa.mh_trav_cat_7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_7 IS 'Catégorie des travaux prévus : Équipements techniques, sécurité, sureté, accessibilité';


--
-- Name: COLUMN cerfa.mh_trav_cat_8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_8 IS 'Catégorie des travaux prévus : Voirie et réseaux divers';


--
-- Name: COLUMN cerfa.mh_trav_cat_9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_9 IS 'Catégorie des travaux prévus : Affouillements ou exhaussements';


--
-- Name: COLUMN cerfa.mh_trav_cat_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_10 IS 'Catégorie des travaux prévus : Sculptures';


--
-- Name: COLUMN cerfa.mh_trav_cat_11; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_11 IS 'Catégorie des travaux prévus : Parcs, jardins et bois';


--
-- Name: COLUMN cerfa.mh_trav_cat_12; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_12 IS 'Catégorie des travaux prévus : Autres, préciser';


--
-- Name: COLUMN cerfa.mh_trav_cat_12_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN cerfa.mh_trav_cat_12_prec IS 'Catégorie des travaux prévus : Autres, préciser';


--
-- Name: cerfa_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE cerfa_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: cerfa_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE cerfa_seq OWNED BY cerfa.cerfa;


--
-- Name: civilite; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE civilite (
    code character varying(20) NOT NULL,
    civilite integer NOT NULL,
    libelle character varying(100),
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE civilite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE civilite IS 'Titre de civilité';


--
-- Name: COLUMN civilite.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN civilite.code IS 'Code de la civilité';


--
-- Name: COLUMN civilite.civilite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN civilite.civilite IS 'Identifiant unique';


--
-- Name: COLUMN civilite.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN civilite.libelle IS 'Libellé de la civilité';


--
-- Name: COLUMN civilite.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN civilite.om_validite_debut IS 'Date de début de validité de la civilité';


--
-- Name: COLUMN civilite.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN civilite.om_validite_fin IS 'Date de fin de validité de la civilité';


--
-- Name: civilite_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE civilite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: civilite_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE civilite_seq OWNED BY civilite.civilite;


--
-- Name: commission; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE commission (
    commission integer NOT NULL,
    code character varying(20),
    commission_type integer NOT NULL,
    libelle character varying(100),
    date_commission date NOT NULL,
    heure_commission character varying(5),
    lieu_adresse_ligne1 character varying(100),
    lieu_adresse_ligne2 character varying(100),
    lieu_salle character varying(100),
    listes_de_diffusion text,
    participants text,
    om_fichier_commission_ordre_jour character varying(255),
    om_final_commission_ordre_jour boolean,
    om_fichier_commission_compte_rendu character varying(255),
    om_final_commission_compte_rendu boolean,
    om_collectivite integer NOT NULL
);


--
-- Name: TABLE commission; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE commission IS 'Demande de passage en commission';


--
-- Name: COLUMN commission.commission; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.commission IS 'Identifiant unique';


--
-- Name: COLUMN commission.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.code IS 'Code de la commission';


--
-- Name: COLUMN commission.commission_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.commission_type IS 'Type de la commission';


--
-- Name: COLUMN commission.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.libelle IS 'Libellé de la commission';


--
-- Name: COLUMN commission.date_commission; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.date_commission IS 'Date de passage de la commission';


--
-- Name: COLUMN commission.heure_commission; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.heure_commission IS 'Heure de passage de la commission';


--
-- Name: COLUMN commission.lieu_adresse_ligne1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.lieu_adresse_ligne1 IS 'Adresse de passage de la commission';


--
-- Name: COLUMN commission.lieu_adresse_ligne2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.lieu_adresse_ligne2 IS 'Complément d''adresse de passage de la commission';


--
-- Name: COLUMN commission.lieu_salle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.lieu_salle IS 'Salle de passage de la commission';


--
-- Name: COLUMN commission.listes_de_diffusion; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.listes_de_diffusion IS 'Liste des emails à notifier pour le compte rendu de la commission';


--
-- Name: COLUMN commission.participants; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.participants IS 'Participants à la commission';


--
-- Name: COLUMN commission.om_fichier_commission_ordre_jour; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.om_fichier_commission_ordre_jour IS 'Identifiant du fichier de l''ordre du jour de la commission finalisé dans le système de stockage';


--
-- Name: COLUMN commission.om_final_commission_ordre_jour; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.om_final_commission_ordre_jour IS 'Permet de savoir si le fichier de l''ordre du jour de la commission est finalisé';


--
-- Name: COLUMN commission.om_fichier_commission_compte_rendu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.om_fichier_commission_compte_rendu IS 'Identifiant du fichier du compte rendu de la commission finalisé dans le système de stockage';


--
-- Name: COLUMN commission.om_final_commission_compte_rendu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.om_final_commission_compte_rendu IS 'Permet de savoir si le fichier du compte rendu de la commission est finalisé';


--
-- Name: COLUMN commission.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission.om_collectivite IS 'Lien vers la collectivité concernée';


--
-- Name: commission_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE commission_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: commission_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE commission_seq OWNED BY commission.commission;


--
-- Name: commission_type; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE commission_type (
    commission_type integer NOT NULL,
    code character varying(10),
    libelle character varying(100),
    lieu_adresse_ligne1 character varying(150),
    lieu_adresse_ligne2 character varying(100),
    lieu_salle character varying(100),
    listes_de_diffusion text,
    participants text,
    corps_du_courriel text,
    om_validite_debut date,
    om_validite_fin date,
    om_collectivite integer NOT NULL
);


--
-- Name: TABLE commission_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE commission_type IS 'Les types de commission';


--
-- Name: COLUMN commission_type.commission_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.commission_type IS 'Identifiant unique';


--
-- Name: COLUMN commission_type.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.code IS 'Code du type de commission';


--
-- Name: COLUMN commission_type.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.libelle IS 'Libellé du type de commission';


--
-- Name: COLUMN commission_type.lieu_adresse_ligne1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.lieu_adresse_ligne1 IS 'Adresse des commissions de ce type';


--
-- Name: COLUMN commission_type.lieu_adresse_ligne2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.lieu_adresse_ligne2 IS 'Complément d''adresse des commissions de ce type';


--
-- Name: COLUMN commission_type.lieu_salle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.lieu_salle IS 'Salle où ont lieu les commissions de ce type';


--
-- Name: COLUMN commission_type.listes_de_diffusion; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.listes_de_diffusion IS 'Liste de diffusion des commissions de ce type';


--
-- Name: COLUMN commission_type.participants; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.participants IS 'Participants aux commissions de ce type';


--
-- Name: COLUMN commission_type.corps_du_courriel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.corps_du_courriel IS 'Corps du courriel diffusé à la liste de diffusion des commissions de ce type';


--
-- Name: COLUMN commission_type.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.om_validite_debut IS 'Date de début de validité de ce type de commission';


--
-- Name: COLUMN commission_type.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.om_validite_fin IS 'Date de fin de validité de ce type de commission';


--
-- Name: COLUMN commission_type.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commission_type.om_collectivite IS 'Lien vers la collectivité concernée';


--
-- Name: commission_type_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE commission_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: commission_type_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE commission_type_seq OWNED BY commission_type.commission_type;


--
-- Name: commune; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE commune (
    commune integer NOT NULL,
    typecom character varying(4),
    com character varying(5) NOT NULL,
    reg character varying(2) NOT NULL,
    dep character varying(3) NOT NULL,
    arr character varying(4),
    tncc character varying(1),
    ncc character varying(200),
    nccenr character varying(200),
    libelle character varying(45),
    can character varying(5),
    comparent character varying(5),
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: COLUMN commune.commune; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.commune IS 'Identifiant technique de la commune';


--
-- Name: COLUMN commune.typecom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.typecom IS 'Type de commune';


--
-- Name: COLUMN commune.com; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.com IS 'Code INSEE de la commune';


--
-- Name: COLUMN commune.reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.reg IS 'Code INSEE de la région';


--
-- Name: COLUMN commune.dep; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.dep IS 'Code INSEE du département';


--
-- Name: COLUMN commune.arr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.arr IS 'Code d’arrondissement sur 3 caractères (métropole) ou 4';


--
-- Name: COLUMN commune.tncc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.tncc IS 'Type de nom en clair';


--
-- Name: COLUMN commune.ncc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.ncc IS 'Nom en clair (majuscules)';


--
-- Name: COLUMN commune.nccenr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.nccenr IS 'Nom en typographie riche';


--
-- Name: COLUMN commune.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.libelle IS 'Nom en typographie riche avec article';


--
-- Name: COLUMN commune.can; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.can IS 'Code canton. Pour les communes « multi-cantonales » code décliné de 99 à 90 (pseudo-canton) ou de 89 à 80 (communes nouvelles)';


--
-- Name: COLUMN commune.comparent; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.comparent IS 'Code de la commune parente pour les arrondissements municipaux et les communes associées ou déléguées.';


--
-- Name: COLUMN commune.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.om_validite_debut IS 'Date de validité (début)';


--
-- Name: COLUMN commune.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN commune.om_validite_fin IS 'Date de validité (fin)';


--
-- Name: commune_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE commune_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: commune_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE commune_seq OWNED BY commune.commune;


--
-- Name: compteur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE compteur (
    compteur integer NOT NULL,
    code character varying(150) NOT NULL,
    description character varying(300) NOT NULL,
    unite character varying(10),
    quantite double precision NOT NULL,
    quota double precision NOT NULL,
    alerte double precision,
    om_collectivite integer NOT NULL,
    date_modification timestamp without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL,
    om_validite_debut date NOT NULL,
    om_validite_fin date
);


--
-- Name: COLUMN compteur.compteur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.compteur IS 'Identifiant technique interne du compteur';


--
-- Name: COLUMN compteur.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.code IS 'Code métier du compteur';


--
-- Name: COLUMN compteur.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.description IS 'Description des données décomptées';


--
-- Name: COLUMN compteur.unite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.unite IS 'Unité de mesure du compteur';


--
-- Name: COLUMN compteur.quantite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.quantite IS 'Valeur du compteur';


--
-- Name: COLUMN compteur.quota; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.quota IS 'Seuil au delà duquel le client est hors contrat';


--
-- Name: COLUMN compteur.alerte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.alerte IS 'Seuil au delà duquel l''utilisateur est averti qu''il se rapproche du quota';


--
-- Name: COLUMN compteur.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.om_collectivite IS 'Identifiant de la collectivité';


--
-- Name: COLUMN compteur.date_modification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.date_modification IS 'Date de dernière modification du compteur';


--
-- Name: COLUMN compteur.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.om_validite_debut IS 'Date de début de validité du compteur';


--
-- Name: COLUMN compteur.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN compteur.om_validite_fin IS 'Date de fin de validité du compteur';


--
-- Name: compteur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE compteur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: compteur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE compteur_seq OWNED BY compteur.compteur;


--
-- Name: consultation; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE consultation (
    consultation integer NOT NULL,
    dossier character varying(30) NOT NULL,
    date_envoi date NOT NULL,
    date_retour date,
    date_limite date,
    service integer,
    avis_consultation integer,
    date_reception date,
    motivation text DEFAULT ''::text,
    fichier character varying(255),
    lu boolean,
    code_barres character varying(12),
    om_fichier_consultation character varying(255),
    om_final_consultation boolean,
    marque boolean DEFAULT false,
    visible boolean DEFAULT true NOT NULL,
    om_fichier_consultation_dossier_final boolean DEFAULT false,
    fichier_dossier_final boolean DEFAULT false,
    texte_fondement_avis text,
    texte_avis text,
    texte_hypotheses text,
    nom_auteur character varying(255),
    prenom_auteur character varying(255),
    qualite_auteur character varying(255),
    categorie_tiers_consulte integer,
    tiers_consulte integer,
    motif_consultation integer,
    commentaire text,
    fichier_pec character varying(250),
    motif_pec text
);


--
-- Name: TABLE consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE consultation IS 'Demande de consultation d''un dossier d''instruction à un service';


--
-- Name: COLUMN consultation.consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.consultation IS 'Identifiant unique';


--
-- Name: COLUMN consultation.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.dossier IS 'Dossier d''instruction sur lequel il y a la demande de consultation';


--
-- Name: COLUMN consultation.date_envoi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.date_envoi IS 'Date d''envoi de la consultation';


--
-- Name: COLUMN consultation.date_retour; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.date_retour IS 'Date de retour de la consultation';


--
-- Name: COLUMN consultation.date_limite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.date_limite IS 'Date limite pour la consultation';


--
-- Name: COLUMN consultation.service; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.service IS 'Service demandé pour la consultation';


--
-- Name: COLUMN consultation.avis_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.avis_consultation IS 'Avis de la consultation';


--
-- Name: COLUMN consultation.date_reception; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.date_reception IS 'Date de réception de la consultation';


--
-- Name: COLUMN consultation.motivation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.motivation IS 'Motivation du service pour l''avis rendu sur la consultation';


--
-- Name: COLUMN consultation.fichier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.fichier IS 'Document joint à la réponse de consultation';


--
-- Name: COLUMN consultation.lu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.lu IS 'Indique que la demande de consultation a été lue';


--
-- Name: COLUMN consultation.code_barres; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.code_barres IS 'Code barres de la consultation';


--
-- Name: COLUMN consultation.om_fichier_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.om_fichier_consultation IS 'Document résumé de la consultation';


--
-- Name: COLUMN consultation.om_final_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.om_final_consultation IS 'Document résumé de la consultation finalisée';


--
-- Name: COLUMN consultation.visible; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.visible IS 'Si vrai, la consultation apparaît dans les éditions faisant appel au sous-état Liste des consultations par dossier.';


--
-- Name: COLUMN consultation.om_fichier_consultation_dossier_final; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.om_fichier_consultation_dossier_final IS 'Identifie que le document généré constitue dossier final';


--
-- Name: COLUMN consultation.fichier_dossier_final; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.fichier_dossier_final IS 'Identifie que le document en pièce jointe constitue dossier final';


--
-- Name: COLUMN consultation.texte_fondement_avis; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.texte_fondement_avis IS 'Texte indiquant le(s) article(s) réglementaire(s) sur le(s)quel(s) se fonde l''avis';


--
-- Name: COLUMN consultation.texte_avis; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.texte_avis IS 'Texte qui permet de préciser l''avis, à la manière du texte figurant aujourd''hui sur les avis papier. C''est un moyen de ne pas avoir à annexer de document indiquant ces éléments lorsqu''il n''y a pas besoin de les mettre en forme';


--
-- Name: COLUMN consultation.texte_hypotheses; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.texte_hypotheses IS 'Texte descriptif des hypothèses sur lesquelles l''avis est rendu lorsque le dossier ne contient pas d''éléments suffisants';


--
-- Name: COLUMN consultation.nom_auteur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.nom_auteur IS 'Nom de l''auteur de l''avis';


--
-- Name: COLUMN consultation.prenom_auteur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.prenom_auteur IS 'Prénom de l''auteur de l''avis';


--
-- Name: COLUMN consultation.qualite_auteur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.qualite_auteur IS 'Qualité de l''auteur de l''avis';


--
-- Name: COLUMN consultation.fichier_pec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.fichier_pec IS 'Permet de stocker le fichier de la pec';


--
-- Name: COLUMN consultation.motif_pec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation.motif_pec IS 'Permet de stocker le motif de la pec';


--
-- Name: consultation_entrante; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE consultation_entrante (
    consultation_entrante integer NOT NULL,
    delai_reponse character varying(255),
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
    texte_objet_consultation text,
    dossier character varying(255),
    type_delai character varying(255),
    objet_consultation character varying(255),
    date_production_notification date,
    date_premiere_consultation date
);


--
-- Name: TABLE consultation_entrante; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE consultation_entrante IS 'Consultation entrante';


--
-- Name: COLUMN consultation_entrante.consultation_entrante; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.consultation_entrante IS 'Identifiant technique de la consultation entrante';


--
-- Name: COLUMN consultation_entrante.delai_reponse; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.delai_reponse IS 'Délais de la réponse autorisée';


--
-- Name: COLUMN consultation_entrante.date_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.date_consultation IS 'Date à laquelle la consultation entrante a été décidée';


--
-- Name: COLUMN consultation_entrante.date_emission; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.date_emission IS 'Date à laquelle la consultation entrante a été transmise au service consultable';


--
-- Name: COLUMN consultation_entrante.service_consultant_id; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.service_consultant_id IS 'Identifiant du service consultant';


--
-- Name: COLUMN consultation_entrante.service_consultant_libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.service_consultant_libelle IS 'Libellé du service consultant';


--
-- Name: COLUMN consultation_entrante.service_consultant_insee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.service_consultant_insee IS 'Code INSEE du service consultant';


--
-- Name: COLUMN consultation_entrante.service_consultant_mail; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.service_consultant_mail IS 'Adresse mail du service consultant';


--
-- Name: COLUMN consultation_entrante.service_consultant_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.service_consultant_type IS 'Type du service consultant';


--
-- Name: COLUMN consultation_entrante.service_consultant__siren; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.service_consultant__siren IS 'Code SIREN du service consultant';


--
-- Name: COLUMN consultation_entrante.etat_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.etat_consultation IS 'État de la consultation entrante';


--
-- Name: COLUMN consultation_entrante.type_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.type_consultation IS 'Type de la consultation entrante';


--
-- Name: COLUMN consultation_entrante.texte_fondement_reglementaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.texte_fondement_reglementaire IS 'Texte indiquant le(s) article(s) réglémen-taire(s) sur le(s)quel(s) se fonde la consultation entrante';


--
-- Name: COLUMN consultation_entrante.texte_objet_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.texte_objet_consultation IS 'Texte descriptif de la consultation entrante';


--
-- Name: COLUMN consultation_entrante.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.dossier IS 'Numéro du dossier d''instruction portant la consultation entrante';


--
-- Name: COLUMN consultation_entrante.type_delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.type_delai IS 'Type de délai pour la réponse (jour/mois)';


--
-- Name: COLUMN consultation_entrante.objet_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.objet_consultation IS 'Identifiant Plat''AU de l''objet de la consultation entrante';


--
-- Name: COLUMN consultation_entrante.date_production_notification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.date_production_notification IS 'Date à laquelle la notification de la consultation entrante a été produite';


--
-- Name: COLUMN consultation_entrante.date_premiere_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN consultation_entrante.date_premiere_consultation IS 'Date à laquelle la consultation entrainte a été consultée pour la première fois';


--
-- Name: consultation_entrante_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE consultation_entrante_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: consultation_entrante_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE consultation_entrante_seq OWNED BY consultation_entrante.consultation_entrante;


--
-- Name: consultation_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE consultation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: consultation_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE consultation_seq OWNED BY consultation.consultation;


--
-- Name: contrainte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE contrainte (
    contrainte integer NOT NULL,
    numero character varying(250),
    nature character varying(10) NOT NULL,
    groupe character varying(250),
    sousgroupe character varying(250),
    libelle character varying(250) NOT NULL,
    texte text,
    no_ordre integer,
    reference boolean DEFAULT false,
    service_consulte boolean DEFAULT false,
    om_validite_debut date,
    om_validite_fin date,
    om_collectivite integer NOT NULL
);


--
-- Name: TABLE contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE contrainte IS 'Table de référence des contraintes';


--
-- Name: COLUMN contrainte.contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.contrainte IS 'Identifiant unique';


--
-- Name: COLUMN contrainte.numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.numero IS 'Numéro unique de contrainte, issu du SIG';


--
-- Name: COLUMN contrainte.nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.nature IS 'Nature de la contrainte POS ou PLU';


--
-- Name: COLUMN contrainte.groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.groupe IS 'Groupe de la contrainte';


--
-- Name: COLUMN contrainte.sousgroupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.sousgroupe IS 'Sous-groupe de la contrainte';


--
-- Name: COLUMN contrainte.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.libelle IS 'Libellé de la contrainte';


--
-- Name: COLUMN contrainte.texte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.texte IS 'Texte de la contrainte';


--
-- Name: COLUMN contrainte.no_ordre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.no_ordre IS 'Numéro d''ordre d''affichage ou d''impression';


--
-- Name: COLUMN contrainte.reference; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.reference IS 'Contrainte récupérée depuis le SIG';


--
-- Name: COLUMN contrainte.service_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.service_consulte IS 'Contrainte affichée aux services consultés';


--
-- Name: COLUMN contrainte.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.om_validite_debut IS 'Date de début de validité';


--
-- Name: COLUMN contrainte.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.om_validite_fin IS 'Date de fin de validité';


--
-- Name: COLUMN contrainte.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN contrainte.om_collectivite IS 'lien vers la collectivité concernée';


--
-- Name: contrainte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE contrainte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: contrainte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE contrainte_seq OWNED BY contrainte.contrainte;


--
-- Name: demande; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE demande (
    demande integer NOT NULL,
    dossier_autorisation_type_detaille integer NOT NULL,
    demande_type integer NOT NULL,
    dossier_instruction character varying(255),
    dossier_autorisation character varying(255),
    date_demande date NOT NULL,
    terrain_references_cadastrales text,
    terrain_adresse_voie_numero character varying(20),
    terrain_adresse_voie character varying(300),
    terrain_adresse_lieu_dit character varying(30),
    terrain_adresse_localite character varying(45),
    terrain_adresse_code_postal character varying(5),
    terrain_adresse_bp character varying(15),
    terrain_adresse_cedex character varying(15),
    terrain_superficie double precision,
    instruction_recepisse integer,
    arrondissement integer,
    om_collectivite integer NOT NULL,
    autorisation_contestee character varying(30),
    depot_electronique boolean DEFAULT false NOT NULL,
    parcelle_temporaire boolean DEFAULT false NOT NULL,
    commune integer,
    source_depot character varying(255)
);


--
-- Name: TABLE demande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE demande IS 'Demande saisie par le guichet unique';


--
-- Name: COLUMN demande.demande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.demande IS 'Identifiant unique';


--
-- Name: COLUMN demande.dossier_autorisation_type_detaille; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.dossier_autorisation_type_detaille IS 'Type détaillé du dossier d''autorisation (PCI, AZ, AT, ...) à sa création';


--
-- Name: COLUMN demande.demande_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.demande_type IS 'Type de la demande, influe sur le type du dossier d''instruction (initial, modificatif, transfert, ...) à sa création';


--
-- Name: COLUMN demande.dossier_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.dossier_instruction IS 'Dossier d''instruction de la demande';


--
-- Name: COLUMN demande.dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.dossier_autorisation IS 'Dossier d''autorisation de la demande';


--
-- Name: COLUMN demande.date_demande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.date_demande IS 'Date de la demande';


--
-- Name: COLUMN demande.terrain_references_cadastrales; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.terrain_references_cadastrales IS 'Références cadastrales de l''adresse du terrain';


--
-- Name: COLUMN demande.terrain_adresse_voie_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.terrain_adresse_voie_numero IS 'Numéro de la voie de l''adresse du terrain';


--
-- Name: COLUMN demande.terrain_adresse_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.terrain_adresse_voie IS 'Nom de la voie de l''adresse du terrain';


--
-- Name: COLUMN demande.terrain_adresse_lieu_dit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.terrain_adresse_lieu_dit IS 'Lieu dit de l''adresse du terrain';


--
-- Name: COLUMN demande.terrain_adresse_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.terrain_adresse_localite IS 'Ville de l''adresse du terrain';


--
-- Name: COLUMN demande.terrain_adresse_code_postal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.terrain_adresse_code_postal IS 'Code postal de l''adresse du terrain';


--
-- Name: COLUMN demande.terrain_adresse_bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.terrain_adresse_bp IS 'Boîte postale de l''adresse du terrain';


--
-- Name: COLUMN demande.terrain_adresse_cedex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.terrain_adresse_cedex IS 'Cedex de l''adresse du terrain';


--
-- Name: COLUMN demande.terrain_superficie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.terrain_superficie IS 'Superficie du terrain';


--
-- Name: COLUMN demande.instruction_recepisse; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.instruction_recepisse IS 'Récipissé de l''instruction lors de la création de la demande';


--
-- Name: COLUMN demande.arrondissement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.arrondissement IS 'Arrondissement du terrain de la demande';


--
-- Name: COLUMN demande.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.om_collectivite IS 'lien vers la collectivité concernée';


--
-- Name: COLUMN demande.autorisation_contestee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.autorisation_contestee IS 'Le numéro de l''autorisation contestée (DI)';


--
-- Name: COLUMN demande.depot_electronique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.depot_electronique IS 'Identifie le dépôt électronique de la demande';


--
-- Name: COLUMN demande.parcelle_temporaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.parcelle_temporaire IS 'Existence d''au moins une parcelle temporaire sur la demande';


--
-- Name: COLUMN demande.commune; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.commune IS 'Commune associée à la demande';


--
-- Name: COLUMN demande.source_depot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande.source_depot IS 'Permet d''indiquer la source de dépot, ce champ peut prendre en valeur : platau, app et portal';


--
-- Name: demande_nature; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE demande_nature (
    demande_nature integer NOT NULL,
    code character varying(20),
    libelle character varying(100),
    description text
);


--
-- Name: TABLE demande_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE demande_nature IS 'Nature de la demande';


--
-- Name: COLUMN demande_nature.demande_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_nature.demande_nature IS 'Identifiant unique';


--
-- Name: COLUMN demande_nature.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_nature.code IS 'Code de la nature de la demande';


--
-- Name: COLUMN demande_nature.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_nature.libelle IS 'Libellé de la nature de la demande';


--
-- Name: COLUMN demande_nature.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_nature.description IS 'Description de la nature de la demande';


--
-- Name: demande_nature_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE demande_nature_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: demande_nature_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE demande_nature_seq OWNED BY demande_nature.demande_nature;


--
-- Name: demande_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE demande_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: demande_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE demande_seq OWNED BY demande.demande;


--
-- Name: demande_type; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE demande_type (
    demande_type integer NOT NULL,
    code character varying(20) NOT NULL,
    libelle character varying(100) NOT NULL,
    description text,
    demande_nature integer NOT NULL,
    groupe integer NOT NULL,
    dossier_instruction_type integer,
    dossier_autorisation_type_detaille integer,
    contraintes character varying(20),
    qualification boolean,
    evenement integer NOT NULL,
    document_obligatoire text,
    regeneration_cle_citoyen boolean DEFAULT false
);


--
-- Name: TABLE demande_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE demande_type IS 'Type de la demande';


--
-- Name: COLUMN demande_type.demande_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.demande_type IS 'Identifiant unique';


--
-- Name: COLUMN demande_type.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.code IS 'Code du type de la demande';


--
-- Name: COLUMN demande_type.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.libelle IS 'Libellé du type de la demande';


--
-- Name: COLUMN demande_type.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.description IS 'Description du type de la demande';


--
-- Name: COLUMN demande_type.demande_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.demande_nature IS 'Nature de la demande';


--
-- Name: COLUMN demande_type.groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.groupe IS 'Groupe du type de la demande. Permet de filtrer les choix du champ dossier_autorisation_type_detaille';


--
-- Name: COLUMN demande_type.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.dossier_instruction_type IS 'Type du dossier d''instruction créé par la demande';


--
-- Name: COLUMN demande_type.dossier_autorisation_type_detaille; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.dossier_autorisation_type_detaille IS 'Type détaillé du dossier d''autorisation crée par la demande. Permet de filtrer les choix du champ dossier_instruction_type';


--
-- Name: COLUMN demande_type.contraintes; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.contraintes IS 'Permet de définir si les informations des demandeurs du dossier d''instruction précédent doivent être récupérées';


--
-- Name: COLUMN demande_type.qualification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.qualification IS 'Le dossier d''instruction crée doit être à qualifier';


--
-- Name: COLUMN demande_type.evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.evenement IS 'Événement à instancier lors de la création de la demande';


--
-- Name: COLUMN demande_type.regeneration_cle_citoyen; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demande_type.regeneration_cle_citoyen IS 'La clé d''accès au portail citoyen du dossier d''autorisation doit être regénérée lors de la création du dossier d''instruction';


--
-- Name: demande_type_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE demande_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: demande_type_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE demande_type_seq OWNED BY demande_type.demande_type;


--
-- Name: demandeur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE demandeur (
    demandeur integer NOT NULL,
    type_demandeur character varying(40),
    qualite character varying(40),
    particulier_nom character varying(100),
    particulier_prenom character varying(50),
    particulier_date_naissance date,
    particulier_commune_naissance character varying(30),
    particulier_departement_naissance character varying(80),
    personne_morale_denomination character varying(40),
    personne_morale_raison_sociale character varying(50),
    personne_morale_siret character varying(15),
    personne_morale_categorie_juridique character varying(15),
    personne_morale_nom character varying(50),
    personne_morale_prenom character varying(50),
    numero character varying(10),
    voie character varying(55),
    complement character varying(50),
    lieu_dit character varying(39),
    localite character varying(250),
    code_postal character varying(5),
    bp character varying(5),
    cedex character varying(5),
    pays character varying(40),
    division_territoriale character varying(40),
    telephone_fixe character varying(20),
    telephone_mobile character varying(20),
    indicatif character varying(5),
    courriel character varying(60),
    notification boolean,
    frequent boolean,
    particulier_civilite integer,
    personne_morale_civilite integer,
    fax character varying(20),
    om_collectivite integer NOT NULL,
    particulier_pays_naissance character varying(250),
    num_inscription character varying(20),
    nom_cabinet character varying(100),
    conseil_regional character varying(100),
    titre_obt_diplo_spec text,
    date_obt_diplo_spec date,
    lieu_obt_diplo_spec text
);


--
-- Name: TABLE demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE demandeur IS 'Pétitionnaire et délégataire de chaque dossier d''instruction';


--
-- Name: COLUMN demandeur.demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.demandeur IS 'Identifiant unique';


--
-- Name: COLUMN demandeur.type_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.type_demandeur IS 'Type de demandeur : avocat / contrevenant / delegataire / petitionnaire / plaignant / requerant / bailleur';


--
-- Name: COLUMN demandeur.qualite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.qualite IS 'Qualité du demandeur : particulier ou personne morale';


--
-- Name: COLUMN demandeur.particulier_nom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.particulier_nom IS 'Nom du demandeur de qualité particulier';


--
-- Name: COLUMN demandeur.particulier_prenom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.particulier_prenom IS 'Prénom du demandeur de qualité particulier';


--
-- Name: COLUMN demandeur.particulier_date_naissance; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.particulier_date_naissance IS 'Date de naissance du demandeur de qualité particulier';


--
-- Name: COLUMN demandeur.particulier_commune_naissance; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.particulier_commune_naissance IS 'Commune de naissance du demandeur de qualité particulier';


--
-- Name: COLUMN demandeur.particulier_departement_naissance; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.particulier_departement_naissance IS 'Département de naissance du demandeur de qualité particulier';


--
-- Name: COLUMN demandeur.personne_morale_denomination; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.personne_morale_denomination IS 'Dénomination du demandeur de qualité personne marole';


--
-- Name: COLUMN demandeur.personne_morale_raison_sociale; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.personne_morale_raison_sociale IS 'Raison sociale du demandeur de qualité personne morale';


--
-- Name: COLUMN demandeur.personne_morale_siret; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.personne_morale_siret IS 'SIRET du demandeur de qualité personne morale';


--
-- Name: COLUMN demandeur.personne_morale_categorie_juridique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.personne_morale_categorie_juridique IS 'Catégorie juridique du demandeur de qualité personne morale';


--
-- Name: COLUMN demandeur.personne_morale_nom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.personne_morale_nom IS 'Nom du demandeur de qualité personne morale';


--
-- Name: COLUMN demandeur.personne_morale_prenom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.personne_morale_prenom IS 'Prénom du demandeur de qualité personne morale';


--
-- Name: COLUMN demandeur.numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.numero IS 'Numéro de voie de l''adresse du demandeur';


--
-- Name: COLUMN demandeur.voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.voie IS 'Voie de l''adresse du demandeur';


--
-- Name: COLUMN demandeur.complement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.complement IS 'Complément d''adresse du demandeur';


--
-- Name: COLUMN demandeur.lieu_dit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.lieu_dit IS 'Lieu-dit de l''adresse du demandeur';


--
-- Name: COLUMN demandeur.localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.localite IS 'Localité de l''adresse du demandeur';


--
-- Name: COLUMN demandeur.code_postal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.code_postal IS 'Code postal de l''adresse du demandeur';


--
-- Name: COLUMN demandeur.bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.bp IS 'Boîte postale de l''adresse du demandeur';


--
-- Name: COLUMN demandeur.cedex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.cedex IS 'Cedex de l''adresse du demandeur';


--
-- Name: COLUMN demandeur.pays; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.pays IS 'Pays de résidence du demandeur';


--
-- Name: COLUMN demandeur.division_territoriale; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.division_territoriale IS 'Division territoriale de résidence du demandeur';


--
-- Name: COLUMN demandeur.telephone_fixe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.telephone_fixe IS 'Numéro de téléphone fixe du demandeur';


--
-- Name: COLUMN demandeur.telephone_mobile; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.telephone_mobile IS 'Numéro de téléphone mobile du demandeur';


--
-- Name: COLUMN demandeur.indicatif; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.indicatif IS 'Indicatif du pays de résidence du demandeur';


--
-- Name: COLUMN demandeur.courriel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.courriel IS 'Adresse mail du demandeur';


--
-- Name: COLUMN demandeur.notification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.notification IS 'Notification par mail du demandeur';


--
-- Name: COLUMN demandeur.frequent; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.frequent IS 'Demandeur fréquent';


--
-- Name: COLUMN demandeur.particulier_civilite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.particulier_civilite IS 'Civilité du demandeur de qualité particulier';


--
-- Name: COLUMN demandeur.personne_morale_civilite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.personne_morale_civilite IS 'Civilité du demandeur de qualité personne morale';


--
-- Name: COLUMN demandeur.fax; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.fax IS 'Numéro de fax du demandeur';


--
-- Name: COLUMN demandeur.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.om_collectivite IS 'Lien vers la collectivité concernée.';


--
-- Name: COLUMN demandeur.particulier_pays_naissance; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.particulier_pays_naissance IS 'Pays de naissance du demandeur de qualité ''particulier''';


--
-- Name: COLUMN demandeur.num_inscription; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.num_inscription IS 'Numéro d''inscription au conseil national de l''ordre des architectes';


--
-- Name: COLUMN demandeur.nom_cabinet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.nom_cabinet IS 'Nom du cabinet dans lequel travail l''architecte';


--
-- Name: COLUMN demandeur.conseil_regional; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.conseil_regional IS 'Conseil régional de l''architecte';


--
-- Name: COLUMN demandeur.titre_obt_diplo_spec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.titre_obt_diplo_spec IS 'Titre d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';


--
-- Name: COLUMN demandeur.date_obt_diplo_spec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.date_obt_diplo_spec IS 'Date d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';


--
-- Name: COLUMN demandeur.lieu_obt_diplo_spec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN demandeur.lieu_obt_diplo_spec IS 'Établissement / ville / pays d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';


--
-- Name: demandeur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE demandeur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: demandeur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE demandeur_seq OWNED BY demandeur.demandeur;


--
-- Name: departement; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE departement (
    departement integer NOT NULL,
    dep character varying(3) NOT NULL,
    reg character varying(2) NOT NULL,
    cheflieu character varying(5) NOT NULL,
    tncc character varying(1),
    ncc character varying(200),
    nccenr character varying(200),
    libelle character varying(45),
    om_validite_debut date NOT NULL,
    om_validite_fin date
);


--
-- Name: COLUMN departement.departement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.departement IS 'Identifiant technique de la departement';


--
-- Name: COLUMN departement.dep; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.dep IS 'Code INSEE du département';


--
-- Name: COLUMN departement.reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.reg IS 'Code INSEE de la région';


--
-- Name: COLUMN departement.cheflieu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.cheflieu IS 'Code INSEE du chef lieu';


--
-- Name: COLUMN departement.tncc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.tncc IS 'Type de nom en clair';


--
-- Name: COLUMN departement.ncc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.ncc IS 'Nom en clair (majuscules)';


--
-- Name: COLUMN departement.nccenr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.nccenr IS 'Nom en typographie riche';


--
-- Name: COLUMN departement.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.libelle IS 'Nom en typographie riche avec article';


--
-- Name: COLUMN departement.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.om_validite_debut IS 'Date de validité (début)';


--
-- Name: COLUMN departement.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN departement.om_validite_fin IS 'Date de validité (fin)';


--
-- Name: departement_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE departement_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: departement_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE departement_seq OWNED BY departement.departement;


--
-- Name: direction; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE direction (
    direction integer NOT NULL,
    code character varying(20) NOT NULL,
    libelle character varying(100) NOT NULL,
    description text,
    chef character varying(100) NOT NULL,
    om_validite_debut date,
    om_validite_fin date,
    om_collectivite integer NOT NULL
);


--
-- Name: TABLE direction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE direction IS 'Direction des divisions, nécessaire aussi pour obtenir le nom du responsable de service dans certains documents';


--
-- Name: COLUMN direction.direction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN direction.direction IS 'Identifiant unique';


--
-- Name: COLUMN direction.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN direction.code IS 'Code de la direction';


--
-- Name: COLUMN direction.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN direction.libelle IS 'Libellé de la direction';


--
-- Name: COLUMN direction.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN direction.description IS 'Description de la direction';


--
-- Name: COLUMN direction.chef; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN direction.chef IS 'Nom et prénom du chef de la direction';


--
-- Name: COLUMN direction.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN direction.om_validite_debut IS 'Date de début de validité de la direction';


--
-- Name: COLUMN direction.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN direction.om_validite_fin IS 'Date de fin de validité de la direction';


--
-- Name: COLUMN direction.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN direction.om_collectivite IS 'Lien vers la collectivité concernée.';


--
-- Name: direction_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE direction_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: direction_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE direction_seq OWNED BY direction.direction;


--
-- Name: division; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE division (
    division integer NOT NULL,
    code character varying(20) NOT NULL,
    libelle character varying(100) NOT NULL,
    description text,
    chef character varying(100) NOT NULL,
    direction integer NOT NULL,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE division; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE division IS 'Division regroupant les instructeurs';


--
-- Name: COLUMN division.division; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN division.division IS 'Identifiant unique';


--
-- Name: COLUMN division.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN division.code IS 'Code de la division';


--
-- Name: COLUMN division.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN division.libelle IS 'Libellé de la division';


--
-- Name: COLUMN division.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN division.description IS 'Description de la division';


--
-- Name: COLUMN division.chef; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN division.chef IS 'Nom et prénom du chef de la division';


--
-- Name: COLUMN division.direction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN division.direction IS 'Direction à laquelle est rattachée la division';


--
-- Name: COLUMN division.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN division.om_validite_debut IS 'Date de début de validité de la division';


--
-- Name: COLUMN division.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN division.om_validite_fin IS 'Date de fin de validité de la division';


--
-- Name: division_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE division_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: division_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE division_seq OWNED BY division.division;


--
-- Name: document_numerise; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE document_numerise (
    document_numerise integer NOT NULL,
    uid character varying(255) NOT NULL,
    dossier character varying(255) NOT NULL,
    nom_fichier character varying(255) NOT NULL,
    date_creation date NOT NULL,
    document_numerise_type integer NOT NULL,
    uid_dossier_final boolean DEFAULT false,
    document_numerise_nature integer,
    uid_thumbnail character varying(255),
    description_type character varying(2000),
    document_travail boolean DEFAULT false NOT NULL
);


--
-- Name: TABLE document_numerise; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE document_numerise IS 'Document numérisé rattaché à un dossier d''instruction';


--
-- Name: COLUMN document_numerise.document_numerise; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.document_numerise IS 'Identifiant unique';


--
-- Name: COLUMN document_numerise.uid; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.uid IS 'Identifiant unique du fichier, compose aussi son chemin';


--
-- Name: COLUMN document_numerise.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.dossier IS 'Dossier d''instruction auquel est rattaché le document';


--
-- Name: COLUMN document_numerise.nom_fichier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.nom_fichier IS 'Nom du document';


--
-- Name: COLUMN document_numerise.date_creation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.date_creation IS 'Date de création du document';


--
-- Name: COLUMN document_numerise.document_numerise_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.document_numerise_type IS 'Type du document';


--
-- Name: COLUMN document_numerise.uid_dossier_final; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.uid_dossier_final IS 'Identifie que le document constitue dossier final';


--
-- Name: COLUMN document_numerise.document_numerise_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.document_numerise_nature IS 'Nature du document';


--
-- Name: COLUMN document_numerise.uid_thumbnail; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.uid_thumbnail IS 'Identifiant unique de la miniature du fichier';


--
-- Name: COLUMN document_numerise.description_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.description_type IS 'Description du type de pièce destiné aux pièces "Autre à préciser"';


--
-- Name: COLUMN document_numerise.document_travail; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise.document_travail IS 'Indique si le document est un document de travail';


--
-- Name: document_numerise_nature; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE document_numerise_nature (
    document_numerise_nature integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(255) NOT NULL,
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE document_numerise_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE document_numerise_nature IS 'Nature de document numérisé';


--
-- Name: COLUMN document_numerise_nature.document_numerise_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_nature.document_numerise_nature IS 'Identifiant numérique unique de la nature de document numérisé';


--
-- Name: COLUMN document_numerise_nature.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_nature.code IS 'Code aplhanumérique unique de la nature de document numérisé';


--
-- Name: COLUMN document_numerise_nature.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_nature.libelle IS 'Libellé de la nature de document numérisé';


--
-- Name: COLUMN document_numerise_nature.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_nature.description IS 'Description de la nature de document numérisé';


--
-- Name: COLUMN document_numerise_nature.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_nature.om_validite_debut IS 'Date de début de validité de la nature de document numérisé';


--
-- Name: COLUMN document_numerise_nature.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_nature.om_validite_fin IS 'Date de fin de validité de la nature de document numérisé';


--
-- Name: document_numerise_nature_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE document_numerise_nature_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: document_numerise_nature_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE document_numerise_nature_seq OWNED BY document_numerise_nature.document_numerise_nature;


--
-- Name: document_numerise_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE document_numerise_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: document_numerise_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE document_numerise_seq OWNED BY document_numerise.document_numerise;


--
-- Name: document_numerise_type; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE document_numerise_type (
    document_numerise_type integer NOT NULL,
    code character varying(50) NOT NULL,
    libelle character varying(2000) NOT NULL,
    document_numerise_type_categorie integer NOT NULL,
    aff_service_consulte boolean DEFAULT true NOT NULL,
    aff_da boolean DEFAULT true NOT NULL,
    synchro_metadonnee boolean DEFAULT false NOT NULL,
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE document_numerise_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE document_numerise_type IS 'Type de document numérisé';


--
-- Name: COLUMN document_numerise_type.document_numerise_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.document_numerise_type IS 'Identifiant unique';


--
-- Name: COLUMN document_numerise_type.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.code IS 'Code du type de document numérisé';


--
-- Name: COLUMN document_numerise_type.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.libelle IS 'Libellé du type de document numérisé';


--
-- Name: COLUMN document_numerise_type.document_numerise_type_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.document_numerise_type_categorie IS 'Catégorie du type de document numérisé';


--
-- Name: COLUMN document_numerise_type.aff_service_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.aff_service_consulte IS 'Définit si les pièces de ce type sont affichées sur les demandes d''avis.';


--
-- Name: COLUMN document_numerise_type.aff_da; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.aff_da IS 'Définit si les pièces de ce type sont affichées sur les dossiers d''autorisation.';


--
-- Name: COLUMN document_numerise_type.synchro_metadonnee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.synchro_metadonnee IS 'Définit si les champs ''aff_da'' et/ou ''aff_service_consulte'' de ce type ont été modifiés (t) ou non (f). Utilisé lors du traitement des métadonnées.';


--
-- Name: COLUMN document_numerise_type.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.description IS 'Description';


--
-- Name: COLUMN document_numerise_type.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.om_validite_debut IS 'Date de début de validité';


--
-- Name: COLUMN document_numerise_type.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type.om_validite_fin IS 'Date de fin de validité';


--
-- Name: document_numerise_type_categorie; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE document_numerise_type_categorie (
    document_numerise_type_categorie integer NOT NULL,
    libelle character varying(255) NOT NULL,
    code character varying(50)
);


--
-- Name: TABLE document_numerise_type_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE document_numerise_type_categorie IS 'Catégorie du type de document numérisé';


--
-- Name: COLUMN document_numerise_type_categorie.document_numerise_type_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type_categorie.document_numerise_type_categorie IS 'Identifiant unique';


--
-- Name: COLUMN document_numerise_type_categorie.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type_categorie.libelle IS 'Libellé de la catégorie du type de document numérisé';


--
-- Name: COLUMN document_numerise_type_categorie.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN document_numerise_type_categorie.code IS 'Code de la catégorie de document numérisé';


--
-- Name: document_numerise_type_categorie_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE document_numerise_type_categorie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: document_numerise_type_categorie_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE document_numerise_type_categorie_seq OWNED BY document_numerise_type_categorie.document_numerise_type_categorie;


--
-- Name: document_numerise_type_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE document_numerise_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: document_numerise_type_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE document_numerise_type_seq OWNED BY document_numerise_type.document_numerise_type;


--
-- Name: donnees_techniques; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE donnees_techniques (
    donnees_techniques integer NOT NULL,
    dossier_instruction character varying(255),
    lot integer,
    am_lotiss boolean,
    am_autre_div boolean,
    am_camping boolean,
    am_caravane boolean,
    am_carav_duree integer,
    am_statio boolean,
    am_statio_cont integer,
    am_affou_exhau boolean,
    am_affou_exhau_sup numeric,
    am_affou_prof numeric,
    am_exhau_haut numeric,
    am_coupe_abat boolean,
    am_prot_plu boolean,
    am_prot_muni boolean,
    am_mobil_voyage boolean,
    am_aire_voyage boolean,
    am_rememb_afu boolean,
    am_parc_resid_loi boolean,
    am_sport_moto boolean,
    am_sport_attrac boolean,
    am_sport_golf boolean,
    am_mob_art boolean,
    am_modif_voie_esp boolean,
    am_plant_voie_esp boolean,
    am_chem_ouv_esp boolean,
    am_agri_peche boolean,
    am_crea_voie boolean,
    am_modif_voie_exist boolean,
    am_crea_esp_sauv boolean,
    am_crea_esp_class boolean,
    am_projet_desc text,
    am_terr_surf numeric,
    am_tranche_desc text,
    am_lot_max_nb integer,
    am_lot_max_shon numeric,
    am_lot_cstr_cos boolean,
    am_lot_cstr_plan boolean,
    am_lot_cstr_vente boolean,
    am_lot_fin_diff boolean,
    am_lot_consign boolean,
    am_lot_gar_achev boolean,
    am_lot_vente_ant boolean,
    am_empl_nb integer,
    am_tente_nb integer,
    am_carav_nb integer,
    am_mobil_nb integer,
    am_pers_nb integer,
    am_empl_hll_nb integer,
    am_hll_shon numeric,
    am_periode_exploit text,
    am_exist_agrand boolean,
    am_exist_date character varying(100),
    am_exist_num character varying(100),
    am_exist_nb_avant integer,
    am_exist_nb_apres integer,
    am_coupe_bois boolean,
    am_coupe_parc boolean,
    am_coupe_align boolean,
    am_coupe_ess character varying(100),
    am_coupe_age character varying(15),
    am_coupe_dens character varying(100),
    am_coupe_qual character varying(100),
    am_coupe_trait character varying(100),
    am_coupe_autr character varying(100),
    co_archi_recours boolean,
    co_cstr_nouv boolean,
    co_cstr_exist boolean,
    co_cloture boolean,
    co_elec_tension numeric,
    co_div_terr boolean,
    co_projet_desc text,
    co_anx_pisc boolean,
    co_anx_gara boolean,
    co_anx_veran boolean,
    co_anx_abri boolean,
    co_anx_autr boolean,
    co_anx_autr_desc text,
    co_tot_log_nb integer,
    co_tot_ind_nb integer,
    co_tot_coll_nb integer,
    co_mais_piece_nb integer,
    co_mais_niv_nb integer,
    co_fin_lls_nb integer,
    co_fin_aa_nb integer,
    co_fin_ptz_nb integer,
    co_fin_autr_nb integer,
    co_fin_autr_desc text,
    co_mais_contrat_ind boolean,
    co_uti_pers boolean,
    co_uti_vente boolean,
    co_uti_loc boolean,
    co_uti_princ boolean,
    co_uti_secon boolean,
    co_resid_agees boolean,
    co_resid_etud boolean,
    co_resid_tourism boolean,
    co_resid_hot_soc boolean,
    co_resid_soc boolean,
    co_resid_hand boolean,
    co_resid_autr boolean,
    co_resid_autr_desc text,
    co_foyer_chamb_nb integer,
    co_log_1p_nb integer,
    co_log_2p_nb integer,
    co_log_3p_nb integer,
    co_log_4p_nb integer,
    co_log_5p_nb integer,
    co_log_6p_nb integer,
    co_bat_niv_nb integer,
    co_trx_exten boolean,
    co_trx_surelev boolean,
    co_trx_nivsup boolean,
    co_demont_periode text,
    co_sp_transport boolean,
    co_sp_enseign boolean,
    co_sp_act_soc boolean,
    co_sp_ouvr_spe boolean,
    co_sp_sante boolean,
    co_sp_culture boolean,
    co_statio_avt_nb integer,
    co_statio_apr_nb integer,
    co_statio_adr text,
    co_statio_place_nb integer,
    co_statio_tot_surf numeric,
    co_statio_tot_shob numeric,
    co_statio_comm_cin_surf numeric,
    su_avt_shon1 numeric,
    su_avt_shon2 numeric,
    su_avt_shon3 numeric,
    su_avt_shon4 numeric,
    su_avt_shon5 numeric,
    su_avt_shon6 numeric,
    su_avt_shon7 numeric,
    su_avt_shon8 numeric,
    su_avt_shon9 numeric,
    su_cstr_shon1 numeric,
    su_cstr_shon2 numeric,
    su_cstr_shon3 numeric,
    su_cstr_shon4 numeric,
    su_cstr_shon5 numeric,
    su_cstr_shon6 numeric,
    su_cstr_shon7 numeric,
    su_cstr_shon8 numeric,
    su_cstr_shon9 numeric,
    su_trsf_shon1 numeric,
    su_trsf_shon2 numeric,
    su_trsf_shon3 numeric,
    su_trsf_shon4 numeric,
    su_trsf_shon5 numeric,
    su_trsf_shon6 numeric,
    su_trsf_shon7 numeric,
    su_trsf_shon8 numeric,
    su_trsf_shon9 numeric,
    su_chge_shon1 numeric,
    su_chge_shon2 numeric,
    su_chge_shon3 numeric,
    su_chge_shon4 numeric,
    su_chge_shon5 numeric,
    su_chge_shon6 numeric,
    su_chge_shon7 numeric,
    su_chge_shon8 numeric,
    su_chge_shon9 numeric,
    su_demo_shon1 numeric,
    su_demo_shon2 numeric,
    su_demo_shon3 numeric,
    su_demo_shon4 numeric,
    su_demo_shon5 numeric,
    su_demo_shon6 numeric,
    su_demo_shon7 numeric,
    su_demo_shon8 numeric,
    su_demo_shon9 numeric,
    su_sup_shon1 numeric,
    su_sup_shon2 numeric,
    su_sup_shon3 numeric,
    su_sup_shon4 numeric,
    su_sup_shon5 numeric,
    su_sup_shon6 numeric,
    su_sup_shon7 numeric,
    su_sup_shon8 numeric,
    su_sup_shon9 numeric,
    su_tot_shon1 numeric,
    su_tot_shon2 numeric,
    su_tot_shon3 numeric,
    su_tot_shon4 numeric,
    su_tot_shon5 numeric,
    su_tot_shon6 numeric,
    su_tot_shon7 numeric,
    su_tot_shon8 numeric,
    su_tot_shon9 numeric,
    su_avt_shon_tot numeric,
    su_cstr_shon_tot numeric,
    su_trsf_shon_tot numeric,
    su_chge_shon_tot numeric,
    su_demo_shon_tot numeric,
    su_sup_shon_tot numeric,
    su_tot_shon_tot numeric,
    dm_constr_dates text,
    dm_total boolean,
    dm_partiel boolean,
    dm_projet_desc text,
    dm_tot_log_nb integer,
    tax_surf_tot numeric,
    tax_surf numeric,
    tax_surf_suppr_mod numeric,
    tax_su_princ_log_nb1 numeric,
    tax_su_princ_log_nb2 numeric,
    tax_su_princ_log_nb3 numeric,
    tax_su_princ_log_nb4 numeric,
    tax_su_princ_log_nb_tot1 numeric,
    tax_su_princ_log_nb_tot2 numeric,
    tax_su_princ_log_nb_tot3 numeric,
    tax_su_princ_log_nb_tot4 numeric,
    tax_su_princ_surf1 numeric,
    tax_su_princ_surf2 numeric,
    tax_su_princ_surf3 numeric,
    tax_su_princ_surf4 numeric,
    tax_su_princ_surf_sup1 numeric,
    tax_su_princ_surf_sup2 numeric,
    tax_su_princ_surf_sup3 numeric,
    tax_su_princ_surf_sup4 numeric,
    tax_su_heber_log_nb1 integer,
    tax_su_heber_log_nb2 integer,
    tax_su_heber_log_nb3 integer,
    tax_su_heber_log_nb_tot1 integer,
    tax_su_heber_log_nb_tot2 integer,
    tax_su_heber_log_nb_tot3 integer,
    tax_su_heber_surf1 numeric,
    tax_su_heber_surf2 numeric,
    tax_su_heber_surf3 numeric,
    tax_su_heber_surf_sup1 numeric,
    tax_su_heber_surf_sup2 numeric,
    tax_su_heber_surf_sup3 numeric,
    tax_su_secon_log_nb integer,
    tax_su_tot_log_nb integer,
    tax_su_secon_log_nb_tot integer,
    tax_su_tot_log_nb_tot integer,
    tax_su_secon_surf numeric,
    tax_su_tot_surf numeric,
    tax_su_secon_surf_sup numeric,
    tax_su_tot_surf_sup numeric,
    tax_ext_pret boolean,
    tax_ext_desc text,
    tax_surf_tax_exist_cons numeric,
    tax_log_exist_nb integer,
    tax_am_statio_ext integer,
    tax_sup_bass_pisc numeric,
    tax_empl_ten_carav_mobil_nb integer,
    tax_empl_hll_nb integer,
    tax_eol_haut_nb integer,
    tax_pann_volt_sup numeric,
    tax_am_statio_ext_sup integer,
    tax_sup_bass_pisc_sup numeric,
    tax_empl_ten_carav_mobil_nb_sup integer,
    tax_empl_hll_nb_sup integer,
    tax_eol_haut_nb_sup integer,
    tax_pann_volt_sup_sup numeric,
    tax_trx_presc_ppr boolean,
    tax_monu_hist boolean,
    tax_comm_nb integer,
    tax_su_non_habit_surf1 numeric,
    tax_su_non_habit_surf2 numeric,
    tax_su_non_habit_surf3 numeric,
    tax_su_non_habit_surf4 numeric,
    tax_su_non_habit_surf5 numeric,
    tax_su_non_habit_surf6 numeric,
    tax_su_non_habit_surf7 numeric,
    tax_su_non_habit_surf_sup1 numeric,
    tax_su_non_habit_surf_sup2 numeric,
    tax_su_non_habit_surf_sup3 numeric,
    tax_su_non_habit_surf_sup4 numeric,
    tax_su_non_habit_surf_sup5 numeric,
    tax_su_non_habit_surf_sup6 numeric,
    tax_su_non_habit_surf_sup7 numeric,
    vsd_surf_planch_smd boolean,
    vsd_unit_fonc_sup numeric,
    vsd_unit_fonc_constr_sup numeric,
    vsd_val_terr numeric,
    vsd_const_sxist_non_dem_surf numeric,
    vsd_rescr_fisc date,
    pld_val_terr numeric,
    pld_const_exist_dem boolean,
    pld_const_exist_dem_surf numeric,
    code_cnil boolean,
    terr_juri_titul character varying(20),
    terr_juri_lot character varying(20),
    terr_juri_zac character varying(20),
    terr_juri_afu character varying(20),
    terr_juri_pup character varying(20),
    terr_juri_oin character varying(20),
    terr_juri_desc text,
    terr_div_surf_etab numeric,
    terr_div_surf_av_div numeric,
    doc_date date,
    doc_tot_trav boolean,
    doc_tranche_trav boolean,
    doc_tranche_trav_desc text,
    doc_surf numeric,
    doc_nb_log integer,
    doc_nb_log_indiv integer,
    doc_nb_log_coll integer,
    doc_nb_log_lls integer,
    doc_nb_log_aa integer,
    doc_nb_log_ptz integer,
    doc_nb_log_autre integer,
    daact_date date,
    daact_date_chgmt_dest date,
    daact_tot_trav boolean,
    daact_tranche_trav boolean,
    daact_tranche_trav_desc text,
    daact_surf numeric,
    daact_nb_log integer,
    daact_nb_log_indiv integer,
    daact_nb_log_coll integer,
    daact_nb_log_lls integer,
    daact_nb_log_aa integer,
    daact_nb_log_ptz integer,
    daact_nb_log_autre integer,
    dossier_autorisation character varying(255),
    am_div_mun boolean,
    co_perf_energ character varying(40),
    architecte integer,
    co_statio_avt_shob character varying(250),
    co_statio_apr_shob character varying(250),
    co_statio_avt_surf character varying(250),
    co_statio_apr_surf character varying(250),
    co_trx_amgt character varying(250),
    co_modif_aspect character varying(250),
    co_modif_struct character varying(250),
    co_ouvr_elec boolean,
    co_ouvr_infra boolean,
    co_trx_imm character varying(250),
    co_cstr_shob character varying(250),
    am_voyage_deb character varying(250),
    am_voyage_fin character varying(250),
    am_modif_amgt character varying(250),
    am_lot_max_shob character varying(250),
    mod_desc character varying(250),
    tr_total character varying(250),
    tr_partiel character varying(250),
    tr_desc character varying(250),
    avap_co_elt_pro boolean,
    avap_nouv_haut_surf boolean,
    avap_co_clot character varying(250),
    avap_aut_coup_aba_arb character varying(250),
    avap_ouv_infra character varying(250),
    avap_aut_inst_mob character varying(250),
    avap_aut_plant character varying(250),
    avap_aut_auv_elec character varying(250),
    tax_dest_loc_tr character varying(250),
    ope_proj_desc text,
    tax_surf_tot_cstr integer,
    cerfa integer NOT NULL,
    tax_surf_loc_stat integer,
    tax_su_princ_surf_stat1 numeric,
    tax_su_princ_surf_stat2 numeric,
    tax_su_princ_surf_stat3 numeric,
    tax_su_princ_surf_stat4 numeric,
    tax_su_secon_surf_stat numeric,
    tax_su_heber_surf_stat1 numeric,
    tax_su_heber_surf_stat2 numeric,
    tax_su_heber_surf_stat3 numeric,
    tax_su_tot_surf_stat numeric,
    tax_su_non_habit_surf_stat1 numeric,
    tax_su_non_habit_surf_stat2 numeric,
    tax_su_non_habit_surf_stat3 numeric,
    tax_su_non_habit_surf_stat4 numeric,
    tax_su_non_habit_surf_stat5 numeric,
    tax_su_non_habit_surf_stat6 numeric,
    tax_su_non_habit_surf_stat7 numeric,
    tax_su_parc_statio_expl_comm_surf numeric,
    tax_log_ap_trvx_nb integer,
    tax_am_statio_ext_cr integer,
    tax_sup_bass_pisc_cr numeric,
    tax_empl_ten_carav_mobil_nb_cr integer,
    tax_empl_hll_nb_cr integer,
    tax_eol_haut_nb_cr integer,
    tax_pann_volt_sup_cr numeric,
    tax_surf_loc_arch numeric,
    tax_surf_pisc_arch numeric,
    tax_am_statio_ext_arch numeric,
    tax_empl_ten_carav_mobil_nb_arch numeric,
    tax_empl_hll_nb_arch numeric,
    tax_eol_haut_nb_arch integer,
    ope_proj_div_co boolean DEFAULT false,
    ope_proj_div_contr boolean DEFAULT false,
    tax_desc text,
    erp_cstr_neuve boolean DEFAULT false,
    erp_trvx_acc boolean DEFAULT false,
    erp_extension boolean DEFAULT false,
    erp_rehab boolean DEFAULT false,
    erp_trvx_am boolean DEFAULT false,
    erp_vol_nouv_exist boolean DEFAULT false,
    erp_loc_eff1 character varying(250),
    erp_loc_eff2 character varying(250),
    erp_loc_eff3 character varying(250),
    erp_loc_eff4 character varying(250),
    erp_loc_eff5 character varying(250),
    erp_loc_eff_tot character varying(250),
    erp_public_eff1 numeric,
    erp_public_eff2 numeric,
    erp_public_eff3 numeric,
    erp_public_eff4 numeric,
    erp_public_eff5 numeric,
    erp_public_eff_tot numeric,
    erp_perso_eff1 numeric,
    erp_perso_eff2 numeric,
    erp_perso_eff3 numeric,
    erp_perso_eff4 numeric,
    erp_perso_eff5 numeric,
    erp_perso_eff_tot numeric,
    erp_tot_eff1 numeric,
    erp_tot_eff2 numeric,
    erp_tot_eff3 numeric,
    erp_tot_eff4 numeric,
    erp_tot_eff5 numeric,
    erp_tot_eff_tot numeric,
    erp_class_cat integer,
    erp_class_type integer,
    tax_surf_abr_jard_pig_colom numeric,
    tax_su_non_habit_abr_jard_pig_colom numeric,
    dia_imm_non_bati boolean DEFAULT false,
    dia_imm_bati_terr_propr boolean DEFAULT false,
    dia_imm_bati_terr_autr boolean DEFAULT false,
    dia_imm_bati_terr_autr_desc text,
    dia_bat_copro boolean DEFAULT false,
    dia_bat_copro_desc text,
    dia_lot_numero text,
    dia_lot_bat text,
    dia_lot_etage text,
    dia_lot_quote_part text,
    dia_us_hab boolean DEFAULT false,
    dia_us_pro boolean DEFAULT false,
    dia_us_mixte boolean DEFAULT false,
    dia_us_comm boolean DEFAULT false,
    dia_us_agr boolean DEFAULT false,
    dia_us_autre boolean DEFAULT false,
    dia_us_autre_prec text,
    dia_occ_prop boolean DEFAULT false,
    dia_occ_loc boolean DEFAULT false,
    dia_occ_sans_occ boolean DEFAULT false,
    dia_occ_autre boolean DEFAULT false,
    dia_occ_autre_prec text,
    dia_mod_cess_prix_vente character varying(250),
    dia_mod_cess_prix_vente_mob character varying(250),
    dia_mod_cess_prix_vente_cheptel character varying(250),
    dia_mod_cess_prix_vente_recol character varying(250),
    dia_mod_cess_prix_vente_autre character varying(250),
    dia_mod_cess_commi boolean DEFAULT false,
    dia_mod_cess_commi_ttc character varying(250),
    dia_mod_cess_commi_ht character varying(250),
    dia_acquereur_nom_prenom character varying(150),
    dia_acquereur_adr_num_voie character varying(10),
    dia_acquereur_adr_ext character varying(55),
    dia_acquereur_adr_type_voie character varying(20),
    dia_acquereur_adr_nom_voie character varying(55),
    dia_acquereur_adr_lieu_dit_bp character varying(39),
    dia_acquereur_adr_cp character varying(5),
    dia_acquereur_adr_localite character varying(250),
    dia_observation text,
    su2_avt_shon1 numeric,
    su2_avt_shon2 numeric,
    su2_avt_shon3 numeric,
    su2_avt_shon4 numeric,
    su2_avt_shon5 numeric,
    su2_avt_shon6 numeric,
    su2_avt_shon7 numeric,
    su2_avt_shon8 numeric,
    su2_avt_shon9 numeric,
    su2_avt_shon10 numeric,
    su2_avt_shon11 numeric,
    su2_avt_shon12 numeric,
    su2_avt_shon13 numeric,
    su2_avt_shon14 numeric,
    su2_avt_shon15 numeric,
    su2_avt_shon16 numeric,
    su2_avt_shon17 numeric,
    su2_avt_shon18 numeric,
    su2_avt_shon19 numeric,
    su2_avt_shon20 numeric,
    su2_avt_shon_tot numeric,
    su2_cstr_shon1 numeric,
    su2_cstr_shon2 numeric,
    su2_cstr_shon3 numeric,
    su2_cstr_shon4 numeric,
    su2_cstr_shon5 numeric,
    su2_cstr_shon6 numeric,
    su2_cstr_shon7 numeric,
    su2_cstr_shon8 numeric,
    su2_cstr_shon9 numeric,
    su2_cstr_shon10 numeric,
    su2_cstr_shon11 numeric,
    su2_cstr_shon12 numeric,
    su2_cstr_shon13 numeric,
    su2_cstr_shon14 numeric,
    su2_cstr_shon15 numeric,
    su2_cstr_shon16 numeric,
    su2_cstr_shon17 numeric,
    su2_cstr_shon18 numeric,
    su2_cstr_shon19 numeric,
    su2_cstr_shon20 numeric,
    su2_cstr_shon_tot numeric,
    su2_chge_shon1 numeric,
    su2_chge_shon2 numeric,
    su2_chge_shon3 numeric,
    su2_chge_shon4 numeric,
    su2_chge_shon5 numeric,
    su2_chge_shon6 numeric,
    su2_chge_shon7 numeric,
    su2_chge_shon8 numeric,
    su2_chge_shon9 numeric,
    su2_chge_shon10 numeric,
    su2_chge_shon11 numeric,
    su2_chge_shon12 numeric,
    su2_chge_shon13 numeric,
    su2_chge_shon14 numeric,
    su2_chge_shon15 numeric,
    su2_chge_shon16 numeric,
    su2_chge_shon17 numeric,
    su2_chge_shon18 numeric,
    su2_chge_shon19 numeric,
    su2_chge_shon20 numeric,
    su2_chge_shon_tot numeric,
    su2_demo_shon1 numeric,
    su2_demo_shon2 numeric,
    su2_demo_shon3 numeric,
    su2_demo_shon4 numeric,
    su2_demo_shon5 numeric,
    su2_demo_shon6 numeric,
    su2_demo_shon7 numeric,
    su2_demo_shon8 numeric,
    su2_demo_shon9 numeric,
    su2_demo_shon10 numeric,
    su2_demo_shon11 numeric,
    su2_demo_shon12 numeric,
    su2_demo_shon13 numeric,
    su2_demo_shon14 numeric,
    su2_demo_shon15 numeric,
    su2_demo_shon16 numeric,
    su2_demo_shon17 numeric,
    su2_demo_shon18 numeric,
    su2_demo_shon19 numeric,
    su2_demo_shon20 numeric,
    su2_demo_shon_tot numeric,
    su2_sup_shon1 numeric,
    su2_sup_shon2 numeric,
    su2_sup_shon3 numeric,
    su2_sup_shon4 numeric,
    su2_sup_shon5 numeric,
    su2_sup_shon6 numeric,
    su2_sup_shon7 numeric,
    su2_sup_shon8 numeric,
    su2_sup_shon9 numeric,
    su2_sup_shon10 numeric,
    su2_sup_shon11 numeric,
    su2_sup_shon12 numeric,
    su2_sup_shon13 numeric,
    su2_sup_shon14 numeric,
    su2_sup_shon15 numeric,
    su2_sup_shon16 numeric,
    su2_sup_shon17 numeric,
    su2_sup_shon18 numeric,
    su2_sup_shon19 numeric,
    su2_sup_shon20 numeric,
    su2_sup_shon_tot numeric,
    su2_tot_shon1 numeric,
    su2_tot_shon2 numeric,
    su2_tot_shon3 numeric,
    su2_tot_shon4 numeric,
    su2_tot_shon5 numeric,
    su2_tot_shon6 numeric,
    su2_tot_shon7 numeric,
    su2_tot_shon8 numeric,
    su2_tot_shon9 numeric,
    su2_tot_shon10 numeric,
    su2_tot_shon11 numeric,
    su2_tot_shon12 numeric,
    su2_tot_shon13 numeric,
    su2_tot_shon14 numeric,
    su2_tot_shon15 numeric,
    su2_tot_shon16 numeric,
    su2_tot_shon17 numeric,
    su2_tot_shon18 numeric,
    su2_tot_shon19 numeric,
    su2_tot_shon20 numeric,
    su2_tot_shon_tot numeric,
    dia_occ_sol_su_terre text,
    dia_occ_sol_su_pres text,
    dia_occ_sol_su_verger text,
    dia_occ_sol_su_vigne text,
    dia_occ_sol_su_bois text,
    dia_occ_sol_su_lande text,
    dia_occ_sol_su_carriere text,
    dia_occ_sol_su_eau_cadastree text,
    dia_occ_sol_su_jardin text,
    dia_occ_sol_su_terr_batir text,
    dia_occ_sol_su_terr_agr text,
    dia_occ_sol_su_sol text,
    dia_bati_vend_tot boolean DEFAULT false,
    dia_bati_vend_tot_txt text,
    dia_su_co_sol text,
    dia_su_util_hab text,
    dia_nb_niv text,
    dia_nb_appart text,
    dia_nb_autre_loc text,
    dia_vente_lot_volume boolean DEFAULT false,
    dia_vente_lot_volume_txt text,
    dia_lot_nat_su text,
    dia_lot_bat_achv_plus_10 boolean DEFAULT false,
    dia_lot_bat_achv_moins_10 boolean DEFAULT false,
    dia_lot_regl_copro_publ_hypo_plus_10 boolean DEFAULT false,
    dia_lot_regl_copro_publ_hypo_moins_10 boolean DEFAULT false,
    dia_indivi_quote_part text,
    dia_design_societe text,
    dia_design_droit text,
    dia_droit_soc_nat text,
    dia_droit_soc_nb text,
    dia_droit_soc_num_part text,
    dia_droit_reel_perso_grevant_bien_oui boolean DEFAULT false,
    dia_droit_reel_perso_grevant_bien_non boolean DEFAULT false,
    dia_droit_reel_perso_nat text,
    dia_droit_reel_perso_viag text,
    dia_mod_cess_adr text,
    dia_mod_cess_sign_act_auth boolean DEFAULT false,
    dia_mod_cess_terme boolean DEFAULT false,
    dia_mod_cess_terme_prec text,
    dia_mod_cess_bene_acquereur boolean DEFAULT false,
    dia_mod_cess_bene_vendeur boolean DEFAULT false,
    dia_mod_cess_paie_nat boolean DEFAULT false,
    dia_mod_cess_design_contr_alien text,
    dia_mod_cess_eval_contr text,
    dia_mod_cess_rente_viag boolean DEFAULT false,
    dia_mod_cess_mnt_an text,
    dia_mod_cess_mnt_compt text,
    dia_mod_cess_bene_rente text,
    dia_mod_cess_droit_usa_hab boolean DEFAULT false,
    dia_mod_cess_droit_usa_hab_prec text,
    dia_mod_cess_eval_usa_usufruit text,
    dia_mod_cess_vente_nue_prop boolean DEFAULT false,
    dia_mod_cess_vente_nue_prop_prec text,
    dia_mod_cess_echange boolean DEFAULT false,
    dia_mod_cess_design_bien_recus_ech text,
    dia_mod_cess_mnt_soulte text,
    dia_mod_cess_prop_contre_echan text,
    dia_mod_cess_apport_societe text,
    dia_mod_cess_bene text,
    dia_mod_cess_esti_bien text,
    dia_mod_cess_cess_terr_loc_co boolean DEFAULT false,
    dia_mod_cess_esti_terr text,
    dia_mod_cess_esti_loc text,
    dia_mod_cess_esti_imm_loca boolean DEFAULT false,
    dia_mod_cess_adju_vol boolean DEFAULT false,
    dia_mod_cess_adju_obl boolean DEFAULT false,
    dia_mod_cess_adju_fin_indivi boolean DEFAULT false,
    dia_mod_cess_adju_date_lieu text,
    dia_mod_cess_mnt_mise_prix text,
    dia_prop_titu_prix_indique boolean DEFAULT false,
    dia_prop_recherche_acqu_prix_indique boolean DEFAULT false,
    dia_acquereur_prof text,
    dia_indic_compl_ope text,
    dia_vente_adju boolean DEFAULT false,
    am_terr_res_demon boolean DEFAULT false,
    am_air_terr_res_mob boolean DEFAULT false,
    ctx_objet_recours integer,
    ctx_reference_sagace character varying(255),
    ctx_nature_travaux_infra_om_html text,
    ctx_synthese_nti text,
    ctx_article_non_resp_om_html text,
    ctx_synthese_anr text,
    ctx_reference_parquet character varying(255),
    ctx_element_taxation character varying(255),
    ctx_infraction boolean,
    ctx_regularisable boolean,
    ctx_reference_courrier character varying(255),
    ctx_date_audience date,
    ctx_date_ajournement date,
    exo_facul_1 boolean DEFAULT false,
    exo_facul_2 boolean DEFAULT false,
    exo_facul_3 boolean DEFAULT false,
    exo_facul_4 boolean DEFAULT false,
    exo_facul_5 boolean DEFAULT false,
    exo_facul_6 boolean DEFAULT false,
    exo_facul_7 boolean DEFAULT false,
    exo_facul_8 boolean DEFAULT false,
    exo_facul_9 boolean DEFAULT false,
    exo_ta_1 boolean DEFAULT false,
    exo_ta_2 boolean DEFAULT false,
    exo_ta_3 boolean DEFAULT false,
    exo_ta_4 boolean DEFAULT false,
    exo_ta_5 boolean DEFAULT false,
    exo_ta_6 boolean DEFAULT false,
    exo_ta_7 boolean DEFAULT false,
    exo_ta_8 boolean DEFAULT false,
    exo_ta_9 boolean DEFAULT false,
    exo_rap_1 boolean DEFAULT false,
    exo_rap_2 boolean DEFAULT false,
    exo_rap_3 boolean DEFAULT false,
    exo_rap_4 boolean DEFAULT false,
    exo_rap_5 boolean DEFAULT false,
    exo_rap_6 boolean DEFAULT false,
    exo_rap_7 boolean DEFAULT false,
    exo_rap_8 boolean DEFAULT false,
    mtn_exo_ta_part_commu numeric,
    mtn_exo_ta_part_depart numeric,
    mtn_exo_ta_part_reg numeric,
    mtn_exo_rap numeric,
    dpc_type character varying(100),
    dpc_desc_actv_ex text,
    dpc_desc_ca text,
    dpc_desc_aut_prec text,
    dpc_desig_comm_arti boolean DEFAULT false,
    dpc_desig_loc_hab boolean DEFAULT false,
    dpc_desig_loc_ann boolean DEFAULT false,
    dpc_desig_loc_ann_prec text,
    dpc_bail_comm_date date,
    dpc_bail_comm_loyer text,
    dpc_actv_acqu text,
    dpc_nb_sala_di text,
    dpc_nb_sala_dd text,
    dpc_nb_sala_tc text,
    dpc_nb_sala_tp text,
    dpc_moda_cess_vente_am boolean DEFAULT false,
    dpc_moda_cess_adj boolean DEFAULT false,
    dpc_moda_cess_prix text,
    dpc_moda_cess_adj_date date,
    dpc_moda_cess_adj_prec text,
    dpc_moda_cess_paie_comp boolean DEFAULT false,
    dpc_moda_cess_paie_terme boolean DEFAULT false,
    dpc_moda_cess_paie_terme_prec text,
    dpc_moda_cess_paie_nat boolean DEFAULT false,
    dpc_moda_cess_paie_nat_desig_alien boolean DEFAULT false,
    dpc_moda_cess_paie_nat_desig_alien_prec text,
    dpc_moda_cess_paie_nat_eval boolean DEFAULT false,
    dpc_moda_cess_paie_nat_eval_prec text,
    dpc_moda_cess_paie_aut boolean DEFAULT false,
    dpc_moda_cess_paie_aut_prec text,
    dpc_ss_signe_demande_acqu boolean DEFAULT false,
    dpc_ss_signe_recher_trouv_acqu boolean DEFAULT false,
    dpc_notif_adr_prop boolean DEFAULT false,
    dpc_notif_adr_manda boolean DEFAULT false,
    dpc_obs text,
    co_peri_site_patri_remar boolean DEFAULT false,
    co_abo_monu_hist boolean DEFAULT false,
    co_inst_ouvr_trav_act_code_envir boolean DEFAULT false,
    co_trav_auto_env boolean DEFAULT false,
    co_derog_esp_prot boolean DEFAULT false,
    ctx_reference_dsj character varying(30),
    co_piscine boolean DEFAULT false,
    co_fin_lls boolean DEFAULT false,
    co_fin_aa boolean DEFAULT false,
    co_fin_ptz boolean DEFAULT false,
    co_fin_autr text,
    dia_ss_date date,
    dia_ss_lieu character varying(255),
    enga_decla_lieu character varying(255),
    enga_decla_date date,
    co_archi_attest_honneur boolean DEFAULT false,
    co_bat_niv_dessous_nb integer,
    co_install_classe boolean DEFAULT false,
    co_derog_innov boolean DEFAULT false,
    co_avis_abf boolean DEFAULT false,
    tax_surf_tot_demo numeric,
    tax_surf_tax_demo numeric,
    tax_su_non_habit_surf8 numeric,
    tax_su_non_habit_surf_stat8 numeric,
    tax_su_non_habit_surf9 numeric,
    tax_su_non_habit_surf_stat9 numeric,
    tax_terrassement_arch boolean DEFAULT false,
    tax_adresse_future_numero character varying(255),
    tax_adresse_future_voie character varying(255),
    tax_adresse_future_lieudit character varying(255),
    tax_adresse_future_localite character varying(255),
    tax_adresse_future_cp character varying(255),
    tax_adresse_future_bp character varying(255),
    tax_adresse_future_cedex character varying(255),
    tax_adresse_future_pays character varying(255),
    tax_adresse_future_division character varying(255),
    co_bat_projete text,
    co_bat_existant text,
    co_bat_nature text,
    terr_juri_titul_date date,
    co_autre_desc text,
    co_trx_autre text,
    co_autre boolean DEFAULT false,
    erp_modif_facades boolean DEFAULT false,
    erp_trvx_adap boolean DEFAULT false,
    erp_trvx_adap_numero character varying(255),
    erp_trvx_adap_valid date,
    erp_prod_dangereux boolean DEFAULT false,
    co_trav_supp_dessus numeric,
    co_trav_supp_dessous numeric,
    tax_su_habit_abr_jard_pig_colom numeric,
    enga_decla_donnees_nomi_comm boolean DEFAULT false,
    x1l_legislation boolean DEFAULT false,
    x1p_precisions character varying(40),
    x1u_raccordement boolean DEFAULT false,
    x2m_inscritmh boolean DEFAULT false,
    s1na1_numero integer,
    s1va1_voie character varying(40),
    s1wa1_lieudit character varying(40),
    s1la1_localite character varying(60),
    s1pa1_codepostal character varying(5),
    s1na2_numero integer,
    s1va2_voie character varying(40),
    s1wa2_lieudit character varying(40),
    s1la2_localite character varying(60),
    s1pa2_codepostal character varying(5),
    e3c_certification boolean DEFAULT false,
    e3a_competence boolean DEFAULT false,
    a4d_description character varying(1000),
    m2b_abf boolean DEFAULT false,
    m2j_pn boolean DEFAULT false,
    m2r_cdac boolean DEFAULT false,
    m2r_cnac boolean DEFAULT false,
    u3a_voirieoui boolean DEFAULT false,
    u3f_voirienon boolean DEFAULT false,
    u3c_eauoui boolean DEFAULT false,
    u3h_eaunon boolean DEFAULT false,
    u3g_assainissementoui boolean DEFAULT false,
    u3n_assainissementnon boolean DEFAULT false,
    u3m_electriciteoui boolean DEFAULT false,
    u3b_electricitenon boolean DEFAULT false,
    u3t_observations character varying(50),
    u1a_voirieoui boolean DEFAULT false,
    u1v_voirienon boolean DEFAULT false,
    u1q_voirieconcessionnaire character varying(30),
    u1b_voirieavant date,
    u1j_eauoui boolean DEFAULT false,
    u1t_eaunon boolean DEFAULT false,
    u1e_eauconcessionnaire character varying(30),
    u1k_eauavant date,
    u1s_assainissementoui boolean DEFAULT false,
    u1d_assainissementnon boolean DEFAULT false,
    u1l_assainissementconcessionnaire character varying(30),
    u1r_assainissementavant date,
    u1c_electriciteoui boolean DEFAULT false,
    u1u_electricitenon boolean DEFAULT false,
    u1m_electriciteconcessionnaire character varying(30),
    u1f_electriciteavant date,
    u2a_observations character varying(600),
    f1ts4_surftaxestation integer,
    f1ut1_surfcree integer,
    f9d_date date,
    f9n_nom character varying(40),
    su2_avt_shon21 numeric,
    su2_avt_shon22 numeric,
    su2_cstr_shon21 numeric,
    su2_cstr_shon22 numeric,
    su2_chge_shon21 numeric,
    su2_chge_shon22 numeric,
    su2_demo_shon21 numeric,
    su2_demo_shon22 numeric,
    su2_sup_shon21 numeric,
    su2_sup_shon22 numeric,
    su2_tot_shon21 numeric,
    su2_tot_shon22 numeric,
    f1gu1_f1gu2_f1gu3 numeric,
    f1lu1_f1lu2_f1lu3 numeric,
    f1zu1_f1zu2_f1zu3 numeric,
    f1pu1_f1pu2_f1pu3 numeric,
    f1gt4_f1gt5_f1gt6 numeric,
    f1lt4_f1lt5_f1lt6 numeric,
    f1zt4_f1zt5_f1zt6 numeric,
    f1pt4_f1pt5_f1pt6 numeric,
    f1xu1_f1xu2_f1xu3 numeric,
    f1xt4_f1xt5_f1xt6 numeric,
    f1hu1_f1hu2_f1hu3 numeric,
    f1mu1_f1mu2_f1mu3 numeric,
    f1qu1_f1qu2_f1qu3 numeric,
    f1ht4_f1ht5_f1ht6 numeric,
    f1mt4_f1mt5_f1mt6 numeric,
    f1qt4_f1qt5_f1qt6 numeric,
    f2cu1_f2cu2_f2cu3 numeric,
    f2bu1_f2bu2_f2bu3 numeric,
    f2su1_f2su2_f2su3 numeric,
    f2hu1_f2hu2_f2hu3 numeric,
    f2eu1_f2eu2_f2eu3 numeric,
    f2qu1_f2qu2_f2qu3 numeric,
    f2ct4_f2ct5_f2ct6 numeric,
    f2bt4_f2bt5_f2bt6 numeric,
    f2st4_f2st5_f2st6 numeric,
    f2ht4_f2ht5_f2ht6 numeric,
    f2et4_f2et5_f2et6 numeric,
    f2qt4_f2qt5_f2qt6 numeric,
    dia_droit_reel_perso_grevant_bien_desc text,
    dia_mod_cess_paie_nat_desc text,
    dia_mod_cess_rente_viag_desc text,
    dia_mod_cess_echange_desc text,
    dia_mod_cess_apport_societe_desc text,
    dia_mod_cess_cess_terr_loc_co_desc text,
    dia_mod_cess_esti_imm_loca_desc text,
    dia_mod_cess_adju_obl_desc text,
    dia_mod_cess_adju_fin_indivi_desc text,
    dia_cadre_titul_droit_prempt text,
    dia_mairie_prix_moyen numeric,
    dia_propri_indivi text,
    dia_situa_bien_plan_cadas_oui boolean DEFAULT false,
    dia_situa_bien_plan_cadas_non boolean DEFAULT false,
    dia_notif_dec_titul_adr_prop boolean DEFAULT false,
    dia_notif_dec_titul_adr_prop_desc text,
    dia_notif_dec_titul_adr_manda boolean DEFAULT false,
    dia_notif_dec_titul_adr_manda_desc text,
    dia_dia_dpu boolean DEFAULT false,
    dia_dia_zad boolean DEFAULT false,
    dia_dia_zone_preempt_esp_natu_sensi boolean DEFAULT false,
    dia_dab_dpu boolean DEFAULT false,
    dia_dab_zad boolean DEFAULT false,
    dia_mod_cess_commi_mnt numeric,
    dia_mod_cess_commi_mnt_ttc boolean DEFAULT false,
    dia_mod_cess_commi_mnt_ht boolean DEFAULT false,
    dia_mod_cess_prix_vente_num numeric,
    dia_mod_cess_prix_vente_mob_num numeric,
    dia_mod_cess_prix_vente_cheptel_num numeric,
    dia_mod_cess_prix_vente_recol_num numeric,
    dia_mod_cess_prix_vente_autre_num numeric,
    dia_su_co_sol_num numeric,
    dia_su_util_hab_num numeric,
    dia_mod_cess_mnt_an_num numeric,
    dia_mod_cess_mnt_compt_num numeric,
    dia_mod_cess_mnt_soulte_num numeric,
    dia_comp_prix_vente numeric,
    dia_comp_surface numeric,
    dia_comp_total_frais numeric,
    dia_comp_mtn_total numeric,
    dia_comp_valeur_m2 numeric,
    dia_esti_prix_france_dom numeric,
    dia_prop_collectivite numeric,
    dia_delegataire_denomination character varying(40),
    dia_delegataire_raison_sociale character varying(50),
    dia_delegataire_siret character varying(15),
    dia_delegataire_categorie_juridique character varying(15),
    dia_delegataire_representant_nom character varying(250),
    dia_delegataire_representant_prenom character varying(250),
    dia_delegataire_adresse_numero character varying(10),
    dia_delegataire_adresse_voie character varying(55),
    dia_delegataire_adresse_complement character varying(50),
    dia_delegataire_adresse_lieu_dit character varying(39),
    dia_delegataire_adresse_localite character varying(250),
    dia_delegataire_adresse_code_postal character varying(5),
    dia_delegataire_adresse_bp character varying(5),
    dia_delegataire_adresse_cedex character varying(5),
    dia_delegataire_adresse_pays character varying(250),
    dia_delegataire_telephone_fixe character varying(20),
    dia_delegataire_telephone_mobile character varying(20),
    dia_delegataire_telephone_mobile_indicatif character varying(5),
    dia_delegataire_courriel character varying(250),
    dia_delegataire_fax character varying(20),
    dia_entree_jouissance_type character varying(250),
    dia_entree_jouissance_date date,
    dia_entree_jouissance_date_effet date,
    dia_entree_jouissance_com text,
    dia_remise_bien_date_effet date,
    dia_remise_bien_com text,
    c2zp1_crete numeric,
    c2zr1_destination character varying(70),
    mh_design_appel_denom text,
    mh_design_type_protect character varying(200),
    mh_design_elem_prot text,
    mh_design_ref_merimee_palissy character varying(10),
    mh_design_nature_prop character varying(200),
    mh_loc_denom text,
    mh_pres_intitule text,
    mh_trav_cat_1 boolean DEFAULT false,
    mh_trav_cat_2 boolean DEFAULT false,
    mh_trav_cat_3 boolean DEFAULT false,
    mh_trav_cat_4 boolean DEFAULT false,
    mh_trav_cat_5 boolean DEFAULT false,
    mh_trav_cat_6 boolean DEFAULT false,
    mh_trav_cat_7 boolean DEFAULT false,
    mh_trav_cat_8 boolean DEFAULT false,
    mh_trav_cat_9 boolean DEFAULT false,
    mh_trav_cat_10 boolean DEFAULT false,
    mh_trav_cat_11 boolean DEFAULT false,
    mh_trav_cat_12 boolean DEFAULT false,
    mh_trav_cat_12_prec text
);


--
-- Name: TABLE donnees_techniques; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE donnees_techniques IS 'Données techniques';


--
-- Name: COLUMN donnees_techniques.donnees_techniques; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.donnees_techniques IS 'Identifiant unique';


--
-- Name: COLUMN donnees_techniques.dossier_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dossier_instruction IS 'Dossier d''instruction auquel sont rattachés les données techniques';


--
-- Name: COLUMN donnees_techniques.lot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.lot IS 'Lot sur lequel sont rattachés les données techniques';


--
-- Name: COLUMN donnees_techniques.am_lotiss; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lotiss IS 'Lotissement';


--
-- Name: COLUMN donnees_techniques.am_autre_div; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_autre_div IS 'Remembrement réalisé par une association foncière urbaine libre';


--
-- Name: COLUMN donnees_techniques.am_camping; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_camping IS 'Terrain de camping';


--
-- Name: COLUMN donnees_techniques.am_caravane; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_caravane IS 'Installation d’une caravane en dehors d’un terrain de camping ou d’un parc résidentiel de loisirs';


--
-- Name: COLUMN donnees_techniques.am_carav_duree; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_carav_duree IS 'Durée annuelle d’installation (en mois)';


--
-- Name: COLUMN donnees_techniques.am_statio; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_statio IS 'Aires de stationnement ouvertes au public, dépôts de véhicules et garages collectifs de caravanes ou de résidences mobiles de loisirs';


--
-- Name: COLUMN donnees_techniques.am_statio_cont; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_statio_cont IS 'Contenance de l''aire de stationnement (nombre d’unités)';


--
-- Name: COLUMN donnees_techniques.am_affou_exhau; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_affou_exhau IS 'Travaux d’affouillements ou d’exhaussements du sol';


--
-- Name: COLUMN donnees_techniques.am_affou_exhau_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_affou_exhau_sup IS 'Superficie (en m2) des travaux d’affouillements ou d’exhaussements du sol';


--
-- Name: COLUMN donnees_techniques.am_affou_prof; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_affou_prof IS 'Profondeur pour les travaux affouillements du sol';


--
-- Name: COLUMN donnees_techniques.am_exhau_haut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_exhau_haut IS 'Hauteur pour les travaux exhaussements du sol';


--
-- Name: COLUMN donnees_techniques.am_coupe_abat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_abat IS 'Coupe et abattage d’arbres';


--
-- Name: COLUMN donnees_techniques.am_prot_plu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_prot_plu IS 'Modification ou suppression d’un élément protégé par un plan local d’urbanisme ou document d’urbanisme en tenant lieu (plan d’occupation des sols, plan de sauvegarde et de mise en valeur, plan d’aménagement de zone)';


--
-- Name: COLUMN donnees_techniques.am_prot_muni; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_prot_muni IS 'Modification ou suppression d’un élément protégé par une délibération du conseil municipal';


--
-- Name: COLUMN donnees_techniques.am_mobil_voyage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_mobil_voyage IS 'Installation d’une résidence mobile constituant l’habitat permanent des gens du voyage pendant plus de trois mois consécutifs';


--
-- Name: COLUMN donnees_techniques.am_aire_voyage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_aire_voyage IS 'Aire d’accueil des gens du voyage';


--
-- Name: COLUMN donnees_techniques.am_rememb_afu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_rememb_afu IS 'Travaux ayant pour effet de modifier l''aménagement des espaces non bâtis autour d''un bâtiment existant situé dans le périmètre d''un site patrimonial remarquable ou abords d''un monument historique';


--
-- Name: COLUMN donnees_techniques.am_parc_resid_loi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_parc_resid_loi IS 'Parc résidentiel de loisirs ou village de vacances';


--
-- Name: COLUMN donnees_techniques.am_sport_moto; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_sport_moto IS 'Aménagement d’un terrain pour la pratique de sports ou de loisirs motorisés';


--
-- Name: COLUMN donnees_techniques.am_sport_attrac; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_sport_attrac IS 'Aménagement d’un parc d’attraction ou d’une aire de jeux et de sports';


--
-- Name: COLUMN donnees_techniques.am_sport_golf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_sport_golf IS 'Aménagement d’un golf';


--
-- Name: COLUMN donnees_techniques.am_mob_art; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_mob_art IS 'Installation de mobilier urbain, d’œuvre d’art';


--
-- Name: COLUMN donnees_techniques.am_modif_voie_esp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_modif_voie_esp IS 'Modification de voie ou espace publics';


--
-- Name: COLUMN donnees_techniques.am_plant_voie_esp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_plant_voie_esp IS 'Plantations effectuées sur les voies ou espaces publics';


--
-- Name: COLUMN donnees_techniques.am_chem_ouv_esp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_chem_ouv_esp IS 'Chemin piétonnier ou objet mobilier destiné à l’accueil ou à l’information du public, lorsqu’ils sont nécessaires à la gestion ou à l’ouverture au public de ces espaces ou milieux';


--
-- Name: COLUMN donnees_techniques.am_agri_peche; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_agri_peche IS 'Aménagement nécessaire à l’exercice des activités agricoles, de pêche et de culture marine ou lacustres, conchylicoles, pastorales et forestières';


--
-- Name: COLUMN donnees_techniques.am_crea_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_crea_voie IS 'Création d’une voie';


--
-- Name: COLUMN donnees_techniques.am_modif_voie_exist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_modif_voie_exist IS 'Travaux ayant pour effet de modifier les caractéristiques d’une voie existante';


--
-- Name: COLUMN donnees_techniques.am_crea_esp_sauv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_crea_esp_sauv IS 'Création d’un espace public (secteur sauvegardé)';


--
-- Name: COLUMN donnees_techniques.am_crea_esp_class; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_crea_esp_class IS 'Création d’un espace public (site classé)';


--
-- Name: COLUMN donnees_techniques.am_projet_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_projet_desc IS 'Description de votre projet de construction';


--
-- Name: COLUMN donnees_techniques.am_terr_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_terr_surf IS 'Superficie du (ou des) terrain(s) à aménager (en m²)';


--
-- Name: COLUMN donnees_techniques.am_tranche_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_tranche_desc IS 'Si les travaux sont réalisés par tranches, en préciser le nombre et leur contenu';


--
-- Name: COLUMN donnees_techniques.am_lot_max_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_max_nb IS 'Nombre maximum de lots projetés';


--
-- Name: COLUMN donnees_techniques.am_lot_max_shon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_max_shon IS 'Surface de plancher maximale envisagée (en m²) des lots';


--
-- Name: COLUMN donnees_techniques.am_lot_cstr_cos; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_cstr_cos IS 'Par application du coefficient d’occupation du sol (COS) à chaque lot';


--
-- Name: COLUMN donnees_techniques.am_lot_cstr_plan; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_cstr_plan IS 'Conformément aux plans ou tableaux joints à la présente demande';


--
-- Name: COLUMN donnees_techniques.am_lot_cstr_vente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_cstr_vente IS 'La constructibilité sera déterminée à la vente de chaque lot. Dans ce cas, le lotisseur devra fournir un certificat aux constructeurs.';


--
-- Name: COLUMN donnees_techniques.am_lot_fin_diff; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_fin_diff IS 'Le projet fait l’objet d’une demande de travaux de finition différés';


--
-- Name: COLUMN donnees_techniques.am_lot_consign; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_consign IS 'Consignation en compte bloqué';


--
-- Name: COLUMN donnees_techniques.am_lot_gar_achev; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_gar_achev IS 'Garantie financière d’achèvement des travaux';


--
-- Name: COLUMN donnees_techniques.am_lot_vente_ant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_vente_ant IS 'Le projet fait l’objet d’une demande de vente ou location de lots par anticipation';


--
-- Name: COLUMN donnees_techniques.am_empl_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_empl_nb IS 'Nombre maximum d’emplacements réservés aux tentes, caravanes ou résidences mobiles de loisirs';


--
-- Name: COLUMN donnees_techniques.am_tente_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_tente_nb IS 'Nombre maximum d’emplacements réservés aux tentes';


--
-- Name: COLUMN donnees_techniques.am_carav_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_carav_nb IS 'Nombre maximum d’emplacements réservés aux caravanes ';


--
-- Name: COLUMN donnees_techniques.am_mobil_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_mobil_nb IS 'Nombre maximum d’emplacements réservés aux mobiles de loisirs';


--
-- Name: COLUMN donnees_techniques.am_pers_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_pers_nb IS 'Nombre maximal de personnes accueillies';


--
-- Name: COLUMN donnees_techniques.am_empl_hll_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_empl_hll_nb IS 'Nombre d’emplacements réservés aux HLL';


--
-- Name: COLUMN donnees_techniques.am_hll_shon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_hll_shon IS 'Surface de plancher prévue, réservée aux HLL';


--
-- Name: COLUMN donnees_techniques.am_periode_exploit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_periode_exploit IS 'Lorsque le terrain est destiné à une exploitation saisonnière, veuillez préciser la (ou les) période(s) d’exploitation';


--
-- Name: COLUMN donnees_techniques.am_exist_agrand; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_exist_agrand IS 'Agrandissement ou ré-aménagement d’une structure existante';


--
-- Name: COLUMN donnees_techniques.am_exist_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_exist_date IS 'Date et/ou numéro de l’autorisation';


--
-- Name: COLUMN donnees_techniques.am_exist_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_exist_num IS 'Nombre d’emplacements';


--
-- Name: COLUMN donnees_techniques.am_exist_nb_avant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_exist_nb_avant IS 'Nombre d’emplacements avant agrandissement ou ré-aménagement';


--
-- Name: COLUMN donnees_techniques.am_exist_nb_apres; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_exist_nb_apres IS 'Nombre d’emplacements après agrandissement ou ré-aménagement';


--
-- Name: COLUMN donnees_techniques.am_coupe_bois; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_bois IS 'Description de l''environnement : bois ou forêt';


--
-- Name: COLUMN donnees_techniques.am_coupe_parc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_parc IS 'Description de l''environnement : parc';


--
-- Name: COLUMN donnees_techniques.am_coupe_align; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_align IS 'Description de l''environnement : alignement (espaces verts urbains)';


--
-- Name: COLUMN donnees_techniques.am_coupe_ess; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_ess IS 'Nature du boisement : Essences';


--
-- Name: COLUMN donnees_techniques.am_coupe_age; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_age IS 'Nature du boisement : Age';


--
-- Name: COLUMN donnees_techniques.am_coupe_dens; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_dens IS 'Nature du boisement : Densité';


--
-- Name: COLUMN donnees_techniques.am_coupe_qual; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_qual IS 'Nature du boisement : Qualité';


--
-- Name: COLUMN donnees_techniques.am_coupe_trait; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_trait IS 'Nature du boisement : Traitement';


--
-- Name: COLUMN donnees_techniques.am_coupe_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_coupe_autr IS 'Nature du boisement : Autres';


--
-- Name: COLUMN donnees_techniques.co_archi_recours; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_archi_recours IS 'Vous avez eu recours à un architecte';


--
-- Name: COLUMN donnees_techniques.co_cstr_nouv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_cstr_nouv IS 'Nouvelle construction';


--
-- Name: COLUMN donnees_techniques.co_cstr_exist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_cstr_exist IS 'Travaux ou changement de destination sur une construction existante';


--
-- Name: COLUMN donnees_techniques.co_cloture; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_cloture IS 'Travaux clôturés';


--
-- Name: COLUMN donnees_techniques.co_elec_tension; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_elec_tension IS 'Puissance électrique nécessaire à votre projet';


--
-- Name: COLUMN donnees_techniques.co_div_terr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_div_terr IS 'Le terrain doit être divisé en propriété ou en jouissance avant l’achèvement de la (ou des) construction(s)';


--
-- Name: COLUMN donnees_techniques.co_projet_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_projet_desc IS 'Courte description de votre projet ou de vos travaux';


--
-- Name: COLUMN donnees_techniques.co_anx_pisc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_anx_pisc IS 'Complément construction : Piscine';


--
-- Name: COLUMN donnees_techniques.co_anx_gara; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_anx_gara IS 'Complément construction : Garage';


--
-- Name: COLUMN donnees_techniques.co_anx_veran; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_anx_veran IS 'Complément construction : Véranda';


--
-- Name: COLUMN donnees_techniques.co_anx_abri; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_anx_abri IS 'Complément construction : Abri de jardin';


--
-- Name: COLUMN donnees_techniques.co_anx_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_anx_autr IS 'Complément construction : Autres annexes à l’habitation';


--
-- Name: COLUMN donnees_techniques.co_anx_autr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_anx_autr_desc IS 'Informations complémentaires sur les autres annexes à l’habitation';


--
-- Name: COLUMN donnees_techniques.co_tot_log_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_tot_log_nb IS 'Nombre total de logements créés';


--
-- Name: COLUMN donnees_techniques.co_tot_ind_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_tot_ind_nb IS 'Nombre total de logements individuels créés';


--
-- Name: COLUMN donnees_techniques.co_tot_coll_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_tot_coll_nb IS 'Nombre total de logements collectifs créés';


--
-- Name: COLUMN donnees_techniques.co_mais_piece_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_mais_piece_nb IS 'Nombre de pièces de la maison';


--
-- Name: COLUMN donnees_techniques.co_mais_niv_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_mais_niv_nb IS 'Nombre de niveaux de la maison';


--
-- Name: COLUMN donnees_techniques.co_fin_lls_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_fin_lls_nb IS 'Répartition du nombre total de logement créés par type de financement : Logement Locatif Social';


--
-- Name: COLUMN donnees_techniques.co_fin_aa_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_fin_aa_nb IS 'Répartition du nombre total de logement créés par type de financement : Accession Sociale (hors prêt à taux zéro)';


--
-- Name: COLUMN donnees_techniques.co_fin_ptz_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_fin_ptz_nb IS 'Répartition du nombre total de logement créés par type de financement : Prêt à taux zéro';


--
-- Name: COLUMN donnees_techniques.co_fin_autr_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_fin_autr_nb IS 'Répartition du nombre total de logement créés par type de financement : Autres financements [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.co_fin_autr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_fin_autr_desc IS 'Description des autres financements';


--
-- Name: COLUMN donnees_techniques.co_mais_contrat_ind; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_mais_contrat_ind IS 'Souscrit un contrat de construction de maison individuelle';


--
-- Name: COLUMN donnees_techniques.co_uti_pers; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_uti_pers IS 'Occupation personnelle ou en compte propre';


--
-- Name: COLUMN donnees_techniques.co_uti_vente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_uti_vente IS 'Mode d''utilisation principale des logements : Pour la vente';


--
-- Name: COLUMN donnees_techniques.co_uti_loc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_uti_loc IS 'Mode d''utilisation principale des logements : Pour la location';


--
-- Name: COLUMN donnees_techniques.co_uti_princ; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_uti_princ IS 'Occupation personnelle : Résidence principale';


--
-- Name: COLUMN donnees_techniques.co_uti_secon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_uti_secon IS 'Occupation personnelle : Résidence secondaire';


--
-- Name: COLUMN donnees_techniques.co_resid_agees; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_resid_agees IS 'Projet foyer ou résidence : Résidence pour personnes âgées';


--
-- Name: COLUMN donnees_techniques.co_resid_etud; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_resid_etud IS 'Projet foyer ou résidence : Résidence pour étudiants';


--
-- Name: COLUMN donnees_techniques.co_resid_tourism; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_resid_tourism IS 'Projet foyer ou résidence : Résidence de tourisme';


--
-- Name: COLUMN donnees_techniques.co_resid_hot_soc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_resid_hot_soc IS 'Projet foyer ou résidence : Résidence hôtelière à vocation sociale';


--
-- Name: COLUMN donnees_techniques.co_resid_soc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_resid_soc IS 'Projet foyer ou résidence : Résidence sociale';


--
-- Name: COLUMN donnees_techniques.co_resid_hand; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_resid_hand IS 'Projet foyer ou résidence : Résidence pour personnes handicapées';


--
-- Name: COLUMN donnees_techniques.co_resid_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_resid_autr IS 'Projet foyer ou résidence : Résidence autres';


--
-- Name: COLUMN donnees_techniques.co_resid_autr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_resid_autr_desc IS 'Précision sur résidence autres';


--
-- Name: COLUMN donnees_techniques.co_foyer_chamb_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_foyer_chamb_nb IS 'Nombre de chambres créées en foyer ou dans un hébergement d’un autre type';


--
-- Name: COLUMN donnees_techniques.co_log_1p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_log_1p_nb IS 'Repartition du nombre de logements créés selon le nombre de pièces : 1 pièce';


--
-- Name: COLUMN donnees_techniques.co_log_2p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_log_2p_nb IS 'Repartition du nombre de logements créés selon le nombre de pièces : 2 pièces';


--
-- Name: COLUMN donnees_techniques.co_log_3p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_log_3p_nb IS 'Repartition du nombre de logements créés selon le nombre de pièces : 3 pièces';


--
-- Name: COLUMN donnees_techniques.co_log_4p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_log_4p_nb IS 'Repartition du nombre de logements créés selon le nombre de pièces : 4 pièces';


--
-- Name: COLUMN donnees_techniques.co_log_5p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_log_5p_nb IS 'Repartition du nombre de logements créés selon le nombre de pièces : 5 pièces';


--
-- Name: COLUMN donnees_techniques.co_log_6p_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_log_6p_nb IS 'Repartition du nombre de logements créés selon le nombre de pièces : 6 pièces';


--
-- Name: COLUMN donnees_techniques.co_bat_niv_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_bat_niv_nb IS 'Le nombre de niveaux du bâtiment le plus élevé : au-dessus du sol';


--
-- Name: COLUMN donnees_techniques.co_trx_exten; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_trx_exten IS 'Travaux comprennent notamment : Extension';


--
-- Name: COLUMN donnees_techniques.co_trx_surelev; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_trx_surelev IS 'Travaux comprennent notamment : Surélévation';


--
-- Name: COLUMN donnees_techniques.co_trx_nivsup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_trx_nivsup IS 'Travaux comprennent notamment : Création de niveaux supplémentaires';


--
-- Name: COLUMN donnees_techniques.co_demont_periode; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_demont_periode IS 'Période(s) de l’année durant laquelle (lesquelles) la construction doit être démontée';


--
-- Name: COLUMN donnees_techniques.co_sp_transport; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_sp_transport IS 'Destination des constructions futures en cas de réalisation au bénéfice d''un service public ou d''intérêt collectif : Transport';


--
-- Name: COLUMN donnees_techniques.co_sp_enseign; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_sp_enseign IS 'Destination des constructions futures en cas de réalisation au bénéfice d''un service public ou d''intérêt collectif : Enseignement et recherche';


--
-- Name: COLUMN donnees_techniques.co_sp_act_soc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_sp_act_soc IS 'Destination des constructions futures en cas de réalisation au bénéfice d''un service public ou d''intérêt collectif : Action sociale';


--
-- Name: COLUMN donnees_techniques.co_sp_ouvr_spe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_sp_ouvr_spe IS 'Destination des constructions futures en cas de réalisation au bénéfice d''un service public ou d''intérêt collectif : Ouvrage spécial';


--
-- Name: COLUMN donnees_techniques.co_sp_sante; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_sp_sante IS 'Destination des constructions futures en cas de réalisation au bénéfice d''un service public ou d''intérêt collectif : Santé';


--
-- Name: COLUMN donnees_techniques.co_sp_culture; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_sp_culture IS 'Destination des constructions futures en cas de réalisation au bénéfice d''un service public ou d''intérêt collectif : Culture et loisir';


--
-- Name: COLUMN donnees_techniques.co_statio_avt_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_avt_nb IS 'Nombre de places de stationnement avant réalisation du projet';


--
-- Name: COLUMN donnees_techniques.co_statio_apr_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_apr_nb IS 'Nombre de places de stationnement après réalisation du projet';


--
-- Name: COLUMN donnees_techniques.co_statio_adr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_adr IS 'Adresse(s) des aires de stationnement [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.co_statio_place_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_place_nb IS 'Nombre de places affectées au projet, aménagées ou réservées en dehors du terrain sur lequel est situé le projet';


--
-- Name: COLUMN donnees_techniques.co_statio_tot_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_tot_surf IS 'Surface totale affectée au stationnement';


--
-- Name: COLUMN donnees_techniques.co_statio_tot_shob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_tot_shob IS 'Surface bâtie affectée au stationnement';


--
-- Name: COLUMN donnees_techniques.co_statio_comm_cin_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_comm_cin_surf IS 'Emprise au sol des surfaces, bâties ou non, affectées au stationnement';


--
-- Name: COLUMN donnees_techniques.su_avt_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon1 IS 'Tableau des surface, ligne : Habitation, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_avt_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon2 IS 'Tableau des surface, ligne : Hébergement hôtelier, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_avt_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon3 IS 'Tableau des surface, ligne : Bureau, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_avt_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon4 IS 'Tableau des surface, ligne : Commerce, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_avt_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon5 IS 'Tableau des surface, ligne : Artisanat, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_avt_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon6 IS 'Tableau des surface, ligne : Industrie, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_avt_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon7 IS 'Tableau des surface, ligne : Exploitation agricole ou forestière, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_avt_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon8 IS 'Tableau des surface, ligne : Entrepôt, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_avt_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon9 IS 'Tableau des surface, ligne : Service public ou d''intérêt collectif, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon1 IS 'Tableau des surface, ligne : Habitation, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon2 IS 'Tableau des surface, ligne : Hébergement hôtelier, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon3 IS 'Tableau des surface, ligne : Bureau, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon4 IS 'Tableau des surface, ligne : Commerce, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon5 IS 'Tableau des surface, ligne : Artisanat, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon6 IS 'Tableau des surface, ligne : Industrie, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon7 IS 'Tableau des surface, ligne : Exploitation agricole ou forestière, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon8 IS 'Tableau des surface, ligne : Entrepôt, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon9 IS 'Tableau des surface, ligne : Service public ou d''intérêt collectif, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon1 IS 'Tableau des surface, ligne : Habitation, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon2 IS 'Tableau des surface, ligne : Hébergement hôtelier, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon3 IS 'Tableau des surface, ligne : Bureau, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon4 IS 'Tableau des surface, ligne : Commerce, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon5 IS 'Tableau des surface, ligne : Artisanat, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon6 IS 'Tableau des surface, ligne : Industrie, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon7 IS 'Tableau des surface, ligne : Exploitation agricole ou forestière, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon8 IS 'Tableau des surface, ligne : Entrepôt, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon9 IS 'Tableau des surface, ligne : Service public ou d''intérêt collectif, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon1 IS 'Tableau des surface, ligne : Habitation, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon2 IS 'Tableau des surface, ligne : Hébergement hôtelier, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon3 IS 'Tableau des surface, ligne : Bureau, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon4 IS 'Tableau des surface, ligne : Commerce, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon5 IS 'Tableau des surface, ligne : Artisanat, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon6 IS 'Tableau des surface, ligne : Industrie, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon7 IS 'Tableau des surface, ligne : Exploitation agricole ou forestière, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon8 IS 'Tableau des surface, ligne : Entrepôt, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon9 IS 'Tableau des surface, ligne : Service public ou d''intérêt collectif, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon1 IS 'Tableau des surface, ligne : Habitation, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon2 IS 'Tableau des surface, ligne : Hébergement hôtelier, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon3 IS 'Tableau des surface, ligne : Bureau, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon4 IS 'Tableau des surface, ligne : Commerce, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon5 IS 'Tableau des surface, ligne : Artisanat, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon6 IS 'Tableau des surface, ligne : Industrie, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon7 IS 'Tableau des surface, ligne : Exploitation agricole ou forestière, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon8 IS 'Tableau des surface, ligne : Entrepôt, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon9 IS 'Tableau des surface, ligne : Service public ou d''intérêt collectif, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_sup_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon1 IS 'Tableau des surface, ligne : Habitation, colonne : ?';


--
-- Name: COLUMN donnees_techniques.su_sup_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon2 IS 'Tableau des surface, ligne : Hébergement hôtelier, colonne : ?';


--
-- Name: COLUMN donnees_techniques.su_sup_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon3 IS 'Tableau des surface, ligne : Bureau, colonne : ?';


--
-- Name: COLUMN donnees_techniques.su_sup_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon4 IS 'Tableau des surface, ligne : Commerce, colonne : ?';


--
-- Name: COLUMN donnees_techniques.su_sup_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon5 IS 'Tableau des surface, ligne : Artisanat, colonne : ?';


--
-- Name: COLUMN donnees_techniques.su_sup_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon6 IS 'Tableau des surface, ligne : Industrie, colonne : ?';


--
-- Name: COLUMN donnees_techniques.su_sup_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon7 IS 'Tableau des surface, ligne : Exploitation agricole ou forestière, colonne : ?';


--
-- Name: COLUMN donnees_techniques.su_sup_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon8 IS 'Tableau des surface, ligne : Entrepôt, colonne : ?';


--
-- Name: COLUMN donnees_techniques.su_sup_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon9 IS 'Tableau des surface, ligne : Service public ou d''intérêt collectif, colonne : ';


--
-- Name: COLUMN donnees_techniques.su_tot_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon1 IS 'Tableau des surface, ligne : Habitation, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.su_tot_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon2 IS 'Tableau des surface, ligne : Hébergement hôtelier, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.su_tot_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon3 IS 'Tableau des surface, ligne : Bureau, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.su_tot_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon4 IS 'Tableau des surface, ligne : Commerce, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.su_tot_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon5 IS 'Tableau des surface, ligne : Artisanat, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.su_tot_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon6 IS 'Tableau des surface, ligne : Industrie, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.su_tot_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon7 IS 'Tableau des surface, ligne : Exploitation agricole ou forestière, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.su_tot_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon8 IS 'Tableau des surface, ligne : Entrepôt, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.su_tot_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon9 IS 'Tableau des surface, ligne : Service public ou d''intérêt collectif, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.su_avt_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_avt_shon_tot IS 'Tableau des surface, ligne : Surfaces totales, colonne : Surface existante avant travaux (A)';


--
-- Name: COLUMN donnees_techniques.su_cstr_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_cstr_shon_tot IS 'Tableau des surface, ligne : Surfaces totales, colonne : Surface créée (B)';


--
-- Name: COLUMN donnees_techniques.su_trsf_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_trsf_shon_tot IS 'Tableau des surface, ligne : Surfaces totales, colonne : Surface créée par changement de destination (C)';


--
-- Name: COLUMN donnees_techniques.su_chge_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_chge_shon_tot IS 'Tableau des surface, ligne : Surfaces totales, colonne : Surface supprimée (D)';


--
-- Name: COLUMN donnees_techniques.su_demo_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_demo_shon_tot IS 'Tableau des surface, ligne : Surfaces totales, colonne : Surface supprimée par changement de destination (E)';


--
-- Name: COLUMN donnees_techniques.su_sup_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_sup_shon_tot IS 'Tableau des surface, ligne : Surfaces totales, colonne : ';


--
-- Name: COLUMN donnees_techniques.su_tot_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su_tot_shon_tot IS 'Tableau des surface, ligne : Surfaces totales, colonne : Surface totale = (a)+(B)+(C)-(D)-(E)';


--
-- Name: COLUMN donnees_techniques.dm_constr_dates; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dm_constr_dates IS 'Date(s) approximative(s) à laquelle le ou les bâtiments dont la démolition est envisagée ont été construits';


--
-- Name: COLUMN donnees_techniques.dm_total; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dm_total IS 'Démolition totale';


--
-- Name: COLUMN donnees_techniques.dm_partiel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dm_partiel IS 'Démolition partielle';


--
-- Name: COLUMN donnees_techniques.dm_projet_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dm_projet_desc IS 'En cas de démolition partielle, veuillez décrire les travaux qui seront, le cas échéant, effectués sur les constructions restantes';


--
-- Name: COLUMN donnees_techniques.dm_tot_log_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dm_tot_log_nb IS 'Nombre de logement démolis';


--
-- Name: COLUMN donnees_techniques.tax_surf_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_tot IS 'Superficie taxable créée de la construction avant modification';


--
-- Name: COLUMN donnees_techniques.tax_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf IS 'Superficie taxable créée par la modification';


--
-- Name: COLUMN donnees_techniques.tax_surf_suppr_mod; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_suppr_mod IS 'Surface taxable supprimée par la modification (en m²)';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_log_nb1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_log_nb1 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Ne bénéficiant pas de prêt aidé, colonne : Nombre de logements avant modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_log_nb2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_log_nb2 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''un PLAI ou LLTS, colonne : Nombre de logements avant modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_log_nb3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_log_nb3 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''autre prêts aidés (PLUS, LES, PLSA, PLS, LLS), colonne : Nombre de logements avant modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_log_nb4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_log_nb4 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''un prêt à taux zéro plus (PTZ+), colonne : Nombre de logements avant modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_log_nb_tot1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_log_nb_tot1 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Ne bénéficiant pas de prêt aidé, colonne : Nombre total de logement après modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_log_nb_tot2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_log_nb_tot2 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''un PLAI ou LLTS, colonne : Nombre total de logement après modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_log_nb_tot3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_log_nb_tot3 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''autre prêts aidés (PLUS, LES, PLSA, PLS, LLS), colonne : Nombre total de logement après modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_log_nb_tot4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_log_nb_tot4 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''un prêt à taux zéro plus (PTZ+), colonne : Nombre total de logement après modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf1 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Ne bénéficiant pas de prêt aidé, colonne : Surfaces créées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf2 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''un PLAI ou LLTS, colonne : Surfaces créées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf3 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''autre prêts aidés (PLUS, LES, PLSA, PLS, LLS), colonne :Surfaces créées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf4 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''un prêt à taux zéro plus (PTZ+), colonne :Surfaces créées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf_sup1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_sup1 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Ne bénéficiant pas de prêt aidé, colonne : Surfaces supprimées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf_sup2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_sup2 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''un PLAI ou LLTS, colonne : Surfaces supprimées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf_sup3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_sup3 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''autre prêts aidés (PLUS, LES, PLSA, PLS, LLS), colonne : Surfaces supprimées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf_sup4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_sup4 IS 'Locaux à usage d''habitation principale et leurs annexes, ligne : Bénéficiant d''un prêt à taux zéro plus (PTZ+), colonne : Surfaces supprimées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_log_nb1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_log_nb1 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Ne bénéficiant pas d''un prêt aidé, colonne : Nombre de logements avant modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_log_nb2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_log_nb2 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Bénéficiant d''un PLAI ou LLTS, colonne : Nombre de logements avant modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_log_nb3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_log_nb3 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Bénéficiant d''autres prêts aidés, colonne : Nombre de logements avant modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_log_nb_tot1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_log_nb_tot1 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Ne bénéficiant pas d''un prêt aidé, colonne : Nombre total de logement après modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_log_nb_tot2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_log_nb_tot2 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Bénéficiant d''un PLAI ou LLTS, colonne : Nombre total de logement après modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_log_nb_tot3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_log_nb_tot3 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Bénéficiant d''autres prêts aidés, colonne : Nombre total de logement après modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_surf1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf1 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Ne bénéficiant pas d''un prêt aidé, colonne : Surfaces créées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_surf2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf2 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Bénéficiant d''un PLAI ou LLTS, colonne : Surfaces créées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_surf3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf3 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Bénéficiant d''autres prêts aidés, colonne : Surfaces créées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_surf_sup1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf_sup1 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Ne bénéficiant pas d''un prêt aidé, colonne : Surfaces supprimées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_surf_sup2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf_sup2 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Bénéficiant d''un PLAI ou LLTS, colonne : Surfaces supprimées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_surf_sup3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf_sup3 IS 'Locaux à usage d''habitation et leurs annexes, ligne : Bénéficiant d''autres prêts aidés, colonne : Surfaces supprimées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_secon_log_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_secon_log_nb IS 'Locaux à usage d''habitation secondaire et leurs annexes, colonne : Nombre de logements avant modifications';


--
-- Name: COLUMN donnees_techniques.tax_su_tot_log_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_tot_log_nb IS 'Nombre total de logements, colonne : Nombre de logements avant modifications';


--
-- Name: COLUMN donnees_techniques.tax_su_secon_log_nb_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_secon_log_nb_tot IS 'Locaux à usage d''habitation secondaire et leurs annexes, colonne : Nombre total de logements après modifications';


--
-- Name: COLUMN donnees_techniques.tax_su_tot_log_nb_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_tot_log_nb_tot IS 'Nombre total de logements, colonne : Nombre total de logements après modifications';


--
-- Name: COLUMN donnees_techniques.tax_su_secon_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_secon_surf IS 'Locaux à usage d''habitation secondaire et leurs annexes, colonne : Surfaces créées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_tot_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_tot_surf IS 'Nombre total de logements, colonne : Surfaces créées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_secon_surf_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_secon_surf_sup IS 'Locaux à usage d''habitation secondaire et leurs annexes, colonne : Surfaces supprimées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_su_tot_surf_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_tot_surf_sup IS 'Nombre total de logements, colonne : Surfaces supprimées par la modification';


--
-- Name: COLUMN donnees_techniques.tax_ext_pret; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_ext_pret IS 'Aide pour la réalisation des travaux';


--
-- Name: COLUMN donnees_techniques.tax_ext_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_ext_desc IS 'Description de l''aide pour la réalisation des travaux';


--
-- Name: COLUMN donnees_techniques.tax_surf_tax_exist_cons; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_tax_exist_cons IS 'Conserver la surface taxable existante';


--
-- Name: COLUMN donnees_techniques.tax_log_exist_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_log_exist_nb IS 'Quel est le nombre de logements existants ?';


--
-- Name: COLUMN donnees_techniques.tax_am_statio_ext; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_am_statio_ext IS 'Nombre de places de stationnement situées à l’extérieur de la construction';


--
-- Name: COLUMN donnees_techniques.tax_sup_bass_pisc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_sup_bass_pisc IS 'Superficie du bassin intérieur ou extérieur de la piscine';


--
-- Name: COLUMN donnees_techniques.tax_empl_ten_carav_mobil_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_empl_ten_carav_mobil_nb IS 'Nombre d’emplacements de tentes, de caravanes et de résidences mobiles de loisirs';


--
-- Name: COLUMN donnees_techniques.tax_empl_hll_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_empl_hll_nb IS 'Nombre d’emplacements pour les habitations légères de loisirs';


--
-- Name: COLUMN donnees_techniques.tax_eol_haut_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_eol_haut_nb IS 'Nombre d’éoliennes dont la hauteur est supérieure à 12 m';


--
-- Name: COLUMN donnees_techniques.tax_pann_volt_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_pann_volt_sup IS 'Superficie des panneaux photo-voltaïques posés au sol';


--
-- Name: COLUMN donnees_techniques.tax_am_statio_ext_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_am_statio_ext_sup IS 'Nombre de places de stationnement situées à l’extérieur de la construction';


--
-- Name: COLUMN donnees_techniques.tax_sup_bass_pisc_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_sup_bass_pisc_sup IS 'Superficie du bassin intérieur ou extérieur de la piscine';


--
-- Name: COLUMN donnees_techniques.tax_empl_ten_carav_mobil_nb_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_empl_ten_carav_mobil_nb_sup IS 'Nombre d’emplacements de tentes, de caravanes et de résidences mobiles de loisirs';


--
-- Name: COLUMN donnees_techniques.tax_empl_hll_nb_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_empl_hll_nb_sup IS 'Nombre d’emplacements pour les habitations légères de loisirs';


--
-- Name: COLUMN donnees_techniques.tax_eol_haut_nb_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_eol_haut_nb_sup IS 'Nombre d’éoliennes dont la hauteur est supérieure à 12 m';


--
-- Name: COLUMN donnees_techniques.tax_pann_volt_sup_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_pann_volt_sup_sup IS 'Superficie des panneaux photo-voltaïques posés au sol';


--
-- Name: COLUMN donnees_techniques.tax_trx_presc_ppr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_trx_presc_ppr IS 'Les travaux projetés sont-ils réalisés suite à des prescriptions résultant d’un Plan de Prévention des Risques naturels, technologiques ou miniers ?';


--
-- Name: COLUMN donnees_techniques.tax_monu_hist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_monu_hist IS 'La construction projetée concerne t-elle un immeuble classé pasrmi les monuments historiques ou inscrit à l’inventaire des monuments historiques ?';


--
-- Name: COLUMN donnees_techniques.tax_comm_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_comm_nb IS 'Nombre de commerces de détail dont la surface de vente est inférieure à 400 m²';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf1 IS 'Surfaces taxables non destinés à l''habitation, ligne : Commerce inférieur à 400m², colonne : Surfaces créées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf2 IS 'Surfaces taxables non destinés à l''habitation, ligne : Locaux industriels et leurs annexes, colonne : Surfaces créées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf3 IS 'Surfaces taxables non destinés à l''habitation, ligne : Locaux artisanaux et leurs annexes, colonne : Surfaces créées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf4 IS 'Surfaces taxables non destinés à l''habitation, ligne : Entrepôt et hangars, colonne : Surfaces créées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf5 IS 'Surfaces taxables non destinés à l''habitation, ligne : Parcs de stationnement, colonne : Surfaces créées [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf6 IS 'Surfaces taxables non destinés à l''habitation, ligne : Exploitation et coopératives agricoles, colonne : Surfaces créées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf7 IS 'Surfaces taxables non destinés à l''habitation, ligne : Centres équestres, colonne : Surfaces créées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_sup1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_sup1 IS 'Surfaces taxables non destinés à l''habitation, ligne : Commerce inférieur à 400m², colonne : Surfaces supprimées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_sup2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_sup2 IS 'Surfaces taxables non destinés à l''habitation, ligne : Locaux industriels et leurs annexes, colonne : Surfaces supprimées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_sup3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_sup3 IS 'Surfaces taxables non destinés à l''habitation, ligne : Locaux artisanaux et leurs annexes, colonne : Surfaces supprimées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_sup4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_sup4 IS 'Surfaces taxables non destinés à l''habitation, ligne : Entrepôt et hangars, colonne : Surfaces supprimées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_sup5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_sup5 IS 'Surfaces taxables non destinés à l''habitation, ligne : Parcs de stationnement, colonne : Surfaces supprimées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_sup6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_sup6 IS 'Surfaces taxables non destinés à l''habitation, ligne : Exploitation et coopératives agricoles, colonne : Surfaces supprimées';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_sup7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_sup7 IS 'Surfaces taxables non destinés à l''habitation, ligne : Centres équestres, colonne : Surfaces supprimées';


--
-- Name: COLUMN donnees_techniques.vsd_surf_planch_smd; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.vsd_surf_planch_smd IS 'La surface de plancher de la construction projetée est-elle égale ou supérieure au seuil minimal de densité';


--
-- Name: COLUMN donnees_techniques.vsd_unit_fonc_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.vsd_unit_fonc_sup IS 'La superficie de votre unité foncière';


--
-- Name: COLUMN donnees_techniques.vsd_unit_fonc_constr_sup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.vsd_unit_fonc_constr_sup IS 'La superficie de l’unité foncière effectivement constructible';


--
-- Name: COLUMN donnees_techniques.vsd_val_terr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.vsd_val_terr IS 'La valeur du m² de terrain nu et libre';


--
-- Name: COLUMN donnees_techniques.vsd_const_sxist_non_dem_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.vsd_const_sxist_non_dem_surf IS 'Les surfaces de plancher des constructions existantes non destinées à être démolies (en m²)';


--
-- Name: COLUMN donnees_techniques.vsd_rescr_fisc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.vsd_rescr_fisc IS 'Si vous avez bénéficié avant le dépôt de votre demande d’un rescrit fiscal, indiquez sa date';


--
-- Name: COLUMN donnees_techniques.pld_val_terr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.pld_val_terr IS 'Valeur du m² de terrain nu et libre';


--
-- Name: COLUMN donnees_techniques.pld_const_exist_dem; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.pld_const_exist_dem IS 'Des constructions existantes sur votre terrain avant le 1er avril 1976 ont été démolies';


--
-- Name: COLUMN donnees_techniques.pld_const_exist_dem_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.pld_const_exist_dem_surf IS 'Si oui, indiquez ici la surface de plancher démolie';


--
-- Name: COLUMN donnees_techniques.code_cnil; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.code_cnil IS 'code CNIL';


--
-- Name: COLUMN donnees_techniques.terr_juri_titul; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_juri_titul IS 'Titulaire d’un certificat d’urbanisme pour le terrain';


--
-- Name: COLUMN donnees_techniques.terr_juri_lot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_juri_lot IS 'Le terrain est situé dans un lotissement';


--
-- Name: COLUMN donnees_techniques.terr_juri_zac; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_juri_zac IS 'Le terrain situé dans une Zone d’Aménagement Concertée (Z.A.C.)';


--
-- Name: COLUMN donnees_techniques.terr_juri_afu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_juri_afu IS 'Le terrain fait partie d’un remembrement urbain (Association Foncière Urbain)';


--
-- Name: COLUMN donnees_techniques.terr_juri_pup; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_juri_pup IS 'Le terrain est situé dans un périmètre ayant fait l’objet d’une convention de Projet Urbain Partenarial (P.U.P)';


--
-- Name: COLUMN donnees_techniques.terr_juri_oin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_juri_oin IS 'Le projet est situé dans le périmètre d’une Opération d’Intérêt National (O.I.N)';


--
-- Name: COLUMN donnees_techniques.terr_juri_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_juri_desc IS 'Si votre terrain est concerné par l’un des cas ci-dessus, veuillez préciser, si vous les connaissez, les dates de décision ou d’autorisation, les numéros et les dénominations ';


--
-- Name: COLUMN donnees_techniques.terr_div_surf_etab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_div_surf_etab IS 'surface des constructions déjà établies sur l’autre partie du terrain (en m2)';


--
-- Name: COLUMN donnees_techniques.terr_div_surf_av_div; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_div_surf_av_div IS 'et la superficie du terrain avant division (en m²)';


--
-- Name: COLUMN donnees_techniques.doc_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_date IS 'Date ouverture chantier';


--
-- Name: COLUMN donnees_techniques.doc_tot_trav; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_tot_trav IS 'Pour la totalité des travaux';


--
-- Name: COLUMN donnees_techniques.doc_tranche_trav; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_tranche_trav IS 'Pour une tranche des travaux';


--
-- Name: COLUMN donnees_techniques.doc_tranche_trav_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_tranche_trav_desc IS 'Veuillez préciser quels sont les aménagements ou constructions commencés';


--
-- Name: COLUMN donnees_techniques.doc_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_surf IS 'Surface créée';


--
-- Name: COLUMN donnees_techniques.doc_nb_log; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_nb_log IS 'Nombre de logements commencés';


--
-- Name: COLUMN donnees_techniques.doc_nb_log_indiv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_nb_log_indiv IS 'Nombre de logements individuels commencés';


--
-- Name: COLUMN donnees_techniques.doc_nb_log_coll; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_nb_log_coll IS 'Nombre de logements collectifs commencés';


--
-- Name: COLUMN donnees_techniques.doc_nb_log_lls; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_nb_log_lls IS 'Logement Locatif Social';


--
-- Name: COLUMN donnees_techniques.doc_nb_log_aa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_nb_log_aa IS 'Accession Aidée (hors prêt à taux zéro)';


--
-- Name: COLUMN donnees_techniques.doc_nb_log_ptz; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_nb_log_ptz IS 'Prêt à taux zéro';


--
-- Name: COLUMN donnees_techniques.doc_nb_log_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.doc_nb_log_autre IS 'Autres financements';


--
-- Name: COLUMN donnees_techniques.daact_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_date IS 'Date achèvement chantier';


--
-- Name: COLUMN donnees_techniques.daact_date_chgmt_dest; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_date_chgmt_dest IS 'Date changement de destination';


--
-- Name: COLUMN donnees_techniques.daact_tot_trav; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_tot_trav IS 'Pour la totalité des travaux';


--
-- Name: COLUMN donnees_techniques.daact_tranche_trav; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_tranche_trav IS 'Pour une tranche des travaux';


--
-- Name: COLUMN donnees_techniques.daact_tranche_trav_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_tranche_trav_desc IS 'Veuillez préciser quels sont les aménagements ou constructions achevés';


--
-- Name: COLUMN donnees_techniques.daact_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_surf IS 'Surface de plancher créée (en m2)';


--
-- Name: COLUMN donnees_techniques.daact_nb_log; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_nb_log IS 'Nombre de logements terminés';


--
-- Name: COLUMN donnees_techniques.daact_nb_log_indiv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_nb_log_indiv IS 'Nombre de logements individuels terminés';


--
-- Name: COLUMN donnees_techniques.daact_nb_log_coll; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_nb_log_coll IS 'Nombre de logements collectifs terminés';


--
-- Name: COLUMN donnees_techniques.daact_nb_log_lls; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_nb_log_lls IS 'Logement Locatif Social ';


--
-- Name: COLUMN donnees_techniques.daact_nb_log_aa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_nb_log_aa IS 'Accession sociale (hors prêt à taux zéro) ';


--
-- Name: COLUMN donnees_techniques.daact_nb_log_ptz; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_nb_log_ptz IS 'Prêt à taux zéro';


--
-- Name: COLUMN donnees_techniques.daact_nb_log_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.daact_nb_log_autre IS 'Autres financements';


--
-- Name: COLUMN donnees_techniques.dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dossier_autorisation IS 'Dossier d''autorisation concernés par les données techniques';


--
-- Name: COLUMN donnees_techniques.am_div_mun; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_div_mun IS 'Division foncière située dans une partie de la commune délimitée par le conseil municipal';


--
-- Name: COLUMN donnees_techniques.co_perf_energ; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_perf_energ IS 'Niveau de performance énergétique';


--
-- Name: COLUMN donnees_techniques.architecte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.architecte IS 'Vous avez eu recours à un architecte';


--
-- Name: COLUMN donnees_techniques.co_statio_avt_shob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_avt_shob IS 'Surface hors œuvre brute des aires bâties de stationnement en m² avant réalisation';


--
-- Name: COLUMN donnees_techniques.co_statio_apr_shob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_apr_shob IS 'Surface hors œuvre brute des aires bâties de stationnement en m² après réalisation';


--
-- Name: COLUMN donnees_techniques.co_statio_avt_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_avt_surf IS 'Surface de l’emprise au sol des aires non bâties de stationnement en m² avant construction';


--
-- Name: COLUMN donnees_techniques.co_statio_apr_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_statio_apr_surf IS 'Surface de l’emprise au sol des aires non bâties de stationnement en m² après réalisation';


--
-- Name: COLUMN donnees_techniques.co_ouvr_elec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_ouvr_elec IS 'Ouvrage et accessoires de lignes de distribution électrique';


--
-- Name: COLUMN donnees_techniques.co_ouvr_infra; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_ouvr_infra IS 'Ouvrage d''infrastructure';


--
-- Name: COLUMN donnees_techniques.am_lot_max_shob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_lot_max_shob IS 'indiquez la surface hors œuvre brute (SHOB) maximale envisagée';


--
-- Name: COLUMN donnees_techniques.mod_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mod_desc IS 'Descriptiondes modifications apportées à votre projet';


--
-- Name: COLUMN donnees_techniques.tr_total; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tr_total IS 'transfert total';


--
-- Name: COLUMN donnees_techniques.tr_partiel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tr_partiel IS 'transfert partiel';


--
-- Name: COLUMN donnees_techniques.tr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tr_desc IS 'description de la (ou des) partie(s) tranférée(s)';


--
-- Name: COLUMN donnees_techniques.avap_co_elt_pro; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.avap_co_elt_pro IS 'Modification ou suppression d''un élément protégé par une délibération du conseil municipal.';


--
-- Name: COLUMN donnees_techniques.avap_nouv_haut_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.avap_nouv_haut_surf IS 'Construction nouvelle de moins de  12m de hauteur et dont la surface hors œuvre brute ne dépasse 2m²';


--
-- Name: COLUMN donnees_techniques.avap_co_clot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.avap_co_clot IS 'Clôture';


--
-- Name: COLUMN donnees_techniques.avap_aut_coup_aba_arb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.avap_aut_coup_aba_arb IS 'Coupe et abattage d''arbres';


--
-- Name: COLUMN donnees_techniques.avap_ouv_infra; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.avap_ouv_infra IS 'Ouvrage d''infrastructure';


--
-- Name: COLUMN donnees_techniques.avap_aut_inst_mob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.avap_aut_inst_mob IS 'Installation de mobilier urbain ou d''oeuvre d''art';


--
-- Name: COLUMN donnees_techniques.avap_aut_plant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.avap_aut_plant IS 'Plantation effectuée sur voie ou espace public';


--
-- Name: COLUMN donnees_techniques.avap_aut_auv_elec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.avap_aut_auv_elec IS 'Ouvrage et accessoires de lignes de distribution électrique';


--
-- Name: COLUMN donnees_techniques.ope_proj_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ope_proj_desc IS 'Description de la demande / du projet';


--
-- Name: COLUMN donnees_techniques.tax_surf_tot_cstr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_tot_cstr IS 'Surface taxable totale créée de la ou des construction(s), hormis les surfaces de stationnement closes et couvertes';


--
-- Name: COLUMN donnees_techniques.tax_surf_loc_stat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_loc_stat IS 'Surface taxable des locaux clos et couverts à usage de stationnement [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf_stat1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_stat1 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Ne bénéficiant pas de prêt aidé" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf_stat2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_stat2 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Bénéficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf_stat3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_stat3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''autres prets aides (PLUS, LES, PSLA, PLS, LLS)" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_princ_surf_stat4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_stat4 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un pret a taux zero plus (PTZ+)" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_secon_surf_stat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_secon_surf_stat IS 'Tableau "Locaux à usage d''habitation secondaire et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_surf_stat1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf_stat1 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Ne bénéficiant pas de prêt aidé" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_surf_stat2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf_stat2 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Bénéficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_heber_surf_stat3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf_stat3 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Bénéficiant d''autres prêts aidés" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_tot_surf_stat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_tot_surf_stat IS 'Tableau "Nombre total de logements" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_stat1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat1 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Total des surfaces crées ou supprimées, y compris les surfaces des annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_stat2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat2 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_stat3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux artisanaux et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_stat4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat4 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Entrepôts et hangars faisant l''objet d''une exploitation commerciale et non ouverts au public" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_stat5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat5 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Parc de stationnement couverts faisant l''objet d''une exploitation commerciale" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_stat6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les exploitations et coopératives agricoles..." Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_stat7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat7 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les centres équestres : Surfaces de plancher affectées aux seules activités équestres" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_parc_statio_expl_comm_surf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_parc_statio_expl_comm_surf IS 'Tableau : Parcs de stationnement couverts faisant l’objet d’une exploitation commerciale';


--
-- Name: COLUMN donnees_techniques.tax_log_ap_trvx_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_log_ap_trvx_nb IS 'Quel est le nombre de logements apres travaux ?';


--
-- Name: COLUMN donnees_techniques.tax_am_statio_ext_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_am_statio_ext_cr IS 'Nombre de places de stationnement non couvertes ou non closes';


--
-- Name: COLUMN donnees_techniques.tax_sup_bass_pisc_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_sup_bass_pisc_cr IS 'Superficie du bassin intérieur ou extérieur de la piscine';


--
-- Name: COLUMN donnees_techniques.tax_empl_ten_carav_mobil_nb_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_empl_ten_carav_mobil_nb_cr IS 'Nombre d’emplacements de tentes, de caravanes et de résidences mobiles de loisirs';


--
-- Name: COLUMN donnees_techniques.tax_empl_hll_nb_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_empl_hll_nb_cr IS 'Nombre d’emplacements pour les habitations légères de loisirs';


--
-- Name: COLUMN donnees_techniques.tax_eol_haut_nb_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_eol_haut_nb_cr IS 'Nombre d’éoliennes dont la hauteur est supérieure à 12 m';


--
-- Name: COLUMN donnees_techniques.tax_pann_volt_sup_cr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_pann_volt_sup_cr IS 'Superficie des panneaux photo-voltaïques posés au sol';


--
-- Name: COLUMN donnees_techniques.tax_surf_loc_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_loc_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre des locaux';


--
-- Name: COLUMN donnees_techniques.tax_surf_pisc_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_pisc_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre de la piscine';


--
-- Name: COLUMN donnees_techniques.tax_am_statio_ext_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_am_statio_ext_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre des emplacements de stationnement';


--
-- Name: COLUMN donnees_techniques.tax_empl_ten_carav_mobil_nb_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_empl_ten_carav_mobil_nb_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre des emplacements de tentes, de caravanes et de résidences mobiles de loisirs';


--
-- Name: COLUMN donnees_techniques.tax_empl_hll_nb_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_empl_hll_nb_arch IS 'Veuillez préciser la profondeur du(des) terrasement(s) nécessaire(s) à la réalisation de votre projet - au titre des emplacements pour les habitations légères de loisirs';


--
-- Name: COLUMN donnees_techniques.tax_eol_haut_nb_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_eol_haut_nb_arch IS 'Nombre d’éoliennes dont la hauteur est supérieure à 12 m concernées';


--
-- Name: COLUMN donnees_techniques.ope_proj_div_co; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ope_proj_div_co IS 'Division en vue de construire';


--
-- Name: COLUMN donnees_techniques.ope_proj_div_contr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ope_proj_div_contr IS 'Division dans une commune qui a institué le contrôle des divisions dans le cadre de l’article L.115-3 du code de l’urbanisme.';


--
-- Name: COLUMN donnees_techniques.tax_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_desc IS 'Informations/Explications complémentaires pouvant vous permettre de bénéficier d’impositions plus favorables.';


--
-- Name: COLUMN donnees_techniques.erp_cstr_neuve; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_cstr_neuve IS 'Nature des travaux : Construction neuve';


--
-- Name: COLUMN donnees_techniques.erp_trvx_acc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_trvx_acc IS 'Nature des travaux : Travaux de mise en conformité totale aux règles d’accessibilité';


--
-- Name: COLUMN donnees_techniques.erp_extension; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_extension IS 'Nature des travaux : Extension';


--
-- Name: COLUMN donnees_techniques.erp_rehab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_rehab IS 'Nature des travaux : Réhabilitation';


--
-- Name: COLUMN donnees_techniques.erp_trvx_am; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_trvx_am IS 'Nature des travaux : Travaux d’aménagement (remplacement de revêtements, rénovation électrique, création d’une rampe, par exemple)';


--
-- Name: COLUMN donnees_techniques.erp_vol_nouv_exist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_vol_nouv_exist IS 'Nature des travaux : Création de volumes nouveaux dans des volumes existants (modification du cloisonnement, par exemple)';


--
-- Name: COLUMN donnees_techniques.erp_loc_eff1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_loc_eff1 IS 'Tableau "Effectif", ligne "Sous-sol" et colonne "Types de locaux (local / taux d''occupation)"';


--
-- Name: COLUMN donnees_techniques.erp_loc_eff2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_loc_eff2 IS 'Tableau "Effectif", ligne "Rez-de-chaussée" et colonne "Types de locaux (local / taux d''occupation)"';


--
-- Name: COLUMN donnees_techniques.erp_loc_eff3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_loc_eff3 IS 'Tableau "Effectif", ligne "1er étage" et colonne "Types de locaux (local / taux d''occupation)"';


--
-- Name: COLUMN donnees_techniques.erp_loc_eff4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_loc_eff4 IS 'Tableau "Effectif", ligne "2e étage" et colonne "Types de locaux (local / taux d''occupation)"';


--
-- Name: COLUMN donnees_techniques.erp_loc_eff5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_loc_eff5 IS 'Tableau "Effectif", ligne "3e étage" et colonne "Types de locaux (local / taux d''occupation)"';


--
-- Name: COLUMN donnees_techniques.erp_loc_eff_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_loc_eff_tot IS 'Tableau "Effectif", ligne "Effectif cumulé" et colonne "Types de locaux (local / taux d''occupation)"';


--
-- Name: COLUMN donnees_techniques.erp_public_eff1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_public_eff1 IS 'Tableau "Effectif", ligne "Sous-sol" et colonne "Public"';


--
-- Name: COLUMN donnees_techniques.erp_public_eff2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_public_eff2 IS 'Tableau "Effectif", ligne "Rez-de-chaussée" et colonne "Public"';


--
-- Name: COLUMN donnees_techniques.erp_public_eff3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_public_eff3 IS 'Tableau "Effectif", ligne "1er étage" et colonne "Public"';


--
-- Name: COLUMN donnees_techniques.erp_public_eff4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_public_eff4 IS 'Tableau "Effectif", ligne "2e étage" et colonne "Public"';


--
-- Name: COLUMN donnees_techniques.erp_public_eff5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_public_eff5 IS 'Tableau "Effectif", ligne "3e étage" et colonne "Public"';


--
-- Name: COLUMN donnees_techniques.erp_public_eff_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_public_eff_tot IS 'Tableau "Effectif", ligne "Effectif cumulé" et colonne "Public"';


--
-- Name: COLUMN donnees_techniques.erp_perso_eff1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_perso_eff1 IS 'Tableau "Effectif", ligne "Sous-sol" et colonne "Personnel"';


--
-- Name: COLUMN donnees_techniques.erp_perso_eff2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_perso_eff2 IS 'Tableau "Effectif", ligne "Rez-de-chaussée" et colonne "Personnel"';


--
-- Name: COLUMN donnees_techniques.erp_perso_eff3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_perso_eff3 IS 'Tableau "Effectif", ligne "1er étage" et colonne "Personnel"';


--
-- Name: COLUMN donnees_techniques.erp_perso_eff4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_perso_eff4 IS 'Tableau "Effectif", ligne "2e étage" et colonne "Personnel"';


--
-- Name: COLUMN donnees_techniques.erp_perso_eff5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_perso_eff5 IS 'Tableau "Effectif", ligne "3e étage" et colonne "Personnel"';


--
-- Name: COLUMN donnees_techniques.erp_perso_eff_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_perso_eff_tot IS 'Tableau "Effectif", ligne "Effectif cumulé" et colonne "Personnel"';


--
-- Name: COLUMN donnees_techniques.erp_tot_eff1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_tot_eff1 IS 'Tableau "Effectif", ligne "Sous-sol" et colonne "TOTAL"';


--
-- Name: COLUMN donnees_techniques.erp_tot_eff2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_tot_eff2 IS 'Tableau "Effectif", ligne "Rez-de-chaussée" et colonne "TOTAL"';


--
-- Name: COLUMN donnees_techniques.erp_tot_eff3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_tot_eff3 IS 'Tableau "Effectif", ligne "1er étage" et colonne "TOTAL"';


--
-- Name: COLUMN donnees_techniques.erp_tot_eff4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_tot_eff4 IS 'Tableau "Effectif", ligne "2e étage" et colonne "TOTAL"';


--
-- Name: COLUMN donnees_techniques.erp_tot_eff5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_tot_eff5 IS 'Tableau "Effectif", ligne "3e étage" et colonne "TOTAL"';


--
-- Name: COLUMN donnees_techniques.erp_tot_eff_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_tot_eff_tot IS 'Tableau "Effectif", ligne "Effectif cumulé" et colonne "TOTAL"';


--
-- Name: COLUMN donnees_techniques.erp_class_cat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_class_cat IS 'Classement sécurité incendie de l’ERP : Catégorie';


--
-- Name: COLUMN donnees_techniques.erp_class_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_class_type IS 'Classement sécurité incendie de l’ERP : Type';


--
-- Name: COLUMN donnees_techniques.tax_surf_abr_jard_pig_colom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_abr_jard_pig_colom IS '1.2.3 Création d’abris de jardin, de pigeonniers et colombiers - Quelle est la surface taxable créée (en m²) ?';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_abr_jard_pig_colom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_abr_jard_pig_colom IS 'Parmi les surfaces déclarées ci-dessus, quelle est la surface affectée à la catégorie des abris de jardin, pigeonniers et colombiers (en m²) ?';


--
-- Name: COLUMN donnees_techniques.dia_imm_non_bati; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_imm_non_bati IS 'Immeuble : Non bâti';


--
-- Name: COLUMN donnees_techniques.dia_imm_bati_terr_propr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_imm_bati_terr_propr IS 'Immeuble : Bâti sur terrain propre';


--
-- Name: COLUMN donnees_techniques.dia_imm_bati_terr_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_imm_bati_terr_autr IS 'Immeuble : Bâti sur terrain d’autrui, dans ce cas indiquer nom et adresse du propriétaire';


--
-- Name: COLUMN donnees_techniques.dia_imm_bati_terr_autr_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_imm_bati_terr_autr_desc IS 'Nom et adresse du propriétaire dans le cas ''Bâti sur terrain d’autrui''';


--
-- Name: COLUMN donnees_techniques.dia_bat_copro; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_bat_copro IS 'Locaux dans un bâtiment en copropriété';


--
-- Name: COLUMN donnees_techniques.dia_bat_copro_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_bat_copro_desc IS 'Description du champ ''Locaux dans un bâtiment en copropriété''';


--
-- Name: COLUMN donnees_techniques.dia_lot_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_lot_numero IS 'N° du lot';


--
-- Name: COLUMN donnees_techniques.dia_lot_bat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_lot_bat IS 'Bâtiment';


--
-- Name: COLUMN donnees_techniques.dia_lot_etage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_lot_etage IS 'Étage';


--
-- Name: COLUMN donnees_techniques.dia_lot_quote_part; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_lot_quote_part IS 'Quote-part des parties communes';


--
-- Name: COLUMN donnees_techniques.dia_us_hab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_us_hab IS 'Usage : habitation';


--
-- Name: COLUMN donnees_techniques.dia_us_pro; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_us_pro IS 'Usage : professionnel';


--
-- Name: COLUMN donnees_techniques.dia_us_mixte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_us_mixte IS 'Usage : mixte';


--
-- Name: COLUMN donnees_techniques.dia_us_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_us_comm IS 'Usage : commercial';


--
-- Name: COLUMN donnees_techniques.dia_us_agr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_us_agr IS 'Usage : agricole';


--
-- Name: COLUMN donnees_techniques.dia_us_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_us_autre IS 'Usage : autre (préciser)';


--
-- Name: COLUMN donnees_techniques.dia_us_autre_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_us_autre_prec IS 'Précision de l''usage ''autre''';


--
-- Name: COLUMN donnees_techniques.dia_occ_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_prop IS 'Occupation : par le(s) propriétaire(s)';


--
-- Name: COLUMN donnees_techniques.dia_occ_loc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_loc IS 'Occupation : par un (des) locataire(s)';


--
-- Name: COLUMN donnees_techniques.dia_occ_sans_occ; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sans_occ IS 'Occupation : sans occupant';


--
-- Name: COLUMN donnees_techniques.dia_occ_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_autre IS 'Occupation : autre (préciser)';


--
-- Name: COLUMN donnees_techniques.dia_occ_autre_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_autre_prec IS 'Précision de l''occupation ''autre''';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente IS 'Prix de vente ou évaluation (en lettres et en chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente_mob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_mob IS 'Dont éventuellement inclus : Mobilier';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente_cheptel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_cheptel IS 'Dont éventuellement inclus : Cheptel';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente_recol; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_recol IS 'Dont éventuellement inclus : Récoltes';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_autre IS 'Dont éventuellement inclus : Autres';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_commi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_commi IS 'Si commission, montant';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_commi_ttc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_commi_ttc IS 'Le montant de la commission est TTC';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_commi_ht; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_commi_ht IS 'Le montant de la commission est HT';


--
-- Name: COLUMN donnees_techniques.dia_acquereur_nom_prenom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_acquereur_nom_prenom IS 'Nom, prénom de l’acquéreur';


--
-- Name: COLUMN donnees_techniques.dia_acquereur_adr_num_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_acquereur_adr_num_voie IS 'N° voie';


--
-- Name: COLUMN donnees_techniques.dia_acquereur_adr_ext; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_acquereur_adr_ext IS 'Extension';


--
-- Name: COLUMN donnees_techniques.dia_acquereur_adr_type_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_acquereur_adr_type_voie IS 'Type de voie';


--
-- Name: COLUMN donnees_techniques.dia_acquereur_adr_nom_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_acquereur_adr_nom_voie IS 'Nom de voie';


--
-- Name: COLUMN donnees_techniques.dia_acquereur_adr_lieu_dit_bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_acquereur_adr_lieu_dit_bp IS 'Lieu-dit ou boite postale';


--
-- Name: COLUMN donnees_techniques.dia_acquereur_adr_cp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_acquereur_adr_cp IS 'Code postal';


--
-- Name: COLUMN donnees_techniques.dia_acquereur_adr_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_acquereur_adr_localite IS 'Localité';


--
-- Name: COLUMN donnees_techniques.dia_observation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_observation IS 'Observation';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon1 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation agricole" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon2 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation forestière" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon3 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Logement" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon4 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon5 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Artisanat et commerce de détail" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon6 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Restauration" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon7 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Commerce de gros" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon8 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Activités de services où s’effectue l’accueil d’une clientèle" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface existante avant travaux (A)" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon10 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Cinéma" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon11; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon11 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux et bureaux accueillant du public des administrations publiques et assimilés" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon12; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon12 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux techniques et industriels des administrations publiques et assimilés" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon13; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon13 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Établissements d’enseignement, de santé et d’action sociale" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon14; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon14 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Salles d’art et de spectacles" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon15; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon15 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Équipements sportifs" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon16; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon16 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres équipements recevant du public" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon17; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon17 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Industrie" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon18; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon18 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Entrepôt" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon19; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon19 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Bureau" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon20; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon20 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Centre de congrès et d’exposition" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon_tot IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Surfaces totales (en m2)" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon1 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation agricole" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon2 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation forestière" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon3 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Logement" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon4 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon5 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Artisanat et commerce de détail" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon6 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Restauration" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon7 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Commerce de gros" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon8 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Activités de services où s’effectue l’accueil d’une clientèle" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface créée (B)" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon10 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Cinéma" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon11; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon11 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux et bureaux accueillant du public des administrations publiques et assimilés" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon12; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon12 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux techniques et industriels des administrations publiques et assimilés" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon13; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon13 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Établissements d’enseignement, de santé et d’action sociale" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon14; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon14 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Salles d’art et de spectacles" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon15; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon15 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Équipements sportifs" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon16; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon16 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres équipements recevant du public" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon17; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon17 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Industrie" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon18; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon18 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Entrepôt" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon19; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon19 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Bureau" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon20; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon20 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Centre de congrès et d’exposition" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon_tot IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Surfaces totales (en m2)" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon1 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation agricole" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon2 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation forestière" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon3 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Logement" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon4 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon5 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Artisanat et commerce de détail" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon6 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Restauration" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon7 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Commerce de gros" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon8 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Activités de services où s’effectue l’accueil d’une clientèle" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface créée par changement de destination ou de sous-destination (C)" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon10 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Cinéma" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon11; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon11 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux et bureaux accueillant du public des administrations publiques et assimilés" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon12; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon12 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux techniques et industriels des administrations publiques et assimilés" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon13; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon13 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Établissements d’enseignement, de santé et d’action sociale" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon14; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon14 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Salles d’art et de spectacles" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon15; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon15 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Équipements sportifs" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon16; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon16 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres équipements recevant du public" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon17; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon17 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Industrie" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon18; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon18 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Entrepôt" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon19; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon19 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Bureau" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon20; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon20 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Centre de congrès et d’exposition" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon_tot IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Surfaces totales (en m2)" et colonne "Surface créée par changement de destination ou de sous-destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon1 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation agricole" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon2 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation forestière" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon3 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Logement" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon4 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon5 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Artisanat et commerce de détail" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon6 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Restauration" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon7 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Commerce de gros" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon8 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Activités de services où s’effectue l’accueil d’une clientèle" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface supprimée (D)" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon10 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Cinéma" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon11; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon11 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux et bureaux accueillant du public des administrations publiques et assimilés" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon12; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon12 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux techniques et industriels des administrations publiques et assimilés" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon13; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon13 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Établissements d’enseignement, de santé et d’action sociale" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon14; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon14 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Salles d’art et de spectacles" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon15; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon15 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Équipements sportifs" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon16; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon16 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres équipements recevant du public" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon17; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon17 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Industrie" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon18; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon18 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Entrepôt" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon19; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon19 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Bureau" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon20; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon20 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Centre de congrès et d’exposition" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon_tot IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Surfaces totales (en m2)" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon1 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation agricole" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon2 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation forestière" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon3 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Logement" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon4 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon5 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Artisanat et commerce de détail" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon6 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Restauration" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon7 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Commerce de gros" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon8 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Activités de services où s’effectue l’accueil d’une clientèle" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon10 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Cinéma" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon11; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon11 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux et bureaux accueillant du public des administrations publiques et assimilés" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon12; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon12 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux techniques et industriels des administrations publiques et assimilés" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon13; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon13 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Établissements d’enseignement, de santé et d’action sociale" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon14; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon14 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Salles d’art et de spectacles" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon15; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon15 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Équipements sportifs" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon16; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon16 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres équipements recevant du public" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon17; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon17 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Industrie" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon18; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon18 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Entrepôt" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon19; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon19 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Bureau" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon20; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon20 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Centre de congrès et d’exposition" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon_tot IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Surfaces totales (en m2)" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon1 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation agricole" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon2 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Exploitation forestière" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon3 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Logement" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon4 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon5 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Artisanat et commerce de détail" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon6 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Restauration" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon7 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Commerce de gros" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon8 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Activités de services où s’effectue l’accueil d’une clientèle" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon10 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Cinéma" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon11; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon11 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux et bureaux accueillant du public des administrations publiques et assimilés" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon12; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon12 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Locaux techniques et industriels des administrations publiques et assimilés" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon13; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon13 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Établissements d’enseignement, de santé et d’action sociale" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon14; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon14 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Salles d’art et de spectacles" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon15; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon15 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Équipements sportifs" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon16; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon16 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres équipements recevant du public" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon17; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon17 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Industrie" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon18; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon18 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Entrepôt" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon19; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon19 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Bureau" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon20; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon20 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Centre de congrès et d’exposition" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon_tot IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Surfaces totales (en m2)" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_terre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_terre IS 'Occupation du sol en superficie (m²) : Terres';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_pres; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_pres IS 'Occupation du sol en superficie (m²) : Près';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_verger; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_verger IS 'Occupation du sol en superficie (m²) : Vergers';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_vigne; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_vigne IS 'Occupation du sol en superficie (m²) : Vignes';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_bois; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_bois IS 'Occupation du sol en superficie (m²) : Bois';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_lande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_lande IS 'Occupation du sol en superficie (m²) : Landes';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_carriere; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_carriere IS 'Occupation du sol en superficie (m²) : Carrières';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_eau_cadastree; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_eau_cadastree IS 'Occupation du sol en superficie (m²) : Eaux cadastrées';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_jardin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_jardin IS 'Occupation du sol en superficie (m²) : Jardins';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_terr_batir; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_terr_batir IS 'Occupation du sol en superficie (m²) : Terrains à bâtir';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_terr_agr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_terr_agr IS 'Occupation du sol en superficie (m²) : Terrains d''agrément';


--
-- Name: COLUMN donnees_techniques.dia_occ_sol_su_sol; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_occ_sol_su_sol IS 'Occupation du sol en superficie (m²) : Sol';


--
-- Name: COLUMN donnees_techniques.dia_bati_vend_tot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_bati_vend_tot IS 'Bâtiments vendus en totalité';


--
-- Name: COLUMN donnees_techniques.dia_bati_vend_tot_txt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_bati_vend_tot_txt IS 'Bâtiments vendus en totalité (texte)';


--
-- Name: COLUMN donnees_techniques.dia_su_co_sol; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_su_co_sol IS 'Surface construite au sol (m2)';


--
-- Name: COLUMN donnees_techniques.dia_su_util_hab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_su_util_hab IS 'Surface utile ou habitable (m2)';


--
-- Name: COLUMN donnees_techniques.dia_nb_niv; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_nb_niv IS 'Nombre de : Niveaux';


--
-- Name: COLUMN donnees_techniques.dia_nb_appart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_nb_appart IS 'Nombre de : Appartements';


--
-- Name: COLUMN donnees_techniques.dia_nb_autre_loc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_nb_autre_loc IS 'Nombre de : Autres locaux';


--
-- Name: COLUMN donnees_techniques.dia_vente_lot_volume; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_vente_lot_volume IS 'Vente en lot de volumes';


--
-- Name: COLUMN donnees_techniques.dia_vente_lot_volume_txt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_vente_lot_volume_txt IS 'Vente en lot de volumes (texte)';


--
-- Name: COLUMN donnees_techniques.dia_lot_nat_su; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_lot_nat_su IS 'Nature et surface utile ou habitable';


--
-- Name: COLUMN donnees_techniques.dia_lot_bat_achv_plus_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_lot_bat_achv_plus_10 IS 'Le bâtiment est achevé depuis : Plus de 10 ans';


--
-- Name: COLUMN donnees_techniques.dia_lot_bat_achv_moins_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_lot_bat_achv_moins_10 IS 'Le bâtiment est achevé depuis : Moins de 10 ans';


--
-- Name: COLUMN donnees_techniques.dia_lot_regl_copro_publ_hypo_plus_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_lot_regl_copro_publ_hypo_plus_10 IS 'Le règlement de copropriété a été publié aux hypothèques depuis : Plus de 10 ans';


--
-- Name: COLUMN donnees_techniques.dia_lot_regl_copro_publ_hypo_moins_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_lot_regl_copro_publ_hypo_moins_10 IS 'Le règlement de copropriété a été publié aux hypothèques depuis : Moins de 10 ans';


--
-- Name: COLUMN donnees_techniques.dia_indivi_quote_part; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_indivi_quote_part IS 'En cas d’indivision, quote-part du bien vendu';


--
-- Name: COLUMN donnees_techniques.dia_design_societe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_design_societe IS 'Désignation de la société';


--
-- Name: COLUMN donnees_techniques.dia_design_droit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_design_droit IS 'Désignation des droits';


--
-- Name: COLUMN donnees_techniques.dia_droit_soc_nat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_droit_soc_nat IS 'Nature';


--
-- Name: COLUMN donnees_techniques.dia_droit_soc_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_droit_soc_nb IS 'Nombre';


--
-- Name: COLUMN donnees_techniques.dia_droit_soc_num_part; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_droit_soc_num_part IS 'Numéro des parts';


--
-- Name: COLUMN donnees_techniques.dia_droit_reel_perso_grevant_bien_oui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_droit_reel_perso_grevant_bien_oui IS 'Grevant les biens : OUI';


--
-- Name: COLUMN donnees_techniques.dia_droit_reel_perso_grevant_bien_non; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_droit_reel_perso_grevant_bien_non IS 'Grevant les biens : NON';


--
-- Name: COLUMN donnees_techniques.dia_droit_reel_perso_nat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_droit_reel_perso_nat IS 'Préciser la nature';


--
-- Name: COLUMN donnees_techniques.dia_droit_reel_perso_viag; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_droit_reel_perso_viag IS 'Indiquer si rente viagère antérieure';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_adr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_adr IS 'Si vente indissociable d’autres biens : Adresse précise du bien';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_sign_act_auth; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_sign_act_auth IS 'Modalités de paiement : comptant à la signature de l’acte authentique';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_terme; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_terme IS 'Modalités de paiement : à terme';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_terme_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_terme_prec IS 'Modalités de paiement : à terme (préciser)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_bene_acquereur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_bene_acquereur IS 'Bénéficiaire : acquéreur';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_bene_vendeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_bene_vendeur IS 'Bénéficiaire : vendeur';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_paie_nat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_paie_nat IS 'Paiement en nature';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_design_contr_alien; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_design_contr_alien IS 'Désignation de la contrepartie de l’aliénation';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_eval_contr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_eval_contr IS 'Evaluation de la contrepartie';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_rente_viag; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_rente_viag IS 'Rente viagère';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_mnt_an; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_an IS 'Montant annuel';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_mnt_compt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_compt IS 'Montant comptant';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_bene_rente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_bene_rente IS 'Bénéficiaire(s) de la rente';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_droit_usa_hab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_droit_usa_hab IS 'Droit d’usage et d’habitation';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_droit_usa_hab_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_droit_usa_hab_prec IS 'Droit d’usage et d’habitation (à préciser)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_eval_usa_usufruit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_eval_usa_usufruit IS 'Evaluation de l’usage ou de l’usufruit';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_vente_nue_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_vente_nue_prop IS 'Vente de la nue-propriété';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_vente_nue_prop_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_vente_nue_prop_prec IS 'Vente de la nue-propriété (à préciser)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_echange; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_echange IS 'Echange';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_design_bien_recus_ech; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_design_bien_recus_ech IS 'Désignation des biens reçus en échange';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_mnt_soulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_soulte IS 'Montant de la soulte le cas échéant';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prop_contre_echan; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prop_contre_echan IS 'Propriétaires contre-échangistes';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_apport_societe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_apport_societe IS 'Apport en société';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_bene; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_bene IS 'Bénéficiaire';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_esti_bien; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_esti_bien IS 'Estimation du bien apporté';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_cess_terr_loc_co; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_cess_terr_loc_co IS 'Cession de tantième de terrains contre remise de locaux à construire';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_esti_terr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_esti_terr IS 'Estimation du terrain';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_esti_loc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_esti_loc IS 'Estimation des locaux à remettre';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_esti_imm_loca; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_esti_imm_loca IS 'Location-accession – Estimation de l’immeuble objet de la location-accession';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_adju_vol; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_adju_vol IS 'Volontaire';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_adju_obl; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_adju_obl IS 'Rendue obligatoire par une disposition législative ou réglementaire';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_adju_fin_indivi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_adju_fin_indivi IS 'Mettant fin à une indivision ne résultant pas d’une donation-partage';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_adju_date_lieu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_adju_date_lieu IS 'Date et lieu de l’adjudication';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_mnt_mise_prix; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_mise_prix IS 'Montant de la mise à prix';


--
-- Name: COLUMN donnees_techniques.dia_prop_titu_prix_indique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_prop_titu_prix_indique IS 'Que le(s) propriétaire(s) nommé(s) à la rubrique 1 : Demande(nt) au titulaire du droit de préemption d’acquérir les biens désignés à la rubrique 3 aux prix et conditions indiqués';


--
-- Name: COLUMN donnees_techniques.dia_prop_recherche_acqu_prix_indique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_prop_recherche_acqu_prix_indique IS 'Que le(s) propriétaire(s) nommé(s) à la rubrique 1 : A (ont) recherché un acquéreur disposé à acquérir les biens désignés à la rubrique 3 aux prix et conditions indiqués';


--
-- Name: COLUMN donnees_techniques.dia_acquereur_prof; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_acquereur_prof IS 'Profession (facultatif)';


--
-- Name: COLUMN donnees_techniques.dia_indic_compl_ope; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_indic_compl_ope IS 'Indications complémentaires concernant l’opération envisagée par l’acquéreur (facultatif)';


--
-- Name: COLUMN donnees_techniques.dia_vente_adju; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_vente_adju IS 'Qu’il est chargé de procéder à la vente par voie d’adjudication comme indiqué à la rubrique F-2 des biens désignés à la rubrique C appartenant a(ux) propriétaire(s) nommé(s) en A';


--
-- Name: COLUMN donnees_techniques.am_terr_res_demon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_terr_res_demon IS 'Aménagement d’un terrain pour au moins 2 résidences démontables, créant une surface de plancher totale supérieure à 40M², constituant l’habitat permanent de leurs utilisateurs';


--
-- Name: COLUMN donnees_techniques.am_air_terr_res_mob; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.am_air_terr_res_mob IS 'Aménagement d’une aire d’accueil ou d’un terrain familial des gens du voyage recevant plus de deux résidences mobiles';


--
-- Name: COLUMN donnees_techniques.ctx_objet_recours; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_objet_recours IS 'Objet du recours';


--
-- Name: COLUMN donnees_techniques.ctx_reference_sagace; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_reference_sagace IS 'Références sagaces';


--
-- Name: COLUMN donnees_techniques.ctx_nature_travaux_infra_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_nature_travaux_infra_om_html IS 'Nature des travaux en infraction (NTI)';


--
-- Name: COLUMN donnees_techniques.ctx_synthese_nti; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_synthese_nti IS 'Synthèse des NTI';


--
-- Name: COLUMN donnees_techniques.ctx_article_non_resp_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_article_non_resp_om_html IS 'Article(s) non respecté(s) (ANR)';


--
-- Name: COLUMN donnees_techniques.ctx_synthese_anr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_synthese_anr IS 'Synthèse (ANR)';


--
-- Name: COLUMN donnees_techniques.ctx_reference_parquet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_reference_parquet IS 'Références Parquet';


--
-- Name: COLUMN donnees_techniques.ctx_element_taxation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_element_taxation IS 'Éléments de taxation';


--
-- Name: COLUMN donnees_techniques.ctx_infraction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_infraction IS 'Infraction';


--
-- Name: COLUMN donnees_techniques.ctx_regularisable; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_regularisable IS 'Régularisable';


--
-- Name: COLUMN donnees_techniques.ctx_reference_courrier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_reference_courrier IS 'Référence(s) courrier';


--
-- Name: COLUMN donnees_techniques.ctx_date_audience; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_date_audience IS 'Date d''audience';


--
-- Name: COLUMN donnees_techniques.ctx_date_ajournement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_date_ajournement IS 'Date d''ajournement';


--
-- Name: COLUMN donnees_techniques.exo_facul_1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_facul_1 IS 'Les locaux d''habitation et d''hébergement mentionnés au 1° de l''article L. 331-12 qui ne bénéficient pas de l''exonération prévue au 2° de l''article L. 331-7.';


--
-- Name: COLUMN donnees_techniques.exo_facul_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_facul_2 IS 'Dans la limite de 50 % de leur surface, les surfaces des locaux à usage d''habitation principale qui ne bénéficient pas de l''abattement mentionné au 2° de l''article L. 331-12 et qui sont financés à l''aide du prêt ne portant pas intérêt prévu à l''article L. 31-10-1 du code de la construction et de l''habitation.';


--
-- Name: COLUMN donnees_techniques.exo_facul_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_facul_3 IS 'Les locaux à usage industriel et artisanal mentionnés au 3° de l''article L. 331-12 du présent code.';


--
-- Name: COLUMN donnees_techniques.exo_facul_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_facul_4 IS 'Les commerces de détail d''une surface de vente inférieure à 400 mètres carrés.';


--
-- Name: COLUMN donnees_techniques.exo_facul_5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_facul_5 IS 'Les immeubles classés parmi les monuments historiques ou inscrits à l''inventaire supplémentaire des monuments historiques.';


--
-- Name: COLUMN donnees_techniques.exo_facul_6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_facul_6 IS 'Les surfaces annexes à usage de stationnement des locaux mentionnés au 1° et ne bénéficiant pas de l''exonération totale.';


--
-- Name: COLUMN donnees_techniques.exo_facul_7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_facul_7 IS 'Les surfaces des locaux annexes à usage de stationnement des immeubles autres que d''habitations individuelles.';


--
-- Name: COLUMN donnees_techniques.exo_facul_8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_facul_8 IS 'Les abris de jardin, les pigeonniers et colombiers soumis à déclaration préalable.';


--
-- Name: COLUMN donnees_techniques.exo_facul_9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_facul_9 IS 'Les maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique, pour les communes maîtres d''ouvrage.';


--
-- Name: COLUMN donnees_techniques.exo_ta_1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_ta_1 IS 'Les constructions et aménagements destinés à être affectés à un service public ou d''utilité publique, dont la liste est fixée par un décret en Conseil d''Etat.';


--
-- Name: COLUMN donnees_techniques.exo_ta_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_ta_2 IS 'Les constructions de locaux d''habitation et d''hébergement mentionnés aux articles 278 sexies et 296 ter du code général des impôts et, en Guyane et à Mayotte, les constructions de mêmes locaux, dès lors qu''ils sont financés dans les conditions du II de l''article R. 331-1 du code de la construction et de l''habitation ou du b du 2 de l''article R. 372-9 du même code.';


--
-- Name: COLUMN donnees_techniques.exo_ta_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_ta_3 IS 'Dans les exploitations et coopératives agricoles, les surfaces de plancher des serres de production, celles des locaux destinés à abriter les récoltes, à héberger les animaux, à ranger et à entretenir le matériel agricole, celles des locaux de production et de stockage des produits à usage agricole, celles des locaux de transformation et de conditionnement des produits provenant de l''exploitation et, dans les centres équestres de loisir, les surfaces des bâtiments affectées aux activités équestres.';


--
-- Name: COLUMN donnees_techniques.exo_ta_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_ta_4 IS 'Les constructions et aménagements réalisés dans les périmètres des opérations d''intérêt national prévues à l''article L. 102-12 lorsque le coût des équipements, dont la liste est fixée par décret en Conseil d''Etat, a été mis à la charge des constructeurs ou des aménageurs.';


--
-- Name: COLUMN donnees_techniques.exo_ta_5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_ta_5 IS 'Les constructions et aménagements réalisés dans les zones d''aménagement concerté mentionnées à l''article L. 311-1 lorsque le coût des équipements publics, dont la liste est fixée par un décret en Conseil d''Etat, a été mis à la charge des constructeurs ou des aménageurs. Cette liste peut être complétée par une délibération du conseil municipal ou de l''organe délibérant de l''établissement public de coopération intercommunale valable pour une durée minimale de trois ans.';


--
-- Name: COLUMN donnees_techniques.exo_ta_6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_ta_6 IS 'Les constructions et aménagements réalisés dans les périmètres délimités par une convention de projet urbain partenarial prévue par l''article L. 332-11-3, dans les limites de durée prévues par cette convention, en application de l''article L. 332-11-4.';


--
-- Name: COLUMN donnees_techniques.exo_ta_7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_ta_7 IS 'Les aménagements prescrits par un plan de prévention des risques naturels prévisibles, un plan de prévention des risques technologiques ou un plan de prévention des risques miniers sur des biens construits ou aménagés conformément aux dispositions du présent code avant l''approbation de ce plan et mis à la charge des propriétaires ou exploitants de ces biens.';


--
-- Name: COLUMN donnees_techniques.exo_ta_8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_ta_8 IS 'La reconstruction à l''identique d''un bâtiment détruit ou démoli depuis moins de dix ans dans les conditions prévues au premier alinéa de l''article L. 111-15, sous réserve des dispositions du 4° de l''article L. 331-30, ainsi que la reconstruction sur d''autres terrains de la même commune ou des communes limitrophes des bâtiments de même nature que les locaux sinistrés dont le terrain d''implantation a été reconnu comme extrêmement dangereux et classé inconstructible, pourvu que le contribuable justifie que les indemnités versées en réparation des dommages occasionnés à l''immeuble ne comprennent pas le montant de la taxe d''aménagement normalement exigible sur les reconstructions.';


--
-- Name: COLUMN donnees_techniques.exo_ta_9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_ta_9 IS 'Les constructions dont la surface est inférieure ou égale à 5 mètres carrés.';


--
-- Name: COLUMN donnees_techniques.exo_rap_1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_rap_1 IS 'Travaux et aménagements dont la surface au sol est inférieure à 3 000 m².';


--
-- Name: COLUMN donnees_techniques.exo_rap_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_rap_2 IS 'Les constructions de locaux d''habitation et d''hébergement mentionnés aux articles 278 sexies et 296 ter du code général des impôts et, en Guyane et à Mayotte, les constructions de mêmes locaux, dès lors qu''ils sont financés dans les conditions du II de l''article R. 331-1 du code de la construction et de l''habitation ou du b du 2 de l''article R. 372-9 du même code.';


--
-- Name: COLUMN donnees_techniques.exo_rap_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_rap_3 IS 'Travaux n''affectant pas le sous-sol : surélévation d''un bâtiment existant, emplacement sans fondation (emplacement de tente, caravane et résidence mobile de loisirs sur un terrain de camping, panneau photovoltaïque fixé au sol, aire de stationnement extérieure...).';


--
-- Name: COLUMN donnees_techniques.exo_rap_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_rap_4 IS 'Dans les exploitations et coopératives agricoles, les surfaces de plancher des serres de production, celles des locaux destinés à abriter les récoltes, à héberger les animaux, à ranger et à entretenir le matériel agricole, celles des locaux de production et de stockage des produits à usage agricole, celles des locaux de transformation et de conditionnement des produits provenant de l''exploitation et, dans les centres équestres de loisir, les surfaces des bâtiments affectées aux activités équestres.';


--
-- Name: COLUMN donnees_techniques.exo_rap_5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_rap_5 IS 'Les constructions et aménagements destinés à être affectés à un service public ou d''utilité publique, dont la liste est fixée par un décret en Conseil d''Etat.';


--
-- Name: COLUMN donnees_techniques.exo_rap_6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_rap_6 IS 'La reconstruction à l''identique d''un bâtiment détruit ou démoli depuis moins de dix ans dans les conditions prévues au premier alinéa de l''article L. 111-15, sous réserve des dispositions du 4° de l''article L. 331-30, ainsi que la reconstruction sur d''autres terrains de la même commune ou des communes limitrophes des bâtiments de même nature que les locaux sinistrés dont le terrain d''implantation a été reconnu comme extrêmement dangereux et classé inconstructible, pourvu que le contribuable justifie que les indemnités versées en réparation des dommages occasionnés à l''immeuble ne comprennent pas le montant de la taxe d''aménagement normalement exigible sur les reconstructions.';


--
-- Name: COLUMN donnees_techniques.exo_rap_7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_rap_7 IS 'Les aménagements prescrits par un plan de prévention des risques naturels prévisibles, un plan de prévention des risques technologiques ou un plan de prévention des risques miniers sur des biens construits ou aménagés conformément aux dispositions du présent code avant l''approbation de ce plan et mis à la charge des propriétaires ou exploitants de ces biens.';


--
-- Name: COLUMN donnees_techniques.exo_rap_8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.exo_rap_8 IS 'Les constructions dont la surface est inférieure ou égale à 5 mètres carrés.';


--
-- Name: COLUMN donnees_techniques.mtn_exo_ta_part_commu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mtn_exo_ta_part_commu IS 'Montant de l''exonération de la taxe d’aménagement sur la part communale.';


--
-- Name: COLUMN donnees_techniques.mtn_exo_ta_part_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mtn_exo_ta_part_depart IS 'Montant de l''exonération de la taxe d’aménagement sur la part départementale.';


--
-- Name: COLUMN donnees_techniques.mtn_exo_ta_part_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mtn_exo_ta_part_reg IS 'Montant de l''exonération de la taxe d’aménagement sur la part régionale.';


--
-- Name: COLUMN donnees_techniques.mtn_exo_rap; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mtn_exo_rap IS 'Montant de l''exonération de la redevance d''archéologie préventive.';


--
-- Name: COLUMN donnees_techniques.dpc_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_type IS 'Type de droit de préemption commercial';


--
-- Name: COLUMN donnees_techniques.dpc_desc_actv_ex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_desc_actv_ex IS 'Activité exercée';


--
-- Name: COLUMN donnees_techniques.dpc_desc_ca; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_desc_ca IS 'Chiffre d’affaires';


--
-- Name: COLUMN donnees_techniques.dpc_desc_aut_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_desc_aut_prec IS 'Autres précisions';


--
-- Name: COLUMN donnees_techniques.dpc_desig_comm_arti; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_desig_comm_arti IS 'Bien à usage uniquement commercial ou artisanal';


--
-- Name: COLUMN donnees_techniques.dpc_desig_loc_hab; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_desig_loc_hab IS 'Bien comportant un local accessoire d’habitation';


--
-- Name: COLUMN donnees_techniques.dpc_desig_loc_ann; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_desig_loc_ann IS 'Bien comportant d’autres locaux annexes (entrepôts, ateliers, etc.)';


--
-- Name: COLUMN donnees_techniques.dpc_desig_loc_ann_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_desig_loc_ann_prec IS 'Préciser la composition de ces autres locaux';


--
-- Name: COLUMN donnees_techniques.dpc_bail_comm_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_bail_comm_date IS 'Date de signature du bail';


--
-- Name: COLUMN donnees_techniques.dpc_bail_comm_loyer; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_bail_comm_loyer IS 'Montant du loyer';


--
-- Name: COLUMN donnees_techniques.dpc_actv_acqu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_actv_acqu IS 'Activité de l’acquéreur pressenti';


--
-- Name: COLUMN donnees_techniques.dpc_nb_sala_di; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_nb_sala_di IS 'À durée indéterminée';


--
-- Name: COLUMN donnees_techniques.dpc_nb_sala_dd; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_nb_sala_dd IS 'À durée déterminée';


--
-- Name: COLUMN donnees_techniques.dpc_nb_sala_tc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_nb_sala_tc IS 'À temps complet';


--
-- Name: COLUMN donnees_techniques.dpc_nb_sala_tp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_nb_sala_tp IS 'À temps partiel';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_vente_am; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_vente_am IS 'Vente amiable';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_adj; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_adj IS 'Adjudication';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_prix; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_prix IS 'Prix de vente ou évaluation (en lettres et chiffres)';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_adj_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_adj_date IS 'En cas d’adjudication, précisez la date';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_adj_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_adj_prec IS 'En cas d’adjudication, précisez les modalités de la vente';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_comp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_comp IS 'Comptant à la signature de l’acte authentique';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_terme; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_terme IS 'À terme';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_terme_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_terme_prec IS 'À terme, précisez';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_nat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_nat IS 'Paiement en nature';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_nat_desig_alien; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_nat_desig_alien IS 'Désignation de la contrepartie de l’aliénation';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_nat_desig_alien_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_nat_desig_alien_prec IS 'Désignation de la contrepartie de l’aliénation, précisez';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_nat_eval; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_nat_eval IS 'Évaluation de la contrepartie';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_nat_eval_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_nat_eval_prec IS 'Évaluation de la contrepartie, précisez';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_aut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_aut IS 'Autre : échange, apport en société...';


--
-- Name: COLUMN donnees_techniques.dpc_moda_cess_paie_aut_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_moda_cess_paie_aut_prec IS 'Autre : échange, apport en société... Précisez';


--
-- Name: COLUMN donnees_techniques.dpc_ss_signe_demande_acqu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_ss_signe_demande_acqu IS 'Demande au titulaire du droit de préemption d’acquérir le bien désigné à la rubrique 3';


--
-- Name: COLUMN donnees_techniques.dpc_ss_signe_recher_trouv_acqu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_ss_signe_recher_trouv_acqu IS 'A recherché et trouvé un acquéreur disposé à acheter le bien désigné à la rubrique 3 aux prix et conditions indiqués';


--
-- Name: COLUMN donnees_techniques.dpc_notif_adr_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_notif_adr_prop IS 'À l’adresse du propriétaire ou du titulaire du bail désigné à la rubrique 1';


--
-- Name: COLUMN donnees_techniques.dpc_notif_adr_manda; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_notif_adr_manda IS 'À l’adresse du mandataire désigné à la rubrique 6';


--
-- Name: COLUMN donnees_techniques.dpc_obs; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dpc_obs IS 'Observations éventuelles';


--
-- Name: COLUMN donnees_techniques.co_peri_site_patri_remar; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_peri_site_patri_remar IS 'Indiquez si votre projet se situe dans les périmètres de protection suivants : se situe dans le périmètre d''un site patrimonial remarquable';


--
-- Name: COLUMN donnees_techniques.co_abo_monu_hist; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_abo_monu_hist IS 'Indiquez si votre projet se situe dans les périmètres de protection suivants : se situe dans les abords d''un monument historique';


--
-- Name: COLUMN donnees_techniques.co_inst_ouvr_trav_act_code_envir; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_inst_ouvr_trav_act_code_envir IS 'Indiquez si votre projet : porte sur une installation, un ouvrage, des travaux ou une activité soumis à déclaration en application du code de l’environnement (IOTA)';


--
-- Name: COLUMN donnees_techniques.co_trav_auto_env; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_trav_auto_env IS 'Indiquez si votre projet : porte sur des travaux soumis à autorisation environnementale en application du L.181-1 du code de l''environnement';


--
-- Name: COLUMN donnees_techniques.co_derog_esp_prot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_derog_esp_prot IS 'Indiquez si votre projet : fait l''objet d’une dérogation au titre du L.411-2 4° du code de l''environnement (dérogation espèces protégées)';


--
-- Name: COLUMN donnees_techniques.ctx_reference_dsj; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.ctx_reference_dsj IS 'Référence DSJ';


--
-- Name: COLUMN donnees_techniques.co_piscine; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_piscine IS 'Piscine [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.co_fin_lls; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_fin_lls IS 'Mode de financement du projet : Logement Locatif Social';


--
-- Name: COLUMN donnees_techniques.co_fin_aa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_fin_aa IS 'Mode de financement du projet : Accession Sociale (hors prêt à taux zéro)';


--
-- Name: COLUMN donnees_techniques.co_fin_ptz; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_fin_ptz IS 'Mode de financement du projet : Prêt à taux zéro';


--
-- Name: COLUMN donnees_techniques.co_fin_autr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_fin_autr IS 'Mode de financement du projet : Autres financements';


--
-- Name: COLUMN donnees_techniques.dia_ss_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_ss_date IS 'Document signé le';


--
-- Name: COLUMN donnees_techniques.dia_ss_lieu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_ss_lieu IS 'Document signé à';


--
-- Name: COLUMN donnees_techniques.enga_decla_lieu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.enga_decla_lieu IS 'Engagement du déclarant : lieu de signature';


--
-- Name: COLUMN donnees_techniques.enga_decla_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.enga_decla_date IS 'Engagement du déclarant : date de signature';


--
-- Name: COLUMN donnees_techniques.co_archi_attest_honneur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_archi_attest_honneur IS 'Je déclare sur l''honneur que mon projet entre dans l''une des situations pour lesquelles le recours à l''architecte n''est pas obligatoire';


--
-- Name: COLUMN donnees_techniques.co_bat_niv_dessous_nb; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_bat_niv_dessous_nb IS 'Le nombre de niveaux du bâtiment le plus élevé : au-dessous du sol';


--
-- Name: COLUMN donnees_techniques.co_install_classe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_install_classe IS 'porte sur une installation classée soumise à enregistrement en application de l''article L. 512-7 du code de l''environnement';


--
-- Name: COLUMN donnees_techniques.co_derog_innov; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_derog_innov IS 'déroge à certaines règles de construction et met en œuvre une solution d''effet équivalent au titre de l''ordonnance n° 2018-937 du 30 octobre 2018 visant à faciliter la réalisation de projets de construction et à favoriser l''innovation';


--
-- Name: COLUMN donnees_techniques.co_avis_abf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_avis_abf IS 'relève de l''article L.632-2-1 du code du patrimoine (avis simple de l''architecte des Bâtiments de France pour les antennes-relais et les opérations liées au traitement de l''habitat indigne)';


--
-- Name: COLUMN donnees_techniques.tax_surf_tot_demo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_tot_demo IS 'Surface taxable démolie de la (ou des) construction(s)';


--
-- Name: COLUMN donnees_techniques.tax_surf_tax_demo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_surf_tax_demo IS 'Quelle est la surface taxable démolie ?';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf8 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et artisanaux ainsi que leurs annexes" Colonne "Surfaces créées (1) hormis les surfaces de stationnement closes et couvertes"';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_stat8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat8 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et artisanaux ainsi que leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf9 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique" Colonne "Surfaces créées (1) hormis les surfaces de stationnement closes et couvertes"';


--
-- Name: COLUMN donnees_techniques.tax_su_non_habit_surf_stat9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat9 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.tax_terrassement_arch; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_terrassement_arch IS 'Votre projet fait-il l''objet d''un (ou de) terrassement(s) ?';


--
-- Name: COLUMN donnees_techniques.tax_adresse_future_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_adresse_future_numero IS 'Adresse à échéance des taxes : Numéro';


--
-- Name: COLUMN donnees_techniques.tax_adresse_future_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_adresse_future_voie IS 'Adresse à échéance des taxes : Voie';


--
-- Name: COLUMN donnees_techniques.tax_adresse_future_lieudit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_adresse_future_lieudit IS 'Adresse à échéance des taxes : Lieu-dit';


--
-- Name: COLUMN donnees_techniques.tax_adresse_future_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_adresse_future_localite IS 'Adresse à échéance des taxes : Localité';


--
-- Name: COLUMN donnees_techniques.tax_adresse_future_cp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_adresse_future_cp IS 'Adresse à échéance des taxes : Code postal';


--
-- Name: COLUMN donnees_techniques.tax_adresse_future_bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_adresse_future_bp IS 'Adresse à échéance des taxes : BP';


--
-- Name: COLUMN donnees_techniques.tax_adresse_future_cedex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_adresse_future_cedex IS 'Adresse à échéance des taxes : Cedex';


--
-- Name: COLUMN donnees_techniques.tax_adresse_future_pays; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_adresse_future_pays IS 'Adresse à échéance des taxes : Pays';


--
-- Name: COLUMN donnees_techniques.tax_adresse_future_division; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_adresse_future_division IS 'Adresse à échéance des taxes : Division territoriale';


--
-- Name: COLUMN donnees_techniques.co_bat_projete; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_bat_projete IS 'Indiquez la destination, la sous-destination et la localisation approximative des bâtiments projetés dans l''unité foncière';


--
-- Name: COLUMN donnees_techniques.co_bat_existant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_bat_existant IS 'Indiquez la destination et la sous-destination des bâtiments à conserver ou à démolir';


--
-- Name: COLUMN donnees_techniques.co_bat_nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_bat_nature IS 'Vous pouvez compléter cette note par des feuilles supplémentaires, des plans, des croquis, des photos. Dans ce cas, précisez ci-dessous la nature et le nombre des pièces fournies';


--
-- Name: COLUMN donnees_techniques.terr_juri_titul_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.terr_juri_titul_date IS 'Si oui, à quelle date a t-il été délivré ?';


--
-- Name: COLUMN donnees_techniques.co_autre_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_autre_desc IS 'Autres travaux envisagés (précisez) [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.co_trx_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_trx_autre IS 'Travaux comprennent notamment : Autre (précisez)';


--
-- Name: COLUMN donnees_techniques.co_autre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_autre IS 'Autres travaux envisagés [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.erp_modif_facades; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_modif_facades IS 'Modification des accès en façades';


--
-- Name: COLUMN donnees_techniques.erp_trvx_adap; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_trvx_adap IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement';


--
-- Name: COLUMN donnees_techniques.erp_trvx_adap_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_trvx_adap_numero IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement : Ad''AP n°';


--
-- Name: COLUMN donnees_techniques.erp_trvx_adap_valid; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_trvx_adap_valid IS 'travaux mettent en œuvre des engagements d''un Ad''AP déposé antérieurement : validé le';


--
-- Name: COLUMN donnees_techniques.erp_prod_dangereux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.erp_prod_dangereux IS 'Cette demande fait l''objet d''une déclaration ou autorisation au titre du code de l''environnement (produits dangereux stockés ou utilisés)';


--
-- Name: COLUMN donnees_techniques.co_trav_supp_dessus; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_trav_supp_dessus IS 'Création de niveaux supplémentaires : au-dessus du sol';


--
-- Name: COLUMN donnees_techniques.co_trav_supp_dessous; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.co_trav_supp_dessous IS 'Création de niveaux supplémentaires : au-dessous du sol';


--
-- Name: COLUMN donnees_techniques.tax_su_habit_abr_jard_pig_colom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.tax_su_habit_abr_jard_pig_colom IS 'Création de locaux destinés à l''habitation : Parmi les surfaces déclarées ci-dessus, quelle est la surface affectée à la catégorie des abris de jardin, pigeonniers et colombiers (en m²) ?';


--
-- Name: COLUMN donnees_techniques.enga_decla_donnees_nomi_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.enga_decla_donnees_nomi_comm IS 'Pour permettre l''utilisation des informations nominatives comprises dans ce formulaire à des fins commerciales, cochez la case ci-contre [SUPPRIMÉ]';


--
-- Name: COLUMN donnees_techniques.x1l_legislation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.x1l_legislation IS 'Indiquez si votre projet : a déjà fait l''objet d''une demande d''autorisation ou d''une déclaration au titre d''une autre législation que celle du code de l''urbanisme';


--
-- Name: COLUMN donnees_techniques.x1p_precisions; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.x1p_precisions IS 'Indiquez si votre projet : a déjà fait l''objet d''une demande d''autorisation ou d''une déclaration au titre d''une autre législation que celle du code de l''urbanisme (Précisez laquelle)';


--
-- Name: COLUMN donnees_techniques.x1u_raccordement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.x1u_raccordement IS 'Indiquez si votre projet : est soumis à une obligation de raccordement à un réseau de chaleur et de froid prévue à l''article L.712-3 du code de l''énergie';


--
-- Name: COLUMN donnees_techniques.x2m_inscritmh; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.x2m_inscritmh IS 'Indiquez si votre projet : porte sur un immeuble inscrit au titre des monuments historiques';


--
-- Name: COLUMN donnees_techniques.s1na1_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1na1_numero IS 'Adresse 1 des aires de stationnement : numéro';


--
-- Name: COLUMN donnees_techniques.s1va1_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1va1_voie IS 'Adresse 1 des aires de stationnement : voie';


--
-- Name: COLUMN donnees_techniques.s1wa1_lieudit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1wa1_lieudit IS 'Adresse 1 des aires de stationnement : lieu-dit';


--
-- Name: COLUMN donnees_techniques.s1la1_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1la1_localite IS 'Adresse 1 des aires de stationnement : localité';


--
-- Name: COLUMN donnees_techniques.s1pa1_codepostal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1pa1_codepostal IS 'Adresse 1 des aires de stationnement : code postal';


--
-- Name: COLUMN donnees_techniques.s1na2_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1na2_numero IS 'Adresse 2 des aires de stationnement : numéro';


--
-- Name: COLUMN donnees_techniques.s1va2_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1va2_voie IS 'Adresse 2 des aires de stationnement : voie';


--
-- Name: COLUMN donnees_techniques.s1wa2_lieudit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1wa2_lieudit IS 'Adresse 2 des aires de stationnement : lieu-dit';


--
-- Name: COLUMN donnees_techniques.s1la2_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1la2_localite IS 'Adresse 2 des aires de stationnement : localité';


--
-- Name: COLUMN donnees_techniques.s1pa2_codepostal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.s1pa2_codepostal IS 'Adresse 2 des aires de stationnement : code postal';


--
-- Name: COLUMN donnees_techniques.e3c_certification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.e3c_certification IS 'En application de l''article L.441-4 du code de l''urbanisme, je certifie avoir fait appel aux compétences nécessaires en matière d''architecture, d''urbanisme et de paysage pour l''établissement du projet architectural, paysager et environnemental.';


--
-- Name: COLUMN donnees_techniques.e3a_competence; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.e3a_competence IS 'Si la surface du terrain à aménager est supérieure à 2 500 m², je certifie qu''un architecte au sens de l''article 9 de la loi n° 77-2 du 3 janvier 1977 sur l''architecture, ou qu''un paysagiste-concepteur au sens de l''article 174 de la loi n° 2016-1087 du 8 août 2016 pour la reconquête de la biodiversité, de la nature et des paysages, a participé à l''établissement du projet architectural, paysager et environnemental.';


--
-- Name: COLUMN donnees_techniques.a4d_description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.a4d_description IS 'Courte description du lieu concerné';


--
-- Name: COLUMN donnees_techniques.m2b_abf; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.m2b_abf IS 'Dossier transmis : Coche à l''Architecte des Bâtiments de France';


--
-- Name: COLUMN donnees_techniques.m2j_pn; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.m2j_pn IS 'Dossier transmis : Coche au Directeur du Parc National';


--
-- Name: COLUMN donnees_techniques.m2r_cdac; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.m2r_cdac IS 'Dossier transmis : Coche au Secrétaire de la Commission Départementale d''Aménagement Commercial ';


--
-- Name: COLUMN donnees_techniques.m2r_cnac; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.m2r_cnac IS 'Dossier transmis : Coche au Secrétaire de la Commission Nationale d''Aménagement Commercial';


--
-- Name: COLUMN donnees_techniques.u3a_voirieoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u3a_voirieoui IS 'Voirie : Coche Oui';


--
-- Name: COLUMN donnees_techniques.u3f_voirienon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u3f_voirienon IS 'Voirie : Coche Non';


--
-- Name: COLUMN donnees_techniques.u3c_eauoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u3c_eauoui IS 'Eau potable : Coche Oui';


--
-- Name: COLUMN donnees_techniques.u3h_eaunon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u3h_eaunon IS 'Eau potable : Coche Non';


--
-- Name: COLUMN donnees_techniques.u3g_assainissementoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u3g_assainissementoui IS 'Assainissement : Coche Oui';


--
-- Name: COLUMN donnees_techniques.u3n_assainissementnon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u3n_assainissementnon IS 'Assainissement : Coche Non';


--
-- Name: COLUMN donnees_techniques.u3m_electriciteoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u3m_electriciteoui IS 'Électricité : Coche Oui';


--
-- Name: COLUMN donnees_techniques.u3b_electricitenon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u3b_electricitenon IS 'Électricité : Coche Non';


--
-- Name: COLUMN donnees_techniques.u3t_observations; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u3t_observations IS 'Observations';


--
-- Name: COLUMN donnees_techniques.u1a_voirieoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1a_voirieoui IS 'Équipements, Voirie : Coche Oui';


--
-- Name: COLUMN donnees_techniques.u1v_voirienon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1v_voirienon IS 'Équipements, Voirie : Coche Non';


--
-- Name: COLUMN donnees_techniques.u1q_voirieconcessionnaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1q_voirieconcessionnaire IS 'Équipements, Voirie : Par quel service ou concessionnaire ?';


--
-- Name: COLUMN donnees_techniques.u1b_voirieavant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1b_voirieavant IS 'Équipements, Voirie : Avant le';


--
-- Name: COLUMN donnees_techniques.u1j_eauoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1j_eauoui IS 'Équipements, Eau potable : Coche Oui';


--
-- Name: COLUMN donnees_techniques.u1t_eaunon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1t_eaunon IS 'Équipements, Eau potable : Coche Non';


--
-- Name: COLUMN donnees_techniques.u1e_eauconcessionnaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1e_eauconcessionnaire IS 'Équipements, Eau potable : Par quel service ou concessionnaire ?';


--
-- Name: COLUMN donnees_techniques.u1k_eauavant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1k_eauavant IS 'Équipements, Eau potable : Avant le';


--
-- Name: COLUMN donnees_techniques.u1s_assainissementoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1s_assainissementoui IS 'Équipements, Assainissement : Coche Oui';


--
-- Name: COLUMN donnees_techniques.u1d_assainissementnon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1d_assainissementnon IS 'Équipements, Assainissement : Coche Non';


--
-- Name: COLUMN donnees_techniques.u1l_assainissementconcessionnaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1l_assainissementconcessionnaire IS 'Équipements, Assainissement : Par quel service ou concessionnaire ?';


--
-- Name: COLUMN donnees_techniques.u1r_assainissementavant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1r_assainissementavant IS 'Équipements, Assainissement : Avant le';


--
-- Name: COLUMN donnees_techniques.u1c_electriciteoui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1c_electriciteoui IS 'Équipement Électricité : Coche Oui';


--
-- Name: COLUMN donnees_techniques.u1u_electricitenon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1u_electricitenon IS 'Équipement Électricité : Coche Non';


--
-- Name: COLUMN donnees_techniques.u1m_electriciteconcessionnaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1m_electriciteconcessionnaire IS 'Équipement Électricité : Par quel service ou concessionnaire ?';


--
-- Name: COLUMN donnees_techniques.u1f_electriciteavant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u1f_electriciteavant IS 'Équipement Électricité : Avant le';


--
-- Name: COLUMN donnees_techniques.u2a_observations; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.u2a_observations IS 'Observations';


--
-- Name: COLUMN donnees_techniques.f1ts4_surftaxestation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1ts4_surftaxestation IS 'Surface taxable créée des parcs de stationnement couverts faisant l''objet d''une exploitation commerciale, ainsi que des locaux clos et couverts à usage de stationnement non situés dans la verticalité du bâti (en m²)';


--
-- Name: COLUMN donnees_techniques.f1ut1_surfcree; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1ut1_surfcree IS 'Surface taxable créée des locaux clos et couverts à usage de stationnement situés dans la verticalité du bâti (en m²)';


--
-- Name: COLUMN donnees_techniques.f9d_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f9d_date IS 'Déclaration des éléments nécessaires au calcul des impositions : Date de la déclaration';


--
-- Name: COLUMN donnees_techniques.f9n_nom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f9n_nom IS 'Déclaration des éléments nécessaires au calcul des impositions : Nom du déclarant';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon21; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_avt_shon22; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_avt_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface existante avant travaux (A)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon21; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_cstr_shon22; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_cstr_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface créée (B)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon21; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface créée par changement de destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_chge_shon22; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_chge_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface créée par changement de destination (C)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon21; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_demo_shon22; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_demo_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface supprimée (D)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon21; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface supprimée par changement de destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_sup_shon22; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_sup_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface supprimée par changement de destination (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon21; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.su2_tot_shon22; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.su2_tot_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';


--
-- Name: COLUMN donnees_techniques.f1gu1_f1gu2_f1gu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1gu1_f1gu2_f1gu3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Ne beneficiant pas de pret aide" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1lu1_f1lu2_f1lu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1lu1_f1lu2_f1lu3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1zu1_f1zu2_f1zu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1zu1_f1zu2_f1zu3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un pret a taux zero plus (PTZ+)" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1pu1_f1pu2_f1pu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1pu1_f1pu2_f1pu3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''autres prets aides (PLUS, LES, PSLA, PLS, LLS)" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1gt4_f1gt5_f1gt6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1gt4_f1gt5_f1gt6 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Ne beneficiant pas de pret aide" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1lt4_f1lt5_f1lt6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1lt4_f1lt5_f1lt6 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1zt4_f1zt5_f1zt6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1zt4_f1zt5_f1zt6 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un pret a taux zero plus (PTZ+)" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1pt4_f1pt5_f1pt6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1pt4_f1pt5_f1pt6 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''autres prets aides (PLUS, LES, PSLA, PLS, LLS)" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1xu1_f1xu2_f1xu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1xu1_f1xu2_f1xu3 IS 'Tableau "Locaux à usage d''habitation secondaire et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1xt4_f1xt5_f1xt6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1xt4_f1xt5_f1xt6 IS 'Tableau "Locaux à usage d''habitation secondaire et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1hu1_f1hu2_f1hu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1hu1_f1hu2_f1hu3 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Ne bénéficiant pas de prêt aidé" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1mu1_f1mu2_f1mu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1mu1_f1mu2_f1mu3 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Beneficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1qu1_f1qu2_f1qu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1qu1_f1qu2_f1qu3 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Beneficiant d''autres prets aides" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1ht4_f1ht5_f1ht6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1ht4_f1ht5_f1ht6 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Ne bénéficiant pas de prêt aidé" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1mt4_f1mt5_f1mt6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1mt4_f1mt5_f1mt6 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Beneficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f1qt4_f1qt5_f1qt6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f1qt4_f1qt5_f1qt6 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Beneficiant d''autres prets aides" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2cu1_f2cu2_f2cu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2cu1_f2cu2_f2cu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Total des surfaces creees ou supprimees, y compris les surfaces des annexes" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2bu1_f2bu2_f2bu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2bu1_f2bu2_f2bu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et artisanaux ainsi que leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2su1_f2su2_f2su3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2su1_f2su2_f2su3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2hu1_f2hu2_f2hu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2hu1_f2hu2_f2hu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Entrepots et hangars faisant l''objet d''une exploitation commerciale et non ouverts au public" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2eu1_f2eu2_f2eu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2eu1_f2eu2_f2eu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les exploitations et cooperatives agricoles : Surfaces de plancher des serres de production, des locaux destines a abriter les recoltes, heberger les animaux, ranger et entretenir le materiel agricole, des locaux de production et de stockage des produits a usage agricole, des locaux de transformation et de conditionnement des produits provenant de l''exploitation" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2qu1_f2qu2_f2qu3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2qu1_f2qu2_f2qu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les centres equestres : Surfaces de plancher affectees aux seules activites equestres" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2ct4_f2ct5_f2ct6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2ct4_f2ct5_f2ct6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Total des surfaces creees ou supprimees, y compris les surfaces des annexes" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2bt4_f2bt5_f2bt6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2bt4_f2bt5_f2bt6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et artisanaux ainsi que leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2st4_f2st5_f2st6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2st4_f2st5_f2st6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2ht4_f2ht5_f2ht6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2ht4_f2ht5_f2ht6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Entrepots et hangars faisant l''objet d''une exploitation commerciale et non ouverts au public" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2et4_f2et5_f2et6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2et4_f2et5_f2et6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les exploitations et cooperatives agricoles : Surfaces de plancher des serres de production, des locaux destines a abriter les recoltes, heberger les animaux, ranger et entretenir le materiel agricole, des locaux de production et de stockage des produits a usage agricole, des locaux de transformation et de conditionnement des produits provenant de l''exploitation" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.f2qt4_f2qt5_f2qt6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.f2qt4_f2qt5_f2qt6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les centres equestres : Surfaces de plancher affectees aux seules activites equestres" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';


--
-- Name: COLUMN donnees_techniques.dia_droit_reel_perso_grevant_bien_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_droit_reel_perso_grevant_bien_desc IS 'Grevant les biens : description';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_paie_nat_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_paie_nat_desc IS 'Paiement en nature : description';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_rente_viag_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_rente_viag_desc IS 'Rente viagère : description';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_echange_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_echange_desc IS 'Echange : description';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_apport_societe_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_apport_societe_desc IS 'Apport en société : description';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_cess_terr_loc_co_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_cess_terr_loc_co_desc IS 'Cession de tantième de terrains contre remise de locaux à construire : description';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_esti_imm_loca_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_esti_imm_loca_desc IS 'Location-accession – Estimation de l''immeuble objet de la location-accession : description';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_adju_obl_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_adju_obl_desc IS 'Rendue obligatoire par une disposition législative ou réglementaire : description';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_adju_fin_indivi_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_adju_fin_indivi_desc IS 'Mettant fin à une indivision ne résultant pas d''une donation-partage : description';


--
-- Name: COLUMN donnees_techniques.dia_cadre_titul_droit_prempt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_cadre_titul_droit_prempt IS 'Cadre réservé au titulaire du droit de préemption';


--
-- Name: COLUMN donnees_techniques.dia_mairie_prix_moyen; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mairie_prix_moyen IS 'Prix moyen au m²';


--
-- Name: COLUMN donnees_techniques.dia_propri_indivi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_propri_indivi IS 'Si le bien est en indivision, indiquer le(s) nom(s)de l''(des) autres co-indivisaires et sa (leur) quote-part (7)';


--
-- Name: COLUMN donnees_techniques.dia_situa_bien_plan_cadas_oui; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_situa_bien_plan_cadas_oui IS 'Plan(s) cadastral(aux) joint(s) : OUI';


--
-- Name: COLUMN donnees_techniques.dia_situa_bien_plan_cadas_non; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_situa_bien_plan_cadas_non IS 'Plan(s) cadastral(aux) joint(s) : NON';


--
-- Name: COLUMN donnees_techniques.dia_notif_dec_titul_adr_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_notif_dec_titul_adr_prop IS 'A l''adresse du (des) propriétaire(s) mentionné(s) à la rubrique A';


--
-- Name: COLUMN donnees_techniques.dia_notif_dec_titul_adr_prop_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_notif_dec_titul_adr_prop_desc IS 'A l''adresse du (des) propriétaire(s) mentionné(s) à la rubrique A : description';


--
-- Name: COLUMN donnees_techniques.dia_notif_dec_titul_adr_manda; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_notif_dec_titul_adr_manda IS 'A l''adresse du mandataire mentionnée à la rubrique H, adresse où le(s) propriétaire(s) a (ont) fait élection de domicile';


--
-- Name: COLUMN donnees_techniques.dia_notif_dec_titul_adr_manda_desc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_notif_dec_titul_adr_manda_desc IS 'A l''adresse du mandataire mentionnée à la rubrique H, adresse où le(s) propriétaire(s) a (ont) fait élection de domicile : description';


--
-- Name: COLUMN donnees_techniques.dia_dia_dpu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_dia_dpu IS 'Soumis au droit de préemption urbain (D.P.U) (articles L. 211-1 et suivants du Code de l''urbanisme (2))';


--
-- Name: COLUMN donnees_techniques.dia_dia_zad; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_dia_zad IS 'Compris dans une zone d''aménagement différé (Z.A.D.) (articles L.212-1- et suivants du Code de l''urbanisme (3))';


--
-- Name: COLUMN donnees_techniques.dia_dia_zone_preempt_esp_natu_sensi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_dia_zone_preempt_esp_natu_sensi IS 'Compris dans une zone de préemption délimitée au titre des espaces naturels sensibles de départements (articles L. 142-1- et suivants du Code de l''urbanisme(4))';


--
-- Name: COLUMN donnees_techniques.dia_dab_dpu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_dab_dpu IS 'Soumis au droit de préemption urbain (D.P.U.) (2)';


--
-- Name: COLUMN donnees_techniques.dia_dab_zad; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_dab_zad IS 'Compris dans une zone d''aménagement différé (Z.A.D.) (3)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_commi_mnt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_commi_mnt IS 'Montant de la commision';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_commi_mnt_ttc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_commi_mnt_ttc IS 'Le montant de la commission est TTC';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_commi_mnt_ht; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_commi_mnt_ht IS 'Le montant de la commission est HT';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_num IS 'Prix de vente ou évaluation (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente_mob_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_mob_num IS 'Dont éventuellement inclus : Mobilier (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente_cheptel_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_cheptel_num IS 'Dont éventuellement inclus : Cheptel (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente_recol_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_recol_num IS 'Dont éventuellement inclus : Récoltes (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_prix_vente_autre_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_autre_num IS 'Dont éventuellement inclus : Autres (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_su_co_sol_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_su_co_sol_num IS 'Surface construite au sol (m2) (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_su_util_hab_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_su_util_hab_num IS 'Surface utile ou habitable (m2) (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_mnt_an_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_an_num IS 'Montant annuel (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_mnt_compt_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_compt_num IS 'Montant comptant (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_mod_cess_mnt_soulte_num; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_soulte_num IS 'Montant de la soulte le cas échéant (chiffres)';


--
-- Name: COLUMN donnees_techniques.dia_comp_prix_vente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_comp_prix_vente IS 'Correspondant au prix détaillé par le vendeur dans le cadre F';


--
-- Name: COLUMN donnees_techniques.dia_comp_surface; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_comp_surface IS 'correspondant aux champs du cerfa "surface utile ou habitable du bien" et/ou "surface au sol" tel que déclarée dans le cadre C';


--
-- Name: COLUMN donnees_techniques.dia_comp_total_frais; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_comp_total_frais IS 'en l''absence de données saisies dans le cerfa sur les frais de notaire notamment, ce champ correspond au montant saisi dans le champ commission  situé dans le cadre F';


--
-- Name: COLUMN donnees_techniques.dia_comp_mtn_total; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_comp_mtn_total IS 'Montant total (en €) (correspondant à l''addition du champ prix de vente et du champ total des frais)';


--
-- Name: COLUMN donnees_techniques.dia_comp_valeur_m2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_comp_valeur_m2 IS 'Valeur au m² (en €) (modélisation du prix au m² correspondant au champ surface divisé par le champ total)';


--
-- Name: COLUMN donnees_techniques.dia_esti_prix_france_dom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_esti_prix_france_dom IS 'Estimation du prix de vente par France Domaine';


--
-- Name: COLUMN donnees_techniques.dia_prop_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_prop_collectivite IS 'Proposition d''acquisition de la collectivité';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_denomination; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_denomination IS 'Délégataire à l''instruction de la demande : Dénomination';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_raison_sociale; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_raison_sociale IS 'Délégataire à l''instruction de la demande : Raison sociale';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_siret; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_siret IS 'Délégataire à l''instruction de la demande : Siret';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_categorie_juridique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_categorie_juridique IS 'Délégataire à l''instruction de la demande : Catégorie juridique';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_representant_nom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_representant_nom IS 'Délégataire à l''instruction de la demande : Nom du représentant';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_representant_prenom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_representant_prenom IS 'Délégataire à l''instruction de la demande : Prénom du représentant';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_adresse_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_numero IS 'Délégataire à l''instruction de la demande : Adresse : Numéro';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_adresse_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_voie IS 'Délégataire à l''instruction de la demande : Adresse : Voie';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_adresse_complement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_complement IS 'Délégataire à l''instruction de la demande : Adresse : Complément';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_adresse_lieu_dit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_lieu_dit IS 'Délégataire à l''instruction de la demande : Adresse : Lieu-dit';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_adresse_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_localite IS 'Délégataire à l''instruction de la demande : Adresse : Localité';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_adresse_code_postal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_code_postal IS 'Délégataire à l''instruction de la demande : Adresse : Code postal';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_adresse_bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_bp IS 'Délégataire à l''instruction de la demande : Adresse : BP';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_adresse_cedex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_cedex IS 'Délégataire à l''instruction de la demande : Adresse : Cedex';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_adresse_pays; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_pays IS 'Délégataire à l''instruction de la demande : Adresse : Pays';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_telephone_fixe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_telephone_fixe IS 'Délégataire à l''instruction de la demande : Téléphone fixe';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_telephone_mobile; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_telephone_mobile IS 'Délégataire à l''instruction de la demande : Téléphone mobile';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_telephone_mobile_indicatif; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_telephone_mobile_indicatif IS 'Délégataire à l''instruction de la demande : Indicatif';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_courriel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_courriel IS 'Délégataire à l''instruction de la demande : Courriel';


--
-- Name: COLUMN donnees_techniques.dia_delegataire_fax; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_delegataire_fax IS 'Délégataire à l''instruction de la demande : Fax';


--
-- Name: COLUMN donnees_techniques.dia_entree_jouissance_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_entree_jouissance_type IS 'Entrée en jouissance : Type';


--
-- Name: COLUMN donnees_techniques.dia_entree_jouissance_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_entree_jouissance_date IS 'Entrée en jouissance : Date';


--
-- Name: COLUMN donnees_techniques.dia_entree_jouissance_date_effet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_entree_jouissance_date_effet IS 'Entrée en jouissance : Date d''effet';


--
-- Name: COLUMN donnees_techniques.dia_entree_jouissance_com; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_entree_jouissance_com IS 'Entrée en jouissance : Commentaire';


--
-- Name: COLUMN donnees_techniques.dia_remise_bien_date_effet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_remise_bien_date_effet IS 'Remise du bien: Date d''effet';


--
-- Name: COLUMN donnees_techniques.dia_remise_bien_com; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.dia_remise_bien_com IS 'Remise du bien: Commentaire';


--
-- Name: COLUMN donnees_techniques.c2zp1_crete; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.c2zp1_crete IS '[Si votre projet est un ouvrage de production d''électricité à partir de l''énergie solaire installé sur le sol] Indiquez sa puissance crête';


--
-- Name: COLUMN donnees_techniques.c2zr1_destination; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.c2zr1_destination IS '[Si votre projet est un ouvrage de production d''électricité à partir de l''énergie solaire installé sur le sol] Indiquez la destination principale de l''énergie solaire';


--
-- Name: COLUMN donnees_techniques.mh_design_appel_denom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_design_appel_denom IS 'Appellation / dénomination';


--
-- Name: COLUMN donnees_techniques.mh_design_type_protect; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_design_type_protect IS 'Type de protection : classé, inscrit, classé et inscrit';


--
-- Name: COLUMN donnees_techniques.mh_design_elem_prot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_design_elem_prot IS 'Élément(s) protégé(s)';


--
-- Name: COLUMN donnees_techniques.mh_design_ref_merimee_palissy; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_design_ref_merimee_palissy IS 'Référence Mérimée';


--
-- Name: COLUMN donnees_techniques.mh_design_nature_prop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_design_nature_prop IS 'Nature de la propriété : privée, publique, privée et publique';


--
-- Name: COLUMN donnees_techniques.mh_loc_denom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_loc_denom IS 'Dénomination de l’immeuble';


--
-- Name: COLUMN donnees_techniques.mh_pres_intitule; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_pres_intitule IS 'Intitulé de l’opération';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_1 IS 'Catégorie des travaux prévus : Fondations, sous-sol';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_2 IS 'Catégorie des travaux prévus : Structure, maçonnerie, gros-œuvre';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_3 IS 'Catégorie des travaux prévus : Parements, enduits, restauration de façades';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_4 IS 'Catégorie des travaux prévus : Charpente, couverture';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_5 IS 'Catégorie des travaux prévus : Menuiseries, métallerie, vitraux';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_6 IS 'Catégorie des travaux prévus : Cloisons, revêtements intérieurs, décors';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_7 IS 'Catégorie des travaux prévus : Équipements techniques, sécurité, sureté, accessibilité';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_8 IS 'Catégorie des travaux prévus : Voirie et réseaux divers';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_9 IS 'Catégorie des travaux prévus : Affouillements ou exhaussements';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_10 IS 'Catégorie des travaux prévus : Sculptures';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_11; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_11 IS 'Catégorie des travaux prévus : Parcs, jardins et bois';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_12; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_12 IS 'Catégorie des travaux prévus : Autres, préciser';


--
-- Name: COLUMN donnees_techniques.mh_trav_cat_12_prec; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN donnees_techniques.mh_trav_cat_12_prec IS 'Catégorie des travaux prévus : Autres, préciser';


--
-- Name: donnees_techniques_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE donnees_techniques_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: donnees_techniques_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE donnees_techniques_seq OWNED BY donnees_techniques.donnees_techniques;


--
-- Name: dossier; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier (
    dossier character varying(255) NOT NULL,
    annee character(2) DEFAULT ''::bpchar NOT NULL,
    etat character varying(150),
    instructeur integer,
    date_demande date,
    date_depot date NOT NULL,
    date_complet date,
    date_rejet date,
    date_notification_delai date,
    delai integer DEFAULT 0 NOT NULL,
    date_limite date,
    accord_tacite character(3) DEFAULT ''::bpchar NOT NULL,
    date_decision date,
    date_validite date,
    date_chantier date,
    date_achevement date,
    date_conformite date,
    description text DEFAULT ''::text NOT NULL,
    erp boolean,
    avis_decision integer,
    enjeu_erp boolean,
    enjeu_urba boolean,
    division integer,
    autorite_competente integer,
    a_qualifier boolean,
    terrain_references_cadastrales text,
    terrain_adresse_voie_numero character varying(20),
    terrain_adresse_voie character varying(300),
    terrain_adresse_lieu_dit character varying(30),
    terrain_adresse_localite character varying(45),
    terrain_adresse_code_postal character varying(5),
    terrain_adresse_bp character varying(15),
    terrain_adresse_cedex character varying(15),
    terrain_superficie double precision,
    dossier_autorisation character varying(255) NOT NULL,
    dossier_instruction_type integer NOT NULL,
    date_dernier_depot date NOT NULL,
    version integer,
    incompletude boolean DEFAULT false NOT NULL,
    evenement_suivant_tacite integer,
    evenement_suivant_tacite_incompletude integer,
    etat_pendant_incompletude character varying(150),
    date_limite_incompletude date,
    delai_incompletude integer,
    dossier_libelle character varying(255),
    numero_versement_archive character varying(100),
    duree_validite integer DEFAULT 0 NOT NULL,
    quartier integer,
    incomplet_notifie boolean DEFAULT false,
    om_collectivite integer NOT NULL,
    tax_secteur integer,
    tax_mtn_part_commu numeric,
    tax_mtn_part_depart numeric,
    tax_mtn_part_reg numeric,
    tax_mtn_total numeric,
    log_instructions text,
    interface_referentiel_erp boolean,
    autorisation_contestee character varying(255),
    date_cloture_instruction date,
    date_premiere_visite date,
    date_derniere_visite date,
    date_contradictoire date,
    date_retour_contradictoire date,
    date_ait date,
    date_transmission_parquet date,
    instructeur_2 integer,
    tax_mtn_rap numeric,
    tax_mtn_part_commu_sans_exo numeric,
    tax_mtn_part_depart_sans_exo numeric,
    tax_mtn_part_reg_sans_exo numeric,
    tax_mtn_total_sans_exo numeric,
    tax_mtn_rap_sans_exo numeric,
    date_modification date,
    hash_sitadel character varying(32),
    depot_electronique boolean DEFAULT false NOT NULL,
    parcelle_temporaire boolean DEFAULT false NOT NULL,
    date_affichage date,
    version_clos integer,
    initial_dt text DEFAULT '{}'::text,
    commune integer,
    adresse_normalisee text,
    adresse_normalisee_json text DEFAULT '{}'::text,
    date_depot_mairie date,
    numerotation_type character varying(3),
    numerotation_dep character varying(3),
    numerotation_com character varying(3),
    numerotation_division character varying(2),
    numerotation_num integer,
    numerotation_suffixe character varying(20),
    numerotation_num_suffixe integer,
    numerotation_entite character varying(10),
    numerotation_num_entite integer,
    pec_metier integer,
    etat_transmission_platau text DEFAULT 'non_transmissible'::text NOT NULL,
    dossier_parent character varying(255),
    terrain_superficie_calculee double precision,
    geoloc_latitude character varying(50),
    geoloc_longitude character varying(50),
    geoloc_rayon double precision,
    geom public.geometry(Point,2154),
    geom1 public.geometry(MultiPolygon,2154)
);


--
-- Name: TABLE dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier IS 'Dossier d''instruction';


--
-- Name: COLUMN dossier.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.dossier IS 'Numéro du dossier d''instruction';


--
-- Name: COLUMN dossier.annee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.annee IS 'Année de la création du dossier d''instruction';


--
-- Name: COLUMN dossier.etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.etat IS 'État du dossier d''instruction';


--
-- Name: COLUMN dossier.instructeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.instructeur IS 'Premier instructeur en charge du dossier d''instruction';


--
-- Name: COLUMN dossier.date_demande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_demande IS 'Date de la demande';


--
-- Name: COLUMN dossier.date_depot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_depot IS 'Date du dépôt du dossier d''instruction';


--
-- Name: COLUMN dossier.date_complet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_complet IS 'Date de complétude du dossier d''instruction';


--
-- Name: COLUMN dossier.date_rejet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_rejet IS 'Date de rejet du dossier d''instruction';


--
-- Name: COLUMN dossier.date_notification_delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_notification_delai IS 'Date de notification du délai au pétitionnaire';


--
-- Name: COLUMN dossier.delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.delai IS 'Délai servant au calcul de la date de validité';


--
-- Name: COLUMN dossier.date_limite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_limite IS 'Date de limite du dossier d''instruction';


--
-- Name: COLUMN dossier.accord_tacite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.accord_tacite IS 'Soumis à un accord tacite';


--
-- Name: COLUMN dossier.date_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_decision IS 'Date de décision du dossier d''instruction';


--
-- Name: COLUMN dossier.date_validite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_validite IS 'Date de validité du dossier d''instruction';


--
-- Name: COLUMN dossier.date_chantier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_chantier IS 'Date de début du chantier du dossier d''instruction';


--
-- Name: COLUMN dossier.date_achevement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_achevement IS 'Date d''achèvement du chantier du dossier d''instruction';


--
-- Name: COLUMN dossier.date_conformite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_conformite IS 'Date de conformité du dossier d''instruction';


--
-- Name: COLUMN dossier.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.description IS 'Description des contraintes';


--
-- Name: COLUMN dossier.erp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.erp IS 'Dossier d''instruction ERP';


--
-- Name: COLUMN dossier.avis_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.avis_decision IS 'Avis du dossier d''instruction';


--
-- Name: COLUMN dossier.enjeu_erp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.enjeu_erp IS 'Le dossier d''instruction a un enjeu ERP';


--
-- Name: COLUMN dossier.enjeu_urba; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.enjeu_urba IS 'Le dossier d''instruction a un enjeu urbain';


--
-- Name: COLUMN dossier.division; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.division IS 'Division à laquelle est rattaché le dossier d''instruction';


--
-- Name: COLUMN dossier.autorite_competente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.autorite_competente IS 'Autorité compétente du dossier d''instruction';


--
-- Name: COLUMN dossier.a_qualifier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.a_qualifier IS 'Le dossier d''instruction est à qualifier';


--
-- Name: COLUMN dossier.terrain_references_cadastrales; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_references_cadastrales IS 'Références cadastrales du dossier d''instruction';


--
-- Name: COLUMN dossier.terrain_adresse_voie_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_adresse_voie_numero IS 'Numéro de la voie de l''adresse du terrain';


--
-- Name: COLUMN dossier.terrain_adresse_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_adresse_voie IS 'Nom de la voie de l''adresse du terrain';


--
-- Name: COLUMN dossier.terrain_adresse_lieu_dit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_adresse_lieu_dit IS 'Lieu dit de l''adresse du terrain';


--
-- Name: COLUMN dossier.terrain_adresse_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_adresse_localite IS 'Ville de l''adresse du terrain';


--
-- Name: COLUMN dossier.terrain_adresse_code_postal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_adresse_code_postal IS 'Code postal de l''adresse du terrain';


--
-- Name: COLUMN dossier.terrain_adresse_bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_adresse_bp IS 'Boîte postale de l''adresse du terrain';


--
-- Name: COLUMN dossier.terrain_adresse_cedex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_adresse_cedex IS 'Cedex de l''adresse du terrain';


--
-- Name: COLUMN dossier.terrain_superficie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_superficie IS 'Superficie du terrain concerné par du dossier d''instruction';


--
-- Name: COLUMN dossier.dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.dossier_autorisation IS 'Dossier d''autorisation du dossier d''instruction';


--
-- Name: COLUMN dossier.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.dossier_instruction_type IS 'Type du dossier d''instruction';


--
-- Name: COLUMN dossier.date_dernier_depot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_dernier_depot IS 'Date du dernier dépôt d''événement d''instruction';


--
-- Name: COLUMN dossier.version; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.version IS 'Numéro de version du dossier d''instruction, permet de connaitre le parcours du dossier d''autorisation';


--
-- Name: COLUMN dossier.incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.incompletude IS 'Le dossier d''instruction est en incomplétude';


--
-- Name: COLUMN dossier.evenement_suivant_tacite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.evenement_suivant_tacite IS 'Événement appliqué en cas de tacicité';


--
-- Name: COLUMN dossier.evenement_suivant_tacite_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.evenement_suivant_tacite_incompletude IS 'Événement appliqué en cas de tacicité sur un dossier en incomplétude';


--
-- Name: COLUMN dossier.etat_pendant_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.etat_pendant_incompletude IS 'État du dossier d''instruction pendant l''incomplétude';


--
-- Name: COLUMN dossier.date_limite_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_limite_incompletude IS 'Date limite de l''incomplétude';


--
-- Name: COLUMN dossier.delai_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.delai_incompletude IS 'Délai servant au calcul de la date lmite d''incomplétude';


--
-- Name: COLUMN dossier.dossier_libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.dossier_libelle IS 'Numéro du dossier d''instruction utilisé lors de l''affichage';


--
-- Name: COLUMN dossier.numero_versement_archive; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.numero_versement_archive IS 'Numéro de versement aux archives du dossier d''instruction';


--
-- Name: COLUMN dossier.duree_validite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.duree_validite IS 'Durée de validité du dossier d''instruction (récupéré du paramétrage du type détaillé du dossier d''autorisation lors de sa création)';


--
-- Name: COLUMN dossier.quartier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.quartier IS 'Quartier du dossier d''instruction';


--
-- Name: COLUMN dossier.incomplet_notifie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.incomplet_notifie IS 'Définit si le dossier est en état incomplet notifié';


--
-- Name: COLUMN dossier.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.om_collectivite IS 'lien vers la collectivité concernée';


--
-- Name: COLUMN dossier.tax_secteur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_secteur IS 'Secteur du dossier d''instruction pour le calcul de la taxe d''aménagement';


--
-- Name: COLUMN dossier.tax_mtn_part_commu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_part_commu IS 'Montant liquidé de la part communale de la taxe d''aménagement avec l''exonération prise en compte';


--
-- Name: COLUMN dossier.tax_mtn_part_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_part_depart IS 'Montant liquidé de la part départementale de la taxe d''aménagement avec l''exonération prise en compte';


--
-- Name: COLUMN dossier.tax_mtn_part_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_part_reg IS 'Montant liquidé de la part régionale de la taxe d''aménagement avec l''exonération prise en compte';


--
-- Name: COLUMN dossier.tax_mtn_total; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_total IS 'Total des montants de la taxe d''aménagement avec l''exonération prise en compte';


--
-- Name: COLUMN dossier.log_instructions; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.log_instructions IS 'Log des événements d''instruction du dossier d''instruction en cours';


--
-- Name: COLUMN dossier.autorisation_contestee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.autorisation_contestee IS 'Le numéro de l''autorisation contestée (DI)';


--
-- Name: COLUMN dossier.date_cloture_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_cloture_instruction IS 'Date de fin d''instruction du dossier recours';


--
-- Name: COLUMN dossier.date_premiere_visite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_premiere_visite IS 'Date du premier PV, mise à jour par l''instruction';


--
-- Name: COLUMN dossier.date_derniere_visite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_derniere_visite IS 'Date du dernier PV, mise à jour par l''instruction';


--
-- Name: COLUMN dossier.date_contradictoire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_contradictoire IS 'Date alimentée par l''instruction';


--
-- Name: COLUMN dossier.date_retour_contradictoire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_retour_contradictoire IS 'Date alimentée par l''instruction';


--
-- Name: COLUMN dossier.date_ait; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_ait IS 'Date alimentée par l''instruction';


--
-- Name: COLUMN dossier.date_transmission_parquet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_transmission_parquet IS 'Date alimentée par l''instruction';


--
-- Name: COLUMN dossier.instructeur_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.instructeur_2 IS 'Second instructeur en charge du dossier d''instruction';


--
-- Name: COLUMN dossier.tax_mtn_rap; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_rap IS 'Montant liquidé de la redevance archéologique préventive (RAP) avec l''exonération prise en compte';


--
-- Name: COLUMN dossier.tax_mtn_part_commu_sans_exo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_part_commu_sans_exo IS 'Montant liquidé de la part communale de la taxe d''aménagement sans l''exonération prise en compte';


--
-- Name: COLUMN dossier.tax_mtn_part_depart_sans_exo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_part_depart_sans_exo IS 'Montant liquidé de la part départementale de la taxe d''aménagement sans l''exonération prise en compte';


--
-- Name: COLUMN dossier.tax_mtn_part_reg_sans_exo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_part_reg_sans_exo IS 'Montant liquidé de la part régionale de la taxe d''aménagement sans l''exonération prise en compte';


--
-- Name: COLUMN dossier.tax_mtn_total_sans_exo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_total_sans_exo IS 'Total des montants de la taxe d''aménagement sans l''exonération prise en compte';


--
-- Name: COLUMN dossier.tax_mtn_rap_sans_exo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.tax_mtn_rap_sans_exo IS 'Montant liquidé de la redevance archéologique préventive (RAP) sans l''exonération prise en compte';


--
-- Name: COLUMN dossier.date_modification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_modification IS 'Date de dernière modification du dossier (MàJ par les données techniques ou les instructions)';


--
-- Name: COLUMN dossier.hash_sitadel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.hash_sitadel IS 'Hash MD5 de la ligne générée pour un export SITADEL';


--
-- Name: COLUMN dossier.depot_electronique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.depot_electronique IS 'Identifie le dépôt électronique du dossier d''instruction';


--
-- Name: COLUMN dossier.parcelle_temporaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.parcelle_temporaire IS 'Existence d''au moins une parcelle temporaire sur le dossier d''instruction';


--
-- Name: COLUMN dossier.date_affichage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_affichage IS 'Date d''affichage de l''avis de dépôt';


--
-- Name: COLUMN dossier.version_clos; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.version_clos IS 'Numéro de version de clôture du dossier d''instruction, permet de connaître le parcours des décisions du dossier d''autorisation';


--
-- Name: COLUMN dossier.initial_dt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.initial_dt IS 'Contient les données techniques initiales du dossier d''instruction au format JSON';


--
-- Name: COLUMN dossier.commune; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.commune IS 'Commune associée au dossier';


--
-- Name: COLUMN dossier.adresse_normalisee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.adresse_normalisee IS 'Adresse normalisée du terrain';


--
-- Name: COLUMN dossier.adresse_normalisee_json; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.adresse_normalisee_json IS 'JSON transmis par l''api adresse lors de la récupération de l''adresse normalisée';


--
-- Name: COLUMN dossier.date_depot_mairie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.date_depot_mairie IS 'Date de dépôt en mairie';


--
-- Name: COLUMN dossier.pec_metier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.pec_metier IS 'Statut de la prise en compte métier du dossier d''instruction';


--
-- Name: COLUMN dossier.etat_transmission_platau; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.etat_transmission_platau IS 'Permet de déterminer si les données d''un dossier ont été transmises à Plat''AU lors de l''ajout. Valeurs possibles : non_transmissible, transmis_mais_non_transmissible et transmissible';


--
-- Name: COLUMN dossier.dossier_parent; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.dossier_parent IS 'Identifiant du dossier parent d''un sous-dossier.';


--
-- Name: COLUMN dossier.terrain_superficie_calculee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.terrain_superficie_calculee IS 'Superficie calculée du terrain concerné par le dossier d''instruction';


--
-- Name: COLUMN dossier.geoloc_latitude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.geoloc_latitude IS 'Latitude du point permettant la géolocalisation en disque';


--
-- Name: COLUMN dossier.geoloc_longitude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.geoloc_longitude IS 'Longitude du point permettant la géolocalisation en disque';


--
-- Name: COLUMN dossier.geoloc_rayon; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier.geoloc_rayon IS 'Rayon de la géolocalisation en disque';


--
-- Name: dossier_autorisation; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_autorisation (
    dossier_autorisation character varying(255) NOT NULL,
    dossier_autorisation_type_detaille integer,
    exercice integer,
    insee character varying(5),
    terrain_references_cadastrales text,
    terrain_adresse_voie_numero character varying(20),
    terrain_adresse_voie character varying(300),
    terrain_adresse_lieu_dit character varying(30),
    terrain_adresse_localite character varying(45),
    terrain_adresse_code_postal character varying(5),
    terrain_adresse_bp character varying(15),
    terrain_adresse_cedex character varying(15),
    terrain_superficie double precision,
    arrondissement integer,
    depot_initial date,
    erp_numero_batiment integer,
    erp_ouvert boolean,
    erp_date_ouverture date,
    erp_arrete_decision boolean,
    erp_date_arrete_decision date,
    numero_version integer DEFAULT 0,
    etat_dossier_autorisation integer,
    date_depot date,
    date_decision date,
    date_validite date,
    date_chantier date,
    date_achevement date,
    avis_decision integer,
    etat_dernier_dossier_instruction_accepte integer,
    dossier_autorisation_libelle character varying(255),
    om_collectivite integer NOT NULL,
    cle_acces_citoyen character varying(20),
    numero_version_clos integer,
    commune integer,
    adresse_normalisee text,
    adresse_normalisee_json text DEFAULT '{}'::text,
    numerotation_type character varying(3),
    numerotation_dep character varying(3),
    numerotation_com character varying(3),
    numerotation_division character varying(2),
    numerotation_num integer
);


--
-- Name: TABLE dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_autorisation IS 'Dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.dossier_autorisation IS 'Numéro du dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.dossier_autorisation_type_detaille; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.dossier_autorisation_type_detaille IS 'Type détaillé du dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.exercice; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.exercice IS 'Exercice fiscal du dossier d''autorisation (année sur deux chiffres)';


--
-- Name: COLUMN dossier_autorisation.insee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.insee IS 'Code INSEE du dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.terrain_references_cadastrales; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.terrain_references_cadastrales IS 'Références cadastrales du dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.terrain_adresse_voie_numero; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.terrain_adresse_voie_numero IS 'Numéro de la voie de l''adresse du terrain';


--
-- Name: COLUMN dossier_autorisation.terrain_adresse_voie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.terrain_adresse_voie IS 'Nom de la voie de l''adresse du terrain';


--
-- Name: COLUMN dossier_autorisation.terrain_adresse_lieu_dit; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.terrain_adresse_lieu_dit IS 'Lieu dit de l''adresse du terrain';


--
-- Name: COLUMN dossier_autorisation.terrain_adresse_localite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.terrain_adresse_localite IS 'Ville de l''adresse du terrain';


--
-- Name: COLUMN dossier_autorisation.terrain_adresse_code_postal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.terrain_adresse_code_postal IS 'Code postal de l''adresse du terrain';


--
-- Name: COLUMN dossier_autorisation.terrain_adresse_bp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.terrain_adresse_bp IS 'Boîte postale de l''adresse du terrain';


--
-- Name: COLUMN dossier_autorisation.terrain_adresse_cedex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.terrain_adresse_cedex IS 'Cedex de l''adresse du terrain';


--
-- Name: COLUMN dossier_autorisation.terrain_superficie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.terrain_superficie IS 'Superficie du terrain concerné par du dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.arrondissement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.arrondissement IS 'Arrondissement du dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.depot_initial; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.depot_initial IS 'Dépôt initial du dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.erp_numero_batiment; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.erp_numero_batiment IS 'Numéro du bâtiment ERP';


--
-- Name: COLUMN dossier_autorisation.erp_ouvert; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.erp_ouvert IS 'Bâtiment ERP ouvert';


--
-- Name: COLUMN dossier_autorisation.erp_date_ouverture; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.erp_date_ouverture IS 'Date d''ouverture du bâtiment ERP';


--
-- Name: COLUMN dossier_autorisation.erp_arrete_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.erp_arrete_decision IS 'Un arrêté de décision a été rendu pour le bâtiment ERP';


--
-- Name: COLUMN dossier_autorisation.erp_date_arrete_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.erp_date_arrete_decision IS 'Date d''arrêté de décision du bâtiment ERP';


--
-- Name: COLUMN dossier_autorisation.numero_version; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.numero_version IS 'Numéro de version du dossier d''instruction en cours';


--
-- Name: COLUMN dossier_autorisation.etat_dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.etat_dossier_autorisation IS 'État du dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.date_depot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.date_depot IS 'Date de dépôt de la demande';


--
-- Name: COLUMN dossier_autorisation.date_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.date_decision IS 'Date de décision du dernier dossier d''instruction accepté';


--
-- Name: COLUMN dossier_autorisation.date_validite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.date_validite IS 'Date de validité du dernier dossier d''instruction accepté';


--
-- Name: COLUMN dossier_autorisation.date_chantier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.date_chantier IS 'Date de chantier du dernier dossier d''instruction accepté';


--
-- Name: COLUMN dossier_autorisation.date_achevement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.date_achevement IS 'Date d''achèvement du chantier du dernier dossier d''instruction accepté';


--
-- Name: COLUMN dossier_autorisation.avis_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.avis_decision IS 'Avis du dossier d''autorisation récupéré depuis le dernier dossier d''instruction accepté';


--
-- Name: COLUMN dossier_autorisation.etat_dernier_dossier_instruction_accepte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.etat_dernier_dossier_instruction_accepte IS 'État du dernier dossier d''instruction accepté';


--
-- Name: COLUMN dossier_autorisation.dossier_autorisation_libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.dossier_autorisation_libelle IS 'Numéro du dossier d''autorisation utilisé lors de l''affichage';


--
-- Name: COLUMN dossier_autorisation.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.om_collectivite IS 'lien vers la collectivité concernée';


--
-- Name: COLUMN dossier_autorisation.cle_acces_citoyen; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.cle_acces_citoyen IS 'Clé d''accès au portail citoyen générée par l''application, permet au pétitionnaire de suivre l''avancement de son dossier';


--
-- Name: COLUMN dossier_autorisation.numero_version_clos; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.numero_version_clos IS 'Numéro de version de clôture du dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation.commune; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.commune IS 'Commune associée au dossier';


--
-- Name: COLUMN dossier_autorisation.adresse_normalisee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.adresse_normalisee IS 'Adresse normalisée du terrain';


--
-- Name: COLUMN dossier_autorisation.adresse_normalisee_json; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation.adresse_normalisee_json IS 'JSON transmis par l''api adresse lors de la récupération de l''adresse normalisée';


--
-- Name: dossier_autorisation_parcelle; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_autorisation_parcelle (
    dossier_autorisation_parcelle integer NOT NULL,
    dossier_autorisation character varying(255) NOT NULL,
    parcelle character varying(20) DEFAULT NULL::character varying,
    libelle character varying(20)
);


--
-- Name: TABLE dossier_autorisation_parcelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_autorisation_parcelle IS 'Parcelles liées aux dossiers d''autorisation (Permet de découper les références cadastrales d''un dossier d''autorisation)';


--
-- Name: COLUMN dossier_autorisation_parcelle.dossier_autorisation_parcelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_parcelle.dossier_autorisation_parcelle IS 'Identifiant unique';


--
-- Name: COLUMN dossier_autorisation_parcelle.dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_parcelle.dossier_autorisation IS 'Dossier d''autorisation de la parcelle';


--
-- Name: COLUMN dossier_autorisation_parcelle.parcelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_parcelle.parcelle IS 'Parcelle liée';


--
-- Name: COLUMN dossier_autorisation_parcelle.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_parcelle.libelle IS 'Libellé de la parcelle';


--
-- Name: dossier_autorisation_parcelle_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_autorisation_parcelle_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_autorisation_parcelle_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_autorisation_parcelle_seq OWNED BY dossier_autorisation_parcelle.dossier_autorisation_parcelle;


--
-- Name: dossier_autorisation_type; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_autorisation_type (
    dossier_autorisation_type integer NOT NULL,
    code character varying(20) NOT NULL,
    libelle character varying(100),
    description text,
    confidentiel boolean DEFAULT false,
    groupe integer,
    affichage_form character varying(250) NOT NULL,
    cacher_da boolean DEFAULT false
);


--
-- Name: TABLE dossier_autorisation_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_autorisation_type IS 'Type des dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type.dossier_autorisation_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type.dossier_autorisation_type IS 'Identifiant unique';


--
-- Name: COLUMN dossier_autorisation_type.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type.code IS 'Code du type de dossier d''autorisation (PC, PD, PA, ...)';


--
-- Name: COLUMN dossier_autorisation_type.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type.libelle IS 'Libellé du type de dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type.description IS 'Description du type de dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type.confidentiel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type.confidentiel IS 'Permet de gérer la confidentialité sur ce type de dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type.groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type.groupe IS 'Permet de définir le service qui doit traiter ce type de dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type.affichage_form; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type.affichage_form IS 'Type d''affichage du formulaire du dossier (DI et/ou DA)';


--
-- Name: COLUMN dossier_autorisation_type.cacher_da; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type.cacher_da IS 'Si positionné à oui, alors les DA de ce type ne seront pas visibles';


--
-- Name: dossier_autorisation_type_detaille; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_autorisation_type_detaille (
    dossier_autorisation_type_detaille integer NOT NULL,
    code character varying(20),
    libelle character varying(100),
    description text,
    dossier_autorisation_type integer NOT NULL,
    cerfa integer,
    cerfa_lot integer,
    duree_validite_parametrage integer DEFAULT 0 NOT NULL,
    dossier_platau boolean DEFAULT false,
    couleur character varying(6),
    secret_instruction boolean DEFAULT false
);


--
-- Name: TABLE dossier_autorisation_type_detaille; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_autorisation_type_detaille IS 'Type détaillé des dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type_detaille.dossier_autorisation_type_detaille; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.dossier_autorisation_type_detaille IS 'Identifiant unique';


--
-- Name: COLUMN dossier_autorisation_type_detaille.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.code IS 'Code du type détaillé de dossier d''autorisation (PCI, PCA, PD, PA, ...)';


--
-- Name: COLUMN dossier_autorisation_type_detaille.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.libelle IS 'Libellé du type détaillé de dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type_detaille.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.description IS 'Description du type détaillé de dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type_detaille.dossier_autorisation_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.dossier_autorisation_type IS 'Type de dossier d''autorisation du type détaillé de dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type_detaille.cerfa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.cerfa IS 'Permet de définir le CERFA qui doit être appliqué à ce type détaillé de dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type_detaille.cerfa_lot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.cerfa_lot IS 'Permet de définir le CERFA qui doit être appliqué aux lots de ce type détaillé de dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type_detaille.duree_validite_parametrage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.duree_validite_parametrage IS 'Permet de calculer la date de péremption d''un dossier d''autorisation';


--
-- Name: COLUMN dossier_autorisation_type_detaille.dossier_platau; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.dossier_platau IS 'Permet de déterminer si le type de dossier d''instruction est transmissible à Plat''AU';


--
-- Name: COLUMN dossier_autorisation_type_detaille.couleur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.couleur IS 'Code hexadécimal de la couleur du type de dossier d''autorisation détaillé';


--
-- Name: COLUMN dossier_autorisation_type_detaille.secret_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_autorisation_type_detaille.secret_instruction IS 'Restreint l''accès aux pièces du DA si le DI est toujours en cours d''instruction.';


--
-- Name: dossier_autorisation_type_detaille_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_autorisation_type_detaille_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_autorisation_type_detaille_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_autorisation_type_detaille_seq OWNED BY dossier_autorisation_type_detaille.dossier_autorisation_type_detaille;


--
-- Name: dossier_autorisation_type_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_autorisation_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_autorisation_type_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_autorisation_type_seq OWNED BY dossier_autorisation_type.dossier_autorisation_type;


--
-- Name: dossier_commission; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_commission (
    dossier_commission integer NOT NULL,
    dossier character varying(255) NOT NULL,
    commission_type integer NOT NULL,
    date_souhaitee date NOT NULL,
    motivation text,
    commission integer,
    avis text,
    lu boolean DEFAULT false
);


--
-- Name: TABLE dossier_commission; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_commission IS 'Demande de passage des dossiers d''instruction en commission';


--
-- Name: COLUMN dossier_commission.dossier_commission; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_commission.dossier_commission IS 'Dossier d''instruction de la demande de passage en commission';


--
-- Name: COLUMN dossier_commission.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_commission.dossier IS 'Identifiant unique';


--
-- Name: COLUMN dossier_commission.commission_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_commission.commission_type IS 'Type de commission (Commission Technique d''Urbanisme, ...)';


--
-- Name: COLUMN dossier_commission.date_souhaitee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_commission.date_souhaitee IS 'Date de passage en commission souhaitée';


--
-- Name: COLUMN dossier_commission.motivation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_commission.motivation IS 'Motivation de la demande de passage en commission';


--
-- Name: COLUMN dossier_commission.commission; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_commission.commission IS 'Identifiant de la commission effective';


--
-- Name: COLUMN dossier_commission.avis; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_commission.avis IS 'Avis rendu par la commission';


--
-- Name: COLUMN dossier_commission.lu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_commission.lu IS 'Permet de définir que l''instructeur a lu l''avis rendu';


--
-- Name: dossier_commission_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_commission_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_commission_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_commission_seq OWNED BY dossier_commission.dossier_commission;


--
-- Name: dossier_contrainte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_contrainte (
    dossier_contrainte integer NOT NULL,
    dossier character varying(255) NOT NULL,
    contrainte integer NOT NULL,
    texte_complete text,
    reference boolean DEFAULT false
);


--
-- Name: TABLE dossier_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_contrainte IS 'Table des contraintes appliquées au dossier';


--
-- Name: COLUMN dossier_contrainte.dossier_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_contrainte.dossier_contrainte IS 'Identifiant unique';


--
-- Name: COLUMN dossier_contrainte.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_contrainte.dossier IS 'Dossier auquel est appliqué la contrainte';


--
-- Name: COLUMN dossier_contrainte.contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_contrainte.contrainte IS 'Contrainte appliquée au dossier';


--
-- Name: COLUMN dossier_contrainte.texte_complete; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_contrainte.texte_complete IS 'Texte complété de la contrainte';


--
-- Name: COLUMN dossier_contrainte.reference; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_contrainte.reference IS 'Contrainte récupérée depuis le SIG';


--
-- Name: dossier_contrainte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_contrainte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_contrainte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_contrainte_seq OWNED BY dossier_contrainte.dossier_contrainte;


--
-- Name: dossier_geolocalisation; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_geolocalisation (
    dossier_geolocalisation integer NOT NULL,
    dossier character varying(255) NOT NULL,
    date_verif_parcelle timestamp without time zone,
    etat_verif_parcelle boolean,
    message_verif_parcelle text,
    date_calcul_emprise timestamp without time zone,
    etat_calcul_emprise boolean,
    message_calcul_emprise text,
    date_dessin_emprise timestamp without time zone,
    etat_dessin_emprise boolean,
    message_dessin_emprise text,
    date_calcul_centroide timestamp without time zone,
    etat_calcul_centroide boolean,
    message_calcul_centroide text,
    date_recup_contrainte timestamp without time zone,
    etat_recup_contrainte boolean,
    message_recup_contrainte text,
    terrain_references_cadastrales_archive text
);


--
-- Name: TABLE dossier_geolocalisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_geolocalisation IS 'État de chaque traitement de géolocalisation d''un dossier';


--
-- Name: COLUMN dossier_geolocalisation.dossier_geolocalisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.dossier_geolocalisation IS 'Identifiant unique';


--
-- Name: COLUMN dossier_geolocalisation.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.dossier IS 'Numéro de dossier d''instruction';


--
-- Name: COLUMN dossier_geolocalisation.date_verif_parcelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.date_verif_parcelle IS 'Dernière date à laquelle les parcelles ont été vérifiées dans le SIG';


--
-- Name: COLUMN dossier_geolocalisation.etat_verif_parcelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.etat_verif_parcelle IS 'Dernier état après vérification des parcelles dans le SIG (''true'' s''il n''y a pas eu d''erreur, ''false'' sinon)';


--
-- Name: COLUMN dossier_geolocalisation.message_verif_parcelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.message_verif_parcelle IS 'Dernier message affiché à l''utilisateur après vérification des parcelles dans le SIG';


--
-- Name: COLUMN dossier_geolocalisation.date_calcul_emprise; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.date_calcul_emprise IS 'Dernière date à laquelle l''emprise a été calculé dans le SIG';


--
-- Name: COLUMN dossier_geolocalisation.etat_calcul_emprise; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.etat_calcul_emprise IS 'Dernier état après le calcul de l''emprise dans le SIG (''true'' s''il n''y a pas eu d''erreur, ''false'' sinon)';


--
-- Name: COLUMN dossier_geolocalisation.message_calcul_emprise; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.message_calcul_emprise IS 'Dernier message affiché à l''utilisateur après le calcul de l''emprise dans le SIG';


--
-- Name: COLUMN dossier_geolocalisation.date_dessin_emprise; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.date_dessin_emprise IS 'Dernière date à laquelle l''emprise a été dessiné dans le SIG';


--
-- Name: COLUMN dossier_geolocalisation.etat_dessin_emprise; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.etat_dessin_emprise IS 'Dernier état après le dessin de l''emprise dans le SIG (''true'' s''il n''y a pas eu d''erreur, ''false'' sinon)';


--
-- Name: COLUMN dossier_geolocalisation.message_dessin_emprise; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.message_dessin_emprise IS 'Dernier message affiché à l''utilisateur après le dessin de l''emprise dans le SIG';


--
-- Name: COLUMN dossier_geolocalisation.date_calcul_centroide; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.date_calcul_centroide IS 'Dernière date à laquelle le centroïde a été calculé dans le SIG';


--
-- Name: COLUMN dossier_geolocalisation.etat_calcul_centroide; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.etat_calcul_centroide IS 'Dernier état après le calcul du centroïde dans le SIG (''true'' s''il n''y a pas eu d''erreur, ''false'' sinon)';


--
-- Name: COLUMN dossier_geolocalisation.message_calcul_centroide; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.message_calcul_centroide IS 'Dernier message affiché à l''utilisateur après le calcul du centroïde dans le SIG';


--
-- Name: COLUMN dossier_geolocalisation.date_recup_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.date_recup_contrainte IS 'Dernière date à laquelle les contraintes ont été récupérées depuis le SIG';


--
-- Name: COLUMN dossier_geolocalisation.etat_recup_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.etat_recup_contrainte IS 'Dernier état après récupération des contraintes depuis le SIG (''true'' s''il n''y a pas eu d''erreur, ''false'' sinon)';


--
-- Name: COLUMN dossier_geolocalisation.message_recup_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.message_recup_contrainte IS 'Dernier message affiché à l''utilisateur après la récupération des contraintes depuis le SIG';


--
-- Name: COLUMN dossier_geolocalisation.terrain_references_cadastrales_archive; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_geolocalisation.terrain_references_cadastrales_archive IS 'Références cadastrales récupérées depuis le dossier d''instruction. Mise à jour seulement lorsque les références cadastrales du dossier d''instruction ont été vérifiées';


--
-- Name: dossier_geolocalisation_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_geolocalisation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_geolocalisation_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_geolocalisation_seq OWNED BY dossier_geolocalisation.dossier_geolocalisation;


--
-- Name: dossier_instruction_type; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_instruction_type (
    dossier_instruction_type integer NOT NULL,
    code character varying(20),
    libelle character varying(100),
    description text,
    dossier_autorisation_type_detaille integer,
    suffixe boolean DEFAULT false,
    mouvement_sitadel character varying(20),
    maj_da_localisation boolean DEFAULT false NOT NULL,
    maj_da_lot boolean DEFAULT false NOT NULL,
    maj_da_demandeur boolean DEFAULT false NOT NULL,
    maj_da_etat boolean DEFAULT false NOT NULL,
    maj_da_date_init boolean DEFAULT false NOT NULL,
    maj_da_date_validite boolean DEFAULT false NOT NULL,
    maj_da_date_doc boolean DEFAULT false NOT NULL,
    maj_da_date_daact boolean DEFAULT false NOT NULL,
    maj_da_dt boolean DEFAULT false NOT NULL,
    sous_dossier boolean DEFAULT false NOT NULL
);


--
-- Name: TABLE dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_instruction_type IS 'Type de dossier d''instruction (initial, modificatif, transfert, ...)';


--
-- Name: COLUMN dossier_instruction_type.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.dossier_instruction_type IS 'Identifiant unique';


--
-- Name: COLUMN dossier_instruction_type.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.code IS 'Code du type de dossier d''instruction';


--
-- Name: COLUMN dossier_instruction_type.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.libelle IS 'Libellé du type de dossier d''instruction';


--
-- Name: COLUMN dossier_instruction_type.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.description IS 'Description du type de dossier d''instruction';


--
-- Name: COLUMN dossier_instruction_type.dossier_autorisation_type_detaille; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.dossier_autorisation_type_detaille IS 'Identifiant du type détaillé de dossier d''autorisation';


--
-- Name: COLUMN dossier_instruction_type.suffixe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.suffixe IS 'Permet de définir si un suffixe doit être appliqué au numéro de dossier d''instruction';


--
-- Name: COLUMN dossier_instruction_type.mouvement_sitadel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.mouvement_sitadel IS 'Mouvement SITADEL associé';


--
-- Name: COLUMN dossier_instruction_type.maj_da_localisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.maj_da_localisation IS 'Mise à jour de la localisation';


--
-- Name: COLUMN dossier_instruction_type.maj_da_lot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.maj_da_lot IS 'Mise à jour des lots';


--
-- Name: COLUMN dossier_instruction_type.maj_da_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.maj_da_demandeur IS 'Mise à jour des demandeurs';


--
-- Name: COLUMN dossier_instruction_type.maj_da_etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.maj_da_etat IS 'Mise à jour de l''état';


--
-- Name: COLUMN dossier_instruction_type.maj_da_date_init; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.maj_da_date_init IS 'Mise à jour des dates initiales';


--
-- Name: COLUMN dossier_instruction_type.maj_da_date_validite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.maj_da_date_validite IS 'Mise à jour de la date de validité';


--
-- Name: COLUMN dossier_instruction_type.maj_da_date_doc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.maj_da_date_doc IS 'Mise à jour de la date d''ouverture du chantier';


--
-- Name: COLUMN dossier_instruction_type.maj_da_date_daact; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.maj_da_date_daact IS 'Mise à jour de la date d''achèvement des travaux';


--
-- Name: COLUMN dossier_instruction_type.maj_da_dt; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.maj_da_dt IS 'Mise à jour des données techniques';


--
-- Name: COLUMN dossier_instruction_type.sous_dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_instruction_type.sous_dossier IS 'Indique si un type de dossier d''instruction est un sous-dossier.';


--
-- Name: dossier_instruction_type_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_instruction_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_instruction_type_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_instruction_type_seq OWNED BY dossier_instruction_type.dossier_instruction_type;


--
-- Name: dossier_message; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_message (
    dossier_message integer NOT NULL,
    dossier character varying(255) NOT NULL,
    type character varying(60),
    emetteur character varying(63),
    date_emission timestamp without time zone NOT NULL,
    lu boolean DEFAULT false,
    contenu text,
    categorie character varying(60),
    destinataire character varying(60) NOT NULL
);


--
-- Name: TABLE dossier_message; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_message IS 'Messages liés aux dossiers';


--
-- Name: COLUMN dossier_message.dossier_message; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_message.dossier_message IS 'Identifiant unique';


--
-- Name: COLUMN dossier_message.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_message.dossier IS 'Dossier d''instruction de ce messages';


--
-- Name: COLUMN dossier_message.type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_message.type IS 'Type de message';


--
-- Name: COLUMN dossier_message.emetteur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_message.emetteur IS 'Service émetteur du message';


--
-- Name: COLUMN dossier_message.date_emission; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_message.date_emission IS 'Date d''envoi du message';


--
-- Name: COLUMN dossier_message.lu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_message.lu IS 'Permet de définir que l''instructeur a lu le message';


--
-- Name: COLUMN dossier_message.contenu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_message.contenu IS 'Contenu du message';


--
-- Name: COLUMN dossier_message.categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_message.categorie IS 'Carégorie du message (interne ou externe)';


--
-- Name: COLUMN dossier_message.destinataire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_message.destinataire IS 'Destinataire du message ("instructeur" par défaut, ou "commune")';


--
-- Name: dossier_message_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_message_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_message_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_message_seq OWNED BY dossier_message.dossier_message;


--
-- Name: dossier_operateur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_operateur (
    dossier_operateur integer NOT NULL,
    operateur_designation_initialisee boolean DEFAULT false NOT NULL,
    operateur_detecte_inrap integer,
    operateur_detecte_collterr text DEFAULT '[]'::text,
    operateur_collterr_type_agrement character varying(30),
    operateur_amenagement_pers_publique character varying(1) DEFAULT NULL::character varying,
    operateur_pers_publique_amenageur character varying(1) DEFAULT NULL::character varying,
    operateur_collterr_kpark_avis character varying(30),
    operateur_selectionne integer,
    operateur_personne_publique integer,
    operateur_personne_publique_avis character varying(30),
    operateur_kpark_libelle character varying(50) DEFAULT ''::character varying,
    operateur_kpark_type_operateur character varying(50) DEFAULT ''::character varying,
    operateur_kpark_evenement character varying(50) DEFAULT ''::character varying,
    operateur_designe integer,
    operateur_valide boolean DEFAULT false NOT NULL,
    operateur_designe_historique text DEFAULT '[]'::text,
    dossier_instruction character varying(255) NOT NULL
);


--
-- Name: COLUMN dossier_operateur.dossier_operateur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.dossier_operateur IS 'Identifiant';


--
-- Name: COLUMN dossier_operateur.operateur_designation_initialisee; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_designation_initialisee IS 'Permet d''identifier si une recherche d''opérateur a été déclenchée';


--
-- Name: COLUMN dossier_operateur.operateur_detecte_inrap; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_detecte_inrap IS 'Identifiant du tiers consulté INRAP détecté par la recherche';


--
-- Name: COLUMN dossier_operateur.operateur_detecte_collterr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_detecte_collterr IS 'Liste des tiers consultés Collectivités Territoriales';


--
-- Name: COLUMN dossier_operateur.operateur_collterr_type_agrement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_collterr_type_agrement IS 'Peut contenir les valeurs "tout_diag" ou "kpark", permet d''identifier si au moins un opérateur détecté à l''habilitation "kpark" sinon qu''il n''y a que des opérateurs avec l''habilitation "tout_diag" [P3]';


--
-- Name: COLUMN dossier_operateur.operateur_amenagement_pers_publique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_amenagement_pers_publique IS 'L''aménagement est-il réalisé par ou pour une personne publique (R523-28) ? (Non par défaut) [P4] {Prend comme valeur NULL, t ou f}';


--
-- Name: COLUMN dossier_operateur.operateur_pers_publique_amenageur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_pers_publique_amenageur IS 'La personne publique "article R523-28" est-elle l''aménageur du projet ?  (Oui par défaut) [P5] {Prend comme valeur NULL, t ou f}';


--
-- Name: COLUMN dossier_operateur.operateur_collterr_kpark_avis; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_collterr_kpark_avis IS 'Avis rendu par le tiers consulté Collectivité Territoriale avec l''habilitation au cas par cas ("Favorable", "Défavorable" ou "Tacite") [P6]';


--
-- Name: COLUMN dossier_operateur.operateur_selectionne; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_selectionne IS 'Identifiant du tiers consulté Collectivités Territoriales sélectionné';


--
-- Name: COLUMN dossier_operateur.operateur_personne_publique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_personne_publique IS 'Identifiant du tiers consulté Personne Publique sélectionné';


--
-- Name: COLUMN dossier_operateur.operateur_personne_publique_avis; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_personne_publique_avis IS 'Avis rendu par le tiers consulté Personne Publique ("Favorable", "Défavorable" ou "Tacite") [P7]';


--
-- Name: COLUMN dossier_operateur.operateur_kpark_libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_kpark_libelle IS 'Nom du cas détecté si un cas est applicable';


--
-- Name: COLUMN dossier_operateur.operateur_kpark_type_operateur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_kpark_type_operateur IS 'Paramètre du choix issu du paramètre de cas "collterr" ou "inrap"';


--
-- Name: COLUMN dossier_operateur.operateur_kpark_evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_kpark_evenement IS 'Identifiant de l''événement à ajouter comme instruction lors de la validation de l''opérateur';


--
-- Name: COLUMN dossier_operateur.operateur_designe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_designe IS 'Identifiant du tiers consulté désigné pour le dossier';


--
-- Name: COLUMN dossier_operateur.operateur_valide; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_valide IS 'Permet d''identifier que l''opérateur désigné est bien validé';


--
-- Name: COLUMN dossier_operateur.operateur_designe_historique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.operateur_designe_historique IS 'JSON contenant l''historique des opérateurs désigné sur le dossier';


--
-- Name: COLUMN dossier_operateur.dossier_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_operateur.dossier_instruction IS 'Dossier d''instruction sur lequel l''opérateur est désigné';


--
-- Name: dossier_operateur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_operateur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_operateur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_operateur_seq OWNED BY dossier_operateur.dossier_operateur;


--
-- Name: dossier_parcelle; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE dossier_parcelle (
    dossier_parcelle integer NOT NULL,
    dossier character varying(255) NOT NULL,
    parcelle character varying(20) DEFAULT NULL::character varying,
    libelle character varying(20)
);


--
-- Name: TABLE dossier_parcelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE dossier_parcelle IS 'Parcelles liées aux dossiers d''instruction (Permet de découper les références cadastrales d''un dossier d''instruction)';


--
-- Name: COLUMN dossier_parcelle.dossier_parcelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_parcelle.dossier_parcelle IS 'Identifiant unique';


--
-- Name: COLUMN dossier_parcelle.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_parcelle.dossier IS 'Dossier d''instruction de la pzrcelle';


--
-- Name: COLUMN dossier_parcelle.parcelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_parcelle.parcelle IS 'Parcelle liée';


--
-- Name: COLUMN dossier_parcelle.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN dossier_parcelle.libelle IS 'Libellé de la parcelle';


--
-- Name: dossier_parcelle_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE dossier_parcelle_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: dossier_parcelle_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE dossier_parcelle_seq OWNED BY dossier_parcelle.dossier_parcelle;


--
-- Name: erp_categorie; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE erp_categorie (
    erp_categorie integer NOT NULL,
    libelle character varying(100),
    description character varying(250)
);


--
-- Name: TABLE erp_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE erp_categorie IS 'Catégorie de l''ERP.';


--
-- Name: COLUMN erp_categorie.erp_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN erp_categorie.erp_categorie IS 'Identifiant unique.';


--
-- Name: COLUMN erp_categorie.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN erp_categorie.libelle IS 'Nom de la catégorie.';


--
-- Name: COLUMN erp_categorie.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN erp_categorie.description IS 'Description de la catégorie.';


--
-- Name: erp_categorie_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE erp_categorie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: erp_categorie_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE erp_categorie_seq OWNED BY erp_categorie.erp_categorie;


--
-- Name: erp_type; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE erp_type (
    erp_type integer NOT NULL,
    libelle character varying(100),
    description character varying(250)
);


--
-- Name: TABLE erp_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE erp_type IS 'Types de l''ERP.';


--
-- Name: COLUMN erp_type.erp_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN erp_type.erp_type IS 'Identifiant unique.';


--
-- Name: COLUMN erp_type.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN erp_type.libelle IS 'Texte affiché pour le type (Exemple : Type S).';


--
-- Name: COLUMN erp_type.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN erp_type.description IS 'Description du type.';


--
-- Name: erp_type_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE erp_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: erp_type_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE erp_type_seq OWNED BY erp_type.erp_type;


--
-- Name: etat; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE etat (
    etat character varying(150) NOT NULL,
    libelle character varying(50) NOT NULL,
    statut character varying(60)
);


--
-- Name: TABLE etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE etat IS 'États des dossiers d''instruction';


--
-- Name: COLUMN etat.etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN etat.etat IS 'Identifiant unique';


--
-- Name: COLUMN etat.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN etat.libelle IS 'Libellé de l''état';


--
-- Name: COLUMN etat.statut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN etat.statut IS 'Statut de l''état (encours, clôture)';


--
-- Name: etat_dossier_autorisation; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE etat_dossier_autorisation (
    etat_dossier_autorisation integer NOT NULL,
    libelle character varying(100)
);


--
-- Name: TABLE etat_dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE etat_dossier_autorisation IS 'États des dossiers d''autorisation';


--
-- Name: COLUMN etat_dossier_autorisation.etat_dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN etat_dossier_autorisation.etat_dossier_autorisation IS 'Identifiant unique';


--
-- Name: COLUMN etat_dossier_autorisation.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN etat_dossier_autorisation.libelle IS 'Libellé de l''état';


--
-- Name: etat_dossier_autorisation_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE etat_dossier_autorisation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: etat_dossier_autorisation_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE etat_dossier_autorisation_seq OWNED BY etat_dossier_autorisation.etat_dossier_autorisation;


--
-- Name: evenement; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE evenement (
    evenement integer NOT NULL,
    libelle character varying(70) NOT NULL,
    action character varying(150),
    etat character varying(150),
    delai integer,
    accord_tacite character(3) DEFAULT ''::bpchar NOT NULL,
    delai_notification integer,
    lettretype character varying(50) DEFAULT ''::character varying NOT NULL,
    consultation character(3) DEFAULT ''::bpchar NOT NULL,
    avis_decision integer,
    restriction character varying(255),
    type character varying(100),
    evenement_retour_ar integer,
    evenement_suivant_tacite integer,
    evenement_retour_signature integer,
    autorite_competente integer,
    retour boolean DEFAULT false,
    non_verrouillable boolean DEFAULT false,
    phase integer,
    finaliser_automatiquement boolean DEFAULT false,
    pec_metier integer,
    commentaire boolean DEFAULT false,
    non_modifiable boolean DEFAULT false,
    non_supprimable boolean DEFAULT false,
    notification character varying(100),
    envoi_cl_platau boolean DEFAULT false,
    signataire_obligatoire boolean DEFAULT false,
    notification_service boolean DEFAULT false,
    notification_tiers character varying(50)
);


--
-- Name: TABLE evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE evenement IS 'Paramétrage des événements d''instruction';


--
-- Name: COLUMN evenement.evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.evenement IS 'Identifiant unique';


--
-- Name: COLUMN evenement.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.libelle IS 'Libellé de l''événement';


--
-- Name: COLUMN evenement.action; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.action IS 'Action à effectuer après l''ajout d''un événement';


--
-- Name: COLUMN evenement.etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.etat IS 'État à appliquer au dossier d''instruction';


--
-- Name: COLUMN evenement.delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.delai IS 'Permet de calculer la durée de validité de l''instruction';


--
-- Name: COLUMN evenement.accord_tacite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.accord_tacite IS 'Permet de définir le type d''accord à la fin du délai limite d''instruction';


--
-- Name: COLUMN evenement.delai_notification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.delai_notification IS 'Délai de notification avant que l''accord tacite soit appliqué';


--
-- Name: COLUMN evenement.lettretype; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.lettretype IS 'Courrier associé à l''événement';


--
-- Name: COLUMN evenement.consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.consultation IS 'Consultation liée à l''événement';


--
-- Name: COLUMN evenement.avis_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.avis_decision IS 'Avis sur la décision du dossier d''instruction';


--
-- Name: COLUMN evenement.restriction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.restriction IS 'Formule optionnelle permettant de refuser la validation du formulaire d’ajout d’événement d’instruction si le résultat de la formule est faux';


--
-- Name: COLUMN evenement.type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.type IS 'Permet de qualifier un type d’événement. Les valeurs disponibles sont : “arrêté” pour permettre une gestion propre aux arrêtés, ou “incomplétude” ou “majoration de délais” pour permettre certains calculs dans les tableaux de bord de l’instructeur';


--
-- Name: COLUMN evenement.evenement_retour_ar; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.evenement_retour_ar IS 'Événement déclenché par un retour AR';


--
-- Name: COLUMN evenement.evenement_suivant_tacite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.evenement_suivant_tacite IS 'Événement déclenché par une decision tacite';


--
-- Name: COLUMN evenement.evenement_retour_signature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.evenement_retour_signature IS 'Événement déclenché par un retour de signature';


--
-- Name: COLUMN evenement.autorite_competente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.autorite_competente IS 'Permet de définir l''autorité compétente du dossier d''instruction';


--
-- Name: COLUMN evenement.retour; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.retour IS 'Permet de définir s''il s''agit d''un événement de retour d''AR ou de signature';


--
-- Name: COLUMN evenement.non_verrouillable; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.non_verrouillable IS 'Permet d''identifier un événement non verrouillable, c''est-à-dire que l''événement d''instruction sera toujours modifiable même si le dossier d''autorisation est clôturé';


--
-- Name: COLUMN evenement.phase; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.phase IS 'Phase';


--
-- Name: COLUMN evenement.finaliser_automatiquement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.finaliser_automatiquement IS 'Finalisation automatique de l''événement';


--
-- Name: COLUMN evenement.pec_metier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.pec_metier IS 'Statut de la prise en compte métier de l''événement destiné au dossier d''instruction';


--
-- Name: COLUMN evenement.commentaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.commentaire IS 'Permet de définir si des commentaires doivent pouvoir être ajoutés à l''événement.';


--
-- Name: COLUMN evenement.non_modifiable; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.non_modifiable IS 'Permet d''identifier si l''évenement ne doit plus pouvoir être modifié après ajout.';


--
-- Name: COLUMN evenement.non_supprimable; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.non_supprimable IS 'Permet d''identifier si l''évenement ne doit plus pouvoir être supprimé après ajout.';


--
-- Name: COLUMN evenement.notification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.notification IS 'Type de notification voulu sur l''évenement';


--
-- Name: COLUMN evenement.envoi_cl_platau; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.envoi_cl_platau IS 'L''envoi au contrôle de légalité se fait par Plat''AU, le suivi de la date d''envoi n''est plus possible manuellement';


--
-- Name: COLUMN evenement.signataire_obligatoire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement.signataire_obligatoire IS 'Option servant a indiquer si un signataire doit obligatoirement être renseigné avant finalisation.';


--
-- Name: evenement_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE evenement_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: evenement_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE evenement_seq OWNED BY evenement.evenement;


--
-- Name: evenement_type_habilitation_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE evenement_type_habilitation_tiers_consulte (
    evenement_type_habilitation_tiers_consulte integer NOT NULL,
    evenement integer NOT NULL,
    type_habilitation_tiers_consulte integer NOT NULL
);


--
-- Name: COLUMN evenement_type_habilitation_tiers_consulte.evenement_type_habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement_type_habilitation_tiers_consulte.evenement_type_habilitation_tiers_consulte IS 'Identifiant du lien entre un évènement et un type d''habilitation pouvant être notifié automatiquement.';


--
-- Name: COLUMN evenement_type_habilitation_tiers_consulte.evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement_type_habilitation_tiers_consulte.evenement IS 'Identifiant du type d''habilitation de tiers qui sera automatiquement notifié à l''ajout de l''evenement lors d''une instruction.';


--
-- Name: COLUMN evenement_type_habilitation_tiers_consulte.type_habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN evenement_type_habilitation_tiers_consulte.type_habilitation_tiers_consulte IS 'Identifiant de l''évènement concerné.';


--
-- Name: evenement_type_habilitation_tiers_consulte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE evenement_type_habilitation_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: evenement_type_habilitation_tiers_consulte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE evenement_type_habilitation_tiers_consulte_seq OWNED BY evenement_type_habilitation_tiers_consulte.evenement_type_habilitation_tiers_consulte;


--
-- Name: famille_travaux; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE famille_travaux (
    famille_travaux integer NOT NULL,
    libelle character varying(255) NOT NULL,
    code character varying(50),
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: COLUMN famille_travaux.famille_travaux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN famille_travaux.famille_travaux IS 'Identifiant unique numérique';


--
-- Name: COLUMN famille_travaux.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN famille_travaux.libelle IS 'Nom de la famille de travaux';


--
-- Name: COLUMN famille_travaux.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN famille_travaux.code IS 'Code de la famille de travaux';


--
-- Name: COLUMN famille_travaux.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN famille_travaux.description IS 'Description de la famille de travaux';


--
-- Name: COLUMN famille_travaux.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN famille_travaux.om_validite_debut IS 'Date de début de validité';


--
-- Name: COLUMN famille_travaux.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN famille_travaux.om_validite_fin IS 'Date de fin de validité';


--
-- Name: famille_travaux_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE famille_travaux_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: famille_travaux_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE famille_travaux_seq OWNED BY famille_travaux.famille_travaux;


--
-- Name: genre; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE genre (
    genre integer NOT NULL,
    code character varying(20),
    libelle character varying(100),
    description text
);


--
-- Name: TABLE genre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE genre IS 'Genre des services d''affectation des dossiers d''instruction (URBA, ERP)';


--
-- Name: COLUMN genre.genre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN genre.genre IS 'Identifiant unique';


--
-- Name: COLUMN genre.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN genre.code IS 'Code du genre de services (URBA, ERP)';


--
-- Name: COLUMN genre.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN genre.libelle IS 'Libellé du service';


--
-- Name: COLUMN genre.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN genre.description IS 'Description du service';


--
-- Name: genre_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE genre_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: genre_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE genre_seq OWNED BY genre.genre;


--
-- Name: groupe; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE groupe (
    groupe integer NOT NULL,
    code character varying(20),
    libelle character varying(100),
    description text,
    genre integer NOT NULL
);


--
-- Name: TABLE groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE groupe IS 'Services d''affectation des dossiers d''instruction (URBA, ERP)';


--
-- Name: COLUMN groupe.groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN groupe.groupe IS 'Identifiant unique';


--
-- Name: COLUMN groupe.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN groupe.code IS 'Code du service (ADS, CTX, CU, ERP, ...)';


--
-- Name: COLUMN groupe.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN groupe.libelle IS 'Libellé du service';


--
-- Name: COLUMN groupe.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN groupe.description IS 'Description du service';


--
-- Name: COLUMN groupe.genre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN groupe.genre IS 'Genre d''appartenance du service';


--
-- Name: groupe_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE groupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: groupe_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE groupe_seq OWNED BY groupe.groupe;


--
-- Name: habilitation_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE habilitation_tiers_consulte (
    habilitation_tiers_consulte integer NOT NULL,
    type_habilitation_tiers_consulte integer NOT NULL,
    texte_agrement text,
    division_territoriales text,
    om_validite_debut date,
    om_validite_fin date,
    tiers_consulte integer NOT NULL
);


--
-- Name: COLUMN habilitation_tiers_consulte.habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN habilitation_tiers_consulte.habilitation_tiers_consulte IS 'Identifiant unique';


--
-- Name: COLUMN habilitation_tiers_consulte.type_habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN habilitation_tiers_consulte.type_habilitation_tiers_consulte IS 'Identifiant unique du type d''habilitation';


--
-- Name: COLUMN habilitation_tiers_consulte.texte_agrement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN habilitation_tiers_consulte.texte_agrement IS 'Texte d’agrément';


--
-- Name: COLUMN habilitation_tiers_consulte.division_territoriales; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN habilitation_tiers_consulte.division_territoriales IS 'Divisions territoriales';


--
-- Name: COLUMN habilitation_tiers_consulte.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN habilitation_tiers_consulte.om_validite_debut IS 'Date de début de validité de l''habilitation du tiers consulté';


--
-- Name: COLUMN habilitation_tiers_consulte.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN habilitation_tiers_consulte.om_validite_fin IS 'Date de fin de validité de l''habilitation du tiers consulté';


--
-- Name: habilitation_tiers_consulte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE habilitation_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: habilitation_tiers_consulte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE habilitation_tiers_consulte_seq OWNED BY habilitation_tiers_consulte.habilitation_tiers_consulte;


--
-- Name: instructeur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE instructeur (
    instructeur integer NOT NULL,
    nom character varying(100) NOT NULL,
    telephone character varying(20),
    division integer NOT NULL,
    om_utilisateur integer,
    om_validite_debut date,
    om_validite_fin date,
    instructeur_qualite integer NOT NULL
);


--
-- Name: TABLE instructeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE instructeur IS 'Instructeur de dossier d''instruction';


--
-- Name: COLUMN instructeur.instructeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur.instructeur IS 'Identifiant unique';


--
-- Name: COLUMN instructeur.nom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur.nom IS 'Nom de l''instructeur';


--
-- Name: COLUMN instructeur.telephone; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur.telephone IS 'Téléphone de l''instructeur';


--
-- Name: COLUMN instructeur.division; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur.division IS 'Division de l''instructeur';


--
-- Name: COLUMN instructeur.om_utilisateur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur.om_utilisateur IS 'Utilisateur correspondant à l''instructeur';


--
-- Name: COLUMN instructeur.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur.om_validite_debut IS 'Date de début de validité de l''instructeur';


--
-- Name: COLUMN instructeur.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur.om_validite_fin IS 'Date de fin de validité de l''instructeur';


--
-- Name: COLUMN instructeur.instructeur_qualite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur.instructeur_qualite IS 'Qualité de l''instructeur';


--
-- Name: instructeur_qualite; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE instructeur_qualite (
    instructeur_qualite integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(255) NOT NULL,
    description text
);


--
-- Name: TABLE instructeur_qualite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE instructeur_qualite IS 'Qualités de l''instructeur';


--
-- Name: COLUMN instructeur_qualite.instructeur_qualite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur_qualite.instructeur_qualite IS 'Identifiant unique';


--
-- Name: COLUMN instructeur_qualite.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur_qualite.code IS 'Code';


--
-- Name: COLUMN instructeur_qualite.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur_qualite.libelle IS 'Libelle';


--
-- Name: COLUMN instructeur_qualite.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instructeur_qualite.description IS 'Description';


--
-- Name: instructeur_qualite_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE instructeur_qualite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: instructeur_qualite_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE instructeur_qualite_seq OWNED BY instructeur_qualite.instructeur_qualite;


--
-- Name: instructeur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE instructeur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: instructeur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE instructeur_seq OWNED BY instructeur.instructeur;


--
-- Name: instruction; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE instruction (
    instruction integer NOT NULL,
    destinataire character varying(255) DEFAULT ''::character varying NOT NULL,
    date_evenement date NOT NULL,
    evenement integer NOT NULL,
    lettretype character varying(50) DEFAULT ''::character varying NOT NULL,
    complement_om_html text,
    complement2_om_html text,
    dossier character varying(255),
    action character varying(150),
    delai integer,
    etat character varying(150),
    accord_tacite character(3) DEFAULT ''::bpchar NOT NULL,
    delai_notification integer DEFAULT 0 NOT NULL,
    archive_delai bigint DEFAULT (0)::bigint NOT NULL,
    archive_date_complet date,
    archive_date_rejet date,
    archive_date_limite date,
    archive_date_notification_delai date,
    archive_accord_tacite character(3) DEFAULT ''::bpchar NOT NULL,
    archive_etat character varying(150) DEFAULT ''::character varying NOT NULL,
    archive_date_decision date,
    archive_avis character varying(20) DEFAULT ''::character varying NOT NULL,
    archive_date_validite date,
    archive_date_achevement date,
    archive_date_chantier date,
    archive_date_conformite date,
    complement3_om_html text,
    complement4_om_html text,
    complement5_om_html text,
    complement6_om_html text,
    complement7_om_html text,
    complement8_om_html text,
    complement9_om_html text,
    complement10_om_html text,
    complement11_om_html text,
    complement12_om_html text,
    complement13_om_html text,
    complement14_om_html text,
    complement15_om_html text,
    avis_decision integer,
    date_finalisation_courrier date,
    date_envoi_signature date,
    date_retour_signature date,
    date_envoi_rar date,
    date_retour_rar date,
    date_envoi_controle_legalite date,
    date_retour_controle_legalite date,
    signataire_arrete integer,
    numero_arrete character varying(100),
    archive_date_dernier_depot date,
    archive_incompletude boolean DEFAULT false NOT NULL,
    archive_evenement_suivant_tacite integer,
    archive_evenement_suivant_tacite_incompletude integer,
    archive_etat_pendant_incompletude character varying(150),
    archive_date_limite_incompletude date,
    archive_delai_incompletude integer,
    code_barres character varying(12),
    om_fichier_instruction character varying(255),
    om_final_instruction boolean,
    document_numerise integer,
    archive_autorite_competente integer,
    autorite_competente integer,
    duree_validite_parametrage integer DEFAULT 0 NOT NULL,
    duree_validite integer DEFAULT 0 NOT NULL,
    archive_incomplet_notifie boolean DEFAULT false,
    om_final_instruction_utilisateur text,
    created_by_commune boolean DEFAULT false,
    date_depot date,
    archive_date_cloture_instruction date,
    archive_date_premiere_visite date,
    archive_date_derniere_visite date,
    archive_date_contradictoire date,
    archive_date_retour_contradictoire date,
    archive_date_ait date,
    archive_date_transmission_parquet date,
    om_fichier_instruction_dossier_final boolean DEFAULT false,
    flag_edition_integrale boolean,
    titre_om_htmletat text,
    corps_om_htmletatex text,
    archive_dossier_instruction_type integer,
    archive_date_affichage date,
    date_depot_mairie date,
    pec_metier integer,
    archive_pec_metier integer,
    archive_a_qualifier boolean DEFAULT false NOT NULL,
    id_parapheur_signature character varying(255),
    statut_signature character varying(255),
    historique_signature text,
    commentaire_signature text,
    commentaire text,
    envoye_cl_platau boolean DEFAULT false,
    parapheur_lien_page_signature character varying(1000) DEFAULT NULL::character varying
);


--
-- Name: TABLE instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE instruction IS 'Événements d''instruction de chaque dossier d''instruction';


--
-- Name: COLUMN instruction.instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.instruction IS 'Identifiant unique';


--
-- Name: COLUMN instruction.destinataire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.destinataire IS 'Numéro de dossier d''instruction cible';


--
-- Name: COLUMN instruction.date_evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_evenement IS 'Date de l''événement d''instruction';


--
-- Name: COLUMN instruction.evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.evenement IS 'Événement du workflow lié à l''événement d''instruction';


--
-- Name: COLUMN instruction.lettretype; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.lettretype IS 'Identifiant du courrier lié';


--
-- Name: COLUMN instruction.complement_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement2_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement2_om_html IS 'Second complément d''information';


--
-- Name: COLUMN instruction.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.dossier IS 'Numéro de dossier d''instruction cible';


--
-- Name: COLUMN instruction.action; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.action IS 'Action du workflow appliquée au dossier d''instruction';


--
-- Name: COLUMN instruction.delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.delai IS 'Délai de majoration appliqué au dossier d''instruction';


--
-- Name: COLUMN instruction.etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.etat IS 'État appliqué au dossier d''instruction';


--
-- Name: COLUMN instruction.accord_tacite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.accord_tacite IS 'Permet de définir si un accord tacite est trouvé à la fin du délai d''instruction';


--
-- Name: COLUMN instruction.delai_notification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.delai_notification IS 'Délai de notification de l''instruction';


--
-- Name: COLUMN instruction.archive_delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_delai IS 'Valeur du dossier avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_complet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_complet IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_rejet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_rejet IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_limite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_limite IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_notification_delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_notification_delai IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_accord_tacite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_accord_tacite IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_etat IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_decision IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_avis; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_avis IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_validite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_validite IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_achevement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_achevement IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_chantier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_chantier IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_conformite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_conformite IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.complement3_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement3_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement4_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement4_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement5_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement5_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement6_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement6_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement7_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement7_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement8_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement8_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement9_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement9_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement10_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement10_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement11_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement11_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement12_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement12_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement13_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement13_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement14_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement14_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.complement15_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.complement15_om_html IS 'Complément d''information';


--
-- Name: COLUMN instruction.avis_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.avis_decision IS 'Decision sur le dossier d''instruction après ajout de l''événement';


--
-- Name: COLUMN instruction.date_finalisation_courrier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_finalisation_courrier IS 'Date de finalisation du courrier';


--
-- Name: COLUMN instruction.date_envoi_signature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_envoi_signature IS 'Date d''envoi du courrier pour signature par l''autorité compétente';


--
-- Name: COLUMN instruction.date_retour_signature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_retour_signature IS 'Date de retour du courrier après signature';


--
-- Name: COLUMN instruction.date_envoi_rar; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_envoi_rar IS 'Date d''envoi du courrier aux pétitionnaires';


--
-- Name: COLUMN instruction.date_retour_rar; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_retour_rar IS 'Date de retour d''accusé de réception du courrier';


--
-- Name: COLUMN instruction.date_envoi_controle_legalite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_envoi_controle_legalite IS 'Date d''envoi du courrier au contrôle de légalité';


--
-- Name: COLUMN instruction.date_retour_controle_legalite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_retour_controle_legalite IS 'Date de retour du courrier après contrôle de légalité';


--
-- Name: COLUMN instruction.signataire_arrete; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.signataire_arrete IS 'Identifiant du signataire de l''arrêté';


--
-- Name: COLUMN instruction.numero_arrete; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.numero_arrete IS 'Numéro de l''arrêté dans le référenciel arrêté';


--
-- Name: COLUMN instruction.archive_date_dernier_depot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_dernier_depot IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_incompletude IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_evenement_suivant_tacite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_evenement_suivant_tacite IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_evenement_suivant_tacite_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_evenement_suivant_tacite_incompletude IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_etat_pendant_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_etat_pendant_incompletude IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_limite_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_limite_incompletude IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_delai_incompletude; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_delai_incompletude IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.code_barres; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.code_barres IS 'Numéro du code barres correspondant à l''instruction';


--
-- Name: COLUMN instruction.om_fichier_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.om_fichier_instruction IS 'Identifiant du fichier finalisé dans le système de stockage';


--
-- Name: COLUMN instruction.om_final_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.om_final_instruction IS 'Permet de savoir si le fichier est finalisé';


--
-- Name: COLUMN instruction.document_numerise; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.document_numerise IS 'Lien vers les documents numérisés';


--
-- Name: COLUMN instruction.archive_autorite_competente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_autorite_competente IS 'Valeur du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.autorite_competente; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.autorite_competente IS 'Lien vers l''autorité compétente affectée au dossier d''instruction';


--
-- Name: COLUMN instruction.duree_validite_parametrage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.duree_validite_parametrage IS 'Durée de validité du dossier d''autorisation récupérée depuis le paramétrage';


--
-- Name: COLUMN instruction.duree_validite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.duree_validite IS 'Durée de validité du dossier d''autorisation depuis le dépôt initial';


--
-- Name: COLUMN instruction.archive_incomplet_notifie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_incomplet_notifie IS 'Archive du champ dossier.incomplet_notifie';


--
-- Name: COLUMN instruction.om_final_instruction_utilisateur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.om_final_instruction_utilisateur IS 'Login et nom de l''utilisateur qui a finalisé l''événement';


--
-- Name: COLUMN instruction.date_depot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_depot IS 'Date du dépôt du dossier d''instruction';


--
-- Name: COLUMN instruction.archive_date_cloture_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_cloture_instruction IS 'Valeur du champ date_cloture_instruction du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_premiere_visite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_premiere_visite IS 'Valeur du champ date_premiere_visite du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_derniere_visite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_derniere_visite IS 'Valeur du champ date_derniere_visite du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_contradictoire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_contradictoire IS 'Valeur du champ date_contradictoire du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_retour_contradictoire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_retour_contradictoire IS 'Valeur du champ date_retour_contradictoire du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_ait; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_ait IS 'Valeur du champ date_ait du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_date_transmission_parquet; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_transmission_parquet IS 'Valeur du champ date_transmission_parquet du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.om_fichier_instruction_dossier_final; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.om_fichier_instruction_dossier_final IS 'Identifie que le document constitue dossier final';


--
-- Name: COLUMN instruction.flag_edition_integrale; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.flag_edition_integrale IS 'Flag permettant d''identifier le type de rédaction ("true" la rédaction est libre et permet de modifier le titre et le corps du courrier, "false" la rédaction est par complément)';


--
-- Name: COLUMN instruction.titre_om_htmletat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.titre_om_htmletat IS 'Contenu du titre du courrier récupéré depuis la lettre type associé';


--
-- Name: COLUMN instruction.corps_om_htmletatex; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.corps_om_htmletatex IS 'Contenu du corps du courrier récupéré depuis la lettre type associé';


--
-- Name: COLUMN instruction.archive_dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_dossier_instruction_type IS 'Type du dossier d''instruction';


--
-- Name: COLUMN instruction.archive_date_affichage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_date_affichage IS 'Valeur du champ date_affichage du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.date_depot_mairie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.date_depot_mairie IS 'Date de dépôt en mairie du dossier d''instruction';


--
-- Name: COLUMN instruction.pec_metier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.pec_metier IS 'Statut de la prise en compte métier de l''instruction, venant de l''événement et destiné au dossier d''instruction';


--
-- Name: COLUMN instruction.archive_pec_metier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_pec_metier IS 'Valeur du champ prise_en_compte du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.archive_a_qualifier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.archive_a_qualifier IS 'Valeur du champ a_qualifier du dossier d''instruction avant ajout de l''événement d''instruction';


--
-- Name: COLUMN instruction.id_parapheur_signature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.id_parapheur_signature IS 'Identifiant du parapheur lié à l''instruction';


--
-- Name: COLUMN instruction.statut_signature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.statut_signature IS 'Statut du parapheur';


--
-- Name: COLUMN instruction.historique_signature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.historique_signature IS 'Historique de traitement du parapheur';


--
-- Name: COLUMN instruction.commentaire_signature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.commentaire_signature IS 'Commentaire reçu du parapheur.';


--
-- Name: COLUMN instruction.commentaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.commentaire IS 'Commentaire permettant de justifier l''evenement.';


--
-- Name: COLUMN instruction.envoye_cl_platau; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.envoye_cl_platau IS 'L''envoi au contrôle de légalité a été fait par Plat''AU, une task ''envoi_CL'' existe déjà';


--
-- Name: COLUMN instruction.parapheur_lien_page_signature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction.parapheur_lien_page_signature IS 'Lien vers la page de signature du document lié à l''instruction';


--
-- Name: instruction_notification; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE instruction_notification (
    instruction_notification integer NOT NULL,
    instruction integer NOT NULL,
    automatique boolean DEFAULT false,
    emetteur character varying(255),
    date_envoi timestamp without time zone,
    destinataire character varying(255),
    date_premier_acces timestamp without time zone,
    statut character varying(20),
    commentaire character varying(255),
    courriel character varying(60)
);


--
-- Name: COLUMN instruction_notification.instruction_notification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.instruction_notification IS 'Identifiant unique de la notification.';


--
-- Name: COLUMN instruction_notification.instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.instruction IS 'Identifiant de l''instruction de la notification.';


--
-- Name: COLUMN instruction_notification.automatique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.automatique IS 'Indique si la notification est automatique ou manuelle.';


--
-- Name: COLUMN instruction_notification.emetteur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.emetteur IS 'Identifiant de l''utilisateur ayant déclenché l''envoi.';


--
-- Name: COLUMN instruction_notification.date_envoi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.date_envoi IS 'Date et heure d''envoi de la notification.';


--
-- Name: COLUMN instruction_notification.destinataire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.destinataire IS 'Courriel du destinataire.';


--
-- Name: COLUMN instruction_notification.date_premier_acces; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.date_premier_acces IS 'Date et heure du premier accès au document';


--
-- Name: COLUMN instruction_notification.statut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.statut IS 'Statut de la notification (envoyé, échec, vu)';


--
-- Name: COLUMN instruction_notification.commentaire; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.commentaire IS 'Détail du status';


--
-- Name: COLUMN instruction_notification.courriel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification.courriel IS 'Courriel du destinataire utilisé pour lui transmettre les informations';


--
-- Name: instruction_notification_document; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE instruction_notification_document (
    instruction_notification_document integer NOT NULL,
    instruction_notification integer NOT NULL,
    instruction integer NOT NULL,
    cle text,
    annexe boolean DEFAULT false,
    document_id integer,
    document_type character varying(100)
);


--
-- Name: COLUMN instruction_notification_document.instruction_notification_document; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification_document.instruction_notification_document IS 'Identifiant unique du document de la notification.';


--
-- Name: COLUMN instruction_notification_document.instruction_notification; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification_document.instruction_notification IS 'Identifiant de la notification.';


--
-- Name: COLUMN instruction_notification_document.instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification_document.instruction IS 'Identifiant de l''instruction.';


--
-- Name: COLUMN instruction_notification_document.cle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification_document.cle IS 'Clé unique d''accès au document.';


--
-- Name: COLUMN instruction_notification_document.annexe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification_document.annexe IS 'Indique si il s''agit d''une annexe ou du dosument principal.';


--
-- Name: COLUMN instruction_notification_document.document_id; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification_document.document_id IS 'Identifiant de l''élément auquel appartiens le document.';


--
-- Name: COLUMN instruction_notification_document.document_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN instruction_notification_document.document_type IS 'Nom de la table à laquelle est rattaché le document';


--
-- Name: instruction_notification_document_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE instruction_notification_document_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: instruction_notification_document_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE instruction_notification_document_seq OWNED BY instruction_notification_document.instruction_notification_document;


--
-- Name: instruction_notification_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE instruction_notification_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: instruction_notification_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE instruction_notification_seq OWNED BY instruction_notification.instruction_notification;


--
-- Name: instruction_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE instruction_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: instruction_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE instruction_seq OWNED BY instruction.instruction;


--
-- Name: lien_categorie_tiers_consulte_om_collectivite; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_categorie_tiers_consulte_om_collectivite (
    lien_categorie_tiers_consulte_om_collectivite integer NOT NULL,
    categorie_tiers_consulte integer NOT NULL,
    om_collectivite integer NOT NULL
);


--
-- Name: COLUMN lien_categorie_tiers_consulte_om_collectivite.lien_categorie_tiers_consulte_om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_categorie_tiers_consulte_om_collectivite.lien_categorie_tiers_consulte_om_collectivite IS 'Identifiant unique';


--
-- Name: COLUMN lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte IS 'Identifiant de la catégorie du tiers consulté';


--
-- Name: COLUMN lien_categorie_tiers_consulte_om_collectivite.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_categorie_tiers_consulte_om_collectivite.om_collectivite IS 'Identifiant de la collectivité';


--
-- Name: lien_categorie_tiers_consulte_om_collectivite_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_categorie_tiers_consulte_om_collectivite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_categorie_tiers_consulte_om_collectivite_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_categorie_tiers_consulte_om_collectivite_seq OWNED BY lien_categorie_tiers_consulte_om_collectivite.lien_categorie_tiers_consulte_om_collectivite;


--
-- Name: lien_demande_demandeur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_demande_demandeur (
    lien_demande_demandeur integer NOT NULL,
    petitionnaire_principal boolean,
    demande integer,
    demandeur integer
);


--
-- Name: TABLE lien_demande_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_demande_demandeur IS 'Liaison entre les demandeurs et les demandes';


--
-- Name: COLUMN lien_demande_demandeur.lien_demande_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_demandeur.lien_demande_demandeur IS 'Identifiant unique';


--
-- Name: COLUMN lien_demande_demandeur.petitionnaire_principal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_demandeur.petitionnaire_principal IS 'Le demandeur lié à la demande est le pétitionnaire principal';


--
-- Name: COLUMN lien_demande_demandeur.demande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_demandeur.demande IS 'Demande liée au demandeur';


--
-- Name: COLUMN lien_demande_demandeur.demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_demandeur.demandeur IS 'Demandeur de la demande';


--
-- Name: lien_demande_demandeur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_demande_demandeur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_demande_demandeur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_demande_demandeur_seq OWNED BY lien_demande_demandeur.lien_demande_demandeur;


--
-- Name: lien_demande_type_dossier_instruction_type; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_demande_type_dossier_instruction_type (
    lien_demande_type_dossier_instruction_type integer NOT NULL,
    demande_type integer,
    dossier_instruction_type integer
);


--
-- Name: TABLE lien_demande_type_dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_demande_type_dossier_instruction_type IS 'Table de liaison entre demande type et dossiers d''instruction type';


--
-- Name: COLUMN lien_demande_type_dossier_instruction_type.lien_demande_type_dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_type_dossier_instruction_type.lien_demande_type_dossier_instruction_type IS 'Identifiant unique';


--
-- Name: COLUMN lien_demande_type_dossier_instruction_type.demande_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_type_dossier_instruction_type.demande_type IS 'Fait le lien avec la demadne type';


--
-- Name: COLUMN lien_demande_type_dossier_instruction_type.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_type_dossier_instruction_type.dossier_instruction_type IS 'Fait le lien avec le type du dossier d''instruction';


--
-- Name: lien_demande_type_dossier_instruction_type_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_demande_type_dossier_instruction_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_demande_type_dossier_instruction_type_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_demande_type_dossier_instruction_type_seq OWNED BY lien_demande_type_dossier_instruction_type.lien_demande_type_dossier_instruction_type;


--
-- Name: lien_demande_type_etat; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_demande_type_etat (
    lien_demande_type_etat integer NOT NULL,
    demande_type integer NOT NULL,
    etat character varying(150) NOT NULL
);


--
-- Name: TABLE lien_demande_type_etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_demande_type_etat IS 'Liaison entre les types de demande et les états des dossiers d''instruction';


--
-- Name: COLUMN lien_demande_type_etat.lien_demande_type_etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_type_etat.lien_demande_type_etat IS 'Identifiant unique';


--
-- Name: COLUMN lien_demande_type_etat.demande_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_type_etat.demande_type IS 'Type de demande';


--
-- Name: COLUMN lien_demande_type_etat.etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_demande_type_etat.etat IS 'État du dernier dossier d''instruction';


--
-- Name: lien_demande_type_etat_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_demande_type_etat_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_demande_type_etat_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_demande_type_etat_seq OWNED BY lien_demande_type_etat.lien_demande_type_etat;


--
-- Name: lien_dit_nature_travaux; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_dit_nature_travaux (
    lien_dit_nature_travaux integer NOT NULL,
    dossier_instruction_type integer NOT NULL,
    nature_travaux integer NOT NULL
);


--
-- Name: TABLE lien_dit_nature_travaux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_dit_nature_travaux IS 'Nature de travaux associé à un type de dossier';


--
-- Name: COLUMN lien_dit_nature_travaux.lien_dit_nature_travaux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dit_nature_travaux.lien_dit_nature_travaux IS 'Identifiant unique';


--
-- Name: COLUMN lien_dit_nature_travaux.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dit_nature_travaux.dossier_instruction_type IS 'Identifiant du type de dossier d''instruction';


--
-- Name: COLUMN lien_dit_nature_travaux.nature_travaux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dit_nature_travaux.nature_travaux IS 'Identifiant de la nature de travaux';


--
-- Name: lien_dit_nature_travaux_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_dit_nature_travaux_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_dit_nature_travaux_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_dit_nature_travaux_seq OWNED BY lien_dit_nature_travaux.lien_dit_nature_travaux;


--
-- Name: lien_document_n_type_d_i_t; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_document_n_type_d_i_t (
    lien_document_n_type_d_i_t integer NOT NULL,
    document_numerise_type integer NOT NULL,
    dossier_instruction_type integer NOT NULL,
    code character varying(10) NOT NULL,
    CONSTRAINT lien_document_n_type_d_i_t__code__check CHECK (((char_length((code)::text) - char_length(replace((code)::text, '-'::text, ''::text))) < 3))
);


--
-- Name: COLUMN lien_document_n_type_d_i_t.lien_document_n_type_d_i_t; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_document_n_type_d_i_t.lien_document_n_type_d_i_t IS 'Identifiant de la reference du document numerise pour le type de dossier d''instruction';


--
-- Name: COLUMN lien_document_n_type_d_i_t.document_numerise_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_document_n_type_d_i_t.document_numerise_type IS 'Identifiant du type de document numerisé';


--
-- Name: COLUMN lien_document_n_type_d_i_t.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_document_n_type_d_i_t.dossier_instruction_type IS 'Identifiant du type de dossier d''instruction';


--
-- Name: COLUMN lien_document_n_type_d_i_t.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_document_n_type_d_i_t.code IS 'Code de la pièce';


--
-- Name: lien_document_n_type_d_i_t_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_document_n_type_d_i_t_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_document_n_type_d_i_t_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_document_n_type_d_i_t_seq OWNED BY lien_document_n_type_d_i_t.lien_document_n_type_d_i_t;


--
-- Name: lien_document_numerise_type_instructeur_qualite; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_document_numerise_type_instructeur_qualite (
    lien_document_numerise_type_instructeur_qualite integer NOT NULL,
    document_numerise_type integer NOT NULL,
    instructeur_qualite integer NOT NULL
);


--
-- Name: TABLE lien_document_numerise_type_instructeur_qualite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_document_numerise_type_instructeur_qualite IS 'Table de liaison entre les types de pièce et les qualités d''instructeur';


--
-- Name: COLUMN lien_document_numerise_type_instructeur_qualite.lien_document_numerise_type_instructeur_qualite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_document_numerise_type_instructeur_qualite.lien_document_numerise_type_instructeur_qualite IS 'Identifiant unique';


--
-- Name: COLUMN lien_document_numerise_type_instructeur_qualite.document_numerise_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_document_numerise_type_instructeur_qualite.document_numerise_type IS 'Identifiant des types de pièce';


--
-- Name: COLUMN lien_document_numerise_type_instructeur_qualite.instructeur_qualite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_document_numerise_type_instructeur_qualite.instructeur_qualite IS 'Indentifiant de la qualité des instructeurs';


--
-- Name: lien_document_numerise_type_instructeur_qualite_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_document_numerise_type_instructeur_qualite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_document_numerise_type_instructeur_qualite_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_document_numerise_type_instructeur_qualite_seq OWNED BY lien_document_numerise_type_instructeur_qualite.lien_document_numerise_type_instructeur_qualite;


--
-- Name: lien_donnees_techniques_moyen_retenu_juge; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_donnees_techniques_moyen_retenu_juge (
    lien_donnees_techniques_moyen_retenu_juge integer NOT NULL,
    donnees_techniques integer NOT NULL,
    moyen_retenu_juge integer NOT NULL
);


--
-- Name: TABLE lien_donnees_techniques_moyen_retenu_juge; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_donnees_techniques_moyen_retenu_juge IS 'Table de liaison entre les données techniques et les moyens retenus par le juge';


--
-- Name: COLUMN lien_donnees_techniques_moyen_retenu_juge.lien_donnees_techniques_moyen_retenu_juge; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_donnees_techniques_moyen_retenu_juge.lien_donnees_techniques_moyen_retenu_juge IS 'Identifiant unique';


--
-- Name: COLUMN lien_donnees_techniques_moyen_retenu_juge.donnees_techniques; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_donnees_techniques_moyen_retenu_juge.donnees_techniques IS 'Identifiant des données techniques';


--
-- Name: COLUMN lien_donnees_techniques_moyen_retenu_juge.moyen_retenu_juge; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_donnees_techniques_moyen_retenu_juge.moyen_retenu_juge IS 'Indentifiant du moyen retenu par le juge';


--
-- Name: lien_donnees_techniques_moyen_retenu_juge_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_donnees_techniques_moyen_retenu_juge_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_donnees_techniques_moyen_retenu_juge_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_donnees_techniques_moyen_retenu_juge_seq OWNED BY lien_donnees_techniques_moyen_retenu_juge.lien_donnees_techniques_moyen_retenu_juge;


--
-- Name: lien_donnees_techniques_moyen_souleve; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_donnees_techniques_moyen_souleve (
    lien_donnees_techniques_moyen_souleve integer NOT NULL,
    donnees_techniques integer NOT NULL,
    moyen_souleve integer NOT NULL
);


--
-- Name: TABLE lien_donnees_techniques_moyen_souleve; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_donnees_techniques_moyen_souleve IS 'Table de liaison entre les données techniques et les moyens soulevés';


--
-- Name: COLUMN lien_donnees_techniques_moyen_souleve.lien_donnees_techniques_moyen_souleve; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_donnees_techniques_moyen_souleve.lien_donnees_techniques_moyen_souleve IS 'Identifiant unique';


--
-- Name: COLUMN lien_donnees_techniques_moyen_souleve.donnees_techniques; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_donnees_techniques_moyen_souleve.donnees_techniques IS 'Identifiant des données techniques';


--
-- Name: COLUMN lien_donnees_techniques_moyen_souleve.moyen_souleve; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_donnees_techniques_moyen_souleve.moyen_souleve IS 'Indentifiant du moyen soulevé';


--
-- Name: lien_donnees_techniques_moyen_souleve_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_donnees_techniques_moyen_souleve_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_donnees_techniques_moyen_souleve_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_donnees_techniques_moyen_souleve_seq OWNED BY lien_donnees_techniques_moyen_souleve.lien_donnees_techniques_moyen_souleve;


--
-- Name: lien_dossier_autorisation_demandeur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_dossier_autorisation_demandeur (
    lien_dossier_autorisation_demandeur integer NOT NULL,
    petitionnaire_principal boolean,
    dossier_autorisation character varying(255),
    demandeur integer
);


--
-- Name: TABLE lien_dossier_autorisation_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_dossier_autorisation_demandeur IS 'Liaison entre les demandeurs et les dossiers d''autorisation';


--
-- Name: COLUMN lien_dossier_autorisation_demandeur.lien_dossier_autorisation_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_autorisation_demandeur.lien_dossier_autorisation_demandeur IS 'Identifiant unique';


--
-- Name: COLUMN lien_dossier_autorisation_demandeur.petitionnaire_principal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_autorisation_demandeur.petitionnaire_principal IS 'Le demandeur lié au dossier d''autorisation est le pétitionnaire principal';


--
-- Name: COLUMN lien_dossier_autorisation_demandeur.dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_autorisation_demandeur.dossier_autorisation IS 'Dossier d''autorisation lié au demandeur';


--
-- Name: COLUMN lien_dossier_autorisation_demandeur.demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_autorisation_demandeur.demandeur IS 'Demandeur lié au dossier d''autorisation';


--
-- Name: lien_dossier_autorisation_demandeur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_dossier_autorisation_demandeur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_dossier_autorisation_demandeur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_dossier_autorisation_demandeur_seq OWNED BY lien_dossier_autorisation_demandeur.lien_dossier_autorisation_demandeur;


--
-- Name: lien_dossier_demandeur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_dossier_demandeur (
    lien_dossier_demandeur integer NOT NULL,
    petitionnaire_principal boolean,
    dossier character varying(255),
    demandeur integer
);


--
-- Name: TABLE lien_dossier_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_dossier_demandeur IS 'Liaison entre les demandeurs et les dossiers d''instruction';


--
-- Name: COLUMN lien_dossier_demandeur.lien_dossier_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_demandeur.lien_dossier_demandeur IS 'Identifiant unique';


--
-- Name: COLUMN lien_dossier_demandeur.petitionnaire_principal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_demandeur.petitionnaire_principal IS 'Le demandeur lié au dossier d''instruction est le pétitionnaire principal';


--
-- Name: COLUMN lien_dossier_demandeur.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_demandeur.dossier IS 'Dossier d''instruction lié au demandeur';


--
-- Name: COLUMN lien_dossier_demandeur.demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_demandeur.demandeur IS 'Demandeur lié au dossier d''instruction';


--
-- Name: lien_dossier_demandeur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_dossier_demandeur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_dossier_demandeur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_dossier_demandeur_seq OWNED BY lien_dossier_demandeur.lien_dossier_demandeur;


--
-- Name: lien_dossier_dossier; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_dossier_dossier (
    lien_dossier_dossier integer NOT NULL,
    dossier_src character varying(255) NOT NULL,
    dossier_cible character varying(255) NOT NULL,
    type_lien lien_dossier_dossier_type_lien NOT NULL
);


--
-- Name: TABLE lien_dossier_dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_dossier_dossier IS 'Table de liaison entre les dossiers d''instruction';


--
-- Name: COLUMN lien_dossier_dossier.lien_dossier_dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_dossier.lien_dossier_dossier IS 'Identifiant unique';


--
-- Name: COLUMN lien_dossier_dossier.dossier_src; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_dossier.dossier_src IS 'Dossier d''instruction source de la liaison, c''est sur celui-ci que les dossiers d''instruction cibles seront affichés';


--
-- Name: COLUMN lien_dossier_dossier.dossier_cible; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_dossier.dossier_cible IS 'Dossier d''instruction cible de la liaison, les dossiers d''instruction cibles n''ont pas les DI source sur leur tableau de laison';


--
-- Name: COLUMN lien_dossier_dossier.type_lien; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_dossier.type_lien IS 'Statique : manuel / auto_recours';


--
-- Name: lien_dossier_dossier_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_dossier_dossier_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_dossier_dossier_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_dossier_dossier_seq OWNED BY lien_dossier_dossier.lien_dossier_dossier;


--
-- Name: lien_dossier_instruction_type_categorie_tiers; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_dossier_instruction_type_categorie_tiers (
    lien_dossier_instruction_type_categorie_tiers integer NOT NULL,
    dossier_instruction_type integer NOT NULL,
    categorie_tiers integer NOT NULL,
    ajout_automatique boolean DEFAULT false
);


--
-- Name: TABLE lien_dossier_instruction_type_categorie_tiers; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_dossier_instruction_type_categorie_tiers IS 'Catégorie de tiers associé à un type de dossier';


--
-- Name: COLUMN lien_dossier_instruction_type_categorie_tiers.lien_dossier_instruction_type_categorie_tiers; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_instruction_type_categorie_tiers.lien_dossier_instruction_type_categorie_tiers IS 'Identifiant unique';


--
-- Name: COLUMN lien_dossier_instruction_type_categorie_tiers.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_instruction_type_categorie_tiers.dossier_instruction_type IS 'Identifiant du type de dossier d''instruction';


--
-- Name: COLUMN lien_dossier_instruction_type_categorie_tiers.categorie_tiers; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_instruction_type_categorie_tiers.categorie_tiers IS 'Identifiant de la catégorie de tiers';


--
-- Name: COLUMN lien_dossier_instruction_type_categorie_tiers.ajout_automatique; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_instruction_type_categorie_tiers.ajout_automatique IS 'Indique si les tiers de cette catégorie doivent automatiquement être liés au dossier de ce type lors de sa création.';


--
-- Name: lien_dossier_instruction_type_categorie_tiers_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_dossier_instruction_type_categorie_tiers_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_dossier_instruction_type_categorie_tiers_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_dossier_instruction_type_categorie_tiers_seq OWNED BY lien_dossier_instruction_type_categorie_tiers.lien_dossier_instruction_type_categorie_tiers;


--
-- Name: lien_dossier_instruction_type_evenement; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_dossier_instruction_type_evenement (
    lien_dossier_instruction_type_evenement integer NOT NULL,
    dossier_instruction_type integer,
    evenement integer
);


--
-- Name: TABLE lien_dossier_instruction_type_evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_dossier_instruction_type_evenement IS 'Liaison entre les types de dossier d''instruction et les événements';


--
-- Name: COLUMN lien_dossier_instruction_type_evenement.lien_dossier_instruction_type_evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_instruction_type_evenement.lien_dossier_instruction_type_evenement IS 'Identifiant unique';


--
-- Name: COLUMN lien_dossier_instruction_type_evenement.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_instruction_type_evenement.dossier_instruction_type IS 'Type du dossier d''instruction lié à l''événement';


--
-- Name: COLUMN lien_dossier_instruction_type_evenement.evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_instruction_type_evenement.evenement IS 'Événement lié au dossier d''instruction';


--
-- Name: lien_dossier_instruction_type_evenement_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_dossier_instruction_type_evenement_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_dossier_instruction_type_evenement_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_dossier_instruction_type_evenement_seq OWNED BY lien_dossier_instruction_type_evenement.lien_dossier_instruction_type_evenement;


--
-- Name: lien_dossier_nature_travaux; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_dossier_nature_travaux (
    lien_dossier_nature_travaux integer NOT NULL,
    dossier character varying(255) NOT NULL,
    nature_travaux integer NOT NULL
);


--
-- Name: TABLE lien_dossier_nature_travaux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_dossier_nature_travaux IS 'Nature de travaux associé à un dossier';


--
-- Name: COLUMN lien_dossier_nature_travaux.lien_dossier_nature_travaux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_nature_travaux.lien_dossier_nature_travaux IS 'Identifiant unique';


--
-- Name: COLUMN lien_dossier_nature_travaux.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_nature_travaux.dossier IS 'Identifiant du dossier d''instruction';


--
-- Name: COLUMN lien_dossier_nature_travaux.nature_travaux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_nature_travaux.nature_travaux IS 'Identifiant de la nature de travaux';


--
-- Name: lien_dossier_nature_travaux_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_dossier_nature_travaux_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_dossier_nature_travaux_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_dossier_nature_travaux_seq OWNED BY lien_dossier_nature_travaux.lien_dossier_nature_travaux;


--
-- Name: lien_dossier_tiers; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_dossier_tiers (
    lien_dossier_tiers integer NOT NULL,
    dossier character varying(255) NOT NULL,
    tiers integer NOT NULL
);


--
-- Name: TABLE lien_dossier_tiers; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_dossier_tiers IS 'Acteur du dossier.';


--
-- Name: COLUMN lien_dossier_tiers.lien_dossier_tiers; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_tiers.lien_dossier_tiers IS 'Identifiant unique';


--
-- Name: COLUMN lien_dossier_tiers.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_tiers.dossier IS 'Identifiant du dossier';


--
-- Name: COLUMN lien_dossier_tiers.tiers; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_dossier_tiers.tiers IS 'Identifiant du tiers';


--
-- Name: lien_dossier_tiers_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_dossier_tiers_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_dossier_tiers_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_dossier_tiers_seq OWNED BY lien_dossier_tiers.lien_dossier_tiers;


--
-- Name: lien_habilitation_tiers_consulte_commune; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_habilitation_tiers_consulte_commune (
    lien_habilitation_tiers_consulte_commune integer NOT NULL,
    habilitation_tiers_consulte integer NOT NULL,
    commune integer NOT NULL
);


--
-- Name: COLUMN lien_habilitation_tiers_consulte_commune.lien_habilitation_tiers_consulte_commune; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_commune.lien_habilitation_tiers_consulte_commune IS 'Identifiant unique';


--
-- Name: COLUMN lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte IS 'Identifiant de l''habilitation du tiers consulté';


--
-- Name: COLUMN lien_habilitation_tiers_consulte_commune.commune; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_commune.commune IS 'Identifiant de la commune';


--
-- Name: lien_habilitation_tiers_consulte_commune_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_habilitation_tiers_consulte_commune_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_habilitation_tiers_consulte_commune_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_habilitation_tiers_consulte_commune_seq OWNED BY lien_habilitation_tiers_consulte_commune.lien_habilitation_tiers_consulte_commune;


--
-- Name: lien_habilitation_tiers_consulte_departement; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_habilitation_tiers_consulte_departement (
    lien_habilitation_tiers_consulte_departement integer NOT NULL,
    habilitation_tiers_consulte integer NOT NULL,
    departement integer NOT NULL
);


--
-- Name: COLUMN lien_habilitation_tiers_consulte_departement.lien_habilitation_tiers_consulte_departement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_departement.lien_habilitation_tiers_consulte_departement IS 'Identifiant unique';


--
-- Name: COLUMN lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte IS 'Identifiant de l''habilitation du tiers consulté';


--
-- Name: COLUMN lien_habilitation_tiers_consulte_departement.departement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_departement.departement IS 'Identifiant de la departement';


--
-- Name: lien_habilitation_tiers_consulte_departement_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_habilitation_tiers_consulte_departement_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_habilitation_tiers_consulte_departement_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_habilitation_tiers_consulte_departement_seq OWNED BY lien_habilitation_tiers_consulte_departement.lien_habilitation_tiers_consulte_departement;


--
-- Name: lien_habilitation_tiers_consulte_specialite_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_habilitation_tiers_consulte_specialite_tiers_consulte (
    lien_habilitation_tiers_consulte_specialite_tiers_consulte integer NOT NULL,
    habilitation_tiers_consulte integer NOT NULL,
    specialite_tiers_consulte integer NOT NULL
);


--
-- Name: COLUMN lien_habilitation_tiers_consulte_specialite_tiers_consulte.lien_habilitation_tiers_consulte_specialite_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_specialite_tiers_consulte.lien_habilitation_tiers_consulte_specialite_tiers_consulte IS 'Identifiant unique';


--
-- Name: COLUMN lien_habilitation_tiers_consulte_specialite_tiers_consulte.habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_specialite_tiers_consulte.habilitation_tiers_consulte IS 'Identifiant de l''utilisateur';


--
-- Name: COLUMN lien_habilitation_tiers_consulte_specialite_tiers_consulte.specialite_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_habilitation_tiers_consulte_specialite_tiers_consulte.specialite_tiers_consulte IS 'Identifiant du tiers consulté';


--
-- Name: lien_habilitation_tiers_consulte_specialite_tiers_consulte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_habilitation_tiers_consulte_specialite_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_habilitation_tiers_consulte_specialite_tiers_consulte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_habilitation_tiers_consulte_specialite_tiers_consulte_seq OWNED BY lien_habilitation_tiers_consulte_specialite_tiers_consulte.lien_habilitation_tiers_consulte_specialite_tiers_consulte;


--
-- Name: lien_id_interne_uid_externe; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_id_interne_uid_externe (
    lien_id_interne_uid_externe integer NOT NULL,
    object character varying(30) NOT NULL,
    object_id character varying(30) NOT NULL,
    external_uid character varying(255) NOT NULL,
    dossier character varying(255),
    category character varying(2000)
);


--
-- Name: TABLE lien_id_interne_uid_externe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_id_interne_uid_externe IS 'Table de liaison entre un objet interne et un objet externe à l''aplication';


--
-- Name: COLUMN lien_id_interne_uid_externe.lien_id_interne_uid_externe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_id_interne_uid_externe.lien_id_interne_uid_externe IS 'Identifiant numérique unique de la liaison';


--
-- Name: COLUMN lien_id_interne_uid_externe.object; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_id_interne_uid_externe.object IS 'Objet interne visé par la liaison';


--
-- Name: COLUMN lien_id_interne_uid_externe.object_id; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_id_interne_uid_externe.object_id IS 'Identifiant unique de l''objet métier interne';


--
-- Name: COLUMN lien_id_interne_uid_externe.external_uid; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_id_interne_uid_externe.external_uid IS 'Identifiant unique de l''objet externe';


--
-- Name: COLUMN lien_id_interne_uid_externe.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_id_interne_uid_externe.dossier IS 'Numéro de dossier lié à l''objet';


--
-- Name: COLUMN lien_id_interne_uid_externe.category; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_id_interne_uid_externe.category IS 'Catégorie de la liaison (récupérée de la task)';


--
-- Name: lien_id_interne_uid_externe_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_id_interne_uid_externe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_id_interne_uid_externe_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_id_interne_uid_externe_seq OWNED BY lien_id_interne_uid_externe.lien_id_interne_uid_externe;


--
-- Name: lien_lot_demandeur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_lot_demandeur (
    lien_lot_demandeur integer NOT NULL,
    lot integer,
    demandeur integer,
    petitionnaire_principal boolean
);


--
-- Name: TABLE lien_lot_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_lot_demandeur IS 'Liaison entre les demandeurs et les lots';


--
-- Name: COLUMN lien_lot_demandeur.lien_lot_demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_lot_demandeur.lien_lot_demandeur IS 'Identifiant unique';


--
-- Name: COLUMN lien_lot_demandeur.lot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_lot_demandeur.lot IS 'Identifiant du lot';


--
-- Name: COLUMN lien_lot_demandeur.demandeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_lot_demandeur.demandeur IS 'Demandeur lié au dossier d''instruction';


--
-- Name: COLUMN lien_lot_demandeur.petitionnaire_principal; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_lot_demandeur.petitionnaire_principal IS 'Le demandeur lié au dossier d''instruction est le pétitionnaire principal';


--
-- Name: lien_lot_demandeur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_lot_demandeur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_lot_demandeur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_lot_demandeur_seq OWNED BY lien_lot_demandeur.lien_lot_demandeur;


--
-- Name: lien_motif_consultation_om_collectivite; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_motif_consultation_om_collectivite (
    lien_motif_consultation_om_collectivite integer NOT NULL,
    motif_consultation integer NOT NULL,
    om_collectivite integer NOT NULL
);


--
-- Name: COLUMN lien_motif_consultation_om_collectivite.lien_motif_consultation_om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_motif_consultation_om_collectivite.lien_motif_consultation_om_collectivite IS 'Identifiant unique';


--
-- Name: COLUMN lien_motif_consultation_om_collectivite.motif_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_motif_consultation_om_collectivite.motif_consultation IS 'Identifiant du motif de consultation';


--
-- Name: COLUMN lien_motif_consultation_om_collectivite.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_motif_consultation_om_collectivite.om_collectivite IS 'Identifiant de la collectivité';


--
-- Name: lien_motif_consultation_om_collectivite_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_motif_consultation_om_collectivite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_motif_consultation_om_collectivite_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_motif_consultation_om_collectivite_seq OWNED BY lien_motif_consultation_om_collectivite.lien_motif_consultation_om_collectivite;


--
-- Name: lien_om_profil_groupe; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_om_profil_groupe (
    lien_om_profil_groupe integer NOT NULL,
    om_profil integer NOT NULL,
    groupe integer NOT NULL,
    confidentiel boolean DEFAULT false,
    enregistrement_demande boolean DEFAULT false
);


--
-- Name: TABLE lien_om_profil_groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_om_profil_groupe IS 'Table de liaison entre les profils et les groupes';


--
-- Name: COLUMN lien_om_profil_groupe.lien_om_profil_groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_profil_groupe.lien_om_profil_groupe IS 'Identifiant unique';


--
-- Name: COLUMN lien_om_profil_groupe.om_profil; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_profil_groupe.om_profil IS 'Identifiant du profil';


--
-- Name: COLUMN lien_om_profil_groupe.groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_profil_groupe.groupe IS 'Indentifiant du groupe';


--
-- Name: COLUMN lien_om_profil_groupe.confidentiel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_profil_groupe.confidentiel IS 'Visualisation des dossiers du groupe';


--
-- Name: COLUMN lien_om_profil_groupe.enregistrement_demande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_profil_groupe.enregistrement_demande IS 'Ajout ou non de dossier pour ce groupe';


--
-- Name: lien_om_profil_groupe_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_om_profil_groupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_om_profil_groupe_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_om_profil_groupe_seq OWNED BY lien_om_profil_groupe.lien_om_profil_groupe;


--
-- Name: lien_om_utilisateur_groupe; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_om_utilisateur_groupe (
    lien_om_utilisateur_groupe integer NOT NULL,
    login character varying(30) NOT NULL,
    groupe integer NOT NULL,
    confidentiel boolean DEFAULT false,
    enregistrement_demande boolean DEFAULT false
);


--
-- Name: TABLE lien_om_utilisateur_groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_om_utilisateur_groupe IS 'Table de liaison entre les utilisateurs et les groupes';


--
-- Name: COLUMN lien_om_utilisateur_groupe.lien_om_utilisateur_groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_utilisateur_groupe.lien_om_utilisateur_groupe IS 'Identifiant unique';


--
-- Name: COLUMN lien_om_utilisateur_groupe.login; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_utilisateur_groupe.login IS 'Identifiant de l''utilisateur';


--
-- Name: COLUMN lien_om_utilisateur_groupe.groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_utilisateur_groupe.groupe IS 'Indentifiant du groupe';


--
-- Name: COLUMN lien_om_utilisateur_groupe.confidentiel; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_utilisateur_groupe.confidentiel IS 'Visualisation des dossiers du groupe';


--
-- Name: COLUMN lien_om_utilisateur_groupe.enregistrement_demande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_utilisateur_groupe.enregistrement_demande IS 'Ajout ou non de dossier pour ce groupe';


--
-- Name: lien_om_utilisateur_groupe_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_om_utilisateur_groupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_om_utilisateur_groupe_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_om_utilisateur_groupe_seq OWNED BY lien_om_utilisateur_groupe.lien_om_utilisateur_groupe;


--
-- Name: lien_om_utilisateur_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_om_utilisateur_tiers_consulte (
    lien_om_utilisateur_tiers_consulte integer NOT NULL,
    om_utilisateur integer NOT NULL,
    tiers_consulte integer NOT NULL
);


--
-- Name: COLUMN lien_om_utilisateur_tiers_consulte.lien_om_utilisateur_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_utilisateur_tiers_consulte.lien_om_utilisateur_tiers_consulte IS 'Identifiant unique';


--
-- Name: COLUMN lien_om_utilisateur_tiers_consulte.om_utilisateur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_utilisateur_tiers_consulte.om_utilisateur IS 'Identifiant de l''utilisateur';


--
-- Name: COLUMN lien_om_utilisateur_tiers_consulte.tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_om_utilisateur_tiers_consulte.tiers_consulte IS 'Identifiant du tiers consulté';


--
-- Name: lien_om_utilisateur_tiers_consulte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_om_utilisateur_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_om_utilisateur_tiers_consulte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_om_utilisateur_tiers_consulte_seq OWNED BY lien_om_utilisateur_tiers_consulte.lien_om_utilisateur_tiers_consulte;


--
-- Name: lien_service_om_utilisateur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_service_om_utilisateur (
    lien_service_om_utilisateur integer NOT NULL,
    om_utilisateur bigint,
    service integer
);


--
-- Name: TABLE lien_service_om_utilisateur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_service_om_utilisateur IS 'Affectation de services aux utilisateurs';


--
-- Name: COLUMN lien_service_om_utilisateur.lien_service_om_utilisateur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_service_om_utilisateur.lien_service_om_utilisateur IS 'Identifiant unique';


--
-- Name: COLUMN lien_service_om_utilisateur.om_utilisateur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_service_om_utilisateur.om_utilisateur IS 'Identifiant de l''utilisateur';


--
-- Name: COLUMN lien_service_om_utilisateur.service; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_service_om_utilisateur.service IS 'Identifiant du service';


--
-- Name: lien_service_om_utilisateur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_service_om_utilisateur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_service_om_utilisateur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_service_om_utilisateur_seq OWNED BY lien_service_om_utilisateur.lien_service_om_utilisateur;


--
-- Name: lien_service_service_categorie; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_service_service_categorie (
    lien_service_service_categorie integer NOT NULL,
    service_categorie integer,
    service integer
);


--
-- Name: TABLE lien_service_service_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_service_service_categorie IS 'Affectation de services aux utilisateurs';


--
-- Name: COLUMN lien_service_service_categorie.lien_service_service_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_service_service_categorie.lien_service_service_categorie IS 'Identifiant unique';


--
-- Name: COLUMN lien_service_service_categorie.service_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_service_service_categorie.service_categorie IS 'Identifiant de catégorie de service';


--
-- Name: COLUMN lien_service_service_categorie.service; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_service_service_categorie.service IS 'Identifiant du service';


--
-- Name: lien_service_service_categorie_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_service_service_categorie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_service_service_categorie_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_service_service_categorie_seq OWNED BY lien_service_service_categorie.lien_service_service_categorie;


--
-- Name: lien_sig_contrainte_dossier_instruction_type; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_sig_contrainte_dossier_instruction_type (
    lien_sig_contrainte_dossier_instruction_type integer NOT NULL,
    sig_contrainte integer NOT NULL,
    dossier_instruction_type integer NOT NULL
);


--
-- Name: COLUMN lien_sig_contrainte_dossier_instruction_type.lien_sig_contrainte_dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_dossier_instruction_type.lien_sig_contrainte_dossier_instruction_type IS 'Identifiant unique interne.';


--
-- Name: COLUMN lien_sig_contrainte_dossier_instruction_type.sig_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_dossier_instruction_type.sig_contrainte IS 'Lien vers la contrainte SIG.';


--
-- Name: COLUMN lien_sig_contrainte_dossier_instruction_type.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_dossier_instruction_type.dossier_instruction_type IS 'Type de dossier d''instruction pour lequel la contrainte est applicable en détection cartographique.';


--
-- Name: lien_sig_contrainte_dossier_instruction_type_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_sig_contrainte_dossier_instruction_type_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_sig_contrainte_dossier_instruction_type_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_sig_contrainte_dossier_instruction_type_seq OWNED BY lien_sig_contrainte_dossier_instruction_type.lien_sig_contrainte_dossier_instruction_type;


--
-- Name: lien_sig_contrainte_evenement; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_sig_contrainte_evenement (
    lien_sig_contrainte_evenement integer NOT NULL,
    sig_contrainte integer NOT NULL,
    evenement integer NOT NULL
);


--
-- Name: TABLE lien_sig_contrainte_evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lien_sig_contrainte_evenement IS 'Évènements suggérés associés aux contraintes.';


--
-- Name: COLUMN lien_sig_contrainte_evenement.lien_sig_contrainte_evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_evenement.lien_sig_contrainte_evenement IS 'Identifiant unique de l''évènement suggéré.';


--
-- Name: COLUMN lien_sig_contrainte_evenement.sig_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_evenement.sig_contrainte IS 'Identifiant de la contrainte.';


--
-- Name: COLUMN lien_sig_contrainte_evenement.evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_evenement.evenement IS 'Identifiant de l''évènement';


--
-- Name: lien_sig_contrainte_evenement_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_sig_contrainte_evenement_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_sig_contrainte_evenement_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_sig_contrainte_evenement_seq OWNED BY lien_sig_contrainte_evenement.lien_sig_contrainte_evenement;


--
-- Name: lien_sig_contrainte_om_collectivite; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_sig_contrainte_om_collectivite (
    lien_sig_contrainte_om_collectivite integer NOT NULL,
    sig_contrainte integer NOT NULL,
    om_collectivite integer NOT NULL
);


--
-- Name: COLUMN lien_sig_contrainte_om_collectivite.lien_sig_contrainte_om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_om_collectivite.lien_sig_contrainte_om_collectivite IS 'Identifiant unique interne.';


--
-- Name: COLUMN lien_sig_contrainte_om_collectivite.sig_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_om_collectivite.sig_contrainte IS 'Lien vers la contrainte SIG.';


--
-- Name: COLUMN lien_sig_contrainte_om_collectivite.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_om_collectivite.om_collectivite IS 'Lien vers la collectivité ou le service.';


--
-- Name: lien_sig_contrainte_om_collectivite_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_sig_contrainte_om_collectivite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_sig_contrainte_om_collectivite_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_sig_contrainte_om_collectivite_seq OWNED BY lien_sig_contrainte_om_collectivite.lien_sig_contrainte_om_collectivite;


--
-- Name: lien_sig_contrainte_sig_attribut; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_sig_contrainte_sig_attribut (
    lien_sig_contrainte_sig_attribut integer NOT NULL,
    sig_contrainte integer NOT NULL,
    sig_attribut integer NOT NULL,
    valeur character varying(250) NOT NULL
);


--
-- Name: COLUMN lien_sig_contrainte_sig_attribut.lien_sig_contrainte_sig_attribut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_sig_attribut.lien_sig_contrainte_sig_attribut IS 'Identifiant unique interne.';


--
-- Name: COLUMN lien_sig_contrainte_sig_attribut.sig_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_sig_attribut.sig_contrainte IS 'Lien vers la contrainte SIG.';


--
-- Name: COLUMN lien_sig_contrainte_sig_attribut.sig_attribut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_sig_attribut.sig_attribut IS 'Lien vers l''attribut SIG.';


--
-- Name: COLUMN lien_sig_contrainte_sig_attribut.valeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_sig_contrainte_sig_attribut.valeur IS 'Valeur permettant l''application de la contrainte.';


--
-- Name: lien_sig_contrainte_sig_attribut_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_sig_contrainte_sig_attribut_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_sig_contrainte_sig_attribut_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_sig_contrainte_sig_attribut_seq OWNED BY lien_sig_contrainte_sig_attribut.lien_sig_contrainte_sig_attribut;


--
-- Name: lien_type_di_type_di; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lien_type_di_type_di (
    lien_type_di_type_di integer NOT NULL,
    type_di_parent integer NOT NULL,
    dossier_instruction_type integer NOT NULL
);


--
-- Name: COLUMN lien_type_di_type_di.lien_type_di_type_di; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_type_di_type_di.lien_type_di_type_di IS 'Identifiant de la liaison entre un type de DI et un type de sous dossier';


--
-- Name: COLUMN lien_type_di_type_di.type_di_parent; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_type_di_type_di.type_di_parent IS 'Identifiant du type de DI du dossier parent.';


--
-- Name: COLUMN lien_type_di_type_di.dossier_instruction_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lien_type_di_type_di.dossier_instruction_type IS 'Identifiant du type de DI du sous dossier.';


--
-- Name: lien_type_di_type_di_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lien_type_di_type_di_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lien_type_di_type_di_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lien_type_di_type_di_seq OWNED BY lien_type_di_type_di.lien_type_di_type_di;


--
-- Name: lot; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE lot (
    lot integer NOT NULL,
    libelle character varying(250) NOT NULL,
    dossier_autorisation character varying(255),
    dossier character varying(255)
);


--
-- Name: TABLE lot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE lot IS 'Lots de chaque dossier';


--
-- Name: COLUMN lot.lot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lot.lot IS 'Identifiant unique';


--
-- Name: COLUMN lot.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lot.libelle IS 'Libellé du lot';


--
-- Name: COLUMN lot.dossier_autorisation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lot.dossier_autorisation IS 'Identifiant du dossier d''autorisation lié au lot';


--
-- Name: COLUMN lot.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN lot.dossier IS 'Identifiant du dossier d''instruction lié au lot';


--
-- Name: lot_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE lot_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: lot_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE lot_seq OWNED BY lot.lot;


--
-- Name: motif_consultation; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE motif_consultation (
    motif_consultation integer NOT NULL,
    code character varying(50),
    description text,
    libelle character varying(255),
    notification_email boolean DEFAULT false,
    delai_type character varying(100) DEFAULT 'mois'::character varying,
    delai integer,
    consultation_papier boolean DEFAULT false,
    om_validite_debut date,
    om_validite_fin date,
    type_consultation character varying(70) DEFAULT 'avec_avis_attendu'::character varying,
    om_etat integer,
    service_type character varying(255) NOT NULL,
    generate_edition boolean DEFAULT false
);


--
-- Name: COLUMN motif_consultation.motif_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.motif_consultation IS 'Identifiant unique';


--
-- Name: COLUMN motif_consultation.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.code IS 'Code du motif de consultation';


--
-- Name: COLUMN motif_consultation.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.description IS 'Description du motif consulté';


--
-- Name: COLUMN motif_consultation.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.libelle IS 'Libellé du motif de consultation';


--
-- Name: COLUMN motif_consultation.notification_email; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.notification_email IS 'La consultation nécessite l''envoi d''un email';


--
-- Name: COLUMN motif_consultation.delai_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.delai_type IS 'Type de délai (mois ou jour)';


--
-- Name: COLUMN motif_consultation.delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.delai IS 'Delai de consultation au service';


--
-- Name: COLUMN motif_consultation.consultation_papier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.consultation_papier IS 'La consultation nécessite l''envoi d''un courrier';


--
-- Name: COLUMN motif_consultation.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.om_validite_debut IS 'Date de début de validité du motif de consultation';


--
-- Name: COLUMN motif_consultation.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.om_validite_fin IS 'Date de fin de validité du motif de consultation';


--
-- Name: COLUMN motif_consultation.type_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.type_consultation IS 'Type de consultation (pour conformité, avis attendu, pour information)';


--
-- Name: COLUMN motif_consultation.om_etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.om_etat IS 'Edition du motif de consultation';


--
-- Name: COLUMN motif_consultation.service_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.service_type IS 'Type du service';


--
-- Name: COLUMN motif_consultation.generate_edition; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN motif_consultation.generate_edition IS 'Générer l''édition liée au service consulté (true) ou non (false)';


--
-- Name: motif_consultation_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE motif_consultation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: motif_consultation_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE motif_consultation_seq OWNED BY motif_consultation.motif_consultation;


--
-- Name: moyen_retenu_juge; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE moyen_retenu_juge (
    moyen_retenu_juge integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(255) NOT NULL,
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE moyen_retenu_juge; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE moyen_retenu_juge IS 'Moyens retenus par le juge';


--
-- Name: COLUMN moyen_retenu_juge.moyen_retenu_juge; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_retenu_juge.moyen_retenu_juge IS 'Identifiant unique';


--
-- Name: COLUMN moyen_retenu_juge.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_retenu_juge.code IS 'Code';


--
-- Name: COLUMN moyen_retenu_juge.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_retenu_juge.libelle IS 'Libelle';


--
-- Name: COLUMN moyen_retenu_juge.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_retenu_juge.description IS 'Description';


--
-- Name: COLUMN moyen_retenu_juge.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_retenu_juge.om_validite_debut IS 'Date de début de validité';


--
-- Name: COLUMN moyen_retenu_juge.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_retenu_juge.om_validite_fin IS 'Date de fin de validité';


--
-- Name: moyen_retenu_juge_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE moyen_retenu_juge_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: moyen_retenu_juge_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE moyen_retenu_juge_seq OWNED BY moyen_retenu_juge.moyen_retenu_juge;


--
-- Name: moyen_souleve; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE moyen_souleve (
    moyen_souleve integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(255) NOT NULL,
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE moyen_souleve; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE moyen_souleve IS 'Moyens soulevés';


--
-- Name: COLUMN moyen_souleve.moyen_souleve; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_souleve.moyen_souleve IS 'Identifiant unique';


--
-- Name: COLUMN moyen_souleve.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_souleve.code IS 'Code';


--
-- Name: COLUMN moyen_souleve.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_souleve.libelle IS 'Libelle';


--
-- Name: COLUMN moyen_souleve.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_souleve.description IS 'Description';


--
-- Name: COLUMN moyen_souleve.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_souleve.om_validite_debut IS 'Date de début de validité';


--
-- Name: COLUMN moyen_souleve.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN moyen_souleve.om_validite_fin IS 'Date de fin de validité';


--
-- Name: moyen_souleve_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE moyen_souleve_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: moyen_souleve_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE moyen_souleve_seq OWNED BY moyen_souleve.moyen_souleve;


--
-- Name: nature_travaux; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE nature_travaux (
    nature_travaux integer NOT NULL,
    libelle character varying(255) NOT NULL,
    code character varying(50),
    famille_travaux integer NOT NULL,
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: COLUMN nature_travaux.nature_travaux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN nature_travaux.nature_travaux IS 'Identifiant unique numérique';


--
-- Name: COLUMN nature_travaux.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN nature_travaux.libelle IS 'Nom de la nature de travaux';


--
-- Name: COLUMN nature_travaux.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN nature_travaux.code IS 'Code de la nature de travaux';


--
-- Name: COLUMN nature_travaux.famille_travaux; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN nature_travaux.famille_travaux IS 'Lien vers la famille de travaux associée';


--
-- Name: COLUMN nature_travaux.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN nature_travaux.description IS 'Description de la nature de travaux';


--
-- Name: COLUMN nature_travaux.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN nature_travaux.om_validite_debut IS 'Date de début de validité';


--
-- Name: COLUMN nature_travaux.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN nature_travaux.om_validite_fin IS 'Date de fin de validité';


--
-- Name: nature_travaux_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE nature_travaux_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: nature_travaux_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE nature_travaux_seq OWNED BY nature_travaux.nature_travaux;


--
-- Name: num_bordereau; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE num_bordereau (
    num_bordereau integer NOT NULL,
    libelle character varying(20),
    envoi date NOT NULL,
    om_collectivite integer NOT NULL
);


--
-- Name: COLUMN num_bordereau.num_bordereau; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_bordereau.num_bordereau IS 'Identifiant technique';


--
-- Name: COLUMN num_bordereau.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_bordereau.libelle IS 'Libelleé = Date d''envoi , éventuellement suivi d''un n° d''ordre';


--
-- Name: COLUMN num_bordereau.envoi; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_bordereau.envoi IS 'Date d"envoi';


--
-- Name: COLUMN num_bordereau.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_bordereau.om_collectivite IS 'lien vers la collectivité concernée';


--
-- Name: num_bordereau_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE num_bordereau_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: num_bordereau_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE num_bordereau_seq OWNED BY num_bordereau.num_bordereau;


--
-- Name: num_dossier; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE num_dossier (
    num_dossier integer NOT NULL,
    ref character varying(30) NOT NULL,
    code character varying(20) NOT NULL,
    petition character varying(200) NOT NULL,
    total_pages integer,
    pa3a4 integer,
    pa0 integer,
    date_depot date,
    num_bordereau integer,
    datenum date,
    num_commande integer,
    om_collectivite integer NOT NULL
);


--
-- Name: COLUMN num_dossier.num_dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.num_dossier IS 'Identifiant technique';


--
-- Name: COLUMN num_dossier.ref; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.ref IS 'Référence';


--
-- Name: COLUMN num_dossier.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.code IS 'Code';


--
-- Name: COLUMN num_dossier.petition; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.petition IS 'Nom du pétitionnaire';


--
-- Name: COLUMN num_dossier.total_pages; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.total_pages IS 'Nombre total de pages';


--
-- Name: COLUMN num_dossier.pa3a4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.pa3a4 IS 'Nombre de pages A3 et A4';


--
-- Name: COLUMN num_dossier.pa0; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.pa0 IS 'Nombre de pages A0';


--
-- Name: COLUMN num_dossier.date_depot; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.date_depot IS 'Date de dépôt';


--
-- Name: COLUMN num_dossier.num_bordereau; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.num_bordereau IS 'Bordereau associé';


--
-- Name: COLUMN num_dossier.datenum; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.datenum IS 'Date de numérisation';


--
-- Name: COLUMN num_dossier.num_commande; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.num_commande IS 'Numéro de commande';


--
-- Name: COLUMN num_dossier.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN num_dossier.om_collectivite IS 'lien vers la collectivité concernée';


--
-- Name: num_dossier_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE num_dossier_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: num_dossier_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE num_dossier_seq OWNED BY num_dossier.num_dossier;


--
-- Name: objet_recours; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE objet_recours (
    objet_recours integer NOT NULL,
    code character varying(10) NOT NULL,
    libelle character varying(255) NOT NULL,
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE objet_recours; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE objet_recours IS 'Objet du recours';


--
-- Name: COLUMN objet_recours.objet_recours; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN objet_recours.objet_recours IS 'Identifiant unique';


--
-- Name: COLUMN objet_recours.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN objet_recours.code IS 'Code';


--
-- Name: COLUMN objet_recours.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN objet_recours.libelle IS 'Libelle';


--
-- Name: COLUMN objet_recours.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN objet_recours.description IS 'Description';


--
-- Name: COLUMN objet_recours.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN objet_recours.om_validite_debut IS 'Date de début de validité';


--
-- Name: COLUMN objet_recours.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN objet_recours.om_validite_fin IS 'Date de fin de validité';


--
-- Name: objet_recours_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE objet_recours_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: objet_recours_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE objet_recours_seq OWNED BY objet_recours.objet_recours;


--
-- Name: pec_metier; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE pec_metier (
    pec_metier integer NOT NULL,
    code character varying(10),
    libelle character varying(255) NOT NULL,
    description text,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: COLUMN pec_metier.pec_metier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN pec_metier.pec_metier IS 'Identifiant technique de la prise en compte métier';


--
-- Name: COLUMN pec_metier.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN pec_metier.code IS 'Code de la prise en compte métier';


--
-- Name: COLUMN pec_metier.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN pec_metier.libelle IS 'Libellé de la prise en compte métier';


--
-- Name: COLUMN pec_metier.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN pec_metier.description IS 'Description de la prise en compte métier';


--
-- Name: COLUMN pec_metier.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN pec_metier.om_validite_debut IS 'Date de validité (début) de la prise en compte métier';


--
-- Name: COLUMN pec_metier.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN pec_metier.om_validite_fin IS 'Date de validité (fin) de la prise en compte métier';


--
-- Name: pec_metier_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE pec_metier_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: pec_metier_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE pec_metier_seq OWNED BY pec_metier.pec_metier;


--
-- Name: phase; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE phase (
    phase integer NOT NULL,
    code character varying(15) NOT NULL,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: TABLE phase; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE phase IS 'Phase';


--
-- Name: COLUMN phase.phase; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN phase.phase IS 'Identifiant unique';


--
-- Name: COLUMN phase.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN phase.code IS 'Code de phase composé de caractères alphanumériques';


--
-- Name: COLUMN phase.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN phase.om_validite_debut IS 'Date de début de validité';


--
-- Name: COLUMN phase.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN phase.om_validite_fin IS 'Date de fin de validité';


--
-- Name: phase_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE phase_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: phase_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE phase_seq OWNED BY phase.phase;


--
-- Name: quartier; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE quartier (
    quartier integer NOT NULL,
    arrondissement integer NOT NULL,
    code_impots character varying(3) NOT NULL,
    libelle character varying(40) NOT NULL
);


--
-- Name: TABLE quartier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE quartier IS 'Liste des quartiers';


--
-- Name: COLUMN quartier.quartier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN quartier.quartier IS 'Identifiant unique';


--
-- Name: COLUMN quartier.arrondissement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN quartier.arrondissement IS 'Arrondissement du quartier';


--
-- Name: COLUMN quartier.code_impots; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN quartier.code_impots IS 'Code impôt du quartier';


--
-- Name: COLUMN quartier.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN quartier.libelle IS 'Libellé du quartier';


--
-- Name: quartier_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE quartier_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: quartier_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE quartier_seq OWNED BY quartier.quartier;


--
-- Name: rapport_instruction; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE rapport_instruction (
    rapport_instruction integer NOT NULL,
    dossier_instruction character varying(255),
    analyse_reglementaire_om_html text,
    description_projet_om_html text,
    proposition_decision text,
    om_fichier_rapport_instruction character varying(255),
    om_final_rapport_instruction boolean,
    complement_om_html text,
    om_fichier_rapport_instruction_dossier_final boolean DEFAULT false
);


--
-- Name: TABLE rapport_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE rapport_instruction IS 'Rapport d''instruction d''un dossier d''instruction';


--
-- Name: COLUMN rapport_instruction.rapport_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN rapport_instruction.rapport_instruction IS 'Identifiant unique';


--
-- Name: COLUMN rapport_instruction.dossier_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN rapport_instruction.dossier_instruction IS 'Dossier d''instruction sur lequel il y a le rapport d''instruction';


--
-- Name: COLUMN rapport_instruction.analyse_reglementaire_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN rapport_instruction.analyse_reglementaire_om_html IS 'Analyse réglementaire de l''instructeur sur le dossier d''instruction';


--
-- Name: COLUMN rapport_instruction.description_projet_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN rapport_instruction.description_projet_om_html IS 'Description du projet du dossier d''instruction';


--
-- Name: COLUMN rapport_instruction.proposition_decision; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN rapport_instruction.proposition_decision IS 'Décision proposée par l''instructeur pour le dossier d''instruction';


--
-- Name: COLUMN rapport_instruction.om_fichier_rapport_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN rapport_instruction.om_fichier_rapport_instruction IS 'Identifiant du fichier finalisé dans le système de stockage';


--
-- Name: COLUMN rapport_instruction.om_final_rapport_instruction; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN rapport_instruction.om_final_rapport_instruction IS 'Permet de savoir si le fichier est finalisé';


--
-- Name: COLUMN rapport_instruction.complement_om_html; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN rapport_instruction.complement_om_html IS 'Informations complementaire sur l''instruction';


--
-- Name: COLUMN rapport_instruction.om_fichier_rapport_instruction_dossier_final; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN rapport_instruction.om_fichier_rapport_instruction_dossier_final IS 'Identifie que le document constitue dossier final';


--
-- Name: rapport_instruction_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE rapport_instruction_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: rapport_instruction_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE rapport_instruction_seq OWNED BY rapport_instruction.rapport_instruction;


--
-- Name: region; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE region (
    region integer NOT NULL,
    reg character varying(2) NOT NULL,
    cheflieu character varying(5) NOT NULL,
    tncc character varying(1),
    ncc character varying(200),
    nccenr character varying(200),
    libelle character varying(45),
    om_validite_debut date NOT NULL,
    om_validite_fin date
);


--
-- Name: COLUMN region.region; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN region.region IS 'Identifiant technique de la region';


--
-- Name: COLUMN region.reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN region.reg IS 'Code INSEE de la région';


--
-- Name: COLUMN region.cheflieu; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN region.cheflieu IS 'Code INSEE du chef lieu';


--
-- Name: COLUMN region.tncc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN region.tncc IS 'Type de nom en clair';


--
-- Name: COLUMN region.ncc; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN region.ncc IS 'Nom en clair (majuscules)';


--
-- Name: COLUMN region.nccenr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN region.nccenr IS 'Nom en typographie riche';


--
-- Name: COLUMN region.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN region.libelle IS 'Nom en typographie riche avec article';


--
-- Name: COLUMN region.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN region.om_validite_debut IS 'Date de validité (début)';


--
-- Name: COLUMN region.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN region.om_validite_fin IS 'Date de validité (fin)';


--
-- Name: region_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE region_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: region_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE region_seq OWNED BY region.region;


--
-- Name: regle; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE regle (
    regle integer NOT NULL,
    sens character varying(5) NOT NULL,
    ordre integer NOT NULL,
    controle character varying(20) DEFAULT ''::character varying NOT NULL,
    id integer DEFAULT 0 NOT NULL,
    champ character varying(30) NOT NULL,
    operateur character(2) NOT NULL,
    valeur double precision NOT NULL,
    message character varying(80) NOT NULL
);


--
-- Name: TABLE regle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE regle IS 'Règles de contrôle de champ';


--
-- Name: COLUMN regle.regle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN regle.regle IS 'Identifiant unique';


--
-- Name: COLUMN regle.sens; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN regle.sens IS 'Sens de la règle (''plus'' ou ''moins'')';


--
-- Name: COLUMN regle.ordre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN regle.ordre IS 'Ordre de la règle';


--
-- Name: COLUMN regle.controle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN regle.controle IS 'Contrôle effectué par la règle';


--
-- Name: COLUMN regle.id; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN regle.id IS 'Identifiant unique';


--
-- Name: COLUMN regle.champ; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN regle.champ IS 'Champ sur lequel la règle doit être appliquée';


--
-- Name: COLUMN regle.operateur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN regle.operateur IS 'Opérateur utilisé par la règle (>, <, >=, <=)';


--
-- Name: COLUMN regle.valeur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN regle.valeur IS 'Valeur à comparer';


--
-- Name: COLUMN regle.message; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN regle.message IS 'Message explicatif de la règle';


--
-- Name: regle_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE regle_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: regle_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE regle_seq OWNED BY regle.regle;


--
-- Name: service; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE service (
    abrege character varying(30) NOT NULL,
    libelle character varying(255) NOT NULL,
    adresse character varying(40) DEFAULT ''::character varying NOT NULL,
    adresse2 character varying(39) DEFAULT ''::character varying NOT NULL,
    cp character varying(5) DEFAULT ''::character varying NOT NULL,
    ville character varying(30) DEFAULT ''::character varying NOT NULL,
    email text DEFAULT ''::character varying NOT NULL,
    delai integer,
    service integer NOT NULL,
    consultation_papier boolean,
    notification_email boolean,
    om_validite_debut date,
    om_validite_fin date,
    type_consultation character varying(70) DEFAULT 'avec_avis_attendu'::character varying NOT NULL,
    edition integer NOT NULL,
    om_collectivite integer NOT NULL,
    delai_type character varying(100) DEFAULT 'mois'::character varying,
    service_type character varying(255) NOT NULL,
    generate_edition boolean DEFAULT false,
    uid_platau_acteur character varying(255),
    accepte_notification_email boolean DEFAULT false
);


--
-- Name: TABLE service; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE service IS 'Services consultés lors de l''instruction d''un dossier';


--
-- Name: COLUMN service.abrege; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.abrege IS 'Code du service';


--
-- Name: COLUMN service.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.libelle IS 'Libellé du service';


--
-- Name: COLUMN service.adresse; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.adresse IS 'Adresse du service';


--
-- Name: COLUMN service.adresse2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.adresse2 IS 'Complément d''adresse du service';


--
-- Name: COLUMN service.cp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.cp IS 'Code postal de l''adresse du service';


--
-- Name: COLUMN service.ville; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.ville IS 'Ville de l''adresse du service';


--
-- Name: COLUMN service.email; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.email IS 'Email du service';


--
-- Name: COLUMN service.delai; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.delai IS 'Delai de consultation au service';


--
-- Name: COLUMN service.service; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.service IS 'Identifiant unique';


--
-- Name: COLUMN service.consultation_papier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.consultation_papier IS 'La consultation nécessite l''envoi d''un courrier';


--
-- Name: COLUMN service.notification_email; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.notification_email IS 'La consultation nécessite l''envoi d''un email';


--
-- Name: COLUMN service.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.om_validite_debut IS 'Date de début de validité du service';


--
-- Name: COLUMN service.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.om_validite_fin IS 'Date de fin de validité du service';


--
-- Name: COLUMN service.type_consultation; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.type_consultation IS 'Type de consultation (pour conformité, avis attendu, pour information)';


--
-- Name: COLUMN service.edition; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.edition IS 'Type d''édition pour la consultation';


--
-- Name: COLUMN service.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.om_collectivite IS 'lien vers la collectivité concernée';


--
-- Name: COLUMN service.delai_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.delai_type IS 'Type de délai (mois ou jour)';


--
-- Name: COLUMN service.service_type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.service_type IS 'Type du service';


--
-- Name: COLUMN service.generate_edition; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.generate_edition IS 'Générer l''édition liée au service consulté (true) ou non (false)';


--
-- Name: COLUMN service.uid_platau_acteur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.uid_platau_acteur IS 'Identifant acteur du service consulté dans Plat''AU';


--
-- Name: COLUMN service.accepte_notification_email; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service.accepte_notification_email IS 'Indique si la notification des services consultés est possible';


--
-- Name: service_categorie; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE service_categorie (
    service_categorie integer NOT NULL,
    libelle character varying(70) DEFAULT ''::character varying NOT NULL
);


--
-- Name: TABLE service_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE service_categorie IS 'Catégorie des services';


--
-- Name: COLUMN service_categorie.service_categorie; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service_categorie.service_categorie IS 'Identifiant unique';


--
-- Name: COLUMN service_categorie.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN service_categorie.libelle IS 'Libellé de la catégorie du service';


--
-- Name: service_categorie_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE service_categorie_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: service_categorie_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE service_categorie_seq OWNED BY service_categorie.service_categorie;


--
-- Name: service_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE service_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: service_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE service_seq OWNED BY service.service;


--
-- Name: sig_attribut; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE sig_attribut (
    sig_attribut integer NOT NULL,
    sig_couche integer NOT NULL,
    libelle character varying(250) NOT NULL,
    identifiant character varying(250) NOT NULL
);


--
-- Name: COLUMN sig_attribut.sig_attribut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_attribut.sig_attribut IS 'Identifiant unique interne.';


--
-- Name: COLUMN sig_attribut.sig_couche; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_attribut.sig_couche IS 'Identifiant de la couche de rattachement.';


--
-- Name: COLUMN sig_attribut.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_attribut.libelle IS 'Nom de l''attribut dans l''interface utilisateur.';


--
-- Name: COLUMN sig_attribut.identifiant; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_attribut.identifiant IS 'Identifiant de l''attribut des objets de la couche.';


--
-- Name: sig_attribut_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE sig_attribut_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: sig_attribut_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE sig_attribut_seq OWNED BY sig_attribut.sig_attribut;


--
-- Name: sig_contrainte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE sig_contrainte (
    sig_contrainte integer NOT NULL,
    nature character varying(10) NOT NULL,
    groupe integer NOT NULL,
    sousgroupe integer,
    libelle character varying(250) NOT NULL,
    texte text,
    texte_genere text,
    no_ordre integer,
    service_consulte boolean DEFAULT false,
    sig_couche integer NOT NULL
);


--
-- Name: COLUMN sig_contrainte.sig_contrainte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.sig_contrainte IS 'Identifiant unique interne.';


--
-- Name: COLUMN sig_contrainte.nature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.nature IS 'Nature de la contrainte.';


--
-- Name: COLUMN sig_contrainte.groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.groupe IS 'Groupe de la contrainte.';


--
-- Name: COLUMN sig_contrainte.sousgroupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.sousgroupe IS 'Sous-groupe de la contrainte.';


--
-- Name: COLUMN sig_contrainte.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.libelle IS 'Libellé permettant de sélectionnerla contrainte dans l''interface d''ajout.';


--
-- Name: COLUMN sig_contrainte.texte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.texte IS 'Texte intégré en texte complété lorsque la contrainte est ajoutée manuellement.';


--
-- Name: COLUMN sig_contrainte.texte_genere; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.texte_genere IS 'Texte intégré lorsque le texte est renvoyé par une recherche dynamique de contrainte.';


--
-- Name: COLUMN sig_contrainte.no_ordre; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.no_ordre IS 'Numéro d''ordre d''affichage ou d''impression.';


--
-- Name: COLUMN sig_contrainte.service_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.service_consulte IS 'Contrainte affichée aux service consulté.';


--
-- Name: COLUMN sig_contrainte.sig_couche; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_contrainte.sig_couche IS 'Sélection de la couche SIG qui porte la contrainte.';


--
-- Name: sig_contrainte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE sig_contrainte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: sig_contrainte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE sig_contrainte_seq OWNED BY sig_contrainte.sig_contrainte;


--
-- Name: sig_couche; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE sig_couche (
    sig_couche integer NOT NULL,
    libelle character varying(250) NOT NULL,
    id_couche character varying(250) NOT NULL
);


--
-- Name: COLUMN sig_couche.sig_couche; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_couche.sig_couche IS 'Identifiant unique interne.';


--
-- Name: COLUMN sig_couche.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_couche.libelle IS 'Nom de la couche dans l''interface utilisateur.';


--
-- Name: COLUMN sig_couche.id_couche; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_couche.id_couche IS 'Identifiant de la couche dans le sig.';


--
-- Name: sig_couche_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE sig_couche_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: sig_couche_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE sig_couche_seq OWNED BY sig_couche.sig_couche;


--
-- Name: sig_groupe; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE sig_groupe (
    sig_groupe integer NOT NULL,
    libelle character varying(250) NOT NULL
);


--
-- Name: COLUMN sig_groupe.sig_groupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_groupe.sig_groupe IS 'Identifiant unique interne.';


--
-- Name: COLUMN sig_groupe.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_groupe.libelle IS 'Libellé du groupe.';


--
-- Name: sig_groupe_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE sig_groupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: sig_groupe_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE sig_groupe_seq OWNED BY sig_groupe.sig_groupe;


--
-- Name: sig_sousgroupe; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE sig_sousgroupe (
    sig_sousgroupe integer NOT NULL,
    libelle character varying(250) NOT NULL
);


--
-- Name: COLUMN sig_sousgroupe.sig_sousgroupe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_sousgroupe.sig_sousgroupe IS 'Identifiant unique interne.';


--
-- Name: COLUMN sig_sousgroupe.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN sig_sousgroupe.libelle IS 'Libellé du sous-groupe.';


--
-- Name: sig_sousgroupe_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE sig_sousgroupe_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: sig_sousgroupe_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE sig_sousgroupe_seq OWNED BY sig_sousgroupe.sig_sousgroupe;


--
-- Name: signataire_arrete; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE signataire_arrete (
    signataire_arrete integer NOT NULL,
    civilite integer,
    nom character varying(80),
    prenom character varying(80),
    qualite character varying(80),
    signature text,
    defaut boolean,
    om_validite_debut date,
    om_validite_fin date,
    om_collectivite integer NOT NULL,
    email character varying(255),
    parametre_parapheur text,
    description character varying(255),
    signataire_habilitation integer,
    agrement text,
    visa text,
    visa_2 text,
    visa_3 text,
    visa_4 text
);


--
-- Name: TABLE signataire_arrete; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE signataire_arrete IS 'Personne accréditée à signer les arrêtés';


--
-- Name: COLUMN signataire_arrete.signataire_arrete; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.signataire_arrete IS 'Identifiant unique';


--
-- Name: COLUMN signataire_arrete.civilite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.civilite IS 'Civilité du signataire';


--
-- Name: COLUMN signataire_arrete.nom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.nom IS 'Nom du signataire';


--
-- Name: COLUMN signataire_arrete.prenom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.prenom IS 'Prénom du signataire';


--
-- Name: COLUMN signataire_arrete.qualite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.qualite IS 'Qualité du signataire (Maire, Prefet, ...)';


--
-- Name: COLUMN signataire_arrete.signature; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.signature IS 'Signature du signataire';


--
-- Name: COLUMN signataire_arrete.defaut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.defaut IS 'Signataire par défaut';


--
-- Name: COLUMN signataire_arrete.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.om_validite_debut IS 'Date de début de validité du signataire';


--
-- Name: COLUMN signataire_arrete.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.om_validite_fin IS 'Date de fin de validité du signataire';


--
-- Name: COLUMN signataire_arrete.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.om_collectivite IS 'Lien vers la collectivité concernée.';


--
-- Name: COLUMN signataire_arrete.email; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.email IS 'E-mail du signataire';


--
-- Name: COLUMN signataire_arrete.parametre_parapheur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.parametre_parapheur IS 'Doit contenir du json, permet de spécifier des paramètres supplémentaires au parapheur.';


--
-- Name: COLUMN signataire_arrete.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.description IS 'Description du signataire';


--
-- Name: COLUMN signataire_arrete.visa; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.visa IS 'Champs servant à saisir un visa.';


--
-- Name: COLUMN signataire_arrete.visa_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.visa_2 IS 'Champs servant à saisir un deuxième visa (Compléments).';


--
-- Name: COLUMN signataire_arrete.visa_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.visa_3 IS 'Champs servant à saisir un troisième visa (Compléments).';


--
-- Name: COLUMN signataire_arrete.visa_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN signataire_arrete.visa_4 IS 'Champs servant à saisir un quatrième visa (Compléments).';


--
-- Name: signataire_arrete_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE signataire_arrete_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: signataire_arrete_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE signataire_arrete_seq OWNED BY signataire_arrete.signataire_arrete;


--
-- Name: signataire_habilitation; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE signataire_habilitation (
    signataire_habilitation integer NOT NULL,
    libelle character varying(255) NOT NULL,
    code character varying(20),
    description character varying(255),
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: signataire_habilitation_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE signataire_habilitation_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: signataire_habilitation_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE signataire_habilitation_seq OWNED BY signataire_habilitation.signataire_habilitation;


--
-- Name: specialite_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE specialite_tiers_consulte (
    specialite_tiers_consulte integer NOT NULL,
    code character varying(50),
    description text,
    libelle character varying(255),
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: COLUMN specialite_tiers_consulte.specialite_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN specialite_tiers_consulte.specialite_tiers_consulte IS 'Identifiant unique';


--
-- Name: COLUMN specialite_tiers_consulte.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN specialite_tiers_consulte.code IS 'Code de la spécialité';


--
-- Name: COLUMN specialite_tiers_consulte.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN specialite_tiers_consulte.description IS 'Description de la spécialité';


--
-- Name: COLUMN specialite_tiers_consulte.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN specialite_tiers_consulte.libelle IS 'Libellé de la spécialité';


--
-- Name: COLUMN specialite_tiers_consulte.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN specialite_tiers_consulte.om_validite_debut IS 'Date de début de validité de la spécialité du tiers consulté';


--
-- Name: COLUMN specialite_tiers_consulte.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN specialite_tiers_consulte.om_validite_fin IS 'Date de fin de validité de la spécialité du tiers consulté';


--
-- Name: specialite_tiers_consulte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE specialite_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: specialite_tiers_consulte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE specialite_tiers_consulte_seq OWNED BY specialite_tiers_consulte.specialite_tiers_consulte;


--
-- Name: storage; Type: TABLE; Schema: openads; Owner: -
--

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
    om_collectivite integer NOT NULL,
    uid_dossier_final boolean DEFAULT false
);


--
-- Name: COLUMN storage.storage; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.storage IS 'Identifiant numérique unique';


--
-- Name: COLUMN storage.creation_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.creation_date IS 'Date de création du fichier';


--
-- Name: COLUMN storage.creation_time; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.creation_time IS 'Heure de création du fichier';


--
-- Name: COLUMN storage.uid; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.uid IS 'Identifiant dans le backend de storage du fichier';


--
-- Name: COLUMN storage.filename; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.filename IS 'Nom du fichier';


--
-- Name: COLUMN storage.size; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.size IS 'Taille du fichier';


--
-- Name: COLUMN storage.mimetype; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.mimetype IS 'Mimetype du fichier';


--
-- Name: COLUMN storage.type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.type IS 'Type du fichier (sitadel, etc.)';


--
-- Name: COLUMN storage.info; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.info IS 'Informations complémentaires (JSON)';


--
-- Name: COLUMN storage.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.om_collectivite IS 'Collectivité du fichier';


--
-- Name: COLUMN storage.uid_dossier_final; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN storage.uid_dossier_final IS 'Identifie que le document constitue dossier final';


--
-- Name: storage_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE storage_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: storage_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE storage_seq OWNED BY storage.storage;


--
-- Name: task; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE task (
    task integer NOT NULL,
    type character varying(30) NOT NULL,
    timestamp_log text DEFAULT '{}'::text NOT NULL,
    state character varying(20) DEFAULT 'draft'::character varying NOT NULL,
    object_id character varying(30),
    dossier character varying(30),
    json_payload text DEFAULT '{}'::text NOT NULL,
    stream character varying,
    category character varying(2000),
    creation_date date,
    creation_time time without time zone,
    last_modification_date date,
    last_modification_time time without time zone,
    comment text
);


--
-- Name: TABLE task; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE task IS 'Liste des tâches à traiter pour la dématérialisation';


--
-- Name: COLUMN task.task; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.task IS 'Identifiant numérique unique de la tâche';


--
-- Name: COLUMN task.type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.type IS 'Type de la tâche (XXX)';


--
-- Name: COLUMN task.timestamp_log; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.timestamp_log IS 'Journal d''horodatage ';


--
-- Name: COLUMN task.state; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.state IS 'Statut (draft, new, pending, done, archived, error, debug, canceled)';


--
-- Name: COLUMN task.object_id; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.object_id IS 'Identifiant de l''objet métier';


--
-- Name: COLUMN task.dossier; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.dossier IS 'Numéro du dossier lié à la tâche';


--
-- Name: COLUMN task.json_payload; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.json_payload IS 'Champ permettant de stocker la view json de la tache';


--
-- Name: COLUMN task.stream; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.stream IS 'Indique si la tache est de type input ou output';


--
-- Name: COLUMN task.category; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.category IS 'Catégorie de la tâche';


--
-- Name: COLUMN task.creation_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.creation_date IS 'Date de création de la tâche';


--
-- Name: COLUMN task.creation_time; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.creation_time IS 'Heure de création de la tâche';


--
-- Name: COLUMN task.last_modification_date; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.last_modification_date IS 'Date de la dernière modification de la tâche';


--
-- Name: COLUMN task.last_modification_time; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN task.last_modification_time IS 'Heure de la dernière modification de la tâche';


--
-- Name: task_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE task_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: task_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE task_seq OWNED BY task.task;


--
-- Name: taxe_amenagement; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE taxe_amenagement (
    taxe_amenagement integer NOT NULL,
    om_collectivite integer NOT NULL,
    en_ile_de_france boolean DEFAULT false,
    val_forf_surf_cstr integer NOT NULL,
    val_forf_empl_tente_carav_rml integer NOT NULL,
    val_forf_empl_hll integer NOT NULL,
    val_forf_surf_piscine integer NOT NULL,
    val_forf_nb_eolienne integer NOT NULL,
    val_forf_surf_pann_photo integer NOT NULL,
    val_forf_nb_parking_ext integer NOT NULL,
    tx_depart numeric NOT NULL,
    tx_reg numeric,
    tx_comm_secteur_1 numeric NOT NULL,
    tx_comm_secteur_2 numeric,
    tx_comm_secteur_3 numeric,
    tx_comm_secteur_4 numeric,
    tx_comm_secteur_5 numeric,
    tx_comm_secteur_6 numeric,
    tx_comm_secteur_7 numeric,
    tx_comm_secteur_8 numeric,
    tx_comm_secteur_9 numeric,
    tx_comm_secteur_10 numeric,
    tx_comm_secteur_11 numeric,
    tx_comm_secteur_12 numeric,
    tx_comm_secteur_13 numeric,
    tx_comm_secteur_14 numeric,
    tx_comm_secteur_15 numeric,
    tx_comm_secteur_16 numeric,
    tx_comm_secteur_17 numeric,
    tx_comm_secteur_18 numeric,
    tx_comm_secteur_19 numeric,
    tx_comm_secteur_20 numeric,
    tx_exo_facul_1_reg numeric,
    tx_exo_facul_2_reg numeric,
    tx_exo_facul_3_reg numeric,
    tx_exo_facul_4_reg numeric,
    tx_exo_facul_5_reg numeric,
    tx_exo_facul_6_reg numeric,
    tx_exo_facul_7_reg numeric,
    tx_exo_facul_8_reg numeric,
    tx_exo_facul_9_reg numeric,
    tx_exo_facul_1_depart numeric,
    tx_exo_facul_2_depart numeric,
    tx_exo_facul_3_depart numeric,
    tx_exo_facul_4_depart numeric,
    tx_exo_facul_5_depart numeric,
    tx_exo_facul_6_depart numeric,
    tx_exo_facul_7_depart numeric,
    tx_exo_facul_8_depart numeric,
    tx_exo_facul_9_depart numeric,
    tx_exo_facul_1_comm numeric,
    tx_exo_facul_2_comm numeric,
    tx_exo_facul_3_comm numeric,
    tx_exo_facul_4_comm numeric,
    tx_exo_facul_5_comm numeric,
    tx_exo_facul_6_comm numeric,
    tx_exo_facul_7_comm numeric,
    tx_exo_facul_8_comm numeric,
    tx_exo_facul_9_comm numeric,
    tx_rap numeric NOT NULL
);


--
-- Name: TABLE taxe_amenagement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE taxe_amenagement IS 'Liste des paramètres par collectivité pour le calcul de la taxe d''aménagement';


--
-- Name: COLUMN taxe_amenagement.taxe_amenagement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.taxe_amenagement IS 'Identifiant unique';


--
-- Name: COLUMN taxe_amenagement.om_collectivite; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.om_collectivite IS 'Collectivité utilisant les paramètres de taxation';


--
-- Name: COLUMN taxe_amenagement.en_ile_de_france; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.en_ile_de_france IS 'Si la collectivité est située en Île-de-France';


--
-- Name: COLUMN taxe_amenagement.val_forf_surf_cstr; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.val_forf_surf_cstr IS 'Valeur forfaitaire de la surface de construction en m²';


--
-- Name: COLUMN taxe_amenagement.val_forf_empl_tente_carav_rml; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.val_forf_empl_tente_carav_rml IS 'Valeur forfaitaire de l''emplacement de tente, caravane et résidence mobile de loisirs';


--
-- Name: COLUMN taxe_amenagement.val_forf_empl_hll; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.val_forf_empl_hll IS 'Valeur forfaitaire de l''emplacement d''habitation légère de loisirs (HLL)';


--
-- Name: COLUMN taxe_amenagement.val_forf_surf_piscine; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.val_forf_surf_piscine IS 'Valeur forfaitaire de la surface de piscine en m²';


--
-- Name: COLUMN taxe_amenagement.val_forf_nb_eolienne; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.val_forf_nb_eolienne IS 'Valeur forfaitaire d''éolienne de plus de 12m de haut (par éolienne)';


--
-- Name: COLUMN taxe_amenagement.val_forf_surf_pann_photo; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.val_forf_surf_pann_photo IS 'Valeur forfaitaire de la surface de panneau photovoltaïque (capteurs solaires destinés à la production de l''électricité) fixé au sol, en m² de surface de panneau (les panneaux solaires thermiques, qui produisent de la chaleur, ne sont pas taxés)';


--
-- Name: COLUMN taxe_amenagement.val_forf_nb_parking_ext; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.val_forf_nb_parking_ext IS 'Valeur forfaitaire de l''emplacement de stationnement extérieure';


--
-- Name: COLUMN taxe_amenagement.tx_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_depart IS 'Taux départemental';


--
-- Name: COLUMN taxe_amenagement.tx_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_reg IS 'Taux régional pour Île-de-France';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_1; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_1 IS 'Taux communal du secteur 1';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_2; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_2 IS 'Taux communal du secteur 2';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_3; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_3 IS 'Taux communal du secteur 3';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_4; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_4 IS 'Taux communal du secteur 4';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_5; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_5 IS 'Taux communal du secteur 5';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_6; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_6 IS 'Taux communal du secteur 6';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_7; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_7 IS 'Taux communal du secteur 7';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_8; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_8 IS 'Taux communal du secteur 8';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_9; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_9 IS 'Taux communal du secteur 9';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_10; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_10 IS 'Taux communae du secteur 10';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_11; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_11 IS 'Taux communal du secteur 11';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_12; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_12 IS 'Taux communal du secteur 12';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_13; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_13 IS 'Taux communal du secteur 13';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_14; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_14 IS 'Taux communal du secteur 14';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_15; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_15 IS 'Taux communal du secteur 15';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_16; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_16 IS 'Taux communal du secteur 16';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_17; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_17 IS 'Taux communal du secteur 17';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_18; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_18 IS 'Taux communal du secteur 18';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_19; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_19 IS 'Taux communal du secteur 19';


--
-- Name: COLUMN taxe_amenagement.tx_comm_secteur_20; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_comm_secteur_20 IS 'Taux communal du secteur 20';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_1_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_1_reg IS 'Les locaux d''habitation et d''hébergement mentionnés au 1° de l''article L. 331-12 qui ne bénéficient pas de l''exonération prévue au 2° de l''article L. 331-7.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_2_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_2_reg IS 'Dans la limite de 50 % de leur surface, les surfaces des locaux à usage d''habitation principale qui ne bénéficient pas de l''abattement mentionné au 2° de l''article L. 331-12 et qui sont financés à l''aide du prêt ne portant pas intérêt prévu à l''article L. 31-10-1 du code de la construction et de l''habitation.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_3_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_3_reg IS 'Les locaux à usage industriel et artisanal mentionnés au 3° de l''article L. 331-12 du présent code.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_4_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_4_reg IS 'Les commerces de détail d''une surface de vente inférieure à 400 mètres carrés.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_5_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_5_reg IS 'Les immeubles classés parmi les monuments historiques ou inscrits à l''inventaire supplémentaire des monuments historiques.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_6_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_6_reg IS 'Les surfaces annexes à usage de stationnement des locaux mentionnés au 1° et ne bénéficiant pas de l''exonération totale.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_7_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_7_reg IS 'Les surfaces des locaux annexes à usage de stationnement des immeubles autres que d''habitations individuelles.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_8_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_8_reg IS 'Les abris de jardin, les pigeonniers et colombiers soumis à déclaration préalable.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_9_reg; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_9_reg IS 'Les maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique, pour les communes maîtres d''ouvrage.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_1_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_1_depart IS 'Les locaux d''habitation et d''hébergement mentionnés au 1° de l''article L. 331-12 qui ne bénéficient pas de l''exonération prévue au 2° de l''article L. 331-7.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_2_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_2_depart IS 'Dans la limite de 50 % de leur surface, les surfaces des locaux à usage d''habitation principale qui ne bénéficient pas de l''abattement mentionné au 2° de l''article L. 331-12 et qui sont financés à l''aide du prêt ne portant pas intérêt prévu à l''article L. 31-10-1 du code de la construction et de l''habitation.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_3_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_3_depart IS 'Les locaux à usage industriel et artisanal mentionnés au 3° de l''article L. 331-12 du présent code.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_4_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_4_depart IS 'Les commerces de détail d''une surface de vente inférieure à 400 mètres carrés.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_5_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_5_depart IS 'Les immeubles classés parmi les monuments historiques ou inscrits à l''inventaire supplémentaire des monuments historiques.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_6_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_6_depart IS 'Les surfaces annexes à usage de stationnement des locaux mentionnés au 1° et ne bénéficiant pas de l''exonération totale.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_7_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_7_depart IS 'Les surfaces des locaux annexes à usage de stationnement des immeubles autres que d''habitations individuelles.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_8_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_8_depart IS 'Les abris de jardin, les pigeonniers et colombiers soumis à déclaration préalable.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_9_depart; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_9_depart IS 'Les maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique, pour les communes maîtres d''ouvrage.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_1_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_1_comm IS 'Les locaux d''habitation et d''hébergement mentionnés au 1° de l''article L. 331-12 qui ne bénéficient pas de l''exonération prévue au 2° de l''article L. 331-7.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_2_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_2_comm IS 'Dans la limite de 50 % de leur surface, les surfaces des locaux à usage d''habitation principale qui ne bénéficient pas de l''abattement mentionné au 2° de l''article L. 331-12 et qui sont financés à l''aide du prêt ne portant pas intérêt prévu à l''article L. 31-10-1 du code de la construction et de l''habitation.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_3_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_3_comm IS 'Les locaux à usage industriel et artisanal mentionnés au 3° de l''article L. 331-12 du présent code.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_4_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_4_comm IS 'Les commerces de détail d''une surface de vente inférieure à 400 mètres carrés.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_5_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_5_comm IS 'Les immeubles classés parmi les monuments historiques ou inscrits à l''inventaire supplémentaire des monuments historiques.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_6_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_6_comm IS 'Les surfaces annexes à usage de stationnement des locaux mentionnés au 1° et ne bénéficiant pas de l''exonération totale.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_7_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_7_comm IS 'Les surfaces des locaux annexes à usage de stationnement des immeubles autres que d''habitations individuelles.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_8_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_8_comm IS 'Les abris de jardin, les pigeonniers et colombiers soumis à déclaration préalable.';


--
-- Name: COLUMN taxe_amenagement.tx_exo_facul_9_comm; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_exo_facul_9_comm IS 'Les maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique, pour les communes maîtres d''ouvrage.';


--
-- Name: COLUMN taxe_amenagement.tx_rap; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN taxe_amenagement.tx_rap IS 'Taux de la redevance d''archéologie préventive par m²';


--
-- Name: taxe_amenagement_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE taxe_amenagement_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: taxe_amenagement_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE taxe_amenagement_seq OWNED BY taxe_amenagement.taxe_amenagement;


--
-- Name: tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE tiers_consulte (
    tiers_consulte integer NOT NULL,
    categorie_tiers_consulte integer NOT NULL,
    abrege character varying(30) NOT NULL,
    libelle character varying(255) NOT NULL,
    adresse character varying(300),
    complement character varying(300),
    cp character varying(5),
    ville character varying(255),
    liste_diffusion text,
    accepte_notification_email boolean DEFAULT false,
    uid_platau_acteur character varying(255)
);


--
-- Name: COLUMN tiers_consulte.tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.tiers_consulte IS 'Identifiant unique';


--
-- Name: COLUMN tiers_consulte.categorie_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.categorie_tiers_consulte IS 'Catégorie du tiers consulté';


--
-- Name: COLUMN tiers_consulte.abrege; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.abrege IS 'Abréviation du tiers consulté';


--
-- Name: COLUMN tiers_consulte.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.libelle IS 'Libellé du tiers consulté';


--
-- Name: COLUMN tiers_consulte.adresse; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.adresse IS 'Adresse du tiers consulté';


--
-- Name: COLUMN tiers_consulte.complement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.complement IS 'Complément d''adresse';


--
-- Name: COLUMN tiers_consulte.cp; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.cp IS 'Code postal de l''adresse du tiers consulté';


--
-- Name: COLUMN tiers_consulte.ville; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.ville IS 'Ville de l''adresse du tiers consulté';


--
-- Name: COLUMN tiers_consulte.liste_diffusion; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.liste_diffusion IS 'Liste de diffusion du tiers consulté';


--
-- Name: COLUMN tiers_consulte.accepte_notification_email; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.accepte_notification_email IS 'Le tiers consulté accepte la notification par mail';


--
-- Name: COLUMN tiers_consulte.uid_platau_acteur; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN tiers_consulte.uid_platau_acteur IS 'Identifant acteur du service consulté dans Plat''AU';


--
-- Name: tiers_consulte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: tiers_consulte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE tiers_consulte_seq OWNED BY tiers_consulte.tiers_consulte;


--
-- Name: transition; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE transition (
    transition integer NOT NULL,
    etat character varying(150) NOT NULL,
    evenement integer NOT NULL
);


--
-- Name: TABLE transition; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON TABLE transition IS 'Table de liaisons entre les états et les événements';


--
-- Name: COLUMN transition.transition; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN transition.transition IS 'Identifiant unique';


--
-- Name: COLUMN transition.etat; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN transition.etat IS 'États des dossiers d''instruction';


--
-- Name: COLUMN transition.evenement; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN transition.evenement IS 'Paramétrage des événements d''instruction';


--
-- Name: transition_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE transition_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: transition_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE transition_seq OWNED BY transition.transition;


--
-- Name: type_habilitation_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE type_habilitation_tiers_consulte (
    type_habilitation_tiers_consulte integer NOT NULL,
    code character varying(50),
    description text,
    libelle character varying(255),
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: COLUMN type_habilitation_tiers_consulte.type_habilitation_tiers_consulte; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN type_habilitation_tiers_consulte.type_habilitation_tiers_consulte IS 'Identifiant unique';


--
-- Name: COLUMN type_habilitation_tiers_consulte.code; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN type_habilitation_tiers_consulte.code IS 'Code du type d''habilitation';


--
-- Name: COLUMN type_habilitation_tiers_consulte.description; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN type_habilitation_tiers_consulte.description IS 'Description du type d''habilitation';


--
-- Name: COLUMN type_habilitation_tiers_consulte.libelle; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN type_habilitation_tiers_consulte.libelle IS 'Libellé du type d''habilitation';


--
-- Name: COLUMN type_habilitation_tiers_consulte.om_validite_debut; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN type_habilitation_tiers_consulte.om_validite_debut IS 'Date de début de validité du type d''habilitation';


--
-- Name: COLUMN type_habilitation_tiers_consulte.om_validite_fin; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN type_habilitation_tiers_consulte.om_validite_fin IS 'Date de fin de validité du type d''habilitation';


--
-- Name: type_habilitation_tiers_consulte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE type_habilitation_tiers_consulte_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: type_habilitation_tiers_consulte_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE type_habilitation_tiers_consulte_seq OWNED BY type_habilitation_tiers_consulte.type_habilitation_tiers_consulte;


--
-- Name: transition transition; Type: DEFAULT; Schema: openads; Owner: -
--

ALTER TABLE ONLY transition ALTER COLUMN transition SET DEFAULT nextval('transition_seq'::regclass);


--
-- Name: action action_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY action
    ADD CONSTRAINT action_pkey PRIMARY KEY (action);


--
-- Name: affectation_automatique affectation_automatique_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY affectation_automatique
    ADD CONSTRAINT affectation_automatique_pkey PRIMARY KEY (affectation_automatique);


--
-- Name: architecte architecte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY architecte
    ADD CONSTRAINT architecte_pkey PRIMARY KEY (architecte);


--
-- Name: arrondissement arrondissement_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY arrondissement
    ADD CONSTRAINT arrondissement_pkey PRIMARY KEY (arrondissement);


--
-- Name: autorite_competente autorite_competente_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY autorite_competente
    ADD CONSTRAINT autorite_competente_pkey PRIMARY KEY (autorite_competente);


--
-- Name: avis_consultation avis_consultation_code_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY avis_consultation
    ADD CONSTRAINT avis_consultation_code_unique UNIQUE (code);


--
-- Name: avis_consultation avis_consultation_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY avis_consultation
    ADD CONSTRAINT avis_consultation_pkey PRIMARY KEY (avis_consultation);


--
-- Name: avis_decision_nature avis_decision_nature_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY avis_decision_nature
    ADD CONSTRAINT avis_decision_nature_pkey PRIMARY KEY (avis_decision_nature);


--
-- Name: avis_decision avis_decision_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY avis_decision
    ADD CONSTRAINT avis_decision_pkey PRIMARY KEY (avis_decision);


--
-- Name: avis_decision_type avis_decision_type_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY avis_decision_type
    ADD CONSTRAINT avis_decision_type_pkey PRIMARY KEY (avis_decision_type);


--
-- Name: bible bible_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY bible
    ADD CONSTRAINT bible_pkey PRIMARY KEY (bible);


--
-- Name: blocnote blocnote_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY blocnote
    ADD CONSTRAINT blocnote_pkey PRIMARY KEY (blocnote);


--
-- Name: categorie_tiers_consulte categorie_tiers_consulte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY categorie_tiers_consulte
    ADD CONSTRAINT categorie_tiers_consulte_pkey PRIMARY KEY (categorie_tiers_consulte);


--
-- Name: cerfa cerfa_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY cerfa
    ADD CONSTRAINT cerfa_pkey PRIMARY KEY (cerfa);


--
-- Name: civilite civilite_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY civilite
    ADD CONSTRAINT civilite_pkey PRIMARY KEY (civilite);


--
-- Name: dossier_autorisation_type code_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation_type
    ADD CONSTRAINT code_unique UNIQUE (code);


--
-- Name: commission commission_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY commission
    ADD CONSTRAINT commission_pkey PRIMARY KEY (commission);


--
-- Name: commission_type commission_type_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY commission_type
    ADD CONSTRAINT commission_type_pkey PRIMARY KEY (commission_type);


--
-- Name: commune commune_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY commune
    ADD CONSTRAINT commune_pkey PRIMARY KEY (commune);


--
-- Name: compteur compteur_code_om_collectivite_om_validite_debut_om_validite_fin; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY compteur
    ADD CONSTRAINT compteur_code_om_collectivite_om_validite_debut_om_validite_fin UNIQUE (code, om_collectivite, om_validite_debut, om_validite_fin);


--
-- Name: compteur compteur_compteur; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY compteur
    ADD CONSTRAINT compteur_compteur PRIMARY KEY (compteur);


--
-- Name: consultation consultation_code_barres_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation
    ADD CONSTRAINT consultation_code_barres_key UNIQUE (code_barres);


--
-- Name: consultation_entrante consultation_entrante_dossier_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation_entrante
    ADD CONSTRAINT consultation_entrante_dossier_unique UNIQUE (dossier);


--
-- Name: consultation_entrante consultation_entrante_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation_entrante
    ADD CONSTRAINT consultation_entrante_pkey PRIMARY KEY (consultation_entrante);


--
-- Name: consultation consultation_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation
    ADD CONSTRAINT consultation_pkey PRIMARY KEY (consultation);


--
-- Name: contrainte contrainte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY contrainte
    ADD CONSTRAINT contrainte_pkey PRIMARY KEY (contrainte);


--
-- Name: demande_nature demande_nature_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande_nature
    ADD CONSTRAINT demande_nature_pkey PRIMARY KEY (demande_nature);


--
-- Name: demande demande_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_pkey PRIMARY KEY (demande);


--
-- Name: demande_type demande_type_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande_type
    ADD CONSTRAINT demande_type_pkey PRIMARY KEY (demande_type);


--
-- Name: demandeur demandeur_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demandeur
    ADD CONSTRAINT demandeur_pkey PRIMARY KEY (demandeur);


--
-- Name: departement departement_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY departement
    ADD CONSTRAINT departement_pkey PRIMARY KEY (departement);


--
-- Name: direction direction_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY direction
    ADD CONSTRAINT direction_pkey PRIMARY KEY (direction);


--
-- Name: division division_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY division
    ADD CONSTRAINT division_pkey PRIMARY KEY (division);


--
-- Name: document_numerise_nature document_numerise_nature_code_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise_nature
    ADD CONSTRAINT document_numerise_nature_code_key UNIQUE (code);


--
-- Name: document_numerise_nature document_numerise_nature_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise_nature
    ADD CONSTRAINT document_numerise_nature_pkey PRIMARY KEY (document_numerise_nature);


--
-- Name: document_numerise document_numerise_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise
    ADD CONSTRAINT document_numerise_pkey PRIMARY KEY (document_numerise);


--
-- Name: document_numerise_type_categorie document_numerise_type_categorie_code_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise_type_categorie
    ADD CONSTRAINT document_numerise_type_categorie_code_key UNIQUE (code);


--
-- Name: document_numerise_type_categorie document_numerise_type_categorie_libelle_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise_type_categorie
    ADD CONSTRAINT document_numerise_type_categorie_libelle_key UNIQUE (libelle);


--
-- Name: document_numerise_type_categorie document_numerise_type_categorie_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise_type_categorie
    ADD CONSTRAINT document_numerise_type_categorie_pkey PRIMARY KEY (document_numerise_type_categorie);


--
-- Name: document_numerise_type document_numerise_type_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise_type
    ADD CONSTRAINT document_numerise_type_pkey PRIMARY KEY (document_numerise_type);


--
-- Name: document_numerise document_numerise_uid_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise
    ADD CONSTRAINT document_numerise_uid_key UNIQUE (uid);


--
-- Name: donnees_techniques donnees_techniques_dossier_autorisation_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT donnees_techniques_dossier_autorisation_unique UNIQUE (dossier_autorisation);


--
-- Name: donnees_techniques donnees_techniques_dossier_instruction_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT donnees_techniques_dossier_instruction_unique UNIQUE (dossier_instruction);


--
-- Name: donnees_techniques donnees_techniques_lot_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT donnees_techniques_lot_unique UNIQUE (lot);


--
-- Name: donnees_techniques donnees_techniques_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT donnees_techniques_pkey PRIMARY KEY (donnees_techniques);


--
-- Name: dossier_autorisation_parcelle dossier_autorisation_parcelle_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation_parcelle
    ADD CONSTRAINT dossier_autorisation_parcelle_pkey PRIMARY KEY (dossier_autorisation_parcelle);


--
-- Name: dossier_autorisation dossier_autorisation_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation
    ADD CONSTRAINT dossier_autorisation_pkey PRIMARY KEY (dossier_autorisation);


--
-- Name: dossier_autorisation_type_detaille dossier_autorisation_type_detaille_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation_type_detaille
    ADD CONSTRAINT dossier_autorisation_type_detaille_pkey PRIMARY KEY (dossier_autorisation_type_detaille);


--
-- Name: dossier_autorisation_type dossier_autorisation_type_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation_type
    ADD CONSTRAINT dossier_autorisation_type_pkey PRIMARY KEY (dossier_autorisation_type);


--
-- Name: dossier_commission dossier_commission_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_commission
    ADD CONSTRAINT dossier_commission_pkey PRIMARY KEY (dossier_commission);


--
-- Name: dossier_contrainte dossier_contrainte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_contrainte
    ADD CONSTRAINT dossier_contrainte_pkey PRIMARY KEY (dossier_contrainte);


--
-- Name: dossier_geolocalisation dossier_geolocalisation_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_geolocalisation
    ADD CONSTRAINT dossier_geolocalisation_pkey PRIMARY KEY (dossier_geolocalisation);


--
-- Name: dossier_instruction_type dossier_instruction_type_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_instruction_type
    ADD CONSTRAINT dossier_instruction_type_pkey PRIMARY KEY (dossier_instruction_type);


--
-- Name: dossier_message dossier_message_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_message
    ADD CONSTRAINT dossier_message_pkey PRIMARY KEY (dossier_message);


--
-- Name: dossier_operateur dossier_operateur_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_operateur
    ADD CONSTRAINT dossier_operateur_pkey PRIMARY KEY (dossier_operateur);


--
-- Name: dossier_parcelle dossier_parcelle_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_parcelle
    ADD CONSTRAINT dossier_parcelle_pkey PRIMARY KEY (dossier_parcelle);


--
-- Name: dossier dossier_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_pkey PRIMARY KEY (dossier);


--
-- Name: etat_dossier_autorisation etat_dossier_autorisation_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY etat_dossier_autorisation
    ADD CONSTRAINT etat_dossier_autorisation_pkey PRIMARY KEY (etat_dossier_autorisation);


--
-- Name: etat etat_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY etat
    ADD CONSTRAINT etat_pkey PRIMARY KEY (etat);


--
-- Name: evenement evenement_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_pkey PRIMARY KEY (evenement);


--
-- Name: evenement_type_habilitation_tiers_consulte evenement_type_habilitation_tiers_consulte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement_type_habilitation_tiers_consulte
    ADD CONSTRAINT evenement_type_habilitation_tiers_consulte_pkey PRIMARY KEY (evenement_type_habilitation_tiers_consulte);


--
-- Name: famille_travaux famille_travaux_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY famille_travaux
    ADD CONSTRAINT famille_travaux_pkey PRIMARY KEY (famille_travaux);


--
-- Name: genre genre_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY genre
    ADD CONSTRAINT genre_pkey PRIMARY KEY (genre);


--
-- Name: groupe groupe_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY groupe
    ADD CONSTRAINT groupe_pkey PRIMARY KEY (groupe);


--
-- Name: habilitation_tiers_consulte habilitation_tiers_consulte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY habilitation_tiers_consulte
    ADD CONSTRAINT habilitation_tiers_consulte_pkey PRIMARY KEY (habilitation_tiers_consulte);


--
-- Name: instructeur instructeur_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instructeur
    ADD CONSTRAINT instructeur_pkey PRIMARY KEY (instructeur);


--
-- Name: instructeur_qualite instructeur_qualite_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instructeur_qualite
    ADD CONSTRAINT instructeur_qualite_pkey PRIMARY KEY (instructeur_qualite);


--
-- Name: instruction instruction_code_barres_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_code_barres_key UNIQUE (code_barres);


--
-- Name: instruction_notification_document instruction_notification_document_cle_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction_notification_document
    ADD CONSTRAINT instruction_notification_document_cle_key UNIQUE (cle);


--
-- Name: instruction_notification_document instruction_notification_document_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction_notification_document
    ADD CONSTRAINT instruction_notification_document_pkey PRIMARY KEY (instruction_notification_document);


--
-- Name: instruction_notification instruction_notification_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction_notification
    ADD CONSTRAINT instruction_notification_pkey PRIMARY KEY (instruction_notification);


--
-- Name: instruction instruction_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_pkey PRIMARY KEY (instruction);


--
-- Name: lien_categorie_tiers_consulte_om_collectivite lien_categorie_tiers_consulte_om_collectivite_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_categorie_tiers_consulte_om_collectivite
    ADD CONSTRAINT lien_categorie_tiers_consulte_om_collectivite_pkey PRIMARY KEY (lien_categorie_tiers_consulte_om_collectivite);


--
-- Name: lien_demande_demandeur lien_demande_demandeur_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_demande_demandeur
    ADD CONSTRAINT lien_demande_demandeur_pkey PRIMARY KEY (lien_demande_demandeur);


--
-- Name: lien_demande_type_dossier_instruction_type lien_demande_type_dossier_instruction_type_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_demande_type_dossier_instruction_type
    ADD CONSTRAINT lien_demande_type_dossier_instruction_type_pkey PRIMARY KEY (lien_demande_type_dossier_instruction_type);


--
-- Name: lien_demande_type_etat lien_demande_type_etat_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_demande_type_etat
    ADD CONSTRAINT lien_demande_type_etat_pkey PRIMARY KEY (lien_demande_type_etat);


--
-- Name: lien_dit_nature_travaux lien_dit_nature_travaux_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dit_nature_travaux
    ADD CONSTRAINT lien_dit_nature_travaux_pkey PRIMARY KEY (lien_dit_nature_travaux);


--
-- Name: lien_document_n_type_d_i_t lien_document_n_type_d_i_t_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_document_n_type_d_i_t
    ADD CONSTRAINT lien_document_n_type_d_i_t_pkey PRIMARY KEY (lien_document_n_type_d_i_t);


--
-- Name: lien_document_numerise_type_instructeur_qualite lien_document_numerise_type_instructeur_qualite_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_document_numerise_type_instructeur_qualite
    ADD CONSTRAINT lien_document_numerise_type_instructeur_qualite_pkey PRIMARY KEY (lien_document_numerise_type_instructeur_qualite);


--
-- Name: lien_donnees_techniques_moyen_retenu_juge lien_donnees_techniques_moyen_retenu_juge_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_donnees_techniques_moyen_retenu_juge
    ADD CONSTRAINT lien_donnees_techniques_moyen_retenu_juge_pkey PRIMARY KEY (lien_donnees_techniques_moyen_retenu_juge);


--
-- Name: lien_donnees_techniques_moyen_souleve lien_donnees_techniques_moyen_souleve_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_donnees_techniques_moyen_souleve
    ADD CONSTRAINT lien_donnees_techniques_moyen_souleve_pkey PRIMARY KEY (lien_donnees_techniques_moyen_souleve);


--
-- Name: lien_dossier_autorisation_demandeur lien_dossier_autorisation_demandeur_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_autorisation_demandeur
    ADD CONSTRAINT lien_dossier_autorisation_demandeur_pkey PRIMARY KEY (lien_dossier_autorisation_demandeur);


--
-- Name: lien_dossier_demandeur lien_dossier_demandeur_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_demandeur
    ADD CONSTRAINT lien_dossier_demandeur_pkey PRIMARY KEY (lien_dossier_demandeur);


--
-- Name: lien_dossier_dossier lien_dossier_dossier_dossier_src_dossier_cible_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_dossier
    ADD CONSTRAINT lien_dossier_dossier_dossier_src_dossier_cible_key UNIQUE (dossier_src, dossier_cible);


--
-- Name: lien_dossier_dossier lien_dossier_dossier_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_dossier
    ADD CONSTRAINT lien_dossier_dossier_pkey PRIMARY KEY (lien_dossier_dossier);


--
-- Name: lien_dossier_instruction_type_categorie_tiers lien_dossier_instruction_type_categorie_tiers_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_instruction_type_categorie_tiers
    ADD CONSTRAINT lien_dossier_instruction_type_categorie_tiers_pkey PRIMARY KEY (lien_dossier_instruction_type_categorie_tiers);


--
-- Name: lien_dossier_instruction_type_evenement lien_dossier_instruction_type_evenement_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_instruction_type_evenement
    ADD CONSTRAINT lien_dossier_instruction_type_evenement_pkey PRIMARY KEY (lien_dossier_instruction_type_evenement);


--
-- Name: lien_dit_nature_travaux lien_dossier_instruction_type_nature_travaux_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dit_nature_travaux
    ADD CONSTRAINT lien_dossier_instruction_type_nature_travaux_unique UNIQUE (dossier_instruction_type, nature_travaux);


--
-- Name: lien_dossier_nature_travaux lien_dossier_nature_travaux_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_nature_travaux
    ADD CONSTRAINT lien_dossier_nature_travaux_pkey PRIMARY KEY (lien_dossier_nature_travaux);


--
-- Name: lien_dossier_nature_travaux lien_dossier_nature_travaux_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_nature_travaux
    ADD CONSTRAINT lien_dossier_nature_travaux_unique UNIQUE (dossier, nature_travaux);


--
-- Name: lien_dossier_tiers lien_dossier_tiers_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_tiers
    ADD CONSTRAINT lien_dossier_tiers_pkey PRIMARY KEY (lien_dossier_tiers);


--
-- Name: lien_dossier_tiers lien_dossier_tiers_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_tiers
    ADD CONSTRAINT lien_dossier_tiers_unique UNIQUE (dossier, tiers);


--
-- Name: lien_habilitation_tiers_consulte_commune lien_habilitation_tiers_consulte_commune_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_commune
    ADD CONSTRAINT lien_habilitation_tiers_consulte_commune_pkey PRIMARY KEY (lien_habilitation_tiers_consulte_commune);


--
-- Name: lien_habilitation_tiers_consulte_departement lien_habilitation_tiers_consulte_departement_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_departement
    ADD CONSTRAINT lien_habilitation_tiers_consulte_departement_pkey PRIMARY KEY (lien_habilitation_tiers_consulte_departement);


--
-- Name: lien_habilitation_tiers_consulte_specialite_tiers_consulte lien_habilitation_tiers_consulte_specialite_tiers_consulte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_specialite_tiers_consulte
    ADD CONSTRAINT lien_habilitation_tiers_consulte_specialite_tiers_consulte_pkey PRIMARY KEY (lien_habilitation_tiers_consulte_specialite_tiers_consulte);


--
-- Name: lien_id_interne_uid_externe lien_id_interne_uid_externe_object_id_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_id_interne_uid_externe
    ADD CONSTRAINT lien_id_interne_uid_externe_object_id_key UNIQUE (external_uid, object, object_id, category);


--
-- Name: lien_id_interne_uid_externe lien_id_interne_uid_externe_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_id_interne_uid_externe
    ADD CONSTRAINT lien_id_interne_uid_externe_pkey PRIMARY KEY (lien_id_interne_uid_externe);


--
-- Name: lien_lot_demandeur lien_lot_demandeur_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_lot_demandeur
    ADD CONSTRAINT lien_lot_demandeur_pkey PRIMARY KEY (lien_lot_demandeur);


--
-- Name: lien_motif_consultation_om_collectivite lien_motif_consultation_om_collectivite_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_motif_consultation_om_collectivite
    ADD CONSTRAINT lien_motif_consultation_om_collectivite_pkey PRIMARY KEY (lien_motif_consultation_om_collectivite);


--
-- Name: lien_om_profil_groupe lien_om_profil_groupe_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_om_profil_groupe
    ADD CONSTRAINT lien_om_profil_groupe_pkey PRIMARY KEY (lien_om_profil_groupe);


--
-- Name: lien_om_utilisateur_groupe lien_om_utilisateur_groupe_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_om_utilisateur_groupe
    ADD CONSTRAINT lien_om_utilisateur_groupe_pkey PRIMARY KEY (lien_om_utilisateur_groupe);


--
-- Name: lien_om_utilisateur_tiers_consulte lien_om_utilisateur_tiers_consulte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_om_utilisateur_tiers_consulte
    ADD CONSTRAINT lien_om_utilisateur_tiers_consulte_pkey PRIMARY KEY (lien_om_utilisateur_tiers_consulte);


--
-- Name: lien_service_om_utilisateur lien_service_om_utilisateur_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_service_om_utilisateur
    ADD CONSTRAINT lien_service_om_utilisateur_pkey PRIMARY KEY (lien_service_om_utilisateur);


--
-- Name: lien_service_service_categorie lien_service_service_categorie_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_service_service_categorie
    ADD CONSTRAINT lien_service_service_categorie_pkey PRIMARY KEY (lien_service_service_categorie);


--
-- Name: lien_sig_contrainte_dossier_instruction_type lien_sig_contrainte_dossier_instruction_type_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_dossier_instruction_type
    ADD CONSTRAINT lien_sig_contrainte_dossier_instruction_type_pkey PRIMARY KEY (lien_sig_contrainte_dossier_instruction_type);


--
-- Name: lien_sig_contrainte_evenement lien_sig_contrainte_evenement_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_evenement
    ADD CONSTRAINT lien_sig_contrainte_evenement_pkey PRIMARY KEY (lien_sig_contrainte_evenement);


--
-- Name: lien_sig_contrainte_evenement lien_sig_contrainte_evenement_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_evenement
    ADD CONSTRAINT lien_sig_contrainte_evenement_unique UNIQUE (sig_contrainte, evenement);


--
-- Name: lien_sig_contrainte_om_collectivite lien_sig_contrainte_om_collectivite_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_om_collectivite
    ADD CONSTRAINT lien_sig_contrainte_om_collectivite_pkey PRIMARY KEY (lien_sig_contrainte_om_collectivite);


--
-- Name: lien_sig_contrainte_sig_attribut lien_sig_contrainte_sig_attribut_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_sig_attribut
    ADD CONSTRAINT lien_sig_contrainte_sig_attribut_pkey PRIMARY KEY (lien_sig_contrainte_sig_attribut);


--
-- Name: lien_type_di_type_di lien_type_di_type_di_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_type_di_type_di
    ADD CONSTRAINT lien_type_di_type_di_pkey PRIMARY KEY (lien_type_di_type_di);


--
-- Name: lot lot_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lot
    ADD CONSTRAINT lot_pkey PRIMARY KEY (lot);


--
-- Name: motif_consultation motif_consultation_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY motif_consultation
    ADD CONSTRAINT motif_consultation_pkey PRIMARY KEY (motif_consultation);


--
-- Name: moyen_retenu_juge moyen_retenu_juge_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY moyen_retenu_juge
    ADD CONSTRAINT moyen_retenu_juge_pkey PRIMARY KEY (moyen_retenu_juge);


--
-- Name: moyen_souleve moyen_souleve_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY moyen_souleve
    ADD CONSTRAINT moyen_souleve_pkey PRIMARY KEY (moyen_souleve);


--
-- Name: nature_travaux nature_travaux_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY nature_travaux
    ADD CONSTRAINT nature_travaux_pkey PRIMARY KEY (nature_travaux);


--
-- Name: num_bordereau num_bordereau_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY num_bordereau
    ADD CONSTRAINT num_bordereau_pkey PRIMARY KEY (num_bordereau);


--
-- Name: num_dossier num_dossier_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY num_dossier
    ADD CONSTRAINT num_dossier_pkey PRIMARY KEY (num_dossier);


--
-- Name: objet_recours objet_recours_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY objet_recours
    ADD CONSTRAINT objet_recours_pkey PRIMARY KEY (objet_recours);


--
-- Name: lien_om_profil_groupe om_profil_groupe_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_om_profil_groupe
    ADD CONSTRAINT om_profil_groupe_key UNIQUE (om_profil, groupe);


--
-- Name: pec_metier pec_metier_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY pec_metier
    ADD CONSTRAINT pec_metier_pkey PRIMARY KEY (pec_metier);


--
-- Name: phase phase_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY phase
    ADD CONSTRAINT phase_pkey PRIMARY KEY (phase);


--
-- Name: quartier quartier_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY quartier
    ADD CONSTRAINT quartier_pkey PRIMARY KEY (quartier);


--
-- Name: rapport_instruction rapport_instruction_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY rapport_instruction
    ADD CONSTRAINT rapport_instruction_pkey PRIMARY KEY (rapport_instruction);


--
-- Name: region region_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY region
    ADD CONSTRAINT region_pkey PRIMARY KEY (region);


--
-- Name: regle regle_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY regle
    ADD CONSTRAINT regle_pkey PRIMARY KEY (regle);


--
-- Name: service_categorie service_categorie_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY service_categorie
    ADD CONSTRAINT service_categorie_pkey PRIMARY KEY (service_categorie);


--
-- Name: lien_service_om_utilisateur service_om_utilisateur_unique; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_service_om_utilisateur
    ADD CONSTRAINT service_om_utilisateur_unique UNIQUE (om_utilisateur, service);


--
-- Name: service service_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY service
    ADD CONSTRAINT service_pkey PRIMARY KEY (service);


--
-- Name: sig_attribut sig_attribut_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY sig_attribut
    ADD CONSTRAINT sig_attribut_pkey PRIMARY KEY (sig_attribut);


--
-- Name: sig_contrainte sig_contrainte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY sig_contrainte
    ADD CONSTRAINT sig_contrainte_pkey PRIMARY KEY (sig_contrainte);


--
-- Name: sig_couche sig_couche_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY sig_couche
    ADD CONSTRAINT sig_couche_pkey PRIMARY KEY (sig_couche);


--
-- Name: sig_groupe sig_groupe_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY sig_groupe
    ADD CONSTRAINT sig_groupe_pkey PRIMARY KEY (sig_groupe);


--
-- Name: sig_sousgroupe sig_sousgroupe_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY sig_sousgroupe
    ADD CONSTRAINT sig_sousgroupe_pkey PRIMARY KEY (sig_sousgroupe);


--
-- Name: signataire_arrete signataire_arrete_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY signataire_arrete
    ADD CONSTRAINT signataire_arrete_pkey PRIMARY KEY (signataire_arrete);


--
-- Name: signataire_habilitation signataire_habilitation_code_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY signataire_habilitation
    ADD CONSTRAINT signataire_habilitation_code_key UNIQUE (code);


--
-- Name: signataire_habilitation signataire_habilitation_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY signataire_habilitation
    ADD CONSTRAINT signataire_habilitation_pkey PRIMARY KEY (signataire_habilitation);


--
-- Name: specialite_tiers_consulte specialite_tiers_consulte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY specialite_tiers_consulte
    ADD CONSTRAINT specialite_tiers_consulte_pkey PRIMARY KEY (specialite_tiers_consulte);


--
-- Name: storage storage_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY storage
    ADD CONSTRAINT storage_pkey PRIMARY KEY (storage);


--
-- Name: task task_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY task
    ADD CONSTRAINT task_pkey PRIMARY KEY (task);


--
-- Name: taxe_amenagement taxe_amenagement_om_collectivite_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY taxe_amenagement
    ADD CONSTRAINT taxe_amenagement_om_collectivite_key UNIQUE (om_collectivite);


--
-- Name: taxe_amenagement taxe_amenagement_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY taxe_amenagement
    ADD CONSTRAINT taxe_amenagement_pkey PRIMARY KEY (taxe_amenagement);


--
-- Name: tiers_consulte tiers_consulte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY tiers_consulte
    ADD CONSTRAINT tiers_consulte_pkey PRIMARY KEY (tiers_consulte);


--
-- Name: transition transition_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY transition
    ADD CONSTRAINT transition_pkey PRIMARY KEY (transition);


--
-- Name: type_habilitation_tiers_consulte type_habilitation_tiers_consulte_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY type_habilitation_tiers_consulte
    ADD CONSTRAINT type_habilitation_tiers_consulte_pkey PRIMARY KEY (type_habilitation_tiers_consulte);


--
-- Name: affectation_automatique_communes_collectivite_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX affectation_automatique_communes_collectivite_idx ON affectation_automatique USING btree (communes, om_collectivite);


--
-- Name: affectation_automatique_communes_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX affectation_automatique_communes_hash ON affectation_automatique USING hash (communes);


--
-- Name: affectation_automatique_communes_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX affectation_automatique_communes_idx ON affectation_automatique USING btree (communes);


--
-- Name: affectation_automatique_om_collectivite_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX affectation_automatique_om_collectivite_hash ON affectation_automatique USING hash (om_collectivite);


--
-- Name: affectation_automatique_om_collectivite_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX affectation_automatique_om_collectivite_idx ON affectation_automatique USING btree (om_collectivite);


--
-- Name: avis_decision_null_dli_in_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX avis_decision_null_dli_in_idx ON dossier USING btree (((avis_decision IS NULL)), date_limite, incomplet_notifie) WHERE ((avis_decision IS NULL) AND (date_limite IS NOT NULL));


--
-- Name: avis_decision_null_dliin_in_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX avis_decision_null_dliin_in_idx ON dossier USING btree (((avis_decision IS NULL)), date_limite_incompletude, incomplet_notifie) WHERE ((avis_decision IS NULL) AND (date_limite_incompletude IS NOT NULL));


--
-- Name: blocnote_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX blocnote_dossier ON blocnote USING btree (dossier);


--
-- Name: blocnote_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX blocnote_dossier_hash ON blocnote USING hash (dossier);


--
-- Name: commune_dep; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX commune_dep ON commune USING btree (dep);


--
-- Name: compteur_code; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX compteur_code ON compteur USING btree (code);


--
-- Name: compteur_om_collectivite; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX compteur_om_collectivite ON compteur USING btree (om_collectivite);


--
-- Name: compteur_om_collectivite_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX compteur_om_collectivite_hash ON compteur USING hash (om_collectivite);


--
-- Name: compteur_om_validite_debut; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX compteur_om_validite_debut ON compteur USING btree (om_validite_debut);


--
-- Name: compteur_om_validite_fin; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX compteur_om_validite_fin ON compteur USING btree (om_validite_fin);


--
-- Name: consultation_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX consultation_dossier ON consultation USING btree (dossier);


--
-- Name: consultation_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX consultation_dossier_hash ON consultation USING hash (dossier);


--
-- Name: consultation_entrante_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX consultation_entrante_dossier ON consultation_entrante USING btree (dossier);


--
-- Name: consultation_entrante_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX consultation_entrante_dossier_hash ON consultation_entrante USING hash (dossier);


--
-- Name: consultation_entrante_service_consultant_id; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX consultation_entrante_service_consultant_id ON consultation_entrante USING btree (service_consultant_id);


--
-- Name: consultation_lu_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX consultation_lu_idx ON consultation USING btree (lu);


--
-- Name: contrainte_libelle; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX contrainte_libelle ON contrainte USING btree (libelle);


--
-- Name: datd_dossier_autorisation_type_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX datd_dossier_autorisation_type_hash ON dossier_autorisation_type_detaille USING hash (dossier_autorisation_type);


--
-- Name: demande_dossier_autorisation; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX demande_dossier_autorisation ON demande USING btree (dossier_autorisation);


--
-- Name: demande_dossier_autorisation_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX demande_dossier_autorisation_hash ON demande USING hash (dossier_autorisation);


--
-- Name: demande_dossier_instruction; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX demande_dossier_instruction ON demande USING btree (dossier_instruction);


--
-- Name: demande_dossier_instruction_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX demande_dossier_instruction_hash ON demande USING hash (dossier_instruction);


--
-- Name: demandeur_type_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX demandeur_type_idx ON demandeur USING hash (lower((type_demandeur)::text));


--
-- Name: departement_dep; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX departement_dep ON departement USING btree (dep);


--
-- Name: dit_dossier_autorisation_type_detaille_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dit_dossier_autorisation_type_detaille_hash ON dossier_instruction_type USING hash (dossier_autorisation_type_detaille);


--
-- Name: document_numerise_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX document_numerise_dossier ON document_numerise USING btree (dossier);


--
-- Name: document_numerise_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX document_numerise_dossier_hash ON document_numerise USING hash (dossier);


--
-- Name: donnees_techniques_dossier_instruction_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX donnees_techniques_dossier_instruction_hash ON donnees_techniques USING hash (dossier_instruction);


--
-- Name: donnees_techniques_dossier_instruction_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX donnees_techniques_dossier_instruction_idx ON donnees_techniques USING btree (dossier_instruction);


--
-- Name: dossier_a_qualifier_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_a_qualifier_idx ON dossier USING btree (a_qualifier);


--
-- Name: dossier_autorisation_dad_etat_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_autorisation_dad_etat_idx ON dossier_autorisation USING btree (dossier_autorisation_type_detaille, etat_dossier_autorisation);


--
-- Name: dossier_autorisation_etat_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_autorisation_etat_idx ON dossier_autorisation USING hash (etat_dossier_autorisation);


--
-- Name: dossier_autorisation_nl; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_autorisation_nl ON dossier_autorisation USING btree (dossier_autorisation);


--
-- Name: dossier_autorisation_nl_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_autorisation_nl_hash ON dossier_autorisation USING hash (dossier_autorisation);


--
-- Name: dossier_autorisation_parcelle_dossier_autorisation; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_autorisation_parcelle_dossier_autorisation ON dossier_autorisation_parcelle USING btree (dossier_autorisation);


--
-- Name: dossier_autorisation_parcelle_dossier_autorisation_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_autorisation_parcelle_dossier_autorisation_hash ON dossier_autorisation_parcelle USING hash (dossier_autorisation);


--
-- Name: dossier_autorisation_type_detaille_dossier_autorisation_type; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_autorisation_type_detaille_dossier_autorisation_type ON dossier_autorisation_type_detaille USING btree (dossier_autorisation_type);


--
-- Name: dossier_autorisation_type_detaille_dossier_platau; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_autorisation_type_detaille_dossier_platau ON dossier_autorisation_type_detaille USING btree (dossier_platau);


--
-- Name: dossier_collectivite; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_collectivite ON dossier USING btree (om_collectivite);


--
-- Name: dossier_collectivite_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_collectivite_hash ON dossier USING hash (om_collectivite);


--
-- Name: dossier_commission_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_commission_dossier ON dossier_commission USING btree (dossier);


--
-- Name: dossier_commission_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_commission_dossier_hash ON dossier_commission USING hash (dossier);


--
-- Name: dossier_commune; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_commune ON dossier USING btree (commune);


--
-- Name: dossier_commune_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_commune_hash ON dossier USING hash (commune);


--
-- Name: dossier_contrainte_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_contrainte_dossier ON dossier_contrainte USING btree (dossier);


--
-- Name: dossier_contrainte_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_contrainte_dossier_hash ON dossier_contrainte USING hash (dossier);


--
-- Name: dossier_date_depot_desc_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_date_depot_desc_idx ON dossier USING btree (date_depot DESC NULLS LAST, dossier);


--
-- Name: dossier_date_depot_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_date_depot_idx ON dossier USING btree (date_depot, dossier);


--
-- Name: dossier_dossier_autorisation; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_dossier_autorisation ON dossier USING btree (dossier_autorisation);


--
-- Name: dossier_dossier_autorisation_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_dossier_autorisation_hash ON dossier USING hash (dossier_autorisation);


--
-- Name: dossier_dossier_instruction_type; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_dossier_instruction_type ON dossier USING btree (dossier_instruction_type);


--
-- Name: dossier_dossier_instruction_type_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_dossier_instruction_type_hash ON dossier USING hash (dossier_instruction_type);


--
-- Name: dossier_dossier_parent; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_dossier_parent ON dossier USING btree (dossier_parent);


--
-- Name: dossier_dossier_parent_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_dossier_parent_hash ON dossier USING hash (dossier_parent);


--
-- Name: dossier_etat_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_etat_idx ON dossier USING btree (etat);


--
-- Name: dossier_etat_idx_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_etat_idx_hash ON dossier USING hash (etat);


--
-- Name: dossier_geolocalisation_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_geolocalisation_dossier ON dossier_geolocalisation USING btree (dossier);


--
-- Name: dossier_geolocalisation_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_geolocalisation_dossier_hash ON dossier_geolocalisation USING hash (dossier);


--
-- Name: dossier_instruction_type_dossier_autorisation_type_detaille; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_instruction_type_dossier_autorisation_type_detaille ON dossier_instruction_type USING btree (dossier_autorisation_type_detaille);


--
-- Name: dossier_message_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_message_dossier ON dossier_message USING btree (dossier);


--
-- Name: dossier_message_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_message_dossier_hash ON dossier_message USING hash (dossier);


--
-- Name: dossier_min_date_decision_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_min_date_decision_idx ON dossier USING btree (date_decision);


--
-- Name: dossier_operateur_dossier_instruction; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_operateur_dossier_instruction ON dossier_operateur USING btree (dossier_instruction);


--
-- Name: dossier_operateur_dossier_instruction_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_operateur_dossier_instruction_hash ON dossier_operateur USING hash (dossier_instruction);


--
-- Name: dossier_parcelle_dossier_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_parcelle_dossier_idx ON dossier_parcelle USING btree (dossier);


--
-- Name: dossier_parcelle_dossier_idx_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX dossier_parcelle_dossier_idx_hash ON dossier_parcelle USING hash (dossier);


--
-- Name: evenement_type; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX evenement_type ON evenement USING btree (type);


--
-- Name: habilitation_tiers_consulte_debut_validite; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX habilitation_tiers_consulte_debut_validite ON habilitation_tiers_consulte USING btree (om_validite_debut);


--
-- Name: habilitation_tiers_consulte_fin_validite; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX habilitation_tiers_consulte_fin_validite ON habilitation_tiers_consulte USING btree (om_validite_fin);


--
-- Name: habilitation_tiers_consulte_tiers_consulte; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX habilitation_tiers_consulte_tiers_consulte ON habilitation_tiers_consulte USING btree (tiers_consulte);


--
-- Name: habilitation_tiers_consulte_tiers_consulte_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX habilitation_tiers_consulte_tiers_consulte_hash ON habilitation_tiers_consulte USING hash (tiers_consulte);


--
-- Name: habilitation_tiers_consulte_type_habilitation_tiers_consulte; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX habilitation_tiers_consulte_type_habilitation_tiers_consulte ON habilitation_tiers_consulte USING btree (type_habilitation_tiers_consulte);


--
-- Name: htc_type_habilitation_tiers_consulte_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX htc_type_habilitation_tiers_consulte_hash ON habilitation_tiers_consulte USING hash (type_habilitation_tiers_consulte);


--
-- Name: instruction_date_retour_rar_evenement_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX instruction_date_retour_rar_evenement_idx ON instruction USING btree (date_retour_rar, evenement);


--
-- Name: instruction_dossier_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX instruction_dossier_idx ON instruction USING btree (dossier);


--
-- Name: instruction_dossier_idx_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX instruction_dossier_idx_hash ON instruction USING hash (dossier);


--
-- Name: lctcoc_categorie_tiers_consulte_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lctcoc_categorie_tiers_consulte_hash ON lien_categorie_tiers_consulte_om_collectivite USING hash (categorie_tiers_consulte);


--
-- Name: ldit_categorie_tiers_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX ldit_categorie_tiers_hash ON lien_dossier_instruction_type_categorie_tiers USING hash (categorie_tiers);


--
-- Name: lditct_dossier_instruction_type_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lditct_dossier_instruction_type_hash ON lien_dossier_instruction_type_categorie_tiers USING hash (dossier_instruction_type);


--
-- Name: lhtcc_habilitation_tiers_consulte_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lhtcc_habilitation_tiers_consulte_hash ON lien_habilitation_tiers_consulte_commune USING hash (habilitation_tiers_consulte);


--
-- Name: lhtcd_habilitation_tiers_consulte_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lhtcd_habilitation_tiers_consulte_hash ON lien_habilitation_tiers_consulte_departement USING hash (habilitation_tiers_consulte);


--
-- Name: lhtcstc_habilitation_tiers_consulte_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lhtcstc_habilitation_tiers_consulte_hash ON lien_habilitation_tiers_consulte_specialite_tiers_consulte USING hash (habilitation_tiers_consulte);


--
-- Name: lhtcstc_specialite_tiers_consulte_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lhtcstc_specialite_tiers_consulte_hash ON lien_habilitation_tiers_consulte_specialite_tiers_consulte USING hash (specialite_tiers_consulte);


--
-- Name: lien_cat_tiers_collectivite_collectivite; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_cat_tiers_collectivite_collectivite ON lien_categorie_tiers_consulte_om_collectivite USING btree (om_collectivite);


--
-- Name: lien_cat_tiers_collectivite_collectivite_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_cat_tiers_collectivite_collectivite_hash ON lien_categorie_tiers_consulte_om_collectivite USING hash (om_collectivite);


--
-- Name: lien_categorie_tiers_consulte_om_collectivite_categorie_tiers_c; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_categorie_tiers_consulte_om_collectivite_categorie_tiers_c ON lien_categorie_tiers_consulte_om_collectivite USING btree (categorie_tiers_consulte);


--
-- Name: lien_dit_categorie_tiers_ajout_auto; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dit_categorie_tiers_ajout_auto ON lien_dossier_instruction_type_categorie_tiers USING btree (ajout_automatique) WHERE (ajout_automatique IS TRUE);


--
-- Name: lien_dit_nature_travaux_dit; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dit_nature_travaux_dit ON lien_dit_nature_travaux USING btree (dossier_instruction_type);


--
-- Name: lien_dit_nature_travaux_dit_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dit_nature_travaux_dit_hash ON lien_dit_nature_travaux USING hash (dossier_instruction_type);


--
-- Name: lien_dit_nature_travaux_nt; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dit_nature_travaux_nt ON lien_dit_nature_travaux USING btree (nature_travaux);


--
-- Name: lien_dit_nature_travaux_nt_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dit_nature_travaux_nt_hash ON lien_dit_nature_travaux USING hash (nature_travaux);


--
-- Name: lien_dossier_autorisation_demandeur_demandeur_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_autorisation_demandeur_demandeur_idx ON lien_dossier_autorisation_demandeur USING hash (demandeur);


--
-- Name: lien_dossier_autorisation_demandeur_dossier_autorisation_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_autorisation_demandeur_dossier_autorisation_idx ON lien_dossier_autorisation_demandeur USING hash (dossier_autorisation);


--
-- Name: lien_dossier_autorisation_demandeur_petitionnaire_principal_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_autorisation_demandeur_petitionnaire_principal_idx ON lien_dossier_autorisation_demandeur USING btree (dossier_autorisation, demandeur) WHERE (petitionnaire_principal IS TRUE);


--
-- Name: lien_dossier_demandeur_demandeur_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_demandeur_demandeur_idx ON lien_dossier_demandeur USING btree (demandeur);


--
-- Name: lien_dossier_demandeur_demandeur_idx_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_demandeur_demandeur_idx_hash ON lien_dossier_demandeur USING hash (demandeur);


--
-- Name: lien_dossier_demandeur_demandeur_petitionnaire_principal_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_demandeur_demandeur_petitionnaire_principal_idx ON lien_dossier_demandeur USING btree (petitionnaire_principal);


--
-- Name: lien_dossier_demandeur_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_demandeur_dossier ON lien_dossier_demandeur USING btree (dossier);


--
-- Name: lien_dossier_demandeur_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_demandeur_dossier_hash ON lien_dossier_demandeur USING hash (dossier);


--
-- Name: lien_dossier_demandeur_dossier_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_demandeur_dossier_idx ON lien_dossier_demandeur USING btree (dossier, petitionnaire_principal);


--
-- Name: lien_dossier_dossier_dossier_src; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_dossier_dossier_src ON lien_dossier_dossier USING btree (dossier_src);


--
-- Name: lien_dossier_dossier_dossier_src_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_dossier_dossier_src_hash ON lien_dossier_dossier USING hash (dossier_src);


--
-- Name: lien_dossier_instruction_type_categorie_tiers_categorie_auto; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_instruction_type_categorie_tiers_categorie_auto ON lien_dossier_instruction_type_categorie_tiers USING btree (categorie_tiers, ajout_automatique);


--
-- Name: lien_dossier_instruction_type_categorie_tiers_categorie_tiers; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_instruction_type_categorie_tiers_categorie_tiers ON lien_dossier_instruction_type_categorie_tiers USING btree (categorie_tiers);


--
-- Name: lien_dossier_instruction_type_categorie_tiers_dossier_instructi; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_instruction_type_categorie_tiers_dossier_instructi ON lien_dossier_instruction_type_categorie_tiers USING btree (dossier_instruction_type);


--
-- Name: lien_dossier_nature_travaux_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_nature_travaux_dossier ON lien_dossier_nature_travaux USING btree (dossier);


--
-- Name: lien_dossier_nature_travaux_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_nature_travaux_dossier_hash ON lien_dossier_nature_travaux USING hash (dossier);


--
-- Name: lien_dossier_nature_travaux_nt; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_nature_travaux_nt ON lien_dossier_nature_travaux USING btree (nature_travaux);


--
-- Name: lien_dossier_nature_travaux_nt_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_nature_travaux_nt_hash ON lien_dossier_nature_travaux USING hash (nature_travaux);


--
-- Name: lien_dossier_tiers_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_tiers_dossier ON lien_dossier_tiers USING btree (dossier);


--
-- Name: lien_dossier_tiers_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_tiers_dossier_hash ON lien_dossier_tiers USING hash (dossier);


--
-- Name: lien_dossier_tiers_tiers; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_tiers_tiers ON lien_dossier_tiers USING btree (tiers);


--
-- Name: lien_dossier_tiers_tiers_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_dossier_tiers_tiers_hash ON lien_dossier_tiers USING hash (tiers);


--
-- Name: lien_habilitation_tiers_consulte_commune_commune; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_habilitation_tiers_consulte_commune_commune ON lien_habilitation_tiers_consulte_commune USING btree (commune);


--
-- Name: lien_habilitation_tiers_consulte_commune_commune_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_habilitation_tiers_consulte_commune_commune_hash ON lien_habilitation_tiers_consulte_commune USING hash (commune);


--
-- Name: lien_habilitation_tiers_consulte_commune_habilitation_tiers_con; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_habilitation_tiers_consulte_commune_habilitation_tiers_con ON lien_habilitation_tiers_consulte_commune USING btree (habilitation_tiers_consulte);


--
-- Name: lien_habilitation_tiers_consulte_departement_departement; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_habilitation_tiers_consulte_departement_departement ON lien_habilitation_tiers_consulte_departement USING btree (departement);


--
-- Name: lien_habilitation_tiers_consulte_departement_departement_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_habilitation_tiers_consulte_departement_departement_hash ON lien_habilitation_tiers_consulte_departement USING hash (departement);


--
-- Name: lien_habilitation_tiers_consulte_departement_habilitation_tiers; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_habilitation_tiers_consulte_departement_habilitation_tiers ON lien_habilitation_tiers_consulte_departement USING btree (habilitation_tiers_consulte);


--
-- Name: lien_habilitation_tiers_consulte_specialite_tiers_consulte_habi; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_habilitation_tiers_consulte_specialite_tiers_consulte_habi ON lien_habilitation_tiers_consulte_specialite_tiers_consulte USING btree (habilitation_tiers_consulte);


--
-- Name: lien_habilitation_tiers_consulte_specialite_tiers_consulte_spec; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_habilitation_tiers_consulte_specialite_tiers_consulte_spec ON lien_habilitation_tiers_consulte_specialite_tiers_consulte USING btree (specialite_tiers_consulte);


--
-- Name: lien_id_interne_uid_externe_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_id_interne_uid_externe_dossier ON lien_id_interne_uid_externe USING btree (dossier);


--
-- Name: lien_id_interne_uid_externe_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_id_interne_uid_externe_dossier_hash ON lien_id_interne_uid_externe USING hash (dossier);


--
-- Name: lien_id_interne_uid_externe_external_uid_object_object_id_categ; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_id_interne_uid_externe_external_uid_object_object_id_categ ON lien_id_interne_uid_externe USING btree (external_uid, object, object_id, category);


--
-- Name: lien_id_interne_uid_externe_object_object_id_category; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_id_interne_uid_externe_object_object_id_category ON lien_id_interne_uid_externe USING btree (object, object_id, category);


--
-- Name: lien_motif_consultation_om_collectivite_motif_consultation; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_motif_consultation_om_collectivite_motif_consultation ON lien_motif_consultation_om_collectivite USING btree (motif_consultation);


--
-- Name: lien_motif_consultation_om_collectivite_motif_consultation_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_motif_consultation_om_collectivite_motif_consultation_hash ON lien_motif_consultation_om_collectivite USING hash (motif_consultation);


--
-- Name: lien_motif_consultation_om_collectivite_om_collectivite; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_motif_consultation_om_collectivite_om_collectivite ON lien_motif_consultation_om_collectivite USING btree (om_collectivite);


--
-- Name: lien_motif_consultation_om_collectivite_om_collectivite_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_motif_consultation_om_collectivite_om_collectivite_hash ON lien_motif_consultation_om_collectivite USING hash (om_collectivite);


--
-- Name: lien_om_utilisateur_tiers_consulte_om_utilisateur; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_om_utilisateur_tiers_consulte_om_utilisateur ON lien_om_utilisateur_tiers_consulte USING btree (om_utilisateur);


--
-- Name: lien_om_utilisateur_tiers_consulte_om_utilisateur_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_om_utilisateur_tiers_consulte_om_utilisateur_hash ON lien_om_utilisateur_tiers_consulte USING hash (om_utilisateur);


--
-- Name: lien_om_utilisateur_tiers_consulte_tiers_consulte; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_om_utilisateur_tiers_consulte_tiers_consulte ON lien_om_utilisateur_tiers_consulte USING btree (tiers_consulte);


--
-- Name: lien_om_utilisateur_tiers_consulte_tiers_consulte_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lien_om_utilisateur_tiers_consulte_tiers_consulte_hash ON lien_om_utilisateur_tiers_consulte USING hash (tiers_consulte);


--
-- Name: lot_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lot_dossier ON lot USING btree (dossier);


--
-- Name: lot_dossier_autorisation; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lot_dossier_autorisation ON lot USING btree (dossier_autorisation);


--
-- Name: lot_dossier_autorisation_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lot_dossier_autorisation_hash ON lot USING hash (dossier_autorisation);


--
-- Name: lot_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX lot_dossier_hash ON lot USING hash (dossier);


--
-- Name: motif_consultation_om_etat; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX motif_consultation_om_etat ON motif_consultation USING btree (om_etat);


--
-- Name: rapport_instruction_dossier_instruction; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX rapport_instruction_dossier_instruction ON rapport_instruction USING btree (dossier_instruction);


--
-- Name: rapport_instruction_dossier_instruction_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX rapport_instruction_dossier_instruction_hash ON rapport_instruction USING hash (dossier_instruction);


--
-- Name: sig_contrainte_libelle; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX sig_contrainte_libelle ON sig_contrainte USING btree (libelle);


--
-- Name: task_dossier; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX task_dossier ON task USING btree (dossier);


--
-- Name: task_dossier_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX task_dossier_hash ON task USING hash (dossier);


--
-- Name: task_object_id; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX task_object_id ON task USING btree (object_id);


--
-- Name: task_object_id_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX task_object_id_hash ON task USING hash (object_id);


--
-- Name: tiers_accepte_notification; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX tiers_accepte_notification ON tiers_consulte USING btree (accepte_notification_email) WHERE (accepte_notification_email IS TRUE);


--
-- Name: tiers_consulte_categorie; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX tiers_consulte_categorie ON tiers_consulte USING btree (categorie_tiers_consulte);


--
-- Name: tiers_consulte_categorie_hash; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX tiers_consulte_categorie_hash ON tiers_consulte USING hash (categorie_tiers_consulte);


--
-- Name: tiers_uid_platau_acteur; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX tiers_uid_platau_acteur ON tiers_consulte USING btree (uid_platau_acteur);


--
-- Name: version_key; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX version_key ON dossier USING btree (version);


--
-- Name: document_numerise_type before_insert_or_update_document_numerise_type; Type: TRIGGER; Schema: openads; Owner: -
--

CREATE TRIGGER before_insert_or_update_document_numerise_type BEFORE INSERT OR UPDATE ON document_numerise_type FOR EACH ROW EXECUTE PROCEDURE check_validite_unique();


--
-- Name: affectation_automatique affectation_automatique_arrondissement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY affectation_automatique
    ADD CONSTRAINT affectation_automatique_arrondissement_fkey FOREIGN KEY (arrondissement) REFERENCES arrondissement(arrondissement);


--
-- Name: affectation_automatique affectation_automatique_dossier_autorisation_type_detaille_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY affectation_automatique
    ADD CONSTRAINT affectation_automatique_dossier_autorisation_type_detaille_fkey FOREIGN KEY (dossier_autorisation_type_detaille) REFERENCES dossier_autorisation_type_detaille(dossier_autorisation_type_detaille);


--
-- Name: affectation_automatique affectation_automatique_dossier_instruction_type_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY affectation_automatique
    ADD CONSTRAINT affectation_automatique_dossier_instruction_type_fkey FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: affectation_automatique affectation_automatique_instructeur_2_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY affectation_automatique
    ADD CONSTRAINT affectation_automatique_instructeur_2_fkey FOREIGN KEY (instructeur_2) REFERENCES instructeur(instructeur);


--
-- Name: affectation_automatique affectation_automatique_instructeur_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY affectation_automatique
    ADD CONSTRAINT affectation_automatique_instructeur_fkey FOREIGN KEY (instructeur) REFERENCES instructeur(instructeur);


--
-- Name: affectation_automatique affectation_automatique_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY affectation_automatique
    ADD CONSTRAINT affectation_automatique_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: affectation_automatique affectation_automatique_quartier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY affectation_automatique
    ADD CONSTRAINT affectation_automatique_quartier_fkey FOREIGN KEY (quartier) REFERENCES quartier(quartier);


--
-- Name: avis_decision avis_decision_avis_decision_nature; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY avis_decision
    ADD CONSTRAINT avis_decision_avis_decision_nature FOREIGN KEY (avis_decision_nature) REFERENCES avis_decision_nature(avis_decision_nature);


--
-- Name: avis_decision avis_decision_avis_decision_type; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY avis_decision
    ADD CONSTRAINT avis_decision_avis_decision_type FOREIGN KEY (avis_decision_type) REFERENCES avis_decision_type(avis_decision_type);


--
-- Name: bible bible_dossier_autorisation_type_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY bible
    ADD CONSTRAINT bible_dossier_autorisation_type_fkey FOREIGN KEY (dossier_autorisation_type) REFERENCES dossier_autorisation_type(dossier_autorisation_type);


--
-- Name: bible bible_evenement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY bible
    ADD CONSTRAINT bible_evenement_fkey FOREIGN KEY (evenement) REFERENCES evenement(evenement);


--
-- Name: bible bible_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY bible
    ADD CONSTRAINT bible_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: blocnote blocnote_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY blocnote
    ADD CONSTRAINT blocnote_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: tiers_consulte categorie_tiers_consulte_categorie_consulte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY tiers_consulte
    ADD CONSTRAINT categorie_tiers_consulte_categorie_consulte_fkey FOREIGN KEY (categorie_tiers_consulte) REFERENCES categorie_tiers_consulte(categorie_tiers_consulte);


--
-- Name: commission commission_commission_type_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY commission
    ADD CONSTRAINT commission_commission_type_fkey FOREIGN KEY (commission_type) REFERENCES commission_type(commission_type);


--
-- Name: commission commission_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY commission
    ADD CONSTRAINT commission_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: commission_type commission_type_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY commission_type
    ADD CONSTRAINT commission_type_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: compteur compteur_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY compteur
    ADD CONSTRAINT compteur_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: consultation consultation_avis_consultation_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation
    ADD CONSTRAINT consultation_avis_consultation_fkey FOREIGN KEY (avis_consultation) REFERENCES avis_consultation(avis_consultation);


--
-- Name: consultation consultation_categorie_tiers_consulte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation
    ADD CONSTRAINT consultation_categorie_tiers_consulte_fkey FOREIGN KEY (categorie_tiers_consulte) REFERENCES categorie_tiers_consulte(categorie_tiers_consulte);


--
-- Name: consultation consultation_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation
    ADD CONSTRAINT consultation_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: consultation_entrante consultation_entrante_dossier; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation_entrante
    ADD CONSTRAINT consultation_entrante_dossier FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: consultation consultation_motif_consultation_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation
    ADD CONSTRAINT consultation_motif_consultation_fkey FOREIGN KEY (motif_consultation) REFERENCES motif_consultation(motif_consultation);


--
-- Name: consultation consultation_service_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation
    ADD CONSTRAINT consultation_service_fkey FOREIGN KEY (service) REFERENCES service(service);


--
-- Name: consultation consultation_tiers_consulte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY consultation
    ADD CONSTRAINT consultation_tiers_consulte_fkey FOREIGN KEY (tiers_consulte) REFERENCES tiers_consulte(tiers_consulte);


--
-- Name: contrainte contrainte_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY contrainte
    ADD CONSTRAINT contrainte_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: demande demande_arrondissement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_arrondissement_fkey FOREIGN KEY (arrondissement) REFERENCES arrondissement(arrondissement);


--
-- Name: demande demande_autorisation_contestee_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_autorisation_contestee_fkey FOREIGN KEY (autorisation_contestee) REFERENCES dossier(dossier);


--
-- Name: demande demande_commune; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_commune FOREIGN KEY (commune) REFERENCES commune(commune);


--
-- Name: demande demande_demande_type_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_demande_type_fkey FOREIGN KEY (demande_type) REFERENCES demande_type(demande_type);


--
-- Name: demande demande_dossier_autorisation_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_dossier_autorisation_fkey FOREIGN KEY (dossier_autorisation) REFERENCES dossier_autorisation(dossier_autorisation);


--
-- Name: demande demande_dossier_autorisation_type_detaille_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_dossier_autorisation_type_detaille_fkey FOREIGN KEY (dossier_autorisation_type_detaille) REFERENCES dossier_autorisation_type_detaille(dossier_autorisation_type_detaille);


--
-- Name: demande demande_dossier_instruction_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_dossier_instruction_fkey FOREIGN KEY (dossier_instruction) REFERENCES dossier(dossier);


--
-- Name: demande demande_instruction_recepisse_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_instruction_recepisse_fkey FOREIGN KEY (instruction_recepisse) REFERENCES instruction(instruction);


--
-- Name: demande demande_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande
    ADD CONSTRAINT demande_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: demande_type demande_type_demande_nature_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande_type
    ADD CONSTRAINT demande_type_demande_nature_fkey FOREIGN KEY (demande_nature) REFERENCES demande_nature(demande_nature);


--
-- Name: demande_type demande_type_dossier_autorisation_type_detaille_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande_type
    ADD CONSTRAINT demande_type_dossier_autorisation_type_detaille_fkey FOREIGN KEY (dossier_autorisation_type_detaille) REFERENCES dossier_autorisation_type_detaille(dossier_autorisation_type_detaille);


--
-- Name: demande_type demande_type_dossier_instruction_type_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande_type
    ADD CONSTRAINT demande_type_dossier_instruction_type_fkey FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: demande_type demande_type_evenement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande_type
    ADD CONSTRAINT demande_type_evenement_fkey FOREIGN KEY (evenement) REFERENCES evenement(evenement);


--
-- Name: demande_type demande_type_groupe_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demande_type
    ADD CONSTRAINT demande_type_groupe_fkey FOREIGN KEY (groupe) REFERENCES groupe(groupe);


--
-- Name: demandeur demandeur_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demandeur
    ADD CONSTRAINT demandeur_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: demandeur demandeur_particulier_civilite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demandeur
    ADD CONSTRAINT demandeur_particulier_civilite_fkey FOREIGN KEY (particulier_civilite) REFERENCES civilite(civilite);


--
-- Name: demandeur demandeur_personne_morale_civilite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY demandeur
    ADD CONSTRAINT demandeur_personne_morale_civilite_fkey FOREIGN KEY (personne_morale_civilite) REFERENCES civilite(civilite);


--
-- Name: direction direction_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY direction
    ADD CONSTRAINT direction_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: division division_direction_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY division
    ADD CONSTRAINT division_direction_fkey FOREIGN KEY (direction) REFERENCES direction(direction);


--
-- Name: document_numerise document_numerise_document_numerise_nature_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise
    ADD CONSTRAINT document_numerise_document_numerise_nature_fkey FOREIGN KEY (document_numerise_nature) REFERENCES document_numerise_nature(document_numerise_nature);


--
-- Name: document_numerise document_numerise_document_numerise_type_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise
    ADD CONSTRAINT document_numerise_document_numerise_type_fkey FOREIGN KEY (document_numerise_type) REFERENCES document_numerise_type(document_numerise_type) MATCH FULL;


--
-- Name: document_numerise document_numerise_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise
    ADD CONSTRAINT document_numerise_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier) MATCH FULL ON UPDATE CASCADE ON DELETE SET NULL;


--
-- Name: document_numerise_type document_numerise_type_document_numerise_type_categorie_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY document_numerise_type
    ADD CONSTRAINT document_numerise_type_document_numerise_type_categorie_fkey FOREIGN KEY (document_numerise_type_categorie) REFERENCES document_numerise_type_categorie(document_numerise_type_categorie) MATCH FULL;


--
-- Name: donnees_techniques donnees_techniques_architecte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT donnees_techniques_architecte_fkey FOREIGN KEY (architecte) REFERENCES architecte(architecte);


--
-- Name: donnees_techniques donnees_techniques_ctx_objet_recours_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT donnees_techniques_ctx_objet_recours_fkey FOREIGN KEY (ctx_objet_recours) REFERENCES objet_recours(objet_recours);


--
-- Name: donnees_techniques donnees_techniques_dossier_instruction_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT donnees_techniques_dossier_instruction_fkey FOREIGN KEY (dossier_instruction) REFERENCES dossier(dossier);


--
-- Name: donnees_techniques donnees_techniques_lot_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT donnees_techniques_lot_fkey FOREIGN KEY (lot) REFERENCES lot(lot);


--
-- Name: dossier_operateur doss_ope_dossier_instruction_dossier_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_operateur
    ADD CONSTRAINT doss_ope_dossier_instruction_dossier_dossier_fkey FOREIGN KEY (dossier_instruction) REFERENCES dossier(dossier);


--
-- Name: dossier_autorisation dossier_autorisation_arrondissement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation
    ADD CONSTRAINT dossier_autorisation_arrondissement_fkey FOREIGN KEY (arrondissement) REFERENCES arrondissement(arrondissement);


--
-- Name: dossier_autorisation dossier_autorisation_avis_decision_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation
    ADD CONSTRAINT dossier_autorisation_avis_decision_fkey FOREIGN KEY (avis_decision) REFERENCES avis_decision(avis_decision);


--
-- Name: dossier_autorisation dossier_autorisation_commune; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation
    ADD CONSTRAINT dossier_autorisation_commune FOREIGN KEY (commune) REFERENCES commune(commune);


--
-- Name: dossier dossier_autorisation_contestee_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_autorisation_contestee_fkey FOREIGN KEY (autorisation_contestee) REFERENCES dossier(dossier);


--
-- Name: donnees_techniques dossier_autorisation_donnees_techniques_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY donnees_techniques
    ADD CONSTRAINT dossier_autorisation_donnees_techniques_fkey FOREIGN KEY (dossier_autorisation) REFERENCES dossier_autorisation(dossier_autorisation);


--
-- Name: dossier_autorisation dossier_autorisation_etat_dernier_dossier_instruction_accepte_f; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation
    ADD CONSTRAINT dossier_autorisation_etat_dernier_dossier_instruction_accepte_f FOREIGN KEY (etat_dernier_dossier_instruction_accepte) REFERENCES etat_dossier_autorisation(etat_dossier_autorisation);


--
-- Name: dossier_autorisation dossier_autorisation_etat_dossier_autorisation_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation
    ADD CONSTRAINT dossier_autorisation_etat_dossier_autorisation_fkey FOREIGN KEY (etat_dossier_autorisation) REFERENCES etat_dossier_autorisation(etat_dossier_autorisation);


--
-- Name: dossier_autorisation dossier_autorisation_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation
    ADD CONSTRAINT dossier_autorisation_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: dossier_autorisation_parcelle dossier_autorisation_parcelle_dossier_autorisation_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation_parcelle
    ADD CONSTRAINT dossier_autorisation_parcelle_dossier_autorisation_fkey FOREIGN KEY (dossier_autorisation) REFERENCES dossier_autorisation(dossier_autorisation);


--
-- Name: dossier_autorisation_type_detaille dossier_autorisation_type_detaille_cerfa_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation_type_detaille
    ADD CONSTRAINT dossier_autorisation_type_detaille_cerfa_fkey FOREIGN KEY (cerfa) REFERENCES cerfa(cerfa);


--
-- Name: dossier_autorisation_type_detaille dossier_autorisation_type_detaille_cerfa_lot_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation_type_detaille
    ADD CONSTRAINT dossier_autorisation_type_detaille_cerfa_lot_fkey FOREIGN KEY (cerfa_lot) REFERENCES cerfa(cerfa);


--
-- Name: dossier_autorisation_type_detaille dossier_autorisation_type_detaille_dossier_autorisation_type_fk; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation_type_detaille
    ADD CONSTRAINT dossier_autorisation_type_detaille_dossier_autorisation_type_fk FOREIGN KEY (dossier_autorisation_type) REFERENCES dossier_autorisation_type(dossier_autorisation_type);


--
-- Name: dossier_autorisation dossier_autorisation_type_detaille_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation
    ADD CONSTRAINT dossier_autorisation_type_detaille_fkey FOREIGN KEY (dossier_autorisation_type_detaille) REFERENCES dossier_autorisation_type_detaille(dossier_autorisation_type_detaille);


--
-- Name: dossier_autorisation_type dossier_autorisation_type_groupe_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_autorisation_type
    ADD CONSTRAINT dossier_autorisation_type_groupe_fkey FOREIGN KEY (groupe) REFERENCES groupe(groupe);


--
-- Name: dossier dossier_autorite_competente_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_autorite_competente_fkey FOREIGN KEY (autorite_competente) REFERENCES autorite_competente(autorite_competente);


--
-- Name: dossier dossier_avis_decision_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_avis_decision_fkey FOREIGN KEY (avis_decision) REFERENCES avis_decision(avis_decision);


--
-- Name: dossier_commission dossier_commission_commission_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_commission
    ADD CONSTRAINT dossier_commission_commission_fkey FOREIGN KEY (commission) REFERENCES commission(commission);


--
-- Name: dossier_commission dossier_commission_commission_type_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_commission
    ADD CONSTRAINT dossier_commission_commission_type_fkey FOREIGN KEY (commission_type) REFERENCES commission_type(commission_type);


--
-- Name: dossier_commission dossier_commission_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_commission
    ADD CONSTRAINT dossier_commission_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: dossier dossier_commune; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_commune FOREIGN KEY (commune) REFERENCES commune(commune);


--
-- Name: dossier_contrainte dossier_contrainte_contrainte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_contrainte
    ADD CONSTRAINT dossier_contrainte_contrainte_fkey FOREIGN KEY (contrainte) REFERENCES contrainte(contrainte);


--
-- Name: dossier_contrainte dossier_contrainte_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_contrainte
    ADD CONSTRAINT dossier_contrainte_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: dossier dossier_division_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_division_fkey FOREIGN KEY (division) REFERENCES division(division);


--
-- Name: dossier dossier_dossier_autorisation_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_dossier_autorisation_fkey FOREIGN KEY (dossier_autorisation) REFERENCES dossier_autorisation(dossier_autorisation);


--
-- Name: dossier dossier_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_dossier_fkey FOREIGN KEY (dossier_parent) REFERENCES dossier(dossier);


--
-- Name: instruction dossier_etat_archive_etat_pendant_incompletude_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT dossier_etat_archive_etat_pendant_incompletude_fkey FOREIGN KEY (archive_etat_pendant_incompletude) REFERENCES etat(etat);


--
-- Name: dossier dossier_etat_etat_pendant_incompletude_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_etat_etat_pendant_incompletude_fkey FOREIGN KEY (etat_pendant_incompletude) REFERENCES etat(etat);


--
-- Name: dossier dossier_etat_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_etat_fkey FOREIGN KEY (etat) REFERENCES etat(etat);


--
-- Name: instruction dossier_evenement_archive_evenement_suivant_tacite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT dossier_evenement_archive_evenement_suivant_tacite_fkey FOREIGN KEY (archive_evenement_suivant_tacite) REFERENCES evenement(evenement);


--
-- Name: instruction dossier_evenement_archive_evenement_suivant_tacite_incompletude; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT dossier_evenement_archive_evenement_suivant_tacite_incompletude FOREIGN KEY (archive_evenement_suivant_tacite_incompletude) REFERENCES evenement(evenement);


--
-- Name: dossier dossier_evenement_evenement_suivant_tacite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_evenement_evenement_suivant_tacite_fkey FOREIGN KEY (evenement_suivant_tacite) REFERENCES evenement(evenement);


--
-- Name: dossier dossier_evenement_evenement_suivant_tacite_incompletude_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_evenement_evenement_suivant_tacite_incompletude_fkey FOREIGN KEY (evenement_suivant_tacite_incompletude) REFERENCES evenement(evenement);


--
-- Name: dossier_geolocalisation dossier_geolocalisation_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_geolocalisation
    ADD CONSTRAINT dossier_geolocalisation_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: dossier dossier_instructeur_2_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_instructeur_2_fkey FOREIGN KEY (instructeur_2) REFERENCES instructeur(instructeur);


--
-- Name: dossier dossier_instructeur_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_instructeur_fkey FOREIGN KEY (instructeur) REFERENCES instructeur(instructeur);


--
-- Name: dossier_instruction_type dossier_instruction_type_dossier_autorisation_type_detaille_fke; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_instruction_type
    ADD CONSTRAINT dossier_instruction_type_dossier_autorisation_type_detaille_fke FOREIGN KEY (dossier_autorisation_type_detaille) REFERENCES dossier_autorisation_type_detaille(dossier_autorisation_type_detaille);


--
-- Name: dossier dossier_instruction_type_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_instruction_type_dossier_fkey FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: dossier_message dossier_message_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_message
    ADD CONSTRAINT dossier_message_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: dossier dossier_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: dossier_parcelle dossier_parcelle_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_parcelle
    ADD CONSTRAINT dossier_parcelle_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: dossier dossier_pec_metier; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_pec_metier FOREIGN KEY (pec_metier) REFERENCES pec_metier(pec_metier);


--
-- Name: dossier dossier_quartier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier
    ADD CONSTRAINT dossier_quartier_fkey FOREIGN KEY (quartier) REFERENCES quartier(quartier);


--
-- Name: evenement evenement_action_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_action_fkey FOREIGN KEY (action) REFERENCES action(action);


--
-- Name: evenement evenement_autorite_competente_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_autorite_competente_fkey FOREIGN KEY (autorite_competente) REFERENCES autorite_competente(autorite_competente);


--
-- Name: evenement evenement_avis_decision_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_avis_decision_fkey FOREIGN KEY (avis_decision) REFERENCES avis_decision(avis_decision);


--
-- Name: evenement evenement_etat_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_etat_fkey FOREIGN KEY (etat) REFERENCES etat(etat);


--
-- Name: evenement evenement_evenement_retour_ar_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_evenement_retour_ar_fkey FOREIGN KEY (evenement_retour_ar) REFERENCES evenement(evenement);


--
-- Name: evenement evenement_evenement_retour_signature_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_evenement_retour_signature_fkey FOREIGN KEY (evenement_retour_signature) REFERENCES evenement(evenement);


--
-- Name: evenement evenement_evenement_suivant_tacite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_evenement_suivant_tacite_fkey FOREIGN KEY (evenement_suivant_tacite) REFERENCES evenement(evenement);


--
-- Name: evenement evenement_pec_metier; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_pec_metier FOREIGN KEY (pec_metier) REFERENCES pec_metier(pec_metier);


--
-- Name: evenement evenement_phase_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement
    ADD CONSTRAINT evenement_phase_fkey FOREIGN KEY (phase) REFERENCES phase(phase);


--
-- Name: evenement_type_habilitation_tiers_consulte evenement_type_habilitation_tc_evenement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement_type_habilitation_tiers_consulte
    ADD CONSTRAINT evenement_type_habilitation_tc_evenement_fkey FOREIGN KEY (evenement) REFERENCES evenement(evenement);


--
-- Name: evenement_type_habilitation_tiers_consulte evenement_type_habilitation_tc_type_habilitation_tc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY evenement_type_habilitation_tiers_consulte
    ADD CONSTRAINT evenement_type_habilitation_tc_type_habilitation_tc_fkey FOREIGN KEY (type_habilitation_tiers_consulte) REFERENCES type_habilitation_tiers_consulte(type_habilitation_tiers_consulte);


--
-- Name: groupe groupe_genre_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY groupe
    ADD CONSTRAINT groupe_genre_fkey FOREIGN KEY (genre) REFERENCES genre(genre);


--
-- Name: habilitation_tiers_consulte habilitation_tiers_consulte_thtc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY habilitation_tiers_consulte
    ADD CONSTRAINT habilitation_tiers_consulte_thtc_fkey FOREIGN KEY (type_habilitation_tiers_consulte) REFERENCES type_habilitation_tiers_consulte(type_habilitation_tiers_consulte);


--
-- Name: instructeur instructeur_division_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instructeur
    ADD CONSTRAINT instructeur_division_fkey FOREIGN KEY (division) REFERENCES division(division);


--
-- Name: instructeur instructeur_instructeur_qualite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instructeur
    ADD CONSTRAINT instructeur_instructeur_qualite_fkey FOREIGN KEY (instructeur_qualite) REFERENCES instructeur_qualite(instructeur_qualite);


--
-- Name: instructeur instructeur_om_utilisateur_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instructeur
    ADD CONSTRAINT instructeur_om_utilisateur_fkey FOREIGN KEY (om_utilisateur) REFERENCES om_utilisateur(om_utilisateur);


--
-- Name: instruction instruction_action_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_action_fkey FOREIGN KEY (action) REFERENCES action(action);


--
-- Name: instruction instruction_autorite_competente_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_autorite_competente_fkey FOREIGN KEY (autorite_competente) REFERENCES autorite_competente(autorite_competente);


--
-- Name: instruction instruction_avis_decision_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_avis_decision_fkey FOREIGN KEY (avis_decision) REFERENCES avis_decision(avis_decision);


--
-- Name: instruction instruction_document_numerise_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_document_numerise_fkey FOREIGN KEY (document_numerise) REFERENCES document_numerise(document_numerise);


--
-- Name: instruction instruction_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: instruction instruction_etat_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_etat_fkey FOREIGN KEY (etat) REFERENCES etat(etat);


--
-- Name: instruction instruction_evenement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_evenement_fkey FOREIGN KEY (evenement) REFERENCES evenement(evenement);


--
-- Name: instruction instruction_pec_metier; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_pec_metier FOREIGN KEY (pec_metier) REFERENCES pec_metier(pec_metier);


--
-- Name: instruction instruction_signataire_arrete_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction
    ADD CONSTRAINT instruction_signataire_arrete_fkey FOREIGN KEY (signataire_arrete) REFERENCES signataire_arrete(signataire_arrete);


--
-- Name: lien_categorie_tiers_consulte_om_collectivite lien_categorie_tiers_consulte_om_collectivite_ctc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_categorie_tiers_consulte_om_collectivite
    ADD CONSTRAINT lien_categorie_tiers_consulte_om_collectivite_ctc_fkey FOREIGN KEY (categorie_tiers_consulte) REFERENCES categorie_tiers_consulte(categorie_tiers_consulte);


--
-- Name: lien_categorie_tiers_consulte_om_collectivite lien_categorie_tiers_consulte_om_collectivite_oc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_categorie_tiers_consulte_om_collectivite
    ADD CONSTRAINT lien_categorie_tiers_consulte_om_collectivite_oc_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: lien_demande_demandeur lien_demande_demandeur_demande_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_demande_demandeur
    ADD CONSTRAINT lien_demande_demandeur_demande_fkey FOREIGN KEY (demande) REFERENCES demande(demande);


--
-- Name: lien_demande_demandeur lien_demande_demandeur_demandeur_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_demande_demandeur
    ADD CONSTRAINT lien_demande_demandeur_demandeur_fkey FOREIGN KEY (demandeur) REFERENCES demandeur(demandeur);


--
-- Name: lien_demande_type_dossier_instruction_type lien_demande_type_dossier_instruction_type_demande_type_fk; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_demande_type_dossier_instruction_type
    ADD CONSTRAINT lien_demande_type_dossier_instruction_type_demande_type_fk FOREIGN KEY (demande_type) REFERENCES demande_type(demande_type);


--
-- Name: lien_demande_type_dossier_instruction_type lien_demande_type_dossier_instruction_type_dossier_instruction_; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_demande_type_dossier_instruction_type
    ADD CONSTRAINT lien_demande_type_dossier_instruction_type_dossier_instruction_ FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: lien_demande_type_etat lien_demande_type_etat_dossier_autorisation_demande_type_fk; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_demande_type_etat
    ADD CONSTRAINT lien_demande_type_etat_dossier_autorisation_demande_type_fk FOREIGN KEY (demande_type) REFERENCES demande_type(demande_type);


--
-- Name: lien_demande_type_etat lien_demande_type_etat_etat; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_demande_type_etat
    ADD CONSTRAINT lien_demande_type_etat_etat FOREIGN KEY (etat) REFERENCES etat(etat);


--
-- Name: lien_dit_nature_travaux lien_dit_nature_travaux_dit_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dit_nature_travaux
    ADD CONSTRAINT lien_dit_nature_travaux_dit_fkey FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: lien_dit_nature_travaux lien_dit_nature_travaux_nature_travaux_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dit_nature_travaux
    ADD CONSTRAINT lien_dit_nature_travaux_nature_travaux_fkey FOREIGN KEY (nature_travaux) REFERENCES nature_travaux(nature_travaux);


--
-- Name: lien_document_n_type_d_i_t lien_document_n_type_d_i_t_d_i_t; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_document_n_type_d_i_t
    ADD CONSTRAINT lien_document_n_type_d_i_t_d_i_t FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: lien_document_n_type_d_i_t lien_document_n_type_d_i_t_document_numerise_type; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_document_n_type_d_i_t
    ADD CONSTRAINT lien_document_n_type_d_i_t_document_numerise_type FOREIGN KEY (document_numerise_type) REFERENCES document_numerise_type(document_numerise_type);


--
-- Name: lien_document_numerise_type_instructeur_qualite lien_document_numerise_type_instructeur_qualite_document_numeri; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_document_numerise_type_instructeur_qualite
    ADD CONSTRAINT lien_document_numerise_type_instructeur_qualite_document_numeri FOREIGN KEY (document_numerise_type) REFERENCES document_numerise_type(document_numerise_type);


--
-- Name: lien_document_numerise_type_instructeur_qualite lien_document_numerise_type_instructeur_qualite_instructeur_qua; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_document_numerise_type_instructeur_qualite
    ADD CONSTRAINT lien_document_numerise_type_instructeur_qualite_instructeur_qua FOREIGN KEY (instructeur_qualite) REFERENCES instructeur_qualite(instructeur_qualite);


--
-- Name: lien_donnees_techniques_moyen_retenu_juge lien_donnees_techniques_moyen_retenu_juge_donnees_techniques_fk; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_donnees_techniques_moyen_retenu_juge
    ADD CONSTRAINT lien_donnees_techniques_moyen_retenu_juge_donnees_techniques_fk FOREIGN KEY (donnees_techniques) REFERENCES donnees_techniques(donnees_techniques);


--
-- Name: lien_donnees_techniques_moyen_retenu_juge lien_donnees_techniques_moyen_retenu_juge_moyen_retenu_juge_fke; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_donnees_techniques_moyen_retenu_juge
    ADD CONSTRAINT lien_donnees_techniques_moyen_retenu_juge_moyen_retenu_juge_fke FOREIGN KEY (moyen_retenu_juge) REFERENCES moyen_retenu_juge(moyen_retenu_juge);


--
-- Name: lien_donnees_techniques_moyen_souleve lien_donnees_techniques_moyen_souleve_donnees_techniques_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_donnees_techniques_moyen_souleve
    ADD CONSTRAINT lien_donnees_techniques_moyen_souleve_donnees_techniques_fkey FOREIGN KEY (donnees_techniques) REFERENCES donnees_techniques(donnees_techniques);


--
-- Name: lien_donnees_techniques_moyen_souleve lien_donnees_techniques_moyen_souleve_moyen_souleve_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_donnees_techniques_moyen_souleve
    ADD CONSTRAINT lien_donnees_techniques_moyen_souleve_moyen_souleve_fkey FOREIGN KEY (moyen_souleve) REFERENCES moyen_souleve(moyen_souleve);


--
-- Name: lien_dossier_autorisation_demandeur lien_dossier_autorisation_demandeur_demande_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_autorisation_demandeur
    ADD CONSTRAINT lien_dossier_autorisation_demandeur_demande_fkey FOREIGN KEY (dossier_autorisation) REFERENCES dossier_autorisation(dossier_autorisation);


--
-- Name: lien_dossier_autorisation_demandeur lien_dossier_autorisation_demandeur_demandeur_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_autorisation_demandeur
    ADD CONSTRAINT lien_dossier_autorisation_demandeur_demandeur_fkey FOREIGN KEY (demandeur) REFERENCES demandeur(demandeur);


--
-- Name: lien_dossier_demandeur lien_dossier_demandeur_demandeur_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_demandeur
    ADD CONSTRAINT lien_dossier_demandeur_demandeur_fkey FOREIGN KEY (demandeur) REFERENCES demandeur(demandeur);


--
-- Name: lien_dossier_demandeur lien_dossier_demandeur_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_demandeur
    ADD CONSTRAINT lien_dossier_demandeur_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: lien_dossier_dossier lien_dossier_dossier_dossier_autorisation_dossier_src_fk; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_dossier
    ADD CONSTRAINT lien_dossier_dossier_dossier_autorisation_dossier_src_fk FOREIGN KEY (dossier_src) REFERENCES dossier(dossier);


--
-- Name: lien_dossier_dossier lien_dossier_dossier_dossier_cible_fk; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_dossier
    ADD CONSTRAINT lien_dossier_dossier_dossier_cible_fk FOREIGN KEY (dossier_cible) REFERENCES dossier(dossier);


--
-- Name: lien_dossier_instruction_type_categorie_tiers lien_dossier_instruction_type_categorie_tiers_ctc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_instruction_type_categorie_tiers
    ADD CONSTRAINT lien_dossier_instruction_type_categorie_tiers_ctc_fkey FOREIGN KEY (categorie_tiers) REFERENCES categorie_tiers_consulte(categorie_tiers_consulte);


--
-- Name: lien_dossier_instruction_type_categorie_tiers lien_dossier_instruction_type_categorie_tiers_dit_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_instruction_type_categorie_tiers
    ADD CONSTRAINT lien_dossier_instruction_type_categorie_tiers_dit_fkey FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: lien_dossier_instruction_type_evenement lien_dossier_instruction_type_evenement_dossier_instruction_typ; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_instruction_type_evenement
    ADD CONSTRAINT lien_dossier_instruction_type_evenement_dossier_instruction_typ FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: lien_dossier_instruction_type_evenement lien_dossier_instruction_type_evenement_evenement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_instruction_type_evenement
    ADD CONSTRAINT lien_dossier_instruction_type_evenement_evenement_fkey FOREIGN KEY (evenement) REFERENCES evenement(evenement);


--
-- Name: lien_dossier_nature_travaux lien_dossier_nature_travaux_di_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_nature_travaux
    ADD CONSTRAINT lien_dossier_nature_travaux_di_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: lien_dossier_nature_travaux lien_dossier_nature_travaux_nature_travaux_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_nature_travaux
    ADD CONSTRAINT lien_dossier_nature_travaux_nature_travaux_fkey FOREIGN KEY (nature_travaux) REFERENCES nature_travaux(nature_travaux);


--
-- Name: lien_dossier_tiers lien_dossier_tiers_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_tiers
    ADD CONSTRAINT lien_dossier_tiers_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: lien_dossier_tiers lien_dossier_tiers_tiers_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_dossier_tiers
    ADD CONSTRAINT lien_dossier_tiers_tiers_fkey FOREIGN KEY (tiers) REFERENCES tiers_consulte(tiers_consulte);


--
-- Name: lien_habilitation_tiers_consulte_commune lien_habilitation_tiers_consulte_commune_com_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_commune
    ADD CONSTRAINT lien_habilitation_tiers_consulte_commune_com_fkey FOREIGN KEY (commune) REFERENCES commune(commune);


--
-- Name: lien_habilitation_tiers_consulte_commune lien_habilitation_tiers_consulte_commune_htc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_commune
    ADD CONSTRAINT lien_habilitation_tiers_consulte_commune_htc_fkey FOREIGN KEY (habilitation_tiers_consulte) REFERENCES habilitation_tiers_consulte(habilitation_tiers_consulte);


--
-- Name: lien_habilitation_tiers_consulte_departement lien_habilitation_tiers_consulte_departement_dept_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_departement
    ADD CONSTRAINT lien_habilitation_tiers_consulte_departement_dept_fkey FOREIGN KEY (departement) REFERENCES departement(departement);


--
-- Name: lien_habilitation_tiers_consulte_departement lien_habilitation_tiers_consulte_departement_htc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_departement
    ADD CONSTRAINT lien_habilitation_tiers_consulte_departement_htc_fkey FOREIGN KEY (habilitation_tiers_consulte) REFERENCES habilitation_tiers_consulte(habilitation_tiers_consulte);


--
-- Name: lien_habilitation_tiers_consulte_specialite_tiers_consulte lien_habilitation_tiers_consulte_stc_htc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_specialite_tiers_consulte
    ADD CONSTRAINT lien_habilitation_tiers_consulte_stc_htc_fkey FOREIGN KEY (habilitation_tiers_consulte) REFERENCES habilitation_tiers_consulte(habilitation_tiers_consulte);


--
-- Name: lien_habilitation_tiers_consulte_specialite_tiers_consulte lien_habilitation_tiers_consulte_stc_stc_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_habilitation_tiers_consulte_specialite_tiers_consulte
    ADD CONSTRAINT lien_habilitation_tiers_consulte_stc_stc_fkey FOREIGN KEY (specialite_tiers_consulte) REFERENCES specialite_tiers_consulte(specialite_tiers_consulte);


--
-- Name: lien_lot_demandeur lien_lot_demandeur_demandeur_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_lot_demandeur
    ADD CONSTRAINT lien_lot_demandeur_demandeur_fkey FOREIGN KEY (demandeur) REFERENCES demandeur(demandeur);


--
-- Name: lien_lot_demandeur lien_lot_demandeur_lot_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_lot_demandeur
    ADD CONSTRAINT lien_lot_demandeur_lot_fkey FOREIGN KEY (lot) REFERENCES lot(lot);


--
-- Name: lien_motif_consultation_om_collectivite lien_motif_consultation_om_collectivite_motif_consultation_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_motif_consultation_om_collectivite
    ADD CONSTRAINT lien_motif_consultation_om_collectivite_motif_consultation_fkey FOREIGN KEY (motif_consultation) REFERENCES motif_consultation(motif_consultation);


--
-- Name: lien_motif_consultation_om_collectivite lien_motif_consultation_om_collectivite_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_motif_consultation_om_collectivite
    ADD CONSTRAINT lien_motif_consultation_om_collectivite_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: lien_om_profil_groupe lien_om_profil_groupe_groupe_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_om_profil_groupe
    ADD CONSTRAINT lien_om_profil_groupe_groupe_fkey FOREIGN KEY (groupe) REFERENCES groupe(groupe);


--
-- Name: lien_om_profil_groupe lien_om_profil_groupe_om_profil_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_om_profil_groupe
    ADD CONSTRAINT lien_om_profil_groupe_om_profil_fkey FOREIGN KEY (om_profil) REFERENCES om_profil(om_profil);


--
-- Name: lien_om_utilisateur_groupe lien_om_utilisateur_groupe_groupe_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_om_utilisateur_groupe
    ADD CONSTRAINT lien_om_utilisateur_groupe_groupe_fkey FOREIGN KEY (groupe) REFERENCES groupe(groupe);


--
-- Name: lien_om_utilisateur_tiers_consulte lien_om_utilisateur_tiers_consulte_om_utilisateur_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_om_utilisateur_tiers_consulte
    ADD CONSTRAINT lien_om_utilisateur_tiers_consulte_om_utilisateur_fkey FOREIGN KEY (om_utilisateur) REFERENCES om_utilisateur(om_utilisateur);


--
-- Name: lien_om_utilisateur_tiers_consulte lien_om_utilisateur_tiers_consulte_tiers_consulte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_om_utilisateur_tiers_consulte
    ADD CONSTRAINT lien_om_utilisateur_tiers_consulte_tiers_consulte_fkey FOREIGN KEY (tiers_consulte) REFERENCES tiers_consulte(tiers_consulte);


--
-- Name: lien_service_om_utilisateur lien_service_om_utilisateur_om_utilisateur_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_service_om_utilisateur
    ADD CONSTRAINT lien_service_om_utilisateur_om_utilisateur_fkey FOREIGN KEY (om_utilisateur) REFERENCES om_utilisateur(om_utilisateur);


--
-- Name: lien_service_om_utilisateur lien_service_om_utilisateur_service_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_service_om_utilisateur
    ADD CONSTRAINT lien_service_om_utilisateur_service_fkey FOREIGN KEY (service) REFERENCES service(service);


--
-- Name: lien_service_service_categorie lien_service_service_categorie_service_categorie_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_service_service_categorie
    ADD CONSTRAINT lien_service_service_categorie_service_categorie_fkey FOREIGN KEY (service_categorie) REFERENCES service_categorie(service_categorie);


--
-- Name: lien_service_service_categorie lien_service_service_categorie_service_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_service_service_categorie
    ADD CONSTRAINT lien_service_service_categorie_service_fkey FOREIGN KEY (service) REFERENCES service(service);


--
-- Name: lien_sig_contrainte_dossier_instruction_type lien_sig_contrainte_dossier_instruction_type_sig_contrainte; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_dossier_instruction_type
    ADD CONSTRAINT lien_sig_contrainte_dossier_instruction_type_sig_contrainte FOREIGN KEY (sig_contrainte) REFERENCES sig_contrainte(sig_contrainte);


--
-- Name: lien_sig_contrainte_evenement lien_sig_contrainte_evenement_evenement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_evenement
    ADD CONSTRAINT lien_sig_contrainte_evenement_evenement_fkey FOREIGN KEY (evenement) REFERENCES evenement(evenement);


--
-- Name: lien_sig_contrainte_evenement lien_sig_contrainte_evenement_sig_contrainte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_evenement
    ADD CONSTRAINT lien_sig_contrainte_evenement_sig_contrainte_fkey FOREIGN KEY (sig_contrainte) REFERENCES sig_contrainte(sig_contrainte);


--
-- Name: lien_sig_contrainte_om_collectivite lien_sig_contrainte_om_collectivite_sig_contrainte; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_om_collectivite
    ADD CONSTRAINT lien_sig_contrainte_om_collectivite_sig_contrainte FOREIGN KEY (sig_contrainte) REFERENCES sig_contrainte(sig_contrainte);


--
-- Name: lien_sig_contrainte_sig_attribut lien_sig_contrainte_sig_attribut_sig_contrainte; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_sig_attribut
    ADD CONSTRAINT lien_sig_contrainte_sig_attribut_sig_contrainte FOREIGN KEY (sig_contrainte) REFERENCES sig_contrainte(sig_contrainte);


--
-- Name: lien_type_di_type_di lien_type_di_type_di_type_di_parent_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_type_di_type_di
    ADD CONSTRAINT lien_type_di_type_di_type_di_parent_fkey FOREIGN KEY (type_di_parent) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: lien_type_di_type_di lien_type_di_type_di_type_di_ss_di_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_type_di_type_di
    ADD CONSTRAINT lien_type_di_type_di_type_di_ss_di_fkey FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: lot lot_dossier_autorisation_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lot
    ADD CONSTRAINT lot_dossier_autorisation_fkey FOREIGN KEY (dossier_autorisation) REFERENCES dossier_autorisation(dossier_autorisation);


--
-- Name: lot lot_dossier_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lot
    ADD CONSTRAINT lot_dossier_fkey FOREIGN KEY (dossier) REFERENCES dossier(dossier);


--
-- Name: motif_consultation motif_consultation_om_etat_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY motif_consultation
    ADD CONSTRAINT motif_consultation_om_etat_fkey FOREIGN KEY (om_etat) REFERENCES om_etat(om_etat);


--
-- Name: nature_travaux nature_travaux_famille_travaux_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY nature_travaux
    ADD CONSTRAINT nature_travaux_famille_travaux_fkey FOREIGN KEY (famille_travaux) REFERENCES famille_travaux(famille_travaux);


--
-- Name: num_bordereau num_bordereau_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY num_bordereau
    ADD CONSTRAINT num_bordereau_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: num_dossier num_dossier_num_bordereau; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY num_dossier
    ADD CONSTRAINT num_dossier_num_bordereau FOREIGN KEY (num_bordereau) REFERENCES num_bordereau(num_bordereau);


--
-- Name: num_dossier num_dossier_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY num_dossier
    ADD CONSTRAINT num_dossier_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: instruction_notification_document om_instruction_notification_document_instruction_notification_f; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction_notification_document
    ADD CONSTRAINT om_instruction_notification_document_instruction_notification_f FOREIGN KEY (instruction_notification) REFERENCES instruction_notification(instruction_notification);


--
-- Name: instruction_notification om_instruction_notification_instruction_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY instruction_notification
    ADD CONSTRAINT om_instruction_notification_instruction_fkey FOREIGN KEY (instruction) REFERENCES instruction(instruction);


--
-- Name: dossier_operateur ope_collterr_select_tiers_consulte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_operateur
    ADD CONSTRAINT ope_collterr_select_tiers_consulte_fkey FOREIGN KEY (operateur_selectionne) REFERENCES tiers_consulte(tiers_consulte);


--
-- Name: dossier_operateur ope_designe_tiers_consulte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_operateur
    ADD CONSTRAINT ope_designe_tiers_consulte_fkey FOREIGN KEY (operateur_designe) REFERENCES tiers_consulte(tiers_consulte);


--
-- Name: dossier_operateur ope_det_inrap_tiers_consulte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_operateur
    ADD CONSTRAINT ope_det_inrap_tiers_consulte_fkey FOREIGN KEY (operateur_detecte_inrap) REFERENCES tiers_consulte(tiers_consulte);


--
-- Name: dossier_operateur ope_pers_pub_tiers_consulte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY dossier_operateur
    ADD CONSTRAINT ope_pers_pub_tiers_consulte_fkey FOREIGN KEY (operateur_personne_publique) REFERENCES tiers_consulte(tiers_consulte);


--
-- Name: quartier quartier_arrondissement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY quartier
    ADD CONSTRAINT quartier_arrondissement_fkey FOREIGN KEY (arrondissement) REFERENCES arrondissement(arrondissement);


--
-- Name: rapport_instruction rapport_instruction_dossier_instruction_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY rapport_instruction
    ADD CONSTRAINT rapport_instruction_dossier_instruction_fkey FOREIGN KEY (dossier_instruction) REFERENCES dossier(dossier);


--
-- Name: service service_edition_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY service
    ADD CONSTRAINT service_edition_fkey FOREIGN KEY (edition) REFERENCES om_etat(om_etat);


--
-- Name: service service_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY service
    ADD CONSTRAINT service_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: sig_attribut sig_attribut_sig_couche; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY sig_attribut
    ADD CONSTRAINT sig_attribut_sig_couche FOREIGN KEY (sig_couche) REFERENCES sig_couche(sig_couche);


--
-- Name: lien_sig_contrainte_dossier_instruction_type sig_contrainte_dossier_instruction_type; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_dossier_instruction_type
    ADD CONSTRAINT sig_contrainte_dossier_instruction_type FOREIGN KEY (dossier_instruction_type) REFERENCES dossier_instruction_type(dossier_instruction_type);


--
-- Name: lien_sig_contrainte_om_collectivite sig_contrainte_om_collectivite; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_om_collectivite
    ADD CONSTRAINT sig_contrainte_om_collectivite FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: lien_sig_contrainte_sig_attribut sig_contrainte_sig_attribut; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY lien_sig_contrainte_sig_attribut
    ADD CONSTRAINT sig_contrainte_sig_attribut FOREIGN KEY (sig_attribut) REFERENCES sig_attribut(sig_attribut);


--
-- Name: sig_contrainte sig_contrainte_sig_couche; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY sig_contrainte
    ADD CONSTRAINT sig_contrainte_sig_couche FOREIGN KEY (sig_couche) REFERENCES sig_couche(sig_couche);


--
-- Name: sig_contrainte sig_contrainte_sig_groupe; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY sig_contrainte
    ADD CONSTRAINT sig_contrainte_sig_groupe FOREIGN KEY (groupe) REFERENCES sig_groupe(sig_groupe);


--
-- Name: sig_contrainte sig_contrainte_sig_sousgroupe; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY sig_contrainte
    ADD CONSTRAINT sig_contrainte_sig_sousgroupe FOREIGN KEY (sousgroupe) REFERENCES sig_sousgroupe(sig_sousgroupe);


--
-- Name: signataire_arrete signataire_arrete_civilite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY signataire_arrete
    ADD CONSTRAINT signataire_arrete_civilite_fkey FOREIGN KEY (civilite) REFERENCES civilite(civilite);


--
-- Name: signataire_arrete signataire_arrete_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY signataire_arrete
    ADD CONSTRAINT signataire_arrete_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: signataire_arrete signataire_arrete_signataire_habilitation_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY signataire_arrete
    ADD CONSTRAINT signataire_arrete_signataire_habilitation_fkey FOREIGN KEY (signataire_habilitation) REFERENCES signataire_habilitation(signataire_habilitation);


--
-- Name: storage storage_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY storage
    ADD CONSTRAINT storage_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: taxe_amenagement taxe_amenagement_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY taxe_amenagement
    ADD CONSTRAINT taxe_amenagement_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: habilitation_tiers_consulte tiers_consulte_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY habilitation_tiers_consulte
    ADD CONSTRAINT tiers_consulte_fkey FOREIGN KEY (tiers_consulte) REFERENCES tiers_consulte(tiers_consulte);


--
-- Name: transition transition_etat_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY transition
    ADD CONSTRAINT transition_etat_fkey FOREIGN KEY (etat) REFERENCES etat(etat);


--
-- Name: transition transition_evenement_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY transition
    ADD CONSTRAINT transition_evenement_fkey FOREIGN KEY (evenement) REFERENCES evenement(evenement);


--
-- PostgreSQL database dump complete
--

--
-- Name: task_by_external_uid(text, text); Type: FUNCTION; Schema: openads; Owner: -
--

CREATE FUNCTION task_by_external_uid(external_uid text, external_uid_type text) RETURNS TABLE(task integer, type text, timestamp_log text, state text, object_id text, dossier text, json_payload text, stream text, category text, external_uid text)
    LANGUAGE sql
    AS $$
    SELECT task, type, timestamp_log, state, object_id, dossier, json_payload, stream, category, external_uid as external_uid
    FROM task
    WHERE json_payload::json->'external_uids'->>external_uid_type = external_uid
$$;
