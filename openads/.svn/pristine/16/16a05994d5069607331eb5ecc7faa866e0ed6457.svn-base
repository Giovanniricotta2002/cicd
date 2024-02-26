*** Settings ***
Documentation    CRUD de la table habilitation_tiers_consulte
...    @author  generated
...    @package openADS
...    @version 07/06/2022 18:06

*** Keywords ***

Depuis le contexte de l'habilitation de tiers consulté
    [Documentation]  Accède au formulaire
    [Arguments]  ${habilitation_tiers_consulte}

    # On accède au tableau
    Depuis le listing  habilitation_tiers_consulte
    # On recherche l'enregistrement
    Rechercher en recherche avancée simple  ${habilitation_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${habilitation_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter une habilitation de tiers consulté
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}  ${div_territoire_intervention_dept}=${EMPTY}  ${div_territoire_intervention_comm}=${EMPTY}

    # On accède au tableau
    Depuis le listing  habilitation_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir une habilitation de tiers consulté  ${values}  ${div_territoire_intervention_dept}  ${div_territoire_intervention_comm}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${habilitation_tiers_consulte} =  Get Text  css=div.form-content span#habilitation_tiers_consulte
    # On le retourne
    [Return]  ${habilitation_tiers_consulte}

Modifier une habilitation de tiers consulté
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${habilitation_tiers_consulte}  ${values}  ${div_territoire_intervention_dept}=${EMPTY}  ${div_territoire_intervention_comm}=${EMPTY}

    # On accède à l'enregistrement
    Depuis le contexte de l'habilitation de tiers consulté  ${habilitation_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  habilitation_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir une habilitation de tiers consulté  ${values}  ${div_territoire_intervention_dept}  ${div_territoire_intervention_comm}
    # On valide le formulaire
    Click On Submit Button

Supprimer une habilitation de tiers consulté
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${habilitation_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte de l'habilitation de tiers consulté  ${habilitation_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  habilitation_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir une habilitation de tiers consulté
    [Documentation]  Remplit le formulaire.
    [Arguments]  ${values}  ${div_territoire_intervention_dept}=${EMPTY}  ${div_territoire_intervention_comm}=${EMPTY}
   
    Si "type_habilitation_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "texte_agrement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "division_territoriales" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    # Remplissage du champs chosen "Division territoriale d’intervention commune" si des valeurs ont été passée
    # en paramètre
    ${is_list}=      Evaluate     isinstance($div_territoire_intervention_comm, list)
    Run Keyword If  ${is_list}  Select From Multiple Chosen List  division_territoire_intervention_commune  ${div_territoire_intervention_comm}
    # Idem pour le champs chosen "Division territoriale d’intervention departement"
    ${is_list}=      Evaluate     isinstance($div_territoire_intervention_dept, list)
    Run Keyword If  ${is_list}  Select From Multiple Chosen List  division_territoire_intervention_departement  ${div_territoire_intervention_dept}
    Si "specialite_tiers_consulte" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire

Rechercher des habilitations de tiers consultes
    [Documentation]  Accède au formulaire de recherche avancé des habilitation de tiers. Dans
    ...  le formulaire saisie les valeurs fourni et clique sur recherche.
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  habilitation_tiers_consulte
    # Ouvre la recherche avancée
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#habilitation_tiers_consulte
    # Saisie les valeurs
    Saisir les parametres de recherche avancee des habilitations de tiers consulte  ${values}
    # Valide la recherche
    Click On Search Button

Saisir les parametres de recherche avancee des habilitations de tiers consulte
    [Documentation]  Entre les valeurs fournies dans le formulaire de saisie de la recherche.
    [Arguments]  ${values}

    Si "habilitation_tiers_consulte" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "type_habilitation_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_validite_debut_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_fin_min" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_fin_max" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "division_territoriales" existe dans "${values}" on execute "Input Text" dans le formulaire
