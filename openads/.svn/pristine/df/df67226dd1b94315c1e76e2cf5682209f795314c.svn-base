*** Settings ***
Documentation     Actions spécifiques aux demandes

*** Keywords ***
Ajouter un nouveau type de demande depuis le menu
    [Arguments]  ${form_values}

    Depuis le tableau des types de demandes
    # On clique sur l'icone ajouter
    Click On Add Button
    # On remplit le formulaire
    Saisir le type de demande  ${form_values}
    # On valide
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur
    # On vérifie le message de validation
    Valid Message Should Contain  Vos modifications ont bien été enregistrées.
    # On récupère l'ID du nouvel enregistrement
    ${dossier_instruction_type} =  Get Text  css=div.form-content span#demande_type
    # On le retourne
    [Return]  ${dossier_instruction_type}

Supprimer le type de demande
    [Documentation]  Supprime l'enregistrement
    [Arguments]  ${demande}  ${code}

    # On accède à l'enregistrement
    Depuis le contexte du type de demande  ${demande}  ${code}
    # On clique sur le bouton supprimer
    Click On Form Portlet Action  demande_type  supprimer
    # On valide le formulaire
    Click On Submit Button
    # Vérification qu'il n'y a aucune erreur
    La page ne doit pas contenir d'erreur

Saisir le type de demande
    [Arguments]  ${form_values}

    Si "code" existe dans "${form_values}" on execute "Input Text" dans le formulaire
    Si "libelle" existe dans "${form_values}" on execute "Input Text" dans le formulaire
    # On sélectionne le groupe
    Si "groupe" existe dans "${form_values}" on execute "Select From List By Label" dans le formulaire
    # On sélectionne le type de DA
    Si "dossier_autorisation_type_detaille" existe dans "${form_values}" on execute "Select From List By Label" dans le formulaire
    # On sélectionne la nature de la demande
    Si "demande_nature" existe dans "${form_values}" on execute "Select From List By Label" dans le formulaire
    # etats_autorises
    Si "etats_autorises" existe dans "${form_values}" on execute "Select Multiple By Label" dans le formulaire
    # On sélectionne les contraintes
    Si "contraintes" existe dans "${form_values}" on execute "Select From List By Label" dans le formulaire
    # On sélectionne le type de DI
    Si "dossier_instruction_type" existe dans "${form_values}" on execute "Select From List By Label" dans le formulaire
    # On sélectionne l'événement de la première instruction
    Si "evenement" existe dans "${form_values}" on execute "Select From List By Label" dans le formulaire
    # On sélectionne la collectivité si renseignée
    Si "document_obligatoire" existe dans "${form_values}" on execute "Input Text" dans le formulaire
    # On coche ou décoche la case de regénération de la clé citoyen
    Si "regeneration_cle_citoyen" existe dans "${form_values}" on execute "Set Checkbox" dans le formulaire
    #dossier instruciton type compatible
    Si "dossier_instruction_type_compatible" existe dans "${form_values}" on execute "Select Multiple By Label" dans le formulaire


Depuis le tableau des types de demandes
    Go To Dashboard
    Go To Submenu In Menu  parametrage-dossier  demande_type

Depuis le contexte du type de demande avec libellé unique
    [Arguments]  ${libelle}
    Depuis le tableau des types de demandes
    Use Simple Search  libellé  ${libelle}
    Click on Link  ${libelle}

Depuis le contexte du type de demande
    [Documentation]  Accède au formulaire
    [Arguments]  ${demande}  ${code}

    # On accède au tableau
    Depuis le tableau des types de demandes
    # On recherche l'enregistrement
    Use Simple Search  Tous  ${demande}
    # On clique sur le résultat
    Click On Link  ${code}
    # On vérifie qu'il n'y a pas d'erreur
    La page ne doit pas contenir d'erreur

Modifier le type de demande
    [Documentation]  Modifie l'enregistrement
    [Arguments]  ${demande}  ${code}  ${values}

    # On accède à l'enregistrement
    Depuis le contexte du type de demande  ${demande}  ${code}
    # On clique sur le bouton modifier
    Click On Form Portlet Action  demande_type  modifier
    # On saisit des valeurs
    Saisir le type de demande  ${values}
    # On valide le formulaire
    Click On Submit Button

Désactiver les types de demande compatible
    [Documentation]  Déselectionne les types compatibles entrés en paramètre
    [Arguments]  ${demande}  ${code}  ${form_values}
    Depuis le contexte du type de demande  ${demande}  ${code}
    Click On Form Portlet Action  demande_type  modifier
    Si "dossier_instruction_type_compatible" existe dans "${form_values}" on execute "Unselect Multiple By Label" dans le formulaire
    # On valide le formulaire
    Click On Submit Button
