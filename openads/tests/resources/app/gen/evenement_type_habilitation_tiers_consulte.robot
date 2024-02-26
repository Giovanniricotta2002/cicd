*** Settings ***
Documentation    CRUD de la table evenement_type_habilitation_tiers_consulte
...    @author  generated
...    @package openADS
...    @version 17/10/2022 11:10

*** Keywords ***

Depuis le contexte evenement_type_habilitation_tiers_consulte
    [Documentation]  Accède au formulaire
    [Arguments]  ${evenement_type_habilitation_tiers_consulte}

    # On accède au tableau
    Go To Tab  evenement_type_habilitation_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  evenement_type_habilitation_tiers_consulte  ${evenement_type_habilitation_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${evenement_type_habilitation_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter evenement_type_habilitation_tiers_consulte
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  evenement_type_habilitation_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir evenement_type_habilitation_tiers_consulte  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${evenement_type_habilitation_tiers_consulte} =  Get Text  css=div.form-content span#evenement_type_habilitation_tiers_consulte
    # On le retourne
    [Return]  ${evenement_type_habilitation_tiers_consulte}

Modifier evenement_type_habilitation_tiers_consulte
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${evenement_type_habilitation_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte evenement_type_habilitation_tiers_consulte  ${evenement_type_habilitation_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  evenement_type_habilitation_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir evenement_type_habilitation_tiers_consulte  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer evenement_type_habilitation_tiers_consulte
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${evenement_type_habilitation_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte evenement_type_habilitation_tiers_consulte  ${evenement_type_habilitation_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  evenement_type_habilitation_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir evenement_type_habilitation_tiers_consulte
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "evenement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "type_habilitation_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire