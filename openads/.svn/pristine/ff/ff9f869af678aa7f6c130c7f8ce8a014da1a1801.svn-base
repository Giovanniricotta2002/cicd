*** Settings ***
Documentation    CRUD de la table dossier
...    @author  generated
...    @package openADS
...    @version 17/02/2023 00:02

*** Keywords ***

Depuis le contexte dossier
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier}

    # On accède au tableau
    Go To Tab  dossier
    # On recherche l'enregistrement
    Use Simple Search  dossier  ${dossier}
    # On clique sur le résultat
    Click On Link  ${dossier}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter dossier
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir dossier  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier} =  Get Text  css=div.form-content span#dossier
    # On le retourne
    [Return]  ${dossier}

Modifier dossier
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte dossier  ${dossier}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier  modifier
    # On saisit des valeurs
    Saisir dossier  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer dossier
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier}

    # On accède à l'enregistrement
    Depuis le contexte dossier  ${dossier}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir dossier
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "annee" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "instructeur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_demande" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_depot" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_complet" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_rejet" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_notification_delai" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "delai" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_limite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "accord_tacite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_decision" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_validite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_chantier" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_achevement" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_conformite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "erp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avis_decision" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "enjeu_erp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "enjeu_urba" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "division" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "autorite_competente" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "a_qualifier" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "terrain_references_cadastrales" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_voie_numero" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_voie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_lieu_dit" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_localite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_code_postal" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_bp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_cedex" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_superficie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_autorisation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_dernier_depot" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "version" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "incompletude" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "evenement_suivant_tacite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "evenement_suivant_tacite_incompletude" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "etat_pendant_incompletude" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_limite_incompletude" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "delai_incompletude" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numero_versement_archive" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "duree_validite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "quartier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "incomplet_notifie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "tax_secteur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_mtn_part_commu" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_mtn_part_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_mtn_part_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_mtn_total" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "log_instructions" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "interface_referentiel_erp" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "autorisation_contestee" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_cloture_instruction" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_premiere_visite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_derniere_visite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_contradictoire" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_retour_contradictoire" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_ait" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_transmission_parquet" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "instructeur_2" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "tax_mtn_rap" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_mtn_part_commu_sans_exo" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_mtn_part_depart_sans_exo" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_mtn_part_reg_sans_exo" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_mtn_total_sans_exo" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tax_mtn_rap_sans_exo" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_modification" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "hash_sitadel" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "depot_electronique" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "parcelle_temporaire" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "date_affichage" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "version_clos" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "initial_dt" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "commune" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "adresse_normalisee" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse_normalisee_json" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_depot_mairie" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "numerotation_type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numerotation_dep" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numerotation_com" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numerotation_division" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numerotation_num" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numerotation_suffixe" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numerotation_num_suffixe" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numerotation_entite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numerotation_num_entite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pec_metier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "etat_transmission_platau" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_parent" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "terrain_superficie_calculee" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "geoloc_latitude" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "geoloc_longitude" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "geoloc_rayon" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "geom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "geom1" existe dans "${values}" on execute "Input Text" dans le formulaire