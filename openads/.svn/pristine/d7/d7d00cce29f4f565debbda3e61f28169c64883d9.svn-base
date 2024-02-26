*** Settings ***
Documentation  Actions spécifiques aux divisions.

*** Keywords ***
Depuis le tableau des divisions
    [Documentation]  Permet d'accéder au tableau des divisions.

    # On ouvre le tableau
    Depuis le listing  division

Ajouter la division depuis le menu
    [Documentation]  Permet d'ajouter une division.
    [Arguments]  ${code}=null  ${libelle}=null  ${description}=null  ${chef}=null  ${debut}=null  ${fin}=null  ${direction}=null

    # On ouvre le tableau des divisions
    Depuis le tableau des divisions
    # On clique sur l'icone d'ajout
    Click On Add Button
    # On remplit le formulaire
    Saisir la division  ${code}  ${libelle}  ${description}  ${chef}  ${debut}  ${fin}  ${direction}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Saisir la division
    [Documentation]  Permet de remplir le formulaire d'une division.
    [Arguments]  ${code}  ${libelle}  ${description}  ${chef}  ${debut}  ${fin}  ${direction}

    # On saisit la code
    Run Keyword If  '${code}' != 'null'  Input Text  code  ${code}
    # On saisit le libelle
    Run Keyword If  '${libelle}' != 'null'  Input Text  libelle  ${libelle}
    # On saisit la description
    Run Keyword If  '${description}' != 'null'  Input Text  description  ${description}
    # On saisit le nom du chef
    Run Keyword If  '${chef}' != 'null'  Input Text  chef  ${chef}
    # On sélectionne la direction
    Run Keyword If  '${direction}' != 'null'  Select From List By Label  direction  ${direction}
    # On saisit la date de début de validité
    Run Keyword If  '${debut}' != 'null'  Input Datepicker  om_validite_debut  ${debut}
    # On saisit la date de fin de validite
    Run Keyword If  '${fin}' != 'null'  Input Datepicker  om_validite_fin  ${fin}
