*** Settings ***
Documentation  Gestion des lettretypes utilisées dans l'onglet instruction des dossiers.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Jeu de données
    [Documentation]  Active l'option : option_redaction_libre puis crée une lettretype, un évènement
    ...  utilisant cette lettretype et un dossier. Ajout de l'évènement d'instruction sur le dossier. 

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_redaction_libre
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    Set Suite Variable  ${id_lettretype}  050_instruction_lettretype
    &{args_lettretype} =  Create Dictionary
    ...  id=${id_lettretype}
    ...  libelle=PB_PARAM
    ...  titre=plop
    ...  corps=plop
    ...  sql=Aucune REQUÊTE
    ...  actif=true
    ...  collectivite=agglo
    Ajouter la lettre-type depuis le menu  &{args_lettretype}

    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=PB_PARAM_050_ins_lettretype
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=050_instruction_lettretype PB_PARAM
    Ajouter l'événement depuis le menu  ${args_evenement}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=050_instruction_lettretype
    ...  particulier_prenom=PB_PARAM
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Set Suite Variable  ${di}
    Set Suite Variable  ${lib_instruction}  PB_PARAM_050_ins_lettretype

    Ajouter une instruction au DI  ${di}  ${lib_instruction}
    # Vérification que si le paramètrage est ok le message d'erreur n'est pas présent
    Page Should Not Contain Element  css=.messsage.ui-state-error

Lettretype de l'évènement d'instruction non existante pour la collectivité du dossier
    [Documentation]  Modification de la lettretype du jeu de données pour la lier à une autre collectivité
    ...  que celle du dossier. Depuis l'onglet Instruction du dossier, accès à l'instruction associé
    ...  à cette lettretype.
    ...  En consultation de l'instruction un message d'erreur est affiché.

    # Activation et changement de la collectivité de la lettretype
    @{args_lettretype} =  Create List  ${id_lettretype}  null  null  null  null  true  ALLAUCH
    Modifier la lettre-type  @{args_lettretype}

    # Vérification de la présence du message d'erreur
    Depuis l'instruction du dossier d'instruction  ${di}  ${lib_instruction}
    Error Message Should Be In Subform  Erreur de paramétrage, le modèle de document n'a pas pu être récupéré. Contactez votre administrateur.


Document n'ayant aucun contenu en mode rédaction libre
    [Documentation]  Accès à l'instruction dont le modèle de document n'a pas pu être récupérée.
    ...  Clique sur l'action Édition rédaction libre et vérifie que les champs titre et corps
    ...  indiquent bien que leur contenu est vide.

    # Activation du mode edition intégrale et vérification du contenu des champs
    Depuis l'instruction du dossier d'instruction  ${di}  ${lib_instruction}
    Click On SubForm Portlet Action  instruction  enable-edition-integrale  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Open Fieldset In SubForm  instruction  titre  manual

    Element Should Contain  css=#titre_om_htmletat  Aucun contenu à afficher.
    Element Should Contain  css=#corps_om_htmletatex  Aucun contenu à afficher.

Rétablissement du paramétrage
    [Documentation]  Désactivation de l'option : option_redaction_libre

    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_redaction_libre
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
