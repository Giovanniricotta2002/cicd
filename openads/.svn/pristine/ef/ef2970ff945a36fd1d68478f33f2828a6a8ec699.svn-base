*** Settings ***
Documentation    CRUD de la table action

*** Keywords ***

Depuis le contexte Action
    [Documentation]  Accède au formulaire
    [Arguments]  ${action}

    # On accède au tableau
    Depuis le listing  action
    # On recherche l'enregistrement
    Use Simple Search  Action  ${action}
    # On clique sur le résultat
    Click On Link  ${action}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter Action
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  action
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Action  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${action} =  Get Text  css=div.form-content span#action
    # On le retourne
    [Return]  ${action}

Modifier Action
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${action}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Action  ${action}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  action  modifier
    # On saisit des valeurs
    Saisir Action  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Action
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${action}

    # On accède à l'enregistrement
    Depuis le contexte Action  ${action}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  action  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Action
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "action" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_etat" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_delai" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_accord_tacite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_avis" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_limite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_notification_delai" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_complet" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_validite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_decision" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_chantier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_achevement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_conformite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_rejet" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_dernier_depot" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_limite_incompletude" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_delai_incompletude" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_autorite_competente" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_cloture_instruction" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_premiere_visite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_derniere_visite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_contradictoire" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_retour_contradictoire" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_ait" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_transmission_parquet" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_donnees_techniques1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_donnees_techniques2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_donnees_techniques3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_donnees_techniques4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_donnees_techniques5" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cible_regle_donnees_techniques1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cible_regle_donnees_techniques2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cible_regle_donnees_techniques3" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cible_regle_donnees_techniques4" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cible_regle_donnees_techniques5" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_dossier_instruction_type" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "regle_date_affichage" existe dans "${values}" on execute "Input Text" dans le formulaire
