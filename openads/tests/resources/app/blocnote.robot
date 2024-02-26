*** Settings ***
Documentation  Actions spécifiques aux bloc-notes.

*** Keywords ***
Ajouter le bloc-note depuis le contexte du dossier d'instruction
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${di}  ${values}

    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  blocnote  Bloc-note
    Click On Add Button JS
    Saisir le bloc-note  ${values}
    Click On Submit Button In Subform
    La page ne doit pas contenir d'erreur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.


Saisir le bloc-note
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "categorie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "note" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
