*** Settings ***
Documentation  Actions dans maildump

*** Keywords ***

Démarrer maildump
    [Documentation]  Permet de démarrer maildump
    Run  om-tests -c startsmtp

Arrêter maildump
    [Documentation]  Permet d'arrêter maildump
    Run  om-tests -c stopsmtp

Accéder à maildump
    [Documentation]  Permet d'accéder à maildump
    Go To  http://127.0.0.1:1080/

Sélectionner le mail à afficher
    [Arguments]  ${mail_id}
    [Documentation]  Permet de sélectionner le mail à afficher
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  //tr[@data-message-id]/td[text()="${mail_id}"]

Vérifier le contenu du mail
    [Documentation]  Permet de vérifier le contenu du message reçu
    [Arguments]  ${mail_id}  ${message}
    Sélectionner le mail à afficher  ${mail_id}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  link:HTML
    Select frame  //iframe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  //body  ${message}

Vérifier le sujet du mail
    [Documentation]  Permet de vérifier le contenu du message reçu depuis le contexte du mail
    [Arguments]  ${mail_id}  ${message}

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=dd.subject  ${message}

Vérifier que le contenu du mail ne contiens pas
    [Documentation]  Permet de vérifier le contenu du message reçu
    [Arguments]  ${mail_id}  ${message}
    Sélectionner le mail à afficher  ${mail_id}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  link:HTML
    Select frame  //iframe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  //body  ${message}

Verifier que le mail a bien été envoyé au destinataire
    [Arguments]  ${mail_id}
    Accéder à maildump
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  //tr[@data-message-id]/td[text()="${mail_id}"]

Verifier que les mails ont bien été envoyés au destinataire
    [Arguments]  ${mail_list}

    :FOR  ${mail}  IN  @{mail_list}
    \   Verifier que le mail a bien été envoyé au destinataire  ${mail}

Verifier que les mails n'ont pas été envoyés au destinataire
    [Arguments]  ${mail_list}

    Accéder à maildump
    :FOR  ${mail}  IN  @{mail_list}
    \   Page Should Not Contain  ${mail}

Vider la boite mail
    Accéder à maildump
    Element Should Be Visible  css=a[title="Delete all messages"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Link  css=a[title="Delete all messages"]
    Handle Alert