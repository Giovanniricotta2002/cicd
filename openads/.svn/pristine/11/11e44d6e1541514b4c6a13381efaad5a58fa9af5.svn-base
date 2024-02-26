*** Settings ***
Documentation  Actions dans un formulaire

*** Keywords ***
Form Value Should Contain
    [Tags]
    [Arguments]  ${champ}  ${valeurAttendue}
    ${valeurRecuperee} =  Get Value  ${champ}
    Should Contain  ${valeurRecuperee}  ${valeurAttendue}

Form Static Value Should Contain
    [Tags]
    [Arguments]  ${champ}  ${valeurAttendue}
    ${valeurRecuperee} =  Get Text  ${champ}
    Should Contain  ${valeurRecuperee}  ${valeurAttendue}

Wait Until Form Value Should Be
    [Tags]
    [Arguments]  ${champ}  ${valeurAttendue}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  ${champ}  ${valeurAttendue}

Select From Chosen List For 'Type' By Name
    [Arguments]  ${field_id}  ${value}
    Select From Chosen List  css=#${field_id}  [${value}]

Select From Chosen List For 'Catégorie' By Name
    [Arguments]  ${field_id}  ${value}
    Select From Chosen List  css=#${field_id}  [${value}]

Selected Label From Chosen List Should Be
    [Arguments]  ${field_id}  ${value}
    ${label_selected} =  Get Text  ${field_id}_chosen span
    Should Be Equal As Strings  ${label_selected}  ${value}

Select From Chosen List
    [Arguments]  ${field_id}  ${value}
    # saisir la recherche
    Input text until text is correct  css=div#${field_id}_chosen input.chosen-search-input  ${value}
    # vérifie que l'élément recherché fait partie de la liste des résulats
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=div#${field_id}_chosen div.chosen-drop ul.chosen-results li.active-result
    ...  ${value}
    # construit le sélecteur du résultat
    ${result_selector} =  Set Variable  xpath=//div[@id = "${field_id}_chosen"]/div[contains(@class, "chosen-drop")]/ul[contains(@class, "chosen-results")]/li[contains(@class, "active-result")]/em[text()="${value}"]
    # vérifie que l'élément recherché existe et correspond
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Page Should Contain Element  ${result_selector}
    # clic sur le résultat
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Click Element Until No More Element  ${result_selector}
    # vérifie que c'est bien ce qui a été sélectionné comme valeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Text Should Be  css=div#${field_id}_chosen .chosen-single.chosen-single-with-deselect span
    ...  ${value}
    Page Should Contain Element  xpath=//div[@id = "${field_id}_chosen"]/div[contains(@class, "chosen-drop")]/ul[contains(@class, "chosen-results")]/li[contains(@class, "result-selected")]/em[text()="${value}"]

Select From Multiple Chosen List
    [Arguments]  ${field_id}  ${values}
    Click Element  ${field_id}_chosen
    :FOR  ${ELEMENT}  IN  @{values}
    \  Input text until text is correct  css=div#${field_id}_chosen input.chosen-search-input  ${ELEMENT}
    \  Press Key  css=#${field_id}_chosen input.chosen-search-input  \\13

Input text until text is correct
    [Documentation]  Saisi un texte dans un input en utilisant le keywodr "input text".
    ...  Vérifie si le texte est bien visible dans le champs. Si ce n'est pas le cas
    ...  réintére l'opération maximum 3 fois.
    ...  Ce keyword sert, dans le cas de la saisie de texte pour les champs chosen, à s'assurer
    ...  que le texte a bien été saisi.
    [Arguments]  ${input_locator}  ${value}

    :FOR  ${INDEX}  IN RANGE  1  4
    \  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    \  ...  Input Text  ${input_locator}  ${value}
    \  # récupère la valeur de la saisie
    \  ${value_inputed} =  Get Value  ${input_locator}
    \  # vérifie que la valeur a été saisie correctement et si c'est le cas on sort de la boucle
    \  Exit For Loop If  "${value}" == "${value_inputed}"
    Run Keyword If  ${INDEX} == 3  Fail  La saisie de la valeur '${value}' a échoué pour le champ '${field_id}'.

Unselect From Chosen List
    [Arguments]  ${field_id}
    Click Element  ${field_id}_chosen .search-choice-close

Unselect From Multiple Chosen List
    [Arguments]  ${field_id}  ${values}

    :FOR  ${ELEMENT}  IN  @{values}
    \  Click Element  xpath=//span[text()="${ELEMENT}"]/following::a[contains(@class, "search-choice-close")]

Unselect Multiple By Label
    [Tags]
    [Documentation]    Désélectionne une liste de libellés si non vide
    [Arguments]  ${champ}  ${list}
    ${length} =  Get Length  ${list}
    Run Keyword If  ${length} > 0  Unselect From List By Label  ${champ}  @{list}


Select From Chosen List Should Contain
    [Arguments]  ${field_id}  ${value}
    # saisir la recherche
    :FOR  ${INDEX}  IN RANGE  1  4
    \   Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    \   ...  Input text until text is correct  css=div#${field_id}_chosen input.chosen-search-input  ${value}
    \   # récupère la valeur de la saisie
    \   ${value_inputed} =  Get Value  css=div#${field_id}_chosen input.chosen-search-input
    \   # vérifie que l'élément recherché fait partie de la liste des résulats
    \   Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    \   ...  Element Text Should Be  css=div#${field_id}_chosen div.chosen-drop ul.chosen-results li.active-result
    \   ...  ${value}
 
Select From Chosen List Should Not Contain
    [Arguments]  ${field_id}  ${value}
    # saisir la recherche
    :FOR  ${INDEX}  IN RANGE  1  4
    \  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    \  ...  Input text until text is correct  css=div#${field_id}_chosen input.chosen-search-input  ${value}
    \  # récupère la valeur de la saisie
    \  ${value_inputed} =  Get Value  css=div#${field_id}_chosen input.chosen-search-input
    \  # vérifie qu'aucun résultat n'apparaît dans la liste
    \  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    \  ...  Element Text Should Be  css=div#${field_id}_chosen div.chosen-drop ul.chosen-results li.no-results
    \  ...  Aucun résultat ${value}

Select From Chosen List Should Contain List
    [Arguments]  ${field_id}  ${values}
    # saisir la recherche
    :FOR  ${value}  IN  ${values}
    \   Select From Chosen List Should Contain  ${field_id}  ${value}

Select Multiple From Chosen List Should Contain List
    [Arguments]  ${field_id}  ${values}
    # saisir la recherche
    :FOR  ${value}  IN  @{values}
    \   Select From Chosen List Should Contain  ${field_id}  ${value}
 
Select From Chosen List Should Not Contain List
    [Arguments]  ${field_id}  ${value}
    # saisir la recherche
    :FOR  ${value}  IN  ${values}
    \  Select From Chosen List Should Not Contain  ${field_id}  ${value}

Select Multiple From Chosen List Should Not Contain List
    [Arguments]  ${field_id}  ${values}
    # saisir la recherche
    :FOR  ${value}  IN  @{values}
    \  Select From Chosen List Should Not Contain  ${field_id}  ${value}