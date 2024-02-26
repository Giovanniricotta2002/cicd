*** Settings ***
Documentation    Test le fonctionnement des écrans du menu Paramétrage Dossiers > Workflows > Événement
# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown


*** Test Cases ***
Affichage dynamique des champs sur le formulaire d'ajout d'un événement
    [Documentation]  Avec un profil administrateur, depuis le menu Administration > Paramétrage, j'ajoute un
    ...  nouvel élement. Dans le formulaire d'ajout je lui donne le libellé "option_module_acteur", la valeur
    ...  "true", la collectivité "agglo" et je valide le formulaire.
    ...
    ...  Depuis le menu Paramétrage Dossiers > Workflows > Événement, je clique sur l'action d'ajout.
    ...  A l'ouverture du formulaire, le champs "type(s) d'habilitation des tiers à notifier" n'est pas visible.
    ...
    ...  Lorsque je sélectionne la valeur "notification automatique" dans le champs "Notification des tiers", le
    ...  champs "type(s) d'habilitation des tiers à notifier" s'affiche.
    ...
    ...  En cliquant sur le bouton valider, sans remplir le libellé de l'événement, le formulaire se recharge
    ...  et "type(s) d'habilitation des tiers à notifier" reste visible.
    ...
    ...  Lorsque je sélectionne une autre valeur dans le champs "Notification des tiers", le champs
    ...  "type(s) d'habilitation des tiers à notifier" est masqué.

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_module_acteur
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    Depuis le formulaire d'ajout de l'événement
    Wait Until Page Contains Element  css=#notification_tiers
    Wait Until Element Is Not Visible  css=#type_habilitation_tiers_consulte

    Select From List By Label  css=#notification_tiers  Notification automatique
    Wait Until Element Is Visible  css=#type_habilitation_tiers_consulte

    Click On Submit Button
    La page ne doit pas contenir d'erreur
    Wait Until Element Is Visible  css=#type_habilitation_tiers_consulte

    Select From List By Label  css=#notification_tiers  Notification manuelle
    Wait Until Element Is Not Visible  css=#type_habilitation_tiers_consulte


Affichage dynamique des champs sur le formulaire de modification d'un événement
    [Documentation]  Depuis le menu Paramétrage Dossiers > Workflows > Événement, j'accède à un événement,
    ...  pour lequel "Notification des tiers " a pour valeur "Notification automatique".
    ...  A l'ouverture du formulaire je constate que le champs "type(s) d'habilitation des tiers à notifier"
    ...  est visible.
    ...
    ...  Lorsque je sélectionne une autre valeur dans le champs "Notification des tiers", le champs
    ...  "type(s) d'habilitation des tiers à notifier" est masqué.
    ...
    ...  Lorsque je sélectionne la valeur "notification automatique" dans le champs "Notification des tiers",
    ...  le champs "type(s) d'habilitation des tiers à notifier" s'affiche.
    ...
    ...  En cliquant sur le bouton valider, sans remplir le libellé de l'événement, le formulaire se recharge
    ...  et "type(s) d'habilitation des tiers à notifier" reste visible.
    ...
    ...  J'accède à un événement pour lequel "Notification des tiers " n'a pas pour valeur "Notification automatique".
    ...  A l'ouverture du formulaire le champs "type(s) d'habilitation des tiers à notifier" n'est pas visible.

    Depuis la page d'accueil  admin  admin
    &{args_evenement} =  Create Dictionary
    ...  libelle=023 PARAM MODIF - NA
    ...  notification_tiers=Notification automatique
    Ajouter l'événement depuis le menu  ${args_evenement}
    Set Suite Variable  ${evenement_NA_libelle}  ${args_evenement.libelle}
    &{args_evenement} =  Create Dictionary
    ...  libelle=023 PARAM MODIF - NM
    ...  notification_tiers=Notification manuelle
    Ajouter l'événement depuis le menu  ${args_evenement}
    Set Suite Variable  ${evenement_NM_libelle}  ${args_evenement.libelle}

    Depuis le formulaire de modification de l'événement  ${evenement_NA_libelle}
    Wait Until Page Contains Element  css=#notification_tiers
    Wait Until Element Is Visible  css=#type_habilitation_tiers_consulte

    Select From List By Label  css=#notification_tiers  Notification manuelle
    Wait Until Element Is Not Visible  css=#type_habilitation_tiers_consulte

    Select From List By Label  css=#notification_tiers  Notification automatique
    Wait Until Element Is Visible  css=#type_habilitation_tiers_consulte

    Input Text  css=#libelle  ${EMPTY}
    Click On Submit Button
    La page ne doit pas contenir d'erreur
    Wait Until Element Is Visible  css=#type_habilitation_tiers_consulte

    Depuis le formulaire de modification de l'événement  ${evenement_NM_libelle}
    Wait Until Page Contains Element  css=#notification_tiers
    Wait Until Element Is Not Visible  css=#type_habilitation_tiers_consulte


Affichage des champs sur le formulaire de consultation d'un événement
    [Documentation]  Depuis le menu Paramétrage Dossiers > Workflows > Événement, j'accède à un événement
    ...  pour lequel "Notification des tiers " a pour valeur "Notification automatique".
    ...  A l'ouverture du formulaire je constate que le champs "type(s) d'habilitation des tiers à notifier"
    ...  est visible.
    ...
    ...  J'accède à un événement pour lequel "Notification des tiers " n'a pas pour valeur "Notification automatique".
    ...  A l'ouverture du formulaire le champs "type(s) d'habilitation des tiers à notifier" n'est pas visible.

    Depuis la page d'accueil  admin  admin

    Depuis le contexte de l'événement  ${evenement_NA_libelle}
    Wait Until Page Contains Element  css=#notification_tiers
    Wait Until Element Is Visible  css=#lib-type_habilitation_tiers_consulte

    Depuis le contexte de l'événement  ${evenement_NM_libelle}
    Wait Until Page Contains Element  css=#notification_tiers
    Wait Until Element Is Not Visible  css=#lib-type_habilitation_tiers_consulte


Affichage des champs sur le formulaire de suppression d'un événement
    [Documentation]  Depuis le menu Paramétrage Dossiers > Workflows > Événement, j'accède à un événement,
    ...  correspondant à un sous-dossier en suppression.
    ...  A l'ouverture du formulaire, je constate que les champs "sous-dossier" et "sous-dossier pour les DI"
    ...  sont visible alors que le champs "type de dossier d'autorisation détaillé" n'est pas affiché.
    ...
    ...  J'accède à un événement n'étant pas un sous-dossier.
    ...  A l'ouverture du formulaire, je constate que les champs "sous-dossier" et "type de dossier d'autorisation détaillé"
    ...  sont visible alors que le champs "sous-dossier pour les DI" n'est pas affiché.

    Depuis la page d'accueil  admin  admin

    Depuis le formulaire de suppression de l'événement  ${evenement_NA_libelle}
    Wait Until Page Contains Element  css=#notification_tiers
    Wait Until Element Is Visible  css=#lib-type_habilitation_tiers_consulte

    Depuis le formulaire de suppression de l'événement  ${evenement_NM_libelle}
    Wait Until Page Contains Element  css=#notification_tiers
    Wait Until Element Is Not Visible  css=#lib-type_habilitation_tiers_consulte