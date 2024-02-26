<?php
//$Id$ 
//gen openMairie le 20/08/2020 12:12

require_once "../gen/obj/document_numerise_nature.class.php";

class document_numerise_nature extends document_numerise_nature_gen {

    /**
     * Défini la valeur par défaut à attribuer au select de la nature des
     * pièces dans le formulair d'ajout des pièces.
     * Si le dossier passé en paramètre est en incomplétude la nature par
     * défaut est 'complémentaire'.
     * Sinon c'est la valeur par défaut qui est utilisé.
     * Si il n'y a pas de dossier passé en paramètre la valeur par défaut est
     * initial.
     *
     * Dans tous les cas, si l'option option_mode_service_consulte est active
     * la nature est 'non applicable'.
     *
     * @param integer identifiant du dossier
     * @return integer|null identifiant de la nature par défaut ou null si aucune
     * valeur par défaut n'a été définie
     */
    public function get_default_select_value($idDossier = null) {
        $all_data = $this->get_all_data();
        // Si l'option mode service consulte est active alors la valeur par
        // défaut est la valeur null.
        if ($this->f->is_option_mode_service_consulte_enabled()) {
            return '';
        }

        // Détermination de la valeur par défaut en utilisant l'état du dossier.
        // incomplet et notifié -> Complémentaire
        // sinon -> initial
        if (! empty($idDossier)) {
            $dossier = $this->f->get_inst__om_dbform(array(
                'obj' => 'dossier',
                'idx' => $idDossier
            ));
            $incompleNotif= $dossier->getVal('incomplet_notifie') === 't'
                || $dossier->getVal('incomplet_notifie') === 'true'
                || $dossier->getVal('incomplet_notifie') === 'oui' ?
                true : false;
            
            foreach ($all_data as $data) {
                if (($incompleNotif && $data['code'] === 'COMP')
                    || (! $incompleNotif && $data['code'] === 'INIT')) {
                    return $data[$this->clePrimaire];
                }
            }
        }

        // Si aucun dossier n'est fourni la nature par défaut est initial
        foreach ($all_data as $data) {
            if ($data['code'] === 'INIT') {
                return $data[$this->clePrimaire];
            }
        }
        return null;
    }

    protected function get_all_data() {
        $result = array();
        $query = sprintf('
            SELECT *
            FROM %1$sdocument_numerise_nature
            ORDER BY document_numerise_nature
            ',
            DB_PREFIXE
        );
        $res = $this->f->get_all_results_from_db_query(
            $query,
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($res['code'] === 'KO') {
            return false;
        }
        $result = $res['result'];
        return $result;
    }

}
