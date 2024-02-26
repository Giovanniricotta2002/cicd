*** Settings ***
Documentation  Test sur les dossiers d'instruction.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Test Cases ***
Suivi de la numérisation des documents
    [Documentation]  Vérification du fonctionnement du suivi de la numérisation
    ...  des documents :
    ...  - l'entrée de menu doit apparaitre seulement si l'option est activée et
    ...  que la permission est acquise
    ...  - le traitement ne doit traiter que les dossiers d'instruction dont le
    ...  type est spécifié et qui est dans l'intervalle de date
    ...  - à chaque changement d'état le suivi du dossier doit être dans un
    ...  listing spécifique
    ...  - attribution d'un suivi de dossier à un bordereau
    ...  - retour de la cellule numérisation sur un bordereau par lot
    ...  - modification des caractéristique d'un suivi de dossier
    ...  - duplication d'un suivi de dossier et retour de la cellule de
    ...  numérisation sur celui-ci (unitairement)
    ...  - vérification du calcul des caractéristiques des différents suivi de
    ...  dossier sur le même dossier d'instruction

    Depuis la page d'accueil  admin  admin

    # Isolation du contexte
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=FREECITY210
    ...  departement=013
    ...  commune=088
    ...  insee=13088
    ...  direction_code=TA
    ...  direction_libelle=Direction de FREECITY210
    ...  direction_chef=Chef
    ...  division_code=TA
    ...  division_libelle=Division TA
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Dixie Monty
    ...  guichet_om_utilisateur_email=dmonty@openads-test.fr
    ...  guichet_om_utilisateur_login=dmonty
    ...  guichet_om_utilisateur_pwd=dmonty
    ...  instr_om_utilisateur_nom=Cecile Boutot
    ...  instr_om_utilisateur_email=cboutot@openads-test.fr
    ...  instr_om_utilisateur_login=cboutot
    ...  instr_om_utilisateur_pwd=cboutot
    Isolation d'un contexte  ${isolation_values}
    Ajouter l'utilisateur depuis le menu  Normand Duval  nduval@openads-test.fr  nduval  nduval  CELLULE SUIVI  ${isolation_values.om_collectivite_libelle}
    Ajouter l'utilisateur depuis le menu  Florence Bourque  fbourque@openads-test.fr  fbourque  fbourque  QUALIFICATEUR  ${isolation_values.om_collectivite_libelle}

    # Vérification de l'affichage du menu
    Page Should Not Contain Menu  numerisation
    Depuis la page d'accueil  cboutot  cboutot
    Page Should Not Contain Menu  numerisation

    Depuis la page d'accueil  admin  admin
    # Ajout des paramètres nécessaires à l'utilisation du suivi de la numérisation
    &{param_values_1} =  Create Dictionary
    ...  libelle=option_suivi_numerisation
    ...  valeur=true
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values_1}
    &{param_values_2} =  Create Dictionary
    ...  libelle=numerisation_type_dossier_autorisation
    ...  valeur='PCI','PCA'
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values_2}
    &{param_values_3} =  Create Dictionary
    ...  libelle=numerisation_intervalle_date
    ...  valeur=300
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values_3}

    # Vérification de l'affichage du menu
    Page Should Contain Menu  numerisation
    # Le profil instructeur n'ayant pas la permission, même l'option activée, il
    # ne devrait pas avoir accès au menu
    Depuis la page d'accueil  cboutot  cboutot
    Page Should Not Contain Menu  numerisation

    # Ajout des dossiers d'instruction
    &{args_petitionnaire_1} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire Corp.
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Paradis
    ...  personne_morale_prenom=Xavier
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di_ok_1} =  Ajouter la demande par WS  ${args_demande_1}  ${args_petitionnaire_1}
    ${di_ok_1} =  Sans espace  ${libelle_di_ok_1}
    #
    &{args_petitionnaire_2} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Rhéaume
    ...  particulier_prenom=Philippine
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di_ok_2} =  Ajouter la demande par WS  ${args_demande_2}  ${args_petitionnaire_2}
    ${di_ok_2} =  Sans espace  ${libelle_di_ok_2}
    #
    &{args_petitionnaire_3} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Cailot
    ...  particulier_prenom=Ophelia
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande_3} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di_ko_1} =  Ajouter la demande par WS  ${args_demande_3}  ${args_petitionnaire_3}
    ${di_ko_1} =  Sans espace  ${libelle_di_ko_1}
    #
    ${date_di_ko_2_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  301 days  result_format=%Y-%m-%d
    ${date_di_ko_2} =  Convert Date  ${date_di_ko_2_db}  result_format=%d/%m/%Y
    &{args_petitionnaire_4} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire Corp.
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Paradis
    ...  personne_morale_prenom=Xavier
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande_4} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_di_ko_2}
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di_ko_2} =  Ajouter la demande par WS  ${args_demande_4}  ${args_petitionnaire_4}
    ${di_ko_2} =  Sans espace  ${libelle_di_ko_2}
    #
    &{list_di_ok} =  Create Dictionary
    ...  ${di_ok_1}
    ...  ${di_ok_2}
    &{list_di_ko} =  Create Dictionary
    ...  ${di_ko_1}
    ...  ${di_ko_2}

    #
    Depuis la page d'accueil  nduval  nduval
    Récupération des dossiers d'instruction pour le suivi de numérisation (mono)  Opération terminée : 2 dossiers importés
    Depuis la page d'accueil  admin  admin
    Récupération des dossiers d'instruction pour le suivi de numérisation (multi)  Opération terminée : 0 dossiers importés  ${isolation_values.om_collectivite_libelle}

    #
    Depuis la page d'accueil  nduval  nduval
    &{args_num_bordereau_1} =  Create Dictionary
    ...  envoi=${date_ddmmyyyy}
    ${num_bordereau} =  Ajouter le bordereau de numérisation  ${args_num_bordereau_1}
    ${libelle_num_bordereau} =  Catenate  SEPARATOR=  BOR_  ${DATE_FORMAT_YYYY-MM-DD}

    Vérification de l'abscence des dossiers d'instruction dans le listing des suivis de dossier  num_dossier_a_attribuer  ${list_di_ko}

    Attribution d'un suivi de dossier sur un bordereau  ${di_ok_1}  ${libelle_num_bordereau}
    Attribution d'un suivi de dossier sur un bordereau  ${di_ok_2}  ${libelle_num_bordereau}

    Vérification du contenu d'un bordereau  ${num_bordereau}  ${list_di_ok}

    Vérification de l'abscence des dossiers d'instruction dans le listing des suivis de dossier  num_dossier_a_attribuer  ${list_di_ok}
    Vérification de la présence des dossiers d'instruction dans le listing des suivis de dossier  num_dossier_a_numeriser  ${list_di_ok}

    Retour de bordereau de la cellule de numérisation avec vérification des dossiers de suivi
    ...  ${libelle_num_bordereau}  ${list_di_ok}  libellé

    Vérification de l'abscence des dossiers d'instruction dans le listing des suivis de dossier  num_dossier_a_numeriser  ${list_di_ok}
    Vérification de la présence des dossiers d'instruction dans le listing des suivis de dossier  num_dossier_traite  ${list_di_ok}

    # Modification des caractéristiques du suivi de dossier
    &{di_ok_1_values} =  Create Dictionary
    ...  total_pages=33
    ...  pa3a4=44
    ...  pa0=55
    Modifier le suivi de dossier  num_dossier_traite  ${di_ok_1}  ${di_ok_1_values}

    @{check_values_1} =  Create List
    ...  ${di_ok_1_values.total_pages}
    ...  ${di_ok_1_values.pa3a4}
    ...  ${di_ok_1_values.pa0}
    ...  ${di_ok_1}
    ...  ${di_ok_2}
    Vérification du contenu d'un bordereau  ${num_bordereau}  ${check_values_1}

    Depuis la page d'accueil  fbourque  fbourque
    Dupliquer le suivi de dossier  ${di_ok_1}
    Attribution d'un suivi de dossier sur un bordereau  ${di_ok_1}  ${libelle_num_bordereau}
    ${date_copy_di_ok_1_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  7 days  result_format=%Y-%m-%d
    ${date_copy_di_ok_1} =  Convert Date  ${date_copy_di_ok_1_db}  result_format=%d/%m/%Y
    &{copy_di_ok_1_values_datenum} =  Create Dictionary
    ...  datenum=${date_copy_di_ok_1}
    Modifier le suivi de dossier  num_dossier_a_numeriser  ${di_ok_1}  ${copy_di_ok_1_values_datenum}
    # Modification des caractéristiques du suivi de dossier
    &{copy_di_ok_1_values} =  Create Dictionary
    ...  total_pages=1
    ...  pa3a4=1
    ...  pa0=1
    Modifier le suivi de dossier  num_dossier_traite  ${date_copy_di_ok_1}  ${copy_di_ok_1_values}  Date de numérisation

    # Vérification de du calcul des caractéristiques dans le bordereau de
    # numérisation
    ${sum_total_pages} =  Evaluate  ${di_ok_1_values.total_pages}+${copy_di_ok_1_values.total_pages}
    ${sum_total_pages_text} =  Convert To String  ${sum_total_pages}
    ${sum_pa3a4} =  Evaluate  ${di_ok_1_values.pa3a4}+${copy_di_ok_1_values.pa3a4}
    ${sum_pa3a4_text} =  Convert To String  ${sum_pa3a4}
    ${sum_pa0} =  Evaluate  ${di_ok_1_values.pa0}+${copy_di_ok_1_values.pa0}
    ${sum_pa0_text} =  Convert To String  ${sum_pa0}
    @{check_values_2} =  Create List
    ...  ${sum_total_pages_text}
    ...  ${sum_pa3a4_text}
    ...  ${sum_pa0_text}
    ...  ${di_ok_1}
    ...  ${di_ok_2}
    Vérification du contenu d'un bordereau  ${num_bordereau}  ${check_values_2}

    # Suppression du paramétrage
    Depuis la page d'accueil  admin  admin
    &{param_args_1} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_suivi_numerisation
    ...  click_value=${isolation_values.om_collectivite_libelle}
    Supprimer le paramètre (surcharge)  ${param_args_1}
    &{param_args_2} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=numerisation_type_dossier_autorisation
    ...  click_value=${isolation_values.om_collectivite_libelle}
    Supprimer le paramètre (surcharge)  ${param_args_2}
    &{param_args_3} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=numerisation_intervalle_date
    ...  click_value=${isolation_values.om_collectivite_libelle}
    Supprimer le paramètre (surcharge)  ${param_args_3}
