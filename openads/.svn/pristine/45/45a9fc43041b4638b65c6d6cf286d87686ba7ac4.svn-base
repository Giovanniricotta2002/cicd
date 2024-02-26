<?php
//$Id$ 
//gen openMairie le 20/08/2020 15:43

require_once "../gen/obj/commune.class.php";

require_once __DIR__ . '/trait_date_valid.php';

class commune extends commune_gen {
    use date_valid;

    /**
     *
     * @return void
     */
    function setvalF($val = array()) {
        parent::setvalF($val);

        // Évite une notice PHP sur le champ om_validite_debut qui n'est pas disponible
        // dans $this->valF
        if ($val['om_validite_debut'] != "") {
            $this->valF['om_validite_debut'] = $this->dateDB($val['om_validite_debut']);
        } else {
            $this->valF['om_validite_debut'] = NULL;
        }
    }
}
