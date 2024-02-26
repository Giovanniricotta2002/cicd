*** Settings ***
Documentation     Actions spécifiques à la taxe d'aménagement.

*** Keywords ***
Depuis le contexte du paramétrage des taxes

    [Documentation]  Permet d'accéder au formulaire de consultation du
    ...  paramétrage des taxes.

    [Arguments]  ${om_collectivite}

    Depuis le listing des paramétrages des taxes
    # On recherche la taxe d'aménagement
    Use Simple Search    Collectivité    ${om_collectivite}
    # On clique sur le lien
    Click On Link    ${om_collectivite}
    # On vérifie le fil d'Ariane
    Page Title Should Contain    Paramétrage > Organisation > Taxes >


Depuis le listing des paramétrages des taxes

    [Documentation]  Permet d'accéder au listing des paramétrages des taxes

    # On clique sur le tableau de bord
    Go To Dashboard
    # On clique sur l'item correspondant du menu
    Go To Submenu In Menu    parametrage    taxe_amenagement
    # On vérifie le fil d'Ariane
    Page Title Should Be    Paramétrage > Organisation > Taxes


Ajouter le paramétrage des taxes

    [Documentation]  Ajoute un paramétrage des taxes sur une collectivité.

    [Arguments]  ${values}

    #
    Depuis le listing des paramétrages des taxes
    # On clique sur l'action ajouter du tableau
    Click On Add Button
    # On saisit le formulaire
    Saisir le formulaire de paramétrage des taxes  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message affiché à l'utilisateur
    Valid Message Should Be  Vos modifications ont bien été enregistrées.


Modifier le paramétrage des taxes

    [Documentation]  Modifie le paramétrage des taxes.

    [Arguments]  ${values}

    Depuis le contexte du paramétrage des taxes  ${values.om_collectivite}
    # On clique sur l'action modifier du portlet
    Click On Form Portlet Action    taxe_amenagement    modifier
    # On saisit le formulaire
    Saisir le formulaire de paramétrage des taxes  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message affiché à l'utilisateur
    Valid Message Should Be  Vos modifications ont bien été enregistrées.


Saisir le formulaire de paramétrage des taxes

    [Documentation]  Permet de saisir le formulaire de paramétrage des taxes.

    [Arguments]  ${values}

    # Saisit les champs du formulaire
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