*** Settings ***
Documentation    Menu Administration
# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown


*** Test Cases ***
Synchronisation des utilisateurs avec un annuaire LDAP

    [Documentation]  On teste la synchronisation des utilisateurs avec le ldap
    ...  Les utilisateurs qui devront être ajoutés et mis à jour :
    ...  einstein, newton, galieleo, tesla
    ...  Et les utilisateurs qui devront être supprimés :
    ...  ldap_instructeur et ldap_service

    #
    Depuis la page d'accueil  admin  admin
    # On accède à l'écran de synchronisation via le menu
    Go To Submenu In Menu  administration  annuaire
    # On vérifie le titre de l'écran
    Page Title Should Be  Administration > Gestion Des Utilisateurs > Utilisateur > Synchronisation Annuaire
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  administration  annuaire
    # ATTENTION POSTULAT : Il y a deux utilisateurs LDAP dans la base
    # et le ldap auquel nous sommes connectés contient 4 utilisateurs qui ne
    # sont pas les deux déjà en base
    Page Should Contain  Il y a 4 utilisateur(s) présent(s) dans l'annuaire et non présent(s) dans la base => 4 ajout(s)
    Page Should Contain  Il y a 2 utilisateur(s) présent(s) dans la base et non présent(s) dans l'annuaire => 2 suppression(s)
    Page Should Contain  Il y a 0 utilisateur(s) présent(s) à la fois dans la base et l'annuaire => 0 mise(s) à jour
    # On clique sur "Synchroniser"
    Click On Submit Button
    # On vérifie que tout s'est bien passé
    Valid Message Should Be  La synchronisation des utilisateurs est terminée.

    # l'utilisateur ldap_instructeur ne doit plus être présent
    Depuis le listing des utilisateurs
    Rechercher en recherche avancée simple  ldap_instructeur
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody  Aucun enregistrement.

    # l'utilisateur ldap_instructeur ne doit plus être présent
    Depuis le listing des utilisateurs
    Rechercher en recherche avancée simple  ldap_service
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody  Aucun enregistrement.

    # On vérifie que les 3 utilisateurs sont bien présents avec l'information LDAP
    Depuis le contexte de l'utilisateur  einstein
    Depuis le contexte de l'utilisateur  newton
    Depuis le contexte de l'utilisateur  galieleo
    Depuis le contexte de l'utilisateur  tesla

    # On supprime un des 3 utilisateurs
    Supprimer l'utilisateur  galieleo

    # On retourne au tableau de bord
    Go To Dashboard
    # On accède à l'écran de synchronisation via le menu
    Go To Submenu In Menu  administration  annuaire
    # On vérifie le titre de l'écran
    Page Title Should Be  Administration > Gestion Des Utilisateurs > Utilisateur > Synchronisation Annuaire
    # ATTENTION POSTULAT : Il n'y a aucun utilisateur LDAP dans la base
    # et le ldap auquel nous sommes connectés contient 3 utilisateurs
    Page Should Contain  Il y a 1 utilisateur(s) présent(s) dans l'annuaire et non présent(s) dans la base => 1 ajout(s)
    Page Should Contain  Il y a 0 utilisateur(s) présent(s) dans la base et non présent(s) dans l'annuaire => 0 suppression(s)
    Page Should Contain  Il y a 3 utilisateur(s) présent(s) à la fois dans la base et l'annuaire => 3 mise(s) à jour
    # On clique sur "Synchroniser"
    Click On Submit Button
    # On vérifie que tout s'est bien passé
    Valid Message Should Be  La synchronisation des utilisateurs est terminée.

    # Test WS
    ${json} =  Set Variable  { "module": "user", "data": "NA"}
    Vérifier le code retour du web service et vérifier que son message est  Post  maintenance  ${json}  200  Synchronisation terminée.


Affichage des champs de fusion

    [Documentation]    Permet de tester la liste des champs de fusion.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Test
    ...  particulier_prenom=Fusion
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_voie_numero=27
    ...  terrain_adresse_voie=rue grande
    ...  terrain_adresse_lieu_dit=Moulin de redon
    ...  terrain_adresse_code_postal=13390
    ...  terrain_adresse_localite=Auriol

    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr

    Ajouter une consultation depuis un dossier  ${di_libelle}  59.72 - DDTM 13 - Service Urbanisme

    Depuis l'onglet consultation du dossier  ${di_libelle}
    Click On Link  59.72 - DDTM 13 - Service Urbanisme
    Click On Link  Éditer la consultation PDF

    Open PDF  ${OM_PDF_TITLE}

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Moulin de redon

    Close PDF


TNR Listing des utilisateurs sans le mot de passe

    [Documentation]    Dans le listing des utilisateurs la colonne mot de passe
    ...    ne doit pas apparaître.

    # On s'identifie en tant qu'admin
    Depuis la page d'accueil  admin  admin
    # On accède au listing des utilisateurs
    Depuis le listing  om_utilisateur
    # On recherche l'utilisateur admin
    Rechercher en recherche avancée simple  admin
    Click Link  admin
    # On vérifie que la page ne contient pas le hash md5 de l'utilisateur admin
    Page Should Not Contain    21232f297a57a5a743894a0e4a801fc3


TNR Ajout d'une bible

    [Documentation]    On doit pouvoir créer une bible liée ou non à un événement.

    # On s'identifie en tant qu'admin
    Depuis la page d'accueil  admin  admin
    # Sans liaison
    Ajouter une bible depuis le paramétrage dossiers  null  Bible seule  Pour plus tard  null  null  null  MARSEILLE
    # Avec liaison
    Ajouter une bible depuis le paramétrage dossiers  Abandonner les travaux  Bible liée  Pour maintenant  null  null  null  MARSEILLE


TNR Vérifier l'orthographe des libellés des types de dossier d'instruction

    [Documentation]  Vérifie que les libellés des types de DI ont la bonne orthographe.

    #
    Depuis la page d'accueil  admin  admin
    # On va sur menu
    Go To Submenu In Menu  parametrage-dossier  dossier_instruction_type
    # On recherche le type de DA DP
    Use Simple Search  type de dossier d'autorisation détaillé  DP (Déclaration préalable)
    # On vérifie que le libellé "Initiale" existe
    Page Should Contain  Initiale
    # On recherche le type de DA DPS
    Use Simple Search  type de dossier d'autorisation détaillé  DPS (DECLARATION PREALABLE SIMPLE)
    # On vérifie que le libellé "Initiale" existe
    Page Should Contain  Initiale
    # On recherche le type de DA AZ
    Use Simple Search  type de dossier d'autorisation détaillé  AZ (Demande d'autorisation spéciale de travaux dans le périmètre d'une AVAP)
    # On vérifie que le libellé "Initiale" existe
    Page Should Contain  Initiale
    # On recherche le type de DA AT
    Use Simple Search  type de dossier d'autorisation détaillé  AT (Demande d'autorisation de construire, d'aménager ou de modifier un ERP)
    # On vérifie que le libellé "Initiale" existe
    Page Should Contain  Initiale


Paramétrage d'un logo

    [Documentation]  Le but de ce test est de vérifier si la création de logo
    ...  le format de fichier envoyer et si la copie du logo duplique le fichier

    # Utilise un fichier de configuration spécifique
    Move File  ..${/}dyn${/}config.inc.php  ..${/}dyn${/}config.inc.php.bak
    Copy File  ..${/}tests${/}binary_files${/}config_2.inc.php  ..${/}dyn${/}config.inc.php

    # On se connecte en tant que "admin"
    Depuis la page d'accueil  admin  admin

    ##
    ## Ajout d'un logo, avec vérification des contraintes sur le fichier
    ##
    # On accède au listing des logos
    Depuis le listing des logos
    # On clique sur le lien d'ajout de logo
    Click On Add Button
    # On saisie des données
    Input Text  css=#id  logo.jpg
    Input Text  css=#libelle  Un logo
    Select Checkbox  css=#actif
    Select From List By Label  css=#om_collectivite  MARSEILLE
    # On tente d'ajouter un fichier trop gros
    Add File and Expect Error Message Contain  fichier  image_1.jpg  excède la directive
    # On tente d'ajouter un fichier avec une mauvais extension
    Add File and Expect Error Message Be  fichier  fichier_1.odt  Le fichier n'est pas conforme à la liste des extension(s) autorisée(s) (.gif;.jpg;.jpeg;.png;.txt;.pdf;.csv;). [fichier_1.odt]
    # On ajoute un fichier correct
    Add File  fichier  image_2.jpg
    # On ajoute le logo en BDD
    Click On Submit Button
    # On vérifie que le logo s'est bien ajouté
    Valid Message Should Be  Vos modifications ont bien été enregistrées.
    Click On Back Button

    # On va créer une copie du logo
    Click Link  Un logo
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#action-form-om_logo-copier
    Click On Form Portlet Action  om_logo  copier  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Button  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  L’élément a été correctement dupliqué.
    Click On Back Button

    # Suppression de la copie et vérification de la présence du fichier dans
    # le logo d'origine.
    Supprimer le logo  copie du ${DATE_FORMAT_DD/MM/YYYY}
    Depuis le contexte du logo  Un logo
    Element Should Not Contain  content  Le fichier n'existe pas ou n'est pas accessible.

    # Restaure le fichier de configuration sauvegardé
    Remove File  ..${/}dyn${/}config.inc.php
    Move File  ..${/}dyn${/}config.inc.php.bak  ..${/}dyn${/}config.inc.php


Paramétrage d'un instructeur appartenant à une division
    [Documentation]  Vérification du fonctionnement de l'ajout d'instructeur
    ...  depuis l'onglet dans utilisateur et depuis le menu instructeur pour
    ...  vérifier le filtre sur les collectivités,
    ...  il va vérifier aussi:
    ...   - La liste vide en cas d'ajour
    ...   - La list des instructeur pour allauch
    ...   - Pour une modification les parametres par defaut
    ...   - Si on change la division que la liste d'utilisateur suit
    ...   - Que la liste des division soit bien limité pour les utilisateurs mono
    ...   - Si la direction change qu'on puisse toujour choisir la division d'origine
    ...  Puis dans les autres interfaces integrant les instructeurs
    ...  (division et om_utilisateur):
    ...  - La liste de l'ajout
    ...  - La liste de modification


    # Vérification du fonctionnement de base.
    Depuis la page d'accueil  admin  admin

    ${collectivite} =  Set Variable  AUVERGNE
    ${division} =  Set Variable  subdivision A
    ${utilisateur_instr_nom} =  Set Variable  Esperanza Lachance
    ${utilisateur_instr_login} =  Set Variable  elachance
    ${utilisateur_admingen_nom} =  Set Variable  France Martel
    ${utilisateur_admingen_login} =  Set Variable  fmartel
    Ajouter la collectivité depuis le menu  ${collectivite}  mono
    Ajouter la direction depuis le menu  A  Direction A  null  Chef A  null  null  ${collectivite}
    Ajouter la division depuis le menu  A  ${division}  null  Chef A  null  null  Direction A
    Ajouter l'utilisateur  ${utilisateur_instr_nom}  nospam@openmairie.org  ${utilisateur_instr_login}  ${utilisateur_instr_login}  INSTRUCTEUR  ${collectivite}
    Ajouter l'utilisateur  ${utilisateur_admingen_nom}  nospam@openmairie.org  ${utilisateur_admingen_login}  ${utilisateur_admingen_login}  ADMINISTRATEUR GENERAL  ${collectivite}

    Depuis le tableau des instructeurs
    Click On Add Button
    Select From List By Label  division  ${division}
    Sleep  1
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  om_utilisateur  ${utilisateur_instr_nom}
    @{select_utilisateur} =  Get List Items  om_utilisateur
    Should Not Contain Match  ${select_utilisateur}  Instructeur
    Should Contain Match  ${select_utilisateur}  ${utilisateur_instr_nom}

    # On vérifie si à l'ajout le select est vide
    Depuis le tableau des instructeurs
    Click On Add Button
    @{liste_instructeur} =  Create List
    ...  choisir Utilisateur
    Select List Should Be  om_utilisateur  ${liste_instructeur}

    # On verifie la liste d'instructeur pour le une division d'Allauch
    Select From List By Label  division  subdivision L
    @{liste_instructeur_allauch} =  Create List
    ...  choisir Utilisateur
    ...  Instr. poly. Allauch
    Select List Should Be  om_utilisateur  ${liste_instructeur_allauch}

    # On vérifie que les paramètres par defauts sont remplis
    Depuis le tableau des instructeurs
    Use Simple Search  nom  Poly Com Allauch
    Click Link  Poly Com Allauch
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#action-form-instructeur-modifier
    Click On Form Portlet Action  instructeur  modifier
    Selected List Label Should Be  division  subdivision L
    Selected List Label Should Be  om_utilisateur  Instr. poly. Allauch

    # On verifie le changement de liste dans lors du chengement de division
    Select From List By Label  division  ${division}
    @{select_utilisateur} =  Get List Items  om_utilisateur
    Should Contain Match  ${select_utilisateur}  ${utilisateur_instr_nom}

    # Modification de la collectivité de la direction ADS
    Depuis le tableau des directions
    Click Link  Direction ADS
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#action-form-direction-modifier
    Click On Form Portlet Action  direction  modifier
    Select From List By Label  om_collectivite  agglo
    Click On Submit Button
    Valid Message Should Be  Vos modifications ont bien été enregistrées.

    Depuis la page d'accueil  admingenmars  admingenmars
    Depuis le listing  om_utilisateur
    Rechercher en recherche avancée simple  instr
    Click Link  instr
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  On clique sur l'onglet  instructeur  Instructeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element Until No More Element  xpath=//a[text()[contains(.,"Instructeur")]]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  instructeur  modifier
    @{liste_division} =  Create List
    ...  choisir division
    ...  subdivision H
    Select List Should Be  division  ${liste_division}
    Selected List Label Should Be  division  subdivision H

    Depuis la page d'accueil  admin  admin
    Depuis le tableau des directions
    Click Link  Direction ADS
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=#action-form-direction-modifier
    Click On Form Portlet Action  direction  modifier
    Select From List By Label  om_collectivite  MARSEILLE
    Click On Submit Button
    Valid Message Should Be  Vos modifications ont bien été enregistrées.

    # On verifie que la liste des division soit bien limité pour les utilisateurs mono
    Depuis la page d'accueil  ${utilisateur_admingen_login}  ${utilisateur_admingen_login}
    Depuis le tableau des instructeurs
    Click On Add Button
    @{liste_division_A} =  Create List
    ...  choisir division
    ...  subdivision A
    Select List Should Be  division  ${liste_division_A}

    # On vérifie la liste des division (contenu / selection) dans utilisateur
    Depuis la page d'accueil  admin  admin
    Depuis le listing  om_utilisateur
    Rechercher en recherche avancée simple  instr
    Click Link  instr
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  On clique sur l'onglet  instructeur  Instructeur
    Click On Add Button
    @{liste_division} =  Create List
    ...  choisir division
    ...  subdivision H
    ...  subdivision J
    Select List Should Be  division  ${liste_division}

    Depuis le listing  om_utilisateur
    Rechercher en recherche avancée simple  instr
    Click Link  instr
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  On clique sur l'onglet  instructeur  Instructeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element Until No More Element  xpath=//a[text()[contains(.,"Instructeur")]]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  instructeur  modifier
    Selected List Label Should Be  division  subdivision H

    # On vérifie la liste des division (contenu / selection) dans division
    Depuis le listing  division
    Use Simple Search  code  L
    Click Link  L
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  On clique sur l'onglet  instructeur  Instructeur
    Click On Add Button
    @{liste_utilisateur} =  Create List
    ...  choisir Utilisateur
    ...  Instr. poly. Allauch
    Select List Should Be  om_utilisateur  ${liste_utilisateur}


    Depuis le listing  division
    Use Simple Search  code  L
    Click Link  L
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  On clique sur l'onglet  instructeur  Instructeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element Until No More Element  xpath=//a[text()[contains(.,"Poly Com Allauch")]]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  instructeur  modifier
    Selected List Label Should Be  om_utilisateur  Instr. poly. Allauch


Surcharger le nombre d'éléments dans le listing d'om_parametre avec un parametre GET

    Depuis la page d'accueil  admin  admin
    # On verifie que le paramètre GET tab_serie affiche bien le nombre de résultat spécifié
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&module=tab&obj=om_parametre&tab_serie=3
    Element Should Contain  css=.pagination-text  1 - 3 enregistrement(s)

    # On verifie que le paramètre GET tab_serie n'accepte pas autre chose que des integer
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&module=tab&obj=om_parametre&tab_serie=plop
    # 15 est le nombre de résultat par défaut
    Element Should Contain  css=.pagination-text  1 - 15 enregistrement(s)

    # On verifie que le paramètre GET tab_serie n'accepte pas autre chose que des integer
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&module=tab&obj=om_parametre&tab_serie=2.1
    # 15 est le nombre de résultat par défaut
    Element Should Contain  css=.pagination-text  1 - 2 enregistrement(s)

    # On verifie que le paramètre GET tab_serie n'accepte pas autre chose que des integer
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&module=tab&obj=om_parametre&tab_serie=-2.1
    # 15 est le nombre de résultat par défaut
    Element Should Contain  css=.pagination-text  1 - 15 enregistrement(s)


Vérification du bon fonctionnement de la recherche avancée Utilisateur

    [Documentation]  On vérifie le fonctionnement de la recherche avancée dans le contexte
    ...  Administration -> Gestion des utilisateurs -> Utilisateur

    # On se connecte en tant que "admin"
    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  administration  utilisateur
    # On vérifie le titre de l'écran
    Page Title Should Be  Administration > Gestion Des Utilisateurs > Utilisateur
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  administration  utilisateur

    # Simuler le clique sur le bouton recherche avancée
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#om_utilisateur

    # On saisie des données (UTILISATEUR)
    Input Text  css=#om_utilisateur  20
    Click On Search Button
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody td.col-1  Administrateur général
    Input Text  css=#om_utilisateur  ${EMPTY}

    # On saisie des données (NOM)
    Input Text  css=#nom  administrateur fonctionnel
    Click On Search Button
    # On vérifie que seul s'affiche les utilisateurs ayant comme info Administrateur
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody td.col-1  Administrateur fonctionnel
    Input Text  css=#nom  ${EMPTY}

    # On saisie des données (EMAIL)
    Input Text  css=#email  einstein@ldap.forumsys.com
    Click On Search Button
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody td.col-1  Albert Einstein
    Input Text  css=#email  ${EMPTY}

    # On saisie des données (LOGIN)
    Input Text  css=#login  admingen
    Click On Search Button
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody td.col-1   	Administrateur général
    Input Text  css=#login  ${EMPTY}

    # On saisie des données (TYPE)
    Input Text  css=#om_type  ldap
    Click On Search Button
    # Il y a plusieurs résultats pour le type ldap et notamment ceux récupéré dans le test case
    # "Synchronisation des utilisateurs avec un annuaire LDAP". Pour ne pas avoir de problème on
    # vérifie juste si le tableau contiens le résultat attendus et pas si il s'agit du 1er élément
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody  Albert Einstein
    Input Text  css=#om_type  ${EMPTY}

    # On saisie des données (PROFIL)
    Select From List By Label  css=select#om_profil  ASSISTANTE
    Click On Search Button
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody td.col-1  Assistante
    Select From List By Label  css=#om_profil  choisir Profil

    # On saisie des données (COLLECTIVITÉ)
    Select From List By Label  css=select#om_collectivite  ALLAUCH
    Click On Search Button
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody td.col-1  Instr. poly. Allauch
    Select From List By Label  css=#om_collectivite  choisir Collectivité

    # Simuler le clique sur le bouton recherche avancée (Aucun enregistrement attendu)
    # On saisie des données
    Input Text  css=#nom  toto
    Click On Search Button
    # On vérifie que seul s'affiche les utilisateurs ayant comme info Administrateur
    Element Should Contain  css=#tab-om_utilisateur table.tab-tab tbody  Aucun enregistrement.
    
    # On se connecte en tant que "admingenmars"
    # verifier qu'il n'a y a pas d'om_collevtivité dans la recherche avancée
    Depuis la page d'accueil  admingenmars  admingenmars
    Go To Submenu In Menu  administration  utilisateur
    # On vérifie le titre de l'écran
    Page Title Should Be  Administration > Gestion Des Utilisateurs > Utilisateur
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  administration  utilisateur
    Wait Until Element Is Not Visible  css=select#om_collectivite


Vérification du bon fonctionnement de la recherche avancée Affectation automatique

    [Documentation]  On vérifie le fonctionnement de la recherche avancée dans le contexte
    ...  Paramétrage -> Affectation AUtomatique

    # On se connecte en tant que "admin"
    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  parametrage  affectation_automatique
    # On vérifie le titre de l'écran
    Page Title Should Be  Paramétrage > Gestion Des Dossiers > Affectation Automatique
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  parametrage  affectation_automatique

    # Simuler le clique sur le bouton recherche avancée
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#affectation_automatique

    # On saisie des données (AFFECTATION AUTO)
    Input Text  css=#affectation_automatique  10
    Click On Search Button
    # On vérifie que seul s'affiche les utilisateurs ayant comme info Administrateur
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-1  Recours contentieux
    Input Text  css=#affectation_automatique  ${EMPTY}

    # On saisie des données (DATD)
    Select From List By Label  css=select#dossier_autorisation_type_detaille  Certificat d'urbanisme
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-1  Certificat d'urbanisme
    Select From List By Label  css=#dossier_autorisation_type_detaille  choisir type de dossier d'autorisation détaillé

    # On saisie des données (INSTRUCTEUR)
    Select From List By Label  css=select#instructeur  Martine Nadeau (H)
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-1  Permis de construire pour une maison individuelle et / ou ses annexes
    Select From List By Label  css=#instructeur  choisir instructeur
 
    # On saisie des données (INSTRUCTEUR SECONDAIRE)
    Select From List By Label  css=select#instructeur_2  Technicien (H)
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-1  Infraction

    # Ajout de valeur dans dossier pour recherche affectation manuelle ,arr, quartier, section et 
    # affectation manuelle (car aucune valeur à recherché)
    Click On Link  Infraction
    Click On Form Portlet Action  affectation_automatique  modifier
    Select From List By Label  css=select#arrondissement  2
    Select From List By Label  css=select#dossier_instruction_type  Certificat d'urbanisme - Initial (P)
    Input Text  css=#section  sectionTest
    Input Text  css=#affectation_manuelle  AM-test
    Click On Submit Button
    Click On Back Button

    Select From List By Label  css=select#instructeur_2  choisir Instructeur secondaire

    # On saisie des données (TYPE DOSSER INSCTRUCTION)
    Select From List By Label  css=select#dossier_instruction_type  Certificat d'urbanisme - Initial (P)
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-1  Infraction
    Select From List By Label  css=#dossier_instruction_type  choisir type de dossier d'instruction

    # On saisie des données (ARRONDISSEMENT)
    Select From List By Label  css=select#arrondissement  2
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-1  Infraction
    Select From List By Label  css=select#arrondissement  choisir arrondissement

    # On saisie des données (QUARTIER)
    Select From List By Label  css=select#quartier  01 – BELSUNCE
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-1  Permis de construire pour une maison individuelle et / ou ses annexes
    Select From List By Label  css=select#quartier  choisir quartier

    # On saisie des données (SECTION)
    Input Text  css=#section  se
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-1  Infraction
    Input Text  css=#section  ${EMPTY}

    # On saisie des données (AFFECTACTION MANUELLE)
    Input Text  css=#affectation_manuelle  AM-test
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-1  Infraction
    Input Text  css=#affectation_manuelle  ${EMPTY}

    # On saisie des données (COLLECTIVITÉ)
    Select From List By Label  css=select#om_collectivite  ALLAUCH
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody td.col-3  Poly Com Allauch (L)
    Select From List By Label  css=select#om_collectivite  choisir Collectivité

    # Simuler le clique sur le bouton recherche avancée (Aucun enregistrement attendu)
    # On saisie des données
    Input Text  css=#affectation_automatique  toto
    Click On Search Button
    Element Should Contain  css=#tab-affectation_automatique table.tab-tab tbody  Aucun enregistrement. 
    Input Text  css=#affectation_automatique  ${EMPTY}
    Click On Search Button

    Input Text  css=#affectation_automatique  9
    Click On Search Button

    Click On Link  Infraction
    Click On Form Portlet Action  affectation_automatique  modifier
    Select From List By Label  css=select#arrondissement  choisir arrondissement
    Select From List By Label  css=select#dossier_instruction_type  choisir type de dossier d'instruction
    Input Text  css=#section  ${EMPTY}
    Input Text  css=#affectation_manuelle  ${EMPTY}
    Click On Submit Button
    Click On Back Button

    # On se connecte en tant que "admingenmars"
    # verifier qu'il n'a y a pas d'om_collevtivité dans la recherche avancée
    Depuis la page d'accueil  admingenmars  admingenmars
    Go To Submenu In Menu  parametrage  affectation_automatique
    # On vérifie le titre de l'écran
    Page Title Should Be  Paramétrage > Gestion Des Dossiers > Affectation Automatique
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  parametrage  affectation_automatique
    Wait Until Element Is Not Visible  css=select#om_collectivite


Afficher un logo spécifique dans l'entête de l'application

    [Documentation]  Vérifie le déploiement et l'affichage d'un logo spécifique
    ...  dans l'entête de l'application.

    # Initialise le format à png
    ${format} =  Set Variable  png
    # Assigne le bon format en fonction de l'existance ou non du format du logo_customer
    ${status} =  Run Keyword And Return Status  File Should Exist  ..${/}app${/}img${/}logo_customer.${format}
    ${format} =  Run Keyword If  ${status} == True  Set Variable  png  ELSE  Set Variable  jpg

    # Supprime le logo spécifique au cas où il serait présent
    Remove File  ..${/}app${/}img${/}logo_customer.${format}

    # Vérifie que le logo spécifique n'est pas visible
    Depuis la page d'accueil  admin  admin
    Wait Until Element Is Visible  css=div#header div#logo h1
    Element Should Not Be Visible  css=div#header div#logo h1 a.logo_customer span

    # Déplace le logo spécifique à l'emplacement nécessaire pour son utilisation
    Copy File  ..${/}tests${/}binary_files${/}logo_customer.png  ..${/}app${/}img${/}

    # Recharge la page d'accueil et vérifie que le logo spécifique est visible
    Go To Dashboard
    Wait Until Element Is Visible  css=div#header div#logo h1
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=div#header div#logo h1 a.logo_customer span

    # Supprime le logo spécifique
    Remove File  ..${/}app${/}img${/}logo_customer.png


Vérification des attributions hiérarchiques de l'utilisateur courant
    [Documentation]  Vérifie la hiérarchie du profil courant : il doit pouvoir créer ou modifier
    ...  uniquement des profils inférieurs en hiérarchie. Les cas sont testés dans cet ordre : 
    ...  1 - comportement de l'application avec un ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    ...  2 - comportement de l'application avec un ADMINISTRATEUR GENERAL
    ...  Les autres utilisateurs (de hiérarchie inférieure) ne peuvent pas créer, ni le profil des utilisateurs.

    ## Connexion en tant qu' "admin" : ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Depuis la page d'accueil  admin  admin

    # Création d'un utilisateur
    Depuis le formulaire d'ajout d'un utilisateur
    @{select_profil} =  Get List Items  om_profil
    Should Contain Match  ${select_profil}  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL

    # Modification du profil de l'utilisateur
    Depuis le contexte de l'utilisateur  admin
    Portlet Action Should Be In Form  om_utilisateur  modifier

    ## Connexion en tant qu' "admingen" : ADMINISTRATEUR GENERAL
    Depuis la page d'accueil  admingen  admingen

    # Création d'un utilisateur
    Depuis le formulaire d'ajout d'un utilisateur
    @{select_profil} =  Get List Items  om_profil
    Should Not Contain Match  ${select_profil}  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL

    # Modification du profil de l'utilisateur
    Depuis le contexte de l'utilisateur  admin
    Portlet Action Should Not Be In Form  om_utilisateur  modifier

    # Modification du profil de l'utilisateur
    Depuis le contexte de l'utilisateur  admingen
    Click On Form Portlet Action  om_utilisateur  modifier
    @{select_profil} =  Get List Items  om_profil
    Should Not Contain Match  ${select_profil}  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Should Contain Match  ${select_profil}  ADMINISTRATEUR GENERAL

Vérification du bon fonctionnement du paramètre affichage_di_listing_colonnes_masquees
    [Documentation]  Permet de vérifier que le paramètre affichage_di_listing_colonnes_masquees
    ...  masque bien la colonne spécifié (date_complet ou localisation ou les deux)

    # On teste le paramètre sur la collectivité de niveau
    # puis sur la collectivité de niveau 1
    Depuis la page d'accueil  admin  admin

    # On vérifie que les deux colonnes sont présentes au départ sur le listing instruction > recherche
    Depuis le listing  dossier_instruction

    Element Should Be Visible  xpath=//th[contains(@class, 'title')]/descendant::span/descendant::a[normalize-space(text())="localisation"]
    Element Should Be Visible  xpath=//th[contains(@class, 'title')]/descendant::span/descendant::a[normalize-space(text())="complétude"]

    # Ajout du paramètre afin de masque seulement la localisation
    &{param_affichage_di_listing_colonnes_masquees} =  Create Dictionary
    ...  libelle=affichage_di_listing_colonnes_masquees
    ...  valeur=localisation
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_affichage_di_listing_colonnes_masquees}

    # On vérifie que la colonne localisation est masquée sur le listing instruction > recherche
    # mais pas complétude
    Depuis le listing  dossier_instruction

    Element Should Not Be Visible  xpath=//th[contains(@class, 'title')]/descendant::span/descendant::a[normalize-space(text())="localisation"]
    Element Should Be Visible  xpath=//th[contains(@class, 'title')]/descendant::span/descendant::a[normalize-space(text())="complétude"]

    # Ajout du paramètre afin de masque seulement la localisation
    &{param_affichage_di_listing_colonnes_masquees} =  Create Dictionary
    ...  libelle=affichage_di_listing_colonnes_masquees
    ...  valeur=localisation;date_complet
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${param_affichage_di_listing_colonnes_masquees}

    # On vérifie que la colonne localisation est masquée sur le listing instruction > recherche en tant qu'admin
    # mais pas complétude
    Depuis le listing  dossier_instruction

    Element Should Not Be Visible  xpath=//th[contains(@class, 'title')]/descendant::span/descendant::a[normalize-space(text())="localisation"]
    Element Should Be Visible  xpath=//th[contains(@class, 'title')]/descendant::span/descendant::a[normalize-space(text())="complétude"]

    # En tant qu'admin marseille les deux colonnes doivent être masquées
    Depuis la page d'accueil  admingenmars  admingenmars

    Depuis le listing  dossier_instruction

    Element Should Not Be Visible  xpath=//th[contains(@class, 'title')]/descendant::span/descendant::a[normalize-space(text())="localisation"]
    Element Should Not Be Visible  xpath=//th[contains(@class, 'title')]/descendant::span/descendant::a[normalize-space(text())="complétude"]

    Depuis la page d'accueil  admin  admin

    # Suppression des paramètre pour revenir dans un état normal
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=affichage_di_listing_colonnes_masquees
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=affichage_di_listing_colonnes_masquees
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${param_args}