*** Settings ***
Documentation    CRUD de la table dossier_instruction_type
...    @author  generated
...    @package openADS
...    @version 20/03/2019 18:03

*** Keywords ***

Depuis le contexte type de dossier d'instruction
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_instruction_type}

    # On accède au tableau
    Go To Tab  dossier_instruction_type
    # On recherche l'enregistrement
    Use Simple Search  type de dossier d'instruction  ${dossier_instruction_type}
    # On clique sur le résultat
    Click On Link  ${dossier_instruction_type}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter type de dossier d'instruction
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  dossier_instruction_type
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir type de dossier d'instruction  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_instruction_type} =  Get Text  css=div.form-content span#dossier_instruction_type
    # On le retourne
    [Return]  ${dossier_instruction_type}

Modifier type de dossier d'instruction
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_instruction_type}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte type de dossier d'instruction  ${dossier_instruction_type}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_instruction_type  modifier
    # On saisit des valeurs
    Saisir type de dossier d'instruction  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer type de dossier d'instruction
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_instruction_type}

    # On accède à l'enregistrement
    Depuis le contexte type de dossier d'instruction  ${dossier_instruction_type}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_instruction_type  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir type de dossier d'instruction
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_autorisation_type_detaille" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "suffixe" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mouvement_sitadel" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "maj_da_localisation" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_lot" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_demandeur" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_etat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_date_init" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_date_validite" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_date_doc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_date_daact" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_dt" existe dans "${values}" on execute "Set Checkbox" dans le formulaire