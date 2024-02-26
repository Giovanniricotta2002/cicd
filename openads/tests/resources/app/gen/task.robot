*** Settings ***
Documentation    CRUD de la table task
...    @author  generated
...    @package openADS
...    @version 25/07/2022 12:07

*** Keywords ***

Depuis le contexte tâche
    [Documentation]  Accède au formulaire
    [Arguments]  ${task}

    # On accède au tableau
    Go To Tab  task
    # On recherche l'enregistrement
    Use Simple Search  tâche  ${task}
    # On clique sur le résultat
    Click On Link  ${task}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter tâche
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  task
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir tâche  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${task} =  Get Text  css=div.form-content span#task
    # On le retourne
    [Return]  ${task}

Modifier tâche
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${task}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte tâche  ${task}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  task  modifier
    # On saisit des valeurs
    Saisir tâche  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer tâche
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${task}

    # On accède à l'enregistrement
    Depuis le contexte tâche  ${task}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  task  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir tâche
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "timestamp_log" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "state" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "object_id" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "json_payload" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "stream" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "category" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "creation_date" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "creation_time" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "last_modification_date" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "last_modification_time" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "comment" existe dans "${values}" on execute "Input Text" dans le formulaire