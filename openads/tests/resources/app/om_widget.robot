*** Settings ***
Documentation  Actions spécifiques aux widgets.

*** Keywords ***
Ajouter le widget depuis l'URL
    [Documentation]  Ajout d'un widget en saisissant l'URL et retourne
    ...  l'identifiant
    [Arguments]  ${values}

    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=0&retour=form
    Saisir le widget de tdb  ${values}
    Click On Submit Button
    ${om_widget} =  Get Text  css=div.form-content span#om_widget
    [Return]  ${om_widget}


Modifier le widget
    [Documentation]  Modification d'un widget existant
    [Arguments]  ${om_widget}  ${values}

    Depuis le contexte du widget  ${om_widget}
    Click On Form Portlet Action  om_widget  modifier
    Saisir le widget de tdb  ${values}
    Click On Submit Button


Saisir le widget de tdb
    [Documentation]  Saisie le formulaire d'un widget
    [Arguments]  ${values}

    Si "libelle" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "type" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "lien" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "texte" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "script" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "arguments" existe dans "${values}" on execute "Input Text" dans le formulaire


Supprimer le widget depuis l'URL par l'identifiant
    [Documentation]  Supprime le widget
    [Arguments]  ${om_widget}

    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_widget&action=2&idx=${om_widget}
    Click On Submit Button
    Valid Message Should Be  La suppression a été correctement effectuée.


Ajouter le widget au tableau de bord du profil depuis l'URL
    [Documentation]  Ajoute le widget au tableau de bord du profil en saisissant
    ...  l'URL et retourne l'identifiant
    [Arguments]  ${values}

    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=0&retour=form
    Saisir le tableau de bord  ${values}
    Click On Submit Button
    ${om_dashboard} =  Get Text  css=div.form-content span#om_dashboard
    [Return]  ${om_dashboard}


Saisir le tableau de bord
    [Documentation]  Saisie le formulaire du tableau de bord
    [Arguments]  ${values}

    Si "om_profil" existe dans "${values}" on execute "Select From List By Label" dans le formulaire
    Si "bloc" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "position" existe dans "${values}" on execute "Input Text" dans le formulaire
    Si "om_widget" existe dans "${values}" on execute "Select From List By Label" dans le formulaire


Supprimer le tableau de bord depuis l'URL par l'identifiant
    [Documentation]  Supprime le widget
    [Arguments]  ${om_dashboard}

    Go To  ${PROJECT_URL}/app/index.php?module=form&obj=om_dashboard&action=2&idx=${om_dashboard}
    Click On Submit Button
    Valid Message Should Be  La suppression a été correctement effectuée.


Insérer les paramètres suivants dans le widget
    [Documentation]  Permet d'insérer des paramètres dans le widget (mettre des \n entre chaque paramètre)
    [Arguments]  ${valeur}  ${widget}
    Depuis le contexte du widget  ${widget}
    Click On Form Portlet Action    om_widget    modifier
    Input Text    arguments
    ...  ${valeur}
    Click On Submit Button