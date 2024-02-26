*** Settings ***
Documentation  Teste l'import spécifique de fichiers CSV

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Case ***
Ouvre le formulaire de l'import spécifique ADS2007 depuis le menu

    [Documentation]  Ce test case permet de vérifier que le formulaire d'import
    ...  spécifique des dossiers sous le format ADS2007, est accessible depuis
    ...  le menu

    Depuis la page d'accueil    admin    admin
    Go To Submenu In Menu  administration  import_specific
    Click Element  id=action-import-ads2007-importer
    La page ne doit pas contenir d'erreur
    Page Should Not Contain  objet est invalide


Import avec succès de dossiers ADS 2007
    [Documentation]  Ce test case permet de vérifier que l'import ads2007
    ...  fonctionne correctement
    ...  Vérifie également que les dossiers sont correctements affichés
    ...  dans les listings.
    #
    Depuis la page d'accueil    admin    admin
    # Ajout d'une collectivité avec une lettre dans son code insee
    Ajouter la collectivité depuis le menu  COLL_TEST_LETTRE  mono
    &{param_division} =  Create Dictionary
    ...  libelle=insee
    ...  valeur=2B000
    ...  om_collectivite=COLL_TEST_LETTRE
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}
    # On importe les dossiers
    Depuis l'import spécifique    ads2007
    Add File    fic1    import_specific_success_ads2007.csv
    Click On Submit Button In Import CSV
    # On vérifie le résultat
    Résultat de l'import doit contenir  5 ligne(s) dans le fichier dont :
    Résultat de l'import doit contenir  - 1 ligne(s) d'entête
    Résultat de l'import doit contenir  - 4 ligne(s) importée(s)

    Le dossier d'instruction doit exister  PD 044185 07 R0013
    Le dossier d'instruction doit exister  PA 044185 08 R0051
    Le dossier d'instruction doit exister  PA 044185 08 R0051M01

    # Vérifie que les dossiers sont correctements affichés dans les listings
    Go To Submenu In Menu  guichet_unique  autre-dossier
    Wait Until Page Contains Element  css=#adv-search-classic-fields input
    Input Text  css=#adv-search-classic-fields input  PD04418507R0013
    Click Element  adv-search-submit
    Wait Until Element Contains  css=#tab-demande_autre_dossier table.tab-tab  PD 044185 07 R0013

    Wait Until Page Contains Element  css=#adv-search-classic-fields input
    Input Text  css=#adv-search-classic-fields input  PA04418508R0051
    Click Element  adv-search-submit
    Wait Until Element Contains  css=#tab-demande_autre_dossier table.tab-tab  PA 044185 08 R0051

    Wait Until Page Contains Element  css=#adv-search-classic-fields input
    Input Text  css=#adv-search-classic-fields input  PA04418508R0051M01
    Click Element  adv-search-submit
    Wait Until Element Contains  css=#tab-demande_autre_dossier table.tab-tab  PA 044185 08 R0051M01


    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    Input Text  css=div#adv-search-adv-fields input#dossier  PD04418507R0013
    Click On Search Button
    Wait Until Element Contains  css=#tab-dossier_instruction table.tab-tab  PD 044185 07 R0013

    Input Text  css=div#adv-search-adv-fields input#dossier  PA04418508R0051
    Click On Search Button
    Wait Until Element Contains  css=#tab-dossier_instruction table.tab-tab  PA 044185 08 R0051

    Input Text  css=div#adv-search-adv-fields input#dossier  PA04418508R0051M01
    Click On Search Button
    Wait Until Element Contains  css=#tab-dossier_instruction table.tab-tab  PA 044185 08 R0051M01

    # Attention : suite au modif de code une ligne du csv ne fonctionne plus
    # lors de l'import car ce cas n'est plus géré (ligne pour tester un PCI)
    # A la place c'est un PA qui est testé. A voir si elle devra être remise plus tard
    Depuis le contexte du dossier d'autorisation  PA 044185 13 R0077
    Element Should Contain  da_description_projet  TEST IMPORT SPECIFIQUE DI INITIAL
    Element Should Contain  depot_initial  11/03/2013
    Element Should Contain  date_depot_DOC  20/06/2013
    Element Should Contain  date_depot_DAACT  21/06/2013
    Depuis le contexte du dossier d'instruction  PA 044185 13 R0077
    Page Should Contain  COLL_TEST_LETTRE
    # TODO : ajouter  la vérification des adresses des dossiers

    # On désactive le suffixe P0 pour les permit de démolir initiaux puis on
    # réimporte les dossiers afin de vérifier que le PD a bien été mis à jour
    # et qu'un autre sans P0 n'a pas été créé
    Depuis le listing  dossier_instruction_type
    Use Simple Search   type de dossier d'autorisation détaillé  PD (Permis de démolir)
    Click On Link  Initial
    Click On Form Portlet Action  dossier_instruction_type  modifier
    Unselect Checkbox  suffixe
    Click On Submit Button
    # On importe les dossiers
    Depuis l'import spécifique    ads2007
    Add File    fic1    import_specific_modif_ads2007.csv
    Click On Submit Button In Import CSV
    # On vérifie le résultat
    Résultat de l'import doit contenir  3 ligne(s) dans le fichier dont :
    Résultat de l'import doit contenir  - 1 ligne(s) d'entête
    Résultat de l'import doit contenir  - 2 ligne(s) importée(s)

    # On vérifie qu'un nouveau dossier n'a pas été créé
    Le dossier d'instruction ne doit pas exister  PD 044185 07 R0013P0

    # On vérifie que le bon dossier a été mis à jour
    Depuis le contexte du dossier d'instruction    PD 044185 07 R0013
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#date_depot  29/06/2008

    # Vérifie la description du projet, la date de DOC et de DAACT du DA
    # Ils doivent être modifié par le modificatif
    # La date de dépôt initial ne doit pas être modifié
    Le dossier d'instruction doit exister  PA 044185 13 R0077M01
    Depuis le contexte du dossier d'autorisation  PA 044185 13 R0077
    Element Should Contain  da_description_projet  TEST IMPORT SPECIFIQUE DI MODIFICATIF
    Element Should Contain  depot_initial  11/03/2013
    Element Should Contain  date_depot_DOC  26/06/2013
    Element Should Contain  date_depot_DAACT  27/06/2013

    # On remet le sufixe au dossiers initiaux PD
    Depuis le listing  dossier_instruction_type
    Use Simple Search   type de dossier d'autorisation détaillé  PD (Permis de démolir)
    Click On Link  Initial
    Click On Form Portlet Action  dossier_instruction_type  modifier
    Select Checkbox  suffixe
    Click On Submit Button

Rejet lors de l'import de dossiers ADS 2007
    #
    Depuis la page d'accueil    admin    admin
    # On importe l'établissement
    Depuis l'import spécifique    ads2007
    Add File    fic1    import_specific_fail_ads2007.csv
    Click On Submit Button In Import CSV
    # On vérifie le résultat
    Résultat de l'import doit contenir  7 ligne(s) dans le fichier dont :
    Résultat de l'import doit contenir  - 1 ligne(s) d'entête
    Résultat de l'import doit contenir  - 1 ligne(s) importée(s)
    Résultat de l'import doit contenir  - 4 ligne(s) rejetée(s)


Ouvre le formulaire de l'import spécifique bible depuis le menu

    [Documentation]  Ce test case permet de vérifier que le formulaire d'import
    ...  spécifique de bibles, est accessible depuis le menu

    Depuis la page d'accueil    admin    admin
    Go To Submenu In Menu  administration  import_specific
    Click Element  id=action-import-bible-importer
    La page ne doit pas contenir d'erreur
    Page Should Not Contain  objet est invalide


Import spécifique de bibles
    [Documentation]  On vérifie que l'import spécifique de bibles fonctionne

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # isole le contexte du test (création d'une collectivité)
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBREBIBLES1
    ...  departement=013
    ...  commune=099
    ...  insee=13099
    ...  direction_code=Z
    ...  direction_libelle=Direction de LIBREBIBLES1
    ...  direction_chef=Chef
    ...  division_code=Z
    ...  division_libelle=Division Z
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Alice Ecila
    ...  guichet_om_utilisateur_email=alicelecila@openads-test.fr
    ...  guichet_om_utilisateur_login=aecila
    ...  guichet_om_utilisateur_pwd=aecila
    ...  instr_om_utilisateur_nom=Eliot Toile
    ...  instr_om_utilisateur_email=eliottoile@openads-test.fr
    ...  instr_om_utilisateur_login=etoile
    ...  instr_om_utilisateur_pwd=etoile
    Isolation d'un contexte  ${isolation_values}

    # récupération des informations pour construire le fichier d'import
    Depuis le contexte de la collectivité  LIBREBIBLES1
    ${collectivite_id} =  Get Text  css=span#om_collectivite
    Depuis le tableau des types de demandes
    Use Simple Search  type de dossier d'instruction  PCI - Initial
    Click on Link  PCI - Initial
    ${demande_type_id} =  Get Text  css=span#demande_type
    Depuis le contexte de l'événement  accepter un dossier sans réserve
    ${evenement_id} =  Get Text  css=span#evenement

    # produit le fichier d'import à partir du template
    ${import_bible_content} =  Get File  binary_files/import_specific_bible.csv.tpl
    ${import_bible_content} =  Replace String  ${import_bible_content}  evt  ${evenement_id}
    ${import_bible_content} =  Replace String  ${import_bible_content}  demande  ${demande_type_id}
    ${import_bible_content} =  Replace String  ${import_bible_content}  collectivite  ${collectivite_id}
    ${current_date} =  Get Current Date   exclude_millis=True
    ${current_date} =  Replace String  ${current_date}  ${SPACE}  _
    ${current_date} =  Replace String  ${current_date}  :  -
    ${import_bible_file} =  Set Variable  import_bible_ok.${current_date}.csv
    Create File  binary_files/${import_bible_file}  ${import_bible_content}

    # va sur la page d'import spécifique de bibles
    Depuis l'import spécifique   bible

    # téléverse le fichier CSV des bibles à importer
    Add File  fic1  ${import_bible_file}
    Click On Submit Button In Import CSV

    # vérifie que l'opération est un succès
    Résultat de l'import doit contenir  4 ligne(s) dans le fichier dont :
    Résultat de l'import doit contenir  - 1 ligne(s) d'entête
    Résultat de l'import doit contenir  - 2 ligne(s) correcte(s)
    Résultat de l'import doit contenir  - 0 ligne(s) rejetée(s)
    Résultat de l'import doit contenir  - 1 ligne(s) vide(s)

    # ajoute un nouveau dossier (PC)
    &{args_demande_auto} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_petitionnaire_auto} =  Create Dictionary
    ...  particulier_nom=Garnier
    ...  particulier_prenom=Arlette
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${di} =  Ajouter la demande par WS  ${args_demande_auto}  ${args_petitionnaire_auto}

    # ajoute une nouvelle instruction (81 accepter un dossier sans réserve)
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve

    # se rend sur la page de l'instruction
    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve

    # clique sur modifier
    Click On SubForm Portlet Action  instruction  modifier

    # clique sur le bouton "bible" dans un complément
    Ouvrir la bible du complément d'instruction n°  1

    # vérifie que les bibles proposées sont les bonnes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Text Should Be  content0  test1

    # en sélectionne une et valide son application
    Select Checkbox  xpath=//*[text()[contains(.,"test1")]]/ancestor::tr/*/input
    Click Element  css=div.ui-dialog>div#upload-container>div>form>div.formControls input[type="submit"]

    # vérifie que ce contenu correspond à celui de la bible sélectionnée
    HTML Should Contain  complement_om_html  Ceci est le test 1

    # Clique sur la bible automatique du second complément
    Ajout automatique de complément(s) d'instruction

    # Vérifie que la bible automatique fonctionne
    HTML Should Contain  complement2_om_html  Ceci est le test 2


Import spécifique de communes
    [Documentation]  On vérifie que l'import spécifique de communes fonctionne

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # isole le contexte du test (création d'une collectivité)
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM1
    ...  departement=013
    ...  commune=098
    ...  insee=13098
    ...  direction_code=W
    ...  direction_libelle=Direction de LIBRECOM1
    ...  direction_chef=Chef
    ...  division_code=W
    ...  division_libelle=Division W
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Gregory Dumoulin
    ...  guichet_om_utilisateur_email=gregorydumoulin@openads-test.fr
    ...  guichet_om_utilisateur_login=gdumoulin
    ...  guichet_om_utilisateur_pwd=gdumoulin
    ...  instr_om_utilisateur_nom=Madeleine Dubeau
    ...  instr_om_utilisateur_email=madeleinedubeau@openads-test.fr
    ...  instr_om_utilisateur_login=mdubeau
    ...  instr_om_utilisateur_pwd=mdubeau
    Isolation d'un contexte  ${isolation_values}

    # va sur la page d'import spécifique de communes
    Depuis l'import spécifique   commune

    # téléverse le fichier CSV des communes à importer
    ${import_communes_file} =  Set Variable  import_specific_communes_ok.csv
    Add File  fic1  ${import_communes_file}
    Click On Submit Button In Import CSV

    # vérifie que l'opération est un succès
    Résultat de l'import doit contenir  41 ligne(s) dans le fichier dont :
    Résultat de l'import doit contenir  - 1 ligne(s) d'entête
    Résultat de l'import doit contenir  - 39 ligne(s) insérée(s)
    Résultat de l'import doit contenir  - 0 ligne(s) rejetée(s)
    Résultat de l'import doit contenir  - 1 ligne(s) vide(s)

TNR erreur de base de données sur l'import ads2007 si le type du DI n'existe pas
    [Documentation]  On vérifie que l'import ads2007 ne provoque pas d'erreur de base de donnée
    ...  si le type du DI n'existe pas. La ligne doit simplement être rejetée.

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # isole le contexte du test (création d'une collectivité)
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=TNRADS2007
    ...  departement=042
    ...  commune=024
    ...  insee=42024
    ...  direction_code=TNRADS2007
    ...  direction_libelle=Direction de TNRADS2007
    ...  direction_chef=Chef
    ...  division_code=TNRADS2007
    ...  division_libelle=Division TNRADS2007
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Mason Laprise
    ...  guichet_om_utilisateur_email=mlaprise@openads-test.fr
    ...  guichet_om_utilisateur_login=mlaprise
    ...  guichet_om_utilisateur_pwd=mlaprise
    ...  instr_om_utilisateur_nom=Victorine Nadeau
    ...  instr_om_utilisateur_email=vnadeau@openads-test.fr
    ...  instr_om_utilisateur_login=vnadeau
    ...  instr_om_utilisateur_pwd=vnadeau
    Isolation d'un contexte  ${isolation_values}

    # va sur la page d'import spécifique de communes
    Depuis l'import spécifique   ads2007

    # téléverse le fichier CSV des communes à importer
    ${import_communes_file} =  Set Variable  import_specific_tnr_ads2007.csv
    Add File  fic1  ${import_communes_file}
    Click On Submit Button In Import CSV

    # vérifie que l'opération est un succès
    Résultat de l'import doit contenir  3 ligne(s) dans le fichier dont :
    Résultat de l'import doit contenir  - 1 ligne(s) d'entête
    Résultat de l'import doit contenir  - 0 ligne(s) importée(s)
    Résultat de l'import doit contenir  - 1 ligne(s) rejetée(s)
    Résultat de l'import doit contenir  - 1 ligne(s) vide(s)

    La page ne doit pas contenir d'erreur
