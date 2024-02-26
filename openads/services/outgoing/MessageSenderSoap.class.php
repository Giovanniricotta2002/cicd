<?php
/**
 * Classe générique d'envoi de requête SOAP avec la librairie SOAP de php
 * 
 *  @package openads
 */

class MessageSenderSoap {

    /**
     * Pour les requêtes avec authentification
     * @var string
     * @var string
     */
    private $login;
    private $password;
    /**
     * Le client soap
     * @var SoapClient
     */
    private $soap;
    /**
     * Les données à envoyer
     * @var array
     */
    private $data;
    /**
     * L'header retourné par une requête
     * @var SoapHeader
     */
    private $headers = array(
        'Content-Type' => "",
        'HTTP' => "",
    );
    /**
     * La réponse de la requête
     * @var array
     */
    private $response;
    /**
     * Le tableau d'erreur qu'un appel a généré
     * @var array
     */
    private $fault;
    /**
     * L'URI du fichier WSDL
     * @var string
     */
    private $wsdl;
    /**
     * Le message d'erreur qu'un appel a généré
     * @var string
     */
    private $errormessage;
    /**
     * La liste des fonctions SOAP du WSDL
     * @var string
     */
    private $functions = NULL;
    /**
     * La liste des types SOAP du WSDL
     * @var string
     */
    private $types = NULL;
    
    /**
     * Constructeur
     */
    public function __construct($wsdl = NULL, $login = NULL, $password = NULL, 
        $options = NULL){
        
        //Initialisation des variables de la classe
        $this->login = $login;
        $this->password = $password;
        $this->wsdl = $wsdl;

        // Options de contexte pour les protocoles http:// et https://.
        $context_http_options = array(
            // Version du protocole HTTP 
            // Depuis PHP 5.3.0, la version du protocole par défaut est 1.1, il
            // faut donc préciser la verision 1.0
            "protocol_version" => 1.0
        );
        
        //Options du client SOAP
        $options = (is_null($options))?array(
            "login" => $this->login,
            "password" => $this->password,
            "authentication" => SOAP_AUTHENTICATION_BASIC,
            "trace" => TRUE,
            "exceptions" => TRUE,
            "cache_wsdl" => WSDL_CACHE_NONE,
            "stream_context" => stream_context_create(
                array(
                    "http" => $context_http_options
                )
            )
        ) : $options;
        
        //Initialisation du client SOAP
        try {
            $this->soap = new SoapClient($this->wsdl,$options);
        } catch (SoapFault $fault) {
            $this->setFault($fault);
            //
            $errormessage = $fault->faultcode." : ".$fault->faultstring;
            $this->setErrorMessage("<br/> Erreur : ".$errormessage);
            //
            $this->log(
                sprintf(
                    '%s / ERREUR initialisation du client SOAP : %s',
                    __METHOD__,
                    getcwd(),
                    $errormessage
                )
            );
            //
            return false;
        }
        //
        return true;
    }
    
    /**
     * Lance l'appel au webservice
     * @param string $method
     * @param string $contentType
     * @param string $file
     * 
     * @return Retourne la réponse du webservice ou -1 en cas d'erreur
     */
    public function execute($method, $data, $options = array(), 
        $input_headers = array(), &$output_headers = array()){
        
        //
        $this->log(
            sprintf(
                '%s / method : %s / data : %s',
                __METHOD__,
                $method,
                str_replace("    ", " ", str_replace("\n", "", print_r($data, true)))
            )
        );

        //        
        $response = NULL;
        
        //L'URL d'envoi doit être non vide
        if (is_null($this->getWsdl())) {
            //
            $errormessage = "L'URL d'envoi doit être non vide";
            $this->log(
                sprintf(
                    '%s / method : %s / ERREUR : %s',
                    __METHOD__,
                    $method,
                    $errormessage
                )
            );
            return -1;
        }

        $soapClient = $this->getSoap();
        //Tente un appel à la méthode passée en paramètre
        if (isset($soapClient)) {
            //
            try {
                //
                $response = $soapClient->__soapCall(
                    $method,
                    array($data),
                    $options,
                    $input_headers,
                    $output_headers
                );
            } catch (SoapFault $fault) {
                //
                $this->setFault($fault);
                //
                $errormessage = "Requete : ".htmlentities($soapClient->__getLastRequest())."<br/> Erreur ".$fault->faultcode." : ".$fault->faultstring;
                $this->setErrorMessage($errormessage);
                //
                $this->log($errormessage);
                return -1;
            }
        } else {
            //
            $errormessage = "Le Client SOAP n'est pas initialise";
            $this->log(
                sprintf(
                    '%s / method : %s / ERREUR : %s',
                    __METHOD__,
                    $method,
                    $errormessage
                )
            );
            return -1;
        }
        //
        if (is_null($response)) {
            $response = -1;
        }
        $this->setResponse($response);
        //
        $this->treatResponse();
        //
        $this->log(
            sprintf(
                '%s / method : %s / response : %s',
                __METHOD__,
                $method,
                str_replace("    ", " ", str_replace("\n", "", print_r($this->getResponse(), true)))
            )
        );
        //
        return $this->getResponse();
    }
    
    /**
     * Va traiter le retour de l'exécution d'une requête afin d'en extraire l'header 
     * et la réponse.
     */
    private function treatResponse(){
        
        $headers = array();
        //Si la réponse n'est pas vide et il n'y a pas eût d'erreur
        if ( $this->getResponse() !== NULL && $this->getResponse() !== -1 ){
            
            //Récupération des informations du transfert curl
            $info = $this->http_parse_headers($this->getSoap()->__getLastResponseHeaders());
            
            //Si la requête ne retourne aucune information
            if ( !is_array($info) ){
                return;
            }
            
            //Récupère le type de contenu et le code HTTP de la requête réponse
            $headers['Content-Type'] = $info['Content-Type'];
            $headers['HTTP'] = $info['HTTP'];
            
            $this->setHeaders($headers);
            
            //Transforme la réponse en tableau associatif
            $this->setResponse(json_decode(json_encode($this->getResponse()), true));
        }
    }
    
    /**
     * Parse un header HTTP
     * @param string $header
     * 
     * @return array 
     */
    function http_parse_headers( $header ) {
        
        $retVal = array();
        $fields = explode("\r\n", preg_replace('/\x0D\x0A[\x09\x20]+/', ' ', $header));
        
        foreach( $fields as $field ) {
            
            if( preg_match('/([^:]+): (.+)/m', $field, $match) ) {
                    
                $match[1] = preg_replace_callback('/(?<=^|[\x09\x20\x2D])./', function($m){ return strtoupper($m[0]); }, strtolower(trim($match[1])));
                if( isset($retVal[$match[1]]) ) {
                    $retVal[$match[1]] = array($retVal[$match[1]], $match[2]);
                } 
                else {
                    $retVal[$match[1]] = trim($match[2]);
                }
            }
            elseif(preg_match('|HTTP/\d\.\d\s+(\d+)\s+.*|',$field,$match)){
                $retVal["HTTP"] = trim($match[1]);
            }
        }
        return $retVal;
    } 
    
    // {{{ Accesseur    
    /**
     * @return string 
     */
    public function getErrorMessage() {
        return $this->errormessage;
    }
    
    /**
     * @return SoapClient 
     */
    public function getSoap() {
        return $this->soap;
    }
    
    /**
     * @return string 
     */
    public function getWsdl() {
        return $this->wsdl;
    }
    
    /**
     * @return array 
     */
    public function getResponse() {
        return $this->response;
    }
    
    /**
     * @return numeric 
     */
    public function getResponseCode() {
        return $this->headers['HTTP'];
    }
    
    /**
     * @return string 
     */
    public function getResponseContentType() {
        return $this->headers['Content-Type'];
    }
    
    /**
     * Cette fonction retourne la liste des fonctions décrites dans le WSDL, s'il a
     * été fourni, sinon elle retourne -1
     * @return mixed 
     */
    public function getFunctions() {
        
        //Si un WSDL a été fourni et que les fonctions n'avaient jamais été demandées
        if ( !is_null($this->getWsdl()) && is_null($this->functions)){
            $this->functions = $this->getSoap()->__getFunctions();
            return $this->functions;
        }
        //Si un WSDL a été fourni et que les fonctions avaient déjà été demandées
        elseif(!is_null($this->getWsdl()) && !is_null($this->functions)){
            return $this->functions;
        }
        //Sinon on retourne une erreur
        else{
            return -1;
        }
    }
    
    /**
     * Cette fonction retourne la liste des types SOAP décrites dans le WSDL, s'il a
     * été fourni, sinon elle retourne -1
     * @return mixed 
     */
    public function getTypes() {
        
        //Si un WSDL a été fourni et que les types n'avaient jamais été demandés
        if ( !is_null($this->getWsdl()) && is_null($this->types)){
            $this->types = $this->getSoap()->__getTypes();
            return $this->types;
        }
        //Si un WSDL a été fourni et que les types avaient déjà été demandés
        elseif(!is_null($this->getWsdl()) && !is_null($this->types)){
            return $this->types;
        }
        //Sinon on retourne une erreur
        else{
            return -1;
        }
    }

    /**
     * @return array 
     */
    public function getFault() {
        return $this->fault;
    }

    // }}}
    
    // {{{ Mutateur
    /**
     * Met à jour le message d'erreur.
     * @param array $errormessage
     */
    public function setErrorMessage($errormessage) {
        $this->errormessage=$errormessage;
    }
    
    /**
     * Met à jour la réponse.
     * @param string $response
     */
    public function setResponse($response) {
        $this->response=$response;
    }
    
    /**
     * Met à jour le header.
     * @param array $headers
     */
    public function setHeaders($headers) {
        $this->headers=$headers;
    }

    /**
     * Met à jour le retour d'erreur
     * @param array $fault
     */
    public function setFault($fault) {
        $this->fault=$fault;
    }

    // }}}

    /**
     *
     */
    var $log_services = null;

    /**
     *
     */
    function log($message) {
        //
        if ($this->log_services == null) {
            //
            require_once "../obj/utils.class.php";
            $this->log_services = logger::instance();
        }
        //
        $this->log_services->log_to_file("services.log", "OUT - ".$message);
    }

}

?>
