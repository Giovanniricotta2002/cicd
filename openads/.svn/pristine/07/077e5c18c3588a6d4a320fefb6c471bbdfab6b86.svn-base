<?php
/**
 * Ce script contient la définition de la classe SURCHARGE 'om_layout_jqueryui'.
 *
 * @package openads
 * @version SVN : $Id$
 */

//
require_once PATH_OPENMAIRIE."om_layout_jqueryui.class.php";

/**
 * Définition de la classe SURCHARGE 'om_layout_jqueryui'.
 */
class om_layout_jqueryui extends layout_jqueryui {

    /**
     * SURCHARGE
     *
     * Affiche le ou les logos :
     * Le logo spécifique si celui-ci existe, et le logo de l'application dans
     * tous les cas.
     *
     * @return void
     */
    public function display_logo() {
        // Le fichier contenant l'image du logo spécifique doit se nommer
        // "logo_customer.jpg" ou "logo_customer.png" et être stocké dans le
        // répertoire "app/img/" à la racine de l'application.
        $filename = null;
        if (file_exists(PATH_OPENMAIRIE."../app/img/logo_customer.jpg") === true) {
            $filename = PATH_OPENMAIRIE."../app/img/logo_customer.jpg";
        }
        if (file_exists(PATH_OPENMAIRIE."../app/img/logo_customer.png") === true) {
            $filename = PATH_OPENMAIRIE."../app/img/logo_customer.png";
        }
        // Calcul de la longueur du logo spécifique en se basant sur une
        // hauteur fixe à 50px.
        $width = null;
        if ($filename !== null) {
            $image_size = getimagesize($filename);
            if ($image_size !== false) {
                $width = round(50*($image_size[0]/$image_size[1]));
            }
        }
        // Affiche seulement le logo de l'application si le logo spécifique
        // n'existe pas ou qu'il ne s'agit pas d'une image valide.
        if ($filename !== null && $width !== null) {
            // Logo
            echo "\t<div id=\"logo\">\n";
            //
            echo "\t\t<h1>\n";
            // Lien vers le tableau de bord
            echo "\t\t<a class=\"logo_customer\" style=\"display: inline-block;\"";
            echo "href=\"".$this->get_parameter("url_dashboard")."\" ";
            echo "title=\"".__("Tableau de bord")."\">\n";
            //
            echo "\t\t\t<span class=\"logo_customer\" style=\"height: 50px; width: ".$width."px;\" >";
            echo "logo_customer";
            echo "</span>\n";
            //
            echo "\t\t</a>\n";
            // Lien vers le tableau de bord
            echo "\t\t<a class=\"logo\" style=\"display: inline-block;\"";
            echo "href=\"".$this->get_parameter("url_dashboard")."\" ";
            echo "title=\"".__("Tableau de bord")."\">\n";
            //
            echo "\t\t\t<span class=\"logo\">";
            echo $this->get_parameter("application");
            echo "</span>\n";
            //
            echo "\t\t</a>\n";
            //
            echo "\t\t</h1>\n";
            // Fin du logo
            echo "\t</div>\n";
        } else {
            parent::display_logo();
        }
    }

    // On ajoute l'attribut "lang" à la balise HTML
    protected function display_html_header_htmltag() {
        //
        echo "<html lang=\"fr\">\n";
    }

        /**
     * Affichage du menu
     */
    public function display_menu() {
        //
        if ($this->get_parameter("menu") == NULL) {
            return;
        }

        // Initialisation des variables de menu
        $compteurMenu = 0;
        $menuOpen = null;

        echo "<!-- ########## START MENU ########## -->\n";
        echo "<div id=\"menu\">\n"; 

        //
        echo "<ul id=\"menu-list\">\n";

        // Boucle sur les rubriques
        foreach ($this->get_parameter("menu") as $m => $rubrik) {

            //
            $cpt_links = 0;

            if (isset($rubrik["selected"])) {
                $menuOpen = $m;
            }

            if (isset($rubrik['class']) and $rubrik['class'] != "") {
                echo "\t<li class=\"rubrik ".$rubrik['class']."\">\n";
            }
            // Titre de la rubrique
            echo "\t\t<h3";
            if (isset($rubrik['description']) and $rubrik['description'] != "") {
                echo " title=\"".$rubrik['description']."\"";
            }
            echo ">";
            echo "<a href=\"";
            if (isset($rubrik['href']) and $rubrik['href'] != "") {
                echo $rubrik['href'];
            } else {
                echo "#";
            }
            echo "\"";
            if (isset($rubrik['class']) and $rubrik['class'] != "") {
                echo " class=\"".$rubrik['class']."-20\"";
            }
            echo ">";
            echo $rubrik['title'];
            echo "</a>";
            echo "</h3>\n";
            //
            if (count($rubrik['links']) != 0) {
                // Contenu de la rubrique
                echo "\t\t<div class=\"rubrik\">\n";
                echo "\t\t\t<ul class=\"rubrik\">\n";
                // Boucle sur les entrees de menu
                foreach ($rubrik['links'] as $link) {
                    // Entree de menu
                    echo "\t\t\t\t";
                    if (trim($link['title']) != "<hr />"
                        && trim($link['title']) != "<hr/>"
                        && trim($link['title']) != "<hr>") {
                        //
                        echo "<li class=\"elem";
                        if (isset($link["selected"])) {
                            echo " ui-state-focus";
                        }
                        if (isset($link['class'])) {
                            echo " ".$link['class']."";
                        }
                        echo "\">";
                        //
                        if (isset($link["href"])) {
                            echo "<a";
                            if (isset($link['class']) and $link['class'] != "") {
                                echo " class=\"".$link['class']."-16\"";
                            }
                            echo " href=\"";
                            if (isset($link['href']) and $link['href'] != "") {
                                echo $link['href'];
                            } else {
                                echo "#";
                            }
                            echo "\"";
                            if (isset($link['target']) and $link['target'] != "") {
                                echo " target=\"".$link['target']."\"";
                            }
                            echo ">";
                        }
                        //
                        echo $link['title'];
                        //
                        if (isset($link["href"])) {
                            echo "</a>";
                        }
                        echo "</li>";
                    } else {
                        echo "<li class=\"elem hr\"><!-- --></li>";
                    }
                    echo "\n";
                }
                // Fin de la rubrique
                echo "\t\t\t</ul>\n";
                echo "\t\t</div>\n";

            }
            // Fermeture de le rubrique
            echo "\t</li>\n";
        }
        // Fin du menu
        echo "</ul>\n";
        echo "</div>\n";
        // Positionnement d'une variable recuperee en javascript pour ouvrir la rubrique active
        echo "<span id='menuopen_val'>$menuOpen</span>";
        //
        echo "<!-- ########## END MENU ########## -->\n";
    }

    var $html_head_css = array(
        10 => array(
            "../app/css/app_poc.css",
            "../app/css/style.css",
            "../../node_modules/remixicon/fonts/remixicon.css",
            "../lib/jquery-thirdparty/jquery-minicolors/jquery.minicolors.css",
        ),
        20 => array(
            // "../lib/om-assets/css/layout_jqueryui_before.css",
            "../app/css/layout_jqueryui_before.css",
        ),
        30 => array(

        ),
    );


    // Rajout d'un container pour l'affichage des listings afin de créer une barre de scroll horizontale
    public function display_table_start_class_default($param) {
        // Affichage de la table

        echo "<section class=\"tab-listing-container\">";
        echo "<!-- tab-tab -->\n";
        echo "<table class=\"tab-tab\">\n";
    }
    public function display_table_start($param) {
        $class=$param['class'];
        // Affichage de la table
        echo "<section class=\"tab-listing-container\">";
        echo "<!-- tab-tab -->\n";
        echo "<table class=\"".$class."-tab\">\n";
    }
    function displayTableContainerEnd() {
        echo "</section>"; 
    }
}
