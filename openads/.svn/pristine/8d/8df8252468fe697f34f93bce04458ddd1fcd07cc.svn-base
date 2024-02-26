*** Settings ***
Documentation    CRUD de la table tiers_consulte
...    @author  generated
...    @package openADS
...    @version 08/02/2023 10:02

*** Keywords ***

Depuis le contexte tiers
    [Documentation]  Accède au formulaire
    [Arguments]  ${tiers_consulte}

    # On accède au tableau
    Go To Tab  tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  tiers  ${tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter tiers
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir tiers  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${tiers_consulte} =  Get Text  css=div.form-content span#tiers_consulte
    # On le retourne
    [Return]  ${tiers_consulte}

Modifier tiers
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte tiers  ${tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  tiers_consulte  modifier
    # On saisit des valeurs
    Saisir tiers  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer tiers
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte tiers  ${tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir tiers
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "categorie_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "abrege" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "complement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ville" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "liste_diffusion" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "accepte_notification_email" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "uid_platau_acteur" existe dans "${values}" on execute "Input Text" dans le formulaire