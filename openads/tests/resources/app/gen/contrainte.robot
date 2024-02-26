*** Settings ***
Documentation    CRUD de la table contrainte
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte contrainte
    [Documentation]  Accède au formulaire
    [Arguments]  ${contrainte}

    # On accède au tableau
    Go To Tab  contrainte
    # On recherche l'enregistrement
    Use Simple Search  contrainte  ${contrainte}
    # On clique sur le résultat
    Click On Link  ${contrainte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter contrainte
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  contrainte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir contrainte  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${contrainte} =  Get Text  css=div.form-content span#contrainte
    # On le retourne
    [Return]  ${contrainte}

Modifier contrainte
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${contrainte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte contrainte  ${contrainte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  contrainte  modifier
    # On saisit des valeurs
    Saisir contrainte  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer contrainte
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${contrainte}

    # On accède à l'enregistrement
    Depuis le contexte contrainte  ${contrainte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  contrainte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir contrainte
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