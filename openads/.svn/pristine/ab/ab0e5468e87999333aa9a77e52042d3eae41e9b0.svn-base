*** Settings ***
Documentation     Actions spécifiques aux couches du SIG

*** Keywords ***

Depuis le contexte de la couche
    [Documentation]  Accède au formulaire
    [Arguments]  ${sig_couche}

    # On accède au tableau
    Depuis le listing  sig_couche
    # On recherche l'enregistrement
    Use Simple Search  couche  ${sig_couche}
    # On clique sur le résultat
    Click On Link  ${sig_couche}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter la couche
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  sig_couche
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir la couche  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${sig_couche} =  Get Text  css=div.form-content span#sig_couche
    # On le retourne
    [Return]  ${sig_couche}

Modifier la couche
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${sig_couche}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte de la couche  ${sig_couche}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  sig_couche  modifier
    # On saisit des valeurs
    Saisir la couche  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer la couche
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${sig_couche}

    # On accède à l'enregistrement
    Depuis le contexte de la couche  ${sig_couche}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  sig_couche  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir la couche
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "id_couche" existe dans "${values}" on execute "Input Text" dans le formulaire

Saisir l'attribut de référence
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "identifiant" existe dans "${values}" on execute "Input Text" dans le formulaire

Ajouter l'attribut de référence de la couche
    [Documentation]  Ajoute un attribut de référence à la couche
    [Arguments]  ${sig_couche}  ${sig_attribut}

    Depuis le contexte de la couche  ${sig_couche}
    # On accède à l'onglet Attributs De Références
    On clique sur l'onglet  Attributs De Références
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir l'attribut de référence  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${sig_attribut_id} =  Get Text  css=div.form-content span#sig_attribut
    # On le retourne
    [Return]  ${sig_attribut_id}

Supprimer l'attribut de référence de la couche
    [Documentation]  Ajoute un attribut de référence à la couche
    [Arguments]  ${sig_couche}  ${sig_attribut}

    Depuis le contexte de la couche  ${sig_couche}
    # On accède à l'onglet Attributs De Références
    On clique sur l'onglet  Attributs De Références
    # On cherche l'attribut dans la recherche dynamique
    Wait Until Element Is Visible  id=recherchedyn
    Input Text  id=recherchedyn  ${sig_attribut}
    Click Element  ${sig_attribut}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  sig_couche  supprimer
    # On valide le formulaire
    Click On Submit Button