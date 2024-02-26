*** Settings ***
Documentation    CRUD de la table civilite
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte civilité
    [Documentation]  Accède au formulaire
    [Arguments]  ${civilite}

    # On accède au tableau
    Go To Tab  civilite
    # On recherche l'enregistrement
    Use Simple Search  civilité  ${civilite}
    # On clique sur le résultat
    Click On Link  ${civilite}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter civilité
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  civilite
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir civilité  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${civilite} =  Get Text  css=div.form-content span#civilite
    # On le retourne
    [Return]  ${civilite}

Modifier civilité
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${civilite}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte civilité  ${civilite}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  civilite  modifier
    # On saisit des valeurs
    Saisir civilité  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer civilité
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${civilite}

    # On accède à l'enregistrement
    Depuis le contexte civilité  ${civilite}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  civilite  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir civilité
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire