*** Settings ***
Documentation  Gestion des demandes d'avis.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Réponse à une consultation par le service consulté

    [Documentation]

    ##
    ## Constitution du jeu de données
    ##
    #
    # Le dossier di_1 est affecté à l'instructeur "Louis Laurent" (instr) division "H"
    #
    #
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instr  instr
    #
    Ajouter une consultation depuis un dossier  ${di}  59.01 - Direction de l'Eau et de l'Assainissement

    ##
    ## Cas d'usage n°1 :
    ##
    ## Connexion et redirection automatique ver le listing des demandes
    ## d'avis en cours
    ##
    # On se connecte en tant que "consu"
    Depuis la page d'accueil  consu  consu
    # On vérifie que nous sommes dans le contexte (listing) "Demande d'avis en cours"
    Submenu In Menu Should Be Selected  demande_avis  demande_avis_encours
    Page Title Should Be  Demandes D'avis > En Cours
    First Tab Title Should Be  Demandes D'avis En Cours
    # Le dossier doit apparaître dans ce listing
    Page Should Contain  ${di}

    ##
    ## Cas d'usage n°2 :
    ##
    ## On rend l'avis sans saisir aucune valeur mais le dossier est toujours disponible
    ## dans les demandes d'avis en cours
    ##
    # On clique sur le lien du dossier
    Click On Link  ${di}
    # On vérifie que nous sommes dans le contexte (form) "Demande d'avis en cours"
    Submenu In Menu Should Be Selected  demande_avis  demande_avis_encours
    Page Title Should Be  Demandes D'avis > En Cours
    First Tab Title Should Be  Demandes D'avis En Cours
    # On clique sur le lien "Rendre un avis" dans le portlet
    Click On SubForm Portlet Action  demande_avis_encours  rendre_avis  modale
    # On clique sur le bouton "Modifier" du formulaire sans saisir de retour d'avis
    Click On Submit Button In Subform  #sousform-demande_avis_encours
    # On vérifie que le message de validation est présent
    Page Should Contain  Vos modifications ont bien été enregistrées.
    # Retour à la liste des demandes
    Click On Back Button In Subform
    # On vérifie que nous sommes dans le contexte (listing) "Demande d'avis en cours"
    Wait Until Element Is Visible  css=#advanced-form
    Submenu In Menu Should Be Selected  demande_avis  demande_avis_encours
    Page Title Should Be  Demandes D'avis > En Cours
    First Tab Title Should Be  Demandes D'avis En Cours
    # Le dossier doit apparaître dans ce listing
    Page Should Contain  ${di}

    ##
    ## Cas d'usage n°3 :
    ##
    ## On accède au document d'avis au format PDF, on rend l'avis et le
    ## dossier n'est plus disponible dans les demandes d'avis en cours
    ## mais se retrouve dans les demandes d'avis passées
    ##
    # On clique sur le lien du dossier
    Click On Link  ${di}
    # On vérifie que nous sommes dans le contexte (form) "Demande d'avis en cours"
    Submenu In Menu Should Be Selected  demande_avis  demande_avis_encours
    Page Title Should Be  Demandes D'avis > En Cours
    First Tab Title Should Be  Demandes D'avis En Cours
    # On clique sur le lien "Edition" dans le portlet
    Click On SubForm Portlet Action  demande_avis_encours  consulter_pdf  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le champ de fusion du di
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di}
    # On ferme le PDF
    Close PDF
    # On clique sur le lien "Rendre un avis" dans le portlet
    Click On SubForm Portlet Action  demande_avis_encours  rendre_avis  modale
    # On tente d'ajouter un fichier trop gros
    Add File and Expect Error Message Contain  fichier  image_1.jpg  excède la directive
    # On tente d'ajouter un fichier avec une mauvais extension
    Add File and Expect Error Message Be  fichier  fichier_1.odt  Le fichier n'est pas conforme à la liste des extension(s) autorisée(s) (.pdf). [fichier_1.odt]
    # Saisie des valeurs dans le formulaire
    Select From List By Label  css=select#avis_consultation  Defavorable
    Input Text  css=textarea#motivation  Pas motivé
    Add File  fichier  lettre_rar16042013124515.pdf
    # On clique sur le bouton "Modifier" du formulaire
    Click On Submit Button In Subform  #sousform-demande_avis_encours
    # On vérifie que le message de validation est présent
    Page Should Contain  Vos modifications ont bien été enregistrées.
    # Retour à la liste des demandes
    Click On Back Button In Subform
    # On vérifie que nous sommes dans le contexte (listing) "Demande d'avis en cours"
    Wait Until Element Is Visible  css=#advanced-form
    Submenu In Menu Should Be Selected  demande_avis  demande_avis_encours
    Page Title Should Be  Demandes D'avis > En Cours
    First Tab Title Should Be  Demandes D'avis En Cours
    # Le dossier ne doit pas apparaître dans ce listing
    Page Should Not Contain  ${di}
    # On vérifie que nous sommes dans le contexte (listing) "Demande d'avis passée"
    Go To Submenu In Menu  demande_avis  demande_avis_passee
    Page Title Should Be  Demandes D'avis > Passées
    First Tab Title Should Be  Demandes D'avis Passées
    # Le dossier doit apparaître dans ce listing
    Page Should Contain  ${di}


    ##
    ## Cas d'usage n°4 :
    ##
    ## Une fois l'avis rendu, le dossier n'est plus disponible dans les
    ## demandes d'avis en cours mais se retrouve dans les demandes d'avis
    ## passées. On peut accéder au document d'avis au format PDF. On peut
    ## visualiser l'avis rendu, la motivation et le fichier
    ##
    # On clique sur le lien du dossier
    Click On Link  ${di}
    # On vérifie que nous sommes dans le contexte (listing) "Demande d'avis passée"
    Submenu In Menu Should Be Selected  demande_avis  demande_avis_passee
    Page Title Should Be  Demandes D'avis > Passées
    First Tab Title Should Be  Demandes D'avis Passées
    # On vérifie que les valeurs saisies ont bien été enregistrées
    Element Should Contain  css=#dossier_libelle  ${di}
    Element Should Contain  css=#avis_consultation  Defavorable
    Element Should Contain  css=#motivation  Pas motivé
    Element Should Contain  css=#fichier  consultation_avis
    # On clique sur le lien "Edition" dans le portlet
    Click On SubForm Portlet Action  demande_avis_passee  consulter_pdf  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le champ de fusion du di
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di}
    # On vérifie le libellé du service et le type de consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Avis demandé - pour conformité
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Direction de l'Eau et de l'Assainissement
    # On ferme le PDF
    Close PDF

    # On vérifie que les données techniques sont disponibles depuis le DA
    ${da} =  Get Substring  ${di}  0  -2
    Depuis le contexte du dossier d'autorisation  ${da}
    Element Should Be Visible  css=#donnees_techniques_da

Export des demandes d'avis

    [Documentation]

    # On se connecte en tant que "consu"
    Depuis la page d'accueil  consu  consu
    # Télécharge le fichier d'export CSV sur le disque
    Depuis le listing des demandes d'avis exports
    ${link} =  Get Element Attribute  css=div.tab-export a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    # On vérifie dans le fichier téléchargé que l'entête correspond à ce qui est attendu
    ${content_file} =  Get File  ${full_path_to_file}
    ${header_csv_file} =  Set Variable  dossier;"adresse pétitionnaire";"type de dossier";"num voie chantier";"adresse chantier";"code postal chantier";"ville chantier";"date limite";"date de dépôt";"références cadastrales";"numero d'avis";travaux;"avis rendu";"date de l'avis rendu";motivation;"présence fichier";"état du dossier";"sdp totale existante";zonages;risques;"sdp totale créée";"sdp créée par destination";"surface terrain";"nombre total de logements";"nombre de parkings"

    Should Contain  ${content_file}  ${header_csv_file}


Marquer un dossier pour une demande d'avis en cours

    [Documentation]  Créée un dossier, lui ajoute une consultation, puis vérifie qu'en
    ...  tant que profil "consu" marquer et démarquer un dossier est possible. On vérifie
    ...  ensuite l'icone affiché dans le listing des demandes d'avis en cours.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Leduc
    ...  particulier_prenom=Emmanuel
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'une consultation
    Depuis la page d'accueil  instr  instr
    Ajouter une consultation depuis un dossier  ${di}  59.01 - Direction de l'Eau et de l'Assainissement

    Depuis la page d'accueil  consu  consu
    Depuis le listing des demandes d'avis en cours
    # On vérifie que le dossier créé est présent
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  tab-demande_avis_encours  ${di}

    Depuis la demande d'avis en cours du dossier  ${di}
    # Marque le dossier et vérifie que marque = Oui dans le formulaire
    Marquer le dossier
    Depuis le listing des demandes d'avis en cours
    # L'icone "marque" doit être présent
    Element Should Be Visible  css=span.marque-16

    Depuis la demande d'avis en cours du dossier  ${di}
    # Dé-marque le dossier et vérifie que marque = Non dans le formulaire
    Dé-marquer le dossier


Vérifier l'onglet des consultations depuis une demande d'avis

    [Documentation]  On vérifie les affichages de l'onglet des consultations
    ...  dans le contexte d'une demande d'avis avec les différents services
    ...  consultés.

    # Libellés des services utilsés dans ce test
    ${service_1} =  Set Variable  59.01 - Direction de l'Eau et de l'Assainissement
    ${service_2} =  Set Variable  95A - Direction de la circulation
    ${service_3} =  Set Variable  96B - Direction de la circulation piétonne

    # On ajoute un service qui sera lié à l'utilisateur ayant le profil de
    # service consulté interne
    Depuis la page d'accueil  admin  admin
    &{service} =  Create Dictionary
    ...  abrege=95A
    ...  libelle=Direction de la circulation
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=tru
    Ajouter le service depuis le listing  ${service}
    &{lien_service_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Service consulté interne
    ...  service=Direction de la circulation
    Ajouter lien service/utilisateur  ${lien_service_om_utilisateur}

    # On ajoute un service qui sera lié à l'utilisateur ayant le profil de
    # service consulté étendu
    &{service} =  Create Dictionary
    ...  abrege=96B
    ...  libelle=Direction de la circulation piétonne
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    &{lien_service_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Service consulté étendu
    ...  service=Direction de la circulation piétonne
    Ajouter lien service/utilisateur  ${lien_service_om_utilisateur}

    # On ajoute un dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Sanschagrin
    ...  particulier_prenom=David
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On ajoute une consultation pour le service lié à l'utilisateur consu, une
    # pour le service lié à l'utilisateur consuint, et une autre pour le service
    # lié à l'utilisateur consuetendu
    Depuis la page d'accueil  instr  instr
    Ajouter une consultation depuis un dossier  ${di}  ${service_1}
    Ajouter une consultation depuis un dossier  ${di}  ${service_2}
    Ajouter une consultation depuis un dossier  ${di}  ${service_3}

    # On se connecte avec l'utilisateur ayant le profil de service consulté
    # externe et on vérifie qu'il n'ait pas accès à l'onglet des consultations
    Depuis la page d'accueil  consu  consu
    Depuis la demande d'avis en cours du dossier  ${di}
    L'onglet ne doit pas être présent  consultation
    Depuis la demande d'avis export du dossier  ${di}
    L'onglet ne doit pas être présent  consultation
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  fichier_upload=testImportManuel.pdf
    Rendre l'avis sur la consultation du dossier  ${di}  ${args_avis_consultation}
    Depuis la demande d'avis passée du dossier  ${di}
    L'onglet ne doit pas être présent  consultation

    # On se connecte avec l'utilisateur ayant le profil de service consulté
    # interne et on vérifie qu'il n'ait pas accès à l'onglet des consultations
    Depuis la page d'accueil  consuint  consuint
    Depuis la demande d'avis en cours du dossier  ${di}
    L'onglet ne doit pas être présent  consultation
    Depuis la demande d'avis export du dossier  ${di}
    L'onglet ne doit pas être présent  consultation
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  fichier_upload=testImportManuel.pdf
    Rendre l'avis sur la consultation du dossier  ${di}  ${args_avis_consultation}
    Depuis la demande d'avis passée du dossier  ${di}
    L'onglet ne doit pas être présent  consultation

    # On vérifie que l'onglet des consultations ne soit pas disponible depuis
    # le contexte des DI
    Depuis le contexte du dossier d'instruction  ${di}
    L'onglet ne doit pas être présent  consultation

    # On se connecte avec l'utilisateur ayant le profil de service consulté
    # étendu et on vérifie qu'il ait accès à l'onglet des consultations
    Depuis la page d'accueil  consuetendu  consuetendu
    Depuis la demande d'avis en cours du dossier  ${di}
    L'onglet doit être présent  consultation  Consultation(s)
    Depuis la demande d'avis export du dossier  ${di}
    L'onglet doit être présent  consultation  Consultation(s)
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  fichier_upload=testImportManuel.pdf
    Rendre l'avis sur la consultation du dossier  ${di}  ${args_avis_consultation}
    Depuis la demande d'avis passée du dossier  ${di}
    L'onglet doit être présent  consultation  Consultation(s)

    # On vérifie l'affichage du listing des consultations
    On clique sur l'onglet  consultation  Consultation(s)
    L'action ajouter ne doit pas être disponible
    # L'action d'ajout multiple ne doit pas être disponible non plus
    Page Should Not Contain Element  css=span.mut-add-16

    # On vérifie l'affichage du formulaire des consultation
    Click On Link  ${service_3}
    Le portlet d'action ne doit pas être présent dans le sous-formulaire
    # Le fichier joint doit être consultable
    Click On Link  css=div#sousform-consultation div#fichier span.reqmo-16 a
    Open PDF  ${OM_PDF_TITLE}
    PDF Page Number Should Contain  1  TEST IMPORT MANUEL 1
    Close PDF


Vérification du champ de recherche avis rendu des demandes d'avis

    [Documentation]  On vérifie le fonctionnement de la recherche avancée sur le champ avis rendu
    ...  dans le contexte d'une demande d'avis passées.

    &{args_petitionnaire_1} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=MARSEILLE
    #
    &{args_petitionnaire_2} =  Create Dictionary
    ...  particulier_nom=TONDUP
    ...  particulier_prenom=Jeremy
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=11/04/2015
    ...  om_collectivite=MARSEILLE
    #
    &{args_petitionnaire_3} =  Create Dictionary
    ...  particulier_nom=TUNG
    ...  particulier_prenom=Pascal
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_3} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=14/04/2015
    ...  om_collectivite=MARSEILLE
    #
    &{args_petitionnaire_4} =  Create Dictionary
    ...  particulier_nom=GUNT
    ...  particulier_prenom=Damien
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_4} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=17/04/2015
    ...  om_collectivite=MARSEILLE
    #
    ${di_1} =  Ajouter la demande par WS  ${args_demande_1}  ${args_petitionnaire_1}
    ${di_2} =  Ajouter la demande par WS  ${args_demande_2}  ${args_petitionnaire_2}
    ${di_3} =  Ajouter la demande par WS  ${args_demande_3}  ${args_petitionnaire_3}
    ${di_4} =  Ajouter la demande par WS  ${args_demande_4}  ${args_petitionnaire_4}

    # On se connecte en tant que "inst"
    Depuis la page d'accueil  instr  instr

    Ajouter une consultation depuis un dossier  ${di_1}  59.01 - Direction de l'Eau et de l'Assainissement
    Ajouter une consultation depuis un dossier  ${di_2}  59.01 - Direction de l'Eau et de l'Assainissement
    Ajouter une consultation depuis un dossier  ${di_3}  59.01 - Direction de l'Eau et de l'Assainissement
    Ajouter une consultation depuis un dossier  ${di_4}  59.01 - Direction de l'Eau et de l'Assainissement

    # On se connecte en tant que "consu"
    Depuis la page d'accueil  consu  consu

    &{args_avis_consultation_1} =  Create Dictionary
    ...  avis_consultation=Favorable
    Rendre l'avis sur la consultation du dossier  ${di_1}  ${args_avis_consultation_1}

    &{args_avis_consultation_2} =  Create Dictionary
    ...  avis_consultation=Favorable
    Rendre l'avis sur la consultation du dossier  ${di_2}  ${args_avis_consultation_2}

    &{args_avis_consultation_3} =  Create Dictionary
    ...  avis_consultation=Defavorable
    Rendre l'avis sur la consultation du dossier  ${di_3}  ${args_avis_consultation_3}

    &{args_avis_consultation_4} =  Create Dictionary
    ...  avis_consultation=Defavorable
    Rendre l'avis sur la consultation du dossier  ${di_4}  ${args_avis_consultation_4}

    # On vérifie l'utilisation du champ de recherche pour les demandes d'avis
    # passées
    Depuis le listing des demandes d'avis passées

    #Simuler le clique sur le bouton recherche avancée
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#avis_consultation
    # On recherche les avis rendu Favorable
    Select From List By Label  css=div#adv-search-adv-fields select#avis_consultation  Favorable
    Click On Search Button

    # On vérifie que s'affiche seulement les dossiers avec un avis Favorable
    Element Should Contain  css=.tab-tab  ${di_1}
    Element Should Contain  css=.tab-tab  ${di_2}
    Element Should Not Contain  css=.tab-tab  ${di_3}
    Element Should Not Contain  css=.tab-tab  ${di_4}

    # On vérifie l'utilisation du champ de recherche pour les demandes d'avis
    # export
    Depuis le listing des demandes d'avis exports

    #Simuler le clique sur le bouton recherche avancée
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields select#avis_consultation
    # On recherche les avis rendu Favorable
    Select From List By Label  css=div#adv-search-adv-fields select#avis_consultation  Favorable
    Click On Search Button

    # On vérifie que s'affiche seulement les dossiers avec un avis Favorable
    Element Should Contain  css=.tab-tab  ${di_1}
    Element Should Contain  css=.tab-tab  ${di_2}
    Element Should Not Contain  css=.tab-tab  ${di_3}
    Element Should Not Contain  css=.tab-tab  ${di_4}

    # On vérifie l'utilisation du champ de recherche pour les demandes d'avis
    # en cours
    Depuis le listing des demandes d'avis en cours

    # Le champ de recherche ne doit pas être affiché
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#service_abrege
    Page Should Not Contain Element  css=div#adv-search-adv-fields select#avis_consultation
