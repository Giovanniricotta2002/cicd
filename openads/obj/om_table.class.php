<?php
/**
 * Ce script définit la classe 'om_table'.
 *
 * @package openads
 * @version SVN : $Id: om_table.class.php 15650 2023-08-31 17:29:39Z softime $
 */

require_once PATH_OPENMAIRIE."om_table.class.php";

/**
 * Définition de la classe 'om_table' (om_table).
 *
 * Cette classe est destinée à permettre la surcharge de certaines méthodes de
 * la classe 'om_table' du framework pour des besoins spécifiques de
 * l'application.
 */
class om_table extends table {

    /**
     * Méthode de composition du tri
     *
     * @return string
     */
    function composeTri() {
        $tri = $this->tri;
        if ((string) $this->getParam("tricol") !== ""
            and isset($this->champAffiche[abs((int) $this->getParam("tricol"))])) {

            // Tricol est la cle du tableau de champ, il faut recuperer le
            // champ pour l'integrer dans la requete on verifie si un 'as' est
            // present pour s'en servir
            $tricol = $this->champAffiche[abs((int) $this->getParam("tricol"))];
            $tab = preg_split("/[ )]as|AS /", $tricol);

            if (count($tab) > 1) {

                /* Permet de determiner si la colonne a trier est une date.
                   Si $tab[0] contient DD/MM/YYYY, c'est une date.
                   Fonctionne actuellement qu'avec PostgresSQL. */

                if (strpos($tab[0], "'DD/MM/YYYY'")) {
                    // si c'est une date, on recupere le premier parametre
                    // de la fonction to_char
                    $tricol = str_replace("to_char(", "", $tab[0]);
                    $tricol = trim(str_replace(",'DD/MM/YYYY')", "", $tricol));
                    $tricol = trim(str_replace(", 'DD/MM/YYYY')", "", $tricol));
                } else {
                    // dans le cas d'un champ non-date, on recupere table.colonne
                    $tricol = $tab[0];
                }

                // seul un signe "-" en début de paramètre de tri effectue un tri
                // par ordre décroissant
                if (substr((string) $this->getParam("tricol"), 0, 1) !== "-") {

                    // tri croissant, nulls en dernier
                    if (OM_DB_PHPTYPE == 'pgsql') {
                        $tricol .= " ASC NULLS LAST";
                    } else {
                        $tricol = ' ISNULL('.$tricol.') ASC, '.$tricol.' ASC';
                    }
                } else {

                    // tri decroissant, nulls en dernier
                    if (OM_DB_PHPTYPE == 'pgsql') {
                        $tricol .= " DESC NULLS LAST";
                    } else {
                        $tricol = ' ISNULL('.$tricol.') ASC, '.$tricol.' DESC';
                    }
                }
            }

            // Si $tri n'est pas vide alors il faut inserer le nouveau champ
            // de tri en premier dans le ORDER BY
            if ($tri) {
                $tri = str_replace("order by ", "ORDER BY ".$tricol.",",
                                   strtolower($tri));
            } else {
                $tri = " order by ".$tricol."";
            }

        }
        return $tri;
    }

    /**
     * SURCHARGE
     *
     * Calcule et affiche la ligne d'entête du tableau.
     *
     * @param array $info
     * @param string $class Prefixe de la classe CSS a utiliser
     * @param boolean $onglet
     *
     * @return void
     */
    function displayHeader($info, $class = "tab", $onglet = false) {
        // Renomme le champ collectivité en service si l'option est activée
        if ($this->f->is_option_renommer_collectivite_enabled() === true) {
            foreach ($info as $key => $elem) {
                if ($elem["name"] === strtolower(__("collectivite"))
                    || $elem["name"] === strtolower(__("om_collectivite"))) {
                    //
                    $info[$key]["name"] = strtolower(__("service"));
                }
                if ($elem["name"] === strval(__("collectivite"))
                    || $elem["name"] === strval(__("om_collectivite"))) {
                    //
                    $info[$key]["name"] = strval(__("service"));
                }
            }
        }

        $getValues = $this->f->get_submitted_get_value();
        // Pour les sous-dossier, le clic sur le bouton "ajouter" entraine l'affichage
        // de la page de consultation du sous-dossier en tant que formulaire (sans ajax).
        //
        // Par défaut les actions de type "corner" affichées dans un onglet sont construite
        // pour utiliser un ajaxIt() afin d'accéder au lien paramétré. Pour contourner ce
        // problème si on est dans le contexte de l'onglet "sous-dossier" alors on modifie
        // la valeur du paramètre "onglet" pour faire comme si on était dans le contexte
        // d'un tab au lieu d'un soustab. Ainsi l'action va s'afficher sans ajaxIt et
        // permettre d'afficher un formulaire à la place d'un sous-formulaire.
        $specificUrl = '';
        $displayTri = true;
        if (! empty($getValues) && ! empty($getValues['obj'])) {
            if ($getValues['obj'] == 'sous_dossier') {
                $onglet = false;
                $displayTri = false;
            }
            // Gestion spécifique du tri pour les lien_dossier_tiers.
            // Il y a plusieurs listings sur l'onglet acteur donc cliquer sur le tri recharge
            // l'onglet avec uniquement un des tableaux triés.
            // Pour que le tri fonctionne correctement, la vue d'affichage des listings est chargée
            // avec 2 paramètres en plus :
            //   - tricol : indique la colonne à trier et le sens du tri
            //   - tritab : élément permettant d'identifier le tableau à trier. C'est la catégorie
            //               qui permet d'identifier quel tableau trier.
            elseif ($getValues['obj'] == 'lien_dossier_tiers' && ! empty($getValues['category'])) {
                $key = '1';
                $tricol = $key;
                // Récupération du tricol comme fais dans la classe parente
                if ((string) $this->getParam("tricol") !== "") {
                    $tricolParam = $this->getParam("tricol");
                    if (abs((int) $tricolParam) == $key) {
                        // si le tri est actuellement croissant
                        if (substr((string) $tricolParam, 0, 1) !== "-") {
                            $tricol = "-".$key;
                        // si le tri est actuellement decroissant
                        } elseif (substr((string) $tricolParam, 0, 1) === "-") {
                            $tricol = "";
                        }
                    }
                }
                // Constitution de l'url servant à afficher la vue avec le tri.
                // /!\ Le paramètre tritab est utilisé pour identifier sur quel tableau appliquer
                //     le tricol. Si ce paramètre est modifié, le modifier également dans :
                //       - lien_dossier_tiers::view_lien_dossier_tiers_tabs()
                // Initialisation des valeurs nécessaire à la construction de l'url
                $urlValues = array('obj', 'retourformulaire', 'idxformulaire', 'category');
                foreach($urlValues as $value) {
                    ${$value} = ! empty($getValues[$value]) ? $getValues[$value] : '';
                }
                $specificUrlTri = sprintf(
                    'a href="#" onclick="ajaxIt(\'%2$s\', \'%1$s&amp;obj=%2$s&amp;action=4&amp;retourformulaire=%3$s&amp;idxformulaire=%4$s&amp;tritab=%5$d&amp;tricol=%6$d\')',
                    OM_ROUTE_SOUSFORM,
                    $obj,
                    $retourformulaire,
                    $idxformulaire,
                    $category,
                    $tricol
                );
            }
        }
        // Récupération du header pour remplacer l'url lié au tri des colonne
        // par une url spécifique si elle a été spécifié
        ob_start();
        parent::displayHeader($info, $class, $onglet);
        $out = ob_get_contents();
        ob_end_clean();
        if (! empty($specificUrlTri)) {
            $out = preg_replace(
                "/a href=\"#\" onclick=\"ajaxIt\('\w*','(.*)'\)/",
                $specificUrlTri,
                $out
            );
        } elseif ($displayTri === false) {
            // Retire les redirections et les icônes de tri du header et ne conserve que
            // le nom à afficher en entete de colonne
            $out = preg_replace("/<a.*>.*ui-icon-triangle.*>(.*)<\/a>/", '$1', $out);
        }
        echo $out;
    }

    /**
     * SURCHARGE
     * 
     * Méthode de composition de la liste des champs du SELECT
     *
     * @return string
     */
    function composeChamp() {
        // Concatenation des champAffiche avec des virgules pour composer la
        // clause SELECT
        $champ = "";
        foreach ($this->champAffiche as $elem) {
            $champ = $champ."".$elem.",";
        }
        $champ = mb_substr($champ, 0, mb_strlen($champ) - 1);
        if ($this->f->is_option_renommer_collectivite_enabled() === true) {
            $champ = str_ireplace(array(__('om_collectivite'), __('collectivite')), __('service'), $champ);
        }
        return $champ;
    }

    /**
     * SURCHARGE
     *
     * Gestion de la recherche.
     *
     * @return void
     */
    function composeSearchTab() {
        parent::composeSearchTab();

        // Renomme le champ collectivité en service si l'option est activée
        if ($this->f->is_option_renommer_collectivite_enabled() === true) {
            if (in_array(__("om_collectivite"), $this->searchTab["display"]) === true) {
                $om_collectivite_keys = array_keys($this->searchTab["display"], __("om_collectivite"));
                foreach ($om_collectivite_keys as $om_collectivite_key) {
                    $this->searchTab["display"][$om_collectivite_key] = __("service");
                }
            }
            if (in_array(__("collectivite"), $this->searchTab["display"]) === true) {
                $om_collectivite_keys = array_keys($this->searchTab["display"], __("collectivite"));
                foreach ($om_collectivite_keys as $om_collectivite_key) {
                    $this->searchTab["display"][$om_collectivite_key] = __("service");
                }
            }
        }
    }

   /**
     * SURCHARGE/OVERLOAD
     *
     * Affichage principal.
     *
     * Surcharge pour retirer les espaces non sécables des icones (&nbsp;)
     * via capture du buffer d'output.
     *
     * @param array $params
     * @param array $actions
     * @param mixed $db
     * @param string $class Prefixe de la classe CSS a utiliser
     * @param boolean $onglet
     *
     * @return void
     */
    public function display($params = array(), $actions = array(), $db = NULL, $class = "tab", $onglet = false) {
        ob_start();
        parent::display($params, $actions, $db, $class, $onglet);
        $out = ob_get_contents();
        ob_end_clean();
        echo str_replace(
            array('</a>&nbsp;</td>', '</a>&nbsp;<a', '<td class="icons">&nbsp;'),
            array('</a></td>', '</a><a', '<td class="icons">'),
            $out
        );
    }


    /**
     * SURCHARGE/OVERLOAD
     * Méthode de composition de la recherche avancée.
     *
     * @param [type] $champ [description]
     * @param [type] $tri   [description]
     *
     * @return [type] [description]
     */
    function composeAdvancedSearch($champ, $tri){
        /* Dans le cas d'une recherche avancee, l'operateur binaire OR
           utilise dans la requete SQL de rechreche devient AND */

        $opp = "or";
        if ($this->isAdvancedSearchEnabled() and
            $this->f->get_submitted_post_value("advanced-search-submit") !== null) {
            $opp = "and";
        }

        // Traitement des filtrages sur tablejoin : on cherche à filtrer les données
        // de table qui vérifient au moins une fois le critère de recherche
        // portant sur la table liée
        // l'option tabletype est alors positionnée sur related par opposition à
        // reference pour une table de référence (le cas par défaut pour les critères
        // portant sur des tables liées)
        //
        // Ce traitement se fait avant traitement de la requête car les critères sont
        // ajoutés à la variable table sous la forme de jointure filtrante
        // de type
        // ... INNER JOIN related ON table.table = related.table
        // AND related.field = $value
        //
        // Exemple :
        //    $champs['parcelle'] = array(
        //    'table' => 'dossier_parcelle',
        //    'where' => 'injoin',
        //    'tablejoin' => 'INNER JOIN (SELECT DISTINCT dossier FROM '.DB_PREFIXE.'dossier_parcelle WHERE lower(dossier_parcelle.libelle) like %s ) AS A1 ON A1.dossier = dossier.dossier' ,
        //    'colonne' => 'libelle',
        //    'type' => 'text',
        //    'taille' => 30,
        //    'libelle' => __('parcelle'));

        // test si on est bien en recherche avancée
        if ($this->isAdvancedSearchEnabled() and
            $this->f->get_submitted_post_value("advanced-search-submit") !== null) {
            // Boucle sur les champs de recherche
            foreach ($this->searchTab["query"] as $key => $elem) {
                // le champ a-t-il une clé tablejoin ? et si la valeur est-elle renseignée ?
                if ( key_exists("tablejoin", $this->paramChampRechercheAv[$elem])
                    and key_exists($elem, $this->f->get_submitted_post_value())
                    ) {
                    // récupération et retraitement de la valeur du POST
                    $value = $this->composeSearchValue(
                        $this->f->get_submitted_post_value($elem)
                    );

                    // retraitement de join pour remplacer %s par la valeur recherchée ;
                    $tablejoin = $this->paramChampRechercheAv[$elem]["tablejoin"];
                    // la chaine de tablejoin doit contenir un unique %s qui représente le champ recherche
                    if (substr_count($tablejoin, '%s') >= 1 ) {
                        $tablejoin = sprintf($tablejoin, $value);
                    }

                    // SURCHARGE pour les ids numériques
                    // si on recherche sur un sélect avec un identifiant numérique
                    if (substr_count($tablejoin, '%d') >= 1 ) {
                        $tablejoin = sprintf($tablejoin, intval($this->f->get_submitted_post_value($elem)));
                    }

                    // Ajout du SQL de la jointure de la table liée dans $this->table
                    $this->table .= " ".$tablejoin." ";
                }


            }
        }


        // Construction de la requete
        $this->sql = "SELECT ".$champ." ";
        $this->sql .= "FROM ".$this->table." ";
        if ($this->selection == '') {
            $this->sql .= "WHERE (";
        } else {
            $this->sql .= $this->selection . " AND (";
        }

        // Construction de la clause WHERE avec les champs de recherche
        $sqlw = "";

        $aggregate_filters = array();

        foreach ($this->searchTab["query"] as $key => $elem) {
            $value = $this->f->get_submitted_post_value("recherche");

            /* Si la recherche avancee est activee on recupere les
               valeurs postees */

            $champ = $elem;

            /* Dans le cas ou des critères sont de type tablejoin on ne
               rajoute pas de WHERE */
            if (key_exists("tablejoin", $this->paramChampRechercheAv[$elem])) {
                continue;
            }
            /* Dans le cas ou des criteres de recherche avancee
               utilisent des fonctions d'aggregation, on n'ajoute
               pas ces criteres a la clause WHERE. Ils seront
               ajoute plus tard a la clause HAVING. */

            if (key_exists("aggregate", $this->paramChampRechercheAv[$champ])) {
                array_push($aggregate_filters, $champ);
                continue;
            }

            /* Gestion des clauses WHERE particulieres */

            if (key_exists("where", $this->paramChampRechercheAv[$champ])) {

                // CAS - intervalle de date
                if ($this->paramChampRechercheAv[$champ]["where"] == "intervaldate") {

                    /* Dans le cas d'un intervalle de dates, deux
                       valeurs sont soumisent: le minimum et le
                       maximum */

                    // le format de date recu : jj/mm/aaaa
                    // avec 0 initiaux

                    if (key_exists($champ."_min", $this->f->get_submitted_post_value())) {
                        $min_date_tab = explode(
                                "/",
                                $this->f->get_submitted_post_value($champ."_min")
                            );

                        if (key_exists(2, $min_date_tab)) {
                            $min_date = $min_date_tab[2]."-".$min_date_tab[1]."-".$min_date_tab[0];
                            $sqlw .= " ".$this->paramChampRechercheAv[$champ]["table"].".".$this->paramChampRechercheAv[$champ]["colonne"]. " >= DATE('".$min_date."') ".$opp." ";
                        }
                    }

                    if (key_exists($champ."_max", $this->f->get_submitted_post_value())) {
                        $max_date_tab = explode(
                                "/",
                                $this->f->get_submitted_post_value($champ."_max")
                            );

                        if (key_exists(2, $max_date_tab)) {
                            $max_date = $max_date_tab[2]."-".$max_date_tab[1]."-".$max_date_tab[0];
                            $sqlw .= " ".$this->paramChampRechercheAv[$champ]["table"].".".$this->paramChampRechercheAv[$champ]["colonne"]. " <= DATE('".$max_date."') ".$opp." ";
                        }
                    }

                } elseif (
                    // CAS - valeurs booleennes
                    $this->paramChampRechercheAv[$champ]["where"] == "booleansubquery" or
                        $this->paramChampRechercheAv[$champ]["where"] == "insubquery") {

                    if ($this->paramChampRechercheAv[$champ]["subtype"] == "manualselect" and
                        key_exists($champ, $this->f->get_submitted_post_value())) {

                        $sqlw .= " ".$this->paramChampRechercheAv[$champ]["table"].".".
                                     $this->paramChampRechercheAv[$champ]["colonne"];

                        if ($this->paramChampRechercheAv[$champ]["where"] == "insubquery" and
                            $this->f->get_submitted_post_value($champ) == "false") {
                            $sqlw .= " NOT IN";
                        } else {
                            $sqlw .= " IN";
                        }

                        $sqlw .= " (".$this->paramChampRechercheAv[$champ]["subquery"];

                        if ($this->paramChampRechercheAv[$champ]["where"] == "booleansubquery") {
                            $sqlw .= " ".$this->f->get_submitted_post_value($champ);
                        }

                        $sqlw .= " ) ".$opp;

                        if ($this->paramChampRechercheAv[$champ]["where"] == "insubquery") {
                            continue;
                        }

                        if ($this->paramChampRechercheAv[$champ]["val_".$this->f->get_submitted_post_value($champ)] == "strict") {

                            $sqlw .= " ".$this->paramChampRechercheAv[$champ]["table"].".".
                                         $this->paramChampRechercheAv[$champ]["colonne"];

                            $sqlw .= " NOT IN";
                            $sqlw .= " (".$this->paramChampRechercheAv[$champ]["subquery"];

                            if ($this->paramChampRechercheAv[$champ]["where"] == "booleansubquery") {

                                $val = "true";
                                if ($this->f->get_submitted_post_value($champ) == "true") {
                                    $val = "false";
                                }

                                $sqlw .= " ".$val;
                            }

                            $sqlw .= " ) ".$opp;
                        }
                    }
                }

                // fin du traitement des valeurs particulieres du WHERE
                continue;
            }

            /*
             * Gestion de la clause TYPE select
             *
             * Si le champ est de type select alors on bypass les wildcards
             * pour faire une recherche strictement égale.
             */

            if (key_exists("type", $this->paramChampRechercheAv[$champ])
                && $this->paramChampRechercheAv[$champ]["type"] == "select") {

                // Création de la condition du where (stricte puisque select)
                $sqlw .= " ".$this->paramChampRechercheAv[$champ]["table"].
                ".".$this->paramChampRechercheAv[$champ]["colonne"].
                " = '".$this->f->get_submitted_post_value($champ)."' ".$opp;

                // On sort de la boucle pour traiter le champ suivant
                continue;
            } // Fin du traitement du type select

            $value = $this->f->get_submitted_post_value($champ);
            if ( is_array($this->paramChampRechercheAv[$champ]["colonne"])){

                $elem = array();
                foreach ($this->paramChampRechercheAv[$champ]["colonne"] as  $data) {

                    $elem[] = $this->paramChampRechercheAv[$champ]["table"].".". $data;
                }
            }
            else{

                $elem = $this->paramChampRechercheAv[$champ]["table"].".".
                    $this->paramChampRechercheAv[$champ]["colonne"];
            }

            // gestion des champs date simple, sans intervalle
            if ($this->paramChampRechercheAv[$champ]["type"] == "date") {
                $sqlw .= " ".$elem." = DATE('".$value."')".$opp." ";
                continue;
            }

            // Caractère d'échappement d'élément dans une recherche
            $separator = ',';
            /*
             * Si on passe plusieurs colonnes dans le champ de recherche,
             * on boucle sur chaque colonne de table liée à ce champ de recherche
             * */
            if ( is_array($elem) ){
                $sqlw .= ' ( ';
                foreach ($elem as $data) {
                    $sqlw .= $this->createSQLW($data, $value, ' OR ');
                }
                $sqlw = substr($sqlw, 0, strlen($sqlw) - 3 ) . " )".$opp." ";
            } else {
                // recherche dans un champ unique
                $sqlw .= $this->createSQLW($elem, $value, $opp).' ';
            }
        }
        // Suppression du dernier $opp
        $sqlw = substr($sqlw, 0, strlen($sqlw) - strlen($opp)-1).")";
        // Construction de la requête non triée pour le count
        $this->sqlnt = $this->sql . $sqlw;
        // Suppression du AND si pas utilisé
        if (substr($this->sqlnt, strlen($this->sqlnt)-6,strlen($this->sqlnt)) == 'AND ()') {
            $this->sqlnt = substr($this->sqlnt, 0, strlen($this->sqlnt)-6);
        }
        // Suppression du WHERE si pas utilisé
        if( substr($this->sqlnt, strlen($this->sqlnt)-8,strlen($this->sqlnt)) == 'WHERE ()'){
            $this->sqlnt = substr($this->sqlnt, 0, strlen($this->sqlnt)-8);
        }
        // Construction de la requête triée pour les résultats
        $this->sql = $this->sqlnt." ".$tri;

        /* Dans le cas ou des criteres de recherche avancee utilisent des
           fonctions d'aggregation, on construit la clause HAVING adequate */

        if (isset($aggregate_filters) and
            count($aggregate_filters) != 0) {

            // Suppression des incoherences
            $this->sql = $this->_del_substr($this->sql, "where ()");
            $this->sql = $this->_del_substr($this->sql, "and ()");

            /* Si la requete contient deja la clause HAVING, on ajoute
               les criteres de recherche utilisant des fonctions d'aggregation
               apres le HAVING */

            if (stristr($this->sql, "having") != false) {

                //
                $filters = "HAVING"; /* pas d'espace apres ce having svp*/
                $filters .= $this->add_aggregate_filters($aggregate_filters, $opp);
                $this->sql = str_ireplace("having", $filters, $this->sql);

            } elseif (stristr($this->sql, "order by") != false) {
                /* Si la requete ne contient pas la clause HAVING, mais une clause
                   ORDER BY, on ajoute les criteres de recherche utilisant des fonctions
                   d'aggregation avant le ORDER BY */

                $filters = "HAVING"; /* pas d'espace apres ce having svp*/
                $filters .= $this->add_aggregate_filters($aggregate_filters, $opp);
                $filters .= " ORDER BY";

                //
                $this->sql = str_ireplace("order by", $filters, $this->sql);

            } else {
                /* Si la requete ne contient ni la clause HAVING, ni ORDER BY, on ajoute
                   les criteres de recherche utilisant des fonctions d'aggregation
                   a la fin de $this->sqlC */
                //
                $this->sql .= " HAVING"; /* pas d'espace apres ce having svp*/
                $this->sql.= $this->add_aggregate_filters($aggregate_filters, $opp);
            }
        }

        // Construction de la requete qui compte le nombre
        // d'enregistrement
        $this->sqlC = "SELECT count(*) FROM (".$this->sqlnt.") AS A";
    }

}
