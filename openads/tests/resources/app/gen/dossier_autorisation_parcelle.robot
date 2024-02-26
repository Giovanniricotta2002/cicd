*** Settings ***
Documentation    CRUD de la table dossier_autorisation_parcelle
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte dossier_autorisation_parcelle
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_autorisation_parcelle}

    # On accède au tableau
    Go To Tab  dossier_autorisation_parcelle
    # On recherche l'enregistrement
    Use Simple Search  dossier_autorisation_parcelle  ${dossier_autorisation_parcelle}
    # On clique sur le résultat
    Click On Link  ${dossier_autorisation_parcelle}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter dossier_autorisation_parcelle
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_autorisation_parcelle
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir dossier_autorisation_parcelle  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_autorisation_parcelle} =  Get Text  css=div.form-content span#dossier_autorisation_parcelle
    # On le retourne
    [Return]  ${dossier_autorisation_parcelle}

Modifier dossier_autorisation_parcelle
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_autorisation_parcelle}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte dossier_autorisation_parcelle  ${dossier_autorisation_parcelle}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_autorisation_parcelle  modifier
    # On saisit des valeurs
    Saisir dossier_autorisation_parcelle  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer dossier_autorisation_parcelle
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_autorisation_parcelle}

    # On accède à l'enregistrement
    Depuis le contexte dossier_autorisation_parcelle  ${dossier_autorisation_parcelle}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_autorisation_parcelle  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir dossier_autorisation_parcelle
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier_autorisation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "parcelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire