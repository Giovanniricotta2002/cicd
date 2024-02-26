*** Settings ***
Documentation    CRUD de la table lien_donnees_techniques_moyen_retenu_juge
...    @author  generated
...    @package openADS
...    @version 27/09/2019 10:09

*** Keywords ***

Depuis le contexte Lien données techniques / moyen retenu par le juge
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_donnees_techniques_moyen_retenu_juge}

    # On accède au tableau
    Go To Tab  lien_donnees_techniques_moyen_retenu_juge
    # On recherche l'enregistrement
    Use Simple Search  Lien données techniques / moyen retenu par le juge  ${lien_donnees_techniques_moyen_retenu_juge}
    # On clique sur le résultat
    Click On Link  ${lien_donnees_techniques_moyen_retenu_juge}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter Lien données techniques / moyen retenu par le juge
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_donnees_techniques_moyen_retenu_juge
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir Lien données techniques / moyen retenu par le juge  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_donnees_techniques_moyen_retenu_juge} =  Get Text  css=div.form-content span#lien_donnees_techniques_moyen_retenu_juge
    # On le retourne
    [Return]  ${lien_donnees_techniques_moyen_retenu_juge}

Modifier Lien données techniques / moyen retenu par le juge
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_donnees_techniques_moyen_retenu_juge}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte Lien données techniques / moyen retenu par le juge  ${lien_donnees_techniques_moyen_retenu_juge}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_donnees_techniques_moyen_retenu_juge  modifier
    # On saisit des valeurs
    Saisir Lien données techniques / moyen retenu par le juge  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer Lien données techniques / moyen retenu par le juge
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_donnees_techniques_moyen_retenu_juge}

    # On accède à l'enregistrement
    Depuis le contexte Lien données techniques / moyen retenu par le juge  ${lien_donnees_techniques_moyen_retenu_juge}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_donnees_techniques_moyen_retenu_juge  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir Lien données techniques / moyen retenu par le juge
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "donnees_techniques" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "moyen_retenu_juge" existe dans "${values}" on execute "Select From List By Label" dans le formulaire