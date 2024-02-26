<?php
/**
 * DBFORM - 'document_numerise_type' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id: document_numerise_type.class.php 5839 2016-01-29 08:50:12Z fmichon $
 */

require_once "../gen/obj/document_numerise_type.class.php";

class document_numerise_type extends document_numerise_type_gen {

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "document_numerise_type.document_numerise_type",
            "document_numerise_type.code",
            "document_numerise_type.libelle",
            "document_numerise_type.description",
            "document_numerise_type.document_numerise_type_categorie",
            "array_to_string(array_agg(lien_document_numerise_type_instructeur_qualite.instructeur_qualite
                                ORDER BY instructeur_qualite.libelle), ';') as instructeur_qualite",
            "document_numerise_type.aff_service_consulte",
            "document_numerise_type.aff_da",
            "document_numerise_type.synchro_metadonnee",
            "document_numerise_type.om_validite_debut",
            "document_numerise_type.om_validite_fin",
        );
    }

    /**
     * Clause from pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__tableSelect() {
        return sprintf(
            '%1$s%2$s
                LEFT JOIN %1$slien_document_numerise_type_instructeur_qualite
                    ON lien_document_numerise_type_instructeur_qualite.document_numerise_type=document_numerise_type.document_numerise_type
                LEFT JOIN %1$sinstructeur_qualite
                    ON lien_document_numerise_type_instructeur_qualite.instructeur_qualite=instructeur_qualite.instructeur_qualite',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     * Clause where pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__selection() {
        return " GROUP BY document_numerise_type.document_numerise_type ";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_qualite() {
        return sprintf(
            'SELECT
                instructeur_qualite.instructeur_qualite,
                instructeur_qualite.libelle as lib
            FROM 
                %1$sinstructeur_qualite
            ORDER BY
                lib',
            DB_PREFIXE
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_instructeur_qualite_by_id() {
        return sprintf(
            'SELECT
                instructeur_qualite.instructeur_qualite,
                instructeur_qualite.libelle as lib
            FROM
                %1$sinstructeur_qualite
            WHERE
                instructeur_qualite.instructeur_qualite IN (<idx>)
            ORDER BY
                lib',
            DB_PREFIXE
        );
    }

    /**
     * Surcharge pour que la categorie PLATAU ne soit pas récupérée
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type_categorie() {
        return sprintf(
            'SELECT
                document_numerise_type_categorie.document_numerise_type_categorie,
                document_numerise_type_categorie.libelle
            FROM
                %1$sdocument_numerise_type_categorie
            WHERE
                document_numerise_type_categorie.code != \'%2$s\'
                || document_numerise_type_categorie.code IS NULL
            ORDER BY
                document_numerise_type_categorie.libelle ASC',
            DB_PREFIXE,
            CODE_CATEGORIE_DOC_NUM_PLATAU
        );
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        if ($this->getParameter("maj") == "0") {
            // Coche par défaut les cases à cocher suivantes
            $form->setVal("aff_da", true);
            $form->setVal("aff_service_consulte", true);
        }
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        if ($this->getParameter("maj") == "0") {
            // Coche par défaut les cases à cocher suivantes
            $form->setVal("aff_da", true);
            $form->setVal("aff_service_consulte", true);
        }
    }

    /**
     * Permet de définir le type des champs.
     *
     * @param object  &$form L'objet formulaire.
     * @param integer $maj   Mode du formulaire.
     */
    public function setType(&$form, $maj) {
        //
        parent::setType($form, $maj);

        // Cache les champs
        $form->setType('synchro_metadonnee', 'hidden');
        $form->setType('om_validite_debut', 'hidden');
        if ($maj < 2 ) {
            $form->setType("instructeur_qualite","select_multiple");
        }
        if ($maj >= 2) {
            $form->setType("instructeur_qualite","select_multiple_static");
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        // instructeur_qualite
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "instructeur_qualite",
            $this->get_var_sql_forminc__sql("instructeur_qualite"),
            $this->get_var_sql_forminc__sql("instructeur_qualite_by_id"),
            false,
            true
        );
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggerajouterapres($id, $dnu1, $val);
        // Ajoute autant de lien_document_numerise_type_instructeur_qualite que
        // de qualité d'instructeur ajoutés
        // Récupération des données du select multiple
        $instructeur_qualite = $this->getPostedValues('instructeur_qualite');
        // Ne traite les données que s'il y en a et qu'elles sont correctes
        if (is_array($instructeur_qualite)
            && count($instructeur_qualite) > 0 ) {
            // Initialisation
            $nb_liens_instructeur_qualite = 0;
            // Boucle sur la liste des états sélectionnés
            foreach ($instructeur_qualite as $value) {
                // Test si la valeur par défaut est sélectionnée
                if ($value != "") {
                    //
                    $donnees = array(
                        'document_numerise_type' => $this->valF['document_numerise_type'],
                        'instructeur_qualite' => $value
                    );
                    // On ajoute l'enregistrement
                    $add = $this->ajouter_instructeur_qualite($donnees);
                    //
                    if ($add === false) {
                        //
                        return false;
                    }
                    // On compte le nombre d'éléments ajoutés
                    $nb_liens_instructeur_qualite++;
                }
            }
            // Message de confirmation
            if ($nb_liens_instructeur_qualite > 0) {
                if ($nb_liens_instructeur_qualite == 1) {
                    $this->addToMessage(_("Creation de ").$nb_liens_instructeur_qualite._(" nouvelle liaison realisee avec succes."));
                } else {
                    $this->addToMessage(_("Creation de ").$nb_liens_instructeur_qualite._(" nouvelles liaisons realisees avec succes."));
                }
            }
        }
        //
        return true;
    }

    /**
     * Methode de recupération des valeurs postées
     *
     * @param string $champ Champ du formulaire.
     *
     * @return string
     */
    public function getPostedValues($champ) {
        
        // Récupération des demandeurs dans POST
        if ($this->f->get_submitted_post_value($champ) !== null) {
            
            return $this->f->get_submitted_post_value($champ);
        }
    }


    /**
     * TRIGGER - triggermodifierapres.
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        parent::triggermodifierapres($id, $dnu1, $val);
        // Suppression de tous les liens de la table
        // lien_document_numerise_type_instructeur_qualite
        $this->supprimer_instructeur_qualite($this->valF['document_numerise_type']);
        // Récupération des données du select multiple
        $instructeur_qualite = $this->getPostedValues('instructeur_qualite');
        // Ne traite les données que s'il y en a et qu'elles sont correctes
        if (is_array($instructeur_qualite)
            && count($instructeur_qualite) > 0) {
            // Initialisation
            $nb_liens_instructeur_qualite = 0;
            // Boucle sur la liste des états sélectionnés
            foreach ($instructeur_qualite as $value) {
                // Test si la valeur par défaut est sélectionnée
                if ($value != "") {
                    //
                    $donnees = array(
                        'document_numerise_type' => $this->valF['document_numerise_type'],
                        'instructeur_qualite' => $value
                    );
                    // On ajoute l'enregistrement
                    $add = $this->ajouter_instructeur_qualite($donnees);
                    //
                    if ($add === false) {
                        //
                        return false;
                    }
                    // On compte le nombre d'éléments ajoutés
                    $nb_liens_instructeur_qualite++;
                }
            }
            // Message de confirmation
            if ($nb_liens_instructeur_qualite > 0) {
                $this->addToMessage(_("Mise a jour des liaisons realisee avec succes."));
            }
        }
        //
        return true;
    }

    /**
     * Ajout d'un lien entre le type de document numérisé et les qualités
     * d'instructeur sélectionnés.
     *
     * @param mixed[] $data Couples document_numerise_type/instructeur_qualite
     *                      à ajouter.
     *
     * @return boolean
     */
    public function ajouter_instructeur_qualite($data) {
        //
        $lien_document_numerise_type_instructeur_qualite = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_document_numerise_type_instructeur_qualite",
            "idx" => "]",
        ));
        // initialisation de la clé primaire
        $val['lien_document_numerise_type_instructeur_qualite'] = "";
        //
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $val[$key] = $value;
            }
        }
        //
        $add = $lien_document_numerise_type_instructeur_qualite->ajouter($val);
        //
        return $add;
    }


    /**
     * Suppression de tous les liens entre le type de document numérisé et les
     * qualités d'instructeur.
     *
     * @param integer $id Identifiant du type de document numérisé.
     *
     * @return boolean
     */
    public function supprimer_instructeur_qualite($id) {
        // Suppression de tous les enregistrements correspondants à l'id de
        // la document_numerise_type
        $sql = "DELETE
            FROM ".DB_PREFIXE."lien_document_numerise_type_instructeur_qualite
            WHERE document_numerise_type=".$id;
        $res = $this->f->db->query($sql);
        $this->addToLog(
            __METHOD__."() : db->query(\"".$sql."\");",
            VERBOSE_MODE
        );
        $this->f->isDatabaseError($res);
        //
        return true;
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Supression des liens entre le type de la demande et les états
        $delete = $this->supprimer_instructeur_qualite($id);
        //
        return $delete;
    }

    /**
     * Cette méthode est appelée lors de la suppression d’un objet, elle permet
     * de vérifier si l’objet supprimé n’est pas lié à une autre table pour en
     * empêcher la suppression.
     *
     * @param integer $id    Identifiant de l'enregistrement.
     * @param null    &$dnu1 Ancienne ressource de base de données.
     * @param array   $val   Liste des valeurs.
     * @param null    $dnu2  Ancien marqueur de débogage.
     *
     * @return void
     */
    public function cleSecondaire($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        // Verification de la cle secondaire : document_numerise
        $this->rechercheTable($this->f->db, "document_numerise", "document_numerise_type", $id);
    }


    /**
     * Récupère la liste des codes dont le champ filtre est à 'true'.
     *
     * @param string $filtre Nom champ filtre (aff_da ou aff_service_consulte).
     *
     * @return mixed Tableau des codes ou false
     */
    public function get_code_by_filtre($filtre) {

        // On vérifie que le champ permettant le filtre, passé en paramètre,
        // existe dans la table des types de pièce
        if ($filtre !== 'aff_da' && $filtre !== 'aff_service_consulte') {
            //
            return false;
        }

        // Requête SQL
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    code
                FROM
                    %1$sdocument_numerise_type
                WHERE
                    %2$s = \'t\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($filtre)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        //
        $list_code = array();
        foreach ($qres['result'] as $row) {
            $list_code[] = $row['code'];
        }

        // Retourne la liste des codes
        return $list_code;
    }


    /**
     * Permet de modifier le fil d'Ariane.
     * 
     * @param string $ent Fil d'Ariane.
     *
     * @return string
     */
    public function getFormTitle($ent) {

        // Fil d'ariane par défaut
        $ent = _("parametrage")." -> "._("Gestion des pièces")." -> "._("document_numerise_type");

        // Si différent de l'ajout
        if($this->getParameter("maj") != 0) {

            // Affiche la clé primaire
            $ent .= " -> ".$this->getVal("document_numerise_type");

            // Affiche le code
            $ent .= " ".mb_strtoupper($this->getVal("code"), 'UTF-8');
        }

        // Change le fil d'Ariane
        return $ent;
    }

    /**
     * TRIGGER - triggermodifier.
     *
     * @return boolean
     */
    function triggermodifier($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        //
        $aff_da = $this->get_boolean_from_pgsql_value($this->getVal('aff_da'));
        //
        $aff_service_consulte = $this->get_boolean_from_pgsql_value($this->getVal('aff_service_consulte'));
        // Si le champ 'aff_da' ou le champ 'aff_service_consulte' sont modifiés
        if ($aff_da !== $this->valF['aff_da']
            || $aff_service_consulte !== $this->valF['aff_service_consulte']) {
            // Met à vrai le marqueur pour mettre à jour les métadonnées
            $this->valF['synchro_metadonnee'] = true;
        }
        // Vérifie si c'est un type appartenant à la catégorie plat'au et si c'est le cas
        // empêche sa modification
        if ($this->is_categorie_platau()) {
            $this->addToMessage(__('Les types de pièces de catégorie Plat\'AU ne peuvent pas être modifiée.'));
            return false;
        }
        //
        return true;
    }

    /**
     * Permet de savoir si le type de document numérisé est de catégorie Plat'AU
     * ou as.
     *
     * @return boolean true : Plat'AU, false : pas Plat'AU
     */
    public function is_categorie_platau() {
        // Récupération de la catégorie de document numérisé pour savoir si
        // c'est un document de catégorie PLATAU
        $categorie = $this->f->get_inst__om_dbform(array(
            'obj' => 'document_numerise_type_categorie',
            'idx' => $this->getVal('document_numerise_type_categorie')
        ));
        return $categorie->getVal('code') == CODE_CATEGORIE_DOC_NUM_PLATAU;
    }

    /**
     * Récupère la liste des identifiants de type de pièces dont le champ
     * 'synchro_metadonnee' est égale à la valeur passé en paramètre.
     *
     * @param boolean $sm_value True ou false.
     *
     * @return mixed Tableau des identifiants ou false.
     */
    public function get_ids_by_synchro_metadonnee($sm_value) {

        // Le champ 'synchro_metadonnee' est un booléen
        if ($sm_value !== true && $sm_value !== false) {
            //
            return false;
        }

        // Requête SQL
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    document_numerise_type
                FROM
                    %1$sdocument_numerise_type
                WHERE
                    synchro_metadonnee = \'%2$s\'',
                DB_PREFIXE,
                ($sm_value === true) ? "t" : "f"
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Tableau des résultats
        $list_ids = array();
        foreach ($qres['result'] as $row) {
            $list_ids[] = $row['document_numerise_type'];
        }

        // Retourne la liste des codes
        return $list_ids;
    }


    /**
     * Récupère la liste des documents numérisés dont le type est présent dans
     * le tableau passé en paramètre.
     *
     * @param array $dnt_ids Liste des identifiants de type.
     *
     * @return mixed Tableau des identifiants ou false.
     */
    public function get_dn_by_dnt_ids(array $dnt_ids) {

        // Vérifie que c'est un tableau en paramètre
        if (is_array($dnt_ids) === false) {
            //
            return false;
        }

        // Récupère les documents numérisés dont le type est passé en paramètre
        // Requête SQL
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    document_numerise
                FROM
                    %1$sdocument_numerise
                WHERE
                    document_numerise_type
                    IN (%2$s)',
                DB_PREFIXE,
                implode(',', array_map("intval", $dnt_ids))
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Tableau des résultats
        $list_ids = array();
        foreach ($qres['result'] as $row) {
            $list_ids[] = $row['document_numerise'];
        }

        //
        return $list_ids;
    }


    /**
     * Récupère l'instance de document_numerise.
     *
     * @param string $document_numerise Identifiant du document numérisé.
     *
     * @return object
     */
    protected function get_inst_document_numerise($document_numerise) {
        //
        return $this->get_inst_common("document_numerise", $document_numerise);
    }

    /**
     * Surcharge de la methode de verification des contraintes.
     * Affiche une erreur si nul.
     * Affiche un message d'erreur à destination de l'utilisateur si
     * la contrainte de validité unique du code de la pièce n'est pas
     * respectée.
     *
     * @param string Debug Info
     * @param string message DB
     * @param string nom de la table
     *
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val, $dnu1, $dnu2);

        // Check la validité de la date et la met au format Y-m-d si elle est valide
        $dateFinVal = $this->dateDB($val['om_validite_fin']);
        // Si la date est vide alors vérifie si il existe un autre code valide
        if (empty($dateFinVal)) {
            if ($this->check_validite_code_unique($val['code'], $val['document_numerise_type']) === false) {
                $this->addToMessage("Il ne peut pas y avoir deux codes valide pour un type de pièce");
                $this->correct = false;
            }
        } else {
            // Si une date a été saisie, compare cette date à la date du jour et si
            // elle supérieur (= en cours de validité) alors vérifie si la contrainte est respectée
            $dateFinVal = new DateTime($dateFinVal);
            $aujourdhui = new DateTime;
            if ($dateFinVal > $aujourdhui) {
                if ($this->check_validite_code_unique($val['code'], $val['document_numerise_type']) === false) {
                    $this->addToMessage("Il ne peut pas y avoir deux codes valide pour un type de pièce");
                    $this->correct = false;
                }
            }
        }
    }

    /**
     * Vérifie si il existe, dans la base de données, des types de document
     * numérisé de même code et étant valide.
     * Effectue une requête permettant de trouver tous les codes identiques à
     * celui recherché qui sont en cours de validité.
     * Si un résultat est trouvé renvoie false. Sinon renvoie true.
     *
     * @param string code du type de document
     * @param integer identifiant du type de document
     *
     * @return boolean
     */
    protected function check_validite_code_unique($code, $idDn = null) {
        // L'id permet d'empêcher en modification que la ligne modifié soit comptée dans les résultats de la requête.
        // En ajout, ce n'est pas nécessaire et l'id n'est pas récupéré dans le formulaire
        // du coup la valeur -1 est utilisé pour s'assurer qu'aucune ligne ne soit exclus
        $idDn = ! empty($idDn) ? $idDn : -1;
        
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$sdocument_numerise_type
                WHERE
                    document_numerise_type.code LIKE \'%2$s\'
                    AND ( om_validite_fin IS NULL
                        OR om_validite_fin > CURRENT_DATE)
                    AND document_numerise_type.document_numerise_type != %3$d',
                DB_PREFIXE,
                $this->f->db->escapeSimple($code),
                intVal($idDn)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        if (! empty(array_shift($qres['result']))) {
            return false;
        }
        return true;
    }

}


