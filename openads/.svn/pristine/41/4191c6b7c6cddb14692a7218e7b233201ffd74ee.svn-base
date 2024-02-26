*** Settings ***
Documentation    CRUD de la table etat_dossier_autorisation
...    @author  generated
...    @package openADS
...    @version 15/09/2017 16:09

*** Keywords ***

Depuis le contexte état
    [Documentation]  Accède au formulaire
    [Arguments]  ${etat_dossier_autorisation}

    # On accède au tableau
    Go To Tab  etat_dossier_autorisation
    # On recherche l'enregistrement
    Use Simple Search  état  ${etat_dossier_autorisation}
    # On clique sur le résultat
    Click On Link  ${etat_dossier_autorisation}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter état
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  etat_dossier_autorisation
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir état  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${etat_dossier_autorisation} =  Get Text  css=div.form-content span#etat_dossier_autorisation
    # On le retourne
    [Return]  ${etat_dossier_autorisation}

Modifier état
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${etat_dossier_autorisation}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte état  ${etat_dossier_autorisation}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  etat_dossier_autorisation  modifier
    # On saisit des valeurs
    Saisir état  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer état
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${etat_dossier_autorisation}

    # On accède à l'enregistrement
    Depuis le contexte état  ${etat_dossier_autorisation}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  etat_dossier_autorisation  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir état
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire