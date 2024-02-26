*** Settings ***
Documentation  Test des événements d'instruction.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Ne pas mettre à jour le dossier d'instruction lors du suivi des dates d'une instruction
    [Documentation]  Lors de la modification d'une instruction, si celle-ci est liée à une
    ...  action utilisant [date_evenement] dans ses règles, alors celles-ci sont exécutées
    ...  sur le dossier d'instruction.
    ...  Lors du suivi des dates de l'instruction, il ne faut pas que le dossier
    ...  d'instruction soit mis à jour quelque soit l'action de l'instruction.

    Depuis la page d'accueil  admin  admin

    # Ajout le WF nécessaire pour le test
    &{args_action} =  Create Dictionary
    ...  action=test051_A001
    ...  libelle=test051_A001
    ...  regle_date_limite=date_evenement
    Ajouter l'action depuis le menu  ${args_action}
    @{etat_source} =  Create List
    ...  delai de notification envoye
    @{type_di} =  Create List
    ...  PCI - P - Initial
    &{args_evenement_001} =  Create Dictionary
    ...  libelle=test051_E001
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=${args_action.libelle}
    ...  lettretype=arrete ARRETE
    Ajouter l'événement depuis le menu  ${args_evenement_001}
    &{args_evenement_002} =  Create Dictionary
    ...  libelle=test051_E002
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=${args_action.libelle}
    ...  lettretype=arrete ARRETE
    Ajouter l'événement depuis le menu  ${args_evenement_002}

    # Depuis le dossier d'instruction, on deux instructeurs utilisant les deux événements identiques,
    # à chaque ajout on vérifie que la date limite est bien modifiée comme le stipule l'action
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Ménard
    ...  particulier_prenom=Susanne
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${date_evenement_001} =  Add Time To Date  ${date_ddmmyyyy}  1 days  %d/%m/%Y  True  %d/%m/%Y
    Ajouter une instruction au DI et la finaliser  ${di}  ${args_evenement_001.libelle}  false  ${date_evenement_001}
    Depuis le contexte du dossier d'instruction  ${di}
    Form Static Value Should Be  css=#date_limite  ${date_evenement_001}
    ${date_evenement_002} =  Add Time To Date  ${date_ddmmyyyy}  10 days  %d/%m/%Y  True  %d/%m/%Y
    Ajouter une instruction au DI et la finaliser  ${di}  ${args_evenement_002.libelle}  false  ${date_evenement_002}
    Depuis le contexte du dossier d'instruction  ${di}
    Form Static Value Should Be  css=#date_limite  ${date_evenement_002}

    # La modification du suivi des dates de la première instruction ajoutée ne devrait pas modifier
    # la date limite du dossier d'instruction
    &{args_instruction} =  Create Dictionary
    ...  date_envoi_signature=${DATE_FORMAT_DD/MM/YYYY}
    Modifier le suivi des dates  ${di}  ${args_evenement_001.libelle}  ${args_instruction}
    Depuis le contexte du dossier d'instruction  ${di}
    Form Static Value Should Be  css=#date_limite  ${date_evenement_002}


Appliquer un événement suivant malgré sa restriction en cas de déclenchement par une tâche de notification
    [Documentation]  Lorsqu'un événement se déclenche automatiquement à la saisie de la date de notification
    ...  et que la date de notification a été saisie par le traitement d'une tâche de notification
    ...  (pour résumer "notifié de façon dématerialisé"), alors celui-ci ne doit plus appliquer sa
    ...  restriction lors de son ajout.

    Depuis la page d'accueil  admin  admin
    # Active l'option de notification
    &{om_param} =  Create Dictionary
    ...  libelle=option_notification
    ...  valeur=portal
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    Constitution du Workflow de gestion d'une incomplétude  051

    # Date du jour moins un mois
    ${date_moins_un_mois} =  Ajouter ou supprimer des mois à une date  -1  ${date_ddmmyyyy}

    # Ajout du dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bobine
    ...  particulier_prenom=Jean
    ...  om_collectivite=MARSEILLE
    ...  courriel=bjean@notif.fr
    ...  notification=t
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=${date_moins_un_mois}
    ...  depot_electronique=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_sans_espace} =  Sans espace  ${di}

   # Modification de l'événement créé dans le WF incomplétude pour activer la notification automatique
   # et déclencher la création de l'événement suivant sur la date de notification
    &{args_evenement} =  Create Dictionary
    ...  libelle=incompletude_051
    ...  notification=Notification automatique
    ...  evenement_retour_ar=incompletude_notifiee_051
    ...  evenement_retour_signature=choisir événement lors du retour de signature
    Modifier l'événement  ${args_evenement}
    # Ajout et finalisation de l'instruction d'incomplétude
    Depuis le contexte du dossier d'instruction  ${di}
    # Calcul la date d'évènement limite
    ${date_lim_notif} =  Ajouter ou supprimer des mois à une date  1  ${date_moins_un_mois}
    ${date_lim_notif} =  Convert Date  ${date_lim_notif}  datetime  date_format=%d/%m/%Y
    ${day_event} =  Evaluate  ${date_lim_notif.day} - 1
    ${month_event} =  Set Variable If  ${date_lim_notif.month} < 10  0${date_lim_notif.month}  ${date_lim_notif.month}
    ${day_event} =  Set Variable If  ${date_lim_notif.day} < 10  0${date_lim_notif.day}  ${date_lim_notif.day}
    ${date_lim_evenement} =   Convert Date  ${date_lim_notif.year}-${month_event}-${day_event}  result_format=%d/%m/%Y
    # Ajoute une instruction en lui donnant la date limite possible
    # Si cette date n'est pas fourni pour les mois en 31 et les 29, 30 et 31 mars l'évènement ne pourra
    # pas être ajouté car la date courante dépassera la date limite de notification du dossier.
    Ajouter une instruction au DI et la finaliser  ${di}  ${incompletude_libelle}  false  ${date_lim_evenement}

    # Modification de la tâche de notification pour que le traitement s'applique
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_sans_espace}
    Depuis le contexte d'une task à partir de la recherche avancée  ${task_values}  portal
    ${values} =  Create Dictionary
    ...  state=terminé
    Modifier la tâche depuis sa page de consultation  ${values}  task_portal

    # Vérifie si l'événement suivant s'est correctement ajouté
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Page Should Contain  incompletude_notifiee_051

    &{om_param} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${om_param}


Prise en compte du cas particulier accord tacite quand à la suppression d'un évènement d'instruction 
    [Documentation]  On vérifie que la prise en compte du champ 'accord_tacite'
    ...  qui peut avoir comme valeur : 'Oui', 'Non' ou '   ' (3 espaces vides)
    ...  ne pose pas de problème lorsqu'on veux supprimer un évènement d'instruction affectant ce champ.

    Depuis la page d'accueil    admin    admin

    # Mise en place du paramétrage necessaire pour reproduire le contexte conflictuelle de la suppression
    # d'une instruction d'évènement

    # Création de l'action de workflow "Change valeur accord tacite"
    &{args_action} =  Create Dictionary
    ...  action=050_02_accord_tacite
    ...  libelle=Change valeur accord tacite
    ...  regle_accord_tacite=accord_tacite
    Ajouter l'action depuis le menu  ${args_action}

    # Création d'un événement de workflow changeant la valeur d'accord tacite
    @{etat_source} =  Create List  dossier accepter
    @{type_di} =  Create List  PD - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=050_02 modification accord_tacite
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=${args_action.libelle}
    ...  tacite=Oui
    Ajouter l'événement depuis le menu  ${args_evenement}

    # On importe un dossier test
    Depuis l'import spécifique    ads2007
    Add File    fic1    import_test_suppression_evenement.csv
    Click On Submit Button In Import CSV
    # On vérifie que l'import s'est bien effectué
    Résultat de l'import doit contenir  2 ligne(s) dans le fichier dont :
    Résultat de l'import doit contenir  - 1 ligne(s) d'entête
    Résultat de l'import doit contenir  - 1 ligne(s) importée(s)
    # Identifiant du dossier importé
    ${di} =  Set Variable  PD 044185 07 R0053

    Le dossier d'instruction doit exister  ${di}

    # On ajoute un évènement d'instruction modifiant le champ accord_tacite
    Ajouter une instruction au DI  ${di}  ${args_evenement.libelle}
    # On vérifie que cette modification, permet toujours la suppression de l'évènement en question
    Supprimer l'instruction  ${di}  ${args_evenement.libelle}
    # On vérifie qu'il n'y a aucun problème, et que l'évènement n'est plus présent
    La page ne doit pas contenir d'erreur
    Page Should Not Contain  ${args_evenement.libelle}
