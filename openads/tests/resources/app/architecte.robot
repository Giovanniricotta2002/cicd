*** Settings ***
Documentation  Bibliothèque de Keywords spécifiques aux architectes.

*** Keywords ***
Depuis le listing des architectes fréquents
    [Tags]  architecte  architecte_frequent
    [Documentation]  Permet d'accéder au listing des enregistrements de type 'architecte_frequent'.

    Depuis le listing  architecte_frequent


Depuis le formulaire d'ajout d'un architecte fréquent
    [Tags]  architecte  architecte_frequent
    [Documentation]  Permet d'accéder au formulaire d'ajout d'un enregistrement de type 'architecte_frequent'.

    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=architecte_frequent&action=0&retour=form
    La page ne doit pas contenir d'erreur


Ajouter l'architecte fréquent
    [Tags]  architecte  architecte_frequent
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    Depuis le formulaire d'ajout d'un architecte fréquent
    Saisir les valeurs dans le formulaire de type 'architecte'  ${values}
    Click On Submit Button
    ${architecte_id} =  Get Text  css=div.form-content span#architecte
    [Return]  ${architecte_id}


Saisir les valeurs dans le formulaire de type 'architecte'
    [Tags]  architecte  architecte_frequent
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "prenom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ville" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pays" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "inscription" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "telephone" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "fax" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "email" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "note" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "frequent" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "nom_cabinet" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "conseil_regional" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_dit" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "boite_postale" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cedex" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "titre_obt_diplo_spec" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_obt_diplo_spec" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "lieu_obt_diplo_spec" existe dans "${values}" on execute "Input Text" dans le formulaire


Ajouter l'architecte
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${dossier_instruction}  ${values}

    # On se rend sur le dossier d'instruction concerné
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}

    # On clique sur l'action des données techniques
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale

    # Attend l'apparition de l'action dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#action-sousform-donnees_techniques-modifier

    # On clique sur l'action modifier
    Click On SubForm Portlet Action  donnees_techniques  modifier

    # Déplie tous les fieldsets présents
    Open All Fieldset Using Javascript  donnees_techniques  sousform

    # On click sur l'action d'ajout de l'architecte
    Click Element  css=span.add-16.add_architecte
    # On saisit des valeurs
    Saisir les valeurs dans le formulaire de type 'architecte'  ${values}
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sousform-architecte input[value=Ajouter]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sousform-architecte a.retour

    # On valide le formulaire des données techniques
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  Vos modifications ont bien été enregistrées.

Modifier l'architecte
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_instruction}  ${values}

    # On se rend sur le dossier d'instruction concerné
    Depuis le contexte du dossier d'instruction  ${dossier_instruction}

    # On clique sur l'action des données techniques
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale

    # Attend l'apparition de l'action dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#action-sousform-donnees_techniques-modifier

    # On clique sur l'action modifier
    Click On SubForm Portlet Action  donnees_techniques  modifier

    # Déplie tous les fieldsets présents
    Open All Fieldset Using Javascript  donnees_techniques  sousform

    Click Element  css=span.edit-16.add_architecte

    # On saisit des valeurs
    Saisir les valeurs dans le formulaire de type 'architecte'  ${values}
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sousform-architecte input[value=Modifier]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sousform-architecte a.retour

    # On valide le formulaire des données techniques
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  Vos modifications ont bien été enregistrées.