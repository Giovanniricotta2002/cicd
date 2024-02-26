*** Settings ***
Documentation  Test les demandeurs

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Keywords ***
Modifier les données du demandeur associé à la demande
    [Documentation]  Modifie les données du demandeur associé à la demande
    [Arguments]  ${nom_container}  ${sousform_suffix}  ${nom}  ${prenom}

    Click Element Until New Element  css=#liste_demandeur #${nom_container} a.edit_demandeur  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=input#particulier_nom
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=input#particulier_prenom
    La page ne doit pas contenir d'erreur
    Textfield Value Should Be  css=input#particulier_nom     ${nom}
    Textfield Value Should Be  css=input#particulier_prenom  ${prenom}
    Input Text  css=input#particulier_nom     ${nom}_mod
    Input Text  css=input#particulier_prenom  ${prenom}_mod
    Click Element Until No More Element  css=div#sousform-${sousform_suffix} .formControls-top input[value="Modifier"]
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=div#sousform-${sousform_suffix} div.message.ui-state-valid  Vos modifications ont bien été enregistrées.
    Click Element Until No More Element  css=div#sousform-${sousform_suffix} .formControls-top a.retour


*** Test Cases ***
TNR Filtre des pétitionnaires fréquents par collectivité dans le listing
    [Documentation]  Ce test case vérifie que lorsqu'on est sur une collectivité mono, la
    ...  liste des pétitionnaires fréquents affiche les pétitionnaires fréquents de la
    ...  commune de l'utilisateur, et ceux créés par une collectivité de niveau 2.
    ...  Un compte Agglo doit voir et accéder à tous les pétitionnaires fréquents.

    # En tant que guichetier collectivité Marseille
    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    # Ajout d'un pétitionnaire fréquent sur Marseille
    &{args_petitionnaire_marseille} =  Create Dictionary
    ...  particulier_nom=Lebrun
    ...  particulier_prenom=Carole

    Go To Submenu  petitionnaire_frequent
    Ajouter le pétitionnaire fréquent depuis le menu pétitionnaire fréquent  ${args_petitionnaire_marseille}

    # On récupère l'identifiant du demandeur
    Depuis le contexte du pétitionnaire fréquent  Lebrun Carole
    ${demandeur_id} =  Get Value    demandeur

    # En tant qu'utilisateur de collectivité de niveau 2
    Depuis la page d'accueil  admin  admin
    Go to Submenu In Menu  guichet_unique  petitionnaire_frequent
    # On doit pas avoir le pétitionnaire fréquent de Marseille
    Page Should Contain  Lebrun Carole
    # On doit pouvoir accéder au pétitionnaire
    Click On Link  Lebrun Carole
    La page ne doit pas contenir d'erreur
    Page Should Contain  Lebrun
    Page Should Contain  Carole
    Page Should Not Contain  Personne Morale
    Click On Back Button

    # Ajout d'un pétitionnaire fréquent sur collectivité Agglo
    &{args_petitionnaire_agglo} =  Create Dictionary
    ...  particulier_nom=Bélanger
    ...  particulier_prenom=Jeannine
    ...  om_collectivite=agglo

    Ajouter le pétitionnaire fréquent depuis le menu pétitionnaire fréquent  ${args_petitionnaire_agglo}

    # En tant qu'instructeur d'Allauch
    Depuis la page d'accueil  instrpolycomm3  instrpolycomm3
    Go to Submenu In Menu  guichet_unique  petitionnaire_frequent
    # On ne doit pas avoir les pétitionnaires fréquents de Marseille
    Page Should Not Contain  Lebrun Carole
    # On doit avoir le pétitionnaire fréquent de l'Agglo
    Page Should Contain  Bélanger Jeannine

    # On vérifie que l'utilisateur d'Allauch ne peut pas accéder au pétitionnaire fréquent
    # de Marseille
    Depuis le tableau des pétitionnaires fréquents
    Page Should Not Contain  Lebrun Carole
    # On vérifie que l'utilisateur d'Allauch ne peut pas accéder au pétitionnaire fréquent
    # de Marseille depuis l'URL
    ${URL} =  Set Variable  ${PROJECT_URL}/${OM_ROUTE_FORM}&obj=petitionnaire_frequent&action=3&idx=${demandeur_id}
    Go To  ${URL}
    # L'URL doit afficher une erreur
    Error Message Should Contain  Droits insuffisants.

    # On vérifie que l'utilisateur d'Allauch peut accéder au pétitionnaire fréquent multi
    Depuis le tableau des pétitionnaires fréquents
    Click On Link  Bélanger Jeannine
    Element Text Should Be  particulier_nom  Bélanger


Création et recherche de pétitionnaires fréquents sur plusieurs collectivités
    [Documentation]  L'objet de ce 'Test Case' est de vérifier que la recherche fonctionne
    ...  en contexte utilisateur avec un profil mono, et que seulement les pétitionnaires
    ...  fréquents de la collectivité de l'utilisateur et de l'agglo sont présents.

    # Ajout d'un pétitionnaire fréquent sur collectivité Agglo
    Depuis la page d'accueil  admin  admin
    &{args_petitionnaire_agglo} =  Create Dictionary
    ...  particulier_nom=L' Gougeon
    ...  particulier_prenom=Élodie
    ...  om_collectivite=agglo

    Go to Submenu In Menu  guichet_unique  petitionnaire_frequent
    Ajouter le pétitionnaire fréquent depuis le menu pétitionnaire fréquent  ${args_petitionnaire_agglo}

    # Ajout d'un pétitionnaire fréquent sur Marseille
    &{args_petitionnaire_marseille} =  Create Dictionary
    ...  particulier_nom=Lavoie
    ...  particulier_prenom=Sophie
    ...  om_collectivite=MARSEILLE

    Go to Submenu In Menu  guichet_unique  petitionnaire_frequent
    Ajouter le pétitionnaire fréquent depuis le menu pétitionnaire fréquent  ${args_petitionnaire_marseille}

    # Ajout de 2 pétitionnaires fréquents avec le même nom sur Allauch
    Depuis la page d'accueil  instrpolycomm3  instrpolycomm3
    &{args_petitionnaire_allauch} =  Create Dictionary
    ...  particulier_nom=Desjardins
    ...  particulier_prenom=Halette
    Go to Submenu In Menu  guichet_unique  petitionnaire_frequent
    Ajouter le pétitionnaire fréquent depuis le menu pétitionnaire fréquent  ${args_petitionnaire_allauch}

    &{args_petitionnaire_allauch} =  Create Dictionary
    ...  particulier_nom=Desjardins
    ...  particulier_prenom=Thomas
    Go to Submenu In Menu  guichet_unique  petitionnaire_frequent
    Ajouter le pétitionnaire fréquent depuis le menu pétitionnaire fréquent  ${args_petitionnaire_allauch}

    ## En tant qu'utilisateur d'Allauch
    ## Recherche du pétitionnaire fréquent sur l'agglo

    Depuis le contexte de nouvelle demande via le tableau de bord
    Select From List By Label  dossier_autorisation_type_detaille  Permis de construire comprenant ou non des démolitions
    ${present}=  Run Keyword And Return Status    Element Should Be Visible   id=demande_type
    Run Keyword If    ${present} == True    Select From List By Label    id=demande_type    Dépôt Initial
    # On clique sur le bouton d'ajout du pétitionnaire principal
    Click Element Until New Element  add_petitionnaire_principal  css=.ui-widget-overlay
    # On saisit le couple nom/prénom
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  particulier_nom  L' Gougeon
    Input Text  particulier_prenom  Élodie
    Click Element  css=.search-frequent-16
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  select-petitionnaire  L' Gougeon Élodie
    Click Element  css=div.dialog-search-frequent-petitionnaire.dialog-search-frequent-petitionnaire div a span

    ## Recherche du pétitionnaire fréquent sur Marseille, qui ne doit pas être trouvé

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  particulier_nom  Lavoie
    Input Text  particulier_prenom  Sophie
    Click Element  css=.search-frequent-16
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Aucune correspondance trouvée.
    Click Element  css=div.dialog-search-frequent-petitionnaire.dialog-search-frequent-petitionnaire div a span

    ## Recherche des pétitionnaires fréquents sur Allauch

    Input Text  particulier_prenom  ${EMPTY}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  particulier_nom  Desjardins
    Click Element  css=.search-frequent-16
    # Les 2 pétitionnaires doivent être trouvés
    ${list} =  Create List  Desjardins Halette  Desjardins Thomas
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select List Should Be  css=#select-petitionnaire  ${list}
    Select From List By Label  css=#select-petitionnaire  Desjardins Halette
    Click Element    css=div.dialog-search-frequent-petitionnaire div.ui-dialog-buttonpane button.ui-button
    # On vérifie que la page ne contient pas d'erreur
    La page ne doit pas contenir d'erreur
    Click On Back Button In Subform
    # On vérifie le fieldset pétionnaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Desjardins Halette


Passage d'un pétitionnaire en non-fréquent
    [Documentation]  L'objet de ce 'Test Case' est de vérifier que l'ajout d'un
    ...  pétitionnaire fréquent par la création de demande fonctionne, et que le passage
    ...  de ce pétitionnaire en non-fréquent ne le supprime pas du dossier lié.

    # Ajout d'un pétitionnaire fréquent en passant par la demande

    &{args_petitionnaire_marseille} =  Create Dictionary
    ...  particulier_nom=Therrien
    ...  particulier_prenom=Oliver
    ...  frequent=true
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_marseille}

    Depuis la page d'accueil  admin  admin
    # Vérification que le demandeur est bien lié au dossier
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Page Title Should Be    Instruction > Dossiers D'instruction > ${di_libelle} THERRIEN OLIVER

    Depuis le tableau des pétitionnaires fréquents
    Use Simple Search  nom  Therrien
    Click Link  Therrien Oliver
    Click On Form Portlet Action  petitionnaire_frequent  non_frequent
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Mise à jour effectuée avec succès
    Click On Back Button
    # Le pétitionnaire ne doit plus apparaître dans la liste des fréquents
    Use Simple Search  nom  Therrien Oliver
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  tab-petitionnaire_frequent  Aucun enregistrement.

    # Vérification que le demandeur est bien lié au dossier après le passage en non-fréquent
    Depuis le contexte du dossier d'instruction  ${di_libelle}
    Page Title Should Be    Instruction > Dossiers D'instruction > ${di_libelle} THERRIEN OLIVER

Lien vers le di dans le message de validation de la demande

    [Documentation]  Vérifie si le lien dans le message de validation est
    ...  fonctionnel.

    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Geralt

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ${libelle_di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}
    # On clique sur le lien vers le DI du message de validation
    Click Link  css=#link_demande_dossier_instruction
    # On vérifie le fil d'Ariane
    Page Title Should Be    Instruction > Dossiers D'instruction > ${libelle_di} DUPONT GERALT


Vérification de la récuperation des pétitionnaires
    [Documentation]  Vérifie si les types de demandes avec le champ contrainte à
    ...  avec_recup utilisent bien les pétitionnaires et qu'ils soient bien
    ...  remplaçables et que les sans_recup sont bien vides.

    Depuis la page d'accueil  admin  admin

    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Amorette
    ...  particulier_prenom=David
    ...  frequent=true
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Racine
    ...  particulier_prenom=Gill
    ...  frequent=true
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire_remplacement} =  Create Dictionary
    ...  particulier_nom=Couturier
    ...  particulier_prenom=Ignace
    ...  frequent=true
    ...  om_collectivite=MARSEILLE
    &{args_correspondant} =  Create Dictionary
    ...  particulier_nom=Belisarda
    ...  particulier_prenom=Aubin
    ...  frequent=true
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  delegataire=${args_correspondant}
    ...  petitionnaire=${args_petitionnaire}

    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    Ajouter une instruction au DI et la finaliser  ${di_libelle}  accepter un dossier sans réserve
    Go To Submenu In Menu  guichet_unique  autre-dossier
    Rechercher et créer une demande sur dossier existant  ${di_libelle}
    Select From List By Label  demande_type  Déclaration attestant l'achèvement et la conformité des travaux

    # Vérification de la contrainte avec_recup
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  liste_demandeur  ${args_petitionnaire_principal.particulier_prenom}
    Element Should Contain  liste_demandeur  ${args_correspondant.particulier_prenom}
    Element Should Contain  liste_demandeur  ${args_petitionnaire.particulier_nom}

    Click Element  css=.petitionnaire .demandeur_del
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  liste_demandeur  ${args_petitionnaire.particulier_prenom}

    Ajouter le demandeur  petitionnaire  ${args_petitionnaire_remplacement}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  liste_demandeur  ${args_petitionnaire_remplacement.particulier_prenom}

    # Vérification de la contrainte sans_recup
    Select From List By Label  demande_type  Demande de transfert
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  add_petitionnaire_principal


TNR de recherche des demandeurs fréquents

    [Documentation]  Vérification de la recherche par prénom des demandeurs
    ...  fréquents (petitionnaire, avocat et bailleur) lors de l'ajout d'une
    ...  demande.
    ...  Ajout de deux demandeurs de chaque type pour contrôler que le retour de
    ...  la recherche soit correct.

    Depuis la page d'accueil  admin  admin

    &{args_petitionnaire_vue} =  Create Dictionary
    ...  particulier_nom=Rouze
    ...  particulier_prenom=Ophelia
    ...  om_collectivite=agglo

    &{args_petitionnaire_masque} =  Create Dictionary
    ...  particulier_nom=Loiselle
    ...  particulier_prenom=Charmaine
    ...  om_collectivite=agglo

    &{args_petitionnaire_di} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Roux
    ...  particulier_prenom=Camus
    ...  om_collectivite=MARSEILLE

    &{args_bailleur_vue} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Tanguay
    ...  particulier_prenom=Pauline
    ...  om_collectivite=MARSEILLE
    ...  frequent=true

    &{args_bailleur_masque} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Sansouci
    ...  particulier_prenom=Georgette
    ...  om_collectivite=MARSEILLE
    ...  frequent=true

    &{args_avocat_vue} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Martel
    ...  particulier_prenom=Amber
    ...  om_collectivite=MARSEILLE
    ...  frequent=true

    &{args_avocat_masque} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Blais
    ...  particulier_prenom=Alaine
    ...  om_collectivite=MARSEILLE
    ...  frequent=true

   # Ajout des pétitionnaires
    Go to Submenu In Menu  guichet_unique  petitionnaire_frequent
    Ajouter le pétitionnaire fréquent depuis le menu pétitionnaire fréquent  ${args_petitionnaire_vue}
    Go to Submenu In Menu  guichet_unique  petitionnaire_frequent
    Ajouter le pétitionnaire fréquent depuis le menu pétitionnaire fréquent  ${args_petitionnaire_masque}

    # Ajout des Bailleurs(obligation de passer par l'ajout d'une demande)
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Fonds de commerce
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    &{args_autres_demandeurs} =  Create Dictionary
    ...  bailleur_principal=${args_bailleur_vue}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_di}  ${args_autres_demandeurs}

    &{args_autres_demandeurs} =  Create Dictionary
    ...  bailleur_principal=${args_bailleur_masque}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_di}  ${args_autres_demandeurs}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  om_collectivite=MARSEILLE
    ...  demande_type=Dépôt Initial
    ${di_re} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_di}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  demande_type=Dépôt Initial REC
    ...  autorisation_contestee=${di_re}
    ...  om_collectivite=MARSEILLE

    &{args_autres_demandeurs} =  Create Dictionary
    ...  avocat_principal=${args_avocat_masque}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    &{args_autres_demandeurs} =  Create Dictionary
    ...  avocat_principal=${args_avocat_vue}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    # TNR de recherche des petitionnaires par prenom
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label  dossier_autorisation_type_detaille  Permis de construire pour une maison individuelle et / ou ses annexes
    Click Element Until New Element  add_petitionnaire_principal  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  css=#sousform-petitionnaire #om_collectivite  MARSEILLE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  particulier_prenom  ${args_petitionnaire_vue.particulier_prenom}
    Click Element  css=.search-frequent-16
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  select-petitionnaire  ${args_petitionnaire_vue.particulier_nom} ${args_petitionnaire_vue.particulier_prenom}
    Element Should Not Contain  select-petitionnaire  ${args_petitionnaire_masque.particulier_nom}
    Click Element  css=div.dialog-search-frequent-petitionnaire.dialog-search-frequent-petitionnaire div a span

    # TNR de recherche des bailleurs par prenom
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label  dossier_autorisation_type_detaille  Fonds de commerce
    Click Element Until New Element  add_bailleur_principal  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  css=#sousform-bailleur #om_collectivite  MARSEILLE
    Input Text  particulier_prenom  ${args_bailleur_vue.particulier_prenom}
    Click Element  css=.search-frequent-16
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  select-bailleur  ${args_bailleur_vue.particulier_nom} ${args_bailleur_vue.particulier_prenom}
    Element Should Not Contain  select-bailleur  ${args_bailleur_masque.particulier_nom}
    Click Element  css=div.dialog-search-frequent-bailleur.dialog-search-frequent-bailleur div a span

    # TNR de recherche des avocats par prenom
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label  dossier_autorisation_type_detaille  Recours contentieux
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    autorisation_contestee    ${di_re}
    Click Button    css=#autorisation_contestee_search_button
    Wait Until Element Is Visible  css=#add_avocat_principal
    Click Element Until New Element  add_avocat_principal  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label  css=#sousform-avocat #om_collectivite  MARSEILLE
    Input Text  particulier_prenom  ${args_avocat_vue.particulier_prenom}
    Click Element  css=.search-frequent-16
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  select-avocat  ${args_avocat_vue.particulier_nom} ${args_avocat_vue.particulier_prenom}
    Element Should Not Contain  select-avocat  ${args_avocat_masque.particulier_nom}


Modification d'un demandeur via demande existante
    [Documentation]  Vérifie la modification d'un demandeur
    ...  à partir d'une demande existante

    # jeu de données commun
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Rouze
    ...  particulier_prenom=Ophelia
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire_autre_1} =  Create Dictionary
    ...  particulier_nom=Loiselle
    ...  particulier_prenom=Charmaine
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire_autre_2} =  Create Dictionary
    ...  particulier_nom=Roux
    ...  particulier_prenom=Camus
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire_autre_3} =  Create Dictionary
    ...  particulier_nom=Tanguay
    ...  particulier_prenom=Pauline
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire_autre_4} =  Create Dictionary
    ...  particulier_nom=Sansouci
    ...  particulier_prenom=Georgette
    ...  om_collectivite=MARSEILLE

    # -- ADS
    # petitionnaire_principal / delegataire / petitionnaire
    Depuis la page d'accueil  instr  instr
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  delegataire=${args_petitionnaire_autre_1}
    ...  petitionnaire=${args_petitionnaire_autre_2}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}  ${args_autres_demandeurs}
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve
    Depuis la page d'accueil  guichetsuivi  guichetsuivi
    Depuis le contexte de demande sur dossier en cours via le menu  ${di}
    Select From List By Label  css=select#demande_type  Demande de modification
    # petitionnaire_principal
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=div#petitionnaire_principal_delegataire
    Modifier les données du demandeur associé à la demande  petitionnaire_principal_delegataire  petitionnaire
    ...  ${args_petitionnaire['particulier_nom']}  ${args_petitionnaire['particulier_prenom']}
    # delegataire
    Modifier les données du demandeur associé à la demande  delegataire  delegataire
    ...  ${args_petitionnaire_autre_1['particulier_nom']}  ${args_petitionnaire_autre_1['particulier_prenom']}
    # petitionnaire
    Modifier les données du demandeur associé à la demande  listePetitionnaires  petitionnaire
    ...  ${args_petitionnaire_autre_2['particulier_nom']}  ${args_petitionnaire_autre_2['particulier_prenom']}

    # les contentieux n'étant pas affichés dans le guichet unique
    # on modifie exceptionnellement leur type DA pour les passer
    # dans le groupe ADS (restauré ensuite)
    Depuis la page d'accueil  admin  admin
    &{args_ctx_type_da} =  Create Dictionary
    ...  groupe=Autorisation ADS
    Modifier le type de dossier d'autorisation  Infraction  ${args_ctx_type_da}
    Modifier le type de dossier d'autorisation  Recours  ${args_ctx_type_da}

    # création de nouveaux types de DI et de types de Demandes
    # en modification pour les contentieux qui n'en n'ont pas (normalement)
    &{args_type_di_in} =  Create Dictionary
    ...  code=M
    ...  libelle=Modificatif
    ...  dossier_autorisation_type_detaille=IN (Infraction)
    ...  suffixe=true
    ...  mouvement_sitadel=MODIFICATIF
    ...  maj_da_localisation=true
    ...  maj_da_lot=true
    ...  maj_da_demandeur=true
    ...  maj_da_etat=true
    ...  maj_da_date_init=true
    ...  maj_da_date_validite=true
    ...  maj_da_date_doc=true
    ...  maj_da_date_daact=true
    ...  maj_da_dt=true
    Ajouter type de dossier d'instruction  ${args_type_di_in}
    &{args_type_di_re} =  Copy Dictionary  ${args_type_di_in}
    Set To Dictionary  ${args_type_di_re}  dossier_autorisation_type_detaille  REC (Recours contentieux)
    Ajouter type de dossier d'instruction  ${args_type_di_re}
    @{args_type_demande_etats} =    Create List  dossier accepter
    &{args_type_demande_in} =  Create Dictionary
    ...  code=DM
    ...  libelle=Demande de modification
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=IN (Infraction)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=${args_type_demande_etats}
    ...  contraintes=Récupération des demandeurs avec modification et ajout
    ...  dossier_instruction_type=IN - Modificatif
    ...  evenement=Notification du délai de droit commun - RE / IN
    Ajouter un nouveau type de demande depuis le menu  ${args_type_demande_in}
    &{args_type_demande_re} =  Copy Dictionary  ${args_type_demande_in}
    Set To Dictionary  ${args_type_demande_re}  dossier_autorisation_type_detaille  REC (Recours contentieux)
    Set To Dictionary  ${args_type_demande_re}  etats_autorises  ${args_type_demande_etats}
    Set To Dictionary  ${args_type_demande_re}  dossier_instruction_type  REC - Modificatif
    Ajouter un nouveau type de demande depuis le menu  ${args_type_demande_re}

    # -- CTX IN
    Depuis la page d'accueil  instr  instr
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_petitionnaire}
    ...  contrevenant=${args_petitionnaire_autre_1}
    ...  plaignant_principal=${args_petitionnaire_autre_2}
    ...  plaignant=${args_petitionnaire_autre_3}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve  menu=infraction
    #Depuis la page d'accueil  guichetsuivi  guichetsuivi (pas visible via ce profil)
    Depuis le contexte de demande sur dossier en cours via le menu  ${di}
    Select From List By Label  css=select#demande_type  Demande de modification
    # contrevenant_principal
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=div#contrevenant_principal
    Modifier les données du demandeur associé à la demande  contrevenant_principal  contrevenant
    ...  ${args_petitionnaire['particulier_nom']}  ${args_petitionnaire['particulier_prenom']}
    # contrevenant
    Modifier les données du demandeur associé à la demande  listeAutresContrevenants  contrevenant
    ...  ${args_petitionnaire_autre_1['particulier_nom']}  ${args_petitionnaire_autre_1['particulier_prenom']}
    # plaignant_principal
    Modifier les données du demandeur associé à la demande  plaignant_principal  plaignant
    ...  ${args_petitionnaire_autre_2['particulier_nom']}  ${args_petitionnaire_autre_2['particulier_prenom']}
    # plaignant
    Modifier les données du demandeur associé à la demande  listeAutresPlaignants  plaignant
    ...  ${args_petitionnaire_autre_3['particulier_nom']}  ${args_petitionnaire_autre_3['particulier_prenom']}

    # -- CTX RE (recours)
    Depuis la page d'accueil  instr  instr
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  demande_type=Dépôt Initial REC
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  requerant_principal=${args_petitionnaire_autre_1}
    ...  requerant=${args_petitionnaire_autre_2}
    ...  avocat_principal=${args_petitionnaire_autre_3}
    ...  avocat=${args_petitionnaire_autre_4}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}  ${args_autres_demandeurs}
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve  menu=recours
    #Depuis la page d'accueil  guichetsuivi  guichetsuivi (pas visible via ce profil)
    Depuis le contexte de demande sur dossier en cours via le menu  ${di}
    Select From List By Label  css=select#demande_type  Demande de modification
    # requerant_principal
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=div#requerant_principal
    Modifier les données du demandeur associé à la demande  requerant_principal  requerant
    ...  ${args_petitionnaire_autre_1['particulier_nom']}  ${args_petitionnaire_autre_1['particulier_prenom']}
    # requerant
    Modifier les données du demandeur associé à la demande  listeAutresRequerants  requerant
    ...  ${args_petitionnaire_autre_2['particulier_nom']}  ${args_petitionnaire_autre_2['particulier_prenom']}
    # avocat_principal
    Modifier les données du demandeur associé à la demande  avocat_principal  avocat
    ...  ${args_petitionnaire_autre_3['particulier_nom']}  ${args_petitionnaire_autre_3['particulier_prenom']}
    # avocat
    Modifier les données du demandeur associé à la demande  listeAutresAvocats  avocat
    ...  ${args_petitionnaire_autre_4['particulier_nom']}  ${args_petitionnaire_autre_4['particulier_prenom']}

    # restauration des type de DA originaux pour les contentieux
    Depuis la page d'accueil  admin  admin
    &{args_ctx_type_da} =  Create Dictionary
    ...  groupe=Contentieux
    Modifier le type de dossier d'autorisation  Infraction  ${args_ctx_type_da}
    Modifier le type de dossier d'autorisation  Recours  ${args_ctx_type_da}

    # création de nouveaux types de DI et de types de Demandes
    # en modification pour les DPC qui n'en n'ont pas (normalement)
    &{args_type_di_fc} =  Copy Dictionary  ${args_type_di_in}
    Set To Dictionary  ${args_type_di_fc}  dossier_autorisation_type_detaille  FC (Fonds de commerce)
    Ajouter type de dossier d'instruction  ${args_type_di_fc}
    &{args_type_demande_fc} =  Create Dictionary
    ...  code=DM
    ...  libelle=Demande de modification
    ...  groupe=Autorisation ADS
    ...  dossier_autorisation_type_detaille=FC (Fonds de commerce)
    ...  demande_nature=Dossier existant
    ...  etats_autorises=${args_type_demande_etats}
    ...  contraintes=Récupération des demandeurs avec modification et ajout
    ...  dossier_instruction_type=FC - Modificatif
    ...  evenement=Notification de delai
    Ajouter un nouveau type de demande depuis le menu  ${args_type_demande_fc}

    # modifie l'évènement d'acceptation de dossier
    # pour ajouter le cas 'FC - Initial'
    # pour pouvoir cloturer un FC
    Depuis le contexte de l'événement  accepter un dossier sans réserve
    Click On Form Portlet Action  evenement  modifier
    @{args_evt_types_di} =  Get Selected List Labels  dossier_instruction_type
    Append To List  ${args_evt_types_di}  FC - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=accepter un dossier sans réserve
    ...  dossier_instruction_type=${args_evt_types_di}
    Saisir l'événement  ${args_evenement}
    Click On Submit Button
    La page ne doit pas contenir d'erreur
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # -- DPC (fond de commerce)
    Depuis la page d'accueil  instr  instr
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Fonds de commerce
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  bailleur_principal=${args_petitionnaire_autre_1}
    ...  bailleur=${args_petitionnaire_autre_2}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve
    #Depuis la page d'accueil  guichetsuivi  guichetsuivi (pas visible via ce profil)
    Depuis le contexte de demande sur dossier en cours via le menu  ${di}
    Wait Until Page Contains Element  css=select#demande_type
    Select From List By Label  css=select#demande_type  Demande de modification
    # bailleur_principal
    Modifier les données du demandeur associé à la demande  bailleur_principal  bailleur
    ...  ${args_petitionnaire_autre_1['particulier_nom']}  ${args_petitionnaire_autre_1['particulier_prenom']}
    # bailleur
    Modifier les données du demandeur associé à la demande  listeAutresBailleurs  bailleur
    ...  ${args_petitionnaire_autre_2['particulier_nom']}  ${args_petitionnaire_autre_2['particulier_prenom']}

TNR de l'affichage des infos des demandeurs dans le formulaire du di
    [Documentation]  Vérifie les informations affichés dans le fieldset demandeur en
    ...  consultation du di.

    Depuis la page d'accueil  instr  instr
    # Affichage de toutes les infos pour un particulier
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=D'Aubigné
    ...  particulier_prenom=Charline
    ...  particulier_civilite=Madame
    ...  om_collectivite=MARSEILLE
    ...  particulier_date_naissance=20/01/1976
    ...  particulier_commune_naissance=MULHOUSE
    ...  particulier_departement_naissance=HAUT-RHIN
    ...  particulier_pays_naissance=FRANCE
    ...  numero=89
    ...  voie=rue des Coudriers
    ...  complement=cplmt
    ...  lieu_dit=Lieu_dit
    ...  localite=MULHOUSE
    ...  code_postal=68100
    ...  bp=1
    ...  cedex=2
    ...  pays=FRANCE
    ...  division_territoriale=div
    ...  telephone_fixe=0447129800
    ...  telephone_mobile=0336018799
    ...  indicatif=+33
    ...  fax=fax
    ...  courriel=cdaubigne@test.test
    ...  notification=t

    # Affichage de toutes les infos pour une personne morale
    &{args_demandeur_autre_1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=denomination
    ...  personne_morale_raison_sociale=raisonSociale
    ...  personne_morale_siret=11111111111111
    ...  personne_morale_categorie_juridique=cat jur
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Bisson
    ...  personne_morale_prenom=Sacripant
    ...  om_collectivite=MARSEILLE
    ...  numero=14
    ...  voie=rue La Boétie
    ...  complement=cplmt 2
    ...  lieu_dit=Lieu_dit 2
    ...  localite=PARIS
    ...  code_postal=75016
    ...  bp=3
    ...  cedex=4
    ...  pays=FRANCE
    ...  division_territoriale=div 2
    ...  telephone_fixe=01.64.94.65.52
    ...  telephone_mobile=04.60.90.60.50
    ...  indicatif=+34
    ...  fax=fax 2
    ...  courriel=sbisson@test.test
    ...  notification=f

    # Affichage sans le lieu de naissance pour un particulier
    &{args_demandeur_autre_2} =  Create Dictionary
    ...  particulier_nom=Collin
    ...  particulier_prenom=Orson
    ...  particulier_civilite=Monsieur
    ...  om_collectivite=MARSEILLE
    ...  particulier_date_naissance=10/11/1970
    ...  numero=89
    ...  voie=cours Jean Jaures
    ...  complement=cplmt 3
    ...  lieu_dit=Lieu_dit 3
    ...  localite=BORDEAUX
    ...  code_postal=33800
    ...  bp=5
    ...  cedex=6
    ...  pays=FRANCE
    ...  division_territoriale=div 3
    ...  telephone_fixe=06.00.31.40.40
    ...  telephone_mobile=05.99.20.39.39
    ...  indicatif=+35
    ...  fax=fax 3
    ...  courriel=ocollin@test.test

    # Affichage sans la date de naissance pour un particulier
    # Le lieu_dit n'est également pas renseigné pour s'assurer qu'il n'y a pas de ligne vide
    # lorsque les infos d'une ligne ne sont pas affichées
    &{args_demandeur_autre_3} =  Create Dictionary
    ...  particulier_nom=Brisebois
    ...  particulier_prenom=Joséphine
    ...  particulier_civilite=Monsieur Madame
    ...  om_collectivite=MARSEILLE
    ...  particulier_commune_naissance=VESOUL
    ...  particulier_departement_naissance=HAUTE-SAÔNE
    ...  particulier_pays_naissance=FRANCE
    ...  numero=46
    ...  voie=Rue Frédéric Chopin
    ...  complement=cplmt 4
    ...  localite=VESOUL
    ...  code_postal=70000
    ...  bp=7
    ...  cedex=8
    ...  telephone_fixe=03.26.74.27.87
    ...  telephone_mobile=06.26.74.27.87
    ...  indicatif=+36
    ...  courriel=jbrisebois@test.test

    &{args_autre_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_demandeur_autre_1}
    ...  delegataire=${args_demandeur_autre_2}
    ...  proprietaire=${args_demandeur_autre_3}
    &{args_di} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS
    ...  ${args_di}
    ...  ${args_petitionnaire_principal}
    ...  ${args_autre_demandeurs}

    # Récupération du texte à valider pour cahque demandeur
    ${content_info_petitionnaire_princ} =  Set Variable  Madame D'Aubigné Charline\n89 rue des Coudriers cplmt\nLieu_dit\n68100 MULHOUSE 1 2\ndiv FRANCE\n0447129800 0336018799\ncdaubigne@test.test (Accepte les couriels)\nNé le 20/01/1976 à MULHOUSE HAUT-RHIN FRANCE
    ${content_info_petitionnaire} =  Set Variable  raisonSociale denomination\n11111111111111 cat jur\nMonsieur Bisson Sacripant\n14 rue La Boétie cplmt 2\nLieu_dit 2\n75016 PARIS 3 4\ndiv 2 FRANCE\n01.64.94.65.52 04.60.90.60.50\nsbisson@test.test
    ${content_info_delegataire} =  Set Variable  Monsieur Collin Orson\n89 cours Jean Jaures cplmt 3\nLieu_dit 3\n33800 BORDEAUX 5 6\ndiv 3 FRANCE\n06.00.31.40.40 05.99.20.39.39\nocollin@test.test\nNé le 10/11/1970
    ${content_info_proprietaire} =  Set Variable  Monsieur Madame Brisebois Joséphine\n46 Rue Frédéric Chopin cplmt 4\n70000 VESOUL 7 8\n03.26.74.27.87 06.26.74.27.87\njbrisebois@test.test\nNé à VESOUL HAUTE-SAÔNE FRANCE

    # Vérification des infos affichées dans le fieldset demandeur
    Depuis le contexte du dossier d'instruction  ${di}
    Open Fieldset  dossier_instruction  demandeur
    Element Text Should Be
    ...  css=.petitionnaire_principal div.synthese_demandeur
    ...  ${content_info_petitionnaire_princ}
    Element Text Should Be
    ...  css=.petitionnaire div.synthese_demandeur
    ...  ${content_info_petitionnaire}
    Element Text Should Be
    ...  css=.delegataire div.synthese_demandeur
    ...  ${content_info_delegataire}
    Element Text Should Be
    ...  css=.proprietaire div.synthese_demandeur
    ...  ${content_info_proprietaire}

