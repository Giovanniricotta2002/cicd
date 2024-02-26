<?php

/**
 * Connecteur GED de test, qui est toujours indisponible 'down'
 */

if (! defined('PATH_OPENMAIRIE')) {
    define('PATH_OPENMAIRIE', dirname(dirname(dirname(__DIR__))).'/core/');
}
require_once PATH_OPENMAIRIE.'om_filestorage.class.php';

class filestorage_down extends filestorage_base {

    public function is_service_available() {
        return false;
    }
}
