*** Settings ***
Documentation    CRUD de la table region
...    @author  generated
...    @package openADS
...    @version 23/10/2020 17:10

*** Keywords ***

Depuis le contexte région
    [Documentation]  Accède au formulaire
    [Arguments]  ${region}

    # On accède au tableau
    Go To Tab  region
    # On recherche l'enregistrement
    Use Simple Search  région  ${region}
    # On clique sur le résultat
    Click On Link  ${region}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter région
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  region
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir région  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${region} =  Get Text  css=div.form-content span#region
    # On le retourne
    [Return]  ${region}

Modifier région
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${region}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte région  ${region}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  region  modifier
    # On saisit des valeurs
    Saisir région  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer région
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${region}

    # On accède à l'enregistrement
    Depuis le contexte région  ${region}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  region  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir région
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cheflieu" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tncc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ncc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "nccenr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire