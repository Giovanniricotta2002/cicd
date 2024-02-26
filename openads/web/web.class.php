<?php
/**
 * La classe openads_web est une surcharge de la classe utils permettant une
 * conenxion à la base de données avec un utilisateur anonyme.
 *
 * @package openfoncier
 * @version SVN : $Id$
 */

// 
require_once "../obj/utils.class.php";

/**
 * Classe openads_web qui étend de la classe utils qui étend elle-même
 * d'om_application
 */
class openads_web extends utils {


    /**
     * Constructeur de la classe
     */
    public function __construct(
        $flag = "anonym",
        $right = null,
        $title = null,
        $icon = null,
        $help = null) {
        //
        parent::__construct($flag, $right, $title, $icon, $help);
    }


    /**
     * Affiche le header de la page HTML.
     *
     * @return void
     */
    protected function display_html_header() {
        //
        printf(
            $this->template_html_header,
            _("Suivi de mon dossier")
        );
    }


    /**
     * Affiche l'entête de la page.
     *
     * @return void
     */
    protected function display_header() {
        // Affiche le pied de page si le paramètre 'content_only' est désactivé
        if ($this->get_content_only_param() == false) {
            //
            printf(
                $this->template_header,
                _("Suivi de mon dossier")
            );
        }
    }


    /**
     * Affiche le header de la page.
     *
     * @return void
     */
    public function display() {
        // Cette méthode est appellé dans le constructeur des openads_web
        // et réalise l'affichage du header. Lors de l'ouverture de documents notifiés
        // en anonyme on avait donc du html mélangé au document.
        // Cette condition permet d'éviter cela en vérifiant si on est dans un des cas
        // ou le HTML ne dois pas être appliqué. Les différents cas identifié dans la
        // condition ont été récupéré de la classe mère pour garder le même fonctionnement.
        if ($this->flag != "nohtml"
            && $this->flag != "login_and_nohtml"
            && $this->flag != "login"
            && $this->flag != "logout"
            && $this->flag != "anonym") {
            // Header de la page HTML
            $this->display_html_header();
            // Entête de la page
            $this->display_header();
            //
            echo '<div class="container">';
        }
    }


    /**
     * Affiche le footer de la page.
     *
     * @return void
     */
    public function displayFooter() {
        // Cette méthode est appellé dans le destructeur des openads_web
        // et réalise l'affichage du footer. Lors de l'ouverture de documents notifiés
        // en anonyme on avait donc du html mélangé au document.
        // Cette condition permet d'éviter cela en vérifiant si on est dans un des cas
        // ou le HTML ne dois pas être appliqué. Les différents cas identifié dans la
        // condition ont été récupéré de la classe mère pour garder le même fonctionnement.
        if ($this->flag != "nohtml"
            && $this->flag != "login_and_nohtml"
            && $this->flag != "login"
            && $this->flag != "logout"
            && $this->flag != "anonym") {
            echo '</div>';

            // Affiche le pied de page si le paramètre 'content_only' est désactivé
            if ($this->get_content_only_param() == false) {
                //
                printf(
                    $this->template_footer
                );
            }
        }
    }


    /**
     * Affiche le footer de la page HTML.
     *
     * @return void
     */
    public function displayHTMLFooter() {
        // Cette méthode est appellé dans le destructeur des openads_web
        // et réalise l'affichage du footer. Lors de l'ouverture de documents notifiés
        // en anonyme on avait donc du html mélangé au document.
        // Cette condition permet d'éviter cela en vérifiant si on est dans un des cas
        // ou le HTML ne dois pas être appliqué. Les différents cas identifié dans la
        // condition ont été récupéré de la classe mère pour garder le même fonctionnement.
        if ($this->flag != "nohtml"
            && $this->flag != "login_and_nohtml"
            && $this->flag != "login"
            && $this->flag != "logout"
            && $this->flag != "anonym") {
            //
            printf(
                $this->template_html_footer
            );
        }
    }


    /**
     * Permet de vérifier que le paramètre d'affichage du contenu seulement est
     * activée ou désactivée.
     * Ce paramètre permet d'afficher seulement le contenu de la page sans
     * l'entête et le pied de page.
     *
     * @return boolean
     */
    public function get_content_only_param() {
        //
        if (isset($_GET['content_only']) === false) {
            return false;
        }
        //
        if ($_GET['content_only'] === 'true') {
            return true;
        }
        //
        return false;
    }


    /**************************************************************************
     * Définition des templates d'affichage
     */


    /**
     * [$template_html_header description]
     *
     * @var string
     */
    var $template_html_header = '<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>%s</title>
    <link href="themes/t01/css/bootstrap.min.css" rel="stylesheet">
    <link href="themes/t01/css/style.css" rel="stylesheet">
  </head>
  <body>';


    /**
     * [$template_header description]
     *
     * @var string
     */
    var $template_header = '
    <!-- HEADER - START -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="citizen.php">%s</a>
          </div>
        </div>
    </div>
    <!-- HEADER - END -->';


    /**
     * [$template_footer description]
     *
     * @var string
     */
    var $template_footer = '
    </div>
    <!-- FOOTER - START -->
    <div id="footer">
      <div class="container">
        <p class="text-muted credit">Généré avec <a href="http://www.openmairie.org/">openADS</a>.</p>
      </div>
    </div>
    <!-- FOOTER - END -->';


    /**
     * [$template_html_footer description]
     *
     * @var string
     */
    var $template_html_footer = '
    <!-- JavaScript -->
    <script src="themes/t01/js/jquery-1.12.1.min.js"></script>
    <script src="themes/t01/js/bootstrap.min.js"></script>
    <script src="themes/t01/js/script.js"></script>
  </body>
</html>';


}

?>
