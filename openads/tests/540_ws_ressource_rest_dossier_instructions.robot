*** Settings ***
Documentation  WS Ressource REST 'dossier_instructions'.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Constitution du jeu de données

    [Documentation]  Constitue le jeu de données.

    #
    Depuis la page d'accueil  admin  admin
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=LOUIS
    ...  particulier_prenom=Daniel
    ...  om_collectivite=MARSEILLE
    ...  particulier_date_naissance=20/10/1982
    ...  particulier_commune_naissance=Puyricard
    ...  particulier_departement_naissance=13
    ...  particulier_pays_naissance=France
    ...  numero=20
    ...  voie=rue du 14 juillet
    ...  complement=Bat A2
    ...  lieu_dit=Lambda
    ...  localite=Marseille
    ...  code_postal=13013
    ...  bp=13099
    ...  cedex=13010
    ...  pays=France
    ...  division_territoriale=DH3
    ...  telephone_fixe=0406042266
    ...  telephone_mobile=0622334123
    ...  indicatif=33
    ...  courriel=d.louis@wanadoo.fr
    ...  fax=0406042270

    @{ref_cad} =  Create List  810  A  0020  A  0022
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_voie_numero=10
    ...  terrain_adresse_lieu_dit=Les Baïsses
    ...  terrain_adresse_code_postal=13333
    ...  terrain_adresse_voie=rue du 14 juillet
    ...  terrain_adresse_localite=Marseille
    ...  terrain_adresse_bp=13380
    ...  terrain_adresse_cedex=13366
    ...  terrain_superficie=22
    ...  terrain_references_cadastrales=${ref_cad}

    #
    ${di}  ${demandeur_id} =  Ajouter la nouvelle demande et récupérer le numéro de pétitionnaire  ${args_demande}  ${args_petitionnaire}
    ${di_id} =  Sans espace  ${di}
    Set Suite Variable  ${di}
    Set Suite Variable  ${di_id}
    Set Suite Variable  ${demandeur_id}

    Ajouter une instruction au DI  ${di}  ARRÊTÉ DE REFUS
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click On Link  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  finaliser
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    &{donnees_techniques_values} =  Create Dictionary
    ...  co_tot_log_nb=52
    ...  am_lot_max_nb=100
    ...  am_empl_nb=23
    ...  co_cstr_exist=t
    ...  co_uti_pers=t
    ...  co_uti_vente=t
    ...  co_uti_loc=t
    # Données techniques du dossiers pour le tableau des surfaces
    &{donnees_techniques_surfaces_values} =  Create Dictionary
    ...  su_avt_shon1=10
    ...  su_avt_shon2=10
    ...  su_avt_shon3=10
    ...  su_avt_shon4=10
    ...  su_avt_shon5=10
    ...  su_avt_shon6=10
    ...  su_avt_shon7=10
    ...  su_avt_shon8=10
    ...  su_avt_shon9=10
    ...  su_cstr_shon1=10
    ...  su_cstr_shon2=10
    ...  su_cstr_shon3=10
    ...  su_cstr_shon4=10
    ...  su_cstr_shon5=10
    ...  su_cstr_shon6=10
    ...  su_cstr_shon7=10
    ...  su_cstr_shon8=10
    ...  su_cstr_shon9=10

    Saisir les données techniques du DI  ${di}  ${donnees_techniques_values}
    Modifier les données techniques pour le calcul des surfaces  ${di}  ${donnees_techniques_surfaces_values}



REST

    [Documentation]  Ce TestCase vérifie la partie REST du WS
    ...  - les méthodes non disponibles doivent retourner un code 400,
    ...  - vérifie le retour complet du web service dossier_instructions
    ...  - les clés suivantes sont obligatoires dans le tableau JSON : type, date, emetteur, dossier_instruction, contenu. Si une des clés n'est pas présente ou si il y a une clé supplémentaire dans les données d'entrées, le WS doit retourner un code 400.

    ## Seule la méthode PUT doit être disponible sur cette ressource
    ${json} =  Set Variable  { "message": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  dossier_instructions  ${json}  400  La méthode POST n'est pas disponible sur cette ressource.
    Vérifier le code retour du web service et vérifier que son message est  Delete  dossier_instructions/123  null  400  La méthode DELETE n'est pas disponible sur cette ressource.

    # Récupération du JSON depuis un fichier, et remplacement des champs variables
    ${json_return} =  Get File  binary_files/tests_services/web_service_dossier_instruction.json
    ${da_id} =  Get Substring  ${di_id}  0  -2
    ${json_return} =  STR_REPLACE  "dossier_instruction": "",  "dossier_instruction": "${di_id}",  ${json_return}
    ${json_return} =  STR_REPLACE  "dossier_autorisation": "",  "dossier_autorisation": "${da_id}",  ${json_return}

    ${json_return} =  STR_REPLACE  "demandeur": "",  "demandeur": "${demandeur_id}",  ${json_return}
    ${date_jour} =  Date du jour au format yyyy-mm-dd
    ${json_return} =  STR_REPLACE  "date_depot_initial": "",  "date_depot_initial": "${date_jour}",  ${json_return}
    ${json_return} =  STR_REPLACE  "date_decision": "",  "date_decision": "${date_jour}",  ${json_return}

    Depuis le contexte du dossier d'instruction  ${di}
    ${date_limite_dd/mm/yyy} =  Get text  date_limite
    ${date_limite_yyyy-mm-dd} =  Convertir une date du format dd/mm/yyyy au format yyyy-mm-dd  ${date_limite_dd/mm/yyy}
    ${json_return} =  STR_REPLACE  "date_limite_instruction": "",  "date_limite_instruction": "${date_limite_yyyy-mm-dd}",  ${json_return}

    Vérifier le code retour et la réponse JSON du web service  Get  dossier_instructions/${di_id}  null  200  ${json_return}

    ## L'identifiant est obligatoire
    # On ne fourni pas de numéro de dossier d'instruction
    ${json} =  Set Variable  { "message": "complet", "date": "${DATE_FORMAT_dd/mm/yyyy}"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions  ${json}  400  Aucun identifiant fourni pour la ressource.
    Vérifier le code retour du web service et vérifier que son message est  Get  dossier_instructions  null  400  Aucun identifiant fourni pour la ressource.

    ## Deux clés sont obligatoires
    # sans la clé 'date'
    ${json} =  Set Variable  { "message": ""}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/123  ${json}  400  La structure des données reçues n'est pas correcte.
    # sans la clé 'message'
    ${json} =  Set Variable  { "date": ""}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/123  ${json}  400  La structure des données reçues n'est pas correcte.

    ## Aucune clé supplémentaire autorisée
    # avec une clé supplémentaire
    ${json} =  Set Variable  { "message": "", "date": "", "plop": ""}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/123  ${json}  400  La structure des données reçues n'est pas correcte.


Métier

    [Documentation]  Ce TestCase vérifie la partie Métier du WS
    ...  - ...

    ##
    # On essaye de mettre à jour un dossier qui n'existe pas
    ${json} =  Set Variable  { "message": "complet", "date": "${DATE_FORMAT_dd/mm/yyyy}"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/LOREM  ${json}  400  Ce dossier n'existe pas

    # On essaye de mettre à jour un dossier qui existe mais n'est pas un AT
    ${json} =  Set Variable  { "message": "complet", "date": "${DATE_FORMAT_dd/mm/yyyy}"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/${di_id}  ${json}  400  Ce dossier n'est pas un dossier de type AT

    # On essaye de mettre à jour un dossier AT en cours d'instruction
    ${json} =  Set Variable  { "message": "complet", "date": "${DATE_FORMAT_dd/mm/yyyy}"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/AT0130551300001P0  ${json}  200  Mise à jour des données realisées avec succès

    # On essaye de mettre à jour un dossier sans message
    ${json} =  Set Variable  { "message": "", "date": "${DATE_FORMAT_dd/mm/yyyy}"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/AT0130551300001P0  ${json}  400  Aucun message fourni

    # On essaye de mettre à jour un dossier avec un message qui existe pas
    ${json} =  Set Variable  { "message": "test", "date": "${DATE_FORMAT_dd/mm/yyyy}"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/AT0130551300001P0  ${json}  400  Message fourni incorrect

    # On essaye de mettre à jour un dossier sans date
    ${json} =  Set Variable  { "message": "complet", "date": null }
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/AT0130551300001P0  ${json}  400  Aucune date fournie

    # On essaye de mettre à jour un dossier avec une date mal formatée
    ${json} =  Set Variable  { "message": "complet", "date": "23/2014"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/AT0130551300001P0  ${json}  400  Date fournie au mauvais format

    # On essaye de mettre à jour un dossier AT pour le cloturer
    ${json} =  Set Variable  { "message": "clos", "date": "${DATE_FORMAT_dd/mm/yyyy}"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_instructions/AT0130551300001P0  ${json}  200  Mise à jour des données realisées avec succès
