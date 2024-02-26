<?php
/**
 * Ce script permet de définir une configuration SMTP pour les tests.
 *
 * Le SMTP utilisé est maildump : https://pypi.python.org/pypi/maildump.
 *
 * @package openmairie_exemple
 * @version SVN : $Id: mail.inc.php 6901 2017-06-14 10:01:46Z nmeucci $
 */

$mail = array();
$mail["mail-test"] = array(
    'mail_host' => 'localhost',
    'mail_port' => '1025',
    'mail_username' => '',
    'mail_pass' => '',
    'mail_from' => 'contact@openads.org',
    'mail_from_name' => 'Administrateur openADS',
);

?>
