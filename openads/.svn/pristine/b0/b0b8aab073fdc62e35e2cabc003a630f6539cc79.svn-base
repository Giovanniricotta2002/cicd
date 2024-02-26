<?php
/**
 * DBFORM - 'demande' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'demande'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/demande.class.php";

require_once "../obj/geoads.class.php";

/**
 * Définition de la classe 'demande'.
 *
 * Cette classe permet d'interfacer la demande, c'est-à-dire l'enregistrement
 * représentant une demande faite par un pétitionnaire pour un nouveau dossier
 * ou pour un dossier existant.
 */
class demande extends demande_gen {

    var $valIdDemandeur = array("petitionnaire_principal" => array(),
                                "delegataire" => array(),
                                "petitionnaire" => array(),
                                "plaignant_principal" => array(),
                                "plaignant" => array(),
                                "contrevenant_principal" => array(),
                                "contrevenant" => array(),
                                "requerant_principal" => array(),
                                "requerant" => array(),
                                "avocat_principal" => array(),
                                "avocat" => array(),
                                "bailleur_principal" => array(),
                                "bailleur" => array(),
                                "proprietaire" => array(),
                                "architecte_lc" => array(),
                                "paysagiste" => array(),
                            );
    var $postedIdDemandeur = array("petitionnaire_principal" => array(),
                                "delegataire" => array(),
                                "petitionnaire" => array(),
                                "plaignant_principal" => array(),
                                "plaignant" => array(),
                                "contrevenant_principal" => array(),
                                "contrevenant" => array(),
                                "requerant_principal" => array(),
                                "requerant" => array(),
                                "avocat_principal" => array(),
                                "avocat" => array(),
                                "bailleur_principal" => array(),
                                "bailleur" => array(),
                                "proprietaire" => array(),
                                "architecte_lc" => array(),
                                "paysagiste" => array(),
                            );

    var $autreDossierEnCour;

    var $cerfa = null;

    /**
     * Instance du paramétrage de la taxe d'aménagement
     *
     * @var null
     */
    var $inst_taxe_amenagement = null;

    /**
     * Instance de la classe dossier_autorisation.
     *
     * @var mixed (resource | null)
     */
    var $inst_dossier_autorisation = null;

    /**
     * Instance de la classe cerfa.
     *
     * @var mixed (resource | null)
     */
    var $inst_cerfa = null;

    /**
     * Liste des types de demandeur
     * @var array
     */
    var $types_demandeur = array(
        "petitionnaire_principal",
        "delegataire",
        "petitionnaire",
        "plaignant_principal",
        "plaignant",
        "contrevenant_principal",
        "contrevenant",
        "requerant_principal",
        "requerant",
        "avocat_principal",
        "avocat",
        "bailleur_principal",
        "bailleur",
        "proprietaire",
        "architecte_lc",
        "paysagiste",
    );

    /**
     * Liste des sources du dépôt
     */
    const SOURCE_DEPOT = array(
        'app',
        PLATAU,
        PORTAL
    );

    /**
     *
     * @return string
     */
    function get_default_libelle() {
        // Récupération de l'instance du dossier d'instruction pour accéder à son
        // libellé
        $inst_di = $this->get_inst_dossier_instruction($this->getVal('dossier_instruction'));
        // Retourne le résultat
        return $inst_di->getVal('dossier_libelle');
    }

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {

        // On récupère les actions génériques définies dans la méthode 
        // d'initialisation de la classe parente
        parent::init_class_actions();

        // ACTION - 003 - consulter
        //
        $this->class_actions[3]["condition"] = "is_user_from_allowed_collectivite";

        // ACTION - 100 - pdfetat
        // Permet de visualiser le récépissé de la demande
        $this->class_actions[100] = array(
            "identifier" => "pdfetat",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("Editer le recepisse PDF"),
                "order" => 100,
                "class" => "pdf-16",
            ),
            "view" => "view_pdfetat",
            "permission_suffix" => "consulter",
        );

        // ACTION - 110 - affichage_reglementaire_registre
        // Affiche un formulaire pour visualiser le registre réglementaire
        $this->class_actions[110] = array(
            "identifier" => "affichage_reglementaire_registre",
            "view" => "view_reglementaire_registre",
            "permission_suffix" => "consulter",
        );

        // ACTION - 111 - generate_affichage_reglementaire_registre
        // Génère et affiche le PDF registre d'affichage réglementaire
        $this->class_actions[111] = array(
            "identifier" => "generate_affichage_reglementaire_registre",
            "view" => "view_generate_affichage_reglementaire_registre",
            "permission_suffix" => "consulter",
        );

        // ACTION - 120 - affichage_reglementaire_attestation
        // Affiche un formulaire pour visualiser l'attestation réglementaire
        $this->class_actions[120] = array(
            "identifier" => "affichage_reglementaire_attestation",
            "view" => "view_reglementaire_attestation",
            "permission_suffix" => "consulter",
        );

        // ACTION - 130 - Récupération de l'adresse
        $this->class_actions[130] = array(
            "identifier" => "get_adresse",
            "view" => "view_get_adresse_by_cadastre",
            "permission_suffix" => "recuperer_adresse",
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        $champs = array(
            "demande",
            "demande.om_collectivite"
        );
        if ($this->f->is_option_dossier_commune_enabled()) {
            $champs[] = "demande.commune";
        }
        array_push($champs,
            "dossier_autorisation_type_detaille",
            "demande.depot_electronique",
            "demande_type",
            "'' as affectation_automatique",
            "dossier_instruction",
            "demande.dossier_autorisation",
            "dossier.etat as \"etat\"",
            "demande.autorisation_contestee",
            "dossier.date_depot_mairie",
            "demande.date_demande",
            "'' as num_doss_manuel",
            "'' as num_doss_type_da",
            "'' as num_doss_code_depcom",
            "'' as num_doss_annee",
            "'' as num_doss_division",
            "'' as num_doss_sequence",
            "'' as num_doss_complet",
            "demande.parcelle_temporaire",
            "demande.terrain_references_cadastrales",
            "demande.terrain_adresse_voie_numero",
            "demande.terrain_adresse_voie",
            "demande.terrain_adresse_lieu_dit",
            "demande.terrain_adresse_localite",
            "demande.terrain_adresse_code_postal",
            "demande.terrain_adresse_bp",
            "demande.terrain_adresse_cedex",
            "demande.terrain_superficie",
            "instruction_recepisse",
            "arrondissement",
            "source_depot",
            "dossier.etat_transmission_platau"
        );
        return $champs;
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
                    ON demande.dossier_instruction = dossier.dossier',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_commune() {
        return "
            SELECT
                commune.commune,
                commune.com || ' - ' || commune.libelle AS libelle
            FROM
                ".DB_PREFIXE."commune
            WHERE
                (commune.om_validite_debut IS NULL OR commune.om_validite_debut < NOW())
                AND (commune.om_validite_fin IS NULL OR commune.om_validite_fin > NOW())
            ORDER BY
                commune.libelle ASC
        ";
    }

    /**
     * CONDITION - is_user_from_allowed_collectivite.
     *
     * Cette condition permet de vérifier si l'utilisateur connecté appartient
     * à une collectivité autorisée : c'est-à-dire de niveau 2 ou identique à
     * la collectivité de l'enregistrement sur lequel on se trouve.
     *
     * @return boolean
     */
    public function is_user_from_allowed_collectivite() {

        // Si l'utilisateur est de niveau 2
        if ($this->f->isCollectiviteMono() === false) {
            // Alors l'utilisateur fait partie d'une collectivité autorisée
            return true;
        }

        // L'utilisateur est donc de niveau 1
        // On vérifie donc si la collectivité de l'utilisateur est la même
        // que la collectivité de l'élément sur lequel on se trouve
        if ($_SESSION["collectivite"] === $this->getVal("om_collectivite")) {
            // Alors l'utilisateur fait partie d'une collectivité autorisée
            return true;
        }

        // L'utilisateur ne fait pas partie d'une collectivité autorisée
        return false;
    }


    /**
     *
     */
    function get_inst_dossier_instruction($dossier_instruction = null) {
        //
        return $this->get_inst_common(
            "dossier_instruction",
            $dossier_instruction,
            "dossier"
        );
    }

    /**
     * VIEW - view_pdfetat
     *
     * Génère un récépissé PDF de la demande.
     *
     * @return void
     */
    function view_pdfetat() {
        // Identifiant de la demande
        $idx = $this->getVal($this->clePrimaire);

        // Requête qui récupère le type de lettre type
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    instruction.instruction,
                    instruction.lettretype,
                    demande.om_collectivite,
                    demande.dossier_instruction
                FROM
                    %1$sdemande
                    LEFT JOIN %1$sinstruction
                        ON demande.instruction_recepisse = instruction.instruction
                WHERE
                    demande.demande = %2$d',
                DB_PREFIXE,
                intval($idx)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        $row = array_shift($qres['result']);

        // Si la requête nous retourne un résultat
        if (isset($row["instruction"])
            && !empty($row["instruction"])
            && isset($row["lettretype"])
            && !empty($row["lettretype"])) {

            // récupération des paramètres de la collectivité
            $coll_param = $this->f->getCollectivite($row["om_collectivite"]);

            // Génération du récépissé
            $pdf_output = $this->compute_pdf_output(
                "lettretype",
                $row["lettretype"],
                $coll_param,
                $row["instruction"]
            );
            // Mise à disposition du récépissé
            $this->expose_pdf_output(
                $pdf_output['pdf_output'],
                "recepisse_depot_".$row["dossier_instruction"].".pdf"
            );
        } else {
            // On indique à l'utilisateur que le récépissé n'existe pas
            $this->f->displayMessage("error", _("Le recepisse demande n'existe pas."));
        }
    }

    /**
     * VIEW - view_reglementaire_registre
     *
     * Affiche un formulaire pour génèrer le registre d'affichage réglementaire.
     *
     * @return void
     */
    function view_reglementaire_registre() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        /**
         * Gestion des erreurs : vérification du paramétrage
         */
        $error = false;
        // Récupération de l'événement correspondant à l'instruction à insérer pour chaque dossier du registre
        $aff_obli = $this->f->getParameter('id_affichage_obligatoire');
        // Si le paramétrage est vide ou pas numérique
        if ($aff_obli == "" or !is_numeric($aff_obli)) {
            $error = true;
        } else {
            // Si pas de correspondance d'événement dans la base
            if ($this->evenement_exist($aff_obli) != true) {
                $error = true;
            }
        }
        // Affichage d'un message si en erreur
        if ($error == true) {
            $error_msg = sprintf(
                "%s %s",
                sprintf(
                    __("Erreur de paramétrage, le paramètre %s n'est pas renseigné ou sa valeur n'est pas compatible."),
                    "<b>id_affichage_obligatoire</b>"
                ),
                __("Veuillez contacter votre administrateur.")
            );
            $this->f->displayMessage("error", $error_msg);
            return;
        }

        // Si un affichage réglementaire des dossiers est demandé (appel en ajax)
        if ($this->f->get_submitted_post_value('submit') !== null) {
            // Désactivation des logs car appel en ajax
            $this->f->disableLog();
            // Récupère la collectivité de l'utilisateur
            $this->f->getCollectivite();
            // Récupération de la liste des dossiers d'instruction dont l'état est
            // "encours" et le groupe est 'ADS'. Une jointure avec la table instruction 
            // permet de savoir si le dossier a déjà été affiché ou non en récupérant 
            // l'id de l'événement qui représente l'attestion de l'affichage 
            // réglementaire dans le paramétrage.
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        dossier.dossier,
                        instruction.instruction,
                        dossier.om_collectivite
                    FROM
                        %1$sdossier
                        LEFT JOIN %1$sinstruction
                            ON dossier.dossier=instruction.dossier
                                AND instruction.evenement = %2$d
                        LEFT JOIN %1$sdossier_autorisation
                            ON dossier.dossier_autorisation =
                                dossier_autorisation.dossier_autorisation
                        LEFT JOIN %1$sdossier_autorisation_type_detaille
                            ON dossier_autorisation.dossier_autorisation_type_detaille =
                                dossier_autorisation_type_detaille.dossier_autorisation_type_detaille 
                        LEFT JOIN %1$sdossier_autorisation_type
                            ON dossier_autorisation_type_detaille.dossier_autorisation_type =
                                dossier_autorisation_type.dossier_autorisation_type
                        LEFT JOIN %1$sgroupe
                            ON dossier_autorisation_type.groupe = groupe.groupe
                        LEFT JOIN %1$sdossier_instruction_type
                            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    WHERE 
                        (select 
                            e.statut 
                        from 
                            %1$setat e 
                        where 
                            e.etat = dossier.etat 
                        ) = \'encours\'
                    AND groupe.code = \'ADS\'
                    AND LOWER(dossier_instruction_type.code) IN (\'p\',\'m\',\'t\')
                    AND dossier.om_collectivite = %3$d',
                    DB_PREFIXE,
                    intval($aff_obli),
                    intval($this->f->getParameter('om_collectivite_idx'))
                ),
                array(
                    'origin' => __METHOD__,
                    'force_return' => true
                )
            );
            if ($qres['code'] !== 'OK') {
                $error_msg = sprintf(
                    "%s %s",
                    __("Impossible de récupérer les dossiers d'instruction en cours."),
                    __("Veuillez contacter votre administrateur.")
                );
                $this->f->displayMessage("error", $error_msg);
                $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                return;
            }
            // Boucle sur les dossiers
            foreach ($qres['result'] as $row) {
                // Si aucune instruction n'a d'événement de type "affichage_obligatoire"
                // on créé une nouvelle instruction avec cet événement.
                if ($row["instruction"] == "") {
                    // Instanciation d'instruction pour ajout
                    $instr = $this->f->get_inst__om_dbform(array(
                        "obj" => "instruction",
                        "idx" => "]",
                    ));
                    // Création d'un tableau avec la liste des champs de l'instruction
                    foreach($instr->champs as $champ) {
                        $valF[$champ] = ""; 
                    }
                    $valF["destinataire"] = $row['dossier'];
                    $valF["date_evenement"] = date("d/m/Y");
                    $valF["evenement"] = $aff_obli;
                    $valF["dossier"] = $row['dossier'];

                    // Définition des valeurs de la nouvelle instruction
                    $instr->valF = array();
                    // Insertion dans la base
                    $res_ajout = $instr->ajouter($valF);
                    if ($res_ajout === false) {
                        $error_msg = sprintf(
                            "%s %s",
                            __("Erreur lors de l'ajout de l'instruction d'affichage obligatoire."),
                            __("Veuillez contacter votre administrateur.")
                        );
                        $this->f->displayMessage("error", $error_msg);
                        $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                        return;
                    }

                    //Finalisation du document
                    $_GET['obj']='instruction';
                    $_GET['idx']=$instr->valF[$instr->clePrimaire];
                    $instr = $this->f->get_inst__om_dbform(array(
                        "obj" => "instruction",
                        "idx" => $_GET['idx'],
                    ));
                    // On se met en contexte de l'action 100 finaliser
                    $instr->setParameter('maj',100);
                    $finalise_instr = $instr->finalize();
                    if ($finalise_instr === false) {
                        $error_msg = sprintf(
                            "%s %s",
                            __("Erreur lors de la finalisation de l'instruction d'affichage obligatoire."),
                            __("Veuillez contacter votre administrateur.")
                        );
                        $this->f->displayMessage("error", $error_msg);
                        $this->f->addToLog(__METHOD__."(): ".$error_msg, DEBUG_MODE);
                        return;
                    }
                }
            }
            //
            $valid_msg = sprintf(
                "%s<br/><br/>%s",
                __("Traitement terminé. Le registre a été généré."),
                sprintf(
                    '<a href="%1$s&obj=demande_affichage_reglementaire_registre&action=111&idx=0" id="%2$s" target="_blank"><span class="om-icon om-icon-16 om-icon-fix reqmo-16" title="%3$s"></span> %3$s</a>',
                    OM_ROUTE_FORM,
                    "registre-form-download",
                    __("Télécharger le registre")
                )
            );
            $this->f->displayMessage("valid", $valid_msg);

        } else { // Sinon affichage standard
            // Affichage de la description de l'écran
            $description = sprintf(
                '<div id="registre-form-fonctionnement" class="registre-form-bloc"><h3>%s</h3><p>%s :</p><ul><li>%s</li><li>%s</li><li>%s</li></ul><br/><p>%s :</p><ul><li>%s</li><li>%s</li></ul></div>',
                __("Fonctionnement"),
                __("Le traitement de génération du registre d'affichage réglementaire va"),
                __("générer le registre que vous devez imprimer et afficher en mairie"),
                __("créer une instruction d'<i>attestation d'affichage suite au dépôt</i> sur chaque dossier d'instruction en cours"),
                __("mettre à jour la <i>date d'affichage</i> de chaque dossier d'instruction en cours"),
                __("Nota bene"),
                __("la <i>date d'affichage</i> est mise à jour uniquement sur les dossiers d'instruction pour lesquels elle n'avait pas été renseignée"),
                __("l'instruction d'<i>attestation d'affichage suite au dépôt</i> est générée uniquement sur les dossiers d'instruction pour lesquels elle n'existe pas déjà")
            );
            $this->f->displayDescription($description);
            // Ouverture du formulaire
            echo "\t<form";
            echo " method=\"post\"";
            echo " id=\"affichage_reglementaire_registre_form\"";
            echo " action=\"#\"";
            echo ">\n";
            //
            echo "<div id=\"msg\"></div>";
            // Affichage du bouton
            echo "\t<div class=\"formControls\">\n";
            printf(
                "<input id=\"registre-form-submit\" class=\"class=\"om-button\" type=\"button\" value=\"%s\" onClick=\"registre_form_confirmation_action('form', this, '%s')\" data-href=\"%s&obj=demande_affichage_reglementaire_registre&action=110&idx=0\" />",
                __("Déclencher le traitement"),
                addslashes(sprintf(
                    "<b>%s</b><br/><br/>%s",
                    __("Important à lire avant de confirmer le message de validation."),
                    __("Ce traitement n'est pas réversible.")
                )),
                OM_ROUTE_FORM
            );
            echo "\t</div>\n";
            // Fermeture du fomulaire
            echo "\t</form>\n";
        }
    }

    /**
     * Vérifie si un évenement existe à l'aide d'une requête sql.
     * Si des résultats sont récupérés c'est que l'événement existe.
     * Renvoie false si l'événement n'existe pas où si aucun identifiant
     * d'événement n'a été passé en paramètre.
     *
     * @param integer identifiant de l'évenement dont on cherche à vérifier
     * l'existence
     * @return boolean
     */
    protected function evenement_exist($evenement) {
        // Cas où l'identifiant de l'évènement n'a pas été passé en paramètre
        if (empty($evenement)) {
            return false;
        }
        // Vérification de l'existance de l'événement
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    count(*)
                FROM
                    %1$sevenement
                WHERE
                    evenement = %2$d',
                DB_PREFIXE,
                intval($evenement)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Si il y a au moins 1 résultat c'est que l'événement existe
        return $qres['result'] !== '0';
    }


    /**
     * VIEW - view_generate_affichage_reglementaire_registre
     *
     * Génère et affiche l'édition PDF registre d'affichage
     * réglementaire.
     *
     * @return void
     */
    function view_generate_affichage_reglementaire_registre() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Génération du PDF
        $result = $this->compute_pdf_output('etat', 'registre_dossiers_affichage_reglementaire', null, $this->getVal($this->clePrimaire));
        // Affichage du PDF
        $this->expose_pdf_output(
            $result['pdf_output'], 
            $result['filename']
        );
    }

    /**
     * VIEW - view_reglementaire_attestation
     *
     * Affiche un formulaire pour génèrer l'attestation d'affichage
     * réglementaire.
     *
     * @return void
     */
    function view_reglementaire_attestation() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        /**
         * Gestion des erreurs : vérification du paramétrage
         */
        $erreur = false;
        // Récupération de l'événement correspondant à l'instruction à insérer pour chaque dossier du registre
        $aff_obli = $this->f->getParameter('id_affichage_obligatoire');
        // Si le paramétrage est vide ou pas numérique
        if ($aff_obli == "" or !is_numeric($aff_obli)) {
            $erreur = true;
        } else {
            // Si pas de correspondance d'événement dans la base
            if ($this->evenement_exist($aff_obli) != true) {
                $error = true;
            }
        }
        // Affichage d'un message si en erreur
        if ($erreur == true) {
            // Affichage de l'erreur et sortie de la vue
            $this->f->displayMessage("error", _("Erreur de parametrage. Contactez votre administrateur."));
            return;
        }

        /**
         * Validation du formulaire
         */
        // Si le formulaire a été validé
        if ($this->f->get_submitted_post_value("dossier") !== null) {
            // Si une valeur a été saisie dans le champs dossier
            if ($this->f->get_submitted_post_value("dossier") != "") {
                // On récupère la valeur postée : 
                // - on l'échappe pour la base de données
                // - on supprime les espaces pour faciliter la saisie
                // - on le positionne en minuscule pour être sûr de la correspondance
                $posted_dossier = $this->f->db->escapesimple(strtolower(str_replace(' ', '', $this->f->get_submitted_post_value("dossier"))));
                // Récupération des informations sur le dossier et l'étape d'instruction
                $qres = $this->f->get_all_results_from_db_query(
                    sprintf(
                        'SELECT 
                            dossier.dossier,
                            instruction.instruction,
                            instruction.lettretype,
                            instruction.om_final_instruction,
                            instruction.om_fichier_instruction 
                        FROM
                            %1$sdossier
                            LEFT JOIN %1$sinstruction
                                ON dossier.dossier = instruction.dossier
                                    AND instruction.evenement = %2$d
                        WHERE 
                            LOWER(dossier.dossier) = \'%3$s\'',
                        DB_PREFIXE,
                        intval($this->f->getParameter('id_affichage_obligatoire')),
                        $this->f->db->escapeSimple($posted_dossier)
                    ),
                    array(
                        'origin' => __METHOD__
                    )
                );
                $row = array_shift($qres['result']);
                // Si il y a un dossier et une étape d'instrcution correspondante à
                // l'événement affichage obligatoire et que l'instruction est bien finalisée
                if ($qres['row_count'] !== 0
                    && $row["instruction"] != ""
                    && isset($row['om_fichier_instruction'])
                    && isset($row['om_final_instruction'])
                    && $row['om_fichier_instruction'] != ''
                    && $row['om_final_instruction'] == 't') {
                    //
                    $message_class = "valid";
                    $message = _("Cliquez sur le lien ci-dessous pour telecharger votre attestation d'affichage");
                    $message .= " : <br/><br/>";
                    $message .= "<a class='om-prev-icon pdf-16'";
                    $message .= " title=\""._("Attestation d'affichage")."\"";
                    $message .= " href='../app/index.php?module=form&snippet=file&obj=instruction&amp;"
                            ."champ=om_fichier_instruction&amp;id=".$row['instruction']."'";
                    $message .= " target='_blank'>";
                    $message .= _("Attestation d'affichage");
                    $message .= "</a>";
                } elseif ($qres['row_count'] != 0
                    && $row["instruction"] != ""
                    && isset($row['om_fichier_instruction'])
                    && isset($row['om_final_instruction'])
                    && $row['om_fichier_instruction'] != ''
                    && $row['om_final_instruction'] == 'f') {
                    // Si l'instruction n'est pas finalisée on indique à l'utilisateur que l'édition n'est pas possible
                    $message_class = "error";
                    $message = _("L'attestation de ce dossier existe mais n'est pas finalisée.");
                } elseif ($qres['row_count'] != 0 && $row["instruction"] == "") {
                    // Si aucune instruction avec l'événement affichage obligatoire n'a
                    // été trouvée
                    $message_class = "error";
                    $message = _("Ce dossier n'a jamais ete affiche.");
                } else {
                    // Si aucun dossier n'est trouvé
                    $message_class = "error";
                    $message = _("Ce dossier n'existe pas.");
                }
            } else {
                // Si aucune valeur n'a été saisie dans le champs dossier
                $message_class = "error";
                $message = _("Veuiller saisir un No de dossier.");
            }
        } 

        /**
         * Affichage des messages et du formulaire
         */
        // Affichage de la description de l'écran
        $this->f->displayDescription(_("Cet ecran permet d'imprimer l'attestation d'affichage ".
                                 "reglementaire d'un dossier d'instruction. Il suffit de ".
                                 "saisir le numero du dossier d'instruction puis de ".
                                 "valider pour obtenir le lien de telechargement de ".
                                 "l'attestation permettant de l'imprimer."));
        // Affichage du message de validation ou d'erreur
        if (isset($message) && isset($message_class) && $message != "") {
            $this->f->displayMessage($message_class, $message);
        }
        // Ouverture du formulaire
        echo "\t<form";
        echo " method=\"post\"";
        echo " id=\"affichage_reglementaire_attestation_form\"";
        echo " action=\"\"";
        echo ">\n";
        // Paramétrage des champs du formulaire
        $champs = array("dossier");
        // Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        // Paramétrage des champs du formulaire
        $form->setLib("dossier", _("No de dossier"));
        $form->setType("dossier", "text");
        $form->setTaille("dossier", 25);
        $form->setMax("dossier", 25);
        // Affichage du formulaire
        $form->entete();
        $form->afficher($champs, 0, false, false);
        $form->enpied();
        // Affichage du bouton
        echo "\t<div class=\"formControls\">\n";
        $this->f->layout->display_form_button(array("value" => _("Valider")));
        echo "\t</div>\n";
        // Fermeture du fomulaire
        echo "\t</form>\n";
    }


    /**
     * VIEW - view_get_adresse_by_cadastre
     * 
     * Permet de récupérer l'adresse de la première référence cadastrale via le sig.
     *
     * @return void
     */
    public function view_get_adresse_by_cadastre() {
        //
        $this->f->disableLog();
        $refcads = "";
        // Récupération des références cadastrales passées en paramètre
        if ($this->f->get_submitted_post_value("refcad") != null) {
            $refcads = $this->f->get_submitted_post_value("refcad");
        }
        // Si ce n'est pas un tableau de références
        if (is_array($refcads) === false){
            printf(json_encode(_("Aucune reference cadastrale fournie")));
            return;
        }
        // TODO : Ajouter les tests
        // XXX
        // Pour les utilisateur mono, il faut récupérer la session mais s'il s'agit d'un
        // utilisateur commnauté, il faut récupérer la valeur du champ om_collectivite
        // et vérifier que celui-ci n'est pas vide sinon afficher un message d'erreur
        $collectivite_idx = $_SESSION["collectivite"];
        if ($this->f->get_submitted_post_value("om_collectivite") != null) {
            $collectivite_idx = $this->f->get_submitted_post_value("om_collectivite");
        }
        $collectivite_param = $this->f->getCollectivite($collectivite_idx);
        // Si le paramètre option_sig de la commune n'a pas la valeur 'sig_externe', on
        // affiche une erreur.
        if ($collectivite_param['option_sig'] != 'sig_externe') {
            printf(json_encode(_("La localisation SIG n'est pas activee pour cette commune.")));
            return;
        }

        $wParcelle = "";
        //Formatage des références cadastrales pour l'envoi
        foreach ($refcads as $refcad) {
            //Pour chaque ligne
            foreach ($refcad as $value) {
                //On ajoute les données dans le tableau que si quartier + section + parcelle
                //a été fourni
                if ($value["quartier"] !== "" && $value["section"] !== "" &&
                    $value["parcelle"] !== "") {
                    //
                    $wParcelle .= $value["quartier"].$value["section"].$value["parcelle"];
                    //Si on a des délimiteurs
                    if (isset($value["delimit"][0])) {
                        
                        //Pour chaque délimiteur
                        for($i = 0; $i < count($value["delimit"][0]); $i++) {
                            //
                            $wParcelle .= $value["delimit"][0][$i];
                        }
                    }
                    // Séparateur
                    $wParcelle .= ";";
                }
            }
        }

        //
        $extra_params = array(
            "inst_framework" => $this->f,
        );
        if ($this->f->is_option_dossier_commune_enabled() === true
            && $this->f->get_submitted_post_value("commune") != null) {
            //
            $extra_params['commune_idx'] = $this->f->get_submitted_post_value("commune");
        }

        try {
            $geoads = new geoads($collectivite_param, $extra_params);
        } catch (geoads_exception $e) {
            printf(json_encode($e->getMessage()));
            return;
        }
        // XXX
        // Pour les utilisateur mono, il faut récupérer la session mais s'il s'agit d'un
        // utilisateur commnauté, il faut récupérer la valeur du champ om_collectivite
        // et vérifier que celui-ci n'est pas vide sinon afficher un message d'erreur
        // Formatage des parcelles pour l'envoi au webservice
        $liste_parcelles = $this->f->parseParcelles($wParcelle, $collectivite_idx);
        try {
            //On lance la requête SOAP
            $execute = $geoads->verif_parcelle($liste_parcelles);
        } catch (geoads_exception $e) {
            printf(json_encode($e->getMessage()));
            return;
        }

        // Vérifie l'existence de la 1ere parcelles
        if (!isset($execute[0]) or $execute[0]['existe'] != true) {
            printf(json_encode(_("Aucune adresse ne correspond a la reference cadastrale fournie")));
            return;
        }

        $response['return_addr'] = array();
        // Si plusieurs parcelles sont retournées on n'utilise que la première pour
        // récupérer l'adresse
        $adresse_ws = '';
        if (isset($execute[0]) && is_array($execute[0])) {
            $adresse_ws = $execute[0];
        }
        //Récupération du nom de la collectivité
        if ($this->f->is_option_dossier_commune_enabled() === true
            && $this->f->get_submitted_post_value("commune") != null) {
            //
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        ncc
                    FROM
                        %1$scommune
                    WHERE
                        commune = %2$d',
                    DB_PREFIXE,
                    intval($this->f->get_submitted_post_value("commune"))
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($qres["code"] !== "OK") {
                $this->f->addToLog(
                    __METHOD__."() : ERROR - ".__("Impossible de récupérer le nom de la commune."),
                    DEBUG_MODE
                );
                return;
            }
        } else {
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        UPPER(valeur)
                    FROM
                        %1$som_parametre
                    WHERE
                        libelle = \'ville\'
                        AND om_collectivite = %2$d',
                    DB_PREFIXE,
                    intval($collectivite_idx)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
        }

        $response["return_addr"]["localite"] = $qres["result"];

        // Formate le code postal
        $code_postal = '';
        // On vérifie que l'arrondissement retourné est bien une valeur 
        // cohérente avant d'essayer de récupérer son code postal en base de 
        // données
        if (isset($adresse_ws["adresse"]['arrondissement']) === true
            && $adresse_ws["adresse"]['arrondissement'] != ""
            && is_numeric($adresse_ws["adresse"]['arrondissement']) === true) {
            // Récupération de l'instance de l'arrondissement afin d'accéder au code postal
            $inst_arrondissement = $this->f->get_inst__om_dbform(array(
                "obj" => "arrondissement",
                "idx" => intval($adresse_ws["adresse"]['arrondissement']),
            ));
            $code_postal = $inst_arrondissement->getVal('code_postal');
        } else {
            if ($this->f->is_option_dossier_commune_enabled() === true
                && $this->f->get_submitted_post_value("commune") != null) {
                //
                $code_postal = '';
            } else {
                //Récupération du code postal
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            valeur
                        FROM
                            %1$som_parametre
                        WHERE
                            libelle = \'cp\'
                            AND om_collectivite = %2$d',
                        DB_PREFIXE,
                        intval($collectivite_idx)
                    ),
                    array(
                        "origin" => __METHOD__,
                    )
                );
                $code_postal = $qres["result"];
            }
        }

        $response['return_addr']['code_postal'] = $code_postal;
        
        // On coupe les chaînes retournées afin que leurs tailles
        // correspondent aux tailles des champs en base de données
        if (isset($adresse_ws["adresse"]['numero_voie']) === true
            && $adresse_ws["adresse"]['numero_voie'] !== '') {
            $response['return_addr']['numero_voie'] = substr($adresse_ws["adresse"]['numero_voie'], 0, 20);
        }
        // cas où le type de voie n'est pas fourni par le SIG
        if (isset($adresse_ws["adresse"]['nom_voie']) === true
            && $adresse_ws["adresse"]['nom_voie'] !== '') {
            $response['return_addr']['nom_voie'] = substr(
                $adresse_ws["adresse"]['nom_voie'],
                0,
                30
            );
        }
        // cas où le type de voie est fourni
        if (isset($adresse_ws["adresse"]['type_voie'])
            AND $adresse_ws["adresse"]['type_voie'] !== ''
            AND $adresse_ws["adresse"]['nom_voie'] !== '') {
            $response['return_addr']['nom_voie'] = substr(
                $adresse_ws["adresse"]['type_voie']." ".$adresse_ws["adresse"]['nom_voie'],
                0,
                30
            );
        }
        //
        printf(json_encode($response));
        return;
    }

    function setValF($val = array()) {

        if (! $this->f->is_option_dossier_commune_enabled()) {
            // ajoute une "fausse" clé 'commune' dans le tableau des données envoyées
            // car la fonction 'setValF()' dans 'gen/obj/demande.class.php'
            // déclenche une erreur 'Undefined index: commune' sinon
            $val['commune'] = null;
            // idem pour cette valeur qui est passée au dossier d'instruction
            $this->valF['commune'] = null;
        }

        parent::setValF($val);

        // Récupération des id demandeurs postés
        $this->getPostedValues();
        //$this->valIdDemandeur=$this->postedIdDemandeur;

        //
        $this->valF['source_depot'] = is_null($val['source_depot']) === true || $val['source_depot'] === '' ? 'app' : $val['source_depot'];

        // On retraite le texte saisie pour jointure en BDD.
        // Traitement identique à celui effectué en JavaScript
        // dans la fonction lookingForAutorisationContestee().
        if ($this->valF['autorisation_contestee'] !== NULL) {
            $val = trim($this->valF['autorisation_contestee']);
            $this->valF['autorisation_contestee'] = preg_replace(
                '/\s+/',
                '',
                $val
            );
        }
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_infos_dossier() {
        return "SELECT
        dossier_autorisation.dossier_autorisation,
        dossier_autorisation.dossier_autorisation_type_detaille,
        dossier_autorisation.depot_initial,
        dossier_autorisation.terrain_references_cadastrales,
        dossier_autorisation.terrain_adresse_voie_numero,
        dossier_autorisation.terrain_adresse_voie,
        dossier_autorisation.terrain_adresse_lieu_dit,
        dossier_autorisation.terrain_adresse_localite,
        dossier_autorisation.terrain_adresse_code_postal,
        dossier_autorisation.terrain_adresse_bp,
        dossier_autorisation.terrain_adresse_cedex,
        dossier_autorisation.terrain_superficie,
        etat.libelle as etat,
        dossier_autorisation.commune
        FROM ".DB_PREFIXE."dossier_autorisation
        INNER JOIN ".DB_PREFIXE."dossier
            ON dossier_autorisation.dossier_autorisation=dossier.dossier_autorisation
            LEFT JOIN ".DB_PREFIXE."etat
    ON dossier.etat = etat.etat
        WHERE dossier = '<idx>'";
    }

    /**
     * Méthode permettant de récupérer les valeurs du dossier d'autorisation
     * correspondant à la nouvelle demande
     */
    function getValFromDossier($dossier_autorisation) {
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                str_replace(
                    "<idx>",
                    $this->f->db->escapeSimple($this->getParameter("idx_dossier")),
                    $this->get_var_sql_forminc__sql("infos_dossier")
                ),
                DB_PREFIXE
            ),
            array(
                'origin' => __METHOD__
            )
        );
        $row = array_shift($qres['result']);
        return $row;
    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        // Sur le formulaire de modification, depot_electronique
        // n'est pas modifiable et affiche Oui/Non.
        if ($maj == 1) {
            if ($this->getVal('depot_electronique') === 't'
                || $this->getVal('depot_electronique') === true
                || $this->getVal('depot_electronique') === 1) {
                //
                $form->setVal('depot_electronique', "Oui");
            } else {
                $form->setVal('depot_electronique', "Non");
            }
        }
        //
        if ($maj == 0) {
            // Définition de la date de dépôt par défaut
            // La date du jour par défaut dans le champs date_demande
            if ($this->f->getParameter('option_date_depot_demande_defaut') !== 'false') {
                $form->setVal("date_demande", date('d/m/Y'));
            }

            $form->setVal("etat_transmission_platau", "non_transmissible");

            // Récupération des valeurs du dossier d'autorisation correspondant
            if ($this->getParameter("idx_dossier") != "") {
                $val_autorisation = $this->getValFromDossier($this->getParameter("idx_dossier"));
                foreach ($val_autorisation as $champ => $value) {
                    $form->setVal($champ, $value);
                }
            }
        }
    }

    function getDataSubmit() {

        $datasubmit = parent::getDataSubmit();
        if($this->getParameter("idx_dossier") != "") {
            $datasubmit .= "&idx_dossier=".$this->getParameter("idx_dossier");
        }
        return $datasubmit;
    }
    
    /**
     * Retourne le type de formulaire : ADS, CTX RE, CTX IN ou DPC.
     *
     * @return,  string Type de formulaire.
     */
    function get_type_affichage_formulaire() {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation_type.affichage_form
                FROM
                    %1$sdemande_type
                    INNER JOIN %1$sdossier_autorisation_type_detaille
                        ON demande_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    INNER JOIN %1$sdossier_autorisation_type
                        ON dossier_autorisation_type.dossier_autorisation_type = dossier_autorisation_type_detaille.dossier_autorisation_type
                WHERE
                    demande_type.demande_type = %2$d',
                DB_PREFIXE,
                intval($this->valF["demande_type"])
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
     * (Surcharge) Effectue des vérifications avant mise à jour des données
     * issues d'un formulaire d'ajout ou de modification.
     *
     * Les vérifications réalisées dans cette méthode sont :
     *  1 - Vérifie si la date de demande est supérieure à la date du jour.
     *      Si elle est supérieure à la date du jour, empêche la validation du formulaire et
     *      averti l'utilisateur que son paramétrage n'est pas correct
     *
     *  2 - Selon le type de formulaire affiché vérifie si un pétitionnaire, un contrevenant
     *      ou un bailleur principal a bien été saisie.
     *      Si ce n'est pas le cas empêche la validation du formulaire et averti l'utilisateur
     *      que la saisie d'un pétitionnaire ou autre principal est obligatoire.
     *
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);

        // Vérification 1
        // Vérifie si la date de demande existe avant de la tester
        if (isset($val["date_demande"]) && $val["date_demande"] != null && $val["date_demande"] != '') {
            //
            $date_demande = $val["date_demande"];
            if (preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/', $val["date_demande"], $d_match)) {
                $date_demande = $d_match[3].'-'.$d_match[2].'-'.$d_match[1];
            }
            $date_demande = DateTime::createFromFormat('Y-m-d', $date_demande);
            $aujourdhui = new DateTime();
            // Renvoie une exception si la date de date de demande n'est pas un DateTime
            try {
                if (! $date_demande instanceof DateTime) {
                    throw new RuntimeException("Not a DateTime");
                }
                // Si la date issus du formulaire n'a pas pu être converti, date_demande vaudra
                // false. Avant de comparer on vérifie donc que la date a bien été récupérée
                if ($date_demande > $aujourdhui) {
                    $this->addToMessage(_("La date de demande ne peut pas être superieure à la date du jour."));
                    $this->correct = false;
                }
            } catch (RuntimeException $e) {
                $this->correct = false;
                $this->addToLog($e.' : '._("Le format de la date de demande n'est pas valide."));
                $this->addToMessage(_("Erreur : le format de la date de demande n'est pas correct. Contactez votre administrateur."));
            }
        }

        // Vérification 2
        // Récupère le type de formulaire affiché. A partir de cette information vérifie
        // selon le type de formulaire si les infos voulues sont bien saisies.
        $type_aff_form = $this->get_type_affichage_formulaire();
        if ($type_aff_form ===false) {
            $this->correct = false;
            $this->addToMessage(_("Une erreur s'est produite lors de l'ajout de ce dossier. Veuillez contacter votre administrateur."));
        }
        switch ($type_aff_form) {
            case 'ADS':
            case 'CTX RE':
            case 'CONSULTATION ENTRANTE':
                if(!isset($this->postedIdDemandeur["petitionnaire_principal"]) OR
                    empty($this->postedIdDemandeur["petitionnaire_principal"]) AND
                    !is_null($this->form)) {
                    $this->correct = false;
                    $this->addToMessage(_("La saisie d'un petitionnaire principal est obligatoire."));
                }
                break;
            case 'CTX IN':
                if(!isset($this->postedIdDemandeur["contrevenant_principal"]) OR
                    empty($this->postedIdDemandeur["contrevenant_principal"]) AND
                    !is_null($this->form)) {
                    $this->correct = false;
                    $this->addToMessage(_("La saisie d'un contrevenant principal est obligatoire."));
                }
                break;
            case 'DPC':
                if(!isset($this->postedIdDemandeur["petitionnaire_principal"]) OR
                    empty($this->postedIdDemandeur["petitionnaire_principal"]) AND
                    !is_null($this->form)) {
                    $this->correct = false;
                    $this->addToMessage(_("La saisie d'un petitionnaire principal est obligatoire."));
                }
                if(!isset($this->postedIdDemandeur["bailleur_principal"]) OR
                    empty($this->postedIdDemandeur["bailleur_principal"]) AND
                    !is_null($this->form)) {
                    $this->correct = false;
                    $this->addToMessage(_("La saisie d'un bailleur principal est obligatoire."));
                }
                break;
        }
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_demande_type_details_by_id() {
        return "SELECT demande_type.demande_type, demande_type.libelle, demande_type.dossier_autorisation_type_detaille, demande_type. dossier_instruction_type FROM ".DB_PREFIXE."demande_type WHERE demande_type = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_lien_demande_demandeur() {
        return "SELECT petitionnaire_principal, demandeur, demande FROM ".DB_PREFIXE."lien_demande_demandeur WHERE demande = <demande>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement ORDER BY NULLIF(arrondissement.libelle,'')::int ASC NULLS LAST";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_dossier_autorisation_type_detaille() {
        return "SELECT
  dossier_autorisation_type_detaille.dossier_autorisation_type_detaille,
  dossier_autorisation_type_detaille.libelle
FROM ".DB_PREFIXE."dossier_autorisation_type_detaille
LEFT JOIN ".DB_PREFIXE."dossier_autorisation_type
    ON dossier_autorisation_type_detaille.dossier_autorisation_type=dossier_autorisation_type.dossier_autorisation_type
LEFT JOIN ".DB_PREFIXE."groupe
    ON dossier_autorisation_type.groupe=groupe.groupe
LEFT JOIN ".DB_PREFIXE."cerfa ON dossier_autorisation_type_detaille.cerfa = cerfa.cerfa
WHERE ((now()<=om_validite_fin AND now()>=om_validite_debut) OR
    dossier_autorisation_type_detaille.cerfa IS NULL OR
    (om_validite_fin IS NULL and om_validite_debut IS NULL) OR
    (now()<=om_validite_fin and om_validite_debut IS NULL) OR
    (om_validite_fin IS NULL AND now()>=om_validite_debut))
    <ajout_condition_requete>
ORDER BY dossier_autorisation_type_detaille.libelle ASC";
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        //parent::setSelect($form, $maj);
        // Méthode de récupération des valeurs du select "demande_type"
        if ($maj < 2
            && (($this->f->get_submitted_get_value('obj') !== null && $this->f->get_submitted_get_value('obj') != "demande")
                OR ($this->f->get_submitted_get_value('obj') === null))) {
            // demande_type
            $form->setSelect(
                'demande_type',
                $this->loadSelectDemandeType($form, $maj, "dossier_autorisation_type_detaille")
            );
        } else {
            // demande_type
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "demande_type",
                $this->get_var_sql_forminc__sql("demande_type"),
                $this->get_var_sql_forminc__sql("demande_type_by_id"),
                false
            );
        }
        // arrondissement
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "arrondissement",
            $this->get_var_sql_forminc__sql("arrondissement"),
            $this->get_var_sql_forminc__sql("arrondissement_by_id"),
            false
        );
        // Filtre des demandes par groupes
        $group_clause = array();
        $ajout_condition_requete = "";
        foreach ($_SESSION["groupe"] as $key => $value) {
            if($value["enregistrement_demande"] !== true) {
                continue;
            }
            $group_clause[$key] = "(groupe.code = '".$key."'";
            if($value["confidentiel"] !== true) {
                $group_clause[$key] .= " AND dossier_autorisation_type.confidentiel IS NOT TRUE";
            }
            $group_clause[$key] .= ")";
        }
        // Mise en chaîne des clauses
        $conditions = implode(" OR ", $group_clause);
        if($conditions !== "") {
            $ajout_condition_requete .= " AND (".$conditions.")";
        }
        // Les clauses sont une white list. Cela qui signifie que l'on
        // rajoute une condition irréalisable si absence de clause.
        if ($ajout_condition_requete === '') {
            $ajout_condition_requete = 'AND false';
        }
        $sql_dossier_autorisation_type_detaille = str_replace(
            '<ajout_condition_requete>',
            $ajout_condition_requete,
            $this->get_var_sql_forminc__sql("dossier_autorisation_type_detaille")
        );
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "dossier_autorisation_type_detaille",
            $sql_dossier_autorisation_type_detaille,
            $this->get_var_sql_forminc__sql("dossier_autorisation_type_detaille_by_id"),
            false
        );
        // om_collectivite
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "om_collectivite",
            $this->get_var_sql_forminc__sql("om_collectivite"),
            $this->get_var_sql_forminc__sql("om_collectivite_by_id"),
            false
        );
        // commune
        $this->init_select(
            $form,
            $this->f->db,
            $maj,
            null,
            "commune",
            $this->get_var_sql_forminc__sql("commune"),
            $this->get_var_sql_forminc__sql("commune_by_id"),
            false
        );


        $contenu = array();
        foreach(self::SOURCE_DEPOT as $key) {
            $const_name = $key;
            $const_value = $key;
            $contenu[0][] = $const_value;
            $contenu[1][] = __($const_value);
        }

        $form->setSelect("source_depot", $contenu);
    }

    /**
     * Charge le select du champ type de demande
     * @param  object $form  Formulaire
     * @param  int    $maj   Mode d'insertion
     * @param  string $champ champ activant le filtre
     * @return array         Contenu du select
     */
    function loadSelectDemandeType(&$form, $maj, $champ) {

        // Contenu de la liste à choix
        $contenu=array();
        $contenu[0][0]='';
        $contenu[1][0]=_('choisir')."&nbsp;"._("demande_type");

        //Récupère l'id du type de dossier d'autorisation détaillé 
        $id_dossier_autorisation_type_detaille = "";
        if ($this->f->get_submitted_post_value($champ) !== null) {
            $id_dossier_autorisation_type_detaille = $this->f->get_submitted_post_value($champ);
        } elseif($this->getParameter($champ) != "") {
            $id_dossier_autorisation_type_detaille = $this->getParameter($champ);
        } elseif(isset($form->val[$champ])) {
            $id_dossier_autorisation_type_detaille = $form->val[$champ];
        }
        //
        if ($id_dossier_autorisation_type_detaille === '') {
            return $contenu;
        }

        // Récupération de paramètre pour le rechargement ajax du select
        $idx_dossier = $this->getParameter("idx_dossier");

        // Récupère l'id de la nature de la demande
        $id_demande_nature = "1";
        if (isset($idx_dossier) AND $idx_dossier != "") {
            $id_demande_nature = '2';
        }

        // Requête récupération type demande pour les nouveaux DA
        $sql = sprintf('
            SELECT
                demande_type.demande_type,
                demande_type.libelle as lib
            FROM
                %1$sdemande_type
                INNER JOIN %1$sdossier_autorisation_type_detaille
                    ON demande_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
                    AND dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = %2$s
                LEFT JOIN %1$sdossier_instruction_type
                    ON dossier_instruction_type.dossier_instruction_type = demande_type.dossier_instruction_type
                WHERE
                    (demande_type.demande_nature = %3$s %4$s)
                    AND demande_type.dossier_instruction_type IS NOT NULL
                    AND dossier_instruction_type.sous_dossier IS NOT TRUE
                ORDER BY
                    demande_type.libelle, demande_type.demande_type
            ',
            DB_PREFIXE,
            intval($id_dossier_autorisation_type_detaille),
            intval($id_demande_nature),
            // Affiche à la fois les types de demande NOUV et EXIST si option numéro complet activée
            $this->f->is_option_dossier_saisie_numero_complet_enabled() === true ? sprintf(' OR demande_type.demande_nature = %s ', 2) : ''
        );
        // Requêtes de récupération des types de demande pour les DA existants
        if ($id_demande_nature == '2') {
            // Récupère la liste des types de demande possibles
            $sql = $this->get_query_demande_type_by_dossier($idx_dossier, $id_demande_nature);
        }
        $qres = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                'origin' => __METHOD__,
                'mode' => DB_FETCHMODE_ORDERED
            )
        );
        //Les résultats de la requête sont stocké dans le tableau contenu
        $k=1;
        foreach ($qres['result'] as $row) {
            $contenu[0][$k] = $row[0];
            $contenu[1][$k] = $row[1];
            $k++;
        }

        // Retourne le contenu de la liste
        return $contenu;
    }

    /**
     * [get_query_demande_type_by_dossier description]
     * @param  [type]  $idx_dossier                     [description]
     * @param  [type]  $id_demande_nature               [description]
     * @param  integer $etat_da_accord                  [description]
     * @param  integer $etat_da_encours                 [description]
     * @param  integer $autorite_competente_sitadel_com [description]
     * @return [type]                                   [description]
     */
    public function get_query_demande_type_by_dossier($idx_dossier, $id_demande_nature = 2, $etat_da_accord = 2, $etat_da_encours = 1, $autorite_competente_sitadel_com = 1) {
        // Unification de trois résultats de réquête pour récupèrer les
        // types de demande possibles :
        // - les types de demande qui ne créé pas de nouveau DI et dont
        //  l'état du DI ciblé fait partie des états autorisés,
        // - les types de demande qui créé de nouveau DI, dont l'état du DI
        //  ciblé fait partie des états autorisés et dont le DA du DI ciblé
        //  est accordé,
        // - les types de demande qui créé de nouveau DI, dont les types
        //  de(s) DI en cours sur le DA ciblé accordé, sont identique(s) à
        //  la liste des types de DI compatibles,
        // - les types de demande qui créé de nouveau DI, dont les types
        // de(s) DI en cours sur le DA ciblé en cours d'instruction sont
        // identique(s) à la liste des types de DI compatibles et dont le
        // DI initial n'est pas de compétence SITADEL "au nom de la commune".
        return sprintf('
            SELECT DISTINCT demande_type.demande_type as dt, demande_type.libelle as lib, demande_type.code as code
            FROM %1$sdemande_type
            INNER JOIN %1$sdossier_autorisation_type_detaille
                ON demande_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            INNER JOIN %1$slien_demande_type_etat
                ON lien_demande_type_etat.demande_type = demande_type.demande_type
            INNER JOIN %1$setat
                ON lien_demande_type_etat.etat = etat.etat
            INNER JOIN %1$sdossier
                ON dossier.dossier = \'%2$s\'
                AND etat.etat = dossier.etat
            INNER JOIN %1$sdossier_autorisation
                ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
                AND dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_autorisation.dossier_autorisation_type_detaille
            WHERE demande_type.dossier_instruction_type IS NULL
            AND demande_type.demande_nature = %3$s
            UNION
            SELECT demande_type.demande_type as dt, demande_type.libelle as lib, demande_type.code as code
            FROM %1$sdemande_type
            INNER JOIN %1$sdossier_instruction_type
                ON demande_type.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
            INNER JOIN %1$sdossier_autorisation_type_detaille
                ON demande_type.dossier_autorisation_type_detaille = dossier_autorisation_type_detaille.dossier_autorisation_type_detaille
            INNER JOIN %1$slien_demande_type_etat
                ON lien_demande_type_etat.demande_type = demande_type.demande_type
            INNER JOIN %1$setat
                ON lien_demande_type_etat.etat = etat.etat
            INNER JOIN %1$sdossier
                ON dossier.dossier = \'%2$s\'
                AND etat.etat = dossier.etat
            INNER JOIN %1$sdossier_autorisation as da
                ON da.dossier_autorisation = dossier.dossier_autorisation
                AND dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = da.dossier_autorisation_type_detaille
            WHERE demande_type.dossier_instruction_type IS NOT NULL
            AND dossier_instruction_type.sous_dossier IS NOT TRUE
            AND demande_type.demande_nature = %3$s
            AND da.etat_dossier_autorisation = %4$s
            AND (
                SELECT count(dossier)
                FROM %1$sdossier
                INNER JOIN %1$sdossier_autorisation
                    ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                    AND dossier_autorisation.dossier_autorisation = da.dossier_autorisation
                INNER JOIN %1$setat
                    ON dossier.etat = etat.etat
                    AND etat.statut = \'encours\'
            ) = 0
            UNION
            SELECT demande_type.demande_type as dt, demande_type.libelle as lib, demande_type.code as code
            FROM %1$sdemande_type
            INNER JOIN %1$sdossier_instruction_type
                ON demande_type.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
            INNER JOIN %1$sdossier
                ON dossier.dossier = \'%2$s\'
            INNER JOIN %1$sdossier_autorisation as da
                ON da.dossier_autorisation = dossier.dossier_autorisation
            INNER JOIN %1$sautorite_competente
                ON autorite_competente.autorite_competente = dossier.autorite_competente
            WHERE demande_type.dossier_instruction_type IS NOT NULL
            AND dossier_instruction_type.sous_dossier IS NOT TRUE
            AND (
                SELECT array_agg(DISTINCT(dossier_instruction_type))
                FROM %1$sdossier
                INNER JOIN %1$sdossier_autorisation
                    ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                    AND dossier_autorisation.dossier_autorisation = da.dossier_autorisation
                INNER JOIN %1$setat
                    ON dossier.etat = etat.etat
                    AND etat.statut = \'encours\'
            ) <@ (
                SELECT array_agg(DISTINCT(dossier_instruction_type))
                FROM %1$slien_demande_type_dossier_instruction_type
                WHERE lien_demande_type_dossier_instruction_type.demande_type = demande_type.demande_type
            )
            AND demande_type.demande_nature = %3$s
            AND (
                da.etat_dossier_autorisation = %4$s
            OR (
                da.etat_dossier_autorisation = %5$s
                AND autorite_competente.autorite_competente_sitadel != %6$s
            ))
            ORDER BY lib, dt
            ',
            DB_PREFIXE,
            $idx_dossier,
            intval($id_demande_nature),
            $etat_da_accord, // Identifiant de l'état de dossier d'autorisation : Accordé
            $etat_da_encours, // Identifiant de l'état de dossier d'autorisation : En cours
            $autorite_competente_sitadel_com // Identifiant de l'autorité compétente SITADEL : 1 - au nom de la commune
        );
    }

    /*
    * Ajout du fielset
    * Add fieldset
    */
    function setLayout(&$form, $maj){
        if ( $maj < 2) {

            // Type de dossier/demande
            $form->setBloc('om_collectivite','D',"","col_12 dossier_type");
                $form->setFieldset('om_collectivite','D'
                                       ,_('Type de dossier/demande'));
                $form->setFieldset('etat','F','');
            $form->setBloc('etat','F');

            // Autorisation contestée
            $form->setBloc('autorisation_contestee','D',"","col_12 demande_autorisation_contestee_hidden_bloc");
                $form->setFieldset('autorisation_contestee','D'
                                       ,_('Autorisation contestée'));
                $form->setFieldset('autorisation_contestee','F','');
            $form->setBloc('autorisation_contestee','F');

            // Date de la demande
            $form->setBloc('date_depot_mairie','D',"","col_4 demande_hidden_bloc");
                $form->setFieldset('date_depot_mairie','D',_('Date de la demande'));
                $form->setFieldset('date_demande','F','');
            $form->setBloc('date_demande','F');

            // En mode ajout et si l'option de saisie manuelle est activée
            if ($maj == 0
                && $this->f->is_option_dossier_saisie_numero_enabled() === true) {

                // Numéro de dossier
                $form->setBloc('num_doss_manuel','D',"","col_8 demande_hidden_bloc bloc_numero_dossier");
                $form->setBloc('num_doss_manuel','DF','', 'col_3 bloc_activ_num_manu saisie_manuelle');
                $form->setBloc('num_doss_type_da','D',"","col_8 bloc_num_manu");
                    $form->setFieldset('num_doss_type_da','D',__("Numéro de dossier"));
                        $form->setBloc('num_doss_type_da','DF','','type-da');
                        $form->setBloc('num_doss_code_depcom','DF','','depcom');
                        $form->setBloc('num_doss_annee','DF','','annee');
                        $form->setBloc('num_doss_division','DF','','division');
                        $form->setBloc('num_doss_sequence','DF','','sequence');
                    $form->setFieldset('num_doss_sequence','F');
                $form->setBloc('num_doss_sequence','F');
                $form->setBloc('num_doss_sequence','F');
            }

            // En mode ajout et si l'option de saisie manuelle est activée
            if ($maj == 0
                && $this->f->is_option_dossier_saisie_numero_complet_enabled() === true) {

                // Numéro de dossier
                $form->setBloc('num_doss_manuel','D',"","col_8 demande_hidden_bloc bloc_numero_complet_dossier");
                $form->setBloc('num_doss_manuel','DF','', 'col_3 bloc_activ_num_manu saisie_manuelle');
                $form->setBloc('num_doss_complet','D',"","col_8 bloc_num_manu");
                    $form->setFieldset('num_doss_complet','D',__("Numéro de dossier"));
                        $form->setBloc('num_doss_complet','DF','','complet');
                    $form->setFieldset('num_doss_complet','F');
                $form->setBloc('num_doss_complet','F');
                $form->setBloc('num_doss_complet','F');
            }

            // Localisation
            $form->setBloc('parcelle_temporaire','D',"",
                           "col_12 localisation demande_hidden_bloc");
                $form->setFieldset('parcelle_temporaire','D',_('Localisation'));
                $form->setFieldset('terrain_superficie','F','');
            $form->setBloc('terrain_superficie','F');

            // Demandeurs
            // → cf. formSpecificContent()
        }
        if ( $maj == 3 ) {
            $form->setBloc('om_collectivite','D',"","dossier_type col_12");
                $form->setBloc('om_collectivite','D',"","dossier_type col_8");
                    $form->setFieldset('om_collectivite','D'
                                       ,_('Type de dossier/demande'));
                    $form->setFieldset('dossier_autorisation','F','');
                $form->setBloc('dossier_autorisation','F');
                /*Fin bloc 1*/

                // Affichage de l'état du dossier d'instruction
                $form->setBloc('etat','D',"","col_4 demande_etat_hidden_bloc");
                    $form->setFieldset('etat','D',_('etat du dossier_instruction'));
                    $form->setFieldset('etat','F','');
                $form->setBloc('etat','F');
            $form->setBloc('etat','F');
            
            $form->setBloc('autorisation_contestee','DF',"","demande_autorisation_contestee_hidden_bloc");

            /*Champ sur lequel s'ouvre le bloc 2 */
            $form->setBloc('date_demande','D',"","col_4 demande_hidden_bloc");
                $form->setFieldset('date_demande','D',_('Date de la demande'));
                $form->setFieldset('date_demande','F','');
            $form->setBloc('date_demande','F');
            /*Fin bloc 2*/
            
            /*Champ sur lequel s'ouvre le bloc 3 */
            $form->setBloc('parcelle_temporaire','D',"",
                           "localisation col_12 demande_hidden_bloc");
                $form->setFieldset('parcelle_temporaire','D',_('Localisation'));
                $form->setFieldset('terrain_superficie','F','');
            $form->setBloc('terrain_superficie','F');
            /*Fin bloc 4*/
        }
    }

    /*
    * Ajoute des actions sur les deux premiers select
    * Add actions on the two first select
    */
    function setOnchange(&$form,$maj){
        parent::setOnchange($form,$maj);

        $form->setOnchange("dossier_autorisation_type_detaille","changeDemandeType();");
        $form->setOnchange("demande_type","manage_document_checklist(this);showFormDemande();");
    }
   
    function setLib(&$form,$maj) {
        parent::setLib($form,$maj);
        //libelle des champs
        $form->setLib('date_depot_mairie', __('Date de dépôt en mairie'));
        $form->setLib('terrain_adresse_voie',_('terrain_adresse'));
        $form->setLib('autorisation_contestee',_('numéro du dossier contesté').' '.$form->required_tag);
    }

    /*
    * Cache le champ terrain_references_cadastrales
    * Hide the fiels terrain_references_cadastrales
    */
    function setType(&$form,$maj) {
        parent::setType($form,$maj);
        
        $form->setType('dossier_instruction', 'hidden');
        $form->setType('source_depot', 'hidden');
        $form->setType('dossier_autorisation', 'hidden');
        $form->setType('autorisation_contestee', 'autorisation_contestee');

        $form->setType('instruction_recepisse', 'hidden');
        $form->setType('arrondissement', 'hidden');
        $form->setType('etat_transmission_platau', 'hidden');

        $form->setType('etat', 'hidden');

        if ($this->f->is_option_date_depot_mairie_enabled() === true){
            $form->setType('date_depot_mairie', "date");
        } else {
            $form->setType('date_depot_mairie', "hidden");
        }

        //Le paramètre "dépôt électronique" n'est pas modifiable manuellement 
        if ($maj == 0) {
            $form->setType('depot_electronique', 'hidden');
        }

        $form->setType("commune", "hidden");

        // Si il s'agit d'une demande sur dossier existant on desactive tous les champs
        // sauf demande_type
        if(($maj == 0 AND $this-> getParameter("idx_dossier"))) {
            $form->setType('dossier_autorisation_type_detaille', 'selecthiddenstatic');
            $form->setType('etat', 'hiddenstatic');
            $form->setType('terrain_references_cadastrales', 'hiddenstatic');
            $form->setType('terrain_adresse_voie_numero', 'hiddenstatic');
            $form->setType('terrain_adresse_voie', 'hiddenstatic');
            $form->setType('terrain_adresse_lieu_dit', 'hiddenstatic');
            $form->setType('terrain_adresse_localite', 'hiddenstatic');
            $form->setType('terrain_adresse_code_postal', 'hiddenstatic');
            $form->setType('terrain_adresse_bp', 'hiddenstatic');
            $form->setType('terrain_adresse_cedex', 'hiddenstatic');
            $form->setType('terrain_superficie', 'hiddenstatic');
        }
        if($maj == 1) {
            $form->setType('depot_electronique', 'hiddenstatic');
            $form->setType('dossier_autorisation_type_detaille', 'selecthiddenstatic');
            $form->setType('demande_type', 'selecthiddenstatic');
        }
        if($maj == 3) {
            $form->setType('terrain_references_cadastrales', 'referencescadastralesstatic');
        }

        if($maj == 1 || $maj == 3) {
            // Numéro de dossier
            // Cache les champs inutiles lors de la consultation et de l'affichage du récépissé
            $form->setType('num_doss_manuel', 'hidden');
            $form->setType('num_doss_type_da', 'hidden');
            $form->setType('num_doss_code_depcom', 'hidden');
            $form->setType('num_doss_annee', 'hidden');
            $form->setType('num_doss_division', 'hidden');
            $form->setType('num_doss_sequence', 'hidden');
            $form->setType('num_doss_complet', 'hidden');
        }

    }


    /**
     * Permet de recupérer l'identifiant du cerfa du DATD séléctionné
     * par l'utilisateur.
     *
     * @return integer identifiant du cerfa
     */
    function getIdCerfa() {
        if($this->cerfa != null) {
            return $this->cerfa;
        }
        // Récupération du cerfa pour le type d'instruction sélectionnée et valide
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation_type_detaille.cerfa
                FROM
                    %1$sdossier_autorisation_type_detaille
                    JOIN %1$scerfa
                        ON dossier_autorisation_type_detaille.cerfa = cerfa.cerfa
                WHERE
                    NOW() <= om_validite_fin
                    AND NOW() >= om_validite_debut
                    AND dossier_autorisation_type_detaille = %2$d',
                DB_PREFIXE,
                intval($this->valF['dossier_autorisation_type_detaille'])
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $this->cerfa = $qres["result"];

        return $this->cerfa;
    }


    /**
     * Méthode permettant d'ajouter un dossier d'autorisation.
     *
     * @param integer  $id    identifiant de la demande
     * @param array    $val   tableau de valeurs postées via le formulaire
     *
     * @return boolean false si erreur
     */
    function ajoutDossierAutorisation($id, $val) {
        $dossier_autorisation = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation",
            "idx" => "]",
        ));
        $id_etat_initial_da =
            $this->f->getParameter('id_etat_initial_dossier_autorisation');

        // Vérification de l'existance d'un état initial des DA dans la table
        // om_parametre afin d'éviter d'eventuelle erreur de base de données
        if(isset($id_etat_initial_da)) {
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        count(*)
                    FROM
                        %1$setat_dossier_autorisation
                    WHERE
                        etat_dossier_autorisation = %2$d',
                    DB_PREFIXE,
                    intval($id_etat_initial_da)
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($qres["code"] !== "OK") {
                return false;
            }

            if($qres["result"] != 1) {
                $this->f->addToLog(__METHOD__."() : ERROR - Plusieurs états de dossier d'autorisation ont cet identifiant.", DEBUG_MODE);

                return false;
            }

            // La méthode ajouter prend en paramètre un tableau associatif
            // contenant toutes les champs de la classe instanciée,
            // d'où l'initialisation du tableau en bouclant sur la liste des
            // champs du DA
            foreach($dossier_autorisation->champs as $value) {
                $valAuto[$value] = null;
            }


            // si l'option 'commune' n'est pas activée
            $insee = null;
            if ($this->f->is_option_dossier_commune_enabled($this->valF['om_collectivite']) === false) {

                // On récupère les paramètres de la collectivité concernée
                // par la demande.
                $collectivite_parameters = $this->f->getCollectivite($this->valF['om_collectivite']);

                // Le paramètre 'insee' est obligatoire si il n'est pas présent
                // dans le tableau des paramètres alors on stoppe le traitement.
                if (!isset($collectivite_parameters['insee'])) {
                    $this->f->addToLog(
                        __METHOD__."(): ERROR om_parametre 'insee' inexistant.",
                        DEBUG_MODE
                    );
                    return false;
                }

                // enregistre le code insee
                $insee = $collectivite_parameters['insee'];
            }

            // si l'option 'commune' est activée
            else {

                // si la commune est définie
                if (! empty($this->valF['commune'])) {

                    // récupère l'objet 'commune'
                    $commune = $this->f->findObjectById("commune", $this->valF['commune']);

                    // s'il est trouvé
                    if (! empty($commune)) {

                        // enregistre le code insee
                        $insee = $commune->getVal('com');
                    }

                    // commune non-trouvée
                    else {
                        $this->f->addToLog(
                            __METHOD__."(): ERROR commune '".$this->valF['commune']."' non-trouvée.",
                            DEBUG_MODE
                        );
                        return false;
                    }
                }

                // commune non-définie
                else {
                    $this->f->addToLog(
                        __METHOD__."(): ERROR champ 'commune' obligatoire.",
                        DEBUG_MODE
                    );
                    return false;
                }

                // enregistre la commune
                $valAuto['commune'] = $this->valF['commune'];
            }

            // Définition des valeurs à insérer
            $valAuto['om_collectivite'] = $this->valF['om_collectivite'];
            $valAuto['dossier_autorisation']="";
            $valAuto['exercice']=null;
            $valAuto['insee'] = $insee;
            $valAuto['arrondissement']=
                $this->getArrondissement($this->valF['terrain_adresse_code_postal']);
            $valAuto['etat_dossier_autorisation']=$id_etat_initial_da;
            $valAuto['erp_numero_batiment']=null;
            $valAuto['erp_ouvert']=null;
            $valAuto['erp_arrete_decision']=null;
            $valAuto['dossier_autorisation_type_detaille']=
                $this->valF['dossier_autorisation_type_detaille'];
            if ($this->f->is_option_date_depot_mairie_enabled() === true && $val['date_depot_mairie'] != null) {
                $valAuto['depot_initial']= $val['date_depot_mairie'];
            } else {
                $valAuto['depot_initial']=
                    $this->dateDBToForm($this->valF['date_demande']);
            }
            $valAuto['terrain_references_cadastrales']=
                $this->valF['terrain_references_cadastrales'];
            $valAuto['terrain_adresse_voie_numero']=
                $this->valF['terrain_adresse_voie_numero'];
            $valAuto['terrain_adresse_voie']=$this->valF['terrain_adresse_voie'];
            $valAuto['terrain_adresse_lieu_dit']=
                $this->valF['terrain_adresse_lieu_dit'];
            $valAuto['terrain_adresse_localite']=
                $this->valF['terrain_adresse_localite'];
            $valAuto['terrain_adresse_code_postal']=
                $this->valF['terrain_adresse_code_postal'];
            $valAuto['terrain_adresse_bp']=$this->valF['terrain_adresse_bp'];
            $valAuto['terrain_adresse_cedex']=$this->valF['terrain_adresse_cedex'];
            $valAuto['terrain_superficie']=$this->valF['terrain_superficie'];
            $valAuto['numero_version']=-1;
            // Pour vérifier dans le dossier d'autorisation si déposé électroniquement
            $valAuto['depot_electronique']=$this->valF['depot_electronique'];

            // saisie manuelle du numéro de dossier et division instructeur
            if (isset($val['num_doss_manuel']) && $val['num_doss_manuel'] == 'Oui' &&
                isset($val['num_doss_sequence']) && !empty($val['num_doss_sequence'])) {

                $valAuto['numero_dossier_seq'] = $val['num_doss_sequence'];

                if (isset($val['num_doss_division'])) {
                    $valAuto['division_instructeur'] = $val['num_doss_division'];
                }
            }

            $this->da_already_exists = false;
            // saisie manuelle du numéro de dossier complet
            if (isset($val['num_doss_manuel']) && $val['num_doss_manuel'] == 'Oui' &&
                isset($val['num_doss_complet']) && !empty($val['num_doss_complet'])) {
                //
                $valAuto['numero_dossier_complet'] = $val['num_doss_complet'];
                $dossier_autorisation_id = $val['num_doss_complet'];

                // donnée utilisée pour le numéro de dossier complet
                $ref_num_dossier = $val['num_doss_complet'];

                // si l'option 'code_entité' est activée pour la collectivité
                if ($this->f->is_option_om_collectivite_entity_enabled($this->valF['om_collectivite'])) {

                    // si le code entité n'est pas défini ou vide
                    if ($this->f->get_collectivite_code_entite($this->valF['om_collectivite']) === null) {

                        // affiche un message d'alerte
                        $err_msg = sprintf(__("Paramètre '%s' manquant ou vide pour la collectivité '%s'"),
                                           'code_entite',
                                           $this->valF['om_collectivite']);
                        $this->f->addToLog(__METHOD__."() : $err_msg", DEBUG_MODE);
                        $this->addToMessage($err_msg.'<br/>');
                    }
                    // si le code entité est défini et non-vide
                    else {

                        // supprime le code entité du numéro de dossier
                        $code_entite = $this->f->get_collectivite_code_entite($this->valF['om_collectivite']);
                        $ref_num_dossier = preg_replace('/'.$code_entite.'[0-9]+$/', '', $ref_num_dossier);
                    }
                }

                $num_urba = $this->f->numerotation_urbanisme($ref_num_dossier);
                if (isset($num_urba['da'][0]) === true) {
                    $dossier_autorisation_id = $num_urba['da'][0];
                }
                if ($this->f->findObjectById('dossier_autorisation', $dossier_autorisation_id) !== null) {
                    $this->da_already_exists = true;
                }
            }

            $valAuto['source_depot'] = is_null($val['source_depot']) === true || $val['source_depot'] === '' ? 'app' : $val['source_depot'];

            if ($this->da_already_exists === false) {
                // Ajout du dossier dans la base
                if($dossier_autorisation->ajouter($valAuto) === false) {
                    $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter le dossier d'autorisation.", DEBUG_MODE);
                    if (!empty($dossier_autorisation->msg)) {
                        $this->f->addToLog(__METHOD__."() : ERROR - ".$dossier_autorisation->msg, DEBUG_MODE);
                        $this->addToMessage($dossier_autorisation->msg.'<br/>');
                    }
                    return false;
                }
                $dossier_autorisation_id = $dossier_autorisation->valF['dossier_autorisation'];
                $this->f->addToLog(__METHOD__."() : DA ajouté : ".$dossier_autorisation_id, VERBOSE_MODE);
            }

            // Liaison du dossier ajouter à la demande
            $this->valF['dossier_autorisation'] = $dossier_autorisation_id;

            return true;
        }

        $this->f->addToLog(__METHOD__."() : ERROR - Le paramétre id_etat_initial_dossier_autorisation n'existe pas.", DEBUG_MODE);

        return false;
    }

    /**
     * Méthode permettant d'ajouter un dossier d'instruction.
     *
     * @param integer  $id                       identifiant de la demande
     * @param array    $val                      tableau de valeurs postées via
     *                                           le formulaire
     * @param integer  $dossier_instruction_type identifiant du DI type
     *
     * @return boolean false si erreur
     */
    function ajoutDossierInstruction($id, $val, $dossier_instruction_type) {
        // Le traitement de la création des dossiers et des sous-dossiers est
        // différent. Instancie la classe voulue pour permettre d'effectuer le
        // bon traitement d'ajout des dossiers
        if (! empty($val['sous_dossier']) && $val['sous_dossier'] == 't') {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "sous_dossier",
                "idx" => "]",
            ));
        } else {
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => "]",
            ));
        }
        // Initialisation du tableau contenant les valeurs qui serviront à créer le dossier
        $valInstr = array();
        foreach($dossier->champs as $value) {
            $valInstr[$value] = null;
        }
        // TODO: remove because unused
        $datd = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_autorisation_type_detaille",
            "idx" => $this->valF['dossier_autorisation_type_detaille'],
        ));
                
        /*Ajout de la variable dossier_instruction_type à l'objet dossier pour le
         * versionning
         */
        $dossier->setDossierInstructionType($dossier_instruction_type);
        
        // Définition des valeurs à entrée dans la table
        $valInstr['om_collectivite']=$this->valF['om_collectivite'];
        $valInstr['dossier_instruction_type']=$dossier_instruction_type;
        $valInstr['date_depot']=$this->dateDBToForm($this->valF['date_demande']);
        if ($this->f->is_option_date_depot_mairie_enabled() === true){
            $valInstr['date_depot_mairie'] = $val['date_depot_mairie'];
        }
        $valInstr['date_dernier_depot']=$this->dateDBToForm($this->valF['date_demande']);
        $valInstr['date_demande']=$this->dateDBToForm($this->valF['date_demande']);
        $valInstr['depot_initial']=$this->dateDBToForm($this->valF['date_demande']);
        $annee = DateTime::createFromFormat("Y-m-d", $this->valF['date_demande']);
        $valInstr['annee']=$annee->format("y");
        $valInstr['depot_electronique']=$this->valF['depot_electronique'];
        $valInstr['parcelle_temporaire']=$this->valF['parcelle_temporaire'];
        $valInstr['terrain_references_cadastrales']=
            $this->valF['terrain_references_cadastrales'];
        $valInstr['terrain_adresse_voie_numero']=
            $this->valF['terrain_adresse_voie_numero'];
        $valInstr['terrain_adresse_voie']=$this->valF['terrain_adresse_voie'];
        $valInstr['terrain_adresse_lieu_dit']=$this->valF['terrain_adresse_lieu_dit'];
        $valInstr['terrain_adresse_localite']=$this->valF['terrain_adresse_localite'];
        $valInstr['terrain_adresse_code_postal']=
            $this->valF['terrain_adresse_code_postal'];
        $valInstr['terrain_adresse_bp']=$this->valF['terrain_adresse_bp'];
        $valInstr['terrain_adresse_cedex']=$this->valF['terrain_adresse_cedex'];
        $valInstr['terrain_superficie']=$this->valF['terrain_superficie'];
        $valInstr['description']="";
        $valInstr['dossier_autorisation']=$this->valF['dossier_autorisation'];
        if ($this->valF["autorisation_contestee"] != "") {
            $valInstr['autorisation_contestee'] = str_replace(' ', '', $this->valF['autorisation_contestee']);
        }
        $valInstr['demande_type'] = $this->valF['demande_type'];
        $valInstr['etat_transmission_platau'] = $val['etat_transmission_platau'];

        /*
         * Gestion de la qualification
         * */
        // Initialise le champ à false
        $valInstr['a_qualifier'] = false;

        // Récupère l'information depuis le type de la demande
        $inst_demande_type = $this->f->get_inst__om_dbform(array(
            "obj" => "demande_type",
            "idx" => intval($valInstr['demande_type']),
        ));
        $qualification = $inst_demande_type->getVal('qualification');
        
        // Si le dossier doit être à qualifier
        if ($qualification === 't') {
            // Met le champ à true
            $valInstr['a_qualifier'] = true;
        }

        /*
         * Gestion de la simulation des taxes
         */
        // Récupère l'instance du cerfa lié au type détaillé du DA
        // TODO : à vérifier mais cette variable n'est pas utilisée et doit être supprimée
        $inst_cerfa = $this->get_inst_cerfa_by_datd($val['dossier_autorisation_type_detaille']);

        // Récupère le paramétrage des taxes
        $inst_taxe_amenagement = $this->get_inst_taxe_amenagement_by_om_collectivite($this->valF['om_collectivite']);
        // Si un paramétrage des taxes est récupéré pour la collectivité
        if ($inst_taxe_amenagement !== null) {
            // Si la taxe d'aménagement à un seul secteur
            if ($inst_taxe_amenagement->has_one_secteur() == true) {
                // Sélectionne l'unique secteur automatiquement
                $valInstr['tax_secteur'] = 1;
            }
        }

        // saisie de la commune
        if (array_key_exists('commune', $this->valF)) {
            $valInstr['commune'] = $this->valF['commune'];
        }

        // saisie de l'affectation automatique
        if (isset($this->valF['affectation_automatique'])) {
            $valInstr['affectation_automatique'] = $this->valF['affectation_automatique'];
        }

        // saisie manuelle du numéro de dossier complet
        if (isset($val['num_doss_manuel']) === true && $val['num_doss_manuel'] == 'Oui' &&
            isset($val['num_doss_complet']) === true && empty($val['num_doss_complet']) === false) {
            //
            $valInstr['numero_dossier_complet'] = $val['num_doss_complet'];
        }
        
        $valInstr['source_depot'] = is_null($val['source_depot']) === true || $val['source_depot'] === '' ? 'app' : $val['source_depot'];

        // Récupération du numéro du dossier parent pour les sous-dossier
        if (! empty($val['sous_dossier'])
            && $val['sous_dossier'] == true
            && ! empty($val['dossier_parent'])) {
            $valInstr['dossier_parent'] = $val['dossier_parent'];
        }

        //
        $this->f->addToLog(__METHOD__."() : ajout du dossier", EXTRA_VERBOSE_MODE);

        if($dossier->ajouter($valInstr) === false) {
            $this->f->addToLog($dossier->msg, DEBUG_MODE);
            $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter le dossier d'instruction.", DEBUG_MODE);
            // Affiche l'erreur empêchant a création du dossier d'instruction
            $this->addToMessage($dossier->msg);
            return false;
        }
        else {
            $this->f->addToLog(__METHOD__."() : dossier ajouté", VERBOSE_MODE);
        }
        

        // Si le dossier n'est pas un initial, que le type de dossier d'autorisation détaillé 
        // est dans la liste du paramètre erp__dossier__nature__at 
        // ou (que le type de dossier d'autorisation détaillé est dans la liste du paramètre erp__dossier__nature_pc 
        // et que le type de dossier d'instruction est dans la liste du paramètre erp__dossier__type_di__pc)
        // alors la valeur de la case ERP du dossier initial est appliquée au nouveau dossier
        if ($this->f->is_option_referentiel_erp_enabled($this->valF['om_collectivite']) === true) {
            if (($dossier->get_di_numero_suffixe($dossier->valF['dossier']) != '' 
                || $dossier->get_di_numero_suffixe($dossier->valF['dossier']) != '0')) {

                if ($this->f->getDATCode($dossier->valF['dossier']) == $this->f->getParameter('erp__dossier__nature__at')
                    || ($this->f->getDATCode($dossier->valF['dossier']) == $this->f->getParameter('erp__dossier__nature__pc')
                    && in_array($dossier->valF['dossier_instruction_type'], explode(";", $this->f->getParameter('erp__dossier__type_di__pc'))) === true)) {
                    
                    // On récupère la valeur de la case erp du dossier d'instruction initial
                    $qres = $this->f->get_one_result_from_db_query(
                        sprintf(
                            'SELECT
                                erp
                            FROM
                                %1$sdossier
                                LEFT JOIN %1$sdossier_instruction_type
                                    ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                            WHERE
                                dossier.dossier_autorisation = (
                                    SELECT 
                                        dossier_autorisation.dossier_autorisation 
                                    FROM
                                        %1$sdossier_autorisation 
                                        LEFT JOIN %1$sdossier
                                            ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
                                    WHERE
                                        dossier = \'%2$s\'
                                )
                                AND dossier_instruction_type.code = \'P\'',
                            DB_PREFIXE,
                            $this->f->db->escapeSimple($dossier->valF['dossier'])
                        ),
                        array(
                            "origin" => __METHOD__,
                            "force_return" => true,
                        )
                    );
                    if ($qres["code"] !== "OK") {
                        $this->f->addToLog(
                            __METHOD__."() : ERROR - Impossible de récupérer la valeur de la case ERP du DI initial",
                            DEBUG_MODE
                        );
                        return false;
                    }

                    // On met à jour la case erp en fonction du DI initial
                    $valF = array();
                    $valF['erp'] = isset($qres["result"]) === true && $qres["result"] === 't' ? true : false;

                    $res = $this->f->db->autoExecute(
                        DB_PREFIXE."dossier",
                        $valF,
                        DB_AUTOQUERY_UPDATE,
                        $dossier->clePrimaire."='".$dossier->valF['dossier']."'"
                    );

                    if ($this->f->isDatabaseError($res, true)) {
                        // Appel de la methode de recuperation des erreurs
                        $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
                        $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'appliquer la case ERP sur le dossier d'instruction.", DEBUG_MODE);
                        $this->correct = false;
                        return false;
                    }
                }
            }
        }

        //Affichage de message à l'utilisateur concernant un problème lors de 
        //l'affectation de l'instructeur au dossier d'instruction
        if ($dossier->valF['dossier_autorisation'] === '' &&
            $dossier->valF['instructeur'] === null){
            $this->addToMessage(
                _("Aucun instructeur compatible avec ce dossier, contactez votre administrateur afin d'en assigner un a ce dossier.")
            );
        }
        elseif ( $dossier->valF['instructeur'] === null ){
            if ($this->f->isAccredited("dossier_modifier_instructeur")) {
                $this->addToMessage("<br/> ".
                    _("Pensez a assigner un instructeur a ce dossier.")
                );
            } else {
                $this->addToMessage(
                    _("Aucun instructeur compatible avec ce dossier, contactez votre administrateur afin d'en assigner un a ce dossier.")
                );
            }
        }

        // Liaison du dossier ajouter à la demande
        $this->valF['dossier_instruction'] = $dossier->valF['dossier'];

        //
        return true;
    }

    /**
     * Méthode permettant d'ajouter les données techniques d'un DA.
     *
     * @param integer  $id    identifiant de la demande
     * @param array    $val   tableau de valeurs postées via le formulaire
     *
     * @return boolean false si erreur
     */
    function ajoutDonneesTechniquesDA($id, $val) {
        $this->DTDA = $this->f->get_inst__om_dbform(array(
            "obj" => "donnees_techniques",
            "idx" => "]",
        ));
        
        // Champs tous à NULL car seul le champ concernant le dossier
        // d'autorisation sera rempli
        foreach($this->DTDA->champs as $value) {
            $valF[$value] = null;
        }
        // Ajout du numéro de dossier d'instruction
        $valF['dossier_autorisation']=$this->valF['dossier_autorisation'];
        // Identifiant du cerfa
        $valF['cerfa'] = $this->getIdCerfa();
        //On vérifie que ce type détaille de dossier d'autorisation a un CERFA
        if ( $valF['cerfa'] !== "" && is_numeric($valF['cerfa'])){
            // Ajout des données techniques
            if($this->DTDA->ajouter($valF) === false) {
                $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter les données techniques du dossier d'autorisation.", DEBUG_MODE);
                return false;
            }
            $this->f->addToLog(__METHOD__."() : DTDA ajoutées", VERBOSE_MODE);
        }
        else {
            //On indique que le dossier d'autorisation n'a pas de données techniques
            $this->DTDA = null;
            //Aucun CERFA n'est paramétré pour ce type détaillé de dossier d'autorisation
            $this->f->addToLog(__METHOD__."() : ERROR - Aucun CERFA paramétré.", DEBUG_MODE);
            return -1;
        }

        //
        return true;
    }

    /**
     * Ajout des liens demandeurs / dossier d'autorisation s'ils n'y sont pas déjà
     **/
    function ajoutLiensDossierAutorisation($id, $val) {
        // Vérifie que le dossier d'instruction possède déjà un petitionnaire principal
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    COUNT(lien_dossier_autorisation_demandeur)
                FROM
                    %1$slien_dossier_autorisation_demandeur
                WHERE
                    dossier_autorisation = \'%2$s\'
                    AND petitionnaire_principal IS TRUE',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->valF['dossier_autorisation'])
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $already_principal = false;
        if ($qres["result"] > 0) {
            $already_principal = true;
        }

        // Création des liens entre le dossier autorisation et les demandeurs
        $ldad = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_dossier_autorisation_demandeur",
            "idx" => "]",
        ));
        // Recupération des demandeurs liés à la demande
        $sql = str_replace(
            "<demande>",
            intval($this->valF['demande']),
            $this->get_var_sql_forminc__sql("lien_demande_demandeur")
        );
        $sql .= sprintf(
            ' AND lien_demande_demandeur.demandeur NOT IN (
                SELECT
                    lien_dossier_autorisation_demandeur.demandeur
                FROM
                    %1$slien_dossier_autorisation_demandeur
                WHERE
                    lien_dossier_autorisation_demandeur.dossier_autorisation = \'%2$s\'
            )',
            DB_PREFIXE,
            $this->f->db->escapeSimple($this->valF['dossier_autorisation'])
        );
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                $sql,
                DB_PREFIXE
            ),
            array(
                'origin' => __METHOD__,
                'force_result' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            return false;
        }
        foreach ($qres['result'] as $row) {
            $can_add = true;
            $row['lien_dossier_autorisation_demandeur'] = NULL;
            $row['dossier_autorisation'] = $this->valF['dossier_autorisation'];
            // La liaison n'est pas ajoutée si celle-ci concerne un pétitionnaire principal
            // alors que le DA possède est déjà lié à un petitionnaire principal
            if ($row['petitionnaire_principal'] === 't'
                && $already_principal === true) {
                //
                $can_add = false;
            }
            if ($can_add === true) {
                $add = $ldad->ajouter($row);
                if ($add === false) {
                    $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter le lien entre le demandeurs et le dossier d'autorisation.", DEBUG_MODE);
                    return false;
                }
            }
        }
        $this->f->addToLog(__METHOD__."() : liens demandeurs DA ajoutés", VERBOSE_MODE);

        //
        return true;
    }

    /**
     * Ajout des liens demandeurs / dossier d'autorisation
     **/
    function ajoutLiensDossierInstruction($id, $val) {
        // Création des liens entre le dossier instruction et les demandeurs
        $ldd = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_dossier_demandeur",
            "idx" => "]",
        ));
        // Recupération des demandeurs liés à la demande
        $qres = $this->f->get_all_results_from_db_query(
            str_replace(
                "<demande>",
                intval($this->valF['demande']),
                $this->get_var_sql_forminc__sql("lien_demande_demandeur")
            ),
            array(
                'origin' => __METHOD__,
                'force_result' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            return false;
        }
        foreach ($qres['result'] as $row) {
            $row['lien_dossier_demandeur'] = NULL;
            $row['dossier'] = $this->valF['dossier_instruction'];
            if ($ldd->ajouter($row) === false) {
                $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter le lien entre le demandeurs et le dossier d'instruction.", DEBUG_MODE);
                return false;
            }
        }
        $this->f->addToLog(__METHOD__."() : liens demandeurs DI ajoutés", VERBOSE_MODE);

        //
        return true;
    }

    /*
     * Récupère l'identifiant d'un arrondissement à partir d'un code postal
     */
    function getArrondissement($terrain_adresse_code_postal){
        
        $arrondissement = NULL;
        
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    arrondissement 
                FROM 
                    %1$sarrondissement 
                WHERE 
                    code_postal = \'%2$d\'',
                DB_PREFIXE,
                intval($terrain_adresse_code_postal)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        
        if ($qres['row_count'] > 0) {
            
            $row = array_shift($qres['result']);
            $arrondissement = $row['arrondissement'];
        }
        
        return $arrondissement;
    }
    
    /*
     * Récupère l'évènement lié à un type de demande
     */
     function getEvenement($demande_type){         
        $evenement = null;
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    evenement
                FROM
                    %1$sdemande_type
                WHERE
                    demande_type = %2$d',
                DB_PREFIXE,
                intval($demande_type)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        
        if ($qres['row_count'] > 0) {
            $row = array_shift($qres['result']);
            $evenement = $row['evenement'];
        }
        
        return $evenement;
    }

    /**
     * TRIGGER - triggerajouter.
     *
     * - Ajout des dossiers
     *
     * @return boolean
     */
    function triggerajouter($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        //
        // Le mode MC nécessite des paramètres spécifiques
        if ($this->f->is_option_om_collectivite_entity_enabled($this->valF['om_collectivite']) === true) {
            if ($this->f->get_collectivite_code_entite(intval($this->valF['om_collectivite'])) === null) {
                $this->addToMessage(sprintf(
                    __("Veuillez renseigner le paramètre %s"),
                    sprintf('<span class="bold">%s</span>', 'code_entite')
                ));
                $this->correct = false;
                return false;
            }
        }
        //
        if($this->valF["demande_type"] != null) {
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    str_replace(
                        '<idx>',
                        intval($this->valF['demande_type']),
                        $this->get_var_sql_forminc__sql("demande_type_details_by_id")
                    )
                ),
                array(
                    'origin' => __METHOD__,
                    'force_result' => true
                )
            );
            if ($qres['code'] !== 'OK') {
                return false;
            }
            // Attribut permettant de définir si un dossier a été créé
            $this->ajoutDI = false;
            $dossier_type = array_shift($qres['result']);
            $dossier_instruction_type = null;
            if (isset($dossier_type['dossier_instruction_type']) === true
                && empty($dossier_type['dossier_instruction_type']) === false) {
                //
                $dossier_instruction_type = intval($dossier_type['dossier_instruction_type']);
            }

            // Par défaut on considère que le dossier d'instruction ne doit pas
            // être transmissible à Plat'AU
            $etat_transmission_platau = 'jamais_transmissible';

            // Si on est sur un ajout dossier sur existant
            // Vérifie que le type de DA est transmissible et que le type de DI est également
            // considéré comme transmissible
            if ($this->valF['dossier_autorisation'] !== ""
                && $this->f->is_type_dossier_platau($this->valF['dossier_autorisation']) === true
                && $this->f->is_dit_transmitted_platau($dossier_instruction_type, intval($this->valF['om_collectivite'])) === true) {
                //
                $etat_transmission_platau = 'non_transmissible';
                if (isset($val['etat_transmission_platau']) === true) {
                    $etat_transmission_platau = $val['etat_transmission_platau'];
                }
            }

            // Création du dossier_autorisation
            if($this->valF['dossier_autorisation'] == "") {
                //
                if($this->ajoutDossierAutorisation($id, $val) === false) {
                    if(empty($this->msg)) {
                        $this -> addToMessage(
                            _("Erreur lors de l'enregistrement de la demande.")." ".
                            _("Contactez votre  administrateur.")
                        );
                    }
                    $this->correct = false;
                    return false;
                }

                // Seulement dans le cas d'un dossier d'instruction initial, dont le type serait
                // prise en charge par Plat'AU, alors il serait transmissible
                if ($this->f->is_type_dossier_platau($this->valF['dossier_autorisation']) === true) {
                    $etat_transmission_platau = 'non_transmissible';
                    if (isset($val['etat_transmission_platau']) === true) {
                        $etat_transmission_platau = $val['etat_transmission_platau'];
                    }
                }

                if ($this->da_already_exists === false) {
                    //
                    $inst_da = $this->get_inst_dossier_autorisation($this->valF['dossier_autorisation']);
                    if ($inst_da->is_dossier_autorisation_visible()) {
                        $this->addToMessage(
                            _("Creation du dossier d'autorisation no").
                            '<span id="new_da">'.
                            $inst_da->getVal('dossier_autorisation_libelle').
                            '</span>'
                        );
                    }
                    // Ajout des données techniques au dossier d'autorisation
                    if($this->ajoutDonneesTechniquesDA($id, $val) === false) {
                        $this -> addToMessage(
                            _("Erreur lors de l'enregistrement de la demande.")." ".
                            _("Contactez votre  administrateur.")
                        );
                        $this->correct = false;
                        return false;
                    }
                }
            } else {

                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            donnees_techniques
                        FROM
                            %1$sdonnees_techniques
                        WHERE
                            dossier_autorisation = \'%2$s\'',
                        DB_PREFIXE,
                        $this->db->escapeSimple($this->valF['dossier_autorisation'])
                    ),
                    array(
                        "origin" => __METHOD__,
                        "force_return" => true,
                    )
                );
                if ($qres["code"] !== "OK") {
                    return false;
                }

                $this->DTDA = null;
                if ($qres["result"] !=="" && is_numeric($qres["result"])){
                    $this->DTDA = $this->f->get_inst__om_dbform(array(
                        "obj" => "donnees_techniques",
                        "idx" => $qres["result"],
                    ));
                    $this->DTDA->setValFFromVal();
                }
            }

            // Enregistrement du numéro dossier existant
            // (il sera écrasé si un DI est créé)
            if ($this->getParameter("idx_dossier") != "") {
                $this->valF['dossier_instruction'] = $this->getParameter("idx_dossier");
            }

            // Affecte la valeur de l'état de transmission avant la création du
            // dossier d'instruction
            $val['etat_transmission_platau'] = $etat_transmission_platau;

            // Création du dossier d'instruction
            if($dossier_instruction_type != null) {
                if($this->ajoutDossierInstruction($id, $val, $dossier_instruction_type) === false ) {
                    $this->addToMessage(
                        _("Erreur lors de l'enregistrement de la demande.")." ".
                        _("Contactez votre  administrateur.")
                    );
                    $this->correct = false;
                    return false;
                }
                // Libellé du dossier
                $inst_di = $this->get_inst_dossier_instruction($this->valF['dossier_instruction']);
                $dossier_libelle = $inst_di->getVal('dossier_libelle');
                // Message de validation
                $this->addToMessage(
                    _("Creation du dossier d'instruction no")."<span id='new_di'>".$dossier_libelle."</span>"."<br/>"
                );

                // Attribut permettant de définir si un dossier a été créé.
                $this->ajoutDI = true;
            }

            $inst_datd = $this->get_inst_common("dossier_autorisation_type_detaille", $this->valF['dossier_autorisation_type_detaille']);
            $code_datd = $inst_datd->getVal('code');

            $obj = "dossier_instruction";
            if ($code_datd === 'REC' OR $code_datd === 'REG') {
                $obj = "dossier_contentieux_tous_recours";
            }
            if ($code_datd === 'IN') {
                $obj = "dossier_contentieux_toutes_infractions";
            }

            // Template du lien vers le DI
            $template_link_di = "<a id='link_demande_dossier_instruction' title=\"%s\" class='lien' href='".OM_ROUTE_FORM."&obj=" . $obj . "&action=3&idx=%s'><span class='om-icon om-icon-16 om-icon-fix consult-16'></span>%s</a>";

            // Lien vers le DI
            $link_di = sprintf($template_link_di, _("Visualiser le dossier d'instruction / modifier la demande"), $this->valF['dossier_instruction'], _("Acceder au dossier d'instruction"));

            // Message affiché à l'utilisateur
            $this->addToMessage($link_di."<br/>");

            /*Ajout de l'arrondissement à partir du code postal*/
            if ( !is_null($this->valF["terrain_adresse_code_postal"]) && is_numeric($this->valF["terrain_adresse_code_postal"]) ){
                
                $this->valF["arrondissement"] = $this->getArrondissement($this->valF["terrain_adresse_code_postal"]);
            }
        }

        //
        return true;
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * - Ajout des délégataires et pétitionnaires
     * - ...
     * - Option de numérisation
     * - Interface avec le référentiel ERP [109]
     * - Interface avec le référentiel ERP [112]
     * - Interface avec le référentiel ERP [110]
     * - Interface avec le référentiel ERP [107]
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Récupération d'informations nécessaires seulement lors de l'envoi de messages ERP
        if ($this->f->is_option_referentiel_erp_enabled($this->valF['om_collectivite']) === true) {
            // Instanciation du dossier d'instruction concerné par la demande en
            // cours d'ajout avant modification éventuelle par l'instruction
            $inst_di = $this->get_inst_dossier_instruction($this->valF['dossier_instruction']);
            // Récupère l'état du dossier avant l'exécution d'une éventuelle action
            // associée à l'événement d'instruction : utile pour le message 112 vers
            // le référentiel ERP
            $etat_di_before_instr = $inst_di->getVal('etat');
        }

        /**
         *
         */
        if ($this->insertLinkDemandeDemandeur() == false) {
            return false;
        }
        
        // Ajout des lliens entre dossier_autorisation et demandeur
        if(!empty($this->valF['dossier_autorisation'])) {
            if ($this->ajoutLiensDossierAutorisation($id, $val) == false) {
                return false;
            }
        }
        // Ajout des liens entre dossier et demandeur
        if($this->ajoutDI === TRUE) {
            if ($this->ajoutLiensDossierInstruction($id, $val) == false) {
                return false;
            }
        }
        
        // Création d'un lien entre le nouveau DI et le dossier contesté
        if ($this->valF["autorisation_contestee"] != "") {
            if ($this->ajoutLienDossierConteste() === false) {
                return false;
            }
        }

        // Duplication des lots (et leurs données techniques) et
        // liaison au nouveau dossier_d'instruction
        if(!empty($this->valF['dossier_autorisation']) AND $val['dossier_autorisation'] != "" ) {
            $this->lienLotDossierInstruction($id, $val);
        }

        /*Création du lien de téléchargement de récépissé de demande*/
        if ( $this->valF['demande_type'] != "" && is_numeric($this->valF['demande_type']) 
            && isset($this->valF['dossier_instruction']) && $this->valF['dossier_instruction'] !== "" ){
         
            /*Récupérer l'événement lié à ce type de demande*/
            $evenement = $this->getEvenement($this->valF['demande_type']);
                            
            /*Récupération de la lettre type de l'événement*/
            $lettretype = $this->f->getLettreType($evenement);
            
            /*Création d'une nouvelle instruction avec cet événement*/
            /*Données*/
            $valInstr['instruction']=NULL;
            
            $valInstr['destinataire']=$this->valF['dossier_instruction'];
            $valInstr['dossier']=$this->valF['dossier_instruction'];
            // Récupère la date de la demande
            $valInstr['date_evenement']=$this->dateDBToForm($this->valF['date_demande']);
            $valInstr['evenement']=$evenement;
            $valInstr['lettretype']=$lettretype;
            $valInstr['complement_om_html']="";
            $valInstr['complement2_om_html']="";
            
            $valInstr['action']="initialisation";
            $valInstr['delai']="2";
            $valInstr['etat']="notifier";
            $valInstr['accord_tacite']="Oui";
            $valInstr['delai_notification']="1";
            $valInstr['archive_delai']="0";
            $valInstr['archive_date_complet']=NULL;
            $valInstr['archive_date_dernier_depot']=NULL;
            $valInstr['archive_date_rejet']=NULL;
            $valInstr['archive_date_limite']=NULL;
            $valInstr['archive_date_notification_delai']=NULL;
            $valInstr['archive_accord_tacite']="Non";
            $valInstr['archive_etat']="initialiser";
            $valInstr['archive_date_decision']=NULL;
            $valInstr['archive_avis']="";
            $valInstr['archive_date_validite']=NULL;
            $valInstr['archive_date_achevement']=NULL;
            $valInstr['archive_date_chantier']=NULL;
            $valInstr['archive_date_conformite']=NULL;
            $valInstr['archive_incompletude']=NULL;
            $valInstr['archive_incomplet_notifie']=NULL;
            $valInstr['archive_evenement_suivant_tacite']="";
            $valInstr['archive_evenement_suivant_tacite_incompletude']=NULL;
            $valInstr['archive_etat_pendant_incompletude']=NULL;
            $valInstr['archive_date_limite_incompletude']=NULL;
            $valInstr['archive_delai_incompletude']=NULL;
            $valInstr['archive_autorite_competente']=NULL;
            $valInstr['complement3_om_html']="";
            $valInstr['complement4_om_html']="";
            $valInstr['complement5_om_html']="";
            $valInstr['complement6_om_html']="";
            $valInstr['complement7_om_html']="";
            $valInstr['complement8_om_html']="";
            $valInstr['complement9_om_html']="";
            $valInstr['complement10_om_html']="";
            $valInstr['complement11_om_html']="";
            $valInstr['complement12_om_html']="";
            $valInstr['complement13_om_html']="";
            $valInstr['complement14_om_html']="";
            $valInstr['complement15_om_html']="";
            $valInstr['avis_decision']=NULL;
            $valInstr['date_finalisation_courrier']=NULL;
            $valInstr['date_envoi_signature']=NULL;
            $valInstr['date_retour_signature']=NULL;
            $valInstr['date_envoi_rar']=NULL;
            $valInstr['date_retour_rar']=NULL;
            $valInstr['date_envoi_controle_legalite']=NULL;
            $valInstr['date_retour_controle_legalite']=NULL;
            $valInstr['signataire_arrete']=NULL;
            $valInstr['numero_arrete']=NULL;
            $valInstr['code_barres']=NULL;
            $valInstr['om_fichier_instruction']=NULL;
            $valInstr['om_final_instruction']=NULL;
            $valInstr['document_numerise']=NULL;
            $valInstr['autorite_competente']=NULL;
            $valInstr['duree_validite_parametrage']="0";
            $valInstr['duree_validite']="0";
            $valInstr['date_depot']=NULL;
            $valInstr['date_depot_mairie']=NULL;
            $valInstr['om_final_instruction_utilisateur']= "f";
            $valInstr['om_fichier_instruction_dossier_final']= "f";
            $valInstr['created_by_commune']= "f";
            $valInstr['archive_date_cloture_instruction'] = null;
            $valInstr['archive_date_premiere_visite'] = null;
            $valInstr['archive_date_derniere_visite'] = null;
            $valInstr['archive_date_contradictoire'] = null;
            $valInstr['archive_date_retour_contradictoire'] = null;
            $valInstr['archive_date_ait'] = null;
            $valInstr['archive_date_transmission_parquet'] = null;
            $valInstr['flag_edition_integrale'] = 'f';
            $valInstr['titre_om_htmletat'] = null;
            $valInstr['corps_om_htmletatex'] = null;
            $valInstr['archive_dossier_instruction_type'] = null;
            $valInstr['archive_date_affichage'] = null;
            $valInstr['pec_metier'] = null;
            $valInstr['archive_pec_metier'] = null;
            $valInstr['archive_a_qualifier'] = null;
            $valInstr['id_parapheur_signature'] = NULL;
            $valInstr['statut_signature'] = NULL;
            $valInstr['commentaire_signature'] = NULL;
            $valInstr['historique_signature'] = NULL;
            $valInstr['parapheur_lien_page_signature'] = NULL;
            $valInstr['commentaire'] = NULL;
            $valInstr['envoye_cl_platau'] = "f";

            // Récupération des champs archive si cette demande a créée un dossier
            // d'instruction mais pas un P0
            if (!is_null($this->valF['dossier_instruction'])
                && $this->valF['dossier_instruction'] !== "" ) {
                // Requête
                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            dossier_instruction_type.code
                        FROM
                            %1$sdemande_type
                            LEFT JOIN %1$sdossier_instruction_type
                                ON demande_type.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                        WHERE
                            demande_type.demande_type = %2$d',
                        DB_PREFIXE,
                        intval($this->valF['demande_type'])
                    ),
                    array(
                        "origin" => __METHOD__,
                        "force_return" => true,
                    )
                );
                if ($qres["code"] !== "OK") {
                    return false;
                }
                $res = $qres["result"];

                // On vérifie qu'il ne s'agit pas d'une nouvelle demande
                if (get_called_class() !== 'demande_nouveau_dossier') {
                    $res = $this->getArchiveInstruction($this->valF['dossier_instruction']);

                    if ($res == false) {
                        $this->addToLog(__METHOD__."(): ".sprintf(__("Erreur à la création de la demande %s lors de la récupération des données du dernier DI accordé."), $this->valF['dossier_instruction']), DEBUG_MODE);
                        return false;
                    }
                    
                    if (isset($res['archive_delai'])) {
                        $valInstr['archive_delai']=$res["archive_delai"];
                    }
                    if (isset($res['archive_date_complet'])) {
                        $valInstr['archive_date_complet']=$res["archive_date_complet"];
                    }
                    if (isset($res['archive_date_dernier_depot'])) {
                        $valInstr['archive_date_dernier_depot']=$res["archive_date_dernier_depot"];
                    }
                    if (isset($res['archive_date_rejet'])) {
                        $valInstr['archive_date_rejet']=$res["archive_date_rejet"];
                    }
                    if (isset($res['archive_date_limite'])) {
                        $valInstr['archive_date_limite']=$res["archive_date_limite"];
                    }
                    if (isset($res['archive_date_notification_delai'])) {
                        $valInstr['archive_date_notification_delai']=$res["archive_date_notification_delai"];
                    }
                    if (isset($res['archive_accord_tacite'])) {
                        $valInstr['archive_accord_tacite']=$res["archive_accord_tacite"];
                    }
                    if (isset($res['archive_etat'])) {
                        $valInstr['archive_etat']=$res["archive_etat"];
                    }
                    if (isset($res['archive_date_decision'])) {
                        $valInstr['archive_date_decision']=$res["archive_date_decision"];
                    }
                    if (isset($res['archive_avis'])) {
                        $valInstr['archive_avis']=$res["archive_avis"];
                    }
                    if (isset($res['archive_date_validite'])) {
                        $valInstr['archive_date_validite']=$res["archive_date_validite"];
                    }
                    if (isset($res['archive_date_achevement'])) {
                        $valInstr['archive_date_achevement']=$res["archive_date_achevement"];
                    }
                    if (isset($res['archive_date_chantier'])) {
                        $valInstr['archive_date_chantier']=$res["archive_date_chantier"];
                    }
                    if (isset($res['archive_date_conformite'])) {
                        $valInstr['archive_date_conformite']=$res["archive_date_conformite"];
                    }
                    if (isset($res['archive_incompletude'])) {
                        $valInstr['archive_incompletude']=$res["archive_incompletude"];
                    }
                    if (isset($res['archive_incomplet_notifie'])) {
                        $valInstr['archive_incomplet_notifie']=$res["archive_incomplet_notifie"];
                    }
                    if (isset($res['archive_evenement_suivant_tacite'])) {
                        $valInstr['archive_evenement_suivant_tacite']=$res["archive_evenement_suivant_tacite"];
                    }
                    if (isset($res['archive_evenement_suivant_tacite_incompletude'])) {
                        $valInstr['archive_evenement_suivant_tacite_incompletude']=$res["archive_evenement_suivant_tacite_incompletude"];
                    }
                    if (isset($res['archive_etat_pendant_incompletude'])) {
                        $valInstr['archive_etat_pendant_incompletude']=$res["archive_etat_pendant_incompletude"];
                    }
                    if (isset($res['archive_date_limite_incompletude'])) {
                        $valInstr['archive_date_limite_incompletude']=$res["archive_date_limite_incompletude"];
                    }
                    if (isset($res['archive_delai_incompletude'])) {
                        $valInstr['archive_delai_incompletude']=$res["archive_delai_incompletude"];
                    }
                    if (isset($res['archive_autorite_competente'])) {
                        $valInstr['archive_autorite_competente']=$res["archive_autorite_competente"];
                    }
                    if (isset($res['archive_date_cloture_instruction'])) {
                        $valInstr['archive_date_cloture_instruction'] = $res['archive_date_cloture_instruction'];
                    }
                    if (isset($res['archive_date_premiere_visite'])) {
                        $valInstr['archive_date_premiere_visite'] = $res['archive_date_premiere_visite'];
                    }
                    if (isset($res['archive_date_derniere_visite'])) {
                        $valInstr['archive_date_derniere_visite'] = $res['archive_date_derniere_visite'];
                    }
                    if (isset($res['archive_date_contradictoire'])) {
                        $valInstr['archive_date_contradictoire'] = $res['archive_date_contradictoire'];
                    }
                    if (isset($res['archive_date_retour_contradictoire'])) {
                        $valInstr['archive_date_retour_contradictoire'] = $res['archive_date_retour_contradictoire'];
                    }
                    if (isset($res['archive_date_ait'])) {
                        $valInstr['archive_date_ait'] = $res['archive_date_ait'];
                    }
                    if (isset($res['archive_date_transmission_parquet'])) {
                        $valInstr['archive_date_transmission_parquet'] = $res['archive_date_transmission_parquet'];
                    }
                    if (isset($res['archive_date_affichage'])) {
                        $valInstr['archive_date_affichage'] = $res['archive_date_affichage'];
                    }
                    if (isset($res['archive_pec_metier'])) {
                        $valInstr['archive_pec_metier'] = $res['archive_pec_metier'];
                    }
                    if (isset($res['archive_a_qualifier'])) {
                        $valInstr['archive_a_qualifier'] = $res['archive_a_qualifier'];
                    }
                }
            }

            // Création d'un nouveau dossier
            $instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => "]",
            ));
            $instruction->valF = array();
            if ($instruction->ajouter($valInstr) === false) {
                // Suppression des messages valides puisque erreur
                $this->msg = '';
                $this -> addToMessage($instruction->msg);
                $this -> addToMessage(_("Une erreur s'est produite lors de la creation du recepisse"));
                $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter l'instruction.", DEBUG_MODE);
                return false;
            }
            $this->f->addToLog(__METHOD__."() : instruction '$evenement' ($lettretype) ajoutée", VERBOSE_MODE);

            // Finalisation du document
            $_GET['obj']='instruction';
            $_GET['idx']=$instruction->valF[$instruction->clePrimaire];
            $instruction_final = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => $_GET['idx'],
            ));

            // Si l'instruction a une lettre type associée
            // ET si elle n'est pas déjà finalisée
            if($instruction_final->getVal('lettretype') != ""
                && $instruction_final->getVal('om_final_instruction') !== 't') {
                // On se met en contexte de l'action 100 finaliser
                $instruction_final->setParameter('maj',100);
                // On finalise l'événement d'instruction
                $this->f->addToLog(__METHOD__."() : finalisation de l'instruction '$evenement' ($lettretype) ...", VERBOSE_MODE);
                $res = $instruction_final->finalize();
                $this->f->addToLog(__METHOD__."() : instruction '$evenement' ($lettretype) finalisée", VERBOSE_MODE);
                // Si échec cela ne stoppe pas la création du dossier
                // et l'utilisateur n'en est pas informé dans l'IHM
                // mais l'erreur est loguée
                if ($res === false) {
                    $this->f->addToLog(__METHOD__."() : ERROR - Impossible de finaliser l'instruction.", DEBUG_MODE);
                }
            }

            // Mise à jour de la demande
            $this->valF['instruction_recepisse'] = $instruction->valF['instruction'];
            $this->valF['date_demande'] = $this->dateDBToForm($this->valF['date_demande']);
            $demande_instance = $this->f->get_inst__om_dbform(array(
                "obj" => "demande",
                "idx" => $this->valF['demande'],
            ));
            if ($demande_instance->modifier($this->valF) === false) {
                $this -> addToMessage($demande_instance->msg);
                $this->f->addToLog(__METHOD__."() : ERROR - Impossible de modifier la demande.", DEBUG_MODE);
                return false;
            }
            $this->f->addToLog(__METHOD__."() : demande mise à jour", VERBOSE_MODE);

            // Instance du dossier d'autorisation
            $inst_da = $this->get_inst_dossier_autorisation($this->valF['dossier_autorisation']);

            // Si l'option d'accès au portail citoyen est activée et que le DA est visible
            if ($this->f->is_option_citizen_access_portal_enabled($this->valF['om_collectivite']) === true
                && $inst_da->is_dossier_autorisation_visible() === true) {

                // Permet de forcer la regénération de la clé citoyen
                $force = false;

                // Regénération de la clé citoyen si le type de demande le demande
                $regeneration_cle_citoyen = $this->get_demande_type_regeneration_cle_citoyen($val['demande_type']);
                if ($regeneration_cle_citoyen === true) {
                    $force = true;
                }

                // Met à jour la clé d'accès au portail citoyen dans le dossier
                // d'autorisation
                $update = $inst_da->update_citizen_access_key($force);
                //
                if ($update !== true) {
                    //
                    $this->addToMessage(_("La cle d'acces au portail citoyen n'a pas pu etre generee."));
                    return false;
                }
            }

            // Si l'instruction initiale a une lettre type liée
            if ($instruction->valF['lettretype'] !== ''
                && $instruction->valF['lettretype'] !== null) {

                // Affichage du récépissé de la demande
                $this -> addToMessage("<a 
                    class='lien' id='link_demande_recepisse'
                    title=\""._("Telecharger le recepisse de la demande")."\"
                    href='".OM_ROUTE_FORM."&obj=demande&amp;action=100&amp;idx=".
                    $this->valF[$this->clePrimaire]."' target='_blank'>
                        <span 
                        class=\"om-icon om-icon-16 om-icon-fix pdf-16\" 
                        title=\""._("Telecharger le recepisse de la demande")."\">".
                            _("Telecharger le recepisse de la demande").
                        "</span>".
                            _("Telecharger le recepisse de la demande")."
                    </a><br/>");
            }
        }

        // Instanciation du dossier d'instruction concerné par la demande en cours d'ajout.
        $inst_di = $this->get_inst_dossier_instruction($this->valF['dossier_instruction']);

        /**
         * Option de numérisation.
         */
        // Si l'option est activée
        if ($this->f->is_option_digitalization_folder_enabled() === true) {
            // Création du répertoire de numérisation pour le dossier en
            // question.
            $ret = $inst_di->create_or_touch_digitalization_folder();
            // Si la création a échouée
            if ($ret !== true) {
                //
                $this->msg = "";
                $this->addToMessage(_("Erreur lors de la création du répertoire de numérisation. Contactez votre administrateur."));
                return false;
            }
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[109] Retrait de la demande -> AT
         * Déclencheur :
         *  - L'option ERP est activée
         *  - Le dossier est de type AT
         *  - Le dossier est marqué comme "connecté au référentiel ERP"
         *  - Le formulaire d'ajout de demande est validé avec un type de
         *    demande correspondant à une demande de retrait
         */
        //
        if ($this->f->is_option_referentiel_erp_enabled($this->valF['om_collectivite']) === true
            && $inst_di->is_connected_to_referentiel_erp() === true
            && $this->f->getDATDCode($inst_di->getVal($inst_di->clePrimaire)) == $this->f->getParameter('erp__dossier__nature__at')
            && in_array($this->valF["demande_type"], explode(";", $this->f->getParameter('erp__demandes__retrait__at')))) {
            //
            $infos = array(
                "dossier_instruction" => $inst_di->getVal($inst_di->clePrimaire),
            );
            //
            $ret = $this->f->send_message_to_referentiel_erp(109, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (109) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (109) du référentiel ERP OK."));
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[112] Dépôt de pièces sur une DAT -> AT
         * Déclencheur :
         *  - L'option ERP est activée
         *  - Le dossier est de type AT
         *  - Le dossier est marqué comme "connecté au référentiel ERP"
         *  - Le formulaire d'ajout de demande est validé avec un type de
         *    demande correspondant à un dépôt de pièces
         */
        //
        if ($this->f->is_option_referentiel_erp_enabled($this->valF['om_collectivite']) === true
            && $inst_di->is_connected_to_referentiel_erp() === true
            && $this->f->getDATCode($inst_di->getVal($inst_di->clePrimaire)) == $this->f->getParameter('erp__dossier__nature__at')
            && in_array($this->valF["demande_type"], explode(";", $this->f->getParameter('erp__demandes__depot_piece__at')))) {
            // Définit le type de pièce par l'état du dossier
            $type_piece = "supplementaire";
            if ($etat_di_before_instr === 'incomplet') {
                $type_piece = "complementaire";
            }
            //
            $infos = array(
                "dossier_instruction" => $inst_di->getVal($inst_di->clePrimaire),
                "type_piece" => $type_piece,
            );
            //
            $ret = $this->f->send_message_to_referentiel_erp(112, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (112) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (112) du référentiel ERP OK."));
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[110] Demande d'ouverture ERP DAT -> AT
         * Déclencheur :
         *  - L'option ERP est activée
         *  - Le dossier est de type AT
         *  - Le dossier est marqué comme "connecté au référentiel ERP"
         *  - Le formulaire d'ajout de demande est validé avec un type de
         *    demande correspondant à une demande de visite d'ouverture ERP
         */
        //
        if ($this->f->is_option_referentiel_erp_enabled($this->valF['om_collectivite']) === true
            && $inst_di->is_connected_to_referentiel_erp() === true
            && $this->f->getDATCode($inst_di->getVal($inst_di->clePrimaire)) == $this->f->getParameter('erp__dossier__nature__at')
            && in_array($this->valF["demande_type"], explode(";", $this->f->getParameter('erp__demandes__ouverture__at')))) {
            //
            $infos = array(
                "dossier_instruction" => $inst_di->getVal($inst_di->clePrimaire),
            );
            //
            $ret = $this->f->send_message_to_referentiel_erp(110, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (110) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (110) du référentiel ERP OK."));
        }

        /**
         * Interface avec le référentiel ERP.
         *
         * (WS->ERP)[107] Demande d'ouverture ERP PC -> PC
         * Déclencheur :
         *  - L'option ERP est activée
         *  - Le dossier est de type PC
         *  - Le dossier est marqué comme "connecté au référentiel ERP"
         *  - Le formulaire d'ajout de demande est validé avec un type de
         *    demande correspondant à une demande de visite d'ouverture ERP
         */
        //
        if ($this->f->is_option_referentiel_erp_enabled($this->valF['om_collectivite']) === true
            && $inst_di->is_connected_to_referentiel_erp() === true
            && $this->f->getDATCode($inst_di->getVal($inst_di->clePrimaire)) == $this->f->getParameter('erp__dossier__nature__pc')
            && in_array($this->valF["demande_type"], explode(";", $this->f->getParameter('erp__demandes__ouverture__pc')))) {
            //
            $infos = array(
                "dossier_instruction" => $inst_di->getVal($inst_di->clePrimaire),
            );
            //
            $ret = $this->f->send_message_to_referentiel_erp(107, $infos);
            if ($ret !== true) {
                $this->cleanMessage();
                $this->addToMessage(_("Une erreur s'est produite lors de la notification (107) du référentiel ERP. Contactez votre administrateur."));
                return false;
            }
            $this->addToMessage(_("Notification (107) du référentiel ERP OK."));
        }

        // À ce niveau le dossier d'instruction a été ajouté, si il est sur existant il faut qu'on lance la méthode
        // permettant de mettre à jour l'état de transmission et les tâches
        if ($inst_di->getVal('etat_transmission_platau') !== 'jamais_transmissible') {
            $trigger_platau_required_fields = $inst_di->trigger_platau_required_fields($inst_di->getVal($inst_di->clePrimaire));

            // Gestion de l'erreur
            if (! $trigger_platau_required_fields) {
                $this->addToMessage(sprintf('%s %s',
                    __("Une erreur s'est produite lors de la mise à jour de l'état de transmission du dossier."),
                    __("Veuillez contacter votre administrateur.")
                ));
                $this->correct = false;
                return false;
            }
        }

        //
        return true;
    }

    /**
     * TRIGGER - triggermodifierapres.
     *
     * - Ajout du lien demande / demandeur(s)
     *
     * @return boolean
     */
    function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        //
        $this->listeDemandeur("demande", $this->val[array_search('demande', $this->champs)]);
        if ($this->insertLinkDemandeDemandeur() == false) {
            return false;
        }
        $this->valIdDemandeur=$this->postedIdDemandeur;

        //
        return true;
    }


    /**
     * Ajout du lien avec le dossier contesté dans le cas de l'ajout d'un
     * dossier de recours.
     *
     * @return,  [type] [description]
     */
    function ajoutLienDossierConteste() {
        // Création des liens entre le dossier instruction créé et le dossier
        // contesté
        $ldd = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_dossier_dossier",
            "idx" => "]",
        ));
        // Préparation des valeurs à mettre en base
        $val['lien_dossier_dossier'] = "";
        $val['dossier_src'] = $this->valF['dossier_instruction'];
        $val['dossier_cible'] = $this->valF["autorisation_contestee"];
        $val['type_lien'] = 'auto_recours';

        return $ldd->ajouter($val);
    }


    /**
     * Gestion des liens entre les lots du DA et le nouveau dossier
     **/
    function lienLotDossierInstruction($id, $val) {
        $lot = $this->f->get_inst__om_dbform(array(
            "obj" => "lot",
            "idx" => "]",
        ));
        $lld = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_lot_demandeur",
            "idx" => "]",
        ));

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$slot
                WHERE
                    dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->valF['dossier_autorisation'])
            ),
            array(
                'origin' => __METHOD__
            )
        );
        foreach ($qres['result'] as $row) {
            // Insertion du nouveau lot
            $valLot['lot'] = "";
            $valLot['libelle'] = $rowLot['libelle'];
            $valLot['dossier_autorisation'] = null;
            $valLot['dossier'] = $this->valF['dossier_instruction'];
            $lot->ajouter($valLot);

            //Insertion des liens entre dossier et les lots
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        *
                    FROM
                        %1$slien_lot_demandeur
                    WHERE
                        lot = %2$d',
                    DB_PREFIXE,
                    intval($rowLot['lot'])
                ),
                array(
                    'origin' => __METHOD__,
                    'force_result' => true
                )
            );
            if ($qres['code'] !== 'OK') {
                return false;
            }
            
            foreach ($qres['result'] as $row) {
                $valLld["lien_lot_demandeur"] = "";
                $valLld["lot"]=$lot->valF['lot'];
                $valLld["demandeur"] = $row['demandeur'];
                $valLld["petitionnaire_principal"] = $row['petitionnaire_principal'];
                if ($lld->ajouter($valLld) === false) {
                    $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter le lien entre le lot et le dossier d'instruction.", DEBUG_MODE);
                    return false;
                }
            }

            // Récupération des données techniques du nouveau lots
            if ($this->ajoutDonneesTechniquesLots($id, $val, $rowLot['lot'], $lot->valF['lot']) === false) {
                $this->addToMessage(
                    _("Erreur lors de l'enregistrement de la demande.")." ".
                    _("Contactez votre  administrateur.")
                );
                $this->correct = false;
                $this->f->addToLog(
                    __METHOD__."(): ERROR ajoutDonneesTechniquesLots",
                    DEBUG_MODE
                );
                return false;
            }

        }

        //
        return true;
    }


    /**
     * Méthode permettant d'ajouter les données techniques d'un lot.
     *
     * @param integer  $id      identifiant de la demande
     * @param array    $val     tableau de valeurs postées via le formulaire
     * @param integer  $lotInit identifiant de lot initial
     * @param integer  $lotDest identifiant du lot qui va recevoir les données
     *
     * @return boolean false si erreur
     */
    function ajoutDonneesTechniquesLots($id, $val, $lotInit, $lotDest) {
        // Requete permettant de recupérer les données techniques du lot passé
        // en paramètre ($lotInit)
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    donnees_techniques
                FROM
                    %1$sdonnees_techniques
                WHERE
                    lot = %2$d',
                DB_PREFIXE,
                intval($lotInit)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $id_dt = $qres["result"];
        // Si des données techniques sont liées au lots on les "copie" et
        // on les lies au lot passé en paramètre (lotDest)
        if(isset($id_dt) and !empty($id_dt)) {
            $donnees_techniques = $this->f->get_inst__om_dbform(array(
                "obj" => "donnees_techniques",
                "idx" => $id_dt,
            ));

            // Récupération des données dans le tableau des valeurs à insérer
            foreach($donnees_techniques->champs as $value) {
                $val[$value] = $donnees_techniques->getVal($value);
            }
            // Modification du lien vers le nouveau lot
            $val["lot"] = $lotDest;
            // Identifiant du cerfa
            $val['cerfa'] = $this->getIdCerfa();
            // Ajout des données techniques     
            if($donnees_techniques->ajouter($val) === false) {
                $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter les données techniques du lot.", DEBUG_MODE);
                return false;
            }
        }

        //
        return true;
    }

    /**
     * Gestion des liens entre la demande et les demandeurs recemment ajoutés
     **/
    function insertLinkDemandeDemandeur() {

        foreach ($this->types_demandeur as $type) {
            // Comparaison des autres demandeurs
            if(isset($this->postedIdDemandeur[$type]) === true) {
                // Suppression des liens non valides
                foreach ($this->valIdDemandeur[$type] as $demandeur) {
                    // Demandeur
                    if(!in_array($demandeur, $this->postedIdDemandeur[$type])) {
                        if ($this->deleteLinkDemandeDemandeur($demandeur) == false) {
                            //
                            return false;
                        }
                    }
                    
                }
                // Ajout des nouveaux liens
                foreach ($this->postedIdDemandeur[$type] as $demandeur) {
                    if(!in_array($demandeur, $this->valIdDemandeur[$type])) {
                        $principal = false;
                        if(strpos($type, '_principal') !== false) {
                            $principal = true;
                        }
                        if ($this->addLinkDemandeDemandeur($demandeur, $principal) == false) {
                            //
                            return false;
                        }
                    }
                }
            }
        }

        //
        return true;
    }


    /**
     * Fonction permettant d'ajouter un lien
     * entre la table demande et demandeur
     **/
    function addLinkDemandeDemandeur($id, $principal) {
        $lienAjout = $this->f->get_inst__om_dbform(array(
            "obj" => "lien_demande_demandeur",
            "idx" => "]",
        ));
        $lien = array('lien_demande_demandeur' => "",
                           'petitionnaire_principal' => (($principal)?"t":"f"),
                           'demande' => $this->valF['demande'],
                           'demandeur' => $id);
        if ($lienAjout->ajouter($lien) === false) {
            $this->f->addToLog(__METHOD__."() : ERROR - Impossible d'ajouter le lien entre la demande et le demandeur.", DEBUG_MODE);
            return false;
        }

        //
        return true;
    }

    /**
     * Fonction permettant de supprimer un lien
     * entre la table demande et demandeur
     **/
    function deleteLinkDemandeDemandeur($id) {
        // Suppression
        $sql = "DELETE FROM ".DB_PREFIXE."lien_demande_demandeur ".
                "WHERE demande=".$this->valF['demande'].
                " AND demandeur=".$id;
        // Execution de la requete de suppression de l'objet
        $res = $this->f->db->query($sql);
        // Logger
        $this->f->addToLog(__METHOD__."(): db->query(\"".$sql."\");", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true)){
            return false;
        }

        //
        return true;
    }

    /**
     * Teste, avec une requête sql, si le lien entre la demande et
     * le demandeur passé en paramètre existe.
     *
     * @param integer identifiant du demandeur
     * @return boolean
     */
    function isLinkDemandeDemandeurExist($idDemandeur) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    count(*)
                FROM
                    %1$slien_demande_demandeur
                WHERE
                    demande = %2$d
                    AND demandeur = %3$d',
                DB_PREFIXE,
                intval($this->valF['demande']),
                intval($idDemandeur)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        if ($qres["result"] === 0) {
            $this->f->addToLog(__METHOD__."(): the query as returned 0 values", VERBOSE_MODE);
            return false;
        }

        return true;
    }

    /**
     * Methode de recupération des valeurs postées
     **/
    function getPostedValues() {
        // Récupération des demandeurs dans POST
        foreach ($this->types_demandeur as $type) {
            if($this->f->get_submitted_post_value($type) !== null AND
                    $this->f->get_submitted_post_value($type) != '') {
                $this->postedIdDemandeur[$type] = $this->f->get_submitted_post_value($type);
            }
        }
    }

    /**
     * Méthode permettant de récupérer les id des demandeurs liés à la table
     * liée passée en paramètre
     *
     * @param string $from Table liée : "demande", "dossier", dossier_autorisation"
     * @param string $id Identifiant (clé primaire de la table liée en question)
     */
    function listeDemandeur($from, $id) {
        // Récupération des demandeurs de la base
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    demandeur.demandeur,
                    demandeur.type_demandeur,
                    lien_%2$s_demandeur.petitionnaire_principal
                FROM
                    %1$slien_%2$s_demandeur
                    INNER JOIN %1$sdemandeur 
                        ON demandeur.demandeur = lien_%2$s_demandeur.demandeur 
                WHERE
                    %2$s = \'%3$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($from),
                $this->f->db->escapeSimple($id)

            ),
            array(
                'origin' => __METHOD__
            )
        );
        // Stockage du résultat dans un tableau
        foreach ($qres['result'] as $row) {
            $demandeur_type = $row['type_demandeur'];
            if ($row['petitionnaire_principal'] == 't'){
                $demandeur_type .= "_principal";
            }
            $this->valIdDemandeur[$demandeur_type][] = $row['demandeur'];
        }
    }


    /**
     * Surcharge du bouton retour afin de retourner sur la recherche de dossiers
     * d'instruction existant
     */
    function retour($premier = 0, $recherche = "", $tricol = "") {

        echo "\n<a class=\"retour\" ";
        echo "href=\"";
        //
        if($this->getParameter("idx_dossier") != "") {
            echo OM_ROUTE_TAB;
            echo "&obj=recherche_dossier";

        } else {
            if($this->getParameter("retour")=="form" AND !($this->getParameter("validation")>0 AND $this->getParameter("maj")==2 AND $this->correct)) {
                echo OM_ROUTE_FORM;
            } else {
                echo OM_ROUTE_TAB;
            }
            echo "&obj=".$this->get_absolute_class_name();
            if($this->getParameter("retour")=="form") {
                echo "&amp;idx=".$this->getParameter("idx");
                echo "&amp;action=3";
            }
        }
        echo "&amp;premier=".$this->getParameter("premier");
        echo "&amp;tricol=".$this->getParameter("tricol");
        echo "&amp;advs_id=".$this->getParameter("advs_id");
        echo "&amp;valide=".$this->getParameter("valide");
        //
        echo "\"";
        echo ">";
        //
        echo _("Retour");
        //
        echo "</a>\n";

    }


    /**
     * Cette méthode permet d'afficher des informations spécifiques dans le
     * formulaire de l'objet
     *
     * @param integer $maj Mode de mise à jour
     */
    function formSpecificContent($maj) {
        $this->display_form_specific_content($maj);
    }

    /**
     * Affiche le contenu souhaité dans la méthode formSpecificContent.
     *
     * @param  integer  $maj         Action du formulaire
     * @param  string   $contraintes Contrainte de récupération des demandeurs
     *
     * @return void
     */
    public function display_form_specific_content($maj, $contraintes = null) {
        // Tableau des demandeurs selon le contexte
        $listeDemandeur = $this->valIdDemandeur;
        /**
         * Gestion du bloc des demandeurs
         */
        // Si le mode est (modification ou suppression ou consultation) ET que
        // le formulaire n'est pas correct (c'est-à-dire que le formulaire est
        // actif) 
        if ($this->correct !== true AND
            $this->getParameter('validation') == 0 AND
            $this->getParameter("maj") != 0) {
            // Alors on récupère les demandeurs dans la table lien pour
            // affectation des résultats dans $this->valIdDemandeur
            $this->listeDemandeur("demande", $this->val[array_search('demande', $this->champs)]);
            $listeDemandeur = $this->valIdDemandeur;
        }

        // Récupération des valeurs postées
        if ($this->getParameter('validation') != 0) {
            $listeDemandeur = $this->postedIdDemandeur;
        }

        // Par défaut les demandeurs récupérés ne sont pas modifiables (linkable)
        // et l'ajout de nouveau est possible (addable)
        $linkable = false;
        $addable = true;
        // Si le mode est (ajout ou modification) ET que le formulaire n'est pas
        // correct (c'est-à-dire que le formulaire est actif)
        if ($this->getParameter("maj") < 2
            && $this->correct !== true) {
            // En fonction de la contrainte de récupération des demandeurs, les
            // possibilités sur le formulaire sont différentes
            switch ($contraintes) {
                case 'sans_recup':
                case 'avec_recup':
                    $linkable = true;
                    break;
                case 'avec_r_sm_aa':
                    $linkable = false;
                    break;
                case 'avec_r_sma':
                    $linkable = false;
                    $addable = false;
                    break;
                default:
                    $linkable = null;
                    break;
            }
        }

        // Affichage des demandeurs et des actions
        // Conteneur de la listes des demandeurs
        echo "<div id=\"liste_demandeur\" class=\"demande_hidden_bloc col_12\">";
        echo "<fieldset class=\"cadre ui-corner-all ui-widget-content\">";
        echo "  <legend class=\"ui-corner-all ui-widget-content ui-state-active\">"
                ._("Demandeurs")."</legend>";
        
        // Affichage du bloc pétitionnaire principal / délégataire
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"petitionnaire_principal_delegataire\">";
        // Affichage de la synthèse du pétitionnaire principal
        $this->displaySyntheseDemandeur($listeDemandeur, "petitionnaire_principal", $linkable, $addable);
        // L'ID DU DIV ET DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"delegataire\">";
        // Affichage de la synthèse du délégataire
        $this->displaySyntheseDemandeur($listeDemandeur, "delegataire", $linkable, $addable);
        echo "</div>";
        // L'ID DU DIV ET DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"proprietaire\">";
        // Affichage de la synthèse du délégataire
        $this->displaySyntheseDemandeur($listeDemandeur, "proprietaire", $linkable, $addable);
        echo "</div>";
        // L'ID DU DIV ET DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"architecte_lc\">";
        // Affichage de la synthèse du délégataire
        $this->displaySyntheseDemandeur($listeDemandeur, "architecte_lc", $linkable, $addable);
        echo "</div>";
        // L'ID DU DIV ET DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"paysagiste\">";
        // Affichage de la synthèse du délégataire
        $this->displaySyntheseDemandeur($listeDemandeur, "paysagiste", $linkable, $addable);
        echo "</div>";
        echo "<div class=\"both\"></div>";
        echo "</div>";
        // Bloc des pétitionnaires secondaires
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listePetitionnaires\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "petitionnaire", $linkable, $addable);
        echo "</div>";

        // Affichage du bloc pétitionnaire principal / délégataire / bailleur
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"petitionnaire_principal_delegataire_bailleur\">";
        // Doit être utilisé avec la div petitionnaire_principal_delegataire
        echo "<div id=\"listeBailleurs\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"bailleur_principal\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "bailleur_principal", $linkable, $addable);
        echo "</div>";
        echo "<div id=\"listeAutresBailleurs\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "bailleur", $linkable, $addable);
        echo "</div>";
        echo "</div>";
        echo "</div>";
        
        echo "<div id=\"plaignant_contrevenant\">";
        // Affichage du bloc contrevenant
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listeContrevenants\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"contrevenant_principal\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "contrevenant_principal", $linkable, $addable);
        echo "</div>";
        echo "<div id=\"listeAutresContrevenants\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "contrevenant", $linkable, $addable);
        echo "</div>";
        echo "</div>";
        // Affichage du bloc plaignant
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listePlaignants\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"plaignant_principal\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "plaignant_principal", $linkable, $addable);
        echo "</div>";
        echo "<div id=\"listeAutresPlaignants\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "plaignant", $linkable, $addable);
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "<div id=\"requerant_avocat\">";
        // Affichage du bloc requérant
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listeRequerants\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"requerant_principal\">";
        // Affichage de la synthèse
        $this->displaySyntheseDemandeur($listeDemandeur, "requerant_principal", $linkable, $addable);
        echo "</div>";
        echo "<div id=\"listeAutresRequerants\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "requerant", $linkable, $addable);
        echo "</div>";
        echo "</div>";
        // Affichage du bloc avocat
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"listeAvocat\" class=\"col_12\">";
        // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
        echo "<div id=\"avocat_principal\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "avocat_principal", $linkable, $addable);
        echo "</div>";
        echo "<div id=\"listeAutresAvocats\">";
        $this->displaySyntheseDemandeur($listeDemandeur, "avocat", $linkable, $addable);
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</fieldset>";
        // Champ flag permettant de récupérer la valeur de l'option sig pour
        // l'utiliser en javascript, notamment lors du chargement de l'interface
        // pour les références cadastrales
        // XXX Si un widget pour les références cadastrales existait, il n'y
        // aurait pas besoin de faire cela
        echo "<input id='option_sig' type='hidden' value='".$this->f->getParameter("option_sig")."' name='option_sig'>";
        echo "</div>";
    }

    /**
     * Affiche le formulaire spécifique des demandeurs.
     *
     * @param  array    $listeDemandeur Tableau des demandeurs
     * @param  string   $type           Type des demandeurs
     * @param  boolean  $linkable       Défini si les demandeurs sont modifiable
     * @param  boolean  $addable        Défini si des demandeurs peuvent être ajoutés
     *
     * @return void                     Affiche le formulaire
     */
    function displaySyntheseDemandeur($listeDemandeur, $type, $linkable = null, $addable = true) {
        // Si la modification des demandeurs récupérés n'est pas précisé
        if ($linkable === null) {
            // Par défaut la modification des demandeurs récupérés n'est pas possible
            $linkable = false;
            // Si le mode est (ajout ou modification) ET que le formulaire n'est pas
            // correct (c'est-à-dire que le formulaire est actif)
            if ($this->getParameter("maj") < 2
                && $this->correct !== true) {
                // La modification des demandeurs récupérés est possible
                $linkable = true;
            }
        }
        // Récupération du type de demandeur pour l'affichage
        switch ($type) {
            case 'petitionnaire_principal':
                $legend = _("Petitionnaire principal");
                break;

            case 'delegataire':
                $legend = _("Autre correspondant");
                break;
            
            case 'petitionnaire':
                $legend = _("Petitionnaire");
                break;
                
            case 'contrevenant_principal':
                $legend = _("Contrevenant principal");
                break;
                
            case 'contrevenant':
                $legend = _("Autre contrevenant");
                break;
                
            case 'plaignant_principal':
                $legend = _("Plaignant principal");
                break;
            
            case 'plaignant':
                $legend = _("Autre plaignant");
                break;
            
            case 'requerant_principal':
                $legend = _("Requérant principal");
                break;
            
            case 'requerant':
                $legend = _("Autre requérant");
                break;
            
            case 'avocat_principal':
                $legend = _("Avocat principal");
                break;
            
            case 'avocat':
                $legend = _("Autre avocat");
                break;

            case 'bailleur_principal':
                $legend = _("Bailleur principal");
                break;
            
            case 'bailleur':
                $legend = _("Autre bailleur");
                break;

            case 'proprietaire':
                $legend = __('Propriétaire');
                break;

            case 'architecte_lc':
                $legend = __('Architecte législation connexe');
                break;

            case 'paysagiste':
                $legend = __('Concepteur-Paysagiste');
                break;
        }
        foreach ($listeDemandeur[$type] as $demandeur_id) {
            $obj = str_replace('_principal', '', $type);
            $demandeur = $this->f->get_inst__om_dbform(array(
                "obj" => $obj,
                "idx" => $demandeur_id,
            ));
            $demandeur -> afficherSynthese($type, $linkable);
            $demandeur -> __destruct();
        }
        // Si en édition de formulaire
        // et qu'il est possible d'ajouter de nouveau demandeur pour ce type
        if ($addable === true
            && $this->getParameter("maj") < 2
            && $this->correct !== true) {
            // Bouton d'ajout du avocat
            // L'ID DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
            echo "<span id=\"add_".$type."\"
                class=\"om-form-button add-16\">".
                $legend.
            "</span>";
        }
    }

    // {{{

    // getter
    function getValIdDemandeur() {
        return $this->valIdDemandeur;
    }
    // setter
    function setValIdDemandeur($valIdDemandeur) {
        $this->valIdDemandeur = $valIdDemandeur;
    }

    /**
     * TRIGGER - triggersupprimer.
     *
     * - Supression du lien entre la demandeur et le(s) demandeur(s)
     *
     * @return boolean
     */
    function triggersupprimer($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        //Création de la requête
        $sql = "DELETE FROM
                    ".DB_PREFIXE."lien_demande_demandeur
                WHERE
                    demande = $id";
              
        $res = $this->f->db->query($sql);
        $this->f->addToLog(__METHOD__."() : db->query(\"".$sql."\")", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true)) {
            return false;
        }

        //
        return true;
    }


    /**
     * Récupère le champ "regeneration_cle_citoyen" du type de la demande.
     *
     * @param integer $demande_type Identifiant du type de la demande.
     *
     * @return boolean
     */
    function get_demande_type_regeneration_cle_citoyen($demande_type) {
        // Initialise le résultat
        $regeneration_cle_citoyen = false;

        // Récupère le champ depuis la demande type
        $inst_demande_type = $this->f->get_inst__om_dbform(array(
            "obj" => "demande_type",
            "idx" => $demande_type,
        ));
        if ($inst_demande_type->getVal('regeneration_cle_citoyen') === 't') {
            $regeneration_cle_citoyen = true;
        }

        // Retourne le résultat
        return $regeneration_cle_citoyen;
    }

    /**
     * Récupère les champs archive_* d'une instruction
     * @param string $dossier L'identifiant du dossier d'instruction
     */
    public function getArchiveInstruction($dossierID){

        //On récupère les données du dernier DI accordé
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier.delai,
                    dossier.accord_tacite,
                    dossier.etat, 
                    dossier.avis_decision, 
                    to_char(dossier.date_complet, \'DD/MM/YYYY\') as date_complet,
                    to_char(dossier.date_depot, \'DD/MM/YYYY\') as date_depot,
                    to_char(dossier.date_depot_mairie, \'DD/MM/YYYY\') as date_depot_mairie,
                    to_char(dossier.date_dernier_depot, \'DD/MM/YYYY\') as date_dernier_depot,
                    to_char(dossier.date_rejet, \'DD/MM/YYYY\') as date_rejet, 
                    to_char(dossier.date_limite, \'DD/MM/YYYY\') as date_limite, 
                    to_char(dossier.date_notification_delai, \'DD/MM/YYYY\') as date_notification_delai, 
                    to_char(dossier.date_decision, \'DD/MM/YYYY\') as date_decision, 
                    to_char(dossier.date_validite, \'DD/MM/YYYY\') as date_validite, 
                    to_char(dossier.date_achevement, \'DD/MM/YYYY\') as date_achevement, 
                    to_char(dossier.date_chantier, \'DD/MM/YYYY\') as date_chantier, 
                    to_char(dossier.date_conformite, \'DD/MM/YYYY\') as date_conformite, 
                    dossier.incompletude, 
                    dossier.evenement_suivant_tacite, dossier.evenement_suivant_tacite_incompletude, 
                    dossier.etat_pendant_incompletude, 
                    to_char(dossier.date_limite_incompletude, \'DD/MM/YYYY\') as date_limite_incompletude, 
                    dossier.delai_incompletude, dossier.autorite_competente, dossier.duree_validite
                    ,dossier.dossier, dossier.incomplet_notifie,
                    to_char(dossier.date_cloture_instruction, \'DD/MM/YYYY\') as date_cloture_instruction, 
                    to_char(dossier.date_premiere_visite, \'DD/MM/YYYY\') as date_premiere_visite, 
                    to_char(dossier.date_derniere_visite, \'DD/MM/YYYY\') as date_derniere_visite, 
                    to_char(dossier.date_contradictoire, \'DD/MM/YYYY\') as date_contradictoire, 
                    to_char(dossier.date_retour_contradictoire, \'DD/MM/YYYY\') as date_retour_contradictoire, 
                    to_char(dossier.date_ait, \'DD/MM/YYYY\') as date_ait, 
                    to_char(dossier.date_transmission_parquet, \'DD/MM/YYYY\') as date_transmission_parquet,
                    dossier.dossier_instruction_type as dossier_instruction_type,
                    to_char(dossier.date_affichage, \'DD/MM/YYYY\') as date_affichage
                FROM
                    %1$sdossier
                    LEFT JOIN %1$savis_decision
                        ON dossier.avis_decision = avis_decision.avis_decision
                WHERE
                    dossier.avis_decision IS NOT NULL
                    AND avis_decision.typeavis = \'F\'
                    AND dossier.dossier_autorisation = (
                        SELECT
                            dossier_autorisation.dossier_autorisation 
                        FROM
                            %1$sdossier_autorisation 
                            LEFT JOIN %1$sdossier
                                ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
                        WHERE
                            dossier = \'%2$s\')
                ORDER BY
                    dossier.version DESC',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossierID)
            ),
            array(
                'origin' => __METHOD__,
                'force_result' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            return false;
        }
        
        //Un des dosssiers d'instruction a été accordé, on récupère ses données
        if ($qres['row_count'] !== 0 ){
            
            $row = array_shift($qres['result']);
            $instruction = $this->f->get_inst__om_dbform(array(
                "obj" => "instruction",
                "idx" => "]",
            ));
            
            $instruction->setParameter("maj", 1);
            $instruction->updateArchiveData($row);
            return $instruction->valF;
        }
        //Sinon, on prend les données du P0, si ce n'est pas un P0
        else {
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        dossier.delai,
                        dossier.accord_tacite,
                        dossier.etat,
                        dossier.avis_decision,
                        dossier.date_complet,
                        dossier.date_dernier_depot,
                        dossier.date_rejet,
                        dossier.date_limite,
                        dossier.date_notification_delai,
                        dossier.date_decision,
                        dossier.date_validite,
                        dossier.date_achevement,
                        dossier.date_chantier,
                        dossier.date_conformite,
                        dossier.incompletude,
                        dossier.evenement_suivant_tacite,
                        dossier.evenement_suivant_tacite_incompletude,
                        dossier.etat_pendant_incompletude,
                        dossier.date_limite_incompletude,
                        dossier.delai_incompletude,
                        dossier.autorite_competente,
                        dossier.duree_validite,
                        dossier.dossier,
                        dossier.incomplet_notifie,
                        dossier.date_depot,
                        dossier.date_depot_mairie,
                        dossier.date_cloture_instruction,
                        dossier.date_premiere_visite,
                        dossier.date_derniere_visite,
                        dossier.date_contradictoire,
                        dossier.date_retour_contradictoire,
                        dossier.date_ait,
                        dossier.date_transmission_parquet,
                        dossier.dossier_instruction_type,
                        dossier.date_affichage
                    FROM
                        %1$sdossier
                        LEFT JOIN %1$sdossier_instruction_type
                            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    WHERE
                        dossier.dossier_autorisation = (
                            SELECT
                                dossier_autorisation.dossier_autorisation 
                            FROM
                                %1$sdossier_autorisation 
                                LEFT JOIN %1$sdossier
                                    ON dossier_autorisation.dossier_autorisation = dossier.dossier_autorisation
                            WHERE
                                dossier = \'%2$s\'
                        )
                        AND dossier_instruction_type.code = \'P\'
                    ORDER BY
                        dossier.version DESC',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($dossierID)
                ),
                array(
                    'origin' => __METHOD__,
                    'force_result' => true
                )
            );
            if ($qres['code'] !== 'OK') {
                return false;
            }
            
            //On est pas dans le cas d'un dépôt d'un P0
            if ($qres['row_count'] != 0 ){
                $row = array_shift($qres['result']);
                $instruction = $this->f->get_inst__om_dbform(array(
                    "obj" => "instruction",
                    "idx" => "]",
                ));
                $instruction->setParameter("maj", 1);
                $instruction->updateArchiveData($row);
                return $instruction->valF;
            }
        }
    }
    
    /**
     * Cette methode permet d'afficher le bouton de validation du formulaire
     *
     * @param integer $maj Mode de mise a jour
     * @return void
     */
    function bouton($maj) {
        
        if (!$this->correct
            && $this->checkActionAvailability() == true) {
            //
            switch($maj) {
                case 0 :
                    $bouton = _("Ajouter");
                    break;
                case 1 :
                    $bouton = _("Modifier");
                    break;
                case 2 :
                    $bouton = _("Supprimer");
                    break;
                default :
                    // Actions specifiques
                    if ($this->get_action_param($maj, "button") != null) {
                        //
                        $bouton = $this->get_action_param($maj, "button");
                    } else {
                        //
                        $bouton = _("Valider");
                    }
                    break;
            }
            //
            $params = array(
                "value" => $bouton,
                "name" => "submit",
                "onclick"=>"return getDataFieldReferenceCadastrale();",
            );
            //
            $this->f->layout->display_form_button($params);
        }

    }

    /**
     * Récupère l'instance de la classe taxe_amenagement.
     *
     * @param integer $om_collectivite La collectivité
     *
     * @return object
     */
    function get_inst_taxe_amenagement_by_om_collectivite($om_collectivite) {
        //
        if ($this->inst_taxe_amenagement === null) {
            //
            $taxe_amenagement = $this->get_taxe_amenagement_by_om_collectivite($om_collectivite);

            // Si aucun paramétrage de taxe trouvé et que la collectivité
            // est mono
            if ($taxe_amenagement === null
                && $this->f->isCollectiviteMono($om_collectivite) === true) {
                // Récupère la collectivité multi
                $om_collectivite_multi = $this->f->get_idx_collectivite_multi();
                //
                $taxe_amenagement = $this->get_taxe_amenagement_by_om_collectivite($om_collectivite_multi);
            }

            //
            if ($taxe_amenagement === null) {
                //
                return null;
            }

            //
            $this->inst_taxe_amenagement = $this->f->get_inst__om_dbform(array(
                "obj" => "taxe_amenagement",
                "idx" => $taxe_amenagement,
            ));
        }
        //
        return $this->inst_taxe_amenagement;
    }

    /**
     * Récupère l'identifiant de la taxe d'aménagement par rapport à la collectivité.
     *
     * @param integer $om_collectivite La collectivité
     *
     * @return integer
     */
    function get_taxe_amenagement_by_om_collectivite($om_collectivite) {
        $taxe_amenagement = null;

        // Si la collectivité n'est pas renseigné
        if ($om_collectivite !== '' && $om_collectivite !== null) {

            // SQL
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        taxe_amenagement
                    FROM
                        %1$staxe_amenagement
                    WHERE
                        om_collectivite = %2$d',
                    DB_PREFIXE,
                    intval($om_collectivite)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            $taxe_amenagement = $qres["result"];
        }

        return $taxe_amenagement;
    }


    /**
     * TODO: replace with '$this->f->findObjectById' ?
     *
     * Récupère l'instance du cerfa par le type détaillé du DA.
     *
     * @param integer $datd Identifiant du type détaillé du DA.
     *
     * @return object
     */
    protected function get_inst_cerfa_by_datd($datd = null) {
        //
        if ($this->inst_cerfa === null) {
            //
            $inst_datd = $this->get_inst_common("dossier_autorisation_type_detaille", $datd);
            //
            $cerfa = $inst_datd->getVal('cerfa');
            //
            if ($cerfa !== '' && $cerfa !== null) {
                //
                $this->inst_cerfa = $this->f->get_inst__om_dbform(array(
                    "obj" => "cerfa",
                    "idx" => $cerfa,
                ));
            }
        }

        //
        return $this->inst_cerfa;
    }


    /**
     * TODO: replace with '$this->f->findObjectById' ?
     *
     * Récupère l'instance du dossier d'autorisation.
     *
     * @param string $dossier_autorisation Identifiant du dossier d'autorisation.
     *
     * @return object
     */
    function get_inst_dossier_autorisation($dossier_autorisation = null) {
        //
        return $this->get_inst_common("dossier_autorisation", $dossier_autorisation);
    }

    /**
     * Vérifie si un dossier d'autorisation avec cette numérotation existe déjà.
     *
     * @return boolean
     */
    function existsDAWithNumeroDossierSeq($idDAdt, $date_demande, $collectivite_id, $num_doss_seq, $commune_id = null, $code_depcom = null) {

        if (empty($idDAdt) || empty($date_demande) || empty($collectivite_id) || empty($num_doss_seq)) {
            return false;
        }

        if ($this->f->is_option_dossier_commune_enabled($collectivite_id) === true
            && empty($commune_id) === true) {
            //
            return false;
        }

        // code du type de DA
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    da_t.code
                FROM
                    %1$sdossier_autorisation_type as da_t
                    INNER JOIN %1$sdossier_autorisation_type_detaille as da_t_d
                        ON da_t.dossier_autorisation_type = da_t_d.dossier_autorisation_type
                WHERE
                    da_t_d.dossier_autorisation_type_detaille = %2$d',
                DB_PREFIXE,
                intval($idDAdt)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $code_type_da = $qres["result"];

        // annee date demande
        $annee = date('y', strtotime($date_demande));

        // code département et commune
        if (empty($code_depcom) === true) {
            if ($this->f->is_option_dossier_commune_enabled($collectivite_id) === false) {
                $collectivite_parameters = $this->f->getCollectivite($collectivite_id);
                if (!isset($collectivite_parameters['departement'])) {
                    $this->f->addToLog(__METHOD__."(): ERROR om_parametre 'departement' inexistant.",
                                       DEBUG_MODE);
                    return false;
                }
                if (!isset($collectivite_parameters['commune'])) {
                    $this->f->addToLog(__METHOD__."(): ERROR om_parametre 'commune' inexistant.",
                                       DEBUG_MODE);
                    return false;
                }
                $departement = strtoupper($collectivite_parameters['departement']);
                $commune = $collectivite_parameters['commune'];
                $code_depcom = $departement.$commune;
            } else {
                //
                $getCodeDepartementCommuneFromCommune = $this->getCodeDepartementCommuneFromCommune($commune_id);
                $code_depcom = $getCodeDepartementCommuneFromCommune[0];
            }
        }

        // construction de la requête
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation
                FROM
                    %1$sdossier_autorisation
                WHERE
                    dossier_autorisation LIKE \'%2$s%3$s%4$s%%%5$s\'',
                DB_PREFIXE,
                $code_type_da,
                $code_depcom,
                $annee,
                str_pad($num_doss_seq, 4, '0', STR_PAD_LEFT)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] === "OK"
            && $qres["result"] !== ""
            && $qres["result"] !== null) {
            return true;
        }
        return false;
    }

    /**
     * Concatenation du code département et du code commune
     * obtenus à partir de la collectivité (collectivité par défaut si aucun id fourni).
     * Renvoie un tuple (code_depcom, error_msg).
     */
    protected function getCodeDepartementCommuneFromCommune(int $commune_id) : array {
        $code_depcom = null;
        $error_msg = null;
        if (!empty($commune_id)) {
            $commune = $this->f->findObjectById("commune", $commune_id);
            if (!empty($commune)) {
                $code_departement = strtoupper($commune->getVal('dep'));
                
                if(strpos(strtoupper($commune->getVal('com')), $code_departement) !== 0){
                    $error_msg = sprintf(__("code département (%s) différent du début du code commune (%s)."), 
                                         $code_departement, strtoupper($commune->getVal('com')));
                    return array(null, $error_msg);
                }

                $code_commune = preg_replace('/^'.$code_departement.'/', '', strtoupper($commune->getVal('com')));
                if(!is_numeric($code_departement) && ! in_array($code_departement, array('2A', '2B'))) {
                    $error_msg = sprintf(__("code département invalide (%s). Doit être numérique ou 2A|2B."),
                                         $code_departement);
                }
                else if (!is_numeric($code_commune)) {
                    $error_msg = sprintf(__("code commune invalide (%s). Doit être numérique."),
                                         $code_commune);
                }
                else {
                    $code_depcom = str_pad($code_departement, 3, '0', STR_PAD_LEFT)
                                  .str_pad($code_commune, 3, '0', STR_PAD_LEFT);
                }
            }
            else {
                $error_msg = sprintf(__("commune ID '%d' inexistante"), $commune_id);
            }
        }
        if (!empty($error_msg)) {
            $this->f->addToLog(__METHOD__."(): ERROR $error_msg", DEBUG_MODE);
        }
        return array($code_depcom, $error_msg);
    }

}


