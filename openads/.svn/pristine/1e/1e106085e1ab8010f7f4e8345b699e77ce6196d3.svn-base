*** Settings ***
Documentation    CRUD de la table moyen_souleve
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Moyens soulevés
    [Documentation]  Accède au formulaire
    [Arguments]  ${moyen_souleve}

    # On accède au tableau
    Go To Tab  moyen_souleve
    # On recherche l'enregistrement
    Use Simple Search  Moyens soulevés  ${moyen_souleve}
    # On clique sur le résultat
    Click On Link  ${moyen_souleve}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Moyens soulevés
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  moyen_souleve
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Moyens soulevés  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${moyen_souleve} =  Get Text  css=div.form-content span#moyen_souleve
    # On le retourne
    [Return]  ${moyen_souleve}

Modifier Moyens soulevés
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${moyen_souleve}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Moyens soulevés  ${moyen_souleve}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  moyen_souleve  modifier
    # On saisit des valeurs
    Saisir Moyens soulevés  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Moyens soulevés
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${moyen_souleve}

    # On accède à l'enregistrement
    Depuis le contexte Moyens soulevés  ${moyen_souleve}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  moyen_souleve  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Moyens soulevés
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire