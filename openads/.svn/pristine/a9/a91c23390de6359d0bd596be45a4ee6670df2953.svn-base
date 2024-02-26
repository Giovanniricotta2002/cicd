*** Settings ***
Documentation    CRUD de la table lien_sig_contrainte_evenement
...    @author  generated
...    @package openADS
...    @version 28/03/2023 10:03

*** Keywords ***

Depuis le contexte Événements Suggérés
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_sig_contrainte_evenement}

    # On accède au tableau
    Go To Tab  lien_sig_contrainte_evenement
    # On recherche l'enregistrement
    Use Simple Search  Événements Suggérés  ${lien_sig_contrainte_evenement}
    # On clique sur le résultat
    Click On Link  ${lien_sig_contrainte_evenement}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Événements Suggérés
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_sig_contrainte_evenement
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Événements Suggérés  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_sig_contrainte_evenement} =  Get Text  css=div.form-content span#lien_sig_contrainte_evenement
    # On le retourne
    [Return]  ${lien_sig_contrainte_evenement}

Modifier Événements Suggérés
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_sig_contrainte_evenement}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Événements Suggérés  ${lien_sig_contrainte_evenement}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_sig_contrainte_evenement  modifier
    # On saisit des valeurs
    Saisir Événements Suggérés  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Événements Suggérés
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_sig_contrainte_evenement}

    # On accède à l'enregistrement
    Depuis le contexte Événements Suggérés  ${lien_sig_contrainte_evenement}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_sig_contrainte_evenement  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Événements Suggérés
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "sig_contrainte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "evenement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire