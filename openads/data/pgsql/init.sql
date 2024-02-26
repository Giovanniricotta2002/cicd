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

-- SET default_tablespace = '';

-- SET default_with_oids = false;

--
-- Name: om_collectivite; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_collectivite (
    om_collectivite integer NOT NULL,
    libelle character varying(100) NOT NULL,
    niveau character varying(1) NOT NULL
);


--
-- Name: om_collectivite_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_collectivite_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_collectivite_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_collectivite_seq OWNED BY om_collectivite.om_collectivite;


--
-- Name: om_dashboard; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_dashboard (
    om_dashboard integer NOT NULL,
    om_profil integer NOT NULL,
    bloc character varying(10) NOT NULL,
    "position" integer,
    om_widget integer NOT NULL
);


--
-- Name: om_dashboard_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_dashboard_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_dashboard_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_dashboard_seq OWNED BY om_dashboard.om_dashboard;


--
-- Name: om_droit; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_droit (
    om_droit integer NOT NULL,
    libelle character varying(100) NOT NULL,
    om_profil integer NOT NULL
);


--
-- Name: om_droit_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_droit_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_droit_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_droit_seq OWNED BY om_droit.om_droit;


--
-- Name: om_etat; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_etat (
    om_etat integer NOT NULL,
    om_collectivite integer NOT NULL,
    id character varying(50) NOT NULL,
    libelle character varying(100) NOT NULL,
    actif boolean,
    orientation character varying(2) NOT NULL,
    format character varying(5) NOT NULL,
    logo character varying(30),
    logoleft integer NOT NULL,
    logotop integer NOT NULL,
    titre_om_htmletat text NOT NULL,
    titreleft integer NOT NULL,
    titretop integer NOT NULL,
    titrelargeur integer NOT NULL,
    titrehauteur integer NOT NULL,
    titrebordure character varying(20) NOT NULL,
    corps_om_htmletatex text NOT NULL,
    om_sql integer NOT NULL,
    se_font character varying(20) NOT NULL,
    se_couleurtexte character varying(11) NOT NULL,
    margeleft integer DEFAULT 10 NOT NULL,
    margetop integer DEFAULT 10 NOT NULL,
    margeright integer DEFAULT 10 NOT NULL,
    margebottom integer DEFAULT 10 NOT NULL,
    header_om_htmletat text,
    header_offset integer DEFAULT 12 NOT NULL,
    footer_om_htmletat text,
    footer_offset integer DEFAULT 12 NOT NULL
);


--
-- Name: COLUMN om_etat.margeleft; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_etat.margeleft IS 'Marge gauche de l''édition';


--
-- Name: COLUMN om_etat.margetop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_etat.margetop IS 'Marge haute de l''édition';


--
-- Name: COLUMN om_etat.margeright; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_etat.margeright IS 'Marge droite de l''édition';


--
-- Name: COLUMN om_etat.margebottom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_etat.margebottom IS 'Marge basse de l''édition';


--
-- Name: om_etat_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_etat_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_etat_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_etat_seq OWNED BY om_etat.om_etat;


--
-- Name: om_lettretype; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_lettretype (
    om_lettretype integer NOT NULL,
    om_collectivite integer NOT NULL,
    id character varying(50) NOT NULL,
    libelle character varying(100) NOT NULL,
    actif boolean,
    orientation character varying(2) NOT NULL,
    format character varying(5) NOT NULL,
    logo character varying(30),
    logoleft integer NOT NULL,
    logotop integer NOT NULL,
    titre_om_htmletat text NOT NULL,
    titreleft integer NOT NULL,
    titretop integer NOT NULL,
    titrelargeur integer NOT NULL,
    titrehauteur integer NOT NULL,
    titrebordure character varying(20) NOT NULL,
    corps_om_htmletatex text NOT NULL,
    om_sql integer NOT NULL,
    margeleft integer DEFAULT 10 NOT NULL,
    margetop integer DEFAULT 10 NOT NULL,
    margeright integer DEFAULT 10 NOT NULL,
    margebottom integer DEFAULT 10 NOT NULL,
    se_font character varying(20),
    se_couleurtexte character varying(11),
    header_om_htmletat text,
    header_offset integer DEFAULT 0 NOT NULL,
    footer_om_htmletat text,
    footer_offset integer DEFAULT 0 NOT NULL
);


--
-- Name: COLUMN om_lettretype.margeleft; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_lettretype.margeleft IS 'Marge gauche de l''édition';


--
-- Name: COLUMN om_lettretype.margetop; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_lettretype.margetop IS 'Marge haute de l''édition';


--
-- Name: COLUMN om_lettretype.margeright; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_lettretype.margeright IS 'Marge droite de l''édition';


--
-- Name: COLUMN om_lettretype.margebottom; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_lettretype.margebottom IS 'Marge basse de l''édition';


--
-- Name: om_lettretype_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_lettretype_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_lettretype_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_lettretype_seq OWNED BY om_lettretype.om_lettretype;


--
-- Name: om_logo; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_logo (
    om_logo integer NOT NULL,
    id character varying(50) NOT NULL,
    libelle character varying(100) NOT NULL,
    description character varying(200),
    fichier character varying(100) NOT NULL,
    resolution integer,
    actif boolean,
    om_collectivite integer NOT NULL
);


--
-- Name: om_logo_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_logo_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_logo_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_logo_seq OWNED BY om_logo.om_logo;


--
-- Name: om_parametre; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_parametre (
    om_parametre integer NOT NULL,
    libelle character varying(100) NOT NULL,
    valeur text NOT NULL,
    om_collectivite integer NOT NULL
);


--
-- Name: om_parametre_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_parametre_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_parametre_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_parametre_seq OWNED BY om_parametre.om_parametre;


--
-- Name: om_profil; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_profil (
    om_profil integer NOT NULL,
    libelle character varying(100) NOT NULL,
    hierarchie integer DEFAULT 0 NOT NULL,
    om_validite_debut date,
    om_validite_fin date
);


--
-- Name: om_profil_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_profil_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_profil_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_profil_seq OWNED BY om_profil.om_profil;


--
-- Name: om_requete; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_requete (
    om_requete integer NOT NULL,
    code character varying(50) NOT NULL,
    libelle character varying(100) NOT NULL,
    description character varying(200),
    requete text,
    merge_fields text,
    type character varying(200) NOT NULL,
    classe character varying(200),
    methode character varying(200)
);


--
-- Name: COLUMN om_requete.type; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_requete.type IS 'Requête SQL ou objet ?';


--
-- Name: COLUMN om_requete.classe; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_requete.classe IS 'Nom de(s) la classe(s) contenant la méthode';


--
-- Name: COLUMN om_requete.methode; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_requete.methode IS 'Méthode (de la première classe si plusieurs définies) fournissant les champs de fusion. Si non spécifiée appel à une méthode générique';


--
-- Name: om_requete_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_requete_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_requete_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_requete_seq OWNED BY om_requete.om_requete;


--
-- Name: om_sig_extent; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_sig_extent (
    om_sig_extent integer NOT NULL,
    nom character varying(150),
    extent character varying(150),
    valide boolean
);


--
-- Name: om_sig_extent_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_sig_extent_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_sig_extent_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_sig_extent_seq OWNED BY om_sig_extent.om_sig_extent;


--
-- Name: om_sig_flux; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_sig_flux (
    om_sig_flux integer NOT NULL,
    libelle character varying(50) NOT NULL,
    om_collectivite integer NOT NULL,
    id character varying(50) NOT NULL,
    attribution character varying(150),
    chemin character varying(255) NOT NULL,
    couches character varying(255) NOT NULL,
    cache_type character varying(3),
    cache_gfi_chemin character varying(255),
    cache_gfi_couches character varying(255)
);


--
-- Name: om_sig_flux_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_sig_flux_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_sig_flux_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_sig_flux_seq OWNED BY om_sig_flux.om_sig_flux;


--
-- Name: om_sig_map; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_sig_map (
    om_sig_map integer NOT NULL,
    om_collectivite integer NOT NULL,
    id character varying(50) NOT NULL,
    libelle character varying(50) NOT NULL,
    actif boolean,
    zoom character varying(3) NOT NULL,
    fond_osm boolean,
    fond_bing boolean,
    fond_sat boolean,
    layer_info boolean,
    projection_externe character varying(60) NOT NULL,
    url text NOT NULL,
    om_sql text NOT NULL,
    retour character varying(50) NOT NULL,
    util_idx boolean,
    util_reqmo boolean,
    util_recherche boolean,
    source_flux integer,
    fond_default character varying(10) NOT NULL,
    om_sig_extent integer NOT NULL,
    restrict_extent boolean,
    sld_marqueur character varying(254),
    sld_data character varying(254),
    point_centrage public.geometry(Point,2154)
);


--
-- Name: om_sig_map_comp; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_sig_map_comp (
    om_sig_map_comp integer NOT NULL,
    om_sig_map integer NOT NULL,
    libelle character varying(50) NOT NULL,
    ordre integer NOT NULL,
    actif boolean,
    comp_maj boolean,
    type_geometrie character varying(30),
    comp_table_update character varying(30),
    comp_champ character varying(30),
    comp_champ_idx character varying(30),
    obj_class character varying(100) NOT NULL
);


--
-- Name: om_sig_map_comp_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_sig_map_comp_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_sig_map_comp_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_sig_map_comp_seq OWNED BY om_sig_map_comp.om_sig_map_comp;


--
-- Name: om_sig_map_flux; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_sig_map_flux (
    om_sig_map_flux integer NOT NULL,
    om_sig_flux integer NOT NULL,
    om_sig_map integer NOT NULL,
    ol_map character varying(50) NOT NULL,
    ordre integer NOT NULL,
    visibility boolean,
    panier boolean,
    pa_nom character varying(50),
    pa_layer character varying(50),
    pa_attribut character varying(50),
    pa_encaps character varying(3),
    pa_sql text,
    pa_type_geometrie character varying(30),
    sql_filter text,
    baselayer boolean,
    singletile boolean,
    maxzoomlevel integer
);


--
-- Name: om_sig_map_flux_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_sig_map_flux_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_sig_map_flux_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_sig_map_flux_seq OWNED BY om_sig_map_flux.om_sig_map_flux;


--
-- Name: om_sig_map_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_sig_map_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_sig_map_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_sig_map_seq OWNED BY om_sig_map.om_sig_map;


--
-- Name: om_sousetat; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_sousetat (
    om_sousetat integer NOT NULL,
    om_collectivite integer NOT NULL,
    id character varying(50) NOT NULL,
    libelle character varying(100) NOT NULL,
    actif boolean,
    titre text NOT NULL,
    titrehauteur integer NOT NULL,
    titrefont character varying(20) NOT NULL,
    titreattribut character varying(20) DEFAULT ''::character varying NOT NULL,
    titretaille integer NOT NULL,
    titrebordure character varying(20) NOT NULL,
    titrealign character varying(20) NOT NULL,
    titrefond character varying(20) NOT NULL,
    titrefondcouleur character varying(11) NOT NULL,
    titretextecouleur character varying(11) NOT NULL,
    intervalle_debut integer NOT NULL,
    intervalle_fin integer NOT NULL,
    entete_flag character varying(20) NOT NULL,
    entete_fond character varying(20) NOT NULL,
    entete_orientation character varying(100) NOT NULL,
    entete_hauteur integer NOT NULL,
    entetecolone_bordure character varying(200) NOT NULL,
    entetecolone_align character varying(100) NOT NULL,
    entete_fondcouleur character varying(11) NOT NULL,
    entete_textecouleur character varying(11) NOT NULL,
    tableau_largeur integer NOT NULL,
    tableau_bordure character varying(20) NOT NULL,
    tableau_fontaille integer NOT NULL,
    bordure_couleur character varying(11) NOT NULL,
    se_fond1 character varying(11) NOT NULL,
    se_fond2 character varying(11) NOT NULL,
    cellule_fond character varying(20) NOT NULL,
    cellule_hauteur integer NOT NULL,
    cellule_largeur character varying(200) NOT NULL,
    cellule_bordure_un character varying(200) NOT NULL,
    cellule_bordure character varying(200) NOT NULL,
    cellule_align character varying(100) NOT NULL,
    cellule_fond_total character varying(20) NOT NULL,
    cellule_fontaille_total integer NOT NULL,
    cellule_hauteur_total integer NOT NULL,
    cellule_fondcouleur_total character varying(11) NOT NULL,
    cellule_bordure_total character varying(200) NOT NULL,
    cellule_align_total character varying(100) NOT NULL,
    cellule_fond_moyenne character varying(20) NOT NULL,
    cellule_fontaille_moyenne integer NOT NULL,
    cellule_hauteur_moyenne integer NOT NULL,
    cellule_fondcouleur_moyenne character varying(11) NOT NULL,
    cellule_bordure_moyenne character varying(200) NOT NULL,
    cellule_align_moyenne character varying(100) NOT NULL,
    cellule_fond_nbr character varying(20) NOT NULL,
    cellule_fontaille_nbr integer NOT NULL,
    cellule_hauteur_nbr integer NOT NULL,
    cellule_fondcouleur_nbr character varying(11) NOT NULL,
    cellule_bordure_nbr character varying(200) NOT NULL,
    cellule_align_nbr character varying(100) NOT NULL,
    cellule_numerique character varying(200) NOT NULL,
    cellule_total character varying(100) NOT NULL,
    cellule_moyenne character varying(100) NOT NULL,
    cellule_compteur character varying(100) NOT NULL,
    om_sql text NOT NULL
);


--
-- Name: om_sousetat_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_sousetat_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_sousetat_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_sousetat_seq OWNED BY om_sousetat.om_sousetat;


--
-- Name: om_utilisateur; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_utilisateur (
    om_utilisateur integer NOT NULL,
    nom character varying(30) NOT NULL,
    email character varying(100) NOT NULL,
    login character varying(30) NOT NULL,
    pwd character varying(100) NOT NULL,
    om_collectivite integer NOT NULL,
    om_type character varying(20) DEFAULT 'DB'::character varying NOT NULL,
    om_profil integer NOT NULL
);


--
-- Name: om_utilisateur_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_utilisateur_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_utilisateur_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_utilisateur_seq OWNED BY om_utilisateur.om_utilisateur;


--
-- Name: om_version; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_version (
    om_version character varying(100) NOT NULL
);


--
-- Name: om_widget; Type: TABLE; Schema: openads; Owner: -
--

CREATE TABLE om_widget (
    om_widget integer NOT NULL,
    libelle character varying(100) NOT NULL,
    lien character varying(80) DEFAULT ''::character varying NOT NULL,
    texte text DEFAULT ''::text NOT NULL,
    type character varying(40) NOT NULL,
    script character varying(80) DEFAULT ''::character varying NOT NULL,
    arguments text DEFAULT ''::text NOT NULL
);


--
-- Name: COLUMN om_widget.script; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_widget.script IS 'Fichier utilisé par le widget';


--
-- Name: COLUMN om_widget.arguments; Type: COMMENT; Schema: openads; Owner: -
--

COMMENT ON COLUMN om_widget.arguments IS 'Arguments affiché dans le widget ';


--
-- Name: om_widget_seq; Type: SEQUENCE; Schema: openads; Owner: -
--

CREATE SEQUENCE om_widget_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


--
-- Name: om_widget_seq; Type: SEQUENCE OWNED BY; Schema: openads; Owner: -
--

ALTER SEQUENCE om_widget_seq OWNED BY om_widget.om_widget;


--
-- Name: om_collectivite om_collectivite_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_collectivite
    ADD CONSTRAINT om_collectivite_pkey PRIMARY KEY (om_collectivite);


--
-- Name: om_dashboard om_dashboard_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_dashboard
    ADD CONSTRAINT om_dashboard_pkey PRIMARY KEY (om_dashboard);


--
-- Name: om_droit om_droit_libelle_om_profil_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_droit
    ADD CONSTRAINT om_droit_libelle_om_profil_key UNIQUE (libelle, om_profil);


--
-- Name: om_droit om_droit_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_droit
    ADD CONSTRAINT om_droit_pkey PRIMARY KEY (om_droit);


--
-- Name: om_etat om_etat_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_etat
    ADD CONSTRAINT om_etat_pkey PRIMARY KEY (om_etat);


--
-- Name: om_lettretype om_lettretype_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_lettretype
    ADD CONSTRAINT om_lettretype_pkey PRIMARY KEY (om_lettretype);


--
-- Name: om_logo om_logo_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_logo
    ADD CONSTRAINT om_logo_pkey PRIMARY KEY (om_logo);


--
-- Name: om_parametre om_parametre_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_parametre
    ADD CONSTRAINT om_parametre_pkey PRIMARY KEY (om_parametre);


--
-- Name: om_profil om_profil_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_profil
    ADD CONSTRAINT om_profil_pkey PRIMARY KEY (om_profil);


--
-- Name: om_requete om_requete_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_requete
    ADD CONSTRAINT om_requete_pkey PRIMARY KEY (om_requete);


--
-- Name: om_sig_extent om_sig_extent_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_extent
    ADD CONSTRAINT om_sig_extent_pkey PRIMARY KEY (om_sig_extent);


--
-- Name: om_sig_flux om_sig_flux_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_flux
    ADD CONSTRAINT om_sig_flux_pkey PRIMARY KEY (om_sig_flux);


--
-- Name: om_sig_map_comp om_sig_map_comp_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_map_comp
    ADD CONSTRAINT om_sig_map_comp_pkey PRIMARY KEY (om_sig_map_comp);


--
-- Name: om_sig_map_flux om_sig_map_flux_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_map_flux
    ADD CONSTRAINT om_sig_map_flux_pkey PRIMARY KEY (om_sig_map_flux);


--
-- Name: om_sig_map om_sig_map_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_map
    ADD CONSTRAINT om_sig_map_pkey PRIMARY KEY (om_sig_map);


--
-- Name: om_sousetat om_sousetat_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sousetat
    ADD CONSTRAINT om_sousetat_pkey PRIMARY KEY (om_sousetat);


--
-- Name: om_utilisateur om_utilisateur_login_key; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_utilisateur
    ADD CONSTRAINT om_utilisateur_login_key UNIQUE (login);


--
-- Name: om_utilisateur om_utilisateur_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_utilisateur
    ADD CONSTRAINT om_utilisateur_pkey PRIMARY KEY (om_utilisateur);


--
-- Name: om_widget om_widget_pkey; Type: CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_widget
    ADD CONSTRAINT om_widget_pkey PRIMARY KEY (om_widget);


--
-- Name: collectivite_niveau; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX collectivite_niveau ON om_collectivite USING btree (niveau);


--
-- Name: om_sig_extent_nom_idx; Type: INDEX; Schema: openads; Owner: -
--

CREATE INDEX om_sig_extent_nom_idx ON om_sig_extent USING btree (nom);


--
-- Name: om_dashboard om_dashboard_om_profil_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_dashboard
    ADD CONSTRAINT om_dashboard_om_profil_fkey FOREIGN KEY (om_profil) REFERENCES om_profil(om_profil);


--
-- Name: om_dashboard om_dashboard_om_widget_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_dashboard
    ADD CONSTRAINT om_dashboard_om_widget_fkey FOREIGN KEY (om_widget) REFERENCES om_widget(om_widget);


--
-- Name: om_droit om_droit_om_profil_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_droit
    ADD CONSTRAINT om_droit_om_profil_fkey FOREIGN KEY (om_profil) REFERENCES om_profil(om_profil);


--
-- Name: om_etat om_etat_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_etat
    ADD CONSTRAINT om_etat_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: om_etat om_etat_om_requete_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_etat
    ADD CONSTRAINT om_etat_om_requete_fkey FOREIGN KEY (om_sql) REFERENCES om_requete(om_requete);


--
-- Name: om_lettretype om_lettretype_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_lettretype
    ADD CONSTRAINT om_lettretype_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: om_lettretype om_lettretype_om_requete_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_lettretype
    ADD CONSTRAINT om_lettretype_om_requete_fkey FOREIGN KEY (om_sql) REFERENCES om_requete(om_requete);


--
-- Name: om_logo om_logo_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_logo
    ADD CONSTRAINT om_logo_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: om_parametre om_parametre_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_parametre
    ADD CONSTRAINT om_parametre_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: om_sig_flux om_sig_flux_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_flux
    ADD CONSTRAINT om_sig_flux_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: om_sig_map_comp om_sig_map_comp_om_sig_map_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_map_comp
    ADD CONSTRAINT om_sig_map_comp_om_sig_map_fkey FOREIGN KEY (om_sig_map) REFERENCES om_sig_map(om_sig_map);


--
-- Name: om_sig_map_flux om_sig_map_flux_om_sig_flux_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_map_flux
    ADD CONSTRAINT om_sig_map_flux_om_sig_flux_fkey FOREIGN KEY (om_sig_flux) REFERENCES om_sig_flux(om_sig_flux);


--
-- Name: om_sig_map_flux om_sig_map_flux_om_sig_map_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_map_flux
    ADD CONSTRAINT om_sig_map_flux_om_sig_map_fkey FOREIGN KEY (om_sig_map) REFERENCES om_sig_map(om_sig_map);


--
-- Name: om_sig_map om_sig_map_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_map
    ADD CONSTRAINT om_sig_map_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: om_sig_map om_sig_map_om_sig_extent_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_map
    ADD CONSTRAINT om_sig_map_om_sig_extent_fkey FOREIGN KEY (om_sig_extent) REFERENCES om_sig_extent(om_sig_extent);


--
-- Name: om_sig_map om_sig_map_om_sig_map_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sig_map
    ADD CONSTRAINT om_sig_map_om_sig_map_fkey FOREIGN KEY (source_flux) REFERENCES om_sig_map(om_sig_map);


--
-- Name: om_sousetat om_sousetat_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_sousetat
    ADD CONSTRAINT om_sousetat_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: om_utilisateur om_utilisateur_om_collectivite_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_utilisateur
    ADD CONSTRAINT om_utilisateur_om_collectivite_fkey FOREIGN KEY (om_collectivite) REFERENCES om_collectivite(om_collectivite);


--
-- Name: om_utilisateur om_utilisateur_om_profil_fkey; Type: FK CONSTRAINT; Schema: openads; Owner: -
--

ALTER TABLE ONLY om_utilisateur
    ADD CONSTRAINT om_utilisateur_om_profil_fkey FOREIGN KEY (om_profil) REFERENCES om_profil(om_profil);


--
-- PostgreSQL database dump complete
--

