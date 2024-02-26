<?php
/**
 * Contient la définition des classes 'electronicsignature' et 'electronicsignature_base'.
 */

if (defined('PATH_OPENMAIRIE') !== true) {
    define('PATH_OPENMAIRIE', '../core/');
}
require_once PATH_OPENMAIRIE."om_logger.class.php";

/**
 * Abstracteur du parapheur
 */
class electronicsignature {

    /**
     * Configuration du connecteur parapheur.
     * @var array
     */
    var $conf = null;

    /**
     * Instance du connecteur parapheur.
     * @var object
     */
    var $electronicsignature = null;

    /**
     * Liste des clés obligatoire pour les parapheurs.
     * @var array
     */
    const DATA_KEYS = array(
        "om_utilisateur_email",
        "om_utilisateur_nom",
        "signataire_arrete_email",
        "signataire_arrete_nom",
        "signataire_arrete_prenom",
        "dossier"
    );

    /**
     * Liste des clés obligatoire pour les métadonnées des documents d'instruction.
     * @var array
     */
    const DOSSIER_METADATA = array(
        "mimetype",
        "filename",
        "url_di",
        "titre_document"
    );

    /**
     * Liste des clés obligatoire pour l'annulation l'envoi en signature des documents d'instruction.
     * @var array
     */
    const CANCEL_DATA_KEYS = array(
        "id_parapheur_signature"
    );


    /**
     * Instancie le connecteur parapheur depuis la collectivité transmise et la
     * configuration.
     *
     * Liste des paramètres :
     * - *conf_name* nom de la configuration à récupérer, par défaut 'electronicsignature-default'
     * - *collectivite_idx* identifiant de la collectivité
     * - collectivite_multi_idx identifiant de la collectivité de niveau 2
     *
     * @param array $params Liste des paramètres.
     */
    public function __construct(array $params) {
        //
        if (file_exists("../dyn/electronicsignature.inc.php") === false) {
            throw new electronicsignature_configuration_exception(__("Aucun fichier de configuration pour la signature électronique."));
        }
        include("../dyn/electronicsignature.inc.php");
        if (isset($conf) === false) {
            throw new electronicsignature_configuration_exception(__("Aucune configuration pour la signature électronique."));
        }
        $this->conf = $conf;
        //
        if (isset($params['conf_name']) === true) {
            $this->conf = $this->conf[$params['conf_name']];
        } else {
            $this->conf = $this->conf['electronicsignature-default'];
        }
        //
        if (isset($params['collectivite_idx']) === true
            && $this->get_conf('unexpected_collectivite') !== null
            && in_array($params['collectivite_idx'], $this->get_conf('unexpected_collectivite')) === true) {
            //
            throw new electronicsignature_configuration_exception(__("Aucun parapheur configuré pour la collectivité."));
        }
        //
        if (isset($params['collectivite_idx']) === true
            && $this->get_conf($params['collectivite_idx']) !== null) {
            //
            $this->conf = $this->conf[$params['collectivite_idx']];
        }
        elseif (isset($params['collectivite_multi_idx']) === true
            && $this->get_conf($params['collectivite_multi_idx']) !== null) {
            //
            $this->conf = $this->conf[$params['collectivite_multi_idx']];
        } else {
            throw new electronicsignature_configuration_exception(__("Aucun parapheur configuré pour la collectivité."));
        }

        //
        if ($this->get_conf('path') === null) {
            throw new electronicsignature_configuration_exception(__("Le chemin vers le connecteur du parapheur n'est pas configuré."));
        }
        //
        if ($this->get_conf('connector') === null) {
            throw new electronicsignature_configuration_exception(__("Le nom du connecteur du parapheur n'est pas configuré."));
        }
        //
        $connector = sprintf(
            '%s_%s',
            get_class($this),
            $this->get_conf('connector')
        );
        require_once $this->conf['path'].$connector.'.class.php';
        $this->electronicsignature = new $connector($this->get_conf());
    }

    /**
     * Détruit la ressource instanciée dans le constructeur.
     */
    public function __destruct() {
        //
        if (is_null($this->electronicsignature) === false) {
            unset($this->electronicsignature);
        }
    }

    /**
     * Accesseur pour récupérer la configuration complète du connecteur parapheur
     * ou une partie de celle-ci.
     *
     * @param  string $params Attribut de la configuration.
     * @return mixed          Le tableau de configuration complet ou la valeur
     * d'une entrée du tableau de configuration.
     */
    public function get_conf($params = null) {
        if ($params === null) {
            return $this->conf;
        }
        if (is_string($params) === true
            && is_array($this->conf) === true) {
            //
            if (array_key_exists($params, $this->conf) === true) {
                return $this->conf[$params];
            }
        }
        if (is_array($params) === true
            && is_array($this->conf) === true
            && count($params) === 2
            && array_key_exists($params[0], $this->conf) === true
            && is_array($this->conf[$params[0]]) === true
            && array_key_exists($params[1], $this->conf[$params[0]]) === true) {
            //
            return $this->conf[$params[0]][$params[1]];
        }
        return null;
    }

    /**
     * Appelle la méthode de même nom du connecteur parapheur.
     * Permet de transmettre un document à signer.
     *
     * @param  array  $data             Liste des paramètres (dépend du connecteur).
     * @param  string $file_content     Contenu du document à signer.
     * @param  array  $dossier_metadata Métadonnées du dossier d'instruction.
     * @param  array  $optional_data    Paramètres spécifique au connecteur.
     * @return array                    Tableau de résultat retourné par le
     * connecteur parapheur, sinon retourne une exception.
     */
    public function send_for_signature(array $data, string $file_content, array $dossier_metadata, array $optional_data = null) {
        //
        if (is_array($data) === false
            || empty($data) === true) {
            //
            throw new electronicsignature_parameter_exception();
        }

        $missed_data_keys = array();
        foreach (self::DATA_KEYS as $data_key) {
            // Construire une liste des clés manquantes
            if (! isset($data[$data_key])) {
                $missed_data_keys[] = $data_key;
            }
        }
        if (! empty($missed_data_keys)) {
            throw new electronicsignature_connector_exception(
                __("Certains paramètres nécessaires à l'envoi en signature sont manquantes : ").implode(', ', $missed_data_keys)
            );
        }

        $missed_metadata_keys = array();
        foreach (self::DOSSIER_METADATA as $data_key) {
            // Construire une liste des clés manquantes
            if (! isset($data[$data_key])) {
                $missed_metadata_keys[] = $data_key;
            }
        }
        if (! empty($missed_data_keys)) {
            throw new electronicsignature_connector_exception(
                __("Certaines métadonnées nécessaires à l'envoi en signature sont manquantes : ").implode(', ', $missed_data_keys)
            );
        }

        if (empty($file_content) === true) {
            //
            throw new electronicsignature_parameter_exception(__("Contenu du fichier absent."));
        }

        //
        $es = $this->electronicsignature;
        if (is_null($es) === true) {
            return false;
        }
        //
        return $es->send_for_signature($data, $file_content, $dossier_metadata, $optional_data);
    }

    /**
     * Appelle la méthode de même nom du connecteur parapheur.
     * Permet d'annuler la transmission du document à signer.
     *
     * @param  array  $data             Liste des paramètres (dépend du connecteur).
     * @return array                    Tableau de résultat retourné par le
     * connecteur parapheur, sinon retourne une exception.
     */
    public function cancel_send_for_signature(array $data) {
        //
        //
        if (is_array($data) === false
            || empty($data) === true) {
            //
            throw new electronicsignature_parameter_exception();
        }

        $missed_data_keys = array();
        foreach (self::CANCEL_DATA_KEYS as $data_key) {
            // Construire une liste des clés manquantes
            if (! isset($data[$data_key])) {
                $missed_data_keys[] = $data_key;
            }
        }
        if (! empty($missed_data_keys)) {
            throw new electronicsignature_connector_exception(
                __("Certains paramètres nécessaires à l'annulation de l'envoi en signature sont manquants : ").implode(', ', $missed_data_keys)
            );
        }

        //
        $es = $this->electronicsignature;
        if (is_null($es) === true) {
            return false;
        }
        //
        return $es->cancel_send_for_signature($data);
    }


    /**
     * Appelle la méthode de même nom du connecteur parapheur.
     * Permet de récupérer le statut d'un parapheur.
     *
     * @param  array  $data Liste des paramètres (dépend du connecteur).
     * @return array        Tableau de résultat retourné par le
     * connecteur parapheur, sinon retourne une exception.
     */
    public function get_signature_status(array $data) {
        //
        if (is_array($data) === false
            || empty($data) === true) {
            //
            throw new electronicsignature_parameter_exception();
        }

        //
        $es = $this->electronicsignature;
        if (is_null($es) === true) {
            return false;
        }
        //
        return $es->get_signature_status($data);
    }

    /**
     * Appelle la méthode de même nom du connecteur parapheur.
     * Permet de récupérer le document signé.
     *
     * @param  array  $data Liste des paramètres (dépend du connecteur).
     * @return array        Tableau de résultat retourné par le
     * connecteur parapheur, sinon retourne une exception.
     */
    public function get_signed_document(array $data) {
        //
        if (is_array($data) === false
            || empty($data) === true) {
            //
            throw new electronicsignature_parameter_exception();
        }

        //
        $es = $this->electronicsignature;
        if (is_null($es) === true) {
            return false;
        }
        //
        return $es->get_signed_document($data);
    }

    /**
     * Appelle la méthode de même nom du connecteur parapheur.
     *
     * Permet de spécifier le support de la notification mail au signataire.
     *
     * @param  array  $data  Liste des paramètres (dépend du connecteur).
     *
     * @return bool  'true' si le connecteur délègue à openADS les notifications mail
     *
     * @throw electronicsignature_connector_method_not_implemented_exception
     */
    public function signer_notification_is_delegated(array $data = []) {
        return $this->electronicsignature->signer_notification_is_delegated($data);
    }
}

/**
 * Classe parente de tous les connecteurs parapheur
 */
class electronicsignature_base {

    /**
     * Configuration du connecteur parapheur.
     * @var array
     */
    var $conf = null;

    /**
     * Instancie le connecteur parapheur selon la configuration.
     *
     * @param array $conf Configuration du connecteur.
     */
    public function __construct(array $conf) {
        $this->conf = $conf;
    }

    /**
     * Accesseur pour récupérer la configuration complète du connecteur parapheur
     * ou une partie de celle-ci.
     *
     * @param  string $params Attribut de la configuration.
     * @return mixed          Le tableau de configuration complet ou la valeur
     * d'une entrée du tableau de configuration.
     */
    protected function get_conf($params = null) {
        if ($params === null) {
            return $this->conf;
        }
        if (is_string($params) === true
            && is_array($this->conf) === true) {
            //
            if (array_key_exists($params, $this->conf) === true) {
                return $this->conf[$params];
            }
        }
        if (is_array($params) === true
            && is_array($this->conf) === true
            && count($params) === 2
            && array_key_exists($params[0], $this->conf) === true
            && is_array($this->conf[$params[0]]) === true
            && array_key_exists($params[1], $this->conf[$params[0]]) === true) {
            //
            return $this->conf[$params[0]][$params[1]];
        }
        return null;
    }

    /**
     * Doit être implémentée par des classe dérivées.
     * Permet de transmettre un document à signer.
     *
     * @param  array  $data             Liste des paramètres (dépend du connecteur).
     * @param  string $file_content     Contenu du document à signer.
     * @param  array  $dossier_metadata Métadonnées du dossier d'instruction.
     * @param  array  $optional_data    Paramètres spécifique au connecteur.
     * @return array                    Tableau de résultat retourné par le
     * connecteur parapheur, sinon retourne une exception.
     */
    protected function send_for_signature(array $data, string $file_content, array $dossier_metadata, array $optional_data = null) {
        //
        throw new electronicsignature_connector_method_not_implemented_exception();
    }

    /**
     * Doit être implémentée par des classe dérivées.
     * Permet d'annuler la transmission du document à signer.
     *
     * @param  array  $data             Liste des paramètres (dépend du connecteur).
     * @return array                    Tableau de résultat retourné par le
     * connecteur parapheur, sinon retourne une exception.
     */
    protected function cancel_send_for_signature(array $data) {
        //
        throw new electronicsignature_connector_method_not_implemented_exception();
    }


    /**
     * Doit être implémentée par des classe dérivées.
     * Permet de récupérer le statut d'un parapheur.
     *
     * @param  array  $data Liste des paramètres (dépend du connecteur).
     * @return array        Tableau de résultat retourné par le
     * connecteur parapheur, sinon retourne une exception.
     */
    protected function get_signature_status(array $data) {
        //
        throw new electronicsignature_connector_method_not_implemented_exception();
    }

    /**
     * Doit être implémentée par des classe dérivées.
     * Permet de récupérer le document signé.
     *
     * @param  array  $data Liste des paramètres (dépend du connecteur).
     * @return array        Tableau de résultat retourné par le
     * connecteur parapheur, sinon retourne une exception.
     */
    protected function get_signed_document(array $data) {
        //
        throw new electronicsignature_connector_method_not_implemented_exception();
    }

    /**
     * Doit être implémentée par les classe dérivées.
     * Permet de spécifier le support de la notification mail au signataire.
     *
     * @param  array  $data  Liste des paramètres (dépend du connecteur).
     *
     * @return bool  'true' si le connecteur délègue à openADS les notifications mail
     *
     * @throw electronicsignature_connector_method_not_implemented_exception
     */
    public function signer_notification_is_delegated(array $data = []) {
        //
        throw new electronicsignature_connector_method_not_implemented_exception();
    }
}

/**
 * Classe gérant les erreurs
 */
class electronicsignature_exception extends Exception {

    public function __construct($message = "", $code = 0, Exception $previous = null) {
        parent::__construct($message, $code, $previous);
        logger::instance()->writeErrorLogToFile();
        logger::instance()->cleanLog();
    }

    protected function add_to_log($code, $message) {
        logger::instance()->log(sprintf(
            "Electronic Signature Connector - Error code : %s -> %s",
            $code,
            $message
        ));
    }
}

class electronicsignature_configuration_exception extends electronicsignature_exception {

    public function __construct($message = null) {
        $ret = trim(sprintf(
            '%s %s %s',
            __('Erreur de configuration du parapheur.'),
            __('Veuillez contacter votre administrateur.'),
            $message
        ));
        parent::__construct($ret);
    }
}

class electronicsignature_parameter_exception extends electronicsignature_exception {

    public function __construct($message = null) {
        $ret = trim(sprintf(
            '%s %s %s',
            __("Les paramètres d'appel au parapheur ne sont pas valides."),
            __('Veuillez contacter votre administrateur.'),
            $message
        ));
        parent::__construct($ret);
    }
}

class electronicsignature_connector_exception extends electronicsignature_exception {

    public function __construct($message = null, $code = null) {
        // Log de l'erreur technique
        $this->add_to_log($code, $message);
        // Log utilisateur
        $ret = trim(sprintf(
            '%s %s %s',
            __('Erreur du parapheur.'),
            __('Veuillez contacter votre administrateur.'),
            $message
        ));
        parent::__construct($ret);
    }
}

class electronicsignature_connector_method_not_implemented_exception extends electronicsignature_exception {

    public function __construct($message = null) {
        $ret = trim(sprintf(
            '%s %s %s',
            __("La méthode n'est pas implémentée dans le connecteur."),
            __('Veuillez contacter votre administrateur.'),
            $message
        ));
        parent::__construct($ret);
    }
}
