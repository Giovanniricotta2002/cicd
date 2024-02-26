<?php
//$Id$ 
//gen openMairie le 03/11/2021 12:39

require_once "../gen/obj/signataire_arrete.class.php";

class signataire_arrete extends signataire_arrete_gen {

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        // TODO : voir si il y a moyen de modifier l'organisation des champs
        // en évitant d'avoir a chaque modif de la table a modifier cette liste
        // de champs
        return array(
            "signataire_arrete",
            "civilite",
            "nom",
            "prenom",
            "qualite",
            "signataire_habilitation",
            "agrement",
            "visa",
            "visa_2",
            "visa_3",
            "visa_4",
            "signature",
            "defaut",
            "om_validite_debut",
            "om_validite_fin",
            "om_collectivite",
            "email",
            "parametre_parapheur",
            "description",
        );
    }
    
    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        // Récupération du mode de l'action
        $crud = $this->get_action_crud($maj);

        // MODE CREER
        if ($maj == 0 || $crud == 'create') {
            $form->setType("parametre_parapheur", "textarea");
        }
        // MDOE MODIFIER
        if ($maj == 1 || $crud == 'update') {
            $form->setType("parametre_parapheur", "textarea");
        }
        // MODE CONSULTER
        if ($maj == 3 || $crud == 'read') {
            $form->setType('parametre_parapheur', 'textareastatic');
        }

    }

    function setvalF($val = array()) {
        parent::setValF($val);
        if (array_key_exists('parametre_parapheur', $val) === true) {
            $this->valF['parametre_parapheur'] = str_replace("'", '"', $val['parametre_parapheur']);
        }
    }
}
