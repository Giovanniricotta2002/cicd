*** Settings ***
Documentation  WS Ressource REST 'dossier_autorisations'.

# On inclut les mots-clefs
Resource  resources/resources.robot
# On ouvre/ferme le navigateur au début/à la fin du Test Suite.
Suite Setup  For Suite Setup
Suite Teardown  For Suite Teardown


*** Test Cases ***
REST

    [Documentation]  Ce TestCase vérifie la partie REST du WS
    ...  - la seule méthode disponible est le PUT, les autres doivent retourner un code 400,
    ...  - les clés suivantes sont obligatoires dans le tableau JSON : type, date, emetteur, dossier_instruction, contenu. Si une des clés n'est pas présente ou si il y a une clé supplémentaire dans les données d'entrées, le WS doit retourner un code 400.

    ## Seule la méthode PUT doit être disponible sur cette ressource
    ${json} =  Set Variable  { "message": ""}
    Vérifier le code retour du web service et vérifier que son message est  Post  dossier_autorisations  ${json}  400  La méthode POST n'est pas disponible sur cette ressource.
    Vérifier le code retour du web service et vérifier que son message est  Delete  dossier_autorisations/123  null  400  La méthode DELETE n'est pas disponible sur cette ressource.

    ## L'identifiant est obligatoire
    # On ne fourni pas de numéro de dossier d'instruction
    ${json} =  Set Variable  { "message": "complet", "date": "${DATE_FORMAT_dd/mm/yyyy}"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_autorisations  ${json}  400  Aucun identifiant fourni pour la ressource.
    Vérifier le code retour du web service et vérifier que son message est  Get  dossier_autorisations  null  400  Aucun identifiant fourni pour la ressource.


Métier

    [Documentation]  Ce TestCase vérifie la partie Métier du WS
    ...  - ...

    ##
    #testDossierAutorisationMAJERP() {
    ${json} =  Set Variable  { "numero_erp": "12345"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_autorisations/PC0130551200001  ${json}  200  Numero ERP du batiment etait assigne au dossier d\'autorisation PC0130551200001

    #testDossierAutorisationERPOuvert() {
    ${json} =  Set Variable  { "erp_ouvert": "oui", "date_arrete": "20/04/2013"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_autorisations/PC0130551200001  ${json}  200  Signature de l'ouverture ERP au publique etait enregistre pour le dossier d'autorisation PC0130551200001

    #testDossierAutorisationDATArrete() {
    ${json} =  Set Variable  { "arrete_effectue": "oui", "date_arrete": "04/06/2014"}
    Vérifier le code retour du web service et vérifier que son message est  Put  dossier_autorisations/PC0130551200001  ${json}  200  Signature de l'ouverture ERP etait enregistre pour le dossier d'autorisation PC0130551200001

    #testDossierAutorisationGET() {
    Vérifier le code retour du web service et vérifier que son message est  Get  dossier_autorisations/PC0130551200001  null  200  Aucun message fourni
    # $this->assertEquals('"dossier_autorisation": "PC0130551200001",  "dossier_autorisation_type_detaille": "1",  "exercice": "",  "insee": "01234",  "terrain_references_cadastrales": "",  "terrain_adresse_voie_numero": "",  "terrain_adresse_voie": "",  "terrain_adresse_lieu_dit": "",  "terrain_adresse_localite": "",  "terrain_adresse_code_postal": "",  "terrain_adresse_bp": "",  "terrain_adresse_cedex": "",  "terrain_superficie": "",  "arrondissement": "",  "depot_initial": "2012-12-17",  "erp_numero_batiment": "12345",  "erp_ouvert": "f",  "erp_date_ouverture": "2013-04-20",  "erp_arrete_decision": "f",  "erp_date_arrete_decision": "2014-06-04",  "numero_version": "0",  "etat_dossier_autorisation": "1",  "date_depot": "",  "date_decision": "",  "date_validite": "",  "date_chantier": "",  "date_achevement": "",  "avis_decision": "",  "etat_dernier_dossier_instruction_accepte": "",  "dossier_autorisation_libelle": "PC 013055 12 00001",  "om_collectivite": "2",  "cle_acces_citoyen": ""',$message);
