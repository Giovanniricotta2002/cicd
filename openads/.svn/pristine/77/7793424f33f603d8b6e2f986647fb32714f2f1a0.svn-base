*** Settings ***
Documentation    Actions spécifiques aux sous-groupes de références du SIG

*** Keywords ***

Depuis le contexte du sous-groupe de référence
    [Documentation]  Accède au formulaire
    [Arguments]  ${sig_sousgroupe}

    # On accède au tableau
    Depuis le listing  sig_sousgroupe
    # On recherche l'enregistrement
    Use Simple Search  sous-groupe de référence  ${sig_sousgroupe}
    # On clique sur le résultat
    Click On Link  ${sig_sousgroupe}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter le sous-groupe de référence
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  sig_sousgroupe
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le sous-groupe de référence  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${sig_sousgroupe} =  Get Text  css=div.form-content span#sig_sousgroupe
    # On le retourne
    [Return]  ${sig_sousgroupe}

Modifier le sous-groupe de référence
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${sig_sousgroupe}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte du sous-groupe de référence  ${sig_sousgroupe}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  sig_sousgroupe  modifier
    # On saisit des valeurs
    Saisir le sous-groupe de référence  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer le sous-groupe de référence
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${sig_sousgroupe}

    # On accède à l'enregistrement
    Depuis le contexte du sous-groupe de référence  ${sig_sousgroupe}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  sig_sousgroupe  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir le sous-groupe de référence
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire