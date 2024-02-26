*** Settings ***
Documentation  Gestion des messages.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Constitution du jeu de données

    [Documentation]  L'objet de ce 'Test Case' est de constituer un jeu de
    ...  données cohérent pour les scénarios fonctionnels qui suivent.

    # Date du jour au format : JJ/MM/AAAA
    ${date_ddmmyyyy} =  Date du jour FR
    Set Suite Variable  ${date_ddmmyyyy}

    # On active l'option pour que le test standalone fonctionne à l'identique
    # que s'il était exécuté avec tous les autres
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_afficher_division
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    &{om_param} =  Create Dictionary
    ...  libelle=option_notification_piece_numerisee
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}


Gestion des retours de messages

    [Documentation]

    ##
    ## Constitution du jeu de données
    ##
    ## On cré deux nouvelles collectivités pour être sûr du nombre
    ## de retours de messages à vérifier dans les widgets et tableaux
    ##
    #
    ${collectivite_a} =  Set Variable  SAMBALPUR
    ${collectivite_b} =  Set Variable  DRIEKAPELLEN
    #
    ${utilisateur_nom_01} =  Set Variable  Hermione JUAREZ
    ${utilisateur_login_01} =  Set Variable  hjuarez
    ${utilisateur_nom_02} =  Set Variable  Jorden BOWERS
    ${utilisateur_login_02} =  Set Variable  jbowers
    ${utilisateur_nom_03} =  Set Variable  Kiara COLE
    ${utilisateur_login_03} =  Set Variable  kcole
    ${utilisateur_nom_04} =  Set Variable  Elizabeth ORTIZ
    ${utilisateur_login_04} =  Set Variable  eortiz
    ${utilisateur_nom_05} =  Set Variable  Cyrille LUCE
    ${utilisateur_login_05} =  Set Variable  cluce
    ${utilisateur_nom_06} =  Set Variable  Irène LOUNO
    ${utilisateur_login_06} =  Set Variable  ilouno
    ${utilisateur_nom_07} =  Set Variable  Virginie PIRES
    ${utilisateur_login_07} =  Set Variable  vpires
    ${utilisateur_nom_08} =  Set Variable  Nouel BRASSEUR
    ${utilisateur_login_08} =  Set Variable  nbrasseur
    ${utilisateur_nom_09} =  Set Variable  Joseph Marcoux
    ${utilisateur_login_09} =  Set Variable  jmarcoux
    ${utilisateur_division_09} =  Set Variable  subdivision YY
    ${instructeur_secondaire_login} =  Set Variable  instructeur_secondaire_mr

    Depuis la page d'accueil  admin  admin

    # Le widget des retours de message ne doit avoir aucun argument
    Insérer les paramètres suivants dans le widget
    ...  ${EMPTY}
    ...  4
    # Ajoute le widget des retours de message au profil instructeur polyvalent commune
    # On cherche a tester le widget dans le cas ou un instrcuteur ajoute une pièce au dossier
    # Or les profils INSTRUCTEUR ne peuvent pas ajouter de pièce. Ce widget est donc associé
    # a ce profil pour pouvoir tester ce cas sans passer par le profil INSTRUCTEUR.
    Ajouter le widget au tableau de bord  INSTRUCTEUR POLYVALENT COMMUNE  Mes messages 

    #
    Ajouter la collectivité depuis le menu  ${collectivite_a}  mono
    Ajouter la collectivité depuis le menu  ${collectivite_b}  mono
    #
    Ajouter la direction depuis le menu  C-T-X  Direction C-T-X  null  Chef C-T-X  null  null  DRIEKAPELLEN
    #
    Ajouter la division depuis le menu  C-T-X  subdivision C-T-X  null  Chef C-T-X  null  null  Direction C-T-X
    #
    Ajouter l'utilisateur  ${utilisateur_nom_01}  nospam@openmairie.org  ${utilisateur_login_01}  ${utilisateur_login_01}  INSTRUCTEUR  ${collectivite_a}
    Ajouter l'utilisateur  ${utilisateur_nom_02}  nospam@openmairie.org  ${utilisateur_login_02}  ${utilisateur_login_02}  INSTRUCTEUR  ${collectivite_a}
    Ajouter l'utilisateur  ${utilisateur_nom_03}  nospam@openmairie.org  ${utilisateur_login_03}  ${utilisateur_login_03}  INSTRUCTEUR  ${collectivite_a}
    Ajouter l'utilisateur  ${utilisateur_nom_04}  nospam@openmairie.org  ${utilisateur_login_04}  ${utilisateur_login_04}  INSTRUCTEUR  ${collectivite_b}
    Ajouter l'utilisateur  ${utilisateur_nom_05}  nospam@openmairie.org  ${utilisateur_login_05}  ${utilisateur_login_05}  JURISTE  ${collectivite_b}
    Ajouter l'utilisateur  ${utilisateur_nom_06}  nospam@openmairie.org  ${utilisateur_login_06}  ${utilisateur_login_06}  TECHNICIEN  ${collectivite_b}
    Ajouter l'utilisateur  ${utilisateur_nom_07}  nospam@openmairie.org  ${utilisateur_login_07}  ${utilisateur_login_07}  ASSISTANTE  ${collectivite_b}
    Ajouter l'utilisateur  ${utilisateur_nom_08}  nospam@openmairie.org  ${utilisateur_login_08}  ${utilisateur_login_08}  RESPONSABLE DIVISION INFRACTION  ${collectivite_b}
    Ajouter l'utilisateur  ${instructeur_secondaire_login}  nospam@openmairie.org  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}  INSTRUCTEUR  ${collectivite_a}

    # On ajoute un utilisateur/instructeur sur la collectivité de niveau 2
    # Cet instructeur doit pouvoir ajouter des pièces au dossier on lui donne donc le profil
    # INSTRUCTEUR POLYVALENT COMMUNE
    Ajouter l'utilisateur  ${utilisateur_nom_09}  nospam@openmairie.org  ${utilisateur_login_09}  ${utilisateur_login_09}  INSTRUCTEUR POLYVALENT COMMUNE  agglo


    Ajouter la direction depuis le menu  AGL  Direction AGGLO  null  Chef AGL  null  null  agglo
    Ajouter la division depuis le menu  YY  ${utilisateur_division_09}  null  Afrodille Boulanger  null  null  Direction AGGLO
    Ajouter la direction depuis le menu  SBP  Direction SBP  null  Chef SBP  null  null  ${collectivite_a}
    Ajouter la division depuis le menu  SBPH  subdivision SBPH  null  Chef SBP  null  null  Direction SBP
    Ajouter la division depuis le menu  SBPJ  subdivision SBPJ  null  Chef SBP  null  null  Direction SBP
    Ajouter la direction depuis le menu  DKP  Direction DKP  null  Chef DKP  null  null  ${collectivite_b}
    Ajouter la division depuis le menu  DKP  subdivision DKP  null  Chef DKP  null  null  Direction DKP
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_05}  subdivision C-T-X  juriste  ${utilisateur_nom_05}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_06}  subdivision C-T-X  technicien  ${utilisateur_nom_06}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_08}  subdivision C-T-X  technicien  ${utilisateur_nom_08}
    #
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_01}  subdivision SBPH  instructeur  ${utilisateur_nom_01}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_02}  subdivision SBPH  instructeur  ${utilisateur_nom_02}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_03}  subdivision SBPJ  instructeur  ${utilisateur_nom_03}
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_04}  subdivision DKP  instructeur  ${utilisateur_nom_04}
    #
    Ajouter l'instructeur depuis le menu  ${utilisateur_nom_09}  ${utilisateur_division_09}  instructeur  ${utilisateur_nom_09}
    # Ajout de l'instructeur qui servira d'instructeur secondaire
    Ajouter l'instructeur depuis le menu  ${instructeur_secondaire_login}  subdivision SBPH  instructeur  ${instructeur_secondaire_login}
    #
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_01} (SBPH)
    ...  instructeur_2=${instructeur_secondaire_login} (SBPH)
    ...  om_collectivite=${collectivite_a}
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_02} (SBPH)
    ...  om_collectivite=${collectivite_a}
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_03} (SBPJ)
    ...  om_collectivite=${collectivite_a}
    ...  dossier_autorisation_type_detaille=Permis de démolir
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_04} (DKP)
    ...  om_collectivite=${collectivite_b}
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_05} (C-T-X)
    ...  instructeur_2=${utilisateur_nom_06} (C-T-X)
    ...  om_collectivite=${collectivite_b}
    ...  dossier_autorisation_type_detaille=Infraction
    Ajouter l'affectation depuis le menu  ${args_affectation}
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_05} (C-T-X)
    ...  om_collectivite=${collectivite_b}
    ...  dossier_autorisation_type_detaille=Recours gracieux
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # DI n°1 : Permis de démolir dans Collectivité A (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_03}' (${utilisateur_login_03})
    # => Division 'J'
    #
    &{args_petitionnaire_01} =  Create Dictionary
    ...  particulier_nom=DUPONT
    ...  particulier_prenom=Jacques
    ...  om_collectivite=${collectivite_a}
    #
    &{args_demande_01} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=${collectivite_a}
    #
    ${di_01} =  Ajouter la demande par WS  ${args_demande_01}  ${args_petitionnaire_01}

    # DI n°2 : Permis de construire pour une maison individuelle et / ou ses annexes dans Collectivité A (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_01}' (${utilisateur_login_01})
    # => Division 'H'
    #
    &{args_petitionnaire_02} =  Create Dictionary
    ...  particulier_nom=VACHIER
    ...  particulier_prenom=Arthur
    ...  om_collectivite=${collectivite_a}
    #
    &{args_demande_02} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=${collectivite_a}
    #
    ${di_02} =  Ajouter la demande par WS  ${args_demande_02}  ${args_petitionnaire_02}

    # DI n°3 : Permis de construire comprenant ou non des démolitions dans Collectivité A (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_02}' (${utilisateur_login_02})
    # => Division 'H'
    #
    &{args_petitionnaire_03} =  Create Dictionary
    ...  particulier_nom=BRAY
    ...  particulier_prenom=Guy
    ...  om_collectivite=${collectivite_a}
    #
    &{args_demande_03} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire comprenant ou non des démolitions
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=${collectivite_a}
    #
    ${di_03} =  Ajouter la demande par WS  ${args_demande_03}  ${args_petitionnaire_03}

    # DI n°4 : Permis de construire pour une maison individuelle et / ou ses annexes dans Collectivité B (niveau mono)
    # => Affecté à l'instructeur '${utilisateur_nom_04}' (${utilisateur_login_04})
    # => Division 'H'
    #
    &{args_petitionnaire_04} =  Create Dictionary
    ...  particulier_nom=BOULAGE
    ...  particulier_prenom=Damien
    ...  om_collectivite=${collectivite_b}
    #
    &{args_demande_04} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=12/04/2015
    ...  om_collectivite=${collectivite_b}
    #
    ${di_04} =  Ajouter la demande par WS  ${args_demande_04}  ${args_petitionnaire_04}


    # DI n°5 : Infraction
    # => Affecté au juriste '${utilisateur_nom_05}' (${utilisateur_login_05})
    # => Affecté au technicien '${utilisateur_nom_06}' (${utilisateur_login_06})
    # => Division 'C-T-X'
    #
    &{args_contrevenant} =  Create Dictionary
    ...  particulier_nom=DUPIN
    ...  particulier_prenom=Romain
    ...  om_collectivite=${collectivite_b}
    &{args_plaignant} =  Create Dictionary
    ...  particulier_nom=MUREAUX
    ...  particulier_prenom=Ludovic
    ...  om_collectivite=${collectivite_b}
    &{args_autres_demandeurs} =  Create Dictionary
    ...  contrevenant_principal=${args_contrevenant}
    ...  plaignant_principal=${args_plaignant}
    &{args_demande_05} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Infraction
    ...  date_demande=12/04/2015
    ...  demande_type=Dépôt Initial IN
    ...  om_collectivite=${collectivite_b}
    ${di_05} =  Ajouter la demande par WS  ${args_demande_05}  ${NULL}  ${args_autres_demandeurs}

    # DI n°6 : Recours
    # => Affecté au juriste '${utilisateur_nom_05}' (${utilisateur_login_05})
    # => Division 'C-T-X'
    #
    &{args_demande_06} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Recours gracieux
    ...  demande_type=Dépôt Initial REG
    ...  date_demande=12/04/2015
    ...  autorisation_contestee=${di_04}
    ...  om_collectivite=${collectivite_b}
    ${di_06} =  Ajouter la demande par WS  ${args_demande_06}  ${EMPTY}

    # On marque comme lu le message créé pour notifier de l'autorisation
    # contestée afin d'éviter de fausser les tests
    Marquer comme lu le message dans le dossier d'instruction  ${di_04}  Autorisation contestée

    # On ajoute un document numérisé par DI
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=autres pièces composant le dossier (A0)
    Ajouter une pièce depuis le dossier d'instruction  ${di_01}  ${document_numerise_values}
    Ajouter une pièce depuis le dossier d'instruction  ${di_02}  ${document_numerise_values}
    Ajouter une pièce depuis le dossier d'instruction  ${di_03}  ${document_numerise_values}
    Ajouter une pièce depuis le dossier d'instruction  ${di_04}  ${document_numerise_values}
    Ajouter une pièce depuis le dossier contentieux  infraction  ${di_05}  ${document_numerise_values}
    Ajouter une pièce depuis le dossier contentieux  recours  ${di_06}  ${document_numerise_values}

    ##
    ## Cas d'usage
    ##
    ##
    ##

    #
    ${widget_id} =  Set Variable  widget_4

    # On vérifie qu'on a la collonne collectivité dans le listing tous les messages
    Go To Submenu In Menu  instruction  messages_tous_retours
    Page Title Should Be  Instruction > Messages > Tous Les Messages
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours situés dans toutes les collectivités.
    Element Should Contain  css=#tab-messages_tous_retours table thead  instructeur
    Element Should Contain  css=#tab-messages_tous_retours table thead  division
    Element Should Contain  css=#tab-messages_tous_retours table thead  collectivité
    # On va sur le listing 'Tous les messages'
    # Il doit contenir des retours des deux collectivités
    Input Text    css=#tab-messages_tous_retours #adv-search-classic-fields input    ${collectivite_a}
    Click On Search Button
    Element Should Contain  css=#tab-messages_tous_retours table  ${collectivite_a}
    # On passe par le tableau de bord afin de fermer le menu instruction.
    # Sinon, vu que la sous-rubrique du menu contentieux a le même nom,
    # le mot-clef échoue.
    Go To Dashboard
    Go To Submenu In Menu  contentieux  messages_contentieux_tous_retours
    Input Text    css=#tab-messages_contentieux_tous_retours #adv-search-classic-fields input    ${collectivite_b}
    Click On Search Button
    Element Should Contain  css=#tab-messages_contentieux_tous_retours table  ${collectivite_b}

    # Filtre sur l'instructeur
    # On se connecte en tant que "${utilisateur_login_01}" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    # On vérifie que les messages apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  1
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Mes retours'
    # Il ne doit contenir qu'un seul retour
    Submenu In Menu Should Be Selected  instruction  messages_mes_retours
    Page Title Should Be  Instruction > Messages > Mes Messages
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours dont je suis l'instructeur ou dont le destinataire est 'commune'.
    Element Should Contain  css=#tab-messages_mes_retours .pagination-text  1 - 1 enregistrement(s) sur 1
    # On va sur le listing 'Messages de ma division'
    # Il doit contenir deux retours
    Go To Submenu In Menu  instruction  messages_retours_ma_division
    Page Title Should Be  Instruction > Messages > Messages De Ma Division
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours situés dans ma division ou dont le destinataire est 'commune'.
    Element Should Contain  css=#tab-messages_retours_ma_division .pagination-text  1 - 2 enregistrement(s) sur 2
    Element Should Contain  css=#tab-messages_retours_ma_division table  ${utilisateur_nom_02}
    # On va sur le listing 'Tous les messages'
    # Il doit contenir trois retours
    Go To Submenu In Menu  instruction  messages_tous_retours
    Page Title Should Be  Instruction > Messages > Tous Les Messages
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours situés dans ma collectivité.
    Element Should Contain  css=#tab-messages_tous_retours .pagination-text  1 - 3 enregistrement(s) sur 3

    # L'instructeur secondaire ne dois pas avoir de résultats sur son tableau de bord
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Element Should Contain  css=#${widget_id} .widget-content-wrapper  Aucun message non lu.

    # Filtre sur l'instructeur secondaire
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur_secondaire
    ...  4

    # On vérifie que les messages apparaissent bien sur le tableau de bord de l'instructeur secondaire
    Depuis la page d'accueil  ${instructeur_secondaire_login}  ${instructeur_secondaire_login}
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  1
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Mes retours'
    # Il ne doit contenir qu'un seul retour
    Submenu In Menu Should Be Selected  instruction  messages_mes_retours
    Page Title Should Be  Instruction > Messages > Mes Messages
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours.
    Element Should Contain  css=#tab-messages_mes_retours .pagination-text  1 - 1 enregistrement(s) sur 1

    # L'instructeur ne dois pas avoir de résultats sur son tableau de bord
    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    Element Should Contain  css=#${widget_id} .widget-content-wrapper  Aucun message non lu.


    # Filtre sur la division
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=division
    ...  4

    # On se connecte en tant que "${utilisateur_login_01}" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    # On vérifie que les messages apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  2
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Messages de ma division'
    # Il doit contenir deux retours
    Submenu In Menu Should Be Selected  instruction  messages_retours_ma_division
    Page Title Should Be  Instruction > Messages > Messages De Ma Division
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours situés dans ma division ou dont le destinataire est 'commune'.
    Element Should Contain  css=#tab-messages_retours_ma_division .pagination-text  1 - 2 enregistrement(s) sur 2

    # Pas de filtre actif
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=aucun
    ...  4

    # On se connecte en tant que "${utilisateur_login_01}" (Profil 'INSTRUCTEUR')
    Depuis la page d'accueil  ${utilisateur_login_01}  ${utilisateur_login_01}
    # On vérifie que les messages apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  3
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # Le lien Voir + nous amène sur le listing 'Tous les messages'
    # Il doit contenir trois retours
    Submenu In Menu Should Be Selected  instruction  messages_tous_retours
    Page Title Should Be  Instruction > Messages > Tous Les Messages
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours situés dans ma collectivité.
    Element Should Contain  css=#tab-messages_tous_retours .pagination-text  1 - 3 enregistrement(s) sur 3

    # Filtre sur l'instructeur
    Depuis la page d'accueil  admin  admin
    Insérer les paramètres suivants dans le widget
    ...  filtre=instructeur
    ...  4

    # On se connecte en tant que Profil 'INSTRUCTEUR'
    Depuis la page d'accueil  ${utilisateur_login_04}  ${utilisateur_login_04}
    # On vérifie que les messages apparaissent bien sur le tableau de bord de l'instructeur
    Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  1
    # On clique sur le lien "Voir +" du widget
    Click Element  css=#${widget_id} .widget-footer a
    # On clique sur le lien du dossier
    Click Link  ${di_04}
    #
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#sousform-dossier_message #dossier_message
    #
    Page Title Should Contain  ${di_04}
    Page Title Should Contain  BOULAGE DAMIEN

    #
    Portlet Action Should Be In SubForm  dossier_message  marquer_comme_lu
    #
    Click On SubForm Portlet Action  dossier_message  marquer_comme_lu
    #
    Valid Message Should Be In Subform  Le message a été marqué comme lu.

    #
    Depuis la page d'accueil  ${utilisateur_login_04}  ${utilisateur_login_04}
    #
    # On vérifie que lorsqu'il n'y a aucun message, une information dans le widget 'Messages'
    # l'indique et que le lien Voir + n'est pas présent
    #
    Element Should Contain  css=#${widget_id} .widget-content-wrapper  Aucun message non lu.
    Element Should Not Contain  css=#${widget_id}  Voir +

    #
    # On clique sur les trois listings liés pour vérifier qu'il n'y a aucun résultat
    #
    Go To Submenu In Menu  instruction  messages_mes_retours
    Page Title Should Be  Instruction > Messages > Mes Messages
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours dont je suis l'instructeur ou dont le destinataire est 'commune'.
    Element Should Contain  css=#tab-messages_mes_retours .pagination-text  1 - 0 enregistrement(s) sur 0
    Element Should Not Contain  css=#tab-messages_mes_retours table thead  instructeur
    Element Should Not Contain  css=#tab-messages_mes_retours table thead  division
    Element Should Not Contain  css=#tab-messages_mes_retours table thead  collectivité
    #
    Go To Submenu In Menu  instruction  messages_retours_ma_division
    Page Title Should Be  Instruction > Messages > Messages De Ma Division
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours situés dans ma division ou dont le destinataire est 'commune'.
    Element Should Contain  css=#tab-messages_retours_ma_division .pagination-text  1 - 0 enregistrement(s) sur 0
    Element Should Contain  css=#tab-messages_retours_ma_division table thead  instructeur
    Element Should Not Contain  css=#tab-messages_retours_ma_division table thead  division
    Element Should Not Contain  css=#tab-messages_retours_ma_division table thead  collectivité
    #
    Go To Submenu In Menu  instruction  messages_tous_retours
    Page Title Should Be  Instruction > Messages > Tous Les Messages
    First Tab Title Should Be  Message
    Page Should Contain  Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction en cours situés dans ma collectivité.
    Element Should Contain  css=#tab-messages_tous_retours .pagination-text  1 - 0 enregistrement(s) sur 0
    Element Should Contain  css=#tab-messages_tous_retours table thead  instructeur
    Element Should Contain  css=#tab-messages_tous_retours table thead  division
    Element Should Not Contain  css=#tab-messages_tous_retours table thead  collectivité

    #
    # Vérification des messages concernant les dossiers contentieux.
    # La fonctionnalité étant la même que celle des messages des dossiers
    # standards, les tests seront moins exhaustifs et contrôlerons seulement le
    # filtre par groupe et les liens de redirection.
    #

    # On vérifie que les dossiers contentieux n'apparaissent pas le listing des
    # dossers standards
    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  instruction  messages_tous_retours
    Page Should Not Contain  ${di_05}
    Page Should Not Contain  ${di_06}
    # On vérifie que les dossiers standards n'apparaissent pas le listing des
    # dossers contentieux
    Depuis la page d'accueil  admin  admin
    Go To Submenu In Menu  contentieux  messages_contentieux_tous_retours
    Page Should Not Contain  ${di_01}
    Page Should Not Contain  ${di_02}
    Page Should Not Contain  ${di_03}
    Page Should Not Contain  ${di_04}

    # On vérifie que le juriste ait accès aux messages recours et infractions
    Depuis la page d'accueil  ${utilisateur_login_05}  ${utilisateur_login_05}
    # On contrôle le widget
    Element Should Contain  css=#widget_134 .widget-content-wrapper span.box-icon  2
    # On vérifie le listing "instructeur"
    Click Element  css=#widget_134 .widget-footer a
    Page Should Contain  ${di_05}
    Page Should Contain  ${di_06}
    # On vérifie les liens du recours et de l'infraction
    Click On Link  ${di_05}
    Submenu In Menu Should Be Selected  contentieux  dossier_contentieux_mes_infractions
    Go To Submenu In Menu  contentieux  messages_contentieux_mes_retours
    Click On Link  ${di_06}
    Submenu In Menu Should Be Selected  contentieux  dossier_contentieux_mes_recours
    # On vérifie le listing "division"
    Go To Submenu In Menu  contentieux  messages_contentieux_retours_ma_division
    Page Should Contain  ${di_05}
    Page Should Contain  ${di_06}
    # On vérifie les liens du recours et de l'infraction
    Click On Link  ${di_05}
    Submenu In Menu Should Be Selected  contentieux  dossier_contentieux_toutes_infractions
    Go To Submenu In Menu  contentieux  messages_contentieux_retours_ma_division
    Click On Link  ${di_06}
    Submenu In Menu Should Be Selected  contentieux  dossier_contentieux_tous_recours
    # On vérifie le listing "aucun"
    Go To Submenu In Menu  contentieux  messages_contentieux_tous_retours
    Page Should Contain  ${di_05}
    Page Should Contain  ${di_06}
    # On vérifie les liens du recours et de l'infraction
    Click On Link  ${di_05}
    Submenu In Menu Should Be Selected  contentieux  dossier_contentieux_toutes_infractions
    Go To Submenu In Menu  contentieux  messages_contentieux_tous_retours
    Click On Link  ${di_06}
    Submenu In Menu Should Be Selected  contentieux  dossier_contentieux_tous_recours

    # On vérifie le cas spécifique du responsable de division infraction qui n'a
    # pas accès aux menu "mes"
    Depuis la page d'accueil  ${utilisateur_login_08}  ${utilisateur_login_08}
    &{args_di} =  Create Dictionary
    ...  instructeur_2=${utilisateur_nom_08} (C-T-X)
    Modifier le dossier d'instruction  ${di_05}  ${args_di}  infraction

    # Le lien des messages "instructeur" doit rediriger vers le menu "tous"
    Go To Submenu In Menu  contentieux  messages_contentieux_mes_retours
    Click On Link  ${di_05}
    Submenu In Menu Should Be Selected  contentieux  dossier_contentieux_toutes_infractions

    ##
    ## Vérification de la notion de destinataire dans les messages
    ##

    #
    # Constitution du jeux de données
    #

    Depuis la page d'accueil  admin  admin

    # On affecte automatiquement cet instructeur sur les dossiers de la
    # collectivité B de niveau 1
    Supprimer l'affectation depuis le menu  Elizabeth ORTIZ (DKP)
    &{args_affectation} =  Create Dictionary
    ...  instructeur=${utilisateur_nom_09} (YY)
    ...  om_collectivite=${collectivite_b}
    Ajouter l'affectation depuis le menu  ${args_affectation}

    # On ajoute un dossier d'instruction
    &{args_petitionnaire_07} =  Create Dictionary
    ...  particulier_nom=Flamand
    ...  particulier_prenom=Léon
    ...  om_collectivite=${collectivite_b}
    &{args_demande_07} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${collectivite_b}
    ${di_07} =  Ajouter la demande par WS  ${args_demande_07}  ${args_petitionnaire_07}

    #
    # Depuis un dossier d'instruction de la commune A affecté à un instructeur
    # de la communauté, on ajoute une pièce avec cet instructeur. Le
    # destinataire du message doit être "commune" et donc l'instructeur affecté
    # ne doit pas être notifié.
    #

    Depuis la page d'accueil  jmarcoux  jmarcoux
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=autres pièces composant le dossier (A0)
    Ajouter une pièce depuis le dossier d'instruction  ${di_07}  ${document_numerise_values}
    Depuis la page d'accueil  ${utilisateur_login_09}  ${utilisateur_login_09}
    Depuis le contexte du message dans le dossier d'instruction  ${di_07}  jmarcoux (Joseph Marcoux)
    # On vérifie que le champ destinataire contient bien la valeur "commune"
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#destinataire  commune
    # On vérifie que le widget indique aucun message
    Go To Dashboard
    Element Should Contain  css=.widget_messages_retours .widget-content-wrapper  Aucun message non lu.
    Element Should Not Contain  css=.widget_messages_retours  Voir +

    #
    # L'instructeur de la commune doit avoir une notification et doit pouvoir
    # marquer comme lu le message même s'il ne sont pas de la même division.
    #

    Depuis la page d'accueil  eortiz  eortiz
    # On vérifie que le widget affiche 1 message
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=#${widget_id} .widget-content-wrapper span.box-icon  1
    # Depuis le lien "Voir +" du widget, on vérifie le message
    Click Element  css=#${widget_id} .widget-footer a
    Click On Link  ${di_07}
    # On vérifie que le champ destinataire contient bien la valeur "commune" et
    # qu'il a accès à l'action "Marquer comme lu"
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#destinataire  commune
    Portlet Action Should Be In SubForm  dossier_message  marquer_comme_lu

    #
    # On ajoute un message à destination de l'instructeur communauté, le
    # destinataire doit contenir la valeur "isntructeur". Ce message ne doit pas
    # être marqué comme lu par un instructeur commune qui n'est pas de la même
    # division.
    #

    Depuis la page d'accueil  admin  admin
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  document_numerise_type=autres pièces composant le dossier (A0)
    Ajouter une pièce depuis le dossier d'instruction  ${di_07}  ${document_numerise_values}
    Depuis le contexte du message dans le dossier d'instruction  ${di_07}  admin (Administrateur)
    # On vérifie que le champ destinataire contient bien la valeur "instructeur"
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Form Static Value Should Be  css=#destinataire  instructeur
    # L'instructeur du dossier doit pouvoir marquer comme lu le message
    Depuis la page d'accueil  jmarcoux  jmarcoux
    Depuis le contexte du message dans le dossier d'instruction  ${di_07}  admin (Administrateur)
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Portlet Action Should Be In SubForm  dossier_message  marquer_comme_lu
    # L'instructeur de la commune ne doit pas pouvoir marquer comme lu le
    # message
    Depuis la page d'accueil  eortiz  eortiz
    Depuis le contexte du message dans le dossier d'instruction  ${di_07}  admin (Administrateur)
    Wait Until Page Contains Element  dossier_message
    Portlet Action Should Not Be In SubForm  dossier_message  marquer_comme_lu


Gestion de l'action 'Marquer comme lu'
    [Documentation]  Test des conditions d'affichage de l'action.
    ...  /!\ Dépendant du paramétrage des instructeurs et affectations automatiques

    # En admin on crée un dossier avec une pièce donc un message
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=PYRET
    ...  particulier_prenom=Laurent
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  date_demande=${date_ddmmyyyy}
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=${date_ddmmyyyy}
    ...  document_numerise_type=autres pièces composant le dossier (A0)

    Depuis la page d'accueil  admin  admin
    Ajouter une pièce depuis le dossier d'instruction  ${di}  ${document_numerise_values}

    # En instructeur d'une division différente que celle du dossier
    # on ne doit pas pouvoir marquer le message comme lu
    Depuis la page d'accueil  instr2  instr
    Depuis l'onglet des messages du dossier d'instruction  ${di}
    Click On Link  Ajout de pièce(s)
    Portlet Action Should Not Be In SubForm  dossier_message  marquer_comme_lu

    # En instructeur du dossier on doit pouvoir marquer le message comme lu
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet des messages du dossier d'instruction  ${di}
    Click On Link  Ajout de pièce(s)
    Portlet Action Should Be In SubForm  dossier_message  marquer_comme_lu

    # On accepte le dossier pour le clôturer
    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve  false  ${date_ddmmyyyy}
    # On doit toujours pouvoir marquer le message comme lu
    Depuis l'onglet des messages du dossier d'instruction  ${di}
    Click On Link  Ajout de pièce(s)
    Portlet Action Should Be In SubForm  dossier_message  marquer_comme_lu

    # On ajoute le bypass au profil instructeur
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu  dossier_message_modifier_lu_bypass  INSTRUCTEUR
    # Dorénavant l'instructeur de la division différente doit pouvoir marquer comme lu
    Depuis la page d'accueil  instr2  instr
    Depuis l'onglet des messages du dossier d'instruction  ${di}
    Click On Link  Ajout de pièce(s)
    Portlet Action Should Be In SubForm  dossier_message  marquer_comme_lu
    # Pour la suite des tests on supprime le bypass créé dans ce test case
    Depuis la page d'accueil  admin  admin
    Depuis le listing des droits
    Use Simple Search  libellé  dossier_message_modifier_lu_bypass
    Click On Link  INSTRUCTEUR
    Click On Form Portlet Action  om_droit  supprimer


Test de l'action 'ajouter'
    [Documentation]  Ajouter un message manuellement

    Depuis la page d'accueil  admin  admin
    #Ajouter le widget de notification des messages au profil INSTRUCTEUR POLYVALENT
    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0
    Select From List By Label  om_profil  INSTRUCTEUR POLYVALENT
    Input Text  bloc  C3
    Select From List By Label  om_widget  Mes messages
    Click On Submit Button
    #Ajouter le droit d'ajouter un message aux types de profil qui seront utilisés
    Ajouter le droit depuis le menu si il n'existe pas  dossier_message_ajouter  INSTRUCTEUR POLYVALENT
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
    ${direction} =  Set Variable  Direction SCP
    ${direction_code} =  Set Variable  SCP
    ${div_1} =  Set Variable  subdivision SCP1
    ${div_code_1} =  Set Variable  SCP1
    Ajouter la direction depuis le menu  ${direction_code}  ${direction}
    ...  null  Chef SCP  null  null  ${collectivite}
    Ajouter la division depuis le menu  ${div_code_1}  ${div_1}  null
    ...  Chef SCP  null  null  ${direction}


    #Créer un nouveau dossier (affecté à l'utilisateur 1)
    Depuis la page d'accueil  admin  admin
    #Création du dossier sur lequel un message manuel sera ajouté
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Parkopoulos
    ...  particulier_prenom=Sisyphe
    ...  om_collectivite=${collectivite}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${collectivite}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #Ajouter un message manuel au dossier collectivité niveau 1 par un administrateur
    ${message} =  Set Variable  Message de l'admin
    ${dossier_message_1} =  Ajouter un message dans le dossier d'instruction  ${di}  ${message}

    #On vérifie que le message apparait dans le listing des messages
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=table.tab-tab  ${dossier_message_1}
    #On vérifie le type et le destinataire du message
    Go To  ${PROJECT_URL}/app/index.php?module=sousform&obj=dossier_message&action=3&idx=${dossier_message_1}
    Wait Until Element Is Visible  type
    Element Text Should Be  type  message manuel
    Element Text Should Be  destinataire  instructeur

    #En vu de pouvoir vérifier l'icone de message dans le listing des derniers dossiers
    #déposés, on ajoute le widget correspondant au tableau de bord INSTRUCTEUR
    Ajouter le droit depuis le menu si il n'existe pas  derniers_dossiers_deposes  INSTRUCTEUR
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

    #Actions de l'utilisateur 1
    Depuis la page d'accueil  instrpoly  instrpoly
    # On clique sur le lien du widget Mes messages(Voir +)
    Click Element Until New Element  css=.widget_messages_retours .widget-footer a  css=div#adv-search-classic-fields input
    # Recherche sur le dossier
    ${libelle_sans_espace} =  Sans espace  ${di}
    Input Text  css=div#adv-search-classic-fields input  ${libelle_sans_espace}
    Click On Search Button
    # L'instructeur polyvalent doit voir le nouveau message
    Element Should Contain  css=table.tab-tab  ${di}
    #Ajouter un message manuel au dossier par un utilisateur 2 (collectivité de niveau 2)
    ${message} =  Set Variable  Message de l'instrpoly (collectivité niveau 2)
    ${dossier_message_2} =  Ajouter un message dans le dossier d'instruction  ${di}  ${message}
    #On vérifie que le message apparait dans le listing des messages
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    ...  Element Should Contain  css=table.tab-tab  ${dossier_message_2}
    Go To  ${PROJECT_URL}/app/index.php?module=sousform&obj=dossier_message&action=3&idx=${dossier_message_2}
    Wait Until Element Is Visible  type
    Element Text Should Be  type  message manuel
    Element Text Should Be  destinataire  commune

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
    ...  particulier_nom=Rintarou
    ...  particulier_prenom=Okabe
    ...  om_collectivite=${collectivite}
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de démolir
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=${collectivite}
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  instrms  instrms
    #On vérifie que l'utilisateur 2 est bien notifié du message laissé par l'admin
    ${nombre_messages} =  Get Text
    ...  css=.widget_messages_retours .widget-content .size-h3.box-icon.rounded.bg-info
    Should Not Be Empty  ${nombre_messages}
    Should Be Equal  ${nombre_messages}  1
    #Ajouter un message manuel au dossier par l'utilisateur 2 (collectivité de niveau 2)
    ${message} =  Set Variable  Message de l'instrms (collectivité niveau 1)
    ${dossier_message_2} =  Ajouter un message dans le dossier d'instruction  ${di}  ${message}
    #On vérifie le type et le destinataire du message
    Go To  ${PROJECT_URL}/app/index.php?module=sousform&obj=dossier_message&action=3&idx=${dossier_message_1}
    Wait Until Element Is Visible  type
    Element Text Should Be  type  message manuel
    Element Text Should Be  destinataire  instructeur
    #On vérifie que l'utilisateur 2 n'est notifié que du message non lu:
    # l'instructeur du dossier étant l'emetteur du message, il n'est pas notifié
    Depuis la page d'accueil  instrms  instrms
    ${nombre_messages} =  Get Text
    ...  css=.widget_messages_retours .widget-content .size-h3.box-icon.rounded.bg-info
    Should Not Be Empty  ${nombre_messages}
    Should Be Equal  ${nombre_messages}  1

    # On vérifie que le listing associé au widget des derniers dossiers déposés
    # affiche bien un indicateur de message manuel pour le dossier
    # On clique sur le lien vers le listing
    Depuis la page d'accueil  instrms  instrms
    Click Link  css=.widget_derniers_dossiers_deposes .widget-footer a
    Page Title Should Be  Instruction > Dossiers Déposés
    # On vérifie la présence de l'indicateur
    Page Should Contain Element  css=div#tab-derniers_dossiers_deposes div.tab-container table.tab-tab tbody tr td.col-10 a span

    #On met l'option du widget des derniers dossiers restreindre_msg_non_lu à true
    Depuis la page d'accueil   admin  admin
    Depuis le contexte du widget  derniers_dossiers_deposes
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments
    ...  codes_datd=PCI;PD\nfiltre=division\nfiltre_depot=guichet\nnombre_de_jours=15\nrestreindre_msg_non_lus=true
    Click On Submit Button
    Depuis la page d'accueil  instrms  instrms
    Click Link  css=.widget_derniers_dossiers_deposes .widget-footer a
    Page Title Should Be  Instruction > Dossiers Déposés
    # On vérifie l'absence' de l'indicateur de message
    Page Should Not Contain Element  css=div#tab-derniers_dossiers_deposes div.tab-container table.tab-tab tbody tr td.col-10 a span

    #Supprimer le droit ajouté en début de test pour revenir en condition initiale
    Depuis la page d'accueil  admin  admin
    Depuis le listing des droits
    Use Simple Search  libellé  derniers_dossiers_deposes
    Select From List By Label  name=selectioncol  Tous
    Click Element  css=button#search-submit
    Wait Until Element Is Visible  css=table.tab-tab
    Click On Link  INSTRUCTEUR
    Click Element  action-form-om_droit-supprimer
    Click On Submit Button

Décomposition du jeu de données
    Depuis la page d'accueil  admin  admin
    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_afficher_division
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}

    &{param_args} =  Create Dictionary
    ...  selection_col=libellé
    ...  search_value=option_notification_piece_numerisee
    ...  click_value=agglo
    Supprimer le paramètre (surcharge)  ${param_args}
