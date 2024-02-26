*** Settings ***
Documentation    CRUD de la table demande_type
...    @author  generated
...    @package openADS
...    @version 20/03/2019 18:03

*** Keywords ***

Depuis le contexte type de demande
    [Documentation]  Accède au formulaire
    [Arguments]  ${demande_type}

    # On accède au tableau
    Go To Tab  demande_type
    # On recherche l'enregistrement
    Use Simple Search  type de demande  ${demande_type}
    # On clique sur le résultat
    Click On Link  ${demande_type}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter type de demande
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  demande_type
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir type de demande  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${demande_type} =  Get Text  css=div.form-content span#demande_type
    # On le retourne
    [Return]  ${demande_type}

Modifier type de demande
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${demande_type}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte type de demande  ${demande_type}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  demande_type  modifier
    # On saisit des valeurs
    Saisir type de demande  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer type de demande
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${demande_type}

    # On accède à l'enregistrement
    Depuis le contexte type de demande  ${demande_type}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  demande_type  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir type de demande
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "demande_nature" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "groupe" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_autorisation_type_detaille" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "contraintes" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "qualification" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "evenement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "document_obligatoire" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regeneration_cle_citoyen" existe dans "${values}" on execute "Set Checkbox" dans le formulaire