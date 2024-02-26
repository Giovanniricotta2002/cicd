*** Settings ***
Documentation  Test de la gestion d'incomplétude

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Cas d'utilisation complet d'une incomplétude jusqu'à la complétude
    [Documentation]  Vérification du comportement des données d'un dossier d'instruction lors d'une incomplétude :
    ...  * l'état
    ...  * le délai
    ...  * la date limite d'instruction
    ...  * l'événement suivant tacite

    Depuis la page d'accueil  admin  admin
    Constitution du Workflow de gestion d'une incomplétude  190

    # Ajout du dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DESJARDINS
    ...  particulier_prenom=Laurent
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Récupèration des données à comparer
    Depuis le contexte du dossier d'instruction  ${di}
    ${etat_ph1} =  Get Text  etat
    ${date_complet_ph1} =  Get Text  date_complet
    ${delai_ph1} =  Get Text  delai
    ${date_limite_ph1} =  Get Text  date_limite
    ${evenement_suivant_tacite_ph1} =  Get Value  evenement_suivant_tacite
    ${incompletude_ph1} =  Get Value  incompletude
    ${incomplet_notifie_ph1} =  Get Value  incomplet_notifie
    ${date_limite_incompletude_ph1} =  Get Value  date_limite_incompletude
    ${evenement_suivant_tacite_incompletude_ph1} =  Get Value  evenement_suivant_tacite_incompletude
    ${etat_pendant_incompletude_ph1} =  Get Value  etat_pendant_incompletude
    ${delai_incompletude_ph1} =  Get Value  delai_incompletude

    # Ajout de l'instruction d'incomplétude
    Ajouter une instruction au DI et la finaliser  ${di}  ${incompletude_libelle}

    # Récupèration des données à comparer
    Depuis le contexte du dossier d'instruction  ${di}
    ${etat_ph2} =  Get Text  etat
    ${date_complet_ph2} =  Get Text  date_complet
    ${delai_ph2} =  Get Text  delai
    ${date_limite_ph2} =  Get Text  date_limite
    ${evenement_suivant_tacite_ph2} =  Get Value  evenement_suivant_tacite
    ${incompletude_ph2} =  Get Value  incompletude
    ${incomplet_notifie_ph2} =  Get Value  incomplet_notifie
    ${date_limite_incompletude_ph2} =  Get Value  date_limite_incompletude
    ${evenement_suivant_tacite_incompletude_ph2} =  Get Value  evenement_suivant_tacite_incompletude
    ${etat_pendant_incompletude_ph2} =  Get Value  etat_pendant_incompletude
    ${delai_incompletude_ph2} =  Get Value  delai_incompletude
    # Vérification des données par rapport à la phase précèdente
    Should Not Be Equal  ${etat_ph2}  ${etat_ph1}
    Should Be Equal  ${date_complet_ph2}  ${date_complet_ph1}
    Should Be Equal  ${delai_ph2}  ${delai_ph1}
    Should Be Equal  ${date_limite_ph2}  ${date_limite_ph1}
    Should Be Equal  ${evenement_suivant_tacite_ph2}  ${evenement_suivant_tacite_ph1}
    Should Not Be Equal  ${incompletude_ph2}  ${incompletude_ph1}
    Should Be Equal  ${incomplet_notifie_ph2}  ${incomplet_notifie_ph1}
    Should Be Equal  ${date_limite_incompletude_ph2}  ${date_limite_incompletude_ph1}
    Should Be Equal  ${evenement_suivant_tacite_incompletude_ph2}  ${evenement_suivant_tacite_incompletude_ph1}
    Should Not Be Equal  ${etat_pendant_incompletude_ph2}  ${etat_pendant_incompletude_ph1}
    Should Be Equal  ${delai_incompletude_ph2}  ${delai_incompletude_ph1}
    # Vérification des valeurs
    Should Be Equal  ${etat_ph2}  ${incompletude_libelle}
    Should Be Equal  ${incompletude_ph2}  t

    # Suivi des dates : modification de la date de notification qui ne déclenche pas l'événement d'incomplétude notifié car paramétré sur la date de retour signature (ce qui n'était pas possible avant la version 4.14)
    Depuis l'instruction du dossier d'instruction  ${di}  ${incompletude_libelle}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Page Should Not Contain  ${incompletude_notifiee_libelle}
    # Suivi des dates : modification de la date de signature qui ne déclenche pas l'événement d'incomplétude notifié car date saisie hors délai
    Depuis l'instruction du dossier d'instruction  ${di}  ${incompletude_libelle}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    ${date_35d} =  Add Time To Date  ${date_ddmmyyyy}  35 days  %d/%m/%Y  False  %d/%m/%Y
    Input Datepicker  date_retour_signature  ${date_35d}
    Click On Submit Button In Subform
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Page Should Not Contain  ${incompletude_notifiee_libelle}
    # Vide la date de retour signature pour exécuter la suite du scénario
    Depuis l'instruction du dossier d'instruction  ${di}  ${incompletude_libelle}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Text  date_retour_signature  ${EMPTY}
    Click On Submit Button In Subform
    # Suivi des dates : modification de la date de signature qui ne déclenche pas l'événement d'incomplétude notifié
    Depuis l'instruction du dossier d'instruction  ${di}  ${incompletude_libelle}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    ${date_5d} =  Add Time To Date  ${date_ddmmyyyy}  5 days  %d/%m/%Y  False  %d/%m/%Y
    Input Datepicker  date_retour_signature  ${date_5d}
    Click On Submit Button In Subform
    Depuis l'onglet instruction du dossier d'instruction  ${di}
    Page Should Contain  ${incompletude_notifiee_libelle}

    # Récupèration des données à comparer
    Depuis le contexte du dossier d'instruction  ${di}
    ${etat_ph3} =  Get Text  etat
    ${date_complet_ph3} =  Get Text  date_complet
    ${delai_ph3} =  Get Text  delai
    ${date_limite_ph3_bf} =  Get Value  date_limite
    ${date_limite_ph3} =  Convert Date  ${date_limite_ph3_bf}  date_format=%Y-%m-%d  result_format=%d/%m/%Y
    ${evenement_suivant_tacite_ph3} =  Get Value  evenement_suivant_tacite
    ${incompletude_ph3} =  Get Value  incompletude
    ${incomplet_notifie_ph3} =  Get Value  incomplet_notifie
    ${date_limite_incompletude_ph3} =  Get Text  date_limite_incompletude
    ${evenement_suivant_tacite_incompletude_ph3} =  Get Value  evenement_suivant_tacite_incompletude
    ${etat_pendant_incompletude_ph3} =  Get Value  etat_pendant_incompletude
    ${delai_incompletude_ph3} =  Get Value  delai_incompletude
    # Vérification des données par rapport à la phase précèdente
    Should Not Be Equal  ${etat_ph3}  ${etat_ph2}
    Should Not Be Equal  ${date_complet_ph3}  ${date_complet_ph2}
    Should Be Equal  ${delai_ph3}  ${delai_ph2}
    Should Be Equal  ${date_limite_ph3}  ${date_limite_ph2}
    Should Be Equal  ${evenement_suivant_tacite_ph3}  ${evenement_suivant_tacite_ph2}
    Should Be Equal  ${incompletude_ph3}  ${incompletude_ph2}
    Should Not Be Equal  ${incomplet_notifie_ph3}  ${incomplet_notifie_ph2}
    Should Not Be Equal  ${date_limite_incompletude_ph3}  ${date_limite_incompletude_ph2}
    Should Not Be Equal  ${evenement_suivant_tacite_incompletude_ph3}  ${evenement_suivant_tacite_incompletude_ph2}
    Should Be Equal  ${etat_pendant_incompletude_ph3}  ${etat_pendant_incompletude_ph2}
    Should Not Be Equal  ${delai_incompletude_ph3}  ${delai_incompletude_ph2}
    # Vérification des valeurs
    Element Should Not Be Visible  date_complet
    Should Be Equal  ${date_complet_ph3}  ${EMPTY}
    Should Be Equal  ${etat_ph3}  ${incompletude_notifiee_libelle}
    Should Be Equal  ${incomplet_notifie_ph3}  t
    Should Be Equal  ${delai_incompletude_ph3}  3

    # Ajout de l'instruction de dépôt de pièce complétaire
    ${date_10d} =  Add Time To Date  ${date_ddmmyyyy}  10 days  %d/%m/%Y  False  %d/%m/%Y
    Ajouter une instruction au DI et la finaliser  ${di}  ${dpc_libelle}  false  ${date_10d}

    # Ajout de l'instruction de complétude
    ${date_15d} =  Add Time To Date  ${date_ddmmyyyy}  15 days  %d/%m/%Y  False  %d/%m/%Y
    Ajouter une instruction au DI  ${di}  ${completude_libelle}  ${date_15d}

    # Vérification de l'état, de la date de complétude, du délai, de la date limite d'instruction et de l'événement suivant tacite
    # L'état, le délai et l'événement suivant tacite doivent être identiques à la seconde vérification
    # La date de complétude doit être identique à la date de dépôt de la pièce complémentaire
    # la date limite d'instruction doit être différente de la vérification précédente
    # XXX

    # Récupèration des données à comparer
    Depuis le contexte du dossier d'instruction  ${di}
    ${etat_ph4} =  Get Text  etat
    ${date_complet_ph4} =  Get Text  date_complet
    ${delai_ph4} =  Get Text  delai
    ${date_limite_ph4} =  Get Text  date_limite
    ${evenement_suivant_tacite_ph4} =  Get Value  evenement_suivant_tacite
    ${incompletude_ph4} =  Get Value  incompletude
    ${incomplet_notifie_ph4} =  Get Value  incomplet_notifie
    ${date_limite_incompletude_ph4} =  Get Value  date_limite_incompletude
    ${evenement_suivant_tacite_incompletude_ph4} =  Get Value  evenement_suivant_tacite_incompletude
    ${etat_pendant_incompletude_ph4} =  Get Value  etat_pendant_incompletude
    ${delai_incompletude_ph4} =  Get Value  delai_incompletude
    # Vérification des données par rapport aux phases précèdentes
    Should Be Equal  ${etat_ph4}  ${etat_ph1}
    Should Not Be Equal  ${date_complet_ph4}  ${date_complet_ph3}
    Should Be Equal  ${delai_ph4}  ${delai_ph1}
    Should Not Be Equal  ${date_limite_ph4}  ${date_limite_ph3}
    Should Be Equal  ${evenement_suivant_tacite_ph4}  ${evenement_suivant_tacite_ph1}
    Should Not Be Equal  ${incompletude_ph4}  ${incompletude_ph3}
    Should Not Be Equal  ${incomplet_notifie_ph4}  ${incomplet_notifie_ph3}
    Should Not Be Equal  ${date_limite_incompletude_ph4}  ${date_limite_incompletude_ph3}
    Should Be Equal  ${evenement_suivant_tacite_incompletude_ph4}  ${evenement_suivant_tacite_incompletude_ph3}
    Should Not Be Equal  ${etat_pendant_incompletude_ph4}  ${etat_pendant_incompletude_ph3}
    Should Not Be Equal  ${delai_incompletude_ph4}  ${delai_incompletude_ph3}
    # Vérification des valeurs
    Element Should Be Visible  date_complet
    Should Be Equal  ${date_complet_ph4}  ${date_10d}
    Should Be Equal  ${etat_ph4}  delai de notification envoye
    Should Be Equal  ${incompletude_ph4}  f
    Should Be Equal  ${incomplet_notifie_ph4}  f
    Should Be Equal  ${delai_incompletude_ph4}  ${EMPTY}
    Should Be Equal  ${date_limite_incompletude_ph4}  ${EMPTY}
    Should Be Equal  ${etat_pendant_incompletude_ph4}  ${EMPTY}

    # On vérifie que lorsque le dossier d'instruction à
    # la valeur false dans le champ accord_tacite
    # le champ "au terme du délai" affiche la valeur "N/A"

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
    # Ajout de l'instruction d'incomplétude
    Ajouter une instruction au DI et la finaliser  ${di}  ${incompletude_libelle}
    Depuis l'instruction du dossier d'instruction  ${di}  ${incompletude_libelle}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_rar  ${date_ddmmyyyy}
    Input Datepicker  date_retour_signature  ${date_ddmmyyyy}
    Click On Submit Button In Subform
    Depuis le contexte du dossier d'instruction  ${di}
    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction de tous les encours  ${di}
    # Lorsque le dossier d'instruction est clôturé, le champ au terme du délai n'est plus affiché
    Ajouter une instruction au DI  ${di}  completude_190
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve
    Depuis le contexte du dossier d'instruction  ${di}
    Element Should Not Be Visible  css=#evenement_suivant_tacite_incompletude
    Element Should Not Be Visible  css=#evenement_suivant_tacite
    # Modification de l'événement de récépissé pour le remettre comme avant
    &{args_evenement} =  Create Dictionary
    ...  libelle=Notification du delai legal maison individuelle
    ...  accord_tacite=Oui
    Depuis la page d'accueil  admin  admin
    Modifier l'événement  ${args_evenement}

    # Voir si ajouter ici ou dans le test 550 pour vérifier le WS de gestion des tacites
    # En cas d'incomplétude notifié sur un dossier, c'est l'événement suivant tacite incomplétude qui doit être utilisé et non l'événement suivant tacite du circuit normal
