*** Settings ***
Documentation    CRUD de la table lien_type_di_type_di
...    @author  generated
...    @package openADS
...    @version 04/08/2022 19:08

*** Keywords ***

Depuis le contexte lien_type_di_type_di
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_type_di_type_di}

    # On accède au tableau
    Go To Tab  lien_type_di_type_di
    # On recherche l'enregistrement
    Use Simple Search  lien_type_di_type_di  ${lien_type_di_type_di}
    # On clique sur le résultat
    Click On Link  ${lien_type_di_type_di}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien_type_di_type_di
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_type_di_type_di
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien_type_di_type_di  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_type_di_type_di} =  Get Text  css=div.form-content span#lien_type_di_type_di
    # On le retourne
    [Return]  ${lien_type_di_type_di}

Modifier lien_type_di_type_di
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_type_di_type_di}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien_type_di_type_di  ${lien_type_di_type_di}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_type_di_type_di  modifier
    # On saisit des valeurs
    Saisir lien_type_di_type_di  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien_type_di_type_di
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_type_di_type_di}

    # On accède à l'enregistrement
    Depuis le contexte lien_type_di_type_di  ${lien_type_di_type_di}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_type_di_type_di  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien_type_di_type_di
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "type_di_parent" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire