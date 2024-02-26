*** Settings ***
Documentation    CRUD de la table lot
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte lot
    [Documentation]  Accède au formulaire
    [Arguments]  ${lot}

    # On accède au tableau
    Go To Tab  lot
    # On recherche l'enregistrement
    Use Simple Search  lot  ${lot}
    # On clique sur le résultat
    Click On Link  ${lot}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lot
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lot
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lot  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lot} =  Get Text  css=div.form-content span#lot
    # On le retourne
    [Return]  ${lot}

Modifier lot
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lot}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lot  ${lot}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lot  modifier
    # On saisit des valeurs
    Saisir lot  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lot
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lot}

    # On accède à l'enregistrement
    Depuis le contexte lot  ${lot}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lot  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lot
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_autorisation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire