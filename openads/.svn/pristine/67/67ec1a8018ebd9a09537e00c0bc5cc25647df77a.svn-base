<?php
//$Id$ 
//gen openMairie le 10/09/2020 13:54

trait date_valid {

    /**
     * Retourne 'true' si l'objet est valide par rapport au moment spécifié.
     *
     * @param  object  $refDT  (optionel)  Un temps de référence pour la comparaison
     *
     * @return bool
     */
    public function valid(DateTime $refDT = null) : bool {
        if (empty($refDT)) {
            $refDT = new DateTime();
        }
        $debutStr = $this->getVal('om_validite_debut');
        $finStr = $this->getVal('om_validite_fin');
        return
            (empty($debutStr) || $refDT >= (new DateTime($debutStr)))
            && (empty($finStr) || $refDT < (new DateTime($finStr)))
        ;
    }

    /**
     * Retourne 'true' si l'objet est dans le passé par rapport au moment spécifié.
     *
     * @param  object  $refDT  (optionel)  Un temps de référence pour la comparaison
     *
     * @return bool
     */
    public function inPast(DateTime $refDT = null) : bool {
        if (empty($refDT)) {
            $refDT = new DateTime();
        }
        $debutStr = $this->getVal('om_validite_debut');
        $finStr = $this->getVal('om_validite_fin');
        return
            (empty($debutStr) || $refDT >= (new DateTime($debutStr)))
            && ($refDT > (new DateTime($finStr)))
        ;
    }

    /**
     * Retourne 'true' si l'objet est dans le futur par rapport au moment spécifié.
     *
     * @param  object  $refDT  (optionel)  Un temps de référence pour la comparaison
     *
     * @return bool
     */
    public function inFuture(DateTime $refDT = null) : bool {
        if (empty($refDT)) {
            $refDT = new DateTime();
        }
        $debutStr = $this->getVal('om_validite_debut');
        $finStr = $this->getVal('om_validite_fin');
        return
            (!empty($debutStr) || $refDT < (new DateTime($debutStr)))
            && (empty($finStr) || $refDT < (new DateTime($finStr)))
        ;
    }
}
