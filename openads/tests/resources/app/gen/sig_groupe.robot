*** Settings ***
Documentation    CRUD de la table sig_groupe
...    @author  generated
...    @package openADS
...    @version 11/06/2021 16:06

*** Keywords ***

Depuis le contexte groupes de référence
    [Documentation]  Accède au formulaire
    [Arguments]  ${sig_groupe}

    # On accède au tableau
    Go To Tab  sig_groupe
    # On recherche l'enregistrement
    Use Simple Search  groupes de référence  ${sig_groupe}
    # On clique sur le résultat
    Click On Link  ${sig_groupe}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter groupes de référence
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  sig_groupe
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir groupes de référence  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${sig_groupe} =  Get Text  css=div.form-content span#sig_groupe
    # On le retourne
    [Return]  ${sig_groupe}

Modifier groupes de référence
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${sig_groupe}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte groupes de référence  ${sig_groupe}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  sig_groupe  modifier
    # On saisit des valeurs
    Saisir groupes de référence  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer groupes de référence
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${sig_groupe}

    # On accède à l'enregistrement
    Depuis le contexte groupes de référence  ${sig_groupe}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  sig_groupe  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir groupes de référence
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire