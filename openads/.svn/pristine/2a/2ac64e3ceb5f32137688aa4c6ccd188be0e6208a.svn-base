*** Settings ***
Documentation    Extensions des mots clés pour la gestion des compteurs

*** Keywords ***

Ajouter compteur avec dates validité
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  compteur
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir compteur avec dates validité  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${compteur} =  Get Text  css=div.form-content span#compteur
    # On le retourne
    [Return]  ${compteur}


Depuis le contexte compteur avec dates validité
    [Documentation]  Accède au formulaire
    [Arguments]  ${compteur}

    # On accède au tableau
    Depuis le listing  compteur
    # Affiche les compteurs expirés
    Click On Link  css=a#action-tab-compteur-global-om_validite-false
    # On recherche l'enregistrement
    Use Simple Search  compteur  ${compteur}
    # On clique sur le résultat
    Click On Link  ${compteur}


Modifier compteur avec dates validité
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${compteur}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte compteur avec dates validité  ${compteur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  compteur  modifier
    # On saisit des valeurs
    Saisir compteur avec dates validité  ${values}
    # On valide le formulaire
    Click On Submit Button


Saisir compteur avec dates validité
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "unite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "quantite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "quota" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "alerte" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_modification" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire

Supprimer compteur avec dates validité
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${compteur}

    # On accède à l'enregistrement
    Depuis le contexte compteur avec dates validité  ${compteur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  compteur  supprimer
    # On valide le formulaire
    Click On Submit Button
