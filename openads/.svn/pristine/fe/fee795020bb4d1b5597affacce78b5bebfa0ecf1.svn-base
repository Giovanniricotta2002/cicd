<?php

if (! defined('PATH_OPENMAIRIE')) {
    define('PATH_OPENMAIRIE', dirname(__DIR__).'/core/');
}
require_once PATH_OPENMAIRIE.'om_filestorage.class.php';
require_once PATH_OPENMAIRIE.'om_logger.class.php';

/**
 * Surcharge du "core" pour permettre l'ajout de la méthode "is_service_available".
 */
class om_filestorage extends filestorage {

    /**
     * Renvoi 'true' si le service tiers est en capacité de répondre aux appels sur son API.
     *
     * Par défaut, renvoie 'true', y compris si la méthode n'est pas surchargée dans le connecteur
     * "enfant".
     *
     * @return boolean
     */
    public function is_service_available() {
        logger::instance()->log(__METHOD__.'() BEGIN', EXTRA_VERBOSE_MODE);
        logger::instance()->log(__METHOD__.'() this->storage: '.var_export($this->storage, true), EXTRA_VERBOSE_MODE);
        if (! empty($this->storage)) {
            logger::instance()->log(__METHOD__.'() this->storage class: '.get_class($this->storage), EXTRA_VERBOSE_MODE);
            logger::instance()->log(__METHOD__.'() "is_service_available" exists: '.var_export(method_exists($this->storage, 'is_service_available'), true), EXTRA_VERBOSE_MODE);
            if (method_exists($this->storage, 'is_service_available')) {
                return $this->storage->is_service_available();
            }
        }
        logger::instance()->log(__METHOD__.'() END: "true" by default', EXTRA_VERBOSE_MODE);
        return true;
    }
}
