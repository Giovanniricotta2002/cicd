*** Settings ***
Documentation  Test des événements d'instruction.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Variables ***
${json_instruction_finalisation}  {"module":"instruction"}


*** Test Cases ***
Création du jeu de données

    [Documentation]  Constitue le jeu de données.

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire&Co
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Martin
    ...  personne_morale_prenom=Nicolas
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_ok} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}


    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Odo
    ...  particulier_prenom=Laurent
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_bible_consultation} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Set Suite Variable  ${di_bible_consultation}

    Depuis la page d'accueil  admin  admin

    Ajouter une consultation depuis un dossier  ${di_bible_consultation}  59.01 - Direction de l'Eau et de l'Assainissement
    Ajouter une consultation depuis un dossier  ${di_bible_consultation}  59.01 - SERAM


    Depuis la page d'accueil  consu  consu
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  motivation=Test
    Rendre l'avis sur la consultation du dossier  ${di_bible_consultation}  ${args_avis_consultation}

    Depuis la page d'accueil  admin  admin

    # Liste des valeurs pour le tableau des surfaces des données techniques
    &{donnees_techniques_values} =  Create Dictionary
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
    ...  su_chge_shon1=10
    ...  su_chge_shon2=10
    ...  su_chge_shon3=10
    ...  su_chge_shon4=10
    ...  su_chge_shon5=10
    ...  su_chge_shon6=10
    ...  su_chge_shon7=10
    ...  su_chge_shon8=10
    ...  su_chge_shon9=10
    ...  su_demo_shon1=10
    ...  su_demo_shon2=10
    ...  su_demo_shon3=10
    ...  su_demo_shon4=10
    ...  su_demo_shon5=10
    ...  su_demo_shon6=10
    ...  su_demo_shon7=10
    ...  su_demo_shon8=10
    ...  su_demo_shon9=10
    ...  su_sup_shon1=10
    ...  su_sup_shon2=10
    ...  su_sup_shon3=10
    ...  su_sup_shon4=10
    ...  su_sup_shon5=10
    ...  su_sup_shon6=10
    ...  su_sup_shon7=10
    ...  su_sup_shon8=10
    ...  su_sup_shon9=10
    Modifier les données techniques pour le calcul des surfaces  ${di_ok}  ${donnees_techniques_values}

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Smith
    ...  particulier_prenom=John
    ...  om_collectivite=MARSEILLE

    ${di_ko} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    #
    Ajouter une instruction au DI  ${di_ko}  Consultation ERP ET IGH
    # Liste des valeurs pour le tableau des surfaces des données techniques
    &{donnees_techniques_values} =  Create Dictionary
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
    ...  su_chge_shon1=10
    ...  su_chge_shon2=10
    ...  su_chge_shon3=10
    ...  su_chge_shon4=10
    ...  su_chge_shon5=10
    ...  su_chge_shon6=10
    ...  su_chge_shon7=10
    ...  su_chge_shon8=10
    ...  su_chge_shon9=10
    ...  su_demo_shon1=10
    ...  su_demo_shon2=10
    ...  su_demo_shon3=10
    ...  su_demo_shon4=10
    ...  su_demo_shon5=10
    ...  su_demo_shon6=10
    ...  su_demo_shon7=10
    ...  su_demo_shon8=10
    ...  su_demo_shon9=10
    ...  su_sup_shon1=10
    ...  su_sup_shon2=10
    ...  su_sup_shon3=10
    ...  su_sup_shon4=10
    ...  su_sup_shon5=10
    ...  su_sup_shon6=10
    ...  su_sup_shon7=10
    ...  su_sup_shon8=10
    ...  su_sup_shon9=10
    Modifier les données techniques pour le calcul des surfaces  ${di_ko}  ${donnees_techniques_values}
    #
    Set Suite Variable  ${di_ok}
    Set Suite Variable  ${di_ko}


Recalcul données DI vers DA
    [Documentation]  Ce test case vérifie la copie des données techniques du DI vers le DA
    ...  après la clôture du DI. Il vérifie également qu'à la clôture du DI, l'état du DA
    ...  passe bien aussi en clôturé.

    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Vaillancour
    ...  particulier_prenom=Alphonse
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    &{donnees_techniques_values} =  Create Dictionary
    ...  su_cstr_shon1=120

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis la page d'accueil  instr  instr
    Modifier les données techniques pour le calcul des surfaces  ${di}  ${donnees_techniques_values}
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_autorisation  En cours
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_autorisation  Accordé

    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${di}
    Click Element  css=#sousform-dossier_autorisation .consult-16
    Wait Until Element Is Visible  donnees_techniques_da
    Click Element  css=#donnees_techniques_da
    Open Fieldset In Subform  donnees_techniques  construire
    Open Fieldset In Subform  donnees_techniques  destinations-et-surfaces-des-constructions
    Element Should Contain  css=#su_cstr_shon1  120

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Guédry
    ...  particulier_prenom=Paul
    ...  om_collectivite=MARSEILLE

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_autorisation  En cours
    Ajouter une instruction au DI  ${di}  refuser un dossier
    On clique sur l'onglet  lien_dossier_dossier  Dossiers Liés
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_autorisation  Refusé


Annulation d'un DA
    [Documentation]  On vérifie que l'ajout d'une demande sur dossier en cours "ANNUL"
    ...  passe bien l'état du DA du dossier ciblé en annulé.

    @{etats_autorises} =  Create List  delai de notification envoye
    &{args_type} =  Create Dictionary
    ...  code=ANNUL
    ...  libelle=Demande d'annulation
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=${etats_autorises}
    ...  contraintes=Récupération des demandeurs avec modification et ajout
    ...  dossier_instruction_type=PCI - Demande d'annulation
    ...  evenement=Notification du delai legal maison individuelle

    &{args_type_instr} =  Create Dictionary
    ...  code=ANNUL
    ...  libelle=Demande d'annulation
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  suffixe=true
    ...  mouvement_sitadel=SUPPRESSION
    ...  maj_da_etat=true

    &{args_action_modif} =  Create Dictionary
    ...  regle_avis=avis_decision
    ...  regle_date_decision=date_evenement

    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - ANNUL - Demande d'annulation
    &{args_evenement} =  Create Dictionary
    ...  libelle=Abandonner les travaux depuis ANNUL
    ...  type=arrete
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=abandon par le demandeur
    ...  etat=instruction terminee (archive)
    ...  avis_decision=Abandon des Travaux

    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=test annulation
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    Depuis la page d'accueil  admin  admin
    Ajouter type de dossier d'instruction  ${args_type_instr}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button
    Use Simple Search  code  ANNUL
    Click On Link  ANNUL
    Ajouter un nouveau type de demande depuis le menu  ${args_type}
    Depuis le contexte du type de demande avec libellé unique  ${args_type.libelle}
    Depuis le listing  action
    Modifier Action  abandon  ${args_action_modif}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Ajouter l'événement depuis le menu  ${args_evenement}

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${di}
    Element Should Contain  css=#sousform-dossier_autorisation  Accordé

    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande d'annulation
    ...  dossier_instruction=${di}
    ${di_annul} =  Ajouter la demande par WS  ${args_demande}
    Ajouter une instruction au DI  ${di_annul}  Abandonner les travaux depuis ANNUL
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${di_annul}
    Element Should Contain  css=#sousform-dossier_autorisation  Abandonné


Vérification de l'auto-complement des bibles
    [Documentation]  Ajout de bibles
    ...  remplissage automatique des complements et qu'ils soient espacés
    ...  et remplissage du premier complement par les consultations

    # Arguments de creations de bible pour l'auto-complement
    &{args_bible1} =  Create Dictionary
    ...  evenement=accepter un dossier sans réserve
    ...  libelle=test 1
    ...  contenu=test contenu 1
    ...  complement=complément 1
    ...  automatique=Oui
    ...  collectivite=agglo
    &{args_bible2} =  Create Dictionary
    ...  evenement=accepter un dossier sans réserve
    ...  libelle=test 2
    ...  contenu=test contenu 2
    ...  complement=complément 2
    ...  automatique=Oui
    ...  collectivite=agglo
    &{args_bible3} =  Create Dictionary
    ...  evenement=accepter un dossier sans réserve
    ...  libelle=test 3
    ...  contenu=test contenu 3
    ...  complement=complément 3
    ...  automatique=Oui
    ...  collectivite=agglo
    &{args_bible4} =  Create Dictionary
    ...  evenement=accepter un dossier sans réserve
    ...  libelle=test 4
    ...  contenu=test contenu 4
    ...  complement=complément 4
    ...  automatique=Oui
    ...  collectivite=agglo
    &{args_bible_tous} =  Create Dictionary
    ...  evenement=accepter un dossier sans réserve
    ...  libelle=test tous
    ...  contenu=test_contenu_tous
    ...  automatique=Oui
    ...  collectivite=agglo

    Depuis la page d'accueil  admin  admin
    Ajouter une bible depuis l'onglet de l'événement  &{args_bible1}
    Click On Back Button In Subform
    Ajouter une bible depuis l'onglet de l'événement  &{args_bible2}
    Click On Back Button In Subform
    Ajouter une bible depuis l'onglet de l'événement  &{args_bible3}
    Click On Back Button In Subform
    Ajouter une bible depuis l'onglet de l'événement  &{args_bible4}
    Click On Back Button In Subform
    Ajouter une bible depuis l'onglet de l'événement  &{args_bible_tous}
    Click On Back Button In Subform
    Ajouter une bible depuis le paramétrage dossiers  null  test multi 1  test multi contenu 1  complément 1  Oui  null  agglo
    Ajouter une bible depuis le paramétrage dossiers  null  test multi 2  test multi contenu 2  complément 1  Non  null  agglo

    # On test le remplissage automatique et la bible

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet instruction du dossier d'instruction  ${di_ok}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Saisir instruction  accepter un dossier sans réserve  null
    Click On Submit Button In Subform Until Message  Vos modifications ont bien été enregistrées.
    Click On Link  automatique
    Click On Link  bible
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.ui-dialog  test multi 1
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.ui-dialog  test multi 2
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.ui-dialog  test tous
    Select Checkbox  xpath=//*[text()[contains(.,"test multi 2")]]/ancestor::tr/*/input
    Click Element  css=div.ui-dialog>div#upload-container>div>form>div.formControls input[type="submit"]
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Click On Link  accepter un dossier sans réserve
    Element Should Contain  css=#complement_om_html  contenu 1
    Element Should Contain  css=#complement_om_html  test_contenu_tous
    Element Should Contain  css=#complement_om_html  test multi contenu 1
    Element Should Contain  css=#complement_om_html  test multi contenu 2
    Element Should Contain  css=#complement2_om_html  contenu 2
    Element Should Contain  css=#complement2_om_html  test_contenu_tous
    Element Should Contain  css=#complement3_om_html  contenu 3
    Element Should Contain  css=#complement3_om_html  test_contenu_tous
    Element Should Contain  css=#complement4_om_html  contenu 4
    Element Should Contain  css=#complement4_om_html  test_contenu_tous
    Page Should Contain Element  css=.libelle-date_envoi_controle_legalite

    # Arguments de creations de bible pour l'auto-complement
    &{args_bible1} =  Create Dictionary
    ...  evenement=Sursis a statuer
    ...  libelle=test1
    ...  contenu=test1
    ...  complement=complément 1
    ...  automatique=Oui
    ...  collectivite=agglo
    &{args_bible2} =  Create Dictionary
    ...  evenement=Sursis a statuer
    ...  libelle=test2
    ...  contenu=test2
    ...  complement=complément 1
    ...  automatique=Oui
    ...  collectivite=agglo
    Depuis la page d'accueil  admin  admin
    Ajouter une bible depuis l'onglet de l'événement  &{args_bible1}
    Click On Back Button In Subform
    Ajouter une bible depuis l'onglet de l'événement  &{args_bible2}
    Click On Back Button In Subform

    Depuis la page d'accueil  instr  instr
    # On va vérifier que il y a bien un retour à la ligne après automatique
    Depuis l'onglet instruction du dossier d'instruction  ${di_bible_consultation}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Saisir instruction  Sursis a statuer  null
    Click On Submit Button In Subform Until Message  Vos modifications ont bien été enregistrées.
    Click On Link  automatique
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Click On Link  Sursis a statuer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#complement_om_html  test1${\n}test2
    # Vérification du complement basé sur les consultations. Il vérifie
    # la présence, l'avis et la date.
    Depuis l'onglet instruction du dossier d'instruction  ${di_bible_consultation}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Saisir instruction  accepter un dossier avec reserve  null
    Click On Submit Button In Subform Until Message  Vos modifications ont bien été enregistrées.
    Click On Link  automatique
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Click On Link  accepter un dossier avec reserve
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#complement_om_html  Vu l'avis du service SERAM${\n}${\n}Vu l'avis Favorable du service Direction de l'Eau et de l'Assainissement du ${DATE_FORMAT_DD/MM/YYYY}

    # Lecture de la consultation pour la suite des tests
    Depuis l'onglet consultation(s) du dossier d'instruction  ${di_bible_consultation}
    Click Link  59.01 - Direction de l'Eau et de l'Assainissement
    ${status} =  Run Keyword And Return Status  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=div > table
    Run Keyword If  ${status} == False  Click Link  59.01 - Direction de l'Eau et de l'Assainissement
    Click On SubForm Portlet Action  consultation  marquer_comme_lu


Modification d'autorité compétente
    [Documentation]    Test du lien automatique entre l'ajout de l'événement d'instruction
    ...  'Changer l'autorité compétente 'commune état'' et la mise à jour de l'autorité
    ...  compétente du dossier.

    ${di} =  Set Variable  AZ 013055 12 00001P0
    Depuis la page d'accueil  instr  instr

    # Vérification de l'autorité compétente de base
    Depuis le contexte du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#autorite_competente  Commune

    ${inst_autcomp} =  Ajouter une instruction au DI  ${di}  Changer l'autorité compétente 'commune état'
    Click On Link  ${inst_autcomp}
    Element Should Not Contain  css=#sousform-instruction #portlet-actions  Édition
    Element Should Not Contain  css=#sousform-instruction #portlet-actions  Finaliser le document
    # On vérifie que le changement est effectif
    Depuis le contexte du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#autorite_competente  Commune pour état

    # On supprime l'instruction pour revenir à Commune
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#autorite_competente  Commune pour état
    Supprimer l'instruction  ${di}  Changer l'autorité compétente 'commune état'
    Depuis le contexte du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=#autorite_competente  Commune pour état
    Element Text Should Be  css=#autorite_competente  Commune

Vérification ajout de Lot
    [Documentation]  Ajout simple de lots avec verification d'erreur

     Depuis la page d'accueil  instr  instr
    ${di} =  Set Variable  AZ 013055 12 00001P0
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  lot  Lot(s)
    Click Element Until No More Element   css=#action-soustab-lot-corner-ajouter
    Click On Submit Button In Subform Until Message  SAISIE NON ENREGISTRÉE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=div.ui-state-error p span.text  SAISIE NON ENREGISTRÉE
    Input Text  css=#libelle  Lot n°1
    Click On Submit Button In Subform
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform

    Click Element Until No More Element   css=#action-soustab-lot-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#libelle
    Input Text  css=#libelle  Lot n°2
    Click On Submit Button In Subform
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform


Dossier d'instruction à qualifier
    [Documentation]  Vérifie la qualification des dossiers avec le profil de
    ...  qualificateur.

    # On ajoute un dossier d'instruction avec un type qui demande qualification
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=DURAND
    ...  particulier_prenom=MICKAEL
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On vérifie que le dossier soit bien affiché pour le qualificateur
    Depuis la page d'accueil  qualif  qualif
    Element Should Contain  css=#widget_15  ADS
    Click On Link  Voir tous mes dossiers à qualifier
    Use Simple Search  Tous  ${di}
    Click On Link  ${di}
    Element should Contain  css=#a_qualifier  Oui
    # Une fois qualifié, le dossier ne doit plus apparaître dans le listing des
    # qualificateurs
    Click On Form Portlet Action  dossier_instruction  modifier
    Set Checkbox  a_qualifier  false
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Depuis le listing  dossier_qualifier_qualificateur
    Element Should Not Contain  css=#tab-dossier_qualifier_qualificateur .tab-tab  ${di}


Ajout de contraintes
    [Documentation]   Le but de ce test est de vérifier qu'un utilisateur avec
    ...  le profil qualificateur puisse ajouter des contraintes sur un dossier
    ...  d'instruction.

    # On ajoute un dossier d'instruction avec un type qui demande qualification
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=HOUDE
    ...  particulier_prenom=Pierre
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On ajoute une contrainte avec le profil du qualificateur
    Depuis la page d'accueil  qualif  qualif
    Depuis le listing  dossier_qualifier_qualificateur
    Use Simple Search  Tous  ${di}
    Click On Link  ${di}
    On clique sur l'onglet  dossier_contrainte  Contrainte(s)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#action-soustab-dossier_contrainte-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#fieldset-sousform-dossier_contrainte-contraintes-openads legend
    Sleep   1
    Wait Until Keyword Succeeds  5s  1s  Click Element  css=#fieldset-sousform-dossier_contrainte-environnement legend
    
    Wait Until Keyword Succeeds  5s  1s  Click Element  css=#contrainte_5
    Click Element  css=input[value='Appliquer les changements']
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.message  La contrainte Pollution puits a été ajoutée au dossier.
    Click On Back Button In Subform
    Element Should Contain  css=#sousform-dossier_contrainte  Le puits d'une profondeur de [...] est pollué.


TNR Instructeur sans division

    [Documentation]  Un instructeur sans division ne doit pas pouvoir instruire
    ...  de dossier.

    # Ajout d'un instructeur
    Depuis la page d'accueil  admin  admin
    Ajouter l'utilisateur  Test  test@test.fr  instrnodiv  instrnodiv  INSTRUCTEUR  MARSEILLE

    #
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=instrnodiv
    ...  personne_morale_raison_sociale=instrnodiv
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=instrnodiv
    ...  om_collectivite=MARSEILLE
    ...  personne_morale_prenom=instrnodiv

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_nodiv} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrnodiv  instrnodiv

    Depuis l'onglet instruction du dossier d'instruction  ${di_nodiv}
    Page Should Not Contain  css=#action-soustab-instruction-corner-ajouter

    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di_nodiv}
    Page Should Not Contain  css=#action-soustab-dossier_contrainte-corner-ajouter

    Depuis l'onglet consultation(s) du dossier d'instruction  ${di_nodiv}
    Page Should Not Contain  css=#action-soustab-consultation-corner-ajouter

    Depuis le contexte du dossier d'instruction  ${di_nodiv}
    On clique sur l'onglet  dossier_commission  Commission(s)
    Page Should Not Contain  css=#action-soustab-dossier_commission-corner-ajouter

    Depuis le contexte du dossier d'instruction  ${di_nodiv}
    On clique sur l'onglet  lot  Lot(s)
    Page Should Not Contain  css=#action-soustab-lot-corner-ajouter

    Depuis l'onglet des messages du dossier d'instruction  ${di_nodiv}
    Page Should Not Contain  css=#action-soustab-blocnote-message-ajouter

    Depuis le contexte du dossier d'instruction  ${di_nodiv}
    On clique sur l'onglet  blocnote  Bloc-note
    Page Should Not Contain  css=#action-soustab-blocnote-corner-ajouter

    Depuis l'onglet des pièces du dossier d'instruction  ${di_nodiv}
    Page Should Not Contain  css=#action-soustab-blocnote-message-ajouter


Champ contentieux de la consultation du DI
    [Documentation]  Ce test case vérifie que le champ contentieux du DI affiche
    ...  bien les pictogrammes RE et IN si les références cadastrales du dossier
    ...  sont en commun avec respectivement au moins un dossier RE et IN non
    ...  clôturé.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Mylène
    ...  particulier_prenom=Françoise
    ...  om_collectivite=MARSEILLE

    @{ref_cad} =  Create List  001  AA  0007

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE

    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Mélisande
    ...  particulier_prenom=Amélie
    ...  om_collectivite=MARSEILLE

    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Wanda
    ...  particulier_prenom=Manon
    ...  om_collectivite=MARSEILLE

    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}

    &{args_demande_inf} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ...  terrain_references_cadastrales=${ref_cad}

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  assist  assist
    # On vérifie l'existence du champ et l'absence de dossier contentieux
    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Contain  css=#fieldset-form-dossier_instruction-enjeu  contentieux
    Element Should Not Contain  css=#fieldset-form-dossier_instruction-enjeu  IN
    Element Should Not Contain  css=#fieldset-form-dossier_instruction-enjeu  RE

    # Pour tester tous les comportements des pictogrammes EN ET IN,
    # on ajoute 2 recours et 2 infractions

    # On ajoute un premier recours (RE) au dossier
    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  demande_type=Dépôt Initial REC
    ...  autorisation_contestee=${di}
    ...  om_collectivite=MARSEILLE
    ${di_re_1} =  Ajouter la demande par WS  ${args_demande_1}

    # On ajoute un second recours (RE) au dossier
    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  demande_type=Dépôt Initial REC
    ...  autorisation_contestee=${di}
    ...  om_collectivite=MARSEILLE
    ${di_re_2} =  Ajouter la demande par WS  ${args_demande_2}

    # On vérifie l'existence du champ et de RE
    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Contain  css=#fieldset-form-dossier_instruction-enjeu  contentieux
    Element Should Not Contain  css=#fieldset-form-dossier_instruction-enjeu  IN
    Element Should Contain  css=#fieldset-form-dossier_instruction-enjeu  RE

    # On ajoute une première infraction (IN) au dossier
    ${di_inf_1} =  Ajouter la demande par WS  ${args_demande_inf}  ${NULL}  ${args_autres_demandeurs}

    # On ajoute une seconde infraction (IN) au dossier
    ${di_inf_2} =  Ajouter la demande par WS  ${args_demande_inf}  ${NULL}  ${args_autres_demandeurs}

    # On vérifie l'existence du champ et de RE, IN
    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Contain  css=#fieldset-form-dossier_instruction-enjeu  contentieux
    Element Should Contain  css=#fieldset-form-dossier_instruction-enjeu  RE IN

    # Lors de la clôture des premiers recours et infraction,
    # les pictogrammes EN et IN doivent rester respectivement orange et rouge
    Ajouter une instruction au DI  ${di_re_1}  accepter un dossier sans réserve  null  recours
    Ajouter une instruction au DI  ${di_inf_1}  accepter un dossier sans réserve  null  infraction

    Depuis le contexte du dossier d'instruction  ${di}
    Vérifier qu'un élément a une classe CSS  name  RE  label-warning
    Vérifier qu'un élément a une classe CSS  name  IN  label-important

    # Lors de la clôture des seconds recours et infraction,
    # les pictogrammes EN et IN doivent tous les deux passer au vert
    Ajouter une instruction au DI  ${di_re_2}  accepter un dossier sans réserve  null  recours
    Ajouter une instruction au DI  ${di_inf_2}  accepter un dossier sans réserve  null  infraction

    Depuis le contexte du dossier d'instruction  ${di}
    Vérifier qu'un élément a une classe CSS  name  RE  label-success
    Vérifier qu'un élément a une classe CSS  name  IN  label-success


TNR champs de fusion et variables de remplacement des éditions
    [Documentation]  On vérifie les champs spéciaux des éditions
    ...  les points verifiés sont:
    ...  - un champ de fusion qui affiche une variable de remplacement qui a un champ de fusion
    ...  - une variable de remplacement qui affiche un champ de fusion qui a une variable de remplacement
    ...  - une variable de remplacement qui affiche une variable de remplacement
    ...  - un champ de fusion qui affiche un champ de fusion

    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  test1  [complement2_instruction]  MARSEILLE
    Ajouter le paramètre depuis le menu  test2  [complement3_instruction]  MARSEILLE
    Ajouter le paramètre depuis le menu  test3  test_final_variable  MARSEILLE
    Ajouter le paramètre depuis le menu  test4  &test3  MARSEILLE

    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Larocque
    ...  personne_morale_raison_sociale=Cerise
    ...  personne_morale_nom=Larocque
    ...  personne_morale_prenom=Cerise
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Saisir instruction  TNR d'imbrication de champs de fusion et variables de remplacement
    Click On Submit Button In Subform Until Message  Vos modifications ont bien été enregistrées.
    Input HTML  complement_om_html  &test1
    Input HTML  complement2_om_html  test_final_fusion
    Input HTML  complement3_om_html  &test3
    Input HTML  complement4_om_html  [complement2_instruction]
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Click Element Until No More Element  xpath=//a[text()[contains(.,"TNR d'imbrication de champs de fusion et variables de remplacement")]]
    Click On SubForm Portlet Action  instruction  edition  new_window

    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  test_final_variable

    ${body_text} =  Get Text  css=#viewer
    ${lines} =  Get Lines Matching Pattern  ${body_text}  test_final_variable
    ${count} =  Get Line Count  ${lines}
    Should Be Equal As Strings  ${count}  2

    ${lines} =  Get Lines Matching Pattern  ${body_text}  test_final_fusion
    ${count} =  Get Line Count  ${lines}
    Should Be Equal As Strings  ${count}  2

    Close PDF


TNR Les log d'instruction ne doivent pas apparaitre
    [Documentation]  On vérifie l'absence de log_instructions dans la page

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Torri
    ...  particulier_prenom=Renato
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve
    Depuis Le Contexte Du Dossier D'instruction  ${di}
    Page Should Not Contain Element  log_instructions


TNR Bug bind de l'overlay ne s'effectuer plus
    [Documentation]  On vérifie que même après le chargement JS d'un  form
    ...  les overlay s'ouvre toujours.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Charline
    ...  particulier_prenom=Pinette
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrpoly  instrpoly

    # Chargement JS
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  recepisse  message  Le récépissé de la demande a été régénéré.

    # On fait appel à l'overlay
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#fieldset-sousform-donnees_techniques-construire legend


Prévisualisation édition et Rédaction libre
    [Documentation]  On vérifie que la modification des compléments est prise en
    ...  compte dans la preview.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bussi
    ...  particulier_prenom=Anthony
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Set Window Size  1290  800
    Depuis la page d'accueil  instr  instr
    # On vérifie que la prévisualisation n'est pas affichée tant que l'option
    # n'est pas activée
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  ABF recours contre avis
    Depuis l'instruction du dossier d'instruction  ${di}  ABF recours contre avis
    Click On SubForm Portlet Action  instruction  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  complement_om_html_ifr
    Element Should Not Be Visible  css=#frame_pdf

    # Activation option
    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  option_previsualisation_edition  true  agglo
    # Ajout lettre-type
    &{args_lettretype} =  Create Dictionary
    ...  id=recours_contre_avis
    ...  libelle=ABF recours contre avis
    ...  sql=Aucune REQUÊTE
    ...  titre=&contraintes
    ...  corps=[complement2_instruction]
    ...  actif=true
    ...  collectivite=MARSEILLE
    Ajouter la lettre-type depuis le menu  &{args_lettretype}
    #
    Depuis la page d'accueil  instr  instr
    Depuis l'instruction du dossier d'instruction  ${di}  ABF recours contre avis
    Click On SubForm Portlet Action  instruction  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  complement_om_html_ifr
    Input HTML  complement_om_html  Azerty123456++++
    Click Element  css=#btn_refresh
    # Attend que la frame de prévisualisation se charge
    Wait Until Page Contains Element  css=#frame_pdf
    # On remodifie le complément sans actualiser, et ce afin d'une part tester que cela
    # n'a aucun effet, et d'autre part être sûr du DOM lors du test de la prévisualisation
    Input HTML  complement_om_html  123456Azerty
    Select Frame  frame_pdf
    # Attend que la prévisualisation se charge
    Wait Until Page Contains Element  css=#outerContainer
    Set Focus To Element  outerContainer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Azerty123456++++
    Unselect Frame

    # 2ème modification du complément
    Click Element  css=#btn_refresh
    # Attend que la frame de prévisualisation se charge
    Wait Until Page Contains Element  css=#frame_pdf
    Input HTML  complement_om_html  qwerty
    Select Frame  frame_pdf
    # Attend que la prévisualisation se charge
    Wait Until Page Contains Element  css=#outerContainer
    Set Focus To Element  outerContainer
    Wait Until Page Contains  123456Azerty
    Unselect Frame

    # On ajoute un événement d'instruction sans lettre type associé et on
    # vérifie que la prévisualisation n'est pas affiché
    Ajouter une instruction au DI  ${di}  Changer l'autorité compétente 'commune état'
    Depuis l'instruction du dossier d'instruction  ${di}  Changer l'autorité compétente 'commune état'
    Click On SubForm Portlet Action  instruction  modifier
    Element Should Not Be Visible  css=#frame_pdf

    # Désactivation option
    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  option_previsualisation_edition  false  agglo

    # On vérifie que la prévisualisation n'est pas affichée tant que l'option
    # n'est pas activée
    Depuis la page d'accueil  instr  instr
    Depuis l'instruction du dossier d'instruction  ${di}  ABF recours contre avis
    Click On SubForm Portlet Action  instruction  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  complement_om_html_ifr
    Element Should Not Be Visible  css=#frame_pdf

    #Verification de l'option rédaction libre
    # Activation de l'option rédaction libre et previsu
    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  option_redaction_libre  true  agglo
    Modifier le paramètre  option_previsualisation_edition  true  agglo


    #Création du dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Polo
    ...  particulier_prenom=Marco
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #Verification de l'instruction sans lettre type
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  Changer l'autorité compétente 'commune état'
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Be Visible  css=#signataire_arrete
    Element Should Not Be Visible  css=#lib-flag_edition_integrale
    Depuis l'instruction du dossier d'instruction  ${di}  Changer l'autorité compétente 'commune état'

    Element Should Not Be Visible  css=#complement_om_html
    Element Should Not Be Visible  css=#complement2_om_html
    Element Should Not Be Visible  css=#complement3_om_html
    Element Should Not Be Visible  css=#complement4_om_html
    Element Should Not Be Visible  css=#titre_om_htmletat
    Element Should Not Be Visible  css=#corps_om_htmletat
    Element Should Not Be Visible  css=#action-sousform-instruction-enable-edition-integrale
    Element Should Not Be Visible  css=#action-sousform-instruction-disable-edition-integrale
    Element Should Not Be Visible  css=#action-sousform-instruction-finaliser

    Click On SubForm Portlet Action  instruction  modifier

    Element Should Not Be Visible  css=#lib-signataire_arrete
    Element Should Not Be Visible  css=#complement_om_html_ifr
    Element Should Not Be Visible  css=#complement2_om_html_ifr
    Element Should Not Be Visible  css=#complement3_om_html_ifr
    Element Should Not Be Visible  css=#complement4_om_html_ifr
    Element Should Not Be Visible  css=#titre_om_htmletat_ifr
    Element Should Not Be Visible  css=#corps_om_htmletatex_ifr
    Click On Back Button In Subform
    Click On Back Button In Subform

    #Vérification de l'instruction avec lettre type
    Ajouter une instruction au DI  ${di}  ARRÊTÉ DE REFUS
    Click On Back Button In Subform

    #Première condition : Pour les petits écrans
    Set Window Size  1266  800

    Click On SubForm Portlet Action  instruction  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  complement_om_html_ifr
    Element Should Be Visible  css=#complement_om_html_ifr
    Element Should Be Visible  css=#complement2_om_html_ifr
    Element Should Be Visible  css=#complement3_om_html_ifr
    Element Should Be Visible  css=#complement4_om_html_ifr
    Element Should Be Visible  css=#btn_preview
    Element Should Not Be Visible  css=#btn_refresh
    Element Should Not Be Visible  css=#btn_redaction
    Element Should Not Be Visible  css=#frame_pdf

    Input HTML  complement_om_html  Azerty123456++++
    Click Element Until No More Element  css=#btn_preview
    # Attend que la frame de prévisualisation se charge
    Wait Until Page Contains Element  css=#frame_pdf

    Element Should Not Be Visible  css=#complement_om_html_ifr
    Element Should Not Be Visible  css=#complement2_om_html_ifr
    Element Should Not Be Visible  css=#complement3_om_html_ifr
    Element Should Not Be Visible  css=#complement4_om_html_ifr
    Element Should Not Be Visible  css=#btn_preview
    Element Should Not Be Visible  css=#btn_refresh
    Element Should Be Visible  css=#btn_redaction
    Element Should Be Visible  css=#frame_pdf

    Select Frame  frame_pdf
    # Attend que la prévisualisation se charge
    Wait Until Page Contains Element  css=#outerContainer
    Focus  outerContainer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Azerty123456++++
    Unselect Frame

    Click On Back Button In Subform
    Click On SubForm Portlet Action  instruction  enable-edition-integrale  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Rédaction libre activé.

    Click On SubForm Portlet Action  instruction  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  corps_om_htmletatex_ifr
    Open Fieldset In Subform  instruction  titre
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#titre_om_htmletat_ifr
    Element Should Be Visible      css=#corps_om_htmletatex_ifr
    Element Should Be Visible      css=#btn_preview
    Element Should Not Be Visible  css=#btn_refresh
    Element Should Not Be Visible  css=#btn_redaction
    Element Should Not Be Visible  css=#frame_pdf

    Input HTML  corps_om_htmletatex  Azerty123456++++
    Click Element Until No More Element  css=#btn_preview
    # Attend que la frame de prévisualisation se charge
    Wait Until Page Contains Element  css=#frame_pdf

    Element Should Not Be Visible  css=#titre_om_htmletat_ifr
    Element Should Not Be Visible  css=#corps_om_htmletatex_ifr
    Element Should Not Be Visible  css=#btn_preview
    Element Should Not Be Visible  css=#btn_refresh
    Element Should Be Visible  css=#btn_redaction
    Element Should Be Visible  css=#frame_pdf

    Select Frame  frame_pdf
    # Attend que la prévisualisation se charge
    Wait Until Page Contains Element  css=#outerContainer
    Set Focus To Element  outerContainer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Azerty123456++++
    Unselect Frame

    Click On Submit Button In Subform

    #On retourne sur le mode complement
    Click On SubForm Portlet Action  instruction  disable-edition-integrale  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Rédaction par compléments activé.

    #Deuxième condition : Pour les grands écrans
    Set Window Size  1680  1050

    Click On SubForm Portlet Action  instruction  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  complement_om_html_ifr

    Element Should Be Visible  css=#complement_om_html_ifr
    Element Should Be Visible  css=#complement2_om_html_ifr
    Element Should Be Visible  css=#complement3_om_html_ifr
    Element Should Be Visible  css=#complement4_om_html_ifr
    Element Should Be Visible  css=#frame_pdf
    Input HTML  complement_om_html  Azerty123456++++

    Click Element  css=#btn_refresh
    # Attend que la frame de prévisualisation se charge
    Wait Until Page Contains Element  css=#frame_pdf

    Select Frame  frame_pdf
    # Attend que la prévisualisation se charge
    Wait Until Page Contains Element  css=#outerContainer
    Set Focus To Element  outerContainer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Azerty123456++++
    Unselect Frame

    Click On Back Button In Subform
    #On change le mode de rédaction
    Click On SubForm Portlet Action  instruction  enable-edition-integrale  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Rédaction libre activé.

    Click On SubForm Portlet Action  instruction  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  corps_om_htmletatex_ifr
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#fieldset-sousform-instruction-titre legend

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#titre_om_htmletat_ifr
    Element Should Be Visible  css=#corps_om_htmletatex_ifr

    Input HTML  corps_om_htmletatex  Azerty123456
    Click Element  css=#btn_refresh
    # Attend que la frame de prévisualisation se charge
    Wait Until Page Contains Element  css=#frame_pdf

    Select Frame  frame_pdf
    # Attend que la prévisualisation se charge
    Wait Until Page Contains Element  css=#outerContainer
    Set Focus To Element  outerContainer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Azerty123456
    Unselect Frame

    Click On Submit Button In Subform

    Click On SubForm Portlet Action  instruction  edition  new_window
    # On ouvre le PDF
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le contenu du PDF
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Azerty123456
    # On ferme le PDF
    Close PDF


    #-- Vérification de l'instruction en rédaction libre directement
    # (champs de fusion correctement substitué)
    # ajout d'une instruction directement en mode rédaction libre
    Ajouter une instruction au DI  ${di}  accepter un dossier avec reserve  redaction_type=Rédaction libre
    # vérification du contenu du titre
    Open Fieldset In Subform  instruction  titre
    # Besoin de temporiser afin que le fieldset puisse finir de se déplier
    Sleep  2
    ${titre_input} =  Get Value  titre_om_htmletat
    # remplacement du caractère espace &nbsp; produisant un faux-espace
    ${titre_input} =  Replace String Using Regexp  ${titre_input}  Dossier.numéro  Dossier numéro
    # signes d'un champ de fusion non substitué
    Should Not Contain Any  ${titre_input}  [  ]  [libelle_dossier]
    # vérification que le titre n'est pas vide
    Should Contain  ${titre_input}  Dossier numéro
    # vérification du contenu du corps
    ${corps_input} =  Get Value  corps_om_htmletatex
    # remplacement du caractère espace &nbsp; produisant un faux-espace
    ${corps_input} =  Replace String Using Regexp  ${corps_input}  Vu.la.demande  Vu la demande
    # signes d'un champ de fusion non substitué
    Should Not Contain Any  ${corps_input}  [  ]  [libelle_datd]
    # vérification que le corps n'est pas vide
    Should Contain  ${corps_input}  Vu la demande

    # en tant qu'admin
    Depuis la page d'accueil  admin  admin

    # supprime l'instruction de test précédente
    Supprimer l'instruction  ${di}  accepter un dossier avec reserve

    # en tant qu'Instructeur
    Depuis la page d'accueil  instr  instr

    #-- Vérification de la variable de substitution &contraintes
    # (variable correctement substituée)
    # ajout des contraintes au DI
    @{contraintes_a_selectionner} =  Create List  3  1
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${di}  ${contraintes_a_selectionner}
    # ajustement du paramétrage (lettre type et évènement)
    Depuis la page d'accueil  admin  admin
    Modifier la lettre-type  recours_contre_avis  sql=Récapitulatif du dossier d'instruction / instruction
    &{args_evt} =  Create Dictionary
    ...  libelle=ABF recours contre avis
    ...  lettretype=recours_contre_avis ABF recours contre avis
    Modifier l'événement  ${args_evt}
    Depuis la page d'accueil  instr  instr
    # ajout de l'instruction avec cette lettre type
    Ajouter une instruction au DI  ${di}  ABF recours contre avis  redaction_type=Rédaction libre
    # vérifications du contenu du titre
    Open Fieldset In Subform  instruction  titre
    ${titre_input} =  Get Value  id:titre_om_htmletat
    # signes de la variable non substituée
    Should Not Contain  ${titre_input}  &contraintes
    # remplacement du caractère espace &nbsp; produisant un faux-espace
    ${titre_input} =  Replace String Using Regexp  ${titre_input}  ZONES.DU.PLU  ZONES DU PLU
    ${titre_input} =  Replace String Using Regexp  ${titre_input}  AUTRES.SERVITUDES  AUTRES SERVITUDES
    Should Contain  ${titre_input}  ZONES DU PLU
    Should Contain  ${titre_input}  AUTRES SERVITUDES
    Should Contain  ${titre_input}  IMPLANTATION-HAUTEUR
    Click On Back Button In Subform

    # en tant qu'admin
    Depuis la page d'accueil  admin  admin

    # rétablissement du paramétrage (lettre type et évènement)
    Modifier la lettre-type  recours_contre_avis  sql=Aucune REQUÊTE
    &{args_evt} =  Create Dictionary
    ...  libelle=ABF recours contre avis
    ...  lettretype=majoration MAJORATION DU DELAI D'INSTRUCTION
    Modifier l'événement  ${args_evt}

    # désactive la prévisualisation des éditions et la rédaction libre
    Modifier le paramètre  option_previsualisation_edition  false  agglo
    Modifier le paramètre  option_redaction_libre  false  agglo