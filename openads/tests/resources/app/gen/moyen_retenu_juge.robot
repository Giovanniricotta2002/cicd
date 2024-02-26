*** Settings ***
Documentation    CRUD de la table moyen_retenu_juge
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Moyens retenus par le juge
    [Documentation]  Accède au formulaire
    [Arguments]  ${moyen_retenu_juge}

    # On accède au tableau
    Go To Tab  moyen_retenu_juge
    # On recherche l'enregistrement
    Use Simple Search  Moyens retenus par le juge  ${moyen_retenu_juge}
    # On clique sur le résultat
    Click On Link  ${moyen_retenu_juge}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Moyens retenus par le juge
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  moyen_retenu_juge
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Moyens retenus par le juge  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${moyen_retenu_juge} =  Get Text  css=div.form-content span#moyen_retenu_juge
    # On le retourne
    [Return]  ${moyen_retenu_juge}

Modifier Moyens retenus par le juge
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${moyen_retenu_juge}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Moyens retenus par le juge  ${moyen_retenu_juge}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  moyen_retenu_juge  modifier
    # On saisit des valeurs
    Saisir Moyens retenus par le juge  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Moyens retenus par le juge
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${moyen_retenu_juge}

    # On accède à l'enregistrement
    Depuis le contexte Moyens retenus par le juge  ${moyen_retenu_juge}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  moyen_retenu_juge  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Moyens retenus par le juge
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire