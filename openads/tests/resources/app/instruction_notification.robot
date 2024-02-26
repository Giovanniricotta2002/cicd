*** Settings ***
Documentation    CRUD de la table instruction_notification
...    @author  generated
...    @package openADS
...    @version 18/11/2021 16:11

*** Keywords ***

Depuis le contexte instruction_notification
    [Documentation]  Accède au formulaire
    [Arguments]  ${instruction_notification}

    # On accède au tableau
    Depuis le listing  instruction_notification
    # On recherche l'enregistrement
    Use Simple Search  instruction_notification  ${instruction_notification}
    # On clique sur le résultat
    Click On Link  ${instruction_notification}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter instruction_notification
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  instruction_notification
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir instruction_notification  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${instruction_notification} =  Get Text  css=div.form-content span#instruction_notification
    # On le retourne
    [Return]  ${instruction_notification}

Modifier instruction_notification
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${instruction_notification}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte instruction_notification  ${instruction_notification}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  instruction_notification  modifier
    # On saisit des valeurs
    Saisir instruction_notification  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer instruction_notification
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${instruction_notification}

    # On accède à l'enregistrement
    Depuis le contexte instruction_notification  ${instruction_notification}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  instruction_notification  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir instruction_notification
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "instruction" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "automatique" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "emetteur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_envoi" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "destinataire" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_premier_acces" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "statut" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "commentaire" existe dans "${values}" on execute "Input Text" dans le formulaire

Recuperer les cles dans le mail de notification
    [Documentation]  Recupere sous la forme d'une liste toutes les cles
    ...  presente dans le mail de notification à l'aide d'une regex.

    ${msg} =  Get Text  //body
    ${key_regex} =  Set Variable  [0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{4}
    ${keys} =  Get Regexp Matches  ${msg}  ${key_regex}
    [Return]  ${keys}

Verifier que le lien de notification contiens
    [Documentation]  Utilise la clé fournit pour composer le lien. Ouvre la page du lien
    ...  puis cherche le texte voulu dans cette page.
    [Arguments]  ${cle}  ${text}

    Go To  ${PROJECT_URL}/web/notification.php?key=${cle}
    Wait Until Page Contains  ${text}


