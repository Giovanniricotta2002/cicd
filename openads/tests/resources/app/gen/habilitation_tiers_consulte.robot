*** Settings ***
Documentation    CRUD de la table habilitation_tiers_consulte
...    @author  generated
...    @package openADS
...    @version 08/02/2023 10:02

*** Keywords ***

Depuis le contexte habilitation de tiers
    [Documentation]  Accède au formulaire
    [Arguments]  ${habilitation_tiers_consulte}

    # On accède au tableau
    Go To Tab  habilitation_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  habilitation de tiers  ${habilitation_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${habilitation_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter habilitation de tiers
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  habilitation_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir habilitation de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${habilitation_tiers_consulte} =  Get Text  css=div.form-content span#habilitation_tiers_consulte
    # On le retourne
    [Return]  ${habilitation_tiers_consulte}

Modifier habilitation de tiers
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${habilitation_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte habilitation de tiers  ${habilitation_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  habilitation_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir habilitation de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer habilitation de tiers
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${habilitation_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte habilitation de tiers  ${habilitation_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  habilitation_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir habilitation de tiers
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "type_habilitation_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "texte_agrement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "division_territoriales" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire