*** Settings ***
Documentation    CRUD de la table lien_habilitation_tiers_consulte_specialite_tiers_consulte
...    @author  generated
...    @package openADS
...    @version 08/02/2023 10:02

*** Keywords ***

Depuis le contexte spécialité(s) des habilitations de tiers
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_habilitation_tiers_consulte_specialite_tiers_consulte}

    # On accède au tableau
    Go To Tab  lien_habilitation_tiers_consulte_specialite_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  spécialité(s) des habilitations de tiers  ${lien_habilitation_tiers_consulte_specialite_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${lien_habilitation_tiers_consulte_specialite_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter spécialité(s) des habilitations de tiers
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_habilitation_tiers_consulte_specialite_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir spécialité(s) des habilitations de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_habilitation_tiers_consulte_specialite_tiers_consulte} =  Get Text  css=div.form-content span#lien_habilitation_tiers_consulte_specialite_tiers_consulte
    # On le retourne
    [Return]  ${lien_habilitation_tiers_consulte_specialite_tiers_consulte}

Modifier spécialité(s) des habilitations de tiers
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_habilitation_tiers_consulte_specialite_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte spécialité(s) des habilitations de tiers  ${lien_habilitation_tiers_consulte_specialite_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_habilitation_tiers_consulte_specialite_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir spécialité(s) des habilitations de tiers  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer spécialité(s) des habilitations de tiers
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_habilitation_tiers_consulte_specialite_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte spécialité(s) des habilitations de tiers  ${lien_habilitation_tiers_consulte_specialite_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_habilitation_tiers_consulte_specialite_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir spécialité(s) des habilitations de tiers
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "habilitation_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "specialite_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire