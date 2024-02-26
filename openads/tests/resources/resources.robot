*** Settings ***
Documentation  Ressources (librairies, keywords et variables)

# Librairies
Library  calendar

# Mots-clefs framework
Library  openmairie.robotframework.Library

# Mots-clefs métier
Resource  override_openmairie_robotframework_library.robot
#Resource  app${/}gen${/}gen_resources.robot
Resource  app${/}acteur.robot
Resource  app${/}action.robot
Resource  app${/}affectation.robot
Resource  app${/}architecte.robot
Resource  app${/}arrondissement.robot
Resource  app${/}avis_decision.robot
Resource  app${/}bible.robot
Resource  app${/}blocnote.robot
Resource  app${/}bordereau.robot
Resource  app${/}cerfa.robot
Resource  app${/}commission.robot
Resource  app${/}commission_type.robot
Resource  app${/}commune.robot
Resource  app${/}compteur.robot
Resource  app${/}consultation.robot
Resource  app${/}contrainte.robot
Resource  app${/}contrainte_parametree.robot
Resource  app${/}demande.robot
Resource  app${/}demande_type.robot
Resource  app${/}demandeur.robot
Resource  app${/}departement.robot
Resource  app${/}direction.robot
Resource  app${/}division.robot
Resource  app${/}document_numerise.robot
Resource  app${/}document_numerise_type.robot
Resource  app${/}document_numerise_type_categorie.robot
Resource  app${/}dossier_autorisation.robot
Resource  app${/}dossier_autorisation_type.robot
Resource  app${/}dossier_autorisation_type_detaille.robot
Resource  app${/}dossier_commission.robot
Resource  app${/}dossier_infraction.robot
Resource  app${/}dossier_instruction.robot
Resource  app${/}dossier_instruction_type.robot
Resource  app${/}dossier_message.robot
Resource  app${/}dossier_recours.robot
Resource  app${/}etat.robot
Resource  app${/}evenement.robot
Resource  app${/}export_import.robot
Resource  app${/}famille_travaux.robot
Resource  app${/}formulaire.robot
Resource  app${/}habilitation_tiers_consulte.robot
Resource  app${/}import_specific.robot
Resource  app${/}instructeur.robot
Resource  app${/}instruction.robot
Resource  app${/}instruction_notification.robot
Resource  app${/}lien_document_n_type_d_i_t.robot
Resource  app${/}lien_id_interne_uid_externe.robot
Resource  app${/}lien_om_utilisateur_groupe.robot
Resource  app${/}lot.robot
Resource  app${/}maildump.robot
Resource  app${/}menu.robot
Resource  app${/}motif_consultation.robot
Resource  app${/}nature_travaux.robot
Resource  app${/}num_bordereau.robot
Resource  app${/}num_dossier.robot
Resource  app${/}om_droit.robot
Resource  app${/}om_parametre.robot
Resource  app${/}om_profil.robot
Resource  app${/}om_utilisateur.robot
Resource  app${/}om_widget.robot
Resource  app${/}phase.robot
Resource  app${/}quartier.robot
Resource  app${/}service.robot
Resource  app${/}sig_contrainte.robot
Resource  app${/}sig_couche.robot
Resource  app${/}sig_groupe.robot
Resource  app${/}sig_sousgroupe.robot
Resource  app${/}signataire.robot
Resource  app${/}statistique.robot
Resource  app${/}suivi.robot
Resource  app${/}task.robot
Resource  app${/}taxe_amenagement.robot
Resource  app${/}tiers_consulte.robot
Resource  app${/}utils.robot

*** Variables ***
${SERVER}          localhost
${PROJECT_NAME}    openads
${BROWSER}         firefox
${DELAY}           0
${ADMIN_USER}      admin
${ADMIN_PASSWORD}  admin
${PROJECT_URL}     http://${SERVER}/${PROJECT_NAME}/
${PATH_BIN_FILES}  ${EXECDIR}${/}binary_files${/}
${TITLE}           :: openMairie :: openADS
${SESSION_COOKIE}  openads
${TIMEOUT}         10 sec
${RETRY_INTERVAL}  0.4 sec

*** Keywords ***
For Suite Setup
    Reload Library  openmairie.robotframework.Library
    # Les keywords définit dans le resources.robot sont prioritaires
    Set Library Search Order  resources  override_openmairie_robotframework_library
    Ouvrir le navigateur
    Tests Setup

For Suite Teardown
    Fermer le navigateur

