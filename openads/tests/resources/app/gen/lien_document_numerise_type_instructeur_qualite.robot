*** Settings ***
Documentation    CRUD de la table lien_document_numerise_type_instructeur_qualite
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Lien type de document numérisé / qualité d'instructeur
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_document_numerise_type_instructeur_qualite}

    # On accède au tableau
    Go To Tab  lien_document_numerise_type_instructeur_qualite
    # On recherche l'enregistrement
    Use Simple Search  Lien type de document numérisé / qualité d'instructeur  ${lien_document_numerise_type_instructeur_qualite}
    # On clique sur le résultat
    Click On Link  ${lien_document_numerise_type_instructeur_qualite}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Lien type de document numérisé / qualité d'instructeur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_document_numerise_type_instructeur_qualite
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Lien type de document numérisé / qualité d'instructeur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_document_numerise_type_instructeur_qualite} =  Get Text  css=div.form-content span#lien_document_numerise_type_instructeur_qualite
    # On le retourne
    [Return]  ${lien_document_numerise_type_instructeur_qualite}

Modifier Lien type de document numérisé / qualité d'instructeur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_document_numerise_type_instructeur_qualite}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Lien type de document numérisé / qualité d'instructeur  ${lien_document_numerise_type_instructeur_qualite}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_document_numerise_type_instructeur_qualite  modifier
    # On saisit des valeurs
    Saisir Lien type de document numérisé / qualité d'instructeur  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Lien type de document numérisé / qualité d'instructeur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_document_numerise_type_instructeur_qualite}

    # On accède à l'enregistrement
    Depuis le contexte Lien type de document numérisé / qualité d'instructeur  ${lien_document_numerise_type_instructeur_qualite}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_document_numerise_type_instructeur_qualite  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Lien type de document numérisé / qualité d'instructeur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "document_numerise_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "instructeur_qualite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire