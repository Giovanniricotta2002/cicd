-- MàJ de la version en BDD
UPDATE om_version SET om_version = '6.0.0' WHERE exists(SELECT 1 FROM om_version) = true;
INSERT INTO om_version
SELECT ('6.0.0') WHERE exists(SELECT 1 FROM om_version) = false;

--
-- [BEGIN] #10227 Augmentation du nombre de caractères pour le champ localité de la demande
--

ALTER TABLE demande ALTER COLUMN terrain_adresse_localite TYPE character varying(45);
ALTER TABLE dossier ALTER COLUMN terrain_adresse_localite TYPE character varying(45);
ALTER TABLE dossier_autorisation ALTER COLUMN terrain_adresse_localite TYPE character varying(45);

--
-- [END] #10227 Augmentation du nombre de caractères pour le champ localité de la demande
--

--
-- [BEGIN] #10240 Decriptif des travaux sur l'onglet DI débordant du champ
--

UPDATE donnees_techniques SET co_projet_desc = replace(co_projet_desc, ' ', ' ') WHERE co_projet_desc IS NOT NULL AND co_projet_desc != '';
UPDATE donnees_techniques SET ope_proj_desc = replace(ope_proj_desc, ' ', ' ') WHERE ope_proj_desc IS NOT NULL AND ope_proj_desc != '';
UPDATE donnees_techniques SET am_projet_desc = replace(am_projet_desc, ' ', ' ') WHERE am_projet_desc IS NOT NULL AND am_projet_desc != '';
UPDATE donnees_techniques SET dm_projet_desc = replace(dm_projet_desc, ' ', ' ') WHERE dm_projet_desc IS NOT NULL AND dm_projet_desc != '';

--
-- [END] #10240 Decriptif des travaux sur l'onglet DI débordant du champ
--

--
-- BEGIN / [#10236] Mise à jour des données techniques et CERFA
--

-- Ajout données techniques et cerfa
-- 3. Désignation du monument historique
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_design_appel_denom text;
COMMENT ON COLUMN donnees_techniques.mh_design_appel_denom IS 'Appellation / dénomination';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_design_type_protect character varying(200);
COMMENT ON COLUMN donnees_techniques.mh_design_type_protect IS 'Type de protection : classé, inscrit, classé et inscrit';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_design_elem_prot text;
COMMENT ON COLUMN donnees_techniques.mh_design_elem_prot IS 'Élément(s) protégé(s)';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_design_ref_merimee_palissy character varying(10);
COMMENT ON COLUMN donnees_techniques.mh_design_ref_merimee_palissy IS 'Référence Mérimée';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_design_nature_prop character varying(200);
COMMENT ON COLUMN donnees_techniques.mh_design_nature_prop IS 'Nature de la propriété : privée, publique, privée et publique';
-- 4. Localisation de l’immeuble protégé ou de l’immeuble abritant l’objet mobilier ou l’orgue protégé
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_loc_denom text;
COMMENT ON COLUMN donnees_techniques.mh_loc_denom IS 'Dénomination de l’immeuble';
-- 5. Présentation synthétique du projet
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_pres_intitule text;
COMMENT ON COLUMN donnees_techniques.mh_pres_intitule IS 'Intitulé de l’opération';
-- 6. Travaux sur l’immeuble
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_1 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_1 IS 'Catégorie des travaux prévus : Fondations, sous-sol';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_2 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_2 IS 'Catégorie des travaux prévus : Structure, maçonnerie, gros-œuvre';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_3 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_3 IS 'Catégorie des travaux prévus : Parements, enduits, restauration de façades';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_4 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_4 IS 'Catégorie des travaux prévus : Charpente, couverture';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_5 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_5 IS 'Catégorie des travaux prévus : Menuiseries, métallerie, vitraux';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_6 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_6 IS 'Catégorie des travaux prévus : Cloisons, revêtements intérieurs, décors';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_7 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_7 IS 'Catégorie des travaux prévus : Équipements techniques, sécurité, sureté, accessibilité';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_8 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_8 IS 'Catégorie des travaux prévus : Voirie et réseaux divers';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_9 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_9 IS 'Catégorie des travaux prévus : Affouillements ou exhaussements';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_10 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_10 IS 'Catégorie des travaux prévus : Sculptures';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_11 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_11 IS 'Catégorie des travaux prévus : Parcs, jardins et bois';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_12 boolean DEFAULT false;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_12 IS 'Catégorie des travaux prévus : Autres, préciser';
ALTER TABLE donnees_techniques ADD COLUMN IF NOT EXISTS mh_trav_cat_12_prec text;
COMMENT ON COLUMN donnees_techniques.mh_trav_cat_12_prec IS 'Catégorie des travaux prévus : Autres, préciser';
--
-- 3. Désignation du monument historique
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_design_appel_denom boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_design_appel_denom IS 'Appellation / dénomination';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_design_type_protect boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_design_type_protect IS 'Type de protection : classé, inscrit, classé et inscrit';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_design_elem_prot boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_design_elem_prot IS 'Élément(s) protégé(s)';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_design_ref_merimee_palissy boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_design_ref_merimee_palissy IS 'Référence Mérimée';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_design_nature_prop boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_design_nature_prop IS 'Nature de la propriété : privée, publique, privée et publique';
-- 4. Localisation de l’immeuble protégé ou de l’immeuble abritant l’objet mobilier ou l’orgue protégé
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_loc_denom boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_loc_denom IS 'Dénomination de l’immeuble';
-- 5. Présentation synthétique du projet
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_pres_intitule boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_pres_intitule IS 'Intitulé de l’opération';
-- 6. Travaux sur l’immeuble
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_1 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_1 IS 'Catégorie des travaux prévus : Fondations, sous-sol';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_2 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_2 IS 'Catégorie des travaux prévus : Structure, maçonnerie, gros-œuvre';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_3 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_3 IS 'Catégorie des travaux prévus : Parements, enduits, restauration de façades';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_4 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_4 IS 'Catégorie des travaux prévus : Charpente, couverture';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_5 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_5 IS 'Catégorie des travaux prévus : Menuiseries, métallerie, vitraux';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_6 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_6 IS 'Catégorie des travaux prévus : Cloisons, revêtements intérieurs, décors';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_7 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_7 IS 'Catégorie des travaux prévus : Équipements techniques, sécurité, sureté, accessibilité';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_8 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_8 IS 'Catégorie des travaux prévus : Voirie et réseaux divers';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_9 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_9 IS 'Catégorie des travaux prévus : Affouillements ou exhaussements';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_10 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_10 IS 'Catégorie des travaux prévus : Sculptures';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_11 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_11 IS 'Catégorie des travaux prévus : Parcs, jardins et bois';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_12 boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_12 IS 'Catégorie des travaux prévus : Autres, préciser';
ALTER TABLE cerfa ADD COLUMN IF NOT EXISTS mh_trav_cat_12_prec boolean DEFAULT false;
COMMENT ON COLUMN cerfa.mh_trav_cat_12_prec IS 'Catégorie des travaux prévus : Autres, préciser';

-- architecte
ALTER TABLE architecte ADD COLUMN IF NOT EXISTS titre_obt_diplo_spec text;
COMMENT ON COLUMN architecte.titre_obt_diplo_spec IS 'Titre d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';
ALTER TABLE architecte ADD COLUMN IF NOT EXISTS date_obt_diplo_spec date;
COMMENT ON COLUMN architecte.date_obt_diplo_spec IS 'Date d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';
ALTER TABLE architecte ADD COLUMN IF NOT EXISTS lieu_obt_diplo_spec text;
COMMENT ON COLUMN architecte.lieu_obt_diplo_spec IS 'Établissement / ville / pays d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';

-- demandeur architecte_lc
ALTER TABLE demandeur ADD COLUMN IF NOT EXISTS titre_obt_diplo_spec text;
COMMENT ON COLUMN demandeur.titre_obt_diplo_spec IS 'Titre d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';
ALTER TABLE demandeur ADD COLUMN IF NOT EXISTS date_obt_diplo_spec date;
COMMENT ON COLUMN demandeur.date_obt_diplo_spec IS 'Date d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';
ALTER TABLE demandeur ADD COLUMN IF NOT EXISTS lieu_obt_diplo_spec text;
COMMENT ON COLUMN demandeur.lieu_obt_diplo_spec IS 'Établissement / ville / pays d’obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent';

-- Mise à jour de la requête d'instruction
\i v6.0.0-om_requete.sql

--
-- END / [#10236] Mise à jour des données techniques et CERFA
--

--
-- BEGIN / [#10165] Ajout d'index dans la base de données
--

--

CREATE INDEX IF NOT EXISTS lien_id_interne_uid_externe_object_object_id_category ON lien_id_interne_uid_externe (object, object_id, category);
--
CREATE INDEX IF NOT EXISTS consultation_entrante_dossier_hash ON consultation_entrante USING HASH (dossier);
CREATE INDEX IF NOT EXISTS donnees_techniques_dossier_instruction_hash ON donnees_techniques USING HASH (dossier_instruction);
CREATE INDEX IF NOT EXISTS lien_dossier_nature_travaux_dossier_hash ON lien_dossier_nature_travaux USING HASH (dossier);
CREATE INDEX IF NOT EXISTS dossier_autorisation_nl_hash ON dossier_autorisation USING HASH (dossier_autorisation);
--
CREATE INDEX IF NOT EXISTS affectation_automatique_communes_hash ON affectation_automatique USING HASH (communes);
CREATE INDEX IF NOT EXISTS affectation_automatique_om_collectivite_hash ON affectation_automatique USING HASH (om_collectivite);
CREATE INDEX IF NOT EXISTS blocnote_dossier_hash ON blocnote USING HASH (dossier);
CREATE INDEX IF NOT EXISTS compteur_om_collectivite_hash ON compteur USING HASH (om_collectivite);
CREATE INDEX IF NOT EXISTS consultation_dossier_hash ON consultation USING HASH (dossier);
CREATE INDEX IF NOT EXISTS demande_dossier_autorisation_hash ON demande USING HASH (dossier_autorisation);
CREATE INDEX IF NOT EXISTS demande_dossier_instruction_hash ON demande USING HASH (dossier_instruction);
CREATE INDEX IF NOT EXISTS document_numerise_dossier_hash ON document_numerise USING HASH (dossier);
CREATE INDEX IF NOT EXISTS dossier_autorisation_parcelle_dossier_autorisation_hash ON dossier_autorisation_parcelle USING HASH (dossier_autorisation);
CREATE INDEX IF NOT EXISTS datd_dossier_autorisation_type_hash ON dossier_autorisation_type_detaille USING HASH (dossier_autorisation_type);
CREATE INDEX IF NOT EXISTS dossier_collectivite_hash ON dossier USING HASH (om_collectivite);
CREATE INDEX IF NOT EXISTS dossier_commission_dossier_hash ON dossier_commission USING HASH (dossier);
CREATE INDEX IF NOT EXISTS dossier_commune_hash ON dossier USING HASH (commune);
CREATE INDEX IF NOT EXISTS dossier_contrainte_dossier_hash ON dossier_contrainte USING HASH (dossier);
CREATE INDEX IF NOT EXISTS dossier_dossier_autorisation_hash ON dossier USING HASH (dossier_autorisation);
CREATE INDEX IF NOT EXISTS dossier_dossier_instruction_type_hash ON dossier USING HASH (dossier_instruction_type);
CREATE INDEX IF NOT EXISTS dossier_dossier_parent_hash ON dossier USING HASH (dossier_parent);
CREATE INDEX IF NOT EXISTS dossier_etat_idx_hash ON dossier USING HASH (etat);
CREATE INDEX IF NOT EXISTS dossier_geolocalisation_dossier_hash ON dossier_geolocalisation USING HASH (dossier);
CREATE INDEX IF NOT EXISTS dit_dossier_autorisation_type_detaille_hash ON dossier_instruction_type USING HASH (dossier_autorisation_type_detaille);
CREATE INDEX IF NOT EXISTS dossier_message_dossier_hash ON dossier_message USING HASH (dossier);
CREATE INDEX IF NOT EXISTS dossier_operateur_dossier_instruction_hash ON dossier_operateur USING HASH (dossier_instruction);
CREATE INDEX IF NOT EXISTS dossier_parcelle_dossier_idx_hash ON dossier_parcelle USING HASH (dossier);
CREATE INDEX IF NOT EXISTS habilitation_tiers_consulte_tiers_consulte_hash ON habilitation_tiers_consulte USING HASH (tiers_consulte);
CREATE INDEX IF NOT EXISTS htc_type_habilitation_tiers_consulte_hash ON habilitation_tiers_consulte USING HASH (type_habilitation_tiers_consulte);
CREATE INDEX IF NOT EXISTS instruction_dossier_idx_hash ON instruction USING HASH (dossier);
CREATE INDEX IF NOT EXISTS lien_cat_tiers_collectivite_collectivite_hash ON lien_categorie_tiers_consulte_om_collectivite USING HASH (om_collectivite);
CREATE INDEX IF NOT EXISTS lctcoc_categorie_tiers_consulte_hash ON lien_categorie_tiers_consulte_om_collectivite USING HASH (categorie_tiers_consulte);
CREATE INDEX IF NOT EXISTS lien_dit_nature_travaux_dit_hash ON lien_dit_nature_travaux USING HASH (dossier_instruction_type);
CREATE INDEX IF NOT EXISTS lien_dit_nature_travaux_nt_hash ON lien_dit_nature_travaux USING HASH (nature_travaux);
CREATE INDEX IF NOT EXISTS lien_dossier_demandeur_demandeur_idx_hash ON lien_dossier_demandeur USING HASH (demandeur);
CREATE INDEX IF NOT EXISTS lien_dossier_demandeur_dossier_hash ON lien_dossier_demandeur USING HASH (dossier);
CREATE INDEX IF NOT EXISTS lien_dossier_dossier_dossier_src_hash ON lien_dossier_dossier USING HASH (dossier_src);
CREATE INDEX IF NOT EXISTS ldit_categorie_tiers_hash ON lien_dossier_instruction_type_categorie_tiers USING HASH (categorie_tiers);
CREATE INDEX IF NOT EXISTS lditct_dossier_instruction_type_hash ON lien_dossier_instruction_type_categorie_tiers USING HASH (dossier_instruction_type);
CREATE INDEX IF NOT EXISTS lien_dossier_nature_travaux_nt_hash ON lien_dossier_nature_travaux USING HASH (nature_travaux);
CREATE INDEX IF NOT EXISTS lien_dossier_tiers_dossier_hash ON lien_dossier_tiers USING HASH (dossier);
CREATE INDEX IF NOT EXISTS lien_dossier_tiers_tiers_hash ON lien_dossier_tiers USING HASH (tiers);
CREATE INDEX IF NOT EXISTS lien_habilitation_tiers_consulte_commune_commune_hash ON lien_habilitation_tiers_consulte_commune USING HASH (commune);
CREATE INDEX IF NOT EXISTS lhtcc_habilitation_tiers_consulte_hash ON lien_habilitation_tiers_consulte_commune USING HASH (habilitation_tiers_consulte);
CREATE INDEX IF NOT EXISTS lien_habilitation_tiers_consulte_departement_departement_hash ON lien_habilitation_tiers_consulte_departement USING HASH (departement);
CREATE INDEX IF NOT EXISTS lhtcd_habilitation_tiers_consulte_hash ON lien_habilitation_tiers_consulte_departement USING HASH (habilitation_tiers_consulte);
CREATE INDEX IF NOT EXISTS lhtcstc_habilitation_tiers_consulte_hash ON lien_habilitation_tiers_consulte_specialite_tiers_consulte USING HASH (habilitation_tiers_consulte);
CREATE INDEX IF NOT EXISTS lhtcstc_specialite_tiers_consulte_hash ON lien_habilitation_tiers_consulte_specialite_tiers_consulte USING HASH (specialite_tiers_consulte);
CREATE INDEX IF NOT EXISTS lien_id_interne_uid_externe_dossier_hash ON lien_id_interne_uid_externe USING HASH (dossier);
CREATE INDEX IF NOT EXISTS lien_motif_consultation_om_collectivite_motif_consultation_hash ON lien_motif_consultation_om_collectivite USING HASH (motif_consultation);
CREATE INDEX IF NOT EXISTS lien_motif_consultation_om_collectivite_om_collectivite_hash ON lien_motif_consultation_om_collectivite USING HASH (om_collectivite);
CREATE INDEX IF NOT EXISTS lien_om_utilisateur_tiers_consulte_om_utilisateur_hash ON lien_om_utilisateur_tiers_consulte USING HASH (om_utilisateur);
CREATE INDEX IF NOT EXISTS lien_om_utilisateur_tiers_consulte_tiers_consulte_hash ON lien_om_utilisateur_tiers_consulte USING HASH (tiers_consulte);
CREATE INDEX IF NOT EXISTS lot_dossier_hash ON lot USING HASH (dossier);
CREATE INDEX IF NOT EXISTS lot_dossier_autorisation_hash ON lot USING HASH (dossier_autorisation);
CREATE INDEX IF NOT EXISTS rapport_instruction_dossier_instruction_hash ON rapport_instruction USING HASH (dossier_instruction);
CREATE INDEX IF NOT EXISTS task_dossier_hash ON task USING HASH (dossier);
CREATE INDEX IF NOT EXISTS task_object_id_hash ON task USING HASH (object_id);
CREATE INDEX IF NOT EXISTS tiers_consulte_categorie_hash ON tiers_consulte USING HASH (categorie_tiers_consulte);
--
-- END / [#10165] Ajout d'index dans la base de données
--
