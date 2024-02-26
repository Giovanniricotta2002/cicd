*** Settings ***
Documentation    CRUD de la table autorite_competente
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte autorité compétente
    [Documentation]  Accède au formulaire
    [Arguments]  ${autorite_competente}

    # On accède au tableau
    Go To Tab  autorite_competente
    # On recherche l'enregistrement
    Use Simple Search  autorité compétente  ${autorite_competente}
    # On clique sur le résultat
    Click On Link  ${autorite_competente}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter autorité compétente
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  autorite_competente
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir autorité compétente  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${autorite_competente} =  Get Text  css=div.form-content span#autorite_competente
    # On le retourne
    [Return]  ${autorite_competente}

Modifier autorité compétente
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${autorite_competente}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte autorité compétente  ${autorite_competente}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  autorite_competente  modifier
    # On saisit des valeurs
    Saisir autorité compétente  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer autorité compétente
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${autorite_competente}

    # On accède à l'enregistrement
    Depuis le contexte autorité compétente  ${autorite_competente}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  autorite_competente  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir autorité compétente
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "autorite_competente_sitadel" existe dans "${values}" on execute "Input Text" dans le formulaire