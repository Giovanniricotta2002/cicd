*** Settings ***
Documentation    CRUD de la table lien_lot_demandeur
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte lien lot/demandeur
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_lot_demandeur}

    # On accède au tableau
    Go To Tab  lien_lot_demandeur
    # On recherche l'enregistrement
    Use Simple Search  lien lot/demandeur  ${lien_lot_demandeur}
    # On clique sur le résultat
    Click On Link  ${lien_lot_demandeur}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien lot/demandeur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_lot_demandeur
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien lot/demandeur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_lot_demandeur} =  Get Text  css=div.form-content span#lien_lot_demandeur
    # On le retourne
    [Return]  ${lien_lot_demandeur}

Modifier lien lot/demandeur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_lot_demandeur}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien lot/demandeur  ${lien_lot_demandeur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_lot_demandeur  modifier
    # On saisit des valeurs
    Saisir lien lot/demandeur  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien lot/demandeur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_lot_demandeur}

    # On accède à l'enregistrement
    Depuis le contexte lien lot/demandeur  ${lien_lot_demandeur}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_lot_demandeur  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien lot/demandeur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "lot" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "demandeur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "petitionnaire_principal" existe dans "${values}" on execute "Set Checkbox" dans le formulaire