*** Settings ***
Documentation    CRUD de la table affectation_automatique
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte affectation automatique
    [Documentation]  Accède au formulaire
    [Arguments]  ${affectation_automatique}

    # On accède au tableau
    Go To Tab  affectation_automatique
    # On recherche l'enregistrement
    Use Simple Search  affectation automatique  ${affectation_automatique}
    # On clique sur le résultat
    Click On Link  ${affectation_automatique}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter affectation automatique
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  affectation_automatique
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir affectation automatique  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${affectation_automatique} =  Get Text  css=div.form-content span#affectation_automatique
    # On le retourne
    [Return]  ${affectation_automatique}

Modifier affectation automatique
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${affectation_automatique}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte affectation automatique  ${affectation_automatique}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  affectation_automatique  modifier
    # On saisit des valeurs
    Saisir affectation automatique  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer affectation automatique
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${affectation_automatique}

    # On accède à l'enregistrement
    Depuis le contexte affectation automatique  ${affectation_automatique}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  affectation_automatique  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir affectation automatique
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "arrondissement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "quartier" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "section" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "instructeur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_autorisation_type_detaille" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "instructeur_2" existe dans "${values}" on execute "Select From List By Label" dans le formulaire