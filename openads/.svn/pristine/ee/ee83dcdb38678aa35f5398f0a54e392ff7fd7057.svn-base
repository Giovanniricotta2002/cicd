*** Settings ***
Documentation  Test des fonctionnalités liées au paramétrage des instructeurs

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
Filtrage de la liste des instructeurs selon la collectivite d'appartenance de l'utilisateur
    [Documentation]  Vérifie les cas d'usage suivant :
    ...  - En tant qu'administrateur de la collectivité Allauch, depuis le menu Paramétrage > Instructeur,
    ...  je peux voir uniquement les instructeurs rattachés à Allauch.
    ...  - En tant qu'administrateur de la collectivité de niveau 2, depuis le menu Paramétrage > Instructeur,
    ...  j'ai accès à la liste de tous les instructeurs paramétrés quelle que soit leur collectivité.

    Depuis la page d'accueil  admin  admin
    # Création d'un admingen pour la collectivité d'Allauch
    Ajouter l'utilisateur depuis le menu  Al Lauch  support@atreal.fr  admingenallauch  admingenallauch  ADMINISTRATEUR GENERAL  ALLAUCH
    # Ajout d'un instructeur pour Marseille et d'un instructeur pour Allauch
    Ajouter l'utilisateur depuis le menu  allauch_instr  support@atreal.fr  instr_allauch  instr_allauch  INSTRUCTEUR POLYVALENT COMMUNE  ALLAUCH
    Ajouter l'instructeur depuis le menu  okAllauchOkAgglo  subdivision L  instructeur  allauch_instr

    Ajouter l'utilisateur depuis le menu  marseille_instr  support@atreal.fr  isntr_marseille  isntr_marseille  INSTRUCTEUR POLYVALENT COMMUNE  MARSEILLE
    Ajouter l'instructeur depuis le menu  koAllauchOkAgglo  subdivision H  instructeur  marseille_instr
    
    # Connexion en tant qu'admin de la collectivité ALLAUCH et vérification que seul l'instructeur
    # de cette collectivité existe
    Depuis la page d'accueil  admingenallauch  admingenallauch
    Depuis le tableau des instructeurs
    Use Simple Search    Utilisateur    allauch_instr
    Wait Until Page Contains  okAllauchOkAgglo
    Use Simple Search    Utilisateur    marseille_instr
    Wait Until Page Contains  Aucun enregistrement.

    # Connexion en tant qu'admin de l'agglo et vérification que des instructeurs de MARSEILLE et
    # d'ALLAUCH sont visibles
    Depuis la page d'accueil  admin  admin
    Depuis le tableau des instructeurs
    Use Simple Search    Utilisateur    allauch_instr
    Wait Until Page Contains  okAllauchOkAgglo
    Use Simple Search    Utilisateur    marseille_instr
    Wait Until Page Contains  koAllauchOkAgglo

    # Suppression des instructeurs et utilisateurs pour ne pas impacter les tests suivants
    Supprimer instructeur  okAllauchOkAgglo
    Supprimer instructeur  koAllauchOkAgglo
    
    Supprimer l'utilisateur  Al Lauch
    Supprimer l'utilisateur  allauch_instr
    Supprimer l'utilisateur  marseille_instr
    