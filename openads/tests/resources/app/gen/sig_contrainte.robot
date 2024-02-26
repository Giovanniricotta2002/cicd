*** Settings ***
Documentation    CRUD de la table sig_contrainte
...    @author  generated
...    @package openADS
...    @version 11/06/2021 16:06

*** Keywords ***

Depuis le contexte contraintes de référence
    [Documentation]  Accède au formulaire
    [Arguments]  ${sig_contrainte}

    # On accède au tableau
    Go To Tab  sig_contrainte
    # On recherche l'enregistrement
    Use Simple Search  contraintes de référence  ${sig_contrainte}
    # On clique sur le résultat
    Click On Link  ${sig_contrainte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter contraintes de référence
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  sig_contrainte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir contraintes de référence  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${sig_contrainte} =  Get Text  css=div.form-content span#sig_contrainte
    # On le retourne
    [Return]  ${sig_contrainte}

Modifier contraintes de référence
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${sig_contrainte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte contraintes de référence  ${sig_contrainte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  sig_contrainte  modifier
    # On saisit des valeurs
    Saisir contraintes de référence  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer contraintes de référence
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${sig_contrainte}

    # On accède à l'enregistrement
    Depuis le contexte contraintes de référence  ${sig_contrainte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  sig_contrainte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir contraintes de référence
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "nature" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "groupe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "sousgroupe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "texte" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "texte_genere" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "no_ordre" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "service_consulte" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "sig_couche" existe dans "${values}" on execute "Select From List By Label" dans le formulaire