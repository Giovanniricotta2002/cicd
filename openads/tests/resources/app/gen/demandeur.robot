*** Settings ***
Documentation    CRUD de la table demandeur
...    @author  generated
...    @package openADS
...    @version 23/08/2023 12:08

*** Keywords ***

Depuis le contexte demandeur
    [Documentation]  Accède au formulaire
    [Arguments]  ${demandeur}

    # On accède au tableau
    Go To Tab  demandeur
    # On recherche l'enregistrement
    Use Simple Search  demandeur  ${demandeur}
    # On clique sur le résultat
    Click On Link  ${demandeur}
    # On vérifie qu'il n'y a pas d'erreur
    Page Should Not Contain Errors

Ajouter demandeur
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Go To Tab  demandeur
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir demandeur  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${demandeur} =  Get Text  css=div.form-content span#demandeur
    # On le retourne
    [Return]  ${demandeur}

Modifier demandeur
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${demandeur}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte demandeur  ${demandeur}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  demandeur  modifier
    # On saisit des valeurs
    Saisir demandeur  ${values}
    # On valide le formulaire
    Click On Submit Button

Supprimer demandeur
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${demandeur}

    # On accède à l'enregistrement
    Depuis le contexte demandeur  ${demandeur}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  demandeur  supprimer
    # On valide le formulaire
    Click On Submit Button

Saisir demandeur
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}
    
    Si "type_demandeur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "qualite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "particulier_nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "particulier_prenom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "particulier_date_naissance" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "particulier_commune_naissance" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "particulier_departement_naissance" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_denomination" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_raison_sociale" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_siret" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_categorie_juridique" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_prenom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numero" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "voie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "complement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_dit" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "localite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code_postal" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "bp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cedex" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pays" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "division_territoriale" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "telephone_fixe" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "telephone_mobile" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "indicatif" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "courriel" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "notification" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "frequent" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "particulier_civilite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "personne_morale_civilite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "fax" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "particulier_pays_naissance" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "num_inscription" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "nom_cabinet" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "conseil_regional" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "titre_obt_diplo_spec" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "date_obt_diplo_spec" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "lieu_obt_diplo_spec" existe dans "${values}" on execute "Input Text" dans le formulaire