<?php
/**
 * DBFORM - 'lien_dossier_dossier' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/lien_dossier_dossier.class.php";

class lien_dossier_dossier extends lien_dossier_dossier_gen {

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        //
        parent::init_class_actions();

        // ACTION - 000 - ajouter
        // Désactivation de l'action ajouter
        $this->class_actions[0] = null;

        // ACTION - 001 - modifier
        // Désactivation de l'action modifier
        $this->class_actions[1] = null;

        // ACTION - 002 - supprimer
        // Désactivation de l'action supprimer
        $this->class_actions[2] = null;

        // ACTION - 003 - consulter
        // Désactivation de l'action consulter
        $this->class_actions[3] = null;

        // ACTION - 4 - view_tab
        // Interface spécifique des l'onglet des dossiers liés
        $this->class_actions[4] = array(
            "identifier" => "view_tab",
            "view" => "view_tab",
            "permission_suffix" => "tab",
            "condition" => "can_user_access_dossier_all_context",
        );

        // ACTION - 5 - view_add
        // Interface spécifique des l'onglet des dossiers liés
        $this->class_actions[5] = array(
            "identifier" => "view_ajouter_liaison",
            "method" => "ajouter_liaison",
            "permission_suffix" => "ajouter",
            "crud" => "create",
            "condition" => "can_user_access_dossier_all_context",
        );
    }

    /**
     * CONDITION - is_ajoutable.
     *
     * Condition pour pouvoir ajouter
     *
     * @return boolean
     */
    function is_ajoutable() {
        // Si bypass
        if ($this->f->can_bypass($this->get_absolute_class_name(), "ajouter")) {
            return true;
        }
        // Teste si le dossier n'est pas cloturé
        // et si l'instructeur est de la même division
        if ($this->is_dossier_instruction_not_closed() === true
            && $this->is_instructeur_from_division_dossier() === true) {
            return true;
        }

        return false;
    }

    /**
     * VIEW - view_tab
     * 
     * Cette vue permet d'afficher l'interface spécifique du tableau
     * des dossiers liés.
     *
     * @return void
     */
    function view_tab() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Si le paramètre 'idxformulaire' n'est pas vide
        // (idxformulaire est la valeur de la clé primaire du DI)
        if ($this->f->get_submitted_get_value('idxformulaire') !== null and $this->f->get_submitted_get_value('idxformulaire') != '') {

            // Initialisation des variables
            $idx = $this->f->get_submitted_get_value('idxformulaire');
            $retourformulaire = ($this->f->get_submitted_get_value('retourformulaire') !== null) ? $this->f->get_submitted_get_value('retourformulaire') : "";
            $obj = ($this->f->get_submitted_get_value('obj') !== null) ? $this->f->get_submitted_get_value('obj') : "";

            if ($retourformulaire == "") {
                // Valeur par défaut de $retourformulaire
                $retourformulaire = 'dossier_instruction';
            }

            // Vérification de la visibilité du DA
            $da = $this->get_inst_dossier_instruction($idx);

            echo "<div id=\"sousform-href\"></div>";
            echo "<div id=\"sousform-" . $obj . "\">";
            echo "<div class=\"soustab-message\"></div>";
            echo "<div class=\"soustab-container\">";

            // Affichage du tableau des dossiers d'autorisation
            if ($da->is_dossier_autorisation_visible() === true) {
                $link_tab_dossier_autorisation = OM_ROUTE_SOUSTAB.'&obj=dossier_autorisation&idxformulaire='.$idx.'&retour=tab&retourformulaire='.$retourformulaire;
                printf('<div id="sousform-dossier_autorisation"></div>
                    <script type="text/javascript" >
                        ajaxIt(\'dossier_autorisation\', \'%1$s\');
                    </script>
                    ', $link_tab_dossier_autorisation);
            }

            // Affichage du tableau des dossiers d'instruction
            $link_tab_dossier_lies = OM_ROUTE_SOUSTAB.'&obj=dossier_lies&idxformulaire='.$idx.'&context=' . $obj . '&retour=tab&retourformulaire='.$retourformulaire;
            printf('<div id="tab_dossier_lies_href" data-href="%1$s"></div><div id="sousform-dossier_lies"></div>
                <script type="text/javascript" >
                    ajaxIt(\'dossier_lies\', \'%1$s\');
                </script>
                ', $link_tab_dossier_lies);

            // Affichage du tableau des dossiers d'instruction retour
            $link_tab_dossier_lies_retour = OM_ROUTE_SOUSTAB.'&obj=dossier_lies_retour&idxformulaire='.$idx.'&context=' . $obj . '&retour=tab&retourformulaire='.$retourformulaire;
            printf('<div id="tab_dossier_lies_retour_href" data-href="%1$s"></div><div id="sousform-dossier_lies_retour"></div>
                <script type="text/javascript" >
                    ajaxIt(\'dossier_lies_retour\', \'%1$s\');
                </script>
                ', $link_tab_dossier_lies_retour);


            // Affichage du tableau des dossiers d'autorisation liés géographiquement
            $link_tab_dossier_lies_geographiquement = OM_ROUTE_SOUSTAB.'&obj=dossier_lies_geographiquement&idxformulaire='.$idx.'&retour=tab&retourformulaire='.$retourformulaire;
            printf('<div id="sousform-dossier_lies_geographiquement"></div>
                <script type="text/javascript" >
                    ajaxIt(\'dossier_lies_geographiquement\', \'%1$s\');
                </script>
                ', $link_tab_dossier_lies_geographiquement);

            echo '</div></div>';
        }
    }


    /**
     * VIEW - ajouter_liaison
     * 
     * Cette vue permet de traiter les contraintes postées et d'afficher
     * le résultat de ce traitement en AJAX.
     *
     * @return void
     */
    function ajouter_liaison($val = array()) {
        $this->checkAccessibility();
        // Begin
        $this->begin_treatment(__METHOD__);
        // Mutateur de valF
        $this->setValF($val);
        // Mutateur de valF specifique a l'ajout
        $this->setValFAjout($val);
        // Verification de la validite des donnees
        $this->verifier($val, $this->f->db, null);
        // Verification specifique au MODE 'insert' de la validite des donnees
        $this->verifierAjout($val, $this->f->db);
        // Si les verifications precedentes sont correctes, on procede a
        // l'ajout, sinon on ne fait rien et on affiche un message d'echec
        if ($this->correct) {
            // Appel au mutateur pour le calcul de la cle primaire (si la cle
            // est automatique) specifique au MODE 'insert'
            $this->setId($this->f->db);
            // Execution du trigger 'before' specifique au MODE 'insert'
            // Le premier parametre est vide car en MODE 'insert'
            // l'enregistrement n'existe pas encore donc il n'a pas
            // d'identifiant
            if($this->triggerajouter("", $this->f->db, $val, null) === false) {
                $this->correct = false;
                $this->addToLog(__METHOD__."(): ERROR", DEBUG_MODE);
                // Return
                return $this->end_treatment(__METHOD__, false);
            }
            // Execution de la requete d'insertion des donnees de l'attribut
            // valF de l'objet dans l'attribut table de l'objet
            $res = $this->f->db->autoExecute(DB_PREFIXE.$this->table, $this->valF, DB_AUTOQUERY_INSERT);
            $this->addToLog(
                __METHOD__."(): db->autoexecute(\"".DB_PREFIXE.$this->table."\", ".print_r($this->valF, true).", DB_AUTOQUERY_INSERT);",
                VERBOSE_MODE
            );
            if ($this->f->isDatabaseError($res, true) !== false) {
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
                $this->correct = false;
                // Return
                return $this->end_treatment(__METHOD__, false);
            } else {
                //
                $main_res_affected_rows = $this->f->db->affectedRows();
                // Log
                $this->addToLog(__METHOD__."(): "._("Requete executee"), VERBOSE_MODE);
                // Execution du trigger 'after' specifique au MODE 'insert'
                // Le premier parametre est vide car en MODE 'insert'
                // l'enregistrement n'existe pas encore donc il n'a pas
                // d'identifiant
                if($this->triggerajouterapres($this->valF[$this->clePrimaire], $this->f->db, $val, null) === false) {
                    $this->correct = false;
                    $this->addToLog(__METHOD__."(): ERROR", DEBUG_MODE);
                    // Return
                    return $this->end_treatment(__METHOD__, false);
                }
                $messageAddSuccess = _("Le dossier %s a été lié.");
                $this->addToMessage(sprintf($messageAddSuccess, $this->valF['dossier_cible']));

                // Template du lien vers le DI
                $template_link_di = "<a id='link_dossier_instruction_lie' title=\"%s\" class='lien' href='".OM_ROUTE_FORM."&obj=dossier_instruction&action=777&idx=%s'>
                <span class='om-icon om-icon-16 om-icon-fix consult-16'></span>%s</a>";

                // Lien vers le DI
                $link_di = sprintf(
                    $template_link_di,
                    _("Acceder au dossier d'instruction"),
                    $this->valF['dossier_cible'],
                    _("Acceder au dossier d'instruction")
                );

                // Message affiché à l'utilisateur
                $this->addToMessage('<br/>'.$link_di);
            }
        } else {
            // Return
            return $this->end_treatment(__METHOD__, false);
        }
        // Return
        return $this->end_treatment(__METHOD__, true);
    }


    function setType(&$form,$maj) {
        parent::setType($form,$maj);

        //type
        $form->setType('lien_dossier_dossier','hidden');
        $form->setType('dossier_src','hidden');
        $form->setType('dossier_cible', 'text');
        $form->setType('type_lien','hidden');
    }

    function setLib(&$form,$maj) {
        parent::setLib($form,$maj);
        $form->setLib('dossier_cible', _("dossier cible"));
    }


    function setLayout(&$form, $maj) {
        

            // Col1 : Fieldset "Dossier d'Instruction"
            // $form->setBloc('dossier_cible', 'D', '', 'col_9');

                $form->setFieldset('dossier_cible', 'D', _("Lier un Dossier"));
                $form->setFieldset('dossier_cible', 'F');
                

            // $form->setBloc('dossier_cible', 'F');

    }


    function setvalF($val = array()) {
        //
        parent::setValF($val);
        //
        if ($this->getParameter('maj') == 5) {
            //
            $dossier = $this->getParameter("idxformulaire");
            //
            $this->valF["dossier_src"] = $dossier;
            $this->valF["dossier_cible"] = strtoupper(str_replace(" ", "", $this->f->db->escapesimple($this->valF["dossier_cible"])));
            $this->valF["type_lien"] = "manuel";
        }
    }

    function retoursousformulaire($idxformulaire = NULL, $retourformulaire = NULL, $val = NULL,
                                  $objsf = NULL, $premiersf = NULL, $tricolsf = NULL, $validation = NULL,
                                  $idx = NULL, $maj = NULL, $retour = NULL) {
        // bouton retour HTML
        echo sprintf("\n".
            '<a class="retour" href="#" id="sousform-action-%s-back-%s" data-href="%s">%s</a>'."\n",
            $objsf, uniqid(),
            sprintf(
                OM_ROUTE_SOUSFORM."&obj=%s&action=%d&idx=%s&retourformulaire=%s&idxformulaire=%s",
                $objsf, 4, 0 /* forçage de l'identifiant à zéro ? */, $retourformulaire, $idxformulaire
            ),
            __('Retour')
        );
    }

    /**
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        //parent::verifier($val);
        // Vérification des champs obligatoires
        $this->checkRequired();
        if ($this->correct === false) {
            return false;
        }

        // Un DI ne peut pas s'auto-lier
        $id_dossier_cible = str_replace(" ", "", $this->valF['dossier_cible']);
        if ($id_dossier_cible == $this->getParameter("idxformulaire")) {
            $this->correct = false;
            $this->addToMessage(_("Vous ne pouvez pas lier un dossier à lui-même. Saisissez un nouveau numéro puis recommencez."));
            return false;
        }

        // Vérification de l'existence du DI cible (avec gestion multi)
        $where_collectivite = "";
        if ($this->f->isCollectiviteMono($_SESSION["collectivite"]) === true) {
            $where_collectivite = sprintf(
                ' AND dossier.om_collectivite=%d ',
                intval($_SESSION["collectivite"])
            );
        }
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    count(*)
                FROM
                    %1$sdossier
                WHERE
                    dossier.dossier = \'%2$s\'
                    %3$s',
                DB_PREFIXE,
                $this->f->db->escapeSimple(strtoupper($id_dossier_cible)),
                $where_collectivite
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $count = $qres["result"];
        if ($count === '0') {
            $this->correct = false;
            $this->addToMessage(
                sprintf(
                    _("Il n'existe aucun dossier correspondant au numéro %s. Saisissez un nouveau numéro puis recommencez."),
                    $id_dossier_cible
                )
            );
            $this->form->setVal('dossier_cible', '');
            return false;
        }

        $inst_dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_instruction",
            "idx" => $id_dossier_cible,
        ));

        // Contrôle d'accès au groupe et aux dossiers confidentiels du groupe du dossier cible
        if ($inst_dossier->can_user_access_dossier() === false) {
            $this->correct = false;
            $this->addToMessage(
                sprintf(
                    _("Il n'existe aucun dossier correspondant au numéro %s. Saisissez un nouveau numéro puis recommencez."),
                    $id_dossier_cible
                )
            );
            $this->form->setVal('dossier_cible', '');
            return false;
        }

        // Vérification de l'existence d'un lien
        $type_link = $this->get_type_link($this->valF['dossier_src'], $this->valF['dossier_cible']);
        if ($type_link !== null) {
            switch ($type_link) {
                case 'manuel':
                    $message_deja_lie = _("Le dossier %s est déjà lié au dossier courant.");
                    break;
                case 'auto_recours':
                    $message_deja_lie = _("Le dossier %s est déjà lié au dossier courant (lien automatique).");
                    break;
                case 'lien_par_da':
                    $message_deja_lie = _("Le dossier %s est déjà lié au dossier courant (même dossier d'autorisation).");
                    break;
                default:
                    $message_deja_lie = _("L'existence d'une liaison entre le dossier courant et le %s n'a pas pu être vérifiée.");
                    $message_deja_lie .= '<br/>';
                    $message_deja_lie .= _("Veuillez contacter votre administrateur.");
                    break;
            }
            $this->addToMessage(sprintf($message_deja_lie, $id_dossier_cible));
            $this->correct = false;
            return false;
        }
    }

    /**
     * Récupère, s'il existe, le type du lien entre deux DI.
     *
     * Le lien peut être implicite (les DI ont le même DA) ou créé :
     *  - manuellement (lors de l'ajout par l'utilisateur) ;
     *  - automatiquement (lors de la création d'un DI contentieux).
     *
     * S'il s'agit d'une liaison implicite par le DA,
     * la notion de DI cible / source ne s'applique pas.
     *
     * Sinon elle s'applique et le lien est directionnel :
     * inverser les DI cible et source est susceptible de modifier le résultat.
     * 
     * @param   string  $dossier_src    ID du DI source
     * @param   string  $dossier_cible  ID du DI cible
     * @return  mixed   NULL si aucune  liaison sinon type du lien (STRING)
     */
    function get_type_link($dossier_src, $dossier_cible) {
        // On vérifie s'il y a une entrée dans la table de liaison pour le sens
        // indiqué en paramètres : si c'est le cas on retourne le type du lien trouvé.
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    type_lien
                FROM
                    %1$slien_dossier_dossier
                WHERE
                    dossier_src = \'%2$s\'
                    AND dossier_cible = \'%3$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple(strtoupper($dossier_src)),
                $this->f->db->escapeSimple(strtoupper($dossier_cible))
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $type_lien = $qres["result"];
        if ($type_lien !== null AND $type_lien !== '') {
            return $type_lien;
        }

        // Sinon on vérifie la présence d'une éventuelle liaison implicite par le DA.
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    count(*)
                FROM
                    %1$sdossier
                WHERE
                    dossier = \'%2$s\'
                    AND dossier_autorisation = (
                        SELECT
                            dossier_autorisation
                        FROM
                            %1$sdossier
                        WHERE
                            dossier = \'%3$s\'
                    )',
                DB_PREFIXE,
                $this->f->db->escapeSimple(strtoupper($dossier_cible)),
                $this->f->db->escapeSimple(strtoupper($dossier_src))
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if ($qres["result"] === '1') {
            return 'lien_par_da';
        }

        // Sinon aucun lien n'a été trouvé.
        return null;
    }

    /**
     * Récupère l'instance du dossier d'instruction.
     *
     * @param string $dossier_instruction Identifiant du dossier d'instruction.
     *
     * @return object
     */
    function get_inst_dossier_instruction($dossier_instruction = null) {
        //
        return $this->get_inst_common("dossier_instruction", $dossier_instruction);
    }

    /*
     * CONDITION - can_user_access_dossier_all_context
     *
     * Vérifie que l'utilisateur a bien accès au dossier d'instruction.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_all_context() {

        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $id_dossier = 
            $this->f->get_submitted_get_value('idxformulaire') : $id_dossier = "");
        //
        if ($id_dossier !== "") {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        // Surcharge la méthode pour ne pas initialiser les select des champs
        // dossier_cible et dossier_src qui récupère la liste complète des
        // dossiers d'instructions
        //parent::setSelect($form, $maj);
    }

    /**
     * Indique si la redirection vers le lien de retour est activée ou non.
     *
     * L'objectif de cette méthode est de permettre d'activer ou de désactiver
     * la redirection dans certains contextes.
     *
     * @return boolean
     */
    function is_back_link_redirect_activated() {
        //
        return false;
    }

    /**
     * SETTER_FORM - set_form_default_values (setVal).
     *
     * @return void
     */
    function set_form_default_values(&$form, $maj, $validation) {
        parent::set_form_default_values($form, $maj, $validation);
        // Il est nécessaire de définir des valeurs par défaut pour chaque
        // champ en maj = 5 car la classe om_formulaire ne gère pas le crud
        // create et ne les intiialise pas par défaut ce qui cause des
        // notices.
        if ($validation == 0 && $maj == 5) {
            foreach ($this->champs as $key => $value) {
                $form->setVal($value, "");
            }
        }
    }
}


