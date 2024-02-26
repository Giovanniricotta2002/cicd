*** Settings ***
Documentation     Actions spécifiques aux profils.

*** Keywords ***
Depuis l'onglet groupe du profil
    [Arguments]  ${profil}

    Depuis le contexte du profil  null  ${profil}
    On clique sur l'onglet  lien_om_profil_groupe  Groupe