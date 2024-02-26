<?php
/**
 * La classe 'geoads' est une classe d'abstraction, spécifique à openADS,
 * permettant de gérer les requêtes vers divers webservices SIG et ainsi
 * proposer aux utilisateurs des informations géographiques.
 * Cette classe est instanciée et utilisée par d'autres scripts pour
 * gérer notamment la vérification de parcelles et ce peu importe le SIG utilisé.
 * Son objectif est d'instancier les classes spécifiques aux SIG aussi appelées
 * connecteurs correspondant au paramétrage de la collectivité.
 * 
 * Ces connecteurs héritent de la classe 'geoads_base' qui leur sert de modèle.
 *
 * Enfin la classe 'geoads_exception' permet de gérer les erreurs.
 * Plusieurs classes en héritent afin de spécifier le type d'exception.
 * 
 * @package openads
 * @version SVN : $Id$
 */

/**
 * Abstracteur de la géolocalisation spécifique à openADS
 */
class geoads {
    /**
     * Cet attribut permet de stocker l'instance du connecteur SIG utilisé.
     * Sa valeur doit être remplie en fonction du paramétrage de la collectivité.
     *
     * @var object  instance du connecteur SIG
     */
    var $sig = null;


    /**
     * Le constructeur instancie la classe du SIG envoyée par le paramétrage
     * de la collectivité.
     *
     * @param  array  $collectivite  Identifiant de la collectivité.
     * @param  array  $extra_params  Tableau de paramètres en extra
     * 
     * @return geoads Instance geoads
     */
    public function __construct(array $collectivite, array $extra_params = array()) {
        // Récupération de la conf sig de la collectivité
        $this->collectivite = $collectivite;
        if(!isset($this->collectivite['sig'])) {
            throw new geoads_configuration_exception("Pas de SIG configuré pour la collectivité");
        }
        // instanciation du connecteur
        $path = "";
        if(isset($this->collectivite['sig']['path'])) {
            $path = $this->collectivite['sig']['path'];
        }
        $connecteur = 'geoads_'.$this->collectivite['sig']['connector'];
        require_once $path.$connecteur.'.class.php';
        $this->sig = new $connecteur($this->collectivite, $extra_params);
    }

    
    /**
     * Le destructeur permet de détruire la ressource instanciée
     * dans le constructeur
     */
    public function __destruct() {
        if ($this->sig != null) {
            unset($this->sig);
        }
    }


    /**
     * GET- Vérification d'existence de parcelles et récupération de leurs adresses.
     * 
     * openADS fournit une liste de parcelles. Le SIG renvoie une collection,
     * en mentionnant pour chaque parcelle si elle existe, et le cas échéant
     * l'adresse qui y est rattachée.
     * 
     * @param array $parcelles Tableau de parcelles à interroger.
     *                         Exemple de structure du tableau d'entrée pour une
     *                         seule parcelle :
     *                         array (
     *                             array(
     *                                 'prefixe' => string,
     *                                 'quartier' => string,
     *                                 'section' => string,
     *                                 'parcelle' => string
     *                             ), // ...
     *                         ).
     * 
     * @return array Tableau de résultats (un sous-tableau par parcelle) :
     *               array(
     *                   array (
     *                       "parcelle"=> "1312158980H0126",
     *                       "existe"=> true,
     *                       "adresse"=> array (
     *                           "numero_voie"=> "666", 
     *                           "type_voie"=> "RUE", 
     *                           "nom_voie"=> "DE LA LIBERTE",
     *                           "arrondissement"=> "11"
     *                       )
     *                   ), // ...
     *               )
     *               La parcelle n'existe pas :
     *               array(
     *                   array (
     *                       "parcelle"=> "1312158980H0126",
     *                       "existe"=> false,
     *                   ), // ...
     *               )
     */
    public function verif_parcelle(array $parcelles) {

        // S'il ne s'agit pas d'un ensemble de parcelles
        if (!is_array($parcelles) or empty($parcelles)){
            // On lève une exception
            throw new geoads_parameter_exception(_("Veuillez vérifier que les references cadastrales ont bien ete saisies"));
        }

        // On retourne les parcelles
        return $this->sig->verif_parcelle($parcelles);
    }


    /**
     * POST -Déclenche sur lme SIG le calcul de l'emprise des parcelles d'un dossier.
     * 
     * openADS fournit une liste de parcelles et le numéro de dossier correspondant.
     * Le SIG renvoie un statut, spécifiant si le calcul été effectué correctement ou non.
     * 
     * @param array  $parcelles Tableau de parcelles.
     *                          Exemple de structure du tableau d'entrée pour une
     *                          seule parcelle :
     *                          array (
     *                              array(
     *                                  'prefixe' => string,
     *                                  'quartier' => string,
     *                                  'section' => string,
     *                                  'parcelle' => string
     *                              ), // ...
     *                          ).
     * @param string $dossier   Numéro du dossier. Ex. : PC1305515J0045P0.
     * 
     * @return boolean true si le calcul est OK, false sinon
     */
    public function calcul_emprise(array $parcelles, $dossier) {
        // S'il ne s'agit pas d'un ensemble de parcelles ou manque le dossier
        if (empty($parcelles) && empty($dossier)) {
            // On lève une exception
            throw new geoads_parameter_exception();
        }
        // Retourne true ou false
        return $this->sig->calcul_emprise($parcelles, $dossier);
    }

    /**
     * POST - Réplique la géolocalisation d'un dossier sur un autre.
     *
     * @param  string  $from  Numéro du dossier à partir duquel répliquer
     * @param  string    $to  Numéro du dossier à géolocaliser
     *
     * @return  bool  'true' si l'opération réussi, 'false' sinon
     */
    public function replicate_geolocalisation(string $from, string $to) {
        if (empty($from) || empty($to)) {
            throw new geoads_parameter_exception("Dossier non spécifié");
        }
        return $this->sig->replicate_geolocalisation($from, $to);
    }

    /**
     * POST - Déclenche sur le SIG le calcul du centroïde d'un dossier.
     * 
     * openADS appelle la méthode centroide sur la ressource du dossier souhaité.
     * Si le calcul du centroïde est conduit avec succès, le SIG renvoie un
     * statut positif, accompagné des coordonnées du centroïde. Dans le cas
     * contraire, le SIG renvoie un statut négatif.
     * 
     * @param string $dossier Numéro du dossier. Ex. : PC1305515J0045P0.
     * 
     * @return mixed Coordonnées du centroïde et les attributs "parcelles" et "surface"
     *               array(
     *                   "statut_calcul_centroide" => true,
     *                   "x" => "1888778.84",
     *                   "y" => "3131268.88",
     *                   "parcelles" => "3200432AB0234;3200432AB0235",
     *                   "surface" => "72",
     *               )
     *               ou false si le calcul a échoué
     */
    public function calcul_centroide($dossier) {
        // S'il manque le dossier
        if ($dossier == ""){
            // On lève une exception
            throw new geoads_parameter_exception();
        }
        // Centroid ou false
        return $this->sig->calcul_centroide($dossier);
    }


    /**
     * GET - Récupération des contraintes applicables sur un dossier.
     * 
     * openADS appelle la méthode contrainte sur la ressource du dossier souhaité.
     * Le SIG renvoie une collection de contraintes qui s'y appliquent.
     * 
     * @param string $dossier Numéro du dossier. Ex. : PC1305515J0045P0.
     *
     * @return array Tableau de contraintes :
     *                       array(
     *                          array(
     *                              "contrainte" => "26",
     *                              "groupe_contrainte" => "ZONES DU PLU",
     *                              "sous_groupe_contrainte" => "protection",
     *                              "libelle" => "Une seconde contrainte du PLU",
     *                          ), // ...
     *                       )
     */
    public function recup_contrainte_dossier($dossier) {
        // S'il manque le dossier
        if ($dossier == ""){
            // On lève une exception
            throw new geoads_parameter_exception();
        }

        // récupère les contraintes applicables sur un dossier
        return $this->sig->recup_contrainte_dossier($dossier);
    }


    /**
     * GET - Récupération de toutes les contraintes existantes pour une commune.
     * 
     * OpenADS appelle le SIG en précisant seulement le code INSEE de la commune.
     * Il renvoie une collection de l'intégralité des contraintes existantes.
     * 
     * @return array Tableau de toutes les contraintes existantes.
     *                       array(
     *                          array(
     *                              "groupe_contrainte" => "ZONES DU PLU",
     *                              "contrainte" => "26",
     *                              "libelle" => "Une seconde contrainte du PLU",
     *                              "sous_groupe_contrainte" => "protection",
     *                          )
     *                       )
     */
    public function recup_toutes_contraintes() {

        // récupère les contraintes applicables sur la commune
        return $this->sig->recup_toutes_contraintes($this->collectivite["insee"]);
    }


    /**
     * Redirection vers le SIG dans le contexte de dessin d'emprise pour un
     * dossier.
     *
     * @param array  $parcelles Tableau de parcelles.
     * @param string $dossier   L'identifiant du dossier.
     *
     * @return string L'url du SIG
     */
    public function redirection_web_emprise(array $parcelles, $dossier) {
        //
        return $this->sig->redirection_web_emprise($parcelles, $dossier);
    }


    /**
     * Redirection vers le SIG dans le contexte de visualisation du dossier.
     * Si les deux arguments sont nuls, c'est l'url par défaut du sig qui doit
     * être retourné.
     *
     * @param array  $parcelles Tableau de parcelles.
     * @param string $dossier   L'identifiant du dossier.
     *
     * @return string L'url du SIG
     */
    public function redirection_web(array $parcelles = null, $dossier = null) {

        // récupère les contraintes applicables sur un dossier
        return $this->sig->redirection_web($parcelles, $dossier);
    }

    /**
     * Vérifie si le connecteur implémente une certaine méthode (publique).
     *
     * @param  string  $name  Nom de la méthode
     * @param    bool  $self  'true' pour que la méthode ne soit pas héritée
     *
     * @return bool  'true' si la méthode est implémentée par le connecteur
     */
    public function methodIsImplemented(string $method, bool $self = true) {
        if (! empty($this->sig)) {
            $class = new ReflectionClass($this->sig);
            $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);
            $classname = get_class($this->sig);
            $methodsFiltered = array_filter(
                $methods,
                function ($m) use ($method, $classname, $self) {
                    return $m->name == $method && (! $self || $m->class == $classname);
                });
            return ! empty($methodsFiltered);
        }
        return false;
    }

    /**
     * Supprime l'emprise d'un dossier dans le SIG.
     *
     * @param  string  $dossier  l'identifiant du dossier à supprimer
     *
     * @return bool  'true' si la suppression a réussi, 'false' sinon
     *               ou 'null' si l'emprise n'existait pas
     */
    public function supprime_emprise(string $dossier) {
        return $this->sig->supprime_emprise($dossier);
    }
}

/**
 * Classe parente de tous les connecteurs SIG
 */
class geoads_base {

    /**
     * Handler d'envoi de messages REST ou SOAP.
     *
     * @var null
     */
    var $messageSender = null;

     /**
     * Paramètres de connexion au sig
     *
     * @var array
     */
    var $sig_parameters = array();

    /**
     * Paramètres de la collectivite
     *
     * @var array
     */
    var $collectivite_parameters = array();

    /**
     * Tableau de paramètres en extra
     * 
     * @var array
     */
    protected $extra_params = array();


    /**
     * Le constructeur instancie le connecteur SIG selon la configuration
     *
     * @param array $collectivite Configuration du connecteur.
     * @param  array  $extra_params  Tableau de paramètres en extra
     * 
     * @return geoads Instance geoads
     */
    public function __construct(array $collectivite, array $extra_params = array()) {
        // Liste des paramètres extra
        $this->extra_params = $extra_params;
        // Config du connecteur SIG de la collectivité en attribut
        $this->set_sig_config($collectivite['sig']);
        // Parametres de la collectivité
        $this->set_collectivite_parameters($collectivite);
        // Instance de la classe permettant d'envoyer des requêtes REST
        $this->init_message_sender();
    }


    public function init_message_sender() {
        // Cette méthode doit être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    public function verif_parcelle(array $parcelles) {
        // Cette méthode doit être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    public function calcul_emprise(array $parcelles, $dossier) {
        // Cette méthode doit être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    public function replicate_geolocalisation(string $from, string $to) {
        // Cette méthode doit être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    public function supprime_emprise(string $dossier) {
        // Cette méthode peut être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    public function calcul_centroide($dossier) {
        // Cette méthode doit être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    public function recup_contrainte_dossier($dossier) {
        // Cette méthode doit être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    public function recup_toutes_contraintes($code_insee) {
        // Cette méthode doit être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    public function redirection_web_emprise(array $parcelles, $dossier) {
        // Cette méthode doit être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    public function redirection_web(array $parcelles = null, $dossier = null) {
        // Cette méthode doit être implémentée par tous les connecteurs
        throw new geoads_connector_method_not_implemented_exception();
    }


    /**
     * Défini l'attribut contenant le tableau de configuration du SIG.
     *
     * @param array $conf Tableau de config.
     */
    public function set_sig_config(array $conf) {
        $this->sig_parameters = $conf;
    }

    /**
     * Défini les paramètres de la collectivite
     *
     * @param array $conf Tableau de config de la collectivité.
     */
    public function set_collectivite_parameters(array $collectivite) {
        $this->collectivite_parameters["departement"] = strtoupper($collectivite["departement"]);
        // Ce om_parametre peut ne pas être défini selon la configuration
        if (isset($collectivite["code_direction"]) === true) {
            $this->collectivite_parameters["code_direction"] = $collectivite["code_direction"];
        }
        $this->collectivite_parameters["commune"] = $collectivite["commune"];
        $this->collectivite_parameters["insee"] = $collectivite["insee"];
        $this->collectivite_parameters["om_collectivite_idx"] = $collectivite["om_collectivite_idx"];
    }


    /**
     * Permet de récupérer un élement de configuration.
     *
     * @param string $key Nom de la clé de l'élément.
     *
     * @return string Valeur de la config.
     */
    public function get_sig_config($key) {
        if(isset($this->sig_parameters[$key]) === false) {
            throw new geoads_configuration_exception("Élément de configuration '$key' non trouvé");
            
        }
        return $this->sig_parameters[$key];
    }


    /**
     * Permet de récupérer un élement de paramétrage de la collectivité.
     *
     * @param string $key Nom de la clé de l'élément.
     *
     * @return string Valeur de la config.
     */
    public function get_collectivite_parameter($key) {
        if(isset($this->collectivite_parameters[$key]) === false) {
            throw new geoads_configuration_exception("Élément de paramétrage '$key' non trouvé");
            
        }
        return $this->collectivite_parameters[$key];
    }

    /**
     * Permet de lancer une requête sql dans la base de données de l'application.
     * La requête sql doit être un SELECT.
     *
     * @param  string  $query_sql  Requête sql à exécuter.
     * 
     * @return array|boolean Résultat de la requête sql ou false.
     */
    protected function query_db($query_sql, $force_return = true) {
        if (isset($this->extra_params['inst_framework']) === false) {
            throw new geoads_exception(__("Il est nécessaire de passer l'instanciation du framework en paramètre pour réaliser des requête en base de données depuis un connecteur SIG."));
        }
        $inst_framework = $this->extra_params['inst_framework'];
        if (stripos($query_sql, 'SELECT') === false) {
            throw new geoads_exception('Seules les requêtes SQL SELECT sont autorisées.');
        }
        return $inst_framework->get_all_results_from_db_query(
            $query_sql,
            array(
                "origin" => __METHOD__,
                "force_return" => $force_return,
            )
        );
    }


}

/**
 * Classe gérant les erreurs (une exception est levée pour chacune).
 */
class geoads_exception extends Exception {


    /**
     * Construit l'exception
     *
     * @param string    $message  Le message de l'exception à lancer.
     * @param integer   $code     Le code de l'exception.
     * @param Exception $previous L'exception précédente, utilisée pour le chaînage d'exception.
     */
    public function __construct($message = "" , $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        logger::instance()->writeErrorLogToFile();
        logger::instance()->cleanLog();
    }


    /**
     * Cette fonction ajoute dans le fichier de log.
     * 
     * @param string $code Le nom de fichier, ou l'identifiant du fichier.
     * @param string $msg  Le message a logger.
     */
    protected function addToLog($code, $msg) {
        require_once PATH_OPENMAIRIE."om_logger.class.php";
        logger::instance()->log("SIG Connector - Error code : ".$code." -> ".$msg);
    }


}

class geoads_bdd_exception extends geoads_exception {


    /**
     * Redéfinition du message d'erreur.
     */
    public function __construct() {
        $message = _("Erreur de base de donnees. Contactez votre administrateur.");
        // Appel du parent
        parent::__construct($message);
    }


}

class geoads_configuration_exception extends geoads_exception {


    /**
     * Redéfinition du message d'erreur.
     */
    public function __construct($msg = null) {
        $message = _("Erreur de configuration SIG.")." "._("Veuillez contacter votre administrateur.").(!empty($msg) ? " Details: $msg" : '');
        // Appel du parent
        parent::__construct($message);
    }


}

class geoads_parameter_exception extends geoads_exception {


    /**
     * Redéfinition du message d'erreur.
     */
    public function __construct($message = null) {
        if($message == null) {
            $message = _("Parametres d'appel au SIG non valides.")." "._("Veuillez contacter votre administrateur.");
        }
        // Appel du parent
        parent::__construct($message);
    }


}


/**
 * Classe de gestion des exceptions sur les methodes non implémentées
 */
class geoads_connector_method_not_implemented_exception extends geoads_exception {


    /**
     * Redéfinition du message d'erreur.
     */
    public function __construct() {
        $message = _("Erreur lors de la connexion au SIG.")." "._("Veuillez contacter votre administrateur");
        // Appel du parent
        parent::__construct($message);
    }


}

/**
 * Classe de gestion des exceptions retournée lors d'un code 4XX
 */
class geoads_connector_4XX_exception extends geoads_exception {


    /**
     * Redéfinition du message d'erreur.
     *
     * @param string  $message Message d'erreur http.
     * @param integer $code    Code de l'erreur http.
     */
    public function __construct($message, $code = null) {
        // Log de l'erreur technique
        $this->addToLog($code, $message);
        // Création du log utilisateur
        $message = _("Erreur lors de la connexion au SIG.")." "._("Veuillez contacter votre administrateur");
        // Appel du parent
        parent::__construct($message);
    }


}

/**
 * Classe de gestion des exceptions retournée lors d'un code 5XX
 */
class geoads_connector_5XX_exception extends geoads_exception {


    /**
     * Log et redéfinition du message d'erreur.
     *
     * @param string  $message Message d'erreur technique.
     * @param integer $code    Code de l'erreur http.
     */
    public function __construct($message, $code = null) {
        // Log de l'erreur technique
        $this->addToLog($code, $message);
        // Création du log utilisateur
        $message = _("Erreur de traitement du SIG.")." "._("Veuillez contacter le service responsable du SIG");
        // Appel du parent
        parent::__construct($message);
    }


}

/**
 * Classe de gestion des exceptions génériques remontées par le générateur
 */
class geoads_connector_exception extends geoads_exception {


    /**
     * Log et redéfinition du message d'erreur.
     *
     * @param string  $message Message d'erreur technique.
     * @param integer $code    Code de l'erreur http.
     */
    public function __construct($message = null, $code = null) {
        // Log de l'erreur technique
        $this->addToLog($code, $message);
        // Création du log utilisateur
        $message = _("Erreur SIG.")." "._("Veuillez contacter votre administrateur");
        // Appel du parent
        parent::__construct($message);
    }


}



