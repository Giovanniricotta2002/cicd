*** Settings ***
Documentation    Extensions des mots clés pour la gestion des communes

*** Keywords ***

Ajouter commune avec dates validité
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  commune
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir commune avec dates validité  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${commune} =  Get Text  css=div.form-content span#commune
    # On le retourne
    [Return]  ${commune}

Saisir commune avec dates validité
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "typecom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "com" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dep" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "arr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tncc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ncc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "nccenr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "can" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "comparent" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Text" dans le formulaire
