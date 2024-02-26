*** Settings ***
Documentation    CRUD de la table avis_decision

*** Keywords ***

Depuis le contexte de l'avis de décision
    [Documentation]  Accède au formulaire
    [Arguments]  ${avis_decision}

    # On accède au tableau
    Depuis le listing  avis_decision
    # On recherche l'enregistrement
    Use Simple Search  avis  ${avis_decision}
    # On clique sur le résultat
    Click On Link  ${avis_decision}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter l'avis de décision
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  avis_decision
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir l'avis de décision  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${avis_decision} =  Get Text  css=div.form-content span#avis_decision
    # On le retourne
    [Return]  ${avis_decision}

Modifier l'avis de décision
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${avis_decision}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte de l'avis de décision  ${avis_decision}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  avis_decision  modifier
    # On saisit des valeurs
    Saisir l'avis de décision  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer l'avis de décision
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${avis_decision}

    # On accède à l'enregistrement
    Depuis le contexte de l'avis de décision  ${avis_decision}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  avis_decision  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir l'avis de décision
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "typeavis" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "sitadel" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "sitadel_motif" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "tacite" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "avis_decision_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "avis_decision_nature" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "prescription" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
