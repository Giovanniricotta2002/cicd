<?php

/**
 * Rend l'objet incrémentable via la fonction 'increment()'.
 */
trait incrementable {

    /**
     * Retourne 'true' si l'objet est incrémenté.
     *
     * Note: utilise l'id de l'objet courant, si il est vide utilise
     *       alors une condition SQL pour sélectionner le bon enregistrement,
     *       cf fonction 'incrementGetSQLCondition()'.
     *
     * @return bool
     */
    public function increment() : bool {

        $INCREMENT_PROP = $this->incrementGetProperty();

        if (empty($INCREMENT_PROP)) {
            throw new IncrementableException(
                "Property to increment for object '".get_class($this)."' is not defined or empty");
        }

        $INCREMENT_LAST_MOD_PROP = $this->incrementGetLastModProp();

        if (empty($INCREMENT_LAST_MOD_PROP) && $this->incrementUpdateLastMod()) {
            throw new IncrementableException(
                "Property to save last modification timestamp for object '".
                get_class($this)."' is not defined or empty");
        }

        $sql = sprintf("
            UPDATE
                %1\$s
            SET
                $INCREMENT_PROP = $INCREMENT_PROP + %2\$s".
                ($this->incrementUpdateLastMod() ? ", %3\$s = CURRENT_TIMESTAMP" : '')."
            WHERE ",
            DB_PREFIXE.$this->table,
            $this->incrementGetStep(),
            $INCREMENT_LAST_MOD_PROP);

        $id = $this->getVal($this->clePrimaire);

        if (! empty($id)) {
            $sql .= $this->clePrimaire.' = '.$id;
        }
        else {
            $sql .= $this->incrementGetSQLCondition();
        }
        file_put_contents('debug.log', $sql);
        $qres = $this->f->db->query($sql);
        if ($this->f->isDatabaseError($qres, true)) {
            $err_msg = $qres->getMessage().' Détails: '.$qres->getDebugInfo();
            throw new IncrementableException("DB error: $err_msg");
        }
        return true;
    }

    /**
     * Renvoi le nom de la propriété contenant la valeur à incrémenter
     *
     * @return string
     */
    protected function incrementGetProperty() : string {
        return 'quantite';
    }

    /**
     * Renvoi le pas d'incrémentation
     *
     * @return float
     */
    protected function incrementGetStep() : float {
        return 1.0;
    }

    /**
     * Défini s'il faut mettre à jour ou pas la date de dernière modification (true = oui)
     *
     * @return bool
     */
    protected function incrementUpdateLastMod() : bool {
        return true;
    }

    /**
     * Renvoi le nom de la propriété contenant le timestamp de dernière modification
     *
     * @return string
     */
    protected function incrementGetLastModProp() : string {
        return 'date_modification';
    }

    /**
     * Génère la clause WHERE de la requête SQL servant à identifiter l'enregistrement
     * (de l'objet courant) à incrémenter par la fonction incrementable::increment()
     *
     * @return string
     */
    abstract protected function incrementGetSQLCondition();
}

class IncrementableException extends Exception {}
