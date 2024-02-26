*** Settings ***
Documentation  Test des événements d'instruction.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown

*** Test Cases ***
Constitution du jeu de données
    [Documentation]  Constitue le jeu de données.

    Depuis la page d'accueil  admin  admin

    &{famille_travaux1} =  Create Dictionary
    ...  libelle=Ravalement
    ...  code=RAV
    ${famille_travaux1.id} =  Ajouter la famille de travaux  ${famille_travaux1}
    Set Suite Variable  ${famille_travaux1}

    &{famille_travaux2} =  Create Dictionary
    ...  libelle=Transformation
    ...  code=TRA
    ${famille_travaux2.id} =  Ajouter la famille de travaux  ${famille_travaux2}
    Set Suite Variable  ${famille_travaux2}

    &{famille_travaux3} =  Create Dictionary
    ...  libelle=Restauration
    ...  code=RES
    ${famille_travaux3.id} =  Ajouter la famille de travaux  ${famille_travaux3}
    Set Suite Variable  ${famille_travaux3}

    @{dit_nature_travauxft1} =  Create List
    ...  DP - Initiale
    ...  CU - Initial
    &{nature_travaux1ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement public
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux1ft1.id} =  Ajouter la nature de travaux  ${nature_travaux1ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux1ft1}

    &{nature_travaux2ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux2ft1.id} =  Ajouter la nature de travaux  ${nature_travaux2ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux2ft1}

    &{nature_travaux3ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé 2
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux3ft1.id} =  Ajouter la nature de travaux  ${nature_travaux3ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux3ft1}

    &{nature_travaux4ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé 3
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux4ft1.id} =  Ajouter la nature de travaux  ${nature_travaux4ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux4ft1}

    &{nature_travaux5ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé 4
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux5ft1.id} =  Ajouter la nature de travaux  ${nature_travaux5ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux5ft1}

    &{nature_travaux6ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé 5
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux6ft1.id} =  Ajouter la nature de travaux  ${nature_travaux6ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux6ft1}

    &{nature_travaux7ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé 6
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux7ft1.id} =  Ajouter la nature de travaux  ${nature_travaux7ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux7ft1}

    &{nature_travaux8ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé 7
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux8ft1.id} =  Ajouter la nature de travaux  ${nature_travaux8ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux8ft1}

    &{nature_travaux9ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé 8
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux9ft1.id} =  Ajouter la nature de travaux  ${nature_travaux9ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux9ft1}

    &{nature_travaux10ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé 9
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux10ft1.id} =  Ajouter la nature de travaux  ${nature_travaux10ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux10ft1}

    &{nature_travaux11ft1} =  Create Dictionary
    ...  libelle=Ravalement d'établissement privé 10
    ...  code=RAEP
    ...  famille_travaux=${famille_travaux1.libelle}
    ${nature_travaux11ft1.id} =  Ajouter la nature de travaux  ${nature_travaux11ft1}  ${dit_nature_travauxft1}
    Set Suite Variable  ${nature_travaux11ft1}

    @{dit_nature_travauxft2} =  Create List
    ...  DP - Initiale
    ...  DP - Achèvement et conformité
    &{nature_travaux1ft2} =  Create Dictionary
    ...  libelle=Transformation de façade privé
    ...  code=TraPr
    ...  famille_travaux=${famille_travaux2.libelle}
    ${nature_travaux1ft2.id} =  Ajouter la nature de travaux  ${nature_travaux1ft2}  ${dit_nature_travauxft2}
    Set Suite Variable  ${nature_travaux1ft2}

    &{nature_travaux2ft2} =  Create Dictionary
    ...  libelle=Transformation de façade public
    ...  code=TraPu
    ...  famille_travaux=${famille_travaux2.libelle}
    ${nature_travaux2ft2.id} =  Ajouter la nature de travaux  ${nature_travaux2ft2}  ${dit_nature_travauxft2}
    Set Suite Variable  ${nature_travaux2ft2}

    ${demain} =  Add Time To Date  ${date_ddmmyyyy}  1 days  %d/%m/%Y  True  %d/%m/%Y
    ${hier} =  Add Time To Date  ${date_ddmmyyyy}  -1 days  %d/%m/%Y  True  %d/%m/%Y
    ${avant_hier} =  Add Time To Date  ${date_ddmmyyyy}  -2 days  %d/%m/%Y  True  %d/%m/%Y
    Set Suite Variable  ${hier}
    Set Suite Variable  ${avant_hier}

    &{nature_travaux3ft2} =  Create Dictionary
    ...  libelle=Transformation de jardin
    ...  code=TraJar
    ...  famille_travaux=${famille_travaux2.libelle}
    ...  om_validite_debut=${date_ddmmyyyy}
    ...  om_validite_fin=01/01/2043
    ${nature_travaux3ft2.id} =  Ajouter la nature de travaux  ${nature_travaux3ft2}  ${dit_nature_travauxft2}
    Set Suite Variable  ${nature_travaux3ft2}

    &{nature_travaux4ft2} =  Create Dictionary
    ...  libelle=Transformation de monument
    ...  code=TraJar
    ...  famille_travaux=${famille_travaux2.libelle}
    ...  om_validite_debut=${demain}
    ...  om_validite_fin=01/01/2043
    ${nature_travaux4ft2.id} =  Ajouter la nature de travaux  ${nature_travaux4ft2}  ${dit_nature_travauxft2}
    Set Suite Variable  ${nature_travaux4ft2}

    &{nature_travaux5ft2} =  Create Dictionary
    ...  libelle=Transformation de route
    ...  code=TraJar
    ...  famille_travaux=${famille_travaux2.libelle}
    ...  om_validite_debut=${avant_hier}
    ...  om_validite_fin=${hier}
    ${nature_travaux5ft2.id} =  Ajouter la nature de travaux  ${nature_travaux5ft2}  ${dit_nature_travauxft2}
    Set Suite Variable  ${nature_travaux5ft2}

    @{dit_nature_travauxft3} =  Create List
    ...  CU - Initial

    &{nature_travaux1ft3} =  Create Dictionary
    ...  libelle=Restauration de façade privé
    ...  code=ReFPr
    ...  famille_travaux=${famille_travaux3.libelle}
    ${nature_travaux1ft3.id} =  Ajouter la nature de travaux  ${nature_travaux1ft3}  ${dit_nature_travauxft3}
    Set Suite Variable  ${nature_travaux1ft3}

    &{nature_travaux2ft3} =  Create Dictionary
    ...  libelle=Restauration de façade public
    ...  code=ReFPu
    ...  famille_travaux=${famille_travaux3.libelle}
    ${nature_travaux2ft3.id} =  Ajouter la nature de travaux  ${nature_travaux2ft3}  ${dit_nature_travauxft3}
    Set Suite Variable  ${nature_travaux2ft3}

Vérification du bon fonctionnement de l'ajout des natures de travaux dans les dossiers d'instruction
    [Documentation]  Permet de vérifier que les natures de travaux sont bien filtrées par type de dossier d'instruction
    ...  et par date de validité

    Depuis la page d'accueil  admin  admin
    # Création d'un dossier est vérification qu'il n'y a pas de natures de travaux associés
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST053NOM1
    ...  particulier_prenom=TEST053PRENOM1
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_sans_nt} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Set Suite Variable  ${di_sans_nt}
    Depuis le contexte du dossier d'instruction  ${di_sans_nt}
    Click On Portlet Action  dossier_instruction  modifier
    Click Element  css=#nature_travaux_chosen
    # On vérifie qu'il n'y a pas de résultats dans le chosen
    Element Should Contain  css=#nature_travaux_chosen div.chosen-drop ul.chosen-results  ${EMPTY}

    # Création d'un dossier ayant les travaux de la famille_travaux 1 et 2
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST053NOM2
    ...  particulier_prenom=TEST053PRENOM2
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=DECLARATION PREALABLE SIMPLE
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_avec_nt_ft1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    @{nature_travaux_di_ft1} =  Create List
    ...  ${nature_travaux1ft1.famille_travaux} / ${nature_travaux1ft1.libelle}
    ...  ${nature_travaux2ft1.famille_travaux} / ${nature_travaux2ft1.libelle}
    ...  ${nature_travaux3ft1.famille_travaux} / ${nature_travaux3ft1.libelle}
    ...  ${nature_travaux4ft1.famille_travaux} / ${nature_travaux4ft1.libelle}
    ...  ${nature_travaux5ft1.famille_travaux} / ${nature_travaux5ft1.libelle}
    ...  ${nature_travaux6ft1.famille_travaux} / ${nature_travaux6ft1.libelle}
    ...  ${nature_travaux7ft1.famille_travaux} / ${nature_travaux7ft1.libelle}
    ...  ${nature_travaux8ft1.famille_travaux} / ${nature_travaux8ft1.libelle}
    ...  ${nature_travaux9ft1.famille_travaux} / ${nature_travaux9ft1.libelle}
    ...  ${nature_travaux10ft1.famille_travaux} / ${nature_travaux10ft1.libelle}
    ...  ${nature_travaux11ft1.famille_travaux} / ${nature_travaux11ft1.libelle}
    ...  ${nature_travaux1ft2.famille_travaux} / ${nature_travaux1ft2.libelle}
    ...  ${nature_travaux2ft2.famille_travaux} / ${nature_travaux2ft2.libelle}
    ${value_di} =  Create Dictionary
    ...  date_demande=${date_ddmmyyyy}
    Set Suite Variable  ${value_di}

    Depuis le contexte du dossier d'instruction  ${di_avec_nt_ft1}
    Click On Portlet Action  dossier_instruction  modifier
    Select Multiple From Chosen List Should Contain List  nature_travaux  ${nature_travaux_di_ft1}
    @{not_nature_travaux_di_ft1} =  Create List
    ...  ${nature_travaux4ft2.famille_travaux} / ${nature_travaux4ft2.libelle}
    ...  ${nature_travaux5ft2.famille_travaux} / ${nature_travaux5ft2.libelle}
    Select Multiple From Chosen List Should Not Contain List  nature_travaux  ${not_nature_travaux_di_ft1}
    Modifier le dossier d'instruction  ${di_avec_nt_ft1}  ${value_di}  nature_travaux=${nature_travaux_di_ft1}
    Set Suite Variable  ${di_avec_nt_ft1}

    # Création d'un dossier ayant les travaux de la famille_travaux 3
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=TEST053NOM3
    ...  particulier_prenom=TEST053PRENOM3
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ${di_avec_nt_ft3} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Set Suite Variable  ${di_avec_nt_ft3}

    @{nature_travaux_di_ft3} =  Create List
    ...  ${nature_travaux1ft3.famille_travaux} / ${nature_travaux1ft3.libelle}
    ...  ${nature_travaux2ft3.famille_travaux} / ${nature_travaux2ft3.libelle}
    Depuis le contexte du dossier d'instruction  ${di_avec_nt_ft3}
    Click On Portlet Action  dossier_instruction  modifier
    Select Multiple From Chosen List Should Contain List  nature_travaux  ${nature_travaux_di_ft3}
    Modifier le dossier d'instruction  ${di_avec_nt_ft3}  ${value_di}  nature_travaux=${nature_travaux_di_ft3}

Vérification du filtrage sur nature travaux et famille_travaux dans le listing des dossiers d'instruction
    [Documentation]  Permet de vérifier que le filtrage sur la nature de travaux et la famille de travaux
    ...  fonctionne correctement

    Depuis la page d'accueil  admin  admin

    # Filtrage famille de travaux
    Depuis le listing  dossier_instruction
    ${param_advs} =  Create Dictionary
    ...  famille_travaux=${nature_travaux1ft3.famille_travaux}
    Saisir les parametres de recherche avancé du dossier d'instruction  ${param_advs}
    Click On Search Button

    Wait Until Element Contains  css=div.pagination-nb  1 -

    Element Should Contain  css=.tab-data
    ...  ${di_avec_nt_ft3}

    Element Should Not Contain  css=.tab-data
    ...  ${di_avec_nt_ft1}

    Element Should Not Contain  css=.tab-data
    ...  ${di_sans_nt}

    Depuis le listing  dossier_instruction
    ${param_advs} =  Create Dictionary
    ...  famille_travaux=${nature_travaux1ft2.famille_travaux}
    Saisir les parametres de recherche avancé du dossier d'instruction  ${param_advs}
    Click On Search Button

    Wait Until Element Contains  css=div.pagination-nb  1 -

    # di_avec_nt_ft1 contient les nature de travaux de la famille 1 et 2
    Element Should Contain  css=.tab-data
    ...  ${di_avec_nt_ft1}

    Element Should Not Contain  css=.tab-data
    ...  ${di_avec_nt_ft3}

    Element Should Not Contain  css=.tab-data
    ...  ${di_sans_nt}

    # Filtrage famille travaux avec un autre champ
    Depuis le listing  dossier_instruction
    ${param_advs} =  Create Dictionary
    ...  famille_travaux=${nature_travaux1ft2.famille_travaux}
    ...  date_depot_min=${date_ddmmyyyy}
    Saisir les parametres de recherche avancé du dossier d'instruction  ${param_advs}
    Click On Search Button

    Wait Until Element Contains  css=div.pagination-nb  1 -

    # di_avec_nt_ft1 contient les nature de travaux de la famille 1 et 2
    Element Should Contain  css=.tab-data
    ...  ${di_avec_nt_ft1}

    Element Should Not Contain  css=.tab-data
    ...  ${di_avec_nt_ft3}

    Element Should Not Contain  css=.tab-data
    ...  ${di_sans_nt}

    # Filtrage nature de travaux
    Depuis le listing  dossier_instruction
    ${param_advs} =  Create Dictionary
    ...  nature_travaux=${nature_travaux1ft1.libelle}
    Saisir les parametres de recherche avancé du dossier d'instruction  ${param_advs}
    Click On Search Button

    Wait Until Element Contains  css=div.pagination-nb  1 -

    # On vérifie que le span contient bien la structure voulu
    # (liste des famille / nature de travaux et description du projet tout en bas)
    # Multiline string with newlines

    @{nature_travaux_di_ft1} =  Create List
    ...  ${nature_travaux1ft1.famille_travaux} / ${nature_travaux1ft1.libelle}
    ...  ${nature_travaux2ft1.famille_travaux} / ${nature_travaux2ft1.libelle}
    ...  ${nature_travaux3ft1.famille_travaux} / ${nature_travaux3ft1.libelle}
    ...  ${nature_travaux4ft1.famille_travaux} / ${nature_travaux4ft1.libelle}
    ...  ${nature_travaux5ft1.famille_travaux} / ${nature_travaux5ft1.libelle}
    ...  ${nature_travaux6ft1.famille_travaux} / ${nature_travaux6ft1.libelle}
    ...  ${nature_travaux7ft1.famille_travaux} / ${nature_travaux7ft1.libelle}
    ...  ${nature_travaux8ft1.famille_travaux} / ${nature_travaux8ft1.libelle}
    ...  ${nature_travaux9ft1.famille_travaux} / ${nature_travaux9ft1.libelle}
    ...  ${nature_travaux10ft1.famille_travaux} / ${nature_travaux10ft1.libelle}
    ...  ${nature_travaux11ft1.famille_travaux} / ${nature_travaux11ft1.libelle}
    ...  ${nature_travaux1ft2.famille_travaux} / ${nature_travaux1ft2.libelle}
    ...  ${nature_travaux2ft2.famille_travaux} / ${nature_travaux2ft2.libelle}
    Sort List  ${nature_travaux_di_ft1}
    ${expected_tooltip_value}=  catenate  SEPARATOR=\n  @{nature_travaux_di_ft1}
    ${title} =  Get Element Attribute  css=.tab-data a.lienTable span  title
    # Saut de ligne en plus dans le title qui doit être enlevé pour que la comparaison soit correct
    ${title} =  Strip String  ${title}
    Should Be Equal  ${title}  ${expected_tooltip_value}

    # di_avec_nt_ft1 contient les nature de travaux de la famille 1 et 2
    Element Should Contain  css=.tab-data
    ...  ${di_avec_nt_ft1}

    Element Should Not Contain  css=.tab-data
    ...  ${di_avec_nt_ft3}

    Element Should Not Contain  css=.tab-data
    ...  ${di_sans_nt}

    # On ajoute une nature de travaux présent dans l'autre dossier
    @{nature_travaux_di_ft3} =  Create List
    ...  ${nature_travaux11ft1.famille_travaux} / ${nature_travaux11ft1.libelle}
    Modifier le dossier d'instruction  ${di_avec_nt_ft3}  ${value_di}  nature_travaux=${nature_travaux_di_ft3}

    # Filtrage nature de travaux
    Depuis le listing  dossier_instruction
    ${param_advs} =  Create Dictionary
    ...  nature_travaux=${nature_travaux11ft1.libelle}
    Saisir les parametres de recherche avancé du dossier d'instruction  ${param_advs}
    Click On Search Button

    Wait Until Element Contains  css=div.pagination-nb  1 - 2

    # On doit trouver les deux dossier qui possède la nature de travaux
    Element Should Contain  css=.tab-tab
    ...  ${di_avec_nt_ft1}

    Element Should Contain  css=.tab-tab
    ...  ${di_avec_nt_ft3}

    Element Should Not Contain  css=.tab-tab
    ...  ${di_sans_nt}

    # Export csv d'un listing filtré par nature de travaux
    ${link_export_listing}=  Get Element Attribute  css=.tab-export a  href
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link_export_listing}  ${EXECDIR}${/}binary_files${/}
    La page ne doit pas contenir d'erreur

    # Récupération du contenu du fichier pour vérifier les champs affiché.
    # Vérifie que les champs "Id Plat'AU du service consultant" et
    # "libellé du service consultant" ne sont pas présent
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    ${content_file} =  Get File  ${full_path_to_file}
    ${header_csv_file} =  Set Variable  dossier;pétitionnaire;correspondant;"architecte (nom)";"architecte (cabinet)";localisation;nature;"nombre de logements créés";"surface créée";"famille de travaux";"nature de travaux";"description du projet";"date de dépôt";"date de complétude";"date limite";instructeur;division;état;enjeu;collectivité;"dossier plat'au";"consultation plat'au";"pièce(s) plat'au";"autres objets plat'au"
    Should Contain  ${content_file}  ${header_csv_file}
    # Vérification du contenu du csv pour les 2 lignes filtrées
    # Famille travaux ligne 1
    Should Contain  ${content_file}  Ravalement, Restauration
    # Famille travaux ligne 2
    Should Contain  ${content_file}  Ravalement, Transformation
    # Famille travaux ligne 1
    Should Contain  ${content_file}  Ravalement d'établissement privé 10, Restauration de façade privé, Restauration de façade public
    # Famille travaux ligne 2
    Should Contain  ${content_file}  Ravalement d'établissement privé, Ravalement d'établissement privé 10, Ravalement d'établissement privé 2, Ravalement d'établissement privé 3, Ravalement d'établissement privé 4, Ravalement d'établissement privé 5, Ravalement d'établissement privé 6, Ravalement d'établissement privé 7, Ravalement d'établissement privé 8, Ravalement d'établissement privé 9, Ravalement d'établissement public, Transformation de façade privé, Transformation de façade public

Vérification de la conservation des natures de travaux lors de l'ajout de dossier sur existant
    [Documentation]  Si la nature de travaux est compatible avec le type de dossier d'instruction sur existant
    ...  exemple : DAACT. Alors la nature de travaux doit apparaître sur le nouveau dossier.

    Depuis la page d'accueil  admin  admin

    # On clôture le dossier initial
    Ajouter une instruction au DI et la finaliser  ${di_avec_nt_ft1}  accepter un dossier sans réserve
    # On ajout un dossier sur existant DAACT
    # Seul les natures de travaux de la famille 2 sont compatibles (cf Constitution du jeu de données)
    Go To Submenu In Menu  guichet_unique  autre-dossier
    Rechercher et créer une demande sur dossier existant  ${di_avec_nt_ft1}
    Select From List By Label  om_collectivite  MARSEILLE
    Select From List By Label  demande_type  Déclaration attestant l'achèvement et la conformité des travaux
    Click On Submit Button
    # On accède au dossier
    Click Element  css=#link_demande_dossier_instruction
    ${id_di_daact} =  Get Text  css=#dossier_libelle

    Element Should Contain  css=div.field-type-select_multiple_static div.form-content  Transformation / Transformation de façade public
    Element Should Contain  css=div.field-type-select_multiple_static div.form-content  Transformation / Transformation de façade privé

    @{nature_travaux_di_ft2} =  Create List
    ...  ${nature_travaux1ft2.famille_travaux} / ${nature_travaux1ft2.libelle}
    ...  ${nature_travaux2ft2.famille_travaux} / ${nature_travaux2ft2.libelle}

    Click On Portlet Action  dossier_instruction  modifier
    Unselect From Multiple Chosen List  nature_travaux  ${nature_travaux_di_ft2}
    Select Multiple From Chosen List Should Contain List  nature_travaux  ${nature_travaux_di_ft2}

    @{not_nature_travaux_di} =  Create List
    ...  ${nature_travaux1ft1.famille_travaux} / ${nature_travaux1ft1.libelle}
    ...  ${nature_travaux2ft1.famille_travaux} / ${nature_travaux2ft1.libelle}
    ...  ${nature_travaux3ft1.famille_travaux} / ${nature_travaux3ft1.libelle}
    ...  ${nature_travaux4ft1.famille_travaux} / ${nature_travaux4ft1.libelle}
    ...  ${nature_travaux5ft1.famille_travaux} / ${nature_travaux5ft1.libelle}
    ...  ${nature_travaux6ft1.famille_travaux} / ${nature_travaux6ft1.libelle}
    ...  ${nature_travaux7ft1.famille_travaux} / ${nature_travaux7ft1.libelle}
    ...  ${nature_travaux8ft1.famille_travaux} / ${nature_travaux8ft1.libelle}
    ...  ${nature_travaux9ft1.famille_travaux} / ${nature_travaux9ft1.libelle}
    ...  ${nature_travaux10ft1.famille_travaux} / ${nature_travaux10ft1.libelle}
    ...  ${nature_travaux11ft1.famille_travaux} / ${nature_travaux11ft1.libelle}
    ...  ${nature_travaux1ft3.famille_travaux} / ${nature_travaux1ft3.libelle}
    ...  ${nature_travaux2ft3.famille_travaux} / ${nature_travaux2ft3.libelle}
    Select Multiple From Chosen List Should Not Contain List  nature_travaux  ${not_nature_travaux_di}
    Select From Multiple Chosen List  nature_travaux  ${nature_travaux_di_ft2}
    # On clôture la DAACT
    Ajouter une instruction au DI et la finaliser  ${id_di_daact}  accepter un dossier sans réserve

    # Sur un autre type de dossier il ne doit pas y avoir de natures de travaux ajoutées
    Go To Submenu In Menu  guichet_unique  autre-dossier
    Rechercher et créer une demande sur dossier existant  ${id_di_daact}
    Select From List By Label  om_collectivite  MARSEILLE
    Select From List By Label  demande_type  Demande d'ouverture de chantier
    Click On Submit Button
    Click Element  css=#link_demande_dossier_instruction
    ${id_di_doc} =  Get Text  css=#dossier_libelle

    Page Should Not Contain  css=div.field-type-select_multiple_static div.form-content
    Page Should Not Contain  css=div.field-type-select_multiple_static div.form-content

    # On clôture la DOC
    Ajouter une instruction au DI et la finaliser  ${id_di_doc}  ARRÊTÉ DE REFUS
    Depuis l'instruction du dossier d'instruction  ${id_di_doc}  ARRÊTÉ DE REFUS
    # On saisi la date de retour AR depuis le formulaire de l'instruction
    Click On SubForm Portlet Action  instruction  modifier_suivi
    Input Datepicker  date_retour_rar  ${date_ddmmyyyy}
    Click On Submit Button In Subform
    Click On Back Button In Subform

    # On refait un ajout sur existant DAACT pour vérifier qu'on prend bien les données du dernier dossier clôturé
    Go To Submenu In Menu  guichet_unique  autre-dossier
    Rechercher et créer une demande sur dossier existant  ${id_di_daact}
    Select From List By Label  om_collectivite  MARSEILLE
    Select From List By Label  demande_type  Déclaration attestant l'achèvement et la conformité des travaux
    Click On Submit Button
    # On accède au dossier
    Click Element  css=#link_demande_dossier_instruction
    ${id_di_daact_2} =  Get Text  css=#dossier_libelle

    # Les natures de travaux de la première DAACT ne doivent pas apparaître au départ
    Page Should Not Contain  css=div.field-type-select_multiple_static div.form-content
    Page Should Not Contain  css=div.field-type-select_multiple_static div.form-content

    # On vérifie qu'elles sont bien disponibles
    Click On Portlet Action  dossier_instruction  modifier
    Select Multiple From Chosen List Should Contain List  nature_travaux  ${nature_travaux_di_ft2}

    &{famille_travaux2_modif} =  Create Dictionary
    ...  om_validite_debut=${avant_hier}
    ...  om_validite_fin=${hier}
    Modifier la famille de travaux  ${famille_travaux2.id}  ${famille_travaux2_modif}

    Depuis le contexte du dossier d'instruction  ${id_di_daact_2}
    Click On Portlet Action  dossier_instruction  modifier
    Select Multiple From Chosen List Should Not Contain List  nature_travaux  ${nature_travaux_di_ft2}
