*** Settings ***
Documentation  Actions spécifiques aux lots.

*** Keywords ***
Depuis l'onglet des lots dans le dossier d'instruction
    [Documentation]  Accède au listing des lots du dossier d'instruction.
    [Tags]  lot
    [Arguments]  ${dossier_instruction}

    Depuis le contexte du dossier d'instruction  ${dossier_instruction}
    On clique sur l'onglet  lot  Lot(s)

Depuis le contexte du lot
    [Documentation]  Accède au formulaire
    [Tags]  lot
    [Arguments]  ${dossier_instruction}  ${lot}

    # On accède au tableau
    Depuis l'onglet des lots dans le dossier d'instruction  ${dossier_instruction}
    # On recherche l'enregistrement
    # Use Tab Simple Search  ${lot}
    # On clique sur le résultat
    Click On Link  ${lot}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter le lot
    [Documentation]  Crée l'enregistrement
    [Tags]  lot
    [Arguments]  ${dossier_instruction}  ${values}

    # On accède au tableau
    Depuis l'onglet des lots dans le dossier d'instruction  ${dossier_instruction}
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le lot  ${values}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie les erreurs
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.

Modifier le lot
    [Documentation]  Modifie l'enregistrement
    [Tags]  lot
    [Arguments]  ${dossier_instruction}  ${lot}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte du lot  ${dossier_instruction}  ${lot}
    # On clique sur le bouton modifier
    Click On Subform Portlet Action  lot  modifier
    # On saisit des valeurs
    Saisir le lot  ${values}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie les erreurs
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.

Supprimer le lot
    [Documentation]  Supprime l'enregistrement
    [Tags]  lot
    [Arguments]  ${dossier_instruction}  ${lot}

    # On accède à l'enregistrement
    Depuis le contexte du lot  ${dossier_instruction}  ${lot}
    # On clique sur le bouton supprimer
    Click On Subform Portlet Action  lot  supprimer
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie les erreurs
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La suppression a été correctement effectuée.

Saisir le lot
    [Documentation]  Remplit le formulaire
    [Tags]  lot
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
