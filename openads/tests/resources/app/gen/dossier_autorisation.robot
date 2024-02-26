*** Settings ***
Documentation    CRUD de la table dossier_autorisation
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte dossier d'autorisation
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_autorisation}

    # On accède au tableau
    Go To Tab  dossier_autorisation
    # On recherche l'enregistrement
    Use Simple Search  dossier d'autorisation  ${dossier_autorisation}
    # On clique sur le résultat
    Click On Link  ${dossier_autorisation}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter dossier d'autorisation
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_autorisation
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir dossier d'autorisation  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_autorisation} =  Get Text  css=div.form-content span#dossier_autorisation
    # On le retourne
    [Return]  ${dossier_autorisation}

Modifier dossier d'autorisation
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_autorisation}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte dossier d'autorisation  ${dossier_autorisation}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_autorisation  modifier
    # On saisit des valeurs
    Saisir dossier d'autorisation  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer dossier d'autorisation
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_autorisation}

    # On accède à l'enregistrement
    Depuis le contexte dossier d'autorisation  ${dossier_autorisation}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_autorisation  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir dossier d'autorisation
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier_autorisation_type_detaille" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "exercice" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "insee" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_references_cadastrales" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_voie_numero" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_voie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_lieu_dit" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_localite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_code_postal" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_bp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_cedex" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_superficie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "arrondissement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "depot_initial" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "erp_numero_batiment" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "erp_ouvert" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_date_ouverture" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "erp_arrete_decision" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "erp_date_arrete_decision" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "numero_version" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat_dossier_autorisation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_depot" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_decision" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_validite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_chantier" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_achevement" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "avis_decision" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "etat_dernier_dossier_instruction_accepte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_autorisation_libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "cle_acces_citoyen" existe dans "${values}" on execute "Input Text" dans le formulaire