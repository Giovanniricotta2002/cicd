*** Settings ***
Documentation     Fonctions et méthodes de traitement

*** Keywords ***
Wait Until All JavaScript Finished
    [Tags]  utils
    [Documentation]  Vérifie 3 conditions qui sont censées indiquer ensemble
    ...  que toutes les requètes réseau et traitements JavaScript sont finis.
    ...  1. Pas de requète XHR/Ajax en cours (partie réseau, pas callbacks)
    ...  2. Ressources de la page chargées (css, images) qui sinon n'est pas
    ...     convert par les autres vérifications.
    ...  3. Message(event) queue vide.
    ...     On vérifie que tous les évenements *déclenchés* sont finis: onClick,
    ...     onChange, onLoad, etc et n'importe quel callback en attente. Pas
    ...     ceux qui attendent un timer(setTimeout) ou le retour d'une XHR.
    ...     Quand le timer/XHR finisent, là les callbacks sont mis dans la queue.
    ...     https://developer.mozilla.org/en-US/docs/Web/JavaScript/EventLoop#Adding_messages
    ...  Attention: ne prend pas en compte le cas d'un traitement déclenché par
    ...  un setTimeout(). Si les 3 conditions passent à true avant que le timer
    ...  soit fini, c'est perdu !
    ...  Dépends de jQuery pour 1. mais il doit y avoir moyen de faire sans.


    ${js}=  catenate  SEPARATOR=\n
    ...  // 1.
    ...  if($.active !== 0) return false;
    ...  //
    ...  // 2.
    ...  if(document.readyState !== "complete") return false;
    ...  //
    ...  // 3. Pour ce faire, on ajoute un message dans la queue et on attend
    ...  // qu'il soit traité.
    ...  // Le flag est stocké sur window pour en faire une variable globale.
    ...  setTimeout(function() { window.allEventsFinished = true }, 0);
    ...  if(window.allEventsFinished !== true) return false;
    ...  //
    ...  // On met le flag à null pour que cela puisse servir plus d'une fois.
    ...  // Ce qui est utile en cas d'alternance d'XHR et callbacks où on risque
    ...  // d'avoir besoin que le check 2 et 3 bloquent alternativement.
    ...  window.allEventsFinished = null;
    ...  return true; // Tout devrait être terminé!
    Wait For Condition  ${js}  ${TIMEOUT}


Isolation d'un contexte
    [Tags]  utils
    [Arguments]  ${values}
    [Documentation]  Permet d'isoler un contexte avec la création :
    ...  - d'une collectivité mono et de son param minimum (dep, com et insee)
    ...  - d'une direction
    ...  - d'une division
    ...  - d'un utilisateur avec le profil "GUICHET UNIQUE"
    ...  - d'un utilisateur avec le profil "INSTRUCTEUR" et de son instructeur
    ...  - d'un utilisateur avec le profil "INSTRUCTEUR" et de son instructeur si
    ...    l'instructeur secondaire est renseigné
    ...  - d'une affectation automatique de l'instructeur sur les PCI
    ...  - d'une affectation automatique de l'instructeur_2 sur les PCI si
    ...    l'instructeur secondaire est renseigné
    ...  ###
    ...  Liste des valeurs à passer dans le dictionnaire en argument :
    ...  om_collectivite_libelle
    ...  departement
    ...  commune
    ...  insee
    ...  direction_code
    ...  direction_libelle
    ...  direction_chef
    ...  division_code
    ...  division_libelle
    ...  division_chef
    ...  guichet_om_utilisateur_nom
    ...  guichet_om_utilisateur_email
    ...  guichet_om_utilisateur_login
    ...  guichet_om_utilisateur_pwd
    ...  instr_om_utilisateur_nom
    ...  instr_om_utilisateur_email
    ...  instr_om_utilisateur_login
    ...  instr_om_utilisateur_pwd
    ...  instr_2_om_utilisateur_nom (optionnel)
    ...  instr_2_om_utilisateur_email (optionnel)
    ...  instr_2_om_utilisateur_login (optionnel)
    ...  instr_2_om_utilisateur_pwd (optionnel)

    Ajouter la collectivité depuis le menu  ${values.om_collectivite_libelle}  mono
    Ajouter le paramètre depuis le menu  departement  ${values.departement}  ${values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu  commune  ${values.commune}  ${values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu  insee  ${values.insee}  ${values.om_collectivite_libelle}
    Ajouter la direction depuis le menu  ${values.direction_code}  ${values.direction_libelle}  null  ${values.direction_chef}  null  null  ${values.om_collectivite_libelle}
    Ajouter la division depuis le menu  ${values.division_code}  ${values.division_libelle}  null  ${values.division_chef}  null  null  ${values.direction_libelle}
    ${exist_gu} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${values}  guichet_om_utilisateur_nom
    Run Keyword If  ${exist_gu} == True  Ajouter l'utilisateur depuis le menu  ${values.guichet_om_utilisateur_nom}  ${values.guichet_om_utilisateur_email}  ${values.guichet_om_utilisateur_login}  ${values.guichet_om_utilisateur_pwd}  GUICHET UNIQUE  ${values.om_collectivite_libelle}
    Ajouter l'utilisateur depuis le menu  ${values.instr_om_utilisateur_nom}  ${values.instr_om_utilisateur_email}  ${values.instr_om_utilisateur_login}  ${values.instr_om_utilisateur_pwd}  INSTRUCTEUR  ${values.om_collectivite_libelle}
    Ajouter l'instructeur depuis le menu  ${values.instr_om_utilisateur_nom}  ${values.division_libelle}  instructeur  ${values.instr_om_utilisateur_nom}

    ${exist_inst_2} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${values}  instr_2_om_utilisateur_nom
    Run Keyword If  ${exist_inst_2} == True  Ajouter l'utilisateur depuis le menu  ${values.instr_2_om_utilisateur_nom}  ${values.instr_2_om_utilisateur_email}  ${values.instr_2_om_utilisateur_login}  ${values.instr_2_om_utilisateur_pwd}  INSTRUCTEUR  ${values.om_collectivite_libelle}
    Run Keyword If  ${exist_inst_2} == True
    ...  Ajouter l'instructeur depuis le menu  ${values.instr_2_om_utilisateur_nom}  ${values.division_libelle}  instructeur  ${values.instr_2_om_utilisateur_nom}
    ${instructeur_2} =  set variable if  ${exist_inst_2} == True
    ...  ${values.instr_2_om_utilisateur_nom} (${values.division_code})
    ...  choisir Instructeur secondaire

    &{args_affectation} =  Create Dictionary
    ...  instructeur=${values.instr_om_utilisateur_nom} (${values.division_code})
    ...  instructeur_2=${instructeur_2}
    ...  om_collectivite=${values.om_collectivite_libelle}
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    Ajouter l'affectation depuis le menu  ${args_affectation}


Depuis le contexte d'un enregistrement
    [Tags]  generic
    [Arguments]  ${args}
    [Documentation]  GENERIC - Accède à la fiche de consultation de
    ...  l'enregistrement.
    ...  Liste des valeurs à déclarer dans le dictionnaire **args** :
    ...  * obj (objet de l'enregistrement)
    ...  * selection_col (colonne pour la recherche simple)
    ...  * search_value (valeur pour la recherche simple)
    ...  * click_value (valeur à cliquer)
    Depuis le listing  ${args.obj}
    Use Simple Search  ${args.selection_col}  ${args.search_value}
    Click Element Until No More Element  link:${args.click_value}


Saisir l'enregistrement
    [Tags]  generic
    [Arguments]  ${values}
    [Documentation]  GENERIC - Saisie un enregistrement.
    ...  Chaque élément de la liste **values** est une liste contenant trois
    ...  valeurs (l'ordre de déclaration est important) :
    ...  * le libelle du champ à saisir
    ...  * la valeur à saisir
    ...  * le keyword à utiliser pour la saisie de la valeur
    :FOR  ${item}  IN  @{values}
    \  Run Keyword  ${item[2]}  ${item[0]}  ${item[1]}


Ajouter l'enregistrement depuis le menu
    [Tags]  generic
    [Arguments]  ${args}  ${values}
    [Documentation]  GENERIC - Ajoute un enregistrement.
    ...  Liste des valeurs à déclarer dans le dictionnaire **args** :
    ...  * obj (objet de l'enregistrement)
    ...  * msg (message de réussite à la validation du formulaire)
    ...  Chaque élément de la liste **values** est une liste contenant trois
    ...  valeurs (l'ordre de déclaration est important) :
    ...  * le libelle du champ à saisir
    ...  * la valeur à saisir
    ...  * le keyword à utiliser pour la saisie de la valeur
    Depuis le listing  ${args.obj}
    Click On Add Button
    Saisir l'enregistrement  ${values}
    Click On Submit Button
    ${exist} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${args}  msg
    Run Keyword If  ${exist} == True  Valid Message Should Contain  ${args.msg}


Modifier l'enregistrement depuis le menu
    [Tags]  generic
    [Arguments]  ${args}  ${values}
    [Documentation]  GENERIC - Modifie un enregistrement.
    ...  Liste des valeurs à déclarer dans le dictionnaire **args** :
    ...  * obj (objet de l'enregistrement)
    ...  * selection_col (colonne pour la recherche simple)
    ...  * search_value (valeur pour la recherche simple)
    ...  * click_value (valeur à cliquer)
    ...  * msg (message de réussite à la validation du formulaire)
    ...  Chaque élément de la liste **values** est une liste contenant trois
    ...  valeurs (l'ordre de déclaration est important) :
    ...  * le libelle du champ à saisir
    ...  * la valeur à saisir
    ...  * le keyword à utiliser pour la saisie de la valeur
    Depuis le contexte d'un enregistrement  ${args}
    Click On Form Portlet Action  ${args.obj}  modifier
    Saisir l'enregistrement  ${values}
    Click On Submit Button
    ${exist} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${args}  msg
    Run Keyword If  ${exist} == True  Valid Message Should Contain  ${args.msg}


Supprimer l'enregistrement depuis le menu
    [Tags]  generic
    [Arguments]  ${args}
    [Documentation]  GENERIC - Supprime l'enregistrement.
    ...  Liste des valeurs à déclarer dans le dictionnaire **args** :
    ...  * obj (objet de l'enregistrement)
    ...  * selection_col (colonne pour la recherche simple)
    ...  * search_value (valeur pour la recherche simple)
    ...  * click_value (valeur à cliquer)
    ...  * msg (message de réussite à la validation du formulaire)
    Depuis le contexte d'un enregistrement  ${args}
    Click On Form Portlet Action  ${args.obj}  supprimer
    Click On Submit Button
    ${exist} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${args}  msg
    Run Keyword If  ${exist} == True  Valid Message Should Contain  ${args.msg}


Click On Tab Action
    [Tags]
    [Arguments]  ${idx}  ${obj}  ${action}  ${position}=left  ${soustab}=False  ${mode}=None  ${message}=None
    # si le mode de confirmation est
    #   new_window: vérifie qu'une nouvelle fenêtre est apparue
    #   modale    : vérifie qu'une fenêtre modale est apparue
    #   message   : vérifie qu'un message est apparu
    #   *         : vérifie que l'élément cliqué a disparu
    ${selector} =  Set Variable If  ${soustab}
    ...  css=#action-soustab-${obj}-${position}-${action}-${idx}
    ...  css=#action-tab-${obj}-${position}-${action}-${idx}
    Run Keyword If  '${mode}' == 'new_window'  Click Element Until New Window       ${selector}
    ...    ELSE IF  '${mode}' == 'modale'      Click Element Until New Element      ${selector}  css=.ui-widget-overlay
    ...    ELSE IF  '${mode}' == 'message'     Click Element Until Message          ${selector}  ${message}
    ...    ELSE                                Click Element Until No More Element  ${selector}
    La page ne doit pas contenir d'erreur


Constitution du Workflow de gestion d'une incomplétude
    [Tags]  generic
    [Arguments]  ${number}
    [Documentation]  Création du Workflow complet permettant la gestion de l'incomplétude dans un dossier d'instruction

    # Création des actions
    # incomplétude
    Set Suite Variable  ${incompletude_libelle}  incompletude_${number}
    &{args_action} =  Create Dictionary
    ...  action=${incompletude_libelle}
    ...  libelle=${incompletude_libelle}
    ...  regle_etat=etat
    ...  regle_incompletude=t
    ...  regle_etat_pendant_incompletude=archive_etat
    Ajouter l'action depuis le menu  ${args_action}
    # incomplétude notifiée
    Set Suite Variable  ${incompletude_notifiee_libelle}  incompletude_notifiee_${number}
    &{args_action} =  Create Dictionary
    ...  action=${incompletude_notifiee_libelle}
    ...  libelle=${incompletude_notifiee_libelle}
    ...  regle_etat=etat
    ...  regle_date_complet=null
    ...  regle_date_limite_incompletude=date_evenement+delai
    ...  regle_delai_incompletude=delai
    ...  regle_incomplet_notifie=t
    ...  regle_evenement_suivant_tacite_incompletude=t
    Ajouter l'action depuis le menu  ${args_action}
    # dépôt de pièce complémentaire
    Set Suite Variable  ${dpc_libelle}  dpc_${number}
    &{args_action} =  Create Dictionary
    ...  action=${dpc_libelle}
    ...  libelle=${dpc_libelle}
    ...  regle_date_dernier_depot=date_evenement
    Ajouter l'action depuis le menu  ${args_action}
    # complétude
    Set Suite Variable  ${completude_libelle}  completude_${number}
    &{args_action} =  Create Dictionary
    ...  action=${completude_libelle}
    ...  libelle=${completude_libelle}
    ...  regle_etat=archive_etat_pendant_incompletude
    ...  regle_accord_tacite=accord_tacite
    ...  regle_date_limite=archive_date_dernier_depot+archive_delai
    ...  regle_date_notification_delai=archive_date_dernier_depot+delai_notification
    ...  regle_date_complet=archive_date_dernier_depot
    ...  regle_date_limite_incompletude=null
    ...  regle_delai_incompletude=null
    ...  regle_incompletude=f
    ...  regle_incomplet_notifie=f
    ...  regle_etat_pendant_incompletude=null
    Ajouter l'action depuis le menu  ${args_action}

    # Création des états
    # incompletude
    &{args_etat} =  Create Dictionary
    ...  etat=${incompletude_libelle}
    ...  libelle=${incompletude_libelle}
    ...  statut=En cours
    Ajouter état  ${args_etat}
    # incompletude notifiée
    &{args_etat} =  Create Dictionary
    ...  etat=${incompletude_notifiee_libelle}
    ...  libelle=${incompletude_notifiee_libelle}
    ...  statut=En cours
    Ajouter état  ${args_etat}

    # Création des événements
    @{type_di} =  Create List  PCI - P - Initial
    # incomplétude notifiée
    &{args_evenement} =  Create Dictionary
    ...  libelle=${incompletude_notifiee_libelle}
    ...  retour=true
    ...  etat=${incompletude_notifiee_libelle}
    # Non nécessaire car récupéré depuis l'événement parent (incompletude_${number})
    # ...  delai=3 Mois
    # ...  accord_tacite=Oui
    # ...  restriction=date_evenement<=archive_date_notification_delai
    ...  action=${incompletude_notifiee_libelle}
    ...  evenement_suivant_tacite=rejet tacite
    Ajouter l'événement depuis le menu  ${args_evenement}
    # incomplétude
    @{etat_source} =  Create List  delai de notification envoye
    &{args_evenement} =  Create Dictionary
    ...  libelle=${incompletude_libelle}
    ...  restriction=date_evenement<=archive_date_notification_delai
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  etat=${incompletude_libelle}
    ...  delai=3 Mois
    ...  accord_tacite=Oui
    ...  lettretype=piececomplementaire NOTIFICATION D'UNE DEMANDE DE PIECES COMPLEMENTAIRES
    ...  action=${incompletude_libelle}
    ...  evenement_retour_signature=${incompletude_notifiee_libelle}
    Ajouter l'événement depuis le menu  ${args_evenement}
    # dépôt de pièce complémentaire
    @{etat_source} =  Create List  ${incompletude_notifiee_libelle}
    &{args_evenement} =  Create Dictionary
    ...  libelle=${dpc_libelle}
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=recepisse_DPC RECEPISSE DE DEPOT DE PIECES COMPLEMENTAIRES
    ...  action=${dpc_libelle}
    Ajouter l'événement depuis le menu  ${args_evenement}
    # completude
    &{args_evenement} =  Create Dictionary
    ...  libelle=${completude_libelle}
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  accord_tacite=Oui
    ...  delai_notification=1 Mois
    ...  action=${completude_libelle}
    Ajouter l'événement depuis le menu  ${args_evenement}

    # Modification de l'événement de récépissé
    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  evenement_suivant_tacite=accord tacite (sans arrete)
    Modifier l'événement  ${args_evenement}

Tab ${Tab} Should Not Contain Add Button
    [Documentation]  Vérifie que le bouton d'ajout d'un listing n'est pas affiché

    Page Should Not Contain Element    css=#action-tab-${Tab}-corner-ajouter

Click Element Until Alert
    [Documentation]  Clique sur un élément jusqu'à ce qu'une alerte apparaisse.
    ...  Vérifie que l'alerte est bien présente en utilisant son message.
    ...  Gère également l'alerte de la manière voulue (ACCEPT par défaut).
    [Arguments]  ${elm_clicked}  ${msg_alert}  ${how_to_handle}=ACCEPT

    # 3 essais de clic sur l'élément (passé en paramètre)
    :FOR  ${INDEX}  IN RANGE  1  4
    \  # attente du succès du clic pendant 3 secondes max
    \  Wait Until Keyword Succeeds  3  ${RETRY_INTERVAL}  Click Element  ${elm_clicked}
    \  # attente de l'apparition de l'alerte pendant quelques secondes
    \  ${alert_visible}=  Run Keyword And Return Status
    \  ...  Wait Until Keyword Succeeds  ${CLIC_CONFIRM_WAIT}  ${RETRY_INTERVAL}  Alert Should Be Present  ${msg_alert}  ${how_to_handle}
    \  # si l'alert est devenu visible, on sort de la boucle
    \  Run Keyword If  ${alert_visible}  Return From Keyword
    Run Keyword If  ${INDEX} == 3  Fail  Le clic sur '${elm_clicked}' a échoué

Activer le mode service consulté
    [Documentation]  Ajoute ou modifier le paramètre option_mode_service_consulté
    ...  depuis le menu Administration > Paramétrage pour activer le mode service
    ...  consulté

    &{params} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${params}

Désactiver le mode service consulté
    [Documentation]  Supprime le paramètre option_mode_service_consulté depuis
    ...  le menu Administration > Paramétrage pour désactiver le mode service
    ...  consulté

    &{params} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_mode_service_consulte
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${params}

Importer des données
    [Documentation]  Accède au menu d'import souhaité (par défaut : Administration > Import)
    ...  sélectionne l'import voulu, rempli le formulaire avec le paramétrage fourni et
    ...  clique sur le bouton de validation. Vérifie que le résultat de l'import est bien
    ...  celui souhaité.
    [Arguments]  ${obj}  ${values}  ${results}  ${type_import}=${EMPTY}

    # Accéde aux import classique ou spécifique en utilisant le keyword adapté
    Run Keyword  Depuis l'import ${type_import}  ${obj}
    # Rempli le formulaire d'import
    Si "fic1" existe dans "${values}" on execute "Add File" dans le formulaire
    Si "separateur" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "import_id" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    # Valide le formulaire et vérifie le message reçu
    Click On Submit Button In Import CSV
    :FOR  ${result}  IN  @{results}
    \  Résultat de l'import doit contenir  ${result}

Ajouter ou supprimer des mois à une date
    [Documentation]  Permet d'ajouter ou de retrancher (en utilisant un nombre négatif) 
    ...  des mois à une date, tout en tenant compte des années bissextiles.
    ...  On peut ajouter ou retrancher 12 mois au maximum.
    ...  Le format de ${date} est : dd/mm/yyyy
    [Arguments]  ${nombre_mois}  ${date}

    # Convertir la string ${date} en objet
    ${date_dmy} =  Convert Date  ${date}  datetime  date_format=%d/%m/%Y
    ${day_date} =  Set Variable  ${date_dmy.day}
    ${day_date} =  Convert To Integer  ${day_date}
    ${month_date} =  Set Variable  ${date_dmy.month}
    ${month_date} =  Convert To Integer  ${month_date}
    ${year_date} =  Set Variable  ${date_dmy.year}
    ${year_date} =  Convert To Integer  ${year_date}
    
    # Calcul des mois
    # * Si le nombre de mois est négatif (${nombre_mois} < 0), cela donne pour le 06/03/2023, auquel on veut retirer 5 mois :
    #    -5 + 12 + 6, avec "-5" comme nombre de mois à ôter à 12 par ans, partant du mois "numéro 6" 

    # * Si le nombre de mois est positif (${nombre_mois} > 0) et que :
    #    * le nombre à ajouter est inférieur aux 12 mois de l'année ôtés du mois d'où part le calcul (${month_date} < (12 - ${nombre_mois})),
    #      alors il suffit d'ajouter le nombre de mois au mois en cours :
    #      5 + 6 => 06/11/2023
    #    * le nombre à ajouter est supérieur aux 12 mois de l'année ôtés du mois d'où part le calcul, 
    #      alors on utilise le même calcul mais en ôtant cette fois une année, afin d'avoir le résultat modulo 12.
    #      Cela donne pour le 06/08/2023, auquel on veut ajouter 5 mois :
    #      5 - 12 + 8 => 06/01/2023
    # Enfin, l'utilisation de la variable ${nombre_de_mois_absolu} permet d'alléger les calculs de ${next_month} ainsi

    ${nombre_de_mois_absolu} =  Evaluate  ${nombre_mois} + ${month_date}

    ${next_month} =  Run Keyword If  ${nombre_mois} > 0 and ${month_date} < (12 - ${nombre_mois})  Set Variable  ${nombre_de_mois_absolu}
    ...  ELSE IF  ${nombre_mois} < 0 and ${nombre_de_mois_absolu} > 0  Set Variable  ${nombre_de_mois_absolu}
    ...  ELSE IF  ${nombre_mois} < 0  Evaluate  ${nombre_de_mois_absolu} + 12
    ...  ELSE IF  ${nombre_mois} > 0  Evaluate  ${nombre_de_mois_absolu} - 12

    # Si le calcul ramène le mois à "0", il devient "12"
    ${next_month} =  Run Keyword If  ${next_month} == 0  Set Variable  12  ELSE  Set Variable  ${next_month}

    # Traitement du dépassement de mois
    ${next_month_year} =  Run Keyword If  ${nombre_mois} > 0 and ${nombre_de_mois_absolu} >= 12  Evaluate  ${year_date} + 1  ELSE IF  ${nombre_mois} < 0 and ${nombre_de_mois_absolu} < 1  Evaluate  ${year_date} - 1  ELSE  Set Variable  ${year_date}

    # Déterminer s'il s'agit d'années bissextiles (leap year) ou non
    ${is_next_year_leap} =  calendar.isleap  ${next_month_year}

    # Traitement du dernier jour du mois
    # Calcul du jour max de février selon le type d'année
    ${max_day_feb} =  Set Variable If  ${is_next_year_leap} == True  29  28
    # Map du nombre de jour pour chaque mois
    &{max_day_per_month} =  Create Dictionary
    ...  1=31
    ...  2=${max_day_feb}
    ...  3=31
    ...  4=30
    ...  5=31
    ...  6=30
    ...  7=31
    ...  8=31
    ...  9=30
    ...  10=31
    ...  11=30
    ...  12=31

    ${next_month_string} =  Convert To String  ${next_month}

    # Détermination du dernier jour du mois suivant
    ${last_day_in_next_month}  Get From Dictionary  ${max_day_per_month}  ${next_month_string}
    # Si le jour calculé dépasse le dernier jour du mois,
    ${get_last_day} =  Set Variable If  ${last_day_in_next_month} < ${day_date}  True  False
    # extraction du dernier jour du mois selon
    ${day_date} =  Run Keyword If  ${get_last_day} == True  Get From Dictionary  ${max_day_per_month}  ${next_month_string}
    ...  ELSE  Set Variable  ${day_date}

    # Préparation de la date résultat
    # Formate correctement le mois si sa valeur est inférieure à 10
    ${next_month} =  Set Variable If  ${next_month} < 10  0${next_month}  ${next_month}
    # Formate correctement le jour si sa valeur est inférieure à 10
    ${day_date} =  Set Variable If  ${day_date} < 10  0${day_date}  ${day_date}
    # Formate correctement l'année si sa valeur est inférieure à 1000
    ${next_month_year} =  Set Variable If  ${next_month_year} < 1000  0${next_month_year}  ${next_month_year}
    # Chaîne de caractères représentant la date dans le format "année-mois-jour"
    ${next_month_date} =  Set Variable  ${next_month_year}-${next_month}-${day_date}
    # Chaîne de caractères représentant la date dans le format "jour/mois/année"
    ${date_calculated} =  Convert Date  ${next_month_date}  result_format=%d/%m/%Y

    [Return]  ${date_calculated}

Vérifier que la date ${date_1} est inférieure à la date ${date_2}
    [Documentation]  Prend deux dates au format "YYYY-MM-DD" et les compare pour
    ...  vérifier que la première est supérieure à la deuxième.
    ...  La comparaison est faite en découpant la date selon les "/" pour créer un
    ...  tableaux à 3 entrées : Jour, Mois et Année
    ...  Ce tableaux est ensuite inversé : Année, Mois et Jour et transformé en chaine.
    ...  Ainsi on peut comparer les 2 dates pour savoir laquelle est la plus ancienne.

    # Récupération des éléments de la date séparément dans un array (Jour/Mois/Année) 
    ${splitted_1}=  Split String    ${date_1},    separator=/
    ${splitted_2}=  Split String    ${date_2},    separator=/
    # Inversion des valeurs de l'array contenant la date (Année/Mois/Jour)
    ${reverse_splitted_1}    Evaluate    $splitted_1[::-1]
    ${reverse_splitted_2}    Evaluate    $splitted_2[::-1]
    # Conversion de l'array en String
    ${reverse_splitted_1} =  Convert To String  ${reverse_splitted_1}
    ${reverse_splitted_2} =  Convert To String  ${reverse_splitted_2}
    # Comparaison des valeurs
    Should Be True     """${reverse_splitted_1}""" <= """${reverse_splitted_2}"""

Chosen List Should Contain List
    [Documentation]  Vérifie que le chosen contiens la liste données.
    ...  Pour cela, affiche le select sur lequel le chosen est basé avec du
    ...  javascript. Vérifie si les éléments de la liste passé en argument
    ...  sont présent dans le select. Remet le select à son état initial.
    [Arguments]  ${selector}  ${expected_options}

    # Rend le select visible pour qu'on puisse tester ces options
    Execute JavaScript  window.jQuery("${selector}").attr('style', '')
    Wait Until Element Is Visible   css=${selector}
    # Vérifie le contenu de la liste
    Select List Should Contain List  css=${selector}  ${expected_options}
    # Remet le select comme il était
    Execute JavaScript  window.jQuery("${selector}").attr("style", "display: none;")
    Wait Until Element Is Not Visible   css=${selector}

Chosen List Should Not Contain List
    [Documentation]  Vérifie que le chosen ne contiens pas la liste données.
    ...  Pour cela, affiche le select sur lequel le chosen est basé avec du
    ...  javascript. Vérifie si les éléments de la liste passé en argument ne
    ...  sont pas présent dans le select. Remet le select à son état initial.
    [Arguments]  ${selector}  ${unexpected_options}

    # Rend le select visible pour qu'on puisse tester ces options
    Execute JavaScript  window.jQuery("${selector}").attr('style', '')
    Wait Until Element Is Visible   css=${selector}
    # Vérifie le contenu de la liste
    Select List Should Not Contain List  css=${selector}  ${unexpected_options}
    # Remet le select comme il était
    Execute JavaScript  window.jQuery("${selector}").attr("style", "display: none;")
    Wait Until Element Is Not Visible   css=${selector}

Vérifier le code retour du web service et vérifier que son message au format string contient
    [Tags]
    [Documentation]  Même documentation que le keyword "Vérifier le code retour du web service et vérifier que son message contient" mais avec retour du WS en string et non en JSON.

    [Arguments]    ${methods}    ${ressource}    ${json}    ${code}    ${message}
    ${resp} =    Appeler le web service    ${methods}    ${ressource}    ${json}
    Should be Equal    '${resp.status_code}'    '${code}'

    ${is_message_exist} =    Run Keyword And Return Status    Get From Dictionary    ${resp.content}    message
    Run Keyword If    ${is_message_exist}    Should Contain    ${resp.content}    ${message}

Vérifier qu'un élément a une classe CSS
    [Documentation]  Vérifie par son attribut HTML (**attribute**)
    ...  et sa valeur d'attribut (**attribute_value**),
    ...  qu'élément possède une classe CSS (**CSS_class**)
    [Arguments]  ${attribute}  ${attribute_value}  ${CSS_class}

    ${command}  Set Variable  return document.querySelector("[${attribute}='${attribute_value}']").classList.contains("${CSS_class}")
    ${is_element_containing_CSS_class}=  Execute Javascript  ${command}

    Should Be True  ${is_element_containing_CSS_class}

Select list should contain value
    [Documentation]  Vérifie que la liste (select) identifiée par le locator contiens bien la valeur (option) voulue.
    [Arguments]  ${locator}  ${expected_value}

    Wait Until Page Contains Element  ${locator}
    ${listeRecuperee} =  Get List Items  ${locator}
    List Should Contain Value  ${listeRecuperee}  ${expected_value}

Select list should not contain value
    [Documentation]  Vérifie que la liste (select) identifiée par le locator ne contiens pas la valeur (option) voulue.
    [Arguments]  ${locator}  ${unexpected_value}

    Wait Until Page Contains Element  ${locator}
    ${listeRecuperee} =  Get List Items  ${locator}
    List Should Not Contain Value  ${listeRecuperee}  ${unexpected_value}