*** Settings ***
Documentation    CRUD de la table nature_travaux
...    @author  generated
...    @package openADS
...    @version 28/03/2023 16:03

*** Keywords ***

Depuis le contexte de la nature de travaux
    [Documentation]  Accède au formulaire
    [Arguments]  ${nature_travaux}

    # On accède au tableau
    Depuis le listing  nature_travaux
    # On recherche l'enregistrement
    Use Simple Search  nature des travaux  ${nature_travaux}
    # On clique sur le résultat
    Click On Link  ${nature_travaux}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter la nature de travaux
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}  ${dit}=${EMPTY}

    # On accède au tableau
    Depuis le listing  nature_travaux
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir la nature de travaux  ${values}  ${dit}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${nature_travaux} =  Get Text  css=div.form-content span#nature_travaux
    # On le retourne
    [Return]  ${nature_travaux}

Modifier la nature de travaux
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${nature_travaux}  ${values}  ${dit}=${EMPTY}

    # On accède à l'enregistrement
    Depuis le contexte de la nature de travaux  ${nature_travaux}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  nature_travaux  modifier
    # On saisit des valeurs
    Saisir la nature de travaux  ${values}  ${dit}
    # On valide le formulaire
    Click On Submit Button

Supprimer la nature des travaux
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${nature_travaux}

    # On accède à l'enregistrement
    Depuis le contexte de la nature de travaux  ${nature_travaux}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  nature_travaux  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir la nature de travaux
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}  ${dit}=${EMPTY}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "famille_travaux" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Text" dans le formulaire
    ${is_list}=      Evaluate     isinstance(${dit}, list)
    Run Keyword If  ${is_list}  Select From Multiple Chosen List  dossier_instruction_type  ${dit}
