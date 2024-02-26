*** Settings ***
Documentation    CRUD de la table dossier_operateur
...    @author  generated
...    @package openADS
...    @version 21/06/2022 11:06

*** Keywords ***

Depuis le contexte dossier_operateur
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_operateur}

    # On accède au tableau
    Go To Tab  dossier_operateur
    # On recherche l'enregistrement
    Use Simple Search  dossier_operateur  ${dossier_operateur}
    # On clique sur le résultat
    Click On Link  ${dossier_operateur}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter dossier_operateur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_operateur
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir dossier_operateur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_operateur} =  Get Text  css=div.form-content span#dossier_operateur
    # On le retourne
    [Return]  ${dossier_operateur}

Modifier dossier_operateur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_operateur}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte dossier_operateur  ${dossier_operateur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_operateur  modifier
    # On saisit des valeurs
    Saisir dossier_operateur  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer dossier_operateur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_operateur}

    # On accède à l'enregistrement
    Depuis le contexte dossier_operateur  ${dossier_operateur}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_operateur  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir dossier_operateur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "operateur_designation_initialisee" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "operateur_detecte_inrap" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "operateur_detecte_collterr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur_collterr_type_agrement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur_amenagement_pers_publique" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur_pers_publique_amenageur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur_collterr_kpark_avis" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur_selectionne" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "operateur_personne_publique" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "operateur_personne_publique_avis" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur_kpark_libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur_kpark_type_operateur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur_kpark_evenement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur_designe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "operateur_valide" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "operateur_designe_historique" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_instruction" existe dans "${values}" on execute "Select From List By Label" dans le formulaire