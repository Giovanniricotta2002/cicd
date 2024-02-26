*** Settings ***
Documentation  Actions spécifiques aux événements d'instruction.

*** Keywords ***
Depuis le tableau des événements
    [Documentation]  Permet d'accéder au listing des événements.

    # On ouvre le tableau
    Depuis le listing  evenement

Saisir l'événement
    [Arguments]  ${values}

    # On saisit le libellé (obligatoire)
    Input Text  libelle  ${values.libelle}

    # autres champs (optionels)
    Si "accord_tacite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "action" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "autorite_competente" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "avis_decision" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "consultation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "delai" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "delai_notification" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire
    Si "etat" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "etats_depuis_lequel_l_evenement_est_disponible" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire
    Si "evenement_retour_ar" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "evenement_retour_signature" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "evenement_suivant_tacite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "lettretype" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "non_verrouillable" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "phase" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "restriction" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "retour" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "finaliser_automatiquement" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "pec_metier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "commentaire" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "non_modifiable" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "non_supprimable" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "notification" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "notification_service" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "notification_tiers" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "type_habilitation_tiers_consulte" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire
    Si "envoi_cl_platau" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "signataire_obligatoire" existe dans "${values}" on execute "Set Checkbox" dans le formulaire

Ajouter l'événement depuis le menu
    [Arguments]  ${values}

    Depuis le formulaire d'ajout de l'événement
    # On remplit le formulaire
    Saisir l'événement  ${values}
    # On valide
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    # On récupère l'ID du nouvel enregistrement
    ${evenement} =  Get Text  css=div.form-content span#evenement
    # On le retourne
    [Return]  ${evenement}

Depuis le formulaire d'ajout de l'événement
    [Arguments]

    # On ouvre le tableau des événements
    Depuis le tableau des événements
    # On clique sur l'icone ajouter
    Click On Add Button

Depuis le contexte de l'événement
    [Documentation]  Permet d'accéder au formulaire en consultation
    ...    d'un événement.
    [Arguments]  ${libelle}

    # On ouvre le tableau des événements
    Depuis le tableau des événements
    # On recherche l'événement
    Use Simple Search  libellé  ${libelle}
    # On clique sur l'événement
    Click On Link  ${libelle}

Modifier l'événement
    [Arguments]  ${values}

    Depuis le formulaire de modification de l'événement  ${values.libelle}
    # On remplit le formulaire
    Saisir l'événement  ${values}
    # On valide
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Depuis le formulaire de modification de l'événement
    [Arguments]  ${libelle}

    # On accède à la fiche de l'événement
    Depuis le contexte de l'événement  ${libelle}
    # On clique sur l'action modifier
    Click On Form Portlet Action  evenement  modifier

Supprimer l'événement
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${evenement}

    Depuis le formulaire de suppression de l'événement
    # On valide le formulaire
    Click On Submit Button

Depuis le formulaire de suppression de l'événement
    [Arguments]  ${evenement}

    # On accède à l'enregistrement
    Depuis le contexte de l'événement  ${evenement}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  evenement  supprimer

Saisir l'action
    [Arguments]  ${values}

    ${items}=  Get Dictionary Items  ${values}
    :FOR  ${key}  ${value}  IN  @{items}
    \  Input Text  ${key}  ${value}


Ajouter l'action depuis le menu
    [Arguments]  ${values}

    # On ouvre le tableau des événements
    Depuis le tableau des actions
    # On clique sur l'icone ajouter
    Click On Add Button
    # On remplit le formulaire
    Saisir l'action  ${values}
    # On valide
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Depuis le tableau des actions
    [Documentation]  Permet d'accéder au listing des événements.

    # On ouvre le tableau
    Depuis le listing  action
