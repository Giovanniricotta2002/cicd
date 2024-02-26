<?php
//$Id$ 
//gen openMairie le 04/09/2017 13:41

require_once PATH_OPENMAIRIE."../gen/obj/num_bordereau.class.php";

class num_bordereau extends num_bordereau_gen {

    function __construct($id, &$dnu1 = null, $dnu2 = null) {
        $this->constructeur($id);
    }
    
    function init_class_actions() {
        parent::init_class_actions();

        // Interdiction de la modification
        $this->class_actions[1] = null;

        $this->class_actions[2]['portlet']['libelle'] = __("Supprimer");

        $this->class_actions[3]['condition'] = array(
            "is_option_suivi_numerisation_enabled",
        );

        $this->class_actions[4] = array(
            "identifier" => "edition-pdf",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => __("Édition"),
                "class" => "pdf-16",
                "order" => 40,
                'description' => __('Édition du bordereau de suivi de numérisation.'),
            ),
            "view" => "view_edition_bordereau",
            "permission_suffix" => "consulter",
            "condition" => array(
                "is_option_suivi_numerisation_enabled",
            ),
        );
        
        $this->class_actions[8] = array(
            "identifier" => "retour_num",
            "portlet" => array(
                "type" => "action-direct-with-confirmation",
                "libelle" => __("Retour de la numérisation"),
                //"class" => "pdf-16"
                "order" => 80,
                'description' => __('Mise à jour de la date de numérisation à la date du jour sur tous les suivis de numérisation de dossier, liés au bordereau.'),
            ),
            "view" => "formulaire",
            "method" => "mise_a_jour_dossier_date_num",
            "permission_suffix" => "modifier_dossier",
            "condition" => array(
                "is_option_suivi_numerisation_enabled",
            ),
        );
    }

    /**
     * [is_option_suivi_numerisation_enabled description]
     * @return boolean [description]
     */
    protected function is_option_suivi_numerisation_enabled() {
        return $this->f->is_option_suivi_numerisation_enabled();
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_collectivite() {
        return "SELECT om_collectivite.om_collectivite, om_collectivite.libelle FROM ".DB_PREFIXE."om_collectivite WHERE om_collectivite.niveau != '2' ORDER BY om_collectivite.libelle ASC";
    }

    /**
     * Configuration du formulaire (VIEW formulaire et VIEW sousformulaire).
     *
     * @param formulaire $form Instance formulaire.
     * @param integer $maj Identifant numérique de l'action.
     * @param integer $validation Marqueur de validation du formulaire.
     *
     * @return void
     */
    function set_form_default_values(&$form, $maj, $validation) {
        parent::set_form_default_values($form, $maj, $validation);
        //
        if ($validation==0) {           
            // pré-renseigner la date
            if ($this->getVal('envoi') == "") {
                $form->setVal('envoi', date("d/m/Y"));
            }
        }        
    }
    
    /**
     * Surcharge pour ne pas laisser saisir le libellé
     * {@inheritDoc}
     * @see num_bordereau_gen::setType()
     */
    function setType(&$form, $maj) {
        
        // héritage
        parent::setType($form, $maj);
        
        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);
        
        // TOUS MODES, par défaut
        $form->setType("num_bordereau", "hidden");
        $form->setType("envoi", "hidden");

        // MODE AJOUTER
        if ($maj == 0 || $crud == 'create') {
            $form->setType("libelle", "hidden");
            $form->setType("envoi", "date");
        }

        // MODE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("libelle", "hiddenstatic");
            $form->setType("om_collectivite", "hiddenstatic");
        }

        // MODE RETOUR NUM
        if ($maj == 8) {
            $form->setType("libelle", "hidden");
            $form->setType("om_collectivite", "hidden");
        }
    }
        /**
         * Surcharge pour positionner le libellé
         * 
         * @param unknown $val
         */
    function setValFAjout($val = array()) {
        
        // le liebllé est standardisé" 
        $this->valF["libelle"] = "BOR_".date('Y-m-d');
        
        //libellé = date + n° séquence éventuel
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    COUNT(1)
                FROM
                    %1$snum_bordereau
                WHERE
                    TO_CHAR(envoi,\'DD/MM/YYYY\') = \'%2$s\'
                GROUP BY
                    envoi',
                DB_PREFIXE,
                $this->f->db->escapeSimple($val["envoi"])
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // si ce n'est pas le premier bordereau du jour
        // on ajoute un numéro de séquence 
        if (intval($qres["result"]) != 0) {
            $this->valF["libelle"] .= '_'.intval($qres["result"]);
        }
    }
        
        
    function view_edition_bordereau() {
        $idx = $this->getVal($this->clePrimaire); // id de l'objet du formulaire
        $lettre_type = "bordereau"; // id de la lettre type
        $this->checkAccessibility();
        $params["watermark"] = false;
        $collectivite = $this->f->getCollectivite($this->getVal('om_collectivite'));
       // $filename = $lettre_type."_".str_replace("/","_",$this->getVal($this->clePrimaire)).".pdf";
        
        
        // Génération du PDF
        
        $pdfedition =  $this->compute_pdf_output("lettretype", $lettre_type, $collectivite, $idx, $params);
            
        
        
        // Affichage du PDF
        $this->expose_pdf_output(
            $pdfedition["pdf_output"],
           "bordereau.pdf"
          //  $filename
            )
        ; 
        return true;
    }

    /**
     * TREATMENT - mise_a_jour_dossier_date_num
     *
     * @return [type] [description]
     */
    public function mise_a_jour_dossier_date_num() {
        // Begin (pour positionner $this->correct à true)
        $this->begin_treatment(__METHOD__);
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Boucle sur tous les dossier de suivi du bordereau pour mettre à jour
        // la date de numérisation à la date du jour
        $query = sprintf('
            SELECT num_dossier
            FROM %1$snum_dossier
            WHERE num_bordereau = %2$s
            ',
            DB_PREFIXE,
            intval($this->getVal($this->clePrimaire))
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            $this->correct = false;
            $this->addToMessage(sprintf('%s %s', __("Erreur de base de donnees."), __("Contactez votre administrateur.")));
            return $this->end_treatment(__METHOD__, false);
        }
        foreach ($res['result'] as $value) {
            $inst_num_dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "num_dossier",
                "idx" => $value['num_dossier'],
            ));
            $valF = array();
            $valF = array_combine($inst_num_dossier->champs, $inst_num_dossier->val);
            $valF['datenum'] = date("d/m/Y");
            $update = $inst_num_dossier->modifier($valF);
            if ($update === false) {
                $this->correct = false;
                $this->addToMessage(sprintf(__("Erreur lors de la mise à jour de la date de numérisation du dossier de suivi %s dans le bordereau."), $value['num_dossier']));
                return $this->end_treatment(__METHOD__, false);
            }
        }

        // Fin du traitement
        $this->addToMessage(__("Les dates de numérisation des dossiers ont été correctement mises à jour."));
        return $this->end_treatment(__METHOD__, true);
    }

}

