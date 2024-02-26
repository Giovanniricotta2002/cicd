*** Settings ***
Documentation  dossier_commission.

*** Keywords ***
Depuis l'onglet commission(s) du dossier d'instruction
    [Arguments]  ${dossier}

    Depuis le contexte du dossier d'instruction  ${dossier}
    On clique sur l'onglet  dossier_commission  Commission(s)


Saisir la demande de passage en commission
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "commission_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_souhaitee" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "motivation" existe dans "${values}" on execute "Input Text" dans le formulaire


