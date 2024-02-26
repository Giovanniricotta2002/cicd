*** Settings ***
Documentation   Test le fonctionnement des écrans du menu Paramétrage Dossiers > Dossiers > Type DI
# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown


*** Test Cases ***
Affichage dynamique des champs sur le formulaire d'ajout d'un type de DI
    [Documentation]  Depuis le menu Paramétrage Dossiers > Dossiers > Type DI, je clique sur l'action d'ajout.
    ...  A l'ouverture du formulaire, je constate que le champs "type de dossier d'autorisation détaillé"
    ...  est visible alors que le champs "sous-dossier pour les DI" n'est pas affiché.
    ...
    ...  En cochant le champs "sous-dossier", le champs "type de dossier d'autorisation détaillé" est masqué et
    ...  "sous-dossier pour les DI" s'affiche.
    ...
    ...  Je décoche la case suffixe. En cliquant sur le bouton valider, le
    ...  formulaire se recharge et "sous-dossier pour les DI" reste visible alors que "type de dossier
    ...  d'autorisation détaillé" reste masqué.
    ...
    ...  En décochant la case "sous-dossier" le champs "type de dossier d'autorisation détaillé" s'affiche et
    ...  "sous-dossier pour les DI" est masqué.

    Depuis la page d'accueil  admin  admin

    Depuis le formulaire d'ajout d'un type de dossier d'instruction
    Wait Until Element Is Visible  css=#dossier_autorisation_type_detaille
    Wait Until Element Is Not Visible  css=#lien_sous_dossier_type_di

    Select Checkbox  css=#sous_dossier
    Wait Until Element Is Visible  css=#lien_sous_dossier_type_di
    Wait Until Element Is Not Visible  css=#dossier_autorisation_type_detaille

    Unselect Checkbox  css=#suffixe
    Click On Submit Button
    La page ne doit pas contenir d'erreur
    Wait Until Element Is Visible  css=#lien_sous_dossier_type_di
    Wait Until Element Is Not Visible  css=#dossier_autorisation_type_detaille

    Unselect Checkbox  css=#sous_dossier
    Wait Until Element Is Visible  css=#dossier_autorisation_type_detaille
    Wait Until Element Is Not Visible  css=#lien_sous_dossier_type_di


Affichage dynamique des champs sur le formulaire de modification d'un type de DI
    [Documentation]  Depuis le menu Paramétrage Dossiers > Dossiers > Type DI, j'accède à un type de DI,
    ...  correspondant à un sous-dossier en modification.
    ...  A l'ouverture du formulaire, je constate que les champs "sous-dossier" et "sous-dossier pour les DI"
    ...  sont visible alors que le champs "type de dossier d'autorisation détaillé" n'est pas affiché.
    ...
    ...  En décochant la case "sous-dossier" le champs "type de dossier d'autorisation détaillé" s'affiche et
    ...  "sous-dossier pour les DI" est masqué
    ...
    ...  En cochant le champs "sous-dossier" le champs "type de dossier d'autorisation détaillé" est masqué et
    ...  "sous-dossier pour les DI" s'affiche.
    ...
    ...  Je décoche la case suffixe. En cliquant sur le bouton valider, le formulaire se recharge et
    ...  "sous-dossier pour les DI" reste visible alors que "type de dossier d'autorisation détaillé" reste masqué.
    ...
    ...  J'accède à un type de DI n'étant pas un sous-dossier.
    ...  A l'ouverture du formulaire, je constate que les champs "sous-dossier" et "type de dossier d'autorisation détaillé"
    ...  sont visible alors que le champs "sous-dossier pour les DI" n'est pas affiché.

    Depuis la page d'accueil  admin  admin
    &{args_type_DI} =  Create Dictionary
    ...  code=022_PARAM
    ...  libelle=022_parametrage_modif
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  suffixe=true
    Ajouter type de dossier d'instruction  ${args_type_DI}
    Set Suite Variable  ${type_DI_libelle}  ${args_type_DI.libelle}
    Set Suite Variable  ${type_DI_code}  ${args_type_DI.code}
    @{di_compatibles} =    Create List
    ...    CU - P - Certificat d'urbanisme - Initial
    &{args_type_DI_SD} =  Create Dictionary
    ...  code=022_PARAM_SD
    ...  sous_dossier=true
    ...  libelle=022_parametrage_SD_modif
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    ...  suffixe=true
    Ajouter type de dossier d'instruction  ${args_type_DI_SD}
    Set Suite Variable  ${type_DI_SD_libelle}  ${args_type_DI_SD.libelle}
    Set Suite Variable  ${type_DI_SD_code}  ${args_type_DI_SD.code}


    Depuis le formulaire de modification d'un type de dossier d'instruction  ${type_DI_SD_libelle}  ${type_DI_SD_code}
    Wait Until Element Is Visible  css=#lien_sous_dossier_type_di
    Wait Until Element Is Not Visible  css=#dossier_autorisation_type_detaille

    Unselect Checkbox  css=#sous_dossier
    Wait Until Element Is Visible  css=#dossier_autorisation_type_detaille
    Wait Until Element Is Not Visible  css=#lien_sous_dossier_type_di

    Select Checkbox  css=#sous_dossier
    Wait Until Element Is Visible  css=#lien_sous_dossier_type_di
    Wait Until Element Is Not Visible  css=#dossier_autorisation_type_detaille

    Unselect Checkbox  css=#suffixe
    Click On Submit Button
    La page ne doit pas contenir d'erreur
    Wait Until Element Is Visible  css=#lien_sous_dossier_type_di
    Wait Until Element Is Not Visible  css=#dossier_autorisation_type_detaille

    Depuis le formulaire de modification d'un type de dossier d'instruction  ${type_DI_libelle}  ${type_DI_code}
    Wait Until Element Is Visible  css=#dossier_autorisation_type_detaille
    Wait Until Element Is Not Visible  css=#lien_sous_dossier_type_di


Affichage des champs sur le formulaire de consultation d'un type de DI
    [Documentation]  Depuis le menu Paramétrage Dossiers > Dossiers > Type DI, j'accède à un type de DI,
    ...  correspondant à un sous-dossier.
    ...  A l'ouverture du formulaire, je constate que les champs "sous-dossier" et "sous-dossier pour les DI"
    ...  sont visible alors que le champs "type de dossier d'autorisation détaillé" n'est pas affiché.
    ...
    ...  J'accède à un type de DI n'étant pas un sous-dossier.
    ...  A l'ouverture du formulaire, je constate que les champs "sous-dossier" et "type de dossier d'autorisation détaillé"
    ...  sont visible alors que le champs "sous-dossier pour les DI" n'est pas affiché.

    Depuis la page d'accueil  admin  admin

    Depuis le contexte type de dossier d'instruction  ${type_DI_SD_libelle}  ${type_DI_SD_code}
    Wait Until Element Is Visible  css=#lib-lien_sous_dossier_type_di
    Wait Until Element Is Not Visible  css=#dossier_autorisation_type_detaille

    Depuis le contexte type de dossier d'instruction  ${type_DI_libelle}  ${type_DI_code}
    Wait Until Element Is Visible  css=#dossier_autorisation_type_detaille
    Wait Until Element Is Not Visible  css=#lib-lien_sous_dossier_type_di


Affichage des champs sur le formulaire de suppression d'un type de DI
    [Documentation]  Depuis le menu Paramétrage Dossiers > Dossiers > Type DI, j'accède à un type de DI,
    ...  correspondant à un sous-dossier en suppression.
    ...  A l'ouverture du formulaire, je constate que les champs "sous-dossier" et "sous-dossier pour les DI"
    ...  sont visible alors que le champs "type de dossier d'autorisation détaillé" n'est pas affiché.
    ...
    ...  J'accède à un type de DI n'étant pas un sous-dossier.
    ...  A l'ouverture du formulaire, je constate que les champs "sous-dossier" et "type de dossier d'autorisation détaillé"
    ...  sont visible alors que le champs "sous-dossier pour les DI" n'est pas affiché.

    Depuis la page d'accueil  admin  admin

    Depuis le formulaire de suppression d'un type de dossier d'instruction  ${type_DI_SD_libelle}  ${type_DI_SD_code}
    Wait Until Element Is Visible  css=#lib-lien_sous_dossier_type_di
    Wait Until Element Is Not Visible  css=#dossier_autorisation_type_detaille
    # Suppression du type de DI pour ne pas impacter les autres tests
    Click On Submit Button

    Depuis le formulaire de suppression d'un type de dossier d'instruction  ${type_DI_libelle}  ${type_DI_code}
    Wait Until Element Is Visible  css=#dossier_autorisation_type_detaille
    Wait Until Element Is Not Visible  css=#lib-lien_sous_dossier_type_di
    # Suppression du type de DI pour ne pas impacter les autres tests
    Click On Submit Button