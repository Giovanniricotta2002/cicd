*** Settings ***
Documentation    CRUD de la table document_numerise
...    @author  generated
...    @package openADS
...    @version 17/04/2020 11:04

*** Keywords ***

Depuis le contexte Pièce
    [Documentation]  Accède au formulaire
    [Arguments]  ${document_numerise}

    # On accède au tableau
    Go To Tab  document_numerise
    # On recherche l'enregistrement
    Use Simple Search  Pièce  ${document_numerise}
    # On clique sur le résultat
    Click On Link  ${document_numerise}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Pièce
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  document_numerise
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Pièce  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${document_numerise} =  Get Text  css=div.form-content span#document_numerise
    # On le retourne
    [Return]  ${document_numerise}

Modifier Pièce
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${document_numerise}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Pièce  ${document_numerise}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  document_numerise  modifier
    # On saisit des valeurs
    Saisir Pièce  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Pièce
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${document_numerise}

    # On accède à l'enregistrement
    Depuis le contexte Pièce  ${document_numerise}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  document_numerise  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Pièce
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "uid" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "nom_fichier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_creation" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "document_numerise_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "uid_dossier_final" existe dans "${values}" on execute "Set Checkbox" dans le formulaire