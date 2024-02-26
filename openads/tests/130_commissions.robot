*** Settings ***
Documentation  Gestion des commissions.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Constitution du jeu de données

    ${list_collectivite_type_commission} =  Create List
    ...  agglo
    &{args_type_de_commission_A} =  Create Dictionary
    ...  code=TA
    ...  libelle=Test type de commission A
    ...  listes_de_diffusion=support@atreal.fr
    ...  participants=Atreal
    ...  corps_du_courriel=Test du type de commission A
    ...  om_collectivite=CA
    &{args_type_de_commission_A2} =  Create Dictionary
    ...  code=TA2
    ...  libelle=Test type de commission A2
    ...  listes_de_diffusion=support@atreal.fr
    ...  participants=Atreal
    ...  corps_du_courriel=Test du type de commission A2
    &{args_type_de_commission_B} =  Create Dictionary
    ...  code=TB
    ...  libelle=Test type de commission B
    ...  listes_de_diffusion=support@atreal.fr
    ...  participants=Atreal
    ...  corps_du_courriel=Test du type de commission B
    ...  om_collectivite=CB
    &{args_type_de_commission_B2} =  Create Dictionary
    ...  code=TB2
    ...  libelle=Test type de commission B2
    ...  listes_de_diffusion=support@atreal.fr
    ...  participants=Atreal
    ...  corps_du_courriel=Test du type de commission B2

    Set Suite Variable  ${list_collectivite_type_commission}
    Set Suite Variable  ${args_type_de_commission_A}
    Set Suite Variable  ${args_type_de_commission_A2}
    Set Suite Variable  ${args_type_de_commission_B2}
    Set Suite Variable  ${args_type_de_commission_B}

    &{args_petitionnaire_1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Archi&Co
    ...  personne_morale_raison_sociale=SA
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=DURAND
    ...  om_collectivite=MARSEILLE
    ...  personne_morale_prenom=Jacques
    &{args_petitionnaire_2} =  Create Dictionary
    ...  particulier_nom=BERGER
    ...  om_collectivite=MARSEILLE
    ...  particulier_prenom=André
    &{args_petitionnaire_3} =  Create Dictionary
    ...  particulier_nom=GRIGNON
    ...  particulier_prenom=Juliette
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_1}
    ${di_1_id} =  Sans espace  ${di_1}
    Set Suite Variable  ${di_1}
    Set Suite Variable  ${di_1_id}
    #
    ${di_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_2}
    ${di_2_id} =  Sans espace  ${di_2}
    Set Suite Variable  ${di_2}
    Set Suite Variable  ${di_2_id}
    #
    ${di_3} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_2}
    ${di_3_id} =  Sans espace  ${di_3}
    Set Suite Variable  ${di_3}
    Set Suite Variable  ${di_3_id}


    &{args_affectation_A} =  Create Dictionary
    ...  instructeur=Instructeur A (CA)
    ...  om_collectivite=CA
    &{args_affectation_B} =  Create Dictionary
    ...  instructeur=Instructeur B (CB)
    ...  om_collectivite=CB

    Depuis la page d'accueil  admin  admin
    Ajouter la collectivité depuis le menu  CA  mono
    Ajouter la collectivité depuis le menu  CB  mono
    Ajouter l'état depuis le menu  commission_ordre_jour   Commission - Ordre du jour  Commission - Ordre du jour  Commission de test  Récapitulatif commission  true  CA
    Ajouter la direction depuis le menu  CA  Direction CA  null  Chef A  null  null  CA
    Ajouter la direction depuis le menu  CB  Direction CB  null  Chef B  null  null  CB
    Ajouter la division depuis le menu  CA  subdivision CA  null  Chef A  null  null  Direction CA
    Ajouter la division depuis le menu  CB  subdivision CB  null  Chef B  null  null  Direction CB
    Ajouter l'utilisateur  Utilisateur A  support@atreal.fr  UA  UA  ADMINISTRATEUR GENERAL  CA
    Ajouter l'utilisateur  Utilisateur B  support@atreal.fr  UB  UB  ADMINISTRATEUR GENERAL  CB
    Ajouter l'utilisateur  Suivi A  support@atreal.fr  SA  SA  CELLULE SUIVI  CA
    Ajouter l'utilisateur  Suivi B  support@atreal.fr  SB  SB  CELLULE SUIVI  CB
    Ajouter l'utilisateur  InstructeurPolyCom A  support@atreal.fr  IPCA  IPCA  INSTRUCTEUR POLYVALENT COMMUNE  CA
    Ajouter l'utilisateur  InstructeurPolyCom B  support@atreal.fr  IPCB  IPCB  INSTRUCTEUR POLYVALENT COMMUNE  CB
    Ajouter l'utilisateur  Instructeur A  support@atreal.fr  IA  IA  INSTRUCTEUR  CA
    Ajouter l'utilisateur  Instructeur B  support@atreal.fr  IB  IB  INSTRUCTEUR  CB
    Ajouter l'instructeur depuis le menu  InstructeurPolyCom A  subdivision CA  instructeur  InstructeurPolyCom A
    Ajouter l'instructeur depuis le menu  InstructeurPolyCom B  subdivision CB  instructeur  InstructeurPolyCom B
    Ajouter l'instructeur depuis le menu  Instructeur A  subdivision CA  instructeur  Instructeur A
    Ajouter l'instructeur depuis le menu  Instructeur B  subdivision CB  instructeur  Instructeur B
    Ajouter l'affectation depuis le menu  ${args_affectation_B}
    Ajouter l'affectation depuis le menu  ${args_affectation_A}

    &{args_petitionnaire_A} =  Create Dictionary
    ...  particulier_nom=DROUIN
    ...  particulier_prenom=Mireille
    ...  om_collectivite=CA
    &{args_demande_A} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=CA

    &{args_petitionnaire_B} =  Create Dictionary
    ...  particulier_nom=MASSÉ
    ...  particulier_prenom=Caresse
    ...  om_collectivite=CB
    &{args_demande_B} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=CB

    &{args_petitionnaire_B2} =  Create Dictionary
    ...  particulier_nom=TURCOTTE
    ...  particulier_prenom=Nicole
    ...  om_collectivite=CB
    &{args_demande_B2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=CB

    ${DIA} =  Ajouter la demande par WS  ${args_demande_A}  ${args_petitionnaire_A}
    ${DIB} =  Ajouter la demande par WS  ${args_demande_B}  ${args_petitionnaire_B}
    ${DIB2} =  Ajouter la demande par WS  ${args_demande_B2}  ${args_petitionnaire_B2}

    ${list_collectivite_type_commission_A} =  Create List
    ...  ${args_type_de_commission_A.libelle}
    ${list_collectivite_type_commission_B} =  Create List
    ...  ${args_type_de_commission_B.libelle}


    Set Suite Variable  ${DIA}
    Set Suite Variable  ${DIB}
    Set Suite Variable  ${DIB2}
    Set Suite Variable  ${list_collectivite_type_commission_A}
    Set Suite Variable  ${list_collectivite_type_commission_B}


Types de commission
    [Documentation]  L'objet de ce 'Test Case' est de vérifier la création
    ...  de type de commission: il doit vérifier:
    ...  - On ne peut pas ajouter des types multi
    ...  - L'impossibilité des faire des types de commission cross commune
    ...  - Et Bon fonctionnement de base
    ...  Dépend de tous les tests précédents.

    Depuis la page d'accueil  admin  admin
    Depuis le listing  commission_type
    Click On Add Button
    Select List Should Not Contain List  om_collectivite  ${list_collectivite_type_commission}
    Saisir type de commission  ${args_type_de_commission_A}
    Click On Submit Button
    Valid Message Should Be  Vos modifications ont bien été enregistrées.
    Ajouter type de commission  ${args_type_de_commission_B}

    Depuis la page d'accueil  UA  UA
    Depuis le listing  commission_type
    Element Should Contain  tab-commission_type  ${args_type_de_commission_A.libelle}
    Element Should Not Contain  tab-commission_type  ${args_type_de_commission_B.libelle}
    Ajouter type de commission  ${args_type_de_commission_A2}

    Depuis la page d'accueil  UB  UB
    Depuis le listing  commission_type
    Element Should Contain  tab-commission_type  ${args_type_de_commission_B.libelle}
    Element Should Not Contain  tab-commission_type  ${args_type_de_commission_A.libelle}
    Ajouter type de commission  ${args_type_de_commission_B2}


    Depuis la page d'accueil  admin  admin
    Depuis le listing  commission_type
    Element Should Contain  tab-commission_type  ${args_type_de_commission_A.libelle}
    Element Should Contain  tab-commission_type  ${args_type_de_commission_A2.libelle}
    Element Should Contain  tab-commission_type  ${args_type_de_commission_B.libelle}
    Element Should Contain  tab-commission_type  ${args_type_de_commission_B2.libelle}

    # On se connecte en tant que "admin"
    Depuis la page d'accueil  admin  admin

    # On clique sur le menu de paramétrage
    Go To Submenu In Menu  parametrage  commission-type
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Paramétrage > Gestion Des Commissions > Type De Commission
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Type De Commission
    # On vérifie que le listing des types de commission est présent
    Element Should Be Visible  css=#tab-commission_type table.tab-tab
    # On vérifie que l'action ajouter est disponible
    Element Should Be Visible  css=#action-tab-commission_type-corner-ajouter

    # On clique sur l'action ajouter
    Click On Add Button
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  parametrage  commission-type
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Paramétrage > Gestion Des Commissions > Type De Commission
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Type De Commission

    # On ajoute les informations du type de commission
    &{type_de_commission_01} =  Create Dictionary
    ...  code=TCOM
    ...  libelle=Test TCOM (avec caractère accentué)
    ...  lieu_salle=2a
    ...  listes_de_diffusion=type_de_commission_01-AK9IT4@example.com
    ...  participants=Atreal
    ...  corps_du_courriel=Test du type de commission (avec caractère accentué)
    ...  om_collectivite=MARSEILLE
    Saisir type de commission  ${type_de_commission_01}
    Set Suite Variable  ${type_de_commission_01}

    # On ajoute le type de commission
    Click On Submit Button
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  parametrage  commission-type
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Paramétrage > Gestion Des Commissions > Type De Commission
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Type De Commission
    # Vérification du message de validation
    Valid Message Should Be  Vos modifications ont bien été enregistrées.

    # On retourne sur le tableau listant les types de commission
    Click On Back Button
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  parametrage  commission-type
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Paramétrage > Gestion Des Commissions > Type De Commission
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Type De Commission
    # On vérifie que le listing des types de commission est présent
    Element Should Be Visible  css=#tab-commission_type table.tab-tab

    # On vérifie que le type de commission nouvellement créé avec les informations
    # ci-dessus existe bien
    Use Simple Search  libellé  ${type_de_commission_01.libelle}
    Element Should Contain  css=#tab-commission_type table.tab-tab tbody  ${type_de_commission_01.libelle}


Demande de passage en commission
    [Documentation]  Le but de ce tests case est vérifier que la création de
    ...  demande de commission soit bien bridée pour les types de commission.
    ...  On vérifira donc lors de l'ajout ou de la modification que le menu
    ...  déroulant ne propose que les types de commissions rattachés à la collectivité
    ...  de l'instructeur et de vérifier leurs présence dans le tableau des demandes.
    ...  Dépend de tous les tests précédents.

    Depuis la page d'accueil  IA  IA
    Depuis l'onglet commission(s) du dossier d'instruction  ${DIA}
    Click On Add Button
    Select List Should Contain List  commission_type  ${list_collectivite_type_commission_A}
    Select List Should Not Contain List  commission_type  ${list_collectivite_type_commission_B}
    Select From List By Label  commission_type  ${args_type_de_commission_A.libelle}
    Click On Submit Button In Subform

    Depuis la page d'accueil  IB  IB
    Depuis l'onglet commission(s) du dossier d'instruction  ${DIB}
    Click On Add Button
    Select List Should Contain List  commission_type  ${list_collectivite_type_commission_B}
    Select List Should Not Contain List  commission_type  ${list_collectivite_type_commission_A}
    Select From List By Label  commission_type  ${args_type_de_commission_B.libelle}
    Click On Submit Button In Subform

    Click On Back Button In Subform
    Click Element Until No More Element  xpath=//a[text()[contains(.,"${args_type_de_commission_B.libelle}")]]
    Click On SubForm Portlet Action  dossier_commission  modifier
    Select List Should Contain List  commission_type  ${list_collectivite_type_commission_B}
    Select List Should Not Contain List  commission_type  ${list_collectivite_type_commission_A}

    Depuis la page d'accueil  IPCA  IPCA
    Go To Submenu In Menu  suivi  commissions-demande-passage
    Element Should Contain  css=.tab-tab  ${DIA}
    Element Should Not Contain  css=.tab-tab  ${DIB}
    Depuis la page d'accueil  IPCB  IPCB
    Go To Submenu In Menu  suivi  commissions-demande-passage
    Element Should Contain  css=.tab-tab  ${DIB}
    Element Should Not Contain  css=.tab-tab  ${DIA}

    # On se connecte en tant que "instr"
    Depuis la page d'accueil  instr  instr
    #
    Depuis l'onglet commission(s) du dossier d'instruction  ${di_1}
    # On vérifie que l'action ajouter est disponible
    Element Should Be Visible  css=#action-soustab-dossier_commission-corner-ajouter

    # On clique sur l'action ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#action-soustab-dossier_commission-corner-ajouter
    # On vérifie que la date du jour est pré-remplie dans le champs "date souhaitée"
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#sformulaire #date_souhaitee  ${DATE_FORMAT_DD/MM/YYYY}

    # On clique sur le bouton "Ajouter" du formulaire sans sélectionner de type de commission
    Click On Submit Button In Subform Until Message  SAISIE NON ENREGISTRÉE
    # On vérifie que le message d'erreur est présent
    Error Message Should Contain In Subform  Le champ type de commission est obligatoire
    Error Message Should Contain In Subform  SAISIE NON ENREGISTRÉE

    # On ajoute les informations de la demande de passage
    &{args_dossier_commission} =  Create Dictionary
    ...  commission_type=${type_de_commission_01.libelle}
    ...  motivation=MOTIVCOM
    Saisir la demande de passage en commission  ${args_dossier_commission}

    # On clique sur le bouton "Ajouter" du formulaire avec toutes les informations saisies
    Click On Submit Button In Subform
    # On vérifie que le message de validation est présent
    Valid Message Should Be In Subform  Vos modifications ont bien été enregistrées.

    # On clique sur le bouton retour
    Click On Back Button In Subform
    # On vérifie que nous avons bien la consultation affichée
    Element Should Contain  css=#sousform-dossier_commission  ${type_de_commission_01.libelle}


Gestion des commissions
    [Documentation]  L'objet de ce 'Test Case' est de vérifier les demandes
    ...  de passage devant une commission depuis le menu suivi
    ...  Dépend de tous les tests précédents.

    &{args_commission_A} =  Create Dictionary
    ...  libelle=COMA
    ...  lieu_adresse_ligne1=1A rue de la république
    ...  heure_commission=10:45
    ...  om_collectivite=CA
    ...  commission_type=${args_type_de_commission_A.libelle}

    &{args_commission_B} =  Create Dictionary
    ...  libelle=COMB
    ...  lieu_adresse_ligne1=1B rue de la république
    ...  heure_commission=11:15
    ...  om_collectivite=CB
    ...  commission_type=${args_type_de_commission_B.libelle}

    Depuis la page d'accueil  IPCA  IPCA
    Go To Submenu In Menu  suivi  commissions
    Click On Add Button
    Select List Should Contain List  commission_type  ${list_collectivite_type_commission_A}
    Select List Should Not Contain List  commission_type  ${list_collectivite_type_commission_B}
    Click On Back Button

    Depuis la page d'accueil  IPCB  IPCB
    Go To Submenu In Menu  suivi  commissions
    Click On Add Button
    Select List Should Contain List  commission_type  ${list_collectivite_type_commission_B}
    Select List Should Not Contain List  commission_type  ${list_collectivite_type_commission_A}
    Click On Back Button

    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  suivi  commissions
    Click On Add Button
    Select From List By Label  om_collectivite  CA
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select List Should Contain List  commission_type  ${list_collectivite_type_commission_A}
    Select List Should Not Contain List  commission_type  ${list_collectivite_type_commission_B}
    Select From List By Label  om_collectivite  CB
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select List Should Contain List  commission_type  ${list_collectivite_type_commission_B}
    Select List Should Not Contain List  commission_type  ${list_collectivite_type_commission_A}


    Ajouter un suivi de commission  ${args_commission_A}
    Click On Back Button
    Element Should Contain  css=#tab-commission  ${args_commission_A.libelle}

    Ajouter un suivi de commission  ${args_commission_B}
    Click On Back Button
    Element Should Contain  css=#tab-commission  ${args_commission_B.libelle}


    Depuis le listing  commission
    Click Link  ${args_commission_B.libelle}
    Wait Until Element Is Visible  commission_dossiers_planifier_retirer
    Click Element  commission_dossiers_planifier_retirer
    Wait Until Element Is Visible  css=.tab-tab
    Element Should Contain  css=.tab-tab  ${DIB}
    Element Should Not Contain  css=.tab-tab  ${DIA}
    Click On Back Button
    Click Link  ${args_commission_A.libelle}
    Wait Until Element Is Visible  commission_dossiers_planifier_retirer
    Click Element  commission_dossiers_planifier_retirer
    Wait Until Element Is Visible  css=.tab-tab
    Element Should Not Contain  css=.tab-tab  ${DIB}
    Element Should Contain  css=.tab-tab  ${DIA}


    ${DIB2_spaceless} =  Sans espace  ${DIB2}

    Depuis la page d'accueil  IPCA  IPCA
    Go To Submenu In Menu  suivi  commissions
    Click Link  ${args_commission_A.libelle}
    Wait Until Element Is Visible  commission_dossiers_planifier_numero
    Click Element  commission_dossiers_planifier_numero
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  dossier  ${DIB2_spaceless}
    Click Element  css=#sousform-add_and_plan_demand input.om-button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div.message span.text  Ce dossier n'existe pas.

    Click On Form Portlet Action  commission  edition_ordre_jour  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Commission de test
    Close PDF

    Depuis la page d'accueil  IPCB  IPCB
    Go To Submenu In Menu  suivi  commissions
    Click Link  ${args_commission_B.libelle}
    Click On Form Portlet Action  commission  edition_ordre_jour  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ORDRE DU JOUR
    Close PDF

    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  suivi  commissions
    Click Link  ${args_commission_A.libelle}
    Click On Form Portlet Action  commission  edition_ordre_jour  new_window
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Commission de test
    Close PDF


Cellule suivi - création commission
    [Documentation]  Dépend de tous les tests précédents.

    # On se connecte en tant que "suivi"
    Depuis la page d'accueil  suivi  suivi

    # On clique sur l'entrée de menu "Suivi -> Commissions -> Gestion"
    Go To Submenu In Menu  suivi  commissions
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Suivi > Commissions > Gestion
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Commission
    # On vérifie que le listing est présent
    Element Should Be Visible  css=#tab-commission table.tab-tab
    # On vérifie que l'action ajouter est disponiblez
    Element Should Be Visible  css=#action-tab-commission-corner-ajouter

    # On clique sur le bouton d'ajout de commission
    Click On Add Button
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  suivi  commissions
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Suivi > Commissions > Gestion
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Commission
    # On vérifie que la date du jour est pré-remplie dans le champs "date"
    Form Value Should Be  css=#date_commission  ${DATE_FORMAT_DD/MM/YYYY}

    # On clique sur le bouton "Ajouter" du formulaire sans sélectionner de type de commission
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  suivi  commissions
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Suivi > Commissions > Gestion
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Commission
    # On vérifie que le message d'erreur est présent
    Error Message Should Contain  Le champ type de commission est obligatoire
    Error Message Should Contain  SAISIE NON ENREGISTRÉE

    # On choisit un type de commission
    Select From List By Label  css=#commission_type  ${type_de_commission_01.libelle}
    # On vérifie que les informations du type de commision sélectionnées sont bien
    # dans les champs
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#libelle  ${type_de_commission_01.libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#lieu_salle  2a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#listes_de_diffusion  ${type_de_commission_01.listes_de_diffusion}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#participants  Atreal
    # Aucune adresse n'avait été saisie dans le champ concernant l'adresse
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#lieu_adresse_ligne1  ${EMPTY}

    # Saisie d'une adresse
    &{args_commission} =  Create Dictionary
    ...  lieu_adresse_ligne1=1 boulevard de la république
    ...  heure_commission=15:00
    Saisir la commission  ${args_commission}

    # On ajoute la commission
    Click On Submit Button
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  suivi  commissions
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Suivi > Commissions > Gestion
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Commission
    # On vérifie que le message de validation est présent
    Valid Message Should Be  Vos modifications ont bien été enregistrées.

    # On retourne sur le tableau listant les commissions
    Click On Back Button
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  suivi  commissions
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Suivi > Commissions > Gestion
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Commission

    # On vérifie que la commission nouvellement avec les informations ci-dessus
    # existe bien
    Element Should Contain  css=#tab-commission  1 boulevard de la république


Cellule suivi - préparation commission
    [Documentation]  Dépend de tous les tests précédents.

    # On se connecte en tant que "suivi"
    Depuis la page d'accueil  suivi  suivi

    ## Vérification de la fiche de visualisation d'une commission
    # On se positionne sur l'écran de gestion de la commission
    Depuis le contexte de la commission  TCOM${DATE_FORMAT_YYYYMMDD}
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  suivi  commissions
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Suivi > Commissions > Gestion
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Commission

    ## Aucun dossier n'est planifié à la commission
    On clique sur l'onglet  dossier_planifie  Les Dossiers Planifiés
    Element Should Contain  css=#sousform-dossier_commission .pagination-text  1 - 0 enregistrement(s) sur 0

    ## Planification d'une demande existante à la commission
    On clique sur l'onglet  commission_dossiers_planifier_retirer  Planifier/retirer Des Dossiers
    # On sélectionne la demande de passage
    Select Checkbox  css=tr#dossier_commission-${di_1_id} input[type='checkbox']
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=#ui-tabs-2 div.formControls input[type="submit"]
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Be Visible  css=#ui-tabs-2 div.message
    La page ne doit pas contenir d'erreur
    # On vérifie que le formulaire s'est bien validé
    Element Should Contain  css=#ui-tabs-2 .message .text  Mise à jour de la planification effectuée.

    ## Un dossier est planifié à la commission
    On clique sur l'onglet  dossier_planifie  Les Dossiers Planifiés
    Element Should Contain  css=#sousform-dossier_commission .pagination-text  1 - 1 enregistrement(s) sur 1

    ##
    On clique sur l'onglet  commission_dossiers_planifier_numero  Planifier Un Dossier Spécifique
    #
    Input Text  css=#dossier  ${di_2_id}
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=#ui-tabs-3 div.formControls input[type="submit"]
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Be Visible  css=#ui-tabs-3 div.message
    La page ne doit pas contenir d'erreur
    # On vérifie que le formulaire s'est bien validé
    Element Should Contain  css=#ui-tabs-3 .message .text  Dossier ajouté avec succès.
    ##
    On clique sur l'onglet  commission_dossiers_planifier_numero  Planifier Un Dossier Spécifique
    #
    Input Text  css=#dossier  ${di_3_id}
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=#ui-tabs-3 div.formControls input[type="submit"]
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Be Visible  css=#ui-tabs-3 div.message
    La page ne doit pas contenir d'erreur
    # On vérifie que le formulaire s'est bien validé
    Element Should Contain  css=#ui-tabs-3 .message .text  Dossier ajouté avec succès.

    ## Deux dossiers sont planifiés à la commission
    On clique sur l'onglet  dossier_planifie  Les Dossiers Planifiés
    Element Should Contain  css=#sousform-dossier_commission .pagination-text  1 - 3 enregistrement(s) sur 3

    ##
    On clique sur l'onglet  commission_dossiers_planifier_numero  Planifier Un Dossier Spécifique
    #
    Input Text  css=#dossier  ${di_2_id}
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=#ui-tabs-3 div.formControls input[type="submit"]
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Be Visible  css=#ui-tabs-3 div.message
    La page ne doit pas contenir d'erreur
    # On vérifie que le formulaire s'est bien validé
    Element Should Contain  css=#ui-tabs-3 .message .text  Ce dossier est déjà à l'ordre du jour.

    ##
    Click On Form Portlet Action  commission  edition_ordre_jour  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie la localisation du terrain
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ORDRE DU JOUR
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  MOTIVCOM
    # On ferme le PDF
    Close PDF

    ## Planification d'une demande existante à la commission
    On clique sur l'onglet  commission_dossiers_planifier_retirer  Planifier/retirer Des Dossiers
    # On sélectionne la demande de passage
    Unselect Checkbox  css=tr#dossier_commission-${di_2_id} input[type='checkbox']
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#ui-tabs-2 div.formControls input[type="submit"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#ui-tabs-2 div.message
    La page ne doit pas contenir d'erreur
    # On vérifie que le formulaire s'est bien validé
    Element Should Contain  css=#ui-tabs-2 .message .text  Mise à jour de la planification effectuée.

    ## Un dossier est planifié à la commission
    On clique sur l'onglet  dossier_planifie  Les Dossiers Planifiés
    Element Should Contain  css=#sousform-dossier_commission .pagination-text  1 - 2 enregistrement(s) sur 2


    ## La motivation doit apparaître sur la proposition d'ordre du jour
    Click On Form Portlet Action  commission  edition_proposition_ordre_jour  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le contenu du pdf
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ORDRE DU JOUR
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  ${di_2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  MOTIVCOM
    # On ferme le PDF
    Close PDF

    ##
    Click On Form Portlet Action  commission  edition_ordre_jour  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le contenu du pdf
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ORDRE DU JOUR
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  ${di_2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  MOTIVCOM
    # On ferme le PDF
    Close PDF

    ##
    Click On Form Portlet Action  commission  diffuser_ordre_jour  message  La diffusion de l'ordre du jour s'est effectuée avec succès.
    Wait Until Page Contains Element  om_fichier_commission_ordre_jour
    ${uid_odj}    Get Mandatory Value    css=#om_fichier_commission_ordre_jour
    ##
    Click On Form Portlet Action  commission  edition_ordre_jour  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le contenu du pdf
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ORDRE DU JOUR
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  ${di_2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  MOTIVCOM
    # On ferme le PDF
    Close PDF

    # On vérifie que le contenu du mail est correct
    Verifier que le mail a bien été envoyé au destinataire  ${type_de_commission_01.listes_de_diffusion}
    Sélectionner le mail à afficher  ${type_de_commission_01.listes_de_diffusion}
    Vérifier le sujet du mail  ${type_de_commission_01.listes_de_diffusion}  ${type_de_commission_01.libelle}
    Accéder à maildump
    Vérifier le contenu du mail  ${type_de_commission_01.listes_de_diffusion}  ${type_de_commission_01.corps_du_courriel}

    # On se positionne sur l'écran de gestion de la commission
    Depuis la page d'accueil  suivi  suivi
    Depuis le contexte de la commission  TCOM${DATE_FORMAT_YYYYMMDD}

    # On vérifie que le l'ordre du jour est mis à jour apres redifusion
    Click On Form Portlet Action  commission  diffuser_ordre_jour  message  La diffusion de l'ordre du jour s'est effectuée avec succès.
    Wait Until Page Contains Element  om_fichier_commission_ordre_jour
    ${uid_odj_2}    Get Mandatory Value    css=#om_fichier_commission_ordre_jour
    Should Be Equal    ${uid_odj}    ${uid_odj_2}

    # On se connecte en tant que "cellule suivi"
    Depuis la page d'accueil  SA  SA
    Depuis le contexte de la commission  TA${DATE_FORMAT_YYYYMMDD}

    On clique sur l'onglet  commission_dossiers_planifier_numero  Planifier Un Dossier Spécifique
    #
    ${DIA_spaceless} =  Sans espace  ${DIA}
    Input Text  css=#dossier  ${DIA_spaceless}
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=#ui-tabs-3 div.formControls input[type="submit"]
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Be Visible  css=#ui-tabs-3 div.message
    La page ne doit pas contenir d'erreur
    # On vérifie que le formulaire s'est bien validé
    Element Should Contain  css=#ui-tabs-3 .message .text  Dossier ajouté avec succès.


Cellule suivi - saisie des avis
    [Documentation]  Dépend de tous les tests précédents.

    # On se connecte en tant que "cellule suivi"
    Depuis la page d'accueil  suivi  suivi

    ## Vérification de la fiche de visualisation d'une commission
    # On se positionne sur l'écran de gestion de la commission
    Depuis le contexte de la commission  TCOM${DATE_FORMAT_YYYYMMDD}
    # On vérifie que le menu est ouvert sur l'élément correct
    Submenu In Menu Should Be Selected  suivi  commissions
    # On vérifie que le titre de la page est cohérent
    Page Title Should Contain  Suivi > Commissions > Gestion
    # On vérifie que le titre de l'onglet est cohérent
    First Tab Title Should Be  Commission

    ##
    # Affichage en visualisation du dossier qui est passé en commission
    Click Link  ${di_1}
    # On saisie le retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  css=textarea#avis  AVISTESTFavorable
    # Validation du formulaire
    Click On Submit Button In Subform
    # La modification a bien été prise en compte
    Valid Message Should Be In Subform  Vos modifications ont bien été enregistrées.

    ##
    Click On Form Portlet Action  commission  edition_compte_rendu  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le contenu du pdf
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  COMPTE RENDU
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  ${di_2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  AVISTESTFavorable
    # On ferme le PDF
    Close PDF

    ##
    # Click On Form Portlet Action  commission  diffuser_compte_rendu  message  Le traitement est en cours. Merci de patienter.
    Click On Form Portlet Action  commission  diffuser_compte_rendu
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La diffusion du compte-rendu s'est effectuée avec succès.
    Wait Until Page Contains Element  om_fichier_commission_compte_rendu
    ${uid_cr}    Get Mandatory Value    css=#om_fichier_commission_compte_rendu
    ##
    Click On Form Portlet Action  commission  edition_compte_rendu  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le contenu du pdf
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  COMPTE RENDU
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  ${di_2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  AVISTESTFavorable
    # On ferme le PDF
    Close PDF

    # On vérifie que le compte rendu est mis à jour apres redifusion
    # Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Form Portlet Action  commission  diffuser_compte_rendu  message  Le traitement est en cours. Merci de patienter.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Form Portlet Action  commission  diffuser_compte_rendu
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  La diffusion du compte-rendu s'est effectuée avec succès.
    Wait Until Page Contains Element  om_fichier_commission_compte_rendu
    ${uid_cr_2}    Get Mandatory Value    css=#om_fichier_commission_compte_rendu
    Should Be Equal    ${uid_cr}    ${uid_cr_2}

    # On ajoute l'avis sur la derniere consultation
    Depuis la page d'accueil  SA  SA
    Depuis le contexte de la commission  TA${DATE_FORMAT_YYYYMMDD}
    Click Link  ${DIA}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  css=textarea#avis  AVISTRESFavorable
    Click On Submit Button In Subform
    Valid Message Should Be In Subform  Vos modifications ont bien été enregistrées.


Retours de commission
    [Documentation]  Dépend de tous les tests précédents.

    # Paramétrage du widget pour ne pas être influencer par le paramétrage des autres tests
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du widget  commission_retours
    Click On Form Portlet Action  om_widget  modifier
    Input Text  arguments  ${EMPTY}
    Click On Submit Button

    # On se connecte en tant que "instr"
    Depuis la page d'accueil  instr  instr

    # On verifie le message du widget
    Element Should Contain  css=.widget_commission_retours .box-icon  1

    # On clique sur le lien du widget (Voir +)
    Click Link  css=.widget_commission_retours .widget-footer a
    La page ne doit pas contenir d'erreur

    # On accède au listing des retours de commission
    Element Should Contain  css=#tab-commission_mes_retours  ${di_1}
    Element Should Contain  css=#tab-commission_mes_retours  AVISTESTFavorable
    # On clique sur le retour du dossier
    Click Link  ${di_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Be In SubForm  dossier_commission  marquer_comme_lu
    La page ne doit pas contenir d'erreur

    # On marque comme lu
    Click On SubForm Portlet Action  dossier_commission  marquer_comme_lu
    Valid Message Should Contain In Subform    Mise à jour effectuée avec succès
    Element Should Contain  css=#lu  Oui

    # Pas de suppression possible
    Portlet Action Should Not Be In SubForm  dossier_commission  supprimer

    # Filtre collectivité
    Depuis le listing  commission_tous_retours
    Page Should Not Contain  AVISTRESFavorable
    Depuis la page d'accueil  IA  IA
    Depuis le listing  commission_tous_retours
    Element Should Contain  css=#tab-commission_tous_retours  AVISTRESFavorable
    Click Element Until No More Element  xpath=//a[text()[contains(.,"${DIA}")]]
    ${DIA_spaceless}=  Sans espace  ${DIA}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_commission .subtitle .libelle  ${DIA_spaceless}
    Click On SubForm Portlet Action  dossier_commission  marquer_comme_lu
    Valid Message Should Contain In Subform    Mise à jour effectuée avec succès
    # Retour sur le tableau de bord
    Depuis la page d'accueil  instr  instr
    # On vérifie le tableau de bord
    Element Should Contain
    ...  css=.widget_commission_retours  Aucun retour de commission non lu.


TNR Vérifie que les fichiers sont supprimés à la suppression de la commission
    [Documentation]  Vérifie dans le filestorage si les fichiers des éditions de
    ...  la commisson sont correctement supprimés lors de la suppression de la
    ...  commission.

    Depuis la page d'accueil  admin  admin
    #
    Depuis le contexte de la commission  TCOM${DATE_FORMAT_YYYYMMDD}
    
    # On diffuse l'ordre du jour et le compte rendu
    # Click On Form Portlet Action    commission    diffuser_ordre_jour  message  Le traitement est en cours. Merci de patienter.
    Click On Form Portlet Action    commission    diffuser_ordre_jour  message  La diffusion de l'ordre du jour s'est effectuée avec succès.
    Sleep  1
    # Click On Form Portlet Action    commission    diffuser_compte_rendu  message  Le traitement est en cours. Merci de patienter.
    Click On Form Portlet Action    commission    diffuser_compte_rendu  message  La diffusion du compte-rendu s'est effectuée avec succès.

    # Récupération de l'uid de l'ordre du jour
    Depuis le contexte de la commission  TCOM${DATE_FORMAT_YYYYMMDD}
    ${oj_uid} =  Get Mandatory Value  om_fichier_commission_ordre_jour
    ${oj_path_1} =  Get Substring  ${oj_uid}  0  2
    ${oj_path_2} =  Get Substring  ${oj_uid}  0  4
    # Vérification dans le filestorage des fichier de l'OJ
    File Should Exist  ..${/}var${/}filestorage${/}${oj_path_1}${/}${oj_path_2}${/}${oj_uid}
    File Should Exist  ..${/}var${/}filestorage${/}${oj_path_1}${/}${oj_path_2}${/}${oj_uid}.info
    # Récupération de l'uid du compte rendu
    ${cr_uid} =  Get Mandatory Value  om_fichier_commission_compte_rendu
    ${cr_path_1} =  Get Substring  ${cr_uid}  0  2
    ${cr_path_2} =  Get Substring  ${cr_uid}  0  4
    # Vérification dans le filestorage des fichiers du CR
    File Should Exist  ..${/}var${/}filestorage${/}${cr_path_1}${/}${cr_path_2}${/}${cr_uid}
    File Should Exist  ..${/}var${/}filestorage${/}${cr_path_1}${/}${cr_path_2}${/}${cr_uid}.info
    #
    Supprimer la demande de commission depuis le contexte du dossier d'instruction  ${di_1}  ${type_de_commission_01.libelle}
    Supprimer la demande de commission depuis le contexte du dossier d'instruction  ${di_2}  ${type_de_commission_01.libelle}
    Supprimer la demande de commission depuis le contexte du dossier d'instruction  ${di_3}  ${type_de_commission_01.libelle}
    #
    Supprimer le suivi de la commission  TCOM${DATE_FORMAT_YYYYMMDD}
    # Vérification dans le filestorage des fichier de l'OJ
    File Should Not Exist  ..${/}var${/}filestorage${/}${oj_path_1}${/}${oj_path_2}${/}${oj_uid}
    File Should Not Exist  ..${/}var${/}filestorage${/}${oj_path_1}${/}${oj_path_2}${/}${oj_uid}.info
    # Vérification dans le filestorage des fichiers du CR
    File Should Not Exist  ..${/}var${/}filestorage${/}${cr_path_1}${/}${cr_path_2}${/}${cr_uid}
    File Should Not Exist  ..${/}var${/}filestorage${/}${cr_path_1}${/}${cr_path_2}${/}${cr_uid}.info
