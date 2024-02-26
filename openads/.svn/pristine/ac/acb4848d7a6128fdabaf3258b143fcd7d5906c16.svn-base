*** Settings ***
Documentation    CRUD de la table consultation_entrante
...    @author  generated
...    @package openADS
...    @version 14/10/2021 15:10

*** Keywords ***

Depuis le contexte consultation entrante
    [Documentation]  Accède au formulaire
    [Arguments]  ${consultation_entrante}

    # On accède au tableau
    Go To Tab  consultation_entrante
    # On recherche l'enregistrement
    Use Simple Search  consultation entrante  ${consultation_entrante}
    # On clique sur le résultat
    Click On Link  ${consultation_entrante}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter consultation entrante
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  consultation_entrante
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir consultation entrante  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${consultation_entrante} =  Get Text  css=div.form-content span#consultation_entrante
    # On le retourne
    [Return]  ${consultation_entrante}

Modifier consultation entrante
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${consultation_entrante}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte consultation entrante  ${consultation_entrante}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  consultation_entrante  modifier
    # On saisit des valeurs
    Saisir consultation entrante  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer consultation entrante
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${consultation_entrante}

    # On accède à l'enregistrement
    Depuis le contexte consultation entrante  ${consultation_entrante}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  consultation_entrante  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir consultation entrante
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "delai_reponse" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_consultation" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_emission" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "service_consultant_id" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "service_consultant_libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "service_consultant_insee" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "service_consultant_mail" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "service_consultant_type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "service_consultant__siren" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "etat_consultation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "type_consultation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "texte_fondement_reglementaire" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "texte_objet_consultation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "type_delai" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "objet_consultation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_production_notification" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "date_premiere_consultation" existe dans "${values}" on execute "Input Datepicker" dans le formulaire