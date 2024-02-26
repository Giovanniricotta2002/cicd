<?php
/**
 * Ce script définit la classe 'storage'.
 *
 * @package openelec
 * @version SVN : $Id: storage.class.php 13137 2022-10-27 20:34:03Z softime $
 */

require_once "../gen/obj/storage.class.php";

/**
 * Définition de la classe 'storage' (om_dbform).
 */
class storage extends storage_gen {

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();
        //
        $this->class_actions[0] = null;
        //
        $this->class_actions[1] = null;
        //
        $this->class_actions[2] = null;
        //
        $this->class_actions[4] = array(
            "identifier" => "all",
            "view" => "view_all",
            "permission_suffix" => "voir_tous",
        );
        // Action  de prévisualisation, ne pas changer le nombre sinon cela risque
        // de casser la prévisualisation du document dans l'onglet Pièce (document_numerise)
        $this->class_actions[400] = array(
            "identifier" => "preview_edition",
            "view" => "formulaire",
            "permission_suffix" => "tab",
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        $champs = parent::get_var_sql_forminc__champs();
        $champs[] = "'' as live_preview";
        return $champs;
    }

    /**
     *
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getVal("filename");
    }

    /**
     *
     * @return void
     */
    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        $form->setType('live_preview', 'hidden');

        // En mode consultation
        if ($maj == 3) {
            $form->setType('uid', 'file');
            $form->setType('filename', 'hidden');
            $form->setType('om_collectivite', 'hidden');
        }
        // En mode prévisualisation
        if ($maj == 400) {
            foreach ($this->champs as $champ) {
                $form->setType($champ, 'hidden');
            }
            $form->setType('live_preview', 'previsualiser');
        }
    }

    /**
     *
     * @return void
     */
    function setLib(&$form, $maj) {
        parent::setLib($form, $maj);

        $form->setLib('storage', __('identifiant'));
        $form->setLib('creation_date', __('date de création'));
        $form->setLib('creation_time', __('heure de création'));
        $form->setLib('uid', __('fichier'));
        $form->setLib('size', __('taille du fichier'));
        $form->setLib('mimetype', __('mimetype du fichier'));
        $form->setLib('type', __('type'));
        $form->setLib('info', __('info'));
        $form->setLib("live_preview", "");
    }

    /**
     *
     * @return mixed Identifiant du fichier ou null si enregistrement inexistant
     *               ou false en cas d'erreur de bdd.
     */
    function get_storage_id_by_uid($uid) {
        $id = null;
        if ($uid !== '' && $uid !== null) {
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        storage
                    FROM
                        %1$sstorage
                    WHERE
                        uid = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($uid)
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($qres["code"] !== "OK") {
                return false;
            }
            $id = $qres["result"];
        }
        //
        return $id;
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        if ($maj == 400) {
            $file = $this->f->storage->get($this->getVal('uid'));
            $form->setSelect('live_preview', array(
                'base64' => base64_encode($file['file_content']),
                'mimetype' => $file['metadata']['mimetype'],
                'label' => 'rapport d\'instruction',
                'href' => sprintf(
                    '../app/index.php?module=form&snippet=file&obj=storage&champ=uid&id=%1$s',
                    $this->getVal($this->clePrimaire)
                )
            ));
        }
    }
}
