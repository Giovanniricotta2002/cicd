*** Settings ***
Documentation    CRUD de la table famille_travaux
...    @author  generated
...    @package openADS
...    @version 28/03/2023 16:03

*** Keywords ***

Depuis le contexte de la famille de travaux
    [Documentation]  Accède au formulaire
    [Arguments]  ${famille_travaux}

    # On accède au tableau
    Depuis le listing  famille_travaux
    # On recherche l'enregistrement
    Use Simple Search  famille de travaux  ${famille_travaux}
    # On clique sur le résultat
    Click On Link  ${famille_travaux}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Ajouter la famille de travaux
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  famille_travaux
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir la famille de travaux  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${famille_travaux} =  Get Text  css=div.form-content span#famille_travaux
    # On le retourne
    [Return]  ${famille_travaux}

Modifier la famille de travaux
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${famille_travaux}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte de la famille de travaux  ${famille_travaux}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  famille_travaux  modifier
    # On saisit des valeurs
    Saisir la famille de travaux  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer la famille de travaux
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${famille_travaux}

    # On accède à l'enregistrement
    Depuis le contexte de la famille de travaux  ${famille_travaux}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  famille_travaux  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir la famille de travaux
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "description" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_validite_debut" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_validite_fin" existe dans "${values}" on execute "Input Datepicker" dans le formulaire