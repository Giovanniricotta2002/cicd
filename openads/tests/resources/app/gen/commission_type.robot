*** Settings ***
Documentation    CRUD de la table commission_type
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte type de commission
    [Documentation]  Accède au formulaire
    [Arguments]  ${commission_type}

    # On accède au tableau
    Go To Tab  commission_type
    # On recherche l'enregistrement
    Use Simple Search  type de commission  ${commission_type}
    # On clique sur le résultat
    Click On Link  ${commission_type}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter type de commission
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  commission_type
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir type de commission  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${commission_type} =  Get Text  css=div.form-content span#commission_type
    # On le retourne
    [Return]  ${commission_type}

Modifier type de commission
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${commission_type}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte type de commission  ${commission_type}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  commission_type  modifier
    # On saisit des valeurs
    Saisir type de commission  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer type de commission
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${commission_type}

    # On accède à l'enregistrement
    Depuis le contexte type de commission  ${commission_type}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  commission_type  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir type de commission
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_adresse_ligne1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_adresse_ligne2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_salle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "listes_de_diffusion" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "participants" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "corps_du_courriel" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire