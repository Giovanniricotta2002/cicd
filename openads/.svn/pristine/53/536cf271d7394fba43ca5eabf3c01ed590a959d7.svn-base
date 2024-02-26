*** Settings ***
Documentation    CRUD de la table lien_demande_demandeur
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte lien demande/demandeur
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_demande_demandeur}

    # On accède au tableau
    Go To Tab  lien_demande_demandeur
    # On recherche l'enregistrement
    Use Simple Search  lien demande/demandeur  ${lien_demande_demandeur}
    # On clique sur le résultat
    Click On Link  ${lien_demande_demandeur}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien demande/demandeur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_demande_demandeur
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien demande/demandeur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_demande_demandeur} =  Get Text  css=div.form-content span#lien_demande_demandeur
    # On le retourne
    [Return]  ${lien_demande_demandeur}

Modifier lien demande/demandeur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_demande_demandeur}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien demande/demandeur  ${lien_demande_demandeur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_demande_demandeur  modifier
    # On saisit des valeurs
    Saisir lien demande/demandeur  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien demande/demandeur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_demande_demandeur}

    # On accède à l'enregistrement
    Depuis le contexte lien demande/demandeur  ${lien_demande_demandeur}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_demande_demandeur  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien demande/demandeur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "petitionnaire_principal" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "demande" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "demandeur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire