<?php
/**
 * Ce script contient la définition de la classe 'DigitalizedDocumentTest'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "testDigitalizedDocument_common.php";
final class DigitalizedDocumentTest extends DigitalizedDocumentCommon {
    public function setUp(): void {
        $this->common_setUp();
    }
    public function tearDown(): void {
        $this->common_tearDown();
    }
    public function onNotSuccessfulTest(Throwable $e): void {
        $this->common_onNotSuccessfulTest($e);
    }
    public static function setUpBeforeClass(): void {
        DigitalizedDocumentCommon::common_setUpBeforeClass();
    }
    public static function tearDownAfterClass(): void {
        DigitalizedDocumentCommon::common_tearDownAfterClass();
    }
}
