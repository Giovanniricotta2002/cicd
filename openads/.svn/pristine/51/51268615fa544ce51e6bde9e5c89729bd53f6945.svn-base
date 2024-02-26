*** Settings ***
Documentation  Actions spécifiques aux éléments de la bible.

*** Keywords ***
Saisir la bible en sous-formulaire
    [Arguments]  ${libelle}=null  ${contenu}=null  ${complement}=null  ${automatique}=null  ${type_da}=null  ${collectivite}=null

    # On saisit le libellé
    Run Keyword If  '${libelle}' != 'null'  Input Text  css=#sformulaire #libelle  ${libelle}
    # On saisit le contenu
    Run Keyword If  '${contenu}' != 'null'  Input Text  css=#sformulaire #contenu  ${contenu}
    # On sélectionne le complément
    Run Keyword If  '${complement}' != 'null'  Select From List By Label  css=#sformulaire #complement  ${complement}
    # On sélectionne "automatique"
    Run Keyword If  '${automatique}' != 'null'  Select From List By Label  css=#sformulaire #automatique  ${automatique}
    # On sélectionne  le type de dossier d'autorisation
    Run Keyword If  '${type_da}' != 'null'  Select From List By Label  css=#sformulaire #dossier_autorisation_type  ${type_da}
    # On sélectionne  la collectivité
    Run Keyword If  '${collectivite}' != 'null'  Select From List By Label  css=#sformulaire #om_collectivite  ${collectivite}

Depuis l'onglet bible de l'événement
    [Arguments]  ${evenement}

    Depuis le contexte de l'événement  ${evenement}
    On clique sur l'onglet  bible  Bible

Ajouter une bible depuis l'onglet de l'événement
    [Arguments]  ${evenement}  ${libelle}  ${contenu}  ${complement}=null  ${automatique}=null  ${type_da}=null  ${collectivite}=null

    Depuis l'onglet bible de l'événement  ${evenement}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-bible-corner-ajouter
    # On remplit le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Saisir la bible en sous-formulaire  ${libelle}  ${contenu}  ${complement}  ${automatique}  ${type_da}  ${collectivite}
    # On valide
    Click On Submit Button In Subform
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.

Depuis le tableau des bibles
    [Documentation]  Permet d'accéder au tableau des bibles.

    # On ouvre le tableau
    Depuis le listing  bible

Ajouter une bible depuis le paramétrage dossiers
    [Arguments]  ${evenement}=null  ${libelle}=null  ${contenu}=null  ${complement}=null  ${automatique}=null  ${type_da}=null  ${collectivite}=null

    # On ouvre le tableau des bibles
    Depuis le tableau des bibles
    # On clique sur l'icone d'ajout
    Click On Add Button
    # On remplit le formulaire
    Saisir la bible en formulaire  ${evenement}  ${libelle}  ${contenu}  ${complement}  ${automatique}  ${type_da}  ${collectivite}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Saisir la bible en formulaire
    [Arguments]  ${evenement}=null  ${libelle}=null  ${contenu}=null  ${complement}=null  ${automatique}=null  ${type_da}=null  ${collectivite}=null

    # On saisit le libellé
    Run Keyword If  '${libelle}' != 'null'  Input Text  libelle  ${libelle}
    # On saisit le contenu
    Run Keyword If  '${contenu}' != 'null'  Input Text  contenu  ${contenu}
    # On sélectionne le complément
    Run Keyword If  '${complement}' != 'null'  Select From List By Label  complement  ${complement}
    # On sélectionne "automatique"
    Run Keyword If  '${automatique}' != 'null'  Select From List By Label  automatique  ${automatique}
    # On sélectionne le type de dossier d'autorisation
    Run Keyword If  '${type_da}' != 'null'  Select From List By Label  dossier_autorisation_type  ${type_da}
    # On sélectionne la collectivité
    Run Keyword If  '${collectivite}' != 'null'  Select From List By Label  om_collectivite  ${collectivite}
    # On sélectionne l'événement
    Run Keyword If  '${evenement}' != 'null'  Select From List By Label  evenement  ${evenement}
