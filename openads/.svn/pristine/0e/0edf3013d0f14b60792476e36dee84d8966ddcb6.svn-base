*** Settings ***
Documentation    CRUD de la table demande
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte demande
    [Documentation]  Accède au formulaire
    [Arguments]  ${demande}

    # On accède au tableau
    Go To Tab  demande
    # On recherche l'enregistrement
    Use Simple Search  demande  ${demande}
    # On clique sur le résultat
    Click On Link  ${demande}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter demande
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  demande
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir demande  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${demande} =  Get Text  css=div.form-content span#demande
    # On le retourne
    [Return]  ${demande}

Modifier demande
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${demande}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte demande  ${demande}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  demande  modifier
    # On saisit des valeurs
    Saisir demande  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer demande
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${demande}

    # On accède à l'enregistrement
    Depuis le contexte demande  ${demande}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  demande  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir demande
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier_autorisation_type_detaille" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "demande_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_instruction" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "dossier_autorisation" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "date_demande" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "terrain_references_cadastrales" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_voie_numero" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_voie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_lieu_dit" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_localite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_code_postal" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_bp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_cedex" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "terrain_superficie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "instruction_recepisse" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "arrondissement" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "autorisation_contestee" existe dans "${values}" on execute "Select From List By Label" dans le formulaire