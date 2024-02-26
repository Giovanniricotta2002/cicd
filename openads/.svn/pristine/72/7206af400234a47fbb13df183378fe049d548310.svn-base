<?php
/**
 * Ce script permet de déclarer la classe 'interface_referentiel_erp'.
 *
 * Interface avec le référentiel ERP.
 *
 * @package openaria
 * @version SVN : $Id$
 */

/**
 * Définition de la classe 'interface_referentiel_erp'.
 */
class interface_referentiel_erp {

    /**
     * Instance de la classe utils
     * @var resource
     */
    var $f = null;

    /**
     * Constructeur.
     */
    public function __construct() {
        //
        $this->init_om_utils();
    }

    /**
     *
     */
    var $messages_openaria = array(
        // message "ERP Qualifie"
        101 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__AT__INFORMATION_DE_QUALIFICATION_ADS",
            "label" => '(Dossier AT) Information de qualification ADS',
            "content_fields" => array(
                "competence", "contraintes_plu", "references_cadastrales",
            )
        ),
        // message "Demande de completude de dossier PC pour un ERP"
        102 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__PC__PRE_DEMANDE_DE_COMPLETUDE_ERP",
            "label" => '(Dossier PC/ERP) Pré-demande de complétude ERP',
            "trigger" => "mark_as_connected_to_referentiel_erp",
        ),
        // message "Demande de qualification de dossier PC pour un ERP"
        103 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__PC__PRE_DEMANDE_DE_QUALIFICATION_ERP",
            "label" => '(Dossier PC/ERP) Pré-demande de qualification ERP',
            "trigger" => "mark_as_connected_to_referentiel_erp",
        ),
        // message "Demande d'instruction de dossier PC pour un ERP"
        104 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__PC__CONSULTATION_OFFICIELLE_POUR_AVIS",
            "label" => '(Dossier PC/ERP) Consultation officielle pour avis',
            "content_fields" => array(
                "consultation", "date_envoi", "service_abrege", "service_libelle", "date_limite",
            ),
            "trigger" => "mark_as_connected_to_referentiel_erp",
        ),
        // message "Arrete d'un dossier PC effectue"
        105 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__PC__INFORMATION_DE_DECISION_ADS",
            "label" => '(Dossier PC/ERP) Information de décision ADS',
            "content_fields" => array(
                "decision",
            )
        ),
        // message "Consultation ERP pour conformite"
        106 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__PC__CONSULTATION_OFFICIELLE_POUR_CONFORMITE",
            "label" => '(Dossier PC/ERP) Consultation officielle pour conformité',
            "content_fields" => array(
                "consultation", "date_envoi", "service_abrege", "service_libelle", "date_limite",
            ),
            "trigger" => "mark_as_connected_to_referentiel_erp",
        ),
        // message "Demande d'ouverture ERP PC"
        107 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__PC__DEMANDE_DE_VISITE_D_OUVERTURE_ERP",
            "label" => "(Dossier PC/ERP) Demande de visite d'ouverture ERP",
        ),
        // message "Depot de dossier DAT"
        108 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__AT__DEPOT_INITIAL",
            "label" => '(Dossier AT) Dépôt initial',
            "trigger" => "mark_as_connected_to_referentiel_erp",
        ),
        // message "Annulation de la demande"
        109 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__AT__RETRAIT_DU_PETITIONNAIRE",
            "label" => '(Dossier AT) Retrait du pétitionnaire',
        ),
        // message "Demande d'ouverture ERP DAT"
        110 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__AT__DEMANDE_DE_VISITE_D_OUVERTURE_ERP",
            "label" => "(Dossier AT) Demande de visite d'ouverture ERP",
        ),
        // message "Ajout de pièce"
        112 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__AT__DEPOT_DE_PIECE_PAR_LE_PETITIONNAIRE",
            "label" => '(Dossier AT) Dépôt de pièce par le pétitionnaire',
            "content_fields" => array(
                "type_piece"
            )
        ),
        // message "Nouvelle pièce"
        113 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__AJOUT_D_UNE_NOUVELLE_PIECE_NUMERISEE",
            "label" => "Ajout d'une nouvelle pièce numérisée",
            "content_fields" => array(
                "date_creation", "nom_fichier", "type", "categorie",
            )
        ),
        // message "Enjeu ADS"
        114 => array(
            "categorie" => "sortant",
            "type" => "ADS_ERP__PC__ENJEU_ADS",
            "label" => "(Dossier AT) Information d'enjeu ADS",
            "content_fields" => array(
                "Dossier à enjeu ADS"
            )
        ),
        204 => array(
            "categorie" => "entrant",
            "type" => "ERP_ADS__PC__INFORMATION_COMPLETUDE_ERP_ACCESSIBILITE",
            "content_fields" => array(
                "Complétude ERP ACC" => array('oui', 'non'),
                "Motivation Complétude ERP ACC" => null,
            ),
        ),
        205 => array(
            "categorie" => "entrant",
            "type" => "ERP_ADS__PC__INFORMATION_COMPLETUDE_ERP_SECURITE",
            "content_fields" => array(
                "Complétude ERP SECU" => array('oui', 'non'),
                "Motivation Complétude ERP SECU" => null,
            ),
        ),
        206 => array(
            "categorie" => "entrant",
            "type" => "ERP_ADS__PC__INFORMATION_QUALIFICATION_ERP",
            "content_fields" => array(
                "Confirmation ERP" => array('oui', 'non'),
                "Type de dossier ERP" => null,
                "Catégorie de dossier ERP" => null,
            ),
        ),
        207 => array(
            "categorie" => "entrant",
            "type" => "ERP_ADS__PC__NOTIFICATION_DOSSIER_A_ENJEUX_ERP",
            "content_fields" => array(
                "Dossier à enjeux ERP" => array('oui', 'non'),
            ),
        ),
        213 => array(
            "categorie" => "entrant",
            "type" => "ERP_ADS__PC__AR_CONSULTATION_OFFICIELLE",
            "label" => "Accusé de réception de consultation d'un service ERP",
            "content_fields" => array(
                "consultation" => null
            ),
        )
    );


    /**
     *
     */
    function get_config_messages_in() {
        $config = array();
        foreach ($this->messages_openaria as $key => $value) {
            if ($value["categorie"] === "entrant") {
                $config[] = $value;
            }
        }
        return $config;
    }

    /**
     *
     */
    function send_message_to_referentiel_erp($code, $infos) {
        /**
         *
         */
        //
        $this->addToLog(
            sprintf(
                '%s(): (WS|ADS->ERP)[%s] - %s',
                __METHOD__,
                $code,
                str_replace("\n", "", print_r($infos, true))
            ),
            EXTRA_VERBOSE_MODE
        );

        /**
         *
         */
        if (!isset($this->messages_openaria[$code])) {
            //
            $this->addToLog(
                sprintf(
                    '%s(): (WS|ADS->ERP)[%s] - Erreur - Code %s invalide',
                    __METHOD__,
                    $code,
                    $code
                ),
                DEBUG_MODE
            );
            return false;
        }

        /**
         *
         */
        //
        $date = date('d/m/Y H:i:s');
        $emetteur = $_SESSION['login'];
        //
        $data = array(
            "type" => $this->messages_openaria[$code]["type"],
            "date" => $date,
            "emetteur" => $emetteur,
            "dossier_instruction" => $infos["dossier_instruction"],
        );
        if (isset($this->messages_openaria[$code]["content_fields"])) {
            $data["contenu"] = array();
            foreach ($this->messages_openaria[$code]["content_fields"] as $field) {
                if (!isset($infos[$field])) {
                    //
                    $this->addToLog(
                        sprintf(
                            '%s(): (WS|ADS->ERP)[%s] - champ %s obligatoire',
                            __METHOD__,
                            $code,
                            $field
                        ),
                        DEBUG_MODE
                    );
                    return false;
                }
                $data["contenu"][$field] = $infos[$field];
            }
        }

        /** 
         * 
         */
        if (isset($this->messages_openaria[$code]["trigger"])
            && $this->messages_openaria[$code]["trigger"] == "mark_as_connected_to_referentiel_erp") {
            //
            $val = array(
                "dossier_instruction" => $infos["dossier_instruction"],
            );
            $ret = $this->trigger_mark_as_connected_to_referentiel_erp($val);
            if ($ret !== true) {
                return false;
            }
        }

        /**
         * Ajout d'un enregistrement dans la table dossier_message
         */
        // Composition des données du message
        $val = array(
            "dossier_message" => 0,
            "categorie" => $this->messages_openaria[$code]["categorie"],
            "type" => $this->messages_openaria[$code]["type"],
            "date_emission" => $date,
            "emetteur" => $emetteur,
            "destinataire" => 'instructeur',
            "dossier" => $infos["dossier_instruction"],
            "lu" => true,
            "contenu" => json_encode($data),
        );
        //
        $inst_dossier_message = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_message",
            "idx" => 0,
        ));
        $ret = $inst_dossier_message->ajouter($val);
        if ($ret !== true) {
            //
            $this->addToLog(
                sprintf(
                    '%s(): (WS|ADS->ERP)[%s] - Erreur lors de la sauvegarde du message',
                    __METHOD__,
                    $code
                ),
                DEBUG_MODE
            );
            return false;
        }

        /**
         *
         */
        //
        if (file_exists("../dyn/services.inc.php")) {
            require "../dyn/services.inc.php";
        }
        require_once PATH_OPENMAIRIE."om_rest_client.class.php";

        $inst_om_rest_client = new om_rest_client(
            $ERP_URL_MESSAGES
        );
        $response = $inst_om_rest_client->execute(
            "POST",
            "application/json",
            json_encode($data)
        );
        //
        $this->addToLog(
            sprintf(
                '%s(): (WS|ADS->ERP)[%s] - Code Retour : %s - Response %s',
                __METHOD__,
                $code,
                $inst_om_rest_client->getResponseCode(),
                str_replace("\n", "", print_r($response, true))
            ),
            EXTRA_VERBOSE_MODE
        );
        if ($inst_om_rest_client->getResponseCode() !== 200) {
            $this->addToLog(
                sprintf(
                    '%s(): (WS|ADS->ERP)[%s] - Erreur : %s',
                    __METHOD__,
                    $code,
                    str_replace("\n", "", print_r($inst_om_rest_client->getResponse(), true))
                ),
                DEBUG_MODE
            );
            return false;
        }

        /**
         *
         */
        //
        $this->addToLog(
            sprintf(
                '%s(): (WS|ADS->ERP)[%s] - return true;',
                __METHOD__,
                $code
            ),
            EXTRA_VERBOSE_MODE
        );
        //
        return true;
    }

    /**
     *
     */
    function view_controlpanel() {
        //
        $this->f->setRight("settings");
        $this->f->setTitle(_("administration_parametrage")." -> "._("interface avec le referentiel erp"));
        $this->f->setFlag(null);
        $this->f->display();
        $this->f->displaySubTitle("Configuration");
        //
        echo "<u>option :</u>";
        printf(
            '<pre>- option_referentiel_erp : <b>%s</b> => <b>%s</b></pre>',
            var_export($this->f->getParameter('option_referentiel_erp'), true),
            ($this->f->is_option_referentiel_erp_enabled() != true ? "DISABLED" : "ENABLED")
        );
        //
        echo "<u>paramètres :</u>";
        $parametres = array(
            "erp__dossier__nature__at",
            "erp__demandes__depot_piece__at",
            "erp__demandes__retrait__at",
            "erp__demandes__ouverture__at",
            "erp__dossier__nature__pc",
            "erp__services__avis__pc",
            "erp__services__conformite__pc",
            "erp__evenements__decision__pc",
            "erp__demandes__ouverture__pc",
        );
        $out = '';
        foreach ($parametres as $parametre) {
            $out .= sprintf(
                "- %s : <b>%s</b>\n",
                $parametre,
                var_export($this->f->getParameter($parametre), true)
            );
        }
        printf(
            '<pre>%s</pre>',
            $out
        );
        //
        echo "<u>../dyn/services.inc.php :</u>";
        if (file_exists("../dyn/services.inc.php")) {
            //
            include "../dyn/services.inc.php";
            //
            $params = array(
                "MESSAGES",
            );
            echo "<pre>";
            foreach ($params as $param) {
                $name_var = sprintf('ERP_URL_%s', $param);
                if (isset(${$name_var})) {
                    echo sprintf('- $%s = "%s";', $name_var, ${$name_var});
                } else {
                    echo sprintf('- $%s à définir', $name_var);
                }
                echo "\n";
            }
            echo "</pre>";
        } else {
            echo "- le fichier n'existe pas";
        }

        /**
         * Stats
         */
        //
        $this->f->displaySubTitle("Statistiques");
        //
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    categorie,
                    type,
                    count(*)
                FROM
                    %1$sdossier_message  
                GROUP BY
                    categorie,
                    type
                ORDER BY
                    categorie DESC,
                    type ASC',
                DB_PREFIXE,
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $results = array();
        foreach ($qres['result'] as $row) {
            $results[] = $row;
        }
        //
        $stats = array();
        //
        foreach ($this->messages_openaria as $key => $value) {
            $stat = $value;
            $stat["code"] = $key;
            $stat["count"] = "";
            foreach ($results as $result) {
                if ($result["type"] === $value["type"]) {
                    $stat["count"] = $result["count"];
                }
            }
            $stats[] = $stat;
        }
        //
        $table_template = '
        <table class="table table-condensed table-bordered table-striped table-hover">
            <tr><th>categorie</th><th>code</th><th>type</th><th>count</th></tr>
            %s
        </table>';
        //
        $line_template = '<tr class="%s"><td>%s</td><td>%s</td><td>%s</td><td>%s</td></tr>';
        //
        $table_content = '';
        foreach ($stats as $key => $value) {
            $table_content .= sprintf(
                $line_template,
                ($value['categorie'] == "entrant" ? "warning" : "info"),
                $value['categorie'],
                $value['code'],
                $value["type"],
                $value["count"]
            );
        }
        //
        printf(
            $table_template,
            $table_content
        );

        /**
         * Logs
         */
        //
        $this->f->displaySubTitle("Logs '../var/log/services.log'");
        echo '<iframe src="../app/index.php?module=settings&view=log" style="width:100%;height:300px;"></iframe>';
    }

    function trigger_mark_as_connected_to_referentiel_erp($val = array()) {
        $inst_dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $val["dossier_instruction"],
        ));
        return $inst_dossier->mark_as_connected_to_referentiel_erp();
    }

    // {{{ BEGIN - UTILS, LOGGER, ERROR

    /**
     * Initialisation de la classe utils.
     *
     * Cette méthode permet de vérifier que l'attribut f de la classe contient
     * bien la ressource utils du framework et si ce n'est pas le cas de la
     * récupérer.
     *
     * @return boolean
     */
    function init_om_utils() {
        //
        if (isset($this->f) && $this->f != null) {
            return true;
        }
        //
        if (isset($GLOBALS["f"])) {
            $this->f = $GLOBALS["f"];
            return true;
        }
        //
        return false;
    }

    /**
     * Ajout d'un message au système de logs.
     *
     * Cette méthode permet de logger un message.
     *
     * @param string  $message Message à logger.
     * @param integer $type    Niveau de log du message.
     *
     * @return void
     */
    function addToLog($message, $type = DEBUG_MODE) {
        //
        if (isset($this->f) && method_exists($this->f, "elapsedtime")) {
            logger::instance()->log(
                $this->f->elapsedtime()." : class ".get_class($this)." - ".$message,
                $type
            );
        } else {
            logger::instance()->log(
                "X.XXX : class ".get_class($this)." - ".$message,
                $type
            );
        }
    }

    // }}} END - UTILS, LOGGER, ERROR

}


