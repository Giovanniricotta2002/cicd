*** Settings ***
Documentation    CRUD de la table bible
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte bible
    [Documentation]  Accède au formulaire
    [Arguments]  ${bible}

    # On accède au tableau
    Go To Tab  bible
    # On recherche l'enregistrement
    Use Simple Search  bible  ${bible}
    # On clique sur le résultat
    Click On Link  ${bible}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter bible
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  bible
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir bible  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${bible} =  Get Text  css=div.form-content span#bible
    # On le retourne
    [Return]  ${bible}

Modifier bible
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${bible}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte bible  ${bible}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  bible  modifier
    # On saisit des valeurs
    Saisir bible  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer bible
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${bible}

    # On accède à l'enregistrement
    Depuis le contexte bible  ${bible}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  bible  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir bible
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "evenement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "contenu" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "complement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "automatique" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_autorisation_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire