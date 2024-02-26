<?php
/**
 * DBFORM - 'commission' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'commission'.
 *
 * @package openads
 * @version SVN : $Id: commission.class.php 4824 2015-06-15 05:58:07Z fmichon $
 */

require_once "../gen/obj/commission.class.php";

/**
 * Définition de la classe 'commission'.
 *
 * Cette classe permet d'interfacer la commission, c'est-à-dire
 * l'enregistrement représentant ...
 */
class commission extends commission_gen {

    /**
     * Champs contenant les UID des fichiers.
     */
    var $abstract_type = array(
        "om_fichier_commission_ordre_jour" => "file",
        "om_fichier_commission_compte_rendu" => "file",
    );

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 011 - diffuser_ordre_jour
        //
        $this->class_actions[11] = array(
            "identifier" => "diffuser_ordre_jour",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("(OJ) Diffuser l'OJ"),
                "order" => 28,
                "class" => "transferer-16",
            ),
            "view" => "formulaire",
            "method" => "diffuse_document",
            "button" => "diffuser_ordre_jour",
            "permission_suffix" => "diffuser_ordre_jour",
        );

        // ACTION - 012 - diffuser_compte_rendu
        //
        $this->class_actions[12] = array(
            "identifier" => "diffuser_compte_rendu",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("(CR) Diffuser le CR"),
                "order" => 29,
                "class" => "transferer-16",
            ),
            "view" => "formulaire",
            "method" => "diffuse_document",
            "button" => "diffuser_compte_rendu",
            "permission_suffix" => "diffuser_compte_rendu",
        );

        // ACTION - 021 - edition_proposition_ordre_jour
        //
        $this->class_actions[21] = array(
            "identifier" => "edition_proposition_ordre_jour",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("(OJ) Proposition"),
                "order" => 30,
                "class" => "pdf-16",
            ),
            "view" => "view_edition_pdf",
            "permission_suffix" => "consulter",
        );

        // ACTION - 022 - edition_ordre_jour
        //
        $this->class_actions[22] = array(
            "identifier" => "edition_ordre_jour",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("(OJ) Ordre du jour"),
                "order" => 31,
                "class" => "pdf-16",
            ),
            "view" => "view_edition_pdf",
            "permission_suffix" => "consulter",
        );

        // ACTION - 023 - edition_compte_rendu
        //
        $this->class_actions[23] = array(
            "identifier" => "edition_compte_rendu",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("(CR) Compte-rendu"),
                "order" => 32,
                "class" => "pdf-16",
            ),
            "view" => "view_edition_pdf",
            "permission_suffix" => "consulter",
        );

        // ACTION - 031 - view_plan_or_unplan_demands
        //
        $this->class_actions[31] = array(
            "identifier" => "view_form_plan_or_unplan_demands",
            "view" => "view_form_plan_or_unplan_demands",
            "permission_suffix" => "dossiers_planifier_retirer",
            "button" => _("Valider"),
        );

        // ACTION - 032 - view_form_add_and_plan_demand
        //
        $this->class_actions[32] = array(
            "identifier" => "view_form_add_and_plan_demand",
            "view" => "view_form_add_and_plan_demand",
            "permission_suffix" => "dossiers_planifier_retirer",
            "button" => _("Valider"),
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "commission",
            "code",
            "om_collectivite",
            "commission_type",
            "libelle",
            "date_commission",
            "heure_commission",
            "lieu_adresse_ligne1",
            "lieu_adresse_ligne2",
            "lieu_salle",
            "listes_de_diffusion",
            "participants",
            "om_fichier_commission_ordre_jour",
            "om_final_commission_ordre_jour",
            "om_fichier_commission_compte_rendu",
            "om_final_commission_compte_rendu",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite WHERE om_collectivite.niveau = '1' ORDER BY om_collectivite.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commission_type_by_collectivite() {
        return "SELECT commission_type.commission_type, commission_type.libelle FROM ".DB_PREFIXE."commission_type WHERE ((commission_type.om_validite_debut IS NULL AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE)) OR (commission_type.om_validite_debut <= CURRENT_DATE AND (commission_type.om_validite_fin IS NULL OR commission_type.om_validite_fin > CURRENT_DATE))) AND commission_type.om_collectivite = <id_collectivite> ORDER BY commission_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commission_type_no_result() {
        return "SELECT commission_type.commission_type, commission_type.libelle FROM ".DB_PREFIXE."commission_type WHERE 0 = 1";
    }

    /**
     * Instance de la classe commission_type.
     *
     * @var mixed (resource | null)
     */
    var $inst_commission_type = null;

    /**
     * Récupère l'instance du type de commission.
     *
     * @param string $commission_type Identifiant du type de commission.
     *
     * @return object
     */
    function get_inst_commission_type($commission_type = null) {
        //
        return $this->get_inst_common("commission_type", $commission_type);
    }

    /**
     *
     */
    function setType(&$form, $maj) {
        //
        parent::setType($form, $maj);
        
        // Cache le champ code en ajout
        if ($maj == 0) {
            
            $form->setType('code', 'hidden');
        }
        
        if ($maj > 0) {
            // Le type de commission n'est pas modifiable une fois la commission ajoutée
            $form->setType('commission_type', 'selecthiddenstatic');
            $form->setType('om_collectivite', 'selecthiddenstatic');

            $form->setType('code', 'hiddenstatic');
        }
        // On définit le type des champs pour les actions direct
        // utilisant la vue formulaire
        if ($maj == 11 || $maj == 12) {
            foreach ($this->champs as $key => $value) {
                $form->setType($value, 'hidden');
            }
        }

        //Cache les champs pour la finalisation
        $form->setType('om_fichier_commission_ordre_jour', 'hidden');
        $form->setType('om_final_commission_ordre_jour', 'hidden');
        $form->setType('om_fichier_commission_compte_rendu', 'hidden');
        $form->setType('om_final_commission_compte_rendu', 'hidden');
    }

    /**
     *
     */
    function setOnchange(&$form, $maj) {
        //
        parent::setOnchange($form, $maj);
        // Action javascript au changement du type de la commission
        $form->setOnchange(
            "commission_type",
            "commission_update_data_from_commission_type(this.value);"
        );
        $form->setOnchange(
            "om_collectivite",
            "changeCommissionType();"
        );
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        //parent::setVal($form, $maj, $validation);
        //
        if ($maj == 0) {
            // Date du jour par défaut
            $form->setVal("date_commission", date('d/m/Y'));
            // Bride de collectivité pour les niveaux mono
            if ($_SESSION['niveau'] == 1) {
                $form->setVal("om_collectivite", $_SESSION["collectivite"]);
            }
        }
    }

    /**
     *
     */
    function setvalF($val = array()) {
        //
        parent::setValF($val);

        // Génération automatique du code de la commission
        // Récupération du code du type de la commission
        $commission_type_code = "";
        if (isset($val['commission_type'])
            && is_numeric($val['commission_type'])) {
            //
            $inst_commission_type = $this->get_inst_commission_type($val['commission_type']);
            $commission_type_code = $inst_commission_type->getVal("code");
        }
        //Formatte la date
        $dateFormatee = $this->formatDate($val['date_commission']);

        //
        $this->valF['code'] = $commission_type_code.$dateFormatee;
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        $crud = $this->get_action_crud($maj);
        // Le but ici est de brider les types aux types de la même commune que le dossier en cas d'ajout
        if ($crud == 'create' OR ($crud === null AND $maj == 0)) {
            if ($_SESSION["niveau"] == 2) {
                // om_collectivite
                $this->init_select(
                    $form,
                    $this->f->db,
                    $maj,
                    null,
                    "om_collectivite",
                    $this->get_var_sql_forminc__sql("om_collectivite"),
                    $this->get_var_sql_forminc__sql("om_collectivite_by_id"),
                    false
                );
            }
            if ($this->getParameter("om_collectivite") != null) {
                $sql_commission_type_by_collectivite = str_replace(
                    '<id_collectivite>',
                    $this->getParameter("om_collectivite"),
                    $this->get_var_sql_forminc__sql("commission_type_by_collectivite")
                );
                $this->init_select(
                    $form,
                    $this->f->db,
                    $maj,
                    null,
                    "commission_type",
                    $sql_commission_type_by_collectivite,
                    $this->get_var_sql_forminc__sql("commission_type_by_id"),
                    true
                );
            } elseif ($_SESSION["niveau"] == 2) {
                $this->init_select(
                    $form,
                    $this->f->db,
                    $maj,
                    null,
                    "commission_type",
                    $this->get_var_sql_forminc__sql("commission_type_no_result"),
                    $this->get_var_sql_forminc__sql("commission_type_by_id"),
                    true
                );
            }
        }
    }

    /**
     * Prend une date au format JJ/MM/AAAA et retourne AAAAMMJJ
     */
    function formatDate($date) {
        $dateFormatee = explode('/', $date);
        $dateFormatee = $dateFormatee[2].$dateFormatee[1].$dateFormatee[0];
        return $dateFormatee;
    }

    /**
     *
     */
    function afterFormSpecificContent() {
        //Le sous-formulaire spécifique ne s'affiche qu'en consultation
        if ($this->getParameter("maj") == 3) {
            $this->view_manage();
        }
    }

    /**
     * VIEW - view_manage.
     *
     * @return void
     */
    function view_manage() {

        // Identifiant de l'enregistrement
        $idx = $this->getVal($this->clePrimaire);

        //
        printf(
            '
            <div id="commission-manage-tabs">
            <ul>
                <li><a href="'.OM_ROUTE_SOUSTAB.'&obj=dossier_commission&idxformulaire=%1$s&retourformulaire=commission" id="dossier_planifie">%2$s</a></li>
                <li><a href="'.OM_ROUTE_FORM.'&obj=commission&action=31&idx=%1$s" id="commission_dossiers_planifier_retirer">%3$s</a></li>
                <li><a href="'.OM_ROUTE_FORM.'&obj=commission&action=32&idx=%1$s" id="commission_dossiers_planifier_numero">%4$s</a></li>
            </ul>
            </div>',
            $idx,
            _("les dossiers planifies"),
            _("planifier/retirer des dossiers"),
            _("planifier un dossier specifique")
        );

    }

    /**
     * VIEW - view_edition_pdf.
     *
     * Edite l'édition de l'instruction ou affiche celle contenue dans le stockage.
     *
     * @return void
     */
    function view_edition_pdf() {

        //
        $this->checkAccessibility();
        // Identifiant de l'enregistrement
        $idx = $this->getVal($this->clePrimaire);

        /**
         * Définition des paramètres.
         */
        //
        if ($this->getParameter("maj") == 21) {
            $obj = "commission_proposition_ordre_jour";
        } elseif ($this->getParameter("maj") == 22) {
            $obj = "commission_ordre_jour";
            $mention = "OJ";
            $type = "de l'ordre du jour";
            $field_uid = "om_fichier_commission_ordre_jour";
            $field_final = "om_final_commission_ordre_jour";
        } elseif ($this->getParameter("maj") == 23) {
            $obj = "commission_compte_rendu";
            $mention = "CR";
            $type = "du compte-rendu";
            $field_uid = "om_fichier_commission_compte_rendu";
            $field_final = "om_final_commission_compte_rendu";
        }

        // Si l'instruction est finalisée
        if (isset($field_final)
            && $this->getVal($field_final) == 't'
            && $this->getVal($field_final) != null) {
            // Ouvre le document
            $lien = '../app/index.php?module=form&snippet=file&obj='.$this->table.'&'.
                    'champ='.$field_uid.'&id='.$this->getVal($this->clePrimaire);
            //
            header("Location: ".$lien);
        } else {

            // Génération du PDF
            $collectivite = $this->f->getCollectivite($this->getVal("om_collectivite"));
            $result = $this->compute_pdf_output(
                'etat',
                $obj,
                $collectivite,
                $idx
            );
            // Affichage du PDF
            $this->expose_pdf_output(
                $result['pdf_output'],
                $result['filename']
            );
        }
    }

    /**
     * VIEW - view_form_plan_or_unplan_demands.
     *
     * @return void
     */
    function view_form_plan_or_unplan_demands() {

        //
        $this->checkAccessibility();
        // Identifiant de l'enregistrement
        $idx = $this->getVal($this->clePrimaire);

        //
        if (!isset($_POST["dossier"])) {
            //
            printf('<div id="view_form_plan_or_unplan_demands">');
            //
            printf('<div id="sousform-plan_or_unplan_demands">');
        }

        // Treatment
        if (isset($_POST["dossier"])) {
            //
            $dossier_commission_all_ids = array();
            $dossier_commission_checkeds = array();
            //
            $posted_dossier = $this->f->get_submitted_post_value('dossier');
            $posted_checkeds = $this->f->get_submitted_post_value('checkeds');
            //
            foreach ($posted_dossier as $key => $value) {
                $plop = explode("_", $value);
                if (count($plop) == 2) {
                    $dossier_commission_all_ids[$plop[0]] = array(
                        "dossier_commission_id" => $plop[0],
                        "dossier" => $plop[1],
                    );
                }
            }
            foreach (explode(";", $posted_checkeds) as $key => $value) {
                $plop = explode("_", $value);
                if (count($plop) == 2) {
                    $dossier_commission_checkeds[$plop[0]] = array(
                        "dossier_commission_id" => $plop[0],
                        "dossier" => $plop[1],
                    );
                }
            }
            //
            $planned = array_keys($dossier_commission_checkeds);
            $unplanned = array_diff(
                array_keys($dossier_commission_all_ids),
                array_keys($dossier_commission_checkeds)
            );
            //
            $ret = $this->update_planning(
                array(
                    "planned" => $planned,
                    "unplanned" => $unplanned,
                )
            );
            $this->message();
        }

        // Formulaire
        printf(
            '
            <!-- ########## START DBFORM ########## -->
            <form 
                method="post" action=""
                onsubmit="commission_submit_plan_or_unplan_demands(\'plan_or_unplan_demands\', \'%s\', this);return false;">',
            $this->getDataSubmit()
        );

        /**
         *
         */
        //
        $sql = 'SELECT
                dossier_commission.dossier_commission AS "dossier_commission_id",
                dossier_commission.dossier AS "dossier",
                dossier.dossier_libelle AS "dossier_libelle",
                CASE WHEN demandeur.qualite = \'particulier\' 
                    THEN TRIM(
                        CONCAT(
                            demandeur.particulier_nom,
                            \' \',
                            demandeur.particulier_prenom
                        )
                    )
                    ELSE TRIM(
                        CONCAT(
                            demandeur.personne_morale_raison_sociale,
                            \' \',
                            demandeur.personne_morale_denomination
                        )
                    )
                END AS "demandeur",
                TRIM(
                    CASE
                        WHEN dossier.adresse_normalisee IS NULL
                            OR TRIM(dossier.adresse_normalisee) = \'\'
                        THEN
                            CONCAT_WS(
                                \' \',
                                dossier.terrain_adresse_voie_numero,
                                dossier.terrain_adresse_voie,
                                dossier.terrain_adresse_code_postal
                            )
                        ELSE
                            dossier.adresse_normalisee
                    END
                ) AS "terrain",
                instructeur.nom AS "instructeur",
                dossier_commission.motivation AS "motivation",
                to_char(dossier_commission.date_souhaitee, \'DD/MM/YYYY\') AS "date_souhaitee",
                to_char(dossier.date_limite, \'DD/MM/YYYY\') AS "date_limite",
                etat.libelle AS "etat",
                dossier_commission.avis AS "avis"
            FROM
                %1$sdossier_commission
                LEFT JOIN %1$sdossier
                    ON dossier_commission.dossier = dossier.dossier
                LEFT JOIN %1$sdossier_instruction_type
                    ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                LEFT JOIN %1$setat
                    ON dossier.etat = etat.etat
                LEFT JOIN (
                    SELECT
                        *
                    FROM
                        %1$slien_dossier_demandeur
                        INNER JOIN %1$sdemandeur
                            ON demandeur.demandeur = lien_dossier_demandeur.demandeur
                    WHERE
                        lien_dossier_demandeur.petitionnaire_principal IS TRUE
                        AND LOWER(demandeur.type_demandeur) = LOWER(\'petitionnaire\')
                ) AS "demandeur"
                    ON demandeur.dossier = dossier.dossier
                LEFT JOIN %1$sinstructeur
                    ON dossier.instructeur = instructeur.instructeur
            %2$s
            ORDER BY
                dossier_commission.avis DESC NULLS LAST,
                dossier';
        
        // Demandes déjà rattachées à la commission.
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                $sql,
                DB_PREFIXE,
                sprintf(
                    'WHERE
                        dossier_commission.commission = \'%d \'
                        AND dossier_instruction_type.sous_dossier IS NOT TRUE',
                    intVal($idx)
                )
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Demandes rattachables à la commission.
        $qresAjout = $this->f->get_all_results_from_db_query(
            sprintf(
                $sql,
                DB_PREFIXE,
                sprintf(
                    'WHERE
                        dossier_commission.commission IS NULL
                        AND dossier_commission.commission_type = ( 
                            SELECT
                                commission_type
                            FROM
                                %1$scommission
                            WHERE
                                commission.commission = \'%2$d\'
                        )',
                    DB_PREFIXE,
                    intVal($idx)
                )
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        /**
         * Aucun résultat. On affiche un message explicite à l'utilisateur
         * et on sort de la view.
         */
        if ($qres['row_count'] == 0 && $qresAjout['row_count'] == 0) {
            echo _("Aucune demande de passage pour ce type de commission.");
            return;
        }

        /**
         * Définition des templates HTML pour l'affichage du tableau.
         */
        //
        $template_table = '
        <table class="tab-tab">%s
        <tbody>%s
        </tbody>
        </table>
        ';
        //
        $template_head = '
        <thead>
            <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                <th class="title col-0 firstcol"><span class="name"></span></th>
                <th class="title col-0 firstcol"><span class="name">%s</span></th>
                <th class="title col-0 firstcol"><span class="name">%s</span></th>
                <th class="title col-0 firstcol"><span class="name">%s</span></th>
                <th class="title col-0 firstcol"><span class="name">%s</span></th>
                <th class="title col-0 firstcol"><span class="name">%s</span></th>
                <th class="title col-0 firstcol"><span class="name">%s</span></th>
                <th class="title col-0 firstcol"><span class="name">%s</span></th>
                <th class="title col-0 firstcol"><span class="name">%s</span></th>
                <th class="title col-0 firstcol"><span class="name">%s</span></th>
            </tr>
        </thead>';
        //
        $template_line = '
        <tr class="tab-data odd" id="dossier_commission-%s">
            <td class="icons">
                <input type="checkbox"%s name="dossier[]" value="%s"%s />
            </td>
            <td class="col-1 firstcol">%s</td>
            <td class="col-1 firstcol">%s</td>
            <td class="col-1">%s</td>
            <td class="col-2 lastcol">%s</td>
            <td class="col-2 lastcol">%s</td>
            <td class="col-2 lastcol">%s</td>
            <td class="col-2 lastcol">%s</td>
            <td class="col-2 lastcol">%s</td>
            <td class="col-2 lastcol">%s</td>
        </tr>';

        /**
         * Affichage du tableau.
         */
        //
        $ct_head = sprintf(
            $template_head,
            _('id'),
            _('dossier'),
            _('demandeur'),
            _('terrain'),
            _('instructeur'),
            _('motivation'),
            _('date_souhaitee'),
            _('date_limite'),
            _('etat')
        );
        //
        $ct_body = "";
        //
        foreach($qres['result'] as $row) {
            $ct_body .= sprintf(
                $template_line,
                $row['dossier'],
                ' checked="checked"',
                $row['dossier_commission_id']."_".$row['dossier'],
                ($row['avis'] != '' ? 'disabled="disabled"' : ''),
                $row['dossier_commission_id'],
                $row['dossier_libelle'],
                $row['demandeur'],
                $row['terrain'],
                $row['instructeur'],
                $row['motivation'],
                $this->f->formatDate($row['date_souhaitee']),
                $this->f->formatDate($row['date_limite']),
                $this->f->formatDate($row['etat'])
            );
        }
        //
        foreach($qresAjout['result'] as $row) {
            $ct_body .= sprintf(
                $template_line,
                $row['dossier'],
                '',
                $row['dossier_commission_id']."_".$row['dossier'],
                '',
                $row['dossier_commission_id'],
                $row['dossier_libelle'],
                $row['demandeur'],
                $row['terrain'],
                $row['instructeur'],
                $row['motivation'],
                $this->f->formatDate($row['date_souhaitee']),
                $this->f->formatDate($row['date_limite']),
                $this->f->formatDate($row['etat'])
            );
        }
        //
        printf($template_table, $ct_head, $ct_body);

        /**
         * Affichage du bouton de validation.
         */
        echo "\t<div class=\"formControls\">\n";
        $correct = $this->correct;
        $this->correct = false;
        $this->bouton($this->getParameter("maj"));
        $this->correct = $correct;
        echo "\t</div>\n";

        //
        printf('</form>');

        //
        if (isset($_POST["dossier"])) {
            printf('</div>');
            printf('</div>');
        }

    }

    /**
     * VIEW - view_form_add_and_plan_demand.
     *
     * @return void
     */
    function view_form_add_and_plan_demand() {

        //
        $this->checkAccessibility();
        // Identifiant de l'enregistrement
        $idx = $this->getVal($this->clePrimaire);

        //
        if (!isset($_POST["dossier"])) {
            //
            printf('<div id="view_form_add_and_plan_demand">');
            //
            printf('<div id="sousform-add_and_plan_demand">');
        }

        // Treatment
        if (isset($_POST["dossier"])) {
            $ret = $this->add_and_plan_demand(
                array(
                    "dossier" => $this->f->get_submitted_post_value('dossier'),
                )
            );
            $this->message();
        }

        // Formulaire
        printf(
            '
            <!-- ########## START DBFORM ########## -->
            <form 
                method="post" action=""
                onsubmit="affichersform(\'add_and_plan_demand\', \'%s\', this);return false;">',
            $this->getDataSubmit()
        );

        // Le formulaire a un seul champ : dossier
        $champs = array("dossier");
        // Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        // Caractéristique du champ
        $form->setLib("dossier", _("No de dossier")." :");
        $form->setType("dossier", "text");
        $form->setTaille("dossier", 25);
        $form->setMax("dossier", 25);
        //
        $form->afficher($champs, 0, false, false);
        //
        echo "\t<div class=\"formControls\">\n";
        $correct = $this->correct;
        $this->correct = false;
        $this->bouton($this->getParameter("maj"));
        $this->correct = $correct;
        echo "\t</div>\n";
        //
        printf('</form>');

        //
        if (isset($_POST["dossier"])) {
            printf('</div>');
            printf('</div>');
        }

    }

    /**
     * TREATMENT - update_planning.
     *
     * @return boolean
     */
    function update_planning($val = array()) {
        //
        $this->begin_treatment(__METHOD__);
        // Identifiant de l'enregistrement
        $idx = $this->getVal($this->clePrimaire);

        //
        if (isset($val["planned"])
            && is_array($val["planned"])
            && count($val["planned"]) != 0) {
            // Mise à jour des éléments checked
            $sql = "UPDATE ".DB_PREFIXE."dossier_commission SET commission=".$idx."
            WHERE dossier_commission in (".implode(",", $val["planned"]).") 
            AND (commission IS NULL OR commission = ".$idx.")";
            $res = $this->f->db->query($sql);
            $this->f->addToLog(
                __METHOD__."(): db->query(\"".$sql."\");",
                VERBOSE_MODE
            );
            $this->f->isDatabaseError($res);
            //
            if (count($val["planned"]) != $this->f->db->affectedRows()) {
                $this->correct = false;
                $this->addToMessage(_("Erreur lors de la mise à jour de la planification."));
                return $this->end_treatment(__METHOD__, false);
            }
        }

        if (isset($val["unplanned"])
            && is_array($val["unplanned"])
            && count($val["unplanned"]) != 0) {
            // Mise à jour des éléments unchecked
            $sql = "UPDATE ".DB_PREFIXE."dossier_commission SET commission=null
            WHERE dossier_commission in (".implode(",", $val["unplanned"]).") AND (avis = '' OR avis IS NULL)";
            $res = $this->f->db->query($sql);
            $this->f->addToLog(
                __METHOD__."(): db->query(\"".$sql."\");",
                VERBOSE_MODE
            );
            $this->f->isDatabaseError($res);
            //
            if (count($val["unplanned"]) != $this->f->db->affectedRows()) {
                $this->correct = false;
                $this->addToMessage(_("Erreur lors de la mise à jour de la planification."));
                return $this->end_treatment(__METHOD__, false);
            }
        }
        //
        $this->addToMessage(_("Mise à jour de la planification effectuée."));
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * TREATMENT - add_and_plan_demand.
     *
     * @return boolean
     */
    function add_and_plan_demand($val = array()) {
        //
        $this->begin_treatment(__METHOD__);
        // Identifiant de l'enregistrement
        $idx = $this->getVal($this->clePrimaire);

        // Vérification de l'existence du paramètre
        if (!isset($val["dossier"]) || $val["dossier"] === "") {
            $this->correct = false;
            $this->addToMessage(_("Aucun numero de dossier saisi."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Vérification de l'existence du dossier
        $dossier = $val["dossier"];

        $qresDossier = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier, 
                    om_collectivite
                FROM
                    %1$sdossier
                    INNER JOIN %1$sdossier_instruction_type
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    INNER JOIN %1$sdossier_autorisation_type_detaille
                        ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    INNER JOIN %1$sdossier_autorisation_type
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                    INNER JOIN %1$sgroupe
                        ON dossier_autorisation_type.groupe = groupe.groupe
                            AND groupe.code != \'CTX\'
                WHERE
                    dossier = \'%2$s\' ',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        // Si le dossier n'existe pas
        if ($qresDossier['row_count'] == 0) {
            $this->correct = false;
            $this->addToMessage(_("Ce dossier n'existe pas."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Teste si le dossier est déjà à l'ordre du jour
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier
                FROM
                    %1$sdossier_commission 
                WHERE
                    dossier = \'%2$s\' 
                AND 
                    dossier_commission.commission = %3$d',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier),
                intVal($idx)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Le dossier est déjà à l'ordre du jour
        if ($qres['row_count'] != 0) {
            $this->correct = false;
            $this->addToMessage(_("Ce dossier est deja a l'ordre du jour."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Récupération du type de commission
        $inst_commission_type = $this->get_inst_commission_type();
        $commission_type_id = $inst_commission_type->getVal($inst_commission_type->clePrimaire);
        $rowDossier = array_shift($qresDossier['result']);
        // On vérifie que le type de commission est de la même collectivité que le dossier
        if ($inst_commission_type->getVal("om_collectivite") != $rowDossier['om_collectivite']) {
            $this->correct = false;
            $this->addToMessage(_("Ce dossier n'existe pas."));
            return $this->end_treatment(__METHOD__, false);

        }

        // Tableau des données du nouveau dossier à passer en commission
        $data = array(
            "dossier_commission" => null,
            "dossier" => $dossier,
            "commission_type" => $commission_type_id,
            "date_souhaitee" => date("d/m/Y"),
            "motivation" => null,
            "commission" => $idx,
            "avis" => null,
            "lu" => false,
        );

        // Ajout du nouveau dossier
        $dossier_commission = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_commission",
            "idx" => "]",
        ));
        $ret = $dossier_commission->ajouter($data);
        if ($ret !== true) {
            $this->correct = false;
            $this->addToMessage(_("Une erreur s'est produite lors de l'ajout de ce dossier. Veuillez contacter votre administrateur."));
            return $this->end_treatment(__METHOD__, false);
        }

        // Le dossier a bien été ajouté
        $this->addToMessage(_("Dossier ajoute avec succes."));
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * TREATMENT - diffuse_document.
     *
     * @return boolean
     */
    function diffuse_document($val = array()) {
        //
        $this->begin_treatment(__METHOD__);
        // Identifiant de l'enregistrement
        $idx = $this->getVal($this->clePrimaire);

        /**
         * Définition des paramètres.
         */
        //
        if ($this->getParameter("maj") == 11) {
            $obj = "commission_ordre_jour";
            $mention = "OJ";
            $type = "de l'ordre du jour";
            $champ = "ordre_jour";
        } elseif ($this->getParameter("maj") == 12) {
            $obj = "commission_compte_rendu";
            $mention = "CR";
            $type = "du compte-rendu";
            $champ = "compte_rendu";
        }

        /**
         * Composition du PDF.
         */
        //
        $collectivite = $this->f->getCollectivite($this->getVal("om_collectivite"));
        $pdf_result = $this->compute_pdf_output(
            "etat",
            $obj,
            $collectivite,
            $idx
        );

        /**
         * Envoi du mail.
         */
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    commission.listes_de_diffusion AS listes_de_diffusion, 
                    commission.code AS code, 
                    to_char(commission.date_commission, \'DD/MM/YYYY\') AS date_commission,
                    commission.libelle AS libelle,
                    commission_type.corps_du_courriel AS corps_du_courriel
                FROM
                    %1$scommission 
                    LEFT JOIN %1$scommission_type 
                        ON commission.commission_type = commission_type.commission_type
                WHERE
                    commission.commission = %2$d',
                DB_PREFIXE,
                intVal($idx)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $row = array_shift($qres['result']);
        //
        $titre = "[".$mention."] ".$row['date_commission']." ".$row['libelle'];
        //
        $corps = $row['corps_du_courriel'];
        //
        $listes_de_diffusion = str_replace(
            "\r\n",
            ',',
            $row['listes_de_diffusion']
        );
        //
        $piece_jointe = array(
            "content" => $pdf_result['pdf_output'],
            "title" => $mention."_".str_replace('/', '-', $row['date_commission'])."_".$row['code'].".pdf",
            "stream" => '',
        );
        //
        $ret = $this->f->sendMail(
            $titre,
            $corps,
            $listes_de_diffusion,
            array($piece_jointe)
        );

        /**
         * Si une erreur survient lors de l'envoi du mail, on stoppe le traitement.
         */
        //
        if ($ret !== true) {
            $this->addToMessage(
                sprintf(
                    _("Une erreur s'est produite lors de la diffusion %s. Veuillez contacter votre administrateur."),
                    $type
                )
            );
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }

        /**
         *
         */
        $ret = $this->finalise_document(array("champ" => $champ, ));
        if ($ret !== true) {
            $this->addToMessage(_("Une erreur s'est produite lors de la finalisation du document."));
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }

        /**
         *
         */
        $this->addToMessage(
            sprintf(
                _("La diffusion %s s'est effectuée avec succès."),
                $type
            )
        );
        $this->correct = true;
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * TREATMENT - finalise_document.
     *
     * Finalisation des documents.
     *
     * @return boolean
     */
    function finalise_document($val = array()) {
        //
        $this->begin_treatment(__METHOD__);
        // Identifiant de l'enregistrement
        $idx = $this->getVal($this->clePrimaire);
        //
        $champ = $val["champ"];

        /**
         * Génération du fichier PDF et de ses métadonnées avant le stockage.
         */
        // Génération du fichier PDF.
        $collectivite = $this->f->getCollectivite($this->getVal("om_collectivite"));
        $pdf_result = $this->compute_pdf_output(
            "etat",
            'commission_'.$champ,
            $collectivite,
            $idx
        );
        // Composition des métadonnées du document.
        $metadata = array_merge(
            array(
                'filename' => 'commission_'.$champ.'_'.$idx.'.pdf',
                'mimetype' => 'application/pdf',
                'size' => strlen($pdf_result["pdf_output"])
            ),
            $this->getMetadata("om_fichier_commission_".$champ)
        );
        //Si le document a déjà été finalisé
        //on met à jour le document mais pas son uid
        if ( $this->getVal("om_final_commission_".$champ) != 'f' ){
            $uid = $this->f->storage->update(
                $this->getVal("om_fichier_commission_".$champ), $pdf_result["pdf_output"], $metadata);
        }
        //Sinon, on joute le document et on récupère son uid
        else {
            //Stockage du PDF
            $uid = $this->f->storage->create($pdf_result["pdf_output"], $metadata, "from_content", $this->table.".".$champ);
        }

        // Si le document n'a pas pu être stocké
        if ($uid == "" || $uid == 'OP_FAILURE') {
            $log_msg_error = "Finalisation non enregistrée - id commission_%s = %s - uid fichier = %s";
            $this->addToLog(sprintf($log_msg_error, $champ, $idx, $uid), DEBUG_MODE);
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }

        // Modifie uniquement les valeurs des champs concernant la finalisation
        // du document
        $valF = array(
            "om_final_commission_".$champ => true,
            "om_fichier_commission_".$champ => $uid
        );
        // Execution de la requête de modification des donnees de l'attribut
        // valF de l'objet dans l'attribut table de l'objet
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.$this->table,
            $valF,
            DB_AUTOQUERY_UPDATE,
            $this->getCle($idx)
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getCle($idx)."\")",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res)) { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }

        // Log
        $this->addToLog(_("Requete executee"), VERBOSE_MODE);
        // Log
        $message = _("Enregistrement")."&nbsp;".$idx."&nbsp;";
        $message .= _("de la table")."&nbsp;\"".$this->table."\"&nbsp;";
        $message .= "[&nbsp;".$this->f->db->affectedRows()."&nbsp;";
        $message .= _("enregistrement(s) mis a jour")."&nbsp;]";
        $this->addToLog($message, VERBOSE_MODE);
        //
        return $this->end_treatment(__METHOD__, true);

    }

    // {{{ Gestion des métadonnées pour les fichiers

    /**
     *
     */
    var $metadata = array(
        "om_fichier_commission_ordre_jour" => array(
            "dossier" => "getDossier",
            "dossier_version" => "getDossierVersion",
            "numDemandeAutor" => "getNumDemandeAutor",
            "anneemoisDemandeAutor" => "getAnneemoisDemandeAutor",
            "typeInstruction" => "getTypeInstruction",
            "statutAutorisation" => "getStatutAutorisation",
            "typeAutorisation" => "getTypeAutorisation",
            "dateEvenementDocument" => "getDateEvenementDocument",
            "groupeInstruction" => 'getGroupeInstruction',
            "title" => 'getTitleOrdreCommission',

            'type' => 'getDocumentType',
            'collectivite' => 'getDossierServiceOrCollectivite',
            'commission' => 'getCommissionCode'
        ),
        "om_fichier_commission_compte_rendu" => array(
            "dossier" => "getDossier",
            "dossier_version" => "getDossierVersion",
            "numDemandeAutor" => "getNumDemandeAutor",
            "anneemoisDemandeAutor" => "getAnneemoisDemandeAutor",
            "typeInstruction" => "getTypeInstruction",
            "statutAutorisation" => "getStatutAutorisation",
            "typeAutorisation" => "getTypeAutorisation",
            "dateEvenementDocument" => "getDateEvenementDocument",
            "groupeInstruction" => 'getGroupeInstruction',
            "title" => 'getTitleCompteRenduCommission',

            'type' => 'getDocumentType',
            'collectivite' => 'getDossierServiceOrCollectivite',
            'commission' => 'getCommissionCode'
        ),
    );

    /**
     * Récupération du numéro de dossier d'instruction à ajouter aux métadonnées
     * @return chaîne vide
     */
    protected function getDossier($champ = null) {
        return "COMMISSION_".$this->getVal('date_commission');
    }

    /**
     * Récupération la version du dossier d'instruction à ajouter aux métadonnées
     * @return chaîne vide
     */
    protected function getDossierVersion() {
        return "";
    }

    /**
     * Récupération du numéro de dossier d'autorisation à ajouter aux métadonnées
     * @return chaîne vide
     */
    protected function getNumDemandeAutor() {
        return "";
    }

    /**
     * Récupération de la date de demande initiale du dossier à ajouter aux métadonnées
     * @return chaîne vide
     */
    protected function getAnneemoisDemandeAutor() {
        return "";
    }

    /**
     * Récupération du type de dossier d'instruction à ajouter aux métadonnées
     * @return chaîne vide
     */
    protected function getTypeInstruction() {
        return "";
    }

    /**
     * Récupération du statut du dossier d'autorisation à ajouter aux métadonnées
     * @return chaîne vide
     */
    protected function getStatutAutorisation() {
        return "";
    }

    /**
     * Récupération du type de dossier d'autorisation à ajouter aux métadonnées
     * @return chaîne vide
     */
    protected function getTypeAutorisation() {
        return "";
    }

    /**
     * Récupération de la date d'ajout de document à ajouter aux métadonnées
     * @return date de l'évènement
     */
    protected function getDateEvenementDocument() {
        return date("Y-m-d");
    }

    /**
     * Récupération du groupe d'instruction à ajouter aux métadonnées
     * @return string Groupe d'instruction
     */
    protected function getGroupeInstruction() {
        return "ADS";
    }

    /**
     * Récupération du type du document à ajouter aux métadonnées
     * @return string Type de document
     */
    protected function getTitleOrdreCommission() {
        return 'Ordre du jour : '.$this->getVal($this->clePrimaire).'_'.$this->getVal('libelle');
    }

    /**
     * Récupération du type du document à ajouter aux métadonnées
     * @return string Type de document
     */
    protected function getTitleCompteRenduCommission() {
        return 'Compte-rendu : '.$this->getVal($this->clePrimaire).'_'.$this->getVal('libelle');
    }

    // }}}

    protected function getDocumentType($champ = null) {
        switch($champ) {
            case "om_fichier_commission_ordre_jour": ;
                return __("Commission").':'.__("Ordre du jour");
            case "om_fichier_commission_compte_rendu":
                return __("Commission").':'.__("Compte rendu");
        }
        return parent::getDocumentType();
    }

    protected function getDossierServiceOrCollectivite($champ = null) {
        $collectiviteId = $this->getVal('om_collectivite');
        if (! empty($collectiviteId)) {
            $collectivite = $this->f->findObjectById('om_collectivite', $collectiviteId);
            if (! empty($collectivite)) {
                return $collectivite->getVal('libelle');
            }
        }
    }

    protected function getCommissionCode($champ = null) {
        return $this->getVal('code');
    }
}
