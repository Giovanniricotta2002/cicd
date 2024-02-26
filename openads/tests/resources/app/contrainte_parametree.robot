*** Settings ***
Documentation    CRUD des contraintes du paramétrage

*** Keywords ***
Depuis le contexte contrainte paramétrée
    [Documentation]  Accède au formulaire
    [Arguments]  ${contrainte}

    # On accède au tableau
    Depuis le listing  contrainte
    # On recherche l'enregistrement
    Use Simple Search  libellé  ${contrainte}
    # On clique sur le résultat
    Click On Link  ${contrainte}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter contrainte paramétrée
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  contrainte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir contrainte paramétrée  ${values}
    # On valide le formulaire
    Click On Submit Button

Modifier contrainte paramétrée
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${contrainte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte contrainte paramétrée  ${contrainte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  contrainte  modifier
    # On saisit des valeurs
    Saisir contrainte paramétrée  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer contrainte paramétrée
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${contrainte}

    # On accède à l'enregistrement
    Depuis le contexte contrainte paramétrée  ${contrainte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  contrainte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir contrainte paramétrée
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "numero" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "nature" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "groupe" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "sousgroupe" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "texte" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "no_ordre" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "reference" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "service_consulte" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
