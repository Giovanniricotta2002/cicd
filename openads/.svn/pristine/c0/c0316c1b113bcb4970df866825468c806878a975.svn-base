*** Settings ***
Documentation  Test l'affichage des pièces sur le dossier d'autorisation selon le paramétrage du secret d'instruction.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Jeu de données
    [Documentation]  Création du jeu de données nécessaire pour la suite des tests.
    ...  Création d'un dossier cloturés avec 1 pièces et création d'un dossier non
    ...  cloturé avec 1 autre pièce et rattaché au même DA.

    Depuis la page d'accueil  admin  admin

    # Identifiant des pièces
    Set Suite Variable  ${piece_visible}  arrêté d'annulation
    Set Suite Variable  ${piece_secrete}  rapport modificatif

    # Création du premier dossier, ajout d'une pièce et ajout d'une instruction pour le cloturer
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Secret
    ...  particulier_prenom=Instruction
    ...  om_collectivite=MARSEILLE
    ${di} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=testImportManuel.pdf
    ...  date_creation=01/01/2023
    ...  document_numerise_type=${piece_visible}
    Saisir et valider le formulaire d'ajout d'une pièce sur le dossier d'instruction  ${di}  ${document_numerise_values}


    Ajouter une instruction au DI et la finaliser  ${di}  accepter un dossier sans réserve

    # Création d'un nouveau dossier rattaché au même DA et ajout d'une autre pièce
    &{args_demande} =  Create Dictionary
    ...  demande_type=Demande de modification
    ...  dossier_instruction=${di}
    ${di_modif} =  Ajouter la demande par WS  ${args_demande}

    &{document_numerise_values} =  Create Dictionary
    ...  uid_upload=test_trouillotage_pdf.pdf
    ...  date_creation=01/02/2023
    ...  document_numerise_type=${piece_secrete}
    Saisir et valider le formulaire d'ajout d'une pièce sur le dossier d'instruction  ${di_modif}  ${document_numerise_values}

    # Set les variables nécessaire pour la suite du test
    # Numéro du DA
    ${da} =  Replace String Using Regexp  ${di}  [A-Z][0-9]+$  ${EMPTY}
    Set Suite Variable  ${da}


Activation du secret d'instruction
    [Documentation]  Active le secret d'instruction pour les PCI

    Depuis la page d'accueil  admin  admin
    &{value} =  Create Dictionary
    ...  secret_instruction=true
    Modifier type de dossier d'autorisation détaillé  PCI  ${value}


Restriction d'accès aux pièces des DA
    [Documentation]  Sur un DA dont secret d'instruction est actif, les pièces des DI
    ...  non cloturé ne doivent pas être visible pour les profils n'ayant pas le droit
    ...  dossier_autorisation_secret_instruction.
    ...  Les profils ayant ce droit peuvent voir toutes les pièces du dossier.
    ...  Si le secret d'instruction n'est pas actif les utilisateurs peuvent voir toutes les
    ...  pièces du dossier quel que soit leur profil.

    # Cas 1 : secret d'instruction actif et utilisateur n'ayant pas le droit dossier_autorisation_secret_instruction
    #  => Les pièces du dossier non cloturé ne doivent pas être visible
    Depuis la page d'accueil  visuda  visuda
    Depuis l'onglet des pièces du dossier d'autorisation  ${da}
    Wait Until Page Contains  ${piece_visible}
    Element Should Not Contain  css=div#sousform-document_numerise  rapport modificatif
    # Vérifie que l'utilisateur peut visualiser les pièces
    Le document numerise contiens  arrêté d'annulation  TEST IMPORT MANUEL 1

    # Cas 2 : secret d'instruction actif et utilisateur ayant le droit dossier_autorisation_secret_instruction
    #  => Les pièces de tous les DI du DA doivent etre visible
    # Ajout du droit au profil instructeur
    Depuis la page d'accueil  admin  admin
    Ajouter le droit depuis le menu si il n'existe pas  dossier_autorisation_secret_instruction  INSTRUCTEUR
    # Test de l'affichage des pièces
    Depuis la page d'accueil  instr  instr
    Depuis l'onglet des pièces du dossier d'autorisation  ${da}
    Wait Until Page Contains  ${piece_visible}
    Element Should Contain  css=div#sousform-document_numerise  ${piece_secrete}
    # Vérifie que l'utilisateur peut visualiser les pièces
    Le document numerise contiens  ${piece_visible}  TEST IMPORT MANUEL 1
    Le document numerise contiens  ${piece_secrete}  TEST TROUILLOTAGE PDF

    # Suppression du droit pour ne pas impacter le reste des tests
    Depuis la page d'accueil  admin  admin
    Supprimer le droit depuis le contexte du profil  dossier_autorisation_secret_instruction  INSTRUCTEUR


Desactivation du secret d'instruction
    [Documentation]  Désactive le secret d'instruction pour les PCI

    Depuis la page d'accueil  admin  admin
    &{value} =  Create Dictionary
    ...  secret_instruction=false
    Modifier type de dossier d'autorisation détaillé  PCI  ${value}