<?php
/**
 * Ce fichier permet de déclarer la classe Services, classe de base pour
 * toutes les ressources exposées à travers l'interface REST.
 *
 * @package openfoncier
 * @version SVN : $Id: services.php 4418 2015-02-24 17:30:28Z tbenita $
 */

/**
 * Cette classe instancie la classe utils pour établir une connexion à la base
 * de données et accéder aux méthodes principales de cette classe. Elle contient
 * également les méthodes permettant de vérifier l'intégrité REST des requêtes
 * reçues. On trouve la définition du comportement par défaut pour les méthodes
 * POST, PUT, GET, DELETE. Les méthodes de retour/réponse à la requête REST sont
 * aussi définies ici.
 */
class Services {

    /**
     * Constructeur
     *
     * Initialise les attributs de la classe.
     */
    public function __construct() {

        /**
         * Définition de la constante 'REST_REQUEST' qui est un marqueur
         * permettant d'indiquer que nous sommes dans le contexte d'une requête
         * REST. Par exemple, ce marqueur permet de ne pas afficher les erreurs
         * lors des traitements dans om_dbform.class.php.
         */
        if (!defined('REST_REQUEST')) {
            define('REST_REQUEST', true);
        }

        /**
         * @var mixed Cet attribut contient les données JSON reçues dans la
         * requête REST. C'est un tableau associatif. Il est utilisé lors de
         * la vérification de la validité du format de la requête REST (voir
         * la méthode requestValid).
         */
        $this->contents = array();

        /**
         * @var resource Cet attribut est l'intance du metier_manager qui permet
         * d'effectuer le traitement sur les données. L'instanciation est faite
         * dans une des classes enfants en fonctione de la ressource.
         */
        $this->metier_manager = null;

        /**
         * @var mixed Cet attribut est utilisé lors de la vérification de la
         * validité du format de la requête. Lorsque les données transmises
         * peuvent être différentes selon la requête alors il est nécessaire
         * d'avoir des groupes de validation. Chaque élément de mdtry_groups,
         * appelé un groupe, est traité comme un tableau. Toutes les chaines
         * trouvées dans un groupe doivent être présentes dans le tableau JSON
         * reçu. Cet attribut doit être rempli dans les classes dérivées.
         */
        $this->mdtry_grps = null;

    }

    /**
     * Destructeur
     *
     * Détruit les variables.
     */
    public function __destruct() {

        // Si un metiermanager est défini alors on le détruit
        if ($this->metier_manager) {
            unset($this->metier_manager);
        }

    }

    /**
     * Cette méthode vérifie si le format des données JSON reçues dans la
     * requête REST est valide.
     *
     * @param mixed $data Le tableau contenant les données reçues
     * @param mixed $optional Une liste des éléments pour lequel l'attribut
     * contents est autorisé à avoir une valeur vide
     * @return bool Renvoi true si le format des données est valide sinon false
     */
    protected function requestValid($data, $optional = null) {

        // Si le tableau est vide alors on retourne false
        if (count($data) == 0) {
            return false;
        }

        // Remplissage de l'attribut contents avec les données reçues
        foreach (array_keys($this->contents) as $elem) {
            if (isset($data[$elem])) {
                $this->contents[$elem] = $data[$elem];
            }
        }

        // Vérification que toutes les données nécessaires sont présentes à
        // moins qu'elle soit optionnelle
        foreach ($this->contents as $key => $value) {
            // Si la valeur est vide
            if (empty($value)) {
                // Si cette clé est optionnelle alors on passe à l'itération
                // suivante
                if ($optional && in_array($key, $optional)) {
                    continue;
                }
                // Si cette clé n'est pas optionnelle alors on retourne false
                return false;
            }
        }

        // On retourne true
        return true;

    }

    /**
     * Cette méthode permet de vérifier si les données transmises correspondent
     * à l'attendu. L'attendu est paramétré dans l'attribut 'mdtry_grps' par les
     * classes qui surcharge la classe Services. Si les données correspondent
     * alors on renvoi la clé du tableau vérifié sinon c'est la valeur NULL
     * qui est retournée.
     * 
     * @param mixed $data Le tableau contenant les données reçues via REST
     */
    protected function requestMdtrGroup(&$data) {

        // Si l'attribut est NULL alors on retourne NULL
        if (is_null($this->mdtry_grps)) {
            return NULL;
        }

        // On boucle sur chacun des groupes
        foreach ($this->mdtry_grps as $key => $group) {
            // On définit un marqueur pour le groupe
            $group_is_correct = NULL;
            // On boucle sur chacun des éléments du groupe
            foreach ($group as $elem) {
                // Si l'élément du groupe correspond
                if (isset($data[$elem]) && !empty($data[$elem])) {
                    // Si le marqueur est NULL alors on le marque à true
                    if (is_null($group_is_correct)) {
                        $group_is_correct = true;
                    }
                } else {
                    // Si l'élément ne correspond pas on passe au groupe suivant
                    $group_is_correct = false;
                    break;
                }
            }
            // Le groupe n'est pas correct alors on passe au groupe suivant
            if ($group_is_correct != true) {
                continue;
            }
            // Si le groupe est correct alors on retourne la clé du groupe
            return $key;
        }

        // Aucun groupe n'est correct alors on retourne NULL
        return NULL;

    }

    /**
     * Cette méthode permet de définir le traitement du POST sur une requête
     * REST. Elle doit être surchargée par la ressource si nécessaire. Le
     * comportement par défaut est de retourner une erreur 400.
     * 
     * @param mixed $request_data Les données JSON reçues (voir @uses)
     * 
     * @uses ./restler La librairie restler, lors de l'utilisation des méthodes
     * PUT et POST, la méthode qui reçoit les données entrantes DOIT contenir
     * un paramètre appellé request_data. En effet la librairie stocke la chaine
     * JSON reçue convertie en un tableau dans le paramètre request_data.
     */
    public function post($request_data) {
        // Log - services.log
        $this->log(__METHOD__." - ".print_r($request_data, true));
        //
        return $this->sendHttpCode(400, "La méthode POST n'est pas disponible".
                                   " sur cette ressource.");
    }

    /**
     * Cette méthode permet de définir le traitement du GET sur une requête
     * REST. Elle doit être surchargée par la ressource si nécessaire. Le
     * comportement par défaut est de retourner une erreur 400.
     *
     * @param string $id L'identifiant de la ressource
     */
    public function get($id) {
        // Log - services.log
        $this->log(__METHOD__." - id:".$id);
        //
        return $this->sendHttpCode(400, "La méthode GET n'est pas disponible".
                                   " sur cette ressource.");
    }

    /**
     * Cette méthode permet de définir le traitement du PUT sur une requête
     * REST. Elle doit être surchargée par la ressource si nécessaire. Le
     * comportement par défaut est de retourner une erreur 400.
     *
     * @param string $id L'identifiant de la ressource
     * @param mixed $request_data Les données JSON reçues (voir @uses)
     *
     * @uses ./restler La librairie restler, lors de l'utilisation des méthodes
     * PUT et POST, la méthode qui reçoit les données entrantes DOIT contenir
     * un paramètre appellé request_data. En effet la librairie stocke la chaine
     * JSON reçue convertie en un tableau dans le paramètre request_data.
     */
    public function put($id, $request_data) {
        // Log - services.log
        $this->log(__METHOD__." - id:".$id." - ".print_r($request_data, true));
        //
        return $this->sendHttpCode(400, "La méthode PUT n'est pas disponible".
                                   " sur cette ressource.");
    }

    /**
     * Cette méthode permet de définir le traitement du DELETE sur une requête
     * REST. Elle doit être surchargée par la ressource si nécessaire. Le
     * comportement par défaut est de retourner une erreur 400.
     *
     * @param string $id L'identifiant de la ressource
     */
    public function delete($id) {
        // Log - services.log
        $this->log(__METHOD__." - id:".$id);
        //
        return $this->sendHttpCode(400, "La méthode DELETE n'est pas".
                                   " disponible sur cette ressource.");
    }

    /**
     * Cette méthode envoi une réponse en fonction du résultat du traitement
     * de la requête.
     *
     * @param string $result Le résultat du traitement
     * @param string $msg Le message additionnel à envoyer
     *
     * @todo XXX Vérifier la logique de traitement de cette méthode
     */
    protected function sendReply($result, $msg) {

        // Si le résultat de la requête n'est pas correct
        if ($result != 'OK') {

            // Si il y a eut un problème avec les données, alors on retourne un
            // code 400  et le message additionnel
            if ($result == 'BAD_DATA') {
                return $this->sendHttpCode(400, $msg);
            }

            // Si il y a eut un problème dans le traitement, alors on retourne
            // un code 500 avec le message additionnel
            return $this->sendHttpCode(500, $msg);

        }

        // Si le résultat de la requête est correct, alors on retourne un code
        // 200 et le message additionnel
        return $this->sendHttpCode(200, $msg);

    }

    /**
     * Cette méthode permet de retourner la réponse à la requête REST.
     *
     * @param int|string $http_code Le code HTTP à envoyer
     * @param string $message Le message additionnel à envoyer
     * @return mixed En-tête HTTP et tableau résultat de la requête REST
     *
     * @todo Modifier le tableau de retour pour qu'il ressemble au tableau
     * de retour d'erreur fourni par restler lors d'un 404 par exemple
     */
    protected function sendHttpCode($http_code, $message = '') {

        // Définition du protocole HTTP
        $http_protocol = "HTTP/1.0"; 
        if (isset($_SERVER['SERVER_PROTOCOL'])
            && stripos($_SERVER['SERVER_PROTOCOL'],"HTTP") >= 0) {
            $http_protocol = $_SERVER['SERVER_PROTOCOL'];
        }

        // Définition des codes HTTP
        $http = array(
            200 => '200 OK',
            201 => '201 Created',
            204 => '204 No Content',
            400 => '400 Bad Request',
            401 => '401 Unauthorized',
            403 => '403 Forbidden',
            404 => '404 Not Found',
            409 => '409 Conflict',
            500 => '500 Internal Server Error',
        );

        // Gestion du paramètre $http_code - les types int et string peuvent
        // être reçus
        if (!is_numeric($http_code)) {
            $http_code = intval($http_code);
        }

        // Envoi de l'en-tête HTTP
        header($http_protocol." ".$http[$http_code]);

        //
        $output = array(
            'http_code' => $http_code,
            'http_code_message' => $http[$http_code],
            'message' => $message,
        );

        // Log - services.log
        $this->log(get_called_class()."::".__FUNCTION__." - ".print_r($output, true));

        // Retour du tableau résultat
        return $output;

    }

    /**
     *
     */
    var $log_services = null;

    /**
     *
     */
    function log($message) {
        //
        if ($this->log_services === null) {
            //
            require_once "../obj/utils.class.php";
            $this->log_services = logger::instance();
        }
        //
        $this->log_services->log_to_file("services.log", "IN - ".$message);
    }


    /**
     * Permet de réduire la chaîne de caractères de certaines données envoyées
     * par requête.
     *
     * @param string $request_data Données de la requête.
     *
     * @return string Données de la requête réduit.
     */
    protected function short_request_data_for_log($request_data) {
        // Réduit la taille de la chaine de caractère lorsqu'il s'agit d'un
        // fichier en base64.
        if (isset($request_data['fichier_base64'])) {
            //
            $request_data['fichier_base64'] = substr($request_data['fichier_base64'], 0, 3).'...'.substr($request_data['fichier_base64'], -3);
        }

        //
        return $request_data;
    }


}

?>
