*** Settings ***
Documentation  Rubrique Suivi.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Keywords ***
Les fonctionnalités de suivi doivent être disponibles

    [Documentation]  Ce test vise uniquement à vérifier que les écrans
    ...  correspondant à chaque entrée de menu ne génère pas une erreur de base
    ...  de données.

    # On vérifie le menu "Retours De Consultation"
    Go To Submenu In Menu  suivi  consultation-retour
    # On vérifie que le titre de la page est cohérent
    Page Title Should Be  Suivi > Demandes D'avis > Retours De Consultation

    # On vérifie le menu "Mise À Jour Des Dates"
    Go To Submenu In Menu  suivi  suivi_mise_a_jour_des_dates
    # On vérifie que le titre de la page est cohérent
    Page Title Should Be  Suivi > Suivi Des Pièces > Mise À Jour Des Dates

    # On vérifie le menu "Envoi Lettre AR"
    Go To Submenu In Menu  suivi  envoi_lettre_rar
    # On vérifie que le titre de la page est cohérent
    Page Title Should Be  Suivi > Suivi Des Pièces > Envoi Lettre AR

    # On vérifie le menu "Bordereaux"
    Go To Submenu In Menu  suivi  bordereaux
    # On vérifie que le titre de la page est cohérent
    Page Title Should Be  Suivi > Suivi Des Pièces > Bordereaux

    # On vérifie le menu "Mise À Jour Des Dates" de la catégorie
    # "Demandes D'avis"
    Go To Submenu In Menu  suivi  demandes_avis_mise_a_jour_des_dates
    # On vérifie que le titre de la page est cohérent
    Page Title Should Be  Suivi > Demandes D'avis > Mise À Jour Des Dates

    # On clique sur l'entrée de menu "Suivi -> Commissions -> Gestion"
    Go To Submenu In Menu  suivi  commissions
    # On vérifie que le titre de la page est cohérent
    Page Title Should Be  Suivi > Commissions > Gestion

    # On vérifie le menu "Demandes"
    Go To Submenu In Menu  suivi  commissions-demande-passage
    # On vérifie que le titre de la page est cohérent
    Page Title Should Be  Suivi > Commissions > Demandes


*** Test Cases ***
Intégration des fonctionnalités de suivi

    Depuis la page d'accueil  suivi  suivi
    Les fonctionnalités de suivi doivent être disponibles

    Depuis la page d'accueil  adminfonct  adminfonct
    Les fonctionnalités de suivi doivent être disponibles


Mise à jour des dates sur les demandes d'avis par la cellule suivi
    [Documentation]  'Suivi > Demandes D'avis > Mise À Jour Des Dates'. La
    ...  cellulle suivi peut mettre à jour les dates des consultations
    ...  directement à l'aide d'un code barre présent sur les demandes
    ...  d'avis.

    ##
    ## Constitution du jeu de données
    ##
    # 2 Nouvelles consultations, sur le dossier di_01 qui est affecté à
    # l'instructeur "Louis Laurent" (instr) division "H" MARSEILLE
    ##
    #
    &{args_petitionnaire_01} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_01} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=MARSEILLE
    # Pour conformité
    ${service_1} =  Set Variable  59.02 - Atelier du Patrimoine
    # Avec avis attendu
    ${service_2} =  Set Variable  59.13 - Régie des Tranports de Marseille - DTP/CIP
    #
    ${di_01} =  Ajouter la demande par WS  ${args_demande_01}  ${args_petitionnaire_01}
    #
    Depuis la page d'accueil  instr  instr
    Ajouter une consultation depuis un dossier  ${di_01}  ${service_1}
    Ajouter une consultation depuis un dossier  ${di_01}  ${service_2}
    Depuis le contexte de la consultation  ${di_01}  ${service_1}
    ${consultation_1_id} =  Get Value  css=div#form-content #consultation
    ${consultation_1_codebarres} =  STR_PAD_LEFT  ${consultation_1_id}  10  0
    ${consultation_1_codebarres} =  Catenate  12${consultation_1_codebarres}
    Depuis le contexte de la consultation  ${di_01}  ${service_2}
    ${consultation_2_id} =  Get Value  css=div#form-content #consultation
    ${consultation_2_codebarres} =  STR_PAD_LEFT  ${consultation_2_id}  10  0
    ${consultation_2_codebarres} =  Catenate  12${consultation_2_codebarres}

    ##
    ##
    ##
    #
    ##
    Depuis la page d'accueil  suivi  suivi
    # On clique sur le menu "Mise à jour des dates" de la catégorie "Demandes d'avis"
    Go To Submenu In Menu  suivi  demandes_avis_mise_a_jour_des_dates
    Page Title Should Be  Suivi > Demandes D'avis > Mise À Jour Des Dates
    First Tab Title Should Be  Consultation

    # On saisit un code barres et on ne saisit pas la date
    Input Text  code_barres  123456789123
    Input Text  date  ${EMPTY}
    # On valide
    Click On Submit Button Until Message  Tous les champs doivent être remplis.
    Error Message Should Be  Tous les champs doivent être remplis.

    # On sait un code barres incorrect
    Input Text  date  12/05/2015
    Input Text  code_barres  '?#
    # On valide
    Click On Submit Button Until Message  Le numéro saisi ne correspond à aucun code barres de consultation.
    Error Message Should Be  Le numéro saisi ne correspond à aucun code barres de consultation.

    # On saisit une date mais pas de code barres
    Input Text  code_barres  ${EMPTY}
    Input Text  date  12/05/2015
    # On valide
    Click On Submit Button Until Message  Tous les champs doivent être remplis.
    Error Message Should Be  Tous les champs doivent être remplis.

    # On saisit une consultation qui n'existe pas
    #$this->byId("date")->value(date("d/m/Y",strtotime("+1 day")));
    Input Text  date  13/05/2015
    Input Text  code_barres  123456789123
    # On valide
    Click On Submit Button Until Message  Le numéro saisi ne correspond à aucun code barres de consultation.
    Error Message Should Be  Le numéro saisi ne correspond à aucun code barres de consultation.

    # On saisit une consultation qui n'est pas une demande d'avis
    Input Text  code_barres  ${consultation_1_codebarres}
    # On valide
    Click On Submit Button Until Message  Cette consultation n'a pas d'avis attendu.
    Error Message Should Be  Cette consultation n'a pas d'avis attendu.

    # On saisit une consultation qui a une demande d'avis
    Input Text  code_barres  ${consultation_2_codebarres}
    # On valide
    Click On Submit Button
    # On vérifie qu'on est sur la consultation
    Form Value Should Be  css=#code_barres  ${consultation_2_codebarres}
    Element Should Contain  css=#dossier_libelle  ${di_01}
    #
    Submenu In Menu Should Be Selected  suivi  demandes_avis_mise_a_jour_des_dates
    Page Title Should Be  Suivi > Demandes D'avis > Mise À Jour Des Dates
    First Tab Title Should Be  Consultation
    #
    Click On Back Button
    Submenu In Menu Should Be Selected  suivi  demandes_avis_mise_a_jour_des_dates
    Page Title Should Be  Suivi > Demandes D'avis > Mise À Jour Des Dates
    First Tab Title Should Be  Consultation
    # On valide
    Click On Submit Button
    # On vérifie qu'on est sur la consultation
    Form Value Should Be  css=#code_barres  ${consultation_2_codebarres}
    Element Should Contain  css=#dossier_libelle  ${di_01}
    #
    Submenu In Menu Should Be Selected  suivi  demandes_avis_mise_a_jour_des_dates
    Page Title Should Be  Suivi > Demandes D'avis > Mise À Jour Des Dates
    First Tab Title Should Be  Consultation
    # On valide la mise à jour de la date
    Click On Submit Button Until Message  Saisie enregistrée
    Valid Message Should Be  Saisie enregistrée

    ##
    ##
    ##
    # On vérifie que la date s'est bien mise à jour
    Depuis la page d'accueil  instr  instr
    Depuis le contexte de la consultation  ${di_01}  ${service_2}
    Element Should Contain  css=#date_reception  13/05/2015


Réponse à une consultation par la cellule suivi
    [Documentation]  'Suivi > Demandes D'avis > Retours De Consultation'. La
    ...  cellulle suivi peut saisir les retours de consultation reçus par
    ...  papier directement à l'aide d'un code barre présent sur les demandes
    ...  d'avis.

    ##
    ## Constitution du jeu de données
    ##
    #
    # Le dossier di_01 est affecté à l'instructeur "Louis Laurent" (instr) division "H"
    #
    #
    &{args_petitionnaire_01} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_01} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=MARSEILLE
    #
    ${service} =  Set Variable  59.01 - Direction de l'Eau et de l'Assainissement
    #
    ${di_01} =  Ajouter la demande par WS  ${args_demande_01}  ${args_petitionnaire_01}
    #
    Depuis la page d'accueil  instr  instr
    Ajouter une consultation depuis un dossier  ${di_01}  ${service}
    Depuis le contexte de la consultation  ${di_01}  ${service}
    ${consultation_id} =  Get Value  css=div#form-content #consultation
    ${consultation_codebarres} =  STR_PAD_LEFT  ${consultation_id}  10  0
    ${consultation_codebarres} =  Catenate  12${consultation_codebarres}

    ##
    ##
    ##

    # On se connecte en tant que "suivi"
    Depuis la page d'accueil  suivi  suivi

    # On accède à l'écran de saisie des retours de consultation
    Go To Submenu In Menu  suivi  consultation-retour
    Page Title Should Be  Suivi > Demandes D'avis > Retours De Consultation
    First Tab Title Should Be  Consultation

    # On clique sur le bouton "Valider" sans saisir de code barres
    Click On Submit Button Until Message  Veuiller saisir un code barres de consultation.
    Error Message Should Be  Veuiller saisir un code barres de consultation.

    #
    Input Text  code_barres  '?#
    Click On Submit Button Until Message  Cette consultation n'existe pas.
    Error Message Should Be  Cette consultation n'existe pas.

    # reset du message
    Go To Submenu In Menu  suivi  consultation-retour
    Input Text  code_barres  aze
    Click On Submit Button Until Message  Cette consultation n'existe pas.
    Error Message Should Be  Cette consultation n'existe pas.

    # Saisie d'un code barre valide
    Input Text  code_barres  ${consultation_codebarres}
    Click On Submit Button
    # On vérifie que les valeurs du formulaire corresponde
    Page Title Should Be  Suivi > Demandes D'avis > Retours De Consultation > ${consultation_id}
    Form Value Should Be  css=#consultation  ${consultation_id}
    Form Value Should Be  css=#dossier_libelle  ${di_01}

    # On clique sur le lien retour
    Click On Back Button
    # On vérifie que le retour nous mène bien à l'écran de saisie des retours de consultation
    Go To Submenu In Menu  suivi  consultation-retour
    Page Title Should Be  Suivi > Demandes D'avis > Retours De Consultation
    First Tab Title Should Be  Consultation

    # Saisie d'un code barre valide
    Input Text  code_barres  ${consultation_codebarres}
    Click On Submit Button
    # On vérifie que les valeurs du formulaire corresponde
    Page Title Should Be  Suivi > Demandes D'avis > Retours De Consultation > ${consultation_id}
    Form Value Should Be  css=#consultation  ${consultation_id}
    Form Value Should Be  css=#dossier_libelle  ${di_01}
    # Saisie des valeurs dans le formulaire
    Select From List By Label  css=select#avis_consultation  Favorable
    Input Text  css=textarea#motivation  blablabla
    Add File  fichier  lettre_rar16042013124515.pdf
    Click On Submit Button Until Message  Vos modifications ont bien été enregistrées.
    # On vérifie que le message de validation est présent
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    # On vérifie qu'il s'agit du formulaire de validation et non d'un listing
    Page Should Not Contain  enregistrement(s)
    Page Title Should Be  Suivi > Demandes D'avis > Retours De Consultation > ${consultation_id}
    Form Value Should Be  css=#consultation  ${consultation_id}
    Form Value Should Be  css=#dossier_libelle  ${di_01}
    # On vérifie que le bouton retour affiche le formulaire de saisie du code
    # barre
    Click On Back Button
    Page Title Should Be  Suivi > Demandes D'avis > Retours De Consultation
    First Tab Title Should Be  Consultation
    Element Should Be Visible  css=#code_barres

    # On vérifie que le retour nous mène bien à l'écran de saisie des retours de consultation
    Go To Submenu In Menu  suivi  consultation-retour
    Page Title Should Be  Suivi > Demandes D'avis > Retours De Consultation
    First Tab Title Should Be  Consultation


TNR Bug "Erreur de base de données" lors de la saisie de caractère spéciaux dans le champ code barre du formulaire de suivi mise à jour des dates des instructions

    [Documentation]

    #
    Depuis la page d'accueil  suivi  suivi
    # On change de contexte pour que l'ouverture de menu suivante fonctionne
    Depuis le listing  dossier_autorisation
    # Saisie de Mise à jour des dates
    Go To Submenu In Menu    suivi    suivi_mise_a_jour_des_dates
    Input Text  date  12/05/2015
    Input Text  code_barres  '?#
    # On valide le formulaire
    Click On Submit Button
    # On ne fait aucune vérification ici car le keyword précédent "Click On
    # Submit Button" permet de vérifier qu'il n'y a pas d'erreur de base de
    # données


TNR Bug "Erreur de base de données" lors de la saisie de caractère spéciaux dans le champ code barre du formulaire de suivi du bordereau d'envoi au maire

    [Documentation]

    #
    Depuis la page d'accueil  admin  admin
    # On change de contexte pour que l'ouverture de menu suivante fonctionne
    Depuis le listing  dossier_autorisation
    # Saisie de Mise à jour des dates
    Go To Submenu In Menu    suivi    bordereau_envoi_maire
    Input Text  date  12/05/2015
    Input Text  code_barres  '?#
    # On valide le formulaire
    Click On Submit Button
    # On ne fait aucune vérification ici car le keyword précédent "Click On
    # Submit Button" permet de vérifier qu'il n'y a pas d'erreur de base de
    # données


TNR Bug "Erreur de base de données" lors de la prévisualisation des bordereaux.

    [Documentation]  Vérifie qu'il n'a aucune erreur lors de la prévisualisation
    ...  des bordereaux depuis le menu des états.

    #
    Depuis la page d'accueil  admin  admin
    # On change de contexte pour que l'ouverture de menu suivante fonctionne
    Depuis le listing  dossier_autorisation
    # Saisie de Mise à jour des dates
    Go To Submenu In Menu    parametrage-dossier    om_etat
    # On fait une recherche sur l'identifiant de l'état
    Use Simple Search  id  bordereau_courriers_signature_maire
    # On sélectionne le résultat
    Click On Link  bordereau_courriers_signature_maire
    # On clic sur l'action de prévisualisation
    Click On Form Portlet Action  om_etat  previsualiser  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie qu'il n'y a pas d'erreur
    Sleep  1
    La page ne doit pas contenir d'erreur
    # On ferme le PDF
    Close PDF
    # On clic sur le bouton de retour
    Click On Back Button
    # On fait une recherche sur l'identifiant de l'état
    Use Simple Search  id  bordereau_avis_maire_prefet
    # On sélectionne le résultat
    Click On Link  bordereau_avis_maire_prefet
    # On clic sur l'action de prévisualisation
    Click On Form Portlet Action  om_etat  previsualiser  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie qu'il n'y a pas d'erreur
    Sleep  1
    La page ne doit pas contenir d'erreur
    # On ferme le PDF
    Close PDF
    # On clic sur le bouton de retour
    Click On Back Button
    # On fait une recherche sur l'identifiant de l'état
    Use Simple Search  id  bordereau_controle_legalite
    # On sélectionne le résultat
    Click On Link  bordereau_controle_legalite
    # On clic sur l'action de prévisualisation
    Click On Form Portlet Action  om_etat  previsualiser  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie qu'il n'y a pas d'erreur
    Sleep  1
    La page ne doit pas contenir d'erreur
    # On ferme le PDF
    Close PDF
    # On clic sur le bouton de retour
    Click On Back Button
    # On fait une recherche sur l'identifiant de l'état
    Use Simple Search  id  bordereau_decisions
    # On sélectionne le résultat
    Click On Link  bordereau_decisions
    # On clic sur l'action de prévisualisation
    Click On Form Portlet Action  om_etat  previsualiser  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie qu'il n'y a pas d'erreur
    Sleep  1
    La page ne doit pas contenir d'erreur
    # On ferme le PDF
    Close PDF
    # On clic sur le bouton de retour
    Click On Back Button


TNR Mise à jour des dates après le délai de notification au pétitionnaire

    [Documentation]  Vérification du message d'erreur lors de la mise à jour de
    ...  la date de retour AR

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=SCP
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Martinez
    ...  personne_morale_prenom=Nicolas
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/05/2015
    ...  om_collectivite=MARSEILLE

    ${di_02} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrpoly  instrpoly
    ${code_barres} =  Ajouter une instruction au DI et la finaliser  ${di_02}  Notification de pieces manquante  false  12/05/2015
    Set Suite Variable  ${code_barres}

    #
    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    # Saisie de Mise à jour des dates
    Go To Submenu In Menu    suivi    suivi_mise_a_jour_des_dates
    Select From List By Label    css=#type_mise_a_jour    date de notification du correspondant
    Input Text  date  12/07/2015
    Input Text  code_barres  ${code_barres}
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=#formulaire div.formControls input[type="submit"]
    # On valide la synthèse
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=#formulaire div.formControls input[type="submit"]

    # Vérification des messages d'erreur
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Contain    css=div.ui-state-error p span.text  Problème de dates : contactez l'instructeur du dossier
    Element Should Contain    css=div.ui-state-error p span.text  (date d'événement <= date limite de notification au pétitionnaire)
    Element Should Contain    css=div.ui-state-valid p span.text  Saisie enregistrée

    # Vérification que l'événement retour n'est pas inséré
    Depuis l'onglet instruction du dossier d'instruction  ${di_02}
    Page Should Not Contain  incomplétude après accusé de réception


Constitution du jeu de données pour les bordereaux de suivi

    [Documentation]  Crée 2 dossiers sur 2 collectivités différentes, et fait le
    ...  paramétrage nécessaire aux tests sur les bordereaux

    # DI sur la collectivite Marseille

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Chesnay
    ...  particulier_prenom=Roger
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # DI sur la collectivite Allauch

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Sevier
    ...  particulier_prenom=André
    ...  om_collectivite=ALLAUCH
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=ALLAUCH

    ${di_allauch} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Variables disponibles dans tout le test suite
    Set Suite Variable  ${di}
    Set Suite Variable  ${di_allauch}


    # On supprime le paramètre pour tester l'erreur.
    Depuis la page d'accueil  admin  admin
    Supprimer le paramètre  id_evenement_bordereau_avis_maire_prefet


TNR Filtre collectivités sur bordereau d'envoi de courriers signature Maire

    [Documentation]  Contrôle que le bordereau d'envoi de courriers signature Maire affiche
    ...  seulement les dossiers de la collectivité de l'utilisateur en tant que mono,
    ...  que le select de collectivité en tant qu'utilisateur multi fonctionne,
    ...  et que le Bordereau d'envoi des avis du Maire au Préfet retourne une
    ...  erreur quand mal paramétré.

    Depuis la page d'accueil  instrpoly  instrpoly
    # Ajout de l'instruction Majoration de délai et des dates pour que le dossier
    # apparaisse dans notre bordereau
    Ajouter une instruction au DI et la finaliser  ${di}  Majoration délai SS en révision  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_signature  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    Depuis la page d'accueil  instrpolycomm3  instrpolycomm3
    # Ajout de l'instruction Majoration de délai et des dates pour que le dossier
    # apparaisse dans notre bordereau
    Ajouter une instruction au DI et la finaliser  ${di_allauch}  Majoration délai SS en révision  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_signature  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    # Le bordereau d'envoi des avis du Maire au Préfet de Marseille doit afficher le
    # dossier "Chesnay" de Marseille et pas "Sevier" d'ALLAUCH
    Depuis la page d'accueil  suivi  suivi
    Click Link  Bordereaux
    Wait Until Element Is Visible  date_bordereau_debut
    # On ne doit pas avoir le select de collectivité en temps que collectivité de niveau 1

    Page Should Not Contain  Collectivité
    La page ne doit pas contenir d'erreur
    Select From List By Label  bordereau  Bordereau d'envoi des avis du Maire au Préfet
    Input Text  date_bordereau_debut  ${date_ddmmyyyy}
    Input Text  date_bordereau_fin  ${date_ddmmyyyy}
    Click On Submit Button Until Message  Erreur de paramétrage. Contactez votre administrateur.
    Error Message Should Contain  Erreur de paramétrage. Contactez votre administrateur.

    # On change la valeur de id_evenement_bordereau_avis_maire_prefet pour que le dossier
    # apparaisse sur le bordereau
    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  id_evenement_bordereau_avis_maire_prefet  81  agglo


    # Vérification des messages d'erreur
    Depuis la page d'accueil  suivi  suivi
    Click Link  Bordereaux
    Wait Until Element Is Visible  date_bordereau_debut
    Click On Submit Button Until Message  Veuillez sélectionner un bordereau
    Error Message Should Contain  Veuillez sélectionner un bordereau
    Select From List By Label  bordereau  Bordereau d'envoi des avis du Maire au Préfet
    Input Text  date_bordereau_debut  null
    Input Text  date_bordereau_fin  null
    Click On Submit Button Until Message  Veuillez saisir une date valide
    Error Message Should Contain  Veuillez saisir une date valide

    Input Text  date_bordereau_debut  ${date_ddmmyyyy}
    Input Text  date_bordereau_fin  ${date_ddmmyyyy}

    Ouvrir le bordereau de suivi  Bordereau d'envoi de courriers signature Maire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Contain  Edition du${SPACE}${date_ddmmyyyy}
    Page Should Not Contain  Sevier
    Close PDF

    ${list_collectivites} =    Create List
    ...    Toutes
    ...    ALLAUCH
    ...    MARSEILLE

    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  suivi  bordereau_envoi_maire
    Click Link  Bordereaux
    # Le select Collectivité doit être présent
    Page Should Contain  Collectivité
    La page ne doit pas contenir d'erreur
    # Le select doit contenir les 4 options
    Select List Should Contain List  om_collectivite  ${list_collectivites}
    # On affiche le bordereau de toutes les communes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_collectivite  Toutes
    Ouvrir le bordereau de suivi  Bordereau d'envoi de courriers signature Maire
    # Le PDF doit contenir les dossiers des 2 communes mono et Toutes au lieu du nom de la
    # commune
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Contain  Toutes
    Page Should Contain  Sevier
    Close PDF

    # On affiche le bordereau des dossiers de Marseille
    Click Link  Bordereaux
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_collectivite  MARSEILLE
    Ouvrir le bordereau de suivi  Bordereau d'envoi de courriers signature Maire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Not Contain  Sevier
    # On doit avoir le code et nom de la commune
    Page Should Contain  013 055
    Page Should Contain  Marseille
    Close PDF


TNR Filtre collectivités sur bordereau d'envoi des décisions

    [Documentation]  Vérifie que le bordereau d'envoi des décisions affiche seulement les
    ...  dossiers de la collectivité de l'utilisateur en tant que mono, et que le select
    ...  de collectivité en tant qu'utilisateur multi fonctionne.

    Depuis la page d'accueil  admingen  admingen
    # Ajout de l'instruction accepter un dossier et des dates pour que le dossier
    # apparaisse dans notre bordereau
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_signature  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    # Ajout de l'instruction accepter un dossier et des dates pour que le dossier
    # apparaisse dans notre bordereau
    Ajouter une instruction au DI et la finaliser  ${di_allauch}  accepter un dossier sans réserve  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_signature  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    # Le bordereau d'envoi des avis du Maire au Préfet de Marseille doit afficher le
    # dossier "Chesnay" de Marseille et pas "Sevier" d'ALLAUCH
    Depuis la page d'accueil  suivi  suivi
    Click On Link  Bordereaux
    Page Title Should Be  Suivi > Suivi Des Pièces > Bordereaux
    Ouvrir le bordereau de suivi  Bordereau d'envoi des décisions
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Contain  Edition du${SPACE}${date_ddmmyyyy}
    Page Should Not Contain  Sevier
    Close PDF

    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  suivi  bordereau_envoi_maire
    Click Link  Bordereaux

    # Le bordereau de toutes les communes doit contenir les 2 dossiers
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_collectivite  Toutes
    Ouvrir le bordereau de suivi  Bordereau d'envoi de courriers signature Maire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Contain  Sevier
    Close PDF

    Click Link  Bordereaux
    # L'option Allauch doit afficher seulement le dossier d'Allauch
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_collectivite  ALLAUCH
    Ouvrir le bordereau de suivi  Bordereau d'envoi de courriers signature Maire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Sevier
    Page Should Not Contain  Chesnay Roger
    Close PDF


TNR Filtre collectivités sur bordereau d'envoi des contrôles de légalité

    [Documentation]  Vérifie que le bordereau d'envoi des contrôles de légalité affiche
    ...  les dossiers de la collectivité de l'utilisateur en tant que mono, et que le
    ...  select de collectivité en tant qu'utilisateur multi fonctionne.

    Depuis la page d'accueil  admingen  admingen
    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_controle_legalite  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    Depuis l'instruction du dossier d'instruction  ${di_allauch}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_controle_legalite  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    # Le bordereau d'envoi des avis du Maire au Préfet de Marseille doit afficher le
    # dossier "Chesnay" de Marseille et pas "Sevier" d'ALLAUCH
    Depuis la page d'accueil  suivi  suivi
    Click Link  Bordereaux
    Ouvrir le bordereau de suivi  Bordereau d'envoi des contrôles de légalité
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Contain  Edition du${SPACE}${date_ddmmyyyy}
    Page Should Not Contain  Sevier
    Close PDF

    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  suivi  bordereau_envoi_maire
    Click Link  Bordereaux

    # L'option Toutes du select doit afficher les dossiers des 2 communes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_collectivite  Toutes
    Ouvrir le bordereau de suivi  Bordereau d'envoi de courriers signature Maire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Contain  Sevier
    Close PDF

    Click Link  Bordereaux
    # L'option Allauch doit afficher seulement le dossier d'Allauch
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_collectivite  ALLAUCH
    Ouvrir le bordereau de suivi  Bordereau d'envoi de courriers signature Maire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Sevier
    Page Should Not Contain  Chesnay Roger
    Close PDF


TNR Filtre collectivités sur bordereau d'envoi des avis du Maire au Préfet

    [Documentation]  Vérifie que le bordereau d'envoi des avis du Maire au Préfet affiche
    ...  les dossiers de la collectivité de l'utilisateur en tant que mono, et que le
    ...  select de collectivité en tant qu'utilisateur multi fonctionne.

    Depuis la page d'accueil  admingen  admingen
    # Met à jour les dates d'envoi de lettre AR
    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    # Met à jour les dates d'envoi de lettre AR
    Depuis l'instruction du dossier d'instruction  ${di_allauch}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    Depuis la page d'accueil  instr  instr
    # Ajout de l'instruction Changer l'autorité compétente 'commune état' pour que le
    # dossier apparaisse dans notre bordereau
    Ajouter une instruction au DI  ${di}  Changer l'autorité compétente 'commune état'  ${date_ddmmyyyy}
    Element Should Contain  css=div.ui-state-valid  Vos modifications ont bien été enregistrées.

    Depuis la page d'accueil  instrpolycomm3  instrpolycomm3
    # Ajout de l'instruction Changer l'autorité compétente 'commune état' pour que le
    # dossier apparaisse dans notre bordereau
    Ajouter une instruction au DI  ${di_allauch}  Changer l'autorité compétente 'commune état'  ${date_ddmmyyyy}
    Element Should Contain  css=div.ui-state-valid  Vos modifications ont bien été enregistrées.

    # Le bordereau d'envoi des avis du Maire au Préfet de Marseille doit afficher le
    # dossier "Chesnay" de Marseille et pas "Sevier" d'ALLAUCH
    Depuis la page d'accueil  suivi  suivi
    Click Link  Bordereaux
    Ouvrir le bordereau de suivi  Bordereau d'envoi des avis du Maire au Préfet
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Contain  Edition du${SPACE}${date_ddmmyyyy}
    Page Should Not Contain  Sevier
    Close PDF


    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  suivi  bordereau_envoi_maire
    Click Link  Bordereaux

    # L'option Marseille doit afficher seulement le dossier de Marseille
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_collectivite  Toutes
    Ouvrir le bordereau de suivi  Bordereau d'envoi de courriers signature Maire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Contain  Sevier
    Close PDF

    Click Link  Bordereaux
    # L'option Marseille doit afficher seulement le dossier de Marseille
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_collectivite  MARSEILLE
    Ouvrir le bordereau de suivi  Bordereau d'envoi de courriers signature Maire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Chesnay Roger
    Page Should Not Contain  Sevier
    Close PDF


Envoi Lettre AR

    [Documentation]  Vérifie plusieurs points des planches AR :
    ...  - vérification des messages d'erreurs du formulaire
    ...  - l'édition générique des planches AR de plusieurs instruction d'un même DI
    ...  Dans l'édition :
    ...  - le représentant d'une personne morale ;
    ...  - la division si la phase est paramétrée sur l'événement ;
    ...  - le code de la phase si la phase est paramétrée sur l'événement.

    #
    &{args_petitionnaire_1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Ynovy
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Pierre-Alexandre
    ...  personne_morale_prenom=JOUVE
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    &{args_petitionnaire_2} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=PMSM
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Catoir
    ...  personne_morale_prenom=Christophe
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di_04} =  Ajouter la demande par WS  ${args_demande_1}  ${args_petitionnaire_1}
    ${di_03} =  Ajouter la demande par WS  ${args_demande_2}  ${args_petitionnaire_2}

    #
    Depuis la page d'accueil  instr  instr
    #
    ${code_barres} =  Récupérer le code barres de l'instruction  ${di_03}  Notification du delai legal maison individuelle
    ${code_barres2} =  Ajouter une instruction au DI et la finaliser  ${di_03}  accepter un dossier sans réserve
    ${code_barres4} =  Ajouter une instruction au DI et la finaliser  ${di_04}  accepter un dossier sans réserve

    Depuis la page d'accueil  suivi  suivi
    Click Link  envoi lettre AR
    Page Title Should Be  Suivi > Suivi Des Pièces > Envoi Lettre AR

    # Vérification sans valeur saisie
    Click On Submit Button Until Message  Tous les champs doivent être remplis.
    Error Message Should Be  Tous les champs doivent être remplis.

    # Vérification avec un numéro non valide
    Input Text  liste_code_barres_instruction  a
    Click On Submit Button Until Message  Le code barres d'instruction a n'est pas valide.
    Error Message Should Be  Le code barres d'instruction a n'est pas valide.

    # Vérification avec un numéro non présent en base
    Input Text  liste_code_barres_instruction  123
    Click On Submit Button Until Message  Le numéro 123 ne correspond à aucun code barres d'instruction.
    Error Message Should Be  Le numéro 123 ne correspond à aucun code barres d'instruction.

    # Vérification avec la 1ère instruction du dossier
    Ouvrir l'édition envoi lettre AR avec le code barres  ${date_ddmmyyyy}  ${code_barres}
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  PDF Pages Number Should Be  1
    # On vérifie que le réprésentant de la personne morale est affiché
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  rep. par Catoir Christophe
    # On vérifie que la division ne soit pas affichée lorsque la phase n'est pas
    # paramétrée
    Page Should Not Contain  subdivision H
    # On vérifie que le code de la phase ne soit pas affiché lorsque la phase
    # n'est pas paramétrée
    Page Should Not Contain  PINSTR
    #
    Close PDF

    # Vérification de l'édition de la 2ème instruction du dossier
    Ouvrir l'édition envoi lettre AR avec le code barres  ${date_ddmmyyyy}  ${code_barres2}
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  PDF Pages Number Should Be  1
    # On vérifie que le réprésentant de la personne morale est affiché
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  rep. par Catoir Christophe
    Page Should Not Contain  subdivision H
    Page Should Not Contain  PINSTR
    #
    Close PDF

    # On vérifie la presence des liens vers les DI et qu'ils pointent vers les bon dossiers.
    Click Element  css=fieldset#fieldset-form-rar-lien_di>legend
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.message  ${di_03}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=fieldset#fieldset-form-rar-lien_di .fieldsetContent .field .text a[title="Consulter"]
    Click Element Until No More Element  css=fieldset#fieldset-form-rar-lien_di .fieldsetContent .field .text a[title="Consulter"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Title Should Be  Instruction > Dossiers D'instruction > ${di_03} SOCIÉTÉ PMSM


    #
    Depuis la page d'accueil  admin  admin
    #
    &{phase} =  Create Dictionary
    ...  code=INSTR
    Ajouter la phase  ${phase}
    # On lie la phase à l'événement "Notification du delai legal maison individuelle"
    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  phase=INSTR
    #
    Modifier l'événement  ${args_evenement}

    #
    Depuis la page d'accueil  suivi  suivi
    #
    Ouvrir l'édition envoi lettre AR avec le code barres  ${date_ddmmyyyy}  ${code_barres}
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  PDF Pages Number Should Be  1
    # On vérifie que le réprésentant de la personne morale est affiché
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  rep. par Catoir Christophe
    # On vérifie que la division est affichée lorsque la phase est paramétrée
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  subdivision H
    # On vérifie que le code de la phase est affiché lorsque la phase est
    # paramétrée
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  INSTR
    #
    Close PDF


    # On vérifie que les liens DI sont occultés pour les utilisateurs qui ne doivent pas y avoir accès.
    Depuis la page d'accueil  instrpolycomm3  instrpolycomm3
    Go To Submenu In Menu  suivi  envoi_lettre_rar
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  date  ${date_ddmmyyyy}
    Input Text  liste_code_barres_instruction  ${code_barres4}
    Click On Submit Button
    Valid Message Should Contain  Cliquez sur le lien ci-dessous pour télécharger votre document :
    Click Element  css=fieldset#fieldset-form-rar-lien_di>legend
    Element Should Not Contain  css=.message  ${di_03}
    Element Should Contain  css=.message  Certains dossiers ont été omis de la liste ci-dessous car vous ne possédez pas les permissions nécessaires pour y accéder.

Mise à jour de dates simple
    [Documentation]  Le but de ce test case est de vérifier la mise à jour de
    ...  dates simples par la cellule de suivi:
    ...  - On crée 2 instructions puis on les finalise
    ...  - On met à jour les instruction avec plusieurs types
    ...  - On vérifie que les mises à jour on été prises en compte à la bonne date

    ${di} =  Set Variable  PC 013055 12 00002P0
    ${evenement_1} =  Set Variable  accepter un dossier sans réserve
    ${evenement_2} =  Set Variable  retrait apres decision
    ${date} =   Get Current Date
    ${date_6} =  Subtract Time From Date  ${date}  6 days  %d/%m/%Y
    ${date_4} =  Subtract Time From Date  ${date}  4 days  %d/%m/%Y

    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI  ${di}  ${evenement_1}
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click On Link  ${evenement_1}
    ${idInstr_1} =  Get Value  css=.form-content input#instruction
    Click On SubForm Portlet Action  instruction  finaliser
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La finalisation du document s'est effectuée avec succès.
    Click On Back Button In Subform

    Ajouter une instruction au DI  ${di}  ${evenement_2}
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click On Link  ${evenement_2}
    ${idInstr_2} =  Get Value  css=.form-content input#instruction
    Click On SubForm Portlet Action  instruction  finaliser
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La finalisation du document s'est effectuée avec succès.
    Click On Back Button In Subform

    ${instruction_codebarres_1} =  STR_PAD_LEFT  ${idInstr_1}  10  0
    ${instruction_codebarres_1} =  Catenate  11${instruction_codebarres_1}

    ${instruction_codebarres_2} =  STR_PAD_LEFT  ${idInstr_2}  10  0
    ${instruction_codebarres_2} =  Catenate  11${instruction_codebarres_2}

    Go To Submenu In Menu  suivi  suivi_mise_a_jour_des_dates

    Input Text  code_barres  ${instruction_codebarres_1}
    Input Text  date  ${date_6}
    Select From List By Label  type_mise_a_jour  date d'envoi pour signature Mairie/Préfet
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  dossier_libelle  ${di}
    Element Should Contain  date_envoi_signature  ${date_6}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Saisie enregistrée

    Input Text  code_barres  ${instruction_codebarres_1}
    Input Text  date  ${date_4}
    Select From List By Label  type_mise_a_jour  date de retour de signature Mairie/Préfet
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  dossier_libelle  ${di}
    Element Should Contain  date_retour_signature  ${date_4}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Saisie enregistrée

    Input Text  code_barres  ${instruction_codebarres_1}
    Input Text  date  ${date_4}
    Select From List By Label  type_mise_a_jour  date d'envoi au contrôle de légalite
    Click On Submit Button
    Element Should Contain  dossier_libelle  ${di}
    Element Should Contain  date_envoi_controle_legalite  ${date_4}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Saisie enregistrée

    Input Text  code_barres  ${instruction_codebarres_1}
    Input Text  date  ${DATE_FORMAT_DD/MM/YYYY}
    Select From List By Label  type_mise_a_jour  date de retour de controle de légalite
    Click On Submit Button
    Element Should Contain  dossier_libelle  ${di}
    Element Should Contain  date_retour_controle_legalite  ${DATE_FORMAT_DD/MM/YYYY}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Saisie enregistrée


    Input Text  code_barres  ${instruction_codebarres_2}
    Input Text  date  ${date_6}
    Select From List By Label  type_mise_a_jour  date d'envoi pour signature Mairie/Préfet
    Click On Submit Button
    Element Should Contain  dossier_libelle  ${di}
    Element Should Contain  date_envoi_signature  ${date_6}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Saisie enregistrée

    Input Text  code_barres  ${instruction_codebarres_2}
    Input Text  date  ${date_4}
    Select From List By Label  type_mise_a_jour  date de retour de signature Mairie/Préfet
    Click On Submit Button
    Element Should Contain  dossier_libelle  ${di}
    Element Should Contain  date_retour_signature  ${date_4}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Saisie enregistrée

    Input Text  code_barres  ${instruction_codebarres_2}
    Input Text  date  ${date_4}
    Select From List By Label  type_mise_a_jour  date d'envoi au contrôle de légalite
    Click On Submit Button
    Element Should Contain  dossier_libelle  ${di}
    Element Should Contain  date_envoi_controle_legalite  ${date_4}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Saisie enregistrée

    Input Text  code_barres  ${instruction_codebarres_2}
    Input Text  date  ${DATE_FORMAT_DD/MM/YYYY}
    Select From List By Label  type_mise_a_jour  date de retour de controle de légalite
    Click On Submit Button
    Element Should Contain  dossier_libelle  ${di}
    Element Should Contain  date_retour_controle_legalite  ${DATE_FORMAT_DD/MM/YYYY}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#formulaire div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Saisie enregistrée

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet instruction du dossier d'instruction  ${di}

    Click Link  ${evenement_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Contain  css=.form-content input#instruction  ${idInstr_1}
    Element Should Contain  date_envoi_signature  ${date_6}
    Element Should Contain  date_retour_signature  ${date_4}
    Element Should Contain  date_envoi_controle_legalite  ${date_4}
    Element Should Contain  date_retour_controle_legalite  ${DATE_FORMAT_DD/MM/YYYY}
    Click On Back Button In Subform

    Click Link  ${evenement_2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Contain  css=.form-content input#instruction  ${idInstr_2}
    Element Should Contain  date_envoi_signature  ${date_6}
    Element Should Contain  date_retour_signature  ${date_4}
    Element Should Contain  date_envoi_controle_legalite  ${date_4}
    Element Should Contain  date_retour_controle_legalite  ${DATE_FORMAT_DD/MM/YYYY}
    Click On Back Button In Subform

Génération du bordereau d'envoi au maire
    [Documentation]  L'objet de ce 'Test Case' est de vérifier la génération
    ...    du PDF ainsi que la mise à jour de la date d'envoi du courrier
    ...    pour signature par le maire.

    # Constitution du jeu de données : un DI commune pour lequel un utilisateur
    # communauté génère l'édition
    Depuis la page d'accueil  admin  admin
    # Donnée 2/3 : instructeur
    Ajouter l'utilisateur  Garcia Gabriel  support@atreal.fr  instrmars2  instrmars2  INSTRUCTEUR  MARSEILLE
    Ajouter la direction depuis le menu  MRS  Direction MRS  null  Chef MRS  null  null  MARSEILLE
    Ajouter la division depuis le menu  MRS  subdivision MRS  null  Chef MRS  null  null  Direction MRS
    Ajouter l'instructeur depuis le menu  Garcia Gabriel  subdivision MRS  instructeur  Garcia Gabriel
    # Donnée 3/3 : affectation automatique du nouvel instructeur
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Garcia Gabriel (MRS)
    ...  om_collectivite=MARSEILLE
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # On crée une nouvelle demande
        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Brousseau
    ...  particulier_prenom=Henry
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # En tant qu'instructeur
    Depuis la page d'accueil  instrmars2  instrmars2
    # On récupère l'identifiant de l' événement d'instruction
    Depuis l'onglet instruction du dossier d'instruction  ${di_libelle}
    Click On Link  Notification du delai legal maison individuelle
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    # On en déduit le code-barres
    ${code_barres} =  STR_PAD_LEFT  ${id_instruction}  10  0
    ${code_barres} =  Catenate  11${code_barres}

    Depuis la page d'accueil  admin  admin
    # On ouvre l'interface de génération du bordereau
    Depuis le formulaire d'édition du bordereau d'envoi au maire
    # On saisit un mauvais code-barres
    Saisir le formulaire du bordereau d'envoi au maire  ${code_barres}1
    # On valide le formulaire
    Valider le formulaire du bordereau d'envoi au maire
    # On vérifie le message d'erreur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Error Message Should Be  Le numéro saisi ne correspond a aucun code-barres d’événement d'instruction.
    # On saisit un code-barres valide
    Saisir le formulaire du bordereau d'envoi au maire  ${code_barres}
    # On revalide le formulaire
    Valider le formulaire du bordereau d'envoi au maire
    # On clique sur le lien de l'édition
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  generer_bordereau_envoi_maire
    # On vérifie le contenu du PDF généré
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  PDF Pages Number Should Be  1
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  bordereau d'envoi
    Close PDF
    # On accède à l'événement d'instruction
    Depuis l'onglet instruction du dossier d'instruction  ${di_libelle}
    Click On Link  Notification du delai legal maison individuelle
    Element Text Should Be  date_envoi_signature  ${date_ddmmyyyy}


Finalisation automatique de l'événement d'instruction retour (par le menu suivi)
    [Documentation]  Vérification de la finalisation automatique de
    ...  l'instruction de retour AR.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_prenom=Édouard
    ...  particulier_nom=Souplet
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instrpoly  instrpoly
    ${code_barres} =  Ajouter une instruction au DI et la finaliser  ${di}  ARRÊTÉ DE REFUS  false  02/09/2000
    # On saisi la date de retour AR depuis le menu de suivi
    Go To Submenu In Menu    suivi    suivi_mise_a_jour_des_dates
    Select From List By Label    css=#type_mise_a_jour    date de notification du correspondant
    Input Text  date  ${date_ddmmyyyy}
    Input Text  code_barres  ${code_barres}
    Click On Submit Button
    Click On Submit Button
    # On vérifie que l'événement d'instruction retour soit finalisé
    Depuis l'instruction du dossier d'instruction  ${di}  Arrêté de Refus signé
    Element Should Contain  css=span#date_finalisation_courrier.field_value  ${date_ddmmyyyy}
