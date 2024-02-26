*** Settings ***
Documentation  Lien avec le référentiel ERP.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Constitution du jeu de données

    [Documentation]

    #
    Depuis la page d'accueil    admin    admin
    #
    @{etats_autorises} =    Create List
    ...    delai de notification envoye
    ...    delai majore
    ...    dossier accepter
    ...    dossier accepté tacitement
    ...    dossier en cours de execution
    ...    dossier en fin d instruction
    ...    dossier incomplet
    ...    dossier rejeter manque de pieces
    ...    dossier sans notification de delai
    ...    instruction terminee (archive)
    #
    &{args_evenement} =  Create Dictionary
    ...  libelle=Dépôt de pièces supplémentaires
    ...  lettretype=recepisse_DPC RECEPISSE DE DEPOT DE PIECES COMPLEMENTAIRES
    Ajouter l'événement depuis le menu  ${args_evenement}


    # Type de Demande n°01
    &{args_demande_type_01} =  Create Dictionary
    ...    code=DPS
    ...    libelle=Dépot de pièces supplémentaires AT Test Lien openARIA
    ...    groupe=ERP
    ...    dossier_autorisation_type_detaille=AT (Demande d'autorisation de construire, d'aménager ou de modifier un ERP)
    ...    demande_nature=Dossier existant
    ...    etats_autorises=@{etats_autorises}
    ...    contraintes=Récupération des demandeurs avec modification et ajout
    ...    evenement=Dépôt de pièces supplémentaires
    Ajouter un nouveau type de demande depuis le menu    ${args_demande_type_01}
    Depuis le contexte du type de demande avec libellé unique  ${args_demande_type_01.libelle}
    ${demande_type_01} =  Get Text  css=#demande_type
    Set Suite Variable  ${args_demande_type_01}
    # Type de Demande n°02
    &{args_demande_type_02} =  Create Dictionary
    ...    code=RD
    ...    libelle=Retrait de la demande Test Lien openARIA
    ...    groupe=ERP
    ...    dossier_autorisation_type_detaille=AT (Demande d'autorisation de construire, d'aménager ou de modifier un ERP)
    ...    demande_nature=Dossier existant
    ...    etats_autorises=@{etats_autorises}
    ...    contraintes=Récupération des demandeurs avec modification et ajout
    ...    evenement=retrait avant décision
    Ajouter un nouveau type de demande depuis le menu    ${args_demande_type_02}
    Depuis le contexte du type de demande avec libellé unique  ${args_demande_type_02.libelle}
    ${demande_type_02} =  Get Text  css=#demande_type
    Set Suite Variable  ${args_demande_type_02}
    # Type de Demande n°03
    &{args_demande_type_03} =  Create Dictionary
    ...    code=DO
    ...    libelle=Demande d'ouverture ERP Test Lien openARIA
    ...    groupe=ERP
    ...    dossier_autorisation_type_detaille=AT (Demande d'autorisation de construire, d'aménager ou de modifier un ERP)
    ...    demande_nature=Dossier existant
    ...    etats_autorises=@{etats_autorises}
    ...    contraintes=Récupération des demandeurs avec modification et ajout
    ...    evenement=retrait avant décision
    Ajouter un nouveau type de demande depuis le menu    ${args_demande_type_03}
    Depuis le contexte du type de demande avec libellé unique  ${args_demande_type_03.libelle}
    ${demande_type_03} =  Get Text  css=#demande_type
    Set Suite Variable  ${args_demande_type_03}
    # Type de Demande n°04
    &{args_demande_type_04} =  Create Dictionary
    ...    code=DO
    ...    libelle=Demande d'ouverture ERP PCI Test Lien openARIA
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...    demande_nature=Dossier existant
    ...    etats_autorises=@{etats_autorises}
    ...    contraintes=Récupération des demandeurs avec modification et ajout
    ...    evenement=retrait avant décision
    Ajouter un nouveau type de demande depuis le menu    ${args_demande_type_04}
    Depuis le contexte du type de demande avec libellé unique  ${args_demande_type_04.libelle}
    ${demande_type_04} =  Get Text  css=#demande_type
    Set Suite Variable  ${args_demande_type_04}
    # Type de Demande n°05
    &{args_demande_type_05} =  Create Dictionary
    ...    code=DO
    ...    libelle=Demande d'ouverture ERP PCA Test Lien openARIA
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCA (Permis de construire comprenant ou non des démolitions)
    ...    demande_nature=Dossier existant
    ...    etats_autorises=@{etats_autorises}
    ...    contraintes=Récupération des demandeurs avec modification et ajout
    ...    evenement=retrait avant décision
    Ajouter un nouveau type de demande depuis le menu    ${args_demande_type_05}
    Depuis le contexte du type de demande avec libellé unique  ${args_demande_type_05.libelle}
    ${demande_type_05} =  Get Text  css=#demande_type
    Set Suite Variable  ${args_demande_type_05}
    # Service 1
    &{service_1} =  Create Dictionary
    ...  abrege=SPGR
    ...  libelle=Service Prévention et Gestion des Risques ERP TEST410
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service_1}
    Depuis le contexte du service  ${service_1.libelle}  ${service_1.abrege}
    ${service_1_id} =  Get Text  css=#service
    Set Suite Variable  ${service_1}
    # Service 2
    &{service_2} =  Create Dictionary
    ...  abrege=DPH
    ...  libelle=Direction des Handicapés TEST410
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service_2}
    Depuis le contexte du service  ${service_2.libelle}  ${service_2.abrege}
    ${service_2_id} =  Get Text  css=#service
    Set Suite Variable  ${service_2}
    # Service 3
    &{service_3} =  Create Dictionary
    ...  abrege=DDC
    ...  libelle=Direction de la Circulation TEST410
    ...  edition=Consultation - Pour conformité
    ...  type_consultation=Pour conformité
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service_3}
    Depuis le contexte du service  ${service_3.libelle}  ${service_3.abrege}
    ${service_3_id} =  Get Text  css=#service
    Set Suite Variable  ${service_3}

    # [101][108][112]
    Ajouter le paramètre depuis le menu  erp__dossier__nature__at  AT  agglo
    # [102][103][104][105]
    Ajouter le paramètre depuis le menu  erp__dossier__nature__pc  PC  agglo
    # [112]
    Ajouter le paramètre depuis le menu  erp__demandes__depot_piece__at  ${demande_type_01}  agglo
    # [109]
    Ajouter le paramètre depuis le menu  erp__demandes__retrait__at  ${demande_type_02}  agglo
    # [110]
    Ajouter le paramètre depuis le menu  erp__demandes__ouverture__at  ${demande_type_03}  agglo
    # [107]
    Ajouter le paramètre depuis le menu  erp__demandes__ouverture__pc  ${demande_type_04};${demande_type_05}  agglo
    # [104]
    Ajouter le paramètre depuis le menu  erp__services__avis__pc  ${service_1_id};${service_2_id}  agglo
    # [106]
    Ajouter le paramètre depuis le menu  erp__services__conformite__pc  ${service_3_id}  agglo
    # [105][111]
    Ajouter le paramètre depuis le menu  erp__evenements__decision__pc  81;31;50  agglo

    Ajouter le paramètre depuis le menu  erp__dossier__type_di__pc  1;6  agglo
    #
    Ajouter le paramètre depuis le menu  option_referentiel_erp  true  agglo

    &{om_param} =  Create Dictionary
    ...  libelle=option_notification_piece_numerisee
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}


Message 108

    # [108]
    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_petitionnaire_1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Bati&Co
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=LEROY
    ...  personne_morale_prenom=Georges
    &{args_petitionnaire_2} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Bati&Co
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=DUPONT
    ...  personne_morale_prenom=Jacques
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    ...  demande_type=Dépôt Initial
    #
    ${di_1} =  Ajouter La Nouvelle Demande Depuis Le Tableau De Bord  ${args_demande}  ${args_petitionnaire_1}
    Set Suite Variable  ${di_1}
    #
    ${di_2} =  Ajouter La Nouvelle Demande Depuis Le Tableau De Bord  ${args_demande}  ${args_petitionnaire_2}
    Set Suite Variable  ${di_2}


Message 101

    # [101]
    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis le formulaire de modification du dossier d'instruction  ${di_1}
    #
    Unselect Checkbox  css=#a_qualifier
    #
    Click On Submit Button
    #
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Valid Message Should Contain  Notification (101) du référentiel ERP OK.


Message 112

    # [112]
    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_demande} =  Create Dictionary
    ...  demande_type=${args_demande_type_01.libelle}
    #
    Ajouter la demande sur existant sans création de dossier  ${di_1}  ${args_demande}
    Valid Message Should Contain  Notification (112) du référentiel ERP OK.


Message 113

    # [113]
    #
    Depuis la page d'accueil  instrpoly  instrpoly
    # Données de la pièce
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=15/09/2015
    ...  document_numerise_type=autres pièces composant le dossier (A0)
    #
    Ajouter une pièce depuis le dossier d'instruction  ${di_1}  ${document_numerise_values}
    Valid Message Should Contain In Subform  Notification (113) du référentiel ERP OK.


Message 114

    # [114]
    #

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Saville
    ...  particulier_prenom=Lazure
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    Depuis le formulaire de modification du dossier d'instruction  ${di}
    Set Checkbox  enjeu_urba  true
    Set Checkbox  enjeu_erp  true
    Set Checkbox  erp  true
    Set Checkbox  a_qualifier  false
    Click On Submit Button
    Valid Message Should Contain  Notification (114) du référentiel ERP OK.

    Depuis le formulaire de modification du dossier d'instruction  ${di_2}
    Set Checkbox  enjeu_urba  true
    Click On Submit Button
    Depuis le formulaire de modification du dossier d'instruction  ${di_2}
    Set Checkbox  enjeu_erp  true
    Set Checkbox  erp  true
    Set Checkbox  a_qualifier  false
    Click On Submit Button
    Valid Message Should Contain  Notification (114) du référentiel ERP OK.


    Depuis le formulaire de modification du dossier d'instruction  ${di_2}
    Set Checkbox  enjeu_urba  false
    Click On Submit Button
    Valid Message Should Contain  Notification (114) du référentiel ERP OK.

Message 109

    # [109]
    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_demande} =  Create Dictionary
    ...  demande_type=${args_demande_type_02.libelle}
    #
    Ajouter la demande sur existant sans création de dossier  ${di_2}  ${args_demande}
    Valid Message Should Contain  Notification (109) du référentiel ERP OK.


Message 110

    # [110]
    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_demande} =  Create Dictionary
    ...  demande_type=${args_demande_type_03.libelle}
    #
    Ajouter la demande sur existant sans création de dossier  ${di_2}  ${args_demande}
    Valid Message Should Contain  Notification (110) du référentiel ERP OK.


Messages 102 et 103

    [Documentation]  Dans le cas des PC/ERP (plan) et dans l'optique de collaboration entre ADS et ERP, l'instructeur ADS lors de la qualification du dossier peut indiquer avant la consultation officielle des services si le dossier concerne un RP et ainsi pré-notifier les services ERP qui peuvent commencer la qualification du dossier plus tôt.

    # [102] ADS_ERP__PC__PRE_DEMANDE_DE_COMPLETUDE_ERP
    # [103] ADS_ERP__PC__PRE_DEMANDE_DE_QUALIFICATION_ERP

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
    ${di_3} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_3_id} =  Sans espace  ${di_3}
    Set Suite Variable  ${di_3}
    Set Suite Variable  ${di_3_id}
    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis le formulaire de modification du dossier d'instruction  ${di_3}
    #
    Select Checkbox  css=#erp
    #
    Unselect Checkbox  css=#a_qualifier
    #
    Click On Submit Button
    Valid Message Should Contain  Notification (102) du référentiel ERP OK.
    Valid Message Should Contain  Notification (103) du référentiel ERP OK.

    #
    #
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=HENRI
    ...  particulier_prenom=Philippe
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di_4} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_4_id} =  Sans espace  ${di_4}
    Set Suite Variable  ${di_4}
    Set Suite Variable  ${di_4_id}
    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis le formulaire de modification du dossier d'instruction  ${di_4}
    #
    Select Checkbox  css=#erp
    #
    Unselect Checkbox  css=#a_qualifier
    #
    Click On Submit Button
    Valid Message Should Contain  Notification (102) du référentiel ERP OK.
    Valid Message Should Contain  Notification (103) du référentiel ERP OK.


Messages 204 et 205 et 206

    [Documentation]  Dans le cas des PC/ERP (plan) et dans l'optique de collaboration entre ADS et ERP, les services ERP dès lors qu'ils ont réalisé la qualification sur un dossier "connecté avec le référentiel ADS", des notifications en informent l'instructeur ADS du dossier.

    # [204] ERP_ADS__PC__INFORMATION_COMPLETUDE_ERP_ACCESSIBILITE
    ${json} =  Set Variable  {"type": "ERP_ADS__PC__INFORMATION_COMPLETUDE_ERP_ACCESSIBILITE", "date": "16/06/2014 14:12", "emetteur": "John Doe", "dossier_instruction": "${di_3_id}", "contenu": { "Complétude ERP ACC": "non", "Motivation Complétude ERP ACC": "Lorem ipsum dolor sit amet..." } }
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  200  Insertion du message 'ERP_ADS__PC__INFORMATION_COMPLETUDE_ERP_ACCESSIBILITE' OK.

    # [205] ERP_ADS__PC__INFORMATION_COMPLETUDE_ERP_SECURITE
    ${json} =  Set Variable  {"type": "ERP_ADS__PC__INFORMATION_COMPLETUDE_ERP_SECURITE", "date": "16/06/2014 14:14", "emetteur": "Jane Doe", "dossier_instruction": "${di_3_id}", "contenu": { "Complétude ERP SECU": "non", "Motivation Complétude ERP SECU": "Lorem ipsum dolor sit amet..." } }
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  200  Insertion du message 'ERP_ADS__PC__INFORMATION_COMPLETUDE_ERP_SECURITE' OK.

    # [206] ERP_ADS__PC__INFORMATION_QUALIFICATION_ERP
    ${json} =  Set Variable  {"type": "ERP_ADS__PC__INFORMATION_QUALIFICATION_ERP", "date": "16/06/2014 14:16", "emetteur": "Jack Doe", "dossier_instruction": "${di_3_id}", "contenu": { "Confirmation ERP": "non", "Type de dossier ERP": "-", "Catégorie de dossier ERP": "-"} }
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  200  Insertion du message 'ERP_ADS__PC__INFORMATION_QUALIFICATION_ERP' OK.


Message 207

    [Documentation]

    # [207] ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP
    ${json} =  Set Variable  {"type": "ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP", "date": "16/06/2014 14:16", "emetteur": "Jack Doe", "dossier_instruction": "${di_4_id}", "contenu": { "Dossier à enjeux ERP": "oui"} }
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  200  Insertion du message 'ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP' OK.


Message 104

    # [104]
    #
    Depuis la page d'accueil  instr  instr
    #
    Ajouter une consultation depuis un dossier  ${di_3}  ${service_1.abrege} - ${service_1.libelle}
    Valid Message Should Contain In Subform  Notification (104) du référentiel ERP OK.
    #
    Ajouter une consultation depuis un dossier  ${di_3}  ${service_2.abrege} - ${service_2.libelle}
    Valid Message Should Contain In Subform  Notification (104) du référentiel ERP OK.


Message 105

    # [105]
    #
    Depuis la page d'accueil  instr  instr
    #
    Ajouter une instruction au DI  ${di_3}  accepter un dossier sans réserve
    Valid Message Should Contain In Subform  Notification (105) du référentiel ERP OK.


Message 106

    # [106]
    #
    Depuis la page d'accueil  instr  instr
    #
    Ajouter une consultation depuis un dossier  ${di_4}  ${service_3.abrege} - ${service_3.libelle}
    Valid Message Should Contain In Subform  Notification (106) du référentiel ERP OK.


Message 107

    # [107]
    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_demande} =  Create Dictionary
    ...  demande_type=${args_demande_type_04.libelle}
    #
    Ajouter la demande sur existant sans création de dossier  ${di_3}  ${args_demande}
    Valid Message Should Contain  Notification (107) du référentiel ERP OK.


Message 213

    # [213]
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=LOUIS
    ...  particulier_prenom=Daniel
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    #
    ${di} =  Ajouter La Nouvelle Demande Depuis Le Tableau De Bord  ${args_demande}  ${args_petitionnaire}
    ${di_id} =  Sans espace  ${di}
    Set Suite Variable  ${di}
    Set Suite Variable  ${di_id}
    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis le formulaire de modification du dossier d'instruction  ${di}
    #
    Select Checkbox  css=#erp
    #
    Unselect Checkbox  css=#a_qualifier
    #
    Click On Submit Button
    Valid Message Should Contain  Notification (102) du référentiel ERP OK.
    Valid Message Should Contain  Notification (103) du référentiel ERP OK.
    #
    Ajouter une consultation depuis un dossier  ${di}  ${service_3.abrege} - ${service_3.libelle}
    Valid Message Should Contain In Subform  Notification (106) du référentiel ERP OK.
    Click On Back Button In Subform
    Click Link  ${service_3.abrege} - ${service_3.libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=div.form-content>#service
    ${consultation_id} =  Get Value  css=div.form-content>#consultation
    ${json} =  Set Variable  {"type": "ERP_ADS__PC__AR_CONSULTATION_OFFICIELLE", "date": "16/06/2014 14:16", "emetteur": "cadre-si", "dossier_instruction": "${di_id}", "contenu": {"consultation": "${consultation_id}"}}
    Vérifier le code retour du web service et vérifier que son message est  Post  messages  ${json}  200  Insertion du message 'ERP_ADS__PC__AR_CONSULTATION_OFFICIELLE' OK.

    Depuis l'onglet des messages du dossier d'instruction  ${di}
    Click Element Until No More Element  xpath=//a[text()[contains(.,"ERP_ADS__PC__AR_CONSULTATION_OFFICIELLE")]]
    La page ne doit pas contenir d'erreur
    Click On SubForm Portlet Action  dossier_message  accuse_reception  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Accusé de réception automatique
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${service_3.libelle}
    Close PDF


Fonctionnement du paramètre erp__dossier__type_di__pc sur la case à cocher ERP et les serivces consultés

    [Documentation]  Test du fonctionnement de la case ERP avec les paramètres
    ...  activés, et sur les différents types de dossiers (AT, PC pour les
    ...  différents types et CU).

    # Vérifie le comportement de la case à cocher ERP sur un PC initial lorsque
    # l'option de l'interfaçage avec le référentiel ERP est désactivée
    # La case à cocher ERP doit être modifiable mais il n'y a pas d'interfaçage
    # avec le référentiel ERP
    Depuis la page d'accueil  admin  admin
    Modifier le paramètre   option_referentiel_erp  false  agglo
    #
    Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=De-Saint-Blëk
    ...  particulier_prenom=Gonzague
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ${di1} =  Ajouter La Nouvelle Demande Depuis Le Tableau De Bord  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    Depuis le formulaire de modification du dossier d'instruction  ${di1}
    Select Checkbox  css=#erp
    Unselect Checkbox  css=#a_qualifier
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Element Should Not Contain  css=div.message.ui-state-valid p span.text  référentiel ERP

    # Vérifie le comportement de la case à cocher ERP sur un AT initial lorsque
    # l'option de l'interfaçage avec le référentiel ERP est activée
    # La case à cocher ERP doit être modifiable afin de permettre l'interfaçage
    # avec le référentiel ERP
    Depuis la page d'accueil  admin  admin
    Modifier le paramètre   option_referentiel_erp  true  agglo
    #
    Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Blörk
    ...  particulier_prenom=Gros
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    ...  demande_type=Dépôt Initial
    ${di2} =  Ajouter La Nouvelle Demande Depuis Le Tableau De Bord  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instr  instr
    Depuis le formulaire de modification du dossier d'instruction  ${di2}
    Select Checkbox  css=#erp
    Unselect Checkbox  css=#a_qualifier
    Click On Submit Button
    Valid Message Should Contain  Notification (101) du référentiel ERP OK.

    # Vérifie le comportement de la case à cocher ERP sur un PC initial lorsque
    # l'option de l'interfaçage avec le référentiel ERP est activée et que le
    # type du dossier d'instruction est dans le paramètre erp__dossier__type_di__pc
    # La case à cocher ERP doit être modifiable afin de permettre l'interfaçage
    # avec le référentiel ERP
    Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Blëk
    ...  particulier_prenom=Gentil
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ${di3} =  Ajouter La Nouvelle Demande Depuis Le Tableau De Bord  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    Depuis le formulaire de modification du dossier d'instruction  ${di3}
    Select Checkbox  css=#erp
    Unselect Checkbox  css=#a_qualifier
    Click On Submit Button
    Valid Message Should Contain  Notification (102) du référentiel ERP OK.
    Valid Message Should Contain  Notification (103) du référentiel ERP OK.
    # Vérifie que lors de l'ajout d'une consultation les services à consulter
    # représentant les services ERP sont disponibles dans la liste à choix
    Depuis l'onglet consultation du dossier  ${di3}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#action-soustab-consultation-corner-ajouter
    ${liste_services_ERP} =  Create List
    ...  Service Prévention et Gestion des Risques ERP TEST410
    ...  Direction des Handicapés TEST410
    ...  Direction de la Circulation TEST410
    Wait Until Element Is Visible  css=#sformulaire select#service
    Select List Should Not Contain List  css=#sformulaire select#service  ${liste_services_ERP}

    # Vérifie le comportement de la case à cocher ERP sur un PC DOC lorsque
    # l'option de l'interfaçage avec le référentiel ERP est activée et que le
    # type du dossier d'instruction n'est pas présent dans le paramètre
    # erp__dossier__type_di__pc
    # La case à cocher ERP ne doit pas être modifiable afin de ne pas permettre
    # l'interfaçage avec le référentiel ERP
    Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Derrick
    ...  particulier_prenom=Stefan
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ${di4} =  Ajouter La Nouvelle Demande Depuis Le Tableau De Bord  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    Depuis le formulaire de modification du dossier d'instruction  ${di4}
    Select Checkbox  css=#erp
    Unselect Checkbox  css=#a_qualifier
    Click On Submit Button
    Valid Message Should Contain  Notification (102) du référentiel ERP OK.
    Valid Message Should Contain  Notification (103) du référentiel ERP OK.
    Ajouter une instruction au DI  ${di4}  accepter un dossier sans réserve
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande d'ouverture de chantier
    ${di5} =  Ajouter la demande sur existant depuis le menu  ${di4}  ${args_demande}
    Depuis le formulaire de modification du dossier d'instruction  ${di5}
    Form Static Value Should Be  css=#erp.field_value  Non
    # Vérifie que lors de l'ajout d'une consultation les services à consulter
    # représentant les services ERP ne sont pas disponibles dans la liste à choix
    Depuis l'onglet consultation du dossier  ${di5}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#action-soustab-consultation-corner-ajouter
    Wait Until Element Is Visible  css=#sformulaire select#service
    Select List Should Not Contain List  css=#sformulaire select#service  ${liste_services_ERP}

    # Vérifie le comportement de la case à cocher ERP sur un CU initial lorsque
    # l'option de l'interfaçage avec le référentiel ERP est activée
    # Le type CU n'étant ni PC, ni AT, le dossier n'est pas interfaçable
    # La case à cocher ERP ne doit pas être modifiable afin de ne pas permettre
    # l'interfaçage avec le référentiel ERP
    Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Callahan
    ...  particulier_prenom=Harry
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ${di6} =  Ajouter La Nouvelle Demande Depuis Le Tableau De Bord  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis le formulaire de modification du dossier d'instruction  ${di6}
    Form Static Value Should Be  css=#erp.field_value  Non

    # On vérifie que la case erp est coché lorsque le type de di est dans la liste erp__dossier__type_di__pc
    Depuis la page d'accueil  admin  admin
    &{param_values_1} =  Create Dictionary
    ...  libelle=erp__dossier__type_di__pc
    ...  valeur=1;6;10
    ...  om_collectivite=agglo
    Ajouter Ou Modifier le paramètre depuis le menu  ${param_values_1}

    Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Honoré
    ...  particulier_prenom=Rodrigue
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ${di4} =  Ajouter La Nouvelle Demande Depuis Le Tableau De Bord  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    Depuis le formulaire de modification du dossier d'instruction  ${di4}
    Select Checkbox  css=#erp
    Unselect Checkbox  css=#a_qualifier
    Click On Submit Button

    Ajouter une instruction au DI  ${di4}  accepter un dossier sans réserve
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande d'ouverture de chantier
    ${di5} =  Ajouter la demande sur existant depuis le menu  ${di4}  ${args_demande}
    Depuis le contexte du dossier d'instruction  ${di5}
    Form Static Value Should Be  css=#erp.field_value  Oui

Rétablissement des paramètres
    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification_piece_numerisee
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}