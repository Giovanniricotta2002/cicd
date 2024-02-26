<?php
/**
 * OM_WIDGET - Surcharge du core
 *
 * L'objectif de la surcharge est de coder les vues spécifiques des widgets
 * de type 'file'.
 *
 * @package openads
 * @version SVN : $Id: om_widget.class.php 5673 2015-12-21 19:35:24Z nmeucci $
 */

require_once PATH_OPENMAIRIE."obj/om_widget.class.php";

class om_widget extends om_widget_core {

    const WIDGET_COMPTEUR_SIGNATURE_TPL = '
        <div class="container">
            {{message}}
            <section class="widget-suivi-conso-stats">
                <div class="statistic {{class}}">
                    <h4>Signatures utilisées</h4>
                    <div>
                    <span class="disk"></span>
                        <p>
                            <span class="count">{{count}}</span>
                            <span class="quota"> / {{quota}}</span>
                            signatures 
                        </p>
                    </div>
                </div>
                <div class="statistic remaining">
                    <h4>Signatures {{left_or_over_label}}</h4>
                    <div>
                        <span class="disk"></span>
                        <p>
                            <span class="count">{{left_or_over}}</span>
                            <span class="quota"> / {{quota}}</span> signatures
                        </p>
                    </div>
                </div>
            </section>
            <section class="widget-suivi-conso-progress">
                <div class="signature-progress-bar {{class}}" style="width: {{consumed_percent}}%"></div>
                <p class="percent">{{consumed_percent}} %</p>
            </section>
        </div>
    ';

    /**
     *
     */
    var $template_help = '<div class="widget-help"><span class="info-16" title="%s"></span></div>';

    /**
     *
     */
    var $template_footer = '
    <div class="widget-footer">
        <a href="%s">
            %s
        </a>
    </div>
    ';

    /**
     * Tableau contenant la liste des filtres pouvant être utilisé
     * dans les widgets.
     */
    protected $existing_filters = array(
        'division',
        'instructeur',
        'instructeur_secondaire',
        'instructeur_ou_instructeur_secondaire'
    );

    /**
     * Cette méthode retourne un arbre html représentant un raccourci.
     * 
     * Un raccourci est composé d'un lien, d'une image et d'une description.
     * Voir les widgets :
     *  - widget_nouvelle_demande_autre_dossier
     *  - widget_nouvelle_demande_dossier_encours
     *  - widget_nouvelle_demande_nouveau_dossier
     */
    function get_display_widget_shortlink($config) {
        return sprintf (
            '<section><a class="flex_center" href="%s"><img src="%s" alt="%s"/><p>%s</p></a></section>',
            $config["a_href"],
            $config["img_src"],
            $config["img_alt"],
            $config["a_content"]
        );
    }

    /**
     * WIDGET DASHBOARD - widget_nouvelle_demande_autre_dossier.
     */
    function view_widget_nouvelle_demande_autre_dossier($content = null) {
        echo $this->get_display_widget_shortlink(array(
            "a_href" => OM_ROUTE_TAB."&obj=demande_autre_dossier",
            "img_src" => "../app/img/dossier-existant.png",
            "img_alt" => _("Autres dossiers"),
            "a_content" => _("Cliquer ici pour saisir une nouvelle demande concernant un dossier en cours ou une autorisation existante"),
        ));
    }

    /**
     * WIDGET DASHBOARD - widget_nouvelle_demande_dossier_encours.
     */
    function view_widget_nouvelle_demande_dossier_encours($content = null) {
        echo $this->get_display_widget_shortlink(array(
            "a_href" => OM_ROUTE_TAB."&obj=demande_dossier_encours",
            "img_src" => "../app/img/dossier-existant.png",
            "img_alt" => _("Dossier en cours"),
            "a_content" => _("Cliquer ici pour saisir une nouvelle demande concernant un dossier en cours"),
        ));
    }

    /**
     * WIDGET DASHBOARD - widget_nouvelle_demande_nouveau_dossier.
     */
    function view_widget_nouvelle_demande_nouveau_dossier($content = null) {
        $params = array("contexte");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        $arguments_default = array(
            "contexte" => "standard"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "contexte"
                    && in_array($elem, array("standard", "contentieux"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        $contexte = $arguments["contexte"];
        $widget_config = array(
            "a_href" => OM_ROUTE_FORM."&obj=demande_nouveau_dossier&amp;action=0&amp;advs_id=&amp;tricol=&amp;valide=&amp;retour=tab&amp;new=",
            "img_src" => "../app/img/dossier-nouveau.png",
            "img_alt" => _("Nouveau dossier"),
            "a_content" => _("Cliquer ici pour saisir une nouvelle demande concernant le depot d'un nouveau dossier"),
        );
        if ($contexte == "contentieux") {
            $widget_config["a_href"] = OM_ROUTE_FORM."&obj=demande_nouveau_dossier_contentieux&amp;action=0&amp;advs_id=&amp;tricol=&amp;valide=&amp;retour=tab&amp;new=";
        }
        echo $this->get_display_widget_shortlink($widget_config);
    }

    /**
     * WIDGET DASHBOARD - widget_recherche_dossier.
     *
     * Quatre cas d'utilisation :
     *  - 1 - La valeur recherchée correspond exactement au code d'un DI,
     *    alors on accède directement à la fiche de visualisation du DI.
     *  - 2 - La valeur recherchée renvoi plusieurs DI, alors on accède au
     *    listing des dossiers d'instruction avec le formulaire de 
     *    recherche avancée pré-rempli avec la valeur saisie.
     *  - 3 - La valeur recherchée renvoi aucun enregistrement, alors on 
     *    affiche un message en ce sens directement dans le widget.
     *  - 4 - Aucune valeur n'est saisie, alors on affiche un message en ce 
     *    sens directement dans le widget.
     *
     * @return void
     */
    function view_widget_recherche_dossier($content = null) {

        /**
         * Traitement de la validation du formulaire
         */
        //
        if ($this->f->get_submitted_post_value("validation") != null
            && $this->f->get_submitted_post_value("dossier") === '') {

            //
            // AUCUNE VALEUR SAISIE
            //

            // Cas d'utilisation n°4
            // Affiche un message d'erreur
            $erreur = _("Veuillez saisir un No de dossier.");
        }
        //
        if ($this->f->get_submitted_post_value("validation") != null
            && $this->f->get_submitted_post_value("dossier") !== null
            && $this->f->get_submitted_post_value("dossier") !== '') {
            //
            $list_dossiers = $this->execute_recherche_dossier();

            $total_dossiers = count($list_dossiers);
            // Si on obtient un seul résultat
            if ($total_dossiers == 1) {
                // On reformate le dossier
                $dossier = str_replace(' ', '', $list_dossiers[0]);
                // On redirige vers le listing des DI
                echo '
                <script type="text/javascript" >
                    widget_recherche_dossier(\''.$dossier.'\', 1, \'dossier_instruction\');
                </script>
                ';
                // On arrête l'exécution du script car l'utilisateur a été 
                // redirigé vers un autre script
                exit();
            }
            // Si on obtient plusieurs résultats
            if ($total_dossiers > 1) {
                // Mémorisation de la recherche
                $search = $this->f->db->escapesimple($this->f->get_submitted_post_value("dossier"));
                // Ajout d'une étoile au début s'il n'y en n'a pas.
                // Par defaut * est toujours ajouté à la fin des recherches.
                if (substr($search, 0, 1) != '*') {
                    $search = '*'.$search;
                }
                // On redirige vers le listing des DI
                // 
                echo '
                <script type="text/javascript" >
                    widget_recherche_dossier(\''.$search.'\', '.$total_dossiers.', \'dossier_instruction\');
                </script>
                ';
                // On arrête l'exécution du script car l'utilisateur a été 
                // redirigé vers un autre script
                exit();
            }
            // Cas d'utilisation n°3
            // Si aucun dossier trouve
            // Affiche un message d'erreur
            $erreur = _("Aucun dossier trouvé.");
        }

        /**
         * Affichage du widget
         */
        // Affichage du message d'informations
        printf(
            '<div class="widget-help"><span class="info-16" title="%s"></span></div>',
            _("Permet la recherche directe de dossiers d'instruction.\n\n".
               "Deux modes de saisie sont possibles :\n".
               "- Code de dossier intégral 'PC0130551300027P0' ou 'PC 013055 13 00027P0' pour un accès direct à la fiche de visualisation du dossier d'instruction,\n".
               "- Code de dossier partiel 'DP' ou 'PC*P0' ou '*013055*' pour un accès au formulaire de recherche avancée des dossiers d'instruction.")
        );
        // Ouverture du form
        echo "\t<form method=\"post\" id=\"widget_recherche_dossier_form\" action=\"".OM_ROUTE_DASHBOARD."\">\n";
        // Affichage d'un éventuel message d'erreur
        if (isset($erreur) && $erreur != "") {
            $class = "error";
            $this->f->displayMessage($class, $erreur);
        }
        // Configuration du formulaire de recherche
        $champs = array("dossier");
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        $form->setLib("dossier", '<span class="om-icon om-icon-16 om-icon-fix loupe-16">Recherche</span>');
        $form->setType("dossier", "text");
        $form->setTaille("dossier", 20);
        $form->setMax("dossier", 250);
        // Affichage du formulaire
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        // Affichage des contrôles du formulaire
        echo "\t<div class=\"formControls\">\n";
        echo "\t\t<input type=\"submit\" class=\"om-button ui-button ui-widget ui-state-default ui-corner-all\"
        value=\""._("Valider")."\" name=\"validation\" />\n";
        echo "\t</div>\n";
        // Fermeture du form
        echo "\t</form>\n";
    }

    /**
     * WIDGET DASHBOARD - widget_recherche_parametrable.
     * 
     * Le widget permet de lister les dossiers en fonction de l'état,
     * du filtre instructeur ou division et d'avoir un message d'aide personnalisé
     */
    function view_widget_recherche_parametrable($content=null) {
        $params = array('etat', 'filtre', 'tri', 'affichage', 'source_depot', 'message_help');
        $arguments = $this->get_arguments($content, $params);
        $conf = $this->get_config_recherche_dossier_parametrable($arguments);

        $sql = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            %s
                %s
                %s
            %s
            %s",
            $conf["query_ct_select"],
            $conf["query_ct_from"],
            '%s',
            trim($conf["query_ct_where"]) !== '' ? "WHERE" : '',
            $conf["query_ct_where"],
            '%s', // emplacement pour les conditions du filtre
            $conf["query_ct_orderby"],
            $conf["query_ct_limit"]
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $sql,
            $conf['arguments']['filtre']
        );
        $sql = sprintf(
            $sql,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        $search = array(
            "valide" => "false",
            "advanced-search-submit" => "",
        );

        // Ajout des arguments pour la recherche avancée
        foreach ($conf['arguments'] as $key => $argument) {
            $search[$key] = $argument;
        }

        // Récupération de l'identifiant de l'instructeur pour la recherche avancée
        if ($conf['arguments']['filtre'] == 'instructeur' || $conf['arguments']['filtre'] == 'instructeur_secondaire') {
            $id_instructeur = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        instructeur.instructeur
                    FROM
                        %1$sinstructeur
                        LEFT JOIN %1$som_utilisateur
                            ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
                    WHERE
                        om_utilisateur.login = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($_SESSION['login'])
                ),
                array(
                    "origin" => __METHOD__
                )
            );

            $conf['arguments']['filtre'] == 'instructeur' ?
                ($search['instructeur'] = $id_instructeur['result']) :
                ($search['instructeur_2'] = $id_instructeur['result']);
        }

        // Récupération de l'identifiant de la division pour la recherche avancée
        if ($conf['arguments']['filtre'] == 'division') {
            $search['division'] = $_SESSION['division'];
        }

        // Récupération de la collectivité pour la recherche avancée
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $search['om_collectivite'] = $_SESSION['collectivite'];
        }

        // Génération de l'advs_id
        $advs_id = str_replace(array('.',','), '', microtime(true));
        $search["advanced-search-submit"] = "";
        $_SESSION["advs_ids"][$advs_id] = serialize($search);

        // Affichage du message d'informations
        printf(
            $this->template_help,
            $conf["message_help"]
        );
        // Affichage du widget avec une bulle
        if ($conf["arguments"]["affichage"] === "nombre") {
            $qres = $this->f->get_one_result_from_db_query(
                $sql,
                array(
                    "origin" => __METHOD__
                )
            );
            
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                // Affichage du message d'informations
                echo __("Aucun dossier trouvé.");
                // Exit
                return;
            }
            $this->display_resultat_bulle($qres['result'], __("dossier(s) trouvé(s)"), "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $sql,
                array(
                    'origin' => __METHOD__
                )
            );

            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                // Affichage du message d'informations
                echo _("Vous n'avez pas de dossiers pour le moment.");
                // Exit
                return;
            }

            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-1 firstcol">
                    %s
                </td>
                <td class="col-1">
                    %s
                </td>
                <td class="col-2 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro du dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier"]
                    ),
                    // Colonne 2 - Libellé du dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date dépôt
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_depot"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Numéro de dossier
                _('dossier'),
                // Colonne 2 - Libellé du dossier
                _('nom_petitionnaire'),
                // Colonne 3 - Date de dépôt
                _('date_depot'),
                // Contenu du tableau
                $ct_tbody
            );            
        }


        // Affichage du footer
        printf(
            $this->template_footer,
            sprintf(
                OM_ROUTE_TAB."&obj=dossier_instruction&advs_id=%s&tricol=%s&message_help=%s",
                $advs_id,
                $conf['arguments']['tri'],
                urlencode($conf['message_help'])
            ),

            // titre
            _("Voir +")
        );
    }

    /**
     * Cette méthode permet de récupérer la configuration du widget 'Recherche
     * paramétrable'.
     * 
     * @return array
     */
    function get_config_recherche_dossier_parametrable($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        $arguments_default = array(
            'affichage' => "nombre",
            'filtre' => 'instructeur',
            'tri' => -6
        );

        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "division", "instructeur_secondaire", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "affichage"
                    && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "tri"
                    && is_numeric(str_replace('-', '', $elem)) === true) {
                    //
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }

        // Ajout du filtre sur la source du dépôt
        $query_ct_where_source_depot = "";
        if (isset($arguments["source_depot"])
            && ! is_null($arguments["source_depot"]) 
            && $arguments["source_depot"] !== "") {

            $source_depot = $arguments["source_depot"];
            if (! is_null($source_depot) && $source_depot !== "") {
                $query_ct_where_source_depot = sprintf(
                    " demande.source_depot = '%s' ",
                    $source_depot
                );
            }
        }

        $query_limit = '';
        // Gestion de l'affichage
        if ($arguments['affichage'] == 'nombre') {
            $query_ct_select = "COUNT(DISTINCT(dossier.dossier))";
            $query_ct_orderby = '';
        } else {
            $query_ct_select = "
                dossier.dossier,
                $select__dossier_libelle__column as dossier_libelle,
                dossier.date_depot
            ";

            $query_ct_orderby = sprintf("ORDER BY dossier.date_depot DESC");
        }

        $query_ct_from = sprintf(
            '%1$sdossier
            INNER JOIN %1$sdossier_instruction_type
                ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
            INNER JOIN %1$sdossier_autorisation_type_detaille
                ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            LEFT JOIN %1$sdemande
                ON demande.dossier_instruction = dossier.dossier
            LEFT JOIN %1$sinstructeur
                ON dossier.instructeur=instructeur.instructeur
            LEFT JOIN %1$som_utilisateur
                ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
            LEFT JOIN %1$sdivision
                ON dossier.division=division.division',
            DB_PREFIXE
        );

        // Filtre sur la collectivité en fonction du niveau
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_join_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_join_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_where_filtre = "";

        //
        $query_ct_where = ' dossier_instruction_type.sous_dossier IS NOT TRUE';
        if (isset($arguments["etat"])
            && is_null($arguments["etat"]) === false
            && $arguments["etat"] !== "") {
            //
            $query_ct_where .= sprintf(
                " AND dossier.etat = '%s' ",
                $arguments['etat']
            );
        }

        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            $select__dossier_libelle__column_as,
            'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("date_depot").'"'
        );

        $message_help = "";
        // Récupération du message d'aide
        if (isset($arguments["message_help"])
            && ! is_null($arguments["message_help"]) 
            && $arguments["message_help"] !== "") {

            $message_help = $arguments["message_help"];
        }

        // Construction du FROM
        $query_ct_from = $query_ct_from.$query_ct_join_collectivite_filter;

        // Construction du WHERE
        $query_ct_where = sprintf(
            '%s %s %s',
            $query_ct_where,
            trim($query_ct_where_source_depot) !== '' ? 'AND' : '',
            $query_ct_where_source_depot
        );

        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_select" => $query_ct_select,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where,
            "query_ct_orderby" => $query_ct_orderby,
            "query_ct_limit" => $query_limit,
        );
    }

    /**
     * WIDGET DASHBOARD - widget_suivi_instruction_parametrable.
     * 
     * Le widget permet de lister les instructions en fonction du statut de signature,
     * du filtre instructeur ou division et d'avoir un message d'aide personnalisé
     */
    function view_widget_suivi_instruction_parametrable($content=null) {
        $params = array(
            'statut_signature',
            'filtre',
            'tri',
            'affichage',
            'message_help',
            'etat',
            'evenement_type',
            'nb_jours_avant_date_limite',
            'nb_mois_avant_date_limite',
            'nb_jours_max_apres_date_evenement',
            'nb_mois_max_apres_date_evenement',
            'affichage_colonne',
            'envoi_cl',
            'type_cl',
            'evenement_id',
            'instruction_finalisee',
            'instruction_notifiee',
            'signataire_description',
            'nb_max_resultat',
            'codes_datd',
            'combinaison_criteres',
            'exclure_evenement_id',
            'statut_dossier',
            'tri_tab_widget',
        );
        $arguments = $this->get_arguments($content, $params);
        $conf = $this->get_config_suivi_instruction_parametrable($arguments);
        $filtre = $conf["arguments"]["filtre"];

        $sql = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            %s
                %s
                %s
            %s
            %s",
            $conf["query_ct_select"],
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            trim($conf["query_ct_where"]) !== '' ? "WHERE" : '',
            $conf["query_ct_where"],
            '%s', // emplacement pour les conditions du filtre
            $conf["query_ct_orderby"],
            $conf["query_ct_limit"]
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $sql,
            $conf['arguments']['filtre']
        );
        $sql = sprintf(
            $sql,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        // Affichage du message d'informations
        printf(
            $this->template_help,
            $conf["message_help"]
        );

        // Affichage du widget avec une bulle
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Execution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $sql,
                array(
                    "origin" => __METHOD__
                )
            );
            
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                // Affichage du message d'informations
                echo __("Aucun document trouvé.");
                // Exit
                return;
            }
            $this->display_resultat_bulle($qres['result'], __("document(s) trouvé(s)"), "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $sql,
                array(
                    'origin' => __METHOD__
                )
            );

            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                // Affichage du message d'informations
                echo _("Il n'y a pas de documents pour le moment.");
                // Exit
                return;
            }

            $affichage_colonne = '';
            $aff_col_is_array = false;
            if (isset($conf['arguments']['affichage_colonne']) 
                && $conf['arguments']['affichage_colonne'] != '') {
                
                $affichage_colonne = explode(';', $conf['arguments']['affichage_colonne']);

                // On veut savoir si c'est un tableau
                $aff_col_is_array = is_array($affichage_colonne);
            }

            // La classe css "title" a été enlevé pour chaque colonne afin que les intitulés soit centrés.
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="col-1 %s">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="col-2 %s">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="col-3 %s">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="col-4 %s">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="col-5 %s">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="col-6 %s">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="col-7 %s">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="col-8 %s lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="col-9 %s lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-1 firstcol">
                    %s
                </td>
                <td class="col-2 %s">
                    %s
                </td>
                <td class="col-3 %s">
                    %s
                </td>
                <td class="col-4 %s .tab-date">
                    %s
                </td>
                <td class="col-5 %s .tab-date">
                    %s
                </td>
                <td class="col-6 %s .tab-date">
                    %s
                </td>
                <td class="col-7 %s">
                    %s
                </td>
                <td class="col-8 %s">
                    %s
                </td>
                <td class="col-9 %s .tab-date">
                    %s
                </td>
                <td class="col-10 widget_icon_align_center %s lastcol">
                    %s
                </td>
            </tr>
            ';

            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_instruction&retour_widget=suivi_instruction_parametrable&widget_recherche_id='.$conf['widget_recherche_id'].'&amp;action=3&amp;idx=%s%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';

            $tab_trad = array(
                'waiting' => __('waiting'),
                'in_progress' => __('en cours'),
                'canceled' => __('annulé'),
                'expired' => __('expiré'), 
                'finished' => __('signé')
            );

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"],
                    isset($conf['arguments']['tri']) ? '&tricol='.$conf['arguments']['tri'] : ''
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Libellé du dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),

                    isset($row['petitionnaire']) === true ? '' : 'widget_hide_col',
                    
                    // Colonne 2 - Pétitionnaire
                    sprintf(
                        $template_link,
                        $ct_href,
                        isset($row['petitionnaire']) === true ? $row["petitionnaire"] : null
                    ),

                    isset($row['evenement_libelle']) === true ? '' : 'widget_hide_col',
                    
                    // Colonne 3 - Instruction
                    sprintf(
                        $template_link,
                        $ct_href,
                        isset($row['evenement_libelle']) === true ? $row["evenement_libelle"] : null
                    ),

                    isset($row['date_envoi_signature']) === true ? '' : 'widget_hide_col',
                    
                    // Colonne 4 - Date envoi en signature
                    sprintf(
                        $template_link,
                        $ct_href,
                        isset($row['date_envoi_signature']) === true ? $this->f->formatDate($row["date_envoi_signature"]) : null
                    ),

                    isset($row['date_retour_signature']) === true ? '' : 'widget_hide_col',
                    
                    // Colonne 5 - Date de retour signature
                    sprintf(
                        $template_link,
                        $ct_href,
                        isset($row['date_retour_signature']) === true ? $this->f->formatDate($row["date_retour_signature"]) : null
                    ),

                    isset($row['date_evenement']) === true ? '' : 'widget_hide_col',
                    
                    // Colonne 6 - Date de "dépôt"
                    sprintf(
                        $template_link,
                        $ct_href,
                        isset($row['date_evenement']) === true ? $this->f->formatDate($row["date_evenement"]) : null
                    ),
                    
                    isset($row['signataire']) === true ? '' : 'widget_hide_col',
                    
                    // Colonne 7 - Signataire
                    sprintf(
                        $template_link,
                        $ct_href,
                        isset($row['signataire']) === true ? $row["signataire"] : null
                    ),

                    isset($row['statut_signature']) === true ? '' : 'widget_hide_col',

                    // Colonne 8 - Statut signature
                    sprintf(
                        $template_link,
                        $ct_href,
                        isset($row['statut_signature']) === true && $row['statut_signature'] != null ? $tab_trad[$row["statut_signature"]] : null
                    ),

                    isset($row['date_limite']) === true ? '' : 'widget_hide_col',
                    
                    // Colonne 9 - Date limite
                    sprintf(
                        $template_link,
                        $ct_href,
                        isset($row['date_limite']) === true ? $this->f->formatDate($row["date_limite"]) : null
                    ),

                    isset($row['alerte_5_jours']) === true ? '' : 'widget_hide_col',
                    
                    // Colonne 10 - Alerte 5 jours
                    sprintf(
                        $template_link,
                        $ct_href,
                        (isset($row['alerte_5_jours']) === true  && $row['alerte_5_jours'] === 't') ? '<img src="../app/img/enjeu-urba-16x16.png"></img>' : null
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Libellé du dossier
                __('dossier'),

                ($aff_col_is_array == true && in_array('petitionnaire', $affichage_colonne)) || $affichage_colonne == 'petitionnaire' ? '' : 'widget_hide_col',
                // Colonne 2 - Pétitionnaire
                __('petitionnaire'),

                ($aff_col_is_array == true && in_array('instruction', $affichage_colonne)) || $affichage_colonne == 'instruction' ? '' : 'widget_hide_col',
                // Colonne 3 - Instruction
                __('instruction'),

                ($aff_col_is_array == true && in_array('date_envoi_signature', $affichage_colonne)) || $affichage_colonne == 'date_envoi_signature' ? '' : 'widget_hide_col',
                
                // Colonne 4 - Date envoi signature
                __('envoi parapheur'),

                ($aff_col_is_array == true && in_array('date_retour_signature', $affichage_colonne)) || $affichage_colonne == 'date_retour_signature' ? '' : 'widget_hide_col',
                // Colonne 5 - Date de retour signature
                __('retour parapheur'),

                ($aff_col_is_array == true && in_array('date_evenement', $affichage_colonne)) || $affichage_colonne == 'date_evenement' ? '' : 'widget_hide_col',
                // Colonne 6 - Date de retour signature
                __('dépôt document'),

                ($aff_col_is_array == true && in_array('signataire', $affichage_colonne)) || $affichage_colonne == 'signataire' ? '' : 'widget_hide_col',
                // Colonne 7 - Signataire
                __('signataire'),

                ($aff_col_is_array == true && in_array('statut_signature', $affichage_colonne)) || $affichage_colonne == 'statut_signature' ? '' : 'widget_hide_col',
                // Colonne 8 - Instruction
                __('statut_signature'),

                ($aff_col_is_array == true && in_array('date_limite', $affichage_colonne)) || $affichage_colonne == 'date_limite' ? '' : 'widget_hide_col',
                // Colonne 9 - Date limite
                __('limite'),

                ($aff_col_is_array == true && in_array('alerte_5_jours', $affichage_colonne)) || $affichage_colonne == 'alerte_5_jours' ? '' : 'widget_hide_col',
                // Colonne 10 - Alerte 5 jours
                __('alerte à 5 jours'),

                // Contenu du tableau
                $ct_tbody
            );
        }


        // Affichage du footer
        printf(
            $this->template_footer,
            sprintf(
                OM_ROUTE_TAB."&obj=suivi_instruction_parametrable&widget_recherche_id=%s%s",
                $conf['widget_recherche_id'],
                isset($conf['arguments']['tri']) ? '&tricol='.$conf['arguments']['tri'] : ''
            ),

            // titre
            _("Voir +")
        );
    }

    /**
     * Cette méthode permet de récupérer la configuration du widget 'Suivi
     * d'instruction paramétrable.
     * 
     * @return array
     */
    function get_config_suivi_instruction_parametrable($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        $arguments_default = array(
            'statut_signature' => null,
            'affichage' => "liste",
            'filtre' => 'instructeur',
            'affichage_colonne' => 'date_envoi_signature;date_limite',
            'evenement_type' => null,
            'etat' => null,
            'evenement_id' => null,
            'signataire_description' => null,
            'nb_max_resultat' => 5,
            'codes_datd' => null,
            'combinaison_criteres' => null,
            'exclure_evenement_id' => null,
            'statut_dossier' => null,
            'tri_tab_widget' => null,
        );

        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "division", "instructeur_secondaire", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "statut_signature"
                    && $elem != "") {
                    $arguments[$key] = explode(';', $elem);
                    continue;
                }
                if ($key === "evenement_type"
                    && $elem != "") {
                    $arguments[$key] = explode(';', $elem);
                    continue;
                }
                if ($key === "evenement_id"
                    && $elem != "") {
                    $arguments[$key] = explode(';', $elem);
                    continue;
                }
                if ($key === "exclure_evenement_id"
                    && $elem != "") {
                    $arguments[$key] = explode(';', $elem);
                    continue;
                }
                if ($key === "statut_dossier"
                    && $elem != "" && ($elem == "encours" || $elem == "cloture")) {
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "codes_datd"
                    && $elem != "") {
                    $arguments[$key] = explode(';', $elem);
                    continue;
                }
                if ($key === "signataire_description"
                    && $elem != "") {
                    $arguments[$key] = explode(';', $elem);
                    continue;
                }
                if ($key === "etat"
                    && $elem != "") {
                    $arguments[$key] = explode(';', $elem);
                    continue;
                }
                if ($key === "combinaison_criteres"
                    && $elem != "") {
                    $arguments[$key] = explode('|', $elem);
                    continue;
                }
                if ($key === "affichage_colonne"
                    && $elem != "") {
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "affichage"
                    && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "tri"
                    && is_numeric(str_replace('-', '', $elem)) === true) {
                    //
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "nb_max_resultat"
                    && is_numeric(str_replace('-', '', $elem)) === true) {
                    //
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "tri_tab_widget"
                    && in_array($elem, array("dossier","statut_signature","date_limite","date_envoi_signature","date_retour_signature","signataire","petitionnaire","instruction"))
                    || in_array($elem, array("-dossier","-statut_signature","-date_limite","-date_envoi_signature","-date_retour_signature","-signataire","-petitionnaire","-instruction"))) {
                    //
                    $arguments[$key] = $elem;
                    continue;
                }

            }
            //
            $arguments[$key] = $value;
        }

        $query_limit = '';
        // Gestion de l'affichage
        if ($arguments['affichage'] == 'nombre') {
            $query_ct_select = "COUNT(*)";
            $query_ct_orderby = '';
        } else {
            $query_ct_select = "
                dossier.dossier,
                $select__dossier_libelle__column as dossier_libelle
            ";


            if ($arguments['affichage_colonne'] != '') {
                $arguments['affichage_colonne'] = explode(';', $arguments['affichage_colonne']);
            }
            // Si il y a plusieurs colonnes supplémentaires
            if (isset($arguments['affichage_colonne'])
                && is_array($arguments['affichage_colonne'])) {

                $query_ct_select .= ', ';
                foreach ($arguments['affichage_colonne'] as $colonne) {
                    // Champ nécessitant un traitement spécifique
                    if ($colonne == 'date_limite') {
                        $query_ct_select .= 'CASE WHEN incomplet_notifie IS TRUE AND incompletude IS TRUE THEN
                                        dossier.date_limite_incompletude ELSE
                                        dossier.date_limite END as date_limite ';    
                    }
                    if ($colonne == 'date_envoi_signature') {
                        $query_ct_select .= 'instruction.date_envoi_signature ';
                    }
                    if ($colonne == 'date_retour_signature') {
                        $query_ct_select .= 'instruction.date_retour_signature ';
                    }
                    if ($colonne == 'date_evenement') {
                        $query_ct_select .= 'instruction.date_evenement ';
                    }
                    if ($colonne == 'signataire') {
                        $query_ct_select .= "TRIM(CONCAT(signataire_arrete.prenom, ' ', signataire_arrete.nom, ' ', signataire_arrete.description)) as signataire ";
                    }
                    if ($colonne == 'statut_signature') {
                        $query_ct_select .= 'instruction.statut_signature ';
                    }
                    if ($colonne == 'petitionnaire') {
                        $query_ct_select .= "CASE WHEN demandeur.qualite='particulier' 
                            THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
                            ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
                        END as petitionnaire ";
                    }
                    if ($colonne == 'instruction') {
                        $query_ct_select .= 'evenement.libelle as evenement_libelle';
                    }
                    if ($colonne == 'alerte_5_jours') {
                        $query_ct_select .= "CASE WHEN date_limite >= CURRENT_DATE AND CURRENT_DATE >= date_limite - 5 * interval '1 day'
                            THEN true
                            ELSE false
                        END as alerte_5_jours";
                    }
                    if (end($arguments['affichage_colonne']) != $colonne) {
                        $query_ct_select .= ', ';
                    }
                }
            }

            // On gère le cas où il n'y a qu'une seule colonne supplémentaire
            if (isset($arguments['affichage_colonne'])
                && is_array($arguments['affichage_colonne']) === false
                && $arguments['affichage_colonne'] != '') {

                $query_ct_select .= ', '.$arguments['affichage_colonne'];

            }

            $query_ct_orderby = '';

            // Correspondances SQL des colonnes possibles du widget
            $triMap = array(
                'dossier' => 'dossier.dossier',
                'signataire' => 'signataire_arrete.nom',
                'instruction' => 'evenement.libelle',
                'date_limite' => 'dossier.date_limite',
                'date_envoi_signature' => 'instruction.date_envoi_signature',
                'date_retour_signature' => 'instruction.date_retour_signature',
                'petitionnaire' => 'demandeur.particulier_nom',
                'statut_signature' => 'instruction.statut_signature'
            );

            // Si l'argument permettant de choisir la colonne sur laquelle faire le tri : 'tri_tab_widget', est renseigné
            if ($arguments['tri_tab_widget'] !== null) {
                $argumentLocal = $arguments['tri_tab_widget'];
                $ordreTri = substr($argumentLocal, 0, 1) === '-' ? 'DESC' : '';
                $cleTri = ltrim($argumentLocal, '-');
                $champTri = $triMap[$cleTri] ?? '';

                $query_ct_orderby = sprintf("ORDER BY %s %s", $champTri, $ordreTri);   
            }
            else {
                // On trie sur le champ date_envoi_signature si il existe
                if ( is_array($arguments['affichage_colonne'])
                    && in_array('date_envoi_signature', $arguments['affichage_colonne'])
                    || $arguments['affichage_colonne'] == 'date_envoi_signature') {
    
                    $query_ct_orderby = sprintf("ORDER BY instruction.date_envoi_signature");
                } elseif ( is_array($arguments['affichage_colonne'])
                    && in_array('date_limite', $arguments['affichage_colonne'])
                    || $arguments['affichage_colonne'] == 'date_limite') {
    
                    $query_ct_orderby = sprintf("ORDER BY date_limite");
                }
    
                if ( is_array($arguments['affichage_colonne'])
                    && in_array('date_evenement', $arguments['affichage_colonne'])
                    || $arguments['affichage_colonne'] == 'date_evenement') {
    
                    $query_ct_orderby = sprintf("ORDER BY instruction.date_evenement");
                }
            }

            $query_limit = sprintf(
                "LIMIT %s", 
                $arguments['nb_max_resultat']
            );
        }

        $query_ct_from = sprintf(
            '%1$sdossier
            INNER JOIN %1$sdossier_instruction_type
                ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
            INNER JOIN %1$sdossier_autorisation_type_detaille
                ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            INNER JOIN %1$sinstruction
                ON instruction.dossier = dossier.dossier
                AND (instruction.date_envoi_signature is NULL
                    AND instruction.instruction = (
                        SELECT
                            MAX(instruction.instruction)
                        FROM
                            %1$sinstruction
                        WHERE
                            instruction.dossier = dossier.dossier
                    ) OR instruction.date_envoi_signature = (
                        SELECT
                            MAX(instruction.date_envoi_signature)
                        FROM
                            %1$sinstruction
                        WHERE
                            instruction.dossier = dossier.dossier
                    )
                )
            LEFT JOIN %1$sinstructeur
                ON dossier.instructeur=instructeur.instructeur
            LEFT JOIN %1$som_utilisateur
                ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
            LEFT JOIN %1$sdivision
                ON dossier.division=division.division',
            DB_PREFIXE
        );

        // Filtre sur la collectivité en fonction du niveau
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_join_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']."
            ";
        } else {
            $query_ct_join_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }
        
        // Type d'évènement jointure
        $query_ct_from_filtre_evenement_type = '';
        // Filtre sur l'évènement
        if ((isset($arguments["evenement_type"])
            && is_null($arguments["evenement_type"]) === false
            && $arguments["evenement_type"] !== "")
            || (isset($arguments["evenement_id"])
            && is_null($arguments["evenement_id"]) === false
            && $arguments["evenement_id"] !== "")
            || (isset($arguments["exclure_evenement_id"])
            && is_null($arguments["exclure_evenement_id"]) === false
            && $arguments["exclure_evenement_id"] !== "")
            || (isset($arguments["type_cl"])
            && is_null($arguments["type_cl"]) === false
            && $arguments["type_cl"] !== "")
            || (is_array($arguments['affichage_colonne'])
                && in_array('instruction', $arguments['affichage_colonne'])
                || $arguments['affichage_colonne'] == 'instruction'))  {
            //
            $query_ct_from_filtre_evenement_type = " INNER JOIN ".DB_PREFIXE."evenement
            ON instruction.evenement=evenement.evenement";
        }


        // Filtre sur les demandeur
        $query_ct_from_filtre_petitionnaire = '';
        if (is_array($arguments['affichage_colonne'])
                && in_array('petitionnaire', $arguments['affichage_colonne'])
                || $arguments['affichage_colonne'] == 'petitionnaire') {
            //
            $query_ct_from_filtre_petitionnaire = " INNER JOIN ".DB_PREFIXE."lien_dossier_demandeur
            ON dossier.dossier = lien_dossier_demandeur.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
            INNER JOIN ".DB_PREFIXE."demandeur
            ON lien_dossier_demandeur.demandeur = demandeur.demandeur";
        }

        // Type d'évènement
        $query_ct_where_evenement_type_filter = '';
        if (isset($arguments["evenement_type"])
            && is_null($arguments["evenement_type"]) === false
            && is_array($arguments["evenement_type"])
            && count($arguments["evenement_type"]) != 0) {
            //
            $sql_evenement_type = '(';
            //
            foreach ($arguments["evenement_type"] as $evenement_type) {
                $sql_evenement_type .= " evenement.type = '".$this->f->db->escapesimple(strtolower($evenement_type))."' OR ";
            }
            $sql_evenement_type = substr($sql_evenement_type, 0, strlen($sql_evenement_type) - 4);
            //
            $query_ct_where_evenement_type_filter = $sql_evenement_type.') ';
        }

        // Identifiant d'évènement
        $query_ct_where_evenement_id_filter = '';
        if (isset($arguments["evenement_id"])
            && is_null($arguments["evenement_id"]) === false
            && is_array($arguments["evenement_id"])
            && count($arguments["evenement_id"]) != 0) {
            //
            $sql_evenement_id = '(';
            //
            foreach ($arguments["evenement_id"] as $evenement_id) {
                $sql_evenement_id .= " evenement.evenement = '".$this->f->db->escapesimple(strtolower($evenement_id))."' OR ";
            }
            $sql_evenement_id = substr($sql_evenement_id, 0, strlen($sql_evenement_id) - 4);
            //
            $query_ct_where_evenement_id_filter = $sql_evenement_id.') ';
        }

        // Exclusion des identifiants d'évènement
        $query_ct_where_exclure_evenement_id_filter = '';
        if (isset($arguments["exclure_evenement_id"])
            && is_null($arguments["exclure_evenement_id"]) === false
            && is_array($arguments["exclure_evenement_id"])
            && count($arguments["exclure_evenement_id"]) != 0) {
            //
            $sql_exclure_evenement_id = '(';
            //
            foreach ($arguments["exclure_evenement_id"] as $exclure_evenement_id) {
                $sql_exclure_evenement_id .= " evenement.evenement != '".$this->f->db->escapesimple(strtolower($exclure_evenement_id))."' AND ";
            }
            $sql_exclure_evenement_id = substr($sql_exclure_evenement_id, 0, strlen($sql_exclure_evenement_id) - 4);
            //
            $query_ct_where_exclure_evenement_id_filter = $sql_exclure_evenement_id.') ';
        }

        // Statut de signature
        $query_ct_where_statut_signature_filter = '';
        if (isset($arguments["statut_signature"])
            && is_null($arguments["statut_signature"]) === false
            && is_array($arguments["statut_signature"])
            && count($arguments["statut_signature"]) != 0) {
            //
            $sql_statut_signature = '(';
            //
            foreach ($arguments["statut_signature"] as $statut) {
                $sql_statut_signature .= " instruction.statut_signature = '".$this->f->db->escapesimple(strtolower($statut))."' OR ";
            }
            $sql_statut_signature = substr($sql_statut_signature, 0, strlen($sql_statut_signature) - 4);
            //
            $query_ct_where_statut_signature_filter = $sql_statut_signature.') ';
        }

        // Etat du dossier
        $query_ct_where_etat = '';
        if (isset($arguments["etat"])
            && is_null($arguments["etat"]) === false
            && is_array($arguments["etat"])
            && count($arguments["etat"]) != 0) {
            //
            $sql_etat = '(';
            //
            foreach ($arguments["etat"] as $etat) {
                $sql_etat .= " dossier.etat = '".$this->f->db->escapesimple(strtolower($etat))."' OR ";
            }
            $sql_etat = substr($sql_etat, 0, strlen($sql_etat) - 4);
            //
            $query_ct_where_etat = $sql_etat.') ';
        }

        $query_ct_from_filtre_signataire_description = '';
        if (isset($arguments["signataire_description"])
            && is_null($arguments["signataire_description"]) === false
            && $arguments["signataire_description"] !== ""
            || (is_array($arguments['affichage_colonne'])
                && in_array('signataire', $arguments['affichage_colonne'])
                || $arguments['affichage_colonne'] == 'signataire')) {
            //
            $query_ct_from_filtre_signataire_description = " INNER JOIN ".DB_PREFIXE."signataire_arrete
            ON instruction.signataire_arrete=signataire_arrete.signataire_arrete";
        }

        $query_ct_from_filtre_statut_dossier = '';
        if (isset($arguments["statut_dossier"])
            && is_null($arguments["statut_dossier"]) === false
            && $arguments["statut_dossier"] !== "") {
            //
            $query_ct_from_filtre_statut_dossier = " LEFT JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat";
        }

        $query_ct_where_statut_dossier_filter = '';
        if (isset($arguments["statut_dossier"])
            && is_null($arguments["statut_dossier"]) === false
            && ($arguments["statut_dossier"] == "encours" || $arguments["statut_dossier"] == "cloture")) {
            //
            $query_ct_where_statut_dossier_filter = " etat.statut = '".$this->f->db->escapesimple($arguments["statut_dossier"])."'";
        }

        // Signataire description
        $query_ct_where_signataire_description_filter = '';
        if (isset($arguments["signataire_description"])
            && is_null($arguments["signataire_description"]) === false
            && is_array($arguments["signataire_description"])
            && count($arguments["signataire_description"]) != 0) {
            //
            $sql_signataire_description = '(';
            //
            foreach ($arguments["signataire_description"] as $signataire_description) {
                $sql_signataire_description .= " signataire_arrete.description = '".$this->f->db->escapesimple($signataire_description)."' OR ";
            }
            $sql_signataire_description = substr($sql_signataire_description, 0, strlen($sql_signataire_description) - 4);
            //
            $query_ct_where_signataire_description_filter = $sql_signataire_description.') ';
        }

        // Nombre de jour date limite
        $query_ct_where_nb_jours_date_limite = '';
        if (isset($arguments["nb_jours_avant_date_limite"])
            && is_null($arguments["nb_jours_avant_date_limite"]) === false
            && $arguments["nb_jours_avant_date_limite"] > 0) {
            
            $query_ct_where_nb_jours_date_limite = sprintf(
                "(dossier.incomplet_notifie IS FALSE
                AND date_limite >= CURRENT_DATE AND date_limite <= CURRENT_DATE + %s * interval '1 day') ",
                $this->f->db->escapesimple(strtolower($arguments['nb_jours_avant_date_limite']))
            );
        }

        // Nombre de mois date limite
        $query_ct_where_nb_mois_date_limite = '';
        if (isset($arguments["nb_mois_avant_date_limite"])
            && is_null($arguments["nb_mois_avant_date_limite"]) === false
            && $arguments["nb_mois_avant_date_limite"] > 0) {
            
            $query_ct_where_nb_mois_date_limite = sprintf(
                "(dossier.incomplet_notifie IS FALSE
                AND date_limite >= CURRENT_DATE AND date_limite <= CURRENT_DATE + %s * interval '1 months') ",
                $this->f->db->escapesimple(strtolower($arguments['nb_mois_avant_date_limite']))
            );
        }

        // Nombre de jour max apres date d'évènement
        $query_ct_where_nb_jours_max_apres_date_evenement = '';
        if (isset($arguments["nb_jours_max_apres_date_evenement"])
            && is_null($arguments["nb_jours_max_apres_date_evenement"]) === false
            && $arguments["nb_jours_max_apres_date_evenement"] > 0) {
            
            $query_ct_where_nb_jours_max_apres_date_evenement = sprintf(
                "CURRENT_DATE <= date_evenement + %s * interval '1 day' ",
                $this->f->db->escapesimple(strtolower($arguments['nb_jours_max_apres_date_evenement']))
            );
        }

        // Nombre de mois max apres date d'évènement
        $query_ct_where_nb_mois_max_apres_date_evenement = '';
        if (isset($arguments["nb_mois_max_apres_date_evenement"])
            && is_null($arguments["nb_mois_max_apres_date_evenement"]) === false
            && $arguments["nb_mois_max_apres_date_evenement"] > 0) {
            
            $query_ct_where_nb_mois_max_apres_date_evenement = sprintf(
                "CURRENT_DATE <= date_evenement + %s * interval '1 months' ",
                $this->f->db->escapesimple(strtolower($arguments['nb_mois_max_apres_date_evenement']))
            );
        }

        // Envoyée au CL
        $query_ct_where_envoi_cl = '';
        if (isset($arguments["envoi_cl"])
            && $arguments["envoi_cl"] === true) {
            
            $query_ct_where_envoi_cl = "(instruction.envoye_cl_platau IS TRUE OR instruction.date_envoi_control_legalite IS NOT NULL) ";
        }

        // Type de contrôle de légalité
        $query_ct_where_type_cl = '';
        if (isset($arguments["type_cl"])
            && is_null($arguments["type_cl"]) === false
            && $arguments["type_cl"] == "Plat'AU") {
            
            $query_ct_where_type_cl = "(instruction.envoye_cl_platau IS TRUE) ";
        } elseif (isset($arguments["type_cl"])
            && is_null($arguments["type_cl"]) === false
            && $arguments["type_cl"] == "Papier") {
            
            $query_ct_where_type_cl = "(instruction.envoye_cl_platau IS FALSE AND instruction.date_envoi_control_legalite IS NOT NULL) ";
        }

        // Instruction notifiée
        $query_ct_where_instruction_notifiee = '';
        if (isset($arguments["instruction_notifiee"])
            && is_null($arguments["instruction_notifiee"]) === false
            && $arguments["instruction_notifiee"] !== '') {

            if ($arguments["instruction_notifiee"] === 'true') {
                $query_ct_where_instruction_notifiee = "instruction.date_retour_rar IS NOT NULL";
            } else {
                $query_ct_where_instruction_notifiee = "instruction.date_retour_rar IS NULL";
            }
        }

        // Instruction finalisée
        $query_ct_where_instruction_finalisee = '';
        if (isset($arguments["instruction_finalisee"])
            && is_null($arguments["instruction_finalisee"]) === false
            && $arguments["instruction_finalisee"] !== '') {
            
            $query_ct_where_instruction_finalisee = sprintf(
                "instruction.om_final_instruction IS %s",
                $this->f->db->escapesimple(strtolower($arguments['instruction_finalisee']))
            );
        }

        // Code datd
        $query_ct_where_codes_datd_filter = '';
        if (isset($arguments["codes_datd"])
            && is_null($arguments["codes_datd"]) === false
            && is_array($arguments["codes_datd"])
            && count($arguments["codes_datd"]) != 0) {
            //
            $sql_codes_datd = '(';
            //
            foreach ($arguments["codes_datd"] as $codes_datd) {
                $sql_codes_datd .= " LOWER(dossier_autorisation_type_detaille.code) = '".$this->f->db->escapesimple(strtolower($codes_datd))."' OR ";
            } 
            $sql_codes_datd = substr($sql_codes_datd, 0, strlen($sql_codes_datd) - 4);
            //
            $query_ct_where_codes_datd_filter = $sql_codes_datd.') ';
        }

        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'.__("dossier").'"',
            $select__dossier_libelle__column_as,
            'to_char(instruction.date_envoi_signature ,\'DD/MM/YYYY\') as "'.__("date_envoi_signature").'"'
        );

        $message_help = "";
        // Récupération du message d'aide
        if (isset($arguments["message_help"])
            && ! is_null($arguments["message_help"])
            && $arguments["message_help"] !== "") {

            $message_help = $arguments["message_help"];
        }

        // Filtrage sur l'instructeur ou la division
        $query_ct_where_filtre = $query_ct_from_filtre_evenement_type.
            $query_ct_from_filtre_signataire_description.
            $query_ct_from_filtre_petitionnaire.
            $query_ct_from_filtre_statut_dossier;

        // Construction du FROM
        $query_ct_from = $query_ct_from.
            $query_ct_join_collectivite_filter.
            $query_ct_where_filtre;

        $tab_criteres = array(
            'statut_signature' => $query_ct_where_statut_signature_filter,
            'etat' => $query_ct_where_etat,
            'evenement_type' => $query_ct_where_evenement_type_filter,
            'evenement_id' => $query_ct_where_evenement_id_filter,
            'nb_jours_avant_date_limite' => $query_ct_where_nb_jours_date_limite,
            'nb_jours_max_apres_date_evenement' => $query_ct_where_nb_jours_max_apres_date_evenement,
            'envoi_cl' => $query_ct_where_envoi_cl,
            'type_cl' => $query_ct_where_type_cl,
            'signataire_description' =>  $query_ct_where_signataire_description_filter,
            'instruction_notifiee' => $query_ct_where_instruction_notifiee,
            'instruction_finalisee' => $query_ct_where_instruction_finalisee,
            'codes_datd' => $query_ct_where_codes_datd_filter,
            'nb_mois_avant_date_limite' => $query_ct_where_nb_mois_date_limite,
            'nb_mois_max_apres_date_evenement' => $query_ct_where_nb_mois_max_apres_date_evenement,
            'exclure_evenement_id' => $query_ct_where_exclure_evenement_id_filter,
            'statut_dossier' => $query_ct_where_statut_dossier_filter,
        );

        $query_ct_where_combi = '';
        if (isset($arguments["combinaison_criteres"])
            && is_null($arguments["combinaison_criteres"]) === false
            && is_array($arguments["combinaison_criteres"])
            && count($arguments["combinaison_criteres"]) != 0) {
            //
            $sql_where_combi = '(';
            //
            foreach ($arguments["combinaison_criteres"] as $critere) {
                $sql_where_combi .= $tab_criteres[$critere].' OR ';
                unset($tab_criteres[$critere]);
            }
            $sql_where_combi = substr($sql_where_combi, 0, strlen($sql_where_combi) - 4);
            //
            $query_ct_where_combi = $sql_where_combi.') ';
        }

        // Construction du WHERE
        $sql_ct_where = ' dossier_instruction_type.sous_dossier IS NOT TRUE AND ';
        foreach ($tab_criteres as $condition) {
            if ($condition !== '') {
                $sql_ct_where .= $condition.' AND ';
            }
        }
        $query_ct_where = substr($sql_ct_where, 0, strlen($sql_ct_where) - 5);

        if ($query_ct_where_combi != '') {
            if ($query_ct_where != '') {
                $query_ct_where .= ' AND ';
            }
            $query_ct_where .= $query_ct_where_combi;
        }

        // Génération du widget recherche id
        if (isset($arguments['statut_signature']) && $arguments['statut_signature'] != null) {
            $arguments['statut_signature'] = implode(';', $arguments['statut_signature']);
        }
        if (isset($arguments['affichage_colonne']) && $arguments['affichage_colonne'] != null && is_array($arguments['affichage_colonne'])) {
            $arguments['affichage_colonne'] = implode(';', $arguments['affichage_colonne']);
        }
        if (isset($arguments['evenement_type']) && $arguments['evenement_type'] != null && is_array($arguments['evenement_type'])) {
            $arguments['evenement_type'] = implode(';', $arguments['evenement_type']);
        }
        if (isset($arguments['evenement_id']) && $arguments['evenement_id'] != null && is_array($arguments['evenement_id'])) {
            $arguments['evenement_id'] = implode(';', $arguments['evenement_id']);
        }
        if (isset($arguments['exclure_evenement_id']) && $arguments['exclure_evenement_id'] != null && is_array($arguments['exclure_evenement_id'])) {
            $arguments['exclure_evenement_id'] = implode(';', $arguments['exclure_evenement_id']);
        }
        if (isset($arguments['etat']) && $arguments['etat'] != null && is_array($arguments['etat'])) {
            $arguments['etat'] = implode(';', $arguments['etat']);
        }
        if (isset($arguments['signataire_description']) && $arguments['signataire_description'] != null && is_array($arguments['signataire_description'])) {
            $arguments['signataire_description'] = implode(';', $arguments['signataire_description']);
        }
        if (isset($arguments['codes_datd']) && $arguments['codes_datd'] != null && is_array($arguments['codes_datd'])) {
            $arguments['codes_datd'] = implode(';', $arguments['codes_datd']);
        }
        if (isset($arguments['combinaison_criteres']) && $arguments['combinaison_criteres'] != null && is_array($arguments['combinaison_criteres'])) {
            $arguments['combinaison_criteres'] = implode('|', $arguments['combinaison_criteres']);
        }
        $widget_recherche_id= str_replace(array('.',','), '', microtime(true));
        $_SESSION['widget_recherche_id'][$widget_recherche_id] = serialize($arguments);

        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_select" => $query_ct_select,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where,
            "query_ct_orderby" => $query_ct_orderby,
            "query_ct_limit" => $query_limit,
            "widget_recherche_id" => $widget_recherche_id
        );
    }



    /**
     * WIDGET DASHBOARD - widget_recherche_dossier_par_type.
     *
     * Le widget de recherche accès direct par type est similaire au widget de recherche
     * accès direct classique. Il permet en plus de choisir la portée de la recherche par
     * le biais d'un select : ADS ou RE* ou IN.
     * Selon le type de dossier choisi, lors de la recherche la redirection se fera vers
     * le menu Instruction ou Contentieux.
     *
     * @return void
     */
    function view_widget_recherche_dossier_par_type($content = null) {

        /**
         * Traitement de la validation du formulaire
         */
        if ($this->f->get_submitted_post_value("validation") != null
            && $this->f->get_submitted_post_value("dossier") !== null
            && $this->f->get_submitted_post_value("dossier") == '') {

            // AUCUNE VALEUR SAISIE
            // Affiche un message d'erreur
            $erreur = _("Veuillez saisir un No de dossier.");
        }
        //
        if ($this->f->get_submitted_post_value("validation") != null
            && $this->f->get_submitted_post_value("dossier") !== null
            && $this->f->get_submitted_post_value("dossier") != '') {
            //
            $list_dossiers = $this->execute_recherche_dossier("type");
            $posted_type_dossier = $this->f->get_submitted_post_value("type_dossier_recherche");
            // Définition des objets sur lesquels la redirection se fera
            if ($posted_type_dossier === "ADS") {
                $obj = "dossier_instruction";
            }
            if ($posted_type_dossier === "RE*") {
                $obj = "dossier_contentieux_tous_recours";
            }
            if ($posted_type_dossier === "IN") {
                $obj = "dossier_contentieux_toutes_infractions";
            }
            $total_dossiers = count($list_dossiers);
            // Si on obtient un seul résultat
            if ($total_dossiers == 1) {
                // On reformate le dossier
                $dossier = strtoupper(str_replace(' ', '', $list_dossiers[0]));
                // On redirige vers le listing des DI
                echo '
                <script type="text/javascript" >
                    widget_recherche_dossier(\'' . $dossier . '\', 1, \'' . $obj . '\');
                </script>
                ';
                // On arrête l'exécution du script car l'utilisateur a été 
                // redirigé vers un autre script
                exit();
            }
            // Si on obtient plusieurs résultats
            if ($total_dossiers > 1) {
                // Mémorisation de la recherche
                $search = $this->f->db->escapesimple($this->f->get_submitted_post_value("dossier"));
                // Ajout d'une étoile au début s'il n'y en n'a pas.
                // Par defaut * est toujours ajouté à la fin des recherches.
                if (substr($search, 0, 1) != '*') {
                    $search = '*'.$search;
                }
                // On redirige vers le listing des DI
                // 
                echo '
                <script type="text/javascript" >
                    widget_recherche_dossier(\''.$search.'\', '.$total_dossiers.', \'' . $obj . '\');
                </script>
                ';
                // On arrête l'exécution du script car l'utilisateur a été 
                // redirigé vers un autre script
                exit();
            }
            // Si aucun dossier trouve
            // Affiche un message d'erreur
            $erreur = _("Aucun dossier trouvé.");
        }

        /**
         * Affichage du widget
         */
        // Liste des paramètres
        $params = array("type_defaut", );
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "type_defaut" => "ADS",
        );
        $arguments = $this->get_arguments($content, $params);

        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "type_defaut"
                    && in_array($elem, array("ADS", "RE*", "IN"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        //
        $type_defaut = $arguments["type_defaut"];

        // Affichage du message d'informations
        printf(
            '<div class="widget-help"><span class="info-16" title="%s"></span></div>',
            _("Permet la recherche directe de dossiers d'instruction, avec choix de la portée de la recherche : ADS ou RE* ou IN.\n".
               "La sélection de la famille de dossier filtre les résultats et conditionne la redirection de l'utilisateur :\n".
               "- ADS : Instruction > Dossiers d'instruction > Recherche\n".
               "- RE* : Contentieux > Recours > Tous les Recours \n".
               "- IN : Contentieux > Infractions > Toutes les Infractions\n\n".
               "Deux modes de saisie sont possibles :\n".
               "- Code de dossier intégral 'PC0130551300027P0' ou 'PC 013055 13 00027P0' pour un accès direct à la fiche de visualisation du dossier d'instruction,\n".
               "- Code de dossier partiel 'DP' ou 'PC*P0' ou '*013055*' pour un accès au formulaire de recherche avancée des dossiers d'instruction.")
        );
        // Ouverture du form
        echo "\t<form method=\"post\" id=\"widget_recherche_dossier_par_type_form\" action=\"".OM_ROUTE_DASHBOARD."\">\n";
        // Affichage d'un éventuel message d'erreur
        if (isset($erreur) && $erreur != "") {
            $class = "error";
            $this->f->displayMessage($class, $erreur);
        }
        // Configuration du formulaire de recherche
        $champs = array("dossier", "type_dossier_recherche");
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        $form->setLib("dossier", '<span class="om-icon om-icon-16 om-icon-fix loupe-16">Recherche</span>');
        $form->setType("dossier", "text");
        $form->setTaille("dossier", 20);
        $form->setMax("dossier", 250);

        // Définition des types de dossiers visibles dans le select
        $options[0] = array("ADS",
            "RE*",
            "IN");
        $options[1] = array(
            _("ADS"),
            _("RE*"),
            _("IN"));

        $form->setType("type_dossier_recherche", "select");
        $form->setLib("om_profil", _("Tableau de bord pour le profil"));
        $form->setSelect('type_dossier_recherche', $options);
        $form->setVal('type_dossier_recherche', $type_defaut);
        $form->setLib('type_dossier_recherche', 'Type de dossier');

        // Affichage du formulaire
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        // Affichage des contrôles du formulaire
        echo "\t<div class=\"formControls\">\n";
        echo "\t\t<input type=\"submit\" class=\"om-button ui-button ui-widget ui-state-default ui-corner-all\"
        value=\""._("Valider")."\" name=\"validation\" />\n";
        echo "\t</div>\n";
        // Fermeture du form
        echo "\t</form>\n";
    }


    /**
     * Méthode générique exécutant une recherche par numéro de dossier dans 2 contextes
     * différents :
     * - le widget de recherche classique
     * - le widget de recherche avec choix du type/groupe de dossier
     *
     * @param string $filtre Indique si un filtre supplémentaire doit être appliqué à la
     * recherche de dossier. Seule valeur possible : "type".
     *
     * @return string $error_message Le message d'erreur s'il y en a un, sinon chaîne vide
     */
    protected function execute_recherche_dossier($filtre = null) {

        // Traitement des valeurs postées
        $posted_dossiers = $this->f->db->escapesimple(strtolower(str_replace("*", "%", $this->f->get_submitted_post_value("dossier"))));
        $posted_dossiers = str_replace(';', ',', $posted_dossiers);

        //
        // UNE VALEUR SAISIE
        //

        // WHERE - Filtre Collectivité
        $query_ct_where_collectivite = "";
        // Si collectivité utilisateur mono alors filtre sur celle-ci
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            //
            $query_ct_where_collectivite = " AND dossier.om_collectivite=".$_SESSION['collectivite'];
        }

        // WHERE - Filtre par groupe
        $query_ct_where_groupe = "";
        $query_ct_where_type_da = "";
        $query_ct_from = "";
        $query_ct_where_common = "";
        $posted_type_dossier = $this->f->get_submitted_post_value("type_dossier_recherche");
        // La variable $posted_type_dossier vaut null si on est dans le contexte du widget
        // de recherche de dossier classique (sans choix du type)
        if ($posted_type_dossier === null OR $posted_type_dossier === "ADS") {
            $query_ct_from = "
                LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
                    ON dossier.dossier_autorisation = 
                        dossier_autorisation.dossier_autorisation 
                LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
                    ON dossier_autorisation.dossier_autorisation_type_detaille = 
                        dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
                LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
                    ON dossier_autorisation_type_detaille.dossier_autorisation_type = 
                        dossier_autorisation_type.dossier_autorisation_type
                LEFT JOIN ".DB_PREFIXE."groupe
                    ON dossier_autorisation_type.groupe = groupe.groupe";
            //
            $query_ct_where_groupe = " 
                AND groupe.code != 'CTX'
            ";
        }
        if ($posted_type_dossier === "RE*" OR $posted_type_dossier === "IN") {
            $query_ct_from = "
                LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
                    ON dossier.dossier_autorisation = 
                        dossier_autorisation.dossier_autorisation 
                LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
                    ON dossier_autorisation.dossier_autorisation_type_detaille = 
                        dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
                LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
                    ON dossier_autorisation_type_detaille.dossier_autorisation_type = 
                        dossier_autorisation_type.dossier_autorisation_type
                    ";
            if ($posted_type_dossier === "RE*") {
                $posted_type_dossier = "RE";
            }
            $query_ct_where_type_da = "
                AND dossier_autorisation_type.code = '". $posted_type_dossier . "'
            ";
        }

        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        // Construction de la requête
        // Pour chaque dossier on cherche sur les deux champs du code du
        // dossier (un avec et un sans espaces)
        $posted_dossiers = explode(',', $posted_dossiers);
        $liste_dossiers = array();
        foreach ($posted_dossiers as $posted_dossier) {
            $sql = "
            SELECT 
                dossier
            FROM
                " . DB_PREFIXE . "dossier
                " . $query_ct_from . "
            WHERE
                (LOWER(dossier.dossier) LIKE '%".$posted_dossier."%' 
                OR LOWER(dossier.dossier_libelle) LIKE '%".$posted_dossier."%' )
            ";
            $sql .= $query_ct_where_collectivite . $query_ct_where_type_da . $query_ct_where_groupe;
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $sql,
                array(
                    'origin' => __METHOD__
                )
            );
            // On récupère les numéros de dossier dans les résultats
            foreach ($qres['result'] as $row) {
                $liste_dossiers[] = $row['dossier'];
            }
        }

        return $liste_dossiers;
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Dossiers
     * limites'.
     *
     * @return array
     */
    function get_config_dossiers_limites($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "nombre_de_jours" => 15,
            "codes_datd" => null,
            "filtre" => "instructeur",
            "restreindre_aux_tacites" => null,
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "nombre_de_jours" 
                    && intval($elem) > 0) {
                    // Ce doit être un entier
                    $arguments[$key] = intval($elem);
                    continue;
                } elseif ($key === "codes_datd"
                    && $elem != "") {
                    // Ce doit être un tableau
                    $arguments[$key] = explode(";", $elem);
                    continue;
                } elseif ($key === "filtre"
                    && in_array($elem, array("instructeur", "instructeur_secondaire", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "restreindre_aux_tacites"
                    && in_array($elem, array("true", "false"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        //
        $nombre_de_jours = $arguments["nombre_de_jours"];
        $codes_datd = $arguments["codes_datd"];
        $filtre = $arguments["filtre"];
        $restreindre_aux_tacites = $arguments["restreindre_aux_tacites"];

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
        dossier.dossier,
        $select__dossier_libelle__column as dossier_libelle,
        dossier.date_limite,
        dossier.date_limite_incompletude,
        CASE WHEN incomplet_notifie IS TRUE AND incompletude IS TRUE THEN
                dossier.date_limite_incompletude ELSE
                dossier.date_limite END as date_limite_na,
        COALESCE(
            demandeur.particulier_nom, 
            demandeur.personne_morale_denomination
        ) AS nom_petitionnaire,
        CASE 
            WHEN dossier.enjeu_erp is TRUE 
                THEN '<span class=''om-icon om-icon-16 om-icon-fix enjeu_erp-16'' title=''"._('Enjeu ERP')."''>ERP</span>' 
            ELSE 
                '' 
        END 
        ||
        CASE
            WHEN dossier.enjeu_urba is TRUE 
                THEN '<span class=''om-icon om-icon-16 om-icon-fix enjeu_urba-16'' title=''"._('Enjeu Urba')."''>URBA</span>' 
            ELSE 
                '' 
        END AS enjeu,
        etat.libelle as etat
        ";
        // SELECT - CHAMPAFFICHE
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            'COALESCE(
                demandeur.particulier_nom, 
                demandeur.personne_morale_denomination
            ) AS "'._("nom_petitionnaire").'"',
            'CASE 
                WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE 
                    THEN to_char(dossier.date_limite_incompletude, \'DD/MM/YYYY\') 
                ELSE
                    to_char(dossier.date_limite, \'DD/MM/YYYY\') 
            END as "'._("date_limite").'"',
            'CASE 
                WHEN dossier.enjeu_erp is TRUE 
                    THEN \'<span class="om-icon om-icon-16 om-icon-fix enjeu_erp-16" title="'._('Enjeu ERP').'">ERP</span>\'
                ELSE 
                    \'\' 
            END 
            ||
            CASE
                WHEN dossier.enjeu_urba is TRUE 
                    THEN \'<span class="om-icon om-icon-16 om-icon-fix enjeu_urba-16" title="'._('Enjeu Urba').'">URBA</span>\'
                ELSE 
                    \'\' 
            END AS "'._("enjeu").'"',
            'etat.libelle as "'.__("etat").'"',
            // XXX Attention cette colonne est cachée en css est doit donc rester la dernière du tableau
            'CASE WHEN incomplet_notifie IS TRUE AND incompletude IS TRUE THEN
                dossier.date_limite_incompletude ELSE
                dossier.date_limite END as date_limite_na',
        );
        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        LEFT JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat
        LEFT JOIN ".DB_PREFIXE."lien_dossier_demandeur
            ON dossier.dossier = lien_dossier_demandeur.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
        LEFT JOIN ".DB_PREFIXE."demandeur
            ON lien_dossier_demandeur.demandeur = demandeur.demandeur
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."instructeur
            ON dossier.instructeur=instructeur.instructeur
        LEFT JOIN ".DB_PREFIXE."om_utilisateur
            ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division
        %s
        ";


        $query_ct_where_collectivite_filter = "";
        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);
        // WHERE - COMMON
        $query_ct_where_common = "
        groupe.code != 'CTX'
        AND
        (
            (
                dossier.incomplet_notifie IS FALSE
                AND date_limite >= CURRENT_DATE AND date_limite <= CURRENT_DATE + ".$nombre_de_jours." * interval '1 day'
            )
            OR
            (
                dossier.incomplet_notifie IS TRUE
                AND dossier.incompletude IS TRUE
                AND date_limite_incompletude >= CURRENT_DATE AND date_limite_incompletude <= CURRENT_DATE + ".$nombre_de_jours." * interval '1 day'
            )
        )
        AND etat.statut != 'cloture'
        AND dossier.avis_decision IS NULL 
        ";
        // WHERE - TACITE
        // Filtre sur le caractère tacite
        $query_ct_where_tacite_filter = '';
        if (is_null($restreindre_aux_tacites) === false
            && $restreindre_aux_tacites === 'true') {
            //
            //
            $query_ct_where_tacite_filter = " AND LOWER(dossier.accord_tacite) = 'oui' ";
        }
        // WHERE - DATD
        // Filtre sur le type détaillé des dossiers
        $query_ct_where_datd_filter = "";
        if (!is_null($codes_datd)
            && is_array($codes_datd)
            && count($codes_datd) != 0) {
            //
            $sql_codes = "";
            //
            foreach ($codes_datd as $code) {
                $sql_codes .= " LOWER(dossier_autorisation_type_detaille.code) = '".$this->f->db->escapesimple(strtolower($code))."' OR ";
            }
            $sql_codes = substr($sql_codes, 0, strlen($sql_codes) - 4);
            //
            $query_ct_where_datd_filter = " AND ( ".$sql_codes." ) ";
        }
        // ORDER BY
        $query_ct_orderby = "
        date_limite_na
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_restreindre_aux_tacites = '';
        //
        if (is_null($restreindre_aux_tacites) === false
            && $restreindre_aux_tacites === 'true') {
            //
            $message_restreindre_aux_tacites = " "._("avec tacite automatique");
        }
        //
        $message_filtre = "";
        //
        switch($filtre) {
            case "instructeur" : 
                $message_filtre = " "._("(filtrés par instructeur)"); 
                break;
            case "instructeur_secondaire" : 
                $message_filtre = " "._("(filtrés par instructeur secondaire)"); 
                break;
            case "division" : 
                $message_filtre = " "._("(filtrés par division)"); 
                break;
        }
        //
        $message_help = sprintf(
            _("Les dossiers%s%s sur lesquels aucune décision n'a été prise et dont la date limite est dans moins de %s jours%s."),
            (is_null($codes_datd) ? "": " (".implode(";",$codes_datd).")"),
            $message_restreindre_aux_tacites,
            $nombre_de_jours,
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where_common" => $query_ct_where_common,
            "query_ct_where_tacite_filter" => $query_ct_where_tacite_filter,
            "query_ct_where_datd_filter" => $query_ct_where_datd_filter,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby,
        );
    }

    /**
     * WIDGET DASHBOARD - Dossiers limites
     *
     * @return void
     */
    function view_widget_dossiers_limites($content = null) {

        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         *
         * - nombre_de_jours : c'est le délai en jours avant la date limite à 
         *   partir duquel on souhaite voir apparaître les dossiers dans le 
         *   widget.
         *   (default) Par défaut la valeur est 15 jours.
         *
         * - codes_datd : la liste des types de dossiers à afficher. exemple :
         *   "PCI;PCA;DPS;CUa;CUb".
         *   (default) Par défaut tous les types sont affichés. [null]
         *
         * - filtre : 
         *    = instructeur
         *    = division
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         *
         * - restreindre_aux_tacites : permet d'afficher seulement les dossiers
         *   d'instruction dont le caractère tacite est actif.
         */
        // Liste des paramètres
        $params = array("nombre_de_jours", "codes_datd", "filtre", "restreindre_aux_tacites", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossiers_limites($arguments);
        //
        $nombre_de_jours = $conf["arguments"]["nombre_de_jours"];
        $codes_datd = $conf["arguments"]["codes_datd"];
        $filtre = $conf["arguments"]["filtre"];
        $restreindre_aux_tacites = $conf['arguments']['restreindre_aux_tacites'];

        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le tye d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 10",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }

        $query = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where_common"],
            $conf["query_ct_where_tacite_filter"],
            $conf["query_ct_where_datd_filter"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Templates nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Execution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );

            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                // Affichage du message d'informations
                echo __("Vous n'avez pas de dossiers limites pour le moment.");
                // Exit
                return;
            }
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
    
            /**
             * Si il n'y a aucun dossier à afficher, alors on affiche un message 
             * clair à l'utilisateur et on sort de la vue.
             */
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                // Affichage du message d'informations
                echo _("Vous n'avez pas de dossiers limites pour le moment.");
                // Exit
                return;
            }
    
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-3">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-4 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-1 firstcol">
                    %s
                </td>
                <td class="col-1">
                    %s
                </td>
                <td class="col-2">
                    %s
                </td>
                <td class="col-3">
                    %s
                </td>
                <td class="col-4 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 2 - Nom du pétitionnaire
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["nom_petitionnaire"]
                    ),
                    // Colonne 3 - Date limite
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_limite_na"])
                    ),
                    // Colonne 4 - Enjeu
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["enjeu"]
                    ),
                    // Colonne 5 - Etat
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["etat"]
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Numéro de dossier
                _('dossier'),
                // Colonne 2 - Nom du pétitionnaire
                _('nom_petitionnaire'),
                // Colonne 3 - Date limite
                _('date_limite'),
                // Colonne 4 - Enjeu
                _('enjeu'),
                // Colonne 5 - Etat
                _('etat'),
                // Contenu du tableau
                $ct_tbody
            );
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            // href (avec les paramètres du widget)
            sprintf(
                OM_ROUTE_TAB."&obj=dossiers_limites&nombre_de_jours=%s&codes_datd=%s&filtre=%s&restreindre_aux_tacites=%s",
                $nombre_de_jours,
                (is_null($codes_datd) ? "" : implode(";",$codes_datd)),
                $filtre,
                $restreindre_aux_tacites
            ),
            // titre
            _("Voir +")
        );
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Mes
     * recours'.
     *
     * @return array
     */
    function get_config_dossier_contentieux_recours($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                    && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        // Utilisation du filtre instructeur dédié au contentieux si le filtre
        // paramétré est "instructeur"
        if (! empty($arguments["filtre"]) && $arguments["filtre"] === 'instructeur') {
            $arguments["filtre"] = 'instructeur_ou_instructeur_secondaire';
        }
        $filtre = $arguments["filtre"];

        // SELECT - CHAMPAFFICHE
        //
        $case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
        THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
        ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
        END";
        //
        $trim_concat_terrain = '
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
        ) as "'.__("localisation").'"';
        //
        $case_requerant = "
        CASE WHEN demandeur_requerant.qualite = 'particulier' 
            THEN TRIM(CONCAT(demandeur_requerant.particulier_nom, ' ', demandeur_requerant.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_requerant.personne_morale_raison_sociale, ' ', demandeur_requerant.personne_morale_denomination)) 
        END
        ";

        //  /!\Attention en cas d'ajout d'une nouvelle colonne dans le $champAffiche, adapter l'index en consequence dans le fichier dossier_contentieux_toutes_recours.export_csv.inc.php/!\
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            'dossier_autorisation_type_detaille.libelle as "'._("type de dossier").'"',
            'dossier_autorisation_contestee.dossier_libelle as "'._("autorisation").'"',
            $case_demandeur.' as "'._("petitionnaire").'"',
            $trim_concat_terrain,
            $case_requerant.' as "'._("requerant").'"',
            'donnees_techniques.ctx_reference_dsj as "'._("ctx_reference_dsj").'"',
            'dossier.numero_versement_archive as "'.__('Numéro d\'archive').'"',
            'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("date de recours").'"',
            'avis_decision.libelle as "'._("decision").'"',
            'etat.libelle as "'._("etat").'"',
        );

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
        dossier.dossier,
        $select__dossier_libelle__column as dossier_libelle,
        dossier.date_depot
        ";

        // FROM
        $query_ct_from = 
        DB_PREFIXE."dossier
        LEFT JOIN (
            SELECT * 
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
        ) as demandeur
            ON demandeur.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_autorisation.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division = division.division
        LEFT JOIN ".DB_PREFIXE."avis_decision
           ON avis_decision.avis_decision=dossier.avis_decision
        LEFT OUTER JOIN ".DB_PREFIXE."arrondissement
            ON arrondissement.code_postal = dossier.terrain_adresse_code_postal
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('requerant')
        ) as demandeur_requerant
            ON demandeur_requerant.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier as dossier_autorisation_contestee
            ON dossier.autorisation_contestee = dossier_autorisation_contestee.dossier
        INNER JOIN (
            SELECT
            ctx_reference_dsj,
            dossier_instruction
            FROM ".DB_PREFIXE."donnees_techniques
        ) as donnees_techniques
            ON donnees_techniques.dossier_instruction = dossier.dossier
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."instructeur
                        ON dossier.instructeur = instructeur.instructeur
                    LEFT JOIN ".DB_PREFIXE."om_utilisateur
                        ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
        %s
        ";

        $query_ct_from_collectivite_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_from_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        }
        else {
            $query_ct_from_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_from_collectivite_filter);

        // WHERE - COMMON
        $query_ct_where_common = "
            LOWER(dossier_autorisation_type.code) = LOWER('RE')
        ";

        // ORDER BY
        $query_ct_orderby = "
        dossier.date_depot DESC, dossier.dossier DESC
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur_ou_instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            _("Les derniers recours%s."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby
        );
    }


    /**
     * WIDGET DASHBOARD - Mes recours
     * @return void
     */
    function view_widget_dossier_contentieux_recours($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         */
        // Liste des paramètres
        $params = array("filtre", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_contentieux_recours($arguments);
        // Récupération du filtre
        $filtre = $conf["arguments"]["filtre"];
        // Définit l'objet cible
        $obj = 'dossier_contentieux_tous_recours';
        if ($filtre === 'instructeur' || $filtre = 'instructeur_ou_instructeur_secondaire') {
            //
            $obj = 'dossier_contentieux_mes_recours';
        }

        /**
         * Composition de la requête
         */
        //
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 5",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }

        $query = sprintf("
            SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Vous n'avez pas de recours.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Vous n'avez pas de recours.");
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=%s&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';
            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // obj
                    $obj,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date de depot
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_depot"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date de depot
                _("Date de recours"),
                // Le Contenu
                $ct_tbody
            );
        }
        /**
         * Affichage du footer
         */
        //
        $template_link_footer = OM_ROUTE_TAB.'&obj=%s';
        //
        $link_footer = sprintf(
            $template_link_footer,
            $obj
        );
        //
        printf(
            $this->template_footer,
            $link_footer,
            _("Voir +")
        );
    }


    /**
     * WIDGET DASHBOARD - RSS
     * 
     * Cette fonction gère l'affichage du widget RSS.
     * 
     * Elle récupère trois arguments :
     * - urls (l'urls des flux rss séparé par une virgule)  
     * - mode (le mode utilisé par le widget, soit "server_side" donc uniquement
     *   sur server, soit "client_side" avec une récuperation des informations en
     *   javascript)
     * - max_item (le nombre d'information provenant du flux, à afficher)
     *
     * Si mode = "server_side" alors 
     * le DOM est construit dans la méthode view_widget_rss() de cette classe
     *
     * Si mode = client_side alors 
     * le DOM est construit en javascript dans script.js::bind_widget_rss()
     *
     * @param string $content Contenu du champ "texte" ou "arguments" du widget
     * @param string $id Identifiant de l'enregistrement "om_dashboard"
     * 
     * @return void
     */
    function display_widget_rss($content = null, $id = null) {
        // Liste des paramètres
        $params = array("urls", "mode", "max_item");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);

        // Requête SQL
        $dashboard = $this->f->get_inst__om_dbform(array(
            'obj' => 'om_dashboard',
            'idx' => $id
        ));
        $widget = $dashboard->getVal('om_widget');
        // Préparation du contenu du widget
        $htmlWidget = sprintf(
            '<div class="widget-rss-marker" data-id_widget="%d" data-mode="%s"/></div>',
            $widget,
            "server_side"
        );
        if ($arguments["mode"] === "client_side") {
            $htmlWidget = sprintf(
                '<div class="widget-rss-marker" data-id_widget="%d" data-mode="%s" data-urls="%s" data-max_item="%s"/></div>',
                $widget,
                "client_side",
                $arguments['urls'],
                $arguments['max_item']
            );
        }
        // Affichage du widget
        echo $htmlWidget;
    }



    /**
     * WIDGET DASHBOARD
     * 
     * Création du DOM du widget RSS dans le cas server_side.
     *
     * @return void
     */
    function view_widget_rss() {
        // Liste des paramètres
        $params = array("urls", "mode", "max_item");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($this->getVal('arguments'), $params);
        // Récupère les URLs des différents flux dans un tableau
        $urls = explode(',', $arguments['urls']);

        // On retire 1 à la valeur de max_item car nous bouclons à partir de 0
        $real_max_item = $arguments['max_item'] - 1;

        //Pour chaque url
        foreach ($urls as $url) {

            // Initialise le contenu vide
            $content = "";

            // Template de l'affichage en liste
            $render = "
                <ul>
                    <h4>%s</h4>
                    %s
                </ul>
            ";

            // Tempalte de l'affichage du contenu
            $content_flux_template = "
                <li>
                    <a href=%s target=_blank>
                        <h5>%s</h5>
                    </a>
                    <p>%s</>
                </li>
                ";

            // Instanciation de la classe DOMDocument
            $xmlDoc = new DOMDocument();
            @$ret = $xmlDoc->load($url);
            if ($ret !== true) {
                printf(
                    $render,
                    "Erreur",
                    "Erreur au chargement de l'URL. Contactez votre administrateur."
                );
                continue;
            }

            // Récupération du nom du flux
            $channel_title = $xmlDoc->getElementsByTagName('channel')->item(0)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;

            // Pour chaque item du flux
            $x = $xmlDoc->getElementsByTagName('item');
            if ($x->length > 0) {
                for ($i=0; $i<=$real_max_item; $i++) {
                    $item_title = $x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
                    $item_link = $x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
                    $item_desc = $x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
                    // Contenu
                    $content .= sprintf($content_flux_template, $item_link, $item_title, $item_desc);
                }
            } else {
                $content = "Aucune donnée disponible";
            }

            // Affiche le contenu du widget
            echo sprintf($render, $channel_title, $content);
        }
    }

  /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 004 - view_widget_rss
        // Permet d'accéder au widget RSS "server_side" depuis une URL
        $this->class_actions[4] = array(
            "identifier" => "widget-rss",
            "view" => "view_widget_rss",
            "permission_suffix" => "widget_rss",
        );

    }

    /**
     * WIDGET DASHBOARD - Mes infractions
     * @return void
     */
    function view_widget_dossier_contentieux_infraction($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         */
        // Liste des paramètres
        $params = array("filtre", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_contentieux_infraction($arguments);
        // Récupération du filtre
        $filtre = $conf["arguments"]["filtre"];
        // Définit l'objet cible
        $obj = 'dossier_contentieux_toutes_infractions';
        if ($filtre === 'instructeur' || $filtre === 'instructeur_ou_instructeur_secondaire') {
            //
            $obj = 'dossier_contentieux_mes_infractions';
        }

        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 5",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }

        $query = sprintf("
            SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );
        
        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Vous n'avez pas d'infraction.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Vous n'avez pas d'infraction.");
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2 lastcol">
                    %s
                </td>
            </tr>
            ';

            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=%s&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // obj
                    $obj,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date de depot
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_depot"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date de depot
                _("Date de réception"),
                // Le Contenu
                $ct_tbody
            );
        }
        /**
         * Affichage du footer
         */
        //
        $template_link_footer = OM_ROUTE_TAB.'&obj=%s';
        //
        $link_footer = sprintf(
            $template_link_footer,
            $obj
        );
        //
        printf(
            $this->template_footer,
            $link_footer,
            _("Voir +")
        );
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Mes
     * infractions'.
     *
     * @return array
     */
    function get_config_dossier_contentieux_infraction($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        // Utilisation du filtre instructeur dédié au contentieux si le filtre
        // paramétré est "instructeur"
        if (! empty($arguments["filtre"]) && $arguments["filtre"] === 'instructeur') {
            $arguments["filtre"] = 'instructeur_ou_instructeur_secondaire';
        }
        $filtre = $arguments["filtre"];

        // SELECT - CHAMPAFFICHE
        //
        $trim_concat_terrain = '
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
        ) as "'.__("localisation").'"';
        //
        $case_contrevenant = "
        CASE WHEN demandeur_contrevenant.qualite = 'particulier' 
            THEN TRIM(CONCAT(demandeur_contrevenant.particulier_nom, ' ', demandeur_contrevenant.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_contrevenant.personne_morale_raison_sociale, ' ', demandeur_contrevenant.personne_morale_denomination)) 
        END
        ";
        //  /!\Attention en cas d'ajout d'une nouvelle colonne dans le $champAffiche, adapter l'index en consequence dans le fichier dossier_contentieux_toutes_infractions.export_csv.inc.php/!\
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $trim_concat_terrain,
            $case_contrevenant.' as "'._("contrevenant").'"',
            'donnees_techniques.ctx_reference_dsj as "'._("ctx_reference_dsj").'"',
            'numero_versement_archive as "'.__('N° archive').'"',
            'to_char(dossier.date_premiere_visite ,\'DD/MM/YYYY\') as "'._("date_premiere_visite").'"',
            'to_char(dossier.date_derniere_visite ,\'DD/MM/YYYY\') as "'._("date_derniere_visite").'"',
            'etat.libelle as "'._("etat").'"',
        );

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
        dossier.dossier,
        $select__dossier_libelle__column as dossier_libelle,
        dossier.date_depot
        ";

        // FROM
        $query_ct_from = 
        DB_PREFIXE."dossier
        LEFT JOIN (
            SELECT * 
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
        ) as demandeur
            ON demandeur.dossier = dossier.dossier
        INNER JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat%s
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_autorisation.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division = division.division
        LEFT JOIN ".DB_PREFIXE."avis_decision
           ON avis_decision.avis_decision=dossier.avis_decision
        LEFT OUTER JOIN ".DB_PREFIXE."arrondissement
            ON arrondissement.code_postal = dossier.terrain_adresse_code_postal
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('contrevenant')
        ) as demandeur_contrevenant
            ON demandeur_contrevenant.dossier = dossier.dossier
        INNER JOIN (
            SELECT
            ctx_reference_dsj,
            ctx_infraction,
            dossier_instruction
            FROM ".DB_PREFIXE."donnees_techniques
        ) as donnees_techniques
            ON donnees_techniques.dossier_instruction = dossier.dossier
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."instructeur
                        ON dossier.instructeur = instructeur.instructeur
                    LEFT JOIN ".DB_PREFIXE."om_utilisateur
                        ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
        LEFT JOIN ".DB_PREFIXE."instructeur as instructeur_secondaire
                        ON dossier.instructeur_2 = instructeur_secondaire.instructeur
                    LEFT JOIN ".DB_PREFIXE."om_utilisateur as utilisateur_2
                        ON instructeur_secondaire.om_utilisateur = utilisateur_2.om_utilisateur
        %s
        ";

        $query_ct_from_collectivite_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_from_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        }
        else {
            $query_ct_from_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        // Retourne seulement les dossiers en cours d'instruction, lorsque le
        // filtre sur instructeur est activé
        $query_ct_where_etat_ctx_filter = "" ;
        if ($filtre === "instructeur_ou_instructeur_secondaire") {
            $query_ct_where_etat_ctx_filter = " AND etat.statut = 'encours'";
        }

        $query_ct_from = sprintf(
            $query_ct_from,
            $query_ct_where_etat_ctx_filter,
            $query_ct_from_collectivite_filter
        );

        // WHERE - COMMON
        $query_ct_where_common = "
            LOWER(dossier_autorisation_type.code) = LOWER('IN')
        ";

        // ORDER BY
        $query_ct_orderby = "
        dossier.date_depot DESC, dossier.dossier DESC
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur_ou_instructeur_secondaire":
                $message_filtre = " ".__("en cours d'instruction")." ".__("dont je suis l'instructeur");
                break;
            case "instructeur_secondaire":
                $message_filtre = " ".__("en cours d'instruction")." ".__("dont je suis l'instructeur secondaire");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            _("Les dernières infractions%s."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where_common,
            "query_ct_orderby" => $query_ct_orderby
        );
    }

    /**
     * Cet méthode permet de formater, la chaîne de caractères reçue du 
     * paramétrage du widget en un tableau de valeurs dont les clés 
     * correspondent aux clés passées en paramètre.
     *
     * @param string $content
     * @param array $params
     *
     * @return array
     */
    function get_arguments($content = null, $params = array()) {
        //
        $arguments = array();
        // On explose les paramètres reçus avec un élément par ligne
        $params_tmp1 = explode("\n", $content);
        // On boucle sur chaque ligne de paramètre
        foreach ($params_tmp1 as $key => $value) {
            // On explose le paramètre de sa valeur avec le séparateur '='
            $params_tmp2[] = explode("=", $value);
        }
        // On boucle sur chaque paramètre reçu pour vérifier si la valeur reçue
        // est acceptable ou non
        foreach ($params_tmp2 as $key => $value) {
            //
            if (!isset($value[0]) || !isset($value[1])) {
                continue;
            }
            //
            if (in_array(trim($value[0]), $params)) {
                $arguments[trim($value[0])] = trim($value[1]);
            }
        }
        //
        return $arguments;
    }

    /**
     * WIDGET DASHBOARD - Retours de messages
     *
     * @return void
     */
    function view_widget_messages_retours($content = null) {

        /**
         * Ce widget est configurable via l'interface Web. Lors de la création
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         *
         * - filtre :
         *    = instructeur
         *    = division
         *    = aucun
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         *
         * - contexte :
         *    = standard
         *    = contentieux
         *    (defaut) Par défaut le contexte est standard.
         *
         * - dossier_cloture :
         *    = true
         *    = false
         *    (default) false
         */
        // Liste des paramètres
        $params = array("filtre", "contexte", "dossier_cloture");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_messages_retours($arguments);
        //
        $filtre = $conf["arguments"]["filtre"];
        //
        $contexte = $conf["arguments"]["contexte"];

        /**
         * Composition de la requête
         */
        $query = sprintf("
            SELECT
                COUNT(*)
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s",
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where_common"],
            $conf["query_ct_where_groupe"],
            '%s' // emplacement pour les conditions du filtre
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        // Pour les messages en plus du filtre ont souhaite récupérer tous les messages
        // à destination de la commune pour les collectivité mono
        if ($conf['arguments']['filtre'] != 'aucun') {
            if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                // Modifie la condition du filtre pour récupérer les messages voulus (filtre
                // instructeur, instructeur_secondaire ou division) ainsi que les messages de
                // à destination de la commune.
                // Le filtre récupéré a un 'AND' devant la condition pour éviter une erreur de
                // base de donnée on le supprime pour ne récupérer que la condition et pouvoir
                // l'associer à la condition sur le destinataire
                $sqlFilter['WHERE'] = sprintf(
                    ' AND (%s %s dossier_message.destinataire = \'commune\')',
                    str_replace(' AND ', '', $sqlFilter['WHERE']),
                    ! empty($sqlFilter['WHERE']) ? 'OR' : ''
                );
            } else {
                // Modifie la condition du filtre pour récupérer les messages voulus (filtre
                // instructeur, instructeur_secondaire ou division) qui sont à destination de
                // l'instructeur
                $sqlFilter['WHERE'] = sprintf(
                    ' %s AND dossier_message.destinataire = \'instructeur\'',
                    $sqlFilter['WHERE']
                );
            }
        }
        // Construction de la requête en intégrant les filtres
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Exécution de la requête
         */
        //
        $qres = $this->f->get_one_result_from_db_query(
            $query,
            array(
                "origin" => __METHOD__
            )
        );

        // Affichage du message d'informations
        printf(
            $this->template_help,
            $conf["message_help"]
        );

        //
        if (intval($qres['result']) === 0) {
            //
            echo __("Aucun message non lu.");
            return;
        }


        /**
         *
         */
        $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");

        // Définit le lien de redirection vers le listing en fonction du
        // contexte et du filtre
        if ($contexte === 'standard') {
            //
            switch ($filtre) {
                case 'instructeur':
                    $obj_href_more_link = 'messages_mes_retours';
                    break;
                case 'instructeur_ou_instructeur_secondaire':
                    $obj_href_more_link = 'messages_mes_retours';
                    break;
                case 'instructeur_secondaire':
                    $obj_href_more_link = 'messages_mes_retours';
                    break;
                case 'division':
                    $obj_href_more_link = 'messages_retours_ma_division';
                    break;
                case 'aucun':
                    $obj_href_more_link = 'messages_tous_retours';
                    break;
            }
        }
        //
        if ($contexte === 'contentieux') {
            //
            switch ($filtre) {
                case 'instructeur':
                    $obj_href_more_link = 'messages_contentieux_mes_retours';
                    break;
                case 'instructeur_ou_instructeur_secondaire':
                    $obj_href_more_link = 'messages_contentieux_mes_retours';
                    break;
                case 'division':
                    $obj_href_more_link = 'messages_contentieux_retours_ma_division';
                    break;
                case 'aucun':
                    $obj_href_more_link = 'messages_contentieux_tous_retours';
                    break;
            }
        }

        //
        if (!$this->f->isAccredited(array($obj_href_more_link, $obj_href_more_link."_tab"), "OR")) {
            return;
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            // href
            sprintf(
                OM_ROUTE_TAB.'&obj=%s&dossier_cloture=%s&filtre=%s',
                $obj_href_more_link,
                $conf["arguments"]["dossier_cloture"],
                $filtre
            ),
            // titre
            _("Voir +")
        );
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Retours de
     * messages'.
     *
     * @return array
     */
    function get_config_messages_retours($arguments) {
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "contexte" => "standard",
            "dossier_cloture" => "false",
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "instructeur_secondaire", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
                //
                if ($key === "contexte"
                    && in_array($elem, array("standard", "contentieux"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "dossier_cloture"
                    && in_array($elem, array("true", "false"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        //
        $filtreWidget = $arguments["filtre"];
        //
        $contexte = $arguments["contexte"];
        $filtre = $contexte == 'contentieux' &&
            (empty($filtre) || $filtre == 'instructeur' || $filtre == 'instructeur_secondaire') ?
            'instructeur_ou_instructeur_secondaire' :
            'instructeur';
        // Utilisation du filtre instructeur dédié au contentieux si le filtre
        // paramétré est "instructeur" ou "instructeur_secondaire" et que le
        // contexte est "contentieux"
        $filtre = $contexte == 'contentieux' &&
            (empty($filtre) ||
                $filtre == 'instructeur' ||
                $filtre == 'instructeur_secondaire') ?
            'instructeur_ou_instructeur_secondaire' :
            'instructeur';

        /**
         * Construction de la requête
         */
        $query_ct_from_collectivite_filter = "";
        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_from_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_from_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from_dossier_cloture_filter = "LEFT JOIN ".DB_PREFIXE."etat
        ON dossier.etat = etat.etat";

        // FROM
        $query_ct_from = sprintf(
            '%1$sdossier_message
            LEFT JOIN %1$sdossier
                ON dossier_message.dossier=dossier.dossier
            LEFT JOIN %1$sdossier_instruction_type
                ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type
            LEFT JOIN %1$sinstructeur
                ON dossier.instructeur = instructeur.instructeur
            LEFT JOIN %1$som_utilisateur
                ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
            LEFT JOIN %1$sinstructeur as instructeur_secondaire
                ON dossier.instructeur_2 = instructeur_secondaire.instructeur
            LEFT JOIN %1$som_utilisateur as utilisateur_2
                ON instructeur_secondaire.om_utilisateur = utilisateur_2.om_utilisateur
            LEFT JOIN %1$sdivision
                ON dossier.division=division.division
            %2$s
            %3$s',
            DB_PREFIXE,
            $query_ct_from_collectivite_filter,
            $arguments["dossier_cloture"] == "false" ?
                $query_ct_from_dossier_cloture_filter :
                ""
        );


        // Filtre les dossiers par contexte
        $query_ct_where_groupe_filter = " AND LOWER(groupe.code) != 'ctx'";
        if ($contexte === 'contentieux') {
            //
            $query_ct_where_groupe_filter = " AND LOWER(groupe.code) = 'ctx'";
        }

        $query_ct_where_dossier_cloture_filter = "AND etat.statut != 'cloture'";

        // WHERE - COMMON
        $query_ct_where_common = sprintf(
            "dossier_message.lu IS FALSE AND
            dossier_instruction_type.sous_dossier IS NOT TRUE
            %s
            %s",
            $query_ct_where_groupe_filter,
            $arguments["dossier_cloture"] == "false" ?
                $query_ct_where_dossier_cloture_filter :
                ""
        );

        // Filtre du groupe
        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        switch ($arguments["dossier_cloture"]) {
            case 'true':
                $message_filtre .= " ".__("en cours et clôturé");
                break;
            default:
                $message_filtre .= " ".__("en cours");
                break;
        }
        //
        switch ($filtreWidget) {
            case "instructeur":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre .= " "._("dont je suis l'instructeur ou dont le destinataire est 'commune'");
                } else {
                    $message_filtre .= " "._("dont je suis l'instructeur et dont le destinataire est 'instructeur'");
                }
                break;
            case "division":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre .= " "._("situés dans ma division ou dont le destinataire est 'commune'");
                } else {
                    $message_filtre .= " "._("situés dans ma division et dont le destinataire est 'instructeur'");
                }
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre .= " "._("situés dans ma collectivité");
                } else {
                    $message_filtre .= " "._("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $template_message_help = _("Les messages marqués comme 'non lu' qui concernent des dossiers d'instruction%s.");
        //
        if ($contexte === 'contentieux') {
            //
            $template_message_help = _("Les messages marqués comme 'non lu' qui concernent des dossiers contentieux%s.");
        }
        //
        $message_help = sprintf(
            $template_message_help,
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_from" => $query_ct_from,
            "query_ct_where_common" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
        );
    }

    /**
     * WIDGET DASHBOARD - Retours de consultation
     *
     * @return void
     */
    function view_widget_consultation_retours($content = null) {

        /**
         * Ce widget est configurable via l'interface Web. Lors de la création
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         *
         * - filtre :
         *    = instructeur
         *    = division
         *    = aucun
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         */
        // Liste des paramètres
        $params = array("filtre", );
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_consultation_retours($arguments);
        //
        $filtre = $conf["arguments"]["filtre"];

        /**
         * Composition de la requête
         */

        $query = sprintf(
            "SELECT
                count(*)
            FROM
                %s
                %s
            WHERE
                %s
                %s",
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where_common"],
            '%s' // emplacement pour les conditions du filtre
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Exécution de la requête
         */
        //
        $qres = $this->f->get_one_result_from_db_query(
            $query,
            array(
                "origin" => __METHOD__
            )
        );

        // Affichage du message d'informations
        printf(
            $this->template_help,
            $conf["message_help"]
        );

        //
        if (intval($qres['result']) === 0) {
            //
            echo __("Aucun retour de consultation non lu.");
            return;
        }


        /**
         *
         */
        $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        /**
         *
         */
        if ($filtre === "aucun") {
            $obj_href_more_link = "consultation_tous_retours";
        } elseif ($filtre === "division") {
            $obj_href_more_link = "consultation_retours_ma_division";
        } else {
            $obj_href_more_link = "consultation_mes_retours";
        }

        //
        if (!$this->f->isAccredited(array($obj_href_more_link, $obj_href_more_link."_tab"), "OR")) {
            return;
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            // href
            sprintf(
                OM_ROUTE_TAB.'&obj=%s&filtre=%s',
                $obj_href_more_link,
                $filtre
            ),
            // titre
            __("Voir +")
        );

    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Retours de
     * consultation'.
     *
     * @return array
     */
    function get_config_consultation_retours($arguments) {
        // Initialisation du tableau des paramètres avec ses valeurs par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "instructeur_secondaire", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        //
        $filtre = $arguments["filtre"];

        /**
         * Construction de la requête
         */
        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."consultation
        LEFT JOIN ".DB_PREFIXE."avis_consultation
            ON consultation.avis_consultation=avis_consultation.avis_consultation
        LEFT JOIN ".DB_PREFIXE."dossier
            ON consultation.dossier=dossier.dossier
        INNER JOIN ".DB_PREFIXE."dossier_instruction_type
            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
        INNER JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."service
            ON consultation.service=service.service
        LEFT JOIN ".DB_PREFIXE."tiers_consulte
            ON consultation.tiers_consulte=tiers_consulte.tiers_consulte
        LEFT JOIN ".DB_PREFIXE."motif_consultation
            ON consultation.motif_consultation=motif_consultation.motif_consultation
        LEFT JOIN ".DB_PREFIXE."instructeur
            ON dossier.instructeur=instructeur.instructeur
        LEFT JOIN ".DB_PREFIXE."om_utilisateur
            ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division
        %s";

        $query_ct_where_collectivite_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);

        // WHERE - COMMON
        $query_ct_where_common = "
        consultation.lu IS FALSE AND
        dossier_instruction_type.sous_dossier IS NOT TRUE
        ";

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur":
                $message_filtre = " "._("dont je suis l'instructeur");
                break;
            case "instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur secondaire");
                break;
            case "division":
                $message_filtre = " "._("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            _("Les consultations marquées comme 'non lu' qui concernent des ".
               "dossiers d'instruction%s."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_from" => $query_ct_from,
            "query_ct_where_common" => $query_ct_where_common,
        );
    }


    /**
     * WIDGET DASHBOARD - widget_commission_retours
     *
     * Ce widget est configurable via l'interface Web. Lors de la création
     * du widget dans le paramétrage il est possible de spécifier la ou les
     * options suivantes :
     *
     * - filtre :
     *    = instructeur
     *    = division
     *    = aucun
     *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
     *
     * @param string $content Arguments pour le widget, ici les filtres.
     * @return void
     */
    function view_widget_commission_retours($content = null) {
        // Liste des paramètres
        $params = array("filtre", );
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_commission_retours($arguments);
        //
        $filtre = $conf["arguments"]["filtre"];

        /**
         * Composition de la requête
         */

        $query = sprintf(
            "SELECT
                count(*)
            FROM
                %s
                %s
            WHERE
                %s
                %s",
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where_common"],
            '%s' // emplacement pour les conditions du filtre
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Exécution de la requête
         */
        //
        $qres = $this->f->get_one_result_from_db_query(
            $query,
            array(
                "origin" => __METHOD__
            )
        );

        // Affichage du message d'informations
        printf(
            $this->template_help,
            $conf["message_help"]
        );

        if (intval($qres['result']) === 0) {
            //
            echo __("Aucun retour de commission non lu.");
            return;
        }


        /**
         * Panel
         */
        $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");

        /**
         * Widget footer
         */
        if ($filtre === "aucun") {
            $obj_href_more_link = "commission_tous_retours";
        } elseif ($filtre === "division") {
            $obj_href_more_link = "commission_retours_ma_division";
        } else {
            $obj_href_more_link = "commission_mes_retours";
        }

        //
        if (!$this->f->isAccredited(array($obj_href_more_link, $obj_href_more_link . "_tab"), "OR")) {
            return;
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            // href
            sprintf(
                '%s&obj=%s&filtre=%s',
                OM_ROUTE_TAB,
                $obj_href_more_link,
                $filtre
            ),
            // titre
            __("Voir +")
        );
    }

    /**
     * Cette méthode permet de récupérer la configuration du widget 'Retours de
     * consultation'.
     *
     * @return array
     */
    function get_config_commission_retours($arguments) {
        // Initialisation du tableau des paramètres avec ses valeurs par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "instructeur_secondaire", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        //
        $filtre = $arguments["filtre"];

        /**
         * Construction de la requête
         */
        // FROM
        $query_ct_from ="
        " . DB_PREFIXE . "dossier_commission
        LEFT JOIN " . DB_PREFIXE . "dossier
            ON dossier_commission.dossier=dossier.dossier
        LEFT JOIN " . DB_PREFIXE . "dossier_instruction_type
            ON dossier.dossier_instruction_type=dossier_instruction_type.dossier_instruction_type
        LEFT JOIN " . DB_PREFIXE . "commission
            ON dossier_commission.commission=commission.commission
        LEFT JOIN " . DB_PREFIXE . "commission_type
            ON commission_type.commission_type=commission.commission_type
        LEFT JOIN ".DB_PREFIXE."instructeur
            ON dossier.instructeur=instructeur.instructeur
        LEFT JOIN ".DB_PREFIXE."om_utilisateur
            ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division
        %s";

        $query_ct_where_collectivite_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN " . DB_PREFIXE . "om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            AND om_collectivite.om_collectivite=" . $_SESSION['collectivite'] . "
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN " . DB_PREFIXE . "om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);

        // WHERE - COMMON
        $query_ct_where_common = "
        dossier_commission.lu IS FALSE AND
        dossier_instruction_type.sous_dossier IS NOT TRUE
        ";

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur":
                $message_filtre = " " . _("dont je suis l'instructeur");
                break;
            case "instructeur_secondaire":
                $message_filtre = " " . _("dont je suis l'instructeur secondaire");
                break;
            case "division":
                $message_filtre = " " . _("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " " . _("situés dans ma collectivité");
                } else {
                    $message_filtre = " " . _("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            _("Les retours de commission marqués comme 'non lu' qui concernent des " .
              "dossiers d'instruction%s."),
            $message_filtre
        );

        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_from" => $query_ct_from,
            "query_ct_where_common" => $query_ct_where_common,
        );

    }


    /**
     * WIDGET DASHBOARD - Dossiers incomplets ou majorés sans date de notification
     *
     * @return void
     */
    function view_widget_dossiers_evenement_incomplet_majoration($content = null) {

        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         *
         * - filtre : 
         *    = instructeur
         *    = division
         *    = aucun
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         */
        // Liste des paramètres
        $params = array("filtre", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossiers_evenement_incomplet_majoration($arguments);
        //
        $filtre = $conf["arguments"]["filtre"];

        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 10",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }

        $query = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where_common"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Vous n'avez pas de dossiers d'instruction avec un événement d'incomplétude ou de majoration de délai sans date de notification.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Vous n'avez pas de dossiers d'instruction avec un événement d'incomplétude ou de majoration de délai sans date de notification.");
                return;
            }
           
            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';

            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';

            // Données dans le tableau
            // 
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-1 firstcol">
                    %s
                </td>
                <td class="col-1">
                    %s
                </td>
                <td class="col-2 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Bouton consulter
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date de dépôt
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_depot"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Bouton consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date de dépôt du dossier
                _('date_depot'),
                // Contenu du tableau
                $ct_tbody
            );
        }

        // Affichage du footer
        printf(
            $this->template_footer,
            // href (avec les paramètres du widget)
            sprintf(
                OM_ROUTE_TAB."&obj=dossiers_evenement_incomplet_majoration&filtre=%s",
                $filtre
            ),
            // titre
            __("Voir tous les dossiers d'instruction avec un événement d'incomplétude ou de majoration de délai sans date de notification")
        );
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Retours de
     * consultation'.
     *
     * @return array
     */
    function get_config_dossiers_evenement_incomplet_majoration($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "instructeur_secondaire", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        //
        $filtre = $arguments["filtre"];

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            dossier.date_depot
        ";
        // SELECT - CHAMPAFFICHE
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("date_depot").'"'
        );
        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        INNER JOIN ".DB_PREFIXE."dossier_instruction_type
            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
        INNER JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_instruction_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN 
            ".DB_PREFIXE."instruction
            ON
                dossier.dossier = instruction.dossier
        LEFT JOIN
            ".DB_PREFIXE."evenement
            ON
                instruction.evenement = evenement.evenement
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."instructeur
            ON dossier.instructeur=instructeur.instructeur
        LEFT JOIN ".DB_PREFIXE."om_utilisateur
            ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division
        %s
        ";

        $query_ct_where_collectivite_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);

        // WHERE - COMMON
        $query_ct_where_common = "
            (
                LOWER(evenement.type) = 'incompletude' OR
                LOWER(evenement.type) = 'majoration_delai'
            ) AND
            (
                instruction.date_envoi_rar > CURRENT_TIMESTAMP  - interval '1 month' AND
                instruction.date_envoi_rar <= CURRENT_TIMESTAMP
            ) AND
            instruction.date_retour_rar IS NULL AND
            evenement.retour = 'f'
        ";

        // ORDER BY
        $query_ct_orderby = "
            dossier.date_depot desc
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur":
                $message_filtre = " "._("dont je suis l'instructeur");
                break;
            case "instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur secondaire");
                break;
            case "division":
                $message_filtre = " "._("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            __("Les dossiers d'instruction%s qui ont un événement d'incomplétude ou de majoration de délai avec une date d'envoi AR, mais sans date de notification."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where_common" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby,
        );
    }


    /**
     * WIDGET DASHBOARD - widget_infos_profil.
     */
    function view_widget_infos_profil($content = null) {

        /**
         * Template nécessaires à l'affichage du widget
         */
        //
        $template_table = '
        </br>
        <h4>Liste des accès</h4>
        <table class="tab-tab">
            <thead>
                <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                    <th class="title col-0 firstcol">
                        <span class="name">
                            %s
                        </span>
                    </th>
                    <th class="title col-1">
                        <span class="name">
                            %s
                        </span>
                    </th>
                    <th class="title col-2 lastcol">
                        <span class="name">
                            %s
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
        %s
            </tbody>
        </table>
        ';
        //
        $template_line = '
        <tr class="tab-data odd">
            <td class="col-1 firstcol">
                %s
            </td>
            <td class="col-1">
                %s
            </td>
            <td class="col-2 lastcol">
                %s
            </td>
        </tr>
        ';


        // Récupère les informations sur l'utilisateur
        $this->f->getUserInfos();

        // Si l'utilisateur est loggé $_SESSION existe
        if(isset($_SESSION['login']) AND !empty($_SESSION['login'])) {

            // On compose le bloc html d'affichage des informations de l'utilisateur
            $bloc_infos_profil = "
                %s
                <div class=\"profil-infos\">
                    <h4>Utilisateur</h4>
                    <div class=\"profil-infos-profil\">
                        <span class=\"libelle\">%s</span> : <span class=\"value\">%s</span>
                    </div>
                    <div class=\"profil-infos-nom\">
                        <span class=\"libelle\">%s</span> : <span class=\"value\">%s</span>
                    </div>
            ";

            // Si l'utilisateur connecté est un instructeur
            if ($this->f->isUserInstructeur() === true) {

                // On compose le bloc html d'affichage des informations de l'utilisateur
                $bloc_infos_profil .= "
                        <div class=\"profil-infos-division\">
                            <span class=\"libelle\">%s</span> : <span class=\"value\">%s</span>
                        </div>
                ";

                // Requête de récupération de la qualité de l'instructeur
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            instructeur_qualite.libelle
                        FROM
                            %1$sinstructeur
                            INNER JOIN %1$sinstructeur_qualite 
                                ON instructeur.instructeur_qualite=instructeur_qualite.instructeur_qualite
                        WHERE
                            instructeur.om_utilisateur = %2$s',
                        DB_PREFIXE,
                        intval($this->f->om_utilisateur["om_utilisateur"])
                    ),
                    array(
                        "origin" => __METHOD__
                    )
                );
                // S'il y a un résultat
                if ($qres['result'] !== null) {
                    $bloc_infos_profil .= sprintf(
                        '<div class="profil-infos-instructeur_qualite">
                            <span class="libelle">
                                %1$s
                            </span>
                             : 
                            <span class="value">
                                %2$s
                            </span>
                        </div>',
                        __("Qualité"),
                        $qres['result']
                    );
                }
            } else {
                // Pour éviter une NOTICE
                $this->f->om_utilisateur["code"] = '';
            }
            //
            $bloc_infos_profil  .= "</div>";

            // Ajout d'un tableau listant les groupes de l'utilisateur ainsi que ses
            // accès aux groupes
            $msg_erreur_groupe = '';
            $bloc_tableau_droits = '';
            // Si le profil et l'utilisateur n'ont pas de groupe défini
            if (isset($_SESSION['groupe']) === false) {
                $msg_erreur_groupe = '
                    <div class="message ui-widget ui-corner-all ui-state-highlight ui-state-error borderless">
                        <p>
                            <span class="ui-icon ui-icon-info"></span> 
                            <span class="text">Problème de paramétrage : vous n\'avez pas de groupe associé.</span>
                        </p>
                    </div>
                ';
            } else {
                $ct_tbody = '';
                // On construit le contenu du tableau
                foreach ($_SESSION['groupe'] as $key => $value) {
                    if ($value['confidentiel'] === true) {
                        $value['confidentiel'] = _('Oui');
                    }
                    else {
                        $value['confidentiel'] = _('Non');
                    }
                    if ($value['enregistrement_demande'] === true) {
                        $value['enregistrement_demande'] = _('Oui');
                    }
                    else {
                        $value['enregistrement_demande'] = _('Non');
                    }
                    // On construit la ligne
                    $ct_tbody .= sprintf(
                        $template_line,
                        // Colonne 1 - Libellé du groupe
                        $value["libelle"],
                        // Colonne 2 - A accès aux dossiers confidentiels
                        $value["confidentiel"],
                        // Colonne 3 - Peut créer une demande
                        $value["enregistrement_demande"]
                    );
                }
                // Affichage du tableau listant les dossiers
                $bloc_infos_profil .= sprintf(
                    $template_table,
                    // Colonne 1 - Libellé du groupe
                    _('groupe'),
                    // Colonne 2 - A accès aux dossiers confidentiels
                    _('dossiers confidentiels'),
                    // Colonne 3 - Peut créer une demande
                    _('enregistrement demande'),
                    // Contenu du tableau
                    $ct_tbody
                );
            }
            // Affichage du bloc html avec les variables associées
            printf(
                $bloc_infos_profil,
                $msg_erreur_groupe,
                _('Profil'), $this->f->om_utilisateur["libelle_profil"],
                _('Nom'), $this->f->om_utilisateur["nom"],
                _('Division'), $this->f->om_utilisateur["code"]
            );
        }
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget
     * 'Mes contradictoires' ou 'Les contradictoires'.
     *
     * @return array
     */
    function get_config_dossier_contentieux_contradictoire($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        // Utilisation du filtre instructeur dédié au contentieux si le filtre
        // paramétré est "instructeur"
        if (! empty($arguments["filtre"]) && $arguments["filtre"] === 'instructeur') {
            $arguments["filtre"] = 'instructeur_ou_instructeur_secondaire';
        }
        $filtre = $arguments["filtre"];
        
        // SELECT - CHAMPAFFICHE
        $trim_concat_terrain = '
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
        ) as "'.__("localisation").'"';
        //
        $case_contrevenant = "
        CASE WHEN demandeur_contrevenant.qualite = 'particulier' 
            THEN TRIM(CONCAT(demandeur_contrevenant.particulier_nom, ' ', demandeur_contrevenant.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_contrevenant.personne_morale_raison_sociale, ' ', demandeur_contrevenant.personne_morale_denomination)) 
        END
        ";
        //
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $trim_concat_terrain,
            $case_contrevenant.' as "'._("contrevenant").'"',
            'to_char(dossier.date_premiere_visite ,\'DD/MM/YYYY\') as "'._("date_premiere_visite").'"',
            'to_char(dossier.date_derniere_visite ,\'DD/MM/YYYY\') as "'._("date_derniere_visite").'"',
            'etat.libelle as "'._("etat").'"',
            'to_char(dossier.date_contradictoire, \'DD/MM/YYYY\') as "'._("date_contradictoire").'"',
            'to_char(dossier.date_retour_contradictoire, \'DD/MM/YYYY\') as "'._("date_retour_contradictoire").'"',
        );

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            dossier.date_contradictoire,
            dossier.date_retour_contradictoire
        ";

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        LEFT JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('contrevenant')
        ) as demandeur_contrevenant
            ON demandeur_contrevenant.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."avis_decision
            ON avis_decision.avis_decision=dossier.avis_decision
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        %s
        ";

        $query_ct_where_collectivite_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);

        // WHERE - COMMON
        $query_ct_where_common = "
            LOWER(dossier_autorisation_type.code) = LOWER('IN')
            AND NOT EXISTS
                (SELECT NULL
                FROM ".DB_PREFIXE."instruction
                INNER JOIN ".DB_PREFIXE."evenement
                    ON instruction.evenement = evenement.evenement
                WHERE instruction.dossier = dossier.dossier
                AND evenement.type = 'annul_contradictoire')
            AND (dossier.date_contradictoire >= CURRENT_DATE + interval '3 weeks'
                OR (dossier.date_contradictoire IS NOT NULL
                   AND dossier.date_retour_contradictoire IS NULL))
            AND date_ait IS NULL
        ";

        // ORDER BY
        $query_ct_orderby = "
            dossier.date_depot ASC
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur_ou_instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur");
                break;
            case "instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur secondaire");
                break;
            case "division":
                $message_filtre = " "._("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            _("Les infractions%s les plus anciennes pour lesquelles la date de contradictoire est saisie (soit elle est supérieure ou égale à la date du jour + 3 semaines, soit elle ne rentre pas dans cette condition et la date de retour du contradictoire est vide), il n'y a pas d'événements de type 'Annulation de contradictoire' et il n'y a pas d'AIT créé."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby,
        );
    }

    /**
     * WIDGET DASHBOARD - Les ou Mes dossiers contradictoires
     * @return void
     */
    function view_widget_dossier_contentieux_contradictoire($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = division
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         */
        // Liste des paramètres
        $params = array("filtre", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_contentieux_contradictoire($arguments);

        $filtre = $conf["arguments"]["filtre"];
        //

       
        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 10",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }

        $query = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Il n'y a pas d'infractions pour lesquelles la date de contradictoire est saisie (soit elle est supérieure ou égale à la date du jour + 3 semaines, soit elle ne rentre pas dans cette condition et la date de retour du contradictoire est vide), il n'y a pas d'événements de type 'Annulation de contradictoire' et il n'y a pas d'AIT créé.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Il n'y a pas d'infractions pour lesquelles la date de contradictoire est saisie (soit elle est supérieure ou égale à la date du jour + 3 semaines, soit elle ne rentre pas dans cette condition et la date de retour du contradictoire est vide), il n'y a pas d'événements de type 'Annulation de contradictoire' et il n'y a pas d'AIT créé.");
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-3 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2">
                    %s
                </td>
                <td class="col-3 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_contentieux_toutes_infractions&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';
            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date contradictoire
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_contradictoire"])
                    ),
                    // Colonne 4 - Date retour contradictoire
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_retour_contradictoire"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date contradictoire
                _('date_contradictoire'),
                // Colonne 4 - Date retour contradictoire
                _('date_retour_contradictoire'),
                // Le Contenu
                $ct_tbody
            );
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            OM_ROUTE_TAB."&obj=dossier_contentieux_contradictoire&filtre=" . $filtre,
            _("Voir +")
        );
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Mes AIT'
     * ou 'Les AIT'.
     *
     * @return array
     */
    function get_config_dossier_contentieux_ait($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        // Utilisation du filtre instructeur dédié au contentieux si le filtre
        // paramétré est "instructeur"
        if (! empty($arguments["filtre"]) && $arguments["filtre"] === 'instructeur') {
            $arguments["filtre"] = 'instructeur_ou_instructeur_secondaire';
        }
        $filtre = $arguments["filtre"];
        
        // SELECT - CHAMPAFFICHE
        $trim_concat_terrain = '
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
        ) as "'.__("localisation").'"';
        //
        $case_contrevenant = "
        CASE WHEN demandeur_contrevenant.qualite = 'particulier' 
            THEN TRIM(CONCAT(demandeur_contrevenant.particulier_nom, ' ', demandeur_contrevenant.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_contrevenant.personne_morale_raison_sociale, ' ', demandeur_contrevenant.personne_morale_denomination)) 
        END
        ";
        //
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $trim_concat_terrain,
            $case_contrevenant.' as "'._("contrevenant").'"',
            'to_char(dossier.date_premiere_visite ,\'DD/MM/YYYY\') as "'._("date_premiere_visite").'"',
            'to_char(dossier.date_derniere_visite ,\'DD/MM/YYYY\') as "'._("date_derniere_visite").'"',
            'etat.libelle as "'._("etat").'"',
            'to_char(dossier.date_ait, \'DD/MM/YYYY\') as "'._("date_ait").'"',
            'to_char(instruction.date_retour_signature, \'DD/MM/YYYY\') as "'._("date_retour_signature").'"',
        );

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            dossier.date_ait,
            instruction.date_retour_signature
        ";

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        LEFT JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('contrevenant')
        ) as demandeur_contrevenant
            ON demandeur_contrevenant.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."avis_decision
            ON avis_decision.avis_decision=dossier.avis_decision
        INNER JOIN ".DB_PREFIXE."instruction
            ON dossier.dossier = instruction.dossier
            AND date_retour_signature IS NOT NULL
        INNER JOIN ".DB_PREFIXE."evenement
           ON instruction.evenement = evenement.evenement
           AND LOWER(evenement.type) LIKE 'ait'
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        %s
        ";

        $query_ct_where_collectivite_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);

        // WHERE
        $query_ct_where_common = "
            LOWER(dossier_autorisation_type.code) = LOWER('IN')
        ";

        // ORDER BY
        $query_ct_orderby = "
            dossier.date_depot DESC
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur_ou_instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur");
                break;
            case "division":
                $message_filtre = " "._("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            _("Les infractions%s les plus récentes pour lesquelles il y a un AIT signé."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby
        );
    }


    /**
     * WIDGET DASHBOARD - Les ou Mes dossiers AIT
     * @return void
     */
    function view_widget_dossier_contentieux_ait($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = division
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         */
        // Liste des paramètres
        $params = array("filtre", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_contentieux_ait($arguments);
        $filtre = $conf["arguments"]["filtre"];

       
        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 5",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }

        $query = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Il n'y a pas d'infractions pour lesquelles il y a un AIT signé.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Il n'y a pas d'infractions pour lesquelles il y a un AIT signé.");
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-3 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2">
                    %s
                </td>
                <td class="col-3 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_contentieux_toutes_infractions&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';
            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date AIT
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_ait"])
                    ),
                    // Colonne 4 - Date retour signature
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_retour_signature"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date AIT
                _('date_ait'),
                // Colonne 4 - Date retour signature
                _('date_retour_signature'),
                // Le Contenu
                $ct_tbody
            );
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            OM_ROUTE_TAB."&obj=dossier_contentieux_ait&filtre=" . $filtre,
            _("Voir +")
        );
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Les infractions
     * non affectées'.
     *
     * @return array
     */
    function get_config_dossier_contentieux_inaffectes($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "division",
            "dossier_encours" => "true",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "dossier_encours"
                    && in_array($elem, array("true", "false"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        $filtre = $arguments["filtre"];
        $d_encours = $arguments["dossier_encours"];
        
        // SELECT - CHAMPAFFICHE
        $trim_concat_terrain = '
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
        ) as "'.__("localisation").'"';
        //
        $case_contrevenant = "
        CASE WHEN demandeur_contrevenant.qualite = 'particulier' 
            THEN TRIM(CONCAT(demandeur_contrevenant.particulier_nom, ' ', demandeur_contrevenant.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_contrevenant.personne_morale_raison_sociale, ' ', demandeur_contrevenant.personne_morale_denomination)) 
        END
        ";
        //
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $trim_concat_terrain,
            $case_contrevenant.' as "'._("contrevenant").'"',
            'to_char(dossier.date_premiere_visite ,\'DD/MM/YYYY\') as "'._("date_premiere_visite").'"',
            'to_char(dossier.date_derniere_visite ,\'DD/MM/YYYY\') as "'._("date_derniere_visite").'"',
            'etat.libelle as "'._("etat").'"',
            'to_char(dossier.date_depot, \'DD/MM/YYYY\') as "'._("Date de réception").'"',
        );

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            dossier.date_depot
        ";

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        INNER JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat%s
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('contrevenant')
        ) as demandeur_contrevenant
            ON demandeur_contrevenant.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."avis_decision
            ON avis_decision.avis_decision=dossier.avis_decision
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division
        %s
        ";

        $query_ct_where_collectivite_filter = "";
        $query_ct_where_statut_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        // Permet de filtrer les dossiers d'instruction pour n'afficher
        // seulement ceux dont l'état est considéré comme 'encours'
        if ($d_encours === 'true') {
            $query_ct_where_statut_filter = " AND etat.statut = 'encours' ";
        }

        $query_ct_from = sprintf($query_ct_from,
            $query_ct_where_statut_filter,
            $query_ct_where_collectivite_filter
        );
        
        // WHERE - COMMON
        $query_ct_where_common = "
            LOWER(dossier_autorisation_type.code) = LOWER('IN')
            AND dossier.instructeur_2 IS NULL
        ";

        // ORDER BY

        $query_ct_orderby = "
            dossier.date_depot ASC
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "division":
                $message_filtre = " "._("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }

        // Complète le message d'aide pour préciser que les dossiers
        // d'instruction sont seulement ceux considérés comme 'encours'
        if ($d_encours === 'true') {
            $message_filtre = " "._("en cours d'instruction").$message_filtre;
        }
        //
        $message_help = sprintf(
            _("Les infractions%s les plus anciennes non-affectées à un technicien."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby
        );
    }

    /**
     * WIDGET DASHBOARD - Les infractions non affectées
     * @return void
     */
    function view_widget_dossier_contentieux_inaffectes($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = division
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         * - dossier_encours (permet d'afficher seulement les DI en cours) :
         *   = true (affiche seulement les DI en cours)
         *   = false (affiche tous les DI)
         *   (default) true
         */
        // Liste des paramètres
        $params = array("filtre", "dossier_encours", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_contentieux_inaffectes($arguments);

        $filtre = $conf["arguments"]["filtre"];
        $d_encours = $conf["arguments"]["dossier_encours"];
        //

       
        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 5",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }

        $query = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Il n'y a pas d'infractions non-affectées à un technicien.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Il n'y a pas d'infractions non-affectées à un technicien.");
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_contentieux_toutes_infractions&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';
            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date de réception
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_depot"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date de réception
                _('Date de réception'),
                // Le Contenu
                $ct_tbody
            );
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            OM_ROUTE_TAB."&obj=dossier_contentieux_inaffectes&filtre=" . $filtre."&dossier_encours=".$d_encours,
            _("Voir +")
        );
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Alerte Visite'.
     *
     * @return array
     */
    function get_config_dossier_contentieux_alerte_visite($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "dossier_encours" => "true",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "dossier_encours"
                    && in_array($elem, array("true", "false"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        // Utilisation du filtre instructeur dédié au contentieux si le filtre
        // paramétré est "instructeur"
        if (! empty($arguments["filtre"]) && $arguments["filtre"] === 'instructeur') {
            $arguments["filtre"] = 'instructeur_ou_instructeur_secondaire';
        }
        $filtre = $arguments["filtre"];
        $d_encours = $arguments["dossier_encours"];

        // SELECT - CHAMPAFFICHE
        $trim_concat_terrain = '
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
        ) as "'.__("localisation").'"';
        //
        $case_contrevenant = "
        CASE WHEN demandeur_contrevenant.qualite = 'particulier' 
            THEN TRIM(CONCAT(demandeur_contrevenant.particulier_nom, ' ', demandeur_contrevenant.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_contrevenant.personne_morale_raison_sociale, ' ', demandeur_contrevenant.personne_morale_denomination)) 
        END
        ";
        //
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $trim_concat_terrain,
            $case_contrevenant.' as "'._("contrevenant").'"',
            'to_char(dossier.date_premiere_visite ,\'DD/MM/YYYY\') as "'._("date_premiere_visite").'"',
            'to_char(dossier.date_derniere_visite ,\'DD/MM/YYYY\') as "'._("date_derniere_visite").'"',
            'etat.libelle as "'._("etat").'"',
            'to_char(dossier.date_depot, \'DD/MM/YYYY\') as "'._("Date de réception").'"',
        );

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            dossier.date_depot
        ";

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        INNER JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat%s
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('contrevenant')
        ) as demandeur_contrevenant
            ON demandeur_contrevenant.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."avis_decision
            ON avis_decision.avis_decision=dossier.avis_decision
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        %s
        ";

        $query_ct_where_collectivite_filter = "";
        $query_ct_where_statut_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        //
        if ($d_encours === 'true') {
            $query_ct_where_statut_filter = " AND etat.statut = 'encours' ";
        }

        $query_ct_from = sprintf(
            $query_ct_from,
            $query_ct_where_statut_filter,
            $query_ct_where_collectivite_filter
        );

        // WHERE - COMMON
        $query_ct_where_common = "
            LOWER(dossier_autorisation_type.code) = LOWER('IN')
            AND dossier.date_depot < CURRENT_TIMESTAMP - interval '3 months'
            AND dossier.date_premiere_visite IS NULL
        ";

        // ORDER BY
        $query_ct_orderby = "
            dossier.date_depot ASC
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur_ou_instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur");
                break;
            case "instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur secondaire");
                break;
            case "division":
                $message_filtre = " "._("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        // Complète le message d'aide pour préciser que les dossiers
        // d'instruction sont seulement ceux considérés comme 'encours'
        if ($d_encours === 'true') {
            $message_filtre = " "._("en cours d'instruction").$message_filtre;
        }
        //
        $message_help = sprintf(
            _("Les infractions%s les plus anciennes pour lesquelles la date de réception est dépassée depuis plus de 3 mois et dont la date de première visite n'est pas saisie."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby
        );
    }

    /**
     * WIDGET DASHBOARD - Alerte Visite
     * @return void
     */
    function view_widget_dossier_contentieux_alerte_visite($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = division
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         * - dossier_encours (permet d'afficher seulement les DI en cours) :
         *   = true (affiche seulement les DI en cours)
         *   = false (affiche tous les DI)
         *   (default) true
         */
        // Liste des paramètres
        $params = array("filtre", "dossier_encours", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_contentieux_alerte_visite($arguments);

        //
        $filtre = $conf["arguments"]["filtre"];
        $d_encours = $conf["arguments"]["dossier_encours"];

        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 5",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }
        $query = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );


        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Il n'y a pas d'infractions pour lesquelles la date de réception est dépassée depuis plus de 3 mois et dont la date de première visite n'est pas saisie.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Il n'y a pas d'infractions pour lesquelles la date de réception est dépassée depuis plus de 3 mois et dont la date de première visite n'est pas saisie.");
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_contentieux_toutes_infractions&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';
            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date de réception
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_depot"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date de réception
                _('Date de réception'),
                // Le Contenu
                $ct_tbody
            );
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            OM_ROUTE_TAB."&obj=dossier_contentieux_alerte_visite&filtre=".$filtre."&dossier_encours=".$d_encours,
            _("Voir +")
        );
    }

    /**
     * Cette méthode permet de récupérer la configuration du widget 'Alerte Parquet'.
     *
     * @return array
     */
    function get_config_dossier_contentieux_alerte_parquet($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "dossier_encours" => "true",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "dossier_encours"
                    && in_array($elem, array("true", "false"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        // Utilisation du filtre instructeur dédié au contentieux si le filtre
        // paramétré est "instructeur"
        if (! empty($arguments["filtre"]) && $arguments["filtre"] === 'instructeur') {
            $arguments["filtre"] = 'instructeur_ou_instructeur_secondaire';
        }
        $filtre = $arguments["filtre"];
        $d_encours = $arguments["dossier_encours"];

        // SELECT - CHAMPAFFICHE
        $trim_concat_terrain = '
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
        ) as "'.__("localisation").'"';
        //
        $case_contrevenant = "
        CASE WHEN demandeur_contrevenant.qualite = 'particulier' 
            THEN TRIM(CONCAT(demandeur_contrevenant.particulier_nom, ' ', demandeur_contrevenant.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_contrevenant.personne_morale_raison_sociale, ' ', demandeur_contrevenant.personne_morale_denomination)) 
        END
        ";
        //
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $trim_concat_terrain,
            $case_contrevenant.' as "'._("contrevenant").'"',
            'to_char(dossier.date_premiere_visite ,\'DD/MM/YYYY\') as "'._("date_premiere_visite").'"',
            'to_char(dossier.date_derniere_visite ,\'DD/MM/YYYY\') as "'._("date_derniere_visite").'"',
            'etat.libelle as "'._("etat").'"',
            'to_char(dossier.date_depot, \'DD/MM/YYYY\') as "'._("Date de réception").'"',
        );

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            dossier.date_depot
        ";

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        INNER JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat%s
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('contrevenant')
        ) as demandeur_contrevenant
            ON demandeur_contrevenant.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."avis_decision
            ON avis_decision.avis_decision=dossier.avis_decision
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        %s
        ";

        $query_ct_where_collectivite_filter = "";
        $query_ct_where_statut_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        // Permet de filtrer les dossiers d'instruction pour n'afficher
        // seulement ceux dont l'état est considéré comme 'encours'
        if ($d_encours === 'true') {
            $query_ct_where_statut_filter = " AND etat.statut = 'encours' ";
        }

        $query_ct_from = sprintf(
            $query_ct_from,
            $query_ct_where_statut_filter,
            $query_ct_where_collectivite_filter
        );

        // WHERE - COMMON
        $query_ct_where_common = "
            LOWER(dossier_autorisation_type.code) = LOWER('IN')
            AND dossier.date_depot < CURRENT_TIMESTAMP - interval '9 months'
            AND dossier.date_transmission_parquet IS NULL
        ";

        // ORDER BY
        $query_ct_orderby = "
            dossier.date_depot ASC
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur_ou_instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur");
                break;
            case "division":
                $message_filtre = " "._("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        // Complète le message d'aide pour préciser que les dossiers
        // d'instruction sont seulement ceux considérés comme 'encours'
        if ($d_encours === 'true') {
            $message_filtre = " "._("en cours d'instruction").$message_filtre;
        }
        //
        $message_help = sprintf(
            _("Les infractions%s les plus anciennes pour lesquelles la date de réception est dépassée depuis plus de 9 mois et dont la date de transmission au parquet n'est pas saisie."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby
        );
    }

    /**
     * WIDGET DASHBOARD - Alerte Parquet
     * @return void
     */
    function view_widget_dossier_contentieux_alerte_parquet($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = division
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         * - dossier_encours (permet d'afficher seulement les DI en cours) :
         *   = true (affiche seulement les DI en cours)
         *   = false (affiche tous les DI)
         *   (default) true
         */
        // Liste des paramètres
        $params = array("filtre", "dossier_encours", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_contentieux_alerte_parquet($arguments);

        //
        $filtre = $conf["arguments"]["filtre"];
        $d_encours = $conf["arguments"]["dossier_encours"];

        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 5",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }
        $query = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Il n'y a pas d'infractions pour lesquelles la date de réception est dépassée depuis plus de 9 mois et dont la date de transmission au parquet n'est pas saisie.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Il n'y a pas d'infractions pour lesquelles la date de réception est dépassée depuis plus de 9 mois et dont la date de transmission au parquet n'est pas saisie.");
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_contentieux_toutes_infractions&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';
            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date de réception
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_depot"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date de réception
                _('Date de réception'),
                // Le Contenu
                $ct_tbody
            );
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            OM_ROUTE_TAB."&obj=dossier_contentieux_alerte_parquet&filtre=".$filtre."&dossier_encours=".$d_encours,
            _("Voir +")
        );
    }

    /**
     * Cette méthode permet de récupérer la configuration du widget 'Mes clôtures'.
     *
     * @return array
     */
    function get_config_dossier_contentieux_clotures($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        // Utilisation du filtre instructeur dédié au contentieux si le filtre
        // paramétré est "instructeur"
        if (! empty($arguments["filtre"]) && $arguments["filtre"] === 'instructeur') {
            $arguments["filtre"] = 'instructeur_ou_instructeur_secondaire';
        }
        $filtre = $arguments["filtre"];

        // SELECT - CHAMPAFFICHE
        $trim_concat_terrain = '
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
        ) as "'.__("localisation").'"';
        //
        $case_requerant = "
        CASE WHEN demandeur_requerant.qualite = 'particulier' 
            THEN TRIM(CONCAT(demandeur_requerant.particulier_nom, ' ', demandeur_requerant.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_requerant.personne_morale_raison_sociale, ' ', demandeur_requerant.personne_morale_denomination)) 
        END
        ";
        //
        $case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
        THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
        ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
        END";
        //
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            'dossier_autorisation_type_detaille.libelle as "'._("type de dossier").'"',
            'dossier_autorisation_contestee.dossier_libelle as "'._("autorisation").'"',
            $case_demandeur.' as "'._("petitionnaire").'"',
            $trim_concat_terrain,
            $case_requerant.' as "'._("requerant").'"',
            'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("date_depot").'"',
            'avis_decision.libelle as "'._("decision").'"',
            'etat.libelle as "'._("etat").'"',
            'to_char(dossier.date_cloture_instruction, \'DD/MM/YYYY\') as "'._("date_cloture_instruction").'"',
        );

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            dossier.date_cloture_instruction
        ";

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        LEFT JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat
        LEFT JOIN (
            SELECT * 
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
        ) as demandeur
            ON demandeur.dossier = dossier.dossier
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('requerant')
        ) as demandeur_requerant
            ON demandeur_requerant.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier as dossier_autorisation_contestee
            ON dossier.autorisation_contestee = dossier_autorisation_contestee.dossier
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."avis_decision
            ON avis_decision.avis_decision=dossier.avis_decision
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        %s
        ";

        $query_ct_where_collectivite_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);

        // WHERE - COMMON
        $query_ct_where_common = "
            LOWER(dossier_autorisation_type.code) = LOWER('RE')
            AND dossier.date_cloture_instruction >= CURRENT_TIMESTAMP
            AND dossier.date_cloture_instruction <= CURRENT_TIMESTAMP + interval '1 month'
        ";

        // ORDER BY

        $query_ct_orderby = "
        dossier.date_cloture_instruction ASC
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur_ou_instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur");
                break;
            case "division":
                $message_filtre = " "._("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            _("Les recours%s les plus récents pour lesquels une date de clôture d'instruction existe et est comprise entre le jour courant et un mois dans le futur."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby
        );
    }

    /**
     * WIDGET DASHBOARD - Les clôtures
     * @return void
     */
    function view_widget_dossier_contentieux_clotures($content = null) {

        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = division
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         */
        // Liste des paramètres
        $params = array("filtre", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_contentieux_clotures($arguments);

        $filtre = $conf["arguments"]["filtre"];
        //

       
        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 5",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }
        $query = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Il n'y a pas de recours pour lesquels une date de clôture d'instruction existe et est comprise entre le jour courant et un mois dans le futur.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Il n'y a pas de recours pour lesquels une date de clôture d'instruction existe et est comprise entre le jour courant et un mois dans le futur.");
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_contentieux_tous_recours&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';
            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date de clôture d'instruction
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_cloture_instruction"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date de clôture d'instruction
                _("date_cloture_instruction"),
                // Le Contenu
                $ct_tbody
            );
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            OM_ROUTE_TAB."&obj=dossier_contentieux_clotures&filtre=" . $filtre,
            _("Voir +")
        );
    }

    /**
     * Cette méthode permet de récupérer la configuration du widget 'Les audience'.
     *
     * @return array
     */
    function get_config_dossier_contentieux_audience($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        // Utilisation du filtre instructeur dédié au contentieux si le filtre
        // paramétré est "instructeur"
        if (! empty($arguments["filtre"]) && $arguments["filtre"] === 'instructeur') {
            $arguments["filtre"] = 'instructeur_ou_instructeur_secondaire';
        }
        $filtre = $arguments["filtre"];

        // SELECT - CHAMPAFFICHE
        $trim_concat_terrain = '
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
        ) as "'.__("localisation").'"';
        //
        $case_contrevenant = "
        CASE WHEN demandeur_contrevenant.qualite = 'particulier' 
            THEN TRIM(CONCAT(demandeur_contrevenant.particulier_nom, ' ', demandeur_contrevenant.particulier_prenom)) 
            ELSE TRIM(CONCAT(demandeur_contrevenant.personne_morale_raison_sociale, ' ', demandeur_contrevenant.personne_morale_denomination)) 
        END
        ";
        //
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $trim_concat_terrain,
            $case_contrevenant.' as "'._("contrevenant").'"',
            'to_char(dossier.date_premiere_visite ,\'DD/MM/YYYY\') as "'._("date_premiere_visite").'"',
            'to_char(dossier.date_derniere_visite ,\'DD/MM/YYYY\') as "'._("date_derniere_visite").'"',
            'etat.libelle as "'._("etat").'"',
            'to_char(donnees_techniques.ctx_date_audience, \'DD/MM/YYYY\') as "'._("ctx_date_audience").'"',
        );

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            donnees_techniques.ctx_date_audience
        ";

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        LEFT JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('contrevenant')
        ) as demandeur_contrevenant
            ON demandeur_contrevenant.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."avis_decision
            ON avis_decision.avis_decision=dossier.avis_decision
        LEFT JOIN ".DB_PREFIXE."donnees_techniques
            ON donnees_techniques.dossier_instruction = dossier.dossier
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        %s
        ";

        $query_ct_where_collectivite_filter = "";

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);
        
        // WHERE - COMMON
        $query_ct_where_common = "
            LOWER(dossier_autorisation_type.code) = LOWER('IN')
            AND donnees_techniques.ctx_date_audience IS NOT NULL
            AND donnees_techniques.ctx_date_audience >= CURRENT_TIMESTAMP
            AND donnees_techniques.ctx_date_audience <= CURRENT_TIMESTAMP + interval '1 month'
        ";
        // ORDER BY

        $query_ct_orderby = "
            donnees_techniques.ctx_date_audience ASC
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur_ou_instructeur_secondaire":
                $message_filtre = " "._("dont je suis l'instructeur");
                break;
            case "division":
                $message_filtre = " "._("situés dans ma division");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " "._("situés dans ma collectivité");
                } else {
                    $message_filtre = " "._("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            _("Les infractions%s les plus récentes pour lesquelles une date d'audience existe et est comprise entre le jour courant et un mois dans le futur."),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where_common,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby,
        );
    }

    /**
     * WIDGET DASHBOARD - Les audiences
     * @return void
     */
    function view_widget_dossier_contentieux_audience($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = division
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         */
        // Liste des paramètres
        $params = array("filtre", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_contentieux_audience($arguments);

        //
        $filtre = $conf["arguments"]["filtre"];
        //
       
        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 5",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }
        $query = sprintf(
            "SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                echo __("Il n'y a pas d'infractions pour lesquelles une date d'audience existe et est comprise entre le jour courant et un mois dans le futur.");
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                echo _("Il n'y a pas d'infractions pour lesquelles une date d'audience existe et est comprise entre le jour courant et un mois dans le futur.");
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_contentieux_toutes_infractions&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';
            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Date d'audience
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["ctx_date_audience"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Numéro de dossier
                _('dossier'),
                // Colonne 3 - Date d'audience
                _('ctx_date_audience'),
                // Le Contenu
                $ct_tbody
            );
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            OM_ROUTE_TAB."&obj=dossier_contentieux_audience&filtre=" . $filtre,
            _("Voir +")
        );
    }

    /**
     * WIDGET DASHBOARD - Derniers dossiers déposés
     *
     * @return void
     */
    function view_widget_derniers_dossiers_deposes($content = null) {

        /**
         * Ce widget est configurable via l'interface Web. Lors de la création
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         *
         * - filtre :
         *    = instructeur
         *    = division
         *    = aucun
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         *
         * - nombre_de_jours : c'est le délai en jours avant la date limite à 
         *   partir duquel on souhaite voir apparaître les dossiers dans le 
         *   widget.
         *   (default) Par défaut la valeur est 15 jours.
         *
         * - codes_datd : la liste des types de dossiers à afficher. exemple :
         *   "PCI;PCA;DPS;CUa;CUb".
         *   (default) Par défaut tous les types sont affichés. [null]
         *
         * - restreindre_msg_non_lus : dans le listing associé, la colonne "message 
         *   manuel" affiche un indicateur
         *      = true :  que si le dossier comporte au moins un message 
         *      manuel NON LU.
         *      = (default)false :si le dossier comporte au moins un message
         *      manuel. 
         *
         * - filtre_depot :
         *      = depot_electronique
         *      = guichet
         *      = (default) aucun
         *     Par défaut le filtre de dépôt est aucun,
         *     donc autorise tous les types de dépôt. 
         */
        // Liste des paramètres
        $params = array("filtre", "nombre_de_jours", "codes_datd", "filtre_depot", "restreindre_msg_non_lus");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_derniers_dossiers_deposes($arguments);
        //
        $filtre = $conf["arguments"]["filtre"];
        $nombre_de_jours = $conf["arguments"]["nombre_de_jours"];
        $codes_datd = $conf["arguments"]["codes_datd"];
        $filtre_depot = $conf["arguments"]["filtre_depot"];
        $restreindre_msg_non_lus = $conf["arguments"]["restreindre_msg_non_lus"];

        /**
         * Composition de la requête
         */
        $query = sprintf(
            "SELECT
                COUNT(DISTINCT(dossier.dossier))
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
                %s
                %s
                %s",
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where_common"],
            $conf["query_ct_where_date_filter"],
            $conf["query_ct_where_groupe"],
            $conf["query_ct_where_depot_filter"],
            $conf["query_ct_where_datd_filter"],
            '%s' // emplacement pour les conditions du filtre
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Exécution de la requête
         */
        //
        $qres = $this->f->get_one_result_from_db_query(
            $query,
            array(
                "origin" => __METHOD__
            )
        );

        // Affichage du message d'informations
        printf(
            $this->template_help,
            $conf["message_help"]
        );

        //
        if (intval($qres['result']) === 0) {
            //
            echo __("Aucun dossier déposé dernièrement.");
            return;
        }


        /**
         *
         */
        $this->display_resultat_bulle($qres['result'], __("Déposés dernièrement"), "bg-info", "");

        // Affichage du footer
        printf(
            $this->template_footer,
            // href (avec les paramètres du widget)
            sprintf(
                OM_ROUTE_TAB."&obj=derniers_dossiers_deposes&filtre=%s&nombre_de_jours=%s&codes_datd=%s&filtre_depot=%s&restreindre_msg_non_lus=%s",
                $filtre,
                $nombre_de_jours,
                (is_null($codes_datd) ? "" : implode(";",$codes_datd)),
                $filtre_depot,
                $restreindre_msg_non_lus
            ),
            // titre
            _("Voir +")
        );

    }

    /**
     * Cette méthode permet de récupérer la configuration du widget 'Dossiers
     * limites'.
     *
     * @return array
     */
    function get_config_derniers_dossiers_deposes($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "nombre_de_jours" => 15,
            "codes_datd" => null,
            "filtre" => "division",
            "filtre_depot"=> "aucun",
            "restreindre_msg_non_lus" => "false"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "nombre_de_jours" 
                    && intval($elem) > 0) {
                    // Ce doit être un entier
                    $arguments[$key] = intval($elem);
                    continue;
                } elseif ($key === "codes_datd"
                    && $elem != "") {
                    // Ce doit être un tableau
                    $arguments[$key] = explode(";", $elem);
                    continue;
                } elseif ($key === "filtre"
                    && in_array($elem, array("instructeur", "instructeur_secondaire", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "filtre_depot"
                    && in_array($elem, array("depot_electronique", "guichet", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "restreindre_msg_non_lus"
                    && in_array($elem, array("true", "false"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
                //
            $arguments[$key] = $value;
        }
        //
        $nombre_de_jours = $arguments["nombre_de_jours"];
        $codes_datd = $arguments["codes_datd"];
        $filtre = $arguments["filtre"];
        $filtre_depot = $arguments["filtre_depot"];
        $restreindre_msg_non_lus = $arguments["restreindre_msg_non_lus"];

        // SELECT - CHAMPAFFICHE - pour le listing
        // On distingue par dossier_libelle car la jointure à la table message 
        // provoque des doublons lorsqu'un dossier a plusieurs messages
        // On distingue par date de dépot car les arguments du "DISTINCT ON" 
        // doivent être ceux de "ORDER BY"
        $case_demandeur = "CASE WHEN demandeur.qualite = 'particulier' 
        THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
        ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
        END";
        $query_ct_select_champrecherche = array(
            'dossier.dossier as "'._("dossier").'"',
            $select__dossier_libelle__column_as,
        );
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $case_demandeur.' AS "'._("petitionnaire").'"',
            'to_char(dossier.date_depot, \'DD/MM/YYYY\') AS "'._("date_depot").'"',
            "CASE WHEN dossier.a_qualifier IS TRUE
                THEN 'Oui'
                ELSE 'Non'
            END".' as "'._("a_qualifier").'"',
            'donnees_techniques.co_tot_log_nb as "'._("nombre total de logements").'"',
            'CASE WHEN su2_avt_shon1 IS NOT NULL
                OR su2_avt_shon2 IS NOT NULL
                OR su2_avt_shon3 IS NOT NULL
                OR su2_avt_shon4 IS NOT NULL
                OR su2_avt_shon5 IS NOT NULL
                OR su2_avt_shon6 IS NOT NULL
                OR su2_avt_shon7 IS NOT NULL
                OR su2_avt_shon8 IS NOT NULL
                OR su2_avt_shon9 IS NOT NULL
                OR su2_avt_shon10 IS NOT NULL
                OR su2_avt_shon11 IS NOT NULL
                OR su2_avt_shon12 IS NOT NULL
                OR su2_avt_shon13 IS NOT NULL
                OR su2_avt_shon14 IS NOT NULL
                OR su2_avt_shon15 IS NOT NULL
                OR su2_avt_shon16 IS NOT NULL
                OR su2_avt_shon17 IS NOT NULL
                OR su2_avt_shon18 IS NOT NULL
                OR su2_avt_shon19 IS NOT NULL
                OR su2_avt_shon20 IS NOT NULL
                OR su2_avt_shon21 IS NOT NULL
                OR su2_avt_shon22 IS NOT NULL
                OR su2_cstr_shon1 IS NOT NULL
                OR su2_cstr_shon2 IS NOT NULL
                OR su2_cstr_shon3 IS NOT NULL
                OR su2_cstr_shon4 IS NOT NULL
                OR su2_cstr_shon5 IS NOT NULL
                OR su2_cstr_shon6 IS NOT NULL
                OR su2_cstr_shon7 IS NOT NULL
                OR su2_cstr_shon8 IS NOT NULL
                OR su2_cstr_shon9 IS NOT NULL
                OR su2_cstr_shon10 IS NOT NULL
                OR su2_cstr_shon11 IS NOT NULL
                OR su2_cstr_shon12 IS NOT NULL
                OR su2_cstr_shon13 IS NOT NULL
                OR su2_cstr_shon14 IS NOT NULL
                OR su2_cstr_shon15 IS NOT NULL
                OR su2_cstr_shon16 IS NOT NULL
                OR su2_cstr_shon17 IS NOT NULL
                OR su2_cstr_shon18 IS NOT NULL
                OR su2_cstr_shon19 IS NOT NULL
                OR su2_cstr_shon20 IS NOT NULL
                OR su2_cstr_shon21 IS NOT NULL
                OR su2_cstr_shon22 IS NOT NULL
                OR su2_chge_shon1 IS NOT NULL
                OR su2_chge_shon2 IS NOT NULL
                OR su2_chge_shon3 IS NOT NULL
                OR su2_chge_shon4 IS NOT NULL
                OR su2_chge_shon5 IS NOT NULL
                OR su2_chge_shon6 IS NOT NULL
                OR su2_chge_shon7 IS NOT NULL
                OR su2_chge_shon8 IS NOT NULL
                OR su2_chge_shon9 IS NOT NULL
                OR su2_chge_shon10 IS NOT NULL
                OR su2_chge_shon11 IS NOT NULL
                OR su2_chge_shon12 IS NOT NULL
                OR su2_chge_shon13 IS NOT NULL
                OR su2_chge_shon14 IS NOT NULL
                OR su2_chge_shon15 IS NOT NULL
                OR su2_chge_shon16 IS NOT NULL
                OR su2_chge_shon17 IS NOT NULL
                OR su2_chge_shon18 IS NOT NULL
                OR su2_chge_shon19 IS NOT NULL
                OR su2_chge_shon20 IS NOT NULL
                OR su2_chge_shon21 IS NOT NULL
                OR su2_chge_shon22 IS NOT NULL
                OR su2_demo_shon1 IS NOT NULL
                OR su2_demo_shon2 IS NOT NULL
                OR su2_demo_shon3 IS NOT NULL
                OR su2_demo_shon4 IS NOT NULL
                OR su2_demo_shon5 IS NOT NULL
                OR su2_demo_shon6 IS NOT NULL
                OR su2_demo_shon7 IS NOT NULL
                OR su2_demo_shon8 IS NOT NULL
                OR su2_demo_shon9 IS NOT NULL
                OR su2_demo_shon10 IS NOT NULL
                OR su2_demo_shon11 IS NOT NULL
                OR su2_demo_shon12 IS NOT NULL
                OR su2_demo_shon13 IS NOT NULL
                OR su2_demo_shon14 IS NOT NULL
                OR su2_demo_shon15 IS NOT NULL
                OR su2_demo_shon16 IS NOT NULL
                OR su2_demo_shon17 IS NOT NULL
                OR su2_demo_shon18 IS NOT NULL
                OR su2_demo_shon19 IS NOT NULL
                OR su2_demo_shon20 IS NOT NULL
                OR su2_demo_shon21 IS NOT NULL
                OR su2_demo_shon22 IS NOT NULL
                OR su2_sup_shon1 IS NOT NULL
                OR su2_sup_shon2 IS NOT NULL
                OR su2_sup_shon3 IS NOT NULL
                OR su2_sup_shon4 IS NOT NULL
                OR su2_sup_shon5 IS NOT NULL
                OR su2_sup_shon6 IS NOT NULL
                OR su2_sup_shon7 IS NOT NULL
                OR su2_sup_shon8 IS NOT NULL
                OR su2_sup_shon9 IS NOT NULL
                OR su2_sup_shon10 IS NOT NULL
                OR su2_sup_shon11 IS NOT NULL
                OR su2_sup_shon12 IS NOT NULL
                OR su2_sup_shon13 IS NOT NULL
                OR su2_sup_shon14 IS NOT NULL
                OR su2_sup_shon15 IS NOT NULL
                OR su2_sup_shon16 IS NOT NULL
                OR su2_sup_shon17 IS NOT NULL
                OR su2_sup_shon18 IS NOT NULL
                OR su2_sup_shon19 IS NOT NULL
                OR su2_sup_shon20 IS NOT NULL
                OR su2_sup_shon21 IS NOT NULL
                OR su2_sup_shon22 IS NOT NULL
            THEN
                donnees_techniques.su2_cstr_shon_tot
            ELSE 
                donnees_techniques.su_cstr_shon_tot
            END as "'._("surface de plancher construite totale").'"',
            "CASE WHEN su2_avt_shon1 IS NOT NULL
                OR su2_avt_shon2 IS NOT NULL
                OR su2_avt_shon3 IS NOT NULL
                OR su2_avt_shon4 IS NOT NULL
                OR su2_avt_shon5 IS NOT NULL
                OR su2_avt_shon6 IS NOT NULL
                OR su2_avt_shon7 IS NOT NULL
                OR su2_avt_shon8 IS NOT NULL
                OR su2_avt_shon9 IS NOT NULL
                OR su2_avt_shon10 IS NOT NULL
                OR su2_avt_shon11 IS NOT NULL
                OR su2_avt_shon12 IS NOT NULL
                OR su2_avt_shon13 IS NOT NULL
                OR su2_avt_shon14 IS NOT NULL
                OR su2_avt_shon15 IS NOT NULL
                OR su2_avt_shon16 IS NOT NULL
                OR su2_avt_shon17 IS NOT NULL
                OR su2_avt_shon18 IS NOT NULL
                OR su2_avt_shon19 IS NOT NULL
                OR su2_avt_shon20 IS NOT NULL
                OR su2_avt_shon21 IS NOT NULL
                OR su2_avt_shon22 IS NOT NULL
                OR su2_cstr_shon1 IS NOT NULL
                OR su2_cstr_shon2 IS NOT NULL
                OR su2_cstr_shon3 IS NOT NULL
                OR su2_cstr_shon4 IS NOT NULL
                OR su2_cstr_shon5 IS NOT NULL
                OR su2_cstr_shon6 IS NOT NULL
                OR su2_cstr_shon7 IS NOT NULL
                OR su2_cstr_shon8 IS NOT NULL
                OR su2_cstr_shon9 IS NOT NULL
                OR su2_cstr_shon10 IS NOT NULL
                OR su2_cstr_shon11 IS NOT NULL
                OR su2_cstr_shon12 IS NOT NULL
                OR su2_cstr_shon13 IS NOT NULL
                OR su2_cstr_shon14 IS NOT NULL
                OR su2_cstr_shon15 IS NOT NULL
                OR su2_cstr_shon16 IS NOT NULL
                OR su2_cstr_shon17 IS NOT NULL
                OR su2_cstr_shon18 IS NOT NULL
                OR su2_cstr_shon19 IS NOT NULL
                OR su2_cstr_shon20 IS NOT NULL
                OR su2_cstr_shon21 IS NOT NULL
                OR su2_cstr_shon22 IS NOT NULL
                OR su2_chge_shon1 IS NOT NULL
                OR su2_chge_shon2 IS NOT NULL
                OR su2_chge_shon3 IS NOT NULL
                OR su2_chge_shon4 IS NOT NULL
                OR su2_chge_shon5 IS NOT NULL
                OR su2_chge_shon6 IS NOT NULL
                OR su2_chge_shon7 IS NOT NULL
                OR su2_chge_shon8 IS NOT NULL
                OR su2_chge_shon9 IS NOT NULL
                OR su2_chge_shon10 IS NOT NULL
                OR su2_chge_shon11 IS NOT NULL
                OR su2_chge_shon12 IS NOT NULL
                OR su2_chge_shon13 IS NOT NULL
                OR su2_chge_shon14 IS NOT NULL
                OR su2_chge_shon15 IS NOT NULL
                OR su2_chge_shon16 IS NOT NULL
                OR su2_chge_shon17 IS NOT NULL
                OR su2_chge_shon18 IS NOT NULL
                OR su2_chge_shon19 IS NOT NULL
                OR su2_chge_shon20 IS NOT NULL
                OR su2_chge_shon21 IS NOT NULL
                OR su2_chge_shon22 IS NOT NULL
                OR su2_demo_shon1 IS NOT NULL
                OR su2_demo_shon2 IS NOT NULL
                OR su2_demo_shon3 IS NOT NULL
                OR su2_demo_shon4 IS NOT NULL
                OR su2_demo_shon5 IS NOT NULL
                OR su2_demo_shon6 IS NOT NULL
                OR su2_demo_shon7 IS NOT NULL
                OR su2_demo_shon8 IS NOT NULL
                OR su2_demo_shon9 IS NOT NULL
                OR su2_demo_shon10 IS NOT NULL
                OR su2_demo_shon11 IS NOT NULL
                OR su2_demo_shon12 IS NOT NULL
                OR su2_demo_shon13 IS NOT NULL
                OR su2_demo_shon14 IS NOT NULL
                OR su2_demo_shon15 IS NOT NULL
                OR su2_demo_shon16 IS NOT NULL
                OR su2_demo_shon17 IS NOT NULL
                OR su2_demo_shon18 IS NOT NULL
                OR su2_demo_shon19 IS NOT NULL
                OR su2_demo_shon20 IS NOT NULL
                OR su2_demo_shon21 IS NOT NULL
                OR su2_demo_shon22 IS NOT NULL
                OR su2_sup_shon1 IS NOT NULL
                OR su2_sup_shon2 IS NOT NULL
                OR su2_sup_shon3 IS NOT NULL
                OR su2_sup_shon4 IS NOT NULL
                OR su2_sup_shon5 IS NOT NULL
                OR su2_sup_shon6 IS NOT NULL
                OR su2_sup_shon7 IS NOT NULL
                OR su2_sup_shon8 IS NOT NULL
                OR su2_sup_shon9 IS NOT NULL
                OR su2_sup_shon10 IS NOT NULL
                OR su2_sup_shon11 IS NOT NULL
                OR su2_sup_shon12 IS NOT NULL
                OR su2_sup_shon13 IS NOT NULL
                OR su2_sup_shon14 IS NOT NULL
                OR su2_sup_shon15 IS NOT NULL
                OR su2_sup_shon16 IS NOT NULL
                OR su2_sup_shon17 IS NOT NULL
                OR su2_sup_shon18 IS NOT NULL
                OR su2_sup_shon19 IS NOT NULL
                OR su2_sup_shon20 IS NOT NULL
                OR su2_sup_shon21 IS NOT NULL
                OR su2_sup_shon22 IS NOT NULL
                THEN
                    REGEXP_REPLACE(CONCAT(
                        CASE WHEN donnees_techniques.su2_cstr_shon1 IS NULL
                            THEN ''
                            ELSE CONCAT ('Exploitation agricole - ', donnees_techniques.su2_cstr_shon1, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon2 IS NULL
                            THEN ''
                            ELSE CONCAT ('Exploitation forestière - ', donnees_techniques.su2_cstr_shon2, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon3 IS NULL
                            THEN ''
                            ELSE CONCAT ('Logement - ', donnees_techniques.su2_cstr_shon3, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon4 IS NULL
                            THEN ''
                            ELSE CONCAT ('Hébergement - ', donnees_techniques.su2_cstr_shon4, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon5 IS NULL
                            THEN ''
                            ELSE CONCAT ('Artisanat et commerce de détail - ', donnees_techniques.su2_cstr_shon5, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon6 IS NULL
                            THEN ''
                            ELSE CONCAT ('Restauration - ', donnees_techniques.su2_cstr_shon6, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon7 IS NULL
                            THEN ''
                            ELSE CONCAT ('Commerce de gros - ', donnees_techniques.su2_cstr_shon7, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon8 IS NULL
                            THEN ''
                            ELSE CONCAT ('Activités de services où s''effectue l''accueil d''une clientèle - ', donnees_techniques.su2_cstr_shon8, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon9 IS NULL
                            THEN ''
                            ELSE CONCAT ('Hébergement hôtelier et touristique - ', donnees_techniques.su2_cstr_shon9, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon10 IS NULL
                            THEN ''
                            ELSE CONCAT ('Cinéma - ', donnees_techniques.su2_cstr_shon10, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon21 IS NULL
                            THEN ''
                            ELSE CONCAT ('Hôtels - ', donnees_techniques.su2_cstr_shon21, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon22 IS NULL
                            THEN ''
                            ELSE CONCAT ('Autres hébergements touristiques - ', donnees_techniques.su2_cstr_shon22, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon11 IS NULL
                            THEN ''
                            ELSE CONCAT ('Locaux et bureaux accueillant du public des administrations publiques et assimilés - ', donnees_techniques.su2_cstr_shon11, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon12 IS NULL
                            THEN ''
                            ELSE CONCAT ('Locaux techniques et industriels des administrations publiques et assimilés - ', donnees_techniques.su2_cstr_shon12, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon13 IS NULL
                            THEN ''
                            ELSE CONCAT ('Établissements d''enseignement, de santé et d''action sociale - ', donnees_techniques.su2_cstr_shon13, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon14 IS NULL
                            THEN ''
                            ELSE CONCAT ('Salles d''art et de spectacles - ', donnees_techniques.su2_cstr_shon14, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon15 IS NULL
                            THEN ''
                            ELSE CONCAT ('Équipements sportifs - ', donnees_techniques.su2_cstr_shon15, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon16 IS NULL
                            THEN ''
                            ELSE CONCAT ('Autres équipements recevant du public - ', donnees_techniques.su2_cstr_shon16, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon17 IS NULL
                            THEN ''
                            ELSE CONCAT ('Industrie - ', donnees_techniques.su2_cstr_shon17, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon18 IS NULL
                            THEN ''
                            ELSE CONCAT ('Entrepôt - ', donnees_techniques.su2_cstr_shon18, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon19 IS NULL
                            THEN ''
                            ELSE CONCAT ('Bureau - ', donnees_techniques.su2_cstr_shon19, ' m² / ')
                        END,
                        CASE WHEN donnees_techniques.su2_cstr_shon20 IS NULL
                            THEN ''
                            ELSE CONCAT ('Centre de congrès et d''exposition - ', donnees_techniques.su2_cstr_shon20, ' m²')
                        END
                    ), ' / $', '')
                ELSE
                    REGEXP_REPLACE(CONCAT(
                        CASE
                            WHEN donnees_techniques.su_cstr_shon1 IS NULL
                            THEN ''
                            ELSE CONCAT('Habitation - ', donnees_techniques.su_cstr_shon1, ' m² / ')
                        END,
                        CASE
                            WHEN donnees_techniques.su_cstr_shon2 IS NULL
                            THEN ''
                            ELSE CONCAT('Hébergement hôtelier - ', donnees_techniques.su_cstr_shon2, ' m² / ')
                        END,
                        CASE
                            WHEN donnees_techniques.su_cstr_shon3 IS NULL
                            THEN ''
                            ELSE CONCAT('Bureaux - ', donnees_techniques.su_cstr_shon3, ' m² / ')
                        END,
                        CASE
                            WHEN donnees_techniques.su_cstr_shon4 IS NULL
                            THEN ''
                            ELSE CONCAT('Commerce - ', donnees_techniques.su_cstr_shon4, ' m² / ')
                        END,
                        CASE
                            WHEN donnees_techniques.su_cstr_shon5 IS NULL
                            THEN ''
                            ELSE CONCAT('Artisanat - ', donnees_techniques.su_cstr_shon5, ' m² / ')
                        END,
                        CASE
                            WHEN donnees_techniques.su_cstr_shon6 IS NULL
                            THEN ''
                            ELSE CONCAT('Industrie - ', donnees_techniques.su_cstr_shon6, ' m² / ')
                        END,
                        CASE
                            WHEN donnees_techniques.su_cstr_shon7 IS NULL
                            THEN ''
                            ELSE CONCAT('Exploitation agricole ou forestière - ', donnees_techniques.su_cstr_shon7, ' m² / ')
                        END,
                        CASE
                            WHEN donnees_techniques.su_cstr_shon8 IS NULL
                            THEN ''
                            ELSE CONCAT('Entrepôt - ', donnees_techniques.su_cstr_shon8, ' m² / ')
                        END, 
                        CASE
                            WHEN donnees_techniques.su_cstr_shon9 IS NULL
                            THEN ''
                            ELSE CONCAT('Service public ou d''intérêt collectif - ', donnees_techniques.su_cstr_shon9, ' m²')
                        END
                    ), ' / $', '')
            END".' as "'._("destination").'"'
        );

        //SELECT DEPOT ELECTRONIQUE (LISTING)
        // Si le filtre_depot précise le type de dépot il est inutile de faire apparaitre cette colonne 
        if ($filtre_depot == "aucun") {
            //
            $query_ct_select_depot_electronique="CASE WHEN dossier.depot_electronique IS TRUE
                THEN 'Oui'
                ELSE 'Non'
            END".' as "'._("depot_electronique").'"';
            // On l'ajoute aux champs affichés
             $query_ct_select_champaffiche[] = $query_ct_select_depot_electronique;
        }

        // SELECT COLONNE MESSAGE (LISTING)
        $query_ct_select_message ="";
        $title_icon_message = __("Le dossier d'instruction possède au moins un message ajouté manuellement%s.")." ".__("Cliquez sur l'icône pour accéder à la liste des messages du dossier.");
        switch($restreindre_msg_non_lus) {
            case "false" : 
                $query_ct_select_message =
                "CASE
                    WHEN dossier.dossier IN (
                        SELECT dossier.dossier 
                        FROM ".DB_PREFIXE."dossier 
                        LEFT JOIN ".DB_PREFIXE."dossier_message ON dossier.dossier=dossier_message.dossier 
                        WHERE dossier_message.lu IS NOT NULL
                        AND dossier_message.type ='"._("message manuel")."'
                        )
                    THEN %s
                    ELSE %s
                END as message";
                $title_icon_message = sprintf($title_icon_message, "");
                break;
            case "true" : 
                $query_ct_select_message =
                "CASE
                    WHEN dossier.dossier IN (
                        SELECT dossier.dossier 
                        FROM ".DB_PREFIXE."dossier 
                        LEFT JOIN ".DB_PREFIXE."dossier_message ON dossier.dossier=dossier_message.dossier 
                        WHERE dossier_message.lu IS NOT NULL
                        AND dossier_message.type ='"._("message manuel")."'
                        AND dossier_message.lu IS FALSE
                        )
                    THEN %s
                    ELSE %s
                END as message";
                $title_icon_message = sprintf($title_icon_message, " ".__('qui soit non lu'));
                break;
        }
        //Selon le paramétrage, une icone de notification message s'affiche à l'utilisateur. Cliquer dessus redirige vers l'onglet des messages. 
        $icone_msg = "CONCAT ('<a title=\"', '".pg_escape_string($title_icon_message)."','\" href=','".OM_ROUTE_FORM."','&obj=dossier_instruction&action=3&idx=',dossier.dossier,'&advs_id=&premier=0&tricol=&valide=&retour=tab#ui-tabs-6>".'<span class=".om-icon om-icon-16 om-icon-fix message-manuel-16"/></a>'."')";
        // Sans message (ou message non lu selon paramétrage) rien ne s'affiche dans la colonne
        $icone_no_msg = "''";
        $query_ct_select_message = sprintf($query_ct_select_message, $icone_msg, $icone_no_msg);
        //Les requêtes de la colonne message sont ajoutées aux requêtes des champs affichés pour le listing
        $query_ct_select_champaffiche[] = $query_ct_select_message;

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        LEFT JOIN (
            SELECT *
            FROM ".DB_PREFIXE."lien_dossier_demandeur
            INNER JOIN ".DB_PREFIXE."demandeur
                ON demandeur.demandeur = lien_dossier_demandeur.demandeur
            WHERE lien_dossier_demandeur.petitionnaire_principal IS TRUE
            AND LOWER(demandeur.type_demandeur) = LOWER('petitionnaire')
        ) AS demandeur
            ON demandeur.dossier = dossier.dossier
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation 
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."donnees_techniques
            ON dossier.dossier = donnees_techniques.dossier_instruction
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."instructeur
            ON dossier.instructeur=instructeur.instructeur
        LEFT JOIN ".DB_PREFIXE."om_utilisateur
            ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division
        %s
        ";

        $query_ct_where_collectivite_filter = "";
        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);
        // WHERE - COMMON
        $query_ct_where_common = "
        groupe.code != 'CTX'
        ";
        // WHERE - nombre_de_jours
        // Filtre sur l'intervalle pour la date de dépôt
        $query_ct_where_date_filter = "
        AND dossier.date_depot >= CURRENT_TIMESTAMP - ".$nombre_de_jours." * interval '1 day'
        ";
        // WHERE - DATD
        // Filtre sur le type détaillé des dossiers
        $query_ct_where_datd_filter = "";
        if (!is_null($codes_datd)
            && is_array($codes_datd)
            && count($codes_datd) != 0) {
            //
            $sql_codes = "";
            //
            foreach ($codes_datd as $code) {
                $sql_codes .= " LOWER(dossier_autorisation_type_detaille.code) = '".$this->f->db->escapesimple(strtolower($code))."' OR ";
            }
            $sql_codes = substr($sql_codes, 0, strlen($sql_codes) - 4);
            //
            $query_ct_where_datd_filter = " AND ( ".$sql_codes." ) ";
        }
        //WHERE - filtre_depot
        // Filtre sur le type de dépôt des dossiers 
        $query_ct_where_depot_filter = "";
        if ($filtre_depot == "depot_electronique") {
            //
            $query_ct_where_depot_filter = "
            AND dossier.depot_electronique IS TRUE
            ";
        }
        if ($filtre_depot == "guichet") {
            
            $query_ct_where_depot_filter = "
            AND dossier.depot_electronique IS FALSE
            ";
        }

        // ORDER BY
        $query_ct_orderby = "
            dossier.date_depot DESC,
            dossier.dossier
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        //
        $message_filtre_depot = '';
        //
        switch ($filtre_depot) {
            case "depot_electronique" : 
                $message_filtre_depot = " "._("déposés électroniquement uniquement"); 
                break;
            case "guichet" : 
                $message_filtre_depot = " "._("déposés uniquement via le guichet"); 
                break;
            case "aucun" :
                $message_filtre_depot = " "._("déposés"); 
                break;
        }
        //
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur" : 
                $message_filtre = " "._("(filtrés par instructeur)"); 
                break;
            case "instructeur_secondaire" : 
                $message_filtre = " "._("(filtrés par instructeur secondaire)"); 
                break;
            case "division" : 
                $message_filtre = " "._("(filtrés par division)"); 
                break;
        }
        //
        $message_restreindre_msg_non_lus = "";
        //
        if ($restreindre_msg_non_lus === "true") {
            $message_restreindre_msg_non_lus =" "._("et dont l'indicateur des messages manuels est restreint aux messages non lus");
        }
        //
        $message_help = sprintf(
            _("Les  dossiers%s%s dans les %s derniers jours%s%s."),
            (is_null($codes_datd) ? "": " (".implode(", ",$codes_datd).")"),
            $message_filtre_depot,
            $nombre_de_jours,
            $message_filtre,
            $message_restreindre_msg_non_lus
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_select_champrecherche" => $query_ct_select_champrecherche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where_common" => $query_ct_where_common,
            "query_ct_where_date_filter" => $query_ct_where_date_filter,
            "query_ct_where_depot_filter" => $query_ct_where_depot_filter,
            "query_ct_where_datd_filter" => $query_ct_where_datd_filter,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby,
        );
    }


    /**
     * Cette méthode permet de récupérer la configuration du widget 'Dossier consulter'.
     *
     * @return array
     */
    function get_config_dossier_consulter($idx) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        /**
         * Construction de la requête
         */
        //
        $case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
        THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
        ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
        END";
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            $case_demandeur as nom_petitionnaire,
            dossier.date_depot,
            dossier_autorisation_type.code
        ";

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        LEFT JOIN ".DB_PREFIXE."lien_dossier_demandeur
            ON dossier.dossier = lien_dossier_demandeur.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
        LEFT JOIN ".DB_PREFIXE."demandeur
            ON lien_dossier_demandeur.demandeur = demandeur.demandeur
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation 
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."dossier_instruction_type
            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
        ";

        $query_ct_where ="
            dossier_instruction_type.sous_dossier IS NOT TRUE AND
            dossier.dossier ='".$idx."'
        ";

        /**
         * Return
         */
        //
        return array(
            "query_ct_select" => $query_ct_select,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where,
        );
    }

    /**
     * WIDGET DASHBOARD - widget_dossier_consulter
     * @return void
     */
    function view_widget_dossier_consulter($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier l'options suivantes :
         *
         * - nb_dossiers : le nombre de dossiers récemment consultés visibile dans le 
         *   widget.
         *   (default) Par défaut la valeur est 5 derniers dossiers.
        **/

        // Liste des paramètres
        $params = array("nb_dossiers");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);

        //On retire 1 à la valeur de nb_dossiers car $i boucle à partir de 0
        if(isset($arguments['nb_dossiers']) == false) {
            $nb_dossiers = 4;
        } else {
            $nb_dossiers = $arguments['nb_dossiers']-1;
        }


        $dossier_brut = null;
        if (isset($_SESSION['dossiers_consulte']) === false) {
            $dossiers_consulte = array();
        } else {
            $dossier_brut = $_SESSION['dossiers_consulte'];
            $dossiers_consulte = array_reverse($dossier_brut);
        }

        /**
         * Template nécessaires à l'affichage du widget
         */
        //
        $template_table = '
        <table class="tab-tab widget_dossier_consulter">
            <thead>
                <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                    <th class="title col-0 firstcol">
                        <span class="name">
                            %s
                        </span>
                    </th>
                    <th class="title col-1">
                        <span class="name">
                            %s
                        </span>
                    </th>
                    <th class="title col-2">
                        <span class="name">
                            %s
                        </span>
                    </th>
                </tr>
            </thead>
            <tbody>
            %s
            </tbody>
        </table>
        ';
        //
        $template_line = '
        <tr class="tab-data odd">
            <td class="col-1 firstcol">
                %s
            </td>
            <td class="col-1">
                %s
            </td>
            <td class="col-2">
                %s
            </td>
        </tr>
        ';

        //
        $template_line_hidden = '
        <tr class="tab-data odd" hidden>
            <td class="col-1 firstcol">
                %s
            </td>
            <td class="col-1">
                %s
            </td>
            <td class="col-2">
                %s
            </td>
        </tr>
        ';
        // Récupererle type du dossier pour bien rediriger et son id.
        $template_href = OM_ROUTE_FORM.'&obj=%s&action=3&idx=%s';

        $template_link = '
        <a class="lienTable" href="%s">
            %s
        </a>
        ';
        //
        $template_footer_consulter = '
        <div class="widget-footer">
            <a class="simple-btn" onClick="%s">
                %s
            </a>
        </div>
        ';

        $ct_tbody = '';

        $i = 0;
        // On construit le contenu du tableau
        foreach ($dossiers_consulte as $key => $value) {

            // Récupération en bdd des données necessaire par idx
            $conf = $this->get_config_dossier_consulter($value);

            // Composition de la requête
            $query = sprintf("
                SELECT
                    %s
                FROM
                    %s
                WHERE
                    %s",
                $conf["query_ct_select"],
                $conf["query_ct_from"],
                $conf["query_ct_where"]
                );

            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );

            $row = array_shift($qres['result']);

            // La requête est faite pour récupérer les infos du dossier uniquement
            // si ce n'est pas un sous-dossier. Si c'est un sous-dossier la requête ne
            // renverra rien, dans ce cas on peut passer à l'itération suivante.
            if (empty($row)) {
                continue;
            }

            // Determination de la route à utiliser.
            switch ($row['code']) {
                case 'IN':
                    $route="dossier_contentieux_toutes_infractions";
                    break;
                case 'RE':
                    $route="dossier_contentieux_tous_recours";
                    break;
                default: $route="dossier_instruction";
            }

            // On construit l'attribut href du lien
            $ct_href = sprintf(
                $template_href,
                $route,
                // idx
                $row['dossier']
            );

            if ($i > $nb_dossiers){
                $good_template_line = $template_line_hidden;
            } else {
                $good_template_line = $template_line;
            }
            // Construction d'une ligne
            $ct_tbody .= sprintf(
                $good_template_line,
                // Colonne 1 - Numéro de dossier
                sprintf(
                    $template_link,
                    $ct_href,
                    $row['dossier_libelle']
                ),
                // Colonne 2 - Nom du pétitionnaire
                sprintf(
                    $template_link,
                    $ct_href,
                    $row["nom_petitionnaire"]
                ),
                // Colonne 3 - Date depot
                sprintf(
                    $template_link,
                    $ct_href,
                    $this->f->formatDate($row["date_depot"])
                )
            );

            $i++;
        }

        // Les sous-dossiers sont comptés comme des dossiers consultés mais ne sont pas
        // affichés. Si un dossier est un sous-dossier le nombre de dossier affiché
        // ($i) ne sera pas incrementé. Dans les cas, où seuls des sous-dossiers ont été
        // consultés ou si aucun dossier n'a été consulté, le nombre de dossier affiché
        // sera de 0.
        if ($i === 0) {
            // Affichage du message d'information
            echo __("Vous n'avez pas consulté de dossier pour le moment.");
            // Exit
            return;
        }

        // Affichage du tableau listant les dossiers
        printf(
            $template_table,
            // Colonne 1 - Numéro de dossier
            __('dossier'),
            // Colonne 2 - petitionnaire
            __('demandeur'),
            // Colonne 3 - date depot
            __('date_depot'),
            // Contenu du tableau
            $ct_tbody
        );

        // On affiche le footer seulement si l'utilisateur à consulté plus de
        // dossier que le nombre de dossier affiché par défaut (paramétrage)
        if ($i > $nb_dossiers) {
            // Affichage du footer
            printf(
                $template_footer_consulter,
                "get_all_dossier_consulte($(this).parent().parent().parent().parent().attr('id'))",
                __("Afficher +")
            );
        }
    }

    /**
     * WIDGET DASHBOARD - Dossiers à qualifier (limite de la notification du délai)
     * @return void
     */
    function view_widget_dossiers_pre_instruction($content = null) {
        /**
         * Ce widget est configurable via l'interface Web. Lors de la création 
         * du widget dans le paramétrage il est possible de spécifier la ou les
         * options suivantes :
         * - filtre : 
         *    = instructeur
         *    = aucun   
         *   (default) Par défaut les dossiers sont filtrés sur l'instructeur.
         */
        // Liste des paramètres
        $params = array("filtre", "codes_datd", "affichage");
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossiers_pre_instruction($arguments);
        // Récupération du filtre
        $filtre = $conf["arguments"]["filtre"];
        //Récupération du code datd
        $codes_datd = $conf["arguments"]["codes_datd"];
        // Définit l'objet cible
        $obj = 'dossier_instruction';

        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le type d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s
            LIMIT 5",
            $conf["query_ct_orderby"]
        );
        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }
        $query = sprintf("
            SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
                %s
                %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            $conf["query_ct_where_datd_filter"],
            $conf["query_ct_where_groupe"],
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Template nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Exécution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                // Affichage du message d'informations
                echo __("Vous n'avez aucun dossier d'instruction à qualifier dont la date limite de notification du délai au pétitionnaire arrive bientôt à échéance.");
                // Exit
                return;
            }
    
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                // Affichage du message d'informations
                echo __("Vous n'avez aucun dossier d'instruction à qualifier dont la date limite de notification du délai au pétitionnaire arrive bientôt à échéance.");
                // Exit
                return;
            }
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-3 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr id="dossier_dossiers_pre_instruction_%s" class="tab-data odd">
                <td class="col-0 firstcol">
                    %s
                </td>
                <td class="col-1 ">
                    %s
                </td>
                <td class="col-2">
                    %s
                </td>
                <td class="col-3 lastcol">
                    %s
                </td>
            </tr>
            ';

            // Bouton consulter
            $template_btn_consulter = '
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="'._('Consulter').'">'
                ._('Consulter')
            .'</span>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=%s&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            $compteur = 0;
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // obj
                    $obj,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    //Numero des id html
                    $compteur,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $template_btn_consulter
                    ),
                    // Colonne 2 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 3 - Demandeur
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["nom_petitionnaire"]
                    ),
                    // Colonne 4 - Date de Notification de délai
                    sprintf(
                        $template_link,
                        $ct_href,
                        $this->f->formatDate($row["date_notification_delai"])
                    )
                );
                $compteur++;
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Consulter
                '',
                // Colonne 2 - Libellé du dossier
                __('dossier'),
                // Colonne 3 - Demandeur
                __('nom_petitionnaire'),
                // Colonne 4 - Date de notification de delai
                __("date de notification limite"),
                // Le Contenu
                $ct_tbody
            );
        }
        /**
         * Affichage du footer
         */
        //
        $template_link_footer = OM_ROUTE_TAB.'&obj=%s';
        //
        $link_footer = sprintf(
            $template_link_footer,
            "dossiers_pre_instruction"
        );
        //
        printf(
            $this->template_footer,
            // href (avec les paramètres du widget)
            sprintf(
                "%s&filtre=%s&codes_datd=%s",
                $link_footer,
                $filtre,
                (is_null($codes_datd) ? "" : implode(";",$codes_datd))
            ),
            // titre
            __("Voir +")
        );
    }

    /**
     * Cette méthode permet de récupérer la configuration du widget
     * 'Dossiers à qualifier (limite de la notification du délai)'.
     *
     * @return array
     */
    function get_config_dossiers_pre_instruction($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "codes_datd" => null,
            "affichage" => "liste"
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "instructeur_secondaire", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "codes_datd"
                    && $elem != "") {
                    // Ce doit être un tableau
                    $arguments[$key] = explode(";", $elem);
                    continue;
                } elseif ($key === "affichage"
                    && in_array($elem, array('liste', 'nombre'))) {
                        // La valeur doit être dans cette liste
                        $arguments[$key] = $elem;
                        continue;
                }
            }
            //
            $arguments[$key] = $value;
        }

        $filtre = $arguments["filtre"]; 
        $codes_datd = $arguments["codes_datd"];
        /**
         * Construction de la requête
         */
        //
        $case_demandeur = "CASE WHEN demandeur.qualite='particulier' 
        THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
        ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
        END";
        // SELECT
        $query_ct_select = "
            dossier.dossier,
            $select__dossier_libelle__column as dossier_libelle,
            $case_demandeur as nom_petitionnaire,
            dossier.date_notification_delai
        ";

        // SELECT - CHAMPAFFICHE
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $case_demandeur.' as "'._("nom_petitionnaire").'"',
            'to_char(dossier.date_notification_delai ,\'DD/MM/YYYY\') as "'._("date de notification limite").'"',
        );

        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        LEFT JOIN ".DB_PREFIXE."lien_dossier_demandeur
            ON dossier.dossier = lien_dossier_demandeur.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
        LEFT JOIN ".DB_PREFIXE."demandeur
            ON lien_dossier_demandeur.demandeur = demandeur.demandeur
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."instructeur
            ON dossier.instructeur=instructeur.instructeur
        LEFT JOIN ".DB_PREFIXE."om_utilisateur
            ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division
        %s
        ";

        $query_ct_where_collectivite_filter = "";
        // Filtre sur les dossiers qui concernent l'utilisateur
        /*
        $query_ct_where_instructeur_filter = "";
        $query_ct_where_division_filter = "";
        if ($filtre == "instructeur") {
            //
            $query_ct_where_instructeur_filter = " JOIN ".DB_PREFIXE."instructeur
                ON dossier.instructeur=instructeur.instructeur
                    OR dossier.instructeur_2=instructeur.instructeur
            JOIN ".DB_PREFIXE."om_utilisateur
                ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur 
                AND om_utilisateur.login='".$_SESSION['login']."' 
            ";
        }  else {
            $query_ct_where_instructeur_filter = " LEFT JOIN ".DB_PREFIXE."instructeur
                ON dossier.instructeur=instructeur.instructeur
            LEFT JOIN ".DB_PREFIXE."om_utilisateur
                ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur ";
        }
        // Filtre sur les dossier de la division
        if ($filtre == "division") {
            //
            $query_ct_where_division_filter = " JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division
            AND division.division = ".$_SESSION['division']."
            ";
        } else {
            $query_ct_where_division_filter = " LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division";
        }*/

        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);

        $query_ct_where ="
            dossier.a_qualifier IS TRUE
            AND dossier.date_notification_delai >= DATE(NOW())
            AND etat.statut = 'encours'
        ";

        $query_ct_where_datd_filter = "";
        if (!is_null($codes_datd)
            && is_array($codes_datd)
            && count($codes_datd) != 0) {
            //
            $sql_codes = "";
            //
            foreach ($codes_datd as $code) {
                $sql_codes .= " LOWER(dossier_autorisation_type_detaille.code) = '".$this->f->db->escapesimple(strtolower($code))."' OR ";
            }
            $sql_codes = substr($sql_codes, 0, strlen($sql_codes) - 4);
            //
            $query_ct_where_datd_filter = " AND ( ".$sql_codes." ) ";
        }

        $query_ct_orderby ="
            dossier.date_notification_delai ASC NULLS LAST, dossier.dossier ASC NULLS LAST
        ";

        $query_ct_where_groupe = "";
        // Gestion des groupes et confidentialité
        include('../sql/pgsql/filter_group_widgets.inc.php');

        /**
         * Message d'aide
         */
        // Filtre
        $message_filtre = "";
        //
        switch ($filtre) {
            case "instructeur":
                $message_filtre = " ".__("dont je suis l'instructeur");
                break;
            case "instructeur_secondaire":
                $message_filtre = " ".__("dont je suis l'instructeur secondaire");
                break;
            case "aucun":
                if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
                    $message_filtre = " ".__("situés dans ma collectivité");
                } else {
                    $message_filtre = " ".__("situés dans toutes les collectivités");
                }
                break;
        }
        //
        $message_help = sprintf(
            __("Les dossiers d'instruction%s%s, qui sont à qualifier, non clôturés et sur lesquels la date limite de notification du délai au pétitionnaire arrive bientôt à échéance."),
            (is_null($codes_datd) ? "": " (".implode(", ",$codes_datd).")"),
            $message_filtre
        );

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_where_datd_filter" => $query_ct_where_datd_filter,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where,
            "query_ct_where_groupe" => $query_ct_where_groupe,
            "query_ct_orderby" => $query_ct_orderby
        );
    }

    protected function display_resultat_bulle($resultat, $legende, $classe, $autre = "") {
        // Panel
        $template_panel = '
        <div class="panel panel-box">
            <div class="list-justified-container">
                <ul class="list-justified text-center">
                    %s
                </ul>
            </div>
        </div>';
        $panel = "";
        // Bulle
        $template_elem = '
        <li>
            <span class="size-h3 box-icon rounded %s">%s</span>
            <p class="text-muted">%s %s</p>
        </li>
        ';
        // Remplissage de la bulle
        $panel_elem = sprintf(
            $template_elem,
            $classe,
            intval($resultat),
            _($legende),
            $autre
        );
        // Remplissage du panel
        $panel .= sprintf(
            $template_panel,
            $panel_elem
        );
        // Affichage du panel
        echo $panel;

    }

    /**
     * Cette méthode permet de récupérer la configuration du widget 'Dossiers
     * limites'.
     *
     * @return array
     */
    function get_config_dossier_non_transmis_platau($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "filtre" => "instructeur",
            "affichage" => "liste",
            "date_depot_debut" => null,
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            if (isset($arguments[$key])) {
                $elem = trim($arguments[$key]);
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "instructeur_secondaire", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "affichage"
                    && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                } elseif ($key === "date_depot_debut"
                    && $elem !== null
                    && $elem !== ''
                    && $this->f->check_date($elem) === true) {
                    //
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }

        if ($arguments['affichage'] == 'nombre') {
            $query_ct_select = "COUNT(*)";
            $query_ct_orderby = '';
            $query_limit = '';
        } else {
            $query_ct_select = sprintf(
                "dossier.dossier,
                $select__dossier_libelle__column as dossier_libelle,
                dossier.date_depot,
                CASE
                    WHEN demandeur.qualite='particulier' 
                    THEN TRIM(CONCAT(demandeur.particulier_nom, ' ', demandeur.particulier_prenom)) 
                    ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, ' ', demandeur.personne_morale_denomination)) 
                END AS demandeur
            ");

            $query_ct_orderby = sprintf("ORDER BY dossier.dossier");
            $query_limit = "LIMIT 5";
        }

        $query_ct_from = sprintf(
            '%1$sdossier
            INNER JOIN %1$slien_dossier_demandeur
                ON dossier.dossier=lien_dossier_demandeur.dossier
                AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
            INNER JOIN %1$sdemandeur
                ON lien_dossier_demandeur.demandeur=demandeur.demandeur
            INNER JOIN %1$sdossier_autorisation
                ON dossier.dossier_autorisation=dossier_autorisation.dossier_autorisation
            INNER JOIN %1$sdossier_autorisation_type_detaille
                ON dossier_autorisation.dossier_autorisation_type_detaille=dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            LEFT JOIN (%1$sdemande
                JOIN %1$sdemande_type
                    ON demande.demande_type = demande_type.demande_type
            )
                ON demande.dossier_instruction = dossier.dossier
                    AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
            LEFT JOIN %1$sinstructeur
                ON dossier.instructeur=instructeur.instructeur
            LEFT JOIN %1$som_utilisateur
                ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
            LEFT JOIN %1$sdivision
                ON dossier.division=division.division',
            DB_PREFIXE
        );

        $query_ct_where = sprintf(
            " dossier_autorisation_type_detaille.dossier_platau = TRUE AND
            (etat_transmission_platau='non_transmissible' OR 
            etat_transmission_platau='transmis_mais_non_transmissible') "
        );

        //
        $date_depot_debut = $arguments["date_depot_debut"];
        if ($date_depot_debut !== null
            && $date_depot_debut !== '') {
            //
            // $date_depot = $this->f->is_option_date_depot_mairie_enabled() === true ? 'dossier.date_depot_mairie' : 'dossier.date_depot';
            $date_depot = 'dossier.date_depot';
            $query_ct_where .= sprintf(
                " AND %s >= '%s' ",
                $date_depot,
                $date_depot_debut
            );
        }

        // Champ à afficher dans le listing
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'._("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            'to_char(dossier.date_depot ,\'DD/MM/YYYY\') as "'._("date_depot").'"',
            'CASE
                WHEN demandeur.qualite=\'particulier\'
                THEN TRIM(CONCAT(demandeur.particulier_nom, \' \', demandeur.particulier_prenom))
                ELSE TRIM(CONCAT(demandeur.personne_morale_raison_sociale, \' \', demandeur.personne_morale_denomination))
            END AS "'._("demandeur").'"'
        );

        $message_help = "Dossier non transmis à Plat'Au car ayant des élements manquants.";

        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_select" => $query_ct_select,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where,
            "query_ct_orderby" => $query_ct_orderby,
            "query_ct_limit" => $query_limit,
        );
    }

    /**
     * Méthode servant à afficher le contenu du widget servant
     * à afficher la liste ou le nombre de dossier non transmis à plat'Au
     * 
     * @param array content
     */
    function view_widget_dossier_non_transmis_platau($content = null) {
        // Liste des paramètres
        $params = array("affichage", "filtre", "date_depot_debut", );
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_dossier_non_transmis_platau($arguments);
        $query = sprintf("
            SELECT
                %s
            FROM
                %s
                %s
            WHERE
                %s
                %s
            %s
            %s",
            $conf["query_ct_select"],
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            $conf["query_ct_where"],
            '%s', // emplacement pour les conditions du filtre
            $conf["query_ct_orderby"],
            $conf["query_ct_limit"]
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
        //
        $template_line = '
        <tr class="tab-data odd">
            <td class="col-1 firstcol">
                %s
            </td>
            <td class="col-1">
                %s
            </td>
            <td class="col-2">
                %s
            </td>
        </tr>
        ';
        //
        $template_href = OM_ROUTE_FORM.'&obj=dossier_instruction&amp;action=3&amp;idx=%s';
        //
        $template_link = '
        <a class="lienTable" href="%s">
            %s
        </a>
        ';
        
        // Affichage du widget avec une bulle
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Execution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );

            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                // Affichage du message d'informations
                echo __("Aucun dossier non transmis pour le moment.");
                // Exit
                return;
            }
            $this->display_resultat_bulle($qres['result'], "Non transmis", "bg-info", "");
            // Affichage du footer
            printf(
                $this->template_footer,
                sprintf(
                    OM_ROUTE_TAB."&obj=dossier_non_transmis&filtre=%s&date_depot_debut=%s",
                    $conf["arguments"]["filtre"],
                    $conf["arguments"]["date_depot_debut"]
                ),

                // titre
                _("Voir +")
            );
        } else {
            // Affichage du widget avec un listing de 5 éléments
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );

            if ($qres['row_count'] === 0) {
                echo _("Aucun dossier non transmis pour le moment.");
            } else {

                // Affichage du message d'informations
                printf(
                    $this->template_help,
                    $conf["message_help"]
                );

                $contenu_tableau="";
                foreach($qres['result'] as $row) {
                    $href_dossier=sprintf(
                        $template_href,
                        $row['dossier']
                    
                    );

                    $contenu_case_dossier=sprintf($template_link,
                        $href_dossier,
                        $row['dossier_libelle']
                    );
        
                    $contenu_case_nom=sprintf($template_link,
                        $href_dossier,
                        $row['demandeur']
                    );
                    $contenu_case_date=sprintf($template_link,
                        $href_dossier,
                        $row['date_depot']
                    );     
                    $contenu_tableau.=sprintf(
                        $template_line,
                        $contenu_case_dossier,
                        $contenu_case_nom,
                        $contenu_case_date            
                    );                    
                }
                                
                $contenu_widget=sprintf(
                    $template_table,
                    "dossier",
                    "demandeur",
                    "date de dépôt",
                    $contenu_tableau
                );
        
                echo $contenu_widget;
                // Affichage du footer
                printf(
                    $this->template_footer,
                    sprintf(
                        OM_ROUTE_TAB."&obj=dossier_non_transmis&filtre=%s&date_depot_debut=%s",
                        $conf["arguments"]["filtre"],
                        $conf["arguments"]["date_depot_debut"]
                    ),
                    // titre
                    _("Voir +")
                );
            }
        }
    }

    /**
     * Cette méthode permet de récupérer la configuration du widget "Suivi
     * tâche Plat'AU".
     *
     * @return array
     */
    function get_config_suivi_tache($arguments) {
        include "../sql/pgsql/app_om_tab_common_select.inc.php";
        // Initialisation du tableau des paramètres avec ses valeur par défaut
        $arguments_default = array(
            "type_tache" => null,
            "etat_tache" => null,
            "filtre" => "instructeur",
            "affichage" => "liste",
            "ordre_tri" => null,
            "categorie_tache" => null,
            "flux_tache" => null,
            "message_help" => null,
            "nb_max_resultat" => 10,
        );
        // Vérification des arguments
        foreach ($arguments_default as $key => $value) {
            //
            if (isset($arguments[$key])) {
                //
                $elem = trim($arguments[$key]);
                //
                if ($key === "type_tache"
                    && $elem != "") {
                    // Ce doit être un tableau
                    $arguments[$key] = explode(";", $elem);
                    continue;
                }
                if ($key === "filtre"
                    && in_array($elem, array("instructeur", "instructeur_secondaire", "division", "aucun"))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "etat_tache"
                    && $elem != "") {
                    // Ce doit être un tableau
                    $arguments[$key] = explode(";", $elem);
                    continue;
                }
                if ($key === "categorie_tache"
                    && in_array($elem, array(PORTAL, PLATAU))) {
                    // Ce doit être un tableau
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "flux_tache"
                    && in_array($elem, array("input", "output"))) {
                    // Ce doit être un tableau
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "message_help"
                    && $elem != "") {
                    // Ce doit être un tableau
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "ordre_tri"
                    && in_array($elem, array("croissant", "décroissant"))) {
                    // Ce doit être un tableau
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "nb_max_resultat"
                    && is_numeric(str_replace('-', '', $elem)) === true) {
                    //
                    $arguments[$key] = $elem;
                    continue;
                }
                if ($key === "affichage"
                    && in_array($elem, array('liste', 'nombre'))) {
                    // La valeur doit être dans cette liste
                    $arguments[$key] = $elem;
                    continue;
                }
            }
            //
            $arguments[$key] = $value;
        }
        //
        $type_task = $arguments["type_tache"];
        $etat_task = $arguments["etat_tache"];
        $filtre = $arguments["filtre"];
        $affichage = $arguments["affichage"];
        $message_help = $arguments["message_help"];

        include ("../sql/pgsql/task.inc.php");

        /**
         * Construction de la requête
         */
        // SELECT
        $query_ct_select = "
        dossier.dossier,
        $select__dossier_libelle__column as dossier_libelle,
        $template_case_traduction_type as type,
        $template_case_traduction_etat as state
        ";
        // SELECT - CHAMPAFFICHE
        $query_ct_select_champaffiche = array(
            'dossier.dossier as "'.__("dossier").'"',
            'dossier.geom as "geom_picto"',
            'demande.source_depot as "demat_picto"',
            $select__dossier_libelle__column_as,
            $template_case_traduction_type.' as "'._("type").'"',
            $template_case_traduction_etat.' as "'._("state").'"',
        );
        // FROM
        $query_ct_from = "
        ".DB_PREFIXE."dossier
        LEFT JOIN ".DB_PREFIXE."etat
            ON dossier.etat = etat.etat
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation
            ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
            ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
        LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
            ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
        LEFT JOIN ".DB_PREFIXE."task
            ON task.dossier = dossier.dossier
            OR task.dossier = dossier_autorisation.dossier_autorisation
        LEFT JOIN (".DB_PREFIXE."demande
            JOIN ".DB_PREFIXE."demande_type
                ON demande.demande_type = demande_type.demande_type
        )
            ON demande.dossier_instruction = dossier.dossier
                AND demande_type.dossier_instruction_type = dossier.dossier_instruction_type
        LEFT JOIN ".DB_PREFIXE."instructeur
            ON dossier.instructeur=instructeur.instructeur
        LEFT JOIN ".DB_PREFIXE."om_utilisateur
            ON instructeur.om_utilisateur=om_utilisateur.om_utilisateur
        LEFT JOIN ".DB_PREFIXE."division
            ON dossier.division=division.division
        %s
        ";

        $query_ct_limit = sprintf(
            "LIMIT %s", 
            $arguments['nb_max_resultat']
        );

        $query_ct_where_collectivite_filter = "";
        // Dans tous les cas si l'utilisateur fait partie d'une collectivité
        // de niveau 1 (mono), on restreint le listing sur les dossiers de sa
        // collectivité
        if ($this->f->isCollectiviteMono($_SESSION['collectivite']) === true) {
            $query_ct_where_collectivite_filter = " JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite 
            AND om_collectivite.om_collectivite=".$_SESSION['collectivite']." 
            ";
        } else {
            $query_ct_where_collectivite_filter = " LEFT JOIN ".DB_PREFIXE."om_collectivite
            ON dossier.om_collectivite=om_collectivite.om_collectivite
            ";
        }

        $query_ct_from = sprintf($query_ct_from, $query_ct_where_collectivite_filter);


        // WHERE - TASK ETAT
        // Filtre sur l'état de la tâche
        $query_ct_where_etat_task_filter = "";
        if (!is_null($etat_task)
            && is_array($etat_task)
            && count($etat_task) != 0) {
            //
            $sql_etat_task = "";
            //
            foreach ($etat_task as $etat) {
                $sql_etat_task .= " LOWER(task.state) = '".$this->f->db->escapesimple(strtolower($etat))."' OR ";
            }
            $sql_etat_task = substr($sql_etat_task, 0, strlen($sql_etat_task) - 4);
            //
            $query_ct_where_etat_task_filter = " ( ".$sql_etat_task." ) ";
        }

        // WHERE - TASK TYPE
        // Filtre sur le type de tâche
        $query_ct_where_type_task_filter = "";
        if (!is_null($type_task)
            && is_array($type_task)
            && count($type_task) != 0) {
            //
            $sql_type_task = "";
            //
            foreach ($type_task as $type) {
                $sql_type_task .= " LOWER(task.type) = '".$this->f->db->escapesimple(strtolower($type))."' OR ";
            }
            $sql_type_task = substr($sql_type_task, 0, strlen($sql_type_task) - 4);
            //
            $query_ct_where_type_task_filter = " ( ".$sql_type_task." ) ";
        }

        // WHERE - TASK CATEGORY
        // Filtre sur la catégorie de la tache (portal ou platau), 
        // si pas spécifié alors pas de filtrage
        $query_ct_where_category_task_filter = "";
        if (isset($arguments["categorie_tache"])
            && is_null($arguments["categorie_tache"]) === false) {
            
            $query_ct_where_category_task_filter = sprintf(
                    "task.category = '%s' ",
                    $arguments["categorie_tache"]        
                );
        }

        // WHERE - TASK STREAM
        // Filtre sur le flux des tâches (input ou output)
        $query_ct_where_stream_task_filter = "";
        if (isset($arguments["flux_tache"])
            && is_null($arguments["flux_tache"]) === false) {
            
            $query_ct_where_category_task_filter = sprintf(
                    "task.stream = '%s' ",
                    $arguments["flux_tache"]        
                );
        }

        $ordre_tri ="";
        if ($arguments['ordre_tri'] == "décroissant") {
            $ordre_tri = "DESC";            
        }
        if ($arguments['ordre_tri'] == "croissant") {
            $ordre_tri = "ASC";            
        }

        // ORDER BY
        $query_ct_orderby = "dossier.date_depot ".$ordre_tri;

        $tab_criteres = array(
            'etat_tache' => $query_ct_where_etat_task_filter,
            'type_tache' => $query_ct_where_type_task_filter,
            'categorie_tache' => $query_ct_where_category_task_filter,
            'flux_tache' => $query_ct_where_stream_task_filter,
        );

        $query_ct_where = "";
        $sql_ct_where = "";
        foreach ($tab_criteres as $condition) {
            if ($condition !== '') {
                $sql_ct_where .= $condition.' AND ';
            }
        }
        $query_ct_where = substr($sql_ct_where, 0, strlen($sql_ct_where) - 5);

        if (isset($arguments['etat_tache']) && $arguments['etat_tache'] != null && is_array($arguments['etat_tache'])) {
            $arguments['etat_tache'] = implode(';', $arguments['etat_tache']);
        }
        if (isset($arguments['type_tache']) && $arguments['type_tache'] != null && is_array($arguments['type_tache'])) {
            $arguments['type_tache'] = implode(';', $arguments['type_tache']);
        }
        $widget_recherche_id= str_replace(array('.',','), '', microtime(true));
        $_SESSION['widget_recherche_id'][$widget_recherche_id] = serialize($arguments);

        /**
         * Return
         */
        //
        return array(
            "arguments" => $arguments,
            "message_help" => $message_help,
            "query_ct_select" => $query_ct_select,
            "query_ct_select_champaffiche" => $query_ct_select_champaffiche,
            "query_ct_from" => $query_ct_from,
            "query_ct_where" => $query_ct_where,
            "query_ct_orderby" => $query_ct_orderby,
            "query_ct_limit" => $query_ct_limit,
            "widget_recherche_id" => $widget_recherche_id
        );
    }

    /**
     * WIDGET DASHBOARD - Dossiers limites
     *
     * @return void
     */
    function view_widget_suivi_tache($content = null) {

        // Liste des paramètres
        $params = array(
            "type_tache",
            "etat_tache",
            "categorie_tache",
            "flux_tache",
            "filtre",
            "affichage",
            "message_help",
            "nb_max_resultat",
            "ordre_tri",
        );
        // Formatage des arguments reçus en paramètres
        $arguments = $this->get_arguments($content, $params);
        // Récupération de la configuration du widget
        $conf = $this->get_config_suivi_tache($arguments);

        /**
         * Composition de la requête
         */
        // Gestion de la requête selon le tye d'affichage
        $query_ct_orderby = sprintf(
            "ORDER BY
            %s",
            $conf["query_ct_orderby"]
        );

        // Gestion de la requête selon le tye d'affichage
        $query_ct_limit = $conf["query_ct_limit"];

        $query_ct_select = $conf["query_ct_select"];
        if ($conf["arguments"]["affichage"] === "nombre") {
            $query_ct_orderby = "";
            $query_ct_select = "COUNT(*)";
        }
        $query = sprintf("
            SELECT
                %s
            FROM
                %s
                %s
            %s
                %s
            %s
            %s",
            $query_ct_select,
            $conf["query_ct_from"],
            '%s', // emplacement pour les jointure du filtre
            ! empty($conf["query_ct_where"]) ?
                'WHERE '.$conf["query_ct_where"] :
                "",
            '%s', // emplacement pour les conditions du filtre
            $query_ct_orderby,
            $query_ct_limit
        );
        // Récupération des éléments à ajouter à la requête pour y intégrer le filtre
        $sqlFilter = $this->get_query_filter(
            $query,
            $conf['arguments']['filtre']
        );
        $query = sprintf(
            $query,
            $sqlFilter["FROM"],
            $sqlFilter["WHERE"]
        );

        /**
         * Templates nécessaires à l'affichage du widget
         */
        if ($conf["arguments"]["affichage"] === "nombre") {
            // Execution de la requête
            $qres = $this->f->get_one_result_from_db_query(
                $query,
                array(
                    "origin" => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );

            // Si il n'y a aucun dossier à afficher
            if (intval($qres['result']) == 0) {
                // Affichage du message d'informations
                echo __("Aucun dossier répondant aux critères.");
                // Exit
                return;
            }
            $this->display_resultat_bulle($qres['result'], "Non lu", "bg-info", "");
        } else {
            // Exécution de la requête
            $qres = $this->f->get_all_results_from_db_query(
                $query,
                array(
                    'origin' => __METHOD__
                )
            );
    
            // Affichage du message d'informations
            printf(
                $this->template_help,
                $conf["message_help"]
            );
    
            /**
             * Si il n'y a aucun dossier à afficher, alors on affiche un message 
             * clair à l'utilisateur et on sort de la vue.
             */
            // Si il n'y a aucun dossier à afficher
            if ($qres['row_count'] === 0) {
                // Affichage du message d'informations
                echo _("Aucun dossier répondant aux critères.");
                // Exit
                return;
            }
    
            //
            $template_table = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-1">
                            <span class="name">
                                %s
                            </span>
                        </th>
                        <th class="title col-2 lastcol">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody>
            %s
                </tbody>
            </table>
            ';
            //
            $template_line = '
            <tr class="tab-data odd">
                <td class="col-1 firstcol">
                    %s
                </td>
                <td class="col-2">
                    %s
                </td>
                <td class="col-3 lastcol">
                    %s
                </td>
            </tr>
            ';
            //
            $template_href = OM_ROUTE_FORM.'&obj=dossier_instruction&retour_widget=suivi_tache&widget_recherche_id='.$conf['widget_recherche_id'].'&amp;action=3&amp;idx=%s';
            //
            $template_link = '
            <a class="lienTable" href="%s">
                %s
            </a>
            ';

            /**
             * Si il y a des dossiers à afficher, alors on affiche le widget.
             */
            // On construit le contenu du tableau
            $ct_tbody = '';
            foreach ($qres['result'] as $row) {
                // On construit l'attribut href du lien
                $ct_href = sprintf(
                    $template_href,
                    // idx
                    $row["dossier"]
                );
                // On construit la ligne
                $ct_tbody .= sprintf(
                    $template_line,
                    // Colonne 1 - Numéro de dossier
                    sprintf(
                        $template_link,
                        $ct_href,
                        $row["dossier_libelle"]
                    ),
                    // Colonne 2 - Type de tâche
                    sprintf(
                        $template_link,
                        $ct_href,
                        __($row["type"])
                    ),
                    // Colonne 3 - Etat
                    sprintf(
                        $template_link,
                        $ct_href,
                        __($row["state"])
                    )
                );
            }
            // Affichage du tableau listant les dossiers
            printf(
                $template_table,
                // Colonne 1 - Numéro de dossier
                __('dossier'),
                // Colonne 2 - Nom du pétitionnaire
                __('type'),
                // Colonne 3 - Date limite
                __('état'),
                // Contenu du tableau
                $ct_tbody
            );
        }
        // Affichage du footer
        printf(
            $this->template_footer,
            // href (avec les paramètres du widget)
            sprintf(
                OM_ROUTE_TAB."&obj=suivi_tache&widget_recherche_id=%s",
                $conf['widget_recherche_id']
            ),
            // titre
            _("Voir +")
        );
    }

    /**
     * Récupère une requête sql et un filtre et renvoie sous la forme
     * d'un tableau les jointures et les conditions nécessaire pour
     * mettre en place le filtre.
     * Si il n'y a pas de filtre, que la méthode de récupération du filtre
     * n'est pas configuré ou qu'aucune requête n'est passée en paramètre
     * le tableau sera renvoyé mais ses entrées seront vide.
     * 
     * @param string query
     * @param string filter
     * @return string requête sql avec les filtres
     */
    public function get_query_filter(string $query, string $filter = '') {
        $sqlFilter = array(
            'FROM' => '',
            'WHERE' => ''
        );
        // Vérifie si le paramétrage est correct. Renvoie la requête sans modification
        // si ce n'est pas le cas
        if (! empty($query) &&
            ! empty($filter) &&
            in_array($filter, $this->existing_filters)) {
            // Fait appel à la méthode permettant de récupérer le sql du filtre
            $methodName = 'add_filter_'.$filter.'_to_query';
            if (method_exists($this, $methodName)) {
                $sqlFilter = $this->$methodName($query);
            }
        }
        // Renvoie les jointures et les conditions nécessaire à l'intégration
        // du filtre
        return $sqlFilter;
    }

    protected function add_filter_instructeur_to_query(string $query) {
        $sqlFilter = array(
            'FROM' => '',
            'WHERE' => ''
        );
        // Vérifie si le lien entre la table instructeur et l'instructeur
        // du dossier existe. Si ce n'est pas le cas on ajoute une jointure.
        if (preg_match("/".DB_PREFIXE."instructeur(?!_)/i", $query) === 0) {
            $sqlFilter['FROM'] .= sprintf(
                    '
                    LEFT JOIN %1$sinstructeur
                        ON dossier.instructeur = instructeur.instructeur
                    LEFT JOIN %1$som_utilisateur
                        ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
                    ',
                    DB_PREFIXE
            );
        }

        // Ajout du filtre dans le where.
        $sqlFilter['WHERE'] .= sprintf(
            ' %1$s om_utilisateur.login = \'%2$s\' ',
            preg_match("/\bWHERE\b/i", $query) === 0 ? 'WHERE' : 'AND',
            $_SESSION['login']
        );
        // Renvoie la requête
        return $sqlFilter;
    }

    protected function add_filter_instructeur_ou_instructeur_secondaire_to_query(string $query) {
        $sqlFilter = array(
            'FROM' => '',
            'WHERE' => ''
        );
        // Vérifie si le lien entre la table instructeur et l'instructeur
        // du dossier existe. Si ce n'est pas le cas on ajoute une jointure.
        if (preg_match("/".DB_PREFIXE."instructeur(?!_)/i", $query) === 0) {
            $sqlFilter['FROM'] .= sprintf(
                    '
                    LEFT JOIN %1$sinstructeur
                        ON dossier.instructeur = instructeur.instructeur
                    LEFT JOIN %1$som_utilisateur
                        ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
                    ',
                    DB_PREFIXE
            );
        }
        // Vérifie si le lien entre la table instructeur et l'instructeur secondaire
        // du dossier existe. Si ce n'est pas le cas on ajoute une jointure.
        if (preg_match("/dossier.instructeur_2(?!_)/i", $query) === 0) {
            $sqlFilter['FROM'] .= sprintf(
                    '
                    LEFT JOIN %1$sinstructeur as instructeur_secondaire
                        ON dossier.instructeur_2 = instructeur_secondaire.instructeur
                    LEFT JOIN %1$som_utilisateur as utilisateur_2
                        ON instructeur_secondaire.om_utilisateur = utilisateur_2.om_utilisateur
                    ',
                    DB_PREFIXE
            );
        }

        // Ajout du filtre dans le where.
        $sqlFilter['WHERE'] .= sprintf(
            ' %1$s (om_utilisateur.login = \'%2$s\'
                OR utilisateur_2.login = \'%2$s\') ',
            preg_match("/\bWHERE\b/i", $query) === 0 ? 'WHERE' : 'AND',
            $_SESSION['login']
        );
        // Renvoie la requête
        return $sqlFilter;
    }

    protected function add_filter_instructeur_secondaire_to_query(string $query) {
        $sqlFilter = array(
            'FROM' => '',
            'WHERE' => ''
        );
        // Vérifie si le lien entre la table instructeur et l'instructeur secondaire
        // du dossier existe. Si ce n'est pas le cas on ajoute une jointure.
        if (preg_match("/dossier.instructeur_2(?!_)/i", $query) === 0) {
            $sqlFilter['FROM'] = sprintf(
                    '
                    LEFT JOIN %1$sinstructeur as instructeur_secondaire
                        ON dossier.instructeur_2 = instructeur_secondaire.instructeur
                    LEFT JOIN %1$som_utilisateur as utilisateur_2
                        ON instructeur_secondaire.om_utilisateur = utilisateur_2.om_utilisateur
                    ',
                    DB_PREFIXE
            );
        }

        // Ajout du filtre dans le where.
        $sqlFilter['WHERE'] .= sprintf(
            ' %1$s utilisateur_2.login = \'%2$s\' ',
            preg_match("/\bWHERE\b/i", $query) === 0 ? 'WHERE' : 'AND',
            $_SESSION['login']
        );
        // Renvoie la requête
        return $sqlFilter;
    }

    protected function add_filter_division_to_query(string $query) {
        $sqlFilter = array(
            'FROM' => '',
            'WHERE' => ''
        );
        // Vérifie si le lien entre la table division et la division
        // du dossier existe. Si ce n'est pas le cas on ajoute une jointure.
        if (preg_match("/".DB_PREFIXE."division(?!_)/i", $query) === 0) {
            $sqlFilter['FROM'] =
                '
                LEFT JOIN %1$sdivision
                    ON dossier.division=division.division
                ';
        }

        // Ajout du filtre dans le where.
        $sqlFilter['WHERE'] .= sprintf(
            ' %1$s division.division = \'%2$s\' ',
            preg_match("/\bWHERE\b/i", $query) === 0 ? 'WHERE' : 'AND',
            $_SESSION['division']
        );

        // Renvoie la requête
        return $sqlFilter;
    }

    public function view_widget_compteur_signatures(string $content = null) {

        $params = array('om_collectivite', 'service', 'url_renouvellement');
        $arguments = $this->get_arguments($content, $params);

        $collectivite_id = null;
        if (isset($arguments['om_collectivite']) && ! empty($arguments['om_collectivite'])) {
            $collectivite_id = $arguments['om_collectivite'];
        }
        if (empty($collectivite_id) && $this->f->is_option_renommer_collectivite_enabled()
                && isset($arguments['service']) && ! empty($arguments['service'])) {
            $collectivite_id = $arguments['service'];
        }
        if (empty($collectivite_id)) {
            // récupère l'identifiant de la collectivité de l'utilisateur courant
            $collectivite_params = $this->f->getCollectivite();
            if (isset($collectivite_params['om_collectivite_idx'])
                    && ! empty($collectivite_params['om_collectivite_idx'])) {
                $collectivite_id = $collectivite_params['om_collectivite_idx'];
            }
        }
        if (empty($collectivite_id)) {
            // erreur
            $message = $this->f->layout->display_message(
                'error',
                __("Échec de la récupération de la collectivité"));
            return false;
        }

        // date courante
        $now_datetime = new Datetime();
        $now_date_text = $now_datetime->format('Y-m-d');

        // récupère le nombre de signatures et le quota pour l'utilisateur en cours (ou paramétré)
        $sql = sprintf(
            "SELECT
                quantite, quota, unite, alerte
            FROM
                %1\$scompteur
            WHERE
                code = '%2\$s'
                AND om_collectivite = %3\$s
                AND (
                    om_validite_debut IS NULL
                    OR om_validite_debut <= TO_DATE('%4\$s', 'YYYY-MM-DD')
                )
                AND (
                    om_validite_fin IS NULL
                    OR om_validite_fin > TO_DATE('%4\$s', 'YYYY-MM-DD')
                )
            ORDER BY
                date_modification DESC
            LIMIT
                1",
            DB_PREFIXE,
            'signatures',
            $collectivite_id,
            $this->f->db->escapeSimple($now_date_text)
        );
        $qres = $this->f->get_all_results_from_db_query($sql, array(
            'origin' => __METHOD__,
            'force_return' => true));

        if ($qres['code'] != 'OK' || ! isset($qres['result'])) {
            $message = $this->f->layout->display_message(
                'error',
                __("Erreur de base de données"));
            return false;
        }
        if (empty($qres['result'])) {
            $message = $this->f->layout->display_message(
                'error',
                sprintf(
                    __("Aucun compteur '%s' valide pour la collectivité %d"),
                    'signatures',
                    $collectivite_id));
            return false;
        }
        if ($qres['row_count'] > 1) {
            $message = $this->f->layout->display_message(
                'error',
                sprintf(
                    __("Erreur: plus d'un compteur '%s' valide pour la collectivité %d"),
                    'signatures',
                    $collectivite_id));
            return false;
        }
        $count = floatval($qres['result'][0]['quantite']);
        $quota = floatval($qres['result'][0]['quota']);
        $unite = $qres['result'][0]['unite'];
        $alerte = floatval($qres['result'][0]['alerte']);

        if (empty($quota)) {
            return $this->display_resultat_bulle(
                $count.(! empty($unite) ? ' '.$unite : ''),
                __("Signatures"),
                'bg-info');
        }

        // détermine le nombre de signatures restantes/en dépassement à partir du quota, ainsi qu'un pourcentage
        $left_or_over = abs($quota - $count);
        $left_or_over_label = __("restantes");
        $consumed_percent = round($count * 100 / $quota);

        // génère le message à afficher à l'utilisateur, ainsi qu'un niveau de criticité INFO|WARNING|CRITICAL
        $css_class = 'info';
        $message = '';
        $url_renouvellement = isset($arguments['url_renouvellement']) ? $arguments['url_renouvellement'] : '#';
        if ($consumed_percent > 100) {
            $css_class = 'error';
            $message = $this->f->layout->display_message(
                $css_class,
                sprintf(
                __("Vous avez atteint la limite de votre quota de signatures. Afin de l'augmenter, %s"),
                '<a class="link" href="'.$url_renouvellement.'">'.__("cliquez ici").'</a>'));
            $left_or_over_label = __("en dépassement");
        }
        elseif (! empty($alerte) && $consumed_percent > $alerte) {
            $css_class = 'warning';
            $message = $this->f->layout->display_message(
                $css_class,
                sprintf(
                __("Attention vous approchez de la limite de votre quota de signatures. Afin de l'augmenter, %s"),
                '<a class="link" href="'.$url_renouvellement.'">'.__("cliquez ici").'</a>'));
        }

        // envoie/affiche la réponse HTTP en remplaçant les valeurs dans le template de réponse du widget
        echo str_replace(
            array('{{count}}', '{{quota}}', '{{left_or_over}}', '{{left_or_over_label}}', '{{consumed_percent}}', '{{message}}', '{{class}}'),
            array($count, $quota, $left_or_over, $left_or_over_label, $consumed_percent, $message, $css_class),
            self::WIDGET_COMPTEUR_SIGNATURE_TPL);
    }
}
