*** Settings ***
Documentation    CRUD de la table lien_dossier_instruction_type_evenement
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte lien dossier d'instruction/type d'evenement
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_dossier_instruction_type_evenement}

    # On accède au tableau
    Go To Tab  lien_dossier_instruction_type_evenement
    # On recherche l'enregistrement
    Use Simple Search  lien dossier d'instruction/type d'evenement  ${lien_dossier_instruction_type_evenement}
    # On clique sur le résultat
    Click On Link  ${lien_dossier_instruction_type_evenement}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien dossier d'instruction/type d'evenement
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_dossier_instruction_type_evenement
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien dossier d'instruction/type d'evenement  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_dossier_instruction_type_evenement} =  Get Text  css=div.form-content span#lien_dossier_instruction_type_evenement
    # On le retourne
    [Return]  ${lien_dossier_instruction_type_evenement}

Modifier lien dossier d'instruction/type d'evenement
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_dossier_instruction_type_evenement}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien dossier d'instruction/type d'evenement  ${lien_dossier_instruction_type_evenement}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_dossier_instruction_type_evenement  modifier
    # On saisit des valeurs
    Saisir lien dossier d'instruction/type d'evenement  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien dossier d'instruction/type d'evenement
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_dossier_instruction_type_evenement}

    # On accède à l'enregistrement
    Depuis le contexte lien dossier d'instruction/type d'evenement  ${lien_dossier_instruction_type_evenement}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_dossier_instruction_type_evenement  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien dossier d'instruction/type d'evenement
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "evenement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire