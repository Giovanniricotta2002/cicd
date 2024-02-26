*** Settings ***
Documentation    CRUD de la table service
...    @author  generated
...    @package openADS
...    @version 21/04/2021 14:04

*** Keywords ***

Depuis le contexte Service
    [Documentation]  Accède au formulaire
    [Arguments]  ${service}

    # On accède au tableau
    Go To Tab  service
    # On recherche l'enregistrement
    Use Simple Search  Service  ${service}
    # On clique sur le résultat
    Click On Link  ${service}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Service
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  service
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Service  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${service} =  Get Text  css=div.form-content span#service
    # On le retourne
    [Return]  ${service}

Modifier Service
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${service}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Service  ${service}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  service  modifier
    # On saisit des valeurs
    Saisir Service  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Service
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${service}

    # On accède à l'enregistrement
    Depuis le contexte Service  ${service}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  service  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Service
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "abrege" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ville" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "email" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "delai" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "consultation_papier" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "notification_email" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "type_consultation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "edition" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "delai_type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "service_type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "generate_edition" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "uid_platau_acteur" existe dans "${values}" on execute "Input Text" dans le formulaire