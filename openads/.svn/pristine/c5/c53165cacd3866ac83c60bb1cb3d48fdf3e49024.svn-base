*** Settings ***
Documentation     Actions spécifiques aux dossiers d'autorisation.

*** Keywords ***
Depuis le listing des dossiers d'autorisation

    [Documentation]    Permet de se positionner sur l'écran "Autorisation ->
    ...    Dossiers d'autorisation"

    #
    Go To Submenu In Menu    autorisation    dossier_autorisation


Depuis le contexte du dossier d'autorisation par la recherche

    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier
    ...  d'autorisation.

    [Arguments]  ${dossier_autorisation}

    # On accède directement au tableau de tous les dossiers d'autorisation
    Depuis le listing des dossiers d'autorisation
    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_autorisation}
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  ${libelle_sans_espace}
    # On valide le formulaire de recherche
    Click On Search Button
    # On accède à la visualisation du DI
    Click On Link  ${dossier_autorisation}


Depuis le contexte du dossier d'autorisation

    [Documentation]    Permet d'accéder à l'écran de visualisation d'un dossier
    ...  d'autorisation.

    [Arguments]  ${dossier_autorisation}

    # On supprime les éventuels espaces du libellé
    ${libelle_sans_espace} =  Sans espace  ${dossier_autorisation}
    # On accède directement au tableau de tous les dossiers d'instruction
    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_autorisation&action=3&idx=${libelle_sans_espace}
    # On vérifie qu'on est bien sur le DI
    Page Should Contain  ${dossier_autorisation}


Depuis l'onglet des pièces du dossier d'autorisation

    [Documentation]  Permet d'accéder à l'onglet des pièces dans le contexte
    ...  d'un dossier d'autorisation.

    [Arguments]  ${dossier_autorisation}

    #
    Depuis le contexte du dossier d'autorisation  ${dossier_autorisation}
    #
    On clique sur l'onglet  document_numerise  Pièces & Documents
