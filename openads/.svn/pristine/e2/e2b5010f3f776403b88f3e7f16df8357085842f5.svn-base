*** Settings ***
Documentation  Test des traitements relatifs à la transmission des tâches, en output, vers plat'AU

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Variables ***
${alternate_filestorage}  filestorage_plop

*** Test Cases ***
Préparation du jeu de données
    [Documentation]  Rend les dossiers de type PCI transmissible à plat'AU.

    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}

Échappement des **\** dans la payload transmise à plat'AU
    [Documentation]  Ajoute un nouveau dossier de type PCI.
    ...  Rempli dans le cerfa du dossier :
    ...     - la date et lieu d'engagement du déclarant (pour le rendre transmissible)
    ...     - la description des travaux en y intégrant des retours à la ligne
    ...  Depuis le menu, Administration > Moniteur Plat'AU, vérifie que les tâches
    ...  liées au dossier existe.
    ...  Réalise l'envoie de la tâche et vérifie que dans la payload les "\n" sont bien
    ...  échapper en "\\n"

    # Création du dossier
    &{args_demande_auto} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_adresse_localite=300_01_task_output_01
    &{args_petitionnaire_auto} =  Create Dictionary
    ...  particulier_nom=300_01_task_output_01
    ...  particulier_prenom=escape_backslash
    ...  om_collectivite=MARSEILLE
    ...  localite=300_01_task_output_01
    ${di} =  Ajouter la demande par WS  ${args_demande_auto}  ${args_petitionnaire_auto}

    # Remplissage du cerfa du dossier
    # le KW de remplissage des données technique n'a pas pu être utilisé car la message contenant
    # des \n casse la condition de vérification du type de champs à remplir.
    # A la place les différentes étapes sont réalisées une par une.
    Depuis le contexte du dossier d'instruction  ${di}
    Click On Form Portlet Action  dossier_instruction  donnees_techniques  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Element Should Be Visible  css=#action-sousform-donnees_techniques-modifier
    Click On SubForm Portlet Action  donnees_techniques  modifier
    Open All Fieldset Using Javascript  donnees_techniques  sousform
    Input Text  css=#enga_decla_lieu  300_01_task_output_01
    Input Text  css=#enga_decla_date  ${date_ddmmyyyy}
    Input Text  css=#ope_proj_desc  Projet de construction\n\nvisant à tester\n\nle fonctionnement de l'échappement des anti-slash
    Click On Submit Button In Subform
    Wait Until Keyword Succeeds     ${TIMEOUT}     ${RETRY_INTERVAL}    Valid Message Should Be  Vos modifications ont bien été enregistrées.
    La page ne doit pas contenir d'erreur

    # Vérification de la création des tâches
    ${di_sans_espace} =  Sans espace  ${di}
    &{task_values} =  Create Dictionary
    ...  type=creation_DI
    ...  dossier=${di_sans_espace}
    ...  state=new
    ...  object_id=${di_sans_espace}
    ...  link_dossier=${di_sans_espace}
    ...  stream=output
    Vérifier que la tâche a bien été ajoutée ou modifiée  ${task_values}

    # Validation de la payload de sortie
    ${task_id} =  Get Text  css=#task
    Vérifier que la tâche renvoie payload fonctionnelle  ${task_id}

Réinitialisation du jeu de données
    [Documentation]  Rend les dossiers de type PCI non transmissible à plat'AU.

    Depuis la page d'accueil  admin  admin
    &{args_type_DA_detaille_modification} =  Create Dictionary
    ...  dossier_platau=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${args_type_DA_detaille_modification}
