*** Settings ***
Documentation    CRUD de la table dossier_geolocalisation
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Géolocalisation
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_geolocalisation}

    # On accède au tableau
    Go To Tab  dossier_geolocalisation
    # On recherche l'enregistrement
    Use Simple Search  Géolocalisation  ${dossier_geolocalisation}
    # On clique sur le résultat
    Click On Link  ${dossier_geolocalisation}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Géolocalisation
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_geolocalisation
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Géolocalisation  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_geolocalisation} =  Get Text  css=div.form-content span#dossier_geolocalisation
    # On le retourne
    [Return]  ${dossier_geolocalisation}

Modifier Géolocalisation
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_geolocalisation}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Géolocalisation  ${dossier_geolocalisation}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_geolocalisation  modifier
    # On saisit des valeurs
    Saisir Géolocalisation  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Géolocalisation
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_geolocalisation}

    # On accède à l'enregistrement
    Depuis le contexte Géolocalisation  ${dossier_geolocalisation}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_geolocalisation  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Géolocalisation
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_verif_parcelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat_verif_parcelle" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "message_verif_parcelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_calcul_emprise" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat_calcul_emprise" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "message_calcul_emprise" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_dessin_emprise" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat_dessin_emprise" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "message_dessin_emprise" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_calcul_centroide" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat_calcul_centroide" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "message_calcul_centroide" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_recup_contrainte" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat_recup_contrainte" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "message_recup_contrainte" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_references_cadastrales_archive" existe dans "${values}" on execute "Input Text" dans le formulaire