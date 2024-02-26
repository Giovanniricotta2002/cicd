*** Settings ***
Documentation     Actions spécifiques aux contraintes

*** Keywords ***
Ajouter la contrainte depuis le menu
    [Arguments]  ${libelle}  ${nature}  ${collectivite}  ${groupe}=null  ${sousgroupe}=null  ${texte}=null

    # On ouvre le tableau des contraintes
    Depuis le tableau des contraintes
    # On clique sur l'icone ajouter
    Click On Add Button
    # On remplit le formulaire
    Saisir la contrainte  ${libelle}  ${nature}  ${collectivite}  ${groupe}  ${sousgroupe}  ${texte}
    # On valide
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    # On récupère l'ID de la contrainte
    ${id_contrainte} =  Get Value  css=div.form-content input#contrainte
    # On le retourne
    [Return]  ${id_contrainte}

Depuis le contexte de la contrainte
    [Documentation]  Permet d'accéder au formulaire en consultation
    ...    d'une contrainte.
    [Arguments]  ${libelle}

    # On ouvre le tableau des contraintes
    Depuis le tableau des contraintes
    # On recherche la contrainte
    Use Simple Search  libellé  ${libelle}
    # On clique sur la contrainte
    Click On Link  ${libelle}

Modifier la contrainte
    [Arguments]  ${libelle_search}  ${libelle}=null  ${nature}=null  ${collectivite}=null  ${groupe}=null  ${sousgroupe}=null  ${texte}=null

    # On accède à la fiche de la contrainte
    Depuis le contexte de la contrainte  ${libelle_search}
    # On clique sur l'action modifier
    Click On Form Portlet Action  contrainte  modifier
    # On remplit le formulaire
    Saisir la contrainte  ${libelle}  ${nature}  ${collectivite}  ${groupe}  ${sousgroupe}  ${texte}
    # On valide
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.

Depuis le tableau des contraintes
    [Documentation]  Permet d'accéder au listing des contraintes.

    # On ouvre le tableau
    Depuis le listing  contrainte

Saisir la contrainte
    [Arguments]  ${libelle}=null  ${nature}=null  ${collectivite}=null  ${groupe}=null  ${sousgroupe}=null  ${texte}=null

    # On saisit le libellé
    Run Keyword If  '${libelle}' != 'null'  Input Text  libelle  ${libelle}
    # On sélectionne la nature
    Run Keyword If  '${nature}' != 'null'  Select From List By Label  nature  ${nature}
    # On sélectionne la collectivité
    Run Keyword If  '${collectivite}' != 'null'  Select From List By Label  om_collectivite  ${collectivite}
    # On saisit le groupe
    Run Keyword If  '${groupe}' != 'null'  Input Text  groupe  ${groupe}
    # On saisit le sous-groupe
    Run Keyword If  '${sousgroupe}' != 'null'  Input Text  sousgroupe  ${sousgroupe}
    # On saisit le texte de la contrainte
    Run Keyword If  '${texte}' != 'null'  Input Text  texte  ${texte}

Synchroniser les contraintes
    [Documentation]  Accède au formulaire de synchronisation des contraintes via son url et clique
    ...  sur le bouton de synchronisation.
    # Dans certain cas la copie / modification du paramétrage peut mettre un peu de temps à
    # être prise en compte dans l'application et empêcher l'affichage du bouton de synchronisation.
    # Pour éviter ça on tente de cliquer sur le bouton et si le clic échoue la page est rechargée
    # puis une nouvelle tentative est effectuée.
    # La page est rechargé 3 fois. Si au bout des 3 fois le clic n'a pas réussi le keyword fail.
    :FOR  ${INDEX}  IN RANGE  1  3
    \  # Accès au formulaire de synchronisation
    \  Go To  ${PROJECT_URL}${OM_ROUTE_FORM}&obj=contrainte&action=100&idx=0
    \  # Tentative de clic sur le bouton de synchronisation
    \  ${synchronisation_ok}=  Run Keyword And Return Status
    \  ...  Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}
    \  ...    Click Element  button-contrainte-synchronisation-synchroniser
    \  # si le clic sur le bouton de synchronisation a réussi on sort de la boucle
    \  Run Keyword If  ${synchronisation_ok}  Return From Keyword
    # Si au bout de 3 tentative le clic sur le bouton n'a toujours pas fonctionné affiche un message d'erreur
    Run Keyword If  ${INDEX} == 3  Fail  Le clic sur le bouton de synchronisation a échoué
