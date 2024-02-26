*** Settings ***
Documentation  Test des fonctionnalités introduites par le multicollectivité.
...    Chaque 'Test Case' est indépendant.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Variables ***

${json_update_dossier_autorisation}    {"module":"update_dossier_autorisation"}

*** Test Cases ***

Constitution du jeu de données
    [Documentation]  Constitution du jeu de données
    ...    En tant que guichetier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DURAND
    ...  particulier_prenom=GÉRARD
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}


Affichage des dossiers d'autorisation pour les services consultés
    [Documentation]  Test l'affichage des DA qui ont une demande d'avis pour
    ...    le profil "Service consulté"

    Depuis la page d'accueil  consu  consu
    Depuis le listing  dossier_autorisation_avis
    Element Should Contain  tab-dossier_autorisation_avis  PC 013055 12 00002
    Click Link  PC 013055 12 00002
    La page ne doit pas contenir d'erreur
    Comment  À faire : vérifier que le lisitng des DA affiche seulement les DA
    ...  pour lesquels l'utilisateur a eu une demande d'avis.


Etat perime
    [Documentation]  L'objet de ce 'Test Case' est de vérifier que le WS passe
    ...    à l'état périmé les dossiers d'autorisation remplissant les conditions :
    ...    - état = Accordé
    ...    - avec date de décision
    ...    - date de validité dans le passé
    ...    - aucun DOC ou DAACT avec avis favorable

    Depuis la page d'accueil    instr    instr
    Go To Submenu In Menu    autorisation    dossier_autorisation
    La page ne doit pas contenir d'erreur
    ${libelle_sans_espace} =  Sans espace  PA 013055 12 00001
    Input Text  css=div#adv-search-adv-fields input#dossier  ${libelle_sans_espace}
    Click On Search Button
    Click On Link    PA 013055 12 00001
    Page Title Should Be    Autorisation > Dossiers D'autorisation
    Element Text Should Be    css=#da_etat    Accordé
    Vérifier le code retour du web service et vérifier que son message contient    Post    maintenance    ${json_update_dossier_autorisation}    200    dossier(s) d'autorisation(s) mis à jour.
    Vérifier le code retour du web service et vérifier que son message est    Post    maintenance    ${json_update_dossier_autorisation}    200    Aucune mise à jour

    Reload Page
    Element Text Should Be    css=#da_etat    Périmé


TNR Bug "Erreur de base de données" dans la recherche avancée des DA sur le critère date de décision

    [Documentation]    Test de non régression sur le bug "Erreur de base de
    ...    données" sur la validation de la recherche avancée dans le listing
    ...    "Autorisation" -> "Dossiers d'Autorisation" sur le critère "Date de
    ...    décision".

    #
    Depuis la page d'accueil    instr    instr
    #
    Depuis le listing des dossiers d'autorisation
    # On remplit les critères date de décision de la recherche avancée
    Input Text  css=div#adv-search-adv-fields input#date_decision_min  01/05/2015
    Input Text  css=div#adv-search-adv-fields input#date_decision_max  31/05/2015
    # On valide le formulaire de recherche
    Click On Search Button
    # On ne fait aucune vérification ici car le keyword précédent "Click On
    # Search Button" permet de vérifier qu'il n'y a pas d'erreur de base de
    # données

TNR Bug Recalcul du DA si plusieurs DI sans décision

    [Documentation]    Test de non régression sur le bug impactant le recalcul
    ...     du DA si plusieurs DI sans décision

    #
    Depuis la page d'accueil    admin    admin

    @{etats_autorises} =    Create List
    ...    delai majore
    ...    delai de notification envoye
    ...    dossier sans notification de delai

    &{args_demande_type} =  Create Dictionary
    ...    code=TNR Bug Recalcul du DA
    ...    libelle=TNR Bug Recalcul du DA
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...    demande_nature=Dossier existant
    ...    etats_autorises=@{etats_autorises}
    ...    contraintes=Récupération des demandeurs avec modification et ajout
    ...    dossier_instruction_type=PCI - Modificatif
    ...    evenement=Notification de delai

    Ajouter un nouveau type de demande depuis le menu    ${args_demande_type}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DURAND
    ...  particulier_prenom=Marcel
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_demande} =  Create Dictionary
    ...  demande_type=TNR Bug Recalcul du DA
    ...  dossier_instruction=${di_libelle}
    ${di_libelle_2} =  Ajouter la demande par WS  ${args_demande}


Visibilité des DA

    [Documentation]  Ce test case vérifie que cocher l'option "masquer DA" d'un type de
    ...  dossier d'autorisation rend bien invisible et inacessible les DA de ce type dans
    ...  toute l'application.

    # On va vérifié si le DATD disparait bien des selects des recherches

    Depuis la page d'accueil    admin    admin
    Depuis le listing  dossier_autorisation
    ${listeRecuperee} =  Get List Items  dossier_autorisation_type_detaille
    List Should Contain Value  ${listeRecuperee}  Permis de construire pour une maison individuelle et / ou ses annexes

    Depuis la page d'accueil  consu  consu
    Depuis le listing  dossier_autorisation_avis
    ${listeRecuperee} =  Get List Items  dossier_autorisation_type_detaille
    List Should Contain Value  ${listeRecuperee}  Permis de construire pour une maison individuelle et / ou ses annexes


    Depuis la page d'accueil    admin    admin
    &{args_type_da} =  Create Dictionary
    ...  cacher_da=true
    Modifier le type de dossier d'autorisation  PC  ${args_type_da}

    Depuis le listing  dossier_autorisation
    ${listeRecuperee} =  Get List Items  dossier_autorisation_type_detaille
    List Should Not Contain Value  ${listeRecuperee}  Permis de construire pour une maison individuelle et / ou ses annexes

    Depuis la page d'accueil  consu  consu
    Depuis le listing  dossier_autorisation_avis
    ${listeRecuperee} =  Get List Items  dossier_autorisation_type_detaille
    List Should Not Contain Value  ${listeRecuperee}  Permis de construire pour une maison individuelle et / ou ses annexes

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=MAROIS
    ...  particulier_prenom=Seymour
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    ${da_libelle} =  Get Substring  ${di_libelle}  0  -2
    ${da_libelle_sans_espace} =  Sans Espace  ${da_libelle}

    # Accès par le menu Autorisation > Dossier d'autorisation pour service consultés (dossier_autorisation_avis)
    Depuis la page d'accueil  consu  consu
    Depuis le listing  dossier_autorisation_avis
    Input Text  css=div#adv-search-adv-fields input#dossier  PC
    Click On Search Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Aucun enregistrement


    # Accès par le menu Autorisation > Dossier d'autorisation
    Depuis la page d'accueil  instr  instr
    Depuis le listing des dossiers d'autorisation
    Input Text  css=div#adv-search-adv-fields input#dossier  ${da_libelle_sans_espace}
    Click On Search Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Aucun enregistrement

    # Accès directement par l'URL
    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_autorisation&action=3&idx=${da_libelle_sans_espace}
    Page Should Contain  Droits insuffisants

    # Accès par l'onglet des dossiers liés du DI
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${di_libelle}
    Element Should Not Be Visible  sousform-dossier_autorisation

    # On vérifie que les fonctionnalités d'accès par le portail citoyen sont désactivées
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    # On vérifie que le champ contenant la clé d'accès au portail citoyen est vide
    Open Fieldset    dossier_instruction    demandeur
    Element Should Not Be Visible  cle_acces_citoyen

    Portlet Action Should Not Be In Form  dossier_instruction  generate_citizen_access_key
    Portlet Action Should Not Be In Form  dossier_instruction  regenerate_citizen_access_key

    # On remet le type de DA "PC" dans l'état initial
    Depuis la page d'accueil    admin    admin

    &{args_type_da} =  Create Dictionary
    ...  cacher_da=false
    Modifier le type de dossier d'autorisation  PC  ${args_type_da}

    # On vérifie le nom du DATD est bien afficher dans la recherche avancer
    Depuis la page d'accueil  instr  instr
    Depuis le listing des dossiers d'autorisation
    Input Text  css=div#adv-search-adv-fields input#dossier  ${da_libelle_sans_espace}
    Click On Search Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.tab-tab  Permis de construire comprenant ou non des démolitions


Historique de décision

    [Documentation]  Ce test case vérifie que l'historique de décision ne
    ...  contient que le pétitionnaire principal.

    #Création d'un PC avec deux pétitionnaires, avec une décision
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Roger
    ...  particulier_prenom=Homard
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire2} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Gontran
    ...  particulier_prenom=Bourfu
    ...  om_collectivite=MARSEILLE

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire2}

    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}  ${args_autres_demandeurs}
    ${da} =  Get Substring  ${di}  0  -2
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve

    #Se rendre dans l'historique de décision du DA, et vérifier que seul le pétitionnaire principal est présent
    Depuis le contexte du dossier d'autorisation  ${da}
    Page Should Not Contain  Gontran Bourfu
    Page Should Contain  Roger Homard

TNR Probleme de recuperation du pétitionnaire sur le dossier d'autorisation
    [Documentation]  Vérifie que le nom du pétitionnaire principal est correctement
    ...  affiché dans la synthèse du dossier d'autorisation dans le cas ou plusieurs
    ...  pétitionnaire ont été enregistré.
    
    Depuis la page d'accueil    admin    admin
   
   # Ajout d'un nouveaux dossier avec un pétitionnaire et un pétitionnaire principal
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST035SUPPRESSIONDOSSIERNOM01
    ...  particulier_prenom=TEST035SUPPRESSIONDOSSIERPRENOM01
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire_2} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=bbb
    ...  particulier_prenom=aaa
    ...  om_collectivite=MARSEILLE
    &{args_autre_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire_2}
    ${di1} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}  ${args_autre_demandeurs}
    # Récupération du nom du da à l'aide de celui du di
    ${da} =  Get Substring  ${di1}  0  -2
    Depuis le contexte du dossier d'autorisation  ${da}
    # Vérification dans la synthèse des demandeurs que le nom du demandeur principal est bien affiché
    Element Should Contain  css=#da_demandeur  TEST035SUPPRESSIONDOSSIERNOM01 TEST035SUPPRESSIONDOSSIERPRENOM01


Tri du champs "Type" de DA dans la recherche des DI
    [Documentation]  Sur le listing de recherche des dossiers d'instruction, 
    ...  le champ "Type" (dossier_autorisation_type_detaille) 
    ...  doit être trié comme sur le formulaire de la demande.

    Depuis la page d'accueil  admin  admin

    # Vérification de l'ordre des éléments avant modification
    Depuis le listing  dossier_instruction
    @{liste_dossier_autorisation_type_detaille} =  Create List
    ...  choisir type de dossier d'autorisation détaillé
    ...  Certificat d'urbanisme
    ...  Déclaration préalable
    ...  DECLARATION PREALABLE SIMPLE
    ...  Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    ...  Demande d'autorisation spéciale de travaux dans le périmètre d'une AVAP
    ...  Fonds de commerce
    ...  Permis d'aménager comprenant ou non des constructions et/ou des démolitions
    ...  Permis de construire comprenant ou non des démolitions
    ...  Permis de construire pour une maison individuelle et / ou ses annexes
    ...  Permis de démolir
    Select List Should Be  dossier_autorisation_type_detaille  ${liste_dossier_autorisation_type_detaille}

    # Modification d'un type de DA pour vérifier son ordre alphabétique à l'affichage
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  libelle=Z - DECLARATION PREALABLE SIMPLE
    Modifier type de dossier d'autorisation détaillé  DPS  ${args_type_DA_detaille_modification}

    # Vérification de l'ordre des éléments après modification
    Depuis le listing  dossier_instruction
    @{liste_dossier_autorisation_type_detaille} =  Create List
    ...  choisir type de dossier d'autorisation détaillé
    ...  Certificat d'urbanisme
    ...  Déclaration préalable
    ...  Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    ...  Demande d'autorisation spéciale de travaux dans le périmètre d'une AVAP
    ...  Fonds de commerce
    ...  Permis d'aménager comprenant ou non des constructions et/ou des démolitions
    ...  Permis de construire comprenant ou non des démolitions
    ...  Permis de construire pour une maison individuelle et / ou ses annexes
    ...  Permis de démolir
    ...  Z - DECLARATION PREALABLE SIMPLE
    Select List Should Be  dossier_autorisation_type_detaille  ${liste_dossier_autorisation_type_detaille}
    
    # Réinitialisation du type de DA en fin de test
    Depuis la page d'accueil  admin  admin
    &{liste_dossier_autorisation_type_detaille} =  Create Dictionary
    ...  libelle=DECLARATION PREALABLE SIMPLE
    Modifier type de dossier d'autorisation détaillé  DPS  ${liste_dossier_autorisation_type_detaille}
