*** Settings ***
Documentation     Envoi en signature dans le parapheur

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
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_ELECSIGN
    ...  departement=020
    ...  commune=001
    ...  insee=20001
    ...  direction_code=H
    ...  direction_libelle=Direction de LIBRECOM_ELECSIGN
    ...  direction_chef=Chef
    ...  division_code=H
    ...  division_libelle=Division H
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Fabienne St-Jean
    ...  guichet_om_utilisateur_email=fstjean@openads-test.fr
    ...  guichet_om_utilisateur_login=fstjean
    ...  guichet_om_utilisateur_pwd=fstjean
    ...  instr_om_utilisateur_nom=Zara Cliche
    ...  instr_om_utilisateur_email=zcliche@openads-test.fr
    ...  instr_om_utilisateur_login=zcliche
    ...  instr_om_utilisateur_pwd=zcliche
    Isolation d'un contexte  ${librecom_values}

    # Ajout des sinataires
    &{args_signataire_case_err_1} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOM1
    ...  prenom=TEST140SIGNATUREPRENOM1
    ...  qualite=TEST140SIGNATUREQUALITE1
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ...  email=caseerror1@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_err_1}
    Set Suite Variable  ${args_signataire_case_err_1}
    &{args_signataire_case_err_2} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOM2
    ...  prenom=TEST140SIGNATUREPRENOM2
    ...  qualite=TEST140SIGNATUREQUALITE2
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ...  email=caseerror2@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_err_2}
    Set Suite Variable  ${args_signataire_case_err_2}
    &{args_signataire_case_err_3} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOM3
    ...  prenom=TEST140SIGNATUREPRENOM3
    ...  qualite=TEST140SIGNATUREQUALITE3
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ...  email=caseerror3@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_err_3}
    Set Suite Variable  ${args_signataire_case_err_3}
    &{args_signataire_case_ok_1} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOM4
    ...  prenom=TEST140SIGNATUREPRENOM4
    ...  qualite=TEST140SIGNATUREQUALITE4
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ...  email=case1-1@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_ok_1}
    Set Suite Variable  ${args_signataire_case_ok_1}
    &{args_signataire_case_ok_2} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOM5
    ...  prenom=TEST140SIGNATUREPRENOM5
    ...  qualite=TEST140SIGNATUREQUALITE5
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ...  email=case2-1@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_ok_2}
    Set Suite Variable  ${args_signataire_case_ok_2}
    &{args_signataire_case_ok_3} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOM6
    ...  prenom=TEST140SIGNATUREPRENOM6
    ...  qualite=TEST140SIGNATUREQUALITE6
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ...  email=case3@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_ok_3}
    Set Suite Variable  ${args_signataire_case_ok_3}
    &{args_signataire_case_ok_4} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOM7
    ...  prenom=TEST140SIGNATUREPRENOM7
    ...  qualite=TEST140SIGNATUREQUALITE7
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ...  email=case4@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_ok_4}
    Set Suite Variable  ${args_signataire_case_ok_4}
    &{args_signataire_case_ok_5} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOM8
    ...  prenom=TEST140SIGNATUREPRENOM8
    ...  qualite=TEST140SIGNATUREQUALITE8
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ...  email=case5@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_ok_5}
    Set Suite Variable  ${args_signataire_case_ok_5}
    &{args_signataire_case_ok_6} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOM9
    ...  prenom=TEST140SIGNATUREPRENOM9
    ...  qualite=TEST140SIGNATUREQUALITE9
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ...  email=case6@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_ok_6}
    Set Suite Variable  ${args_signataire_case_ok_6}

Envoi en signature des documents dans le parapheur avec un connecteur de test
    [Documentation]  Vérification de 6 scénarios avec le parapheur, 3 avec
    ...  erreur et 3 sans erreur.
    ...
    ...  Les scénarios avec erreurs :
    ...  1/ Erreur lors de l'envoi en signature, le connecteur de test retourne un
    ...  message d'erreur spécifique.
    ...  2/ Erreur lors de la récupération du statut du parapheur, le connecteur
    ...  de test retourne un message d'erreur spécifique.
    ...  3/ Erreur lors de la récupération du document signé, le connecteur de
    ...  test retourne un message spécifique.
    ...
    ...  Les scénarios sans erreurs :
    ...  1/ Le statut du parapheur récupéré est toujours le même que celui lors
    ...  de l'envoi en signature, seulement la date d'envoi en signature sur
    ...  l'instruction est modifiée. Les dates d'envoi et de retour signature ne
    ...  sont plus modifiable depuis le suivi des dates. On vérifie aussi que lorsque
    ...  le commentaire est modifié, une nouvelle entrée est ajoutée.
    ...  2/ Le statut du parapheur récupéré est différent de celui lors de l'envoi
    ...  en signature et il s'agit d'un 'finished' avec récupération du document
    ...  signé, donc modification de l'édition et ajout de la date de retour
    ...  signature sur l'instruction.
    ...  3/ Le statut du parapheur récupéré est différent de celui lors de l'envoi
    ...  en signature et il s'agit d'un 'canceled', l'action d'envoi en signature
    ...  doit être à nouveau possible depuis l'instruction.

    Depuis la page d'accueil  admin  admin

    # Cas d'erreur 1
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM1
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM1
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_err_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_err_1}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_err_1.prenom} ${args_signataire_case_err_1.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Error Message Should Contain In Subform  Produit une exception sur la méthode send_for_signature

    # Cas d'erreur 2
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM2
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM2
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_err_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_err_2}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_err_2.prenom} ${args_signataire_case_err_2.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Produit une exception sur la méthode get_signature_status

    # Cas d'erreur 3
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM3
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM3
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_err_3} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_err_3}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_err_3.prenom} ${args_signataire_case_err_3.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Produit une exception sur la méthode get_signed_document

    # On modifie la base de l'URL de la redirection vers le dossier d'instruction dans les
    # métadonnées du dossier pour vérifier que *param_base_path_metadata_url_di* fonctionne
    # correctement
    # La vérification est faite dans le cas 1 du connecteur de test
    &{param_division} =  Create Dictionary
    ...  libelle=param_base_path_metadata_url_di
    ...  valeur=test_metadata_url_di
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # Cas succès 1
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM4
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM4
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_ok_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_ok_1}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok_1.prenom} ${args_signataire_case_ok_1.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Form Static Value Should Be  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    Portlet Action Should Not Be In SubForm  instruction  annuler_envoi_en_signature
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Element Should Be Visible  css=#date_envoi_signature[readonly="readonly"]
    Element Should Be Visible  css=#date_retour_signature[readonly="readonly"]
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    # Ajout du commentaire lors de la première vérification du statut de signature
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  a bien été mise à jour
    # Vérification de la nouvelle entrée dans le tableau d'historique et dans le champ commentaire
    Depuis l'instruction du dossier d'instruction  ${di_case_ok_1}  accepter un dossier sans réserve
    Form Value Should Contain  css=#commentaire_signature  Test de commentaire lorsque le statut est en cours, l'apostrophe est aussi testé ;)
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#fieldset-sousform-instruction-historique legend
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.gridjs-tbody  Test de commentaire lorsque le statut est en cours, l'apostrophe est aussi testé ;)
    # À la deuxième vérification rien n'a changé
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Rien à faire sur l'instruction ${id_instruction}

    # Active l'action d'annulation d'envoi en signature
    Run  sed -i 's/"cancel_send" => false/"cancel_send" => true/' ../dyn/electronicsignature.inc.php
    
    # Vérification de l'action d'annulation
    Depuis la page d'accueil  admin  admin
    Depuis l'instruction du dossier d'instruction  ${di_case_ok_1}  accepter un dossier sans réserve
    ${status} =  Run Keyword And Return Status  Portlet Action Should Be In SubForm  instruction  annuler_envoi_signature
    Run Keyword If  ${status} == False  Run Keywords
    ...  Reload Page
    ...  AND  Depuis l'instruction du dossier d'instruction  ${di_case_ok_1}  accepter un dossier sans réserve
    ...  AND  Portlet Action Should Be In SubForm  instruction  annuler_envoi_signature
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Be In SubForm  instruction  annuler_envoi_signature
    Click On SubForm Portlet Action  instruction  annuler_envoi_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Form Value Should Contain  css=#commentaire_signature  Annulé par l'émetteur le ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  signature annulée
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Be In SubForm  instruction  envoyer_a_signature
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Not Be In SubForm  instruction  annuler_envoi_signature


    # On supprime *param_base_path_metadata_url_di* de l'URL de la redirection vers le
    # dossier d'instruction dans les métadonnées du dossier pour vérifier que la base
    # de l'URL est utilisée comme prévu
    # La vérification est faite dans le cas 2 du connecteur de test
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=param_base_path_metadata_url_di
    ...  click_value=param_base_path_metadata_url_di
    Supprimer le paramètre (surcharge)  ${param_args}

    # Cas succès 2
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM5
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM5
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_ok_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_ok_2}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok_2.prenom} ${args_signataire_case_ok_2.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Wait Until Element Contains  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  ${id_instruction} et son document ont bien été mis à jour
    Depuis l'instruction du dossier d'instruction  ${di_case_ok_2}  ${id_instruction}
    Form Static Value Should Be  css=#date_retour_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  signé
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    # Un document signé ne peut pas être annulé
    Portlet Action Should Not Be In SubForm  instruction  annuler_envoi_signature
    Form Value Should Contain  css=#commentaire_signature  Test commentaire document signé.
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  PARAPHEUR CONNECTEUR DE TEST
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  DOCUMENT SIGNÉ
    Close PDF
    # Vérification de la possibilité de reprendre la rédaction du document d'instruction :
    # L'utilisateur *admin* ayant la permission *instruction_definaliser_apres_signature*
    # doit pouvoir reprendre la rédaction.
    # L'instructeur affecté au dossier ne doit pas pouvoir réaliser cette action.
    Depuis la page d'accueil  zcliche  zcliche
    Depuis l'instruction du dossier d'instruction  ${di_case_ok_2}  ${id_instruction}
    Portlet Action Should Not Be In SubForm  instruction  definaliser
    Depuis la page d'accueil  admin  admin
    Depuis l'instruction du dossier d'instruction  ${di_case_ok_2}  ${id_instruction}
    Portlet Action Should Be In SubForm  instruction  definaliser


    # On défini le format de l'url attendu pour être rediriger sur l'onglet 'Pièces & Documents'
    # du dossier courant
    ${new_url_parapheur} =  Set Variable  http://localhost/openads/app/index.php?module=form&direct_link=true&obj=dossier_instruction&action=3&idx=PC0200012300005P0&direct_field=dossier&direct_form=document_numerise&direct_action=4&direct_idx=PC0200012300005P0

    # On ouvre le fieldset 'Historique'
    Click Element  css=#fieldset-sousform-instruction-historique legend
    # On récupère l'url de redirection envoyé en commentaire pour la tester
    ${new_URL_redirect_parapheur} =  Get Text  css=tbody tr:nth-child(1) td[data-column-id="commentaire"]
    Should Be Equal  ${new_url_parapheur}  ${new_URL_redirect_parapheur}

    # On accède à l'url pour vérifier que tout est bon : pas d'erreur, et qu'on est bien dans le bon dossier et le bon onglet 'Pièces & Documents'
    Go To  ${new_URL_redirect_parapheur}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  La page ne doit pas contenir d'erreur
    # On vérifie qu'on est bien dans le bon dossier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  PC 020001 23 00005P0 TEST140SIGNATUREPETNOM5 TEST140SIGNATUREPETPRENOM5
    # On vérifie qu'on est bien dans l'onglet 'Pièces & Documents' via la visibilité du lien de l'ajout d'une pièce
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Ajouter une pièce
    # On vérifie que la page affiché est bien fonctionnelle
    Click On Link  css=#action-soustab-blocnote-message-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#fieldset-sousform-document_numerise-piece

    # Cas succès 3
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM6
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM6
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_ok_3} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_ok_3}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok_3.prenom} ${args_signataire_case_ok_3.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Wait Until Element Contains  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  ${id_instruction} a bien été mise à jour
    Depuis l'instruction du dossier d'instruction  ${di_case_ok_3}  ${id_instruction}
    Form Static Value Should Be  css=#date_envoi_signature  ${EMPTY}
    Form Static Value Should Be  css=#statut_signature  signature annulée
    Form Value Should Contain  css=#commentaire_signature  Test d'un commentaire refus.
    Portlet Action Should Be In SubForm  instruction  envoyer_a_signature

    # Cas 5 vérification de l'envoi en signature le jour de la date limite

    # La date limite doit être aujourd'hui sachant qu'il y a un délai de 2 mois

    # 1 - créer une action de modification de date
    @{type_di} =  Create List
    ...  PCI - P - Initial
    &{args_action} =  Create Dictionary
    ...  action=changement_date
    ...  libelle=changement_date
    ...  regle_date_limite=date_evenement
    Ajouter Action  ${args_action}
    @{etats_autorises2} =  Create List
    ...    delai de notification envoye

    # 2 - créer un événement éponyme utilisant cette action
    &{args_evenement_para2} =  Create Dictionary
    ...  libelle=Changement date - 140 envoi signature
    ...  dossier_instruction_type=${type_di}
    ...  action=${args_action.libelle}
    ...  etats_autorises=${etats_autorises2}
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etats_autorises2}
    Ajouter l'événement depuis le menu  ${args_evenement_para2}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM8
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM8
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  date_demande=${date_ddmmyyyy}
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_ok_5} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # 3 - déclencher l'événement à l'aide d'une instruction
    Ajouter une instruction au DI  ${di_case_ok_5}  Changement date - 140 envoi signature

    Ajouter une instruction au DI et la finaliser  ${di_case_ok_5}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok_5.prenom} ${args_signataire_case_ok_5.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Wait Until Element Contains  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Rien à faire sur l'instruction ${id_instruction}
    Depuis l'instruction du dossier d'instruction  ${di_case_ok_5}  ${id_instruction}
    ${date_limite} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  1 days  result_format=%Y-%m-%d
    Form Value Should Contain  css=#commentaire_signature  ${date_limite}

    # Vérification de l'envoi en signature si document expiré
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM9
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM9
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_ok_6} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  zcliche  zcliche
    Ajouter une instruction au DI et la finaliser  ${di_case_ok_6}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok_6.prenom} ${args_signataire_case_ok_6.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    ${date_envoi_signature} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  -1 days
    ${date_envoi_signature} =  Convert Date    ${date_envoi_signature}  result_format=%d/%m/%Y
    Wait Until Element Contains  css=#date_envoi_signature  ${date_envoi_signature}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  ${id_instruction} a bien été mise à jour
    Depuis l'instruction du dossier d'instruction  ${di_case_ok_6}  ${id_instruction}
    Form Static Value Should Be  css=#statut_signature  délai de signature expiré
    Portlet Action Should Be In SubForm  instruction  envoyer_a_signature
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.

Vérification de l'utilisation de l'envoi en signature avec relecture
    [Documentation]  Permet de vérifier si l'envoi en signature avec relecture fonctionne correctement.
    ...  Une option est mise à disposition pour activer l'envoi en signature avec relecture. Elle se nomme "option_parapheur_relecture"
    ...  Lorsque cette option est activée l'action "Envoi en signature avec relecture" est disponible dans l'instruction.
    ...  Lorsqu'on envoi le document en signature avec relecture cette information est spécifié dans le tableau historique sous l'adresse
    ...  email du signataire.
    ...  L'action est similaire à celle d'envoi en signature avec un paramètre en plus. Le signataire utilisé sera le case_ok_4.

    # Copie le fichier de configuration pour le connecteur test du parapheur
    Copy File  ..${/}tests${/}binary_files${/}electronicsignature_test${/}electronicsignature.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin

    # Active l'action d'envoi en signature avec relecture
    Run  sed -i 's/"is_forced_view_files" => null/"is_forced_view_files" => true/' ../dyn/electronicsignature.inc.php

    # Cas succès 4
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM7
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM7
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_ok_4} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_ok_4}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok_4.prenom} ${args_signataire_case_ok_4.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature_relecture  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Form Static Value Should Be  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature_relecture
    Form Value Should Contain  css=#commentaire_signature  Relecture demandée.
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  ${id_instruction} a bien été mise à jour
    Depuis l'instruction du dossier d'instruction  ${di_case_ok_4}  ${id_instruction}
    Form Static Value Should Be  css=#date_envoi_signature  ${EMPTY}
    Form Static Value Should Be  css=#statut_signature  signature annulée
    Form Value Should Contain  css=#commentaire_signature  Test d'un commentaire refus.
    Portlet Action Should Be In SubForm  instruction  envoyer_a_signature
    Portlet Action Should Be In SubForm  instruction  envoyer_a_signature_relecture

    # Désactive l'action d'envoi en signature avec relecture
    Run  sed -i 's/"is_forced_view_files" => true/"is_forced_view_files" => null/' ../dyn/electronicsignature.inc.php

    Depuis l'instruction du dossier d'instruction  ${di_case_ok_4}  ${id_instruction}
    Portlet Action Should Be In SubForm  instruction  envoyer_a_signature
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature_relecture

Vérification de l'envoi en signature d'un document sur un dossier sans date limite
    [Documentation]  Afin de vérifier que l'envoi en signature se fait correctement
    ...  pour un document sur un dossier sans date limite, on va modifier la règle de l'action
    ...  initier un délai de notification, qui est utilisé sur la première instruction
    ...  ajouté lors de l'ajout d'un PC, afin d'enlever le calcul de la date limite
    ...  On test ensuite l'envoi en signature d'un document et on vérifie qu'il n'y
    ...  a pas de message d'erreur.
    ...  Enfin on rétabli la règle de l'action comme avant.

    # On enlève la règle de calcul de la date limite sur l'action d'initialisation du dossier d'instruction
    &{args_action_modif} =  Create Dictionary
    ...  regle_date_limite=${EMPTY}
    Modifier Action  initialisation  ${args_action_modif}

    # Création d'un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREDTLNOM
    ...  particulier_prenom=TEST140SIGNATUREDTLPRENOM
    ...  om_collectivite=LIBRECOM_ELECSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN
    ${di_case_ok_dtl} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On vérifie que la date limite est bien vide sur le dossier
    Depuis le contexte du dossier d'instruction  ${di_case_ok_dtl}
    Element Text Should Be  css=#date_limite  ${EMPTY}

    # On ajoute une instruction à envoyer au parapheur
    Ajouter une instruction au DI et la finaliser  ${di_case_ok_dtl}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok_4.prenom} ${args_signataire_case_ok_4.nom}
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer

    # Le document doit bien être envoyé
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Form Static Value Should Be  css=#date_envoi_signature  ${date_ddmmyyyy}
    Form Static Value Should Be  css=#statut_signature  en cours de signature

    La page ne doit pas contenir d'erreur

    # On rétabli la règle de calcul de la date limite sur l'action d'initialisation du dossier d'instruction
    &{args_action_modif} =  Create Dictionary
    ...  regle_date_limite=archive_date_dernier_depot+delai
    Modifier Action  initialisation  ${args_action_modif}

Widget "Suivi d'instruction paramétrable"
    [Documentation]  Permet de vérifier que le widget de suivi d'instruction paramétrable
    ...  fonctionne correctement

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # instructeur qui sera affecté comme instructeur secondaire des dossiers
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire_sip
    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WIDGET_SUIVI_INSTR
    ...  departement=170
    ...  commune=170
    ...  insee=17170
    ...  direction_code=JA
    ...  direction_libelle=Direction de LIBRECOM_WIDGET_SUIVI_INSTR
    ...  direction_chef=Chef
    ...  division_code=JA
    ...  division_libelle=Division JA
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Halil Zibr
    ...  guichet_om_utilisateur_email=hzibr@openads-test.fr
    ...  guichet_om_utilisateur_login=hzibr
    ...  guichet_om_utilisateur_pwd=hzibr
    ...  instr_om_utilisateur_nom=Omir Amb
    ...  instr_om_utilisateur_email=oaamb@openads-test.fr
    ...  instr_om_utilisateur_login=oaamb
    ...  instr_om_utilisateur_pwd=oaamb
    ...  instr_2_om_utilisateur_nom=${instructeur_secondaire_login}
    ...  instr_2_om_utilisateur_email=${instructeur_secondaire_login}@openads-test.fr
    ...  instr_2_om_utilisateur_login=${instructeur_secondaire_login}
    ...  instr_2_om_utilisateur_pwd=${instructeur_secondaire_login}
    ...  code_entite=LBCOM_120
    ...  acteur=LIBRECOM-ACT-120
    Isolation d'un contexte  ${librecom_values}

    # Ajout d'affectation de l'instructeur du contexte pour le type détaillé 'Déclaration préalable'
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${librecom_values.instr_om_utilisateur_nom} (${librecom_values.division_code})
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    Ajouter l'affectation depuis le menu  ${args_affectation}

    Depuis le contexte de l'instructeur  Omir Amb
    ${id_instructeur} =  Get Text  css=#instructeur
    Depuis le contexte de l'instructeur  ${instructeur_secondaire_login}
    ${id_instructeur_secondaire} =  Get Text  css=#instructeur

    Depuis la page d'accueil  admin  admin

    # On utilise un email permettant d'avoir un état in_progress après la récupération du statut
    &{args_signataire_case_ok_suivi_instr} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOMSUIVINSTR
    ...  prenom=TEST140SIGNATUREPRENOMSUIVINSTR
    ...  qualite=TEST140SIGNATUREQUALITESUIVINSTR
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ...  email=signataire-cptsign-2@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_ok_suivi_instr}

    # Ajout d'arguments en majuscules pour tester qu'ils sont retraités en minuscules (ncodes_datd=PCI;dp)
    ${om_widget} =  Set Variable  suivi_instruction_parametrable
    ${om_widget_libelle} =  Set Variable  TEST140WIDGETSUIVIINSTRPARAMETRABLE
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=${om_widget}
    ...  arguments=statut_signature=in_progress\naffichage=liste\ntri=-6\nmessage_help=plop\ncodes_datd=PCI;Dp\nnb_max_resultat=20
    Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=INSTRUCTEUR
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    # On vérifie lorsqu'il n'y a pas de résultats
    Depuis la page d'accueil  oaamb  oaamb

    Element Should Contain  css=.widget_${om_widget} .widget-content
    ...  Il n'y a pas de documents pour le moment.

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # On ajoute un dossier et on met une instruction au statut de signature "in_progress"
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM8
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM8
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ${di_case_ok_1_suiv_instr} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_ok_1_suiv_instr}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok_suivi_instr.prenom} ${args_signataire_case_ok_suivi_instr.nom}
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Rien à faire sur l'instruction ${id_instruction}

    # Ajout d'un dossier de type détaillé différent de PCI : DP (Déclaration préalable)
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM8_2
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM8_2
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ${di_case_ok_2_suiv_instr} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_ok_2_suiv_instr}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok_suivi_instr.prenom} ${args_signataire_case_ok_suivi_instr.nom}
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Rien à faire sur l'instruction ${id_instruction}

    # On vérifie qu'il y a bien le résultat
    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_case_ok_1_suiv_instr}

    # On vérifie que les 2 entrées (Permis de construire pour une maison individuelle et / ou ses annexes 
    # et Déclaration préalable) ont bien été créées dans le widget malgré leurs majuscules
    Element Should Contain  css=.widget_${om_widget} .widget-content-wrapper .widget-content  ${di_case_ok_1_suiv_instr}
    Element Should Contain  css=.widget_${om_widget} .widget-content-wrapper .widget-content  ${di_case_ok_2_suiv_instr}

    # L'instructeur secondaire ne dois pas avoir de résultat
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Element Should Contain  css=.widget_${om_widget} .widget-content
    ...  Il n'y a pas de documents pour le moment.


    # Test le filtre sur l'instructeur secondaire
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  statut_signature=in_progress;canceled\naffichage=liste\ntri=-6\nmessage_help=plop\nfiltre=instructeur_secondaire\nnb_max_resultat=20
    ...  ${om_widget}
    # L'instructeur ne dois pas avoir de résultat
    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget} .widget-content
    ...  Il n'y a pas de documents pour le moment.
    # L'instructeur secondaire a bien un résultat
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Element Should Contain  css=.widget_${om_widget}  ${di_case_ok_1_suiv_instr}


    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # On ajout un dossier et on met une instruction au statut "canceled"
    &{args_signataire_case_canceled_suivi_instr} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TEST140SIGNATURENOMSUIVINSTRCANCELED
    ...  prenom=TEST140SIGNATUREPRENOMSUIVINSTRCANCELED
    ...  qualite=TEST140SIGNATUREQUALITESUIVINSTRCANCELED
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ...  email=case3@test.test
    ${signataire_id} =  Ajouter le signataire depuis le menu  ${args_signataire_case_canceled_suivi_instr}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM9
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM9
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ${di_case_canceled_suiv_instr} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_canceled_suiv_instr}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_canceled_suivi_instr.prenom} ${args_signataire_case_canceled_suivi_instr.nom}
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  ${id_instruction} a bien été mise à jour

    # On vérifie que le paramétrage avec plusieurs statut fonctionne correctement
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  statut_signature=in_progress;canceled\naffichage=liste\ntri=-6\nmessage_help=plop\nnb_max_resultat=20
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_case_ok_1_suiv_instr}
    Element Should Contain  css=.widget_${om_widget}  ${di_case_canceled_suiv_instr}

    Depuis la page d'accueil  admin  admin

    ${arg_instr} =  Create Dictionary
    ...  instr_om_utilisateur_nom=Halil Zibr
    ...  instr_om_utilisateur_email=hzibr@openads-test.fr
    ...  instr_om_utilisateur_login=hzibr
    ...  instr_om_utilisateur_pwd=hzibr
    ...  division_libelle=Division JA
    Ajouter l'instructeur depuis le menu  ${arg_instr.instr_om_utilisateur_nom}  ${arg_instr.division_libelle}  instructeur  ${arg_instr.instr_om_utilisateur_nom}

    # On vérifie le bon fonctionnement du filtre instructeur ou division
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140SIGNATUREPETNOM10
    ...  particulier_prenom=TEST140SIGNATUREPETPRENOM10
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ${di_case_canceled_2_suiv_instr} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Permet d'afficher le select de la division sans avoir le nom de la division
    # derrière celui de l'instructeur
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    &{modifications} =  Create Dictionary
    ...  instructeur=Halil Zibr
    ...  division=Division JA
    Modifier le dossier d'instruction  ${di_case_canceled_2_suiv_instr}  ${modifications}

    # Réinitialisation des paramètres
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_afficher_division
    ...  click_value=LIBRECOM_WIDGET_SUIVI_INSTR
    Supprimer le paramètre (surcharge)  ${param_args}

    Ajouter une instruction au DI et la finaliser  ${di_case_canceled_2_suiv_instr}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_canceled_suivi_instr.prenom} ${args_signataire_case_canceled_suivi_instr.nom}
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  ${id_instruction} a bien été mise à jour

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  statut_signature=canceled\naffichage=liste\nfiltre=division\ntri=-6\nmessage_help=plop
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_case_canceled_suiv_instr}
    Element Should Contain  css=.widget_${om_widget}  ${di_case_canceled_2_suiv_instr}

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  statut_signature=canceled\naffichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nnb_max_resultat=20
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_case_canceled_suiv_instr}
    Element Should Not Contain  css=.widget_${om_widget}  ${di_case_canceled_2_suiv_instr}

    Depuis la page d'accueil  admin  admin
    # On vérifie qu'il n'y a pas de doublon dans le listing du "Voir +" du widget
    Ajouter une instruction au DI et la finaliser  ${di_case_canceled_suiv_instr}  affichage_obligatoire  signataire_arrete=${args_signataire_case_canceled_suivi_instr.prenom} ${args_signataire_case_canceled_suivi_instr.nom}
    ${id_instruction} =  Get Value  css=.form-content input#instruction
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Le document a été envoyé pour signature dans le parapheur.
    Portlet Action Should Not Be In SubForm  instruction  envoyer_a_signature
    ${json} =  Set Variable  {"module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  ${id_instruction} a bien été mise à jour

    Depuis la page d'accueil  oaamb  oaamb
    Click Link  css=.widget_${om_widget} .widget-footer a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.pageDescription  plop
    Element Should Contain  css=tr.odd  ${di_case_canceled_suiv_instr}
    Element Should Not Be Visible  css=tr.even
    # On vérifie qu'il n'y a pas d'erreur de bdd lors du tri sur une colonne
    Click Element  css=.col-6
    Wait Until Element Is Visible  css=tr.odd
    La page ne doit pas contenir d'erreur

    # On vérifie que le retour vers le listing à partir d'un dossier sélectionné fonctionne correctement
    Click Element  css=.consult-16
    Click On Back Button
    Wait Until Element Is Visible  css=.pageDescription
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.pageDescription  plop

    # Filtre Identifiant d'évènement (peut-être multi-valué)
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nevenement_id=30\nnb_max_resultat=20
    ...  ${om_widget}



    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140FILTREIDNOM
    ...  particulier_prenom=TEST140FILTREIDPRENOM
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ${di_3_suiv_instr} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Ajouter une instruction au DI et la finaliser  ${di_3_suiv_instr}  accepter un dossier avec reserve  signataire_arrete=${args_signataire_case_canceled_suivi_instr.prenom} ${args_signataire_case_canceled_suivi_instr.nom}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}


    # Filtre Type d’instruction (peut-être multi-valué)
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nevenement_type=arrete\nnb_max_resultat=20
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nevenement_type=arrete;affichage\nnb_max_resultat=20
    ...  ${om_widget}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140FILTREINSTRTYPENOM
    ...  particulier_prenom=TEST140FILTREINSTRTYPEPRENOM
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ${di_4_suiv_instr} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    ${date_event_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  3 days  result_format=%Y-%m-%d
    ${date_evenement} =  Convert Date  ${date_event_db}  result_format=%d/%m/%Y
    Ajouter une instruction au DI et la finaliser  ${di_4_suiv_instr}  affichage_obligatoire  false  ${date_evenement}  signataire_arrete=${args_signataire_case_canceled_suivi_instr.prenom} ${args_signataire_case_canceled_suivi_instr.nom}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_4_suiv_instr}

    # Filtre Instruction finalisée : oui / non / (pas de filtre si non remplit)
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\ninstruction_finalisee=true
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}

    Depuis la page d'accueil  admin  admin
    Depuis le contexte du widget  ${om_widget_libelle}
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\ninstruction_finalisee=false\nnb_max_resultat=20
    Click On Submit Button

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Not Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}

    # Filtre Instruction notifiée : oui / non / (pas de filtre si non remplit)
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\ninstruction_notifiee=false\nnb_max_resultat=20
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\ninstruction_notifiee=true\nnb_max_resultat=20
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Not Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}

    # Filtre Exclusion Identifiant d'évènement (peut-être multi-valué)
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nexclure_evenement_id=30\nnb_max_resultat=20
    ...  ${om_widget}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140FILTREIDNOM
    ...  particulier_prenom=TEST140FILTREIDPRENOM
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ${di_5_suiv_instr} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Ajouter une instruction au DI et la finaliser  ${di_5_suiv_instr}  accepter un dossier avec reserve  signataire_arrete=${args_signataire_case_canceled_suivi_instr.prenom} ${args_signataire_case_canceled_suivi_instr.nom}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Not Contain  css=.widget_${om_widget}  ${di_5_suiv_instr}

    # Filtre Statut du di
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nstatut_dossier=cloture\nnb_max_resultat=20
    ...  ${om_widget}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST140FILTREIDNOM
    ...  particulier_prenom=TEST140FILTREIDPRENOM
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ${di_6_suiv_instr} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Ajouter une instruction au DI et la finaliser  ${di_6_suiv_instr}  accepter un dossier avec reserve  signataire_arrete=${args_signataire_case_canceled_suivi_instr.prenom} ${args_signataire_case_canceled_suivi_instr.nom}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_6_suiv_instr}

    # Filtre Signataire : filtre selon le champ 'description' du signataire.
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nsignataire_description=Division H\nnb_max_resultat=20
    ...  ${om_widget}

    &{args_signataire_case_canceled_suivi_instr_modif} =  Create Dictionary
    ...  description=Division H
    Modifier signataire  ${signataire_id}  ${args_signataire_case_canceled_suivi_instr_modif}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}

    # Filtre État : filtre selon l’état du dossier (peut-être multi-valué)
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\netat=accepter\nnb_max_resultat=20
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\netat=notifier\nnb_max_resultat=20
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Not Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}

    # Filtre Nombre de jours avant la date limite d'instruction : ce filtre ne dois pas prendre en compte les dates limites d’incomplétudes.
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nnb_jours_avant_date_limite=3\nnb_max_resultat=20
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Not Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nnb_jours_avant_date_limite=150\nnb_max_resultat=20
    ...  ${om_widget}

    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_3_suiv_instr}


    # Vérifications du bon fonctionnement de la gestion de l'icone "alerte_5_jours"
    # du widget suivi instruction paramétrable
    # On ajoute 2 dossiers, l'un affichant l'icône, l'autre non
    ${om_widget} =  Set Variable  suivi_instruction_parametrable

    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nnb_jours_avant_date_limite=150\nnb_max_resultat=20\naffichage_colonne=alerte_5_jours
    ...  ${om_widget}

    ${current_date} =  Get Current Date  result_format=%d/%m/%Y

    # Affichage icone alerte 5 jours
    # Date du jour moins un mois et 25 jours -> alerte 5 jours affiché
    ${add5days} =  Add Time To Date  ${current_date}  5 days  %d/%m/%Y  True  %d/%m/%Y
    ${retranche2month25} =  Ajouter ou supprimer des mois à une date  -2  ${add5days}

    # Ajout dossier d'instruction qui affichera l'icône
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=dors
    ...  particulier_prenom=Jean
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ...  date_demande=${retranche2month25}
    ...  depot_electronique=true
    ${di_avec_alerte_5_jour} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Non affichage icone alerte 5 jours
    # Date du jour moins un mois et 24 jours -> alerte 5 jours absente
    ${add4days} =  Add Time To Date  ${current_date}  6 days  %d/%m/%Y  True  %d/%m/%Y
    ${retranche2month26} =  Ajouter ou supprimer des mois à une date  -2  ${add4days}

    # Ajout dossier d'instruction qui n'affichera pas l'icône
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=cercle
    ...  particulier_prenom=Jean
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_SUIVI_INSTR
    ...  date_demande=${retranche2month26}
    ...  depot_electronique=true
    ${di_sans_alerte_5_jour} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    
    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=.widget_${om_widget}  ${di_avec_alerte_5_jour}
    Element Should Contain  css=.widget_${om_widget}  ${di_sans_alerte_5_jour}

    # Vérification que l'icône alerte_5_jours est bien affiché pour le dossier correspondant
    ${icone_present}=  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Get Element Attribute  xpath=//a[normalize-space(text()) = '${di_avec_alerte_5_jour}']/ancestor::tr/td[contains(@class, 'col-10')]/a/img  src
    should be true  "${icone_present}" == "http://localhost/openads/app/img/enjeu-urba-16x16.png"

    # Vérification que l'icône alerte_5_jours n'est pas affiché pour le dossier correspondant
    ${icone_absent}=  Get Text  xpath=//a[normalize-space(text()) = '${di_sans_alerte_5_jour}']/ancestor::tr/td[contains(@class, 'col-10')]/a
    should be true  "${icone_absent}" == ""

    ## Test d'utilisation de l'argument 'tri_tab_widget'

    Depuis la page d'accueil  admin  admin

    # Ajout des colonnes 'instruction' et 'signataire' et ajout de l'argument 'tri_tab_widget' en 'instruction'
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nnb_jours_avant_date_limite=150\nnb_max_resultat=20\naffichage_colonne=signataire;instruction\ntri_tab_widget=instruction
    ...  ${om_widget}

    # Vérification de l'ordre du premier élément dans la colonne 'instruction', avec le tri appliqué
    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=div.widget-content table.tab-tab tr.tab-data td.col-3 a  accepter un dossier avec reserve 
    
    # Modification de l'argument 'tri_tab_widget' en '-instruction' : tri inverse attendu
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nnb_jours_avant_date_limite=150\nnb_max_resultat=20\naffichage_colonne=signataire;instruction\ntri_tab_widget=-instruction
    ...  ${om_widget}

    # Vérification de l'ordre du premier élément dans la colonne 'instruction', avec le tri inverse appliqué
    Depuis la page d'accueil  oaamb  oaamb
    Element Should Contain  css=div.widget-content table.tab-tab tr.tab-data td.col-3 a  affichage_obligatoire 



    # Filtre Nombre de jour maximum après la date d'évènement instruction :
    # Depuis la page d'accueil  admin  admin
    # Insérer les paramètres suivants dans le widget
    # ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nnb_jours_max_apres_date_evenement=3
    # ...  ${om_widget}

    # Depuis la page d'accueil  oaamb  oaamb
    # Element Should Contain  css=.widget_${om_widget}  ${di_4_suiv_instr}

    # Depuis la page d'accueil  admin  admin
    # Insérer les paramètres suivants dans le widget
    # ...  affichage=liste\nfiltre=instructeur\ntri=-6\nmessage_help=plop\nnb_jours_max_apres_date_evenement=5
    # ...  ${om_widget}

    # Depuis la page d'accueil  oaamb  oaamb
    # Element Should Not Contain  css=.widget_${om_widget}  ${di_4_suiv_instr}

    # Filtre Type de contrôle de légalité : Plat'AU / papier

    # Filtre Envoyé au contrôle de légalité : oui / non

Suppression du fichier de configuration du connecteur parapheur de test
    Remove File  ..${/}dyn${/}electronicsignature.inc.php

TNR recherche avancée du listing des signataires
    
    Depuis la page d'accueil  admin  admin

    # Paramètre l'appli pour renommer om_collectivite en service
    &{param_values} =  Create Dictionary
    ...  libelle=option_renommer_collectivite
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # Création d'une habilitation et d'un signataire ayant cette habilitation
    &{args_signataire_habilitation} =  Create Dictionary
    ...  libelle=habilitation test
    ...  Description=TEST
    ...  prenom=TEST140SIGNATUREPRENOM1
    ...  om_validite_debut=22/02/2022
    Ajouter signataire_habilitation  ${args_signataire_habilitation}

    ${current_date} =  Get Current Date  result_format=%d/%m/%Y
    ${nextDay} =  Add Time To Date  ${current_date}  1 days  %d/%m/%Y  True  %d/%m/%Y
    &{args_signataire} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=TNRNOM
    ...  prenom=TNRPRENOM
    ...  qualite=TNRQUALITE
    ...  signataire_habilitation=habilitation test
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=MARSEILLE
    ...  email=test@test.test
    ...  description=description test
    ...  om_validite_debut=22/02/2022
    ...  om_validite_fin=${nextDay}
    Ajouter le signataire depuis le menu  ${args_signataire}

    # Remplissage du formulaire de recherche avancé avec tous les champs
    Depuis le tableau des signataires
    Input Text  css=div#adv-search-adv-fields input#signataire_arrete  TNRPRENOM
    Input Text  css=div#adv-search-adv-fields input#qualite  TNRQUALITE
    Input Text  css=div#adv-search-adv-fields input#signataire_habilitation  habilitation test
    Select from list by label  css=div#adv-search-adv-fields select#defaut  Non
    Input Text  css=div#adv-search-adv-fields input#date_validite_debut_min  21/02/2022
    Input Text  css=div#adv-search-adv-fields input#date_validite_debut_max  ${nextDay}
    Input Text  css=div#adv-search-adv-fields input#date_validite_fin_min  ${nextDay}
    Input Text  css=div#adv-search-adv-fields input#date_validite_fin_max  ${nextDay}
    Input Text  css=div#adv-search-adv-fields input#email  test@test.test
    Input Text  css=div#adv-search-adv-fields input#description  description
    Select from list by label  css=div#adv-search-adv-fields select#om_collectivite  MARSEILLE
    # On valide le formulaire de recherche
    Click On Search Button
    La page ne doit pas contenir d'erreur

    Page Should Contain  TNRNOM

    # On vérifie que l'export traduit bien la colonne om_collectivite en service lorsque l'option est activée
    ${link_export_listing}=  Get Element Attribute  css=.tab-export a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link_export_listing}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    # On vérifie dans le fichier téléchargé que l'entête correspond à ce qui est attendu
    ${content_file} =  Get File  ${full_path_to_file}
    ${firstline_csv_file} =  Set Variable  signataire;civilité;nom;prénom;qualité;"type d'habilitation";défaut;"date de début de validité";"date de fin de validité";email;description;service;signature;"paramètre du parapheur";agrément;visa;code
    Should Contain  ${content_file}  ${firstline_csv_file}

    #Supprime le paramètre
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_renommer_collectivite
    ...  click_value=option_renommer_collectivite
    Supprimer le paramètre (surcharge)  ${param_values}
