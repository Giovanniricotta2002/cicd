<?php
/**
 * Ce script contient la définition de la classe 'RESTTest'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "testREST_common.php";
final class RESTTest extends RESTCommon {
    public function setUp(): void {
        $this->common_setUp();
    }
    public function tearDown(): void {
        $this->common_tearDown();
    }
    public function onNotSuccessfulTest(Throwable $e): void {
        $this->common_onNotSuccessfulTest($e);
    }
}
