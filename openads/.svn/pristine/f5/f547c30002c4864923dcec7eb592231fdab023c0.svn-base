<?php
/**
 * Ce fichier est destine a permettre la surcharge de certaines methodes de
 * la classe om_edition pour des besoins specifiques de l'application
 *
 * @package openmairie_exemple
 * @version SVN : $Id: om_edition.class.php $
 */

/**
 *
 */
require_once PATH_OPENMAIRIE."om_edition.class.php";

/**
 *
 */
class om_edition extends edition {
    /**
     * La surcharge de fonction ci-dessous n'est présente que pour changer l'ordre
     * d'un petit bloc de code (l'exécution du fichier '$file_to_include')
     * pour ne pas modifier le 'core' du framework.
     * @XXX: corriger le 'core' du framework, puis retirer cette surcharge
     */

    /**
     * Génération de l'édition PDF pour une édition "etat" ou "lettretype".
     *
     * @param string $edition_elem Élement sur lequel porte l'édition. Les
     *                             valeurs possibles sont "etat" ou "lettretype".
     * @param string $collectivite Identifiant de la collectivité spécifique
     *                             (dans certains cas d'utilisation liés au
     *                             multi-collectivité) sur laquelle porte
     *                             l'édition.
     *
     * @return array
     */
    function pdf_om_etat_om_lettretype($edition_elem, $collectivite) {

        // Initialisation des variables en fonction de l'élément <EDITION> passé
        // en paramètre.
        if ($edition_elem == "lettretype") {
            $table = "om_lettretype";
            $file_to_include = "../dyn/varlettretypepdf.inc";
        } elseif ($edition_elem == "etat") {
            $table = "om_etat";
            $file_to_include = "../dyn/varetatpdf.inc";
        } else {
            return array(
                "pdf_output" => "",
                "filename" => "",
            );
        }

        // Paramétrage du filigrane
        (isset($_GET['watermark']) && $_GET['watermark'] == 'true') ?
            $watermark = true : $watermark = false;

        // S'il s'agit d'une prévisualisation, on affecte la clé primaire de la lettre
        // type à la variable edition_direct_preview_id
        $edition_direct_preview_id = null;
        if (isset($_GET["specific"])
            && is_array($_GET["specific"])
            && isset($_GET["specific"]["mode"])
            && $_GET["specific"]["mode"] == "edition_direct_preview"
            && isset($_GET["specific"]["id"])) {
            //
            $edition_direct_preview_id = $_GET["specific"]["id"];
        }

        // Dans certains cas d'utilisation liés au multi collectivité, il est
        // nécessaire de récupérer l'édition de la collectivité de l'élément au
        // lieu de la collectivité de l'utilisateur. Donc on vérifie si le
        // tableau de paramètre de la collectivité a été passé en paramètre
        // sinon on définit celui de l'utilisateur connecté.
        if ($collectivite == null) {
            $collectivite = $this->f->getCollectivite();
        }
        //
        if (isset($_GET["obj"]) || isset($_GET['idx'])) {
            // Identifiant de l'édition à générer (champ id de la table om_<EDITION>)
            (isset($_GET['obj']) ? $obj = $_GET['obj'] : $obj = "");
            // Identifiant de l'élément concerné par l'édition
            (isset($_GET['idx']) ? $idx = $_GET['idx'] : $idx = "");
        } elseif (isset($_POST["obj"]) || isset($_POST['idx'])) {
            //
            (isset($_POST['obj']) ? $obj = $_POST['obj'] : $obj = "");
            // Si c'est un tableau qui est fourni dans le POST alors on le concatène
            // avec des ; pour coller au format attendu
            if (is_array($obj) === true) {
                $obj_str = "";
                foreach ($obj as $value) {
                    $obj_str .= $value.";";
                }
                $obj = $obj_str;
            }
            //
            (isset($_POST['idx']) ? $idx = $_POST['idx'] : $idx = "");
            // Si c'est un tableau qui est fourni dans le POST alors on le concatène
            // avec des ; pour coller au format attendu
            if (is_array($idx) === true) {
                $idx_str = "";
                foreach ($obj as $value) {
                    $idx_str .= $value.";";
                }
                $idx = $idx_str;
            }
        } else {
            //
            $obj = "";
            $idx = "";
        }
        //
        $editions = array_filter(explode(";", $obj));
        $elements = array_filter(explode(";", $idx));

        // Si un seul élément est fourni alors qu'il y a plusieurs éditions alors on
        // suppose que c'est le même élément pour chacune des éditions
        if (count($editions) != count($elements) && count($editions) > 1 &&
            count($elements) == 1) {
            foreach ($editions as $edition) {
                $elements[] = $elements[0];
            }
        } elseif (count($editions) != count($elements) && count($editions) == 1 &&
            count($elements) > 1) {
            // Si une seule édition est fourni alors qu'il y a plusieurs
            // éléments alors on suppose que c'est la même édition pour chacun
            // des éléments
            $tmp_edition = $editions[0];
            $editions = array();
            foreach ($elements as $element) {
                $editions[] = $tmp_edition;
            }
            unset($tmp_edition);
        }

        /**
         * Ces paramètres sont ici pour une raison de rétro-compatibilité
         * @todo Vérifier qu'il n'est pas possible de les supprimer de ce fichier et de
         *       les gérer dans dyn/var<EDITION>pdf.inc ce qui est déjà en partie le
         *       cas
         */
        //
        $destinataire = "";
        //
        $datecourrier = date('d/m/Y');
        //
        $complement = "<-Ici le complement->";

        /**
         * Inclusion de la classe de génération des éditions
         */
        //
        set_time_limit(180);
        //
        require_once PATH_OPENMAIRIE."fpdf_etat.php";

        /**
         * Multi impression
         */
        // Définition du css interne au pdf
        $css = "<style>
        span.error {
            font-weight: bold;
            background-color: #cdcdcd;
            color: #ff0000;
        }
        .mce_maj {
            text-transform: uppercase;
        }
        .mce_min {
            text-transform: lowercase;
        }
        </style>";
        //
        $pdf = null;
        //
        foreach ($editions as $key => $value) {

            /**
             * Initialisation des variables :
             * - $obj :
             * - $idx :
             */
            //
            $obj = $value;
            //
            $idx = "-1";
            if (isset($elements[$key])) {
                if (is_integer($elements[$key])) {
                    $idx = $elements[$key];
                } else {
                    $idx = $this->f->db->escapeSimple($elements[$key]);
                }
            }
            // Compatibilité antérieure : dans le cas où le remplacement des variables
            // dans le fichier de remplacement dyn/var<EDITION>pdf.inc se base sur la
            // variable $_GET au lieu de la variable $idx
            $_GET['idx'] = $idx;

            /**
             * Récupération du paramétrage de l'édition.
             */
            //
            $this->f->addToLog(__METHOD__."() récupération édition ($table, $obj, ".$collectivite['om_collectivite_idx'].", $edition_direct_preview_id)", EXTRA_VERBOSE_MODE);
            $edition = $this->get_edition_from_collectivite(
                $table,
                $obj,
                $collectivite['om_collectivite_idx'],
                $edition_direct_preview_id
            );
            $this->f->addToLog(__METHOD__."() récupération édition OK", EXTRA_VERBOSE_MODE);
            // Si aucune édition ne correspond dans le paramétrage, on passe à
            // l'itération suivante de la boucle multi édition.
            if (is_null($edition)) {
                //
                continue;
            }

            // CHAMPS DE FUSION - Récupération des valeurs
            // Initialisation du tableau de champs de fusion
            $this->f->addToLog(__METHOD__."() récupération des champs de fusion (".$edition["om_sql"].", $idx)", EXTRA_VERBOSE_MODE);
            $merge_fields_values = $this->get_merge_fields_values(
                $edition["om_sql"],
                $idx
            );
            $this->f->addToLog(__METHOD__."() récupération des champs de fusion OK", EXTRA_VERBOSE_MODE);

            // VARIABLES DE REMPLACEMENT - Récupération des valeurs
            //
            $this->f->addToLog(__METHOD__."() récupération des variables de substitution", EXTRA_VERBOSE_MODE);
            $substitution_vars_values = $this->get_substitution_vars_values(
                $collectivite['om_collectivite_idx']
            );
            $this->f->addToLog(__METHOD__."() récupération des variables de substitution OK", EXTRA_VERBOSE_MODE);

            /**
             * Initialisation du fichier PDF.
             */
            // Si on se trouve sur la première édition
            if (is_null($pdf)) {
                // Instanciation du document PDF avec les paramètres de la
                // première édition.
                $pdf = new PDF(
                    // $orientation (string) page orientation. Possible values are
                    // (case insensitive):
                    // - P or Portrait (default)
                    // - L or Landscape
                    // - '' (empty string) for automatic orientation
                    $edition["orientation"],
                    // $unit (string) User measure unit. Possible values are:
                    // - pt: point
                    // - mm: millimeter (default)
                    // - cm: centimeter
                    // - in: inch
                    "mm",
                    // $format (mixed) The format used for pages.
                    $edition["format"],
                    // $unicode (boolean) TRUE means that the input text is unicode
                    // (default = true)
                    true,
                    // $encoding (string) Charset encoding (used only when converting
                    // back html entities); default is UTF-8.
                    'HTML-ENTITIES'
                );
                // Si le filigrane "DOCUMENT DE TRAVAIL" est paramétré.
                if ($watermark == true) {
                    // On l'ajoute sur chaque page
                    $pdf->setWatermark();
                }
                // Start First Page Group
                // Lors d'une édition multi, la numérotation est globale.
                // XXX Il est possible de rendre la numérotation des pages
                //     spécifique à chaque édition en déplaçant l'instruction
                //     suivante en dehors de ce bloc pour qu'il soit appelé
                //     à chaque itération de la boucle multi.
                $pdf->startPageGroup();
            }

            /**
             * Initialisation des paramètres de marges de l'édition.
             */
            // Définit les marges du document
            if ($edition["margeleft"] == "") {
                $edition["margeleft"] = PDF_MARGIN_LEFT;
            }
            if ($edition["margetop"] == "") {
                $edition["margetop"] = PDF_MARGIN_TOP;
            }
            if ($edition["margeright"] == "") {
                $edition["margeright"] = PDF_MARGIN_RIGHT;
            }
            if ($edition["margebottom"] == "") {
                $edition["margebottom"] = PDF_MARGIN_BOTTOM;
            }
            // set margins
            $pdf->setMargins(
                $edition["margeleft"],
                $edition["margetop"],
                $edition["margeright"]
            );
            $pdf->SetHeaderMargin($edition["margetop"]);
            $pdf->SetFooterMargin($edition["margebottom"]);
            // set auto page breaks
            $pdf->SetAutoPageBreak(true, $edition["margebottom"]);
            // définition du padding haut et bas des balises p span et table
            $tagvs = array(
                'p' => array(
                    0 => array('h' => 0, 'n' => 0),
                    1 => array('h' => 0, 'n' => 0)
                ),
                'div' => array(
                    0 => array('h' => 0, 'n' => 0),
                    1 => array('h' => 0, 'n' => 0)
                ),
                'span' => array(
                    0 => array('h' => 0, 'n' => 0),
                    1 => array('h' => 0, 'n' => 0)
                ),
                'table' => array(
                    0 => array('h' => 0, 'n' => 0),
                    1 => array('h' => 0, 'n' => 0)
                ),
            );
            $pdf->setHtmlVSpace($tagvs);

            /**
             * HEADER - Paramétrage de l'entête
             */
            //
            if ($edition["header_om_htmletat"] != "") {
                $header = html_entity_decode($edition["header_om_htmletat"]);
                $header = preg_replace('#<\s*tcpdf[^>]+>#', '', $header);
                $header = $this->replace_all_elements(
                    $header,
                    $substitution_vars_values,
                    $merge_fields_values
                );
                $header = '<meta charset="UTF-8" />'.$header.'';
                $header = $pdf->prepare_html_for_tcpdf($header);
                $header = $css.$header;
                $header = str_replace("&numpage", $pdf->getPageNumGroupAlias(), $header);
                $header = str_replace("&nbpages", $pdf->getPageGroupAlias(), $header);
                $header = str_replace("&amp;numpage", $pdf->getPageNumGroupAlias(), $header);
                $header = str_replace("&amp;nbpages", $pdf->getPageGroupAlias(), $header);
                //
                $pdf->set_header(array(
                    "offset" => $edition["header_offset"],
                    "html" => $header,
                ));
            }

            /**
             * FOOTER - Paramétrage du pied de page
             */
            //
            if ($edition["footer_om_htmletat"] != "") {
                $footer = html_entity_decode($edition["footer_om_htmletat"]);
                $footer = preg_replace('#<\s*tcpdf[^>]+>#', '', $footer);
                $footer = $this->replace_all_elements(
                    $footer,
                    $substitution_vars_values,
                    $merge_fields_values
                );
                $footer = '<meta charset="UTF-8" />'.$footer.'';
                $footer = $pdf->prepare_html_for_tcpdf($footer);
                $footer = $css.$footer;
                $footer = str_replace("&numpage", $pdf->getPageNumGroupAlias(), $footer);
                $footer = str_replace("&nbpages", $pdf->getPageGroupAlias(), $footer);
                $footer = str_replace("&amp;numpage", $pdf->getPageNumGroupAlias(), $footer);
                $footer = str_replace("&amp;nbpages", $pdf->getPageGroupAlias(), $footer);
                //
                $pdf->set_footer(array(
                    "offset" => $edition["footer_offset"],
                    "html" => $footer,
                ));
            }

            /**
             *
             */
            // Ajoute une nouvelle page à l'édition
            $pdf->AddPage();

            /**
             * LOGO - Affichage du logo
             */
            //
            $logo = $this->get_logo_from_collectivite(
                $edition['logo'],
                $collectivite['om_collectivite_idx']
            );
            //
            if (!is_null($logo)) {
                // TCPDF::Image()
                $pdf->Image(
                    // $file (string) Name of the file containing the image or a '@' character followed by the image data string. To link an image without embedding it on the document, set an asterisk character before the URL (i.e.: '*http://www.example.com/image.jpg').
                    $logo["file"],
                    // $x (float) Abscissa of the upper-left corner (LTR) or upper-right corner (RTL).
                    $edition["logoleft"],
                    // $y (float) Ordinate of the upper-left corner (LTR) or upper-right corner (RTL).
                    $edition["logotop"],
                    // $w (float) Width of the image in the page. If not specified or equal to zero, it is automatically calculated.
                    $logo["w"],
                    // $h (float) Height of the image in the page. If not specified or equal to zero, it is automatically calculated.
                    $logo["h"],
                    // $type (string) Image format. Possible values are (case insensitive): JPEG and PNG (whitout GD library) and all images supported by GD: GD, GD2, GD2PART, GIF, JPEG, PNG, BMP, XBM, XPM;. If not specified, the type is inferred from the file extension.
                    $logo["type"]
                );
            }

            /**
             * TITRE ET CORPS
             */
            // Remise en forme du html pour être interprété par TCPDF
            $titre = html_entity_decode($edition["titre_om_htmletat"]);
            $corps = html_entity_decode($edition["corps_om_htmletatex"]);
            // Suppression des balises TCPDF pour éviter toutes intrusions
            $titre = preg_replace('#<\s*tcpdf[^>]+>#', '', $titre);
            $corps = preg_replace('#<\s*tcpdf[^>]+>#', '', $corps);
            // Éventuels champs de fusion spécifiques
            if (isset($_GET["specific"])
                && is_array($_GET["specific"])
                && isset($_GET["specific"]["titre"])
                && is_array($_GET["specific"]["titre"])
                && isset($_GET["specific"]["titre"]["mode"])
                && $_GET["specific"]["titre"]["mode"] == "set"
                && isset($_GET["specific"]["titre"]["value"])) {
                $titre = $_GET["specific"]["titre"]["value"];
            }
            if (isset($_GET["specific"])
                && is_array($_GET["specific"])
                && isset($_GET["specific"]["corps"])
                && is_array($_GET["specific"]["corps"])
                && isset($_GET["specific"]["corps"]["mode"])
                && $_GET["specific"]["corps"]["mode"] == "set"
                && isset($_GET["specific"]["corps"]["value"])) {
                $corps = $_GET["specific"]["corps"]["value"];
            }
            if (isset($_GET["specific"])
                && is_array($_GET["specific"])
                && isset($_GET["specific"]["merge_fields"])
                && is_array($_GET["specific"]["merge_fields"])) {
                foreach ($_GET["specific"]["merge_fields"] as $merge_field => $value) {
                    $titre = str_ireplace($merge_field, $value, $titre);
                    $corps = str_ireplace($merge_field, $value, $corps);
                }
            }

            //
            $titre = $this->replace_all_elements(
                $titre,
                $substitution_vars_values,
                $merge_fields_values
            );

            //
            $corps = $this->replace_all_elements(
                $corps,
                $substitution_vars_values,
                $merge_fields_values
            );

            // Remplacement des paramètres dans le fichier ../dyn/var<EDITION>pdf.inc
            // @deprecated
            if (file_exists($file_to_include)) {
                // Rétrocompatibilité - certaines variables doivent exister dans
                // le script inclus.
                $sql = "";
                // Traitement des & et &amp;
                $titre = str_ireplace("&amp;", "&", $titre);
                $corps = str_ireplace("&amp;", "&", $corps);
                // Inclusion du script
                include $file_to_include;
                // Suppression de la variable
                unset($sql);
            }

            // Récupération du contenu du titre
            if (isset($_GET["specific"])
                && is_array($_GET["specific"])
                && isset($_GET["specific"]["titre"])
                && is_array($_GET["specific"]["titre"])
                && isset($_GET["specific"]["titre"]["mode"])
                && $_GET["specific"]["titre"]["mode"] == "get") {
                return array(
                    "pdf_output" => $titre
                );
            }

            // Récupération du contenu du corps
            if (isset($_GET["specific"])
                && is_array($_GET["specific"])
                && isset($_GET["specific"]["corps"])
                && is_array($_GET["specific"]["corps"])
                && isset($_GET["specific"]["corps"]["mode"])
                && $_GET["specific"]["corps"]["mode"] == "get") {
                return array(
                    "pdf_output" => $corps
                );
            }

            /**
             * TITRE - Affichage du titre
             */
            //
            $titre = "<meta charset='UTF-8' />".$titre."";
            $titre = $pdf->prepare_html_for_tcpdf($titre);
            $titre = $css.$titre;
            $titre = str_replace("&amp;numpage", $pdf->getPageNumGroupAlias(), $titre);
            $titre = str_replace("&amp;nbpages", $pdf->getPageGroupAlias(), $titre);
            $titre = str_replace("&numpage", $pdf->getPageNumGroupAlias(), $titre);
            $titre = str_replace("&nbpages", $pdf->getPageGroupAlias(), $titre);
            // Affichage du titre si non vide
            if (trim($titre) != "") {
                // TCPDF::writeHTMLCell()
                $pdf->writeHTMLCell(
                    // $w (float) Cell width. If 0, the cell extends up to the right margin.
                    $edition["titrelargeur"],
                    // $h (float) Cell minimum height. The cell extends automatically if needed.
                    0,
                    // $x (float) upper-left corner X coordinate
                    $edition["titreleft"],
                    // $y (float) upper-left corner Y coordinate
                    $edition["titretop"],
                    // $html (string) html text to print. Default value: empty string.
                    $titre,
                    // $border (mixed) Indicates if borders must be drawn around the cell.
                    $edition["titrebordure"],
                    // $ln (int) Indicates where the current position should go after the call.
                    0,
                    // $fill (boolean) Indicates if the cell background must be painted (true) or transparent (false).
                    false,
                    // $reseth (boolean) if true reset the last cell height (default true).
                    true,
                    // $align (string) Allows to center or align the text.
                    '',
                    // $autopadding (boolean) if true, uses internal padding and automatically adjust it to account for line width.
                    true
                );
            }
            $pdf->ln();

            /**
             * CORPS - Affichage du corps
             */
            //
            $corps = "<meta charset='UTF-8' />".$corps."";
            $corps = $pdf->prepare_html_for_tcpdf($corps);
            $corps = $pdf->initSousEtats($edition, $corps, $collectivite['om_collectivite_idx']);
            $corps = $css.$corps;
            $corps = str_replace("&amp;numpage", $pdf->getPageNumGroupAlias(), $corps);
            $corps = str_replace("&amp;nbpages", $pdf->getPageGroupAlias(), $corps);
            $corps = str_replace("&numpage", $pdf->getPageNumGroupAlias(), $corps);
            $corps = str_replace("&nbpages", $pdf->getPageGroupAlias(), $corps);
            // Affichage du corps si non vide
            if (trim($corps) != "") {
                // TCPDF::writeHTML()
                $pdf->writeHTML(
                    // $html (string) text to display.
                    $corps,
                    // $ln (boolean) if true add a new line after text (default = true).
                    true,
                    // $fill (boolean) Indicates if the background must be painted (true) or transparent (false).
                    false,
                    // $reseth (boolean) if true reset the last cell height (default false).
                    true,
                    // $cell (boolean) if true add the current left (or right for RTL) padding to each Write (default false).
                    false
                );
            }
        }

        //
        if (is_null($pdf)) {
            return array(
                "pdf_output" => "",
                "filename" => "",
            );
        }

        // Construction du nom du fichier
        $filename = date("Ymd-His");
        $filename .= "-".$edition_elem;
        $filename .= "-".$obj;
        $filename .= ".pdf";

        //
        $pdf_output = $this->handle_output($pdf, $filename);

        //
        return array(
            "pdf_output" => $pdf_output,
            "filename" => $filename,
        );
    }

    /**
     * La surcharge de fonction ci-dessous n'est présente que parce que la
     * fonction 'pdf_om_etat_om_lettretype()' ci-dessus l'utilise et qu'elle
     * est délcarée 'private' dans la classe parente, rendant impossible
     * son appel depuis une classe fille.
     * @XXX: corriger le 'core' du framework, puis retirer cette surcharge
     */

    /**
     * Gère la sortie PDF.
     *
     * La sortie est gréré en fonction du paramètre $_GET['output']. En fonction
     * de ce paramètre le PDF peut donc être envoyé en inline dans le navigateur,
     * en mode download, écrit sur le disque ou retourné sous forme de chaîne de
     * caractères.
     *
     * @param resource $pdf Instance d'une classe PDF.
     * @param string $filename Nom du fichier.
     *
     * @return void|string
     */
    private function handle_output($pdf, $filename) {
        //
        $pdf_output = "";
        //
        $output = "";
        if (isset($_GET["output"])) {
            $output = $_GET["output"];
        }
        if (!in_array($output, array("string", "file", "download", "inline", "no"))) {
            if ($this->f->getParameter("edition_output") == "download") {
                $output = "download";
            } else {
                $output = "inline"; // Valeur par defaut
            }
        }
        //
        if ($output == "string") {
            // S : renvoyer le document sous forme de chaine. name est ignore.
            $pdf_output = $pdf->Output("", "S");
        } elseif ($output == "file") {
            // F : sauver dans un fichier local, avec le nom indique dans name
            // (peut inclure un repertoire).
            $pdf->Output($this->f->getParameter("pdfdir").$filename, "F");
        } elseif ($output == "download") {
            // D : envoyer au navigateur en forcant le telechargement, avec le nom
            // indique dans name.
            $pdf->Output($filename, "D");
        } elseif ($output == "inline") {
            // I : envoyer en inline au navigateur. Le plug-in est utilise s'il est
            // installe. Le nom indique dans name est utilise lorsque l'on selectionne
            // "Enregistrer sous" sur le lien generant le PDF.
            $pdf->Output($filename, "I");
        } elseif ($output == "no") {
            //
        }
        //
        return $pdf_output;
    }
}
