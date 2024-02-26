*** Settings ***
Documentation     Actions spécifiques aux demandeurs

*** Keywords ***
Ajouter le pétitionnaire fréquent depuis le menu pétitionnaire fréquent
    [Arguments]  ${petitionnaire_values}

    Click On Add Button
    # On remplit le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Saisir le pétitionnaire fréquent  ${petitionnaire_values}
    # On valide
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    # On ferme l'overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Back Button


Depuis le tableau des pétitionnaires fréquents

    [Documentation]  Permet d'accéder au tableau des pétitionnaires fréquents.

    # On ouvre le tableau
    Depuis le listing  petitionnaire_frequent


Depuis le contexte du pétitionnaire fréquent

    [Documentation]  Permet d'accéder au formulaire en consultation
    ...    d'une pétitionnaire fréquent.

    [Arguments]  ${nom}=null

    # On ouvre le tableau des pétitionnaires fréquents
    Depuis le tableau des pétitionnaires fréquents
    # On recherche le pétitionnaire fréquent
    Run Keyword If  '${nom}' != 'null'  Use Simple Search  nom  ${nom}
    Run Keyword If  '${nom}' != 'null'  Click On Link  ${nom}