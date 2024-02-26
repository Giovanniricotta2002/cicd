*** Settings ***
Documentation     Actions spécifiques aux utilisateurs.

*** Keywords ***
Depuis l'onglet groupe de l'utilisateur
    [Arguments]  ${login}

    Depuis le contexte de l'utilisateur  ${login}
    On clique sur l'onglet  lien_om_utilisateur_groupe  Groupe


Ajouter le groupe depuis l'onglet groupe de l'utilisateur
    [Tags]
    [Documentation]  Permet d'ajouter un utilisateur en accédant directement au formulaire
    [Arguments]  ${groupe_libelle}  ${confidentiel}=null  ${enregistrement_demande}=null

    Wait Until Element Is Visible  action-soustab-lien_om_utilisateur_groupe-corner-ajouter
    Click Element  action-soustab-lien_om_utilisateur_groupe-corner-ajouter
    # On remplit le formulaire
    Saisir le groupe  ${groupe_libelle}  ${confidentiel}  ${enregistrement_demande}
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform


Saisir le groupe
    [Tags]
    [Documentation]  Permet de remplir le formulaire d'un utilisateur.
    [Arguments]  ${groupe_libelle}  ${confidentiel}=null  ${enregistrement_demande}=null

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=select#groupe
    # On sélectionne le groupe
    Run Keyword If  "${groupe_libelle}" != "null"  Select From List By Label  groupe  ${groupe_libelle}
    # On coche actif si spécifié
    Run Keyword If  "${confidentiel}" == "true"  Select Checkbox  confidentiel
    # On décoche confidentiel si spécifié
    Run Keyword If  "${confidentiel}" == "false"  Unselect Checkbox  confidentiel
    # On coche enregistrement_demande si spécifié
    Run Keyword If  "${enregistrement_demande}" == "true"  Select Checkbox  enregistrement_demande
    # On décoche enregistrement_demande si spécifié
    Run Keyword If  "${enregistrement_demande}" == "false"  Unselect Checkbox  enregistrement_demande


Modifier l'utilisateur depuis le menu
    [Arguments]  ${om_utilisateur}  ${values}

    Depuis le contexte de l'utilisateur  ${om_utilisateur}
    Click On Form Portlet Action  om_utilisateur  modifier
    Saisir l'utilisateur depuis le formulaire  ${values}
    Click On Submit Button


Saisir l'utilisateur depuis le formulaire
    [Arguments]  ${values}

    Si "nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "email" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "login" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pwd" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "om_profil" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
