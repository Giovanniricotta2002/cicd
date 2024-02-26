*** Settings ***
Documentation  Actions spécifiques aux directions.

*** Keywords ***
Depuis le tableau des directions
    [Documentation]  Permet d'accéder au tableau des directions.

    # On ouvre le tableau
    Depuis le listing  direction

Depuis le contexte de la direction
    [Documentation]  Accède à la fiche de consultation de la direction.
    [Arguments]  ${libelle}=null  ${code}=null

    Depuis le tableau des directions
    # On recherche la direction
    Run Keyword If    '${code}' != 'null'    Use Simple Search    code    ${code}    ELSE IF    '${libelle}' != 'null'    Use Simple Search    libellé    ${libelle}    ELSE    Fail
    # On clique sur la direction
    Run Keyword If    '${code}' != 'null'    Click On Link    ${code}    ELSE IF    '${libelle}' != 'null'    Click On Link    ${libelle}    ELSE    Fail

Ajouter la direction depuis le menu
    [Documentation]  Permet d'ajouter une direction.
    [Arguments]  ${code}=null  ${libelle}=null  ${description}=null  ${chef}=null  ${debut}=null  ${fin}=null  ${collectivite}=null

    # On ouvre le tableau des directions
    Depuis le tableau des directions
    # On clique sur l'icone d'ajout
    Click On Add Button
    # On remplit le formulaire
    Saisir la direction  ${code}  ${libelle}  ${description}  ${chef}  ${debut}  ${fin}  ${collectivite}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Saisir la direction
    [Documentation]  Permet de remplir le formulaire d'une direction.
    [Arguments]  ${code}  ${libelle}  ${description}  ${chef}  ${debut}  ${fin}  ${collectivite}

    # On saisit le code
    Run Keyword If  '${code}' != 'null'  Input Text  code  ${code}
    # On saisit le libelle
    Run Keyword If  '${libelle}' != 'null'  Input Text  libelle  ${libelle}
    # On saisit la description
    Run Keyword If  '${description}' != 'null'  Input Text  description  ${description}
    # On saisit le nom du chef
    Run Keyword If  '${chef}' != 'null'  Input Text  chef  ${chef}
    # On sélectionne la collectivité
    Run Keyword If  '${collectivite}' != 'null'  Select From List By Label  om_collectivite  ${collectivite}
    # On saisit la date de début de validité
    Run Keyword If  '${debut}' != 'null'  Input Datepicker  om_validite_debut  ${debut}
    # On saisit la date de fin de validite
    Run Keyword If  '${fin}' != 'null'  Input Datepicker  om_validite_fin  ${fin}
