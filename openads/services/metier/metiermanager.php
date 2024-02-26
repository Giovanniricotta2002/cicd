<?php
/**
 * Ce fichier permet de déclarer la classe de base MetierManager qui permet
 * de fournir des méthodes communes aux classes métiers effectuant les
 * traitements métiers nécessaires aux différentes ressources exposées.
 *
 * @package openfoncier
 * @version SVN : $Id: metiermanager.php 4843 2015-06-18 16:28:11Z nmeucci $
 */

//
require_once("../obj/utils.class.php");

/**
 *
 */
class MetierManager {

    /**
     * @access protected
     * @var string
     */
    var $KO = 'KO';
    var $OK = 'OK';
    var $NA = 'NA'; // not apllicable
    var $BAD_DATA = 'BAD_DATA';
    var $DEBUG = 0;
    /**#@-*/

    /**
     * Constructeur
     *
     * Attribue les valeurs au $_SESSION['collectivite'] et $_SESSION['login']
     * @todo La valeur stockee dans $_SESSION['collectivite'] doit etre
     * obtenue plutot que code en dur.
     * @todo La valeur stockee dans $_SESSION['login'] doit etre
     * obtenue plutot que code en dur.
     * @uses utils Utilise obj/utils.class.php pour etablir une connexion BD
     * @uses application::connectDatabase() Dans cette fonction l'execution
     * pourrait s'terminer si la connexion avec BD echuait. Pour empecher
     * que cela se produise, on mit $_SESSION['login'] a une valeur qui est
     * pas vide est qui donne l'utilisateur tout le droit necessaire.
     */
    public function __construct() {
        // Logger
        $this->addToLog("__construct(): start", EXTRA_VERBOSE_MODE);
        //
        $_POST["login_action_connect"] = true;
        if (file_exists("../dyn/services.inc.php") === true) {
            require_once "../dyn/services.inc.php";
        }
        if (isset($services_login) === true
            && is_string($services_login)) {
            //
            $_POST["login"] = $services_login;
        }
        if (isset($services_password) === true
            && is_string($services_password)) {
            //
            $_POST["password"] = $services_password;
        }
        //
        ob_start();
        //
        $this->f = new utils("login_and_nohtml");
        // Désactive l'affichage des logs
        $this->f->disableLog();
        // Permet lors de l'instantiation d'objets métiers d'avoir accès à f
        $GLOBALS['f'] = $this->f;
        // initialise le msg attribute qui est utilise pour stocker les
        // messages de retour (reussite ou erreur)
        $this->msg = '';
        //
        $ob_get_clean = ob_get_clean();
        // Logger
        $this->addToLog("__construct(): end", EXTRA_VERBOSE_MODE);
    }

    /*
     * Destructeur
     *
     * Unsets the instance of the utils class.
     * Unsets in the $_SESSION the key=>value pairs that were set in
     * the constructor.
     */
    public function __destruct() {
        // Logger
        $this->addToLog("__destruct(): start", EXTRA_VERBOSE_MODE);
        $this->f->logout();
        //
        unset($this->f);
        // Logger
        $this->addToLog("__destruct(): end", EXTRA_VERBOSE_MODE);
        // Mode DEBUG
        // logger::instance()->writeLogToFile();
    }

    /*
     * Fait l'insertion d'un redord dans la BD par l'appel de la methode
     * dbform::ajouter().
     * 
     * Precondition: $this->metier_instance n'est pas NULL.
     *
     * @uses dbform::ajouter() La methode qui fait l'insertion dans la BD.
     * @param mixed $data Tableau qui contient les donnees a ajouter dans la BD
     * @param string $msg_OK Le message a retourner en cas de success
     * @param string $msg_KO Le message a retourner en cas de echec
     * @return string En cas de success on retourne 'OK'. En cas d'erreur
     * on retourne le message d'erreur stocke dans l'atribut $msg, si l'atribut
     * $msg n'est pas vide, ou un message d'erreur generique si $msg est vide.
     */
    protected function ajouter(&$data, $msg_OK = null, $msg_KO = null) {

        // essai d'ajout des donnees dans la base de donnees
        $this->f->db->autoCommit(false);
        if ($this->metier_instance->ajouter($data)) {

            //
            $this->f->db->commit();

            //
            $this->setMessage($msg_OK);
            return $this->OK;
        } else {

            //
            $this->metier_instance->undoValidation();
            
            //
            if (isset($this->metier_instance->msg)
                && !empty($this->metier_instance->msg)) {
                $this->setMessage($this->filtreBalisesHtml(
                                    $this->metier_instance->msg));
                return $this->KO;
            }
            $this->setMessage($msg_KO);
            return $this->KO;
        }       
    }


    /*
     * Fait l'insertion d'un redord dans la BD par l'appel de la methode
     * dbform::modifier() method.
     * 
     * Precondition: $this->metier_instance n'est pas NULL.
     *
     * @uses dbform::modifier() La methode qui fait la modification des
     * donnees dans la BD.
     * @param mixed $data Tableau qui contient les donnees a modifier dans la BD
     * @param string $msg_OK Le message a retourner en cas de success
     * @param string $msg_KO Le message a retourner en cas de echec
     * @return string Retourne 'OK' en reussite, une message d'erreur en
     * cas d'echec si le message d'erreur etait stocke dans $this->msg, ou
     * un message d'erreur generique autrement.
     */    
    protected function modifier($data, $msg_OK = null, $msg_KO = null) {

        // essai d'ajout des donnees dans la base de donnees
        $this->f->db->autoCommit(false);
        if ($this->metier_instance->modifier($data)) {

            //
            $this->f->db->commit();

            //
            $this->setMessage($msg_OK);
            return $this->OK;
        } else {

            //
            $this->metier_instance->undoValidation();
            
            //
            if (isset($this->metier_instance->msg)
                && !empty($this->metier_instance->msg)) {
                $this->setMessage($this->filtreBalisesHtml(
                                    $this->metier_instance->msg));
                return $this->KO;
            }
            $this->setMessage($msg_KO);
            return $this->KO;
        }   
    }


    /*
     * Fait la suppression d'un redord dans la BD par l'appel de la methode
     * dbform::supprimer() method.
     * 
     * Precondition: $this->metier_instance n'est pas NULL.
     *
     * @uses dbform::supprimer() La methode qui fait la suppression des
     * donnees dans la BD.
     * @param mixed $data Tableau qui contient les donnees a modifier dans la BD
     * @param string $msg_OK Le message a retourner en cas de success
     * @param string $msg_KO Le message a retourner en cas de echec     * 
     * @return string Retourne 'OK' en reussite, une message d'erreur en
     * cas d'echec si le message d'erreur etait stocke dans $this->msg, ou
     * un message d'erreur generique autrement.
     */
    protected function supprimer(&$data, $msg_OK, $msg_KO) {

        // essai d'ajout des donnees dans la base de donnees
        $this->f->db->autoCommit(false);
        if ($this->metier_instance->supprimer($data)) {

            //
            $this->f->db->commit();

            //
            $this->setMessage($msg_OK);
            return $this->OK;
        } else {

            //
            $this->metier_instance->undoValidation();
            
            //
            if (isset($this->metier_instance->msg)
                && !empty($this->metier_instance->msg)) {
                $this->setMessage($this->filtreBalisesHtml(
                                    $this->metier_instance->msg));
                return $this->KO;
            }
            $this->setMessage($msg_KO);
            return $this->KO;
        } 
    }

    /*
     * Attribue une valeur au attribute $msg de la classe. Utilise dans le
     * retour d'une demande arrive par l'inteface REST
     * @param string $msg The chaine des caracteres a stocker dans
     * l'attribute msg.
     */
    protected function setMessage($msg) {
        if ($msg) {
            $this->msg = $msg;
        }
    }

    
    /*
     * Retourne le chaine des caracteres stocke dans l'attribut $msg
     * @return string La valeur de $this->msg.
     */
    public function getMessage() {
        return $this->msg;
    }

    /*
     * Ajoute une chaine des caracteres dans le log.
     * @param string $message Le message qui doit etre ajoute dans le log.
     * @param string $type Le mode de log.
     * @todo Qu'est ce que on va faire avec des messages d'erreur de la BD si
     * le traitement etait initie par une demande arrivee par REST ?
     */
    function addToLog($message, $type = DEBUG_MODE) {
        //
        logger::instance()->log("class ".get_class($this)." - ".$message, $type);
    }

    // {{{

    /**
     * Le principe de cette méthode est de récupérer la valeur de la clé
     * primaire de l'instance de l'objet métier.
     */
    protected function getMetierInstanceValForPrimaryKey() {

        // 
        return $this->getMetierInstanceValForField($this->metier_instance->clePrimaire);

    }

    /**
     * Le principe de cette méthode est de récupérer la valeur du field passé
     * en paramètre dans l'attribut 'val' de l'instance de l'objet métier.
     *
     * @param string $field Nom du champ  à récupérer
     */
    protected function getMetierInstanceValForField($field) {

        // Si l'objet métier n'a pas été instancié alors on retourne NULL
        if ($this->metier_instance == NULL) {
            return NULL;
        }
        // On récupère la clé de la valeur '$field' dans l'attribut 'champs' de
        // l'objet
        $key = array_search($field,
                            $this->metier_instance->champs);
        // Si la clé n'est pas présente dans le tableau alors on retourne NULL
        if (is_null($key) || $key === false) {
            return NULL;
        }
        // Si on ne retrouve pas la clé dans l'attribut 'val' de l'objet alors
        // on retour NULL
        if (!isset($this->metier_instance->val[$key])) {
            return NULL;
        }
        // Logger
        $this->addToLog("getMetierInstanceValForField(): \$field = \"".$field."\" ; return ".$this->metier_instance->val[$key].";", EXTRA_VERBOSE_MODE);
        // On retourne la valeur du champ représentant la clé primaire
        return $this->metier_instance->val[$key];

    }

    // }}}

    // {{{ METHODES UTILITAIRES

    /**
     * Cette méthode permet de supprimer les balises HTML d'une chaîne de
     * caractères
     * 
     * Filters out the HTML tags from a string.
     *
     * @param string $var The string from which to filter out the HTML tags.
     * @return string Returns $var without the HTML tags.
     */
    protected function filtreBalisesHtml($var) {
        $pattern = '/<[\/]*[\sa-zA-Z0-9="]*[\/]*>/';
        $replacement = '';
        return preg_replace($pattern, $replacement, $var);
    }

    /**
     * Cette méthode vérifier qu'une date se trouve dans un intervalle
     * 
     * Verifies that a date falls inside of a date interval
     * @param string $date_str The string that should fall
     * within the interval
     * @param string $date_start_str The begining of the interval
     * @param string $date_end_str The end of the interval
     * @return book true if $date_str is found inside of the
     * interval, false otherwise 
     */
    protected function dateInsideInterval($date_str, $date_start_str = null,
                               $date_end_str = null) {
        $dates_str = array($date_start_str, $date_str, $date_end_str);
        if (count($dates_str) == 1) {
            return true;
        }
        $dates = array();
        $prev_date = -1;
        for ($i = 0; $i < 3; $i++) {
            if ($dates_str[$i] == null) {
                $dates[] = null;
                continue;
            }
            $d = explode('/', $dates_str[$i]);
            $date = strtotime($d[2].'-'.$d[1].'-'.$d[0]);
            if ($i > 0 && $date < $prev_date) {
                return false;
            }
            $prev_date = $date;
        }
        return true;
    }

    /**
     * Cette méthode vérife la validité d'un timestamp
     * @param string $date_str Chaine des chracteres contenant le datestamp
     * dans la forme JJ/MM/YYYY H:MI"
     * @param string $date_db Parametre de sortie. Il contient la date dans le
     * format de BD timestamp: 'YYYY-MM-JJ hh:mm'
     * @param bool $time_search Indicated wheather hours and minutes should be
     * searched for in the $date_str or not
     * @return True if the timestamp is valid, false otherwise.
     */
    protected function timestampValide($date_str, &$date_db, $time_search = false) {
        $date_db = null;
        // check that the date is valid
        $date_time = explode(" ", $date_str);
        if (count($date_time) != 2 && $time_search) {
            return false; // bad date
        }
        // first verify that the date is correct
        $date = explode("/", $date_time[0]);
        if (count($date) != 3) {
            return false; // bad date
        }
        if (!checkdate($date[1], $date[0], $date[2])) {
            return false; // bad date
        }
        
        if ($time_search && count($date_time) != 2) {
            return false; // time not present even though searched for
        }
        // verify that the time is good
        if ($time_search) {
            $time_str = explode(':', $date_time[1]);
            if (count($time_str) <= 1) {
                return false; // time in bad format
            }
            // only interested in hours and minutes
            $hours = intval($time_str[0]);
            $minutes = intval($time_str[1]);
            if ($hours < 0 || $hours > 23) {
                return false; // bad hour
            }
            if ($minutes < 0 || $minutes > 59) {
                return false;
            }
        }
        $date_db = $date[2].'-'.$date[1].'-'.$date[0];
        if ($time_search) {
            $date_db .= ' '.$hours.':'.$minutes;
        }
        return true;
    }

    /**
     * Affecte une valeur à un paramètre de l'instance
     * 
     * @param  [string] $parameter Paramètre
     * @param  [mixed]  $value     Valeur à lui affecter
     * @return [void]
     */
    protected function setParameter($parameter, $value) {

        // On affecte la valeur au paramètre de l'instance
        $this->metier_instance->parameters[$parameter] = $value;
    }

    /**
     * Récupère la valeur d'un paramètre de l'instance
     * 
     * @param  [string] $parameter Paramètre
     * @return [mixed]             Sa valeur ou null si pas de paramètre
     */
    protected function getParameter($parameter) {

        // Si le paramètre existe
        if (isset($this->metier_instance->parameters[$parameter])) {
            // On retourne sa valeur
            return $this->metier_instance->parameters[$parameter];
        }
        // Sinon on retourne l'état null
        return null;
    }

    /**
     * Supprime un paramètre de l'instance
     * voire le tableau de paramètres s'il est vide
     * 
     * @param  [string] $parameter Paramètre
     * @return [void]
     */
    protected function unsetParameter($parameter) {

        // Suppression du paramètre
        unset($this->metier_instance->parameters[$parameter]);
        // Après avoir supprimé un paramètre il se peut qu'il n'y en ait plus
        // on supprime alors le tableau de paramètres pour éviter
        // d'éventuels effets de bord.
        if (isset($this->metier_instance->parameters)
            && empty($this->metier_instance->parameters)) {
            unset($this->metier_instance->parameters);
        }
    }

    // }}}


    /**
     *
     */
    function log($message) {
        //
        @file_put_contents(
            "../var/log/services.log",
            date("Y-m-d H:i:s")." - IN - ".str_replace("    ", " ", str_replace("\n", "", $message))."\n",
            FILE_APPEND
        );
    }

    
}

?>
