*** Settings ***
Documentation    CRUD de la table dossier_contrainte
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Contraintes liées au dossier
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_contrainte}

    # On accède au tableau
    Go To Tab  dossier_contrainte
    # On recherche l'enregistrement
    Use Simple Search  Contraintes liées au dossier  ${dossier_contrainte}
    # On clique sur le résultat
    Click On Link  ${dossier_contrainte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Contraintes liées au dossier
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_contrainte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Contraintes liées au dossier  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_contrainte} =  Get Text  css=div.form-content span#dossier_contrainte
    # On le retourne
    [Return]  ${dossier_contrainte}

Modifier Contraintes liées au dossier
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_contrainte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Contraintes liées au dossier  ${dossier_contrainte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_contrainte  modifier
    # On saisit des valeurs
    Saisir Contraintes liées au dossier  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Contraintes liées au dossier
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_contrainte}

    # On accède à l'enregistrement
    Depuis le contexte Contraintes liées au dossier  ${dossier_contrainte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_contrainte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Contraintes liées au dossier
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "contrainte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "texte_complete" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "reference" existe dans "${values}" on execute "Set Checkbox" dans le formulaire