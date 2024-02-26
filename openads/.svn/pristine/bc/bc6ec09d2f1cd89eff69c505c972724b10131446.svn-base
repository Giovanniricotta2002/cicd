*** Settings ***
Documentation  Test la taxe d'aménagement.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Création d'un dossier d'instruction avant l'activation de la simulation des taxes

    [Documentation]  Permet de vérifier les actions utilisant le paramétrage des
    ...  taxes si aucun paramétrage n'est renseigné et que l'option n'est pas
    ...  activée.

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Tollmache
    ...  particulier_prenom=Fleur
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_not_for_suite} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di_not_for_suite}
    # On vérifie que le fieldset de simulation des taxes n'est pas accessible
    Page Should Not Contain Element  css=#fieldset-form-dossier_instruction-simulation-des-taxes
    # On vérifie que la modification des données techniques ne provoque pas
    # d'erreur
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    Click On Back Button In Subform
    # On vérifie que la modification du dossier d'instruction ne provoque pas
    # d'erreur
    Click On Form Portlet Action  dossier_instruction  modifier
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message affiché à l'utilisateur
    Valid Message Should Be  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur


Création d'un dossier d'instruction après activation de l'option et sans paramétrage des taxes

    [Documentation]  Permet de vérifier les actions utilisant le paramétrage des
    ...  taxes si aucun paramétrage n'est renseigné et que l'option est activée.

    Depuis la page d'accueil  admin  admin
    # On active l'option de simulation des taxes
    &{param_values} =  Create Dictionary
    ...  libelle=option_simulation_taxes
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Laux
    ...  particulier_prenom=Claudette
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_not_for_suite} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di_not_for_suite}
    # On vérifie que le fieldset de simulation des taxes n'est pas accessible
    Page Should Not Contain Element  css=#fieldset-form-dossier_instruction-simulation-des-taxes
    # On vérifie que la modification des données techniques ne provoque pas
    # d'erreur
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    Click On Back Button In Subform
    # On vérifie que la modification du dossier d'instruction ne provoque pas
    # d'erreur
    Click On Form Portlet Action  dossier_instruction  modifier
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message affiché à l'utilisateur
    Valid Message Should Be  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur

    Depuis la page d'accueil  admin  admin
    # On désactive l'option de simulation des taxes
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_simulation_taxes
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}


Création d'un dossier d'instruction après paramétrage des taxes et sans l'option activée

    [Documentation]  Permet de vérifier les actions utilisant le paramétrage des
    ...  taxes si un paramétrage est renseigné et que l'option est desactivée.

    Depuis la page d'accueil  admin  admin
    &{args_taxes} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  val_forf_surf_cstr=705
    ...  val_forf_empl_tente_carav_rml=3000
    ...  val_forf_empl_hll=10000
    ...  val_forf_surf_piscine=200
    ...  val_forf_nb_eolienne=3000
    ...  val_forf_surf_pann_photo=10
    ...  val_forf_nb_parking_ext=2000
    ...  tx_depart=2.00
    ...  tx_comm_secteur_1=1.00
    ...  tx_rap=0.40
    Ajouter le paramétrage des taxes  ${args_taxes}

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Labossière
    ...  particulier_prenom=Arthur
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_not_for_suite} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di_not_for_suite}
    # On vérifie que le fieldset de simulation des taxes n'est pas accessible
    Page Should Not Contain Element  css=#fieldset-form-dossier_instruction-simulation-des-taxes
    # On vérifie que la modification des données techniques ne provoque pas
    # d'erreur
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    Click On Back Button In Subform
    # On vérifie que la modification du dossier d'instruction ne provoque pas
    # d'erreur
    Click On Form Portlet Action  dossier_instruction  modifier
    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message affiché à l'utilisateur
    Valid Message Should Be  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur


Ajout de la demande avec secteur sélectionné automatiquement

    [Documentation]  Ajoute une demande lorsque la taxe d'aménagement est
    ...  paramétrée avec un seul secteur.

    Depuis la page d'accueil  admin  admin
    # On désactive l'option de simulation des taxes
    &{param_values} =  Create Dictionary
    ...  libelle=option_simulation_taxes
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=De Riv
    ...  particulier_prenom=Géralt
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Set Suite Variable  ${di}

    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie le fil d'Ariane
    Page Title Should Be    Instruction > Dossiers D'instruction > ${di} DE RIV GÉRALT
    # On déplie le fieldset de la taxe d'aménagement
    Open Fieldset    dossier_instruction    simulation-des-taxes
    # On vérifie que le secteur 1 est sélectionné
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Contain    css=#tax_secteur    Secteur 1


Modification des données techniques du dossier d'instruction

    [Documentation]  Modifie les données techniques du dossier d'instruction
    ...  pour lancer le calcul automatique des taxes.

    #
    Depuis la page d'accueil  instr  instr
    &{args_dt_taxes} =  Create Dictionary
    ...  tax_surf_tot_cstr=${160}
    ...  tax_su_princ_surf1=${160}
    ...  tax_sup_bass_pisc_cr=${50}
    ...  tax_am_statio_ext_cr=${2}
    ...  tax_terrassement_arch=true
    ...  mtn_exo_ta_part_commu=${100}
    ...  mtn_exo_ta_part_depart=${100}
    ...  mtn_exo_ta_part_reg=${0}
    ...  mtn_exo_rap=${10}
    Modifier les données techniques pour le calcul des impositions  ${di}  ${args_dt_taxes}
    # On clique sur le bouton retour
    Click On Back Button In Subform
    #
    Depuis le contexte du dossier d'instruction  ${di}
    # On déplie le fieldset de la taxe d'aménagement
    Open Fieldset    dossier_instruction    simulation-des-taxes
    # Vérifie les montants
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Contain    css=#tax_secteur    Secteur 1
    Element Should Contain  css=#tax_mtn_part_commu  815
    Element Should Contain  css=#tax_mtn_part_commu_sans_exo  915
    Element Should Contain  css=#tax_mtn_part_depart  1731
    Element Should Contain  css=#tax_mtn_part_depart_sans_exo  1831
    Element Should Contain  css=#tax_mtn_total  2546
    Element Should Contain  css=#tax_mtn_total_sans_exo  2746
    Element Should Contain  css=#tax_mtn_rap  356
    Element Should Contain  css=#tax_mtn_rap_sans_exo  366


Modification du secteur du dossier d'instruction

    [Documentation]  Modifie le secteur du dossier d'instruction pour relancer
    ...  le calcul automatique des taxes.

    Depuis la page d'accueil  admin  admin
    &{args_taxes} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  tx_comm_secteur_2=2.00
    Modifier le paramétrage des taxes  ${args_taxes}
    #
    Depuis la page d'accueil  instr  instr
    &{args_di} =  Create Dictionary
    ...  tax_secteur=Secteur 2
    Modifier le dossier d'instruction  ${di}  ${args_di}
    #
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie que le secteur 2 est sélectionné
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tax_secteur  Secteur 2
     # On déplie le fieldset de la taxe d'aménagement
    Open Fieldset  dossier_instruction  simulation-des-taxes
    # Vérifie les montants
    Element Should Contain  css=#tax_mtn_part_commu  1731
    Element Should Contain  css=#tax_mtn_part_commu_sans_exo  1831
    Element Should Contain  css=#tax_mtn_part_depart  1731
    Element Should Contain  css=#tax_mtn_part_depart_sans_exo  1831
    Element Should Contain  css=#tax_mtn_total  3462
    Element Should Contain  css=#tax_mtn_total_sans_exo  3662
    Element Should Contain  css=#tax_mtn_rap  -10
    Element Should Contain  css=#tax_mtn_rap_sans_exo  0


Vérification du montant liquidé de la part régionale

    [Documentation]  Si la commune se situe en Île-de-France, le dossier
    ...  d'instruction est soumis à une taxe en plus, la part régionale.

    Depuis la page d'accueil  admin  admin
    &{args_taxes} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  tx_reg=0.25
    ...  en_ile_de_france=true
    Modifier le paramétrage des taxes  ${args_taxes}
    #
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Vos modifications ont bien été enregistrées.
    # On clique sur le bouton retour
    Click On Back Button In Subform
    #
    Depuis le contexte du dossier d'instruction  ${di}
    # On déplie le fieldset de la taxe d'aménagement
    Open Fieldset  dossier_instruction  simulation-des-taxes
    # On vérifie que le montant de la taxe régionale existe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#tax_mtn_part_reg  228
    Element Should Contain  css=#tax_mtn_part_reg_sans_exo  228
    # On vérifie le montant total qui doit être modifié
    Element Should Contain  css=#tax_mtn_total  3690
    Element Should Contain  css=#tax_mtn_total_sans_exo  3890


Suppression d'un taux de secteur communal utilisé par un dossier

    [Documentation]  Si on supprime le taux d'un secteur communal utilisé dans
    ...  un dossier d'instruction et qu'on modifie les données techniques pour
    ...  relancer le calcul, les montants doivent être vides car incalculable
    ...  sans le taux cummunal

    Depuis la page d'accueil  admin  admin
    &{args_taxes} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  tx_comm_secteur_2=${EMPTY}
    Modifier le paramétrage des taxes  ${args_taxes}
    #
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Vos modifications ont bien été enregistrées.
    # On clique sur le bouton retour
    Click On Back Button In Subform
    #
    Depuis le contexte du dossier d'instruction  ${di}
    # On déplie le fieldset de la taxe d'aménagement
    Open Fieldset  dossier_instruction  simulation-des-taxes
    # On vérifie que les montants de la TA sont vides car incalculable
    Element Should Contain  css=#tax_mtn_part_commu  ${EMPTY}
    Element Should Contain  css=#tax_mtn_part_commu_sans_exo  ${EMPTY}
    Element Should Contain  css=#tax_mtn_part_depart  ${EMPTY}
    Element Should Contain  css=#tax_mtn_part_depart_sans_exo  ${EMPTY}
    Element Should Contain  css=#tax_mtn_total  ${EMPTY}
    Element Should Contain  css=#tax_mtn_total_sans_exo  ${EMPTY}


Désactivation de la simulation des taxes

    [Documentation]  Si l'option de simulation des taxes est désactivée, on
    ...  vérifie que le fieldset n'est plus accessible et que la modification
    ...  des données techniques ne provoque pas d'erreur

    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_simulation_taxes
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie le fieldset n'est plus accessible
    Page Should Not Contain Element  css=#fieldset-form-dossier_instruction-simulation-des-taxes
    # On vérifie que la modification des données techniques ne provoque pas
    # d'erreur
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    # On valide le formulaire
    Click On Submit Button In Subform
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    Click On Back Button In Subform
