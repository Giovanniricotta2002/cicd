*** Settings ***
Documentation  Actions spécifiques aux affectations automatiques.

*** Keywords ***
Depuis le tableau des affectations
    [Documentation]  Permet d'accéder au tableau des affectations automatiques.

    # On ouvre le tableau
    Depuis le listing  affectation_automatique

Depuis le contexte de l'affectation
    [Documentation]  Permet d'accéder au formulaire en consultation
    ...    d'une affectation.
    [Arguments]  ${instructeur}=null  ${simple_search}=null

    # On ouvre le tableau des affectations automatiques
    Depuis le tableau des affectations
    # On recherche l'affectation
    Run Keyword If    '${instructeur}' != 'null'    Rechercher en recherche avancée simple  ${instructeur}    ELSE IF    '${simple_search}' != 'null'    Rechercher en recherche avancée simple  ${simple_search}    ELSE    Fail
    # On clique sur l'affectation
    Run Keyword If    '${instructeur}' != 'null'    Click On Link    ${instructeur}    ELSE IF    '${simple_search}' != 'null'    Click On Link    ${simple_search}    ELSE    Fail

Ajouter l'affectation depuis le menu
    [Documentation]  Permet d'ajouter une affectation.
    [Arguments]  ${values}

    # On ouvre le tableau des affectations automatiques
    Depuis le tableau des affectations
    # On clique sur l'icone d'ajout
    Click On Add Button
    # On remplit le formulaire
    Saisir l'affectation  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Saisir l'affectation
    [Documentation]  Permet de remplir le formulaire d'une affectation.
    [Arguments]  ${values}

    Si "arrondissement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "quartier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "section" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "instructeur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "instructeur_2" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_autorisation_type_detaille" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "affectation_manuelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "communes" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire

Supprimer l'affectation depuis le menu

    [Documentation]

    [Arguments]  ${instructeur}=null  ${simple_search}=null

    #
    Depuis le contexte de l'affectation  ${instructeur}  ${simple_search}
    # On clique sur l'action supprimer
    Click On Form Portlet Action  affectation_automatique  supprimer
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La suppression a été correctement effectuée.

Depuis le contexte de l'affectation manuelle
    [Documentation]  Permet d'accéder au formulaire en consultation
    ...    d'une affectation.
    [Arguments]  ${libelle}

    # On ouvre le tableau des affectations automatiques
    Depuis le tableau des affectations
    # On recherche l'affectation
    Rechercher en recherche avancée simple  ${libelle}
    # On clique sur l'affectation
    Click On Link    ${libelle}

Supprimer l'affectation manuelle depuis le menu

    [Documentation]

    [Arguments]  ${libelle}

    Depuis le contexte de l'affectation manuelle  ${libelle}
    # On clique sur l'action supprimer
    Click On Form Portlet Action  affectation_automatique  supprimer
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La suppression a été correctement effectuée.
