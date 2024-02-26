<?php
//$Id$ 
//gen openMairie le 01/06/2022 16:00

require_once PATH_OPENMAIRIE."obj/om_parametre.class.php";

class om_parametre extends om_parametre_core {

    /**
     * Surcharge de la méthode dbform->verifier()
     *
     * Vérifications effectuées :
     *  - si le paramètre s'appelle 'param_operateur' vérifie que sa valeur
     *    n'est pas nul et que c'est un json correctement formé.
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);

        if ($this->getVal('libelle') === 'param_operateur'
            || $this->valF['libelle'] === 'param_operateur'
            || $val['libelle'] === 'param_operateur') {
            // Conversion des double quote en simple par openmairie 
            // il faut donc faire l'opération inverse avant de faire la vérification
            $param_operateur = str_replace("'", '"', $val['valeur']);
            $param_operateur = json_decode($param_operateur);
            // Vérifie si le paramètre n'est pas vide et si le json a pu être correctement
            // décodé. Si ce n'est pas le cas préviens l'utilisateur que le paramètre n'est
            // pas au bon format.
            if (is_null($param_operateur) || json_last_error() !== JSON_ERROR_NONE) {
                $this->correct = false;
                $this->addToMessage(__('La configuration de ce paramètre n\'est pas au bon format'));
            }
        }
    }

    function setvalF($val = array()) {
        parent::setValF($val);
        if (($this->getVal('libelle') === 'param_operateur'
            || $this->valF['libelle'] === 'param_operateur')
            && array_key_exists('valeur', $val) === true) {

            $this->valF['valeur'] = str_replace("'", '"', $val['valeur']);
        }
    }
}
