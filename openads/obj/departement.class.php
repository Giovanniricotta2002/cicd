<?php
//$Id$ 
//gen openMairie le 10/09/2020 13:54

require_once "../gen/obj/departement.class.php";

require_once __DIR__ . '/trait_date_valid.php';

class departement extends departement_gen {
    use date_valid;

    /**
     * Mutateur pour la propriété 'valF' en mode CREATE & UPDATE.
     *
     * @param array $val Tableau des valeurs brutes.
     *
     * @return void
     */
    public function setvalF($val = array()) {
        parent::setvalF($val);
        if ($val['om_validite_debut'] != "") {
            $this->valF['om_validite_debut'] = $this->dateDB($val['om_validite_debut']);
        } else {
            $this->valF['om_validite_debut'] = NULL;
        }
    }
}
