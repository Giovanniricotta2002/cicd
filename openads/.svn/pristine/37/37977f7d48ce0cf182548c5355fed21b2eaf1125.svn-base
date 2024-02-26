*** Settings ***
Documentation    CRUD de la table lien_donnees_techniques_moyen_souleve
...    @author  generated
...    @package openADS
...    @version 27/09/2019 10:09

*** Keywords ***

Depuis le contexte Lien données techniques / moyen soulevé
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_donnees_techniques_moyen_souleve}

    # On accède au tableau
    Go To Tab  lien_donnees_techniques_moyen_souleve
    # On recherche l'enregistrement
    Use Simple Search  Lien données techniques / moyen soulevé  ${lien_donnees_techniques_moyen_souleve}
    # On clique sur le résultat
    Click On Link  ${lien_donnees_techniques_moyen_souleve}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Lien données techniques / moyen soulevé
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_donnees_techniques_moyen_souleve
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Lien données techniques / moyen soulevé  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_donnees_techniques_moyen_souleve} =  Get Text  css=div.form-content span#lien_donnees_techniques_moyen_souleve
    # On le retourne
    [Return]  ${lien_donnees_techniques_moyen_souleve}

Modifier Lien données techniques / moyen soulevé
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_donnees_techniques_moyen_souleve}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Lien données techniques / moyen soulevé  ${lien_donnees_techniques_moyen_souleve}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_donnees_techniques_moyen_souleve  modifier
    # On saisit des valeurs
    Saisir Lien données techniques / moyen soulevé  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Lien données techniques / moyen soulevé
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_donnees_techniques_moyen_souleve}

    # On accède à l'enregistrement
    Depuis le contexte Lien données techniques / moyen soulevé  ${lien_donnees_techniques_moyen_souleve}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_donnees_techniques_moyen_souleve  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Lien données techniques / moyen soulevé
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "donnees_techniques" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "moyen_souleve" existe dans "${values}" on execute "Select From List By Label" dans le formulaire