<?php
//$Id$ 
//gen openMairie le 03/03/2022 13:02

require_once "../gen/obj/type_habilitation_tiers_consulte.class.php";

class type_habilitation_tiers_consulte extends type_habilitation_tiers_consulte_gen {

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "type_habilitation_tiers_consulte",
            "code",
            "libelle",
            "description",
            "om_validite_debut",
            "om_validite_fin",
        );
    }

}
