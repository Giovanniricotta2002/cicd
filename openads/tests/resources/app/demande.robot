*** Settings ***
Documentation     Actions spécifiques aux demandes

*** Keywords ***
Ajouter la nouvelle demande
    [Arguments]  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}=  ${menu}=

    # On ouvre le menu nouveau dossier
    Run Keyword If  '${menu}' == 'contentieux'  Depuis le contexte de nouvelle demande contentieux via l'URL
    ...  ELSE  Depuis le contexte de nouvelle demande via l'URL
    ${libelle_di} =  Ajouter la demande et récupérer le numéro de DI  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}
    # On retourne le numéro de DI
    [Return]  ${libelle_di}

Ajouter la nouvelle demande depuis le menu
    [Arguments]  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}=

    # On ouvre le menu nouveau dossier
    Depuis le contexte de nouvelle demande via le menu
    ${libelle_di} =  Ajouter la demande et récupérer le numéro de DI  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}
    # On retourne le numéro de DI
    [Return]  ${libelle_di}

Ajouter la nouvelle demande depuis le tableau de bord
    [Arguments]  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}=
    # On ouvre le menu nouveau dossier
    Depuis le contexte de nouvelle demande via le tableau de bord
    ${libelle_di} =  Ajouter la demande et récupérer le numéro de DI  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}
    # On retourne le numéro de DI
    [Return]  ${libelle_di}

Ajouter la nouvelle demande et récupérer le numéro de pétitionnaire
    [Arguments]  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}=
    # On ouvre le menu nouveau dossier
    Depuis le contexte de nouvelle demande via l'URL
    ${libelle_di} =  Ajouter la demande et récupérer le numéro de DI  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}
    ${demandeur_id} =  Get Value  css=#petitionnaire_principal_delegataire .demandeur_id
    # On retourne le numéro de DI
    [Return]  ${libelle_di}  ${demandeur_id}

Ajouter la demande et récupérer le numéro de DI
    [Arguments]  ${demande_values}  ${petitionnaire_values}=  ${autres_demandeurs_values}=
    Ajouter la demande  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}
    Validation du formulaire de la demande
    # On récupère le libelle du dossier d'instruction
    ${libelle_di} =  Get Text  new_di
    # On retourne le numéro de DI
    [Return]  ${libelle_di}


Ajouter la demande
    [Arguments]  ${demande_values}  ${petitionnaire_values}=  ${autres_demandeurs_values}=

    # On remplit le formulaire
    Saisir la demande  ${demande_values}

    # Ajout du pétitionnaire principal seulement s'il est passé en paramètre
    ${length} =   Get Length  ${petitionnaire_values}
    ${is_petitionnaire_principal_defined} =  Run Keyword And Return Status  Should Not Be Equal As Integers  ${length}  0
    ${is_petitionnaire_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  petitionnaire
    ${is_petitionnaire2_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  petitionnaire2
    ${is_petitionnaire3_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  petitionnaire3
    ${is_delegataire_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  delegataire
    ${is_proprietaire_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  proprietaire
    ${is_contrevenant_principal_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  contrevenant_principal
    ${is_contrevenant_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  contrevenant
    ${is_plaignant_principal_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  plaignant_principal
    ${is_plaignant_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  plaignant
    ${is_requerant_principal_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  requerant_principal
    ${is_requerant_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  requerant
    ${is_avocat_principal_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  avocat_principal
    ${is_avocat_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  avocat
    ${is_bailleur_principal_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  bailleur_principal
    ${is_bailleur_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  bailleur
    ${is_architecte_legi_connexe_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  architecte_lc
    ${is_concepteur_paysagiste_defined} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${autres_demandeurs_values}  paysagiste

    # On attend que tous les demandeurs principaux des contentieux soient affichés
    Sleep  0.2
    Run Keyword If  ${is_avocat_principal_defined} == True  Wait Until Element Is Visible  css=#add_avocat_principal
    Run Keyword If  ${is_requerant_principal_defined} == True  Wait Until Element Is Visible  css=#add_requerant_principal
    Run Keyword If  ${is_contrevenant_principal_defined} == True  Wait Until Element Is Visible  css=#add_contrevenant_principal

    # On attend que le bailleur soit Visible
    Run Keyword If  ${is_bailleur_principal_defined} == True  Wait Until Element Is Visible  css=#add_bailleur_principal

    Run Keyword If  ${is_petitionnaire_principal_defined} == True  Ajouter le demandeur  petitionnaire_principal  ${petitionnaire_values}
    Run Keyword If  ${is_petitionnaire_defined} == True  Ajouter le demandeur  petitionnaire  ${autres_demandeurs_values.petitionnaire}
    Run Keyword If  ${is_petitionnaire2_defined} == True  Ajouter le demandeur  petitionnaire  ${autres_demandeurs_values.petitionnaire2}
    Run Keyword If  ${is_petitionnaire3_defined} == True  Ajouter le demandeur  petitionnaire  ${autres_demandeurs_values.petitionnaire3}
    Run Keyword If  ${is_delegataire_defined} == True  Ajouter le demandeur  delegataire  ${autres_demandeurs_values.delegataire}
    Run Keyword If  ${is_proprietaire_defined} == True  Ajouter le demandeur  proprietaire  ${autres_demandeurs_values.proprietaire}
    Run Keyword If  ${is_contrevenant_principal_defined} == True  Ajouter le demandeur  contrevenant_principal  ${autres_demandeurs_values.contrevenant_principal}
    Run Keyword If  ${is_contrevenant_defined} == True  Ajouter le demandeur  contrevenant  ${autres_demandeurs_values.contrevenant}
    Run Keyword If  ${is_plaignant_principal_defined} == True  Ajouter le demandeur  plaignant_principal  ${autres_demandeurs_values.plaignant_principal}
    Run Keyword If  ${is_plaignant_defined} == True  Ajouter le demandeur  plaignant  ${autres_demandeurs_values.plaignant}
    Run Keyword If  ${is_requerant_principal_defined} == True  Ajouter le demandeur  requerant_principal  ${autres_demandeurs_values.requerant_principal}
    Run Keyword If  ${is_requerant_defined} == True  Ajouter le demandeur  requerant  ${autres_demandeurs_values.requerant}
    Run Keyword If  ${is_avocat_principal_defined} == True  Ajouter le demandeur  avocat_principal  ${autres_demandeurs_values.avocat_principal}
    Run Keyword If  ${is_avocat_defined} == True  Ajouter le demandeur  avocat  ${autres_demandeurs_values.avocat}
    Run Keyword If  ${is_bailleur_principal_defined} == True  Ajouter le demandeur  bailleur_principal  ${autres_demandeurs_values.bailleur_principal}
    Run Keyword If  ${is_bailleur_defined} == True  Ajouter le demandeur  bailleur  ${autres_demandeurs_values.bailleur}
    Run Keyword If  ${is_architecte_legi_connexe_defined} == True  Ajouter le demandeur  architecte_lc  ${autres_demandeurs_values.architecte_lc}
    Run Keyword If  ${is_concepteur_paysagiste_defined} == True  Ajouter le demandeur  paysagiste  ${autres_demandeurs_values.paysagiste}


Validation du formulaire de la demande
    # On valide
    Click On Submit Button
    # Vérification du message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur


Ajouter la demande sur existant
    [Arguments]  ${libelle_di}  ${demande_values}

    # On ouvre le menu autre dossier
    Depuis le contexte de demande sur existant via l'URL  ${libelle_di}
    ${libelle_di} =  Ajouter la demande et récupérer le numéro de DI  ${demande_values}
    # On retourne le numéro du nouveau DI créé
    [Return]  ${libelle_di}

Ajouter la demande sur existant depuis le tableau de bord
    [Arguments]  ${libelle_di}  ${demande_values}

    # On ouvre le menu autre dossier
    Depuis le contexte de demande sur existant via le tableau de bord  ${libelle_di}
    ${libelle_di} =  Ajouter la demande et récupérer le numéro de DI  ${demande_values}
    # On retourne le numéro du nouveau DI créé
    [Return]  ${libelle_di}

Ajouter la demande sur existant depuis le menu
    [Arguments]  ${libelle_di}  ${demande_values}

    # On ouvre le menu autre dossier
    Depuis le contexte de demande sur existant via le menu  ${libelle_di}
    ${libelle_di} =  Ajouter la demande et récupérer le numéro de DI  ${demande_values}
    # On retourne le numéro du nouveau DI créé
    [Return]  ${libelle_di}

Ajouter la demande sur existant sans création de dossier
    [Arguments]  ${libelle_di}  ${demande_values}

    # On ouvre le menu autre dossier
    Depuis le contexte de demande sur existant via l'URL  ${libelle_di}
    Ajouter la demande  ${demande_values}
    Validation du formulaire de la demande

Ajouter la demande sur dossier en cours
    [Arguments]  ${libelle_di}  ${demande_values}  ${petitionnaire_values}=

    Depuis le contexte de demande sur dossier en cours via l'URL  ${libelle_di}
    ${libelle_di} =  Ajouter la demande et récupérer le numéro de DI  ${demande_values}  ${petitionnaire_values}

    # On retourne le numéro du nouveau DI créé
    [Return]  ${libelle_di}

Ajouter la demande sur dossier en cours depuis le menu
    [Arguments]  ${libelle_di}  ${demande_values}  ${petitionnaire_values}=

    # On ouvre le menu dossier en cours
    Depuis le contexte de demande sur dossier en cours via le menu  ${libelle_di}
    ${libelle_di} =  Ajouter la demande et récupérer le numéro de DI  ${demande_values}  ${petitionnaire_values}
    # On retourne le numéro du nouveau DI créé
    [Return]  ${libelle_di}

Ajouter la demande sur dossier en cours sans création de dossier
    [Arguments]  ${libelle_di}  ${demande_values}

    # On ouvre le menu dossier en cours
    Depuis le contexte de demande sur dossier en cours via l'URL  ${libelle_di}
    Ajouter la demande  ${demande_values}
    Validation du formulaire de la demande

Depuis le contexte de nouvelle demande via l'URL
    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=demande_nouveau_dossier&action=0

Depuis le contexte de nouvelle demande via le menu
    Go To Dashboard
    Go To Submenu In Menu  guichet_unique  nouveau-dossier

Depuis le contexte de nouvelle demande via le tableau de bord
    Go To Dashboard
    Click On Link  Cliquer ici pour saisir une nouvelle demande concernant le dépôt d'un nouveau dossier

Depuis le contexte de nouvelle demande contentieux via l'URL
    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=demande_nouveau_dossier_contentieux&action=0

Depuis le contexte de demande sur existant via l'URL
    [Arguments]  ${libelle_di}
    ${libelle_di} =  Sans Espace  ${libelle_di}
    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=demande_autre_dossier&action=0&idx_dossier=${libelle_di}

Depuis le contexte de demande sur existant via le tableau de bord
    [Arguments]    ${libelle_di}
    Go To Dashboard
    Click On Link  Cliquer ici pour saisir une nouvelle demande concernant un dossier en cours ou une autorisation existante
    Rechercher et créer une demande sur dossier existant  ${libelle_di}

Depuis le contexte de demande sur existant via le menu
    [Arguments]    ${libelle_di}
    Go To Dashboard
    Go To Submenu In Menu  guichet_unique  autre-dossier
    Rechercher et créer une demande sur dossier existant  ${libelle_di}

Depuis le contexte de demande sur dossier en cours via l'URL
    [Arguments]    ${libelle_di}
    ${libelle_di} =  Sans Espace  ${libelle_di}
    Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=demande_dossier_encours&action=0&idx_dossier=${libelle_di}

Depuis le contexte de demande sur dossier en cours via le menu
    [Arguments]    ${libelle_di}
    Go To Dashboard
    Go To Submenu In Menu  guichet_unique  dossier-existant
    ${libelle_di} =  Sans Espace  ${libelle_di}
    Wait Until Page Contains Element  css=#adv-search-classic-fields input
    Input Text  css=#adv-search-classic-fields input  ${libelle_di}
    Click Element  adv-search-submit
    Wait Until Page Contains Element  css=#action-tab-demande_dossier_encours-left-consulter-${libelle_di}
    Click Element  css=#action-tab-demande_dossier_encours-left-consulter-${libelle_di}

Rechercher et créer une demande sur dossier existant
    [Arguments]    ${libelle_di}
    ${libelle_di} =  Sans Espace  ${libelle_di}
    Wait Until Page Contains Element  css=#adv-search-classic-fields input
    Input Text  css=#adv-search-classic-fields input  ${libelle_di}
    Click Element  adv-search-submit
    Wait Until Page Contains Element  css=#action-tab-demande_autre_dossier-left-consulter-${libelle_di}
    Click Element  css=#action-tab-demande_autre_dossier-left-consulter-${libelle_di}

Saisir la demande
    [Arguments]    ${demande_values}

    # Attend que le formulaire de saisie de la demande soit affiché
    Wait Until Page Contains Element  css=#lib-dossier_autorisation_type_detaille

    # On sélectionne le type de dossier d'autorisation détaillé
    Si "dossier_autorisation_type_detaille" existe dans "${demande_values}" on execute "Select From List By Label" dans le formulaire

    # On sélectionne le type de demande
    ${present}=  Run Keyword And Return Status    Element Should Be Visible   id=demande_type
    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${demande_values}    demande_type
    Run Keyword If    ${exist} == True and ${present} == True    Si "demande_type" existe dans "\${demande_values}" on execute "Select From List By Label" dans le formulaire

    # Gestion du cas particulier des dossiers Recours
    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${demande_values}    autorisation_contestee
    Run Keyword If  ${exist} == True  Wait Until Element Is Visible  autorisation_contestee
    Run Keyword If  ${exist} == True  Input Text  autorisation_contestee  ${demande_values.autorisation_contestee}
    Run Keyword If  ${exist} == True  Click Element  autorisation_contestee_search_button

    ${commune_specified} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${demande_values}  commune
    ${commune_text} =  Run Keyword If  ${commune_specified} == True  Get From Dictionary  ${demande_values}  commune
    Run Keyword If  ${commune_specified} == True  Wait Until Element Is Visible  css=#autocomplete-commune-search
    Run Keyword If  ${commune_specified} == True  Input text until text is correct  css=#autocomplete-commune-search  ${commune_text}
    Run Keyword If  ${commune_specified} == True  Wait Until Element Is Visible  css=ul.ui-autocomplete
    Run Keyword If  ${commune_specified} == True  Click Element Until No More Element  css=ul.ui-autocomplete li.ui-menu-item a

    Wait Until Element Is Visible  date_demande
    Sleep  0.2
    # On saisit la date
    Si "date_demande" existe dans "${demande_values}" on execute "Input Text" dans le formulaire
    # On sélectionne la collectivité si renseignée
    Si "om_collectivite" existe dans "${demande_values}" on execute "Select From List By Label" dans le formulaire
    # localite du terrain
    Si "terrain_adresse_voie_numero" existe dans "${demande_values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_voie" existe dans "${demande_values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_lieu_dit" existe dans "${demande_values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_code_postal" existe dans "${demande_values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_localite" existe dans "${demande_values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_bp" existe dans "${demande_values}" on execute "Input Text" dans le formulaire
    Si "terrain_adresse_cedex" existe dans "${demande_values}" on execute "Input Text" dans le formulaire
    Si "terrain_superficie" existe dans "${demande_values}" on execute "Input Text" dans le formulaire
    Si "terrain_references_cadastrales" existe dans "${demande_values}" on execute "Saisir les références cadastrales"
    Si "terrain_references_cadastrales_ligne" existe dans "${demande_values}" on execute "Saisir les références cadastrales par ligne"
    Si "parcelle_temporaire" existe dans "${demande_values}" on execute "Set Checkbox" dans le formulaire
    Si "depot_electronique" existe dans "${demande_values}" on execute "Saisir un dépôt électronique"
    # On sélectionne l'affecation automatique si renseignée
    Si "affectation_automatique" existe dans "${demande_values}" on execute "Select From List By Label" dans le formulaire

    ${num_dossier_complet_specified} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${demande_values}  num_dossier_complet
    ${num_dossier_complet_text} =  Run Keyword If  ${num_dossier_complet_specified} == True  Get From Dictionary  ${demande_values}  num_dossier_complet
    Run Keyword If  ${num_dossier_complet_specified} == True  Click Element  css=#num_doss_manuel
    Run Keyword If  ${num_dossier_complet_specified} == True  Wait Until Element Is Visible  css=#num_doss_complet
    Run Keyword If  ${num_dossier_complet_specified} == True  Input text  css=#num_doss_complet  ${num_dossier_complet_text}

Saisir un dépot électronique
    [Arguments]    ${depot_electronique}
    [Documentation]  Permet de signaler que la demande est issue d'un dépôt électronique
    ...  .

    # Mise du champ depot_electronique hidden à true ou false s'il est renseigné
    Input Text  css=input#depot_electronique.champFormulaire  ${depot_electronique}

Saisir les références cadastrales
    [Arguments]    ${references_cadastrales}
    [Documentation]  Permet de saisir un nombre "infini" de références cadastrales sur une
    ...  seule ligne. Ce mot clé recoit une liste de références cadastrales avec un élément
    ...  par ligne, ex: @{ref_cad} =  Create List  806  AB  01  A  50
    ...  Ce mot-clé clique sur le bouton "ajouter d'autres champs" autant de fois que
    ...  nécessaire.

    # Initialisation du compteur à 1
    ${i} =  Set Variable  1
    ${modulo} =  Set Variable  0
    :FOR  ${value}  IN  @{references_cadastrales}
    \    Run Keyword If  ${i} > 3 and (${i}-3)%2 == 1  Click Element  moreFieldReferenceCadastrale0
    \    Input Text  css=.reference_cadastrale_custom_fields .reference_cadastrale_custom_field:nth-child(${i})  ${value}
    \    ${i}  Evaluate  ${i}+1

Saisir les références cadastrales par ligne
    [Arguments]    ${references_cadastrales}
    [Documentation]  Permet de saisir un nombre "infini" de références cadastrales sur une
    ...  seule ligne. Ce mot clé recoit une liste de références cadastrales avec un élément
    ...  par ligne, ex: @{ref_cad} =  Create List  806  AB  01  809  BB  02
    ...  Ce mot-clé clique sur le bouton "ajouter d'autres champs" autant de fois que
    ...  nécessaire.

    # Initialisation du compteur à 1
    ${i} =  Set Variable  1
    ${cpt_nb_value} =  Set Variable  1
    ${modulo} =  Set Variable  0
    ${list_nb_value}=  Get Length  ${references_cadastrales}
    :FOR  ${value}  IN  @{references_cadastrales}
    \    Run Keyword If  ${list_nb_value} > 3 and ${cpt_nb_value}==3  Click Element  morelineReferenceCadastrale
    \    ${cpt_nb_value}=  Run Keyword If  ${list_nb_value} > 3 and ${cpt_nb_value}<3  Evaluate  ${cpt_nb_value}+1
    \    ...  ELSE         Run Keyword If  ${list_nb_value} > 3 and ${cpt_nb_value}==3  Set Variable  1

    :FOR  ${value}  IN  @{references_cadastrales}
    \    Input Text  css=.reference_cadastrale_custom_fields .reference_cadastrale_custom_field:nth-of-type(${i})  ${value}
    \    ${i}  Evaluate  ${i}+1

Ajouter le demandeur
    [Arguments]  ${type_demandeur}  ${demandeur_values}

    # Suppression du demandeur déjà existant
    ${exist} =  Run Keyword And Return Status  Dictionary Should Contain Key  ${demandeur_values}  delete_demandeur
    ${demandeur_id} =  Run Keyword If  ${exist} == True  Get Value  css=input[name='${type_demandeur}[]']
    Run Keyword If  ${exist} == True  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#${type_demandeur}_${demandeur_id} a span.demandeur_del
    # On clique sur le bouton
    Click Element Until New Element  add_${type_demandeur}  css=.ui-widget-overlay
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur
    ${type_demandeur} =  STR_REPLACE  _principal  ${EMPTY}  ${type_demandeur}
    # On remplit le formulaire
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Saisir le demandeur  ${type_demandeur}  ${demandeur_values}
    # Clic sur le bouton ajouter
    Click Element Until No More Element  css=#sousform-${type_demandeur} input[value=Ajouter]
    # Vérification du message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain In Subform  Vos modifications ont bien été enregistrées.
    # On ferme l'overlay
    Click Element Until No More Element  css=#sousform-${type_demandeur} a.retour

Ajouter le pétitionnaire fréquent depuis le menu
    [Documentation]  Permet d'ajouter un pétitionnaire fréquent depuis le menu.
    [Arguments]  ${petitionnaire_values}

    Depuis le listing  petitionnaire_frequent
    # On clique sur le bouton ajouter
    Click On Add Button
    Saisir le pétitionnaire fréquent  ${petitionnaire_values}
    # On valide
    Click On Submit Button
    # Vérification du message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Saisir le pétitionnaire fréquent
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    # XXX Problématique RF : Le champ om_collectivite ne doit pas être sélectionné en dernier
    # sinon le bouton de validation n'arrive pas à être cliqué.
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    #
    Si "type_demandeur" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "qualite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "particulier_nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "particulier_prenom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "particulier_date_naissance" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "particulier_commune_naissance" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "particulier_departement_naissance" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "particulier_pays_naissance" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_denomination" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_raison_sociale" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_siret" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_categorie_juridique" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_nom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_prenom" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "numero" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "voie" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "complement" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "lieu_dit" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "localite" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "code_postal" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "bp" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "cedex" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "pays" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "division_territoriale" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "telephone_fixe" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "telephone_mobile" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "indicatif" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "courriel" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "notification" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "frequent" existe dans "${values}" on execute "Set Checkbox" dans le formulaire
    Si "particulier_civilite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "personne_morale_civilite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "fax" existe dans "${values}" on execute "Input Text" dans le formulaire


Saisir le demandeur
    [Arguments]  ${type_demandeur}  ${demandeur_values}

    # XXX Problématique RF : Le champ om_collectivite ne doit pas être sélectionné en dernier
    # sinon le bouton de validation n'arrive pas à être cliqué.
    Si "om_collectivite" existe dans "${demandeur_values}" on execute "Select From List By Label" dans "${type_demandeur}"
    #
    Si "qualite" existe dans "${demandeur_values}" on execute "Select From List By Label" dans "${type_demandeur}"
    Si "particulier_civilite" existe dans "${demandeur_values}" on execute "Select From List By Label" dans "${type_demandeur}"
    Si "particulier_nom" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "particulier_prenom" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "particulier_date_naissance" existe dans "${demandeur_values}" on execute "Input Datepicker From Css Selector" dans "${type_demandeur}"
    Si "particulier_commune_naissance" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "particulier_departement_naissance" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "particulier_pays_naissance" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "personne_morale_denomination" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "personne_morale_raison_sociale" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "personne_morale_civilite" existe dans "${demandeur_values}" on execute "Select From List By Label" dans "${type_demandeur}"
    Si "personne_morale_nom" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "personne_morale_prenom" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "personne_morale_siret" existe dans "${demandeur_values}" on execute "Input Text" dans le formulaire
    Si "personne_morale_categorie_juridique" existe dans "${demandeur_values}" on execute "Input Text" dans le formulaire
    Si "numero" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "voie" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "complement" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "lieu_dit" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "localite" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "code_postal" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "bp" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "cedex" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "pays" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "division_territoriale" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "telephone_fixe" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "telephone_mobile" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "indicatif" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "courriel" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "fax" existe dans "${demandeur_values}" on execute "Input Text" dans "${type_demandeur}"
    Si "frequent" existe dans "${demandeur_values}" on execute "Set Checkbox" dans "${type_demandeur}"
    Si "notification" existe dans "${demandeur_values}" on execute "Set Checkbox" dans "${type_demandeur}"


Ajouter la demande par WS
    [Documentation]  Ajoute une demande avec les même parametres que Ajouter la nouvelle demande
    [Arguments]  ${demande_values}  ${petitionnaire_values}=  ${autres_demandeurs_values}=

    ${json_data} =  Create Dictionary
    ...  demande=${demande_values}
    ...  petitionnaire_principal=${petitionnaire_values}
    ...  autre_demandeurs=${autres_demandeurs_values}

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${demande_values}    demande_type
    Run Keyword If  '${exist}' != 'True'  Fail  Mauvais paramètres passés au mot-clé "Ajouter la demande par WS".

    ${exist} =    Run Keyword And Return Status    Dictionary Should Contain Key    ${demande_values}    dossier_instruction
    Run Keyword If    ${exist} == True    Get Value From Dictionary  ${demande_values}  dossier_instruction
    Run Keyword If    ${exist} == True    Set to dictionary  ${json_data}  dossier_instruction  ${value}

    ${session} =  Catenate  http${PROJECT_NAME}
    Create Session  ${session}  ${PROJECT_URL}tests_services/rest_entry.php
    ${headers} =  Create Dictionary  Content-Type=application/json

    # Convertion de dictionnaire enshaine JSON
    ${json_string}=  evaluate  json.dumps(${json_data})  json

    ${resp}  Post Request  ${session}  /demande  data=${json_string}  headers=${headers}

    # On verifie s'il y a eu une erreur
    ${status} =  Run Keyword And Return Status  To Json  ${resp.content}
    Run Keyword If  '${status}' != 'True'  Log  ${resp.content}  WARN

    # Convertion de chaine JSON en dict python
    ${resp} =  To Json  ${resp.content}

    Run Keyword If  '${resp["http_code"]}' != '200'  Log  ${resp["message"]}  WARN
    Should be Equal  '${resp["http_code"]}'  '200'

    ${libelle_di} =  Set Variable  ${resp["message"]["dossier"]}

    [Return]  ${libelle_di}


Ajouter la nouvelle demande depuis le menu sans validation du formulaire
    [Arguments]  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}=

    # On ouvre le menu nouveau dossier
    Depuis le contexte de nouvelle demande via le menu
    ${libelle_di} =  Ajouter la demande  ${demande_values}  ${petitionnaire_values}  ${autres_demandeurs_values}
