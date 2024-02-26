*** Settings ***
Documentation  Test des événements d'instruction.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Suggestion d'Evenement d'instruction
    [Documentation]  Vérification du fonctionnement du paramétrage et de l'affichage des suggestions
    ...  dans les onglets contraintes et instruction d'un DI.

    Depuis la page d'accueil  admin  admin
    # Paramétrage des groupes, sous-groupes et couches nécessaire à la création des contraintes
    # de référence
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

    # Ajout de 5 contraintes ayant des paramétrages différents pour tester tous les cas possible.
    # Toutes les contraintes sont liées à un même évènement pour s'assurer que cela ne causera pas de
    # doublons par la suite.

    # Contrainte Ref 1 : collectivité : agglo, type de dossier : PCI initial,
    # Evenement : adjoint,  affichage_obligatoire
    @{collectivité} =  Create List  agglo
    @{DI_type} =  Create List  PCI - P - Initial
    ${contrainte_1} =  Set Variable  Ref 1
    &{argt_contrainte} =  Create Dictionary
    ...  nature=TST
    ...  groupe=${lib_groupe}
    ...  sousgroupe=${lib_ss_groupe}
    ...  sig_couche=${lib_couche} (1)
    ...  libelle=${contrainte_1}
    ...  dossier_instruction_type=${DI_type}
    ...  om_collectivite=${collectivité}
    Ajouter la contrainte de référence  ${argt_contrainte}
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_1}  adjoint
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_1}  affichage_obligatoire

    # Contrainte Ref 2 : collectivité : Marseille, type de dossier : PCI initial,
    # Evenement : ARRÊTÉ DE REFUS,  affichage_obligatoire
    @{collectivité} =  Create List  MARSEILLE
    ${contrainte_2} =  Set Variable  Ref 2
    &{argt_contrainte} =  Create Dictionary
    ...  nature=TST
    ...  groupe=${lib_groupe}
    ...  sousgroupe=${lib_ss_groupe}
    ...  sig_couche=${lib_couche} (1)
    ...  libelle=${contrainte_2}
    ...  dossier_instruction_type=${DI_type}
    ...  om_collectivite=${collectivité}
    Ajouter la contrainte de référence  ${argt_contrainte}
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_2}  ARRÊTÉ DE REFUS
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_2}  affichage_obligatoire

    # Contrainte Ref 3 : collectivité : agglo et Marseille, type de dossier : PCI initial et DP
    # Evenement : commission nationale,  affichage_obligatoire
    @{collectivité} =  Create List  agglo  MARSEILLE
    @{DI_type} =  Create List  PCI - P - Initial  DP - P - Initiale
    ${contrainte_3} =  Set Variable  Ref 3
    &{argt_contrainte} =  Create Dictionary
    ...  nature=TST
    ...  groupe=${lib_groupe}
    ...  sousgroupe=${lib_ss_groupe}
    ...  sig_couche=${lib_couche} (1)
    ...  libelle=${contrainte_3}
    ...  dossier_instruction_type=${DI_type}
    ...  om_collectivite=${collectivité}
    Ajouter la contrainte de référence  ${argt_contrainte}
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_3}  commission nationale
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_3}  affichage_obligatoire

    # Contrainte Ref 4 : collectivité : agglo et Marseille, type de dossier : DP
    # Evenement : Defrichement soumis a enquete publique,  affichage_obligatoire
    @{DI_type} =  Create List  DP - P - Initiale
    ${contrainte_4} =  Set Variable  Ref 4
    &{argt_contrainte} =  Create Dictionary
    ...  nature=TST
    ...  groupe=${lib_groupe}
    ...  sousgroupe=${lib_ss_groupe}
    ...  sig_couche=${lib_couche} (1)
    ...  libelle=${contrainte_4}
    ...  dossier_instruction_type=${DI_type}
    ...  om_collectivite=${collectivité}
    Ajouter la contrainte de référence  ${argt_contrainte}
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_4}  Defrichement soumis a enquete publique
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_4}  affichage_obligatoire

    # Contrainte Ref 5 : collectivité : Aubagne, type de dossier : PCI initial
    # Evenement : Consultation ERP ET IGH,  affichage_obligatoire
    @{DI_type} =  Create List  PCI - P - Initial
    @{collectivité} =  Create List  ALLAUCH
    ${contrainte_5} =  Set Variable  Ref 5
    &{argt_contrainte} =  Create Dictionary
    ...  nature=TST
    ...  groupe=${lib_groupe}
    ...  sousgroupe=${lib_ss_groupe}
    ...  sig_couche=${lib_couche} (1)
    ...  libelle=${contrainte_5}
    ...  dossier_instruction_type=${DI_type}
    ...  om_collectivite=${collectivité}
    Ajouter la contrainte de référence  ${argt_contrainte}
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_5}  Consultation ERP ET IGH
    Ajouter un evenement suggere à la contrainte de référence  ${contrainte_5}  affichage_obligatoire

    # Ajout des contraintes correspondantes (simule la création des contraintes)
    ${id_contrainte1} =  Ajouter la contrainte depuis le menu  ${contrainte_1}  PLU  agglo  TST  Suggere  tst contrainte suggere 1
    ${id_contrainte2} =  Ajouter la contrainte depuis le menu  ${contrainte_2}  PLU  MARSEILLE  TST  Suggere  tst contrainte suggere 2
    ${id_contrainte3_1} =  Ajouter la contrainte depuis le menu  ${contrainte_3}  PLU  agglo  TST  Suggere  tst contrainte suggere 3.1
    ${id_contrainte3_2} =  Ajouter la contrainte depuis le menu  ${contrainte_3}  PLU  MARSEILLE  TST  Suggere  tst contrainte suggere 3.2
    ${id_contrainte4_1} =  Ajouter la contrainte depuis le menu  ${contrainte_4}  PLU  agglo  TST  Non Suggere  tst contrainte suggere 4.1
    ${id_contrainte5} =  Ajouter la contrainte depuis le menu  ${contrainte_5}  PLU  MARSEILLE  TST  Non Suggere  tst contrainte suggere 5

    # Création du dossier et ajout des contraintes
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Instruction
    ...  particulier_prenom=Suggestion
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Les contraintes 4.1 et 5 n'ont pas de suggestion pour ce type de dossier. Elles sont ajoutées
    # en première pour tester le non affichage de l'icone des suggestions et du message d'info
    @{contraintes_to_add} =  Create List  ${id_contrainte4_1}  ${id_contrainte5}
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${di}  ${contraintes_to_add}
    # Pas de message concernant des suggestions
    Page Should Not Contain Element  css=span#message.ui-state-info
    # Pas d'icone en forme d'ampoule
    Page Should Not Contain Element  css=span.suggestion-icon

    # Ajout des 3 autres contraintes. Le message d'information est maintenant visible et chacune des
    # contraintes doit avoir une ampoule et n'apparaître qu'une fois.
    @{contraintes_to_add} =  Create List  ${id_contrainte1}  ${id_contrainte2}  ${id_contrainte3_1}  ${id_contrainte3_2}
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${di}  ${contraintes_to_add}
    Element Should Contain  css=div.message.ui-state-info  Des suggestions (💡) d'instruction en rapport avec les contraintes ci-dessous sont disponibles.
    # La page doit maintenant contenir 4 icones de suggestion
    Page Should Contain Element  css=span.suggestion-icon  limit=4
    # Vérification du message de suggestion
    ${attributes} =  Get Element Attribute  css=span.suggestion-icon  title
    Should Be Equal  ${attributes}  Instructions suggérées :\n- adjoint\n- affichage_obligatoire

    # Ajout d'un doublon sur une contrainte suggérrées, elle doit être affichée deux fois.
    @{contraintes_to_add} =  Create List  ${id_contrainte1}
    Ajouter des contraintes depuis l'onglet du dossier d'instruction  ${di}  ${contraintes_to_add}
    # Vérification que la contrainte est bien visible 2 fois
    Page Should Contain Element  xpath=//a[text()[contains(.,"${contrainte_1}")]]  limit=2

    # Accès au formulaire d'ajout d'une instruction, les instructions suggérées ne doivent pas avoir de doublons.
    Depuis le formulaire d'ajout d'une instruction du DI  ${di}
    @{evenements_suggeres} =  Create List  affichage_obligatoire  adjoint  ARRÊTÉ DE REFUS  commission nationale
    :FOR  ${evenement}  IN  @{evenements_suggeres}
    # Vérifie la présence des évènements dans le groupe des évènements suggérés
    \  Page Should Contain Element  xpath=//optgroup[contains(@label, "💡 Suggestions")]/descendant::option[normalize-space(text())="${evenement}"]
    # Vérifie qu'ils ne sont pas en doublon dans la liste
    \  Page Should Contain Element  xpath=//option[normalize-space(text())="${evenement}"]  None  INFO  1


    # Modification du libellé d'une contrainte. Les suggestions associées à cette contrainte ne
    # doivent plus l'être.
    Modifier la contrainte  ${contrainte_1}  plop

    # La contrainte modifié ne dois plus avoir de suggestion dans l'onglet contrainte et les autres suggestions
    # doivent toujours être présente
    Depuis l'onglet contrainte(s) du dossier d'instruction  ${di}
    Page Should Contain Element  css=span.suggestion-icon  limit=3
    Page Should Not Contain Element  css=#sousform-dossier_contrainte tr:nth-child(1) span.suggestion-icon

    # L'évènement ne dois plus être suggéré à l'ajout d'une instruction
    Depuis le formulaire d'ajout d'une instruction du DI  ${di}
    # Vérifie que l'évènement de la contrainte 1 (adjoint) n'est plus dans la liste des évènement suggérés
    # et se trouve avec les autres évènements
    Page Should Not Contain Element  xpath=//optgroup[contains(@label, "💡 Suggestions")]/descendant::option[text()[contains(.,"adjoint")]]
    Page Should Contain Element  xpath=//option[text()[contains(.,"adjoint")]]
    # Les autres évènements doivent toujours être présentet sans doublons
    @{evenements_suggeres} =  Create List  affichage_obligatoire  ARRÊTÉ DE REFUS  commission nationale
    :FOR  ${evenement}  IN  @{evenements_suggeres}
    # Vérifie la présence des évènements dans le groupe des évènements suggérés
    \  Page Should Contain Element  xpath=//optgroup[contains(@label, "💡 Suggestions")]/descendant::option[normalize-space(text())="${evenement}"]
    # Vérifie qu'ils ne sont pas en doublon dans la liste
    \  Page Should Contain Element  xpath=//option[normalize-space(text())="${evenement}"]  None  INFO  1
