*** Settings ***
Documentation    CRUD de la table avis_decision_type
...    @author  generated
...    @package openADS
...    @version 22/01/2021 10:01

*** Keywords ***

Depuis le contexte Type d'avis de décision
    [Documentation]  Accède au formulaire
    [Arguments]  ${avis_decision_type}

    # On accède au tableau
    Go To Tab  avis_decision_type
    # On recherche l'enregistrement
    Use Simple Search  Type d'avis de décision  ${avis_decision_type}
    # On clique sur le résultat
    Click On Link  ${avis_decision_type}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Type d'avis de décision
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  avis_decision_type
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Type d'avis de décision  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${avis_decision_type} =  Get Text  css=div.form-content span#avis_decision_type
    # On le retourne
    [Return]  ${avis_decision_type}

Modifier Type d'avis de décision
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${avis_decision_type}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Type d'avis de décision  ${avis_decision_type}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  avis_decision_type  modifier
    # On saisit des valeurs
    Saisir Type d'avis de décision  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Type d'avis de décision
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${avis_decision_type}

    # On accède à l'enregistrement
    Depuis le contexte Type d'avis de décision  ${avis_decision_type}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  avis_decision_type  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Type d'avis de décision
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire