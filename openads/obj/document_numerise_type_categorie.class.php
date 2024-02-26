<?php
/**
 * DBFORM - 'document_numerise_type' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id: document_numerise_type_categorie.class.php 5839 2016-01-29 08:50:12Z fmichon $
 */

require_once "../gen/obj/document_numerise_type_categorie.class.php";

class document_numerise_type_categorie extends document_numerise_type_categorie_gen {

    /**
     * Permet de modifier le fil d'Ariane.
     * 
     * @param string $ent Fil d'Ariane.
     *
     * @return string
     */
    public function getFormTitle($ent) {

        // Fil d'ariane par défaut
        $ent = _("parametrage")." -> "._("Gestion des pièces")." -> "._("document_numerise_type_categorie");

        // Si différent de l'ajout
        if($this->getParameter("maj") != 0) {

            // Affiche la clé primaire
            $ent .= " -> ".$this->getVal("document_numerise_type_categorie");

            // Affiche le code
            $ent .= " ".mb_strtoupper($this->getVal("libelle"), 'UTF-8');
        }

        // Change le fil d'Ariane
        return $ent;
    }

    /**
     * TRIGGER - triggermodifier.
     *
     * Vérifie si la categorie modifiée est la cétagorie PLATAU et si c'est le cas
     * empêche la modification.
     *
     * @return boolean
     */
    function triggermodifier($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Regarde si le code est PLATAU et si c'est le cas empêche la modification et
        // affiche un message d'erreur
        if ($val['code'] != $this->getval('code') && $this->getval('code') === CODE_CATEGORIE_DOC_NUM_PLATAU) {
            $this->addToMessage(__("La catégorie Plat'AU ne peut pas être modifiée."));
            return false;
        }
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * Vérifie si la categorie supprimée est la cétagorie PLATAU et si c'est le cas
     * empêche la suppression.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Regarde si le code est Plat'AU et si c'est le cas empêche la suppression et
        // affiche un message d'erreur
        if ($this->getval('code') === CODE_CATEGORIE_DOC_NUM_PLATAU) {
            $this->addToMessage(__("La catégorie Plat'AU ne peut pas être supprimée."));
            return false;
        }
    }
}


