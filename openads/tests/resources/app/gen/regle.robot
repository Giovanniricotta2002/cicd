*** Settings ***
Documentation    CRUD de la table regle
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte règle
    [Documentation]  Accède au formulaire
    [Arguments]  ${regle}

    # On accède au tableau
    Go To Tab  regle
    # On recherche l'enregistrement
    Use Simple Search  règle  ${regle}
    # On clique sur le résultat
    Click On Link  ${regle}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter règle
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  regle
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir règle  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${regle} =  Get Text  css=div.form-content span#regle
    # On le retourne
    [Return]  ${regle}

Modifier règle
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${regle}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte règle  ${regle}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  regle  modifier
    # On saisit des valeurs
    Saisir règle  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer règle
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${regle}

    # On accède à l'enregistrement
    Depuis le contexte règle  ${regle}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  regle  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir règle
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "sens" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ordre" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "controle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "id" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "champ" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "operateur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "valeur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "message" existe dans "${values}" on execute "Input Text" dans le formulaire