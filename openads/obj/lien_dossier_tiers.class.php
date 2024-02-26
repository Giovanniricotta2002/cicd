<?php
//$Id$
//gen openMairie le 23/01/2023 15:06

require_once "../gen/obj/lien_dossier_tiers.class.php";

class lien_dossier_tiers extends lien_dossier_tiers_gen {


    /**
     * Définition des actions disponibles sur la classe.
     *
     * Les actions définies / modifiées sont :
     *  - Action 1 - Modifier : suppression du bouton modifier du portlet
     *  - Action 2 - Supprimer : surcharge pour l'enlever du portlet et pouvoir supprimer
     *               directement depuis le listing
     *  - Action 4 - view_lien_dossier_tiers_tabs : vues contenant les listings d'acteurs
     *               par catégorie
     *  - Action 6 - Action permettant d'ajouter plusieurs acteurs d'une catégorie au dossier
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();

        // ACTION - 1 - Modifier
        // L'action ne dois pas être affiché dans le portlet
        unset($this->class_actions[1]['portlet']);
        // ACTION - 2 - Supprimer
        // Surcharge de l'action de suppression pour supprimer un élément
        // directement depuis le listing.
        // /!\ cette action est lié à un script pour que l'affichage après utilisation
        //     de l'action se fasse correctement
        $this->class_actions[2] = array(
            "identifier" => "delete_link",
            "method" => "delete_link",
            "permission_suffix" => "supprimer",
            "condition" => array(
                "exists",
            )
        );
        // ACTION - 4 - view_lien_dossier_tiers_tabs
        $this->class_actions[4] = array(
            "identifier" => "view_lien_dossier_tiers_tabs",
            "view" => "view_lien_dossier_tiers_tabs",
            "permission_suffix" => "tab",
        );
        // ACTION - 6 - add_link
        // /!\ cette action est lié à un script pour que l'affichage après utilisation
        //     de l'action se fasse correctement
        $this->class_actions[6] = array(
            "identifier" => "ajouter",
            "permission_suffix" => "ajouter",
            "method" => "add_links",
            "crud" => "create"
        );
    }

    /**
     * Set l'attribut tab_back_link de la classe si il est vide en lui affectant l'url
     * construite à partir des paramétres.
     *
     * Renvoie l'url contenu dans l'attribut tab_back_link.
     *
     * @param string nom de l'objet
     * @param string retourformulaire
     * @param string retourformulaire
     * @return string
     */
    function get_tab_back_link(string $obj, string $retourformulaire, string $idxformulaire) {
        if (empty($this->tab_back_link)) {
            $this->tab_back_link = sprintf(
                OM_ROUTE_SOUSFORM."&obj=%s&action=%d&idx=%s&retourformulaire=%s&idxformulaire=%s",
                $obj,
                4,
                0, // forçage de l'identifiant à zéro ?
                $retourformulaire,
                $idxformulaire
            );
        }
        return $this->tab_back_link;
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     * Récupère les champs des acteurs et des tiers pour permettre l'affichage des
     * même donnée que les tiers en consultation d'un acteur.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        $champs = parent::get_var_sql_forminc__champs();
        if (empty($this->tiers)) {
            $this->tiers = $this->f->get_inst__om_dbform(array(
                'obj' => 'tiers_consulte',
                'idx' => ']'
            ));
        }
        return array_merge($champs, $this->tiers->get_var_sql_forminc__champs());
    }

    /**
     * Clause from pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__tableSelect() {
        $select = parent::get_var_sql_forminc__tableSelect();
        return sprintf(
            '%1$s
            LEFT JOIN %2$stiers_consulte
                ON %3$s.tiers = tiers_consulte.tiers_consulte',
            $select,
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     * Requête permettant de récupéré les catégorie de tiers de la même manière que
     * que pour les tiers consulté.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers_consulte() {
        if (empty($this->tiers)) {
            $this->tiers = $this->f->get_inst__om_dbform(array(
                'obj' => 'tiers_consulte',
                'idx' => ']'
            ));
        }
        return $this->tiers->get_var_sql_forminc__sql_categorie_tiers_consulte();
    }

    /**
     * Requête permettant de récupéré la catégorie de tiers de la même manière que
     * que pour les tiers consulté.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_categorie_tiers_consulte_by_id() {
        if (empty($this->tiers)) {
            $this->tiers = $this->f->get_inst__om_dbform(array(
                'obj' => 'tiers_consulte',
                'idx' => ']'
            ));
        }
        return $this->tiers->get_var_sql_forminc__sql_categorie_tiers_consulte_by_id();
    }

    /**
     * SETTER FORM - setType
     *
     * Surcharge du type du champs tiers pour en faire un select multiple depuis le
     * formulaire d'ajout via l'action 6.
     */
    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        // Les champs tiers_consulte et libelle de la table tiers n'ont pas besoin
        // d'être affiché car leur information est redondante avec celle du champs tiers
        // de la table lien_dossier_tiers
        $form->setType("tiers_consulte", "hidden");
        $form->setType("libelle", "hidden");
        // MODE CONSULTER
        if ($maj == 3) {
            $form->setType("dossier", "hiddenstatic");
            $form->setType("categorie_tiers_consulte", "selectstatic");
            $form->setType("accepte_notification_email", "checkboxstatic");
        }
        // MODE AJOUTER
        if ($maj == 6) {
            // Masque tous les champs liés au tiers
            if (empty($this->tiers)) {
                $this->tiers = $this->f->get_inst__om_dbform(array(
                    'obj' => 'tiers_consulte',
                    'idx' => ']'
                ));
            }
            foreach ($this->tiers->champs as $champs) {
                $form->setType($champs, "hidden");
            }
            $form->setType("tiers", "select_multiple");
            $form->setType("dossier", "hidden");
        }
    }

    /**
     * Configuration du formulaire (VIEW formulaire et VIEW sousformulaire).
     * Surcharge permettant de traduire le nom des champs issus de la table tiers.
     *
     * @param formulaire $form Instance formulaire.
     * @param integer $maj Identifant numérique de l'action.
     *
     * @return void
     */
    function setLib(&$form, $maj) {
        parent::setLib($form, $maj);
        // Traduction de tous les champs de la table tiers
        if (empty($this->tiers)) {
            $this->tiers = $this->f->get_inst__om_dbform(array(
                'obj' => 'tiers_consulte',
                'idx' => ']'
            ));
        }
        foreach ($this->tiers->champs as $champs) {
            $form->setLib($champs, __($champs));
        }
    }

    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj, $dnu1, $dnu2);
        // categorie_tiers_consulte
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "categorie_tiers_consulte",
            $this->get_var_sql_forminc__sql("categorie_tiers_consulte"),
            $this->get_var_sql_forminc__sql("categorie_tiers_consulte_by_id"),
            true
        );
    }

    /**
     *  SETTER FORM - setOnchange
     *
     * Surcharge de setOnchange du champs tiers pour enlever l'appel de la méthode
     * VerifNum() qui casse le fonctionnerment du select multiple.
     */
    function setOnchange(&$form, $maj) {
        parent:: setOnchange($form, $maj);
        $form->setOnchange('tiers','');
    }

    /**
     * SETTER FORM - set_form_default_values
     *
     * Donne une valeur vide par défaut à l'ajout des liens depuis l'action 6
     * avant validation du formulaire afin d'éviter des notices PHP.
     *
     * @param formulaire $form Instance formulaire.
     * @param integer $maj Identifant numérique de l'action.
     * @param integer $validation Marqueur de validation du formulaire.
     *
     * @return void
     */
    function set_form_default_values(&$form, $maj, $validation) {
        if ($validation == 0 && $maj == 6) {
            $form->setVal('lien_dossier_tiers', '', $validation);
            // Initialisation a vide de tous les champs qui ne servent à rien
            // pour éviter des notices PHP
            $form->setVal('tiers', '', $validation);
            if (empty($this->tiers)) {
                $this->tiers = $this->f->get_inst__om_dbform(array(
                    'obj' => 'tiers_consulte',
                    'idx' => ']'
                ));
            }
            foreach ($this->tiers->champs as $champs) {
                $form->setVal($champs, '', $validation);
            }
        }
    }

    /**
     * Requête sql de récupération de l'identifiant et du libellé des tiers consulté
     * dont la catégorie est donnée par le paramètre "category" de l'url et qui ne sont
     * pas déjà associé au dossier donnée par le paramètre "idxformulaire" de l'url.
     *
     * Par défaut si category n'est pas défini on filtre sur la catégory 0.
     * Par défaut si idxformulaire n'est pas défini on cherche le dossier ''.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_tiers() {
        $category = $this->f->get_submitted_get_value('category');
        $idxformulaire = $this->f->get_submitted_get_value('idxformulaire');
        $dossier = $this->get_inst_dossier($idxformulaire);
        // Récupération du département et de la commune du dossier
        $commune = $dossier->getVal('commune');
        // Le département est récupéré à partir de la commune du dossier donc si la
        // commune n'a pas pu être récupéré on ne récupère pas non plus le département.
        $idDepartement = '';
        if (! empty($commune)) {
            $departement = $dossier->get_inst_departement_dossier();
            $idDepartement = $departement->getVal($departement->clePrimaire);
        }
        return sprintf(
            'SELECT
                tiers_consulte.tiers_consulte,
                tiers_consulte.libelle
            FROM
                %1$stiers_consulte
            WHERE
                tiers_consulte.categorie_tiers_consulte = %2$d
                -- garde uniquement les tiers notifiable
                AND tiers_consulte.liste_diffusion IS NOT NULL
                AND TRIM(tiers_consulte.liste_diffusion) != \'\'
                AND tiers_consulte.accepte_notification_email IS TRUE
                -- exclus les tiers déjà lié au dossier
                AND tiers_consulte.tiers_consulte NOT IN (
                    SELECT
                        tiers
                    FROM
                        %1$slien_dossier_tiers
                    WHERE
                        lien_dossier_tiers.dossier = \'%3$s\')
                -- Garde les tiers n ayant pas d habilitation en cours de validite
                -- OU ayant une habilitation liée à la commune du dossier
                -- OU ayant une habilitation liée au département d appartenance de la commune du dossier
                -- OU n étant lié à aucune commune ou département
                AND tiers_consulte.tiers_consulte IN (
                    SELECT
                        tiers_consulte.tiers_consulte
                    FROM
                        %1$stiers_consulte
                        -- Filtre pour garder uniquement les habilitations en cours de validité
                        LEFT JOIN %1$shabilitation_tiers_consulte
                            ON tiers_consulte.tiers_consulte = habilitation_tiers_consulte.tiers_consulte
                                AND (habilitation_tiers_consulte.om_validite_debut IS NULL
                                        OR habilitation_tiers_consulte.om_validite_debut <= CURRENT_DATE)
                                    AND (habilitation_tiers_consulte.om_validite_fin IS NULL
                                        OR habilitation_tiers_consulte.om_validite_fin > CURRENT_DATE)
                        -- Récupère uniquement les habilitations liées à la commune du dossier
                        LEFT JOIN %1$slien_habilitation_tiers_consulte_commune
                            ON habilitation_tiers_consulte.habilitation_tiers_consulte = lien_habilitation_tiers_consulte_commune.habilitation_tiers_consulte
                                AND lien_habilitation_tiers_consulte_commune.commune = %4$d
                        -- Récupère uniquement les habilitations liées au département du dossier
                        LEFT JOIN %1$slien_habilitation_tiers_consulte_departement
                            ON habilitation_tiers_consulte.habilitation_tiers_consulte = lien_habilitation_tiers_consulte_departement.habilitation_tiers_consulte
                                AND lien_habilitation_tiers_consulte_departement.departement = %5$d
                    WHERE
                        -- Pas d habilitation en cours de validité
                        habilitation_tiers_consulte.habilitation_tiers_consulte IS NULL
                        OR (-- Habilitation associée à la commune du dossier
                            lien_habilitation_tiers_consulte_commune.lien_habilitation_tiers_consulte_commune IS NOT NULL
                            -- Habilitation associée au département du dossier
                            OR lien_habilitation_tiers_consulte_departement.lien_habilitation_tiers_consulte_departement IS NOT NULL
                            -- Habilitation non liée à une commune ou à un département
                            OR (NOT EXISTS(
                                    SELECT lien_habilitation_tiers_consulte_departement
                                    FROM %1$slien_habilitation_tiers_consulte_departement AS lhtcd
                                    WHERE lhtcd.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte)
                                AND NOT EXISTS(
                                    SELECT lien_habilitation_tiers_consulte_commune
                                    FROM %1$slien_habilitation_tiers_consulte_commune AS lhtcc
                                    WHERE lhtcc.habilitation_tiers_consulte = habilitation_tiers_consulte.habilitation_tiers_consulte))))
            ORDER BY
                tiers_consulte.libelle ASC',
            DB_PREFIXE,
            (! empty($category) ? $category : 0),
            $this->f->db->escapeSimple($idxformulaire),
            intval($commune),
            intval($idDepartement)
        );
    }

    /**
     * Requête sql de récupération de l'identifiant et du libellé d'un tiers consulté
     * selon son identifiant.
     *
     * @return string
     */
    function get_var_sql_forminc__sql_tiers_by_id() {
        return sprintf(
            'SELECT
                tiers_consulte.tiers_consulte,
                tiers_consulte.libelle
            FROM
                %1$stiers_consulte
            WHERE
                tiers_consulte = <idx>',
            DB_PREFIXE
        );
    }

    /**
     * Vue de l'onglet acteurs.
     * Affichage d'un listing par catégorie de tiers recherché pour le type du dossier courant.
     * Affichage d'un listing par catégorie de tiers non recherché pour le type du dossier
     * courant mais dont des tiers sont associés au dossier.
     *
     * Chacun des listing comporte :
     *  - un bouton ajouter qui redirige vers le formulaire d'ajout des tiers de la catégorie.
     *  - des actions de suppression permettant de supprimer le tiers voulu.
     *  - des actions de consultation permettant de visualiser les infos du tiers voulu
     * /!\ la redirection lors du clic sur les actions d'ajout et de suppression est géré
     *     en partie avec du javascript. De même que le non affichage de la barre de recherche.
     *  - la possibilité de trier les listings
     * /!\ le tri des listings a été surchargé dans om_table::displayHeader() pour pouvoir
     *     fonctionner correctement sur cette vue.
     */
    function view_lien_dossier_tiers_tabs() {
        // Récupération des variables nécessaires à l'affichage de la vue
        // Ces 2 paramètres sont nécessaires pour construire l'url d'affichage des
        // listing par catégorie
        $idx = ! empty($this->f->get_submitted_get_value('idxformulaire')) ?
            $this->f->get_submitted_get_value('idxformulaire') :
            '';

        $retourformulaire = ($this->f->get_submitted_get_value('retourformulaire') !== null) ?
            $this->f->get_submitted_get_value('retourformulaire') :
            '';
        // Récupération du paramètre permettant d'identifier si un tri a été effectué sur un
        // des tableaux
        $tritab = ($this->f->get_submitted_get_value('tritab') !== null) ?
            $this->f->get_submitted_get_value('tritab') :
            '';
        // Récupération du lien permettant de recharger la page lors de l'utilisation de l'action
        // de suppression
        $back_link = $this->get_tab_back_link('lien_dossier_tiers', $retourformulaire, $idx);
        // Récupération de la liste des catégories pour lesquelles un listing doit être affiché
        $categoryToDisplay = $this->get_actor_category_to_display($idx);
        // Préparation du contenu de la page si aucune catégorie ne dois être ajoutée au dossier
        $vue = '';
        // Affichage du message de validation d'ajout si il y en a un
        $this->f->handle_and_display_session_message();
        if (empty($categoryToDisplay)) {
            $vue =__('Aucun acteur à ajouter pour ce dossier.');
        } else {
            // Préparation du html de chacun des listings à afficher
            foreach ($categoryToDisplay as $category) {
                // Url permettant d'accéder au listing de la catégorie de tiers.
                // Le parametre "category" permet de filtrer la sélection des tiers par catégorie
                // lors de l'ajout. Le parametre "libcategory" permet d'afficher le libellé de la
                // catégorie dans le fil d'Ariane du formulaire d'ajout.
                // /!\ Ces paramètre sont aussi utilisés dans la méthode :
                //     $this->getDataSubmitSousForm()
                //     Pour correctement recharger la page en cas d'erreur à l'envoi du formulaire.
                // Si le paramètre tritab est défini et qu'il correspond à la catégorie du tableau
                // affiché ajoute le paramètre tricol à l'url pour le trier comme voulu. Sinon
                // le tableau est trié par ordre alphabétique de tiers par défaut.
                $linkActorByCategory = sprintf(
                    '%s&obj=lien_dossier_tiers&idxformulaire=%s&retour=tab&retourformulaire=%s&category=%d&libcategory=%s&tricol=%s',
                    OM_ROUTE_SOUSTAB,
                    $idx,
                    $retourformulaire,
                    intval($category['categorie_tiers_consulte']),
                    urlencode($category['libelle']),
                    ! empty($tritab) && $tritab == $category['categorie_tiers_consulte'] ?
                        '&tricol='.$this->f->get_submitted_get_value('tricol') :
                        '1'
                );
                // Affichage d'un listing
                $vue .= sprintf(
                    '<h3 id="actor-category-title">%1$s</h3>
                    <div id="sousform-acteur_category_%2$s"></div>
                            <script type="text/javascript" >
                                ajaxIt(\'acteur_category_%2$s\', \'%3$s\');
                            </script>',
                    $category['libelle'],
                    $category['categorie_tiers_consulte'],
                    $linkActorByCategory
                );
            }
        }
        // Affichage de la vue
        printf(
            '<div id="sousform-lien_dossier_tiers">
                <div id="back_link" data-href="%1$s"></div>
                %2$s
            </div>',
            $back_link,
            $vue
        );
    }

    /**
     * TREATMENT - supprimer_liaison.
     *
     * Supprime le lien entre le dossier et un tiers.
     *
     * @return boolean
     */
    function delete_link() {
        $this->begin_treatment(__METHOD__);
        $this->correct = true;
        // Instanciation du tiers à délié pour afficher son nom dans le message
        $tiers = $this->f->get_inst__om_dbform(array(
            'obj' => 'tiers_consulte',
            'idx' => $this->getVal('tiers')
        ));
        $message = __("L'acteur %s a été supprimé du dossier.");
        // Suppression du lien et gestion du cas où la suppression échoue
        if ($this->supprimer(array_combine($this->champs, $this->val)) === false) {
            $this->correct = false;
            $message = __("L'acteur %s n'a pas pu être supprimé du dossier.");
        }
        $this->addToMessage(sprintf(
            $message,
            $tiers->getVal('libelle')));
        return $this->end_treatment(__METHOD__, $this->correct);
    }

    /**
     * Récupère les données du formulaire et vérifie si elles sont correctes.
     * Si c'est le cas vérifie si des tiers ont bien été sélectionné et
     * ajoute ces tiers au dossier.
     *
     * @param array $val tableau contenant les valeurs issues du formulaire
     * @return boolean
     */
    protected function add_links($val = array()) {
        $this->begin_treatment(__METHOD__);
        // Vérifie que les valeurs ont bien été saisies dans le formulaire
        if (empty($val['dossier'])) {
            $this->correct = false;
            $this->addToMessage(__('Le remplissage du champs tiers est obligatoire.'));
        }
        if (empty($val['tiers'])) {
            $this->correct = false;
            $this->addToMessage(__('Le remplissage du champs tiers est obligatoire.'));
        }
        if (! $this->correct) {
            // Message d'echec (saut d'une ligne supplementaire avant le
            // message pour qu'il soit mis en evidence)
            $this->addToMessage(__("SAISIE NON ENREGISTREE"));
            return $this->end_treatment(__METHOD__, false);
        }
        // Récupère les tiers saisie dans le dossier en supprimant les entrées vide
        $tiers = array_filter(explode(";", $val['tiers']));
        // Vérifie le format des données issues du champs tiers
        if (! is_array($tiers)) {
            $this->correct = false;
            $message = __("Erreur lors de la récupération des tiers : format des données incorrect");
            $this->addToMessage($message);
            $this->addToLog(
                sprintf(
                    '%s() : %s %s = %s',
                    __METHOD__,
                    $message,
                    __('tiers'),
                    var_export($tiers, true)
                ),
                DEBUG_MODE
            );
        }
        // Si il y a des valeurs correcte de tiers et que le numéro de dossier est bien renseigné
        // récupère les valeur des tiers et ajoute une liaison par tiers.
        // Récupération des messages dans un tableau pour faciliter la séparation des différents message
        // à l'aide d'un implode
        $message = array();
        foreach ($tiers as $tier) {
            $val = array(
                'lien_dossier_tiers' => null,
                'dossier' => $val['dossier'],
                'tiers' => $tier
            );
            // Instanciation du tier pour récupérer son nom
            $tier = $this->f->get_inst__om_dbform(array(
                'obj' => 'tiers_consulte',
                'idx' => $tier
            ));
            // Ajout des liens et gestion du message et des erreurs
            if ($this->ajouter($val) === false) {
                $this->correct = false;
                // En cas d'erreur, même si des acteurs ont déjà été marqué comme ajouté, leur
                // ajout sera annulé. Pour éviter que des éléments soit marqué comme ajouté
                // alors que ce n'est pas le csa, on réinitialise le message en cas d'erreur
                // et les ajout sont supsendu
                $message = array(
                    sprintf(
                        '%s<br/><br/>%s',
                        sprintf(
                            __('Erreur lors de l\'ajout de l\'acteurs %s sur le dossier %s.'),
                            $tier->getVal('libelle'),
                            $val['dossier']
                        ),
                        __("SAISIE NON ENREGISTREE")
                    )
                );
                break;
            } else {
                $message[] = sprintf(
                    __('L\'acteurs %s a été ajouté au dossier.'),
                    $tier->getVal('libelle')
                );
            }
        }
        // Remplace le message de base par les messages construit précedemment.
        // Comme la méthode ajouter est utilisé plusieurs fois cela permet d'éviter
        // d'avoir un message qui se repéte X fois.
        $this->msg = implode('<br/>', $message);
        return $this->end_treatment(__METHOD__, $this->correct);
    }

    /**
     * Effectue une requête sql qui récupère l'identifiant et le libellé de toutes la catégorie
     * de tiers associé au type de dossier et de toutes la catégorie associée à des tiers acteur
     * du dossier.
     * Cette liste est ensuite trié par ordre alphabétique et renvoyé.
     *
     * @param string identifiant du dossier
     * @return array tableau contenant les identifiants et les libellés des catégorie de tiers
     * du dossier.
     */
    protected function get_actor_category_to_display(string $idDossier) {
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT -- Récupération des catégories de tiers associé au type de dossier et à la collectivité
                    categorie_tiers_consulte.categorie_tiers_consulte,
                    categorie_tiers_consulte.libelle
                FROM
                    %1$sdossier
                    JOIN %1$sdossier_instruction_type
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    JOIN %1$slien_dossier_instruction_type_categorie_tiers
                        ON dossier_instruction_type.dossier_instruction_type = lien_dossier_instruction_type_categorie_tiers.dossier_instruction_type
                    JOIN %1$scategorie_tiers_consulte
                        ON lien_dossier_instruction_type_categorie_tiers.categorie_tiers = categorie_tiers_consulte.categorie_tiers_consulte
                    -- Récupération des categories liées à la collectivités du dossier
                    JOIN %1$slien_categorie_tiers_consulte_om_collectivite
                        ON lien_categorie_tiers_consulte_om_collectivite.categorie_tiers_consulte = categorie_tiers_consulte.categorie_tiers_consulte
                            AND lien_categorie_tiers_consulte_om_collectivite.om_collectivite = dossier.om_collectivite
                WHERE
                    dossier.dossier = \'%2$s\'
                UNION
                SELECT -- Récupération des catégories de tiers lié à des acteurs du dossier
                    categorie_tiers_consulte.categorie_tiers_consulte,
                    categorie_tiers_consulte.libelle
                FROM
                    %1$sdossier
                    JOIN %1$slien_dossier_tiers
                        ON dossier.dossier = lien_dossier_tiers.dossier
                    JOIN %1$stiers_consulte
                        ON lien_dossier_tiers.tiers = tiers_consulte.tiers_consulte
                    JOIN %1$scategorie_tiers_consulte
                        ON tiers_consulte.categorie_tiers_consulte = categorie_tiers_consulte.categorie_tiers_consulte
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idDossier)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        // Faire un order by sur un union ne fonctionne pas. A la place
        // c'est le tableau des résultats qui est ordonné.
        usort($qres['result'], function($a, $b) {
            return strcmp($a['libelle'], $b['libelle']);
        });
        return $qres['result'];
    }

    /**
     * SURCHARGE - retoursousformulaire
     *
     * Surcharge des boutons de retour des formulaires des acteurs pour renvoyer vers l'onglet
     * acteur du dossier.
     *
     *  @param string $idxformulaire : identifiant de l'objet du formulaire
     *  @param string $retourformulaire : nom de l'objet du formulaire
     *  @param string $val : valeur du formulaire ?
     *  @param string $objsf : nom de l'objet du sous-formulaire
     *  @param string $premiersf : ?
     *  @param string $tricolsf : tri des colonnes
     *  @param string $valdation : indique si le formulaire à déjà été soumis (1) ou pas (0)
     *  @param string $idx : id de l'objet du sous-formulaire
     *  @param string $maj : identifiant de l'action en cours
     *  @param string $retour : type de retour (tab ou form)
     */
    function retoursousformulaire($idxformulaire = NULL, $retourformulaire = NULL, $val = NULL,
                                  $objsf = NULL, $premiersf = NULL, $tricolsf = NULL, $validation = NULL,
                                  $idx = NULL, $maj = NULL, $retour = NULL) {
        // Récupération et affichage du lien de retour
        $back_link = $this->get_tab_back_link($objsf, $retourformulaire, $idxformulaire);
        printf(
            '<a class="retour" href="#" id="sousform-action-%s-back-%s" data-href="%s">%s</a>',
            $objsf,
            uniqid(),
            $back_link,
            __('Retour')
        );
    }

    /**
     * Methode permettant aux objets metiers de surcharger facilement
     * la methode sousformulaire et de passer facilement des variables
     * supplementaires en parametre. Cette methode retourne une chaine
     * representant l'attribut action du formulaire.
     *
     * Cette surcharge permet de passer l'identifiant et le libellé de la
     * catégorie dans les paramètres de l'url. Ces paramètres sont nécessaires
     * pour pouvoir filter le champs tiers des formulaires d'ajout et modif
     * par la catégorie du listing.
     *
     * @return string
     */
    function getDataSubmitSousForm() {
        $category = $this->f->get_submitted_get_value('category');
        $libCategory = $this->f->get_submitted_get_value('libcategory');
        $url = sprintf(
            '%s&amp;category=%s&amp;libcategory=%s',
            parent::getDataSubmitSousForm(),
            intval($category),
            urlencode($libCategory)
        );
        return $url;
    }

    /**
     * SURCHARGE - get_back_link()
     *
     * Surcharge de la méthode dbform::get_back_link() pour proposé un cas spécific
     * au lien_dossier_tiers. Si le retour est "specific" on renvoie ainsi vers
     * l'onglet acteur.
     *
     * @param string $view : type de vue (formulaire ou sous-formulaire)
     * @return string url de redirection
     */
    function get_back_link($view = "formulaire") {
        $href = parent::get_back_link($view);
        if ($this->getParameter("retour") === "specific") {
            $obj = $this->get_absolute_class_name();
            $retourformulaire = $this->getParameter("retourformulaire");
            $idxformulaire = $this->getParameter("idxformulaire");
            $href = $this->get_tab_back_link($obj, $retourformulaire, $idxformulaire);
        }
        return $href;
    }

    /**
     * TRIGGER - triggerajouter.
     *
     * /!\ ATTENTION /!\
     * Utilisation d'un INSERT SQL pour cette table dans la méthode add_dossier_actors()
     * de la classe dossier.
     *
     * @param string $id
     * @param null &$dnu1 @deprecated  Ne pas utiliser.
     * @param array $val Tableau des valeurs brutes.
     * @param null $dnu2 @deprecated  Ne pas utiliser.
     *
     * @return boolean
     */
    public function triggerajouter($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        parent::triggerajouter($id, $dnu1, $val, $dnu2);
    }
}
