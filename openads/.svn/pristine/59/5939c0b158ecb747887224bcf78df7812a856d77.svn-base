*** Settings ***
Documentation    CRUD de la table dossier_instruction_type
...    @author  generated
...    @package openADS
...    @version 22/12/2015 11:12

*** Keywords ***

Depuis le contexte type de dossier d'instruction
    [Documentation]  Accède au formulaire
    [Arguments]  ${dossier_instruction_type}  ${code}

    # On accède au tableau
    Depuis le listing  dossier_instruction_type
    # On recherche l'enregistrement
    Use Simple Search  Tous  ${dossier_instruction_type}
    # On clique sur le résultat
    Click On Link  ${code}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter type de dossier d'instruction
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au formulaire d'ajout
    Depuis le formulaire d'ajout d'un type de dossier d'instruction
    # On saisit des valeurs
    Saisir type de dossier d'instruction  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${dossier_instruction_type} =  Get Text  css=div.form-content span#dossier_instruction_type
    # On le retourne
    [Return]  ${dossier_instruction_type}

Depuis le formulaire d'ajout d'un type de dossier d'instruction
    [Documentation]  Accède au formulaire d'ajout d'un type de dossier d'instruction.

    # On accède au tableau
    Depuis le listing  dossier_instruction_type
    # On clique sur le bouton ajouter
    Click On Add Button

Modifier type de dossier d'instruction
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${dossier_instruction_type}  ${code}  ${values}

    # On accède au formulaire de modification
    Depuis le formulaire de modification d'un type de dossier d'instruction  ${dossier_instruction_type}  ${code}
    # On saisit des valeurs
    Saisir type de dossier d'instruction  ${values}
    # On valide le formulaire
    Click On Submit Button

Depuis le formulaire de modification d'un type de dossier d'instruction
    [Documentation]  Accède au formulaire de modification d'un type de dossier d'instruction.
    [Arguments]  ${dossier_instruction_type}  ${code}

    # On accède à l'enregistrement
    Depuis le contexte type de dossier d'instruction  ${dossier_instruction_type}  ${code}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  dossier_instruction_type  modifier

Supprimer type de dossier d'instruction
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${dossier_instruction_type}  ${code}

    # On accède au formulaire de suppression
    Depuis le formulaire de suppression d'un type de dossier d'instruction  ${dossier_instruction_type}  ${code}
    # On valide le formulaire
    Click On Submit Button

Depuis le formulaire de suppression d'un type de dossier d'instruction
    [Documentation]  Accède au formulaire de modification d'un type de dossier d'instruction.
    [Arguments]  ${dossier_instruction_type}  ${code}

    # On accède à l'enregistrement
    Depuis le contexte type de dossier d'instruction  ${dossier_instruction_type}  ${code}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  dossier_instruction_type  supprimer

Saisir type de dossier d'instruction
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Wait Until Page Contains Element  css=#code
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier_autorisation_type_detaille" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "suffixe" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "mouvement_sitadel" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "maj_da_localisation" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_lot" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_demandeur" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_etat" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_date_init" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_date_validite" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_date_doc" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_date_daact" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "maj_da_dt" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "sous_dossier" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "lien_sous_dossier_type_di" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire
    # Déselectionne tous les résultats puis reselectionne les valeurs voules
    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${values}    categories_tiers
    Run Keyword If    ${exist} == True    Unselect All From List    categories_tiers
    Si "categories_tiers" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire
    # Déselectionne tous les résultats puis reselectionne les valeurs voules
    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${values}    categories_tiers_ajout_auto
    Run Keyword If    ${exist} == True    Unselect All From List    categories_tiers_ajout_auto
    Si "categories_tiers_ajout_auto" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire
