*** Settings ***
Documentation  Surcharge des keywords de bas niveau

*** Keywords ***
La page ne doit pas contenir d'erreur
    Page Should Not Contain  Erreur de base de données.
    Page Should Not Contain Element  css=table.xdebug-error

Click Element Until Message
    [Tags]
    [Documentation]  Clique sur un élément jusqu'à ce qu'un message apparaisse
    [Arguments]      ${elm_clicked}  ${message}  ${elm_message}=None

    # Vérifie que l'élément à cliquer est visible
    Element Should Be Visible  ${elm_clicked}

    # Vérifie qu'aucun message ne contient actuellement le message recherché
    No Message Should Be  ${message}

    # 3 essais de clic sur l'élément (passé en paramètre)
    :FOR  ${INDEX}  IN RANGE  1  4
    \
    \  # attente du succès du clic pendant 3 secondes max
    \  Wait Until Keyword Succeeds     3     ${RETRY_INTERVAL}    Click Element  ${elm_clicked}
    \
    \  # attente de l'apparition du message pendant quelques secondes
    \  ${msg_found}=  Run Keyword And Return Status
    \  ...  Run Keyword If  "${elm_message}" != "None"
    \  ...     Wait Until Keyword Succeeds  ${CLIC_CONFIRM_WAIT}  ${RETRY_INTERVAL}  Element Should Contain  ${elm_message}  ${message}
    \  ...  ELSE
    \  ...     Wait Until Keyword Succeeds  ${CLIC_CONFIRM_WAIT}  ${RETRY_INTERVAL}  One Of Messages Should Be  ${message}
    \
    \  # si on a détecté le message, on sort de la boucle
    \  Run Keyword If  ${msg_found}  Return From Keyword
    Run Keyword If  ${INDEX} == 3  Fail  Le clic sur '${elm_clicked}' a échoué

Click On Submit Button In Subform Until Message
    [Tags]
    [Documentation]  Clic sur le bouton de confirmation jusqu'à ce qu'un message
    ...              apparaisse
    [Arguments]  ${message}  ${elm_message}=None
    Run Keyword If  "${elm_message}" != "None"
    ...  Click Element Until Message  css=#sformulaire div.formControls input[type="submit"]  ${message}  ${elm_message}
    ...  ELSE  Click Element Until Message  css=#sformulaire div.formControls input[type="submit"]  ${message}  css=#sformulaire div.message


Rechercher en recherche avancée simple
    [Documentation]
    [Tags]
    [Arguments]  ${terme}
    ${passed} =     Run Keyword And Return Status  Element Should Contain  css=#advanced-form legend  Afficher la recherche simple
    Run Keyword If  ${passed}  Click Element  css=#toggle-advanced-display
    Input Text  css=#adv-search-classic-fields input  ${terme}
    Click Element  adv-search-submit


Depuis le contexte de l'utilisateur
    [Tags]  om_utilisateur
    [Documentation]  Accède à la fiche de consultation de l'utilisateur.
    [Arguments]  ${login}=null  ${email}=null

    Depuis le listing des utilisateurs
    # On recherche l'utilisateur
    Run Keyword If    '${login}' != 'null'    Rechercher en recherche avancée simple  ${login}    ELSE IF    '${email}' != 'null'    Rechercher en recherche avancée simple  ${email}    ELSE    Fail
    # On clique sur l'utilisateur
    Run Keyword If    '${login}' != 'null'    Click On Link    ${login}    ELSE IF    '${email}' != 'null'    Click On Link    ${email}    ELSE    Fail


Open Fieldset Using Javascript
    [Tags]
    [Documentation]    Déplie un fieldset en utilisant javascript
    [Arguments]    ${obj}    ${fieldset}

    # Vérifie que le fieldset est bien chargé
    Wait Until Page Contains Element  css=#fieldset-${obj}-${fieldset}
    # Ouvre le fieldset et affiche son contenu
    Execute Javascript  window.jQuery("#fieldset-${obj}-${fieldset}").removeClass("collapsed")
    Execute Javascript  window.jQuery("#fieldset-${obj}-${fieldset} legend").removeClass("collapsed")
    Execute Javascript  window.jQuery("#fieldset-${obj}-${fieldset} div.fieldsetContent").show()
    # Vérifications que le fieldset est correctement ouvert
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=#fieldset-${obj}-${fieldset} div.fieldsetContent
    # Temporisation nécessaire pour que le contenu du fieldset soit correctement affiché
    Sleep  0.5


Open All Fieldset Using Javascript
    [Tags]
    [Documentation]    Déplie tous les fieldsets d'un formulaire ou sous formulaire
    ...  en utilisant javascript
    [Arguments]    ${obj}  ${typeForm}=form

    # Vérifie que les fieldsets sont bien chargés
    Wait Until Page Contains Element  css=fieldset[id^=fieldset-${typeForm}-${obj}]
    # Ouvre tous les fieldsets et affiche leur contenu
    Execute Javascript  window.jQuery("fieldset[id^=fieldset-${typeForm}-${obj}]").removeClass("collapsed")
    Execute Javascript  window.jQuery("fieldset[id^=fieldset-${typeForm}-${obj}] legend").removeClass("collapsed")
    Execute Javascript  window.jQuery("fieldset[id^=fieldset-${typeForm}-${obj}] div.fieldsetContent").show()
    # Vérifications que le fieldset est correctement ouvert
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=fieldset[id^=fieldset-${typeForm}-${obj}] div.fieldsetContent
    # Temporisation nécessaire pour que le contenu du fieldset soit correctement affiché
    Sleep  0.5

Manual Open Fieldset
    [Tags]
    [Documentation]    Déplie un fieldset en cliquant sur le bouton d'ouverture du fieldset
    [Arguments]    ${obj}    ${fieldset}
    
    # Vérifie que le fieldset est bien chargé
    Wait Until Page Contains Element  css=#fieldset-${obj}-${fieldset}
    # Ouvre le fieldset et affiche son contenu
    Click Element Until New Element
    ...  css=#fieldset-${obj}-${fieldset} > legend.collapsible
    ...  css=#fieldset-${obj}-${fieldset} > .fieldsetContent
    # Vérifications que le fieldset est correctement ouvert
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...   Element Should Not Be Visible  css=#fieldset-form-${obj}-${fieldset} > legend.collapsed
    # Temporisation nécessaire pour que le contenu du fieldset soit correctement affiché
    Sleep  0.5

Open Fieldset
    [Tags]
    [Documentation]    Déplie un fieldset de formulaire en utilisant le mode
    ...  d'ouverture voulu (javascript par défaut)
    [Arguments]    ${obj}    ${fieldset}   ${open_mode}=js

    # passe form devant le nom de l'objet pour pouvoir réutiliser le keyword d'ouverture
    # de fieldset existant
    Run Keyword If  '${open_mode}' == 'js'
    ...  Open Fieldset Using Javascript  form-${obj}   ${fieldset}
    ...  ELSE  Manual Open Fieldset  form-${obj}   ${fieldset}


Open Fieldset In Subform
    [Tags]
    [Documentation]    Déplie un fieldset de sous formulaire en le mode
    ...  d'ouverture voulu (javascript par défaut)
    [Arguments]    ${obj}    ${fieldset}   ${open_mode}=js

    # passe sousform devant le nom de l'objet pour pouvoir réutiliser le keyword d'ouverture
    # de fieldset existant
    Run Keyword If  '${open_mode}' == 'js'
    ...  Open Fieldset Using Javascript  sousform-${obj}   ${fieldset}
    ...  ELSE  Manual Open Fieldset  sousform-${obj}   ${fieldset}

Click On Portlet Action
    [Tags]
    [Arguments]  ${obj}  ${action}  ${sousform}=False  ${mode}=None  ${message}=None
    # si le mode de confirmation est
    #   new_window: vérifie qu'une nouvelle fenêtre est apparue
    #   modale    : vérifie qu'une fenêtre modale est apparue
    #   message   : vérifie qu'un message est apparu
    #   *         : vérifie que l'élément cliqué a disparu
    ${selector} =  Set Variable If  ${sousform}  css=#action-sousform-${obj}-${action}
    ...                                          css=#action-form-${obj}-${action}
    # Attend que l'action soit visible avant de cliquer dessus
    Wait Until Page Contains Element  ${selector}
    Run Keyword If  '${mode}' == 'new_window'  Click Element Until New Window       ${selector}
    ...    ELSE IF  '${mode}' == 'modale'      Click Element Until New Element      ${selector}  css=.ui-widget-overlay
    ...    ELSE IF  '${mode}' == 'message'     Click Element Until Message          ${selector}  ${message}
    ...    ELSE                                Click Element Until No More Element  ${selector}


Depuis la page d'accueil
    [Tags]
    [Arguments]  ${username}  ${password}
    [Documentation]    L'objet de ce 'Keyword' est de positionner l'utilisateur
    ...    sur la page de login ou son tableau de bord si on le fait se connecter.

    # On accède à la page d'accueil
    Go To  ${PROJECT_URL}
    La page ne doit pas contenir d'erreur

    # On vérifie si un utilisateur est connecté ou non
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#title h2
    ${titre} =  Get Text  css=#title h2
    ${is_connected} =  Evaluate  "${titre}"!="veuillez vous connecter"

    # On récupère le login de l'utilisateur si un utilisateur est connecté
    ${connected_login} =  Set Variable  None
    ${connected_login} =  Run Keyword If  "${is_connected}"=="True"  Get Text  css=#actions li.action-login

    # L'utilisateur souhaité est déjà connecté, on sort
    Run Keyword If  "${connected_login}"=="${username}"  Return From Keyword  L'utilisateur souhaité est déjà connecté.

    # On se déconnecte si un utilisateur est déjà connecté
    Run Keyword If  "${is_connected}"=="True"  Click Link  css=#actions a.actions-logout

    # On vérifie si l'utilisateur est connecté ou non
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#title h2
    ${titre} =  Get Text  css=#title h2
    ${is_connected} =  Evaluate  "${titre}"!="veuillez vous connecter"

    # On s'authentifie avec le nouvel utilisateur
    S'authentifier  ${username}  ${password}



Ouvrir le navigateur
    [Tags]  global
    [Arguments]    ${width}=1024    ${height}=768
    Open Browser    ${PROJECT_URL}    ${BROWSER}
    Set Window Size    ${width}    ${height}
    Set Selenium Speed    ${DELAY}
    Wait Until Element Is Visible    css=#title h2
    Element Text Should Be    css=#title h2    veuillez vous connecter
    Title Should Be    ${TITLE}

Input Datepicker From Css Selector
    [Tags]
    [Arguments]    ${selector}    ${date}

    # On clique sur l'icône du datepicker
    Click Element    ${selector} + .ui-datepicker-trigger
    # On récupère le jour
    ${day} =    Get Substring    ${date}    0    2
    # On récupère le mois
    ${month} =     Get Substring    ${date}    3    5
    # On récupère l'année
    ${year} =    Get Substring    ${date}    6
    # Récupère le premier chiffre de la date
    ${day_first_character} =    Get Substring    ${day}    0    1
    # Récupère le deuxième chiffre de la date
    ${day_second_character} =    Get Substring    ${day}    1    2
    # On fait -1 sur le mois pour avoir la value du datepicker
    ${month} =    Convert to Integer    ${month}
    ${datepicker_month} =    Evaluate    ${month}-1
    ${datepicker_month} =    Convert to String    ${datepicker_month}
    # On sélectionne le mois
    Wait Until Keyword Succeeds     10 sec     ${RETRY_INTERVAL}    Select From List By Value    css=.ui-datepicker-month    ${datepicker_month}
    # On sélectionne l'année
    Select From List By Value    css=.ui-datepicker-year    ${year}
    # On sélectionne le jour, sur un caractère ou deux selon la valeur du premier
    Run keyword If    '${day_first_character}' == '0'    Click Link    ${day_second_character}    ELSE    Click Link    ${day}
    # On attend le temps que le datepicker ne soit plus affiché
    Sleep     1


Input Datepicker
    [Tags]
    [Arguments]    ${champ}    ${date}
    # On clique sur l'image du datepicker
    Click Element    css=input#${champ} + .ui-datepicker-trigger
    # On récupère le jour
    ${day} =    Get Substring    ${date}    0    2
    # On récupère le mois
    ${month} =     Get Substring    ${date}    3    5
    # On récupère l'année
    ${year} =    Get Substring    ${date}    6
    # Récupère le premier chiffre de la date
    ${day_first_character} =    Get Substring    ${day}    0    1
    # Récupère le deuxième chiffre de la date
    ${day_second_character} =    Get Substring    ${day}    1    2
    # On fait -1 sur le mois pour avoir la value du datepicker
    ${month} =    Convert to Integer    ${month}
    ${datepicker_month} =    Evaluate    ${month}-1
    ${datepicker_month} =    Convert to String    ${datepicker_month}
    # On sélectionne le mois
    Wait Until Keyword Succeeds     10 sec     ${RETRY_INTERVAL}    Select From List By Value    css=.ui-datepicker-month    ${datepicker_month}
    # On sélectionne l'année
    Select From List By Value    css=.ui-datepicker-year    ${year}
    # On sélectionne le jour, sur un caractère ou deux selon la valeur du premier
    Run keyword If    '${day_first_character}' == '0'    Click Link    ${day_second_character}    ELSE    Click Link    ${day}
    # On attend le temps que le datepicker ne soit plus affiché
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  ui-datepicker-div


Se déconnecter
    [Tags]
    Wait Until Element Is Visible    css=#title h2
    Element Text Should Be    css=#title h2    Tableau De Bord
    Click Link    css=#actions a.actions-logout
    Wait Until Element Is Visible    css=#title h2
    Element Text Should Be    css=#title h2    veuillez vous connecter
    La page ne doit pas contenir d'erreur


Depuis la page de login
    [Tags]  global
    [Documentation]  Accède à la page de login.
    ...
    ...  L'utilisateur ne doit pas être connecté sinon le keyword va échouer.

    Go To  ${PROJECT_URL}
    Wait Until Element Is Visible  css=#title h2
    Element Text Should Be  css=#title h2  veuillez vous connecter
    Title Should Be  ${TITLE}
    La page ne doit pas contenir d'erreur
