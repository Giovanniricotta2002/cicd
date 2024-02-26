*** Settings ***
Documentation    CRUD de la table document_numerise_type
...    @author  generated
...    @package openADS
...    @version 17/04/2020 11:04

*** Keywords ***

Depuis le contexte Type de pièces
    [Documentation]  Accède au formulaire
    [Arguments]  ${document_numerise_type}

    # On accède au tableau
    Go To Tab  document_numerise_type
    # On recherche l'enregistrement
    Use Simple Search  Type de pièces  ${document_numerise_type}
    # On clique sur le résultat
    Click On Link  ${document_numerise_type}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Type de pièces
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  document_numerise_type
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Type de pièces  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${document_numerise_type} =  Get Text  css=div.form-content span#document_numerise_type
    # On le retourne
    [Return]  ${document_numerise_type}

Modifier Type de pièces
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${document_numerise_type}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Type de pièces  ${document_numerise_type}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  document_numerise_type  modifier
    # On saisit des valeurs
    Saisir Type de pièces  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Type de pièces
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${document_numerise_type}

    # On accède à l'enregistrement
    Depuis le contexte Type de pièces  ${document_numerise_type}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  document_numerise_type  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Type de pièces
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "document_numerise_type_categorie" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "aff_service_consulte" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "aff_da" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "synchro_metadonnee" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire