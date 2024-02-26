*** Settings ***
Documentation    CRUD de la table commission
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte commission
    [Documentation]  Accède au formulaire
    [Arguments]  ${commission}

    # On accède au tableau
    Go To Tab  commission
    # On recherche l'enregistrement
    Use Simple Search  commission  ${commission}
    # On clique sur le résultat
    Click On Link  ${commission}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter commission
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  commission
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir commission  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${commission} =  Get Text  css=div.form-content span#commission
    # On le retourne
    [Return]  ${commission}

Modifier commission
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${commission}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte commission  ${commission}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  commission  modifier
    # On saisit des valeurs
    Saisir commission  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer commission
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${commission}

    # On accède à l'enregistrement
    Depuis le contexte commission  ${commission}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  commission  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir commission
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "commission_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_commission" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "heure_commission" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_adresse_ligne1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_adresse_ligne2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_salle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "listes_de_diffusion" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "participants" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_fichier_commission_ordre_jour" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_final_commission_ordre_jour" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_fichier_commission_compte_rendu" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_final_commission_compte_rendu" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire