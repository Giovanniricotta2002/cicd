*** Settings ***
Documentation     Compteur de signatures

# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown


*** Test Cases ***
Constitution du jeu de données

    # Copie le fichier de configuration pour le connecteur test du parapheur
    Copy File  ..${/}tests${/}binary_files${/}electronicsignature_test${/}electronicsignature.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin

    # Isolation du contexte
    &{collectivite_values} =  Create Dictionary
    ...  om_collectivite_libelle=Collectivité-CPTSIGN
    ...  departement=018
    ...  commune=001
    ...  insee=18001
    ...  direction_code=G
    ...  direction_libelle=Direction de Collectivité-CPTSIGN
    ...  direction_chef=Chef
    ...  division_code=G
    ...  division_libelle=Division G
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Jean Roule
    ...  guichet_om_utilisateur_email=jroule@openads-test.fr
    ...  guichet_om_utilisateur_login=jroule
    ...  guichet_om_utilisateur_pwd=jroule
    ...  instr_om_utilisateur_nom=Hector Blumberg
    ...  instr_om_utilisateur_email=hblumberg@openads-test.fr
    ...  instr_om_utilisateur_login=hblumberg
    ...  instr_om_utilisateur_pwd=hblumberg
    Isolation d'un contexte  ${collectivite_values}
    Set Suite Variable  ${collectivite_values}

    # Ajout des sinataires
    &{args_signataire_1} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=Signataire-CPTSIGN-nom-1
    ...  prenom=Signataire-CPTSIGN-prénom-1
    ...  qualite=Signataire-CPTSIGN-qualité-1
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=Collectivité-CPTSIGN
    ...  email=signataire-cptsign-1@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_1}
    Set Suite Variable  ${args_signataire_1}
    &{args_signataire_2} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=Signataire-CPTSIGN-nom-2
    ...  prenom=Signataire-CPTSIGN-prénom-2
    ...  qualite=Signataire-CPTSIGN-qualité-2
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=Collectivité-CPTSIGN
    ...  email=signataire-cptsign-2@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_2}
    Set Suite Variable  ${args_signataire_2}
    &{args_signataire_3} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=Signataire-CPTSIGN-nom-3
    ...  prenom=Signataire-CPTSIGN-prénom-3
    ...  qualite=Signataire-CPTSIGN-qualité-3
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=Collectivité-CPTSIGN
    ...  email=signataire-cptsign-3@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_3}
    Set Suite Variable  ${args_signataire_3}


Ajoute puis modifie un compteur

    Depuis la page d'accueil  admin  admin

    &{args_compteur} =  Create Dictionary
    ...  code=testcpt1
    ...  description=Description de testcpt1
    ...  unite=kg
    ...  quantite=0
    ...  quota=100
    ...  alerte=80
    ...  om_collectivite=Collectivité-CPTSIGN
    ...  om_validite_debut=02/02/2020
    ${compteur_id} =  Ajouter compteur avec dates validité  ${args_compteur}
    La page ne doit pas contenir d'erreur

    Set To Dictionary  ${args_compteur}  unite=l
    Modifier compteur avec dates validité  ${compteur_id}  ${args_compteur}
    La page ne doit pas contenir d'erreur


Vérifie l'incrémentation du compteur de signature lorsqu'un document est signé

    Depuis la page d'accueil  admin  admin

    # ajoute un compteur 'signatures' pour la collectivité 'Collectivité-CPTSIGN'
    &{args_compteur} =  Create Dictionary
    ...  code=signatures
    ...  description=Nombre de signatures
    ...  quantite=0
    ...  quota=0
    ...  om_collectivite=Collectivité-CPTSIGN
    ...  om_validite_debut=02/02/2020
    Set Suite Variable  ${args_compteur}
    ${compteur_id} =  Ajouter compteur avec dates validité  ${args_compteur}
    La page ne doit pas contenir d'erreur
    Set Suite Variable  ${compteur_id}

    # ajoute un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pétitionaire-CPTSIGN-nom
    ...  particulier_prenom=Pétitionaire-CPTSIGN-prénom
    ...  om_collectivite=Collectivité-CPTSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-CPTSIGN
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # ajoute une instruction au dossier associée au signataire 1
    Ajouter une instruction au DI et la finaliser
    ...  ${di}  accepter un dossier sans réserve
    ...  signataire_arrete=${args_signataire_1.prenom} ${args_signataire_1.nom}

    # envoie le document (de l'instruction) en signature
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Form Static Value Should Be  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    Portlet Action Should Not Be In SubForm  instruction  annuler_envoi_en_signature
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Element Should Be Visible  css=#date_envoi_signature[readonly="readonly"]
    Element Should Be Visible  css=#date_retour_signature[readonly="readonly"]
    ${id_instruction} =  Get Value  css=.form-content input#instruction

    # déclenche la réception des documents signés et vérifie que l'instruction a bien été mise à jour
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  200
    ...  L'instruction ${id_instruction} et son document ont bien été mis à jour

    # vérifie que le document signé a bien été récupéré
    Depuis l'instruction du dossier d'instruction  ${di}  ${id_instruction}
    Form Static Value Should Be  css=#date_retour_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  signé
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    Form Value Should Contain  css=#commentaire_signature  Test commentaire document signé.
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  PARAPHEUR CONNECTEUR DE TEST
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  DOCUMENT SIGNÉ
    Close PDF

    # constate que le compteur 'signatures' de la collectivité 'Collectivité-CPTSIGN' a été incrémenté
    Depuis le contexte compteur avec dates validité  ${compteur_id}
    ${compteur_qte} =  Get Text  css=div.form-content span#quantite
    Should Be Equal  1  ${compteur_qte}


Vérifie l'incrémentation du compteur de signature lorsqu'un document est signé pour une collectivité niveau 2

    Depuis la page d'accueil  admin  admin

    # ajoute un compteur 'signatures' pour la collectivité de niveau 2
    &{args_compteur} =  Create Dictionary
    ...  code=signatures
    ...  description=Nombre de signatures
    ...  quantite=0
    ...  quota=0
    ...  om_collectivite=agglo
    ...  om_validite_debut=04/04/2020
    ${compteur_id} =  Ajouter compteur avec dates validité  ${args_compteur}
    La page ne doit pas contenir d'erreur

    # ajoute un signataire sur la collectivité de niveau 1 sans compteur
    &{args_signataire} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=Signataire-MARSEILLE-nom-CPTSIGN
    ...  prenom=Signataire-MARSEILLE-prénom-CPTSIGN
    ...  qualite=Signataire-MARSEILLE-qualité-CPTSIGN
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=MARSEILLE
    ...  email=signataire-marseille-cptsign@test.test
    Ajouter le signataire depuis le menu  ${args_signataire}

    # ajoute un dossier sur une collectivité de niveau 1 sans compteur
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pétitionaire-MARSEILLE-nom-CPTSIGN
    ...  particulier_prenom=Pétitionaire-MARSEILLE-prénom-CPTSIGN
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # ajoute une instruction au dossier associée au signataire 1
    Ajouter une instruction au DI et la finaliser
    ...  ${di}  accepter un dossier sans réserve
    ...  signataire_arrete=${args_signataire.prenom} ${args_signataire.nom}

    # envoie le document (de l'instruction) en signature
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Form Static Value Should Be  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    Portlet Action Should Not Be In SubForm  instruction  annuler_envoi_en_signature
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Element Should Be Visible  css=#date_envoi_signature[readonly="readonly"]
    Element Should Be Visible  css=#date_retour_signature[readonly="readonly"]
    ${id_instruction} =  Get Value  css=.form-content input#instruction

    # déclenche la réception des documents signés et vérifie que l'instruction a bien été mise à jour
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  200
    ...  L'instruction ${id_instruction} et son document ont bien été mis à jour

    # vérifie que le document signé a bien été récupéré
    Depuis l'instruction du dossier d'instruction  ${di}  ${id_instruction}
    Form Static Value Should Be  css=#date_retour_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  signé
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    Form Value Should Contain  css=#commentaire_signature  Test commentaire document signé.
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  PARAPHEUR CONNECTEUR DE TEST
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  DOCUMENT SIGNÉ
    Close PDF

    # constate que le compteur 'signatures' de la collectivité de niveau 2 a été incrémenté
    Depuis le contexte compteur avec dates validité  ${compteur_id}
    ${compteur_qte} =  Get Text  css=div.form-content span#quantite
    Should Be Equal  1  ${compteur_qte}

    # supprime le compteur 'signatures' pour la collectivité de niveau 2
    Supprimer compteur avec dates validité  ${compteur_id}
    La page ne doit pas contenir d'erreur


Vérifie la non-incrémentation du compteur de signature lorsqu'un document est en cours de signature

    Depuis la page d'accueil  admin  admin

    # le compteur 'signatures' pour la collectivité 'Collectivité-CPTSIGN' existe déjà
    # (ajouté dans le test précédent)

    # ajoute un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pétitionaire-CPTSIGN-nom
    ...  particulier_prenom=Pétitionaire-CPTSIGN-prénom
    ...  om_collectivite=Collectivité-CPTSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-CPTSIGN
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # ajoute une instruction au dossier associée au signataire 2
    Ajouter une instruction au DI et la finaliser
    ...  ${di}  accepter un dossier sans réserve
    ...  signataire_arrete=${args_signataire_2.prenom} ${args_signataire_2.nom}

    # envoie le document (de l'instruction) en signature
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Form Static Value Should Be  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    Portlet Action Should Not Be In SubForm  instruction  annuler_envoi_en_signature
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Element Should Be Visible  css=#date_envoi_signature[readonly="readonly"]
    Element Should Be Visible  css=#date_retour_signature[readonly="readonly"]
    ${id_instruction} =  Get Value  css=.form-content input#instruction

    # déclenche la réception des documents signés et vérifie que l'instruction n'a pas été mise à jour
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  200  Rien à faire sur l'instruction

    # constate que le compteur 'signatures' de la collectivité 'Collectivité-CPTSIGN'
    # n'a pas été incrémenté (était égal à 1 suite au test précédent)
    Depuis le contexte compteur avec dates validité  ${compteur_id}
    ${compteur_qte} =  Get Text  css=div.form-content span#quantite
    Should Be Equal  1  ${compteur_qte}


Vérifie que la date de validité d'un compteur signature est prise en compte correctement

    Depuis la page d'accueil  admin  admin

    # le compteur 'signatures' pour la collectivité 'Collectivité-CPTSIGN' existe déjà
    # (ajouté dans le test précédent)

    # récupère la valeur actuelle du compteur de signatures pour la collectivité
    # 'Collectivité-CPTSIGN' ainsi que sa date de dernière mise à jour
    Depuis le contexte compteur avec dates validité  ${compteur_id}
    ${compteur_qte} =  Get Text  css=div.form-content span#quantite
    Should Be Equal  1  ${compteur_qte}

    # archive le compteur de signature existant
    Set To Dictionary  ${args_compteur}  quantite=${compteur_qte}
    Set To Dictionary  ${args_compteur}  om_validite_fin=02/02/2021
    Modifier compteur avec dates validité  ${compteur_id}  ${args_compteur}
    La page ne doit pas contenir d'erreur

    # ajoute un compteur 'signatures' pour la collectivité 'Collectivité-CPTSIGN'
    &{args_compteur_new} =  Create Dictionary
    ...  code=signatures
    ...  description=Nombre de signatures
    ...  quantite=0
    ...  quota=0
    ...  om_collectivite=Collectivité-CPTSIGN
    ...  om_validite_debut=02/02/2022
    Set Suite Variable  ${args_compteur_new}
    ${compteur_id_new} =  Ajouter compteur avec dates validité  ${args_compteur_new}
    La page ne doit pas contenir d'erreur
    Set Suite Variable  ${compteur_id_new}

    # ajoute un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pétitionaire-CPTSIGN-nom
    ...  particulier_prenom=Pétitionaire-CPTSIGN-prénom
    ...  om_collectivite=Collectivité-CPTSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-CPTSIGN
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # ajoute une instruction au dossier associée au signataire 3
    Ajouter une instruction au DI et la finaliser
    ...  ${di}  accepter un dossier sans réserve
    ...  signataire_arrete=${args_signataire_3.prenom} ${args_signataire_3.nom}

    # envoie le document (de l'instruction) en signature
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Form Static Value Should Be  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    Portlet Action Should Not Be In SubForm  instruction  annuler_envoi_en_signature
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Element Should Be Visible  css=#date_envoi_signature[readonly="readonly"]
    Element Should Be Visible  css=#date_retour_signature[readonly="readonly"]
    ${id_instruction} =  Get Value  css=.form-content input#instruction

    # déclenche la réception des documents signés et vérifie que l'instruction n'a pas été mise à jour
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  200
    ...  L'instruction ${id_instruction} et son document ont bien été mis à jour

    # constate que le compteur archivé 'signatures' de la collectivité 'Collectivité-CPTSIGN'
    # n'a pas été incrémenté (était égal à 1 suite au test précédent)
    Depuis le contexte compteur avec dates validité  ${compteur_id}
    ${compteur_qte} =  Get Text  css=div.form-content span#quantite
    Should Be Equal  1  ${compteur_qte}

    # constate que le compteur actuel 'signatures' de la collectivité 'Collectivité-CPTSIGN'
    # a pas été incrémenté
    Depuis le contexte compteur avec dates validité  ${compteur_id_new}
    ${compteur_qte_new} =  Get Text  css=div.form-content span#quantite
    Should Be Equal  1  ${compteur_qte_new}


Vérification des différents affichages du widget de compteur de signatures

    Depuis la page d'accueil  admin  admin

    # ajout d'un administrateur fonctionnel pour la collectivité 'Collectivité-CPTSIGN'
    Ajouter l'utilisateur depuis le menu  Admin CPTSIGN
    ...  acptsign@openads-test.fr  acptsign  acptsign  ADMINISTRATEUR FONCTIONNEL
    ...  ${collectivite_values.om_collectivite_libelle}

    # ajout d'un widget de compteur signatures au tableau de bord de l'administrateur fonctionnel
    ${om_widget_libelle} =  Set Variable  Signatures
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=compteur_signatures
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=ADMINISTRATEUR FONCTIONNEL
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    # le compteur 'signatures' pour la collectivité 'Collectivité-CPTSIGN' existe déjà
    # (ajouté dans le test précédent)

    # modifie le compteur existant (celui qui est valide, donc le nouveau du test précédent)
    Set To Dictionary  ${args_compteur_new}  quantite=100
    Set To Dictionary  ${args_compteur_new}  alerte=80
    Set To Dictionary  ${args_compteur_new}  quota=500
    Modifier compteur avec dates validité  ${compteur_id_new}  ${args_compteur_new}
    La page ne doit pas contenir d'erreur

    # vérifie l'affichage du widget sur le tableau de bord de l'administrateur fonctionnel
    Depuis la page d'accueil  acptsign  acptsign
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  100 / 500 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  400 / 500 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  20 %

    # modifie le compteur pour augmenter le nombre de signature pour qu'il dépasse l'alerte
    Depuis la page d'accueil  admin  admin
    Set To Dictionary  ${args_compteur_new}  quantite=450
    Set To Dictionary  ${args_compteur_new}  alerte=80
    Set To Dictionary  ${args_compteur_new}  quota=500
    Modifier compteur avec dates validité  ${compteur_id_new}  ${args_compteur_new}
    La page ne doit pas contenir d'erreur

    # vérifie l'affichage du widget sur le tableau de bord de l'administrateur fonctionnel
    Depuis la page d'accueil  acptsign  acptsign
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  450 / 500 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  50 / 500 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  90 %
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures
    ...  Attention vous approchez de la limite de votre quota de signatures. Afin de l'augmenter, cliquez ici

    # modifie le compteur pour augmenter le nombre de signature pour qu'il dépasse le quota
    Depuis la page d'accueil  admin  admin
    Set To Dictionary  ${args_compteur_new}  quantite=550
    Set To Dictionary  ${args_compteur_new}  alerte=80
    Set To Dictionary  ${args_compteur_new}  quota=500
    Modifier compteur avec dates validité  ${compteur_id_new}  ${args_compteur_new}
    La page ne doit pas contenir d'erreur

    # vérifie l'affichage du widget sur le tableau de bord de l'administrateur fonctionnel
    Depuis la page d'accueil  acptsign  acptsign
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  550 / 500 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  50 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  110 %
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures
    ...  Vous avez atteint la limite de votre quota de signatures. Afin de l'augmenter, cliquez ici

    # ajoute un autre compteur 'signatures' pour une autre collectivité (ici 'Marseille')
    Depuis la page d'accueil  admin  admin
    &{args_compteur_other} =  Create Dictionary
    ...  code=signatures
    ...  description=Nombre de signatures
    ...  quantite=77
    ...  quota=0
    ...  om_collectivite=MARSEILLE
    ...  om_validite_debut=02/02/2022
    ${compteur_id_other} =  Ajouter compteur avec dates validité  ${args_compteur_other}
    La page ne doit pas contenir d'erreur

    # vérifie l'affichage du widget sur le tableau de bord de l'administrateur fonctionnel
    Depuis la page d'accueil  adminfonct  adminfonct
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  77

    # vérifie le message d'erreur du widget lorsqu'il ne trouve pas le compteur de signatures
    # pour la collectivité associée à l'utilisateur actuel (ici on utilise une astuce en allant
    # dans la prévisualisation du tableau de bord avec l'utilisateur 'admin' qui est associé
    # à la collectivité de niveau 2 - identifiant 1 -, qui n'a pas de compteur de signatures)
    Depuis la page d'accueil  admin  admin
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&validation=1&idx=0&action=4
    Select From List By Label  om_profil  ADMINISTRATEUR FONCTIONNEL
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures
    ...  Aucun compteur 'signatures' valide pour la collectivité 1

    # supprime le widget du dashboard (nécessaire au test suivant)
    Supprimer le tableau de bord depuis l'URL par l'identifiant  ${om_dashboard}


Vérification des paramètres du widget de compteur de signatures

    Depuis la page d'accueil  admin  admin

    Depuis le contexte de la collectivité  ${collectivite_values.om_collectivite_libelle}
    ${collectivite_id} =  Get Text  css=span#om_collectivite

    # ajout d'un widget de compteur signatures au tableau de bord de l'administrateur fonctionnel
    ${om_widget_libelle} =  Set Variable  Signatures CTPSIGN
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=compteur_signatures
    ...  arguments=om_collectivite=${collectivite_id}
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=ADMINISTRATEUR FONCTIONNEL
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    # le compteur 'signatures' pour la collectivité 'Collectivité-CPTSIGN' existe déjà
    # (ajouté dans le test précédent)

    # vérifie que l'affichage du widget sur le tableau de bord de l'administrateur fonctionnel
    # correspond bien à la collectivité passée en paramètre du widget (ici 'Collectivité-CPTSIGN'
    # alors que l'on est sur la page d'un administrateur fonctionnel de 'Marseille')
    Depuis la page d'accueil  adminfonct  adminfonct
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  550 / 500 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  50 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  110 %
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures
    ...  Vous avez atteint la limite de votre quota de signatures. Afin de l'augmenter, cliquez ici

