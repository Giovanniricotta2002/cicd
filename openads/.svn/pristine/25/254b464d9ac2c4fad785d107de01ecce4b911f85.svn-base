*** Settings ***
Documentation  WS Resources REST.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Constitution du jeu de données
    [Documentation]  L'objet de ce TestCase est de constituer un jeu de données
    ...  cohérent pour les scénarios fonctionnels qui suivent.

    # Sauvegarde du script de configuration services.inc.php en cours d'utilisation
    # (supposé correct) avant remplacement par un script avec authentification incorrecte
    Delete All Sessions
    Move File  ..${/}dyn${/}services.inc.php  ..${/}dyn${/}services.inc.php.bak
    Copy File  ..${/}tests${/}binary_files${/}services_fail_auth.inc.php  ..${/}dyn${/}services.inc.php
    ${grep} =  Grep File  ..${/}dyn${/}services.inc.php   * // SERVICES_FAIL_AUTH
    Should Contain  ${grep}  * // SERVICES_FAIL_AUTH


REST
    [Documentation]  Pour chaque resource REST exposée, si la configuration est mauvaise on veut
    ...  que l'erreur soit catchée et nous renvoi un 500.

    # consultations/ PUT
    ${json} =  Set Variable  { "avis": "Favorable", "date_retour": "${DATE_FORMAT_dd/mm/yyyy}" }
    Vérifier le code retour du web service et vérifier que son message est  Put  consultations/123  ${json}  500  Erreur lors de la connexion au serveur.

    # dossier_autorisations/ PUT
    ${json} =  Set Variable  { "erp_ouvert": "oui", "date_arrete": "20/04/2013"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_autorisations/123  ${json}  500  Erreur lors de la connexion au serveur.

    # dossier_autorisations/ GET
    Vérifier le code retour du web service et vérifier que son message est  Get  dossier_autorisations/123  null  500  Erreur lors de la connexion au serveur.

    # dossier_instructions/ PUT
    ${json} =  Set Variable  { "message": "complet", "date": "${DATE_FORMAT_dd/mm/yyyy}"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/123  ${json}  500  Erreur lors de la connexion au serveur.

    # dossier_instructions/ GET
    Vérifier le code retour du web service et vérifier que son message est  Get  dossier_instructions/123  null  500  Erreur lors de la connexion au serveur.

    # maintenance/ POST
    ${json} =  Set Variable  { "module":"instruction"}
    Vérifier le code retour du web service et vérifier que son message est  Post  maintenance  ${json}  500  Erreur lors de la connexion au serveur.

    # messages/ POST
    ${json} =  Set Variable  { "type": "", "date": "", "emetteur": "", "dossier_instruction": "", "contenu": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  500  Erreur lors de la connexion au serveur.


Déconstitution du jeu de données
    [Documentation]  L'objet de ce TestCase est de repositionner le jeu de données
    ...  cohérent pour les TestSuite qui suivent.

    # Restauration du script de configuration services.inc.php précédemment sauvegardé
    Delete All Sessions
    Remove File  ..${/}dyn${/}services.inc.php
    Move File  ..${/}dyn${/}services.inc.php.bak  ..${/}dyn${/}services.inc.php
    ${grep} =  Grep File  ..${/}dyn${/}services.inc.php   * // SERVICES_PASS_AUTH
    Should Contain  ${grep}  * // SERVICES_PASS_AUTH

