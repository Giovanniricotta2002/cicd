*** Settings ***
Documentation  Actions relatives aux imports spécifiques de fichiers CSV.

*** Keywords ***
Depuis l'import spécifique
    [Arguments]    ${obj}
    Go To    ${PROJECT_URL}app/import_specific.php?obj=${obj}
    Wait Until Keyword Succeeds     5 sec     0.2 sec    La page ne doit pas contenir d'erreur

Résultat de l'import doit contenir
    [Arguments]    ${content}
    Wait Until Element Is Visible    css=div#content div.message p span.text
    Element Should Contain    css=div#content div.message p span.text    ${content}
