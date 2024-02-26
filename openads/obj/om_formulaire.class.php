<?php
/**
 * Ce fichier est destine a permettre la surcharge de certaines methodes de
 * la classe om_formulaire pour des besoins specifiques de l'application
 *
 * @package openmairie_exemple
 * @version SVN : $Id: om_formulaire.class.php 6161 2016-03-14 14:05:13Z nhaye $
 */

/**
 *
 */
require_once PATH_OPENMAIRIE."om_formulaire.class.php";

/**
 *
 */
class om_formulaire extends formulaire {
   
    /**
     * La valeur du champ est passe par le controle hidden
     *
     * @param string $champ Nom du champ
     * @param integer $validation
     * @param boolean $DEBUG Parametre inutilise
     */
    function referencescadastralesstatic($champ, $validation, $DEBUG = false) {

        //
        foreach (explode(';', $this->val[$champ]) as $key => $ref) {
            echo "<span class=\"reference-cadastrale-".$key."\">";
            echo $ref;
            echo "</span> ";
        }
    }
    
    function tableau($champ,$validation,$DEBUG = false) {
        // Ouverture du tableau
        echo "<table class='om-form-tab-table'>";

            // Affichage des entêtes de colonnes
            echo "<tr class='om-form-tab-tr'>";
            foreach ($this->select[$champ]["column_header"] as $value) {
                echo "<th";
                // Si l'entête de colonne n'est pas vide
                if($value != "") {
                    // Ajoute la classe à l'élément
                    echo " class='om-form-tab-th'";
                }
                echo ">";
                //echo "<th class='om-form-tab-th'>";
                echo $value;
                echo "</th>";
            }
            echo "</tr>";
            
            // Initialisation des variables
            $k=0;
            $keys = array_keys($this->select[$champ]["values"]);
            $values = array_values($this->select[$champ]["values"]);

            // Affichage de chaque ligne
            for ($i=0; $i<count($this->select[$champ]["row_header"]); $i++) {
                echo "<tr class='om-form-tab-tr'>";

                // Affichage de l'entête de ligne
                echo "<th";
                // Si l'entête de ligne n'est pas vide
                if($this->select[$champ]["row_header"][$i] != "") {
                    // Ajoute la classe à l'élément
                    echo " class='om-form-tab-th'";
                }
                echo ">";
                echo $this->select[$champ]["row_header"][$i];
                echo "</th>";

                // Affichage des champs
                for ($j=0; $j<count($this->select[$champ]["column_header"])-1; $j++) {
                    echo "<td class='om-form-tab-td'>";

                    // Appel de la méthode définie dans setType
                    if (method_exists($this, $this->type[$keys[$i+$j*count($this->select[$champ]["row_header"])]])) {
                        $function=$this->type[$keys[$i+$j*count($this->select[$champ]["row_header"])]];

                        $this->$function($keys[$i+$j*count($this->select[$champ]["row_header"])], $validation);
                    } else {
                        $this->statiq($keys[$i+$j*count($this->select[$champ]["row_header"])], $validation);
                    }
                    echo "</td>";
                    $k++;
                }
                echo "</tr>";
            }
        echo "</table>";
    }

    function tab_custom($champ,$validation,$DEBUG = false) {
        $tab = json_decode(html_entity_decode($this->val[$champ]));

        if ($tab !== NULL) {
            $keys = array_keys(get_object_vars($tab[0]));
            // Détermine le numéro de collonne de départ.
            $col = 0;
            if (in_array('identifiant',$keys)) {
                unset($keys[array_search('identifiant', $keys)]);
                $col=1;
            }
            // $this->addToLog('tab : '.var_export($tab, true), DEBUG_MODE);
            //$this->addToLog('keys : '.var_export($keys, true), DEBUG_MODE);
            // $this->addToLog('json_error : '.var_export(json_last_error_msg(), true), DEBUG_MODE);
            // $this->addToLog('type : '.var_export($this->type, true), DEBUG_MODE);
            // Ouverture du tableau
            echo "<table class='om-form-tab-table'>";

                // Affichage des entêtes de colonnes
                echo "<tr class='om-form-tab-tr'>";
                foreach ($keys as $key) {
                    echo "<th";
                    // Si l'entête de colonne n'est pas vide
                    if($key != "") {
                        // Ajoute la classe à l'élément
                        echo " class='om-form-tab-th'";
                    }
                    echo ">";
                    //echo "<th class='om-form-tab-th'>";
                    echo __($key);
                    echo "</th>";
                }
                echo "</tr>";
                
                // Initialisation des variables
                $k=0;
                // Affichage de chaque ligne
                for ($i=0; $i<count($tab); $i++) {
                    echo "<tr class='om-form-tab-tr'>";

                    $values = get_object_vars($tab[$i]);
                    // $this->addToLog('i : '.var_export($i, true), DEBUG_MODE);
                    // Affichage des champs
                    for ($j=$col; $j<count($keys)+$col; $j++) {
                        echo "<td class='om-form-tab-td'>";

                    // $this->addToLog('j : '.var_export($j, true), DEBUG_MODE);
                    // $this->addToLog('keys[i+j] : '.var_export($keys[$i+$j], true), DEBUG_MODE);
                    // $this->addToLog('value : '.var_export($values[$keys[$j]], true), DEBUG_MODE);
                    // $this->addToLog('key exists : '.var_export(array_key_exists($keys[$j], $this->val), true), DEBUG_MODE);
                        // Appel de la méthode définie dans setType
                        if (array_key_exists($keys[$j], $this->val)
                            && method_exists($this, $this->type[$keys[$j]])
                            && $values[$keys[$j]] != 'no_select') {
                            // $this->addToLog('method exists : '.var_export(method_exists($this, $this->type[$keys[$j]]), true), DEBUG_MODE);
                            $this->val[$keys[$j]."_".$i] = $values[$keys[$j]];
                            $function=$this->type[$keys[$j]];
                            $this->$function($keys[$j]."_".$i, $validation);
                            $this->setType($keys[$j]."_".$i, "hidden");
                            // $this->hidden($keys[$j]."_".$i, $validation, $DEBUG);
                        } else if ($values[$keys[$j]] != 'no_select') {
                            print($values[$keys[$j]]);
                            // $this->statiq($keys[$i+$j], $validation);
                        } else {
                            $this->val[$keys[$j]."_".$i] = "no_select";
                        }
                        echo "</td>";
                        $k++;
                    }
                    echo "</tr>";
                }
            echo "</table>";

            foreach ($keys as $key) {
                if (array_key_exists($key, $this->val)
                            && method_exists($this, $this->type[$key])) {

                    $this->setType($key, "hidden");
                    $this->hidden($key, $validation, $DEBUG);
                }
            }
        }
    }

    /**
     * Au clique affiche un pop-up contenant le formulaire en ajout de l'objet $champ
     * @param string $champ Nom du champ
     * @param integer $validation
     * @param boolean $DEBUG Parametre inutilise
     */
    function manage_with_popup($champ,$validation,$DEBUG = false){
        
        //Si on a pas de valeur on affiche un bouton d'ajout
        if ($this->val[$champ]==''){
            printf ("<span class=\"om-form-button add-16 add_".$champ."\"
                onclick=\"popupIt('".$champ."',
                '".OM_ROUTE_SOUSFORM."&obj=".$champ."&action=0'+
                '&retourformulaire=".$this->getParameter('obj')."', 860, 'auto',
                getObjId, '".$this->select[$champ]["obj"]."');\"".
                ">");
            printf(_("Saisir un(e) %s"),$champ);
            printf ("</span>");
        }
        //On affiche les données enregistrées et un bouton de suppression
        else {
            //
            printf ("<span class=\"om-form-button delete-16 add_".$champ."\"
                onclick=\"setDataFrequent('','".$champ."');\"".
                "title=\"");
            printf(_("Supprimer"));
            printf("\">");
            printf("&nbsp;");
            printf("</span>");
            //
            
            //
            printf ("<span class=\"om-form-button edit-16 add_".$champ."\"
                onclick=\"popupIt('".$champ."',
                '".OM_ROUTE_SOUSFORM."&obj=".$champ."&action=1&idx=".$this->val[$champ]."'+
                '&retourformulaire=".$this->getParameter('obj')."', 860, 'auto',
                getObjId, '".$this->select[$champ]["obj"]."');\"".
                "title=\"");
            printf(_("editer"));
            printf("\">");
            printf(isset($this->select[$champ]["data"])?$this->select[$champ]["data"]:_("Aucun libelle pour la donnee"));
            printf("</span>");
        } 
        //
        printf ("<input");
        printf (" type=\"hidden\"");
        printf (" name=\"".$champ."\"");
        printf (" id=\"".$champ."\" ");
        printf (" value=\"".$this->val[$champ]."\"");
        printf (" class=\"champFormulaire\"");
        if (!$this->correct) {
            if (isset($this->onchange) and $this->onchange[$champ] != "") {
                printf (" onchange=\"".$this->onchange[$champ]."\"");
            }
            if (isset($this->onkeyup) and $this->onkeyup[$champ] != "") {
                printf (" onkeyup=\"".$this->onkeyup[$champ]."\"");
            }
            if (isset($this->onclick) and $this->onclick[$champ] != "") {
                printf (" onclick=\"".$this->onclick[$champ]."\"");
            }
        } else {
            printf (" disabled=\"disabled\"");
        }
        printf (" />\n");
        //
    }

    /**
     * La valeur du champ est passé par le champ input hidden
     * @param string $champ Nom du champ
     * @param integer $validation
     * @param boolean $DEBUG Parametre inutilise
     */
    function checkboxhiddenstatic($champ, $validation, $DEBUG = false) {

        // Input de type hidden pour passé la valeur à la validation du 
        // formulaire
        echo "<input";
        echo " type=\"hidden\"";
        echo " id=\"".$champ."\"";
        echo " name=\"".$champ."\"";
        echo " value=\"".$this->val[$champ]."\"";
        echo " class=\"champFormulaire\"";
        echo " />\n";

        // Affichage de la valeur 'Oui' ou 'Non'
        if ($this->val[$champ] == 1 || $this->val[$champ] == "t"
            || $this->val[$champ] == "Oui") {
            $value = "Oui";
        } else {
            $value = "Non";
        }
        echo "<span id=\"".$champ."\" class=\"field_value\">$value</span>";
    }
    
    /**
     * La valeur du champ est passé par le champ input hidden.
     * 
     * @param string  $champ      Nom du champ.
     * @param integer $validation Indicateur de validation du formulaire.
     * @param boolean $DEBUG      Parametre inutilise.
     */
    function regle_donnees_techniques($champ, $validation, $DEBUG = false) {

       $params = array(
        "type" => "text",
        "name" => "cible_".$champ,
        "id" => "cible_".$champ,
        "value" => $this->val["cible_".$champ],
        "size" => $this->taille["cible_".$champ],
        "maxlength" => $this->max["cible_".$champ],
        "correct" => $this->correct,
        "onchange" => "",
        "onkeyup" => "",
        "onclick" => ""
        );
        echo _("Champ : ");
        $this->f->layout->display_formulaire_text($params);
        echo " = ";
        
       $params = array(
        "type" => "text",
        "name" => $champ,
        "id" => $champ,
        "value" => $this->val[$champ],
        "size" => $this->taille[$champ],
        "maxlength" => $this->max[$champ],
        "correct" => $this->correct,
        "onchange" => "",
        "onkeyup" => "",
        "onclick" => ""
        );
        $this->f->layout->display_formulaire_text($params);
    }
    
    /**
     * La valeur du champ est passé par le champ input hidden.
     * 
     * @param string  $champ      Nom du champ.
     * @param integer $validation Indicateur de validation du formulaire.
     * @param boolean $DEBUG      Parametre inutilise.
     */
    function regle_donnees_techniques_static($champ, $validation, $DEBUG = false) {
        //
        if ($this->val["cible_".$champ] !== '') {
            echo "<span id=\"".$champ."\" class=\"regle_donnees_techniques\">";
            printf("%s = %s", $this->val["cible_".$champ], $this->val[$champ]);
            echo "</span>";
        }
    }
    
    /**
     * La valeur du champ est passé par le champ input hidden.
     * 
     * @param string  $champ      Nom du champ.
     * @param integer $validation Indicateur de validation du formulaire.
     * @param boolean $DEBUG      Parametre inutilise.
     */
    function cible_regle_donnees_techniques($champ, $validation, $DEBUG = false) {
        
    }


    /**
     * Widget - Type de champ composé de 4 inputs de 4 caractère chacun, dédié à la saisie
     * de la clé d'accès au portail citoyen.
     *
     * @param string  $champ      Nom du champ.
     * @param integer $validation Etat de la validation du formulaire.
     * @param boolean $DEBUG      Parametre inutilise.
     *
     * @return void
     */
    function citizen_access_key($champ, $validation, $DEBUG = false) {

        // Stockage de l'identifiant du champ suivant
        for ($i = 1; $i < 5; $i++) {
            if ($i < 4) {
                $next_value = 1 + $i;
                $next_value = $champ.$next_value;
            }
            echo "<input";
            echo " type=\"text\"";
            echo " name=\"".$champ."\"";
            echo " id=\"".$champ.$i."\"";
            echo " class=\"champFormulaire citizen_access_key\"";
            echo " maxlength=\"4\"";
            echo " size=\"4\"";
            echo " onKeyUp=\"autojump(this.id,".$next_value.", event);concatenate_citizen_access_key();\"";
            echo " onchange=\"concatenate_citizen_access_key()\"";
            echo " autocomplete=\"off\"";
            echo " />";
            if ($i < 4) {
                echo " - ";
            }
        }
    }

    function autorisation_contestee($champ, $validation, $DEBUG = false) {
        // Champ recherche DI
        echo "<input";
        echo " type=\"text\"";
        echo " name=\"".$champ."\"";
        echo " id=\"".$champ."\"";
        echo " class=\"champFormulaire\"";
        echo " maxlength=\"30\"";
        echo " size=\"20\"";
        echo " value=\"".$this->val[$champ]."\" ";
        echo " />&nbsp;";
        // Bouton chercher
        echo "<input";
        echo " id=\"autorisation_contestee_search_button\"";
        echo " type=\"button\"";
        echo " value=\""._('Chercher')."\" ";
        echo " name=\"looking_for_autorisation_contestee\"";
        echo " onclick=\"lookingForAutorisationContestee();\"";
        echo " class=\"om-button\"";
        echo " />&nbsp;";
        // Bouton annuler
        echo "<input";
        echo " id=\"autorisation_contestee_cancel_button\"";
        echo " type=\"button\"";
        echo " value=\""._('Annuler')."\" ";
        echo " name=\"erase_autorisation_contestee\"";
        echo " onclick=\"eraseAutorisationContestee();\"";
        echo " class=\"om-button\"";
        echo " />";
    }

    /**
     * Gère l'affichage d'un champ de type "previsualiser".
     *
     * Le champ est initialisé comme un select (setSelect()) et ses paramètres sont
     * stockées dans les valeurs du select. Pour pouvoir récupérer le
     * type du champs, il faut avoir une clé "mimetype" dans les paramétres du select qui
     * a pour valeur le mimetype du fichier issus du filestorage.
     *
     * Le type de champ est ainsi récupéré.
     * Il y a 3 types de champs différents :
     *    pdf : utilisation du pdf viewer du navigateur -> méthode : previsualiser_pdf()
     *    image : affichage de l'image -> méthode : previsualiser_image()
     *    autre : affichage d'un message indiquant que la prévisualisation
     *    n'est pas disponible pour ce type de fichier -> non_previsualisable()
     *
     * @param string id du champ
     * @param integer 0 : le formulaire a été validé sinon 1
     * @param boolean
     *
     * @return void
     */
    protected function previsualiser($champ, $validation, $DEBUG = false) {
        // Récupère le type du champ et renvoie l'affichage correspondant
        if (isset($this->select[$champ]) === true
            && isset($this->select[$champ]['mimetype']) === true) {

            $mimetype = $this->select[$champ]['mimetype'];
            $filetype = substr($mimetype, strpos($mimetype, '/') + 1);
            if ($filetype == 'pdf') {
                $this->previsualiser_pdf($champ, $validation, $DEBUG = false);
            } elseif ($filetype == 'jpeg' ||
                $filetype == 'jpg' ||
                $filetype == 'png' ||
                $filetype == 'gif' ||
                $filetype == 'tiff' ||
                $filetype == 'bitmap'
            ) {
                $this->previsualiser_image($champ, $validation, $DEBUG = false);
            } else {
                $this->non_previsualisable($champ, $validation, $DEBUG = false);
            }
        }
    }

    /**
     * Affiche le contenu d'un PDF dans un iframe.
     *
     * Le champ doit être paramétré comme un champ select (setSelect)
     * avec une clé "base64" et en valeur le contenu du PDF en base 64
     * pour que le PDF puisse être affiché.
     *
     * @param string id du champ
     * @param integer 0 : le formulaire a été validé sinon 1
     * @param boolean
     *
     * @return void
     */
    protected function previsualiser_pdf($champ, $validation, $DEBUG = false) {
        // Récupération du contenu du pdf en base 64 dans les valeurs du select
        $base64 = '';
        if (isset($this->select[$champ]) === true
            && isset($this->select[$champ]['base64']) === true) {
            $base64 = $this->select[$champ]['base64'];
        }
        // Affichage du pdf
        printf(
            '<div id=%1$s></div>
            <script type="text/javascript">
                $(function() {
                    set_jquery_data_var_pdf("%2$s");
                    load_iframe_pdf();
                })
            </script>
            <div id="frame_content"></div>
            <input id="inst_id" type="hidden" value="" />',
            $champ,
            $base64,
            $this->val[$champ]
        );
    }

    /**
     * Affiche un message d'information indiquant que le type de
     * document ne peut être prévisualiser avec un lien permettant
     * de le télécharger.
     *
     * Le champ doit être paramétré comme un champ select (setSelect)
     * avec une clé "href" et en valeur le lien permettant de télécharger
     * la pièce pour que le lien de téléchargement soit fonctionnel.
     *
     * @param string id du champ
     * @param integer 0 : le formulaire a été validé sinon 1
     * @param boolean
     *
     * @return void
     */
    protected function non_previsualisable($champ, $validation, $DEBUG = false) {
        // Récupération du lien de téléchargement de l'image dans les valeurs du select
        $href = '';
        if (isset($this->select[$champ]) === true
            && isset($this->select[$champ]['href']) === true) {
            $href = $this->select[$champ]['href'];
        }
        // Affichage du message de non prévisualisation
        printf(
            '<div id="%1$s">
                <div class="message ui-widget ui-corner-all text-info ui-state-highlight ui-state-info">
                    <p>
                        <span class="ui-icon ui-icon-info"></span>
                        <span class="text">%2$s</span>
                    </p>
                    <a href="%3$s" class="lien-info">
                        <span class="om-icon om-icon-16 om-icon-fix consult-16"></span>
                        %4$s
                    </a>
                </div>
            </div>',
            $champ,
            __('Le format de ce fichier ne permet pas de le prévisualiser.'),
            $href,
            __('Télécharger directement le fichier')
        );
    }

    /**
     * Affiche un message d'information indiquant que le type de
     * document ne peut être prévisualiser avec un lien permettant
     * de le télécharger.
     *
     * Le champ doit être paramétré comme un champ select (setSelect)
     * avec comme valeur le tableau suivant :
     * array(
     *   "base64" => contenu de l'image en base 64,
     *   "mimetype" => mimetype issus du filestorage,
     *   "label" => description de l'image a affiché si l'image ne se charge pas
     * )
     *
     * @param string id du champ
     * @param integer 0 : le formulaire a été validé sinon 1
     * @param boolean
     *
     * @return void
     */
    protected function previsualiser_image($champ, $validation, $DEBUG = false) {
        // Récupération du paramétre dans les valeurs du select
        $base64 = '';
        if (isset($this->select[$champ]) === true
            && isset($this->select[$champ]['base64']) === true) {
            $base64 = $this->select[$champ]['base64'];
        }
        $mimetype = '';
        if (isset($this->select[$champ]) === true
            && isset($this->select[$champ]['mimetype']) === true) {
            $mimetype = $this->select[$champ]['mimetype'];
        }
        $label = '';
        if (isset($this->select[$champ]) === true
            && isset($this->select[$champ]['label']) === true) {
            $label = $this->select[$champ]['label'];
        }
        // Affichage de l'image
        printf(
            '<div id="%1$s"></div>
                <img src="data:%2$s;base64,%3$s" class="previsualise_img" alt="%4$s" />
            <input id="inst_id" type="hidden" value="%5$s"/>',
            $champ,
            $mimetype,
            $base64,
            isset($label) ? $label : '-',
            $this->val[$champ]
        );
    }

    /**
     * SNIPPET_FORM - filterselect.
     *
     * Ce script permet de récupérer les valeurs d'un select pour permettre de filtrer
     * ses valeurs à partir d'une autre valeur sélectionnée. Par exemple filtrer les
     * utilisateurs en fonction de la valeur de profil sélectionnée dans le même formulaire.
     *
     * @return void
     */
    function snippet__filterselect() {
        $this->f->disableLog();

        // Données pour le champ visé
        (isset($_GET['idx']) ? $idx = $_GET['idx'] : $idx = "");
        // Table visée pour la requête
        (isset($_GET['tableName']) ? $tableName = $_GET['tableName'] : $tableName = "");
        // Champs visé pour le tri
        (isset($_GET['linkedField']) ? $linkedField = $_GET['linkedField'] : $linkedField = "");
        // Formulaire visé
        (isset($_GET['formCible']) ? $formCible = $_GET['formCible'] : $formCible = "");

        // Le formulaire visé doit être renseigné
        if ($formCible != '') {
            $champ = array($linkedField);
            $form = $this->f->get_inst__om_formulaire(array(
                "validation" => 0,
                "maj" => 0,
                "champs" => $champ,
            ));

            // Creation d'un objet vide pour pouvoir créer facilement les champs de
            // type select
            $object = $this->f->get_inst__om_dbform(array(
                "obj" => $formCible,
                "idx" => "]",
            ));
            $object->setParameter($linkedField, $idx);
            $object->setSelect($form, 0);

            //
            echo json_encode($form->select[$tableName]);

        }
    }

    /**
     * WIDGET_FORM - httpclickbutton.
     *
     * Bouton avec action sur le clique en JavaScript.
     *
     * @param string $champ Nom du champ
     * @param integer $validation
     * @param boolean $DEBUG Parametre inutilise
     *
     * @return void
     */
    function httpclickbutton($champ, $validation, $DEBUG = false) {
        if (isset($this->select[$champ][0])) {
            $aff = $this->select[$champ][0];
        } else {
            $aff = $champ;
        }
        echo "<a id='".$champ."' class='httpclickbutton' href='#' onclick=\"".$this->val[$champ]."; return false;\" >";
        echo $aff;
        echo "</a>\n";
    }

    /**
     * Surcharge pour deux nouvelles extensions de type:
     *  - '*nolabel': ne pas afficher le libellé
     *  - '*labelafter': afficher le libellé après
     *
     * @param string $champ Nom du champ
     * @param integer $validation
     * @param boolean $DEBUG Parametre inutilise
     * @return void
     */
    function afficherChamp($champ, $validation, $DEBUG = false) {

        // Récupération du type du champ
        if (isset($this->type[$champ])) {
            $type_champ = $this->type[$champ];
        } else {
            $type_champ = "statiq";
        }

        // Ajout du label en lien avec l'id du champ correspondant
        // si le type du champ n'est pas le spécifique 'nodisplay'
        if ($type_champ !== "nodisplay") {

            // *nolabel
            $nolabel = false;
            if (substr($type_champ, -7) == 'nolabel') {
                $nolabel = true;
                $type_champ = substr($type_champ, 0, -7);
                $this->type[$champ] = $type_champ;
            }

            // *labelafter
            $labelafter = false;
            if (substr($type_champ, -10) == 'labelafter') {
                $labelafter = true;
                $type_champ = substr($type_champ, 0, -10);
                $this->type[$champ] = $type_champ;
            }

            // Ouverture du conteneur du champ (libellé et widget)
            $classes = isset($this->classes_specifiques) && ! empty($this->classes_specifiques[$champ]) ?
                $type_champ.' '.$this->classes_specifiques[$champ] :
                $type_champ;
            $this->f->layout->display_formulaire_conteneur_libelle_widget($classes);

            $demat_color = false;
            if ($type_champ == 'text_demat_color' 
                || $type_champ == 'date_demat_color' 
                || $type_champ == 'static_demat_color' 
                || $type_champ == 'datestatic_demat_color'
                || $type_champ == 'checkbox_demat_color') {
                $demat_color = true;
                echo '<div class="demat-color">';
                if ($type_champ == 'static_demat_color') {
                    $type_champ = substr($type_champ, 0, 6);
                } elseif ($type_champ == 'datestatic_demat_color') {
                    $type_champ = substr($type_champ, 0, 10);
                } elseif ($type_champ == 'checkbox_demat_color') {
                    $type_champ = substr($type_champ, 0, 8);
                } else {
                    $type_champ = substr($type_champ, 0, 4);
                }
                $this->type[$champ] = $type_champ;
            }

            if (! $nolabel && ! $labelafter) {
                // Ouverture du conteneur du libellé
                $this->f->layout->display_formulaire_conteneur_libelle_champs();
                echo "          <label for=\"".$champ."\" class=\"libelle-".$champ.
                "\" id=\"lib-".$champ."\">\n";
                echo "            ".$this->lib[$champ].
                (in_array($champ, $this->required_field)? " ".$this->required_tag:"")."\n";
                echo "          </label>\n";
                // Fermeture du conteneur du libellé
                $this->f->layout->display_formulaire_fin_conteneur_champs();
            }

            // Ouverture du conteneur du widget
            $this->f->layout->display_formulaire_conteneur_champs();
            // Affichage du champ en fonction de son type
            $fonction = $type_champ;
            if ($fonction == "static") {
                $fonction = "statiq";
            }
            if (method_exists($this, $fonction)) {
                $this->$fonction($champ, $validation);
            } else {
                $this->statiq($champ, $validation);
            }
            // Fermeture du conteneur du widget
            $this->f->layout->display_formulaire_fin_conteneur_champs();

            if (! $nolabel && $labelafter) {
                // Ouverture du conteneur du libellé
                $this->f->layout->display_formulaire_conteneur_libelle_champs();
                echo "          <label for=\"".$champ."\" class=\"libelle-".$champ.
                "\" id=\"lib-".$champ."\">\n";
                echo "            ".$this->lib[$champ].
                (in_array($champ, $this->required_field)? " ".$this->required_tag:"")."\n";
                echo "          </label>\n";
                // Fermeture du conteneur du libellé
                $this->f->layout->display_formulaire_fin_conteneur_champs();
            }

            // Fermeture du conteneur du champ (libellé et widget)
            $this->f->layout->display_formulaire_fin_conteneur_champs();
            if ($demat_color === true) {
                echo "</div>";
            }
        }
    }

    /**
     * Surcharge pour ajouter la prise en charge de paramètres supplémentaires.
     * En l'occurence, le besoin est de supporter: disabled et readonly.
     */
    function text($champ, $validation, $DEBUG = false, $extra_params = array()) {
        if ($this->val[$champ] != "" 
            && $validation == 0
            && array_key_exists('date', $extra_params) === true
            && $extra_params['date'] === true) {
            //
            $this->val[$champ] = $this->dateAff($this->val[$champ]);
        }
        echo '<input';
        echo ' type="text"';
        echo ' name="'.$champ.'"';
        echo ' id="'.$champ.'"';
        echo ' value="'.$this->val[$champ].'"';
        echo ' size="'.$this->taille[$champ].'"';
        echo ' maxlength="'.$this->max[$champ].'"';
        echo ' class="champFormulaire"';
        if (!$this->correct) {
            if (isset($this->onchange) and $this->onchange[$champ] != "") {
                echo " onchange=\"".$this->onchange[$champ]."\"";
            }
            if (isset($this->onkeyup) and $this->onkeyup[$champ] != "") {
                echo " onkeyup=\"".$this->onkeyup[$champ]."\"";
            }
            if (isset($this->onclick) and $this->onclick[$champ] != "") {
                echo " onclick=\"".$this->onclick[$champ]."\"";
            }
        } else {
            echo " disabled=\"disabled\"";
        }
        foreach($extra_params as $name => $value) {
            echo ' '.$name.'="'.$value.'"';
        }
        echo " />\n";
    }

    /**
     * Surcharge réutilisant le code existant de la fonction text()
     * et permettant de passer des paramètres.
     */
    function textreadonly($champ, $validation, $DEBUG = false) {
        $this->text($champ, $validation, $DEBUG, array('readonly' => 'readonly'));
    }

    /**
     * Surcharge réutilisant le code existant de la fonction text()
     * et permettant de passer des paramètres.
     */
    function datereadonly($champ, $validation, $DEBUG = false) {
        $this->text($champ, $validation, $DEBUG, array('readonly' => 'readonly', 'date' => true));
    }

    /**
     * Surcharge pour ajouter la prise en charge de paramètres supplémentaires.
     * En l'occurence, le besoin est de supporter: disabled et readonly.
     */
    function checkbox($champ, $validation, $DEBUG = false, $extra_params = array()) {
        // valeur et checked
        if ($this->val[$champ] == 1 || $this->val[$champ] == "t"
            || $this->val[$champ] == "Oui") {
            $value = "Oui";
            $checked = " checked=\"checked\"";
        } else {
            $value = "";
            $checked = "";
        }
        // layout html
        echo "<input";
        echo " type=\"checkbox\"";
        echo " name=\"".$champ."\"";
        echo " id=\"".$champ."\" ";
        echo " value=\"".$value."\"";
        echo " size=\"".$this->taille[$champ]."\"";
        echo " maxlength=\"".$this->max[$champ]."\"";
        echo " class=\"champFormulaire\"";
        echo $checked;
        if (!$this->correct) {
            echo " onchange=\"changevaluecheckbox(this);";
            if (isset($this->onchange) and $this->onchange[$champ] != "") {
                echo "".$this->onchange[$champ]."";
            }
            echo "\"";
            if (isset($this->onkeyup) and $this->onkeyup[$champ] != "") {
                echo " onkeyup=\"".$this->onkeyup[$champ]."\"";
            }
            if (isset($this->onclick) and $this->onclick[$champ] != "") {
                echo " onclick=\"".$this->onclick[$champ]."\"";
            }
        } else {
            echo " disabled=\"disabled\"";
        }
        foreach($extra_params as $name => $value) {
            echo ' '.$name.'="'.$value.'"';
        }
        echo " />\n";
    }

    /**
     * Surcharge réutilisant le code existant de la fonction checkbox()
     * et permettant de passer des paramètres.
     */
    function checkboxreadonly($champ, $validation, $DEBUG = false) {
        $this->checkbox($champ, $validation, $DEBUG, array('readonly' => 'readonly'));
    }

    /**
     * WIDGET_FORM - link.
     * 
     * Champ lien vers un enregistrement lié.
     *
     * Configuration du widget via setSelect : array(
     *     "obj" => "objet du formulaire lié",
     *     "idx" => (optionnel) "Identifiant de l'enregistrement lié (si aucune
     *              valeur n'est fournie c'est la valeur du champ dans le
     *              formulaire qui est utilisée)",
     *     "libelle" => (optionnel) "Libellé de la valeur du champ (si aucune
     *                  valeur n'est fourni c'est idx qui est utilisé)",
     *     "right" => (optionnel) "Permissions pour avoir accès au lien",
     * );
     *
     * @param string $champ Nom du champ
     * @param integer $validation
     * @param boolean $DEBUG Parametre inutilise
     */
    function link($champ, $validation, $DEBUG = false) {
        /**
         * Configuration
         */
        $obj = "";
        $idx = "";
        $libelle = "";
        $right = null;
        // Récupération de la configuration du setSelect
        if (is_array($this->select) === true
            && array_key_exists($champ, $this->select) === true
            && is_array($this->select[$champ]) === true) {
            //
            if (array_key_exists("obj", $this->select[$champ]) === true) {
                $obj = $this->select[$champ]["obj"];
            }
            if (array_key_exists("idx", $this->select[$champ]) === true) {
                $idx = $this->select[$champ]["idx"];
            }
            if (array_key_exists("libelle", $this->select[$champ]) === true) {
                $libelle = $this->select[$champ]["libelle"];
            }
            if (array_key_exists("right", $this->select[$champ]) === true) {
                $right = $this->select[$champ]["right"];
            }
            if (array_key_exists("title", $this->select[$champ]) === true) {
                $title = $this->select[$champ]["title"];
            }
        }
        // Aucun identifiant fourni dans le setSelect donc on ressaye de
        // récupérer la valeur du champ présente dans le formulaire
        if ($idx === ""
            && is_array($this->val) === true
            && array_key_exists($champ, $this->val) === true) {
            //
            $idx = $this->val[$champ];
        }
        // Aucun libellé fourni dans le setSelect donc on y affecte la
        // valeur de l'identifiant de l'élément lié
        if ($libelle === "") {
            $libelle = $idx;
        }
        /**
         * Affiche la value dans un champ hidden pour être postée par le form
         */
        $this->setType($champ, "hidden");
        $this->hidden($champ, $validation, $DEBUG);
        /**
         * Affichage soit du lien soit du libellé soit rien :
         * - le lien est affiché si tous les paramètres sont correctement
         *   configurés et que l'utilisateur a les permissions,
         * - sinon si un libellé est configuré c'est le libellé qui est affiché,
         * - sinon on affiche rien.
         */
        if ($idx !== ""
            && $obj !== ""
            && $libelle !== ""
            && ($right == null
                || $this->f->isAccredited($right) === true)) {
            //
            printf(
                '<a id="link_%1$s" class="lienFormulaire" title="%4$s" href="%2$s">%3$s</a>',
                $champ,
                sprintf(
                    '%1$s&obj=%2$s&action=3&idx=%3$s',
                    OM_ROUTE_FORM,
                    $obj,
                    $idx
                ),
                $libelle,
                $title

            );
        } elseif ($libelle !== "") {
            printf(
                '<span id="link_%1$s_inactif" class="field_value">%2$s</span>',
                $champ,
                $libelle
            );
        }
    }


    /**
     * Permet d'afficher le résultat d'un champ en "json pretty", la balise <pre> est necessaire
     * Le résultat mis dans le champ doit être converti avec la fonction json_encode()
     * avec comme paramètre JSON_PRETTY_PRINT
     */
    function jsonprettyprint($champ, $validation, $DEBUG = false) {
        //
        echo '<pre id="'.$champ.'">';
        echo $this->val[$champ];
        echo '</pre>';
    }


    /**
     * Permet d'afficher sous forme de tableau le résultat d'un champ en "json".
     */
    function jsontotab($champ, $validation, $DEBUG = false) {

        $values_tab = json_decode(str_replace("'", '"', $this->val[$champ]), true);
        if ($values_tab === null) {
            $values_tab = json_decode($this->val[$champ], true);
        }
        
        // Si le décodage du json à échoué ou qu'il est vide le tableau n'a pas a être affiché
        if ($values_tab === false || empty($values_tab)) {
            echo __("Aucun enregistrement.");
            return;
        }
        
        // Initialisation d'un tableau qui contiendra les valeurs
        $data_tab = array();

        // Récupération des colonnes de la première ligne
        $columns_tab = array_keys($values_tab[0]);

        // Rend les colonnes traduisibles
        $columns = '[';
        foreach ($columns_tab as $key => $value) {
            if ($value == 'annexes' 
            || $value == 'state'
            || $value == 'prev_state'
            || $value == 'contexte' ) {
                $columns .= ", {
                    'name' : '".__($value)."',
                    'formatter': function (cell) { return gridjs.html(cell);}
                }";
            }
            else {
                $columns_tab[$key] = __($value);
                $columns .= $columns != '[' ? ', '.json_encode($columns_tab[$key], JSON_UNESCAPED_SLASHES):
                json_encode($columns_tab[$key], JSON_UNESCAPED_SLASHES);
            }
        }
        $columns .= ']';

        // Récupération des valeurs sans les colonnes
        foreach ($values_tab as $value) {
            $data_tab[] = array_values($value);
        }
        
        // Conversion des tableaux en json
        
        //$columns = json_encode($columns_tab, JSON_UNESCAPED_SLASHES);
        $data = json_encode($data_tab, JSON_UNESCAPED_SLASHES);

        // On appel la fonction js en lui passant en paramètre les colonnes et les données du tableau
        echo '<div id="'.$champ.'_jsontotab"></div>
            <script type="text/javascript">
                $(function() {
                    init_view_jsontotab("'.$champ.'", '.$columns.', '.$data.');
                });
            </script>';
    }

    /**
     * Mutateur pour la propriété 'onchange'.
     *
     * @param string $champ
     * @param string $contenu
     * @param string $position  vaut 'append' pour insérer à la fin, 'prepend' pour insérer au début
     *
     * @return void
     */
    function addOnchange($champ, $contenu, $position = 'append') {
        if ($position = 'append') {
            $this->onchange[$champ] .= ';'.$contenu;
        }
        elseif ($position = 'prepend') {
            $this->onchange[$champ] = $contenu .';'. $this->onchange[$champ];
        }
    }

    /**
     * SURCHARGE
     *
     * Mutateur pour la propriété 'lib'.
     *
     * @param string $champ
     * @param string $contenu
     * @return void
     */
    function setLib($champ, $contenu) {
        parent::setLib($champ, $contenu);

        // Renomme la collectivité en service
        if ($champ === 'om_collectivite'
            && $contenu === __('om_collectivite')
            && $this->f->is_option_renommer_collectivite_enabled() === true) {
            //
            $this->lib[$champ] = __("service");
        }
    }


    /**
     * WIDGET_FORM - textareahidden.
     *
     * Surcharge de textarea permettant (à l'aide du css) d'avoir
     * un textarea non visible (hidden) sur la page.
     *
     * @param string $champ Nom du champ
     * @param integer $validation
     * @param boolean $DEBUG Parametre inutilise
     *
     * @return void
     */
    function textareahidden($champ, $validation, $DEBUG = false) {
        $this->textarea($champ, $validation, $DEBUG = false);
    }

    /**
     * Création d'un input pour choisir une couleur
     *
     * @param string   $champ      Nom du champ
     * @param integer  $validation 
     * @param boolean  $DEBUG      Paramètre inutilisé
     */
    function color($champ, $validation, $DEBUG = false) {

        // Inclusion de JSColor
        $this->f->addHTMLHeadJs("../app/lib/jscolor/jscolor.js");
        // Affiche l'input
        echo "<input";
        echo " type=\"text\"";
        echo " id=\"".$champ."\"";
        echo " size=\"6\"";
        echo " maxlength=\"6\"";
        echo " name=\"".$champ."\"";
        echo " value=\"".$this->val[$champ]."\"";
        echo " class=\"champFormulaire color\"";
        echo " />\n";  
    }

    /**
     * WIDGET_FORM - select.
     *
     * SELECT - Affiche un select.
     *
     * Les informations permettant de construire le select sont récupérées des attributs suivant :
     *   - $this->onchange[$champs] -> attribut onchange à intégrer dans le html du select
     *   - $this->select[$champs]   -> tableau des données à afficher dans le select
     *   - $this->correct           -> ???
     *   - $this->val[$champs]      -> valeur actuelle du champs qui permet de savoir si une option
     *                                 dois être marquée comme sélectionnée
     *
     * @param string $champ Nom du champ
     * @param integer $validation
     * @param boolean $DEBUG Parametre inutilise
     *
     * @return void
     */
    function select($champ, $validation, $DEBUG = false) {
        if (! $this->correct) {
            if (! empty($this->onchange[$champ])) {
                printf(
                    '<select name="%1$s" id="%1$s" size="1" onchange="%2$s" class="champFormulaire">',
                    $champ,
                    $this->onchange[$champ]
                );
            } else {
                $this->f->layout->display_formulaire_select_personnalise(array("champ" => $champ));
            }
        } else {
            printf(
                '<select name="%1$s" id="%1$s" size="1" class="champFormulaire" disabled="disabled">',
                $champ
            );
        }

        // Le tableau des données du select est composé de cette manière :
        //    array(
        //        0 => array(                 -> liste des valeurs du select
        //                 1 => 'val_1,
        //                 ...,
        //                 n => array(         -> si il y a un groupe contiens les labels et les valeurs du groupe ordonné comme le select
        //                    0 => array(...), -> liste des valeurs du groupe
        //                    1 => array(...)  -> liste des labels du groupe
        //                 ),
        //             )
        //        1 => array(                  -> liste des labels
        //                 1 => 'label_1',
        //                 ...,
        //                 n => 'label_group'  -> label qui sera attribué au groupe
        //    )

        // Affichage des options.
        // Parcours le tableau des valeurs en utilisant un index dont la limite est le nombre
        // de valeurs contenues dans les données à afficher.
        // Pour chaque ligne, vérifie si il s'agit d'un groupe en testant le tableau des
        // valeur pour vérifier si l'entrée contiens un tableau.
        // Si il s'agit d'un groupe, affiche le nom du groupe à partir du label correspondant et
        // affiche chacune des options du groupe.
        // Si ce n'est pas le cas affiche l'option correspondant à la ligne.
        $nb_options = count($this->select[$champ][0]);
        // Ces deux variables servent uniquement à rendre le code plus compréhensible
        $values = $this->select[$champ][0];
        $labels = $this->select[$champ][1];
        for ($i = 0; $i < $nb_options; $i++) {
            // Si la "valeur" de la ligne est un tableau c'est qu'il s'agit d'un groupe
            if (is_array($values[$i])) {
                // Ouverture de la balise du groupe
                printf('<optgroup label="%s">', $labels[$i]);
                $nb_options_groupe = count($values[$i][0]);
                // Ces deux variables servent uniquement à rendre le code plus compréhensible
                $group_values = $values[$i][0];
                $group_labels = $values[$i][1];
                // Remplissage des options du groupe.
                for ($index_group = 0; $index_group < $nb_options_groupe; $index_group++) {
                    $this->print_select_option(
                        $group_values[$index_group],
                        $group_labels[$index_group],
                        $this->val[$champ] == $group_values[$index_group]
                    );
                }
                // Fermeture de la balise du gorupe et passage à la ligne suivante
                printf('</optgroup>');
                continue;
            }
            // Remplissage de l'option
            $this->print_select_option(
                $values[$i],
                $labels[$i],
                $this->val[$champ] == $values[$i]
            );
        }

        echo "</select>";
    }

    /**
     * Affiche une option d'un select.
     *
     * @param string valeur attribuer à l'option
     * @param string nom de l'option
     * @param boolean indique si l'option est sélectionnée ou pas
     */
    protected function print_select_option(string $value, string $label, $is_selected = false) {
        printf(
            '<option %s value="%s">
                %s
            </option>',
            ($is_selected ? 'selected="selected"' : ''),
            $value,
            $label
        );
    }
}
