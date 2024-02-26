*** Settings ***
Documentation    CRUD de la table signataire_arrete
...    @author  generated
...    @package openADS
...    @version 21/05/2021 13:05

*** Keywords ***

Depuis le contexte signataire
    [Documentation]  Accède au formulaire
    [Arguments]  ${signataire_arrete}

    # On accède au tableau
    Go To Tab  signataire_arrete
    # On recherche l'enregistrement
    Use Simple Search  signataire  ${signataire_arrete}
    # On clique sur le résultat
    Click On Link  ${signataire_arrete}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter signataire
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  signataire_arrete
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir signataire  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${signataire_arrete} =  Get Text  css=div.form-content span#signataire_arrete
    # On le retourne
    [Return]  ${signataire_arrete}

Modifier signataire
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${signataire_arrete}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte signataire  ${signataire_arrete}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  signataire_arrete  modifier
    # On saisit des valeurs
    Saisir signataire  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer signataire
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${signataire_arrete}

    # On accède à l'enregistrement
    Depuis le contexte signataire  ${signataire_arrete}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  signataire_arrete  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir signataire
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "civilite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "prenom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "qualite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "signature" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "defaut" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "email" existe dans "${values}" on execute "Input Text" dans le formulaire