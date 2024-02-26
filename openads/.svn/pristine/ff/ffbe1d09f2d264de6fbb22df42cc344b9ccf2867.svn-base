*** Settings ***
Documentation    CRUD de la table dossier_message
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte dossier message
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_message}

    # On accède au tableau
    Go To Tab  dossier_message
    # On recherche l'enregistrement
    Use Simple Search  dossier message  ${dossier_message}
    # On clique sur le résultat
    Click On Link  ${dossier_message}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter dossier message
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_message
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir dossier message  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_message} =  Get Text  css=div.form-content span#dossier_message
    # On le retourne
    [Return]  ${dossier_message}

Modifier dossier message
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_message}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte dossier message  ${dossier_message}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_message  modifier
    # On saisit des valeurs
    Saisir dossier message  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer dossier message
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_message}

    # On accède à l'enregistrement
    Depuis le contexte dossier message  ${dossier_message}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_message  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir dossier message
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "emetteur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_emission" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "contenu" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "categorie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "destinataire" existe dans "${values}" on execute "Input Text" dans le formulaire