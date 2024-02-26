*** Settings ***
Documentation    Actions spécifiques aux groupes de référence du SIG

*** Keywords ***

Depuis le contexte du groupe de référence
    [Documentation]  Accède au formulaire
    [Arguments]  ${sig_groupe}

    # On accède au tableau
    Depuis le listing  sig_groupe
    # On recherche l'enregistrement
    Use Simple Search  groupe de référence  ${sig_groupe}
    # On clique sur le résultat
    Click On Link  ${sig_groupe}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter le groupe de référence
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  sig_groupe
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le groupe de référence  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${sig_groupe} =  Get Text  css=div.form-content span#sig_groupe
    # On le retourne
    [Return]  ${sig_groupe}

Modifier le groupe de référence
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${sig_groupe}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte du groupe de référence  ${sig_groupe}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  sig_groupe  modifier
    # On saisit des valeurs
    Saisir groupe de référence  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer le groupe de référence
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${sig_groupe}

    # On accède à l'enregistrement
    Depuis le contexte du groupe de référence  ${sig_groupe}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  sig_groupe  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir le groupe de référence
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire