*** Settings ***
Documentation  WS Ressource REST 'maintenance'.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Constitution du jeu de données

    [Documentation]  On teste le formulaire de géolocalisation automatique par
    ...  lots de dossiers d'instruction. Les tests suivants sont effectués en
    ...  multicollectivité et en monocollectivité :
    ...  - 1 dossier où la vérification des parcelles échoue
    ...  - 1 dossier où le calcul de l'emprise échoue
    ...  - 1 dossier où le calcul du centroïde échoue
    ...  - 1 dossier où la géolocalisation automatique est un succès.

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  option_sig  sig_externe  agglo
    Ajouter la collectivité depuis le menu  Americity  mono
    Ajouter le paramètre depuis le menu  departement  066  Americity
    Ajouter le paramètre depuis le menu  commune  333  Americity
    Ajouter le paramètre depuis le menu  insee  66333  Americity
    Ajouter la collectivité depuis le menu  Brittown  mono
    Ajouter le paramètre depuis le menu  departement  099  Brittown
    Ajouter le paramètre depuis le menu  commune  555  Brittown
    Ajouter le paramètre depuis le menu  insee  99555  Brittown

    &{om_param} =  Create Dictionary
    ...  libelle=option_notification_piece_numerisee
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lincolns
    ...  particulier_prenom=Abraham
    ...  om_collectivite=Americity
    @{ref_cad} =  Create List  999  WW  0001
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Americity
    ...  date_demande=05/06/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_A} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Windsor
    ...  particulier_prenom=Elisabeth
    ...  om_collectivite=Brittown
    @{ref_cad} =  Create List  999  WW  0002
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Brittown
    ...  date_demande=05/06/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_B} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

Vérification que tous les types de fichiers openADS puissent être importés
    [Documentation]  Vérifie que tous les types de fichiers
    ...  openADS puissent être importés (et non uniquement les PDF)

    Activer l'option de numérisation

    # Création d'un dossier dans le répertoire 'Todo'
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Type_Fichiers
    ...  particulier_prenom=Dossier
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${dossier} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    
    ${dossier_sans_espace} =  Sans Espace  ${dossier}
    Create Directory  ..${/}var${/}digitalization${/}Todo${/}${dossier_sans_espace}
    Run  chmod 777 -R ..${/}var${/}digitalization${/}Todo${/}${dossier_sans_espace}
    
    # Création d'un fichier dont l'extension (non-PDF) est admise sur openADS
    # Le nom de fichier doit être composé selon DATE ABREGE INCREMENT | YYYYMMDDABREGE-12
    
    Create File  ..${/}var${/}digitalization${/}Todo${/}${dossier_sans_espace}${/}20121212111.doc  Fichier de vérification des types de fichiers pour imports
    Run  chmod 777 -R ..${/}var${/}digitalization${/}Todo${/}${dossier_sans_espace}${/}20121212111.doc

    # Création d'un fichier dont l'extension est en PDF
    # Le nom de fichier doit être composé selon DATE ABREGE INCREMENT | YYYYMMDDABREGE-12
    
    Create File  ..${/}var${/}digitalization${/}Todo${/}${dossier_sans_espace}${/}20121212111.PDF  Fichier de vérification des types de fichiers pour imports
    Run  chmod 777 -R ..${/}var${/}digitalization${/}Todo${/}${dossier_sans_espace}${/}20121212111.PDF
    
    # Import du fichier par Web Service
    ${json} =  Set Variable  {"module":"import"}
    Vérifier le code retour du web service et vérifier que son message au format string contient  Post  maintenance  ${json}  200  Tous les documents ont été traités

    ${fileExists}=  File Should Exist  ..${/}var${/}digitalization${/}Done${/}${dossier_sans_espace}${/}20121212111.doc
    ${fileExists}=  File Should Exist  ..${/}var${/}digitalization${/}Done${/}${dossier_sans_espace}${/}20121212111.PDF
   
    # Rétablissement du paramétrage d'origine
    Désactiver l'option de numérisation
    # Remove File  ..${/}var${/}digitalization${/}Todo${/}${dossier_sans_espace}${/}20121212111.doc
    # Remove Directory  ..${/}var${/}digitalization${/}Todo${/}${dossier_sans_espace}

REST
    [Documentation]  Ce TestCase vérifie la partie REST du WS.
    ...  - la seule méthode disponible est le POST, les autres doivent retourner un code 400,
    ...  - l'attribut "module" est obligatoire et ne doit pas être vide

    ## Seule la méthode POST doit être disponible sur cette ressource
    ${json} =  Set Variable  { "module": "" }
    Vérifier le code retour du web service et vérifier que son message est  Get  maintenance/123  ${json}  400  La méthode GET n'est pas disponible sur cette ressource.
    Vérifier le code retour du web service et vérifier que son message est  Put  maintenance/123  ${json}  400  La méthode PUT n'est pas disponible sur cette ressource.
    Vérifier le code retour du web service et vérifier que son message est  Delete  maintenance/123  ${json}  400  La méthode DELETE n'est pas disponible sur cette ressource.

    ## L'attribut "module" est obligatoire et ne doit pas être vide
    ${json} =  Set Variable  { "existpas" : "instruction" }
    Vérifier le code retour du web service et vérifier que son message est  Post  maintenance  ${json}  400  Le format des données reçues n'est pas correct.
    ${json} =  Set Variable  { "module" : "" }
    Vérifier le code retour du web service et vérifier que son message est  Post  maintenance  ${json}  400  Le format des données reçues n'est pas correct.


Métier
    [Documentation]  Ce TestCase vérifie la partie Métier du WS

    # Le module doit exister
    ${json} =  Set Variable  { "module" : "existpas", "data" : "" }
    Vérifier le code retour du web service et vérifier que son message est  Post  maintenance  ${json}  400  Le module demandé n'existe pas


Métier - Géolocalisation automatique des dossiers d'instruction
    [Documentation]  Ce TestCase vérifie la partie Métier du WS
    ...  le contenu du message est conforme dans les cas:
    ...  - DI géocodé avec succès
    ...  - DI en erreur

    ##
    # essai avec un DI dont le geocodage s'effectue avec succès
    ${json} =  Set Variable  { "module":"update_missing_geolocation"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Americity ::1 dossier(s) d'instruction a(ont) été géolocalisé(s),;

    ##
    # essai avec un DI en erreur au calcul de l'emprise
    ${json} =  Set Variable  { "module":"update_missing_geolocation"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Brittown ::1 dossier(s) d'instruction n'a(ont) pas pu être géolocalisé(s),

    Supprimer le paramètre  option_sig

    Remove File  ..${/}dyn${/}sig.inc.php


Métier - Récupération des dossiers d'instruction pour le suivi de numérisation
    [Documentation]

    # Isolation du contexte
    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=FREECITY550
    ...  departement=013
    ...  commune=550
    ...  insee=13550
    ...  direction_code=I
    ...  direction_libelle=Direction de FREECITY550
    ...  direction_chef=Chef
    ...  division_code=I
    ...  division_libelle=Division I
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Thierry Bouvier
    ...  guichet_om_utilisateur_email=tbouvier@openads-test.fr
    ...  guichet_om_utilisateur_login=tbouvier
    ...  guichet_om_utilisateur_pwd=tbouvier
    ...  instr_om_utilisateur_nom=Colette Frechette
    ...  instr_om_utilisateur_email=cfrechette@openads-test.fr
    ...  instr_om_utilisateur_login=cfrechette
    ...  instr_om_utilisateur_pwd=cfrechette
    Isolation d'un contexte  ${isolation_values}
    &{param_values_1} =  Create Dictionary
    ...  libelle=option_suivi_numerisation
    ...  valeur=true
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values_1}
    &{param_values_2} =  Create Dictionary
    ...  libelle=numerisation_type_dossier_autorisation
    ...  valeur='PCI','PCA'
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values_2}
    &{param_values_3} =  Create Dictionary
    ...  libelle=numerisation_intervalle_date
    ...  valeur=300
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values_3}

    # Ajout des dossiers d'instruction
    &{args_petitionnaire_1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire Corp.
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Paradis
    ...  personne_morale_prenom=Xavier
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di_ok_1} =  Ajouter la demande par WS  ${args_demande_1}  ${args_petitionnaire_1}
    ${di_ok_1} =  Sans espace  ${libelle_di_ok_1}
    #
    &{args_petitionnaire_2} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Rhéaume
    ...  particulier_prenom=Philippine
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di_ok_2} =  Ajouter la demande par WS  ${args_demande_2}  ${args_petitionnaire_2}
    ${di_ok_2} =  Sans espace  ${libelle_di_ok_2}
    #
    &{args_petitionnaire_3} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Cailot
    ...  particulier_prenom=Ophelia
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande_3} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di_ko_1} =  Ajouter la demande par WS  ${args_demande_3}  ${args_petitionnaire_3}
    ${di_ko_1} =  Sans espace  ${libelle_di_ko_1}
    #
    ${date_di_ko_2_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  301 days  result_format=%Y-%m-%d
    ${date_di_ko_2} =  Convert Date  ${date_di_ko_2_db}  result_format=%d/%m/%Y
    &{args_petitionnaire_4} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire Corp.
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Paradis
    ...  personne_morale_prenom=Xavier
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande_4} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_di_ko_2}
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di_ko_2} =  Ajouter la demande par WS  ${args_demande_4}  ${args_petitionnaire_4}
    ${di_ko_2} =  Sans espace  ${libelle_di_ko_2}
    #
    Depuis le contexte de la collectivité  ${isolation_values.om_collectivite_libelle}
    ${om_collectivite} =  Get Text  css=span#om_collectivite

    ${json} =  Set Variable  {"module":"add_suivi_numerisation", "data":[{"om_collectivite":"${om_collectivite}"}]}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Opération terminée : 2 dossiers importés

    ${json} =  Set Variable  {"module":"add_suivi_numerisation", "data":[{"om_collectivite":""}]}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  500  Veuillez renseigner l'identifiant de la collectivité

    ${json} =  Set Variable  {"module":"add_suivi_numerisation", "data":[{"om_collectivite":"1"}]}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  500  Les paramètres requis pour l'utilisation du suivi de numérisation ne sont pas renseignés

    ${json} =  Set Variable  {"module":"add_suivi_numerisation", "data":[{"om_collectivite":"${om_collectivite}", "numerisation_intervalle_date":"350"}]}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Opération terminée : 1 dossiers importés

    ${json} =  Set Variable  {"module":"add_suivi_numerisation", "data":[{"om_collectivite":"${om_collectivite}", "numerisation_type_dossier_autorisation":"'DP'"}]}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Opération terminée : 1 dossiers importés

    # Suppression du paramétrage
    &{param_args_1} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_suivi_numerisation
    ...  click_value=${isolation_values.om_collectivite_libelle}
    Supprimer le paramètre (surcharge)  ${param_args_1}
    &{param_args_2} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=numerisation_type_dossier_autorisation
    ...  click_value=${isolation_values.om_collectivite_libelle}
    Supprimer le paramètre (surcharge)  ${param_args_2}
    &{param_args_3} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=numerisation_intervalle_date
    ...  click_value=${isolation_values.om_collectivite_libelle}
    Supprimer le paramètre (surcharge)  ${param_args_3}


Métier - Purge des fichiers orphelins
    [Documentation]  Purge des fichiers orphelins.

    Copy Directory  ..${/}tests${/}binary_files${/}filestorage_test  ..${/}var${/}
    Move File  ..${/}dyn${/}filestorage.inc.php  ..${/}dyn${/}filestorage.inc.php.bak
    Copy File  ..${/}tests${/}binary_files${/}filestorage_3.inc.php  ..${/}dyn${/}
    Move File  ..${/}dyn${/}filestorage_3.inc.php  ..${/}dyn${/}filestorage.inc.php


    #Isolation du contexte
    Depuis la page d'accueil  admin  admin
    Ajouter la collectivité depuis le menu  FREECITY550-1  mono
    Ajouter le paramètre depuis le menu  departement  032  FREECITY550-1
    Ajouter le paramètre depuis le menu  commune  098  FREECITY550-1
    Ajouter le paramètre depuis le menu  insee  32098  FREECITY550-1

    # Le dossier doit être transmissible pour que le service soit ajouté
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST550NOM
    ...  particulier_prenom=TEST550PRENOM
    ...  om_collectivite=FREECITY550-1

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=FREECITY550-1

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=autres pièces composant le dossier (A0)

    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    &{service} =  Create Dictionary
    ...  abrege=TS550
    ...  libelle=TEST 550 PFO
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=FREECITY550-1
    Ajouter le service depuis le listing  ${service}
    Ajouter une consultation depuis un dossier  ${di}  ${service.abrege} - ${service.libelle}
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  recepisse

    ${json} =  Set Variable  { "module":"purge_orphans_files_filesystem"}
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json}  200  Suppression de

    # Rétablissement du paramétrage
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    Remove File  ..${/}dyn${/}filestorage.inc.php
    Move File  ..${/}dyn${/}filestorage.inc.php.bak  ..${/}dyn${/}filestorage.inc.php

Rétablissement des paramètres
    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification_piece_numerisee
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
