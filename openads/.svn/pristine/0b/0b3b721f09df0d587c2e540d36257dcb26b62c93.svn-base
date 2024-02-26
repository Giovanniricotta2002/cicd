*** Settings ***
Documentation    CRUD de la table avis_consultation
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte avis
    [Documentation]  Accède au formulaire
    [Arguments]  ${avis_consultation}

    # On accède au tableau
    Go To Tab  avis_consultation
    # On recherche l'enregistrement
    Use Simple Search  avis  ${avis_consultation}
    # On clique sur le résultat
    Click On Link  ${avis_consultation}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter avis
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  avis_consultation
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir avis  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${avis_consultation} =  Get Text  css=div.form-content span#avis_consultation
    # On le retourne
    [Return]  ${avis_consultation}

Modifier avis
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${avis_consultation}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte avis  ${avis_consultation}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  avis_consultation  modifier
    # On saisit des valeurs
    Saisir avis  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer avis
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${avis_consultation}

    # On accède à l'enregistrement
    Depuis le contexte avis  ${avis_consultation}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  avis_consultation  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir avis
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "abrege" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire