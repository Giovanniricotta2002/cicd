*** Settings ***
Documentation    CRUD de la table lien_document_n_type_d_i_t
...    @author  generated
...    @package openADS
...    @version 15/07/2021 10:07

*** Keywords ***

Depuis le contexte lien_document_n_type_d_i_t
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_document_n_type_d_i_t}

    # On accède au tableau
    Go To Tab  lien_document_n_type_d_i_t
    # On recherche l'enregistrement
    Use Simple Search  lien_document_n_type_d_i_t  ${lien_document_n_type_d_i_t}
    # On clique sur le résultat
    Click On Link  ${lien_document_n_type_d_i_t}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien_document_n_type_d_i_t
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_document_n_type_d_i_t
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien_document_n_type_d_i_t  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_document_n_type_d_i_t} =  Get Text  css=div.form-content span#lien_document_n_type_d_i_t
    # On le retourne
    [Return]  ${lien_document_n_type_d_i_t}

Modifier lien_document_n_type_d_i_t
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_document_n_type_d_i_t}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien_document_n_type_d_i_t  ${lien_document_n_type_d_i_t}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_document_n_type_d_i_t  modifier
    # On saisit des valeurs
    Saisir lien_document_n_type_d_i_t  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien_document_n_type_d_i_t
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_document_n_type_d_i_t}

    # On accède à l'enregistrement
    Depuis le contexte lien_document_n_type_d_i_t  ${lien_document_n_type_d_i_t}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_document_n_type_d_i_t  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien_document_n_type_d_i_t
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "document_numerise_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire