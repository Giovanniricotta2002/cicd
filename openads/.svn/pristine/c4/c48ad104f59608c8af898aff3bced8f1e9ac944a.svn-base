--
-- BEGIN / [#9957] Mise à jour des données techniques et CERFA
--

-- Mise à jour de la requête d'instruction (XXX pour le moment exclusivement pour les DIA/DAB)
UPDATE om_requete SET requete = '
SELECT

    --Données générales de l''événement d''instruction
    signataire_arrete.agrement AS agrement_signataire,
    signataire_arrete.visa AS visa_signataire,
    signataire_arrete.visa_2 AS visa_signataire_2,
    signataire_arrete.visa_3 AS visa_signataire_3,
    signataire_arrete.visa_4 AS visa_signataire_4,
    consultation_entrante.service_consultant_libelle,
    
    instruction.complement_om_html as complement_instruction,
    instruction.complement_om_html as complement1_instruction,
    instruction.complement2_om_html as complement2_instruction,
    instruction.complement3_om_html as complement3_instruction,
    instruction.complement4_om_html as complement4_instruction,
    instruction.code_barres as code_barres_instruction,
    to_char(instruction.date_evenement,''DD/MM/YYYY'') as date_evenement_instruction, 
    om_lettretype.libelle as libelle_om_lettretype,
    instruction.archive_delai as archive_delai_instruction,

    --Données générales du dossier d''instruction

    dossier.dossier_libelle as libelle_dossier,
    dossier.dossier as code_barres_dossier,
    dossier_autorisation.dossier_autorisation_libelle as libelle_da,

    dossier_autorisation_type_detaille.code as code_datd,
    dossier_autorisation_type_detaille.libelle as libelle_datd,
    dossier_autorisation_type.code as code_dat,
    dossier_autorisation_type.libelle as libelle_dat,
    dossier_instruction_type.code as code_dit,
    dossier_instruction_type.libelle as libelle_dit,
    dossier.delai as delai_dossier,
    to_char(dossier_autorisation.date_decision, ''DD/MM/YYYY'') as date_decision_da,
    ( select string_agg(parcelles::text, '', '') from ( select dossier_parcelle.libelle as parcelles from &DB_PREFIXEdossier_parcelle where dossier_parcelle.dossier = dossier.dossier  order by dossier_parcelle.libelle ) as req_parcelles) as terrain_references_cadastrales_dossier,
    dossier.terrain_superficie as terrain_superficie_dossier,
    quartier.libelle as libelle_quartier,

    avis_decision.libelle as libelle_avis_decision,

    dossier_autorisation.cle_acces_citoyen,

    CASE WHEN dossier.depot_electronique IS TRUE
        THEN ''&mention_depot_electronique_recepisse''
        ELSE ''''
    END as mention_depot_electronique_recepisse,

    
    -- Localisation du dossier

    commune.com as commune_code,
    commune.libelle as commune_libelle,
    commune.dep as departement_code,
    departement.libelle as departement_libelle,
    commune.reg as region_code,
    region.libelle as region_libelle,

    -- Données contentieux du dossier d''instruction
    dossier.autorisation_contestee as autorisation_contestee,
    to_char(dossier.date_cloture_instruction, ''DD/MM/YYYY'') as date_cloture_instruction_dossier,
    to_char(dossier.date_premiere_visite, ''DD/MM/YYYY'') as date_premiere_visite_dossier,
    to_char(dossier.date_derniere_visite, ''DD/MM/YYYY'') as date_derniere_visite_dossier,
    to_char(dossier.date_contradictoire, ''DD/MM/YYYY'') as date_contradictoire_dossier,
    to_char(dossier.date_retour_contradictoire, ''DD/MM/YYYY'') as date_retour_contradictoire_dossier,
    to_char(dossier.date_ait, ''DD/MM/YYYY'') as date_ait_dossier,
    to_char(dossier.date_transmission_parquet, ''DD/MM/YYYY'') as date_transmission_parquet_dossier,

    --Données générales du paramétrage de l''événement

    evenement.libelle as libelle_evenement,
    evenement.etat as etat_evenement,
    evenement.delai as delai_evenement,
    evenement.accord_tacite as accord_tacite_evenement,
    evenement.delai_notification as delai_notification_evenement,
    evenement.avis_decision as avis_decision_evenement,
    evenement.autorite_competente as autorite_competente_evenement,

    --Coordonnées de l''instructeur

    instructeur.nom as nom_instructeur,
    instructeur.telephone as telephone_instructeur,
    division.code as division_instructeur,
    om_utilisateur.email as email_instructeur,

    -- Coordonnées de l''instructeur 2
    instructeur_2.nom as nom_instructeur_2,
    instructeur_2.telephone as telephone_instructeur_2,
    division_2.code as division_instructeur_2,
    om_utilisateur_2.email as email_instructeur_2,

    --Adresse du terrain du dossier d''instruction

    dossier.terrain_adresse_voie_numero as terrain_adresse_voie_numero_dossier,
&DB_PREFIXEadresse(dossier.terrain_adresse_voie_numero::text, dossier.terrain_adresse_voie::text, ''''::text, dossier.terrain_adresse_lieu_dit::text, dossier.terrain_adresse_bp::text, dossier.terrain_adresse_code_postal::text, dossier.terrain_adresse_localite::text, dossier.terrain_adresse_cedex::text) as adresse_terrain_sdl,
&DB_PREFIXEadresse(dossier.terrain_adresse_voie_numero::text, dossier.terrain_adresse_voie::text, ''''::text, dossier.terrain_adresse_lieu_dit::text, dossier.terrain_adresse_bp::text, dossier.terrain_adresse_code_postal::text, dossier.terrain_adresse_localite::text, dossier.terrain_adresse_cedex::text, '' ''::text) as adresse_terrain,
    dossier.terrain_adresse_voie as terrain_adresse_voie_dossier,
    dossier.terrain_adresse_lieu_dit as terrain_adresse_lieu_dit_dossier,
    CASE 
        WHEN dossier.terrain_adresse_bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', dossier.terrain_adresse_bp)
    END as terrain_adresse_bp_dossier,
    dossier.terrain_adresse_code_postal as terrain_adresse_code_postal_dossier,
    dossier.terrain_adresse_localite as terrain_adresse_localite_dossier,
    CASE 
        WHEN dossier.terrain_adresse_cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', dossier.terrain_adresse_cedex)
    END as terrain_adresse_cedex_dossier,

    arrondissement.libelle as libelle_arrondissement,

    --Taxe d''aménagement du dossier d''instruction
    CASE
        WHEN tax_secteur = 1 THEN taxe_amenagement.tx_comm_secteur_1
        WHEN tax_secteur = 2 THEN taxe_amenagement.tx_comm_secteur_2
        WHEN tax_secteur = 3 THEN taxe_amenagement.tx_comm_secteur_3
        WHEN tax_secteur = 4 THEN taxe_amenagement.tx_comm_secteur_4
        WHEN tax_secteur = 5 THEN taxe_amenagement.tx_comm_secteur_5
        WHEN tax_secteur = 6 THEN taxe_amenagement.tx_comm_secteur_6
        WHEN tax_secteur = 7 THEN taxe_amenagement.tx_comm_secteur_7
        WHEN tax_secteur = 8 THEN taxe_amenagement.tx_comm_secteur_8
        WHEN tax_secteur = 9 THEN taxe_amenagement.tx_comm_secteur_9
        WHEN tax_secteur = 10 THEN taxe_amenagement.tx_comm_secteur_10
        WHEN tax_secteur = 11 THEN taxe_amenagement.tx_comm_secteur_11
        WHEN tax_secteur = 12 THEN taxe_amenagement.tx_comm_secteur_12
        WHEN tax_secteur = 13 THEN taxe_amenagement.tx_comm_secteur_13
        WHEN tax_secteur = 14 THEN taxe_amenagement.tx_comm_secteur_14
        WHEN tax_secteur = 15 THEN taxe_amenagement.tx_comm_secteur_15
        WHEN tax_secteur = 16 THEN taxe_amenagement.tx_comm_secteur_16
        WHEN tax_secteur = 17 THEN taxe_amenagement.tx_comm_secteur_17
        WHEN tax_secteur = 18 THEN taxe_amenagement.tx_comm_secteur_18
        WHEN tax_secteur = 19 THEN taxe_amenagement.tx_comm_secteur_19
        WHEN tax_secteur = 20 THEN taxe_amenagement.tx_comm_secteur_20
    END as tax_taux_secteur,

    taxe_amenagement.tx_comm_secteur_1 as tax_taux_secteur_1,
    taxe_amenagement.tx_comm_secteur_2 as tax_taux_secteur_2,
    taxe_amenagement.tx_comm_secteur_3 as tax_taux_secteur_3,
    taxe_amenagement.tx_comm_secteur_4 as tax_taux_secteur_4,
    taxe_amenagement.tx_comm_secteur_5 as tax_taux_secteur_5,
    taxe_amenagement.tx_comm_secteur_6 as tax_taux_secteur_6,
    taxe_amenagement.tx_comm_secteur_7 as tax_taux_secteur_7,
    taxe_amenagement.tx_comm_secteur_8 as tax_taux_secteur_8,
    taxe_amenagement.tx_comm_secteur_9 as tax_taux_secteur_9,
    taxe_amenagement.tx_comm_secteur_10 as tax_taux_secteur_10,
    taxe_amenagement.tx_comm_secteur_11 as tax_taux_secteur_11,
    taxe_amenagement.tx_comm_secteur_12 as tax_taux_secteur_12,
    taxe_amenagement.tx_comm_secteur_13 as tax_taux_secteur_13,
    taxe_amenagement.tx_comm_secteur_14 as tax_taux_secteur_14,
    taxe_amenagement.tx_comm_secteur_15 as tax_taux_secteur_15,
    taxe_amenagement.tx_comm_secteur_16 as tax_taux_secteur_16,
    taxe_amenagement.tx_comm_secteur_17 as tax_taux_secteur_17,
    taxe_amenagement.tx_comm_secteur_18 as tax_taux_secteur_18,
    taxe_amenagement.tx_comm_secteur_19 as tax_taux_secteur_19,
    taxe_amenagement.tx_comm_secteur_20 as tax_taux_secteur_20,

    CASE WHEN taxe_amenagement.en_ile_de_france IS NULL
        OR taxe_amenagement.en_ile_de_france IS FALSE
        THEN ''Non''
        ELSE ''Oui''
    END as tax_en_ile_de_france,
    taxe_amenagement.val_forf_surf_cstr as tax_val_forf_surf_cstr,
    taxe_amenagement.val_forf_empl_tente_carav_rml as tax_val_forf_empl_tente_carav_rml,
    taxe_amenagement.val_forf_empl_hll as tax_val_forf_empl_hll,
    taxe_amenagement.val_forf_surf_piscine as tax_val_forf_surf_piscine,
    taxe_amenagement.val_forf_nb_eolienne as tax_val_forf_nb_eolienne,
    taxe_amenagement.val_forf_surf_pann_photo as tax_val_forf_surf_pann_photo,
    taxe_amenagement.val_forf_nb_parking_ext as tax_val_forf_nb_parking_ext,
    taxe_amenagement.tx_depart  as tax_tx_depart,
    taxe_amenagement.tx_reg as tax_tx_reg,
    taxe_amenagement.tx_exo_facul_1_reg as tax_tx_exo_facul_1_reg,
    taxe_amenagement.tx_exo_facul_2_reg as tax_tx_exo_facul_2_reg,
    taxe_amenagement.tx_exo_facul_3_reg as tax_tx_exo_facul_3_reg,
    taxe_amenagement.tx_exo_facul_4_reg as tax_tx_exo_facul_4_reg,
    taxe_amenagement.tx_exo_facul_5_reg as tax_tx_exo_facul_5_reg,
    taxe_amenagement.tx_exo_facul_6_reg as tax_tx_exo_facul_6_reg,
    taxe_amenagement.tx_exo_facul_7_reg as tax_tx_exo_facul_7_reg,
    taxe_amenagement.tx_exo_facul_8_reg as tax_tx_exo_facul_8_reg,
    taxe_amenagement.tx_exo_facul_9_reg as tax_tx_exo_facul_9_reg,
    taxe_amenagement.tx_exo_facul_1_depart  as tax_tx_exo_facul_1_depart,
    taxe_amenagement.tx_exo_facul_2_depart  as tax_tx_exo_facul_2_depart,
    taxe_amenagement.tx_exo_facul_3_depart  as tax_tx_exo_facul_3_depart,
    taxe_amenagement.tx_exo_facul_4_depart  as tax_tx_exo_facul_4_depart,
    taxe_amenagement.tx_exo_facul_5_depart  as tax_tx_exo_facul_5_depart,
    taxe_amenagement.tx_exo_facul_6_depart  as tax_tx_exo_facul_6_depart,
    taxe_amenagement.tx_exo_facul_7_depart  as tax_tx_exo_facul_7_depart,
    taxe_amenagement.tx_exo_facul_8_depart  as tax_tx_exo_facul_8_depart,
    taxe_amenagement.tx_exo_facul_9_depart  as tax_tx_exo_facul_9_depart,
    taxe_amenagement.tx_exo_facul_1_comm as tax_tx_exo_facul_1_comm,
    taxe_amenagement.tx_exo_facul_2_comm as tax_tx_exo_facul_2_comm,
    taxe_amenagement.tx_exo_facul_3_comm as tax_tx_exo_facul_3_comm,
    taxe_amenagement.tx_exo_facul_4_comm as tax_tx_exo_facul_4_comm,
    taxe_amenagement.tx_exo_facul_5_comm as tax_tx_exo_facul_5_comm,
    taxe_amenagement.tx_exo_facul_6_comm as tax_tx_exo_facul_6_comm,
    taxe_amenagement.tx_exo_facul_7_comm as tax_tx_exo_facul_7_comm,
    taxe_amenagement.tx_exo_facul_8_comm as tax_tx_exo_facul_8_comm,
    taxe_amenagement.tx_exo_facul_9_comm as tax_tx_exo_facul_9_comm,
    taxe_amenagement.tx_rap as tax_tx_rap,

    dossier.tax_mtn_rap as tax_montant_rap,
    CONCAT_WS('' '', ''Secteur'', dossier.tax_secteur) as tax_secteur,
    dossier.tax_secteur as tax_numero_secteur,
    dossier.tax_mtn_part_commu as tax_montant_part_communale,
    dossier.tax_mtn_part_depart as tax_montant_part_departementale,
    dossier.tax_mtn_part_reg as tax_montant_part_regionale,
    dossier.tax_mtn_total as tax_montant_total,

    --Coordonnées du pétitionnaire principal
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier'' OR petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_nom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_nom
        ELSE ''''
    END as nom_qualite_part_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
        ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
    END as nom_complet_qualite_pm_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
        THEN petitionnaire_principal.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
            END
    END as nom_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier'' OR petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_nom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN petitionnaire_principal.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_denomination
    END as denomination_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_siret
    END as siret_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_principal,
    petitionnaire_principal.numero as numero_petitionnaire_principal,
&DB_PREFIXEadresse(petitionnaire_principal.numero::text, petitionnaire_principal.voie::text, petitionnaire_principal.complement::text, petitionnaire_principal.lieu_dit::text, petitionnaire_principal.bp::text, petitionnaire_principal.code_postal::text, petitionnaire_principal.localite::text, petitionnaire_principal.cedex::text) as adresse_petitionnaire_principal_sdl,
&DB_PREFIXEadresse(petitionnaire_principal.numero::text, petitionnaire_principal.voie::text, petitionnaire_principal.complement::text, petitionnaire_principal.lieu_dit::text, petitionnaire_principal.bp::text, petitionnaire_principal.code_postal::text, petitionnaire_principal.localite::text, petitionnaire_principal.cedex::text, '' ''::text) as adresse_petitionnaire_principal,
    petitionnaire_principal.voie as voie_petitionnaire_principal,
    petitionnaire_principal.complement as complement_petitionnaire_principal,
    petitionnaire_principal.lieu_dit as lieu_dit_petitionnaire_principal,
    CASE 
        WHEN petitionnaire_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_principal.bp)
    END as bp_petitionnaire_principal,
    petitionnaire_principal.code_postal as code_postal_petitionnaire_principal,
    petitionnaire_principal.localite as localite_petitionnaire_principal,
    CASE 
        WHEN petitionnaire_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_principal.cedex)
    END as cedex_petitionnaire_principal,
    petitionnaire_principal.pays as pays_petitionnaire_principal,
    petitionnaire_principal.division_territoriale as division_territoriale_petitionnaire_principal,
    petitionnaire_principal.courriel as email_petitionnaire_principal,
    CASE WHEN petitionnaire_principal.notification IS TRUE
        THEN ''[X]''
        ELSE ''[ ]''
    END as notification_petitionnaire_principal,

    --Coordonnées du pétitionnaire principal initial
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_initial_civilite.libelle, petitionnaire_principal_initial.particulier_nom, petitionnaire_principal_initial.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_principal_initial.personne_morale_nom IS NOT NULL OR petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_initial.personne_morale_raison_sociale, petitionnaire_principal_initial.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_initial_civilite.libelle, petitionnaire_principal_initial.personne_morale_nom, petitionnaire_principal_initial.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_principal_initial.personne_morale_raison_sociale, '' '', petitionnaire_principal_initial.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier'' OR petitionnaire_principal_initial.personne_morale_nom IS NOT NULL OR petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_initial_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN petitionnaire_principal_initial.particulier_nom
        ELSE
            CASE WHEN petitionnaire_principal_initial.personne_morale_nom IS NOT NULL
                THEN petitionnaire_principal_initial.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN petitionnaire_principal_initial.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal_initial.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_initial_civilite.libelle, petitionnaire_principal_initial.particulier_nom, petitionnaire_principal_initial.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN petitionnaire_principal_initial_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN petitionnaire_principal_initial.particulier_nom
        ELSE ''''
    END as nom_qualite_part_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN petitionnaire_principal_initial.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.personne_morale_nom IS NOT NULL OR petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_initial.personne_morale_raison_sociale, petitionnaire_principal_initial.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_initial_civilite.libelle, petitionnaire_principal_initial.personne_morale_nom, petitionnaire_principal_initial.personne_morale_prenom))
        ELSE TRIM(CONCAT(petitionnaire_principal_initial.personne_morale_raison_sociale, '' '', petitionnaire_principal_initial.personne_morale_denomination))
    END as nom_complet_qualite_pm_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.personne_morale_nom IS NOT NULL OR petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_initial_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.personne_morale_nom IS NOT NULL
        THEN petitionnaire_principal_initial.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_initial.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_initial_civilite.libelle, petitionnaire_principal_initial.particulier_nom, petitionnaire_principal_initial.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_principal_initial.personne_morale_nom IS NOT NULL OR petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_initial.personne_morale_raison_sociale, petitionnaire_principal_initial.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_initial_civilite.libelle, petitionnaire_principal_initial.personne_morale_nom, petitionnaire_principal_initial.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_principal_initial.personne_morale_raison_sociale, '' '', petitionnaire_principal_initial.personne_morale_denomination))
            END
    END as nom_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier'' OR petitionnaire_principal_initial.personne_morale_nom IS NOT NULL OR petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_principal_initial_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN petitionnaire_principal_initial.particulier_nom
        ELSE
            CASE WHEN petitionnaire_principal_initial.personne_morale_nom IS NOT NULL
                THEN petitionnaire_principal_initial.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN petitionnaire_principal_initial.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_principal_initial.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal_initial.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal_initial.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal_initial.personne_morale_denomination
    END as denomination_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal_initial.personne_morale_siret
    END as siret_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_principal_initial.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_principal_initial,

    petitionnaire_principal_initial.numero as numero_petitionnaire_principal_initial,
&DB_PREFIXEadresse(petitionnaire_principal_initial.numero::text, petitionnaire_principal_initial.voie::text, petitionnaire_principal_initial.complement::text, petitionnaire_principal_initial.lieu_dit::text, petitionnaire_principal_initial.bp::text, petitionnaire_principal_initial.code_postal::text, petitionnaire_principal_initial.localite::text, petitionnaire_principal_initial.cedex::text) as adresse_petitionnaire_principal_initial_sdl,
&DB_PREFIXEadresse(petitionnaire_principal_initial.numero::text, petitionnaire_principal_initial.voie::text, petitionnaire_principal_initial.complement::text, petitionnaire_principal_initial.lieu_dit::text, petitionnaire_principal_initial.bp::text, petitionnaire_principal_initial.code_postal::text, petitionnaire_principal_initial.localite::text, petitionnaire_principal_initial.cedex::text, '' ''::text) as adresse_petitionnaire_principal_initial,
    petitionnaire_principal_initial.voie as voie_petitionnaire_principal_initial,
    petitionnaire_principal_initial.complement as complement_petitionnaire_principal_initial,
    petitionnaire_principal_initial.lieu_dit as lieu_dit_petitionnaire_principal_initial,
    CASE 
        WHEN petitionnaire_principal_initial.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_principal_initial.bp)
    END as bp_petitionnaire_principal_initial,
    petitionnaire_principal_initial.code_postal as code_postal_petitionnaire_principal_initial,
    petitionnaire_principal_initial.localite as localite_petitionnaire_principal_initial,
    CASE 
        WHEN petitionnaire_principal_initial.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_principal_initial.cedex)
    END as cedex_petitionnaire_principal_initial,
    petitionnaire_principal_initial.pays as pays_petitionnaire_principal,
    petitionnaire_principal_initial.division_territoriale as division_territoriale_petitionnaire_principal,
    petitionnaire_principal_initial.courriel as email_petitionnaire_principal_initial,
    CASE WHEN petitionnaire_principal_initial.notification IS TRUE
        THEN ''[X]''
        ELSE ''[ ]''
    END as notification_petitionnaire_principal_initial,

    --Coordonnées du pétitionnaire 1

    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_1_civilite.libelle, petitionnaire_1.particulier_nom, petitionnaire_1.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_1.personne_morale_raison_sociale, petitionnaire_1.personne_morale_denomination, ''représenté(e) par'', petitionnaire_1_civilite.libelle, petitionnaire_1.personne_morale_nom, petitionnaire_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_1.personne_morale_raison_sociale, '' '', petitionnaire_1.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier'' OR petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_nom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL
                THEN petitionnaire_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_1_civilite.libelle, petitionnaire_1.particulier_nom, petitionnaire_1.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_nom
        ELSE ''''
    END as nom_qualite_part_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_petitionnaire_1,
    CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', petitionnaire_1.personne_morale_raison_sociale, petitionnaire_1.personne_morale_denomination, ''représenté(e) par'', petitionnaire_1_civilite.libelle, petitionnaire_1.personne_morale_nom, petitionnaire_1.personne_morale_prenom))
        ELSE TRIM(CONCAT(petitionnaire_1.personne_morale_raison_sociale, '' '', petitionnaire_1.personne_morale_denomination))
    END as nom_complet_qualite_pm_petitionnaire_1,
    CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_petitionnaire_1,
    CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL
        THEN petitionnaire_1.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_petitionnaire_1,
    CASE WHEN petitionnaire_1.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_1.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_1_civilite.libelle, petitionnaire_1.particulier_nom, petitionnaire_1.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_1.personne_morale_raison_sociale, petitionnaire_1.personne_morale_denomination, ''représenté(e) par'', petitionnaire_1_civilite.libelle, petitionnaire_1.personne_morale_nom, petitionnaire_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_1.personne_morale_raison_sociale, '' '', petitionnaire_1.personne_morale_denomination))
            END
    END as nom_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier'' OR petitionnaire_1.personne_morale_nom IS NOT NULL OR petitionnaire_1.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_1_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_nom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_nom IS NOT NULL
                THEN petitionnaire_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN petitionnaire_1.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_1.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_denomination
    END as denomination_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_siret
    END as siret_petitionnaire_1,
    CASE WHEN petitionnaire_1.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_1.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_1,
    petitionnaire_1.numero as numero_petitionnaire_1,
&DB_PREFIXEadresse(petitionnaire_1.numero::text, petitionnaire_1.voie::text, petitionnaire_1.complement::text, petitionnaire_1.lieu_dit::text, petitionnaire_1.bp::text, petitionnaire_1.code_postal::text, petitionnaire_1.localite::text, petitionnaire_1.cedex::text) as adresse_petitionnaire_1_sdl,
&DB_PREFIXEadresse(petitionnaire_1.numero::text, petitionnaire_1.voie::text, petitionnaire_1.complement::text, petitionnaire_1.lieu_dit::text, petitionnaire_1.bp::text, petitionnaire_1.code_postal::text, petitionnaire_1.localite::text, petitionnaire_1.cedex::text, '' ''::text) as adresse_petitionnaire_1,
    petitionnaire_1.voie as voie_petitionnaire_1,
    petitionnaire_1.complement as complement_petitionnaire_1,
    petitionnaire_1.lieu_dit as lieu_dit_petitionnaire_1,
    CASE 
        WHEN petitionnaire_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_1.bp)
    END as bp_petitionnaire_1,
    petitionnaire_1.code_postal as code_postal_petitionnaire_1,
    petitionnaire_1.localite as localite_petitionnaire_1,
    CASE 
        WHEN petitionnaire_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_1.cedex)
    END as cedex_petitionnaire_1,
    petitionnaire_1.pays as pays_petitionnaire_1,
    petitionnaire_1.division_territoriale as division_territoriale_petitionnaire_1,

    --Coordonnées du pétitionnaire 2

    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_2_civilite.libelle, petitionnaire_2.particulier_nom, petitionnaire_2.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_2.personne_morale_raison_sociale, petitionnaire_2.personne_morale_denomination, ''représenté(e) par'', petitionnaire_2_civilite.libelle, petitionnaire_2.personne_morale_nom, petitionnaire_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_2.personne_morale_raison_sociale, '' '', petitionnaire_2.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier'' OR petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_nom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL
                THEN petitionnaire_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_2_civilite.libelle, petitionnaire_2.particulier_nom, petitionnaire_2.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_nom
        ELSE ''''
    END as nom_qualite_part_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_petitionnaire_2,
    CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', petitionnaire_2.personne_morale_raison_sociale, petitionnaire_2.personne_morale_denomination, ''représenté(e) par'', petitionnaire_2_civilite.libelle, petitionnaire_2.personne_morale_nom, petitionnaire_2.personne_morale_prenom))
        ELSE TRIM(CONCAT(petitionnaire_2.personne_morale_raison_sociale, '' '', petitionnaire_2.personne_morale_denomination))
    END as nom_complet_qualite_pm_petitionnaire_2,
    CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_petitionnaire_2,
    CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL
        THEN petitionnaire_2.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_petitionnaire_2,
    CASE WHEN petitionnaire_2.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_2.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_2_civilite.libelle, petitionnaire_2.particulier_nom, petitionnaire_2.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_2.personne_morale_raison_sociale, petitionnaire_2.personne_morale_denomination, ''représenté(e) par'', petitionnaire_2_civilite.libelle, petitionnaire_2.personne_morale_nom, petitionnaire_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_2.personne_morale_raison_sociale, '' '', petitionnaire_2.personne_morale_denomination))
            END
    END as nom_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier'' OR petitionnaire_2.personne_morale_nom IS NOT NULL OR petitionnaire_2.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_2_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_nom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_nom IS NOT NULL
                THEN petitionnaire_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN petitionnaire_2.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_2.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_denomination
    END as denomination_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_2,
    CASE WHEN petitionnaire_2.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_2.personne_morale_siret
    END as siret_petitionnaire_2,
    petitionnaire_2.numero as numero_petitionnaire_2,
&DB_PREFIXEadresse(petitionnaire_2.numero::text, petitionnaire_2.voie::text, petitionnaire_2.complement::text, petitionnaire_2.lieu_dit::text, petitionnaire_2.bp::text, petitionnaire_2.code_postal::text, petitionnaire_2.localite::text, petitionnaire_2.cedex::text) as adresse_petitionnaire_2_sdl,
&DB_PREFIXEadresse(petitionnaire_2.numero::text, petitionnaire_2.voie::text, petitionnaire_2.complement::text, petitionnaire_2.lieu_dit::text, petitionnaire_2.bp::text, petitionnaire_2.code_postal::text, petitionnaire_2.localite::text, petitionnaire_2.cedex::text, '' ''::text) as adresse_petitionnaire_2,
    petitionnaire_2.voie as voie_petitionnaire_2,
    petitionnaire_2.complement as complement_petitionnaire_2,
    petitionnaire_2.lieu_dit as lieu_dit_petitionnaire_2,
    CASE 
        WHEN petitionnaire_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_2.bp)
    END as bp_petitionnaire_2,
    petitionnaire_2.code_postal as code_postal_petitionnaire_2,
    petitionnaire_2.localite as localite_petitionnaire_2,
    CASE 
        WHEN petitionnaire_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_2.cedex)
    END as cedex_petitionnaire_2,
    petitionnaire_2.pays as pays_petitionnaire_2,
    petitionnaire_2.division_territoriale as division_territoriale_petitionnaire_2,

    --Coordonnées du pétitionnaire 3

    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_3_civilite.libelle, petitionnaire_3.particulier_nom, petitionnaire_3.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_3.personne_morale_raison_sociale, petitionnaire_3.personne_morale_denomination, ''représenté(e) par'', petitionnaire_3_civilite.libelle, petitionnaire_3.personne_morale_nom, petitionnaire_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_3.personne_morale_raison_sociale, '' '', petitionnaire_3.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier'' OR petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_nom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL
                THEN petitionnaire_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_3_civilite.libelle, petitionnaire_3.particulier_nom, petitionnaire_3.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_nom
        ELSE ''''
    END as nom_qualite_part_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_petitionnaire_3,
    CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', petitionnaire_3.personne_morale_raison_sociale, petitionnaire_3.personne_morale_denomination, ''représenté(e) par'', petitionnaire_3_civilite.libelle, petitionnaire_3.personne_morale_nom, petitionnaire_3.personne_morale_prenom))
        ELSE TRIM(CONCAT(petitionnaire_3.personne_morale_raison_sociale, '' '', petitionnaire_3.personne_morale_denomination))
    END as nom_complet_qualite_pm_petitionnaire_3,
    CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_petitionnaire_3,
    CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL
        THEN petitionnaire_3.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_petitionnaire_3,
    CASE WHEN petitionnaire_3.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_3.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_3_civilite.libelle, petitionnaire_3.particulier_nom, petitionnaire_3.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_3.personne_morale_raison_sociale, petitionnaire_3.personne_morale_denomination, ''représenté(e) par'', petitionnaire_3_civilite.libelle, petitionnaire_3.personne_morale_nom, petitionnaire_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_3.personne_morale_raison_sociale, '' '', petitionnaire_3.personne_morale_denomination))
            END
    END as nom_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier'' OR petitionnaire_3.personne_morale_nom IS NOT NULL OR petitionnaire_3.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_3_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_nom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_nom IS NOT NULL
                THEN petitionnaire_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN petitionnaire_3.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_3.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_denomination
    END as denomination_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_siret
    END as siret_petitionnaire_3,
    CASE WHEN petitionnaire_3.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_3.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_3,
    petitionnaire_3.numero as numero_petitionnaire_3,
&DB_PREFIXEadresse(petitionnaire_3.numero::text, petitionnaire_3.voie::text, petitionnaire_3.complement::text, petitionnaire_3.lieu_dit::text, petitionnaire_3.bp::text, petitionnaire_3.code_postal::text, petitionnaire_3.localite::text, petitionnaire_3.cedex::text) as adresse_petitionnaire_3_sdl,
&DB_PREFIXEadresse(petitionnaire_3.numero::text, petitionnaire_3.voie::text, petitionnaire_3.complement::text, petitionnaire_3.lieu_dit::text, petitionnaire_3.bp::text, petitionnaire_3.code_postal::text, petitionnaire_3.localite::text, petitionnaire_3.cedex::text, '' ''::text) as adresse_petitionnaire_3,
    petitionnaire_3.voie as voie_petitionnaire_3,
    petitionnaire_3.complement as complement_petitionnaire_3,
    petitionnaire_3.lieu_dit as lieu_dit_petitionnaire_3,
    CASE 
        WHEN petitionnaire_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_3.bp)
    END as bp_petitionnaire_3,
    petitionnaire_3.code_postal as code_postal_petitionnaire_3,
    petitionnaire_3.localite as localite_petitionnaire_3,
    CASE 
        WHEN petitionnaire_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_3.cedex)
    END as cedex_petitionnaire_3,
    petitionnaire_3.pays as pays_petitionnaire_3,
    petitionnaire_3.division_territoriale as division_territoriale_petitionnaire_3,

    --Coordonnées du pétitionnaire 4

    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_4_civilite.libelle, petitionnaire_4.particulier_nom, petitionnaire_4.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_4.personne_morale_raison_sociale, petitionnaire_4.personne_morale_denomination, ''représenté(e) par'', petitionnaire_4_civilite.libelle, petitionnaire_4.personne_morale_nom, petitionnaire_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_4.personne_morale_raison_sociale, '' '', petitionnaire_4.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier'' OR petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_nom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL
                THEN petitionnaire_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_4_civilite.libelle, petitionnaire_4.particulier_nom, petitionnaire_4.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_nom
        ELSE ''''
    END as nom_qualite_part_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_petitionnaire_4,
    CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', petitionnaire_4.personne_morale_raison_sociale, petitionnaire_4.personne_morale_denomination, ''représenté(e) par'', petitionnaire_4_civilite.libelle, petitionnaire_4.personne_morale_nom, petitionnaire_4.personne_morale_prenom))
        ELSE TRIM(CONCAT(petitionnaire_4.personne_morale_raison_sociale, '' '', petitionnaire_4.personne_morale_denomination))
    END as nom_complet_qualite_pm_petitionnaire_4,
    CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_petitionnaire_4,
    CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL
        THEN petitionnaire_4.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_petitionnaire_4,
    CASE WHEN petitionnaire_4.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_4.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_4_civilite.libelle, petitionnaire_4.particulier_nom, petitionnaire_4.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_4.personne_morale_raison_sociale, petitionnaire_4.personne_morale_denomination, ''représenté(e) par'', petitionnaire_4_civilite.libelle, petitionnaire_4.personne_morale_nom, petitionnaire_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_4.personne_morale_raison_sociale, '' '', petitionnaire_4.personne_morale_denomination))
            END
    END as nom_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier'' OR petitionnaire_4.personne_morale_nom IS NOT NULL OR petitionnaire_4.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_4_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_nom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_nom IS NOT NULL
                THEN petitionnaire_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN petitionnaire_4.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_4.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_denomination
    END as denomination_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_4,
    CASE WHEN petitionnaire_4.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_4.personne_morale_siret
    END as siret_petitionnaire_4,
    petitionnaire_4.numero as numero_petitionnaire_4,
&DB_PREFIXEadresse(petitionnaire_4.numero::text, petitionnaire_4.voie::text, petitionnaire_4.complement::text, petitionnaire_4.lieu_dit::text, petitionnaire_4.bp::text, petitionnaire_4.code_postal::text, petitionnaire_4.localite::text, petitionnaire_4.cedex::text) as adresse_petitionnaire_4_sdl,
&DB_PREFIXEadresse(petitionnaire_4.numero::text, petitionnaire_4.voie::text, petitionnaire_4.complement::text, petitionnaire_4.lieu_dit::text, petitionnaire_4.bp::text, petitionnaire_4.code_postal::text, petitionnaire_4.localite::text, petitionnaire_4.cedex::text, '' ''::text) as adresse_petitionnaire_4,
    petitionnaire_4.voie as voie_petitionnaire_4,
    petitionnaire_4.complement as complement_petitionnaire_4,
    petitionnaire_4.lieu_dit as lieu_dit_petitionnaire_4,
    CASE 
        WHEN petitionnaire_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_4.bp)
    END as bp_petitionnaire_4,
    petitionnaire_4.code_postal as code_postal_petitionnaire_4,
    petitionnaire_4.localite as localite_petitionnaire_4,
    CASE 
        WHEN petitionnaire_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_4.cedex)
    END as cedex_petitionnaire_4,
    petitionnaire_4.pays as pays_petitionnaire_4,
    petitionnaire_4.division_territoriale as division_territoriale_petitionnaire_4,

    --Coordonnées du pétitionnaire 5

    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_5_civilite.libelle, petitionnaire_5.particulier_nom, petitionnaire_5.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_5.personne_morale_raison_sociale, petitionnaire_5.personne_morale_denomination, ''représenté(e) par'', petitionnaire_5_civilite.libelle, petitionnaire_5.personne_morale_nom, petitionnaire_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_5.personne_morale_raison_sociale, '' '', petitionnaire_5.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier'' OR petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_nom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL
                THEN petitionnaire_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_5_civilite.libelle, petitionnaire_5.particulier_nom, petitionnaire_5.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_nom
        ELSE ''''
    END as nom_qualite_part_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_petitionnaire_5,
    CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', petitionnaire_5.personne_morale_raison_sociale, petitionnaire_5.personne_morale_denomination, ''représenté(e) par'', petitionnaire_5_civilite.libelle, petitionnaire_5.personne_morale_nom, petitionnaire_5.personne_morale_prenom))
        ELSE TRIM(CONCAT(petitionnaire_5.personne_morale_raison_sociale, '' '', petitionnaire_5.personne_morale_denomination))
    END as nom_complet_qualite_pm_petitionnaire_5,
    CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_petitionnaire_5,
    CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL
        THEN petitionnaire_5.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_petitionnaire_5,
    CASE WHEN petitionnaire_5.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_5.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', petitionnaire_5_civilite.libelle, petitionnaire_5.particulier_nom, petitionnaire_5.particulier_prenom))
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', petitionnaire_5.personne_morale_raison_sociale, petitionnaire_5.personne_morale_denomination, ''représenté(e) par'', petitionnaire_5_civilite.libelle, petitionnaire_5.personne_morale_nom, petitionnaire_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(petitionnaire_5.personne_morale_raison_sociale, '' '', petitionnaire_5.personne_morale_denomination))
            END
    END as nom_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier'' OR petitionnaire_5.personne_morale_nom IS NOT NULL OR petitionnaire_5.personne_morale_prenom IS NOT NULL
        THEN petitionnaire_5_civilite.libelle
        ELSE ''''
    END as civilite_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_nom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_nom IS NOT NULL
                THEN petitionnaire_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN petitionnaire_5.particulier_prenom
        ELSE
            CASE WHEN petitionnaire_5.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_raison_sociale
    END as raison_sociale_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_denomination
    END as denomination_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_categorie_juridique
    END as categorie_juridique_petitionnaire_5,
    CASE WHEN petitionnaire_5.qualite=''particulier''
        THEN ''''
        ELSE petitionnaire_5.personne_morale_siret
    END as siret_petitionnaire_5,
    petitionnaire_5.numero as numero_petitionnaire_5,
&DB_PREFIXEadresse(petitionnaire_5.numero::text, petitionnaire_5.voie::text, petitionnaire_5.complement::text, petitionnaire_5.lieu_dit::text, petitionnaire_5.bp::text, petitionnaire_5.code_postal::text, petitionnaire_5.localite::text, petitionnaire_5.cedex::text) as adresse_petitionnaire_5_sdl,
&DB_PREFIXEadresse(petitionnaire_5.numero::text, petitionnaire_5.voie::text, petitionnaire_5.complement::text, petitionnaire_5.lieu_dit::text, petitionnaire_5.bp::text, petitionnaire_5.code_postal::text, petitionnaire_5.localite::text, petitionnaire_5.cedex::text, '' ''::text) as adresse_petitionnaire_5,
    petitionnaire_5.voie as voie_petitionnaire_5,
    petitionnaire_5.complement as complement_petitionnaire_5,
    petitionnaire_5.lieu_dit as lieu_dit_petitionnaire_5,
    CASE 
        WHEN petitionnaire_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', petitionnaire_5.bp)
    END as bp_petitionnaire_5,
    petitionnaire_5.code_postal as code_postal_petitionnaire_5,
    petitionnaire_5.localite as localite_petitionnaire_5,
    CASE 
        WHEN petitionnaire_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', petitionnaire_5.cedex)
    END as cedex_petitionnaire_5,
    petitionnaire_5.pays as pays_petitionnaire_5,
    petitionnaire_5.division_territoriale as division_territoriale_petitionnaire_5,

    --Coordonnées du contrevenant principal

    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_principal_civilite.libelle, contrevenant_principal.particulier_nom, contrevenant_principal.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_principal.personne_morale_raison_sociale, contrevenant_principal.personne_morale_denomination, ''représenté(e) par'', contrevenant_principal_civilite.libelle, contrevenant_principal.personne_morale_nom, contrevenant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_principal.personne_morale_raison_sociale, '' '', contrevenant_principal.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier'' OR contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
        THEN contrevenant_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_nom
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL
                THEN contrevenant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_prenom
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_prenom IS NOT NULL
                THEN contrevenant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_principal_civilite.libelle, contrevenant_principal.particulier_nom, contrevenant_principal.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_nom
        ELSE ''''
    END as nom_qualite_part_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_contrevenant_principal,
    CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', contrevenant_principal.personne_morale_raison_sociale, contrevenant_principal.personne_morale_denomination, ''représenté(e) par'', contrevenant_principal_civilite.libelle, contrevenant_principal.personne_morale_nom, contrevenant_principal.personne_morale_prenom))
        ELSE TRIM(CONCAT(contrevenant_principal.personne_morale_raison_sociale, '' '', contrevenant_principal.personne_morale_denomination))
    END as nom_complet_qualite_pm_contrevenant_principal,
    CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
        THEN contrevenant_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_contrevenant_principal,
    CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL
        THEN contrevenant_principal.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_contrevenant_principal,
    CASE WHEN contrevenant_principal.personne_morale_prenom IS NOT NULL
        THEN contrevenant_principal.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_principal_civilite.libelle, contrevenant_principal.particulier_nom, contrevenant_principal.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_principal.personne_morale_raison_sociale, contrevenant_principal.personne_morale_denomination, ''représenté(e) par'', contrevenant_principal_civilite.libelle, contrevenant_principal.personne_morale_nom, contrevenant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_principal.personne_morale_raison_sociale, '' '', contrevenant_principal.personne_morale_denomination))
            END
    END as nom_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier'' OR contrevenant_principal.personne_morale_nom IS NOT NULL OR contrevenant_principal.personne_morale_prenom IS NOT NULL
        THEN contrevenant_principal_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_nom
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_nom IS NOT NULL
                THEN contrevenant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN contrevenant_principal.particulier_prenom
        ELSE
            CASE WHEN contrevenant_principal.personne_morale_prenom IS NOT NULL
                THEN contrevenant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_denomination
    END as denomination_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_siret
    END as siret_contrevenant_principal,
    CASE WHEN contrevenant_principal.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_principal.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_principal,
    contrevenant_principal.numero as numero_contrevenant_principal,
&DB_PREFIXEadresse(contrevenant_principal.numero::text, contrevenant_principal.voie::text, contrevenant_principal.complement::text, contrevenant_principal.lieu_dit::text, contrevenant_principal.bp::text, contrevenant_principal.code_postal::text, contrevenant_principal.localite::text, contrevenant_principal.cedex::text) as adresse_contrevenant_principal_sdl,
&DB_PREFIXEadresse(contrevenant_principal.numero::text, contrevenant_principal.voie::text, contrevenant_principal.complement::text, contrevenant_principal.lieu_dit::text, contrevenant_principal.bp::text, contrevenant_principal.code_postal::text, contrevenant_principal.localite::text, contrevenant_principal.cedex::text, '' ''::text) as adresse_contrevenant_principal,
    contrevenant_principal.voie as voie_contrevenant_principal,
    contrevenant_principal.complement as complement_contrevenant_principal,
    contrevenant_principal.lieu_dit as lieu_dit_contrevenant_principal,
    CASE 
        WHEN contrevenant_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_principal.bp)
    END as bp_contrevenant_principal,
    contrevenant_principal.code_postal as code_postal_contrevenant_principal,
    contrevenant_principal.localite as localite_contrevenant_principal,
    CASE 
        WHEN contrevenant_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_principal.cedex)
    END as cedex_contrevenant_principal,
    contrevenant_principal.pays as pays_contrevenant_principal,
    contrevenant_principal.division_territoriale as division_territoriale_contrevenant_principal,

    --Coordonnées du contrevenant 1

    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_1_civilite.libelle, contrevenant_1.particulier_nom, contrevenant_1.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_1.personne_morale_raison_sociale, contrevenant_1.personne_morale_denomination, ''représenté(e) par'', contrevenant_1_civilite.libelle, contrevenant_1.personne_morale_nom, contrevenant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_1.personne_morale_raison_sociale, '' '', contrevenant_1.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier'' OR contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
        THEN contrevenant_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_nom
        ELSE
            CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL
                THEN contrevenant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_prenom
        ELSE
            CASE WHEN contrevenant_1.personne_morale_prenom IS NOT NULL
                THEN contrevenant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_1_civilite.libelle, contrevenant_1.particulier_nom, contrevenant_1.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_nom
        ELSE ''''
    END as nom_qualite_part_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_contrevenant_1,
    CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', contrevenant_1.personne_morale_raison_sociale, contrevenant_1.personne_morale_denomination, ''représenté(e) par'', contrevenant_1_civilite.libelle, contrevenant_1.personne_morale_nom, contrevenant_1.personne_morale_prenom))
        ELSE TRIM(CONCAT(contrevenant_1.personne_morale_raison_sociale, '' '', contrevenant_1.personne_morale_denomination))
    END as nom_complet_qualite_pm_contrevenant_1,
    CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
        THEN contrevenant_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_contrevenant_1,
    CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL
        THEN contrevenant_1.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_contrevenant_1,
    CASE WHEN contrevenant_1.personne_morale_prenom IS NOT NULL
        THEN contrevenant_1.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_1_civilite.libelle, contrevenant_1.particulier_nom, contrevenant_1.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_1.personne_morale_raison_sociale, contrevenant_1.personne_morale_denomination, ''représenté(e) par'', contrevenant_1_civilite.libelle, contrevenant_1.personne_morale_nom, contrevenant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_1.personne_morale_raison_sociale, '' '', contrevenant_1.personne_morale_denomination))
            END
    END as nom_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier'' OR contrevenant_1.personne_morale_nom IS NOT NULL OR contrevenant_1.personne_morale_prenom IS NOT NULL
        THEN contrevenant_1_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_nom
        ELSE
            CASE WHEN contrevenant_1.personne_morale_nom IS NOT NULL
                THEN contrevenant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN contrevenant_1.particulier_prenom
        ELSE
            CASE WHEN contrevenant_1.personne_morale_prenom IS NOT NULL
                THEN contrevenant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_denomination
    END as denomination_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_siret
    END as siret_contrevenant_1,
    CASE WHEN contrevenant_1.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_1.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_1,
    contrevenant_1.numero as numero_contrevenant_1,
&DB_PREFIXEadresse(contrevenant_1.numero::text, contrevenant_1.voie::text, contrevenant_1.complement::text, contrevenant_1.lieu_dit::text, contrevenant_1.bp::text, contrevenant_1.code_postal::text, contrevenant_1.localite::text, contrevenant_1.cedex::text) as adresse_contrevenant_1_sdl,
&DB_PREFIXEadresse(contrevenant_1.numero::text, contrevenant_1.voie::text, contrevenant_1.complement::text, contrevenant_1.lieu_dit::text, contrevenant_1.bp::text, contrevenant_1.code_postal::text, contrevenant_1.localite::text, contrevenant_1.cedex::text, '' ''::text) as adresse_contrevenant_1,
    contrevenant_1.voie as voie_contrevenant_1,
    contrevenant_1.complement as complement_contrevenant_1,
    contrevenant_1.lieu_dit as lieu_dit_contrevenant_1,
    CASE 
        WHEN contrevenant_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_1.bp)
    END as bp_contrevenant_1,
    contrevenant_1.code_postal as code_postal_contrevenant_1,
    contrevenant_1.localite as localite_contrevenant_1,
    CASE 
        WHEN contrevenant_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_1.cedex)
    END as cedex_contrevenant_1,
    contrevenant_1.pays as pays_contrevenant_1,
    contrevenant_1.division_territoriale as division_territoriale_contrevenant_1,

    --Coordonnées du contrevenant 2

    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_2_civilite.libelle, contrevenant_2.particulier_nom, contrevenant_2.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_2.personne_morale_raison_sociale, contrevenant_2.personne_morale_denomination, ''représenté(e) par'', contrevenant_2_civilite.libelle, contrevenant_2.personne_morale_nom, contrevenant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_2.personne_morale_raison_sociale, '' '', contrevenant_2.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier'' OR contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
        THEN contrevenant_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_nom
        ELSE
            CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL
                THEN contrevenant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_prenom
        ELSE
            CASE WHEN contrevenant_2.personne_morale_prenom IS NOT NULL
                THEN contrevenant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_2_civilite.libelle, contrevenant_2.particulier_nom, contrevenant_2.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_nom
        ELSE ''''
    END as nom_qualite_part_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_contrevenant_2,
    CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', contrevenant_2.personne_morale_raison_sociale, contrevenant_2.personne_morale_denomination, ''représenté(e) par'', contrevenant_2_civilite.libelle, contrevenant_2.personne_morale_nom, contrevenant_2.personne_morale_prenom))
        ELSE TRIM(CONCAT(contrevenant_2.personne_morale_raison_sociale, '' '', contrevenant_2.personne_morale_denomination))
    END as nom_complet_qualite_pm_contrevenant_2,
    CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
        THEN contrevenant_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_contrevenant_2,
    CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL
        THEN contrevenant_2.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_contrevenant_2,
    CASE WHEN contrevenant_2.personne_morale_prenom IS NOT NULL
        THEN contrevenant_2.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_2_civilite.libelle, contrevenant_2.particulier_nom, contrevenant_2.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_2.personne_morale_raison_sociale, contrevenant_2.personne_morale_denomination, ''représenté(e) par'', contrevenant_2_civilite.libelle, contrevenant_2.personne_morale_nom, contrevenant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_2.personne_morale_raison_sociale, '' '', contrevenant_2.personne_morale_denomination))
            END
    END as nom_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier'' OR contrevenant_2.personne_morale_nom IS NOT NULL OR contrevenant_2.personne_morale_prenom IS NOT NULL
        THEN contrevenant_2_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_nom
        ELSE
            CASE WHEN contrevenant_2.personne_morale_nom IS NOT NULL
                THEN contrevenant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN contrevenant_2.particulier_prenom
        ELSE
            CASE WHEN contrevenant_2.personne_morale_prenom IS NOT NULL
                THEN contrevenant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_denomination
    END as denomination_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_2,
    CASE WHEN contrevenant_2.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_2.personne_morale_siret
    END as siret_contrevenant_2,
    contrevenant_2.numero as numero_contrevenant_2,
&DB_PREFIXEadresse(contrevenant_2.numero::text, contrevenant_2.voie::text, contrevenant_2.complement::text, contrevenant_2.lieu_dit::text, contrevenant_2.bp::text, contrevenant_2.code_postal::text, contrevenant_2.localite::text, contrevenant_2.cedex::text) as adresse_contrevenant_2_sdl,
&DB_PREFIXEadresse(contrevenant_2.numero::text, contrevenant_2.voie::text, contrevenant_2.complement::text, contrevenant_2.lieu_dit::text, contrevenant_2.bp::text, contrevenant_2.code_postal::text, contrevenant_2.localite::text, contrevenant_2.cedex::text, '' ''::text) as adresse_contrevenant_2,
    contrevenant_2.voie as voie_contrevenant_2,
    contrevenant_2.complement as complement_contrevenant_2,
    contrevenant_2.lieu_dit as lieu_dit_contrevenant_2,
    CASE 
        WHEN contrevenant_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_2.bp)
    END as bp_contrevenant_2,
    contrevenant_2.code_postal as code_postal_contrevenant_2,
    contrevenant_2.localite as localite_contrevenant_2,
    CASE 
        WHEN contrevenant_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_2.cedex)
    END as cedex_contrevenant_2,
    contrevenant_2.pays as pays_contrevenant_2,
    contrevenant_2.division_territoriale as division_territoriale_contrevenant_2,

    --Coordonnées du contrevenant 3

    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_3_civilite.libelle, contrevenant_3.particulier_nom, contrevenant_3.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_3.personne_morale_raison_sociale, contrevenant_3.personne_morale_denomination, ''représenté(e) par'', contrevenant_3_civilite.libelle, contrevenant_3.personne_morale_nom, contrevenant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_3.personne_morale_raison_sociale, '' '', contrevenant_3.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier'' OR contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN contrevenant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_nom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL
                THEN contrevenant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_prenom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN contrevenant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_3_civilite.libelle, contrevenant_3.particulier_nom, contrevenant_3.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_nom
        ELSE ''''
    END as nom_qualite_part_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_contrevenant_3,
    CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', contrevenant_3.personne_morale_raison_sociale, contrevenant_3.personne_morale_denomination, ''représenté(e) par'', contrevenant_3_civilite.libelle, contrevenant_3.personne_morale_nom, contrevenant_3.personne_morale_prenom))
        ELSE TRIM(CONCAT(contrevenant_3.personne_morale_raison_sociale, '' '', contrevenant_3.personne_morale_denomination))
    END as nom_complet_qualite_pm_contrevenant_3,
    CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN contrevenant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_contrevenant_3,
    CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL
        THEN contrevenant_3.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_contrevenant_3,
    CASE WHEN contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN contrevenant_3.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_3_civilite.libelle, contrevenant_3.particulier_nom, contrevenant_3.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_3.personne_morale_raison_sociale, contrevenant_3.personne_morale_denomination, ''représenté(e) par'', contrevenant_3_civilite.libelle, contrevenant_3.personne_morale_nom, contrevenant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_3.personne_morale_raison_sociale, '' '', contrevenant_3.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier'' OR contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN contrevenant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_nom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL
                THEN contrevenant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_prenom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN contrevenant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_3_civilite.libelle, contrevenant_3.particulier_nom, contrevenant_3.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_nom
        ELSE ''''
    END as nom_qualite_part_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_contrevenant_3,
    CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', contrevenant_3.personne_morale_raison_sociale, contrevenant_3.personne_morale_denomination, ''représenté(e) par'', contrevenant_3_civilite.libelle, contrevenant_3.personne_morale_nom, contrevenant_3.personne_morale_prenom))
        ELSE TRIM(CONCAT(contrevenant_3.personne_morale_raison_sociale, '' '', contrevenant_3.personne_morale_denomination))
    END as nom_complet_qualite_pm_contrevenant_3,
    CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN contrevenant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_contrevenant_3,
    CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL
        THEN contrevenant_3.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_contrevenant_3,
    CASE WHEN contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN contrevenant_3.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_3_civilite.libelle, contrevenant_3.particulier_nom, contrevenant_3.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_3.personne_morale_raison_sociale, contrevenant_3.personne_morale_denomination, ''représenté(e) par'', contrevenant_3_civilite.libelle, contrevenant_3.personne_morale_nom, contrevenant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_3.personne_morale_raison_sociale, '' '', contrevenant_3.personne_morale_denomination))
            END
    END as nom_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier'' OR contrevenant_3.personne_morale_nom IS NOT NULL OR contrevenant_3.personne_morale_prenom IS NOT NULL
        THEN contrevenant_3_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_nom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_nom IS NOT NULL
                THEN contrevenant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN contrevenant_3.particulier_prenom
        ELSE
            CASE WHEN contrevenant_3.personne_morale_prenom IS NOT NULL
                THEN contrevenant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_denomination
    END as denomination_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_siret
    END as siret_contrevenant_3,
    CASE WHEN contrevenant_3.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_3.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_3,
    contrevenant_3.numero as numero_contrevenant_3,
&DB_PREFIXEadresse(contrevenant_3.numero::text, contrevenant_3.voie::text, contrevenant_3.complement::text, contrevenant_3.lieu_dit::text, contrevenant_3.bp::text, contrevenant_3.code_postal::text, contrevenant_3.localite::text, contrevenant_3.cedex::text) as adresse_contrevenant_3_sdl,
&DB_PREFIXEadresse(contrevenant_3.numero::text, contrevenant_3.voie::text, contrevenant_3.complement::text, contrevenant_3.lieu_dit::text, contrevenant_3.bp::text, contrevenant_3.code_postal::text, contrevenant_3.localite::text, contrevenant_3.cedex::text, '' ''::text) as adresse_contrevenant_3,
    contrevenant_3.voie as voie_contrevenant_3,
    contrevenant_3.complement as complement_contrevenant_3,
    contrevenant_3.lieu_dit as lieu_dit_contrevenant_3,
    CASE 
        WHEN contrevenant_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_3.bp)
    END as bp_contrevenant_3,
    contrevenant_3.code_postal as code_postal_contrevenant_3,
    contrevenant_3.localite as localite_contrevenant_3,
    CASE 
        WHEN contrevenant_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_3.cedex)
    END as cedex_contrevenant_3,
    contrevenant_3.pays as pays_contrevenant_3,
    contrevenant_3.division_territoriale as division_territoriale_contrevenant_3,

    --Coordonnées du contrevenant 4

    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_4_civilite.libelle, contrevenant_4.particulier_nom, contrevenant_4.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_4.personne_morale_raison_sociale, contrevenant_4.personne_morale_denomination, ''représenté(e) par'', contrevenant_4_civilite.libelle, contrevenant_4.personne_morale_nom, contrevenant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_4.personne_morale_raison_sociale, '' '', contrevenant_4.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier'' OR contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
        THEN contrevenant_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_nom
        ELSE
            CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL
                THEN contrevenant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_prenom
        ELSE
            CASE WHEN contrevenant_4.personne_morale_prenom IS NOT NULL
                THEN contrevenant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_4_civilite.libelle, contrevenant_4.particulier_nom, contrevenant_4.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_nom
        ELSE ''''
    END as nom_qualite_part_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_contrevenant_4,
    CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', contrevenant_4.personne_morale_raison_sociale, contrevenant_4.personne_morale_denomination, ''représenté(e) par'', contrevenant_4_civilite.libelle, contrevenant_4.personne_morale_nom, contrevenant_4.personne_morale_prenom))
        ELSE TRIM(CONCAT(contrevenant_4.personne_morale_raison_sociale, '' '', contrevenant_4.personne_morale_denomination))
    END as nom_complet_qualite_pm_contrevenant_4,
    CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
        THEN contrevenant_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_contrevenant_4,
    CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL
        THEN contrevenant_4.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_contrevenant_4,
    CASE WHEN contrevenant_4.personne_morale_prenom IS NOT NULL
        THEN contrevenant_4.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_4_civilite.libelle, contrevenant_4.particulier_nom, contrevenant_4.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_4.personne_morale_raison_sociale, contrevenant_4.personne_morale_denomination, ''représenté(e) par'', contrevenant_4_civilite.libelle, contrevenant_4.personne_morale_nom, contrevenant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_4.personne_morale_raison_sociale, '' '', contrevenant_4.personne_morale_denomination))
            END
    END as nom_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier'' OR contrevenant_4.personne_morale_nom IS NOT NULL OR contrevenant_4.personne_morale_prenom IS NOT NULL
        THEN contrevenant_4_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_nom
        ELSE
            CASE WHEN contrevenant_4.personne_morale_nom IS NOT NULL
                THEN contrevenant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN contrevenant_4.particulier_prenom
        ELSE
            CASE WHEN contrevenant_4.personne_morale_prenom IS NOT NULL
                THEN contrevenant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_denomination
    END as denomination_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_4,
    CASE WHEN contrevenant_4.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_4.personne_morale_siret
    END as siret_contrevenant_4,
    contrevenant_4.numero as numero_contrevenant_4,
&DB_PREFIXEadresse(contrevenant_4.numero::text, contrevenant_4.voie::text, contrevenant_4.complement::text, contrevenant_4.lieu_dit::text, contrevenant_4.bp::text, contrevenant_4.code_postal::text, contrevenant_4.localite::text, contrevenant_4.cedex::text) as adresse_contrevenant_4_sdl,
&DB_PREFIXEadresse(contrevenant_4.numero::text, contrevenant_4.voie::text, contrevenant_4.complement::text, contrevenant_4.lieu_dit::text, contrevenant_4.bp::text, contrevenant_4.code_postal::text, contrevenant_4.localite::text, contrevenant_4.cedex::text, '' ''::text) as adresse_contrevenant_4,
    contrevenant_4.voie as voie_contrevenant_4,
    contrevenant_4.complement as complement_contrevenant_4,
    contrevenant_4.lieu_dit as lieu_dit_contrevenant_4,
    CASE 
        WHEN contrevenant_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_4.bp)
    END as bp_contrevenant_4,
    contrevenant_4.code_postal as code_postal_contrevenant_4,
    contrevenant_4.localite as localite_contrevenant_4,
    CASE 
        WHEN contrevenant_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_4.cedex)
    END as cedex_contrevenant_4,
    contrevenant_4.pays as pays_contrevenant_4,
    contrevenant_4.division_territoriale as division_territoriale_contrevenant_4,

    --Coordonnées du contrevenant 5

    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', contrevenant_5_civilite.libelle, contrevenant_5.particulier_nom, contrevenant_5.particulier_prenom))
        ELSE
            CASE WHEN contrevenant_5.personne_morale_nom IS NOT NULL OR contrevenant_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', contrevenant_5.personne_morale_raison_sociale, contrevenant_5.personne_morale_denomination, ''représenté(e) par'', contrevenant_5_civilite.libelle, contrevenant_5.personne_morale_nom, contrevenant_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(contrevenant_5.personne_morale_raison_sociale, '' '', contrevenant_5.personne_morale_denomination))
            END
    END as nom_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier'' OR contrevenant_5.personne_morale_nom IS NOT NULL OR contrevenant_5.personne_morale_prenom IS NOT NULL
        THEN contrevenant_5_civilite.libelle
        ELSE ''''
    END as civilite_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN contrevenant_5.particulier_nom
        ELSE
            CASE WHEN contrevenant_5.personne_morale_nom IS NOT NULL
                THEN contrevenant_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN contrevenant_5.particulier_prenom
        ELSE
            CASE WHEN contrevenant_5.personne_morale_prenom IS NOT NULL
                THEN contrevenant_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_raison_sociale
    END as raison_sociale_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_denomination
    END as denomination_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_categorie_juridique
    END as categorie_juridique_contrevenant_5,
    CASE WHEN contrevenant_5.qualite=''particulier''
        THEN ''''
        ELSE contrevenant_5.personne_morale_siret
    END as siret_contrevenant_5,
    contrevenant_5.numero as numero_contrevenant_5,
&DB_PREFIXEadresse(contrevenant_5.numero::text, contrevenant_5.voie::text, contrevenant_5.complement::text, contrevenant_5.lieu_dit::text, contrevenant_5.bp::text, contrevenant_5.code_postal::text, contrevenant_5.localite::text, contrevenant_5.cedex::text) as adresse_contrevenant_5_sdl,
&DB_PREFIXEadresse(contrevenant_5.numero::text, contrevenant_5.voie::text, contrevenant_5.complement::text, contrevenant_5.lieu_dit::text, contrevenant_5.bp::text, contrevenant_5.code_postal::text, contrevenant_5.localite::text, contrevenant_5.cedex::text, '' ''::text) as adresse_contrevenant_5,
    contrevenant_5.voie as voie_contrevenant_5,
    contrevenant_5.complement as complement_contrevenant_5,
    contrevenant_5.lieu_dit as lieu_dit_contrevenant_5,
    CASE 
        WHEN contrevenant_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', contrevenant_5.bp)
    END as bp_contrevenant_5,
    contrevenant_5.code_postal as code_postal_contrevenant_5,
    contrevenant_5.localite as localite_contrevenant_5,
    CASE 
        WHEN contrevenant_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', contrevenant_5.cedex)
    END as cedex_contrevenant_5,
    contrevenant_5.pays as pays_contrevenant_5,
    contrevenant_5.division_territoriale as division_territoriale_contrevenant_5,

    --Coordonnées du requérant principal

    CASE WHEN requerant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_principal_civilite.libelle, requerant_principal.particulier_nom, requerant_principal.particulier_prenom))
        ELSE
            CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_principal.personne_morale_raison_sociale, requerant_principal.personne_morale_denomination, ''représenté(e) par'', requerant_principal_civilite.libelle, requerant_principal.personne_morale_nom, requerant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_principal.personne_morale_raison_sociale, '' '', requerant_principal.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier'' OR requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
        THEN requerant_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_nom
        ELSE
            CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL
                THEN requerant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_prenom
        ELSE
            CASE WHEN requerant_principal.personne_morale_prenom IS NOT NULL
                THEN requerant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_principal_civilite.libelle, requerant_principal.particulier_nom, requerant_principal.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_nom
        ELSE ''''
    END as nom_qualite_part_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_requerant_principal,
    CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', requerant_principal.personne_morale_raison_sociale, requerant_principal.personne_morale_denomination, ''représenté(e) par'', requerant_principal_civilite.libelle, requerant_principal.personne_morale_nom, requerant_principal.personne_morale_prenom))
        ELSE TRIM(CONCAT(requerant_principal.personne_morale_raison_sociale, '' '', requerant_principal.personne_morale_denomination))
    END as nom_complet_qualite_pm_requerant_principal,
    CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
        THEN requerant_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_requerant_principal,
    CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL
        THEN requerant_principal.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_requerant_principal,
    CASE WHEN requerant_principal.personne_morale_prenom IS NOT NULL
        THEN requerant_principal.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_principal_civilite.libelle, requerant_principal.particulier_nom, requerant_principal.particulier_prenom))
        ELSE
            CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_principal.personne_morale_raison_sociale, requerant_principal.personne_morale_denomination, ''représenté(e) par'', requerant_principal_civilite.libelle, requerant_principal.personne_morale_nom, requerant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_principal.personne_morale_raison_sociale, '' '', requerant_principal.personne_morale_denomination))
            END
    END as nom_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier'' OR requerant_principal.personne_morale_nom IS NOT NULL OR requerant_principal.personne_morale_prenom IS NOT NULL
        THEN requerant_principal_civilite.libelle
        ELSE ''''
    END as civilite_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_nom
        ELSE
            CASE WHEN requerant_principal.personne_morale_nom IS NOT NULL
                THEN requerant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN requerant_principal.particulier_prenom
        ELSE
            CASE WHEN requerant_principal.personne_morale_prenom IS NOT NULL
                THEN requerant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_raison_sociale
    END as raison_sociale_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_denomination
    END as denomination_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_siret
    END as siret_requerant_principal,
    CASE WHEN requerant_principal.qualite=''particulier''
        THEN ''''
        ELSE requerant_principal.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_principal,
    requerant_principal.numero as numero_requerant_principal,
&DB_PREFIXEadresse(requerant_principal.numero::text, requerant_principal.voie::text, requerant_principal.complement::text, requerant_principal.lieu_dit::text, requerant_principal.bp::text, requerant_principal.code_postal::text, requerant_principal.localite::text, requerant_principal.cedex::text) as adresse_requerant_principal_sdl,
&DB_PREFIXEadresse(requerant_principal.numero::text, requerant_principal.voie::text, requerant_principal.complement::text, requerant_principal.lieu_dit::text, requerant_principal.bp::text, requerant_principal.code_postal::text, requerant_principal.localite::text, requerant_principal.cedex::text, '' ''::text) as adresse_requerant_principal,
    requerant_principal.voie as voie_requerant_principal,
    requerant_principal.complement as complement_requerant_principal,
    requerant_principal.lieu_dit as lieu_dit_requerant_principal,
    CASE 
        WHEN requerant_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_principal.bp)
    END as bp_requerant_principal,
    requerant_principal.code_postal as code_postal_requerant_principal,
    requerant_principal.localite as localite_requerant_principal,
    CASE 
        WHEN requerant_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_principal.cedex)
    END as cedex_requerant_principal,
    requerant_principal.pays as pays_requerant_principal,
    requerant_principal.division_territoriale as division_territoriale_requerant_principal,

    --Coordonnées du requérant 1

    CASE WHEN requerant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_1_civilite.libelle, requerant_1.particulier_nom, requerant_1.particulier_prenom))
        ELSE
            CASE WHEN requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_1.personne_morale_raison_sociale, requerant_1.personne_morale_denomination, ''représenté(e) par'', requerant_1_civilite.libelle, requerant_1.personne_morale_nom, requerant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_1.personne_morale_raison_sociale, '' '', requerant_1.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier'' OR requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
        THEN requerant_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_nom
        ELSE
            CASE WHEN requerant_1.personne_morale_nom IS NOT NULL
                THEN requerant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_prenom
        ELSE
            CASE WHEN requerant_1.personne_morale_prenom IS NOT NULL
                THEN requerant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_1_civilite.libelle, requerant_1.particulier_nom, requerant_1.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_nom
        ELSE ''''
    END as nom_qualite_part_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_requerant_1,
    CASE WHEN requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', requerant_1.personne_morale_raison_sociale, requerant_1.personne_morale_denomination, ''représenté(e) par'', requerant_1_civilite.libelle, requerant_1.personne_morale_nom, requerant_1.personne_morale_prenom))
        ELSE TRIM(CONCAT(requerant_1.personne_morale_raison_sociale, '' '', requerant_1.personne_morale_denomination))
    END as nom_complet_qualite_pm_requerant_1,
    CASE WHEN requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
        THEN requerant_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_requerant_1,
    CASE WHEN requerant_1.personne_morale_nom IS NOT NULL
        THEN requerant_1.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_requerant_1,
    CASE WHEN requerant_1.personne_morale_prenom IS NOT NULL
        THEN requerant_1.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_1_civilite.libelle, requerant_1.particulier_nom, requerant_1.particulier_prenom))
        ELSE
            CASE WHEN requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_1.personne_morale_raison_sociale, requerant_1.personne_morale_denomination, ''représenté(e) par'', requerant_1_civilite.libelle, requerant_1.personne_morale_nom, requerant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_1.personne_morale_raison_sociale, '' '', requerant_1.personne_morale_denomination))
            END
    END as nom_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier'' OR requerant_1.personne_morale_nom IS NOT NULL OR requerant_1.personne_morale_prenom IS NOT NULL
        THEN requerant_1_civilite.libelle
        ELSE ''''
    END as civilite_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_nom
        ELSE
            CASE WHEN requerant_1.personne_morale_nom IS NOT NULL
                THEN requerant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN requerant_1.particulier_prenom
        ELSE
            CASE WHEN requerant_1.personne_morale_prenom IS NOT NULL
                THEN requerant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_raison_sociale
    END as raison_sociale_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_denomination
    END as denomination_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_siret
    END as siret_requerant_1,
    CASE WHEN requerant_1.qualite=''particulier''
        THEN ''''
        ELSE requerant_1.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_1,
    requerant_1.numero as numero_requerant_1,
&DB_PREFIXEadresse(requerant_1.numero::text, requerant_1.voie::text, requerant_1.complement::text, requerant_1.lieu_dit::text, requerant_1.bp::text, requerant_1.code_postal::text, requerant_1.localite::text, requerant_1.cedex::text) as adresse_requerant_1_sdl,
&DB_PREFIXEadresse(requerant_1.numero::text, requerant_1.voie::text, requerant_1.complement::text, requerant_1.lieu_dit::text, requerant_1.bp::text, requerant_1.code_postal::text, requerant_1.localite::text, requerant_1.cedex::text, '' ''::text) as adresse_requerant_1,
    requerant_1.voie as voie_requerant_1,
    requerant_1.complement as complement_requerant_1,
    requerant_1.lieu_dit as lieu_dit_requerant_1,
    CASE 
        WHEN requerant_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_1.bp)
    END as bp_requerant_1,
    requerant_1.code_postal as code_postal_requerant_1,
    requerant_1.localite as localite_requerant_1,
    CASE 
        WHEN requerant_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_1.cedex)
    END as cedex_requerant_1,
    requerant_1.pays as pays_requerant_1,
    requerant_1.division_territoriale as division_territoriale_requerant_1,

    --Coordonnées du requérant 2

    CASE WHEN requerant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_2_civilite.libelle, requerant_2.particulier_nom, requerant_2.particulier_prenom))
        ELSE
            CASE WHEN requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_2.personne_morale_raison_sociale, requerant_2.personne_morale_denomination, ''représenté(e) par'', requerant_2_civilite.libelle, requerant_2.personne_morale_nom, requerant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_2.personne_morale_raison_sociale, '' '', requerant_2.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier'' OR requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
        THEN requerant_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_nom
        ELSE
            CASE WHEN requerant_2.personne_morale_nom IS NOT NULL
                THEN requerant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_prenom
        ELSE
            CASE WHEN requerant_2.personne_morale_prenom IS NOT NULL
                THEN requerant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_2_civilite.libelle, requerant_2.particulier_nom, requerant_2.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_nom
        ELSE ''''
    END as nom_qualite_part_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_requerant_2,
    CASE WHEN requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', requerant_2.personne_morale_raison_sociale, requerant_2.personne_morale_denomination, ''représenté(e) par'', requerant_2_civilite.libelle, requerant_2.personne_morale_nom, requerant_2.personne_morale_prenom))
        ELSE TRIM(CONCAT(requerant_2.personne_morale_raison_sociale, '' '', requerant_2.personne_morale_denomination))
    END as nom_complet_qualite_pm_requerant_2,
    CASE WHEN requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
        THEN requerant_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_requerant_2,
    CASE WHEN requerant_2.personne_morale_nom IS NOT NULL
        THEN requerant_2.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_requerant_2,
    CASE WHEN requerant_2.personne_morale_prenom IS NOT NULL
        THEN requerant_2.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_2_civilite.libelle, requerant_2.particulier_nom, requerant_2.particulier_prenom))
        ELSE
            CASE WHEN requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_2.personne_morale_raison_sociale, requerant_2.personne_morale_denomination, ''représenté(e) par'', requerant_2_civilite.libelle, requerant_2.personne_morale_nom, requerant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_2.personne_morale_raison_sociale, '' '', requerant_2.personne_morale_denomination))
            END
    END as nom_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier'' OR requerant_2.personne_morale_nom IS NOT NULL OR requerant_2.personne_morale_prenom IS NOT NULL
        THEN requerant_2_civilite.libelle
        ELSE ''''
    END as civilite_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_nom
        ELSE
            CASE WHEN requerant_2.personne_morale_nom IS NOT NULL
                THEN requerant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN requerant_2.particulier_prenom
        ELSE
            CASE WHEN requerant_2.personne_morale_prenom IS NOT NULL
                THEN requerant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_raison_sociale
    END as raison_sociale_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_denomination
    END as denomination_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_2,
    CASE WHEN requerant_2.qualite=''particulier''
        THEN ''''
        ELSE requerant_2.personne_morale_siret
    END as siret_requerant_2,
    requerant_2.numero as numero_requerant_2,
&DB_PREFIXEadresse(requerant_2.numero::text, requerant_2.voie::text, requerant_2.complement::text, requerant_2.lieu_dit::text, requerant_2.bp::text, requerant_2.code_postal::text, requerant_2.localite::text, requerant_2.cedex::text) as adresse_requerant_2_sdl,
&DB_PREFIXEadresse(requerant_2.numero::text, requerant_2.voie::text, requerant_2.complement::text, requerant_2.lieu_dit::text, requerant_2.bp::text, requerant_2.code_postal::text, requerant_2.localite::text, requerant_2.cedex::text, '' ''::text) as adresse_requerant_2,
    requerant_2.voie as voie_requerant_2,
    requerant_2.complement as complement_requerant_2,
    requerant_2.lieu_dit as lieu_dit_requerant_2,
    CASE 
        WHEN requerant_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_2.bp)
    END as bp_requerant_2,
    requerant_2.code_postal as code_postal_requerant_2,
    requerant_2.localite as localite_requerant_2,
    CASE 
        WHEN requerant_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_2.cedex)
    END as cedex_requerant_2,
    requerant_2.pays as pays_requerant_2,
    requerant_2.division_territoriale as division_territoriale_requerant_2,

    --Coordonnées du requérant 3

    CASE WHEN requerant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_3_civilite.libelle, requerant_3.particulier_nom, requerant_3.particulier_prenom))
        ELSE
            CASE WHEN requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_3.personne_morale_raison_sociale, requerant_3.personne_morale_denomination, ''représenté(e) par'', requerant_3_civilite.libelle, requerant_3.personne_morale_nom, requerant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_3.personne_morale_raison_sociale, '' '', requerant_3.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier'' OR requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
        THEN requerant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_nom
        ELSE
            CASE WHEN requerant_3.personne_morale_nom IS NOT NULL
                THEN requerant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_prenom
        ELSE
            CASE WHEN requerant_3.personne_morale_prenom IS NOT NULL
                THEN requerant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_3_civilite.libelle, requerant_3.particulier_nom, requerant_3.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_nom
        ELSE ''''
    END as nom_qualite_part_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_requerant_3,
    CASE WHEN requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', requerant_3.personne_morale_raison_sociale, requerant_3.personne_morale_denomination, ''représenté(e) par'', requerant_3_civilite.libelle, requerant_3.personne_morale_nom, requerant_3.personne_morale_prenom))
        ELSE TRIM(CONCAT(requerant_3.personne_morale_raison_sociale, '' '', requerant_3.personne_morale_denomination))
    END as nom_complet_qualite_pm_requerant_3,
    CASE WHEN requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
        THEN requerant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_requerant_3,
    CASE WHEN requerant_3.personne_morale_nom IS NOT NULL
        THEN requerant_3.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_requerant_3,
    CASE WHEN requerant_3.personne_morale_prenom IS NOT NULL
        THEN requerant_3.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_3_civilite.libelle, requerant_3.particulier_nom, requerant_3.particulier_prenom))
        ELSE
            CASE WHEN requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_3.personne_morale_raison_sociale, requerant_3.personne_morale_denomination, ''représenté(e) par'', requerant_3_civilite.libelle, requerant_3.personne_morale_nom, requerant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_3.personne_morale_raison_sociale, '' '', requerant_3.personne_morale_denomination))
            END
    END as nom_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier'' OR requerant_3.personne_morale_nom IS NOT NULL OR requerant_3.personne_morale_prenom IS NOT NULL
        THEN requerant_3_civilite.libelle
        ELSE ''''
    END as civilite_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_nom
        ELSE
            CASE WHEN requerant_3.personne_morale_nom IS NOT NULL
                THEN requerant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN requerant_3.particulier_prenom
        ELSE
            CASE WHEN requerant_3.personne_morale_prenom IS NOT NULL
                THEN requerant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_raison_sociale
    END as raison_sociale_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_denomination
    END as denomination_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_siret
    END as siret_requerant_3,
    CASE WHEN requerant_3.qualite=''particulier''
        THEN ''''
        ELSE requerant_3.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_3,
    requerant_3.numero as numero_requerant_3,
&DB_PREFIXEadresse(requerant_3.numero::text, requerant_3.voie::text, requerant_3.complement::text, requerant_3.lieu_dit::text, requerant_3.bp::text, requerant_3.code_postal::text, requerant_3.localite::text, requerant_3.cedex::text) as adresse_requerant_3_sdl,
&DB_PREFIXEadresse(requerant_3.numero::text, requerant_3.voie::text, requerant_3.complement::text, requerant_3.lieu_dit::text, requerant_3.bp::text, requerant_3.code_postal::text, requerant_3.localite::text, requerant_3.cedex::text, '' ''::text) as adresse_requerant_3,
    requerant_3.voie as voie_requerant_3,
    requerant_3.complement as complement_requerant_3,
    requerant_3.lieu_dit as lieu_dit_requerant_3,
    CASE 
        WHEN requerant_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_3.bp)
    END as bp_requerant_3,
    requerant_3.code_postal as code_postal_requerant_3,
    requerant_3.localite as localite_requerant_3,
    CASE 
        WHEN requerant_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_3.cedex)
    END as cedex_requerant_3,
    requerant_3.pays as pays_requerant_3,
    requerant_3.division_territoriale as division_territoriale_requerant_3,

    --Coordonnées du requérant 4

    CASE WHEN requerant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_4_civilite.libelle, requerant_4.particulier_nom, requerant_4.particulier_prenom))
        ELSE
            CASE WHEN requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_4.personne_morale_raison_sociale, requerant_4.personne_morale_denomination, ''représenté(e) par'', requerant_4_civilite.libelle, requerant_4.personne_morale_nom, requerant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_4.personne_morale_raison_sociale, '' '', requerant_4.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier'' OR requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
        THEN requerant_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_nom
        ELSE
            CASE WHEN requerant_4.personne_morale_nom IS NOT NULL
                THEN requerant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_prenom
        ELSE
            CASE WHEN requerant_4.personne_morale_prenom IS NOT NULL
                THEN requerant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_4_civilite.libelle, requerant_4.particulier_nom, requerant_4.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_nom
        ELSE ''''
    END as nom_qualite_part_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_requerant_4,
    CASE WHEN requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', requerant_4.personne_morale_raison_sociale, requerant_4.personne_morale_denomination, ''représenté(e) par'', requerant_4_civilite.libelle, requerant_4.personne_morale_nom, requerant_4.personne_morale_prenom))
        ELSE TRIM(CONCAT(requerant_4.personne_morale_raison_sociale, '' '', requerant_4.personne_morale_denomination))
    END as nom_complet_qualite_pm_requerant_4,
    CASE WHEN requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
        THEN requerant_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_requerant_4,
    CASE WHEN requerant_4.personne_morale_nom IS NOT NULL
        THEN requerant_4.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_requerant_4,
    CASE WHEN requerant_4.personne_morale_prenom IS NOT NULL
        THEN requerant_4.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_4_civilite.libelle, requerant_4.particulier_nom, requerant_4.particulier_prenom))
        ELSE
            CASE WHEN requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_4.personne_morale_raison_sociale, requerant_4.personne_morale_denomination, ''représenté(e) par'', requerant_4_civilite.libelle, requerant_4.personne_morale_nom, requerant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_4.personne_morale_raison_sociale, '' '', requerant_4.personne_morale_denomination))
            END
    END as nom_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier'' OR requerant_4.personne_morale_nom IS NOT NULL OR requerant_4.personne_morale_prenom IS NOT NULL
        THEN requerant_4_civilite.libelle
        ELSE ''''
    END as civilite_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_nom
        ELSE
            CASE WHEN requerant_4.personne_morale_nom IS NOT NULL
                THEN requerant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN requerant_4.particulier_prenom
        ELSE
            CASE WHEN requerant_4.personne_morale_prenom IS NOT NULL
                THEN requerant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_raison_sociale
    END as raison_sociale_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_denomination
    END as denomination_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_4,
    CASE WHEN requerant_4.qualite=''particulier''
        THEN ''''
        ELSE requerant_4.personne_morale_siret
    END as siret_requerant_4,
    requerant_4.numero as numero_requerant_4,
&DB_PREFIXEadresse(requerant_4.numero::text, requerant_4.voie::text, requerant_4.complement::text, requerant_4.lieu_dit::text, requerant_4.bp::text, requerant_4.code_postal::text, requerant_4.localite::text, requerant_4.cedex::text) as adresse_requerant_4_sdl,
&DB_PREFIXEadresse(requerant_4.numero::text, requerant_4.voie::text, requerant_4.complement::text, requerant_4.lieu_dit::text, requerant_4.bp::text, requerant_4.code_postal::text, requerant_4.localite::text, requerant_4.cedex::text, '' ''::text) as adresse_requerant_4,
    requerant_4.voie as voie_requerant_4,
    requerant_4.complement as complement_requerant_4,
    requerant_4.lieu_dit as lieu_dit_requerant_4,
    CASE 
        WHEN requerant_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_4.bp)
    END as bp_requerant_4,
    requerant_4.code_postal as code_postal_requerant_4,
    requerant_4.localite as localite_requerant_4,
    CASE 
        WHEN requerant_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_4.cedex)
    END as cedex_requerant_4,
    requerant_4.pays as pays_requerant_4,
    requerant_4.division_territoriale as division_territoriale_requerant_4,

    --Coordonnées du requérant 5

    CASE WHEN requerant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_5_civilite.libelle, requerant_5.particulier_nom, requerant_5.particulier_prenom))
        ELSE
            CASE WHEN requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_5.personne_morale_raison_sociale, requerant_5.personne_morale_denomination, ''représenté(e) par'', requerant_5_civilite.libelle, requerant_5.personne_morale_nom, requerant_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_5.personne_morale_raison_sociale, '' '', requerant_5.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier'' OR requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
        THEN requerant_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_nom
        ELSE
            CASE WHEN requerant_5.personne_morale_nom IS NOT NULL
                THEN requerant_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_prenom
        ELSE
            CASE WHEN requerant_5.personne_morale_prenom IS NOT NULL
                THEN requerant_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_5_civilite.libelle, requerant_5.particulier_nom, requerant_5.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_nom
        ELSE ''''
    END as nom_qualite_part_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_requerant_5,
    CASE WHEN requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', requerant_5.personne_morale_raison_sociale, requerant_5.personne_morale_denomination, ''représenté(e) par'', requerant_5_civilite.libelle, requerant_5.personne_morale_nom, requerant_5.personne_morale_prenom))
        ELSE TRIM(CONCAT(requerant_5.personne_morale_raison_sociale, '' '', requerant_5.personne_morale_denomination))
    END as nom_complet_qualite_pm_requerant_5,
    CASE WHEN requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
        THEN requerant_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_requerant_5,
    CASE WHEN requerant_5.personne_morale_nom IS NOT NULL
        THEN requerant_5.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_requerant_5,
    CASE WHEN requerant_5.personne_morale_prenom IS NOT NULL
        THEN requerant_5.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', requerant_5_civilite.libelle, requerant_5.particulier_nom, requerant_5.particulier_prenom))
        ELSE
            CASE WHEN requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', requerant_5.personne_morale_raison_sociale, requerant_5.personne_morale_denomination, ''représenté(e) par'', requerant_5_civilite.libelle, requerant_5.personne_morale_nom, requerant_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(requerant_5.personne_morale_raison_sociale, '' '', requerant_5.personne_morale_denomination))
            END
    END as nom_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier'' OR requerant_5.personne_morale_nom IS NOT NULL OR requerant_5.personne_morale_prenom IS NOT NULL
        THEN requerant_5_civilite.libelle
        ELSE ''''
    END as civilite_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_nom
        ELSE
            CASE WHEN requerant_5.personne_morale_nom IS NOT NULL
                THEN requerant_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN requerant_5.particulier_prenom
        ELSE
            CASE WHEN requerant_5.personne_morale_prenom IS NOT NULL
                THEN requerant_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_raison_sociale
    END as raison_sociale_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_denomination
    END as denomination_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_categorie_juridique
    END as categorie_juridique_requerant_5,
    CASE WHEN requerant_5.qualite=''particulier''
        THEN ''''
        ELSE requerant_5.personne_morale_siret
    END as siret_requerant_5,
    requerant_5.numero as numero_requerant_5,
&DB_PREFIXEadresse(requerant_5.numero::text, requerant_5.voie::text, requerant_5.complement::text, requerant_5.lieu_dit::text, requerant_5.bp::text, requerant_5.code_postal::text, requerant_5.localite::text, requerant_5.cedex::text) as adresse_requerant_5_sdl,
&DB_PREFIXEadresse(requerant_5.numero::text, requerant_5.voie::text, requerant_5.complement::text, requerant_5.lieu_dit::text, requerant_5.bp::text, requerant_5.code_postal::text, requerant_5.localite::text, requerant_5.cedex::text, '' ''::text) as adresse_requerant_5,
    requerant_5.voie as voie_requerant_5,
    requerant_5.complement as complement_requerant_5,
    requerant_5.lieu_dit as lieu_dit_requerant_5,
    CASE 
        WHEN requerant_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', requerant_5.bp)
    END as bp_requerant_5,
    requerant_5.code_postal as code_postal_requerant_5,
    requerant_5.localite as localite_requerant_5,
    CASE 
        WHEN requerant_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', requerant_5.cedex)
    END as cedex_requerant_5,
    requerant_5.pays as pays_requerant_5,
    requerant_5.division_territoriale as division_territoriale_requerant_5,

    --Coordonnées de l''avocat principal

    CASE WHEN avocat_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_principal_civilite.libelle, avocat_principal.particulier_nom, avocat_principal.particulier_prenom))
        ELSE
            CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_principal.personne_morale_raison_sociale, avocat_principal.personne_morale_denomination, ''représenté(e) par'', avocat_principal_civilite.libelle, avocat_principal.personne_morale_nom, avocat_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_principal.personne_morale_raison_sociale, '' '', avocat_principal.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier'' OR avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
        THEN avocat_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_nom
        ELSE
            CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL
                THEN avocat_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_prenom
        ELSE
            CASE WHEN avocat_principal.personne_morale_prenom IS NOT NULL
                THEN avocat_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_principal_civilite.libelle, avocat_principal.particulier_nom, avocat_principal.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_nom
        ELSE ''''
    END as nom_qualite_part_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_avocat_principal,
    CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', avocat_principal.personne_morale_raison_sociale, avocat_principal.personne_morale_denomination, ''représenté(e) par'', avocat_principal_civilite.libelle, avocat_principal.personne_morale_nom, avocat_principal.personne_morale_prenom))
        ELSE TRIM(CONCAT(avocat_principal.personne_morale_raison_sociale, '' '', avocat_principal.personne_morale_denomination))
    END as nom_complet_qualite_pm_avocat_principal,
    CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
        THEN avocat_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_avocat_principal,
    CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL
        THEN avocat_principal.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_avocat_principal,
    CASE WHEN avocat_principal.personne_morale_prenom IS NOT NULL
        THEN avocat_principal.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_principal_civilite.libelle, avocat_principal.particulier_nom, avocat_principal.particulier_prenom))
        ELSE
            CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_principal.personne_morale_raison_sociale, avocat_principal.personne_morale_denomination, ''représenté(e) par'', avocat_principal_civilite.libelle, avocat_principal.personne_morale_nom, avocat_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_principal.personne_morale_raison_sociale, '' '', avocat_principal.personne_morale_denomination))
            END
    END as nom_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier'' OR avocat_principal.personne_morale_nom IS NOT NULL OR avocat_principal.personne_morale_prenom IS NOT NULL
        THEN avocat_principal_civilite.libelle
        ELSE ''''
    END as civilite_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_nom
        ELSE
            CASE WHEN avocat_principal.personne_morale_nom IS NOT NULL
                THEN avocat_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN avocat_principal.particulier_prenom
        ELSE
            CASE WHEN avocat_principal.personne_morale_prenom IS NOT NULL
                THEN avocat_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_raison_sociale
    END as raison_sociale_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_denomination
    END as denomination_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_siret
    END as siret_avocat_principal,
    CASE WHEN avocat_principal.qualite=''particulier''
        THEN ''''
        ELSE avocat_principal.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_principal,
    avocat_principal.numero as numero_avocat_principal,
&DB_PREFIXEadresse(avocat_principal.numero::text, avocat_principal.voie::text, avocat_principal.complement::text, avocat_principal.lieu_dit::text, avocat_principal.bp::text, avocat_principal.code_postal::text, avocat_principal.localite::text, avocat_principal.cedex::text) as adresse_avocat_principal_sdl,
&DB_PREFIXEadresse(avocat_principal.numero::text, avocat_principal.voie::text, avocat_principal.complement::text, avocat_principal.lieu_dit::text, avocat_principal.bp::text, avocat_principal.code_postal::text, avocat_principal.localite::text, avocat_principal.cedex::text, '' ''::text) as adresse_avocat_principal,
    avocat_principal.voie as voie_avocat_principal,
    avocat_principal.complement as complement_avocat_principal,
    avocat_principal.lieu_dit as lieu_dit_avocat_principal,
    CASE 
        WHEN avocat_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_principal.bp)
    END as bp_avocat_principal,
    avocat_principal.code_postal as code_postal_avocat_principal,
    avocat_principal.localite as localite_avocat_principal,
    CASE 
        WHEN avocat_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_principal.cedex)
    END as cedex_avocat_principal,
    avocat_principal.pays as pays_avocat_principal,
    avocat_principal.division_territoriale as division_territoriale_avocat_principal,

    --Coordonnées de l''avocat 1

    CASE WHEN avocat_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_1_civilite.libelle, avocat_1.particulier_nom, avocat_1.particulier_prenom))
        ELSE
            CASE WHEN avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_1.personne_morale_raison_sociale, avocat_1.personne_morale_denomination, ''représenté(e) par'', avocat_1_civilite.libelle, avocat_1.personne_morale_nom, avocat_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_1.personne_morale_raison_sociale, '' '', avocat_1.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier'' OR avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
        THEN avocat_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_nom
        ELSE
            CASE WHEN avocat_1.personne_morale_nom IS NOT NULL
                THEN avocat_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_prenom
        ELSE
            CASE WHEN avocat_1.personne_morale_prenom IS NOT NULL
                THEN avocat_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_1_civilite.libelle, avocat_1.particulier_nom, avocat_1.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_nom
        ELSE ''''
    END as nom_qualite_part_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_avocat_1,
    CASE WHEN avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', avocat_1.personne_morale_raison_sociale, avocat_1.personne_morale_denomination, ''représenté(e) par'', avocat_1_civilite.libelle, avocat_1.personne_morale_nom, avocat_1.personne_morale_prenom))
        ELSE TRIM(CONCAT(avocat_1.personne_morale_raison_sociale, '' '', avocat_1.personne_morale_denomination))
    END as nom_complet_qualite_pm_avocat_1,
    CASE WHEN avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
        THEN avocat_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_avocat_1,
    CASE WHEN avocat_1.personne_morale_nom IS NOT NULL
        THEN avocat_1.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_avocat_1,
    CASE WHEN avocat_1.personne_morale_prenom IS NOT NULL
        THEN avocat_1.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_1_civilite.libelle, avocat_1.particulier_nom, avocat_1.particulier_prenom))
        ELSE
            CASE WHEN avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_1.personne_morale_raison_sociale, avocat_1.personne_morale_denomination, ''représenté(e) par'', avocat_1_civilite.libelle, avocat_1.personne_morale_nom, avocat_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_1.personne_morale_raison_sociale, '' '', avocat_1.personne_morale_denomination))
            END
    END as nom_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier'' OR avocat_1.personne_morale_nom IS NOT NULL OR avocat_1.personne_morale_prenom IS NOT NULL
        THEN avocat_1_civilite.libelle
        ELSE ''''
    END as civilite_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_nom
        ELSE
            CASE WHEN avocat_1.personne_morale_nom IS NOT NULL
                THEN avocat_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN avocat_1.particulier_prenom
        ELSE
            CASE WHEN avocat_1.personne_morale_prenom IS NOT NULL
                THEN avocat_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_raison_sociale
    END as raison_sociale_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_denomination
    END as denomination_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_siret
    END as siret_avocat_1,
    CASE WHEN avocat_1.qualite=''particulier''
        THEN ''''
        ELSE avocat_1.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_1,
    avocat_1.numero as numero_avocat_1,
&DB_PREFIXEadresse(avocat_1.numero::text, avocat_1.voie::text, avocat_1.complement::text, avocat_1.lieu_dit::text, avocat_1.bp::text, avocat_1.code_postal::text, avocat_1.localite::text, avocat_1.cedex::text) as adresse_avocat_1_sdl,
&DB_PREFIXEadresse(avocat_1.numero::text, avocat_1.voie::text, avocat_1.complement::text, avocat_1.lieu_dit::text, avocat_1.bp::text, avocat_1.code_postal::text, avocat_1.localite::text, avocat_1.cedex::text, '' ''::text) as adresse_avocat_1,
    avocat_1.voie as voie_avocat_1,
    avocat_1.complement as complement_avocat_1,
    avocat_1.lieu_dit as lieu_dit_avocat_1,
    CASE 
        WHEN avocat_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_1.bp)
    END as bp_avocat_1,
    avocat_1.code_postal as code_postal_avocat_1,
    avocat_1.localite as localite_avocat_1,
    CASE 
        WHEN avocat_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_1.cedex)
    END as cedex_avocat_1,
    avocat_1.pays as pays_avocat_1,
    avocat_1.division_territoriale as division_territoriale_avocat_1,

    --Coordonnées de l''avocat 2

    CASE WHEN avocat_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_2_civilite.libelle, avocat_2.particulier_nom, avocat_2.particulier_prenom))
        ELSE
            CASE WHEN avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_2.personne_morale_raison_sociale, avocat_2.personne_morale_denomination, ''représenté(e) par'', avocat_2_civilite.libelle, avocat_2.personne_morale_nom, avocat_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_2.personne_morale_raison_sociale, '' '', avocat_2.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier'' OR avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
        THEN avocat_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_nom
        ELSE
            CASE WHEN avocat_2.personne_morale_nom IS NOT NULL
                THEN avocat_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_prenom
        ELSE
            CASE WHEN avocat_2.personne_morale_prenom IS NOT NULL
                THEN avocat_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_2_civilite.libelle, avocat_2.particulier_nom, avocat_2.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_nom
        ELSE ''''
    END as nom_qualite_part_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_avocat_2,
    CASE WHEN avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', avocat_2.personne_morale_raison_sociale, avocat_2.personne_morale_denomination, ''représenté(e) par'', avocat_2_civilite.libelle, avocat_2.personne_morale_nom, avocat_2.personne_morale_prenom))
        ELSE TRIM(CONCAT(avocat_2.personne_morale_raison_sociale, '' '', avocat_2.personne_morale_denomination))
    END as nom_complet_qualite_pm_avocat_2,
    CASE WHEN avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
        THEN avocat_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_avocat_2,
    CASE WHEN avocat_2.personne_morale_nom IS NOT NULL
        THEN avocat_2.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_avocat_2,
    CASE WHEN avocat_2.personne_morale_prenom IS NOT NULL
        THEN avocat_2.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_2_civilite.libelle, avocat_2.particulier_nom, avocat_2.particulier_prenom))
        ELSE
            CASE WHEN avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_2.personne_morale_raison_sociale, avocat_2.personne_morale_denomination, ''représenté(e) par'', avocat_2_civilite.libelle, avocat_2.personne_morale_nom, avocat_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_2.personne_morale_raison_sociale, '' '', avocat_2.personne_morale_denomination))
            END
    END as nom_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier'' OR avocat_2.personne_morale_nom IS NOT NULL OR avocat_2.personne_morale_prenom IS NOT NULL
        THEN avocat_2_civilite.libelle
        ELSE ''''
    END as civilite_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_nom
        ELSE
            CASE WHEN avocat_2.personne_morale_nom IS NOT NULL
                THEN avocat_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN avocat_2.particulier_prenom
        ELSE
            CASE WHEN avocat_2.personne_morale_prenom IS NOT NULL
                THEN avocat_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_raison_sociale
    END as raison_sociale_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_denomination
    END as denomination_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_2,
    CASE WHEN avocat_2.qualite=''particulier''
        THEN ''''
        ELSE avocat_2.personne_morale_siret
    END as siret_avocat_2,
    avocat_2.numero as numero_avocat_2,
&DB_PREFIXEadresse(avocat_2.numero::text, avocat_2.voie::text, avocat_2.complement::text, avocat_2.lieu_dit::text, avocat_2.bp::text, avocat_2.code_postal::text, avocat_2.localite::text, avocat_2.cedex::text) as adresse_avocat_2_sdl,
&DB_PREFIXEadresse(avocat_2.numero::text, avocat_2.voie::text, avocat_2.complement::text, avocat_2.lieu_dit::text, avocat_2.bp::text, avocat_2.code_postal::text, avocat_2.localite::text, avocat_2.cedex::text, '' ''::text) as adresse_avocat_2,
    avocat_2.voie as voie_avocat_2,
    avocat_2.complement as complement_avocat_2,
    avocat_2.lieu_dit as lieu_dit_avocat_2,
    CASE 
        WHEN avocat_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_2.bp)
    END as bp_avocat_2,
    avocat_2.code_postal as code_postal_avocat_2,
    avocat_2.localite as localite_avocat_2,
    CASE 
        WHEN avocat_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_2.cedex)
    END as cedex_avocat_2,
    avocat_2.pays as pays_avocat_2,
    avocat_2.division_territoriale as division_territoriale_avocat_2,

    --Coordonnées de l''avocat 3

    CASE WHEN avocat_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_3_civilite.libelle, avocat_3.particulier_nom, avocat_3.particulier_prenom))
        ELSE
            CASE WHEN avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_3.personne_morale_raison_sociale, avocat_3.personne_morale_denomination, ''représenté(e) par'', avocat_3_civilite.libelle, avocat_3.personne_morale_nom, avocat_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_3.personne_morale_raison_sociale, '' '', avocat_3.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier'' OR avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
        THEN avocat_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_nom
        ELSE
            CASE WHEN avocat_3.personne_morale_nom IS NOT NULL
                THEN avocat_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_prenom
        ELSE
            CASE WHEN avocat_3.personne_morale_prenom IS NOT NULL
                THEN avocat_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_3_civilite.libelle, avocat_3.particulier_nom, avocat_3.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_nom
        ELSE ''''
    END as nom_qualite_part_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_avocat_3,
    CASE WHEN avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', avocat_3.personne_morale_raison_sociale, avocat_3.personne_morale_denomination, ''représenté(e) par'', avocat_3_civilite.libelle, avocat_3.personne_morale_nom, avocat_3.personne_morale_prenom))
        ELSE TRIM(CONCAT(avocat_3.personne_morale_raison_sociale, '' '', avocat_3.personne_morale_denomination))
    END as nom_complet_qualite_pm_avocat_3,
    CASE WHEN avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
        THEN avocat_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_avocat_3,
    CASE WHEN avocat_3.personne_morale_nom IS NOT NULL
        THEN avocat_3.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_avocat_3,
    CASE WHEN avocat_3.personne_morale_prenom IS NOT NULL
        THEN avocat_3.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_3_civilite.libelle, avocat_3.particulier_nom, avocat_3.particulier_prenom))
        ELSE
            CASE WHEN avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_3.personne_morale_raison_sociale, avocat_3.personne_morale_denomination, ''représenté(e) par'', avocat_3_civilite.libelle, avocat_3.personne_morale_nom, avocat_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_3.personne_morale_raison_sociale, '' '', avocat_3.personne_morale_denomination))
            END
    END as nom_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier'' OR avocat_3.personne_morale_nom IS NOT NULL OR avocat_3.personne_morale_prenom IS NOT NULL
        THEN avocat_3_civilite.libelle
        ELSE ''''
    END as civilite_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_nom
        ELSE
            CASE WHEN avocat_3.personne_morale_nom IS NOT NULL
                THEN avocat_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN avocat_3.particulier_prenom
        ELSE
            CASE WHEN avocat_3.personne_morale_prenom IS NOT NULL
                THEN avocat_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_raison_sociale
    END as raison_sociale_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_denomination
    END as denomination_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_siret
    END as siret_avocat_3,
    CASE WHEN avocat_3.qualite=''particulier''
        THEN ''''
        ELSE avocat_3.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_3,
    avocat_3.numero as numero_avocat_3,
&DB_PREFIXEadresse(avocat_3.numero::text, avocat_3.voie::text, avocat_3.complement::text, avocat_3.lieu_dit::text, avocat_3.bp::text, avocat_3.code_postal::text, avocat_3.localite::text, avocat_3.cedex::text) as adresse_avocat_3_sdl,
&DB_PREFIXEadresse(avocat_3.numero::text, avocat_3.voie::text, avocat_3.complement::text, avocat_3.lieu_dit::text, avocat_3.bp::text, avocat_3.code_postal::text, avocat_3.localite::text, avocat_3.cedex::text, '' ''::text) as adresse_avocat_3,
    avocat_3.voie as voie_avocat_3,
    avocat_3.complement as complement_avocat_3,
    avocat_3.lieu_dit as lieu_dit_avocat_3,
    CASE 
        WHEN avocat_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_3.bp)
    END as bp_avocat_3,
    avocat_3.code_postal as code_postal_avocat_3,
    avocat_3.localite as localite_avocat_3,
    CASE 
        WHEN avocat_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_3.cedex)
    END as cedex_avocat_3,
    avocat_3.pays as pays_avocat_3,
    avocat_3.division_territoriale as division_territoriale_avocat_3,

    --Coordonnées de l''avocat 4

    CASE WHEN avocat_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_4_civilite.libelle, avocat_4.particulier_nom, avocat_4.particulier_prenom))
        ELSE
            CASE WHEN avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_4.personne_morale_raison_sociale, avocat_4.personne_morale_denomination, ''représenté(e) par'', avocat_4_civilite.libelle, avocat_4.personne_morale_nom, avocat_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_4.personne_morale_raison_sociale, '' '', avocat_4.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier'' OR avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
        THEN avocat_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_nom
        ELSE
            CASE WHEN avocat_4.personne_morale_nom IS NOT NULL
                THEN avocat_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_prenom
        ELSE
            CASE WHEN avocat_4.personne_morale_prenom IS NOT NULL
                THEN avocat_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_4_civilite.libelle, avocat_4.particulier_nom, avocat_4.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_nom
        ELSE ''''
    END as nom_qualite_part_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_avocat_4,
    CASE WHEN avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', avocat_4.personne_morale_raison_sociale, avocat_4.personne_morale_denomination, ''représenté(e) par'', avocat_4_civilite.libelle, avocat_4.personne_morale_nom, avocat_4.personne_morale_prenom))
        ELSE TRIM(CONCAT(avocat_4.personne_morale_raison_sociale, '' '', avocat_4.personne_morale_denomination))
    END as nom_complet_qualite_pm_avocat_4,
    CASE WHEN avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
        THEN avocat_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_avocat_4,
    CASE WHEN avocat_4.personne_morale_nom IS NOT NULL
        THEN avocat_4.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_avocat_4,
    CASE WHEN avocat_4.personne_morale_prenom IS NOT NULL
        THEN avocat_4.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_4_civilite.libelle, avocat_4.particulier_nom, avocat_4.particulier_prenom))
        ELSE
            CASE WHEN avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_4.personne_morale_raison_sociale, avocat_4.personne_morale_denomination, ''représenté(e) par'', avocat_4_civilite.libelle, avocat_4.personne_morale_nom, avocat_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_4.personne_morale_raison_sociale, '' '', avocat_4.personne_morale_denomination))
            END
    END as nom_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier'' OR avocat_4.personne_morale_nom IS NOT NULL OR avocat_4.personne_morale_prenom IS NOT NULL
        THEN avocat_4_civilite.libelle
        ELSE ''''
    END as civilite_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_nom
        ELSE
            CASE WHEN avocat_4.personne_morale_nom IS NOT NULL
                THEN avocat_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN avocat_4.particulier_prenom
        ELSE
            CASE WHEN avocat_4.personne_morale_prenom IS NOT NULL
                THEN avocat_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_raison_sociale
    END as raison_sociale_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_denomination
    END as denomination_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_4,
    CASE WHEN avocat_4.qualite=''particulier''
        THEN ''''
        ELSE avocat_4.personne_morale_siret
    END as siret_avocat_4,
    avocat_4.numero as numero_avocat_4,
&DB_PREFIXEadresse(avocat_4.numero::text, avocat_4.voie::text, avocat_4.complement::text, avocat_4.lieu_dit::text, avocat_4.bp::text, avocat_4.code_postal::text, avocat_4.localite::text, avocat_4.cedex::text) as adresse_avocat_4_sdl,
&DB_PREFIXEadresse(avocat_4.numero::text, avocat_4.voie::text, avocat_4.complement::text, avocat_4.lieu_dit::text, avocat_4.bp::text, avocat_4.code_postal::text, avocat_4.localite::text, avocat_4.cedex::text, '' ''::text) as adresse_avocat_4,
    avocat_4.voie as voie_avocat_4,
    avocat_4.complement as complement_avocat_4,
    avocat_4.lieu_dit as lieu_dit_avocat_4,
    CASE 
        WHEN avocat_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_4.bp)
    END as bp_avocat_4,
    avocat_4.code_postal as code_postal_avocat_4,
    avocat_4.localite as localite_avocat_4,
    CASE 
        WHEN avocat_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_4.cedex)
    END as cedex_avocat_4,
    avocat_4.pays as pays_avocat_4,
    avocat_4.division_territoriale as division_territoriale_avocat_4,

    --Coordonnées de l''avocat 5

    CASE WHEN avocat_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_5_civilite.libelle, avocat_5.particulier_nom, avocat_5.particulier_prenom))
        ELSE
            CASE WHEN avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_5.personne_morale_raison_sociale, avocat_5.personne_morale_denomination, ''représenté(e) par'', avocat_5_civilite.libelle, avocat_5.personne_morale_nom, avocat_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_5.personne_morale_raison_sociale, '' '', avocat_5.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier'' OR avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
        THEN avocat_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_nom
        ELSE
            CASE WHEN avocat_5.personne_morale_nom IS NOT NULL
                THEN avocat_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_prenom
        ELSE
            CASE WHEN avocat_5.personne_morale_prenom IS NOT NULL
                THEN avocat_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_5_civilite.libelle, avocat_5.particulier_nom, avocat_5.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_nom
        ELSE ''''
    END as nom_qualite_part_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_avocat_5,
    CASE WHEN avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', avocat_5.personne_morale_raison_sociale, avocat_5.personne_morale_denomination, ''représenté(e) par'', avocat_5_civilite.libelle, avocat_5.personne_morale_nom, avocat_5.personne_morale_prenom))
        ELSE TRIM(CONCAT(avocat_5.personne_morale_raison_sociale, '' '', avocat_5.personne_morale_denomination))
    END as nom_complet_qualite_pm_avocat_5,
    CASE WHEN avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
        THEN avocat_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_avocat_5,
    CASE WHEN avocat_5.personne_morale_nom IS NOT NULL
        THEN avocat_5.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_avocat_5,
    CASE WHEN avocat_5.personne_morale_prenom IS NOT NULL
        THEN avocat_5.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', avocat_5_civilite.libelle, avocat_5.particulier_nom, avocat_5.particulier_prenom))
        ELSE
            CASE WHEN avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', avocat_5.personne_morale_raison_sociale, avocat_5.personne_morale_denomination, ''représenté(e) par'', avocat_5_civilite.libelle, avocat_5.personne_morale_nom, avocat_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(avocat_5.personne_morale_raison_sociale, '' '', avocat_5.personne_morale_denomination))
            END
    END as nom_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier'' OR avocat_5.personne_morale_nom IS NOT NULL OR avocat_5.personne_morale_prenom IS NOT NULL
        THEN avocat_5_civilite.libelle
        ELSE ''''
    END as civilite_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_nom
        ELSE
            CASE WHEN avocat_5.personne_morale_nom IS NOT NULL
                THEN avocat_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN avocat_5.particulier_prenom
        ELSE
            CASE WHEN avocat_5.personne_morale_prenom IS NOT NULL
                THEN avocat_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_raison_sociale
    END as raison_sociale_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_denomination
    END as denomination_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_categorie_juridique
    END as categorie_juridique_avocat_5,
    CASE WHEN avocat_5.qualite=''particulier''
        THEN ''''
        ELSE avocat_5.personne_morale_siret
    END as siret_avocat_5,
    avocat_5.numero as numero_avocat_5,
&DB_PREFIXEadresse(avocat_5.numero::text, avocat_5.voie::text, avocat_5.complement::text, avocat_5.lieu_dit::text, avocat_5.bp::text, avocat_5.code_postal::text, avocat_5.localite::text, avocat_5.cedex::text) as adresse_avocat_5_sdl,
&DB_PREFIXEadresse(avocat_5.numero::text, avocat_5.voie::text, avocat_5.complement::text, avocat_5.lieu_dit::text, avocat_5.bp::text, avocat_5.code_postal::text, avocat_5.localite::text, avocat_5.cedex::text, '' ''::text) as adresse_avocat_5,
    avocat_5.voie as voie_avocat_5,
    avocat_5.complement as complement_avocat_5,
    avocat_5.lieu_dit as lieu_dit_avocat_5,
    CASE 
        WHEN avocat_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', avocat_5.bp)
    END as bp_avocat_5,
    avocat_5.code_postal as code_postal_avocat_5,
    avocat_5.localite as localite_avocat_5,
    CASE 
        WHEN avocat_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', avocat_5.cedex)
    END as cedex_avocat_5,
    avocat_5.pays as pays_avocat_5,
    avocat_5.division_territoriale as division_territoriale_avocat_5,

    --Coordonnées du plaignant principal

    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_principal_civilite.libelle, plaignant_principal.particulier_nom, plaignant_principal.particulier_prenom))
        ELSE
            CASE WHEN plaignant_principal.personne_morale_nom IS NOT NULL OR plaignant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_principal.personne_morale_raison_sociale, plaignant_principal.personne_morale_denomination, ''représenté(e) par'', plaignant_principal_civilite.libelle, plaignant_principal.personne_morale_nom, plaignant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_principal.personne_morale_raison_sociale, '' '', plaignant_principal.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier'' OR plaignant_principal.personne_morale_nom IS NOT NULL OR plaignant_principal.personne_morale_prenom IS NOT NULL
        THEN plaignant_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN plaignant_principal.particulier_nom
        ELSE
            CASE WHEN plaignant_principal.personne_morale_nom IS NOT NULL
                THEN plaignant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN plaignant_principal.particulier_prenom
        ELSE
            CASE WHEN plaignant_principal.personne_morale_prenom IS NOT NULL
                THEN plaignant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_principal_civilite.libelle, plaignant_principal.particulier_nom, plaignant_principal.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN plaignant_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN plaignant_principal.particulier_nom
        ELSE ''''
    END as nom_qualite_part_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN plaignant_principal.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_plaignant_principal,
    CASE WHEN plaignant_principal.personne_morale_nom IS NOT NULL OR plaignant_principal.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', plaignant_principal.personne_morale_raison_sociale, plaignant_principal.personne_morale_denomination, ''représenté(e) par'', plaignant_principal_civilite.libelle, plaignant_principal.personne_morale_nom, plaignant_principal.personne_morale_prenom))
        ELSE TRIM(CONCAT(plaignant_principal.personne_morale_raison_sociale, '' '', plaignant_principal.personne_morale_denomination))
    END as nom_complet_qualite_pm_plaignant_principal,
    CASE WHEN plaignant_principal.personne_morale_nom IS NOT NULL OR plaignant_principal.personne_morale_prenom IS NOT NULL
        THEN plaignant_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_plaignant_principal,
    CASE WHEN plaignant_principal.personne_morale_nom IS NOT NULL
        THEN plaignant_principal.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_plaignant_principal,
    CASE WHEN plaignant_principal.personne_morale_prenom IS NOT NULL
        THEN plaignant_principal.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_principal_civilite.libelle, plaignant_principal.particulier_nom, plaignant_principal.particulier_prenom))
        ELSE
            CASE WHEN plaignant_principal.personne_morale_nom IS NOT NULL OR plaignant_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_principal.personne_morale_raison_sociale, plaignant_principal.personne_morale_denomination, ''représenté(e) par'', plaignant_principal_civilite.libelle, plaignant_principal.personne_morale_nom, plaignant_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_principal.personne_morale_raison_sociale, '' '', plaignant_principal.personne_morale_denomination))
            END
    END as nom_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier'' OR plaignant_principal.personne_morale_nom IS NOT NULL OR plaignant_principal.personne_morale_prenom IS NOT NULL
        THEN plaignant_principal_civilite.libelle
        ELSE ''''
    END as civilite_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN plaignant_principal.particulier_nom
        ELSE
            CASE WHEN plaignant_principal.personne_morale_nom IS NOT NULL
                THEN plaignant_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN plaignant_principal.particulier_prenom
        ELSE
            CASE WHEN plaignant_principal.personne_morale_prenom IS NOT NULL
                THEN plaignant_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN ''''
        ELSE plaignant_principal.personne_morale_raison_sociale
    END as raison_sociale_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN ''''
        ELSE plaignant_principal.personne_morale_denomination
    END as denomination_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN ''''
        ELSE plaignant_principal.personne_morale_siret
    END as siret_plaignant_principal,
    CASE WHEN plaignant_principal.qualite=''particulier''
        THEN ''''
        ELSE plaignant_principal.personne_morale_categorie_juridique
    END as categorie_juridique_plaignant_principal,
    plaignant_principal.numero as numero_plaignant_principal,
&DB_PREFIXEadresse(plaignant_principal.numero::text, plaignant_principal.voie::text, plaignant_principal.complement::text, plaignant_principal.lieu_dit::text, plaignant_principal.bp::text, plaignant_principal.code_postal::text, plaignant_principal.localite::text, plaignant_principal.cedex::text) as adresse_plaignant_principal_sdl,
&DB_PREFIXEadresse(plaignant_principal.numero::text, plaignant_principal.voie::text, plaignant_principal.complement::text, plaignant_principal.lieu_dit::text, plaignant_principal.bp::text, plaignant_principal.code_postal::text, plaignant_principal.localite::text, plaignant_principal.cedex::text, '' ''::text) as adresse_plaignant_principal,
    plaignant_principal.voie as voie_plaignant_principal,
    plaignant_principal.complement as complement_plaignant_principal,
    plaignant_principal.lieu_dit as lieu_dit_plaignant_principal,
    CASE 
        WHEN plaignant_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', plaignant_principal.bp)
    END as bp_plaignant_principal,
    plaignant_principal.code_postal as code_postal_plaignant_principal,
    plaignant_principal.localite as localite_plaignant_principal,
    CASE 
        WHEN plaignant_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', plaignant_principal.cedex)
    END as cedex_plaignant_principal,
    plaignant_principal.pays as pays_plaignant_principal,
    plaignant_principal.division_territoriale as division_territoriale_plaignant_principal,

    --Coordonnées de l''plaignant 1

    CASE WHEN plaignant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_1_civilite.libelle, plaignant_1.particulier_nom, plaignant_1.particulier_prenom))
        ELSE
            CASE WHEN plaignant_1.personne_morale_nom IS NOT NULL OR plaignant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_1.personne_morale_raison_sociale, plaignant_1.personne_morale_denomination, ''représenté(e) par'', plaignant_1_civilite.libelle, plaignant_1.personne_morale_nom, plaignant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_1.personne_morale_raison_sociale, '' '', plaignant_1.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier'' OR plaignant_1.personne_morale_nom IS NOT NULL OR plaignant_1.personne_morale_prenom IS NOT NULL
        THEN plaignant_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN plaignant_1.particulier_nom
        ELSE
            CASE WHEN plaignant_1.personne_morale_nom IS NOT NULL
                THEN plaignant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN plaignant_1.particulier_prenom
        ELSE
            CASE WHEN plaignant_1.personne_morale_prenom IS NOT NULL
                THEN plaignant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_1_civilite.libelle, plaignant_1.particulier_nom, plaignant_1.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN plaignant_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN plaignant_1.particulier_nom
        ELSE ''''
    END as nom_qualite_part_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN plaignant_1.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_plaignant_1,
    CASE WHEN plaignant_1.personne_morale_nom IS NOT NULL OR plaignant_1.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', plaignant_1.personne_morale_raison_sociale, plaignant_1.personne_morale_denomination, ''représenté(e) par'', plaignant_1_civilite.libelle, plaignant_1.personne_morale_nom, plaignant_1.personne_morale_prenom))
        ELSE TRIM(CONCAT(plaignant_1.personne_morale_raison_sociale, '' '', plaignant_1.personne_morale_denomination))
    END as nom_complet_qualite_pm_plaignant_1,
    CASE WHEN plaignant_1.personne_morale_nom IS NOT NULL OR plaignant_1.personne_morale_prenom IS NOT NULL
        THEN plaignant_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_plaignant_1,
    CASE WHEN plaignant_1.personne_morale_nom IS NOT NULL
        THEN plaignant_1.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_plaignant_1,
    CASE WHEN plaignant_1.personne_morale_prenom IS NOT NULL
        THEN plaignant_1.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_1_civilite.libelle, plaignant_1.particulier_nom, plaignant_1.particulier_prenom))
        ELSE
            CASE WHEN plaignant_1.personne_morale_nom IS NOT NULL OR plaignant_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_1.personne_morale_raison_sociale, plaignant_1.personne_morale_denomination, ''représenté(e) par'', plaignant_1_civilite.libelle, plaignant_1.personne_morale_nom, plaignant_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_1.personne_morale_raison_sociale, '' '', plaignant_1.personne_morale_denomination))
            END
    END as nom_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier'' OR plaignant_1.personne_morale_nom IS NOT NULL OR plaignant_1.personne_morale_prenom IS NOT NULL
        THEN plaignant_1_civilite.libelle
        ELSE ''''
    END as civilite_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN plaignant_1.particulier_nom
        ELSE
            CASE WHEN plaignant_1.personne_morale_nom IS NOT NULL
                THEN plaignant_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN plaignant_1.particulier_prenom
        ELSE
            CASE WHEN plaignant_1.personne_morale_prenom IS NOT NULL
                THEN plaignant_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN ''''
        ELSE plaignant_1.personne_morale_raison_sociale
    END as raison_sociale_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN ''''
        ELSE plaignant_1.personne_morale_denomination
    END as denomination_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN ''''
        ELSE plaignant_1.personne_morale_siret
    END as siret_plaignant_1,
    CASE WHEN plaignant_1.qualite=''particulier''
        THEN ''''
        ELSE plaignant_1.personne_morale_categorie_juridique
    END as categorie_juridique_plaignant_1,
    plaignant_1.numero as numero_plaignant_1,
&DB_PREFIXEadresse(plaignant_1.numero::text, plaignant_1.voie::text, plaignant_1.complement::text, plaignant_1.lieu_dit::text, plaignant_1.bp::text, plaignant_1.code_postal::text, plaignant_1.localite::text, plaignant_1.cedex::text) as adresse_plaignant_1_sdl,
&DB_PREFIXEadresse(plaignant_1.numero::text, plaignant_1.voie::text, plaignant_1.complement::text, plaignant_1.lieu_dit::text, plaignant_1.bp::text, plaignant_1.code_postal::text, plaignant_1.localite::text, plaignant_1.cedex::text, '' ''::text) as adresse_plaignant_1,
    plaignant_1.voie as voie_plaignant_1,
    plaignant_1.complement as complement_plaignant_1,
    plaignant_1.lieu_dit as lieu_dit_plaignant_1,
    CASE 
        WHEN plaignant_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', plaignant_1.bp)
    END as bp_plaignant_1,
    plaignant_1.code_postal as code_postal_plaignant_1,
    plaignant_1.localite as localite_plaignant_1,
    CASE 
        WHEN plaignant_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', plaignant_1.cedex)
    END as cedex_plaignant_1,
    plaignant_1.pays as pays_plaignant_1,
    plaignant_1.division_territoriale as division_territoriale_plaignant_1,

    --Coordonnées de l''plaignant 2

    CASE WHEN plaignant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_2_civilite.libelle, plaignant_2.particulier_nom, plaignant_2.particulier_prenom))
        ELSE
            CASE WHEN plaignant_2.personne_morale_nom IS NOT NULL OR plaignant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_2.personne_morale_raison_sociale, plaignant_2.personne_morale_denomination, ''représenté(e) par'', plaignant_2_civilite.libelle, plaignant_2.personne_morale_nom, plaignant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_2.personne_morale_raison_sociale, '' '', plaignant_2.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier'' OR plaignant_2.personne_morale_nom IS NOT NULL OR plaignant_2.personne_morale_prenom IS NOT NULL
        THEN plaignant_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN plaignant_2.particulier_nom
        ELSE
            CASE WHEN plaignant_2.personne_morale_nom IS NOT NULL
                THEN plaignant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN plaignant_2.particulier_prenom
        ELSE
            CASE WHEN plaignant_2.personne_morale_prenom IS NOT NULL
                THEN plaignant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_2_civilite.libelle, plaignant_2.particulier_nom, plaignant_2.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN plaignant_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN plaignant_2.particulier_nom
        ELSE ''''
    END as nom_qualite_part_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN plaignant_2.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_plaignant_2,
    CASE WHEN plaignant_2.personne_morale_nom IS NOT NULL OR plaignant_2.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', plaignant_2.personne_morale_raison_sociale, plaignant_2.personne_morale_denomination, ''représenté(e) par'', plaignant_2_civilite.libelle, plaignant_2.personne_morale_nom, plaignant_2.personne_morale_prenom))
        ELSE TRIM(CONCAT(plaignant_2.personne_morale_raison_sociale, '' '', plaignant_2.personne_morale_denomination))
    END as nom_complet_qualite_pm_plaignant_2,
    CASE WHEN plaignant_2.personne_morale_nom IS NOT NULL OR plaignant_2.personne_morale_prenom IS NOT NULL
        THEN plaignant_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_plaignant_2,
    CASE WHEN plaignant_2.personne_morale_nom IS NOT NULL
        THEN plaignant_2.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_plaignant_2,
    CASE WHEN plaignant_2.personne_morale_prenom IS NOT NULL
        THEN plaignant_2.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_2_civilite.libelle, plaignant_2.particulier_nom, plaignant_2.particulier_prenom))
        ELSE
            CASE WHEN plaignant_2.personne_morale_nom IS NOT NULL OR plaignant_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_2.personne_morale_raison_sociale, plaignant_2.personne_morale_denomination, ''représenté(e) par'', plaignant_2_civilite.libelle, plaignant_2.personne_morale_nom, plaignant_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_2.personne_morale_raison_sociale, '' '', plaignant_2.personne_morale_denomination))
            END
    END as nom_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier'' OR plaignant_2.personne_morale_nom IS NOT NULL OR plaignant_2.personne_morale_prenom IS NOT NULL
        THEN plaignant_2_civilite.libelle
        ELSE ''''
    END as civilite_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN plaignant_2.particulier_nom
        ELSE
            CASE WHEN plaignant_2.personne_morale_nom IS NOT NULL
                THEN plaignant_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN plaignant_2.particulier_prenom
        ELSE
            CASE WHEN plaignant_2.personne_morale_prenom IS NOT NULL
                THEN plaignant_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN ''''
        ELSE plaignant_2.personne_morale_raison_sociale
    END as raison_sociale_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN ''''
        ELSE plaignant_2.personne_morale_denomination
    END as denomination_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN ''''
        ELSE plaignant_2.personne_morale_categorie_juridique
    END as categorie_juridique_plaignant_2,
    CASE WHEN plaignant_2.qualite=''particulier''
        THEN ''''
        ELSE plaignant_2.personne_morale_siret
    END as siret_plaignant_2,
    plaignant_2.numero as numero_plaignant_2,
&DB_PREFIXEadresse(plaignant_2.numero::text, plaignant_2.voie::text, plaignant_2.complement::text, plaignant_2.lieu_dit::text, plaignant_2.bp::text, plaignant_2.code_postal::text, plaignant_2.localite::text, plaignant_2.cedex::text) as adresse_plaignant_2_sdl,
&DB_PREFIXEadresse(plaignant_2.numero::text, plaignant_2.voie::text, plaignant_2.complement::text, plaignant_2.lieu_dit::text, plaignant_2.bp::text, plaignant_2.code_postal::text, plaignant_2.localite::text, plaignant_2.cedex::text, '' ''::text) as adresse_plaignant_2,
    plaignant_2.voie as voie_plaignant_2,
    plaignant_2.complement as complement_plaignant_2,
    plaignant_2.lieu_dit as lieu_dit_plaignant_2,
    CASE 
        WHEN plaignant_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', plaignant_2.bp)
    END as bp_plaignant_2,
    plaignant_2.code_postal as code_postal_plaignant_2,
    plaignant_2.localite as localite_plaignant_2,
    CASE 
        WHEN plaignant_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', plaignant_2.cedex)
    END as cedex_plaignant_2,
    plaignant_2.pays as pays_plaignant_2,
    plaignant_2.division_territoriale as division_territoriale_plaignant_2,

    --Coordonnées de l''plaignant 3

    CASE WHEN plaignant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_3_civilite.libelle, plaignant_3.particulier_nom, plaignant_3.particulier_prenom))
        ELSE
            CASE WHEN plaignant_3.personne_morale_nom IS NOT NULL OR plaignant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_3.personne_morale_raison_sociale, plaignant_3.personne_morale_denomination, ''représenté(e) par'', plaignant_3_civilite.libelle, plaignant_3.personne_morale_nom, plaignant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_3.personne_morale_raison_sociale, '' '', plaignant_3.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier'' OR plaignant_3.personne_morale_nom IS NOT NULL OR plaignant_3.personne_morale_prenom IS NOT NULL
        THEN plaignant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN plaignant_3.particulier_nom
        ELSE
            CASE WHEN plaignant_3.personne_morale_nom IS NOT NULL
                THEN plaignant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN plaignant_3.particulier_prenom
        ELSE
            CASE WHEN plaignant_3.personne_morale_prenom IS NOT NULL
                THEN plaignant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_3_civilite.libelle, plaignant_3.particulier_nom, plaignant_3.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN plaignant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN plaignant_3.particulier_nom
        ELSE ''''
    END as nom_qualite_part_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN plaignant_3.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_plaignant_3,
    CASE WHEN plaignant_3.personne_morale_nom IS NOT NULL OR plaignant_3.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', plaignant_3.personne_morale_raison_sociale, plaignant_3.personne_morale_denomination, ''représenté(e) par'', plaignant_3_civilite.libelle, plaignant_3.personne_morale_nom, plaignant_3.personne_morale_prenom))
        ELSE TRIM(CONCAT(plaignant_3.personne_morale_raison_sociale, '' '', plaignant_3.personne_morale_denomination))
    END as nom_complet_qualite_pm_plaignant_3,
    CASE WHEN plaignant_3.personne_morale_nom IS NOT NULL OR plaignant_3.personne_morale_prenom IS NOT NULL
        THEN plaignant_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_plaignant_3,
    CASE WHEN plaignant_3.personne_morale_nom IS NOT NULL
        THEN plaignant_3.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_plaignant_3,
    CASE WHEN plaignant_3.personne_morale_prenom IS NOT NULL
        THEN plaignant_3.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_3_civilite.libelle, plaignant_3.particulier_nom, plaignant_3.particulier_prenom))
        ELSE
            CASE WHEN plaignant_3.personne_morale_nom IS NOT NULL OR plaignant_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_3.personne_morale_raison_sociale, plaignant_3.personne_morale_denomination, ''représenté(e) par'', plaignant_3_civilite.libelle, plaignant_3.personne_morale_nom, plaignant_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_3.personne_morale_raison_sociale, '' '', plaignant_3.personne_morale_denomination))
            END
    END as nom_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier'' OR plaignant_3.personne_morale_nom IS NOT NULL OR plaignant_3.personne_morale_prenom IS NOT NULL
        THEN plaignant_3_civilite.libelle
        ELSE ''''
    END as civilite_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN plaignant_3.particulier_nom
        ELSE
            CASE WHEN plaignant_3.personne_morale_nom IS NOT NULL
                THEN plaignant_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN plaignant_3.particulier_prenom
        ELSE
            CASE WHEN plaignant_3.personne_morale_prenom IS NOT NULL
                THEN plaignant_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN ''''
        ELSE plaignant_3.personne_morale_raison_sociale
    END as raison_sociale_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN ''''
        ELSE plaignant_3.personne_morale_denomination
    END as denomination_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN ''''
        ELSE plaignant_3.personne_morale_siret
    END as siret_plaignant_3,
    CASE WHEN plaignant_3.qualite=''particulier''
        THEN ''''
        ELSE plaignant_3.personne_morale_categorie_juridique
    END as categorie_juridique_plaignant_3,
    plaignant_3.numero as numero_plaignant_3,
&DB_PREFIXEadresse(plaignant_3.numero::text, plaignant_3.voie::text, plaignant_3.complement::text, plaignant_3.lieu_dit::text, plaignant_3.bp::text, plaignant_3.code_postal::text, plaignant_3.localite::text, plaignant_3.cedex::text) as adresse_plaignant_3_sdl,
&DB_PREFIXEadresse(plaignant_3.numero::text, plaignant_3.voie::text, plaignant_3.complement::text, plaignant_3.lieu_dit::text, plaignant_3.bp::text, plaignant_3.code_postal::text, plaignant_3.localite::text, plaignant_3.cedex::text, '' ''::text) as adresse_plaignant_3,
    plaignant_3.voie as voie_plaignant_3,
    plaignant_3.complement as complement_plaignant_3,
    plaignant_3.lieu_dit as lieu_dit_plaignant_3,
    CASE 
        WHEN plaignant_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', plaignant_3.bp)
    END as bp_plaignant_3,
    plaignant_3.code_postal as code_postal_plaignant_3,
    plaignant_3.localite as localite_plaignant_3,
    CASE 
        WHEN plaignant_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', plaignant_3.cedex)
    END as cedex_plaignant_3,
    plaignant_3.pays as pays_plaignant_3,
    plaignant_3.division_territoriale as division_territoriale_plaignant_3,

    --Coordonnées de l''plaignant 4

    CASE WHEN plaignant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_4_civilite.libelle, plaignant_4.particulier_nom, plaignant_4.particulier_prenom))
        ELSE
            CASE WHEN plaignant_4.personne_morale_nom IS NOT NULL OR plaignant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_4.personne_morale_raison_sociale, plaignant_4.personne_morale_denomination, ''représenté(e) par'', plaignant_4_civilite.libelle, plaignant_4.personne_morale_nom, plaignant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_4.personne_morale_raison_sociale, '' '', plaignant_4.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier'' OR plaignant_4.personne_morale_nom IS NOT NULL OR plaignant_4.personne_morale_prenom IS NOT NULL
        THEN plaignant_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN plaignant_4.particulier_nom
        ELSE
            CASE WHEN plaignant_4.personne_morale_nom IS NOT NULL
                THEN plaignant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN plaignant_4.particulier_prenom
        ELSE
            CASE WHEN plaignant_4.personne_morale_prenom IS NOT NULL
                THEN plaignant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_4_civilite.libelle, plaignant_4.particulier_nom, plaignant_4.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN plaignant_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN plaignant_4.particulier_nom
        ELSE ''''
    END as nom_qualite_part_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN plaignant_4.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_plaignant_4,
    CASE WHEN plaignant_4.personne_morale_nom IS NOT NULL OR plaignant_4.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', plaignant_4.personne_morale_raison_sociale, plaignant_4.personne_morale_denomination, ''représenté(e) par'', plaignant_4_civilite.libelle, plaignant_4.personne_morale_nom, plaignant_4.personne_morale_prenom))
        ELSE TRIM(CONCAT(plaignant_4.personne_morale_raison_sociale, '' '', plaignant_4.personne_morale_denomination))
    END as nom_complet_qualite_pm_plaignant_4,
    CASE WHEN plaignant_4.personne_morale_nom IS NOT NULL OR plaignant_4.personne_morale_prenom IS NOT NULL
        THEN plaignant_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_4_civilite.libelle, plaignant_4.particulier_nom, plaignant_4.particulier_prenom))
        ELSE
            CASE WHEN plaignant_4.personne_morale_nom IS NOT NULL OR plaignant_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_4.personne_morale_raison_sociale, plaignant_4.personne_morale_denomination, ''représenté(e) par'', plaignant_4_civilite.libelle, plaignant_4.personne_morale_nom, plaignant_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_4.personne_morale_raison_sociale, '' '', plaignant_4.personne_morale_denomination))
            END
    END as nom_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier'' OR plaignant_4.personne_morale_nom IS NOT NULL OR plaignant_4.personne_morale_prenom IS NOT NULL
        THEN plaignant_4_civilite.libelle
        ELSE ''''
    END as civilite_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN plaignant_4.particulier_nom
        ELSE
            CASE WHEN plaignant_4.personne_morale_nom IS NOT NULL
                THEN plaignant_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN plaignant_4.particulier_prenom
        ELSE
            CASE WHEN plaignant_4.personne_morale_prenom IS NOT NULL
                THEN plaignant_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN ''''
        ELSE plaignant_4.personne_morale_raison_sociale
    END as raison_sociale_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN ''''
        ELSE plaignant_4.personne_morale_denomination
    END as denomination_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN ''''
        ELSE plaignant_4.personne_morale_categorie_juridique
    END as categorie_juridique_plaignant_4,
    CASE WHEN plaignant_4.qualite=''particulier''
        THEN ''''
        ELSE plaignant_4.personne_morale_siret
    END as siret_plaignant_4,
    plaignant_4.numero as numero_plaignant_4,
&DB_PREFIXEadresse(plaignant_4.numero::text, plaignant_4.voie::text, plaignant_4.complement::text, plaignant_4.lieu_dit::text, plaignant_4.bp::text, plaignant_4.code_postal::text, plaignant_4.localite::text, plaignant_4.cedex::text) as adresse_plaignant_4_sdl,
&DB_PREFIXEadresse(plaignant_4.numero::text, plaignant_4.voie::text, plaignant_4.complement::text, plaignant_4.lieu_dit::text, plaignant_4.bp::text, plaignant_4.code_postal::text, plaignant_4.localite::text, plaignant_4.cedex::text, '' ''::text) as adresse_plaignant_4,
    plaignant_4.voie as voie_plaignant_4,
    plaignant_4.complement as complement_plaignant_4,
    plaignant_4.lieu_dit as lieu_dit_plaignant_4,
    CASE 
        WHEN plaignant_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', plaignant_4.bp)
    END as bp_plaignant_4,
    plaignant_4.code_postal as code_postal_plaignant_4,
    plaignant_4.localite as localite_plaignant_4,
    CASE 
        WHEN plaignant_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', plaignant_4.cedex)
    END as cedex_plaignant_4,
    plaignant_4.pays as pays_plaignant_4,
    plaignant_4.division_territoriale as division_territoriale_plaignant_4,

    --Coordonnées de l''plaignant 5

    CASE WHEN plaignant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_5_civilite.libelle, plaignant_5.particulier_nom, plaignant_5.particulier_prenom))
        ELSE
            CASE WHEN plaignant_5.personne_morale_nom IS NOT NULL OR plaignant_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_5.personne_morale_raison_sociale, plaignant_5.personne_morale_denomination, ''représenté(e) par'', plaignant_5_civilite.libelle, plaignant_5.personne_morale_nom, plaignant_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_5.personne_morale_raison_sociale, '' '', plaignant_5.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier'' OR plaignant_5.personne_morale_nom IS NOT NULL OR plaignant_5.personne_morale_prenom IS NOT NULL
        THEN plaignant_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN plaignant_5.particulier_nom
        ELSE
            CASE WHEN plaignant_5.personne_morale_nom IS NOT NULL
                THEN plaignant_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN plaignant_5.particulier_prenom
        ELSE
            CASE WHEN plaignant_5.personne_morale_prenom IS NOT NULL
                THEN plaignant_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_5_civilite.libelle, plaignant_5.particulier_nom, plaignant_5.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN plaignant_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN plaignant_5.particulier_nom
        ELSE ''''
    END as nom_qualite_part_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN plaignant_5.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_plaignant_5,
    CASE WHEN plaignant_5.personne_morale_nom IS NOT NULL OR plaignant_5.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', plaignant_5.personne_morale_raison_sociale, plaignant_5.personne_morale_denomination, ''représenté(e) par'', plaignant_5_civilite.libelle, plaignant_5.personne_morale_nom, plaignant_5.personne_morale_prenom))
        ELSE TRIM(CONCAT(plaignant_5.personne_morale_raison_sociale, '' '', plaignant_5.personne_morale_denomination))
    END as nom_complet_qualite_pm_plaignant_5,
    CASE WHEN plaignant_5.personne_morale_nom IS NOT NULL OR plaignant_5.personne_morale_prenom IS NOT NULL
        THEN plaignant_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_plaignant_5,
    CASE WHEN plaignant_5.personne_morale_nom IS NOT NULL
        THEN plaignant_5.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_plaignant_5,
    CASE WHEN plaignant_5.personne_morale_prenom IS NOT NULL
        THEN plaignant_5.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', plaignant_5_civilite.libelle, plaignant_5.particulier_nom, plaignant_5.particulier_prenom))
        ELSE
            CASE WHEN plaignant_5.personne_morale_nom IS NOT NULL OR plaignant_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', plaignant_5.personne_morale_raison_sociale, plaignant_5.personne_morale_denomination, ''représenté(e) par'', plaignant_5_civilite.libelle, plaignant_5.personne_morale_nom, plaignant_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(plaignant_5.personne_morale_raison_sociale, '' '', plaignant_5.personne_morale_denomination))
            END
    END as nom_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier'' OR plaignant_5.personne_morale_nom IS NOT NULL OR plaignant_5.personne_morale_prenom IS NOT NULL
        THEN plaignant_5_civilite.libelle
        ELSE ''''
    END as civilite_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN plaignant_5.particulier_nom
        ELSE
            CASE WHEN plaignant_5.personne_morale_nom IS NOT NULL
                THEN plaignant_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN plaignant_5.particulier_prenom
        ELSE
            CASE WHEN plaignant_5.personne_morale_prenom IS NOT NULL
                THEN plaignant_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN ''''
        ELSE plaignant_5.personne_morale_raison_sociale
    END as raison_sociale_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN ''''
        ELSE plaignant_5.personne_morale_denomination
    END as denomination_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN ''''
        ELSE plaignant_5.personne_morale_categorie_juridique
    END as categorie_juridique_plaignant_5,
    CASE WHEN plaignant_5.qualite=''particulier''
        THEN ''''
        ELSE plaignant_5.personne_morale_siret
    END as siret_plaignant_5,
    plaignant_5.numero as numero_plaignant_5,
&DB_PREFIXEadresse(plaignant_5.numero::text, plaignant_5.voie::text, plaignant_5.complement::text, plaignant_5.lieu_dit::text, plaignant_5.bp::text, plaignant_5.code_postal::text, plaignant_5.localite::text, plaignant_5.cedex::text) as adresse_plaignant_5_sdl,
&DB_PREFIXEadresse(plaignant_5.numero::text, plaignant_5.voie::text, plaignant_5.complement::text, plaignant_5.lieu_dit::text, plaignant_5.bp::text, plaignant_5.code_postal::text, plaignant_5.localite::text, plaignant_5.cedex::text, '' ''::text) as adresse_plaignant_5,
    plaignant_5.voie as voie_plaignant_5,
    plaignant_5.complement as complement_plaignant_5,
    plaignant_5.lieu_dit as lieu_dit_plaignant_5,
    CASE 
        WHEN plaignant_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', plaignant_5.bp)
    END as bp_plaignant_5,
    plaignant_5.code_postal as code_postal_plaignant_5,
    plaignant_5.localite as localite_plaignant_5,
    CASE 
        WHEN plaignant_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', plaignant_5.cedex)
    END as cedex_plaignant_5,
    plaignant_5.pays as pays_plaignant_5,
    plaignant_5.division_territoriale as division_territoriale_plaignant_5,

    --Coordonnées du délégataire

    CASE WHEN delegataire.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
                ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_delegataire,
    CASE WHEN delegataire.qualite=''particulier'' OR delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
        THEN delegataire_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_nom
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL
                THEN delegataire.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_prenom
        ELSE
            CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_nom
        ELSE ''''
    END as nom_qualite_part_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_delegataire,
    CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
        ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
    END as nom_complet_qualite_pm_delegataire,
    CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
        THEN delegataire_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_delegataire,
    CASE WHEN delegataire.personne_morale_nom IS NOT NULL
        THEN delegataire.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_delegataire,
    CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
        THEN delegataire.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_delegataire,
    CASE
        WHEN delegataire.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
                ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
            END
    END as nom_delegataire,
    CASE WHEN delegataire.qualite=''particulier'' OR delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
        THEN delegataire_civilite.libelle
        ELSE ''''
    END as civilite_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_nom
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL
                THEN delegataire.personne_morale_nom
                ELSE ''''
            END
    END as nom_particulier_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN delegataire.particulier_prenom
        ELSE
            CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_particulier_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_raison_sociale
    END as raison_sociale_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_denomination
    END as denomination_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_siret
    END as siret_delegataire,
    CASE WHEN delegataire.qualite=''particulier''
        THEN ''''
        ELSE delegataire.personne_morale_categorie_juridique
    END as categorie_juridique_delegataire,
    delegataire.numero as numero_delegataire,
&DB_PREFIXEadresse(delegataire.numero::text, delegataire.voie::text, delegataire.complement::text, delegataire.lieu_dit::text, delegataire.bp::text, delegataire.code_postal::text, delegataire.localite::text, delegataire.cedex::text) as adresse_delegataire_sdl,
&DB_PREFIXEadresse(delegataire.numero::text, delegataire.voie::text, delegataire.complement::text, delegataire.lieu_dit::text, delegataire.bp::text, delegataire.code_postal::text, delegataire.localite::text, delegataire.cedex::text, '' ''::text) as adresse_delegataire,
    delegataire.voie as voie_delegataire,
    delegataire.complement as complement_delegataire,
    delegataire.lieu_dit as lieu_dit_delegataire,
    CASE 
        WHEN delegataire.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', delegataire.bp)
    END as bp_delegataire,
    delegataire.code_postal as code_postal_delegataire,
    delegataire.localite as ville_delegataire,
    CASE 
        WHEN delegataire.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', delegataire.cedex)
    END as cedex_delegataire,
    delegataire.pays as pays_delegataire,
    delegataire.division_territoriale as division_territoriale_delegataire,

    --Coordonnées de du bailleur principal

    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_principal_civilite.libelle, bailleur_principal.particulier_nom, bailleur_principal.particulier_prenom))
        ELSE
            CASE WHEN bailleur_principal.personne_morale_nom IS NOT NULL OR bailleur_principal.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', bailleur_principal.personne_morale_raison_sociale, bailleur_principal.personne_morale_denomination, ''représenté(e) par'', bailleur_principal_civilite.libelle, bailleur_principal.personne_morale_nom, bailleur_principal.personne_morale_prenom))
                ELSE TRIM(CONCAT(bailleur_principal.personne_morale_raison_sociale, '' '', bailleur_principal.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier'' OR bailleur_principal.personne_morale_nom IS NOT NULL OR bailleur_principal.personne_morale_prenom IS NOT NULL
        THEN bailleur_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN bailleur_principal.particulier_nom
        ELSE
            CASE WHEN bailleur_principal.personne_morale_nom IS NOT NULL
                THEN bailleur_principal.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN bailleur_principal.particulier_prenom
        ELSE
            CASE WHEN bailleur_principal.personne_morale_prenom IS NOT NULL
                THEN bailleur_principal.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_principal_civilite.libelle, bailleur_principal.particulier_nom, bailleur_principal.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN bailleur_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN bailleur_principal.particulier_nom
        ELSE ''''
    END as nom_qualite_part_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN bailleur_principal.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_bailleur_principal,
    CASE WHEN bailleur_principal.personne_morale_nom IS NOT NULL OR bailleur_principal.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', bailleur_principal.personne_morale_raison_sociale, bailleur_principal.personne_morale_denomination, ''représenté(e) par'', bailleur_principal_civilite.libelle, bailleur_principal.personne_morale_nom, bailleur_principal.personne_morale_prenom))
        ELSE TRIM(CONCAT(bailleur_principal.personne_morale_raison_sociale, '' '', bailleur_principal.personne_morale_denomination))
    END as nom_complet_qualite_pm_bailleur_principal,
    CASE WHEN bailleur_principal.personne_morale_nom IS NOT NULL OR bailleur_principal.personne_morale_prenom IS NOT NULL
        THEN bailleur_principal_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_bailleur_principal,
    CASE WHEN bailleur_principal.personne_morale_nom IS NOT NULL
        THEN bailleur_principal.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_bailleur_principal,
    CASE WHEN bailleur_principal.personne_morale_prenom IS NOT NULL
        THEN bailleur_principal.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN ''''
        ELSE bailleur_principal.personne_morale_raison_sociale
    END as raison_sociale_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN ''''
        ELSE bailleur_principal.personne_morale_denomination
    END as denomination_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN ''''
        ELSE bailleur_principal.personne_morale_siret
    END as siret_bailleur_principal,
    CASE WHEN bailleur_principal.qualite=''particulier''
        THEN ''''
        ELSE bailleur_principal.personne_morale_categorie_juridique
    END as categorie_juridique_bailleur_principal,
    bailleur_principal.numero as numero_bailleur_principal,
&DB_PREFIXEadresse(bailleur_principal.numero::text, bailleur_principal.voie::text, bailleur_principal.complement::text, bailleur_principal.lieu_dit::text, bailleur_principal.bp::text, bailleur_principal.code_postal::text, bailleur_principal.localite::text, bailleur_principal.cedex::text) as adresse_bailleur_principal_sdl,
&DB_PREFIXEadresse(bailleur_principal.numero::text, bailleur_principal.voie::text, bailleur_principal.complement::text, bailleur_principal.lieu_dit::text, bailleur_principal.bp::text, bailleur_principal.code_postal::text, bailleur_principal.localite::text, bailleur_principal.cedex::text, '' ''::text) as adresse_bailleur_principal,
    bailleur_principal.voie as voie_bailleur_principal,
    bailleur_principal.complement as complement_bailleur_principal,
    bailleur_principal.lieu_dit as lieu_dit_bailleur_principal,
    CASE 
        WHEN bailleur_principal.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', bailleur_principal.bp)
    END as bp_bailleur_principal,
    bailleur_principal.code_postal as code_postal_bailleur_principal,
    bailleur_principal.localite as localite_bailleur_principal,
    CASE 
        WHEN bailleur_principal.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', bailleur_principal.cedex)
    END as cedex_bailleur_principal,
    bailleur_principal.pays as pays_bailleur_principal,
    bailleur_principal.division_territoriale as division_territoriale_bailleur_principal,

    --Coordonnées de du bailleur 1

    CASE WHEN bailleur_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_1_civilite.libelle, bailleur_1.particulier_nom, bailleur_1.particulier_prenom))
        ELSE
            CASE WHEN bailleur_1.personne_morale_nom IS NOT NULL OR bailleur_1.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', bailleur_1.personne_morale_raison_sociale, bailleur_1.personne_morale_denomination, ''représenté(e) par'', bailleur_1_civilite.libelle, bailleur_1.personne_morale_nom, bailleur_1.personne_morale_prenom))
                ELSE TRIM(CONCAT(bailleur_1.personne_morale_raison_sociale, '' '', bailleur_1.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier'' OR bailleur_1.personne_morale_nom IS NOT NULL OR bailleur_1.personne_morale_prenom IS NOT NULL
        THEN bailleur_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN bailleur_1.particulier_nom
        ELSE
            CASE WHEN bailleur_1.personne_morale_nom IS NOT NULL
                THEN bailleur_1.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN bailleur_1.particulier_prenom
        ELSE
            CASE WHEN bailleur_1.personne_morale_prenom IS NOT NULL
                THEN bailleur_1.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_1_civilite.libelle, bailleur_1.particulier_nom, bailleur_1.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN bailleur_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN bailleur_1.particulier_nom
        ELSE ''''
    END as nom_qualite_part_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN bailleur_1.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_bailleur_1,
    CASE WHEN bailleur_1.personne_morale_nom IS NOT NULL OR bailleur_1.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', bailleur_1.personne_morale_raison_sociale, bailleur_1.personne_morale_denomination, ''représenté(e) par'', bailleur_1_civilite.libelle, bailleur_1.personne_morale_nom, bailleur_1.personne_morale_prenom))
        ELSE TRIM(CONCAT(bailleur_1.personne_morale_raison_sociale, '' '', bailleur_1.personne_morale_denomination))
    END as nom_complet_qualite_pm_bailleur_1,
    CASE WHEN bailleur_1.personne_morale_nom IS NOT NULL OR bailleur_1.personne_morale_prenom IS NOT NULL
        THEN bailleur_1_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_bailleur_1,
    CASE WHEN bailleur_1.personne_morale_nom IS NOT NULL
        THEN bailleur_1.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_bailleur_1,
    CASE WHEN bailleur_1.personne_morale_prenom IS NOT NULL
        THEN bailleur_1.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN ''''
        ELSE bailleur_1.personne_morale_raison_sociale
    END as raison_sociale_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN ''''
        ELSE bailleur_1.personne_morale_denomination
    END as denomination_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN ''''
        ELSE bailleur_1.personne_morale_siret
    END as siret_bailleur_1,
    CASE WHEN bailleur_1.qualite=''particulier''
        THEN ''''
        ELSE bailleur_1.personne_morale_categorie_juridique
    END as categorie_juridique_bailleur_1,
    bailleur_1.numero as numero_bailleur_1,
&DB_PREFIXEadresse(bailleur_1.numero::text, bailleur_1.voie::text, bailleur_1.complement::text, bailleur_1.lieu_dit::text, bailleur_1.bp::text, bailleur_1.code_postal::text, bailleur_1.localite::text, bailleur_1.cedex::text) as adresse_bailleur_1_sdl,
&DB_PREFIXEadresse(bailleur_1.numero::text, bailleur_1.voie::text, bailleur_1.complement::text, bailleur_1.lieu_dit::text, bailleur_1.bp::text, bailleur_1.code_postal::text, bailleur_1.localite::text, bailleur_1.cedex::text, '' ''::text) as adresse_bailleur_1,
    bailleur_1.voie as voie_bailleur_1,
    bailleur_1.complement as complement_bailleur_1,
    bailleur_1.lieu_dit as lieu_dit_bailleur_1,
    CASE 
        WHEN bailleur_1.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', bailleur_1.bp)
    END as bp_bailleur_1,
    bailleur_1.code_postal as code_postal_bailleur_1,
    bailleur_1.localite as localite_bailleur_1,
    CASE 
        WHEN bailleur_1.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', bailleur_1.cedex)
    END as cedex_bailleur_1,
    bailleur_1.pays as pays_bailleur_1,
    bailleur_1.division_territoriale as division_territoriale_bailleur_1,

    --Coordonnées de du bailleur 2

    CASE WHEN bailleur_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_2_civilite.libelle, bailleur_2.particulier_nom, bailleur_2.particulier_prenom))
        ELSE
            CASE WHEN bailleur_2.personne_morale_nom IS NOT NULL OR bailleur_2.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', bailleur_2.personne_morale_raison_sociale, bailleur_2.personne_morale_denomination, ''représenté(e) par'', bailleur_2_civilite.libelle, bailleur_2.personne_morale_nom, bailleur_2.personne_morale_prenom))
                ELSE TRIM(CONCAT(bailleur_2.personne_morale_raison_sociale, '' '', bailleur_2.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier'' OR bailleur_2.personne_morale_nom IS NOT NULL OR bailleur_2.personne_morale_prenom IS NOT NULL
        THEN bailleur_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN bailleur_2.particulier_nom
        ELSE
            CASE WHEN bailleur_2.personne_morale_nom IS NOT NULL
                THEN bailleur_2.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN bailleur_2.particulier_prenom
        ELSE
            CASE WHEN bailleur_2.personne_morale_prenom IS NOT NULL
                THEN bailleur_2.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_2_civilite.libelle, bailleur_2.particulier_nom, bailleur_2.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN bailleur_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN bailleur_2.particulier_nom
        ELSE ''''
    END as nom_qualite_part_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN bailleur_2.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_bailleur_2,
    CASE WHEN bailleur_2.personne_morale_nom IS NOT NULL OR bailleur_2.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', bailleur_2.personne_morale_raison_sociale, bailleur_2.personne_morale_denomination, ''représenté(e) par'', bailleur_2_civilite.libelle, bailleur_2.personne_morale_nom, bailleur_2.personne_morale_prenom))
        ELSE TRIM(CONCAT(bailleur_2.personne_morale_raison_sociale, '' '', bailleur_2.personne_morale_denomination))
    END as nom_complet_qualite_pm_bailleur_2,
    CASE WHEN bailleur_2.personne_morale_nom IS NOT NULL OR bailleur_2.personne_morale_prenom IS NOT NULL
        THEN bailleur_2_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_bailleur_2,
    CASE WHEN bailleur_2.personne_morale_nom IS NOT NULL
        THEN bailleur_2.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_bailleur_2,
    CASE WHEN bailleur_2.personne_morale_prenom IS NOT NULL
        THEN bailleur_2.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN ''''
        ELSE bailleur_2.personne_morale_raison_sociale
    END as raison_sociale_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN ''''
        ELSE bailleur_2.personne_morale_denomination
    END as denomination_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN ''''
        ELSE bailleur_2.personne_morale_categorie_juridique
    END as categorie_juridique_bailleur_2,
    CASE WHEN bailleur_2.qualite=''particulier''
        THEN ''''
        ELSE bailleur_2.personne_morale_siret
    END as siret_bailleur_2,
    bailleur_2.numero as numero_bailleur_2,
&DB_PREFIXEadresse(bailleur_2.numero::text, bailleur_2.voie::text, bailleur_2.complement::text, bailleur_2.lieu_dit::text, bailleur_2.bp::text, bailleur_2.code_postal::text, bailleur_2.localite::text, bailleur_2.cedex::text) as adresse_bailleur_2_sdl,
&DB_PREFIXEadresse(bailleur_2.numero::text, bailleur_2.voie::text, bailleur_2.complement::text, bailleur_2.lieu_dit::text, bailleur_2.bp::text, bailleur_2.code_postal::text, bailleur_2.localite::text, bailleur_2.cedex::text, '' ''::text) as adresse_bailleur_2,
    bailleur_2.voie as voie_bailleur_2,
    bailleur_2.complement as complement_bailleur_2,
    bailleur_2.lieu_dit as lieu_dit_bailleur_2,
    CASE 
        WHEN bailleur_2.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', bailleur_2.bp)
    END as bp_bailleur_2,
    bailleur_2.code_postal as code_postal_bailleur_2,
    bailleur_2.localite as localite_bailleur_2,
    CASE 
        WHEN bailleur_2.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', bailleur_2.cedex)
    END as cedex_bailleur_2,
    bailleur_2.pays as pays_bailleur_2,
    bailleur_2.division_territoriale as division_territoriale_bailleur_2,

    --Coordonnées de du bailleur 3

    CASE WHEN bailleur_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_3_civilite.libelle, bailleur_3.particulier_nom, bailleur_3.particulier_prenom))
        ELSE
            CASE WHEN bailleur_3.personne_morale_nom IS NOT NULL OR bailleur_3.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', bailleur_3.personne_morale_raison_sociale, bailleur_3.personne_morale_denomination, ''représenté(e) par'', bailleur_3_civilite.libelle, bailleur_3.personne_morale_nom, bailleur_3.personne_morale_prenom))
                ELSE TRIM(CONCAT(bailleur_3.personne_morale_raison_sociale, '' '', bailleur_3.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier'' OR bailleur_3.personne_morale_nom IS NOT NULL OR bailleur_3.personne_morale_prenom IS NOT NULL
        THEN bailleur_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN bailleur_3.particulier_nom
        ELSE
            CASE WHEN bailleur_3.personne_morale_nom IS NOT NULL
                THEN bailleur_3.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN bailleur_3.particulier_prenom
        ELSE
            CASE WHEN bailleur_3.personne_morale_prenom IS NOT NULL
                THEN bailleur_3.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_3_civilite.libelle, bailleur_3.particulier_nom, bailleur_3.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN bailleur_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN bailleur_3.particulier_nom
        ELSE ''''
    END as nom_qualite_part_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN bailleur_3.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_bailleur_3,
    CASE WHEN bailleur_3.personne_morale_nom IS NOT NULL OR bailleur_3.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', bailleur_3.personne_morale_raison_sociale, bailleur_3.personne_morale_denomination, ''représenté(e) par'', bailleur_3_civilite.libelle, bailleur_3.personne_morale_nom, bailleur_3.personne_morale_prenom))
        ELSE TRIM(CONCAT(bailleur_3.personne_morale_raison_sociale, '' '', bailleur_3.personne_morale_denomination))
    END as nom_complet_qualite_pm_bailleur_3,
    CASE WHEN bailleur_3.personne_morale_nom IS NOT NULL OR bailleur_3.personne_morale_prenom IS NOT NULL
        THEN bailleur_3_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_bailleur_3,
    CASE WHEN bailleur_3.personne_morale_nom IS NOT NULL
        THEN bailleur_3.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_bailleur_3,
    CASE WHEN bailleur_3.personne_morale_prenom IS NOT NULL
        THEN bailleur_3.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN ''''
        ELSE bailleur_3.personne_morale_raison_sociale
    END as raison_sociale_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN ''''
        ELSE bailleur_3.personne_morale_denomination
    END as denomination_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN ''''
        ELSE bailleur_3.personne_morale_siret
    END as siret_bailleur_3,
    CASE WHEN bailleur_3.qualite=''particulier''
        THEN ''''
        ELSE bailleur_3.personne_morale_categorie_juridique
    END as categorie_juridique_bailleur_3,
    bailleur_3.numero as numero_bailleur_3,
&DB_PREFIXEadresse(bailleur_3.numero::text, bailleur_3.voie::text, bailleur_3.complement::text, bailleur_3.lieu_dit::text, bailleur_3.bp::text, bailleur_3.code_postal::text, bailleur_3.localite::text, bailleur_3.cedex::text) as adresse_bailleur_3_sdl,
&DB_PREFIXEadresse(bailleur_3.numero::text, bailleur_3.voie::text, bailleur_3.complement::text, bailleur_3.lieu_dit::text, bailleur_3.bp::text, bailleur_3.code_postal::text, bailleur_3.localite::text, bailleur_3.cedex::text, '' ''::text) as adresse_bailleur_3,
    bailleur_3.voie as voie_bailleur_3,
    bailleur_3.complement as complement_bailleur_3,
    bailleur_3.lieu_dit as lieu_dit_bailleur_3,
    CASE 
        WHEN bailleur_3.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', bailleur_3.bp)
    END as bp_bailleur_3,
    bailleur_3.code_postal as code_postal_bailleur_3,
    bailleur_3.localite as localite_bailleur_3,
    CASE 
        WHEN bailleur_3.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', bailleur_3.cedex)
    END as cedex_bailleur_3,
    bailleur_3.pays as pays_bailleur_3,
    bailleur_3.division_territoriale as division_territoriale_bailleur_3,

    --Coordonnées de du bailleur 4

    CASE WHEN bailleur_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_4_civilite.libelle, bailleur_4.particulier_nom, bailleur_4.particulier_prenom))
        ELSE
            CASE WHEN bailleur_4.personne_morale_nom IS NOT NULL OR bailleur_4.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', bailleur_4.personne_morale_raison_sociale, bailleur_4.personne_morale_denomination, ''représenté(e) par'', bailleur_4_civilite.libelle, bailleur_4.personne_morale_nom, bailleur_4.personne_morale_prenom))
                ELSE TRIM(CONCAT(bailleur_4.personne_morale_raison_sociale, '' '', bailleur_4.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier'' OR bailleur_4.personne_morale_nom IS NOT NULL OR bailleur_4.personne_morale_prenom IS NOT NULL
        THEN bailleur_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN bailleur_4.particulier_nom
        ELSE
            CASE WHEN bailleur_4.personne_morale_nom IS NOT NULL
                THEN bailleur_4.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN bailleur_4.particulier_prenom
        ELSE
            CASE WHEN bailleur_4.personne_morale_prenom IS NOT NULL
                THEN bailleur_4.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_4_civilite.libelle, bailleur_4.particulier_nom, bailleur_4.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN bailleur_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN bailleur_4.particulier_nom
        ELSE ''''
    END as nom_qualite_part_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN bailleur_4.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_bailleur_4,
    CASE WHEN bailleur_4.personne_morale_nom IS NOT NULL OR bailleur_4.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', bailleur_4.personne_morale_raison_sociale, bailleur_4.personne_morale_denomination, ''représenté(e) par'', bailleur_4_civilite.libelle, bailleur_4.personne_morale_nom, bailleur_4.personne_morale_prenom))
        ELSE TRIM(CONCAT(bailleur_4.personne_morale_raison_sociale, '' '', bailleur_4.personne_morale_denomination))
    END as nom_complet_qualite_pm_bailleur_4,
    CASE WHEN bailleur_4.personne_morale_nom IS NOT NULL OR bailleur_4.personne_morale_prenom IS NOT NULL
        THEN bailleur_4_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_bailleur_4,
    CASE WHEN bailleur_4.personne_morale_nom IS NOT NULL
        THEN bailleur_4.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_bailleur_4,
    CASE WHEN bailleur_4.personne_morale_prenom IS NOT NULL
        THEN bailleur_4.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN ''''
        ELSE bailleur_4.personne_morale_raison_sociale
    END as raison_sociale_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN ''''
        ELSE bailleur_4.personne_morale_denomination
    END as denomination_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN ''''
        ELSE bailleur_4.personne_morale_categorie_juridique
    END as categorie_juridique_bailleur_4,
    CASE WHEN bailleur_4.qualite=''particulier''
        THEN ''''
        ELSE bailleur_4.personne_morale_siret
    END as siret_bailleur_4,
    bailleur_4.numero as numero_bailleur_4,
&DB_PREFIXEadresse(bailleur_4.numero::text, bailleur_4.voie::text, bailleur_4.complement::text, bailleur_4.lieu_dit::text, bailleur_4.bp::text, bailleur_4.code_postal::text, bailleur_4.localite::text, bailleur_4.cedex::text) as adresse_bailleur_4_sdl,
&DB_PREFIXEadresse(bailleur_4.numero::text, bailleur_4.voie::text, bailleur_4.complement::text, bailleur_4.lieu_dit::text, bailleur_4.bp::text, bailleur_4.code_postal::text, bailleur_4.localite::text, bailleur_4.cedex::text, '' ''::text) as adresse_bailleur_4,
    bailleur_4.voie as voie_bailleur_4,
    bailleur_4.complement as complement_bailleur_4,
    bailleur_4.lieu_dit as lieu_dit_bailleur_4,
    CASE 
        WHEN bailleur_4.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', bailleur_4.bp)
    END as bp_bailleur_4,
    bailleur_4.code_postal as code_postal_bailleur_4,
    bailleur_4.localite as localite_bailleur_4,
    CASE 
        WHEN bailleur_4.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', bailleur_4.cedex)
    END as cedex_bailleur_4,
    bailleur_4.pays as pays_bailleur_4,
    bailleur_4.division_territoriale as division_territoriale_bailleur_4,

    --Coordonnées de du bailleur 5

    CASE WHEN bailleur_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_5_civilite.libelle, bailleur_5.particulier_nom, bailleur_5.particulier_prenom))
        ELSE
            CASE WHEN bailleur_5.personne_morale_nom IS NOT NULL OR bailleur_5.personne_morale_prenom IS NOT NULL
                THEN TRIM(CONCAT_WS('' '', bailleur_5.personne_morale_raison_sociale, bailleur_5.personne_morale_denomination, ''représenté(e) par'', bailleur_5_civilite.libelle, bailleur_5.personne_morale_nom, bailleur_5.personne_morale_prenom))
                ELSE TRIM(CONCAT(bailleur_5.personne_morale_raison_sociale, '' '', bailleur_5.personne_morale_denomination))
            END
    END as nom_complet_qualite_part_ou_pm_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier'' OR bailleur_5.personne_morale_nom IS NOT NULL OR bailleur_5.personne_morale_prenom IS NOT NULL
        THEN bailleur_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_ou_pm_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN bailleur_5.particulier_nom
        ELSE
            CASE WHEN bailleur_5.personne_morale_nom IS NOT NULL
                THEN bailleur_5.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_part_ou_pm_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN bailleur_5.particulier_prenom
        ELSE
            CASE WHEN bailleur_5.personne_morale_prenom IS NOT NULL
                THEN bailleur_5.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_part_ou_pm_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN TRIM(CONCAT_WS('' '', bailleur_5_civilite.libelle, bailleur_5.particulier_nom, bailleur_5.particulier_prenom))
        ELSE ''''
    END as nom_complet_qualite_part_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN bailleur_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_part_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN bailleur_5.particulier_nom
        ELSE ''''
    END as nom_qualite_part_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN bailleur_5.particulier_prenom
        ELSE ''''
    END as prenom_qualite_part_bailleur_5,
    CASE WHEN bailleur_5.personne_morale_nom IS NOT NULL OR bailleur_5.personne_morale_prenom IS NOT NULL
        THEN TRIM(CONCAT_WS('' '', bailleur_5.personne_morale_raison_sociale, bailleur_5.personne_morale_denomination, ''représenté(e) par'', bailleur_5_civilite.libelle, bailleur_5.personne_morale_nom, bailleur_5.personne_morale_prenom))
        ELSE TRIM(CONCAT(bailleur_5.personne_morale_raison_sociale, '' '', bailleur_5.personne_morale_denomination))
    END as nom_complet_qualite_pm_bailleur_5,
    CASE WHEN bailleur_5.personne_morale_nom IS NOT NULL OR bailleur_5.personne_morale_prenom IS NOT NULL
        THEN bailleur_5_civilite.libelle
        ELSE ''''
    END as civilite_qualite_pm_bailleur_5,
    CASE WHEN bailleur_5.personne_morale_nom IS NOT NULL
        THEN bailleur_5.personne_morale_nom
        ELSE ''''
    END as nom_qualite_pm_bailleur_5,
    CASE WHEN bailleur_5.personne_morale_prenom IS NOT NULL
        THEN bailleur_5.personne_morale_prenom
        ELSE ''''
    END as prenom_qualite_pm_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN ''''
        ELSE bailleur_5.personne_morale_raison_sociale
    END as raison_sociale_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN ''''
        ELSE bailleur_5.personne_morale_denomination
    END as denomination_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN ''''
        ELSE bailleur_5.personne_morale_categorie_juridique
    END as categorie_juridique_bailleur_5,
    CASE WHEN bailleur_5.qualite=''particulier''
        THEN ''''
        ELSE bailleur_5.personne_morale_siret
    END as siret_bailleur_5,
    bailleur_5.numero as numero_bailleur_5,
&DB_PREFIXEadresse(bailleur_5.numero::text, bailleur_5.voie::text, bailleur_5.complement::text, bailleur_5.lieu_dit::text, bailleur_5.bp::text, bailleur_5.code_postal::text, bailleur_5.localite::text, bailleur_5.cedex::text) as adresse_bailleur_5_sdl,
&DB_PREFIXEadresse(bailleur_5.numero::text, bailleur_5.voie::text, bailleur_5.complement::text, bailleur_5.lieu_dit::text, bailleur_5.bp::text, bailleur_5.code_postal::text, bailleur_5.localite::text, bailleur_5.cedex::text, '' ''::text) as adresse_bailleur_5,
    bailleur_5.voie as voie_bailleur_5,
    bailleur_5.complement as complement_bailleur_5,
    bailleur_5.lieu_dit as lieu_dit_bailleur_5,
    CASE 
        WHEN bailleur_5.bp IS NULL
        THEN ''''
        ELSE CONCAT(''BP '', bailleur_5.bp)
    END as bp_bailleur_5,
    bailleur_5.code_postal as code_postal_bailleur_5,
    bailleur_5.localite as localite_bailleur_5,
    CASE 
        WHEN bailleur_5.cedex IS NULL
        THEN ''''
        ELSE CONCAT(''CEDEX '', bailleur_5.cedex)
    END as cedex_bailleur_5,
    bailleur_5.pays as pays_bailleur_5,
    bailleur_5.division_territoriale as division_territoriale_bailleur_5,

    -- CORRESPONDANT : destinataire du courrier. Il est le délégataire ou le pétitionnaire principal

    CASE
        WHEN delegataire.qualite IS NULL
        THEN
                CASE WHEN petitionnaire_principal.qualite=''particulier''
                    THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
                    ELSE
                        CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                            THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                            ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
                        END
                END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
                ELSE
                    CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                        THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
                        ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
                    END
            END
    END as nom_complet_qualite_part_ou_pm_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier'' OR petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal_civilite.libelle
                ELSE ''''
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier'' OR delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire_civilite.libelle
                ELSE ''''
            END
    END as civilite_qualite_part_ou_pm_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN petitionnaire_principal.particulier_nom
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                        THEN petitionnaire_principal.personne_morale_nom
                        ELSE ''''
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN delegataire.particulier_nom
                ELSE
                    CASE WHEN delegataire.personne_morale_nom IS NOT NULL
                        THEN delegataire.personne_morale_nom
                        ELSE ''''
                    END
            END
    END as nom_qualite_part_ou_pm_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN petitionnaire_principal.particulier_prenom
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                        THEN petitionnaire_principal.personne_morale_prenom
                        ELSE ''''
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN delegataire.particulier_prenom
                ELSE
                    CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
                        THEN delegataire.personne_morale_prenom
                        ELSE ''''
                    END
            END
    END as prenom_qualite_part_ou_pm_correspondant,
    CASE
        WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
                ELSE ''''
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
                ELSE ''''
            END
    END as nom_complet_qualite_part_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN petitionnaire_principal_civilite.libelle
                ELSE ''''
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN delegataire_civilite.libelle
                ELSE ''''
            END
    END as civilite_qualite_part_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            petitionnaire_principal.particulier_nom
        ELSE
            delegataire.particulier_nom
    END as nom_qualite_part_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            petitionnaire_principal.particulier_prenom
        ELSE
            delegataire.particulier_prenom
    END as prenom_qualite_part_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal_civilite.libelle
                ELSE ''''
            END
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire_civilite.libelle
                ELSE ''''
            END
    END as civilite_qualite_pm_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_nom
                ELSE ''''
            END
        ELSE
            CASE WHEN delegataire.personne_morale_nom IS NOT NULL
                THEN delegataire.personne_morale_nom
                ELSE ''''
            END
    END as nom_qualite_pm_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal.personne_morale_prenom
                ELSE ''''
            END
        ELSE
            CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire.personne_morale_prenom
                ELSE ''''
            END
    END as prenom_qualite_pm_correspondant,

    CASE
        WHEN delegataire.qualite IS NULL
        THEN
                CASE WHEN petitionnaire_principal.qualite=''particulier''
                    THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
                    ELSE
                        CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                            THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                            ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
                        END
                END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
                ELSE
                    CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                        THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
                        ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
                    END
            END
    END as nom_complet_qualite_pm_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN TRIM(CONCAT_WS('' '', petitionnaire_principal_civilite.libelle, petitionnaire_principal.particulier_nom, petitionnaire_principal.particulier_prenom))
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                        THEN TRIM(CONCAT_WS('' '', petitionnaire_principal.personne_morale_raison_sociale, petitionnaire_principal.personne_morale_denomination, ''représenté(e) par'', petitionnaire_principal_civilite.libelle, petitionnaire_principal.personne_morale_nom, petitionnaire_principal.personne_morale_prenom))
                        ELSE TRIM(CONCAT(petitionnaire_principal.personne_morale_raison_sociale, '' '', petitionnaire_principal.personne_morale_denomination))
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN TRIM(CONCAT_WS('' '', delegataire_civilite.libelle, delegataire.particulier_nom, delegataire.particulier_prenom))
                ELSE
                    CASE WHEN delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                        THEN TRIM(CONCAT_WS('' '', delegataire.personne_morale_raison_sociale, delegataire.personne_morale_denomination, ''représenté(e) par'', delegataire_civilite.libelle, delegataire.personne_morale_nom, delegataire.personne_morale_prenom))
                        ELSE TRIM(CONCAT(delegataire.personne_morale_raison_sociale, '' '', delegataire.personne_morale_denomination))
                    END
            END
    END as nom_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier'' OR petitionnaire_principal.personne_morale_nom IS NOT NULL OR petitionnaire_principal.personne_morale_prenom IS NOT NULL
                THEN petitionnaire_principal_civilite.libelle
                ELSE ''''
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier'' OR delegataire.personne_morale_nom IS NOT NULL OR delegataire.personne_morale_prenom IS NOT NULL
                THEN delegataire_civilite.libelle
                ELSE ''''
            END
    END as civilite_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN petitionnaire_principal.particulier_nom
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_nom IS NOT NULL
                        THEN petitionnaire_principal.personne_morale_nom
                        ELSE ''''
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN delegataire.particulier_nom
                ELSE
                    CASE WHEN delegataire.personne_morale_nom IS NOT NULL
                        THEN delegataire.personne_morale_nom
                        ELSE ''''
                    END
            END
    END as nom_particulier_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN petitionnaire_principal.particulier_prenom
                ELSE
                    CASE WHEN petitionnaire_principal.personne_morale_prenom IS NOT NULL
                        THEN petitionnaire_principal.personne_morale_prenom
                        ELSE ''''
                    END
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN delegataire.particulier_prenom
                ELSE
                    CASE WHEN delegataire.personne_morale_prenom IS NOT NULL
                        THEN delegataire.personne_morale_prenom
                        ELSE ''''
                    END
            END
    END as prenom_particulier_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_raison_sociale
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_raison_sociale
            END
    END as raison_sociale_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_denomination
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_denomination
            END
    END as denomination_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_siret
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_siret
            END
    END as siret_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN
            CASE WHEN petitionnaire_principal.qualite=''particulier''
                THEN ''''
                ELSE petitionnaire_principal.personne_morale_categorie_juridique
            END
        ELSE
            CASE WHEN delegataire.qualite=''particulier''
                THEN ''''
                ELSE delegataire.personne_morale_categorie_juridique
            END
    END as categorie_juridique_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.numero
        ELSE delegataire.numero
    END as numero_correspondant,
&DB_PREFIXEadresse(CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.numero ELSE delegataire.numero END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.voie ELSE delegataire.voie END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.complement ELSE delegataire.complement END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.lieu_dit ELSE delegataire.lieu_dit END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.bp ELSE delegataire.bp END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.code_postal ELSE delegataire.code_postal END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.localite ELSE delegataire.localite END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text) as adresse_correspondant_sdl,
&DB_PREFIXEadresse(CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.numero ELSE delegataire.numero END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.voie ELSE delegataire.voie END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.complement ELSE delegataire.complement END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.lieu_dit ELSE delegataire.lieu_dit END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.bp ELSE delegataire.bp END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.code_postal ELSE delegataire.code_postal END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.localite ELSE delegataire.localite END::text, CASE WHEN delegataire.qualite IS NULL THEN petitionnaire_principal.cedex ELSE delegataire.cedex END::text, '' ''::text) as adresse_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.voie
        ELSE delegataire.voie
    END as voie_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.complement
        ELSE delegataire.complement
    END as complement_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.lieu_dit
        ELSE delegataire.lieu_dit
    END as lieu_dit_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN 
            CASE 
                WHEN petitionnaire_principal.bp IS NULL
                THEN ''''
                ELSE CONCAT(''BP '', petitionnaire_principal.bp)
            END
        ELSE 
            CASE 
                WHEN delegataire.bp IS NULL
                THEN ''''
                ELSE CONCAT(''BP '', delegataire.bp)
            END
    END as bp_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.code_postal
        ELSE delegataire.code_postal
    END as code_postal_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.localite
        ELSE delegataire.localite
    END as ville_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN 
            CASE 
                WHEN petitionnaire_principal.cedex IS NULL
                THEN ''''
                ELSE CONCAT(''CEDEX '', petitionnaire_principal.cedex)
            END 
        ELSE 
            CASE 
                WHEN delegataire.cedex IS NULL
                THEN ''''
                ELSE CONCAT(''CEDEX '', delegataire.cedex)
            END 
    END as cedex_correspondant,

    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.pays
        ELSE delegataire.pays
    END as pays_correspondant,
    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.division_territoriale
        ELSE delegataire.division_territoriale
    END as division_territoriale_correspondant,
    CASE WHEN delegataire.qualite IS NULL
        THEN petitionnaire_principal.courriel
        ELSE delegataire.courriel
    END as email_correspondant,
    CASE WHEN delegataire.qualite IS NULL
        THEN CASE WHEN petitionnaire_principal.notification IS TRUE
                THEN ''[X]''
                ELSE ''[ ]''
            END
        ELSE ''[ ]''
    END as notification_correspondant,

    --Dates importantes du dossier d''instruction
    to_char(dossier.date_depot_mairie, ''DD/MM/YYYY'') as date_depot_mairie,
    to_char(dossier.date_affichage, ''DD/MM/YYYY'') as date_affichage,
    to_char(dossier.date_depot, ''DD/MM/YYYY'') as date_depot_dossier,
    to_char(dossier.date_complet, ''DD/MM/YYYY'') as date_completude,
    to_char(dossier.date_dernier_depot, ''DD/MM/YYYY'') as date_dernier_depot,
    to_char(dossier.date_decision, ''DD/MM/YYYY'') as date_decision_dossier,
    CASE WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE 
        THEN to_char(dossier.date_limite_incompletude ,''DD/MM/YYYY'') 
        ELSE to_char(dossier.date_limite ,''DD/MM/YYYY'')
    END as date_limite_dossier,
    to_char(dossier.date_achevement,''DD/MM/YYYY'') as date_achevement_dossier,
    to_char(dossier.date_conformite,''DD/MM/YYYY'') as date_conformite_dossier,
    to_char(dossier.date_notification_delai,''DD/MM/YYYY'') as date_notification_delai_dossier,
    
    --Noms des signataires
    TRIM(CONCAT(signataire_civilite.libelle, '' '',signataire_arrete.prenom, '' '', signataire_arrete.nom)) as arrete_signataire,
    TRIM(CONCAT(signataire_arrete.qualite, '' '', signataire_arrete.signature)) as signature_signataire,
    TRIM(signataire_arrete.signature) as signature_signataire_ss_qualite,
    division.chef as chef_division,
    direction.chef as chef_direction,
    direction.libelle as libelle_direction,
    direction.description as description_direction,
    
    --Données générales des données techniques
    donnees_techniques.co_projet_desc as co_projet_desc_donnees_techniques,
    donnees_techniques.am_projet_desc as am_projet_desc_donnees_techniques,
    donnees_techniques.dm_projet_desc as dm_projet_desc_donnees_techniques,
    donnees_techniques.ope_proj_desc as ope_proj_desc_donnees_techniques,
    TRIM(CONCAT(
        donnees_techniques.co_projet_desc, '' '',
        donnees_techniques.am_projet_desc, '' '',
        donnees_techniques.dm_projet_desc, '' '',
        donnees_techniques.ope_proj_desc
        )) as projet_desc_donnees_techniques,
    donnees_techniques.am_lot_max_nb as am_lot_max_nb_donnees_techniques,
    donnees_techniques.am_lot_max_shon as am_lot_max_shon_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_avt_shon21 IS NOT NULL
        OR su2_avt_shon22 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_cstr_shon21 IS NOT NULL
        OR su2_cstr_shon22 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_chge_shon21 IS NOT NULL
        OR su2_chge_shon22 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_demo_shon21 IS NOT NULL
        OR su2_demo_shon22 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        OR su2_sup_shon21 IS NOT NULL
        OR su2_sup_shon22 IS NOT NULL
        THEN donnees_techniques.su2_cstr_shon_tot
        ELSE donnees_techniques.su_cstr_shon_tot
    END as su_cstr_shon_tot_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_avt_shon21 IS NOT NULL
        OR su2_avt_shon22 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_cstr_shon21 IS NOT NULL
        OR su2_cstr_shon22 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_chge_shon21 IS NOT NULL
        OR su2_chge_shon22 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_demo_shon21 IS NOT NULL
        OR su2_demo_shon22 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        OR su2_sup_shon21 IS NOT NULL
        OR su2_sup_shon22 IS NOT NULL
        THEN donnees_techniques.su2_demo_shon_tot
        ELSE donnees_techniques.su_demo_shon_tot
    END as su_demo_shon_tot_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_avt_shon21 IS NOT NULL
        OR su2_avt_shon22 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_cstr_shon21 IS NOT NULL
        OR su2_cstr_shon22 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_chge_shon21 IS NOT NULL
        OR su2_chge_shon22 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_demo_shon21 IS NOT NULL
        OR su2_demo_shon22 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        OR su2_sup_shon21 IS NOT NULL
        OR su2_sup_shon22 IS NOT NULL
        THEN
            REGEXP_REPLACE(CONCAT(
                CASE WHEN donnees_techniques.su2_cstr_shon1 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Exploitation agricole - '', donnees_techniques.su2_cstr_shon1, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon2 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Exploitation forestière - '', donnees_techniques.su2_cstr_shon2, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon3 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Logement - '', donnees_techniques.su2_cstr_shon3, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon4 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Hébergement - '', donnees_techniques.su2_cstr_shon4, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon5 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Artisanat et commerce de détail - '', donnees_techniques.su2_cstr_shon5, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon6 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Restauration - '', donnees_techniques.su2_cstr_shon6, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon7 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Commerce de gros - '', donnees_techniques.su2_cstr_shon7, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon8 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Activités de services où s''''effectue l''''accueil d''''une clientèle - '', donnees_techniques.su2_cstr_shon8, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon9 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Hébergement hôtelier et touristique - '', donnees_techniques.su2_cstr_shon9, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon10 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Cinéma - '', donnees_techniques.su2_cstr_shon10, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon21 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Hôtels - '', donnees_techniques.su2_cstr_shon21, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon22 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Autres hébergements touristiques - '', donnees_techniques.su2_cstr_shon22, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon11 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Locaux et bureaux accueillant du public des administrations publiques et assimilés - '', donnees_techniques.su2_cstr_shon11, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon12 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Locaux techniques et industriels des administrations publiques et assimilés - '', donnees_techniques.su2_cstr_shon12, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon13 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Établissements d''''enseignement, de santé et d''''action sociale - '', donnees_techniques.su2_cstr_shon13, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon14 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Salles d''''art et de spectacles - '', donnees_techniques.su2_cstr_shon14, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon15 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Équipements sportifs - '', donnees_techniques.su2_cstr_shon15, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon16 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Autres équipements recevant du public - '', donnees_techniques.su2_cstr_shon16, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon17 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Industrie - '', donnees_techniques.su2_cstr_shon17, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon18 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Entrepôt - '', donnees_techniques.su2_cstr_shon18, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon19 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Bureau - '', donnees_techniques.su2_cstr_shon19, '' m² / '')
                END,
                CASE WHEN donnees_techniques.su2_cstr_shon20 IS NULL
                    THEN ''''
                    ELSE CONCAT (''Centre de congrès et d''''exposition - '', donnees_techniques.su2_cstr_shon20, '' m²'')
                END
            ), '' / $'', '''')
        ELSE
            REGEXP_REPLACE(CONCAT(
                CASE
                    WHEN donnees_techniques.su_cstr_shon1 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Habitation - '', donnees_techniques.su_cstr_shon1, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon2 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Hébergement hôtelier - '', donnees_techniques.su_cstr_shon2, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon3 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Bureaux - '', donnees_techniques.su_cstr_shon3, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon4 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Commerce - '', donnees_techniques.su_cstr_shon4, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon5 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Artisanat - '', donnees_techniques.su_cstr_shon5, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon6 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Industrie - '', donnees_techniques.su_cstr_shon6, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon7 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Exploitation agricole ou forestière - '', donnees_techniques.su_cstr_shon7, '' m² / '')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon8 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Entrepôt - '', donnees_techniques.su_cstr_shon8, '' m² / '')
                END, 
                CASE
                    WHEN donnees_techniques.su_cstr_shon9 IS NULL
                    THEN ''''
                    ELSE CONCAT(''Service public ou d''''intérêt collectif - '', donnees_techniques.su_cstr_shon9, '' m²'')
                END
            ), '' / $'', '''')
    END as tab_surface_donnees_techniques,
    donnees_techniques.co_tot_log_nb as co_tot_log_nb_donnees_techniques,
    donnees_techniques.co_statio_place_nb as co_statio_place_nb_donnees_techniques,
    -- Si une valeur est saisie dans la deuxième version du tableau des surfaces
    -- alors on récupère seulement ses valeurs
    CASE WHEN su2_avt_shon1 IS NOT NULL
        OR su2_avt_shon2 IS NOT NULL
        OR su2_avt_shon3 IS NOT NULL
        OR su2_avt_shon4 IS NOT NULL
        OR su2_avt_shon5 IS NOT NULL
        OR su2_avt_shon6 IS NOT NULL
        OR su2_avt_shon7 IS NOT NULL
        OR su2_avt_shon8 IS NOT NULL
        OR su2_avt_shon9 IS NOT NULL
        OR su2_avt_shon10 IS NOT NULL
        OR su2_avt_shon11 IS NOT NULL
        OR su2_avt_shon12 IS NOT NULL
        OR su2_avt_shon13 IS NOT NULL
        OR su2_avt_shon14 IS NOT NULL
        OR su2_avt_shon15 IS NOT NULL
        OR su2_avt_shon16 IS NOT NULL
        OR su2_avt_shon17 IS NOT NULL
        OR su2_avt_shon18 IS NOT NULL
        OR su2_avt_shon19 IS NOT NULL
        OR su2_avt_shon20 IS NOT NULL
        OR su2_avt_shon21 IS NOT NULL
        OR su2_avt_shon22 IS NOT NULL
        OR su2_cstr_shon1 IS NOT NULL
        OR su2_cstr_shon2 IS NOT NULL
        OR su2_cstr_shon3 IS NOT NULL
        OR su2_cstr_shon4 IS NOT NULL
        OR su2_cstr_shon5 IS NOT NULL
        OR su2_cstr_shon6 IS NOT NULL
        OR su2_cstr_shon7 IS NOT NULL
        OR su2_cstr_shon8 IS NOT NULL
        OR su2_cstr_shon9 IS NOT NULL
        OR su2_cstr_shon10 IS NOT NULL
        OR su2_cstr_shon11 IS NOT NULL
        OR su2_cstr_shon12 IS NOT NULL
        OR su2_cstr_shon13 IS NOT NULL
        OR su2_cstr_shon14 IS NOT NULL
        OR su2_cstr_shon15 IS NOT NULL
        OR su2_cstr_shon16 IS NOT NULL
        OR su2_cstr_shon17 IS NOT NULL
        OR su2_cstr_shon18 IS NOT NULL
        OR su2_cstr_shon19 IS NOT NULL
        OR su2_cstr_shon20 IS NOT NULL
        OR su2_cstr_shon21 IS NOT NULL
        OR su2_cstr_shon22 IS NOT NULL
        OR su2_chge_shon1 IS NOT NULL
        OR su2_chge_shon2 IS NOT NULL
        OR su2_chge_shon3 IS NOT NULL
        OR su2_chge_shon4 IS NOT NULL
        OR su2_chge_shon5 IS NOT NULL
        OR su2_chge_shon6 IS NOT NULL
        OR su2_chge_shon7 IS NOT NULL
        OR su2_chge_shon8 IS NOT NULL
        OR su2_chge_shon9 IS NOT NULL
        OR su2_chge_shon10 IS NOT NULL
        OR su2_chge_shon11 IS NOT NULL
        OR su2_chge_shon12 IS NOT NULL
        OR su2_chge_shon13 IS NOT NULL
        OR su2_chge_shon14 IS NOT NULL
        OR su2_chge_shon15 IS NOT NULL
        OR su2_chge_shon16 IS NOT NULL
        OR su2_chge_shon17 IS NOT NULL
        OR su2_chge_shon18 IS NOT NULL
        OR su2_chge_shon19 IS NOT NULL
        OR su2_chge_shon20 IS NOT NULL
        OR su2_chge_shon21 IS NOT NULL
        OR su2_chge_shon22 IS NOT NULL
        OR su2_demo_shon1 IS NOT NULL
        OR su2_demo_shon2 IS NOT NULL
        OR su2_demo_shon3 IS NOT NULL
        OR su2_demo_shon4 IS NOT NULL
        OR su2_demo_shon5 IS NOT NULL
        OR su2_demo_shon6 IS NOT NULL
        OR su2_demo_shon7 IS NOT NULL
        OR su2_demo_shon8 IS NOT NULL
        OR su2_demo_shon9 IS NOT NULL
        OR su2_demo_shon10 IS NOT NULL
        OR su2_demo_shon11 IS NOT NULL
        OR su2_demo_shon12 IS NOT NULL
        OR su2_demo_shon13 IS NOT NULL
        OR su2_demo_shon14 IS NOT NULL
        OR su2_demo_shon15 IS NOT NULL
        OR su2_demo_shon16 IS NOT NULL
        OR su2_demo_shon17 IS NOT NULL
        OR su2_demo_shon18 IS NOT NULL
        OR su2_demo_shon19 IS NOT NULL
        OR su2_demo_shon20 IS NOT NULL
        OR su2_demo_shon21 IS NOT NULL
        OR su2_demo_shon22 IS NOT NULL
        OR su2_sup_shon1 IS NOT NULL
        OR su2_sup_shon2 IS NOT NULL
        OR su2_sup_shon3 IS NOT NULL
        OR su2_sup_shon4 IS NOT NULL
        OR su2_sup_shon5 IS NOT NULL
        OR su2_sup_shon6 IS NOT NULL
        OR su2_sup_shon7 IS NOT NULL
        OR su2_sup_shon8 IS NOT NULL
        OR su2_sup_shon9 IS NOT NULL
        OR su2_sup_shon10 IS NOT NULL
        OR su2_sup_shon11 IS NOT NULL
        OR su2_sup_shon12 IS NOT NULL
        OR su2_sup_shon13 IS NOT NULL
        OR su2_sup_shon14 IS NOT NULL
        OR su2_sup_shon15 IS NOT NULL
        OR su2_sup_shon16 IS NOT NULL
        OR su2_sup_shon17 IS NOT NULL
        OR su2_sup_shon18 IS NOT NULL
        OR su2_sup_shon19 IS NOT NULL
        OR su2_sup_shon20 IS NOT NULL
        OR su2_sup_shon21 IS NOT NULL
        OR su2_sup_shon22 IS NOT NULL
        THEN donnees_techniques.su2_tot_shon_tot
        ELSE donnees_techniques.su_tot_shon_tot
    END as su_tot_shon_tot_donnees_techniques,

    -- Données techniques pour les AT
    CONCAT_WS('', '',
        CASE WHEN donnees_techniques.erp_cstr_neuve IS TRUE THEN ''construction neuve'' END,
        CASE WHEN donnees_techniques.erp_trvx_acc IS TRUE THEN ''travaux de mise en conformité totale aux règles d’accessibilité'' END,
        CASE WHEN donnees_techniques.erp_extension IS TRUE THEN ''extension'' END,
        CASE WHEN donnees_techniques.erp_rehab IS TRUE THEN ''réhabilitation'' END,
        CASE WHEN donnees_techniques.erp_trvx_am IS TRUE THEN ''travaux d’aménagement (remplacement de revêtements, rénovation électrique, création d’une rampe, par exemple)'' END,
        CASE WHEN donnees_techniques.erp_vol_nouv_exist IS TRUE THEN ''création de volumes nouveaux dans des volumes existants (modification du cloisonnement, par exemple)'' END
    ) as at_type_travaux,
    donnees_techniques.erp_public_eff_tot as at_effectif_public_total,
    CONCAT_WS('' - '', erp_categorie.libelle, erp_categorie.description) as at_categorie_etablissement,
    CONCAT_WS('' - '', erp_type.libelle, erp_type.description) as at_type_etablissement,

    -- Données techniques pour une DIA
    COALESCE (donnees_techniques.dia_mod_cess_prix_vente,'''') AS dia_mod_cess_prix_vente,
    donnees_techniques.dia_mod_cess_prix_vente_num AS dia_mod_cess_prix_vente_num,
    CASE WHEN donnees_techniques.dia_mod_cess_prix_vente_mob_num IS NOT NULL
        THEN donnees_techniques.dia_mod_cess_prix_vente_mob_num::text
        ELSE donnees_techniques.dia_mod_cess_prix_vente_mob
    END AS dia_mod_cess_prix_vente_mob,
    CASE WHEN donnees_techniques.dia_mod_cess_prix_vente_cheptel_num IS NOT NULL
        THEN donnees_techniques.dia_mod_cess_prix_vente_cheptel_num::text
        ELSE donnees_techniques.dia_mod_cess_prix_vente_cheptel
    END AS dia_mod_cess_prix_vente_cheptel,
    CASE WHEN donnees_techniques.dia_mod_cess_prix_vente_recol_num IS NOT NULL
        THEN donnees_techniques.dia_mod_cess_prix_vente_recol_num::text
        ELSE donnees_techniques.dia_mod_cess_prix_vente_recol
    END AS dia_mod_cess_prix_vente_recol,
    CASE WHEN donnees_techniques.dia_mod_cess_prix_vente_autre_num IS NOT NULL
        THEN donnees_techniques.dia_mod_cess_prix_vente_autre_num::text
        ELSE donnees_techniques.dia_mod_cess_prix_vente_autre
    END AS dia_mod_cess_prix_vente_autre,
    donnees_techniques.dia_mod_cess_commi_mnt AS dia_mod_cess_commi_mnt,
    COALESCE (donnees_techniques.dia_acquereur_nom_prenom,'''') AS dia_acquereur_nom_prenom,
    &DB_PREFIXEadresse(
        CONCAT_WS('' '', donnees_techniques.dia_acquereur_adr_num_voie::text, donnees_techniques.dia_acquereur_adr_ext::text),
        CONCAT_WS('' '', donnees_techniques.dia_acquereur_adr_type_voie::text, donnees_techniques.dia_acquereur_adr_nom_voie::text),
        ''''::text,
        donnees_techniques.dia_acquereur_adr_lieu_dit_bp::text,
        ''''::text,
        donnees_techniques.dia_acquereur_adr_cp::text,
        donnees_techniques.dia_acquereur_adr_localite::text,
        ''''::text
    ) as dia_acquereur_adresse_sdl,
    &DB_PREFIXEadresse(
        CONCAT_WS('' '', donnees_techniques.dia_acquereur_adr_num_voie::text, donnees_techniques.dia_acquereur_adr_ext::text),
        CONCAT_WS('' '', donnees_techniques.dia_acquereur_adr_type_voie::text, donnees_techniques.dia_acquereur_adr_nom_voie::text),
        ''''::text,
        donnees_techniques.dia_acquereur_adr_lieu_dit_bp::text,
        ''''::text,
        donnees_techniques.dia_acquereur_adr_cp::text,
        donnees_techniques.dia_acquereur_adr_localite::text,
        ''''::text,
        '' ''::text
    ) as dia_acquereur_adresse,
    donnees_techniques.dia_esti_prix_france_dom AS dia_esti_prix_france_dom,
    donnees_techniques.dia_prop_collectivite AS dia_prop_collectivite,
    donnees_techniques.dia_entree_jouissance_type AS dia_entree_jouissance_type,
    to_char(donnees_techniques.dia_entree_jouissance_date, ''DD/MM/YYYY'') AS dia_entree_jouissance_date,
    to_char(donnees_techniques.dia_entree_jouissance_date_effet, ''DD/MM/YYYY'') AS dia_entree_jouissance_date_effet,
    donnees_techniques.dia_entree_jouissance_com AS dia_entree_jouissance_com,
    to_char(donnees_techniques.dia_remise_bien_date_effet, ''DD/MM/YYYY'') AS dia_remise_bien_date_effet,
    donnees_techniques.dia_remise_bien_com AS dia_remise_bien_com,

    -- Données techniques pour le contentieux
    objet_recours.libelle as ctx_objet_recours_libelle,
    donnees_techniques.ctx_reference_sagace as ctx_reference_sagace,
    donnees_techniques.ctx_nature_travaux_infra_om_html as ctx_nature_travaux_infra_om_html,
    donnees_techniques.ctx_synthese_nti as ctx_synthese_nti,
    donnees_techniques.ctx_article_non_resp_om_html as ctx_article_non_resp_om_html,
    donnees_techniques.ctx_synthese_anr as ctx_synthese_anr,
    donnees_techniques.ctx_reference_parquet as ctx_reference_parquet,
    donnees_techniques.ctx_element_taxation as ctx_element_taxation,
    CASE donnees_techniques.ctx_infraction WHEN ''t'' THEN ''Oui'' else ''Non'' end as ctx_infraction,
    CASE donnees_techniques.ctx_regularisable WHEN ''t'' THEN ''Oui'' else ''Non'' end as ctx_regularisable,
    donnees_techniques.ctx_reference_courrier as ctx_reference_courrier,
    to_char(donnees_techniques.ctx_date_audience, ''DD/MM/YYYY'') as date_audience_ctx,
    to_char(donnees_techniques.ctx_date_ajournement, ''DD/MM/YYYY'') as date_ajournement_ctx,

    -- Données techniques pour les DPC
    donnees_techniques.dpc_type as dpc_type,
    donnees_techniques.dpc_moda_cess_prix as dpc_moda_cess_prix,

    --Bordereau d''envoi au maire
    CASE
        WHEN evenement.type = ''arrete''
        THEN CONCAT(''transmission d''''une proposition de décision sur '', evenement.libelle)
        ELSE CONCAT(''transmission d''''un courrier d''''instruction sur '', evenement.libelle)
    END as objet_bordereau_envoi_maire
    
FROM
    &DB_PREFIXEinstruction
LEFT JOIN
    &DB_PREFIXEsignataire_arrete
    ON instruction.signataire_arrete = signataire_arrete.signataire_arrete
LEFT JOIN
&DB_PREFIXEsignataire_habilitation
ON signataire_arrete.signataire_habilitation = signataire_habilitation.signataire_habilitation

LEFT JOIN
    &DB_PREFIXEcivilite as signataire_civilite
    ON signataire_arrete.civilite = signataire_civilite.civilite
LEFT JOIN
    &DB_PREFIXEdossier
    ON
        instruction.dossier=dossier.dossier
LEFT JOIN
 &DB_PREFIXEconsultation_entrante
 ON consultation_entrante.dossier=dossier.dossier
LEFT JOIN
    &DB_PREFIXEom_lettretype
    ON instruction.lettretype = om_lettretype.id
    AND om_lettretype.actif IS TRUE
    AND (om_lettretype.om_collectivite = dossier.om_collectivite OR om_lettretype.om_collectivite = (SELECT om_collectivite FROM &DB_PREFIXEom_collectivite WHERE niveau::integer = 2))
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''petitionnaire''
    ) as petitionnaire_principal
    ON petitionnaire_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as petitionnaire_principal_civilite
    ON
        petitionnaire_principal.particulier_civilite = petitionnaire_principal_civilite.civilite OR petitionnaire_principal.personne_morale_civilite = petitionnaire_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''contrevenant''
    ) as contrevenant_principal
    ON contrevenant_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as contrevenant_principal_civilite
    ON
        contrevenant_principal.particulier_civilite = contrevenant_principal_civilite.civilite OR contrevenant_principal.personne_morale_civilite = contrevenant_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''requerant''
    ) as requerant_principal
    ON requerant_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as requerant_principal_civilite
    ON
        requerant_principal.particulier_civilite = requerant_principal_civilite.civilite OR requerant_principal.personne_morale_civilite = requerant_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''avocat''
    ) as avocat_principal
    ON avocat_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as avocat_principal_civilite
    ON
        avocat_principal.particulier_civilite = avocat_principal_civilite.civilite OR avocat_principal.personne_morale_civilite = avocat_principal_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''plaignant''
    ) as plaignant_principal
    ON plaignant_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as plaignant_principal_civilite
    ON
        plaignant_principal.particulier_civilite = plaignant_principal_civilite.civilite OR plaignant_principal.personne_morale_civilite = plaignant_principal_civilite.civilite
LEFT JOIN
    &DB_PREFIXElien_dossier_autorisation_demandeur
    ON
        dossier.dossier_autorisation = lien_dossier_autorisation_demandeur.dossier_autorisation AND lien_dossier_autorisation_demandeur.petitionnaire_principal IS TRUE
LEFT JOIN
    &DB_PREFIXEdemandeur as petitionnaire_principal_initial
    ON
        lien_dossier_autorisation_demandeur.demandeur = petitionnaire_principal_initial.demandeur
LEFT JOIN
    &DB_PREFIXEcivilite as petitionnaire_principal_initial_civilite
    ON
        petitionnaire_principal_initial.particulier_civilite = petitionnaire_principal_initial_civilite.civilite OR petitionnaire_principal_initial.personne_morale_civilite = petitionnaire_principal_initial_civilite.civilite
LEFT JOIN
    (
    &DB_PREFIXElien_dossier_demandeur AS lien_dossier_delegataire
        JOIN &DB_PREFIXEdemandeur as delegataire
        ON
            lien_dossier_delegataire.demandeur = delegataire.demandeur AND delegataire.type_demandeur = ''delegataire''
    )
    ON
        instruction.dossier = lien_dossier_delegataire.dossier AND lien_dossier_delegataire.petitionnaire_principal IS FALSE
LEFT JOIN
    &DB_PREFIXEcivilite as delegataire_civilite
    ON
        delegataire.particulier_civilite = delegataire_civilite.civilite OR delegataire.personne_morale_civilite = delegataire_civilite.civilite
LEFT JOIN (
        SELECT *
        FROM &DB_PREFIXElien_dossier_demandeur
        INNER JOIN &DB_PREFIXEdemandeur
            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
        WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
        AND demandeur.type_demandeur = ''bailleur''
    ) as bailleur_principal
    ON bailleur_principal.dossier = dossier.dossier
LEFT JOIN
    &DB_PREFIXEcivilite as bailleur_principal_civilite
    ON
        bailleur_principal.particulier_civilite = bailleur_principal_civilite.civilite OR bailleur_principal.personne_morale_civilite = bailleur_principal_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS petitionnaire_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''petitionnaire''
    
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

WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_petitionnaire_autre
ON instruction.dossier = sub_petitionnaire_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_1
    ON
        petitionnaire_1.demandeur = petitionnaire_autre[1] AND petitionnaire_1.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_1_civilite
    ON
        petitionnaire_1.particulier_civilite = petitionnaire_1_civilite.civilite OR petitionnaire_1.personne_morale_civilite = petitionnaire_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_2
    ON
        petitionnaire_2.demandeur = petitionnaire_autre[2] AND petitionnaire_2.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_2_civilite
    ON
        petitionnaire_2.particulier_civilite = petitionnaire_2_civilite.civilite OR petitionnaire_2.personne_morale_civilite = petitionnaire_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_3
    ON
        petitionnaire_3.demandeur = petitionnaire_autre[3] AND petitionnaire_3.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_3_civilite
    ON
        petitionnaire_3.particulier_civilite = petitionnaire_3_civilite.civilite OR petitionnaire_3.personne_morale_civilite = petitionnaire_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_4
    ON
        petitionnaire_4.demandeur = petitionnaire_autre[4] AND petitionnaire_4.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_4_civilite
    ON
        petitionnaire_4.particulier_civilite = petitionnaire_4_civilite.civilite OR petitionnaire_4.personne_morale_civilite = petitionnaire_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as petitionnaire_5
    ON
        petitionnaire_5.demandeur = petitionnaire_autre[5] AND petitionnaire_5.type_demandeur = ''petitionnaire''
    LEFT JOIN
        &DB_PREFIXEcivilite as petitionnaire_5_civilite
    ON
        petitionnaire_5.particulier_civilite = petitionnaire_5_civilite.civilite OR petitionnaire_5.personne_morale_civilite = petitionnaire_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS contrevenant_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''contrevenant''
    
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

WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_contrevenant_autre
ON instruction.dossier = sub_contrevenant_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_1
    ON
        contrevenant_1.demandeur = contrevenant_autre[1] AND contrevenant_1.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_1_civilite
    ON
        contrevenant_1.particulier_civilite = contrevenant_1_civilite.civilite OR contrevenant_1.personne_morale_civilite = contrevenant_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_2
    ON
        contrevenant_2.demandeur = contrevenant_autre[2] AND contrevenant_2.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_2_civilite
    ON
        contrevenant_2.particulier_civilite = contrevenant_2_civilite.civilite OR contrevenant_2.personne_morale_civilite = contrevenant_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_3
    ON
        contrevenant_3.demandeur = contrevenant_autre[3] AND contrevenant_3.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_3_civilite
    ON
        contrevenant_3.particulier_civilite = contrevenant_3_civilite.civilite OR contrevenant_3.personne_morale_civilite = contrevenant_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_4
    ON
        contrevenant_4.demandeur = contrevenant_autre[4] AND contrevenant_4.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_4_civilite
    ON
        contrevenant_4.particulier_civilite = contrevenant_4_civilite.civilite OR contrevenant_4.personne_morale_civilite = contrevenant_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as contrevenant_5
    ON
        contrevenant_5.demandeur = contrevenant_autre[5] AND contrevenant_5.type_demandeur = ''contrevenant''
    LEFT JOIN
        &DB_PREFIXEcivilite as contrevenant_5_civilite
    ON
        contrevenant_5.particulier_civilite = contrevenant_5_civilite.civilite OR contrevenant_5.personne_morale_civilite = contrevenant_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS requerant_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''requerant''
    
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

WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_requerant_autre
ON instruction.dossier = sub_requerant_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_1
    ON
        requerant_1.demandeur = requerant_autre[1] AND requerant_1.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_1_civilite
    ON
        requerant_1.particulier_civilite = requerant_1_civilite.civilite OR requerant_1.personne_morale_civilite = requerant_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_2
    ON
        requerant_2.demandeur = requerant_autre[2] AND requerant_2.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_2_civilite
    ON
        requerant_2.particulier_civilite = requerant_2_civilite.civilite OR requerant_2.personne_morale_civilite = requerant_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_3
    ON
        requerant_3.demandeur = requerant_autre[3] AND requerant_3.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_3_civilite
    ON
        requerant_3.particulier_civilite = requerant_3_civilite.civilite OR requerant_3.personne_morale_civilite = requerant_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_4
    ON
        requerant_4.demandeur = requerant_autre[4] AND requerant_4.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_4_civilite
    ON
        requerant_4.particulier_civilite = requerant_4_civilite.civilite OR requerant_4.personne_morale_civilite = requerant_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as requerant_5
    ON
        requerant_5.demandeur = requerant_autre[5] AND requerant_5.type_demandeur = ''requerant''
    LEFT JOIN
        &DB_PREFIXEcivilite as requerant_5_civilite
    ON
        requerant_5.particulier_civilite = requerant_5_civilite.civilite OR requerant_5.personne_morale_civilite = requerant_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS avocat_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''avocat''
    
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

WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_avocat_autre
ON instruction.dossier = sub_avocat_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_1
    ON
        avocat_1.demandeur = avocat_autre[1] AND avocat_1.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_1_civilite
    ON
        avocat_1.particulier_civilite = avocat_1_civilite.civilite OR avocat_1.personne_morale_civilite = avocat_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_2
    ON
        avocat_2.demandeur = avocat_autre[2] AND avocat_2.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_2_civilite
    ON
        avocat_2.particulier_civilite = avocat_2_civilite.civilite OR avocat_2.personne_morale_civilite = avocat_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_3
    ON
        avocat_3.demandeur = avocat_autre[3] AND avocat_3.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_3_civilite
    ON
        avocat_3.particulier_civilite = avocat_3_civilite.civilite OR avocat_3.personne_morale_civilite = avocat_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_4
    ON
        avocat_4.demandeur = avocat_autre[4] AND avocat_4.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_4_civilite
    ON
        avocat_4.particulier_civilite = avocat_4_civilite.civilite OR avocat_4.personne_morale_civilite = avocat_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as avocat_5
    ON
        avocat_5.demandeur = avocat_autre[5] AND avocat_5.type_demandeur = ''avocat''
    LEFT JOIN
        &DB_PREFIXEcivilite as avocat_5_civilite
    ON
        avocat_5.particulier_civilite = avocat_5_civilite.civilite OR avocat_5.personne_morale_civilite = avocat_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS plaignant_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''plaignant''
    
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

WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_plaignant_autre
ON instruction.dossier = sub_plaignant_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as plaignant_1
    ON
        plaignant_1.demandeur = plaignant_autre[1] AND plaignant_1.type_demandeur = ''plaignant''
    LEFT JOIN
        &DB_PREFIXEcivilite as plaignant_1_civilite
    ON
        plaignant_1.particulier_civilite = plaignant_1_civilite.civilite OR plaignant_1.personne_morale_civilite = plaignant_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as plaignant_2
    ON
        plaignant_2.demandeur = plaignant_autre[2] AND plaignant_2.type_demandeur = ''plaignant''
    LEFT JOIN
        &DB_PREFIXEcivilite as plaignant_2_civilite
    ON
        plaignant_2.particulier_civilite = plaignant_2_civilite.civilite OR plaignant_2.personne_morale_civilite = plaignant_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as plaignant_3
    ON
        plaignant_3.demandeur = plaignant_autre[3] AND plaignant_3.type_demandeur = ''plaignant''
    LEFT JOIN
        &DB_PREFIXEcivilite as plaignant_3_civilite
    ON
        plaignant_3.particulier_civilite = plaignant_3_civilite.civilite OR plaignant_3.personne_morale_civilite = plaignant_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as plaignant_4
    ON
        plaignant_4.demandeur = plaignant_autre[4] AND plaignant_4.type_demandeur = ''plaignant''
    LEFT JOIN
        &DB_PREFIXEcivilite as plaignant_4_civilite
    ON
        plaignant_4.particulier_civilite = plaignant_4_civilite.civilite OR plaignant_4.personne_morale_civilite = plaignant_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as plaignant_5
    ON
        plaignant_5.demandeur = plaignant_autre[5] AND plaignant_5.type_demandeur = ''plaignant''
    LEFT JOIN
        &DB_PREFIXEcivilite as plaignant_5_civilite
    ON
        plaignant_5.particulier_civilite = plaignant_5_civilite.civilite OR plaignant_5.personne_morale_civilite = plaignant_5_civilite.civilite
LEFT JOIN (
    SELECT lien_dossier_demandeur.dossier, array_agg(lien_dossier_demandeur.demandeur ORDER BY lien_dossier_demandeur.demandeur) AS bailleur_autre
    FROM &DB_PREFIXElien_dossier_demandeur
    LEFT JOIN &DB_PREFIXEdossier
        ON lien_dossier_demandeur.dossier=dossier.dossier
        AND lien_dossier_demandeur.petitionnaire_principal IS FALSE
    LEFT JOIN &DB_PREFIXEinstruction
        ON instruction.dossier = dossier.dossier
    RIGHT JOIN &DB_PREFIXEdemandeur
        ON lien_dossier_demandeur.demandeur=demandeur.demandeur
        AND demandeur.type_demandeur = ''bailleur''
    
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

WHERE instruction.instruction = &idx
    GROUP BY lien_dossier_demandeur.dossier
) as sub_bailleur_autre
ON instruction.dossier = sub_bailleur_autre.dossier
LEFT JOIN
        &DB_PREFIXEdemandeur as bailleur_1
    ON
        bailleur_1.demandeur = bailleur_autre[1] AND bailleur_1.type_demandeur = ''bailleur''
    LEFT JOIN
        &DB_PREFIXEcivilite as bailleur_1_civilite
    ON
        bailleur_1.particulier_civilite = bailleur_1_civilite.civilite OR bailleur_1.personne_morale_civilite = bailleur_1_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as bailleur_2
    ON
        bailleur_2.demandeur = bailleur_autre[2] AND bailleur_2.type_demandeur = ''bailleur''
    LEFT JOIN
        &DB_PREFIXEcivilite as bailleur_2_civilite
    ON
        bailleur_2.particulier_civilite = bailleur_2_civilite.civilite OR bailleur_2.personne_morale_civilite = bailleur_2_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as bailleur_3
    ON
        bailleur_3.demandeur = bailleur_autre[3] AND bailleur_3.type_demandeur = ''bailleur''
    LEFT JOIN
        &DB_PREFIXEcivilite as bailleur_3_civilite
    ON
        bailleur_3.particulier_civilite = bailleur_3_civilite.civilite OR bailleur_3.personne_morale_civilite = bailleur_3_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as bailleur_4
    ON
        bailleur_4.demandeur = bailleur_autre[4] AND bailleur_4.type_demandeur = ''bailleur''
    LEFT JOIN
        &DB_PREFIXEcivilite as bailleur_4_civilite
    ON
        bailleur_4.particulier_civilite = bailleur_4_civilite.civilite OR bailleur_4.personne_morale_civilite = bailleur_4_civilite.civilite
    LEFT JOIN
        &DB_PREFIXEdemandeur as bailleur_5
    ON
        bailleur_5.demandeur = bailleur_autre[5] AND bailleur_5.type_demandeur = ''bailleur''
    LEFT JOIN
        &DB_PREFIXEcivilite as bailleur_5_civilite
    ON
        bailleur_5.particulier_civilite = bailleur_5_civilite.civilite OR bailleur_5.personne_morale_civilite = bailleur_5_civilite.civilite
LEFT JOIN
    &DB_PREFIXEdossier_instruction_type
    ON
        dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
LEFT JOIN
    &DB_PREFIXEdossier_autorisation
    ON
        dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
LEFT JOIN
    &DB_PREFIXEdossier_autorisation_type_detaille
    ON
        dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
LEFT JOIN
    &DB_PREFIXEdossier_autorisation_type
    ON
        dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
LEFT JOIN
    &DB_PREFIXEinstructeur
    ON
        dossier.instructeur = instructeur.instructeur
LEFT JOIN
    &DB_PREFIXEinstructeur as instructeur_2
    ON
        dossier.instructeur_2 = instructeur_2.instructeur
LEFT JOIN
    &DB_PREFIXEom_utilisateur
    ON
        om_utilisateur.om_utilisateur = instructeur.om_utilisateur
LEFT JOIN
    &DB_PREFIXEom_utilisateur as om_utilisateur_2
    ON
        om_utilisateur_2.om_utilisateur = instructeur_2.om_utilisateur
LEFT JOIN
    &DB_PREFIXEdivision
    ON
        instructeur.division = division.division
LEFT JOIN
    &DB_PREFIXEdivision as division_2
    ON
        instructeur_2.division = division_2.division
LEFT JOIN 
    &DB_PREFIXEdirection
    ON division.direction = direction.direction
LEFT JOIN
    &DB_PREFIXEarrondissement
    ON
        dossier.terrain_adresse_code_postal = arrondissement.code_postal
LEFT JOIN
    &DB_PREFIXEavis_decision
    ON
        dossier.avis_decision = avis_decision.avis_decision
LEFT JOIN
    &DB_PREFIXEetat
    ON
        dossier.etat = etat.etat
LEFT JOIN
    &DB_PREFIXEdonnees_techniques
    ON
    dossier.dossier = donnees_techniques.dossier_instruction
LEFT JOIN 
    &DB_PREFIXEevenement
    ON
        instruction.evenement = evenement.evenement
LEFT JOIN 
    &DB_PREFIXEquartier
    ON
        dossier.quartier = quartier.quartier
LEFT JOIN
    &DB_PREFIXEtaxe_amenagement
    ON
        dossier.om_collectivite = taxe_amenagement.om_collectivite
LEFT JOIN
    &DB_PREFIXEerp_categorie
    ON
        donnees_techniques.erp_class_cat = erp_categorie.erp_categorie
LEFT JOIN
    &DB_PREFIXEerp_type
    ON
        donnees_techniques.erp_class_type = erp_type.erp_type
LEFT JOIN
    &DB_PREFIXEobjet_recours
    ON
        donnees_techniques.ctx_objet_recours = objet_recours.objet_recours

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

WHERE instruction.instruction = &idx
',
merge_fields = '--Données générales de l''événement d''instruction
[complement1_instruction]
[complement2_instruction]
[complement3_instruction]
[complement4_instruction]
[code_barres_instruction]
[date_evenement_instruction]
[libelle_om_lettretype]
[archive_delai_instruction]
[agrement_signataire]
[visa_signataire]
[visa_signataire_2]
[visa_signataire_3]
[visa_signataire_4]
[service_consultant_libelle]

--Données générales du dossier d''instruction
[libelle_dossier]    [code_barres_dossier]    [delai_dossier]    [terrain_references_cadastrales_dossier]
[terrain_superficie_dossier]
[libelle_quartier]
[libelle_da]
[code_datd]    [libelle_datd]
[code_dat]    [libelle_dat]
[code_dit]    [libelle_dit]
[libelle_avis_decision]
[mention_depot_electronique_recepisse]

-- Données contentieux du dossier d''instruction
[autorisation_contestee]
[date_cloture_instruction_dossier]
[date_premiere_visite_dossier]
[date_derniere_visite_dossier]
[date_contradictoire_dossier]
[date_retour_contradictoire_dossier]
[date_ait_dossier]
[date_transmission_parquet_dossier]

--Données générales du paramétrage de l''événement
[libelle_evenement]
[etat_evenement]
[delai_evenement]
[accord_tacite_evenement]
[delai_notification_evenement]
[avis_decision_evenement]
[autorite_competente_evenement]
[cle_acces_citoyen]

--Coordonnées de l''instructeur
[nom_instructeur]
[telephone_instructeur]
[division_instructeur]
[email_instructeur]

-- Coordonnées de l''instructeur 2
[nom_instructeur_2]
[telephone_instructeur_2]
[division_instructeur_2]
[email_instructeur_2]

--Adresse du terrain du dossier d''instruction 
[terrain_adresse_voie_numero_dossier]
[adresse_terrain_sdl]
[adresse_terrain]    [terrain_adresse_voie_dossier]
[terrain_adresse_lieu_dit_dossier]    [terrain_adresse_bp_dossier]
[terrain_adresse_code_postal_dossier]    [terrain_adresse_localite_dossier]    [terrain_adresse_cedex_dossier]

[libelle_arrondissement]

--Taxe d''aménagement du dossier d''instruction
[tax_taux_secteur](à utiliser si l''option de simulation des taxes est activée et que le taxe du secteur est définit sur le dossier)
[tax_taux_secteur_1](jusqu''à 20)  [tax_numero_secteur]    [tax_montant_part_communale]    [tax_montant_part_departementale]
[tax_montant_part_regionale]    [tax_montant_total] [tax_secteur]   [tax_en_ile_de_france]
[tax_val_forf_surf_cstr]    [tax_val_forf_empl_tente_carav_rml] [tax_val_forf_empl_hll] [tax_val_forf_surf_piscine]
[tax_val_forf_nb_eolienne]  [tax_val_forf_surf_pann_photo]  [tax_val_forf_nb_parking_ext]   [tax_tx_depart] [tax_tx_reg]
[tax_tx_exo_facul_1_reg] [tax_tx_exo_facul_2_reg]   [tax_tx_exo_facul_3_reg]    [tax_tx_exo_facul_4_reg]    [tax_tx_exo_facul_5_reg]
[tax_tx_exo_facul_6_reg] [tax_tx_exo_facul_7_reg] [tax_tx_exo_facul_8_reg] [tax_tx_exo_facul_9_reg] [tax_tx_exo_facul_1_depart]
[tax_tx_exo_facul_2_depart] [tax_tx_exo_facul_3_depart] [tax_tx_exo_facul_4_depart] [tax_tx_exo_facul_5_depart]
[tax_tx_exo_facul_6_depart] [tax_tx_exo_facul_7_depart] [tax_tx_exo_facul_8_depart] [tax_tx_exo_facul_9_depart]
[tax_tx_exo_facul_1_comm]   [tax_tx_exo_facul_2_comm]   [tax_tx_exo_facul_3_comm] [tax_tx_exo_facul_4_comm]
[tax_tx_exo_facul_5_comm] [tax_tx_exo_facul_6_comm] [tax_tx_exo_facul_7_comm] [tax_tx_exo_facul_8_comm] [tax_tx_exo_facul_9_comm]
[tax_tx_rap]

--Coordonnées du pétitionnaire principal
[nom_qualite_part_petitionnaire_principal] [prenom_qualite_part_petitionnaire_principal]
[civilite_qualite_part_petitionnaire_principal] [nom_complet_qualite_part_petitionnaire_principal]
[nom_qualite_pm_petitionnaire_principal] [prenom_qualite_pm_petitionnaire_principal]
[civilite_qualite_pm_petitionnaire_principal] [nom_complet_qualite_pm_petitionnaire_principal]
[nom_qualite_part_ou_pm_petitionnaire_principal] [prenom_qualite_part_ou_pm_petitionnaire_principal]
[civilite_qualite_part_ou_pm_petitionnaire_principal] [nom_complet_qualite_part_ou_pm_petitionnaire_principal]
[nom_petitionnaire_principal] (Déprécié, à ne plus utiliser)
[civilite_petitionnaire_principal] (Déprécié, à ne plus utiliser)
[nom_particulier_petitionnaire_principal] (Déprécié, à ne plus utiliser)
[prenom_particulier_petitionnaire_principal] (Déprécié, à ne plus utiliser)
[raison_sociale_petitionnaire_principal]
[denomination_petitionnaire_principal]
[siret_petitionnaire_principal]
[categorie_juridique_petitionnaire_principal]
[numero_petitionnaire_principal]
[adresse_petitionnaire_principal_sdl]
[adresse_petitionnaire_principal]    [voie_petitionnaire_principal]    [complement_petitionnaire_principal]
[lieu_dit_petitionnaire_principal]    [bp_petitionnaire_principal]
[code_postal_petitionnaire_principal]    [localite_petitionnaire_principal]    [cedex_petitionnaire_principal]
[pays_petitionnaire_principal] [division_territoriale_petitionnaire_principal]
[email_petitionnaire_principal]  [notification_petitionnaire_principal]

--Coordonnées du pétitionnaire principal initial
[nom_qualite_part_petitionnaire_principal_initial] [prenom_qualite_part_petitionnaire_principal_initial]
[civilite_qualite_part_petitionnaire_principal_initial] [nom_complet_qualite_part_petitionnaire_principal_initial]
[nom_qualite_pm_petitionnaire_principal_initial] [prenom_qualite_pm_petitionnaire_principal_initial]
[civilite_qualite_pm_petitionnaire_principal_initial] [nom_complet_qualite_pm_petitionnaire_principal_initial]
[nom_qualite_part_ou_pm_petitionnaire_principal_initial] [prenom_qualite_part_ou_pm_petitionnaire_principal_initial]
[civilite_qualite_part_ou_pm_petitionnaire_principal_initial] [nom_complet_qualite_part_ou_pm_petitionnaire_principal_initial]
[nom_petitionnaire_principal_initial] (Déprécié, à ne plus utiliser)
[civilite_petitionnaire_principal_initial] (Déprécié, à ne plus utiliser)
[nom_particulier_petitionnaire_principal_initial] (Déprécié, à ne plus utiliser)
[prenom_particulier_petitionnaire_principal_initial] (Déprécié, à ne plus utiliser)
[raison_sociale_petitionnaire_principal_initial]
[denomination_petitionnaire_principal_initial]
[siret_petitionnaire_principal_initial]
[categorie_juridique_petitionnaire_principal_initial]
[numero_petitionnaire_principal_initial]
[adresse_petitionnaire_principal_initial_sdl]
[adresse_petitionnaire_principal_initial]    [voie_petitionnaire_principal_initial]    [complement_petitionnaire_principal_initial]
[lieu_dit_petitionnaire_principal_initial]    [bp_petitionnaire_principal_initial]
[code_postal_petitionnaire_principal_initial]    [localite_petitionnaire_principal_initial]    [cedex_petitionnaire_principal_initial]
[pays_petitionnaire_principal_initial] [division_territoriale__petitionnaire_principal_initial]
[email_petitionnaire_principal_initial]  [notification_petitionnaire_principal_initial]

--Coordonnées des autres pétitionnaires
[nom_qualite_part_petitionnaire_1](jusqu''à 5)    [prenom_qualite_part_petitionnaire_1](jusqu''à 5)
[civilite_qualite_part_petitionnaire_1](jusqu''à 5)    [nom_complet_qualite_part_petitionnaire_1](jusqu''à 5)
[nom_qualite_pm_petitionnaire_1](jusqu''à 5)    [prenom_qualite_pm_petitionnaire_1](jusqu''à 5)
[civilite_qualite_pm_petitionnaire_1](jusqu''à 5)    [nom_complet_qualite_pm_petitionnaire_1](jusqu''à 5)
[nom_qualite_part_ou_pm_petitionnaire_1](jusqu''à 5)    [prenom_qualite_part_ou_pm_petitionnaire_1](jusqu''à 5)
[civilite_qualite_part_ou_pm_petitionnaire_1](jusqu''à 5)    [nom_complet_qualite_part_ou_pm_petitionnaire_1](jusqu''à 5)
[nom_petitionnaire_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[civilite_petitionnaire_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[nom_particulier_petitionnaire_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[prenom_particulier_petitionnaire_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[raison_sociale_petitionnaire_1](jusqu''à 5)
[denomination_petitionnaire_1](jusqu''à 5)
[siret_petitionnaire_1](jusqu''à 5)
[categorie_juridique_petitionnaire_1](jusqu''à 5)
[numero_petitionnaire_1](jusqu''à 5)
[adresse_petitionnaire_1_sdl](jusqu''à 5)
[adresse_petitionnaire_1](jusqu''à 5)    [voie_petitionnaire_1](jusqu''à 5)
[complement_petitionnaire_1](jusqu''à 5)
[lieu_dit_petitionnaire_1](jusqu''à 5)    [bp_petitionnaire_1](jusqu''à 5)
[code_postal_petitionnaire_1](jusqu''à 5)    [localite_petitionnaire_1](jusqu''à 5)
[cedex_petitionnaire_1](jusqu''à 5)
[pays_petitionnaire_1](jusqu''à 5) [division_territoriale_petitionnaire_1](jusqu''à 5)

--Coordonnées du contrevenant principal
[nom_qualite_part_contrevenant_principal] [prenom_qualite_part_contrevenant_principal]
[civilite_qualite_part_contrevenant_principal] [nom_complet_qualite_part_contrevenant_principal]
[nom_qualite_pm_contrevenant_principal] [prenom_qualite_pm_contrevenant_principal]
[civilite_qualite_pm_contrevenant_principal] [nom_complet_qualite_pm_contrevenant_principal]
[nom_qualite_part_ou_pm_contrevenant_principal] [prenom_qualite_part_ou_pm_contrevenant_principal]
[civilite_qualite_part_ou_pm_contrevenant_principal] [nom_complet_qualite_part_ou_pm_contrevenant_principal]
[nom_contrevenant_principal] (Déprécié, à ne plus utiliser)
[civilite_contrevenant_principal] (Déprécié, à ne plus utiliser)
[nom_particulier_contrevenant_principal] (Déprécié, à ne plus utiliser)
[prenom_particulier_contrevenant_principal] (Déprécié, à ne plus utiliser)
[raison_sociale_contrevenant_principal]
[denomination_contrevenant_principal]
[siret_contrevenant_principal]
[categorie_juridique_contrevenant_principal]
[numero_contrevenant_principal]
[adresse_contrevenant_principal_sdl]
[adresse_contrevenant_principal]    [voie_contrevenant_principal]    [complement_contrevenant_principal]
[lieu_dit_contrevenant_principal]    [bp_contrevenant_principal]
[code_postal_contrevenant_principal]    [localite_contrevenant_principal]    [cedex_contrevenant_principal]
[pays_contrevenant_principal] [division_territoriale_contrevenant_principal]

--Coordonnées des autres contrevenants
[nom_qualite_part_contrevenant_1](jusqu''à 5) [prenom_qualite_part_contrevenant_1](jusqu''à 5)
[civilite_qualite_part_contrevenant_1](jusqu''à 5) [nom_complet_qualite_part_contrevenant_1](jusqu''à 5)
[nom_qualite_pm_contrevenant_1](jusqu''à 5) [prenom_qualite_pm_contrevenant_1](jusqu''à 5)
[civilite_qualite_pm_contrevenant_1](jusqu''à 5) [nom_complet_qualite_pm_contrevenant_1](jusqu''à 5)
[nom_qualite_part_ou_pm_contrevenant_1](jusqu''à 5) [prenom_qualite_part_ou_pm_contrevenant_1](jusqu''à 5)
[civilite_qualite_part_ou_pm_contrevenant_1](jusqu''à 5) [nom_complet_qualite_part_ou_pm_contrevenant_1](jusqu''à 5)
[nom_contrevenant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[civilite_contrevenant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[nom_particulier_contrevenant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[prenom_particulier_contrevenant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[raison_sociale_contrevenant_1](jusqu''à 5)
[denomination_contrevenant_1](jusqu''à 5)
[siret_contrevenant_1](jusqu''à 5)
[categorie_juridique_contrevenant_1](jusqu''à 5)
[numero_contrevenant_1](jusqu''à 5)
[adresse_contrevenant_1_sdl](jusqu''à 5)
[adresse_contrevenant_1](jusqu''à 5)    [voie_contrevenant_1](jusqu''à 5)
[complement_contrevenant_1](jusqu''à 5)
[lieu_dit_contrevenant_1](jusqu''à 5)    [bp_contrevenant_1](jusqu''à 5)
[code_postal_contrevenant_1](jusqu''à 5)    [localite_contrevenant_1](jusqu''à 5)
[cedex_contrevenant_1](jusqu''à 5)
[pays_contrevenant_1](jusqu''à 5) [division_territoriale_contrevenant_1](jusqu''à 5)

--Coordonnées du requérant principal
[nom_qualite_part_requerant_principal] [prenom_qualite_part_requerant_principal]
[civilite_qualite_part_requerant_principal] [nom_complet_qualite_part_requerant_principal]
[nom_qualite_pm_requerant_principal] [prenom_qualite_pm_requerant_principal]
[civilite_qualite_pm_requerant_principal] [nom_complet_qualite_pm_requerant_principal]
[nom_qualite_part_ou_pm_requerant_principal] [prenom_qualite_part_ou_pm_requerant_principal]
[civilite_qualite_part_ou_pm_requerant_principal] [nom_complet_qualite_part_ou_pm_requerant_principal]
[nom_requerant_principal] (Déprécié, à ne plus utiliser)
[civilite_requerant_principal] (Déprécié, à ne plus utiliser)
[nom_particulier_requerant_principal] (Déprécié, à ne plus utiliser)
[prenom_particulier_requerant_principal] (Déprécié, à ne plus utiliser)
[raison_sociale_requerant_principal]
[denomination_requerant_principal]
[siret_requerant_principal]
[categorie_juridique_requerant_principal]
[numero_requerant_principal]
[adresse_requerant_principal_sdl]
[adresse_requerant_principal]    [voie_requerant_principal]    [complement_requerant_principal]
[lieu_dit_requerant_principal]    [bp_requerant_principal]
[code_postal_requerant_principal]    [localite_requerant_principal]    [cedex_requerant_principal]
[pays_requerant_principal] [division_territoriale_requerant_principal]

--Coordonnées des autres requérants
[nom_qualite_part_requerant_1](jusqu''à 5) [prenom_qualite_part_requerant_1](jusqu''à 5)
[civilite_qualite_part_requerant_1](jusqu''à 5) [nom_complet_qualite_part_requerant_1](jusqu''à 5)
[nom_qualite_pm_requerant_1](jusqu''à 5) [prenom_qualite_pm_requerant_1](jusqu''à 5)
[civilite_qualite_pm_requerant_1](jusqu''à 5) [nom_complet_qualite_pm_requerant_1](jusqu''à 5)
[nom_qualite_part_ou_pm_requerant_1](jusqu''à 5) [prenom_qualite_part_ou_pm_requerant_1](jusqu''à 5)
[civilite_qualite_part_ou_pm_requerant_1](jusqu''à 5) [nom_complet_qualite_part_ou_pm_requerant_1](jusqu''à 5)
[nom_requerant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[civilite_requerant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[nom_particulier_requerant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[prenom_particulier_requerant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[raison_sociale_requerant_1](jusqu''à 5)
[denomination_requerant_1](jusqu''à 5)
[siret_requerant_1](jusqu''à 5)
[categorie_juridique_requerant_1](jusqu''à 5)
[numero_requerant_1](jusqu''à 5)
[adresse_requerant_1_sdl](jusqu''à 5)
[adresse_requerant_1](jusqu''à 5)    [voie_requerant_1](jusqu''à 5)
[complement_requerant_1](jusqu''à 5)
[lieu_dit_requerant_1](jusqu''à 5)    [bp_requerant_1](jusqu''à 5)
[code_postal_requerant_1](jusqu''à 5)    [localite_requerant_1](jusqu''à 5)
[cedex_requerant_1](jusqu''à 5)
[pays_requerant_1](jusqu''à 5) [division_territoriale_requerant_1](jusqu''à 5)

--Coordonnées de l''avocat principal
[nom_qualite_part_avocat_principal] [prenom_qualite_part_avocat_principal]
[civilite_qualite_part_avocat_principal] [nom_complet_qualite_part_avocat_principal]
[nom_qualite_pm_avocat_principal] [prenom_qualite_pm_avocat_principal]
[civilite_qualite_pm_avocat_principal] [nom_complet_qualite_pm_avocat_principal]
[nom_qualite_part_ou_pm_avocat_principal] [prenom_qualite_part_ou_pm_avocat_principal]
[civilite_qualite_part_ou_pm_avocat_principal] [nom_complet_qualite_part_ou_pm_avocat_principal]
[nom_avocat_principal] (Déprécié, à ne plus utiliser)
[civilite_avocat_principal] (Déprécié, à ne plus utiliser)
[nom_particulier_avocat_principal] (Déprécié, à ne plus utiliser)
[prenom_particulier_avocat_principal] (Déprécié, à ne plus utiliser)
[raison_sociale_avocat_principal]
[denomination_avocat_principal]
[siret_avocat_principal]
[categorie_juridique_avocat_principal]
[numero_avocat_principal]
[adresse_avocat_principal_sdl]
[adresse_avocat_principal]    [voie_avocat_principal]    [complement_avocat_principal]
[lieu_dit_avocat_principal]    [bp_avocat_principal]
[code_postal_avocat_principal]    [localite_avocat_principal]    [cedex_avocat_principal]
[pays_avocat_principal] [division_territoriale_avocat_principal]

--Coordonnées des autres avocats
[nom_qualite_part_avocat_1](jusqu''à 5) [prenom_qualite_part_avocat_1](jusqu''à 5)
[civilite_qualite_part_avocat_1](jusqu''à 5) [nom_complet_qualite_part_avocat_1](jusqu''à 5)
[nom_qualite_pm_avocat_1](jusqu''à 5) [prenom_qualite_pm_avocat_1](jusqu''à 5)
[civilite_qualite_pm_avocat_1](jusqu''à 5) [nom_complet_qualite_pm_avocat_1](jusqu''à 5)
[nom_qualite_part_ou_pm_avocat_1](jusqu''à 5) [prenom_qualite_part_ou_pm_avocat_1](jusqu''à 5)
[civilite_qualite_part_ou_pm_avocat_1](jusqu''à 5) [nom_complet_qualite_part_ou_pm_avocat_1](jusqu''à 5)
[nom_avocat_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[civilite_avocat_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[nom_particulier_avocat_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[prenom_particulier_avocat_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[raison_sociale_avocat_1](jusqu''à 5)
[denomination_avocat_1](jusqu''à 5)
[siret_avocat_1](jusqu''à 5)
[categorie_juridique_avocat_1](jusqu''à 5)
[numero_avocat_1](jusqu''à 5)
[adresse_avocat_1_sdl](jusqu''à 5)
[adresse_avocat_1](jusqu''à 5)    [voie_avocat_1](jusqu''à 5)
[complement_avocat_1](jusqu''à 5)
[lieu_dit_avocat_1](jusqu''à 5)    [bp_avocat_1](jusqu''à 5)
[code_postal_avocat_1](jusqu''à 5)    [localite_avocat_1](jusqu''à 5)
[cedex_avocat_1](jusqu''à 5)
[pays_avocat_1](jusqu''à 5) [division_territoriale_avocat_1](jusqu''à 5)

--Coordonnées du plaignant principal
[nom_qualite_part_plaignant_principal] [prenom_qualite_part_plaignant_principal]
[civilite_qualite_part_plaignant_principal] [nom_complet_qualite_part_plaignant_principal]
[nom_qualite_pm_plaignant_principal] [prenom_qualite_pm_plaignant_principal]
[civilite_qualite_pm_plaignant_principal] [nom_complet_qualite_pm_plaignant_principal]
[nom_qualite_part_ou_pm_plaignant_principal] [prenom_qualite_part_ou_pm_plaignant_principal]
[civilite_qualite_part_ou_pm_plaignant_principal] [nom_complet_qualite_part_ou_pm_plaignant_principal]
[nom_plaignant_principal] (Déprécié, à ne plus utiliser)
[civilite_plaignant_principal] (Déprécié, à ne plus utiliser)
[nom_particulier_plaignant_principal] (Déprécié, à ne plus utiliser)
[prenom_particulier_plaignant_principal] (Déprécié, à ne plus utiliser)
[raison_sociale_plaignant_principal]
[denomination_plaignant_principal]
[siret_plaignant_principal]
[categorie_juridique_plaignant_principal]
[numero_plaignant_principal]
[adresse_plaignant_principal_sdl]
[adresse_plaignant_principal]    [voie_plaignant_principal]    [complement_plaignant_principal]
[lieu_dit_plaignant_principal]    [bp_plaignant_principal]
[code_postal_plaignant_principal]    [localite_plaignant_principal]    [cedex_plaignant_principal]
[pays_plaignant_principal] [division_territoriale_plaignant_principal]

--Coordonnées des autres plaignants
[nom_qualite_part_plaignant_1](jusqu''à 5) [prenom_qualite_part_plaignant_1](jusqu''à 5)
[civilite_qualite_part_plaignant_1](jusqu''à 5) [nom_complet_qualite_part_plaignant_1](jusqu''à 5)
[nom_qualite_pm_plaignant_1](jusqu''à 5) [prenom_qualite_pm_plaignant_1](jusqu''à 5)
[civilite_qualite_pm_plaignant_1](jusqu''à 5) [nom_complet_qualite_pm_plaignant_1](jusqu''à 5)
[nom_qualite_part_ou_pm_plaignant_1](jusqu''à 5) [prenom_qualite_part_ou_pm_plaignant_1](jusqu''à 5)
[civilite_qualite_part_ou_pm_plaignant_1](jusqu''à 5) [nom_complet_qualite_part_ou_pm_plaignant_1](jusqu''à 5)
[nom_plaignant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[civilite_plaignant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[nom_particulier_plaignant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[prenom_particulier_plaignant_1](jusqu''à 5) (Déprécié, à ne plus utiliser)
[raison_sociale_plaignant_1](jusqu''à 5)
[denomination_plaignant_1](jusqu''à 5)
[siret_plaignant_1](jusqu''à 5)
[categorie_juridique_plaignant_1](jusqu''à 5)
[numero_plaignant_1](jusqu''à 5)
[adresse_plaignant_1_sdl](jusqu''à 5)
[adresse_plaignant_1](jusqu''à 5)    [voie_plaignant_1](jusqu''à 5)
[complement_plaignant_1](jusqu''à 5)
[lieu_dit_plaignant_1](jusqu''à 5)    [bp_plaignant_1](jusqu''à 5)
[code_postal_plaignant_1](jusqu''à 5)    [localite_plaignant_1](jusqu''à 5)
[cedex_plaignant_1](jusqu''à 5)
[pays_plaignant_1](jusqu''à 5) [division_territoriale_plaignant_1](jusqu''à 5)

--Coordonnées du délégataire
[nom_qualite_part_delegataire] [prenom_qualite_part_delegataire]
[civilite_qualite_part_delegataire] [nom_complet_qualite_part_delegataire]
[nom_qualite_pm_delegataire] [prenom_qualite_pm_delegataire]
[civilite_qualite_pm_delegataire] [nom_complet_qualite_pm_delegataire]
[nom_qualite_part_ou_pm_delegataire] [prenom_qualite_part_ou_pm_delegataire]
[civilite_qualite_part_ou_pm_delegataire] [nom_complet_qualite_part_ou_pm_delegataire]
[nom_delegataire] (Déprécié, à ne plus utiliser)
[civilite_delegataire] (Déprécié, à ne plus utiliser)
[nom_particulier_delegataire] (Déprécié, à ne plus utiliser)
[prenom_particulier_delegataire] (Déprécié, à ne plus utiliser)
[raison_sociale_delegataire]
[denomination_delegataire]
[siret_delegataire]
[categorie_juridique_delegataire]
[numero_delegataire]
[adresse_delegataire_sdl]
[adresse_delegataire]    [voie_delegataire]    [complement_delegataire]
[lieu_dit_delegataire]    [bp_delegataire]
[code_postal_delegataire]    [ville_delegataire]    [cedex_delegataire]
[pays_delegataire] [division_territoriale_delegataire]

--Coordonnées du bailleur principal
[nom_qualite_part_bailleur_principal] [prenom_qualite_part_bailleur_principal]
[civilite_qualite_part_bailleur_principal] [nom_complet_qualite_part_bailleur_principal]
[nom_qualite_pm_bailleur_principal] [prenom_qualite_pm_bailleur_principal]
[civilite_qualite_pm_bailleur_principal] [nom_complet_qualite_pm_bailleur_principal]
[nom_qualite_part_ou_pm_bailleur_principal] [prenom_qualite_part_ou_pm_bailleur_principal]
[civilite_qualite_part_ou_pm_bailleur_principal] [nom_complet_qualite_part_ou_pm_bailleur_principal]
[raison_sociale_bailleur_principal]
[denomination_bailleur_principal]
[siret_bailleur_principal]
[categorie_juridique_bailleur_principal]
[numero_bailleur_principal]
[adresse_bailleur_principal_sdl]
[adresse_bailleur_principal]    [voie_bailleur_principal]    [complement_bailleur_principal]
[lieu_dit_bailleur_principal]    [bp_bailleur_principal]
[code_postal_bailleur_principal]    [localite_bailleur_principal]    [cedex_bailleur_principal]
[pays_bailleur_principal] [division_territoriale_bailleur_principal]

--Coordonnées des autres bailleurs
[nom_qualite_part_bailleur_1](jusqu''à 5) [prenom_qualite_part_bailleur_1](jusqu''à 5)
[civilite_qualite_part_bailleur_1](jusqu''à 5) [nom_complet_qualite_part_bailleur_1](jusqu''à 5)
[nom_qualite_pm_bailleur_1](jusqu''à 5) [prenom_qualite_pm_bailleur_1](jusqu''à 5)
[civilite_qualite_pm_bailleur_1](jusqu''à 5) [nom_complet_qualite_pm_bailleur_1](jusqu''à 5)
[nom_qualite_part_ou_pm_bailleur_1](jusqu''à 5) [prenom_qualite_part_ou_pm_bailleur_1](jusqu''à 5)
[civilite_qualite_part_ou_pm_bailleur_1](jusqu''à 5) [nom_complet_qualite_part_ou_pm_bailleur_1](jusqu''à 5)
[raison_sociale_bailleur_1](jusqu''à 5)
[denomination_bailleur_1](jusqu''à 5)
[siret_bailleur_1](jusqu''à 5)
[categorie_juridique_bailleur_1](jusqu''à 5)
[numero_bailleur_1](jusqu''à 5)
[adresse_bailleur_1_sdl](jusqu''à 5)
[adresse_bailleur_1](jusqu''à 5)    [voie_bailleur_1](jusqu''à 5)
[complement_bailleur_1](jusqu''à 5)
[lieu_dit_bailleur_1](jusqu''à 5)    [bp_bailleur_1](jusqu''à 5)
[code_postal_bailleur_1](jusqu''à 5)    [localite_bailleur_1](jusqu''à 5)
[cedex_bailleur_1](jusqu''à 5)
[pays_bailleur_1](jusqu''à 5) [division_territoriale_bailleur_1](jusqu''à 5)

-- CORRESPONDANT : destinataire du courrier. Il est le délégataire ou le pétitionnaire principal
[nom_qualite_part_correspondant] [prenom_qualite_part_correspondant]
[civilite_qualite_part_correspondant] [nom_complet_qualite_part_correspondant]
[nom_qualite_pm_correspondant] [prenom_qualite_pm_correspondant]
[civilite_qualite_pm_correspondant] [nom_complet_qualite_pm_correspondant]
[nom_qualite_part_ou_pm_correspondant] [prenom_qualite_part_ou_pm_correspondant]
[civilite_qualite_part_ou_pm_correspondant] [nom_complet_qualite_part_ou_pm_correspondant]
[nom_correspondant] (Déprécié, à ne plus utiliser)
[civilite_correspondant] (Déprécié, à ne plus utiliser)
[nom_particulier_correspondant] (Déprécié, à ne plus utiliser)
[prenom_particulier_correspondant] (Déprécié, à ne plus utiliser)
[raison_sociale_correspondant]
[denomination_correspondant]
[siret_correspondant]
[categorie_juridique_correspondant]
[numero_correspondant]
[adresse_correspondant_sdl]
[adresse_correspondant]    [voie_correspondant]    [complement_correspondant]
[lieu_dit_correspondant]    [bp_correspondant]
[code_postal_correspondant]    [ville_correspondant]    [cedex_correspondant]
[pays_correspondant] [division_territoriale_correspondant] 
[email_correspondant]  [notification_correspondant]

--Dates importantes du dossier d''instruction
[date_affichage]
[date_depot_dossier]
[date_completude]
[date_dernier_depot]
[date_decision_dossier]
[date_limite_dossier]
[date_achevement_dossier]
[date_conformite_dossier]
[date_notification_delai_dossier]
[date_decision_da]

--Noms des signataires
[agrement_signataire],
[visa_signataire],
[visa_signataire_2]
[visa_signataire_3]
[visa_signataire_4]
[arrete_signataire]
[signature_signataire]
[signature_signataire_ss_qualite]
[chef_division]
[chef_direction]
[libelle_direction]
[description_direction]

--Données générales des données techniques
[co_projet_desc_donnees_techniques]    [am_projet_desc_donnees_techniques]
[dm_projet_desc_donnees_techniques]    [ope_proj_desc_donnees_techniques]
[projet_desc_donnees_techniques]
[co_tot_log_nb_donnees_techniques]    [co_statio_place_nb_donnees_techniques]
[am_lot_max_nb_donnees_techniques]    [am_lot_max_shon_donnees_techniques]
-- Les données techniques suivantes concernent le tableau des surfaces
-- Elles récupèrent les valeurs du tableau composé des sous-destinations si au
-- moins une valeur de celui-ci est saisie
[su_cstr_shon_tot_donnees_techniques]    [su_demo_shon_tot_donnees_techniques]
[tab_surface_donnees_techniques]
[su_tot_shon_tot_donnees_techniques]

--Données techniques des AT
[at_type_travaux]
[at_effectif_public_total]
[at_categorie_etablissement]
[at_type_etablissement]

-- Données techniques pour les DPC
[dpc_type]
[dpc_moda_cess_prix]

-- Données techniques pour une DIA
[dia_mod_cess_prix_vente] (Prix de vente en lettres et chiffres)
[dia_mod_cess_prix_vente_num] (Prix de vente en chiffres)
[dia_mod_cess_prix_vente_mob] (Prix de vente mobilier)
[dia_mod_cess_prix_vente_cheptel] (Prix de vente cheptel)
[dia_mod_cess_prix_vente_recol] (Prix de vente récultes)
[dia_mod_cess_prix_vente_autre] (Prix de vente autres)
[dia_mod_cess_commi_mnt] (Montant de la commmission)
[dia_acquereur_nom_prenom] (Nom et prénom de l''acquéreur)
[dia_acquereur_adresse_sdl] (Adresse de l''acquéreur avec saut de ligne)
[dia_acquereur_adresse] (Adresse de l''acquéreur sans saut de ligne)
[dia_esti_prix_france_dom] (Estimation du prix de vente par France Domaine)
[dia_prop_collectivite] (Proposition d''acquisition de la collectivité)
[dia_entree_jouissance_type] (Type de l''entrée en jouissance)
[dia_entree_jouissance_date] (Date de l''entrée en jouissance)
[dia_entree_jouissance_date_effet] (Date d''effet de l''entrée en jouissance)
[dia_entree_jouissance_com] (Commentaire de l''entrée en jouissance)
[dia_remise_bien_date_effet] (Date d''effet de la remise du bien)
[dia_remise_bien_com] (Commentaire de la remise du bien)

--Bordereau envoi au maire
[objet_bordereau_envoi_maire]

--Données techniques du contentieux
[ctx_objet_recours_libelle]
[ctx_reference_sagace]
[ctx_nature_travaux_infra_om_html]
[ctx_synthese_nti]
[ctx_article_non_resp_om_html]
[ctx_synthese_anr]
[ctx_reference_parquet]
[ctx_element_taxation]
[ctx_infraction]
[ctx_regularisable]
[ctx_reference_courrier]
[date_audience_ctx]
[date_ajournement_ctx]
'
WHERE om_requete = 29 AND code = 'instruction';

--
-- END / [#9957] Mise à jour des données techniques et CERFA
--
