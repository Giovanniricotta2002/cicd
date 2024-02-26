*** Settings ***
Documentation    CRUD de la table lien_id_interne_uid_externe
...    @author  generated
...    @package openADS
...    @version 28/05/2020 12:05

*** Keywords ***

Ajouter le lien entre id interne et uid externe
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To  ${PROJECT_URL}${OM_ROUTE_TAB}&obj=lien_id_interne_uid_externe
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le lien entre id interne et uid externe  ${values}
    # On valide le formulaire
    Click On Submit Button

Saisir le lien entre id interne et uid externe
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "object" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "object_id" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "external_uid" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "dossier" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "category" existe dans "${values}" on execute "Input Text" dans le formulaire
