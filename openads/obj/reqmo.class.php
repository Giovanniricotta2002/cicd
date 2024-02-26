<?php
/**
 * Ce script permet de définir la classe 'reqmo'.
 *
 * @package openads
 * @version SVN : $Id: reqmo.class.php 6046 2016-02-26 15:27:06Z fmichon $
 */

/**
 * Classe permettant de factoriser la génération du rendu des requêtes mémorisées
 *
 * Requêteur
 * principe de REQMO (requête memorisée):
 * permet de faire des requêtes memorisées
 * la requête est paramétrée en sql/typedebase/langue/obj.reqmo.inc.php
 * $reqmo['sql'] = requête paramétrable
 * les paramètres sont entre crochets
 * type de paramètre  = $reqmo['parametre']
 *  checked : case à cocher pour que la zone soit prise en compte
 *  liste : liste de valeur proposé pour paramétrer une sélection ou un tri
 *  select : liste de valeur proposé pour paramétrer une sélection ou un tri 
 *           d'après une requête dans une table
 * $reqmo['libelle'] = libéllé de la requête
 * $reqmo['separateur'] = séparateur pour fichier csv
 */
class reqmo {

    // utils
    var $f = "";

    // Liste des fichiers reqmo
    var $tab_reqmo = array();

    // Type de rendu
    var $sortie = "";

    var $info;

    var $obj;

    var $extension;

    function __construct($f, $obj, $extension = "reqmo") {
        $this->f = $f;
        $this->obj = $obj;
        $this->extension = $extension;
    }// fin constructeur

    private function getReqmoFile() {
        $dir = getcwd();
        $dir = substr($dir, 0, strlen($dir) - 4)."/sql/".OM_DB_PHPTYPE."/";
        $dossier = opendir($dir);
        while ($entree = readdir($dossier)) {
            if (strstr($entree, $this->extension)) {
                
                // Si l'extention du fichier $entree est .inc.php
                if (strpos($entree, ".inc.php")) {
                    $filext = strlen($this->extension)+9;
                }
                // Sinon on considere qu'elle est -> .inc (compatibilite)
                else {
                    $filext = strlen($this->extension)+5;
                }
                
                array_push($this->tab_reqmo, 
                    array('file' => substr($entree, 0, strlen($entree) - $filext)));
            }
        }
        closedir($dossier);
        asort($this->tab_reqmo);

        return $this->tab_reqmo;
    }

    function displayReqmoList($url = "requeteur.php") {
        $this->getReqmoFile();
        echo "\n<div id=\"".$this->extension."\">\n";
        //
        echo "<fieldset class=\"cadre ui-corner-all ui-widget-content\">\n";
        //
        echo "\t<legend class=\"ui-corner-all ui-widget-content ui-state-active\">";
        echo _("Choix de la requete memorisee");
        echo "</legend>\n";
        //
        echo "\t<div class=\"list\">\n";
        if (count($this->tab_reqmo) == 0) {
            echo "<p>";
            echo _("Il n'y a aucun element de ce type dans l'application.");
            echo "</p>";
        }
        //
        $this->f->layout->display_start_liste_responsive();
        //
        $nbr_elements=0;
        foreach ($this->tab_reqmo as $elem) {
            $nbr_elements=$nbr_elements+1;
            $this->f->layout->display_start_block_liste_responsive($nbr_elements);
            echo "<span>\n";
            //
            $params = array(
            "file" => $elem['file']
            );
            // XXX passe plus par le layout dans le cas ou l'url est passée en paramètre
            // $this->f->layout->display_reqmo_lien($params);
            echo "<a ";
            echo " class=\"om-prev-icon reqmo-16\" href=\"".$url."?obj=".$params['file']."\">";
            echo _($params['file']);
            echo "</a>";

            echo "</span>\n";
            $this->f->layout->display_close_block_liste_responsive();
            //
        }
        $this->f->layout->display_close_liste_responsive(); 
        echo "\t</div>\n";
        //
        echo "</fieldset>\n";
        //
        echo "</div>\n";

    }

    /**
     * Ouverture du conteneur de contenu
     * @return [type] [description]
     */
    private function openContent() {
        /**
        * Ouverture du conteneur de la page
        */
        //
        echo "\n<div id=\"generator-generate\">\n";
        //
        echo "<div id=\"formulaire\">\n\n";
        //
        $this->f->layout->display_start_navbar();
        echo "<ul>\n";
        if (isset($reqmo["reqmo_libelle"])) {
            echo "\t<li><a href=\"#tabs-1\">".
            _("Export de : ").
            _($reqmo["reqmo_libelle"])."</a></li>\n";
        } elseif (isset($reqmo["libelle"])) {
            echo "\t<li><a href=\"#tabs-1\">".
            _("Export de : ").
            _($reqmo["libelle"])."</a></li>\n";
        } else {
            echo "\t<li><a href=\"#tabs-1\">".
            _("Export de : ")._($this->obj).
            "</a></li>\n";
        }
        echo "</ul>\n";
        //
        $this->f->layout->display_stop_navbar();    
        echo "\n<div id=\"tabs-1\">\n";
    }

    /**
     * Affichage du formulaire de la requête mémorisée
     * @param  [type] $validation [description]
     * @return [type]             [description]
     */
    function displayForm(
        $validation,
        $urlRequet = "requeteur.php",
        $urlRetour = OM_ROUTE_MODULE_REQMO, $error = false) {

        $this->openContent();
        /**
        * Ouverture du formulaire
        */
        // Ouverture de la balise formulaire
        echo "<form method=\"post\" action=\"".$urlRequet."?obj=".$this->obj.
        "&amp;step=1\" name=\"f1\">\n";
        $param["obj"]=$this->obj;
        $param["db"]= $this->f->db;
        $param["validation"]=$validation;
        $param["cptemp"]= 0;
        $param["cpts"]=0;
        $param["cptsel"]=0;
        $param["extension"]=$this->extension;
        $param["error"]=$error;
        // XXX Plus possible d'utiliser cette méthode
        // $this->f->layout->display_requeteur_formulaire($param, $this->f);
        $this->display_requeteur_formulaire($param, $this->f);
        //
        // Affichage des actions de controles du formulaire
        echo "<div class=\"formControls\">";
        // Bouton de validation du formulaire
        $param["input"]="<input type=\"submit\" name=\"valid.reqmo\" value=\"".
        _("Executer la requete sur :")." '"._($this->obj)."'\" />";
        $this->f->layout->display_input($param);
        // Lien retour
        // XXX Plus possible
        $param["lien"]="<a href=\"".$urlRetour."\" class=\"retour\">"._("Retour")."</a>";
        $this->f->layout->display_lien_retour($param);
        // Fermeture du conteneur des actions de controles du formulaire
        echo "</div>";
        // Fermeture de la balise formulaire
        echo "\n</form>\n";
        $this->closeContent();
    }

    /**
     * Fermeture du conteneur de contenu
     * @return [type] [description]
     */
    private function displayBoutonRetour($url) {
        // Affichage des actions de controles du formulaire
        echo "<div class=\"formControls\">";
        // Lien retour
        $param["lien"]="<a  href=\"".$url."?obj=".$this->obj.
        "&amp;step=0\" class=\"retour\">"._("Retour")."</a>";
        $this->f->layout->display_lien_retour($param);           
        // Fermeture du conteneur des actions de controles du formulaire
        echo "</div>";
    }

    /**
     * Fermeture du conteneur de contenu
     * @return [type] [description]
     */
    private function closeContent() {
        //
        echo "</div>\n";
        //
        echo "</div>\n";
        //
        echo "</div>\n";
    }

    function prepareRequest($reqmo) {
        // Gestion éventuelle du multi-collectivités
        if (strpos($reqmo['sql'], 'IN (<idx_collectivite>)') !== false) {
            // Par défaut comportement mono
            $idx_collectivite = $_SESSION['collectivite'];
            // Si utilisateur multi
            if ($this->f->has_collectivite_multi() === true) {
                $idx_collectivite = $this->f->get_list_id_collectivites();
                // si échec
                if ($idx_collectivite === false) {
                    return _("Erreur de base de donnees. Contactez votre administrateur.");
                }
            }
            // Remplacement
            $reqmo['sql']=str_replace('<idx_collectivite>', $idx_collectivite, $reqmo['sql']);
        }

        // Remplace la chaîne de caractère par la valeur du paramètre du même
        // nom
        if (strpos($reqmo['sql'], '<id_datd_filtre_reqmo_dossier_dia>') !== false) {
            //
            $reqmo['sql'] = str_replace('<id_datd_filtre_reqmo_dossier_dia>', $this->f->getParameter('id_datd_filtre_reqmo_dossier_dia'), $reqmo['sql']);
        }

        // Variable qui sert à vérifier qu'au moins un des critères a été sélectionné
        $checked = false;
        $hasCritere = false;
        //
        $temp = explode ("[", $reqmo["sql"]);
        for($i = 1; $i < count($temp); $i++) {
            $temp1 = explode ("]", $temp [$i]);
            $temp4 = explode (" as ", $temp1 [0]);
            if (isset ($temp4 [1])) {
                $temp5 = $temp4 [1]; // uniquement as
            } else {
                $temp5 = $temp1 [0]; // en entier
            }

            if ($this->f->get_submitted_post_value($temp5) !== null && 
                $this->f->get_submitted_post_value($temp5) !== '') {
                $temp2 = $this->f->get_submitted_post_value($temp5);
            } elseif (isset($reqmo['required'][$temp1[0]])
                && $reqmo['required'][$temp1[0]] === false
                && isset($reqmo['default'][$temp1[0]])) {
                // récupération de l'éventuel défaut
                $temp2 = $reqmo['default'][$temp1[0]];
            } else {
                $temp2 = "";
            }
            // ****
            if(isset($reqmo[$temp5])){
                if($reqmo[$temp5]=="checked") {
                    $hasCritere = true;
                    if ($this->f->get_submitted_post_value($temp5) == 'Oui'||
                        $this->f->get_submitted_post_value($temp5) === '') {
                        $reqmo ['sql'] = str_replace ("[".$temp1[0]."]",
                            $temp1[0],
                            $reqmo['sql']);
                        //
                        $checked=true;
                    } else {
                        $reqmo['sql']=str_replace("[".$temp1[0]."],",
                            '',
                            $reqmo['sql']);
                        $reqmo['sql']=str_replace(",[".$temp1[0]."]",
                            '',
                            $reqmo['sql']);
                        $reqmo['sql']=str_replace(", [".$temp1[0]."]",
                            '',
                            $reqmo['sql']);
                        $reqmo['sql']=str_replace("[".$temp1[0]."]",
                            '',
                            $reqmo['sql']);
                    }
                } else {
                    if ($temp2=="") return _("Veuillez saisir toutes les valeurs du formulaire.");
                    elseif (!$this->hasType($temp2, $reqmo['type'][$temp1[0]])) return _("Veuillez saisir les valeurs au bon format.");
                    $reqmo['sql']=str_replace("[".$temp1[0]."]",
                        $temp2,
                        $reqmo['sql']);
                }
                //****
            } else {
                if ($temp2=="") return _("Veuillez saisir toutes les valeurs du formulaire.");
                elseif (!$this->hasType($temp2, $reqmo['type'][$temp1[0]])) return _("Veuillez saisir les valeurs au bon format.");
                $reqmo['sql']=str_replace("[".$temp1[0]."]",
                    $temp2,
                    $reqmo['sql']);
            }
            //****
            $temp1[0]="";
        }
        //
        if (!$checked&&$hasCritere) return _("Veuillez choisir au moins un critère.");
        //
        $blanc = 0;
        $temp = "";
        for($i=0;$i<strlen($reqmo['sql']);$i++) {
            if (substr($reqmo['sql'], $i, 1)==chr(13) or
                substr($reqmo['sql'], $i, 1)==chr(10) or
                substr($reqmo['sql'], $i, 1)==chr(32)) {
                if ($blanc==0){
                    $temp=$temp.chr(32);
                }
                $blanc=1;
            } else {
                $temp=$temp.substr($reqmo['sql'],$i,1);
                $blanc=0;
            }
        }
        $reqmo['sql']=$temp ;
        $reqmo['sql']=str_replace(',,', ',', $reqmo['sql']);
        $reqmo['sql']=str_replace(', ,', ',', $reqmo['sql']);
        $reqmo['sql']=str_replace(', from', ' from', $reqmo['sql']);
        $reqmo['sql']=str_replace(', FROM', ' FROM', $reqmo['sql']);
        $reqmo['sql']=str_replace('select ,', 'select ', $reqmo['sql']);
        $reqmo['sql']=str_replace('SELECT ,', 'SELECT ', $reqmo['sql']);
        // post limite
        if ($this->f->get_submitted_post_value('limite') !== null) {
            $limite = $this->f->get_submitted_post_value('limite');
        } else {
            $limite = 100;
        }
        // post  sortie
        if ($this->f->get_submitted_post_value('sortie') !== null) {
            $sortie= $this->f->get_submitted_post_value('sortie');
        } else {
            $sortie ='tableau';
        }
        //
        if($sortie =='tableau'&&!is_numeric($limite)){
            return _("Veuillez saisir une valeur numérique pour le nombre limite d'enregistrement à afficher.");
        }
        // limite uniquement pour tableau
        if ($sortie =='tableau') {
            $reqmo['sql']= $reqmo['sql']." limit ".$limite;
        }
        // s'il y a des conditions à supprimer
        if (isset($reqmo['conditions_to_delete'])
            && is_array($reqmo['conditions_to_delete'])) {
            // on supprime chacune que l'on trouve
            foreach ($reqmo['conditions_to_delete'] as $condition) {
                $condition = trim($condition);
                if (strpos($reqmo['sql'], $condition) !== false) {
                    $reqmo['sql']=str_replace($condition, '', $reqmo['sql']);
                }
            }
        }
        $this->reqmo = $reqmo;
        return true;
    }

    function displayTable($url = "requeteur.php") {
        // execution de la requete
        $qres = $this->f->get_all_results_from_db_query(
            $this->reqmo['sql'],
            array(
                "origin" => __METHOD__,
                "get_columns_name" => true,
                "mode" => DB_FETCHMODE_ORDERED
            )
        );

        $this->info = $qres['columns_name'];
        //
        echo "&nbsp;";
        $param['class']="tab";
        $param['idcolumntoggle']="requeteur";
        $this->f->layout->display_table_start($param);
        //echo "<table class=\"tab-tab\">\n";
        //
        echo "<thead><tr class=\"ui-tabs-nav ui-accordion ui-state-default tab-title\">";
        $key=0;
        foreach($this->info as $elem) {
            $param = array(
                "key" => $key,
                "info" => $this->info
            );
            $this->f->layout->display_table_cellule_entete_colonnes($param);
            echo "<center>"._($elem)."</center></th>";
            $key=$key+1;
        }
        echo "</tr></thead>\n";
        //
        $cptenr = 0;
        foreach($qres['result'] as $row) {
            //
            echo "<tr class=\"tab-data ".($cptenr % 2 == 0 ? "odd" : "even")."\">\n";
            //
            $cptenr = $cptenr + 1;
            $i = 0;
            foreach ($row as $elem) {
                if (is_numeric($elem)) {
                    echo "<td   class='resultrequete' align='right'>";
                } else {
                    echo "<td  class='resultrequete'>";
                }
                $tmp="";
                $tmp=str_replace(chr(13).chr(10), '<br>', $elem);
                echo $tmp."</td>";
                $i++;
            }
            echo "</tr>\n";
        }
        //
        echo "</tbody></table>\n";
        if ($cptenr==0){
            echo "<br>"._('aucun')."&nbsp;"._('enregistrement')."<br>";
        }
        $this->displayBoutonRetour($url);
    }

    function displayCSV($separateur, $url = "requeteur.php") {

        // execution de la requete
        $qres = $this->f->get_all_results_from_db_query(
            $this->reqmo['sql'],
            array(
                "origin" => __METHOD__,
                "get_columns_name" => true,
                "mode" => DB_FETCHMODE_ORDERED
            )
        );
        $this->info = $qres['columns_name'];
        $inf="";
        foreach ($this->info as $elem) {
            $inf=$inf.$elem.$separateur;
        }
        $inf .= "\n";
        $cptenr=0;
        foreach($qres['result'] as $row) {
            $cptenr=$cptenr+1;
            $i=0;
            foreach($row as $elem) {
                //****
                $tmp="";
                $tmp=str_replace(chr(13).chr(10), ' / ', $elem);
                $tmp=str_replace(';', ' ', $tmp);
                //*****
                $inf .= '"'.$tmp.'"'.$separateur;
                $i++;
            }
            $inf .= "\n";
        }
        if ($cptenr==0){
            $inf .="\n"._('aucun')."&nbsp;"._('enregistrement')."\n";
        }

        /**
         * Écriture de l'export dans un fichier sur le disque et affichage du 
         * lien de téléchargement.
         */
        // Composition du nom du fichier
        $nom_fichier = "export_".$this->obj.".csv";
        // Composition des métadonnées du fichier
        $metadata_fichier = array(
            "filename" => $nom_fichier,
            "size" => strlen($inf),
            "mimetype" => "text/csv",
        );
        // Écriture du fichier
        $uid_fichier = $this->f->storage->create_temporary($inf, $metadata_fichier);
        //
        echo  _("Le fichier a ete exporte, vous pouvez l'ouvrir immediatement en cliquant sur : ");
        $msg = "<a class=\"om-prev-icon trace-16\" href=\"../app/index.php?module=form&snippet=file&uid=".$uid_fichier."&amp;mode=temporary\" target=\"_blank\">";
        $msg .= _("Telecharger le fichier")." [".$nom_fichier."]";
        $msg .= "</a>";
        //
        $param['lien']=$msg;
        $this->f->layout->display_lien($param);
        $msg .= "<br />";
        $this->displayBoutonRetour($url);
    }

    function displayPDF($url = "requeteur.php") {
        require_once PATH_OPENMAIRIE."fpdf_etat.php";
        $pdf = new PDF($this->reqmo['om_sousetat_orientation'], "mm", $this->reqmo['om_sousetat_format'],
                true,
                'UTF-8');
            $pdf->setPrintHeader(false);
        // Affichage de la mention Page X/X en pied de page
        $pdf->startPageGroup();
        $pdf->set_footer(array(
            "offset" => 12,
            "html" => sprintf(
                '<p style="text-align:center;font-size:8pt;"><em>Page %s/%s</em></p>',
                $pdf->getPageNumGroupAlias(),
                $pdf->getPageGroupAlias()
            ),
        ));
        // Ajoute une nouvelle page à l'édition
        $pdf->AddPage();
        // On récupère l'enregistrement 'om_sousetat' de la collectivité en cours dans
        // l'état 'actif'
        $niveau = $_SESSION['niveau'];
        $sql = sprintf(
            'SELECT
                *
            FROM
                %1$som_sousetat
            WHERE
                id = \'%2$s\'
                AND actif IS TRUE
                AND om_collectivite = \'%3$d\'',
            DB_PREFIXE,
            $this->f->db->escapeSimple($this->reqmo["om_sousetat"]),
            intval($_SESSION['collectivite'])
        );
        $qres2 = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                'origin' => __METHOD__
            )
        );
        // Si on obtient aucun résultat
        if ($qres2['row_count'] == 0) {
            //
            if ($niveau == "") {
                // On récupère l'identifiant de la collectivité de niveau 2
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            om_collectivite
                        FROM
                            %1$som_collectivite
                        WHERE
                            niveau = \'2\'',
                        DB_PREFIXE
                    ),
                    array(
                        "origin" => __METHOD__,
                    )
                );
                $niveau = $qres["result"];
            }
            // On récupère l'enregistrement 'om_sousetat' de la collectivité de niveau
            // 2 dans l'état 'actif'
            $sql = sprintf(
                'SELECT
                    *
                FROM
                    %1$som_sousetat
                WHERE
                    id = \'%2$s\'
                    AND actif IS TRUE
                    AND om_collectivite = \'%3$d\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->reqmo["om_sousetat"]),
                intval($niveau)
            );
            $qres2 = $this->f->get_all_results_from_db_query(
                $sql,
                array(
                    'origin' => __METHOD__
                )
            );
            // Si on obtient aucun résultat
            if ($qres2['row_count'] == 0) {
                // On récupère l'enregistrement 'om_sousetat' de la collectivité de
                // niveau 2 dans n'importe quel état
                $sql = sprintf(
                    'SELECT
                        *
                    FROM
                        %1$som_sousetat
                    WHERE
                        id = \'%2$s\'
                        AND om_collectivite = \'%3$d\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($this->reqmo["om_sousetat"]),
                    intval($niveau)
                );
                $qres2 = $this->f->get_all_results_from_db_query(
                    $sql,
                    array(
                        'origin' => __METHOD__
                    )
                );
            }
        }

//
        foreach($qres2['result'] as $sousetat) {
            $idx = "";
            $_GET['idx'] = "";
            //
            $titre = '';
            $titre = $sousetat['titre'];
            $titre = str_replace("&aujourdhui", date('d/m/Y'), $titre);
            $collectivite = isset($collectivite)&&$collectivite != array()?
            $collectivite:
            $this->f->getCollectivite();
            if (isset($collectivite) && $collectivite != array()) {
                //
                foreach (array_keys($collectivite) as $elem) {
                    //
                    if (is_array($collectivite[$elem]) === false) {
                        $temp = "&".$elem;
                        $titre = str_replace($temp, $collectivite[$elem], $titre);
                        $sql = str_replace($temp, $collectivite[$elem], $sql);
                        if ( strstr($elem, "ged_") === false && strstr($elem, "erp_") === false 
                            && strstr($elem, "id_") === false && strstr($elem, "sig_") === false
                            && strstr($elem, "option_") === false ) {
                            $champs_remplacement_etat[] = "&amp;".$elem;
                        }
                    }
                }
            }  
            //Date au format jour_de_la_semaine jour_du_mois mois_de_l'année
            //Ex. Lundi 12 Mars
            $jourSemaine = array(_('Dimanche'),_('Lundi'),_('Mardi'),_('Mercredi'),_('Jeudi'),
                _('Vendredi'),_('Samedi'));
            $moisAnnee = array(_('Janvier'),_('Fevrier'),_('Mars'),_('Avril'),_('Mai'),
                _('Juin'),_('Juillet'),_('Aout'),_('Septembre'),_('Octobre'),_('Novembre')
                ,_('Decembre'));
            $titre=str_replace("&jourSemaine",$jourSemaine[date('w')]." ".date('d')." ".$moisAnnee[date('n')-1]." ".date('Y'),$titre);
            $sousetat['titre'] = $titre;
            $sousetat['om_sql'] = $this->reqmo['sql'];
            // imprime  les colonnes de la requete
            $edition = array(
                'se_font' => 'helvetica',
                'se_couleurtexte' => array(0,0,0)
                );
            $pdf->sousetatdb($this->f->db, $edition, $sousetat);
        }
        
        // Construction du nom du fichier
        $filename = date("Ymd-His");
        $filename .= "-reqmo";
        $filename .= "-".$this->obj;
        $filename .= ".pdf";
        $contenu = $pdf->Output($filename, "S");

        // Métadonnées du fichier csv résultat
        $metadata['filename'] = $filename;
        $metadata['size'] = strlen($contenu);
        $metadata['mimetype'] = "application/pdf";
        // Création du fichier sur le storage temporaire
        $pdf_res_uid = $this->f->storage->create_temporary($contenu, $metadata);
        // Affichage du message d'erreur ou de validation
        if($pdf_res_uid === "OP_FAILURE" ){
            $this->f->addToMessage("error", _("Erreur de configuration. Contactez votre administrateur."));
        } else {
            $msg =  _("Le fichier a ete exporte, vous pouvez l'ouvrir immediatement en cliquant sur : ");
            $msg .= "<a class='bold' target='_blanc' href=\"../app/index.php?module=form&snippet=file&uid=".$pdf_res_uid."&mode=temporary\">";
            $msg .= _("Telecharger le fichier")." [".$filename."]";
            $msg .= "</a>";
            $this->f->addToMessage("ok", $msg);
        }
        $this->f->displayMessages();
        //
        echo "<br />";
        $this->displayBoutonRetour($url);
    }

    public function display_requeteur_formulaire($param,$f) {
        //  
        //   requeteur formulaire
        //
        $db=$param["db"];
        $extension = $param["extension"];
        if (file_exists ("../sql/".OM_DB_PHPTYPE."/".$this->obj.".".$extension.".inc.php")) {
            include ("../sql/".OM_DB_PHPTYPE."/".$this->obj.".".$extension.".inc.php");
         }
         elseif (file_exists ("../sql/".OM_DB_PHPTYPE."/".$this->obj.".".$extension.".inc")) {
            include ("../sql/".OM_DB_PHPTYPE."/".$this->obj.".".$extension.".inc");
         }
        $validation = $param["validation"];
        $cptemp = $param["cptemp"];
        $cpts=$param["cpts"];
        $cptsel=$param["cptsel"];
        $error = $param["error"];
        echo "<table cellpadding=\"0\" class=\"formEntete ui-corner-all\">\n";
        //
        if ($error !== false){
            $this->f->displayMessage("error", $error);
        }
        echo "<tr><td colspan=\"2\">";
        //
        echo "<fieldset class=\"cadre ui-corner-all ui-widget-content\">\n";
        //
        echo "\t<legend class=\"ui-corner-all ui-widget-content ui-state-active\">";
        echo _("Criteres de la requete");
        echo "</legend>\n";
        //
        echo "<table>";
        // On separe tous les champs entre crochets dans la requête
        $temp = explode ("[", $reqmo["sql"]);
        //
        for ($i = 1; $i < sizeof($temp); $i++) {
            // On vire le crochet de la fin
            $temp1 = explode("]", $temp[$i]);
            // On check si alias
            $temp4 = explode (" as ", $temp1[0]);
            if (isset($temp4[1])) {
                $temp1[0] = $temp4[1];
            }
            //
            $temp6 = $temp1[0];

            if (!isset($reqmo[$temp1[0]])) {
                // saisie criteres where
                //
                if ($cpts == 0) {
                    echo "<tr>\n";
                } elseif ($cpts == 4) {
                    echo "</tr>\n<tr>\n";
                    $cpts = 0;
                }
                //
                echo "\t<td class=\"tri\">";
                echo "&nbsp;"._($temp6)."&nbsp;<input type=\"text\" name=\"".$temp1[0]."\" value=\"\" size=\"30\" class=\"champFormulaire\" />";
                echo "</td>\n";
                //
                $cpts++;
            } else {
                //
                               
                if ($reqmo[$temp1[0]] == "checked") {
                    //
                    if ($cptemp == 0) {
                        echo "<tr>\n";
                        echo "\t<td colspan=\"4\"><b>";
                        echo _("Choix des champs a afficher");
                        echo "</b></td>\n";
                        echo "</tr>\n<tr>\n";
                    } elseif ($cptemp == 4) {
                        echo "</tr>\n<tr>\n";
                        $cptemp = 0;
                    }
                    //
                    echo "\t<td colspan='2' class='champs'>";
                    echo "<input type=\"checkbox\" value=\"".(($this->f->get_submitted_post_value($temp1[0])!==null||$this->f->get_submitted_get_value('step')===null||$this->f->get_submitted_get_value('step')=="0")?"Oui":"")."\" name=\"".$temp1[0]."\" size=\"40\" class=\"champFormulaire\" ".(($this->f->get_submitted_post_value($temp1[0])=="Oui"||$this->f->get_submitted_get_value('step')===null||$this->f->get_submitted_get_value('step')=="0")?"checked=\"checked\"":"")." />";
                    echo "&nbsp;&nbsp;"._($temp6)."&nbsp;";
                    echo "</td>\n";
                    //
                    $cptemp++;
                } else {
                    //
                    $temp3 = "";
                    $temp3 = $reqmo[$temp1[0]];
                    if(!is_array($temp3)) {
                        $temp3 = substr($temp3, 0, 6);
                    }
                    //
                    if ($temp3 == "select") {
                        //
                        if ($cptsel == 0) {
                            echo "</tr><tr>\n";
                            echo "\t<td colspan=\"4\"><b>";
                            echo _("Choix des criteres de tri");
                            echo "</b></td>\n";
                            echo "</tr>\n";
                        } elseif ($cptsel == 4) {
                            echo "</tr>\n<tr>\n";
                            $cptsel = 0;
                        }
                        //
                        echo "\t<td class=\"tri\">";
                        echo _($temp6)."&nbsp;";
                        echo "<select name=\"".$temp1[0]."\" class=\"champFormulaire\">";
                        $qres1 = $this->f->get_all_results_from_db_query(
                            $reqmo[$temp1[0]],
                            array(
                                'origin' => __METHOD__,
                                'mode' => DB_FETCHMODE_ORDERED
                                )
                            );
                        foreach($qres1['result'] as $row1) {
                            echo "<option value=\"".$row1[0]."\" ".(($this->f->get_submitted_post_value($temp1[0])==$row1[0])?"selected=\"selected\"":"").">".$row1[1]."</option>";
                        }
                        echo "</select>";
                        echo "</td>\n";
                        //
                        $cptsel++;
                    } 
                    //Si un tableau est fourni
                    elseif(is_array($temp3)) {
                        //
                        if ($cptsel == 0) {
                            echo "</tr><tr>\n";
                            echo "\t<td colspan=\"4\"><b>";
                            echo _("Choix des criteres de tri");
                            echo "</b></td>\n";
                            echo "</tr><tr>\n";
                        }  elseif ($cptsel == 4) {
                            echo "</tr>\n<tr>\n";
                            $cptsel = 0;
                        }
                        //
                        echo "\t<td class=\"tri\">";
                        echo _($temp6)."&nbsp;";
                        echo "<select name=\"".$temp1[0]."\" class=\"champFormulaire\">";
                        foreach ($reqmo [$temp1 [0]] as $elem) {
                            echo "<option value='".$elem."' ".(($this->f->get_submitted_post_value($temp1[0])==$elem)?"selected='selected'":"").">"._($elem)."</option>";
                        }
                        echo "</select>";
                        echo "</td>\n";
                        //
                        $cptsel++;
                    } 
                    // Si un input est fourni
                    else {
                        //
                        if ($cptsel == 0) {
                            echo "</tr><tr>\n";
                            echo "\t<td colspan=\"4\"><b>";
                            echo _("Choix des criteres de tri");
                            echo "</b></td>\n";
                            echo "</tr><tr>\n";
                        }  elseif ($cptsel == 4) {
                            echo "</tr>\n<tr>\n";
                            $cptsel = 0;
                        }
                        //
                        echo "\t<td class=\"tri\">";
                        echo _($temp6)."&nbsp;";
                        echo "<input type=\"text\" name=\""._($temp6)."\" placeholder=\"".$reqmo[$temp6]."\" value=\"".$this->f->get_submitted_post_value($temp1[0])."\" size=\"10\" class=\"champFormulaire\" />";
                        echo "</td>\n";
                        //
                        $cptsel++;
                    }
                }
            }
            // re initialisation
            $temp1[0] = "";
        }
        echo "</tr>";
        echo "</table>";
        //
        echo "</fieldset>\n";
        //
        //echo "<table>\n";
        //
        echo "<tr><td colspan=\"2\">";
        //
        echo "<fieldset class=\"cadre ui-corner-all ui-widget-content\">\n";
        //
        echo "\t<legend class=\"ui-corner-all ui-widget-content ui-state-active\">";
        echo _("Parametres de sortie");
        echo "</legend>\n";
        //
        echo "<table>";
        //
        echo "<tr>";
        //
        echo "<td class=\"params\">"._("Choix du format de sortie")."&nbsp;";
        echo "<select name=\"sortie\" class=\"champFormulaire\">";
        echo "<option value=\"tableau\" ".(($this->f->get_submitted_post_value('sortie')=="tableau")?"selected='selected'":"").">"._("Tableau - Affichage a l'ecran")."</option>";
        echo "<option value=\"csv\" ".(($this->f->get_submitted_post_value('sortie')=="csv")?"selected='selected'":"").">"._("CSV - Export vers logiciel tableur")."</option>";

        if(isset($reqmo["om_sousetat"]) AND $reqmo["om_sousetat"] != "") {
            echo "<option value=\"pdf\" ".(($this->f->get_submitted_post_value('sortie')=="pdf")?"selected='selected'":"").">"._("PDF - Version imprimable")."</option>";
        }
        echo "</select>";
        echo "</td>";
        //
        echo "</tr>";
        echo "<tr>";
        //
        echo "<td class=\"params\">"._("Separateur de champs (pour le format CSV)")."&nbsp;";
        echo "<select name=\"separateur\" class=\"champFormulaire\">";
        echo "<option ".(($this->f->get_submitted_post_value('separateur')==";")?"selected='selected'":"").">;</option>";
        echo "<option ".(($this->f->get_submitted_post_value('separateur')=="|")?"selected='selected'":"").">|</option>";
        echo "<option ".(($this->f->get_submitted_post_value('separateur')==",")?"selected='selected'":"").">,</option>";
        echo "</select>";
        echo "</td>";
        //
        echo "</tr>";
        echo "<tr>";
        //
        echo "<td class=\"params\" >"._("Nombre limite d'enregistrements a afficher (pour le format Tableau)")."&nbsp;";
        echo "<input type=\"text\" name=\"limite\" value=\"".(($this->f->get_submitted_post_value('limite')!==""&&$this->f->get_submitted_get_value('step')!==null&&$this->f->get_submitted_get_value('step')!="0")?$this->f->get_submitted_post_value('limite'):"100")."\" size=\"5\" class=\"champFormulaire\" />";
        echo "</td>";
        echo "</tr>";
        echo "</table>";
        //
        echo "</fieldset>\n";
        //
        echo "</td></tr>\n";
        // Fermeture de la balise table
        echo "</table>\n";
    }
    
    /**
     * Test si la valeur passée en argument est du type attendu
     * @param type $valeur  Valeur à tester
     * @param type $type    Type attendu de la donnée
     */
    function hasType($valeur, $type){
        
        switch ($type){
            case 'date' :
                $d = DateTime::createFromFormat('d/m/Y', $valeur);
                return $d && $d->format('d/m/Y') == $valeur;
            case 'integer' :
                return is_numeric($valeur);
            case 'string' :
                return is_string($valeur);
            default :
                return false;
        }
    }

}


