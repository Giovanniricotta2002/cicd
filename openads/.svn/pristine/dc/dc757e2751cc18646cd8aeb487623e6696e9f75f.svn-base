*** Settings ***
Documentation    CRUD de la table lien_document_n_type_d_i_t
...    @author  generated
...    @package openADS
...    @version 05/07/2021 16:07

*** Keywords ***

Depuis le contexte nomenclature des pieces
    [Documentation]  Accède au formulaire
    [Arguments]  ${nomenclature_piece}

    # On accède au tableau
    Depuis le listing  lien_document_n_type_d_i_t
    # On recherche l'enregistrement
    Use Simple Search  lien_document_n_type_d_i_t  ${nomenclature_piece}
    # On clique sur le résultat
    Click On Link  ${nomenclature_piece}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter une nomenclature de piece
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  lien_document_n_type_d_i_t
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir une nomenclature de piece  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${nomenclature_piece} =  Get Text  css=div.form-content span#lien_document_n_type_d_i_t
    # On le retourne
    [Return]  ${nomenclature_piece}

Modifier une nomenclature de piece
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${nomenclature_piece}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte nomenclature des pieces  ${nomenclature_piece}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_document_n_type_d_i_t  modifier
    # On saisit des valeurs
    Saisir une nomenclature de piece  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer une nomenclature de piece
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${nomenclature_piece}

    # On accède à l'enregistrement
    Depuis le contexte nomenclature des pieces  ${nomenclature_piece}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_document_n_type_d_i_t  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir une nomenclature de piece
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "document_numerise_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire