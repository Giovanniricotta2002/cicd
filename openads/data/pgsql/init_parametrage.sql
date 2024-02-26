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
-- Data for Name: avis_consultation; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO avis_consultation (libelle, abrege, om_validite_debut, om_validite_fin, avis_consultation, code) VALUES ('Defavorable', NULL, NULL, NULL, 1, '1');
INSERT INTO avis_consultation (libelle, abrege, om_validite_debut, om_validite_fin, avis_consultation, code) VALUES ('Favorable', NULL, NULL, NULL, 2, '2');
INSERT INTO avis_consultation (libelle, abrege, om_validite_debut, om_validite_fin, avis_consultation, code) VALUES ('Favorable avec Reserve', NULL, NULL, NULL, 3, '3');
INSERT INTO avis_consultation (libelle, abrege, om_validite_debut, om_validite_fin, avis_consultation, code) VALUES ('Tacite', NULL, NULL, NULL, 4, '4');
INSERT INTO avis_consultation (libelle, abrege, om_validite_debut, om_validite_fin, avis_consultation, code) VALUES ('Autre', NULL, NULL, NULL, 5, '5');


--
-- Data for Name: civilite; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO civilite (code, civilite, libelle, om_validite_debut, om_validite_fin) VALUES ('M. Mme', 1, 'Monsieur Madame', NULL, NULL);
INSERT INTO civilite (code, civilite, libelle, om_validite_debut, om_validite_fin) VALUES ('Mlle', 2, 'Mademoiselle', NULL, NULL);
INSERT INTO civilite (code, civilite, libelle, om_validite_debut, om_validite_fin) VALUES ('Mme', 3, 'Madame', NULL, NULL);
INSERT INTO civilite (code, civilite, libelle, om_validite_debut, om_validite_fin) VALUES ('M.', 4, 'Monsieur', NULL, NULL);


--
-- Data for Name: om_collectivite; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO om_collectivite (om_collectivite, libelle, niveau) VALUES (3, 'ALLAUCH', '1');
INSERT INTO om_collectivite (om_collectivite, libelle, niveau) VALUES (1, 'agglo', '2');
INSERT INTO om_collectivite (om_collectivite, libelle, niveau) VALUES (2, 'MARSEILLE', '1');


--
-- Data for Name: om_profil; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (1, 'PROFIL NON CONFIGURÉ', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (2, 'ADMINISTRATEUR TECHNIQUE', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (3, 'INSTRUCTEUR', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (4, 'SERVICE CONSULTÉ', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (5, 'CELLULE SUIVI', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (6, 'GUICHET UNIQUE', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (7, 'QUALIFICATEUR', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (8, 'SERVICE CONSULTÉ INTERNE', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (9, 'VISUALISATION DA et DI', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (10, 'VISUALISATION DA', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (11, 'DIVISIONNAIRE', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (12, 'CHEF DE SERVICE', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (13, 'ADMINISTRATEUR FONCTIONNEL', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (14, 'INSTRUCTEUR SERVICE', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (15, 'GUICHET ET SUIVI', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (17, 'INSTRUCTEUR POLYVALENT COMMUNE', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (18, 'INSTRUCTEUR POLYVALENT', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (20, 'ASSISTANTE', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (21, 'CHEF DE SERVICE CONTENTIEUX', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (22, 'JURISTE', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (23, 'TECHNICIEN', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (24, 'RESPONSABLE DIVISION INFRACTION', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (25, 'DIRECTION CONSULTATION', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (26, 'DIRECTION RECOURS', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (27, 'DIRECTION INFRACTION', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (28, 'SERVICE CONSULTÉ ÉTENDU', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (29, 'SERVICE CONSULTÉ DI', 0, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (19, 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL', 99, NULL, NULL);
INSERT INTO om_profil (om_profil, libelle, hierarchie, om_validite_debut, om_validite_fin) VALUES (16, 'ADMINISTRATEUR GENERAL', 98, NULL, NULL);


--
-- Data for Name: om_widget; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (1, 'Profil non configuré', '', 'Votre profil ne peut accéder à aucune fonction du logiciel. Veuillez contacter l''administrateur pour que vos permissions soient configurées.', 'web', '', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (5, 'Nouveau dossier', '', '', 'file', 'nouvelle_demande_nouveau_dossier', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (8, 'Dossiers limites à 15 jours', '', '', 'file', 'dossiers_limites', 'nombre_de_jours=15');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (9, 'Recherche accès direct', '', '', 'file', 'recherche_dossier', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (11, 'Dossiers à qualifier', '', '', 'file', 'dossier_qualifier', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (12, 'Infos profil', '', '', 'file', 'infos_profil', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (13, 'Redirection', '', '', 'file', 'redirection', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (6, 'Dossier en cours', '', '', 'file', 'nouvelle_demande_dossier_encours', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (14, 'Autres dossiers', '', '', 'file', 'nouvelle_demande_autre_dossier', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (15, 'Dossiers auxquels on peut proposer une autre décision', '', '', 'file', 'dossiers_evenement_retour_finalise', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (4, 'Mes messages', '', '', 'file', 'messages_retours', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (3, 'Mes retours de consultation', '', '', 'file', 'consultation_retours', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (16, 'Recherche accès direct par type', '', '', 'file', 'recherche_dossier_par_type', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (17, 'Les contradictoires', '', '', 'file', 'dossier_contentieux_contradictoire', 'filtre=aucun');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (18, 'Mes contradictoires', '', '', 'file', 'dossier_contentieux_contradictoire', 'filtre=instructeur');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (19, 'Les AIT', '', '', 'file', 'dossier_contentieux_ait', 'filtre=aucun');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (20, 'Mes AIT', '', '', 'file', 'dossier_contentieux_ait', 'filtre=instructeur');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (21, 'Les audiences', '', '', 'file', 'dossier_contentieux_audience', 'filtre=aucun');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (22, 'Mes clôtures', '', '', 'file', 'dossier_contentieux_clotures', 'filtre=instructeur');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (23, 'Les infractions non affectées', '', '', 'file', 'dossier_contentieux_inaffectes', 'filtre=aucun');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (24, 'Alerte Visite', '', '', 'file', 'dossier_contentieux_alerte_visite', 'filtre=aucun');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (25, 'Alerte Parquet', '', '', 'file', 'dossier_contentieux_alerte_parquet', 'filtre=aucun');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (26, 'Mes Recours', '', '', 'file', 'dossier_contentieux_recours', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (28, 'Nouveau dossier contentieux', '', '', 'file', 'nouvelle_demande_nouveau_dossier', 'contexte=contentieux');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (29, 'Mes messages du contentieux', '', '', 'file', 'messages_retours', 'filtre=instructeur
contexte=contentieux');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (30, 'Les messages du contentieux', '', '', 'file', 'messages_retours', 'filtre=division
contexte=contentieux');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (7, 'Mes retours de commission', '', '', 'file', 'commission_retours', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (31, 'Les derniers dossiers consultés', '', '', 'file', 'dossier_consulter', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (32, 'Les derniers dossiers déposés', '', '', 'file', 'derniers_dossiers_deposes', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (33, 'Mes alertes visites', '', '', 'file', 'dossier_contentieux_alerte_visite', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (34, 'Mes alertes parquets', '', '', 'file', 'dossier_contentieux_alerte_parquet', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (27, 'Mes Infractions', '', '', 'file', 'dossier_contentieux_infraction', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (35, 'Dossiers à qualifier (limite de la notification du délai)', '', '', 'file', 'dossiers_pre_instruction', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (10, 'Dossiers incomplets ou majorés sans date de notification', '', '', 'file', 'dossiers_evenement_incomplet_majoration', '');
INSERT INTO om_widget (om_widget, libelle, lien, texte, type, script, arguments) VALUES (36, 'Dossiers non transmis à Plat''AU', '', '', 'file', 'controle_donnee', '');


--
-- Data for Name: om_dashboard; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (1, 1, 'C1', 1, 1);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (9, 3, 'C1', 2, 9);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (3, 3, 'C3', 1, 3);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (4, 3, 'C3', 2, 4);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (7, 3, 'C3', 3, 7);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (8, 3, 'C2', 1, 8);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (10, 3, 'C2', 2, 10);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (11, 3, 'C1', 2, 11);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (5, 6, 'C1', 1, 5);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (14, 11, 'C2', 1, 8);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (15, 7, 'C2', 1, 11);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (16, 7, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (19, 11, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (21, 4, 'C1', 1, 13);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (22, 8, 'C1', 1, 13);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (23, 12, 'C2', 1, 8);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (24, 12, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (2, 3, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (25, 13, 'C1', 1, 5);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (26, 13, 'C2', 1, 6);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (6, 6, 'C2', 1, 14);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (27, 3, 'C1', 3, 15);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (28, 6, 'C1', 3, 15);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (52, 14, 'C1', 2, 9);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (53, 14, 'C3', 1, 3);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (54, 14, 'C3', 2, 4);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (55, 14, 'C3', 3, 7);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (56, 14, 'C2', 1, 8);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (57, 14, 'C2', 2, 10);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (58, 14, 'C1', 2, 11);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (59, 14, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (60, 16, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (61, 16, 'C2', 2, 10);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (62, 16, 'C2', 1, 8);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (63, 16, 'C3', 1, 3);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (64, 16, 'C1', 2, 9);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (65, 17, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (66, 17, 'C2', 1, 5);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (67, 17, 'C3', 1, 14);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (68, 17, 'C3', 2, 8);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (69, 17, 'C3', 3, 10);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (70, 17, 'C1', 3, 3);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (71, 17, 'C1', 2, 9);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (73, 15, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (74, 15, 'C2', 1, 5);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (75, 15, 'C3', 1, 14);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (76, 15, 'C1', 2, 9);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (77, 15, 'C1', 2, 15);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (78, 17, 'C2', 2, 15);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (79, 18, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (80, 18, 'C2', 1, 5);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (81, 18, 'C3', 1, 14);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (82, 18, 'C3', 2, 8);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (83, 18, 'C3', 3, 10);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (84, 18, 'C1', 3, 3);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (85, 18, 'C1', 2, 9);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (87, 18, 'C2', 2, 15);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (88, 20, 'C2', 3, 16);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (89, 21, 'C2', 3, 16);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (90, 22, 'C2', 3, 16);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (91, 23, 'C2', 3, 16);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (92, 24, 'C2', 3, 16);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (93, 25, 'C2', 3, 16);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (94, 26, 'C2', 3, 16);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (95, 27, 'C2', 3, 16);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (96, 20, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (97, 21, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (98, 22, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (99, 23, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (100, 24, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (101, 25, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (102, 26, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (103, 27, 'C1', 1, 12);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (104, 20, 'C3', 1, 17);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (105, 22, 'C2', 3, 18);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (106, 22, 'C3', 1, 20);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (107, 20, 'C3', 2, 19);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (108, 21, 'C3', 1, 19);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (109, 24, 'C2', 1, 19);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (110, 22, 'C3', 3, 21);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (111, 20, 'C3', 3, 21);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (112, 21, 'C3', 2, 21);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (113, 22, 'C3', 2, 22);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (114, 21, 'C2', 2, 22);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (115, 20, 'C2', 2, 23);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (116, 24, 'C2', 2, 23);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (117, 24, 'C3', 1, 24);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (118, 24, 'C3', 2, 25);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (121, 21, 'C3', 3, 24);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (122, 21, 'C3', 4, 25);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (123, 28, 'C1', 1, 13);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (124, 22, 'C2', 2, 27);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (125, 23, 'C2', 2, 27);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (126, 22, 'C2', 1, 26);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (127, 21, 'C2', 1, 26);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (128, 20, 'C1', 2, 28);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (129, 23, 'C1', 2, 28);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (130, 21, 'C1', 2, 30);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (131, 21, 'C2', 4, 29);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (132, 24, 'C3', 3, 30);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (133, 24, 'C3', 4, 29);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (134, 22, 'C3', 4, 29);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (135, 23, 'C3', 4, 29);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (136, 29, 'C1', 1, 13);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (137, 16, 'C3', 2, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (138, 19, 'C1', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (139, 20, 'C2', 3, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (140, 5, 'C1', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (141, 12, 'C3', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (142, 21, 'C1', 3, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (143, 25, 'C3', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (144, 27, 'C3', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (145, 26, 'C3', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (146, 11, 'C3', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (147, 15, 'C2', 2, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (148, 6, 'C3', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (149, 3, 'C2', 3, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (150, 18, 'C2', 4, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (151, 17, 'C2', 4, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (152, 14, 'C2', 3, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (153, 22, 'C1', 2, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (154, 7, 'C3', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (155, 24, 'C1', 2, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (156, 29, 'C3', 2, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (157, 23, 'C2', 3, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (158, 10, 'C1', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (159, 9, 'C1', 1, 31);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (160, 11, 'C2', 2, 32);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (161, 23, 'C3', 1, 33);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (162, 23, 'C3', 2, 34);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (163, 18, 'C2', 2, 35);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (164, 17, 'C2', 2, 35);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (165, 3, 'C3', 4, 36);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (166, 7, 'C3', 2, 36);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (167, 5, 'C2', 1, 36);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (168, 15, 'C3', 2, 36);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (169, 11, 'C3', 2, 36);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (170, 14, 'C3', 4, 36);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (171, 16, 'C3', 3, 36);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (172, 17, 'C3', 4, 36);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (173, 18, 'C3', 4, 36);
INSERT INTO om_dashboard (om_dashboard, om_profil, bloc, "position", om_widget) VALUES (174, 19, 'C1', 1, 9);


--
-- Data for Name: om_parametre; Type: TABLE DATA; Schema: openads; Owner: postgres
--

INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (71, 'adresse_direction_urbanisme', 'DIRECTION DE L''URBANISME
ALLAUCH', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (72, 'adresse_direction_urbanisme_RAR', 'DIRECTION DE L''URBANISME
ALLAUCH', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (73, 'adresse_SAH', 'SERVICE LOGEMENT ET URBANISME
ALLAUCH', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (74, 'adresse_SAU', 'SERVICE DES AUTORISATIONS D''URBANISME
ALLAUCH', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (75, 'commune', '002', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (76, 'cp', '13190', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (77, 'delaville', 'd''Allauch', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (79, 'insee', '13002', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (80, 'maire', 'Roland Povinelli', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (81, 'titreelu', 'Maire d''Allauch', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (82, 'ville', 'Allauch', 3);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (69, 'id_etat_initial_dossier_autorisation', '1', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (8, 'commune', '055', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (7, 'departement', '013', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (20, 'region', '93', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (67, 'id_evenement_bordereau_avis_maire_prefet', '-1', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (84, 'insee', 'false', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (83, 'code_direction', '0', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (85, 'option_portail_acces_citoyen', 'true', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (86, 'acces_citoyen', '<br/><br/>Vous pouvez consulter directement votre dossier par internet à l''adresse &acces_citoyen_adresse et en saisissant votre numéro de dossier ainsi que la clé d''accès [cle_acces_citoyen].', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (88, 'option_notification_piece_numerisee', 'true', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (89, 'param_courriel_de_notification_commune_objet_depuis_instruction', '[openADS] Notification de finalisation d''un événement d''instruction', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (90, 'param_courriel_de_notification_commune_modele_depuis_instruction', 'Bonjour,

Un nouvel événement d''instruction vient d''être finalisé concernant le dossier <DOSSIER_INSTRUCTION>. Le détail est disponible ici : 
<URL_INSTRUCTION>

Cordialement.', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (1, 'maire', 'O PENMAIRIE', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (4, 'lettre', 'R', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (6, 'cp', '13200', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (11, 'titreelu', 'Conseiller Général des Bouches du Rhône', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (12, 'datepos', '02/03/1983', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (19, 'ville', 'Marseille', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (10, 'delaville', 'de Marseille', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (9, 'nom', 'Jean-Claude Gaudin', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (21, 'adresse_direction_urbanisme', 'DIRECTION DU DÉVELOPPEMENT URBAIN
SERVICE DES AUTORISATIONS D''URBANISME
40, Rue Fauchier
13233 MARSEILLE', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (33, 'rapport_instruction_analyse_reglementaire', '', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (34, 'rapport_instruction_proposition_decision', '', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (48, 'ged_code_produit', 'OpenADS', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (13, 'option_afficher_division', 'true', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (47, 'id_etat_initial_dossier_autorisation', '1', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (18, 'option_ged', 'false', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (62, 'adresse_direction_urbanisme_RAR', 'DIRECTION DU DÉVELOPPEMENT URBAIN
SERVICE DES AUTORISATIONS D''URBANISME
40, Rue Fauchier
13233 MARSEILLE', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (63, 'insee', '13055', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (64, 'option_localisation', 'false', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (60, 'option_contrainte_di', 'aucun', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (15, 'services_consultes_lien_externe', '', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (14, 'services_consultes_lien_interne', '', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (66, 'option_arrondissement', 'false', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (70, 'option_instructeur_division_numero_dossier', 'false', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (87, 'acces_citoyen_adresse', 'https://citoyen.atreal.fr/marseille/ads/', 2);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (57, 'id_evenement_completude_at', '96', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (58, 'id_evenement_cloture_at', '97', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (91, 'id_datd_filtre_reqmo_dossier_dia', '-1', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (92, 'option_final_auto_instr_tacite_retour', 'true', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (93, 'id_avis_consultation_tacite', '-1', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (16, 'id_affichage_obligatoire', '89', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (94, 'parametre_courriel_type_titre', '[openADS] Notification concernant votre dossier [DOSSIER]', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (95, 'parametre_courriel_type_message', 'Bonjour, veuillez prendre connaissance du(des) document(s) suivant(s) :<br> [LIEN_TELECHARGEMENT_DOCUMENT]<br>[LIEN_TELECHARGEMENT_ANNEXE]', 1);
INSERT INTO om_parametre (om_parametre, libelle, valeur, om_collectivite) VALUES (96, 'parametre_notification_url_acces', 'http://localhost/openads/', 2);


--
-- Name: avis_consultation_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('avis_consultation_seq', 6, false);


--
-- Name: civilite_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('civilite_seq', 5, false);


--
-- Name: om_collectivite_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('om_collectivite_seq', 4, false);


--
-- Name: om_dashboard_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('om_dashboard_seq', 175, false);


--
-- Name: om_parametre_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('om_parametre_seq', 97, false);


--
-- Name: om_profil_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('om_profil_seq', 30, false);


--
-- Name: om_widget_seq; Type: SEQUENCE SET; Schema: openads; Owner: postgres
--

SELECT pg_catalog.setval('om_widget_seq', 37, false);


--
-- PostgreSQL database dump complete
--

