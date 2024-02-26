*** Settings ***
Documentation  Test du paramétrage des dossiers en profil ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Test Cases ***
Paramétrage type de demande
    [Documentation]  Teste le formulaire du type de demande qui possède des select filtrés

    Depuis la page d'accueil  admin  admin
    &{args} =  Create Dictionary
    ...  code=TEST
    ...  libelle=Test ajout de type de demande
    ...  groupe=Autorisation ADS
    ...  evenement=Notification du delai legal maison individuelle
    ...  demande_nature=Nouveau dossier
    Depuis le tableau des types de demandes
    Click On Add Button
    Saisir le type de demande  ${args}
    Sleep  1
    @{select_datd} =  Get List Items  dossier_autorisation_type_detaille
    Should Contain Match  ${select_datd}  AZ (Demande d'autorisation spéciale de travaux dans le périmètre d'une AVAP)
    Should Contain Match  ${select_datd}  CU (Certificat d'urbanisme)
    Should Contain Match  ${select_datd}  DP (Déclaration préalable)
    Should Contain Match  ${select_datd}  DPS (DECLARATION PREALABLE SIMPLE)
    Should Contain Match  ${select_datd}  PA (Permis d'aménager comprenant ou non des constructions et/ou des démolitions)
    Should Contain Match  ${select_datd}  PCA (Permis de construire comprenant ou non des démolitions)
    Should Contain Match  ${select_datd}  PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    Should Contain Match  ${select_datd}  PD (Permis de démolir)
    Select From List By Label  dossier_autorisation_type_detaille  AZ (Demande d'autorisation spéciale de travaux dans le périmètre d'une AVAP)
    Sleep  1
    @{select_dit} =  Get List Items  dossier_instruction_type
    Should Contain Match  ${select_dit}  AZ - Initiale
    Should Contain Match  ${select_dit}  AZ - Transfert
    Should Contain Match  ${select_dit}  AZ - Modificatif
    Should Contain Match  ${select_dit}  AZ - Achèvement et conformité
    Should Contain Match  ${select_dit}  AZ - Ouverture de chantier
    Select From List By Label  dossier_instruction_type  AZ - Initiale
    Click On Submit Button
    La page ne doit pas contenir d'erreur

Paramétrage action
    [Documentation]  Teste l'existence des champs saisis dans la règle d'une action

    Depuis la page d'accueil  admin  admin

    &{args} =  Create Dictionary
    ...  action=changer_decision
    ...  libelle=Changer la décision
    ...  regle_etat=etat + champ_errone
    ...  regle_date_dernier_depot=NULL
    Depuis le tableau des actions
    Click On Add Button
    Saisir l'action  ${args}
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE
    La page ne doit pas contenir d'erreur
    Error Message Should Contain  Le champ champ_errone n'est pas utilisable pour le champ règle etat
    Error Message Should Contain  Le champ date de dernier dépôt des dossiers ne peut être mis à NULL.

    &{args} =  Create Dictionary
    ...  action=maj_travaux_infra
    ...  libelle=MAJ travaux infra
    ...  cible_regle_donnees_techniques1=ctx_nature_travaux_infra_om_html
    ...  regle_donnees_techniques1=ctx_nature_travaux_infra_om_html+test
    Depuis le tableau des actions
    Click On Add Button
    Saisir l'action  ${args}
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE
    La page ne doit pas contenir d'erreur
    Error Message Should Contain  Le champ test n'est pas utilisable pour le champ Règle donnée technique n°1

    &{args} =  Create Dictionary
    ...  action=maj_travaux_infra
    ...  libelle=MAJ travaux infra
    ...  cible_regle_donnees_techniques1=ctx_nature_travaux_infra_om_html
    ...  regle_donnees_techniques1=ctx_nature_travaux_infra_om_html+complement_om_html
    Depuis le tableau des actions
    Click On Add Button
    Saisir l'action  ${args}
    Click On Submit Button
    La page ne doit pas contenir d'erreur

    # Création d'un événement de workflow de changement de décision
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  IN - P - Initiale
    &{args_evenement} =  Create Dictionary
    ...  libelle=MAJ travaux infra
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=MAJ travaux infra
    ...  lettretype=arrete ARRETE
    #
    Ajouter l'événement depuis le menu  ${args_evenement}

    #
    &{args_contrevenant} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Règles
    ...  personne_morale_raison_sociale=Action
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Martin
    ...  personne_morale_prenom=Nicolas
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE

    ${di_ok} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    #
    Depuis la page d'accueil  juriste  juriste
    ${today} =  Date du jour FR
    Ajouter une instruction au DI    ${di_ok}    MAJ travaux infra  ${today}  infraction
    Click On Back Button In Subform
    Click On Back Button In Subform
    Click On Link    MAJ travaux infra
    Click Element Until No More Element  css=#action-sousform-instruction_contexte_ctx_inf-modifier
    La page ne doit pas contenir d'erreur
    Input HTML    css=#complement_om_html    Détails des travaux en infraction
    Click On Submit Button In Subform
    Depuis le contexte du dossier infraction  ${di_ok}
    # On clique sur l'action données techniques du portlet
    Click On Form Portlet Action    dossier_contentieux_toutes_infractions    donnees_techniques    modale
    # On déplie le fieldset "Construire"
    Open Fieldset In Subform  donnees_techniques_contexte_ctx  contentieux
    Element Should Contain    css=#ctx_nature_travaux_infra_om_html    Détails des travaux en infraction


Paramétrage événément retour
    [Documentation]  Teste le paramétrage entre les événements avant AR et les événements AR

    Depuis la page d'accueil  admin  admin
    #
    &{args} =  Create Dictionary
    ...  libelle=test_princ
    ...  restriction=date_evenement <= archive_date_dernier_depot + 1
    ...  action=initier un delai
    ...  delai=5 Mois
    ...  accord_tacite=Oui
    ...  delai_notification=1 Mois
    ...  avis_decision=Non concerné
    Ajouter l'événement depuis le menu  ${args}
    #
    &{args} =  Create Dictionary
    ...  libelle=test_suivant_tacite
    Ajouter l'événement depuis le menu  ${args}
    #
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args} =  Create Dictionary
    ...  libelle=test_retour
    ...  retour=true
    ...  etat=delai majore
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    Ajouter l'événement depuis le menu  ${args}
    #
    Depuis le contexte de l'événement  test_retour
    Click On Form Portlet Action  evenement  modifier
    Select From List By Label  evenement_suivant_tacite  test_suivant_tacite
    Click On Submit Button
    #
    &{args} =  Create Dictionary
    ...  libelle=test_princ
    ...  evenement_retour_ar=test_retour
    ...  evenement_retour_signature=test_retour
    Depuis le contexte de l'événement  ${args.libelle}
    Click On Form Portlet Action  evenement  modifier
    Saisir l'événement  ${args}
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE
    Error Message Should Contain  L'événement "test_retour" ne peut pas être utilisé en tant qu'événement d'accusé de réception et événement de retour de signature.
    Select From List By Label  evenement_retour_signature  choisir événement lors du retour de signature
    Click On Submit Button
    # On vérifie que les paramètres ont été copiés
    Depuis le contexte de l'événement  test_retour
    Element Text Should Be  restriction  date_evenement <= archive_date_dernier_depot + 1
    Element Text Should Be  delai  5
    Element Text Should Be  accord_tacite  Oui
    Element Text Should Be  delai_notification  1
    Element Text Should Be  avis_decision  Non concerné
    #
    &{args} =  Create Dictionary
    ...  libelle=test_princ_2
    ...  evenement_retour_signature=test_retour
    Depuis le tableau des événements
    Click On Add Button
    Saisir l'événement  ${args}
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE
    Error Message Should Contain  L'événement "test_retour" est déjà utilisé en tant qu'événement d'accusé de réception.
    #
    Go To Submenu  workflows
    Select From List By Label  di_type  PCI - P - Initial
    Element Should Contain  tabs-1  TEST_RETOUR [RETOUR]

Copie d'un événément
    [Documentation]  Nécessite le test case 'Paramétrage événément retour'

    Ajouter une bible depuis l'onglet de l'événement  test_princ  test bible assoc evenement  test bible assoc evenement  null  null  null  agglo
    Depuis le contexte de l'événement  test_princ
    ${id_event} =  Get Text  evenement
    Depuis le tableau des événements
    Use Simple Search  libellé  test_princ
    Wait Until Element Is Visible  action-tab-evenement-left-copier-${id_event}
    Click Element  action-tab-evenement-left-copier-${id_event}
    Select Checkbox  bible
    Click Element  button-Copier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La copie de l'enregistrement événement avec l'identifiant ${id_event} s'est effectuée avec succès
    Click Element  css=#action-link--copy-of-evenement-${id_event}
    Element Should Contain  libelle  Copie de test_princ du
    On clique sur l'onglet  bible  Bible
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-bible table.tab-tab  test bible assoc evenement

Paramétrage contrainte
    [Documentation]  Teste le CRUD des contraintes paramétrées

    &{args} =  Create Dictionary
    ...  libelle=Une contrainte manuelle
    ...  groupe=Zone du PLU
    ...  sousgroupe=protection
    ...  texte=Texte de la contrainte à compléter.
    ...  om_collectivite=agglo
    Ajouter contrainte paramétrée  ${args}
    Depuis le contexte contrainte paramétrée  Une contrainte manuelle
    Element Text Should Be  texte  Texte de la contrainte à compléter.
    &{args} =  Create Dictionary
    ...  texte=Texte de la contrainte à compléter depuis un dossier.
    Modifier contrainte paramétrée  Une contrainte manuelle  ${args}
    Depuis le contexte contrainte paramétrée  Une contrainte manuelle
    Element Text Should Be  texte  Texte de la contrainte à compléter depuis un dossier.
    Supprimer contrainte paramétrée  Une contrainte manuelle
    Depuis le listing  contrainte
    Page Should Not Contain  Une contrainte manuelle


TNR - Vérifie l'événement suivant tacite sur le dossier
    [Documentation]  Ajoute un événement qui comporte un événement suivant
    ...  tacite. Cette événement d'instruction est appliqué sur un DI. On
    ...  vérifie que le DI en question à bien l'événement suivant tacite dans
    ...  son champ "Au terme du délai"

    Depuis la page d'accueil  admin  admin

    # Création de l'événement qui sera utilisé en suivant tacite
    @{etat_source} =  Create List
    ...  delai de notification envoye
    @{type_di} =  Create List
    ...  PCI - P - Initial
    &{args} =  Create Dictionary
    ...  libelle=Evnt suivant tacite
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    Ajouter l'événement depuis le menu  ${args}

    # Création de l'événement qui sera utilisé en suivant tacite
    &{args} =  Create Dictionary
    ...  action=maj_accord_tacite_320
    ...  libelle=maj_accord_tacite_320
    ...  regle_accord_tacite=accord_tacite
    Depuis le tableau des actions
    Click On Add Button
    Saisir l'action  ${args}
    Click On Submit Button
    La page ne doit pas contenir d'erreur

    @{etat_source} =  Create List
    ...  delai de notification envoye
    @{type_di} =  Create List
    ...  PCI - P - Initial
    &{args} =  Create Dictionary
    ...  libelle=Evnt pour test suivant tacite
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  evenement_suivant_tacite=Evnt suivant tacite
    ...  action=maj_accord_tacite_320
    ...  accord_tacite=Oui
    Ajouter l'événement depuis le menu  ${args}

    # On ajoute le DI sur lequel l'événement suivant tacite sera vérifié
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Desilets
    ...  particulier_prenom=Victoire
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  Evnt pour test suivant tacite

    # On vérifie le champ "Au terme du délai" du DI
    Depuis le contexte du dossier d'instruction  ${di}
    Page Should Contain  Evnt suivant tacite


Paramétrage régénération automatique clé citoyen
    [Documentation]  Vérifie que le paramétrage de la régénération de
    ...  la clé d'accès citoyen associée à un dossier fonctionne :
    ...  Ajoute un type de demande en activant la régénération de la clé
    ...  d'accès citoyen pour ce type de demande, puis ajoute une demande de
    ...  ce type pour un dossier d'autorisation, et vérifie que la clé a bien
    ...  été régénérée.

    Depuis la page d'accueil  admin  admin

    # On active l'option clé citoyen pour pouvoir ajouter un dossier avec clé
    Modifier le paramètre  option_portail_acces_citoyen  true  agglo

    # Création du type de demande qui sera utilisé pour la régénération de la clé
    @{etats_autorises} =    Create List
    ...    delai majore
    ...    delai de notification envoye
    ...    dossier sans notification de delai
    &{args_demande_type} =  Create Dictionary
    ...  code=TEST
    ...  libelle=Test regen clé citoyen pour un type de demande
    ...  groupe=Autorisation ADS
    ...  evenement=Notification de delai
    ...  demande_nature=Dossier existant
    ...  etats_autorises=${etats_autorises}
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  regeneration_cle_citoyen=true
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}

    # On ajoute le DI sur lequel la clé d'acces citoyen sera vérifié
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Young
    ...  particulier_prenom=Penryn
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On vérifie que le DI nouvellement créé contient bien une clé d'accès citoyen
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'est pas vide
    Open Fieldset    dossier_instruction    demandeur
    Wait Until Element Is Visible  cle_acces_citoyen
    ${citizen_access_key} =  Get Text  cle_acces_citoyen
    Should Not Be Empty  ${citizen_access_key}

    # On fait pour ce DI une demande dont le type doit provoquer une régénération de la clé d'accès citoyen
    &{args_demande} =  Create Dictionary
    ...  demande_type=Test regen clé citoyen pour un type de demande
    ...  dossier_instruction=${di}
    ${di_M01} =  Ajouter la demande par WS  ${args_demande}

    # On vérifie que le DI sur lequel on a fait la demande contient bien une nouvelle clé d'accès citoyen
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'est pas vide
    Open Fieldset    dossier_instruction    demandeur
    Wait Until Element Is Visible  cle_acces_citoyen
    ${citizen_access_key_regen} =  Get Text  cle_acces_citoyen
    Should Not Be Empty  ${citizen_access_key_regen}

    # On vérifie que l'ancienne clé et la nouvelle ne sont pas égales
    Should Not Be Equal  ${citizen_access_key_regen}  ${citizen_access_key}

Paramétrage événément non supprimable et non modifiable
    [Documentation]  Teste l'impact des événements non paramétrable et non modifiable
    ...  sur une instruction.
    ...  Vérifie également qu'il n'est pas possible d'avoir une lettretype sur l'évenment
    ...  si il n'est pas modifiable.

    Depuis la page d'accueil  admin  admin

    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    #
    &{args} =  Create Dictionary
    ...  libelle=test_evenement_non_modif
    ...  non_modifiable=true
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    Ajouter l'événement depuis le menu  ${args}
    #
    &{args} =  Create Dictionary
    ...  libelle=test_evenement_non_suppr
    ...  non_supprimable=true
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    Ajouter l'événement depuis le menu  ${args}
    #
    &{args} =  Create Dictionary
    ...  libelle=test_evenement_non_suppr_non_modif
    ...  non_modifiable=true
    ...  non_supprimable=true
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    Ajouter l'événement depuis le menu  ${args}

    # Test le cas ou l'événement est non modifiable et qu'on associe une lettretype
    &{args} =  Create Dictionary
    ...  libelle=test_evenement_non_suppr_non_modif
    ...  non_modifiable=true
    ...  non_supprimable=true
    ...  lettretype=arrete ARRETE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    Depuis le tableau des événements
    Click On Add Button
    Saisir l'événement  ${args}
    Click On Submit Button
    Error Message Should Contain  L'evenement ne peut pas avoir une lettre type et être non modifiable

    # On ajoute le DI sur lequel on va tester les instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Armenta
    ...  particulier_prenom=Virginia
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout des intsructions
    ${instr_non_modif} =  Ajouter une instruction au DI  ${di}  test_evenement_non_modif
    ${instr_non_suppr} =  Ajouter une instruction au DI  ${di}  test_evenement_non_suppr
    ${instr_non_modif_non_suppr} =  Ajouter une instruction au DI  ${di}  test_evenement_non_suppr_non_modif

    # Vérification des actions des instructions
    Depuis l'instruction du dossier d'instruction  ${di}  ${instr_non_modif}
    Portlet Action Should Not Be In Form  instruction  modifier

    Depuis l'instruction du dossier d'instruction  ${di}  ${instr_non_suppr}
    Portlet Action Should Not Be In Form  instruction  supprimer

    Depuis l'instruction du dossier d'instruction  ${di}  ${instr_non_modif_non_suppr}
    Portlet Action Should Not Be In Form  instruction  supprimer
    Portlet Action Should Not Be In Form  instruction  modifier

Paramétrage événément avec commentaire
    [Documentation]  Vérifie que si l'événement à l'option commentaire alors
    ...  le champs commentaire est visible lors de la création et de la consultation de
    ...  l'instruction.

    Depuis la page d'accueil  admin  admin

    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    #
    &{args} =  Create Dictionary
    ...  libelle=test_evenement_commentaire
    ...  commentaire=true
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    Ajouter l'événement depuis le menu  ${args}
    #

    # On ajoute le DI sur lequel on va tester les instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Batard
    ...  particulier_prenom=William
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Test de l'affichage du champ commentaire selon l'événement choisi
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter

    Saisir instruction  test_evenement_commentaire  null  null  null  test du commentaire
    Element Should Be Visible  css=#commentaire

    Saisir instruction  ARRÊTÉ DE REFUS  null  null  null
    Element Should Not Be Visible  css=#commentaire

    Saisir instruction  test_evenement_commentaire  null  null  null  test du commentaire
    Element Should Be Visible  css=#commentaire

    Click On Submit Button In Subform
    Page Should Contain  Vos modifications ont bien été enregistrées.
    Click On Link  test_evenement_commentaire
    ${instruction} =  Get Value  css=.form-content input#instruction

    # Vérification de la présence du commentaire en consultation
    Depuis l'instruction du dossier d'instruction  ${di}  ${instruction}
    Element Should Contain  css=#commentaire  test du commentaire

    # Vérifie que le commentaire n'est pas modifiable
    Click On SubForm Portlet Action  instruction  modifier
    Element Should Not Be Visible  css=div.field-type-hidden #commentaire

