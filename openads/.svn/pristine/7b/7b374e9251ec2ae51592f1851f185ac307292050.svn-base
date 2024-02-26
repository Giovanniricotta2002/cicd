*** Settings ***
Documentation    CRUD de la table tiers_consulte
...    @author  generated
...    @package openADS
...    @version 25/02/2022 18:02

*** Keywords ***

Depuis le contexte tiers_consulte
    [Documentation]  Accède au formulaire
    [Arguments]  ${tiers_consulte}

    # On accède au tableau
    Depuis le listing  tiers_consulte
    # On recherche l'enregistrement
    Input Text  css=#adv-search-classic-fields input.champFormulaire  ${tiers_consulte}
    # On valide le formulaire de recherche
    Click On Search Button
    # On clique sur le résultat
    Click On Link  ${tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Rechercher des tiers consultes
    [Documentation]  Accède au formulaire de recherche avancé des tiers. Dans
    ...  le formulaire saisie les valeurs fourni et clique sur recherche.
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  tiers_consulte
    # Ouvre la recherche avancée
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#tiers_consulte
    # Saisie les valeurs
    Saisir les parametres de recherche avancee du tiers consulte  ${values}
    # Valide la recherche
    Click On Search Button

Saisir les parametres de recherche avancee du tiers consulte
    [Documentation]  Entre les valeurs fournies dans le formulaire de saisie de la recherche.
    [Arguments]  ${values}

    Si "tiers_consulte" existe dans "${values}" on execute "Input Text"" dans le formulaire
    Si "categorie_tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "abrege" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "complement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ville" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "liste_diffusion" existe dans "${values}" on execute "Input Text" dans le formulaire

    # Vérifie que le champs existe avant de saisir sa valeur
    Wait Until Page Contains Element  css=#accepte_notification_email
    Si "accepte_notification_email" existe dans "${values}" on execute "Select From List By Label" dans le formulaire

    Si "uid_platau_acteur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire

Ajouter le tiers consulte depuis le listing
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le tiers consulte  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${tiers_consulte} =  Get Text  css=div.form-content span#tiers_consulte
    # On le retourne
    [Return]  ${tiers_consulte}

Modifier le tiers consulte
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte tiers_consulte  ${tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  tiers_consulte  modifier
    # On saisit des valeurs
    Saisir le tiers consulte  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer le tiers consulte
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte tiers_consulte  ${tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir le tiers consulte
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

Depuis le contexte de la categorie de tiers consulte
    [Documentation]  Accède au formulaire
    [Arguments]  ${categorie_tiers_consulte}

    # On accède au tableau
    Depuis le listing  categorie_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  Tous  ${categorie_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${categorie_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter la categorie de tiers consulte
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  categorie_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir la categorie de tiers consulte  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${categorie_tiers_consulte} =  Get Text  css=div.form-content span#categorie_tiers_consulte
    # On le retourne
    [Return]  ${categorie_tiers_consulte}

Modifier la categorie de tiers consulte
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${categorie_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte de la categorie de tiers consulte  ${categorie_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  categorie_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir la categorie de tiers consulte  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer la categorie de tiers consulte
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${categorie_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte de la categorie de tiers consulte  ${categorie_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  categorie_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir la categorie de tiers consulte
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select Multiple By Label" dans le formulaire

Depuis le contexte lien utilisateur / tiers consulté
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_om_utilisateur_tiers_consulte}

    # On accède au tableau
    Depuis le listing  lien_om_utilisateur_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  lien utilisateur / tiers consulté  ${lien_om_utilisateur_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${lien_om_utilisateur_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter lien utilisateur / tiers consulté
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  lien_om_utilisateur_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien utilisateur / tiers consulté  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_om_utilisateur_tiers_consulte} =  Get Text  css=div.form-content span#lien_om_utilisateur_tiers_consulte
    # On le retourne
    [Return]  ${lien_om_utilisateur_tiers_consulte}

Modifier lien utilisateur / tiers consulté
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_om_utilisateur_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien utilisateur / tiers consulté  ${lien_om_utilisateur_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_om_utilisateur_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir lien utilisateur / tiers consulté  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien utilisateur / tiers consulté
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_om_utilisateur_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte lien utilisateur / tiers consulté  ${lien_om_utilisateur_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_om_utilisateur_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien utilisateur / tiers consulté
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "om_utilisateur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "tiers_consulte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire

Depuis le contexte du type d'habilitation de tiers consulté
    [Documentation]  Accède au formulaire
    [Arguments]  ${type_habilitation_tiers_consulte}

    # On accède au tableau
    Depuis le listing  type_habilitation_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  type d'habilitation de tiers consulté  ${type_habilitation_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${type_habilitation_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter un type d'habilitation de tiers consulté
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  type_habilitation_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir un type d'habilitation de tiers consulté  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${type_habilitation_tiers_consulte} =  Get Text  css=div.form-content span#type_habilitation_tiers_consulte
    # On le retourne
    [Return]  ${type_habilitation_tiers_consulte}

Modifier un type d'habilitation de tiers consulté
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${type_habilitation_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte type d'habilitation de tiers consulté  ${type_habilitation_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  type_habilitation_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir un type d'habilitation de tiers consulté  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer un type d'habilitation de tiers consulté
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${type_habilitation_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte type d'habilitation de tiers consulté  ${type_habilitation_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  type_habilitation_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir un type d'habilitation de tiers consulté
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Text" dans le formulaire

Depuis le contexte de la spécialité de tiers consulté
    [Documentation]  Accède au formulaire
    [Arguments]  ${specialite_tiers_consulte}

    # On accède au tableau
    Depuis le listing  specialite_tiers_consulte
    # On recherche l'enregistrement
    Use Simple Search  spécialité de tiers consulté  ${specialite_tiers_consulte}
    # On clique sur le résultat
    Click On Link  ${specialite_tiers_consulte}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter la spécialité de tiers consulté
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  specialite_tiers_consulte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir la spécialité de tiers consulté  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${specialite_tiers_consulte} =  Get Text  css=div.form-content span#specialite_tiers_consulte
    # On le retourne
    [Return]  ${specialite_tiers_consulte}

Modifier la spécialité de tiers consulté
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${specialite_tiers_consulte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte de la spécialité de tiers consulté  ${specialite_tiers_consulte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  specialite_tiers_consulte  modifier
    # On saisit des valeurs
    Saisir la spécialité de tiers consulté  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer la spécialité de tiers consulté
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${specialite_tiers_consulte}

    # On accède à l'enregistrement
    Depuis le contexte de la spécialité de tiers consulté  ${specialite_tiers_consulte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  specialite_tiers_consulte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir la spécialité de tiers consulté
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire