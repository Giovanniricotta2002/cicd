-- MàJ de la version en BDD
UPDATE om_version SET om_version = '5.14.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('5.14.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- BEGIN / [#9924] - Modification d'un document généré par une instruction
--

-- Suppression de la permission sur le profil instructeur
DELETE FROM om_droit WHERE libelle = 'instruction_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR');
DELETE FROM om_droit WHERE libelle = 'instruction_modale_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR');

-- Donne la permission à un instructeur polyvalent de voir le lien du portlet "Remplacer par le document signé"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

-- Donne la permission à un instructeur polyvalent de voir le contenu de la modale "Remplacer par le document signé"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modale_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modale_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT')
);

-- Donne la permission à un instructeur polyvalent de voir le lien du portlet "Remplacer par le document signé"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

-- Donne la permission à un instructeur polyvalent de voir le contenu de la modale "Remplacer par le document signé"
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'instruction_modale_selection_document_signe', (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'instruction_modale_selection_document_signe' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'INSTRUCTEUR POLYVALENT COMMUNE')
);

--
-- END / [#9924] - Modification d'un document généré par une instruction
--

--
-- BEGIN / [#9957] Mise à jour des données techniques et CERFA
--

-- Champs supprimées
COMMENT ON COLUMN donnees_techniques.su2_avt_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface existante avant travaux (A)" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.su2_cstr_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface créée (B)" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.su2_chge_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface créée par changement de destination ou de sous-destination (C)" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.su2_demo_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface supprimée (D)" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.su2_sup_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface supprimée par changement de destination ou de sous-destination (E)" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.su2_tot_shon9 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hébergement hôtelier et touristique" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.co_statio_adr IS 'Adresse(s) des aires de stationnement [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.enga_decla_donnees_nomi_comm IS 'Pour permettre l''utilisation des informations nominatives comprises dans ce formulaire à des fins commerciales, cochez la case ci-contre [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.co_piscine IS 'Piscine [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.co_autre IS 'Autres travaux envisagés [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.co_autre_desc IS 'Autres travaux envisagés (précisez) [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_surf_loc_stat IS 'Surface taxable des locaux clos et couverts à usage de stationnement [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_stat1 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Ne bénéficiant pas de prêt aidé" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_stat2 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Bénéficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_stat3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''autres prets aides (PLUS, LES, PSLA, PLS, LLS)" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_princ_surf_stat4 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un pret a taux zero plus (PTZ+)" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_secon_surf_stat IS 'Tableau "Locaux à usage d''habitation secondaire et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf_stat1 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Ne bénéficiant pas de prêt aidé" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf_stat2 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Bénéficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_heber_surf_stat3 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Bénéficiant d''autres prêts aidés" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_tot_surf_stat IS 'Tableau "Nombre total de logements" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat1 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Total des surfaces crées ou supprimées, y compris les surfaces des annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat2 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux artisanaux et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat4 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Entrepôts et hangars faisant l''objet d''une exploitation commerciale et non ouverts au public" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat5 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Parc de stationnement couverts faisant l''objet d''une exploitation commerciale" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les exploitations et coopératives agricoles..." Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat7 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les centres équestres : Surfaces de plancher affectées aux seules activités équestres" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat8 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et artisanaux ainsi que leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat9 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf5 IS 'Surfaces taxables non destinés à l''habitation, ligne : Parcs de stationnement, colonne : Surfaces créées [SUPPRIMÉ]';
COMMENT ON COLUMN donnees_techniques.tax_su_non_habit_surf_stat5 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Parc de stationnement couverts faisant l''objet d''une exploitation commerciale" Colonne "Surfaces créées pour le stationnement clos et couvert" [SUPPRIMÉ]';
--
COMMENT ON COLUMN cerfa.co_statio_adr IS 'Adresse(s) des aires de stationnement [SUPPRIMÉ]';
COMMENT ON COLUMN cerfa.enga_decla_donnees_nomi_comm IS 'Pour permettre l''utilisation des informations nominatives comprises dans ce formulaire à des fins commerciales, cochez la case ci-contre [SUPPRIMÉ]';
COMMENT ON COLUMN cerfa.co_piscine IS 'Piscine [SUPPRIMÉ]';
COMMENT ON COLUMN cerfa.co_autre IS 'Autres travaux envisagés [SUPPRIMÉ]';
COMMENT ON COLUMN cerfa.co_autre_desc IS 'Autres travaux envisagés (précisez) [SUPPRIMÉ]';
COMMENT ON COLUMN cerfa.tax_surf_loc_stat IS 'Surface taxable des locaux clos et couverts à usage de stationnement [SUPPRIMÉ]';

-- Ajout des données techniques et CERFA dans "Informations pour l''application d''une législation connexe"
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS x1l_legislation boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.x1l_legislation IS 'Indiquez si votre projet : a déjà fait l''objet d''une demande d''autorisation ou d''une déclaration au titre d''une autre législation que celle du code de l''urbanisme';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS x1p_precisions character varying(40);
COMMENT ON COLUMN donnees_techniques.x1p_precisions IS 'Indiquez si votre projet : a déjà fait l''objet d''une demande d''autorisation ou d''une déclaration au titre d''une autre législation que celle du code de l''urbanisme (Précisez laquelle)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS x1u_raccordement boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.x1u_raccordement IS 'Indiquez si votre projet : est soumis à une obligation de raccordement à un réseau de chaleur et de froid prévue à l''article L.712-3 du code de l''énergie';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS x2m_inscritmh boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.x2m_inscritmh IS 'Indiquez si votre projet : porte sur un immeuble inscrit au titre des monuments historiques';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS x1l_legislation boolean DEFAULT false;
COMMENT ON COLUMN cerfa.x1l_legislation IS 'Indiquez si votre projet : a déjà fait l''objet d''une demande d''autorisation ou d''une déclaration au titre d''une autre législation que celle du code de l''urbanisme';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS x1p_precisions boolean DEFAULT false;
COMMENT ON COLUMN cerfa.x1p_precisions IS 'Indiquez si votre projet : a déjà fait l''objet d''une demande d''autorisation ou d''une déclaration au titre d''une autre législation que celle du code de l''urbanisme (Précisez laquelle)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS x1u_raccordement boolean DEFAULT false;
COMMENT ON COLUMN cerfa.x1u_raccordement IS 'Indiquez si votre projet : est soumis à une obligation de raccordement à un réseau de chaleur et de froid prévue à l''article L.712-3 du code de l''énergie';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS x2m_inscritmh boolean DEFAULT false;
COMMENT ON COLUMN cerfa.x2m_inscritmh IS 'Indiquez si votre projet : porte sur un immeuble inscrit au titre des monuments historiques';

-- Renommer le champ *co_bat_niv_nb* de "Nombre de niveaux du bâtiment le plus élevé" à "au-dessus du sol"
COMMENT ON COLUMN donnees_techniques.co_bat_niv_nb IS 'Le nombre de niveaux du bâtiment le plus élevé : au-dessus du sol';
COMMENT ON COLUMN cerfa.co_bat_niv_nb IS 'Le nombre de niveaux du bâtiment le plus élevé : au-dessus du sol';

-- Ajout des données techniques et CERFA dans "Divers construction" : "Places de stationnement
-- affectées au projet, aménagées ou réservées en dehors du terrain sur lequel est situé le projet"
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1na1_numero integer;
COMMENT ON COLUMN donnees_techniques.s1na1_numero IS 'Adresse 1 des aires de stationnement : numéro';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1va1_voie character varying(40);
COMMENT ON COLUMN donnees_techniques.s1va1_voie IS 'Adresse 1 des aires de stationnement : voie';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1wa1_lieudit character varying(40);
COMMENT ON COLUMN donnees_techniques.s1wa1_lieudit IS 'Adresse 1 des aires de stationnement : lieu-dit';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1la1_localite character varying(60);
COMMENT ON COLUMN donnees_techniques.s1la1_localite IS 'Adresse 1 des aires de stationnement : localité';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1pa1_codepostal character varying(5);
COMMENT ON COLUMN donnees_techniques.s1pa1_codepostal IS 'Adresse 1 des aires de stationnement : code postal';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1na2_numero integer;
COMMENT ON COLUMN donnees_techniques.s1na2_numero IS 'Adresse 2 des aires de stationnement : numéro';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1va2_voie character varying(40);
COMMENT ON COLUMN donnees_techniques.s1va2_voie IS 'Adresse 2 des aires de stationnement : voie';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1wa2_lieudit character varying(40);
COMMENT ON COLUMN donnees_techniques.s1wa2_lieudit IS 'Adresse 2 des aires de stationnement : lieu-dit';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1la2_localite character varying(60);
COMMENT ON COLUMN donnees_techniques.s1la2_localite IS 'Adresse 2 des aires de stationnement : localité';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS s1pa2_codepostal character varying(5);
COMMENT ON COLUMN donnees_techniques.s1pa2_codepostal IS 'Adresse 2 des aires de stationnement : code postal';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1na1_numero boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1na1_numero IS 'Adresse 1 des aires de stationnement : numéro';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1va1_voie boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1va1_voie IS 'Adresse 1 des aires de stationnement : voie';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1wa1_lieudit boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1wa1_lieudit IS 'Adresse 1 des aires de stationnement : lieu-dit';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1la1_localite boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1la1_localite IS 'Adresse 1 des aires de stationnement : localité';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1pa1_codepostal boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1pa1_codepostal IS 'Adresse 1 des aires de stationnement : code postal';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1na2_numero boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1na2_numero IS 'Adresse 2 des aires de stationnement : numéro';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1va2_voie boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1va2_voie IS 'Adresse 2 des aires de stationnement : voie';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1wa2_lieudit boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1wa2_lieudit IS 'Adresse 2 des aires de stationnement : lieu-dit';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1la2_localite boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1la2_localite IS 'Adresse 2 des aires de stationnement : localité';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS s1pa2_codepostal boolean DEFAULT false;
COMMENT ON COLUMN cerfa.s1pa2_codepostal IS 'Adresse 2 des aires de stationnement : code postal';

-- Ajout des données techniques et CERFA dans "Engagement du déclarant" : "Pour un permis
-- d'aménager un lotissement"
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS e3c_certification boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.e3c_certification IS 'En application de l''article L.441-4 du code de l''urbanisme, je certifie avoir fait appel aux compétences nécessaires en matière d''architecture, d''urbanisme et de paysage pour l''établissement du projet architectural, paysager et environnemental.';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS e3a_competence boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.e3a_competence IS 'Si la surface du terrain à aménager est supérieure à 2 500 m², je certifie qu''un architecte au sens de l''article 9 de la loi n° 77-2 du 3 janvier 1977 sur l''architecture, ou qu''un paysagiste-concepteur au sens de l''article 174 de la loi n° 2016-1087 du 8 août 2016 pour la reconquête de la biodiversité, de la nature et des paysages, a participé à l''établissement du projet architectural, paysager et environnemental.';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS e3c_certification boolean DEFAULT false;
COMMENT ON COLUMN cerfa.e3c_certification IS 'En application de l''article L.441-4 du code de l''urbanisme, je certifie avoir fait appel aux compétences nécessaires en matière d''architecture, d''urbanisme et de paysage pour l''établissement du projet architectural, paysager et environnemental.';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS e3a_competence boolean DEFAULT false;
COMMENT ON COLUMN cerfa.e3a_competence IS 'Si la surface du terrain à aménager est supérieure à 2 500 m², je certifie qu''un architecte au sens de l''article 9 de la loi n° 77-2 du 3 janvier 1977 sur l''architecture, ou qu''un paysagiste-concepteur au sens de l''article 174 de la loi n° 2016-1087 du 8 août 2016 pour la reconquête de la biodiversité, de la nature et des paysages, a participé à l''établissement du projet architectural, paysager et environnemental.';

-- Ajout des données techniques et CERFA dans "Déclaration de coupe et/ou abattage d''arbres"
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS a4d_description character varying(1000);
COMMENT ON COLUMN donnees_techniques.a4d_description IS 'Courte description du lieu concerné';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS a4d_description boolean DEFAULT false;
COMMENT ON COLUMN cerfa.a4d_description IS 'Courte description du lieu concerné';

-- Ajout des données techniques et CERFA dans "Cadre réservé à l''administration – Mairie"
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS m2b_abf boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.m2b_abf IS 'Dossier transmis : Coche à l''Architecte des Bâtiments de France';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS m2j_pn boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.m2j_pn IS 'Dossier transmis : Coche au Directeur du Parc National';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS m2r_cdac boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.m2r_cdac IS 'Dossier transmis : Coche au Secrétaire de la Commission Départementale d''Aménagement Commercial ';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS m2r_cnac boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.m2r_cnac IS 'Dossier transmis : Coche au Secrétaire de la Commission Nationale d''Aménagement Commercial';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u3a_voirieoui boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u3a_voirieoui IS 'Voirie : Coche Oui';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u3f_voirienon boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u3f_voirienon IS 'Voirie : Coche Non';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u3c_eauoui boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u3c_eauoui IS 'Eau potable : Coche Oui';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u3h_eaunon boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u3h_eaunon IS 'Eau potable : Coche Non';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u3g_assainissementoui boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u3g_assainissementoui IS 'Assainissement : Coche Oui';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u3n_assainissementnon boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u3n_assainissementnon IS 'Assainissement : Coche Non';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u3m_electriciteoui boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u3m_electriciteoui IS 'Électricité : Coche Oui';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u3b_electricitenon boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u3b_electricitenon IS 'Électricité : Coche Non';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u3t_observations character varying(50);
COMMENT ON COLUMN donnees_techniques.u3t_observations IS 'Observations';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1a_voirieoui boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u1a_voirieoui IS 'Équipements, Voirie : Coche Oui';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1v_voirienon boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u1v_voirienon IS 'Équipements, Voirie : Coche Non';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1q_voirieconcessionnaire character varying(30);
COMMENT ON COLUMN donnees_techniques.u1q_voirieconcessionnaire IS 'Équipements, Voirie : Par quel service ou concessionnaire ?';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1b_voirieavant date;
COMMENT ON COLUMN donnees_techniques.u1b_voirieavant IS 'Équipements, Voirie : Avant le';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1j_eauoui boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u1j_eauoui IS 'Équipements, Eau potable : Coche Oui';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1t_eaunon boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u1t_eaunon IS 'Équipements, Eau potable : Coche Non';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1e_eauconcessionnaire character varying(30);
COMMENT ON COLUMN donnees_techniques.u1e_eauconcessionnaire IS 'Équipements, Eau potable : Par quel service ou concessionnaire ?';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1k_eauavant date;
COMMENT ON COLUMN donnees_techniques.u1k_eauavant IS 'Équipements, Eau potable : Avant le';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1s_assainissementoui boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u1s_assainissementoui IS 'Équipements, Assainissement : Coche Oui';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1d_assainissementnon boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u1d_assainissementnon IS 'Équipements, Assainissement : Coche Non';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1l_assainissementconcessionnaire character varying(30);
COMMENT ON COLUMN donnees_techniques.u1l_assainissementconcessionnaire IS 'Équipements, Assainissement : Par quel service ou concessionnaire ?';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1r_assainissementavant date;
COMMENT ON COLUMN donnees_techniques.u1r_assainissementavant IS 'Équipements, Assainissement : Avant le';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1c_electriciteoui boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u1c_electriciteoui IS 'Équipement Électricité : Coche Oui';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1u_electricitenon boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.u1u_electricitenon IS 'Équipement Électricité : Coche Non';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1m_electriciteconcessionnaire character varying(30);
COMMENT ON COLUMN donnees_techniques.u1m_electriciteconcessionnaire IS 'Équipement Électricité : Par quel service ou concessionnaire ?';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u1f_electriciteavant date;
COMMENT ON COLUMN donnees_techniques.u1f_electriciteavant IS 'Équipement Électricité : Avant le';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS u2a_observations character varying(600);
COMMENT ON COLUMN donnees_techniques.u2a_observations IS 'Observations';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS m2b_abf boolean DEFAULT false;
COMMENT ON COLUMN cerfa.m2b_abf IS 'Dossier transmis : Coche à l''Architecte des Bâtiments de France';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS m2j_pn boolean DEFAULT false;
COMMENT ON COLUMN cerfa.m2j_pn IS 'Dossier transmis : Coche au Directeur du Parc National';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS m2r_cdac boolean DEFAULT false;
COMMENT ON COLUMN cerfa.m2r_cdac IS 'Dossier transmis : Coche au Secrétaire de la Commission Départementale d''Aménagement Commercial ';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS m2r_cnac boolean DEFAULT false;
COMMENT ON COLUMN cerfa.m2r_cnac IS 'Dossier transmis : Coche au Secrétaire de la Commission Nationale d''Aménagement Commercial';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u3a_voirieoui boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u3a_voirieoui IS 'Voirie : Coche Oui';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u3f_voirienon boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u3f_voirienon IS 'Voirie : Coche Non';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u3c_eauoui boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u3c_eauoui IS 'Eau potable : Coche Oui';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u3h_eaunon boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u3h_eaunon IS 'Eau potable : Coche Non';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u3g_assainissementoui boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u3g_assainissementoui IS 'Assainissement : Coche Oui';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u3n_assainissementnon boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u3n_assainissementnon IS 'Assainissement : Coche Non';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u3m_electriciteoui boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u3m_electriciteoui IS 'Électricité : Coche Oui';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u3b_electricitenon boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u3b_electricitenon IS 'Électricité : Coche Non';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u3t_observations boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u3t_observations IS 'Observations';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1a_voirieoui boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1a_voirieoui IS 'Équipements, Voirie : Coche Oui';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1v_voirienon boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1v_voirienon IS 'Équipements, Voirie : Coche Non';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1q_voirieconcessionnaire boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1q_voirieconcessionnaire IS 'Équipements, Voirie : Par quel service ou concessionnaire ?';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1b_voirieavant boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1b_voirieavant IS 'Équipements, Voirie : Avant le';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1j_eauoui boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1j_eauoui IS 'Équipements, Eau potable : Coche Oui';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1t_eaunon boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1t_eaunon IS 'Équipements, Eau potable : Coche Non';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1e_eauconcessionnaire boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1e_eauconcessionnaire IS 'Équipements, Eau potable : Par quel service ou concessionnaire ?';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1k_eauavant boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1k_eauavant IS 'Équipements, Eau potable : Avant le';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1s_assainissementoui boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1s_assainissementoui IS 'Équipements, Assainissement : Coche Oui';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1d_assainissementnon boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1d_assainissementnon IS 'Équipements, Assainissement : Coche Non';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1l_assainissementconcessionnaire boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1l_assainissementconcessionnaire IS 'Équipements, Assainissement : Par quel service ou concessionnaire ?';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1r_assainissementavant boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1r_assainissementavant IS 'Équipements, Assainissement : Avant le';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1c_electriciteoui boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1c_electriciteoui IS 'Équipement Électricité : Coche Oui';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1u_electricitenon boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1u_electricitenon IS 'Équipement Électricité : Coche Non';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1m_electriciteconcessionnaire boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1m_electriciteconcessionnaire IS 'Équipement Électricité : Par quel service ou concessionnaire ?';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u1f_electriciteavant boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u1f_electriciteavant IS 'Équipement Électricité : Avant le';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS u2a_observations boolean DEFAULT false;
COMMENT ON COLUMN cerfa.u2a_observations IS 'Observations';

-- Ajout des données techniques et CERFA dans "Déclaration des éléments nécessaires au calcul des
-- impositions"
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1ts4_surftaxestation integer;
COMMENT ON COLUMN donnees_techniques.f1ts4_surftaxestation IS 'Surface taxable créée des parcs de stationnement couverts faisant l''objet d''une exploitation commerciale, ainsi que des locaux clos et couverts à usage de stationnement non situés dans la verticalité du bâti (en m²)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1ut1_surfcree integer;
COMMENT ON COLUMN donnees_techniques.f1ut1_surfcree IS 'Surface taxable créée des locaux clos et couverts à usage de stationnement situés dans la verticalité du bâti (en m²)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f9d_date date;
COMMENT ON COLUMN donnees_techniques.f9d_date IS 'Déclaration des éléments nécessaires au calcul des impositions : Date de la déclaration';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f9n_nom character varying(40);
COMMENT ON COLUMN donnees_techniques.f9n_nom IS 'Déclaration des éléments nécessaires au calcul des impositions : Nom du déclarant';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS f1ts4_surftaxestation boolean DEFAULT false;
COMMENT ON COLUMN cerfa.f1ts4_surftaxestation IS 'Surface taxable créée des parcs de stationnement couverts faisant l''objet d''une exploitation commerciale, ainsi que des locaux clos et couverts à usage de stationnement non situés dans la verticalité du bâti (en m²)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS f1ut1_surfcree boolean DEFAULT false;
COMMENT ON COLUMN cerfa.f1ut1_surfcree IS 'Surface taxable créée des locaux clos et couverts à usage de stationnement situés dans la verticalité du bâti (en m²)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS f9d_date boolean DEFAULT false;
COMMENT ON COLUMN cerfa.f9d_date IS 'Déclaration des éléments nécessaires au calcul des impositions : Date de la déclaration';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS f9n_nom boolean DEFAULT false;
COMMENT ON COLUMN cerfa.f9n_nom IS 'Déclaration des éléments nécessaires au calcul des impositions : Nom du déclarant';

-- Destination, sous-destination des constructions et tableau des surfaces
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_avt_shon21 numeric;
COMMENT ON COLUMN donnees_techniques.su2_avt_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface existante avant travaux (A)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_avt_shon22 numeric;
COMMENT ON COLUMN donnees_techniques.su2_avt_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface existante avant travaux (A)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_cstr_shon21 numeric;
COMMENT ON COLUMN donnees_techniques.su2_cstr_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface créée (B)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_cstr_shon22 numeric;
COMMENT ON COLUMN donnees_techniques.su2_cstr_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface créée (B)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_chge_shon21 numeric;
COMMENT ON COLUMN donnees_techniques.su2_chge_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface créée par changement de destination (C)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_chge_shon22 numeric;
COMMENT ON COLUMN donnees_techniques.su2_chge_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface créée par changement de destination (C)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_demo_shon21 numeric;
COMMENT ON COLUMN donnees_techniques.su2_demo_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface supprimée (D)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_demo_shon22 numeric;
COMMENT ON COLUMN donnees_techniques.su2_demo_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface supprimée (D)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_sup_shon21 numeric;
COMMENT ON COLUMN donnees_techniques.su2_sup_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface supprimée par changement de destination (E)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_sup_shon22 numeric;
COMMENT ON COLUMN donnees_techniques.su2_sup_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface supprimée par changement de destination (E)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_tot_shon21 numeric;
COMMENT ON COLUMN donnees_techniques.su2_tot_shon21 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Hôtels" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS su2_tot_shon22 numeric;
COMMENT ON COLUMN donnees_techniques.su2_tot_shon22 IS 'Tableau "Destination, sous-destination des constructions et tableau des surfaces", ligne "Autres hébergements touristiques" et colonne "Surface totale = (A) + (B) + (C) - (D) - (E)"';
-- Locaux à usage d''habitation principale et leurs annexes
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1gu1_f1gu2_f1gu3 numeric;
COMMENT ON COLUMN donnees_techniques.f1gu1_f1gu2_f1gu3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Ne beneficiant pas de pret aide" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1lu1_f1lu2_f1lu3 numeric;
COMMENT ON COLUMN donnees_techniques.f1lu1_f1lu2_f1lu3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1zu1_f1zu2_f1zu3 numeric;
COMMENT ON COLUMN donnees_techniques.f1zu1_f1zu2_f1zu3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un pret a taux zero plus (PTZ+)" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1pu1_f1pu2_f1pu3 numeric;
COMMENT ON COLUMN donnees_techniques.f1pu1_f1pu2_f1pu3 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''autres prets aides (PLUS, LES, PSLA, PLS, LLS)" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1gt4_f1gt5_f1gt6 numeric;
COMMENT ON COLUMN donnees_techniques.f1gt4_f1gt5_f1gt6 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Ne beneficiant pas de pret aide" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1lt4_f1lt5_f1lt6 numeric;
COMMENT ON COLUMN donnees_techniques.f1lt4_f1lt5_f1lt6 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1zt4_f1zt5_f1zt6 numeric;
COMMENT ON COLUMN donnees_techniques.f1zt4_f1zt5_f1zt6 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''un pret a taux zero plus (PTZ+)" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1pt4_f1pt5_f1pt6 numeric;
COMMENT ON COLUMN donnees_techniques.f1pt4_f1pt5_f1pt6 IS 'Tableau "Locaux à usage d''habitation principale et leurs annexes" Ligne "Beneficiant d''autres prets aides (PLUS, LES, PSLA, PLS, LLS)" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
-- Locaux à usage d''habitation secondaire et leurs annexes
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1xu1_f1xu2_f1xu3 numeric;
COMMENT ON COLUMN donnees_techniques.f1xu1_f1xu2_f1xu3 IS 'Tableau "Locaux à usage d''habitation secondaire et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1xt4_f1xt5_f1xt6 numeric;
COMMENT ON COLUMN donnees_techniques.f1xt4_f1xt5_f1xt6 IS 'Tableau "Locaux à usage d''habitation secondaire et leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
-- Locaux à usage d''hébergement et leurs annexes
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1hu1_f1hu2_f1hu3 numeric;
COMMENT ON COLUMN donnees_techniques.f1hu1_f1hu2_f1hu3 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Ne bénéficiant pas de prêt aidé" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1mu1_f1mu2_f1mu3 numeric;
COMMENT ON COLUMN donnees_techniques.f1mu1_f1mu2_f1mu3 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Beneficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1qu1_f1qu2_f1qu3 numeric;
COMMENT ON COLUMN donnees_techniques.f1qu1_f1qu2_f1qu3 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Beneficiant d''autres prets aides" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1ht4_f1ht5_f1ht6 numeric;
COMMENT ON COLUMN donnees_techniques.f1ht4_f1ht5_f1ht6 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Ne bénéficiant pas de prêt aidé" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1mt4_f1mt5_f1mt6 numeric;
COMMENT ON COLUMN donnees_techniques.f1mt4_f1mt5_f1mt6 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Beneficiant d''un PLAI ou LLTS" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f1qt4_f1qt5_f1qt6 numeric;
COMMENT ON COLUMN donnees_techniques.f1qt4_f1qt5_f1qt6 IS 'Tableau "Locaux à usage d''hébergement et leurs annexes" Ligne "Beneficiant d''autres prets aides" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
-- Création ou extension de locaux non destinés à l''habitation
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2cu1_f2cu2_f2cu3 numeric;
COMMENT ON COLUMN donnees_techniques.f2cu1_f2cu2_f2cu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Total des surfaces creees ou supprimees, y compris les surfaces des annexes" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2bu1_f2bu2_f2bu3 numeric;
COMMENT ON COLUMN donnees_techniques.f2bu1_f2bu2_f2bu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et artisanaux ainsi que leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2su1_f2su2_f2su3 numeric;
COMMENT ON COLUMN donnees_techniques.f2su1_f2su2_f2su3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2hu1_f2hu2_f2hu3 numeric;
COMMENT ON COLUMN donnees_techniques.f2hu1_f2hu2_f2hu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Entrepots et hangars faisant l''objet d''une exploitation commerciale et non ouverts au public" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2eu1_f2eu2_f2eu3 numeric;
COMMENT ON COLUMN donnees_techniques.f2eu1_f2eu2_f2eu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les exploitations et cooperatives agricoles : Surfaces de plancher des serres de production, des locaux destines a abriter les recoltes, heberger les animaux, ranger et entretenir le materiel agricole, des locaux de production et de stockage des produits a usage agricole, des locaux de transformation et de conditionnement des produits provenant de l''exploitation" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2qu1_f2qu2_f2qu3 numeric;
COMMENT ON COLUMN donnees_techniques.f2qu1_f2qu2_f2qu3 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les centres equestres : Surfaces de plancher affectees aux seules activites equestres" Colonne "Surfaces créées pour le stationnement clos et couvert non situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2ct4_f2ct5_f2ct6 numeric;
COMMENT ON COLUMN donnees_techniques.f2ct4_f2ct5_f2ct6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Total des surfaces creees ou supprimees, y compris les surfaces des annexes" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2bt4_f2bt5_f2bt6 numeric;
COMMENT ON COLUMN donnees_techniques.f2bt4_f2bt5_f2bt6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Locaux industriels et artisanaux ainsi que leurs annexes" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2st4_f2st5_f2st6 numeric;
COMMENT ON COLUMN donnees_techniques.f2st4_f2st5_f2st6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Maisons de santé mentionnées à l''article L. 6323-3 du code de la santé publique" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2ht4_f2ht5_f2ht6 numeric;
COMMENT ON COLUMN donnees_techniques.f2ht4_f2ht5_f2ht6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Entrepots et hangars faisant l''objet d''une exploitation commerciale et non ouverts au public" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2et4_f2et5_f2et6 numeric;
COMMENT ON COLUMN donnees_techniques.f2et4_f2et5_f2et6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les exploitations et cooperatives agricoles : Surfaces de plancher des serres de production, des locaux destines a abriter les recoltes, heberger les animaux, ranger et entretenir le materiel agricole, des locaux de production et de stockage des produits a usage agricole, des locaux de transformation et de conditionnement des produits provenant de l''exploitation" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS f2qt4_f2qt5_f2qt6 numeric;
COMMENT ON COLUMN donnees_techniques.f2qt4_f2qt5_f2qt6 IS 'Tableau "Création ou extension de locaux non destinés à l''habitation" Ligne "Dans les centres equestres : Surfaces de plancher affectees aux seules activites equestres" Colonne "Surfaces créées pour le stationnement clos et couvert situées dans la verticalité du bâti"';

-- Ajout des données techniques et CERFA manquantes pour les DIA
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_droit_reel_perso_grevant_bien_desc text;
COMMENT ON COLUMN donnees_techniques.dia_droit_reel_perso_grevant_bien_desc IS 'Grevant les biens : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_paie_nat_desc text;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_paie_nat_desc IS 'Paiement en nature : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_rente_viag_desc text;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_rente_viag_desc IS 'Rente viagère : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_echange_desc text;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_echange_desc IS 'Echange : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_apport_societe_desc text;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_apport_societe_desc IS 'Apport en société : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_cess_terr_loc_co_desc text;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_cess_terr_loc_co_desc IS 'Cession de tantième de terrains contre remise de locaux à construire : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_esti_imm_loca_desc text;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_esti_imm_loca_desc IS 'Location-accession – Estimation de l''immeuble objet de la location-accession : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_adju_obl_desc text;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_adju_obl_desc IS 'Rendue obligatoire par une disposition législative ou réglementaire : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_adju_fin_indivi_desc text;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_adju_fin_indivi_desc IS 'Mettant fin à une indivision ne résultant pas d''une donation-partage : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_cadre_titul_droit_prempt text;
COMMENT ON COLUMN donnees_techniques.dia_cadre_titul_droit_prempt IS 'Cadre réservé au titulaire du droit de préemption';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mairie_prix_moyen numeric;
COMMENT ON COLUMN donnees_techniques.dia_mairie_prix_moyen IS 'Prix moyen au m²';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_propri_indivi text;
COMMENT ON COLUMN donnees_techniques.dia_propri_indivi IS 'Si le bien est en indivision, indiquer le(s) nom(s)de l''(des) autres co-indivisaires et sa (leur) quote-part (7)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_situa_bien_plan_cadas_oui boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_situa_bien_plan_cadas_oui IS 'Plan(s) cadastral(aux) joint(s) : OUI';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_situa_bien_plan_cadas_non boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_situa_bien_plan_cadas_non IS 'Plan(s) cadastral(aux) joint(s) : NON';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_notif_dec_titul_adr_prop boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_notif_dec_titul_adr_prop IS 'A l''adresse du (des) propriétaire(s) mentionné(s) à la rubrique A';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_notif_dec_titul_adr_prop_desc text;
COMMENT ON COLUMN donnees_techniques.dia_notif_dec_titul_adr_prop_desc IS 'A l''adresse du (des) propriétaire(s) mentionné(s) à la rubrique A : description';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_notif_dec_titul_adr_manda boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_notif_dec_titul_adr_manda IS 'A l''adresse du mandataire mentionnée à la rubrique H, adresse où le(s) propriétaire(s) a (ont) fait élection de domicile';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_notif_dec_titul_adr_manda_desc text;
COMMENT ON COLUMN donnees_techniques.dia_notif_dec_titul_adr_manda_desc IS 'A l''adresse du mandataire mentionnée à la rubrique H, adresse où le(s) propriétaire(s) a (ont) fait élection de domicile : description';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_droit_reel_perso_grevant_bien_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_droit_reel_perso_grevant_bien_desc IS 'Grevant les biens : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_paie_nat_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_paie_nat_desc IS 'Paiement en nature : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_rente_viag_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_rente_viag_desc IS 'Rente viagère : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_echange_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_echange_desc IS 'Echange : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_apport_societe_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_apport_societe_desc IS 'Apport en société : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_cess_terr_loc_co_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_cess_terr_loc_co_desc IS 'Cession de tantième de terrains contre remise de locaux à construire : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_esti_imm_loca_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_esti_imm_loca_desc IS 'Location-accession – Estimation de l''immeuble objet de la location-accession : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_adju_obl_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_adju_obl_desc IS 'Rendue obligatoire par une disposition législative ou réglementaire : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_adju_fin_indivi_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_adju_fin_indivi_desc IS 'Mettant fin à une indivision ne résultant pas d''une donation-partage : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_cadre_titul_droit_prempt boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_cadre_titul_droit_prempt IS 'Cadre réservé au titulaire du droit de préemption';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mairie_prix_moyen boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mairie_prix_moyen IS 'Prix moyen au m²';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_propri_indivi boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_propri_indivi IS 'Si le bien est en indivision, indiquer le(s) nom(s)de l''(des) autres co-indivisaires et sa (leur) quote-part (7)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_situa_bien_plan_cadas_oui boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_situa_bien_plan_cadas_oui IS 'Plan(s) cadastral(aux) joint(s) : OUI';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_situa_bien_plan_cadas_non boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_situa_bien_plan_cadas_non IS 'Plan(s) cadastral(aux) joint(s) : NON';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_notif_dec_titul_adr_prop boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_notif_dec_titul_adr_prop IS 'A l''adresse du (des) propriétaire(s) mentionné(s) à la rubrique A';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_notif_dec_titul_adr_prop_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_notif_dec_titul_adr_prop_desc IS 'A l''adresse du (des) propriétaire(s) mentionné(s) à la rubrique A : description';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_notif_dec_titul_adr_manda boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_notif_dec_titul_adr_manda IS 'A l''adresse du mandataire mentionnée à la rubrique H, adresse où le(s) propriétaire(s) a (ont) fait élection de domicile';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_notif_dec_titul_adr_manda_desc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_notif_dec_titul_adr_manda_desc IS 'A l''adresse du mandataire mentionnée à la rubrique H, adresse où le(s) propriétaire(s) a (ont) fait élection de domicile : description';

-- Ajout des données techniques et CERFA manquantes pour les DIA
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_dia_dpu boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_dia_dpu IS 'Soumis au droit de préemption urbain (D.P.U) (articles L. 211-1 et suivants du Code de l''urbanisme (2))';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_dia_zad boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_dia_zad IS 'Compris dans une zone d''aménagement différé (Z.A.D.) (articles L.212-1- et suivants du Code de l''urbanisme (3))';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_dia_zone_preempt_esp_natu_sensi boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_dia_zone_preempt_esp_natu_sensi IS 'Compris dans une zone de préemption délimitée au titre des espaces naturels sensibles de départements (articles L. 142-1- et suivants du Code de l''urbanisme(4))';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_dab_dpu boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_dab_dpu IS 'Soumis au droit de préemption urbain (D.P.U.) (2)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_dab_zad boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_dab_zad IS 'Compris dans une zone d''aménagement différé (Z.A.D.) (3)';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_dia_dpu boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_dia_dpu IS 'Soumis au droit de préemption urbain (D.P.U) (articles L. 211-1 et suivants du Code de l''urbanisme (2))';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_dia_zad boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_dia_zad IS 'Compris dans une zone d''aménagement différé (Z.A.D.) (articles L.212-1- et suivants du Code de l''urbanisme (3))';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_dia_zone_preempt_esp_natu_sensi boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_dia_zone_preempt_esp_natu_sensi IS 'Compris dans une zone de préemption délimitée au titre des espaces naturels sensibles de départements (articles L. 142-1- et suivants du Code de l''urbanisme(4))';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_dab_dpu boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_dab_dpu IS 'Soumis au droit de préemption urbain (D.P.U.) (2)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_dab_zad boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_dab_zad IS 'Compris dans une zone d''aménagement différé (Z.A.D.) (3)';

-- Ajout des données techniques et CERFA manquantes pour les DIA : changement commission
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_commi_mnt numeric;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_commi_mnt IS 'Montant de la commision';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_commi_mnt_ttc boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_commi_mnt_ttc IS 'Le montant de la commission est TTC';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_commi_mnt_ht boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_commi_mnt_ht IS 'Le montant de la commission est HT';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_commi_mnt boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_commi_mnt IS 'Montant de la commision';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_commi_mnt_ttc boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_commi_mnt_ttc IS 'Le montant de la commission est TTC';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_commi_mnt_ht boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_commi_mnt_ht IS 'Le montant de la commission est HT';

-- Duplication des données techniques et CERFA pour les DIA : surface et montant en numeric
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_num IS 'Prix de vente ou évaluation (chiffres)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_mob_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_mob_num IS 'Dont éventuellement inclus : Mobilier (chiffres)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_cheptel_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_cheptel_num IS 'Dont éventuellement inclus : Cheptel (chiffres)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_recol_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_recol_num IS 'Dont éventuellement inclus : Récoltes (chiffres)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_autre_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_prix_vente_autre_num IS 'Dont éventuellement inclus : Autres (chiffres)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_su_co_sol_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_su_co_sol_num IS 'Surface construite au sol (m2) (chiffres)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_su_util_hab_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_su_util_hab_num IS 'Surface utile ou habitable (m2) (chiffres)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_mnt_an_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_an_num IS 'Montant annuel (chiffres)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_mnt_compt_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_compt_num IS 'Montant comptant (chiffres)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_mod_cess_mnt_soulte_num numeric;
COMMENT ON COLUMN donnees_techniques.dia_mod_cess_mnt_soulte_num IS 'Montant de la soulte le cas échéant (chiffres)';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_num IS 'Prix de vente ou évaluation (chiffres)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_mob_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_mob_num IS 'Dont éventuellement inclus : Mobilier (chiffres)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_cheptel_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_cheptel_num IS 'Dont éventuellement inclus : Cheptel (chiffres)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_recol_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_recol_num IS 'Dont éventuellement inclus : Récoltes (chiffres)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_prix_vente_autre_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_prix_vente_autre_num IS 'Dont éventuellement inclus : Autres (chiffres)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_su_co_sol_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_su_co_sol_num IS 'Surface construite au sol (m2) (chiffres)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_su_util_hab_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_su_util_hab_num IS 'Surface utile ou habitable (m2) (chiffres)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_mnt_an_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_an_num IS 'Montant annuel (chiffres)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_mnt_compt_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_compt_num IS 'Montant comptant (chiffres)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_mod_cess_mnt_soulte_num boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_mod_cess_mnt_soulte_num IS 'Montant de la soulte le cas échéant (chiffres)';

-- Ajout des données techniques et CERFA supplémentaires pour les DIA
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_comp_prix_vente numeric;
COMMENT ON COLUMN donnees_techniques.dia_comp_prix_vente IS 'Correspondant au prix détaillé par le vendeur dans le cadre F';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_comp_surface numeric;
COMMENT ON COLUMN donnees_techniques.dia_comp_surface IS 'correspondant aux champs du cerfa "surface utile ou habitable du bien" et/ou "surface au sol" tel que déclarée dans le cadre C';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_comp_total_frais numeric;
COMMENT ON COLUMN donnees_techniques.dia_comp_total_frais IS 'en l''absence de données saisies dans le cerfa sur les frais de notaire notamment, ce champ correspond au montant saisi dans le champ commission  situé dans le cadre F';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_comp_mtn_total numeric;
COMMENT ON COLUMN donnees_techniques.dia_comp_mtn_total IS 'Montant total (en €) (correspondant à l''addition du champ prix de vente et du champ total des frais)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_comp_valeur_m2 numeric;
COMMENT ON COLUMN donnees_techniques.dia_comp_valeur_m2 IS 'Valeur au m² (en €) (modélisation du prix au m² correspondant au champ surface divisé par le champ total)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_esti_prix_france_dom numeric;
COMMENT ON COLUMN donnees_techniques.dia_esti_prix_france_dom IS 'Estimation du prix de vente par France Domaine';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_prop_collectivite numeric;
COMMENT ON COLUMN donnees_techniques.dia_prop_collectivite IS 'Proposition d''acquisition de la collectivité';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_denomination character varying(40);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_denomination IS 'Délégataire à l''instruction de la demande : Dénomination';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_raison_sociale character varying(50);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_raison_sociale IS 'Délégataire à l''instruction de la demande : Raison sociale';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_siret character varying(15);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_siret IS 'Délégataire à l''instruction de la demande : Siret';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_categorie_juridique character varying(15);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_categorie_juridique IS 'Délégataire à l''instruction de la demande : Catégorie juridique';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_representant_nom character varying(250);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_representant_nom IS 'Délégataire à l''instruction de la demande : Nom du représentant';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_representant_prenom character varying(250);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_representant_prenom IS 'Délégataire à l''instruction de la demande : Prénom du représentant';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_numero character varying(10);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_numero IS 'Délégataire à l''instruction de la demande : Adresse : Numéro';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_voie character varying(55);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_voie IS 'Délégataire à l''instruction de la demande : Adresse : Voie';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_complement character varying(50);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_complement IS 'Délégataire à l''instruction de la demande : Adresse : Complément';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_lieu_dit character varying(39);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_lieu_dit IS 'Délégataire à l''instruction de la demande : Adresse : Lieu-dit';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_localite character varying(250);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_localite IS 'Délégataire à l''instruction de la demande : Adresse : Localité';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_code_postal character varying(5);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_code_postal IS 'Délégataire à l''instruction de la demande : Adresse : Code postal';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_bp character varying(5);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_bp IS 'Délégataire à l''instruction de la demande : Adresse : BP';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_cedex character varying(5);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_cedex IS 'Délégataire à l''instruction de la demande : Adresse : Cedex';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_pays character varying(250);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_adresse_pays IS 'Délégataire à l''instruction de la demande : Adresse : Pays';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_telephone_fixe character varying(20);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_telephone_fixe IS 'Délégataire à l''instruction de la demande : Téléphone fixe';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_telephone_mobile character varying(20);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_telephone_mobile IS 'Délégataire à l''instruction de la demande : Téléphone mobile';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_telephone_mobile_indicatif character varying(5);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_telephone_mobile_indicatif IS 'Délégataire à l''instruction de la demande : Indicatif';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_courriel character varying(250);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_courriel IS 'Délégataire à l''instruction de la demande : Courriel';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_delegataire_fax character varying(20);
COMMENT ON COLUMN donnees_techniques.dia_delegataire_fax IS 'Délégataire à l''instruction de la demande : Fax';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_entree_jouissance_type character varying(250);
COMMENT ON COLUMN donnees_techniques.dia_entree_jouissance_type IS 'Entrée en jouissance : Type';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_entree_jouissance_date date;
COMMENT ON COLUMN donnees_techniques.dia_entree_jouissance_date IS 'Entrée en jouissance : Date';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_entree_jouissance_date_effet date;
COMMENT ON COLUMN donnees_techniques.dia_entree_jouissance_date_effet IS 'Entrée en jouissance : Date d''effet';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_entree_jouissance_com text;
COMMENT ON COLUMN donnees_techniques.dia_entree_jouissance_com IS 'Entrée en jouissance : Commentaire';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_remise_bien_date_effet date;
COMMENT ON COLUMN donnees_techniques.dia_remise_bien_date_effet IS 'Remise du bien: Date d''effet';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS dia_remise_bien_com text;
COMMENT ON COLUMN donnees_techniques.dia_remise_bien_com IS 'Remise du bien: Commentaire';
--
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_comp_prix_vente boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_comp_prix_vente IS 'Correspondant au prix détaillé par le vendeur dans le cadre F';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_comp_surface boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_comp_surface IS 'correspondant aux champs du cerfa "surface utile ou habitable du bien" et/ou "surface au sol" tel que déclarée dans le cadre C';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_comp_total_frais boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_comp_total_frais IS 'en l''absence de données saisies dans le cerfa sur les frais de notaire notamment, ce champ correspond au montant saisi dans le champ commission  situé dans le cadre F';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_comp_mtn_total boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_comp_mtn_total IS 'Montant total (en €) (correspondant à l''addition du champ prix de vente et du champ total des frais)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_comp_valeur_m2 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_comp_valeur_m2 IS 'Valeur au m² (en €) (modélisation du prix au m² correspondant au champ surface divisé par le champ total)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_esti_prix_france_dom boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_esti_prix_france_dom IS 'Estimation du prix de vente par France Domaine';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_prop_collectivite boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_prop_collectivite IS 'Proposition d''acquisition de la collectivité';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_denomination boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_denomination IS 'Délégataire à l''instruction de la demande : Dénomination';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_raison_sociale boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_raison_sociale IS 'Délégataire à l''instruction de la demande : Raison sociale';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_siret boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_siret IS 'Délégataire à l''instruction de la demande : Siret';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_categorie_juridique boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_categorie_juridique IS 'Délégataire à l''instruction de la demande : Catégorie juridique';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_representant_nom boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_representant_nom IS 'Délégataire à l''instruction de la demande : Nom du représentant';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_representant_prenom boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_representant_prenom IS 'Délégataire à l''instruction de la demande : Prénom du représentant';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_numero boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_adresse_numero IS 'Délégataire à l''instruction de la demande : Adresse : Numéro';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_voie boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_adresse_voie IS 'Délégataire à l''instruction de la demande : Adresse : Voie';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_complement boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_adresse_complement IS 'Délégataire à l''instruction de la demande : Adresse : Complément';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_lieu_dit boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_adresse_lieu_dit IS 'Délégataire à l''instruction de la demande : Adresse : Lieu-dit';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_localite boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_adresse_localite IS 'Délégataire à l''instruction de la demande : Adresse : Localité';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_code_postal boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_adresse_code_postal IS 'Délégataire à l''instruction de la demande : Adresse : Code postal';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_bp boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_adresse_bp IS 'Délégataire à l''instruction de la demande : Adresse : BP';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_cedex boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_adresse_cedex IS 'Délégataire à l''instruction de la demande : Adresse : Cedex';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_adresse_pays boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_adresse_pays IS 'Délégataire à l''instruction de la demande : Adresse : Pays';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_telephone_fixe boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_telephone_fixe IS 'Délégataire à l''instruction de la demande : Téléphone fixe';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_telephone_mobile boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_telephone_mobile IS 'Délégataire à l''instruction de la demande : Téléphone mobile';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_telephone_mobile_indicatif boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_telephone_mobile_indicatif IS 'Délégataire à l''instruction de la demande : Indicatif';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_courriel boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_courriel IS 'Délégataire à l''instruction de la demande : Courriel';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_delegataire_fax boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_delegataire_fax IS 'Délégataire à l''instruction de la demande : Fax';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_entree_jouissance_type boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_entree_jouissance_type IS 'Entrée en jouissance : Type';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_entree_jouissance_date boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_entree_jouissance_date IS 'Entrée en jouissance : Date';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_entree_jouissance_date_effet boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_entree_jouissance_date_effet IS 'Entrée en jouissance : Date d''effet';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_entree_jouissance_com boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_entree_jouissance_com IS 'Entrée en jouissance : Commentaire';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_remise_bien_date_effet boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_remise_bien_date_effet IS 'Remise du bien: Date d''effet';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS dia_remise_bien_com boolean DEFAULT false;
COMMENT ON COLUMN cerfa.dia_remise_bien_com IS 'Remise du bien: Commentaire';

-- Mise à jour de la requête d'instruction
\i v5.14.0-om_requete.sql

--
-- END / [#9957] Mise à jour des données techniques et CERFA
--

--
-- BEGIN / [#9964] - Ajout du numéro d’archive
--
INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'gestion_numero_versement_archive', (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'gestion_numero_versement_archive' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'JURISTE')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'gestion_numero_versement_archive', (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'gestion_numero_versement_archive' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'TECHNICIEN')
);

INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'gestion_numero_versement_archive', (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'gestion_numero_versement_archive' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ASSISTANTE')
);


INSERT INTO om_droit (om_droit, libelle, om_profil)
SELECT nextval('om_droit_seq'), 'gestion_numero_versement_archive', (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
WHERE NOT EXISTS (
    SELECT om_droit FROM om_droit WHERE libelle = 'gestion_numero_versement_archive' AND om_profil = (SELECT om_profil FROM om_profil WHERE libelle = 'ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL')
);

--
-- END / [#9964] - Ajout du numéro d’archive
--

--
-- BEGIN / [#9976] - Notification automatique des tiers
--

-- Rename the column notification_tiers tmp_notification_tiers in order to store the value
ALTER TABLE
    evenement RENAME COLUMN notification_tiers TO tmp_notification_tiers;

-- Create a new column notification_tiers
ALTER TABLE
    evenement
ADD
    COLUMN notification_tiers character varying(50);

-- Set the value of notification_tiers to 'notification_manuelle' when the old notification was set to true
UPDATE
    evenement
SET
    notification_tiers = 'notification_manuelle'
WHERE
    tmp_notification_tiers IS TRUE;

-- remove the old column
ALTER TABLE
    evenement DROP COLUMN tmp_notification_tiers;

--
-- Name: evenement_type_habilitation_tiers_consulte; Type: TABLE; Schema: openads; Owner: -
--
CREATE TABLE evenement_type_habilitation_tiers_consulte (
    evenement_type_habilitation_tiers_consulte integer NOT NULL,
    evenement integer NOT NULL,
    type_habilitation_tiers_consulte integer NOT NULL
);

COMMENT ON COLUMN evenement_type_habilitation_tiers_consulte.evenement_type_habilitation_tiers_consulte IS 'Identifiant du lien entre un évènement et un type d''habilitation pouvant être notifié automatiquement.';

COMMENT ON COLUMN evenement_type_habilitation_tiers_consulte.evenement IS 'Identifiant du type d''habilitation de tiers qui sera automatiquement notifié à l''ajout de l''evenement lors d''une instruction.';

COMMENT ON COLUMN evenement_type_habilitation_tiers_consulte.type_habilitation_tiers_consulte IS 'Identifiant de l''évènement concerné.';

--
-- Name: evenement_type_habilitation_tiers_consulte_seq; Type: SEQUENCE; Schema: openads; Owner: -
--
CREATE SEQUENCE evenement_type_habilitation_tiers_consulte_seq
START WITH
    1 INCREMENT BY 1 NO MINVALUE NO MAXVALUE CACHE 1;

-- Primary keys
ALTER TABLE
    evenement_type_habilitation_tiers_consulte
ADD
    CONSTRAINT evenement_type_habilitation_tiers_consulte_pkey PRIMARY KEY (evenement_type_habilitation_tiers_consulte);

-- Foreign Kyes
ALTER TABLE
    ONLY evenement_type_habilitation_tiers_consulte
ADD
    CONSTRAINT evenement_type_habilitation_tc_evenement_fkey FOREIGN KEY (evenement) REFERENCES evenement(evenement);

ALTER TABLE
    ONLY evenement_type_habilitation_tiers_consulte
ADD
    CONSTRAINT evenement_type_habilitation_tc_type_habilitation_tc_fkey FOREIGN KEY (type_habilitation_tiers_consulte) REFERENCES type_habilitation_tiers_consulte(type_habilitation_tiers_consulte);

--
-- END / [#9976] - Notification automatique des tiers
--