*** Settings ***
Documentation    CRUD de la table compteur
...    @author  generated
...    @package openADS
...    @version 20/10/2022 18:10

*** Keywords ***

Depuis le contexte compteur
    [Documentation]  Accède au formulaire
    [Arguments]  ${compteur}

    # On accède au tableau
    Go To Tab  compteur
    # On recherche l'enregistrement
    Use Simple Search  compteur  ${compteur}
    # On clique sur le résultat
    Click On Link  ${compteur}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter compteur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  compteur
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir compteur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${compteur} =  Get Text  css=div.form-content span#compteur
    # On le retourne
    [Return]  ${compteur}

Modifier compteur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${compteur}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte compteur  ${compteur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  compteur  modifier
    # On saisit des valeurs
    Saisir compteur  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer compteur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${compteur}

    # On accède à l'enregistrement
    Depuis le contexte compteur  ${compteur}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  compteur  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir compteur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "unite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "quantite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "quota" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "alerte" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_modification" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire