*** Settings ***
Documentation    CRUD de la table taxe_amenagement
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte taxe d'aménagement
    [Documentation]  Accède au formulaire
    [Arguments]  ${taxe_amenagement}

    # On accède au tableau
    Go To Tab  taxe_amenagement
    # On recherche l'enregistrement
    Use Simple Search  taxe d'aménagement  ${taxe_amenagement}
    # On clique sur le résultat
    Click On Link  ${taxe_amenagement}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter taxe d'aménagement
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  taxe_amenagement
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir taxe d'aménagement  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${taxe_amenagement} =  Get Text  css=div.form-content span#taxe_amenagement
    # On le retourne
    [Return]  ${taxe_amenagement}

Modifier taxe d'aménagement
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${taxe_amenagement}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte taxe d'aménagement  ${taxe_amenagement}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  taxe_amenagement  modifier
    # On saisit des valeurs
    Saisir taxe d'aménagement  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer taxe d'aménagement
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${taxe_amenagement}

    # On accède à l'enregistrement
    Depuis le contexte taxe d'aménagement  ${taxe_amenagement}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  taxe_amenagement  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir taxe d'aménagement
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "en_ile_de_france" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "val_forf_surf_cstr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "val_forf_empl_tente_carav_rml" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "val_forf_empl_hll" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "val_forf_surf_piscine" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "val_forf_nb_eolienne" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "val_forf_surf_pann_photo" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "val_forf_nb_parking_ext" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_5" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_6" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_7" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_8" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_9" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_10" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_11" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_12" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_13" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_14" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_15" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_16" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_17" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_18" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_19" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_comm_secteur_20" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_1_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_2_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_3_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_4_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_5_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_6_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_7_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_8_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_9_reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_1_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_2_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_3_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_4_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_5_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_6_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_7_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_8_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_9_depart" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_1_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_2_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_3_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_4_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_5_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_6_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_7_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_8_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_exo_facul_9_comm" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tx_rap" existe dans "${values}" on execute "Input Text" dans le formulaire