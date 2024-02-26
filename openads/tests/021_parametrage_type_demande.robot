*** Settings ***
Documentation    Test le fonctionnement des écrans du menu Paramétrage Dossiers > Demande > Type
# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown


*** Test Cases ***
Ajout d'un nouveau type de demande
    [Documentation]  Avec un profil administrateur, depuis le menu Paramétrage Dossier > Demandes > Type,
    ...  je clique sur la croix verte pour accéder au formulaire d'ajout de ma demande.
    ...  Je remplis mon formulaire et lorsque je le valide ma demande est créée.
    ...  Depuis le listing des types de demande, mon nouveau type de demande est maintenant visible.

    Depuis la page d'accueil  admin  admin
    &{args_demande_type} =  Create Dictionary
    ...    code=TEST021
    ...    libelle=TEST_021
    ...    groupe=Autorisation ADS
    ...    dossier_autorisation_type_detaille=PCA (Permis de construire comprenant ou non des démolitions)
    ...    demande_nature=Nouveau dossier
    ...    dossier_instruction_type=PCA - Initial
    ...    evenement=Notification de delai
    Ajouter un nouveau type de demande depuis le menu    ${args_demande_type}
    Set Suite Variable  ${libelle_demande}  ${args_demande_type.libelle}
    Set Suite Variable  ${code_demande}  ${args_demande_type.code}

    Depuis le tableau des types de demandes
    Use Simple Search  code  ${code_demande}
    Element Should Contain  css=table.tab-tab  ${libelle_demande}


Suppression d'un type de demande n'ayant pas de dossier
    [Documentation]  Avec un profil administrateur, depuis le menu Paramétrage Dossier > Demandes > Type,
    ...  je sélectionne un type de demande existant qui n'a pas de dossiers associés.
    ...  Depuis la page de consultation du type de demande, lorsque je clique sur l'action "Supprimer",
    ...  mon type de demande est supprimé et n'est plus visible dans le tableau.
    
    Supprimer le type de demande  ${libelle_demande}  ${code_demande}
    Depuis le tableau des types de demandes
    Use Simple Search  code  ${code_demande}
    Element Should Contain  css=table.tab-tab  Aucun enregistrement.
