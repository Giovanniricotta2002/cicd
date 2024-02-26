<?php
/**
 * Ce fichier est destine a permettre la surcharge de certaines methodes de
 * la classe om_dbform pour des besoins specifiques de l'application
 *
 * @package openmairie_exemple
 * @version SVN : $Id: om_dbform.class.php 6137 2016-03-09 10:42:13Z nhaye $
 */

/**
 *
 */
require_once PATH_OPENMAIRIE."om_dbform.class.php";

/**
 *
 */
class om_dbform extends dbForm {
    

    /**
     * Liste des métadonnées communes à l'ensemble des fichiers de l'application
     */
    var $metadata_global = array(
        "codeProduit" => "getCodeProduit",
    );

    /**
     * Retourne le code produit défini dans le paramétrage
     * @return string code produit (OpenADS)
     */
    protected function getCodeProduit() {
        return $this->f->getParameter("ged_code_produit");
    }

    // {{{ SURCHARGES DES LIBELLES DES BOUTONS

                       /**
     * Cette methode permet d'afficher le bouton de validation du formulaire
     *
     * @param integer $maj Mode de mise a jour
     * @return void
     */
    function bouton($maj) {


        if (!$this->correct
            && $this->checkActionAvailability() == true) {


            //
            switch($maj) {
                case 0 :
                    $bouton = _("Ajouter");
                    break;
                case 1 :
                    $bouton = _("Modifier");
                    break;
                case 2 :
                    $bouton = _("Supprimer");
                    break;
                default :
                    // Actions specifiques
                    if ($this->get_action_param($maj, "button") != null) {
                        //
                        $bouton = $this->get_action_param($maj, "button");
                    } else {
                        //
                        $bouton = _("Valider");
                    }
                    break;
            }
            //
            // $bouton .= "&nbsp;"._("l'enregistrement de la table")."&nbsp;:";
            // $bouton .= "&nbsp;'"._($this->table)."'";
            //
            $params = array(
                "value" => $bouton,
                "class" => "btn btn-primary",
            );
            //
            $this->f->layout->display_form_button($params);
        }

    }

    // }}}

    /**
     * Accesseur standard à une ressource.
     *
     * Cette méthode permet d'instancier la classe passée en paramètre selon
     * deux logiques différentes :
     *  - Cas n°1 : soit on veut instancier un objet en particulier de manière
     *    ponctuelle alors on passe le paramètre id qui correspond à
     *    l'identifiant de l'objet sur lequel on veut instancier la classe, et
     *    l'instanciation est effectuée et la ressource retournée.
     *  - Cas n°2 : soit on veut instancier un objet lié (clé étrangère) à
     *    l'objet courant et on ne passe donc pas de paramètre id, car il est
     *    récupéré directement sur l'objet courant (on peut éventuellement
     *    indiquer le nom du champ à récupérer par le paramètre field sinon
     *    c'est le nom de la classe qui est utilisé), et l'instanciation est
     *    effectuée et la ressource stockée puis retournée. Attention, si la
     *    ressource a déjà été stockée lors d'un appel précédent alors on la
     *    retourne sans réinstanciation.
     *
     * @param string $class Nom de la classe à instancier.
     * @param string|null $id Identifiant de l'objet à instancier.
     * @param string|null $field Nom du champ ou récupérer l'identifiant de
     *                    l'objet à instancier si différent du nom de la classe.
     *
     * @return resource
     */
    function get_inst_common($class, $id = null, $field = null) {
        //// Gestion du cas n°1 -> Instanciation ponctuelle
        // Si un identifiant est passé en paramètre
        if ($id !== null) {
            // Retour de l'instanciation
            return $this->f->get_inst__om_dbform(array(
                "obj" => $class,
                "idx" => $id,
            ));
        }

        //// Gestion du cas n°2 -> Instanciation liée à l'objet courant
        // On définit le nom de l'attribut dans lequel on va stocker la
        // ressource
        $var_name = "inst_".$class;
        // Si l'attribut n'existe pas ou est initialisé à null
        if (!isset($this->$var_name) || $this->$var_name === null) {
            // Si le paramètre field n'est pas passé en paramètre
            // alors on utilise le nom de la classe
            if ($field === null) {
                $field = $class;
            }
            // Stockage de l'instanciation dans l'attribut de l'objet courant
            $this->$var_name = $this->f->get_inst__om_dbform(array(
                "obj" => $class,
                "idx" => $this->getVal($field),
            ));
        }
        // Retour de l'instanciation
        return $this->$var_name;
    }

    // {{{ SUBSTITUTION_VARS

    /**
     * Récupération des valeurs des champs de fusion
     *
     * @return array         tableau associatif
     */
    function get_values_substitution_vars($om_collectivite_idx = null) {
        //
        $values = parent::get_values_substitution_vars($om_collectivite_idx);


        // Surcharge de la récupération des paramètres car dans openADS on ne gère 
        // pas le 'prefixe_edition_substitution_vars' géré par le framework.
        foreach ($this->f->getCollectivite($om_collectivite_idx) as $key => $value) {
            // XXX Spécificité SIG, un paramètre peut être de type tableau
            if (is_array($value)) {
                continue;
            }
            //
            $value = str_replace("\r\n", "<br/>", $value);
            $value = str_replace("\n", "<br/>", $value);
            $value = str_replace("\r", "<br/>", $value);
            $values[$key] = $value;
        }
        //
        //Date au format jour_de_la_semaine jour_du_mois mois_de_l'année
        //Ex. Lundi 12 Mars 2016
        $jourSemaine = array(
            _('Dimanche'),
            _('Lundi'),
            _('Mardi'),
            _('Mercredi'),
            _('Jeudi'),
            _('Vendredi'),
            _('Samedi'),
        );
        $moisAnnee = array(
            _('Janvier'),
            _('Fevrier'),
            _('Mars'),
            _('Avril'),
            _('Mai'),
            _('Juin'),
            _('Juillet'),
            _('Aout'),
            _('Septembre'),
            _('Octobre'),
            _('Novembre'),
            _('Decembre'),
        );
        //
        $values["aujourdhui"] = date("d/m/Y");
        $values["datecourrier"] = date("d/m/Y");
        $values["jourSemaine"] = sprintf(
            '%s %s %s %s',
            $jourSemaine[date('w')],
            date('d'),
            $moisAnnee[date('n') - 1],
            date('Y')
        );

        /**
         * GESTION SPECIFIQUE DES BORDEREAUX (om_etat)
         *
         * - &date_bordereau_debut
         * - &date_bordereau_fin
         * => $titre
         * => $corps
         */
        if (isset($_GET["obj"]) 
            && $this->f->starts_with($_GET["obj"], 'bordereau') === true) {

            (isset($_GET['date_bordereau_debut']) ? $date_bordereau_debut = $_GET["date_bordereau_debut"] : $date_bordereau_debut = "");
            (isset($_GET['date_bordereau_fin']) ? $date_bordereau_fin = $_GET["date_bordereau_fin"] : $date_bordereau_fin = "");

            // formatage des dates de début et de fin de bordereau en EN/US
            $date_bordereau_debut_en = substr($date_bordereau_debut,6,4)."-".substr($date_bordereau_debut,3,2)."-".substr($date_bordereau_debut,0,2);
            $date_bordereau_fin_en = substr($date_bordereau_fin,6,4)."-".substr($date_bordereau_fin,3,2)."-".substr($date_bordereau_fin,0,2);
            // gestion de l'absence de dates (contexte prévisualisation de l'état)
            if ($date_bordereau_debut_en == '--' || $date_bordereau_fin_en == '--') {
                // Dates volontairement irréalistes pour n'obtenir aucun résultat
                $date_bordereau_debut_en = '1212-12-12';
                $date_bordereau_fin_en = '1212-12-12';
            }
            //
            $values["date_bordereau_debut"] = $date_bordereau_debut;
            $values["date_bordereau_fin"] = $date_bordereau_fin;

            //
            if (isset($_GET['collectivite']) && $_SESSION['niveau'] == '2') {
                if (!is_numeric($_GET["collectivite"])) {
                    $values["departement"] = "";
                    $values["ville"] = "";
                    $values["commune"] = "Toutes";
                } else {
                    $collectivite_parameters = $this->f->getCollectivite($_GET["collectivite"]);
                    $values["departement"] = $collectivite_parameters["departement"];
                    $values["ville"] = $collectivite_parameters["ville"];
                    $values["commune"] = $collectivite_parameters["commune"];
                }
            }

        }

        /**
         * RAPPORT D'INSTRUCTION
         * - &rapport_instruction_consultation
         * => $titre
         * => $corps
         */
        //Récupéraion de la liste des consultations d'un dossier d'instruction pour 
        //l'édition du rapport d'instruction
        if (isset($_GET["obj"]) 
            && strcasecmp( $_GET['obj'], "rapport_instruction") == 0
            && file_exists("../app/rapport_instruction_consultation.php")) {
            //
            $consultations = "";
            include "../app/rapport_instruction_consultation.php";
            $values["rapport_instruction_consultation"] = $consultations;
        }

        // Si l'option du portail citoyen n'est pas activée
        if ($this->f->is_option_citizen_access_portal_enabled($om_collectivite_idx) !== true) {
            // Les valeurs ne sont pas affichées
            $values["acces_citoyen"] = "";
            $values["acces_citoyen_adresse"] = "";
        } else {
            $values["acces_citoyen"] = $this->f->getParameter('acces_citoyen');
            $values["acces_citoyen_adresse"] = $this->f->getParameter('acces_citoyen_adresse');
        }

        //
        return $values;
    }

    /**
     * Récupération des libellés des champs de fusion
     *
     * @return array         tableau associatif
     */
    function get_labels_substitution_vars($om_collectivite_idx = null) {
        //
        $labels = parent::get_labels_substitution_vars();
        //
        $labels["om_parametre"] = array();
        // Surcharge de la récupération des paramètres car dans openADS on ne gère 
        // pas le 'prefixe_edition_substitution_vars' géré par le framework.
        foreach ($this->f->getCollectivite($om_collectivite_idx) as $key => $value) {
            // XXX Spécificité SIG, un paramètre peut être de type tableau
            if (is_array($value)) {
                continue;
            }
            // On ne récupère pas les paramètres dont le préfixe fait partie
            // des éléments : ged_, erp_, id_, sig_, option_, qui n'ont pas vraiment
            // de raison de se trouver dans une édition pdf.
            // Attention ces éléments sont tout de même remplacés dans la méthode
            // 'get_values' pour la raison suivante : rétrocompatibilité.
            if (strstr($key, "ged_") !== false || strstr($key, "erp_") !== false 
                || strstr($key, "id_") !== false || strstr($key, "sig_") !== false
                || strstr($key, "option_") !== false ) {
                continue;
            }
            //
            switch ($key) {
                case 'departement':
                    $label = _("Département (Format sur trois caractères : 072)"); 
                    break;
                case 'commune':
                    $label = _("Code commune (Format sur trois caractères : 064)"); 
                    break;
                case 'insee':
                    $label = _("Code INSEE (Format sur cinq caractères : 72064)"); 
                    break;
                default:
                    $label = "-";
            }
            $labels["om_parametre"][$key] = $label;
        }
        ksort($labels["om_parametre"]);
        //
        $labels["divers"] = array(
            "aujourdhui" => _("Date du jour (Format : 14/01/1978)"),
            "datecourrier" => _("Date du jour (Format : 14/01/1978)"),
            "jourSemaine" => _("Date du jour en lettre (Format : Samedi 14 Janvier 1978)"),
            "acces_citoyen" => _("Texte d'information concernant l'acces au portail citoyen pour les petitionnaires"),
            "acces_citoyen_adresse" => _("Lien vers le portail citoyen"),
        );
        //
        $labels["specifique"] = array();
        if (isset($_GET["obj"]) 
            && strcasecmp( $_GET['obj'], "om_etat") == 0) {
            $labels["specifique"] = array(
                "rapport_instruction_consultation" => _("Rapport d'instruction uniquement - Liste des consultations du dossier"),
                "date_bordereau_debut" => _("Bordereau uniquement - Date de début du bordereau"),
                "date_bordereau_fin" => _("Bordereau uniquement - Date de fin du bordereau"),
            );
        }   
        $labels["specifique"]["contraintes"] = _("Liste de toutes les contraintes du dossier");
        $labels["specifique"]["contraintes(liste_groupe=g1,g2...;liste_ssgroupe=sg1,sg2...)"] = _("Les options liste_groupe et liste_ssgroupe sont optionnelles et peuvent contenir une valeur unique ou plusieurs valeurs separees par une virgule, sans espace.");
        $labels["specifique"]["contraintes(service_consulte=t)"] = _("L'option service_consulte permet d'ajouter une condition sur le champ du meme nom. Il peut prendre t (Oui) ou f (Non) comme valeur.");
        $labels["specifique"]["contraintes(affichage_sans_arborescence=t)"] = _("L'option affichage_sans_arborescence permet d'afficher une liste de contraintes sans leurs groupes et sous-groupes, et sans puces. Il peut prendre t (Oui) ou f (Non) comme valeur.");
        //
        return $labels;
    }

    // }}} SUBSTITUTION_VARS

    /**
     * Cette methode permet d'effacer les messages de validation.
     */
    function cleanMessage() {
        //
        $this->msg = "";
    }


    /**
     * Retourne le booléen de la valeur pgsql passée en paramètre.
     * Si la valeur est 't' alors retourne true, si la valeur est 'f' false,
     * sinon null.
     *
     * @param string $pgsql_value Soit 't', soit 'f'.
     *
     * @return boolean ou null.
     */
    public function get_boolean_from_pgsql_value($pgsql_value) {
        //
        if ($pgsql_value === 't') {
            //
            return true;
        }
        //
        if ($pgsql_value === 'f') {
            //
            return false;
        }

        //
        return null;
    }


    /**
     * Retourne le booléen de la valeur d'affichage passée en paramètre.
     * Si la valeur est 'Oui' alors retourne true, si la valeur est 'Non' ou ''
     * alors retourne false, sinon retourne null.
     *
     * @param string $view_value Soit 'Oui', soit 'Non'.
     *
     * @return boolean ou null.
     */
    public function get_boolean_from_view_value($view_value) {
        //
        if (strtolower($view_value) === strtolower('Oui')) {
            //
            return true;
        }
        //
        if (strtolower($view_value) === strtolower('Non')
            || $view_value === '') {
            //
            return false;
        }

        //
        return null;
    }


    /**
     * Récupère la liste des valeurs de l'objet dans un tableau.
     *
     * @return array
     */
    public function get_array_val() {
        //
        $return = array();
        //
        foreach ($this->champs as $champ) {
            //
            $return[$champ] = $this->getVal($champ);
        }

        //
        return $return;
    }


    /**
     * Affichage du message de validation
     * 
     * @return void
     */
    protected function display_msg() {
        $type = 'valid';
        if ($this->correct === false) {
            $type = 'error';
        }
        $this->f->displayMessage($type, $this->msg);
    }


    /**
     * Ajouter une liaison NàN entre deux tables.
     *
     * @param string $table_l Table de liaison.
     * @param string $table_f Table cible.
     * @param string $field   Champ de la table à liée.
     * @param string $field_f Champ de la table laison qui est associé à la table cible.
     * Ce champs n'est utile que si la table de liaison lie une table à elle même.
     * @param array $specific_values   valeurs supplémentaires à intégrer à l'enregistrement
     *
     * @return integer Nombre de lien crée
     */
    protected function ajouter_liaisons_table_nan($table_l, $table_f, $field, $values=null, $field_f = null, $specific_values = array()) {
        //
        $multiple_values = array();
        // Récupération des données du select multiple
        $postvar = $this->getParameter("postvar");
        if (isset($postvar[$field])
            && is_array($postvar[$field])) {
            $multiple_values = $postvar[$field];
        } elseif ($values != null) {
            //
            $multiple_values = $values;
            // Si ce n'est pas un tableau
            if (!is_array($values)) {
                //
                $multiple_values = explode(";", $multiple_values);
            }
        }

        // Ajout des liaisons
        $nb_liens = 0;
        // Boucle sur la liste des valeurs sélectionnées
        foreach ($multiple_values as $value) {
            // Test si la valeur par défaut est sélectionnée
            if ($value == "") {
                continue;
            }
            // Pour les cas où une table est liée à elle même on récupère
            // le nom du champs fourni en paramètre. Si rien n'a été spécifié
            // alors le nom du champs est celui de la table cible.
            if (empty($field_f)) {
                $field_f = $table_f;
            }
            // On compose les données de l'enregistrement
            $donnees = array(
                $this->clePrimaire => $this->valF[$this->clePrimaire],
                $field_f => $value,
                $table_l => "",
            );
            // Ajoute les valeurs supplémentaires à intégrer à l'enregistrement
            if (is_array($specific_values) && ! empty($specific_values)) {
                $donnees = array_merge($donnees, $specific_values);
            }
            // On ajoute l'enregistrement
            $obj_l = $this->f->get_inst__om_dbform(array(
                "obj" => $table_l,
                "idx" => "]",
            ));
            $obj_l->ajouter($donnees);
            // On compte le nombre d'éléments ajoutés
            $nb_liens++;
        }
        //
        return $nb_liens;
    }


    /**
     * Supprimer les liens d'une table NàN.
     *
     * @param string $table Table de liaison.
     * @param string $conditions conditions supplémentaires en sql permettant de déterminer les
     * élément à supprimer (ex: $conditions = 'AND plop < 3)
     *
     * @return void
     */
    protected function supprimer_liaisons_table_nan($table, string $conditions = '') {
        // Suppression de tous les enregistrements correspondants à l'id 
        // de l'objet instancié en cours dans la table NaN.
        // Si des conditions supplémentaires sont passées en paramètres elles seront ajoutées à la requête
        $qres = $this->f->execute_db_query(
            sprintf(
                'DELETE FROM %1$s%2$s WHERE %3$s = %4$s %5$s',
                DB_PREFIXE,
                $table,
                $this->clePrimaire,
                !empty($this->getVal($this->clePrimaire)) && is_string($this->getVal($this->clePrimaire)) ? "'".$this->getVal($this->clePrimaire)."'" : $this->getVal($this->clePrimaire),
                $conditions
            ),
            array(
                'origin' => __METHOD__,
            )
        );
    }


    /**
     * Récupère l'instance de dossier.
     *
     * @param string $dossier Identifiant du dossier d'instruction.
     *
     * @return object
     */
    protected function get_inst_dossier($dossier = null) {
        //
        return $this->get_inst_common("dossier", $dossier);
    }


    /**
     * Cette méthode permet de récupérer le code de division correspondant
     * au dossier sur lequel on se trouve.
     *
     * @return string Code de la division du dossier en cours
     */
    function getDivisionFromDossier($dossier = null) {

        // Cette méthode peut être appelée plusieurs fois lors d'une requête.
        // Pour éviter de refaire le traitement de recherche de la division
        // alors on vérifie si nous ne l'avons pas déjà calculé.
        if (isset($this->_division_from_dossier) === true and
            $this->_division_from_dossier != NULL) {
            // Logger
            $this->addToLog("getDivisionFromDossier(): retour de la valeur déjà calculée - '".$this->_division_from_dossier."'", EXTRA_VERBOSE_MODE);
            // On retourne la valeur déjà calculée
            return $this->_division_from_dossier;
        }
        if ($dossier === null) {
            // Test sur le mode et le contexte du formulaire
            if ($this->getParameter("retourformulaire") == "dossier"
                    || $this->f->contexte_dossier_instruction()) {
                // Si on se trouve en mode AJOUT (seul mode où l'enregistrement
                // n'existe pas en base de données) ET que nous nous trouvons
                // dans le contexte d'un dossier d'instruction alors on récupère
                // le numéro de dossier depuis le paramètre 'idxformulaire'
                $dossier = $this->getParameter("idxformulaire");
            } elseif ($this->getParameter("retourformulaire") == "lot") {
                $inst_lot = $this->f->get_inst__om_dbform(array(
                    "obj" => "lot",
                    "idx" => $this->getParameter("idxformulaire"),
                ));
                $dossier = $inst_lot->getVal("dossier");
            } else {
                // Sinon on récupère le numéro de dossier dans le champs dossier de
                // l'enregistrement (en base de données)
                $dossier = $this->getVal("dossier");
            }
        }

        // On requête la division du dossier
        $inst_dossier_instruction = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_instruction",
            "idx" => $dossier,
        ));
        $this->_division_from_dossier = $inst_dossier_instruction->getVal("division");
        // On retourne la valeur retournée
        return $this->_division_from_dossier;
    }


    /**
     * Vérifie que l'utilisateur est instructeur et qu'il est de la division du
     * dossier.
     *
     * @return,  boolean true/false
     */
    function is_instructeur_from_division_dossier() {
        if ($this->f->isUserInstructeur() === true and
            $this->f->om_utilisateur["division"] == $this->getDivisionFromDossier()) {
            return true;
        }
        return false;
    }


    /**
     * Si le dossier d'instruction auquel est rattachée l'enregistrement est 
     * cloturé, on affiche pas les liens du portlet.
     *
     * @return boolean true si non cloturé false sinon
     */
    function is_dossier_instruction_not_closed() {
        $idxformulaire = $this->getParameter("idxformulaire");
        //Si le dossier d'instruction auquel est rattachée la consultation est 
        //cloturé, on affiche pas les liens du portlet
        if ($idxformulaire != '' && $this->f->contexte_dossier_instruction()){
            if ($this->f->getStatutDossier($idxformulaire) != "cloture"){
                return true;
            }
        }
        return false;
    }

    /**
     * Initialisation des valeurs des champs HTML <select>
     *
     * @param formulaire $form formulaire
     * @param null &$dnu1 @deprecated Ancienne ressource de base de données.
     * @param int $maj type d action (0:ajouter, 1:modifier, etc.)
     * @param null $dnu2 @deprecated Ancien marqueur de débogage.
     * @param string $field nom du champ <select> a initialiser
     * @param string $sql requete de selection des valeurs du <select>
     * @param string $sql_by_id requete de selection valeur par identifiant
     * @param string $om_validite permet de définir si l'objet lié est affecté par une date de validité
     * @param string $multiple permet d'utiliser cette méthode pour configurer l'affichage de select_multiple (widget)
     * @param string $field_name traduction du champ
     */
    function init_select(&$form = null, &$dnu1 = null, $maj = null, $dnu2 = null, $field = "", $sql = "",
                         $sql_by_id = "", $om_validite = false, $multiple = false,
                         $field_name = '') {

        // Si aucune traduction du champ fournie
        if ($field_name === '') {
            $field_name = _($field);
        }

        // Renomme la collectivité en service sur l'option est activée
        if ($field === 'om_collectivite'
            && $this->f->is_option_renommer_collectivite_enabled() === true) {
            //
            $field_name = sprintf('%s %s',__("le"), __("service"));
        }

        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        // MODES AJOUTER, MODIFIER ET RECHERCHE AVANCÉE
        if (($crud === 'create' OR $crud === 'update' OR $crud == 'search')
            OR ($crud === null AND ($maj == 0 OR $maj == 1 OR $maj == 999))) {
            // Exécution de la requête
            $res = $this->f->db->query($sql);
            // Logger
            $this->addToLog(__METHOD__."(): db->query(\"".$sql."\");", VERBOSE_MODE);
            // Vérification d'une éventuelle erreur de base de données
            $this->f->isDatabaseError($res);
            // Initialisation du select
            $contenu = array();
            $contenu[0][0] = '';
            $contenu[1][0] = _('choisir')."&nbsp;".$field_name;
            //
            $k=1;
            while($row =& $res->fetchRow()){
                $contenu[0][$k] = $row[0];
                $contenu[1][$k] = $row[1];
                $k++;
            }

            // Si en mode "modifier" et si la gestion des dates de validité est activée
            if (($crud === 'update' OR ($crud === null AND $maj == 1))
                AND $om_validite == true) {
                $field_values = array();
                // Dans le cas d'un select_multiple
                if ($multiple == true) {
                    $field_values = explode(";", $this->form->val[$field]);
                }
                // Dans le cas d'un select simple
                else {
                    $field_values = array($this->form->val[$field],);
                }
                // S'il y a une ou plusieurs valeurs
                if (!empty($field_values) && $field_values[0] != '') {
                    // pour chacune d'entre elles
                    foreach ($field_values as $field_value) {
                        // si elle manque au contenu du select
                        if (!in_array($field_value, $contenu[0])) {
                            // on l'ajoute
                            $this->getSelectOldValue($form, $maj, $this->f->db, $contenu,
                                                     $sql_by_id, $field, $field_value);
                        }
                    }
                }
                // S'il n'y a pas de valeur c'est que soit :
                // - aucune valeur n'est présaisie en première validation,
                // - le formulaire a été validé en erreur.
                // C'est ce dernier cas qui nous intéresse afin de ne pas perdre
                // dans le contenu une valeur invalide pourtant sélectionnée.
                // Si elle n'a pas été sélectionnée elle est dans tous les cas
                // perdue, il faut recharger le formulaire pour la récupérer.
                else {
                    // On vérifie si le formulaire est vide : si oui
                    // cela signifie que le formulaire a été validé en erreur
                    $empty = true;
                    foreach ($this->form->val as $f => $value) {
                        if (!empty($value)) {
                            $empty = false;
                        }
                    }
                    // Déclaration des valeurs postées
                    $field_posted_values = array();
                    // Dans le cas d'un select_multiple avec des valeurs postées
                    if ($multiple == true && isset($_POST[$field])) {
                        $field_posted_values = $_POST[$field];
                    }
                    // Dans le cas d'un select simple avec une valeur postée
                    elseif (isset($_POST[$field])) {
                        $field_posted_values = array($_POST[$field],);
                    }
                    // S'il y a une ou plusieurs valeurs postées
                    // et que le formulaire a déjà été validé
                    if ($empty == true && !empty($field_posted_values) && $field_posted_values[0] != '') {
                        // pour chacune d'entre elles
                        foreach ($field_posted_values as $field_posted_value) {
                            // si elle manque au contenu du select
                            if (!in_array($field_posted_value, $contenu[0])) {
                                // on l'ajoute
                                $this->getSelectOldValue($form, $maj, $this->f->db, $contenu,
                                                         $sql_by_id, $field, $field_posted_value);
                            }
                        }
                    }
                }
            }
            // Initialisation des options du select dans le formulaire
            $form->setSelect($field, $contenu);
            // Logger
            $this->addToLog(__METHOD__."(): form->setSelect(\"".$field."\", ".print_r($contenu, true).");", EXTRA_VERBOSE_MODE);
        }

        // MODE SUPPRIMER, CONSULTER ET ACTIONS SPECIFIQUES SANS CRUD
        if (($crud === 'delete' OR $crud === 'read')
            OR ($crud === null AND $maj >= 2 AND $maj != 999)) {
            // Initialisation du select
            $contenu[0][0] = '';
            $contenu[1][0] = '';

            if (isset($this->form->val[$field]) and
                !empty($this->form->val[$field]) and $sql_by_id) {
                // Dans le cas d'un select_multiple
                if ($multiple == true) {
                    // Permet de gérer le cas ou les clés primaires sont alphanumériques
                    $val_field = "'".str_replace(";", "','",$this->form->val[$field])."'";
                } else {
                    $val_field = $this->form->val[$field];
                }
                // ajout de l'identifiant recherche a la requete
                $sql_by_id = str_replace('<idx>', $val_field, $sql_by_id);
                // Exécution de la requête
                $res = $this->f->db->query($sql_by_id);
                // Logger
                $this->addToLog(__METHOD__."(): db->query(".$sql_by_id.");", VERBOSE_MODE);
                // Vérification d'une éventuelle erreur de base de données
                $this->f->isDatabaseError($res);
                // Affichage de la première ligne d'aide à la saisie
                $row =& $res->fetchRow();
                $contenu[0][0] = $row[0];
                $contenu[1][0] = $row[1];
                //
                $k=1;
                while($row =& $res->fetchRow()){
                    $contenu[0][$k] = $row[0];
                    $contenu[1][$k] = $row[1];
                    $k++;
                }
            }

            $form->setSelect($field, $contenu);
            // Logger
            $this->addToLog(__METHOD__."(): form->setSelect(\"".$field."\", ".print_r($contenu, true).");", EXTRA_VERBOSE_MODE);
        }
    }


    /**
     * Récupère la configuration du filestorage dans son intégralité ou
     * seulement le paramètre précisé.
     *
     * @param mixed $key Nom du paramètre de la configuration à récupérer.
     *
     * @return mixed Tableau de la configuration ou null.
     */
    public function get_filestorage_config($key=null) {
        // Vérifie que la configuration du filestorage existe
        if (is_array($this->f->filestorage_config) !== true) {
            //
            return null;
        }

        // Si le paramètre de la configuration n'est pas précisé
        if ($key === null) {
            // Retourne toute la configuration
            return $this->f->filestorage_config;
        }

        // Si le paramètre de la configuration n'existe pas
        if (array_key_exists($key, $this->f->filestorage_config) !== true) {
            //
            return null;
        }

        //
        return $this->f->filestorage_config[$key];
    }


    /**
     * Cette méthode appelée dans le triggermodifierapres() permet de contrôler
     * si le connecteur filestorage demande l'exécution de méthode de
     * traitement.
     *
     * @param array $values Liste des valeurs pour la comparaison.
     *
     * @return boolean
     */
    public function post_update_metadata(array $values) {
        // Récupère la configuration du traitement des métadonnées
        $metadata_handlers = $this->get_filestorage_config('metadata_handlers');
        // Vérifie la configuration du traitement des métadonnées
        if ($metadata_handlers === null
            || is_array($metadata_handlers) !== true
            || array_key_exists($this->table, $metadata_handlers) !== true) {
            //
            return true;
        }

        // Liste des méthodes à exécuter pour l'objet
        $methods = $metadata_handlers[$this->table];

        // Parcours les méthodes à exécuter, configurées dans le connecteur
        // filestorage
        foreach ($methods as $method) {
            //
            if (method_exists($this, $method) === true) {
                //
                $treatment = $this->$method($values);
                //
                if ($treatment !== true) {
                    //
                    return false;
                }
            }
        }

        //
        return true;
    }


    /**
     * Vérifie que l'utilsateur connecté soit lié à la collectivité de niveau 2
     * (multi) ou que l'objet instancié soit lié à une collectivité de niveau 1
     * (mono).
     * Cette méthode fonctionne seulement avec les objets ayant un champ
     * "om_collectivite" et dans un mode différent de l'ajout.
     *
     * @return boolean
     */
    public function is_user_multi_or_is_object_mono() {
        //
        if ($this->f->has_collectivite_multi() === true
            || $this->f->isCollectiviteMono($this->getVal("om_collectivite")) === true) {
            //
            return true;
        }

        //
        return false;
    }

    /**
     * Compose le nom de la séquence.
     *
     * @param string $datc  Code du type de DA
     * @param string $annee Année sur deux caractères
     * @param string $dep   Code du département sur trois caractères
     * @param string $com   Code du la commune sur trois caractères
     *
     * @return string  Nom de la séquence
     */
    public function compose_sequence_name($datc, $annee, $dep, $com) {
        /**
         * On vérifie la validité des trois paramètres.
         */
        // Vérification du code du type de dossier d'autorisation.
        if (!is_string($datc)) {
            // Logger
            $this->addToLog(
                __METHOD__."(): parametre datc = '".var_export($datc, true)."' invalide",
                DEBUG_MODE
            );
            // Stop le traitement
            return false;
        }

        // Vérification de l'année.
        if ($annee == null
            || !is_numeric($annee)
            || strlen($annee) > 2) {
            // Logger
            $this->addToLog(
                __METHOD__."(): champ annee = '".var_export($annee, true)."' invalide",
                DEBUG_MODE
            );
            // Stop le traitement
            return false;
        }

        // Vérification du code département.
        if ($dep == null
                || ((!is_numeric($dep) || (intval($dep) == 0 && $dep !== '000'))
                    // exceptions pour la Corse
                    && ! in_array(strtoupper($dep), array('02A', '02B')))
                || strlen($dep) > 3) {
            // Logger
            $this->addToLog(
                __METHOD__."(): om_parametre departement = '".var_export($dep, true)."' invalide",
                DEBUG_MODE
            );
            // Stop le traitement
            return false;
        }
        
        // Vérification du code commune.
        if ($com == null
            || !is_numeric($com)
            || (intval($com) == 0 && $com !== '000')
            || strlen($com) > 3) {
            // Logger
            $this->addToLog(
                __METHOD__."(): om_parametre commune = '".var_export($com, true)."' invalide",
                DEBUG_MODE
            );
            // Stop le traitement
            return false;
        }

        /**
         * On compose les identifiants qui composent la séquence.
         */
        // Clé unique.
        // Exemple : pc_15_013_055
        $unique_key = sprintf('%s_%s_%s_%s', strtolower($datc), $annee, $dep, $com);
        // Nom de la table représentant la séquence pour appel via la méthode
        // database::nextId() qui prend un nom de séquence sans son suffixe
        // '_seq'.
        // Exemple : openads.dossier_pc_15_013_055
        $table_name = sprintf('%sdossier_%s', DB_PREFIXE, $unique_key);
        // Nom de la séquence avec son suffixe 'seq'.
        // Exemple : openads.dossier_pc_15_013_055_seq
        $sequence_name = sprintf('%s_seq', $table_name);

        return strtolower($sequence_name);
    }

    /**
     * Méthode générique d'ajout d'un enregistrement simple.
     *
     * @param string $table Nom de la table
     * @param array  $data  Liste des données du nouvel enregistrement
     *
     * @return boolean
     */
    public function add_simple_record($table, array $data) {
        //
        $inst = $this->f->get_inst__om_dbform(array(
            "obj" => $table,
            "idx" => "]",
        ));
        //
        $val = array();
        // Initialisation de la clé primaire
        $val[$table] = "";
        if (is_array($data) === true) {
            foreach ($data as $key => $value) {
                $val[$key] = $value;
            }
        }
        //
        $add = $inst->ajouter($val);
        //
        return $add;
    }

    /**
     * Ajout de toutes les liaisons de l'enregistrement instancié dans la table
     * de lien
     *
     * @param string $link_table   Nom de la table de liaison
     * @param string $table_linked Nom de la table cible de la liaison
     * @param array  $datas        Liste des liens à réaliser
     *
     * @return mixed Retourne false en cas d'erreur, sinon le nombre de liaison
     */
    public function add_related_table($link_table, $table_linked, array $datas) {
        //
        $cpt = 0;
        foreach ($datas as $data) {
            //
            if ($data !== "" && $data !== null) {
                //
                $val = array(
                    $this->clePrimaire => $this->valF[$this->clePrimaire],
                    $table_linked => $data
                );
                //
                $add = $this->add_simple_record($link_table, $val);
                // En cas d'erreur, le traitement est stoppé
                if ($add === false) {
                    return false;
                }
                //
                $cpt++;
            }
        }
        //
        return $cpt;
    }

    /**
     * Supprime toutes les liaisons de l'enregistrement instancié dans la table
     * de lien.
     *
     * @param string $link_table Nom de la table de liaison
     *
     * @return boolean
     */
    public function delete_related_table($link_table) {
        $id_related_table = $this->getVal($this->clePrimaire);
        if (! empty($this->valF) && ! empty($this->valF[$this->clePrimaire])) {
            $id_related_table = $this->valF[$this->clePrimaire];
        }
        //
        $sql = sprintf("DELETE FROM %s%s WHERE %s = %s",
            DB_PREFIXE,
            $link_table,
            $this->clePrimaire,
            $id_related_table
        );
        $res = $this->f->db->query($sql);
        $this->addToLog(__METHOD__."(): db->query(\"".$sql."\");", VERBOSE_MODE);
        //
        $this->f->isDatabaseError($res);
        //
        return true;
    }

    /**
     * TREATMENT - Traitement des tables de liaison.
     * Suppression des toutes les liaisons d'un enregistrement en début de
     * chaque traitement.
     *
     * @param string $link_table   Nom de la table de liaison
     * @param string $table_linked Nom de la table cible de la liaison
     * @param string $link_field   Nom du champ qui représente la table de
     *                             liaison
     *
     * @return mixed Retourne false en cas d'erreur, sinon le nombre de liaison
     */
    public function handle_related_table($link_table, $table_linked, $link_field) {
        //
        $this->begin_treatment(__METHOD__);

        // Suppression de toutes les liaisons
        $delete = $this->delete_related_table($link_table);

        // Récupère la valeur postée du champ fictif
        $datas = $this->f->get_submitted_post_value($link_field);

        //
        if (is_array($datas) !== true || count($datas) === 0) {
            //
            return $this->end_treatment(__METHOD__, false);
        }

        // Ajout de toutes les liaisons
        $cpt = $this->add_related_table($link_table, $table_linked, $datas);

        // Retourne le nombre de liaison mise à jour ou ajoutée
        return $this->end_treatment(__METHOD__, $cpt);
    }

    /**
     * Récupère l'identifiant de l'enregistrement par rapport aux arguments.
     *
     * @param string $idx_name        Nom du champ de l'identifiant
     * @param string $table           Nom de la table
     * @param string $condition_field Nom du champ pour la condition
     * @param string $condition_value Valeur du champ de condition
     *
     * @return mixed Résultat de la requête ou null
     */
    public function get_idx_by_args($idx_name, $table, $condition_field, $condition_value) {

        // Retourne null si aucune valeur de condition transmise
        if ($condition_value === '' || $condition_value === null) {
            return null;
        }
        //
        $args = array(
            'idx_name' => $idx_name,
            'table' => $table,
            'condition_field' => $condition_field,
            'condition_value' => $condition_value,
        );
        //
        return $this->f->get_idx_by_args($args);
    }

    /**
     *  Vérifie qu'une chaîne est au format json
     * 
     * @param  string  $text chaîne à analyser
     * @return boolean       vrai si formatée json
     */
    public function isJson($text) {
        json_decode($text);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Surcharge pour assigner les champs 'valF' à 'val' lorsque l'ajout a réussi.
     */
    function ajouter($val = array(), &$dnu1 = null, $dnu2 = null) {
        $res = parent::ajouter($val, $dnu1, $dnu2);
        if ($res !== false) {
            foreach($this->champs as $index => $champ) {
                $this->val[$index] = isset($this->valF[$champ]) ? $this->valF[$champ] : null;
            }
        }
        return $res;
    }

    /**
     * (surcharge pour permettre d'assigner une méthode à un objet tiers)
     *
     * Méthode permettant de produire les métadonnées associées à un champ.
     *
     * @param  string  $champ  Champ sur lequel on récupère les métadonnées
     *
     * @return array|null  Métadonnées du champ, ou null si une erreur survient
     */
    function getMetadata($champ) {

        // Initialisation du tableau de métadonnées
        $metadata = array();

        // Sources globale et locale des métadonnées
        $md_sources = array();
        if(isset($this->metadata_global) AND !empty($this->metadata_global)) {
            $md_sources[] = $this->metadata_global;
        }
        if(isset($this->metadata[$champ]) AND !empty($this->metadata[$champ])) {
            $md_sources[] = $this->metadata[$champ];
        }

        // Pour chaque source on associé la valeur retounrée par la fonction à la clé
        foreach($md_sources as $md_source) {
            foreach($md_source as $key => $callable) {
                // c'est une méthode locale à l'objet courant
                if (is_string($callable) && method_exists($this, $callable)) {
                    $metadata[$key] = $this->$callable($champ);
                }
                // c'est un callable
                elseif(is_callable($callable)) {
                    $metadata[$key] = call_user_func($callable, $champ);
                }
            }
        }
        return $metadata;
    }

    protected function getDossier($champ = null) {
        return $this->getVal('dossier');
    }

    protected function getDossierObject() {
        return $this->f->findObjectById('dossier', $this->getDossier(null));
    }

    protected function getDossierDateDecision($champ = null) {
        return $this->getDossierObject()->getVal('date_decision');
    }

    protected function getDossierAutorisationTypeDetaille($champ = null) {
        return $this->getDossierObject()->getVal('dossier_autorisation_type_detaille');
    }

    protected function getDossierInstructionTypeLibelle($champ = null) {
        $ditId = $this->getDossierObject()->getVal('dossier_instruction_type');
        if (! empty($ditId)) {
            $dit = $this->f->findObjectById('dossier_instruction_type', $ditId);
            if (! empty($dit)) {
                return $dit->getVal('libelle');
            }
        }
        return null;
    }

    protected function getDossierCommuneObject() {
        if ($this->f->is_option_dossier_commune_enabled()) {
            $communeId = $this->getDossierObject()->getVal('commune');
            if (!empty($communeId)) {
                return $this->f->findObjectById('commune', $communeId);
            }
        }
        return null;
    }

    protected function getDossierRegion($champ = null) {
        $commune = $this->getDossierCommuneObject();
        if (! empty($commune)) {
            return $commune->getVal('reg');
        }
        else {
            $params = $this->f->getCollectivite($this->getDossierObject()->getVal('om_collectivite'));
            if (! empty($params) && isset($params['region'])) {
                return $params['region'];
            }
        }
        return null;
    }

    protected function getDossierDepartement($champ = null) {
        $commune = $this->getDossierCommuneObject();
        if (! empty($commune)) {
            return strtoupper($commune->getVal('dep'));
        }
        else {
            $params = $this->f->getCollectivite($this->getDossierObject()->getVal('om_collectivite'));
            if (! empty($params) && isset($params['departement'])) {
                return strtoupper($params['departement']);
            }
        }
        return null;
    }

    protected function getDossierCommune($champ = null) {
        $commune = $this->getDossierCommuneObject();
        if (! empty($commune)) {
            return $commune->getVal('com');
        }
        else {
            $params = $this->f->getCollectivite($this->getDossierObject()->getVal('om_collectivite'));
            if (! empty($params) && isset($params['commune'])) {
                return $params['commune'];
            }
        }
        return null;
    }

    protected function getDossierAnnee($champ = null) {
        return $this->getDossierObject()->getVal('annee');
    }

    protected function getDossierDivision($champ = null) {
        $instructeurId = $this->getDossierObject()->getVal('instructeur');
        if (! empty($instructeurId)) {
            $instructeur = $this->f->findObjectById('instructeur', $instructeurId);
            if (! empty($instructeur)) {
                $divisionId = $instructeur->getVal('division');
                if (! empty($divisionId)) {
                    $division = $this->f->findObjectById('division', $divisionId);
                    if (! empty($division)) {
                        $directionId = $division->getVal('direction');
                        if (! empty($directionId)) {
                            $direction = $this->f->findObjectById('direction', $directionId);
                            if (! empty($direction)) {
                                return $direction->getVal('libelle');
                            }
                        }
                    }
                }
            }
        }
        return null;
    }

    protected function getDossierServiceOrCollectivite($champ = null) {
        $dossier = $this->getDossierObject();
        if (! empty($dossier)) {
            $collectiviteId = $dossier->getVal('om_collectivite');
            if (! empty($collectiviteId)) {
                $collectivite = $this->f->findObjectById('om_collectivite', $collectiviteId);
                if (! empty($collectivite)) {
                    return $collectivite->getVal('libelle');
                }
            }
        }
        return null;
    }

    protected function getDocumentType($champ = null) {
        if (in_array('libelle', $this->champs)) {
            return get_class($this).':'.$this->getVal('libelle');
        }
        return get_class($this);
    }

    /**
     * Récupère une image et renvoie sa miniature à la taille voulue.
     * Par défaut la taille est de 128px * 128px.
     * Il est également possible de choisir le format du fichier de sortie,
     * le type de compresion (cf. méthode setCompression d'imagick) et la
     * qualité de la cpmpression
     * 
     * @param string uid du fichier
     * @param integer hauteur voulue en pixel
     * @param integer largeur voulue en pixel
     * @param string format du fichier. Par défaut "png".
     * @param int type de compresion. Par défaut : Imagick::COMPRESSION_LZW
     * @param int qualité de compression. Par défaut : 90.
     *
     * @return Imagick miniature
     */
    public function get_miniature_fichier(
        $fichier,
        $hauteur = 128,
        $largeur = 128,
        $format = "png",
        $compression = Imagick::COMPRESSION_LZW,
        $compressionQuality = 90
    ) {
        // Récupère le fichier à miniaturiser
        if (empty($fichier)) {
            $this->addToLog(__METHOD__."() : Erreur aucun fichier à miniaturiser");
            return;
        }

        $miniature = new Imagick($fichier);
        $miniature->setIteratorIndex(0);
        $miniature->setCompression($compression);
        $miniature->setCompressionQuality($compressionQuality);
        $miniature->setImageFormat($format);
        $miniature->thumbnailImage($hauteur, $largeur);

        return $miniature->getImagesBlob();
    }

    /**
     * Méthode servant à vérifier si un fichier peut être miniaturisé
     *
     * @param array info du fichier
     * @return boolean
     */
    public function is_miniturisable($infoFichier) {
        $formatAccepte = array('gif', 'jpg', 'jpeg', 'png', 'pdf', 'tiff', 'bitmap');
        $mimetype =  $infoFichier['metadata']['mimetype'];
        $format = substr($mimetype, stripos($mimetype, '/') + 1);
        if (! in_array($format, $formatAccepte)) {
            return false;
        }
        return true;
    }
}
