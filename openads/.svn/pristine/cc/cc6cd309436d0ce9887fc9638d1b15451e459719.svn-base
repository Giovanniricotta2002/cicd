*** Settings ***
Documentation  Tests concernant l'affectation d'instructeurs aux dossiers via le formulaire de modification du dossier.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Option de limitation de l'affectation des dossiers aux instructeurs de la division de l'utilisateur
    [Documentation]  Après avoir activé l'option option_filtre_instructeur_DI_par_division 
    ...  et depuis la page de modification d'un DI,
    ...  1 - Un instructeur d'une division A depuis la page de modification d'un DI, 
    ...  peut sélectionner uniquement des instructeurs de la division A.
    ...  2 - Un instructeur d'une division rattachée à la collectivité de niveau 2, 
    ...  peut sélectionner les instructeurs de sa division ou des divisions liées aux collectivités de niveau 1.
    ...  3 - Un utilisateur non rattaché à une division,
    ...  peut sélectionner les instructeurs rattachés aux divisions associées à sa collectivité


    # Jeu de données
    # Ajout d'une collectivité LIMITINSTRCITY pour isoler le test.
    # Création de 4 divisions :
    #  - division A : 1 admin general et 1 instructeur. L'admin général permet de vérifier le contenu
    #                 de la liste des instructeurs pour un utilisateur de la div A. L'instructeur est
    #                 ajouté pour vérifier sa présence dans la liste des instructeurs.
    #  - Div B : 1 instructeur. Cet instructeur est ajouté pour vérifier dans le cas 1 que les
    #                 instructeurs des autres divisions ne peuvent pas être sélectionnés.
    #  - division N2 : 1 admin general et 1 instructeur. L'admin général permet de vérifier le contenu
    #                 de la liste des instructeurs pour un utilisateur d'un div liée à la collectivité
    #                 de niveau 2. L'instructeur est ajouté pour vérifier sa présence dans la liste des
    #                 instructeurs.
    #  - division N2bis : 1 instructeur. Cet instructeur est ajouté pour vérifier dans le cas 2 que les
    #                 instructeurs, des autres divisions, rattachées à l'agglo, ne peuvent pas être sélectionnés.
    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIMITINSTRCITY
    ...  departement=013
    ...  commune=198
    ...  insee=13018
    ...  direction_code=LIMITINSTR
    ...  direction_libelle=Dir 051A
    ...  direction_chef=Chef 051A
    ...  division_code=div A
    ...  division_libelle=Division A
    ...  division_chef=Chef A
    ...  guichet_om_utilisateur_nom=Selim Itinstr
    ...  guichet_om_utilisateur_email=sitrinst@openads-test.fr
    ...  guichet_om_utilisateur_login=sitrinst
    ...  guichet_om_utilisateur_pwd=sitrinst
    ...  instr_om_utilisateur_nom=ins DIVIA
    ...  instr_om_utilisateur_email=idivia@openads-test.fr
    ...  instr_om_utilisateur_login=idivia
    ...  instr_om_utilisateur_pwd=idivia
    Isolation d'un contexte  ${isolation_values}

    # On s'assure de ne pas afficher la division de l'instructeur pour ne pas impacter
    # la détection du nom de l'instructeur
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Divisions
    Ajouter la direction depuis le menu  LIMITINSTRCITY  Direction B  null  Chef B  null  null  LIMITINSTRCITY
    Ajouter la division depuis le menu  div B  Div B  null  Chef B  null  null  Direction B

    Ajouter la direction depuis le menu  agglo  Direction N2  null  Chef N2  null  null  agglo
    Ajouter la division depuis le menu  div N2  Division N2  null  Chef N2  null  null  Direction N2

    Ajouter la direction depuis le menu  agglo  Direction N2Bis  null  Chef N2Bis  null  null  agglo
    Ajouter la division depuis le menu  div N2Bis  Division N2Bis  null  Chef N2Bis  null  null  Direction N2Bis


    # Instructeurs
    Ajouter l'utilisateur  admin DIVIA  idivia@openmairie.org  adivia  adivia  ADMINISTRATEUR GENERAL  LIMITINSTRCITY
    Ajouter l'instructeur depuis le menu  admin DIVIA  Division A  instructeur  admin DIVIA

    Ajouter l'utilisateur  ins DIVIB  idivib@openmairie.org  idivib  idivib  INSTRUCTEUR POLYVALENT  LIMITINSTRCITY
    Ajouter l'instructeur depuis le menu  ins DIVIB  Div B  instructeur  ins DIVIB

    Ajouter l'utilisateur  Agglo MERATION  aggloman@openmairie.org  ameration  ameration  ADMINISTRATEUR GENERAL  agglo
    Ajouter l'instructeur depuis le menu  Agglo MERATION  Division N2  instructeur  Agglo MERATION

    Ajouter l'utilisateur  autre agglo  aggloman@openmairie.org  aagglo  aagglo  INSTRUCTEUR POLYVALENT  agglo
    Ajouter l'instructeur depuis le menu  autre agglo  Division N2  instructeur  autre agglo

    Ajouter l'utilisateur  autre divagglo  aggloman@openmairie.org  adivagglo  adivagglo  INSTRUCTEUR POLYVALENT  agglo
    Ajouter l'instructeur depuis le menu  autre divagglo  Division N2Bis  instructeur  autre divagglo

    # utilisateurs sans division permettant de tester le cas 3
    Ajouter l'utilisateur  sans DIV  sansdiv@openmairie.org  sdiv  sdiv  ADMINISTRATEUR GENERAL  LIMITINSTRCITY


    # Activation de l'option filtre_instructeur_DI_par_division
    Depuis la page d'accueil  admin  admin
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_filtre_instructeur_DI_par_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # Création d'un dossier affecté à la collectivité isolée
    Depuis la page d'accueil  adivia  adivia
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=LIMIT
    ...  particulier_prenom=Instr
    ...  om_collectivite=LIMITINSTRCITY
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2022
    ...  om_collectivite=LIMITINSTRCITY
    ${di_div} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    ${list_locator} =  Set Variable  css=select#instructeur
    
    
    # 1 ## Cas : En tant qu'instructeur d'une division A, depuis la page de modification d'un DI, 
    # je peux sélectionner uniquement des instructeurs de la division A.
    Depuis le contexte du dossier d'instruction  ${di_div}
    Click On Form Portlet Action  dossier_instruction  modifier
    Select list should contain value  ${list_locator}  ins DIVIA
    Select list should not contain value  ${list_locator}  ins DIVIB


    # 2 ## Cas : En tant qu'instructeur d'une division rattachée à la collectivité de niveau 2, depuis la page de modification d'un DI, 
    # je peux sélectionner les instructeurs de ma division ou des divisions liées aux collectivités de niveau 1.
    Depuis la page d'accueil  ameration  ameration
    Depuis le contexte du dossier d'instruction  ${di_div}
    Click On Form Portlet Action  dossier_instruction  modifier
    # Les instructeurs des autres divisions de niveau 2 ne sont pas visibles
    Select list should not contain value  ${list_locator}  autre divagglo
    # Les instructeurs de la division de l'utilisateur ou des divisions de niveau 1 peuvent être sélectionnés
    ${list_value_expected} =  Create List  autre agglo  ins DIVIA  ins DIVIB
    Select List Should Contain List  ${list_locator}  ${list_value_expected}


    # # 3 ## Cas : En tant qu'utilisateur non rattaché à une division, depuis la page de modification d'un DI, 
    # # je peux sélectionner les instructeurs rattachés aux divisions associées à ma collectivité.
    Depuis la page d'accueil  sdiv  sdiv
    Depuis le contexte du dossier d'instruction  ${di_div}
    Click On Form Portlet Action  dossier_instruction  modifier
    # Les instructeurs rattachés a ma collectivité être sélectionnés
    Wait Until Page Contains Element  ${list_locator}
    ${list_value_expected} =  Create List  ins DIVIA  ins DIVIB  admin DIVIA
    Select List Should Contain List  ${list_locator}  ${list_value_expected}

    # Rétablis le paramétrage
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
