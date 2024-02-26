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
    

Colonne de la nature des travaux dans le listing des dossiers d'instruction
    [Documentation]  Colonne qui regroupe diverses description depuis les
    ...  données techniques et qui est tronquée en longueur de texte (40). Le
    ...  texte complet est affiché dans une infobulle (title d'un <span>)

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Olofsson
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr2  instr
    &{args_donnees_techniques} =  Create Dictionary
    ...  co_projet_desc=valeur co_projet_desc
    ...  ope_proj_desc=valeur ope_proj_desc
    ...  am_projet_desc=valeur am_projet_desc
    ...  dm_projet_desc=valeur dm_projet_desc
    ...  erp_cstr_neuve=t
    ...  erp_trvx_acc=t
    ...  erp_extension=t
    ...  erp_rehab=t
    ...  erp_trvx_am=t
    ...  erp_vol_nouv_exist=t
    Saisir les données techniques du DI  ${di}  ${args_donnees_techniques}
    Click On Back Button In Subform

    # Recherche du DI
    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    Input Text  dossier  ${di}
    Click Button  adv-search-submit

    # <br/> devient /n dans RF
    Element Should Contain  css=.tab-data a.lienTable span
    ...  valeur co_projet_desc${\n}valeur ope_proj_de…

    # Multiline string with newlines
    ${expected_tooltip_value}=  catenate  SEPARATOR=\n
    ...  valeur co_projet_desc
    ...  valeur ope_proj_desc
    ...  valeur am_projet_desc
    ...  valeur dm_projet_desc
    ...  Construction neuve
    ...  Travaux de mise en conformité totale aux règles d’accessibilité
    ...  Extension
    ...  Réhabilitation
    ...  Travaux d’aménagement (remplacement de revêtements, rénovation électrique, création d’une rampe, par exemple)
    ...  Création de volumes nouveaux dans des volumes existants (modification du cloisonnement, par exemple)

    ${title} =  Get Element Attribute  css=.tab-data a.lienTable span  title
    Should Be Equal  ${title}  ${expected_tooltip_value}

    ## Deuxième DI pour tester le cas < 40 caractères avec 2 descriptions
    ## et donc un saut de ligne. Permet de test que les <br/> sont ajoutées
    ## dans les deux cas.
    # On réutilise exactement les mêmes données de base mais moins de données
    # techniques
    ${di_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    &{args_donnees_techniques} =  Create Dictionary
    ...  dm_projet_desc=valeur dm_projet_desc
    ...  erp_cstr_neuve=t
    Saisir les données techniques du DI  ${di_2}  ${args_donnees_techniques}
    Click On Back Button In Subform

    # Recherche du DI
    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    Input Text  dossier  ${di_2}
    Click Button  adv-search-submit

    # <br/> devient /n dans RF
    Element Should Contain  css=.tab-data a.lienTable span
    ...  valeur dm_projet_desc${\n}Construction neuve


Finalisation automatique de l'événement d'instruction tacite
    [Documentation]  Ce test case contrôle que les instructions ajoutées de
    ...  manière tacite sont finalisées automatiquement si l'option est activée.

    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  option_final_auto_instr_tacite_retour  false  agglo

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_prenom=Théodore
    ...  particulier_nom=Course
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=02/09/2000
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  ARRÊTÉ DE REFUS  02/09/2000
    #
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json_instruction_finalisation}  200  dossier(s) mis à jour.
    # On vérifie que l'événement d'instruction tacite soit finalisé
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS 2
    Element Should Contain  css=span#date_finalisation_courrier.field_value  ${EMPTY}

    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  option_final_auto_instr_tacite_retour  true  agglo

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_prenom=Harriette
    ...  particulier_nom=Lamarre
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=02/09/2000
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI  ${di}  ARRÊTÉ DE REFUS  02/09/2000
    #
    Vérifier le code retour du web service et vérifier que son message contient  Post  maintenance  ${json_instruction_finalisation}  200  dossier(s) mis à jour.
    # On vérifie que l'événement d'instruction tacite soit finalisé
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS 2
    Element Should Contain  css=span#date_finalisation_courrier.field_value  ${date_ddmmyyyy}


Finalisation automatique de l'événement d'instruction retour (par le suivi des dates)
    [Documentation]  Les événements d'instruction retour ajouter automatiquement
    ...  à la saisie du suivi des dates doivent être finalisés, si l'option est
    ...  activée.

    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  option_final_auto_instr_tacite_retour  false  agglo

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_prenom=Arienne
    ...  particulier_nom=Charlesbois
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instrpoly  instrpoly
    Ajouter une instruction au DI et la finaliser  ${di}  ARRÊTÉ DE REFUS
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS
    # On saisi la date de retour AR depuis le formulaire de l'instruction
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform
    Click On Back Button In Subform
    # On vérifie que l'événement d'instruction retour soit finalisé
    Depuis l'instruction du dossier d'instruction  ${di}  Arrêté de Refus signé
    Element Should Contain  css=span#date_finalisation_courrier.field_value  ${EMPTY}

    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  option_final_auto_instr_tacite_retour  true  agglo

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_prenom=Eustache
    ...  particulier_nom=Laforge
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  instrpoly  instrpoly
    Ajouter une instruction au DI et la finaliser  ${di}  ARRÊTÉ DE REFUS
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS
    # On saisi la date de retour AR depuis le formulaire de l'instruction
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform
    Click On Back Button In Subform
    # On vérifie que l'événement d'instruction retour soit finalisé
    Depuis l'instruction du dossier d'instruction  ${di}  Arrêté de Refus signé
    Element Should Contain  css=span#date_finalisation_courrier.field_value  ${date_ddmmyyyy}


Suppression d'une instruction par un instructeur polyvalent et un instructeur polyvalent commune
    [Documentation]  Le principe est de créer deux instructions et de les
    ...  supprimer avec les deux types de profils concernés

    Depuis la page d'accueil  admin  admin
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Fluet
    ...  particulier_prenom=Matthieu
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI  ${di_1}  Notification de pieces manquante

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Jean
    ...  particulier_prenom=Victor
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=DECLARATION PREALABLE SIMPLE
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI  ${di_2}  Notification de pieces manquante

    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis l'instruction du dossier d'instruction  ${di_1}  Notification de pieces manquante
    Portlet Action Should Be In SubForm  instruction  supprimer
    Click On SubForm Portlet Action  instruction  supprimer
    Supprimer l'instruction  ${di_1}  Notification de pieces manquante

    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    Depuis l'instruction du dossier d'instruction  ${di_2}  Notification de pieces manquante
    Portlet Action Should Be In SubForm  instruction  supprimer
    Click On SubForm Portlet Action  instruction  supprimer
    Supprimer l'instruction  ${di_2}  Notification de pieces manquante

Finalisation automatique de l'instruction
    [Documentation]  L'objet de ce 'Test Case' est de vérifier la finalisation
    ...  automatique d'un événement

    Depuis la page d'accueil  admin  admin
    Ajouter la collectivité depuis le menu  Baskerville  mono
    Ajouter le paramètre depuis le menu  departement  055  Baskerville
    Ajouter le paramètre depuis le menu  commune  678  Baskerville
    Ajouter le paramètre depuis le menu  insee  55678  Baskerville

    # Création d'une lettre type test à associer à l'événement test 1
    &{args_lettretype} =  Create Dictionary
    ...  id=test_finalisation_auto
    ...  libelle=Test
    ...  sql=Aucune REQUÊTE
    ...  titre=&idx, &destinataire, aujourdhui&aujourdhui, datecourrier&datecourrier, &departement
    ...  corps=<p><br pagebreak="true" /></p>&idx, &destinataire, aujourdhui&aujourdhui, datecourrier&datecourrier, &departement
    ...  actif=true
    ...  collectivite=agglo
    #
    Ajouter la lettre-type depuis le menu  &{args_lettretype}

    #Définition de l'état & type de DI depuis lesquels les événements seront disponibles
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial


    # Création de l'événement test 1
    &{args_evenement} =  Create Dictionary
    ...  libelle=Test finalisation automatique avec LT
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=test_finalisation_auto Test
    ...  finaliser_automatiquement=false

    Ajouter l'événement depuis le menu  ${args_evenement}

    # Création de l'événement test 2
    &{args_evenement} =  Create Dictionary
    ...  libelle=Test finalisation automatique sans LT
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  finaliser_automatiquement=true

    Ajouter l'événement depuis le menu  ${args_evenement}

    # Création des demandes
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Roumanov
    ...  particulier_prenom=Anastasia
    ...  om_collectivite=Baskerville
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Baskerville
    ...  date_demande=01/01/2018
    ${di_finalisation_auto_KO} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Potemkine
    ...  particulier_prenom=Vladimir
    ...  om_collectivite=Baskerville
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Baskerville
    ...  date_demande=01/01/2018
    ${di_finalisation_sans_LT} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Polikov
    ...  particulier_prenom=Dimitri
    ...  om_collectivite=Baskerville
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Baskerville
    ...  date_demande=01/01/2018
    ${di_finalisation_auto_OK} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}


    #Test avec finaliser_automatiquement à false on devrait voir s'afficher dans l'onglet
    # 'Instruction' la commande 'Finaliser le document'
    Ajouter une instruction au DI  ${di_finalisation_auto_KO}  Test finalisation automatique avec LT
    Click On Back Button In Subform
    Element Should Contain  css=div#portlet-actions.ui-widget-content.ui-corner-all.ui-state-default span.om-prev-icon.om-icon-16.finalise  Finaliser le document

    #Test avec finaliser_automatiquement à true mais sans Lettre Type on ne devrait voir
    #s'afficher dans l'onglet
    # ni la commande 'Finaliser le document'
    # ni la commande 'Reprendre la rédaction du document'
    Ajouter une instruction au DI  ${di_finalisation_sans_LT}  Test finalisation automatique sans LT
    Should Not Contain  css=div.formEntete.ui-corner-all  css=span.om-prev-icon.om-icon-16.finalise
    Should Not Contain  css=div.formEntete.ui-corner-all  css=span.om-prev-icon.om-icon-16.definalise

    #Evenement avec LT : finaliser automatiquement passe de false à true
    &{args_evenement} =  Create Dictionary
    ...  libelle=Test finalisation automatique avec LT
    ...  finaliser_automatiquement=true

    Modifier l'événement  ${args_evenement}

    #Test avec finaliser_automatiquement à true on devrait voir s'afficher dans l'onglet
    # 'Instruction' la commande 'Finaliser le document'
    Ajouter une instruction au DI  ${di_finalisation_auto_OK}  Test finalisation automatique avec LT
    Element Should Contain  css=div#portlet-actions.ui-widget-content.ui-corner-all.ui-state-default span.om-prev-icon.om-icon-16.definalise  Reprendre la rédaction du document

Marqueur de dépôt électronique et de parcelle temporaire
    [Documentation]  L'objet de ce 'Test Case' est de vérifier le bon fonctionnement
    ...  des indicateurs de dépôt électronique et de présence de parcelle temporaire
    ...  sur un DI.

    Depuis la page d'accueil  admin  admin

    # On ajoute le DI sur lequel la vérification sera effectuée
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Doisneau
    ...  particulier_prenom=Robert
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  depot_electronique=true
    ...  parcelle_temporaire=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On vérifie que le DI nouvellement créé contient bien les indicateurs positifs
    Depuis le contexte du dossier d'instruction  ${di}
    # Depot electronique
    Wait Until Element Is Visible  css=.dossier_petitionnaire
    Element Should Be Visible  css=span.om-icon.om-icon-16.om-icon-fix.depot-electronique-16
    # Parcelle temporaire
    
    Wait Until Element Is Visible  parcelle_temporaire
    ${parcelle_temporaire} =  Get Text  parcelle_temporaire
    Should Not Be Empty  ${parcelle_temporaire}

    # On vérifie que l'indicateur de parcelle temporaire est à Oui
    Should Be Equal  ${parcelle_temporaire}  Oui

Vérification du rechargement de l'onglet DI

    [Documentation]  L'objet de ce 'Test Case' est de vérifier le bon fonctionnement
    ...  du rechargement de l'onglet DI lorsqu'on clique dessus à partir d'un autre
    ...  onglet et que tous les paramètres de recherche sont maintenus.

    # ajoute le DI sur lequel la vérification sera effectuée
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Neige
    ...  particulier_prenom=Jean
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    Depuis la page d'accueil  admin  admin
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di_sans_espace} =  Sans Espace  ${di}

    # recherche sur le dossier
    Depuis la page d'accueil  instr  instr
    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    Input Text  css=input#dossier  ${di_sans_espace}
    Input Text  css=input#particulier  Neige
    Click On Search Button

    # sélectionne le dossier
    Click Element Until No More Element  xpath=//a[normalize-space(text()) = '${di}']

    # vérifie que son état est 'delai de notification envoye'
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=span#etat  delai de notification envoye

    # passe sur l'onglet 'Instruction'
    Click Element Until New Element  css=a#instruction  css=div#sousform-instruction

    # affiche le formulaire d'ajout d'instruction
    Click Element Until No More Element  css=a#action-soustab-instruction-corner-ajouter

    # saisi l'instruction
    Saisir instruction  accepter un dossier sans réserve
    Click On Submit Button In Subform Until Message  Vos modifications ont bien été enregistrées.
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.

    # passe sur l'onglet 'DI'
    Click Element Until New Element  css=a#main  css=div#form-content

    # vérifie que son état est 'dossier accepter'
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=span#etat  dossier accepter

    # clique sur le bouton de retour
    Click Element Until No More Element  css=div.formControls-top a.retour

    # vérifie que le résultat ne contient que le dossier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  xpath=//table[contains(@class, "tab-tab")]/tbody/tr/td[contains(concat(" ", normalize-space(@class), " "), " col-3 ")]/a[normalize-space(text()) = "${di}"]
    Element Should Not Be Visible  xpath=//table[contains(@class, "tab-tab")]/tbody/tr/td[contains(concat(" ", normalize-space(@class), " "), " col-3 ")]/a[normalize-space(text()) != "${di}"]

Affichage des dates sur l'instruction

    [Documentation]  Test l'affichage des dates d'une instruction dans le cas où
    ...  l'option d'affichage de sdates en lecture seule est active et dans le cas
    ...  où il n'y a pas de lettretype associé à l'événement

    # Jeu de données
    Depuis la page d'accueil  admin  admin
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    # Evenement sans lettretype
    &{args} =  Create Dictionary
    ...  libelle=evenement_sans_lettretype
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    Ajouter l'événement depuis le menu  ${args}
    # Evenement avec lettretype
    &{args} =  Create Dictionary
    ...  libelle=evenement_avec_lettretype
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=arrete ARRETE
    Ajouter l'événement depuis le menu  ${args}

    # DI
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Boileau
    ...  particulier_prenom=Aubrette
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'une instruction avec un évenement sans lettretype
    ${instr_sans_lettretype} =  Ajouter une instruction au DI  ${di}  evenement_sans_lettretype
    Page Should Not Contain Element  css=#fieldset-sousform-instruction-dates

    # Ajout d'une instruction avec un évenement avec lettretype
    ${instr_avec_lettretype} =  Ajouter une instruction au DI  ${di}  evenement_avec_lettretype
    Click On Submit Button In Subform
    Page Should Contain Element  css=#fieldset-sousform-instruction-dates

    # Activation de l'option passant la date de l'événement en lecture seule
    &{param_values} =  Create Dictionary
    ...  libelle=option_date_evenement_instruction_lecture_seule
    ...  valeur=true
    ...  om_collectivite=MARSEILLE
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # Accès au formulaire d'ajout d'une instruction et vérification que la date est
    # visible mais non modifiable
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-instruction-corner-ajouter
    Page Should Contain Element  css=div.field-type-datestatic  date_evenement

    # Accès au formulaire de modification d'une instruction et vérification que la date est
    # visible mais non modifiable
    Depuis l'instruction du dossier d'instruction  ${di}  ${instr_avec_lettretype}
    Click On SubForm Portlet Action  instruction  modifier
    Page Should Contain Element  css=div.field-type-datestatic  date_evenement

    #Supprime le paramètre de saisie du nom des dossiers
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_date_evenement_instruction_lecture_seule
    ...  click_value=option_date_evenement_instruction_lecture_seule
    Supprimer le paramètre (surcharge)  ${param_values}


Historisation des rapports d'instruction

    [Documentation]  Vérifie que le tableau de l'historique des rapports d'instruction s'affiche
    ...  et fonctionne correctement. Vérifie également qu'un rapport d'instruction un fois
    ...  finalisé n'est plus ni modifiable, ni supprimable. Pour finir valide l'affichage
    ...  des rapports d'instruction depuis le sous onglet Pièce(s) & Document(s) de l'onglet
    ...  Pièce(s).

    # Commencer par donner les droits aux instructeurs pour visualiser l'historique des rapports
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu  storage  INSTRUCTEUR
    Ajouter le droit depuis le menu  rapport_instruction_supprimer  INSTRUCTEUR

    # Création d'un instructeur et d'un dossier
    Ajouter la collectivité depuis le menu  K7  mono
    Ajouter la direction depuis le menu  K7  K7  null  Chef K7  null  null  K7
    Ajouter la division depuis le menu  SB42  subdivision SB7  null
    ...  Chef K7  null  null  K7

    Ajouter l'utilisateur  Cheney DeGrasse  nospam@openmairie.org  cdegrasse  cdegrasse  INSTRUCTEUR  K7

    Ajouter l'instructeur depuis le menu  Cheney DeGrasse  subdivision SB7  instructeur  Cheney DeGrasse
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Cheney DeGrasse (SB42)
    ...  om_collectivite=K7
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    Ajouter l'affectation depuis le menu  ${args_affectation}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bradamate
    ...  particulier_prenom=Davignon
    ...  om_collectivite=K7
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=K7
    ...  depot_electronique=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Test du rapport d'instruction en tant qu'instructeur
    Depuis la page d'accueil  cdegrasse  cdegrasse
    &{args_ri} =  Create Dictionary
    ...  description_projet_om_html=Description du projet v1
    Ajouter et finaliser le rapport d'instruction  ${di}  ${args_ri}

    # Le tableau d'historique doit être visible et vide
    # Les actions modifier et supprimer ne doivent pas être dans le portlet
    Depuis le contexte du rapport d'instruction  ${di}
    Portlet Action Should Not Be In SubForm  rapport_instruction  supprimer
    Portlet Action Should Not Be In SubForm  rapport_instruction  modifier
    Element Should Contain  css=#sousform-storage-rapport_instruction  Aucun enregistrement.

    # Reprise de l'édition, la première version du rapport doit apparaître dans le tableau
    Click On SubForm Portlet Action  rapport_instruction  definalise
    Wait Until Page Contains  La définalisation du document s'est effectuée avec succès.
    Element Should Contain  css=#sousform-storage-rapport_instruction tbody tr:nth-child(1) td.lastcol  1
    # La nouvelle édition est modifiable et supprimable
    Portlet Action Should Be In SubForm  rapport_instruction  supprimer
    Portlet Action Should Be In SubForm  rapport_instruction  modifier

    # Modification du rapport et finalisation
    &{args_ri} =  Create Dictionary
    ...  description_projet_om_html=Description du projet v2
    Modifier le rapport d'instruction  ${di}  ${args_ri}
    Depuis le contexte du rapport d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  La finalisation du document s'est effectuée avec succès.
    Portlet Action Should Not Be In SubForm  rapport_instruction  supprimer
    Portlet Action Should Not Be In SubForm  rapport_instruction  modifier
    # Seul le premier rapport doit être visible dans le tableau
    Element Should Contain  css=#sousform-storage-rapport_instruction tbody tr:nth-child(1) td.lastcol  1
    Page Should Not Contain Element  css=#sousform-storage-rapport_instruction tbody tr:nth-child(2)

    # Test de la consultation d'un rapport historisé
    Click Element Until New Element
    ...  css=a[id^=action-soustab-storage-left-consulter]
    ...  css=div#sousform-storage div#uid
    Element Should Contain  css=div#sousform-storage div#uid  rapport_instruction_1.pdf
    # Test du lien de retour
    Click Element Until New Element
    ...  css=a[id^=sousform-action-storage-back]
    ...  css=div#sousform-storage div.pagination-nb
    # Test de l'action de téléchargement
    Click Link  css=a[id^=action-soustab-storage-left-telecharger]
    Select Window  NEW
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Description du projet v1

    # Suppression des droits
    Depuis la page d'accueil  admin  admin
    Supprimer le droit depuis le contexte du profil  storage  INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  rapport_instruction_supprimer  INSTRUCTEUR

Sélection des contraintes à conserver
    [Documentation]   Le but de ce test est de vérifier que la sélection des contraintes
    ...  à conserver fonctionner correctement et que les contraintes non sélectionnées
    ...  sont bien supprimées lorsque l'on clique sur le bouton "Conserver les contraintes sélectionnées"

    Depuis la page d'accueil  admin  admin
    # Création d'un nouveau dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Alphonse
    ...  particulier_prenom=Monjeau
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  depot_electronique=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout de 3 contraintes de groupe et sous-groupe différent
    ${id_contrainte1} =  Ajouter la contrainte depuis le menu  Contrainte TNR Conserve 1  PLU  MARSEILLE  TNR Groupe 1  TNR sousgroupe 1  1ère contrainte instr
    ${id_contrainte2} =  Ajouter la contrainte depuis le menu  Contrainte TNR Non Conserve 2  PLU  MARSEILLE  TNR Groupe 1  TNR sousgroupe 2  2ème contrainte instr
    ${id_contrainte3} =  Ajouter la contrainte depuis le menu  Contrainte TNR Non Conserve 3  PLU  MARSEILLE  TNR Groupe 2  TNR sousgroupe 3  3ème contrainte instr

    @{contraintes_a_selectionner} =  Create List  ${id_contrainte_1}  ${id_contrainte_2}  ${id_contrainte3}
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${di}  ${contraintes_a_selectionner}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TNR Conserve 1
    Page Should Contain  TNR Non Conserve 2
    Page Should Contain  TNR Non Conserve 3

    # Utilisation du bouton de suppression des contraintes non sélectionnées

    # Clique sur l'action de sélection et vérification que toutes les contraintes sont cochées
    Select Checkbox  css=#checkbox_select_all_none
    Checkbox Should Be Selected  css=table[id="sousgroupe_tnr sousgroupe 1"] input.checkbox-contrainte_conserve
    Checkbox Should Be Selected  css=table[id="sousgroupe_tnr sousgroupe 2"] input.checkbox-contrainte_conserve
    Checkbox Should Be Selected  css=table[id="sousgroupe_tnr sousgroupe 3"] input.checkbox-contrainte_conserve

    # Utilisation de l'action de conservation des actions après avoir sélectionné toutes les lignes
    Click Element  css=input[name=supprimer_contraintes_non_selectionnees]
    Wait Until Element Contains  css=#sousform-dossier_contrainte #sousform-message  Aucune contrainte supprimée
    La page ne doit pas contenir d'erreur
    Page Should Not Contain Element  css=#sousform-dossier_contrainte #sousform-message .ui-state-error

    # Sélection des lignes à conserver
    Unselect Checkbox  css=#checkbox_select_all_none
    Checkbox Should Not Be Selected  css=table[id="sousgroupe_tnr sousgroupe 1"] input.checkbox-contrainte_conserve
    Checkbox Should Not Be Selected  css=table[id="sousgroupe_tnr sousgroupe 2"] input.checkbox-contrainte_conserve
    Checkbox Should Not Be Selected  css=table[id="sousgroupe_tnr sousgroupe 3"] input.checkbox-contrainte_conserve

    # Vérification de la sélection par groupe
    Select Checkbox  css=#checkbox_select_all_groupe_tnr_groupe_1
    Checkbox Should Be Selected  css=table[id="sousgroupe_tnr sousgroupe 1"] input.checkbox-contrainte_conserve
    Checkbox Should Be Selected  css=table[id="sousgroupe_tnr sousgroupe 2"] input.checkbox-contrainte_conserve
    Checkbox Should Not Be Selected  css=table[id="sousgroupe_tnr sousgroupe 3"] input.checkbox-contrainte_conserve

    Unselect Checkbox  css=table[id="sousgroupe_tnr sousgroupe 2"] .checkbox-contrainte_conserve
    # Utilisation du bouton de suppression des contraintes non sélectionnées
    Click Element  css=input[name=supprimer_contraintes_non_selectionnees]

    # Vérification de la liste des contraintes supprimées dans le message de validation
    Wait Until Element Contains  css=#sousform-dossier_contrainte #sousform-message  Contrainte TNR Non Conserve 2
    Element Should Contain   css=#sousform-dossier_contrainte #sousform-message  Contrainte TNR Non Conserve 3
    Element Should Not Contain   css=#sousform-dossier_contrainte #sousform-message  Contrainte TNR Conserve 1

    # Vérification que les éléments supprimés ne sont plus présent dans le tableau
    Page Should Not Contain Element  css=table[id="sousgroupe_tnr sousgroupe 3"]
    Page Should Not Contain Element  css=table[id="sousgroupe_tnr sousgroupe 2"]
    Page Should Contain Element  css=table[id="sousgroupe_tnr sousgroupe 1"]

    # Vérification que si l'utilisateur n'a pas le droit de supprimer des contraintes
    # les checkbox et les actions ne sont pas visible
    Depuis la page d'accueil  assist  assist
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di}
    Page Should Not Contain Element  css=input[name=supprimer_contraintes_non_selectionnees]
    Page Should Not Contain Element  css=#checkbox_select_all_none
    Page Should Not Contain Element  css=input.checkbox-contrainte_conserve
    Page Should Not Contain Element  css=div#sousform-dossier_contrainte span.delete-16

Finalisation instruction avec signataire obligatoire
    [Documentation]   Le but de ce test est de vérifier que lorsque l'option
    ...  signataire obligatoire est activé pour un événement, si l'instruction
    ...  associé a cet événement n'a pas de signataire alors elle ne peut
    ...  pas être finalisé

    Depuis la page d'accueil  admin  admin

    # Paramétrage de l'événement avec finalisation obligatoire
    &{args_lettretype} =  Create Dictionary
    ...  id=TEST_SIGNATAIRE_OBLIGATOIRE
    ...  libelle=Test
    ...  sql=Aucune REQUÊTE
    ...  titre=&idx, &destinataire, aujourdhui&aujourdhui, datecourrier&datecourrier, &departement
    ...  corps=Ceci est un document
    ...  actif=true
    ...  collectivite=agglo
    Ajouter la lettre-type depuis le menu  &{args_lettretype}

    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    # Évenement avec signataire obligatoire
    &{args_evenement1} =  Create Dictionary
    ...  libelle=TEST_OPTION_SIGNATAIRE_OBLIGATOIRE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=TEST_SIGNATAIRE_OBLIGATOIRE Test
    ...  signataire_obligatoire=true
    Ajouter l'événement depuis le menu  ${args_evenement1}
    # Évenement sans signataire obligatoire
    &{args_evenement1} =  Create Dictionary
    ...  libelle=TEST_OPTION_SIGNATAIRE_OBLIGATOIRE_INACTIVE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=TEST_SIGNATAIRE_OBLIGATOIRE Test
    Ajouter l'événement depuis le menu  ${args_evenement1}

    # Création d'un nouveau dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Neil
    ...  particulier_prenom=Campbell
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  depot_electronique=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'une instruction sans signataire associé
    Ajouter une instruction au DI et la finaliser  ${di}  TEST_OPTION_SIGNATAIRE_OBLIGATOIRE  false  null  null  choisir signataire
    Error Message Should Be  Le document ne peut pas être finalisé car aucun signataire n'a été sélectionné.

    # Modification pour ajouter un signataire -> l'instruction doit être finalisable
    Depuis l'instruction du dossier d'instruction  ${di}  TEST_OPTION_SIGNATAIRE_OBLIGATOIRE
    # TODO : ajouter un keywords de modification d'une instruction et factoriser le code des tests avec
    Click Element Until New Element  css=#action-sousform-instruction-modifier  css=#signataire_arrete
    Select From List By Label  css=#signataire_arrete  Albert Dupont
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    Click On SubForm Portlet Action  instruction  finaliser
    Valid Message Should Be  La finalisation du document s'est effectuée avec succès.

    # Ajout d'une instruction sans signataire obligatoire et sans signataire
    Ajouter une instruction au DI et la finaliser  ${di}  TEST_OPTION_SIGNATAIRE_OBLIGATOIRE_INACTIVE  false  null  null  choisir signataire
    Valid Message Should Be  La finalisation du document s'est effectuée avec succès.

TNR Vérification du bon fonctionnement de l'export du listing

    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    ${link_export_listing}=  Get Element Attribute  css=.tab-export a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link_export_listing}  ${EXECDIR}${/}binary_files${/}
    La page ne doit pas contenir d'erreur

    # Récupération du contenu du fichier pour vérifier les champs affiché.
    # Vérifie que les champs "Id Plat'AU du service consultant" et
    # "libellé du service consultant" ne sont pas présent
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    ${content_file} =  Get File  ${full_path_to_file}
    ${header_csv_file} =  Set Variable  dossier;pétitionnaire;correspondant;"architecte (nom)";"architecte (cabinet)";localisation;nature;"nombre de logements créés";"surface créée";"famille de travaux";"nature de travaux";"description du projet";"date de dépôt";"date de complétude";"date limite";instructeur;division;état;enjeu;collectivité;"dossier plat'au";"consultation plat'au";"pièce(s) plat'au";"autres objets plat'au"
    Should Contain  ${content_file}  ${header_csv_file}

    # Activation du mode service consulté et vérification que les champs "Id Plat'AU du service consultant"
    # et "libellé du service consultant" ne sont pas présent
    Activer le mode service consulté
    Go To Submenu In Menu  instruction  dossier_instruction_recherche
    ${link_export_listing}=  Get Element Attribute  css=.tab-export a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link_export_listing}  ${EXECDIR}${/}binary_files${/}
    La page ne doit pas contenir d'erreur

    # Récupération du contenu du fichier pour vérifier les champs affiché.
    # Vérifie que les champs "Id Plat'AU du service consultant" et
    # "libellé du service consultant" sont présent
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    ${content_file} =  Get File  ${full_path_to_file}
    ${header_csv_file} =  Set Variable  dossier;pétitionnaire;correspondant;"architecte (nom)";"architecte (cabinet)";localisation;nature;"nombre de logements créés";"surface créée";"famille de travaux";"nature de travaux";"description du projet";"date de dépôt";"date de complétude";"date limite";instructeur;division;état;enjeu;collectivité;"dossier plat'au";"consultation plat'au";"pièce(s) plat'au";"autres objets plat'au";"service consultant : identifiant";"service consultant : libellé"
    Should Contain  ${content_file}  ${header_csv_file}

    # Désactivation du mode service consulté
    Désactiver le mode service consulté


Nom de l'utilisateur qui a créé/finalisé l'instruction dans le listing des instructions du dossier

    Depuis la page d'accueil  guichet  guichet

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Tilco
    ...  particulier_prenom=Balu

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial

    ${libelle_di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}

    ${libelle_di_spaceless} =  Sans espace  ${libelle_di}

    Depuis la page d'accueil  instr  instr

    Ajouter une instruction au DI  ${libelle_di}  rejet tacite

    #Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#formulaire table.tab-tab tr.odd td.col-5  guichet (Guichet Unique)
    ${selector}=  Set Variable  //div[@id = 'sousform-instruction']/descendant::table[contains(@class, 'tab-tab')]/descendant::td[contains(@class, 'col-3')]/a[text()[contains(., "delai de notification envoye")]]/ancestor::tr/td[contains(@class, 'col-5')]/a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  xpath=${selector}  guichet (Guichet Unique)
    #Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#formulaire table.tab-tab tr.even td.col-5  instr (Instructeur)
    ${selector}=  Set Variable  //div[@id = 'sousform-instruction']/descendant::table[contains(@class, 'tab-tab')]/descendant::td[contains(@class, 'col-3')]/a[text()[contains(., "dossier rejeter manque de pieces")]]/ancestor::tr/td[contains(@class, 'col-5')]/a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  xpath=${selector}  instr (Instructeur)

    ${libelle_di} =  Set Variable   AT 013055 12 00001P0
    Ajouter une instruction au DI  ${libelle_di}  rejet tacite

    #Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#formulaire table.tab-tab tr.odd td.col-5  ${EMPTY}
    ${selector}=  Set Variable  //div[@id = 'sousform-instruction']/descendant::table[contains(@class, 'tab-tab')]/descendant::td[contains(@class, 'col-3')]/a[text()[contains(., "delai de notification envoye")]]/ancestor::tr/td[contains(@class, 'col-5')]/a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  xpath=${selector}  ${EMPTY}
    #Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#formulaire table.tab-tab tr.odd td.col-5  instr (Instructeur)
    ${selector}=  Set Variable  //div[@id = 'sousform-instruction']/descendant::table[contains(@class, 'tab-tab')]/descendant::td[contains(@class, 'col-3')]/a[text()[contains(., "dossier rejeter manque de pieces")]]/ancestor::tr/td[contains(@class, 'col-5')]/a
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  xpath=${selector}  instr (Instructeur)

    # Supprime l'instruction de rejet tacite car empêche les tests suivants sur
    # le dossier AT 013055 12 00001P0 de fonctionner
    Depuis la page d'accueil  admin  admin
    Supprimer l'instruction  ${libelle_di}  rejet tacite

Modification d'un document généré par une instruction
        [Documentation]  Cette action permet d'ajouter manuellement le document disponible via le 
    ...  lien du portlet "Édition".
    ...  Cette action n'est disponible que si l'instruction est finalisé, si une date d'envoi pour signature
    ...  existe, et que la date de retour signature n'est pas renseignée.

    # Jeu de données
    #
     &{args_petitionnaire_modif_doc} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST_modif
    ...  particulier_prenom=TEST_doc
    ...  om_collectivite=MARSEILLE

    &{args_demande_modif_doc} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    
    # On crée un nouveau dossier d'instruction
    ${di_modif_doc} =  Ajouter la demande par WS  ${args_demande_modif_doc}  ${args_petitionnaire_modif_doc}

    # On entre dans le dossier d'instruction en tant qu'admin afin d'accéder au journal d'instruction
    Depuis la page d'accueil  admin  admin
    Depuis l'onglet instruction du dossier d'instruction  ${di_modif_doc}
    Click On Link  Notification du delai legal maison individuelle

    # On vérifie le contenu PDF de l'édition généré automatiquement par l'instruction
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # On verifie que le document comporte le type de dossier, et le nom et prénom du particulier
    # afin de s'assurer que le PDF est bien le document généré par l'instruction
    PDF Page Number Should Contain  1  Permis de construire pour une maison individuelle et / ou ses annexes
    PDF Page Number Should Contain  1  TEST_modif
    PDF Page Number Should Contain  1  TEST_doc
    # On ferme le PDF
    Close PDF
    Sleep  1

    Depuis l'onglet instruction du dossier d'instruction  ${di_modif_doc}
    Click On Link  Notification du delai legal maison individuelle
    # On accède à la modale de modification du document
    Click On SubForm Portlet Action  instruction  modale_selection_document_signe  modale
    # On remplit le formulaire de modification du document généré par l'instruction
    # Ajout du nouveau document
    Add File  document_signe  testImportManuel.pdf
    # Ajout de la date de retour signature
    ${date_retour_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Input Datepicker  modale_date_retour_signature  ${date_retour_sign}
    Click On Submit Button In Subform
    #On ferme la modale
    Click Element Until No More Element  css=.ui-dialog-titlebar-close
    
    #On vérifie que la date de retour signature s'est bien mise à jour
    Wait Until Element Contains  css=#date_retour_signature  ${date_retour_sign}
    # On vérifie le contenu du PDF 'Édition' pour vérifier qu'il est bien mis à jour avec le nouveau document.
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    PDF Page Number Should Contain  1  TEST IMPORT MANUEL 1
