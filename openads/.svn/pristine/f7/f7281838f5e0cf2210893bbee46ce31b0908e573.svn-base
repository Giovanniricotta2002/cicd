 <?php
//$Id$ 
//gen openMairie le 30/08/2017 14:47

require_once PATH_OPENMAIRIE."../gen/obj/num_dossier.class.php";

class num_dossier extends num_dossier_gen {

    function __construct($id, &$dnu1 = null, $dnu2 = null) {
        $this->constructeur($id);
    }
    
    function init_class_actions() {
        parent::init_class_actions();
        
        // Interdiction de l'ajout direct
        $this->class_actions[0] = array();

        // Action - 001 - modifier
        $this->class_actions[1]['condition'] = array(
            "is_editable",
            "is_option_suivi_numerisation_enabled",
        );

        // Action - 002 - supprimer
        $this->class_actions[2]['condition'] = array(
            "is_option_suivi_numerisation_enabled",
        );
        $this->class_actions[2]['portlet']['libelle'] = __("Supprimer");

        // Action - 003 - consulter
        $this->class_actions[3]['condition'] = array(
            "is_option_suivi_numerisation_enabled",
        );

        // ACTION - 004 - copier
        //
        $this->class_actions[4] = array(
            "identifier" => "copier",
            "portlet" => array(
                "type" => "action-direct-with-confirmation",
                "libelle" => __("Dupliquer le dossier"),
                "order" => 40,
                //"class" => "copy-16",
            ),
            "view" => "formulaire",
            "method" => "copier",
            "button" => "copier",
            "permission_suffix" => "copier",
            "condition" => array(
                "is_option_suivi_numerisation_enabled",
            ),
            "crud" => "create",
        );
        
    }

    /**
     * CONDITION - is_editable.
     *
     * Condition pour l'action de modification.
     *
     * @return boolean
     */
    function is_editable() {
        // Impossible de modifier le suivi depuis la vue de tous les dossiers
        // suivis
        if ($this->get_absolute_class_name() !== 'num_dossier') {
            return true;
        }
        //
        return false;
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
    function get_var_sql_forminc__sql_num_bordereau() {
        // Filtre les bordereaux disponibles par la collectivité du dossier
        // suivi
        $om_collectivite = $_SESSION['collectivite'];
        if ($this->getParameter("maj") != 0) {
            $om_collectivite = $this->getval('om_collectivite');
        }
        return sprintf('
            SELECT num_bordereau.num_bordereau, num_bordereau.libelle
            FROM %1$snum_bordereau
            WHERE num_bordereau.om_collectivite = %2$s
            ORDER BY num_bordereau.libelle DESC
            ',
            DB_PREFIXE,
            $om_collectivite
        );
    }

    /* surcharge */
    function setType(&$form, $maj) {
        // héritage 
        parent::setType($form, $maj);
        
        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        // MDOE MODIFIER, par défaut on verrouille tout
        if ($maj == 1 || $crud == 'update') {
            $form->setType("id", "hiddenstatic");
            $form->setType("ref", "hiddenstatic");
            $form->setType("code", "hiddenstatic");
            $form->setType("petition", "hiddenstatic");
            $form->setType("total_pages", "hiddenstatic");
            $form->setType("pa3a4", "hiddenstatic");
            $form->setType("pa0", "hiddenstatic");
            $form->setType("date_depot", "hiddenstaticdate");
            $form->setType("num_bordereau", "selecthiddenstatic");
            $form->setType("datenum", "hiddenstaticdate");
            $form->setType("num_commande", "hiddenstatic");
            $form->setType("om_collectivite", "hidden");
            if ($_SESSION["niveau"] == 2) {
                $form->setType("om_collectivite", "selecthiddenstatic");
            }
        }

    }

            
    function copier($val = array(), &$dnu1 = null, $dnu2 = null) {
        // Begin
        $this->begin_treatment(__METHOD__);

        // Récuperation de la valeur de la cle primaire de l'objet
        $id = $this->getVal($this->clePrimaire);
        // Récupération des valeurs de l'objet
        $this->setValFFromVal();
        // Maj des valeur de l'objet à copier
        $this->valF[$this->clePrimaire]=null;
        $this->valF["num_bordereau"]=null;
        $this->valF["datenum"]=null;
        
        //
        $ret = $this->ajouter($this->valF);
        // Si le traitement ne s'est pas déroulé correctement
        if ($ret !== true) {
            // Return
            return $this->end_treatment(__METHOD__, false);
        }

        // Message
        $this->addToMessage(__("L'élément a été correctement dupliqué."));
        // Return
        return $this->end_treatment(__METHOD__, true);
    }

    function setLayout(&$form, $maj) {
            $form->setBloc('num_dossier','D',"", "col_7");
                $form->setFieldset('num_dossier','D',' '.__('identification').' ', "");
                $form->setFieldset('code','F',' ');
                 
                $form->setFieldset('petition','D',' '.__('détail').' ', "collapsible");
                $form->setFieldset('date_depot','F');
                
                $form->setFieldset('num_bordereau','D',' '.__('traitement').' ', "collapsible");
                $form->setFieldset('om_collectivite','F');
            $form->setBloc('om_collectivite','F');
    }

}
