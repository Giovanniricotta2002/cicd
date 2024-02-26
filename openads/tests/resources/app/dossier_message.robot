*** Settings ***
Documentation     Actions spécifiques aux pièces.

*** Keywords ***
Depuis le contexte du message dans le dossier d'instruction
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_instruction}  ${dossier_message}

    Depuis l'onglet des messages du dossier d'instruction  ${dossier_instruction}
    Click Element Until No More Element  xpath=//a[text()[contains(.,"${dossier_message}")]]


Marquer comme lu le message dans le dossier d'instruction
    [Documentation]  Marque comme lu le message
    [Arguments]  ${dossier_instruction}  ${dossier_message}

    # On accède à l'enregistrement
    Depuis le contexte du message dans le dossier d'instruction  ${dossier_instruction}  ${dossier_message}
    #
    Click On SubForm Portlet Action  dossier_message  marquer_comme_lu
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Le message a été marqué comme lu
    #
    Form Static Value Should Be  lu  Oui


Marquer comme non lu le message dans le dossier d'instruction
    [Documentation]  Marque comme non lu le message
    [Arguments]  ${dossier_instruction}  ${dossier_message}

    # On accède à l'enregistrement
    Depuis le contexte du message dans le dossier d'instruction  ${dossier_instruction}  ${dossier_message}
    #
    Click On SubForm Portlet Action  dossier_message  marquer_comme_non_lu
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Le message a été marqué comme non lu
    #
    Form Static Value Should Be  lu  Non


Supprimer le message dans le dossier d'instruction
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_instruction}  ${dossier_message}

    # On accède à l'enregistrement
    Depuis le contexte du message dans le dossier d'instruction  ${dossier_instruction}  ${dossier_message}
    # On clique sur le bouton supprimer
    Click On SubForm Portlet Action  dossier_message  supprimer
    # On valide le formulaire
    Click On Submit Button

Ajouter un message dans le dossier d'instruction
    [Documentation]  Ajoute un enregistrement
    [Arguments]  ${dossier_instruction}  ${message_content}

    # On accède à l'enregistrement
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    On clique sur l'onglet  dossier_message  Message(s)
    Click On Add Button
    Input Text  contenu  ${message_content}
    # On valide le formulaire
    Click On Submit Button

    ${dossier_message} =  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Get Text  css=span#dossier_message.field_value

    #Retour sur l'onglet
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    On clique sur l'onglet  dossier_message  Message(s)

    [Return]  ${dossier_message}

