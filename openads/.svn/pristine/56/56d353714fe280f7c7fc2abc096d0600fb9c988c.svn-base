*** Settings ***
Documentation    CRUD de la table rapport_instruction
...    @author  generated
...    @package openADS
...    @version 23/10/2018 13:10

*** Keywords ***

Depuis le contexte rapport d'instruction
    [Documentation]  Accède au formulaire
    [Arguments]  ${rapport_instruction}

    # On accède au tableau
    Go To Tab  rapport_instruction
    # On recherche l'enregistrement
    Use Simple Search  rapport d'instruction  ${rapport_instruction}
    # On clique sur le résultat
    Click On Link  ${rapport_instruction}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter rapport d'instruction
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  rapport_instruction
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir rapport d'instruction  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${rapport_instruction} =  Get Text  css=div.form-content span#rapport_instruction
    # On le retourne
    [Return]  ${rapport_instruction}

Modifier rapport d'instruction
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${rapport_instruction}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte rapport d'instruction  ${rapport_instruction}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  rapport_instruction  modifier
    # On saisit des valeurs
    Saisir rapport d'instruction  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer rapport d'instruction
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${rapport_instruction}

    # On accède à l'enregistrement
    Depuis le contexte rapport d'instruction  ${rapport_instruction}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  rapport_instruction  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir rapport d'instruction
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier_instruction" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "analyse_reglementaire_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "description_projet_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "proposition_decision" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_fichier_rapport_instruction" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_final_rapport_instruction" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "complement_om_html" existe dans "${values}" on execute "Input HTML" dans le formulaire
    Si "om_fichier_rapport_instruction_dossier_final" existe dans "${values}" on execute "Set Checkbox" dans le formulaire