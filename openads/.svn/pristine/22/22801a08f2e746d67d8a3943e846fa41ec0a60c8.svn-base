*** Settings ***
Documentation  Actions spécifiques aux instructeurs.

*** Keywords ***
Depuis le tableau des instructeurs
    [Documentation]  Permet d'accéder au tableau des instructeurs.

    # On ouvre le tableau
    Depuis le listing  instructeur

Depuis le contexte de l'instructeur
    [Documentation]  Permet d'accéder au formulaire en consultation
    ...    d'un instructeur.
    [Arguments]  ${nom}=null  ${utilisateur}=null

    # On ouvre le tableau des instructeurs
    Depuis le tableau des instructeurs
    # On recherche l'instructeur
    Run Keyword If    '${utilisateur}' != 'null'    Use Simple Search    Utilisateur    ${utilisateur}    ELSE IF    '${nom}' != 'null'    Use Simple Search    nom    ${nom}    ELSE    Fail
    # On clique sur l'instructeur
    Run Keyword If    '${utilisateur}' != 'null'    Click On Link    ${utilisateur}    ELSE IF    '${nom}' != 'null'    Click On Link    ${nom}    ELSE    Fail

Ajouter l'instructeur depuis le menu
    [Documentation]  Permet d'ajouter un instructeur.
    [Arguments]  ${nom}  ${division}  ${qualite}  ${utilisateur}=null  ${telephone}=null  ${debut}=null  ${fin}=null

    # On ouvre le tableau des instructeurs
    Depuis le tableau des instructeurs
    # On clique sur l'icone d'ajout
    Click On Add Button
    # On remplit le formulaire
    Saisir l'instructeur depuis le menu  ${nom}  ${division}  ${qualite}  ${utilisateur}  ${telephone}  ${debut}  ${fin}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Saisir l'instructeur depuis le menu
    [Documentation]  Permet de remplir le formulaire d'un instructeur.
    [Arguments]  ${nom}  ${division}  ${qualite}  ${utilisateur}  ${telephone}  ${debut}  ${fin}

    # On saisit le nom
    Run Keyword If  '${nom}' != 'null'  Input Text  nom  ${nom}
    # Ajout d'un timer car le nom peut être tronqué quand la validation du
    # formulaire est trop rapide
    Sleep  1
    # On sélectionne la division
    Run Keyword If  '${division}' != 'null'  Select From List By Label  division  ${division}
    # On sélectionne l'utilisateur
    Run Keyword If  '${utilisateur}' != 'null'  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_utilisateur  ${utilisateur}
    # On saisit le téléphone
    Run Keyword If  '${telephone}' != 'null'  Input Text  telephone  ${telephone}
    # On saisit la date de début de validité
    Run Keyword If  '${debut}' != 'null'  Input Datepicker  om_validite_debut  ${debut}
    # On saisit la date de fin de validite
    Run Keyword If  '${fin}' != 'null'  Input Datepicker  om_validite_fin  ${fin}
    # On sélectionne la qualité de l'instructeur
    Run Keyword If  '${qualite}' != 'null'  Select From List By Label  instructeur_qualite  ${qualite}

Ajouter l'instructeur
    [Documentation]  Permet d'ajouter un instructeur.
    [Arguments]  ${values}

    # On ouvre le tableau des instructeurs
    Depuis le tableau des instructeurs
    # On clique sur l'icone d'ajout
    Click On Add Button
    # On remplit le formulaire
    Saisir l'instructeur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Saisir l'instructeur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "telephone" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "division" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_utilisateur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "instructeur_qualite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire

Supprimer instructeur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${instructeur}

    # On accède à l'enregistrement
    Depuis le contexte de l'instructeur  ${instructeur}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  instructeur  supprimer
    # On valide le formulaire
    Click On Submit Button

Modifier l'instructeur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${values}  ${nom}=null  ${utilisateur}=null

    # On accède à l'enregistrement
    Depuis le contexte de l'instructeur  ${nom}  ${utilisateur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  instructeur  modifier
    # On saisit des valeurs
    Saisir l'instructeur  ${values}
    # On valide le formulaire
    Click On Submit Button