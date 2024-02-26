*** Settings ***
Documentation  Actions spécifiques aux signataires d'arrêté.

*** Keywords ***

Depuis le tableau des signataires
    [Documentation]  Permet d'accéder au tableau des signataires.

    # On ouvre le tableau
    Depuis le listing  signataire_arrete

Depuis le contexte du signataire
    [Documentation]  Accède au formulaire
    [Arguments]  ${signataire_arrete}

    # On accède au tableau
    Depuis le tableau des signataires
    # On passe en recherche simple
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-classic-fields input.champFormulaire
    # On saisit l'id du signataire
    Input Text  css=div#adv-search-classic-fields input.champFormulaire  ${signataire_arrete}
    # On valide le formulaire de recherche
    Click On Search Button
    # On clique sur le résultat
    Click On Link  ${signataire_arrete}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter le signataire depuis le menu
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le tableau des signataires
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le signataire  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${signataire_arrete} =  Get Text  css=div.form-content span#signataire_arrete
    # On le retourne
    [Return]  ${signataire_arrete}

Modifier signataire
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${signataire_arrete}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte du signataire  ${signataire_arrete}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  signataire_arrete  modifier
    # On saisit des valeurs
    Saisir le signataire  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer signataire
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${signataire_arrete}

    # On accède à l'enregistrement
    Depuis le contexte du signataire  ${signataire_arrete}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  signataire_arrete  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir le signataire
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "civilite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "prenom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "qualite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "signature" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "defaut" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "email" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "signataire_habilitation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire

Depuis le contexte signataire_habilitation
    [Documentation]  Accède au formulaire
    [Arguments]  ${signataire_habilitation}

    # On accède au tableau
    Depuis le listing  signataire_habilitation
    # On recherche l'enregistrement
    Use Simple Search  signataire_habilitation  ${signataire_habilitation}
    # On clique sur le résultat
    Click On Link  ${signataire_habilitation}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter signataire_habilitation
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  signataire_habilitation
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir signataire_habilitation  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${signataire_habilitation} =  Get Text  css=div.form-content span#signataire_habilitation
    # On le retourne
    [Return]  ${signataire_habilitation}

Modifier signataire_habilitation
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${signataire_habilitation}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte signataire_habilitation  ${signataire_habilitation}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  signataire_habilitation  modifier
    # On saisit des valeurs
    Saisir signataire_habilitation  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer signataire_habilitation
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${signataire_habilitation}

    # On accède à l'enregistrement
    Depuis le contexte signataire_habilitation  ${signataire_habilitation}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  signataire_habilitation  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir signataire_habilitation
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire