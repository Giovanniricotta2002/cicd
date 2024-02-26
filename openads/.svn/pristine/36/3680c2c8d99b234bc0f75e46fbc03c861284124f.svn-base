<?php
/**
 * Ce script contient la définition de la classe 'OMTestCase'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/utils.class.php";

abstract class OMTestCase extends PHPUnit\Framework\TestCase {
    /**
     *
     */
    public function common_setUp() {
        date_default_timezone_set('Europe/Paris');
        echo ' = '.get_called_class().'.'.str_replace('test_', '', $this->getName())."\r\n";
    }

    /**
     *
     */
    public function common_tearDown() {
    }

    /**
     * Méthode étant appelée lors du fail d'un test.
     *
     * @param $e Exception remontée lors du test
     * @return void
     */
    public function common_onNotSuccessfulTest(Throwable $e) {
        echo 'Line '.$e->getLine().' : '.$e->getMessage()."\r\n";
        parent::onNotSuccessfulTest($e);
    }

    /**
     *
     */
    protected function get_inst_om_application($login = null, $password = null) {
        if ($login === null && $password === null) {
            @$f = new utils("anonym");
            $GLOBALS['f'] = $f;
            return $f;
        }
        $_POST["login"] = $login;
        $_POST["password"] = $password;
        $_POST["login_action_connect"] = true;
        @$f = new utils("login_and_nohtml");
        $GLOBALS['f'] = $f;
        return $f;
    }

    /**
     *
     */
    protected function clean_session() {
        if (isset($_SESSION)) {
            unset($_SESSION);
        }
    }
}
