*** Settings ***
Documentation     Évolutions du connecteur SIG

# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown


*** Keywords ***
Activer le mode MC/ABF
    Depuis la page d'accueil  admin  admin

    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_option_mode_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_mode_service_consulte}
    &{param_option_om_collectivite_entity} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_om_collectivite_entity}
    &{param_option_dossier_saisie_numero_complet} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_dossier_saisie_numero_complet}


Désactiver le mode MC/ABF
    Depuis la page d'accueil  admin  admin

    &{param_dossier_commune} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_dossier_commune}
    &{param_option_mode_service_consulte} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_mode_service_consulte}
    &{param_option_om_collectivite_entity} =  Create Dictionary
    ...  libelle=option_om_collectivite_entity
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_om_collectivite_entity}
    &{param_option_dossier_saisie_numero_complet} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_dossier_saisie_numero_complet}


*** Test Cases ***
Setup

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin

    # Isolation du contexte
    &{collectivite_values} =  Create Dictionary
    ...  om_collectivite_libelle=Collectivité-evol-sig
    ...  departement=026
    ...  commune=362
    ...  insee=26362
    ...  direction_code=E
    ...  direction_libelle=Direction de Collectivité-evol-sig
    ...  direction_chef=Chef
    ...  division_code=K
    ...  division_libelle=Division K
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Lo Cean
    ...  guichet_om_utilisateur_email=lcean@openads-test.fr
    ...  guichet_om_utilisateur_login=lcean
    ...  guichet_om_utilisateur_pwd=lcean
    ...  instr_om_utilisateur_nom=La Mer
    ...  instr_om_utilisateur_email=lmer@openads-test.fr
    ...  instr_om_utilisateur_login=lmer
    ...  instr_om_utilisateur_pwd=lmer
    ...  code_entite=evol_sig
    ...  acteur=EV-SIG-0001
    Isolation d'un contexte  ${collectivite_values}
    Set Suite Variable  ${collectivite_values}

    Depuis le contexte de la collectivité  ${collectivite_values.om_collectivite_libelle}
    ${collectivite_id} =  Get Text  css=#om_collectivite
    Set Suite Variable  ${collectivite_id}

    # ajout le code entité et acteur
    Ajouter le paramètre depuis le menu  code_entite  ${collectivite_values.code_entite}
    ...  ${collectivite_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte  ${collectivite_values.acteur}
    ...  ${collectivite_values.om_collectivite_libelle}

    # paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_PCI
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}
    &{param_type_demande_modificatif} =  Create Dictionary
    ...  libelle=param_type_demande_modificatif_PCI
    ...  valeur=DM
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_type_demande_modificatif}
    &{param_type_demande_transfert} =  Create Dictionary
    ...  libelle=param_type_demande_transfert_PCI
    ...  valeur=DT
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_type_demande_transfert}

    # rend l'instructeur polyvalent (nécessaire pour le droit de supprimer les dossiers)
    &{args_om_util} =  Create Dictionary
    ...  om_profil=INSTRUCTEUR POLYVALENT
    Modifier l'utilisateur depuis le menu  lmer  ${args_om_util}

    # même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # option_instructeur_division_numero_dossier
    &{param_option_instructeur_division_numero_dossier} =  Create Dictionary
    ...  libelle=option_instructeur_division_numero_dossier
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_instructeur_division_numero_dossier}

    # ajout paramètres SIG
    &{param_option_sig} =  Create Dictionary
    ...  libelle=option_sig
    ...  valeur=sig_externe
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_sig}
    &{param_code_direction} =  Create Dictionary
    ...  libelle=code_direction
    ...  valeur=0
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_code_direction}

    # Synchronisation des contraintes de géolocalisation
    Depuis la page d'accueil  admingen  admingen
    Synchroniser les contraintes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  3 contrainte(s)

    # Ajout d'une commune
    &{commune} =  Create Dictionary
    ...  typecom=COM
    ...  com=${collectivite_values.insee}
    ...  reg=20
    ...  dep=26
    ...  arr=362
    ...  ncc=Commune-evol-sig
    ...  nccenr=Commune-evol-sig
    ...  libelle=Commune-evol-sig
    ${commune_id} =  Ajouter commune avec dates validité  ${commune}
    Set Suite Variable  ${commune_id}

Verification de la récupération des contraintes en cas d'id alphanumerique
    [Documentation]  Verifie que en cas d'id alphanumerique,
    ...    la récupération des contraintes se fait sans erreur

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}
    Synchroniser les contraintes
    Synchroniser les contraintes
    Element Should Not Contain  css=div.message.ui-state-valid p span.text   Une erreur s'est produite 

Suppression de la géolocalisation à la suppression d'un dossier

    Depuis la page d'accueil  admin  admin

    # ajout paramètre suppression dossier
    &{param_option_suppression_dossier_instruction} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_suppression_dossier_instruction}

    # ajout d'un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Gi
    ...  particulier_prenom=Gi
    ...  om_collectivite=Collectivité-evol-sig
    @{ref_cad} =  Create List  000  AB  0651
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-evol-sig
    ...  date_demande=01/12/2022
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # géolocalisation du dossier
    Depuis la page d'accueil  lmer  lmer
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Click Element  css=input#verif_parcelle-button
    Wait Until Element Contains  css=div#verif_parcelle-message  Les parcelles existent.
    Click Element  css=input#calcul_emprise-button
    Wait Until Element Contains  css=div#calcul_emprise-message  L'emprise a été calculée.
    Click Element  css=input#calcul_centroide-button
    Wait Until Element Contains  css=div#calcul_centroide-message  Le centroide a été calculé
    Click Element  css=input#recup_contrainte-button
    Handle Alert
    Wait Until Element Contains  css=span#contrainte  2 contrainte(s) ajoutée(s) depuis le SIG

    # vérification que le dossier est bien géolocalisé (présence lien et POINT)
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  POINT(10123 10456)

    # suppression du dossier
    ##Depuis le contexte du dossier d'instruction  ${di_libelle}
    Portlet Action Should Be In Form  dossier_instruction  supprimer
    Supprimer le dossier d'instruction  ${di_libelle}
    Valid Message Should Be  La suppression a été correctement effectuée.

    # désactive le paramètre suppression dossier
    Depuis la page d'accueil  admin  admin
    &{param_option_suppression_dossier_instruction} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_option_suppression_dossier_instruction}


Copie de la géolocalisation à partir d'un autre dossier - mode commune

    # ajout d'un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Ju
    ...  particulier_prenom=Ju
    ...  om_collectivite=Collectivité-evol-sig
    @{ref_cad} =  Create List  000  AB  0651
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-evol-sig
    ...  date_demande=02/12/2022
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # géolocalisation du dossier
    Depuis la page d'accueil  lmer  lmer
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Click Element  css=input#verif_parcelle-button
    Wait Until Element Contains  css=div#verif_parcelle-message  Les parcelles existent.
    Click Element  css=input#calcul_emprise-button
    Wait Until Element Contains  css=div#calcul_emprise-message  L'emprise a été calculée.
    Click Element  css=input#calcul_centroide-button
    Wait Until Element Contains  css=div#calcul_centroide-message  Le centroide a été calculé
    Click Element  css=input#recup_contrainte-button
    Handle Alert
    Wait Until Element Contains  css=span#contrainte  2 contrainte(s) ajoutée(s) depuis le SIG

    # vérification que le dossier est bien géolocalisé (présence lien et POINT)
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  POINT(10123 10456)

    # vérification que le dossier possède bien les contraintes
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une contrainte du PLU pour le test de geoloc
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une seconde contrainte du PLU pour le test de geoloc

    # instruction du dossier
    Ajouter une instruction au DI  ${di_libelle}  accepter un dossier sans réserve

    # ajout d'un modificatif du dossier (création d'un nouveau dossier)
    &{args_demande_mod} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di_libelle}
    ...  date_demande=02/12/2022
    ${di_libelle_mod} =  Ajouter la demande par WS  ${args_demande_mod}

    # Contrôle des références cadastrales sur le dossier
    Depuis le contexte du dossier d'instruction  ${di_libelle_mod}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  000AB0651

    # vérification que le nouveau dossier est bien géolocalisé (identique au précédent)
    Depuis le contexte du dossier d'instruction  ${di_libelle_mod}
    Form Value Should Contain  geom  POINT(10123 10456)

    # vérification que le nouveau dossier possède bien les contraintes (identique au précédent)
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di_libelle_mod}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une contrainte du PLU pour le test de geoloc
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une seconde contrainte du PLU pour le test de geoloc

    # instruction du dossier
    Depuis le contexte du dossier d'instruction  ${di_libelle_mod}
    Ajouter une instruction au DI  ${di_libelle_mod}  accepter un dossier sans réserve

    # ajout d'un modificatif du dossier (création d'un nouveau dossier)
    &{args_demande_mod2} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di_libelle}
    ...  date_demande=02/12/2022
    ${di_libelle_mod2} =  Ajouter la demande par WS  ${args_demande_mod2}

    # Contrôle des références cadastrales sur le dossier
    Depuis le contexte du dossier d'instruction  ${di_libelle_mod2}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  000AB0651

    # vérification que le nouveau dossier est bien géolocalisé (identique au précédent)
    Depuis le contexte du dossier d'instruction  ${di_libelle_mod2}
    Form Value Should Contain  geom  POINT(10123 10456)

    # vérification que le nouveau dossier possède bien les contraintes (identique au précédent)
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di_libelle_mod2}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une contrainte du PLU pour le test de geoloc
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une seconde contrainte du PLU pour le test de geoloc


Copie de la géolocalisation à partir d'un dossier parent - mode "MC/ABF"
    Activer le mode MC/ABF

    # Définir un type de dossier comme étant un sous-type d'un autre
    Depuis la page d'accueil  admin  admin
    ${codeSsDossier} =  Set Variable  SDESIG
    ${libSsDossier} =  Set Variable  Sous Dossier Evol SIG
    @{di_compatibles} =    Create List
    ...    PCI - P - Permis de construire pour une maison individuelle et / ou ses annexes - Initial
    &{args_type_di} =  Create Dictionary
    ...  code=${codeSsDossier}
    ...  libelle=${libSsDossier}
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    ...  maj_da_localisation=false
    ${idSsDossierEvolSIG} =  Ajouter type de dossier d'instruction  ${args_type_di}
    &{args_demande_type} =  Create Dictionary
    ...    code=TEST${codeSsDossier}
    ...    libelle=Test sous dossier évol SIG
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...    demande_nature=Dossier existant
    ...    dossier_instruction_type=${libSsDossier}
    ...    evenement=Notification de delai
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}

    # ajouter un dossier (type parent)
#     &{args_petitionnaire} =  Create Dictionary
#     ...  particulier_nom=Ro
#     ...  particulier_prenom=Ro
#     ...  om_collectivite=Collectivité-evol-sig
#     @{ref_cad} =  Create List  000  AB  0651
#     &{args_demande} =  Create Dictionary
#     ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
#     ...  demande_type=Dépôt Initial
#     ...  om_collectivite=Collectivité-evol-sig
#     ...  commune=${commune_id}
#     ...  date_demande=03/12/2022
#     ...  terrain_references_cadastrales=${ref_cad}
#     ...  num_doss_complet=PC 026362 22 E0001
#     ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-SIG-00
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  SIG-000-00
    ${json_payload} =  Replace String  ${json_payload}  13055  ${collectivite_values.insee}
    ${json_payload} =  Replace String  ${json_payload}  "om_collectivite": "2"  "om_collectivite": "${collectivite_id}"
    ${json_payload} =  Replace String  ${json_payload}  "annee": "20"  "annee": "22"
    ${json_payload} =  Replace String  ${json_payload}  2020  2022
    ${json_payload} =  Replace String  ${json_payload}  2021  2022
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee} 20  0${collectivite_values.insee} 22
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee}20  0${collectivite_values.insee}22
    ${json_payload} =  Replace String  ${json_payload}  TEST300TASK  EVOLSIG
    ${json_payload} =  Replace String  ${json_payload}  P0  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  07777  00001
    ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${collectivite_values.acteur}
    ${json_payload} =  Replace String  ${json_payload}  "terrain_references_cadastrales": ""  "terrain_references_cadastrales": "000AB0651"
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  [^ ]{5}$  00001 ${collectivite_values.code_entite}01
    ${da_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ...  [^ ]{5}$  00001
    ${di_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier"]}
    ...  [^ ]{5}$  00001${collectivite_values.code_entite}01
    ${da_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation"]}
    ...  [^ ]{5}$  00001
    ${di_regex} =  Catenate  .*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
#     Depuis le contexte du dossier d'autorisation  ${da_lib_expected}
#     Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
#     ...  Element Should Contain  css=#dossier_autorisation_libelle  ${da_lib_expected}
    ${di_libelle} =  Set Variable  ${di_lib_expected}

    # géolocalisation du dossier
    Depuis la page d'accueil  lmer  lmer
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Click Element  css=input#verif_parcelle-button
    Wait Until Element Contains  css=div#verif_parcelle-message  Les parcelles existent.
    Click Element  css=input#calcul_emprise-button
    Wait Until Element Contains  css=div#calcul_emprise-message  L'emprise a été calculée.
    Click Element  css=input#calcul_centroide-button
    Wait Until Element Contains  css=div#calcul_centroide-message  Le centroide a été calculé
    Click Element  css=input#recup_contrainte-button
    Handle Alert
    Wait Until Element Contains  css=span#contrainte  2 contrainte(s) ajoutée(s) depuis le SIG

    # vérification que le dossier est bien géolocalisé (présence lien et POINT)
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  POINT(10123 10456)

    # vérification que le dossier possède bien les contraintes
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une contrainte du PLU pour le test de geoloc
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une seconde contrainte du PLU pour le test de geoloc

    # instruction du dossier
    Ajouter une instruction au DI  ${di_libelle}  accepter un dossier sans réserve

    # ajouter un sous-dossier (sous-type)
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${di_libelle}
    Element Should Contain  css=#sousform-sous_dossier_${idSsDossierEvolSIG}  sous dossier evol sig
    Ajouter le sous-dossier au dossier  ${idSsDossierEvolSIG}
    ${di_libelle_maj} =  Convert To Upper Case  ${di_libelle}
    Wait Until Element Contains  css=#title > h2  Instruction > Sous Dossier Evol SIG > ${di_libelle_maj} > ${codeSsDossier}01
    ${di_libelle_sd} =  Set Variable  ${di_libelle} ${codeSsDossier}01
    Element Should Contain  css=#dossier_libelle  ${di_libelle_sd}

    # vérifier que le dossier est géolocalisé de manière identique au dossier "parent"
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${di_libelle}
    ${di_libelle_sd_nospace} =  Sans espace  ${di_libelle_sd}
    Click On Link  css=#sousform-sous_dossier_${idSsDossierEvolSIG} .firstcol a[href$="idx=${di_libelle_sd_nospace}"]
    Form Value Should Contain  geom  POINT(10123 10456)
    On clique sur l'onglet  dossier_contrainte  Contrainte(s)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une contrainte du PLU pour le test de geoloc
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une seconde contrainte du PLU pour le test de geoloc

    # ajouter un autre sous-dossier
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${di_libelle}
    Element Should Contain  css=#sousform-sous_dossier_${idSsDossierEvolSIG}  sous dossier evol sig
    Ajouter le sous-dossier au dossier  ${idSsDossierEvolSIG}
    ${di_libelle_maj} =  Convert To Upper Case  ${di_libelle}
    Wait Until Element Contains  css=#title > h2  Instruction > Sous Dossier Evol SIG > ${di_libelle_maj} > ${codeSsDossier}02
    ${di_libelle_sd} =  Set Variable  ${di_libelle} ${codeSsDossier}02
    Element Should Contain  css=#dossier_libelle  ${di_libelle_sd}

    # vérifier que le dossier est géolocalisé de manière identique au dossier "parent"
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${di_libelle}
    ${di_libelle_sd_nospace} =  Sans espace  ${di_libelle_sd}
    Click On Link  css=#sousform-sous_dossier_${idSsDossierEvolSIG} .firstcol a[href$="idx=${di_libelle_sd_nospace}"]
    Form Value Should Contain  geom  POINT(10123 10456)
    On clique sur l'onglet  dossier_contrainte  Contrainte(s)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une contrainte du PLU pour le test de geoloc
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une seconde contrainte du PLU pour le test de geoloc

    Désactiver le mode MC/ABF


Copie de la géolocalisation à partir d'un dossier sur le même DA - mode "MC/ABF"
    Activer le mode MC/ABF

    # ajouter un dossier (consultation)
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-SIG-01
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  SIG-000-01
    ${json_payload} =  Replace String  ${json_payload}  13055  ${collectivite_values.insee}
    ${json_payload} =  Replace String  ${json_payload}  "om_collectivite": "2"  "om_collectivite": "${collectivite_id}"
    ${json_payload} =  Replace String  ${json_payload}  "annee": "20"  "annee": "22"
    ${json_payload} =  Replace String  ${json_payload}  2020  2022
    ${json_payload} =  Replace String  ${json_payload}  2021  2022
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee} 20  0${collectivite_values.insee} 22
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee}20  0${collectivite_values.insee}22
    ${json_payload} =  Replace String  ${json_payload}  TEST300TASK  EVOLSIG
    ${json_payload} =  Replace String  ${json_payload}  P0  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  07777  00002
    ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${collectivite_values.acteur}
    ${json_payload} =  Replace String  ${json_payload}  "terrain_references_cadastrales": ""  "terrain_references_cadastrales": "000AB0651"
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  [^ ]{5}$  00002 ${collectivite_values.code_entite}01
    ${da_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ...  [^ ]{5}$  00002
    ${di_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier"]}
    ...  [^ ]{5}$  00002${collectivite_values.code_entite}01
    ${da_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation"]}
    ...  [^ ]{5}$  00002
    ${di_regex} =  Catenate  .*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    ${di_libelle} =  Set Variable  ${di_lib_expected}

    # géolocalisation du dossier
    Depuis la page d'accueil  lmer  lmer
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Click Element  css=input#verif_parcelle-button
    Wait Until Element Contains  css=div#verif_parcelle-message  Les parcelles existent.
    Click Element  css=input#calcul_emprise-button
    Wait Until Element Contains  css=div#calcul_emprise-message  L'emprise a été calculée.
    Click Element  css=input#calcul_centroide-button
    Wait Until Element Contains  css=div#calcul_centroide-message  Le centroide a été calculé
    Click Element  css=input#recup_contrainte-button
    Handle Alert
    Wait Until Element Contains  css=span#contrainte  2 contrainte(s) ajoutée(s) depuis le SIG

    # vérification que le dossier est bien géolocalisé (présence lien et POINT)
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  POINT(10123 10456)

    # vérification que le dossier possède bien les contraintes
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une contrainte du PLU pour le test de geoloc
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une seconde contrainte du PLU pour le test de geoloc

    # ajouter un second dossier (consultation) sur le même DA
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-SIG-02
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  SIG-000-02
    ${json_payload} =  Replace String  ${json_payload}  13055  ${collectivite_values.insee}
    ${json_payload} =  Replace String  ${json_payload}  "om_collectivite": "2"  "om_collectivite": "${collectivite_id}"
    ${json_payload} =  Replace String  ${json_payload}  "annee": "20"  "annee": "22"
    ${json_payload} =  Replace String  ${json_payload}  2020  2022
    ${json_payload} =  Replace String  ${json_payload}  2021  2022
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee} 20  0${collectivite_values.insee} 22
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee}20  0${collectivite_values.insee}22
    ${json_payload} =  Replace String  ${json_payload}  TEST300TASK  EVOLSIG
    ${json_payload} =  Replace String  ${json_payload}  P0  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  07777  00002
    ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${collectivite_values.acteur}
    ${json_payload} =  Replace String  ${json_payload}  "terrain_references_cadastrales": ""  "terrain_references_cadastrales": "000AB0651"
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  [^ ]{5}$  00002 ${collectivite_values.code_entite}02
    ${da_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ...  [^ ]{5}$  00002
    ${di_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier"]}
    ...  [^ ]{5}$  00002${collectivite_values.code_entite}02
    ${da_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation"]}
    ...  [^ ]{5}$  00002
    ${di_regex} =  Catenate  .*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    ${di_libelle} =  Set Variable  ${di_lib_expected}

    # vérifier que le dossier est géolocalisé de manière identique au dossier "parent"
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  POINT(10123 10456)

    # vérification que le nouveau dossier possède bien les contraintes (identique au précédent)
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une contrainte du PLU pour le test de geoloc
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une seconde contrainte du PLU pour le test de geoloc

    Désactiver le mode MC/ABF


Dossier ajouté malgré l'échec de la copie de la géolocalisation à partir d'un dossier sur le même DA - mode "MC/ABF"
    Activer le mode MC/ABF

    # ajouter un dossier (consultation)
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-SIG-03
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  SIG-000-03
    ${json_payload} =  Replace String  ${json_payload}  13055  ${collectivite_values.insee}
    ${json_payload} =  Replace String  ${json_payload}  "om_collectivite": "2"  "om_collectivite": "${collectivite_id}"
    ${json_payload} =  Replace String  ${json_payload}  "annee": "20"  "annee": "22"
    ${json_payload} =  Replace String  ${json_payload}  2020  2022
    ${json_payload} =  Replace String  ${json_payload}  2021  2022
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee} 20  0${collectivite_values.insee} 22
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee}20  0${collectivite_values.insee}22
    ${json_payload} =  Replace String  ${json_payload}  TEST300TASK  EVOLSIG
    ${json_payload} =  Replace String  ${json_payload}  P0  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  07777  00003
    ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${collectivite_values.acteur}
    ${json_payload} =  Replace String  ${json_payload}  "terrain_references_cadastrales": ""  "terrain_references_cadastrales": "000AB0653"
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  [^ ]{5}$  00003 ${collectivite_values.code_entite}01
    ${da_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ...  [^ ]{5}$  00003
    ${di_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier"]}
    ...  [^ ]{5}$  00003${collectivite_values.code_entite}01
    ${da_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation"]}
    ...  [^ ]{5}$  00003
    ${di_regex} =  Catenate  .*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    ${di_libelle} =  Set Variable  ${di_lib_expected}

    # géolocalisation du dossier
    Depuis la page d'accueil  lmer  lmer
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Click Element  css=input#verif_parcelle-button
    Wait Until Element Contains  css=div#verif_parcelle-message  Les parcelles existent.
    Click Element  css=input#calcul_emprise-button
    Wait Until Element Contains  css=div#calcul_emprise-message  L'emprise a été calculée.
    Click Element  css=input#calcul_centroide-button
    Wait Until Element Contains  css=div#calcul_centroide-message  Le centroide a été calculé
    Click Element  css=input#recup_contrainte-button
    Handle Alert
    Wait Until Element Contains  css=span#contrainte  2 contrainte(s) ajoutée(s) depuis le SIG

    # vérification que le dossier est bien géolocalisé (présence lien et POINT)
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  POINT(10123 10456)
    Capture Page Screenshot

    # vérification que le dossier possède bien les contraintes
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di_libelle}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une contrainte du PLU pour le test de geoloc
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte table.tab-tab tbody  Une seconde contrainte du PLU pour le test de geoloc

    # ajouter un second dossier (consultation) sur le même DA, qui aurait dû échouer
    # à cause d'une exception
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-SIG-04
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  SIG-000-04
    ${json_payload} =  Replace String  ${json_payload}  13055  ${collectivite_values.insee}
    ${json_payload} =  Replace String  ${json_payload}  "om_collectivite": "2"  "om_collectivite": "${collectivite_id}"
    ${json_payload} =  Replace String  ${json_payload}  "annee": "20"  "annee": "22"
    ${json_payload} =  Replace String  ${json_payload}  2020  2022
    ${json_payload} =  Replace String  ${json_payload}  2021  2022
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee} 20  0${collectivite_values.insee} 22
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee}20  0${collectivite_values.insee}22
    ${json_payload} =  Replace String  ${json_payload}  TEST300TASK  EVOLSIG
    ${json_payload} =  Replace String  ${json_payload}  P0  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  07777  00003
    ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${collectivite_values.acteur}
    ${json_payload} =  Replace String  ${json_payload}  "terrain_references_cadastrales": ""  "terrain_references_cadastrales": "000AB0654"
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  [^ ]{5}$  00003 ${collectivite_values.code_entite}02
    ${da_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ...  [^ ]{5}$  00003
    ${di_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier"]}
    ...  [^ ]{5}$  00003${collectivite_values.code_entite}02
    ${da_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation"]}
    ...  [^ ]{5}$  00003
    ${di_regex} =  Catenate  .*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    ${di_libelle} =  Set Variable  ${di_lib_expected}

    # vérifier que le dossier n'est pas géolocalisé
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  Aucune géolocalisation

    # ajouter un troisème dossier (consultation) sur le même DA, qui aurait dû échouer
    # à cause d'une erreur métier (return false)
    ${json_payload} =  Get File  ${EXECDIR}${/}binary_files${/}json_payload_ref.txt
    ${json_payload} =  Replace String  ${json_payload}  7XY-DK8-5X  000-SIG-05
    ${json_payload} =  Replace String  ${json_payload}  3XY-DK4-7X  SIG-000-05
    ${json_payload} =  Replace String  ${json_payload}  13055  ${collectivite_values.insee}
    ${json_payload} =  Replace String  ${json_payload}  "om_collectivite": "2"  "om_collectivite": "${collectivite_id}"
    ${json_payload} =  Replace String  ${json_payload}  "annee": "20"  "annee": "22"
    ${json_payload} =  Replace String  ${json_payload}  2020  2022
    ${json_payload} =  Replace String  ${json_payload}  2021  2022
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee} 20  0${collectivite_values.insee} 22
    ${json_payload} =  Replace String  ${json_payload}  0${collectivite_values.insee}20  0${collectivite_values.insee}22
    ${json_payload} =  Replace String  ${json_payload}  TEST300TASK  EVOLSIG
    ${json_payload} =  Replace String  ${json_payload}  P0  ${EMPTY}
    ${json_payload} =  Replace String  ${json_payload}  07777  00003
    ${json_payload} =  Replace String  ${json_payload}  EF-DSQ-4512  ${collectivite_values.acteur}
    ${json_payload} =  Replace String  ${json_payload}  "terrain_references_cadastrales": ""  "terrain_references_cadastrales": "000AB0655"
    ${payload_dict} =  To Json  ${json_payload}
    ${task_values} =  Create Dictionary
    ...  type=create_DI_for_consultation
    ...  json_payload=${json_payload}
    Ajouter la tâche par WS  ${task_values}
    ${msg} =  Déclencher le traitement des tâches par WS
    ${di_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_libelle"]}
    ...  [^ ]{5}$  00003 ${collectivite_values.code_entite}03
    ${da_lib_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation_libelle"]}
    ...  [^ ]{5}$  00003
    ${di_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier"]}
    ...  [^ ]{5}$  00003${collectivite_values.code_entite}03
    ${da_expected} =  Replace String Using Regexp  ${payload_dict["dossier"]["dossier_autorisation"]}
    ...  [^ ]{5}$  00003
    ${di_regex} =  Catenate  .*\\[[0-9]+\\]  ${task_values["type"]}  ${payload_dict["dossier"]["dossier"]}  :
    ...  dossier instruction  '${di_lib_expected}'  .*$
    ${di_matches} =  Get Regexp Matches  ${msg}  ${di_regex}
    ${di_matches_len} =  Get Length  ${di_matches}
    Should Be True  "${di_matches_len}" > "0"
    Depuis le contexte du dossier d'instruction  ${di_lib_expected}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#dossier_libelle  ${di_lib_expected}
    ${di_libelle} =  Set Variable  ${di_lib_expected}

    # vérifier que le dossier n'est pas géolocalisé
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  Aucune géolocalisation

    Désactiver le mode MC/ABF


Récupération des parcelles et de la surface lors du calcul du centroïde d'un dossier manuellement géolocalisé

    Depuis la page d'accueil  admin  admin

    # ajout d'un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Ba
    ...  particulier_prenom=Ba
    ...  om_collectivite=Collectivité-evol-sig
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-evol-sig
    ...  date_demande=08/12/2022
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # géolocalisation du dossier
    Depuis la page d'accueil  lmer  lmer
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Click Element  css=input#verif_parcelle-button
    Wait Until Element Contains  css=div#verif_parcelle-message  Veuillez vérifier que les références cadastrales ont bien été saisies
    Click Element  css=input#calcul_emprise-button
    Wait Until Element Contains  css=div#calcul_emprise-message  L'emprise n'a pas pu être calculée.
    Click Element  css=input#calcul_centroide-button
    Wait Until Element Contains  css=div#calcul_centroide-message  Le centroide a été calculé
    Click Element  css=input#recup_contrainte-button
    Handle Alert
    Wait Until Element Contains  css=div#recup_contrainte-message  Les parcelles n'ont pas été vérifiées ou ont été modifiées

    # vérification que le dossier est bien géolocalisé (présence lien et POINT)
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  POINT(10123 10456)

    # vérification de la présence des parcelles et de la surface
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  000AB0653
    Form Static Value Should Be  css=span#terrain_superficie_calculee  700


Récupération de la surface et pas des parcelles lors du calcul du centroïde d'un dossier automatiquement géolocalisé

    Depuis la page d'accueil  admin  admin

    # ajout d'un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Ba
    ...  particulier_prenom=Ba
    ...  om_collectivite=Collectivité-evol-sig
    @{ref_cad} =  Create List  000  AB  0654
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-evol-sig
    ...  date_demande=09/12/2022
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # géolocalisation du dossier
    Depuis la page d'accueil  lmer  lmer
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Click Element  css=input#verif_parcelle-button
    Wait Until Element Contains  css=div#verif_parcelle-message  Les parcelles existent.
    Click Element  css=input#calcul_emprise-button
    Wait Until Element Contains  css=div#calcul_emprise-message  L'emprise a été calculée.
    Click Element  css=input#calcul_centroide-button
    Wait Until Element Contains  css=div#calcul_centroide-message  Le centroide a été calculé
    Click Element  css=input#recup_contrainte-button
    Handle Alert
    Wait Until Element Contains  css=span#contrainte  2 contrainte(s) ajoutée(s) depuis le SIG

    # vérification que le dossier est bien géolocalisé (présence lien et POINT)
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  POINT(10123 10456)

    # vérification de la présence des parcelles et de la surface
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  000AB0654
    Form Static Value Should Be  css=span#terrain_superficie_calculee  700


Vérification de l'emprise par coordonnées géographiques

    Depuis la page d'accueil  admin  admin

    # ajout d'un dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bu
    ...  particulier_prenom=Bu
    ...  om_collectivite=Collectivité-evol-sig
    @{ref_cad} =  Create List  000  ZZ  0999
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-evol-sig
    ...  terrain_references_cadastrales=${ref_cad}
    ...  date_demande=10/12/2022
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # saisie des coordonnées géographiques
    Depuis la page d'accueil  lmer  lmer
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    &{args_modif} =  Create Dictionary
    ...  geoloc_latitude=43° 17,46 N
    ...  geoloc_longitude=5°22.11E
    ...  geoloc_rayon=100
    Modifier le dossier d'instruction  ${di_libelle}  ${args_modif}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=span#geoloc_latitude  43° 17.46 N
    Form Static Value Should Be  css=span#geoloc_longitude  5° 22.11 E
    Form Static Value Should Be  css=span#geoloc_rayon  100

    # géolocalisation du dossier
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Click Element  css=input#verif_parcelle-button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#verif_parcelle-message  Les parcelles n'existent pas.
    Click Element  css=input#calcul_emprise-button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#calcul_emprise-message  L'emprise a été calculée.
    Click Element  css=input#calcul_centroide-button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#calcul_centroide-message  Le centroide a été calculé
    Click Element  css=input#recup_contrainte-button
    Handle Alert
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=span#contrainte  2 contrainte(s) ajoutée(s) depuis le SIG

    # vérification que le dossier est bien géolocalisé (présence lien et POINT)
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Form Value Should Contain  geom  POINT(10123 10456)

    # vérification de la présence de la surface
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=span#terrain_superficie_calculee  700


    # échec de l'ajout d'un dossier car coordonnées géographiques invalides
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Br
    ...  particulier_prenom=Br
    ...  om_collectivite=Collectivité-evol-sig
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Collectivité-evol-sig
    ...  date_demande=11/12/2022
    ...  geoloc_latitude=4317.46 N
    ...  geoloc_longitude=522.11
    ...  geoloc_rayon=abc
    ${status} =  Run Keyword And Return Status  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Should Be Equal  ${status}  ${FALSE}


Teardown

    Depuis la page d'accueil  admin  admin

    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_sig
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=option_instructeur_division_numero_dossier
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    Remove File  ..${/}dyn${/}sig.inc.php
