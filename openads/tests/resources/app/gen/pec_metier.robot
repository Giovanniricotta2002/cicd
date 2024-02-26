*** Settings ***
Documentation    CRUD de la table pec_metier
...    @author  generated
...    @package openADS
...    @version 22/01/2021 10:01

*** Keywords ***

Depuis le contexte prise en compte métier
    [Documentation]  Accède au formulaire
    [Arguments]  ${pec_metier}

    # On accède au tableau
    Go To Tab  pec_metier
    # On recherche l'enregistrement
    Use Simple Search  prise en compte métier  ${pec_metier}
    # On clique sur le résultat
    Click On Link  ${pec_metier}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter prise en compte métier
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  pec_metier
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir prise en compte métier  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${pec_metier} =  Get Text  css=div.form-content span#pec_metier
    # On le retourne
    [Return]  ${pec_metier}

Modifier prise en compte métier
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${pec_metier}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte prise en compte métier  ${pec_metier}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  pec_metier  modifier
    # On saisit des valeurs
    Saisir prise en compte métier  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer prise en compte métier
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${pec_metier}

    # On accède à l'enregistrement
    Depuis le contexte prise en compte métier  ${pec_metier}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  pec_metier  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir prise en compte métier
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire