*** Settings ***
Documentation    CRUD de la table lien_dossier_dossier
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Lien entre dossiers
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_dossier_dossier}

    # On accède au tableau
    Go To Tab  lien_dossier_dossier
    # On recherche l'enregistrement
    Use Simple Search  Lien entre dossiers  ${lien_dossier_dossier}
    # On clique sur le résultat
    Click On Link  ${lien_dossier_dossier}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Lien entre dossiers
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_dossier_dossier
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Lien entre dossiers  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_dossier_dossier} =  Get Text  css=div.form-content span#lien_dossier_dossier
    # On le retourne
    [Return]  ${lien_dossier_dossier}

Modifier Lien entre dossiers
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_dossier_dossier}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Lien entre dossiers  ${lien_dossier_dossier}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_dossier_dossier  modifier
    # On saisit des valeurs
    Saisir Lien entre dossiers  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Lien entre dossiers
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_dossier_dossier}

    # On accède à l'enregistrement
    Depuis le contexte Lien entre dossiers  ${lien_dossier_dossier}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_dossier_dossier  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Lien entre dossiers
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier_src" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_cible" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "type_lien" existe dans "${values}" on execute "Input Text" dans le formulaire