<?php
/**
 * Ce script contient la définition de la classe 'RESTPHP70Test'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "testREST_common.php";
final class RESTPHP70Test extends RESTCommon {
    public function setUp() {
        $this->common_setUp();
    }
    public function tearDown() {
        $this->common_tearDown();
    }
    public function onNotSuccessfulTest(Throwable $e) {
        $this->common_onNotSuccessfulTest($e);
    }
}
