*** Settings ***
Documentation     Geolocalisation SIG

# On inclut les mots-clefs
Resource    resources/resources.robot
# On ouvre et on ferme le navigateur respectivement au début et à la fin
# du Test Suite.
Suite Setup    For Suite Setup
Suite Teardown    For Suite Teardown


*** Test Cases ***
Setup
    [Documentation]  Constitition du jeu de données nécessaire pour les tests.

    Depuis la page d'accueil  admin  admin
    # Création de deux collectivités
    Ajouter la collectivité depuis le menu  Libreville  mono
    Ajouter la collectivité depuis le menu  Freeville  mono
    Ajouter le paramètre depuis le menu  departement  078  Freeville
    Ajouter le paramètre depuis le menu  commune  345  Freeville
    Ajouter le paramètre depuis le menu  insee  78345  Freeville
    # Définition des paramètres nécessaire pour le test
    # LIBREVILLE
    &{param_values} =  Create Dictionary
    ...  libelle=departement
    ...  valeur=045
    ...  om_collectivite=Libreville
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=commune
    ...  valeur=678
    ...  om_collectivite=Libreville
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=insee
    ...  valeur=45678
    ...  om_collectivite=Libreville
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    # FREEVILLE
    &{param_values} =  Create Dictionary
    ...  libelle=departement
    ...  valeur=078
    ...  om_collectivite=Freeville
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=commune
    ...  valeur=345
    ...  om_collectivite=Freeville
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    &{param_values} =  Create Dictionary
    ...  libelle=insee
    ...  valeur=78345
    ...  om_collectivite=Freeville
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    # GÉNÉRAL
    &{param_values} =  Create Dictionary
    ...  libelle=option_sig
    ...  valeur=sig_externe
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    # Ajout d'un administrateur général à la collectivité
    @{admingen_libreville} =  Create List  admingenlibreville  admingenlibreville
    Set Suite Variable  ${admingen_libreville}
    Ajouter l'utilisateur depuis le menu  Trépanier Antoine  support@mail.fr  @{admingen_libreville}  ADMINISTRATEUR GENERAL  Libreville


Catching d'éventuelles Fatal Errors lors de la synchronisation de contraintes
    [Documentation]  On teste que l'apparition de Fatal Errors lors de la synchronisation
    ...  de contraintes soit bien catch et ne crash pas la page.
    ...  A cette fin, on crée dans geoads_test.class.php
    ...  un cas pour la méthode recup_toutes_contraintes($code_insee) :
    ...  le cas ayant pour code insee '45678' qui déclenche une
    ...  geoads_connector_exception et affichant bien le message :
    ...  "Caught exception: Erreur SIG. Veuillez contacter votre administrateur"

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}
    
    # Le test ne peut pas avoir lieu dans le cas : Administrateur mono / synchro multi, 
    # on modifie sig.inc.php vers une synchro mono
    
    Run  sed -i 's/"sig_treatment_mod" => "multi"/"sig_treatment_mod" => "mono"/' ../dyn/sig.inc.php

    Depuis la page d'accueil  @{admingen_libreville}
    Synchroniser les contraintes
    #La page ne doit pas contenir d'erreur
    Page Should Contain  Caught exception: Erreur SIG. Veuillez contacter votre administrateur

    # On rétablit sig.inc.php vers une synchro multi
    Run  sed -i 's/"sig_treatment_mod" => "mono"/"sig_treatment_mod" => "multi"/' ../dyn/sig.inc.php

    
Géolocalisation automatique des dossiers d'instruction

    [Documentation]  On teste le formulaire de géolocalisation automatique par
    ...  lots de dossiers d'instruction. Les tests suivants sont effectués en
    ...  multicollectivité et en monocollectivité :
    ...  - 1 dossier où la vérification des parcelles échoue
    ...  - 1 dossier où le calcul de l'emprise échoue
    ...  - 1 dossier où le calcul du centroïde échoue
    ...  - 1 dossier où la géolocalisation automatique est un succès
    ...  - 1 dossier qui n'est pas pris en compte car ayant une parcelle temporaire.

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin

    # Ajout du paramètre permettant de filtrer les dossiers d'instruction à
    # traiter lors de la géolocalisation automatique
    # Permier argument date de dépôt limite
    # Deuxième argument liste des type de dossier d'autorisation à traiter
    # Troisième argument l'avis de décision à ne pas traiter
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=param_geolocalisation_auto
    ...  valeur=2015-01-01;'PC','CU';Defavorable
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # Ajout d'un dossier d'instruction dont la date de dépôt est antérieur à la
    # date limite du paramètre, il ne devrait pas être comptabiliser dans le
    # résultat final
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Généreux
    ...  particulier_prenom=Josette
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  0010
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=31/12/2014
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV10_ignore} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'un dossier d'instruction dont le type n'est pas dans la liste
    # autorisée du paramètre, il ne devrait pas être comptabiliser dans le
    # résultat final
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Bélanger
    ...  particulier_prenom=Daniel
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  0011
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Déclaration préalable
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV11_ignore} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'un dossier d'instruction dont l'avis de décision est identique à
    # celui du paramètre, il ne devrait pas être comptabiliser dans le résultat
    # final
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Collin
    ...  particulier_prenom=Arthur
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  0012
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV12_ignore} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}
    Ajouter une instruction au DI et la finaliser  ${di_libelle_LV12_ignore}  ARRÊTÉ DE REFUS 2
    &{args_instruction} =  Create Dictionary
    ...  date_retour_rar=${DATE_FORMAT_DD/MM/YYYY}
    Modifier le suivi des dates  ${di_libelle_LV12_ignore}  ARRÊTÉ DE REFUS 2  ${args_instruction}

    # Ajout d'un dossier d'instruction dont le type est dans la liste autorisée
    # du paramètre, il devrait être comptabiliser dans le résultat final
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Picard
    ...  particulier_prenom=Huette
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  0013
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV13_geoloc} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Contrôle des références cadastrales sur les dossiers
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV10_ignore}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0010
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV11_ignore}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0011
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV12_ignore}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0012
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV13_geoloc}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0013

    # Contrôle le résultation du traitement de la géolocalisation automatique
    # 1 seul des 4 dossiers d'instructions devrait être traité
    Depuis la page d'accueil  @{admingen_libreville}
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button Until Message  dossier(s) d'instruction
    Element Should Contain  css=div#formulaire  Libreville
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction a(ont) été géolocalisé(s)
    Element Should Not Contain  css=div#formulaire  dossier(s) d'instruction n'a(ont) pas pu être géolocalisé(s)
    Element Should Not Contain  css=div.message.ui-state-valid p span.text  Freeville
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV10_ignore}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV11_ignore}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV12_ignore}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV13_geoloc}
    Form Value Should Contain  geom  POINT(10123 10456)


    # échoue pour cause de parcelle inexistante (codé en dur dans le faux connecteur sig)
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Simard
    ...  particulier_prenom=Julienne
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  0001
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV1_fail} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # échoue pour cause de calcul d'emprise en erreur (codé en dur dans le faux connecteur sig)
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Smith
    ...  particulier_prenom=John
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  0003
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV3_fail} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # échoue pour cause de calcul centroïde en erreur (codé en dur dans le faux connecteur sig)
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Durand
    ...  particulier_prenom=Eléonore
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  0005
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV5_fail} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Flynn
    ...  particulier_prenom=Andrew
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  0006
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_LV6} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # échoue pour cause de parcelle inexistante (codé en dur dans le faux connecteur sig)
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Madsen
    ...  particulier_prenom=Caroline
    ...  om_collectivite=Freeville
    @{ref_cad} =  Create List  999  ZZ  0002
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Freeville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_FV2_fail} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # échoue pour cause de calcul d'emprise en erreur (codé en dur dans le faux connecteur sig)
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Holmes
    ...  particulier_prenom=Sherlock
    ...  om_collectivite=Freeville
    @{ref_cad} =  Create List  999  ZZ  0004
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Freeville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_FV4_fail} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # échoue pour cause de calcul centroïde en erreur (codé en dur dans le faux connecteur sig)
        &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Djivani
    ...  particulier_prenom=Papita
    ...  om_collectivite=Freeville
    @{ref_cad} =  Create List  999  ZZ  0007
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Freeville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_FV7_fail} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pendragon
    ...  particulier_prenom=Solomon
    ...  om_collectivite=Freeville
    @{ref_cad} =  Create List  999  ZZ  0008
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Freeville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_FV8} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'un dossier d'instruction possédant au moins une parcelle
    # temporaire, il ne devrait pas être comptabiliser dans le résultat final
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pellinore
    ...  particulier_prenom=Perceval
    ...  om_collectivite=Freeville
    @{ref_cad} =  Create List  999  ZZ  0009
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Freeville
    ...  date_demande=01/01/2018
    ...  terrain_references_cadastrales=${ref_cad}
    ...  parcelle_temporaire=true
    ${di_libelle_FV9_ignore} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis la page d'accueil  admin  admin
    # Contrôle des références cadastrales sur les dossiers
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV1_fail}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0001
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV3_fail}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0003
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV5_fail}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0005
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV6}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0006
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV2_fail}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0002
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV4_fail}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0004
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV7_fail}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0007
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV8}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0008
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV9_ignore}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0009

    # Contrôle les résultat de la géolocalisation automatique
    Depuis la page d'accueil  admingenlibreville  admingenlibreville
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button Until Message  dossier(s) d'instruction
    Element Should Contain  css=div#formulaire  Libreville
    Element Should Contain  css=div#formulaire  2 dossier(s) d'instruction a(ont) été géolocalisé(s)
    Element Should Contain  css=div#formulaire  2 dossier(s) d'instruction n'a(ont) pas pu être géolocalisé(s)
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction en erreur à la vérification des parcelles
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction en erreur au calcul de l'emprise
    Element Should Not Contain  css=div.message.ui-state-valid p span.text  Freeville
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV1_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV3_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV5_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV6}
    Form Value Should Contain  geom  POINT(10123 10456)
    Depuis la page d'accueil  admingen  admingen
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV2_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV4_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV7_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV8}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV9_ignore}
    Form Value Should Contain  geom  ${EMPTY}

    Depuis la page d'accueil  admingen  admingen
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button Until Message  dossier(s) d'instruction
    Element Should Contain  css=div#formulaire  Libreville
    Element Should Contain  css=div#formulaire  2 dossier(s) d'instruction n'a(ont) pas pu être géolocalisé(s)
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction en erreur à la vérification des parcelles
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction en erreur au calcul de l'emprise
    Element Should Contain  css=div#formulaire  Freeville
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction a(ont) été géolocalisé(s)
    Capture Page Screenshot
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV1_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_LV3_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV2_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV4_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV7_fail}
    Form Value Should Contain  geom  ${EMPTY}
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV8}
    Form Value Should Contain  geom  POINT(10123 10456)
    Depuis le contexte du dossier d'instruction  ${di_libelle_FV9_ignore}
    Form Value Should Contain  geom  ${EMPTY}

    Supprimer le paramètre  option_sig

    Remove File  ..${/}dyn${/}sig.inc.php

Paramètre de filtrage de la geolocalisation sur les dossiers du jours
    [Documentation]  Test le fonctionnement du paramètrage de la géolocalisation
    ...  dans le cas ou l'on filtre sur la date du jour

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_sig
    ...  valeur=sig_externe
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Ajout du paramètre permettant de filtrer les dossiers d'instruction à
    # traiter lors de la géolocalisation automatique
    # Permier argument date de dépôt limite
    # Deuxième argument liste des type de dossier d'autorisation à traiter
    # Troisième argument l'avis de décision à ne pas traiter
    &{param_values} =  Create Dictionary
    ...  libelle=param_geolocalisation_auto
    ...  valeur=today;'PC','CU';Defavorable
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Ajout d'un dossier d'instruction dont la date de dépôt n'est pas celle
    # du jour
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Pico
    ...  particulier_prenom=Josette
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  1000
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  date_demande=31/12/2014
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Ajout d'un dossier d'instruction dont la date de dépot est celle
    # du jour
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Sairien
    ...  particulier_prenom=Jean
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  2000
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_libelle_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Vérification du fonctionnement de la géolocalisation. Seul
    # le dossier dont la date de dépot est celle du jour doit avoir son centroide.
    Depuis le contexte du dossier d'instruction  ${di_libelle_1}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ1000
    Depuis le contexte du dossier d'instruction  ${di_libelle_2}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ2000

    Depuis la page d'accueil  admingen  admingen
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button
    Element Should Contain  css=div#formulaire  Libreville
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction a(ont) été géolocalisé(s)
    Element Should Not Contain  css=div#formulaire  dossier(s) d'instruction n'a(ont) pas pu être géolocalisé(s)
    Element Should Not Contain  css=div.message.ui-state-valid p span.text  Freeville
    Depuis le contexte du dossier d'instruction  ${di_libelle_2}
    Form Value Should Contain  geom  POINT(10123 10456)
    Depuis le contexte du dossier d'instruction  ${di_libelle_1}
    Form Value Should Contain  geom  ${EMPTY}

    Supprimer le paramètre  option_sig

    Remove File  ..${/}dyn${/}sig.inc.php

TNR de l'affichage des messages dans la vue de geolocalisation après geolocalisation auto
    [Documentation]  Vérifie que lorsque l'on accède à la vue d'un dossier ayant été géolocalisé
    ...  automatiquement, les messages des actions de vérification des parcelles, calcul d'emprise et
    ...  calcul du centroide sont bien présent.

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_sig
    ...  valeur=sig_externe
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Ajout du paramètre permettant de filtrer les dossiers d'instruction à
    # traiter lors de la géolocalisation automatique
    # Permier argument date de dépôt limite
    # Deuxième argument liste des type de dossier d'autorisation à traiter
    # Troisième argument l'avis de décision à ne pas traiter
    &{param_values} =  Create Dictionary
    ...  libelle=param_geolocalisation_auto
    ...  valeur=today;'PC','CU';Defavorable
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}
    
    # Création de deux dossier un avec une parcelle non existante et l'autre ok
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Padidé
    ...  particulier_prenom=Jai
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  0001
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_aff_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Neymar
    ...  particulier_prenom=Jean
    ...  om_collectivite=Libreville
    @{ref_cad} =  Create List  999  ZZ  1000
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Certificat d'urbanisme
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=Libreville
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_aff_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    Depuis le contexte du dossier d'instruction  ${di_aff_1}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ0001
    Depuis le contexte du dossier d'instruction  ${di_aff_2}
    Open Fieldset  dossier_instruction  localisation
    Form Static Value Should Be  css=.reference-cadastrale-0  999ZZ1000

    # Utilisation de l'action de géolocalisation automatique
    # Contrôle les résultat de la géolocalisation automatique
    Depuis la page d'accueil  admingen  admingen
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button
    Element Should Contain  css=div#formulaire  Libreville
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction a(ont) été géolocalisé(s)
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction en erreur à la vérification des parcelles

    # Vérification que les messages sont ok pour le dossier geolocaliser
    Depuis le contexte du dossier d'instruction  ${di_aff_2}
    Form Value Should Contain  geom  POINT(10123 10456)
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Element Should Contain  css=div#verif_parcelle-message  Les parcelles existent.
    Element Should Contain  css=div#calcul_emprise-message  L'emprise a été calculé.
    Element Should Contain  css=div#dessin_emprise-message  Action non effectuée.
    Element Should Contain  css=div#calcul_centroide-message  Le centroide a été calculé.
    Element Should Contain  css=div#recup_contrainte-message  Action non effectuée.

    # Vérification que les messages sont ok pour l'autre dossier
    Depuis le contexte du dossier d'instruction  ${di_aff_1}
    Form Value Should Contain  geom  ${EMPTY}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Element Should Contain  css=div#verif_parcelle-message  Le traitement automatique a échoué.
    Element Should Contain  css=div#calcul_emprise-message  Action non effectuée.
    Element Should Contain  css=div#dessin_emprise-message  Action non effectuée.
    Element Should Contain  css=div#calcul_centroide-message  Action non effectuée.
    Element Should Contain  css=div#recup_contrainte-message  Action non effectuée.

    Supprimer le paramètre  option_sig

    Remove File  ..${/}dyn${/}sig.inc.php

Ajout d'une contrainte de références et de ses critères d'application

    Depuis la page d'accueil  admin  admin

    # Ajout de la couche
    Depuis le listing  sig_couche
    Click On Add Button
    ${sig_couche} =  Create Dictionary
    ...  libelle=Abord MH
    ...  id_couche=0
    Saisir la couche  ${sig_couche}
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    ${sig_couche_id} =  Get Text  css=div.form-content span#sig_couche

    # Ajout de l'attribut de référence sur la couche
    Depuis le contexte de la couche  ${sig_couche_id}
    On clique sur l'onglet  sig_attribut  Attributs De Références
    Click On Add Button
    # Le champ 'libelle' de sig_attribut ne peut pas être saisie autrement
    # qu'en utilisant la sélection avec le sous formulaire car dans le
    # formulaire principal il y a aussi un champ 'libelle'
    Input Text  css=#sformulaire div.formEntete div#form-content #libelle  appellation
    Input Text  css=#sformulaire div.formEntete div#form-content #identifiant  appellation
    Click On Submit Button In Subform

    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Ajout du groupe de référence
    Depuis le listing  sig_groupe
    Click On Add Button
    ${sig_groupe} =  Create Dictionary
    ...  libelle=SPR
    Saisir le groupe de référence  ${sig_groupe}
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Ajout du sous-groupe de référence
    Depuis le listing  sig_sousgroupe
    Click On Add Button
    ${sig_sousgroupe} =  Create Dictionary
    ...  libelle=SPR sous-groupe
    Saisir le sous-groupe de référence  ${sig_sousgroupe}
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

    # Ajout de la contrainte de référence
    Depuis le listing  sig_contrainte
    Click On Add Button
    @{type_di} =  Create List  AT - P - Initiale  AT - M - Modificatif
    @{om_collectivite} =  Create List  MARSEILLE  ALLAUCH
    ${sig_contrainte} =  Create Dictionary
    ...  nature=SPR
    ...  groupe=SPR
    ...  sous-groupe=SPR sous-groupe
    ...  libelle=Contrainte test
    ...  texte=Ceci est un texte
    ...  texte_genere=Ceci est un texte généré avec un champ de fusion [appellation]
    ...  sig_couche=${sig_couche.libelle} (${sig_couche.id_couche})
    ...  dossier_instruction_type=${type_di}
    ...  om_collectivite=${om_collectivite}
    Saisir la contrainte de référence  ${sig_contrainte}
    Click On Submit Button
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    ${sig_contrainte_id} =  Get Text  css=div.form-content span#sig_contrainte

    # Ajout du critère d'application de la contrainte de référence
    Depuis le contexte de la contrainte de référence  ${sig_contrainte_id}
    On clique sur l'onglet  lien_sig_contrainte_sig_attribut  Critères D'application
    ${critere_application} =  Create Dictionary
    ...  sig_attribut=appellation
    ...  valeur=valeur d'appellation
    Click On Add Button
    Saisir le critère d'application de la contrainte de référence  ${critere_application}
    Click On Submit Button In Subform
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Géolocalisation automatique des dossiers d'instruction avec geolocalisation des contraintes

    [Documentation]  On teste le formulaire de géolocalisation automatique avec
    ...  l'option de récupération des contraintes actives. Puis on vérifie que
    ...  la geolocalisation a correctement fonctionné et que les contraintes ont
    ...  bien été récupéré et si ce n'est pas le cas que le message d'erreur est
    ...  clair.

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_sig
    ...  valeur=sig_externe
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Ajout du paramètre permettant de filtrer les dossiers d'instruction à
    # traiter lors de la géolocalisation automatique
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=param_geolocalisation_auto
    ...  valeur=today;'PC';Defavorable
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Ajout de l'option de récupération des contraintes
    &{param_values} =  Create Dictionary
    ...  libelle=option_geolocalisation_auto_contrainte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # Ajout d'un dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Robillard
    ...  particulier_prenom=Campbell
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  999  ZZ  0010
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_recup_contrainte_auto_1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Utilisation de l'action de geolocalisation auto avant synchro des contraintes
    Depuis la page d'accueil  admingen  admingen
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button
    Element Should Contain  css=div#formulaire  MARSEILLE
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction dont les contraintes n'ont pas pu être récupérées.

    # Vérification que les messages sont ok dans la vue de la geoloc du dossier
    Depuis le contexte du dossier d'instruction  ${di_recup_contrainte_auto_1}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Element Should Contain  css=div#verif_parcelle-message  Les parcelles existent.
    Element Should Contain  css=div#calcul_emprise-message  L'emprise a été calculé.
    Element Should Contain  css=div#dessin_emprise-message  Action non effectuée.
    Element Should Contain  css=div#calcul_centroide-message  Le centroide a été calculé.
    Element Should Contain  css=div#recup_contrainte-message  Les contraintes doivent être synchronisées. Contactez votre administrateur.

    # Ajout d'un nouveau dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Grivois
    ...  particulier_prenom=Arlette
    ...  om_collectivite=ALLAUCH
    @{ref_cad} =  Create List  999  ZZ  0010
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=ALLAUCH
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_recup_contrainte_auto_2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Utilisation de l'action de geolocalisation après synchro des contraintes
    Depuis la page d'accueil  admingen  admingen
    Synchroniser les contraintes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain   contrainte(s) ajoutée(s)
    Valid Message Should Contain  Aucune contraintes à modifier.
    Valid Message Should Contain  3 contrainte(s) archivée(s)
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button
    Element Should Contain  css=div#formulaire  ALLAUCH
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction a(ont) été géolocalisé(s)

    # Vérification que les messages sont ok dans la vue de la geoloc du dossier
    Depuis le contexte du dossier d'instruction  ${di_recup_contrainte_auto_2}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Element Should Contain  css=div#verif_parcelle-message  Les parcelles existent.
    Element Should Contain  css=div#calcul_emprise-message  L'emprise a été calculé.
    Element Should Contain  css=div#dessin_emprise-message  Action non effectuée.
    Element Should Contain  css=div#calcul_centroide-message  Le centroide a été calculé.
    Element Should Contain  css=div#recup_contrainte-message  Les contraintes ont été récupérées.

    Supprimer le paramètre  option_sig
    Supprimer le paramètre  option_geolocalisation_auto_contrainte
    Supprimer le paramètre  param_geolocalisation_auto

    Remove File  ..${/}dyn${/}sig.inc.php

TNR vérification de la mise à jour du message de récupération des contraintes après traitement

    [Documentation]  Effectue un traitement de récupération des contraintes puis,
    ...  depuis l'overlay de geoloalisation vérifie que le message indiquant le
    ...  nombre de contraintes récupérées est bien celui attendus.

    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=option_sig
    ...  valeur=sig_externe
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Ajout du paramètre permettant de filtrer les dossiers d'instruction à
    # traiter lors de la géolocalisation automatique
    Depuis la page d'accueil  admin  admin
    &{param_values} =  Create Dictionary
    ...  libelle=param_geolocalisation_auto
    ...  valeur=today;'PC';Defavorable
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${param_values}

    # Ajout de l'option de récupération des contraintes
    &{param_values} =  Create Dictionary
    ...  libelle=option_geolocalisation_auto_contrainte
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter le paramètre depuis le menu (surcharge)  ${param_values}

    # Ajout d'un dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Goulet
    ...  particulier_prenom=Ancelote
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  999  ZZ  0010
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_references_cadastrales=${ref_cad}
    ${di1} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Utilisation de l'action de geolocalisation après synchro des contraintes
    Depuis la page d'accueil  admingen  admingen
    Synchroniser les contraintes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  3 contrainte(s)
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button
    Element Should Contain  css=div#formulaire  MARSEILLE
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction a(ont) été géolocalisé(s)

    # Vérification que le messsage est ok dans la vue de la geoloc du dossier
    Depuis le contexte du dossier d'instruction  ${di1}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Element Should Contain  css=span#contrainte  2 contrainte(s) ajoutée(s) depuis le SIG

    # Ajout d'un dossier d'instruction
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Lang
    ...  particulier_prenom=Chapin
    ...  om_collectivite=MARSEILLE
    @{ref_cad} =  Create List  999  ZZ  0010
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE
    ...  terrain_references_cadastrales=${ref_cad}
    ${di2} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # Utilisation de l'action de géolocalisation manuelle et vérification
    # que le messsage est ok dans la vue de la geoloc du dossier
    Depuis le contexte du dossier d'instruction  ${di2}
    Click Link  css=#action-form-dossier_instruction-geolocalisation
    Click Element  css=input#verif_parcelle-button
    Wait Until Element Contains  css=div#verif_parcelle-message  Les parcelles existent.
    Click Element  css=input#calcul_emprise-button
    Wait Until Element Contains  css=div#calcul_emprise-message  L'emprise a été calculée.
    Click Element  css=input#calcul_centroide-button
    Wait Until Element Contains  css=div#calcul_centroide-message  Le centroide a été calculé
    Click Element  css=input#recup_contrainte-button
    Handle Alert
    Wait Until Element Contains  css=span#contrainte  2 contrainte(s) ajoutée(s) depuis le SIG

    Supprimer le paramètre  option_sig
    Supprimer le paramètre  option_geolocalisation_auto_contrainte
    Supprimer le paramètre  param_geolocalisation_auto

    Remove File  ..${/}dyn${/}sig.inc.php

Dans un dossier d'instruction, le pictogramme de géolocalisation doit apparaitre de la bonne couleur 

    [Documentation]  On vérifie que dans un dossier d'instruction, lorsqu'on est sur l'onglet DI, 
    ...  s'il existe une valeur de géolocalisation, on vérifie qu'un pictogramme vert apparaisse 
    ...  ainsi que les coordonnées correspondantes dans le formulaire "Dossier d'instruction".
    ...  À l'inverse, s'il n'existe pas de valeur de géolocalisation, on vérifie qu'un pictogramme rouge 
    ...  apparaisse suivi d'un indicateur "Aucune géolocalisation".
    
    Copy File  ..${/}tests${/}binary_files${/}geoads_test${/}sig.inc.php  ..${/}dyn${/}

    Depuis la page d'accueil  admin  admin
    Ajouter le paramètre depuis le menu  option_sig  sig_externe  agglo
        
    #1- Ajout d'un nouveau dossier d'instruction avec informations pour géolocalisation
    &{args_petitionnaire} =  Create Dictionary
    ...  particulier_nom=Provist
    ...  particulier_prenom=Alain
    ...  om_collectivite=ALLAUCH
    @{ref_cad} =  Create List  999  ZZ  0010
    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=ALLAUCH
    ...  terrain_references_cadastrales=${ref_cad}
    ${di_geoloc} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On vérifie que le dossier est supprimable avant la géolocalisation
    Depuis la page d'accueil  admin  admin

    # On active l'option de suppression
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=true
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    Depuis le contexte du dossier d'instruction  ${di_geoloc}

    Portlet Action Should Be In Form  dossier_instruction  supprimer

    Depuis la page d'accueil  admin  admin
    Synchroniser les contraintes
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  3 contrainte(s)
    Go To Submenu In Menu  administration  geocoder
    Click On Submit Button
    Element Should Contain  css=div#formulaire  ALLAUCH
    Element Should Contain  css=div#formulaire  1 dossier(s) d'instruction a(ont) été géolocalisé(s)
   
   #on vérifie que l'information de géolocalisation apparaisse correctement dans le DI
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di_geoloc}
    
    Element Should be visible  css=a#action-form-localiser
    Element Should be visible  css=span.om-icon.om-icon-16.om-icon-fix.sig-16
    Element Should Contain  css=a#action-form-localiser  POINT(10123 10456)
    
    ## # On vérifie qu'il n'est plus supprimable après géolocalisation
    ## Portlet Action Should Not Be In Form  dossier_instruction  supprimer
    # Depuis l'évolution du connecteur SIG le dossier est supprimable si le
    # connecteur SIG implémente la suppression d'emprise, or le faux
    # connecteur SIG utilisé dans les tests implémente désormais cette
    # fonctionnalité, le dossier est donc toujours supprimable
    Portlet Action Should Be In Form  dossier_instruction  supprimer

    # On désactive l'option de suppression
    &{om_param} =  Create Dictionary
    ...  libelle=option_suppression_dossier_instruction
    ...  valeur=false
    ...  om_collectivite=agglo
    Ajouter ou modifier le paramètre depuis le menu  ${om_param}

    # 2 - On crée un DI sans géolocalisation et on vérifie que le pictogramme
    # rouge apparaisse suivi de la mention "Aucune géolocalisation"
    &{args_petitionnaire} =  Create Dictionary
    ...  qualite=particulier
    ...  particulier_nom=Menvussa
    ...  particulier_prenom=Gérard
    ...  om_collectivite=MARSEILLE

    &{args_demande} =  Create Dictionary
    ...  dossier_autorisation_type_detaille=Permis de construire pour une maison individuelle et / ou ses annexes
    ...  demande_type=Dépôt Initial
    ...  om_collectivite=MARSEILLE

    ${di_nogeoloc} =  Ajouter la demande par WS  ${args_demande}  ${args_petitionnaire}

    # On entre dans le dossier d'instruction et on vérifie que la valeur pour 
    # le champ "Géolocalisation" n'existe pas
    Depuis la page d'accueil  admin  admin
    Depuis le contexte du dossier d'instruction  ${di_nogeoloc}
    
    Element Should be visible  css=div.no-geoloc_label
    Element Should be visible  css=span.om-icon.om-icon-16.om-icon-fix.sig-16.no-geoloc
    Element Should Contain  css=div.no-geoloc_label  Aucune géolocalisation
***
    #Remise à zero de la configuration
    Supprimer le paramètre  option_sig
    Remove File  ..${/}dyn${/}sig.inc.php
