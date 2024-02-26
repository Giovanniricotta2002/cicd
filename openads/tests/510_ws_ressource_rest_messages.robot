*** Settings ***
Documentation  WS Ressource REST 'messages'.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Constitution du jeu de données

    [Documentation]  Constitue le jeu de données.

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=LOUIS
    ...  particulier_prenom=Daniel
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_id} =  Sans espace  ${di}
    Set Suite Variable  ${di_id}


REST

    [Documentation]  Ce TestCase vérifie la partie REST du WS
    ...  - la seule méthode disponible est le POST, les autres doivent retourner un code 400,
    ...  - les clés suivantes sont obligatoires dans le tableau JSON : type, date, emetteur, dossier_instruction, contenu. Si une des clés n'est pas présente ou si il y a une clé supplémentaire dans les données d'entrées, le WS doit retourner un code 400.

    ## Seule la méthode POST doit être disponible sur cette ressource
    ${json} =  Set Variable  { "type": ""}
    Vérifier le code retour du web service et vérifier que son message est  Get  messages/123  ${json}  400  La méthode GET n'est pas disponible sur cette ressource.
    Vérifier le code retour du web service et vérifier que son message est  Put  messages/123  ${json}  400  La méthode PUT n'est pas disponible sur cette ressource.
    Vérifier le code retour du web service et vérifier que son message est  Delete  messages/123  ${json}  400  La méthode DELETE n'est pas disponible sur cette ressource.

    ## Cinq clés sont obligatoires
    # sans la clé 'contenu'
    ${json} =  Set Variable  { "type": "", "date": "", "emetteur": "", "dossier_instruction": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  La structure des données reçues n'est pas correcte.
    # sans la clé 'dossier_instruction'
    ${json} =  Set Variable  { "type": "", "date": "", "emetteur": "", "contenu": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  La structure des données reçues n'est pas correcte.
    # sans la clé 'emetteur'
    ${json} =  Set Variable  { "type": "", "date": "", "dossier_instruction": "", "contenu": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  La structure des données reçues n'est pas correcte.
    # sans la clé 'date'
    ${json} =  Set Variable  { "type": "", "emetteur": "", "dossier_instruction": "", "contenu": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  La structure des données reçues n'est pas correcte.
    # sans la clé 'type'
    ${json} =  Set Variable  { "date": "", "emetteur": "", "dossier_instruction": "", "contenu": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  La structure des données reçues n'est pas correcte.

    ## Aucune clé supplémentaire autorisée
    # avec une clé supplémentaire
    ${json} =  Set Variable  { "type": "", "date": "", "emetteur": "", "dossier_instruction": "", "contenu": "", "plop": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  La structure des données reçues n'est pas correcte.


Métier

    [Documentation]  Ce TestCase vérifie la partie Métier du WS
    ...  - le type est conforme
    ...  - le contenu est conforme
    ...  - le dossier d'instruction existe
    ...  - la date est valide

    ##
    # essai avec un type de message qui n'existe pas
    ${json} =  Set Variable  { "type": "", "date": "12/06/2016 12:00", "emetteur": "instr", "dossier_instruction": "${di_id}", "contenu": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  Le type de message n'est pas correct.

    ##
    # essai avec un type de message qui ne correspond pas aux clés présentes dans 'contenu'
    ${json} =  Set Variable  { "type": "ERP_ADS__PC__INFORMATION_COMPLETUDE_ERP_ACCESSIBILITE", "date": "12/06/2016 12:00", "emetteur": "instr", "dossier_instruction": "${di_id}", "contenu": { "Dossier à enjeux ERP": ""}}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  Le contenu du message n'est pas correct.
    # essai avec une valeur du contenu qui ne correspodn pas à une valeur attendue
    ${json} =  Set Variable  { "type": "ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP", "date": "12/06/2016 12:00", "emetteur": "instr", "dossier_instruction": "${di_id}", "contenu": { "Dossier à enjeux ERP": ""}}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  Le contenu du message n'est pas correct.
    # essai avec du contenu supplémentaire
    ${json} =  Set Variable  { "type": "ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP", "date": "12/06/2016 12:00", "emetteur": "instr", "dossier_instruction": "${di_id}", "contenu": { "Dossier à enjeux ERP": "Oui", "plop": ""}}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  Le contenu du message n'est pas correct.

    ##
    # essai avec un dossier d'instruction qui n'existe pas
    ${json} =  Set Variable  { "type": "ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP", "date": "12/06/2016 12:00", "emetteur": "instr", "dossier_instruction": "", "contenu": { "Dossier à enjeux ERP": "Oui"}}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  Le dossier spécifié dans le message n'existe pas.

    ##
    # essai avec une date incorrecte
    ${json} =  Set Variable  { "type": "ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP", "date": "", "emetteur": "instr", "dossier_instruction": "${di_id}", "contenu": { "Dossier à enjeux ERP": "Oui"}}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  400  La date n'est pas correcte.

    ##
    #
    ${json} =  Set Variable  { "type": "ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP", "date": "12/06/2016 12:00", "emetteur": "instr", "dossier_instruction": "${di_id}", "contenu": { "Dossier à enjeux ERP": "Oui"}}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  200  Insertion du message 'ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP' OK.


