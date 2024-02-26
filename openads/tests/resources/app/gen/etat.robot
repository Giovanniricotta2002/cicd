*** Settings ***
Documentation    CRUD de la table etat
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte état
    [Documentation]  Accède au formulaire
    [Arguments]  ${etat}

    # On accède au tableau
    Go To Tab  etat
    # On recherche l'enregistrement
    Use Simple Search  état  ${etat}
    # On clique sur le résultat
    Click On Link  ${etat}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter état
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  etat
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir état  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${etat} =  Get Text  css=div.form-content span#etat
    # On le retourne
    [Return]  ${etat}

Modifier état
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${etat}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte état  ${etat}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  etat  modifier
    # On saisit des valeurs
    Saisir état  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer état
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${etat}

    # On accède à l'enregistrement
    Depuis le contexte état  ${etat}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  etat  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir état
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "statut" existe dans "${values}" on execute "Input Text" dans le formulaire