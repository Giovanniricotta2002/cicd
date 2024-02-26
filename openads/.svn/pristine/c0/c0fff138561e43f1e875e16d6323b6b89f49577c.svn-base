<?php
/**
 * DBFORM - 'document_numerise' - Surcharge gen.
 *
 * @package openads
 * @version SVN : $Id: document_numerise.class.php 6565 2017-04-21 16:14:15Z softime $
 */

//
require_once "../gen/obj/document_numerise.class.php";

// Identifiant plat'AU de la pièce "autre à préciser"
define("CODE_AUTRE_TYPE_PIECE", 111);
define("CODE_TYPE_DOC_TRAVAIL", 'DOCTRAV');

/**
 *
 */
class document_numerise extends document_numerise_gen {

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 000 - ajouter
        // 
        $this->class_actions[0]["condition"] = array("is_ajoutable", "can_user_access_dossier_contexte_ajout");
        
        // ACTION - 001 - modifier
        // 
        $this->class_actions[1]["condition"] = array("is_modifiable", "can_user_access_dossier_contexte_modification");
        
        // ACTION - 002 - supprimer
        //
        $this->class_actions[2]["condition"] = array("is_supprimable", "can_user_access_dossier_contexte_modification", "is_not_deletable_if_file_send_to_platau");

        // ACTION - 004 - view_tab
        // Interface spécifique du tableau des pièces
        $this->class_actions[4] = array(
            "identifier" => "view_tab",
            "view" => "view_tab",
            "permission_suffix" => "tab",
        );

        // ACTION - 005 - ajouter_document_travail
        $this->class_actions[5]= array(
            "identifier" => "ajouter_document_travail",
            "view" => "formulaire",
            "permission_suffix" => "ajouter_document_travail",
            "crud" => "create"
        );

        // ACTION - 100 - Télécharger toutes les pièces numérisées
        $this->class_actions[100] = array(
            "identifier" => "archive_piece",
            "view" => "generate_archive_piece",
             "permission_suffix" => "tab",
        );

        // ACTION - 101 - Télécharger toutes les documents numérisées
        $this->class_actions[101] = array(
            "identifier" => "archive_doc",
            "view" => "generate_archive_doc",
             "permission_suffix" => "dossier_final",
        );

        // ACTION - 300 - view_dossier_final
        // Interface spécifique de constitution du dossier final
        $this->class_actions[300] = array(
            "identifier" => "view_dossier_final",
            "view" => "view_dossier_final",
            "permission_suffix" => "dossier_final",
        );

        // ACTION - 301 - Constituer le dossier final
        $this->class_actions[301] = array(
            "identifier" => "constituer_dossier_final",
            "view" => "constituer_dossier_final",
            "permission_suffix" => "dossier_final",
        );

        // ACTION - 302 - Télécharger le dossier final
        $this->class_actions[302] = array(
            "identifier" => "archive_dossier_final",
            "view" => "generate_archive_dossier_final",
            "permission_suffix" => "dossier_final",
        );


        // ACTION - 303 - Télécharger tous les documents
        $this->class_actions[303] = array(
            "identifier" => "view_tab_telechargement",
            "view" => "view_tab_telechargement",
            "permission_suffix" => "telechargement",
        );

        // ACTION - 304 - Télécharger l'archive de l'onglet téléchargement
        $this->class_actions[304] = array(
            "identifier" => "archive_telechargement",
            "view" => "generate_archive_telechargement",
            "permission_suffix" => "telechargement",
        );

        // ACTION - 310 - view_tab_document
        // Interface spécifique du tableau des documents
        $this->class_actions[310] = array(
            "identifier" => "view_tab_document",
            "view" => "view_tab_document",
            "permission_suffix" => "tab",
        );

        //
        $this->class_actions[400] = array(
            "identifier" => "preview_edition",
            "view" => "formulaire",
            "permission_suffix" => "tab",
        );

        //
        $this->class_actions[997] = array(
            "identifier" => "image_data",
            "view" => "view_image_data",
            "permission_suffix" => "tab",
        );

        //
        $this->class_actions[998] = array(
            "identifier" => "json_data",
            "view" => "view_json_data",
            "permission_suffix" => "consulter",
        );
    }

    /**
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "document_numerise",
            "uid",
            "dossier",
            "nom_fichier",
            "date_creation",
            "document_numerise_type",
            "description_type",
            "document_numerise_nature",
            "uid_dossier_final",
            "document_travail",
            "'' as live_preview",
            "uid_thumbnail",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type_for_dossier_instruction_type() {
        return sprintf(
            'SELECT
                document_numerise_type.document_numerise_type,
                CASE WHEN lien_document_n_type_d_i_t.code IS NULL
                        THEN document_numerise_type.libelle
                    WHEN document_numerise_type.code LIKE \'%2$s\' AND lien_document_n_type_d_i_t.dossier_instruction_type != \'<dossier_instruction_type>\'
                        THEN document_numerise_type.libelle
                    ELSE CONCAT(lien_document_n_type_d_i_t.code, \' | \', document_numerise_type.libelle)
                END AS nomenclature_document_numerise
            FROM
                %1$sdocument_numerise_type 
                    LEFT JOIN %1$slien_document_n_type_d_i_t 
                        ON lien_document_n_type_d_i_t.document_numerise_type = document_numerise_type.document_numerise_type
            WHERE
                (lien_document_n_type_d_i_t.dossier_instruction_type=\'<dossier_instruction_type>\'
                    OR lien_document_n_type_d_i_t.dossier_instruction_type IS NULL
                    OR document_numerise_type.code LIKE \'%2$s\')
                AND document_numerise_type.code NOT LIKE \'%3$s\'
                AND (document_numerise_type.om_validite_fin >= CURRENT_DATE
                    OR document_numerise_type.om_validite_fin IS NULL)
            ORDER BY
                REGEXP_REPLACE(REGEXP_REPLACE(lien_document_n_type_d_i_t.code, \'[[:digit:]]\', \'\', \'g\'), \'-\', \'\', \'g\') ASC,
                SUBSTRING(lien_document_n_type_d_i_t.code FROM \'[0-9]+\')::integer ASC,
                REGEXP_REPLACE(REGEXP_REPLACE(TRIM(REPLACE(lien_document_n_type_d_i_t.code, SUBSTRING(lien_document_n_type_d_i_t.code FROM \'[0-9]+-\'), \'\')), \'[[:alpha:]]\', \'\', \'g\'), \'-\', \'.\', \'g\')::float ASC NULLS FIRST,
                document_numerise_type.libelle ASC',
            DB_PREFIXE,
            CODE_AUTRE_TYPE_PIECE,
            CODE_TYPE_DOC_TRAVAIL
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type_for_user_and_dossier_instruction_type() {
        return sprintf(
            'SELECT
                document_numerise_type.document_numerise_type,
                CASE WHEN lien_document_n_type_d_i_t.code IS NULL
                        THEN document_numerise_type.libelle
                    WHEN document_numerise_type.code LIKE \'%2$s\' AND lien_document_n_type_d_i_t.dossier_instruction_type != \'<dossier_instruction_type>\'
                        THEN document_numerise_type.libelle
                    ELSE CONCAT(lien_document_n_type_d_i_t.code, \' | \', document_numerise_type.libelle)
                END AS nomenclature_document_numerise
            FROM
                %1$sdocument_numerise_type 
                    JOIN %1$slien_document_numerise_type_instructeur_qualite
                        ON lien_document_numerise_type_instructeur_qualite.document_numerise_type = document_numerise_type.document_numerise_type
                    JOIN %1$sinstructeur_qualite
                        ON lien_document_numerise_type_instructeur_qualite.instructeur_qualite = instructeur_qualite.instructeur_qualite
                    JOIN %1$sinstructeur
                        ON instructeur.instructeur_qualite = instructeur_qualite.instructeur_qualite
                    JOIN %1$som_utilisateur 
                        ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
                    LEFT JOIN %1$slien_document_n_type_d_i_t 
                        ON lien_document_n_type_d_i_t.document_numerise_type = document_numerise_type.document_numerise_type
            WHERE 
                om_utilisateur.login=\'<om_utilisateur_login>\'
                AND (lien_document_n_type_d_i_t.dossier_instruction_type=\'<dossier_instruction_type>\'
                    OR lien_document_n_type_d_i_t.dossier_instruction_type IS NULL
                    OR document_numerise_type.code LIKE \'%2$s\')
                AND document_numerise_type.code NOT LIKE \'%3$s\'
                AND (document_numerise_type.om_validite_fin >= CURRENT_DATE
                    OR document_numerise_type.om_validite_fin IS NULL)
            ORDER BY
                REGEXP_REPLACE(REGEXP_REPLACE(lien_document_n_type_d_i_t.code, \'[[:digit:]]\', \'\', \'g\'), \'-\', \'\', \'g\') ASC,
                SUBSTRING(lien_document_n_type_d_i_t.code FROM \'[0-9]+\')::integer ASC,
                REGEXP_REPLACE(REGEXP_REPLACE(TRIM(REPLACE(lien_document_n_type_d_i_t.code, SUBSTRING(lien_document_n_type_d_i_t.code FROM \'[0-9]+-\'), \'\')), \'[[:alpha:]]\', \'\', \'g\'), \'-\', \'.\', \'g\')::float ASC NULLS FIRST,
                document_numerise_type.libelle ASC',
            DB_PREFIXE,
            CODE_AUTRE_TYPE_PIECE,
            CODE_TYPE_DOC_TRAVAIL
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_document_numerise_type_for_user() {
        return sprintf(
            'SELECT
                document_numerise_type.document_numerise_type,
                document_numerise_type.libelle
            FROM
                %1$sdocument_numerise_type 
                    JOIN %1$slien_document_numerise_type_instructeur_qualite
                        ON lien_document_numerise_type_instructeur_qualite.document_numerise_type = document_numerise_type.document_numerise_type
                    JOIN %1$sinstructeur_qualite
                        ON lien_document_numerise_type_instructeur_qualite.instructeur_qualite = instructeur_qualite.instructeur_qualite
                    JOIN %1$sinstructeur
                        ON instructeur.instructeur_qualite = instructeur_qualite.instructeur_qualite
                    JOIN %1$som_utilisateur 
                        ON instructeur.om_utilisateur = om_utilisateur.om_utilisateur
            WHERE 
                om_utilisateur.login=\'<om_utilisateur_login>\'
                AND (document_numerise_type.om_validite_fin >= CURRENT_DATE
                    OR document_numerise_type.om_validite_fin IS NULL)
                AND (document_numerise_type.code NOT LIKE \'%2$s\')
            ORDER BY
                document_numerise_type.libelle ASC',
            DB_PREFIXE,
            CODE_TYPE_DOC_TRAVAIL
        );
    }

    /**
     *
     */
    //Métadonnées spécifiques
    var $metadata = array(
        "uid" => array(
            "dossier" => "getDossier",
            "dossier_version" => "getDossierVersion",
            "numDemandeAutor" => "getNumDemandeAutor",
            "anneemoisDemandeAutor" => "getAnneemoisDemandeAutor",
            "typeInstruction" => "getTypeInstruction",
            "statutAutorisation" => "getStatutAutorisation",
            "typeAutorisation" => "getTypeAutorisation",
            "dateEvenementDocument" => "getDateEvenementDocument",
            "filename" => "getFilename",
            "groupeInstruction" => 'getGroupeInstruction',
            "title" => 'getTitle',
            'consultationPublique' => 'getConsultationPublique',
            'consultationTiers' => 'getConsultationTiers',
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

    var $metadonneesArrete = array();
    
    var $abstract_type = array(
        "uid" => "file",
    );

    var $nomenclaturePieces = null;

    /**
     * Instance de dossier_message
     *
     * @var null
     */
    var $inst_dossier_message = null;

    /**
     * Instance de document_numerise_type
     *
     * @var null
     */
    var $inst_document_numerise_type = null;

    /**
     * Identifiant du message de notification à l'ajout d'une pièce numérisée.
     *
     * @var null
     */
    var $dossier_message_id = null;

    /**
     * Affiche le bouton toggl permet de changer la vue pour les pièces déposées
     * et toutes les pièces constituant le dossier
     *
     * @return void
     */
    function display_toggl_button($obj, $retourformulaire, $idxformulaire) {
        //
        $template = '<div id="switch-toutes_les_pieces-pieces_deposees">
                        %s
                    </div>';

        $template_onclick = 'onclick="ajaxIt(\'%1$s\',\'%2$s&obj=%1$s&action=%3$s&objsf=document_numerise&retourformulaire=%4$s&idxformulaire=%5$s\');"';

        $sous_onglet_list = array(
            'document_numerise' => array(
                'permission' => 'document_numerise',
                'icon' => 'consult',
                'trad' =>__("Pièces pétitionnaire"),
                'onclick' => sprintf($template_onclick, $obj, OM_ROUTE_SOUSFORM, '4', $retourformulaire, $idxformulaire),
                'action' => "4"
            ),
            'document_instruction' => array(
                'permission_1' => 'document_travail',
                'permission_2' => 'document_instruction',
                'icon' => 'consult',
                'trad' => __("Documents d'instruction"),
                'onclick' => sprintf($template_onclick, $obj, OM_ROUTE_SOUSFORM, '310', $retourformulaire, $idxformulaire),
                'action' => "310"
            ),
            'dossier_final' => array(
                'permission' => 'document_numerise_dossier_final',
                'icon' => 'toutes-les-pieces',
                'trad' => __("Dossier final"),
                'onclick' => sprintf($template_onclick, $obj, OM_ROUTE_SOUSFORM, '300', $retourformulaire, $idxformulaire),
                'action' => "300"
            ),
            'telechargement' => array(
                'permission' => 'document_numerise_telechargement',
                'icon' => 'reqmo',
                'trad' => __("Téléchargement"),
                'onclick' => sprintf($template_onclick, $obj, OM_ROUTE_SOUSFORM, '303', $retourformulaire, $idxformulaire),
                'action' => "303"
            )
        );

        $template_sous_onglet = '
            <div class="switcher__label %s" data-view="%s">
                <a class="om-prev-icon om-icon-16 %s-16 right" %s>
                    %s
                </a>
            </div>';

        $sous_onglets_activated = '';

        foreach ($sous_onglet_list as $sous_onglet => $info) {
            if (isset($info['permission'])
                && ($this->f->isAccredited(array('document_numerise', $info['permission'], $info['permission'].'_tab', $info['permission'].'_uid_telecharger'), "OR"))) {
                $sous_onglets_activated .= sprintf(
                    $template_sous_onglet,
                    ($this->getParameter("maj") == $info["action"]) ? "onglet_active"  : "",
                    $info["permission"],
                    $info['icon'],
                    $info['onclick'],
                    $info['trad']
                );
            }
            if (isset($info['permission_1']) && isset($info['permission_2'])) {
                if ($this->f->isAccredited(
                    array(
                        $info['permission_1'],
                        $info['permission_1'].'_tab',
                        $info['permission_2'],
                        $info['permission_2'].'_tab'
                    ), "OR")) {

                    $sous_onglets_activated .= sprintf(
                        $template_sous_onglet,
                        ($this->getParameter("maj") == $info["action"]) ? "onglet_active"  : "",
                        $info["permission_2"],
                        $info['icon'],
                        $info['onclick'],
                        $info['trad']
                    );
                }
            }
        }
        //
        printf(
            $template,
            $sous_onglets_activated
        );
    }

    /**
     * Renvoie le code d'affichage du lien de téléchargement de toutes les pièces d'un tableau.
     *
     * @param string $dossier identifiant du dossier
     * @param string $obj objet concerné
     * @param string $nomObj nom donné à l'objet dans le titre et les messages
     *
     * @return string
     */
    protected function get_link_download_zip($dossier = null, $obj = "", $nomObj = 'documents', $title = "", $action = null) {
        // Affichage de l'action
        if (! empty($dossier)) {
            // Messages de l'action
            $zip_messages = array(
                "title" => _("Téléchargement de l'archive"),
                "confirm_message" => _("Êtes vous sûr de vouloir télécharger l'intégralité des ".$nomObj." du dossier ?"),
                "confirm_button_ok" => _("Oui"),
                "confirm_button_ko" => _("Non"),
                "waiting_message" => _("Votre archive est en cours de préparation. Veuillez patienter."),
                "download_message" => _("Votre archive est prête,"),
                "download_link_message" => _("Cliquez ici pour la télécharger"),
                "error_message" => _("L'archive n'a pas pu être créée. Veuillez contacter votre administrateur."),
            );
            $zip_messages_json = json_encode($zip_messages, JSON_HEX_APOS);
            // Remplacement des messages en JSON dans le template
            return sprintf(
                $this->template_link_download_zip,
                $zip_messages_json,
                $dossier,
                $obj,
                $action,
                $title
            );
        }
        return '';
    }

    /**
     * Compose un tableau en créant les colonnes à l'aide de la liste des
     * champs fournis.
     *
     * @param array $colonnes tableau associatif de la forme : nom_col_res => nom colonne
     * @param array $resultats tableau associatif de la forme : "nom_col_res" => resultat
     * @param string $titre Titre de l'entete du tableau. Si nul pas d'entete de titre 
     *
     * @return string
     */
    protected function compose_listing($colonnes = array(), $resultats = array(), $titre = null) {
        // Ouverture de la balise table
        $this->f->layout->display_table_start_class_default(null);

        // Si il existe un titre ajoute une ligen d'entête avec ce titre
        if (! empty($titre)) {
            printf(
                '<thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol headerCat" colspan="%s">
                            <span class="name">
                                %s
                            </span>
                        </th>
                    </tr>
                </thead>',
                count($colonnes),
                $titre
            );
        }
        // Entete du tableau
        printf(
            '<thead>
                <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">'
        );
        // Création des entêtes de chaque colonne
        $key = 0;
        foreach ($colonnes as $colonne) {
            $param = array(
                "key" => $key,
                "info" =>  $colonnes
            );
            $this->f->layout->display_table_cellule_entete_colonnes($param);
            printf(__($colonne).'</th>');
            $key++;
        }
        printf(
            '</tr>
        </thead>'
        );

        // Remplissage du tableau
        $tr_class = " even ";
        $htmlContenuTab = '';
        foreach ($resultats as $resultat) {
            $numColonne = 0;
            $htmlColonnes = '';
            $tr_class = $tr_class == " odd " ? " even " : " odd ";
            foreach (array_keys($colonnes) as $nomColonne) {
                $htmlColonnes .= sprintf($this->template_cell, $numColonne, "", $resultat[$nomColonne]);
                $numColonne++;
            }
            // Affichage de la ligne du tableau
            $htmlContenuTab = sprintf($this->template_row, $tr_class, $htmlColonnes);
        }

        // Affiche "Aucun enregistrement" si le tableau est vide
        if (empty($htmlContenuTab)) {
            $htmlContenuTab = sprintf(
                '<tr class="tab-data empty">
                    <td colspan="%s">
                        Aucun enregistrement.
                    </td>
                </tr>',
                count($colonnes)
            );
        }

        // Affichage du contenu du tableau
        printf(
            "%s
            </table>",
            $htmlContenuTab
        );
    }

    /**
     * Récupère et renvoie au format json les informations nécessaire
     * permettant d'afficher une image.
     */
    public function view_image_data() {
        $this->checkAccessibility();
        $this->f->disableLog();
        $img = $this->f->storage->get($this->getVal('uid_thumbnail'));
        if (is_array($img) &&
            array_key_exists('file_content', $img) &&
            array_key_exists('metadata', $img)
        ) {
            $min = sprintf(
                'data:%s;base64,%s',
                $img['metadata']['mimetype'],
                chunk_split(base64_encode($img['file_content']))
            );
            printf($min);
        }
    }

    /**
     * Récupération de la liste des pièces (document_numerise) selon le contexte.
     *
     * Contextes possible : dossier_instruction (DI), demande_avis (DAV), dossier_autorisation (DA).
     *  - DI : Récupère toutes les pièces rattachées au dossier sont affichées
     *
     *  - DAV : Récupère les pièces rattachées au dossier sur lequel porte la demande d'avis ET
     *    n'ayant pas un type ne devant pas être affiché en consultation.
     *
     *  - DA : Récupère les pièces rattachées aux DI rattachés au DA ET n'ayant pas un type ne
     *    devant pas être affiché sur les DA.
     *
     *  - autre : affiche tous les documents numérisé n'étant pas des documents de travail
     *  (non utilisé)
     * @param string $contexte : contexte dans lequel on souhaite afficher les documents
     * @param string : identifiant du dossier (DI ou DA selon le contexte).
     * @return array
     */
    protected function get_document_numerise_to_display($contexte, $dossier) {
        // Gestion des filtres en fonction du contexte
        $filtre_dossier = '';
        $filtre_supplementaire = '';
        $type_aff = '';
        $filtre_doc = '';
        $join_sup = '';

        if ($contexte == "dossier_instruction"
            || $contexte == "demande_avis") {
            $filtre_dossier = sprintf(
                "AND document_numerise.dossier = '%s'",
                $this->f->db->escapeSimple($dossier)
            );

            // Définition du type d'affichage permettant de récupérer la liste des documents à filtrer
            if ($contexte === 'demande_avis') {
                $type_aff = 'aff_service_consulte';
            }
        } elseif ($contexte == "dossier_autorisation") {
            $filtre_dossier = sprintf(
                "AND dossier_autorisation.dossier_autorisation = '%s'",
                $this->f->db->escapeSimple($dossier)
            );

            // Si l'option option_cache_piece_num_refuse_da est activée alors on cache
            // les pièces des dossiers d'istruction dont l'avis de décision est de typeavis 'D'
            if ($this->f->getParameter('option_cache_piece_num_refuse_da') == 'true') {
                $filtre_supplementaire = "AND avis_decision.typeavis is null OR avis_decision.typeavis != 'D'\n";
            }
            // Les pièces des dossiers non cloturés, rattaché au DA, ne doivent pas être visible si le
            // DA est paramétré pour que l'instruction soit secrète
            $dossier_autorisation = $this->f->get_inst__om_dbform(array(
                'obj' => 'dossier_autorisation',
                'idx' => $dossier
            ));
            $datd = $this->f->get_inst__om_dbform(array(
                'obj' => 'dossier_autorisation_type_detaille',
                'idx' => $dossier_autorisation->getVal('dossier_autorisation_type_detaille')
            ));
            if ($this->get_boolean_from_pgsql_value($datd->getVal('secret_instruction')) === true
                && $this->f->isAccredited('dossier_autorisation_secret_instruction') === false) {
                $join_sup = sprintf(
                    '-- Ne récupère pas les pièces des dossiers non cloturé
                    INNER JOIN %1$setat
                        ON dossier.etat = etat.etat
                            AND etat.statut = \'cloture\'',
                    DB_PREFIXE
                );
            }

            // Définition du type d'affichage permettant de récupérer la liste des documents à filtrer
            $type_aff = 'aff_da';
        }


        // Récupération du sql permettant d'éliminer les types de document ne devant pas être affichés
        if (! empty($type_aff)) {
            $filtre_doc = $this->get_filtre_type_document($type_aff);
        }

        // Exécution de la requête
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT  
                    document_numerise.document_numerise AS document_numerise,
                    document_numerise.date_creation AS date_creation,
                    document_numerise_type_categorie.libelle AS categorie,
                    document_numerise.nom_fichier AS nom_fichier,
                    document_numerise.description_type AS description_type,
                    document_numerise_type.libelle AS type_document,
                    document_numerise_type.document_numerise_type AS document_numerise_type,
                    document_numerise.uid AS uid,
                    document_numerise.uid_thumbnail AS uid_thumbnail,
                    dossier.dossier AS dossier
                FROM 
                    %1$sdocument_numerise 
                    LEFT JOIN %1$sdocument_numerise_type
                        ON document_numerise.document_numerise_type = document_numerise_type.document_numerise_type
                    LEFT JOIN %1$sdocument_numerise_type_categorie
                        ON document_numerise_type.document_numerise_type_categorie = document_numerise_type_categorie.document_numerise_type_categorie 
                    LEFT JOIN %1$sdossier 
                        ON document_numerise.dossier = dossier.dossier 
                    %2$s
                    LEFT JOIN %1$sdossier_autorisation
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                    LEFT JOIN %1$savis_decision 
                        ON dossier.avis_decision = avis_decision.avis_decision
                WHERE
                    document_numerise.document_travail IS FALSE
                    %3$s
                    %4$s
                    %5$s
                ORDER BY 
                    document_numerise.date_creation, 
                    document_numerise.nom_fichier',
                DB_PREFIXE,
                $join_sup,
                $filtre_dossier,
                $filtre_supplementaire,
                $filtre_doc
            ),
            array(
                'origin' => __METHOD__
            )
        );

        return $qres['result'];
    }

    /**
     * Renvoie le sql des conditions d'exclusion des types de pièce ne devant pas être
     * affichées selon le type de d'affichage voulu.
     * Les types de pièce sont identifiés par leur code.
     *
     * @param string type d'affichage voulu
     * @return string sql des conditions permettant d'exclure les types de pièces ne devant pas
     * être récupérées
     */
    function get_filtre_type_document($type_aff) {
        // Instance de la classe document_numerise_type
        $inst_dnt = $this->get_inst_document_numerise_type();
        // Récupère la liste des codes dont le champ correspondant au type d'affichage est à 'true'
        $listing_pieces_filtre = $inst_dnt->get_code_by_filtre($type_aff);

        $filtre = "";
        if ($listing_pieces_filtre !== false) {
            // Compose la condition de la requête
            foreach ($listing_pieces_filtre as $filtre_code) {
                $filtre .= " document_numerise_type.code = '".$this->f->db->escapesimple(trim($filtre_code))."' OR ";
            }
            $filtre = substr($filtre, 0, strlen($filtre) - 4);
        }

        if ($filtre === "" || $filtre === false) {
            $filtre = "document_numerise_type.code = ''";
        }
        $filtre = sprintf(" AND (%s) ", $filtre);
        return $filtre;
    }

    /**
     * VIEW - view_tab
     * 
     * Cette vue permet d'afficher l'interface spécifique du tableau
     * des pièces (liste et bouton d'ajout).
     *
     * @return void
     */
    function view_tab() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        /**
         *
         */
        echo "\n\n";
        echo "\n<!-- ########## START VIEW DOCUMENT_NUMERISE ########## -->\n";
        echo "\n\n";

        //
        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $idxformulaire = $this->f->get_submitted_get_value('idxformulaire') : $idxformulaire = "");
        ($this->f->get_submitted_get_value('retourformulaire') !== null ? $retourformulaire = $this->f->get_submitted_get_value('retourformulaire') : $retourformulaire = "");
        ($this->f->get_submitted_get_value('obj') !== null ? $obj = $this->f->get_submitted_get_value('obj') : $obj = "");

        /**
         * Récupération de l'identifiant du dossier
         *
         * En fonction du contexte dans lequel on se trouve, on récupère 
         * l'identifiant du dossier selon une méthode différente : 
         * - dans le contexte du DI, on récupère directement depuis les 
         *   paramètres GET passsés à la vue (idxformulaire) l'id du DI
         * - dans le contexte du DA, on récupère directement depuis les 
         *   paramètres GET passsés à la vue (idxformulaire) l'id du DA
         * - dans le contexte d'une consultation pour un service consulté
         *   (demande_avis), on récupère depuis les paramètres GET 
         *   passsés à la vue (idxformulaire) l'id de la consultation puis
         *   on fait une requête pour récupérer l'id du DI
         */

        //
        $contexte = "";
        if ($retourformulaire == "dossier_autorisation") {
            // Si on se trouve dans le contexte d'un dossier d'autorisation
            $contexte = "dossier_autorisation";
            $dossier_autorisation = $idxformulaire;
            $dossier = $dossier_autorisation;
        } elseif ($retourformulaire == 'dossier' || $this->f->contexte_dossier_instruction()) {
            // Si on se trouve dans le contexte d'un dossier d'instruction
            $contexte = "dossier_instruction";
            $dossier_instruction = $idxformulaire;
            $dossier = $dossier_instruction;
            // Action de bascule vers la vue de constitution du dossier final
            // seulement si l'utilisateur connecté a la permission
            if ($this->is_action_available(300) === true
                || $this->is_action_available(303) === true
                || $this->f->isAccredited('document_instruction') === true
                || $this->f->isAccredited('document_travail') === true) {
                $this->display_toggl_button($obj, $retourformulaire, $idxformulaire);
            }
        } elseif ($retourformulaire == "demande_avis"
            || $retourformulaire == "demande_avis_encours"
            || $retourformulaire == "demande_avis_passee") {
            // Si on se trouve dans le contexte d'une demande d'avis
            $contexte = "demande_avis";
            $demande_avis = $idxformulaire;
            // Récupération du dossier en fonction du numéro de consultation
            $inst_consultation = $this->f->get_inst__om_dbform(array(
                "obj" => "consultation",
                "idx" => $demande_avis,
            ));
            $dossier_instruction = $inst_consultation->getVal("dossier");
            $dossier = $dossier_instruction;
        }

        // Template de l'action de prévisualisation dans un overlay avec la miniature
        // TODO : récupérer l'id du dossier autrement que via un attribut id-dossier
        // TODO : gérer le cas ou les miniatures n'ont pas a être affichée
        $template_min_preview_link = '
<a id="action-form-document_numerise-%1$s-preview_edition" id-dossier="%1$s" class="action action-self tooltip" href="%2$s" title="%3$s">
    <span class="om-icon om-icon-16 om-icon-fix preview-16" title="%3$s">
        <span class="tooltip-span">
            <img src="../lib/om-assets/img/loading.gif" class="" alt="%3$s" id="document_numerise_min_%1$s" />
        </span>
    </span>
</a>
        ';

        // Template de l'action de prévisualisation dans un overlay avec l'îcone
        $template_icon_preview_link = '
<a id="action-form-document_numerise-%1$s-preview_edition" class="action action-self" href="%2$s" title="%3$s">
    <span class="om-icon om-icon-16 om-icon-fix preview-16" title="%3$s">
        %3$s
    </span>
</a>
        ';

        // Récupération de la liste des pièces
        $documents = $this->get_document_numerise_to_display($contexte, $dossier);

        /**
         * Gestion du lien vers l'ajout d'une nouvelle pièce
         *
         * Le lien d'ajout d'une nouvelle pièce est disponible uniquement dans
         * le contexte du dossier d'instruction.
         */
        //
        $ct_link_add = "";
        // 
        if ($contexte == "dossier_instruction" 
            && $this->is_action_available(0)) {
            // Affiche bouton ajouter
            $ct_link_add = sprintf(
                $this->template_link_add,
                $obj,
                OM_ROUTE_SOUSFORM,
                $obj,
                $retourformulaire,
                $idxformulaire,
                _("Ajouter une pièce")
            );
        }

        /**
         * Gestion du lien vers le téléchargement de toutes les pièces dans une archive.
         *
         * Le lien est disponible dans l'onglet pièce du DA, du DI, des demandes d'avis
         * en cours et passées.
         */
        //
        $ct_link_download_zip = "";
        if (($contexte == "dossier_instruction"
            OR $contexte == "dossier_autorisation" 
            OR $contexte == "demande_avis")
            AND ($this->f->isAccredited("document_numerise_tab")
                OR $this->f->isAccredited("document_numerise"))) {
            // Identifiant du DA ou DI à passer dans le lien de l'archive zip
            if ($contexte == "dossier_autorisation") {
                $dossier = $dossier_autorisation;
            } else {
                $dossier = $dossier_instruction;
            }
            // Affichage du bouton "Télécharger toutes les pièces" et passage des messages
            // d'erreur à la fonction Javascript qui va afficher la fenêtre modale qui 
            // permet de télécharger l'archive zip.
            if(count($documents) > 0) {
                $ct_link_download_zip = $this->get_link_download_zip(
                    $dossier,
                    $obj,
                    'pièces',
                    _("Télécharger toutes les pièces déposées"),
                    100
                );
            }
        }

        /**
         * Gestion du lien vers la fiche de visualisation de la pièce
         * 
         * Le lien vers la fiche de visualisation d'une pièce est disponible 
         * uniquement dans le contexte du dossier d'instruction.
         */
        //
        if ($contexte == "dossier_instruction" 
            && ($this->f->isAccredited("document_numerise_consulter")
                || $this->f->isAccredited("document_numerise"))
            ) {
            //
            $template_info_view = $this->template_info_view_link;
            $template_icon_view = $this->template_icon_view_link;
        } else {
            // Le template info view avec le lien prend 6 arguments, le
            // 6ème étant le type de pièce. Si l'utilisateur n'a pas accés
            // à la pièce seul le type de pièce doit être affiché soit
            // l'élément numéro 6
            $template_info_view = '%6$s';
            $template_icon_view = "";
        }


        /**
         * Gestion de l'affichage
         */
        // Si on se trouve dans le contexte du dossier d'autorisation alors le 
        // tableau affiche une colonne supplémentaire pour afficher le numéro
        // du dossier
        if ($contexte == "dossier_autorisation") {
            $nb_col = 4;
        } else {
            $nb_col = 3;
        }
        //
        $ct_list_dn = "";
        //
        $i = 1;

        //Résultat à $i - 1 pour tester la date et catégorie des documents
        $lastRes = array();
        $lastRes['date_creation'][0] = "";
        $lastRes['categorie'][0] = "";

        //Tant qu'il y a des résultats
        foreach ($documents as $row) {

            /**
             * Gestion du lien de téléchargement de la pièce
             */
            //
            if ($this->f->isAccredited(array("document_numerise", "document_numerise_uid_telecharger"), "OR")) {
                //
                $template_icon_preview = $template_icon_preview_link;
                if ($this->f->is_option_miniature_fichier_enabled() &&
                    empty($row['uid_thumbnail']) === false) {
                    $template_icon_preview = $template_min_preview_link;
                }
                $template_filename = $this->template_filename_download;
            } else {
                //
                $template_icon_preview = '';
                $template_filename = $this->template_filename_readonly;
            }

            $lastRes['date_creation'][$i] = $row['date_creation'];
            $lastRes['categorie'][$i] = $row['categorie'];

            //Si la date de création est différente de celle du résultat juste avant
            if ($row['date_creation'] != $lastRes['date_creation'][$i-1]) {
                //Si ce n'est pas le premier résultat on ferme la table
                if($i != 1) {
                    $ct_list_dn .= "</table>";
                } 
                //Affiche la table 
                $ct_list_dn .= "<table class='tab-tab document_numerise'>";
                //Affiche le header de la date
                $ct_list_dn .= sprintf(
                    $this->template_header,
                    'headerDate',
                    $nb_col,
                    $this->f->formatDate($row['date_creation'])
                );
                //Affiche le header de la catégorie
                $ct_list_dn .= sprintf(
                    $this->template_header,
                    'headerCat', 
                    $nb_col,
                    $row['categorie']
                );
                //Style des lignes
                $style = 'odd';
            }
            
            //Si la date de création est identique à celle du résultat juste avant
            //et la catégorie est différente de celle du résultat juste avant
            if ($row['date_creation'] == $lastRes['date_creation'][$i-1] && $row['categorie'] != $lastRes['categorie'][$i-1]) {
                //Affiche le header de la catégorie
                $ct_list_dn .= sprintf(
                    $this->template_header,
                    'headerCat',
                    $nb_col,
                    $row['categorie']
                );
                //Style des lignes
                $style = 'odd';
            }

            //Si toujours dans la catégorie on change le style de la ligne
            if ($row['categorie'] == $lastRes['categorie'][$i-1] && $row['date_creation'] == $lastRes['date_creation'][$i-1]) {
                $style = ($style=='even')?'odd':'even';
            }

            //
            $style .= " col".$nb_col;

            // Action de prévisualisation
            $preview_action = sprintf('%s&obj=%s&action=%s&idx=%s&retour=tab', OM_ROUTE_FORM, $obj, 400, $row['document_numerise']);
            $preview_button = sprintf(
                $template_icon_preview,
                $row['document_numerise'],
                $preview_action,
                __("Prévisualiser")
            );

            // Si une description du type à été récupéré alors c'est que la pièce est du
            // type "Autre type à préciser". Dans ce cas on stocke la description pour
            // popuvoir l'afficher à la place du type de pièce
            $descriptionType = null;
            if (! empty($row['description_type'])) {
                $descriptionType = $row['description_type'];
            }
            // Si on est dans la visualisation du DA, on affiche le numéro du dossier 
            // d'instruction auquel est rataché la pièce et le nom du fichier
            if ($contexte === 'dossier_autorisation') {
                // Affichage d'une ligne du listing des pièces composée de :
                //  - l'action de prévisualisation
                //  - le numéro du dossier
                //  - l'action de téléchargement de la pièce et le nom du fichier
                //  - la description du type si elle existe (cas des "Autres à préciser") et le
                //    type de pièce sinon
                $ct_list_dn .= sprintf(
                    $this->template_line_4col,
                    $style,
                    $preview_button,
                    $row['dossier'],
                    sprintf(
                        $template_filename,
                        $row['document_numerise'],
                        $row['document_numerise'],
                        $row['nom_fichier']
                    ),
                    ! empty($descriptionType) ? $descriptionType : $row['type_document']
                );
            } elseif ($contexte === "demande_avis") {
                // Affichage d'une ligne du listing des pièces composée de :
                //  - l'action de prévisualisation
                //  - l'action de téléchargement de la pièce et le nom du fichier
                //  - la description du type si elle existe (cas des "Autres à préciser") et le
                //    type de pièce sinon
                $ct_list_dn .= sprintf(
                    $this->template_line_3col,
                    $style,
                    $preview_button,
                    sprintf(
                        $template_filename,
                        $row['document_numerise'],
                        $row['document_numerise'],
                        $row['nom_fichier']
                    ),
                    ! empty($descriptionType) ? $descriptionType : $row['type_document']
                );
            } elseif ($contexte === 'dossier_instruction') {
                // Récupération du/des code de la pièce pour l'affichage du libellé de la pièce
                $dossierInstruction = $this->f->get_inst__om_dbform(array(
                    'obj' => 'dossier_instruction',
                    'idx' => $idxformulaire
                ));
                $typeDossierInstruction = $dossierInstruction->getVal('dossier_instruction_type');
                $typePiece = $this->get_libelle_piece_avec_nomenclature(
                    $row['type_document'],
                    $row['document_numerise_type'],
                    $typeDossierInstruction
                );

                // Affiche le code de la pièce (s'il existe) et le type de document
                // Dans le cas, ou une description du type a été ajouté affiche la
                // description du type à la place du libellé
                if (! empty($descriptionType)) {
                    // Gestion des deux cas : avec code avant le libellé et sans code
                    $positionSeparateur = strpos($typePiece, '|');
                    if ($positionSeparateur !== false) {
                        $typePiece = substr($typePiece, 0, $positionSeparateur + 2).$descriptionType;
                    } else {
                        $typePiece = $descriptionType;
                    }
                }

                // Affichage d'une ligne du listing des pièces composée de :
                //  - l'action de prévisualisation
                //  - l'action de téléchargement de la pièce et le nom du fichier
                //  - la description du type si elle existe (cas des "Autres à préciser") et le
                //    type de pièce sinon
                $ct_list_dn .= sprintf(
                    $this->template_line_3col,
                    $style,
                    sprintf(
                        '%s%s',
                        sprintf(
                            $template_icon_view,
                            $obj,
                            OM_ROUTE_SOUSFORM,
                            $obj,
                            $row['document_numerise'],
                            $retourformulaire,
                            $idxformulaire
                        ),
                        $preview_button
                    ),
                    sprintf(
                        $template_filename,
                        $row['document_numerise'],
                        $row['document_numerise'],
                        $row['nom_fichier']
                    ),
                    sprintf(
                        $template_info_view,
                        $obj,
                        OM_ROUTE_SOUSFORM,
                        $row['document_numerise'],
                        $retourformulaire,
                        $idxformulaire,
                        $typePiece
                    )
                );
            }

            //
            $i++;

        }

        //On ferme la table
        $ct_list_dn .= "</table>";

        //S'il n'y a pas de résultat on affiche "Aucun enregistrement"
        if (count($documents) == 0) {
            //
            $ct_list_dn = "<p class='noData'>"._("Aucun enregistrement")."</p>";
        }

        /**
         *
         */
        printf(
            $this->template_view,
            $ct_link_add,
            $ct_link_download_zip,
            $ct_list_dn
        );

        /**
         *
         */
        echo "\n\n";
        echo "\n<!-- ########## END VIEW DOCUMENT_NUMERISE ########## -->\n";
        echo "\n\n";
    }

    /**
     * VIEW - view_tab_telechargement
     *
     * Vue permettant de consulter et de télécharger les documents de travail, 
     * les documents d'instructions et les pièces liés au dossier courant
     *
     * @return void
     */
    function view_tab_telechargement() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Récupèration des variables nécessaires
        $idxformulaire = $this->getParameter('idxformulaire');
        $retourformulaire = $this->getParameter('retourformulaire');
        $obj = get_class($this);

        // La vue n'est pas affichée si le contexte n'est un dossier d'instruction
        if (in_array($retourformulaire, $this->foreign_keys_extended["dossier"]) !== true) {
            return;
        }

        /**
         *
         */
        echo "\n\n";
        echo "\n<!-- ########## START VIEW TELECHARGEMENT ########## -->\n";
        echo "\n\n";

        // ACTION BASCULER VERS TELECHARGEMENT
        $this->display_toggl_button($obj, $retourformulaire, $idxformulaire);

        // Message affiché à l'utilisateur
        printf('<div id="form-message-telechargement"></div>');

        /*
        *Requêtes de récupération des fichiers 
        */
        $sql_document_travail = sprintf('
            SELECT
                document_numerise.document_numerise as id,
                document_numerise.date_creation::text as date,
                document_numerise_type_categorie.libelle as categorie,
                document_numerise.nom_fichier as nom_fichier,
                document_numerise_type.libelle as type_document,
                document_numerise.uid as uid,
                \'document_travail\' as classe
            FROM 
                %1$sdocument_numerise
                LEFT JOIN %1$sdocument_numerise_type
                    ON document_numerise.document_numerise_type = document_numerise_type.document_numerise_type
                LEFT JOIN %1$sdocument_numerise_type_categorie
                    ON document_numerise_type.document_numerise_type_categorie = document_numerise_type_categorie.document_numerise_type_categorie 
            WHERE
                document_numerise.document_travail IS TRUE
                AND document_numerise.dossier = \'%2$s\'
            ',
            DB_PREFIXE,
            $idxformulaire
        );


        $sql_document_numerise = sprintf('
            SELECT
                document_numerise.document_numerise as id,
                document_numerise.date_creation::text as date,
                document_numerise_type_categorie.libelle as categorie,
                document_numerise.nom_fichier as nom_fichier,
                document_numerise_type.libelle as type_document,
                document_numerise.uid as uid,
                \'document_numerise\' as classe
            FROM 
                %1$sdocument_numerise 
                LEFT JOIN %1$sdocument_numerise_type
                    ON document_numerise.document_numerise_type = document_numerise_type.document_numerise_type
                LEFT JOIN %1$sdocument_numerise_type_categorie
                    ON document_numerise_type.document_numerise_type_categorie = document_numerise_type_categorie.document_numerise_type_categorie 
                LEFT JOIN %1$sdossier 
                    ON document_numerise.dossier = dossier.dossier
                LEFT JOIN %1$sdossier_autorisation
                    ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
            WHERE
                document_numerise.dossier = \'%2$s\'
                AND document_numerise.document_travail IS FALSE
            ',
            DB_PREFIXE,
            $idxformulaire
        );

        $sql_document_instruction = sprintf('
            SELECT
                instruction.instruction as id,
                CASE WHEN instruction.date_finalisation_courrier IS NOT NULL
                    THEN instruction.date_finalisation_courrier::text
                    ELSE \'Non applicable\' 
                END as date,
                \'%3$s\' as categorie,
                CONCAT(\'instruction_\',instruction.instruction) as nom_fichier,
                om_lettretype.libelle as type_document,
                instruction.om_fichier_instruction as uid,
                \'instruction\' as classe
            FROM 
                %1$sinstruction
                LEFT JOIN %1$som_lettretype ON om_lettretype.id = instruction.lettretype
                INNER JOIN %1$som_collectivite
                    ON om_lettretype.om_collectivite = om_collectivite.om_collectivite
                LEFT JOIN %1$sdossier ON instruction.dossier = dossier.dossier
            WHERE
                instruction.dossier = \'%2$s\'
                AND instruction.om_fichier_instruction is not null
                AND (om_collectivite.om_collectivite = dossier.om_collectivite
                    OR (om_collectivite.niveau = \'2\'
                        AND NOT EXISTS (
                            SELECT
                                other_lettretype.om_lettretype
                            FROM
                                %1$som_lettretype AS other_lettretype JOIN %1$som_collectivite
                                    ON other_lettretype.om_collectivite = om_collectivite.om_collectivite
                            WHERE
                                om_lettretype.id = other_lettretype.id
                                AND om_collectivite.om_collectivite = dossier.om_collectivite
                        )
                    )
                )
            ',
            DB_PREFIXE,
            $idxformulaire,
            __("document généré")
        );

        //Variation du type du document en cas d'avis tacite défini
        $id_tacite = $this->f->getParameter('id_avis_consultation_tacite');
        $consultation_else_type_document = "CONCAT('consultation_', service.type_consultation)";
        if ($id_tacite !== null && trim($id_tacite) !== '') {
            $consultation_else_type_document = sprintf("CASE WHEN consultation.avis_consultation IS NOT NULL
            THEN CASE WHEN consultation.avis_consultation = %s
                    THEN CONCAT('consultation_', service.type_consultation, '_tacite')
                    ELSE CONCAT('consultation_', service.type_consultation)
                END 
            ELSE CONCAT('consultation_',service.type_consultation)
            END ",
            $id_tacite
            );
        }

        $sql_document_consultation = sprintf('
            SELECT
                consultation.consultation as id,
                CASE WHEN consultation.date_retour IS NOT NULL 
                        THEN consultation.date_retour::text
                        ELSE consultation.date_envoi::text
                    END as date,
                CASE WHEN consultation.fichier IS NOT NULL
                        THEN \'%3$s\'
                        ELSE \'%4$s\'
                    END as categorie,
                CASE WHEN consultation.fichier IS NOT NULL
                        THEN CONCAT(\'consultation_avis_\',consultation.consultation)
                        ELSE CONCAT(\'consultation_\',consultation.consultation)
                    END as nom_fichier,
                CASE WHEN consultation.fichier IS NOT NULL
                        THEN CONCAT(\'consultation_avis_\',service.type_consultation)
                        ELSE %5$s
                    END as type_document,
                CASE WHEN consultation.fichier IS NOT NULL
                        THEN fichier
                        ELSE om_fichier_consultation
                    END as uid,
                CASE WHEN consultation.fichier IS NOT NULL
                        THEN \'consultation_fichier\'
                        ELSE \'consultation_om_fichier\'
                    END as classe
            FROM
                %1$sconsultation
            JOIN %1$sservice 
                ON consultation.service = service.service
            WHERE
                consultation.dossier = \'%2$s\'
            AND (consultation.fichier IS NOT NULL
                OR consultation.om_fichier_consultation IS NOT NULL)
            ',
            DB_PREFIXE,
            $idxformulaire,
            $this->f->db->escapeSimple(__("retour d'avis")),
            __("document généré"),
            $consultation_else_type_document
        );

        $sql_document_pec = sprintf('
            SELECT
                consultation.consultation as id,
                \'Non applicable\' as date,
                CONCAT(\'consultation_pec_\',consultation.consultation) as categorie,
                CONCAT(\'consultation_pec_\',consultation.consultation) as nom_fichier,
                \'document PeC\' as type_document,
                consultation.fichier_pec as uid,
                \'consultation_pec\' as classe
            FROM
                %1$sconsultation
            JOIN %1$sservice 
                ON consultation.service = service.service
            WHERE
                consultation.dossier = \'%2$s\'
            AND consultation.fichier_pec IS NOT NULL
            ',
            DB_PREFIXE,
            $idxformulaire
        );

        /*
        * Traitement des fichiers sans date ( càd dont la base ne comporte pas de champ de date) - DEBUT
        *
        */
        $sql_rapport_instruction = sprintf('
            SELECT
                COALESCE(rapport_instruction.rapport_instruction, storage.storage) as id,
                \'Non applicable\' as date,
                \'%3$s\' as categorie,
                storage.filename as nom_fichier,
                \'rapport_instruction\' as type_document,
                storage.uid as uid,
                CASE
                    WHEN rapport_instruction.rapport_instruction IS NULL THEN \'storage\'
                    ELSE \'rapport_instruction\'
                END AS classe
            FROM 
                %1$sstorage LEFT JOIN
                %1$srapport_instruction ON rapport_instruction.om_fichier_rapport_instruction = storage.uid
            WHERE
                storage.info::json->>\'dossier\' = \'%2$s\'
            ',
            DB_PREFIXE,
            $idxformulaire,
            __("document généré")
        );


        // Union dans le but d'afficher ces résultats dans le tableau "document d'instruction"
        $union_query = sprintf("
            (%s)
            UNION
            (%s)
            UNION
            (%s)
            UNION
            (%s)",
            $sql_document_instruction,
            $sql_document_consultation,
            $sql_document_pec,
            $sql_rapport_instruction
        );

        // Exécution de la requête de récupération des fichiers
        $qres_union_instruction = $this->f->get_all_results_from_db_query(
            $union_query,
            array(
                "origin" => __METHOD__,
            )
        );

        // Exécution de la requête de récupération des fichiers
        $qres_document_numerise = $this->f->get_all_results_from_db_query(
            $sql_document_numerise,
            array(
                "origin" => __METHOD__,
            )
        );

        // Exécution de la requête de récupération des fichiers
        $qres_document_travail = $this->f->get_all_results_from_db_query(
            $sql_document_travail,
            array(
                "origin" => __METHOD__,
            )
        );

        $tous_les_tableaux = array();

        $template_link_file_telechargement = $this->template_link_file_telechargement;

        //Affichage du listing des pièces
        $tous_les_tableaux["document_numerise"] = array();
        foreach($qres_document_numerise['result'] as $row) {
            // Dans le cas des documents numérisés récupération du libellé
            $typePiece = $row['type_document'];
            if ($row['classe'] === 'document_numerise') {
                // Récupération du type de document et du dossier pour connaître
                // le type de document et son libellé ainsi que le type de dossier d'instruction.
                // A partir de ces informations le libellé du type est formé.
                $documentNum = $this->f->get_inst__om_dbform(array(
                    'obj' => 'document_numerise',
                    'idx' => $row['id']
                ));
                $dossier = $this->f->get_inst__om_dbform(array(
                    'obj' => 'dossier',
                    'idx' => $idxformulaire
                ));
                $typePiece = $this->get_libelle_piece_avec_nomenclature(
                    $row['type_document'],
                    $documentNum->getVal('document_numerise_type'),
                    $dossier->getVal('dossier_instruction_type')
                );

                // Affiche le code de la pièce (s'il existe) et le type de document
                // Dans le cas, ou une description du type a été ajouté affiche la
                // description du type à la place du libellé
                if (! empty($documentNum->getVal('description_type'))) {
                    // Gestion des deux cas : avec code avant le libellé et sans code
                    $positionSeparateur = strpos($typePiece, '|');
                    if ($positionSeparateur !== false) {
                        $typePiece = substr($typePiece, 0, $positionSeparateur + 2).
                            $documentNum->getVal('description_type');
                    } else {
                        $typePiece = $documentNum->getVal('description_type');
                    }
                }
            }

            $tous_les_tableaux["document_numerise"][] = array(
                "nom_fichier" => $row['nom_fichier'],
                "uid" => $row['uid'],
                "type_document" => $typePiece,
                "id" => $row['id'],
                "categorie" => $row['categorie'],
                "classe" => $row['classe'],
                "date_document" => $row['date']
            );
        }

        //Affichage du listing des documents d'instructions, comprenant également
        // les documents de consultation et les documents PEC
        if ($this->f->isAccredited('document_instruction')) {


            $tous_les_tableaux["document_instruction"] = array();
            foreach($qres_union_instruction['result'] as $row) {
                // Dans le cas des documents numérisés récupération du libellé
                $typePiece = $row['type_document'];
                if ($row['classe'] === 'document_numerise') {
                    // Récupération du type de document et du dossier pour connaître
                    // le type de document et son libellé ainsi que le type de dossier d'instruction.
                    // A partir de ces informations le libellé du type est formé.
                    $documentNum = $this->f->get_inst__om_dbform(array(
                        'obj' => 'document_numerise',
                        'idx' => $row['id']
                    ));
                    $dossier = $this->f->get_inst__om_dbform(array(
                        'obj' => 'dossier',
                        'idx' => $idxformulaire
                    ));
                    $typePiece = $this->get_libelle_piece_avec_nomenclature(
                        $row['type_document'],
                        $documentNum->getVal('document_numerise_type'),
                        $dossier->getVal('dossier_instruction_type')
                    );

                    // Affiche le code de la pièce (s'il existe) et le type de document
                    // Dans le cas, ou une description du type a été ajouté affiche la
                    // description du type à la place du libellé
                    if (! empty($documentNum->getVal('description_type'))) {
                        // Gestion des deux cas : avec code avant le libellé et sans code
                        $positionSeparateur = strpos($typePiece, '|');
                        if ($positionSeparateur !== false) {
                            $typePiece = substr($typePiece, 0, $positionSeparateur + 2).
                                $documentNum->getVal('description_type');
                        } else {
                            $typePiece = $documentNum->getVal('description_type');
                        }
                    }
                }

                $tous_les_tableaux["document_instruction"][] = array(
                    "nom_fichier" => $row['nom_fichier'],
                    "uid" => $row['uid'],
                    "type_document" => $typePiece,
                    "id" => $row['id'],
                    "categorie" => $row['categorie'],
                    "classe" => $row['classe'],
                    "date_document" => $row['date']
                );
            }
        }

        if ($this->f->isAccredited('document_travail')) {
            //Affichage du listing des document de travail
            $tous_les_tableaux["document_travail"] = array();
            foreach($qres_document_travail['result'] as $row) {

                // Dans le cas des documents numérisés récupération du libellé
                $typePiece = $row['type_document'];
                if ($row['classe'] === 'document_numerise') {
                    // Récupération du type de document et du dossier pour connaître
                    // le type de document et son libellé ainsi que le type de dossier d'instruction.
                    // A partir de ces informations le libellé du type est formé.
                    $documentNum = $this->f->get_inst__om_dbform(array(
                        'obj' => 'document_numerise',
                        'idx' => $row['id']
                    ));
                    $dossier = $this->f->get_inst__om_dbform(array(
                        'obj' => 'dossier',
                        'idx' => $idxformulaire
                    ));
                    $typePiece = $this->get_libelle_piece_avec_nomenclature(
                        $row['type_document'],
                        $documentNum->getVal('document_numerise_type'),
                        $dossier->getVal('dossier_instruction_type')
                    );

                    // Affiche le code de la pièce (s'il existe) et le type de document
                    // Dans le cas, ou une description du type a été ajouté affiche la
                    // description du type à la place du libellé
                    if (! empty($documentNum->getVal('description_type'))) {
                        // Gestion des deux cas : avec code avant le libellé et sans code
                        $positionSeparateur = strpos($typePiece, '|');
                        if ($positionSeparateur !== false) {
                            $typePiece = substr($typePiece, 0, $positionSeparateur + 2).
                                $documentNum->getVal('description_type');
                        } else {
                            $typePiece = $documentNum->getVal('description_type');
                        }
                    }
                }

                $tous_les_tableaux["document_travail"][] = array(
                    "nom_fichier" => $row['nom_fichier'],
                    "uid" => $row['uid'],
                    "type_document" => $typePiece,
                    "id" => $row['id'],
                    "categorie" => $row['categorie'],
                    "classe" => $row['classe'],
                    "date_document" => $row['date']
                );
            }
        }

        /*
        * Entrée: tableau $champs_tableau[date_none ou date_exists][arrays des fichiers non triés]
        * Tri des colonnes du tableau 
        */
        foreach ($tous_les_tableaux as &$champ_tableau) {
            // Tri alphabétique par nom de fichier 
            usort($champ_tableau, function($element1, $element2)  {
                return strnatcmp($element1['nom_fichier'], $element2['nom_fichier']);
            });
            // Tri alphabétique par catégorie
            usort($champ_tableau, function($element1, $element2)  {
                return strnatcmp($element1['categorie'], $element2['categorie']);
            });
            // Tri par date_document décroissante
            usort($champ_tableau, function($element1, $element2)  {
                // Petit hack pour mettre les non-date en premier dans la liste
                if ($element1['date_document'] == 'Non applicable') {
                    return -1;
                }
                if ($element2['date_document'] == 'Non applicable') {
                    return 1;
                }
                return (strtotime($element2['date_document']) - strtotime($element1['date_document']));
            });
        }
        /* Sortie: 
        * tableau $champs_tableau[date_none ou date_exists][arrays des fichiers triés 
        * par date_document/catégorie/nom_fichier]
        */


        $form = $this->f->get_inst__om_formulaire();
        /*
        * Affichage du formulaire
        */
        $this->f->layout->display__form_controls_container__begin(array(
            "controls" => "top",
        ));

        // On n'affiche pas les tableaux, si aucun des tableaux ne contient de résultat
        if(!empty($tous_les_tableaux["document_numerise"]) || 
            !empty($tous_les_tableaux["document_instruction"]) || 
            !empty($tous_les_tableaux["document_travail"]) ){
                
            printf($this->template_checkbox, 'checkbox_select_all_none', 'checkbox_select_all_none', 'onclick', 'telechargement_checkbox_select_all_none(this);', 'checkbox_select_all_none', '', __('Tout sélectionner / désélectionner'));

            $this->f->layout->display__form_controls_container__end();

            // /*
            // * Construction du lien de téléchargement
            // */
            $zip_messages = array(
                    "title" => __("Téléchargement des documents sélectionnés"),
                    "confirm_message" => __("Êtes vous sûr(e) de vouloir télécharger l'ensemble des documents sélectionnés ?"),
                    "confirm_button_ok" => __("Oui"),
                    "confirm_button_ko" => __("Non"),
                    "waiting_message" => __("Votre archive est en cours de préparation. Veuillez patienter."),
                    "download_message" => __("Votre archive est prête,"),
                    "download_link_message" => __("Cliquez ici pour la télécharger"),
                    "error_message" => __("L'archive n'a pas pu être créée. Veuillez contacter votre administrateur."),
                );
            $zip_messages_json = json_encode($zip_messages, JSON_HEX_APOS);

            // Début du formulaire
            $form->entete();

            // - Affichage des entêtes de colonne
            $param = array(
                'idcolumntoggle' => "telechargement"
            );
            $array_telechargement = array("selection", "Date depot", "type", "nom", "catégorie");

            // Template affichant les différents tr et th des tableaux, avec leurs titres spécifiques
            $template_table =
            "
                <tr class='ui-tabs-nav ui-accordion ui-state-default tab-title'>
                    <th class='title categorie %s' colspan='5'>
                        <span class='name'>
                            %s
                        </span>
                    </th>
                </tr>";


            // ouverture balise table
            $this->f->layout->display_table_start_class_default($param);

            echo "<thead><tr class=\"ui-tabs-nav ui-accordion ui-state-default tab-title\">\n";
            $param = array(
                        "key" => 0,
                        "info" =>  $array_telechargement
                    );
            $this->f->layout->display_table_cellule_entete_colonnes($param);
            echo "&nbsp;&nbsp;";
            echo "</th>";
            $param = array(
                        "key" => 1,
                        "info" => $array_telechargement
                    );
            $this->f->layout->display_table_cellule_entete_colonnes($param);
            echo __("date");
            echo "</th>";
            $param = array(
                        "key" => 2,
                        "info" => $array_telechargement
                    );
            $this->f->layout->display_table_cellule_entete_colonnes($param);
            echo __("type");
            echo "</th>";
            $param = array(
                        "key" => 3,
                        "info" => $array_telechargement
                    );
            $this->f->layout->display_table_cellule_entete_colonnes($param);
            echo __("nom du fichier");
            echo "</th>";
            $param = array(
                        "key" => 4,
                        "info" => $array_telechargement
                    );
            $this->f->layout->display_table_cellule_entete_colonnes($param);
            echo __("categorie");
            echo "</th>\n";
            echo "</tr>\n";
            echo "</thead>\n";
        
        } else {
            echo __("Aucun document n'est associé à ce dossier.");
            return;
        }

        $j = 0;
        // Affichage de tous les documents téléchargeables
        foreach ($tous_les_tableaux as $table) {
            $i = 0;
            foreach($table as $value){
                //
                switch($value["classe"]) {

                    case "document_travail" : 
                        // Si on c'est la 1ere entête du tableau, alors on appele un class css plutôt qu'une autre pour le bon affichage
                        if($j == 0){
                            // Pour n'afficher qu'une seule fois le titre de la section
                            echo ($i == 0) ? sprintf($template_table, "first-entete-telechargement", "Documents de travail") : "";
                        } else {
                            // Pour n'afficher qu'une seule fois le titre de la section
                            echo ($i == 0) ? sprintf($template_table, "entete-telechargement", "Documents de travail") : "";
                        }
                        ++$j;
                        $champ_uid = "uid";
                        break;
    
                    case "instruction" :
                    case "consultation_fichier" :
                    case "consultation_om_fichier" :
                    case "consultation_pec" :
                    case "rapport_instruction" :
                    case "storage" :
                        // Si on c'est la 1ere entête du tableau, alors on appele un class css plutôt qu'une autre pour le bon affichage
                        if($j == 0){
                            // Pour n'afficher qu'une seule fois le titre de la section
                            echo ($i == 0) ? sprintf($template_table, "first-entete-telechargement", "Documents d'instruction") : "";
                        } else {
                            // Pour n'afficher qu'une seule fois le titre de la section
                            echo ($i == 0) ? sprintf($template_table, "entete-telechargement", "Documents d'instruction") : "";
                        }
                        ++$j;

                        // Gestion des différents cas lorsqu'on est sur des documents d'instruction
                        if ($value['classe'] == 'instruction') {
                            $champ_uid = 'om_fichier_instruction';
                        }

                        if ($value['classe'] == 'rapport_instruction') {
                            $champ_uid = 'om_fichier_rapport_instruction';
                        }

                        if ($value['classe'] == 'storage') {
                            $champ_uid = 'uid';
                        }

                        if ($value['classe'] == 'consultation_pec') {
                            $value['classe'] = 'consultation';
                            $champ_uid = 'fichier_pec';
                        }

                        if ($value['classe'] == 'consultation_fichier') {
                            $value['classe'] = 'consultation';
                            $champ_uid = 'fichier';
                        }

                        if ($value['classe'] == 'consultation_om_fichier') {
                            $value['classe'] = 'consultation';
                            $champ_uid = 'om_fichier_consultation';
                        }
                        break;
    
                    case "document_numerise" :
                    // Si on c'est la 1ere entête du tableau, alors on appele un class css plutôt qu'une autre pour le bon affichage
                        if($j == 0){
                            // Pour n'afficher qu'une seule fois le titre de la section
                            echo ($i == 0) ? sprintf($template_table, "first-entete-telechargement", "Pièces pétitionnaire") : "";
                        } else {
                            // Pour n'afficher qu'une seule fois le titre de la section
                            echo ($i == 0) ? sprintf($template_table, "entete-telechargement", "Pièces pétitionnaire") : "";
                        }
                        ++$j;
                        $champ_uid = "uid";
                        break;
                }

                // On construit la case à cocher
                $checked = '';
                $box = sprintf(
                    $this->template_checkbox,
                    $value["classe"],
                    $value["uid"],
                    'champ_uid',
                    $champ_uid,
                    'checkbox-telechargement',
                    $checked,
                    ''
                );
                // Action de prévisualisation
                $action = $value['classe'] == 'instruction' ? 401 : 400;
                $preview_action = sprintf(
                    '%s&obj=%s&action=%s&idx=%s&champ_uid=%s&retour=tab',
                    OM_ROUTE_FORM,
                    $value['classe'] == 'document_travail' ? 'document_numerise' : $value['classe'],
                    $action,
                    $value['id'],
                    $champ_uid
                );
                $preview_button = sprintf(
                    $this->template_icon_preview_link,
                    $value['classe'] == 'document_travail' ? 'document_numerise' : $value['classe'],
                    $value['id'],
                    $preview_action,
                    __("Prévisualiser"),
                    $value['classe']
                );
                //Détermination des classes de la balise <tr>
                $tr_class = " odd ";
                if ($i % 2 === 1) {
                    $tr_class = " even ";
                }
                
                $date_affichee = $value["date_document"];
                if ($value["date_document"] != 'Non applicable') {
                    $timestamp = strtotime($value["date_document"]);
                    $date_affichee = date("d/m/Y", $timestamp);
                }
                // Composition des cellules
                $colls = sprintf(
                        $this->template_cell,
                        0,
                        "",
                        $box.$preview_button
                    );
                $colls .= 
                    sprintf(
                        $this->template_cell,
                        1,
                        "",
                        sprintf(
                            $template_link_file_telechargement,
                            $value["classe"],
                            $champ_uid,
                            $value["id"],
                            $date_affichee
                        )
                );
                $colls .=
                    sprintf(
                        $this->template_cell,
                        2,
                        "",
                        sprintf(
                            $template_link_file_telechargement,
                            $value["classe"],
                            $champ_uid,
                            $value["id"],
                            ucfirst(strtolower(str_replace('_', ' ', $value["type_document"])))
                        )
                    );
                $colls .=
                    sprintf(
                        $this->template_cell,
                        3,
                        "",
                        sprintf(
                            $template_link_file_telechargement,
                            $value["classe"],
                            $champ_uid,
                            $value["id"],
                            $value["nom_fichier"]
                        )
                    );
                $colls .= 
                    sprintf(
                        $this->template_cell,
                        4,
                        "",
                        sprintf(
                            $template_link_file_telechargement,
                            $value["classe"],
                            $champ_uid,
                            $value["id"],
                            $value["categorie"]
                        )
                    );
                // Affichage de la ligne du tableau
                printf($this->template_row, $tr_class, $colls);
                ++$i;
            }
        }
        printf('</table>');
        // Ferme le formulaire
        $form->enpied();

        //Fin de l'affichage du formulaire de constitution du dossier final 
        $this->f->layout->display__form_controls_container__begin(array(
            "controls" => "bottom",
        ));
        $this->f->layout->display_form_button(array(
            "name" => "archive_telechargement",
            "value" => __("Télécharger les documents sélectionnés"),
            "onclick" => sprintf("archive_telechargement(%s,'%s','%s');", str_replace('"', "'", $zip_messages_json), $idxformulaire, $obj)
        ));

        // Fermeture du conteneur des actions de controles du formulaire
        $this->f->layout->display__form_controls_container__end();
    }


    /**
     * VIEW - view_documents
     *
     * Vue permettant de consulter les documents et ajouter des documents
     * de travail.
     *
     * @return void
     */
    function view_tab_document() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Récupèration des variables nécessaires
        $idxformulaire = $this->getParameter('idxformulaire');
        $retourformulaire = $this->getParameter('retourformulaire');
        $obj = get_class($this);

        // La vue n'est pas affichée si le contexte n'est un dossier d'instruction
        if (in_array($retourformulaire, $this->foreign_keys_extended["dossier"]) !== true) {
            return;
        }
        // Requêtes de récupération des documents de travail


        echo "\n\n";
        echo "\n<!-- ########## START VIEW DOCUMENTS ########## -->\n";
        echo "\n\n";

        // ACTION BASCULER VERS DOCUMENTS
        $this->display_toggl_button($obj, $retourformulaire, $idxformulaire);

        $form = $this->f->get_inst__om_formulaire();
        // Début du formulaire
        $form->entete();

        // Lien vers le téléchargement de tous les documents dans une archive.
        $ct_link_download_zip = "";
        printf(
            '<!-- Actions -->
                %s
            <br>
            <!-- Liste des documents -->',
            $this->get_link_download_zip($idxformulaire, $obj, 'documents', 'Télécharger tous les documents', 101)
        );
        
        // Affichage du tableau des documents d'instructions
        if ($this->f->isAccredited("document_instruction") ||
            $this->f->isAccredited("document_instruction_tab")) {
                $link_tab_instruction = OM_ROUTE_SOUSTAB.'&obj=document_instruction&idxformulaire='.$idxformulaire.'&context='.$obj.'&retour=tab&retourformulaire='.$retourformulaire;
                printf('<div id="tab_document_instruction_href" data-href="%1$s"></div><div id="sousform-document_instruction"></div>
                    <script type="text/javascript" >
                        ajaxIt(\'document_instruction\', \'%1$s\');
                    </script>
                    <br>', $link_tab_instruction);
        }

        // Affichage du tableau des documents de travail
        if ($this->f->isAccredited("document_travail") ||
        $this->f->isAccredited("document_travail_tab")) {
            $link_tab_doc_travail = OM_ROUTE_SOUSTAB.'&obj=document_numerise&idxformulaire='.$idxformulaire.'&context='.$obj.'&retour=tab&retourformulaire='.$retourformulaire;
            printf('<div id="tab_document_travail_href" data-href="%1$s"></div><div id="sousform-document_travail"></div>
                <script type="text/javascript" >
                    ajaxIt(\'document_travail\', \'%1$s\');
                </script>
                ', $link_tab_doc_travail);
        }

        // Ferme le formulaire
        $form->enpied();
    }

    /**
     * VIEW - view_dossier_final
     *
     * Vue permettant de constituer le dossier final.
     *
     * @return void
     */
    function view_dossier_final() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Récupèration des variables nécessaires
        $idxformulaire = $this->getParameter('idxformulaire');
        $retourformulaire = $this->getParameter('retourformulaire');
        $obj = get_class($this);

        // La vue n'est pas affichée si le contexte n'est un dossier d'instruction
        if (in_array($retourformulaire, $this->foreign_keys_extended["dossier"]) !== true) {
            return;
        }

        /**
         *
         */
        echo "\n\n";
        echo "\n<!-- ########## START VIEW DOSSIER FINAL ########## -->\n";
        echo "\n\n";

        // ACTION BASCULER VERS DOSSIER FINAL
        $this->display_toggl_button($obj, $retourformulaire, $idxformulaire);

        // Message affiché à l'utilisateur
        printf('<div id="form-message-dossier-final"></div>');

        //Requête de récupération des dates les plus récente pour chaque type de document
        //dont la recommandation doit se baser dessus.
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    MAX(date_evenement) AS last_date,
                    \'instruction\' AS type_document
                FROM 
                    %1$sinstruction
                WHERE
                    instruction.dossier = \'%2$s\'
                    AND om_fichier_instruction IS NOT NULL
                UNION
                (SELECT
                    MAX(document_numerise.date_creation) AS last_date,
                    document_numerise_type.libelle AS type_document
                FROM 
                    %1$sdocument_numerise 
                    LEFT JOIN %1$sdocument_numerise_type
                        ON document_numerise.document_numerise_type = document_numerise_type.document_numerise_type
                    LEFT JOIN %1$sdocument_numerise_type_categorie
                        ON document_numerise_type.document_numerise_type_categorie = document_numerise_type_categorie.document_numerise_type_categorie 
                    LEFT JOIN %1$sdossier 
                        ON document_numerise.dossier = dossier.dossier 
                    LEFT JOIN %1$sdossier_autorisation
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                WHERE
                    document_numerise.dossier = \'%2$s\'
                GROUP by type_document)',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idxformulaire)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        //Tableau contenant les dates indexées par le type de document
        $last_date = array(); 
        foreach ($qres['result'] as $row) {
            $last_date[$row["type_document"]] = $row["last_date"];
        }
        /*
        *Requêtes de récupération des fichiers 
        */
        //Variation du type du document en cas d'avis tacite défini
        $id_tacite = $this->f->getParameter('id_avis_consultation_tacite');
        $consultation_else_type_document = "CONCAT('consultation_', service.type_consultation)";
        if ($id_tacite !== null && trim($id_tacite) !== '') {
            $consultation_else_type_document = sprintf(
                "CASE WHEN consultation.avis_consultation IS NOT NULL
                    THEN
                        CASE WHEN consultation.avis_consultation = %s
                            THEN CONCAT('consultation_', service.type_consultation, '_tacite')
                            ELSE CONCAT('consultation_', service.type_consultation)
                        END 
                    ELSE CONCAT('consultation_',service.type_consultation)
                END",
                $this->f->db->escapeSimple($id_tacite)
            );
        }

        // Exécution de la requête de récupération des fichiers
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT -- Récupération des documents numérisé (pièces du dossier)
                    document_numerise.document_numerise AS id,
                    document_numerise.date_creation AS date,
                    document_numerise_type_categorie.libelle AS categorie,
                    document_numerise.nom_fichier AS nom_fichier,
                    document_numerise_type.libelle AS type_document,
                    document_numerise.uid AS uid,
                    \'document_numerise\' AS classe,
                    uid_dossier_final AS dossier_final
                FROM 
                    %1$sdocument_numerise 
                    LEFT JOIN %1$sdocument_numerise_type
                        ON document_numerise.document_numerise_type = document_numerise_type.document_numerise_type
                    LEFT JOIN %1$sdocument_numerise_type_categorie
                        ON document_numerise_type.document_numerise_type_categorie = document_numerise_type_categorie.document_numerise_type_categorie 
                    LEFT JOIN %1$sdossier 
                        ON document_numerise.dossier = dossier.dossier 
                    LEFT JOIN %1$sdossier_autorisation
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                WHERE
                    document_numerise.dossier = \'%2$s\'
                    AND document_numerise.document_travail IS FALSE
                UNION
                -- Récupération des documents liés à l instruction
                (SELECT  
                    instruction.instruction AS id,
                    instruction.date_finalisation_courrier AS date,
                    \'%3$s\' AS categorie,
                    CONCAT(\'instruction_\', instruction.instruction) AS nom_fichier,
                    om_lettretype.libelle AS type_document,
                    instruction.om_fichier_instruction AS uid,
                    \'instruction\' AS classe,
                    om_fichier_instruction_dossier_final AS dossier_final
                FROM 
                    %1$sinstruction
                    LEFT JOIN %1$som_lettretype
                        ON om_lettretype.id = instruction.lettretype
                    INNER JOIN %1$som_collectivite
                        ON om_lettretype.om_collectivite = om_collectivite.om_collectivite
                    LEFT JOIN %1$sdossier ON instruction.dossier = dossier.dossier
    
                WHERE
                    instruction.dossier = \'%2$s\'
                    AND instruction.om_fichier_instruction IS NOT NULL
                    AND (om_collectivite.om_collectivite = dossier.om_collectivite
                        OR (om_collectivite.niveau = \'2\'
                            AND NOT EXISTS (
                                SELECT
                                    other_lettretype.om_lettretype
                                FROM
                                    %1$som_lettretype AS other_lettretype
                                    JOIN %1$som_collectivite
                                        ON other_lettretype.om_collectivite = om_collectivite.om_collectivite
                                WHERE
                                    om_lettretype.id = other_lettretype.id
                                    AND om_collectivite.om_collectivite = dossier.om_collectivite))))
                UNION
                -- Récupération des documents liés aux consultations
                (SELECT
                    consultation.consultation AS id,
                    CASE WHEN consultation.date_retour IS NOT NULL 
                        THEN consultation.date_retour
                        ELSE consultation.date_envoi 
                    END AS date,
                    CASE WHEN consultation.fichier IS NOT NULL 
                        THEN \'%4$s\'
                        ELSE \'%3$s\'
                    END AS categorie,
                    CASE WHEN consultation.fichier IS NOT NULL 
                        THEN CONCAT(\'consultation_avis_\', consultation.consultation)
                        ELSE CONCAT(\'consultation_\', consultation.consultation)
                    END AS nom_fichier,
                    CASE WHEN consultation.fichier IS NOT NULL 
                        THEN CONCAT(\'consultation_avis_\', service.type_consultation)
                        ELSE %5$s
                    END AS type_document,
                    CASE WHEN consultation.fichier IS NOT NULL 
                        THEN fichier
                        ELSE om_fichier_consultation
                    END AS uid,
                    \'consultation\' AS classe,
                    CASE WHEN consultation.fichier IS NOT NULL 
                        THEN consultation.fichier_dossier_final
                        ELSE consultation.om_fichier_consultation_dossier_final
                    END AS dossier_final
                FROM
                    %1$sconsultation
                    JOIN %1$sservice 
                        ON consultation.service = service.service
                WHERE
                    consultation.dossier = \'%2$s\'
                    AND (consultation.fichier IS NOT NULL
                        OR consultation.om_fichier_consultation IS NOT NULL))',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idxformulaire),
                __("document généré"),
                __("retour d''avis"),
                $consultation_else_type_document
            ),
            array(
                'origin' => __METHOD__
            )
        );

        //Affichage du formulaire de constitution du dossier final
        $dossier_final_archive = array();
        $champs_tableau = array();
        $champs_tableau["date_none"] = array();
        $champs_tableau["date_exists"] = array();
        foreach ($qres['result'] as $row) {
            // id, date,categorie,nom_fichier,type_document,uid,class,dossier_final_piece_recommandee
            if ($row['dossier_final'] === 't' || $row['dossier_final'] === true ) {
                $dossier_final = 'true';
                $dossier_final_archive[] = $row["uid"];
            } else {
                $dossier_final = 'false';
            }
            $dossier_final_piece_recommandee = 'false';
            //Le fichier généré d'une consultation n'est pas recommandé en général
            //Le fichier joint à un avis à une consultation est recommandé en général
            if ($row["categorie"] === __("document généré")){
                $dossier_final_piece_recommandee = 'false';
            } else if ($row["categorie"] === __("retour d'avis")) {
                $dossier_final_piece_recommandee = 'true';
            }
            //Le fichier généré d'un avis tacite est recommandé
            if (substr($row["type_document"], -6) === 'tacite'){
                $dossier_final_piece_recommandee = 'true';
            }
            //Les fichiers sans date de dépot associée vont dans un tableau à part
            if ($row['date'] === null || trim($row['date']) === "") {
                $key_date = "date_none";
                $dossier_final_piece_recommandee = 'true';
            } else {
                $key_date = "date_exists";
                if ($row["type_document"] === "consultation_pour_information"
                    || $row["type_document"] === "consultation_avis_pour_information"
                    || $row["type_document"] === "consultation_pour_information_tacite") {
                    //
                    $dossier_final_piece_recommandee = 'false';
                } else if (isset($last_date[$row["type_document"]]) === true && $last_date[$row["type_document"]]!== null) {
                    $dossier_final_piece_recommandee = ($row['date'] === $last_date[$row["type_document"]]) ? 'true':'false';
                }
            }

            // Dans le cas des documents numérisés récupération du libellé
            $typePiece = $row['type_document'];
            if ($row['classe'] === 'document_numerise') {
                // Récupération du type de document et du dossier pour connaître
                // le type de document et son libellé ainsi que le type de dossier d'instruction.
                // A partir de ces informations le libellé du type est formé.
                $documentNum = $this->f->get_inst__om_dbform(array(
                    'obj' => 'document_numerise',
                    'idx' => $row['id']
                ));
                $dossier = $this->f->get_inst__om_dbform(array(
                    'obj' => 'dossier',
                    'idx' => $idxformulaire
                ));
                $typePiece = $this->get_libelle_piece_avec_nomenclature(
                    $row['type_document'],
                    $documentNum->getVal('document_numerise_type'),
                    $dossier->getVal('dossier_instruction_type')
                );

                // Affiche le code de la pièce (s'il existe) et le type de document
                // Dans le cas, ou une description du type a été ajouté affiche la
                // description du type à la place du libellé
                if (! empty($documentNum->getVal('description_type'))) {
                    // Gestion des deux cas : avec code avant le libellé et sans code
                    $positionSeparateur = strpos($typePiece, '|');
                    if ($positionSeparateur !== false) {
                        $typePiece = substr($typePiece, 0, $positionSeparateur + 2).
                            $documentNum->getVal('description_type');
                    } else {
                        $typePiece = $documentNum->getVal('description_type');
                    }
                }
            }

            $champs_tableau[$key_date][] = array(
                "nom_fichier" => $row['nom_fichier'],
                "uid" => $row['uid'],
                "type_document" => $typePiece,
                "id" => $row['id'],
                "categorie" => $row['categorie'],
                "classe" => $row['classe'],
                "dossier_final" => $dossier_final,
                "dossier_final_piece_recommandee" => $dossier_final_piece_recommandee,
                "date_document" => $row['date']
            );
        }

        /*
        * Traitement des fichiers sans date ( càd dont la base ne comporte pas de champ de date) - DEBUT
        *
        */
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT  
                    COALESCE(rapport_instruction.rapport_instruction, storage.storage) AS id,
                    \'%2$s\' AS categorie,
                    storage.filename AS nom_fichier,
                    \'rapport_instruction\' AS type_document,
                    storage.uid AS uid,
                    CASE WHEN rapport_instruction.rapport_instruction IS NULL
                        THEN \'storage\'
                        ELSE \'rapport_instruction\'
                    END AS classe,
                    CASE WHEN rapport_instruction.rapport_instruction IS NULL
                        THEN uid_dossier_final
                        ELSE om_fichier_rapport_instruction_dossier_final
                    END AS dossier_final,
                    CASE WHEN rapport_instruction.rapport_instruction IS NULL
                        THEN \'false\'
                        ELSE \'true\'
                    END AS dossier_final_piece_recommandee
                FROM 
                    %1$sstorage
                    LEFT JOIN %1$srapport_instruction
                        ON rapport_instruction.om_fichier_rapport_instruction = storage.uid
                WHERE
                    storage.info::json->>\'dossier\' = \'%3$s\'',
                DB_PREFIXE,
                __("document généré"),
                $this->f->db->escapeSimple($idxformulaire)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        foreach ($qres['result'] as $row) {
            $dossier_final = 'false';
            if ($row['dossier_final'] === 't' || $row['dossier_final'] === true ){
                $dossier_final = 'true';
                $dossier_final_archive[] = $row["uid"];
            }

            $champs_tableau["date_none"][] = array(
                "nom_fichier" => $row['nom_fichier'],
                "uid" => $row['uid'],
                "type_document" => $row['type_document'],
                "id" => $row['id'],
                "categorie" => $row['categorie'],
                "classe" => $row['classe'],
                "dossier_final" => $dossier_final,
                "dossier_final_piece_recommandee" => $row['dossier_final_piece_recommandee'],
                "date_document" => ''
            );
        }

        /*
        * Entrée: tableau $champs_tableau[date_none ou date_exists][arrays des fichiers non triés]
        * Tri des colonnes du tableau 
        */
        foreach ($champs_tableau as &$champ_tableau) {
            // Tri alphabétique par nom de fichier 
            usort($champ_tableau, function($element1, $element2)  {
                return strnatcmp($element1['nom_fichier'], $element2['nom_fichier']);
            });
            // Tri alphabétique par catégorie
            usort($champ_tableau, function($element1, $element2)  {
                return strnatcmp($element1['categorie'], $element2['categorie']);
            });
            // Tri par date_document décroissante
            usort($champ_tableau, function($element1, $element2)  {
                return (strtotime($element2['date_document']) - strtotime($element1['date_document']));
            });
        }
        /* Sortie: 
        * tableau $champs_tableau[date_none ou date_exists][arrays des fichiers triés 
        * par date_document/catégorie/nom_fichier]
        */


        $form = $this->f->get_inst__om_formulaire();

        /*
        * Affichage du formulaire
        */
        $this->f->layout->display__form_controls_container__begin(array(
            "controls" => "top",
        ));

        printf($this->template_checkbox, 'checkbox_select_all_none', 'checkbox_select_all_none', 'onclick', 'dossier_final_checkbox_select_all_none(this);', 'checkbox_select_all_none', '', __('Tout sélectionner / désélectionner'));
        $this->f->layout->display__form_input_submit(array(
            "value" => _("Sélectionner les pièces et documents recommandés"),
            "onclick" => "dossier_final_select_recommandees();",
            "class" => 'dossier_final_select_recommandees',
        ));

        /*
        * Construction du lien de téléchargement du dossier final
        */
        $link_telecharger_dossier_final = "";
        if($dossier_final_archive !== array()){
            $zip_messages = array(
                    "title" => _("Téléchargement du dossier final"),
                    "confirm_message" => _("Êtes vous sûr(e) de vouloir télécharger l'ensemble des pièces du dossier final ?"),
                    "confirm_button_ok" => _("Oui"),
                    "confirm_button_ko" => _("Non"),
                    "waiting_message" => _("Votre archive est en cours de préparation. Veuillez patienter."),
                    "download_message" => _("Votre archive est prête,"),
                    "download_link_message" => _("Cliquez ici pour la télécharger"),
                    "error_message" => _("L'archive n'a pas pu être créée. Veuillez contacter votre administrateur."),
                );
            $zip_messages_json = json_encode($zip_messages, JSON_HEX_APOS);
            $dossier_final_archive_json = json_encode($dossier_final_archive, JSON_HEX_APOS);
            $link_telecharger_dossier_final = sprintf("
                <a id='telecharger_dossier_final' onclick='generate_archive_dossier_final(%s,%s,\"%s\", \"%s\");' href='#'>
                    <span class='om-icon om-icon-16 om-icon-fix archive-16'
                    title='"._("Télécharger le dossier final")."'>"._("Télécharger le dossier final")."</span>
                    "._("Télécharger le dossier final")."
                </a>
                ",
                $zip_messages_json,
                $dossier_final_archive_json,
                $idxformulaire,
                $obj
            );
        }
        printf("
            <div id='telecharger-dossier-final'>%s</div>",
            $link_telecharger_dossier_final
        );

        $this->f->layout->display__form_controls_container__end();

        // Début du formulaire
        $form->entete();

        // Ouverture de la balise table
        // - Affichage des entêtes de colonne
        $param = array(
            'idcolumntoggle' => "dossier_final"
        );
        $this->f->layout->display_table_start_class_default($param);
        $array_dossier_final = array("selection", "Date depot", "type", "nom", "catégorie");
        echo "<thead>\n";
        echo "<tr class=\"ui-tabs-nav ui-accordion ui-state-default tab-title\">\n";
        $param = array(
                    "key" => 0,
                    "info" =>  $array_dossier_final
             );
        $this->f->layout->display_table_cellule_entete_colonnes($param);
        echo "&nbsp;&nbsp;";
        echo "</th>";
        $param = array(
                    "key" => 1,
                    "info" => $array_dossier_final
             );
        $this->f->layout->display_table_cellule_entete_colonnes($param);
        echo __("date");
        echo "</th>";
        $param = array(
                    "key" => 2,
                    "info" => $array_dossier_final
             );
        $this->f->layout->display_table_cellule_entete_colonnes($param);
        echo __("type");
        $param = array(
                    "key" => 3,
                    "info" => $array_dossier_final
             );
        $this->f->layout->display_table_cellule_entete_colonnes($param);
        echo __("nom du fichier");
        echo "</th>";
        $param = array(
                    "key" => 4,
                    "info" => $array_dossier_final
             );
        $this->f->layout->display_table_cellule_entete_colonnes($param);
        echo __("categorie");
        echo "</th>\n";
        echo "</tr>\n";
        echo "</thead>\n";

        // Affichage des documents non daté, en tête de tableau
        $i = 0;
        foreach($champs_tableau["date_none"] as $value){
            //
            switch($value["classe"]) {
                case "rapport_instruction" : 
                    $champ_uid = "om_fichier_rapport_instruction"; 
                    break;
                case "storage" : 
                    $champ_uid = "uid"; 
                    break;
                case "instruction" :
                    $champ_uid = "om_fichier_instruction";
                    break;
            }
            $nom_fichier = sprintf($this->template_link_file, $value["classe"], $champ_uid, $value["id"], __('Ouvrir le fichier'), $value["nom_fichier"]);
            // On construit la case à cocher
            $checked = '';
            if ($value["dossier_final"] === 'true') {
                $checked = 'checked="checked"';
            }
            // Action de prévisualisation
            $action = $value['classe'] == 'instruction' ? 401 : 400;
            $preview_action = sprintf(
                '%s&obj=%s&action=%s&idx=%s&champ_uid=%s&retour=tab',
                OM_ROUTE_FORM,
                $value['classe'],
                $action,
                $value['id'],
                $champ_uid
            );
            $preview_button = sprintf(
                $this->template_icon_preview_link,
                $value['classe'],
                $value['id'],
                $preview_action,
                __("Prévisualiser"),
                $value['classe']
            );
            $box = sprintf($this->template_checkbox, $value["classe"], $value["uid"], 'champ_uid', $champ_uid, 'checkbox-dossier_final', $checked, '');
            //Détermination des classes de la balise <tr>
            $tr_class = " odd ";
            if ($i % 2 === 1) {
                $tr_class = " even ";
            }
            if ($value["dossier_final_piece_recommandee"] === 'true') {
                $tr_class .= " dossier_final_piece_recommandee";
            }
            $date = __("Non applicable");
            // Composition des cellules
            $colls = sprintf($this->template_cell, 0, "", $box.$preview_button);
            $colls .= sprintf($this->template_cell, 1, "", $date);
            $colls .= sprintf($this->template_cell, 2, "", $value["type_document"]);
            $colls .= sprintf($this->template_cell, 3, "", $nom_fichier);
            $colls .= sprintf($this->template_cell, 4, "", $value["categorie"]);
            // Affichage de la ligne du tableau
            printf($this->template_row, $tr_class, $colls);
            $i++;
        }
        // Affichage des documents ayant une date
        foreach ($champs_tableau["date_exists"] as $value) {
            //
            switch($value["classe"]) {
                case "consultation" :
                    if ($value["categorie"] === __("retour d'avis")) {
                        $champ_uid = "fichier";
                    } else {
                        $champ_uid = "om_fichier_consultation";
                    }
                    break;
                case "instruction" : 
                    $champ_uid = "om_fichier_instruction";
                    break;
                case "document_numerise" : 
                    $champ_uid = "uid";
                    break;
            }
            $nom_fichier = sprintf($this->template_link_file, $value["classe"], $champ_uid, $value["id"], __('Ouvrir le fichier'), $value["nom_fichier"]);
            // On construit la case à cocher
            $checked = '';
            if ($value["dossier_final"] === 'true') {
                $checked = 'checked="checked"';
            }
            $box = sprintf($this->template_checkbox, $value["classe"], $value["uid"], 'champ_uid', $champ_uid, 'checkbox-dossier_final', $checked, '');
            // Action de prévisualisation
            $action = $value['classe'] == 'instruction' ? 401 : 400;
            $preview_action = sprintf(
                '%s&obj=%s&action=%s&idx=%s&champ_uid=%s&retour=tab',
                OM_ROUTE_FORM,
                $value['classe'],
                $action,
                $value['id'],
                $champ_uid
            );
            $preview_button = sprintf(
                $this->template_icon_preview_link,
                $value['classe'],
                $value['id'],
                $preview_action,
                __("Prévisualiser"),
                $value['classe']
            );
            //Détermination des classes de la balise <tr>
            $tr_class = " odd ";
            if ($i % 2 === 1) {
                $tr_class = " even ";
            }
            if ($value["dossier_final_piece_recommandee"] === 'true'){
                $tr_class .= " dossier_final_piece_recommandee";
            }
            $timestamp = strtotime($value["date_document"]);
            $date_affichee = date("d/m/Y", $timestamp);
            // Composition des cellules
            $colls = sprintf($this->template_cell, 0, "", $box.$preview_button);
            $colls .= sprintf($this->template_cell, 1, "", $date_affichee);
            $colls .= sprintf($this->template_cell, 2, "", $value["type_document"]);
            $colls .= sprintf($this->template_cell, 3, "", $nom_fichier);
            $colls .= sprintf($this->template_cell, 4, "", $value["categorie"]);
            // Affichage de la ligne du tableau
            printf($this->template_row, $tr_class, $colls);
            $i++;
        }
        printf('</table>');
        // Ferme le formulaire
        $form->enpied();

        //Fin de l'affichage du formulaire de constitution du dossier final 
        $this->f->layout->display__form_controls_container__begin(array(
            "controls" => "bottom",
        ));
        $this->f->layout->display_form_button(array(
            "name" => "constituer_dossier_final",
            "value" => __("Constituer le dossier final"),
            "onclick" => sprintf("constituer_dossier_final('%s','%s');", $idxformulaire, $obj)
        ));

        // Fermeture du conteneur des actions de controles du formulaire
        $this->f->layout->display__form_controls_container__end();
    }
    /**
     * VIEW - constituer_dossier_final.
     *
     * Permet de constituer le dossier final et de (re)-créer le bouton de
     * téléchargement de l'archive du dossier final
     *
     * @return void
     */
    function constituer_dossier_final(){
        $response = array();
        $response["msg_error"] = "";
        $dossier_final_archive = array();
        $obj = get_class($this);
        $dossier_instruction = $this->f->get_submitted_get_value("dossier");
        //Préparation du bouton (argument var_text dans le onclick)
        $zip_messages = array(
                    "title" => _("Téléchargement du dossier final"),
                    "confirm_message" => _("Êtes vous sûr(e) de vouloir télécharger l'ensemble des pièces du dossier final ?"),
                    "confirm_button_ok" => _("Oui"),
                    "confirm_button_ko" => _("Non"),
                    "waiting_message" => _("Votre archive est en cours de préparation. Veuillez patienter."),
                    "download_message" => _("Votre archive est prête,"),
                    "download_link_message" => _("Cliquez ici pour la télécharger"),
                    "error_message" => _("L'archive n'a pas pu être créée. Veuillez contacter votre administrateur."),
                );
        $zip_messages_json = json_encode($zip_messages, JSON_HEX_APOS);
        //
        $dossier_final = "";
        // Récupération des références cadastrales passées en paramètre
        if ($this->f->get_submitted_post_value("dossier_final") != null) {
            $dossier_final = $this->f->get_submitted_post_value("dossier_final");
        }
        // Si ce n'est pas un tableau de références
        if (is_array($dossier_final) === false || $dossier_final === array()) {
            $msg_error = __("Aucun fichier trouvé pour le dossier final.");
            $this->f->addToLog(__METHOD__."(): ".$msg_error, VERBOSE_MODE);
            printf(json_encode(["msg_error" => $msg_error]));
            return;
        }
        //
        foreach ($dossier_final as $key => $fichier) {

            // Met à jour le TODO
            // Il n'y a pas de champ dossier_final dans la table storage il ne faut donc pas
            // faire de update pour cette table
            $res = $this->f->db->autoExecute(
                DB_PREFIXE.$fichier["table"],
                [$fichier["champ_uid"]."_dossier_final" => $fichier["val"]],
                DB_AUTOQUERY_UPDATE,
                $fichier["champ_uid"]."='".$fichier["uid"]."'"
            );
            //
            if ($this->f->isDatabaseError($res, true) === true) {
                $msg_error = sprintf(__("Erreur lors de l'ajout d'un fichier au dossier final (uid: %s)"), $fichier["uid"]);
                $this->f->addToLog(__METHOD__."(): ".$msg_error, DEBUG_MODE);
                printf(json_encode(["msg_error" => $msg_error]));
                return;
            }
            if ($fichier["val"] === "true" || $fichier["val"] === true) {
                $dossier_final_archive[] = $fichier["uid"];
            }
        }

        // Si aucun fichier n'est sélectionné, le bouton permettant de
        // télécharger l'intégralité des documents dans une archive, est caché
        $link_telecharger_dossier_final = "";
        if (count($dossier_final_archive) !== 0) {
            $dossier_final_archive_json = json_encode($dossier_final_archive, JSON_HEX_APOS);
            $link_telecharger_dossier_final = sprintf("
                <a id='telecharger_dossier_final' onclick='generate_archive_dossier_final(%s,%s,\"%s\", \"%s\");' href='#'>
                    <span class='om-icon om-icon-16 om-icon-fix archive-16'
                    title='"._("Télécharger le dossier final")."'>"._("Télécharger le dossier final")."</span>
                    "._("Télécharger le dossier final")."
                </a>
                ",
                $zip_messages_json,
                $dossier_final_archive_json,
                $dossier_instruction,
                $obj
            );
        }

        $response["button_content"] = $link_telecharger_dossier_final;
        printf(json_encode($response), JSON_HEX_APOS);
    }

    /**
     * VIEW - generate_archive_dossier_final
     *
     * Permet de générer une archive zip contenant les documents constitutifs du
     * dossier final
     *
     * @return void
     */
    function generate_archive_dossier_final() {
        $this->generate_archive('_dossier_final_');
    }

    /**
     * TREATMENT - generate_archive
     * 
     * Fonction générique permettant de composer
     * une archive zip en fonction d'une liste d'uid
     * récupéré dans le $GET
     * 
     * @param string $filename Permet de choisir une partie du nom du fichier (dossier_final ou telechargement)
     * 
     * @return void
     */
    function generate_archive($filename) {
        $this->f->disableLog();

        $return = array();

        // Liste des documents à télécharger séparés par une virgule ","
        if ($this->f->get_submitted_get_value('ids') === null) {
            printf(json_encode(_("Aucun document fourni")));
            return;
        }
        $uids = $this->f->get_submitted_get_value('ids');
        $uids = explode(",", $uids);

        if ($this->f->get_submitted_get_value('dossier') === null) {
            printf(json_encode(_("Aucun dossier fourni")));
            return;
        }
        $dossier = $this->f->get_submitted_get_value('dossier');

        // Création du storage temporaire
        $temp = "0";
        $metadata = array(
            "filename" => time().".zip",
            "size" => 1,
            "mimetype" => "application/zip",
        );
        // Création du fichier zip en filestorage temporary
        if ($this->f->storage === null) {
            printf(json_encode(_("Erreur lors de la création de l'archive")));
            return;
        }
        $temp_uid = $this->f->storage->create_temporary($temp, $metadata);
        if ($temp_uid === OP_FAILURE) {
            printf(json_encode(_("Erreur lors de la création de l'archive")));
            return;
        }
        // Récupération de son path pour ziparchive
        $temp_path = $this->f->storage->getPath_temporary($temp_uid);
        // Instanciation de l'archive
        $zip = new ZipArchive;
        $zip->open($temp_path, ZipArchive::OVERWRITE);
        // On rempli l'archive avec les documents récupérés sur le storage
        foreach ($uids as $uid) {
            $file = $this->f->storage->get($uid);
            if ($file === OP_FAILURE) {
                $return['status'] = false;
            } else {
               $zip->addFromString($file['metadata']['filename'], $file['file_content']); 
            }
        }
        $zip->close();

        // Création d'un second temporary pour mettre à jour les métadonnées
        $size = filesize($temp_path);
        $file_name = $dossier.$filename.date("Ymd");
        $metadata = array(
            "filename" => $file_name.".zip",
            "size" => $size,
            "mimetype" => "application/zip",
        );
        $uid_archive = $this->f->storage->create_temporary($temp_path, $metadata, "from_path");
        $return['status'] = true;

        if ($uid_archive === OP_FAILURE) {
            $return['status'] = false;
        }
        $return['file'] = $uid_archive;
        printf(json_encode($return));
    }

    /**
     * VIEW - generate_archive_telechargement
     *
     * Permet de générer une archive zip contenant les documents sélectionnés
     * dans le sous-onglet téléchargement
     *
     * @return void
     */
    function generate_archive_telechargement() {
        $this->generate_archive('_telechargement_');
    }

    function setType(&$form,$maj) {
        parent::setType($form,$maj);

        //type
        $form->setType('document_numerise','hidden');
        $form->setType('description_type','hidden');
        $form->setType('dossier','hidden');
        $form->setType('nom_fichier','hidden');
        $form->setType('uid_dossier_final','hidden');
        $form->setType('live_preview', 'hidden');
        $form->setType('document_travail', 'hidden');
        $form->setType('uid_thumbnail', 'hidden');

        if ($maj==0){ //ajout
            $form->setType('nom_fichier','hidden');
            if ($this->getParameter("retourformulaire") == "") {
                $form->setType('uid','upload');
            } else {
                $form->setType('uid','upload2');
            }
        }// fin ajout
        //ajout et modif spécifique au document de travail
        if ($maj==5 || ($maj == 1 && $this->getVal('document_travail') == 't')) {
            if ($this->getParameter("retourformulaire") == "") {
                $form->setType('uid','upload');
            } else {
                $form->setType('uid','upload2');
            }
            $form->setType('document_numerise_type','hidden');
            $form->setType('document_numerise_nature','hidden');
            $form->setType('description_type','text');
        }// fin ajout

        if ($maj==1){ //modifier
            $form->setType('nom_fichier','hiddenstatic');
            $form->setType('document_numerise_type','selecthiddenstatic');
            if ($this->getParameter("retourformulaire") == "") {
                $form->setType('uid','upload');
            } else {
                $form->setType('uid','upload2');
            }
            if (! $this->f->isAccredited($this->get_absolute_class_name()."_modifier_fichier")) {
                $form->setType('uid', 'hiddenstatic');
            }

            // Différenciation du form des document_numerisé de celui des documents de travail
            if ($this->getVal('document_travail') != 't') {
                // Si il s'agit du type 'Autre type de pièce' ou qu'une description du type existe
                // alors le champs description_type doit être saisissable
                $idAutreTypePiece = $this->get_document_numerise_type_id_by_code(CODE_AUTRE_TYPE_PIECE);
                if (! empty($this->getVal('description_type')) ||
                    $this->getVal('document_numerise_type') == $idAutreTypePiece
                ) {
                    $form->setType('description_type', 'text');
                }
            } else {
                $form->setType('description_type', 'text');
                $form->setType('document_numerise_type','hidden');
                $form->setType('document_numerise_nature','hidden');
            }
        }// fin modifier

        if ($maj==2){ //supprimer
            $form->setType('uid','filestatic');
            $form->setType('date_creation','datestatic');
        }// fin supprimer

        if ($maj==3){ //consulter
            $form->setType('uid','file');
        }// fin consulter

        if ($maj == 400) {
            foreach ($this->champs as $champ) {
                $form->setType($champ, 'hidden');
            }
            // Détermine si c'est une image ou un pdf qui doit être affiché
            $form->setType('live_preview', 'previsualiser');
        }
    }

    function setLayout(&$form, $maj){
        if ($maj == 0 || $maj == 1) {
            $form->setFieldset('document_numerise', 'D', _('Pièce'));
            $form->setBloc('document_numerise', 'D', "", "sousform-document_numerise-action-".$maj);
            $form->setBloc('uid_dossier_final', 'F');
            $form->setFieldset('uid_dossier_final', 'F', '');
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
        $this->retourformulaire = $retourformulaire;
        //
        if ($maj == 0
            && $this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
            //
            $form->setVal("dossier", $idxformulaire);
            // Récupération de la date de dernier depot
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $idxformulaire
            ));
            $date = ! empty($dossier->getVal('date_dernier_depot')) ?
                $dossier->getVal('date_dernier_depot') :
                date("d/m/Y");
            $form->setVal("date_creation", $date);
            //
            $inst_dcn = $this->f->get_inst__om_dbform(array(
                "obj" => "document_numerise_nature",
                "idx" => 0,
            ));
            $form->setVal("document_numerise_nature", $inst_dcn->get_default_select_value($idxformulaire));
        }

        if ($maj == 5) {
            $idTypeDocTravail = $this->get_document_numerise_type_id_by_code(CODE_TYPE_DOC_TRAVAIL);
            $form->setVal("dossier", $idxformulaire);
            $form->setVal("date_creation", date("d/m/Y"));
            $form->setVal("document_numerise_type", $idTypeDocTravail);
            $form->setVal("document_travail", true);
        }
    }

    /**
     * [setLib description]
     * @param [type] $form [description]
     * @param [type] $maj  [description]
     */
    function setLib(&$form, $maj) {
        parent::setLib($form, $maj);

        //
        $form->setLib("uid", _("fichier"));
        $form->setLib("date_creation", _("Date"));
        $form->setLib("live_preview", "");
        $form->setLib("description_type", _("description"));
        $form->setLib("document_numerise_nature", _("Nature de pièce"));
    }


    /**
     * Méthode de traitement des données retournées par le formulaire
     */
    function setvalF($val = array()) {
        parent::setvalF($val);

        if ($val["date_creation"] == "") {
            $this->valF["date_creation"] = "";
        }

        // Génération automatique du nom du fichier
        if ($val["nom_fichier"] == "" || $this->getParameter("maj") != 0) {
            // Si le fichier n'a pas été modifié récupère l'extension sur le nom du fichier
            $extension = '';
            if ($this->getVal('uid') == $val['uid']) {
                $posExtension = strpos($val["nom_fichier"], ".");
                if ($posExtension !== false) {
                    $extension = substr($val["nom_fichier"], $posExtension);
                }
            } else {
                // Récupère l'extension sur le fichier temporaire
                $temporary_test = explode("|", $this->valF['uid']);
                if (isset($temporary_test[0]) === true && $temporary_test[0] == "tmp") {
                    if (isset($temporary_test[1]) === true) {
                        $tmp_filename = $this->f->storage->getFilename_temporary($temporary_test[1]);
                        $extension = strtolower(substr($tmp_filename, strrpos($tmp_filename, '.')));
                    }
                }
            }
            $this->valF['nom_fichier'] = $this->generate_filename($this->valF["date_creation"], $val['document_numerise_type'], $extension);
        }
    }

    /**
     * Génère le nom du fichier.
     *
     * @param  string  $p_date                   Date
     * @param  integer $p_document_numerise_type Identifiant du type du document
     * @param  string  $p_extension              Extension
     * @param  string  $p_dossier                Numéro du dossier
     * @return string                            Nom du fichier
     */
    public function generate_filename($p_date, $p_document_numerise_type, $p_extension = null, $p_dossier = null) {
        // Change le format de la date
        $date = date("Ymd");
        if ($p_date !== null
            && $p_date !== '') {
            //
            $date = date("Ymd", strtotime($p_date));
        }

        // Récupération du code du type
        $code_dnt = '';
        if ($p_document_numerise_type !== null
            && $p_document_numerise_type !== '') {
            //
            $code_dnt = $this->get_document_numerise_type_code_by_id($p_document_numerise_type);
            // Remplissage du tableau des nomenclatures si il n'a pas déjà été rempli
            if (isset($this->nomenclaturePieces) !== true
                || $this->nomenclaturePieces === null) {
                //
                $this->set_nomenclature_piece();
            }
            // Récupération du code Plat'AU de la pièce.
            // Cette récupération n'est possible que si le type du dossier d'instruction
            // est identifié.
            $idx_dossier = $p_dossier;
            if ($this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
                $idx_dossier = $this->f->get_submitted_get_value('idxformulaire');
            }
            if ($idx_dossier !== null
                && $idx_dossier !== '') {
                //
                $inst_dossier = $this->f->get_inst__om_dbform(array(
                    'obj' => 'dossier',
                    'idx' => $idx_dossier
                ));
                $type_dossier = $inst_dossier->getVal('dossier_instruction_type');
                // Récupèration du code Plat'AU de la pièce s'il existe
                if (empty($idx_dossier) === false
                    && array_key_exists($p_document_numerise_type, $this->nomenclaturePieces)
                    && array_key_exists($type_dossier, $this->nomenclaturePieces[$p_document_numerise_type])
                    && empty($this->nomenclaturePieces[$p_document_numerise_type][$type_dossier]) === false) {
                    // Un seul code est utilisé pour composer le nom du fichier même si plusieurs
                    // correspondent. Dans ce code les "-" sont remplacé par des "_"
                    // pour éviter la confusion avec le numéro du fichier
                    $code_dnt = str_replace(
                        '-',
                        '_',
                        $this->nomenclaturePieces[$p_document_numerise_type][$type_dossier][0]
                    );
                }
            }
        }

        // Récupération de l'extension
        $extension = $p_extension;

        // Compose le nom du fichier date + code type document numérisé + extension
        $filename = $date.$code_dnt.$extension;
        $counter = 1;
        while ($this->filename_exists_for_dossier_instruction($filename, $p_dossier) === true) {
            $filename = $date.$code_dnt.'-'.$counter.$extension;
            $counter++;
        }
        // Retourne le nom du fichier
        return $filename;
    }

    function setOnchange(&$form, $maj) {
        parent::setOnchange($form, $maj);
        $idAutreTypePiece = $this->get_document_numerise_type_id_by_code(CODE_AUTRE_TYPE_PIECE);
        $form->setOnchange('document_numerise_type', 'afficheChampDescription(this.value,'.$idAutreTypePiece.')');
    }

    /**
     * Permet de mettre à jour un champs dans la table instruction sans passer par ses triggers
     * @param   string $document_numerise Identifiant du fichier
     * @param   integer $instruction L'identifiant de l'instruction à mettre à jour
     */
    private function updateInstructionAutoExecute($document_numerise, $instruction) {

      // valeurs à mettre à jour
      $val = array("document_numerise"=>$document_numerise);
      // met à jour la table instruction sans passer par ses triggers
      $res = $this->f->db->autoExecute(DB_PREFIXE."instruction", $val, DB_AUTOQUERY_UPDATE,"instruction=".$instruction);
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."instruction\", ".print_r($val, true).", DB_AUTOQUERY_UPDATE, \"instruction=".$instruction."\")",
            VERBOSE_MODE
        );
        $this->f->isDatabaseError($res);
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * - Interface avec le référentiel ERP [113]
     * - Notification de l'instructeur par message
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {

        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // On a besoin de l'instance du dossier lié au document numérisé
        $inst_di = $this->get_inst_dossier($this->valF['dossier']);

        // Dans le contexte d'un document de travail
        if ($val['document_travail'] == true) {
            return true;
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[113] Ajout d'une nouvelle pièce
         * Déclencheur :
         *  - L'option ERP est activée
         *  - Le dossier est marqué comme "connecté au référentiel ERP"
         *  - Une nouvelle pièce est ajoutée au dossier
         */
        if ($this->f->is_option_referentiel_erp_enabled($inst_di->getVal('om_collectivite')) === true
            && $inst_di->is_connected_to_referentiel_erp() === true) {
            //
            $inst_document_numerise_type = $this->get_inst_document_numerise_type($this->valF['document_numerise_type']);

            // Vérifie que le type du document peut être partagé avec des
            // services tiers
            if ($inst_document_numerise_type->getVal('aff_service_consulte') === 't') {
                //
                $infos = array(
                    "dossier_instruction" => $inst_di->getVal($inst_di->clePrimaire),
                    "date_creation" => $this->valF["date_creation"],
                    "nom_fichier" => $this->valF["nom_fichier"],
                    "type" => $inst_document_numerise_type->getVal('libelle'),
                    "categorie" => $this->get_document_numerise_type_categorie_libelle($this->valF['document_numerise_type']),
                );
                //
                $ret = $this->f->send_message_to_referentiel_erp(113, $infos);
                if ($ret !== true) {
                    $this->cleanMessage();
                    $this->addToMessage(_("Une erreur s'est produite lors de la notification (113) du référentiel ERP. Contactez votre administrateur."));
                    return false;
                }
                $this->addToMessage(_("Notification (113) du référentiel ERP OK."));
            }
        }

        /**
         * Notification de l'instructeur par message.
         */
        // Si l'option de notification par message est activée
        if ($this->f->getParameter('option_notification_piece_numerisee') === 'true') {
            // Instancie la classe dossier_message
            $dossier_message = $this->get_inst_dossier_message(0);
            // Ajoute le message de notification
            $dossier_message_val = array(
                'dossier' => $val['dossier'],
                'type' => __('Ajout de pièce(s)'),
                'emetteur' => $this->f->get_connected_user_login_name(),
                'login' => $_SESSION['login'],
                'date_emission' => date('Y-m-d H:i:s'),
                'contenu' => __('Une ou plusieurs pièces ont été ajoutées sur le dossier.')
            );
            $add = $dossier_message->add_notification_message($dossier_message_val, false, true);
            // Si une erreur se produit pendant l'ajout
            if ($add !== true) {
                // Message d'erreur affiché à l'utilisateur
                $this->addToMessage(_("Le message de notification n'a pas pu être ajouté."));
                $this->correct = false;
                return false;
            }

            // Récupère l'identifiant du message
            if (isset($dossier_message->valF[$dossier_message->clePrimaire]) === true) {
                $this->set_dossier_message_id($dossier_message->valF[$dossier_message->clePrimaire]);
            }
        }

        /**
         * Vignette / miniature
         */
        // XXX Seulement pour les PDF et les images ? XXX
        if ($this->f->is_option_miniature_fichier_enabled() === true) {
            $infoFichier = $this->f->storage->get($this->valF['uid']);
            if ($this->is_miniturisable($infoFichier)) {
                $im = $this->get_miniature_fichier(
                    $this->f->storage->getPath($this->valF['uid']),
                    128,
                    128,
                    "png"
                );
                // Si la création de la miniature a réussi, elle est enregistré dans la BD
                if (! empty($im)) {
                    $metadata = array(
                        "filename" => $this->valF['nom_fichier'].".min.png",
                        "size" => strlen($im),
                        "mimetype" => "image/png",
                        "date_creation" => date("Y-m-d"),
                    );
                    $uid_thumbnail = $this->f->storage->create($im, $metadata, "from_content", "document_numerise.uid_thumbnail");
                    if ($uid_thumbnail === OP_FAILURE) {
                        $this->addToMessage(__("Erreur lors de la creation de la miniature du fichier."));
                        return false;
                    }
                    $res = $this->f->db->autoExecute(
                        DB_PREFIXE.$this->table,
                        array("uid_thumbnail" => $uid_thumbnail, ),
                        DB_AUTOQUERY_UPDATE,
                        $this->clePrimaire."=".$id
                    );
                    $this->f->addToLog(__METHOD__."() : db->autoExecute(".$res.")", VERBOSE_MODE);
                    //
                    if ($this->f->isDatabaseError($res, true) === true) {
                        $msg_error = sprintf(__("Erreur lors de la sauvegarde de la miniature du fichier"));
                        $this->addToMessage($msg_error);
                        $this->f->addToLog(__METHOD__."(): ".$msg_error, DEBUG_MODE);
                        return false;
                    }
                }
            }
        }

        /**
         * Gestion des tâches pour la dématérialisation
         */
        //
        if ($this->f->is_type_dossier_platau($inst_di->getVal('dossier_autorisation'))
            && $inst_di->getVal('etat_transmission_platau') !== 'jamais_transmissible'
            && ($this->f->is_option_mode_service_consulte_enabled() !== true
                || ($this->f->is_option_mode_service_consulte_enabled() === true
                && ($inst_di->get_source_depot_from_demande() === PLATAU
                    || $inst_di->get_source_depot_from_demande() === PORTAL)))
            && $this->is_document_numerise_categorie_platau($val['document_numerise_type'])) {
            //
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            // On vérifie que la pièce n'est pas liée à une demande issue de create_DI d'une autre catégorie que portal
            $search_values = array(
                sprintf('type = \'%s\'', 'create_DI'),
                sprintf('object_id = \'%s\'', $val['dossier']),
                sprintf('category != \'%s\'', PORTAL),
                sprintf('state != \'%s\'', $inst_task::STATUS_CANCELED),
            );
            $task_exists = $inst_task->task_exists_multi_search($search_values);
            if ($task_exists == false) {
                $task_val = array(
                    'type' => 'ajout_piece',
                    'object_id' => $id,
                    'dossier' => $val['dossier'],
                );
                // Change l'état de la tâche de notification en fonction de l'état de
                // transmission du dossier d'instruction
                if ($this->f->is_option_mode_service_consulte_enabled() === false
                    && ($inst_di->getVal('etat_transmission_platau') == 'non_transmissible' 
                    || $inst_di->getVal('etat_transmission_platau') == 'transmis_mais_non_transmissible')) {
                    //
                    $task_val['state'] = $inst_task::STATUS_DRAFT;
                }
                $add_task = $inst_task->add_task(array('val' => $task_val));
                if ($add_task === false) {
                    $this->addToMessage(sprintf('%s %s',
                        __("Une erreur s'est produite lors de la création tâche."),
                        __("Veuillez contacter votre administrateur.")
                    ));
                    $this->correct = false;
                    return false;
                }
            }
        }
        //
        return true;
    }

    /**
     * Permet de savoir si le document numérisé est de catégorie Plat'AU
     * ou as.
     *
     * @param integer identifiant du type de document numerise sélectionné
     * @return boolean true : Plat'AU, false : pas Plat'AU
     */
    protected function is_document_numerise_categorie_platau($documentNumeriseType){
        // Récupération de la catégorie de document numérisé pour savoir si
        // c'est un document de catégorie PLATAU
        $type = $this->f->get_inst__om_dbform(array(
            'obj' => 'document_numerise_type',
            'idx' => $documentNumeriseType
        ));
        return $type->is_categorie_platau();
    }

    /**
     * Affecte une valeur à l'attribut de l'identifiant du message.
     *
     * @param integer $value Valeur à stocker dans l'attribut.
     *
     * @return void
     */
    private function set_dossier_message_id($value) {
        //
        $this->dossier_message_id = $value;
    }


    /**
     * Retourne l'identifiant du message stocké dans l'attribut.
     *
     * @return integer
     */
    private function get_dossier_message_id() {
        //
        return $this->dossier_message_id;
    }

    /**
     * TRIGGER - triggermodifier.
     *
     * @return boolean
     */
    function triggermodifier($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // si le fichier n'a pas été déjà modifié
        if (stripos($val['uid'], 'tmp') === false) {
            // récupération du fichier et de ses métadonnées
            $file = $this->f->storage->get($val['uid']);
            // créé un fichier temporaire
            $tmp_file = $this->f->storage->create_temporary($file['file_content'], $file['metadata'], "from_content");
            // remplace le fichier par le temporaire pour obliger la modification du fichier
            $this->valF['uid'] = 'tmp|'.$tmp_file;
        }
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // si le fichier a été modifié
        if ($val['uid'] !== $this->getVal('uid')) {
            // Initialise l'uid du thumbnail pour le cas ou il n'y a pas de miniature
            // pour le fichier
            $uid_thumbnail = null;
            // Vérifie que le fichier est miniaturisable
            $infoFichier = $this->f->storage->get($this->getVal('uid'));
            if ($this->f->is_option_miniature_fichier_enabled() &&
                $this->is_miniturisable($infoFichier)
            ) {
                // Mise à jour de la miniature
                $im = $this->get_miniature_fichier(
                    $this->f->storage->getPath($this->getVal('uid')),
                    128,
                    128,
                    "png"
                );
                // Si la création de la miniature a réussi, elle est enregistré dans la BD
                $metadata = array(
                    "filename" => $this->valF['nom_fichier'].".min.png",
                    "size" => strlen($im),
                    "mimetype" => "image/png",
                    "date_creation" => date("Y-m-d"),
                );
                // Si il existe déjà un uid pour la miniature on la met à jour
                // Si il n'y a aucun uid associé à la miniature on en créé un
                if (! empty($this->getVal("uid_thumbnail"))) {
                    $uid_thumbnail = $this->f->storage->update(
                        $this->getVal("uid_thumbnail"),
                        $im,
                        $metadata,
                        "from_content"
                    );
                } else {
                    $uid_thumbnail = $this->f->storage->create($im, $metadata, "from_content", "document_numerise.uid_thumbnail");
                }
                if ($uid_thumbnail === OP_FAILURE) {
                    $this->addToMessage(__("Erreur lors de la mise à jour de la miniature du fichier."));
                    return false;
                }
            } elseif (! empty($this->getVal('uid_thumbnail'))) {
                // Si on a un uid pour la miniature et qu'on supprime la miniature
                // alors on la supprime également dans le filestorage
                $res_delete = $this->f->storage->delete($this->getVal('uid_thumbnail'));
                // Gestion erreur verrou
                if ($res_delete === false) {
                    //
                    $msg = __("Le fichier sur le champ")." ".$this->table." uid_thumbnail ".
                    __("est verouille. ");
                    $this->addToLog(__METHOD__."(): ".$msg.__("id")." = ".$this->getVal($this->clePrimaire)." - ".__("uid fichier")." = ".$this->getVal('uid_thumbnail'), DEBUG_MODE);
                    return $msg.__("Veuillez revalider le formulaire");
                }
                // Gestion erreur filestorage
                if ($res_delete == OP_FAILURE) {
                    //
                    $msg = __("Erreur lors de la suppression du fichier sur le champ").
                    " \"".$this->table." uid \" ";
                    $this->addToLog(__METHOD__."(): ".$msg.__("id")." = ".$this->getVal($this->clePrimaire)." - ".__("uid fichier")." = ".$this->getVal('uid_thumbnail'), DEBUG_MODE);
                    return $msg.__("Veuillez contacter votre administrateur.");
                }
            }
            $res = $this->f->db->autoExecute(
                DB_PREFIXE.$this->table,
                array("uid_thumbnail" => $uid_thumbnail),
                DB_AUTOQUERY_UPDATE,
                $this->clePrimaire."=".$id
            );
            $this->f->addToLog(__METHOD__."() : db->autoExecute(".$res.")", VERBOSE_MODE);
            //
            if ($this->f->isDatabaseError($res, true) === true) {
                $msg_error = sprintf(__("Erreur lors de la sauvegarde de la miniature du fichier"));
                $this->addToMessage($msg_error);
                $this->f->addToLog(__METHOD__."(): ".$msg_error, DEBUG_MODE);
                return false;
            }
        }
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Si il existe une miniature stockée dans le filestorage on la supprime
        if (! empty($this->getVal('uid_thumbnail'))) {
            // Si on a un uid pour la miniature et qu'on supprime la miniature
            // alors on la supprime également dans le filestorage
            $res_delete = $this->f->storage->delete($this->getVal('uid_thumbnail'));
            // Gestion erreur verrou
            if ($res_delete === false) {
                //
                $msg = __("Le fichier sur le champ")." ".$this->table." uid_thumbnail ".
                __("est verouille. ");
                $this->addToLog(__METHOD__."(): ".$msg.__("id")." = ".$this->getVal($this->clePrimaire)." - ".__("uid fichier")." = ".$this->getVal('uid_thumbnail'), DEBUG_MODE);
                return $msg.__("Veuillez revalider le formulaire");
            }
            // Gestion erreur filestorage
            if ($res_delete == OP_FAILURE) {
                //
                $msg = __("Erreur lors de la suppression du fichier sur le champ").
                " \"".$this->table." uid \" ";
                $this->addToLog(__METHOD__."(): ".$msg.__("id")." = ".$this->getVal($this->clePrimaire)." - ".__("uid fichier")." = ".$this->getVal('uid_thumbnail'), DEBUG_MODE);
                return $msg.__("Veuillez contacter votre administrateur.");
            }
        }
    }

    /**
     * TRIGGER - triggersupprimerapres.
     *
     * @return boolean
     */
    function triggersupprimerapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        parent::triggersupprimerapres($id, $dnu1, $val, $dnu2);

        /**
         * Gestion des tâches pour la dématérialisation
         */
        $inst_task_empty = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));
        $task_exists = $inst_task_empty->task_exists('ajout_piece', $id);
        if ($task_exists !== false) {
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => $task_exists,
            ));
            if ($inst_task->getVal('state') === $inst_task::STATUS_NEW || $inst_task->getVal('state') === $inst_task::STATUS_DRAFT) {
                $task_val = array(
                    'state' => $inst_task::STATUS_CANCELED,
                );
                $update_task = $inst_task->update_task(array('val' => $task_val));
                if ($update_task === false) {
                    $this->addToMessage(sprintf('%s %s',
                        sprintf(__("Une erreur s'est produite lors de la modification de la tâche %."), $inst_task->getVal($inst_task->clePrimaire)),
                        __("Veuillez contacter votre administrateur.")
                    ));
                    $this->correct = false;
                    return false;
                }
            }
        }

        //
        return true;
    }

    /**
     * Surcharge du bouton retour des sous-formulaire
     */
    function retoursousformulaire($idxformulaire = NULL, $retourformulaire = NULL, $val = NULL,
                                  $objsf = NULL, $premiersf = NULL, $tricolsf = NULL, $validation = NULL,
                                  $idx = NULL, $maj = NULL, $retour = NULL) {

        if (($maj == 0 || (($maj == 3  || $maj == 2) && $this->getVal('document_travail') != 't'))
            && $this->f->contexte_dossier_instruction()) {

            // bouton retour HTML
            echo sprintf("\n".
                '<a class="retour" href="#" id="sousform-action-%s-back-%s" data-href="%s">%s</a>'."\n",
                $objsf, uniqid(),
                sprintf(
                    OM_ROUTE_SOUSFORM."&obj=%s&action=%d&idx=%s&retourformulaire=%s&idxformulaire=%s&retour=%s",
                    $objsf, 4, $idxformulaire, $retourformulaire, $idxformulaire, 'form'
                ),
                __('Retour')
            );

        } else if ($maj == 5 || $maj == 3 || $maj == 2) {
            // bouton retour HTML
            echo sprintf("\n".
                '<a class="retour" href="#" id="sousform-action-%s-back-%s" data-href="%s">%s</a>'."\n",
                $objsf, uniqid(),
                sprintf(
                    OM_ROUTE_SOUSFORM."&obj=%s&action=%d&idx=%s&retourformulaire=%s&idxformulaire=%s&retour=%s",
                    $objsf,310, $idxformulaire, $retourformulaire, $idxformulaire, 'form'
                ),
                __('Retour')
            );
        } else {
            parent::retoursousformulaire($idxformulaire, $retourformulaire, $val,
                                  $objsf, $premiersf, $tricolsf, $validation,
                                  $idx, $maj, $retour);
        }
    }

    /**
     * Methode verifier
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);
        // On verifie si il y a une autre collectivite multi
        $idTypeDocTrav = $this->get_document_numerise_type_id_by_code(CODE_TYPE_DOC_TRAVAIL);
        if ($this->valF['document_travail'] ||
            $this->get_boolean_from_pgsql_value($this->getVal('document_travail'))
        ) {
            if ($this->valF['document_numerise_type'] != $idTypeDocTrav) {
                $this->addToMessage('Le type des documents de travail ne peut pas être modifié');
                $this->correct = false;
            }
        } else {
            if ($this->valF['document_numerise_type'] == $idTypeDocTrav) {
                $this->addToMessage('Un document numérisé ne peut pas avoir pour type "document de travail"');
                $this->correct = false;
            }
        }
        // Vérification que la pièce n'a pas été modifié par un utilisateur non autorisé
        if (! empty($this->getVal('uid'))
            && ! $this->f->isAccredited($this->get_absolute_class_name()."_modifier_fichier")
            && ($this->getVal('uid') != $this->valF['uid'])) {
            $this->addToMessage('Droit insuffisant pour pouvoir modifier le fichier');
            $this->correct = false;
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        // parent::setSelect($form, $maj);
        // Si l'utilisateur a une entrée dans la table instructeur, on affiche les types
        // de pièces ayant la valeur ajout_instructeur valant true
        // Dans le cas d'un dossier d'instruction, filtrage des pièces selon le type de dossier
        $sql_document_numerise_type = $this->get_var_sql_forminc__sql("document_numerise_type");
        if ($this->f->isUserInstructeur() !== null && $this->f->isUserInstructeur() !== false
            && $this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
            $sql_document_numerise_type = str_replace(
                '<om_utilisateur_login>',
                $this->f->om_utilisateur['login'],
                $this->get_var_sql_forminc__sql("document_numerise_type_for_user_and_dossier_instruction_type")
            );
            $dossier_instruction = $this->f->get_inst__om_dbform(array(
                'obj' => 'dossier',
                'idx' => $this->f->get_submitted_get_value('idxformulaire')
            ));
            $sql_document_numerise_type = str_replace(
                '<dossier_instruction_type>',
                $dossier_instruction->getVal('dossier_instruction_type'),
                $sql_document_numerise_type
            );
        } elseif ($this->f->isUserInstructeur() !== null && $this->f->isUserInstructeur() !== false) {
            $sql_document_numerise_type = str_replace(
                '<om_utilisateur_login>',
                $this->f->om_utilisateur['login'],
                $this->get_var_sql_forminc__sql("document_numerise_type_for_user")
            );
        } elseif ($this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true
            && $this->f->get_submitted_get_value('idxformulaire') !== null) {
            $dossier_instruction = $this->f->get_inst__om_dbform(array(
                'obj' => 'dossier',
                'idx' => $this->f->get_submitted_get_value('idxformulaire')
            ));
            $sql_document_numerise_type = str_replace(
                '<dossier_instruction_type>',
                $dossier_instruction->getVal('dossier_instruction_type'),
                $this->get_var_sql_forminc__sql("document_numerise_type_for_dossier_instruction_type")
            );
        }
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "document_numerise_type",
            $sql_document_numerise_type,
            $this->get_var_sql_forminc__sql("document_numerise_type_by_id"),
            false
        );
        // Ajout des contraintes spécifiques pour l'ajout d'un fichier en retour de
        // consultation
        //Seulement dans le cas d'un dossier d'instruction
        if ($this->is_in_context_of_foreign_key("dossier", $this->getParameter("retourformulaire")) === true) {
            //Tableau des contraintes
            $params = array(
                "constraint" => array(
                    "extension" => ".gif;.jpg;.jpeg;.png;.pdf;.doc;.docx;.odt;.xls;.xlsx;.ods;.tiff;.bitmap"
                ),
            );
            
            $form->setSelect("uid", $params);
        }

        //
        if ($maj == 400) {
            $file = $this->f->storage->get($this->getVal('uid'));
            $base64 = base64_encode($file['file_content']);
            $form->setSelect('live_preview', array(
                'base64' => $base64,
                'mimetype' => $file['metadata']['mimetype'],
                'label' => $this->getVal('description_type'),
                'href' => sprintf(
                    '../app/index.php?module=form&snippet=file&obj=document_numerise&champ=uid&id=%1$s',
                    $this->getVal($this->clePrimaire)
                )
            ));
        }

        // document_numerise_nature
        $this->init_select(
            $form, 
            $this->f->db,
            $maj,
            null,
            "document_numerise_nature",
            $this->get_var_sql_forminc__sql("document_numerise_nature"),
            $this->get_var_sql_forminc__sql("document_numerise_nature_by_id"),
            true
        );
        // Changement du nom de l'option de valeur null en non applicable
        // pour le select de la nature du document numérisé.
        // La condition permet de gérer le cas des selectstatic et de n'afficher
        // "non applicable" uniquement si c'est la nature choisi.
        if ($form->select['document_numerise_nature'][0][0] == '') {
            $form->select['document_numerise_nature'][1][0] = 'Non applicable';
        }
    }

    // {{{ 
    // Méthodes de récupération des métadonnées document
    /**
     * Récupération du numéro de dossier d'instruction à ajouter aux métadonnées
     * @return [type] [description]
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
     * @return [type] [description]
     */
    protected function getNumDemandeAutor() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier_autorisation;
    }
    /**
     * Récupération de la date de demande initiale du dossier à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getAnneemoisDemandeAutor() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->date_demande_initiale;
    }
    /**
     * Récupération du type de dossier d'instruction à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getTypeInstruction() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier_instruction_type;
    }
    /**
     * Récupération du statut du dossier d'autorisation à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getStatutAutorisation() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->statut;
    }
    /**
     * Récupération du type de dossier d'autorisation à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getTypeAutorisation() {
        if(empty($this->specificMetadata)) {
            $this->getSpecificMetadata();
        }
        return $this->specificMetadata->dossier_autorisation_type;
    }
    /**
     * Récupération nom du fichier à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getFilename() {
        return $this->valF["nom_fichier"];
    }
    /**
     * Récupération de la date d'ajout de document à ajouter aux métadonnées
     * @return [type] [description]
     */
    protected function getDateEvenementDocument() {
        return date("Y-m-d", strtotime($this->valF["date_creation"]));
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
     * Récupération du libellé du type du document à ajouter aux métadonnées
     * @return string Groupe d'instruction
     */
    protected function getTitle() {
        $inst_document_numerise_type = $this->f->get_inst__om_dbform(array(
            "obj" => "document_numerise_type",
            "idx" => $this->valF["document_numerise_type"],
        ));
        return $inst_document_numerise_type->getVal("libelle");
    }


    /**
     * Récupération du paramètre d'affichage publique du document.
     *
     * @return boolean
     */
    public function getConsultationPublique() {

        // Identifiant du type de pièce
        $dnt_id = null;
        if ($this->getParameter('maj') == '0') {
            $dnt_id = $this->valF['document_numerise_type'];
        }

        // Instance du type de la pièce
        $inst_dnt = $this->get_inst_document_numerise_type($dnt_id);

        //
        $value = $this->get_boolean_from_pgsql_value($inst_dnt->getVal('aff_da'));
        //
        if ($value === true) {
            return 'true';
        }
        //
        if ($value === false) {
            return 'false';
        }
        //
        return null;
    }


    /**
     * Récupération du paramètre d'affichage aux tiers du document.
     *
     * @return boolean
     */
    public function getConsultationTiers() {

        //  Identifiant du type de pièce
        $dnt_id = null;
        if ($this->getParameter('maj') == '0') {
            $dnt_id = $this->valF['document_numerise_type'];
        }

        // Instance du type de la pièce
        $inst_dnt = $this->get_inst_document_numerise_type($dnt_id);

        //
        $value = $this->get_boolean_from_pgsql_value($inst_dnt->getVal('aff_service_consulte'));
        //
        if ($value === true) {
            return 'true';
        }
        //
        if ($value === false) {
            return 'false';
        }
        //
        return null;
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
     * Récupération des nomenclature des pièces
     *
     * @return boolean
     */
    protected function set_nomenclature_piece() {
        $nomenclaturePieces = array();

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    lien_document_n_type_d_i_t.dossier_instruction_type AS dossier_instruction_type,
                    lien_document_n_type_d_i_t.document_numerise_type AS document_numerise_type,
                    lien_document_n_type_d_i_t.code AS code
                FROM
                    %1$slien_document_n_type_d_i_t
                ORDER BY
                    document_numerise_type,
                    dossier_instruction_type',
                DB_PREFIXE
            ),
            array(
                'origin' => __METHOD__
            )
        );

        $idTypeDossier = -1;
        $idPiece = -1;
        foreach ($qres['result'] as $row) {
            if ($idPiece != $row['document_numerise_type']) {
                $idPiece = $row['document_numerise_type'];
            }
            if ($idTypeDossier != $row['dossier_instruction_type']) {
                $idTypeDossier = $row['dossier_instruction_type'];
            }
            $nomenclaturePieces[$idPiece][$idTypeDossier][] = $row['code'];
        }
        $this->nomenclaturePieces = $nomenclaturePieces;
    }

    /**
     * Renvoie le libellé du type de pièce avec les codes pièces associées sous la forme :
     *      CODE1 / ... / CODEN | libelle_type_piece
     * Si il n'y a pas de code associé à la pièce seul le libellé est renvoyé
     */
    public function get_libelle_piece_avec_nomenclature($libelleDocument, $idTypeDocument, $idTypeDossier) {
        // Remplissage du tableau des nomenclatures si il n'a pas déjà été rempli
        if (isset($this->nomenclaturePieces) !== true
            || $this->nomenclaturePieces === null) {
            $this->set_nomenclature_piece();
        }
        // Récupération des codes du type de pièce pour le type de dossier donné et
        // construction du libellé
        $nomenclaturePieces = $this->nomenclaturePieces;
        if (array_key_exists($idTypeDocument, $nomenclaturePieces)
            && array_key_exists($idTypeDossier, $nomenclaturePieces[$idTypeDocument])) {
            $libelleDocument = implode(' / ', $nomenclaturePieces[$idTypeDocument][$idTypeDossier])
                .' | '
                .$libelleDocument;
        }
        return $libelleDocument;
    }

    // Fin des méthodes de récupération des métadonnées
    // }}}

    /**
     * Permet de vérifier si le du document numérisé est déjà utilisé dans la BDD pour le
     * dossier d'instruction courant.
     * 
     * @param  string $filename Le nom du fichier dont on veut vérifier l'existence.
     * @return bool             true si le fichier existe, sinon false.
     */
    private function filename_exists_for_dossier_instruction($filename, $p_dossier = null) {
        // Identifiant du dossier d'instruction
        $idx_dossier = $p_dossier;
        if ($p_dossier === null
            || $p_dossier === '') {
            //
            $idx_dossier = $this->valF['dossier'];
        }
        // Requête
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    count(document_numerise)
                FROM
                    %1$sdocument_numerise
                WHERE
                    dossier = \'%2$s\'
                    AND nom_fichier = \'%3$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idx_dossier),
                $this->f->db->escapeSimple($filename)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Si le nom de fichier existe une ou plusieurs fois
        if ($qres["result"] >= 1) {
            return true;
        }
        return false;
    }

    /**
     * VIEW - generate_archive_piece
     * Permet de générer une archive zip contenant les documents passés en paramètre
     * 
     * @param string $ids Identifiant des documents numérisés séparés par une virgule.
     *
     * @return uid du fichier zip ou false si erreur.
     */
    function generate_archive_piece() {
        $this->f->disableLog();

        $return = array();

        if($this->f->get_submitted_get_value('ids') === null
            || $this->f->get_submitted_get_value('dossier') === null) {
            $return['status'] = false;
        }
        $ids = $this->f->get_submitted_get_value('ids');
        // Identifiant du DI ou DA (selon contexte des pièces)
        $dossier = $this->f->get_submitted_get_value('dossier');

        // Création du storage temporaire
        $temp = "0";
        $metadata = array(
            "filename" => time().".zip",
            "size" => 1,
            "mimetype" => "application/zip",
        );

        // Création du fichier zip en filestorage temporary
        if($this->f->storage == null) {
            $return['status'] = false;
        }
        $temp_uid = $this->f->storage->create_temporary($temp, $metadata);
        if($temp_uid == OP_FAILURE) {
            $return['status'] = false;
        }
        // Récupération de son path pour ziparchive
        $temp_path = $this->f->storage->getPath_temporary($temp_uid);
        // Récupération des uid de documents
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    uid
                FROM
                    %sdocument_numerise
                WHERE
                    document_numerise IN (%s)',
                DB_PREFIXE,
                $this->f->db->escapeSimple($ids)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );

        if ($qres["code"] !== "OK") {
            $return['status'] = false;
        }
        // Instanciation de l'archive
        $zip = new ZipArchive;
        $zip->open($temp_path, ZipArchive::OVERWRITE);
        // On rempli l'archive avec les documents récupérés sur le storage
        foreach ($qres['result'] as $row) {
            $file = $this->f->storage->get($row['uid']);
            if($file == OP_FAILURE) {
            $return['status'] = false;
            }
            $zip->addFromString($file['metadata']['filename'], $file['file_content']);
        }
        $zip->close();

        // Création d'un second temporary pour mettre à jour les métadonnées
        $size = filesize($temp_path);
        $id_doc = explode(',', $ids);
        $file_name = $dossier.'_'.date("Ymd");
        $metadata = array(
            "filename" => $file_name.".zip",
            "size" => $size,
            "mimetype" => "application/zip",
        );
        $uid = $this->f->storage->create_temporary($temp_path, $metadata, "from_path");
        // Suppression du temporaire
        $this->f->storage->delete_temporary($temp_uid);
        $return['status'] = true;

        if($uid == OP_FAILURE) {
            $return['status'] = false;
        }
        $return['file'] = $uid;
        echo json_encode($return);
    }

    /**
     * VIEW - generate_archive_doc
     * Permet de générer une archive zip contenant les documents passés en paramètre
     * 
     * @param string $ids Identifiant des documents numérisés séparés par une virgule.
     *
     * @return uid du fichier zip ou false si erreur.
     */
    function generate_archive_doc() {
        $this->f->disableLog();

        $return = array();

        if($this->f->get_submitted_get_value('ids') === null
            || $this->f->get_submitted_get_value('dossier') === null) {
            $return['status'] = false;
        }
        $ids = $this->f->get_submitted_get_value('ids');
        // Identifiant du DI ou DA (selon contexte des pièces)
        $dossier = $this->f->get_submitted_get_value('dossier');

        // Création du storage temporaire
        $temp = "0";
        $metadata = array(
            "filename" => time().".zip",
            "size" => 1,
            "mimetype" => "application/zip",
        );

        // Création du fichier zip en filestorage temporary
        if($this->f->storage == null) {
            $return['status'] = false;
        }
        $temp_uid = $this->f->storage->create_temporary($temp, $metadata);
        if($temp_uid == OP_FAILURE) {
            $return['status'] = false;
        }
        // Récupération de son path pour ziparchive
        $temp_path = $this->f->storage->getPath_temporary($temp_uid);
        // Récupération des uid de documents
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    uid,
                    nom_fichier AS libelle
                FROM
                    %1$sdocument_numerise
                WHERE
                    dossier LIKE \'%2$s\'
                    AND document_travail IS TRUE
                    AND uid IS NOT NULL
                UNION
                (SELECT
                    om_fichier_instruction as uid,
                    lettretype as libelle
                FROM
                    %1$sinstruction
                WHERE
                    dossier LIKE \'%2$s\' AND
                    om_fichier_instruction IS NOT NULL
                )',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        // En cas d'erreur de BD ou si aucune ligne n'a été récupéré le traitement
        // s'arrête et renvoie une erreur
        if ($qres["code"] !== "OK" || $qres['row_count'] === 0) {
            $return['status'] = false;
        } else {
            // Instanciation de l'archive
            $zip = new ZipArchive;
            $zip->open($temp_path, ZipArchive::OVERWRITE);
            // On rempli l'archive avec les documents récupérés sur le storage
            foreach ($qres['result'] as $row) {
                $file = $this->f->storage->get($row['uid']);
                if ($file == OP_FAILURE) {
                    $return['status'] = false;
                }
                $zip->addFromString($file['metadata']['filename'], $file['file_content']);
            }
            $zip->close();
    
            // Création d'un second temporary pour mettre à jour les métadonnées
            $size = filesize($temp_path);
            $id_doc = explode(',', $ids);
            $file_name = $dossier.'_'.date("Ymd");
            $metadata = array(
                "filename" => $file_name.".zip",
                "size" => $size,
                "mimetype" => "application/zip",
            );
            $uid = $this->f->storage->create_temporary($temp_path, $metadata, "from_path");
            // Suppression du temporaire
            $this->f->storage->delete_temporary($temp_uid);
            $return['status'] = true;

            if ($uid == OP_FAILURE) {
                $return['status'] = false;
            }
            $return['file'] = $uid;
        }
        echo json_encode($return);
    }

    /**
     * Méthode de traitement de fichier : trouillotage du fichier temporaire
     *
     * @param string $uid    uid du fichier à trouilloter
     * @param string $stamp    tampon pour le trouillotage du fichier
     * @return string/boolean retourne uid du fichier trouilloté ou false
     */
    function traitementFichierTrouillotage($uid, $stamp = "") {

        //
        $fichier_temporaire = $this->f->storage->storage->temporary_storage->get($uid);

        /*
         * DEBUT - Trouillotage du fichier
         */
        $msg_trouillotage = __("Erreur lors du trouillotage du fichier."); 

        //Récupération du contenu du fichier temporaire
        if ($fichier_temporaire === null || $fichier_temporaire === OP_FAILURE) {
            $this->addToMessage($msg_trouillotage." ".__("Le fichier est introuvable."));
            return false;
        }
        $fichier_content = base64_encode($fichier_temporaire["file_content"]);
        //Si on a pu récupérer le contenu, on le trouillote
        if ($fichier_content === false){
            $this->addToMessage($msg_trouillotage." ".__("Le contenu du fichier n'a pas pu etre recupere."));
            return false;
        }

        //Debut - STAMP
        $data = array(
            "base64" => $fichier_content,
            "stamp_value" => $stamp
        );
        if (file_exists("../dyn/services.inc.php")) {
            require "../dyn/services.inc.php";
        }
        // Vérification de la configuration du service de trouillotage
        if (isset($STAMP_WS_URL_) === false) {
            $this->addToMessage($msg_trouillotage." ".__("Le service de trouillotage numérique n'est pas configuré."));
            return false;
        }
        require_once PATH_OPENMAIRIE."om_rest_client.class.php";
        $inst_om_rest_client = new om_rest_client(
            $STAMP_WS_URL_
        );
        $response = $inst_om_rest_client->execute(
            "POST",
            "application/json",
            json_encode($data)
        );
        $fichier_trouillote = false;
        if ($inst_om_rest_client->getResponseCode() === 200) {
            $fichier_trouillote = base64_decode($response["base64"]);
        }
        if ($fichier_trouillote === false) {
            $this->addToMessage($msg_trouillotage." ".__("Le contenu trouillote du fichier n'a pas pu etre recupere."));
            return false;
        }
        //Fin - STAMP

        //Constitution des metadata du fichier temporaire trouilloté
        $metadata = $fichier_temporaire['metadata'];
        $metadata["size"] = strlen($fichier_trouillote);
        //Creation d'un fichier temporaire trouilloté à partir du contenu
        $tmp_fichier_trouillote = $this->f->storage->create_temporary($fichier_trouillote, $metadata, "from_content");
        if ($tmp_fichier_trouillote === OP_FAILURE) {
            $this->addToMessage($msg_trouillotage." ".__("Erreur lors de la creation du fichier trouillote temporaire."));
            return false;
        }
        return $tmp_fichier_trouillote;
    }


    /**
     * Méthode de traitement de fichier uploadé : récupération du fichier
     * temporaire, pour l'ajout avec trouillotage si l'option est activée. 
     *
     * @return string/boolean retourne true ou un message d'erreur
     */
    function traitementFichierUploadAjoutModification() {
        if ($this->f->is_option_trouillotage_numerique_enabled() !== true){
            return parent::traitementFichierUploadAjoutModification();
        }
         // Récupération du mode de l'action
        $crud = $this->get_action_crud();

        $type_list = array();
        // Récupération du tableau abstract_type si il existe sinon on utilise
        // les type de champs définis dans le formulaire
        if (isset($this->abstract_type)) {
            $type_list = $this->abstract_type;
        } elseif (isset($this->form->type)) {
            $type_list = $this->form->type;
        }
        
        // Pour chaque champs configurés avec les widgets upload, upload2 ou filestatic
        // ou chaque champs de type abstrait file défini dans le tableau abstract_type
        foreach ($type_list as $champ => $type) {
            //
            if ($type == "upload" OR $type == "upload2" OR $type == "filestatic"
                OR (isset($this->abstract_type) AND $type == "file")) {

                // Message d'erreur
                $msg = "";

                // Cas d'un ajout de fichier
                // Condition : si la valeur existante en base est vide ou que
                // nous sommes en mode 'AJOUT' ET qu'une valeur est postée pour
                // le champ fichier
                if (($this->getVal($champ) == ""
                        OR ($crud === 'create'
                            OR ($crud === null AND $this->getParameter('maj') == 0)))
                    AND isset($this->valF[$champ])
                    AND $this->valF[$champ] != "") {

                    // Si la valeur du champ contient le marqueur 'temporary'
                    $temporary_test = explode("|", $this->valF[$champ]);
                    //
                    if (isset($temporary_test[0]) && $temporary_test[0] == "tmp") {
                        //
                        if (!isset($temporary_test[1])) {
                            //
                            $msg = __("Erreur lors de la creation du fichier sur le champ").
                            " \"".$this->table.".".$champ."\". ";
                            $this->addToLog(__METHOD__."(): ".$msg, DEBUG_MODE);
                            $this->addToMessage($msg.__("Veuillez contacter votre administrateur."));
                            return $msg.__("Veuillez contacter votre administrateur.");
                        }

                        //Constitution du tampon 
                        $date_depot = $this->getDateEvenementDocument()!==null ? $this->getDateEvenementDocument():date(("Y-m-d H:i:s"));
                        $stamp = sprintf("%s %s",
                            $this->getDossier(),
                            $date_depot);
                        //Trouillotage
                        $fichier_trouillote = $this->traitementFichierTrouillotage($temporary_test[1],$stamp);
                        if(isset($fichier_trouillote) !== true
                            || $fichier_trouillote === false){
                            //
                            return $msg.__("Le contenu trouillote du fichier n'a pas pu etre recupere.");
                        }

                        // Récupération des métadonnées calculées après validation
                        $metadata = $this->getMetadata($champ); 
                        //Création du fichier définitif à partir du fichier temporaire trouilloté
                        $this->valF[$champ] = $this->f->storage->create($fichier_trouillote, $metadata, "from_temporary", $this->table.".".$champ);
                        // Si le fichier est vérouillé
                        if ($this->valF[$champ] === false) {
                            //
                            $msg =  __("Le fichier sur le champ")." ".$this->table.".".$champ." ".
                            __("est verouille. ");
                            $this->addToLog(__METHOD__."(): ".$msg, DEBUG_MODE);
                            $this->addToMessage($msg.__("Veuillez revalider le formulaire."));
                            return $msg.__("Veuillez revalider le formulaire.");
                        }
                        // Gestion du retour d'erreur
                        if ($this->valF[$champ] == OP_FAILURE) {
                            //
                            $msg = __("Erreur lors de la creation du fichier sur le champ").
                            " \"".$this->table.".".$champ."\". ";
                            $this->addToLog(__METHOD__."(): ".$msg, DEBUG_MODE);
                            $this->addToMessage($msg.__("Veuillez contacter votre administrateur."));
                            return  $msg.__("Veuillez contacter votre administrateur.");
                        }
                    }
                }

                // Cas d'une modification de fichier
                // Condition : si nous ne sommes pas en mode 'AJOUT' ET si la
                // valeur existante en base n'est pas vide ET qu'une valeur est
                // postée pour le champ fichier ET que la valeur postée est
                // différente de la valeur présente en base
                if ((($crud !== null AND $crud !== 'create')
                      OR ($crud === null AND $this->getParameter('maj') != 0))
                    AND $this->getVal($champ) != ""
                    AND isset($this->valF[$champ])
                    AND $this->valF[$champ] != ""
                    AND $this->getVal($champ) != $this->valF[$champ]) {

                    // Si la valeur du champ contient le marqueur 'temporary'
                    $temporary_test = explode("|", $this->valF[$champ]);
                    //
                    if (isset($temporary_test[0]) && $temporary_test[0] == "tmp") {
                        //
                        if (!isset($temporary_test[1])) {
                            //
                            $msg = __("Erreur lors de la mise a jour du fichier sur le champ").
                            " \"".$this->table.".".$champ."\". ";
                            $this->addToLog(__METHOD__."(): ".$msg.__("id")." = ".$this->valF[$this->clePrimaire]." - ".__("uid fichier")." = ".$this->getVal($champ), DEBUG_MODE);
                            $this->addToMessage($msg.__("Veuillez contacter votre administrateur."));
                            return $msg.__("Veuillez contacter votre administrateur.");
                        }

                        //Constitution du tampon 
                        $date_depot = $this->getDateEvenementDocument()!==null ? $this->getDateEvenementDocument():date(("Y-m-d H:i:s"));
                        $stamp = sprintf("%s %s",
                            $this->getDossier(),
                            $date_depot);
                        //Trouillotage
                        $fichier_trouillote = $this->traitementFichierTrouillotage($temporary_test[1],$stamp);
                        if(isset($fichier_trouillote) !== true
                            || $fichier_trouillote === false){
                            //
                            return $msg.__("Le contenu trouillote du fichier n'a pas pu etre recupere.");
                        }

                        // Sauvegarde de l'ancien fichier
                        $this->tmpFile[$champ] = $this->f->storage->get($this->getVal($champ));
                        // Récupération des métadonnées calculées après validation
                        $metadata = $this->getMetadata($champ);
                        //
                        $this->valF[$champ] = $this->f->storage->update($this->getVal($champ),$fichier_trouillote, $metadata, "from_temporary");
                        // Si le fichier est vérouillé
                        if ($this->valF[$champ] === false) {
                            //
                            $msg = __("Le fichier sur le champ")." ".$this->table.".".$champ." ".
                            __("est verouille. ");
                            $this->addToLog(__METHOD__."(): ".$msg.__("id")." = ".$this->valF[$this->clePrimaire]." - ".__("uid fichier")." = ".$this->getVal($champ), DEBUG_MODE);
                            $this->addToMessage($msg.__("Veuillez revalider le formulaire."));
                            return $msg.__("Veuillez revalider le formulaire");
                        }
                        // Gestion du retour d'erreur
                        if ($this->valF[$champ] == OP_FAILURE) {
                            //
                            $msg = __("Erreur lors de la mise a jour du fichier sur le champ").
                            " \"".$this->table.".".$champ."\". ";
                            $this->addToLog(__METHOD__."(): ".$msg.__("id")." = ".$this->valF[$this->clePrimaire]." - ".__("uid fichier")." = ".$this->getVal($champ), DEBUG_MODE);
                            $this->addToMessage($msg.__("Veuillez contacter votre administrateur."));
                            return $msg.__("Veuillez contacter votre administrateur.");
                        }
                    }
                }
            }
        }
        return true;
    }

    /**
     * Récupère l'identifiant du type de document depuis son code
     *
     * @param  string $dnt_code Code du type de document
     * @return mixed            Identifiant, vide s'il n'y pas de résultat, sinon false
     */
    public function get_document_numerise_type_id_by_code(string $dnt_code) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    document_numerise_type
                FROM
                    %1$sdocument_numerise_type
                WHERE
                    code = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dnt_code)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        return $qres["result"];
    }

    /**
     * Permet de recupérer le code du type de document par la clé primaire
     * @param  int $document_numerise_type Clé primaire d'un donnée de document_numerise_type
     * @return string                      Code du type de document 
     */
    private function get_document_numerise_type_code_by_id($document_numerise_type) {
        $inst_document_numerise_type = $this->get_inst_document_numerise_type($document_numerise_type);
        return $inst_document_numerise_type->getVal("code");
    }

    /**
     * Permet de récupérer le libellé de la catégorie du type de document
     * @param  int $document_numerise_type    Clé primaire d'un donnée de document_numerise_type
     * @return string                         Libellé de la catégorie du type de document
     */
    private function get_document_numerise_type_categorie_libelle($document_numerise_type) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    document_numerise_type_categorie.libelle
                FROM
                    %1$sdocument_numerise_type
                    LEFT JOIN %1$sdocument_numerise_type_categorie
                        ON document_numerise_type.document_numerise_type_categorie = document_numerise_type_categorie.document_numerise_type_categorie
                WHERE
                    document_numerise_type.document_numerise_type = %2$d',
                DB_PREFIXE,
                intval($document_numerise_type)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }


    /**
     * Cette méthode permet de stocker en attribut toutes les métadonnées
     * nécessaire à l'ajout d'un document.
     */
    public function getSpecificMetadata() {

        //Requête pour récupérer les informations essentiels sur le dossier d'instruction
        $sql = "SELECT dossier.dossier as dossier,
                        dossier_autorisation.dossier_autorisation as dossier_autorisation, 
                        to_char(dossier.date_demande, 'YYYY/MM') as date_demande_initiale,
                        dossier_instruction_type.code as dossier_instruction_type, 
                        etat_dossier_autorisation.libelle as statut,
                        dossier_autorisation_type.code as dossier_autorisation_type,
                        groupe.code as groupe_instruction,
                        CASE WHEN dossier.erp IS TRUE
                            THEN 'true'
                            ELSE 'false'
                        END as erp
                FROM ".DB_PREFIXE."dossier 
                    LEFT JOIN ".DB_PREFIXE."dossier_instruction_type  
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    LEFT JOIN ".DB_PREFIXE."dossier_autorisation 
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation 
                    LEFT JOIN ".DB_PREFIXE."etat_dossier_autorisation
                        ON  dossier_autorisation.etat_dossier_autorisation = etat_dossier_autorisation.etat_dossier_autorisation
                    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type_detaille
                        ON dossier_autorisation.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type = dossier_autorisation_type.dossier_autorisation_type
                    LEFT JOIN ".DB_PREFIXE."groupe
                        ON dossier_autorisation_type.groupe = groupe.groupe
                WHERE dossier.dossier = '".$this->valF["dossier"]."'";
        $res = $this->f->db->query($sql);
        $this->addToLog(
            __METHOD__."(): db->query(".$sql.")",
            VERBOSE_MODE
        );
        $this->f->isDatabaseError($res);
        //Le résultat est récupéré dans un objet
        $row =& $res->fetchRow(DB_FETCHMODE_OBJECT);

        //Si il y a un résultat
        if ($row !== null) {

            // Instrance de la classe dossier
            $inst_dossier = $this->get_inst_dossier($this->valF["dossier"]);

            // Insère l'attribut version à l'objet
            $row->version = $inst_dossier->get_di_numero_suffixe();

            //Alors on créé l'objet dossier_instruction
            $this->specificMetadata = $row;

        }
    }



    /**
     * CONDITION - is_ajoutable.
     *
     * Condition pour pouvoir ajouter
     *
     * @return boolean
     */
    function is_ajoutable() {
        // Test du bypass
        if ($this->f->isAccredited($this->get_absolute_class_name()."_ajouter_bypass")) {
            return true;
        }
        // Test des autres conditions
        return $this->is_ajoutable_or_modifiable_or_supprimable($this->getParameter("idxformulaire"));
    }

    /**
     * CONDITION - is_modifiable.
     *
     * Condition pour afficher le bouton modifier
     *
     * @return boolean
     */
    function is_modifiable() {
        // Test du bypass
        if ($this->f->isAccredited($this->get_absolute_class_name()."_modifier_bypass")) {
            return true;
        }
        // Test des autres conditions
        return $this->is_ajoutable_or_modifiable_or_supprimable();
    }

    /**
     * CONDITION - is_supprimable.
     *
     * Condition pour afficher le bouton supprimer
     * @return boolean
     */
    function is_supprimable() {
        // Test du bypass
        if ($this->f->isAccredited($this->get_absolute_class_name()."_supprimer_bypass")) {
            return true;
        }
        // Test des autres conditions
        return $this->is_ajoutable_or_modifiable_or_supprimable();
    }

    function is_not_deletable_if_file_send_to_platau() {
        // Tester si le dossier est envoyé a Plat'au
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    state
                FROM
                    %1$stask
                WHERE
                    object_id::integer = %2$d
                AND 
                    (type = \'ajout_piece\' OR type = \'add_piece\')',
                DB_PREFIXE,
                intval($this->getVal($this->clePrimaire))
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $state = $qres['result'];

        $inst_task = $this->f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));

        $task_val = array(
            $inst_task::STATUS_ARCHIVED,
            $inst_task::STATUS_DONE,
            $inst_task::STATUS_PENDING,
            $inst_task::STATUS_NEW,
        );

        if (in_array($state, $task_val, true)){
            return false;
        }

        return true;
    }

    /**
     * Conditions pour afficher les boutons modifier et supprimer
     *
     * @return boolean
     */
    function is_ajoutable_or_modifiable_or_supprimable() {
        // Tester si le dossier est cloturé ,
        // et si l'instructeur est de la même division
        if ($this->is_instructeur_from_division_dossier() === true and
            $this->is_dossier_instruction_not_closed() === true){
            return true;
        }

        return false;
    }


    /**
     * Retourne le statut du dossier d'instruction
     * @param string $idx Identifiant du dossier d'instruction
     * @return string Le statut du dossier d'instruction
     */
    function getStatutAutorisationDossier($idx){
        $statut = '';
        //Si l'identifiant du dossier d'instruction fourni est correct
        if ( $idx != '' ){
            //On récupère le statut de l'état du dossier d'instruction à partir de 
            //l'identifiant du dossier d'instruction
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        etat.statut
                    FROM
                        %1$sdossier
                        LEFT JOIN %1$setat
                            ON dossier.etat = etat.etat
                    WHERE
                        dossier = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($idx)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $statut = $qres["result"];
        }
        return $statut;
    }


    /**
     * Récupère l'état d'un dossier d'instruction
     * @param $idxDossier L'identifiant du dossier d'instruction
     * @return L'état du dossier d'instruction 
     */
    function getEtatDossier($idxDossier){
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    etat.etat
                FROM
                    %1$setat
                    LEFT JOIN %1$sdossier
                        ON dossier.etat = etat.etat
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idxDossier)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            $this->erreur_db($qres["message"], $qres["message"], 'document_numerise');
        }
        return $qres["result"];;
    }


    /**
     * Instance de la demande d'avis
     *
     * @var null
     */
    var $inst_demande_avis = null;

    /**
     * Récupère l'instance de la demande d'avis
     *
     * @param integer $demande_avis Identifiant de la demande d'avis
     *
     * @return object
     */
    function get_inst_demande_avis($demande_avis = null) {
        //
        if (is_null($this->inst_demande_avis)) {
            //
            if (is_null($demande_avis)) {
                // Récupère l'identifiant du formulaire parent
                $demande_avis = $this->getParameter("idxformulaire");
            }
            // Instancie la demande d'avis
            $this->inst_demande_avis = $this->f->get_inst__om_dbform(array(
                "obj" => "demande_avis",
                "idx" => $demande_avis,
            ));
        }
        //
        return $this->inst_demande_avis;
    }


    /**
    * Permet de recupérer l'identifiant du dossier d'instruction.
    *
    * @param integer $document_numerise Clé primaire de document_numerise.
    *
    * @return string dossier
    */
    private function get_libelle_dossier($document_numerise) {
        $inst_document_numerise = $this->f->get_inst__om_dbform(array(
            "obj" => "document_numerise",
            "idx" => $document_numerise,
        ));
        return $inst_document_numerise->getVal("dossier");
    }


    /**
     * Récupère l'instance de dossier message.
     *
     * @param string $dossier_message Identifiant du message.
     *
     * @return object
     */
    private function get_inst_dossier_message($dossier_message = null) {
        //
        return $this->get_inst_common("dossier_message", $dossier_message);
    }


    /**
     * Récupère l'instance de document_numerise_type.
     *
     * @param string $document_numerise_type Identifiant du message.
     *
     * @return object
     */
    private function get_inst_document_numerise_type($document_numerise_type = null) {
        //
        return $this->get_inst_common("document_numerise_type", $document_numerise_type);
    }

    /**
     * Récupère l'instance de document_numerise_nature.
     *
     * @param string $document_numerise_nature Identifiant du message.
     *
     * @return object
     */
    private function get_inst_document_numerise_nature($document_numerise_nature = null) {
        //
        return $this->get_inst_common("document_numerise_nature", $document_numerise_nature);
    }


    /**
     * Ajout d'un contenu spécifique à la fin du sous-formulaire.
     *
     * @param integer $maj État du formulaire.
     *
     * @return void
     */
    public function sousFormSpecificContent($maj) {
        // Si l'option de notification par message de l'ajout d'une pièce
        // numérisée est activée
        if ($this->f->getParameter('option_notification_piece_numerisee') === 'true') {
            //
            echo "<input id=\"dossier_message_id\" name=\"dossier_message_id\" type=\"hidden\" value=\"".$this->get_dossier_message_id()."\" />";
        }
    }

    /*
     * CONDITION - can_user_access_dossier_contexte_ajout
     *
     * Vérifie que l'utilisateur a bien accès au dossier d'instruction passé dans le
     * formulaire d'ajout.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_ajout() {

        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $id_dossier = 
            $this->f->get_submitted_get_value('idxformulaire') : $id_dossier = "");
        //
        if ($id_dossier !== "") {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
    }

   /*
     * CONDITION - can_user_access_dossier_contexte_modification
     *
     * Vérifie que l'utilisateur a bien accès au dossier lié au document instancié.
     * Cette méthode vérifie que l'utilisateur est lié au groupe du dossier, et si le
     * dossier est confidentiel qu'il a accès aux confidentiels de ce groupe.
     * 
     */
    function can_user_access_dossier_contexte_modification() {

        $id_dossier = $this->getVal('dossier');
        //
        if ($id_dossier !== "" && $id_dossier !== null) {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_instruction",
                "idx" => $id_dossier,
            ));
            //
            return $dossier->can_user_access_dossier();
        }
        return false;
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
        return false;
    }

    public function view_json_data() {
        $this->checkAccessibility();
        $this->f->disableLog();
        $view = $this->get_json_data();
        printf(json_encode($view));
    }

    public function get_json_data() {
        $val = array_combine($this->champs, $this->val);
        foreach ($val as $key => $value) {
            $val[$key] = strip_tags($value);
        }
        $inst_dnt = $this->get_inst_document_numerise_type($val['document_numerise_type']);
        $val['document_numerise_type_code'] = $inst_dnt->getVal('code');
        $val['document_numerise_type_libelle'] = $inst_dnt->getVal('libelle');
        $inst_dnn = $this->get_inst_document_numerise_nature($val['document_numerise_nature']);
        $val['document_numerise_nature_code'] = $inst_dnn->getVal('code');
        $val['document_numerise_nature_libelle'] = $inst_dnn->getVal('libelle');
        return $val;
    }

    protected function getDocumentType($champ = null) {
        $typeId = $this->getVal('document_numerise_type');
        if (empty($typeId) && isset($this->valF['document_numerise_type'])) {
            $typeId = $this->valF['document_numerise_type'];
        }
        if (! empty($typeId)) {
            $type = $this->f->findObjectById('document_numerise_type', $typeId);
            if (! empty($type)) {
                return __("Pièce").':'.$type->getVal('libelle');
            }
        }
        return parent::getDocumentType($champ);
    }

    /**
     * Affiche la page de téléchargement du document de la notification.
     *
     * @param boolean $content_only Affiche le contenu seulement.
     *
     * @return void
     */
    public function view_telecharger_document_anonym() {
        // Par défaut on considère qu'on va afficher le formulaire
        $idx = 0;
        // Flag d'erreur
        $error = false;
        // Message d'erreur
        $message = '';

        // Paramètres GET : récupération de la clé d'accès
        $cle_acces_document = $this->f->get_submitted_get_value('key');
        $cle_acces_document = $this->f->db->escapeSimple($cle_acces_document);
        // Vérification de l'existence de la clé et récupération de l'uid du fichier
        $uidFichier = $this->getUidDocumentNumeriseWithKey($cle_acces_document);
        if ($uidFichier != null) {
            // Récupération du document
            $file = $this->f->storage->get($uidFichier);

            // Headers
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date dans le passé
            header("Content-Type: ".$file['metadata']['mimetype']);
            header("Accept-Ranges: bytes");
            header("Content-Disposition: inline; filename=\"".$file['metadata']['filename']."\";" );
            // Affichage du document
            echo $file['file_content'];

            // Récupération de la date de premier accès et maj du suivi uniquement
            // si la date de 1er accès n'a pas encore été remplis
            $inst_notif = $this->getInstanceNotificationWithKey($cle_acces_document);
            if ($inst_notif->getVal('date_premier_acces') == null ||
                $inst_notif->getVal('date_premier_acces') == '') {
                $notif_val = array();
                foreach ($inst_notif->champs as $champ) {
                    $notif_val[$champ] = $inst_notif->getVal($champ);
                }
                $notif_val['date_premier_acces'] = date("d/m/Y H:i:s");
                $notif_val['statut'] = 'vu';
                $notif_val['commentaire'] = 'Le document a été vu';
                $suivi_notif = $inst_notif->modifier($notif_val);
            }

        } else {
            // Page vide 404
            printf('Ressource inexistante');
            header('HTTP/1.0 404 Not Found');
        }
    }

    /**
     * Récupère une clé et renvoie l'uid du document liée à cette
     * clé. Si la clé n'existe pas renvoie null.
     * 
     * @param string $cleGen clé dont on cherche l'instruction
     * @return integer|null 
     */
    protected function getUidDocumentNumeriseWithKey($cleGen) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    document_numerise.uid
                FROM
                    %1$sinstruction_notification_document
                    LEFT JOIN %1$sdocument_numerise
                        ON instruction_notification_document.document_id = document_numerise.document_numerise
                WHERE
                    instruction_notification_document.cle = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($cleGen)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

    /**
     * Récupère une clé, fait une requête pour récupérer l'id de la notification liée a cette clé.
     * Récupère l'instance de instruction_notification dont l'id a été récupéré et la renvoie.
     * 
     * @param string $cleGen
     * @return instruction_notification
     */
    protected function getInstanceNotificationWithKey($key) {
        // TODO : refactoriser pour éviter d'avoir a réecrire cette méthode dans chaque classe
        // a laquelle la consultation anonyme des documents est associée
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    instruction_notification
                FROM
                    %1$sinstruction_notification_document
                WHERE
                    cle = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($key)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Récupération de l'instance de notification
        $instNotif = $this->f->get_inst__om_dbform(array(
            "obj" => "instruction_notification",
            "idx" => $qres["result"],
        ));
        return $instNotif;
    }

    /**
     * Template de l'affichage d'un onglet pour les vues
     * @var string
     */
    var $template_view =
        '<div class="formEntete ui-corner-all">
            <!-- Action ajouter -->
            %s
            %s
            <!-- Liste des pièces -->
            %s
        </div>';

    /**
     * template du lien permettant d'afficher l'action d'ajout de pièce
     * @var string
     */
    var $template_link_add =
        '<p>
            <a id="action-soustab-blocnote-message-ajouter" onclick="ajaxIt(\'%s\', \'%s&obj=%s&action=0&tri=&objsf=document_numerise&premiersf=0&retourformulaire=%s&idxformulaire=%s&trisf=&retour=tab\');"
            href="#">
                <span class="om-icon om-icon-16 om-icon-fix add-16" title="Ajouter">Ajouter</span>
                %s
            </a>
        </p>';

    /**
     * template du lien permettant d'afficher l'action d'ajout de pièce
     * @var string
     */
    var $template_link_download_zip =
        "<p>
            <a id='zip_download_link' onclick='zip_doc_numerise(%1\$s, \"%2\$s\", \"%3\$s\", \"%4\$s\");' href='#'>
                <span class='om-icon om-icon-16 om-icon-fix archive-16'
                title='%5\$s'>%5\$s</span>
                %5\$s
            </a>
        </p>";

    /**
     * template de l'en-tête d'un listing
     * @var string
     */
    var $template_header  =
        '<thead>
            <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                <th class="title col-0 firstcol %s" colspan="%s">
                    <span class="name">
                        %s
                    </span>
                </th>
            </tr>
        </thead>';

    /**
     * template de l'en-tête d'un listing
     * @var string
     */
    var $template_filename_download = '
        <a class="lienTable lienDocumentNumerise" href="../app/index.php?module=form&snippet=file&obj=document_numerise&champ=uid&id=%1$s" target="_blank" id="document_numerise_%2$s">
            <span class="om-prev-icon reqmo-16" title="Télécharger">
                %3$s
            </span>
        </a>';

    /**
     * Template de visualisation du nom du fichier en lecture seule
     *(Pas d'accès au téléchargement de la pièce)
     * @var string
     */
    var $template_filename_readonly =
        '<p class="lienDocumentNumerise" id="document_numerise_%2$s">%3$s';

    /**
     * Template de visualisation de l'icône de l'action Consulter 
     * @var string
     */
    var $template_icon_view_link =
        '<a onclick="ajaxIt(\'%s\',\'%s&obj=%s&action=3&idx=%s&tri=&premier=0&objsf=document_numerise&premiersf=0&retourformulaire=%s&idxformulaire=%s&trisf=&retour=tab\');" href="#">
            <span class="om-icon om-icon-16 om-icon-fix consult-16" title="Consulter">
                Consulter
            </span>
        </a>';

    /**
     * Template de l'action de prévisualisation dans un overlay
     * @var string
     */
    var $template_icon_preview_link =
        '<a id="action-form-%1$s-%2$s-preview_edition" class="action action-self" href="%3$s" title="%4$s">
            <span class="om-icon om-icon-16 om-icon-fix preview-16" title="%4$s">
                %4$s
            </span>
        </a>';

    /**
     * Template de l'action de prévisualisation dans un overlay
     * @var string
     */
    var $template_info_view_link =
        '<a class="lienTable" onclick="ajaxIt(\'%1$s\',\'%2$s&obj=%1$s&action=3&idx=%3$s&tri=&premier=0&objsf=document_numerise&premiersf=0&retourformulaire=%4$s&idxformulaire=%5$s&trisf=&retour=tab\');" href="#">
            %6$s
        </a>';
    
    /**
     * Template de la structure d'un listing (tableau) à 3 colonnes
     * @var string
     */
    var $template_line_3col =
        '<tr class="tab-data %s">
            <td class="icons">
                %s
            </td>
            <td class="col-0 firstcol">
                %s
            </td>
            <td class="col-1">
                %s
            </td>
        </tr>';
    
    /**
     * Template de la structure d'un listing (tableau) à 4 colonnes
     * @var string
     */
    var $template_line_4col =
        '<tr class="tab-data %s">
            <td class="icons">
                %s
            </td>
            <td class="col-0 firstcol">
                %s
            </td>
            <td class="col-1">
                %s
            </td>
            <td class="col-2">
                %s
            </td>
        </tr>';

    /**
     * Template du lien pour la visualisation du document
     * @var string
     */                     
    var $template_link_file =
        '<a class="lienTable" href="../app/index.php?module=form&snippet=file&obj=%s&champ=%s&id=%s" target="_blank">
            <span class="om-prev-icon reqmo-16" title="%s">
                %s
            </span>
        </a>';

    /**
     * Affichage de l'url de téléchargement sans icone
     * @var string
     */
    var $template_link_file_telechargement =
        '<a class="lienTable" href="../app/index.php?module=form&snippet=file&obj=%s&champ=%s&id=%s" target="_blank">
                %s
        </a>';

    /**
     * Template d'une checkbox
     * @var string
     */
    var $template_checkbox =
        '<input type="checkbox" name="%1$s" id="%2$s" %3$s="%4$s" class="%5$s" %6$s />
        <label for="%2$s">
            %7$s
        </label>';
    
    /**
     * Template pour l'affichage d'une ligne du tableau
     * @var string
     */
    var $template_row = '<tr class="tab-data %s">%s</tr>';

    /**
     * Template pour l'affichage d'une cellule
     * @var string
     */
    var $template_cell = '<td class="col-%s %s">%s</td>';
}// fin classe
