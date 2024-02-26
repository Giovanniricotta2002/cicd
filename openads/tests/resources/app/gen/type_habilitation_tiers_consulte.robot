*** Settings ***
Documentation    CRUD de la table type_habilitation_tiers_consulte
...    @author  generated
...    @package openADS
...    @version 08/02/2023 10:02

*** Keywords ***

Depuis le contexte type d'habilitation de tiers
    [Documentation]  Accède au formulaire
    [Arguments]  ${type_habilitation_tiers_consulte}

    # On accède au tableau
    Go To Tab  type_habilitation_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  type d'habilitation de tiers  ${type_habilitation_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${type_habilitation_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter type d'habilitation de tiers
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  type_habilitation_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir type d'habilitation de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${type_habilitation_tiers_consulte} =  Get Text  css=div.form-content span#type_habilitation_tiers_consulte
    # On le retourne
    [Return]  ${type_habilitation_tiers_consulte}

Modifier type d'habilitation de tiers
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${type_habilitation_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte type d'habilitation de tiers  ${type_habilitation_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  type_habilitation_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir type d'habilitation de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer type d'habilitation de tiers
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${type_habilitation_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte type d'habilitation de tiers  ${type_habilitation_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  type_habilitation_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir type d'habilitation de tiers
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire