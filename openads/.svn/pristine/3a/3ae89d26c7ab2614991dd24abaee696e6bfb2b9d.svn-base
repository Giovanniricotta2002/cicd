*** Settings ***
Documentation  Test les dépôts de demandes

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Ajouter une demande de recours

    # Dossier source
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire&Co
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Martinez
    ...  personne_morale_prenom=Nicolas
    ...  om_collectivite=MARSEILLE

    &{args_avocat} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire&Co
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Avocat
    ...  personne_morale_prenom=Nicolas
    ...  frequent=true


    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  om_collectivite=MARSEILLE
    ...  demande_type=Dépôt Initial
    ${di_src} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Dossier cible
    Depuis la page d'accueil  assist  assist
    Depuis le contexte de nouvelle demande contentieux via l'URL
    Select From List By Label    dossier_autorisation_type_detaille    Recours contentieux
    Capture Page Screenshot
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text    css=#fieldset-form-demande_nouveau_dossier_contentieux-autorisation-contestee #autorisation_contestee    ${di_src}
    Capture Page Screenshot
    Click Button    css=#autorisation_contestee_search_button
    Capture Page Screenshot
    Page Should Not Contain    Il n'existe aucun dossier correspondant au numéro ${di_src}. Saisissez un nouveau numéro puis recommencez.
    Capture Page Screenshot
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain    css=#petitionnaire_principal_delegataire    Notaire&Co
    Ajouter le demandeur  avocat_principal  ${args_avocat}
    # On clique sur le bouton d'ajout d'un avocat
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  add_avocat
    # On saisit le nom
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Select From List By Label    qualite    personne morale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Input Text  personne_morale_nom  Avocat
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#fieldset-sousform-avocat-personne-morale span.search-frequent-16
    # On sélectionne l'avocat
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  select-avocat  Société Notaire&Co Avocat  Avocat Nicolas
    Click Element  css=div.dialog-search-frequent-avocat.dialog-search-frequent-avocat div.ui-dialog-buttonset button span
    Click On Back Button In Subform

    Click On Submit Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur
    ${libelle_di_re} =    Get Text    id=new_di
    Click Link    Accéder au dossier d'instruction
    La page ne doit pas contenir d'erreur
    On clique sur l'onglet  lien_dossier_dossier_contexte_ctx_re  Dossiers Liés
    Element Should Contain    sousform-dossier_lies    ${di_src}

    Set Suite Variable  ${libelle_di_re}

    # On vérifie le fonctionnement du champ "Référence DSJ" récupéré depuis les
    # données techniques
    &{dt_values} =  Create Dictionary
    ...  ctx_reference_dsj=Wazaaa
    Saisir les données techniques du DI  ${libelle_di_re}  ${dt_values}  recours  _contexte_ctx
    Click On Back Button In Subform
    Depuis le contexte du dossier d'instruction  ${libelle_di_re}  recours
    Form Static Value Should Be  ctx_reference_dsj  Wazaaa

    # On vérifie le fonctionnement du champ "Référence SAGACE" récupéré depuis les
    # données techniques
    &{dt_values} =  Create Dictionary
    ...  ctx_reference_sagace=Blork
    Saisir les données techniques du DI  ${libelle_di_re}  ${dt_values}  recours  _contexte_ctx
    Click On Back Button In Subform
    Depuis le contexte du dossier d'instruction  ${libelle_di_re}  recours
    Form Static Value Should Be  ctx_reference_sagace  Blork


Vérifier l'ajout de demande en fonction du paramétrage du type de dossier d'autorisation

    [Documentation]  8 cas d'utilisations :
    ...  1. Le profil de l'utilisateur connecté peut ajouter un type de DA
    ...  2. Le profil de l'utilisateur connecté ne peut pas ajouter un type de DA
    ...  3. L'utilisateur connecté à directement le droit d'ajouter un type de DA et surcharge le paramétrage du profil
    ...  4. L'utilisateur connecté à directement l'interdiction d'ajouter un type de DA et surcharge le paramétrage du profil
    ...  5. L'utilisateur connecté à directement le droit d'accéder à un type de DA confidentiel et surcharge le paramétrage du profil
    ...  6. L'utilisateur connecté à directement l'interdiction d'accéder à un type de DA confidentiel et surcharge le paramétrage du profil
    ...  7. Le profil de l'utilisateur connecté peut accéder à un type de DA confidentiel
    ...  8. Le profil de l'utilisateur connecté ne peut pas accéder à un type de DA confidentiel

    #
    # Initialisation du paramétrage
    #
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du profil  null  GUICHET UNIQUE
    On clique sur l'onglet  lien_om_profil_groupe  Groupe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ERP
    # On clique sur le bouton modifier
    Click On SubForm Portlet Action  lien_om_profil_groupe  modifier
    # On desactive l'ajout de demande
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Set Checkbox  enregistrement_demande  false
    # On valide le formulaire
    Click On Submit Button In Subform


    #
    # Cas 1 le Guichet unique peut ajouter un dossier ADS
    #
    Depuis la page d'accueil  guichet  guichet
    #
    Depuis le contexte de nouvelle demande via l'URL
    ${list_da_type_ads} =    Create List
    ...    Permis de construire pour une maison individuelle et / ou ses annexes
    # Le select doit contenir les types détaillés de DA du groupe ADS
    Select List Should Contain List  dossier_autorisation_type_detaille  ${list_da_type_ads}

    #
    # Cas 2 le Guichet unique ne peut ajouter un dossier ERP
    #
    ${list_da_type_erp} =    Create List
    ...    Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    Select List Should Not Contain List  dossier_autorisation_type_detaille  ${list_da_type_erp}

    #
    # Initialisation de surcharge des groupes par utilisateur
    #
    Depuis la page d'accueil  admin  admin
    Depuis le contexte de l'utilisateur  guichet
    On clique sur l'onglet  lien_om_utilisateur_groupe  Groupe
    # On clique sur le bouton ajouter pour surcharger les droits sur le groupe ADS
    Click On Add Button
    &{lien_om_utilisateur_groupe_ads} =    Create Dictionary
    ...  groupe=Autorisation ADS
    ...  confidentiel=true
    Saisir lien_om_utilisateur_groupe  ${lien_om_utilisateur_groupe_ads}
    # On valide le formulaire
    Click On Submit Button In Subform
    Click On Back Button In Subform
    # On clique sur le bouton ajouter pour surcharger les droits sur le groupe ERP
    Click On Add Button
    &{lien_om_utilisateur_groupe_erp} =    Create Dictionary
    ...  groupe=ERP
    ...  confidentiel=true
    ...  enregistrement_demande=true
    Saisir lien_om_utilisateur_groupe  ${lien_om_utilisateur_groupe_erp}
    # On valide le formulaire
    Click On Submit Button In Subform
    Click On Back Button In Subform

    #
    # Cas 3 le Guichet unique peut ajouter un dossier ADS
    #
    Depuis la page d'accueil  guichet  guichet
    #
    Depuis le contexte de nouvelle demande via l'URL
    ${list_da_type_erp} =    Create List
    ...    Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    # Le select doit contenir les types détaillés de DA du groupe ADS
    Select List Should Contain List  dossier_autorisation_type_detaille  ${list_da_type_erp}

    #
    # Cas 4 le Guichet unique ne peut ajouter un dossier ERP
    #
    ${list_da_type_ads} =    Create List
    ...    Permis de construire pour une maison individuelle et / ou ses annexes
    Select List Should Not Contain List  dossier_autorisation_type_detaille  ${list_da_type_ads}

    #
    # Cas 5 le guichet ajoute une demande de type confidentielle avec surcharge utilisateur
    #
    Depuis la page d'accueil  admin  admin
    Depuis le listing  dossier_autorisation_type
    Click On Link    AT
    Click On Form Portlet Action  dossier_autorisation_type  modifier
    Set Checkbox  confidentiel  true
    Click On Submit Button
    Depuis la page d'accueil  guichet  guichet
    #
    Depuis le contexte de nouvelle demande via l'URL
    ${list_da_type_erp} =    Create List
    ...    Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    Select List Should Contain List  dossier_autorisation_type_detaille  ${list_da_type_erp}

    #
    # Cas 6 le guichet ne peut pas ajouter une demande de type confidentielle avec surcharge utilisateur
    #
    Depuis la page d'accueil  admin  admin
    Depuis le contexte de l'utilisateur  guichet
    On clique sur l'onglet  lien_om_utilisateur_groupe  Groupe
    Click On Link  ERP
    Click On SubForm Portlet Action  lien_om_utilisateur_groupe  modifier
    Set Checkbox  confidentiel  false
    Click On Submit Button In Subform
    Depuis la page d'accueil  guichet  guichet
    #
    Depuis le contexte de nouvelle demande via l'URL
    ${list_da_type_erp} =    Create List
    ...    Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    Select List Should Not Contain List  dossier_autorisation_type_detaille  ${list_da_type_erp}

    #
    # Cas 7 le guichet ne peut pas ajouter une demande de type confidentielles
    #
    Depuis la page d'accueil  admin  admin
    # Suppression des surcharges
    Depuis le contexte de l'utilisateur  guichet
    On clique sur l'onglet  lien_om_utilisateur_groupe  Groupe
    Click On Link  ERP
    Click On SubForm Portlet Action  lien_om_utilisateur_groupe  supprimer
    Click On Submit Button In Subform
    Click On Link  Autorisation ADS
    Click On SubForm Portlet Action  lien_om_utilisateur_groupe  supprimer
    Click On Submit Button In Subform
    # Modification du paramétrage du groupe
    Depuis le contexte du profil  null  GUICHET UNIQUE
    On clique sur l'onglet  lien_om_profil_groupe  Groupe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ERP
    # On clique sur le bouton modifier
    Click On SubForm Portlet Action  lien_om_profil_groupe  modifier
    # On desactive l'ajout de demande
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Set Checkbox  confidentiel  true
    Set Checkbox  enregistrement_demande  true
    # On valide le formulaire
    Click On Submit Button In Subform
    Depuis la page d'accueil  guichet  guichet
    #
    Depuis le contexte de nouvelle demande via l'URL
    ${list_da_type_erp} =    Create List
    ...    Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    Select List Should Contain List  dossier_autorisation_type_detaille  ${list_da_type_erp}

    #
    # Cas 8. Le profil de l'utilisateur connecté ne peut pas accéder à un type de DA confidentiel
    #
    Depuis la page d'accueil  admin  admin
    # Modification du paramétrage du groupe
    Depuis le contexte du profil  null  GUICHET UNIQUE
    On clique sur l'onglet  lien_om_profil_groupe  Groupe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ERP
    # On clique sur le bouton modifier
    Click On SubForm Portlet Action  lien_om_profil_groupe  modifier
    # On desactive l'ajout de demande
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Set Checkbox  enregistrement_demande  false
    # On valide le formulaire
    Click On Submit Button In Subform
    Depuis la page d'accueil  guichet  guichet
    #
    Depuis le contexte de nouvelle demande via l'URL
    ${list_da_type_erp} =    Create List
    ...    Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    Select List Should Not Contain List  dossier_autorisation_type_detaille  ${list_da_type_erp}

    # On remet le paramétrage en place
    Depuis la page d'accueil  admin  admin
    Depuis le listing  dossier_autorisation_type
    Click On Link    AT
    Click On Form Portlet Action  dossier_autorisation_type  modifier
    Set Checkbox  confidentiel  false
    Click On Submit Button
    #
    Depuis le contexte du profil  null  GUICHET UNIQUE
    On clique sur l'onglet  lien_om_profil_groupe  Groupe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ERP
    Click On SubForm Portlet Action  lien_om_profil_groupe  modifier
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Set Checkbox  enregistrement_demande  true
    Click On Submit Button In Subform

Verifier que le l'export csv ne contient pas de html avec l'option option_afficher_couleur_dossier activé
    [Documentation]  Ce test verifie que lorsque l'option susnommée dans le titre du test est activé,
    ...    Alors l'export csv ne doit pas contenir de html dans le champ dsosier pour les contentieux

    Depuis la page d'accueil  admin  admin

    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=Chnadonnet
    ...  particulier_prenom=Gaston
    ...  om_collectivite=MARSEILLE
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=Audet
    ...  particulier_prenom=Saber
    ...  om_collectivite=MARSEILLE
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=MARSEILLE
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    &{om_param} =  Create Dictionary
    ...  libelle=option_afficher_couleur_dossier
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    Go To Submenu In Menu  contentieux  dossier_contentieux_toutes_infractions
    ${link_export_listing} =  Get Element Attribute  css=.tab-export a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link_export_listing}  ${EXECDIR}${/}binary_files${/}
    La page ne doit pas contenir d'erreur

    # Récupération du contenu du fichier pour vérifier que le champ dossier n'a pas de html
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    ${content_file} =  Get File  ${full_path_to_file}

    Should Not Contain  ${content_file}  span

    Go To Submenu In Menu  contentieux  dossier_contentieux_tous_recours
    ${link_export_listing} =  Get Element Attribute  css=.tab-export a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link_export_listing}  ${EXECDIR}${/}binary_files${/}
    La page ne doit pas contenir d'erreur

    # Récupération du contenu du fichier pour vérifier que le champ dossier n'a pas de html
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    ${content_file} =  Get File  ${full_path_to_file}

    Should Not Contain  ${content_file}  span

    &{om_param} =  Create Dictionary
    ...  libelle=option_afficher_couleur_dossier
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

Vérifier les listing en fonction du paramétrage du type de dossier d'autorisation

    [Documentation]  4 cas d'utilisations :
    ...  1. utilisateur : non confidentiel, groupe : non confidentiel, type : non confidentiel → visible
    ...  2. utilisateur : non confidentiel, groupe : non confidentiel, type : confidentiel → non visible
    ...  3. utilisateur : non confidentiel, groupe : confidentiel, type : confidentiel → visible
    ...  4. utilisateur : confidentiel, groupe : non confidentiel, type : confidentiel → visible

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
    ...  dossier_autorisation_type_detaille=Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  guichet  guichet

    # Cas 1 :
    # On accède directement au tableau de tous les dossiers d'autorisation
    Depuis le listing  dossier_instruction
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di}
    # On valide le formulaire de recherche
    Click On Search Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Location Should Contain  &advs_id=

    Total Results Should Be Equal  1

    # Cas 2 :
    Depuis la page d'accueil  admin  admin
    # Modification du paramétrage du groupe
    Depuis le contexte du profil  null  GUICHET UNIQUE
    On clique sur l'onglet  lien_om_profil_groupe  Groupe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ERP
    # On clique sur le bouton modifier
    Click On SubForm Portlet Action  lien_om_profil_groupe  modifier
    # On desactive l'ajout de demande
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Set Checkbox  confidentiel  false
    # On valide le formulaire
    Click On Submit Button In Subform
    # On accède directement au tableau de tous les dossiers d'autorisation
    Depuis la page d'accueil  admin  admin
    Depuis le listing  dossier_autorisation_type
    Click On Link    AT
    Click On Form Portlet Action  dossier_autorisation_type  modifier
    Set Checkbox  confidentiel  true
    Click On Submit Button
    Depuis la page d'accueil  guichet  guichet
    Depuis le listing  dossier_instruction
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di}
    # On valide le formulaire de recherche
    Click On Search Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Location Should Contain  &advs_id=

    Total Results Should Be Equal  0

    # Cas 3
    Depuis la page d'accueil  admin  admin
    # Modification du paramétrage du groupe
    Depuis le contexte du profil  null  GUICHET UNIQUE
    On clique sur l'onglet  lien_om_profil_groupe  Groupe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ERP
    # On clique sur le bouton modifier
    Click On SubForm Portlet Action  lien_om_profil_groupe  modifier
    # On desactive l'ajout de demande
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Set Checkbox  confidentiel  true
    # On valide le formulaire
    Click On Submit Button In Subform
    Depuis la page d'accueil  guichet  guichet
    Depuis le listing  dossier_instruction
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di}
    # On valide le formulaire de recherche
    Click On Search Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Location Should Contain  &advs_id=

    Total Results Should Be Equal  1

    # Cas 4
    Depuis la page d'accueil  admin  admin
    # Modification du paramétrage du groupe
    Depuis le contexte du profil  null  GUICHET UNIQUE
    On clique sur l'onglet  lien_om_profil_groupe  Groupe
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On Link  ERP
    # On clique sur le bouton modifier
    Click On SubForm Portlet Action  lien_om_profil_groupe  modifier
    # On desactive l'ajout de demande
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Set Checkbox  confidentiel  false
    # On valide le formulaire
    Click On Submit Button In Subform

    Depuis le contexte de l'utilisateur  guichet
    On clique sur l'onglet  lien_om_utilisateur_groupe  Groupe
    # On clique sur le bouton ajouter pour surcharger les droits sur le groupe ADS
    Click On Add Button
    &{lien_om_utilisateur_groupe_erp} =    Create Dictionary
    ...  groupe=ERP
    ...  confidentiel=true
    ...  enregistrement_demande=true
    Saisir lien_om_utilisateur_groupe  ${lien_om_utilisateur_groupe_erp}
    # On valide le formulaire
    Click On Submit Button In Subform

    Depuis la page d'accueil  guichet  guichet
    Depuis le listing  dossier_instruction
    # On fait une recherche sur le libellé du DI
    Input Text  css=div#adv-search-adv-fields input#dossier  ${di}
    # On valide le formulaire de recherche
    Click On Search Button
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Location Should Contain  &advs_id=

    Total Results Should Be Equal  1

    # On remet le paramétrage en place
    Depuis la page d'accueil  admin  admin
    Depuis le listing  dossier_autorisation_type
    Click On Link    AT
    Click On Form Portlet Action  dossier_autorisation_type  modifier
    Set Checkbox  confidentiel  false
    Click On Submit Button
    Depuis le contexte de l'utilisateur  guichet
    On clique sur l'onglet  lien_om_utilisateur_groupe  Groupe
    Click On Link   ERP
    Click On SubForm Portlet Action  lien_om_utilisateur_groupe  supprimer
    Click On Submit Button In Subform

Vérifier la liste des instructeurs

    [Documentation]  Sur les DI :
    ...  si le type d'affichage est "ADS" affiche les instructeurs de qualité "Instructeur" (instructeur et instructeur_2),
    ...  si le type d'affichage est "CTX RE" ou "CTX IN" afficher seulement les instructeurs de qualité "Juriste".
    ...  Si le type d'affichage est CTX IN afficher le second instructeur de type technicien

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}
    Depuis le contexte de l'utilisateur  instr1
    On clique sur l'onglet  instructeur  Instructeur
    Click On Link    Martine Nadeau
    Click On SubForm Portlet Action  instructeur  modifier
    Select From List By Label  instructeur_qualite  juriste
    Select From List By Label  division  subdivision H
    Click On Submit Button In Subform

    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=personne morale
    ...  personne_morale_denomination=Notaire&Co
    ...  personne_morale_raison_sociale=Société
    ...  personne_morale_civilite=Monsieur
    ...  personne_morale_nom=Martin
    ...  personne_morale_prenom=Nicolas
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Demande d'autorisation de construire, d'aménager ou de modifier un ERP
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

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
    ${di_inf} =  Ajouter la demande par WS  ${args_demande}  ${NULL}  ${args_autres_demandeurs}

    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  modifier
    ${list_instructeur_juriste} =    Create List
    ...    Martine Nadeau (H)
    Select List Should Not Contain List  instructeur  ${list_instructeur_juriste}
    Select List Should Not Contain List  instructeur_2  ${list_instructeur_juriste}

    Depuis le formulaire de modification du dossier recours  ${libelle_di_re}
    ${list_instructeur_juriste} =    Create List
    ...    Martine Nadeau (H)
    Select List Should Contain List  instructeur  ${list_instructeur_juriste}
    Element Should Not Be Visible  instructeur_2

    Depuis le contexte de l'utilisateur  instr1
    On clique sur l'onglet  instructeur  Instructeur
    Click On Link    Martine Nadeau
    Click On SubForm Portlet Action  instructeur  modifier
    Select From List By Label  instructeur_qualite  technicien
    Click On Submit Button In Subform

    Depuis le formulaire de modification du dossier infraction  ${di_inf}
    ${list_instructeur_tech} =    Create List
    ...    Martine Nadeau (H)
    Select List Should Not Contain List  instructeur  ${list_instructeur_tech}
    Select List Should Contain List  instructeur_2  ${list_instructeur_tech}

    # RAZ des données
    Depuis le contexte de l'utilisateur  instr1
    On clique sur l'onglet  instructeur  Instructeur
    Click On Link    Martine Nadeau
    Click On SubForm Portlet Action  instructeur  modifier
    Select From List By Label  instructeur_qualite  instructeur
    Click On Submit Button In Subform

    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_afficher_division
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}


    # Vérification du bon fonctionnement du numéro d'archive et de son bon affichage (colonne et RA+RS)
    Depuis la page d'accueil  tech  tech

    # Synthèse Dossier infraction
    # Vérifier que le champ archive est bien présent dans la synthèse du dossier d'infraction
    Depuis le contexte du dossier infraction  ${di_inf}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#lib-numero_versement_archive

    # Vérifier que le champ "Numéro" du fieldset "Archive" est modifiable, et que tout se passe correctement
    # Ajout d'un numéro d'archive : 123456
    ${numero_versement_archive} =  Set Variable  123456
    Modifier le dossier infraction  dossier_infraction=${di_inf}  numero_versement_archive=${numero_versement_archive}
    Page Should Contain  Vos modifications ont bien été enregistrées.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#numero_versement_archive  ${numero_versement_archive}

    # Section 'mes infractions'
    # Vérification de la présence du champ n° d'archive à la place du champ référénce dsj
    Depuis le listing  dossier_contentieux_mes_infractions
    # Vérfier que la colonne 'n° archive' est bien présente
    Element Should Contain  css=table.tab-tab th.title.col-7 span.name a  n° archive
    # Vérifier la RS pour 'mes infractions'
    # Recherche simplifié global
    Use Simple Search  Tous  ${numero_versement_archive}
    Page Should Not Contain  Aucun enregistrement.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-7  ${numero_versement_archive}
    # Recherche simplifié spécifique au numéro d'archive
    Use Simple Search  Numéro d'archive  ${numero_versement_archive}
    Page Should Not Contain  Aucun enregistrement.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-7  ${numero_versement_archive}

    # Section 'toutes les infractions'
    # Vérification de la présence du champ n° d'archive à la place du champ référénce dsj
    Depuis le listing  dossier_contentieux_toutes_infractions
    # Vérfier que la colonne 'n° archive' est bien présente
    Element Should Contain  css=table.tab-tab th.title.col-7 span.name a  n° archive

    # Vérifier la RS pour 'toutes les infractions'
    # Recherche simplifié
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-classic-fields input.champFormulaire
    Input Text  css=div#adv-search-classic-fields input.champFormulaire  ${numero_versement_archive}
    Click On Search Button
    # Vérifie que la RS fonctionne bien pour le numéro d'archive
    Page Should Not Contain  Aucun enregistrement.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-7  ${numero_versement_archive}

    # Recherche avancée spécifique au numéro d'archive
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#numero_versement_archive
    Input Text  css=div#adv-search-adv-fields input#numero_versement_archive  ${numero_versement_archive}
    Click On Search Button
    # Vérifie que la RS fonctionne bien pour le numéro d'archive
    Page Should Not Contain  Aucun enregistrement.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-7  ${numero_versement_archive}


    # Ajout d'un dossier recours contentieux
    &{args_dossier} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire3} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=bo
    ...  particulier_prenom=bo
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_dossier}  ${args_petitionnaire3}
    &{args_dossier_contentieux} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours contentieux
    ...  demande_type=Dépôt Initial REC
    ...  autorisation_contestee=${di}
    ...  om_collectivite=MARSEILLE
    ${di_re} =  Ajouter la demande par WS  ${args_dossier_contentieux}

    Depuis la page d'accueil  juriste  juriste

    # Synthèse Dossier recours
    # Vérifier que le champ archive est bien présent dans la synthèse du dossier recours
    Depuis le contexte du dossier recours  ${di_re}
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#lib-numero_versement_archive

    # Vérifier que le champ "Numéro" du fieldset "Archive" est modifiable, et que tout se passe correctement
    # Ajout d'un numéro d'archive : 535353
    ${numero_versement_archive} =  Set Variable  535353
    Modifier le dossier recours  dossier_recours=${di_re}  numero_versement_archive=${numero_versement_archive}
    Page Should Contain  Vos modifications ont bien été enregistrées.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Value Should Be  css=#numero_versement_archive  ${numero_versement_archive}

    # Section 'mes recours'
    Depuis le listing  dossier_contentieux_mes_recours
    # Vérfier que la colonne 'n° archive' est bien présente
    Element Should Contain  css=table.tab-tab th.title.col-10 span.name a  numéro d'archive

    # Vérifier la RS pour 'mes recours'
    Depuis le listing  dossier_contentieux_mes_recours
    Use Simple Search  Tous  ${numero_versement_archive}
    Page Should Not Contain  Aucun enregistrement.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-10  ${numero_versement_archive}
    # Recherche simplifié spécifique au numéro d'archive
    Use Simple Search  Numéro d'archive  ${numero_versement_archive}
    Page Should Not Contain  Aucun enregistrement.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-10  ${numero_versement_archive}

    # Section 'tous les recours'
    Depuis le listing  dossier_contentieux_tous_recours
    # Vérfier que la colonne 'uméro d'archive' est bien présente
    Element Should Contain  css=table.tab-tab th.title.col-10 span.name a  numéro d'archive

    # Vérifier la RS pour 'toutes les recours'
    # Recherche simplifié
    Click Element  css=#toggle-advanced-display
    Wait Until Element Is Visible  css=div#adv-search-classic-fields input.champFormulaire
    Input Text  css=div#adv-search-classic-fields input.champFormulaire  ${numero_versement_archive}
    Click On Search Button
    # Vérifie que la RS fonctionne bien pour le numéro d'archive
    Page Should Not Contain  Aucun enregistrement.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-10  ${numero_versement_archive}

    # Vérifier la RA pour 'toutes les recours'
    Depuis le listing  dossier_contentieux_tous_recours
    Wait Until Element Is Visible  css=div#adv-search-adv-fields input#numero_versement_archive
    Input Text  css=div#adv-search-adv-fields input#numero_versement_archive  ${numero_versement_archive}
    Click On Search Button
    # Vérifie que la RA fonctionne bien pour le numéro d'archive
    Page Should Not Contain  Aucun enregistrement.
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=td.col-10  ${numero_versement_archive}

    # Section 'toutes les infractions'
    # Vérification de la présence du champ référénce dsj
    Depuis le listing  dossier_contentieux_toutes_infractions
    # Vérfier que la colonne 'reference_dsj' n'est plus présente
    Element Should Contain  css=table.tab-tab th.title.col-6 span.name a  référence dsj

    # Section 'mes infractions'
    # Vérification de la présence du champ référénce dsj
    Depuis le listing  dossier_contentieux_mes_infractions
    # Vérfier que la colonne 'reference_dsj' n'est plus présente
    Element Should Contain  css=table.tab-tab th.title.col-6 span.name a  référence dsj
