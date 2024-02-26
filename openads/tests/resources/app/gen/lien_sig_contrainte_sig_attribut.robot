*** Settings ***
Documentation    CRUD de la table lien_sig_contrainte_sig_attribut
...    @author  generated
...    @package openADS
...    @version 07/07/2021 12:07

*** Keywords ***

Depuis le contexte critères d'application
    [Documentation]  Accède au formulaire
    [Arguments]  ${lien_sig_contrainte_sig_attribut}

    # On accède au tableau
    Go To Tab  lien_sig_contrainte_sig_attribut
    # On recherche l'enregistrement
    Use Simple Search  critères d'application  ${lien_sig_contrainte_sig_attribut}
    # On clique sur le résultat
    Click On Link  ${lien_sig_contrainte_sig_attribut}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter critères d'application
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  lien_sig_contrainte_sig_attribut
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir critères d'application  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${lien_sig_contrainte_sig_attribut} =  Get Text  css=div.form-content span#lien_sig_contrainte_sig_attribut
    # On le retourne
    [Return]  ${lien_sig_contrainte_sig_attribut}

Modifier critères d'application
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${lien_sig_contrainte_sig_attribut}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte critères d'application  ${lien_sig_contrainte_sig_attribut}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  lien_sig_contrainte_sig_attribut  modifier
    # On saisit des valeurs
    Saisir critères d'application  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer critères d'application
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${lien_sig_contrainte_sig_attribut}

    # On accède à l'enregistrement
    Depuis le contexte critères d'application  ${lien_sig_contrainte_sig_attribut}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  lien_sig_contrainte_sig_attribut  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir critères d'application
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "sig_contrainte" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "sig_attribut" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "valeur" existe dans "${values}" on execute "Input Text" dans le formulaire