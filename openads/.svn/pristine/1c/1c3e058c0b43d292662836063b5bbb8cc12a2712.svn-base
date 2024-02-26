*** Settings ***
Documentation     Actions spécifiques aux générations de bordereaux.

*** Keywords ***
Depuis le formulaire d'édition du bordereau d'envoi au maire

    # On accède au formulaire via le menu
    Go To Dashboard
    Go To Submenu In Menu  suivi  bordereau_envoi_maire
    # On vérifie que l'on s'y trouve
    Breadcrumb Should Be  Suivi > Suivi Des Pièces > Bordereau D'envoi Au Maire

Saisir le formulaire du bordereau d'envoi au maire
    [Arguments]  ${code_barres}=null  ${date_envoi}=null

    # On saisit le code-barres
    Run Keyword If  '${code_barres}' != 'null'  Input Text  code_barres  ${code_barres}
    # On saisit la date d'envoi du courrier pour signature par le maire
    Run Keyword If  '${date_envoi}' != 'null'  Input Datepicker  date  ${date_envoi}

Valider le formulaire du bordereau d'envoi au maire

    Click Element  css=div.formControls input.om-button[type='submit']