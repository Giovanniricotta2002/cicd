<?php
/**
 * DBFORM - 'dossier_instruction_type' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'dossier_instruction_type'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/dossier_instruction_type.class.php";

class dossier_instruction_type extends dossier_instruction_type_gen {

    /**
     * Liaison NaN
     *
     * Tableau contenant les objets qui représente les liaisons.
     */
    var $liaisons_nan = array(
        // Permet de paramétrer le champs lié à la table de liaison lien_type_di_type_di
        "lien_type_di_type_di" => array(
            "table_l" => "lien_type_di_type_di",
            "table_f" => "dossier_instruction_type",
            "field_f" => "type_di_parent",
            "field" => "lien_sous_dossier_type_di",
        ),
        // Paramétrage du champs lié à la table de liaison lien_dossier_instruction_type_categorie_tiers
        // permettant de paramétrer les acteurs à ajouter automatiquement
        "lien_dossier_instruction_type_categorie_tiers_ajout_auto" => array(
            "table_l" => "lien_dossier_instruction_type_categorie_tiers",
            "table_f" => "categorie_tiers_consulte",
            "field_f" => "categorie_tiers",
            "field" => "categories_tiers_ajout_auto",
            "specific_values" => array(
                'ajout_automatique' => true
            ),
            // Condition permettant de différencier les catégories d'acteur en ajout auto de ceux en ajout manuel
            "conditions_to_delete" => 'AND ajout_automatique IS TRUE'
        ),
        // Paramétrage du champs lié à la table de liaison lien_dossier_instruction_type_categorie_tiers
        // permettant de paramétrer les acteurs à ajouter manuellement
        "lien_dossier_instruction_type_categorie_tiers" => array(
            "table_l" => "lien_dossier_instruction_type_categorie_tiers",
            "table_f" => "categorie_tiers_consulte",
            "field_f" => "categorie_tiers",
            "field" => "categories_tiers",
            "specific_values" => array(
                'ajout_automatique' => false
            ),
            // Condition permettant de différencier les catégories d'acteur en ajout manuel de ceux en ajout auto
            "conditions_to_delete" => 'AND ajout_automatique IS NOT TRUE'
        )
    );

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, (dossier_autorisation_type_detaille.code||' ('||dossier_autorisation_type_detaille.libelle||')') as lib FROM ".DB_PREFIXE."dossier_autorisation_type_detaille ORDER BY lib";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille_by_id() {
        return "SELECT dossier_autorisation_type_detaille.dossier_autorisation_type_detaille, (dossier_autorisation_type_detaille.code||' ('||dossier_autorisation_type_detaille.libelle||')') as lib FROM ".DB_PREFIXE."dossier_autorisation_type_detaille WHERE dossier_autorisation_type_detaille = <idx>";
    }

    /**
     * Requête permettant de récupérer un type de dossier d'instruction à partir
     * de son id.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return sprintf(
            'SELECT 
                dossier_instruction_type.dossier_instruction_type,
                CONCAT_WS(
                    \' - \',
                    dossier_autorisation_type_detaille.code,
                    dossier_instruction_type.code,
                    dossier_autorisation_type_detaille.libelle,
                    dossier_instruction_type.libelle
                ) AS libelle_type_di_parent
            FROM
                %1$sdossier_instruction_type
                LEFT JOIN %1$sdossier_autorisation_type_detaille
                    ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            WHERE
                dossier_instruction_type.dossier_instruction_type IN (<idx>)
            ORDER BY
                libelle_type_di_parent',
            DB_PREFIXE
        );
    }

    /**
     * Requête permettant de récupérer la liste de tous les types de dossier
     * d'instruction n'étant pas des types de sous-dossier.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type() {
        return sprintf(
            'SELECT 
                dossier_instruction_type.dossier_instruction_type,
                CONCAT_WS(
                    \' - \',
                    dossier_autorisation_type_detaille.code,
                    dossier_instruction_type.code,
                    dossier_autorisation_type_detaille.libelle,
                    dossier_instruction_type.libelle
                ) AS libelle_type_di_parent
            FROM
                %1$sdossier_instruction_type
                LEFT JOIN %1$sdossier_autorisation_type_detaille
                    ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            WHERE
                dossier_instruction_type.sous_dossier IS FALSE
            ORDER BY
                libelle_type_di_parent',
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categories_tiers() {
        return sprintf(
            'SELECT
                categorie_tiers_consulte.categorie_tiers_consulte,
                categorie_tiers_consulte.libelle
            FROM
                %1$scategorie_tiers_consulte
            WHERE
                ((categorie_tiers_consulte.om_validite_debut IS NULL
                    AND (categorie_tiers_consulte.om_validite_fin IS NULL
                        OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE))
                OR (categorie_tiers_consulte.om_validite_debut <= CURRENT_DATE
                    AND (categorie_tiers_consulte.om_validite_fin IS NULL
                        OR categorie_tiers_consulte.om_validite_fin > CURRENT_DATE)))
            ORDER BY
                categorie_tiers_consulte.libelle ASC',
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categories_tiers_by_id() {
        return sprintf(
            'SELECT
                categorie_tiers_consulte.categorie_tiers_consulte,
                categorie_tiers_consulte.libelle
            FROM
                %1$scategorie_tiers_consulte
            WHERE
                categorie_tiers_consulte IN (<idx>)',
            DB_PREFIXE
        );
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "dossier_instruction_type.dossier_instruction_type",
            "code",
            "libelle",
            "description",
            "sous_dossier",
            "array_to_string(
                array_agg(
                    distinct(lien_type_di_type_di.type_di_parent)
                    ORDER BY
                        lien_type_di_type_di.type_di_parent
                ),
                ';'
            ) as lien_sous_dossier_type_di",
            "dossier_autorisation_type_detaille",
            "suffixe",
            "mouvement_sitadel",
            "maj_da_localisation",
            "maj_da_lot",
            "maj_da_demandeur",
            "maj_da_etat",
            "maj_da_date_init",
            "maj_da_date_validite",
            "maj_da_date_doc",
            "maj_da_date_daact",
            "maj_da_dt",
            "array_to_string(
                array_agg(
                    distinct(categories_tiers_ajout_auto.categorie_tiers)
                    ORDER BY
                        categories_tiers_ajout_auto.categorie_tiers
                ),
                ';'
            ) as categories_tiers_ajout_auto",
            "array_to_string(
                array_agg(
                    distinct(categories_tiers.categorie_tiers)
                    ORDER BY
                        categories_tiers.categorie_tiers
                ),
                ';'
            ) as categories_tiers"
        );
    }

    /**
     * Clause from pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__tableSelect() {
        return sprintf(
            '%1$s%2$s
                LEFT JOIN %1$slien_type_di_type_di
                    ON lien_type_di_type_di.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type
                LEFT JOIN %1$slien_dossier_instruction_type_categorie_tiers AS categories_tiers_ajout_auto
                    ON categories_tiers_ajout_auto.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                        AND categories_tiers_ajout_auto.ajout_automatique IS TRUE
                LEFT JOIN %1$slien_dossier_instruction_type_categorie_tiers AS categories_tiers
                    ON categories_tiers.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                        AND categories_tiers.ajout_automatique IS NOT TRUE',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     * Clause where pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__selection() {
        return " GROUP BY dossier_instruction_type.dossier_instruction_type ";
    }

    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        $optionNotif = $this->f->is_option_enabled('option_module_acteur');

        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        $form->setType('mouvement_sitadel','selectstatic');
        $form->setType('lien_sous_dossier_type_di','select_multiple_static');
        $form->setType('categories_tiers_ajout_auto', 'hidden');
        $form->setType('categories_tiers', 'hidden');
        if ($optionNotif === true) {
            $form->setType('categories_tiers_ajout_auto', 'select_multiple_static');
            $form->setType('categories_tiers', 'select_multiple_static');
        }

        // MODE AJOUTER et MODE MODIFIER
        if ($maj < 2) {
            $form->setType('mouvement_sitadel','select');
            $form->setType('lien_sous_dossier_type_di','select_multiple');
            if ($optionNotif === true) {
                $form->setType('categories_tiers_ajout_auto', 'select_multiple');
                $form->setType('categories_tiers', 'select_multiple');
            }
            $retourformulaire = $this->getParameter('retourformulaire');
            $form->setType("sous_dossier", "checkbox");
            $form->setType("lien_sous_dossier_type_di", "select_multiple");
            // Si on est bien dans le contexte datd
            // On passe les champs 'sous_dossier' et 'lien_sous_dossier_type_di' en statique
            // pour éviter de les cocher/selectionner, ce qui créerai un dossier d’autorisation
            if (! empty($retourformulaire)
                && $this->is_in_context_of_foreign_key("dossier_autorisation_type_detaille", $retourformulaire)) {
                $form->setType("sous_dossier", "checkboxstatic");
                $form->setType("lien_sous_dossier_type_di", "select_multiple_static");
            }
        }


    }

    function setTaille(&$form, $maj) {
        parent::setTaille($form, $maj);
        $form->setTaille("lien_sous_dossier_type_di", 20);
        $form->setTaille("categories_tiers_ajout_auto", 20);
        $form->setTaille("categories_tiers", 20);
    }

    function setMax(&$form, $maj) {
        parent::setMax($form, $maj);
        $form->setMax("lien_sous_dossier_type_di", 20);
        $form->setMax("categories_tiers_ajout_auto", 20);
        $form->setMax("categories_tiers", 20);
    }

    function set_form_specificity(&$form, $maj) {
        parent::set_form_specificity($form, $maj);
        // Pour les sous-dossiers masque le champs dossier_autorisation_type_detaille.
        // Sinon c'est le champs 'lien_sous_dossier_type_di' qui est masqué
        if ($this->getParameter("validation") > 0) {
            $postvar = $this->getParameter("postvar");
            // Si le champs est masqué alors il n'est pas présent dans le post. Comme il est
            // masqué cela signifie que la case sous-dossier n'est pas coché
            $sousDossier = isset($postvar['sous_dossier']) ? $postvar['sous_dossier'] : false;
        } elseif (isset($this->val['sous_dossier'])) {
            $sousDossier = $this->val['sous_dossier'];
        } else {
            $sousDossier = $this->get_boolean_from_pgsql_value($this->getVal('sous_dossier'));
        }
 
        if ($sousDossier === true || $sousDossier == 't' || $sousDossier === 'Oui') {
            $form->classes_specifiques['dossier_autorisation_type_detaille'] = 'ui-tabs-hide';
        } else {
            $form->classes_specifiques['lien_sous_dossier_type_di'] = 'ui-tabs-hide';
        }

        // Si on est dans le contexte datd, on rend visible les champs 
        // 'dossier_autorisation_type_detaille' et 'lien_sous_dossier_type_di'
        $retourformulaire = $this->getParameter('retourformulaire');
        if (! empty($retourformulaire)
            && $retourformulaire != 'dossier_autorisation_type_detaille') {
            $form->classes_specifiques['dossier_autorisation_type_detaille'] = 'display-block';
            $form->classes_specifiques['lien_sous_dossier_type_di'] = 'display-block';
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // mouvement_sitadel
        $contenu=array();
        $contenu[0]=array(
            '',
            'DEPOT',
            'MODIFICATIF',
            'SUIVI',
            'SUPPRESSION',
            'TRANSFERT',
            );
        $contenu[1]=array(
            _('choisir')." "._("mouvement_sitadel"),
            _('DEPOT'),
            _('MODIFICATIF'),
            _('SUIVI'),
            _('SUPPRESSION'),
            _('TRANSFERT'),
            );
        $form->setSelect("mouvement_sitadel",$contenu);

        // Initialisation du selecteur multiple specialite_tiers_consulte
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "lien_sous_dossier_type_di",
            $this->get_var_sql_forminc__sql("dossier_instruction_type"),
            $this->get_var_sql_forminc__sql("dossier_instruction_type_by_id"),
            false,
            true
        );

        // Initialisation du selecteur multiple de selection des categories de tiers
        // pour l'ajout auto des acteurs
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "categories_tiers",
            $this->get_var_sql_forminc__sql("categories_tiers"),
            $this->get_var_sql_forminc__sql("categories_tiers_by_id"),
            false,
            true
        );

        // Initialisation du selecteur multiple de selection des categories de tiers
        // pour l'ajout manuel des acteurs
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "categories_tiers_ajout_auto",
            $this->get_var_sql_forminc__sql("categories_tiers"),
            $this->get_var_sql_forminc__sql("categories_tiers_by_id"),
            false,
            true
        );
    }

    function setLayout(&$form, $maj){
        $form->setFieldset('code','D',_('Caractéristiques'));
        $form->setBloc('code','D',"","col_12");
        $form->setBloc('mouvement_sitadel','F');
        $form->setFieldset('mouvement_sitadel','F','');

        $form->setFieldset('maj_da_localisation', 'D', __("Mises à jour des données du dossier d'autorisation"));
        $form->setBloc('maj_da_localisation','D',"","col_12");
        $form->setBloc('maj_da_dt','F');
        $form->setFieldset('maj_da_dt','F','');

        $form->setFieldset('categories_tiers_ajout_auto', 'D', __("Catégorie(s) de tiers requise(s)"));
        $form->setBloc('categories_tiers_ajout_auto','D',"","col_12");
        $form->setBloc('categories_tiers','F');
        $form->setFieldset('categories_tiers','F','');

    }

    /**
     * (Surcharge) Cette fonction sert à paramétrer les libellés des champs qui
     * seront affichés dans les formulaires et leur traduction.
     *
     * @param formulaire $form : instance du formulaire
     * @param integer $maj : identifiant de l'action issus de l'url du formualire
     */
    function setLib(&$form,$maj) {
        parent::setLib($form, $maj);
        $form->setLib("lien_sous_dossier_type_di", __("Sous-dossier pour le(s) DI"));
        $form->setLib("sous_dossier", __("Sous-dossier"));
        $form->setLib("categories_tiers", __("Ajout par l'utilisateur"));
        $form->setLib("categories_tiers_ajout_auto", __("Ajout automatique"));
    }

    /**
     * (Surcharge) 
     *
     * @param formulaire $form : instance du formulaire
     * @param integer $maj : identifiant de l'action issus de l'url du formualire
     */
    function setOnchange(&$form, $maj) {
        // Alterne l'affichage des champs lien_sous_dossier_type_di et
        // dossier_autorisation_type_detaille selon la valeur du champs sous_dossier
        $form->setOnchange(
            'sous_dossier',
            'alternate_display(
                    this.value,
                    [\'lien_sous_dossier_type_di\'],
                    [\'dossier_autorisation_type_detaille\']
            )'
        );
    }

    /**
     * (Surcharge) Effectue des vérifications avant mise à jour des données
     * issues d'un formulaire d'ajout ou de modification.
     *
     * Les vérifications réalisées dans cette méthode sont :
     *  1 - Si la case "sous_dossier" est cochée vérifie que la case "suffixe" l'est aussi.
     *    Si ce n'est pas le cas empeche la validation du formulaire et averti l'utilisateur
     *    que son paramétrage n'est pas correct.
     *  2 - Si la case "sous_dossier" est cochée vérifie que les champs de paramétrage de la mise
     *    à jour du dossier d'autorisation ne sont pas coché.
     *    Si ce n'est pas le cas empeche la validation du formulaire et averti l'utilisateur
     *    que son paramétrage n'est pas correct.
     *  3 - Si la case "sous_dossier" n'est pas coché vérifie que le champs dossier_autorisation_type_detaille
     *    à bien été rempli.
     *    Si ce n'est pas le cas empeche la validation du formulaire et averti l'utilisateur
     *    que le champ dossier_autorisation_type_detaille est obligatoire.
     *
     * @param formulaire $form : instance du formulaire
     * @param integer $maj : identifiant de l'action issus de l'url du formualire
     * @param string $dnu1 : inutilisé
     * @param string $dnu2 : inutilisés
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val, $dnu1, $dnu2);

        // Vérification 1 & 2
        if (! empty($val['sous_dossier'])
            && $val['sous_dossier'] == 'Oui'
        ) {
            // 1 - Vérifie si la case suffixe a bien été cochée
            if (isset($val['suffixe']) && $val['suffixe'] == '') {
                $this->correct = false;
                $this->addToMessage(
                    __("L'affichage du suffixe du numéro de dossier est obligatoire pour les sous-dossiers.")
                );
            }
            // 2 - Vérifie pour chacun des champs de mise à jour du DA s'il est bien paramétré.
            // Si ce n'est pas le cas, enregistre le nom du champs dans une liste.
            $champsAVerifier = array(
                "maj_da_localisation",
                "maj_da_lot",
                "maj_da_demandeur",
                "maj_da_etat",
                "maj_da_date_init",
                "maj_da_date_validite",
                "maj_da_date_doc",
                "maj_da_date_daact",
                "maj_da_dt"
            );
            $listeChamps = '';
            foreach ($champsAVerifier as $champs) {
                if (! empty($val[$champs]) && $val[$champs] == 'Oui') {
                    $listeChamps .= sprintf(
                        '<li>%s</li>',
                        __($champs)
                    );
                }
            }
            // Informe l'utilisateur que sont paramétrage n'est pas correct et lui donne
            // la liste des champs à corriger.
            if (! empty($listeChamps)) {
                $this->correct = false;
                $message = sprintf(
                    '%1$s %2$s
                    <ul>
                        %3$s
                    </ul>',
                    __("L'évolution d'un sous-dossier ne dois pas entrainer de mise à jour du dossier d'autorisation."),
                    __("Veuillez décocher les champs suivants : "),
                    $listeChamps
                );
                $this->addToMessage($message);
            }
        } elseif (empty($val['dossier_autorisation_type_detaille'])) {
            // Cas 3 : le champs dossier_autorisation_type_detaille est obligatoire
            // pour tous les types de dossier n'étant pas des sous-dossier
            $this->correct = false;
            $message = $this->addToMessage(
                __('Le champ').
                ' <span class="bold">'.$this->getLibFromField('dossier_autorisation_type_detaille').'</span> '.
                __('est obligatoire')
            );
        }
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * Les traitements réalisés sont :
     * - Crée les liens entre le type de dossier d'instruction ajouté et le(s) type(s)
     *   de DI sélectionnés dans le champs "Sous-dossier pour le(s) DI". (lien entre
     *   les types de sous-dossier et les dossiers d'instruction auxquels ils pourront
     *   être associé)
     *
     * - Crée les liens entre les catégories de tiers et le type de dossier d'instruction.
     *   Les liens issus du champs categorie_tiers_ajout_auto sont créés avec la colonne
     *   ajout_automatique a TRUE
     *   Les liens issus du champs categorie_tiers sont créés avec la colonne
     *   ajout_automatique a FALSE
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggerajouterapres($id, $dnu1, $val);

        // Liaison NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Si le champ possède une valeur
            if (isset($val[$liaison_nan["field"]]) === true) {
                // Ajout des liaisons table Nan
                $nb_liens = $this->ajouter_liaisons_table_nan(
                    $liaison_nan["table_l"],
                    $liaison_nan["table_f"],
                    $liaison_nan["field"],
                    $val[$liaison_nan["field"]],
                    $liaison_nan["field_f"],
                    is_array($liaison_nan) && array_key_exists('specific_values', $liaison_nan) ?
                        $liaison_nan['specific_values'] :
                        array()
                );
                // Message de confirmation
                if ($nb_liens > 0) {
                    if ($nb_liens == 1) {
                        $this->addToMessage(sprintf(__("Création d'une nouvelle liaison réalisee avec succès.")));
                    } else {
                        $this->addToMessage(sprintf(__("Création de %s nouvelles liaisons réalisée avec succès."), $nb_liens));
                    }
                }
            }
        }

        return true;
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * Les traitements réalisés sont :
     * - Supprime tous les liens entre le type de dossier d'instruction (DI) modifié
     *   et les types de DI auxquels il est associé.
     * - Crée les liens entre le type de DI modifié et le(s) type(s) de DI sélectionnés
     *   dans le champs "Sous-dossier pour le(s) DI". (lien entre les types de sous-dossier
     *   et les dossiers d'instruction auxquels ils pourront être associé)
     *
     * - Supprime les liens entre les catégories de tiers et le type de dossier d'instruction
     *   lié au champs categorie_tiers_ajout_auto. Les liens supprimés sont ceux ayant
     *   le type de DI courant et pour lesquels ajout_automatique vaut TRUE
     * - Crée les liens entre les catégories de tiers et le type de dossier d'instruction
     *   issus du champs categorie_tiers_ajout_auto. Ils sont créés avec la colonne
     *   ajout_automatique a TRUE
     *
     * - Supprime les liens entre les catégories de tiers et le type de dossier d'instruction
     *   lié au champs categorie_tiers. Les liens supprimés sont ceux ayant le type de DI
     *   courant et pour lesquels ajout_automatique vaut FALSE
     * - Crée les liens entre les catégories de tiers et le type de dossier d'instruction
     *   issus du champs categorie_tiers. Ils sont créés avec la colonne
     *   ajout_automatique a FALSE
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggermodifierapres($id, $dnu1, $val);
        
        // Liaisons NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Suppression des liaisons table NaN
            $this->supprimer_liaisons_table_nan(
                $liaison_nan["table_l"],
                is_array($liaison_nan) && array_key_exists('conditions_to_delete', $liaison_nan) ?
                    $liaison_nan['conditions_to_delete'] :
                    ''
            );
            // Ajout des liaisons table Nan
            $nb_liens = $this->ajouter_liaisons_table_nan(
                $liaison_nan["table_l"],
                $liaison_nan["table_f"],
                $liaison_nan["field"],
                $val[$liaison_nan["field"]],
                $liaison_nan["field_f"],
                is_array($liaison_nan) && array_key_exists('specific_values', $liaison_nan) ?
                    $liaison_nan['specific_values'] :
                    array()
            );
            // Message de confirmation
            if ($nb_liens > 0) {
                $this->addToMessage(__("Mise a jour des liaisons realisee avec succes."));
            }
        }

        return true;
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * Les traitements réalisés sont :
     * - Supprime tous les liens entre le type de dossier d'instruction (DI) modifié
     *   et les types de DI auxquels il est associé. (lien entre les types de sous-dossier
     *   et les dossiers d'instruction auxquels ils pourront être associé)
     *
     * - Supprime les liens entre les catégories de tiers et le type de dossier d'instruction.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggersupprimer($id, $dnu1, $val);
        // Liaisons NaN
        foreach ($this->liaisons_nan as $liaison_nan) {
            // Suppression des liaisons table NaN
            $this->supprimer_liaisons_table_nan($liaison_nan["table_l"]);
        }
        return true;
    }

    /**
     * Surcharge de la méthode rechercheTable pour éviter de court-circuiter le 
     * générateur en devant surcharger la méthode cleSecondaire afin de supprimer
     * les éléments liés dans les tables NaN.
     *
     * @param [type] $dnu1      Instance BDD - À ne pas utiliser
     * @param [type] $table     Table
     * @param [type] $field     Champ
     * @param [type] $id        Identifiant
     * @param [type] $dnu2      Marqueur de débogage - À ne pas utiliser
     * @param string $selection Condition de la requête
     *
     * @return [type] [description]
     */
    function rechercheTable(&$dnu1 = null, $table = "", $field = "", $id = null, $dnu2 = null, $selection = "") {
        //
        if (in_array($table, array_keys($this->liaisons_nan))) {
            //
            $this->addToLog(__METHOD__."(): On ne vérifie pas la table ".$table." car liaison nan.", EXTRA_VERBOSE_MODE);
            return;
        }
        //
        parent::rechercheTable($this->f->db, $table, $field, $id, null, $selection);
    }
}


