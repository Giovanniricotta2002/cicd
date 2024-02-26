*** Settings ***
Documentation  Test des fonctionnalités introduites par le multicollectivité.
...    Chaque 'Test Case' est indépendant afin de créer un jeu de données conséquent.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Service
    [Documentation]  L'objet de ce 'Test Case' est de vérifier le filtre des
    ...    services proposés dans les consultations des DI selon la collectivité
    ...    à laquelle ils sont rattachés.

    # Constitution du jeu de données : l'objectif est d'avoir des services rattachés
    # à des collectivités mono distinctes et à la multicollectivité.
    # En tant qu'administrateur
    Depuis la page d'accueil  admin  admin
    # Donnée 1/4 : collectivité 'Allauch' de niveau 1
    Ajouter la collectivité depuis le menu  Allauch  mono
    # Donnée 2/4 : service rattaché à Marseille (mono)
    &{service} =  Create Dictionary
    ...  abrege=77.77
    ...  libelle=Sermarseille
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    # Donnée 3/4 : service rattaché à Allauch (mono)
    &{service} =  Create Dictionary
    ...  abrege=77.78
    ...  libelle=Serallauch
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=Allauch
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    # Donnée 4/4 : service rattaché à Agglo (multi)
    &{service} =  Create Dictionary
    ...  abrege=77.79
    ...  libelle=Seragglo
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=agglo
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Roussel
    ...  particulier_prenom=Alexis
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    # On crée une nouvelle demande via le tableau de bord
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # En tant qu'instructeur de Marseille :
    # on attend des services de Marseille et d'Agglo uniquement
    Depuis la page d'accueil  instr  instr
    # Cas 1/2 - Ajout d'une consultation
    Ajouter une consultation depuis l'onglet du dossier d'instruction  ${di_libelle}
    Wait Until Element Is Visible  service
    @{select_service} =  Get List Items  service
    Should Contain Match  ${select_service}  77.77 - Sermarseille
    Should Contain Match  ${select_service}  77.79 - Seragglo
    Should Not Contain Match  ${select_service}  77.78 - Serallauch
    # Cas 2/2 - Ajout d'un lot de consultations
    Ajouter un lot de consultations depuis l'onglet du dossier d'instruction  ${di_libelle}
    Element Should Contain In Subform  css=div.list-ser-them  Sermarseille
    Element Should Contain In Subform  css=div.list-ser-them  Seragglo
    Element Should Not Contain  css=div.list-ser-them  Serallauch

    # TNR : gestion multi dans le paramétrage
    # création d'un service par utilisateur mono puis modifié par un utilisateur agglo
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu  service  INSTRUCTEUR POLYVALENT COMMUNE
    Depuis la page d'accueil  instrpolycomm3  instrpolycomm3
    &{service} =  Create Dictionary
    ...  abrege=77.80
    ...  libelle=Sermono
    ...  edition=Consultation - Demande d'avis
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du service  null  77.80
    Element Text Should Be  om_collectivite  ALLAUCH
    Click On Form Portlet Action  service  modifier
    Click On Submit Button
    Element Text Should Be  om_collectivite  ALLAUCH

Affectation
    [Documentation]  L'objet de ce 'Test Case' est de vérifier l'affectation
    ...    automatique d'un instructeur à un nouveau dossier en fonction de sa
    ...    collectivité.

    # Constitution du jeu de données : l'objectif est d'avoir des guichetiers et
    # instructeurs sur deux collectivités mono, ainsi qu'une liste d'affectations.
    # En tant qu'administrateur
    Depuis la page d'accueil  admin  admin
    # Donnée 1/4 : collectivité 'Aix' de niveau 1
    Ajouter la collectivité depuis le menu  Aix  mono
    # Donnée 2/4 : guichetier rattaché à 'Aix'
    Ajouter l'utilisateur depuis le menu  Lévesque Élise  support@atreal.fr  guiaix  guiaix  GUICHET UNIQUE  Aix
    # Donnée 3/4 : instructeur rattaché à 'Aix'
    Ajouter l'utilisateur  Montague Antoine  support@atreal.fr  instraix  instraix  INSTRUCTEUR  Aix
    Ajouter la direction depuis le menu  AIX  Direction AIX  null  Chef AIX  null  null  Aix
    Ajouter la division depuis le menu  AIX  subdivision AIX  null  Chef AIX  null  null  Direction AIX
    Ajouter l'instructeur depuis le menu  Montague Antoine  subdivision AIX  instructeur  Montague Antoine
    # Donnée 4/4 : affectation automatique du nouvel instructeur
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Montague Antoine (AIX)
    ...  om_collectivite=Aix
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # On crée une nouvelle demande via le tableau de bord
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Brunelle
    ...  particulier_prenom=Pierre
    ...  om_collectivite=Aix

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Aix
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # En tant qu'instructeur d'Aix
    Depuis la page d'accueil  instraix  instraix
    # On ouvre le DI
    Depuis le contexte du dossier d'instruction par recherche  ${di_libelle}
    # On vérifie l'affectation automatique
    Element Text Should Be  instructeur  Montague Antoine

    # Second instructeur

    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Chnadonnet
    ...  particulier_prenom=Gaston
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Audet
    ...  particulier_prenom=Saber
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE

    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    Depuis la page d'accueil  admin  admin

    # On vérifie l'affectation automatique
    Depuis le contexte du dossier infraction par recherche  ${di_inf}
    Element Text Should Be  instructeur  Juriste
    Element Text Should Be  instructeur_2  Technicien

Signataire
    [Documentation]  L'objet de ce 'Test Case' est de vérifier le filtre des
    ...    signataires proposés dans les instructions des DI selon la collectivité
    ...    à laquelle ils sont rattachés.

    # Constitution du jeu de données : l'objectif est d'avoir des signataires
    # rattachés à des collectivités mono distinctes et à la multicollectivité.
    # En tant qu'administrateur
    Depuis la page d'accueil  admin  admin
    # Donnée 1/8 : collectivité 'Martigues' de niveau 1
    Ajouter la collectivité depuis le menu  Martigues  mono
    # Donnée 2/8 : collectivité 'La Ciotat' de niveau 1
    Ajouter la collectivité depuis le menu  La Ciotat  mono
    # Donnée 3/8 : signataire rattaché à la collectivité 'Martigues' (mono)
    &{args_signataire} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=Guernon
    ...  prenom=Vincent
    ...  qualite=Maire
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=Martigues
    Ajouter le signataire depuis le menu  ${args_signataire}
    # Donnée 4/8 : signataire rattaché à la collectivité 'La Ciotat' (mono)
    &{args_signataire} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=Guernon
    ...  prenom=Nathalie
    ...  qualite=Chartier
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=La Ciotat
    Ajouter le signataire depuis le menu  ${args_signataire}
    # Donnée 5/8 : signataire rattaché à la collectivité 'agglo' (multi)
    &{args_signataire} =  Create Dictionary
    ...  civilite=Madame
    ...  nom=Blanchard
    ...  prenom=Patricia
    ...  qualite=Maire
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=agglo
    Ajouter le signataire depuis le menu  ${args_signataire}
    # Donnée 7/8 : instructeur rattaché à 'Martigues'
    Ajouter l'utilisateur  Cressac Laurent  support@atreal.fr  instrmart  instrmart  INSTRUCTEUR  Martigues
    Ajouter la direction depuis le menu  MAR  Direction MAR  null  Chef MAR  null  null  Martigues
    Ajouter la division depuis le menu  MAR  subdivision MAR  null  Chef MAR  null  null  Direction MAR
    Ajouter l'instructeur depuis le menu  Cressac Laurent  subdivision MAR  instructeur  Cressac Laurent
    # Donnée 8/8 : affectation automatique du nouvel instructeur
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Cressac Laurent (MAR)
    ...  om_collectivite=Martigues
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # En tant que guichetier de Martigues
    # On crée une nouvelle demande via le tableau de bord
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Brunelle
    ...  particulier_prenom=Pierre
    ...  om_collectivite=Martigues

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Martigues
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # En tant qu'instructeur de Martigues
    Depuis la page d'accueil  instrmart  instrmart
    # On ouvre l'onglet instruction du nouveau DI
    Depuis l'onglet instruction du dossier d'instruction  ${di_libelle}
    # On accède à l'instruction
    Click On Link  Notification du delai legal maison individuelle
    # On reprend la rédaction
    Click On SubForm Portlet Action  instruction  definaliser
    # On revient au tableau
    Click On Back Button In Subform
    # On ré-accède à l'instruction
    Click On Link  Notification du delai legal maison individuelle
    # On modifie l'instruction
    Click On SubForm Portlet Action  instruction  modifier

    # Si le click au portlet ne fonctionne pas on essaie encore
    ${status} =  Run Keyword And Return Status  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=select#signataire_arrete
    Run Keyword If  ${status} == False  Click On SubForm Portlet Action  instruction  modifier

    # On vérifie le contenu du select des signataires
    @{select_signataire} =  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Get List Items  signataire_arrete
    Should Contain Match  ${select_signataire}  Patricia Blanchard
    Should Contain Match  ${select_signataire}  Vincent Guernon
    Should Not Contain Match  ${select_signataire}  Nathalie Chartier

Direction
    [Documentation]  L'objet de ce 'Test Case' est de vérifier le filtre des
    ...    instructeurs et des divisions proposés dans les dossiers d'instruction
    ...    selon la collectivité.
    # Constitution du jeu de données : l'objectif est d'avoir des signataires
    # rattachés à des collectivités mono distinctes et à la multicollectivité.
    # En tant qu'administrateur
    Depuis la page d'accueil  admin  admin
    # On active le SIG externe
    Modifier le paramètre   option_afficher_division  true  agglo
    # Donnée : collectivité 'Nice' de niveau 1
    Ajouter la collectivité depuis le menu  Nice  mono
    # Donnée : direction rattaché à la collectivité 'Nice' (mono)
    Ajouter la direction depuis le menu  X  Direction X  null  Chef X  null  null  Nice
    # Donnée : division rattaché à la direction 'X'
    Ajouter la division depuis le menu  X  subdivision X  null  Chef X  null  null  Direction X
    # Donnée : instructeur rattaché à 'Nice'
    Ajouter l'utilisateur  DUPONT Jean-Paul  support@atreal.fr  instrdupmart  instrdupmart  INSTRUCTEUR  Nice
    Ajouter l'instructeur depuis le menu  DUPONT Jean-Paul  subdivision X  instructeur  DUPONT Jean-Paul

    # On crée une nouvelle demande via le tableau de bord
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=BOMONT
    ...  particulier_prenom=Paulette
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # En tant qu'administrateur
    Depuis la page d'accueil  admin  admin
    # On ouvre l'onglet instruction du nouveau DI
    Depuis le formulaire de modification du dossier d'instruction  ${di_libelle}

    # On vérifie le contenu du select des instructeurs
    @{select_instructeur} =  Get List Items  instructeur
    Should Not Contain Match  ${select_instructeur}  Nathalie Chartier
    # On vérifie le contenu du select des divisions
    @{select_division} =  Get List Items  division
    Should Not Contain Match  ${select_division}  Nathalie Chartier

Bible
    [Documentation]  L'objet de ce 'Test Case' est de vérifier le filtre des
    ...    éléments de la bible proposés dans les instructions des DI selon
    ...    la collectivité à laquelle ils sont rattachés.
    ...    Un 2ème cas d'utilisation est un TNR, on vérifie que pour un code de type de
    ...    DA sur 3 caractères, l'ajout d'une bible sur une instruction fonctionne.

    # Constitution du jeu de données : l'objectif est d'avoir des éléments
    # rattachés à des collectivités mono distinctes et à la multicollectivité.
    # En tant qu'administrateur
    Depuis la page d'accueil  admin  admin
    # Donnée 1/7 : collectivité 'Plan de Cuques' de niveau 1
    Ajouter la collectivité depuis le menu  Plan de Cuques  mono
    # Donnée 2/7 : collectivité 'Plan de Campagne' de niveau 1
    Ajouter la collectivité depuis le menu  Plan de Campagne  mono
    # Donnée 3/7 : bible rattachée à Plan de Cuques
    Ajouter une bible depuis l'onglet de l'événement  Notification du delai legal maison individuelle  Bibcuq  Bibcuq  complément 1  Oui  Permis de construire  Plan de Cuques
    # Donnée 4/7 : bible rattachée à Plan de Campagne
    Ajouter une bible depuis l'onglet de l'événement  Notification du delai legal maison individuelle  Bibcamp  Bibcamp  complément 1  Oui  Permis de construire  Plan de Campagne
    # Donnée 5/7 : guichetier rattaché à 'Plan de Cuques'
    Ajouter l'utilisateur  Bilodeau Simone  support@atreal.fr  quicuq  quicuq  GUICHET UNIQUE  Plan de Cuques
    # Donnée 6/7 : instructeur rattaché à 'Plan de Cuques'
    Ajouter l'utilisateur  Huard Franck  support@atreal.fr  instrcuq  instrcuq  INSTRUCTEUR  Plan de Cuques
    Ajouter la direction depuis le menu  PDC  Direction PDC  null  Chef PDC  null  null  Plan de Cuques
    Ajouter la division depuis le menu  PDC  subdivision PDC  null  Chef PDC  null  null  Direction PDC
    Ajouter l'instructeur depuis le menu  Huard Franck  subdivision PDC  instructeur  Huard Franck
    # Donnée 7/7 : affectation automatique du nouvel instructeur
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Huard Franck (PDC)
    ...  om_collectivite=Plan de Cuques
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # On passe le code du type de DA sur 3 caractères
    &{args_type_da} =  Create Dictionary
    ...  code=PCI
    Modifier le type de dossier d'autorisation  PC  ${args_type_da}

    # On crée une nouvelle demande via le tableau de bord
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pellerin
    ...  particulier_prenom=Olivier
    ...  om_collectivite=Plan de Cuques

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Plan de Cuques
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # En tant qu'instructeur de Plan de Cuques
    Depuis la page d'accueil  instrcuq  instrcuq
    # On ouvre l'onglet instruction du nouveau DI
    Depuis l'onglet instruction du dossier d'instruction  ${di_libelle}
    # On accède à l'instruction
    Click On Link  Notification du delai legal maison individuelle
    # On reprend la rédaction
    Click On SubForm Portlet Action  instruction  definaliser
    # On revient au tableau
    Click On Back Button In Subform
    # On ré-accède à l'instruction
    Click On Link  Notification du delai legal maison individuelle
    # On modifie l'instruction
    Click On SubForm Portlet Action  instruction  modifier
    # On ajoute automatiquement la bible de Plan de Cuques
    Ajout automatique de complément(s) d'instruction
    # On vérifie le contenu du champ complément 1
    HTML Should Contain  complement_om_html  Bibcuq
    HTML Should Not Contain  complement_om_html  Bibcamp
    # On revient au tableau
    Depuis l'onglet instruction du dossier d'instruction  ${di_libelle}
    # On ré-accède à l'instruction
    Click On Link  Notification du delai legal maison individuelle
    # On modifie l'instruction
    Click On SubForm Portlet Action  instruction  modifier
    # On ouvre la bible du complément 1
    Ouvrir la bible du complément d'instruction n°  1
    Capture Page Screenshot
    Element Text Should Not Be  content0  Bibcamp
    Element Text Should Be  content0  Bibcuq
    Element Should Not Be Visible  content1

    # On remet le type de DA dans l'état initial
    Depuis la page d'accueil  admin  admin
    &{args_type_da} =  Create Dictionary
    ...  code=PC
    Modifier le type de dossier d'autorisation  PCI  ${args_type_da}

Widget
    [Documentation]  L'objet de ce 'Test Case' est de vérifier le filtre des
    ...    dossiers proposés dans les widgets selon la collectivité à laquelle
    ...    ils sont rattachés.

    # Constitution du jeu de données : l'objectif est d'avoir des éléments
    # rattachés à des collectivités mono distinctes et à la multicollectivité.

    # En tant qu'administrateur
    Depuis la page d'accueil  admin  admin
    # Donnée 1/7 : collectivité 'Toulon' de niveau 1
    Ajouter la collectivité depuis le menu  Toulon  mono
    # Donnée 2/7 : collectivité 'Berre' de niveau 1
    Ajouter la collectivité depuis le menu  Berre  mono
    # Donnée 6/7 : divisionnaire rattaché à 'agglo'
    Ajouter l'utilisateur  Lizotte Marcel  support@atreal.fr  divagglo  divagglo  DIVISIONNAIRE  agglo
    # Donnée 7/7 : divisionnaire rattaché à 'Toulon'
    Ajouter l'utilisateur  Royden Arnaud  support@atreal.fr  divtou  divtou  DIVISIONNAIRE  Toulon
    # Premier DI mono

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Platt
    ...  particulier_prenom=Guillaume
    ...  om_collectivite=Toulon

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Toulon
    ${di_toulon} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_toulon_ns} =  Sans espace  ${di_toulon}

    # Second DI mono
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Kerman
    ...  particulier_prenom=Nicolas
    ...  om_collectivite=Berre

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Berre
    ${di_berre} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Set Suite Variable  ${di_berre}
    ${di_berre_ns} =  Sans espace  ${di_berre}
    Set Suite Variable  ${di_berre_ns}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Varden
    ...  particulier_prenom=Lucie
    ...  om_collectivite=agglo

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=agglo
    ${di_agglo} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Set Suite Variable  ${di_agglo}
    ${di_agglo_ns} =  Sans espace  ${di_agglo}
    Set Suite Variable  ${di_agglo_ns}
    # Ajout des widgets au tableau de bord des divisionnaires
    Depuis la page d'accueil  admin  admin
    Ajouter le widget au tableau de bord  DIVISIONNAIRE  Recherche accès direct
    # Cas 1/2 : Divisionnaire multi peut recherche tous les DI
    Depuis la page d'accueil  divagglo  divagglo
    Input Text  dossier  ${di_toulon_ns}
    Click Element  css=input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_toulon}
    Go To Dashboard
    Input Text  dossier  ${di_berre_ns}
    Click Element  css=input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_berre}
    Go To Dashboard
    Input Text  dossier  ${di_agglo_ns}
    Click Element  css=input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_agglo}
    # Cas 2/2 : Divisionnaire mono ne peut rechercher que les DI de sa collectivité
    Depuis la page d'accueil  divtou  divtou
    Input Text  dossier  ${di_toulon_ns}
    Click Element  css=input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_toulon}
    Go To Dashboard
    Input Text  dossier  ${di_berre_ns}
    Click Element  css=input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Aucun dossier trouvé
    Input Text  dossier  ${di_agglo_ns}
    Click Element  css=input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Aucun dossier trouvé

Consultation via URL
    [Documentation]  L'objet de ce 'Test Case' est de vérifier la condition d'accès
    ...    à un DI selon sa collectivité ainsi que celle de l'utilisateur loggué.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Mason
    ...  particulier_prenom=Thomas
    ...  om_collectivite=ALLAUCH
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=ALLAUCH
    ${di_allauch} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_allauch_ns} =  Sans espace  ${di_allauch}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Villareal
    ...  particulier_prenom=Antoine
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_marseille} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_marseille_ns} =  Sans espace  ${di_marseille}

    # En tant qu'instructeur agglo on a accès à tous les DI
    Depuis la page d'accueil  divagglo  divagglo
    # Accès OK à un DI d'Allauch
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${di_allauch_ns}
    Page Should Not Contain  Droits insuffisants
    Element Should Contain  css=#dossier_libelle  ${di_allauch}
    # Accès OK à un DI de Marseille
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${di_marseille_ns}
    Page Should Not Contain  Droits insuffisants
    Element Should Contain  css=#dossier_libelle  ${di_marseille}
    # Accès OK à un DI de Berre (commune non paramétrée)
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${di_berre_ns}
    Page Should Not Contain  Droits insuffisants
    Element Should Contain  css=#dossier_libelle  ${di_berre}
    # Accès OK à un DI agglo
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${di_agglo_ns}
    Page Should Not Contain  Droits insuffisants
    Element Should Contain  css=#dossier_libelle  ${di_agglo}

    # En tant qu'instructeur poly d'Allauch
    Depuis la page d'accueil  instrpolycomm3  instrpolycomm3
    # Accès OK à un DI d'Allauch
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${di_allauch_ns}
    Page Should Not Contain  Droits insuffisants
    Element Should Contain  css=#dossier_libelle  ${di_allauch}
    # Accès KO à un DI de Marseille
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${di_marseille_ns}
    Page Should Contain  Droits insuffisants
    # Accès KO à un DI de Berre (commune non paramétrée)
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${di_berre_ns}
    Page Should Contain  Droits insuffisants
    # Accès KO à un DI agglo
    Go To    ${PROJECT_URL}${OM_ROUTE_FORM}&obj=dossier_instruction&action=3&idx=${di_agglo_ns}
    Page Should Contain  Droits insuffisants


TNR Filtre incorrect sur les services à consulter

    [Documentation]  Lorsqu'on était dans le contexte de surcharge de dossier_instruction
    ...  (mes_encours, mes_clotures...) le filtre sur les services n'était pas appliqué.
    ...  Ce test vérifie indirectement que les abrégés des service soient bien présents
    ...  pour l'ajout de consultations et consultations multiples.

    Depuis la page d'accueil  admin  admin
    # Ajoute un service sur la collectivité Allauch
    &{service} =  Create Dictionary
    ...  abrege=77.81
    ...  libelle=Serviceallauch
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=ALLAUCH
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    # Ajoute un service sur la collectivité Marseille
    &{service} =  Create Dictionary
    ...  abrege=77.82
    ...  libelle=Servicemarseille
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Fluet
    ...  particulier_prenom=Brice
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=03/02/2016
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    # Se rend sur le formulaire d'ajout d'une consultation
    Depuis le contexte du dossier d'instruction de mes encours  ${di}
    On clique sur l'onglet  consultation  Consultation(s)
    # On clic sur le bouton d'ajout
    Click On Add Button JS
    @{select_service} =  Get List Items  service
    # Vérifie que la consultation de marseille est présente, et pas celle d'Allauch
    Should Contain Match  ${select_service}  77.82 - Servicemarseille
    Should Not Contain Match  ${select_service}  77.81 - Serviceallauch
    Click On Back Button In Subform
    # Vérifie que le filtre est aussi appliqué pour l'ajout multiple
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter_multiple
    Element Should Contain In Subform  css=div.list-ser-them  77.82 - Servicemarseille
    Element Should Not Contain  css=div.list-ser-them  77.81 - Serviceallauch


TNR Vérification des variables de remplacement en multi-collectivité

    [Documentation]  Ce test permet de contrôler l'affichage des variables de
    ...  remplacement dans le titre et le corps d'une édition, dans plusieurs
    ...  contextes différents et avec différents utilisateurs.

    #
    Depuis la page d'accueil  admin  admin
    #
    Modifier le paramètre  departement  777  agglo
    #
    Ajouter le paramètre depuis le menu  departement  888  MARSEILLE

    # Le contenu de la nouvelle lettre-type de test, avec &contraintes sans paramètres
    &{args_lettretype} =  Create Dictionary
    ...  id=test_XXX
    ...  libelle=Test
    ...  sql=Aucune REQUÊTE
    ...  titre=&idx, &destinataire, aujourdhui&aujourdhui, datecourrier&datecourrier, &departement
    ...  corps=<p><br pagebreak="true" /></p>&idx, &destinataire, aujourdhui&aujourdhui, datecourrier&datecourrier, &departement
    ...  actif=true
    ...  collectivite=agglo
    #
    Ajouter la lettre-type depuis le menu  &{args_lettretype}
    #
    Modifier la lettre-type  test_XXX

    # Création d'un événement de workflow de changement de décision
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=TEST_XXX
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=test_XXX Test
    #
    Ajouter l'événement depuis le menu  ${args_evenement}

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Hervé
    ...  particulier_prenom=Marguerite
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis le contexte du dossier d'instruction  ${di}
    #
    Ajouter une instruction au DI  ${di}  TEST_XXX

    #
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_XXX
    #
    ${instruction} =  Get Text  css=#form-content #instruction

    # On ouvre le PDF de l'instruction
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  ${instruction}
    PDF Page Number Should Contain  1  &destinataire
    PDF Page Number Should Contain  1  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  1  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  1  888
    # On contrôle le corps
    PDF Page Number Should Contain  2  ${instruction}
    PDF Page Number Should Contain  2  &destinataire
    PDF Page Number Should Contain  2  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  2  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  2  888
    # On ferme le PDF
    Close PDF

    #
    Depuis la page d'accueil  admin  admin
    #
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_XXX
    # On ouvre le PDF de l'instruction
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  ${instruction}
    PDF Page Number Should Contain  1  &destinataire
    PDF Page Number Should Contain  1  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  1  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  1  888
    # On contrôle le corps
    PDF Page Number Should Contain  2  ${instruction}
    PDF Page Number Should Contain  2  &destinataire
    PDF Page Number Should Contain  2  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  2  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  2  888
    # On ferme le PDF
    Close PDF

    #
    Supprimer le paramètre  departement  888

    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_XXX
    # On ouvre le PDF de l'instruction
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  ${instruction}
    PDF Page Number Should Contain  1  &destinataire
    PDF Page Number Should Contain  1  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  1  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  1  777
    # On contrôle le corps
    PDF Page Number Should Contain  2  ${instruction}
    PDF Page Number Should Contain  2  &destinataire
    PDF Page Number Should Contain  2  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  2  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  2  777
    # On ferme le PDF
    Close PDF

    #
    Depuis la page d'accueil  admin  admin
    #
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_XXX
    # On ouvre le PDF de l'instruction
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  ${instruction}
    PDF Page Number Should Contain  1  &destinataire
    PDF Page Number Should Contain  1  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  1  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  1  777
    # On contrôle le corps
    PDF Page Number Should Contain  2  ${instruction}
    PDF Page Number Should Contain  2  &destinataire
    PDF Page Number Should Contain  2  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  2  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  2  777
    # On ferme le PDF
    Close PDF

    #
    Supprimer le paramètre  departement  777

    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_XXX
    # On ouvre le PDF de l'instruction
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  ${instruction}
    PDF Page Number Should Contain  1  &destinataire
    PDF Page Number Should Contain  1  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  1  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  1  &departement
    # On contrôle le corps
    PDF Page Number Should Contain  2  ${instruction}
    PDF Page Number Should Contain  2  &destinataire
    PDF Page Number Should Contain  2  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  2  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  2  &departement
    # On ferme le PDF
    Close PDF

    #
    Depuis la page d'accueil  admin  admin
    #
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_XXX
    # On ouvre le PDF de l'instruction
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  ${instruction}
    PDF Page Number Should Contain  1  &destinataire
    PDF Page Number Should Contain  1  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  1  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  1  &departement
    # On contrôle le corps
    PDF Page Number Should Contain  2  ${instruction}
    PDF Page Number Should Contain  2  &destinataire
    PDF Page Number Should Contain  2  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  2  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  2  &departement
    # On ferme le PDF
    Close PDF

    #
    Ajouter le paramètre depuis le menu  departement  888  MARSEILLE

    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_XXX
    # On ouvre le PDF de l'instruction
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  ${instruction}
    PDF Page Number Should Contain  1  &destinataire
    PDF Page Number Should Contain  1  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  1  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  1  888
    # On contrôle le corps
    PDF Page Number Should Contain  2  ${instruction}
    PDF Page Number Should Contain  2  &destinataire
    PDF Page Number Should Contain  2  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  2  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  2  888
    # On ferme le PDF
    Close PDF

    #
    Depuis la page d'accueil  admin  admin
    #
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_XXX
    # On ouvre le PDF de l'instruction
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On contrôle le titre
    PDF Page Number Should Contain  1  ${instruction}
    PDF Page Number Should Contain  1  &destinataire
    PDF Page Number Should Contain  1  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  1  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  1  888
    # On contrôle le corps
    PDF Page Number Should Contain  2  ${instruction}
    PDF Page Number Should Contain  2  &destinataire
    PDF Page Number Should Contain  2  aujourdhui${date_ddmmyyyy}
    PDF Page Number Should Contain  2  datecourrier${date_ddmmyyyy}
    PDF Page Number Should Contain  2  888
    # On ferme le PDF
    Close PDF

    # On remet les paramètres par défaut
    Ajouter le paramètre depuis le menu  departement  013  agglo
    Supprimer le paramètre  departement  888


Option de renommage du libellé "Collectivité" pour "Service" dans les affichages
    [Documentation]  Vérification dans les différents affichages de la modification
    ...  de "Collectivité" en "Service".
    ...  La modification étant faite en surchargeant les méthodes du framework,
    ...  tous les affichages tels que les formulaires et listings sont impactés
    ...  sans modification spécifique dans les différentes classes.
    ...  Seulement quelques écrans ont été modifiés spécifiquement.

    ${value_expected} =  Set Variable  Service
    ${value_expected_min} =  Set Variable  service
    ${value_unexpected} =  Set Variable  Collectivité

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_renommer_collectivite
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # Vérification du menu
    Depuis le listing des collectivités
    ${menu_om_collectivite} =  Get Text  css=#menu-list li.collectivite a.collectivite-16
    Should Be Equal  ${value_expected}  ${menu_om_collectivite}

    # Vérification dans le listing des collectivité
    Depuis le listing des collectivités
    Breadcrumb Should Contain  ${value_expected}
    ${header_om_collectivite} =  Get Text  css=table.tab-tab th.firstcol span.name a
    Should Be Equal  ${value_expected_min}  ${header_om_collectivite}
    # Vérification dans le listing des dossiers d'instruction
    Depuis le listing  dossier_instruction
    ${header_dossier} =  Get Text  css=table.tab-tab th.lastcol span.name a
    Should Be Equal  ${value_expected_min}  ${header_dossier}

    # Vérification sur un formulaire de collectivité (consultation)
    ${omc_lib} =  Set Variable  FREECITY010RCS
    Ajouter la collectivité depuis le menu  ${omc_lib}  mono
    Depuis le contexte de la collectivité  ${omc_lib}
    Breadcrumb Should Contain  ${value_expected}
    ${label_om_collectivite} =  Get Text  css=#lib-om_collectivite
    Should Be Equal  ${value_expected}  ${label_om_collectivite}
    # Vérification sur un formulaire de paramètres (consultation)
    ${omp_lib} =  Set Variable  TEST010RCS
    Ajouter le paramètre depuis le menu  ${omp_lib}  ${omp_lib}  ${omc_lib}
    Depuis le contexte du paramètre  ${omp_lib}
    ${label_om_collectivite} =  Get Text  css=#lib-om_collectivite
    Should Be Equal  ${value_expected}  ${label_om_collectivite}
    # Vérification sur un formulaire de direction (consultation)
    ${dir_lib} =  Set Variable  DIR010RCS
    Ajouter la direction depuis le menu  D010RCS  ${dir_lib}  null  chef  null  null  ${omc_lib}
    Depuis le contexte de la direction  ${dir_lib}
    ${label_om_collectivite} =  Get Text  css=#lib-om_collectivite
    Should Be Equal  ${value_expected}  ${label_om_collectivite}

    # Vérification du select et du fieldset lors de l'ajout d'une demande avec
    # un demandeur
    ${demande_omc_select} =  Set Variable  css=div#formulaire select#om_collectivite
    ${demandeur_omc_select} =  Set Variable  css=div#sformulaire select#om_collectivite
    ${demandeur_fieldset} =  Set Variable  css=fieldset#fieldset-sousform-petitionnaire-service
    @{list_value_expected} =  Create List  choisir le ${value_expected}
    @{list_value_unexpected} =  Create List  choisir ${value_unexpected}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${omc_lib}
    Depuis le contexte de nouvelle demande via le menu
    ${label_om_collectivite} =  Get Text  css=#lib-om_collectivite
    Should Contain  ${label_om_collectivite}  ${value_expected}
    Select List Should Contain List  ${demande_omc_select}  ${list_value_expected}
    Select List Should Not Contain List  ${demande_omc_select}  ${list_value_unexpected}
    Saisir la demande  ${args_demande}
    Click Element Until New Element  add_petitionnaire_principal  css=.ui-widget-overlay
    Element Should Contain  ${demandeur_fieldset}  ${value_expected}
    Select List Should Contain List  ${demandeur_omc_select}  ${list_value_expected}
    Select List Should Not Contain List  ${demandeur_omc_select}  ${list_value_unexpected}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_renommer_collectivite
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
