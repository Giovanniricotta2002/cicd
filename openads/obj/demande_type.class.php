<?php
/**
 * DBFORM - 'demande_type' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'demande_type'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/demande_type.class.php";

class demande_type extends demande_type_gen {

    /**
     * Constructeur.
     */
    function __construct($id, &$dnu1 = null, $dnu2 = null) {
        $this->constructeur($id);
        // Initialisation des variables de classe
        $this->lib_dossier_autorisation_type_detaille = _('dossier_autorisation_type_detaille');
        $this->lib_dossier_instruction_type = _("type de dossier d'instruction a creer");
    }

    // Variables de classe
    var $lib_dossier_autorisation_type_detaille;
    var $lib_dossier_instruction_type;

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        parent::init_class_actions();

        // ACTION - 100 - non_frequent
        // Finalise l'enregistrement
        $this->class_actions[100] = array(
            "identifier" => "doc_checklist",
            "view" => "doc_checklist_json",
            "permission_suffix" => "show_checklist",
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "demande_type.demande_type",
            "demande_type.code",
            "demande_type.libelle",
            "demande_type.description",
            "demande_type.groupe",
            "demande_type.dossier_autorisation_type_detaille",
            "demande_type.demande_nature",
            "(SELECT string_agg(etat::text, ';') FROM ".DB_PREFIXE."lien_demande_type_etat WHERE demande_type = demande_type.demande_type) as etats_autorises",
            "(SELECT string_agg(dossier_instruction_type::text, ';') FROM ".DB_PREFIXE."lien_demande_type_dossier_instruction_type WHERE demande_type = demande_type.demande_type) as dossier_instruction_type_compatible",
            "demande_type.contraintes",
            "demande_type.dossier_instruction_type",
            "demande_type.qualification",
            "demande_type.regeneration_cle_citoyen",
            "demande_type.evenement",
            "demande_type.document_obligatoire",
        );
    }

    /**
     * Clause where pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__selection() {
        return " GROUP BY demande_type.demande_type, demande_type.libelle ";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type() {
        return "SELECT dossier_instruction_type.dossier_instruction_type,
            (dossier_autorisation_type_detaille.code||' - '||dossier_instruction_type.libelle) as lib
            FROM ".DB_PREFIXE."dossier_instruction_type
            LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            ORDER BY lib";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return "SELECT
        dossier_instruction_type.dossier_instruction_type,
        CONCAT_WS(' - ', dossier_autorisation_type_detaille.code, dossier_instruction_type.libelle) as lib
        FROM ".DB_PREFIXE."dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
        ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        WHERE dossier_instruction_type.dossier_instruction_type = <idx>";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille() {
        return "SELECT
        dossier_autorisation_type_detaille.dossier_autorisation_type_detaille,
        (dossier_autorisation_type_detaille.code||' ('||dossier_autorisation_type_detaille.libelle||')') as lib
        FROM ".DB_PREFIXE."dossier_autorisation_type_detaille
        ORDER BY lib";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille_by_id() {
        return "SELECT
        dossier_autorisation_type_detaille.dossier_autorisation_type_detaille,
        (dossier_autorisation_type_detaille.code||' ('||dossier_autorisation_type_detaille.libelle||')') as lib
        FROM ".DB_PREFIXE."dossier_autorisation_type_detaille
        WHERE dossier_autorisation_type_detaille = <idx>";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement() {
        return "SELECT evenement.evenement, evenement.libelle as lib FROM ".DB_PREFIXE."evenement
        ORDER BY lib";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_evenement_by_id() {
        return "SELECT evenement.evenement, evenement.libelle FROM ".DB_PREFIXE."evenement WHERE evenement = <idx>";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etats_autorises() {
        return "
        SELECT
            etat.etat,
            etat.libelle as lib
        FROM ".DB_PREFIXE."etat
        ORDER BY lib";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_etats_autorises_by_id() {
        return "
        SELECT
            etat.etat,
            etat.libelle as lib
        FROM ".DB_PREFIXE."etat
        WHERE etat.etat IN (<idx>)
        ORDER BY lib";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_compatible() {
        return "
        SELECT
            dossier_instruction_type.dossier_instruction_type,
            CONCAT_WS(' - ', dossier_autorisation_type_detaille.code, dossier_instruction_type.libelle) as lib
        FROM ".DB_PREFIXE."dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        ORDER BY lib";
    }

    /**
     *
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_compatible_by_id() {
        return "
        SELECT
            dossier_instruction_type.dossier_instruction_type,
            CONCAT_WS(' - ', dossier_autorisation_type_detaille.code, dossier_instruction_type.libelle) as lib
        FROM ".DB_PREFIXE."dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_instruction_type.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        WHERE dossier_instruction_type.dossier_instruction_type IN (<idx>)
        ORDER BY lib";
    }

        
    /**
     * Requête permettant de récupérer les types de dossier d'instruction et les types de
     * sous-dossier par rapport au type détaillé de dossier d'autorisation
     *
     * @return string
     */
    function get_var_sql_forminc__sql_type_di_et_sous_dossier_by_dossier_autorisation_type_detaille() {
        return sprintf(
            'SELECT 
                dossier_instruction_type.dossier_instruction_type,
                CONCAT_WS(\' - \', dossier_autorisation_type_detaille.code, dossier_instruction_type.libelle) AS lib
            FROM
                %1$sdossier_instruction_type
                LEFT JOIN %1$sdossier_autorisation_type_detaille
                    ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            WHERE
                dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = <idx_dossier_autorisation_type_detaille>
                -- Selectionne tous les type de sous_dossier rattaché à un type de dossier d instruction
                -- dont le type du dossier d autorisation est celui voulu
                OR (dossier_instruction_type.sous_dossier IS TRUE
                    AND dossier_instruction_type.dossier_instruction_type IN (
                        SELECT
                            lien_type_di_type_di.dossier_instruction_type
                        FROM
                            %1$slien_type_di_type_di
                            LEFT JOIN %1$sdossier_instruction_type
                                ON lien_type_di_type_di.type_di_parent = dossier_instruction_type.dossier_instruction_type
                        WHERE
                            dossier_instruction_type.dossier_autorisation_type_detaille = <idx_dossier_autorisation_type_detaille>
                    )
                )
            ORDER BY
                dossier_autorisation_type_detaille.code,
                dossier_instruction_type.libelle',
            DB_PREFIXE
        );
    }

        
    /**
     * Requête permettant de récupérer les types de dossier d'instruction par rapport
     * au type détaillé de dossier d'autorisation
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_dossier_autorisation_type_detaille() {
        return "
        SELECT 
            dossier_instruction_type.dossier_instruction_type,
            CONCAT_WS(' - ', dossier_autorisation_type_detaille.code, dossier_instruction_type.libelle) as lib
        FROM ".DB_PREFIXE."dossier_instruction_type
            LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
                ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        WHERE dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = <idx_dossier_autorisation_type_detaille>
        ORDER BY dossier_autorisation_type_detaille.code, dossier_instruction_type.libelle";
    }

    /**
     * Requête permettant de récupérer les types détaillés de dossier d'autorisation
     * par rapport au groupe
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille_by_groupe() {
        return sprintf(
            'SELECT 
                dossier_autorisation_type_detaille.dossier_autorisation_type_detaille,
                (dossier_autorisation_type_detaille.code || \' (\' || dossier_autorisation_type_detaille.libelle || \')\') AS lib
            FROM
                %1$sdossier_autorisation_type_detaille
                LEFT JOIN %1$sdossier_autorisation_type
                    ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
            WHERE
                dossier_autorisation_type.groupe = <idx_groupe>
            ORDER BY
                dossier_autorisation_type_detaille.code,
                dossier_autorisation_type_detaille.libelle',
            DB_PREFIXE
        );
    }

    /**
     * Permet de retourner les informations necessaires à l'affichage de la checklist
     * des documents obligatoires lors du dépôt de demande.
     */
    function doc_checklist_json() {
        $this->f->disableLog();

        if($this->getVal("document_obligatoire") != "") {
            // Si des documents obligatoires sont définis on constitue le json
            $res = array(
                "title"=>_("Liste des documents obligatoires"),
                "documents" => preg_split("/\\r\\n|\\r|\\n/", $this->getVal("document_obligatoire")),
                "libelle_ok" => _("Valider"),
                "libelle_cancel" => _("Rejeter la demande"),
                "message_ko" => _("Tous les documents doivent-etre presents.\nDans le cas contraire, rejeter la demande."),
                "message_rejet" => _("Etes vous sur de vouloir rejeter la demande ?"),
            );
            // On retourne le JSON
            printf("%s", json_encode($res));
        } else {
            // Sinon on retourn false
            printf("false");
        }
    }

    function setLib(&$form, $maj) {
        //
        parent::setLib($form, $maj);
        //
        $form->setLib("dossier_instruction_type", $this->lib_dossier_instruction_type);
        $form->setLib("evenement", _("type de l'evenement d'instruction a creer"));
        $form->setLib("etats_autorises", __("états autorisés du dossier d'instruction ciblé"));
        $form->setLib("regeneration_cle_citoyen", _("regénérer la clé d'accès au portail citoyen"));
        $form->setLib('dossier_autorisation_type_detaille', $this->lib_dossier_autorisation_type_detaille);

        //
        $form->setLib("dossier_instruction_type_compatible", __("types compatibles des dossiers d’instruction en cours"));
    }

    function setLayout(&$form, $maj) {
        //
        parent::setLayout($form, $maj);
        //
        $form->setFieldset("demande_type", "D", _("demande_type"));
        $form->setFieldset("description", "F");
        //
        $form->setFieldset("groupe", "D", _("categorisation"));
        $form->setFieldset("demande_nature", "F");
        //
        $form->setFieldset("etats_autorises", "D", _("comportement de la demande"));
        $form->setFieldset("regeneration_cle_citoyen", "F");
        //
        $form->setFieldset("evenement", "DF", _("recepisse de la demande"));
        //
        $form->setFieldset("document_obligatoire", "DF", _("documents obligatoires"));
    }

    function setType(&$form, $maj) {
        //
        parent::setType($form, $maj);

        if ($maj < 2 ) {
            $form->setType("contraintes","select");
            $form->setType("etats_autorises","select_multiple");
            $form->setType("dossier_instruction_type_compatible", "select_multiple");
        }
        if ($maj >= 2) {
            $form->setType("contraintes","selecthiddenstatic");
            $form->setType("etats_autorises","select_multiple_static");
            $form->setType("dossier_instruction_type_compatible", "select_multiple_static");
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // Liste des contraintes applicables lors de la création d'une nouvelle demande
        $contraintes = array(
            array(
                '',
                'avec_recup',
                'avec_r_sma',
                'avec_r_sm_aa',
                'sans_recup',
            ),
            array(
                __('choisir une contrainte'),
                __('Récupération des demandeurs avec modification et ajout'),
                __('Récupération des demandeurs sans modification ni ajout'),
                __('Récupération des demandeurs sans modification avec ajout'),
                __('Sans récupération des demandeurs'),
            ),
        );
        $form->setSelect("contraintes", $contraintes);
        //Initialisation de la liste des états des dossiers d'instruction
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "etats_autorises",
            $this->get_var_sql_forminc__sql("etats_autorises"),
            $this->get_var_sql_forminc__sql("etats_autorises_by_id"),
            false,
            true
        );
        if ($this->getParameter('maj') == 3 || $this->getParameter('maj') == 2) {
            // Initialisation de la liste des types de dossier d'instruction
            // compatibles pour la parallèlisation
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "dossier_instruction_type_compatible",
                $this->get_var_sql_forminc__sql("dossier_instruction_type_compatible"),
                $this->get_var_sql_forminc__sql("dossier_instruction_type_compatible_by_id"),
                false,
                true
            );
        }

        // Si en ajout ou en modification
        if ($maj < 2) {
            // Initialise les select en fonction de la valeur d'un autre champ
            $form->setSelect(
                'dossier_autorisation_type_detaille',
                $this->loadSelect_dossier_autorisation_type_detaille($form, $maj, "groupe")
            );
            $form->setSelect(
                'dossier_instruction_type',
                $this->loadSelect_dossier_instruction_type($form, $maj, "dossier_autorisation_type_detaille")
            );
            $form->setSelect(
                'dossier_instruction_type_compatible',
                $this->loadSelect_dossier_instruction_type_compatible($form, $maj, "dossier_autorisation_type_detaille")
            );
        }
    }

    /**
     * Permet de définir l’attribut “onchange” sur chaque champ
     * @param object $form Formumaire
     * @param int    $maj  Mode d'insertion
     */
    function setOnchange(&$form,$maj) {
        parent::setOnchange($form,$maj);

        //Au changement sur le champ groupe, réinitilisation des champs dossier_autorisation_type_detaille et dossier_instruction_type
        $form->setOnchange('groupe', 'filterSelect(this.value, \'dossier_autorisation_type_detaille\', \'groupe\', \'demande_type\'), filterSelect(dossier_autorisation_type_detaille.value, \'dossier_instruction_type\', \'dossier_autorisation_type_detaille\', \'demande_type\')');
        $form->setOnchange('dossier_autorisation_type_detaille', 'filterSelect(this.value, \'dossier_instruction_type\', \'dossier_autorisation_type_detaille\', \'demande_type\');filterSelect(this.value, \'dossier_instruction_type_compatible\', \'dossier_autorisation_type_detaille\', \'demande_type\')');
        $form->setOnchange("demande_nature", "VerifNum(this);required_fields_demande_type(this.value, '".addslashes($this->lib_dossier_autorisation_type_detaille)."', '".addslashes($this->lib_dossier_instruction_type)."');");
        
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * Traitement des liens dans les tables de liaison après l'ajout de l'enregistrement
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        //
        parent::triggerajouterapres($id, $dnu1, $val);
        // Traitement des liaisons dans lien_demande_type_etat
        $lien_demande_type_etat = $this->handle_related_table('lien_demande_type_etat', 'etat', 'etats_autorises');
        if ($lien_demande_type_etat > 0) {
            $message = sprintf(_("Mise à jour de %s liaison(s) avec les états autorisés."), $lien_demande_type_etat);
            $this->addToMessage($message);
        }

        // Traitement des liaisons dans lien_demande_type_dossier_instruction_type
        $lien_demande_type_dossier_instruction_type = $this->handle_related_table('lien_demande_type_dossier_instruction_type', 'dossier_instruction_type', 'dossier_instruction_type_compatible');
        if ($lien_demande_type_dossier_instruction_type > 0) {
            $message = sprintf(_("Mise à jour de %s liaison(s) avec les types de dossier d'instruction compatibles."), $lien_demande_type_dossier_instruction_type);
            $this->addToMessage($message);
        }

        //
        return true;
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * Traitement des liens dans les tables de liaison après la modification de
     * l'enregistrement
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        //
        parent::triggermodifierapres($id, $dnu1, $val);
        // Traitement des liaisons dans lien_demande_type_etat
        $lien_demande_type_etat = $this->handle_related_table('lien_demande_type_etat', 'etat', 'etats_autorises');
        if ($lien_demande_type_etat > 0) {
            $message = sprintf(_("Mise à jour de %s liaison(s) avec les états autorisés."), $lien_demande_type_etat);
            $this->addToMessage($message);
        }
        // Traitement des liaisons dans lien_demande_type_dossier_instruction_type
        $lien_demande_type_dossier_instruction_type = $this->handle_related_table('lien_demande_type_dossier_instruction_type', 'dossier_instruction_type', 'dossier_instruction_type_compatible');
        if ($lien_demande_type_dossier_instruction_type > 0) {
            $message = sprintf(_("Mise à jour de %s liaison(s) avec les types de dossier d'instruction compatibles."), $lien_demande_type_dossier_instruction_type);
            $this->addToMessage($message);
        }
        //
        return true;
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * Suppression des liens dans les tables de liaison avant la suppression de
     * l'enregistrement
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        //
        parent::triggersupprimer($id, $dnu1, $val);
        // Suppression des liens entre le type de demande et les états
        $lien_demande_type_etat = $this->delete_related_table('lien_demande_type_etat');
        // Suppression des liens entre le type de demande et les types de
        // dossiers d'instruction compatibles
        $lien_demande_type_dossier_instruction_type = $this->delete_related_table('lien_demande_type_dossier_instruction_type');
        //
        return true;
    }

    /**
     * Suppression de la recherche de clés sur la table lien_demande_type_etat_dossier_autorisation
     */
    function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // Verification de la cle secondaire : demande
        $this->rechercheTable($dnu1, "demande", "demande_type", $id);
    }

    /**
     * Charge le select du champ type de dossier d'autorisation détaillé
     * @param  object $form  Formulaire
     * @param  int    $maj   Mode d'insertion
     * @param  string $champ champ activant le filtre
     * @return array         Contenu du select
     */
    function loadSelect_dossier_autorisation_type_detaille(&$form, $maj, $champ) {
        //
        $contenu=array();
        $contenu[0][0]='';
        $contenu[1][0]=_("Choisir type de dossier d'autorisation detaille");

        //Récupère l'id du type de dossier d'autorisation détaillé 
        $id_groupe = "";
        if ($this->f->get_submitted_post_value($champ) !== null) {
            $id_groupe = $this->f->get_submitted_post_value($champ);
        } elseif($this->getParameter($champ) != "") {
            $id_groupe = $this->getParameter($champ);
        } elseif(isset($form->val[$champ])) {
            $id_groupe = $form->val[$champ];
        }

        if ($id_groupe != "") {
            //Si l'id l'id du type de dossier d'autorisation détaillé est renseigné
            $qres = $this->f->get_all_results_from_db_query(
                str_replace(
                    '<idx_groupe>',
                    intVal($id_groupe),
                    $this->get_var_sql_forminc__sql("dossier_autorisation_type_detaille_by_groupe")
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            // Les résultats de la requête sont stockés dans le tableau contenu
            $k=1;
          
            foreach($qres['result'] as $row) {
                $contenu[0][$k] = $row['dossier_autorisation_type_detaille'];
                $contenu[1][$k] = $row['lib'];
                $k++;
            }
        }
        //
        return $contenu;
    }

    /**
     * Charge le select du champ type de dossier d'instruction (DI) à créer.
     * Ce select contiens la liste de tous les types de DI ayant pour type
     * de dossier d'autorisation (DA) détaillé le type voulu.
     * Ainsi que tous les types de DI étant des sous-dossiers et étant lié à des types
     * de DI qui ont pour type de DA détaillé le type voulu.
     *
     * @param  object $form  Formulaire
     * @param  int    $maj   Mode d'insertion
     * @param  string $champ champ activant le filtre
     * @return array         Contenu du select
     */
    function loadSelect_dossier_instruction_type(&$form, $maj, $champ) {
        $contenu=array();
        $contenu[0][0]='';
        $contenu[1][0]=_("Choisir type de dossier d'instruction");

        //Récupère l'id du type de dossier d'autorisation détaillé 
        $id_dossier_autorisation_type_detaille = "";
        if ($this->f->get_submitted_post_value($champ) !== null) {
            $id_dossier_autorisation_type_detaille = $this->f->get_submitted_post_value($champ);
        } elseif($this->getParameter($champ) != "") {
            $id_dossier_autorisation_type_detaille = $this->getParameter($champ);
        } elseif(isset($form->val[$champ])) {
            $id_dossier_autorisation_type_detaille = $form->val[$champ];
        }

        if ($id_dossier_autorisation_type_detaille != "") {
            //Si l'id l'id du type de dossier d'autorisation détaillé est renseigné
            $qres = $this->f->get_all_results_from_db_query(
                str_replace(
                    '<idx_dossier_autorisation_type_detaille>',
                    intVal($id_dossier_autorisation_type_detaille),
                    $this->get_var_sql_forminc__sql("type_di_et_sous_dossier_by_dossier_autorisation_type_detaille")
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            // Les résultats de la requête sont stockés dans le tableau contenu
            $k=1;
          
            foreach($qres['result'] as $row) {
                $contenu[0][$k] = $row['dossier_instruction_type'];
                $contenu[1][$k] = $row['lib'];
                $k++;
            }
        }

        return $contenu;
    }

    /**
     * Charge le select du champ type de dossier d'instruction à créer 
     * @param  object $form  Formulaire
     * @param  int    $maj   Mode d'insertion
     * @param  string $champ champ activant le filtre
     * @return array         Contenu du select
     */
    function loadSelect_dossier_instruction_type_compatible(&$form, $maj, $champ) {
        //
        $contenu=array();
        $contenu[0][0]='';
        $contenu[1][0]=_("Choisir type de dossier d'instruction");

        //Récupère l'id du type de dossier d'autorisation détaillé 
        $id_dossier_autorisation_type_detaille = "";
        if ($this->f->get_submitted_post_value($champ) !== null) {
            $id_dossier_autorisation_type_detaille = $this->f->get_submitted_post_value($champ);
        } elseif($this->getParameter($champ) != "") {
            $id_dossier_autorisation_type_detaille = $this->getParameter($champ);
        } elseif(isset($form->val[$champ])) {
            $id_dossier_autorisation_type_detaille = $form->val[$champ];
        }

        if ($id_dossier_autorisation_type_detaille != "") {
            //Si l'id l'id du type de dossier d'autorisation détaillé est renseigné
            $qres = $this->f->get_all_results_from_db_query(
                str_replace(
                    '<idx_dossier_autorisation_type_detaille>',
                    intVal($id_dossier_autorisation_type_detaille),
                    $this->get_var_sql_forminc__sql("type_di_et_sous_dossier_by_dossier_autorisation_type_detaille")
                ),
                array(
                    'origin' => __METHOD__
                )
            );
            // Les résultats de la requête sont stockés dans le tableau contenu
            $k=1;
          
            foreach($qres['result'] as $row) {
                $contenu[0][$k] = $row['dossier_instruction_type'];
                $contenu[1][$k] = $row['lib'];
                $k++;
            } 
        }
        //
        return $contenu;
    }

    /**
     * (Surcharge) Effectue des vérifications avant mise à jour des données
     * issues d'un formulaire d'ajout ou de modification.
     *
     * Les vérifications réalisées dans cette méthode sont :
     *  1 - Vérifie pour les demandes de nouveau dossier si le type détaillé de dossier
     *      d'autorisation (DA) et si type de dossier d'instruction (DI) ont bien été
     *      saisie. Si ce n'est pas le cas empêche la validation du formulaire et
     *      indique à l'utilisateur que ces champs sont obligatoires pour les nouvelles
     *      demandes.
     *  2 - Si le type de DI associé à la demande est un type utilisé pour des sous-dossiers
     *      alors le champs "Nature de la demande" dois obligatoirement avoir pour valeur
     *      "Dossier existant". Si ce n'est pas le cas empeche la validation du formulaire et
     *      averti l'utilisateur que son paramétrage n'est pas correct.
     *
     * @param formulaire $form : instance du formulaire
     * @param integer $maj : identifiant de l'action issus de l'url du formualire
     * @param string $dnu1 : inutilisé
     * @param string $dnu2 : inutilisés
     *
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);
        $codeDemandeNature = $this->get_demande_nature_code($this->valF['demande_nature']);
        // Vérification 1
        // Si c'est une nouvelle demande
        if ($codeDemandeNature == 'NOUV') {

            // Si le champ dossier_autorisation_type_detaille est vide
            if ($this->valF['dossier_autorisation_type_detaille'] == ''
                || $this->valF['dossier_autorisation_type_detaille'] == null) {
                $this->correct = false;
                $this->addToMessage(__("Le champ")." <span class=\"bold\">".$this->lib_dossier_autorisation_type_detaille."</span> ".__("est obligatoire"));
            }

            // Si dossier_instruction_type est vide
            if ($this->valF['dossier_instruction_type'] == ''
                || $this->valF['dossier_instruction_type'] == null) {
                $this->correct = false;
                $this->addToMessage(__("Le champ")." <span class=\"bold\">".$this->lib_dossier_instruction_type."</span> ".__("est obligatoire"));
            }
            
        }

        // Vérification 2
        if (! empty($val['dossier_instruction_type'])) {
            // Récupère l'instance du type de DI pour vérifier si ce type est associé
            // à des sous_dossier
            $typeDI = $this->f->get_inst__om_dbform(array(
                'obj' => 'dossier_instruction_type',
                'idx' => $val['dossier_instruction_type']
            ));
            if ($this->get_boolean_from_pgsql_value($typeDI->getVal('sous_dossier'))
                && $codeDemandeNature != 'EXIST') {
                $this->correct = false;
                $this->addToMessage(__('Les demandes associées à des sous-dossiers sont obligatoirement des demandes sur dossier existant.'));
            }
        }
    }

    /**
     * Récupère le code de la nature de la demande
     * @param  integer $demande_nature  Identifiant de la nature de la demande
     * @return string                   Code de la nature de la demande
     */
    function get_demande_nature_code($demande_nature) {
        $inst_demande_nature = $this->f->get_inst__om_dbform(array(
            "obj" => "demande_nature",
            "idx" => $demande_nature,
        ));
        return $inst_demande_nature->getVal("code");
    }
}

