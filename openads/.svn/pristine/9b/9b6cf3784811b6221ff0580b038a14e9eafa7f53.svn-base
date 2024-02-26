*** Settings ***
Documentation    Actions spécifiques aux contraintes de référence du SIG

*** Keywords ***

Depuis le contexte de la contrainte de référence
    [Documentation]  Accède au formulaire
    [Arguments]  ${sig_contrainte}

    # On accède au tableau
    Depuis le listing  sig_contrainte
    # On recherche l'enregistrement
    Use Simple Search  Tous  ${sig_contrainte}
    # On clique sur le résultat
    Click On Link  ${sig_contrainte}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter la contrainte de référence
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  sig_contrainte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir la contrainte de référence  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${sig_contrainte} =  Get Text  css=div.form-content span#sig_contrainte
    # On le retourne
    [Return]  ${sig_contrainte}

Modifier la contrainte de référence
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${sig_contrainte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte de la contrainte de référence  ${sig_contrainte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  sig_contrainte  modifier
    # On saisit des valeurs
    Saisir la contrainte de référence  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer la contrainte de référence
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${sig_contrainte}

    # On accède à l'enregistrement
    Depuis le contexte de la contrainte de référence  ${sig_contrainte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  sig_contrainte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir la contrainte de référence
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "nature" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "groupe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "sousgroupe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "texte" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "texte_genere" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "no_ordre" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "service_consulte" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "sig_couche" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire

Ajouter le critère d'application de la contrainte de référence
    [Documentation]  Ajout un critère d'application à la contrainte de référence
    [Arguments]  ${sig_contrainte}  ${critere_application}

    # On accède à l'enregistrement
    Depuis le contexte de la contrainte de référence  ${sig_contrainte}
    # On accède à l'onglet Critères D'application
    On clique sur l'onglet  Critères D'application
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le critère d'application  ${critere_application}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${critere_application_id} =  Get Text  css=div.form-content span#
    # On le retourne
    [Return]  ${critere_application_id}

Saisir le critère d'application de la contrainte de référence
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "sig_attribut" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "valeur" existe dans "${values}" on execute "Input Text" dans le formulaire

Ajouter un evenement suggere à la contrainte de référence
    [Documentation]  Accède à une contrainte de référence, puis ajoute une suggestion
    ...  d'évènement depuis l'onglet "Évènements suggérés".
    [Arguments]  ${sig_contrainte}  ${evenement}

    # On accède à l'enregistrement
    Depuis le contexte de la contrainte de référence  ${sig_contrainte}
    # On accède à l'onglet "Évènements suggérés"
    On clique sur l'onglet  lien_sig_contrainte_evenement  Événements Suggérés
    # Clique sur le bouton d'ajout, remplit le formulaire et le valide
    Click On Add Button
    Select From Chosen List  evenement  ${evenement}
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement et on le retourne
    ${id_suggestion_evenement} =  Get Text  css=div.form-content span#lien_sig_contrainte_evenement
    [Return]  ${id_suggestion_evenement}
