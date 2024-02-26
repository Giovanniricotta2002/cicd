<?php
ini_set('max_execution_time', '7200');
ini_set('memory_limit', '4G');
ini_set('max_file_size', '1G');
/**
 * Ce script permet de définir la classe 'import_specific'.
 *
 * @package openads
 * @version SVN : $Id: import_specific.class.php 6138 2016-03-09 10:53:39Z nhaye $
 */

require_once PATH_OPENMAIRIE."om_import.class.php";

/**
 * Définition de la classe import.
 *
 * Cette classe étend le module d'import du framework. Ce module permet 
 * l'intégration de données dans l'applicatif depuis des fichiers CSV.
 */
class import_specific extends import {

    /**
     *
     */
    var $script_path = "../app/import_specific.php";

    /**
     *
     */
    var $script_extension = ".import_specific.inc.php";

    /**
     * Ligne de travail du tableau en cours de formatage
     */
    var $line;

    /**
     * Table de ligne rejetées à retiournées en csv
     */
    var $rejet = array();

    /**
     * Table de ligne rejetées à retiournées en csv
     */
    var $line_error = array();

    /**
     * Liste des DA contenant chacun une liste de DI
     */
    var $dossier_autorisation;

    /**
     * liste des tableaux associatifs permettant de pré-charger les
     * tables de correspondance avant de commencer le traitement
     *
     * @var array
     */
    protected $cache;

    /**
     * Affichage de la liste des imports disponibles.
     *
     * @return void
     */
    function display_import_list() {
        //
        echo "\n<div id=\"import-list\">\n";
        // Composition de la liste de liens vers les imports disponibles.
        // En partant de la liste des imports disponibles, on compose une liste
        // d'éléments composés d'une URL, d'un libellé, et de tous les paramètres
        // permettant l'affichage de l'élément comme un élément de liste.
        $list = array();
        foreach ($this->get_import_list() as $key => $value) {
            //
            $list[] = array(
                "href" => $this->script_path."?obj=".$key,
                "title" => $value["title"],
                "class" => "om-prev-icon import-16",
                "id" => "action-import-".$key."-importer",
            );
        }
        //
        $this->f->layout->display_list(
            array(
                "title" => _("choix de l'import"),
                "list" => $list,
            )
        );
        //
        echo "</div>\n";
    }

    /**
     * Affichage du formulaire d'import.
     *
     * @param string $obj Identifiant de l'import.
     *
     * @return void
     */
    function display_import_form($obj) {
        //
        echo "\n<div id=\"form-csv-import\" class=\"formulaire\">\n";
        $this->f->layout->display__form_container__begin(array(
            "action" => $this->script_path."?obj=".$obj,
            "method" => "post",
            "name" => "f2",
        ));
        //
        $champs = array("fic1", "separateur");
        //
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        //
        $form->setLib("fic1", __("Fichier CSV"));
        $form->setType("fic1", "upload2");
        $form->setTaille("fic1", 64);
        $form->setMax("fic1", 30);
        // Restriction sur le champ d'upload
        $params = array(
            "constraint" => array(
                "size_max" => 8,
                "extension" => ".csv;.txt"
            ),
        );
        $form->setSelect("fic1", $params);
        //
        $form->setLib("separateur", __("Separateur"));
        $form->setType("separateur", "select");
        $separator_list = array(
            0 => array(";", ",", ),
            1 => array("; ".__("(point-virgule)"), ", ".__("(virgule)")),
        );
        $form->setSelect("separateur", $separator_list);
        //
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        //
        $this->f->layout->display__form_controls_container__begin(array(
            "controls" => "bottom",
        ));
        $this->f->layout->display__form_input_submit(array(
            "name" => "submit-csv-import",
            "value" => __("Importer"),
            "class" => "boutonFormulaire",
        ));
        // Lien retour
        $this->f->layout->display_lien_retour(array(
            "href" => $this->script_path,
        ));
        $this->f->layout->display__form_controls_container__end();
        //
        $this->f->layout->display__form_container__end();
        echo "</div>\n";
    }

    /**
     * Affichage de l'assistant d'import.
     *
     * @param string $obj Identifiant de l'import.
     *
     * @return void
     */
    function display_import_helper($obj) {
        if ($obj === "ads2007") {
            $this->display_import_helper_ads2007($obj);
        }
        elseif (in_array($obj, array('bible', 'commune', 'region', 'departement'))) {
            $this->display_import_helper_specific($obj);
        }
        else {
            parent::display_import_helper($obj);
        }
    }

    /**
     * Affichage de l'assistant d'import.
     *
     * @param string $obj Identifiant de l'import.
     *
     * @return void
     */
    function display_import_helper_ads2007($obj) {
        // Récupération du fichier de paramétrage de l'import
        // XXX Faire un accesseur pour vérifier l'existence du fichier
        include $this->import_list[$obj]["path"];
        //
        if (!isset($fields)) {
            return;
        }
        //
        echo "<fieldset class=\"cadre ui-corner-all ui-widget-content\">\n";
        //
        echo "\t<legend class=\"ui-corner-all ui-widget-content ui-state-active\">";
        echo _("Structure du fichier CSV");
        echo "</legend>\n";
        // Lien vers le téléchargement d'un fichier CSV modèle
        echo "<div>";
        // $this->f->layout->display_link(array(
        //     "href" => $this->script_path."?obj=".$obj."&amp;action=template",
        //     "title" => _("Télécharger le fichier CSV modèle"),
        //     "class" => "om-prev-icon reqmo-16",
        //     "target" => "_blank",
        // ));
        echo "</div>";
        // Affichage des informations sur l'import
        echo "<table ";
        echo " class=\"table table-condensed table-bordered table-striped\" ";
        echo " id=\"structure_csv\">\n";
        //
        echo "<thead>\n";
        echo "<tr>";
        echo "<th>"._("Ordre")."</th>";
        echo "<th>"._("Champ")."</th>";
        echo "<th>"._("Type")."</th>";
        echo "<th>"._("Obligatoire")."</th>";
        echo "<th>"._("Defaut")."</th>";
        echo "<th>"._("Vocabulaire")."</th>";
        echo "</tr>\n";
        echo "</thead>\n";
        //
        $i = 1;
        //
        echo "<tbody>\n";
        foreach ($fields as $key => $field) {
            // Gestion du caractère obligatoire du champ
            (isset($field["require"]) && $field["require"] == true) ?
                $needed = true : $needed = false;
            echo "<tr>";
            // Ordre
            echo "<td><b>".$i."</b></td>";
            // Champ
            echo "<td>".$field["header"]."</td>";
            // Type
            echo "<td>";
            if (isset($field["type"])) {
                switch ($field["type"]) {
                    case 'blob':
                        echo "text";
                        break;
                    case 'string':
                        echo "text";
                        break;
                    default:
                        echo $field["type"];
                        break;
                }
            }
            // Taille
            if (isset($field["len"])) { 
                if (!in_array($field["type"], array("blob", "geom", ))) {
                    echo " (";
                    echo $field["len"];
                    echo ")";
                }
            }
            echo "</td>";
            // Obligatoire si not null et si aucune valeur par défaut
            echo "<td>";
            if ($needed == true && !isset($field["default"])) { 
                echo "Oui";
            }
            echo "</td>";
            // Défaut
            echo "<td>";
            if (isset($field["default"])) { 
                echo "<i>".$field["default"]."</i>";
            }
            echo "</td>";
            // Vocabulaire
            echo "<td>";
            // Clé étrangère
            if (isset($field["foreign_key"])) {
                echo _("Cle etrangere vers").
                    " : <a href=\"".OM_ROUTE_TAB."&obj=".
                    $field["foreign_key"]["table"]."\">";
                echo $field["foreign_key"]["table"].".".$field["foreign_key"]["field"];
                echo "</a>";
                if (isset($field["foreign_key"]["foreign_key_alias"]) 
                    && isset($field["foreign_key"]["foreign_key_alias"]["fields_list"])) {
                    if (count($field["foreign_key"]["foreign_key_alias"]["fields_list"]) > 1) {
                        echo "<br/>=> "._("Valeurs alternatives possibles")." : ";
                    } else {
                        echo "<br/>=> "._("Valeur alternative possible")." : ";
                    }
                    echo implode(
                            ", ",
                            $field["foreign_key"]["foreign_key_alias"]["fields_list"]
                        );
                }
            }
            // Dates et booléens
            $field_info = "";
            if (isset($field["type"])) {
                switch ($field["type"]) {
                    case 'date':
                        $field_info = _("Format")." : '"._("DD/MM/YYYY")."'";
                        break;
                    case 'bool':
                        $field_info = _("Format")." :<br/>";
                        if ($needed == false) {
                            $field_info .= "'' "._("pour état null")."<br/>";
                        }
                        $field_info .= "'t', 'true', '1', 'Oui' "._("pour oui");
                        $field_info .= "<br/>";
                        $field_info .= "'f', 'false', '0', 'Non' "._("pour non");
                        break;
                    default:
                        break;
                }
            }
            echo $field_info;
            echo "</td>";
            //
            echo "</tr>\n";
            $i++;
        }
        //
        echo "</tbody>\n";
        //
        echo "</table>\n";
        //
        echo "</fieldset>\n";
    }

    /**
     * Surcharge pour remplacer  OM_ROUTE_MODULE_IMPORT par '../app/import_specific.php?'.
     *
     * @param string $obj Identifiant de l'import.
     *
     * @return void
     */
    function display_import_helper_specific($obj) {
        // Récupération du fichier de paramétrage de l'import
        // XXX Faire un accesseur pour vérifier l'existence du fichier
        include $this->import_list[$obj]["path"];
        //
        if (isset($zone) && !isset($fields)) {
            return;
        }
        //
        echo "<fieldset class=\"cadre ui-corner-all ui-widget-content\">\n";
        //
        echo "\t<legend class=\"ui-corner-all ui-widget-content ui-state-active\">";
        echo __("Structure du fichier CSV");
        echo "</legend>\n";
        // Lien vers le téléchargement d'un fichier CSV modèle
        echo "<div>";
        $this->f->layout->display_link(array(
            "href" => "../app/import_specific.php?obj=$obj&amp;action=template",
            "title" => __("Télécharger le fichier CSV modèle"),
            "class" => "om-prev-icon reqmo-16",
            "target" => "_blank",
        ));
        echo "</div>";
        // Affichage des informations sur l'import
        echo "<table ";
        echo " class=\"table table-condensed table-bordered table-striped\" ";
        echo " id=\"structure_csv\">\n";
        //
        echo "<thead>\n";
        echo "<tr>";
        echo "<th>".__("Ordre")."</th>";
        echo "<th>".__("Champ")."</th>";
        echo "<th>".__("Type")."</th>";
        echo "<th>".__("Obligatoire")."</th>";
        echo "<th>".__("Defaut")."</th>";
        echo "<th>".__("Vocabulaire")."</th>";
        echo "</tr>\n";
        echo "</thead>\n";
        //
        $i = 1;
        //
        echo "<tbody>\n";
        foreach ($fields as $key => $field) {
            // Gestion du caractère obligatoire du champ
            (isset($field["notnull"]) && $field["notnull"] == true) ?
                $needed = true : $needed = false;
            echo "<tr>";
            // Ordre
            echo "<td><b>".$i."</b></td>";
            // Champ
            echo "<td>".$key."</td>";
            // Type
            echo "<td>";
            if (isset($field["type"])) {
                switch ($field["type"]) {
                    case 'blob':
                        echo "text";
                        break;
                    default:
                        echo $field["type"];
                        break;
                }
            }
            // Taille
            if (isset($field["len"])) {
                if (!in_array($field["type"], array("blob", "geom", ))) {
                    echo " (";
                    echo $field["len"];
                    echo ")";
                }
            }
            echo "</td>";
            // Obligatoire si not null et si aucune valeur par défaut
            echo "<td>";
            if ($needed == true && !isset($field["default"])) {
                echo "Oui";
            }
            echo "</td>";
            // Défaut
            echo "<td>";
            if (isset($field["default"])) {
                echo "<i>".$field["default"]."</i>";
            }
            echo "</td>";
            // Vocabulaire
            echo "<td>";
            // Clé étrangère
            if (isset($field["fkey"])) {
                echo __("Cle etrangere vers")." : <a href=\"".OM_ROUTE_TAB."&obj=".$field["fkey"]["foreign_table_name"]."\">";
                echo $field["fkey"]["foreign_table_name"].".".$field["fkey"]["foreign_column_name"];
                echo "</a>";
                if (isset($field["fkey"]["foreign_key_alias"])
                    && isset($field["fkey"]["foreign_key_alias"]["fields_list"])) {
                    if (count($field["fkey"]["foreign_key_alias"]["fields_list"]) > 1) {
                        echo "<br/>=> ".__("Valeurs alternatives possibles")." : ";
                    } else {
                        echo "<br/>=> ".__("Valeur alternative possible")." : ";
                    }
                    echo implode(", ", $field["fkey"]["foreign_key_alias"]["fields_list"]);
                }
            }
            // Dates et booléens
            $field_info = "";
            if (isset($field["type"])) {
                switch ($field["type"]) {
                    case 'date':
                        $field_info = __("Format")." : '".__("YYYY-MM-DD")."'";
                        break;
                    case 'bool':
                        $field_info = __("Format")." :<br/>";
                        if ($needed == false) {
                            $field_info .= "'' ".__("pour état null")."<br/>";
                        }
                        $field_info .= "'t', 'true', '1' ".__("pour oui");
                        $field_info .= "<br/>";
                        $field_info .= "'f', 'false', '0' ".__("pour non");
                        break;
                    default:
                        break;
                }
            }
            echo $field_info;
            echo "</td>";
            //
            echo "</tr>\n";
            $i++;
        }
        //
        echo "</tbody>\n";
        //
        echo "</table>\n";
        //
        echo "</fieldset>\n";
    }

    /**
     * Traitement d'import.
     *
     * @param string $obj Identifiant de l'import.
     *
     * @todo Modifier cette méthode pour la rendre générique et éventuellement
     *       utilisable depuis d'autres contextes que celui de la vue principale
     *       du module import.
     *
     * @return void
     */
    function treatment_import($obj) {
        if ($obj === "ads2007") {
            $this->treatment_import_ads2007($obj);
        }
        elseif ($obj === "bible") {
            $this->treatment_import_bible($obj);
        }
        elseif (in_array($obj, array('commune', 'region', 'departement'))) {
            $this->treatment_import_with_validity($obj);
        }
        else {
            parent::treatment_import($obj);
        }
    }

    /**
     * [treatment_import_bible description]
     *
     * @param [type] $obj [description]
     *
     * @return [type] [description]
     */
    private function treatment_import_bible($obj) {
        // On vérifie que le formulaire a bien été validé
        if (!isset($_POST['submit-csv-import'])) {
            //
            return false;
        }

        // On récupère les paramètres du formulaire
        $separateur=$_POST['separateur'];

        // On vérifie que le fichier a bien été posté et qu'il n'est pas vide
        if (isset($_POST['fic1']) && $_POST['fic1'] == "") {
            //
            $class = "error";
            $message = __("Vous n'avez pas selectionne de fichier a importer.");
            $this->f->displayMessage($class, $message);
            //
            return false;
        }

        // On enlève le préfixe du fichier temporaire
        $fichier_tmp = str_replace("tmp|", "", $_POST['fic1']);
        // On récupère le chemin vers le fichier
        $path = $this->f->storage->storage->temporary_storage->getPath($fichier_tmp);
        // On vérifie que le fichier peut être récupéré
        if (!file_exists($path)) {
            //
            $class = "error";
            $message = __("Le fichier n'existe pas.");
            $this->f->displayMessage($class, $message);
            //
            return false;
        }

        // Configuration par défaut du fichier de paramétrage de l'import
        //
        $table = "";
        // Clé primaire numérique automatique. Si la table dans laquelle les
        // données vont être importées possède une clé primaire numérique
        // associée à une séquence automatique, il faut positionner le nom du
        // champ de la clé primaire dans la variable $id. Attention il se peut
        // que ce paramètre se chevauche avec le critère OBLIGATOIRE. Si ce
        // champ est défini dans $zone et qu'il est obligatoire et qu'il est
        // en $id, les valeurs du fichier CSV seront ignorées.
        $id = "";
        //
        $verrou = 1; // =0 pas de mise a jour de la base / =1 mise a jour
        //
        $fic_rejet = 1; // =0 pas de fichier pour relance / =1 fichier relance traitement
        //
        $ligne1 = 1; // = 1 : 1ere ligne contient nom des champs / o sinon
        //
        $encodages = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1");

        // Récupération du fichier de paramétrage de l'import
        // XXX Faire un accesseur pour vérifier l'existence du fichier
        include $this->import_list[$obj]["path"];

        // On ouvre le fichier en lecture
        $fichier = fopen($path, "r");

        // Initialisation des variables
        $cpt = array(
            "total" => 0,
            "rejet" => 0,
            "insert" => 0,
            "firstline" => 0,
            "empty" => 0,
        );
        $rejet = "";

        // Boucle sur chaque ligne du fichier
        $lines = array();
        while (!feof($fichier)) {
            // Incrementation du compteur de lignes
            $cpt['total']++;
            // Logger
            $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total'], EXTRA_VERBOSE_MODE);
            // On définit si on se trouve sur la ligne titre
            $firstline = ($cpt['total'] == 1 && $ligne1 == 1 ? true : false);
            // On définit le marqueur correct à true
            $correct = true;
            //
            $valF = array();
            $msg = "";

            // Récupération de la ligne suivante dans le fichier
            $contenu = fgetcsv($fichier, 4096, $separateur);

            //
            $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - contenu = ".print_r($contenu, true), EXTRA_VERBOSE_MODE);
            // Si la ligne a plus d'un champ et que le premier champ n'est pas vide
            if (is_array($contenu) === true && count($contenu) > 1 && $contenu[0] != "") { // enregistrement vide (RC à la fin)
                //
                if ($firstline == true) {
                    //
                    $cpt['firstline']++;
                    // Logger
                    $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - firstline", EXTRA_VERBOSE_MODE);
                } else {
                    // NG
                    if (isset($fields)) {
                        // On boucle sur chaque champ défini dans le fichier
                        // de configuration de l'import pour récupérer la
                        // valeur à importer dans la base pour ce champ
                        foreach ($fields as $key => $field) {
                            //
                            $key_num = array_search($key, array_keys($fields));
                            //
                            if (!isset($contenu[$key_num])) {
                                $valF[$key] = -1;
                                // On rejette l'enregistrement
                                $correct = false;
                                // Raison du rejet à ajouter dans le fichier rejet
                                $msg = __("nombre de colonnes incohérent")." : la colonne ".$key_num." n'existe pas";
                                // Logger
                                $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                            } else {
                                // Suppression des espaces superflus
                                $valF[$key] = trim($contenu[$key_num]);
                                // Traitement de l'encodage
                                $valF[$key] = iconv(mb_detect_encoding($valF[$key], $encodages), "UTF-8", $valF[$key]);
                                // la chaine de texte 'null' représente la valeur null
                                if (strtolower($valF[$key]) === "null") {
                                    $valF[$key] = null;
                                }
                            }

                            // Logger
                            $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - champ '".$key."' = '".$valF[$key]."'", EXTRA_VERBOSE_MODE);

                            // ----------------------------------------------------
                            // Gestion des valeurs par défaut lors de la
                            // transmission d'une valeur vide ou nulle
                            // ----------------------------------------------------
                            // Si le paramétrage est défini correctement et que la
                            // valeur transmise est vide ou nulle
                            if (isset($field["type"]) && isset($field["notnull"])
                                && $valF[$key] !== '0'
                                && (empty($valF[$key]) || is_null($valF[$key]))) {
                                // Si une valeur par défaut est proposée dans la paramétrage
                                if (isset($field["default"])) {
                                    // On affecte la valeur par défaut
                                    $valF[$key] = $field["default"];
                                // Si le champ est de type entier et qu'il n'est pas
                                // obligatoire
                                } elseif ($field["type"] == "int"
                                          && $field["notnull"] == false) {
                                    // On affecte null afin de ne pas initialiser
                                    // un champs entier avec une chaine vide ce qui
                                    // provoquerait une erreur de base de données
                                    $valF[$key] = null;

                                // Si le champ est de type date et qu'il n'est pas
                                // obligatoire
                                } elseif ($field["type"] == "date"
                                          && $field["notnull"] == false) {
                                    // On affecte null afin de ne pas initialiser
                                    // un champs date avec une chaine vide ce qui
                                    // provoquerait une erreur de base de données
                                    $valF[$key] = null;

                                // Si le champ est de type booléen et qu'il n'est pas
                                // obligatoire
                                } elseif ($field["type"] == "bool"
                                          && $field["notnull"] == false) {
                                    // XXX Vérifier pourquoi la valeur null
                                    // provoque une erreur de base de données
                                    $valF[$key] = null;

                                // Si le champ est de type string et qu'il n'est pas
                                // obligatoire et que ce champ est une clé étrangère
                                } elseif ($field["type"] == "string"
                                          && $field["notnull"] == false
                                          && isset($field["fkey"])) {
                                    // On affecte null car une chaine vide serait
                                    // considérait comme une clé primaire de l'autre
                                    // table ce qui provoquerait une erreur de base
                                    //  de données
                                    $valF[$key] = null;

                                // Si le champ est de type geom et qu'il n'est pas
                                // obligatoire
                                } elseif ($field["type"] == "geom"
                                          && $field["notnull"] == false) {
                                    // On enlève le champ de l'enregistrement
                                    unset($valF[$key]);
                                }
                            }

                            // ----------------------------------------------------
                            // Vérification du caractère obligatoire d'un champ
                            // ----------------------------------------------------
                            if (isset($field["notnull"]) && $field["notnull"] == true
                                && (empty($valF[$key]) || is_null($valF[$key])) && $valF[$key] != '0') {
                                // On rejette l'enregistrement
                                $correct = false;
                                // Raison du rejet à ajouter dans le fichier rejet
                                $msg = __("champ obligatoire vide")." : ".$key." = ".$valF[$key];
                                // Logger
                                $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                            }

                            // ----------------------------------------------------
                            // Vérification de la taille des string
                            // ----------------------------------------------------
                            if (isset($field["type"]) && $field["type"] == "string"
                                && mb_strlen($valF[$key]) > $field["len"]) {
                                // On rejette l'enregistrement
                                $correct = false;
                                // Raison du rejet à ajouter dans le fichier rejet
                                $msg = __("valeur trop longue pour le champ")." : ".$key."(".$field["len"].") = ".$valF[$key]." (".mb_strlen($valF[$key]).")";
                                // Logger
                                $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                            }

                            // ----------------------------------------------------
                            // Gestion du critère EXIST
                            // ----------------------------------------------------
                            // Ce critère permet de vérifier si la valeur fournie
                            // existe bien dans la table liée (clé étrangère).
                            // Exemple du paramétrage de ce critère :
                            //   $exist = array(
                            //     "champ1" => 1, // Ce champ est lié et doit exister
                            //     "champ2" => 0, // Ce champ n'est pas lié
                            //   );
                            // Par défaut si le critère n'est pas paramétré, on
                            // considère que le champ n'est pas lié.
                            // Comportement : si la valeur du champ en question
                            // dans le fichier CSV est vide alors on rejette
                            // l'enregistrement
                            // ----------------------------------------------------
                            if (isset($field["fkey"]) && !empty($valF[$key])) {
                                // Logger
                                $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - champ '".$key."' - EXIST", EXTRA_VERBOSE_MODE);
                                // Si le champ recherché est sensé être de type entier et est n'est pas numeric
                                if (isset($field["type"]) && $field["type"] = "int"
                                    && !is_numeric($valF[$key])
                                    && isset($field["fkey"]["foreign_key_alias"])) {
                                    $sql = str_replace("<SEARCH>", $valF[$key], $field["fkey"]["foreign_key_alias"]["query"]);
                                    $qres = $this->f->get_one_result_from_db_query(
                                        $sql,
                                        array(
                                            "origin" => __METHOD__,
                                            "force_return" => true,
                                        )
                                    );
                                    if (!is_null($qres["result"]) && $qres["code"] === "OK") {
                                        $valF[$key] = $qres["result"];
                                    } else {
                                        // On rejette l'enregistrement
                                        $correct = false;
                                        // Raison du rejet à ajouter dans le fichier rejet
                                        $msg = __("cle secondaire inexistante")." : ".$key." = ".$valF[$key]." / ";
                                        // Logger
                                        $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                                    }
                                } else {
                                    //
                                    $sql = $field["fkey"]["sql_exist"].$valF[$key];
                                    if (strrpos($field["fkey"]["sql_exist"], "'") === strlen($field["fkey"]["sql_exist"])-strlen("'")) {
                                        $sql .= "'";
                                    }
                                    $qres = $this->f->get_one_result_from_db_query(
                                        $sql,
                                        array(
                                            "origin" => __METHOD__,
                                            "force_return" => true,
                                        )
                                    );
                                    // Si le résultat de la requête ne renvoi aucune valeur ou
                                    // une erreur de base de données alors on rejette l'enregistrement
                                    if (is_null($qres["result"]) || $qres["code"] !== "OK") {
                                        // On rejette l'enregistrement
                                        $correct = false;
                                        // Raison du rejet à ajouter dans le fichier rejet
                                        $msg = __("cle secondaire inexistante")." : ".$key." = ".$valF[$key]." / ";
                                        // Logger
                                        $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                                    }
                                }
                            }
                        }
                    // OG
                    } elseif (isset($zone)) {
                        // On boucle sur chaque champ définit dans le fichier
                        // de configuration de l'import pour récupérer la
                        // valeur à importer dans la base pour ce champ
                        foreach (array_keys($zone) as $champ) {
                            // Logger
                            $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - champ '".$champ."'", EXTRA_VERBOSE_MODE);

                            // ----------------------------------------------------
                            // Gestion du critère DEFAUT
                            // ----------------------------------------------------
                            if ($zone[$champ] == "") { // valeur par defaut
                                //
                                $valF[$champ] = ""; // eviter le not null value
                                //
                                if (!isset($defaut[$champ])) {
                                    $defaut[$champ] = "";
                                }
                                $valF[$champ] = $defaut[$champ];
                            } else {
                                if (isset($contenu[$zone[$champ]])) {
                                    $valF[$champ] = $contenu[$zone[$champ]];
                                } else {
                                    // On rejette l'enregistrement
                                    $correct = false;
                                    // Raison du rejet à ajouter dans le fichier rejet
                                    $msg = __("nombre de colonnes incohérent")." : la colonne ".$champ." n'existe pas dans le fichier";
                                    // Logger
                                    $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                                }
                            }

                            // ----------------------------------------------------
                            // Gestion du critère OBLIGATOIRE
                            // ----------------------------------------------------
                            // Ce critère permet de vérifier, avant de faire une
                            // requête d'insertion, que la valeur fournie est
                            // correcte. Exemple du paramétrage de ce critère :
                            //   $obligatoire = array(
                            //     "champ1" => 1, // Ce champ est obligatoire
                            //     "champ2" => 0, // Ce champ n'est pas obligatoire
                            //   );
                            // Par défaut si le critère n'est pas paramétré, on
                            // considère que le champ n'est pas obligatoire.
                            // Comportement : si la valeur du champ en question
                            // dans le fichier CSV est vide ou null alors on
                            // rejette l'enregistrement.
                            // ----------------------------------------------------
                            if (isset($obligatoire[$champ])
                                && $obligatoire[$champ] == 1
                                && (empty($valF[$champ]) || is_null($valF[$champ]))) {
                                // On rejette l'enregistrement
                                $correct = false;
                                // Raison du rejet à ajouter dans le fichier rejet
                                $msg = __("champ obligatoire vide")." : ".$champ." = ".$valF[$champ];
                                // Logger
                                $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                            } elseif (!isset($obligatoire[$champ])) {
                                // Par défaut on indique que le champ n'est pas obligatoire
                                $obligatoire[$champ] = 0;
                            }

                            // ----------------------------------------------------
                            // Gestion du critère EXIST
                            // ----------------------------------------------------
                            // Ce critère permet de vérifier si la valeur fournie
                            // existe bien dans la table liée (clé étrangère).
                            // Exemple du paramétrage de ce critère :
                            //   $exist = array(
                            //     "champ1" => 1, // Ce champ est lié et doit exister
                            //     "champ2" => 0, // Ce champ n'est pas lié
                            //   );
                            // Par défaut si le critère n'est pas paramétré, on
                            // considère que le champ n'est pas lié.
                            // Comportement : si la valeur du champ en question
                            // dans le fichier CSV est vide alors on rejette
                            // l'enregistrement
                            // ----------------------------------------------------
                            if (isset($exist[$champ])
                                && $exist[$champ] == 1
                                && !empty($valF[$champ])) {
                                // Logger
                                $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - champ '".$champ."' - EXIST", EXTRA_VERBOSE_MODE);
                                //
                                $sql = $sql_exist[$champ].$valF[$champ];
                                if (strrpos($sql_exist[$champ], "'") === strlen($sql_exist[$champ])-strlen("'")) {
                                    $sql .= "'";
                                }
                                $qres = $this->f->get_one_result_from_db_query(
                                    $sql,
                                    array(
                                        "origin" => __METHOD__,
                                        "force_return" => true,
                                    )
                                );
                                // Si le résultat de la requête ne renvoi aucune valeur ou
                                // une erreur de base de données alors on rejette l'enregistrement
                                if (is_null($qres["result"]) || $qres["code"] !== "OK") {
                                    // On rejette l'enregistrement
                                    $correct = false;
                                    // Raison du rejet à ajouter dans le fichier rejet
                                    $msg = __("cle secondaire inexistante")." : ".$champ." = ".$valF[$champ];
                                    // Logger
                                    $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                                }
                            } elseif (!isset($exist[$champ])) {
                                // Par défaut on indique que le champ n'est pas lié
                                $exist[$champ] = 0;
                            }
                        }
                    }

                    if ($correct == true) {
                        $lines[$cpt['total']] = $valF;
                        $cpt["insert"]++;
                    }
                }
                // Si il y a une erreur sur la ligne alors on constitue un fichier
                // de rejet que l'utilisateur corrigera
                if ($correct == false || $firstline == true) {
                    // On recompose la ligne avec les separateurs
                    $ligne = "";
                    foreach ($fields as $key => $field) {
                        $key_num = array_search($key, array_keys($fields));
                        if (!isset($contenu[$key_num])) {
                            $ligne .= $separateur;
                        } elseif ($field["type"] == "string" or $field["type"] == "blob") {
                            $ligne .= '"'.$contenu[$key_num].'"'.$separateur;
                        } else {
                            $ligne .= $contenu[$key_num].$separateur;
                        }
                    }
                    // On ajoute une colonne erreur sur la premiere ligne
                    if ($firstline == true) {
                        $ligne .= "rejet";
                    } else {
                        $cpt["rejet"]++;
                        $ligne .= '"'.$msg.'"';
                    }
                    // Ajout du caractere de fin de ligne
                    $rejet .= $ligne."\n";
                } else {
                    // Cas de l'import spécifique des bibles, toutes les lignes même
                    // correctes doivent être récupérées dans le fichier de rejet
                    $ligne = "";
                    foreach ($fields as $key => $field) {
                        $key_num = array_search($key, array_keys($fields));
                        if (!isset($contenu[$key_num])) {
                            $ligne .= $separateur;
                        } elseif ($field["type"] == "string" or $field["type"] == "blob") {
                            $ligne .= '"'.$contenu[$key_num].'"'.$separateur;
                        } else {
                            $ligne .= $contenu[$key_num].$separateur;
                        }
                    }
                    $msg = __("Il n'y a pas d'erreur sur cette ligne");
                    $ligne .= '"'.$msg.'"';
                    $rejet .= $ligne."\n";
                }
            } else {
                $cpt["empty"]++;
            }
        }

        // Fermeture du fichier
        fclose($fichier);

        /**
         * Affichage du message de résultat de l'import
         */
        // Composition du message résultat
        $message = __("Resultat de l'import")."<br/>";
        $message .= $cpt["total"]." ".__("ligne(s) dans le fichier dont :")."<br/>";
        $message .= " - ".$cpt["firstline"]." ".__("ligne(s) d'entete")."<br/>";
        $message .= " - ".$cpt["insert"]." ".__("ligne(s) correcte(s)")."<br/>";
        $message .= " - ".$cpt["rejet"]." ".__("ligne(s) rejetee(s)")."<br/>";
        $message .= " - ".$cpt["empty"]." ".__("ligne(s) vide(s)")."<br/>";
        //
        if ($fic_rejet == 1 && $cpt["rejet"] != 0) {
            //
            $class = "error";
            // Composition du fichier de rejet
            $rejet = substr($rejet, 0, strlen($rejet) - 1);
            $metadata = array(
                "filename" => "import_".$obj."_".date("Ymd_Gis")."_rejet.csv",
                "size" => strlen($rejet),
                "mimetype" => "application/vnd.ms-excel",
            );
            $uid = $this->f->storage->create_temporary($rejet, $metadata);
            // Enclenchement de la tamporisation de sortie
            ob_start();
            //
            $this->f->layout->display_link(array(
                "href" => OM_ROUTE_FORM."&snippet=file&amp;uid=".$uid."&amp;mode=temporary",
                "title" => __("Télécharger le fichier CSV rejet"),
                "class" => "om-prev-icon reqmo-16",
                "target" => "_blank",
            ));
            // Affecte le contenu courant du tampon de sortie au message puis l'efface
            $message .= ob_get_clean();
        } else {
            //
            $class = "ok";
        }
        //
        $this->f->displayMessage($class, $message);

        // L'import ne s'applique que s'il n'y a aucun rejet
        if ($cpt["rejet"] === 0) {
            // Désactivation l'auto-commit
            $this->f->db->autoCommit(false);
            // Suppression de toutes les bibles existantes
            $query = sprintf('
                DELETE
                FROM %1$s%2$s
                ',
                DB_PREFIXE,
                $obj
            );
            $res = $this->f->db->query($query);
            $this->addToLog(__METHOD__."(): db->query(\"".$query."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true)) {
                $this->f->db->rollback();
                $error_msg = sprintf(
                    "%s %s",
                    __("La suppression de toutes les bibles a échouée."),
                    __("Veuillez contacter votre administrateur.")
                );
                $this->f->displayMessage('error', $error_msg);
                $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                return false;
            }

            // Ajout de toutes les lignes du fichier
            $error_add  = false;
            foreach ($lines as $key => $line) {
                $codes = explode("},", $line['codes']);
                foreach ($codes as $code) {
                    $error_check_ids  = false;
                    $code = str_replace(array("{", "}"), "", $code);
                    $ids = array_map('trim', explode(",", $code));
                    $bible = $this->f->get_inst__om_dbform(array(
                        "obj" => $obj,
                        "idx" => "]",
                    ));
                    // Valeurs de la bible
                    $valF = array();
                    foreach($bible->champs as $champ) {
                        $valF[$champ] = '';
                    }
                    $valF['libelle'] = $line['libelle'];
                    $valF['contenu'] = $line['contenu'];
                    $valF['evenement'] = $ids[0];
                    $valF['complement'] = $ids[1];
                    $valF['automatique'] = $ids[2];
                    $valF['dossier_autorisation_type'] = $ids[3];
                    $valF['om_collectivite'] = $ids[4];
                    $check_evenement = $this->check_id_exists('evenement', $valF['evenement']);
                    if ($check_evenement === false) {
                        $error_check_ids = true;
                        $error_msg = sprintf(__("L'événement dont l'identifiant est %s n'existe pas."), $valF['evenement']);
                        $this->f->displayMessage('error', $error_msg);
                        $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                    }
                    $check_dossier_autorisation_type = $this->check_id_exists('dossier_autorisation_type', $valF['dossier_autorisation_type']);
                    if ($check_dossier_autorisation_type === false) {
                        $error_check_ids = true;
                        $error_msg = sprintf(__("Le type de dossier d'autorisation dont l'identifiant est %s n'existe pas."), $valF['dossier_autorisation_type']);
                        $this->f->displayMessage('error', $error_msg);
                        $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                    }
                    $check_om_collectivite = $this->check_id_exists('om_collectivite', $valF['om_collectivite']);
                    if ($check_om_collectivite === false) {
                        $error_check_ids = true;
                        $error_msg = sprintf(__("La collectivité dont l'identifiant est %s n'existe pas."), $valF['om_collectivite']);
                        $this->f->displayMessage('error', $error_msg);
                        $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                    }
                    if ($error_check_ids === false) {
                        $ajouter = $bible->ajouter($valF);
                        if ($ajouter === false) {
                            $error_add = true;
                            $error_msg = sprintf(
                                "%s %s",
                                sprintf(__("Erreur lors de l'ajout de la bible dont les valeurs sont : %s."), print_r($valF, true)),
                                __("Veuillez contacter votre administrateur.")
                            );
                            $this->f->displayMessage('error', $error_msg);
                            $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                            if ($bible->msg !== null && $bible->msg !== '') {
                                $this->f->displayMessage('error', $bible->msg);
                            }
                        } else {
                            $valid_msg = sprintf(__("Ajout de la bible dont les valeurs sont %s."), print_r($valF, true));
                            $this->f->addToLog(__METHOD__."(): ".$valid_msg, VERBOSE_MODE);
                        }
                    }
                }
            }
            // On annule toute la transaction dès la première erreur d'ajout
            if ($error_add === true) {
                $this->f->db->rollback();
                return false;
            }

            // Vérification du verrou
            if ($verrou == 1) {
                // Commit de la transaction
                $this->f->db->commit();
            } else {
                $this->f->db->rollback();
                $error_msg = sprintf(
                    "%s %s",
                    __("Le traitement d'import ne possède pas la permission de mettre à jour la base de données."),
                    __("Veuillez contacter votre administrateur.")
                );
                $this->f->displayMessage('error', $error_msg);
                $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                return false;
            }
        }
    }

    /**
     * Réalise un import 'classique' mais avec une gestion de la validité
     * (champs 'validite_debut' et 'validite_fin').
     * La totalité des données doit être importée.
     * Le fichier de rejet contiendra également la totalité des données importées.
     *
     * @param [type] $obj [description]
     *
     * @return [type] [description]
     */
    private function treatment_import_with_validity($obj, $archiveAll = false) {

        // On vérifie que le formulaire a bien été validé
        if (!isset($_POST['submit-csv-import'])) {
            //
            return false;
        }

        // On récupère les paramètres du formulaire
        $separateur=$_POST['separateur'];

        // On vérifie que le fichier a bien été posté et qu'il n'est pas vide
        if (isset($_POST['fic1']) && $_POST['fic1'] == "") {
            //
            $class = "error";
            $message = __("Vous n'avez pas selectionne de fichier a importer.");
            $this->f->displayMessage($class, $message);
            //
            return false;
        }

        // On enlève le préfixe du fichier temporaire
        $fichier_tmp = str_replace("tmp|", "", $_POST['fic1']);
        // On récupère le chemin vers le fichier
        $path = $this->f->storage->storage->temporary_storage->getPath($fichier_tmp);
        // On vérifie que le fichier peut être récupéré
        if (!file_exists($path)) {
            //
            $class = "error";
            $message = __("Le fichier n'existe pas.");
            $this->f->displayMessage($class, $message);
            //
            return false;
        }

        // Configuration par défaut du fichier de paramétrage de l'import
        //
        $table = "";
        // Clé primaire numérique automatique. Si la table dans laquelle les
        // données vont être importées possède une clé primaire numérique
        // associée à une séquence automatique, il faut positionner le nom du
        // champ de la clé primaire dans la variable $id. Attention il se peut
        // que ce paramètre se chevauche avec le critère OBLIGATOIRE. Si ce
        // champ est défini dans $zone et qu'il est obligatoire et qu'il est
        // en $id, les valeurs du fichier CSV seront ignorées.
        $id = "";
        //
        $verrou = 1; // =0 pas de mise a jour de la base / =1 mise a jour
        //
        $fic_rejet = 1; // =0 pas de fichier pour relance / =1 fichier relance traitement
        //
        $ligne1 = 1; // = 1 : 1ere ligne contient nom des champs / o sinon
        //
        $encodages = array("UTF-8", "ASCII", "Windows-1252", "ISO-8859-15", "ISO-8859-1");

        // Récupération du fichier de paramétrage de l'import
        // XXX Faire un accesseur pour vérifier l'existence du fichier
        include $this->import_list[$obj]["path"];

        // On ouvre le fichier en lecture
        $fichier = fopen($path, "r");

        // Initialisation des variables
        $cpt = array(
            "total" => 0,
            "rejet" => 0,
            "insert" => 0,
            "firstline" => 0,
            "empty" => 0,
        );
        $rejet = "";

        // Boucle sur chaque ligne du fichier
        $lines = array();
        while (!feof($fichier)) {
            // Incrementation du compteur de lignes
            $cpt['total']++;
            // Logger
            $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total'], EXTRA_VERBOSE_MODE);
            // On définit si on se trouve sur la ligne titre
            $firstline = ($cpt['total'] == 1 && $ligne1 == 1 ? true : false);
            // On définit le marqueur correct à true
            $correct = true;
            //
            $valF = array();
            $msg = "";

            // Récupération de la ligne suivante dans le fichier
            $contenu = fgetcsv($fichier, 4096, $separateur);

            //
            $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - contenu = ".print_r($contenu, true), EXTRA_VERBOSE_MODE);
            // Si la ligne a plus d'un champ et que le premier champ n'est pas vide
            if (is_array($contenu) && count($contenu) > 1 && $contenu[0] != "") { // enregistrement vide (RC à la fin)
                //
                if ($firstline == true) {
                    //
                    $cpt['firstline']++;
                    // Logger
                    $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - firstline", EXTRA_VERBOSE_MODE);
                } else {
                    // NG
                    if (isset($fields)) {
                        // On boucle sur chaque champ défini dans le fichier
                        // de configuration de l'import pour récupérer la
                        // valeur à importer dans la base pour ce champ
                        foreach ($fields as $key => $field) {
                            //
                            $key_num = array_search($key, array_keys($fields));
                            //
                            if (!isset($contenu[$key_num])) {
                                $valF[$key] = -1;
                                // On rejette l'enregistrement
                                $correct = false;
                                // Raison du rejet à ajouter dans le fichier rejet
                                $msg = __("nombre de colonnes incohérent")." : la colonne ".$key_num." n'existe pas";
                                // Logger
                                $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                            } else {
                                // Suppression des espaces superflus
                                $valF[$key] = trim($contenu[$key_num]);
                                // Traitement de l'encodage
                                $valF[$key] = iconv(mb_detect_encoding($valF[$key], $encodages), "UTF-8", $valF[$key]);
                                // la chaine de texte 'null' représente la valeur null
                                if (strtolower($valF[$key]) === "null") {
                                    $valF[$key] = null;
                                }
                            }

                            // Logger
                            $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - champ '".$key."' = '".$valF[$key]."'", EXTRA_VERBOSE_MODE);

                            // ----------------------------------------------------
                            // Gestion des valeurs par défaut lors de la
                            // transmission d'une valeur vide ou nulle
                            // ----------------------------------------------------
                            // Si le paramétrage est défini correctement et que la
                            // valeur transmise est vide ou nulle
                            if (isset($field["type"]) && isset($field["notnull"])
                                && $valF[$key] !== '0'
                                && (empty($valF[$key]) || is_null($valF[$key]))) {
                                // Si une valeur par défaut est proposée dans la paramétrage
                                if (isset($field["default"])) {
                                    // On affecte la valeur par défaut
                                    $valF[$key] = $field["default"];
                                // Si le champ est de type entier et qu'il n'est pas
                                // obligatoire
                                } elseif ($field["type"] == "int"
                                          && $field["notnull"] == false) {
                                    // On affecte null afin de ne pas initialiser
                                    // un champs entier avec une chaine vide ce qui
                                    // provoquerait une erreur de base de données
                                    $valF[$key] = null;

                                // Si le champ est de type date et qu'il n'est pas
                                // obligatoire
                                } elseif ($field["type"] == "date"
                                          && $field["notnull"] == false) {
                                    // On affecte null afin de ne pas initialiser
                                    // un champs date avec une chaine vide ce qui
                                    // provoquerait une erreur de base de données
                                    $valF[$key] = null;

                                // Si le champ est de type booléen et qu'il n'est pas
                                // obligatoire
                                } elseif ($field["type"] == "bool"
                                          && $field["notnull"] == false) {
                                    // XXX Vérifier pourquoi la valeur null
                                    // provoque une erreur de base de données
                                    $valF[$key] = null;

                                // Si le champ est de type string et qu'il n'est pas
                                // obligatoire et que ce champ est une clé étrangère
                                } elseif ($field["type"] == "string"
                                          && $field["notnull"] == false
                                          && isset($field["fkey"])) {
                                    // On affecte null car une chaine vide serait
                                    // considérait comme une clé primaire de l'autre
                                    // table ce qui provoquerait une erreur de base
                                    //  de données
                                    $valF[$key] = null;

                                // Si le champ est de type geom et qu'il n'est pas
                                // obligatoire
                                } elseif ($field["type"] == "geom"
                                          && $field["notnull"] == false) {
                                    // On enlève le champ de l'enregistrement
                                    unset($valF[$key]);
                                }
                            }

                            // ----------------------------------------------------
                            // Vérification du caractère obligatoire d'un champ
                            // ----------------------------------------------------
                            if (isset($field["notnull"]) && $field["notnull"] == true
                                && (empty($valF[$key]) || is_null($valF[$key])) && $valF[$key] != '0') {
                                // On rejette l'enregistrement
                                $correct = false;
                                // Raison du rejet à ajouter dans le fichier rejet
                                $msg = __("champ obligatoire vide")." : ".$key." = ".$valF[$key];
                                // Logger
                                $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                            }

                            // ----------------------------------------------------
                            // Vérification de la taille des string
                            // ----------------------------------------------------
                            if (isset($field["type"]) && $field["type"] == "string"
                                && mb_strlen($valF[$key]) > $field["len"]) {
                                // On rejette l'enregistrement
                                $correct = false;
                                // Raison du rejet à ajouter dans le fichier rejet
                                $msg = __("valeur trop longue pour le champ")." : ".$key."(".$field["len"].") = ".$valF[$key]." (".mb_strlen($valF[$key]).")";
                                // Logger
                                $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                            }

                            // ----------------------------------------------------
                            // Gestion du critère EXIST
                            // ----------------------------------------------------
                            // Ce critère permet de vérifier si la valeur fournie
                            // existe bien dans la table liée (clé étrangère).
                            // Exemple du paramétrage de ce critère :
                            //   $exist = array(
                            //     "champ1" => 1, // Ce champ est lié et doit exister
                            //     "champ2" => 0, // Ce champ n'est pas lié
                            //   );
                            // Par défaut si le critère n'est pas paramétré, on
                            // considère que le champ n'est pas lié.
                            // Comportement : si la valeur du champ en question
                            // dans le fichier CSV est vide alors on rejette
                            // l'enregistrement
                            // ----------------------------------------------------
                            if (isset($field["fkey"]) && !empty($valF[$key])) {
                                // Logger
                                $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - champ '".$key."' - EXIST", EXTRA_VERBOSE_MODE);
                                // Si le champ recherché est sensé être de type entier et est n'est pas numeric
                                if (isset($field["type"]) && $field["type"] = "int"
                                    && !is_numeric($valF[$key])
                                    && isset($field["fkey"]["foreign_key_alias"])) {
                                    $sql = str_replace("<SEARCH>", $valF[$key], $field["fkey"]["foreign_key_alias"]["query"]);
                                    $qres = $this->f->get_one_result_from_db_query(
                                        $sql,
                                        array(
                                            "origin" => __METHOD__,
                                            "force_return" => true,
                                        )
                                    );
                                    if (!is_null($qres["result"]) && $qres["code"] === "OK") {
                                        $valF[$key] = $qres["result"];
                                    } else {
                                        // On rejette l'enregistrement
                                        $correct = false;
                                        // Raison du rejet à ajouter dans le fichier rejet
                                        $msg = __("cle secondaire inexistante")." : ".$key." = ".$valF[$key]." / ";
                                        // Logger
                                        $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                                    }
                                } else {
                                    //
                                    $sql = $field["fkey"]["sql_exist"].$valF[$key];
                                    if (strrpos($field["fkey"]["sql_exist"], "'") === strlen($field["fkey"]["sql_exist"])-strlen("'")) {
                                        $sql .= "'";
                                    }
                                    $qres = $this->f->get_one_result_from_db_query(
                                        $sql,
                                        array(
                                            "origin" => __METHOD__,
                                            "force_return" => true,
                                        )
                                    );
                                    // Si le résultat de la requête ne renvoi aucune valeur ou
                                    // une erreur de base de données alors on rejette l'enregistrement
                                    if (is_null($qres["result"]) || $qres["code"] !== "OK") {
                                        // On rejette l'enregistrement
                                        $correct = false;
                                        // Raison du rejet à ajouter dans le fichier rejet
                                        $msg = __("cle secondaire inexistante")." : ".$key." = ".$valF[$key]." / ";
                                        // Logger
                                        $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                                    }
                                }
                            }
                        }
                    // OG
                    } elseif (isset($zone)) {
                        // On boucle sur chaque champ définit dans le fichier
                        // de configuration de l'import pour récupérer la
                        // valeur à importer dans la base pour ce champ
                        foreach (array_keys($zone) as $champ) {
                            // Logger
                            $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - champ '".$champ."'", EXTRA_VERBOSE_MODE);

                            // ----------------------------------------------------
                            // Gestion du critère DEFAUT
                            // ----------------------------------------------------
                            if ($zone[$champ] == "") { // valeur par defaut
                                //
                                $valF[$champ] = ""; // eviter le not null value
                                //
                                if (!isset($defaut[$champ])) {
                                    $defaut[$champ] = "";
                                }
                                $valF[$champ] = $defaut[$champ];
                            } else {
                                if (isset($contenu[$zone[$champ]])) {
                                    $valF[$champ] = $contenu[$zone[$champ]];
                                } else {
                                    // On rejette l'enregistrement
                                    $correct = false;
                                    // Raison du rejet à ajouter dans le fichier rejet
                                    $msg = __("nombre de colonnes incohérent")." : la colonne ".$champ." n'existe pas dans le fichier";
                                    // Logger
                                    $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                                }
                            }

                            // ----------------------------------------------------
                            // Gestion du critère OBLIGATOIRE
                            // ----------------------------------------------------
                            // Ce critère permet de vérifier, avant de faire une
                            // requête d'insertion, que la valeur fournie est
                            // correcte. Exemple du paramétrage de ce critère :
                            //   $obligatoire = array(
                            //     "champ1" => 1, // Ce champ est obligatoire
                            //     "champ2" => 0, // Ce champ n'est pas obligatoire
                            //   );
                            // Par défaut si le critère n'est pas paramétré, on
                            // considère que le champ n'est pas obligatoire.
                            // Comportement : si la valeur du champ en question
                            // dans le fichier CSV est vide ou null alors on
                            // rejette l'enregistrement.
                            // ----------------------------------------------------
                            if (isset($obligatoire[$champ])
                                && $obligatoire[$champ] == 1
                                && (empty($valF[$champ]) || is_null($valF[$champ]))) {
                                // On rejette l'enregistrement
                                $correct = false;
                                // Raison du rejet à ajouter dans le fichier rejet
                                $msg = __("champ obligatoire vide")." : ".$champ." = ".$valF[$champ];
                                // Logger
                                $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                            } elseif (!isset($obligatoire[$champ])) {
                                // Par défaut on indique que le champ n'est pas obligatoire
                                $obligatoire[$champ] = 0;
                            }

                            // ----------------------------------------------------
                            // Gestion du critère EXIST
                            // ----------------------------------------------------
                            // Ce critère permet de vérifier si la valeur fournie
                            // existe bien dans la table liée (clé étrangère).
                            // Exemple du paramétrage de ce critère :
                            //   $exist = array(
                            //     "champ1" => 1, // Ce champ est lié et doit exister
                            //     "champ2" => 0, // Ce champ n'est pas lié
                            //   );
                            // Par défaut si le critère n'est pas paramétré, on
                            // considère que le champ n'est pas lié.
                            // Comportement : si la valeur du champ en question
                            // dans le fichier CSV est vide alors on rejette
                            // l'enregistrement
                            // ----------------------------------------------------
                            if (isset($exist[$champ])
                                && $exist[$champ] == 1
                                && !empty($valF[$champ])) {
                                // Logger
                                $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total']." - champ '".$champ."' - EXIST", EXTRA_VERBOSE_MODE);
                                //
                                $sql = $sql_exist[$champ].$valF[$champ];
                                if (strrpos($sql_exist[$champ], "'") === strlen($sql_exist[$champ])-strlen("'")) {
                                    $sql .= "'";
                                }
                                $qres = $this->f->get_one_result_from_db_query(
                                    $sql,
                                    array(
                                        "origin" => __METHOD__,
                                        "force_return" => true,
                                    )
                                );
                                // Si le résultat de la requête ne renvoi aucune valeur ou
                                // une erreur de base de données alors on rejette l'enregistrement
                                if (is_null($qres["result"]) || $qres["code"] !== "OK") {
                                    // On rejette l'enregistrement
                                    $correct = false;
                                    // Raison du rejet à ajouter dans le fichier rejet
                                    $msg = __("cle secondaire inexistante")." : ".$champ." = ".$valF[$champ];
                                    // Logger
                                    $this->f->addToLog(__METHOD__."(): REJET => ".$msg, EXTRA_VERBOSE_MODE);
                                }
                            } elseif (!isset($exist[$champ])) {
                                // Par défaut on indique que le champ n'est pas lié
                                $exist[$champ] = 0;
                            }
                        }
                    }

                    if ($correct == true) {
                        $lines[$cpt['total']] = $valF;
                    }
                }
                // Si il y a une erreur sur la ligne alors on constitue un fichier
                // de rejet que l'utilisateur corrigera
                if ($correct == false || $firstline == true) {
                    // On recompose la ligne avec les separateurs
                    $ligne = "";
                    foreach ($fields as $key => $field) {
                        $key_num = array_search($key, array_keys($fields));
                        if (!isset($contenu[$key_num])) {
                            $ligne .= $separateur;
                        } elseif ($field["type"] == "string" or $field["type"] == "blob") {
                            $ligne .= '"'.$contenu[$key_num].'"'.$separateur;
                        } else {
                            $ligne .= $contenu[$key_num].$separateur;
                        }
                    }
                    // On ajoute une colonne erreur sur la premiere ligne
                    if ($firstline == true) {
                        $ligne .= "rejet";
                    } else {
                        $cpt["rejet"]++;
                        $ligne .= '"'.$msg.'"';
                    }
                    // Ajout du caractere de fin de ligne
                    $rejet .= $ligne."\n";
                } else {
                    // Cas de cet import spécifique, toutes les lignes même
                    // correctes doivent être récupérées dans le fichier de rejet
                    $ligne = "";
                    foreach ($fields as $key => $field) {
                        $key_num = array_search($key, array_keys($fields));
                        if (!isset($contenu[$key_num])) {
                            $ligne .= $separateur;
                        } elseif ($field["type"] == "string" or $field["type"] == "blob") {
                            $ligne .= '"'.$contenu[$key_num].'"'.$separateur;
                        } else {
                            $ligne .= $contenu[$key_num].$separateur;
                        }
                    }
                    $msg = __("Il n'y a pas d'erreur sur cette ligne");
                    $ligne .= '"'.$msg.'"';
                    $rejet .= $ligne."\n";
                }
            } else {
                $cpt["empty"]++;
            }
        }

        // Fermeture du fichier
        fclose($fichier);

        // L'import ne s'applique que s'il n'y a aucun rejet
        if ($cpt["rejet"] === 0) {

            // Désactivation l'auto-commit
            $this->f->db->autoCommit(false);

            // Flag d'erreurs
            $error_archive = false;
            $error_add = false;

            // Date courante
            $cur_date = (new DateTime())->format('Y-m-d');

            // Listes des objets selon l'action requise
            $obj_to_archive = array();
            $obj_to_add = array();

            // change la casse des noms de colonnes de chaque ligne
            $linesLowerCase = array();
            foreach ($lines as $key => $line) {
                $linesLowerCase[$key] = array_change_key_case($line, CASE_LOWER);
            }
            $lines = $linesLowerCase;

            // archiver tout et ajouter tout
            if ($archiveAll !== false) {

                $archiveSQLPrepared = $this->f->db->prepare("
                    UPDATE
                        $table
                    SET
                        om_validite_fin = TO_DATE(?, 'YYYY-MM-DD')
                    WHERE
                        (om_validite_debut IS NULL OR om_validite_debut <= TO_DATE(?, 'YYYY-MM-DD'))
                        AND (om_validite_fin IS NULL OR om_validite_fin > TO_DATE(?, 'YYYY-MM-DD'))
                ");
                $res = $this->f->db->execute($archiveSQLPrepared, array(
                    $cur_date, $cur_date, $cur_date
                ));
                $this->addToLog(__METHOD__ . "(): db->execute(\"".$archiveSQLPrepared."\");", VERBOSE_MODE);
                if ($this->f->isDatabaseError($res, true)) {
                    $error_archive = true;
                    $error_msg = sprintf(
                        "%s %s",
                        __("L'archivage de tous.tes les ${obj}s a échoué."),
                        __("Veuillez contacter votre administrateur.")
                    );
                    $this->f->displayMessage('error', $error_msg);
                    $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                }
                else {
                    $obj_to_add = $lines;
                }
            }

            // archivage et ajout sélectifs
            else {

                // récupère la liste des objets existant valides
                $existingSQLPrepared = $this->f->db->prepare("
                    SELECT
                        *
                    FROM
                        $table
                    WHERE
                        (om_validite_debut IS NULL OR om_validite_debut <= TO_DATE(?, 'YYYY-MM-DD'))
                        AND (om_validite_fin IS NULL OR om_validite_fin > TO_DATE(?, 'YYYY-MM-DD'))"
                );
                $res = $this->f->db->execute($existingSQLPrepared, array($cur_date, $cur_date));
                $this->addToLog(__METHOD__ . "(): db->execute(\"".$existingSQLPrepared."\");", VERBOSE_MODE);
                if ($this->f->isDatabaseError($res, true)) {
                    $error_add = true;
                    $error_msg = sprintf(
                        __("Échec de la récupération des ${table}s existant(e)s valides (%s)."),
                        $res->getMessage()
                    );
                    $this->f->displayMessage('error', $error_msg);
                    $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                }
                else {

                    // liste des champs sans les champs liés à la date de validité ou d'identifiant
                    $fieldsNoValidityDatesOrId = array_filter(
                        array_keys($fields),
                        function($field) use($obj) {
                            return ! in_array($field, array(
                                $obj, 'om_validite_debut', 'om_validite_fin'));
                        }
                    );

                    // stockage des lignes qui correspondent à un objet existant valide
                    $linesKeysMatchingObject = array();

                    // pour chaque objet existant valide
                    while ($row = $res->fetchRow(DB_FETCHMODE_ASSOC)) {

                        // on le recherche dans/compare aux données importées
                        $objectMatch = false;
                        foreach ($lines as $key => $line) {
                            if (! in_array($key, $linesKeysMatchingObject)) {

                                // compare les valeurs importées VS existantes de chaque champ
                                $allFieldsMatch = true;
                                foreach($fieldsNoValidityDatesOrId as $field) {
                                    if (! isset($line[$field]) || $row[$field] != $line[$field]) {
                                        $allFieldsMatch = false;
                                        break;
                                    }
                                }

                                // tous les champs ont les mêmes valeurs que l'objet existant
                                if ($allFieldsMatch === true) {

                                    // objet marqué comme trouvé
                                    $objectMatch = true;
                                    $linesKeysMatchingObject[] = $key;
                                    break;
                                }
                            }
                        }

                        // si on ne l'a pas trouvé : on le sélectionne pour archivage
                        if ($objectMatch === false) {
                            $obj_to_archive[] = $row[$obj];
                        }
                    }

                    // procède à l'archivage
                    if (! empty($obj_to_archive)) {

                        $archiveSQLPrepared = $this->f->db->prepare("
                            UPDATE
                                $table
                            SET
                                om_validite_fin = TO_DATE(?, 'YYYY-MM-DD')
                            WHERE
                                $obj = ?
                        ");
                        $archiveData = array_map(
                            function($id) use($cur_date) { return array($cur_date, $id); },
                            $obj_to_archive
                        );
                        $res = $this->f->db->executeMultiple($archiveSQLPrepared, $archiveData);
                        $this->addToLog(__METHOD__ . "(): db->executeMultiple(\"".$archiveSQLPrepared."\");", VERBOSE_MODE);
                        if ($this->f->isDatabaseError($res, true)) {
                            $error_archive = true;
                            $error_msg = sprintf(
                                "%s %s",
                                __("L'archivage des ${obj}s sélectionné(e)s a échoué."),
                                __("Veuillez contacter votre administrateur.")
                            );
                            $this->f->displayMessage('error', $error_msg);
                            $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                        }
                    }

                    // pour chaque objet importé, si il ne correspond pas à
                    // un objet existant valide, on l'ajoute
                    if ($error_archive !== true) {
                        foreach($lines as $key => $line) {
                            if (! in_array($key, $linesKeysMatchingObject)) {
                                $obj_to_add[] = $line;
                            }
                        }
                    }
                }
            }

            // procède à l'ajout des nouvelles données
            if ($error_archive !== true && ! empty($obj_to_add)) {

                $addSQLPrepared = $this->f->db->prepare("
                    INSERT INTO $table
                        ($obj,".implode(',', array_keys($fields)).",om_validite_debut)
                    VALUES
                        (?,".implode(',', array_map(function() { return '?'; }, $fields)).",TO_DATE(?, 'YYYY-MM-DD'))
                ");

                foreach($obj_to_add as $line) {

                    // récupération du nouvel ID
                    $newId = null;
                    $res = $this->f->db->nextId($table);
                    $this->f->addToLog(__METHOD__."(): db->nextId(\"".$table."\");", VERBOSE_MODE);
                    if ($this->f->isDatabaseError($res, true)) {
                        $error_add = true;
                        $error_msg = sprintf(
                            "%s %s",
                            sprintf(
                                __("L'ID $obj n'a pas pu être déterminé (%s)."),
                                $res->getMessage()
                            ),
                            __("Veuillez contacter votre administrateur.")
                        );
                        $this->f->displayMessage('error', $error_msg);
                        $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                        break;
                    }
                    else {
                        $newId = $res;
                    }

                    // ajout de la donnée
                    $mapping = array($newId);
                    foreach(array_keys($fields) as $field) {
                        $mapping[] = isset($line[$field]) ? $line[$field] : null;
                    }
                    $mapping[] = $cur_date;
                    $res = $this->f->db->execute($addSQLPrepared, $mapping);
                    $this->addToLog(__METHOD__ . "(): db->execute(\"".$addSQLPrepared."\");", VERBOSE_MODE);
                    if ($this->f->isDatabaseError($res, true)) {
                        $error_add = true;
                        $error_msg = sprintf(
                            __("Échec de l'enregistrement $obj (%s)."),
                            $res->getMessage()
                        );
                        $this->f->displayMessage('error', $error_msg);
                        $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                        continue;
                    }

                    $cpt['insert']++;
                }
            }

            // On annule toute la transaction en cas d'erreur
            if ($error_add === true || $error_archive === true) {
                $this->f->db->rollback();
                $this->f->displayMessage('error', __("Import annulé"));
                $this->f->addToLog(__METHOD__."(): ".__("Import annulé"), DEBUG_MODE);
            }
            // Vérification du verrou
            elseif ($verrou == 1) {
                // commit de la transaction
                $this->f->db->commit();
            }
            else {
                // rollback de la transaction
                $this->f->db->rollback();
                $error_msg = sprintf(
                    "%s %s",
                    __("Le traitement d'import ne possède pas la permission de mettre à jour la base de données."),
                    __("Veuillez contacter votre administrateur.")
                );
                $this->f->displayMessage('error', $error_msg);
                $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
            }
        }

        /**
         * Affichage du message de résultat de l'import
         */
        // Composition du message résultat
        $message = __("Resultat de l'import")."<br/>";
        $message .= $cpt["total"]." ".__("ligne(s) dans le fichier dont :")."<br/>";
        $message .= " - ".$cpt["firstline"]." ".__("ligne(s) d'entete")."<br/>";
        $msg_insert_text = __("ligne(s) valide(s) non-enregistrée(s)");
        if (intval($cpt["rejet"]) == 0 && intval($cpt["insert"]) >= 0) {
            $msg_insert_text = __("ligne(s) insérée(s)");
        }
        $message .= " - ".$cpt["insert"]." $msg_insert_text<br/>";
        $message .= " - ".$cpt["rejet"]." ".__("ligne(s) rejetee(s)")."<br/>";
        $message .= " - ".$cpt["empty"]." ".__("ligne(s) vide(s)")."<br/>";
        $class = ($cpt["rejet"] != 0 || $error_add || $error_archive || ! $verrou) ? 'error' : 'ok';

        // Composition du fichier de rejet
        if ($fic_rejet == 1 && $cpt["rejet"] != 0) {
            $rejet = substr($rejet, 0, strlen($rejet) - 1);
            $metadata = array(
                "filename" => "import_".$obj."_".date("Ymd_Gis")."_rejet.csv",
                "size" => strlen($rejet),
                "mimetype" => "application/vnd.ms-excel",
            );
            $uid = $this->f->storage->create_temporary($rejet, $metadata);
            // Enclenchement de la tamporisation de sortie
            ob_start();
            //
            $this->f->layout->display_link(array(
                "href" => OM_ROUTE_FORM."&snippet=file&amp;uid=".$uid."&amp;mode=temporary",
                "title" => __("Télécharger le fichier CSV rejet"),
                "class" => "om-prev-icon reqmo-16",
                "target" => "_blank",
            ));
            // Affecte le contenu courant du tampon de sortie au message puis l'efface
            $message .= ob_get_clean();
        }

        // display summary message
        $this->f->displayMessage($class, $message);

        // return false if case of error
        if ($class == 'error') {
            return false;
        }
    }


    /**
     * Vérifie que l'enregistrement existe.
     *
     * @return mixed
     */
    function check_id_exists($table, $idx) {
        if ($table === null || $table === '') {
            return false;
        }
        if ($idx === null || $idx === '' || $idx === 'NULL') {
            return null;
        }
        $enr = $this->f->get_inst__om_dbform(array(
            "obj" => $table,
            "idx" => $idx,
        ));
        if ($enr->getVal($enr->clePrimaire) !== null && $enr->getVal($enr->clePrimaire) !== '') {
            return true;
        }
        return false;
    }

    /**
     * Initialisation du tableau comportant les valeurs recherchées dans les clés étrangères
     * Chargement du résultat en cache pour optimiser le traitement de chargement (charge tableau associatif)
     *
     * @return void
     */
    public function load_foreign_keys() {
        // parcours de tous les champs pour identifier et charger les caches
        foreach (array_keys($this->column) as $field_name) {
            // chargement de la définition de champ
            $field = $this->column[$field_name];
            // si le champ dispose d'une définition de clé étrangère on la charge en cache
            if (array_key_exists('foreign_key', $field)
                && array_key_exists('id', $field['foreign_key'])
                && array_key_exists('table', $field['foreign_key'])
                && array_key_exists('field', $field['foreign_key'])
            ) {
                $this->load_foreign_key(
                    $field_name,
                    $field['foreign_key']['id'],
                    $field['foreign_key']['table'],
                    $field['foreign_key']['field']
                );
            }
        }
    }

    /**
     * Récupération de la valeur d'une clé étrangère identifié par
     * le nom du champ de référence, le nom de la table a laquelle fait
     * référence la clé et le nom du champ dont on souhaite récupérer la
     * valeur.
     * Cette valeur est ensuite stockée en cache pour optimiser les temps
     * de chargement (charge tableau associatif : cache_foreign_key)
     *
     * @param string nom du champ dans le fichier csv
     * @param string nom du champ de réference de la clé étrangère
     * @param string nom de la table à laquelle fait reférence la clé étrangère
     * @param string nom du champ dont on récupère la valeur
     *
     * @return void
     */
    protected function load_foreign_key($field_name, $id, $table, $field) {
        // Chargement des valeurs depuis la base de données
        $sql = sprintf(
            'SELECT
                %1$s,
                %2$s
            FROM
                %3$s%4$s',
            $id,
            $field,
            DB_PREFIXE,
            $table
        );
        $list_valeurs = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        // Chargement des valeurs dans un tableau associatif
        $this->cache['foreign_key'][$field_name] = array();
        foreach ($list_valeurs['result'] as $value) {
            $this->cache['foreign_key'][$field_name][$value[$field]] = $value[$id];
        }
    }
    
    /**
     * Récupération par une requête sql de la liste des codes
     * des types de dossier d'autorisation et de l'identifiant
     * des types de dossier d'autorisation détaillé associé.
     *
     * Stockage de ces informations sous la forme d'un tableau
     * associatif dans l'attribut cache_da_datd.
     *
     * @return void
     */
    protected function load_prefix_da(){
        $this->cache['da_datd'] = array();
        $sql = sprintf(
            'SELECT
                DISTINCT dossier_autorisation_type.code as da,
                dossier_autorisation_type_detaille.dossier_autorisation_type_detaille as datd
            FROM
                %1$sdossier_autorisation_type_detaille
                JOIN %1$sdossier_autorisation_type 
                    ON dossier_autorisation_type_detaille.dossier_autorisation_type =
                        dossier_autorisation_type.dossier_autorisation_type 
            ORDER BY
                dossier_autorisation_type_detaille.dossier_autorisation_type_detaille',
            DB_PREFIXE
        );
        $list_da = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        foreach($list_da['result'] as $value){
            $this->cache['da_datd'][$value['datd']] = $value['da'];      
        }
    }

    /**
     * Récupération via une requête sql de la liste
     * des codes insees par collectivite.
     *
     * Stockage de cette liste sous la forme d'un tableau
     * associatif dans l'attribut "cache_om_collectivite_insee"
     *
     * @return void
     */
    protected function load_collectivite(){

        $sql = sprintf(
            'SELECT
                om_parametre.om_collectivite as om_collectivite,
                om_parametre.valeur as insee
            FROM
                %1$som_parametre 
                JOIN %1$som_collectivite 
                    ON om_parametre.om_collectivite = om_collectivite.om_collectivite 
            WHERE
                om_parametre.libelle = \'insee\'
                AND om_collectivite.niveau = \'1\'',
            DB_PREFIXE
        );

        $list_collectivite = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        foreach ($list_collectivite['result'] as $value) {
            $this->cache['om_collectivite_insee'][$value['insee']] = $value['om_collectivite'];
        }
    }

    // Chargement d'un tableau associatif pour récupérer le code postal en fonction du code collectivité
    /**
     * Récupération de la liste des codes postaux en fonction du code collectivité
     * via une requête sql.
     * Chargement d'un tableau associatif avec les résultats obtenus dans la propriété
     * cache.
     *
     * @return void
     */
    protected function load_cp(){
        $this->cache['cp_om_collectivite'] = array();
        $sql = "
        SELECT om_parametre.om_collectivite as om_collectivite,om_parametre.valeur as cp
        FROM ".DB_PREFIXE."om_parametre 
        JOIN ".DB_PREFIXE."om_collectivite 
        ON om_parametre.om_collectivite = om_collectivite.om_collectivite 
        WHERE om_parametre.libelle='cp' and om_collectivite.niveau = '1'";
        $list_cp = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        foreach($list_cp['result'] as $value){
            $this->cache['cp_om_collectivite'][$value['om_collectivite']] = $value['cp'];
        }
    }

    /**
     * Récupération de la liste de nom de commune par code collectivité
     * via une requête sql.
     * Chargement d'un tableau associatif avec les résultats obtenus dans la propriété
     * cache.
     *
     * @return void
     */
    protected function load_ville(){
        $this->cache['commune_om_collectivite'] = array();
        $sql = sprintf(
            'SELECT
                om_parametre.om_collectivite as om_collectivite,
                om_parametre.valeur as commune
            FROM
                %1$som_parametre 
                JOIN %1$som_collectivite 
                    ON om_parametre.om_collectivite = om_collectivite.om_collectivite 
            WHERE
                om_parametre.libelle = \'ville\'
                AND om_collectivite.niveau = \'1\'',
            DB_PREFIXE
        );
        $list_commune = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        foreach($list_commune['result'] as $value){
            $this->cache['commune_om_collectivite'][$value['om_collectivite']] = $value['commune'];
        }
    }

    /**
     * Récupération de la liste des cerfas par type de dossier d'autorisation détaillé
     * via une requête sql.
     * Chargement d'un tableau associatif avec les résultats obtenus dans la propriété
     * cache_cerfa_datd.
     *
     * @return void
     */
    protected function load_cerfa(){
        $this->cache['cerfa_datd'] = array();
        $sql = sprintf(
            'SELECT
                cerfa,
                dossier_autorisation_type_detaille
            FROM
                %1$sdossier_autorisation_type_detaille',
            DB_PREFIXE
        );
        
        $list_cerfa = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        // En cas d'erreur arrête le traitement et affiche l'erreur dans
        // le fichier de log
        $this->f->isDatabaseError($list_cerfa);
        // Stockage des résultats
        foreach ($list_cerfa['result'] as $value) {
            $this->cache['cerfa_datd'][$value['dossier_autorisation_type_detaille']] = $value['cerfa'];
        }
    }
    
    /**
     * Setter des attributs cache['di_type'] et cache['di_suffixe'].
     * Effectue une requête pour récupérer la liste des types
     * de dossier d'instruction (DI), des types détaillé de dossier d'autorisation (DA),
     * des codes et suffixe des types de DI.
     *
     * Remplis un tableau associatif cache['di_type'] de cette manière :
     *    - cache['di_type'][identifiant du type de DA détaillé][code] = identifiant du type de DI
     *
     * Remplis un tableau associatif cache['di_suffixe'] de cette manière :
     *    - cache['di_suffixe'][identifiant du type de DI] = suffixe du type de DI
     *
     * @return void
     */
    protected function load_dossier_instruction_type() {
        $sql = sprintf(
            'SELECT
                dossier_instruction_type,
                dossier_autorisation_type_detaille,
                code,
                suffixe
            FROM
                %1$sdossier_instruction_type',
            DB_PREFIXE
        );
        $dossier_instruction_type = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        // Stockage des résultats
        foreach ($dossier_instruction_type['result'] as $value) {
            $this->cache['di_type'][$value['dossier_autorisation_type_detaille']][$value['code']] = $value['dossier_instruction_type'];
            
            $this->cache['di_suffixe'][$value['dossier_instruction_type']] = $value['suffixe'];
        }
    }

    /**
     * Traitement d'import pour csv provenant d'ads2007
     *
     * @param string $obj Identifiant de l'import.
     *
     * @todo Modifier cette méthode pour la rendre générique et éventuellement
     *       utilisable depuis d'autres contextes que celui de la vue principale
     *       du module import.
     *
     * @return boolean false si erreur
     */
    function treatment_import_ads2007($obj) {
        
        // On vérifie que le formulaire a bien été validé
        if (!isset($_POST['submit-csv-import'])) {
            //
            return false;
        }

        // On récupère les paramètres du formulaire
        $separateur=$_POST['separateur'];

        // On vérifie que le fichier a bien été posté et qu'il n'est pas vide
        if (isset($_POST['fic1']) && $_POST['fic1'] == "") {
            //
            $class = "error";
            $message = _("Vous n'avez pas selectionne de fichier a importer.");
            $this->f->displayMessage($class, $message);
            //
            return false;
        }

        // On enlève le préfixe du fichier temporaire
        $fichier_tmp = str_replace("tmp|", "", $_POST['fic1']);
        // On récupère le chemin vers le fichier
        $path = $this->f->storage->storage->temporary_storage->getPath($fichier_tmp);
        // On vérifie que le fichier peut être récupéré
        if (!file_exists($path)) {
            //
            $class = "error";
            $message = _("Le fichier n'existe pas.");
            $this->f->displayMessage($class, $message);
            //
            return false;
        }

        // Configuration par défaut du fichier de paramétrage de l'import
        //
        $table = "";
        // Clé primaire numérique automatique. Si la table dans laquelle les
        // données vont être importées possède une clé primaire numérique 
        // associée à une séquence automatique, il faut positionner le nom du
        // champ de la clé primaire dans la variable $id. Attention il se peut 
        // que ce paramètre se chevauche avec le critère OBLIGATOIRE. Si ce
        // champ est défini dans $zone et qu'il est obligatoire et qu'il est
        // en $id, les valeurs du fichier CSV seront ignorées.
        $id = "";
        // 
        $verrou = 1; // =0 pas de mise a jour de la base / =1 mise a jour
        //
        $fic_rejet = 1; // =0 pas de fichier pour relance / =1 fichier relance traitement
        //
        $ligne1 = 1; // = 1 : 1ere ligne contient nom des champs / o sinon

        // Récupération du fichier de paramétrage de l'import
        // XXX Faire un accesseur pour vérifier l'existence du fichier
        include $this->import_list[$obj]["path"];

        $this->column = $fields;

        $header = array();
        foreach ($fields as $key => $value) {
            $header[] = $fields[$key]["header"];
        }

        // On ouvre le fichier en lecture
        $fichier = fopen($path, "r");

        // Initialisation des variables
        $cpt = array(
            "total" => 0,
            "rejet" => 0,
            "insert" => 0,
            "error" => 0,
            "firstline" => 0,
            "empty" => 0,
        );

        // Chargement du cache, qui récupère le préfixe_da en fonction du datd (dans un tableau associatif $this->cache['da_datd'] qui stock en index le datd et à pour valeur le da)
        $this->load_prefix_da();
        // Chargement du cache, qui récupère la collectivité en fonction de l'insee (dans un tableau associatif $this->cache['om_collectivite_insee'] qui stock en index le code insee et à pour valeur la collectivité)
        $this->load_collectivite();
        // Chargement du cache pour les codes CERFA en fonction du DATD
        $this->load_cerfa();
        // Chargement du cache pour toutes les clés étrangères
        $this->load_foreign_keys($fields);
        // Chargement du cache pour les type de DI et leur suffixe
        $this->load_dossier_instruction_type();
        // Chargement des codes postaux des communes depuis les paramètres
        $this->load_cp();
        // Chargement des noms de communes depuis les paramètres
        $this->load_ville();

        // Boucle sur chaque ligne du fichier
        while (!feof($fichier)) {
            // Incrementation du compteur de lignes
            $cpt['total']++;
            // Logger
            $this->f->addToLog(__METHOD__."(): LINE ".$cpt['total'], EXTRA_VERBOSE_MODE);
            // On définit si on se trouve sur la ligne titre
            $firstline = ($cpt['total'] == 1 && $ligne1 == 1 ? true : false);
            //
            $valF = array();
            $this->line_error = array();

            // Récupération de la ligne suivante dans le fichier
            $contenu = fgetcsv($fichier, 4096, $separateur);
            //
            $this->f->addToLog(
                __METHOD__."(): LINE ".$cpt['total']." - contenu = ".print_r($contenu, true),
                EXTRA_VERBOSE_MODE
            );
            // Si la ligne un champ ou moins et qu'il est vide on passe a la ligne
            // suivante 
            if ($contenu === false
                || (is_array($contenu) === true && count($contenu) == 1 && $contenu[0] == "")) { // enregistrement vide
                $cpt["empty"]++;
                continue;
            }

            // Suppression des espaces superflus
            $contenu = array_map("trim", $contenu);
            array_walk(
                $contenu,
                function (&$entry) {
                    $entry = iconv("ISO-8859-15", "UTF-8", $entry);
                }
            );
            // Suppression des colonnes de trop
            while(count($contenu) > 61) {
                unset($contenu[count($contenu)-1]);
            }

            // Si pas le bon nombre de colonnes on en ajoute pour ajouter le message
            // d'erreur
            if(count($contenu) != 61) {
                // Ajout des colonnes
                while(count($contenu) != 61) {
                    $contenu[] = "";
                }
                $contenu[] = _("Le format de la ligne n'est pas valide");
                $this->rejet[] = $contenu;
                $cpt["rejet"]++;
                continue;
            }

            // Si la première ligne est entête
            if ($contenu[0] === "Type") {
                //
                $cpt['firstline']++;
                // Logger
                $this->f->addToLog(
                    __METHOD__."(): LINE ".$cpt['total']." - firstline",
                    EXTRA_VERBOSE_MODE
                );
                continue;
            }

            $contenu = array_combine(array_keys($this->column), $contenu);

            // Définition de la variable de travail
            $this->line = $contenu;

            // Traitement des lignes du csv

            // Si une date de decision est définie sans nature de decision alors 
            // le dossier est implicitement accordé
            if(!empty($this->line["date_de_decision"]) and 
                empty($this->line["nature_decision"])) {

                $this->line["nature_decision"] = "Favorable";
            }
            // vérification de clôture du DI
            $this->is_cloture();

            // définision de l'avis en fonction des date saisie
            if (!$this->set_avis_decision_from_date()) {
                $this->line_error[] = _("L'avis de décision n'a pas été trouvé");
            }

            // reformatage du code INSEE
            if (!$this->format_code_insee()) {
                $this->line_error[] = _("Le code INSEE n'a pas été trouvé");
            }

            // Si l'on n'a pas d'état et que l'on a une décision, on met la décision dans l'état pour déduire l'état à partir de la décision
            if ($this->line["etat"] == '' && $this->line["nature_decision"] != '') {
                $this->line["etat"] = $this->line["nature_decision"];
            }

            // Pour chaque champs vérifications définie dans la conf
            foreach ( $this->line as $key => $value ) {

                $this->line[$key] = trim($this->line[$key]);
                // Vérification du format des valeurs selon leurs type
                if($this->check_type($key) === false) {
                    $this->line_error[] = sprintf(
                        _("La colonne %s ne correspond pas au format requis"),
                        $this->column[$key]["header"]
                    );
                }
                // Mise en correspondance des valeurs de la base
                $this->set_linked_value($key);
                // Vérification de l'existance des clés etrangères
                if($this->get_foreign_key_id($key) === false) {
                    $this->line_error[] = sprintf(
                        _("Aucune correspondance pour la colonne %s"),
                        $this->column[$key]["header"]
                    );
                }

                // Vérification des champs obligatoires
                if($this->check_required($key) === false) {
                    $this->line_error[] = sprintf(
                        _("La colonne %s est obligatoire"),
                        $this->column[$key]["header"]
                    );
                }

            }

            // Vérification des numéros de dossier et affectation dans les champs
            $this->explode_dossier();
            
            // vérification du numéro de DA
            $regex_da = "/^[0-9]{2}[0-9AB][0-9]{3}[0-9]{2}([A-Z]{1,2}|[0-9])[0-9]{4}$/i";
            if(! empty($this->line["initial"]) && ! preg_match($regex_da, $this->line["initial"], $matches)) {
                $this->f->addToLog(
                    __METHOD__."(): LINE  Failed to match regex on DA numero: '" . $this->line["initial"] . "'",
                    EXTRA_VERBOSE_MODE
                );
                $this->line_error[] = _("Numéro de dossier autorisation invalide");
            }

            // on continue seulement si les numéros de dossier sont valides
            if(empty($this->line_error)) {
                // Vérifie si le type de dossier existe
                $this->line["dossier_instruction_type"] =
                    $this->get_dossier_instruction_type($this->line["type"], $this->line["code"]);
                if ($this->line["dossier_instruction_type"] === null) {
                    $this->line_error[] = sprintf(
                        _("Aucun type de dossier d'instruction ne correspond (type = %s, code = %s)"),
                        $this->line["type"],
                        $this->line["code"]
                    );
                }

                // Définition de la collectivité du dossier si la collectivité n'est
                // pas défini les autres traitements ne sont pas effectué.
                if (! $this->set_collectivite()) {
                    $this->line_error[] = _("Le code INSEE de la commune n'est pas paramétré dans l'application");
                } else {
                    // Formatage (explode) de l'adresse du demandeur
                    if ($this->explode_address($this->line["adresse_demandeur"]) === false) {
                        $this->line_error[] =
                            _("Le format de l'adresse demandeur n'est pas correct");
                    } else {
                        $this->line["adresse_demandeur"] =
                        $this->explode_address($this->line["adresse_demandeur"]);
                    }
                    // Formatage (explode) de l'adresse du terrain
                    if ($this->explode_address($this->line["terrain"]) === false) {
                        $this->line_error[] =
                            _("Le format de la localisation du dossier n'est pas correct");
                    } else {
                        $this->line["terrain"] =
                        $this->explode_address($this->line["terrain"]);
                    }
                    // Formatage des références cadastrales
                    if ($this->parse_reference_cadastrale("references_cadastrales") === false) {
                        $this->line_error[] =
                            _("Le format des references cadastrale n'est pas correct");
                    }
                    // Définition du prefixe des numéro DI et DA
                    $this->set_prefix_di();
                }
            }

            if(!empty($this->line_error)) {
                $contenu[] = implode("\n", $this->line_error);
                $this->rejet[] = $contenu;
                $cpt["rejet"]++;
                continue;
            } else {
                $this->line['original_line'] = $contenu;
            }

            // Ajout de la ligne traitée au tableau final
            $this->dossier_autorisation[$this->line["initial"]][$this->line["version"]] = array(
                'data' => $this->line,
                'errors' => $this->line_error
            );
        }
    
        // Vérifie qu'il y a des dossier d'autorisation a traité ce qui n'est pas le cas si
        // toutes les lignes sont en erreurs
        if (is_array($this->dossier_autorisation) && $this->dossier_autorisation != array()) {

            // Vérification de l'intégrité de l'instruction
            foreach ($this->dossier_autorisation as $da_id => $list_di) {
                // récupère la liste des DI qui ne sont pas en erreur
                $list_of_valid_DI = array();
                foreach ($list_di as $version => $data_di) {

                    // pas d'erreur préalable
                    if (empty($data_di['errors'])) {

                        // ajout du DI à la liste des DI valides du DA
                        $list_of_valid_DI[$version] = $data_di['data'];
                    }
                }

                // si aucun DI est valide, on ne traite pas ce DA
                if (empty($list_of_valid_DI)) {
                    continue;
                }

                $this->f->db->autoCommit(false);
                $commit = true;

                if ($this->is_da_exist($da_id) != true) {
                    if ($this->add_dossier_autorisation($da_id, $list_of_valid_DI) != true) {
                        $cpt["error"]++;
                        $this->f->db->rollback();
                        continue;
                    }
                }

                // On boucle maintenant sur les DI valides du DA
                foreach ($list_of_valid_DI as $version => $data_di) {

                    // Récupération du statut de l'option suffixe pour ce type de DI
                    $suffixe = $this->get_dossier_instruction_type_suffixe($data_di["dossier_instruction_type"]);

                    // si le DI est un modificatif et que le DI initial n'est pas importé
                    if ($version !== 0 &&
                        (! isset($list_of_valid_DI[0]) || $list_of_valid_DI[0]['numero'] != $da_id)
                    ) {
                        $di_initial_type = $this->get_dossier_instruction_type($data_di["type"], 'P');
                        if ($di_initial_type === null) {
                            $cpt["rejet"]++;
                            $data_di['original_line'][] = sprintf(
                                _("Aucun type de dossier d'instruction ne correspond (type = %s, code = %s)"),
                                $data_di["type"],
                                'P'
                            );
                            $this->rejet[] = $data_di['original_line'];
                            $commit = false;
                            continue;
                        }
                        $di_initial_suffixe = $this->get_dossier_instruction_type_suffixe($di_initial_type);
                        $di_initial_num = $da_id.($di_initial_suffixe === 't' ? 'P0' : '');

                        // récupère le DI initial
                        $qres = $this->f->get_one_result_from_db_query(
                            sprintf(
                                'SELECT
                                    dossier
                                FROM
                                    %1$sdossier
                                WHERE
                                    dossier = \'%2$s\'',
                                DB_PREFIXE,
                                $this->f->db->escapeSimple($di_initial_num)
                            ),
                            array(
                                "origin" => __METHOD__,
                            )
                        );
                        // si le DI initial n'existe pas déjà en base
                        if (empty($qres["result"])) {

                            // on renvoi une erreur
                            $cpt["rejet"]++;
                            $data_di['original_line'][] = sprintf(
                                _("Aucun dossier d'instruction initial correspondant (initial = %s)"),
                                $di_initial_num
                            );
                            $this->rejet[] = $data_di['original_line'];
                            $commit = false;
                            continue;
                        }
                    }

                    // Si initial on récupère le numéro de dossier si il existe
                    $data_di["dossier_exist"] = $this->is_di_exist($data_di);

                    if ($this->add_dossier_instruction($data_di) === false) {
                        $cpt["error"]++;
                        $commit = false;
                        continue;
                    }

                    if ($this->add_donnees_techniques($data_di) === false) {
                        $cpt["error"]++;
                        $commit = false;
                        continue;
                    }

                    if ($data_di["dossier_exist"] == false) {
                        if ($this->add_demandeur($data_di) === false) {
                            $cpt["error"]++;
                            $commit = false;
                            continue;
                        }
                    }

                    $cpt["insert"]++;
                }

                if ($commit) {
                    $this->update_dossier_autorisation($da_id);
                    $this->f->db->commit(); // Validation des transactions
                } else {
                    $this->f->addToLog(__METHOD__."(): ROLLING BACK (DA: $da_id)", DEBUG_MODE);
                    $this->f->db->rollback();
                }
            }
        }
        

        // Fermeture du fichier
        fclose($fichier);

        /**
         * Affichage du message de résultat de l'import
         */
        // Composition du message résultat
        $message = _("Resultat de l'import")."<br/>";
        $message .= $cpt["total"]." "._("ligne(s) dans le fichier dont :")."<br/>";
        $message .= " - ".$cpt["firstline"]." "._("ligne(s) d'entete")."<br/>";
        $message .= " - ".$cpt["insert"]." "._("ligne(s) importee(s)")."<br/>";
        $message .= " - ".$cpt["error"]." "._("ligne(s) en erreur")."<br/>";
        $message .= " - ".$cpt["rejet"]." "._("ligne(s) rejetee(s)")."<br/>";
        $message .= " - ".$cpt["empty"]." "._("ligne(s) vide(s)")."<br/>";
        //
        if($cpt["error"] > 0 ) {
            //
            $class = "error";
            $message .= 
                _("Erreur de base de donnees. Contactez votre administrateur.")."<br/>";

        }
        if ($fic_rejet == 1 && $cpt["rejet"] != 0) {
            //
            $class = "error";
            $header[] = "Erreur (s)";
            $header = array_map(array($this, "encodeFunc"), $header);
            $rejet = implode(";", $header)."\n";
            // Composition du fichier de rejet
            foreach ($this->rejet as $line_rejet) {
                $line_rejet = array_map(array($this, "encodeFunc"), $line_rejet);
                $rejet .= implode(";", $line_rejet)."\n";
            }
            $rejet = iconv("UTF-8", "ISO-8859-15", $rejet);
            $metadata = array(
                "filename" => "import_".$obj."_".date("Ymd_Gis")."_rejet.csv",
                "size" => strlen($rejet),
                "mimetype" => "application/vnd.ms-excel",
            );
            $uid = $this->f->storage->create_temporary($rejet, $metadata);
            // Enclenchement de la tamporisation de sortie
            ob_start();
            //
            $this->f->layout->display_link(
                array(
                    "href" => "../app/index.php?module=form&snippet=file&uid=".$uid."&amp;mode=temporary",
                    "title" => _("Télécharger le fichier CSV rejet"),
                    "class" => "om-prev-icon reqmo-16",
                    "target" => "_blank",
                )
            );
            // Affecte le contenu courant du tampon de sortie au message puis l'efface
            $message .= ob_get_clean();
        } else {
            //
            $class = "ok";
        }
        //
        $this->f->displayMessage($class, $message);
    }

    /**
     * Formate le code insee fourni par l'export ads2007 afin de le mettre sur 5 caractères.
     * Renvoie true si le traitement a fonctionné et false si ce n'est pas le cas.
     *
     * @return boolean
     */
    function format_code_insee() {
        if(!isset($this->line["insee"]) or $this->line["insee"] == "") {
            return false;
        }
        $this->line["insee"] =
            str_pad(
                strval(
                    $this->line["insee"]
                ),
                5,
                '0',
                STR_PAD_LEFT
            );
        return true;
    }

    /**
     * Permet d'échapper des quote autour de chaque valeur.
     *
     * @param string $value chaine à enquoter
     *
     * @return string même chaîne avec quotes
     */
    function encodeFunc($value) {
        return "\"".$value."\"";
    }

    /**
     * [is_da_exist description]
     *
     * @param [type] $id [description]
     *
     * @return boolean [description]
     */
    function is_da_exist($id) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    count(*)
                FROM
                    %1$sdossier_autorisation
                WHERE
                    dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($id)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if ($qres["result"] != "0") {
            return true;
        }
        return false;
    }

    /**
     * Vérifie si le di existe en BDD, si il existe on retourne true sinon false.
     *
     * @param string $id identifiant du dossier
     *
     * @return boolean
     */
    function is_di_exist($data_di) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier
                FROM
                    %1$sdossier
                WHERE
                    dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($data_di["numero"])
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if ($qres["result"] != null) {
            return true;
        }
        return false;
    }

    /**
     * Vérifie le contenu en fonction du paramétrage
     *
     * @param integer $key clé de la colonne
     * 
     * @return string message d'erreur ou chaine vide
     */
    function check_required($key) {
        if($this->column[$key]["require"] === true and $this->line[$key] =="") {
            return false;
        }
        return true;
    }

    /**
     * Vérifie le contenu en fonction du paramétrage
     *
     * @param integer $key clé de la colonne
     *
     * @return string message d'erreur ou chaine vide
     */
    function check_type($key) {
        if ($this->line[$key] === "") {
            return true;
        }
        $regex = '';
        $type = $this->column[$key]["type"];
        switch ($type) {

            case 'integer':
                $this->line[$key] = str_replace(' ', '', $this->line[$key]);
                $regex = '/^\d*$/';
                break;
            case 'float':
                $this->line[$key] = str_replace(' ', '', $this->line[$key]);
                $regex = '/^(\d*[,|.])?\d*$/';
                break;
            case 'boolean':
                $regex = '/^(Oui|Non)$/i';
                break;
            case 'date':
                $regex = '/^\d{2}\/\d{2}\/\d{4}$/';
                // Vérifie que le format de la date est correct et le corrige si ce n'est
                // pas le cas et si la conversion est possible
                $this->line[$key] = $this->convert_date($this->line[$key]);
                break;
            default:
                $regex = '/^.*$/m';
                break;
        }
        if (preg_match($regex, $this->line[$key])) {
            return true;
        }
        return false;
    }

    /**
     * Récupère une date et la converti pour la mettre au format DD/MM/YYYY.
     * Si le format de la date est déjà correcte elle n'est pas converti.
     * Les dates pouvant être converties sont les dates au format suivant :
     *   * format français avec année sur 2 caractères : DD/MM/YY
     *   * format anglo-saxon : YYYY-MM-DD
     * 
     * @param string date a convertir
     * @return string date convertie
     */
    protected function convert_date($date) {
        $regex = '/^\d{2}\/\d{2}\/\d{4}$/';
        // Vérifie si la date est déjà au bon format : DD/MM/YYYY
        if (! preg_match($regex, $date, $results)) {
            // test du format français avec année sur 2 caractères
            if (preg_match('/^(\d{2}\/\d{2}\/)(\d{2})$/', $date, $results)) {
                // match : on complète l'année
                // TODO : voir comment améliorer la gestion des années 19xx et 20xx
                if (strval($results[0]) > 40) {
                    return $results[1].'19'.$results[2];
                }
                return $results[1].'20'.$results[2];
            }

            // test du format anglo-saxon
            if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $date, $results)) {
                // match : on convertit au format français
                return $results[3].'/'.$results[2].'/'.$results[1];
            }
        }
        return $date;
    }

    /**
     * Vérifie si une date de clôture ou une decision est présente.
     */
    function is_cloture() {
        if( 
            empty($this->line["date_accord_tacite"]) and
            empty($this->line["date_de_rejet_tacite"]) and
            empty($this->line["date_de_refus_tacite"]) and
            (empty($this->line["date_de_decision"]) or
            empty($this->line["nature_decision"]))
            ) {

            $this->line_error[] = _("Ce dossier n'est pas cloture");
        }
    }

    /**
     * Positionne l'avis en fonction des dates de décision.
     */
    function set_avis_decision_from_date() {
        if(!isset($this->line["date_accord_tacite"]) or 
            !isset($this->line["date_de_rejet_tacite"]) or
            !isset($this->line["date_de_refus_tacite"])) {
            return false;
        }
        $this->line["date_accord_tacite"] = trim($this->line["date_accord_tacite"]);
        $this->line["date_de_rejet_tacite"] = trim($this->line["date_de_rejet_tacite"]);
        $this->line["date_de_refus_tacite"] = trim($this->line["date_de_refus_tacite"]);

        if(!empty($this->line["date_accord_tacite"])) {
            $this->line["nature_decision"] = "Accord Tacite";
            $this->line["date_de_decision"] = $this->line["date_accord_tacite"];
        }
        if(!empty($this->line["date_de_rejet_tacite"])) {
            $this->line["nature_decision"] = "Rejet tacite";
            $this->line["date_de_decision"] = $this->line["date_de_rejet_tacite"];
        }
        if(!empty($this->line["date_de_refus_tacite"])) {
            $this->line["nature_decision"] = "Refus tacite";
            $this->line["date_de_decision"] = $this->line["date_de_refus_tacite"];
        }
        return true;
    }

    /**
     * Récupération des clés étrangères.
     *
     * @param integer $key clé de la colonne
     *
     * @return string message d'erreur ou chaine vide
     */
    function get_foreign_key_id($key) {
        // si pas de foreign_key déclarée, pas de problème
        if(!isset($this->cache['foreign_key'][$key])) {
            return true;
        }
        // recherche de la valeur
        if(array_key_exists($this->line[$key], $this->cache['foreign_key'][$key])){
            // on remplace la valeur d'origine par la clé trouvée
            $this->line[$key] = $this->cache['foreign_key'][$key][$this->line[$key]];
            return true;
        }
        // clé inexistante
        return false;
    }

    /**
     * Méthode de substition de valeurs du csv avec du paramétrage de la base.
     *
     * @param integer $key clé de la colonne
     */
    function set_linked_value($key) {
        if(isset($this->column[$key]["link"]) and
            $this->line[$key] != "" and
            array_key_exists($this->line[$key], $this->column[$key]["link"])) {

            $this->line[$key] = $this->column[$key]["link"][$this->line[$key]];
        }
    }


    /**
     * Formate les references cadastrale.
     *
     * @param string $key clé de la colonne
     *
     * @return string vide
     */
    function parse_reference_cadastrale($key) {
        if($this->line[$key] == "") {
            return true;
        }
        $regex = "/^(\d{0,3})?-?(\D{1,2})-(\d{0,4})\w?$/i";
        
        // Les ref sont séparées par une virgule
        $reference = explode(',', $this->line[$key]);
        $ref_format = array();

        foreach ($reference as $value) {
            if(trim($value) == "") {
                continue;
            }
            $array_ref = array();

            // Pour chaque ref on vérifie le format
            if(!preg_match($regex, trim($value), $array_ref)) {
                
                return false;
            }
            // Et on les formate pour openads
            $ref_format[] = sprintf(
                "%s%s%s",
                str_pad($array_ref[1], 3, "0", STR_PAD_LEFT),
                $array_ref[2],
                str_pad($array_ref[3], 4, "0", STR_PAD_LEFT)
                );
        }
        $this->line[$key] = implode(";", $ref_format);
        if (substr($this->line[$key], -1, 1) != ';') $this->line[$key] .= ';';
        return true;
    }

    /**
     * Décompose une adresse postale complète en éléments distincts
     *
     * @param string $adresse_complete Adresse complète
     * 
     * @return array Adresse triée
     */
    function explode_address($adresse_complete) { 
        /**
         * Le script procède comme suit :
         *
         * - on supprime le pays
         * - Ã  chaque extraction on supprime les espaces en début et fin de chaîne
         * - on récupère le numéro puis la ville puis le code postal
         * - on récupère la voie qui, si trop longue, est scindée en complément(s)
         */
        // Préparation du tableau de retour
        $adresse_triee = array(
            "numero" => "",
            "voie" => "",
            "complement1" => "",
            "complement2" => "",
            "cp" => "",
            "ville" => "",
        );
        // décomposition de l'adresse sur le modèle 'adresse cp ville'
        // sinon on lui ajoute les cp et ville de la commune du dossier
        $matches = array();
        if (preg_match('/(^.*)([\d]{5})(.*)$/i', $adresse_complete, $matches)) {
            $adresse = trim($matches[1]);
            $cp = trim($matches[2]);
            $ville = trim($matches[3]);
        } else {
            $adresse = $adresse_complete;
            $cp = $this->get_cp($this->line["om_collectivite"]);
            $ville = $this->get_ville($this->line["om_collectivite"]);
        }
        // récupération du cp
        $adresse_triee['cp'] = $cp;
        // Suppression du pays et récupération de la ville
        $adresse_triee['ville'] = trim(preg_replace('/france/i', '', $ville));
        // décomposition de l'adresse pour isoler le numéro sous la forme numéro et rue :
        // 1 - 2 rue des tests -> on devrait obtenir comme numéro 1 - 2 et comme adresse rue des tests
        // 1-2 rue des tests -> on devrait obtenir comme numéro 1-2 et comme adresse rue des tests
        // 1bis rue des tests -> numero : 1 bis et adresse : idem précédent
        // 1b rue des tests -> numero : 1b et adresse : idem précédent
        // 1B rue des tests -> numero : 1B et adresse : idem précédent
        // 1, rue des tests -> numéro : 1 et adresse : idem précédent
        $numero = '';
        $voie = '';
        if (preg_match('/^(\d+\s*(-\s*\d+\s*|bis|[bB]|)?,?)?(.*)$/i', $adresse, $matches)) {
            $numero = $matches[1];
            // $matches[2] renvoie le reste composant le numéro
            // ex : 1B -> $matches[2] = B et $matches[1] = 1B
            $voie = trim($matches[3]);
            // Suppression des espaces superflus
            $numero = str_replace(' ', '', $numero);
            // Suppression de la virgule qui suit le numéro
            $numero = preg_replace('/,$/', '', $numero);
        } else {
            $voie = $adresse;
        }
        $adresse_triee['numero'] = $numero;
        // Récupération de la voie en la divisant en deux voire trois parties
        // si la chaîne de caractères est trop longue.
        // Cela ne fractionne pas les mots.
        $max_size = 30; // longueur maximum de la chaîne
        if (strlen($voie) > $max_size ) {
            $decoupe = explode(
                '\n',
                wordwrap($voie, $max_size , '\n')
            );
            // Première partie : la voie
            $adresse_triee['voie'] = $decoupe[0];
            // Deuxième partie : le complément
            $adresse_triee['complement1'] = $decoupe[1];
            // Eventuel second complément
            if (isset($decoupe[2])) {
                $adresse_triee['complement2'] = $decoupe[2];
            }
        } else {
            $adresse_triee['voie'] = $voie;
        }

        foreach ($adresse_triee as $value) {
            if(strlen($value) > $max_size) {
                return false;
            }
        }

        // Renvoi du tableau
        return $adresse_triee;
    }

    /**
     * Permet de définir la collectivité de niveau 1 du dossier en fonction de son code INSEE
     *
     * @return boolean
     */
    function set_collectivite() {

        if(array_key_exists($this->line['insee'], $this->cache['om_collectivite_insee'])){
            $om_collectivite = $this->cache['om_collectivite_insee'][$this->line["insee"]];
            $this->line["om_collectivite"] = intval($om_collectivite);
            return true;
        }
        return false;
    }

    /**
     * Recupère le prefix du DI et DA en fonction du DATD
     */
    function set_prefix_di() {
        if(!is_numeric($this->line["type"])) {
            $this->line_error[] = _("Le type de dossier est inconnu");
            return false;
        }

        if(! isset($this->cache['da_datd'][$this->line["type"]])){
            $this->line_error[] = _("Le type d'autorisation détaillé n'a pas été trouvé");
            return false;
        }

        $prefix = $this->cache['da_datd'][$this->line["type"]];
        $this->line["initial"] = $prefix.$this->line["initial"];
        $this->line["lib_da"] = $prefix.$this->line["lib_da"];
        $this->line["numero"] = $prefix.$this->line["numero"];
        $this->line["lib_di"] = $prefix.$this->line["lib_di"];
    }


    /**
     * Ajout des DA.
     *
     * @param array $di_data données du DA
     */
    function add_dossier_autorisation($da_id, $list_di) {

        $da_valF["dossier_autorisation"] = $da_id;
        $da_valF["exercice"] = substr($list_di[min(array_keys($list_di))]["depot_en_mairie"], -2);
        $da_valF["insee"] = $list_di[min(array_keys($list_di))]["insee"];
        $da_valF["terrain_references_cadastrales"] = $list_di[min(array_keys($list_di))]["references_cadastrales"];
        $da_valF["terrain_adresse_voie_numero"] = $list_di[min(array_keys($list_di))]["terrain"]["numero"];
        $da_valF["terrain_adresse_voie"] = $list_di[min(array_keys($list_di))]["terrain"]["voie"];
        $da_valF["terrain_adresse_lieu_dit"] = $list_di[min(array_keys($list_di))]["terrain"]["complement1"];
        $da_valF["terrain_adresse_localite"] = $list_di[min(array_keys($list_di))]["terrain"]["ville"];
        $da_valF["terrain_adresse_code_postal"] = $list_di[min(array_keys($list_di))]["terrain"]["cp"];
        $surf = $this->get_surface($list_di[min(array_keys($list_di))]["surface_terrain"]);
        $da_valF["terrain_superficie"] = (($surf===0)? null : $surf);
        $da_valF["depot_initial"] = $list_di[min(array_keys($list_di))]["depot_en_mairie"];
        $da_valF["om_collectivite"] = $list_di[min(array_keys($list_di))]["om_collectivite"];
        $da_valF["dossier_autorisation_type_detaille"] = $list_di[min(array_keys($list_di))]["type"];
        $da_valF["dossier_autorisation_libelle"] = $list_di[min(array_keys($list_di))]["lib_da"];

        // Execution de la requete d'insertion des donnees de l'attribut
        // valF de l'objet dans l'attribut table de l'objet
        $res = $this->f->db->autoExecute(DB_PREFIXE."dossier_autorisation", $da_valF, DB_AUTOQUERY_INSERT);
        // Si une erreur survient
        if ($this->f->isDatabaseError($res, true)) {
            return false;
        }
        return true;
    }

    /**
     * Ajout des DI.
     *
     * @param array $di_data données du DI
     */
    function add_dossier_instruction($di_data) {

        $di_valF["dossier"] = $di_data["numero"];
        $di_valF["dossier_libelle"] = $di_data["lib_di"];
        $di_valF["etat"] = $di_data["etat"];

        $di_valF["date_demande"] = $this->prepare_date($di_data["depot_en_mairie"]);
        $di_valF["date_depot"] = $this->prepare_date($di_data["depot_en_mairie"]);
        $di_valF["date_dernier_depot"] = $this->prepare_date($di_data["depot_en_mairie"]);
        $di_valF["date_complet"] = $this->prepare_date($di_data["completude"]);
        $di_valF["date_notification_delai"] = $this->prepare_date($di_data["notification_majoration"]);
        $di_valF["date_limite"] = $this->prepare_date($di_data["dli"]);
        $di_valF["date_decision"] = $this->prepare_date($di_data["date_de_decision"]);
        $di_valF["date_chantier"] = $this->prepare_date($di_data["doc"]);
        $di_valF["date_achevement"] = $this->prepare_date($di_data["daact"]);
        $di_valF["avis_decision"] = $this->prepare_date($di_data["nature_decision"]);

        $di_valF["autorite_competente"] = $di_data["autorite"];

        $di_valF["terrain_references_cadastrales"] = $di_data["references_cadastrales"];
        $di_valF["terrain_adresse_voie_numero"] = $di_data["terrain"]["numero"];
        $di_valF["terrain_adresse_voie"] = $di_data["terrain"]["voie"];
        $di_valF["terrain_adresse_lieu_dit"] = $di_data["terrain"]["complement1"];
        $di_valF["terrain_adresse_localite"] = $di_data["terrain"]["ville"];
        $di_valF["terrain_adresse_code_postal"] = $di_data["terrain"]["cp"];
        $surf = $this->get_surface($di_data["surface_terrain"]);
        $di_valF["terrain_superficie"] = (($surf===0)? null : $surf);

        $di_valF["dossier_autorisation"] = $di_data["initial"];
        $di_valF["dossier_instruction_type"] = $di_data["dossier_instruction_type"];

        $di_valF["version"] = $di_data["version"];

        $di_valF["om_collectivite"] = $di_data["om_collectivite"];

        $di_valF['annee'] = substr($di_data["depot_en_mairie"], -2);
        
        $di_valF["etat_transmission_platau"] = "jamais_transmissible";

        // Si le dossier existe on le met à jour
        if($di_data["dossier_exist"] == true) {
            $mode = DB_AUTOQUERY_UPDATE;
        } else {
            $mode = DB_AUTOQUERY_INSERT;
        }

        // Execution de la requete d'insertion des donnees de l'attribut
        // valF de l'objet dans l'attribut table de l'objet
        $res = $this->f->db->autoExecute(
            DB_PREFIXE."dossier",
            $di_valF,
            $mode,
            "dossier='".$di_data["numero"]."'");
        // Si une erreur survient
        if ($this->f->isDatabaseError($res, true)) {
            return false;
        }

        // Si le champ des références cadastrales n'est pas vide
        if ($di_valF['terrain_references_cadastrales'] != '') {
            // Si le dossier existe, les references cadastrales peuvent êtres
            // mise à jour on les supprimes donc pour insérer des parcelles à jour
            $sql = "delete from ".DB_PREFIXE."dossier_parcelle where dossier='".$di_data["numero"]."'";
            // Execution de la requete de suppression de l'objet
            $res = $this->f->db->query($sql);
            // Si une erreur survient
            if ($this->f->isDatabaseError($res, true)) {
                return false;
            }
            // Parse les parcelles
            $list_parcelles = $this->f->parseParcelles($di_valF['terrain_references_cadastrales']);
            // A chaque parcelle une nouvelle ligne est créée dans la table
            // dossier_parcelle
            foreach ($list_parcelles as $parcelle) {

                // Instance de la classe dossier_parcelle
                $dossier_parcelle = $this->f->get_inst__om_dbform(array(
                    "obj" => "dossier_parcelle",
                    "idx" => "]",
                ));

                // Valeurs à sauvegarder
                $value = array(
                    'dossier_parcelle' => '',
                    'dossier' => $di_valF['dossier'],
                    'parcelle' => '',
                    'libelle' => $parcelle['quartier']
                                    .$parcelle['section']
                                    .$parcelle['parcelle']
                );

                // Ajout de la ligne
                $dossier_parcelle->ajouter($value);
            }

        }

        return true;
    }

    /**
     * Mise en forme des dates.
     *
     * @param date $date format DD/MM/YYYY
     *
     * @return date format DD/MM/YYYY null si chaine vide
     */
    function prepare_date($date) {
        if($date == '') {
            return null;
        }
        return $date;
    }

    /**
     * Ajout des données techniques.
     *
     * @param array $di_data données du DI
     */
    function add_donnees_techniques($di_data) {

        $cerfa = $this->get_cerfa($di_data["type"]);

        $val_dt["donnees_techniques"] = $this->f->db->nextId(DB_PREFIXE.'donnees_techniques');
        $val_dt["cerfa"] = $cerfa;
        $val_dt["dossier_instruction"] = $di_data["numero"];
        $val_dt["am_projet_desc"] = "";
        $val_dt["co_projet_desc"] = "";
        $val_dt["dm_projet_desc"] = "";
        // PI et PC
        if($di_data['type'] == 1 or $di_data['type'] == 2) {
            $val_dt["co_projet_desc"] = $di_data["projet"];
        }
        // PA
        elseif ($di_data['type'] == 4) {
            $val_dt["am_projet_desc"] = $di_data["projet"];
        }
        // PD
        elseif ($di_data['type'] == 3) {
            $val_dt["dm_projet_desc"] = $di_data["projet"];
        }
        // DP
        elseif ($di_data['type'] == 5 || $di_data['type'] == 370 || $di_data['type'] == 420 || $di_data['type'] == 421 || $di_data['type'] == 422) {
            $val_dt["co_projet_desc"] = $di_data["projet"];
        }
        // CUa et CUb
        else {
            $val_dt["ope_proj_desc"] = $di_data["projet"];
        }

        $val_dt["co_tot_log_nb"] = intval($di_data["nb_logements"]);

        $val_dt["am_terr_surf"] = $this->get_surface($di_data["surface_terrain"]);

        $val_dt["am_lotiss"] = $this->get_boolean($di_data["lotissement"]);
        $val_dt["terr_juri_afu"] = $this->get_boolean($di_data["afu"]);

        $val_dt["code_cnil"] = $this->get_boolean($di_data["opposition_cnil"]);

        // Définition des surfaces selon destination
        $destination = explode(',', $di_data["destination"]);
        switch (trim($destination[0])) {
            case 'Habitation':
                $i = 1;
                break;
            case 'Hébergement hôtelier':
                $i = 2;
                break;
            case 'Bureaux':
                $i = 3;
                break;
            case 'Commerce':
                $i = 4;
                break;
            case 'Artisanat':
                $i = 5;
                break;
            case 'Industrie':
                $i = 6;
                break;
            case 'Exploit. agricole ou forestière':
                $i = 7;
                break;
            case 'Entrepôt':
                $i = 8;
                break;
            case 'Service public ou d\'intérêt général':
                $i = 9;
                break;

            default:
                $i = 1;
                break;
        }
        // Tableau des surfaces
        $val_dt["su_avt_shon".$i] = $this->get_surface($di_data["shon_existante"]);
        $val_dt["su_cstr_shon".$i] = $this->get_surface($di_data["shon_construite"]);
        $val_dt["su_trsf_shon".$i] = $this->get_surface($di_data["shon_transformation_shob"]);
        $val_dt["su_chge_shon".$i] = $this->get_surface($di_data["shon_changement_destination"]);
        $val_dt["su_demo_shon".$i] = $this->get_surface($di_data["shon_demolie"]);
        $val_dt["su_sup_shon".$i] = $this->get_surface($di_data["shon_supprimee"]);

        // dates DOC/DAACT
        $val_dt["doc_date"] = $this->prepare_date($di_data["doc"]);
        $val_dt["daact_date"] = $this->prepare_date($di_data["daact"]);

        // Si les données techniques existe on les met à jour
        if($di_data["dossier_exist"] == true) {
            $mode = DB_AUTOQUERY_UPDATE;
        } else {
            $mode = DB_AUTOQUERY_INSERT;
        }
        // Execution de la requete d'insertion des donnees de l'attribut
        // valF de l'objet dans l'attribut table de l'objet
        $res = $this->f->db->autoExecute(
            DB_PREFIXE."donnees_techniques",
            $val_dt,
            $mode,
            "dossier_instruction='".$di_data["numero"]."'");

        // On retourne l'inverse du resultat d'erreur
        return !$this->f->isDatabaseError($res, true);

    }

    /**
     * Ajout d'un demandeur.
     *
     * @param array $di_data liste des données du DI
     */
    function add_demandeur($di_data) {

        $val_demandeur["demandeur"] = $this->f->db->nextId(DB_PREFIXE.'demandeur');
        $val_demandeur["type_demandeur"] = 'petitionnaire';
        $val_demandeur["qualite"] = 'particulier';
        $val_demandeur["particulier_nom"] = $di_data["demandeur"];
        $val_demandeur["numero"] = $di_data["adresse_demandeur"]["numero"];
        $val_demandeur["voie"] = $di_data["adresse_demandeur"]["voie"];
        $val_demandeur["complement"] = $di_data["adresse_demandeur"]["complement1"];
        $val_demandeur["lieu_dit"] = $di_data["adresse_demandeur"]["complement2"];
        $val_demandeur["code_postal"] = $di_data["adresse_demandeur"]["cp"];
        $val_demandeur["localite"] = $di_data["adresse_demandeur"]["ville"];
        $val_demandeur["om_collectivite"] = $di_data["om_collectivite"];

        // Execution de la requete d'insertion des donnees de l'attribut
        // valF de l'objet dans l'attribut table de l'objet
        $res = $this->f->db->autoExecute(
            DB_PREFIXE."demandeur",
            $val_demandeur,
            DB_AUTOQUERY_INSERT
        );

        if($this->f->isDatabaseError($res, true)) {
            return false;
        }

        $val_lien_dossier_demandeur = array(
            'lien_dossier_demandeur' => $this->f->db->nextId(DB_PREFIXE.'lien_dossier_demandeur'),
            'petitionnaire_principal' => "t",
            'dossier' => $di_data["numero"],
            'demandeur' => $val_demandeur["demandeur"]
        );
        // Execution de la requete d'insertion des donnees de l'attribut
        // valF de l'objet dans l'attribut table de l'objet
        $res = $this->f->db->autoExecute(
            DB_PREFIXE."lien_dossier_demandeur",
            $val_lien_dossier_demandeur,
            DB_AUTOQUERY_INSERT
        );

        if($this->f->isDatabaseError($res, true)) {
            return false;
        }

        return true;
    }

    /**
     * Retourne un float
     *
     * @param string $surf valeur à virgule
     *
     * @return float
     */
    function get_surface($surf) {
        if($surf == '') {
            return null;
        }
        return floatval(str_replace(',', '.', $surf));
    }

    /**
     * Transforme Oui/Non en booleen interpretable par la base.
     *
     * @param String $bool Oui/Non
     *
     * @return string t/f
     */
    function get_boolean($bool) {
        if($bool == '' or $bool == 'NULL') {
            return null;
        }
        if($bool == 'Oui') {
            return 't';
        }
        if($bool == 'Non') {
            return 'f';
        }
    }

    /**
     * Récupération du cerfa associé au DATD.
     *
     * @param integer $datd identifiant du DATD
     *
     * @return integer|null identifiant du cerfa ou null si il
     * n'a pas été récupéré
     */
    function get_cerfa($datd) {
        // recherche de la valeur
        if(array_key_exists($datd, $this->cache['cerfa_datd']) && $this->cache['cerfa_datd'][$datd] !=''){
            // on retourne la valeur de cerfa
            return $this->cache['cerfa_datd'][$datd];
        }
        // si on n'a pas trouvé de CERFA on active le CERFA générique, id 16
        return 16;
    }

    /**
     * Récupération du cp associé à la commune.
     *
     * @param integer $om_collectivite
     *
     * @return str code postal
     */
    function get_cp($om_collectivite) {
        // recherche de la valeur
        if(array_key_exists($om_collectivite, $this->cache['cp_om_collectivite']) && $this->cache['cp_om_collectivite'][$om_collectivite] !=''){
            // on retourne la valeur de cerfa
            return $this->cache['cp_om_collectivite'][$om_collectivite];
        }
    }

    /**
     * Récupération du nom de commune associé à la commune.
     *
     * @param integer $om_collectivite
     *
     * @return str commune
     */
    function get_ville($om_collectivite) {
        // recherche de la valeur
        if(array_key_exists($om_collectivite, $this->cache['commune_om_collectivite']) && $this->cache['commune_om_collectivite'][$om_collectivite] !=''){
            // on retourne la valeur de cerfa
            return $this->cache['commune_om_collectivite'][$om_collectivite];
        }
    }

    /**
     * Méthode de mise à jour des données du DA passé en paramètre.
     *
     * @param string $id_da identifiant du DA
     *
     * @return boolean true/false
     */
    function update_dossier_autorisation($id_da) {
        $da = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => $id_da,
        ));
        // Mises à jour du DA à exécuter
        $updates_da = array(
            'localisation',
            'lot',
            'demandeur',
            'etat',
            'date_init_import',
            'date_validite',
            'date_doc_import',
            'date_daact_import',
            'dt',
        );
        return $da->majDossierAutorisation(array(
            'updates_da' => $updates_da,
            'mode_update' => 'get_all_close_di',
            'force_calcul_parcelles' => true,
        ));
    }

    /**
     * Analyse de la composition du numéro de dossier pour en extraire les différentes composantes
     *  - numéro de dossier
     *  - insee
     *  - lettre de service, sur un ou deux caractères alphabétiques, ou 0
     *  - numéro du dossier
     *  - séparateur '-' de la partie incrément, optionnel
     *  - type d'incrément (P|M|T|DOC|DAACT|PRO|ANNUL)
     *  - numéro d'incrément
     * 
     * 
     * Jeu de tests :
     * 02a16813A0041m01
     * 08116814A0005-M01
     * 08116814A00051
     * 08116814AB0051
     * 0811681400051
     * 454            -> invalide
     * 08116814A00051 -> invalide
     * 
     */
    protected function explode_dossier() {
        $dossier = array(
            "di"        => '',
            "da"        => '',
            "insee"     => '',
            "annee"     => '',
            "division"  => '',
            "numero"    => '',
            "sep"       => '',
            "code"      => 'P',
            "version"   => 0,
            );
            
        $regex_di = "/^(([0-9]{2}[0-9AB][0-9]{3})([0-9]{2})([A-Z]{1,2}|[0-9])([0-9]{4}))(-){0,1}(P|M|T|DOC|DAACT|PRO|ANNUL)?([0-9]{1,2})?$/i";
        if(! preg_match($regex_di, $this->line["numero"], $matches)) {
            $this->f->addToLog(
                __METHOD__."(): LINE  Failed to match regex on DI numero: '" . $this->line["numero"] . "'",
                EXTRA_VERBOSE_MODE
            );
            $this->line_error[] = _("Numéro de dossier instruction invalide");
            return;
        }
        $dossier["di"] = $matches[0];
        $dossier["da"] = isset($matches[1]) ? $matches[1] : $dossier["da"];
        $dossier["insee"] = isset($matches[2]) ? $matches[2] : $dossier["insee"];
        $dossier["annee"] = isset($matches[3]) ? $matches[3] : $dossier["annee"];
        $dossier["division"] = isset($matches[4]) ? $matches[4] : $dossier["division"];
        $dossier["numero"] = isset($matches[5]) ? $matches[5] : $dossier["numero"];
        $dossier["sep"] = isset($matches[6]) ? $matches[6] : $dossier["sep"];
        $dossier["code"] = isset($matches[7]) ? $matches[7] : $dossier["code"];
        $dossier["version"] = isset($matches[8]) ? intval($matches[8]) : $dossier["version"];

        // Vérification que le DA est bien celui déclaré dans initial lorsque initial est défini
        if($this->line["initial"] != '' && $this->line["initial"] != $dossier["da"]){
            $this->line_error[] = _("Le numéro de dossier initial et le numéro de dossier ne correspondent pas.");
        }
        
        // Affectation du DA si aucun dossier initial
        if($this->line["initial"] == '') {
            $this->line["initial"] = $dossier["da"];
        }
        
        // Affectation du numéro de version
        $this->line["version"] = intval($dossier["version"]);
        
        // Si l'on a un numéro de version mais pas de type, on rejette la ligne
        if ($dossier["version"] != 0 && ($dossier["code"] == 'P' || $dossier["code"] == '')) {
            $this->line_error[] = _("Le numéro de dossier comporte un numéro d'incrément mais pas de type de dossier suivant une autorisation initiale (M|T|DOC|DAACT|PRO|ANNUL).");
        }
        
        // Chargement du type de DI
        $this->line["code"] = $dossier["code"];
        
        // Identifiant DA "PC01001021A0001"
        $this->line["initial"] = $dossier["insee"].$dossier["annee"].$dossier["division"].$dossier["numero"];

        // Identifiant DI "PC01001021A0001M01"
        $this->line["numero"] = $dossier["insee"].$dossier["annee"].$dossier["division"].$dossier["numero"];
        if ($dossier["version"] != 0 && $dossier["code"] != 'P') {
            $this->line["numero"].=$dossier["code"].str_pad(strval($dossier["version"]), 2, '0', STR_PAD_LEFT);
        }

        // Libellé DA "PC 010010 21 A0001"
        $this->line["lib_da"] = ' '.$dossier["insee"].' '.$dossier["annee"].' '.$dossier["division"].$dossier["numero"];

        // Libellé DI "PC 010010 21 A0001M01"
        $this->line["lib_di"] = $this->line["lib_da"];
        if ($dossier["version"] != 0 && $dossier["code"] != 'P') {
            $this->line["lib_di"].=$dossier["code"].str_pad(strval($dossier["version"]), 2, '0', STR_PAD_LEFT);
        }
    }

    /**
     * Récupération du suffixe du type de dossier d'instruction
     * dans l'attribut cache['di_suffixe'].
     * Si il n'y a pas de suffixe pour le type de DI renvoie null.
     *
     * @param integer $id_dossier_instruction_type identifiant du type de DI
     *
     * @return integer|null si le suffixe existe renvoie sa valeur sinon renvoie null
     */
    protected function get_dossier_instruction_type_suffixe($id_dossier_instruction_type) {
        if (array_key_exists($id_dossier_instruction_type, $this->cache['di_suffixe'])) {
            return $this->cache['di_suffixe'][$id_dossier_instruction_type];
        }

        return null;
    }


    /**
     * Récupération de l'identifiant du type de dossier d'instruction.
     *
     * @param integer $type dossier_autorisation_type_detaille
     * @param string  $code P/T/M
     *
     * @return integer|null identifiant du type de dossier d'instruction ou
     * null si le type de DI n'a pas été trouvé
     */
    protected function get_dossier_instruction_type($type, $code) {
        if (array_key_exists($type, $this->cache['di_type']) &&
            array_key_exists($code, $this->cache['di_type'][$type])){
            return $this->cache['di_type'][$type][$code];
        }
        return null;
    }
}


