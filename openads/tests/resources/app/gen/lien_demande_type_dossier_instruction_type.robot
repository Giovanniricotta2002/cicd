*** Settings ***
Documentation    CRUD de la table lien_demande_type_dossier_instruction_type
...    @author  generated
...    @package openADS
...    @version 15/11/2018 16:11

*** Keywords ***

Depuis le contexte lien_demande_type_dossier_instruction_type
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_demande_type_dossier_instruction_type}

    # On accède au tableau
    Go To Tab  lien_demande_type_dossier_instruction_type
    # On recherche l'enregistrement
    Use Simple Search  lien_demande_type_dossier_instruction_type  ${lien_demande_type_dossier_instruction_type}
    # On clique sur le résultat
    Click On Link  ${lien_demande_type_dossier_instruction_type}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien_demande_type_dossier_instruction_type
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_demande_type_dossier_instruction_type
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien_demande_type_dossier_instruction_type  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_demande_type_dossier_instruction_type} =  Get Text  css=div.form-content span#lien_demande_type_dossier_instruction_type
    # On le retourne
    [Return]  ${lien_demande_type_dossier_instruction_type}

Modifier lien_demande_type_dossier_instruction_type
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_demande_type_dossier_instruction_type}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien_demande_type_dossier_instruction_type  ${lien_demande_type_dossier_instruction_type}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_demande_type_dossier_instruction_type  modifier
    # On saisit des valeurs
    Saisir lien_demande_type_dossier_instruction_type  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien_demande_type_dossier_instruction_type
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_demande_type_dossier_instruction_type}

    # On accède à l'enregistrement
    Depuis le contexte lien_demande_type_dossier_instruction_type  ${lien_demande_type_dossier_instruction_type}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_demande_type_dossier_instruction_type  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien_demande_type_dossier_instruction_type
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "demande_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire