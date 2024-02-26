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
-- Data for Name: architecte; Type: TABLE DATA; Schema: openads; Owner: postgres
--



--
-- Data for Name: direction; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO direction (direction, code, libelle, description, chef, om_validite_debut, om_validite_fin, om_collectivite) VALUES (2, 'ADS-ALLAUCH', 'Direction ADS d''Allauch', 'Direction des autorisations des droits du sol de la ville d''Allauch', 'Julien Rouvière', NULL, NULL, 3);
INSERT INTO direction (direction, code, libelle, description, chef, om_validite_debut, om_validite_fin, om_collectivite) VALUES (1, 'ADS', 'Direction ADS', 'Direction des autorisations des droits du sol', 'Jeanette Rochefort', NULL, NULL, 2);


--
-- Data for Name: division; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO division (division, code, libelle, description, chef, direction, om_validite_debut, om_validite_fin) VALUES (22, 'H', 'subdivision H', NULL, 'Paien Labossière', 1, NULL, NULL);
INSERT INTO division (division, code, libelle, description, chef, direction, om_validite_debut, om_validite_fin) VALUES (23, 'J', 'subdivision J', NULL, 'Stéphane Cartier', 1, NULL, NULL);
INSERT INTO division (division, code, libelle, description, chef, direction, om_validite_debut, om_validite_fin) VALUES (24, 'L', 'subdivision L', NULL, 'Le Maire', 2, NULL, NULL);


--
-- Data for Name: instructeur_qualite; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO instructeur_qualite (instructeur_qualite, code, libelle, description) VALUES (1, 'instr', 'instructeur', NULL);
INSERT INTO instructeur_qualite (instructeur_qualite, code, libelle, description) VALUES (2, 'juri', 'juriste', NULL);
INSERT INTO instructeur_qualite (instructeur_qualite, code, libelle, description) VALUES (3, 'tech', 'technicien', NULL);


--
-- Data for Name: om_utilisateur; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (25, 'Instr. poly. Allauch', 'support@atreal.fr', 'instrpolycomm3', '53645c3fce0321d416ddae1e7516020e', 3, 'DB', 17);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (20, 'Administrateur général', 'support@atreal.fr', 'admingen', 'dbb8ae68325e4282d2c7a9b66ee2c0dd', 1, 'DB', 16);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (21, 'Instructeur polyvalent', 'support@atreal.fr', 'instrpoly', '598cf3537c1cc72974210fd7f2061ae8', 1, 'DB', 18);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (2, 'Anonyme', 'support@atreal.fr', 'anony', '9163834aac262db4408928dd21608752', 2, 'DB', 1);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (3, 'Instructeur', 'support@atreal.fr', 'instr', 'e1403d6e7f5e9a4b9090db9056e5b08a', 2, 'DB', 3);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (4, 'Instructeur 1', 'support@atreal.fr', 'instr1', 'e1403d6e7f5e9a4b9090db9056e5b08a', 2, 'DB', 3);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (5, 'Instructeur 2', 'support@atreal.fr', 'instr2', 'e1403d6e7f5e9a4b9090db9056e5b08a', 2, 'DB', 3);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (6, 'Service consulté', 'support@atreal.fr', 'consu', '0da946569d9461a74e7495ade5719b16', 2, 'DB', 4);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (7, 'Service consulté 1', 'support@atreal.fr', 'consu1', '0da946569d9461a74e7495ade5719b16', 2, 'DB', 4);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (8, 'Service consulté 2', 'support@atreal.fr', 'consu2', '0da946569d9461a74e7495ade5719b16', 2, 'DB', 4);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (9, 'Cellule suivi', 'support@atreal.fr', 'suivi', '88a76b5541cd34cea92bc20ec5bf75e2', 2, 'DB', 5);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (10, 'Guichet Unique', 'support@atreal.fr', 'guichet', 'aca8a84cc15c9d23d11e96a15df4f828', 2, 'DB', 6);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (11, 'Service consulté interne', 'support@atreal.fr', 'consuint', '41f5107d08bf85431bf518a48315008b', 2, 'db', 8);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (12, 'Visualisation DA et DI', 'support@atreal.fr', 'visudadi', 'f5482d356ab55aae5edf5e6146f44644', 2, 'db', 9);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (14, 'Qualificateur', 'support@atreal.fr', 'qualif', 'c7f6e8776497fc37bc20c6eae9db1c9d', 2, 'db', 7);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (13, 'Visualisation DA', 'support@atreal.fr', 'visuda', 'f8d59fd856bf844a90f0968e8acd8cac', 2, 'db', 10);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (15, 'Divisionnaire', 'support@atreal.fr', 'divi', 'a8124c681eeedd309a78db78c6d087b9', 2, 'db', 11);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (16, 'Chef de service', 'support@atreal.fr', 'chef', 'cbb4581ba3ada1ddef9b431eef2660ce', 2, 'db', 12);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (17, 'ldap_instructeur', 'support@atreal.fr', 'ldap_instructeur', '84b07083423cf92950e2eb1e2fb1995f', 2, 'ldap', 3);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (18, 'ldap_service', 'support@atreal.fr', 'ldap_service', 'dfcf7011422a7f19a16e0f92287a37d6', 2, 'ldap', 4);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (19, 'Administrateur fonctionnel', 'support@atreal.fr', 'adminfonct', '1fd0c3ab4628760fa01aa6658144ec08', 2, 'DB', 13);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (22, 'Instructeur polyvalent commune', 'support@atreal.fr', 'instrpolycomm', '0d110edaeff4a6f29d09988f9eee77cc', 2, 'DB', 17);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (23, 'Guichet et suivi', 'support@atreal.fr', 'guichetsuivi', '09c2102d8338de774534822eef0c880e', 2, 'DB', 15);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (24, 'Instr. poly. Marseille', 'support@atreal.fr', 'instrpolycomm2', '427db6cc66f871a5d1a754a8921769ae', 2, 'DB', 17);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (26, 'Instr. Service Marseille', 'support@atreal.fr', 'instrserv', '5536e11d34155ca19eefffa99dfa93a0', 2, 'DB', 14);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (27, 'Administrateur gen Marseile', 'support@atreal.fr', 'admingenmars', 'ab3cc79bb97c8a3e851feb2a8e14c7f8', 2, 'DB', 16);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (1, 'Administrateur', 'support@atreal.fr', 'admin', '21232f297a57a5a743894a0e4a801fc3', 1, 'DB', 19);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (28, 'Assistante', 'support@atreal.fr', 'assist', '8213d162ea32a3fcfec2aae5538c48e5', 2, 'DB', 20);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (29, 'Chef de service contentieux', 'support@atreal.fr', 'chefctx', 'e1d58e2f8089012666da4b5e6ba29fe1', 2, 'DB', 21);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (30, 'Juriste', 'support@atreal.fr', 'juriste', 'b024f0d47cf50bbc81bc33f28e32925f', 2, 'DB', 22);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (31, 'Technicien', 'support@atreal.fr', 'tech', 'd9f9133fb120cd6096870bc2b496805b', 2, 'DB', 23);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (32, 'Responsable div. infraction', 'support@atreal.fr', 'respinf', 'bd74a534d94cea857e395b07e94c352f', 2, 'DB', 24);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (33, 'Direction consultation', 'support@atreal.fr', 'dirconsu', '7661a6d1c817e00ea565a6d85fcb93d4', 2, 'DB', 25);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (34, 'Direction recours', 'support@atreal.fr', 'dirrec', 'fc3f307132bf9bf1df951f33320400bc', 2, 'DB', 26);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (35, 'Direction infraction', 'support@atreal.fr', 'dirinf', '151b0882556e89c4e59c85b6ee30693a', 2, 'DB', 27);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (36, 'Service consulté étendu', 'support@atreal.fr', 'consuetendu', 'f0db0a85cbc2558f877862891b754407', 2, 'DB', 28);
INSERT INTO om_utilisateur (om_utilisateur, nom, email, login, pwd, om_collectivite, om_type, om_profil) VALUES (37, 'Service consulté DI', 'support@atreal.fr', 'consudi', '88eb80664446885a9023255ba33c1cba', 2, 'DB', 29);


--
-- Data for Name: instructeur; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (1, 'Louis Laurent', NULL, 22, 3, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (2, 'Martine Nadeau', NULL, 22, 4, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (3, 'Roland Richard', NULL, 23, 5, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (4, 'Pierre Martin', NULL, 22, 15, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (5, 'ldap_instructeur', NULL, 22, 17, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (6, 'Poly', NULL, 22, 21, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (7, 'Poly Com', NULL, 23, 22, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (8, 'Poly Com Marseille', NULL, 23, 24, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (9, 'Poly Com Allauch', NULL, 24, 25, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (10, 'Instr. Service Marseille', NULL, 22, 26, NULL, NULL, 1);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (11, 'Chef de service contentieux', NULL, 22, 29, NULL, NULL, 2);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (12, 'Juriste', NULL, 22, 30, NULL, NULL, 2);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (13, 'Technicien', NULL, 22, 31, NULL, NULL, 3);
INSERT INTO instructeur (instructeur, nom, telephone, division, om_utilisateur, om_validite_debut, om_validite_fin, instructeur_qualite) VALUES (14, 'Responsable div. infraction', NULL, 22, 32, NULL, NULL, 2);


--
-- Name: architecte_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('architecte_seq', 1, false);


--
-- Name: direction_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('direction_seq', 3, false);


--
-- Name: division_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('division_seq', 25, false);


--
-- Name: instructeur_qualite_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('instructeur_qualite_seq', 4, false);


--
-- Name: instructeur_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('instructeur_seq', 15, false);


--
-- Name: om_utilisateur_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('om_utilisateur_seq', 38, false);


--
-- PostgreSQL database dump complete
--

