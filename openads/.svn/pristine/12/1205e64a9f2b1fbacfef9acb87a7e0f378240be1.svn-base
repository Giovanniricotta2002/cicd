*** Settings ***
Documentation  WS Ressource REST 'maintenance' avec stockage indisponible.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Custom Setup

    Move File  ..${/}dyn${/}filestorage.inc.php  ..${/}dyn${/}filestorage.inc.php.bak
    Copy File  ..${/}tests${/}binary_files${/}down_filestorage.inc.php
    ...  ..${/}dyn${/}filestorage.inc.php


Appel les APIs de maintenance avec le stockage indisponible.

    # services impactés par le stockage (GED) indisponible

    Activer l'option de numérisation

    ${json} =  Set Variable  {"module":"import"}
    # Note: obligation de forcer la répétition de ce mot clé jusqu'à ce qu'il réussisse à cause d'un
    #       bug dans PHP (sorte de "race condition") qui empêche aléatoirement la prise en compte des
    #       fichiers de config déplacés ci-dessus (juste avant dans la chronologie) !!
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Vérifier le code retour du web service et vérifier que son message au format string contient
    ...  Post  maintenance  ${json}  500  Service de stockage des documents indisponible

    ${json} =  Set Variable  { "module":"purge"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  500  Service de stockage des documents indisponible

    ${json} =  Set Variable  { "module":"maj_metadonnees_documents_numerises"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  500  Service de stockage des documents indisponible

    Désactiver l'option de numérisation

    &{param_values} =  Create Dictionary
    ...  libelle=option_suivi_numerisation
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    ${json} =  Set Variable  { "module":"add_suivi_numerisation"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  500  Service de stockage des documents indisponible

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_suivi_numerisation
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

    ${json} =  Set Variable  { "module":"update_parapheur_datas"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  500  Service de stockage des documents indisponible

    ${json} =  Set Variable  { "module":"instruction"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  500  Service de stockage des documents indisponible

    # services NON impactés par le stockage (GED) indisponible

    ${json} =  Set Variable  { "module":"user"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  200  Synchronisation terminée

    ${json} =  Set Variable  { "module":"consultation"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  200  consultations mise(s) à jour

    ${json} =  Set Variable  { "module":"update_dossier_autorisation"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  200  Aucune mise à jour
    #...  Post  maintenance  ${json}  200  dossier(s) d'autorisation(s) mis à jour

    # TODO: configurer un SIG pour qu'il puisse y avoir la synchro des contraintes
    #${json} =  Set Variable  { "module":"contrainte"}
    #Vérifier le code retour du web service et vérifier que son message contient
    #...  Post  maintenance  ${json}  200  ?

    # TODO: configurer un SIG pour qu'il puisse y avoir la géoloc'
    #${json} =  Set Variable  { "module":"update_missing_geolocation"}
    #Vérifier le code retour du web service et vérifier que son message contient
    #...  Post  maintenance  ${json}  200  ?

    # services NON testable avec le stockage (GED) indisponible (le connecteur doit forcément être 'filesystem')

    ${json} =  Set Variable  { "module":"purge_orphans_files_filesystem"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  500  Stockage des documents effectué sur un support différent du filesystem

    ${json} =  Set Variable  { "module":"get_uids_without_files"}
    Vérifier le code retour du web service et vérifier que son message contient
    ...  Post  maintenance  ${json}  500  Stockage des documents effectué sur un support différent du filesystem


Appel du webservice de traitement des tâches avec le stockage indisponible.

    ${resp} =  Déclencher le traitement des tâches par WS et retourner la réponse
    ${status} =  Run Keyword And Return Status  Should Be Equal  '${resp.status_code}'  '500'
    Run Keyword If  '${status}' != 'True'  Log  ${resp.status_code}  WARN
    Run Keyword If  '${status}' != 'True'  Log  ${resp.content}  WARN

    # décode le corps de la réponse supposément formatté en JSON
    ${status} =  Run Keyword And Return Status  To Json  ${resp.content}
    Run Keyword If  '${status}' != 'True'  Log  ${resp.content}  WARN
    ${data} =  To Json  ${resp.content}

    Should Be Equal  '${data["http_code"]}'  '500'
    Should Be Equal  '${data["message"]}'  'Service de stockage des documents indisponible'


Custome Teardown

    Remove File  ..${/}dyn${/}filestorage.inc.php
    Move File  ..${/}dyn${/}filestorage.inc.php.bak  ..${/}dyn${/}filestorage.inc.php
