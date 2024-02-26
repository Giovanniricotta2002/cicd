*** Settings ***
Documentation    Surcharge CRUD de la table arrondissement

*** Keywords ***

Ajouter l'arrondissement
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  arrondissement
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir l'arrondissement  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${arrondissement} =  Get Text  css=div.form-content span#arrondissement
    # On le retourne
    [Return]  ${arrondissement}

Saisir l'arrondissement
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code_postal" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code_impots" existe dans "${values}" on execute "Input Text" dans le formulaire
