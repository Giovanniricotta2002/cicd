*** Settings ***
Documentation    CRUD de la table instructeur_qualite
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Qualité de l'instructeur
    [Documentation]  Accède au formulaire
    [Arguments]  ${instructeur_qualite}

    # On accède au tableau
    Go To Tab  instructeur_qualite
    # On recherche l'enregistrement
    Use Simple Search  Qualité de l'instructeur  ${instructeur_qualite}
    # On clique sur le résultat
    Click On Link  ${instructeur_qualite}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Qualité de l'instructeur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  instructeur_qualite
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Qualité de l'instructeur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${instructeur_qualite} =  Get Text  css=div.form-content span#instructeur_qualite
    # On le retourne
    [Return]  ${instructeur_qualite}

Modifier Qualité de l'instructeur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${instructeur_qualite}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Qualité de l'instructeur  ${instructeur_qualite}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  instructeur_qualite  modifier
    # On saisit des valeurs
    Saisir Qualité de l'instructeur  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Qualité de l'instructeur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${instructeur_qualite}

    # On accède à l'enregistrement
    Depuis le contexte Qualité de l'instructeur  ${instructeur_qualite}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  instructeur_qualite  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Qualité de l'instructeur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire