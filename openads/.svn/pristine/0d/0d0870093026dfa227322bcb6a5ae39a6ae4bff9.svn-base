*** Settings ***
Documentation    CRUD de la table objet_recours
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte Objet du recours
    [Documentation]  Accède au formulaire
    [Arguments]  ${objet_recours}

    # On accède au tableau
    Go To Tab  objet_recours
    # On recherche l'enregistrement
    Use Simple Search  Objet du recours  ${objet_recours}
    # On clique sur le résultat
    Click On Link  ${objet_recours}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Objet du recours
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  objet_recours
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Objet du recours  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${objet_recours} =  Get Text  css=div.form-content span#objet_recours
    # On le retourne
    [Return]  ${objet_recours}

Modifier Objet du recours
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${objet_recours}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Objet du recours  ${objet_recours}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  objet_recours  modifier
    # On saisit des valeurs
    Saisir Objet du recours  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Objet du recours
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${objet_recours}

    # On accède à l'enregistrement
    Depuis le contexte Objet du recours  ${objet_recours}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  objet_recours  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Objet du recours
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire