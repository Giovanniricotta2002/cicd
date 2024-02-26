*** Settings ***
Documentation    CRUD de la table instruction
...    @author  generated
...    @package openADS
...    @version 23/10/2018 09:10

*** Keywords ***

Depuis le contexte Instruction
    [Documentation]  Accède au formulaire
    [Arguments]  ${instruction}

    # On accède au tableau
    Go To Tab  instruction
    # On recherche l'enregistrement
    Use Simple Search  Instruction  ${instruction}
    # On clique sur le résultat
    Click On Link  ${instruction}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Instruction
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  instruction
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Instruction  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${instruction} =  Get Text  css=div.form-content span#instruction
    # On le retourne
    [Return]  ${instruction}

Modifier Instruction
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${instruction}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Instruction  ${instruction}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  instruction  modifier
    # On saisit des valeurs
    Saisir Instruction  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Instruction
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${instruction}

    # On accède à l'enregistrement
    Depuis le contexte Instruction  ${instruction}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  instruction  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Instruction
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "destinataire" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_evenement" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "evenement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "lettretype" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "complement_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement2_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "action" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "delai" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "accord_tacite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "delai_notification" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "archive_delai" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "archive_date_complet" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_rejet" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_limite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_notification_delai" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_accord_tacite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "archive_etat" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "archive_date_decision" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_avis" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "archive_date_validite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_achevement" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_chantier" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_conformite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "complement3_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement4_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement5_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement6_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement7_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement8_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement9_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement10_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement11_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement12_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement13_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement14_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "complement15_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "avis_decision" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_finalisation_courrier" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_envoi_signature" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_retour_signature" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_envoi_rar" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_retour_rar" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_envoi_controle_legalite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_retour_controle_legalite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "signataire_arrete" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "numero_arrete" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "archive_date_dernier_depot" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_incompletude" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "archive_evenement_suivant_tacite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "archive_evenement_suivant_tacite_incompletude" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "archive_etat_pendant_incompletude" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "archive_date_limite_incompletude" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_delai_incompletude" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code_barres" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_fichier_instruction" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_final_instruction" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "document_numerise" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "archive_autorite_competente" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "autorite_competente" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "duree_validite_parametrage" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "duree_validite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "archive_incomplet_notifie" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_final_instruction_utilisateur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "created_by_commune" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "date_depot" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_cloture_instruction" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_premiere_visite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_derniere_visite" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_contradictoire" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_retour_contradictoire" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_ait" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "archive_date_transmission_parquet" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_fichier_instruction_dossier_final" existe dans "${values}" on execute "Set Checkbox" dans le formulaire