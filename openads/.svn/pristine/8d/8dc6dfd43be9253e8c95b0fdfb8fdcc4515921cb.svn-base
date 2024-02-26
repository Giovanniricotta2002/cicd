*** Settings ***
Documentation     Notification des demandeurs

# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown

*** Keywords ***
Valider le formulaire de notification
    [Documentation]  Clique sur le bouton de validation du formulaire
    ...  de notification manuelle. Vérifie que la validation a bien été
    ...  enregistré et que la page ne contiens pas d'erreur.
    ...  Récupère et renvoie la date et l'heure de validation du formulaire.

    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Wait Until Page Contains  La notification a été générée.
    La page ne doit pas contenir d'erreur
    [Return]  ${CurrentDate}

*** Test Cases ***
Constitution du jeu de données
    [Documentation]  constitution d'un jeu de données servant à tester le bon fonctionnement
    ...  de la notification des demandeurs

    Depuis la page d'accueil  admin  admin
    # Isolation du contexte
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_NOTIFDEM
    ...  departement=020
    ...  commune=001
    ...  insee=20001
    ...  direction_code=Notif
    ...  direction_libelle=Direction de LIBRECOM_NOTIFDEM
    ...  direction_chef=Chef
    ...  division_code=Notif
    ...  division_libelle=Division Notif
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Durandana Paquet
    ...  guichet_om_utilisateur_email=dpaquet@openads-test.fr
    ...  guichet_om_utilisateur_login=dpaquet
    ...  guichet_om_utilisateur_pwd=dpaquet
    ...  instr_om_utilisateur_nom=Mandel Paulet
    ...  instr_om_utilisateur_email=mpaulet@openads-test.fr
    ...  instr_om_utilisateur_login=mpaulet
    ...  instr_om_utilisateur_pwd=mpaulet
    ...  acteur=plop
    Isolation d'un contexte  ${librecom_values}

    # paramètrage du titre et du message de notificatio
    &{om_param} =  Create Dictionary
    ...  libelle=parametre_courriel_type_titre
    ...  valeur=[openADS] Notification concernant votre dossier [DOSSIER]
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{om_param} =  Create Dictionary
    ...  libelle=parametre_courriel_service_type_titre
    ...  valeur=[openADS] Notification pour les services concernant le dossier [DOSSIER]
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{om_param} =  Create Dictionary
    ...  libelle=parametre_courriel_type_message
    ...  valeur=Bonjour, veuillez prendre connaissance du(des) document(s) suivant(s) :<br> [LIEN_TELECHARGEMENT_DOCUMENT]<br>[LIEN_TELECHARGEMENT_ANNEXE]
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    
    &{om_param} =  Create Dictionary
    ...  libelle=parametre_courriel_service_type_message
    ...  valeur=Bonjour les services, veuillez prendre connaissance du(des) document(s) suivant(s) :<br> [LIEN_TELECHARGEMENT_DOCUMENT]<br>[LIEN_TELECHARGEMENT_ANNEXE]
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{om_param} =  Create Dictionary
    ...  libelle=parametre_notification_url_acces
    ...  valeur=http://localhost/openads/
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # lettretype
    &{args_lettretype} =  Create Dictionary
    ...  id=test_NOTIF
    ...  libelle=Test
    ...  sql=Aucune REQUÊTE
    ...  titre=&idx, &destinataire, aujourdhui&aujourdhui, datecourrier&datecourrier, &departement
    ...  corps=Ceci est un document
    ...  actif=true
    ...  collectivite=agglo
    Ajouter la lettre-type depuis le menu  &{args_lettretype}

    # Ajout de 9 événements pour tester tous les cas de notification
    # 4 événements avec des lettretypes sans annexes
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement1} =  Create Dictionary
    ...  libelle=TEST_NOTIF_AUTO_LETTRETYPE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=test_NOTIF Test
    ...  notification=Notification automatique
    Ajouter l'événement depuis le menu  ${args_evenement1}

    &{args_evenement2} =  Create Dictionary
    ...  libelle=TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=test_NOTIF Test
    ...  notification=Notification automatique avec signature requise
    Ajouter l'événement depuis le menu  ${args_evenement2}

    &{args_evenement3} =  Create Dictionary
    ...  libelle=TEST_NOTIF_MAN_LETTRETYPE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=test_NOTIF Test
    ...  notification=Notification manuelle
    Ajouter l'événement depuis le menu  ${args_evenement3}

    &{args_evenement4} =  Create Dictionary
    ...  libelle=TEST_NOTIF_MAN_SIGN_LETTRETYPE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=test_NOTIF Test
    ...  notification=Notification manuelle avec signature requise
    Ajouter l'événement depuis le menu  ${args_evenement4}

    # 2 événements sans lettretypes sans annexe
    &{args_evenement5} =  Create Dictionary
    ...  libelle=TEST_NOTIF_AUTO
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  notification=Notification automatique
    Ajouter l'événement depuis le menu  ${args_evenement5}

    &{args_evenement6} =  Create Dictionary
    ...  libelle=TEST_NOTIF_MAN
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  notification=Notification manuelle
    Ajouter l'événement depuis le menu  ${args_evenement6}

    # 3 événements avec annexe
    &{args_evenement7} =  Create Dictionary
    ...  libelle=TEST_NOTIF_MAN_ANNEXE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  notification=Notification manuelle avec annexe
    Ajouter l'événement depuis le menu  ${args_evenement7}

    &{args_evenement8} =  Create Dictionary
    ...  libelle=TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=test_NOTIF Test
    ...  notification=Notification manuelle avec annexe
    Ajouter l'événement depuis le menu  ${args_evenement8}

    &{args_evenement9} =  Create Dictionary
    ...  libelle=TEST_NOTIF_MAN_SIGN_LETTRETYPE_ANNEXE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=test_NOTIF Test
    ...  notification=Notification manuelle avec annexe et avec signature requise
    Ajouter l'événement depuis le menu  ${args_evenement9}

    # Évenements dont les services consultés peuvent être notifiés
    &{args_evenement10} =  Create Dictionary
    ...  libelle=TEST_NOTIF_SC_SANS_LETTRETYPE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  notification_service=true
    Ajouter l'événement depuis le menu  ${args_evenement10}

    &{args_evenement11} =  Create Dictionary
    ...  libelle=TEST_NOTIF_SC_AVEC_LETTRETYPE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=test_NOTIF Test
    ...  notification_service=true
    Ajouter l'événement depuis le menu  ${args_evenement11}

    # Création de deux services d'instruction notifiable et d'un non notifiable
    &{service} =  Create Dictionary
    ...  abrege=00.00
    ...  libelle=ServiceNotifiable1
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  service_type=openADS
    ...  generate_edition=true
    ...  accepte_notification_email=true
    ...  email=notifiable1@ok.fr
    Ajouter le service depuis le listing  ${service}

    &{service} =  Create Dictionary
    ...  abrege=00.01
    ...  libelle=ServiceNotifiable2
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  service_type=openADS
    ...  generate_edition=true
    ...  accepte_notification_email=true
    ...  email=notifiable2@ok.fr\nnotifiable3@ok.fr\nnotifiable4@ok.fr
    Ajouter le service depuis le listing  ${service}

    &{service} =  Create Dictionary
    ...  abrege=00.02
    ...  libelle=ServiceNonNotifiable
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  service_type=openADS
    ...  generate_edition=true
    ...  accepte_notification_email=false
    ...  email=nnotifiable@nope.fr
    Ajouter le service depuis le listing  ${service}

Activation de la notification par mail
    [Documentation]  Active la notification par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    &{om_param} =  Create Dictionary
    ...  libelle=option_notification
    ...  valeur=mail
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{om_param} =  Create Dictionary
    ...  libelle=option_notification_piece_numerisee
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    Démarrer maildump


Notification automatique par mail d'une instruction sans lettretype
    [Documentation]  Vérifie le bon fonctionnement de la notification automatique
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Cressac
    ...  particulier_prenom=Véronique
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=vcressac@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Charpie
    ...  particulier_prenom=Aimé
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=caime@notnotif.fr

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique sans lettretype
    # La notification doit se faire à l'ajout de l'instruction
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI  ${di_notif_auto1}  TEST_NOTIF_AUTO

    # Vérification de l'affichage du tableau de suivi
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_AUTO
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  vcressac@notif.fr
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_AUTO
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    Element Should Not Contain  css=td[data-column-id="destinataire"]  caime@notnotif.fr
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # On vérifie qu'un dossier déjà notifié ne peut pas être supprimé
    Depuis la page d'accueil  admin  admin

    # On active l'option de suppression
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    Depuis le contexte du dossier d'instruction  ${di_notif_auto1}

    Portlet Action Should Not Be In Form  dossier_instruction  supprimer

    # On désactive l'option de suppression
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Vérification de l'envoi du mail et du contenu du mail
    Verifier que le mail a bien été envoyé au destinataire  vcressac@notif.fr
    Page Should Not Contain  caime@notnotif.fr
    # le mail ne doit pas contenir de lien car il n'y a pas de pièce
    Vérifier que le contenu du mail ne contiens pas  vcressac@notif.fr  /web/notification.php?key=


Notification automatique par mail d'une instruction avec lettretype sans signature requise
    [Documentation]  Vérifie le bon fonctionnement de la notification automatique
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Patience
    ...  particulier_prenom=Boncoeur
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=pboncoeur@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Veronneau
    ...  particulier_prenom=Vail
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique sans la finaliser pour vérifier
    # que l'action d'envoi manuelle de la notification n'est pas visible
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI  ${di_notif_auto1}  TEST_NOTIF_AUTO_LETTRETYPE
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_AUTO_LETTRETYPE
    Portlet Action Should Not Be In SubForm  instruction  overlay_notification_manuelle
    # Finalisation de l'instruction ce qui doit déclencher l'envoi de la notification automatique
    Click On SubForm Portlet Action  instruction  finaliser
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y

    # Test de l'affichage des informations dans le tableau de suivi
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  pboncoeur@notif.fr
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_AUTO_LETTRETYPE
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    Element Should Not Contain  css=td[data-column-id="destinataire"]  vail
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Vérification de l'envoi du mail et du contenu du mail
    Verifier que le mail a bien été envoyé au destinataire  pboncoeur@notif.fr
    Page Should Not Contain  vail
    # le mail doit contenir le lien vers la pièce
    Vérifier le contenu du mail  pboncoeur@notif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_AUTO_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}


Notification automatique par mail d'une instruction avec lettretype et avec retour signature
    [Documentation]  Vérifie le bon fonctionnement de la notification automatique
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Denomination
    ...  personne_morale_nom=Monjeau
    ...  personne_morale_prenom=Eglantine
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=meglantine@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_raison_sociale=raison sociale
    ...  personne_morale_nom=Bonenfant
    ...  personne_morale_prenom=Anne
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=abonenfant@notnotif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique avec lettretype avec signature
    # La notification doit se faire à l'ajout de la date de retour
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Portlet Action Should Not Be In SubForm  instruction  overlay_notification_manuelle
    Page Should Not Contain Element  css=fieldset#fieldset-sousform-instruction-suivi-notification
    # Remplissage de la date de retour de signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Click On Submit Button In Subform

    # Vérification de l'affichage du tableau de suivi
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="émetteur"]      admin (Administrateur)
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=div#suivi_notification_jsontotab  meglantine@notif.fr
    Element Should Contain  css=div#suivi_notification_jsontotab  abonenfant@notnotif.fr
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="instruction"]  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="statut"]       envoyé
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Vérification de l'envoi des mails et de leur contenu
    Verifier que le mail a bien été envoyé au destinataire  meglantine@notif.fr
    Vérifier le contenu du mail  meglantine@notif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document

    Verifier que le mail a bien été envoyé au destinataire  abonenfant@notnotif.fr
    Vérifier le contenu du mail  abonenfant@notnotif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}


Notification manuelle par mail d'une instruction sans lettretype
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Loiselle
    ...  particulier_prenom=Roland
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=rloiselle@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Dandonneau
    ...  particulier_prenom=Parfait
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=dparfait@notnotif.fr

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique sans lettretype
    Depuis la page d'accueil  mpaulet  mpaulet
    ${inst_notif_man} =  Ajouter une instruction au DI  ${di_notif_auto1}  TEST_NOTIF_MAN
    Click On Link  ${inst_notif_man}
    # L'action ne doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  Loiselle Roland | rloiselle@notif.fr | pétitionnaire principal
    Element Should Not Contain  css=div#sousform-instruction_notification_manuelle  dparfait@notnotif.fr
    Page Should Not Contain Element  css=select#annexes_documents
    # Sélection du demandeur et validation
    Select Checkbox  css=div#sousform-instruction_notification_manuelle input[type="checkbox"]
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification
    # Test de l'affichage des informations dans le tableau de suivi
    Element Should Not Contain  css=div#suivi_notification_jsontotab  dparfait@notnotif.fr
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  rloiselle@notif.fr
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_MAN
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé

    # Vérification de l'envoi du mail et de son contenu
    Verifier que le mail a bien été envoyé au destinataire  rloiselle@notif.fr
    Page Should Not Contain  dparfait@notnotif.fr
    # le mail ne doit pas contenir de lien car il n'y a pas de pièce
    Vérifier que le contenu du mail ne contiens pas  rloiselle@notif.fr  /web/notification.php?key=


Notification manuelle par mail d'une instruction avec lettretype sans signature requise
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=denom1
    ...  personne_morale_nom=Leclerc
    ...  personne_morale_prenom=Maurelle
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=denom2
    ...  personne_morale_nom=Jalbert
    ...  personne_morale_prenom=Matthieu
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=mjalbert@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification manuelle avec lettretype sans signature
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE
    # L'action doit être dans le portlet
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  denom2 représenté par Jalbert Matthieu | mjalbert@notif.fr | pétitionnaire
    Element Should Not Contain  css=div#sousform-instruction_notification_manuelle  Leclerc
    Page Should Not Contain Element  css=select#annexes_documents
    # Sélection du demandeur et validation
    Select Checkbox  css=div#sousform-instruction_notification_manuelle input[type="checkbox"]
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification
    # Test de l'affichage des informations dans le tableau de suivi
    Element Should Not Contain  css=div#suivi_notification_jsontotab  leclerc
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  mjalbert@notif.fr
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_MAN_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé

    # Vérifie que le mail a bien été envoyé
    Verifier que le mail a bien été envoyé au destinataire  mjalbert@notif.fr
    Page Should Not Contain  leclerc
    # le mail doit contenir le lien vers la pièce
    Vérifier le contenu du mail  mjalbert@notif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}


Notification manuelle par mail d'une instruction avec lettretype et signature requise
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Babin
    ...  particulier_prenom=Pauline
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=pbabin@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Chenard
    ...  particulier_prenom=Lance
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=lchenard@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique avec lettretype avec signature
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE
    # L'action ne doit être dans le portlet
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE
    Portlet Action Should Not Be In SubForm  instruction  overlay_notification_manuelle
    # Ajout d'une date de signature
    # Remplissage de la date de retour de signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  Chenard Lance | lchenard@notif.fr | pétitionnaire
    Element Should Contain  css=div#sousform-instruction_notification_manuelle  Babin Pauline | pbabin@notif.fr | pétitionnaire principal
    Page Should Not Contain Element  css=select#annexes_documents
    # Sélection du demandeur et validation
    Select Checkbox  css=div#sousform-instruction_notification_manuelle div.bloc:nth-child(1) > div:nth-child(2) input
    Select Checkbox  css=div#sousform-instruction_notification_manuelle div.bloc:nth-child(1) > div:nth-child(3) input
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification
    # Test de l'affichage des informations dans le tableau de suivi
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="émetteur"]      admin (Administrateur)
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=div#suivi_notification_jsontotab  lchenard@notif.fr
    Element Should Contain  css=div#suivi_notification_jsontotab  pbabin@notif.fr
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="instruction"]  TEST_NOTIF_MAN_SIGN_LETTRETYPE
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="statut"]       envoyé
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="commentaire"]  Le mail de notification a été envoyé

    # Vérifie que les mails ont bien été envoyés et qu'ils contiennent le lien vers la pièce
    Verifier que le mail a bien été envoyé au destinataire  lchenard@notif.fr
    Vérifier le contenu du mail  lchenard@notif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document

    Verifier que le mail a bien été envoyé au destinataire  pbabin@notif.fr
    Vérifier le contenu du mail  pbabin@notif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}


Notification manuelle par mail d'une instruction sans lettretype avec annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin
    # Ajout d'un dossier et d'une instruction de notification manuelle sans lettretype
    # avec une annexe
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Gadbois
    ...  particulier_prenom=Agnès
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=agadbois@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Houle
    ...  particulier_prenom=Fanchon
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=hfanchon@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # finalisation et ajout d'une date de retour signature sur une instruction
    # pour pouvoir la choisir comme annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout de l'instruction de notification
    Depuis la page d'accueil  mpaulet  mpaulet
    ${inst_notif_man_annexe} =  Ajouter une instruction au DI  ${di_notif_auto1}  TEST_NOTIF_MAN_ANNEXE
    Click On Link  ${inst_notif_man_annexe}
    # L'action ne doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Vérification de l'affichage du formulaire de notif manuelle :
    # les 2 pétitionnaires et le champs de sélection de l'annexe doivent être visible
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  Gadbois Agnès | agadbois@notif.fr | pétitionnaire principal
    Element Should Contain  css=div#sousform-instruction_notification_manuelle  Houle Fanchon | hfanchon@notif.fr | pétitionnaire 

    # Sélection d'un demandeur et validation
    Select Checkbox  xpath=//label[normalize-space(text()) = 'Houle Fanchon | hfanchon@notif.fr | pétitionnaire']//ancestor::div[contains(@class, 'field-type-checkbox')]//input[contains(@type, 'checkbox')]
    @{liste_documents}  Create List  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification
    # Test de l'affichage des informations dans le tableau de suivi
    
    Element Should Not Contain  css=div#suivi_notification_jsontotab  agadbois@notif.fr
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  hfanchon@notif.fr
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_MAN_ANNEXE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé

    # Vérifie que le mail a bien été envoyé et qu'il contiens un lien vers l'annexe
    Verifier que le mail a bien été envoyé au destinataire  hfanchon@notif.fr
    Vérifier le contenu du mail  hfanchon@notif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  RECEPISSE DE DEPOT
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_ANNEXE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}


Notification manuelle par mail d'une instruction avec lettretype avec annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin
    # Ajout d'un dossier et d'une instruction de notification manuelle sans lettretype
    # avec une annexe
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Létourneau
    ...  particulier_prenom=Jules
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=jletourneau@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Charpentier
    ...  particulier_prenom=Medoro
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=mcharpentier@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # finalisation et ajout d'une date de retour signature sur une instruction du di
    # pour pouvoir la choisir comme annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout de l'instruction et finalisation
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    # L'action doit être dans le portlet
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Vérification de l'affichage du formulaire de notif manuelle :
    # les 2 pétitionnaires et le champs de sélection de l'annexe doivent être visible
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  Létourneau Jules | jletourneau@notif.fr | pétitionnaire principal
    Element Should Contain  css=div#sousform-instruction_notification_manuelle  Charpentier Medoro | mcharpentier@notif.fr | pétitionnaire 
    
    # Sélection d'un demandeur et validation
    Select Checkbox  xpath=//label[normalize-space(text()) = 'Charpentier Medoro | mcharpentier@notif.fr | pétitionnaire']//ancestor::div[contains(@class, 'field-type-checkbox')]//input[contains(@type, 'checkbox')]
    @{liste_documents}  Create List  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification
    # Test de l'affichage des informations dans le tableau de suivi
    Element Should Not Contain  css=div#suivi_notification_jsontotab  jletourneau@notif.fr
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  mcharpentier@notif.fr
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé

    # Vérifie que le mail a bien été envoyé et qu'il contiens les liens vers la pièce et l'annexe
    Verifier que le mail a bien été envoyé au destinataire  mcharpentier@notif.fr
    Vérifier le contenu du mail  mcharpentier@notif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document
    # TNR : vérifie que le PDF ne contiens pas de HTML
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${PROJECT_URL}/web/notification.php?key=${key}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    # Vérifie le contenu de la première ligne du PDF pour s'assurer qu'il contiens bien
    # le début du PDF et pas du HTML
    ${result} =  Run  head -n 1 ${full_path_to_file} | grep "^%PDF"
    Should Contain  ${result}  %PDF
    # Vérifie le contenu de la dernière ligne du PDF pour s'assurer qu'il contiens bien
    # la fin du PDF et pas du HTML
    ${result} =  Run  tail -n 1 ${full_path_to_file} | grep "%%EOF"
    Should Contain  ${result}  %%EOF

    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    ${key}=  Get From List  ${keys}  1
    Verifier que le lien de notification contiens  ${key}  RECEPISSE DE DEPOT

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}


Notification manuelle par mail d'une instruction avec lettretype, signature requise et annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin
    # Ajout d'un dossier et d'une instruction de notification manuelle sans lettretype
    # avec une annexe
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=DeGrasse
    ...  particulier_prenom=Charlot
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=dcharlot@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Jetté
    ...  particulier_prenom=Edmee
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=jedmee@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # finalisation et ajout d'une date de retour signature sur une instruction du di
    # pour pouvoir la choisir comme annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout de l'instruction et finalisation
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE_ANNEXE
    # L'action ne doit être dans le portlet
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE_ANNEXE
    Portlet Action Should Not Be In SubForm  instruction  overlay_notification_manuelle
    # Ajout d'une date de signature
    # Remplissage de la date de retour de signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Vérification de l'affichage du formulaire de notif manuelle :
    # les 2 pétitionnaires et le champs de sélection de l'annexe doivent être visible
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  DeGrasse Charlot | dcharlot@notif.fr | pétitionnaire principal
    Element Should Contain  css=div#sousform-instruction_notification_manuelle  Jetté Edmee | jedmee@notif.fr | pétitionnaire
    
    # Sélection d'un demandeur et validation
    Select Checkbox  xpath=//label[normalize-space(text()) = 'Jetté Edmee | jedmee@notif.fr | pétitionnaire']//ancestor::div[contains(@class, 'field-type-checkbox')]//input[contains(@type, 'checkbox')]
    @{liste_documents}  Create List  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification
    # Test de l'affichage des informations dans le tableau de suivi
    
    Element Should Contain  css=td[data-column-id="émetteur"]      admin (Administrateur)
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  jedmee@notif.fr
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_MAN_SIGN_LETTRETYPE_ANNEXE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé

    # Vérifie que le mail a bien été envoyé et qu'il contiens les liens vers la pièce et l'annexe
    Verifier que le mail a bien été envoyé au destinataire  jedmee@notif.fr
    Vérifier le contenu du mail  jedmee@notif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    ${key}=  Get From List  ${keys}  1
    Verifier que le lien de notification contiens  ${key}  RECEPISSE DE DEPOT

    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE_ANNEXE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}


Notification avec annexes multiples par mail
    [Documentation]  Vérifie à l'ouverture du formulaire de notification que le
    ...  message d'information indique bien le nombre maximum d'annexes acceptées.
    ...  Vérifie que toutes les annexes sont bien transmises dans le mail de notification.
    ...  Vérifie que si l'utilisateur sélectionne plus d'annexes que le nombre d'annexe maximum, 
    ...  -> un message d'erreur s'affiche à la validation du formulaire et le formulaire est re-affiché.
    ...  Vérifie que si l'utilisateur n'a pas correctement saisi le paramètre 'parametre_notification_max_annexes',
    ...  -> le nombre d'annexe max par défaut est de 5.
    ...  Vérifie que si le paramètre 'parametre_notification_max_annexes' est correctement saisi,
    ...  -> sa valeur définira la valeur du nombre maximum d'annexes.

    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=DeGrasse
    ...  particulier_prenom=Charlot
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=dcharlot@notif.fr
    ...  notification=t
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_limit} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # finalisation et ajout d'une date de retour signature sur une instruction du di
    # pour pouvoir la choisir comme annexe
    Depuis la page d'accueil  admin  admin
    Depuis l'instruction du dossier d'instruction  ${di_notif_limit}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout de 5 pièces qui pourront être sélectionnées comme annexe
    @{liste_pieces}  Create List  autres pièces composant le dossier (A0)  arrêté retour préfecture  certificat conformité totale lotissement  avis obligatoires  dossier sécurité ERP
    @{title_piece_annexes}  Create List
    : FOR  ${piece}  IN  @{liste_pieces}
    \  &{document_numerise_values} =  Create Dictionary
    \  ...  uid_upload=testImportManuel.pdf
    \  ...  date_creation=10/09/2016
    \  ...  document_numerise_type=${piece}
    \  Ajouter une pièce depuis le dossier d'instruction  ${di_notif_limit}  ${document_numerise_values}
    # Récupère le nom du fichier et l'associe à celui de la pièce pour obtenir le titre de l'annexe
    \  Click On Back Button In SubForm
    \  ${nom_fichier} =  Get Text  xpath=//a[normalize-space(text()) = "${piece}"]//ancestor::tr/td[contains(@class, "firstcol")]/a/span[contains(@title, "Télécharger")]
    \  ${title_annexe} =  Catenate  ${nom_fichier}  -  ${piece}
    \  Append To List  ${title_piece_annexes}  ${title_annexe}
    # Supprime le dernier titre car la dernière pièce ne sera pas transmise lors de la notification
    Remove From List  ${title_piece_annexes}  3
    Remove From List  ${title_piece_annexes}  3

    # Ajout d'une consultation et rendu d'avis pour pouvoir la choisir comme annexe
    Ajouter une consultation depuis un dossier  ${di_notif_limit}  00.02 - ServiceNonNotifiable
    Depuis le contexte de la consultation  ${di_notif_limit}  00.02 - ServiceNonNotifiable
    &{piece_values} =  Create Dictionary
    ...  fichier_upload=testImportManuel2.pdf
    ...  date_demande=03/02/2016
    ...  avis_consultation=Tacite
    ${nom_piece} =  Ajouter une pièce à la consultation  ${piece_values}

    # Connexion en tant qu'instructeur du dossier
    # Ajout d'une instruction notifiable à laquelle on peut ajouter des annexes
    Ajouter une instruction au DI et la finaliser  ${di_notif_limit}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE

    # Accès au formulaire de notification manuelle et vérification du message d'info
    Depuis la page d'accueil  mpaulet  mpaulet
    Depuis l'instruction du dossier d'instruction  ${di_notif_limit}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale

    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y

    # Sélection du demandeur
    Select Checkbox  css=input[type="checkbox"]
    # Sélection de toutes les annexes possibles
    Select From Multiple Chosen List  annexes_pieces  ${liste_pieces}
    @{liste_documents}  Create List  Avis - ServiceNonNotifiable - ${CurrentDate}  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}

    ${param_option_annexe_default_value} =  Set Variable  5

    # Validation du formulaire et vérification du message d'erreur
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    Wait until keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL} 
    ...  Error Message Should Contain  Plus de ${param_option_annexe_default_value} annexes ont été sélectionnées vous devez en supprimer 2 pour que les pétitionnaires soient notifiés.

    # Déselection de certaines pièces pour n'en garder que 5
    @{liste_pieces_unselect}  Create List  avis obligatoires  dossier sécurité ERP
    Unselect From Multiple Chosen List  annexes_pieces  ${liste_pieces_unselect}    
    Click Element Until New Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]  css=.message.ui-state-valid
    Wait Until Element Contains 
    ...  css=.message.ui-state-valid 
    ...  La notification a été générée.\nLes pièces et documents suivants seront envoyés :\nTEST_NOTIF_MAN_LETTRETYPE_ANNEXE\ncertificat conformité totale lotissement\nautres pièces composant le dossier (A0)\narrêté retour préfecture\nAvis - ServiceNonNotifiable - ${CurrentDate}\nNotification du delai legal maison individuelle

    # Affichage de la liste des annexes dans le tableau de suivi
    Click Link  css=.ui-dialog-titlebar-close
    Wait Until Page Contains Element  css=td[data-column-id="annexes"]
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe\nAnnexe\nAnnexe\nAnnexe\nAnnexe

    # Affichage du nom de l'élement dans le tooltip. Pour ça on vérifie que l'élément contiens bien
    # un attribut title ayant le nom de la pièce
    # Récupération des attributs des annexes et stockage dans une liste
    # On vérifie également l'affichage de la page de téléchargement du document
    @{contenu_annexes}  Create List    TEST IMPORT MANUEL 1  TEST IMPORT MANUEL 1  TEST IMPORT MANUEL 1  TEST IMPORT MANUEL 2  RECEPISSE DE DEPOT
    @{liste_titre_annexes}  Create List
    : FOR  ${index}  IN RANGE  1  6
    \  ${tooltip} =  Get Element Attribute  css=td[data-column-id="annexes"] li:nth-child(${index}) a  title
    \  Append To List  ${liste_titre_annexes}  ${tooltip}
    \  Click Link  css=td[data-column-id="annexes"] li:nth-child(${index}) a
    # Récupération du contenu du document et vérification du contenu dans la page
    # de téléchargement
    \  ${index_contenu} =  Evaluate  ${index} - 1
    \  ${contenu} =  Get From List  ${contenu_annexes}  ${index_contenu}
    \  Select Window  NEW
    \  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${contenu}
    # Ferme la fenêtre de récupération du document et retourne sur l'application
    \  Close Window
    \  Select Window
    # Vérifie que les titres des documents existe bien dans la liste
    List Should Contain Sub List  ${liste_titre_annexes}  ${liste_documents}
    # Vérifie que les titres des pièces existent bien dans la liste
    List Should Contain Sub List  ${liste_titre_annexes}  ${title_piece_annexes}

    # Test de l'accès aux différents types de pièce et document
    Verifier que le mail a bien été envoyé au destinataire  dcharlot@notif.fr
    Vérifier le contenu du mail  dcharlot@notif.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document
    ${key}=  Get From List  ${keys}  1
    Verifier que le lien de notification contiens  ${key}  TEST IMPORT MANUEL 1
    ${key}=  Get From List  ${keys}  2
    Verifier que le lien de notification contiens  ${key}  TEST IMPORT MANUEL 1
    ${key}=  Get From List  ${keys}  3
    Verifier que le lien de notification contiens  ${key}  TEST IMPORT MANUEL 1
    ${key}=  Get From List  ${keys}  4
    Verifier que le lien de notification contiens  ${key}  TEST IMPORT MANUEL 2
    ${key}=  Get From List  ${keys}  5
    Verifier que le lien de notification contiens  ${key}  RECEPISSE DE DEPOT


    # Vérification du bon fonctionnement de l'option parametre_notification_max_annexes et de l'affichage des annexes
    Depuis la page d'accueil  admin  admin

    # Vérification de la bonne gestion du 'parametre_notification_max_annexes' 
    # sur le nombre d'annexe max sélectionnable, quand le paramètre à pour valeur :
    # => STRING
    # => EMPTY
    # => INT

    # Ajout paramètres nb annexe max (MAL RENSEIGNÉ) -> STRING
    &{param_option_annexe} =  Create Dictionary
    ...  libelle=parametre_notification_max_annexes
    ...  valeur=DocteurToto
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_annexe}
    # Vérifier que le nombre d'annexes que l'on peux ajouter est de 5 par défaut 
    Depuis l'instruction du dossier d'instruction  ${di_notif_limit}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  DeGrasse Charlot | dcharlot@notif.fr | pétitionnaire principal
    Page Should Contain  Si vous le souhaitez, vous pouvez ajouter jusqu'à ${param_option_annexe_default_value} annexes.

    # Ajout paramètres nb annexe max (MAL RENSEIGNÉ) -> EMPTY
    &{param_option_annexe} =  Create Dictionary
    ...  libelle=parametre_notification_max_annexes
    ...  valeur=' '
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_annexe}
    # Vérifier que le nombre d'annexes que l'on peux ajouter est de 5 par défaut 
    Depuis l'instruction du dossier d'instruction  ${di_notif_limit}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  DeGrasse Charlot | dcharlot@notif.fr | pétitionnaire principal
    Page Should Contain  Si vous le souhaitez, vous pouvez ajouter jusqu'à ${param_option_annexe_default_value} annexes.

    # Ajout paramètres nb annexe max (BIEN RENSEIGNÉ) -> 1
    &{param_option_annexe} =  Create Dictionary
    ...  libelle=parametre_notification_max_annexes
    ...  valeur=1
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_annexe}
    # Vérifier que le nombre d'annexes que l'on peux ajouter est bien de 10 
    Depuis l'instruction du dossier d'instruction  ${di_notif_limit}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  DeGrasse Charlot | dcharlot@notif.fr | pétitionnaire principal
    Page Should Contain  Si vous le souhaitez, vous pouvez ajouter jusqu'à ${param_option_annexe.valeur} annexes.

    # Ajouter plus d'annexes que la valeur d'annexes max prise en compte :
    # => génère une notice car la limite du nombre d'annexes est dépassé (valeur max -> 'parametre_notification_max_annexes')
    # On test ici l'ajout de 2 annexes alors que la limite est de 1
    # Sélection du demandeur
    Select Checkbox  css=input[type="checkbox"]
    # Sélection de toutes les annexes possibles
    @{liste_pieces_select}  Create List  autres pièces composant le dossier (A0)
    Select From Multiple Chosen List  annexes_pieces  ${liste_pieces_select}
    @{liste_documents}  Create List  Avis - ServiceNonNotifiable - ${CurrentDate}
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}
    Wait until keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    Wait until keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL} 
    ...  Error Message Should Contain  Plus de ${param_option_annexe.valeur} annexes ont été sélectionnées vous devez en supprimer 1 pour que les pétitionnaires soient notifiés.

    # Déselection de 1 annexe pour ne pas dépasser le nb max => 1
    @{liste_pieces_unselect}  Create List  autres pièces composant le dossier (A0)
    Unselect From Multiple Chosen List  annexes_pieces  ${liste_pieces_unselect}  
    Click Element Until New Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]  css=.message.ui-state-valid
    Wait until keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  La notification a été générée.
    Click Link  css=.ui-dialog-titlebar-close

    Depuis l'instruction du dossier d'instruction  ${di_notif_limit}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE

    # Vérifier que le traitement de l'ajout des annexes s'est bien effectué dans le suivi de notification
    Element Should Contain  css=div#suivi_notification_jsontotab                         dcharlot@notif.fr
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="émetteur"]      admin (Administrateur)
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="destinataire"]  dcharlot@notif.fr
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="instruction"]   TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Element Text Should Be  css=tbody tr:nth-child(2) td[data-column-id="annexes"]       Annexe
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="statut"]        envoyé
    Element Should Contain  css=tbody tr:nth-child(2) td[data-column-id="commentaire"]   Le mail de notification a été envoyé

    # Vérifier que les infos annexes (lors du survol) sont affiché au bon format :
    # => Avis – Libellé du service – date de retour d’avis
    Element Should Be Visible  css=tbody tr:nth-child(2) td[data-column-id="annexes"] a[title="Avis - ServiceNonNotifiable - ${CurrentDate}"]
    Click Element  css=#consultation
    Wait until keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-3 a.lienTable  ${CurrentDate}
    Wait until keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-5 a.lienTable  00.02 - ServiceNonNotifiable

    # En supprimant le paramètre, la valeur max du nombre d'annexe notifiable par défaut est à 5
    Supprimer le paramètre  parametre_notification_max_annexes


TNR Notification erronée manuelle via portal
    [Documentation]  Vérifie l'affichage des informations de refus
    ...  lors de la notification manuelle via portal,
    ...  alors que le pétitionnaire principal n'est pas notifiable

    # Ajout de l'option_notification avec la valeur PORTAL
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_notification
    ...  valeur=portal
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Nouveau dossier dont la notification par mail est décochée pour le pétitionnaire
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=TEST_NOM
    ...  particulier_prenom=TEST_PRENOM
    ...  om_collectivite=MARSEILLE
    ...  courriel=test@test.fr
    ...  notification=f
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  depot_electronique=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  

    # Evènement 'adjoint' modifié
    &{args_evenement} =  Create Dictionary
    ...  evenement=62
    ...  libelle=adjoint
    ...  notification=Notification manuelle avec annexe
    Modifier l'événement  ${args_evenement}

    # Ajout de l'instruction au DI
    Ajouter une instruction au DI et la finaliser  ${di}  adjoint

    Depuis l'instruction du dossier d'instruction  ${di}  adjoint
    # Click sur la Notification du pétitionnaire dans le Portlet Action
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale

    # Vérification de la première information délivrée
    Page Should Contain  Le demandeur principal ne peut pas être notifié : la notification se fait via PORTAL

    # Click sur le bouton 'Valider' conduisant à une fenêtre d'erreur
    Click On Submit Button In Subform

    # Vérification de la présence des messages d'erreur
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  Erreur lors de la génération de la notification.
    Wait until element contains  css=div#sousform-instruction_notification_manuelle  Le pétitionnaire principal doit avoir une adresse mail valide renseignée et accepter les notifications par mail.

Notification par mail des services consultés instruction sans lettretype et sans annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction dont les services peuvent être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Carrière
    ...  particulier_prenom=Élisabeth
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_SC1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout de l'instruction a notifier au service qui n'a pas de lettretype
    Depuis la page d'accueil  mpaulet  mpaulet
    ${inst_notif_sc_ss_lt1} =  Ajouter une instruction au DI  ${di_notif_SC1}  TEST_NOTIF_SC_SANS_LETTRETYPE
    Click On Link  ${inst_notif_sc_ss_lt1}
    # L'action doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_service_consulte

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_service_consulte  modale
    Wait until page Contains  ServiceNotifiable1
    Page Should Contain  ServiceNotifiable2
    Element Should Not Contain  css=#sousform-instruction_notification_manuelle .formEntete #form-content:nth-child(1)   ServiceNonNotifiable
    # Remplissage du formulaire et validation
    Select Checkbox  css=div#sousform-instruction_notification_manuelle div.bloc:nth-child(1) > div:nth-child(2) input
    Select Checkbox  css=div#sousform-instruction_notification_manuelle div.bloc:nth-child(1) > div:nth-child(3) input
    ${CurrentDate} =  Valider le formulaire de notification

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification-service 
    # Test de l'affichage des informations dans le tableau de suivi
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  ServiceNotifiable1
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_SC_SANS_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    
    # Vérification de l'envoi du mail et de son contenu
    Verifier que le mail a bien été envoyé au destinataire  notifiable1@ok.fr
    Verifier que le mail a bien été envoyé au destinataire  notifiable2@ok.fr
    Verifier que le mail a bien été envoyé au destinataire  notifiable3@ok.fr
    Verifier que le mail a bien été envoyé au destinataire  notifiable4@ok.fr
    # le mail ne doit pas contenir de lien car il n'y a pas de pièce
    Vérifier que le contenu du mail ne contiens pas  notifiable1@ok.fr  /web/notification.php?key=
    # Vérifie que le message affiché est bien celui paramétré
    Page Should Contain  Bonjour les services, veuillez prendre connaissance du(des) document(s) suivant(s)
    Unselect frame
    Vérifier le sujet du mail  notifiable1@ok.fr  [openADS] Notification pour les services concernant le dossier
    Vider la boite mail


Notification par mail des services consultés instruction avec lettretype et sans annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction dont les services peuvent être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Soucy
    ...  particulier_prenom=Galatee
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_SC2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout de l'instruction a notifier au service qui n'a pas de lettretype
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI et la finaliser  ${di_notif_SC2}  TEST_NOTIF_SC_AVEC_LETTRETYPE
    # L'action doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_service_consulte

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_service_consulte  modale
    Wait until page Contains  ServiceNotifiable1
    Page Should Contain  ServiceNotifiable2
    Element Should Not Contain  css=#sousform-instruction_notification_manuelle .formEntete #form-content:nth-child(1)  ServiceNonNotifiable
    # Remplissage du formulaire et validation
    Select Checkbox  css=div#sousform-instruction_notification_manuelle div.bloc:nth-child(1) > div:nth-child(2) input
    ${CurrentDate}=  Valider le formulaire de notification

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification-service 
    # Test de l'affichage des informations dans le tableau de suivi
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  ServiceNotifiable1
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_SC_AVEC_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    
    # Vérification de l'envoi du mail et de son contenu
    Verifier que le mail a bien été envoyé au destinataire  notifiable1@ok.fr
    Page Should Not Contain  notifiable2@ok.fr
    # Le mail doit contenir le lien vers le document de l'instruction
    Vérifier le contenu du mail  notifiable1@ok.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    # Vérifie que le message affiché est bien celui paramétré
    Page Should Contain  Bonjour les services, veuillez prendre connaissance du(des) document(s) suivant(s)
    Unselect frame
    Vérifier le sujet du mail  notifiable1@ok.fr  [openADS] Notification pour les services concernant le dossier
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC2}  TEST_NOTIF_SC_AVEC_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}
    Vider la boite mail


Notification par mail des services consultés instruction sans lettretype et avec annexes
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction dont les services peuvent être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Desnoyers
    ...  particulier_prenom=Ogier
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_SC3} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction finalisée et signé qui servira d'annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC3}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout d'un retour d'avis
    Ajouter une consultation depuis un dossier  ${di_notif_SC3}  00.02 - ServiceNonNotifiable
    Depuis le contexte de la consultation  ${di_notif_SC3}  00.02 - ServiceNonNotifiable
    &{piece_values} =  Create Dictionary
    ...  fichier_upload=testImportManuel.pdf
    ...  date_demande=03/02/2016
    ...  avis_consultation=Tacite
    ${nom_piece} =  Ajouter une pièce à la consultation  ${piece_values}

    # Ajout de l'instruction a notifier au service qui n'a pas de lettretype
    Depuis la page d'accueil  mpaulet  mpaulet
    ${inst_notif_sc_ss_lt3} =  Ajouter une instruction au DI  ${di_notif_SC3}  TEST_NOTIF_SC_SANS_LETTRETYPE
    Click On Link  ${inst_notif_sc_ss_lt3}
    # L'action doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_service_consulte

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_service_consulte  modale
    Wait until page Contains  ServiceNotifiable1
    Page Should Contain  ServiceNotifiable2
    Element Should Not Contain  css=#sousform-instruction_notification_manuelle .formEntete .bloc:nth-child(1)  ServiceNonNotifiable
    # Remplissage du formulaire et validation
    Select Checkbox  css=div#sousform-instruction_notification_manuelle div.bloc:nth-child(1) > div:nth-child(2) input
    @{annexes_a_selectionner} =  Create List  Avis - ServiceNonNotifiable  Notification du delai legal maison individuelle
    Select From Multiple Chosen List   annexes  ${annexes_a_selectionner}
    ${CurrentDate}=  Valider le formulaire de notification

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification-service 
    # Test de l'affichage des informations dans le tableau de suivi
    
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  ServiceNotifiable1
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_SC_SANS_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe\nAnnexe
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    
    # Vérification de l'envoi du mail et de son contenu
    Verifier que le mail a bien été envoyé au destinataire  notifiable1@ok.fr
    Page Should Not Contain  notifiable2@ok.fr
    # Le mail doit contenir le lien vers les annexes
    Vérifier le contenu du mail  notifiable1@ok.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    # Vérifie que le message affiché est bien celui paramétré
    Page Should Contain  Bonjour les services, veuillez prendre connaissance du(des) document(s) suivant(s)
    Unselect frame
    Vérifier le sujet du mail  notifiable1@ok.fr  [openADS] Notification pour les services concernant le dossier
    ${annexe1}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${annexe1}  RECEPISSE DE DEPOT
    ${annexe2}=  Get From List  ${keys}  1
    Verifier que le lien de notification contiens  ${annexe2}  TEST IMPORT MANUEL 1

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC3}  TEST_NOTIF_SC_SANS_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}
    Vider la boite mail


Notification par mail des services consultés instruction avec lettretype et avec annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction dont les services peuvent être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Lanoie
    ...  particulier_prenom=Hortense
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_SC4} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction finalisée et signé qui servira d'annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC4}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout d'un retour d'avis
    Ajouter une consultation depuis un dossier  ${di_notif_SC4}  00.02 - ServiceNonNotifiable
    Depuis le contexte de la consultation  ${di_notif_SC4}  00.02 - ServiceNonNotifiable
    &{piece_values} =  Create Dictionary
    ...  fichier_upload=testImportManuel.pdf
    ...  date_demande=03/02/2016
    ...  avis_consultation=Tacite
    ${nom_piece} =  Ajouter une pièce à la consultation  ${piece_values}

    # Ajout de l'instruction a notifier au service qui n'a pas de lettretype
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI et la finaliser  ${di_notif_SC4}  TEST_NOTIF_SC_AVEC_LETTRETYPE
    # L'action doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_service_consulte

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  overlay_notification_service_consulte  modale
    Wait until page Contains  ServiceNotifiable1
    Page Should Contain  ServiceNotifiable2
    Element Should Not Contain  css=#sousform-instruction_notification_manuelle .formEntete .bloc:nth-child(1)  ServiceNonNotifiable
    # Remplissage du formulaire et validation
    Select Checkbox  css=div#sousform-instruction_notification_manuelle div.bloc:nth-child(1) > div:nth-child(2) input
    @{annexes_a_selectionner} =  Create List  Avis - ServiceNonNotifiable  Notification du delai legal maison individuelle
    Select From Multiple Chosen List   annexes  ${annexes_a_selectionner}
    ${CurrentDate}=  Valider le formulaire de notification

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification-service 
    # Test de l'affichage des informations dans le tableau de suivi
    
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet
    Element Should Contain  css=td[data-column-id="dateD'envoi"]   ${CurrentDate}
    Element Should Contain  css=td[data-column-id="destinataire"]  ServiceNotifiable1
    Element Text Should Be  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_SC_AVEC_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe\nAnnexe
    Element Should Contain  css=td[data-column-id="statut"]       envoyé
    Element Should Contain  css=td[data-column-id="commentaire"]  Le mail de notification a été envoyé
    
    # Vérification de l'envoi du mail et de son contenu
    Verifier que le mail a bien été envoyé au destinataire  notifiable1@ok.fr
    Page Should Not Contain  notifiable2@ok.fr
    # Le mail doit contenir le lien vers le document et les annexes
    Vérifier le contenu du mail  notifiable1@ok.fr  /web/notification.php?key=
    ${keys} =  Recuperer les cles dans le mail de notification
    # Vérifie que le message affiché est bien celui paramétré
    Page Should Contain  Bonjour les services, veuillez prendre connaissance du(des) document(s) suivant(s)
    Unselect frame
    Vérifier le sujet du mail  notifiable1@ok.fr  [openADS] Notification pour les services concernant le dossier
    ${key}=  Get From List  ${keys}  0
    Verifier que le lien de notification contiens  ${key}  Ceci est un document
    ${annexe1}=  Get From List  ${keys}  1
    Verifier que le lien de notification contiens  ${annexe1}  RECEPISSE DE DEPOT
    ${annexe2}=  Get From List  ${keys}  2
    Verifier que le lien de notification contiens  ${annexe2}  TEST IMPORT MANUEL 1

    # Suivi de la date de 1er accès
    Depuis l'instruction du dossier d'instruction  ${di_notif_SC4}  TEST_NOTIF_SC_AVEC_LETTRETYPE
    Element Should Contain  css=td[data-column-id="dateDePremierAccès"]  ${CurrentDate}
    Vider la boite mail

Echec de la notification automatique par mail du demandeurs principal lié à un mauvais paramétrage
    [Documentation]  Test la notification en cas d'échec de la notification du demandeur
    ...  principale lié à un mauvais paramétrage (pas de mail, mail erroné ou n'accepte
    ...  pas les notifications).
    ...  Trois cas de notification automatique sont testés : à l'ajout de l'instruction,
    ...  à la finalisation de la lettretype et au remplissage de la date de retour de
    ...  signature.
    ...  En cas d'echec on vérifie qu'un message à destination de l'instructeur a bien été
    ...  envoyé, que le suivi de notification a bien une ligne indiquant que la notification
    ...  du demandeur principal à échoué et qu'un message d'information indiquant les
    ...  paramètre à corriger est bien affiché.

    Depuis la page d'accueil  admin  admin

    # 1er cas : notification automatique à l'ajout de l'instruction
    # Ajout d'un dossier pour lequel le demandeur principal n'accepte pas les notifications
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Fayme
    ...  particulier_prenom=Dastous
    ...  courriel=fdastous@test.fr
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_erreur} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction ce qui doit déclencher la création d'un message et l'apparition
    # du suivi de notification
    Depuis la page d'accueil  mpaulet  mpaulet
    ${inst_notif_auto} =  Ajouter une instruction au DI  ${di_notif_erreur}  TEST_NOTIF_AUTO
    Click On Link  ${inst_notif_auto}
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet) (automatique)
    Element Should Contain  css=td[data-column-id="destinataire"]  Fayme Dastous fdastous@test.fr
    Element Should Contain  css=td[data-column-id="instruction"]   TEST_NOTIF_AUTO
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]        Echec
    Element Should Contain  css=td[data-column-id="commentaire"]   Le pétitionnaire principal n'accepte pas les notifications.
    # Vérification qu'un message informant l'utilisateur des problèmes de paramétrages est affiché
    Depuis l'instruction du dossier d'instruction  ${di_notif_erreur}  TEST_NOTIF_AUTO
    Element Should Contain  css=.panel_information  La notification n'est pas possible.
    Click Element  css=#fieldset-message-tab_erreur_param_notif legend
    Wait until Element Is Visible  css=#fieldset-message-tab-content
    Element Should Contain  css=#fieldset-message-tab-content  Le pétitionnaire principal n'accepte pas les notifications.

    Depuis l'onglet des messages du dossier d'instruction  ${di_notif_erreur}
    Total Results In Subform Should Be Equal  1  dossier_message
    # Récupération de l'id du premier message pour accéder plus facilement au suivant
    Page should contain  erreur expedition
    ${id_message} =  Get Text  css=td.firstcol
    Depuis le contexte du message dans le dossier d'instruction  ${di_notif_erreur}  ${id_message}
    Element Should Contain  css=#type           erreur expedition
    Element Should Contain  css=#emetteur       mpaulet (Mandel Paulet)
    Element Should Contain  css=#destinataire   instructeur
    Element Should Contain  css=#lu             Non
    Element Should Contain  css=#contenu        Échec lors de la notification de l'instruction TEST_NOTIF_AUTO.\nLe pétitionnaire principal n'accepte pas les notifications.\nVeuillez corriger ces informations avant de renvoyer la notification.



    # 2ème cas : notification automatique à la finalisation du document d'instruction
    # Ajout d'un dossier pour lequel le demandeur principal n'a pas d'adresse mail
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Leala
    ...  particulier_prenom=Rocheleau
    ...  notification=t
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_erreur} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction ce qui doit déclencher la création d'un message et l'apparition
    # du suivi de notification
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI et la finaliser  ${di_notif_erreur}  TEST_NOTIF_AUTO_LETTRETYPE
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet) (automatique)
    Element Should Contain  css=td[data-column-id="destinataire"]  Leala Rocheleau
    Element Should Contain  css=td[data-column-id="instruction"]   TEST_NOTIF_AUTO_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]        Echec
    Element Should Contain  css=td[data-column-id="commentaire"]   Le courriel du pétitionnaire principal n'est pas renseigné.
    # Vérification qu'un message informant l'utilisateur des problèmes de paramétrages est affiché
    Depuis l'instruction du dossier d'instruction  ${di_notif_erreur}  TEST_NOTIF_AUTO_LETTRETYPE
    Element Should Contain  css=.panel_information  La notification n'est pas possible.
    Click Element  css=#fieldset-message-tab_erreur_param_notif legend
    Wait until Element Is Visible  css=#fieldset-message-tab-content
    Element Should Contain  css=#fieldset-message-tab-content  Le courriel du pétitionnaire principal n'est pas renseigné.

    Depuis l'onglet des messages du dossier d'instruction  ${di_notif_erreur}
    Total Results In Subform Should Be Equal  1  dossier_message
    # Récupération de l'id du premier message pour accéder plus facilement au suivant
    ${id_message2} =  Get Text  css=td.firstcol
    Depuis le contexte du message dans le dossier d'instruction  ${di_notif_erreur}  ${id_message2}
    Element Should Contain  css=#type           erreur expedition
    Element Should Contain  css=#emetteur       mpaulet (Mandel Paulet)
    Element Should Contain  css=#destinataire   instructeur
    Element Should Contain  css=#lu             Non
    Element Should Contain  css=#contenu        Échec lors de la notification de l'instruction TEST_NOTIF_AUTO_LETTRETYPE.\nLe courriel du pétitionnaire principal n'est pas renseigné.



    # 3ème cas : notification automatique après retour signature du document d'instruction
    # Ajout d'un dossier pour lequel le demandeur principal a une adresse mail incorrect
    # et pour lequel il y a 2 demandeurs
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Boileau
    ...  particulier_prenom=Daniel
    ...  courriel=bdaniel.oups
    ...  notification=t
    ...  om_collectivite=LIBRECOM_NOTIFDEM

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Grondin
    ...  particulier_prenom=Orson
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=ogrondin@notif.fr
    ...  notification=t
    ...  om_collectivite=LIBRECOM_NOTIFDEM

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_erreur} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout d'une instruction ce qui doit déclencher la création d'un message et l'apparition
    # du suivi de notification
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di_notif_erreur}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    # Remplissage de la date de retour de signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform
    # Vérification du suivi de la notification
    Element Should Contain  css=tr:nth-child(2) td[data-column-id="émetteur"]      admin (Administrateur)
    Element Should Contain  css=tr:nth-child(2) td[data-column-id="destinataire"]  Boileau Daniel bdaniel.oups
    Element Should Contain  css=tr:nth-child(2) td[data-column-id="instruction"]   TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Element Should Contain  css=tr:nth-child(2) td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=tr:nth-child(2) td[data-column-id="statut"]        Echec
    Element Should Contain  css=tr:nth-child(2) td[data-column-id="commentaire"]   Le courriel du pétitionnaire principal n'est pas correct : bdaniel.oups.
    Element Should Contain  css=tr:nth-child(1) td[data-column-id="émetteur"]      admin (Administrateur)
    Element Should Contain  css=tr:nth-child(1) td[data-column-id="destinataire"]  Grondin Orson ogrondin@notif.fr
    Element Should Contain  css=tr:nth-child(1) td[data-column-id="instruction"]   TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Element Should Contain  css=tr:nth-child(1) td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=tr:nth-child(1) td[data-column-id="statut"]        envoyé
    Element Should Contain  css=tr:nth-child(1) td[data-column-id="commentaire"]   Le mail de notification a été envoyé
    # Vérification qu'un message informant l'utilisateur des problèmes de paramétrages est affiché
    Depuis l'instruction du dossier d'instruction  ${di_notif_erreur}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Element Should Contain  css=.panel_information  La notification n'est pas possible.
    Click Element  css=#fieldset-message-tab_erreur_param_notif legend
    Wait until Element Is Visible  css=#fieldset-message-tab-content
    Element Should Contain  css=#fieldset-message-tab-content  Le courriel du pétitionnaire principal n'est pas correct : bdaniel.oups.

    Depuis l'onglet des messages du dossier d'instruction  ${di_notif_erreur}
    Total Results In Subform Should Be Equal  1  dossier_message
    # Récupération de l'id du premier message pour accéder plus facilement au suivant
    ${id_message3} =  Get Text  css=td.firstcol
    Depuis le contexte du message dans le dossier d'instruction  ${di_notif_erreur}  ${id_message3}
    Element Should Contain  css=#type           erreur expedition
    Element Should Contain  css=#emetteur       admin (Administrateur)
    Element Should Contain  css=#destinataire   instructeur
    Element Should Contain  css=#lu             Non
    Element Should Contain  css=#contenu        Le courriel du pétitionnaire principal n'est pas correct : bdaniel.oups.


Activation de la notification par le portail citoyen
    [Documentation]  Activation de la notification par le portail citoyen

    Depuis la page d'accueil  admin  admin

    # Modification du paramétrage de notification
    &{param_args} =  Create Dictionary
    ...  libelle=option_notification
    ...  valeur=portal
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu   ${param_args}
    
    Arrêter maildump


Notification automatique via le portail citoyen d'une instruction sans lettretype
    [Documentation]  Vérifie le bon fonctionnement de la notification automatique
    ...  via le portail citoyen des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=L'Heureux
    ...  particulier_prenom=Madeleine
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=mlheureux@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Charette
    ...  particulier_prenom=Suzette
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=scharette@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique sans lettretype
    # La notification doit se faire à l'ajout de l'instruction
    Depuis la page d'accueil  mpaulet  mpaulet
    ${inst_notif_auto1} =  Ajouter une instruction au DI  ${di_notif_auto1}  TEST_NOTIF_AUTO
    Click On Link  ${inst_notif_auto1}
    Element Should Contain  css=div#suivi_notification_jsontotab  mlheureux@notif.fr
    Element Should Contain  css=div#suivi_notification_jsontotab  en cours d'envoi
    Element Should Not Contain  css=div#suivi_notification_jsontotab  scharette@notif.fr
    Portlet Action Should Be In SubForm  instruction  notification_manuelle_portal

    # La tâche de notification de catégorie portal doit exister
    Depuis la page d'accueil  admin  admin
    ${di_notif_auto1_se} =  Sans espace  ${di_notif_auto1}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_auto1_se}
    ...  state=new
    ...  link_dossier=${di_notif_auto1_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

Notification automatique via le portail citoyen d'une instruction avec lettretype sans signature requise
    [Documentation]  Vérifie le bon fonctionnement de la notification automatique
    ...  via le portail citoyen des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Desjardins
    ...  particulier_prenom=Sargent
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=sdesjardins@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Boisclair
    ...  particulier_prenom=Rabican
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=rboisclair@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique sans la finaliser pour vérifier
    # que l'action d'envoi manuelle de la notification n'est pas visible
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI  ${di_notif_auto1}  TEST_NOTIF_AUTO_LETTRETYPE
    Portlet Action Should Not Be In SubForm  instruction  notification_manuelle_portal
    # Finalisation de l'instruction ce qui doit déclencher l'envoi de la notification automatique
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_AUTO_LETTRETYPE
    Click On SubForm Portlet Action  instruction  finaliser
    Element Should Contain  css=div#suivi_notification_jsontotab  sdesjardins@notif.fr
    Element Should Contain  css=div#suivi_notification_jsontotab  en cours d'envoi
    Element Should Not Contain  css=div#suivi_notification_jsontotab  rboisclair@notif.fr
    Portlet Action Should Be In SubForm  instruction  notification_manuelle_portal

    # La tâche de notification de catégorie portal doit exister
    Depuis la page d'accueil  admin  admin
    ${di_notif_auto1_se} =  Sans espace  ${di_notif_auto1}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_auto1_se}
    ...  state=new
    ...  link_dossier=${di_notif_auto1_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

Notification automatique via le portail citoyen d'une instruction avec lettretype et avec retour signature
    [Documentation]  Vérifie le bon fonctionnement de la notification automatique
    ...  via le portail citoyen des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Denomination
    ...  personne_morale_nom=Tabor
    ...  personne_morale_prenom=Phaneuf
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=tphaneuf@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_raison_sociale=raison sociale
    ...  personne_morale_nom=Labrosse
    ...  personne_morale_prenom=Patrick
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=plabosse@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique avec lettretype avec signature
    # La notification doit se faire à l'ajout de la date de retour
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Portlet Action Should Not Be In SubForm  instruction  notification_manuelle_portal
    Page Should Not Contain Element  css=fieldset#fieldset-sousform-instruction-suivi-notification
    # Remplissage de la date de retour de signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform
    # Vérification des infos
    Element Should Contain  css=div#suivi_notification_jsontotab  tphaneuf@notif.fr
    Element Should Contain  css=div#suivi_notification_jsontotab  en cours d'envoi
    Element Should Not Contain  css=div#suivi_notification_jsontotab  plabosse@notif.fr
    Portlet Action Should Be In SubForm  instruction  notification_manuelle_portal

    # La tâche de notification de catégorie portal doit exister
    Depuis la page d'accueil  admin  admin
    ${di_notif_auto1_se} =  Sans espace  ${di_notif_auto1}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_auto1_se}
    ...  state=new
    ...  link_dossier=${di_notif_auto1_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

Notification manuelle via le portail citoyen d'une instruction sans lettretype
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  via le portail citoyen des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Chandonnet
    ...  particulier_prenom=Honoré
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=hchandonnet@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Dufresne
    ...  particulier_prenom=Villette
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=vdufresne@notnotif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique sans lettretype
    Depuis la page d'accueil  mpaulet  mpaulet
    ${inst_notif_man} =  Ajouter une instruction au DI  ${di_notif_auto1}  TEST_NOTIF_MAN
    CLick On Link  ${inst_notif_man}
    # L'action ne doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  notification_manuelle_portal

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  notification_manuelle_portal  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Element Should Contain  css=div#suivi_notification_jsontotab  hchandonnet@notif.fr
    Element Should Contain  css=div#suivi_notification_jsontotab  en cours d'envoi
    Element Should Not Contain  css=div#suivi_notification_jsontotab  vdufresne@notnotif.fr

    Depuis la page d'accueil  admin  admin
    ${di_notif_auto1_se} =  Sans espace  ${di_notif_auto1}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_auto1_se}
    ...  state=new
    ...  link_dossier=${di_notif_auto1_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

Notification manuelle via le portail citoyen d'une instruction avec lettretype sans signature requise
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  via le portail citoyen des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=denom1
    ...  personne_morale_nom=Lapierre
    ...  personne_morale_prenom=Ormazd
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=olapierre@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=denom2
    ...  personne_morale_nom=Poisson
    ...  personne_morale_prenom=Warrane
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=pwarrane@notnotif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification manuelle avec lettretype sans signature
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE
    # L'action doit être dans le portlet
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE
    Portlet Action Should Be In SubForm  instruction  notification_manuelle_portal

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  notification_manuelle_portal  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Element Should Contain  css=div#suivi_notification_jsontotab  olapierre@notif.fr
    Element Should Contain  css=div#suivi_notification_jsontotab  en cours d'envoi
    Element Should Not Contain  css=div#suivi_notification_jsontotab  pwarrane@notnotif.fr

    Depuis la page d'accueil  admin  admin
    ${di_notif_auto1_se} =  Sans espace  ${di_notif_auto1}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_auto1_se}
    ...  state=new
    ...  link_dossier=${di_notif_auto1_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

Notification manuelle via le portail citoyen d'une instruction avec lettretype et signature requise
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  via le portail citoyen des demandeurs

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    # Seul le pétitionnaire principal a un courriel et accepte les notification
    # c'est donc le seul pétitionnaire qui devra être notifié
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Doucet
    ...  particulier_prenom=Merle
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=mdoucet@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Riel
    ...  particulier_prenom=Chappell
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=criel@notnotif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Ajout de l'instruction de notification automatique avec lettretype avec signature
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE
    # L'action ne doit être dans le portlet
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE
    Portlet Action Should Not Be In SubForm  instruction  notification_manuelle_portal
    # Ajout d'une date de signature
    # Remplissage de la date de retour de signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform
    Portlet Action Should Be In SubForm  instruction  notification_manuelle_portal

    # Utilisation de l'action
    Click On SubForm Portlet Action  instruction  notification_manuelle_portal  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Element Should Contain  css=div#suivi_notification_jsontotab  mdoucet@notif.fr
    Element Should Contain  css=div#suivi_notification_jsontotab  en cours d'envoi
    Element Should Not Contain  css=div#suivi_notification_jsontotab  criel@notnotif.fr

    Depuis la page d'accueil  admin  admin
    ${di_notif_auto1_se} =  Sans espace  ${di_notif_auto1}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_auto1_se}
    ...  state=new
    ...  link_dossier=${di_notif_auto1_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

Notification manuelle via le portail citoyen d'une instruction sans lettretype avec annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin
    # Ajout d'un dossier et d'une instruction de notification manuelle sans lettretype
    # avec une annexe
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Lang
    ...  particulier_prenom=Roxanne
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=rlang@notif.fr
    ...  notification=t

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # finalisation et ajout d'une date de retour signature sur une instruction
    # pour pouvoir la choisir comme annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout de l'instruction de notification
    Depuis la page d'accueil  mpaulet  mpaulet
    ${inst_notif_man_annexe} =  Ajouter une instruction au DI  ${di_notif_auto1}  TEST_NOTIF_MAN_ANNEXE
    Click On Link  ${inst_notif_man_annexe}
    # L'action ne doit être dans le portlet
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Vérification de l'affichage du formulaire de notif manuelle
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    # Sélection d'une annexe et validation
    Page Should Not Contain Element  css=div#instruction_notification_manuelle input[type="checkbox"]
    @{liste_documents}  Create List  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification
    # Test de l'affichage des informations dans le tableau de suivi
    
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet)
    Element Text Should Be  css=td[data-column-id="dateD'envoi"]   ${EMPTY}
    Element Should Contain  css=td[data-column-id="destinataire"]  rlang@notif.fr
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_MAN_ANNEXE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe
    Element Should Contain  css=td[data-column-id="statut"]       en cours d'envoi
    Element Should Contain  css=td[data-column-id="commentaire"]  Notification en cours de traitement
    Page Should Not Contain Element  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}

    Depuis la page d'accueil  admin  admin
    ${di_notif_auto1_se} =  Sans espace  ${di_notif_auto1}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_auto1_se}
    ...  state=new
    ...  link_dossier=${di_notif_auto1_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

Notification manuelle via le portail citoyen d'une instruction avec lettretype avec annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin
    # Ajout d'un dossier et d'une instruction de notification manuelle sans lettretype
    # avec une annexe
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Chartré
    ...  particulier_prenom=Arnaud
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=achartre@notif.fr
    ...  notification=t

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # finalisation et ajout d'une date de retour signature sur une instruction du di
    # pour pouvoir la choisir comme annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout de l'instruction et finalisation
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    # L'action doit être dans le portlet
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Vérification de l'affichage du formulaire de notif manuelle avec annexe
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait Until Page Contains Element  css=div#annexes_documents_chosen
    # Sélection d'une annexe et validation
    Page Should Not Contain Element  css=div#instruction_notification_manuelle input[type="checkbox"]
    @{liste_documents}  Create List  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification
    # Test de l'affichage des informations dans le tableau de suivi
    
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet)
    Element Text Should Be  css=td[data-column-id="dateD'envoi"]   ${EMPTY}
    Element Should Contain  css=td[data-column-id="destinataire"]  achartre@notif.fr
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe
    Element Should Contain  css=td[data-column-id="statut"]       en cours d'envoi
    Element Should Contain  css=td[data-column-id="commentaire"]  Notification en cours de traitement
    Page Should Not Contain Element  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}

    Depuis la page d'accueil  admin  admin
    ${di_notif_auto1_se} =  Sans espace  ${di_notif_auto1}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_auto1_se}
    ...  state=new
    ...  link_dossier=${di_notif_auto1_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

Notification manuelle via le portail citoyen d'une instruction avec lettretype, signature requise et annexe
    [Documentation]  Vérifie le bon fonctionnement de la notification manuelle
    ...  par mail des demandeurs

    Depuis la page d'accueil  admin  admin
    # Ajout d'un dossier et d'une instruction de notification manuelle sans lettretype
    # avec une annexe
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Rochefort
    ...  particulier_prenom=Algernon
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=arochefort@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Landry
    ...  particulier_prenom=Logistilla
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=llandry@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # finalisation et ajout d'une date de retour signature sur une instruction du di
    # pour pouvoir la choisir comme annexe
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout de l'instruction et finalisation
    Ajouter une instruction au DI et la finaliser  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE_ANNEXE
    # L'action ne doit être dans le portlet
    Depuis l'instruction du dossier d'instruction  ${di_notif_auto1}  TEST_NOTIF_MAN_SIGN_LETTRETYPE_ANNEXE
    Portlet Action Should Not Be In SubForm  instruction  overlay_notification_manuelle
    # Ajout d'une date de signature
    # Remplissage de la date de retour de signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle

    # Vérification de l'affichage du formulaire de notif manuelle :
    # les 2 pétitionnaires et le champs de sélection de l'annexe doivent être visible
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    # Sélection d'un demandeur et validation
    Wait Until Page Contains Element  css=div#annexes_documents_chosen
    Page Should Not Contain Element  css=div#instruction_notification_manuelle input[type="checkbox"]
    @{liste_documents}  Create List  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    Wait Until Page Contains  La notification a été générée.

    # Vérifie que la page s'est bien mis à jour lors de la validation
    Wait Until Page Contains Element  css=#fieldset-sousform-instruction-suivi-notification
    # Test de l'affichage des informations dans le tableau de suivi
    
    Element Should Contain  css=td[data-column-id="émetteur"]      admin (Administrateur)
    Element Text Should Be  css=td[data-column-id="dateD'envoi"]   ${EMPTY}
    Element Should Contain  css=td[data-column-id="destinataire"]  arochefort@notif.fr
    Element Should Contain  css=td[data-column-id="instruction"]  TEST_NOTIF_MAN_SIGN_LETTRETYPE_ANNEXE
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe
    Element Should Contain  css=td[data-column-id="statut"]       en cours d'envoi
    Element Should Contain  css=td[data-column-id="commentaire"]  Notification en cours de traitement
    Page Should Not Contain Element  css=td[data-column-id="dateDePremierAccès"]  ${EMPTY}

    Depuis la page d'accueil  admin  admin
    ${di_notif_auto1_se} =  Sans espace  ${di_notif_auto1}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_auto1_se}
    ...  state=new
    ...  link_dossier=${di_notif_auto1_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

Suppression d'une instruction liée à une notification via le portail citoyen
    [Documentation]  Vérifie le comportement suite à la suppression d'instruction ayant
    ...  été notifiée

    Depuis la page d'accueil  admin  admin

    # Ajout d'un dossier et d'une instruction de notification auto
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Dupuis
    ...  particulier_prenom=Varden
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=vdupuis@notif.fr
    ...  notification=t
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_del} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}
    ${di_notif_del_se} =  Sans espace  ${di_notif_del}

    # Ajout de l'instruction de notification automatique sans lettretype
    # La notification doit se faire à l'ajout de l'instruction
    ${inst_notif_auto2} =  Ajouter une instruction au DI  ${di_notif_del}  TEST_NOTIF_AUTO
    Click On Link  ${inst_notif_auto2}
    Element Should Contain  css=div#suivi_notification_jsontotab  vdupuis@notif.fr
    Element Should Contain  css=div#suivi_notification_jsontotab  en cours d'envoi
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_del_se}
    ...  state=new
    ...  link_dossier=${di_notif_del_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

    # Suppression de l'instruction
    Supprimer l'instruction  ${di_notif_del}  TEST_NOTIF_AUTO
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_del_se}
    ...  state=canceled
    ...  link_dossier=${di_notif_del_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal


Suppression d'un dossier d'instruction ayant son récépissé notifié
    [Documentation]  Vérifie le comportement suite à la suppression d'un dossier
    ...  d'instruction ayant son récépissé notifié

    Depuis la page d'accueil  admin  admin

    # Active l'option de suppression des dossiers
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Modifie l'événement de récépissé
    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  notification=Notification automatique
    Modifier l'événement  ${args_evenement}

    # Ajout d'un dossier et d'une instruction de notification auto
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Patry
    ...  particulier_prenom=Robert
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=rpatry@notif.fr
    ...  notification=t
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_del} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}
    ${di_del_se} =  Sans espace  ${di_del}

    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_recepisse
    ...  dossier=${di_del_se}
    ...  state=new
    ...  link_dossier=${di_del_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

    # Supprime le dossier d'instruction
    Supprimer le dossier d'instruction  ${di_del}

    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_recepisse
    ...  dossier=${di_del_se}
    ...  state=canceled
    ...  link_dossier=${di_del_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

    # Suppression des paramètres
    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  notification=Pas de notification
    Modifier l'événement  ${args_evenement}
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}


Gestion des erreurs de paramétrage pour les dossiers notifiés via le portail citoyen
    [Documentation]  Ce test vérifie que si le dossier a été déposé via le portail citoyen
    ...  alors, même si le paramétrage du pétitionnaire principal n'est pas correct, le
    ...  message d'information pour la correction ne sera pas affiché sur l'instruction.
    ...  Vérifie également que les problèmes de notification n'empêche pas le déclenchement
    ...  de la notification et qu'il n'y a pas d'alert envoyé en cas de problème de paramétrage.
    ...  Pour les dossiers non déposés via le portail citoyen vérifie que les erreurs de
    ...  paramétrage du demandeur principal ne déclenche pas de notification et de message
    ...  indiquant une erreur de paramétrage.

    # 1er cas : notification automatique à l'ajout de l'instruction
    # Ajout d'un dossier pour lequel le demandeur principal n'accepte pas les notifications
    # et n'a pas d'adresse mail
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Quessy
    ...  particulier_prenom=Apolline
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ...  source_depot=portal
    ${di_notif_erreur} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction le message d'information concernant les erreurs de paramétrage
    # ne dois pas être affiché et l'instructeur ne doit pas recevoir de message
    # La notification doit être créé
    Depuis la page d'accueil  mpaulet  mpaulet
    ${inst_notif_auto3} =  Ajouter une instruction au DI  ${di_notif_erreur}  TEST_NOTIF_AUTO
    Click On Link  ${inst_notif_auto3}
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet) (automatique)
    Element Should Contain  css=td[data-column-id="destinataire"]  Quessy Apolline
    Element Should Contain  css=td[data-column-id="instruction"]   TEST_NOTIF_AUTO
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]        en cours d'envoi
    Element Should Contain  css=td[data-column-id="commentaire"]   Notification en cours de traitement

    Depuis l'instruction du dossier d'instruction  ${di_notif_erreur}  TEST_NOTIF_AUTO
    Page Should Not Contain  La notification n'est pas possible.

    Depuis l'onglet des messages du dossier d'instruction  ${di_notif_erreur}
    Total Results In Subform Should Be Equal  0  dossier_message

    # Cas 2 : notification automatique à l'ajout de l'instruction pour un dossier qui n'a pas été
    # déposé via portal.
    # Ajout d'un dossier pour lequel le demandeur principal n'accepte pas les notifications
    # et n'a pas d'adresse mail.
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Déziel
    ...  particulier_prenom=Agathe
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ...  source_depot=app
    ${di_notif_erreur} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction, il ne doit pas y avoir de notification ni d'alerte.
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI  ${di_notif_erreur}  TEST_NOTIF_AUTO

    Depuis l'instruction du dossier d'instruction  ${di_notif_erreur}  TEST_NOTIF_AUTO
    Page Should Not Contain Element  css=div#suivi_notification_jsontotab
    Page Should Contain  La notification n'est pas possible.

    Depuis l'onglet des messages du dossier d'instruction  ${di_notif_erreur}
    Total Results In Subform Should Be Equal  0  dossier_message

    # Cas 3 : notification automatique à la finalisation du document d'instruction
    # Ajout d'un dossier pour lequel le demandeur principal n'accepte pas les notifications
    # et n'a pas d'adresse mail
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Aymon
    ...  particulier_prenom=Cailot
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ...  source_depot=portal
    ${di_notif_erreur} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction le message d'information concernant les erreurs de paramétrage
    # ne dois pas être affiché et l'instructeur ne doit pas recevoir de message
    # La notification doit être créé
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI et la finaliser  ${di_notif_erreur}  TEST_NOTIF_AUTO_LETTRETYPE
    Element Should Contain  css=td[data-column-id="émetteur"]      mpaulet (Mandel Paulet) (automatique)
    Element Should Contain  css=td[data-column-id="destinataire"]  Aymon Cailot
    Element Should Contain  css=td[data-column-id="instruction"]   TEST_NOTIF_AUTO_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]        en cours d'envoi
    Element Should Contain  css=td[data-column-id="commentaire"]   Notification en cours de traitement

    Depuis l'instruction du dossier d'instruction  ${di_notif_erreur}  TEST_NOTIF_AUTO_LETTRETYPE
    Page Should Not Contain  La notification n'est pas possible.

    Depuis l'onglet des messages du dossier d'instruction  ${di_notif_erreur}
    Total Results In Subform Should Be Equal  0  dossier_message

    # Cas 4 : notification automatique à la finalisation du document d'instruction pour un dossier
    # qui n'a pas été déposé via portal.
    # Ajout d'un dossier pour lequel le demandeur principal n'accepte pas les notifications
    # et n'a pas d'adresse mail. Il ne doit pas y avoir de notification en erreur ni de message
    # d'alerte
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Dupuis
    ...  particulier_prenom=Dielle
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ...  source_depot=app
    ${di_notif_erreur} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction, la notification ne doit pas être ajouté et il ne doit pas y avoir d'alerte
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI et la finaliser  ${di_notif_erreur}  TEST_NOTIF_AUTO_LETTRETYPE

    Depuis l'instruction du dossier d'instruction  ${di_notif_erreur}  TEST_NOTIF_AUTO_LETTRETYPE
    Page Should Not Contain Element  css=div#suivi_notification_jsontotab
    Page Should Contain  La notification n'est pas possible.

    Depuis l'onglet des messages du dossier d'instruction  ${di_notif_erreur}
    Total Results In Subform Should Be Equal  0  dossier_message


    # Cas 5 : notification automatique après retour signature.
    # Ajout d'un dossier pour lequel le demandeur principal n'accepte pas les notifications
    # et n'a pas d'adresse mail
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Lang
    ...  particulier_prenom=Grégoire
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ...  source_depot=portal
    ${di_notif_erreur} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction le message d'information concernant les erreurs de paramétrage
    # ne dois pas être affiché et l'instructeur ne doit pas recevoir de message
    # La notification doit être créé
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di_notif_erreur}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    # Remplissage de la date de retour de signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform
    # Vérification du suivi de la notification
    Element Should Contain  css=td[data-column-id="émetteur"]      admin (Administrateur)
    Element Should Contain  css=td[data-column-id="destinataire"]  Lang Grégoire
    Element Should Contain  css=td[data-column-id="instruction"]   TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Element Text Should Be  css=td[data-column-id="annexes"]  ${EMPTY}
    Element Should Contain  css=td[data-column-id="statut"]        en cours d'envoi
    Element Should Contain  css=td[data-column-id="commentaire"]   Notification en cours de traitement

    Depuis l'instruction du dossier d'instruction  ${di_notif_erreur}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Page Should Not Contain  La notification n'est pas possible.

    Depuis l'onglet des messages du dossier d'instruction  ${di_notif_erreur}
    Total Results In Subform Should Be Equal  0  dossier_message

    # Cas 6 : notification automatique après retour signature pour un dossier
    # qui n'a pas été déposé via portal.
    # Ajout d'un dossier pour lequel le demandeur principal n'accepte pas les notifications
    # et n'a pas d'adresse mail
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Duval
    ...  particulier_prenom=Arnaud
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ...  source_depot=app
    ${di_notif_erreur} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # Ajout d'une instruction, la notification ne doit pas être ajouté et il ne doit pas y avoir d'alerte
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di_notif_erreur}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    # Remplissage de la date de retour de signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform
    Page Should Contain  La notification n'est pas possible.

    Depuis l'instruction du dossier d'instruction  ${di_notif_erreur}  TEST_NOTIF_AUTO_SIGN_LETTRETYPE
    Page Should Not Contain Element  css=div#suivi_notification_jsontotab
    Page Should Contain  La notification n'est pas possible.

    Depuis l'onglet des messages du dossier d'instruction  ${di_notif_erreur}
    Total Results In Subform Should Be Equal  0  dossier_message


Notification avec annexes multiples via le portail citoyen
    [Documentation]  Vérifie à l'ouverture du formulaire de notification que le
    ...  message d'information indique bien le nombre maximum d'annexes acceptées (5 par défaut).
    ...  Vérifie que si l'utilisateur sélectionne plus de 5 annexes un message
    ...  d'erreur s'affiche à la validation du formulaire et le formulaire est
    ...  re-affiché.
    ...  Vérifie également que dans le tableau de suivi des notifications la date de
    ...  premier accès n'est pas présente.
    ...  Vérifie également le bon fonctionnement de la limite maximum d'annexe (parametre_notification_max_annexes) 
    ...  notifiable au pétitionnaire via le portail citoyen

    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=TEST
    ...  particulier_prenom=PORTAL_ANNEXE_MULT
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=dcharlot@notif.fr
    ...  notification=t
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di_notif_annexe_mult} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}

    # finalisation et ajout d'une date de retour signature sur une instruction du di
    # pour pouvoir la choisir comme annexe
    Depuis la page d'accueil  admin  admin
    Depuis l'instruction du dossier d'instruction  ${di_notif_annexe_mult}  Notification du delai legal maison individuelle
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform

    # Ajout de 4 pièces qui pourront être sélectionnées comme annexe
    @{liste_pieces}  Create List  autres pièces composant le dossier (A0)  arrêté retour préfecture  certificat conformité totale lotissement  avis obligatoires
    @{title_piece_annexes}  Create List
    : FOR  ${piece}  IN  @{liste_pieces}
    \  &{document_numerise_values} =  Create Dictionary
    \  ...  uid_upload=testImportManuel.pdf
    \  ...  date_creation=10/09/2016
    \  ...  document_numerise_type=${piece}
    \  Ajouter une pièce depuis le dossier d'instruction  ${di_notif_annexe_mult}  ${document_numerise_values}
    # Récupère le nom du fichier et l'associe à celui de la pièce pour obtenir le titre de l'annexe
    \  Click On Back Button In SubForm
    \  ${nom_fichier} =  Get Text  xpath=//a[normalize-space(text()) = "${piece}"]//ancestor::tr/td[contains(@class, "firstcol")]/a/span[contains(@title, "Télécharger")]
    \  ${title_annexe} =  Catenate  ${nom_fichier}  -  ${piece}
    \  Append To List  ${title_piece_annexes}  ${title_annexe}
    # Supprime le dernier titre car la dernière pièce ne sera pas transmise lors de la notification
    Remove From List  ${title_piece_annexes}  3

    # Ajout d'une consultation et rendu d'avis pour pouvoir la choisir comme annexe
    Ajouter une consultation depuis un dossier  ${di_notif_annexe_mult}  00.02 - ServiceNonNotifiable
    Depuis le contexte de la consultation  ${di_notif_annexe_mult}  00.02 - ServiceNonNotifiable
    &{piece_values} =  Create Dictionary
    ...  fichier_upload=testImportManuel2.pdf
    ...  date_demande=03/02/2016
    ...  avis_consultation=Tacite
    ${nom_piece} =  Ajouter une pièce à la consultation  ${piece_values}

    # Connexion en tant qu'instructeur du dossier
    # Ajout d'une instruction notifiable à laquelle on peut ajouter des annexes
    Ajouter une instruction au DI et la finaliser  ${di_notif_annexe_mult}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE

    # Accès au formulaire de notification manuelle et vérification du message d'info
    Depuis la page d'accueil  mpaulet  mpaulet
    Depuis l'instruction du dossier d'instruction  ${di_notif_annexe_mult}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale

    ${yyyy} =  Get Time  year
    ${mm} =  Get Time  month
    ${dd} =  Get Time  day
    ${CurrentDate} =  Catenate  SEPARATOR=/  ${dd}  ${mm}  ${yyyy}

    # Sélection de toutes les annexes possibles
    Select From Multiple Chosen List  annexes_pieces  ${liste_pieces}
    @{liste_documents}  Create List  Avis - ServiceNonNotifiable - ${CurrentDate}  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}

    # Validation du formulaire et vérification du message d'erreur
    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    Wait until keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL} 
    ...  Error Message Should Contain  Plus de 5 annexes ont été sélectionnées vous devez en supprimer 1 pour que les pétitionnaires soient notifiés.

    # Vérification du bon fonctionnement de la limite du nombre d'annexe max notifiable au pétitionnaire (portal)
    Depuis la page d'accueil  admin  admin

    # Ajout paramètres nb annexe max (BIEN RENSEIGNÉ) -> 6
    &{param_option_annexe} =  Create Dictionary
    ...  libelle=parametre_notification_max_annexes
    ...  valeur=6
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_annexe}

    Depuis la page d'accueil  mpaulet  mpaulet
    Depuis l'instruction du dossier d'instruction  ${di_notif_annexe_mult}  TEST_NOTIF_MAN_LETTRETYPE_ANNEXE
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale

    # Sélection de toutes les annexes possibles
    Select From Multiple Chosen List  annexes_pieces  ${liste_pieces}
    @{liste_documents}  Create List  Avis - ServiceNonNotifiable - ${CurrentDate}  Notification du delai legal maison individuelle
    Select From Multiple Chosen List  annexes_documents  ${liste_documents}

    Wait until keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL} 
    ...  Page Should Contain  Si vous le souhaitez, vous pouvez ajouter jusqu'à 6 annexes.

    Click Element  css=div#sousform-instruction_notification_manuelle input[type="submit"]
    Wait Until Element Contains 
    ...  css=.message.ui-state-valid 
    ...  La notification a été générée.\nLes pièces et documents suivants seront envoyés :\nTEST_NOTIF_MAN_LETTRETYPE_ANNEXE\ncertificat conformité totale lotissement\nautres pièces composant le dossier (A0)\narrêté retour préfecture\navis obligatoires\nAvis - ServiceNonNotifiable - ${CurrentDate}\nNotification du delai legal maison individuelle

    # Affichage de la liste des annexes dans le tableau de suivi
    Click Link  css=.ui-dialog-titlebar-close
    Wait Until Page Contains Element  css=td[data-column-id="annexes"]
    Element Text Should Be  css=td[data-column-id="annexes"]  Annexe\nAnnexe\nAnnexe\nAnnexe\nAnnexe\nAnnexe

    # Affichage du nom de l'élement dans le tooltip. Pour ça on vérifie que l'élément contiens bien
    # un attribut title ayant le nom de la pièce
    # Récupération des attributs des annexes et stockage dans une liste
    # On vérifie également l'affichage de la page de téléchargement du document
    @{liste_titre_annexes}  Create List
    : FOR  ${index}  IN RANGE  1  7
    \  ${tooltip} =  Get Element Attribute  css=td[data-column-id="annexes"] li:nth-child(${index}) a  title
    \  Append To List  ${liste_titre_annexes}  ${tooltip}
    \  Click Link  css=td[data-column-id="annexes"] li:nth-child(${index}) a
    # Vérifie que le PDF s'affiche bien
    \  Select Window  NEW
    \  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST
    # Ferme la fenêtre de récupération du document et retourne sur l'application
    \  Close Window
    \  Select Window
    # Vérifie que les titres des documents existe bien dans la liste
    List Should Contain Sub List  ${liste_titre_annexes}  ${liste_documents}
    # Vérifie que les titres des pièce existe bien dans la liste
    List Should Contain Sub List  ${liste_titre_annexes}  ${title_piece_annexes}

    # La tâche de notification de catégorie portal doit exister
    Depuis la page d'accueil  admin  admin
    ${di_notif_annexe_mult_se} =  Sans espace  ${di_notif_annexe_mult}
    # Vérification de la task
    &{task_values} =  Create Dictionary
    ...  type=notification_instruction
    ...  dossier=${di_notif_annexe_mult_se}
    ...  state=new
    ...  link_dossier=${di_notif_annexe_mult_se}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}  portal

    Depuis la page d'accueil  admin  admin

    # En supprimant le paramètre, la valeur max du nombre d'annexe notifiable par défaut est à 5
    Supprimer le paramètre  parametre_notification_max_annexes

Suppression du parametre de notification
    [Documentation]  Suppression du parametre de notification

    Depuis la page d'accueil  admin  admin

    # Suppression du paramétrage de notification
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification
    ...  click_value=LIBRECOM_NOTIFDEM
    Supprimer le paramètre (surcharge)  ${param_args}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification_piece_numerisee
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

La notification des demandeurs doit afficher une erreur si l'option notification n'est pas active
    [Documentation]  Vérifie que la notification des demandeur n'envoie rien et affiche une erreur
    ...  si l'option option_notification n'est pas active. Test 2 cas : la notification automatique
    ...  et la notification manuelle.

    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_notification
    ...  valeur=plop
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Ajout d'un dossier et d'une instruction de notification auto.
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Cressac
    ...  particulier_prenom=Véronique
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  courriel=vcressac@notif.fr
    ...  notification=t
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis la page d'accueil  mpaulet  mpaulet
    Ajouter une instruction au DI  ${di}  TEST_NOTIF_AUTO
    # Un message d'erreur doit etre dans le tableau de suivi
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_NOTIF_AUTO
    Wait Until Element Contains  css=td[data-column-id="statut"]       Echec
    Element Should Contain  css=td[data-column-id="commentaire"]  L'option de notification option_notification doit obligatoirement être définie.

    # Ajout d'un dossier et d'une instruction de notification manuelle
    ${inst_notif_man} =  Ajouter une instruction au DI  ${di}  TEST_NOTIF_MAN
    Click On Link  ${inst_notif_man}
    Portlet Action Should Be In SubForm  instruction  overlay_notification_manuelle
    # Accès au formulaire de notification manuelle. Un message d'erreur doit être visible
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Wait Until Element Contains  css=#sousform-instruction_notification_manuelle .message  Erreur lors de la génération de la notification.\nL'option de notification option_notification doit obligatoirement être définie.

TNR Message lorsque la notification n'est pas possible
    [Documentation]  Permet de vérifier que le message est
    ...  correctement affiché lorsque la notification n'est pas possible

    # Activation du paramètre de notification avec la valeur mail
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_notification
    ...  valeur=mail
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial

    # Évènement sans notification

    &{args_evenementsansnotif} =  Create Dictionary
    ...  libelle=Évènement sans notification
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    Ajouter l'événement depuis le menu  ${args_evenementsansnotif}

    &{args_evenementnotifauto} =  Create Dictionary
    ...  libelle=Évènement avec notification automatique
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  notification=Notification automatique
    Ajouter l'événement depuis le menu  ${args_evenementnotifauto}

    &{args_evenementnotifman} =  Create Dictionary
    ...  libelle=Évènement avec notification manuelle
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  notification=Notification manuelle
    Ajouter l'événement depuis le menu  ${args_evenementnotifman}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=145TESTMESSAGENOM
    ...  particulier_prenom=145TESTMESSAGEPRENOM
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_NOTIFDEM
    ...  depot_electronique=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  mpaulet  mpaulet
    # Ajout de l'évènement sans notification
    Ajouter une instruction au DI  ${di}  ${args_evenementsansnotif.libelle}
    # Ajout de l'évènement avec notification automatique
    Ajouter une instruction au DI  ${di}  ${args_evenementnotifauto.libelle}
    # Ajout de l'évènement avec notification manuelle
    Ajouter une instruction au DI  ${di}  ${args_evenementnotifman.libelle}

    Depuis l'instruction du dossier d'instruction  ${di}  ${args_evenementsansnotif.libelle}
    Element Should Not Be Visible  css=.panel_information

    Depuis l'instruction du dossier d'instruction  ${di}  ${args_evenementnotifauto.libelle}
    Element Should Contain  css=.panel_information  La notification n'est pas possible.
    Element Should Contain  css=.panel_information legend  Les données suivantes doivent être modifiées

    Depuis l'instruction du dossier d'instruction  ${di}  ${args_evenementnotifman.libelle}
    Element Should Contain  css=.panel_information  La notification n'est pas possible.
    Element Should Contain  css=.panel_information legend  Les données suivantes doivent être modifiées

    Depuis la page d'accueil  admin  admin
    # Suppression du paramètre de notification
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

