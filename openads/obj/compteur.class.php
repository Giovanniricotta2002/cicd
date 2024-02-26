<?php

require_once "../gen/obj/compteur.class.php";

require_once __DIR__ . '/trait_date_valid.php';
require_once __DIR__ . '/trait_incrementable.php';

class compteur extends compteur_gen {
    use date_valid;
    use incrementable;

    function setType(&$form, $maj) {
        parent::setType($form, $maj);

        // masque le champ 'date_modification' lors de l'ajout ou de la modification
        if ($maj == '0' || $maj == '1') {
            $form->setType('date_modification', 'hidden');
        }
    }

    /**
     *
     * @return void
     */
    function setvalF($val = array()) {
        parent::setvalF($val);

        // date de modification: évite une valeur vide et met toujours à jour la modification
        $this->valF['date_modification'] = date('Y-m-d H:i:s');
    }

    /**
     * Génère la clause WHERE de la requête SQL servant à identifiter l'enregistrement
     * à incrémenter par la fonction incrementable::increment()
     *
     * @return string
     */
    protected function incrementGetSQLCondition() {
        $sql_cond = sprintf("
            code = '%s'
            AND om_collectivite = '%s'",
            $this->getVal('code'),
            $this->getVal('om_collectivite'));
        if (! empty($this->getVal('om_validite_debut'))) {
            $sql_cond .= sprintf(
                " AND om_validite_debut = TO_DATE('%s', 'YYYY-MM-DD')",
                $this->getVal('om_validite_debut'));
        }
        else {
            $sql_cond .= " AND om_validite_debut IS NULL";
        }
        if (! empty($this->getVal('om_validite_fin'))) {
            $sql_cond .= sprintf(
                " AND om_validite_fin = TO_DATE('%s', 'YYYY-MM-DD')",
                $this->getVal('om_validite_fin'));
        }
        else {
            $sql_cond .= " AND om_validite_fin IS NULL";
        }
        return $sql_cond;
    }
}
