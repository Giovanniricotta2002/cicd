<?php
/**
 * DBFORM - 'quartier' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'quartier'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/quartier.class.php";

class quartier extends quartier_gen {
    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement ORDER BY NULLIF(arrondissement.libelle,'')::int ASC NULLS LAST";
    }
}
