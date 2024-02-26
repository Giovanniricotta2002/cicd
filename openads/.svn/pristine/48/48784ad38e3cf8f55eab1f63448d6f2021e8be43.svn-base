*** Settings ***
Documentation     Actions spécifiques aux services

*** Keywords ***
Ajouter le service depuis le listing
    [Arguments]  ${values}

    # On ouvre le tableau des services
    Depuis le tableau des services
    # On clique sur l'icone ajouter
    Click On Add Button
    # On remplit le formulaire
    Saisir le service  ${values}
    # On valide
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur

Depuis le contexte du service
    [Documentation]  Permet d'accéder au formulaire en consultation
    ...    d'un service.
    [Arguments]  ${libelle}=null  ${abrege}=null

    # On ouvre le tableau des services
    Depuis le tableau des services
    # On recherche la collectivité
    Run Keyword If    '${abrege}' != 'null'    Use Simple Search    abrégé    ${abrege}    ELSE IF    '${libelle}' != 'null'    Use Simple Search    libellé    ${libelle}    ELSE    Fail
    # On clique sur la collectivité
    Run Keyword If    '${abrege}' != 'null'    Click On Link    ${abrege}    ELSE IF    '${libelle}' != 'null'    Click On Link    ${libelle}    ELSE    Fail

Depuis le tableau des services
    [Documentation]  Permet d'accéder au listing des services.

    # On ouvre le tableau
    Depuis le listing  service

Modifier le service
    [Arguments]  ${abrege_actuel}  ${libelle_actuel}  ${values}

    # On accède au service souhaité
    Depuis le contexte du service  ${libelle_actuel}  ${abrege_actuel}
    #On clique sur l'action modifier
    Click On Form Portlet Action  service  modifier
    # On remplit le formulaire
    Saisir le service  ${values}
    # On valide
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur

Saisir le service
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
    Si "type_consultation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "edition" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "delai_type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "service_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "generate_edition" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "uid_platau_acteur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "accepte_notification_email" existe dans "${values}" on execute "Set Checkbox" dans le formulaire

Ajouter lien service/utilisateur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  lien_service_om_utilisateur
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien service/utilisateur  ${values}
    # On valide le formulaire
    Click On Submit Button


Saisir lien service/utilisateur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "om_utilisateur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "service" existe dans "${values}" on execute "Select From List By Label" dans le formulaire

