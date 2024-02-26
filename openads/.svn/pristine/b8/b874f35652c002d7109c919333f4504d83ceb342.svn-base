<?php
//$Id$ 
//gen openMairie le 09/07/2021 11:14

require_once "../gen/obj/lien_document_n_type_d_i_t.class.php";

class lien_document_n_type_d_i_t extends lien_document_n_type_d_i_t_gen {


    /**
     * Surcharge pour que la recherche se fasse sur la bonne colonne (document_numerise_type.code)
     * et éviter des erreurs de base de données
     *
     * @return string
     */
    function get_var_sql_forminc__sql_code_document_numerise_type_by_id() {
        return "SELECT document_numerise_type.document_numerise_type, document_numerise_type.libelle FROM ".DB_PREFIXE."document_numerise_type WHERE document_numerise_type.code LIKE '<idx>'";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type() {
        return "SELECT
                dossier_instruction_type.dossier_instruction_type,
                CONCAT(dossier_autorisation_type_detaille.code, ' ', dossier_instruction_type.libelle)
            FROM
                ".DB_PREFIXE."dossier_instruction_type
                INNER JOIN ".DB_PREFIXE." dossier_autorisation_type_detaille
                    ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille
            ORDER BY
                dossier_instruction_type.libelle ASC";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_instruction_type_by_id() {
        return "SELECT
                dossier_instruction_type.dossier_instruction_type,
                CONCAT(dossier_autorisation_type_detaille.code, ' ', dossier_instruction_type.libelle)
            FROM
                ".DB_PREFIXE."dossier_instruction_type
                INNER JOIN ".DB_PREFIXE." dossier_autorisation_type_detaille
                    ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_instruction_type.dossier_autorisation_type_detaille
            WHERE
                dossier_instruction_type = <idx>";
    }

    function setLib(&$form, $maj) {
        parent::setLib($form, $maj);

        $form->setLib("lien_document_n_type_d_i_t", "id");
    }
}
