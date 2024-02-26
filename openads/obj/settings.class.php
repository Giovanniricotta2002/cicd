<?php
/**
 * Ce script permet de déclarer la classe settings.
 *
 * @package openaria
 * @version SVN : $Id$
 */

/**
 * Définition de la classe settings.
 *
 * Cette classe gère le module 'Settings'. Ce module permet de gérer les interfaces
 * d'administration et paramétrage et traitement.
 */
class settings {

    /**
     * Instance de la classe utils
     * @var resource
     */
    var $f = null;

    /**
     * Constructeur.
     */
    public function __construct() {
        //
        $this->init_om_utils();
    }

    /**
     *
     */
    function view_main() {
        //
        if (isset($_GET["controlpanel"]) 
            && $_GET["controlpanel"] == "interface_referentiel_erp") {
            //
            require_once "../obj/interface_referentiel_erp.class.php";
            $interface_referentiel_erp = new interface_referentiel_erp();
            $interface_referentiel_erp->view_controlpanel();
        } elseif (isset($_GET["view"]) 
            && $_GET["view"] == "log") {
            $this->view_log();
        }
    }

    function view_log() {
        if (!file_exists("../var/log/services.log")) {
            return;
        }
        echo "<pre>";
        $fp = fopen("../var/log/services.log", 'r');
        $pos = -2; // Skip final new line character (Set to -1 if not present)
        $lines = array();
        $currentLine = '';
        while (-1 !== fseek($fp, $pos, SEEK_END)) {
            $char = fgetc($fp);
            if (PHP_EOL == $char) {
                    echo $currentLine."\n";
                    $currentLine = '';
            } else {
                    $currentLine = $char . $currentLine;
            }
            $pos--;
        }
        var_dump($lines);
        // echo file_get_contents("../var/log/services.log");
        echo "</pre>";
    }

    // {{{ BEGIN - UTILS, LOGGER, ERROR

    /**
     * Initialisation de la classe utils.
     *
     * Cette méthode permet de vérifier que l'attribut f de la classe contient
     * bien la ressource utils du framework et si ce n'est pas le cas de la
     * récupérer.
     *
     * @return boolean
     */
    function init_om_utils() {
        //
        if (isset($this->f) && $this->f != null) {
            return true;
        }
        //
        if (isset($GLOBALS["f"])) {
            $this->f = $GLOBALS["f"];
            return true;
        }
        //
        return false;
    }

    /**
     * Ajout d'un message au système de logs.
     *
     * Cette méthode permet de logger un message.
     *
     * @param string  $message Message à logger.
     * @param integer $type    Niveau de log du message.
     *
     * @return void
     */
    function addToLog($message, $type = DEBUG_MODE) {
        //
        if (isset($this->f) && method_exists($this->f, "elapsedtime")) {
            logger::instance()->log(
                $this->f->elapsedtime()." : class ".get_class($this)." - ".$message,
                $type
            );
        } else {
            logger::instance()->log(
                "X.XXX : class ".get_class($this)." - ".$message,
                $type
            );
        }
    }

    // }}} END - UTILS, LOGGER, ERROR

}


