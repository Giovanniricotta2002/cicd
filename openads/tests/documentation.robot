*** Settings ***
Documentation     TestSuite "Documentation" : cette suite permet d'extraire
...    automatiquement les captures à destination de la documentation.
# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown
# A chaque début de Test Case on positionne la taille de la fenêtre
# pour obtenir des captures homogènes
Test Setup    Set Window Size  ${1280}  ${1024}




*** Keywords ***
Capture and crop page screenshot Sleep
    [Documentation]  Ce keyword permet 
    ...    nécessaires aux captures d'écran.
    
    [Arguments]  ${filename}  @{locator}

    Sleep  0.1
    Capture and crop page screenshot  ${filename}  @{locator}


Highlight heading
    [Arguments]  ${locator}

    Update element style  ${locator}  margin-top  0.75em
    Highlight  ${locator}

Capturer le menu et le dashboard des profils
    [Arguments]  ${logins}

    #
    :FOR  ${login}  IN  @{logins}
    #
    \  Depuis la page d'accueil  ${login}  ${login}
    \  Go To Dashboard
    #
    \  Capture and crop page screenshot Sleep  screenshots/profils/a_dashboard_${login}.png
    \  ...  content
    #
    \  Capture and crop page screenshot Sleep  screenshots/profils/a_menu_${login}.png
    \  ...  menu-list


Capturer le menu des profils
    [Arguments]  ${logins}

    #
    :FOR  ${login}  IN  @{logins}
    #
    \  Depuis la page d'accueil  ${login}  ${login}
    \  Capture and crop page screenshot Sleep  screenshots/profils/a_menu_${login}.png
    \  ...  menu-list


Prérequis

    [Documentation]  L'objet de ce 'Test Case' est de respecter les prérequis
    ...    nécessaires aux captures d'écran.

    [Tags]  doc

    # Création des répertoires destinés à recevoir les captures d'écran
    # selon le respect de l'architecture de la documentation
    Create Directory    results/screenshots
    Create Directory    results/screenshots/ergonomie
    Create Directory    results/screenshots/profils

*** Test Cases ***
Constitution d'un jeu de données

    [Documentation]  L'objet de ce 'Test Case' est de constituer un jeu de de
    ...    données cohérent pour les scénarios fonctionnels qui suivent.

    [Tags]  doc

    Depuis la page d'accueil  admin  admin
    &{service} =  Create Dictionary
    ...  abrege=95A
    ...  libelle=Direction de la circulation
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    &{lien_service_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Service consulté interne
    ...  service=Direction de la circulation
    Ajouter lien service/utilisateur  ${lien_service_om_utilisateur}

    # Ajout du paramétrage des taxes pour la colllectivité MARSEILLE
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

    # On affiche les divisions pour les affectations automatiques
    Modifier le paramètre   option_afficher_division  true  agglo

    #
    &{args_petitionnaire_1} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_1} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  date_demande=12/04/2015
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    Depuis la page d'accueil  guichet  guichet
    ${di_1} =  Ajouter la demande par WS  ${args_demande_1}  ${args_petitionnaire_1}
    Set Suite Variable  ${di_1}

    #
    &{args_petitionnaire_2} =  Create Dictionary
    ...  particulier_nom=Boulanger
    ...  particulier_prenom=Denis
    #
    @{ref_cad} =  Create List  001  AA  0007
    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  date_demande=20/05/2016
    ...  terrain_references_cadastrales=${ref_cad}
    #
    &{args_petitionnaire_3} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=The Network Chef Inc.
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Barteaux
    ...  personne_morale_prenom=René
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande_3} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    #
    &{args_petitionnaire_4} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=UrbaBat Inc.
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Dufresne
    ...  personne_morale_prenom=Richard
    ...  om_collectivite=MARSEILLE
    #
    ${date_di_4_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  25 days  result_format=%Y-%m-%d
    ${date_di_4_form} =  Convert Date  ${date_di_4_db}  result_format=%d/%m/%Y
    &{args_demande_4} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=${date_di_4_form}

    Depuis la page d'accueil  guichet  guichet
    ${di_2} =  Ajouter la nouvelle demande depuis le tableau de bord  ${args_demande_2}  ${args_petitionnaire_2}
    Set Suite Variable  ${di_2}

    #
    ${di_3} =  Ajouter la demande par WS  ${args_demande_3}  ${args_petitionnaire_3}
    Set Suite Variable  ${di_3}

    #
    ${di_4} =  Ajouter la demande par WS  ${args_demande_4}  ${args_petitionnaire_4}
    Set Suite Variable  ${di_4}

    #
    Depuis la page d'accueil  instrpoly  instrpoly
    Ajouter une consultation depuis un dossier  ${di_1}  59.01 - Direction de l'Eau et de l'Assainissement
    Ajouter une consultation depuis un dossier  ${di_1}  95A - Direction de la circulation

    # Pour que le dossier soit affiché dans le widget dossiers_evenement_incomplet_majoration
    Ajouter une instruction au DI et la finaliser  ${di_1}  majoration + DPC hors SS  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    ${code_barres} =  Récupérer le code barres de l'instruction  ${di_3}  Notification du delai legal maison individuelle
    Ajouter une instruction au DI  ${di_3}  accepter un dossier sans réserve
    Set Suite Variable  ${code_barres}

    # Connexion en admin pour pouvoir modifier les dates de suivi
    Depuis la page d'accueil  admin  admin

    # Pour que le dossier soit affiché dans le widget dossiers_evenement_incomplet_majoration
    Depuis la page d'accueil  admin  admin
    Ajouter une instruction au DI et la finaliser  ${di_2}  majoration + DPC hors SS  false  ${date_ddmmyyyy}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_envoi_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    ## Changement du filtre en aucun (collectivite) pour avoir les 2 dossiers
    # Depuis la page d'accueil  admin  admin
    Depuis le listing  om_widget
    Click On Link    dossiers_evenement_incomplet_majoration
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments    filtre=aucun
    Click On Submit Button

    &{args_avis_consultation_1} =  Create Dictionary
    ...  avis_consultation=Favorable

    #
    Depuis la page d'accueil  consu  consu

    Rendre l'avis sur la consultation du dossier  ${di_1}  ${args_avis_consultation_1}

    Depuis la page d'accueil  admin  admin

    # On active l'option de notification par message
    Modifier le paramètre  option_notification_piece_numerisee  true

    # On ajoute un document numérisé par DI
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=autres pièces composant le dossier (A0)
    Ajouter une pièce depuis le dossier d'instruction  ${di_1}  ${document_numerise_values}

    # Ajoute des infractions dont la date de réception est dépassée de 10 mois
    # Ces infractions seront affichées dans les widgets 'Alerte parquet' et
    #'Alerte visite'
    Depuis la page d'accueil  assist  assist
    ${date_di_inf_1_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  300 days  result_format=%Y-%m-%d
    ${date_di_inf_1_form} =  Convert Date  ${date_di_inf_1_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Charrette
    ...  particulier_prenom=Ophelia
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Moreau
    ...  particulier_prenom=Marcel
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ...  date_demande=${date_di_inf_1_form}
    ${args_peti} =  Create Dictionary

    ${di_inf_1} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    Set Suite Variable  ${di_inf_1}
    #
    ${date_di_inf_2_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  300 days  result_format=%Y-%m-%d
    ${date_di_inf_2_form} =  Convert Date  ${date_di_inf_2_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Raymond
    ...  particulier_prenom=Bertrand
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Bonsaint
    ...  particulier_prenom=Philippe
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ...  date_demande=${date_di_inf_2_form}
    ${args_peti} =  Create Dictionary
    ${di_inf_2} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    Set Suite Variable  ${di_inf_2}

    # Ajoute des infractions non affectées à des technicien
    # Ces infractions seront affichées dans le widget 'Les infractions non
    # affectées'
    # On supprime l'affectation automatique du technicien sur les infractions
    Depuis la page d'accueil  admin  admin
    Supprimer l'affectation depuis le menu  null  Infraction
    #
    Depuis la page d'accueil  assist  assist
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Lagueux
    ...  particulier_prenom=Anne
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Hachée
    ...  particulier_prenom=Diane
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  om_collectivite=MARSEILLE
    ...  demande_type=Dépôt Initial IN
    ${args_peti} =  Create Dictionary
    ${di_inf_3} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    Set Suite Variable  ${di_inf_3}
    #
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Grandbois
    ...  particulier_prenom=Stéphane
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Patel
    ...  particulier_prenom=Nicolas
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${args_peti} =  Create Dictionary
    ${di_inf_4} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    Set Suite Variable  ${di_inf_4}
    # On ajoute l'affectation automatique du technicien
    Depuis la page d'accueil  admin  admin
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Juriste (H)
    ...  instructeur_2=Technicien (H)
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # Ajoute des recours dont la date de réception est comprise dans le mois
    # courant
    # Ces recours seront affichés dans le widget 'Mes clôtures'
    # On ajoute une autorisation à contester
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Charlebois
    ...  particulier_prenom=Agate
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_conteste} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    #
    Depuis la page d'accueil  assist  assist
    ${date_di_re_1_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  10 days  result_format=%Y-%m-%d
    ${date_di_re_1_form} =  Convert Date  ${date_di_re_1_db}  result_format=%d/%m/%Y
    &{args_requerant} =  Create Dictionary
    ...  particulier_nom=Henrichon
    ...  particulier_prenom=Aurore
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  requerant_principal=${args_requerant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours gracieux
    ...  demande_type=Dépôt Initial REG
    ...  om_collectivite=MARSEILLE
    ...  autorisation_contestee=${di_conteste}
    ${args_peti} =  Create Dictionary
    ${di_re_1} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    Set Suite Variable  ${di_re_1}
    #
    ${date_di_re_2_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  10 days  result_format=%Y-%m-%d
    ${date_di_re_2_form} =  Convert Date  ${date_di_re_2_db}  result_format=%d/%m/%Y
    &{args_requerant} =  Create Dictionary
    ...  particulier_nom=Gagné
    ...  particulier_prenom=Daniel
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  requerant_principal=${args_requerant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours gracieux
    ...  demande_type=Dépôt Initial REG
    ...  autorisation_contestee=${di_conteste}
    ...  om_collectivite=MARSEILLE
    ${args_peti} =  Create Dictionary
    ${di_re_2} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    Set Suite Variable  ${di_re_2}
    # On saisit les dates de clôture des recours
    Depuis la page d'accueil  juriste  juriste
    Ajouter une instruction au DI  ${di_re_1}  Clôture de l'instruction  ${date_di_re_1_form}  recours
    Ajouter une instruction au DI  ${di_re_2}  Clôture de l'instruction  ${date_di_re_2_form}  recours

    # Ajoute des infractions dont la date d'audience est comprise dans le mois
    # courant
    # Ces infractions seront affichées dans le widget 'Les audiences'
    Depuis la page d'accueil  assist  assist
    ${date_di_inf_5_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  10 days  result_format=%Y-%m-%d
    ${date_di_inf_5_form} =  Convert Date  ${date_di_inf_5_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Courtois
    ...  om_collectivite=MARSEILLE
    ...  particulier_prenom=Christine
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Blais
    ...  om_collectivite=MARSEILLE
    ...  particulier_prenom=Eugenia
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction
    ...  date_demande=${DATE_FORMAT_DD/MM/YYYY}
    ${args_peti} =  Create Dictionary
    ${di_inf_5} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    #
    ${date_di_inf_6_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  10 days  result_format=%Y-%m-%d
    ${date_di_inf_6_form} =  Convert Date  ${date_di_inf_6_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Legault
    ...  om_collectivite=MARSEILLE
    ...  particulier_prenom=Liane
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Brisebois
    ...  om_collectivite=MARSEILLE
    ...  particulier_prenom=Manon
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction
    ...  date_demande=${DATE_FORMAT_DD/MM/YYYY}
    ${args_peti} =  Create Dictionary
    ${di_inf_6} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    # On saisit la date d'audience dans les données techniques
    Depuis la page d'accueil  juriste  juriste
    &{donnees_techniques_values} =  Create Dictionary
    ...  ctx_date_audience=${date_di_inf_5_form}
    Saisir les données techniques du dossier infraction  ${di_inf_5}  ${donnees_techniques_values}
    &{donnees_techniques_values} =  Create Dictionary
    ...  ctx_date_audience=${date_di_inf_6_form}
    Saisir les données techniques du dossier infraction  ${di_inf_6}  ${donnees_techniques_values}

    # Ajoute des infractions qui ont un AIT signé
    # Ces infraction seront affichées dans les widgets 'Mes AIT' et 'Les AIT'
    Depuis la page d'accueil  assist  assist
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Courtois
    ...  om_collectivite=MARSEILLE
    ...  particulier_prenom=Christine
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Blais
    ...  om_collectivite=MARSEILLE
    ...  particulier_prenom=Eugenia
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  demande_type=Dépôt Initial IN
    ...  dossier_autorisation_type_detaille=Infraction
    ...  om_collectivite=MARSEILLE
    ${args_peti} =  Create Dictionary
    ${di_inf_7} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    #
    &{args_contrevenant} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  particulier_nom=Talon
    ...  particulier_prenom=Petrie
    &{args_plaignant} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  particulier_nom=Baril
    ...  particulier_prenom=Martin
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ${args_peti} =  Create Dictionary
    ${di_inf_8} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    # On saisit les date d'ait et de retour signature
    Depuis la page d'accueil  juriste  juriste
    Ajouter une instruction au DI et la finaliser  ${di_inf_7}  Arrêté interruptif des travaux  false  null  infraction
    &{args_instruction} =  Create Dictionary
    ...  date_retour_signature=${DATE_FORMAT_DD/MM/YYYY}
    Modifier le suivi des dates  ${di_inf_7}  Arrêté interruptif des travaux  ${args_instruction}  infraction
    Ajouter une instruction au DI et la finaliser  ${di_inf_8}  Arrêté interruptif des travaux  false  null  infraction
    &{args_instruction} =  Create Dictionary
    ...  date_retour_signature=${DATE_FORMAT_DD/MM/YYYY}
    Modifier le suivi des dates  ${di_inf_8}  Arrêté interruptif des travaux  ${args_instruction}  infraction

    # Ajoute des infractions dont la date de contradictoire est supérieure ou
    # égale à la date du jour + 3 semaines, sans date de retour de
    # contradictoire, sans événements de type 'Annlation de contradictoire' et
    # sans AIT
    # Ces infraction seront affichées dans les widgets 'Mes contradictoires' et
    # 'Les contradictoires'
    Depuis la page d'accueil  assist  assist
    ${date_di_inf_9_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  28 days  result_format=%Y-%m-%d
    ${date_di_inf_9_form} =  Convert Date  ${date_di_inf_9_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  particulier_nom=Archambault
    ...  particulier_prenom=Corette
    &{args_plaignant} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  particulier_nom=Cantin
    ...  particulier_prenom=Joanna
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  date_demande=${DATE_FORMAT_DD/MM/YYYY}
    ${args_peti} =  Create Dictionary
    ${di_inf_9} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    #
    ${date_di_inf_10_db} =  Add Time To Date  ${DATE_FORMAT_YYYY-MM-DD}  28 days  result_format=%Y-%m-%d
    ${date_di_inf_10_form} =  Convert Date  ${date_di_inf_10_db}  result_format=%d/%m/%Y
    &{args_contrevenant} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  particulier_nom=Archambault
    ...  particulier_prenom=Corette
    &{args_plaignant} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  particulier_nom=Cantin
    ...  particulier_prenom=Joanna
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  date_demande=${DATE_FORMAT_DD/MM/YYYY}
    ${args_peti} =  Create Dictionary
    ${di_inf_10} =  Ajouter la demande par WS  ${args_demande}  ${args_peti}  ${args_autres_demandeurs}
    # On saisit une date de contradictoire
    Depuis la page d'accueil  juriste  juriste
    Ajouter une instruction au DI  ${di_inf_9}  Date contradictoire  ${date_di_inf_9_form}  infraction
    Ajouter une instruction au DI  ${di_inf_10}  Date contradictoire  ${date_di_inf_10_form}  infraction

    # Renseigne les données nécessaires au calcul des taxes
    Depuis la page d'accueil  instr  instr
    &{args_dt_taxes} =  Create Dictionary
    ...  tax_surf_tot_cstr=160
    ...  tax_su_princ_surf1=160
    ...  tax_sup_bass_pisc_cr=50
    ...  tax_am_statio_ext_cr=2
    ...  tax_surf_loc_arch=0.5
    ...  tax_surf_pisc_arch=2
    ...  mtn_exo_ta_part_commu=0
    ...  mtn_exo_ta_part_depart=0
    ...  mtn_exo_ta_part_reg=0
    ...  mtn_exo_rap=0
    Modifier les données techniques pour le calcul des impositions  ${di_1}  ${args_dt_taxes}

    # On ajoute un service qui sera lié à l'utilisateur ayant le profil de
    # service consulté interne
    Depuis la page d'accueil  admin  admin
    &{service} =  Create Dictionary
    ...  abrege=95A
    ...  libelle=Direction de la circulation
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    &{lien_service_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Service consulté étendu
    ...  service=Direction de la circulation
    Ajouter lien service/utilisateur  ${lien_service_om_utilisateur}

    # On ajoute un service qui sera lié à l'utilisateur ayant le profil de
    # service consulté étendu
    &{service} =  Create Dictionary
    ...  abrege=96B
    ...  libelle=Direction de la circulation piétonne
    ...  edition=Consultation - Demande d'avis
    ...  om_collectivite=MARSEILLE
    ...  service_type=openADS
    ...  generate_edition=true
    Ajouter le service depuis le listing  ${service}
    &{lien_service_om_utilisateur} =  Create Dictionary
    ...  om_utilisateur=Service consulté étendu
    ...  service=Direction de la circulation piétonne
    Ajouter lien service/utilisateur  ${lien_service_om_utilisateur}

    # Paramétrage d'une contrainte avec un évènement suggéré
    ${lib_ss_groupe} =  Set Variable  Sous Groupe TST
    &{argts} =  Create Dictionary
    ...  libelle=${lib_ss_groupe}
    Ajouter le sous-groupe de référence  ${argts}

    ${lib_groupe} =  Set Variable  Groupe TST
    &{argts} =  Create Dictionary
    ...  libelle=${lib_groupe}
    Ajouter le groupe de référence  ${argts}

    ${lib_couche} =  Set Variable  Couche TST
    &{argts} =  Create Dictionary
    ...  libelle=${lib_couche}
    ...  id_couche=1
    Ajouter la couche  ${argts}

    @{collectivité} =  Create List  agglo
    @{DI_type} =  Create List  PCI - P - Initial
    ${contrainte_avec_suggestion} =  Set Variable  Contrainte de test
    &{argt_contrainte} =  Create Dictionary
    ...  nature=TST
    ...  groupe=${lib_groupe}
    ...  sousgroupe=${lib_ss_groupe}
    ...  sig_couche=${lib_couche} (1)
    ...  libelle=${contrainte_avec_suggestion}
    ...  dossier_instruction_type=${DI_type}
    ...  om_collectivite=${collectivité}
    Ajouter la contrainte de référence  ${argt_contrainte}
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_avec_suggestion}  affichage_obligatoire

    ${id_contrainte_avec_suggestion} =  Ajouter la contrainte depuis le menu  ${contrainte_avec_suggestion}  PLU  agglo  TST  Suggere  contrainte avec suggestion
    Set Suite Variable  ${id_contrainte_avec_suggestion}

***
CE liés aux consultations entrantes

    [Documentation]  L'objet de ce 'Test Case' est de réaliser les captures
    ...  d'écran liés aux consultations entrantes.

    [Tags]  doc

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_division} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_division}

    # activer la saisie complète des numéros
    &{param_saisie_complete} =  Create Dictionary
    ...  libelle=option_dossier_saisie_numero_complet
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_multi_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WS_AFF_DI
    ...  departement=016
    ...  commune=099
    ...  insee=16099
    ...  direction_code=V
    ...  direction_libelle=Direction de LIBRECOM_WS_AFF_DI
    ...  direction_chef=Chef
    ...  division_code=V
    ...  division_libelle=Division V
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Merci Collin
    ...  guichet_om_utilisateur_email=mcollin@openads-test.fr
    ...  guichet_om_utilisateur_login=mcollin
    ...  guichet_om_utilisateur_pwd=mcollin
    ...  instr_om_utilisateur_nom=Carolos Beauchemin
    ...  instr_om_utilisateur_email=cbeauchemin@openads-test.fr
    ...  instr_om_utilisateur_login=cbeauchemin
    ...  instr_om_utilisateur_pwd=cbeauchemin
    ...  code_entite=LBCOM_20
    ...  acteur=LIBRECOM-ACT-020
    Isolation d'un contexte  ${librecom_multi_values}

    # ajouter le paramètre 'acteur' à la collectivité/au service
    Ajouter le paramètre depuis le menu  platau_acteur_service_consulte
    ...  ${librecom_multi_values["acteur"]}  ${librecom_multi_values["om_collectivite_libelle"]}

    # Change le type affichage du type de DA
    &{args_da_type} =  Create Dictionary
    ...  affichage_form=CONSULTATION ENTRANTE
    Modifier le type de dossier d'autorisation  Permis de construire  ${args_da_type}

    # Affichage de la consultation entrante avec 
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=LIBRECOM_WS_AFF_DI
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300AdresseLocalite
    ...  depot_electronique=true
    ...  source_depot=platau
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOM03
    ...  particulier_prenom=TEST300TASKPRENOM03
    ...  localite=TEST300Localite
    ...  om_collectivite=LIBRECOM_WS_AFF_DI
    ${di_case_1} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    Depuis le contexte du dossier d'instruction  ${di_case_1}
    Open All Fieldset Using Javascript  dossier_instruction
    Capture and crop page screenshot Sleep  screenshots/a_synthese_consultation_entrante.png
    ...  content

    # Remet les paramètres par défaut
    &{args_da_type} =  Create Dictionary
    ...  affichage_form=ADS
    Modifier le type de dossier d'autorisation  Permis de construire  ${args_da_type}
    Ajouter ou modifier le paramètre depuis le menu  ${param_saisie_complete}
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_afficher_division
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_dossier_saisie_numero_complet
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}


CE des menus, widgets et tableaux de bord

    [Documentation]  L'objet de ce 'Test Case' est de réaliser les captures
    ...  d'écran des menus, widgets et tableaux de bord à destination de la
    ...  documentation.

    [Tags]  doc

    Depuis la page d'accueil  admin  admin

    #
    # LISTINGS
    #

    # Création d'un dossier demat
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  depot_electronique=true
    ...  source_depot=platau
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Sirois
    ...  particulier_prenom=Eugenia
    ...  om_collectivite=MARSEILLE
    ${di_demat} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire}
    # Icône "consulter" demat
    Depuis le listing  dossier_instruction
    ${di_demat_sans_espace} =  Sans espace  ${di_demat}
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di_demat_sans_espace}
    Click On Search Button
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_listing_di_consulter_demat.png
    ...    css=table.tab-tab tr.consult-demat td.icons span.consult-16

    # Création d'un dossier papier
    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  depot_electronique=true
    ...  source_depot=app
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Francoeur
    ...  particulier_prenom=Victor
    ...  om_collectivite=MARSEILLE
    ${di_app} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire}
    # Icône "consulter" par défaut
    Depuis le listing  dossier_instruction
    ${di_app_sans_espace} =  Sans espace  ${di_app}
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di_app_sans_espace}
    Click On Search Button
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_listing_di_consulter_app.png
    ...    table.tab-tab tr td.icons span.consult-16

    #
    # WIDGETS
    #

    # Widget de controle de données
    Depuis le contexte du widget  controle_donnee
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments
    ...  filtre=aucun
    Click On Submit Button

    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  ADMINISTRATEUR FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  Dossiers non transmis à Plat'AU
    Click On Submit Button

    Depuis la page d'accueil    adminfonct    adminfonct
    Go To Dashboard
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_nouvelle_demande_dossier_encours.png
    ...    div.widget_nouvelle_demande_dossier_encours
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_controle_donnee.png
    ...    div.widget_controle_donnee

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_WIDGET_RECHERCHE
    ...  departement=045
    ...  commune=188
    ...  insee=45188
    ...  direction_code=GA
    ...  direction_libelle=Direction de LIBRECOM_WIDGET_RECHERCHE
    ...  direction_chef=Chef
    ...  division_code=GA
    ...  division_libelle=Division GA
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Yhalil Gibr
    ...  guichet_om_utilisateur_email=ygibr@openads-test.fr
    ...  guichet_om_utilisateur_login=ygibr
    ...  guichet_om_utilisateur_pwd=ygibr
    ...  instr_om_utilisateur_nom=Yomir Tamb
    ...  instr_om_utilisateur_email=ytamb@openads-test.fr
    ...  instr_om_utilisateur_login=ytamb
    ...  instr_om_utilisateur_pwd=ytamb
    ...  code_entite=LBCOM_25
    ...  acteur=LIBRECOM-ACT-25
    Isolation d'un contexte  ${librecom_values}

    &{args_om_widget} =  Create Dictionary
    ...  libelle=Recherche paramétrable
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=recherche_parametrable
    ...  arguments=etat=notifier\naffichage=nombre\ntri=-6
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=Recherche paramétrable
    ...  om_profil=INSTRUCTEUR
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_WIDGET_RECHERCHE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Rivière
    ...  particulier_prenom=Coralie
    ...  om_collectivite=LIBRECOM_WIDGET_RECHERCHE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil    ytamb  ytamb
    Go To Dashboard

    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_recherche_parametrable.png
    ...    div.widget_recherche_parametrable

    #
    Depuis la page d'accueil    assist    assist
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_recherche_dossier_par_type.png
    ...    div.widget_recherche_dossier_par_type
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_inaffectes.png
    ...    div.widget_dossier_contentieux_inaffectes
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_ait.png
    ...    div.widget_dossier_contentieux_ait
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_contradictoire.png
    ...    div.widget_dossier_contentieux_contradictoire

    #
    Depuis la page d'accueil    guichet    guichet
    Go To Dashboard
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_nouvelle_demande_nouveau_dossier.png
    ...    div.widget_nouvelle_demande_nouveau_dossier
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_nouvelle_demande_autre_dossier.png
    ...    div.widget_nouvelle_demande_autre_dossier
    #
    Depuis la page d'accueil    instr    instr
    Go To Dashboard
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_tableau-de-bord-exemple.png
    ...    #content
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_infos_profil.png
    ...    div.widget_infos_profil
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_recherche_dossier.png
    ...    div.widget_recherche_dossier
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_consultation_retours.png
    ...    div.widget_consultation_retours
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_messages_retours.png
    ...    div.widget_messages_retours
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossiers_evenement_incomplet_majoration.png
    ...    div.widget_dossiers_evenement_incomplet_majoration

    # Isole le contexte
    Depuis la page d'accueil  admin  admin
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_045_DS
    ...  departement=001
    ...  commune=001
    ...  insee=01001
    ...  direction_code=B
    ...  direction_libelle=Direction B de LIBRECOM_045_DS
    ...  direction_chef=Chef
    ...  division_code=B
    ...  division_libelle=Division B
    ...  division_chef=Chef
    ...  instr_om_utilisateur_nom=Phillipa Durand
    ...  instr_om_utilisateur_email=pdurand@openads-test.fr
    ...  instr_om_utilisateur_login=pdurand
    ...  instr_om_utilisateur_pwd=pdurand
    Isolation d'un contexte  ${librecom_values}
    ${date_di_db} =  Subtract Time From Date  ${DATE_FORMAT_YYYY-MM-DD}  50 days  result_format=%Y-%m-%d
    ${date_di} =  Convert Date  ${date_di_db}  result_format=%d/%m/%Y
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Mélodie
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  date_demande=${date_di}
    ${di_instr_1_division_1_commune_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DURAND
    ...  particulier_prenom=Jean
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  date_demande=${date_di}
    ${di_instr_2_division_1_commune_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=MARTIN
    ...  particulier_prenom=Auguste
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${librecom_values.om_collectivite_libelle}
    ...  date_demande=${date_di}
    ${di_instr_3_division_2_commune_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du widget  dossiers_limites
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments    filtre=aucun
    Click On Submit Button
    Depuis la page d'accueil  pdurand  pdurand
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossiers_limites.png
    ...    div.widget_dossiers_limites

    #
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  filtre=aucun  dossiers_pre_instruction
    #
    Depuis la page d'accueil    instrpoly    instrpoly
    Go To Dashboard
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossiers_pre_instruction.png
    ...    div.widget_dossiers_pre_instruction
    #
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget  ${EMPTY}  dossiers_pre_instruction

    #
    Depuis la page d'accueil    tech    tech
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_alerte_parquet.png
    ...    div.widget_dossier_contentieux_alerte_parquet
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_alerte_visite.png
    ...    div.widget_dossier_contentieux_alerte_visite

    #
    Depuis la page d'accueil    juriste    juriste
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_clotures.png
    ...    div.widget_dossier_contentieux_clotures
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_audience.png
    ...    div.widget_dossier_contentieux_audience
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_ait.png
    ...    div.widget_dossier_contentieux_ait
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_recours.png
    ...    div.widget_dossier_contentieux_recours
    #
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_contentieux_infraction.png
    ...    div.widget_dossier_contentieux_infraction

    Depuis la page d'accueil  admin  admin
    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=dossier_instruction
    Input Text    dossier    ${di_1},${di_2},${di_3}
    Click Element  css=#adv-search-submit
    Click On Link  ${di_1}
    Click On Back Button
    Click On Link  ${di_2}
    Click On Back Button
    Click On Link  ${di_3}
    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=dossier_contentieux_tous_recours
    Input Text    dossier    ${di_re_1},${di_re_2}
    Click Element  css=#adv-search-submit
    Click On Link  ${di_re_1}
    Click On Back Button
    Click On Link  ${di_re_2}
    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=dossier_contentieux_toutes_infractions
    Input Text    dossier    ${di_inf_1},${di_inf_2},${di_inf_3},${di_inf_4}
    Click Element  css=#adv-search-submit
    Click On Link  ${di_inf_1}
    Click On Back Button
    Click On Link  ${di_inf_2}
    Click On Back Button
    Click On Link  ${di_inf_3}
    Click On Back Button
    Click On Link  ${di_inf_4}
    Go To Dashboard
    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_dossier_consulter.png
    ...  css=div.widget_dossier_consulter

    #
    # MENUS ET DASHBOARDS
    #

    @{logins_menu_dashboard}  Create List
    ...  admin
    ...  adminfonct
    ...  admingen
    ...  suivi
    ...  chef
    ...  divi
    ...  guichet
    ...  guichetsuivi
    ...  instr
    ...  instrserv
    ...  instrpoly
    ...  instrpolycomm
    ...  qualif
    ...  visuda
    ...  visudadi
    ...  dirinf
    ...  dirrec
    ...  dirconsu
    ...  respinf
    ...  tech
    ...  juriste
    ...  chefctx
    ...  assist

    Capturer le menu et le dashboard des profils  ${logins_menu_dashboard}

    @{logins_menu}  Create List
    ...  consuint
    ...  consuetendu
    ...  consu
    ...  consudi


    Capturer le menu des profils  ${logins_menu}


CE des demandes
    [Tags]  doc
    [Documentation]  Réalise les captures d'écran concernant les demandes pour
    ...  la documentation.

    ##
    # Numérotation manuelle
    ##

    # Isolation du contexte
    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=MIDGARD
    ...  departement=012
    ...  commune=345
    ...  insee=12345
    ...  direction_code=W
    ...  direction_libelle=Direction de MIDGARD
    ...  direction_chef=Chef
    ...  division_code=W
    ...  division_libelle=Division W
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Alice Langlais
    ...  guichet_om_utilisateur_email=alicelanglais@openads-test.fr
    ...  guichet_om_utilisateur_login=alanglais
    ...  guichet_om_utilisateur_pwd=alanglais
    ...  instr_om_utilisateur_nom=Eliot Levasseur
    ...  instr_om_utilisateur_email=eliotlevasseur@openads-test.fr
    ...  instr_om_utilisateur_login=elevasseur
    ...  instr_om_utilisateur_pwd=elevasseur
    Isolation d'un contexte  ${isolation_values}
    Ajouter le droit depuis le menu  demande_nouveau_dossier_recuperer_code_type_da  GUICHET UNIQUE
    Ajouter le droit depuis le menu  demande_nouveau_dossier_recuperer_code_depcom  GUICHET UNIQUE
    Ajouter le droit depuis le menu  demande_nouveau_dossier_recuperer_dossier_division  GUICHET UNIQUE
    Ajouter le droit depuis le menu  demande_nouveau_dossier_recuperer_dossier_seq  GUICHET UNIQUE
    Ajouter le paramètre depuis le menu  option_dossier_saisie_numero  true  agglo
    Ajouter le paramètre depuis le menu  option_instructeur_division_numero_dossier  true  ${isolation_values.om_collectivite_libelle}
    # Ajout d'un dossier d'instruction pour incrémenter la numérotation
    &{args_demande_auto} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_petitionnaire_auto} =  Create Dictionary
    ...  particulier_nom=Garnier
    ...  particulier_prenom=Arlette
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${di_auto} =  Ajouter la demande par WS  ${args_demande_auto}  ${args_petitionnaire_auto}
    # Formulaire d'ajout d'une demande avec activation de la saisie manuelle
    # pour prendre la capture d'écran
    Depuis la page d'accueil  alanglais  alanglais
    &{args_demande_manu} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire_manu} =  Create Dictionary
    ...  particulier_nom=TOLIN
    ...  particulier_prenom=Patrice
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande_manu}  ${args_petitionnaire_manu}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=#petitionnaire_principal_delegataire .synthese_demandeur  TOLIN Patrice
    Click Element Until New Element  css=#num_doss_manuel  css=div.bloc_num_manu
    Wait Until Form Value Should Be  css=#num_doss_type_da  PC
    Wait Until Form Value Should Be  css=#num_doss_code_depcom  ${isolation_values.departement}${isolation_values.commune}
    ${date_annee_yyyy} =  Get Time  year
    ${date_annee_yy} =  Get Substring  ${date_annee_yyyy}  -2
    Wait Until Form Value Should Be  css=#num_doss_annee  ${date_annee_yy}
    Wait Until Form Value Should Be  css=#num_doss_division  W
    Wait Until Form Value Should Be  css=#num_doss_sequence  2
    Capture and crop page screenshot Sleep
    ...  screenshots/a_guichet_unique_nouvelle_demande_saisie_numero.png
    ...  content
    # Désactivation des paramètres
    Depuis la page d'accueil  admin  admin
    Supprimer le droit depuis le contexte du profil  demande_nouveau_dossier_recuperer_code_type_da  GUICHET UNIQUE
    Supprimer le droit depuis le contexte du profil  demande_nouveau_dossier_recuperer_code_depcom  GUICHET UNIQUE
    Supprimer le droit depuis le contexte du profil  demande_nouveau_dossier_recuperer_dossier_seq  GUICHET UNIQUE
    Supprimer le paramètre  option_dossier_saisie_numero  true
    Supprimer le paramètre  option_instructeur_division_numero_dossier  true


CE des dossiers d'instruction

    [Documentation]  L'objet de ce 'Test Case' est de réaliser les captures d'écran
    ...    à destination de la documentation.

    [Tags]  doc

    #
    # MESSAGES
    #

    Depuis la page d'accueil    instrpoly    instrpoly
    Depuis l'onglet des messages du dossier d'instruction  ${di_1}
    #
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_message_tab.png
    ...    formulaire
    #
    Click On Link  Ajout de pièce(s)
    #
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_message_form.png
    ...    sousform-dossier_message
    # TODO : Cette partie a été commenté car elle bloquait la génération de CE pour le reste du Test Case.
    # Depuis le contexte du dossier d'instruction  ${di_1}
    # Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_instruction_message_champs_requis_platau.png
    # ...  css=#fieldset-message-tab_demat-color

    Depuis la page d'accueil  admin  admin
    # Ajout d'un code de suivi de demande
    &{param_args} =  Create Dictionary
    ...  libelle=portal_code_suivi_base_url
    ...  valeur=LIEN_PORTAL/[PORTAL_CODE_SUIVI]/load
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_args}
    ${di_1_spaceless} =  Sans espace  ${di_1}
    ${values_lien_id_interne_uid_externe} =  Create Dictionary
    ...  object=code-suivi
    ...  object_id=${di_1_spaceless}
    ...  external_uid=code-suivi://TESTCODESUIVIPORTAL
    ...  dossier=${di_1_spaceless}
    ...  category=portal
    Ajouter le lien entre id interne et uid externe  ${values_lien_id_interne_uid_externe}
    ${values_lien_id_interne_uid_externe} =  Create Dictionary
    ...  object=code-suivi
    ...  object_id=${di_1_spaceless}
    ...  external_uid=code-suivi://TESTCODESUIVIPORTAL2
    ...  dossier=${di_1_spaceless}
    ...  category=portal
    Ajouter le lien entre id interne et uid externe  ${values_lien_id_interne_uid_externe}
    ${values_lien_id_interne_uid_externe} =  Create Dictionary
    ...  object=code-suivi
    ...  object_id=${di_1_spaceless}
    ...  external_uid=code-suivi://TESTCODESUIVIPORTAL3
    ...  dossier=${di_1_spaceless}
    ...  category=portal
    Ajouter le lien entre id interne et uid externe  ${values_lien_id_interne_uid_externe}

    Depuis la page d'accueil    instrpoly    instrpoly
    Depuis le contexte du dossier d'instruction  ${di_1}
    Open All Fieldset Using Javascript  dossier_instruction
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_portal_code_suivi.png
    ...  css=fieldset#fieldset-form-dossier_instruction-ide_au---codes-de-suivi

    Depuis le contexte du rapport d'instruction  ${di_1}

    # Multiline string with newlines
    ${analyse_reglementaire}=  catenate  SEPARATOR=\n
    ...  Accès (article 3) : Conforme/Non Conforme
    ...  ${EMPTY}
    ...  Réseaux (article 4) : Conforme/Non Conforme
    ...  ${EMPTY}
    ...  Implantation (articles 6 7 8) : Conforme/Non Conforme
    ...  (implantation à m de la limite séparative la plus proche pour une différence d'altitude de m, et à plus de m de l'alignement de la voie)
    ...  ${EMPTY}
    ...  Emprise au sol (article 9) : Conforme/Non Conforme/Non réglementé
    ...  ${EMPTY}
    ...  Hauteur (article 10) : Conforme/Non Conforme
    ...  (m pour une hauteur maxi de m)
    ...  ${EMPTY}
    ...  Aspect architectural (article11) : Conforme/Non Conforme
    ...  ${EMPTY}
    ...  Stationnement (article 12) : Conforme/Non Conforme
    ...  (surface totale de plancher totale : m²)
    ...  dans le bâtiment : en surface :
    ...  ${EMPTY}
    ...  Espaces Verts (article 13) : Conforme/Non Conforme
    ...  ${EMPTY}
    ...  C.O.S (article 14) et surface des terrains (article5) : Non réglementé
    ...  ${EMPTY}
    ...  Taxes et redevances :
    ...  Taxe aménagement : oui/non
    ...  Redevance archéologie : oui/non

    Input HTML  analyse_reglementaire_om_html  ${analyse_reglementaire}

    Capture and crop page screenshot Sleep  screenshots/a_instruction_portlet_rapport_instruction.png
    ...    sousform-rapport_instruction

    # Historisation du rapport pour affichage du tableau avec des versions historisées
    Ajouter et finaliser le rapport d'instruction  ${di_1}  ${analyse_reglementaire}
    Depuis le contexte du rapport d'instruction  ${di_1}
    Click On SubForm Portlet Action  rapport_instruction  definalise
    Wait Until Page Contains  La définalisation du document s'est effectuée avec succès.
    Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Page Contains  La finalisation du document s'est effectuée avec succès.


    # Screenshot pour la qualification ERP
    Depuis le formulaire de modification du dossier d'instruction  ${di_1}
    Highlight heading  css=#erp
    Capture and crop page screenshot Sleep  screenshots/a_instruction_qualification_erp.png
    ...  css=#fieldset-form-dossier_instruction-qualification

    # augmente la taille de la fenêtre pour être sûr que la prévisu soit visible
    Set Window Size  1680  1050

    Depuis la page d'accueil  admin  admin
    # Capture du tableau des ri historisé
    Depuis le contexte du rapport d'instruction  ${di_1}
    Capture and crop page screenshot Sleep  screenshots/a_tab_histo_ri.png
    ...    sousform-rapport_instruction

    Ajouter le paramètre depuis le menu  option_previsualisation_edition  true  agglo

    # Prévisualisation du PDF lors de la modification d'une instruction
    Depuis la page d'accueil    instr    instr
    Depuis l'instruction du dossier d'instruction  ${di_3}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  modifier
    Sleep  3
    Capture and crop page screenshot Sleep  screenshots/a_instruction_previsualisation_edition.png
    ...  css=#sousform-instruction

    #-- Rédaction libre
    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  option_redaction_libre  true  agglo
    # Contrainte avec un évènement suggéré
    @{contraintes_to_add} =  Create List  ${id_contrainte_avec_suggestion}
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${di_3}  ${contraintes_to_add}

    Depuis la page d'accueil    instr    instr

    # ajout d'une instruction
    Set Window Size  1280  800
    Depuis l'onglet instruction du dossier d'instruction  ${di_3}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sousform-instruction #action-soustab-instruction-corner-ajouter
    Sleep  2
    Capture and crop page screenshot Sleep  screenshots/a_instruction_form_ajout.png
    ...  css=#formulaire
    # Capture d'écran de la liste à choix des évènements d'instruction avec évènement suggérés
    Click Element Until New Element  evenement_chosen  css=.chosen-drop
    Capture and crop page screenshot Sleep  screenshots/a_instruction_suggeree.png
    ...  css=.chosen-drop
    Click On Back Button In Subform
    Set Window Size  1680  1050

    # bouton "Rédaction libre" du Portlet de l'instruction
    Depuis l'instruction du dossier d'instruction  ${di_3}  accepter un dossier sans réserve
    Highlight heading  id=action-sousform-instruction-enable-edition-integrale
    Capture and crop page screenshot Sleep  screenshots/a_instruction_redaction_libre_bouton_portlet.png
    ...  css=#sousform-instruction #portlet-actions

    # bouton "Modifier" du Portlet de l'instruction
    Depuis l'instruction du dossier d'instruction  ${di_3}  accepter un dossier sans réserve
    Highlight heading  id=action-sousform-instruction-modifier
    Capture and crop page screenshot Sleep  screenshots/a_instruction_redaction_libre_bouton_modifier_portlet.png
    ...  css=#sousform-instruction #portlet-actions

    # activation du mode "Rédaction libre"
    Depuis l'instruction du dossier d'instruction  ${di_3}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  enable-edition-integrale  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer

    # bouton "Rédaction par compléments" du Portlet de l'instruction
    Depuis l'instruction du dossier d'instruction  ${di_3}  accepter un dossier sans réserve
    Highlight heading  id=action-sousform-instruction-disable-edition-integrale
    Capture and crop page screenshot Sleep  screenshots/a_instruction_redaction_libre_bouton_complements_portlet.png
    ...  css=#sousform-instruction #portlet-actions

    # champs "Titre" et "Corps" lors de la modification de l'instruction
    Depuis l'instruction du dossier d'instruction  ${di_3}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  modifier
    Sleep  3
    Capture and crop page screenshot Sleep  screenshots/a_instruction_form_edition.png
    ...  css=#formulaire
    Highlight heading  id=fieldset-sousform-instruction-titre
    Highlight heading  id=fieldset-sousform-instruction-corps
    Capture and crop page screenshot Sleep  screenshots/a_instruction_redaction_libre_champs_corps.png
    ...  css=#sousform-instruction .container_instr_edition

    # désactivation du mode "Rédaction libre"
    Depuis l'instruction du dossier d'instruction  ${di_3}  accepter un dossier sans réserve
    Click On SubForm Portlet Action  instruction  disable-edition-integrale  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer

    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  option_redaction_libre  false  agglo

    #-- fin Rédaction libre

    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  option_previsualisation_edition  false  agglo

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
    ...  terrain_adresse_voie_numero=56
    ...  terrain_adresse_voie=boulevard Amiral Courbet
    ...  terrain_adresse_localite=Marseille

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

    ${args_peti} =  Create Dictionary

    # Ajout du DI initial
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label    dossier_autorisation_type_detaille    Recours contentieux
    Select From List By Label    om_collectivite    MARSEILLE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    autorisation_contestee    ${di}
    Click Button    css=#autorisation_contestee_search_button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain    css=#petitionnaire_principal_delegataire    Mylène Françoise
    Sleep  1
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    Ajouter la demande par WS  ${args_demande_inf}  ${args_peti}  ${args_autres_demandeurs}
    Depuis le contexte du dossier d'instruction  ${di}

    Highlight heading  css=#fieldset-form-dossier_instruction-enjeu>.fieldsetContent>.field-type-static
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_instruction_form_enjeu_fieldset.png
    ...  css=#fieldset-form-dossier_instruction-enjeu.cadre

    # Pour tester tous les comportements des pictogrammes EN et IN, 
    # lorsque le statut du dossier contentieux a un statut clôturé
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=coco
    ...  particulier_prenom=free
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  002  AZ  0008
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=tila
    ...  particulier_prenom=pot
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=radon
    ...  particulier_prenom=glee
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande_inf} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_enjeu_ctx_cloture} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    &{args_demande_re} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  demande_type=Dépôt Initial REC
    ...  autorisation_contestee=${di_enjeu_ctx_cloture}
    ...  om_collectivite=MARSEILLE
    ${di_re_enjeu_ctx} =  Ajouter la demande par WS  ${args_demande_re}
    ${di_inf_enjeu_ctx} =  Ajouter la demande par WS  ${args_demande_inf}  ${NULL}  ${args_autres_demandeurs}
    # Lors de la clôture des recours et infraction,
    # les pictogrammes EN et IN doivent tous les deux passer au vert
    Ajouter une instruction au DI  ${di_re_enjeu_ctx}  accepter un dossier sans réserve  null  recours
    Ajouter une instruction au DI  ${di_inf_enjeu_ctx}  accepter un dossier sans réserve  null  infraction
    Depuis le contexte du dossier d'instruction  ${di_enjeu_ctx_cloture}
    Vérifier qu'un élément a une classe CSS  name  RE  label-success
    Vérifier qu'un élément a une classe CSS  name  IN  label-success
    Highlight heading  css=#fieldset-form-dossier_instruction-enjeu>.fieldsetContent>.field-type-static
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_instruction_form_enjeu_fieldset_tous_cloture.png
    ...  css=#fieldset-form-dossier_instruction-enjeu.cadre

    Depuis le contexte du dossier d'instruction  ${di}

    Click On Form Portlet Action    dossier_instruction    modifier

    ${date_depot_selector} =  Set Variable  css=div.field-type-date:first-child
    Element Should Be Visible  ${date_depot_selector}
    Highlight heading  ${date_depot_selector}
    Capture and crop page screenshot Sleep  screenshots/a_instruction_action_modifier_date_depot.png
    ...  css=div#tabs-1
    Clear highlight  ${date_depot_selector}
    # TODO : Commenté car bloquant pour la génération de CE.
    # ${date_affichage_selector} =  Set Variable  css=div.field-type-date:nth-child(2)
    # Element Should Be Visible  ${date_affichage_selector}
    # Highlight heading  ${date_affichage_selector}
    # Capture and crop page screenshot Sleep  screenshots/a_instruction_action_modifier_date_affichage.png
    # ...  css=div#tabs-1
    # Clear highlight  ${date_affichage_selector}

    # en tant qu'admin
    Depuis la page d'accueil  admin  admin

    #-- ajout du paramétrage
    # action de mise à jour de la date d'affichage
    &{args_action} =  Create Dictionary
    ...  identifiant=maj_date_affichage
    ...  action=maj_date_affichage
    ...  libelle=mise à jour de la date d'affichage
    ...  regle_date_affichage=date_evenement
    Ajouter Action  ${args_action}
    # évènement d'affichage obligatoire
    &{args_evenement} =  Create Dictionary
    ...  evenement=89
    ...  libelle=affichage_obligatoire
    ...  action=mise à jour de la date d'affichage
    Modifier l'événement  ${args_evenement}

    #-- modification de la date d'affichage par le menu "Registre"
    Depuis la page d'accueil  guichet  guichet
    Go To Submenu In Menu  guichet_unique  affichage_reglementaire_registre
    Capture and crop page screenshot Sleep  screenshots/a_guichet_unique_affichage_reglementaire_registre_formulaire.png
    ...  content
    Click Element  id=registre-form-submit
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Wait Until Keyword Succeeds  1 min  0.1 sec  Valid Message Should Contain  Traitement terminé. Le registre a été généré.
    La page ne doit pas contenir d'erreur
    Click Element  id=registre-form-download

    #-- capture le portlet et l'action d'attestion d'affichage
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di}
    ${attestation_affichage_selector} =  Set Variable  css=#action-form-dossier_instruction-date_affichage
    Element Should Be Visible  ${attestation_affichage_selector}
    Highlight heading  ${attestation_affichage_selector}
    Capture and crop page screenshot Sleep  screenshots/a_instruction_action_attestation_affichage.png
    ...  css=div#portlet-actions
    Clear highlight  ${attestation_affichage_selector}



    # Capture d'écran portlet et tableau du journal d'instruction
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di}
    ${log_instructions_selector} =  Set Variable  css=#action-form-dossier_instruction-get_log_di
    Element Should Be Visible  ${log_instructions_selector}
    Capture and crop page screenshot Sleep  screenshots/a_instruction_portlet_log_instructions.png
    ...  ${log_instructions_selector}
    Click On Form Portlet Action  dossier_instruction  get_log_di
    Wait Until Element Is Visible  css=div#log_instructions_jsontotab
    Capture and crop page screenshot Sleep  screenshots/a_instruction_log_instructions_table.png
    ...  css=div.formEntete.ui-corner-all

    # -- Capture portlet et formulaire pour normaliser l'adresse
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di}
    ${normalize_address_selector} =  Set Variable  css=#action-form-dossier_instruction-normalize_address
    Element Should Be Visible  ${normalize_address_selector}
    Capture and crop page screenshot Sleep  screenshots/a_instruction_portlet_normalize_address.png
    ...  ${normalize_address_selector}
    Click On Form Portlet Action  dossier_instruction  normalize_address  modale
    Wait Until Element Is Visible  css=ul.ui-autocomplete
    Capture and crop page screenshot Sleep  screenshots/a_instruction_normalize_address_form.png
    ...  css=div.ui-dialog

    # CE au terme du délai
    Depuis la page d'accueil  admin  admin
    # Modification de l'événement de récépissé
    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  accord_tacite=Non
    Modifier l'événement  ${args_evenement}

    # Ajout du dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=190TESTnoeventtacitenom
    ...  particulier_prenom=190TESTnoeventtaciteprenom
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis le contexte du dossier d'instruction  ${di}

    Capture and crop page screenshot Sleep  screenshots/a_instruction_terme_delai.png
    ...  css=#fieldset-form-dossier_instruction-instruction

        # Modification de l'événement de récépissé
    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  accord_tacite=Oui
    Modifier l'événement  ${args_evenement}

    Depuis la page d'accueil  admin  admin
    &{famille_travaux1} =  Create Dictionary
    ...  libelle=Ravalement
    ...  code=RAV
    ${famille_travaux1.id} =  Ajouter la famille de travaux  ${famille_travaux1}

    @{dit_nature_travauxft1} =  Create List
    ...  DP - Initiale
    &{nature_travaux1ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement public
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux1ft1.id} =  Ajouter la nature de travaux  ${nature_travaux1ft1}  ${dit_nature_travauxft1}

    &{nature_travaux2ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux2ft1.id} =  Ajouter la nature de travaux  ${nature_travaux2ft1}  ${dit_nature_travauxft1}

    # Création d'un dossier ayant les travaux de la famille_travaux 1
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST053NOM2
    ...  particulier_prenom=TEST053PRENOM2
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=DECLARATION PREALABLE SIMPLE
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_avec_nt_ft1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis le contexte du dossier d'instruction  ${di_avec_nt_ft1}
    Click On Portlet Action  dossier_instruction  modifier
    Click Element  css=#nature_travaux_chosen

    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_instruction_nature_travaux.png
    ...  content

CE des contraintes

    [Documentation]  L'objet de ce 'Test Case' est de réaliser les captures d'écran
    ...   de l'affichage des contraintes à destination de la documentation.

    [Tags]  doc

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
    ${id_contrainte1} =  Ajouter la contrainte depuis le menu  Contrainte 1  PLU  MARSEILLE  Groupe 1  sousgroupe 1  1ère contrainte instr
    ${id_contrainte2} =  Ajouter la contrainte depuis le menu  Contrainte 2  PLU  MARSEILLE  Groupe 1  sousgroupe 2  2ème contrainte instr
    ${id_contrainte3} =  Ajouter la contrainte depuis le menu  Contrainte 3  PLU  MARSEILLE  Groupe 2  sousgroupe 3  3ème contrainte instr

    Acceder au formulaire d'ajout des contraintes du dossier d'instruction  ${di}
    @{contraintes_to_add} =  Create List  ${id_contrainte1}  ${id_contrainte2}  ${id_contrainte3}
    # TODO : remplacer la ligne précédente par cette ligne lorsque la version du navigateur permettra de correctement
    #        afficher les suggestions
    # @{contraintes_to_add} =  Create List  ${id_contrainte1}  ${id_contrainte2}  ${id_contrainte3}  ${id_contrainte_avec_suggestion}
    Selectionner les contraintes a ajouter  ${contraintes_to_add}

    # CE de l'écran de sélection des contraintes
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_contrainte_form.png
    ...  content

    # On clique sur Appliquer les changements
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sformulaire div.formControls input[type="submit"]
    # Vérification de l'affichage du message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#sousform-dossier_contrainte div.message.ui-state-valid p span.text  La contrainte Contrainte 1 a été ajoutée au dossier.

    # CE de l'écran de sélection des contraintes après validation
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_contrainte_form_valide.png
    ...  content

    # Utilisation du bouton de suppression des contraintes non sélectionnées
    Click On Back Button In SubForm

    # CE de l'écran des contraintes
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_contrainte_view.png
    ...  content

CE des instructions
    [Documentation]  Captures d'écran concernant les instructions.
    [Tags]  doc

    # Ajout d'un dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lamarre
    ...  particulier_prenom=Gilles
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  001  AA  0009
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #
    # Suivi des dates et reprendre l'instruction
    #
    Depuis la page d'accueil  admin  admin
    Depuis l'instruction du dossier d'instruction  ${di}  Notification du delai legal maison individuelle
    Highlight heading  css=#action-sousform-instruction-modifier_suivi
    Capture and crop page screenshot Sleep  screenshots/a_instruction_portlet_mise_a_jour_des_dates.png
    ...  css=#sousform-instruction div#portlet-actions
    Clear highlight  css=#action-sousform-instruction-modifier_suivi
    Highlight heading  css=#action-sousform-instruction-definaliser
    Capture and crop page screenshot Sleep  screenshots/a_instruction_portlet_reprendre_instruction.png
    ...  css=#sousform-instruction div#portlet-actions
    Clear highlight  css=#action-sousform-instruction-definaliser
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Capture and crop page screenshot Sleep  screenshots/a_instruction_form_mise_a_jour_des_dates.png
    ...  css=#sousform-instruction

    # Envoi en signature au parapheur
    Copy File  ..${/}tests${/}binary_files${/}electronicsignature_test${/}electronicsignature.inc.php  ..${/}dyn${/}
    # Active l'action d'annulation d'envoi en signature
    Run  sed -i 's/"cancel_send" => false/"cancel_send" => true/' ../dyn/electronicsignature.inc.php
    Depuis la page d'accueil  admin  admin

    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    # Isolation du contexte
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_ELECSIGN_DOC
    ...  departement=020
    ...  commune=001
    ...  insee=20001
    ...  direction_code=ZZ
    ...  direction_libelle=Direction de LIBRECOM_ELECSIGN_DOC
    ...  direction_chef=Chef
    ...  division_code=ZZ
    ...  division_libelle=Division ZZ
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Mabienne St-Jean
    ...  guichet_om_utilisateur_email=mstjean@openads-test.fr
    ...  guichet_om_utilisateur_login=mstjean
    ...  guichet_om_utilisateur_pwd=mstjean
    ...  instr_om_utilisateur_nom=Kara Cliche
    ...  instr_om_utilisateur_email=kcliche@openads-test.fr
    ...  instr_om_utilisateur_login=kcliche
    ...  instr_om_utilisateur_pwd=kcliche
    Isolation d'un contexte  ${librecom_values}


    &{args_signataire_case_ok} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=DOCSIGNATURENOM
    ...  prenom=DOCSIGNATUREPRENOM
    ...  qualite=DOCSIGNATUREQUALITE
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=LIBRECOM_ELECSIGN_DOC
    ...  email=case4@test.test
    Ajouter le signataire depuis le menu  ${args_signataire_case_ok}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DOCSIGNATURENOM
    ...  particulier_prenom=SIGNATUREPPRENOM
    ...  om_collectivite=LIBRECOM_ELECSIGN_DOC
    ...  localite=PLOP
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=LIBRECOM_ELECSIGN_DOC
    ...  terrain_adresse_localite=PLOPPLOP
    ${di_case_ok} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_case_ok}  accepter un dossier sans réserve  signataire_arrete=${args_signataire_case_ok.prenom} ${args_signataire_case_ok.nom}
    Capture and crop page screenshot Sleep  screenshots/a_instruction_portlet_envoi_en_signature_parapheur.png
    ...  css=#sousform-instruction div#portlet-actions
    Click On SubForm Portlet Action  instruction  envoyer_a_signature  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Click Element  css=#fieldset-sousform-instruction-historique > legend.collapsible
    Sleep  20

    Capture and crop page screenshot Sleep  screenshots/a_instruction_fieldset_suivi_parapheur.png
    ...  css=#sousform-instruction fieldset#fieldset-sousform-instruction-suivi-parapheur

    Capture and crop page screenshot Sleep  screenshots/a_instruction_portlet_annuler_envoi_en_signature_parapheur.png
    ...  css=#sousform-instruction div#portlet-actions

    Depuis le contexte du dossier d'instruction  ${di_case_ok}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    # On clique sur l'action modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    Open fieldset In Subform  donnees_techniques  engagement-du-declarant
    Input Text  enga_decla_lieu  MARSEILLE
    Input Datepicker  enga_decla_date  ${date_ddmmyyyy}
    Click On Submit Button In Subform


    ${om_widget_libelle} =  Set Variable  Suivi d'instruction paramétrable
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=suivi_instruction_parametrable
    ...  arguments=statut_signature=in_progress\naffichage=liste\ntri=-6
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=INSTRUCTEUR
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    Depuis la page d'accueil  kcliche  kcliche

    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_suivi_instruction_parametrable.png
    ...    div.widget_suivi_instruction_parametrable

    # Par défaut le filtre est sur instructeur
    Depuis la page d'accueil  admin  admin
    ${om_widget_libelle} =  Set Variable  Widget 'Suivi de transfert'
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=suivi_tache
    ...  arguments=etat_tache=new\naffichage=liste\ntype_tache=creation_di;creation_da
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=INSTRUCTEUR
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}


    Depuis la page d'accueil  kcliche  kcliche

    Capture and crop page screenshot Sleep  screenshots/ergonomie/a_widget_suivi_tache.png
    ...    div.widget_suivi_tache

    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}
    Remove File  ..${/}dyn${/}electronicsignature.inc.php

    Depuis la page d'accueil  admin  admin
    # définir les paramètres de type de demande
    &{platau_type_demande_initial} =  Create Dictionary
    ...  libelle=platau_type_demande_initial_DP
    ...  valeur=DI
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${platau_type_demande_initial}

    # isole le contexte du test (création d'une collectivité)
    &{librecom_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM_CONTROLE_LEGALITE
    ...  departement=025
    ...  commune=160
    ...  insee=25160
    ...  direction_code=GM
    ...  direction_libelle=Direction de LIBRECOM_CONTROLE_LEGALITE
    ...  direction_chef=Chef
    ...  division_code=GM
    ...  division_libelle=Division GM
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Shalil Dibran
    ...  guichet_om_utilisateur_email=sdibran@openads-test.fr
    ...  guichet_om_utilisateur_login=sdibran
    ...  guichet_om_utilisateur_pwd=sdibran
    ...  instr_om_utilisateur_nom=Uomir Sambu
    ...  instr_om_utilisateur_email=usambu@openads-test.fr
    ...  instr_om_utilisateur_login=usambu
    ...  instr_om_utilisateur_pwd=usambu
    ...  code_entite=LBCOM_25
    ...  acteur=LIBRECOM-ACT-025
    Isolation d'un contexte  ${librecom_values}

    # Modification de l'événement pour transmission au CL par Plat'AU
    &{args_evenement} =  Create Dictionary
    ...  libelle=accepter un dossier sans réserve
    ...  envoi_cl_platau=true
    Modifier l'événement  ${args_evenement}

    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=LIBRECOM_CONTROLE_LEGALITE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_adresse_localite=TEST300controlelegalite
    ...  depot_electronique=true
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST300TASKNOMCONTROLELEGALITE
    ...  particulier_prenom=TEST300TASKPRENOMCONTROLELEGALITE
    ...  localite=TEST300Localite
    ...  om_collectivite=LIBRECOM_CONTROLE_LEGALITE
    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    &{donnees_techniques_values} =  Create Dictionary
    ...  enga_decla_lieu=TEST300engadelalieu
    ...  enga_decla_date=${date_ddmmyyyy}
    Saisir les données techniques du DI  ${di}  ${donnees_techniques_values}
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve
    &{args_date} =  Create Dictionary
    ...  date_retour_signature=${date_ddmmyyyy}
    Modifier le suivi des dates  ${di}  accepter un dossier sans réserve  ${args_date}

    Capture and crop page screenshot Sleep  screenshots/a_instruction_portlet_envoi_controle_legalite.png
    ...  css=#sousform-instruction div#portlet-actions

    # Capture d'écran liées à la notification des communes par mails
    &{param_values} =  Create Dictionary
    ...  libelle=param_courriel_de_notification_commune
    ...  valeur=support@atreal.fr\nsupport2@atreal.fr
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=param_courriel_de_notification_commune_objet_depuis_instruction
    ...  valeur=test
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=param_courriel_de_notification_commune_modele_depuis_instruction
    ...  valeur=test
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    Depuis l'instruction du dossier d'instruction  ${di}  accepter un dossier sans réserve
    Capture and crop page screenshot Sleep  screenshots/a_notifier_commune.png
    ...  css=#sousform-instruction div#portlet-actions
    Click On SubForm Portlet Action  instruction  notifier_commune  modale
    Cliquer sur le bouton de la fenêtre modale  Confirmer
    Capture and crop page screenshot Sleep  screenshots/a_suivi_notification_commune.png
    ...  css=fieldset#fieldset-sousform-instruction-suivi-notification-commune

    # Réinitialisation des paramètres
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=param_courriel_de_notification_commune
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_values}
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=param_courriel_de_notification_commune_objet_depuis_instruction
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_values}
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=param_courriel_de_notification_commune_modele_depuis_instruction
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_values}
    &{args_evenement} =  Create Dictionary
    ...  libelle=accepter un dossier sans réserve
    ...  envoi_cl_platau=false
    Modifier l'événement  ${args_evenement}

    # Capture d'écran pour la modification du document généré par une instruction.
     &{args_petitionnaire_modif_doc} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=TEST_modif
    ...  particulier_prenom=TEST_doc
    ...  om_collectivite=MARSEILLE

    &{args_demande_modif_doc} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_modif_doc} =  Ajouter la demande par WS  ${args_demande_modif_doc}  ${args_petitionnaire_modif_doc}

    # On entre dans le dossier d'instruction en tant qu'admin afin d'accéder au journal d'instruction
    Depuis la page d'accueil  admin  admin
    Depuis l'onglet instruction du dossier d'instruction  ${di_modif_doc}
    Click On Link  Notification du delai legal maison individuelle
    Click On SubForm Portlet Action  instruction  modifier_suivi

    ${date_envoi_sign} =  Convert Date  ${DATE_FORMAT_YYYY-MM-DD}  result_format=%d/%m/%Y
    Input Datepicker  date_envoi_signature  ${date_envoi_sign}
    ${CurrentDate}=  Get Current Date  result_format=%d/%m/%Y
    Click On Submit Button In Subform
    
    Highlight heading  css=div#sousform-container>div.formEntete>div#portlet-actions #action-sousform-instruction-modale_selection_document_signe span

    Capture and crop page screenshot Sleep  screenshots/a_instruction_portlet_modification_document_signe.png
    ...  css=#sousform-instruction div#portlet-actions


CE des dossiers d'autorisation
    [Documentation]  Captures d'écran concernant les dossiers d'autorisation
    [Tags]  doc

    # Paramétrage pour la parallélisation des dossiers
    Depuis la page d'accueil  admin  admin
    # Modification des types de demande pour qu'une DOC et un modificatif soient
    # compatibles à l'instruction en parallèle
    @{type_di_comp_doc} =  Create List  PCI - Modificatif
    &{type_PCI_DOC_comp} =  Create Dictionary
    ...  dossier_instruction_type_compatible=${type_di_comp_doc}
    Depuis la page d'accueil  admin  admin
    Modifier le type de demande  PCI  DOC  ${type_PCI_DOC_comp}

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lamarre
    ...  particulier_prenom=Gilles
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  001  AA  0009
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${da} =  Get Substring  ${di}  0  -2
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve
    #
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  om_collectivite=MARSEILLE
    Ajouter la demande sur existant  ${di}  ${args_demande}
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande d'ouverture de chantier
    ...  om_collectivite=MARSEILLE
    Ajouter la demande sur existant  ${di}  ${args_demande}

    Depuis le contexte du dossier d'autorisation  ${da}
    # Sélectionne les différents bloc composant le formulaire
    Update element style
    ...  css=#dossier_autorisation .col_6 .col_12:nth-child(1)
    ...  outline
    ...  solid black 3px
    Update element style
    ...  css=#dossier_autorisation .col_6 .col_12:nth-child(2)
    ...  outline
    ...  solid black 3px
    Update element style
    ...  css=#dossier_autorisation .col_6 .col_12:nth-child(3)
    ...  outline
    ...  solid black 3px
    Update element style
    ...  css=#dossier_autorisation .col_6 .col_12:nth-child(4)
    ...  outline
    ...  solid green 3px
    Update element style
    ...  css=#dossier_autorisation .col_6 .col_12:nth-child(5)
    ...  outline
    ...  solid red 3px
    Update element style
    ...  css=#dossier_autorisation .col_6 .col_12:nth-child(6)
    ...  outline
    ...  solid blue 3px
    Update element style
    ...  css=#dossier_autorisation .col_6:nth-child(2) .col_12:nth-child(1)
    ...  outline
    ...  solid black 3px
    Update element style
    ...  css=#dossier_autorisation .col_6:nth-child(2) .col_12:nth-child(2)
    ...  outline
    ...  solid black 3px
    Update element style
    ...  css=#dossier_autorisation .col_6:nth-child(2) .col_12:nth-child(3)
    ...  outline
    ...  solid black 3px
    Update element style
    ...  css=#dossier_autorisation .col_6:nth-child(2) .col_12:nth-child(4)
    ...  outline
    ...  solid green 3px
    Update element style
    ...  css=#dossier_autorisation .col_6:nth-child(3) .col_12:nth-child(1)
    ...  outline
    ...  solid black 3px
    Update element style
    ...  css=#dossier_autorisation .col_6:nth-child(3) .col_12:nth-child(2)
    ...  outline
    ...  solid black 3px
    Update element style
    ...  css=#dossier_autorisation .col_6:nth-child(3) .col_12:nth-child(3)
    ...  outline
    ...  solid black 3px
    Update element style
    ...  css=#dossier_autorisation .col_6:nth-child(3) .col_12:nth-child(4)
    ...  outline
    ...  solid green 3px
    Capture and crop page screenshot Sleep  screenshots/a_autorisation_visualisation.png
    ...  css=#content

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté
    ...  date_creation=${date_ddmmyyyy}
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    Depuis l'onglet des pièces du dossier d'autorisation  ${da}
    Capture and crop page screenshot Sleep  screenshots/a_autorisation_document_numerise_tab.png
    ...    content

CE des demandes d'avis

    [Documentation]  Captures d'écran concernant les demandes d'avis.

    [Tags]  doc

    #
    # L'onglet "Pièce(s)"
    #

    Depuis la page d'accueil  consu  consu
    Depuis l'onglet des pièces de la demande d'avis passée du dossier d'instruction  ${di_1}
    Capture and crop page screenshot Sleep  screenshots/a_service_consulte_demande_avis_piece.png
    ...    content

    #
    # L'onglet "Consultation(s)"
    #

    Depuis la page d'accueil  consuetendu  consuetendu
    Depuis l'onglet des consultations de la demande d'avis en cours du dossier d'instruction  ${di_1}
    Capture and crop page screenshot Sleep  screenshots/a_service_consulte_demande_avis_consultation.png
    ...    content


CE du paramétrage des pièces

    [Documentation]  Captures d'écran concernant la gestion des pièces.

    [Tags]  doc

    #
    # Type de pièce
    #

    Depuis la page d'accueil  admin  admin
    Depuis le listing  document_numerise_type
    Click On Add Button
    Capture and crop page screenshot Sleep  screenshots/a_parametrage_document_numerise_type_form.png
    ...    content


CE du paramétrage de la nomenclature des pièces

    [Documentation]  Captures d'écran concernant la gestion des pièces.

    [Tags]  doc

    #
    # Nomenclature de pièce
    #

    Depuis la page d'accueil  admin  admin
    Depuis le listing  lien_document_n_type_d_i_t
    Click On Add Button
    Capture and crop page screenshot Sleep  screenshots/a_parametrage_document_numerise_nomenclature_form.png
    ...    content



CE du menu de mise à jour des métadonnées

    [Documentation]  Captures d'écran concernant la gestion des pièces.

    [Tags]  doc

    #
    # Type de pièce
    #

    Depuis la page d'accueil  admin  admin
    Depuis le listing  document_numerise_type
    Click On Add Button
    Capture and crop page screenshot Sleep  screenshots/a_parametrage_document_numerise_type_form.png
    ...    content

    #
    # Traitement des pièces
    #

    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=document_numerise_traitement_metadonnees&action=100&idx=0
    Capture and crop page screenshot Sleep  screenshots/a_parametrage_document_numerise_metadata_treatment.png
    ...    content

    # Afin d'avoir un fichier en erreur, on le supprime sur le filestorage
    Remove Directory  ../var/filestorage/79/79d4  true
    # On modifie un type de pièces
    ${dnt_code} =  Set Variable  ART
    &{dnt_values} =  Create Dictionary
    ...  aff_da=true
    Modifier le type de pièces  ${dnt_code}  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=document_numerise_traitement_metadonnees&action=100&idx=0
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Cette page permet de mettre à jour certaines métadonnées des pièces numérisées.
    Click On Submit Button
    Sleep  1
    La page ne doit pas contenir d'erreur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Le traitement s'est correctement déroulé, sauf pour les pièces numérisées ci-dessous :
    Valid Message Should Contain  Dossier d'instruction n°AZ0130551200001P0 : le document 20160919ART.pdf n'a pas pu être mis à jour.

    Capture and crop page screenshot Sleep  screenshots/a_parametrage_document_numerise_metadata_treatment_res.png
    ...    content


CE des consultations
    [Tags]  doc
    [Documentation]  Captures d'écran concernant les consultation.

    # Login pour la visualisation de consultation
    Depuis la page d'accueil  instr  instr
    # On ce met sur l'onglet de consultation
    Depuis l'onglet consultation du dossier  ${di_1}
    # On fait la CE du tableau
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_consultation_tab.png
    ...    sousform-consultation
    # On rentre dans la consultation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  59.01 - Direction de l'Eau et de l'Assainissement

    Highlight heading  css=div#sousform-container>div.formEntete>div#portlet-actions #action-sousform-consultation-masquer_dans_edition span
    # On enléve le soulignement du marquer comme lu #action-sousform-consultation-marquer_comme_lu
    Mouse Out  css=div#sousform-container>div.formEntete>div#portlet-actions #action-sousform-consultation-marquer_comme_lu
    # On fait la CE du portlet
    Capture and crop page screenshot Sleep  screenshots/a_portlet_masquer_consultation.png
    ...    div#sousform-container>div.formEntete>div#portlet-actions

    Click On Back Button In Subform
    # On supprime en JS l'action de trop pour donner une impression de zoom sur le bouton uniquement
    Execute Javascript  return (function(){ jQuery("a[id*='action-soustab-consultation-left-consulter']").remove(); return true; })();
    Capture and crop page screenshot Sleep  screenshots/a_instruction_tab_masquer_consultation.png
    ...    td.icons

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  59.01 - Direction de l'Eau et de l'Assainissement
    # On clique sur l'action de masquer le document
    Click On SubForm Portlet Action  consultation  masquer_dans_edition
    # Vérification du message de succès pour attendre
    Valid Message Should Be In Subform  La consultation est masquée dans les éditions.
    Highlight heading  css=div#sousform-container>div.formEntete>div#portlet-actions #action-sousform-consultation-afficher_dans_edition span
    # On enléve le soulignement du marquer comme lu
    Mouse Out  css=div#sousform-container>div.formEntete>div#portlet-actions #action-sousform-consultation-marquer_comme_lu

    Capture and crop page screenshot Sleep  screenshots/a_portlet_visible_consultation.png
    ...    div#sousform-container>div.formEntete>div#portlet-actions

    Click On Back Button In Subform
    # On supprime en JS l'action de trop pour donner une impression de zoom sur le bouton uniquement
    Execute Javascript  return (function(){ jQuery("a[id*='action-soustab-consultation-left-consulter']").remove(); return true; })();
    Capture and crop page screenshot Sleep  screenshots/a_instruction_tab_visible_consultation.png
    ...    td.icons


CE de l'onglet des dossiers liés

    [Documentation]  Captures d'écran concernant l'onglet "Dossiers liés" d'un
    ...  dossier d'instruction.

    [Tags]  doc

    Depuis l'onglet dossiers liés du dossier d'instruction  ${di_1}
    Click On Add Button

    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossiers_lies_form_ajout.png
    ...    content


CE de la création de lettre RAR

    [Documentation]  Captures d'écran concernant les lettre RAR

    [Tags]  doc

    Depuis la page d'accueil  suivi  suivi

    Go To Dashboard
    Page Title Should Be  Tableau De Bord
    Capture and crop page screenshot Sleep  screenshots/a_suivi_menu.png  menu-list

    Click Link  envoi lettre AR
    Page Title Should Be  Suivi > Suivi Des Pièces > Envoi Lettre AR

    Capture and crop page screenshot Sleep  screenshots/a_suivi_envoi_lettre_rar_formulaire.png
    ...    formulaire

    # Vérification sans valeur saisie
    Click On Submit Button
    Error Message Should Be  Tous les champs doivent être remplis.

    Capture and crop page screenshot Sleep  screenshots/a_suivi_envoi_lettre_rar_message_aucune_saisie.png
    ...    .message

    # Vérification avec un numéro non valide
    Input Text  liste_code_barres_instruction  a
    Click On Submit Button
    Error Message Should Be  Le code barres d'instruction a n'est pas valide.

    Capture and crop page screenshot Sleep  screenshots/a_suivi_envoi_lettre_rar_message_evenement_instruction_incorrect.png
    ...    .message

    # Vérification avec un numéro non présent en base
    Input Text  liste_code_barres_instruction  123
    Click On Submit Button
    Error Message Should Be  Le numéro 123 ne correspond à aucun code barres d'instruction.

    Capture and crop page screenshot Sleep  screenshots/a_suivi_envoi_lettre_rar_message_evenement_instruction_inexistant.png
    ...    .message

    Click Link  envoi lettre AR
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Input Text  date  ${date_ddmmyyyy}
    Input Text  liste_code_barres_instruction  ${code_barres}
    Click On Submit Button
    Valid Message Should Contain  Cliquez sur le lien ci-dessous pour télécharger votre document :
    Click Element  css=fieldset#fieldset-form-rar-lien_di>legend

    Capture and crop page screenshot Sleep  screenshots/a_suivi_envoi_lettre_rar_message_evenement_instruction_ok.png
    ...    .message

    Click Link  envoi lettre AR
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Input Text  date  27/11/2020
    Input Text  liste_code_barres_instruction  ${code_barres}
    Click On Submit Button
    Error Message Should Contain  Une lettre correspondante

    Capture and crop page screenshot Sleep  screenshots/a_suivi_envoi_lettre_rar_message_evenement_instruction_deja.png
    ...    .message


CE du parametrage des commissions
    [Tags]  doc
    [Documentation]  L'objet de ce 'Test Case' est de faire une CE du
    ...  type de commission.

    Depuis la page d'accueil  admin  admin
    Depuis le listing  commission_type
    Click On Add Button
    Capture and crop page screenshot Sleep  screenshots/a_type_commission_parametrage.png
    ...    #formulaire


CE du widget retour de commission
    [Tags]  doc
    [Documentation]  L'objet de ce 'Test Case' est de faire une CE du
    ...  widget retour de commission.

    # On crée une collectivité pour ne pas perturber ni être perturbé par
    # les autres tests.
    ${collectivite} =  Set Variable  CHÂTEAUVERT
    ${utilisateur_instructeur_nom} =  Set Variable  Arman Christiaanse
    ${utilisateur_instructeur_login} =  Set Variable  achristiaanse

    Depuis la page d'accueil  admin  admin
    Ajouter la collectivité depuis le menu  ${collectivite}  mono
    Ajouter la direction depuis le menu  ${collectivite}  Direction A  null
    ...  Chef A  null  null  ${collectivite}
    Ajouter la division depuis le menu  div A  subdivision A  null
    ...  Chef A  null  null  Direction A

    Ajouter l'utilisateur  ${utilisateur_instructeur_nom}  test@example.org
    ...  ${utilisateur_instructeur_login}  ${utilisateur_instructeur_login}
    ...  INSTRUCTEUR  ${collectivite}
    Ajouter l'instructeur depuis le menu  ${utilisateur_instructeur_nom}
    ...  subdivision A  instructeur  ${utilisateur_instructeur_nom}

    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_instructeur_nom} (div A)
    ...  om_collectivite=${collectivite}
    Ajouter l'affectation depuis le menu  ${args_affectation}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Vaillancourt
    ...  particulier_prenom=Harbin
    ...  om_collectivite=${collectivite}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=${collectivite}
    ${di_01} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${code_type_commission} =  Set Variable  TC

    &{args_type_de_commission} =  Create Dictionary
    ...  code=${code_type_commission}
    ...  libelle=Type C
    ...  listes_de_diffusion=support@atreal.fr
    ...  participants=Atreal
    ...  corps_du_courriel=Type C
    ...  om_collectivite=${collectivite}
    Ajouter type de commission  ${args_type_de_commission}

    ## Début workflow commission
    Depuis la page d'accueil  ${utilisateur_instructeur_login}  ${utilisateur_instructeur_login}
    Ajouter la commission depuis le contexte du dossier d'instruction
    ...  ${di_01}  Type C  ${date_ddmmyyyy}

    Depuis la page d'accueil  admin  admin
    &{args_commission} =  Create Dictionary
    ...  om_collectivite=${collectivite}
    ...  commission_type=Type C
    Ajouter un suivi de commission  ${args_commission}

    Planifier un dossier pour une commission
    ...  ${di_01}  ${code_type_commission}${DATE_FORMAT_YYYYMMDD}

    Rendre un avis sur dossier passé en commission
    ...  favorable  ${di_01}  ${code_type_commission}${DATE_FORMAT_YYYYMMDD}

    Depuis la page d'accueil  ${utilisateur_instructeur_login}  ${utilisateur_instructeur_login}
    Element Should Contain  css=.widget_commission_retours .box-icon  1
    Capture and crop page screenshot Sleep
    ...  screenshots/ergonomie/a_widget_commission_mes_retours.png
    ...  css=.widget_commission_retours


CE du parametrage des services
    [Tags]  doc
    [Documentation]  L'objet de ce 'Test Case' est de faire une CE du
    ...  formulaire d'ajout des services

    Depuis la page d'accueil  admin  admin
    Depuis le listing  service
    Click On Add Button
    Capture and crop page screenshot Sleep  screenshots/a_service_parametrage.png
    ...    #formulaire

CE du parametrage des tiers
    [Tags]  doc
    [Documentation]  L'objet de ce 'Test Case' est de faire une CE du
    ...  formulaire d'ajout des tiers et du listing des tiers.
    ...  La capture du listing des tiers met en évidence le fait que si
    ...  une catégorie est lié à plusieurs collectvité alors un tiers
    ...  rattaché à cette catégorie sera affiché une fois pour chaque
    ...  collectivités liées.

    Depuis la page d'accueil  admin  admin
    Depuis le listing  tiers_consulte
    Click On Add Button
    Capture and crop page screenshot Sleep  screenshots/a_tiers_parametrage.png
    ...    #formulaire

    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie MA
    ...  abrege=TMA
    ...  libelle=tiers M/A
    ...  ville=MARSEILLE
    ...  liste_diffusion=support@atreal.fr
    ...  accepte_notification_email=true
    Ajouter le tiers consulte depuis le listing  ${args_tiers}
    Depuis le listing  tiers_consulte
    Capture and crop page screenshot Sleep  screenshots/a_listing_tiers.png
    ...    #formulaire

CE du parametrage des bibles
    [Tags]  doc
    [Documentation]  L'objet de ce 'Test Case' est de faire une CE des
    ...  bibles

    Depuis la page d'accueil  admin  admin
    Depuis le listing  bible
    Click On Add Button
    Capture and crop page screenshot Sleep  screenshots/a_parametrage_bible.png
    ...    #formulaire
*** test case ***
CE de la simulation des taxes
    [Tags]  doc
    [Documentation]  Permet de réaliser les captures d'écrans concernant la
    ...  simulation des taxes.

    # On active l'option de simulation des taxes
    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  option_simulation_taxes  true  agglo

    # CE du paramétrage des taxes
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du paramétrage des taxes  MARSEILLE
    Click On Form Portlet Action  taxe_amenagement  modifier
    Capture and crop page screenshot Sleep  screenshots/a_taxe_amenagement_form.png  formulaire

    # CE du fieldset de simulation des taxes
    Depuis la page d'accueil  instr  instr
    &{args_dt_taxes} =  Create Dictionary
    ...  tax_surf_tot_cstr=160
    ...  tax_su_princ_surf1=160
    ...  tax_sup_bass_pisc_cr=50
    ...  tax_am_statio_ext_cr=2
    ...  tax_surf_loc_arch=0.5
    ...  tax_surf_pisc_arch=2
    ...  mtn_exo_ta_part_commu=100
    ...  mtn_exo_ta_part_depart=100
    ...  mtn_exo_ta_part_reg=0
    ...  mtn_exo_rap=20
    Modifier les données techniques pour le calcul des impositions  ${di_1}  ${args_dt_taxes}
    &{args_di} =  Create Dictionary
    ...  tax_secteur=Secteur 1
    Modifier le dossier d'instruction  ${di_1}  ${args_di}
    Depuis le contexte du dossier d'instruction  ${di_1}
    Open Fieldset  dossier_instruction  simulation-des-taxes
    Capture and crop page screenshot Sleep  screenshots/a_instruction_simulation_taxes.png
    ...  css=#fieldset-form-dossier_instruction-simulation-des-taxes

    # CE des données techniques nécessaires au calcul de la TA
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    Open Fieldset In Subform  donnees_techniques  declaration-des-elements-necessaires-au-calcul-des-impositions
    Open Fieldset In Subform  donnees_techniques  exonerations
    Sleep  1
    Highlight heading  css=#tax_surf_tot_cstr
    Highlight heading  css=#tax_empl_ten_carav_mobil_nb_cr
    Highlight heading  css=#tax_empl_hll_nb_cr
    Highlight heading  css=#tax_sup_bass_pisc_cr
    Highlight heading  css=#tax_eol_haut_nb_cr
    Highlight heading  css=#tax_pann_volt_sup_cr
    Highlight heading  css=#tax_am_statio_ext_cr
    Highlight heading  css=#tax_su_princ_surf4
    Highlight heading  css=#tax_su_princ_surf3
    Highlight heading  css=#tax_su_heber_surf3
    Highlight heading  css=#tax_su_princ_surf1
    Highlight heading  css=#tax_su_princ_surf2
    Highlight heading  css=#tax_su_non_habit_surf2
    Highlight heading  css=#tax_su_non_habit_surf3
    Highlight heading  css=#tax_su_non_habit_surf4
    Highlight heading  css=#tax_su_parc_statio_expl_comm_surf
    Highlight heading  css=#mtn_exo_ta_part_commu
    Highlight heading  css=#mtn_exo_ta_part_depart
    Highlight heading  css=#mtn_exo_ta_part_reg
    Capture and crop page screenshot Sleep  screenshots/a_instruction_simulation_taxes_dt_ta.png
    ...  css=#fieldset-sousform-donnees_techniques-declaration-des-elements-necessaires-au-calcul-des-impositions
    Click On Back Button In Subform

    # CE des données techniques nécessaires au calcul de la RAP
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier
    Open Fieldset In Subform  donnees_techniques  declaration-des-elements-necessaires-au-calcul-des-impositions
    Open Fieldset In Subform  donnees_techniques  exonerations
    Sleep  1
    Highlight heading  css=#tax_surf_loc_arch
    Highlight heading  css=#tax_surf_tot_cstr
    Highlight heading  css=#tax_empl_ten_carav_mobil_nb_arch
    Highlight heading  css=#tax_empl_ten_carav_mobil_nb_cr
    Highlight heading  css=#tax_empl_hll_nb_arch
    Highlight heading  css=#tax_empl_hll_nb_cr
    Highlight heading  css=#tax_surf_pisc_arch
    Highlight heading  css=#tax_sup_bass_pisc_cr
    Highlight heading  css=#tax_am_statio_ext_arch
    Highlight heading  css=#tax_am_statio_ext_cr
    Highlight heading  css=#tax_su_princ_surf4
    Highlight heading  css=#tax_su_princ_surf3
    Highlight heading  css=#tax_su_heber_surf3
    Highlight heading  css=#tax_su_princ_surf1
    Highlight heading  css=#tax_su_princ_surf2
    Highlight heading  css=#tax_su_non_habit_surf2
    Highlight heading  css=#tax_su_non_habit_surf3
    Highlight heading  css=#tax_su_non_habit_surf4
    Highlight heading  css=#tax_su_parc_statio_expl_comm_surf
    Highlight heading  css=#mtn_exo_rap
    Capture and crop page screenshot Sleep  screenshots/a_instruction_simulation_taxes_dt_rap.png
    ...  css=#fieldset-sousform-donnees_techniques-declaration-des-elements-necessaires-au-calcul-des-impositions
    Click On Back Button In Subform
***
CE de la creation des nouveaux dossiers contentieux
    [Tags]  doc
    [Documentation]  Captures d'écran de la creation des nouveaux dossiers
    ...  contentieux.

    Depuis la page d'accueil  assist  assist
    Depuis le contexte de nouvelle demande contentieux via l'URL
    &{args_demande_mauvais_di} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  autorisation_contestee=DP0130551710001P0
    &{args_demande_valides} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  autorisation_contestee=${di_2}

    Run Keyword And Expect Error  *
    ...  Saisir la demande  ${args_demande_mauvais_di}
    Capture and crop page screenshot Sleep
    ...  screenshots/a_contentieux_demande_dossier_recours.png
    ...  css=.ui-state-error

    Saisir la demande  ${args_demande_valides}
    Sleep  2
    Capture and crop page screenshot Sleep
    ...  screenshots/a_contentieux_demande_dossier_recours_erreur_dossier_conteste.png
    ...  css=#content #formulaire

    # Capture de la synthèse d'un dossier d'instruction et d'un dossier d'infraction
    Depuis le contexte du dossier infraction  ${di_inf_1}
    Open All Fieldset Using Javascript  dossier_contentieux_toutes_infractions
    Capture and crop page screenshot Sleep  screenshots/a_synthese_dossier_infraction.png  css=#content

    Depuis le contexte du dossier recours  ${di_re_1}
    Open All Fieldset Using Javascript  dossier_contentieux_tous_recours
    Capture and crop page screenshot Sleep  screenshots/a_synthese_dossier_recours.png  css=#content


CE du paramétrage des groupes
    [Tags]  doc
    [Documentation]  L'objet de ce 'Test Case' est de faire les CE du
    ...  paramétrage des groupes, par profil et par utilisateur

    Depuis la page d'accueil  admin  admin

    Ajouter l'utilisateur  Baril Amélie  support@atreal.fr  abaril  abaril  VISUALISATION DA et DI  MARSEILLE

    Depuis l'onglet groupe du profil  VISUALISATION DA et DI
    Capture and crop page screenshot Sleep  screenshots/a_administration_om_profil_groupe.png
    ...    content

    Depuis l'onglet groupe de l'utilisateur  abaril

    Ajouter le groupe depuis l'onglet groupe de l'utilisateur  Autorisation ADS  true  true
    Ajouter le groupe depuis l'onglet groupe de l'utilisateur  Changement d'usage  false  true
    Ajouter le groupe depuis l'onglet groupe de l'utilisateur  Renseignement d'urbanisme  false  true
    Ajouter le groupe depuis l'onglet groupe de l'utilisateur  ERP  false  true

    Capture and crop page screenshot Sleep  screenshots/a_administration_om_utilisateur_groupe.png
    ...    content


CE des dossiers liés
    [Tags]  doc
    [Documentation]  L'objet de ce 'Test Case' est de faire les CE des
    ...  listings de l'onglet Dossiers Liés du DI

    Depuis la page d'accueil  instrpolycomm3  instrpolycomm3
    &{args_petitionnaire_autre_commune} =  Create Dictionary
    ...  particulier_nom=Beauchamps
    ...  particulier_prenom=Maurissette
    @{ref_cad_autre_commune} =  Create List  806  AB  25
    &{args_demande_autre_commune} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad_autre_commune}
    ${libelle_di_autre_commune} =  Ajouter la nouvelle demande  ${args_demande_autre_commune}  ${args_petitionnaire_autre_commune}
    Depuis la page d'accueil  guichet  guichet
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Beauchamps
    ...  particulier_prenom=Jeanette
    @{ref_cad} =  Create List  806  AB  25  A  30
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ${libelle_di} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}
    ${libelle_di_spaceless} =  Sans espace  ${libelle_di}
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Forest
    ...  particulier_prenom=David
    @{ref_cad} =  Create List  806  AB  01  A  50
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  terrain_references_cadastrales=${ref_cad}
    ${libelle_di2} =  Ajouter la nouvelle demande  ${args_demande}  ${args_petitionnaire}
    ${libelle_di2_spaceless} =  Sans espace  ${libelle_di2}
    ${libelle_da} =  Get Substring  ${libelle_di}  0  -2
    ${libelle_da_spaceless} =  Sans espace  ${libelle_da}
    ${libelle_da2} =  Get Substring  ${libelle_di2}  0  -2
    ${libelle_da_autre_commune} =  Get Substring  ${libelle_di_autre_commune}  0  -2
    ${libelle_di_autre_commune_spaceless} =  Sans espace  ${libelle_di_autre_commune}
    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${libelle_di}  accepter un dossier sans réserve
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    Depuis la page d'accueil  guichet  guichet
    ${libelle_di_modification} =  Ajouter la demande sur existant depuis le tableau de bord  ${libelle_di}  ${args_demande}
    ${libelle_di_modification_spaceless} =  Sans espace  ${libelle_di_modification}
    Depuis la page d'accueil  admin  admin
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label    dossier_autorisation_type_detaille    Recours contentieux
    Select From List By Label    om_collectivite    MARSEILLE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    autorisation_contestee    ${libelle_di}
    Click Button    css=#autorisation_contestee_search_button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain    css=#petitionnaire_principal_delegataire    Beauchamps Jeanette
    Sleep  1
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    ${libelle_di_re} =  Get Text  id=new_di
    ${libelle_di_re_spaceless} =  Sans espace  ${libelle_di_re}
    Depuis le contexte de nouvelle demande via l'URL
    Select From List By Label    dossier_autorisation_type_detaille    Recours contentieux
    Select From List By Label    om_collectivite    MARSEILLE
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    autorisation_contestee    ${libelle_di2}
    Click Button    css=#autorisation_contestee_search_button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain    css=#petitionnaire_principal_delegataire    Forest David
    Sleep  1
    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    ${libelle_di_re2} =  Get Text  id=new_di
    ${libelle_di_re_2spaceless} =  Sans espace  ${libelle_di_re2}
    Depuis l'onglet des messages du dossier d'instruction  ${libelle_di}
    Click On Link  Autorisation contestée
    Element Text Should Be  contenu  Cette autorisation a été contestée par le recours ${libelle_di_re_spaceless}.
    Depuis la page d'accueil  instrpoly  instrpoly
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_modification}
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di_autre_commune}
    Click On Submit Button In SubForm
    Valid Message Should Contain In Subform  Le dossier ${libelle_di_autre_commune_spaceless} a été lié.
    Click On Link  link_dossier_instruction_lie
    Page Title Should Be    Instruction > Dossiers D'instruction > ${libelle_di_autre_commune} BEAUCHAMPS MAURISSETTE
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_modification}
    Element Should Contain  sousform-dossier_lies  ${libelle_di_autre_commune}
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di_modification}
    Element Should Not Contain  sousform-dossier_lies  ${libelle_di_autre_commune}
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di2}
    Click On Submit Button In SubForm
    Valid Message Should Contain In Subform  Le dossier ${libelle_di2_spaceless} a été lié.
    Click On Link  link_dossier_instruction_lie
    Page Title Should Be    Instruction > Dossiers D'instruction > ${libelle_di2} FOREST DAVID
    On clique sur l'onglet  lien_dossier_dossier  Dossiers Liés
    Element Should Contain  sousform-dossier_lies  Aucun enregistrement.
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di_modification_spaceless}
    Click On Submit Button In SubForm
    Valid Message Should Contain In Subform  Le dossier ${libelle_di_modification_spaceless} a été lié.
    Click On Back Button In SubForm
    Element Should Contain  sousform-dossier_lies  ${libelle_di_modification}
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di2}
    Click Element  action-soustab-dossier_lies-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  dossier cible
    Input Text  dossier_cible  ${libelle_di_re2}
    Click On Submit Button In SubForm
    Valid Message Should Contain In Subform  Le dossier ${libelle_di_re2_spaceless} a été lié.
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet Dossiers Liés du dossier d'instruction  ${libelle_di2}
    Capture and crop page screenshot Sleep
    ...  screenshots/a_instruction_dossiers_lies.png
    ...  css=#sousform-lien_dossier_dossier



CE du paramétrage des logos
    [Documentation]  Captures d'écran concernant la gestion des logos.
    [Tags]  doc

    Depuis la page d'accueil  admin  admin
    Depuis le listing  om_logo
    Click On Add Button
    Capture and crop page screenshot Sleep  screenshots/a_parametrage_edition_logo.png
    ...    content
    Depuis le listing  om_logo
    Click Link  logopdf.png multi
    Capture and crop page screenshot Sleep  screenshots/a_parametrage_edition_logo_portlet.png
    ...  portlet-actions

CE de la géolocalisation automatique
    [Documentation]  Capture d'écran spécifique à la géolocalisation automatique des DI
    [Tags]  doc

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}
    Depuis la page d'accueil  admin  admin
    Ajouter la collectivité depuis le menu  Libreville  mono
    Ajouter le paramètre depuis le menu  departement  045  Libreville
    Ajouter le paramètre depuis le menu  commune  678  Libreville
    Ajouter le paramètre depuis le menu  insee  45678  Libreville
    Ajouter le paramètre depuis le menu  option_sig  sig_externe  Libreville
    Ajouter l'utilisateur depuis le menu  Trépanier Antoine  support@mail.fr  admingenlibreville  admingenlibreville  ADMINISTRATEUR GENERAL  Libreville

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Simard
    ...  particulier_prenom=Julienne
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZZ  0001
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Smith
    ...  particulier_prenom=John
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZZ  0003
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Durand
    ...  particulier_prenom=Eléonore
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZZ  0005
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV3} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Flynn
    ...  particulier_prenom=Andrew
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZZ  0006
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV4} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  admingenlibreville  admingenlibreville
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button
    Capture and crop page screenshot Sleep  screenshots/a_administration_geolocalisation_auto.png
    ...    content

    Supprimer le paramètre  option_sig
    Remove File  ..${/}dyn${/}sig.inc.php


CE du Widget RSS
    [Documentation]  Captures d'écran concernant le Widget Rss
    [Tags]  doc

    # Copy des fichiers de flux rss dans /app pour y avoir accés
    Copy Directory  ..${/}tests${/}binary_files${/}rss  ..${/}app${/}

    ${url_rss_doc} =  Set Variable  ${PROJECT_URL}app/rss/rss_doc.xml
    Depuis la page d'accueil  admin  admin

    # Création du widget

    # Depuis la page d'ajout d'un widget
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=0&advs_id=&premier=0&tricol=&valide=&retour=form
    Input Text  libelle  openADS - Actualités
    # Selection
    Select From List By Label  type  file - le contenu du widget provient d'un script sur le serveur
    Select From List By Label  script  rss
    Input Text  arguments  urls=${url_rss_doc}\nmode=client_side\nmax_item=3
    Click On Submit Button

    # Composition du tableau de bord du profil ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0&advs_id=&premier=0&tricol=-0&valide=&retour=form
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  openADS - Actualités
    Click On Submit Button
    ${id_widget_doc}=  Get Text  om_dashboard
    # Vérification des informations reçu
    Depuis la page d'accueil  admin  admin
    Capture and crop page screenshot Sleep  results/screenshots/ergonomie/a_widget_rss.png
    ...    .widget_rss

    # Suppression des fichiers de /app.
    Remove Directory  ..${/}app${/}rss  true

    # # Suppression des widget du tdb
    Go To  ${PROJECT_URL}/app/index.php?module=tab&obj=om_dashboard&premier=0&tricol=-0&advs_id=&valide=&style=tab&onglet=&
    Click Link  ${id_widget_doc}
    Click On Form Portlet Action  om_dashboard  supprimer
    Click On Submit Button

CE de l'indicateur de parcelle temporaire et du depot electronique
    [Documentation]  Capture d'écran spécifique a l'indicateur
    ...  de présence de parcelle temporaire sur les DI
    [Tags]  doc

    # On ajoute le DI sur lequel la capture sera prise
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Davinci
    ...  particulier_prenom=Leonard
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  depot_electronique=true
    ...  parcelle_temporaire=true
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di}
    # Capture parcelle temporaire
    Open Fieldset    dossier_instruction    localisation
    Wait Until Element Is Visible  parcelle_temporaire
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_parcelle_temporaire.png
    ...  css=#fieldset-form-dossier_instruction-localisation div
    # Capture depot_electronique
    Wait Until Element Is Visible  css=.bloc.dossier_petitionnaire
    Capture and crop page screenshot Sleep  screenshots/a_instruction_dossier_depot_electronique.png
    ...  css=fieldset#fieldset-form-dossier_instruction-dossier-d_instruction

CE du Widget Derniers dossiers déposés
    [Documentation]  Captures d'écran concernant le Widget Derniers dossiers déposés
    [Tags]  doc

    Depuis la page d'accueil  admin  admin

    # Paramétrage du widget
    Depuis le contexte du widget  derniers_dossiers_deposes
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments
    ...  codes_datd=PCI;PD\nfiltre=aucun\nfiltre_depot=guichet\nnombre_de_jours=15
    Click On Submit Button

    #Création de dossiers
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Small
    ...  particulier_prenom=Lennie
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Milton
    ...  particulier_prenom=George
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    ## Capture d'ecran
    # On ajoute le widget au tableau de bord des administrateur
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    Input Text  bloc  C1
    Select From List By Label  om_widget  Les derniers dossiers déposés
    Click On Submit Button
    Depuis la page d'accueil  admin  admin
    Capture and crop page screenshot Sleep  results/screenshots/ergonomie/a_widget_derniers_dossiers_deposes.png
    ...    .widget_derniers_dossiers_deposes

CE des messages manuels
    [Tags]  doc
    [Documentation]  Capture d'écran concernant les messages manuels


    Depuis la page d'accueil  admin  admin
    #Créer le contexte (Affectation automatique de l'instructeur polyvalent (utilisateur 2)
    #de l'agglo (niv 2) sur les dossiers de la collectivité de niveau 1)
    ${collectivite} =  Set Variable  MadScientist
    Ajouter la collectivité depuis le menu  ${collectivite}  mono
    #
    &{args_affectation} =  Create Dictionary
    ...  instructeur=Poly (H)
    ...  om_collectivite=${collectivite}
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    Ajouter l'affectation depuis le menu  ${args_affectation}

    #
    ${direction} =  Set Variable  Direction ME
    ${direction_code} =  Set Variable  ME
    ${div_1} =  Set Variable  subdivision ME1
    ${div_code_1} =  Set Variable  ME1
    Ajouter la direction depuis le menu  ${direction_code}  ${direction}
    ...  null  Chef A  null  null  ${collectivite}
    Ajouter la division depuis le menu  ${div_code_1}  ${div_1}  null
    ...  Chef A  null  null  ${direction}

    #En vu de pouvoir vérifier l'icone de message dans le listing des derniers dossiers
    #déposés, on ajoute le widget correspondant au tableau de bord INSTRUCTEUR
    Ajouter le droit depuis le menu  derniers_dossiers_deposes  INSTRUCTEUR
    Depuis le contexte du widget  derniers_dossiers_deposes
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments
    ...  codes_datd=PCI;PD\nfiltre=division\nfiltre_depot=guichet\nnombre_de_jours=15
    Click On Submit Button
    # On ajoute le widget au tableau de bord des instructeurs
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  INSTRUCTEUR
    Input Text  bloc  C1
    Select From List By Label  om_widget  Les derniers dossiers déposés
    Click On Submit Button
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu  dossier_message_ajouter  INSTRUCTEUR
    #Créer un nouveau dossier (affecté à l'utilisateur 2)
    ${utilisateur_2} =  Set Variable  Makise Kurisu
    Ajouter l'utilisateur  ${utilisateur_2}  support@atreal.fr  instrms  instrms  INSTRUCTEUR  ${collectivite}
    Ajouter l'instructeur depuis le menu  ${utilisateur_2}  ${div_1}  instructeur  ${utilisateur_2}
    #
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_2} (${div_code_1})
    ...  om_collectivite=${collectivite}
    ...  dossier_autorisation_type_detaille=Permis de démolir
    Ajouter l'affectation depuis le menu  ${args_affectation}
    #Création du dossier sur lequel un message manuel sera ajouté
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DESPRES
    ...  particulier_prenom=Sylvaine
    ...  om_collectivite=${collectivite}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${collectivite}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrms  instrms
    #Ajouter un message manuel au dossier par l'utilisateur 2 (collectivité de niveau 2)
    ${message} =  Set Variable  Message de l'instrms (collectivité niveau 1)
    ${dossier_message_2} =  Ajouter un message dans le dossier d'instruction  ${di}  ${message}

    # On vérifie que le listing associé au widget des derniers dossiers déposés
    # affiche bien un indicateur de message manuel pour le dossier
    # On clique sur le lien vers le listing
    Depuis la page d'accueil  instrms  instrms
    Click Link  css=.widget_derniers_dossiers_deposes .widget-footer a
    Page Title Should Be  Instruction > Dossiers Déposés
    # On vérifie la présence de l'indicateur
    Page Should Contain Element  css=div#tab-derniers_dossiers_deposes div.tab-container table.tab-tab tbody tr td.col-10 a span
    Capture and crop page screenshot Sleep  results/screenshots/a_instruction_dossier_message_form_ajouter.png
    ...    table.tab-tab

CE Gestion des pièces
    [Documentation]  Capture d'écran spécifique aux pièces (pièces, documents
    ...  et constitution du dossier final).
    [Tags]  doc

    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  id_avis_consultation_tacite  4  agglo

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=SALMON
    ...  particulier_prenom=Suzy
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=01/01/2018
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    # Créer des nomenclatures
    &{dnt_values} =  Create Dictionary
    ...  code=98
    ...  libelle=rescrit fiscal
    ...  document_numerise_type_categorie=Autre
    Ajouter le type de pièces  ${dnt_values}
    &{nomenclature_values} =  Create Dictionary
    ...  document_numerise_type=rescrit fiscal
    ...  dossier_instruction_type=PCI Initial
    ...  code=F2
    ${id_nomenclature} =  Ajouter une nomenclature de piece  ${nomenclature_values}
    &{nomenclature_values} =  Create Dictionary
    ...  document_numerise_type=rescrit fiscal
    ...  dossier_instruction_type=PCI Initial
    ...  code=F3
    ${id_nomenclature} =  Ajouter une nomenclature de piece  ${nomenclature_values}
    #charger des pièces
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=fichier_1.odt
    ...  document_numerise_type=arrêté
    ...  date_creation=04/06/2018
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.jpg
    ...  document_numerise_type=arrêté
    ...  date_creation=05/05/2018
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté
    ...  date_creation=15/03/2018
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=F3 | rescrit fiscal
    ...  date_creation=10/04/2018
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    #charger un document de travail
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.jpg
    ...  date_creation=05/05/2018
    ...  description=plan du terrain
    Ajouter un document de travail depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    #Faire des demandes de consultation pour inf, pour consu avec avis rendu
    # Pour conformité
    Ajouter une consultation depuis un dossier  ${di}  59.01 - Direction de l'Eau et de l'Assainissement
    #Rendre un avis à l'avis attendu
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  fichier_upload=testImportManuel.pdf
    Depuis la page d'accueil  consu  consu
    Rendre l'avis sur la consultation du dossier  ${di}  ${args_avis_consultation}
    #consultation avec Avis tacite
    Depuis la page d'accueil  admin  admin
    Ajouter une consultation depuis un dossier  ${di}  59.01 - Direction de l'Eau et de l'Assainissement
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Tacite
    Depuis la page d'accueil  consu  consu
    Rendre l'avis sur la consultation du dossier  ${di}  ${args_avis_consultation}
    #Avec avis attendu sans retour d'avis
    Depuis la page d'accueil  admin  admin
    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#service
    Select From List By Label  css=select#service  59.01 - SERAM
    Input Text  css=#date_envoi  03/02/2018
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées
    Click On Back Button In Subform
    #
    #Pour information
    Ajouter une consultation depuis un dossier  ${di}  59.12 - Direction de la Propreté Urbaine
    Click On Back Button In Subform
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=table.tab-tab
    ...  pour conformite
    Element Should Contain  css=table.tab-tab  pour information
    Element Should Contain  css=table.tab-tab  avec avis attendu
    #Valider et finaliser le rapport d'instruction
    Depuis le contexte du rapport d'instruction  ${di}
    Click On Submit Button In Subform
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Depuis le contexte du rapport d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La finalisation du document s'est effectuée avec succès.
    #
    Depuis la page d'accueil  instr  instr
    #On se place sur l'onglet de gestion des pièces du DI
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    #On bascule vers le dossier final
    Click Element  css=a.om-prev-icon.om-icon-16.toutes-les-pieces-16.right
    Sleep  1
    #
    Click Button  Sélectionner les pièces et documents recommandés
    @{locators_checkboxes_pieces_recommandees} =  Get WebElements  css=tr.dossier_final_piece_recommandee td.checkbox-dossier_final
    :FOR  ${locator}  IN  @{locators_checkboxes_pieces_recommandees}
    \  Checkbox Should Be Selected  ${locator}
    #
    #Cliquer sur Constituer le dossier final
    Click Element  name:constituer_dossier_final
    Wait Until Element Is Visible  css=.message.ui-widget.ui-corner-all.ui-state-highlight
    #Recharger et vérifier le précochage
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    #On clique sur le sous onglet correspondant au dossier final
    Click Element  css=a.om-prev-icon.om-icon-16.toutes-les-pieces-16.right
    Sleep  1
    # On prend la capture de la liste des pièces
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_dossier_final_form.png
    ...  css=#sousform-document_numerise

    # Formulaire d'ajout d'une pièce
    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Wait Until Element Is Visible  id=action-soustab-blocnote-message-ajouter
    Click Element  id=action-soustab-blocnote-message-ajouter
    Wait Until Element Is Visible  id=uid_upload
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_form_ajouter.png
    ...  css=#sousform-document_numerise

    # Listing des pièces
    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Wait Until Element Is Visible  id=action-soustab-blocnote-message-ajouter
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_tab.png
    ...  css=#sousform-document_numerise
    Click Element Until New Element
    ...  css=span.om-icon.om-icon-16.om-icon-fix.preview-16
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf
    Sleep  2
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_tab_preview.png
    ...  css=div.ui-dialog
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # Miniature de la pièce
    Mouse Over  xpath=//span[normalize-space(text()) = "20180505ARRT.jpg"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_tab_vignette.png
    ...  css=#sousform-document_numerise

    # Bouton et lien pour télécharger toutes les pièces dans une archive zip
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_btn_telecharger_archive.png
    ...  css=#zip_download_link
    Click Element  zip_download_link
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Êtes vous sûr de vouloir télécharger l'intégralité des pièces du dossier
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_lien_telecharger_archive.png
    ...  css=.ui-dialog

    # Listing des documents
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di}
    Capture and crop page screenshot Sleep  screenshots/a_instruction_documents_instruction_et_travail_tab.png
    ...  css=#sousform-document_numerise
    # Prévisu document d'instruction
    Click Element Until New Element
    ...  css=span.om-icon.om-icon-16.om-icon-fix.preview-16
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf
    Sleep  2
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_instruction_tab_preview.png
    ...  css=div.ui-dialog
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-instruction_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # Prévisu document de travail
    Click Element Until New Element
    ...  css=#sousform-document_travail span.om-icon.om-icon-16.om-icon-fix.preview-16
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog img
    Sleep  2
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_travail_tab_preview.png
    ...  css=div.ui-dialog
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # formulaire d'ajout des documents de travail
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Click Link  css=a#action-soustab-document_numerise-corner-ajouter
    Sleep  2
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_travail_form_ajouter.png
    ...  css=#sousform-document_numerise

    # Bouton et lien pour télécharger tous les documents dans une archive zip
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di}
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_documents_btn_telecharger_archive.png
    ...  css=#zip_download_link
    Click Element  css=#zip_download_link
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Êtes vous sûr de vouloir télécharger l'intégralité des documents du dossier
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_documents_lien_telecharger_archive.png
    ...  css=.ui-dialog

    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Click Element  css=div[data-view="document_numerise_telechargement"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#checkbox_select_all_none

    # Ecran sous onglet "Téléchargement"
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_telechargement.png
    ...  css=#sousform-document_numerise

    # Bouton télécharger du sous onglet "Téléchargement"
    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_telechargement_button.png
    ...  css=.ui-button

    # click sur tout selectionner
    Click Element  css=#checkbox_select_all_none
    # click sur télécharger
    Click Element  css=.ui-button

    Capture and crop page screenshot Sleep  screenshots/a_instruction_document_numerise_telechargement_lien_telecharger_archive.png
    ...  css=.ui-dialog

    Depuis la page d'accueil  admin  admin
    Supprimer le paramètre  id_avis_consultation_tacite

CE Suivi de la numérisation
    [Documentation]  Capture d'écran spécifique au suivi de la numérisation.
    [Tags]  doc

    Depuis la page d'accueil  admin  admin
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=FREECITY210
    ...  departement=013
    ...  commune=088
    ...  insee=13088
    ...  direction_code=Z
    ...  direction_libelle=Direction de FREECITY210
    ...  direction_chef=Chef
    ...  division_code=Z
    ...  division_libelle=Division Z
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Dixie Monty
    ...  guichet_om_utilisateur_email=dmonty@openads-test.fr
    ...  guichet_om_utilisateur_login=dmonty
    ...  guichet_om_utilisateur_pwd=dmonty
    ...  instr_om_utilisateur_nom=Cécile Boutot
    ...  instr_om_utilisateur_email=cboutot@openads-test.fr
    ...  instr_om_utilisateur_login=cboutot
    ...  instr_om_utilisateur_pwd=cboutot
    Isolation d'un contexte  ${isolation_values}
    Ajouter l'utilisateur depuis le menu  Normand Duval  nduval@openads-test.fr  nduval  nduval  CELLULE SUIVI  ${isolation_values.om_collectivite_libelle}
    Ajouter l'utilisateur depuis le menu  Florence Bourque  fbourque@openads-test.fr  fbourque  fbourque  QUALIFICATEUR  ${isolation_values.om_collectivite_libelle}
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

    # Ajout du dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire&Co
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Martin
    ...  personne_morale_prenom=Nicolas
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${di} =  Sans espace  ${libelle_di}
    &{args_petitionnaire_2} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Cailot
    ...  particulier_prenom=Ophelia
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    &{args_demande_2} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${isolation_values.om_collectivite_libelle}
    ${libelle_di_2} =  Ajouter la demande par WS  ${args_demande_2}  ${args_petitionnaire_2}
    ${di_2} =  Sans espace  ${libelle_di_2}

    Depuis la page d'accueil  nduval  nduval

    # Récupération du suivi des dossiers d'instruction
    Go To Submenu In Menu  numerisation  num_dossier_recuperation
    Click On Submit Button
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_dossier_recuperation.png
    ...  content

    # Créer un bordereau
    Depuis le listing  num_bordereau
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_bordereau_tab.png
    ...  content
    Click On Add Button
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_bordereau_form_ajout.png
    ...  content
    &{args_num_bordereau_1} =  Create Dictionary
    ...  envoi=${date_ddmmyyyy}
    ${num_bordereau} =  Ajouter le bordereau de numérisation  ${args_num_bordereau_1}
    ${libelle_num_bordereau} =  Catenate  SEPARATOR=  BOR_  ${DATE_FORMAT_YYYY-MM-DD}

    # Associer les dossiers à un bordereau
    Depuis le listing  num_dossier_a_attribuer
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_dossier_a_attribuer_tab.png
    ...  content
    Depuis le contexte du suivi de dossier  num_dossier_a_attribuer  ${di}
    Select From List By Label  num_bordereau  ${libelle_num_bordereau}
    Highlight heading  css=select#num_bordereau
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_dossier_a_attribuer_form_modif_bordereau.png
    ...  content
    Click On Submit Button

    # Transmettre un bordereau à la cellule de numérisation
    Depuis le contexte du bordereau de numérisation  ${libelle_num_bordereau}  libellé
    Highlight heading  css=a#action-form-num_bordereau-edition-pdf
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_bordereau_form_consult_edition.png
    ...  content

    Depuis le listing  num_bordereau
    Highlight heading  css=a#action-tab-num_bordereau-left-imprimer-${num_bordereau}
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_bordereau_tab_edition.png
    ...  content

    # Retour du bordereau de la cellule de numérisation par lot
    Depuis le contexte du bordereau de numérisation  ${libelle_num_bordereau}  libellé
    Highlight heading  css=a#action-form-num_bordereau-retour_num
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_bordereau_form_consult_retournum.png
    ...  content
    Click On Form Portlet Action  num_bordereau  retour_num  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Button  Confirmer
    On clique sur l'onglet  num_dossier  Suivi Des Dossiers Du Bordereau
    Input Text  css=span#recherche_onglet form input#recherchedyn  ${di}
    Highlight heading  css=th.title col-9
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_bordereau_form_onglet_num_dossier.png
    ...  content

    # Retour du bordereau de la cellule de numérisation par suivi
    Attribution d'un suivi de dossier sur un bordereau  ${di_2}  ${libelle_num_bordereau}
    Depuis le listing  num_dossier_a_numeriser
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_dossier_a_numeriser_tab.png
    ...  content
    Depuis le contexte du suivi de dossier  num_dossier_a_numeriser  ${di_2}
    Input Text  datenum  ${date_ddmmyyyy}
    Highlight heading  css=input#datenum
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_dossier_a_numeriser_form_datenum.png
    ...  content

    # Modifier les caractéristiques d’un suivi de dossier d'instruction numérisé
    Depuis le listing  num_dossier_traite
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_dossier_traite_tab.png
    ...  content
    Depuis le contexte du suivi de dossier  num_dossier_traite  ${di}
    Highlight heading  css=fieldset#fieldset-form-num_dossier_traite--detail-
    Capture and crop page screenshot Sleep  screenshots/a_suivi_numerisation_num_dossier_traite_form_pages.png
    ...  content

CE de la commune associée au dossier lors d'une nouvelle demande

    [Documentation]  Capture d'écran spécifique à la commune associée au dossier lors d'une nouvelle
    ...  demande
    [Tags]  doc

    # En tant qu'admin
    Depuis la page d'accueil  admin  admin

    # Permet le même comportement du test qu'il soit exécuté en runone ou runall
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # isole le contexte du test (création d'une collectivité)
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=LIBRECOM
    ...  departement=013
    ...  commune=095
    ...  insee=13095
    ...  direction_code=X
    ...  direction_libelle=Direction de LIBRECOM
    ...  direction_chef=Chef
    ...  division_code=X
    ...  division_libelle=Division X
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Alain Posteur
    ...  guichet_om_utilisateur_email=aposteur@openads-test.fr
    ...  guichet_om_utilisateur_login=aposteur
    ...  guichet_om_utilisateur_pwd=aposteur
    ...  instr_om_utilisateur_nom=Abdel Ledba
    ...  instr_om_utilisateur_email=aledba@openads-test.fr
    ...  instr_om_utilisateur_login=aledba
    ...  instr_om_utilisateur_pwd=aledba
    Isolation d'un contexte  ${isolation_values}
    &{isolation_values} =  Create Dictionary
    ...  om_collectivite_libelle=LOINCOM
    ...  departement=796
    ...  commune=095
    ...  insee=79695
    ...  direction_code=Y
    ...  direction_libelle=Direction de LOINCOM
    ...  direction_chef=Chef
    ...  division_code=Y
    ...  division_libelle=Division Y
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Olice Ecilo
    ...  guichet_om_utilisateur_email=olicelecilo@openads-test.fr
    ...  guichet_om_utilisateur_login=oecilo
    ...  guichet_om_utilisateur_pwd=oecilo
    ...  instr_om_utilisateur_nom=Oliot Toilo
    ...  instr_om_utilisateur_email=oliottoilo@openads-test.fr
    ...  instr_om_utilisateur_login=otoilo
    ...  instr_om_utilisateur_pwd=otoilo
    Isolation d'un contexte  ${isolation_values}


    #-- importer des communes via l'import spécifique
    Depuis l'import spécifique   commune
    ${import_communes_file} =  Set Variable  import_specific_communes_libre.csv
    Add File  fic1  ${import_communes_file}
    Click On Submit Button In Import CSV
    Résultat de l'import doit contenir  41 ligne(s) dans le fichier dont :
    Résultat de l'import doit contenir  - 1 ligne(s) d'entête
    Résultat de l'import doit contenir  - 39 ligne(s) insérée(s)
    Résultat de l'import doit contenir  - 0 ligne(s) rejetée(s)
    Résultat de l'import doit contenir  - 1 ligne(s) vide(s)

    #-- ajouter manuellement une commune en saisissant une date de validité dans le passé
    &{expiredcom_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=45645
    ...  reg=45
    ...  dep=45
    ...  arr=645
    ...  tncc=0
    ...  ncc=Commune test (ancienne)
    ...  nccenr=Commune test (ancienne)
    ...  libelle=Commune test (ancienne)
    ...  can=45
    ...  comparent=
    ...  om_validite_debut=01/01/2020
    ...  om_validite_fin=01/02/2020
    Ajouter commune avec dates validité  ${expiredcom_values}
    # ajouter manuellement une commune en saisissant une date de validité dans le futur
    ${yyyy} =  Get Time  year
    ${mm} =  Get Time  month
    ${dd} =  Get Time  day
    ${date_courante} =  Catenate  SEPARATOR=/  ${dd}  ${mm}  ${yyyy}
    ${yyyy} =  Evaluate  ${yyyy}+1
    ${date_futur} =  Catenate  SEPARATOR=/  ${dd}  ${mm}  ${yyyy}
    &{futurcom_values} =  Create Dictionary
    ...  typecom=COM
    ...  com=46646
    ...  reg=46
    ...  dep=46
    ...  arr=646
    ...  tncc=0
    ...  ncc=FUTURCOM
    ...  nccenr=Futurcom
    ...  libelle=Futurcom
    ...  can=46
    ...  comparent=
    ...  om_validite_debut=${date_futur}
    Ajouter commune avec dates validité  ${futurcom_values}

    # En tant que guichet unique de LIBRECOM
    Depuis la page d'accueil  aposteur  aposteur

    # activer l'option dossier_commune
    Depuis la page d'accueil  admin  admin
    # pour l'utilisateur admin
    Ajouter le paramètre depuis le menu  option_dossier_commune  true  agglo
    # pour les autres utilisateurs
    Ajouter le paramètre depuis le menu  option_dossier_commune  true  LIBRECOM
    Ajouter le paramètre depuis le menu  option_dossier_commune  true  LOINCOM

    # En tant que guichet unique de LIBRECOM
    Depuis la page d'accueil  aposteur  aposteur

    # rechercher une commune
    Depuis le contexte de nouvelle demande via l'URL
    Input Text  css=#autocomplete-commune-search  13904
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=ul.ui-autocomplete li.ui-menu-item a  13904 - LibreCom 4e Arrondissement

    # capturer le résultat de la recherche de commune
    Highlight heading  css=#autocomplete-commune-search
    Capture and crop page screenshot Sleep  screenshots/a_guichet_unique_nouvelle_demande_saisie_commune.png
    ...  content

    # sélectionner une commune
    Click Element Until No More Element  css=ul.ui-autocomplete li.ui-menu-item a

    # sélectionner la collectivité, le DAtd
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lacharité
    ...  particulier_prenom=Juliette
    Ajouter la nouvelle demande depuis le menu sans validation du formulaire  ${args_demande}  ${args_petitionnaire}

    # saisir une date de demande dans le passé
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  css=input#date_demande  01/01/1980
    Simulate Event  css=input#date_demande  change

    # rechercher la même commune et ne pas la trouver
    Input Text  css=#autocomplete-commune-search  13904
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain
    ...  css=ul.ui-autocomplete li.ui-menu-item a  Aucun résultat

    # capturer l'absence de résultat pour la même commune avec une date de demande dans le passé
    Highlight heading  css=#autocomplete-commune-search
    Highlight heading  css=#date_demande
    Capture and crop page screenshot Sleep  screenshots/a_guichet_unique_nouvelle_demande_saisie_commune_date_demande.png
    ...  content
    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter Ou Modifier le paramètre depuis le menu  ${om_param}
    # pour les autres utilisateurs
    &{om_param} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=LIBRECOM
    Ajouter Ou Modifier le paramètre depuis le menu  ${om_param}
    &{om_param} =  Create Dictionary
    ...  libelle=option_dossier_commune
    ...  valeur=false
    ...  om_collectivite=LOINCOM
    Ajouter Ou Modifier le paramètre depuis le menu  ${om_param}

CE prise en compte métier
    [Documentation]  Capture d'écran spécifique à la prise en compte métier sur un DI.
    [Tags]  doc

    Depuis la page d'accueil  admin  admin

    # Ajoute l'action et l'événement pour changer la prise en compte métier
    &{args_action} =  Create Dictionary
    ...  action=changer_pec
    ...  libelle=Changer PeC
    ...  regle_pec_metier=pec_metier
    Ajouter l'action depuis le menu  ${args_action}
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement} =  Create Dictionary
    ...  libelle=300 - Prise en compte métier
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  action=Changer PeC
    ...  etat=delai de notification envoye
    ...  pec_metier=Pris en compte
    Ajouter l'événement depuis le menu  ${args_evenement}

    # Ajout du dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Meilleur
    ...  particulier_prenom=Zoé
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${libelle_di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Ajouter une instruction au DI  ${libelle_di}  300 - Prise en compte métier

    Depuis le formulaire de modification du dossier d'instruction  ${libelle_di}
    Highlight heading  css=#pec_metier
    Capture and crop page screenshot Sleep  screenshots/a_instruction_pec.png
    ...  css=#fieldset-form-dossier_instruction-qualification

CE notification demandeurs
    [Documentation]  Capture d'écran spécifique à la notification des demandeurs.
    [Tags]  doc

    Depuis la page d'accueil  admin  admin

    # paramètrage du titre et du message de notification
    &{om_param} =  Create Dictionary
    ...  libelle=parametre_courriel_type_titre
    ...  valeur=[openADS] Notification concernant votre dossier
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    &{om_param} =  Create Dictionary
    ...  libelle=parametre_courriel_type_message
    ...  valeur=Bonjour, veuillez prendre connaissance du(des) document(s) suivant(s) :\n [LIEN_TELECHARGEMENT_DOCUMENT]\n[LIEN_TELECHARGEMENT_ANNEXE]
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # lettretype
    &{args_lettretype} =  Create Dictionary
    ...  id=test_NOTIF
    ...  libelle=Test
    ...  sql=Aucune REQUÊTE
    ...  titre=&idx, &destinataire, aujourdhui&aujourdhui, datecourrier&datecourrier, &departement
    ...  corps=Ceci est un document
    ...  actif=true
    ...  collectivite=MARSEILLE
    Ajouter la lettre-type depuis le menu  &{args_lettretype}

    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement1} =  Create Dictionary
    ...  libelle=EX_NOTIF_DOC
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  notification=Notification manuelle avec annexe
    Ajouter l'événement depuis le menu  ${args_evenement1}

    &{args_evenement2} =  Create Dictionary
    ...  libelle=EX_NOTIF_AUTO_DOC
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  notification=Notification automatique
    Ajouter l'événement depuis le menu  ${args_evenement2}

    # Nouveau dossier sur lequel on va tester l'affichage de la notification des demandeurs
    &{args_petitionnaire_principal} =  Create Dictionary
    ...  particulier_nom=Cressac
    ...  particulier_prenom=Véronique
    ...  om_collectivite=MARSEILLE
    ...  courriel=vcressac@notif.fr
    ...  notification=t

    &{args_petitionnaire1} =  Create Dictionary
    ...  particulier_nom=Charpie
    ...  particulier_prenom=Aimé
    ...  om_collectivite=MARSEILLE
    ...  courriel=caime@notif.fr
    ...  notification=t

    &{args_autres_demandeurs} =  Create Dictionary
    ...  petitionnaire=${args_petitionnaire1}

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  depot_electronique=true
    ${di_notif_auto1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire_principal}  ${args_autres_demandeurs}

    # Capture d'écran du tableau de suivi
    Ajouter une instruction au DI  ${di_notif_auto1}  EX_NOTIF_AUTO_DOC
    Click Element  link:EX_NOTIF_AUTO_DOC
    Wait Until Element Is Visible  css=#fieldset-sousform-instruction-suivi-notification
    Capture and crop page screenshot Sleep  screenshots/a_suivi_notification_demandeur.png
    ...  css=#fieldset-sousform-instruction-suivi-notification
    # notification de catégorie mail pour avoir le formulaire de choix des demandeurs
    &{om_param} =  Create Dictionary
    ...  libelle=option_notification
    ...  valeur=mail
    ...  om_collectivite=MARSEILLE
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Capture du formulaire de saisie des demanduuers avec annexe
    Ajouter une instruction au DI  ${di_notif_auto1}  EX_NOTIF_DOC
    Click Element  link:EX_NOTIF_DOC
    Click On SubForm Portlet Action  instruction  overlay_notification_manuelle  modale
    Capture and crop page screenshot Sleep  screenshots/a_form_saisie_demandeur_notification.png
    ...  css=#sousform-instruction_notification_manuelle

    # Suppression du paramétre
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification
    ...  click_value=MARSEILLE
    Supprimer le paramètre (surcharge)  ${param_args}

CE sous-dossier
    [Documentation]  Capture d'écran spécifique à la mise en place de sous dossier.
    [Tags]  doc

    # On créé un type deux types de sous dossier un avec un type de demande associé
    # et pas l'autre.
    Depuis la page d'accueil  admin  admin
    @{di_compatibles} =    Create List
    ...    CU - P - Certificat d'urbanisme - Initial
    &{args_type_di} =  Create Dictionary
    ...  code=SD1
    ...  libelle=Exemple Sous Dossier 1
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    Ajouter type de dossier d'instruction  ${args_type_di}
    &{args_type_di} =  Create Dictionary
    ...  code=SD1
    ...  libelle=Exemple Sous Dossier 2
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    ${args_type_di.id} =  Ajouter type de dossier d'instruction  ${args_type_di}

    &{args_demande_type} =  Create Dictionary
    ...    code=TESTSD2
    ...    libelle=Demande Exemple SD2
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=CU (Certificat d'urbanisme)
    ...    demande_nature=Dossier existant
    ...    dossier_instruction_type=Exemple Sous Dossier 2
    ...    evenement=Notification de delai
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}

    # activation de mode service consulté, pour afficher l'onglet des sous-dossiers
    &{om_param} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Ajout d'un dossier compatible et capture d'écran de l'onglet sous-dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Exemple
    ...  particulier_prenom=Sous Dossier
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${dossier_parent} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Capture and crop page screenshot Sleep  screenshots/a_instruction_sous_dossier.png
    ...  css=div#content
    # Ajout d'un sous-dossier et caprure de son contenu
    Ajouter le sous-dossier au dossier  ${args_type_di.id}
    Capture and crop page screenshot Sleep  screenshots/a_instruction_consultation_sous_dossier.png
    ...  css=div#content

    # Réinitialisation des paramètres
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_mode_service_consulte
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}


CE widget Compteur Signatures
    [Documentation]  Capture d'écran spécifique au widget de compteur de signatures électronique.
    [Tags]  doc

    # Copie le fichier de configuration pour le connecteur test du parapheur
    Copy File  ..${/}tests${/}binary_files${/}electronicsignature_test${/}electronicsignature.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin

    # Isolation du contexte
    &{collectivite_values} =  Create Dictionary
    ...  om_collectivite_libelle=Collectivité-DOC-CPTSIGN
    ...  departement=019
    ...  commune=001
    ...  insee=19001
    ...  direction_code=G
    ...  direction_libelle=Direction de Collectivité-DOC-CPTSIGN
    ...  direction_chef=Chef
    ...  division_code=G
    ...  division_libelle=Division G
    ...  division_chef=Chef
    ...  guichet_om_utilisateur_nom=Rean Joule
    ...  guichet_om_utilisateur_email=rjoule@openads-test.fr
    ...  guichet_om_utilisateur_login=rjoule
    ...  guichet_om_utilisateur_pwd=rjoule
    ...  instr_om_utilisateur_nom=Bector Hlumberg
    ...  instr_om_utilisateur_email=bhlumberg@openads-test.fr
    ...  instr_om_utilisateur_login=bhlumberg
    ...  instr_om_utilisateur_pwd=bhlumberg
    Isolation d'un contexte  ${collectivite_values}
    Set Suite Variable  ${collectivite_values}

    # Ajout des sinataires
    &{args_signataire} =  Create Dictionary
    ...  civilite=Monsieur
    ...  nom=Signataire-DOC-CPTSIGN-nom
    ...  prenom=Signataire-DOC-CPTSIGN-prénom
    ...  qualite=Signataire-DOC-CPTSIGN-qualité
    ...  signature=X
    ...  defaut=false
    ...  om_collectivite=Collectivité-DOC-CPTSIGN
    ...  email=signataire-doc-cptsign@test.test
    Ajouter le signataire depuis le menu  ${args_signataire}

    # ajoute un compteur 'signatures' pour la collectivité 'Collectivité-DOC-CPTSIGN'
    &{args_compteur} =  Create Dictionary
    ...  code=signatures
    ...  description=Nombre de signatures
    ...  quantite=450
    ...  alerte=80
    ...  quota=500
    ...  om_collectivite=Collectivité-DOC-CPTSIGN
    ...  om_validite_debut=02/02/2022
    ${compteur_id} =  Ajouter compteur avec dates validité  ${args_compteur}
    La page ne doit pas contenir d'erreur

    # ajout d'un administrateur fonctionnel pour la collectivité 'Collectivité-DOC-CPTSIGN'
    Ajouter l'utilisateur depuis le menu  Admin DOC-CPTSIGN
    ...  acptsign@openads-test.fr  acptsign  acptsign  ADMINISTRATEUR FONCTIONNEL
    ...  ${collectivite_values.om_collectivite_libelle}

    # ajout d'un widget de compteur signatures au tableau de bord de l'administrateur fonctionnel
    ${om_widget_libelle} =  Set Variable  Signatures
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=compteur_signatures
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=ADMINISTRATEUR FONCTIONNEL
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}

    # vérifie l'affichage du widget sur le tableau de bord de l'administrateur fonctionnel
    Depuis la page d'accueil  acptsign  acptsign
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  450 / 500 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  50 / 500 signatures
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures  90 %
    Element Should Contain  css=#widget_${om_dashboard}.widget_compteur_signatures
    ...  Attention vous approchez de la limite de votre quota de signatures. Afin de l'augmenter, cliquez ici

    Capture and crop page screenshot Sleep  screenshots/a_widget_compteur_signatures.png
    ...  css=#widget_${om_dashboard}.widget_compteur_signatures
