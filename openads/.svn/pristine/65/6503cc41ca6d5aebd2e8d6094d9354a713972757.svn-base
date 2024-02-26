<?php
/**
 * OM_ETAT - Surcharge du core
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once PATH_OPENMAIRIE."obj/om_etat.class.php";

class om_etat extends om_etat_core {

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();


        // ACTION - 001 - modifier
        //
        $this->class_actions[1]["condition"] = array("is_user_multi_or_is_object_mono");

        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["condition"] = array("is_user_multi_or_is_object_mono");
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_sousetat() {
        return "select id, (id||' '||libelle) as libelle from ".DB_PREFIXE."om_sousetat where actif IS TRUE and om_collectivite=".$_SESSION['collectivite']." order by libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_om_sousetat_by_id() {
        return "select id, (id||' '||libelle) as libelle from ".DB_PREFIXE."om_sousetat";
    }

    /**
     * Permet de modifier les valeurs d'un objet pour le copier.
     *
     * @param array  $valCopy Liste des valeurs à copier
     * @param string $objsf   Liste des objets liés
     * @param mixed  $DEBUG   Mode debug
     *
     * @return array
     */
    function update_for_copy($valCopy, $objsf, $DEBUG) {

        // Libellé du duplicata
        $libelle = _("Copie de %s du %s");
        $valCopy['libelle'] = sprintf($libelle, $valCopy['libelle'], date('d/m/Y H:i:s'));
        // Tronque le libellé si celui est trop long
        $valCopy['libelle'] = mb_substr($valCopy['libelle'], 0, 100, "UTF8");

        // La lettre-type ne doit pas être actif
        $valCopy['actif'] = 'f';

        // Message à retourner
        $valCopy['message'] = '';

        // Retourne les valeurs
        return $valCopy;
    }


}


