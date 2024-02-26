<?php
/**
 * Ce script contient la définition de la classe 'GeneralTest'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "testGeneral_common.php";
final class GeneralTest extends GeneralCommon {
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
