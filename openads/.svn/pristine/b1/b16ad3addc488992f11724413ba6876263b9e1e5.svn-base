*** Settings ***
Documentation    CRUD de la table sig_attribut
...    @author  generated
...    @package openADS
...    @version 14/06/2021 10:06

*** Keywords ***

Depuis le contexte attributs de références
    [Documentation]  Accède au formulaire
    [Arguments]  ${sig_attribut}

    # On accède au tableau
    Go To Tab  sig_attribut
    # On recherche l'enregistrement
    Use Simple Search  attributs de références  ${sig_attribut}
    # On clique sur le résultat
    Click On Link  ${sig_attribut}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter attributs de références
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  sig_attribut
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir attributs de références  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${sig_attribut} =  Get Text  css=div.form-content span#sig_attribut
    # On le retourne
    [Return]  ${sig_attribut}

Modifier attributs de références
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${sig_attribut}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte attributs de références  ${sig_attribut}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  sig_attribut  modifier
    # On saisit des valeurs
    Saisir attributs de références  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer attributs de références
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${sig_attribut}

    # On accède à l'enregistrement
    Depuis le contexte attributs de références  ${sig_attribut}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  sig_attribut  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir attributs de références
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "sig_couche" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "identifiant" existe dans "${values}" on execute "Input Text" dans le formulaire