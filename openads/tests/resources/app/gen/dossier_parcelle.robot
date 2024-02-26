*** Settings ***
Documentation    CRUD de la table dossier_parcelle
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Parcelle
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_parcelle}

    # On accède au tableau
    Go To Tab  dossier_parcelle
    # On recherche l'enregistrement
    Use Simple Search  Parcelle  ${dossier_parcelle}
    # On clique sur le résultat
    Click On Link  ${dossier_parcelle}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Parcelle
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_parcelle
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Parcelle  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_parcelle} =  Get Text  css=div.form-content span#dossier_parcelle
    # On le retourne
    [Return]  ${dossier_parcelle}

Modifier Parcelle
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_parcelle}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Parcelle  ${dossier_parcelle}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_parcelle  modifier
    # On saisit des valeurs
    Saisir Parcelle  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Parcelle
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_parcelle}

    # On accède à l'enregistrement
    Depuis le contexte Parcelle  ${dossier_parcelle}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_parcelle  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Parcelle
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "parcelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire