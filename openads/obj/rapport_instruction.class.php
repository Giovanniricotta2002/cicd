<?php
/**
 * DBFORM - 'rapport_instruction' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'rapport_instruction'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once ("../gen/obj/rapport_instruction.class.php");

class rapport_instruction extends rapport_instruction_gen {

    var $metadata = array(
        "om_fichier_rapport_instruction" => array(
            "dossier" => "getDossier",
            "dossier_version" => "getDossierVersion",
            "numDemandeAutor" => "getNumDemandeAutor",
            "anneemoisDemandeAutor" => "getAnneemoisDemandeAutor",
            "typeInstruction" => "getTypeInstruction",
            "statutAutorisation" => "getStatutAutorisation",
            "typeAutorisation" => "getTypeAutorisation",
            "dateEvenementDocument" => "getDateEvenementDocument",
            "groupeInstruction" => 'getGroupeInstruction',
            "title" => 'getTitle',
            'concerneERP' => 'get_concerne_erp',

            'type' => 'getDocumentType',
            'dossier_autorisation_type_detaille' => 'getDossierAutorisationTypeDetaille',
            'dossier_instruction_type' => 'getDossierInstructionTypeLibelle',
            'region' => 'getDossierRegion',
            'departement' => 'getDossierDepartement',
            'commune' => 'getDossierCommune',
            'annee' => 'getDossierAnnee',
            'division' => 'getDossierDivision',
            'collectivite' => 'getDossierServiceOrCollectivite'
        ),
    );

    var $abstract_type = array(
        "om_fichier_rapport_instruction" => "file",
    );

    /**
     * Instance de la classe dossier
     *
     * @var mixed
     */
    var $inst_dossier = null;

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 001 - modifier
        // Modification du libellé de l'action "modifier"
        $this->class_actions[1]["portlet"]["libelle"] = _("Modifier");
        $this->class_actions[1]["condition"] = array("show_rapport_instruction_finaliser_portlet_action",
                                                "is_editable");

        // ACTION - 002 - supprimer
        // Modification de la condition d'affichage de l'action "supprimer"
        $this->class_actions[2]["condition"] = array("show_rapport_instruction_finaliser_portlet_action",
                                                "is_deletable");

        // ACTION - 100 - edition
        // Permet d'afficher l'édition du rapport d'instruction
        $this->class_actions[100] = array(
            "identifier" => "edition",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("Edition"),
                "order" => 100,
                "class" => "pdf-16",
            ),
            "view" => "view_edition",
            "permission_suffix" => "consulter",
        );

        // ACTION - 110 - finalise
        // Permet de finaliser le rapport d'instruction
        $this->class_actions[110] = array(
            "identifier" => "finalise",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Finaliser le document"),
                "order" => 110,
                "class" => "finalise",
            ),
            "view" => "formulaire",
            "method" => "finalize",
            "button" => "finalise",
            "permission_suffix" => "finaliser",
            "condition" => array("show_rapport_instruction_finaliser_portlet_action",
                            "is_finalizable"),
        );

        // ACTION - 120 - definalise
        // Permet de reprendre la rédaction du rapport d'instruction
        $this->class_actions[120] = array(
            "identifier" => "definalise",
            "portlet" => array(
                "type" => "action-direct",
                "libelle" => _("Reprendre la redaction du document"),
                "order" => 120,
                "class" => "definalise",
            ),
            "view" => "formulaire",
            "method" => "unfinalize",
            "button" => "definalise",
            "permission_suffix" => "definaliser",
            "condition" => array("show_unfinalize_portlet_action", 
                            "is_unfinalizable"),
        );

        // ACTION - 400 - preview_edition
        // /!\ ne pas changer le numéro d'action sinon la prévisualisation
        // depuis l'onglet document ne sera plus dirigé vers la bonne action
        $this->class_actions[400] = array(
            "identifier" => "preview_edition",
            "view" => "formulaire",
            "permission_suffix" => "previsualiser",
        );
    }

    /**
     * CONDITION - is_editable.
     *
     * Condition pour afficher le bouton de modification.
     *
     * @return boolean
     */
    function is_editable() {
        
        //
        if ($this->f->can_bypass("rapport_instruction", "modifier")){
            return true;
        }
        
        if ($this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        //
        return false;
    }

    /**
     * CONDITION - is_deletable.
     *
     * Condition pour afficher le bouton de suppression.
     *
     * @return boolean
     */
    function is_deletable() {

        if ($this->f->can_bypass("rapport_instruction", "supprimer")){
            return true;
        }
        
        if ($this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        
        return false;
    }

    /**
     * CONDITION - is_finalizable.
     *
     * Condition pour afficher le bouton de finalisation.
     *
     * @return boolean
     */
    function is_finalizable() {

        if($this->f->can_bypass("rapport_instruction", "finaliser")){
            return true;
        }
        
        if ($this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        
        return false;
    }

    /**
     * CONDITION - is_unfinalizable.
     *
     * Condition pour afficher le bouton de définalisation.
     *
     * @return boolean
     */
    function is_unfinalizable() {

        if($this->f->can_bypass("rapport_instruction", "definaliser")){
            return true;
        }
        
        if ($this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        
        return false;
    }

    /**
     * Clause from pour la requête de sélection des données de l'enregistrement.
     *
     * @return string
     */
    function get_var_sql_forminc__tableSelect() {
        return sprintf(
            '%1$s%2$s
                LEFT JOIN %1$sdossier
                    ON rapport_instruction.dossier_instruction=dossier.dossier',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "rapport_instruction",
            "dossier_instruction",
            "dossier_libelle",
            "analyse_reglementaire_om_html",
            "description_projet_om_html",
            "complement_om_html",
            "proposition_decision",
            "om_fichier_rapport_instruction",
            "om_final_rapport_instruction",
            "om_fichier_rapport_instruction_dossier_final",
            "'' as live_preview",
        );
    }

    /**
     * VIEW - view_edition.
     *
     * Permet de visualiser le pdf en le générant ou en le récupérant depuis
     * le système de fichier.
     *
     * @return void
     */
    function view_edition() {

        //
        if($this->getVal("om_final_rapport_instruction") == 't'
            && $this->getVal("om_final_rapport_instruction") != null) {

            //
            $lien = '../app/index.php?module=form&snippet=file&obj='.$this->table.'&'.
                    'champ=om_fichier_rapport_instruction&id='.$this->getVal($this->clePrimaire);
            //
            header("Location: ".$lien);
        } else {

            // Identifiant du rapport d'instruction
            $idx = $this->getVal($this->clePrimaire);

            // Récupère la colelctivité du dossier d'instruction
            $dossier_instruction_om_collectivite = $this->get_dossier_instruction_om_collectivite();

            //
            $collectivite = $this->f->getCollectivite($dossier_instruction_om_collectivite);

            // Paramètres du PDF
            $params = array(
                "watermark" => true,
                "specific" => array(
                    "mode" => "previsualisation",
                ),
            );
            // Génération du PDF
            $result = $this->compute_pdf_output('etat', $this->table, $collectivite, $idx, $params);
            // Affichage du PDF
            $this->expose_pdf_output(
                $result['pdf_output'], 
                $result['filename']
            );
        }
    }

    /**
     * Récupère la collectivité du dossier d'instruction.
     *
     * @return integer
     */
    function get_dossier_instruction_om_collectivite() {

        //
        $dossier_instruction = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_instruction",
            "idx" => $this->getVal('dossier_instruction'),
        ));

        //
        return $dossier_instruction->getVal('om_collectivite');
    }
    
    // Modification du style de certains champs
    function setType(&$form,$maj) {
        parent::setType($form,$maj);

        $form->setType('dossier_instruction', 'hidden');
        $form->setType('om_fichier_rapport_instruction_dossier_final', 'hidden');
        $form->setType('live_preview', 'hidden');
        
        if( $maj < 2 ){           
            // Select pour le proposition de décision
            $form->setType('proposition_decision', 'select');
        }

        // Modification 
        $form->setType('dossier_libelle', 'hiddenstatic');
        
        //Cache les champs pour la finalisation
        $form->setType('om_fichier_rapport_instruction', 'hidden');
        $form->setType('om_final_rapport_instruction', 'hidden');

        //
        if($maj == 110 || $maj == 120) {
            //
            foreach ($this->champs as $value) {
                //
                $form->setType($value, 'hidden');
            }
        }

        if ($maj == 400) {
            foreach ($this->champs as $champ) {
                $form->setType($champ, 'hidden');
            }
            $form->setType('live_preview', 'previsualiser');
        }
    }


    function setLib(&$form, $maj) {
        //
        parent::setLib($form, $maj);
        //
        $form->setLib('dossier_libelle', _("dossier_libelle"));
        $form->setLib("live_preview", "");
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        //
        if ($maj == 0) {
            // Analyse réglementaire
            // Choisi par l'administrateur
            $temp_analyse_reglementaire = explode("\r", $this->f->getParameter("rapport_instruction_analyse_reglementaire"));
            $analyse_reglementaire = "";
            foreach ($temp_analyse_reglementaire as $value) {
                $analyse_reglementaire .= "<p>".$value."</p>";
            }
            $form->setVal("analyse_reglementaire_om_html", $analyse_reglementaire);
            // Description du projet
            // Libellé des travaux du dossier en cours
            // Création de la requête
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                    dossier_libelle, 
                    CONCAT(
                        donnees_techniques.am_projet_desc,
                        \' \',
                        donnees_techniques.co_projet_desc
                    ) AS libelle
                FROM
                    %1$sdossier
                    LEFT JOIN %1$sdonnees_techniques
                        ON donnees_techniques.dossier_instruction = dossier.dossier
                WHERE 
                    dossier.dossier=\'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idxformulaire)
                ),
                array(
                    "origin" => __METHOD__
                )
            );
            // Si le champ travaux est rempli
            foreach($qres['result'] as $row) {
                if ($row["libelle"] != "") {
                    $description_projet = $row["libelle"];
                    $form->setVal("description_projet_om_html", $description_projet);
                }
                // Ajout automatique du numéro de dossier d'instruction
                $form->setVal("dossier_libelle", $row["dossier_libelle"]);
            }
            // Ajout automatique du numéro de dossier d'instruction
            $form->setVal("dossier_instruction", $idxformulaire);
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        //parent::setSelect($form, $maj);
        // Lors d'un ajout ou d'une modification
        if( $maj < 2 ){
            
            // proposition_decision
            $contenu=array();

            $k = 0;
            $contenu[0][$k]="";
            $contenu[1][$k++]=_('choisir')." "._('proposition_decision');
            
            // Si le paramètre existe et a été remplie
            if ( !is_null($this->f->getParameter('rapport_instruction_proposition_decision'))){
                             
                $donnees = $this->f->getParameter('rapport_instruction_proposition_decision');
                $donnees = explode('<br />', nl2br(htmlentities($donnees)));
                
                // Pour chaque ligne du paramètre, faire une ligne dans le select
                foreach ($donnees as $value) {
                
                    $contenu[0][$k]=$value;
                    $contenu[1][$k++]=$value;
                }
            }
            $form->setSelect("proposition_decision",$contenu);
            
        }

        // Fenetre d'affichage du pdf du rapport d'instruction
        if ($maj == 400) {
            $file = $this->f->storage->get($this->getVal('om_fichier_rapport_instruction'));
            $form->setSelect('live_preview', array(
                'base64' => base64_encode($file['file_content']),
                'mimetype' => $file['metadata']['mimetype'],
                'label' => 'rapport d\'instruction',
                'href' => sprintf(
                    '../app/index.php?module=form&snippet=file&obj=rapport_instruction&champ=om_fichier_rapport_instruction&id=%1$s',
                    $this->getVal($this->clePrimaire)
                )
            ));
        }
    }


    /**
     * Récupération du numéro de dossier d'instruction à ajouter aux métadonnées
     * @return string numéro de dossier d'autorisation
     */
    protected function getDossier($champ = null) {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier;
    }
    /**
     * Récupération la version du dossier d'instruction à ajouter aux métadonnées
     * @return int Version
     */
    protected function getDossierVersion() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->version;
    }
    /**
     * Récupération du numéro de dossier d'autorisation à ajouter aux métadonnées
     * @return string numéro de dossier d'autorisation
     */
    protected function getNumDemandeAutor() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier_autorisation;
    }
    /**
     * Récupération de la date de demande initiale du dossier à ajouter aux métadonnées
     * @return date date de la demande initiale
     */
    protected function getAnneemoisDemandeAutor() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->date_demande_initiale;
    }
    /**
     * Récupération du type de dossier d'instruction à ajouter aux métadonnées
     * @return string type du dossier d'instruction
     */
    protected function getTypeInstruction() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier_instruction_type;
    }
    /**
     * Récupération du statut du dossier d'autorisation à ajouter aux métadonnées
     * @return string avis
     */
    protected function getStatutAutorisation() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->statut;
    }
    /**
     * Récupération du type de dossier d'autorisation à ajouter aux métadonnées
     * @return string type de dossier d'autorisation
     */
    protected function getTypeAutorisation() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier_autorisation_type;
    }
    /**
     * Récupération de la date d'ajout de document à ajouter aux métadonnées
     * @return date de l'évènement
     */
    protected function getDateEvenementDocument() {
        return date("Y-m-d");
    }
    /**
     * Récupération du groupe d'instruction à ajouter aux métadonnées
     * @return string Groupe d'instruction
     */
    protected function getGroupeInstruction() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->groupe_instruction;
    }
    /**
     * Récupération du type du document à ajouter aux métadonnées
     * @return string Type de document
     */
    protected function getTitle() {
        return "Rapport d'instruction";
    }


    /**
     * Récupération du champ ERP du dossier d'instruction.
     *
     * @return boolean
     */
    public function get_concerne_erp() {
        //
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        //
        return $this->specificMetadata->erp;
    }


    /**
     * Cette méthode permet de stocker en attribut toutes les métadonnées
     * nécessaire à l'ajout d'un document.
     */
    public function getSpecificMetadata() {
        //Requête pour récupérer les informations essentiels sur le dossier d'instruction
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    dossier.dossier AS dossier,
                    dossier_autorisation.dossier_autorisation AS dossier_autorisation, 
                    to_char(dossier.date_demande, \'YYYY/MM\') AS date_demande_initiale,
                    dossier_instruction_type.code AS dossier_instruction_type, 
                    etat_dossier_autorisation.libelle AS statut,
                    dossier_autorisation_type.code AS dossier_autorisation_type,
                    groupe.code AS groupe_instruction,
                    CASE WHEN dossier.erp IS TRUE
                        THEN \'true\'
                        ELSE \'false\'
                    END AS erp
                FROM %1$sdossier 
                    LEFT JOIN %1$sdossier_instruction_type  
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    LEFT JOIN %1$sdossier_autorisation 
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation 
                    LEFT JOIN %1$setat_dossier_autorisation
                        ON  dossier_autorisation.etat_dossier_autorisation = etat_dossier_autorisation.etat_dossier_autorisation
                    LEFT JOIN %1$sdossier_autorisation_type_detaille
                        ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    LEFT JOIN %1$sdossier_autorisation_type
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                    LEFT JOIN %1$sgroupe
                        ON dossier_autorisation_type.groupe = groupe.groupe
                WHERE
                    dossier.dossier = \'%2$s\' ',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal("dossier_instruction"))
            ),
            array(
                "origin" => __METHOD__,
                'mode' => DB_FETCHMODE_OBJECT
            )
        );
        //Le résultat est récupéré dans un objet
        $row = array_shift($qres['result']);
        //Si il y a un résultat
        if ($row !== null) {

            // Instrance de la classe dossier.
            // Il est nécessaire de préciser l'identifiant du dossier d'instruction
            // car le nom du champ n'est pas identique au nom de la table.
            // S'ils avaient été identiques, alors get_inst_common aurait récupérée
            // l'identifiant.
            $inst_dossier = $this->get_inst_dossier($this->getVal('dossier_instruction'));

            // Insère l'attribut version à l'objet
            $row->version = $inst_dossier->get_di_numero_suffixe();

            //Alors on créé l'objet dossier_instruction
            $this->specificMetadata = $row;
        }
    }

    /**
     * Récupère le numéro de la prochaine version du rapport
     * d'instruction.
     */
    protected function get_prochaine_version_ri() {
        // Récupère le numéro de version de la dernière version enregistré.
        // Le dernier numéro de version ne peut pas être récupéré a l'aide d'un
        // MAX car il s'agit d'une chaine de caractère pour la requête et donc
        // 9 est plus grand que 10. Le numéro de version va donc stagner à 10.
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    COALESCE(MAX((storage.info::json->>\'version\')::int), 0)
                FROM
                    %1$sstorage
                WHERE
                    storage.info::json->>\'dossier\' = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal('dossier_instruction'))
            )
        );
        return ($qres["result"] + 1);
    }

    /**
     * Récupère les informations nécessaire au stockage du rapport d'instruction
     * et le stocke dans la table storage.
     */
    protected function ajouter_ri_table_storage($uid, $metadata, $version, $dossier_instruction_om_collectivite) {
        // Préparation du json contenant les données manquantes du tableau
        $jsonInfo = json_encode(array(
            'version' => $version,
            'createur' => $this->f->get_connected_user_login_name(),
            'dossier' => $this->getVal('dossier_instruction')
        ));
        // Préparation du tableau contenant les valeurs à transmettre à la BD 
        $valF = array(
            'storage' => $this->db->nextId(DB_PREFIXE.'storage'),
            'creation_date' => $metadata['dateEvenementDocument'],
            'creation_time' => date('G:i:s'),
            'uid' => $uid,
            'filename' => $metadata['filename'],
            'size' => $metadata['size'],
            'mimetype' => $metadata['mimetype'],
            'type' => 'rapport_instruction',
            'info' => "$jsonInfo",
            'om_collectivite' => $dossier_instruction_om_collectivite
        );
        // Remplis la table storage en y ajoutant le document finalisé
        $res = $this->f->db->autoExecute(
            DB_PREFIXE.'storage',
            $valF,
            DB_AUTOQUERY_INSERT
        );
        $this->addToLog(__METHOD__."(): db->autoExecute(\"".DB_PREFIXE."storage\", ".print_r($valF, true).", DB_AUTOQUERY_INSERT);", VERBOSE_MODE);

        if ($this->f->isDatabaseError($res, true) === true) {
            return false;
        }

        return true;
    }


    /**
     * TREATMENT - finalize.
     * 
     * Permet de finaliser un enregistrement.
     *
     * @param array $val  valeurs soumises par le formulaire
     *
     * @return boolean
     */
    function finalize($val = array()) {
        // Begin
        $this->begin_treatment(__METHOD__);
        
        //
        $ret = $this->manage_finalizing("finalize", $val);

        // Si le traitement ne s'est pas déroulé correctement
        if ($ret !== true) {

            // Return
            return $this->end_treatment(__METHOD__, false);
        }

        // Return
        return $this->end_treatment(__METHOD__, true);
        
    }

    /**
     * TREATMENT - unfinalize.
     * 
     * Permet de definaliser un enregistrement.
     *
     * @param array $val  valeurs soumises par le formulaire
     *
     * @return boolean
     */
    function unfinalize($val = array()) {
        // Begin
        $this->begin_treatment(__METHOD__);

        //
        $ret = $this->manage_finalizing("unfinalize", $val);

        // Si le traitement ne s'est pas déroulé correctement
        if ($ret !== true) {

            // Return
            return $this->end_treatment(__METHOD__, false);
        }

        // Return
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Finalisation des documents.
     * 
     * @param string $mode finalize/unfinalize
     * @param array  $val  valeurs soumises par le formulaire
     */
    function manage_finalizing($mode = null, $val = array()) {
        //
        $this->begin_treatment(__METHOD__);

        //
        $id_rapport = $this->getVal($this->clePrimaire);

        // Recuperation de la valeur de la cle primaire de l'objet
        $id = $this->getVal($this->clePrimaire);

        //
        $admin_msg_error = _("Veuillez contacter votre administrateur.");
        $file_msg_error = _("Erreur de traitement de fichier.")
            ." ".$admin_msg_error;
        $bdd_msg_error = _("Erreur de base de données.")
            ." ".$admin_msg_error;
        $log_msg_error = "Finalisation non enregistrée - id rapport_instruction = %s - uid fichier = %s";

        // Si on finalise le document
        if ($mode == "finalize") {
            //
            $etat = _('finalisation');

            // Récupère la colelctivité du dossier d'instruction
            $dossier_instruction_om_collectivite = $this->get_dossier_instruction_om_collectivite();
            //
            $collectivite = $this->f->getCollectivite($dossier_instruction_om_collectivite);
            // Génération du PDF
            $result = $this->compute_pdf_output('etat', $this->table, $collectivite, $id_rapport);
            $pdf_output = $result['pdf_output'];

            //Métadonnées du document
            $version = $this->get_prochaine_version_ri();
            $metadata = array(
                'filename' => 'rapport_instruction_'.$version.'.pdf',
                'mimetype' => 'application/pdf',
                'size' => strlen($pdf_output)
            );
            // Récupération des métadonnées calculées après validation
            $spe_metadata = $this->getMetadata("om_fichier_rapport_instruction");

            // Assemble les métadonnées
            $metadata = array_merge($metadata, $spe_metadata);
            // Ajoute le nouveaux document sur le filestorage et dans la base
            $uid = $this->f->storage->create($pdf_output, $metadata, "from_content", $this->table.".om_fichier_rapport_instruction");
            if ($this->ajouter_ri_table_storage($uid, $metadata, $version, $collectivite['om_collectivite_idx']) === false) {
                $this->correct = false;
                $this->addToMessage($bdd_msg_error);
                return $this->end_treatment(__METHOD__, false);
            }
        }

        // Si on définalise le document
        if ($mode == "unfinalize") {
            //
            $etat = _('définalisation');
            // Récupération de l'uid du document finalisé
            $uid = $this->getVal("om_fichier_rapport_instruction");
        }

        // Si on définalise l'UID doit être défini
        // Si on finalise la création/modification du fichier doit avoir réussi
        if ($uid == '' || $uid == 'OP_FAILURE'){
            $this->correct = false;
            $this->addToMessage($file_msg_error);
            $this->addToLog(sprintf($log_msg_error, $id_rapport, $uid), DEBUG_MODE);
            return $this->end_treatment(__METHOD__, false);
        }

        //
        foreach ($this->champs as $key => $value) {
            //
            $val[$value] = $this->val[$key];
        }
        $this->setvalF($val);

        // Verification de la validite des donnees
        $this->verifier($this->val);
        // Si les verifications precedentes sont correctes, on procede a
        // la modification, sinon on ne fait rien et on retourne une erreur
        if ($this->correct === true) {

            //
            $valF = array();
            if($mode=="finalize") {
                $valF["om_final_rapport_instruction"] = true;
            } else {
                $valF["om_final_rapport_instruction"] = false;
            }
            $valF["om_fichier_rapport_instruction"] = $uid;

            // Execution de la requête de modification des donnees de l'attribut
            // valF de l'objet dans l'attribut table de l'objet
            $res = $this->f->db->autoExecute(DB_PREFIXE.$this->table, $valF, 
                DB_AUTOQUERY_UPDATE, $this->getCle($id_rapport));
            $this->addToLog(
                __METHOD__."() : db->autoExecute(\"".DB_PREFIXE.$this->table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$this->getCle($id_rapport)."\")",
                VERBOSE_MODE
            );
            //
            if ($this->f->isDatabaseError($res, true) === true) {
                $this->correct = false;
                $this->addToMessage($bdd_msg_error);
                return $this->end_treatment(__METHOD__, false);
            }

            //
            $this->addToMessage(sprintf(_("La %s du document s'est effectuee avec succes."), $etat));
            //
            return $this->end_treatment(__METHOD__, true);
        }
        // L'appel de verifier() a déjà positionné correct à false
        // et défini un message d'erreur.
        $this->addToLog(sprintf($log_msg_error, $id_rapport, $uid), DEBUG_MODE);
        return $this->end_treatment(__METHOD__, false);
    }

    /**
     * Si le document est finalisé l'action "finaliser" n'est pas affichée
     *
     * @return boolean true sinon lu false sinon
     */
    function show_rapport_instruction_finaliser_portlet_action() {
        if ($this->is_document_finalized("om_final_rapport_instruction")) {
            return false;
        }
        return true;
    }
    
    /**
     * Retourne is_document_finalized("om_final_consultation")
     *
     * @return boolean true si finalisé false sinon
     */
    function show_unfinalize_portlet_action() {
        return $this->is_document_finalized("om_final_rapport_instruction");
    }
    
    /**
     * Permet de savoir si le document passé en paramètre est finalisé
     *
     * @param string $field flag finalisé
     *
     * @return boolean true si finalisé false sinon
     */
    function is_document_finalized($field) {
        if($this->getVal($field) == 't') {
            return true;
        }
        return false;
    }


    /**
     * Retourne la cible de retour (VIEW formulaire et VIEW sousformulaire).
     *
     * La cible de retour peut être 'form' ou 'tab'. L'ergonomie permet donc
     * de renvoyer soit sur la vue de l'élément (form) soir sur le listing
     * (tab).
     *
     * @return string
     */
    function get_back_target() {
        //
        return "form";
    }


    /**
     * Indique si la redirection vers le lien de retour est activée ou non.
     *
     * L'objectif de cette méthode est de permettre d'activer ou de désactiver
     * la redirection dans certains contextes.
     *
     * @return boolean
     */
    function is_back_link_redirect_activated() {
        //
        $crud = $this->get_action_crud();
        //
        if ($crud === 'delete' || $crud === 'create') {
            //
            return false;
        }
        //
        return true;
    }

    protected function getDocumentType($champ = null) {
        return __("Rapport d'instruction");
    }


    function sousFormSpecificContent($maj) {
        //
        $crud = $this->get_action_crud($maj);
        //
        if ($crud === 'read') {
            if ($this->f->isAccredited(array("storage", "storage_tab"), "OR")) {
                // Affiche le tableau des versions
                $link_tab_storage = OM_ROUTE_SOUSTAB.'&obj=storage&idxformulaire='.$this->getval('dossier_instruction').'&retour=tab&retourformulaire=rapport_instruction';
                $tab_storage = sprintf(
                    '<div id="sousform-storage-rapport_instruction" class="rapport_instruction-form-bloc-tab"></div>
                    <script type="text/javascript" >
                        ajaxIt(\'storage-rapport_instruction\', \'%1$s\');
                    </script>',
                    $link_tab_storage
                );
                printf(
                    "<br/><div id=\"rapport_instruction-form-histo\" class=\"rapport_instruction-form-bloc-end\"><h3>%s</h3>%s</div>",
                    __("Historique des versions"),
                    $tab_storage
                );
            }
        }
    }

    /**
     * SURCHARGE depuis om_dbform.class.php
     *
     * Méthode de traitement de fichier uploadé : récupération du fichier temporaire,
     * pour la suppression.
     *
     * @return string/boolean retourne true ou un message d'erreur
     */
    function traitementFichierUploadSuppression() {
        // Le fichier étant utilisé dans l'historisation il n'est pas supprimé
        return true;
    }

}// fin classe

