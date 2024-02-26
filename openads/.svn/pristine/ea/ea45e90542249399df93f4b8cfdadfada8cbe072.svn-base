*** Settings ***
Documentation    CRUD de la table lien_id_interne_uid_externe
...    @author  generated
...    @package openADS
...    @version 28/05/2020 12:05

*** Keywords ***

Depuis le contexte lien_id_interne_uid_externe
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_id_interne_uid_externe}

    # On accède au tableau
    Go To Tab  lien_id_interne_uid_externe
    # On recherche l'enregistrement
    Use Simple Search  lien_id_interne_uid_externe  ${lien_id_interne_uid_externe}
    # On clique sur le résultat
    Click On Link  ${lien_id_interne_uid_externe}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien_id_interne_uid_externe
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_id_interne_uid_externe
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien_id_interne_uid_externe  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_id_interne_uid_externe} =  Get Text  css=div.form-content span#lien_id_interne_uid_externe
    # On le retourne
    [Return]  ${lien_id_interne_uid_externe}

Modifier lien_id_interne_uid_externe
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_id_interne_uid_externe}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien_id_interne_uid_externe  ${lien_id_interne_uid_externe}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_id_interne_uid_externe  modifier
    # On saisit des valeurs
    Saisir lien_id_interne_uid_externe  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien_id_interne_uid_externe
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_id_interne_uid_externe}

    # On accède à l'enregistrement
    Depuis le contexte lien_id_interne_uid_externe  ${lien_id_interne_uid_externe}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_id_interne_uid_externe  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien_id_interne_uid_externe
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "object" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "object_id" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "external_uid" existe dans "${values}" on execute "Input Text" dans le formulaire