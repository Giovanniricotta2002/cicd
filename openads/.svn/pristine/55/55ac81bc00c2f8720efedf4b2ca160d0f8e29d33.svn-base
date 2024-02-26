*** Settings ***
Documentation    CRUD de la table lien_demande_type_etat
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte lien entre le type de la demande et l'état du dernier dossier d'instruction
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_demande_type_etat}

    # On accède au tableau
    Go To Tab  lien_demande_type_etat
    # On recherche l'enregistrement
    Use Simple Search  lien entre le type de la demande et l'état du dernier dossier d'instruction  ${lien_demande_type_etat}
    # On clique sur le résultat
    Click On Link  ${lien_demande_type_etat}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien entre le type de la demande et l'état du dernier dossier d'instruction
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_demande_type_etat
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien entre le type de la demande et l'état du dernier dossier d'instruction  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_demande_type_etat} =  Get Text  css=div.form-content span#lien_demande_type_etat
    # On le retourne
    [Return]  ${lien_demande_type_etat}

Modifier lien entre le type de la demande et l'état du dernier dossier d'instruction
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_demande_type_etat}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien entre le type de la demande et l'état du dernier dossier d'instruction  ${lien_demande_type_etat}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_demande_type_etat  modifier
    # On saisit des valeurs
    Saisir lien entre le type de la demande et l'état du dernier dossier d'instruction  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien entre le type de la demande et l'état du dernier dossier d'instruction
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_demande_type_etat}

    # On accède à l'enregistrement
    Depuis le contexte lien entre le type de la demande et l'état du dernier dossier d'instruction  ${lien_demande_type_etat}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_demande_type_etat  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien entre le type de la demande et l'état du dernier dossier d'instruction
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "demande_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "etat" existe dans "${values}" on execute "Select From List By Label" dans le formulaire