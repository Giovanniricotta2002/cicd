*** Settings ***
Documentation    CRUD de la table document_numerise_nature
...    @author  generated
...    @package openADS
...    @version 14/10/2021 15:10

*** Keywords ***

Depuis le contexte nature de pièce
    [Documentation]  Accède au formulaire
    [Arguments]  ${document_numerise_nature}

    # On accède au tableau
    Go To Tab  document_numerise_nature
    # On recherche l'enregistrement
    Use Simple Search  nature de pièce  ${document_numerise_nature}
    # On clique sur le résultat
    Click On Link  ${document_numerise_nature}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter nature de pièce
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  document_numerise_nature
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir nature de pièce  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${document_numerise_nature} =  Get Text  css=div.form-content span#document_numerise_nature
    # On le retourne
    [Return]  ${document_numerise_nature}

Modifier nature de pièce
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${document_numerise_nature}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte nature de pièce  ${document_numerise_nature}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  document_numerise_nature  modifier
    # On saisit des valeurs
    Saisir nature de pièce  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer nature de pièce
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${document_numerise_nature}

    # On accède à l'enregistrement
    Depuis le contexte nature de pièce  ${document_numerise_nature}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  document_numerise_nature  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir nature de pièce
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire