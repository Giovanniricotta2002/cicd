*** Settings ***
Documentation    CRUD de la table signataire_habilitation
...    @author  generated
...    @package openADS
...    @version 03/03/2022 18:03

*** Keywords ***

Depuis le contexte habilitation du signataire
    [Documentation]  Accède au formulaire
    [Arguments]  ${signataire_habilitation}

    # On accède au tableau
    Go To Tab  signataire_habilitation
    # On recherche l'enregistrement
    Use Simple Search  habilitation du signataire  ${signataire_habilitation}
    # On clique sur le résultat
    Click On Link  ${signataire_habilitation}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter habilitation du signataire
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  signataire_habilitation
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir habilitation du signataire  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${signataire_habilitation} =  Get Text  css=div.form-content span#signataire_habilitation
    # On le retourne
    [Return]  ${signataire_habilitation}

Modifier habilitation du signataire
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${signataire_habilitation}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte habilitation du signataire  ${signataire_habilitation}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  signataire_habilitation  modifier
    # On saisit des valeurs
    Saisir habilitation du signataire  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer habilitation du signataire
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${signataire_habilitation}

    # On accède à l'enregistrement
    Depuis le contexte habilitation du signataire  ${signataire_habilitation}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  signataire_habilitation  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir habilitation du signataire
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire