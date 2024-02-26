*** Settings ***
Documentation  TestSuite "Architecte"
...
...  Les données techniques d'un DI permettent de saisir l'architecte du
...  projet. Cet architecte peut avoir un caractère fréquent et il est
...  donc possible de gérer ces architectes depuis un listing dédié.
Resource  resources/resources.robot
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Test Cases ***
Constitution du jeu de données
    [Documentation]  L'objet de ce TestCase est de constituer un jeu de données
    ...  cohérent pour les scénarios fonctionnels qui suivent.

    Depuis la page d'accueil  admin  admin

    &{archi_g_01} =  Create Dictionary
    ...  nom=Mercier
    ...  prenom=Paul
    ...  adresse1=113 boulevard de pont de vivaux
    ...  adresse2=
    ...  cp=13010
    ...  ville=Marseille
    ...  pays=France
    ...  inscription=54646
    ...  telephone=0497856235
    ...  fax=0497856236
    ...  email=paul.mercier@architecte.fr
    ...  note=
    ...  nom_cabinet=
    ...  conseil_regional=
    ${archi_g_01.id} =  Ajouter l'architecte fréquent  ${archi_g_01}
    Set Suite Variable  ${archi_g_01}

    &{archi_g_02} =  Create Dictionary
    ...  nom=Mercier
    ...  prenom=Jean
    ...  adresse1=113 boulevard de pont de vivaux
    ...  adresse2=
    ...  cp=13010
    ...  ville=Marseille
    ...  pays=France
    ...  inscription=56454
    ...  telephone=0491352689
    ...  fax=0491352685
    ...  email=jean.mercier@architecte.fr
    ...  note=
    ...  nom_cabinet=
    ...  conseil_regional=
    ${archi_g_02.id} =  Ajouter l'architecte fréquent  ${archi_g_02}
    Set Suite Variable  ${archi_g_02}

    &{di_g_01} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{di_g_01.petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=DUPONT T060 DI_G_01
    ...  particulier_prenom=JACQUES
    ...  om_collectivite=MARSEILLE
    ${di_g_01.libelle} =  Ajouter la demande par WS  ${di_g_01}  ${di_g_01.petitionnaire1}
    Set Suite Variable  ${di_g_01}

    &{di_g_02} =  Create Dictionary
    ...  om_collectivite=MARSEILLE
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    &{di_g_02.petitionnaire1} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=DURAND T060 DI_G_01
    ...  particulier_prenom=PAUL
    ...  om_collectivite=MARSEILLE
    ${di_g_02.libelle} =  Ajouter la demande par WS  ${di_g_02}  ${di_g_02.petitionnaire1}
    Set Suite Variable  ${di_g_02}


test_01_AjoutArchitecteFrequent
    [Documentation]  Test de l'ajout d'un architecte fréquent par
    ...  l'administrateur technique.

    Depuis la page d'accueil  admin  admin

    # On accède à l'écran de gestion des architectes fréquents
    Go To Submenu In Menu  instruction  architecte_frequent
    Page Title Should Be  Instruction > Qualification > Architecte Fréquent
    First Tab Title Should Be  Architecte Fréquent

    # On clique sur le "+" du tableau d'architectes fréquents
    Click On Add Button

    # On essaye de valider le formulaire sans remplir de champ
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE
    # On vérifie qu'il y a un message d'erreur
    Error Message Should Contain  SAISIE NON ENREGISTRÉE

    # On remplit les champs
    Input Text  css=#nom  Lefebvre
    Input Text  css=#prenom  James
    Input Text  css=#adresse1  113 boulevard de pont de vivaux
    Input Text  css=#cp  13010
    Input Text  css=#ville  Marseille
    Input Text  css=#inscription  0491855565
    Input Text  css=#telephone  0491236589
    Input Text  css=#fax  0491236585
    Input Text  css=#email  james.lefebvre@architecte.fr

    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Be  Vos modifications ont bien été enregistrées.

    # On clique sur le bouton de retour
    Click On Back Button
    Page Title Should Be  Instruction > Qualification > Architecte Fréquent
    First Tab Title Should Be  Architecte Fréquent
    Submenu In Menu Should Be Selected  instruction  architecte_frequent

    # On vérifie que l'architecte fréquent s'est bien ajouté en cliquant dessus
    Use Simple Search  Tous  Lefebvre
    Click On Link  James Lefebvre
    Page Title Should Contain  Instruction > Qualification > Architecte Fréquent >
    Page Title Should Contain  JAMES LEFEBVRE
    First Tab Title Should Be  Architecte Fréquent
    Submenu In Menu Should Be Selected  instruction  architecte_frequent


test_02_AjoutArchitecteFrequentDonneesTechniques
    [Documentation]  Test de l'ajout d'un architecte fréquent aux données
    ...  techniques par l'instructeur. Utilisation de l'architecte fréquent
    ...  rajouté par l'administrateur.

    Depuis la page d'accueil  instr  instr

    # On accède à un dossier d'instruction dans le contexte de mes encours
    Depuis le contexte du dossier d'instruction de mes encours  ${di_g_01.libelle}
    # On clique sur "Données techniques dans le portlet d'actions"
    Click On Form Portlet Action  dossier_instruction_mes_encours  donnees_techniques  modale
    # On affiche le formulaire en modification
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier

    # On ouvre les fieldsets Construire puis Projet construction
    Open Fieldset In Subform  donnees_techniques  construire
    Open Fieldset In Subform  donnees_techniques  projet-construction

    # On clique sur "Ajouter un architecte"
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sousform-donnees_techniques span.add_architecte
    # On essaye de valider un formulaire vide
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sousform-architecte .om-button
    # On vérifie le message d'erreur
    Error Message Should Contain In Subform  SAISIE NON ENREGISTRÉE

    # On écrit le nom d'un architecte qui ne retournera aucun résultat
    Input Text  css=#sousform-architecte #nom  zzz
    # On lance la recherche
    Click Element  css=.search-frequent-16
    # On vérifie le message de l'overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.dialog-search-frequent-architecte  Aucune correspondance trouvée.
    # On clique sur valider
    Click Element  css=.ui-dialog .ui-dialog-buttonset .ui-button-text-only

    # On écrit le nom d'un architecte avec un apostrophe pour s'assurer que la reque ne plante pas
    Input Text  css=#sousform-architecte #nom  *'*
    # On lance la recherche
    Click Element  css=.search-frequent-16
    # On vérifie le message de l'overlay
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Contain  css=.dialog-search-frequent-architecte  Aucune correspondance trouvée.
    # On clique sur valider
    Click Element  css=.ui-dialog .ui-dialog-buttonset .ui-button-text-only

    # on écrit le nom d'un architecte qui existe existe en plusieurs fois
    Input Text  css=#sousform-architecte #nom  Mercier
    # On lance la recherche
    Click Element  css=.search-frequent-16
    # On vérifie qu'on a deux résultats
    Sleep  2
    ${list} =  Get List Items  css=#dialog select
    Length Should Be  ${list}  2

    # On clique sur fermer
    Click Element  css=div.dialog-search-frequent-architecte a.ui-dialog-titlebar-close

    # On écrit le nom d'un architecte qui existe qu'une fois
    Input Text  css=#sousform-architecte #nom  Lefebvre
    # On lance la recherche
    Click Element  css=.search-frequent-16
    # On vérifie qu'on a qu'un seul résultat
    Sleep  2
    ${list} =  Get List Items  css=#dialog select
    Length Should Be  ${list}  1

    # On valide le formulaire de l'architecte
    Click Element  css=div.dialog-search-frequent-architecte div.ui-dialog-buttonset button
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Error Message Should Be In Subform  Architecte fréquent non modifiable

    # On vérifie que le prenom de l'architecte choisit est bon
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Text Should Be  css=#sousform-architecte #prenom  James

    # On clique sur retour
    Click Element  css=#sousform-architecte a.retour

    # On vérifie que l'identifiant de l'architecte choisit est remplit
    Wait Until Element Is Visible  css=.field-type-manage_with_popup .edit-16
    Element Text Should Be  css=.field-type-manage_with_popup .edit-16  Lefebvre James

    # On valide le formulaire de données techniques
    Click On Submit Button In Subform

    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be In Subform  Vos modifications ont bien été enregistrées.

    # On clique sur retour
    Click On Back Button In Subform

    # On clique sur "Données techniques dans le portlet d'actions"
    Click On Form Portlet Action  dossier_instruction_mes_encours  donnees_techniques  modale
    Wait Until Page Contains Element  css=[id^="fieldset-sousform-donnees_techniques"]

    # On ouvre les fieldsets Construire puis Projet construction
    Open Fieldset In Subform  donnees_techniques  construire
    Open Fieldset In Subform  donnees_techniques  projet-construction

    # On verifie que le bon architecte s'est enregistré
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Text Should Be  css=#sousform-donnees_techniques #architecte  James Lefebvre

    # On clique sur retour
    Click On Back Button In Subform


test_03_AjoutArchitecteDonneesTechniques
    [Documentation]  Test de l'ajout d'un architecte aux données techniques par
    ...  l'instructeur.

    Depuis la page d'accueil  instr  instr

    # On accède à un dossier d'instruction dans le contexte de mes encours
    Depuis le contexte du dossier d'instruction de mes encours  ${di_g_02.libelle}
    # On clique sur "Données techniques dans le portlet d'actions"
    Click On Form Portlet Action  dossier_instruction_mes_encours  donnees_techniques  modale
    # On affiche le formulaire en modification
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click On SubForm Portlet Action  donnees_techniques  modifier

    # On ouvre les fieldsets Construire puis Projet construction
    Open Fieldset In Subform  donnees_techniques  construire
    Open Fieldset In Subform  donnees_techniques  projet-construction

    # On clique sur "Ajouter un architecte"
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sousform-donnees_techniques span.add_architecte
    # On essaye de valider un formulaire vide
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Element  css=#sousform-architecte .om-button
    # On vérifie le message d'erreur
    Error Message Should Contain In Subform  SAISIE NON ENREGISTRÉE

    # On remplit les champs
    Input Text  css=#nom  Montmorrency
    Input Text  css=#prenom  Paul Marie Édouard
    Input Text  css=#adresse1  113 boulevard de pont de vivaux
    Input Text  css=#cp  13010
    Input Text  css=#ville  Marseille
    Input Text  css=#inscription  0491855565
    Input Text  css=#telephone  0491236589
    Input Text  css=#fax  0491236585
    Input Text  css=#email  paul.marie.edouard.montmorrency@architecte.fr

    # On valide le formulaire de l'architecte
    Click Element  css=#sousform-architecte .om-button
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be In Subform  Vos modifications ont bien été enregistrées.

    # On clique sur retour
    Click Element  css=#sousform-architecte a.retour

    # On vérifie que l'identifiant de l'architecte choisit est remplit
    Wait Until Element Is Visible  css=.field-type-manage_with_popup .edit-16
    Element Text Should Be  css=.field-type-manage_with_popup .edit-16  Montmorrency Paul Marie Édouard

    # On valide le formulaire de données techniques
    Click On Submit Button In Subform

    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be In Subform  Vos modifications ont bien été enregistrées.

    # On clique sur retour
    Click On Back Button In Subform

    # On clique sur "Données techniques dans le portlet d'actions"
    Click On Form Portlet Action  dossier_instruction_mes_encours  donnees_techniques  modale

    # On ouvre les fieldsets Construire puis Projet construction
    Open Fieldset In Subform  donnees_techniques  construire
    Open Fieldset In Subform  donnees_techniques  projet-construction

    # On verifie que le bon architecte s'est enregistré
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Text Should Be  css=#sousform-donnees_techniques #architecte  Paul Marie Édouard Montmorrency

    # On clique sur retour
    Click On Back Button In Subform


test_04_MarquerArchitecteFrequentNonFrequent
    [Documentation]  Test de l'ajout d'un architecte fréquent par
    ...  l'administrateur technique.

    Depuis la page d'accueil  admin  admin

    # On accède à l'écran de gestion des architectes fréquents
    Go To Submenu In Menu  instruction  architecte_frequent
    Page Title Should Be  Instruction > Qualification > Architecte Fréquent
    First Tab Title Should Be  Architecte Fréquent

    # On clique sur le "+" du tableau d'architectes fréquents
    Click On Add Button

    # On essaye de valider le formulaire sans remplir de champ
    Click On Submit Button Until Message  SAISIE NON ENREGISTRÉE
    # On vérifie qu'il y a un message d'erreur
    Error Message Should Contain  SAISIE NON ENREGISTRÉE

    # On remplit les champs
    Input Text  css=#nom  Paul
    Input Text  css=#prenom  James
    Input Text  css=#adresse1  113 boulevard de pont de vivaux
    Input Text  css=#cp  13010
    Input Text  css=#ville  Marseille
    Input Text  css=#inscription  0491855565
    Input Text  css=#telephone  0491236589
    Input Text  css=#fax  0491236585
    Input Text  css=#email  james.paul@architecte.fr

    # On valide le formulaire
    Click On Submit Button
    # On vérifie le message de validation
    Valid Message Should Be  Vos modifications ont bien été enregistrées.

    # On clique sur le bouton de retour
    Click On Back Button
    Page Title Should Be  Instruction > Qualification > Architecte Fréquent
    First Tab Title Should Be  Architecte Fréquent
    Submenu In Menu Should Be Selected  instruction  architecte_frequent

    # On vérifie que l'architecte fréquent s'est bien ajouté en cliquant dessus
    Use Simple Search  Tous  James
    Click On Link  James Paul
    Page Title Should Contain  Instruction > Qualification > Architecte Fréquent >
    Page Title Should Contain  JAMES PAUL
    First Tab Title Should Be  Architecte Fréquent
    Submenu In Menu Should Be Selected  instruction  architecte_frequent

    #  On marque l'architecte comme non fréquent
    Click On Form Portlet Action  architecte_frequent  non_frequent
    # On vérifie le message
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Be  Mise à jour effectuée avec succès

    # On clique sur le bouton de retour
    Click On Back Button
    Page Title Should Be  Instruction > Qualification > Architecte Fréquent
    First Tab Title Should Be  Architecte Fréquent
    Submenu In Menu Should Be Selected  instruction  architecte_frequent

    #  On vérifie que le text est présent
    Use Simple Search  Tous  James
    Page Should Not Contain  James Paul


