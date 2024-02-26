*** Settings ***
Documentation    Surcharge CRUD de la table quartier

*** Keywords ***

Ajouter le quartier
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  quartier
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le quartier  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${quartier} =  Get Text  css=div.form-content span#quartier
    # On le retourne
    [Return]  ${quartier}

Saisir le quartier
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "arrondissement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "code_impots" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
