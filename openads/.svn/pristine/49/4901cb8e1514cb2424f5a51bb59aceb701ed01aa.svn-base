<?php
/**
 * Ce fichier est destine a permettre la surcharge de certaines methodes de
 * la classe om_application pour des besoins specifiques de l'application
 *
 * @package openmairie_exemple
 * @version SVN : $Id: utils.class.php 6132 2016-03-09 09:18:18Z stimezouaght $
 */

/**
 *
 */
if (file_exists("../dyn/locales.inc.php") === true) {
    require_once "../dyn/locales.inc.php";
}

/**
 *
 */
if (file_exists("../dyn/include.inc.php") === true) {
    require_once "../dyn/include.inc.php";
} else {
    /**
     * Définition de la constante représentant le chemin d'accès au framework
     */
    define("PATH_OPENMAIRIE", getcwd()."/../core/");
    
    /**
     * TCPDF specific config
     */
    define('K_TCPDF_EXTERNAL_CONFIG', true);
    define('K_TCPDF_CALLS_IN_HTML', true);
    define('K_PATH_FONTS', '../app/fonts/');

    /**
     * Dépendances PHP du framework
     * On modifie la valeur de la directive de configuration include_path en
     * fonction pour y ajouter les chemins vers les librairies dont le framework
     * dépend.
     */
    set_include_path(
        get_include_path().PATH_SEPARATOR.implode(
            PATH_SEPARATOR,
            array(
                getcwd()."/../php/pear",
                getcwd()."/../php/db",
                getcwd()."/../php/fpdf",
                getcwd()."/../php/phpmailer",
                getcwd()."/../php/tcpdf",
            )
        )
    );

    /**
     * Retourne l'URL de la racine d'openADS.
     * Exemple : http://localhost/openads/
     */
    if (!function_exists("get_base_url")) {
        function get_base_url() {
            // Récupération du protocole
            $protocol = 'http';
            if (isset($_SERVER['HTTPS'])) {
                $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
            }
            // Récupération du domaine
            $domain = $_SERVER['HTTP_HOST'];
            // Récupération du port
            $port = $_SERVER['SERVER_PORT'];
            $disp_port = ($protocol == 'http' && $port == 80 || $protocol == 'https' && $port == 443) ? '' : ":$port";
            // Construction du chemin restant
            $base_url = str_replace('app', '', rtrim(dirname($_SERVER['PHP_SELF']), '/\\'));
            //
            return $protocol."://".$domain.$disp_port.$base_url;
        }
    }
    define("PATH_BASE_URL", get_base_url());
}

/**
 *
 */
if (file_exists("../dyn/debug.inc.php") === true) {
    require_once "../dyn/debug.inc.php";
}

/**
 *
 */
(defined("PATH_OPENMAIRIE") ? "" : define("PATH_OPENMAIRIE", ""));

/**
 * Constante donnant le code de la catégorie de document numérisé liée à Plat'AU
 */
(defined("CODE_CATEGORIE_DOC_NUM_PLATAU") ? "" : define('CODE_CATEGORIE_DOC_NUM_PLATAU', 'PLATAU'));

/**
 * Constantes donnant le nom de la catégorie des tâches liées à Plat'AU et ua portail citoyen
 */
(defined("PLATAU") ? "" : define('PLATAU', 'platau'));
(defined("PORTAL") ? "" : define('PORTAL', 'portal'));
/**
 *
 */
require_once PATH_OPENMAIRIE."om_application.class.php";

/**
 *
 */
class utils extends application {

    /**
     * Gestion du nom de l'application.
     *
     * @var mixed Configuration niveau application.
     */
    protected $_application_name = "openADS";

    /**
     * Titre HTML.
     *
     * @var mixed Configuration niveau application.
     */
    protected $html_head_title = ":: openMairie :: openADS";

    /**
     * Gestion du nom de la session.
     *
     * @var mixed Configuration niveau application.
     */
    protected $_session_name = "openads";

    /**
     * Gestion du favicon de l'application.
     *
     * @var mixed Configuration niveau application.
     */
    var $html_head_favicon = '../app/img/favicon.ico';

    /**
     * Gestion du mode de gestion des permissions.
     *
     * @var mixed Configuration niveau application.
     */
    protected $config__permission_by_hierarchical_profile = false;

    /**
     * Stockage des paramètres des collectivités.
     *
     * @var array
     */
    protected $collectivitiesParameters = array();

    // {{{

    /**
     * SURCHARGE DE LA CLASSE OM_APPLICATION.
     *
     * @see Documentation sur la méthode parent 'om_application:getCollectivite'.
     */
    function getCollectivite($om_collectivite_idx = null) {
        // On vérifie si une valeur a été passée en paramètre ou non.
        if ($om_collectivite_idx === null) {
            // Cas d'utilisation n°1 : nous sommes dans le cas où on 
            // veut récupérer les informations de la collectivité de
            // l'utilisateur et on stocke l'info dans un flag.
            $is_get_collectivite_from_user = true;
            // On initialise l'identifiant de la collectivité
            // à partir de la variable de session de l'utilisateur.
            $om_collectivite_idx = $_SESSION['collectivite'];
        } else {
            // Cas d'utilisation n°2 : nous sommes dans le cas où on
            // veut récupérer les informations de la collectivité 
            // passée en paramètre et on stocke l'info dans le flag.
            $is_get_collectivite_from_user = false;
        }


        if (array_key_exists($om_collectivite_idx, $this->collectivitiesParameters) === false
            || empty($this->collectivitiesParameters[$om_collectivite_idx]) === true) {
            $collectivite_parameters = parent::getCollectivite($om_collectivite_idx);

            //// BEGIN - SURCHARGE OPENADS

            // Ajout du paramétrage du sig pour la collectivité
            if (file_exists("../dyn/var.inc")) {
                include "../dyn/var.inc";
            }
            if (file_exists("../dyn/sig.inc.php")) {
                include "../dyn/sig.inc.php";
            }
            if (!isset($sig_externe)) {
                $sig_externe = "sig-default";
            }
            $idx_multi = $this->get_idx_collectivite_multi();
    
            if (isset($collectivite_parameters['om_collectivite_idx'])
                && isset($conf[$sig_externe][$collectivite_parameters['om_collectivite_idx']])
                && isset($conf[$sig_externe]["sig_treatment_mod"])
                && isset($collectivite_parameters["option_sig"])
                && $collectivite_parameters["option_sig"] == "sig_externe") {
                // Cas numéro 1 : conf sig définie sur la collectivité et option sig active
                $collectivite_parameters["sig"] = $conf[$sig_externe][$collectivite_parameters['om_collectivite_idx']];
                $collectivite_parameters["sig"]["sig_treatment_mod"] = $conf[$sig_externe]["sig_treatment_mod"];
            } elseif ($idx_multi != ''
                && isset($conf[$sig_externe][$idx_multi])
                && isset($conf[$sig_externe]["sig_treatment_mod"])
                && isset($collectivite_parameters["option_sig"])
                && $collectivite_parameters["option_sig"] == "sig_externe") {
                // Cas numéro : conf sig définie sur la collectivité multi et option_sig activé pour la collectivité mono
                $collectivite_parameters["sig"] = $conf[$sig_externe][$idx_multi];
                $collectivite_parameters["sig"]["sig_treatment_mod"] = $conf[$sig_externe]["sig_treatment_mod"];
            }

            //// END - SURCHARGE OPENADS

            // Si on se trouve dans le cas d'utilisation n°1
            if ($is_get_collectivite_from_user === true) {
                // Alors on stocke dans l'attribut collectivite le tableau de
                // paramètres pour utilisation depuis la méthode 'getParameter'.
                $this->collectivite = $collectivite_parameters;
            }
            // On stocke le tableau de paramètres.
            $this->collectivitiesParameters[$om_collectivite_idx] = $collectivite_parameters;
        }
        // Renvoie la liste des paramètres de la collectivité voulue
        return $this->collectivitiesParameters[$om_collectivite_idx];
    }

    /**
     * Affiche un bloc d'information.
     *
     * @param string $class Classe CSS.
     * @param string $message Message à afficher.
     *
     * @return void
     */
    function display_panel_information($class = "", $message = "", $tableau=null, $legend=null, $id_suffixe='') {
        if (!defined('REST_REQUEST')) {
            if ($tableau !== null) {
                $message .= '<fieldset id="fieldset-message-tab_'.$id_suffixe.'" class="cadre ui-corner-all ui-widget-content startClosed collapsed">';
                $message .= '<legend class="ui-corner-all ui-widget-content ui-state-active">'.$legend.'</legend>';
                $message .= '<div id="fieldset-message-tab-content" class="fieldsetContent" style="display: none;">';
                $message .= '<ul>';
                foreach ($tableau as $value) {
                    $message .= "<li>".$value."</li>";
                }
                $message .= '</ul>';
                $message .= '</div>';
                $message .= '</fieldset>';
            }
            //
            if ($class == "ok") {
                $class = "valid";
            }
            //
            echo "\n<div class=\"panel_information ui-widget ui-corner-all ui-state-highlight ui-state-".$class."\">\n";
            echo "<p>\n";
            echo "\t<span class=\"ui-icon ui-icon-info\"><!-- --></span> \n\t";
            echo "<span class=\"text\">";
            echo $message;
            echo "</span>";
            echo "\n</p>\n";
            echo "</div>\n";
        }
    }

    /**
     * Récupère toutes les collectivités ayant le niveau passé en
     * paramètre. Si le niveau n'est pas donné ou que ce n'est pas
     * un nombre renvoi une chaine vide.
     *
     * @param integer niveau de la collectivite
     * @return string
     */
    protected function get_collectivite_par_niveau($niveau) {
        if (empty($niveau) || ! is_numeric($niveau)) {
            return '';
        }
        $qres = $this->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    om_collectivite
                FROM
                    %1$som_collectivite
                WHERE
                    niveau = \'%2$d\'',
                DB_PREFIXE,
                intval($niveau)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres['result'];
    }

    /**
     * Retourne l'identifiant de la collectivité multi ou l'identifiant de la
     * seule collectivité dans le cas d'une installation mono.
     *
     * @return integer Identifiant de la collectivité multi.
     */
    public function get_idx_collectivite_multi() {
        // Récupère l'identifiant de la collectivité de niveau 2
        $idx = $this->get_collectivite_par_niveau(2);
        // S'il n'y a pas de collectivité de niveau 2
        if ($idx == null || $idx == '') {
            // Compte le nombre de collectivité
            $qres = $this->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        count(om_collectivite)
                    FROM
                        %1$som_collectivite',
                    DB_PREFIXE
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $count = $qres["result"];
            // S'il y qu'une collectivité
            if ($count == 1) {
                // Récupère l'identifiant de la seule collectivité
                $idx = $this->get_collectivite_par_niveau(1);
            }
        }
        // Retourne l'identifiant
        return $idx;
    }


    /**
     * Retourne  l'identifiant de la collectivité de l'element de la table passée
     * en paramètre.
     *
     * @param string $table Table de l'element.
     * @param mixed  $id    Identifiant de l'element.
     *
     * @return string identifiant de la collectivite ou false si l'element n'existe pas.
     */
    public function get_collectivite_of_element($table, $id) {
        $instance = $this->get_inst__om_dbform(array(
            "obj" => $table,
            "idx" => $id,
        ));
        if($instance->getVal($instance->clePrimaire) != '') {
            return $instance->getVal('om_collectivite');
        }
        return false;
    }


    /**
     * Retourne vrai si la collectivité passée en paramètre ou la collectivité
     * de l'utilisateur connecté est mono.
     *
     * @param string $id Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function isCollectiviteMono($id = null) {
        // Si on ne passe pas de collectivité en argument
        if ($id == null) {
            // On vérifie la collectivité stockée en session de l'utilisateur
            // connecté
            $res = false;
            if ($_SESSION['niveau'] === '1') {
                //
                $res = true;
            }
            //
            return $res;
        }

        $inst_om_collectivite = $this->get_inst__om_dbform(array(
            "obj" => "om_collectivite",
            "idx" => $id,
        ));
        if ($inst_om_collectivite->getVal("niveau") === '1') {
            //
            return true;
        }
        //
        return false;
    }

    // }}}

    // {{{

    var $om_utilisateur = array();
    var $user_is_instr = NULL;
    var $user_is_service = NULL;
    public $user_is_tiers = NULL;
    var $user_is_admin = NULL;
    var $user_is_service_ext = NULL;
    public $user_is_tiers_ext = NULL;
    var $user_is_qualificateur = NULL;
    var $user_is_chef = NULL;
    var $user_is_divisionnaire = NULL;
    var $user_is_service_int = NULL;
    public $user_is_tiers_int = NULL;

    /**
     * Méthode de récupération des informations de l'utilisateur connecté.
     */
    function getUserInfos() {
        
        // Si l'utilisateur est loggé $_SESSION existe
        if(isset($_SESSION['login']) AND !empty($_SESSION['login'])) {

            // Récupération des infos utilisateur
            $qres = $this->get_all_results_from_db_query(
                sprintf('
                    SELECT 
                        om_utilisateur, 
                        nom, 
                        email, 
                        login, 
                        om_collectivite, 
                        om_profil
                    FROM 
                        %1$som_utilisateur 
                    WHERE 
                        login = \'%2$s\' ',
                    DB_PREFIXE,
                    $_SESSION['login']
                ),
                array(
                    "origin" => __METHOD__,
                )
            );

            // On ne récupère que la 1ere ligne
            $this->om_utilisateur = array_shift($qres['result']);

            // Récupère le profil et test si c'est un 
            $inst_om_profil = $this->get_inst__om_dbform(array(
                "obj" => "om_profil",
                "idx" => $this->om_utilisateur['om_profil'],
            ));
            $resProfil = $inst_om_profil->getVal("libelle");
            // Sauvegarde le libelle du profil
            $this->om_utilisateur["libelle_profil"] = $resProfil;

            // si c'est un administrateur technique
            // XXX Mauvaise méthode, il faut utiliser isAccredited
            if ($resProfil == "ADMINISTRATEUR TECHNIQUE"
                || $resProfil == "ADMINISTRATEUR FONCTIONNEL") {
                $this->user_is_admin = true;
            } else {
                $this->user_is_admin = false;
            }

            //si c'est un service externe
            if ($resProfil == "SERVICE CONSULTÉ") {
                $this->user_is_service_ext = true;
            } else {
                $this->user_is_service_ext = false;
            }

            //si c'est un service interne
            if ($resProfil == "SERVICE CONSULTÉ INTERNE") {
                $this->user_is_service_int = true;
            } else {
                $this->user_is_service_int = false;
            }

            // TODO : a vérifié parce que je me contente de copier le traitement pour les services
            // je ne sais pas si ce sera utile ou pas
            //si c'est un tiers externe
            if ($resProfil == "TIERS CONSULTÉ") {
                $this->user_is_tiers_ext = true;
            } else {
                $this->user_is_tiers_ext = false;
            }

            //si c'est un tiers interne
            if ($resProfil == "TIERS CONSULTÉ INTERNE") {
                $this->user_is_tiers_int = true;
            } else {
                $this->user_is_tiers_int = false;
            }

            // si c'est un qualificateur
            if ($resProfil == "QUALIFICATEUR") {
                $this->user_is_qualificateur = true;
            } else {
                $this->user_is_qualificateur = false;
            }

            // si c'est un chef de service
            if ($resProfil == "CHEF DE SERVICE") {
                $this->user_is_chef = true;
            } else {
                $this->user_is_chef = false;
            }

            // si c'est un divisionnaire
            if ($resProfil == "DIVISIONNAIRE") {
                $this->user_is_divisionnaire = true;
            } else {
                $this->user_is_divisionnaire = false;
            }
            
            // Récupération des infos instructeur
            $qres = $this->get_all_results_from_db_query(
                sprintf('
                    SELECT 
                        instructeur.instructeur, 
                        instructeur.nom, 
                        instructeur.telephone,
                        division.division, 
                        division.code, 
                        division.libelle 
                    FROM 
                        %1$sinstructeur 
                        INNER JOIN %1$sdivision 
                            ON division.division=instructeur.division 
                    WHERE 
                        instructeur.om_utilisateur = %2$d ',
                    DB_PREFIXE,
                    intval($this->om_utilisateur['om_utilisateur'])
                ),
                array(
                    "origin" => __METHOD__,
                )
            );

            // Si pas de résultat, initialisé à NULL
            // Comme le comportement de la requête qui va être remplacé
            // On ne récupère que la 1ere ligne
            $tempInstr= (!empty($qres['result'])) ? array_shift($qres['result']) : NULL;

            // Si il y a un resultat c'est un instructeur
            if (is_array($tempInstr) === true && count($tempInstr) > 0) {
                $this->user_is_instr=true;
                $this->om_utilisateur = array_merge($this->om_utilisateur,$tempInstr);
            } else {
                $this->user_is_instr=false;
            }

            // Récupération des infos de services consultés
            $qres = $this->get_all_results_from_db_query(
                sprintf('
                    SELECT
                        service.service,
                        service.abrege,
                        service.libelle
                    FROM
                        %1$sservice
                        INNER JOIN %1$slien_service_om_utilisateur
                            ON lien_service_om_utilisateur.service=service.service
                    WHERE
                        lien_service_om_utilisateur.om_utilisateur = %2$d',
                    DB_PREFIXE,
                    intval($this->om_utilisateur['om_utilisateur'])
                ),
                array(
                    "origin" => __METHOD__,
                )
            );

            foreach ($qres['result'] as $result) {
                $this->om_utilisateur['service'][]=$result;
            }

            // Si il y a un resultat c'est un utilisateur de service
            if(isset($this->om_utilisateur['service'])) {
                $this->user_is_service=true;
            } else {
                $this->user_is_service=false;
            }


            // Récupération des infos de tiers consultés
            $qres = $this->get_all_results_from_db_query(
                sprintf('
                    SELECT
                        tiers_consulte.tiers_consulte,
                        tiers_consulte.abrege,
                        tiers_consulte.libelle
                    FROM
                        %1$slien_om_utilisateur_tiers_consulte
                        INNER JOIN %1$stiers_consulte
                            ON lien_om_utilisateur_tiers_consulte.tiers_consulte=tiers_consulte.tiers_consulte
                    WHERE
                        lien_om_utilisateur_tiers_consulte.om_utilisateur = %2$d',
                    DB_PREFIXE,
                    intval($this->om_utilisateur['om_utilisateur'])
                ),
                array(
                    "origin" => __METHOD__,
                )
            );

            foreach ($qres['result'] as $result) {
                $this->om_utilisateur['tiers'][]=$result;
            }

            // Si il y a un resultat c'est un utilisateur de tiers
            $this->user_is_tiers = false;
            if (isset($this->om_utilisateur['tiers'])) {
                $this->user_is_tiers = true;
            }
        }
    }

    /**
     * getter user_is_service
     */
    function isUserService() {
        //
        if (is_null($this->user_is_service)) {
            //
            $this->getUserInfos();
        }
        //
        return $this->user_is_service;
    }

    /**
     * getter user_is_tiers
     */
    function isUserTiers() {
        //
        if (is_null($this->user_is_tiers)) {
            //
            $this->getUserInfos();
        }
        //
        return $this->user_is_tiers;
    }

    /**
     * getter user_is_instr
     */
    function isUserInstructeur() {
        //
        if (is_null($this->user_is_instr)) {
            //
            $this->getUserInfos();
        }
        //
        return $this->user_is_instr;
    }

    function isUserAdministrateur() {
        //
        if (is_null($this->user_is_admin)) {
            //
            $this->getUserInfos();
        }
        //
        return $this->user_is_admin;
    }

    /**
     * getter user_is_service_ext
     */
    function isUserServiceExt() {
        //
        if (is_null($this->user_is_service_ext)) {
            //
            $this->getUserInfos();
        }
        //
        return $this->user_is_service_ext;
    }

    /**
     * getter user_is_service_int
     */
    function isUserServiceInt() {
        //
        if (is_null($this->user_is_service_int)) {
            //
            $this->getUserInfos();
        }
        //
        return $this->user_is_service_int;
    }

    /**
     * getter user_is_qualificateur
     */
    function isUserQualificateur() {
        //
        if (is_null($this->user_is_qualificateur)) {
            //
            $this->getUserInfos();
        }
        //
        return $this->user_is_qualificateur;
    }

    /**
     * getter user_is_chef
     */
    function isUserChef() {
        //
        if (is_null($this->user_is_chef)) {
            //
            $this->getUserInfos();
        }
        //
        return $this->user_is_chef;
    }

    /**
     * getter user_is_divisionnaire
     */
    function isUserDivisionnaire() {
        //
        if (is_null($this->user_is_divisionnaire)) {
            //
            $this->getUserInfos();
        }
        //
        return $this->user_is_divisionnaire;
    }

    /**
     * Méthode permettant de définir si l'utilisateur connecté peut ajouter un
     * événement d'instruction
     *
     * @param integer $idx identifiant du dossier
     * @param string  $obj objet
     *
     * @return boolean true si il peut false sinon
     */
    function isUserCanAddObj($idx, $obj) {
        // Si il à le droit "bypass" il peut ajouter
        if($this->isAccredited($obj."_ajouter_bypass") === true) {
            return true;
        }
        if($this->isAccredited(array($obj."_ajouter", $obj), "OR") === false) {
            return false;
        }
        $return = false;
        
        $object_instance = $this->get_inst__om_dbform(array(
            "obj" => $obj,
            "idx" => "]",
        ));
        // Si il n'est pas dans la même division on défini le retour comme faux
        // à moins qu'il ai un droit de changement de decision
        if($this->isUserInstructeur() === true &&
            ($object_instance->getDivisionFromDossier($idx) == $_SESSION["division"] or
            ($obj == "instruction" &&
            $object_instance->isInstrCanChangeDecision($idx) === true))) {

            $return = true;
        }

        return $return;
    }


    /**
     * Ajout de variables de session contenant la division pour permettre une
     * utilisation plus efficace dans les requetes.
     *
     * @param array $utilisateur Tableau d'informations de l'utilisateur.
     */
    function triggerAfterLogin($utilisateur = NULL) {

        // Récupération de la division de l'utilisateur.
        $qres = $this->get_all_results_from_db_query(
            sprintf('
                SELECT 
                    instructeur.division, 
                    division.code
                FROM 
                    %1$sinstructeur
                    LEFT JOIN %1$sdivision
                        ON instructeur.division = division.division
                WHERE 
                    instructeur.om_utilisateur= %2$d ',
                DB_PREFIXE,
                intval($utilisateur["om_utilisateur"])
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        // On ne récupère que la 1ere ligne
        $row = array_shift($qres['result']);
        
        // Enregistrement de la division en session
        if (isset($row["division"]) && $row["division"] != NULL) {
            $_SESSION["division"] = $row["division"];
            $_SESSION["division_code"] = $row["code"];
        } else {
            $_SESSION["division"] = "0";
            $_SESSION["division_code"] = "";
        }

        // Récupération du paramétrage des groupes de l'utilisateur
        $qres = $this->get_all_results_from_db_query(
            sprintf('
                SELECT 
                    groupe.code, 
                    lien_om_utilisateur_groupe.confidentiel, 
                    lien_om_utilisateur_groupe.enregistrement_demande, 
                    groupe.libelle
                FROM 
                    %1$sgroupe
                    RIGHT JOIN %1$slien_om_utilisateur_groupe 
                        ON lien_om_utilisateur_groupe.groupe = groupe.groupe
                WHERE 
                    lien_om_utilisateur_groupe.login = \'%2$s\'
                ORDER BY 
                    libelle',
                DB_PREFIXE,
                $this->db->escapeSimple($utilisateur["login"])
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        $resGroupes=$qres['result'];

        // Si aucun résultat alors récupération du paramétrage des groupes du profil
        if (count($resGroupes) === 0) {

            $qres = $this->get_all_results_from_db_query(
                sprintf(
                    'SELECT 
                        groupe.code, 
                        lien_om_profil_groupe.confidentiel, 
                        lien_om_profil_groupe.enregistrement_demande, 
                        groupe.libelle
                    FROM 
                        %1$sgroupe
                        RIGHT JOIN %1$slien_om_profil_groupe 
                            ON lien_om_profil_groupe.groupe = groupe.groupe
                        AND 
                            om_profil = %2$s
                    ORDER BY 
                        libelle',
                    DB_PREFIXE,
                    $this->db->escapeSimple($utilisateur["om_profil"])
                ),
                array(
                    "origin" => __METHOD__,
                )
            );

            $resGroupes = $qres['result'];
        }
        $_SESSION["groupe"] = array();
        // Enregistrement des groupe en session
        foreach ($resGroupes as $result) {
            // $resGroupes=$result;
            if ($result["confidentiel"] === 't') {
                $result["confidentiel"] = true;
            } else {
                $result["confidentiel"] = false;
            }
            if ($result["enregistrement_demande"] === 't') {
                $result["enregistrement_demande"] = true;
            } else {
                $result["enregistrement_demande"] = false;
            }
            $_SESSION["groupe"][$result["code"]] = array(
                "confidentiel" => $result["confidentiel"],
                "enregistrement_demande" => $result["enregistrement_demande"],
                "libelle" => $result["libelle"],
            );
        }
    }

    // Affichage des actions supplémentaires
    function displayActionExtras() {
        // Affichage de la division si l'utilisateur en possède une
        if ($_SESSION["division"] != 0) { 
            echo "\t\t\t<li class=\"action-division\">";
            echo "(".$_SESSION['division_code'].")";
            echo "</li>\n";
        }
    }

    // }}}


    // {{{ GESTION DES FICHIERS
    
    /**
     *
     */
    function notExistsError ($explanation = NULL) {
        // message
        $message_class = "error";
        $message = _("Cette page n'existe pas.");
        $this->addToMessage ($message_class, $message);
        //
        $this->setFlag(NULL);
        $this->display();
        
        //
        die();
    }
    
     // }}}
    /**
     * Retourne le statut du dossier d'instruction
     * @param string $idx Identifiant du dossier d'instruction
     * @return string Le statut du dossier d'instruction
     */
    function getStatutDossier($idx){
        $statut = '';
        //Si l'identifiant du dossier d'instruction fourni est correct
        if ($idx != '') {
            //On récupère le statut de l'état du dossier à partir de l'identifiant du
            //dossier d'instruction
            $qres = $this->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        etat.statut
                    FROM
                        %1$sdossier
                        LEFT JOIN %1$setat
                            ON dossier.etat = etat.etat
                    WHERE
                        dossier = \'%2$s\'',
                    DB_PREFIXE,
                    $this->db->escapeSimple($idx)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $statut = $qres["result"];
        }
        return $statut;
    }

    /**
     * Formate le champ pour le type Timestamp
     * @param  date  $date_str      Date
     * @param  boolean $show        Format pour l'affichage
     * @return mixed                False si le traitement échoue ou la date formatée
     */
    function formatTimestamp ($date_str, $show = true) {

        // Sépare la date et l'heure
        $date = explode(" ", $date_str);
        if (count($date) != 2) {
            return false;
        }

        // Date en BDD
        $date_db = explode ('-', $date[0]);
        // Date en affichage
        $date_show = explode ('/', $date[0]);

        // Contrôle la composition de la date
        if (count ($date_db) != 3 and count ($date_show) != 3) {
            return false;
        }

        if (count ($date_db) == 3) {
            // Vérifie que c'est une date valide
            if (!checkdate($date_db[1], $date_db[2], $date_db[0])) {
                return false;
            }
            // Si c'est pour l'affichage de la date
            if ($show == true) {
                return $date_db [2]."/".$date_db [1]."/".$date_db [0]." ".$date[1];
            } else {
                return $date[0];
            }
        }

        //
        if (count ($date_show) == 3) {
            // Vérifie que c'est une date valide
            if (!checkdate($date_show[1], $date_show[0], $date_show[2])) {
                return false;
            }
            // Si c'est pour l'affichage de la date
            if ($show == true) {
                return $date[0];
            } else {
                return $date_show [2]."-".$date_show [1]."-".$date_show [0]." ".$date[1];
            }

        }
        return false;

    }

    /**
     * Permet de calculer la liste des parcelles à partir de la chaîne passée en paramètre
     * et la retourner sous forme d'un tableau associatif
     * 
     * @param  string $strParcelles     Chaîne de la parcelles.
     * @param  string $collectivite_idx Collectivite de la parcelle, false pour que la
     *                                  collectivité ne soit pas récupérée.
     * @param  string $dossier_id       Identifiant du dossier d'instruction.
     * 
     * @return array (array(prefixe, quartier, section, parcelle), ...)
     */
    function parseParcelles($strParcelles, $collectivite_idx = null, $dossier_id = null) {
        
        // Séparation des lignes
        $references = explode(";", $strParcelles);
        $liste_parcelles = array();
        
        // On boucle sur chaque ligne pour ajouter la liste des parcelles de chaque ligne
        foreach ($references as $parcelles) {
            // Si le contenu de la parcelle est vide on passe à la suite
            if (strval($parcelles) === ""){
                continue;
            }
            // Tableau des champs de la ligne de références cadastrales
            $reference_tab = array();
            // On récupère le quartier
            preg_match('/^[0-9]{3}/', $parcelles, $matches);
            if (empty($matches) === false) {
                $reference_tab[] =  $matches[0];
            }

            // Le dernier chiffre de la parcelle est soit au caractère 9 soit au caractère 8
            // Ceci nous permet de savoir si il y a une ou deux lettres dans la section
            if (substr($parcelles, 8, 1) == ''
                || substr($parcelles, 8, 1) == "A" 
                || substr($parcelles, 8, 1) == "/" ) {
                //
                $only_one_letter = true;
                $regex_for_section = '/^[a-zA-Z]{1}/';

            } else if ( preg_match('/^[0-9]+$/', substr($parcelles, 8, 1)) == 1 ) { 
                $only_one_letter = false;
                $regex_for_section = '/^[0-9a-zA-Z]{2}/';
            }
            
            // On récupère la section
            preg_match($regex_for_section, substr($parcelles, 3), $matches);
            if (empty($matches) === false) {
                $reference_tab[] = $matches[0];
            }

            // On récupère la parcelle
            preg_match('/^[0-9]{4}/', substr($parcelles, $only_one_letter === true ? 4 : 5 ), $matches);
            if (empty($matches) === false) {
                $reference_tab[] = $matches[0];
            }

            // On vérifie que la référence cadastrale possède au moins un séparateur
            if ( substr($parcelles, $only_one_letter === true ? 8 : 9 ) !== false ) {
                    // Initialisation du tableau qui va contenir les séparateurs et les parcelles non triés    
                    $sep_parc_tab = array();

                    // On récupère les séparateurs et les parcelles dans un tableau
                    $sep_parc_tab = preg_split('/(A)|(\/)/', substr($parcelles, $only_one_letter === true ? 8 : 9 ), -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

                    // Si le tableau est rempli on boucle sur les séparateurs + parcelles pour les ajouter dans le tableau
                    if ( empty($sep_parc_tab) === false ) {
                        foreach ($sep_parc_tab as $value) {
                            $reference_tab[] = $value;
                        }
                    }
            }

            // Vérification du format de la parcelle
            if (isset($reference_tab[0]) === false
                || isset($reference_tab[1]) === false) {
                //
                $msg = sprintf(
                    "%sLa parcelle %s ne respectent pas le format imposé par openADS.",
                    isset($dossier_id) === true && $dossier_id !== null ? sprintf("%s : ", $dossier_id) : '',
                    $parcelles
                );
                $this->addToLog(__METHOD__."() : ".$msg, DEBUG_MODE);
                continue;
            }

            // Calcul des parcelles
            $quartier = $reference_tab[0];
            $sect = $reference_tab[1];

            $ancien_ref_parc = "";
            for ($i=2; $i < count($reference_tab); $i+=2) {
                if ($collectivite_idx !== null
                    && $collectivite_idx !== false) {
                    // Récupération du code impot de l'arrondissement
                    $collectivite = $this->getCollectivite($collectivite_idx);
                    $parc["prefixe"] = $this->get_arrondissement_code_impot($quartier);
                }
                $parc["quartier"] = $quartier;
                // Met en majuscule si besoin
                $parc["section"] = strtoupper($sect);
                if( $ancien_ref_parc == "" OR $reference_tab[$i-1] == "/") {
                    // 1ere parcelle ou parcelle individuelle
                    // Compléte par des "0" le début de la chaîne si besoin
                    $parc["parcelle"] = str_pad($reference_tab[$i], 4, "0", STR_PAD_LEFT);
                    // Ajout d'une parcelle à la liste
                    $liste_parcelles[] = $parc;
                } elseif ($reference_tab[$i-1] == "A") {
                    // Interval de parcelles
                    for ($j=$ancien_ref_parc+1; $j <= $reference_tab[$i]; $j++) {
                        // Compléte par des "0" le début de la chaîne si besoin
                        $parc["parcelle"] = str_pad($j, 4, "0", STR_PAD_LEFT);
                        // Ajout d'une parcelle à la liste
                        $liste_parcelles[] = $parc;
                    }
                }
                //Gestion des erreurs
                else{
                    $msg = sprintf(
                        "%sLa parcelle %s ne respectent pas le format imposé par openADS.",
                        isset($dossier_id) === true && $dossier_id !== null ? sprintf("%s : ", $dossier_id) : '',
                        $parcelles
                    );
                    $this->addToLog(__METHOD__."() : ".$msg, DEBUG_MODE);
                    continue;
                }
                // Sauvegarde de la référence courante de parcelle
                $ancien_ref_parc = $reference_tab[$i];
            }
        }

        return $liste_parcelles;
    }


    /**
     * Récupère le code impôt par rapport au quartier.
     * 
     * @param string $quartier Numéro de quartier.
     * @return string Code impôts.
     */
    protected function get_arrondissement_code_impot($quartier) {
        // Si le quartier fournis est correct
        if ($quartier != "") {
            // Requête SQL
            $qres = $this->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        arrondissement.code_impots
                    FROM
                        %1$sarrondissement
                        LEFT JOIN %1$squartier
                            ON quartier.arrondissement = arrondissement.arrondissement 
                    WHERE
                        quartier.code_impots = \'%2$s\'',
                    DB_PREFIXE,
                    $quartier
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
        }
        // Retour
        $code_impots = ! isset($qres["result"]) || $qres["result"] === null ?
            '' :
            $qres["result"];
        return $code_impots;
    }


    /**
     * Formate les parcelles en ajoutant le code impôt
     * @param  array    $liste_parcelles   Tableau des parcelles
     * @return string                      Liste des parcelles formatées
     */
    function formatParcelleToSend($liste_parcelles) {

        //
        $wParcelle = array();

        //Formatage des références cadastrales pour l'envoi
        foreach ($liste_parcelles as $value) {
                
            // On ajoute les données dans le tableau que si quartier + section + parcelle
            // a été fourni
            if ($value["quartier"] !== ""
                && $value["section"] !== ""
                && $value["parcelle"] !== ""){
                
                //On récupère le code impôt de l'arrondissement
                $arrondissement = $this->get_arrondissement_code_impot($value["quartier"]);
                
                //On ajoute la parcelle, si un arrondissement a été trouvé
                if ($arrondissement!=="") {
                    //
                    $wParcelle[] = $arrondissement.$value["quartier"].
                        str_pad($value["section"], 2, " ", STR_PAD_LEFT).
                        $value["parcelle"];
                }
            }
        }

        //
        return $wParcelle;
    }

    /**
     * Retourne true si tous les paramètres du SIG externe ont bien été définis
     * @return bool true/false
     */
    public function issetSIGParameter($idx) {
        $collectivite_idx = $this->get_collectivite_of_element("dossier", $idx);
        $collectivite = $this->getCollectivite($collectivite_idx);
        if(isset($collectivite["sig"])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Permet de vérifier que des champs existe dans une table
     * @param  array  $list_fields Liste des champs à tester
     * @param  string $table       Table où les champs doivent exister
     * @return mixed               Retourne les champs qui n'existent pas
     *                             ou true
     */
    public function check_field_exist($list_fields, $table) {

        // Instance de la classe en paramètre
        $object = $this->get_inst__om_dbform(array(
            "obj" => $table,
            "idx" => "]",
        ));

        // Récupère les champs de la table
        foreach ($object->champs as $champ) {
            $list_column[] = $champ;
        }

        // Tableau des champs en erreur
        $error_fields = array();

        // Pour chaque champ à tester
        foreach ($list_fields as $value) {
            
            // S'il n'apparaît pas dans la liste des champs possible
            if (!in_array($value, $list_column)) {

                // Alors le champ est ajouté au tableau des erreurs
                $error_fields[] = $value;
            }
        }

        // Si le tableau des erreurs n'est pas vide on le retourne
        if (count($error_fields) > 0) {
            return $error_fields;
        }

        // Sinon on retourne le booléen true
        return true;

    }

    /*
     * 
     */
    /**
     * Récupère la lettre type lié à un événement
     * @param  integer  $evenement L'identifiant de l'événement
     * @return integer  Retourne l'idenfiant de la lettre-type ou true
     */
    function getLettreType($evenement){

        $qres = $this->get_all_results_from_db_query(
            sprintf('
                SELECT
                    lettretype
                FROM
                    %1$sevenement
                WHERE
                    evenement = %2$d',
                DB_PREFIXE,
                intval($evenement)
            ),
            array(
                "origin" => __METHOD__,
            )
        );


        
        $lettretype = null;
        
        if ($qres['row_count'] > 0) {
            $row = array_shift($qres['result']);
            $lettretype = $row['lettretype'];
        }
       
        return $lettretype;
    }
    
    /**
     * Retourne le type de dossier d'autorisation du dossier courant :
     * @param $idxDossier Le numéro du dossier d'instruction
     * @return le code du type détaillée de dossier d'autorisation
     **/
    function getDATDCode($idxDossier) {
        $qres = $this->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation_type_detaille.code
                FROM
                    %1$sdossier_autorisation_type_detaille
                    INNER JOIN %1$sdossier_autorisation
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_autorisation.dossier_autorisation_type_detaille
                    INNER JOIN %1$sdossier
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->db->escapeSimple($idxDossier)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

    /**
     * Retourne le type de dossier d'autorisation du dossier courant :
     * @param $idxDossier Le numéro du dossier d'instruction
     * @return le code du type de dossier d'autorisation
     **/
    function getDATCode($idxDossier) {
        $qres = $this->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    dossier_autorisation_type.code
                FROM 
                    %1$sdossier_autorisation_type
                    INNER JOIN %1$sdossier_autorisation_type_detaille
                        ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type
                    INNER JOIN %1$sdossier_autorisation
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_autorisation.dossier_autorisation_type_detaille
                    INNER JOIN %1$sdossier
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                WHERE 
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->db->escapeSimple($idxDossier)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

    /**
     * Permet de copier un enregistrement
     * @param  mixed $idx   Identifiant de l'enregistrment
     * @param  string $obj   Objet de l'enregistrment
     * @param  string $objsf Objets associés
     * @return array        Tableau des nouveaux id et du message
     */
    function copier($idx, $obj, $objsf) {

        // Tableau de résultat
        $resArray = array();
        // Message retourné à l'utilisateur
        $message = "";
        // Type du message (valid ou error)
        $message_type = "valid";

        // Requête SQL permettant de récupérer les informations sur l'objet métier
        $qres = $this->get_all_results_from_db_query(
            sprintf('
                SELECT 
                    * 
                FROM 
                    %1$s%2$s
                WHERE 
                    %2$s = %3$s',
                DB_PREFIXE,
                $obj,
                $idx
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        // Valeurs clonées
        $valF = array();

        foreach ($qres['result'] as $result) {
            $valF = $result;
        }

        // Valeurs non clonées
        // Identifiant modifié pour que ça soit un ajout
        $valF[$obj] = "]";
        // Instance de l'objet métier
        $clone_obj = $this->get_inst__om_dbform(array(
            "obj" => $obj,
            "idx" => "]",
        ));
        // Si dans l'objet métier la fonction "copier" existe
        if (method_exists($clone_obj, "update_for_copy")) {
            // Traitement sur les valeurs du duplicata
            $valF = $clone_obj->update_for_copy($valF, $objsf, DEBUG);
            // Recupère les messages retourné par la fonction
            $message .= $valF['message'];
            // Supprime les messages de la liste des valeurs
            unset($valF['message']);
        }
        // Ajoute le duplicata
        $clone_obj->ajouter($valF);
        // Si aucune erreur se produit dans la classe instanciée
        if ($clone_obj->correct === true) {
            // Récupère l'identifiant de l'objet créé
            $clone_obj_id = $clone_obj->valF[$obj];

            // Message
            $message .= sprintf(_("La copie de l'enregistrement %s avec l'identifiant %s s'est effectuee avec succes"), "<span class='bold'>"._($obj)."</span>", "<span class='bold'>".$idx."</span>")."<br />";
            $message .= sprintf(
                '<a class="om-prev-icon" id="action-link--copy-of-%s-%s" href="%s">%s</a><br/><br/>',
                $obj,
                $idx,
                sprintf(
                    '%s&obj=%s&action=3&idx=%s',
                    OM_ROUTE_FORM,
                    $obj,
                    $clone_obj_id
                ),
                ("Cliquer ici pour accéder à la copie")
            );
            // Ajout de l'identifant au tableau des résultat
            $resArray[$obj.'_'.$idx] = $clone_obj_id;

            // S'il y a au moins un objet metier associé
            if ($objsf != "") {
                // Liste des objet métier associés
                $list_objsf = explode(",", $objsf);
                // Pour chaque objet associé
                foreach ($list_objsf as $key => $objsf) {
                    // Requête SQL permettant de récupérer les informations sur 
                    // l'objet métier associé
                    $qres = $this->get_all_results_from_db_query(
                        sprintf('
                            SELECT 
                                * 
                            FROM 
                                %1$s%2$s
                            WHERE 
                                %3$s = %4$s',
                            DB_PREFIXE,
                            $objsf,
                            $obj,
                            $idx
                        ),
                        array(
                            "origin" => __METHOD__,
                        )
                    );

                    // Pour chaque élément associé
                    foreach ($qres['result'] as $result) {
                        // Identifiant de l'objet associé à copier
                        $idxsf = $result[$objsf];

                        // Valeurs clonées
                        $valF = $result;
                        // Valeurs non clonées
                        $valF[$obj] = $clone_obj_id;
                        // Identifiant modifié pour que ça soit un ajout
                        $valF[$objsf] = "]";
                        // Instance de l'objet métier associé
                        $clone_objsf = $this->get_inst__om_dbform(array(
                            "obj" => $objsf,
                            "idx" => "]",
                        ));
                        // Si dans l'objet métier associé 
                        // la fonction "copier" existe
                        if (method_exists($clone_objsf, "update_for_copy")) {
                            // Traitement sur les valeurs du duplicata
                            $valF = $clone_objsf->update_for_copy($valF, $objsf, DEBUG);
                            // Recupère les messages retourné par la fonction
                            $message .= $valF['message'];
                            // Supprime les messages de la liste des valeurs
                            unset($valF['message']);
                        }
                        // Ajoute le duplicata
                        $clone_objsf->ajouter($valF);
                        // Si aucune erreur se produit dans la classe instanciée
                        if ($clone_objsf->correct === true) {
                            // Récupère l'identifiant de l'objet créé
                            $clone_objsf_id = $clone_objsf->valF[$objsf];

                            // Message
                            $message .= sprintf(
                                _("La copie de l'enregistrement %s avec l'identifiant %s s'est effectuee avec succes"),
                                "<span class='bold'>"._($objsf)."</span>",
                                "<span class='bold'>".$idxsf."</span>"
                            )."<br />";

                            // Ajout de l'identifant au tableau des résultat
                            $resArray[$objsf.'_'.$result[$objsf]] = $clone_objsf_id;
                        } else {

                            // Message d'erreur récupéré depuis la classe
                            $message .= $clone_objsf->msg;
                            // Type du message 
                            $message_type = "error";
                        }
                    }
                }
            }
        //    
        } else {

            // Message d'erreur récupéré depuis la classe
            $message .= $clone_obj->msg;
            // Type du message 
            $message_type = "error";
        }

        // Ajout du message au tableau des résultats
        $resArray['message'] = $message;
        // Ajout du type de message au tableau des résultats
        $resArray['message_type'] = $message_type;

        // Retourne le tableau des résultats
        return $resArray;
    }

    /**
     * Cette fonction prend en entrée le ou les paramètres du &contrainte qui sont entre
     * parenthèses (un ensemble de paramètres séparés par des points-virgules). Elle
     * sépare les paramètres et leurs valeurs puis construit et retourne un tableau 
     * associatif qui contient pour les groupes et sous-groupes :
     * - un tableau de valeurs, avec un nom de groupe ou sous-groupe par ligne
     * pour les autres options :
     * - la valeur de l'option
     * 
     * @param string $contraintes_param    Chaîne contenant tous les paramètres
     * 
     * @return array  Tableau associatif avec paramètres et valeurs séparés
     */
    function explodeConditionContrainte($contraintes_param) {

        // Initialisation des variables
        $return = array();
        $listGroupes = "";
        $listSousgroupes = "";
        $service_consulte = "";
        $affichage_sans_arborescence = "";

        // Sépare toutes les conditions avec leurs valeurs et les met dans un tableau
        $contraintes_params = explode(";", $contraintes_param);
        
        // Pour chaque paramètre de &contraintes
        foreach ($contraintes_params as $value) {
            // Récupère le mot-clé "liste_groupe" et les valeurs du paramètre
            if (strstr($value, "liste_groupe=")) { 
                // On enlève le mots-clé "liste_groupe=", on garde les valeurs
                $listGroupes = str_replace("liste_groupe=", "", $value);
            }
            // Récupère le mot-clé "liste_ssgroupe" et les valeurs du paramètre
            if (strstr($value, "liste_ssgroupe=")) { 
                // On enlève le mots-clé "liste_ssgroupe=", on garde les valeurs
                $listSousgroupes = str_replace("liste_ssgroupe=", "", $value);
            }
            // Récupère le mot-clé "service_consulte" et la valeur du paramètre
            if (strstr($value, "service_consulte=")) { 
                // On enlève le mots-clé "service_consulte=", on garde sa valeur
                $service_consulte = str_replace("service_consulte=", "", $value);
            }
            // Récupère le mot-clé "affichage_sans_arborescence" et la valeur du
            // paramètre
            if (strstr($value, "affichage_sans_arborescence=")) { 
                // On enlève le mots-clé "affichage_sans_arborescence=", on garde la valeur
                $affichage_sans_arborescence = str_replace("affichage_sans_arborescence=", "", $value);
            }
        }

        // Récupère dans des tableaux la liste des groupes et sous-groupes qui  
        // doivent être utilisés lors du traitement de la condition
        if ($listGroupes != "") {
            $listGroupes = array_map('trim', explode(",", $listGroupes));
        }
        if ($listSousgroupes != "") {
            $listSousgroupes = array_map('trim', explode(",", $listSousgroupes));
        }

        // Tableau à retourner
        $return['groupes'] = $listGroupes;
        $return['sousgroupes'] = $listSousgroupes;
        $return['service_consulte'] = $service_consulte;
        $return['affichage_sans_arborescence'] = $affichage_sans_arborescence;
        return $return;
    }

    /**
     * Méthode qui complète la clause WHERE de la requête SQL de récupération des
     * contraintes, selon les paramètres fournis. Elle permet d'ajouter une condition sur
     * les groupes, sous-groupes et les services consultés.
     * 
     * @param $string  $part  Contient tous les paramètres fournis à &contraintes séparés
     * par des points-virgules, tel que définis dans l'état.
     * array[]  $conditions  Paramètre optionnel, contient les conditions déjà explosées
     * par la fonction explodeConditionContrainte()
     * 
     * @return string    Contient les clauses WHERE à ajouter à la requête SQL principale.
     */
    function traitement_condition_contrainte($part, $conditions = NULL) {

        // Initialisation de la condition
        $whereContraintes = "";
        // Lorsqu'on a déjà les conditions explosées dans le paramètre $conditions, on
        // utilise ces données. Sinon, on appelle la méthode qui explose la chaîne de 
        // caractères contenant l'ensemble des paramètres.
        if (is_array($conditions)){
            $explodeConditionContrainte = $conditions;
        }
        else {
            $explodeConditionContrainte = $this->explodeConditionContrainte($part);
        }
        // Récupère les groupes, sous-groupes et service_consulte pour la condition
        $groupes = $explodeConditionContrainte['groupes'];
        $sousgroupes = $explodeConditionContrainte['sousgroupes'];
        $service_consulte = $explodeConditionContrainte['service_consulte'];

        // Pour chaque groupe
        if ($groupes != "") {
            foreach ($groupes as $key => $groupe) {
                // Si le groupe n'est pas vide
                if (!empty($groupe)) {
                    // Choisit l'opérateur logique
                    $op_logique = $key > 0 ? 'OR' : 'AND (';
                    // Ajoute la condition
                    $whereContraintes .= " ".$op_logique." lower(trim(both E'\n\r\t' from contrainte.groupe)) = lower('"
                        .pg_escape_string($groupe)."')";
                }
            }
            // S'il y a des valeurs dans groupe
            if (count($groupes) > 0) {
                // Ferme la parenthèse
                $whereContraintes .= " ) ";
            }
        }

        // Pour chaque sous-groupe
        if ($sousgroupes != "") {
            foreach ($sousgroupes as $key => $sousgroupe) {
                // Si le sous-groupe n'est pas vide
                if (!empty($sousgroupe)) {
                    // Choisit l'opérateur logique
                    $op_logique = $key > 0 ? 'OR' : 'AND (';
                    // Ajoute la condition
                    $whereContraintes .= " ".$op_logique." lower(trim(both E'\n\r\t' from contrainte.sousgroupe)) = lower('"
                        .pg_escape_string($sousgroupe)."')";
                }
            }
            // S'il y a des valeurs dans sous-groupe
            if (count($sousgroupes) > 0) {
                // Ferme la parenthèse
                $whereContraintes .= " ) ";
            }
        }

        // Si l'option service_consulte n'est pas vide
        if ($service_consulte != "") {
            // Ajoute la condition
            $whereContraintes .= " AND service_consulte = cast(lower('".$service_consulte."') as boolean) ";
        }

        // Condition retournée
        return $whereContraintes;
    }

    /**
     * Calcule une date par l'ajout ou la soustraction de mois ou de jours.
     *
     * @param date    $date     Date de base (format dd-mm-yyyy)
     * @param integer $delay    Délais à ajouter
     * @param string  $operator Opérateur pour le calcul ("-" ou "+")
     * @param string  $type     Type de calcul (mois ou jour)
     * 
     * @return date             Date calculée
     */
    function mois_date($date, $delay, $operator = "+", $type = "mois") {
        // On force le type du paramètre $delay
        $delay = intval($delay);

        // Si un type n'est pas définit
        if ($type != "mois" && $type != "jour") {
            //
            return null;
        }

        // Si aucune date n'a été fournie ou si ce n'est pas une date correctement 
        // formatée
        if ( is_null($date) || $date == "" ||
            preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $date) == 0 ){
            return null;
        }

        // Si l'opérateur n'est pas définit
        if ($operator != "+" && $operator != "-") {
            //
            return null;
        }

        // Découpage de la date
        $temp = explode("-", $date);
        $day = (int) $temp[2];
        $month = (int) $temp[1];
        $year = (int) $temp[0];

        // Si c'est un calcul sur des mois
        // Le calcul par mois ne se fait pas comme le calcul par jour car
        // les fonctions PHP ne réalisent pas les calculs réglementaires
        if ($type == "mois") {

            // Si c'est une addition
            if ($operator == '+') {
                // Année à ajouter
                $year += floor($delay / 12);
                // Mois restant
                $nb_month = ($delay % 12);
                // S'il y a des mois restant
                if ($nb_month != 0) {
                    // Ajout des mois restant
                    $month += $nb_month;
                    // Si ça dépasse le mois 12 (décembre)
                    if ($month > 12) {
                        // Soustrait 12 au mois
                        $month -= 12;
                        // Ajoute 1 à l'année
                        $year += 1;
                    }
                }
            }

            // Si c'est une soustraction
            if ($operator == "-") {
                // Année à soustraire
                $year -= floor($delay / 12);
                // Mois restant
                $nb_month = ($delay % 12);
                // S'il y a des mois restant
                if ($nb_month != 0) {
                    // Soustrait le délais
                    $month -= $nb_month;
                    // Si ça dépasse le mois 1 (janvier)
                    if ($month < 1) {
                        // Soustrait 12 au mois
                        $month += 12;
                        // Ajoute 1 à l'année
                        $year -= 1;
                    }
                }
            }

            // Calcul du nombre de jours dans le mois sélectionné
            switch($month) {
                // Mois de février
                case "2":
                    if ($year % 4 == 0 && $year % 100 != 0 || $year % 400 == 0) {
                        $day_max = 29;
                    } else {
                        $day_max = 28;
                    }
                break;
                // Mois d'avril, juin, septembre et novembre
                case "4":
                case "6":
                case "9":
                case "11":
                    $day_max = 30;
                break;
                // Mois de janvier, mars, mai, juillet, août, octobre et décembre 
                default:
                    $day_max = 31;
            }

            // Si le jour est supérieur au jour maximum du mois
            if ($day > $day_max) {
                // Le jour devient le jour maximum
                $day = $day_max;
            }

            // Compléte le mois et le jour par un 0 à gauche si c'est un chiffre
            $month = str_pad($month, 2, "0", STR_PAD_LEFT);
            $day = str_pad($day, 2, "0", STR_PAD_LEFT);

            // Résultat du calcul
            $date_result = $year."-".$month."-".$day;
        }

        // Si c'est un calcul sur des jours
        if ($type == "jour") {
            //
            $datetime = new DateTime($date);
            // Si le délai est un numérique
            if (is_numeric($delay)) {
                // Modifie la date
                $datetime->modify($operator.$delay.' days');
            }
            // Résultat du calcul
            $date_result = $datetime->format('Y-m-d');
        }

        // Retourne la date calculée
        return $date_result;
    }

    /**
     * Vérifie la valididité d'une date.
     * 
     * @param string $pDate Date à vérifier
     * 
     * @return boolean
     */
    function check_date($pDate) {

        // Vérifie si c'est une date valide
        if (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $pDate, $date) 
            && checkdate($date[2], $date[3], $date[1]) 
            && $date[1] >= 1900) {
            //
            return true;
        }

        //
        return false;
    }
    
    /**
     * Permet de tester le bypass
     * 
     * @param string $obj le nom de l'objet
     * @param string $permission_suffix  
     * @return boolean
     */
    function can_bypass($obj="", $permission_suffix=""){
        //On teste le droit bypass
        if ($permission_suffix!=""&&$obj!=""&&
            $this->isAccredited($obj."_".$permission_suffix."_bypass")){
            return true;
        }
        return false;
    }


    /**
     * Vérifie l'option de numérisation.
     *
     * @return boolean
     */
    public function is_option_digitalization_folder_enabled() {
        //
        if ($this->getParameter("option_digitalization_folder") !== true) {
            //
            return false;
        }
        //
        return true;
    }


    /**
     * Vérifie l'option de suppression d'un dossier d'instruction.
     *
     * @return boolean
     */
    public function is_option_suppression_dossier_instruction_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_suppression_dossier_instruction']) === true
            && $parameters['option_suppression_dossier_instruction'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }



    /**
     * Vérifie que l'option d'accès au portail citoyen est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_citizen_access_portal_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_portail_acces_citoyen']) === true
            && $parameters['option_portail_acces_citoyen'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }


    /**
     * Vérifie que l'option du SIG est activée.
     *
     * @return boolean
     */
    public function is_option_sig_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_sig']) === true
            && $parameters['option_sig'] === 'sig_externe') {
            //
            return true;
        }
        //
        return false;
    }

    /**
     * Vérifie que l'option du SIG est activée.
     *
     * @return boolean
     */
    public function is_option_ws_synchro_contrainte_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_ws_synchro_contrainte']) === true
            && $parameters['option_ws_synchro_contrainte'] === 'true') {
            //
            return true;
        }
        //
        return false;
    }


    /**
     * Vérifie que l'option de simulation des taxes est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_simulation_taxes_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_simulation_taxes']) === true
            && $parameters['option_simulation_taxes'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option de prévisualisation de l'édition est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_preview_pdf_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_previsualisation_edition']) === true
            && $parameters['option_previsualisation_edition'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option de rédaction libre de l'édition est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_redaction_libre_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_redaction_libre']) === true
            && $parameters['option_redaction_libre'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }


    /**
     * Vérifie que l'option de finalisation automatique des instructions tacites
     * et retours est activée..
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_finalisation_auto_enabled($om_collectivite = null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_final_auto_instr_tacite_retour']) === true
            && $parameters['option_final_auto_instr_tacite_retour'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option de trouillotage numérique automatique des
     * pièces est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_trouillotage_numerique_enabled($om_collectivite = null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_trouillotage_numerique']) === true
            && $parameters['option_trouillotage_numerique'] === 'true') {
            //
            return true;
        }
        //
        return false;
    }

    /**
     * Vérifie que l'option de saisie du numéro de dossier est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_dossier_saisie_numero_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_dossier_saisie_numero']) === true
            && $parameters['option_dossier_saisie_numero'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option de saisie du numéro de dossier est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_dossier_saisie_numero_complet_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_dossier_saisie_numero_complet']) === true
            && $parameters['option_dossier_saisie_numero_complet'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option de la commune associée à un dossier est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_dossier_commune_enabled($om_collectivite=null) {
        $parameters = $this->getCollectivite($om_collectivite);
        return (
            isset($parameters['option_dossier_commune']) &&
            $parameters['option_dossier_commune'] === 'true');
    }

    /**
     * Vérifie que l'option de récupération de la division de l'instructeur
     * affecté pour la numérotation des dossiers est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_instructeur_division_numero_dossier_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_instructeur_division_numero_dossier']) === true
            && $parameters['option_instructeur_division_numero_dossier'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option pour afficher les un surlignage en couleur des
     * numéros des dossiers dans les listings est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_afficher_couleur_dossier($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_afficher_couleur_dossier']) === true
            && $parameters['option_afficher_couleur_dossier'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option du suivi de numérisation est activée.
     * Les utilisateurs de la collectivité de niveau 2 peuvent accéder aux
     * fonctionnalités du suivi de numérisation même si l'option est activée seulement
     * sur une collectivité de niveau 1.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_suivi_numerisation_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_suivi_numerisation']) === true
            && $parameters['option_suivi_numerisation'] === 'true') {
            //
            return true;
        }

        // Si l'utilisateur fait partie de la collectivité de niveau 2
        // et qu'au moins une des communes à l'option de numérisation activée
        if ($this->has_collectivite_multi() === true) {
            $qres = $this->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        valeur
                    FROM
                        %1$som_parametre
                    WHERE
                        libelle = \'option_suivi_numerisation\'',
                    DB_PREFIXE
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($qres["code"] === "OK"
                && $qres["result"] === "true") {
                //
                return true;
            }
        }

        //
        return false;
    }

    // Mode MC
    public function is_option_om_collectivite_entity_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_om_collectivite_entity']) === true
            && $parameters['option_om_collectivite_entity'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    public function is_option_date_depot_mairie_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_date_depot_mairie']) === true
            && $parameters['option_date_depot_mairie'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * [is_option_date_depot_mairie_enabled description]
     * @param  [type]  $om_collectivite [description]
     * @return boolean                  [description]
     */
    public function is_option_renommer_collectivite_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_renommer_collectivite']) === true
            && $parameters['option_renommer_collectivite'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * [is_option_mode_service_consulte_enabled description]
     * @param  [type]  $om_collectivite [description]
     * @return boolean                  [description]
     */
    public function is_option_mode_service_consulte_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_mode_service_consulte']) === true
            && $parameters['option_mode_service_consulte'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie si l'option de notification automatique de dépôt de dossier
     * par voie dématérialisée est active ou pas.
     *
     * @param integer $om_collectivite identifiant de la collectivité
     * @return boolean
     */
    public function is_option_notification_depot_demat_enabled($om_collectivite=null) {
        $parameters = $this->getCollectivite($om_collectivite);

        if (isset($parameters['option_notification_depot_demat']) === true
            && $parameters['option_notification_depot_demat'] === 'true') {
            return true;
        }
        return false;
    }

    /**
     * Méthode permettant de récupérer le paramètrage de l'option
     * option_notification
     *
     * @param integer identifiant de la collectivité dont on veux le paramétrage
     * @return string la valeur du paramètre ou null si il n'est pas défini
     */
    public function get_param_option_notification($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_notification']) === true) {
            return $parameters['option_notification'];
        }
        //
        return null;
    }

    /**
     * Méthode permettant de récupérer le paramètrage de l'option
     * param_operateur
     *
     * @param integer identifiant de la collectivité. Par défaut, il est null
     * @return array
     */
    public function get_option_param_operateur($om_collectivite=null) {

        $parameters = $this->getCollectivite($om_collectivite);

        if (isset($parameters['param_operateur']) === true) {
            $param_operateur = json_decode($parameters['param_operateur']);
            return $param_operateur;
        }

        return null;
    }

    /**
     * Méthode permettant de récupérer le paramètre
     * affichage_di_listing_colonnes_masquees
     *
     * @param integer identifiant de la collectivité. Par défaut, il est null
     * @return array
     */
    public function get_affichage_di_listing_colonnes_masquees($om_collectivite=null) {
        $parameters = $this->getCollectivite($om_collectivite);
        if (isset($parameters['affichage_di_listing_colonnes_masquees']) === true) {
            $colonnes = explode(";", $parameters['affichage_di_listing_colonnes_masquees']);
            return $colonnes;
        }

        return null;
    }

    /**
     * Méthode permettant de récupérer le paramètre
     * option_afficher_localisation_colonne_dossier
     *
     * @param integer identifiant de la collectivité. Par défaut, il est null
     * @return boolean
     */
    public function is_option_afficher_localisation_colonne_dossier($om_collectivite=null) {
        $parameters = $this->getCollectivite($om_collectivite);
        if (isset($parameters['option_afficher_localisation_colonne_dossier']) === true
            && $parameters['option_afficher_localisation_colonne_dossier'] === 'true') {
            //
            return true;
        }

        return false;
    }


    /**
     * Méthode permettant de récupérer le paramètrage de l'option
     * option_notification
     *
     * @return boolean
     */
    public function get_parametre_notification_url_acces($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['parametre_notification_url_acces']) === true) {
            return $parameters['parametre_notification_url_acces'];
        }
        //
        return null;
    }

    /**
     * Permet de récupérer le paramètre 'param_base_path_metadata_url_di'
     *
     * @param  integer $om_collectivite Identifiant de la collectivité.
     * @return mixed                    Chaine de caractères ou null
     */
    public function get_param_base_path_metadata_url_di($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['param_base_path_metadata_url_di']) === true) {
            return $parameters['param_base_path_metadata_url_di'];
        }
        //
        return null;
    }

    /**
     * Permet de récupérer le paramètre 'portal_code_suivi_base_url'.
     *
     * @param  integer $om_collectivite Identifiant de la collectivité.
     * @return mixed                    Chaine de caractères ou null.
     */
    public function get_portal_code_suivi_base_url($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['portal_code_suivi_base_url']) === true
            && $parameters['portal_code_suivi_base_url'] !== null
            && $parameters['portal_code_suivi_base_url'] !== '') {
            //
            return $parameters['portal_code_suivi_base_url'];
        }
        //
        return null;
    }

    /**
     * Méthode permettant de récupérer le corps et le titre du mail de notification
     * selon le type de notification voulu.
     *
     * @return boolean
     */
    public function get_notification_parametre_courriel_type($om_collectivite=null, $typeNotification = 'notification_demandeur') {
        $paramDefaut = array(
            'parametre_courriel_type_titre' => __("[openADS] Notification concernant votre dossier [DOSSIER]"),
            'parametre_courriel_type_message' => __("Bonjour, veuillez prendre connaissance du(des) document(s) suivant(s) :<br>[LIEN_TELECHARGEMENT_DOCUMENT]<br>[LIEN_TELECHARGEMENT_ANNEXE]"),
        );
        // Il existe 3 type de notification des demandeurs. Si la notification voulu appartiens a un de ces 3 types
        // alors ce sont les paramétre de la notification des demandeurs qui doivent être récupéré
        if (in_array($typeNotification, array('notification_instruction', 'notification_recepisse', 'notification_decision'))) {
            $typeNotification = 'notification_demandeur';
        }
        // Construit le nom de la méthode selon le type de notification
        // si la méthode existe elle est appellé sinon on renvoie le message défini par défaut
        $method = sprintf('get_%1$s_parametre_courriel_type', $typeNotification);
        if (method_exists($this, $method)) {
            $param = $this->$method($om_collectivite);
            // Si le titre du message n'a pas été récupéré c'est le titre par défaut qui est utilisé
            $param['parametre_courriel_type_titre'] =
                ! array_key_exists('parametre_courriel_type_titre', $param) ?
                $paramDefaut['parametre_courriel_type_titre'] :
                $param['parametre_courriel_type_titre'];
            // Si le corps du message n'a pas été récupéré c'est le titre par défaut qui est utilisé
            $param['parametre_courriel_type_message'] =
                ! array_key_exists('parametre_courriel_type_message', $param) ?
                $paramDefaut['parametre_courriel_type_message'] :
                $param['parametre_courriel_type_message'];
            return $param;
        }
        return $paramDefaut;
    }

    /**
     * Permet de récupérer les phrases types composant la notification aux pétitionnaires.
     *
     * @param  integer $om_collectivite Identifiant de la collectivité.
     *
     * @return array                    Tableau contenant les phrases types.
     */
    private function get_notification_demandeur_parametre_courriel_type($om_collectivite = null) {
        // Phrases types par défaut
        $result = array();
        // Récupération des paramètres
        $parameters = $this->getCollectivite($om_collectivite);
        // Vérification de l'existance des paramètres titre et message
        if (isset($parameters['parametre_courriel_type_message']) === true
            && $parameters['parametre_courriel_type_message'] !== null
            && $parameters['parametre_courriel_type_message'] !== '') {
            //
            $result['parametre_courriel_type_message'] = $parameters['parametre_courriel_type_message'];
        }
        if (isset($parameters['parametre_courriel_type_titre']) === true
            && $parameters['parametre_courriel_type_titre'] !== null
            && $parameters['parametre_courriel_type_titre'] !== '') {
            //
            $result['parametre_courriel_type_titre'] = $parameters['parametre_courriel_type_titre'];
        }
        //
        return $result;
    }

    /**
     * Permet de récupérer les phrases types composant la notification aux services
     * consultés.
     *
     * @param  integer $om_collectivite Identifiant de la collectivité.
     *
     * @return array                    Tableau contenant les phrases types.
     */
    private function get_notification_service_consulte_parametre_courriel_type($om_collectivite = null) {
        // Phrases types par défaut
        $result = array();
        // Récupération des paramètres
        $parameters = $this->getCollectivite($om_collectivite);
        // Vérification de l'existance des paramètres titre et message
        if (isset($parameters['parametre_courriel_service_type_message']) === true
            && $parameters['parametre_courriel_service_type_message'] !== null
            && $parameters['parametre_courriel_service_type_message'] !== '') {
            //
            $result['parametre_courriel_type_message'] = $parameters['parametre_courriel_service_type_message'];
        }
        if (isset($parameters['parametre_courriel_service_type_titre']) === true
            && $parameters['parametre_courriel_service_type_titre'] !== null
            && $parameters['parametre_courriel_service_type_titre'] !== '') {
            //
            $result['parametre_courriel_type_titre'] = $parameters['parametre_courriel_service_type_titre'];
        }
        //
        return $result;
    }

    /**
     * Permet de récupérer les phrases types composant la notification aux tiers consultés.
     *
     * @param  integer $om_collectivite Identifiant de la collectivité.
     *
     * @return array                    Tableau contenant les phrases types.
     */
    private function get_notification_tiers_consulte_parametre_courriel_type($om_collectivite = null) {
        // Phrases types par défaut
        $result = array();
        // Récupération des paramètres
        $parameters = $this->getCollectivite($om_collectivite);
        // Vérification de l'existance des paramètres titre et message
        if (isset($parameters['parametre_courriel_tiers_type_message']) === true
            && $parameters['parametre_courriel_tiers_type_message'] !== null
            && $parameters['parametre_courriel_type_message'] !== '') {
            //
            $result['parametre_courriel_type_message'] = $parameters['parametre_courriel_tiers_type_message'];
        }
        if (isset($parameters['parametre_courriel_tiers_type_titre']) === true
            && $parameters['parametre_courriel_tiers_type_titre'] !== null
            && $parameters['parametre_courriel_tiers_type_titre'] !== '') {
            //
            $result['parametre_courriel_type_titre'] = $parameters['parametre_courriel_tiers_type_titre'];
        }
        //
        return $result;
    }

    /**
     * Permet de récupérer les phrases types composant la notification automatique du
     * dépôt de dossiers dématérialisés.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return array Tableau contenant les phrases types.
     */
    private function get_notification_depot_demat_parametre_courriel_type($om_collectivite = null) {
        // Phrases types par défaut
        $result = array();
        // Récupération des paramètres
        $parameters = $this->getCollectivite($om_collectivite);
        // Vérification de l'existance des paramètres titre et message
        if (isset($parameters['param_courriel_de_notification_depot_demat_message']) === true
            && $parameters['param_courriel_de_notification_depot_demat_message'] !== null
            && $parameters['param_courriel_de_notification_depot_demat_message'] !== '') {

            $result['parametre_courriel_type_message'] =
                $parameters['param_courriel_de_notification_depot_demat_message'];
        }
        if (isset($parameters['param_courriel_de_notification_depot_demat_titre']) === true
            && $parameters['param_courriel_de_notification_depot_demat_titre'] !== null
            && $parameters['param_courriel_de_notification_depot_demat_titre'] !== '') {

            $result['parametre_courriel_type_titre'] =
                $parameters['param_courriel_de_notification_depot_demat_titre'];
        }
        return $result;
    }

    /**
     * Permet de récupérer les phrases types composant la notification aux services
     * consultés.
     *
     * @param  integer $om_collectivite Identifiant de la collectivité.
     *
     * @return array Tableau contenant les phrases types.
     */
    public function get_notification_commune_parametre_courriel_type($om_collectivite = null) {
        // Phrases types par défaut
        $result = array();
        // Récupération des paramètres
        $parameters = $this->getCollectivite($om_collectivite);
        // Vérification de l'existance des paramètres titre et message
        if (isset($parameters['param_courriel_de_notification_commune_modele_depuis_instruction']) === true
            && $parameters['param_courriel_de_notification_commune_modele_depuis_instruction'] !== null
            && $parameters['param_courriel_de_notification_commune_modele_depuis_instruction'] !== '') {
            //
            $result['parametre_courriel_type_message'] = $parameters['param_courriel_de_notification_commune_modele_depuis_instruction'];
        }
        if (isset($parameters['param_courriel_de_notification_commune_objet_depuis_instruction']) === true
            && $parameters['param_courriel_de_notification_commune_objet_depuis_instruction'] !== null
            && $parameters['param_courriel_de_notification_commune_objet_depuis_instruction'] !== '') {
            //
            $result['parametre_courriel_type_titre'] = $parameters['param_courriel_de_notification_commune_objet_depuis_instruction'];
        }
        //
        return $result;
    }

    /**
     * Méthode permettant de récupérer le corps et le titre du mail de notification au signataire
     *
     * @param integer identifiant de la collectivité
     *
     * @return array tableau à deux entrées :
     *    - parametre_courriel_type_titre : titre parametré pour les courriels
     *    - parametre_courriel_type_message : contenu parametré pour les courriels
     */
    public function get_notification_signataire_parametre_courriel_type($om_collectivite = null) {
        // Phrases types par défaut
        $result = array(
            'parametre_courriel_type_titre' => __("[openADS] Nouveau document à signer pour le dossier [DOSSIER]"),
            'parametre_courriel_type_message' => __("Bonjour,<br/><br/>Un document concernant le dossier <DOSSIER_INSTRUCTION> est disponible à la signature.<br/><br/>Vous pouvez le signer en cliquant sur le lien suivant :<br/>[LIEN_PAGE_SIGNATURE]<br/><br/>Si vous possédez un compte sur openADS, vous pouvez retrouver l'intégralité du dossier en suivant le lien ci-dessous :<br/>[URL_DOSSIER]"),
        );
        // Récupération des paramètres
        $parameters = $this->getCollectivite($om_collectivite);
        if (isset($parameters['param_courriel_notification_signataire_type_message']) === true
            && $parameters['param_courriel_notification_signataire_type_message'] !== null
            && $parameters['param_courriel_notification_signataire_type_message'] !== '') {
            //
            $result['parametre_courriel_type_message'] = $parameters['param_courriel_notification_signataire_type_message'];
        }
        if (isset($parameters['param_courriel_notification_signataire_type_titre']) === true
            && $parameters['param_courriel_notification_signataire_type_titre'] !== null
            && $parameters['param_courriel_notification_signataire_type_titre'] !== '') {
            //
            $result['parametre_courriel_type_titre'] = $parameters['param_courriel_notification_signataire_type_titre'];
        }
        //
        return $result;
    }

    /**
     * Récupère la liste des mails paramétrés pour l'envoi de notification email aux
     * communes
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return array Liste des adresses emails.
     */
    public function get_param_courriel_de_notification_commune($om_collectivite = null) {
        $listeEmail = array();
        // Récupération des paramètres
        $parameters = $this->getCollectivite($om_collectivite);
        // Récupération du contenu du paramèrtre
        if (! empty($parameters['param_courriel_de_notification_commune'])) {
            $listeEmail = explode("\n", $parameters['param_courriel_de_notification_commune']);
        }
        return $listeEmail;
    }

    /**
     * Permet de récupérer la limite maximum du nombre d'annexe que l'on peux envoyer
     * lors de la notification des pétitionnaires via le paramètre "parametre_notification_max_annexes"
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return int Valeur maximale du nombre d'annexe notifiable
     */
    public function get_nb_max_annexe($om_collectivite = null) {
        $nb_annexe_max = 5;
        // Récupération des paramètres
        $parameters = $this->getCollectivite($om_collectivite);
        // Récupération de la valeur du paramètre 'parametre_notification_max_annexes'
        if (!empty($parameters['parametre_notification_max_annexes'])
            && is_numeric($parameters['parametre_notification_max_annexes'])) {
            // Si l'utilisateur à ajouté et correctement saisi le paramètre "parametre_notification_max_annexes" 
            // cette valeur devient la nouvelle limite du nombre max d'annexe notifiable
            $nb_annexe_max = intVal($parameters['parametre_notification_max_annexes']);
        }
        return $nb_annexe_max;
    }

    function is_type_dossier_platau($dossier_autorisation) {
        $inst_da = $this->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => $dossier_autorisation,
        ));

        $inst_datd = $inst_da->get_inst_dossier_autorisation_type_detaille();

        if ($inst_datd->getVal('dossier_platau') === true || $inst_datd->getVal('dossier_platau') === 't'){
            return true;
        }

        return false;
    }

    /**
     * Définit si le type de dossier d'instruction est transmissible à Plat'AU.
     *
     * @param  integer  $dossier_instruction_type Identifiant du type de dossier d'instruction
     *
     * @return boolean
     */
    public function is_dit_transmitted_platau($dossier_instruction_type, $om_collectivite = null) {
        $parameters = $this->getCollectivite($om_collectivite);
        $inst_dit = $this->get_inst__om_dbform(array(
            "obj" => "dossier_instruction_type",
            "idx" => $dossier_instruction_type,
        ));
        // Si le code du type de dossier d'instruction est dans la liste des codes
        // identifiés comme transmissibles à Plat'AU grâce au paramètre dit_code__to_transmit__platau
        if (isset($parameters['dit_code__to_transmit__platau']) === true) {
            $dit_code__to_transmit__platau = explode(";", $parameters['dit_code__to_transmit__platau']);
            if (is_array($dit_code__to_transmit__platau) === true) {
                $dit_code__to_transmit__platau = array_map('mb_strtolower', $dit_code__to_transmit__platau);
                if (in_array(mb_strtolower($inst_dit->getVal('code')), $dit_code__to_transmit__platau, true)) {
                    // Le type de DI est considéré comme transmissible
                    return true;
                }
            }
            // Si le code n'est pas renseigné, alors le type de DI n'est pas transmissible
            return false;
        }
        // Si le paramètre n'est pas définit alors tous les types de DI sont considéré comme transmissible
        return true;
    }

    /**
     * Vérifie que l'option du lien Google Street View est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_streetview_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_streetview']) === true
            && $parameters['option_streetview'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option d'affichage en lecture seule de la date
     * de l'événement d'instruction est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_date_evenement_instruction_lecture_seule($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_date_evenement_instruction_lecture_seule']) === true
            && $parameters['option_date_evenement_instruction_lecture_seule'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option référentiel ERP est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_geolocalisation_auto_contrainte_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_geolocalisation_auto_contrainte']) === true
            && $parameters['option_geolocalisation_auto_contrainte'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie que l'option de renommage des documents numérisés ajoutés par
     * une tâches "add_piece" est activée.
     *
     * Cette option doit être globale, c'est-à-dire soit sur la collectivité de
     * niveau 2, soit désactivée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_renommage_document_numerise_tache_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_renommage_document_numerise_tache']) === true
            && $parameters['option_renommage_document_numerise_tache'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Vérifie le niveau de la collectivité de l'utilisateur connecté
     * 
     * @return boolean
     */
    function has_collectivite_multi() {
        $idx_multi = $this->get_idx_collectivite_multi();
        if (intval($_SESSION['collectivite']) === intval($idx_multi)) {
            return true;
        }
        return false;
    }


    /**
     * Pour un path absolu donné, retourne le relatif à la racine de
     * l'application.
     *
     * @param string $absolute Chemin absolu.
     *
     * @return mixed Faux si échec sinon chemin relatif.
     */
    public function get_relative_path($absolute) {
        if ($this->get_path_app() === false) {
            return false;
        }
        $path_app = $this->get_path_app();
        return str_replace($path_app, '', $absolute);
    }


    /**
     * Retourne le path absolu de la racine de l'application
     * 
     * @return mixed Faux si échec sinon chemin absolu
     */
    public function get_path_app() {
        $match = array();
        preg_match( '/(.*)\/[a-zA-Z0-9]+\/\.\.\/core\/$/', PATH_OPENMAIRIE, $match);
        // On vérifie qu'il n'y a pas d'erreur
        if (isset($match[1]) === false) {
            return false;
        }
        return $match[1];
    }

    /**
     * Compose un tableau et retourne son code HTML
     * 
     * @param   string  $id       ID CSS du conteneur
     * @param   array   $headers  entêtes de colonnes
     * @param   array   $rows     lignes
     * @return  string            code HTML
     */
    public function compose_generate_table($id, $headers, $rows) {
        //
        $html = '';
        // Début conteneur
        $html .= '<div id="'.$id.'">';
        // Début tableau
        $html .= '<table class="tab-tab">';
        // Début entête
        $html .= '<thead>';
        $html .= '<tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">';
        // Colonnes
        $nb_colonnes = count($headers);
        $index_last_col = $nb_colonnes - 1;
        foreach ($headers as $i => $header) {
            if ($i === 0) {
                $col = ' firstcol';
            }
            if ($i === $index_last_col) {
                $col = ' lastcol';
            }
            $html .= '<th class="title col-'.$i.$col.'">';
                $html .= '<span class="name">';
                    $html .= $header;
                $html .= '</span>';
            $html .= '</th>';
        }
        // Fin entête
        $html .= '</tr>';
        $html .= '</thead>';
        // Début corps
        $html .= '<tbody>';
        // Lignes
        foreach ($rows as $cells) {
            // Début ligne
            $html .= '<tr class="tab-data">';
            // Cellules
            foreach ($cells as $j => $cell) {
                if ($j === 0) {
                $col = ' firstcol';
                }
                if ($j === $index_last_col) {
                    $col = ' lastcol';
                }
                $html .= '<td class="title col-'.$j.$col.'">';
                    $html .= '<span class="name">';
                        $html .= $cell;
                    $html .= '</span>';
                $html .= '</td>';
            }
            // Fin ligne
            $html .= "</tr>";
        }
        // Fin corps
        $html .= '</tbody>';
        // Fin tableau
        $html .= '</table>';
        // Fin conteneur
        $html .= '</div>';
        //
        return $html;
    }

    /**
     * Retourne le login de l'utilisateur connecté + entre parenthèses son nom
     * s'il en a un.
     * 
     * @return  string  myLogin OU myLogin (myName)
     */
    public function get_connected_user_login_name() {
        // Requête et stockage des informations de l'user connecté
        $this->getUserInfos();
        // Si le nom existe et est défini on le récupère
        $nom = "";
        if (isset($this->om_utilisateur["nom"])
            && !empty($this->om_utilisateur["nom"])) {
            $nom = trim($this->om_utilisateur["nom"]);
        }
        // Définition de l'émetteur : obligatoirement son login
        $emetteur = $_SESSION['login'];
        // Définition de l'émetteur : + éventuellement son nom
        if ($nom != "") {
            $emetteur .= " (".$nom.")";
        }
        // Retour
        return $emetteur;
    }

    /**
     * Cette méthode permet d'interfacer le module 'Settings'.
     */
    function view_module_settings() {
        //
        require_once "../obj/settings.class.php";
        $settings = new settings();
        $settings->view_main();
    }


    /**
     * Vérifie que l'option référentiel ERP est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_referentiel_erp_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_referentiel_erp']) === true
            && $parameters['option_referentiel_erp'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }
    
    /**
     * Vérifie que l'option d'affichage de la miniature des fichiers est activée.
     *
     * @param integer $om_collectivite Identifiant de la collectivité.
     *
     * @return boolean
     */
    public function is_option_miniature_fichier_enabled($om_collectivite=null) {
        //
        $parameters = $this->getCollectivite($om_collectivite);
        //
        if (isset($parameters['option_miniature_fichier']) === true
            && $parameters['option_miniature_fichier'] === 'true') {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Méthode générique permettant de savoir si une option donnée est active.
     *
     * @param string $opionName : nom de l'option dans la table om_parametre
     * @param string $om_collectivite : identifiant de la collectivite pour laquelle on souhaite vérifier
     * l'activation de l'option.
     *
     * @return boolean
     */
    public function is_option_enabled(string $optionName, $om_collectivite = null) {
        // Récupération des paramètres de la collectivité voulu
        $parameters = $this->getCollectivite($om_collectivite);
        // Vérification que l'option est active cad qu'elle existe et qu'elle a pour valeur 'true'
        return isset($parameters[$optionName]) === true && $parameters[$optionName] === 'true';
    }

    /**
     * Interface avec le référentiel ERP.
     */
    function send_message_to_referentiel_erp($code, $infos) {
        //
        require_once "../obj/interface_referentiel_erp.class.php";
        $interface_referentiel_erp = new interface_referentiel_erp();
        $ret = $interface_referentiel_erp->send_message_to_referentiel_erp($code, $infos);
        return $ret;
    }

    /**
     * Récupère la liste des identifiants des collectivités
     *
     * @param  string $return_type 'string' ou 'array' selon que l'on retourne
     *                             respectivement une chaîne ou un tableau
     * @param  string $separator   caractère(s) séparateur(s) employé(s) lorsque
     *                             l'on retourne une chaîne, inutilisé si tableau
     * @return mixed               possibilité de boolean/string/array :
     *                             false si erreur BDD sinon résultat
     */
    public function get_list_id_collectivites($return_type = 'string', $separator = ',') {
        $qres = $this->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    array_to_string(
                        array_agg(om_collectivite),
                        \'%2$s\'
                    ) AS list_id_collectivites
                FROM
                    %1$som_collectivite',
                DB_PREFIXE,
                $this->db->escapeSimple($separator)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );

        if ($qres["code"] !== "OK") {
            return false;
        }
        if ($return_type === 'array') {
            return explode($separator, $qres["result"]);
        }
        return $qres["result"];
    }

    /**
     * Teste si l'utilisateur connecté appartient au groupe indiqué en paramètre
     * ou s'il a le goupe bypass.
     *
     * @param  string  $groupe Code du groupe : ADS / CTX / CU / RU / ERP.
     * @return boolean         vrai si utilisateur appartient au groupe fourni
     */
    public function is_user_in_group($groupe) {
        if (isset($_SESSION['groupe']) === true
            && (array_key_exists($groupe, $_SESSION['groupe']) === true
                || array_key_exists("bypass", $_SESSION['groupe']) === true)) {
            return true;
        }
        return false;
    }

    /**
     * CONDITION - can_user_access_dossiers_confidentiels_from_groupe
     *
     * Permet de savoir si le type de dossier d'autorisation du dossier courant est
     * considéré comme confidentiel ou si l'utilisateur a le groupe bypass.
     *
     * @param string $groupe Code du groupe : ADS / CTX / CU / RU / ERP.
     * @return boolean true si l'utilisateur à accès aux dossiers confidentiels du groupe
     * passé en paramètre, sinon false.
     *
     */
    public function can_user_access_dossiers_confidentiels_from_groupe($groupe) {
        if ((isset($_SESSION['groupe'][$groupe]['confidentiel']) === true
            AND $_SESSION['groupe'][$groupe]['confidentiel'] === true)
            || array_key_exists("bypass", $_SESSION['groupe']) === true) {
            return true;
        }
        return false;
    }

    public function starts_with($haystack, $needle) {
         $length = strlen($needle);
         return (substr($haystack, 0, $length) === $needle);
    }

    public function ends_with($haystack, $needle) {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
        return (substr($haystack, -$length) === $needle);
    }

     /**
      * Récupère le type définit dans la base de données des champs d'une table
      * entière ou d'un champs si celui-ci est précisé.
      *
      * Liste des types BDD :
      * - int4
      * - varchar
      * - bool
      * - numeric
      * - text
      *
      * @param string $table  Nom de la table.
      * @param string $column Nom de la colonne (facultatif).
      *
      * @return array
      */
    public function get_type_from_db($table, $column = null) {

        $qres = $this->get_all_results_from_db_query(
            sprintf('
                SELECT 
                    column_name,
                    udt_name
                FROM 
                    information_schema.columns
                WHERE 
                    table_schema = \'%1$s\' 
                    AND 
                        table_name = \'%2$s\'
                    %3$s
                ORDER BY 
                    ordinal_position',
                str_replace('.', '', DB_PREFIXE),
                $table,
                // Si une colonne est précisé
                ($column !== null || $column !== '') ?
                    sprintf(" AND column_name = '%s' ", $column) :
                    ''
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        $list_type = array();
        foreach ($qres['result'] as $result) {
            $list_type[$result['column_name']] = $result['udt_name'];
        }

        // Retourne la liste des codes
        return $list_type;
    }


    /**
     * Cette méthode permet de récupérer le code de division correspondant
     * au dossier sur lequel on se trouve.
     *
     * Méthode identique à la méthode getDivisionFromDossier() de la classe
     * om_dbform à l'exception d'un cas de récupération du numéro de dossier par
     * la méthode getVal(). Cette exception permet d'utiliser cette méthode dans
     * les scripts instanciant seulement la classe utils tel que les *.inc.php.
     *
     * @param string $dossier Identifiant du dossier d'instruction.
     *
     * @return string Code de la division du dossier en cours
     */
    public function get_division_from_dossier_without_inst($dossier = null) {

        // Cette méthode peut être appelée plusieurs fois lors d'une requête.
        // Pour éviter de refaire le traitement de recherche de la division
        // alors on vérifie si nous ne l'avons pas déjà calculé.
        if (isset($this->_division_from_dossier) === true
            && $this->_division_from_dossier !== null) {
            // Log
            $this->addToLog(__METHOD__."() : retour de la valeur déjà calculée - '".$this->_division_from_dossier."'", EXTRA_VERBOSE_MODE);
            // On retourne la valeur déjà calculée
            return $this->_division_from_dossier;
        }

        // Récupère le paramétre retourformulaire présent dans l'URL
        $retourformulaire = $this->getParameter("retourformulaire");
        // Récupère le paramétre idxformulaire présent dans l'URL
        $idxformulaire = $this->getParameter("idxformulaire");

        // Si le dossier n'est pas passé en paramètre de la méthode
        if ($dossier === null) {

            // La méthode de récupération du dossier diffère selon le contexte
            // du formulaire
            if ($retourformulaire === "dossier"
                || $this->contexte_dossier_instruction()) {

                // Récupère le numéro du dossier depuis le paramètre
                // idxformulaire présent dans l'URL
                $dossier = $idxformulaire;
            }
            //
            if ($retourformulaire === "lot") {
                $inst_lot = $this->get_inst__om_dbform(array(
                    "obj" => "lot",
                    "idx" => $idxformulaire,
                ));
                $dossier = $inst_lot->getVal("dossier");
            }
        }

        // À cette étape si le dossier n'est toujours pas récupéré alors la
        // division ne pourra pas être récupérée
        if ($dossier === null) {
            //
            return null;
        }

        $inst_dossier = $this->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $dossier,
        ));
        $this->_division_from_dossier  = $inst_dossier->getVal("division");

        //
        return $this->_division_from_dossier;

    }

    /**
     *
     */
    function setDefaultValues() {
        $this->addHTMLHeadCss(
            array(
                "../app/lib/chosen/chosen.min.css",
            ),
            21
        );
        $this->addHTMLHeadJs(
            array(
                "../app/lib/chosen/chosen.jquery.min.js",
            ),
            21
        );

        $this->addHTMLHeadCss(
            array(
                "../app/lib/gridjs/mermaid.min.css",
            ),
            22
        );
        $this->addHTMLHeadJs(
            array(
                "../app/lib/gridjs/gridjs.min.js",
            ),
            22
        );
    }


    /**
     * Permet de définir la configuration des liens du footer.
     *
     * @return void
     */
    protected function set_config__footer() {
        $footer = array();
        // Documentation du site
        $footer[] = array(
            "title" => __("Documentation"),
            "description" => __("Acceder a l'espace documentation de l'application"),
            "href" => "http://docs.openmairie.org/?project=openads&version=6.2&format=html&path=manuel_utilisateur",
            "target" => "_blank",
            "class" => "footer-documentation",
        );

        // Portail openMairie
        $footer[] = array(
            "title" => __("openMairie.org"),
            "description" => __("Site officiel du projet openMairie"),
            "href" => "http://www.openmairie.org/catalogue/openads",
            "target" => "_blank",
            "class" => "footer-openmairie",
        );
        //
        $this->config__footer = $footer;
    }

    /**
     * Surcharge - set_config__menu().
     *
     * @return void
     */
    protected function set_config__menu() {
        //
        $menu = array();

        // {{{ Rubrique AUTORISATION
        //
        $rubrik = array(
            "title" => __("Autorisation"),
            "class" => "autorisation",
            "right" => "menu_autorisation"
        );
        //
        $links = array();

        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_autorisation",
            "class" => "dossier_autorisation",
            "title" => _("Dossiers d'autorisation"),
            "right" => array("dossier_autorisation", "dossier_autorisation_tab", ),
            "open" => array("index.php|dossier_autorisation[module=tab]", "index.php|dossier_autorisation[module=form]", ),
        );

        // Lien vers les dossiers d'autorisations qui ont une demande d'avis
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_autorisation_avis",
            "class" => "dossier_autorisation",
            "title" => _("Dossiers d'autorisation"),
            "right" => array(
                "dossier_autorisation_avis",
                "dossier_autorisation_avis_tab",
            ),
            "open" => array("index.php|dossier_autorisation_avis[module=tab]", "index.php|dossier_autorisation[module=form]", ),
        );

        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}

        // {{{ Rubrique GUICHET UNIQUE
        //
        $rubrik = array(
            "title" => _("Guichet Unique"),
            "class" => "guichet_unique",
            "right" => "menu_guichet_unique",
        );
        //
        $links = array();
        //
        $links[] = array(
            "href" => OM_ROUTE_DASHBOARD,
            "class" => "tableau-de-bord",
            "title" => _("tableau de bord"),
            "right" => "menu_guichet_unique_dashboard",
            "open" => array("index.php|[module=dashboard]",),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("nouvelle demande"),
            "right" => array(
                "demande",
                "demande_nouveau_dossier_ajouter",
                "demande_dossier_encours_ajouter", "demande_dossier_encours_tab",
                "demande_autre_dossier_ajouter", "demande_autre_dossier_tab",
                "demande_consulter","demande_tab",
            ),
        );
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "demande",
                "demande_dossier_encours_ajouter",
                "demande_dossier_encours_ajouter", "demande_dossier_encours_tab",
            ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=demande_nouveau_dossier&amp;action=0&amp;advs_id=&amp;tricol=&amp;valide=&amp;retour=tab&amp;new=",
            "class" => "nouveau-dossier",
            "title" => _("nouveau dossier"),
            "right" => array(
                "demande",
                "demande_nouveau_dossier_ajouter",
            ),
            "open" => array("index.php|demande_nouveau_dossier[module=form]",),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=demande_dossier_encours",
            "class" => "dossier-existant",
            "title" => _("dossier en cours"),
            "right" => array(
                "demande",
                "demande_dossier_encours_ajouter",
                "demande_dossier_encours_tab",
            ),
            "open" => array("index.php|demande_dossier_encours[module=tab]", "index.php|demande_dossier_encours[module=form]"),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=demande_autre_dossier",
            "class" => "autre-dossier",
            "title" => _("autre dossier"),
            "right" => array(
                "demande",
                "demande_autre_dossier_ajouter",
                "demande_autre_dossier_tab",
            ),
            "open" => array("index.php|demande_autre_dossier[module=tab]", "index.php|demande_autre_dossier[module=form]"),
        );
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "demande",
                "demande_consulter",
                "demande_tab"
            ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=demande",
            "class" => "pdf",
            "title" => _("recepisse"),
            "right" => array(
                "demande",
                "demande_consulter",
                "demande_tab"
            ),
            "open" => array("index.php|demande[module=tab]","index.php|demande[module=form]"),
        );
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "petitionnaire_frequent",
                "petitionnaire_frequent_consulter",
                "petitionnaire_frequent_tab"
            ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=petitionnaire_frequent",
            "class" => "petitionnaire_frequent",
            "title" => _("petitionnaire_frequent"),
            "right" => array(
                "petitionnaire_frequent",
                "petitionnaire_frequent_consulter",
                "petitionnaire_frequent_tab"
            ),
            "open" => array("index.php|petitionnaire_frequent[module=tab]","index.php|petitionnaire_frequent[module=form]"),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("affichage reglementaire"),
            "right" => array(
                "affichage_reglementaire_registre",
                "affichage_reglementaire_attestation",
            ),
        );
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "affichage_reglementaire_registre",
                "affichage_reglementaire_attestation",
            ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=demande_affichage_reglementaire_registre&action=110&idx=0",
            "class" => "affichage_reglementaire_registre",
            "title" => _("registre"),
            "right" => array(
                "affichage_reglementaire_registre",
            ),
            "open" => array("index.php|demande_affichage_reglementaire_registre[module=tab]", "index.php|demande_affichage_reglementaire_registre[module=form]"),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=demande_affichage_reglementaire_attestation&action=120&idx=0",
            "class" => "affichage_reglementaire_attestation",
            "title" => _("attestation"),
            "right" => array(
                "affichage_reglementaire_attestation",
            ),
            "open" => array("index.php|demande_affichage_reglementaire_attestation[module=tab]", "index.php|demande_affichage_reglementaire_attestation[module=form]"),
        );
        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}

        // {{{ Rubrique QUALIFICATION
        //
        $rubrik = array(
            "title" => _("Qualification"),
            "class" => "qualification",
            "right" => "qualification_menu",
        );
        //
        $links = array();
        //
        $links[] = array(
            "href" => OM_ROUTE_DASHBOARD,
            "class" => "tableau-de-bord",
            "title" => _("tableau de bord"),
            "right" => "menu_qualification_dashboard",
            "open" => array("index.php|[module=dashboard]",),
        );

        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_qualifier_qualificateur",
            "class" => "dossier_qualifier_qualificateur",
            "title" => _("dossiers a qualifier"),
            "right" => array(
                "dossier_qualifier_qualificateur",
                "dossier_qualifier_qualificateur_tab",
            ),
            "open" => array("index.php|dossier_qualifier_qualificateur[module=tab]", "index.php|dossier_instruction[module=form]", ),
        );

        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}

        // {{{ Rubrique INSTRUCTION
        //
        $rubrik = array(
            "title" => _("instruction"),
            "class" => "instruction",
            "right" => "menu_instruction",
        );
        //
        $links = array();
        //
        $links[] = array(
            "href" => OM_ROUTE_DASHBOARD,
            "class" => "tableau-de-bord",
            "title" => _("tableau de bord"),
            "right" => "menu_instruction_dashboard",
            "open" => array("index.php|[module=dashboard]",),
        );
        // Catégorie DOSSIERS D'INSTRUCTION
        $links[] = array(
            "class" => "category",
            "title" => _("dossiers d'instruction"),
            "right" => array(
                "dossier_instruction_mes_encours", "dossier_instruction_mes_encours_tab",
                "dossier_instruction_tous_encours", "dossier_instruction_tous_encours_tab",
                "dossier_instruction_mes_clotures", "dossier_instruction_mes_clotures_tab",
                "dossier_instruction_tous_clotures", "dossier_instruction_tous_clotures_tab",
                "dossier_instruction", "dossier_instruction_tab",
                "PC_modificatif", "PC_modificatif_tab", 
            ),
        );
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "dossier_instruction_mes_encours", "dossier_instruction_mes_encours_tab",
                "dossier_instruction_tous_encours", "dossier_instruction_tous_encours_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_instruction_mes_encours",
            "class" => "dossier_instruction_mes_encours",
            "title" => _("mes encours"),
            "right" => array("dossier_instruction_mes_encours", "dossier_instruction_mes_encours_tab", ),
            "open" => array("index.php|dossier_instruction_mes_encours[module=tab]", "index.php|dossier_instruction_mes_encours[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_instruction_tous_encours",
            "class" => "dossier_instruction_tous_encours",
            "title" => _("tous les encours"),
            "right" => array("dossier_instruction_tous_encours", "dossier_instruction_tous_encours_tab", ),
            "open" => array("index.php|dossier_instruction_tous_encours[module=tab]", "index.php|dossier_instruction_tous_encours[module=form]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "dossier_instruction_mes_clotures", "dossier_instruction_mes_clotures_tab",
                "dossier_instruction_tous_clotures", "dossier_instruction_tous_clotures_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_instruction_mes_clotures",
            "class" => "dossier_instruction_mes_clotures",
            "title" => _("mes clotures"),
            "right" => array("dossier_instruction_mes_clotures", "dossier_instruction_mes_clotures_tab", ),
            "open" => array("index.php|dossier_instruction_mes_clotures[module=tab]", "index.php|dossier_instruction_mes_clotures[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_instruction_tous_clotures",
            "class" => "dossier_instruction_tous_clotures",
            "title" => _("tous les clotures"),
            "right" => array("dossier_instruction_tous_clotures", "dossier_instruction_tous_clotures_tab", ),
            "open" => array("index.php|dossier_instruction_tous_clotures[module=tab]", "index.php|dossier_instruction_tous_clotures[module=form]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "dossier_instruction", "dossier_instruction_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_instruction",
            "class" => "dossier_instruction_recherche",
            "title" => _("recherche"),
            "right" => array("dossier_instruction", "dossier_instruction_tab", ),
            "open" => array("index.php|dossier_instruction[module=tab]", "index.php|dossier_instruction[module=form]", ),
        );

        // Catégorier Qualification
        $links[] = array(
            "class" => "category",
            "title" => _("qualification"),
            "right" => array("dossier_qualifier", "architecte_frequent",),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array("dossier_qualifier", "architecte_frequent", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_qualifier",
            "class" => "dossier_qualifier",
            "title" => _("dossiers a qualifier"),
            "right" => array("dossier_qualifier", "dossier_qualifier_tab", ),
            "open" => array("index.php|dossier_qualifier[module=tab]", "index.php|dossier_qualifier[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=architecte_frequent",
            "class" => "architecte_frequent",
            "title" => _("architecte_frequent"),
            "right" => array("architecte_frequent", "architecte_frequent_tab", ),
            "open" => array("index.php|architecte_frequent[module=tab]", "index.php|architecte_frequent[module=form]", ),
        );
        // Catégorie CONSULTATIONS
        $links[] = array(
            "class" => "category",
            "title" => _("consultations"),
            "right" => array(
                "consultation",
                "consultation_mes_retours",
                "consultation_retours_ma_division",
                "consultation_tous_retours",
            ),
        );
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "consultation",
                "consultation_mes_retours",
                "consultation_retours_ma_division",
                "consultation_tous_retours",
            ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=consultation_mes_retours",
            "class" => "consultation_mes_retours",
            "title" => _("Mes retours"),
            "right" => array(
                "consultation",
                "consultation_mes_retours",
                "consultation_mes_retours_tab",
            ),
            "open" => array("index.php|consultation_mes_retours[module=tab]", "index.php|consultation_mes_retours[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=consultation_retours_ma_division",
            "class" => "consultation_retours_ma_division",
            "title" => _("Retours de ma division"),
            "right" => array(
                "consultation",
                "consultation_retours_ma_division",
                "consultation_retours_ma_division_tab",
            ),
            "open" => array("index.php|consultation_retours_ma_division[module=tab]", "index.php|consultation_retours_ma_division[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=consultation_tous_retours",
            "class" => "consultation_tous_retours",
            "title" => _("Tous les retours"),
            "right" => array(
                "consultation_tous_retours",
                "consultation_tous_retours_tab",
            ),
            "open" => array("index.php|consultation_tous_retours[module=tab]", "index.php|consultation_tous_retours[module=form]", ),
        );
        // Catégorie MESSAGES
        $links[] = array(
            "class" => "category",
            "title" => _("Messages"),
            "right" => array(
                "messages",
                "messages_mes_retours",
                "messages_retours_ma_division",
                "messages_tous_retours",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "messages",
                "messages_mes_retours",
                "messages_retours_ma_division",
                "messages_tous_retours",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=messages_mes_retours",
            "class" => "messages_mes_retours",
            "title" => _("Mes messages"),
            "right" => array(
                "messages",
                "messages_mes_retours",
                "messages_mes_retours_tab",
            ),
            "open" => array("index.php|messages_mes_retours[module=tab]", "index.php|messages_mes_retours[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=messages_retours_ma_division",
            "class" => "messages_retours_ma_division",
            "title" => _("Messages de ma division"),
            "right" => array(
                "messages",
                "messages_retours_ma_division",
                "messages_retours_ma_division_tab",
            ),
            "open" => array("index.php|messages_retours_ma_division[module=tab]", "index.php|messages_retours_ma_division[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=messages_tous_retours",
            "class" => "messages_tous_retours",
            "title" => _("Tous les messages"),
            "right" => array(
                "messages",
                "messages_tous_retours",
                "messages_tous_retours_tab",
            ),
            "open" => array("index.php|messages_tous_retours[module=tab]", "index.php|messages_tous_retours[module=form]", ),
        );
        // Catégorie COMMISSIONS
        $links[] = array(
            "class" => "category",
            "title" => _("commissions"),
            "right" => array(
                "commission_mes_retours",
                "commission_mes_retours_tab",
                "commission_retours_ma_division",
                "commission_retours_ma_division_tab",
                "commission_tous_retours",
                "commission_tous_retours_tab",
            ),
        );
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "commission_mes_retours",
                "commission_mes_retours_tab",
                "commission_retours_ma_division",
                "commission_retours_ma_division_tab",
                "commission_tous_retours",
                "commission_tous_retours_tab",
            ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=commission_mes_retours",
            "class" => "commission_mes_retours",
            "title" => _("Mes retours"),
            "right" => array(
                "commission_mes_retours",
                "commission_mes_retours_tab",
            ),
            "open" => array("index.php|commission_mes_retours[module=tab]", "index.php|commission_mes_retours[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=commission_retours_ma_division",
            "class" => "commission_retours_ma_division",
            "title" => _("Retours de ma division"),
            "right" => array(
                "commission_retours_ma_division",
                "commission_retours_ma_division_tab",
            ),
            "open" => array("index.php|commission_retours_ma_division[module=tab]", "index.php|commission_retours_ma_division[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=commission_tous_retours",
            "class" => "commission_tous_retours",
            "title" => _("Tous les retours"),
            "right" => array(
                "commission_tous_retours",
                "commission_tous_retours_tab",
            ),
            "open" => array("index.php|commission_tous_retours[module=tab]", "index.php|commission_tous_retours[module=form]", ),
        );

        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}

        // {{{ Rubrique Contentieux
        //
        $rubrik = array(
            "title" => _("Contentieux"),
            "class" => "contentieux",
            "right" => "menu_contentieux",
        );
        //
        $links = array();
        //
        $links[] = array(
            "href" => OM_ROUTE_DASHBOARD,
            "class" => "tableau-de-bord",
            "title" => _("tableau de bord"),
            "right" => "menu_contentieux_dashboard",
            "open" => array("index.php|[module=dashboard]", "index.php|dossier_contentieux_contradictoire[module=tab]", "index.php|dossier_contentieux_ait[module=tab]", "index.php|dossier_contentieux_audience[module=tab]", "index.php|dossier_contentieux_clotures[module=tab]", "index.php|dossier_contentieux_inaffectes[module=tab]", "index.php|dossier_contentieux_alerte_visite[module=tab]", "index.php|dossier_contentieux_alerte_parquet[module=tab]", ),
        );
        // Catégorie Nouvelle demande
        $links[] = array(
            "class" => "category",
            "title" => _("Nouvelle demande"),
            "right" => array(
                "demande_nouveau_dossier_contentieux_ajouter",
            ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=demande_nouveau_dossier_contentieux&amp;action=0&amp;advs_id=&amp;tricol=&amp;valide=&amp;retour=tab&amp;new=",
            "class" => "nouveau-dossier",
            "title" => _("nouveau dossier"),
            "right" => array(
                "demande_nouveau_dossier_contentieux_ajouter",
            ),
            "open" => array("index.php|demande_nouveau_dossier_contentieux[module=form]",),
        );
        // Catégorie Recours
        $links[] = array(
            "class" => "category",
            "title" => _("Recours"),
            "right" => array(
                "dossier_contentieux_mes_recours", "dossier_contentieux_mes_recours_tab", 
                "dossier_contentieux_tous_recours", "dossier_contentieux_tous_recours_tab", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_contentieux_mes_recours",
            "class" => "dossier_contentieux_mes_recours",
            "title" => _("Mes recours"),
            "right" => array("dossier_contentieux_mes_recours", "dossier_contentieux_mes_recours_tab", ),
            "open" => array("index.php|dossier_contentieux_mes_recours[module=tab]", "index.php|dossier_contentieux_mes_recours[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_contentieux_tous_recours",
            "class" => "dossier_contentieux_tous_recours",
            "title" => _("Tous les recours"),
            "right" => array("dossier_contentieux_tous_recours", "dossier_contentieux_tous_recours_tab", ),
            "open" => array("index.php|dossier_contentieux_tous_recours[module=tab]", "index.php|dossier_contentieux_tous_recours[module=form]", ),
        );
        // Catégorie Infractions
        $links[] = array(
            "class" => "category",
            "title" => _("Infractions"),
            "right" => array(
                "dossier_contentieux_mes_infractions", "dossier_contentieux_mes_infractions_tab", 
                "dossier_contentieux_toutes_infractions", "dossier_contentieux_toutes_infractions_tab", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_contentieux_mes_infractions",
            "class" => "dossier_contentieux_mes_infractions",
            "title" => _("Mes infractions"),
            "right" => array("dossier_contentieux_mes_infractions", "dossier_contentieux_mes_infractions_tab", ),
            "open" => array("index.php|dossier_contentieux_mes_infractions[module=tab]", "index.php|dossier_contentieux_mes_infractions[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_contentieux_toutes_infractions",
            "class" => "dossier_contentieux_toutes_infractions",
            "title" => _("Toutes les infractions"),
            "right" => array("dossier_contentieux_toutes_infractions", "dossier_contentieux_toutes_infractions_tab", ),
            "open" => array("index.php|dossier_contentieux_toutes_infractions[module=tab]", "index.php|dossier_contentieux_toutes_infractions[module=form]", ),
        );
        // Catégorie MESSAGES
        $links[] = array(
            "class" => "category",
            "title" => _("Messages"),
            "right" => array(
                "messages_contentieux",
                "messages_contentieux_mes_retours",
                "messages_contentieux_retours_ma_division",
                "messages_contentieux_tous_retours",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "messages_contentieux",
                "messages_contentieux_mes_retours",
                "messages_contentieux_retours_ma_division",
                "messages_contentieux_tous_retours",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=messages_contentieux_mes_retours",
            "class" => "messages_contentieux_mes_retours",
            "title" => _("Mes messages"),
            "right" => array(
                "messages_contentieux",
                "messages_contentieux_mes_retours",
                "messages_contentieux_mes_retours_tab",
            ),
            "open" => array("index.php|messages_contentieux_mes_retours[module=tab]", "index.php|messages_contentieux_mes_retours[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=messages_contentieux_retours_ma_division",
            "class" => "messages_contentieux_retours_ma_division",
            "title" => _("Messages de ma division"),
            "right" => array(
                "messages_contentieux",
                "messages_contentieux_retours_ma_division",
                "messages_contentieux_retours_ma_division_tab",
            ),
            "open" => array("index.php|messages_contentieux_retours_ma_division[module=tab]", "index.php|messages_contentieux_retours_ma_division[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=messages_contentieux_tous_retours",
            "class" => "messages_contentieux_tous_retours",
            "title" => _("Tous les messages"),
            "right" => array(
                "messages_contentieux",
                "messages_contentieux_tous_retours",
                "messages_contentieux_tous_retours_tab",
            ),
            "open" => array("index.php|messages_contentieux_tous_retours[module=tab]", "index.php|messages_contentieux_tous_retours[module=form]", ),
        );


        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}

        // {{{ Rubrique SUIVI
        //
        $rubrik = array(
            "title" => _("Suivi"),
            "class" => "suivi",
            "right" => "menu_suivi",
        );
        //
        $links = array();
        //
        $links[] = array(
            "href" => OM_ROUTE_DASHBOARD,
            "class" => "tableau-de-bord",
            "title" => _("tableau de bord"),
            "right" => "menu_suivi_dashboard",
            "open" => array("index.php|[module=dashboard]",),
        );
        $links[] = array(
            "class" => "category",
            "title" => _("suivi des pieces"),
            "right" => array(
                "instruction_suivi_retours_de_consultation", "instruction_suivi_mise_a_jour_des_dates",
                "instruction_suivi_envoi_lettre_rar", "instruction_suivi_bordereaux",
                "instruction_suivi_retours_de_consultation_consulter", "instruction_suivi_mise_a_jour_des_dates_consulter",
                "instruction_suivi_envoi_lettre_rar_consulter", "instruction_suivi_bordereaux_consulter",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "instruction_suivi_retours_de_consultation", "instruction_suivi_mise_a_jour_des_dates",
                "instruction_suivi_envoi_lettre_rar", "instruction_suivi_bordereaux",
                "instruction_suivi_retours_de_consultation_consulter", "instruction_suivi_mise_a_jour_des_dates_consulter",
                "instruction_suivi_envoi_lettre_rar_consulter", "instruction_suivi_bordereaux_consulter",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "instruction_suivi_mise_a_jour_des_dates", "instruction_suivi_mise_a_jour_des_dates_consulter", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=instruction_suivi_mise_a_jour_des_dates&action=170&idx=0",
            "class" => "suivi_mise_a_jour_des_dates",
            "title" => _("Mise a jour des dates"),
            "right" => array("instruction_suivi_mise_a_jour_des_dates", "instruction_suivi_mise_a_jour_des_dates_consulter", ),
            "open" => array("index.php|instruction_suivi_mise_a_jour_des_dates[module=tab]", "index.php|instruction_suivi_mise_a_jour_des_dates[module=form]"),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "instruction_suivi_envoi_lettre_rar", "instruction_suivi_envoi_lettre_rar_consulter", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=instruction_suivi_envoi_lettre_rar&action=160&idx=0",
            "class" => "envoi_lettre_rar",
            "title" => _("envoi lettre AR"),
            "right" => array("instruction_suivi_envoi_lettre_rar", "instruction_suivi_envoi_lettre_rar_consulter", ),
            "open" => array("index.php|instruction_suivi_envoi_lettre_rar[module=tab]", "index.php|instruction_suivi_envoi_lettre_rar[module=form]"),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "instruction_suivi_bordereaux", "instruction_suivi_bordereaux_consulter", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=instruction_suivi_bordereaux&action=150&idx=0",
            "class" => "bordereaux",
            "title" => _("Bordereaux"),
            "right" => array("instruction_suivi_bordereaux", "instruction_suivi_bordereaux_consulter", ),
            "open" => array("index.php|instruction_suivi_bordereaux[module=tab]", "index.php|instruction_suivi_bordereaux[module=form]"),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=bordereau_envoi_maire&action=190&idx=0",
            "class" => "bordereau_envoi_maire",
            "title" => _("Bordereau d'envoi au maire"),
            "right" => array("instruction_bordereau_envoi_maire","bordereau_envoi_maire"),
            "open" => array("index.php|bordereau_envoi_maire[module=form]",),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("Demandes d'avis"),
            "right" => array(
                "consultation_suivi_mise_a_jour_des_dates", 
                "consultation_suivi_retours_de_consultation",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=consultation&idx=0&action=110",
            "class" => "demandes_avis_mise_a_jour_des_dates",
            "title" => _("Mise a jour des dates"),
            "right" => array("consultation_suivi_mise_a_jour_des_dates", ),
            "open" => array("index.php|consultation[module=form][action=110]"),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=consultation&idx=0&action=120",
            "class" => "consultation-retour",
            "title" => _("retours de consultation"),
            "right" => array("consultation_suivi_retours_de_consultation", ),
            "open" => array("index.php|consultation[module=form][action=120]", "index.php|consultation[module=form][action=100]", ),
        );
        // Catégorie COMMISSIONS
        $links[] = array(
            "class" => "category",
            "title" => _("commissions"),
            "right" => array(
                "commission",
                "commission_tab",
                "commission_demandes_passage",
                "commission_demandes_passage_tab",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "commission",
                "commission_tab",
                "commission_demandes_passage",
                "commission_demandes_passage_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=commission",
            "class" => "commissions",
            "title" => _("gestion"),
            "right" => array(
                "commission",
            ),
            "open" => array("index.php|commission[module=tab]", "index.php|commission[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=commission_demandes_passage",
            "class" => "commissions-demande-passage",
            "title" => _("demandes"),
            "right" => array(
                "commission",
                "commission_demandes_passage",
            ),
            "open" => array("index.php|commission_demandes_passage[module=tab]", "index.php|commission_demandes_passage[module=form]", ),
        );
        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}

        // {{{ Rubrique DEMANDES D'AVIS
        //
        $rubrik = array(
            "title" => _("Demandes d'avis"),
            "class" => "demande_avis",
            "right" => "menu_demande_avis",
        );
        //
        $links = array();
        //
        $links[] = array(
            "href" => OM_ROUTE_DASHBOARD,
            "class" => "tableau-de-bord",
            "title" => _("tableau de bord"),
            "right" => "menu_demande_avis_dashboard",
            "open" => array("index.php|[module=dashboard]",),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "demande_avis_encours", "demande_avis_encours_tab",
                "demande_avis_passee", "demande_avis_passee_tab",
                "demande_avis", "demande_avis_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=demande_avis_encours",
            "class" => "demande_avis_encours",
            "title" => _("Demandes en cours"),
            "right" => array("demande_avis_encours", "demande_avis_encours_tab", ),
            "open" => array("index.php|demande_avis_encours[module=tab]", "index.php|demande_avis_encours[module=form]", ),
        );

        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=demande_avis_passee",
            "class" => "demande_avis_passee",
            "title" => _("Demandes passees"),
            "right" => array("demande_avis_passee", "demande_avis_passee_tab", ),
            "open" => array("index.php|demande_avis_passee[module=tab]", "index.php|demande_avis_passee[module=form]", ),
        );

        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=demande_avis",
            "class" => "demande_avis",
            "title" => _("Exports"),
            "right" => array("demande_avis", "demande_avis_tab", ),
            "open" => array("index.php|demande_avis[module=tab]", "index.php|demande_avis[module=form]", ),
        );

        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}


        // {{{ Rubrique NUMERISATION
        // Condition d'affichage de la rubrique
        if (isset($_SESSION['collectivite']) === true
            && $this->is_option_suivi_numerisation_enabled() === true) {
            //
            $rubrik = array(
                "title" => __("numerisation"),
                "class" => "numerisation",
            );
            //
            $links = array();
            //
            // --->
            $links[] = array(
                    "class" => "category",
                    "title" => __("traitement d'un lot"),
                    "right" => array("num_dossier", "num_dossier_recuperation",
                            "num_bordereau", "num_bordereau_tab", ) ,
            );
            //
            $links[] = array(
                    "title" => "<hr/>",
                    "right" => array("num_dossier_recuperation",
                            "num_bordereau", "num_bordereau_tab", ) ,
            );
            //
            $links[] = array(
                    "href" => OM_ROUTE_FORM."&obj=num_dossier_recuperation&idx=0&action=4",
                    "class" => "num_dossier_recuperation",
                    "title" => __("récupération du suivi des dossiers"),
                    "right" => array( "num_dossier_recuperation", ) ,
                    "open" => array( "index.php|num_dossier_recuperation[module=form]", ),
            );
            //
            $links[] = array(
                    "title" => "<hr/>",
                    "right" => array( "num_bordereau", "num_bordereau_tab", ) ,
            );
            //
            $links[] = array(
                    "href" => OM_ROUTE_TAB."&obj=num_bordereau",
                    "class" => "num_bordereau",
                    "title" => __("tous les bordereaux"),
                    "right" => array( "num_bordereau", "num_bordereau_tab", ),
                    "open" => array("index.php|num_bordereau[module=tab]", "index.php|num_bordereau[module=form]", ),
            );
            
            //
            // --->
            $links[] = array(
                    "class" => "category",
                    "title" => __("suivi dossier"),
                    "right" => array("num_dossier_recuperation",
                            "num_dossier", "num_dossier_tab",
                            "num_dossier_a_attribuer", "num_dossier_a_attribuer_tab",
                            "num_dossier_a_numeriser", "num_dossier_a_numeriser_tab",
                            "num_dossier_traite", "num_dossier_traite_tab",
                    ) ,
            );
            //
            $links[] = array(
                    "title" => "<hr/>",
                    "right" => array("num_dossier_recuperation",
                            "num_dossier", "num_dossier_tab",
                            "num_dossier_a_attribuer", "num_dossier_a_attribuer_tab",
                            "num_dossier_a_numeriser", "num_dossier_a_numeriser_tab",
                            "num_dossier_traite", "num_dossier_traite_tab",
                    ) ,
            );
            //
            $links[] = array(
                    "href" => OM_ROUTE_TAB."&obj=num_dossier_a_attribuer",
                    "class" => "num_dossier_a_attribuer",
                    "title" => __("num_dossier_a_attribuer"),
                    "right" => array("num_dossier", "num_dossier_a_attribuer", "num_dossier_a_attribuer_tab",),
                    "open" => array("index.php|num_dossier_a_attribuer[module=tab]","index.php|num_dossier_a_attribuer[module=form]", ),
            );
            //
            $links[] = array(
                    "href" => OM_ROUTE_TAB."&obj=num_dossier_a_numeriser",
                    "class" => "num_dossier_a_numeriser",
                    "title" => __("num_dossier_a_numeriser"),
                    "right" => array("num_dossier", "num_dossier_a_numeriser", "num_dossier_a_numeriser_tab",),
                    "open" => array("index.php|num_dossier_a_numeriser[module=tab]","index.php|num_dossier_a_numeriser[module=form]", ),
            );
            //
            $links[] = array(
                    "href" => OM_ROUTE_TAB."&obj=num_dossier_traite",
                    "class" => "num_dossier_traite",
                    "title" => __("num_dossier_traite"),
                    "right" => array("num_dossier", "num_dossier_traite", "num_dossier_traite_tab",),
                    "open" => array("index.php|num_dossier_traite[module=tab]","index.php|num_dossier_traite[module=form]", ),
            );
            //
            $links[] = array(
                    "title" => "<hr/>",
                    "right" => array( "num_dossier", "num_dossier_tab",) ,
            );
            //
            $links[] = array(
                    "href" => OM_ROUTE_TAB."&obj=num_dossier",
                    "class" => "num_dossier",
                    "title" => __("tous les dossiers"),
                    "right" => array("num_dossier", "num_dossier_tab",),
                    "open" => array("index.php|num_dossier[module=tab]", "index.php|num_dossier[module=form]", ),
            );
            
            //
            $rubrik['links'] = $links;
            //
            $menu["menu-rubrik-numerisation"] = $rubrik;
            // }}}
        }


        // Commentaire de la rubrique EXPORT qui n'est pas prévue d'être opérationnelle
        // dans cette version
        // {{{ Rubrique EXPORT
        //
        $rubrik = array(
           "title" => _("export / import"),
           "class" => "edition",
           "right" => "menu_export",
        );
        //
        $links = array();

        //
        $links[] = array(
           "href" => "".OM_ROUTE_FORM."&obj=sitadel&action=6&idx=0",
           "class" => "sitadel",
           "title" => _("export sitadel"),
           "right" => "export_sitadel",
           "open" => "index.php|sitadel[module=form]",
        );
        //
        $links[] = array(
           "href" => "../app/versement_archives.php",
           "class" => "versement_archives",
           "title" => _("versement aux archives"),
           "right" => "versement_archives",
           "open" => "versement_archives.php|",
        );
        //
        $links[] = array(
           "href" => "../app/reqmo_pilot.php",
           "class" => "reqmo",
           "title" => _("statistiques a la demande"),
           "right" => "reqmo_pilot",
           "open" => "reqmo_pilot.php|",
        );
        //
        $links[] = array(
            "href" => OM_ROUTE_MODULE_REQMO,
            "class" => "reqmo",
            "title" => __("requetes memorisees"),
            "right" => "reqmo",
            "open" => array(
                "reqmo.php|",
                "index.php|[module=reqmo]",
            ),
        );
        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}


        // {{{ Rubrique PARAMETRAGE
        //
        $rubrik = array(
            "title" => _("parametrage dossiers"),
            "class" => "parametrage-dossier",
            "right" => "menu_parametrage",
        );
        //
        $links = array();
        //
        $links[] = array(
            "class" => "category",
            "title" => _("dossiers"),
            "right" => array(
                "dossier_autorisation_type", "dossier_autorisation_type_tab",
                "dossier_autorisation_type_detaille",
                "dossier_autorisation_type_detaille_tab", "dossier_instruction_type",
                "dossier_instruction_type_tab", "cerfa", "cerfa_tab",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "cerfa", "cerfa_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=cerfa",
            "class" => "cerfa",
            "title" => _("cerfa"),
            "right" => array("cerfa", "cerfa_tab", ),
            "open" => array("index.php|cerfa[module=tab]", "index.php|cerfa[module=form]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "dossier_autorisation_type", "dossier_autorisation_type_tab",
                "dossier_autorisation_type_detaille",
                "dossier_autorisation_type_detaille_tab", "dossier_instruction_type",
                "dossier_instruction_type_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_autorisation_type",
            "class" => "dossier_autorisation_type",
            "title" => _("type DA"),
            "right" => array("dossier_autorisation_type", "dossier_autorisation_type_tab", ),
            "open" => array("index.php|dossier_autorisation_type[module=tab]", "index.php|dossier_autorisation_type[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_autorisation_type_detaille",
            "class" => "dossier_autorisation_type_detaille",
            "title" => _("type DA detaille"),
            "right" => array("dossier_autorisation_type_detaille", "dossier_autorisation_type_detaille_tab", ),
            "open" => array("index.php|dossier_autorisation_type_detaille[module=tab]", "index.php|dossier_autorisation_type_detaille[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=dossier_instruction_type",
            "class" => "dossier_instruction_type",
            "title" => _("type DI"),
            "right" => array("dossier_instruction_type", "dossier_instruction_type_tab", ),
            "open" => array("index.php|dossier_instruction_type[module=tab]", "index.php|dossier_instruction_type[module=form]", ),
        );
        // Famille et Nature de travaux
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "famille_travaux", "famille_travaux_tab",
                "nature_travaux", "nature_travaux_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=famille_travaux",
            "class" => "famille_travaux",
            "title" => __("Famille des travaux"),
            "right" => array("famille_travaux", "famille_travaux_tab", ),
            "open" => array(
                "index.php|famille_travaux[module=tab]",
                "index.php|famille_travaux[module=form][action=0]",
                "index.php|famille_travaux[module=form][action=1]",
                "index.php|famille_travaux[module=form][action=2]",
                "index.php|famille_travaux[module=form][action=3]",
                ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=nature_travaux",
            "class" => "nature_travaux",
            "title" => __("Nature des travaux"),
            "right" => array("nature_travaux", "nature_travaux_tab", ),
            "open" => array(
                "index.php|nature_travaux[module=tab]",
                "index.php|nature_travaux[module=form][action=0]",
                "index.php|nature_travaux[module=form][action=1]",
                "index.php|nature_travaux[module=form][action=2]",
                "index.php|nature_travaux[module=form][action=3]",
                ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "contrainte", "contrainte_tab",
                "contrainte_souscategorie", "contrainte_souscategorie_tab",
                "contrainte_categorie", "contrainte_categorie_tab"
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=contrainte",
            "class" => "contrainte",
            "title" => _("contrainte"),
            "right" => array("contrainte", "contrainte_tab", ),
            "open" => array(
                "index.php|contrainte[module=tab]",
                "index.php|contrainte[module=form][action=0]",
                "index.php|contrainte[module=form][action=1]",
                "index.php|contrainte[module=form][action=2]",
                "index.php|contrainte[module=form][action=3]",
                ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("demandes"),
            "right" => array(
                "demande_type",
                "demande_type_tab", "demande_nature", "demande_nature_tab",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "demande_type",
                "demande_type_tab", "demande_nature", "demande_nature_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=demande_nature",
            "class" => "demande_nature",
            "title" => _("nature"),
            "right" => array("demande_nature", "demande_nature_tab", ),
            "open" => array("index.php|demande_nature[module=tab]", "index.php|demande_nature[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=demande_type",
            "class" => "demande_type",
            "title" => _("type"),
            "right" => array("demande_type", "demande_type_tab",),
            "open" => array("index.php|demande_type[module=tab]", "index.php|demande_type[module=form]", ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("workflows"),
            "right" => array(
                "workflows",
                "action", "action_tab", "etat",
                "etat_tab", "evenement", "evenement_tab", "bible", "bible_tab", "avis_decision", 
                "avis_decision_tab", "avis_consultation", "avis_consultation_tab",
                "avis_decision_type", "avis_decision_type_tab",
                "avis_decision_nature", "avis_decision_nature_tab",
            ),
        );

        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "workflows",
                "action", "action_tab", "etat",
                "etat_tab", "evenement", "evenement_tab", "bible", "bible_tab", "avis_decision",
                "avis_decision_tab", "avis_consultation", "avis_consultation_tab",
                "avis_decision_type", "avis_decision_type_tab",
                "avis_decision_nature", "avis_decision_nature_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "../app/workflows.php",
            "class" => "workflows",
            "title" => _("workflows"),
            "right" => array("workflows", ),
            "open" => array("workflows.php|", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "evenement", "evenement_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=evenement",
            "class" => "evenement",
            "title" => _("evenement"),
            "right" => array("evenement", "evenement_tab", ),
            "open" => array("index.php|evenement[module=tab]", "index.php|evenement[module=form]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "action", "action_tab", "etat",
                "etat_tab", "avis_decision",
                "avis_decision_tab", "avis_decision_type", "avis_decision_type_tab",
                "avis_decision_nature", "avis_decision_nature_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=etat",
            "class" => "workflow-etat",
            "title" => _("etat"),
            "right" => array("etat", "etat_tab", ),
            "open" => array("index.php|etat[module=tab]", "index.php|etat[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=avis_decision",
            "class" => "avis_decision",
            "title" => _("avis decision"),
            "right" => array("avis_decision", "avis_decision_tab", ),
            "open" => array("index.php|avis_decision[module=tab]", "index.php|avis_decision[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=avis_decision_type",
            "class" => "avis_decision_type",
            "title" => __("avis_decision_type"),
            "right" => array("avis_decision_type", "avis_decision_type_tab", ),
            "open" => array("index.php|avis_decision_type[module=tab]", "index.php|avis_decision_type[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=avis_decision_nature",
            "class" => "avis_decision_nature",
            "title" => __("avis_decision_nature"),
            "right" => array("avis_decision_nature", "avis_decision_nature_tab", ),
            "open" => array("index.php|avis_decision_nature[module=tab]", "index.php|avis_decision_nature[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=action",
            "class" => "action",
            "title" => _("action"),
            "right" => array("action", "action_tab", ),
            "open" => array("index.php|action[module=tab]", "index.php|action[module=form]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "bible", "bible_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=bible",
            "class" => "bible",
            "title" => _("bible"),
            "right" => array("bible", "bible_tab", ),
            "open" => array("index.php|bible[module=tab]", "index.php|bible[module=form]", ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("editions"),
            "right" => array(
                "om_etat", "om_etat_tab", "om_sousetat", "om_sousetat_tab",
                "om_lettretype", "om_lettretype_tab", "om_requete", "om_requete_tab",
                "om_logo", "om_logo_tab",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "om_etat", "om_etat_tab", "om_lettretype", "om_lettretype_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_etat",
            "class" => "om_etat",
            "title" => _("om_etat"),
            "right" => array("om_etat", "om_etat_tab", ),
            "open" => array("index.php|om_etat[module=tab]", "index.php|om_etat[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_lettretype",
            "class" => "om_lettretype",
            "title" => _("om_lettretype"),
            "right" => array("om_lettretype", "om_lettretype_tab"),
            "open" => array("index.php|om_lettretype[module=tab]", "index.php|om_lettretype[module=form]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "om_logo", "om_logo_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_logo",
            "class" => "om_logo",
            "title" => _("om_logo"),
            "right" => array("om_logo", "om_logo_tab", ),
            "open" => array("index.php|om_logo[module=tab]", "index.php|om_logo[module=form]", ),
        );
        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}

        // {{{ Rubrique PARAMETRAGE
        //
        $rubrik = array(
            "title" => _("parametrage"),
            "class" => "parametrage",
            "right" => "menu_parametrage",
        );
        //
        $links = array();
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=civilite",
            "class" => "civilite",
            "title" => _("civilite"),
            "right" => array("civilite", "civilite_tab", ),
            "open" => array("index.php|civilite[module=tab]", "index.php|civilite[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=arrondissement",
            "class" => "arrondissement",
            "title" => _("arrondissement"),
            "right" => array("arrondissement", "arrondissement_tab", ),
            "open" => array("index.php|arrondissement[module=tab]", "index.php|arrondissement[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=quartier",
            "class" => "quartier",
            "title" => _("quartier"),
            "right" => array("quartier", "quartier_tab", ),
            "open" => array("index.php|quartier[module=tab]", "index.php|quartier[module=form]", ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("Organisation"),
            "right" => array(
                "direction", "direction_tab", "division", "division_tab", "instructeur_qualite",
                "instructeur_qualite_tab", "instructeur", "instructeur_tab", "groupe",
                "groupe_tab", "genre", "genre_tab", "signataire_habilitation",
                "signataire_habilitation_tab", "signataire_arrete", "signataire_arrete_tab",
                "taxe_amenagement_tab", "taxe_amenagement", 
            ),
        );
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "direction", "direction_tab", "division", "division_tab", "instructeur_qualite",
                "instructeur_qualite_tab", "instructeur", "instructeur_tab", "groupe",
                "groupe_tab", "genre", "genre_tab", "signataire_arrete", "signataire_arrete_tab",
                "taxe_amenagement_tab", "taxe_amenagement", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=genre",
            "class" => "genre",
            "title" => _("genre"),
            "right" => array("genre", "genre_tab", ),
            "open" => array("index.php|genre[module=tab]", "index.php|genre[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=groupe",
            "class" => "groupe",
            "title" => _("groupe"),
            "right" => array("groupe", "groupe_tab", ),
            "open" => array("index.php|groupe[module=tab]", "index.php|groupe[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=direction",
            "class" => "direction",
            "title" => _("direction"),
            "right" => array("direction", "direction_tab", ),
            "open" => array("index.php|direction[module=tab]", "index.php|direction[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=division",
            "class" => "division",
            "title" => _("division"),
            "right" => array("division", "division_tab", ),
            "open" => array("index.php|division[module=tab]", "index.php|division[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=instructeur_qualite",
            "class" => "instructeur_qualite",
            "title" => _("instructeur_qualite"),
            "right" => array("instructeur_qualite", "instructeur_qualite_tab", ),
            "open" => array("index.php|instructeur_qualite[module=tab]", "index.php|instructeur_qualite[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=instructeur",
            "class" => "instructeur",
            "title" => _("instructeur"),
            "right" => array("instructeur", "instructeur_tab", ),
            "open" => array("index.php|instructeur[module=tab]", "index.php|instructeur[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=signataire_habilitation",
            "class" => "signataire_habilitation",
            "title" => _("signataire habilitation"),
            "right" => array("signataire_habilitation", "signataire_habilitation", ),
            "open" => array("index.php|signataire_habilitation[module=tab]", "index.php|signataire_habilitation[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=signataire_arrete",
            "class" => "signataire_arrete",
            "title" => _("signataire arrete"),
            "right" => array("signataire_arrete", "signataire_arrete", ),
            "open" => array("index.php|signataire_arrete[module=tab]", "index.php|signataire_arrete[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=taxe_amenagement",
            "class" => "taxe_amenagement",
            "title" => _("taxes"),
            "right" => array("taxe_amenagement", "taxe_amenagement_tab", ),
            "open" => array("index.php|taxe_amenagement[module=tab]", "index.php|taxe_amenagement[module=form]", ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("gestion des commissions"),
            "right" => array(
                "commission_type", "commission_type_tab",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "commission_type", "commission_type_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=commission_type",
            "class" => "commission-type",
            "title" => _("commission_type"),
            "right" => array("commission_type", "commission_type_tab", ),
            "open" => array("index.php|commission_type[module=tab]", "index.php|commission_type[module=form]", ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("gestion des consultations"),
            "right" => array(
                "avis_consultation", "avis_consultation_tab", "service", "service_tab",
                "service_categorie", "service_categorie_tab",
                "lien_service_service_categorie", "lien_service_service_categorie_tab",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "avis_consultation", "avis_consultation_tab", "service", "service_tab",
                "service_categorie", "service_categorie_tab",
                "lien_service_service_categorie", "lien_service_service_categorie_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=avis_consultation",
            "class" => "avis_consultation",
            "title" => _("avis consultation"),
            "right" => array("avis_consultation", "avis_consultation_tab", ),
            "open" => array("index.php|avis_consultation[module=tab]", "index.php|avis_consultation[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=service",
            "class" => "service",
            "title" => _("service"),
            "right" => array("service", "service_tab", ),
            "open" => array("index.php|service[module=tab]", "index.php|service[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=service_categorie",
            "class" => "service_categorie",
            "title" => _("thematique des services"),
            "right" => array("service_categorie", "service_categorie_tab", ),
            "open" => array("index.php|service_categorie[module=tab]", "index.php|service_categorie[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=categorie_tiers_consulte",
            "class" => "categorie_tiers_consulte",
            "title" => __("catégorie des tiers consultés"),
            "right" => array("categorie_tiers_consulte", "categorie_tiers_consulte_tab", ),
            "open" => array("index.php|categorie_tiers_consulte[module=tab]", "index.php|categorie_tiers_consulte[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=tiers_consulte",
            "class" => "tiers_consulte",
            "title" => __("tiers"),
            "right" => array("tiers_consulte", "tiers_consulte_tab", ),
            "open" => array("index.php|tiers_consulte[module=tab]", "index.php|tiers_consulte[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=type_habilitation_tiers_consulte",
            "class" => "type_habilitation_tiers_consulte",
            "title" => __("type d'habilitation des tiers consultés"),
            "right" => array("type_habilitation_tiers_consulte", "type_habilitation_tiers_consulte_tab", ),
            "open" => array("index.php|type_habilitation_tiers_consulte[module=tab]", "index.php|type_habilitation_tiers_consulte[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=habilitation_tiers_consulte",
            "class" => "habilitation_tiers_consulte",
            "title" => __("habilitation des tiers consultés"),
            "right" => array("habilitation_tiers_consulte", "habilitation_tiers_consulte_tab", ),
            "open" => array("index.php|habilitation_tiers_consulte[module=tab]", "index.php|habilitation_tiers_consulte[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=specialite_tiers_consulte",
            "class" => "specialite_tiers_consulte",
            "title" => __("spécialité des tiers consultés"),
            "right" => array("specialite_tiers_consulte", "specialite_tiers_consulte_tab", ),
            "open" => array("index.php|specialite_tiers_consulte[module=tab]", "index.php|specialite_tiers_consulte[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=motif_consultation",
            "class" => "motif_consultation",
            "title" => __("motif de consultation"),
            "right" => array("motif_consultation", "motif_consultation_tab", ),
            "open" => array("index.php|motif_consultation[module=tab]", "index.php|motif_consultation[module=form]", ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("Gestion des dossiers"),
            "right" => array(
                "dossier_autorisation_type", "dossier_autorisation_type_tab",
                "dossier_autorisation_type_detaille",
                "dossier_autorisation_type_detaille_tab", "dossier_instruction_type",
                "dossier_instruction_type_tab",
                "autorite_competente", "autorite_competente_tab",
                "affectation_automatique", "affectation_automatique_tab",
                "pec_metier", "pec_metier_tab", 
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "dossier_autorisation_type", "dossier_autorisation_type_tab",
                "dossier_autorisation_type_detaille",
                "dossier_autorisation_type_detaille_tab", "dossier_instruction_type",
                "dossier_instruction_type_tab",
                "autorite_competente", "autorite_competente_tab",
                "affectation_automatique", "affectation_automatique_tab",
                "pec_metier", "pec_metier_tab", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=etat_dossier_autorisation",
            "class" => "etat_dossier_autorisation",
            "title" => _("etat dossiers autorisations"),
            "right" => array("etat_dossier_autorisation", "etat_dossier_autorisation_tab", ),
            "open" => array("index.php|etat_dossier_autorisation[module=tab]", "index.php|etat_dossier_autorisation[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=affectation_automatique",
            "class" => "affectation_automatique",
            "title" => _("affectation automatique"),
            "right" => array("affectation_automatique", "affectation_automatique_tab", ),
            "open" => array("index.php|affectation_automatique[module=tab]", "index.php|affectation_automatique[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=autorite_competente",
            "class" => "autorite_competente",
            "title" => _("autorite")." "._("competente"),
            "right" => array("autorite_competente", "autorite_competente_tab", ),
            "open" => array("index.php|autorite_competente[module=tab]", "index.php|autorite_competente[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=phase",
            "class" => "phase",
            "title" => _("phase"),
            "right" => array("phase", "phase_tab", ),
            "open" => array("index.php|phase[module=tab]", "index.php|phase[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=pec_metier",
            "class" => "pec_metier",
            "title" => _("pec_metier"),
            "right" => array("pec_metier", "pec_metier_tab", ),
            "open" => array("index.php|pec_metier[module=tab]", "index.php|pec_metier[module=form]", ),
        );

        //Gestion des pièces
        $links[] = array(
            "class" => "category",
            "title" => _("Gestion des pièces"),
            "right" => array(
                "document_numerise_type_categorie", "document_numerise_type_categorie_tab",
                "document_numerise_type",
                "document_numerise_type_tab", "document_numerise_traitement_metadonnees",
                "document_numerise_traitement_metadonnees_executer", 
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "document_numerise_type_categorie", "document_numerise_type_categorie_tab",
                "document_numerise_type",
                "document_numerise_type_tab", "document_numerise_traitement_metadonnees",
                "document_numerise_traitement_metadonnees_executer", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=document_numerise_type_categorie",
            "class" => "document_numerise_type_categorie",
            "title" => _("Catégorie des pièces"),
            "right" => array(
                "document_numerise_type_categorie",
                "document_numerise_type_categorie_tab",
                ),
            "open" => array(
                "index.php|document_numerise_type_categorie[module=tab]",
                "index.php|document_numerise_type_categorie[module=form]",
                ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=document_numerise_type",
            "class" => "document_numerise_type",
            "title" => _("Type des pièces"),
            "right" => array(
                "document_numerise_type",
                "document_numerise_type_tab",
                ),
            "open" => array(
                "index.php|document_numerise_type[module=tab]",
                "index.php|document_numerise_type[module=form][action=0]",
                "index.php|document_numerise_type[module=form][action=1]",
                "index.php|document_numerise_type[module=form][action=2]",
                "index.php|document_numerise_type[module=form][action=3]",
                ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=lien_document_n_type_d_i_t",
            "class" => "lien_document_n_type_d_i_t",
            "title" => _("Nomenclature des pièces"),
            "right" => array(
                "lien_document_n_type_d_i_t",
                "lien_document_n_type_d_i_t_tab",
                ),
            "open" => array(
                "index.php|lien_document_n_type_d_i_t[module=tab]",
                "index.php|lien_document_n_type_d_i_t[module=form][action=0]",
                "index.php|lien_document_n_type_d_i_t[module=form][action=1]",
                "index.php|lien_document_n_type_d_i_t[module=form][action=2]",
                "index.php|lien_document_n_type_d_i_t[module=form][action=3]",
                ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=document_numerise_traitement_metadonnees&action=100&idx=0",
            "class" => "document_numerise_traitement_metadonnees",
            "title" => _("Mise à jour des métadonnées"),
            "description" => _("Mettre à jour les métadonnées de tous les documents numérisés."),
            "right" => array(
                "document_numerise_traitement_metadonnees",
                "document_numerise_traitement_metadonnees_executer",
                ),
            "open" => array("index.php|document_numerise_traitement_metadonnees[module=form]", ),
        );

        // Gestion des contentieux
        $links[] = array(
            "class" => "category",
            "title" => _("Gestion des contentieux"),
            "right" => array(
                "objet_recours", "objet_recours_tab", "moyen_souleve", "moyen_souleve_tab",
                "moyen_retenu_juge", "moyen_retenu_juge_tab", 
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "objet_recours", "objet_recours_tab", "moyen_souleve", "moyen_souleve_tab",
                "moyen_retenu_juge", "moyen_retenu_juge_tab", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=objet_recours",
            "class" => "objet_recours",
            "title" => _("objet_recours"),
            "right" => array(
                "objet_recours", "objet_recours_tab",
            ),
            "open" => array(
                "index.php|objet_recours[module=tab]", "index.php|objet_recours[module=form]",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=moyen_souleve",
            "class" => "moyen_souleve",
            "title" => _("moyen_souleve"),
            "right" => array(
                "moyen_souleve", "moyen_souleve_tab",
            ),
            "open" => array(
                "index.php|moyen_souleve[module=tab]", "index.php|moyen_souleve[module=form]",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=moyen_retenu_juge",
            "class" => "moyen_retenu_juge",
            "title" => _("moyen_retenu_juge"),
            "right" => array(
                "moyen_retenu_juge", "moyen_retenu_juge_tab",
            ),
            "open" => array(
                "index.php|moyen_retenu_juge[module=tab]", "index.php|moyen_retenu_juge[module=form]",
            ),
        );

        //
        $links[] = array(
            "class" => "category",
            "title" => _("géolocalisation"),
            "right" => array(
                "sig_groupe",
                "sig_sousgroupe",
                "sig_contrainte"
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=sig_couche",
            "class" => "sig_couche",
            "title" => _("Couches"),
            "right" => array("sig_contrainte", "sig_contrainte_tab","sig_couche", "sig_couche_tab", ),
            "open" => array("index.php|sig_couche[module=tab]", "index.php|sig_couche[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=sig_groupe",
            "class" => "sig_groupe",
            "title" => _("sig_groupe"),
            "right" => array(
                "sig_groupe", "sig_groupe_tab",
            ),
            "open" => array(
                "index.php|sig_groupe[module=tab]", "index.php|sig_groupe[module=form]",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=sig_sousgroupe",
            "class" => "sig_sousgroupe",
            "title" => _("sig_sousgroupe"),
            "right" => array(
                "sig_sousgroupe", "sig_sousgroupe_tab",
            ),
            "open" => array(
                "index.php|sig_sousgroupe[module=tab]", "index.php|sig_sousgroupe[module=form]",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=sig_contrainte",
            "class" => "sig_contrainte",
            "title" => _("sig_contrainte"),
            "right" => array(
                "sig_contrainte", "sig_contrainte_tab", "sig_attribut", "sig_attribut_tab"
            ),
            "open" => array(
                "index.php|sig_contrainte[module=tab]", "index.php|sig_contrainte[module=form]",
            ),
        );
        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        // }}}

        // {{{ Rubrique ADMINISTRATION
        //
        $rubrik = array(
            "title" => _("administration"),
            "class" => "administration",
            "right" => "menu_administration",
        );
        //
        $links = array();
        //
        // Renomme la collectivité en service
        $om_collectivite_title = __("om_collectivite");
        if (isset($_SESSION['collectivite']) === true
            && $this->is_option_renommer_collectivite_enabled() === true) {
            //
            $om_collectivite_title = __("service");
        }
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_collectivite",
            "class" => "collectivite",
            "title" => $om_collectivite_title,
            "right" => array("om_collectivite", "om_collectivite_tab", ),
            "open" => array("index.php|om_collectivite[module=tab]", "index.php|om_collectivite[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_parametre",
            "class" => "parametre",
            "title" => _("om_parametre"),
            "right" => array("om_parametre", "om_parametre_tab", ),
            "open" => array("index.php|om_parametre[module=tab]", "index.php|om_parametre[module=form]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array("commune", "commune_tab", )
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=commune",
            "title" => __("communes"),
            "right" => array("commune", "commune_tab"),
            "open" => array("index.php|commune[module=tab]", "index.php|commune[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=departement",
            "title" => __("départements"),
            "right" => array("departement", "departement_tab"),
            "open" => array("index.php|departement[module=tab]", "index.php|departement[module=form]")
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=region",
            "title" => __("régions"),
            "right" => array("region", "region_tab"),
            "open" => array("index.php|region[module=tab]", "index.php|region[module=form]")
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("gestion des utilisateurs"),
            "right" => array(
                "om_utilisateur", "om_utilisateur_tab", "om_profil", "om_profil_tab",
                "om_droit", "om_droit_tab", "directory",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "om_utilisateur", "om_utilisateur_tab", "om_profil", "om_profil_tab",
                "om_droit", "om_droit_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_profil",
            "class" => "profil",
            "title" => _("om_profil"),
            "right" => array("om_profil", "om_profil_tab", ),
            "open" => array("index.php|om_profil[module=tab]", "index.php|om_profil[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_droit",
            "class" => "droit",
            "title" => _("om_droit"),
            "right" => array("om_droit", "om_droit_tab", ),
            "open" => array("index.php|om_droit[module=tab]", "index.php|om_droit[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_utilisateur",
            "class" => "utilisateur",
            "title" => _("om_utilisateur"),
            "right" => array("om_utilisateur", "om_utilisateur_tab", ),
            "open" => array(
                "index.php|om_utilisateur[module=tab]",
                "index.php|om_utilisateur[module=form][action=0]",
                "index.php|om_utilisateur[module=form][action=1]",
                "index.php|om_utilisateur[module=form][action=2]",
                "index.php|om_utilisateur[module=form][action=3]",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array("om_utilisateur", "om_utilisateur_synchroniser", ),
            "parameters" => array("isDirectoryOptionEnabled" => true, ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=om_utilisateur&idx=0&action=11",
            "class" => "annuaire",
            "title" => _("annuaire"),
            "right" => array("om_utilisateur", "om_utilisateur_synchroniser", ),
            "open" => array("index.php|om_utilisateur[module=form][action=11]", ),
            "parameters" => array("isDirectoryOptionEnabled" => true, ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("tableaux de bord"),
            "right" => array(
                "om_widget", "om_widget_tab", "om_dashboard",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "om_widget", "om_widget_tab", "om_dashboard",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_widget",
            "class" => "om_widget",
            "title" => _("om_widget"),
            "right" => array("om_widget", "om_widget_tab", ),
            "open" => array("index.php|om_widget[module=tab]", "index.php|om_widget[module=form]", ),
        );
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=compteur",
            "class" => "compteur",
            "title" => __("Compteur & quota"),
            "right" => array("compteur", "compteur_tab", ),
            "open" => array("index.php|compteur[module=tab]", "index.php|compteur[module=form]", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=om_dashboard&amp;idx=0&amp;action=4",
            "class" => "om_dashboard",
            "title" => _("composition"),
            "right" => array("om_dashboard", ),
            "open" => array("index.php|om_dashboard[module=form][action=4]", ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("sig"),
            "right" => array(
                "om_sig_map", "om_sig_map_tab", "om_sig_flux", "om_sig_flux_tab", "om_sig_extent", "om_sig_extent_tab",
            ),
            "parameters" => array("option_localisation" => "sig_interne", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "om_sig_map", "om_sig_map_tab", "om_sig_flux", "om_sig_flux_tab", "om_sig_extent", "om_sig_extent_tab",
            ),
            "parameters" => array("option_localisation" => "sig_interne", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_sig_extent",
            "class" => "om_sig_extent",
            "title" => _("om_sig_extent"),
            "right" => array("om_sig_extent", "om_sig_extent_tab", ),
            "open" => array("index.php|om_sig_extent[module=tab]", "index.php|om_sig_extent[module=form]", ),
            "parameters" => array("option_localisation" => "sig_interne", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_sig_map",
            "class" => "om_sig_map",
            "title" => _("om_sig_map"),
            "right" => array("om_sig_map", "om_sig_map_tab", ),
            "open" => array("index.php|om_sig_map[module=tab]", "index.php|om_sig_map[module=form]", ),
            "parameters" => array("option_localisation" => "sig_interne", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_sig_flux",
            "class" => "om_sig_flux",
            "title" => _("om_sig_flux"),
            "right" => array("om_sig_flux", "om_sig_flux_tab", ),
            "open" => array("index.php|om_sig_flux[module=tab]", "index.php|om_sig_flux[module=form]", ),
            "parameters" => array("option_localisation" => "sig_interne", ),
        );
        //
        $links[] = array(
            "class" => "category",
            "title" => _("options avancees"),
            "right" => array("import", "gen", "om_requete", "om_requete_tab",
                             "om_sousetat", "om_sousetat_tab",),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "interface_referentiel_erp",
            ),
        );
        //
        $links[] = array(
            "href" => "../app/settings.php?controlpanel=interface_referentiel_erp",
            "class" => "interface_referentiel_erp",
            "title" => _("interface_referentiel_erp"),
            "right" => array("interface_referentiel_erp", ),
            "open" => array("settings.php|[controlpanel=interface_referentiel_erp]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array(
                "om_sousetat", "om_sousetat_tab",
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_sousetat",
            "class" => "om_sousetat",
            "title" => _("om_sousetat"),
            "right" => array("om_sousetat", "om_sousetat_tab", ),
            "open" => array("index.php|om_sousetat[module=tab]", "index.php|om_sousetat[module=form]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array("om_requete", "om_requete_tab", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=om_requete",
            "class" => "om_requete",
            "title" => _("om_requete"),
            "right" => array("om_requete", "om_requete_tab", ),
            "open" => array("index.php|om_requete[module=tab]", "index.php|om_requete[module=form]", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array("task", "task_tab", ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_TAB."&obj=task",
            "class" => "task",
            "title" => _("Moniteur Plat'AU"),
            "right" => array("task", "task_tab", ),
            "open" => array("index.php|task[module=tab]", "index.php|task[module=form]", ),
        );
        
        //Afficher le menu moniteur IDE'AU si l'option notification portal est activée. 
        if (isset($_SESSION['collectivite']) === true
            && $this->get_param_option_notification() === PORTAL)
        {
            $links[] = array(
                "href" => "".OM_ROUTE_TAB."&obj=task_portal",
                "class" => "task_portal",
                "title" => __("Moniteur iDE'AU"),
                "right" => array("task_portal", "task_portal_tab", ),
                "open" => array("index.php|task_portal[module=tab]", "index.php|task_portal[module=form]", ),
            );
        }
        
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array("import", ),
        );
        //
        $links[] = array(
            "href" => OM_ROUTE_MODULE_IMPORT,
            "class" => "import",
            "title" => __("Import"),
            "description" => __("Ce module permet l'intégration de données dans l'application depuis des fichiers CSV."),
            "right" => array("import", ),
            "open" => array(
                "import.php|",
                "index.php|[module=import]",
            ),
        );
        //
        $links[] = array(
            "href" => "../app/import_specific.php",
            "class" => "import_specific",
            "title" => _("Import specifique"),
            "right" => array("import", ),
            "open" => array("import_specific.php|", ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array("gen", ),
        );
        //
        $links[] = array(
            "title" => _("Generateur"),
            "href" => OM_ROUTE_MODULE_GEN,
            "class" => "generator",
            "right" => array("gen", ),
            "open" => array(
                "gen.php|","genauto.php|", "gensup.php|", "genfull.php|",
                "genetat.php|", "gensousetat.php|", "genlettretype.php|",
                "genimport.php|",
            ),
        );
        //
        $links[] = array(
            "title" => "<hr/>",
            "right" => array("contrainte", "contrainte_synchronisation"),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=contrainte&action=100&idx=0",
            "class" => "contrainte",
            "title" => _("synchronisation des contraintes"),
            "right" => array("contrainte", "contrainte_synchronisation", ),
            "open" => array("index.php|contrainte[module=form][action=100]", ),
            "parameters" => array(
                "option_sig" => "sig_externe", 
            ),
        );
        //
        $links[] = array(
            "href" => "".OM_ROUTE_FORM."&obj=dossier_instruction&action=126&idx=0",
            "class" => "geocoder",
            "title" => _("Géolocalisation des dossiers"),
            "right" => array("dossier_instruction_geocoder", ),
            "open" => array("index.php|dossier_instruction[module=form][action=126]", ),
            "parameters" => array(
                "option_sig" => "sig_externe", 
            ),
        );
        //
        $rubrik['links'] = $links;
        //
        $menu[] = $rubrik;
        $this->config__menu = $menu;
    }

    /**
     * Récupère tous les résultats d'une requête SQL.
     *
     * @param string $query Requête SQL
     * @param array $extras Tableau de paramètres :
     *        - force_return (bool) : Force le retour d'un boolean en cas d'erreur
     *        - origin (string) : Origine d'appel de la méthode
     *        - get_columns_name (bool) : Renvoie le nom des colonnes de la requête sous la forme d'un tableau
     *        - mode (string) : détermine la façon dont les lignes de résultats sont importés.
     *              Par défaut : DB_FETCHMODE_ASSOC
     *
     * @return array
     */
    function get_all_results_from_db_query(string $query, array $extras = array()) {
        $res = $this->db->query($query);
        $origin = __METHOD__;
        if (array_key_exists("origin", $extras) === true
            && is_string($extras["origin"]) === true) {
            //
            $origin = $extras["origin"];
        }
        $this->addToLog(
            $origin."(): #db->query(\"".$query."\");",
            VERBOSE_MODE
        );
        $result = array(
            'code' => '',
            'message' => '',
            'result' => array(),
            'row_count' => 0
        );
        $force_return = false;
        if (array_key_exists("force_return", $extras) === true
            && is_bool($extras["force_return"]) === true) {
            //
            $force_return = $extras["force_return"];
        }
        if ($this->isDatabaseError($res, $force_return) !== false) {
            $result['code'] = 'KO';
            $result['message'] = __("Erreur de base de donnees. Contactez votre administrateur.");
            return $result;
        }
        $result['code'] = 'OK';
        $mode = DB_FETCHMODE_ASSOC;
        if (array_key_exists("mode", $extras) === true) {
            $mode = $extras["mode"];
        }

        while ($row =& $res->fetchrow($mode)) {
            array_push($result['result'], $row);
        }

        // Récupération du nom des colonnes
        if (array_key_exists("get_columns_name", $extras) === true
            && $extras["get_columns_name"] === true) {

            $infos = $res->tableInfo();
            $result['columns_name'] = array();
            foreach($infos as $info) {
                $result['columns_name'][] = $info['name'];
            }
        }
        // Nombre de lignes retournées par la requête
        $result['row_count'] = $res->numRows();

        $res->free();
        return $result;
    }

    /**
     * Récupère un résultat d'une requête SQL.
     *
     * @param string $query Requête SQL
     * @param array $extras Tableau de paramètres :
     *        - force_return (bool) : Force le retour d'un boolean en cas d'erreur
     *        - origin (string) : Origine d'appel de la méthode
     *
     * @return array
     */
    function get_one_result_from_db_query(string $query, array $extras = array()) {
        $res = $this->db->getone($query);
        $origin = __METHOD__;
        if (array_key_exists("origin", $extras) === true
            && is_string($extras["origin"]) === true) {
            //
            $origin = $extras["origin"];
        }
        $this->addToLog(
            $origin."(): #db->getone(\"".$query."\");",
            VERBOSE_MODE
        );
        $result = array(
            "code" => "",
            "message" => "",
            "result" => array(),
        );
        $force_return = false;
        if (array_key_exists("force_return", $extras) === true
            && is_bool($extras["force_return"]) === true) {
            //
            $force_return = $extras["force_return"];
        }
        if ($this->isDatabaseError($res, $force_return) !== false) {
            $result["code"] = "KO";
            $result["message"] = __("Erreur de base de donnees. Contactez votre administrateur.");
            return $result;
        }
        $result["code"] = "OK";
        $result["result"] = $res;
        return $result;
    }

    /**
     * Exécute requête SQL.
     *
     * @param string $query Requête SQL
     * @param array $extras Tableau de paramètres :
     *        - force_return (bool) : Force le retour d'un boolean en cas d'erreur
     *        - origin (string) : Origine d'appel de la méthode
     *
     * @return array
     */
    function execute_db_query(string $query, array $extras = array()) {
        $res = $this->db->query($query);
        $origin = __METHOD__;
        if (array_key_exists("origin", $extras) === true
            && is_string($extras["origin"]) === true) {
            //
            $origin = $extras["origin"];
        }
        $this->addToLog(
            $origin."(): #db->query(\"".$query."\");",
            VERBOSE_MODE
        );
        $result = array(
            'code' => '',
            'message' => '',
            'result' => array(),
        );
        $force_return = false;
        if (array_key_exists("force_return", $extras) === true
            && is_bool($extras["force_return"]) === true) {
            //
            $force_return = $extras["force_return"];
        }

        if ($this->isDatabaseError($res, $force_return) !== false) {
            $result['code'] = 'KO';
            $result['message'] = __("Erreur de base de donnees. Contactez votre administrateur.");
            return $result;
        }
        $result['code'] = 'OK';
        return $result;
    }

    /**
     * Instanciation de la classe 'edition'.
     * (surcharge de la fonction pour ajouter la prise en compte
     * de la surcharge locale de la classe om_edition).
     *
     * @param array $args Arguments à passer au constructeur.
     * @return edition
     */
    function get_inst__om_edition($args = array()) {
        if (file_exists("../obj/om_edition.class.php")) {
            require_once "../obj/om_edition.class.php";
            $class_name = "om_edition";
        } else {
            require_once PATH_OPENMAIRIE."om_edition.class.php";
            $class_name = "edition";
        }
        return new $class_name();
    }

    /**
     * Instanciation de la classe 'reqmo'.
     * (surcharge de la fonction pour ajouter la prise en compte
     * de la surcharge locale de la classe om_edition).
     *
     * @param array $args Arguments à passer au constructeur.
     * @return edition
     */
    function get_inst__om_reqmo($args = array()) {
        if (file_exists("../obj/om_reqmo.class.php")) {
            require_once "../obj/om_reqmo.class.php";
            $class_name = "om_reqmo";
        } else {
            require_once PATH_OPENMAIRIE."om_reqmo.class.php";
            $class_name = "reqmo";
        }
        return new $class_name();
    }

    /**
     * Permet d'enregistrer un fichier dans la table 'storage'.
     *
     * @return mixed Identifiant du fichier dans la table storage ou false.
     */
    function store_file($filecontent, $filemetadata, $type, $info = null, $collectivite = null, $dossierFinal = false) {
        if ($collectivite === null) {
            $get_collectivite = $this->getCollectivite();
            $collectivite = $get_collectivite['om_collectivite_idx'];
        }
        $uid = $this->storage->create($filecontent, $filemetadata, "from_content", "storage.uid");
        if ($uid == 'OP_FAILURE') {
            return false;
        }
        $inst_storage = $this->get_inst__om_dbform(array(
            "obj" => "storage",
            "idx" => "]",
        ));
        $val = array(
            "storage" => '',
            "file" => "NEW",
            "creation_date" => date("Y-m-d"),
            "creation_time" => date("G:i:s"),
            "uid" => $uid,
            "filename" => $filemetadata["filename"],
            "size" => $filemetadata["size"],
            "mimetype" => $filemetadata["mimetype"],
            "type" => $type,
            "info" => $info,
            "om_collectivite" => $collectivite,
            "uid_dossier_final" => $dossierFinal
        );
        $ret = $inst_storage->ajouter($val);
        if ($ret !== true) {
            return false;
        }
        // Récupère l'identifiant dans le storage
        $id = $inst_storage->get_storage_id_by_uid($uid);
        //
        return $id;
    }

    /**
     * Surcharge de la fonction d'affichage pour ajouter
     * un détecteur de bloqueur de pub (cassant l'application).
     *
     * @return void
     */
    function displayHTMLFooter() {
        parent::displayHTMLFooter();
        if (in_array($this->flag, array("login_and_nohtml", "nohtml", "login", "logout", "anonym")) !== true) {
            $this->ad_blocker_detector();
        }
    }

    /**
     * "Fausse" surcharge de la méthode du même nom dans om_layout.
     * Ajoute la possibilité d'ajouter une class CSS à la balise legend.
     *
     * Cette methode permet d'ouvrir un fieldset
    */
    public function display_formulaire_debutFieldset($params) {
        // Ouverture du fieldset
        echo "      <fieldset";
        echo (isset($params["identifier"]) ? " id=\"".$params["identifier"]."\"" : "");
        echo " class=\"cadre ui-corner-all ui-widget-content ".$params["action2"]."\">\n";
        echo "        <legend class=\"ui-corner-all ui-widget-content ui-state-active ".$params["legend_class"]."\">";
        echo $params["action1"];
        echo "        </legend>\n";
        // Ouverture du conteneur interne du fieldset
        echo "        <div class=\"fieldsetContent\">\n";
    }

    /**
     * Affiche un bloc de code Javascript
     * responsable de détecter les bloqueurs de pub
     * et d'afficher un message le cas échéant.
     */
    protected function ad_blocker_detector() {

        printf(
            '<script type="text/javascript">
                var blocked = [];
                // jquery has not loaded
                if(typeof($) == "undefined" && typeof(jQuery) == "undefined") {
                    blocked.push("jquery");
                }
                // tinyMCE has not loaded
                if(typeof(tinyMCE) == "undefined") {
                    blocked.push("tinyMCE");
                }
                // locale has not loaded
                if(typeof(locale) == "undefined") {
                    blocked.push("locale");
                }
                // om_layout has not loaded
                if(typeof(om_initialize_content) == "undefined") {
                    blocked.push("om_layout");
                }
                // app script has not loaded
                if(typeof(app_script_t4Fv4a59uSU7MwpJ59Qp) == "undefined") {
                    blocked.push("app_script");
                }

                // something was blocked
                if(blocked.length > 0) {

                    // removing every node in the body
                    while(document.body.firstChild) { document.body.removeChild(document.body.firstChild); }

                    // creating the message (node) and its style
                    var msgNode = document.createElement("p");
                    msgNode.id = "adblocker-detected";
                    msgNode.style.position = "relative";
                    msgNode.style.width = "calc(100%% - 60px)";
                    msgNode.style.margin = "20px auto";
                    msgNode.style.padding = "20px";
                    msgNode.style.background = "#FEF8F6";
                    msgNode.style.color = "#cd0a0a";
                    msgNode.style.border = "1px solid #cd0a0a";
                    msgNode.style.borderRadius = "4px";
                    msgNode.style.gridColumns = "1 / -1";
                    msgNode.innerHTML = "%s";

                    // appending the message (node) to the body
                    document.body.insertBefore(msgNode, document.body.firstChild);
                }
            </script>',
            sprintf(
                '<span>%s</span><br/><br/><span>%s</span><br/><br/><span>%s</span>',
                __("Un bloqueur de publicité a été détecté, et ceci empêche l'application de fonctionner normalement."),
                __("Afin de rétablir le bon fonctionnement, il vous est nécessaire d'ajouter l'application à la liste blanche des applications autorisées (<small>pour cela, référez-vous à la documentation de votre extension bloqueuse de publicité</small>)."),
                __("<em>Pour information, ceci se produit parce que l'application se nomme openADS, or les bloqueurs de publicité ont tendance à bloquer tout ce qui contient la chaîne de caractères 'ads' (<small>publicité</small> en anglais) comme c'est le cas dans le nom open<strong>ADS</strong>.</em>")
            )
        );
    }

    /**
     * Récupère l'identifiant de l'enregistrement par rapport aux arguments.
     *
     * @param string $idx_name        Nom du champ de l'identifiant
     * @param string $table           Nom de la table
     * @param string $condition_field Nom du champ pour la condition
     * @param string $condition_value Valeur du champ de condition
     *
     * @return mixed Résultat de la requête ou null
     */
    public function get_idx_by_args(array $args) {
        $where2 = '';
        if (isset($args['condition2_field']) === true
            && isset($args['condition2_value']) === true
            && $args['condition2_field'] !== ''
            && $args['condition2_field'] !== null
            && $args['condition2_value'] !== ''
            && $args['condition2_value'] !== null) {
            //
            $where2 = sprintf(" AND %s = '%s'", $args['condition2_field'], $args['condition2_value']);
        }
        $where3 = '';
        if (isset($args['condition3_field']) === true
            && isset($args['condition3_value']) === true
            && $args['condition3_field'] !== ''
            && $args['condition3_field'] !== null
            && $args['condition3_value'] !== ''
            && $args['condition3_value'] !== null) {
            //
            $where3 = sprintf(" AND %s = '%s'", $args['condition3_field'], $args['condition3_value']);
        }
        $order = '';
        if (isset($args['order_field']) === true
            && isset($args['order_asc_desc']) === true
            && $args['order_field'] !== ''
            && $args['order_field'] !== null
            && $args['order_asc_desc'] !== ''
            && $args['order_asc_desc'] !== null) {
            //
            $order = sprintf(" ORDER BY %s %s ", $args['order_field'], $args['order_asc_desc']);
        }
        $qres = $this->get_one_result_from_db_query(
            sprintf(
                "SELECT
                    %s
                FROM
                    %s%s
                WHERE
                    %s = '%s'
                    %s
                    %s
                %s",
                $args['idx_name'],
                DB_PREFIXE,
                $args['table'],
                $args['condition_field'],
                $args['condition_value'],
                $where2,
                $where3,
                $order
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

    public function get_inst__by_other_idx(array $args) {
        // En cas de plusieurs résultat, instancie seulement le premier retourné
        $idx = $this->get_idx_by_args(array(
            'idx_name' => $args['obj'],
            'table' => $args['obj'],
            'condition_field' => $args['fk_field'],
            'condition_value' => $args['fk_idx'],
            'condition2_field' => isset($args['fk_field_2']) === true ? $args['fk_field_2'] : null,
            'condition2_value' => isset($args['fk_idx_2']) === true ? $args['fk_idx_2'] : null,
            'condition3_field' => isset($args['fk_field_3']) === true ? $args['fk_field_3'] : null,
            'condition3_value' => isset($args['fk_idx_3']) === true ? $args['fk_idx_3'] : null,
            'order_field' => isset($args['order_field']) === true ? $args['order_field'] : null,
            'order_asc_desc' => isset($args['order_asc_desc']) === true ? $args['order_asc_desc'] : null,
        ));
        $inst = $this->get_inst__om_dbform(array(
            'obj' => $args['obj'],
            'idx' => $idx,
        ));
        return $inst;
    }

    /**
     * Retourne l'objet demandé avec ses propriétés remplis à partir des données en base
     * ou 'null' si l'objet n'est pas trouvé en base de données.
     *
     * @param  string    $class  La classe de l'objet demandé
     * @param  string      $idx  L'identifiant de l'objet en base de donnée
     * @param    bool  $onlyone  Si vaut 'true', déclenche une exception s'il y a plus d'un résultat
     *
     * @return $mixed  L'objet ou null
     *
     * (à partir de PHP 7.1 on pourra utiliser le ReturnType ?object)
     */
    public function findObjectById(string $class, string $idx, bool $onlyone = true) {
        $obj = null;
        if (!empty($class) && !empty($idx)) {
            $qres = $this->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        COUNT(%2$s)
                    FROM
                        %1$s%2$s
                    WHERE
                        %2$s::CHARACTER VARYING = \'%3$s\'',
                    DB_PREFIXE,
                    $class,
                    $idx

                ),
                array(
                    "origin" => __METHOD__
                )
            );
            if ($qres["code"] !== "OK") {
                throw new RuntimeException("Failed database query (".$qres['message'].")");
            }
            $count = intval(strval($qres['result']));
            if ($count === 1) {
                $obj = $this->get_inst__om_dbform(array('obj' => $class, 'idx' => $idx));
            }
            elseif($count > 1 && $onlyone) {
                throw new RuntimeException("More than one result ($count) for '$class' ID '$idx'");
            }
        }
        $obj = $this->get_inst__om_dbform(array('obj' => $class, 'idx' => $idx));
        if ($obj->exists() !== true) {
            return null;
        }
        return $obj;
    }

    /**
     * Retourne l'objet demandé avec ses propriétés remplis à partir des données en base
     * ou 'null' si l'objet n'est pas trouvé en base de données.
     *
     * @param  string      class  La classe de l'objet demandé
     * @param  string  condition  La clause WHERE de la requête SQL qui va être effectuée
     * @param  string      order  (optionel) La clause ORDER BY de la requête SQL qui va être effectuée
     * @param  string       from  (optionel) La clause FROM de la requête SQL qui va être effectuée
     * @param  string    onlyone  (optionel) Si 'true': génère une exception si plus d'un résultat
     *
     * @return $mixed  L'objet ou null
     *
     * @throw RuntimeException
     *
     * (à partir de PHP 7.1 on pourra utiliser le ReturnType ?object)
     */
    public function findObjectByCondition(string $class, string $condition, string $order,
                                          string $from = null, bool $onlyone = true) {
        $obj = null;
        if (!empty($class)) {
            $class = $this->db->escapeSimple($class);
            $from = ! empty($from) ?
                $from :
                sprintf(' FROM %s%s', DB_PREFIXE, $class);
            $condition = ! empty($condition) ?
                " WHERE $condition" :
                '';
            $order = ! empty($order) ?
                " ORDER BY $order" :
                '';

            $sqlExist = sprintf(
                'SELECT
                    COUNT(%1$s)
                %2$s
                %3$s',
                $class,
                $from,
                $condition
            );
            $qres = $this->get_one_result_from_db_query(
                $sqlExist,
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
    
            if ($qres["code"] !== "OK") {
                throw new RuntimeException("Failed database query (".$qres['message'].")");
            }
            $count = intval(strval($qres['result']));
            if(empty($count)) {
                return null;
            }
            if($count > 1 && $onlyone) {
                $this->addToLog(__METHOD__."(): get_one_result_from_db_query(\"".$sqlExist."\");", DEBUG_MODE);
                throw new RuntimeException("More than one result ($count) for '$class'");
            }
            $sqlID = sprintf(
                'SELECT
                    %1$s
                %2$s
                %3$s
                LIMIT 1',
                $class,
                $from,
                $condition,
                $order
            );
            $qres = $this->get_one_result_from_db_query(
                $sqlID,
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($qres["code"] !== "OK") {
                throw new RuntimeException("Failed database query (".$qres['message'].")");
            }
            $idx = intval(strval($qres['result']));
            $obj = $this->get_inst__om_dbform(array('obj' => $class, 'idx' => $idx));
        }
        return $obj;
    }

    /**
     * Récupère la totalité des objets d'un type donné.
     * Si l'argument $sqlFilter est non-vide alors il sera utilisé pour filtrer les objets.
     * Si l'argument $sqlOrder est non-vide alors il sera utilisé pour ordonner les objets.
     *
     * Note: le code de cette méthode est largement inspiré de dbform::init_record_data().
     *
     * @return array|false
     */
    public function getAllObjects(string $type, string $sqlfilter = '', string $sqlOrder = '') {

        // objet "modèle" utilisé pour accéder aux variables nécessaires à la construction
        // de la requête SQL et aussi pour y stocker les infos communes à tous les objets de
        // ce type (ex: tailles des champs, etc.).
        $objectTemplate = $this->get_inst__om_dbform(array('obj' => $type));

        // construction de la requpete SQL (éventuellement avec un filtre)
        $sqlSelectedColumns = $objectTemplate->get_var_sql_forminc__champs();
        if (! empty($objectTemplate->_var_from_sql_forminc__champs)) {
            $sqlSelectedColumns = $objectTemplate->_var_from_sql_forminc__champs;
        }
        $sqlSelectColumns = implode(', ', $sqlSelectedColumns);
        $sqlSelectFrom = $objectTemplate->get_var_sql_forminc__tableSelect();
        if (! empty($objectTemplate->_var_from_sql_forminc__tableSelect)) {
            $sqlSelectFrom = $objectTemplate->_var_from_sql_forminc__tableSelect;
        }
        $sqlSelectWhere = '';
        if (! empty($sqlfilter)) {
            $sqlSelectWhere = "WHERE $sqlfilter";
        }
        $sqlSelectOrder = $objectTemplate->table." ASC";
        if (! empty($sqlOrder)) {
            $sqlSelectOrder = $sqlOrder;
        }
        $sql = sprintf('SELECT %s FROM %s %s ORDER BY %s',
            $sqlSelectColumns,
            $sqlSelectFrom,
            $sqlSelectWhere,
            $sqlSelectOrder);

        // exécution de la requête
        $this->addToLog(__METHOD__."() : sql query: $sql", VERBOSE_MODE);
        $res = $this->db->execute($this->db->prepare($sql));
        if ($this->isDatabaseError($res, true)) {
            $this->addToLog(
                __METHOD__."(): erreur SQL sur la table '".$objectTemplate->table."': ".
                    $res->getMessage(), DEBUG_MODE);
            return false;
        }

        // recuperation des informations sur la structure de la table
        // ??? compatibilite POSTGRESQL (len = -1, type vide, flags vide)
        $info = $res->tableInfo();

        // Recuperation des infos
        foreach ($info as $index => $item) {
            $objectTemplate->champs[$index] = $item['name'];
            $objectTemplate->longueurMax[$index] = $item['len'];
            $objectTemplate->type[$index] = $item['type'];
            $objectTemplate->flags[$index] = $item['flags'];
        }

        // création et remplissage des objets
        $allObjects = array();
        while ($row = $res->fetchRow()) {
            $object = new $type(null);
            foreach(array('champs', 'longueurMax', 'type', 'flags') as $key) {
                $object->$key = $objectTemplate->$key;
            }
            foreach ($row as $index => $item) {
                $object->val[$index] = $item;
            }
            $allObjects[] = $object;
        }

        return $allObjects;
    }

    /**
     * Cette méthode permet de transformer une chaine de caractère standard
     * en une chaine sans caractères spéciaux ni accents.
     *
     * NOTE: la convertion est de 1 caractère vers 1 caractères afin de permettre
     *       à la fonction 'sqlNormalizeSearchValue()' d'effectuer la même conversion.
     *
     * @param string $string La chaine de caractère à normaliser
     *
     * @return string La chaine de caractère normalisée
     */
    public function normalize_string($string = "") {
        //
        $invalid = array('Š'=>'S', 'š'=>'s', 'Đ'=>'D', 'đ'=>'d', 'Ž'=>'Z',
            'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c', 'À'=>'A', 'Á'=>'A',
            'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E',
            'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I',
            'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O',
            'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'S',
            'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a',
            'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e',  'ë'=>'e', 'ì'=>'i', 'í'=>'i',
            'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o',
            'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y',
            'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', "`" => "_",
            "„" => "_", "`" => "_", "´" => "_", "“" => "_", "”" => "_",
            "{" => "_", "}" => "_", "~" => "_", "–" => "-",
            "’" => "_",  "(" => "_",  ")" => "_", "/"=>"-", "'"=>"_",
        );
        $string = str_replace(array_keys($invalid), array_values($invalid), $string);
        $string = strtolower($string);
        return $string;
    }

    /**
     * Transforme une chaine en une suite d'instruction pSQL pour la normaliser.
     * En l'occurence cela supprimer les accents et la passe en casse minuscule.
     *
     * NOTE: la convertion est de 1 caractère vers 1 caractères afin de permettre
     *       à la fonction 'normalize_string()' d'effectuer la même conversion.
     *
     * @param string $value Chaîne recherchée à normaliser.
     *
     * @return string
     */
    public function sqlNormalizeSearchValue($value){
        $value = html_entity_decode($value, ENT_QUOTES);
        // échappement des caractères spéciaux
        $value = pg_escape_string($value);
        // encodage
        if (DBCHARSET != 'UTF8' and HTTPCHARSET == 'UTF-8') {
            $value = utf8_decode($value);
        }
        // normalisation des caractères
        $value = " TRANSLATE(LOWER(".
            $value."::varchar), ".
            "'ŠšĐđŽžČčĆćÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýþÿŔŕ`„´“”{}~–’()/''', ".
            "'SsDdZzCcCcAAAAAAACEEEEIIIINOOOOOOUUUUYBSaaaaaaaceeeeiiiionoooooouuuybyRr________-___-_') ";
        return $value;
    }

    /**
     * Retourne une valeur unique récupérée à partir d'une requête SQL "basique".
     *
     * Il faut fournir une (ou deux) valeur filtre qui va sélectionner la ligne à partir
     * de laquelle récupérer la valeur souhaitée.
     *
     * @param string $table         La table sur laquelle faire la requête
     * @param string $columnSelect  La colonne permettant de récupérer la valeur recherchée
     * @param string $columnWhere   La colonne à laquelle la valeur '$value' va être comparée
     * @param string $value         La valeur filtre qui permet de sélectionner une ligne
     * @param string $extraTable    Une table supplémentaire pour tester une seconde valeur
     * @param string $extraColumn   Une colonne supplémentaire pour tester une seconde valeur
     * @param string $extraValue    La seconde valeur 'filtre' pour mieux sélectionner une ligne
     * @param bool $normalizeColumn Si vaut 'true' alors on normalise la colonne '$columnWhere'
     * @param bool $normalizeValue  Si vaut 'true' alors on normalise la valeur '$value'
     */
    public function getSingleSqlValue(
            string $table, string $columnSelect, string $columnWhere, string $value,
            string $extraTable = null, string $extraColumn = null, string $extraValue = null,
            bool $normalizeColumn = true, bool $normalizeValue = true) {

        // colonnes utilisées pour la clause WHERE
        $columnNormalized = $columnWhere;
        if ($normalizeColumn) {
            $columnNormalized = $this->sqlNormalizeSearchValue($columnWhere);
        }
        $valueNormalized = $this->db->escapeSimple($value);
        if ($normalizeValue) {
            $valueNormalized = $this->db->escapeSimple(strtolower(
                $this->normalize_string($value)));
        }
        // valeur utilisée pour la clause WHERE
        if (ctype_digit($value)) {
            $columnNormalized = "$table.$table";
            $valueNormalized = intval($value);
        }

        // SQL de base
        $sql = sprintf("SELECT $columnSelect FROM ".DB_PREFIXE."$table WHERE %s = '%s'",
            $columnNormalized,
            $valueNormalized);

        // s'il y a une colonne supplémentaire à ajouter à la clause WHERE
        if (! empty($extraColumn)) {

            // si cette colonne provient d'une autre table, on ajoute cette autre table
            $tables = array($table);
            if (! empty($extraTable) && $extraTable != $table) {
                $tables[] = $extraTable;
            }

            // construit le SQL avec les deux colonnes dans la clause WHERE
            $columnsNormalized = array($columnNormalized, $extraColumn);
            $valuesNormalized = array($valueNormalized, $extraValue);
            $sql = sprintf("SELECT $columnSelect FROM %s WHERE %s",
                DB_PREFIXE.implode(', '.DB_PREFIXE, $tables),
                implode(' AND ', array_map(
                    function ($col, $val) {
                        return "$col = '$val'";
                    },
                    $columnsNormalized, $valuesNormalized)));
        }

        // exécute la requête en demandant en résultat une unique valeur
        $qres = $this->get_one_result_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );

        // vérifie les erreurs
        if ($qres["code"] !== "OK") {
            throw new RuntimeException(__("Erreur de base de données.").' '.
                sprintf(__("Détails: %s"), $qres["message"]));
        }
        // si la ligne n'a pas été trouvée
        if ($qres["result"] === null) {
            throw new InvalidArgumentException(__(
                "L'objet $table '$valueNormalized' n'existe pas."));
        }

        // renvoie la valeur trouvée
        return $qres["result"];
    }

    /**
     * Vérifie si la saisie du numéro complet respecte la numérotation
     * réglementaire d'un dossier d'urbanisme (code de l'urbanisme A423-1 à A423-4)
     * et renvoie les différents éléments constituant du numéro de dossier.
     *
     * Attention: cette fonction pourrait confondre un code entité avec un suffixe,
     *            c'est pourquoi il est nécessaire de supprimer tout code entité
     *            d'un numéro de dossier avant de le passer à cette fonction.
     *
     * @param  string $numero     identifiant du dossier
     * @param  bool   $espaces    si 'true' accepte les espaces, sinon non
     * @return array              ['di' => [...], 'da' => [...]] contenant les éléments
     */
    public function numerotation_urbanisme(string $numero, bool $espaces = false) {
        // Masques
        $blank = $espaces ? '\s' : '';
        $base = '(?P<type>[A-Z]{2,3})'.$blank.
                '(?P<departement>[0-9]{3}|02[AB])(?P<commune>[0-9]{3})'.$blank.
                '(?P<annee>[0-9]{2})'.$blank.
                '(?P<division>[A-Z0-9])(?P<numero>[0-9]{4})';
        $pattern_di = "/^$base(?P<suffixe>[A-Z]{1,5})?(?P<num_suffixe>[0-9]{1,2})?$/i";
        $pattern_da = "/^$base$/i";

        $result = array(
            "di" => array(),
            "da" => array(),
        );

        if (preg_match($pattern_di, $numero, $matches_di) === 1) {
            $result["di"] = $matches_di;
            $numero = $matches_di['type'].$matches_di['departement'].$matches_di['commune'].
                      $matches_di['annee'].$matches_di['division'].$matches_di['numero'];
        }
        if (preg_match($pattern_da, $numero, $matches_da) === 1) {
            $result["da"] = $matches_da;
        }

        return $result;
    }

    /**
     * Vérifie si un formulaire est ouvert dans le contexte d'un
     * dossier d'instruction. Pour cela vérifiesi le paramètre retourformulaire
     * prend une de ces valeurs :
     *  - dossier_instruction
     *  - dossier_instruction_mes_encours
     *  - dossier_instruction_tous_encours
     *  - dossier_instruction_mes_clotures
     *  - dossier_instruction_tous_clotures
     *  - dossier_contentieux_mes_infractions
     *  - dossier_contentieux_toutes_infractions
     *  - dossier_contentieux_mes_recours
     *  - dossier_contentieux_tous_recours
     *  - sous_dossier
     *
     * /!\ Pour l'affichage des références cadastrales dans le formulaire de modification
     * d'un dossier d'instruction cette condition est aussi utilisée mais en javascript.
     * Si cette méthode est modifiée il faut également aller modifier les conditions
     * dans app/js/script.js (~l1580)
     *
     * @return boolean
     */
    public function contexte_dossier_instruction() {
        $retourformulaire = $this->get_submitted_get_value("retourformulaire");

        if ($retourformulaire == 'dossier_instruction' ||
            $retourformulaire == 'dossier_instruction_mes_encours' ||
            $retourformulaire == 'dossier_instruction_tous_encours' ||
            $retourformulaire == 'dossier_instruction_mes_clotures' ||
            $retourformulaire == 'dossier_instruction_tous_clotures' ||
            $retourformulaire == 'dossier_contentieux_mes_infractions' ||
            $retourformulaire == 'dossier_contentieux_toutes_infractions' ||
            $retourformulaire == "dossier_contentieux_mes_recours" ||
            $retourformulaire == "dossier_contentieux_tous_recours" ||
            $retourformulaire == "sous_dossier") {
            return true;
        }
        return false;
    }

    /**
     * Calcule l'id d'un sous-formulaire d'un objet donné. Pour cela
     * récupère le fichier de paramétrage de l'objet (.inc) pour accéder
     * à la variable de paramétrage des sous-formulaires.
     * Vérifie pour chacun des formulaires paramétrés si l'utilisateur à
     * les permissions nécessaires pour y accéder. A partir de ces
     * informations calcule l'identifiant du sous-onglet.
     *
     * @param string nom du formulaire auquel appartiens le sous-formulaire
     * @return integer identifiant du sus-formulaire
     */
    public function get_ui_tabs($obj, $direct_field, $direct_form, $direct_action, $direct_idx) {
        $tabs_id = 1;
        // Rétrocompatibilité : il est possible que dans les scripts inclus
        // par cette méthode, la variable $f soit attendue et utilisée.
        // @deprecated Cette variable ne doit plus être utilisée.
        $f = $this;

        // Initialisation des paramètres
        $params = array(
            // action sur l'objet parent
            "action" => array(
                "default_value" => "",
            ),
            // (optionnel) soit idx soit direct_field : identifiant de
            // l'objet contexte
            "idx" => array(
                "default_value" => "",
            )
        );
        foreach ($this->get_initialized_parameters($params) as $key => $value) {
            ${$key} = $value;
        }
        // Vérification des paramètres obligatoires
        if (empty($obj)
            || empty($action)
            || (empty($idx) && empty($direct_field))
            || empty($direct_form)
            || empty($direct_action)
            || empty($direct_idx)) {

            return $tabs_id;
        }
        // Inclusion du script [sql/<OM_DB_PHPTYPE>/<OBJ>.inc.php]
        // L'objectif est de récupéré la liste des onglets pour extraire
        // l'identifiant de l'onglet sélectionné
        // - Variable utilisée $sousformulaire
        $standard_script_path = "../sql/".OM_DB_PHPTYPE."/".$obj.".inc.php";
        $core_script_path = PATH_OPENMAIRIE."sql/".OM_DB_PHPTYPE."/".$obj.".inc.php";
        $gen_script_path = "../gen/sql/".OM_DB_PHPTYPE."/".$obj.".inc.php";
        $custom_script_path = $this->get_custom("tab", $obj);

        if ($custom_script_path !== null) {
            require_once $custom_script_path;
        } elseif (file_exists($standard_script_path) === false
            && file_exists($core_script_path) === true) {
            require_once $core_script_path;
        } elseif (file_exists($standard_script_path) === false
            && file_exists($gen_script_path) === true) {
            require_once $gen_script_path;
        } elseif (file_exists($standard_script_path) === true) {
            require $standard_script_path;
        }

        if (empty($sousformulaire)) {
            return $tabs_id;
        }

        foreach ($sousformulaire as $sousform) {
            $droit = array($sousform, $sousform."_tab");

            if ($this->isAccredited($droit, "OR")) {
                if ($sousform == $direct_form) {
                    break;
                }
                $tabs_id++;
            }
        }
        return $tabs_id;
    }


    /**
     * Récupère une requête sql et renvoie les éléments nécessaires
     * pour ajouter le filtrage de des groupes à cette requête.
     * Renvoie ces éléments sous la forme d'un tableau associatif
     *  ex : array(
     *          ['FROM'] => 'LEFT JOIN ...',
     *          ['WHERE'] => '...'
     *      );
     *
     * @param string requête sql à faire évoluer
     * @return array
     */
    public function get_sql_filtre_groupe($sql = '') {
        $sqlCplmt = array(
            'FROM' => '',
            'WHERE' => ''
        );

        // Tableau temporaire contenant les clauses pour chaque groupe
        $group_clause = array();
        foreach ($_SESSION["groupe"] as $key => $value) {
            $group_clause[$key] = "(groupe.code = '".$key."'";
            if($value["confidentiel"] !== true) {
                $group_clause[$key] .= " AND dossier_autorisation_type.confidentiel IS NOT TRUE";
            }
            $group_clause[$key] .= ")";
        }
        // Ajout du cas ou le code du groupe est null
        $group_clause['EMPTY'] = '(groupe.code IS NULL AND dossier_autorisation_type.confidentiel IS NOT TRUE)';
        // Mise en chaîne des clauses
        $conditions = implode(" OR ", $group_clause);
        if ($conditions !== "") {
            // On ajout le WHERE si il n'est pas présent
            if (stripos($sql, "WHERE") === false) {
                $sqlCplmt['WHERE'] .= "WHERE ";
            } else {
                $sqlCplmt['WHERE'] .= " AND ";
            }
        
            $sqlCplmt['WHERE'] .= "(".$conditions.")";
        }
        
        
        // Jointures manquantes dans la requête d'origine qui devront être ajouté
        // dans la requête complémentaire
        if (preg_match("/".DB_PREFIXE."dossier_autorisation(?!_)/i", $sql) === 0) {
            $sqlCplmt['FROM'] .= "
            LEFT JOIN ".DB_PREFIXE."dossier_autorisation
                ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation";
        }
        if (preg_match("/".DB_PREFIXE."dossier_autorisation_type_detaille(?!_)/i", $sql) === 0) {
            $sqlCplmt['FROM'] .= "
            LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
                ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille";
        }
        if (preg_match("/".DB_PREFIXE."dossier_autorisation_type(?!_)/i", $sql) === 0) {
            $sqlCplmt['FROM'] .= "
            LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
                ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type";
        }
        if (preg_match("/".DB_PREFIXE."groupe(?!_)/i", $sql) === 0) {
            $sqlCplmt['FROM'] .= "
            LEFT JOIN ".DB_PREFIXE."groupe
                ON dossier_autorisation_type.groupe = groupe.groupe";
        }
        
        return $sqlCplmt;
    }

    /**
     * Récupère une requête sql et renvoie les éléments nécessaires
     * pour ajouter le filtrage de des groupes à cette requête.
     * Renvoie ces éléments sous la forme d'un tableau associatif
     *  ex : array(
     *          ['FROM'] => 'LEFT JOIN ...',
     *          ['WHERE'] => '...'
     *      );
     *
     * @param string requête sql à faire évoluer
     * @return array
     */
    public function get_sql_filtre_sous_dossier($sql = '') {
        $sqlCplmt = array(
            'FROM' => '',
            'WHERE' => ''
        );
        // On ajout le WHERE si il n'est pas présent
        $sqlCplmt['WHERE'] = ' AND dossier_instruction_type.sous_dossier IS NOT TRUE';
        if (stripos($sql, "WHERE") === false) {
            $sqlCplmt['WHERE'] .= 'WHERE dossier_instruction_type.sous_dossier IS NOT TRUE';
        }
        // Jointures manquantes dans la requête d'origine qui devront être ajouté
        // dans la requête complémentaire
        if (preg_match("/".DB_PREFIXE."dossier_instruction_type(?!_)/i", $sql) === 0 ||
            preg_match("/".DB_PREFIXE."dossier_instruction_type(?!_)\s*(as|AS)/i", $sql) !== 0) {
            $sqlCplmt['FROM'] .= "
            LEFT JOIN ".DB_PREFIXE."dossier_instruction_type
                ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type";
        }

        return $sqlCplmt;
    }

    /**
     * Récupère le code entité de la collectivité passé en paramètre ou de la
     * collectivité de l'utilisateur connecté.
     *
     * @param  string $om_collectivite Identifiant de la collectivité
     *
     * @return string                  Code entité ou null
     */
    public function get_collectivite_code_entite($om_collectivite = null) {
        // Récupération des paramètres de la collectivité voulu
        $parameters = $this->getCollectivite($om_collectivite);
        //
        return isset($parameters['code_entite']) === true && empty($parameters['code_entite']) === false ? strval(trim($parameters['code_entite'])) : null;
    }

    /**
     * Surcharge du "core" pour pouvoir utiliser une surcharge de l'abstracteur
     * du connecteur de stockage.
     */
    function setFilestorage() {
        $this->storage = false;
        if ($this->setFilestorageConfig()) {
            // surchage du "core"
            require_once __DIR__.'/om_filestorage.class.php';
            $this->storage = new om_filestorage($this->filestorage_config);
        }
    }

    /**
     * Permet de remplacer les espaces insécables par des espaces sécables
     * pour la valeur d'un champ texte.
     *
     * @param string $value Valeur à traiter
     * @return string la valeur avec des espaces sécables
     */
    function replace_non_breaking_space($value) {
       return preg_replace("/ |&nbsp;/", ' ', $value);
    }
}
