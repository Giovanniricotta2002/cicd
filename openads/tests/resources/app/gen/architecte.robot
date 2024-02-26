*** Settings ***
Documentation    CRUD de la table architecte
...    @author  generated
...    @package openADS
...    @version 23/08/2023 12:08

*** Keywords ***

Depuis le contexte architecte
    [Documentation]  Accède au formulaire
    [Arguments]  ${architecte}

    # On accède au tableau
    Go To Tab  architecte
    # On recherche l'enregistrement
    Use Simple Search  architecte  ${architecte}
    # On clique sur le résultat
    Click On Link  ${architecte}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter architecte
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  architecte
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir architecte  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${architecte} =  Get Text  css=div.form-content span#architecte
    # On le retourne
    [Return]  ${architecte}

Modifier architecte
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${architecte}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte architecte  ${architecte}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  architecte  modifier
    # On saisit des valeurs
    Saisir architecte  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer architecte
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${architecte}

    # On accède à l'enregistrement
    Depuis le contexte architecte  ${architecte}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  architecte  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir architecte
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "prenom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse1" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "adresse2" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "ville" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pays" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "inscription" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "telephone" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "fax" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "email" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "note" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "frequent" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "nom_cabinet" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "conseil_regional" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_dit" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "boite_postale" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cedex" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "titre_obt_diplo_spec" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_obt_diplo_spec" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "lieu_obt_diplo_spec" existe dans "${values}" on execute "Input Text" dans le formulaire