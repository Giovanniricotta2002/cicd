<?php
//$Id$ 
//gen openMairie le 28/06/2021 11:26

require_once "../gen/obj/lien_sig_contrainte_sig_attribut.class.php";

class lien_sig_contrainte_sig_attribut extends lien_sig_contrainte_sig_attribut_gen {

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_sig_attribut_by_sig_contrainte() {
        return "SELECT sig_attribut.sig_attribut, sig_attribut.libelle FROM ".DB_PREFIXE."sig_attribut INNER JOIN ".DB_PREFIXE."sig_contrainte ON sig_attribut.sig_couche = sig_contrainte.sig_couche WHERE sig_contrainte.sig_contrainte = <sig_contrainte> ORDER BY sig_attribut.libelle ASC";
    }


    /**
     *
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj, $dnu1, $dnu2);
        $idxformulaire = $this->getParameter('idxformulaire');
        $retourformulaire = $this->getParameter('retourformulaire');
        if (in_array($retourformulaire, $this->foreign_keys_extended["sig_contrainte"])) {
            $sql_sig_attribut_by_sig_contrainte = str_replace(
                '<sig_contrainte>',
                $idxformulaire,
                $this->get_var_sql_forminc__sql("sig_attribut_by_sig_contrainte")
            );
            // sig_attribut
            $this->init_select(
                $form, 
                $this->f->db,
                $maj,
                null,
                "sig_attribut",
                $sql_sig_attribut_by_sig_contrainte,
                $this->get_var_sql_forminc__sql("sig_attribut_by_id"),
                false
            );
        }
    }

}
