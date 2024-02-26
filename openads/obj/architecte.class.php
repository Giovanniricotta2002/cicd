<?php
/**
 * DBFORM - 'architecte' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'architecte'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/architecte.class.php";

class architecte extends architecte_gen {

    // {{{ Gestion de la confidentialité des données spécifiques
    
    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        parent::init_class_actions();

        // ACTION - 001 - modifier
        // Modifie la condition et le libellé du bouton modifier
        $this->class_actions[1]["condition"] = array("is_not_frequent");

        // ACTION - 100 - non_frequent
        // Finalise l'enregistrement
        $this->class_actions[100] = array(
            "identifier" => "non_frequent",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Marquer non frequent"),
                "order" => 100,
                "class" => "radiation-16",
            ),
            "view" => "formulaire",
            "method" => "set_non_frequent",
            "permission_suffix" => "modifier_frequent",
            "condition" => array("is_frequent"),
        );

        // ACTION - 110 - recuperer_frequent
        // Finalise l'enregistrement
        $this->class_actions[110] = array(
            "identifier" => "recuperer_frequent",
            "view" => "formulaire",
            "method" => "modifier",
            "button" => "valider",
            "permission_suffix" => "modifier",
        );
    }

    //}}}

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "architecte",
            "nom",
            "prenom",
            "adresse1",
            "adresse2",
            "lieu_dit",
            "boite_postale",
            "cp",
            "cedex",
            "ville",
            "pays",
            "inscription",
            "conseil_regional",
            "nom_cabinet",
            "telephone",
            "fax",
            "email",
            "note",
            "titre_obt_diplo_spec",
            "date_obt_diplo_spec",
            "lieu_obt_diplo_spec",
            "frequent",
        );
    }
    
    /**
     * Retourne true si pétitionnaire frequent false sinon.
     *
     * @return boolean retourne true si frequent false sinon.
     */
    function is_frequent() {
        if($this->getVal("frequent") == 't') {
            return true;
        }
        return false;
    }

    /**
     * Retourne false si pétitionnaire frequent true sinon.
     *
     * @return boolean retourne false si frequent true sinon.
     */
    function is_not_frequent() {
        return !$this->is_frequent();
    }

    /**
     * TREATMENT - set_non_frequent.
     * 
     * Cette methode permet de passer le pétitionnaire en non fréquent.
     *
     * @return boolean true si maj effectué false sinon
     */
    function set_non_frequent($val) {
        // Cette méthode permet d'exécuter une routine en début des méthodes
        // dites de TREATMENT.
        $this->begin_treatment(__METHOD__);

        if($this->getVal("frequent") == 't') {
            $this->correct = true;
            $valF = array();
            $valF["frequent"] = false;

            $res = $this->f->db->autoExecute(
                DB_PREFIXE.$this->table, 
                $valF,
                DB_AUTOQUERY_UPDATE,
                $this->clePrimaire."=".$this->getVal($this->clePrimaire)
            );
            if ($this->f->isDatabaseError($res, true)) {
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
                $this->correct = false;
                // Termine le traitement
                return $this->end_treatment(__METHOD__, false);
            } else {
                $this->addToMessage(_("Mise a jour effectuee avec succes"));
                return $this->end_treatment(__METHOD__, true);
            }

        } else {
            $this->addToMessage(_("Element deja frequent"));
        }

        // Termine le traitement
        return $this->end_treatment(__METHOD__, false);
    }
    
    /**
     * Ajout des blocs pour la gestion des architectes fréquents
     */
    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        if ($maj < 2) { //ajouter et modifier [add and modify]
          $form->setType('email', 'mail');
        }
        // MODE recup_frequent
        if ($maj == 110) {
            //Affichage d'un message d'information
            $this->addToMessage(_("Architecte frequent non modifiable"));
            $form->setType("architecte", "hiddenstatic");
            $form->setType("nom", "static");
            $form->setType("prenom", "static");
            $form->setType("adresse1", "static");
            $form->setType("adresse2", "static");
            $form->setType("lieu_dit", "static");
            $form->setType("boite_postale", "static");
            $form->setType("cp", "static");
            $form->setType("cedex", "static");
            $form->setType("ville", "static");
            $form->setType("pays", "static");
            $form->setType("inscription", "static");
            $form->setType("telephone", "static");
            $form->setType("fax", "static");
            $form->setType("email", "static");
            $form->setType("note", "static");
            $form->setType("frequent", "checkboxstatic");
            $form->setType("nom_cabinet", "static");
            $form->setType("conseil_regional", "static");
        }
        // Pour les actions appelée en POST en Ajax, il est nécessaire de
        // qualifier le type de chaque champs (Si le champ n'est pas défini un
        // PHP Notice:  Undefined index dans core/om_formulaire.class.php est
        // levé). On sélectionne donc les actions de portlet de type
        // action-direct ou assimilé et les actions spécifiques avec le même
        // comportement.
        if ($this->get_action_param($maj, "portlet_type") == "action-direct"
            || $this->get_action_param($maj, "portlet_type") == "action-direct-with-confirmation") {
            //
            foreach ($this->champs as $key => $value) {
                $form->setType($value, 'hidden');
            }
            $form->setType($this->clePrimaire, "hiddenstatic");
        }
    }
    
    function setLayout(&$form, $maj){
        
        $form->setBloc('architecte','D',"", "alignForm");
        //
            $form->setBloc('architecte','DF',"", "group");
        //
        $form->setBloc('architecte','F');
        
        if($this->getVal('frequent') != 't' || $maj == 0 ) {
            $form->setBloc('nom','D',"","group alignForm civilite_architecte ".($maj<2 ? "search_fields ":""));
        } else {
            $form->setBloc('nom','D',"","group alignForm");
        }
        
        //$form->setBloc('nom','D',"", "group civilite_architecte ".($maj<2 ? "search_fields":""));
        $form->setBloc('prenom','F');
        
        $form->setBloc('adresse1','D',"", "adresse_architecte alignForm");
        //
            $form->setBloc('adresse1','DF',"", "group");
            $form->setBloc('adresse2','DF',"", "group");
            $form->setBloc('lieu_dit','DF',"", "group");
            $form->setBloc('boite_postale','DF',"", "group");
            $form->setBloc('cp','DF',"", "group");
            $form->setBloc('cedex','DF',"", "group");
            $form->setBloc('ville','DF',"", "group");
            $form->setBloc('pays','DF',"", "group");
        //
        $form->setBloc('pays','F');
        
        $form->setBloc('inscription','D',"", "complement_architecte alignForm");
            //
            $form->setBloc('inscription','DF',"", "group");
            $form->setBloc('conseil_regional','DF',"", "group");
            $form->setBloc('nom_cabinet','DF',"", "group");
            $form->setBloc('telephone','DF',"", "group");
            $form->setBloc('fax','DF',"", "group");
            $form->setBloc('email','DF',"", "group");
            $form->setBloc('note','DF',"", "group");
            //
        $form->setBloc('note','F');

        $form->setBloc('titre_obt_diplo_spec', 'D', __("Obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent"), "alignForm");
        $form->setBloc('lieu_obt_diplo_spec', 'F');
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        $form->setVal("pays", "France");
    }

    function setLib(&$form,$maj) {
        //
        parent::setLib($form, $maj);
        $form->setLib('frequent',"<span class=\"om-form-button copy-16\"
                      title=\""._("Sauvegarder cet architecte")."\">"._("Sauvegarder (architecte frequent)")."</span>");

        // Dans le cas d’une intervention sur un immeuble classé au titre des monuments historiques
        $form->setLib('titre_obt_diplo_spec', __("Titre"));
        $form->setLib('date_obt_diplo_spec', __("Date"));
        $form->setLib('lieu_obt_diplo_spec', __("Établissement / ville / pays"));
    }
    
    /**
     * Ajout d'un champs caché permettant de linker l'id du demandeur
     * recement ajouté
     **/
    function sousFormSpecificContent($maj) {
        
        $id_architecte = $this->getVal("architecte");
        if(isset($this->valF["architecte"]) AND !empty($this->valF["architecte"])) {
            echo "<input id=\"id_retour\" name=\"idRetour\" type=\"hidden\" value=\"".
                    $this->valF["architecte"]."\" />";
        } elseif(isset($id_architecte) AND !empty($id_architecte) AND $maj == 110) {
            echo "<input id=\"id_retour\" name=\"idRetour\" type=\"hidden\" value=\"".
                    $this->getVal("architecte")."\" />";
        }
    }
    
    /**
     * Synthèse de l'architecte pour le formulaire des données techniques
     */
    function afficherSynthese() {
        
        $nom = $this->getVal('nom');
        $prenom = $this->getVal('prenom');
        
        //Affichage du bouton pour ajout si dans un objet qui n'est pas en BDD
        if ( $this->getParameter("maj") === 0 ){
            printf ("<span class=\"om-form-button add-16 add_architecte\"
                onclick=\"popupIt('architecte',
                '".OM_ROUTE_SOUSFORM."&obj=architecte&action=0'+
                '&retourformulaire=donnees_techniques', 860, 'auto',
                getObjId, 'architecte');\"".
                ">");
            printf(_("Saisir un(e) architecte"));
        }
        //Affichage du bouton de suppression sinon
        else {
            //
            printf ("<span class=\"om-form-button delete-16 add_architecte\"
                onclick=\"setDataFrequent('','architecte');\"".
                "title=\"");
            printf(_("Supprimer"));
            printf("\">");
            printf("&nbsp;");
            printf("</span>");
            //
            printf ("<span class=\"om-form-button edit-16 add_architecte\"
                onclick=\"popupIt('architecte',
                '".OM_ROUTE_SOUSFORM."&obj=architecte&action=1&idx=".$this->getVal($this->clePrimaire)."'+
                '&retourformulaire=donnees_techniques', 860, 'auto',
                getObjId, '".$this->clePrimaire."');\"".
                "title=\"");
            printf(_("editer"));
            printf("\">");
            printf("%s %s",$nom,$prenom);
        }
        printf ("</span>");
    }

    /**
     * Le bouton de modification est masqué si on est en modification d'un architecte fréquent
     */
    function boutonsousformulaire($datasubmit, $maj, $val=null) {
        if($this->getVal('frequent') != 't' || $maj == 0 ) {
            if (!$this->correct) {
                //
                switch ($maj) {
                    case 0:
                        $bouton = _("Ajouter");
                        break;
                    case 1:
                        $bouton = _("Modifier");
                        break;
                    case 2:
                        $bouton = _("Supprimer");
                        break;
                }
                //
                echo "<input type=\"button\" value=\"".$bouton."\" ";
                echo "onclick=\"affichersform('".$this->get_absolute_class_name()."', '$datasubmit', this.form);\" ";
                echo "class=\"om-button\" />";
            }
        }
    }


    /**
     * Indique si la redirection vers le lien de retour est activée ou non.
     *
     * L'objectif de cette méthode est de permettre d'activer ou de désactiver
     * la redirection dans certains contextes.
     *
     * @return boolean
     */
    function is_back_link_redirect_activated() {
        //
        if ($this->getParameter("retourformulaire") === 'donnees_techniques') {
            //
            return false;
        }

        //
        return true;
    }

    /**
     * Permet de modifier le fil d'Ariane depuis l'objet pour un formulaire
     * @param string    $ent    Fil d'Ariane récupéréré
     * @return                  Fil d'Ariane
     */
    function getFormTitle($ent) {
        //
        $out = $ent;
        if ($this->getVal($this->clePrimaire) != "") {
            $out .= "<span class=\"libelle\">&nbsp;->&nbsp;".$this->getVal($this->clePrimaire)."&nbsp;".$this->getVal('prenom')."&nbsp;".$this->getVal('nom')."</span>";
        }
        return $out;
    }

    public function view_json_data() {
        $this->checkAccessibility();
        $this->f->disableLog();
        $view = $this->get_json_data();
        printf(json_encode($view));
    }

    public function get_json_data() {
        $val = array_combine($this->champs, $this->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        return $val;
    }

}// fin classe


