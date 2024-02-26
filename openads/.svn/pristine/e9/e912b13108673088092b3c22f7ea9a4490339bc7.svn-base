*** Settings ***
Documentation    CRUD de la table lien_dit_nature_travaux
...    @author  generated
...    @package openADS
...    @version 28/03/2023 16:03

*** Keywords ***

Depuis le contexte lien_dit_nature_travaux
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_dit_nature_travaux}

    # On accède au tableau
    Go To Tab  lien_dit_nature_travaux
    # On recherche l'enregistrement
    Use Simple Search  lien_dit_nature_travaux  ${lien_dit_nature_travaux}
    # On clique sur le résultat
    Click On Link  ${lien_dit_nature_travaux}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter lien_dit_nature_travaux
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_dit_nature_travaux
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir lien_dit_nature_travaux  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_dit_nature_travaux} =  Get Text  css=div.form-content span#lien_dit_nature_travaux
    # On le retourne
    [Return]  ${lien_dit_nature_travaux}

Modifier lien_dit_nature_travaux
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_dit_nature_travaux}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte lien_dit_nature_travaux  ${lien_dit_nature_travaux}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_dit_nature_travaux  modifier
    # On saisit des valeurs
    Saisir lien_dit_nature_travaux  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer lien_dit_nature_travaux
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_dit_nature_travaux}

    # On accède à l'enregistrement
    Depuis le contexte lien_dit_nature_travaux  ${lien_dit_nature_travaux}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_dit_nature_travaux  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir lien_dit_nature_travaux
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "dossier_instruction_type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "nature_travaux" existe dans "${values}" on execute "Select From List By Label" dans le formulaire