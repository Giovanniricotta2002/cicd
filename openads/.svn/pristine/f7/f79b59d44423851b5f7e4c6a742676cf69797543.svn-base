*** Settings ***
Documentation  Test sur les sous dossiers.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Test Cases ***
Paramétrage d'un sous dossier
    [Documentation]  Paramètre un type de dossier pour un sous-dossier et un type de
    ...  demande lié à ce type de dossier.
    ...  Vérifie qu'une fois le sous dossier paramétré, il est accessible depuis l'onglet
    ...  sous-dossier des dossiers compatibles.
    ...  Test également les vérifications faites lors du paramétrage des sous-dossiers.
    ...  Paramétrage du type de dossier :
    ...     - si la case "sous_dossier" est cochée alors la case "suffixe" doit obligatoirement
    ...       l'être aussi
    ...     - si la case "sous_dossier" est cochée alors les éléments de "Mises à jour des
    ...       données du dossier d'autorisation" ne doivent pas être coché
    ...  Paramétrage du type de demande :
    ...     - si la demande concerne un "sous_dossier" alors la "nature de la
    ...       demande" doit obligatoirement être "dossier existant"

    Depuis la page d'accueil  admin  admin

    # Test les vérifications faite lors de l'ajout d'un type de sous dossier.
    Depuis le listing  dossier_instruction_type
    Click On Add Button

    @{di_compatibles} =    Create List
    ...    PCI - P - Permis de construire pour une maison individuelle et / ou ses annexes - Initial
    # Cas 1 : sous-dossier sans suffixe coché
    &{args_type_di} =  Create Dictionary
    ...  code=SDT
    ...  libelle=Sous Dossier Test
    ...  sous_dossier=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    Saisir type de dossier d'instruction  ${args_type_di}
    # Valide le formulaire et vérifie le message d'erreur
    Click Element Until Message
    ...  css=#formulaire div.formControls input[type="submit"]
    ...  L'affichage du suffixe du numéro de dossier est obligatoire pour les sous-dossiers.
    ...  css=div.message.ui-state-error

    # Cas 2 : sous-dossier avec mises à jour des données du dossier d'autorisation
    &{args_type_di} =  Create Dictionary
    ...  code=SDT
    ...  libelle=Sous Dossier Test
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    ...  maj_da_localisation=true
    Saisir type de dossier d'instruction  ${args_type_di}
    # Valide le formulaire et vérifie le message d'erreur
    Click Element Until Message
    ...  css=#formulaire div.formControls input[type="submit"]
    ...  L'évolution d'un sous-dossier ne dois pas entrainer de mise à jour du dossier d'autorisation.
    ...  css=div.message.ui-state-error

    # Ajout du nouveau type de sous dossier
    &{args_type_di} =  Create Dictionary
    ...  code=SDT
    ...  libelle=Sous Dossier ('Test')
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    ...  maj_da_localisation=false
    Saisir type de dossier d'instruction  ${args_type_di}
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    ${idSsDossierTest} =  Get Text  css=div.form-content span#dossier_instruction_type
    Set Suite Variable  ${idSsDossierTest}

    # Ajout d'une famille et de natures de travaux pour vérifier la conservation de ces
    # natures lors de la création du sous-dossier
    &{famille_travaux} =  Create Dictionary
    ...  libelle=Restauration SSDS
    ...  code=RES
    ${famille_travaux.id} =  Ajouter la famille de travaux  ${famille_travaux}
    Set Suite Variable  ${famille_travaux}

    @{dit_nature_travaux} =  Create List
    ...  PCI - Initial
    &{nature_travaux_ssds1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement public ssds
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux.libelle}
    ${nature_travaux_ssds1.id} =  Ajouter la nature de travaux  ${nature_travaux_ssds1}  ${dit_nature_travaux}
    Set Suite Variable  ${nature_travaux_ssds1}

    &{nature_travaux2_ssds1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé ssds
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux.libelle}
    ${nature_travaux2_ssds1.id} =  Ajouter la nature de travaux  ${nature_travaux2_ssds1}  ${dit_nature_travaux}
    Set Suite Variable  ${nature_travaux2_ssds1}

    @{nature_travaux_ssds} =  Create List
    ...  ${nature_travaux_ssds1.famille_travaux} / ${nature_travaux_ssds1.libelle}
    ...  ${nature_travaux2_ssds1.famille_travaux} / ${nature_travaux2_ssds1.libelle}

    # Test les vérifications faite lors de l'ajout d'un type de demande lié au sous dossier.
    Depuis le tableau des types de demandes
    Click On Add Button

    # Cas 1 : type de demande lié à un sous-dossier ayant pour nature "Nouveau dossier"
    @{etats_autorises} =    Create List
    ...    delai de notification envoye
    &{args_demande_type} =  Create Dictionary
    ...    code=TESTSD
    ...    libelle=Test demande sous dossier
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...    demande_nature=Nouveau dossier
    ...    etats_autorises=@{etats_autorises}
    ...    dossier_instruction_type=${args_type_di.libelle}
    ...    evenement=Notification de delai
    Saisir le type de demande  ${args_demande_type}
    # Valide le formulaire et vérifie le message d'erreur
    Click Element Until Message
    ...  css=#formulaire div.formControls input[type="submit"]
    ...  Les demandes associées à des sous-dossiers sont obligatoirement des demandes sur dossier existant.
    ...  css=div.message.ui-state-error

    # Création du type de demande associée au sous dossier
    &{args_demande_type} =  Create Dictionary
    ...    code=TESTSD
    ...    libelle=Test demande sous dossier
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...    demande_nature=Dossier existant
    ...    etats_autorises=@{etats_autorises}
    ...    dossier_instruction_type=${args_type_di.libelle}
    ...    evenement=Notification de delai
    Saisir le type de demande  ${args_demande_type}
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur

    # Vérification de l'affichage des listings de sous dossier
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_civilite=Madame
    ...  particulier_nom=Test ajout
    ...  particulier_prenom=Sous Dossier
    ...  om_collectivite=MARSEILLE
    ...  particulier_date_naissance=20/01/1976
    ...  particulier_commune_naissance=MULHOUSE
    ...  particulier_departement_naissance=HAUT-RHIN
    ...  particulier_pays_naissance=FRANCE
    ...  numero=89
    ...  voie=rue des Coudriers
    ...  complement=cplmt
    ...  lieu_dit=Lieu_dit
    ...  localite=MULHOUSE
    ...  code_postal=68100
    ...  bp=1
    ...  cedex=2
    ...  pays=FRANCE
    ...  division_territoriale=div
    ...  telephone_fixe=0447129800
    ...  telephone_mobile=0336018799
    ...  indicatif=+33
    ...  fax=fax
    ...  courriel=cdaubigne@test.test
    ...  notification=t
    @{ref_cad} =  Create List  000  0A  0001
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_voie_numero=24
    ...  terrain_adresse_voie=rue des marmottons
    ...  terrain_adresse_lieu_dit=Le pré des marmottons
    ...  terrain_adresse_code_postal=13333
    ...  terrain_adresse_localite=Marmotte Vallée
    ...  terrain_references_cadastrales=${ref_cad}
    ${dossier_parent} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Set Suite Variable  ${dossier_parent}
    Depuis le contexte du dossier d'instruction  ${dossier_parent}
    Click On Portlet Action  dossier_instruction  modifier
    ${value_di} =  Create Dictionary
    ...  date_demande=${date_ddmmyyyy}
    Modifier le dossier d'instruction  ${dossier_parent}  ${value_di}  nature_travaux=@{nature_travaux_ssds}

    # L'onglet des sous-dossier ne dois pas être visible tant que le mode
    # service consulté n'est pas actif
    Depuis le contexte du dossier d'instruction  ${dossier_parent}
    Page Should Not Contain  sous-dossier

    # activation de mode service consulté, l'onglet dois maintenant être
    # visible
    &{om_param} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Element Should Contain  css=#sousform-sous_dossier  sous dossier ('test')

Création de sous dossier
    [Documentation]  Utilise le type de sous-dossier et le dossier paramétré précedemment.
    ...  Ce test vérifie :
    ...   - l'organisation et l'affichage des listings des sous-dossiers,
    ...   - l'absence de tri sur le header des listings
    ...   - l'ajout et l'affichage d'un sous-dossier,
    ...   - la numérotation des sous-dossiers et l'affichage du fil d'ariane
    ...   - l'affectation automatique pour les sous-dossiers et les informations copiées du parent
    ...   - la supression des sous-dossiers

    Depuis la page d'accueil  admin  admin
    # Activation de l'option de suppression des dossiers pour tester celle des sous-dossier
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # Paramétrage d'un deuxième type de sous-dossier
    ${codeSsDossier} =  Set Variable  SDTA
    @{di_compatibles} =    Create List
    ...    PCI - P - Permis de construire pour une maison individuelle et / ou ses annexes - Initial
    &{args_type_di} =  Create Dictionary
    ...  code=${codeSsDossier}
    ...  libelle=Sous Dossier Test Ajout
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    ...  maj_da_localisation=false
    ${idSsDossierTestAjout} =  Ajouter type de dossier d'instruction  ${args_type_di}

    &{args_demande_type} =  Create Dictionary
    ...    code=TEST${codeSsDossier}
    ...    libelle=Test ajout sous dossier
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...    demande_nature=Dossier existant
    ...    dossier_instruction_type=Sous Dossier Test Ajout
    ...    evenement=Notification de delai
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}

    # Ajout de la compatibilité avec le sous dossier pour une nature de travaux sur les deux
    @{dit_nature_travaux} =  Create List
    ...  PCI - Initial
    ...  Sous Dossier Test Ajout
    Modifier la nature de travaux  ${nature_travaux_ssds1.id}  ${nature_travaux_ssds1}  ${dit_nature_travaux}
    @{not_nature_travaux_ssds} =  Create List
    ...  ${nature_travaux2_ssds1.famille_travaux} / ${nature_travaux2_ssds1.libelle}
    @{nature_travaux_ssds} =  Create List
    ...  ${nature_travaux_ssds1.famille_travaux} / ${nature_travaux_ssds1.libelle}

    # Accès au listing des sous-dossier et vérification de l'affichage
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Element Should Contain  css=#sousform-sous_dossier_${idSsDossierTest}  sous dossier ('test')
    Element Should Contain  css=#sousform-sous_dossier_${idSsDossierTestAjout}  sous dossier test ajout

    # Création, affichage d'un sous-dossier, vérification de la numérotation du dossier et du fil d'Ariane
    Ajouter le sous-dossier au dossier  ${idSsDossierTestAjout}
    # Vérification du numéro de dossier
    Wait Until Element Contains  css=#title > h2  Instruction > Sous Dossier Test Ajout > ${dossier_parent} > ${codeSsDossier}01
    Element Should Contain  css=#dossier_libelle  ${dossier_parent} ${codeSsDossier}01

    # On vérifie que les natures de travaux sont présentes ou non
    Element Should Contain  css=div.field-type-select_multiple_static div.form-content  ${nature_travaux_ssds1.famille_travaux} / ${nature_travaux_ssds1.libelle}
    Element Should Not Contain  css=div.field-type-select_multiple_static div.form-content  ${nature_travaux2_ssds1.famille_travaux} / ${nature_travaux2_ssds1.libelle}
    Click On Portlet Action  sous_dossier  modifier
    # On vérifie que le chosen nature travaux fonctionne bien
    Unselect From Multiple Chosen List  nature_travaux  ${nature_travaux_ssds}
    Select Multiple From Chosen List Should Contain List  nature_travaux  ${nature_travaux_ssds}
    Select Multiple From Chosen List Should Not Contain List  nature_travaux  ${not_nature_travaux_ssds}
    Select From Multiple Chosen List  nature_travaux  ${nature_travaux_ssds}
    Click On Submit Button

    # Le sous onglet sous-dossier ne dois pas être visible
    Page Should Not Contain Element  css=li.ui-state-default.ui-corner-top a#sous_dossier

    # Vérifie que les infos copiées du dossier d'instruction sont présente :
    #  - infos de localisation
    #  - infos des demandeurs
    Open Fieldset  sous_dossier  localisation
    Element Should Contain  css=#terrain_adresse_voie_numero  24
    Element Should Contain  css=#terrain_adresse_voie  rue des marmottons
    Element Should Contain  css=#terrain_adresse_lieu_dit  Le pré des marmottons
    Element Should Contain  css=#terrain_adresse_code_postal  13333
    Element Should Contain  css=#terrain_adresse_localite  Marmotte Vallée
    Element Should Contain  css=.reference-cadastrale-0  0000A0001

    Open Fieldset  dossier_instruction  demandeur
    Element Should Contain
    ...  css=#fieldset-form-dossier_instruction-demandeur .synthese_demandeur
    ...  Madame Test ajout Sous Dossier\n89 rue des Coudriers cplmt\nLieu_dit\n68100 MULHOUSE 1 2\ndiv FRANCE\n0447129800 0336018799\ncdaubigne@test.test (Accepte les couriels)\nNé le 20/01/1976 à MULHOUSE HAUT-RHIN FRANCE

    # Vérifie l'affectation du sous-dossier
    Element Should Contain  css=#instructeur  Louis Laurent 
    Element Should Contain  css=#division  subdivision H
    
    # Ajout d'un second sous-dossier et vérification que le premier ne peut pas
    # être supprimer et que le deuxième peut l'être.
    On clique sur l'onglet  main  DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=a[id^=form-action-sous_dossier-back]
    Click On Back Button
    Ajouter le sous-dossier au dossier  ${idSsDossierTestAjout}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=a[id^=form-action-sous_dossier-back]
    Portlet Action Should Be In Form  sous_dossier  supprimer
    Click On Back Button
    # retour sur le premier sous-dossier et vérification de l'affichage de l'action
    ${libelle_sans_espace} =  Sans espace  ${dossier_parent}
    Click On Link  css=#sousform-sous_dossier_${idSsDossierTestAjout} .firstcol a[href$="idx=${libelle_sans_espace}${codeSsDossier}01"]
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=a[id^=form-action-sous_dossier-back]
    Portlet Action Should Not Be In Form  sous_dossier  supprimer
    Click On Back Button
    # Suppression du sous dossier.
    Click On Link  css=#sousform-sous_dossier_${idSsDossierTestAjout} .firstcol a[href$="idx=${libelle_sans_espace}${codeSsDossier}02"]
    Click On Form Portlet Action  sous_dossier  supprimer
    Click On Submit Button
    # Vérifie qu'on retombe bien sur le dossier d'instruction et que le sous-dossier n'existe plus
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  TEST AJOUT SOUS DOSSIER
    Page Should Not Contain Element  css=#sousform-sous_dossier_${idSsDossierTestAjout} .firstcol a[href$="idx=${libelle_sans_espace}${codeSsDossier}02"]
    # Vérifie que le tri des colonnes n'est pas possible
    Page Should Not Contain Element  css=#content a span[class^="ui-icon ui-icon-triangle"]

    # Réinitialisation des paramètres
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_suppression_dossier_instruction
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

Ajout de consultation sur les sous-dossier
    [Documentation]  Depuis le contexte d'un sous-dossier, dans l'onglet Consultation
    ...  ajoute une consultation. Vérifie que cette consultation est visible dans le
    ...  listing des consultations du sous-dossier.

    # Création d'un sous-dossier
    Depuis la page d'accueil  admin  admin
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Ajouter le sous-dossier au dossier  ${idSsDossierTest}

    # Ajout de la consultation
    On clique sur l'onglet  consultation  Consultation(s)
    Ajouter une consultation depuis le listing des consultations   59.72 - DDTM 13 - Service Urbanisme
    Click On Back Button In SubForm
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=#sousform-consultation  59.72 - DDTM 13 - Service Urbanisme

Gestion des erreurs de paramétrage des sous dossiers
    [Documentation]  Test 4 cas :
    ...  1) Aucun type de sous-dossier n'est compatible avec le type de dossier consulté.
    ...  2) Le type de sous-dossier n'a pas de type de demande associée
    ...  3) Le sous-dossier à plusieurs type de demande associés
    ...  4) Le dossier a des sous-dossier lié mais dont le type de sous-dossier n'est plus
    ...     lié à ce type de dossier. (sous-dossier historique)
    ...     Vérifie aussi que l'accès au sous-dossier historique fonctionne bien ainsi que
    ...     le retour vers le dossier parent.

    # Cas 1 : On créé un dossier de type CU. En accédant à l'onglet sous-dossier
    # un message doit être affiché indiquant qu'aucun type de sous dossier ne peut
    # être ajouté
    Depuis la page d'accueil  admin  admin
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Test problème paramétrage
    ...  particulier_prenom=Sous Dossier
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${dossier_parent} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Element Should Contain  css=.message.ui-state-info  Aucun sous-dossier n'est associé à ce type de dossier.


    # Cas 2 : On paramètre un type de sous dossier pour les CU mais aucun type de
    # demande n'est associé à ce type de dossier.
    # En accédant au dossier précedemment créé le listing des sous-dossiers doit
    # être visible mais le bouton d'ajout n'est pas présent. Un message doit être
    # affiché indiquant que le paramétrage de ce type de dossier est erroné.
    Depuis la page d'accueil  admin  admin
    @{di_compatibles} =    Create List
    ...    CU - P - Certificat d'urbanisme - Initial
    &{args_type_di} =  Create Dictionary
    ...  code=SDTP
    ...  libelle=Sous Dossier Test Param
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    ...  maj_da_localisation=false
    Ajouter type de dossier d'instruction  ${args_type_di}
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Element Should Contain  css=.message.ui-state-info  Le paramétrage doit être corrigé pour que ce(s) sous-dossier(s) puisse(nt) être ajouté(s).
    Tab sous_dossier Should Not Contain Add Button


    # Cas 3 : On paramètre deux type de demande pour le sous dossier précedemment créé.
    # En accédant au dossier précedemment créé le listing des sous-dossiers doit
    # être visible mais le bouton d'ajout n'est pas présent. Un message doit être
    # affiché indiquant que le paramétrage de ce type de dossier est erroné.
    Depuis la page d'accueil  admin  admin
    @{etats_autorises} =    Create List
    ...    delai de notification envoye
    &{args_demande_type} =  Create Dictionary
    ...    code=TESTSDP1
    ...    libelle=Test parametrage sous dossier 1
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=CU (Certificat d'urbanisme)
    ...    demande_nature=Dossier existant
    ...    etats_autorises=@{etats_autorises}
    ...    dossier_instruction_type=Sous Dossier Test Param
    ...    evenement=Notification de delai
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}

    &{args_demande_type} =  Create Dictionary
    ...    code=TESTSDP2
    ...    libelle=Test parametrage sous dossier 2
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=CU (Certificat d'urbanisme)
    ...    demande_nature=Dossier existant
    ...    etats_autorises=@{etats_autorises}
    ...    dossier_instruction_type=Sous Dossier Test Param
    ...    evenement=Notification de delai
    ${demande_type_id} =  Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}
    Ajouter type de dossier d'instruction  ${args_type_di}
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Element Should Contain  css=.message.ui-state-info  Le paramétrage doit être corrigé pour que ce(s) sous-dossier(s) puisse(nt) être ajouté(s).
    Tab sous_dossier Should Not Contain Add Button


    # Cas 4 : On ajoute un sous-dossier au dossier et on supprime le lien entre ce type
    # de sous dossier et ce type de dossier. Le sous-dossier est accessible dans un listing
    # particulier et le bouton d'ajout n'est pas accessible pour ce type de sous-dossier.

    # /!\   Il y a un bug sur la supression de demande qui empêche de supprimer les demandes.
    # Pour contourner le problème, un des types de demande des DI de type Sous Dossier Test Param
    # est associé à un nouveau type de sous-dossier. Ainsi, le paramétrage des ce type de SD
    # est corrigé et ils peuvent être ajouté à des dossiers.
    &{args_type_di} =  Create Dictionary
    ...  code=BSDH
    ...  libelle=bug_sous-dossier_historique
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles}
    ...  maj_da_localisation=false
    ${type_DI_id} =  Ajouter type de dossier d'instruction  ${args_type_di}
    &{values_modif} =  Create Dictionary
    ...    dossier_instruction_type=${args_type_di.libelle}
    Modifier le type de demande  ${demande_type_id}  ${args_demande_type.code}  ${values_modif}

    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Ajouter le sous-dossier au dossier  ${type_DI_id}
    # Vérifie que le sous-dossier est bien visible dans la liste des sous-dossier du DI
    ${dossier_parent_se} =  Sans espace  ${dossier_parent}
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    Wait Until Page Contains  ${dossier_parent_se}${args_type_di.code}01

    # Modification du paramétrage et vérification de l'affichage du sous-dossier en tant que
    # sous-dossier historique
    # TODO : refactorer ce bout de code en le remplaçant par le KW "Modifier type de dossier d'instruction".
    #        + faire évoluer ce KW pour vider le champs lien_sous_dossier_type_di avant de le remplir
    # => En raison d'un bug l'évolution du KW n'est pas possible pour l'instant car cela entraine des fails
    #    dans ce test.
    @{di_compatibles} =    Create List
    ...    CU - T - Certificat d'urbanisme - Transfert
    Depuis le formulaire de modification d'un type de dossier d'instruction  ${args_type_di.libelle}  ${args_type_di.code}
    Unselect All From List    lien_sous_dossier_type_di
    Select Multiple By Label  lien_sous_dossier_type_di  ${di_compatibles}
    Click On Submit Button


    # Vérification de l'affichage des SD historique
    Depuis l'onglet des sous_dossiers du dossier d'instruction  ${dossier_parent}
    La Page Ne Doit Pas Contenir D'erreur
    Page should contain   sous dossier historique
    Tab sous_dossier_sous_dossier_historique Should Not Contain Add Button
    # Vérifie le fonctionnement de la redirection des sous-dossiers historique
    Click Link  css=#sousform-sous_dossier_sous_dossier_historique td.firstcol a[href$="${dossier_parent_se}${args_type_di.code}01"]
    Wait Until Page Contains  ${dossier_parent} ${args_type_di.code}01
    La Page Ne Doit Pas Contenir D'erreur
    Click On Back Button
    # TNR : le message d'information concernant le paramétrage des sous-dossier doit être affiché une
    #       seule fois
    Wait Until Page Contains Element  css=#sousform-sous_dossier_sous_dossier_historique
    Page Should Contain Element  css=.message.ui-state-info  None  INFO  1

    # Réinitialisation du paramétrage
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_mode_service_consulte
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

Affichage des sous-dossiers par contexte
    [Documentation]  Teste l'affichage des actions, des onglets et de la redirection
    ...    vers le contexte du dossier parent dans 3 cas :
    ...    - accès depuis un widget : on utilise le widget de recherche paramétrabme.
    ...      le sous-dossier (SD) ne dois pas apparaître dans ce widget. Le retour du SD
    ...      doit ramener sur le dossier parent puis sur le listing du widget.
    ...    - dossier d'instruction :  
    ...    - dossier contentieux

    Depuis la page d'accueil  admin  admin
    # activation de mode service consulté, pour afficher l'onglet des sous-dossiers
    &{om_param} =  Create Dictionary
    ...  libelle=option_mode_service_consulte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}
    # Création d'un événement spécifique au sous-dossier
    @{etat_source} =  Create List  delai de notification envoye
    @{type_di} =  Create List  PCI - P - Initial
    &{args_evenement1} =  Create Dictionary
    ...  libelle=Test des sous-dossiers
    ...  etats_depuis_lequel_l_evenement_est_disponible=${etat_source}
    ...  dossier_instruction_type=${type_di}
    ${evenement_id} =  Ajouter l'événement depuis le menu  ${args_evenement1}

    # Ajout d'un tiers consulté pour avoir toutes les actions disponible sur le listing
    # des consultations
    &{args_tiers} =  Create Dictionary
    ...  categorie_tiers_consulte=Catégorie Marseille
    ...  abrege=TNR_ACT
    ...  libelle=TNR ajout consultation tiers
    ${id_tiers} =  Ajouter le tiers consulte depuis le listing  ${args_tiers}
    # Paramétrage d'un sous dossiers pour les infractions
    ${codeSDCtx} =  Set Variable  SDTCTX
    @{di_compatibles_ctx} =    Create List
    ...    IN - P - Infraction - Initiale
    &{args_type_di} =  Create Dictionary
    ...  code=${codeSDCtx}
    ...  libelle=Sous Dossier Test Ctx
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles_ctx}
    ...  maj_da_localisation=false
    ${idSDTestCtx} =  Ajouter type de dossier d'instruction  ${args_type_di}

    &{args_demande_type} =  Create Dictionary
    ...    code=TEST${codeSDCtx}
    ...    libelle=Test sous dossier ctx
    ...    groupe=Contentieux
    ...    dossier_autorisation_type_detaille=IN (Infraction)
    ...    demande_nature=Dossier existant
    ...    dossier_instruction_type=Sous Dossier Test Ctx
    ...    evenement=Test des sous-dossiers
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}


    # Affichage des sous-dossiers dans le contexte d'une infraction


    # Mise en place du contexte nécessaire pour accéder aux dossier contentieux
    # (infraction)
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Roch
    ...  particulier_prenom=Thibault
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${dossier_parent_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    Depuis la page d'accueil  assist  assist
    Depuis le contexte du dossier infraction par recherche  ${dossier_parent_inf}

    # Vérifie que les sous-onglets accessible sont bien les mêmes entre le dossier
    # et le sous-dossier
    # Récupération de la liste des onglets du DI moins l'onglet sous-dossier
    ${onglets} =  Get WebElements  css=ul.ui-tabs-nav li a
    ${onglet_ids}=    Create List
    :FOR  ${onglet}  IN  @{onglets}
    \    ${value}=  Get Element Attribute  ${onglet}  id
    \    Append To List  ${onglet_ids}  ${value}
    Remove Values From List  ${onglet_ids}  sous_dossier

    Ajouter le sous-dossier au dossier  ${idSDTestCtx}
    # Récupération de la liste des onglets du sous DI
    ${onglets_sd} =  Get WebElements  css=ul.ui-tabs-nav li a
    ${onglet_sd_ids}=    Create List
    :FOR  ${onglet_sd}  IN  @{onglets_sd}
    \    ${value}=  Get Element Attribute  ${onglet_sd}  id
    \    Append To List  ${onglet_sd_ids}  ${value}
    Lists Should Be Equal  ${onglet_ids}  ${onglet_sd_ids}

    # Pour chaque sous-onglet vérifie qu'il n'y a pas d'erreur et que les actions
    # et les éléments voulus sont tous présent
    # Onglet contraintes
    On clique sur l'onglet  dossier_contrainte_contexte_ctx  Contrainte(s)
    Page Should Contain Element  css=a#action-soustab-dossier_contrainte-corner-ajouter
    Click On Link  css=a#action-soustab-dossier_contrainte-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain   Contraintes liées au dossier
    Click On Back Button In SubForm
    # Onglet instruction
    On clique sur l'onglet  instruction_contexte_ctx_inf  Instruction
    Page Should Contain Element  css=a#action-soustab-instruction_contexte_ctx_inf-corner-ajouter
    Click On Link  css=a#action-soustab-instruction_contexte_ctx_inf-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain  événement
    Click On Back Button In SubForm
    # Onglet message
    On clique sur l'onglet  dossier_message_contexte_ctx  Message(s)
    Page Should Not Contain Element  css=a#action-soustab-dossier_message_contexte_ctx-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain     Aucun enregistrement.
    # onglet bloc-note
    On clique sur l'onglet  blocnote_contexte_ctx  Bloc-note
    Page Should Contain Element  css=a#action-soustab-blocnote_contexte_ctx-corner-ajouter
    Click On Link  css=a#action-soustab-blocnote_contexte_ctx-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain    catégorie
    Click On Back Button In SubForm
    # onglet Pièces & Documents : sous onglets pièce pétitionnaire
    On clique sur l'onglet  document_numerise_contexte_ctx  Pièces & Documents
    Page Should Contain Element  css=a#action-soustab-blocnote-message-ajouter
    Click On Link  css=a#action-soustab-blocnote-message-ajouter
    Page Should Contain  Nature de pièce 
    La page ne doit pas contenir d'erreur
    Click On Back Button In SubForm
    # onglet Pièces & Documents : sous onglets Docs. instruction
    Click Element Until New Element  css=div[data-view="document_instruction"]  css=div.switcher__label.onglet_active[data-view="document_instruction"]
    Page Should Contain Element  css=a#zip_download_link
    Click On Link  css=a#zip_download_link
    Page Should Contain    Téléchargement de l'archive
    Click On Link  css=a.ui-dialog-titlebar-close
    # onglet Pièces & Documents : sous onglets Dossier final
    Click Element Until New Element  css=div[data-view="document_numerise_dossier_final"]  css=div.switcher__label.onglet_active[data-view="document_numerise_dossier_final"]
    Page Should Contain Element  css=input[name="constituer_dossier_final"]
    # onglet Dossiers Liés
    On clique sur l'onglet  lien_dossier_dossier_contexte_ctx_inf  Dossiers Liés
    Page Should Contain Element  css=a#action-soustab-dossier_lies-corner-ajouter
    Click On Link  css=a#action-soustab-dossier_lies-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain    dossier cible
    Click On Back Button In SubForm
    Page Should Contain Element  css=div#sousform-dossier_lies
    Page Should Contain Element  css=div#sousform-dossier_lies_retour
    Page Should Contain Element  css=div#sousform-dossier_lies_geographiquement

    # Vérification de la redirection dans le contexte voulu
    ${libelle_sans_espace} =  Sans espace  ${dossier_parent_inf}
    On clique sur l'onglet  main  DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=a[id^=form-action-sous_dossier-back]
    # Vérification de la redirection vers le dossier parent dans l'onglet sous-dossier
    Click On Back Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  sous dossier test ctx
    # Vérification de la redirection vers le listing des infractions avec les paramètres voulus de
    # recherche avancée
    On clique sur l'onglet  main  DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=a[id^=form-action-dossier_contentieux_toutes_infractions-back]
    Click On Back Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=input#dossier
    ${val_recherche} =  Get Value  css=input#dossier
    Should Be equal  ${libelle_sans_espace}  ${val_recherche}


    # Affichage des sous-dossiers dans le contexte d'un DI


    Depuis la page d'accueil  admin  admin
    # Paramétrage du sous-dossier
    ${codeSDAds} =  Set Variable  SDTADS
    @{di_compatibles_ads} =    Create List
    ...    PCI - P - Permis de construire pour une maison individuelle et / ou ses annexes - Initial
    &{args_type_di} =  Create Dictionary
    ...  code=${codeSDAds}
    ...  libelle=Sous Dossier Test ADS
    ...  sous_dossier=true
    ...  suffixe=true
    ...  lien_sous_dossier_type_di=@{di_compatibles_ads}
    ...  maj_da_localisation=false
    ${idSDTestAds} =  Ajouter type de dossier d'instruction  ${args_type_di}

    &{args_demande_type} =  Create Dictionary
    ...    code=TEST${codeSDAds}
    ...    libelle=Test sous dossier ADS
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...    demande_nature=Dossier existant
    ...    dossier_instruction_type=Sous Dossier Test ADS
    ...    evenement=Test des sous-dossiers
    Ajouter un nouveau type de demande depuis le menu  ${args_demande_type}

    # Mise en place du contexte nécessaire pour accéder aux dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Test paramétrage
    ...  particulier_prenom=Sous Dossier
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${dossier_parent_di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instr  instr
    Depuis le contexte du dossier d'instruction par recherche  ${dossier_parent_di}
    La page ne doit pas contenir d'erreur

    # Vérifie que les sous-onglets accessible sont bien les mêmes entre le dossier
    # et le sous-dossier
    # Récupération de la liste des onglets du DI moins l'onglet sous-dossier
    ${onglets} =  Get WebElements  css=ul.ui-tabs-nav li a
    ${onglet_ids}=    Create List
    :FOR  ${onglet}  IN  @{onglets}
    \    ${value}=  Get Element Attribute  ${onglet}  id
    \    Append To List  ${onglet_ids}  ${value}
    Log List  ${onglet_ids}
    Remove Values From List  ${onglet_ids}  sous_dossier
    Log List  ${onglet_ids}

    Ajouter le sous-dossier au dossier  ${idSDTestAds}
    # Récupération de la liste des onglets du sous DI
    ${onglets_sd} =  Get WebElements  css=ul.ui-tabs-nav li a
    ${onglet_sd_ids}=    Create List
    :FOR  ${onglet_sd}  IN  @{onglets_sd}
    \    ${value}=  Get Element Attribute  ${onglet_sd}  id
    \    Append To List  ${onglet_sd_ids}  ${value}
    Log List  ${onglet_sd_ids}
    Lists Should Be Equal  ${onglet_ids}  ${onglet_sd_ids}

    # Pour chaque sous-onglet vérifie qu'il n'y a pas d'erreur et que les actions
    # et les éléments voulus sont tous présent
    # Onglet Contraintes
    On clique sur l'onglet  dossier_contrainte  Contrainte(s)
    Page Should Contain Element  css=a#action-soustab-dossier_contrainte-corner-ajouter
    Click On Link  css=a#action-soustab-dossier_contrainte-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain   Contraintes liées au dossier
    Click On Back Button In SubForm
    # Onglet Instruction
    On clique sur l'onglet  instruction  Instruction
    Page Should Contain Element  css=a#action-soustab-instruction-corner-ajouter
    Click On Link  css=a#action-soustab-instruction-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain  événement
    Click On Back Button In SubForm
    # Onglet Consultation
    On clique sur l'onglet  consultation  Consultation(s)
    Page Should Contain Element  css=a#action-soustab-consultation-corner-ajouter
    Page Should Contain Element  css=a#action-soustab-consultation-corner-ajouter_multiple
    Page Should Contain Element  css=a#action-soustab-consultation-corner-ajouter_consultation_tiers
    Click On Link  css=a#action-soustab-consultation-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain   Service
    Click On Back Button In SubForm
    Click On Link  css=a#action-soustab-consultation-corner-ajouter_multiple
    Page Should Contain   Consultation par thematique
    Click On Back Button In SubForm
    Click On Link  css=a#action-soustab-consultation-corner-ajouter_consultation_tiers
    Page Should Contain   catégorie du tiers consulté
    Click On Back Button In SubForm
    # Onglet Commission
    On clique sur l'onglet  dossier_commission  Commission(s)
    Page Should Contain Element  css=a#action-soustab-dossier_commission-corner-ajouter
    Click On Link  css=a#action-soustab-dossier_commission-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain   type de commission
    Click On Back Button In SubForm
    # Onglet lots
    On clique sur l'onglet  lot  Lot(s)
    Page Should Contain Element  css=a#action-soustab-lot-corner-ajouter
    Click On Link  css=a#action-soustab-lot-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain    libellé
    Click On Back Button In SubForm
    # Onglet message
    On clique sur l'onglet  dossier_message  Message(s)
    Page Should Not Contain Element  css=a#action-soustab-dossier_message-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain     Aucun enregistrement.
    # onglet bloc-note
    On clique sur l'onglet  blocnote  Bloc-note
    Page Should Contain Element  css=a#action-soustab-blocnote-corner-ajouter
    Click On Link  css=a#action-soustab-blocnote-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain    catégorie
    Click On Back Button In SubForm
    # onglet Pièces & Documents : sous onglets pièce pétitionnaire
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Page Should Not Contain Element  css=a#action-soustab-blocnote-message-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain    Aucun enregistrement
    # onglet Pièces & Documents : sous onglets Docs. instruction
    Click Element Until New Element  css=div[data-view="document_instruction"]  css=div.switcher__label.onglet_active[data-view="document_instruction"]
    Page Should Contain Element  css=a#zip_download_link
    Wait Until Page Contains Element  css=a#action-soustab-document_numerise-corner-ajouter
    Click On Link  css=a#action-soustab-document_numerise-corner-ajouter
    Page Should Contain    Fichier
    Click On Back Button In SubForm
    Click On Link  css=a#zip_download_link
    Page Should Contain    Téléchargement de l'archive
    Click On Link  css=a.ui-dialog-titlebar-close
    # onglet Pièces & Documents : sous onglets Dossier final
    Click On Link  css=#switch-toutes_les_pieces-pieces_deposees a.toutes-les-pieces-16
    Page Should Contain Element  css=input[name="constituer_dossier_final"]
    # onglet Dossiers Liés
    On clique sur l'onglet  lien_dossier_dossier  Dossiers Liés
    Page Should Contain Element  css=a#action-soustab-dossier_lies-corner-ajouter
    Click On Link  css=a#action-soustab-dossier_lies-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain    dossier cible
    Click On Back Button In SubForm
    Page Should Contain Element  css=div#sousform-dossier_autorisation
    Page Should Contain Element  css=div#sousform-dossier_lies
    Page Should Contain Element  css=div#sousform-dossier_lies_retour
    Page Should Contain Element  css=div#sousform-dossier_lies_geographiquement
    La page ne doit pas contenir d'erreur


    # Vérification de la redirection dans le contexte voulu
    ${libelle_sans_espace} =  Sans espace  ${dossier_parent_di}
    On clique sur l'onglet  main  DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=a[id^=form-action-sous_dossier-back]
    # Vérification de la redirection vers le dossier parent dans l'onglet sous-dossier
    Click On Back Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  sous dossier test ads
    # Vérification de la redirection vers le listing des infractions avec les paramètres voulus de
    # recherche avancée
    On clique sur l'onglet  main  DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=a[id^=form-action-dossier_instruction-back]
    Click On Back Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=input#dossier
    ${val_recherche} =  Get Value  css=input#dossier
    Should Be equal  ${libelle_sans_espace}  ${val_recherche}

    #Affichage des sous-dossiers dans le contexte d'un widget

    Depuis la page d'accueil  admin  admin
    # Paramétrage du widget
    ${om_widget_libelle} =  Set Variable  TEST055WIDGETSUIVIINSTRPARAMETRABLE
    &{args_om_widget} =  Create Dictionary
    ...  libelle=${om_widget_libelle}
    ...  type=file - le contenu du widget provient d'un script sur le serveur
    ...  script=suivi_instruction_parametrable
    ...  arguments=evenement_id=${evenement_id}\naffichage=liste\naffichage_colonne=petitionnaire\nfiltre=aucun\ncodes_datd=pci\nmessage_help=Ceci est un widget
    ${om_widget} =  Ajouter le widget depuis l'URL  ${args_om_widget}
    &{args_om_dashboard} =  Create Dictionary
    ...  om_widget=${om_widget_libelle}
    ...  om_profil=ADMINISTRATEUR TECHNIQUE ET FONCTIONNEL
    ...  bloc=C1
    ...  position=1
    ${om_dashboard} =  Ajouter le widget au tableau de bord du profil depuis l'URL  ${args_om_dashboard}
    # Ajout d'une instruction pour filtrer et n'avoir qu'un seul résultat dans le widget
    Ajouter une instruction au DI  ${dossier_parent_di}  Test des sous-dossiers

    # Accès au tableau de bord et accès au DI créé précedemment en passant par le widget
    Go To Dashboard
    Click On Link  css=.widget_suivi_instruction_parametrable td.firstcol a[href$="idx=${libelle_sans_espace}"]
    La page ne doit pas contenir d'erreur

    # Vérifie que les sous-onglets accessible sont bien les mêmes entre le dossier
    # et le sous-dossier
    # Récupération de la liste des onglets du DI moins l'onglet sous-dossier
    ${onglets} =  Get WebElements  css=ul.ui-tabs-nav li a
    ${onglet_ids}=    Create List
    :FOR  ${onglet}  IN  @{onglets}
    \    ${value}=  Get Element Attribute  ${onglet}  id
    \    Append To List  ${onglet_ids}  ${value}
    Log List  ${onglet_ids}
    Remove Values From List  ${onglet_ids}  sous_dossier
    Log List  ${onglet_ids}

    Ajouter le sous-dossier au dossier  ${idSDTestAds}
    # Récupération de la liste des onglets du sous DI
    ${onglets_sd} =  Get WebElements  css=ul.ui-tabs-nav li a
    ${onglet_sd_ids}=    Create List
    :FOR  ${onglet_sd}  IN  @{onglets_sd}
    \    ${value}=  Get Element Attribute  ${onglet_sd}  id
    \    Append To List  ${onglet_sd_ids}  ${value}
    Log List  ${onglet_sd_ids}
    Lists Should Be Equal  ${onglet_ids}  ${onglet_sd_ids}

    # Pour chaque sous-onglet vérifie qu'il n'y a pas d'erreur et que les actions
    # et les éléments voulus sont tous présent
    # Onglet Contraintes
    On clique sur l'onglet  dossier_contrainte  Contrainte(s)
    Page Should Contain Element  css=a#action-soustab-dossier_contrainte-corner-ajouter
    Click On Link  css=a#action-soustab-dossier_contrainte-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain   Contraintes liées au dossier
    Click On Back Button In SubForm
    # Onglet Instruction
    On clique sur l'onglet  instruction  Instruction
    Page Should Contain Element  css=a#action-soustab-instruction-corner-ajouter
    Click On Link  css=a#action-soustab-instruction-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain  événement
    Click On Back Button In SubForm
    # Onglet Consultation
    On clique sur l'onglet  consultation  Consultation(s)
    Page Should Contain Element  css=a#action-soustab-consultation-corner-ajouter
    Page Should Contain Element  css=a#action-soustab-consultation-corner-ajouter_multiple
    Page Should Contain Element  css=a#action-soustab-consultation-corner-ajouter_consultation_tiers
    Click On Link  css=a#action-soustab-consultation-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain   Service
    Click On Back Button In SubForm
    Click On Link  css=a#action-soustab-consultation-corner-ajouter_multiple
    Page Should Contain   Consultation par thematique
    Click On Back Button In SubForm
    Click On Link  css=a#action-soustab-consultation-corner-ajouter_consultation_tiers
    Page Should Contain   catégorie du tiers consulté
    Click On Back Button In SubForm
    # Onglet Commission
    On clique sur l'onglet  dossier_commission  Commission(s)
    Page Should Contain Element  css=a#action-soustab-dossier_commission-corner-ajouter
    Click On Link  css=a#action-soustab-dossier_commission-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain   type de commission
    Click On Back Button In SubForm
    # Onglet lots
    On clique sur l'onglet  lot  Lot(s)
    Page Should Contain Element  css=a#action-soustab-lot-corner-ajouter
    Click On Link  css=a#action-soustab-lot-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain    libellé
    Click On Back Button In SubForm
    # Onglet message
    On clique sur l'onglet  dossier_message  Message(s)
    Page Should Contain Element  css=a#action-soustab-dossier_message-corner-ajouter
    Click On Link  css=a#action-soustab-dossier_message-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain   émetteur
    Click On Back Button In SubForm
    # onglet bloc-note
    On clique sur l'onglet  blocnote  Bloc-note
    Page Should Contain Element  css=a#action-soustab-blocnote-corner-ajouter
    Click On Link  css=a#action-soustab-blocnote-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain    catégorie
    Click On Back Button In SubForm
    # onglet Pièces & Documents : sous onglets pièce pétitionnaire
    On clique sur l'onglet  document_numerise  Pièces & Documents
    Page Should Contain Element  css=a#action-soustab-blocnote-message-ajouter
    Click On Link  css=a#action-soustab-blocnote-message-ajouter
    Page Should Contain  Nature de pièce 
    La page ne doit pas contenir d'erreur
    Click On Back Button In SubForm
    # onglet Pièces & Documents : sous onglets Docs. instruction
    Click Element Until New Element  css=div[data-view="document_instruction"]  css=div.switcher__label.onglet_active[data-view="document_instruction"]
    Page Should Contain Element  css=a#zip_download_link
    Wait Until Page Contains Element   css=a#action-soustab-document_numerise-corner-ajouter
    Click On Link  css=a#action-soustab-document_numerise-corner-ajouter
    Page Should Contain    Fichier
    Click On Back Button In SubForm
    Click On Link  css=a#zip_download_link
    Page Should Contain    Téléchargement de l'archive
    Click On Link  css=a.ui-dialog-titlebar-close
    # onglet Pièces & Documents : sous onglets Dossier final
    Click On Link  css=#switch-toutes_les_pieces-pieces_deposees a.toutes-les-pieces-16
    Page Should Contain Element  css=input[name="constituer_dossier_final"]
    # onglet Dossiers Liés
    On clique sur l'onglet  lien_dossier_dossier  Dossiers Liés
    Page Should Contain Element  css=a#action-soustab-dossier_lies-corner-ajouter
    Click On Link  css=a#action-soustab-dossier_lies-corner-ajouter
    La page ne doit pas contenir d'erreur
    Page Should Contain    dossier cible
    Click On Back Button In SubForm
    Page Should Contain Element  css=div#sousform-dossier_autorisation
    Page Should Contain Element  css=div#sousform-dossier_lies
    Page Should Contain Element  css=div#sousform-dossier_lies_retour
    Page Should Contain Element  css=div#sousform-dossier_lies_geographiquement

    # Vérification de la redirection dans le contexte voulu
    On clique sur l'onglet  main  DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=a[id^=form-action-sous_dossier-back]
    # Vérification de la redirection vers le dossier parent dans l'onglet sous-dossier
    Click On Back Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  sous dossier test ads
    # Vérification de la redirection vers le listing des infractions avec les paramètres voulus de
    # recherche avancée
    On clique sur l'onglet  main  DI
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain Element  css=a[id^=form-action-dossier_instruction-back]
    Click On Back Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Ceci est un widget

    # Réinitialisation des paramètres et suppression du widget
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_mode_service_consulte
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
    Supprimer le tableau de bord depuis l'URL par l'identifiant  ${om_dashboard}
    Supprimer le widget depuis l'URL par l'identifiant  ${om_widget}
    # Suppression du tiers ajouté pour le test
    Supprimer le tiers consulte  ${id_tiers}


Vérification de l'ajout d'un nouveau type de sous-dossier DI, ne délenchant pas la création d’un DA
    [Documentation]  Ajout d'un nouveau type de sous-dossier DI empêchant de déclencher la création d’un DA

    Depuis la page d'accueil  admin  admin

    # 1 - Ajout d'un nouveau type de sous_dossier DI
    &{args_type_di} =  Create Dictionary
    ...  code=test055
    ...  libelle=testons
    ...  description=testons
    ...  dossier_autorisation_type_detaille=PCI (Permis de construire pour une maison individuelle et / ou ses annexes)
    ...  suffixe=true
    Ajouter type de dossier d'instruction  ${args_type_di}
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    Click On Back Button

    # Vérification de la bonne existance du nouveau type de sous_dossier DI
    Depuis la page d'accueil  admin  admin
    Depuis le listing  dossier_autorisation_type_detaille
    Use Simple Search  type de dossier d'autorisation  PC
    Click On Link  PCI
    La page ne doit pas contenir d'erreur
    Click Element  css=#dossier_instruction_type
    Click On Link  ${args_type_di.code}
    # On vérifie que les champs "sous_dossier" et "Sous-dossier pour le(s) DI" sont bien statiques et visible
    Click Element  css=#action-sousform-dossier_instruction_type-modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#sous_dossier  Non
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#lib-lien_sous_dossier_type_di  ${EMPTY}
