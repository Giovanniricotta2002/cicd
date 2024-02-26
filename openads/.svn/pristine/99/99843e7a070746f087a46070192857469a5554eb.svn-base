*** Settings ***
Documentation  Actions spécifiques aux phases.

*** Keywords ***

Depuis le contexte de la phase
    [Documentation]  Accède au formulaire
    [Arguments]  ${phase}

    # On accède au tableau
    Depuis le listing  phase
    # On recherche l'enregistrement
    Use Simple Search  phase  ${phase}
    # On clique sur le résultat
    Click On Link  ${phase}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter la phase
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  phase
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir la phase  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Modifier la phase
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${phase}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte de la phase  ${phase}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  phase  modifier
    # On saisit des valeurs
    Saisir la phase  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Supprimer la phase
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${phase}

    # On accède à l'enregistrement
    Depuis le contexte de la phase  ${phase}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  phase  supprimer
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  La suppression a été correctement effectuée.

Saisir la phase
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
