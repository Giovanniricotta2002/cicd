#
# Description
#
# @package openads
# @version SVN : $Id $
#

*** Settings ***
Documentation  Test les pièces.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Constitution d'un jeu de données

    [Documentation]  L'objet de ce 'Test Case' est de constituer un jeu de de
    ...  données cohérent pour les scénarios fonctionnels qui suivent.

    Depuis la page d'accueil  admin  admin
    &{om_param} =  Create Dictionary
    ...  libelle=option_notification_piece_numerisee
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Rivière
    ...  particulier_prenom=Coralie
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Liste des arguments pour la demande
    &{args_demande_at} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire_at} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Duplanty
    ...  particulier_prenom=Dominic
    ...  om_collectivite=MARSEILLE
    #
    ${di_at} =  Ajouter la demande par WS  ${args_demande_at}  ${args_petitionnaire_at}

    #
    Depuis la page d'accueil  instr  instr
    #
    Ajouter une consultation depuis un dossier  ${di}  59.13 - Régie des Tranports de Marseille - DTP/CIP

    # Les dossiers sont accessibles dans la suite du test
    Set Suite Variable  ${di}
    Set Suite Variable  ${di_at}

Impossible de supprimer une piece qui a été envoyé a openads
    [Documentation]  Verifie que si une piece a été envoyé a plat'au
    ...  la piece ne peux pas etre supprimer

    Depuis la page d'accueil  admin  admin

    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

    &{args_dossier} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{args_petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Samir
    ...  particulier_prenom=Nasri
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire1}

    ${di1_sans_espace} =  Sans espace  ${di}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=Test type document numerise de catégorie PLATAU
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    &{task_values} =  Create Dictionary
    ...  type=ajout_piece
    ...  dossier=${di1_sans_espace}
    ...  state=draft
    ...  link_dossier=${di1_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}
    ${id_creation_DA} =  Get Text  css=#task

    # State archived
    &{task_values_modif} =  Create Dictionary
    ...  state=archivé
    Modifier la task  ${id_creation_DA}  ${task_values_modif}

    Depuis le contexte de la pièce par le dossier d'instruction  ${di}  Test type document numerise de catégorie PLATAU 
    Page Should Not Contain Element  css=#action-sousform-document_numerise-supprimer

    # State new
    &{task_values_modif} =  Create Dictionary
    ...  state=à traiter
    Modifier la task  ${id_creation_DA}  ${task_values_modif}

    Depuis le contexte de la pièce par le dossier d'instruction  ${di}  Test type document numerise de catégorie PLATAU 
    Page Should Not Contain Element  css=#action-sousform-document_numerise-supprimer

    # State pending
    &{task_values_modif} =  Create Dictionary
    ...  state=en cours
    Modifier la task  ${id_creation_DA}  ${task_values_modif}

    Depuis le contexte de la pièce par le dossier d'instruction  ${di}  Test type document numerise de catégorie PLATAU 
    Page Should Not Contain Element  css=#action-sousform-document_numerise-supprimer

    # State done
    &{task_values_modif} =  Create Dictionary
    ...  state=terminé
    Modifier la task  ${id_creation_DA}  ${task_values_modif}

    Depuis le contexte de la pièce par le dossier d'instruction  ${di}  Test type document numerise de catégorie PLATAU 
    Page Should Not Contain Element  css=#action-sousform-document_numerise-supprimer

    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

Catégorie de pièce
    [Documentation]  Ajoute, modifie et supprime une catégorie de pièce.
    ...  Vérifie l'ajout de type depuis le sous-formulaire.

    # On ajoute une catégorie
    Depuis la page d'accueil  admin  admin
    ${dntc_libelle} =  Set Variable  Document numérisé
    &{dntc_values} =  Create Dictionary
    ...  libelle=${dntc_libelle}
    Ajouter la catégorie de pièces  ${dntc_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    # On récupère l'identifiant de la catégorie
    Depuis le contexte de la catégorie de pièces  ${dntc_libelle}
    ${dntc_id} =  Get Text    css=#document_numerise_type_categorie

    # On modifie une catégorie
    ${dntc2_libelle} =  Set Variable  Pièce numérisée
    &{dntc_values} =  Create Dictionary
    ...  libelle=${dntc2_libelle}
    Modifier la catégorie de pièces  ${dntc_libelle}  ${dntc_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On supprime une catégorie
    ${dntc3_libelle} =  Set Variable  Catégorie à supprimer
    &{dntc_values} =  Create Dictionary
    ...  libelle=${dntc3_libelle}
    Ajouter la catégorie de pièces  ${dntc_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Supprimer la catégorie de pièces  ${dntc3_libelle}
    Valid Message Should Contain  La suppression a été correctement effectuée.

    # On ajoute un type depuis la catégorie
    ${instructeur_qualite} =  Create List
    ...  instructeur
    &{dnt_values} =  Create Dictionary
    ...  code=IMG
    ...  libelle=Image
    ...  instructeur_qualite=${instructeur_qualite}
    Depuis le contexte de la catégorie de pièces  ${dntc2_libelle}
    On clique sur l'onglet  document_numerise_type  Type De Pièces
    # On vérifie que le tableau est vide
    Element Should Contain  css=#sousform-document_numerise_type  Aucun enregistrement
    # On vérifie que la catégorie soit déjà sélectionné et que les cases à
    # cocher 'aff_da' et 'aff_service_consulte' soient déjà cochées
    Click On Add Button JS
    Form Value Should Be  css=input#document_numerise_type_categorie  ${dntc_id}
    Form Value Should Be  aff_service_consulte  Oui
    Form Value Should Be  aff_da  Oui
    Saisir le type de pièces en sous-formulaire  ${dnt_values}
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.


Type de pièce
    [Documentation]  Ajoute, modifie et supprime un type de pièce.
    ...  Test egalement la contrainte d'unicité de la validité des codes
    ...  des pièces.

    # On ajoute une catégorie car c'est un champ obligatoire pour les types
    Depuis la page d'accueil  admin  admin
    ${dntc_libelle} =  Set Variable  Plan pour dossier
    &{dntc_values} =  Create Dictionary
    ...  libelle=${dntc_libelle}
    Ajouter la catégorie de pièces  ${dntc_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On ajoute un type, on vérifie que les cases à cocher 'aff_da' et
    # 'aff_service_consulte' soient déjà cochées et que le champ
    # 'synchro_metadonnee' non visible soit à false
    ${dnt_code} =  Set Variable  DCPL01
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Plan pour dossier de coordination
    ...  document_numerise_type_categorie=${dntc_libelle}
    Depuis le listing  document_numerise_type
    Click On Add Button
    Form Value Should Be  aff_service_consulte  Oui
    Form Value Should Be  aff_da  Oui
    Saisir le type de pièces  ${dnt_values}
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Depuis le contexte du type de pièces  ${dnt_code}
    ${synchro_metadonnee} =  Get Mandatory Value  css=#synchro_metadonnee
    Should Be equal  ${synchro_metadonnee}  f

    # On modifie le champ aff_da du type et on vérifie que le champ
    #'synchro_metadonnee' devient true
    &{dnt_values} =  Create Dictionary
    ...  libelle=Plan pour dossier de coordination 01
    ...  aff_da=false
    Modifier le type de pièces  ${dnt_code}  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Depuis le contexte du type de pièces  ${dnt_code}
    ${synchro_metadonnee} =  Get Mandatory Value  css=#synchro_metadonnee
    Should Be equal  ${synchro_metadonnee}  t

    # On ajoute un autre type de pièce ayant le même code et ayant une date
    # de fin de validité nul. Vérifie qu'un message d'erreur est visible.
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Plan pour dossier de coordination
    ...  document_numerise_type_categorie=${dntc_libelle}
    Ajouter le type de pièces  ${dnt_values}
    Error Message Should Contain  Il ne peut pas y avoir deux codes valide pour un type de pièce

    # Même opération mais avec une date de fin de validité dépassé pour vérifier
    # que l'enregistrement fonctionne
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Plan pour dossier de coordination
    ...  document_numerise_type_categorie=${dntc_libelle}
    ...  om_validite_fin=19/06/1995
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    ${dnt_test_validite} =  Get Text  css=div.form-content span#document_numerise_type

    # Modification de la date de fin de validité pour rendre la pièce valide et
    # tester la contrainte
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=Plan pour dossier de coordination
    ...  document_numerise_type_categorie=${dntc_libelle}
    ...  om_validite_fin=19/06/2041
    Depuis le listing  document_numerise_type
    Use Simple Search  Tous  ${dnt_test_validite}
    Click On Link  action-tab-document_numerise_type-global-om_validite-false
    Click On Link  ${dnt_test_validite}
    La page ne doit pas contenir d'erreur
    Click On Form Portlet Action  document_numerise_type  modifier
    Saisir le type de pièces  ${dnt_values}
    Click On Submit Button
    Error Message Should Contain  Il ne peut pas y avoir deux codes valide pour un type de pièce

    # On supprime un type
    ${dnt2_code} =  Set Variable  DC
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt2_code}
    ...  libelle=Document numérisé
    ...  document_numerise_type_categorie=${dntc_libelle}
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Supprimer le type de pièces  ${dnt2_code}
    Valid Message Should Contain  La suppression a été correctement effectuée.

Non ajout ni modification des types de pièces de catégorie Plat'AU
    [Documentation]  Vérifie que les types de pièces ayant la catégorie Plat'AU ne peuvent pas être
    ...  modifiée et que la catégorie Plat'AU ne peut pas être sélectionné dans le formulaire
    ...  d'ajout.

    # On essaie modifie le type ayant la catégorie PLATAU
    &{dnt_cat_platau_values} =  Create Dictionary
    ...  document_numerise_type_categorie=Daact
    Modifier le type de pièces  PLATAU  ${dnt_cat_platau_values}
    Error Message Should Contain  Les types de pièces de catégorie Plat'AU ne peuvent pas être modifiée.

    # Vérifie si la catégorie Plat'AU est accessible depuis le formulaire d'ajout
    Depuis le listing  document_numerise_type
    Click On Add Button
    Element Should Not Contain  css=select#document_numerise_type_categorie  Plat'AU

Nomenclature de pièce
    [Documentation]  Ajoute, modifie et supprime une nomenclature de pièce.

    # On ajoute type de pièce et un type de dossier d'instruction car ce
    # sont de champ obligatoire pour la nomenclature des pièces
    # Pour ajouter un type de pièce on ajoute également une catégorie
    ${dntc_libelle} =  Set Variable  Test pour dossier
    &{dntc_values} =  Create Dictionary
    ...  libelle=${dntc_libelle}
    Ajouter la catégorie de pièces  ${dntc_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    &{dnt_values} =  Create Dictionary
    ...  code=TESTDN
    ...  libelle=Test Document numérisé
    ...  document_numerise_type_categorie=${dntc_libelle}
    Ajouter le type de pièces  ${dnt_values}

    # On ajoute une nomenclature
    &{nomenclature_values} =  Create Dictionary
    ...  document_numerise_type=Test Document numérisé
    ...  dossier_instruction_type=AT Initiale
    ...  code=TEST01
    ${id_nomenclature} =  Ajouter une nomenclature de piece  ${nomenclature_values}

    # On modifie la nomenclature
    &{nomenclature_values} =  Create Dictionary
    ...  code=TEST02
    Modifier une nomenclature de piece  ${id_nomenclature}  ${nomenclature_values}

    # On supprime la nomenclature
    Supprimer une nomenclature de piece  ${id_nomenclature}
    Valid Message Should Contain  La suppression a été correctement effectuée.

Ajout de pièces

    [Documentation]  Vérifie que l'ajout de 2 pièces ayant la même date et le même type
    ...  crée bien les fichiers avec un suffixe.
    ...  On vérifie également que le type de pièce n'est pas visible pour un instructeur
    ...  si l'option n'est pas activé pour ce type de pièce.
    ...  Vérifie également que le code de la pièce est affiché et que les pièces sont
    ...  bien filtrées par type de dossier.
    ...  On vérifie que la date de création par défaut est bien la dernière date de création
    ...  enregistrée.

    # On ajoute une catégorie car c'est un champ obligatoire pour les types
    Depuis la page d'accueil  admin  admin
    ${dntc_libelle} =  Set Variable  Le roi
    &{dntc_values} =  Create Dictionary
    ...  libelle=${dntc_libelle}
    Ajouter la catégorie de pièces  ${dntc_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On ajoute un type, on vérifie que les cases à cocher 'aff_da',
    #'aff_service_consulte' soient déjà cochées et que le
    # champ 'synchro_metadonnee' non visible soit à false
    ${dnt_code} =  Set Variable  LR01
    ${type_libelle_dict} =  Create List
    ...  Document très important
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=${type_libelle_dict}
    ...  document_numerise_type_categorie=${dntc_libelle}
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On ajoute plusieurs nomenclatures. Une pour le dossier tester permettant
    # de vérifier que l'affichage du code est correct. Une pour un autre dossier
    # pour s'assurer que ce code n'est pas visible. Deux autres qui permettront
    # de tester l'affichage en cas de nomenclature différente pour une même pièce
    # d'un dossier
    &{nomenclature_values} =  Create Dictionary
    ...  document_numerise_type=arrêté modificatif
    ...  dossier_instruction_type=PCI Initial
    ...  code=ART01
    ${id_nomenclature_1} =  Ajouter une nomenclature de piece  ${nomenclature_values}

    &{nomenclature_values} =  Create Dictionary
    ...  document_numerise_type=arrêté d'annulation
    ...  dossier_instruction_type=AT Initiale
    ...  code=ARA02
    ${id_nomenclature_2} =  Ajouter une nomenclature de piece  ${nomenclature_values}

    &{nomenclature_values} =  Create Dictionary
    ...  document_numerise_type=autres pièces composant le dossier (A0)
    ...  dossier_instruction_type=PCI Initial
    ...  code=LR03
    ${id_nomenclature_3} =  Ajouter une nomenclature de piece  ${nomenclature_values}

    &{nomenclature_values} =  Create Dictionary
    ...  document_numerise_type=autres pièces composant le dossier (A0)
    ...  dossier_instruction_type=PCI Initial
    ...  code=LR04
    ${id_nomenclature_4} =  Ajouter une nomenclature de piece  ${nomenclature_values}
    
    Depuis la page d'accueil  instrpoly  instrpoly

    # On vérifie le message en cas d'un listing vide
    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Element Should Contain  css=#sousform-document_numerise  Aucun enregistrement

    # Données de la pièce
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=15/09/2015
    ...  document_numerise_type=vues et coupes du projet dans le profil du terrain naturel

    # Décomposition de l'ajout de pièce pour vérifier que le type de pièce créé précédemment
    # n'est pas visible par l'instructeur
    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    #
    Wait Until Element Is Visible  id=action-soustab-blocnote-message-ajouter
    Click Element  id=action-soustab-blocnote-message-ajouter
    Wait Until Element Is Visible  document_numerise_type_chosen
    Select From Chosen List Should Not Contain  document_numerise_type  Document très important
    Select From Chosen List Should Not Contain  document_numerise_type  ARA02 | arrêté d'annulation
    Select From Chosen List Should Contain  document_numerise_type  ART01 | arrêté modificatif
    Select From Chosen List Should Contain  document_numerise_type  LR03 | autres pièces composant le dossier (A0)
    Select From Chosen List Should Contain  document_numerise_type  LR04 | autres pièces composant le dossier (A0)
    Saisir la pièce  ${document_numerise_values}
    # On valide le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform
    # On vérifie le message de validation
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.

    # On vérifie qu'il n'y ait pas de confirmation de transmission ERP
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Not Contain  css=#sformulaire div.message p span.text  Le message a été transmis au référentiel ERP.

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    Click On Back Button In Subform

    Element Should Contain  css=#sousform-document_numerise  20150915DGPA05.pdf
    Element Should Contain  css=#sousform-document_numerise  20160910ART.pdf
    Element Should Contain  css=#sousform-document_numerise  20160910ART-1.pdf
    Element Should Contain  css=#sousform-document_numerise  20160910ART-2.pdf

    # Vérification de l'affichage des codes
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=ART01 | arrêté modificatif
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=LR04 | autres pièces composant le dossier (A0)
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    Click On Back Button In Subform

    Element Should Contain  css=#sousform-document_numerise  ART01 | arrêté modificatif
    Element Should Contain  css=#sousform-document_numerise  LR03 / LR04 | autres pièces composant le dossier (A0)
    Element Should Contain  css=#sousform-document_numerise  20160910ART01.pdf
    Element Should Contain  css=#sousform-document_numerise  20160910LR03.pdf

    # On vérifie le contrôle d'extension lors de l'upload d'un fichier
    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    # On clique sur l'action d'ajout
    Wait Until Element Is Visible  id=action-soustab-blocnote-message-ajouter
    Click Element  id=action-soustab-blocnote-message-ajouter
    Wait Until Element Is Visible  uid_upload
    # On vérifie qu'un CSV ne peut pas être uploadée
    Add File and Expect Error Message Contain  uid  versement_archives.csv  Le fichier n'est pas conforme à la liste des extension(s) autorisée(s)

    # suppression des nomenclatures pour éviter des erreurs dans les tests suivants
    Depuis la page d'accueil  admin  admin
    Supprimer une nomenclature de piece  ${id_nomenclature_1}
    Supprimer une nomenclature de piece  ${id_nomenclature_2}
    Supprimer une nomenclature de piece  ${id_nomenclature_3}
    Supprimer une nomenclature de piece  ${id_nomenclature_4}

    # Vérification que la date d'ajout par défaut est celle de dernier depot
    # en passant le dossier en incompletude et en ajoutant une pièce complémentaire
    Constitution du Workflow de gestion d'une incomplétude  250
    Ajouter une instruction au DI et la finaliser  ${di}  ${incompletude_libelle}
    Depuis l'instruction du dossier d'instruction  ${di}  ${incompletude_libelle}
    Click On SubForm Portlet Action  instruction  modifier_suivi
    ${date_5d} =  Add Time To Date  ${date_ddmmyyyy}  5 days  %d/%m/%Y  False  %d/%m/%Y
    Input Datepicker  date_retour_signature  ${date_5d}
    Click On Submit Button In Subform

    Ajouter une instruction au DI  ${di}  dpc_250  ${date_5d}

    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Click Link  id=action-soustab-blocnote-message-ajouter
    Wait Until Element Is Visible  id=fieldset-sousform-document_numerise-piece
    Element Should Contain  css=#lib-date_creation  Date
    Page Should Contain Element  css=input[value="${date_5d}"]

    ${date_15d} =  Add Time To Date  ${date_ddmmyyyy}  15 days  %d/%m/%Y  False  %d/%m/%Y
    Ajouter une instruction au DI  ${di}  ${completude_libelle}  16/05/2019


Modification d'une pièce

    [Documentation]  Modifie une pièce et vérifie que son nom est régénéré.
    ...  Vérifie également qu'un instructeur peut modifier une pièce mais pas
    ...  le fichier associé à cette pièce.
    ...  La non modification du fichier ne doit pas provoquer d'erreur.

    # Données de la pièce
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel2.pdf
    ...  date_creation=10/09/2005
    #
    Depuis la page d'accueil  admin  admin
    #
    Modifier une pièce depuis le dossier d'instruction  ${di}  vues et coupes du projet dans le profil du terrain naturel  ${document_numerise_values}

    # Récupération de l'UID utilisé dans le test de suppression de la pièce
    Depuis le contexte de la pièce par le dossier d'instruction  ${di}  vues et coupes du projet dans le profil du terrain naturel
    Click On Subform Portlet Action  document_numerise  modifier
    ${document_numerise_uid} =  Get Value  uid
    Set Suite Variable  ${document_numerise_uid}
    #
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    # On clique pour visualiser le document, le nom doit avoir été modifié par
    # rapport à la date
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=tr.col3 td.firstcol a.lienTable span.reqmo-16
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie le contenu du PDF
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST IMPORT MANUEL 2
    # On ferme le PDF
    Close PDF

    # Modification d'une pièce avec un profil instructeur
    Depuis la page d'accueil  instr  instr
    Depuis le contexte de la pièce par le dossier d'instruction  ${di}  vues et coupes du projet dans le profil du terrain naturel
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  document_numerise  modifier
    # Le champ de modification du fichier ne doit pas être accessible
    Page Should not contain  css=input#uid_upload
    &{document_numerise_values} =  Create Dictionary
    ...  date_creation=20/09/2015
    Saisir la pièce  ${document_numerise_values}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform
    La page ne doit pas contenir d'erreur


Gestion du type de pièce "autre à préciser"

    [Documentation]  Vérifie que ce type de pièce est bien accessible quel que
    ...  soit le dossier d'instruction et même si il n'a pas de code associé.
    ...  Test l'utilisation du champ description_type et si il permet bien de
    ...  remplacer le libellé du type dans les listings.

    Depuis la page d'accueil  admin  admin
    # Vérification que cette pièce est visible dans différent type de dossier
    # même si elle n'a pas de code pour ce type de dossier
    &{nomenclature_values} =  Create Dictionary
    ...  document_numerise_type=Autre type à préciser
    ...  dossier_instruction_type=AT Initiale
    ...  code=TEST01
    Ajouter une nomenclature de piece  ${nomenclature_values}

    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Click Element  id=action-soustab-blocnote-message-ajouter
    Wait Until Element Is Visible  document_numerise_nature
    Select From Chosen List Should Contain  document_numerise_type  Autre type à préciser
    # Le champ description type ne doit pas être saisissable
    Page Should Not Contain Element  input#description_type

    # Ajout d'une pièce autre à préciser en remplissant le champ description_type
    # pour vérifier que le libellé est mis à jour dans le listing
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=Autre type à préciser
    ...  description_type=description très précise du document
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    Click On Back Button In Subform
    Element Should Contain  css=#sousform-document_numerise  description très précise du document

    # Modification de la pièce
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=arrêté
    Depuis le contexte de la pièce par le dossier d'instruction  ${di}  description très précise du document
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  document_numerise  modifier
    # Remplissage avec une description vide
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  description_type=${EMPTY}
    Saisir la pièce  ${document_numerise_values}
    # Validation de la modification
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Submit Button In Subform

    # Vérification dans le listing que la description n'est plus présente
    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Element Should Not Contain  css=#sousform-document_numerise  description très précise du document
    Element Should Contain  css=#sousform-document_numerise  Autre

Nature des pièces par défaut

    [Documentation]  Vérifie que dans le formulaire d'ajout des pièces
    ...  si le paramètre option_mode_service_consulte est active alors
    ...  le type de pièce par défaut est "Non applicable".
    ...  Sinon c'est le type initial ou complémentaire qui doit être par défaut
    ...  selon l'incompletude du dossier.

    # Activation du paramètre
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Click Element  id=action-soustab-blocnote-message-ajouter
    Wait Until Element Is Visible  document_numerise_nature
    Element Should Contain  css=select#document_numerise_nature option[selected="selected"]  Non applicable

    # Suppression du paramètre
    &{param_values} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_mode_service_consulte
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_values}

    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Click Element  id=action-soustab-blocnote-message-ajouter
    Wait Until Element Is Visible  document_numerise_nature
    Element Should Contain  css=select#document_numerise_nature option[selected="selected"]  Initiale

    # Test de la nature par défaut des pièces dans un dossier incomplet
    Constitution du Workflow de gestion d'une incomplétude  200
    Ajouter une instruction au DI et la finaliser  ${di}  ${incompletude_libelle}
    Depuis l'instruction du dossier d'instruction  ${di}  ${incompletude_libelle}
    ${date_5d} =  Add Time To Date  ${date_ddmmyyyy}  5 days  %d/%m/%Y  False  %d/%m/%Y
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_signature  ${date_5d}
    Click On Submit Button In Subform

    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Click Element  id=action-soustab-blocnote-message-ajouter
    Wait Until Element Is Visible  document_numerise_nature
    Element Should Contain  css=select#document_numerise_nature option[selected="selected"]  Complémentaire

    ${date_15d} =  Add Time To Date  ${date_ddmmyyyy}  15 days  %d/%m/%Y  False  %d/%m/%Y
    Ajouter une instruction au DI  ${di}  ${completude_libelle}  ${date_15d}


Document de travail

    [Documentation]  Ajoute, modifie,télécharge et supprime un document de travail.

    Depuis la page d'accueil  instr  instr
    # Vérifie que l'onglet document s'affiche sans erreur et que les listing des docs
    # d'instruction et des documents de travail sont bien présents
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di}
    La page ne doit pas contenir d'erreur
    Element Should Contain  css=#sousform-document_instruction  Documents d'instruction
    Element Should Contain  css=#sousform-document_travail  Documents de travail

    # Test de la redirection du bouton retour du formulaire d'ajout
    Click Element  id=action-soustab-document_numerise-corner-ajouter
    Click On Back Button In SubForm
    Wait Until Element Is Visible  css=div.switcher__label.onglet_active[data-view="document_instruction"]

    # Ajout d'un document de travail
    &{doc_travail_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.jpg
    ...  description_type=document de travail
    ...  date_creation=22/08/2021
    ${doc_travail} =  Ajouter un document de travail depuis le dossier d'instruction  ${di}  ${doc_travail_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    # Vérification de l'affichage dans le tableau
    Click On Back Button In SubForm
    Element Should Contain  css=#sousform-document_travail .tab-data  document de travail
    Element Should Contain  css=#sousform-document_travail .tab-data  20210822DOCTRAV.jpg

    # Modification du document de travail
    Depuis la page d'accueil  instrpoly  instrpoly
    &{doc_travail_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  description_type=document de travail (modifié)
    ...  date_creation=23/08/2021
    Modifier un document de travail depuis le dossier d'instruction  ${di}  document de travail  ${doc_travail_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    # Vérification de l'affichage dans le tableau et de la redirection de l'action retour
    # vers l'onglet des documents
    Click On Back Button In SubForm
    Click On Back Button In SubForm
    Page Should Contain Element  css=div.switcher__label.onglet_active[data-view="document_instruction"]
    Element Should Contain  css=#sousform-document_travail .tab-data  document de travail (modifié)
    Element Should Contain  css=#sousform-document_travail .tab-data  20210823DOCTRAV.pdf

    # On clique pour visualiser le document
    Click Element  css=div#sousform-document_travail tr.tab-data td.col-1 a.lienTable span.reqmo-16
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST IMPORT MANUEL 1
    Close PDF

    # Suppression du document de travail
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    Supprimer un document de travail depuis le dossier d'instruction  ${di}  document de travail (modifié)
    Valid Message Should Contain  La suppression a été correctement effectuée.


Vérification de l'affichage sur le dossier d'autorisation

    [Documentation]  Vérifie l'affichage sur les dossiers d'autorisation.

    # On ajoute un type de pièce non affiché sur les DA
    Depuis la page d'accueil  admin  admin
    ${dntc_libelle} =  Set Variable  Non visible au public
    &{dntc_values} =  Create Dictionary
    ...  libelle=${dntc_libelle}
    Ajouter la catégorie de pièces  ${dntc_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    ${dnt_code} =  Set Variable  NVPLAN
    ${dnt_libelle} =  Set Variable  Plan non public
    ${instructeur_qualite} =  Create List
    ...  instructeur
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=${dnt_libelle}
    ...  document_numerise_type_categorie=${dntc_libelle}
    ...  aff_da=false
    ...  instructeur_qualite=${instructeur_qualite}
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On ajoute une pièce numérisée sur le DI vérifié
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=21/09/2015
    ...  document_numerise_type=${dnt_libelle}
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    # On récupère le numéro du dossier d'autorisation depuis le numéro du DI
    ${dossier_autorisation} =  Get Substring  ${di}  0  -2
    #
    Depuis la page d'accueil  guichet  guichet
    #
    Depuis l'onglet des pièces du dossier d'autorisation  ${dossier_autorisation}
    # On vérifie que le numéro du dossier d'instruction est affiché
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  ${di}
    # On vérifie que le nom du fichier est affiché
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  20150920DGPA05.pdf
    # On vérifie que la pièce n'est pas affiché
    Page Should Not Contain  20150921NVPLAN.pdf
    # On clique pour visualiser le document
    Click Element  css=tr.col4 td.col-1 a.lienTable span.reqmo-16
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie la localisation du terrain
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST IMPORT MANUEL 2
    # On ferme le PDF
    Close PDF

    # Activation de l'option option_cache_piece_num_refuse_da et vérification
    # du bon foncitonnement de l'option
    Depuis la page d'accueil  admin  admin
    &{param_values_1} =  Create Dictionary
    ...  libelle=option_cache_piece_num_refuse_da
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values_1}
    Ajouter une instruction au DI et la finaliser  ${di}  ARRÊTÉ DE REFUS
    &{args_instruction} =  Create Dictionary
    ...  date_retour_rar=${DATE_FORMAT_DD/MM/YYYY}
    Modifier le suivi des dates  ${di}  ARRÊTÉ DE REFUS  ${args_instruction}

    Depuis la page d'accueil  guichet  guichet

    Depuis l'onglet des pièces du dossier d'autorisation  ${dossier_autorisation}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  20150920DGPA05.pdf

    # Suppression de l'instruction d'arrete de refus et suppression de l'option
    Depuis la page d'accueil  admin  admin
    &{args_instruction} =  Create Dictionary
    ...  date_retour_rar=${EMPTY}
    Modifier le suivi des dates  ${di}  ARRÊTÉ DE REFUS  ${args_instruction}
    Depuis l'instruction du dossier d'instruction  ${di}  Arrêté de Refus signé
    Click On SubForm Portlet Action  instruction  definaliser
    Supprimer l'instruction  ${di}  Arrêté de Refus signé
    Depuis l'instruction du dossier d'instruction  ${di}  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  definaliser
    Supprimer l'instruction  ${di}  ARRÊTÉ DE REFUS

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_cache_piece_num_refuse_da
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}


Vérification de l'affichage sur la demande d'avis

    [Documentation]  Vérifie l'affichage sur les demandes d'avis.

    # On ajoute un type de pièce non affiché sur les demandes d'avis
    Depuis la page d'accueil  admin  admin
    ${dntc_libelle} =  Set Variable  Top secret
    &{dntc_values} =  Create Dictionary
    ...  libelle=${dntc_libelle}
    Ajouter la catégorie de pièces  ${dntc_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    ${dnt_code} =  Set Variable  TSPLAN
    ${dnt_libelle} =  Set Variable  Plan top secret
    ${instructeur_qualite} =  Create List
    ...  instructeur
    &{dnt_values} =  Create Dictionary
    ...  code=${dnt_code}
    ...  libelle=${dnt_libelle}
    ...  document_numerise_type_categorie=${dntc_libelle}
    ...  aff_service_consulte=false
    ...  instructeur_qualite=${instructeur_qualite}
    Ajouter le type de pièces  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # On ajoute une pièce numérisée sur le DI vérifié
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=21/09/2015
    ...  document_numerise_type=${dnt_libelle}
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    #
    Depuis la page d'accueil  consu  consu
    #
    Depuis l'onglet des pièces de la demande d'avis en cours du dossier d'instruction  ${di}
    # On vérifie que le nom du fichier est affiché
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  20150920DGPA05.pdf
    # On vérifie que la pièce n'est pas affiché
    Page Should Not Contain  20150921TSPLAN.pdf
    # On vérifie que la pièce n'est pas affiché
    Page Should Not Contain  20150921TSPLAN.pdf
    # On clique pour visualiser le document
    Click Element  css=tr.col3 td.firstcol a.lienTable span.reqmo-16
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie la localisation du terrain
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST IMPORT MANUEL 2
    # On ferme le PDF
    Close PDF


Suppression d'une pièce

    [Documentation]  Vérifie dans le filestorage si le fichier du document numérisé est
    ...  correctement supprimé lors de la suppression d'une pièce

    ${path_1} =  Get Substring  ${document_numerise_uid}  0  2
    ${path_2} =  Get Substring  ${document_numerise_uid}  0  4
    # Vérification dans le filestorage
    File Should Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${document_numerise_uid}
    File Should Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${document_numerise_uid}.info
    #
    Depuis la page d'accueil  instrpoly  instrpoly
    #
    Supprimer une pièce depuis le dossier d'instruction  ${di}  vues et coupes du projet dans le profil du terrain naturel
    # Vérification dans le filestorage
    File Should Not Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${document_numerise_uid}
    File Should Not Exist  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${document_numerise_uid}.info


TNR Ajout de pièces au DI en tant qu'instructeur

    [Documentation]  L'utilisation d'un getval faisait qu'un dossier au hasard était
    ...  récupéré lors de l'ajout de pièces, quand ce dossier était clôturé l'ajout de
    ...  pièces produisait une erreur de droits insuffisants pour les instructeurs.

    # On crée une nouvelle demande pour le TNR
        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Riel
    ...  particulier_prenom=Sébastien
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Le bug provenait du fait que l'on instanciait à tort le premier document
    # numérisé créé en base de données. Celui-ci est lié au AZ 013055 12 00001P0.
    # Ainsi on testait toujours ce DI pour savoir s'il était clôturé et donc si
    # on avait le droit ou non d'ajouter une pièce.
    Depuis la page d'accueil  instrpoly  instrpoly
    Ajouter une instruction au DI  AZ 013055 12 00001P0  ARRÊTÉ DE REFUS
    Click On Back Button In Subform
    Click On Back Button In Subform
     # En cloturant le AZ 013055 12 00001P0 on reproduit le use case.
    Click On Link  ARRÊTÉ DE REFUS
    Click On SubForm Portlet Action  instruction  finaliser
    Click On SubForm Portlet Action  instruction  definaliser
    Click On SubForm Portlet Action  instruction  modifier
    Input Datepicker  date_retour_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform

    # On teste l'ajout de pièces sur le DI de test en tant qu'instructeur
    # Cela doit fonctionner bien que le AZ 013055 12 00001P0 soit clôturé
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=15/09/2015
    ...  document_numerise_type=vues et coupes du projet dans le profil du terrain naturel
    Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    # On supprime les événements d'instruction créés spécifiquement pour le TNR
    Depuis la page d'accueil  admin  admin
    Depuis l'instruction du dossier d'instruction  AZ 013055 12 00001P0  Arrêté de Refus signé
    Click On SubForm Portlet Action  instruction  definaliser
    Supprimer l'instruction  AZ 013055 12 00001P0  Arrêté de Refus signé
    Supprimer l'instruction  AZ 013055 12 00001P0  ARRÊTÉ DE REFUS


TNR Vérification des métadonnées des fichiers

    [Documentation]  Vérifie les métadonnées des fichiers créé par
    ...  l'application.

    # On crée une nouvelle demande pour le TNR
        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Dufresne
    ...  particulier_prenom=Thierry
    ...  om_collectivite=MARSEILLE
    #
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di_metadata} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    ${libelle_di_metadata} =  Sans espace  ${di_metadata}

    # On ajoute une pièce sur le dossier d'instruction initial
    Depuis la page d'accueil  admin  admin
    # Données de la pièce
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté
    #
    Ajouter une pièce depuis le dossier d'instruction  ${di_metadata}  ${document_numerise_values}
    # On récupére l'UID de la pièce pour définir les chemins
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_metadata}  arrêté
    Click On Subform Portlet Action  document_numerise  modifier
    ${uid} =  Get Value  uid
    ${path_1} =  Get Substring  ${uid}  0  2
    ${path_2} =  Get Substring  ${uid}  0  4
    # On vérifie les métadonnées depuis le fichier ".info" dans le filesystem
    ${file_info} =  Get File  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info
    Should Contain  ${file_info}  dossier=${libelle_di_metadata}
    Should Contain  ${file_info}  dossier_version=0
    Should Contain  ${file_info}  typeInstruction=P

    # On accepte le dossier d'instruction initial
    Ajouter une instruction au DI  ${di_metadata}  accepter un dossier sans réserve

    # On ajoute un modificatif sur le dossier d'instruction
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di_metadata}
    #
    ${di_metadata_1} =  Ajouter la demande par WS  ${args_demande}
    # On récupère le numéro du dossier sans espace
    ${libelle_di_metadata_1} =  Sans espace  ${di_metadata_1}
    # On ajoute une pièce sur le dossier d'instruction de modification 1
    Depuis la page d'accueil  admin  admin
    # Données de la pièce
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté
    #
    Ajouter une pièce depuis le dossier d'instruction  ${di_metadata_1}  ${document_numerise_values}
    # On récupére l'UID de la pièce pour définir les chemins
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_metadata_1}  arrêté
    Click On Subform Portlet Action  document_numerise  modifier
    ${uid} =  Get Value  uid
    ${path_1} =  Get Substring  ${uid}  0  2
    ${path_2} =  Get Substring  ${uid}  0  4
    # On vérifie les métadonnées depuis le fichier ".info" dans le filesystem
    ${file_info} =  Get File  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info
    Should Contain  ${file_info}  dossier=${libelle_di_metadata_1}
    Should Contain  ${file_info}  dossier_version=01
    Should Contain  ${file_info}  typeInstruction=M

    # On accepte le dossier d'instruction de modification 1
    Ajouter une instruction au DI  ${di_metadata_1}  accepter un dossier sans réserve

    #
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di_metadata_1}
    #
    ${di_metadata_2} =  Ajouter la demande par WS  ${args_demande}
    # On récupère le numéro du dossier sans espace
    ${libelle_di_metadata_2} =  Sans espace  ${di_metadata_2}
    # On ajoute une pièce sur le dossier d'instruction de modification 2
    # Données de la pièce
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté
    #
    Ajouter une pièce depuis le dossier d'instruction  ${di_metadata_2}  ${document_numerise_values}
    # On récupére l'UID de la pièce pour définir les chemins
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_metadata_2}  arrêté
    Click On Subform Portlet Action  document_numerise  modifier
    ${uid} =  Get Value  uid
    ${path_1} =  Get Substring  ${uid}  0  2
    ${path_2} =  Get Substring  ${uid}  0  4
    # On vérifie les métadonnées depuis le fichier ".info" dans le filesystem
    ${file_info} =  Get File  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info
    Should Contain  ${file_info}  dossier=${libelle_di_metadata_2}
    Should Contain  ${file_info}  dossier_version=02
    Should Contain  ${file_info}  typeInstruction=M

    # On ajoute une pièce sur le dossier d'instruction de modification 1
    Depuis la page d'accueil  admin  admin
    # Données de la pièce
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté de conformité
    #
    Ajouter une pièce depuis le dossier d'instruction  ${di_metadata_1}  ${document_numerise_values}
    # On récupére l'UID de la pièce pour définir les chemins
    Depuis le contexte de la pièce par le dossier d'instruction  ${di_metadata_1}  arrêté de conformité
    Click On Subform Portlet Action  document_numerise  modifier
    ${uid} =  Get Value  uid
    ${path_1} =  Get Substring  ${uid}  0  2
    ${path_2} =  Get Substring  ${uid}  0  4
    # On vérifie les métadonnées depuis le fichier ".info" dans le filesystem
    ${file_info} =  Get File  ..${/}var${/}filestorage${/}${path_1}${/}${path_2}${/}${uid}.info
    Should Contain  ${file_info}  dossier=${libelle_di_metadata_1}
    Should Contain  ${file_info}  dossier_version=01
    Should Contain  ${file_info}  typeInstruction=M


Téléchargement de l'intégralité des pièces

    [Documentation]  Contrôle que l'action "télécharger toutes les pièces" dans l'onglet
    ...  Pièce(s) d'un dossier d'instruction, dans l'onglet Pièce(s) du DA et les demandes
    ...  d'avis produit bien une archive téléchargeable contenant toutes les pièces.
    ...  On ajoute plusieurs fois le même type de pièce le même jour pour vérifier que les
    ...  fichiers sont bien suffixés.

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Compagnon
    ...  particulier_prenom=Émilie
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  admin  admin

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=31/03/2016
    ...  document_numerise_type=avis obligatoires
    Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=31/03/2016
    ...  document_numerise_type=avis obligatoires
    Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=31/03/2016
    ...  document_numerise_type=avis obligatoires
    Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel2.pdf
    ...  date_creation=30/03/2016
    ...  document_numerise_type=avis obligatoires
    Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    # Pièce de type "arrêté retour prefecture" qui sera disponible depuis le DA
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=31/03/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    Depuis la page d'accueil  instr  instr
    # Ajout d'une consultation au dossier pour que consu puisse accéder aux pièces
    Ajouter une consultation depuis un dossier  ${di_libelle}  59.01 - Direction de l'Eau et de l'Assainissement

    Depuis l'onglet des pièces du dossier d'instruction  ${di_libelle}
    ${path_archive}  ${archive_name} =  Télécharger toutes les pièces

    # Composition du nom correct de l'archive zip
    ${di_libelle_spaceless} =  Sans espace  ${di_libelle}
    ${date_ddmmyyyy} =  Date du jour EN
    ${date_jour_sans_tirets} =  STR_REPLACE  -  ${EMPTY}  ${date_ddmmyyyy}
    ${correct_archive_name_di} =  Set Variable  ${di_libelle_spaceless}_${date_jour_sans_tirets}.zip

    # Vérification du nom de l'archive, qui doit commencer par le n° de DI
    Should Be Equal  ${correct_archive_name_di}  ${archive_name}
    # L'archive doit contenir les 3 pièces du DI
    Archive Should Contain File  ${path_archive}  20160331AVIS.pdf
    Archive Should Contain File  ${path_archive}  20160331AVIS-1.pdf
    Archive Should Contain File  ${path_archive}  20160331AVIS-2.pdf
    Archive Should Contain File  ${path_archive}  20160330AVIS.pdf
    Archive Should Contain File  ${path_archive}  20160331ART.pdf

    # Récupération de l'archive dans le contexte du DA du DI utilisé précédemment
    ${da_libelle} =  Get Substring  ${di_libelle}  0  -2
    ${da_libelle_spaceless} =  Sans espace  ${da_libelle}
    ${correct_archive_name_da} =  Set Variable  ${da_libelle_spaceless}_${date_jour_sans_tirets}.zip

    Depuis l'onglet des pièces du dossier d'autorisation  ${da_libelle}
    ${path_archive}  ${archive_name} =  Télécharger toutes les pièces

    # Le nom de l'archive doit commencer par le numéro de DA (sans le P0 du DI)
    Should Be Equal  ${correct_archive_name_da}  ${archive_name}
    Archive Should Contain File  ${path_archive}  20160331AVIS.pdf
    Archive Should Contain File  ${path_archive}  20160331AVIS-1.pdf
    Archive Should Contain File  ${path_archive}  20160331AVIS-2.pdf
    Archive Should Contain File  ${path_archive}  20160330AVIS.pdf
    Archive Should Contain File  ${path_archive}  20160331ART.pdf

    # Récupération de l'archive depuis la demande d'avis en cours
    Depuis la page d'accueil  consu  consu
    Depuis la demande d'avis en cours du dossier  ${di_libelle}
    On clique sur l'onglet  document_numerise  Pièces & Documents

    ${path_archive}  ${archive_name} =  Télécharger toutes les pièces

    Should Be Equal  ${correct_archive_name_di}  ${archive_name}
    Archive Should Contain File  ${path_archive}  20160331AVIS.pdf
    Archive Should Contain File  ${path_archive}  20160331AVIS-1.pdf
    Archive Should Contain File  ${path_archive}  20160331AVIS-2.pdf
    Archive Should Contain File  ${path_archive}  20160330AVIS.pdf
    Archive Should Contain File  ${path_archive}  20160331ART.pdf

    # On rend l'avis sur la consultation pour qu'elle devienne "passée"
    On clique sur l'onglet  main  Demandes D'avis En Cours
        &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  motivation=Pas de réserves
    ...  fichier_upload=testImportManuel.pdf

    Rendre l'avis sur la consultation du dossier  ${di_libelle}  ${args_avis_consultation}
    Depuis la demande d'avis passée du dossier  ${di_libelle}
    On clique sur l'onglet  document_numerise  Pièces & Documents

    ${path_archive}  ${archive_name} =  Télécharger toutes les pièces

    Should Be Equal  ${correct_archive_name_di}  ${archive_name}
    Archive Should Contain File  ${path_archive}  20160331AVIS.pdf
    Archive Should Contain File  ${path_archive}  20160331AVIS-1.pdf
    Archive Should Contain File  ${path_archive}  20160331AVIS-2.pdf
    Archive Should Contain File  ${path_archive}  20160330AVIS.pdf
    Archive Should Contain File  ${path_archive}  20160331ART.pdf


Vérification du message de notification à l'ajout d'une pièce numérisée

    [Documentation]  Vérification des différents cas concernant la notification
    ...  par message à l'ajout de pièce numérisée.


    # On ajoute un instructeur de la même division que instrpolycomm2
    ${utilisateur_nom} =  Set Variable  Patricia O''Maley
    Depuis la page d'accueil  admin  admin
    Ajouter l'utilisateur  ${utilisateur_nom}  nospam@openmairie.org  pomaley  pomaley  INSTRUCTEUR POLYVALENT  MARSEILLE
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom}  subdivision J  instructeur  ${utilisateur_nom}

    # On ajoute un DI
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Rousseau
    ...  particulier_prenom=Matilda
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #
    # Cas n°1
    #

    # On se connecte avec l'instructeur affecté au dossier pour ajouter une
    # pièce
    Depuis la page d'accueil  instrpolycomm2  instrpolycomm2
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=autres pièces composant le dossier (A0)
    ${dossier_message_1} =  Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    # On vérifie que le message est déjà marqué comme lu
    Depuis l'onglet des messages du dossier d'instruction  ${di_libelle}
    Total Results In Subform Should Be Equal  1  dossier_message
    Depuis le contexte du message dans le dossier d'instruction  ${di_libelle}  ${dossier_message_1}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  lu  Oui

    #
    # Cas n°2
    #

    # On ajoute une nouvelle pièce sur le même dossier avec le même utilisateur
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=autres pièces composant le dossier (A3/A4)
    ${dossier_message_2} =  Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    # On vérifie qu'il n'y a pas de message ajouté
    Should Be Empty  ${dossier_message_2}
    Depuis l'onglet des messages du dossier d'instruction  ${di_libelle}
    Total Results In Subform Should Be Equal  1  dossier_message

    #
    # Cas n°3
    #

    # On se connecte avec un instructeur qui n'est pas affecté au dossier mais
    # de la même division
    Depuis la page d'accueil  pomaley  pomaley
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=autres pièces composant le dossier délivré (A0)
    ${dossier_message_3} =  Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    # On vérifie que le message est marqué comme non lu
    Depuis l'onglet des messages du dossier d'instruction  ${di_libelle}
    Total Results In Subform Should Be Equal  2  dossier_message
    Depuis le contexte du message dans le dossier d'instruction  ${di_libelle}  ${dossier_message_3}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  lu  Non

    #
    # Cas n°4
    #

    # On ajoute une nouvelle pièce avec l'instructeur qui n'est pas affecté au
    # dossier mais de la même division
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=autres pièces composant le dossier délivré (A3/A4)
    ${dossier_message_4} =  Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    # On vérifie qu'il n'y a pas de message ajouté
    Should Be Empty  ${dossier_message_4}
    Depuis l'onglet des messages du dossier d'instruction  ${di_libelle}
    Total Results In Subform Should Be Equal  2  dossier_message

    #
    # Cas n°5
    #

    # On marque comme lu le message du précédent dépôt de pièce
    Marquer comme lu le message dans le dossier d'instruction  ${di_libelle}  ${dossier_message_3}

    # On ajoute une nouvelle pièce avec l'instructeur qui n'est pas affecté au
    # dossier mais de la même division
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=avis obligatoires
    ${dossier_message_5} =  Ajouter une pièce depuis le dossier d'instruction  ${di_libelle}  ${document_numerise_values}

    # On vérifie que le message est marqué comme non lu
    Depuis l'onglet des messages du dossier d'instruction  ${di_libelle}
    Total Results In Subform Should Be Equal  3  dossier_message
    Depuis le contexte du message dans le dossier d'instruction  ${di_libelle}  ${dossier_message_5}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  lu  Non


Traitement des métadonnées

    [Documentation]  Vérification du traitement des métadonnées.

    #
    # Cas n°1 : Premier traitement, tous les types de pièces doivent avoir le
    #           flag de modification à 'true'. Les fichiers déjà existants
    #           doivent avoir les deux nouvelles métadonnées 'aff_da' et
    #           'aff_sc'.
    #
    Depuis la page d'accueil  admin  admin

    @{md_no} =  Create List
    ...  consultationPublique
    ...  consultationTiers

    # Les 2 fichiers sont présents dans le jeu de données et copiés par om_tests
    ${doc01_fichier_path} =  Récupérer le chemin vers le fichier de métadonnées correspondant à l'uid  483cf5c504c9f81a7c7f470c5a209140
    ${doc02_fichier_path} =  Récupérer le chemin vers le fichier de métadonnées correspondant à l'uid  79d433ed40812262504c289980960f18
    ${doc03_fichier_path} =  Récupérer le chemin vers le fichier de métadonnées correspondant à l'uid  891807ffed15ac8fd09bc1032760017b

    Les métadonnées (clé) ne doivent pas être présentes dans le fichier  ${md_no}  ${doc01_fichier_path}
    Les métadonnées (clé) ne doivent pas être présentes dans le fichier  ${md_no}  ${doc02_fichier_path}
    Les métadonnées (clé) ne doivent pas être présentes dans le fichier  ${md_no}  ${doc03_fichier_path}

    Mise à jour des métadonnées  Le traitement s'est correctement déroulé.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Le traitement s'est correctement déroulé.

    # On vérifie les métadonnées du fichier
    ${md} =  Create Dictionary
    ...  consultationPublique=true
    ...  consultationTiers=true
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc01_fichier_path}
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc02_fichier_path}
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc03_fichier_path}

    #
    # Cas n°2 : Il n'y a aucune modification.
    #
    Mise à jour des métadonnées  Il n'y a aucun type de pièces modifié.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Il n'y a aucun type de pièces modifié.
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc01_fichier_path}
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc02_fichier_path}
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc03_fichier_path}

    #
    # Cas n°3 : Modification du paramètre 'aff_da' d'un type de pièces, on
    #           vérifie que la métadonnée sur le fichier de ce type a
    #           correctement été modifiée.
    #
    # On modifie un type de pièces
    ${dnt_code} =  Set Variable  ART
    &{dnt_values} =  Create Dictionary
    ...  aff_da=false
    Modifier le type de pièces  ${dnt_code}  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    #
    Mise à jour des métadonnées  Le traitement s'est correctement déroulé.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Le traitement s'est correctement déroulé.
    # On vérifie les métadonnées du fichier
    ${md} =  Create Dictionary
    ...  consultationPublique=false
    ...  consultationTiers=true
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc02_fichier_path}
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc03_fichier_path}

    #
    # Cas n°4 : Modification du paramètre 'aff_da' d'un type de pièces non utilisé
    #

    ${dnt_code} =  Set Variable  RDA
    &{dnt_values} =  Create Dictionary
    ...  aff_da=false
    Modifier le type de pièces  ${dnt_code}  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    #
    Mise à jour des métadonnées  Il n'y a aucun fichier dont les métadonnées doivent être mises à jour.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Il n'y a aucun fichier dont les métadonnées doivent être mises à jour.
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc01_fichier_path}
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc02_fichier_path}
    Les métadonnées (clé/valeur) doivent être présentes dans le fichier  ${md}  ${doc03_fichier_path}

    #
    # Cas n°5 : Test du fonctionnement normal du web service de maj des métadonnées, puis
    #           suppression d'un document du filestorage alors qu'il est toujours en base.
    #           La mise à jour des métadonnées doit afficher qu'un document est en erreur.
    #
    Remove Directory  ../var/filestorage/79/79d4  true
    # On modifie un type de pièces
    ${dnt_code} =  Set Variable  ART
    &{dnt_values} =  Create Dictionary
    ...  aff_da=true
    Modifier le type de pièces  ${dnt_code}  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Mise à jour des métadonnées  Le traitement s'est correctement déroulé, sauf pour les pièces numérisées ci-dessous :
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Le traitement s'est correctement déroulé, sauf pour les pièces numérisées ci-dessous :
    Valid Message Should Contain  Dossier d'instruction n°AZ0130551200001P0 : le document 20160919ART.pdf n'a pas pu être mis à jour.

    # Test du web service de mise à jour de toutes les pièces
    ${json} =  Set Variable  {"module":"maj_metadonnees_documents_numerises"}
    Vérifier le code retour du web service et vérifier que son message est  Post  maintenance  ${json}  200  Tous les documents ont été traités.

    # On modifie le type de pièces pour que le traitement s'effectue de nouveau
    &{dnt_values} =  Create Dictionary
    ...  aff_da=false
    Modifier le type de pièces  ${dnt_code}  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Suppression du document numérisé sur le filesystem
    Remove Directory  var/digitalization/b/b120

    # Test du web service de mise à jour de toutes les pièces
    ${json} =  Set Variable  { "module": "maj_metadonnees_documents_numerises"}
    Vérifier le code retour du web service et vérifier que son message est  Post  maintenance  ${json}  200  Liste des fichiers en erreur : Dossier d'instruction n°AZ0130551200001P0 - le document 20160919ART.pdf n'a pas pu être mis à jour

    # Remet les valeurs par défaut
    &{dnt_values} =  Create Dictionary
    ...  aff_da=true
    Modifier le type de pièces  ${dnt_code}  ${dnt_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Téléchargement de l'intégralité des documents numerise

    [Documentation]  Contrôle que l'action "télécharger tous les documents" dans l'onglet
    ...  Documents(s) d'un dossier d'instruction produit bien une archive téléchargeable
    ...  contenant toutes les pièces.
    ...  On ajoute plusieurs fois le même type de pièce le même jour pour vérifier que les
    ...  fichiers sont bien suffixés.

    Depuis la page d'accueil  admin  admin

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Compagnon
    ...  particulier_prenom=Jean
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'un document d'instruction et de documents de travail de format différent
    &{document_travail_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.jpg
    ...  date_creation=31/03/2016
    ...  description_type=image
    Ajouter un document de travail depuis le dossier d'instruction  ${di_libelle}  ${document_travail_values}

    &{document_travail_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=31/03/2016
    ...  description_type=pdf
    Ajouter un document de travail depuis le dossier d'instruction  ${di_libelle}  ${document_travail_values}

    &{document_travail_values} =  Create Dictionary
    ...  uid_upload=fichier_1.odt
    ...  date_creation=30/03/2016
    ...  description_type=texte
    Ajouter un document de travail depuis le dossier d'instruction  ${di_libelle}  ${document_travail_values}

    # Récupération du nom des documents d'instruction
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di_libelle}
    ${nom_fichier_doc_instr} =  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}   Get Text  css=#sousform-document_instruction .tab-data td.col-1 span
    # Utilisation de l'action de téléchargement des documents
    ${path_archive}  ${archive_name} =  Télécharger tous les documents

    # Composition du nom correct de l'archive zip
    ${di_libelle_spaceless} =  Sans espace  ${di_libelle}
    ${date_ddmmyyyy} =  Date du jour EN
    ${date_jour_sans_tirets} =  STR_REPLACE  -  ${EMPTY}  ${date_ddmmyyyy}
    ${correct_archive_name_di} =  Set Variable  ${di_libelle_spaceless}_${date_jour_sans_tirets}.zip

    # Vérification du nom de l'archive, qui doit commencer par le n° de DI
    Should Be Equal  ${correct_archive_name_di}  ${archive_name}
    # L'archive doit contenir les 3 documents de travail et le document d'instruction
    Archive Should Contain File  ${path_archive}  20160331DOCTRAV.pdf
    Archive Should Contain File  ${path_archive}  20160331DOCTRAV.jpg
    Archive Should Contain File  ${path_archive}  20160330DOCTRAV.odt
    Archive Should Contain File  ${path_archive}  ${nom_fichier_doc_instr}.pdf


Configuration des méthodes de traitement sur les métadonnées des fichiers liés aux dossiers d'instruction
    [Documentation]  Vérification de l'exécution des méthodes de traitements sur
    ...  les métadonnées des fichiers liés aux dossiers d'instruction,
    ...  configurées depuis le connecteur du filestorage.

    # On ajoute le DI depuis lequel on va vérifier la mise à jour des
    # métadonnées
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Duffet
    ...  particulier_prenom=Felicien
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On ajoute un fichier de chaque lien possible avec le DI :
    # - l'instruction est ajoutée automatiquement grâce au récépissé de la demande ;
    # - une pièce numérisée ;
    # - une consultation et le fichier joint au rendu d'avis ;
    # - le rapport d'instruction
    Depuis la page d'accueil  instrpoly  instrpoly
    &{args_dn} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=avis obligatoires
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${args_dn}
    Ajouter une consultation depuis un dossier  ${di}  59.01 - Direction de l'Eau et de l'Assainissement
    Depuis la page d'accueil  consu  consu
    &{args_ac} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  motivation=Pas de réserves
    ...  fichier_upload=testImportManuel.pdf
    Rendre l'avis sur la consultation du dossier  ${di}  ${args_ac}
    Depuis la page d'accueil  instrpoly  instrpoly
    &{args_ri} =  Create Dictionary
    ...  description_projet_om_html=Description du projet
    Ajouter et finaliser le rapport d'instruction  ${di}  ${args_ri}

    # On récupère les chemins de chaque fichier info dont le l'uid est accessible depuis
    # le DOM
    ${dn_info_path} =  Récupérer le chemin du fichier .info de la pièce stocké  ${di}  avis obligatoires
    ${consultation_fj_info_path} =  Récupérer le chemin du fichier .info du fichier joint de la consultation  ${di}  59.01 - Direction de l'Eau et de l'Assainissement
    @{list_path}  Create List  ${dn_info_path}  ${consultation_fj_info_path}

    # On vérifie les métadonnées de chaque fichier afin de contrôler que la
    # métadonnée *concerneERP* à comme valeur 'false'
    :FOR  ${path}  IN  @{list_path}
    \  ${info} =  Get File  ${path}
    \  Should Contain  ${info}  concerneERP=false

    # On définit les deux modification de DI
    &{args_di_true} =  Create Dictionary
    ...  erp=true
    &{args_di_false} =  Create Dictionary
    ...  erp=false

    ##
    ## Sans la configuration du traitement des métadonnées dans le connecteur du
    ## filestorage
    ##

    # On coche le champ ERP du dossier d'instruction pour vérifier que la
    # métadonnée des fichiers n'est pas mise à jour (valeur 'false')
    Modifier le dossier d'instruction  ${di}  ${args_di_true}
    :FOR  ${path}  IN  @{list_path}
    \  ${info} =  Get File  ${path}
    \  Should Contain  ${info}  concerneERP=false
    Modifier le dossier d'instruction  ${di}  ${args_di_false}

    ##
    ## Avec la configuration du traitement des métadonnées dans le connecteur du
    ## filestorage, mais sans la méthode de traitement renseignée
    ##

    # On change la configuration du filestorage
    Move File  ..${/}dyn${/}filestorage.inc.php  ..${/}dyn${/}filestorage.inc.php.bak
    Copy File  ..${/}tests${/}binary_files${/}filestorage_1.inc.php  ..${/}dyn${/}
    Move File  ..${/}dyn${/}filestorage_1.inc.php  ..${/}dyn${/}filestorage.inc.php

    # On coche le champ ERP du dossier d'instruction pour vérifier que la
    # métadonnée des fichiers n'est pas mise à jour (valeur 'false')
    Modifier le dossier d'instruction  ${di}  ${args_di_true}
    :FOR  ${path}  IN  @{list_path}
    \  ${info} =  Get File  ${path}
    \  Should Contain  ${info}  concerneERP=false
    Modifier le dossier d'instruction  ${di}  ${args_di_false}

    ##
    ## Avec la configuration du traitement des métadonnées dans le connecteur du
    ## filestorage et la méthode de traitement renseignée
    ##

    # On change la configuration du filestorage
    Copy File  ..${/}tests${/}binary_files${/}filestorage_2.inc.php  ..${/}dyn${/}
    Move File  ..${/}dyn${/}filestorage_2.inc.php  ..${/}dyn${/}filestorage.inc.php

    # On coche le champ ERP du dossier d'instruction pour vérifier que la
    # métadonnée des fichiers est mise à jour (valeur 'true')
    Modifier le dossier d'instruction  ${di}  ${args_di_true}
    :FOR  ${path}  IN  @{list_path}
    \  ${info} =  Get File  ${path}
    \  Should Contain  ${info}  concerneERP=true

    # On modifie à nouveau le DI sans changer la valeur du champ ERP et on
    # contrôle que la métadonnée des fichiers n'est pas modifiée (valeur 'true')
    ${args_di} =  Create Dictionary
    Modifier le dossier d'instruction  ${di}  ${args_di}
    :FOR  ${path}  IN  @{list_path}
    \  ${info} =  Get File  ${path}
    \  Should Contain  ${info}  concerneERP=true

    # On modifie une dernière fois le DI en changeant la valeur du champ ERP et
    # on inspecte la métadonnée des fichiers (valeur 'false')
    Modifier le dossier d'instruction  ${di}  ${args_di_false}
    :FOR  ${path}  IN  @{list_path}
    \  ${info} =  Get File  ${path}
    \  Should Contain  ${info}  concerneERP=false

    # On remet la configuration du filestorage par défaut
    Move File  ..${/}dyn${/}filestorage.inc.php.bak  ..${/}dyn${/}filestorage.inc.php

Trouillotage numérique
    [Documentation]  Vérification de l'affichage du tampon
    ...  et de son contenu.

    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  option_trouillotage_numerique  true  agglo

    # On ajoute le DI depuis lequel on va vérifier le trouillotage numérique
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bourdon
    ...  particulier_prenom=Lucidota
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On ajoute une pièce numérisée sur le DI
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=01/01/1999
    ...  document_numerise_type=arrêté
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    # Vérification que le fichier est remplacé par celui du service de
    # trouillotage
    Depuis le contexte de la pièce par le dossier d'instruction  ${di}  arrêté
    Click On Link  Télécharger
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST TROUILLOTAGE PDF
    Close PDF

    Supprimer le paramètre  option_trouillotage_numerique


Constitution du dossier final
    [Documentation]  Vérification des différentes étapes lors de la constitution
    ...  du dossier final
    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  id_avis_consultation_tacite  4  agglo

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Alric
    ...  particulier_prenom=Lily-June
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  date_demande=01/01/2018
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Vérification que lorsqu'un document d'instruction est récupéré,
    # si celui-ci n'a pas de date de finalisation,
    # alors il doit être traité comme les autres documents sans date (rapport d'instruction)

    Ajouter une instruction au DI et la finaliser  ${di}  Consultation service d'hygiène municipal

    ${date_finalisation_instr} =  Set Variable  ${EMPTY}
    &{date_instruction} =  Create Dictionary
    ...  date_finalisation_courrier=${date_finalisation_instr}
    Modifier le suivi des dates  ${di}  Consultation service d'hygiène municipal  ${date_instruction}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Click Element  css=a.om-prev-icon.om-icon-16.toutes-les-pieces-16.right
    Page Should Not Contain  Undefined variable

    # Modification de la date de finalisation de l'instruction pour pouvoir vérifier si la bonne
    # date est affiché dans l'onglet pièces & documents
    ${date_finalisation_instr} =  Set Variable  02/06/2001
    &{date_instruction} =  Create Dictionary
    ...  date_finalisation_courrier=${date_finalisation_instr}
    ...  date_envoi_signature=03/06/2001
    ...  date_retour_signature=04/06/2001
    Modifier le suivi des dates  ${di}  Notification du delai legal maison individuelle  ${date_instruction}

    #charger des pièces
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté
    ...  date_creation=05/05/2018
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté
    ...  date_creation=15/03/2018
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}
    #
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
    Depuis l'onglet consultation du dossier  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  action-soustab-consultation-corner-ajouter
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#service
    Select From List By Label  css=select#service  59.12 - Direction de la Propreté Urbaine
    Input Text  css=#date_envoi  15/02/2018
    Click On Submit Button In Subform
    Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées
    # Ajout d'une date de retour
    &{date_retour} =  Create Dictionary
    ...  date_retour=16/03/2018
    Modifier la consultation  ${date_retour}
    Click On Back Button In Subform
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=table.tab-tab
    ...  pour conformite
    Element Should Contain  css=table.tab-tab  pour information
    Element Should Contain  css=table.tab-tab  avec avis attendu

    #Valider et finaliser le rapport d'instruction et créer un rapport d'instruction historisé
    Depuis le contexte du rapport d'instruction  ${di}
    Click On Submit Button In Subform
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button In Subform
    Depuis le contexte du rapport d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La finalisation du document s'est effectuée avec succès.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  definalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La définalisation du document s'est effectuée avec succès.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La finalisation du document s'est effectuée avec succès.
    #

    Depuis la page d'accueil  instr  instr
    # Ajout d'un document de travail
    &{document_travail_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  description_type=document de travail
    ...  date_creation=06/06/2001
    Ajouter un document de travail depuis le dossier d'instruction  ${di}  ${document_travail_values}

    # Récupération du nom du fichier du doc de travail et du doc d'instruction
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di}
    Wait Until Element Is Visible  id=sousform-document_travail
    ${nom_fichier_doc_trav} =  Get Text  css=#sousform-document_travail .tab-data td.col-1 span
    ${nom_fichier_doc_instr} =  Get Text  css=#sousform-document_instruction .tab-data td.col-1 span
  
    #On se place sur l'onglet de gestion des pièces du DI
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    #On bascule vers le dossier final
    Click Element  css=a.om-prev-icon.om-icon-16.toutes-les-pieces-16.right
    Sleep  1
    Page Should Not Contain Element  css=#telecharger_dossier_final

    # Vérifie que tous les documents attendus sont présents, que le document de travail
    # n'est pas visible et que les dates sont correctes
    ${pieces} =  Set Variable
    @{locators_pieces_document} =  Get WebElements  css=.tab-data
    :FOR  ${locator}  IN  @{locators_pieces_document}
    \  ${line} =  Get Text   ${locator}
    \  ${pieces} =  Catenate  ${pieces}  ${line}
    Should Contain  ${pieces}  rapport_instruction
    Should Contain  ${pieces}  Non applicable
    Should Contain  ${pieces}  consultation_avis_pour_conformite
    Should Contain  ${pieces}  consultation_pour_conformite_tacite
    Should Contain  ${pieces}  consultation_avec_avis_attendu
    Should Contain  ${pieces}  03/02/2018
    Should Contain  ${pieces}  consultation_pour_information
    Should Contain  ${pieces}  16/03/2018
    Should Contain  ${pieces}  20180505ARRT.pdf
    Should Contain  ${pieces}  05/05/2018
    Should Contain  ${pieces}  ${nom_fichier_doc_instr}
    Should Contain  ${pieces}  ${date_finalisation_instr}
    Should Not Contain  ${pieces}  ${nom_fichier_doc_trav}
    

    #vérifier que les éléments de la classe en surbrillance sont ceux qu'on attend (boucle for)
    ${pieces_recommandees} =  Set Variable
    @{locators_pieces_recommandees} =  Get WebElements  css=.dossier_final_piece_recommandee
    :FOR  ${locator}  IN  @{locators_pieces_recommandees}
    \  ${line} =  Get Text   ${locator}
    \  ${pieces_recommandees} =  Catenate  ${pieces_recommandees}  ${line}
    Should Contain  ${pieces_recommandees}  rapport_instruction_2.pdf
    Should Contain  ${pieces_recommandees}  consultation_avis_pour_conformite
    Should Contain  ${pieces_recommandees}  consultation_pour_conformite_tacite
    Should Contain  ${pieces_recommandees}  20180505ARRT.pdf
    Should Not Contain  ${pieces_recommandees}  consultation_avec_avis_attendu
    Should Not Contain  ${pieces_recommandees}  consultation_pour_information
    Should Not Contain  ${pieces_recommandees}  20180315ARRT.pdf
    Should Not Contain  ${pieces_recommandees}  rapport_instruction_1.pdf
    #On vérifie que rien n'est pré coché
    @{locators_checkboxes_all} =  Get WebElements  css=.checkbox-dossier_final
    :FOR  ${locator}  IN  @{locators_checkboxes_all}
    \  Checkbox Should Not Be Selected  ${locator}
    # vérification des boutons de coche
    # Vérifie que toutes les cases à cocher sont sélectionnées
    Click Button  id=checkbox_select_all_none
    Sleep  1
    :FOR  ${locator}  IN  @{locators_checkboxes_all}
    \  Checkbox Should Be Selected  ${locator}
    # Vérifie que toutes les cases à cocher sont désélectionnées
    Click Button  id=checkbox_select_all_none
    :FOR  ${locator}  IN  @{locators_checkboxes_all}
    \  Checkbox Should Not Be Selected  ${locator}
    # Vérifie que seulement les cases ) cocher recommandées sont sélectionnées
    Click Button  Sélectionner les pièces et documents recommandés
    @{locators_checkboxes_pieces_recommandees} =  Get WebElements  css=tr.dossier_final_piece_recommandee td.checkbox-dossier_final
    :FOR  ${locator}  IN  @{locators_checkboxes_pieces_recommandees}
    \  Checkbox Should Be Selected  ${locator}
    #
    #Cliquer sur Constituer le dossier final
    Click Element  name:constituer_dossier_final
    Wait Until Element Is Visible  css=.message.ui-widget.ui-corner-all.ui-state-highlight
    Element Should Contain  css=.message.ui-widget.ui-corner-all.ui-state-highlight   Le dossier final a bien été constitué
    Page Should Not Contain Element  css=div#telecharger_dossier_final

    # Télécharger toutes les pièces et vérifier l'archive
    ${path_archive}  ${archive_name} =  Télécharger le dossier final
    # Composition du nom correct de l'archive zip
    ${di_libelle_spaceless} =  Sans espace  ${di}
    ${date_ddmmyyyy} =  Date du jour EN
    ${date_jour_sans_tirets} =  STR_REPLACE  -  ${EMPTY}  ${date_ddmmyyyy}
    ${correct_archive_name_di} =  Set Variable  ${di_libelle_spaceless}_dossier_final_${date_jour_sans_tirets}.zip
    # Vérification du nom de l'archive, et de son contenu
    Should Be Equal  ${correct_archive_name_di}  ${archive_name}
    Archive Should Contain File  ${path_archive}  20180505ARRT.pdf

    #Recharger et vérifier le précochage
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    #On clique sur le sous onglet correspondant au dossier final
    Click Element  css=a.om-prev-icon.om-icon-16.toutes-les-pieces-16.right
    Sleep  1
    La page ne doit pas contenir d'erreur
    #Le dernier dossier final comportait toutes les pièces recommandées cochées
    :FOR  ${locator}  IN  @{locators_checkboxes_pieces_recommandees}
    \  Checkbox Should Be Selected  ${locator}
    #télécharger toutes les pièces et vérifier l'archive
    ${path_archive}  ${archive_name} =  Télécharger le dossier final
    # Composition du nom correct de l'archive zip
    ${di_libelle_spaceless} =  Sans espace  ${di}
    ${date_ddmmyyyy} =  Date du jour EN
    ${date_jour_sans_tirets} =  STR_REPLACE  -  ${EMPTY}  ${date_ddmmyyyy}
    ${correct_archive_name_di} =  Set Variable  ${di_libelle_spaceless}_dossier_final_${date_jour_sans_tirets}.zip

    # Vérification du nom de l'archive, et de son contenu
    Should Be Equal  ${correct_archive_name_di}  ${archive_name}
    Archive Should Contain File  ${path_archive}  20180505ARRT.pdf

    # Ajoute un rapport d'instruction historisé à l'archive
    ${locator_checkbox} =  Set Variable  xpath=//span[normalize-space(text()) = "rapport_instruction_1.pdf"]//ancestor::tr/td[contains(@class, "col-0")]/input[contains(@class, "checkbox-dossier_final")]
    Select Checkbox  xpath=//span[normalize-space(text()) = "rapport_instruction_1.pdf"]//ancestor::tr/td[contains(@class, "col-0")]/input[contains(@class, "checkbox-dossier_final")]
    #Cliquer sur Constituer le dossier final
    Click Element  name:constituer_dossier_final
    Wait Until Element Is Visible  css=.message.ui-widget.ui-corner-all.ui-state-highlight
    Element Should Contain  css=.message.ui-widget.ui-corner-all.ui-state-highlight   Le dossier final a bien été constitué
    Page Should Not Contain Element  css=div#telecharger_dossier_final
    #Le dernier dossier final comportait toutes les pièces recommandées cochées
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    #On clique sur le sous onglet correspondant au dossier final
    Click Element  css=a.om-prev-icon.om-icon-16.toutes-les-pieces-16.right
    Sleep  1
    La page ne doit pas contenir d'erreur
    #Le dossier final doit contenir le rapport historisé
    Checkbox Should Be Selected  ${locator_checkbox}
    
    Depuis la page d'accueil  admin  admin
    Modifier le paramètre  id_avis_consultation_tacite  -1  agglo


Vérification de l'affichage de la prévisualisation des pièces

    [Documentation]  Vérifie l'affichage de la prévisualisation des pièces pour un pdf
    ...  et une image et un type de document non prévisualisable.

    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Cloutier
    ...  particulier_prenom=Agate
    ...  om_collectivite=MARSEILLE
    #
    ${di_preview} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  admin  admin

    # ajoute une pièce au dossier
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=10/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di_preview}  ${document_numerise_values}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.jpg
    ...  date_creation=11/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di_preview}  ${document_numerise_values}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=fichier_1.odt
    ...  date_creation=12/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di_preview}  ${document_numerise_values}

    # reviens sur le listing des pièces pour vérifier l'affichage dans le contexte du DI
    Click On Back Button In Subform

    # vérifie que la pièce a bien été ajoutée
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#sousform-document_numerise  20160910ART.pdf
    Element Should Contain  css=#sousform-document_numerise  20160911ART.jpg
    Element Should Contain  css=#sousform-document_numerise  20160912ART.odt

    # Test prévisualisation du pdf
    # clique sur le lien de prévisualisation (attends la fenêtre modale)
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "20160910ART.pdf"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    ...  css=.ui-widget-overlay

    # vérifie que l'iframe PDF est bien chargée dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf

    # sélectionne l'iframe PDF
    Select Frame  frame_pdf

    # vérifie que le PDF contient la bonne valeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=div#viewer .page .textLayer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#viewer .page .textLayer  TEST IMPORT MANUEL 1

    # désélectionne l'iframe PDF
    Unselect Frame

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # Test prévisualisation de l'image
    # clique sur le lien de prévisualisation (attends la fenêtre modale)
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "20160911ART.jpg"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    ...  css=.ui-widget-overlay

    # vérifie que l'image est bien affiché dans l'overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog img

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # Test prévisualisation pour un type de document non prévisualisable
    # clique sur le lien de prévisualisation (attends la fenêtre modale)
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "20160912ART.odt"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    ...  css=.ui-widget-overlay

    # vérifie que le message d'information et le lien de téléchargement sont bien affiché
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div.text-info  Le format de ce fichier ne permet pas de le prévisualiser.
    Element Should Be Visible  css=a.lien-info

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # On ajoute une consultation pour vérifier le contexte d'une demande d'avis
    Ajouter une consultation depuis un dossier  ${di_preview}  59.01 - Direction de l'Eau et de l'Assainissement
    Depuis la page d'accueil  consu  consu
    Depuis l'onglet des pièces de la demande d'avis en cours du dossier d'instruction  ${di_preview}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#sousform-document_numerise  20160910ART.pdf
    Element Should Contain  css=#sousform-document_numerise  20160911ART.jpg
    Element Should Contain  css=#sousform-document_numerise  20160912ART.odt

    # Test PDF
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "20160910ART.pdf"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf
    Select Frame  frame_pdf
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=div#viewer .page .textLayer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#viewer .page .textLayer  TEST IMPORT MANUEL 1
    Unselect Frame
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay
    # Test image
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "20160911ART.jpg"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog img
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay
    # Test Autre
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "20160912ART.odt"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div.text-info  Le format de ce fichier ne permet pas de le prévisualiser.
    Element Should Be Visible  css=a.lien-info
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # Vérifie l'affichage dans le contexte du DA
    Depuis la page d'accueil  guichet  guichet
    ${da_preview} =  Get Substring  ${di_preview}  0  -2
    Depuis l'onglet des pièces du dossier d'autorisation  ${da_preview}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#sousform-document_numerise  20160910ART.pdf
    Element Should Contain  css=#sousform-document_numerise  20160911ART.jpg
    Element Should Contain  css=#sousform-document_numerise  20160912ART.odt
    # Test PDF
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "20160910ART.pdf"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf
    Select Frame  frame_pdf
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=div#viewer .page .textLayer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#viewer .page .textLayer  TEST IMPORT MANUEL 1
    Unselect Frame
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay
    # Test Image
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "20160911ART.jpg"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog img
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay
    # Test Autre
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "20160912ART.odt"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    ...  css=.ui-widget-overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div.text-info  Le format de ce fichier ne permet pas de le prévisualiser.
    Element Should Be Visible  css=a.lien-info
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # supprime les pièces du dossier
    Depuis la page d'accueil  admin  admin
    Supprimer une pièce depuis le dossier d'instruction  ${di_preview}  arrêté retour préfecture
    Supprimer une pièce depuis le dossier d'instruction  ${di_preview}  arrêté retour préfecture
    Supprimer une pièce depuis le dossier d'instruction  ${di_preview}  arrêté retour préfecture


Vérification de l'affichage de la prévisualisation des documents d'instruction

    [Documentation]  Vérifie l'affichage de la prévisualisation des documents d'instruction
    ...  et du rapport d'instruction

    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Cloutier
    ...  particulier_prenom=Jeanne
    ...  om_collectivite=MARSEILLE
    #
    ${di_preview} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr

    # Récupère le nom d'un document d'instruction existe
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di_preview}
    Wait Until Element Is Visible  id=sousform-document_travail
    ${nom_fichier_doc_instr} =  Get Text  css=#sousform-document_instruction .tab-data td.col-1 span

    # clique sur le lien de prévisualisation (attends la fenêtre modale)
    Click Element Until New Element  css=div[data-view="document_numerise_dossier_final"]  css=div.switcher__label.onglet_active[data-view="document_numerise_dossier_final"]

    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "${nom_fichier_doc_instr}"]//ancestor::tr/td[contains(@class, "col-0")]/a/span[normalize-space(text()) = "Prévisualiser"]/ancestor::a
    ...  css=.ui-widget-overlay

    # vérifie que l'iframe PDF est bien chargée dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf

    # sélectionne l'iframe PDF
    Select Frame  frame_pdf

    # vérifie que le PDF contient la bonne valeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=div#viewer .page .textLayer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#viewer .page .textLayer  RECEPISSE DE DEPOT

    # désélectionne l'iframe PDF
    Unselect Frame

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-instruction_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay


    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu  storage  INSTRUCTEUR
    # Ajout et finalisation (x2) du rapport d'instruction
    Depuis la page d'accueil  instr  instr
    &{args_ri} =  Create Dictionary
    ...  description_projet_om_html=Description du projet v1
    Ajouter et finaliser le rapport d'instruction  ${di_preview}  ${args_ri}
    # Definaliser
    Depuis le contexte du rapport d'instruction  ${di_preview}
    Click On SubForm Portlet Action  rapport_instruction  definalise
    Wait Until Page Contains  La définalisation du document s'est effectuée avec succès.
    # Re-finalise pour avoir 2 versions
    &{args_ri} =  Create Dictionary
    ...  description_projet_om_html=Description du projet v2
    Modifier le rapport d'instruction  ${di_preview}  ${args_ri}
    Finaliser le rapport d'instruction  ${di_preview}

    # clique sur le lien de prévisualisation (attends la fenêtre modale)
    Depuis l'onglet des pièces du dossier d'instruction  ${di_preview}

    Click Element Until New Element  css=div[data-view="document_numerise_dossier_final"]  css=div.switcher__label.onglet_active[data-view="document_numerise_dossier_final"]
    Element Should Contain  css=#sousform-document_numerise table.tab-tab  rapport_instruction_1.pdf
    Element Should Contain  css=#sousform-document_numerise tr.dossier_final_piece_recommandee  rapport_instruction_2.pdf
    # Teste la prévisualisation du rapport d'instruction
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "rapport_instruction_1.pdf"]//ancestor::tr/td[contains(@class, "col-0")]/a/span[normalize-space(text()) = "Prévisualiser"]/ancestor::a
    ...  css=.ui-widget-overlay

    # vérifie que l'iframe PDF est bien chargée dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf

    # sélectionne l'iframe PDF
    Select Frame  frame_pdf

    # vérifie que le PDF contient la bonne valeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=div#viewer .page .textLayer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#viewer .page .textLayer  Description du projet v1

    # désélectionne l'iframe PDF
    Unselect Frame

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-storage_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # Teste la prévisualisation du rapport d'instruction historisé
    Click Element Until New Element
    ...  xpath=//span[normalize-space(text()) = "rapport_instruction_2.pdf"]//ancestor::tr/td[contains(@class, "col-0")]/a/span[normalize-space(text()) = "Prévisualiser"]/ancestor::a
    ...  css=.ui-widget-overlay

    # vérifie que l'iframe PDF est bien chargée dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf

    # sélectionne l'iframe PDF
    Select Frame  frame_pdf

    # vérifie que le PDF contient la bonne valeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=div#viewer .page .textLayer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#viewer .page .textLayer  Description du projet v2

    # désélectionne l'iframe PDF
    Unselect Frame

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-rapport_instruction_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    Depuis la page d'accueil  admin  admin
    Supprimer le droit depuis le contexte du profil  storage  INSTRUCTEUR

Vérification de l'affichage de la prévisualisation des documents de consultation

    [Documentation]  Vérifie l'affichage de la prévisualisation des documents de consultation

    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Cloutier
    ...  particulier_prenom=Marc
    ...  om_collectivite=MARSEILLE
    #
    ${di_preview} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'une consultation
    Ajouter une consultation depuis un dossier  ${di_preview}  59.01 - Direction de l'Eau et de l'Assainissement
    
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    # clique sur le lien de prévisualisation (attends la fenêtre modale)
    Depuis l'onglet des pièces du dossier d'instruction  ${di_preview}
    Click Element Until New Element  css=div[data-view="document_numerise_dossier_final"]  css=div.switcher__label.onglet_active[data-view="document_numerise_dossier_final"]
    Click Element Until New Element
    ...  xpath=//td[normalize-space(text()) = "consultation_pour_conformite"]//ancestor::tr/td[contains(@class, "col-0")]/a/span[normalize-space(text()) = "Prévisualiser"]/ancestor::a
    ...  css=.ui-widget-overlay

    # vérifie que l'iframe PDF est bien chargée dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf

    # sélectionne l'iframe PDF
    Select Frame  frame_pdf

    # vérifie que le PDF contient la bonne valeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=div#viewer .page .textLayer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#viewer .page .textLayer  Direction de l'Eau et de l'Assainissement

    # désélectionne l'iframe PDF
    Unselect Frame

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-consultation_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay


Vérification de l'affichage de la prévisualisation des documents de travail

    [Documentation]  Vérifie l'affichage de la prévisualisation des documents de travail.
    ...  Vérifie que l'action de prévisualisation n'est pas présente pour les fichiers qui
    ...  ne sont ni des pdf, ni des images.
    ...  Test l'affichage des images et des pdf.

    Depuis la page d'accueil  admin  admin
    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Monsieur
    ...  particulier_nom=Cloutier
    ...  particulier_prenom=Paul
    ...  om_collectivite=MARSEILLE
    #
    ${di_preview} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout de documents de travail de différent format
    &{doc_travail_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  description_type=document de travail format pdf
    ...  date_creation=25/08/2021
    ${doc_travail} =  Ajouter un document de travail depuis le dossier d'instruction  ${di_preview}  ${doc_travail_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    &{doc_travail_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.jpg
    ...  description_type=document de travail format jpg
    ...  date_creation=25/08/2021
    ${doc_travail} =  Ajouter un document de travail depuis le dossier d'instruction  ${di_preview}  ${doc_travail_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    &{doc_travail_values} =  Create Dictionary
    ...  uid_upload=fichier_1.odt
    ...  description_type=document de travail format odt
    ...  date_creation=25/08/2021
    ${doc_travail} =  Ajouter un document de travail depuis le dossier d'instruction  ${di_preview}  ${doc_travail_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Test de la prévisualisation d'un pdf
    Depuis la page d'accueil  instrpolycomm  instrpolycomm
    # clique sur le lien de prévisualisation (attends la fenêtre modale)
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di_preview}
    Click Element Until New Element
    ...  xpath=//a[normalize-space(text()) = "document de travail format pdf"]//ancestor::tr/td[contains(@class, "icons")]/a/span[normalize-space(text()) = "Prévisualiser"]/ancestor::a
    ...  css=.ui-widget-overlay

    # vérifie que l'iframe PDF est bien chargée dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.ui-dialog iframe#frame_pdf

    # sélectionne l'iframe PDF
    Select Frame  frame_pdf

    # vérifie que le PDF contient la bonne valeur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=div#viewer .page .textLayer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=div#viewer .page .textLayer  TEST IMPORT MANUEL 1

    # désélectionne l'iframe PDF
    Unselect Frame

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # Test de la prévisualisation d'une image
    Depuis la page d'accueil  instr  instr
    # clique sur le lien de prévisualisation (attends la fenêtre modale)
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di_preview}
    Click Element Until New Element
    ...  xpath=//a[normalize-space(text()) = "document de travail format jpg"]//ancestor::tr/td[contains(@class, "icons")]/a/span[normalize-space(text()) = "Prévisualiser"]/ancestor::a
    ...  css=.ui-widget-overlay

    # vérifie que l'image est bien chargée dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.previsualise_img

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay

    # Test de l'affichage de l'action pour les autres types de fichier
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di_preview}
    Click Element Until New Element
    ...  xpath=//a[normalize-space(text()) = "document de travail format odt"]//ancestor::tr/td[contains(@class, "icons")]/a/span[normalize-space(text()) = "Prévisualiser"]/ancestor::a
    ...  css=.ui-widget-overlay

    # vérifie que le texte et le lien de téléchargement sont bien chargée dans la fenêtre modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Be Visible  css=.text-info
    Element Should Be Visible  css=a.lien-info

    # ferme la fenêtre modale en cliquant sur le bouton retour
    Click Element Until No More Element
    ...  css=.ui-dialog div#sousform-document_numerise_preview_edition .retour
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Not Be Visible  css=.ui-widget-overlay
    

Affichage des miniatures

    [Documentation]  Test l'affichage des miniatures des pièces.

    # Activation de l'option de miniaturisation
    Depuis la page d'accueil  admin  admin
    &{option_miniature} =  Create Dictionary
    ...  libelle=option_miniature_fichier
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${option_miniature}

    # Liste des arguments pour la demande
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    # Liste des arguments pour le pétitionnaire
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Cloutier
    ...  particulier_prenom=Agate
    ...  om_collectivite=MARSEILLE
    #
    ${di_preview} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # ajoute des pièces au dossier
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=20/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di_preview}  ${document_numerise_values}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.jpg
    ...  date_creation=22/09/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di_preview}  ${document_numerise_values}

    # reviens sur le listing des pièces pour vérifier l'affichage dans le contexte du DI
    Click On Back Button In Subform
    # Vérifie que l'icone de prévisualisation est visible mais pas les images
    Wait Until Page Contains
    ...  20160920ART.pdf
    Page Should Contain Element  xpath=//span[normalize-space(text()) = "20160920ART.pdf"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    Page Should Contain Element  xpath=//span[normalize-space(text()) = "20160922ART.jpg"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    Element Should not be visible  css=span.tooltip-span img  

    # Test l'affichage de la miniature
    Mouse Over  xpath=//span[normalize-space(text()) = "20160920ART.pdf"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    Element Should be visible  xpath=//span[normalize-space(text()) = "20160920ART.pdf"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]/span/img

    # Test l'affichage de la miniature
    Mouse Over  xpath=//span[normalize-space(text()) = "20160922ART.jpg"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]
    Element Should be visible  xpath=//span[normalize-space(text()) = "20160922ART.jpg"]//ancestor::tr/td[contains(@class, "icons")]/a/span[contains(@title, "Prévisualiser")]/span/img

    # Désactivation de l'option de miniaturisation
    Depuis la page d'accueil  admin  admin
    Supprimer le paramètre  option_miniature_fichier

Vérification de l'absence de doublon dans la liste des documents d'instruction de l'onglet Docs. Instructop,
    [Documentation]  Test vérifiant que si une lettretype non active est liée à une instruction,
    ...  avec une autre lettretype de même id mais qui est active, elle n'apparaît pas dans le listing
    ...  des documents d'instruction de l'onglet pièce.
    ...  Vérifie également que si 2 lettretypes actives de même id existent c'est celle liée à la collectivité
    ...  du dossier ou, si il n'y a pas de collectivité correspondante, celle de la collectivité de niveau 2
    ...  qui est affichée


    Depuis la page d'accueil  admin  admin
    # Ajout d'une lettretype non active de même id que le recepisse de depot
    &{args_lettretype} =  Create Dictionary
    ...  id=TNR_DOUBLON_DOC_INSTR
    ...  libelle=lettretype non active
    ...  sql=Aucune REQUÊTE
    ...  titre=null
    ...  corps=null
    ...  actif=false
    ...  collectivite=agglo
    Ajouter la lettre-type depuis le menu  &{args_lettretype}
    &{args_lettretype} =  Create Dictionary
    ...  id=TNR_DOUBLON_DOC_INSTR
    ...  libelle=lettretype agglo
    ...  sql=Aucune REQUÊTE
    ...  titre=null
    ...  corps=null
    ...  actif=true
    ...  collectivite=agglo
    Ajouter la lettre-type depuis le menu  &{args_lettretype}
    &{args_lettretype} =  Create Dictionary
    ...  id=TNR_DOUBLON_DOC_INSTR
    ...  libelle=lettretype allauch
    ...  sql=Aucune REQUÊTE
    ...  titre=null
    ...  corps=null
    ...  actif=true
    ...  collectivite=ALLAUCH
    Ajouter la lettre-type depuis le menu  &{args_lettretype}

    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement1} =  Create Dictionary
    ...  libelle=TEST_DOUBLON_LETTRETYPE
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ...  lettretype=TNR_DOUBLON_DOC_INSTR lettretype agglo
    Ajouter l'événement depuis le menu  ${args_evenement1}

    # Cas 1 : Vérification dans l'onglet pièce que le recepisse de depot est visible mais pas
    # la lettretype non active
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Beaudouin
    ...  particulier_prenom=Serge
    ...  om_collectivite=MARSEILLE
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_libelle}  TEST_DOUBLON_LETTRETYPE
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di_libelle}
    Element Should Contain  css=#sousform-document_instruction  lettretype agglo
    Element Should Not Contain  css=#sousform-document_instruction  lettretype non active
    # vérifie que la lettretype associée à la collectivité allauch n'est pas visible
    Element Should Not Contain  css=#sousform-document_instruction  lettretype allauch

    # Cas 2 : vérifie que la lettretype de la collectivité est affiché et pas celle lié à l'agglo
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=ALLAUCH
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=DOUBLON
    ...  particulier_prenom=DOCS. INSTRUCTION
    ...  om_collectivite=ALLAUCH
    ${di_libelle} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_libelle}  TEST_DOUBLON_LETTRETYPE
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di_libelle}
    Element Should Contain  css=#sousform-document_instruction  lettretype allauch
    # vérifie que la lettretype non active et celle associée à l'agglo ne sont pas visible
    Element Should Not Contain  css=#sousform-document_instruction  lettretype non active
    Element Should Not Contain  css=#sousform-document_instruction  lettretype agglo


TNR Vérification que le type de pièce est bien affiché pour tous les profils autorisé
    [Documentation]  Test vérifiant que si un utilisateur a un profil lui permettant
    ...  d'accéder à l'onglet Pièce(s) alors la catégorie des pièces doit être visible.

    # Création d'un dossier et ajout d'une pièce a ce dossier
    Depuis la page d'accueil  admin  admin

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Beauchesne
    ...  particulier_prenom=Alexis
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Wait Until Page Contains  arrêté retour préfecture
    La page ne doit pas contenir d'erreur

    # Changement de profil pour un profil pouvant voir les pièces mais
    # pas les modifier
    Depuis la page d'accueil  dirrec  dirrec
    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Wait Until Page Contains  arrêté retour préfecture
    La page ne doit pas contenir d'erreur

Vérification que les instructeurs ne peuvent ajouter que des documents de travail
    [Documentation]  Ce tests sert à vérifier que les droits d'ajout des pièces
    ...  et des documents de travail sont bien gérés séparemment. Vérifie que pour
    ...  les instructeurs il est possible d'ajouter des documents de travail mais
    ...  pas des pièces.
    ...  Vérifie également que depuis le tableau des documents de travail seule
    ...  l'action d'ajout des documents de travail est accessible.

    # Ajout d'un dossier
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=BRAVAS
    ...  particulier_prenom=Denise
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Vérification avec un profil administrateur que l'action d'ajout des pièces est présente
    # dans le sous-onglet Pièces déposés
    Depuis la page d'accueil  admin  admin
    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Element Should Contain  css=a#action-soustab-blocnote-message-ajouter  AJOUTER AJOUTER UNE PIÈCE
    # Accède au sous onglet Documents et on vérifie que l'action d'ajout des documents de travail
    # est présente et pas celle d'ajout des documents numérisé (1 seul action d'ajout)
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di}
    Page Should Contain Element  css=a#action-soustab-document_numerise-corner-ajouter  None  INFO  1

    # Vérification avec un profil instructeur que l'action d'ajout des pièces n'est pas présente
    # dans le sous-onglet Pièces déposés
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet des pièces du dossier d'instruction  ${di}
    Page Should Not Contain  css=a#action-soustab-blocnote-message-ajouter
    # Accède au sous onglet Documents et on vérifie que l'action d'ajout des documents de travail
    # est présente et pas celle d'ajout des documents numérisé (1 seul action d'ajout)
    Accéder à l'onglet documents de l'onglet pièces par le dossier d'instruction  ${di}
    Page Should Contain Element  css=a#action-soustab-document_numerise-corner-ajouter  None  INFO  1

Vérification du bon fonctionnement des sous onglets en fonction des permissions
    [Documentation]  Permet de vérifier l'affichage des sous onglet en fonction des permissions de l'utilisateur

    # On test l'affichage lorsque le profil n'a pas accès à l'onglet
    Depuis la page d'accueil  admin  admin
    Supprimer le droit depuis le contexte du profil  document_numerise_telechargement  INSTRUCTEUR

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    # - Vérifier que le toggle ne contient pas l'onglet "Téléchargement"
    Element Should Not Be Visible  css=div[data-view="document_numerise_telechargement"]

    Depuis la page d'accueil  admin  admin
    # On remet le droit sur le profil INSTRUCTEUR
    Ajouter le droit depuis le menu  document_numerise_telechargement  INSTRUCTEUR

    # Vérification de la non présence du sous onglet Document d'instruction si les deux permissions son supprimées
    Supprimer le droit depuis le contexte du profil  document_instruction  INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  document_travail  INSTRUCTEUR

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    # - Vérifier que le toggle ne contient pas l'onglet "Téléchargement"
    Element Should Not Be Visible  css=div[data-view="document_instruction"]

    Depuis la page d'accueil  admin  admin
    # On remet le droit sur le profil INSTRUCTEUR
    Ajouter le droit depuis le menu  document_instruction  INSTRUCTEUR

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    # - Vérifier que le toggle ne contient pas l'onglet "Téléchargement"
    Element Should Be Visible  css=div[data-view="document_instruction"]
    Click Element  css=div.switcher__label[data-view="document_instruction"]

    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  Documents de travail
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Documents d'instruction

    Depuis la page d'accueil  admin  admin
    # On remet le droit sur le profil INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  document_instruction  INSTRUCTEUR
    Ajouter le droit depuis le menu  document_travail  INSTRUCTEUR

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    # - Vérifier que le toggle ne contient pas l'onglet "Téléchargement"
    Element Should Be Visible  css=div[data-view="document_instruction"]
    Click Element  css=div.switcher__label[data-view="document_instruction"]

    Page Should Not Contain  Documents d'instruction
    Page Should Contain  Documents de travail

    Depuis la page d'accueil  admin  admin
    # On remet le droit sur le profil INSTRUCTEUR
    Ajouter le droit depuis le menu  document_instruction  INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  document_numerise_dossier_final  INSTRUCTEUR

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents
    # - Vérifier que le toggle ne contient pas l'onglet "Téléchargement"
    Element Should Not Be Visible  css=div[data-view="document_numerise_dossier_final"]

    Depuis la page d'accueil  admin  admin
    # On veut seulement les pièces pétitionnaires
    Supprimer le droit depuis le contexte du profil  document_numerise_telechargement  INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  document_instruction  INSTRUCTEUR
    Supprimer le droit depuis le contexte du profil  document_travail  INSTRUCTEUR

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    On clique sur l'onglet  document_numerise  Pièces & Documents

    Element Should Not Be Visible  css=#switch-toutes_les_pieces-pieces_deposees

    # On rétablie les permissions comme avant
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu  document_instruction  INSTRUCTEUR
    Ajouter le droit depuis le menu  document_numerise_telechargement  INSTRUCTEUR
    Ajouter le droit depuis le menu  document_travail  INSTRUCTEUR
    Ajouter le droit depuis le menu  document_numerise_dossier_final  INSTRUCTEUR

Téléchargement de l'ensemble des documents
    [Documentation]  Test vérifiant le bon fonctionnement du sous onglet 'Téléchargement',
    ...  de son bon affichage, et du téléchargement de l'ensemble des documents, comprenant :
    ...  les documents de travail, les documents d'instruction, les pièces pétitionnaire,
    ...  les documents de consultation ainsi que les documents PeC.

    Depuis la page d'accueil  admin  admin

    # Ajout d'un DI
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Pantouflard
    ...  particulier_prenom=Bob
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'une consultation
    Ajouter une consultation depuis un dossier  ${di}  59.13 - Régie des Tranports de Marseille - DTP/CIP
    ${id_consultation} =  Get Element Attribute  css=#form-content #consultation  value

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie que le document généré est présent
    On clique sur l'onglet  document_numerise  Pièces & Documents
    # Vérifie qu'il n'y a pas de problème dans le contenu du sous onglet "Téléchargement"
    Click Element  css=div.switcher__label[data-view="document_numerise_telechargement"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  consultation_${id_consultation}

    Depuis la page d'accueil  consu  consu
    &{args_avis_consultation} =  Create Dictionary
    ...  avis_consultation=Favorable
    ...  motivation=Pas de réserves
    ...  fichier_upload=20130207F6.pdf

    Rendre l'avis sur la consultation du dossier  ${di}  ${args_avis_consultation}

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie que le retour d'avis est présent
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Click Element  css=div.switcher__label[data-view="document_numerise_telechargement"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  consultation_avis_${id_consultation}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  retour d'avis
    # Le document généré de la consultation ne doit pas être présent
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Not Contain  consultation_${id_consultation}

    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di}
    # Ajout d'un document numerise (PIÈCE)
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=31/03/2016
    ...  document_numerise_type=arrêté retour préfecture
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    # Ajout d'un document de travail
    &{document_travail_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.jpg
    ...  date_creation=31/03/2016
    ...  description_type=image
    Ajouter un document de travail depuis le dossier d'instruction  ${di}  ${document_travail_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    &{document_travail_values} =  Create Dictionary
    ...  uid_upload=20091106AUTPCP.pdf
    ...  date_creation=31/03/2016
    ...  description_type=pdf
    Ajouter un document de travail depuis le dossier d'instruction  ${di}  ${document_travail_values}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Ajout d'un rapport d'instruction
    Depuis le contexte du rapport d'instruction  ${di}
    Click On Submit Button In Subform
    Click On Back Button In Subform
    Depuis le contexte du rapport d'instruction  ${di}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La finalisation du document s'est effectuée avec succès.
    # On ajoute une version pour avoir un storage en plus du om_fichier_rapport_instruction
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  definalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La définalisation du document s'est effectuée avec succès.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  rapport_instruction  finalise
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  La finalisation du document s'est effectuée avec succès.
    Click On Back Button In Subform

    # Ajout d'un document d'instruction
    ${instr_id} =  Ajouter une instruction au DI et la finaliser  ${di}  Consultation service d'hygiène municipal
    Click On Back Button In Subform

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}

    # Vérification de l'accès à l'onglet "Pièces & Documents"
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Page Should Not Contain    Droits insuffisants. Vous n'avez pas suffisamment de droits pour acceder à cette page.

    # Vérifie que c'est bien l'onglet "Pièces pétitionnaire" qui à la classe css "onglet_active"
    Page Should Contain Element  css=div.switcher__label.onglet_active[data-view="document_numerise"]

    # Vérifie que le sous onglet "Téléchargement" est bien présent
    Element Should Be Visible  css=#switch-toutes_les_pieces-pieces_deposees  Téléchargement

    # Vérifie qu'il n'y a pas de problème dans le contenu du sous onglet "Téléchargement"
    Click Element  css=div.switcher__label[data-view="document_numerise_telechargement"]
    La page ne doit pas contenir d'erreur

    # Vérifie que lorsque l'on clique sur un des sous onglets, la class css de cette élément à bien "onglet_active" présent
    Page Should Contain Element  css=div.switcher__label.onglet_active[data-view="document_numerise_telechargement"]
    # Et que les autres élement n'ont pas de class "onglet_active"
    Page Should Not Contain Element  css=div.switcher__label.onglet_active[data-view="document_numerise"]
    Page Should Not Contain Element  css=div.switcher__label.onglet_active[data-view="document_instruction"]
    Page Should Not Contain Element  css=div.switcher__label.onglet_active[data-view="document_numerise_dossier_final"]

    # Vérifie les lignes d'entête
    Element Should Contain  css=thead .col-0  ${EMPTY}
    Element Should Contain  css=thead .col-1  date
    Element Should Contain  css=thead .col-2  type
    Element Should Contain  css=thead .col-3  nom du fichier
    Element Should Contain  css=thead .col-4  catégorie

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction  ${di}
    # - Vérifier que le toggle contient bien l'onglet "Téléchargement"
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Element Should Be Visible  css=div[data-view="document_numerise_telechargement"]
    Click Element  css=div[data-view="document_numerise_telechargement"]

    # On vérifie que les 3 sections sont présente dans le tableau de téléchargement
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Pièces pétitionnaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Documents d'instruction
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Documents de travail
    # On vérifie que les fichiers ajoutés sont bien présents
    # pièce pétitionnaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  20160331ART.pdf
    # Documents de travail
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  20160331DOCTRAV.pdf
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  20160331DOCTRAV.jpg
    # Rapport d'instruction
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  rapport_instruction_1.pdf
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  rapport_instruction_2.pdf

    # La présence des documents PeC sera vérifiée dans le test 300 lors des vérification des consultation avec PeC

    # On test le bon fonctionnement du téléchargement d'un seul document
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  Recepisse de depot
    Open PDF  ${OM_PDF_TITLE}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  RECEPISSE DE DEPOT
    Page Should Contain  Pantouflard Bob
    Close PDF

    # - Vérifier le bon fonctionnement de la selection/deselection du sous onglet "Téléchargement"
    # Récupération des checkbox
    @{locators_checkboxes_all} =  Get WebElements  css=.checkbox-telechargement
    # Vérifie que toutes les cases à cocher sont sélectionnées
    Click Button  id=checkbox_select_all_none
    Sleep  1
    :FOR  ${locator}  IN  @{locators_checkboxes_all}
    \  Checkbox Should Be Selected  ${locator}

    # Vérifie que toutes les cases à cocher sont désélectionnées
    Click Button  id=checkbox_select_all_none
    :FOR  ${locator}  IN  @{locators_checkboxes_all}
    \  Checkbox Should Not Be Selected  ${locator}

    Click Button  id=checkbox_select_all_none
    Click Element  name=archive_telechargement

    # Télécharger toutes les pièces et vérifier l'archive
    ${path_archive}  ${archive_name} =  Télécharger l'archive du sous onglet téléchargement
    # Composition du nom correct de l'archive zip
    ${di_libelle_spaceless} =  Sans espace  ${di}
    ${date_ddmmyyyy} =  Date du jour EN
    ${date_jour_sans_tirets} =  STR_REPLACE  -  ${EMPTY}  ${date_ddmmyyyy}
    ${correct_archive_name_di} =  Set Variable  ${di_libelle_spaceless}_telechargement_${date_jour_sans_tirets}.zip
    # Vérification du nom de l'archive, et de son contenu
    Should Be Equal  ${correct_archive_name_di}  ${archive_name}

    @{all_files} =  Get WebElements  css=tbody tr.tab-data td.col-3 a
    :FOR  ${file}  IN  @{all_files}
    \  ${file_name} =  Get Text  ${file}
    \  ${match_instr} =  Run Keyword And Return Status  Should Match Regexp  ${file_name}  ^instruction_\\d+
    \  ${match_cons} =  Run Keyword And Return Status  Should Match Regexp  ${file_name}  ^consultation_avis_\\d+
    \  ${file_name} =  Run Keyword If  ${match_instr}==True or ${match_cons}==True  Set Variable  ${file_name}.pdf  ELSE  Set Variable  ${file_name}
    \  Archive Should Contain File  ${path_archive}  ${file_name}

Décomposition du jeu de données
    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification_piece_numerisee
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
