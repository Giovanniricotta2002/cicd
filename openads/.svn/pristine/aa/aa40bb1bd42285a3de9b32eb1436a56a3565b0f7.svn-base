*** Settings ***
Documentation  Actions spécifiques aux type de pièce.

*** Keywords ***

Depuis le contexte du type de pièces
    [Documentation]  Accède au formulaire
    [Arguments]  ${document_numerise_type}

    # On accède au tableau
    Depuis le listing  document_numerise_type
    # On recherche l'enregistrement
    Use Simple Search  Tous  ${document_numerise_type}
    # On clique sur le résultat
    Click On Link  ${document_numerise_type}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter le type de pièces
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  document_numerise_type
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le type de pièces  ${values}
    # On valide le formulaire
    Click On Submit Button

Modifier le type de pièces
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${document_numerise_type}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte du type de pièces  ${document_numerise_type}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  document_numerise_type  modifier
    # On saisit des valeurs
    Saisir le type de pièces  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer le type de pièces
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${document_numerise_type}

    # On accède à l'enregistrement
    Depuis le contexte du type de pièces  ${document_numerise_type}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  document_numerise_type  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir le type de pièces
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "document_numerise_type_categorie" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "instructeur_qualite" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire
    Si "aff_service_consulte" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "aff_da" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "synchro_metadonnee" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire

Saisir le type de pièces en sous-formulaire
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "code" existe dans "${values}" on execute "Input Text" dans "document_numerise_type"
    Si "libelle" existe dans "${values}" on execute "Input Text" dans "document_numerise_type"
    Si "document_numerise_type_categorie" existe dans "${values}" on execute "Select From List By Label" dans "document_numerise_type"
    Si "instructeur_qualite" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire
    Si "aff_service_consulte" existe dans "${values}" on execute "Set Checkbox" dans "document_numerise_type"
    Si "aff_da" existe dans "${values}" on execute "Set Checkbox" dans "document_numerise_type"
    Si "synchro_metadonnee" existe dans "${values}" on execute "Set Checkbox" dans "document_numerise_type"
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans "document_numerise_type"


Mise à jour des métadonnées
    [Documentation]  Lance l'action de mise à jour des métadonnées des documents numérisés
    [Arguments]  ${message}=null

    Go To Submenu In Menu  parametrage  document_numerise_traitement_metadonnees
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Cette page permet de mettre à jour certaines métadonnées des pièces numérisées.
    Run Keyword If  "${message}" == 'null'  Click On Submit Button
    ...       ELSE                          Click On Submit Button Until Message  ${message}
    La page ne doit pas contenir d'erreur
