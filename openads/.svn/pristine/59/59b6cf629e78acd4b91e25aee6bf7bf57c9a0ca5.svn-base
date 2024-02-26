*** Settings ***
Documentation  Test du portail citoyen.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
SFPC01 Dépôt initial d'un dossier puis édition du récépissé

    [Documentation]  Ajoute une demande et vérifie la génération de la clé
    ...  d'accès au portail citoyen ainsi que son affichage sur le dossier
    ...  d'instruction et sur le récépissé de dépôt.

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Goguen
    ...  particulier_prenom=Victor
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  guichet  guichet
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie le fil d'Ariane
    Page Title Should Be    Instruction > Dossiers D'instruction > ${di} GOGUEN VICTOR
    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'est pas vide
    Open Fieldset    dossier_instruction    demandeur
    # On récupère la valeur du champ contenant la clé d'accès au portail citoyen
    Wait Until Element Is Visible  cle_acces_citoyen
    ${citizen_access_key} =  Get Text  cle_acces_citoyen
    Should Not Be Empty  ${citizen_access_key}

    # On régénère le récépissé de demande
    Click On Form Portlet Action  dossier_instruction  recepisse  message  Le récépissé de la demande a été régénéré.
    # On ouvre le PDF
    Click Link  css=#telecharger_recepisse
    #
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie que le texte affiché correspond aux paramétres
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Vous pouvez consulter directement votre dossier par internet à l'adresse
    Page Should Contain  https://citoyen.atreal.fr/marseille/ads/ et en saisissant votre numéro de dossier ainsi
    Page Should Contain  que la clé d'accès ${citizen_access_key}.
    # On ferme le PDF
    Close PDF


SFPC02 Dépôt d'un modificatif

    [Documentation]  Ajoute une demande sans l'option de portail citoyen activée pour
    ...  créer un dossier sans clé générée. Sur ce dossier on ajoute une demande de
    ...  modificatif en activant l'option. La clé d'accès au portail citoyen doit être
    ...  générée.

    #
    Depuis la page d'accueil  admin  admin
    # On désactive l'option pour ajouter un dossier sans clé d'accès au portail citoyen
    Modifier le paramètre  option_portail_acces_citoyen  false  agglo

    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Moquin
    ...  particulier_prenom=Laurent
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie le fil d'Ariane
    Page Title Should Be    Instruction > Dossiers D'instruction > ${di} MOQUIN LAURENT
    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'existe pas
    Open Fieldset    dossier_instruction    demandeur
    Page Should Not Contain Element  cle_acces_citoyen

    #
    Depuis la page d'accueil  instr  instr
    #
    Ajouter une instruction au DI  ${di}  accepter un dossier sans réserve

    #
    Depuis la page d'accueil  admin  admin
    # On active l'option pour ajouter un dossier avec clé d'accès au portail citoyen
    Modifier le paramètre  option_portail_acces_citoyen  true  agglo

    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di}
    #
    ${di_modif} =  Ajouter la demande par WS  ${args_demande}
    # ON va sur le DI
    Depuis le contexte du dossier d'instruction  ${di_modif}
    # On vérifie le fil d'Ariane
    Page Title Should Be    Instruction > Dossiers D'instruction > ${di_modif} MOQUIN LAURENT
    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'est pas vide
    Open Fieldset    dossier_instruction    demandeur
    Wait Until Element Is Visible  cle_acces_citoyen
    ${citizen_access_key} =  Get Text  cle_acces_citoyen
    Should Not Be Empty  ${citizen_access_key}

    # On régénère le récépissé de demande
    Click On Form Portlet Action  dossier_instruction  recepisse  message  Le récépissé de la demande a été régénéré.
    # On ouvre le PDF
    Click Link  css=#telecharger_recepisse
    #
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie que le texte affiché correspond aux paramétres
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Vous pouvez consulter directement votre dossier par internet à l'adresse
    Page Should Contain  https://citoyen.atreal.fr/marseille/ads/ et en saisissant votre numéro de dossier ainsi
    Page Should Contain  que la clé d'accès ${citizen_access_key}.
    # On ferme le PDF
    Close PDF


SFPC03 Génération de la lettre d'information

    [Documentation]  Ajoute une demande et vérifie que la clé a été associée au DA, puis
    ...  ajoute l'instruction "Générer une lettre d'information accès citoyen" et édite
    ...  la lettre type, en vérifiant qu'elle contient bien la clé et le texte d'invite.
    ...  On désactive ensuite l'option portail citoyen et on contrôlé que le texte
    ...  d'invite n'est pas présent dans la lettre d'information.

    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Allaire
    ...  particulier_prenom=Jeoffroi
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    #
    ${di} =  Ajouter la nouvelle demande depuis le tableau de bord  ${args_demande}  ${args_petitionnaire}

    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie le fil d'Ariane
    Page Title Should Be    Instruction > Dossiers D'instruction > ${di} ALLAIRE JEOFFROI
    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'est pas vide
    Open Fieldset    dossier_instruction    demandeur
    Wait Until Element Is Visible  cle_acces_citoyen
    ${citizen_access_key} =  Get Text  cle_acces_citoyen
    Should Not Be Empty  ${citizen_access_key}

    Depuis la page d'accueil  instr  instr
    Ajouter une instruction au DI et la finaliser  ${di}  Lettre d'information d'accès citoyen
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La finalisation du document s'est effectuée avec succès.
    # On ouvre le PDF
    Click On SubForm Portlet Action  instruction  edition  new_window
    #
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie que le texte affiché correspond aux paramétres
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Vous pouvez consulter directement votre dossier par internet à l'adresse https://citoyen.atreal.fr/marseille/ads/ et en
    Page Should Contain  saisissant votre numéro de dossier ainsi que la clé d'accès ${citizen_access_key}.
    Close PDF

    #
    Depuis la page d'accueil  admin  admin
    # On désactive l'option pour vérifier que le contenu de la lettre type
    Modifier le paramètre  option_portail_acces_citoyen  false  agglo

    Depuis la page d'accueil  instr  instr
    Depuis l'instruction du dossier d'instruction  ${di}  Lettre d'information d'accès citoyen
    # On définalise et finalise l'événement pour régénérer la lettre d'information
    Click On SubForm Portlet Action  instruction  definaliser
    Click On SubForm Portlet Action  instruction  finaliser
    # On ouvre le PDF
    Click On SubForm Portlet Action  instruction  edition  new_window
    Open PDF  ${OM_PDF_TITLE}
    # Le texte d'invite ne doit plus être présent
    Sleep  1
    Page Should Not Contain  Vous pouvez consulter directement votre dossier par internet à l'adresse https://citoyen.atreal.fr/marseille/ads/ et en
    Page Should Not Contain  saisissant votre numéro de dossier ainsi que la clé d'accès ${citizen_access_key}.
    Close PDF


SFPC04 Générer la clé d'accès

    [Documentation]  Ajoute une demande sans l'option de portail citoyen activée
    ...  pour créer un dossier sans clé générée. Sur ce dossier on utilise
    ...  l'action de génération de la clé, puis on ajoute l'événement
    ...  d'instruction permettant d'afficher les informations de connexion.

    #
    Depuis la page d'accueil  admin  admin
    # On désactive l'option pour ajouter un dossier sans clé
    Modifier le paramètre  option_portail_acces_citoyen  false  agglo

    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Patry
    ...  particulier_prenom=Rachelle
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    #
    Depuis la page d'accueil  admin  admin
    # On active l'option pour ajouter un dossier avec clé
    Modifier le paramètre  option_portail_acces_citoyen  true  agglo

    #
    Depuis la page d'accueil  instr  instr
    #
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie que le champ contenant la clé d'accès au portail citoyen est vide
    Open Fieldset    dossier_instruction    demandeur
    ${citizen_access_key} =  Get Text  cle_acces_citoyen
    Should Be Empty  ${citizen_access_key}
    # On vérifie que l'action générer est présente
    Portlet Action Should Be In Form  dossier_instruction  generate_citizen_access_key

    # On clic sur l'action "Générer la clé d'accès"
    Click On Form Portlet Action  dossier_instruction  generate_citizen_access_key
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La clé d'accès au portail citoyen a été générée.
    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'est
    # plus vide
    Open Fieldset    dossier_instruction    demandeur
    Wait Until Element Is Visible  cle_acces_citoyen
    ${citizen_access_key} =  Get Text  cle_acces_citoyen
    Should Not Be Empty  ${citizen_access_key}
    # On vérifie que l'action générer n'est pas présente
    Portlet Action Should Not Be In Form  dossier_instruction  generate_citizen_access_key

    #
    Ajouter une instruction au DI et la finaliser  ${di}  Lettre d'information d'accès citoyen
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La finalisation du document s'est effectuée avec succès.
    # On ouvre le PDF
    Click On SubForm Portlet Action  instruction  edition  new_window
    #
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie que le texte affiché correspond aux paramétres
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Vous pouvez consulter directement votre dossier par internet à l'adresse https://citoyen.atreal.fr/marseille/ads/ et en
    Page Should Contain  saisissant votre numéro de dossier ainsi que la clé d'accès ${citizen_access_key}.
    # On ferme le PDF
    Close PDF


SFPC05 Régénération de la clé d'accès

    [Documentation]  Ajoute une demande et vérifie qu'une clé a été associée au DA, puis
    ...  utilise le bouton "Regénérer la clé d'accès". On contrôle qu'une nouvelle clé soit
    ...  affichée sur le DI et que l'instructeur ne voit pas le bouton regénérer la clé.
    ...  Ensuite on ajoute l'instruction "Générer une lettre d'information" et on vérifie
    ...  le contenu de l'édition.

    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Leduc
    ...  particulier_prenom=Gaston
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie le fil d'Ariane
    Page Title Should Be    Instruction > Dossiers D'instruction > ${di} LEDUC GASTON
    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'est pas vide
    Open Fieldset    dossier_instruction    demandeur
    # On récupère la valeur du champ contenant la clé d'accès au portail citoyen
    Wait Until Element Is Visible  cle_acces_citoyen
    ${citizen_access_key} =  Get Text  cle_acces_citoyen
    Should Not Be Empty  ${citizen_access_key}

    Depuis la page d'accueil  admingen  admingen
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  regenerate_citizen_access_key  modale
    # On valide la confirmation
    Click Element  css=div.ui-dialog-buttonset button
    Sleep  3
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La clé d'accès au portail citoyen a été régénérée.

    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'est pas vide
    Open Fieldset    dossier_instruction    demandeur
    Wait Until Element Is Visible  cle_acces_citoyen
    ${citizen_access_key_new} =  Get Text  cle_acces_citoyen
    Should Not Be Empty  ${citizen_access_key}
    Should Not Be Equal  ${citizen_access_key}  ${citizen_access_key_new}

    Depuis la page d'accueil  instr  instr

    Depuis le contexte du dossier d'instruction  ${di}
    # L'instructeur ne doit pas pouvoir regénérer la clé d'accès
    Portlet Action Should Not Be In Form  dossier_instruction  regenerate_citizen_access_key

    Ajouter une instruction au DI et la finaliser  ${di}  Lettre d'information d'accès citoyen
    # On vérifie le message de validation
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  La finalisation du document s'est effectuée avec succès.
    # On ouvre le PDF
    Click On SubForm Portlet Action  instruction  edition  new_window
    #
    Open PDF  ${OM_PDF_TITLE}
    # On vérifie que le texte affiché correspond aux paramétres
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Page Should Contain  Vous pouvez consulter directement votre dossier par internet à l'adresse https://citoyen.atreal.fr/marseille/ads/ et en
    Page Should Contain  saisissant votre numéro de dossier ainsi que la clé d'accès ${citizen_access_key_new}.
    Close PDF


SFPC06 Accès au portail citoyen

    [Documentation]  Vérifie l'accès au portail citoyen par un utilisateur
    ...  anonyme. Sont testés les différents cas d'erreur et les informations
    ...  affichées en cas de succès. Contrôle que l'accès anonyme ne permet pas d'accéder
    ...  à openADS.

    #
    Depuis la page d'accueil  guichet  guichet
    #
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Hervé
    ...  particulier_prenom=Marguerite
    ...  om_collectivite=MARSEILLE
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    #
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Depuis le contexte du dossier d'instruction  ${di}
    # On vérifie le fil d'Ariane
    Page Title Should Be    Instruction > Dossiers D'instruction > ${di} HERVÉ MARGUERITE
    # On vérifie que le champ contenant la clé d'accès au portail citoyen n'est pas vide
    Open Fieldset    dossier_instruction    demandeur
    Wait Until Element Is Visible  cle_acces_citoyen
    ${citizen_access_key} =  Get Text  cle_acces_citoyen
    Should Not Be Empty  ${citizen_access_key}
    # Formatage de la clé d'accès sans les tirets
    ${citizen_access_key} =  STR_REPLACE  -  ${EMPTY}  ${citizen_access_key}

    # On récupère le numéro du DA
    ${da} =  Get Substring  ${di}  0  -2

    # On se déconnecte
    Go To    ${PROJECT_URL}
    Se déconnecter

    # On ouvre la page d'accueil du portail
    Go To    http://localhost/openads/web/citizen.php
    La page ne doit pas contenir d'erreur
    # On vérifie que les champs de saisis sont visible
    Page Should Contain Element  css=#dossier
    Page Should Contain Element  css=#cle_acces_citoyen_split1
    # On vérifie qu'un champ timestamp caché est présent
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Page Should Contain Element  css=#timestamp_generation_formulaire

    # On saisit seulement le numéro du dossier
    Input Text    css=#dossier    ${di}
    Input Text    css=#cle_acces_citoyen_split1    ${EMPTY}
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=.formulaire div.formControls input[type="submit"]
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Contain  css=div.alert-danger  Tous les champs doivent être remplis.

    # On saisit seulement le numéro du dossier
    Input Text    css=#dossier    ${EMPTY}
    Input Text    css=#cle_acces_citoyen_split1    ${citizen_access_key}
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=.formulaire div.formControls input[type="submit"]
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Contain  css=div.alert-danger  Tous les champs doivent être remplis.

    # On tente une injection SQL
    Input Text    css=#dossier    ';zgz'';"abcdef';'"
    Input Text    css=#cle_acces_citoyen_split1    ';zgz'';"abcdef';'"

    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Form Value Should Be    css=#cle_acces_citoyen_complete    ';zg-z'';-"abc-def'

    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=.formulaire div.formControls input[type="submit"]
    # On vérifie que l'injection SQL ne produit pas d'erreur de base de données.
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Contain  css=div.alert-danger  Le numéro de dossier ou la clé d'accès n'est pas valide.

    # On saisit seulement le numéro du dossier
    Input Text    css=#dossier    ${da}
    Input Text    css=#cle_acces_citoyen_split1    ${citizen_access_key}

    # On modifie le timestamp pour ajouter 5 minutes
    ${timestamp_generation_formulaire} =  Get Mandatory Value  css=#timestamp_generation_formulaire
    ${timestamp_generation_formulaire} =  Convert to Integer  ${timestamp_generation_formulaire}
    ${timestamp_generation_formulaire} =  Evaluate  ${timestamp_generation_formulaire}-300
    Execute Javascript  document.getElementById("timestamp_generation_formulaire").value = '${timestamp_generation_formulaire}';
    Sleep  1
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=.formulaire div.formControls input[type="submit"]
    # On vérifie le message affiché à l'utilisateur
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Element Should Contain  css=div.alert-danger  Le formulaire a expiré. Veuillez recharger la page.

    # On saisit seulement le numéro du dossier
    Input Text    css=#dossier    ${da}
    Input Text    css=#cle_acces_citoyen_split1    ${citizen_access_key}
    # On valide le formulaire
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Click Element  css=.formulaire div.formControls input[type="submit"]
    # On attend le message de validation, qu'il soit correct ou renvoie une erreur.
    La page ne doit pas contenir d'erreur
    # On vérifie le numéro du DI et du DA
    Page Should Contain  ${di}
    Page Should Contain  ${da}

    # Vérifie que l'accès anonyme ne permet pas d'être loggué sur openADS
    Depuis la page de login
