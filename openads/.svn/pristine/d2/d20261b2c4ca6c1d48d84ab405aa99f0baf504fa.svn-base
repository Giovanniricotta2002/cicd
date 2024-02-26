*** Settings ***
Documentation    CRUD de la table instruction_notification_document
...    @author  generated
...    @package openADS
...    @version 21/02/2022 17:02

*** Keywords ***

Depuis le contexte instruction_notification_document
    [Documentation]  Accède au formulaire
    [Arguments]  ${instruction_notification_document}

    # On accède au tableau
    Go To Tab  instruction_notification_document
    # On recherche l'enregistrement
    Use Simple Search  instruction_notification_document  ${instruction_notification_document}
    # On clique sur le résultat
    Click On Link  ${instruction_notification_document}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter instruction_notification_document
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  instruction_notification_document
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir instruction_notification_document  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${instruction_notification_document} =  Get Text  css=div.form-content span#instruction_notification_document
    # On le retourne
    [Return]  ${instruction_notification_document}

Modifier instruction_notification_document
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${instruction_notification_document}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte instruction_notification_document  ${instruction_notification_document}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  instruction_notification_document  modifier
    # On saisit des valeurs
    Saisir instruction_notification_document  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer instruction_notification_document
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${instruction_notification_document}

    # On accède à l'enregistrement
    Depuis le contexte instruction_notification_document  ${instruction_notification_document}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  instruction_notification_document  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir instruction_notification_document
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "instruction_notification" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "instruction" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "annexe" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "document_id" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "document_type" existe dans "${values}" on execute "Input Text" dans le formulaire