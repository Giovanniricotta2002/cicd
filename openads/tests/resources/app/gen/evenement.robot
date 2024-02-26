*** Settings ***
Documentation    CRUD de la table evenement
...    @author  generated
...    @package openADS
...    @version 21/01/2021 15:01

*** Keywords ***

Depuis le contexte événement
    [Documentation]  Accède au formulaire
    [Arguments]  ${evenement}

    # On accède au tableau
    Go To Tab  evenement
    # On recherche l'enregistrement
    Use Simple Search  événement  ${evenement}
    # On clique sur le résultat
    Click On Link  ${evenement}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter événement
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  evenement
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir événement  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${evenement} =  Get Text  css=div.form-content span#evenement
    # On le retourne
    [Return]  ${evenement}

Modifier événement
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${evenement}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte événement  ${evenement}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  evenement  modifier
    # On saisit des valeurs
    Saisir événement  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer événement
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${evenement}

    # On accède à l'enregistrement
    Depuis le contexte événement  ${evenement}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  evenement  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir événement
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "action" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "etat" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "delai" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "accord_tacite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "delai_notification" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lettretype" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "consultation" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "avis_decision" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "restriction" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "evenement_retour_ar" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "evenement_suivant_tacite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "evenement_retour_signature" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "autorite_competente" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "retour" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "non_verrouillable" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "phase" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "finaliser_automatiquement" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "pec_metier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire