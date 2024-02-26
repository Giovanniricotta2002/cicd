*** Settings ***
Documentation    CRUD de la table num_dossier
...    @author  generated
...    @package openADS
...    @version 26/11/2019 17:11

*** Keywords ***
Depuis le contexte du suivi de dossier
    [Documentation]  Accède au formulaire
    [Arguments]  ${obj}  ${search_value}  ${search_label}=Dossier

    Depuis le listing  ${obj}
    Use Simple Search  ${search_label}  ${search_value}
    Click On Link  ${search_value}
    La page ne doit pas contenir d'erreur

Modifier le suivi de dossier
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${obj}  ${search_value}  ${values}  ${search_label}=Dossier

    Depuis le contexte du suivi de dossier  ${obj}  ${search_value}  ${search_label}
    Saisir le suivi de dossier  ${values}
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Dupliquer le suivi de dossier
    [Documentation]
    [Arguments]  ${search_value}  ${search_label}=Dossier

    Depuis le contexte du suivi de dossier  num_dossier  ${search_value}  ${search_label}
    Click On Form Portlet Action  num_dossier  copier  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Button  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  L'élément a été correctement dupliqué.

Saisir le suivi de dossier
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "ref" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "petition" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "total_pages" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pa3a4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pa0" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_depot" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "num_bordereau" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "datenum" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "num_commande" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire

Récupération des dossiers d'instruction pour le suivi de numérisation (multi)
    [Documentation]
    [Arguments]  ${message}  ${om_collectivite}

    Go To Submenu In Menu  numerisation  num_dossier_recuperation
    Select From List By Label  om_collectivite  ${om_collectivite}
    Click On Submit Button
    Valid Message Should Contain  ${message}

Récupération des dossiers d'instruction pour le suivi de numérisation (mono)
    [Documentation]
    [Arguments]  ${message}

    Go To Submenu In Menu  numerisation  num_dossier_recuperation
    Click On Submit Button
    Valid Message Should Contain  ${message}

Attribution d'un suivi de dossier sur un bordereau
    [Documentation]
    [Arguments]  ${search_value}  ${libelle_num_bordereau}  ${search_label}=Dossier

    Depuis le contexte du suivi de dossier  num_dossier_a_attribuer  ${search_value}  ${search_label}
    Select From List By Label  num_bordereau  ${libelle_num_bordereau}
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Vérification de la présence des dossiers d'instruction dans le listing des suivis de dossier
    [Documentation]
    [Arguments]  ${obj}  ${list_di}

    Depuis le listing  ${obj}
    :FOR  ${di}  IN  @{list_di}
    \  Use Simple Search  Dossier  ${di}
    \  Element Should Contain  css=.tab-tab  ${di}

Vérification de l'abscence des dossiers d'instruction dans le listing des suivis de dossier
    [Documentation]
    [Arguments]  ${obj}  ${list_di}

    Depuis le listing  ${obj}
    :FOR  ${di}  IN  @{list_di}
    \  Use Simple Search  Dossier  ${di}
    \  Element Should Not Contain  css=.tab-tab  ${di}
