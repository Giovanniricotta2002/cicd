*** Settings ***
Documentation    CRUD de la table commune
...    @author  generated
...    @package openADS
...    @version 20/08/2020 15:08

*** Keywords ***

Depuis le contexte commune
    [Documentation]  Accède au formulaire
    [Arguments]  ${commune}

    # On accède au tableau
    Go To Tab  commune
    # On recherche l'enregistrement
    Use Simple Search  commune  ${commune}
    # On clique sur le résultat
    Click On Link  ${commune}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter commune
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  commune
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir commune  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${commune} =  Get Text  css=div.form-content span#commune
    # On le retourne
    [Return]  ${commune}

Modifier commune
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${commune}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte commune  ${commune}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  commune  modifier
    # On saisit des valeurs
    Saisir commune  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer commune
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${commune}

    # On accède à l'enregistrement
    Depuis le contexte commune  ${commune}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  commune  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir commune
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "typecom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "com" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "reg" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dep" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "arr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tncc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ncc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "nccenr" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "can" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "comparent" existe dans "${values}" on execute "Input Text" dans le formulaire