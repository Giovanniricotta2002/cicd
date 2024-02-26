*** Settings ***
Documentation    CRUD de la table num_bordereau
...    @author  generated
...    @package openADS
...    @version 26/11/2019 17:11

*** Keywords ***
Depuis le contexte du bordereau de numérisation
    [Documentation]  Accède au formulaire
    [Arguments]  ${search_value}  ${search_label}=Numéro du bordereau

    Depuis le listing  num_bordereau
    Use Simple Search  ${search_label}  ${search_value}
    Click On Link  ${search_value}
    La page ne doit pas contenir d'erreur

Ajouter le bordereau de numérisation
    [Documentation]  Crée l'enregistrement
    [Arguments]  ${values}

    # On accède au tableau
    Depuis le listing  num_bordereau
    # On clique sur le bouton ajouter
    Click On Add Button
    # On saisit des valeurs
    Saisir le bordereau de numérisation  ${values}
    # On valide le formulaire
    Click On Submit Button
    # On récupère l'ID du nouvel enregistrement
    ${num_bordereau} =  Get Value  css=div.form-content input#num_bordereau
    # On le retourne
    [Return]  ${num_bordereau}

Saisir le bordereau de numérisation
    [Documentation]  Remplit le formulaire
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "envoi" existe dans "${values}" on execute "Input Datepicker" dans le formulaire
    Si "om_collectivite" existe dans "${values}" on execute "Select From List By Label" dans le formulaire

Vérification du contenu d'un bordereau
    [Documentation]  C'est le document PDF qui est transmis à la cellule de
    ...  numérisation
    [Arguments]  ${num_bordereau}  ${check_values}  ${page}=1

    Depuis le listing  num_bordereau
    Use Simple Search  Numéro du bordereau  ${num_bordereau}
    Click On Tab Action  ${num_bordereau}  num_bordereau  imprimer  left  False  new_window
    Open PDF  ${OM_PDF_TITLE}
    :FOR  ${check_value}  IN  @{check_values}
    \  PDF Page Number Should Contain  ${page}  ${check_value}
    Close PDF

Retour de bordereau de la cellule de numérisation avec vérification des dossiers de suivi
    [Documentation]
    [Arguments]  ${search_value}  ${list_di}  ${search_label}=Numéro du bordereau

    Depuis le contexte du bordereau de numérisation  ${search_value}  ${search_label}
    Click On Form Portlet Action  num_bordereau  retour_num  modale
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Click Button  Confirmer
    Wait Until Keyword Succeeds  ${TIMEOUT}  ${RETRY_INTERVAL}  Valid Message Should Contain  Les dates de numérisation des dossiers ont été correctement mises à jour.
    On clique sur l'onglet  num_dossier  Suivi Des Dossiers Du Bordereau
    :FOR  ${di}  IN  @{list_di}
    \  Input Text  css=span#recherche_onglet form input#recherchedyn  ${di}
    \  Click Element Until New Element  link:${di}  css=div#sousform-num_dossier div#sformulaire
    \  Form Static Value Should Be  css=span#datenum  ${date_ddmmyyyy}
    \  Click On Back Button In Subform
