*** Settings ***
Documentation     Actions spécifiques aux droits.

*** Keywords ***
Depuis le listing des droits du profil
    [Documentation]  Permet d'accéder au listing des droits depuis le formulaire
    ...  d'un profil.
    [Arguments]  ${om_profil}

    Depuis le contexte du profil  null  ${om_profil}
    Click On Tab  om_droit  Droit


Depuis le droit dans le contexte du profil
    [Documentation]
    [Arguments]  ${om_droit}  ${om_profil}

    Depuis le listing des droits du profil  ${om_profil}
    Wait Until Element Is Visible  id=recherchedyn
    Input Text  id=recherchedyn  ${om_droit}
    Wait Until Element Contains  id=sousform-om_droit  ${om_droit}
    Click On Link  ${om_droit}


Supprimer le droit depuis le contexte du profil
    [Documentation]  Permet de supprimer un droit affecté à un profil.
    [Arguments]  ${om_droit}  ${om_profil}

    Depuis le droit dans le contexte du profil  ${om_droit}  ${om_profil}
    Click On SubForm Portlet Action  om_droit  supprimer
    Click On Submit Button In Subform

Ajouter le droit depuis le menu si il n'existe pas
    [Tags]  om_droit
    [Arguments]  ${libelle}  ${om_profil}
    [Documentation]  Ajoute un droit en utilisant le libellé du droit à ajouter et
    ...  le profil du droit. Si l'ajout fonctionne le keywords réussi. Si l'ajout
    ...  du droit vérifie, à l'aide du message d'erreur, si c'est parce que le droit
    ...  existe déjà. Si c'est le cas le keyword réussi sinon il fail

    ${ajout} =  Run Keyword And Return Status  Ajouter le droit depuis le menu  ${libelle}  ${om_profil}
    Run Keyword If  ${ajout}==${FALSE}  Error Message Should Contain  Les valeurs saisies dans les champs libellé, Profil existent déjà, veuillez saisir de nouvelles valeurs
