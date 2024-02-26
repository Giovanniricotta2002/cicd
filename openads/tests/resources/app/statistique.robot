*** Settings ***
Documentation     Actions spécifiques aux statistiques.

*** Keywords ***
Depuis le formulaire de génération de l'export SITADEL

    # On accède au formulaire via le menu
    Go To Submenu In Menu  edition  sitadel
    # On vérifie que l'on s'y trouve
    Breadcrumb Should Be  Export / Import > Export SITADEL

Cliquer sur le bouton export SITADEL
    [Arguments]  ${text}=Confirmer

    Click Element  css=#sitadel-form-export-submit
    Cliquer sur le bouton de la fenêtre modale  ${text}
    La page ne doit pas contenir d'erreur

Depuis le menu des statistiques à la demande
    Go To Submenu In Menu  edition  reqmo

Choix du format de sortie CSV
    Select From List By Label  css=select[name='sortie']  CSV - Export vers logiciel tableur

Exécuter la reqmo
    Submit Form  css=form[action^='../app/reqmo_pilot']

Lien téléchargement CSV
    ${link} =  Get Element Attribute  css=a[href^='../app/index.php?module=form&snippet=file&uid=']  href
    [Return]  ${link}

Contenu CSV
    [Arguments]  ${link}
    ${output_dir}  ${output_name} =  Télécharger un fichier  ${SESSION_COOKIE}  ${link}  ${EXECDIR}${/}binary_files${/}
    ${full_path_to_file} =  Catenate  SEPARATOR=  ${output_dir}  ${output_name}
    ${content_file} =  Get File  ${full_path_to_file}
    [Return]  ${content_file}
