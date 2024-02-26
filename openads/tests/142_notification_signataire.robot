*** Settings ***
Documentation     Notification du signataire

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
    ...  om_collectivite_libelle=Collectivité-NOTIFSIGN
    ...  departement=018
    ...  commune=001
    ...  insee=18001
    ...  direction_code=G
    ...  direction_libelle=Direction de Collectivité-NOTIFSIGN
    ...  direction_chef=Chef
    ...  division_code=G
    ...  division_libelle=Division NS
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Imbé Signe
    ...  guichet_om_utilisateur_email=isigne@openads-test.fr
    ...  guichet_om_utilisateur_login=isigne
    ...  guichet_om_utilisateur_pwd=isigne
    ...  instr_om_utilisateur_nom=So Signe
    ...  instr_om_utilisateur_email=ssigne@openads-test.fr
    ...  instr_om_utilisateur_login=ssigne
    ...  instr_om_utilisateur_pwd=ssigne
    Isolation d'un contexte  ${collectivite_values}
    Set Suite Variable  ${collectivite_values}

    # Ajout d'un signataire
    &{args_signataire} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=Signataire-NOTIFSIGN-nom
    ...  prenom=Signataire-NOTIFSIGN-prénom
    ...  qualite=Signataire-NOTIFSIGN-qualité
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=Collectivité-NOTIFSIGN
    ...  email=signataire-notifsign-1@test.test
    Ajouter le signataire depuis le menu  ${args_signataire}
    Set Suite Variable  ${args_signataire}


Activation de la capture des mails
    [Documentation]  Active la capture des mails
    Depuis la page d'accueil  admin  admin
    Démarrer maildump


Vérifie l'envoi d'une notification au signataire lorsque le parapheur ne le supporte pas

    Depuis la page d'accueil  admin  admin

    # ajoute un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pétitionaire-NOTIFSIGN-nom
    ...  particulier_prenom=Pétitionaire-NOTIFSIGN-prénom
    ...  om_collectivite=Collectivité-NOTIFSIGN
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-NOTIFSIGN
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  ssigne  ssigne

    # ajoute une instruction au dossier associée au signataire
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

    # vérifie que le champ 'parapheur_lien_page_signature' est bien rempli
    Page Should Contain Element  css=#parapheur_lien_page_signature
    Element Should Not Be visible  css=#parapheur_lien_page_signature
    ${lien} =  Get Value  css=#parapheur_lien_page_signature
    Should Be Equal  ${lien}  http://localhost/test-notif-signataire

    # vérifie qu'un mail a bien été envoyé à destination du signataire
    Verifier que le mail a bien été envoyé au destinataire  ${args_signataire.email}
    Vérifier le contenu du mail  ${args_signataire.email}  http://localhost/test-notif-signataire


# TODO: Vérifie l'absence de traitement lorsque le parapheur support la notification mail

# TODO: Vérifie l'absence d'erreur et de traitement lorsque le parapheur ne précise pas le support
# de la notification

# TODO: Vérifie l'absence de blocage et le message d'erreur en cas d'erreur ou d'exception


Suppression du fichier de configuration du connecteur parapheur de test
    Remove File  ..${/}dyn${/}electronicsignature.inc.php

Désactivation de la capture des mails
    [Documentation]  Désactive la capture des mails
    Depuis la page d'accueil  admin  admin
    Arrêter maildump

