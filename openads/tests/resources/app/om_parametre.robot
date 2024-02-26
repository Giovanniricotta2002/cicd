*** Settings ***
Documentation  Actions spécifiques aux paramètres.

*** Keywords ***
Ajouter le paramètre depuis le menu (surcharge)
    [Tags]  om_parametre
    [Arguments]  ${args}
    [Documentation]  XXX
    &{generic_args} =  Create Dictionary
    ...  obj=om_parametre
    ...  msg=Vos modifications ont bien été enregistrées.
    @{libelle} =  Create List  libelle  ${args.libelle}  Input Text
    @{valeur} =  Create List  valeur  ${args.valeur}  Input Text
    @{om_collectivite} =  Create List  om_collectivite  ${args.om_collectivite}  Select From List By Label
    @{values} =  Create List
    ...  ${libelle}
    ...  ${valeur}
    ...  ${om_collectivite}
    Ajouter l'enregistrement depuis le menu  ${generic_args}  ${values}


Ajouter ou modifier le paramètre depuis le menu
    [Tags]  om_parametre
    [Arguments]  ${args}
    [Documentation]  XXX
    @{libelle} =  Create List  libelle  ${args.libelle}  Input Text
    @{valeur} =  Create List  valeur  ${args.valeur}  Input Text
    @{om_collectivite} =  Create List  om_collectivite  ${args.om_collectivite}  Select From List By Label
    @{values} =  Create List
    ...  ${libelle}
    ...  ${valeur}
    ...  ${om_collectivite}
    ${search_value} =  Get From List  ${libelle}  1
    ${click_value} =  Get From List  ${om_collectivite}  1
    &{generic_args} =  Create Dictionary
    ...  obj=om_parametre
    ...  msg=Vos modifications ont bien été enregistrées.
    ...  selection_col=libellé
    ...  search_value=${search_value}
    ...  click_value=${click_value}
    ${update} =  Run Keyword And Return Status  Modifier l'enregistrement depuis le menu  ${generic_args}  ${values}
    Run Keyword If  ${update}==${FALSE}  Ajouter l'enregistrement depuis le menu  ${generic_args}  ${values}


Supprimer le paramètre (surcharge)
    [Tags]  om_parametre
    [Arguments]  ${args}
    [Documentation]  XXX
    &{generic_args} =  Create Dictionary
    ...  obj=om_parametre
    ...  selection_col=${args.selection_col}
    ...  search_value=${args.search_value}
    ...  click_value=${args.click_value}
    ...  msg=La suppression a été correctement effectuée.
    Supprimer l'enregistrement depuis le menu  ${generic_args}
