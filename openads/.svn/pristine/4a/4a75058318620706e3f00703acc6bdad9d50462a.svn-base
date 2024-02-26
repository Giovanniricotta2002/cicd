*** Settings ***
Documentation  Actions spécifiques aux commissions.

*** Keywords ***
Depuis le listing des commissions

    Depuis le listing  commission


Depuis le contexte de la commission
    [Documentation]  Accède au formulaire
    [Arguments]  ${commission}

    Depuis le listing des commissions
    # On recherche l'enregistrement
    Use Simple Search  code  ${commission}
    # On clique sur le résultat
    Click On Link  ${commission}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur


Ajouter un suivi de commission
    [Documentation]  Créer une commission. Avec type, date, collectivité, etc.
    [Arguments]  ${commission_values}

    # Depuis le tableau de bord
    Go To Dashboard
    # Depuis le menu de gestion des commissions
    Go To Submenu In Menu  suivi  commissions
    # On clique sur le bouton d'ajout
    Click On Add Button
    #
    Saisir la commission  ${commission_values}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.


Planifier un dossier pour une commission
    [Documentation]  Planifier pour une commission un dossier faisant l'objet
    ...  d'une demande.
    [Arguments]  ${dossier_instruction}  ${code_commission}

    Depuis le contexte de la commission  ${code_commission}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  On clique sur l'onglet  commission_dossiers_planifier_retirer
    ...  Planifier/retirer Des Dossiers
    ${di_id} =  Sans espace  ${dossier_instruction}
    Select Checkbox  css=tr#dossier_commission-${di_id} input[type='checkbox']
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Click Element  css=#ui-tabs-2 div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=#ui-tabs-2 div.message
    # On vérifie que le formulaire s'est bien validé
    Element Should Contain  css=#ui-tabs-2 .message .text
    ...  Mise à jour de la planification effectuée.
    La page ne doit pas contenir d'erreur


Rendre un avis sur dossier passé en commission
    [Documentation]  Rendre un avis sur dossier passé en commission.
    [Arguments]  ${avis}  ${dossier_instruction}  ${code_commission}

    Depuis le contexte de la commission  ${code_commission}
    # Affichage en visualisation du dossier qui est passé en commission
    Click Link  ${dossier_instruction}
    # On saisie le retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Input Text  css=textarea#avis  ${avis}
    # Validation du formulaire
    Click On Submit Button In Subform
    # La modification a bien été prise en compte
    Valid Message Should Be In Subform
    ...  Vos modifications ont bien été enregistrées.


Saisir la commission
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    # comportement AJAX : commission_type est filtré selon om_collectivite
    Sleep  0.5
    Si "commission_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_commission" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "heure_commission" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_adresse_ligne1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_adresse_ligne2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_salle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "listes_de_diffusion" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "participants" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_fichier_commission_ordre_jour" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_final_commission_ordre_jour" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_fichier_commission_compte_rendu" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_final_commission_compte_rendu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire


Depuis la demande de commission dans le contexte du dossier d'instruction

    [Documentation]

    [Arguments]  ${dossier_instruction}  ${commission}

    #
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    #
    On clique sur l'onglet  dossier_commission  Commission(s)
    # On clique sur la demande de commission
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Click On Link  ${commission}


Supprimer le suivi de la commission

    [Documentation]

    [Arguments]  ${commission}

    #
    Depuis le contexte de la commission  ${commission}
    # On clique sur l'action supprimer
    Click On Form Portlet Action    commission    supprimer
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  La suppression a été correctement effectuée.


Ajouter la commission depuis le contexte du dossier d'instruction

    [Documentation]  Permet d'ajouter la commission depuis le dossier d'instruction.

    [Arguments]  ${dossier_instruction}  ${type}  ${date}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    On clique sur l'onglet  dossier_commission  Commission(s)
    # On clique sur le bouton ajouter
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Click On Add Button JS
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Saisir la demande de commission  ${type}  ${date}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.


Saisir la demande de commission

    [Documentation]  Saisit le formulaire de la commission.

    [Arguments]  ${type}  ${date}

    Select From List By Label  commission_type  ${type}
    Input Datepicker  date_souhaitee  ${date}


Supprimer la demande de commission depuis le contexte du dossier d'instruction

    [Documentation]  Permet de supprimer le demande de passage en commission.

    [Arguments]  ${dossier_instruction}  ${commission}

    #
    Depuis la demande de commission dans le contexte du dossier d'instruction  ${dossier_instruction}  ${commission}
    # On clique sur laction supprimer
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Click On SubForm Portlet Action  dossier_commission  supprimer
    # On valide le formulaire
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Click On Submit Button In Subform
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  5 sec  0.2 sec  Valid Message Should Contain  La suppression a été correctement effectuée.
