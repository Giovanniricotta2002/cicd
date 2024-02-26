<?php
/**
 * DBFORM - 'dossier_autorisation' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'dossier_autorisation'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/dossier_autorisation.class.php";

class dossier_autorisation extends dossier_autorisation_gen {

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

    /**
     * Instance de la classe dossier_autorisation_type.
     *
     * @var null
     */
    var $inst_dossier_autorisation_type = null;

    /**
     * Instance de la classe dossier_autorisation_type_detaille.
     *
     * @var null
     */
    var $inst_dossier_autorisation_type_detaille = null;

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        
        parent::init_class_actions();

        // ACTION - 003 - view_consulter
        // Interface spécifique du formulaire de consultation
        $this->class_actions[3] = array(
            "identifier" => "view_consulter",
            "view" => "view_consulter",
            "permission_suffix" => "consulter",
            "condition" => "is_dossier_autorisation_visible",
        );

        // ACTION - 004 - view_document_numerise
        // Interface spécifique du tableau des pièces
        $this->class_actions[4] = array(
            "identifier" => "view_document_numerise",
            "view" => "view_document_numerise",
            "permission_suffix" => "document_numerise",
        );

        // ACTION - 777 - Redirection vers la classe fille adéquate
        // 
        $this->class_actions[777] = array(
            "identifier" => "redirect",
            "view" => "redirect",
            "permission_suffix" => "consulter",
        );

        //
        //
        $this->class_actions[998] = array(
            "identifier" => "json_data",
            "view" => "view_json_data",
            "permission_suffix" => "consulter",
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_arrondissement() {
        return "SELECT arrondissement.arrondissement, arrondissement.libelle FROM ".DB_PREFIXE."arrondissement ORDER BY NULLIF(arrondissement.libelle,'')::int ASC NULLS LAST";
    }

    /**
     * VIEW - view_document_numerise.
     *
     * Vue du tableau des pièces du dossier d'autorisation.
     *
     * Cette vue permet de gérer le contenu de l'onglet "Pièce(s)" sur un 
     * dossier d'autorisation. Cette vue spécifique est nécessaire car
     * l'ergonomie standard du framework ne prend pas en charge ce cas.
     * C'est ici la vue spécifique des pièces liées au dossier qui est
     * affichée directement au clic de l'onglet au lieu du soustab.
     * 
     * L'idée est donc de simuler l'ergonomie standard en créant un container 
     * et d'appeler la méthode javascript 'ajaxit' pour charger le contenu 
     * de la vue visualisation de l'objet lié.
     * 
     * @return void
     */
    function view_document_numerise() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Récupération des variables GET
        ($this->f->get_submitted_get_value('idxformulaire')!==null ? $idxformulaire = 
            $this->f->get_submitted_get_value('idxformulaire') : $idxformulaire = "");
        ($this->f->get_submitted_get_value('retourformulaire')!==null ? $retourformulaire = 
            $this->f->get_submitted_get_value('retourformulaire') : $retourformulaire = "");
        // Objet à charger
        $obj = "document_numerise";
        // Construction de l'url de sousformulaire à appeler
        $url = OM_ROUTE_SOUSFORM."&obj=".$obj;
        $url .= "&idx=".$idxformulaire;
        $url .= "&action=4";
        $url .= "&retourformulaire=".$retourformulaire;
        $url .= "&idxformulaire=".$idxformulaire;
        $url .= "&retour=form";
        // Affichage du container permettant le reffraichissement du contenu
        // dans le cas des action-direct.
        printf('
            <div id="sousform-href" data-href="%s">
            </div>',
            $url
        );
        // Affichage du container permettant de charger le retour de la requête
        // ajax récupérant le sous formulaire.
        printf('
            <div id="sousform-%s">
            </div>
            <script>
            ajaxIt(\'%s\', \'%s\');
            </script>',
            $obj,
            $obj,
            $url
        );
    }


    /**
     * Affiche la fiche du dossier d'autorisation passé en paramètre.
     *
     * @param string  $idx           Identifiant du DA.
     * @param mixed   $bouton_retour Affiche ou non le bouton retour.
     * @param boolean $display_cerfa Affiche ou non l'overlay sur le CERFA.
     *
     * @return void
     */
    protected function display_dossier_autorisation_data($idx, $bouton_retour, $display_cerfa = true) {
        // Liste des templates pour l'affichage d'un DA
        // Templates pour le tableau listant les lots
        $template_table_lots = '
        <table class="tab-tab">
            <thead>
                <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                    <th class="title col-0 firstcol"><span class="name">%1$s</span></th>
                    <th class="title col-1"><span class="name">%2$s</span></th>
                </tr>
            </thead>
            <tbody>%3$s</tbody>
        </table>';
        //
        $template_cell_lots = '
        <tr class="tab-data %1$s">
            <td class="col-0 firstcol">%2$s</td>
            <td class="col-1">%3$s</td>
        </tr>
        ';

        //Récupération des données
        //Données du dossier d'autorisation
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation_libelle,
                    commune.libelle AS commune_libelle,
                    CASE
                        WHEN etat_dernier_dossier_instruction_accepte IS NULL THEN eda.libelle
                        ELSE edda.libelle
                    END as etat,
                    CASE
                        WHEN demandeur.qualite = \'particulier\' THEN TRIM(
                            CONCAT(
                                civilite.code,
                                \' \',
                                demandeur.particulier_nom,
                                \' \',
                                demandeur.particulier_prenom
                            )
                        )
                        ELSE TRIM(
                            CONCAT(
                                demandeur.personne_morale_raison_sociale,
                                \' \',
                                demandeur.personne_morale_denomination
                            )
                        )
                    END as "demandeur",
                    TRIM(
                        CONCAT_WS(
                            \' \',
                            replace(
                                dossier_autorisation.terrain_references_cadastrales,
                                \';\',
                                \' \'
                            ),
                            \'<br/>\',
                            CASE
                                WHEN dossier_autorisation.adresse_normalisee IS NULL
                                OR TRIM(dossier_autorisation.adresse_normalisee) = \'\' THEN
                                    '.DB_PREFIXE.'adresse(
                                        dossier_autorisation.terrain_adresse_voie_numero::text,
                                        dossier_autorisation.terrain_adresse_voie::text,
                                        \'\'::text,
                                        dossier_autorisation.terrain_adresse_lieu_dit::text,
                                        dossier_autorisation.terrain_adresse_bp::text,
                                        dossier_autorisation.terrain_adresse_code_postal::text,
                                        dossier_autorisation.terrain_adresse_localite::text,
                                        dossier_autorisation.terrain_adresse_cedex::text,
                                        \'\'::text,
                                        \', \'::text
                                    )
                                ELSE dossier_autorisation.adresse_normalisee
                            END
                        )
                    ) as "infos_localisation_terrain",
                    to_char(depot_initial, \'DD/MM/YYYY\') as "depot_initial",
                    to_char(date_decision, \'DD/MM/YYYY\') as "date_decision",
                    to_char(date_validite, \'DD/MM/YYYY\') as "date_validite",
                    to_char(date_chantier, \'DD/MM/YYYY\') as "date_chantier",
                    to_char(date_achevement, \'DD/MM/YYYY\') as "date_achevement",
                    dossier_autorisation_type_detaille.libelle as "type_detaille"
                FROM
                    %1$sdossier_autorisation
                    LEFT JOIN %1$setat_dossier_autorisation as eda 
                        ON dossier_autorisation.etat_dossier_autorisation = eda.etat_dossier_autorisation
                    LEFT JOIN %1$setat_dossier_autorisation as edda 
                        ON dossier_autorisation.etat_dernier_dossier_instruction_accepte = edda.etat_dossier_autorisation
                    LEFT JOIN %1$slien_dossier_autorisation_demandeur 
                        ON dossier_autorisation.dossier_autorisation = lien_dossier_autorisation_demandeur.dossier_autorisation
                    LEFT JOIN %1$sdemandeur 
                        ON lien_dossier_autorisation_demandeur.demandeur = demandeur.demandeur
                    LEFT JOIN %1$scivilite 
                        ON civilite.civilite = demandeur.particulier_civilite
                        OR civilite.civilite = demandeur.personne_morale_civilite
                    LEFT JOIN %1$sdossier_autorisation_type_detaille 
                        ON dossier_autorisation_type_detaille.dossier_autorisation_type_detaille = dossier_autorisation.dossier_autorisation_type_detaille
                    LEFT JOIN %1$scommune 
                        ON commune.commune = dossier_autorisation.commune
                WHERE
                    lien_dossier_autorisation_demandeur.petitionnaire_principal IS TRUE
                    AND dossier_autorisation.dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idx)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        $rowDonneesDA = array_shift($qres['result']);
                
        //Récupération des données principales des données techniques rattachées au DA
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    donnees_techniques as "donnees_techniques",
                    CONCAT_WS(
                        \'<br/>\',
                        CASE
                            WHEN co_projet_desc = \'\' THEN NULL
                            ELSE TRIM(co_projet_desc)
                        END,
                        CASE
                            WHEN ope_proj_desc = \'\' THEN NULL
                            ELSE TRIM(ope_proj_desc)
                        END,
                        CASE
                            WHEN am_projet_desc = \'\' THEN NULL
                            ELSE TRIM(am_projet_desc)
                        END,
                        CASE
                            WHEN dm_projet_desc = \'\' THEN NULL
                            ELSE TRIM(dm_projet_desc)
                        END
                    ) as "description_projet",
                    -- Si une valeur est saisie dans la deuxième version du tableau des
                    -- surfaces alors on récupère seulement ses valeurs
                    CASE
                        WHEN su2_avt_shon1 IS NOT NULL
                        OR su2_avt_shon2 IS NOT NULL
                        OR su2_avt_shon3 IS NOT NULL
                        OR su2_avt_shon4 IS NOT NULL
                        OR su2_avt_shon5 IS NOT NULL
                        OR su2_avt_shon6 IS NOT NULL
                        OR su2_avt_shon7 IS NOT NULL
                        OR su2_avt_shon8 IS NOT NULL
                        OR su2_avt_shon9 IS NOT NULL
                        OR su2_avt_shon10 IS NOT NULL
                        OR su2_avt_shon11 IS NOT NULL
                        OR su2_avt_shon12 IS NOT NULL
                        OR su2_avt_shon13 IS NOT NULL
                        OR su2_avt_shon14 IS NOT NULL
                        OR su2_avt_shon15 IS NOT NULL
                        OR su2_avt_shon16 IS NOT NULL
                        OR su2_avt_shon17 IS NOT NULL
                        OR su2_avt_shon18 IS NOT NULL
                        OR su2_avt_shon19 IS NOT NULL
                        OR su2_avt_shon20 IS NOT NULL
                        OR su2_avt_shon21 IS NOT NULL
                        OR su2_avt_shon22 IS NOT NULL
                        OR su2_cstr_shon1 IS NOT NULL
                        OR su2_cstr_shon2 IS NOT NULL
                        OR su2_cstr_shon3 IS NOT NULL
                        OR su2_cstr_shon4 IS NOT NULL
                        OR su2_cstr_shon5 IS NOT NULL
                        OR su2_cstr_shon6 IS NOT NULL
                        OR su2_cstr_shon7 IS NOT NULL
                        OR su2_cstr_shon8 IS NOT NULL
                        OR su2_cstr_shon9 IS NOT NULL
                        OR su2_cstr_shon10 IS NOT NULL
                        OR su2_cstr_shon11 IS NOT NULL
                        OR su2_cstr_shon12 IS NOT NULL
                        OR su2_cstr_shon13 IS NOT NULL
                        OR su2_cstr_shon14 IS NOT NULL
                        OR su2_cstr_shon15 IS NOT NULL
                        OR su2_cstr_shon16 IS NOT NULL
                        OR su2_cstr_shon17 IS NOT NULL
                        OR su2_cstr_shon18 IS NOT NULL
                        OR su2_cstr_shon19 IS NOT NULL
                        OR su2_cstr_shon20 IS NOT NULL
                        OR su2_cstr_shon21 IS NOT NULL
                        OR su2_cstr_shon22 IS NOT NULL
                        OR su2_chge_shon1 IS NOT NULL
                        OR su2_chge_shon2 IS NOT NULL
                        OR su2_chge_shon3 IS NOT NULL
                        OR su2_chge_shon4 IS NOT NULL
                        OR su2_chge_shon5 IS NOT NULL
                        OR su2_chge_shon6 IS NOT NULL
                        OR su2_chge_shon7 IS NOT NULL
                        OR su2_chge_shon8 IS NOT NULL
                        OR su2_chge_shon9 IS NOT NULL
                        OR su2_chge_shon10 IS NOT NULL
                        OR su2_chge_shon11 IS NOT NULL
                        OR su2_chge_shon12 IS NOT NULL
                        OR su2_chge_shon13 IS NOT NULL
                        OR su2_chge_shon14 IS NOT NULL
                        OR su2_chge_shon15 IS NOT NULL
                        OR su2_chge_shon16 IS NOT NULL
                        OR su2_chge_shon17 IS NOT NULL
                        OR su2_chge_shon18 IS NOT NULL
                        OR su2_chge_shon19 IS NOT NULL
                        OR su2_chge_shon20 IS NOT NULL
                        OR su2_chge_shon21 IS NOT NULL
                        OR su2_chge_shon22 IS NOT NULL
                        OR su2_demo_shon1 IS NOT NULL
                        OR su2_demo_shon2 IS NOT NULL
                        OR su2_demo_shon3 IS NOT NULL
                        OR su2_demo_shon4 IS NOT NULL
                        OR su2_demo_shon5 IS NOT NULL
                        OR su2_demo_shon6 IS NOT NULL
                        OR su2_demo_shon7 IS NOT NULL
                        OR su2_demo_shon8 IS NOT NULL
                        OR su2_demo_shon9 IS NOT NULL
                        OR su2_demo_shon10 IS NOT NULL
                        OR su2_demo_shon11 IS NOT NULL
                        OR su2_demo_shon12 IS NOT NULL
                        OR su2_demo_shon13 IS NOT NULL
                        OR su2_demo_shon14 IS NOT NULL
                        OR su2_demo_shon15 IS NOT NULL
                        OR su2_demo_shon16 IS NOT NULL
                        OR su2_demo_shon17 IS NOT NULL
                        OR su2_demo_shon18 IS NOT NULL
                        OR su2_demo_shon19 IS NOT NULL
                        OR su2_demo_shon20 IS NOT NULL
                        OR su2_demo_shon21 IS NOT NULL
                        OR su2_demo_shon22 IS NOT NULL
                        OR su2_sup_shon1 IS NOT NULL
                        OR su2_sup_shon2 IS NOT NULL
                        OR su2_sup_shon3 IS NOT NULL
                        OR su2_sup_shon4 IS NOT NULL
                        OR su2_sup_shon5 IS NOT NULL
                        OR su2_sup_shon6 IS NOT NULL
                        OR su2_sup_shon7 IS NOT NULL
                        OR su2_sup_shon8 IS NOT NULL
                        OR su2_sup_shon9 IS NOT NULL
                        OR su2_sup_shon10 IS NOT NULL
                        OR su2_sup_shon11 IS NOT NULL
                        OR su2_sup_shon12 IS NOT NULL
                        OR su2_sup_shon13 IS NOT NULL
                        OR su2_sup_shon14 IS NOT NULL
                        OR su2_sup_shon15 IS NOT NULL
                        OR su2_sup_shon16 IS NOT NULL
                        OR su2_sup_shon17 IS NOT NULL
                        OR su2_sup_shon18 IS NOT NULL
                        OR su2_sup_shon19 IS NOT NULL
                        OR su2_sup_shon20 IS NOT NULL
                        OR su2_sup_shon21 IS NOT NULL
                        OR su2_sup_shon22 IS NOT NULL THEN REGEXP_REPLACE(
                            CONCAT(
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon1 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Exploitation agricole - \',
                                        donnees_techniques.su2_cstr_shon1,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon2 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Exploitation forestière - \',
                                        donnees_techniques.su2_cstr_shon2,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon3 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Logement - \',
                                        donnees_techniques.su2_cstr_shon3,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon4 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Hébergement - \',
                                        donnees_techniques.su2_cstr_shon4,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon5 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Artisanat et commerce de détail - \',
                                        donnees_techniques.su2_cstr_shon5,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon6 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Restauration - \',
                                        donnees_techniques.su2_cstr_shon6,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon7 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Commerce de gros - \',
                                        donnees_techniques.su2_cstr_shon7,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon8 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Activités de services où s\'\'effectue l\'\'accueil d\'\'une clientèle - \',
                                        donnees_techniques.su2_cstr_shon8,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon9 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Hébergement hôtelier et touristique - \',
                                        donnees_techniques.su2_cstr_shon9,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon10 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Cinéma - \',
                                        donnees_techniques.su2_cstr_shon10,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon21 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Hôtels - \',
                                        donnees_techniques.su2_cstr_shon21,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon22 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Autres hébergements touristiques - \',
                                        donnees_techniques.su2_cstr_shon22,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon11 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Locaux et bureaux accueillant du public des administrations publiques et assimilés - \',
                                        donnees_techniques.su2_cstr_shon11,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon12 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Locaux techniques et industriels des administrations publiques et assimilés - \',
                                        donnees_techniques.su2_cstr_shon12,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon13 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Établissements d\'\'enseignement, de santé et d\'\'action sociale - \',
                                        donnees_techniques.su2_cstr_shon13,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon14 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Salles d\'\'art et de spectacles - \',
                                        donnees_techniques.su2_cstr_shon14,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon15 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Équipements sportifs - \',
                                        donnees_techniques.su2_cstr_shon15,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon16 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Autres équipements recevant du public - \',
                                        donnees_techniques.su2_cstr_shon16,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon17 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Industrie - \',
                                        donnees_techniques.su2_cstr_shon17,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon18 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Entrepôt - \',
                                        donnees_techniques.su2_cstr_shon18,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon19 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Bureau - \',
                                        donnees_techniques.su2_cstr_shon19,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su2_cstr_shon20 IS NULL THEN \'\'
                                    ELSE CONCAT (
                                        \'Centre de congrès et d\'\'exposition - \',
                                        donnees_techniques.su2_cstr_shon20,
                                        \' m²\'
                                    )
                                END
                            ),
                            \' <br/>$\',
                            \'\'
                        )
                        ELSE REGEXP_REPLACE(
                            CONCAT(
                                CASE
                                    WHEN donnees_techniques.su_cstr_shon1 IS NULL THEN \'\'
                                    ELSE CONCAT(
                                        \'Habitation - \',
                                        donnees_techniques.su_cstr_shon1,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su_cstr_shon2 IS NULL THEN \'\'
                                    ELSE CONCAT(
                                        \'Hébergement hôtelier - \',
                                        donnees_techniques.su_cstr_shon2,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su_cstr_shon3 IS NULL THEN \'\'
                                    ELSE CONCAT(
                                        \'Bureaux - \',
                                        donnees_techniques.su_cstr_shon3,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su_cstr_shon4 IS NULL THEN \'\'
                                    ELSE CONCAT(
                                        \'Commerce - \',
                                        donnees_techniques.su_cstr_shon4,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su_cstr_shon5 IS NULL THEN \'\'
                                    ELSE CONCAT(
                                        \'Artisanat - \',
                                        donnees_techniques.su_cstr_shon5,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su_cstr_shon6 IS NULL THEN \'\'
                                    ELSE CONCAT(
                                        \'Industrie - \',
                                        donnees_techniques.su_cstr_shon6,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su_cstr_shon7 IS NULL THEN \'\'
                                    ELSE CONCAT(
                                        \'Exploitation agricole ou forestière - \',
                                        donnees_techniques.su_cstr_shon7,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su_cstr_shon8 IS NULL THEN \'\'
                                    ELSE CONCAT(
                                        \'Entrepôt - \',
                                        donnees_techniques.su_cstr_shon8,
                                        \' m² <br/>\'
                                    )
                                END,
                                CASE
                                    WHEN donnees_techniques.su_cstr_shon9 IS NULL THEN \'\'
                                    ELSE CONCAT(
                                        \'Service public ou d\'\'intérêt collectif - \',
                                        donnees_techniques.su_cstr_shon9,
                                        \' m²\'
                                    )
                                END
                            ),
                            \' <br/>$\',
                            \'\'
                        )
                    END as "surface",
                    co_tot_ind_nb as "nombre_logement_crees_individuel",
                    co_tot_coll_nb as "nombre_logement_crees_collectif"
                FROM
                    %1$sdonnees_techniques
                WHERE
                    dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idx)
            ),
            array(
                'origin' => __METHOD__
            )
        );
        $rowPrincDonneesTechniques = array_shift($qres['result']);
        
        //Historique des décisions du dossier d'autorisation
        $resDonneesDecisionsDA = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    avis_decision.libelle as "avis_libelle",
                    dossier_instruction_type.libelle as "di_libelle",
                    civilite.code as "code",
                    CASE
                        WHEN demandeur.qualite = \'particulier\' THEN TRIM(
                            CONCAT(
                                demandeur.particulier_nom,
                                \' \',
                                demandeur.particulier_prenom
                            )
                        )
                        ELSE TRIM(
                            CONCAT(
                                demandeur.personne_morale_raison_sociale,
                                \' \',
                                demandeur.personne_morale_denomination
                            )
                        )
                    END as "demandeur",
                    to_char(dossier.date_decision, \'DD/MM/YYYY\') as "date_decision"
                FROM
                    %1$sdossier
                    LEFT JOIN %1$sdossier_instruction_type
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    LEFT JOIN %1$slien_dossier_demandeur
                        ON dossier.dossier = lien_dossier_demandeur.dossier
                    LEFT JOIN %1$sdemandeur
                        ON lien_dossier_demandeur.demandeur = demandeur.demandeur
                    LEFT JOIN %1$savis_decision
                        ON dossier.avis_decision = avis_decision.avis_decision
                    LEFT JOIN %1$scivilite
                        ON civilite.civilite = demandeur.particulier_civilite
                        OR civilite.civilite = demandeur.personne_morale_civilite
                WHERE
                    dossier.dossier_autorisation = \'%2$s\'
                    AND dossier.avis_decision IS NOT NULL
                    AND demandeur.type_demandeur = \'petitionnaire\'
                    AND lien_dossier_demandeur.petitionnaire_principal = true
                    AND dossier_instruction_type.sous_dossier IS NOT TRUE
                ORDER BY
                    dossier.date_decision ASC',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idx)
            ),
            array(
                'origin' => __METHOD__
            )
        );

        // Récupèration des lots liés au dossier d'autorisation
        $res_da_list_lot = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    lot.libelle,
                    CASE WHEN demandeur_lot.qualite = \'particulier\'
                        THEN TRIM(
                            CONCAT_WS(
                                \' \',
                                civilite_lot.code,
                                demandeur_lot.particulier_nom,
                                demandeur_lot.particulier_prenom))
                        ELSE TRIM(
                            CONCAT_WS(
                                \' \',
                                demandeur_lot.personne_morale_raison_sociale,
                                demandeur_lot.personne_morale_denomination)) 
                    END as demandeur
                FROM
                    %1$slot
                    LEFT JOIN %1$slien_lot_demandeur
                        ON lot.lot = lien_lot_demandeur.lot
                    LEFT JOIN %1$sdemandeur as demandeur_lot
                        ON lien_lot_demandeur.demandeur = demandeur_lot.demandeur
                        AND lien_lot_demandeur.petitionnaire_principal IS TRUE
                    LEFT JOIN %1$scivilite as civilite_lot
                        ON demandeur_lot.particulier_civilite = civilite_lot.civilite
                        OR demandeur_lot.personne_morale_civilite = civilite_lot.civilite
                    LEFT JOIN %1$sdossier
                        ON lot.dossier = dossier.dossier
                    LEFT JOIN %1$sdossier_instruction_type
                        ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                WHERE
                    lot.dossier_autorisation = \'%2$s\' AND
                    dossier_instruction_type.sous_dossier IS NOT TRUE
                ORDER BY
                    lot.lot',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idx)
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        //Historique des décisions
        $histo_decisions = '';
        if (count($resDonneesDecisionsDA) > 0 ){

            // Entête de tableau
            $header = '
            <table class="tab-tab">
                <thead>
                    <tr class="ui-tabs-nav ui-accordion ui-state-default tab-title">
                        <th class="title col-0 firstcol">
                            <span class="name">
                            %s
                            </span>
                        </th>
                        <th class="title col-0 firstcol">
                            <span class="name">
                            %s
                            </span>
                        </th>
                        <th class="title col-0 firstcol">
                            <span class="name">
                            %s
                            </span>
                        </th>
                        <th class="title col-0 firstcol">
                            <span class="name">
                            %s
                            </span>
                        </th>
                    </tr>
                </thead>
            ';
            $histo_decisions .= sprintf($header, _('Decision'), _('Type de dossier'),
                _('Demandeur'), _('date_decision'));

            $histo_decisions .= '<tbody>';

            foreach ($resDonneesDecisionsDA['result'] as $rowDonneesDecisionsDA) {

                $content = '
                    <tr class="tab-data odd">
                        <td class="col-1 firstcol">
                        %s
                        </td>
                        <td class="col-1 firstcol">
                        %s
                        </td>
                        <td class="col-1">
                        %s
                        </td>
                        <td class="col-1">
                        %s
                        </td>
                    </tr>
                    ';
                $histo_decisions .= sprintf($content, $rowDonneesDecisionsDA["avis_libelle"], 
                    $rowDonneesDecisionsDA["di_libelle"], 
                    $rowDonneesDecisionsDA["code"]." ".$rowDonneesDecisionsDA["demandeur"],
                    $rowDonneesDecisionsDA["date_decision"]);
            }

            $histo_decisions .= '</tbody></table>';
        }
        else {
            $histo_decisions .= "<span class='no-value'>" . _("Aucune decision liee a ce dossier d'autorisation."). "</span>";
        }

        // Affiche le bouton des données technique
        $donnees_techniques = '';
        if ($rowPrincDonneesTechniques['donnees_techniques'] != ''
            && $display_cerfa === true
            && $this->f->isAccredited(array('donnees_techniques', 'donnees_techniques_consulter'), 'OR') === true) {

            // Toutes les données du cerfa
            $donnees_techniques = sprintf ("<a><span id=\"donnees_techniques_da\" class=\"om-prev-icon om-icon-16 om-form-button\"
            onclick=\"popupIt('donnees_techniques',
            '".OM_ROUTE_SOUSFORM."&obj=donnees_techniques&action=4&idx=".$rowPrincDonneesTechniques['donnees_techniques']."'+
            '&idxformulaire=".$idx."&retourformulaire=dossier_autorisation', 860, 'auto',
            '', '');\"".
            ">%s</span></a>", __("Cliquez pour voir les données techniques / CERFA"));
        }

        //
        if ($bouton_retour !== false) {
            //
            printf("<div class=\"formControls formControls-top\">%s</div>", $bouton_retour);
        } else {
            //
            printf("<h3>%s</h3>", $rowDonneesDA["dossier_autorisation_libelle"]);
        }

        // Données techniques à récupérer depuis la requête SQL sur les DI en
        // cours
        $select_di_dt = sprintf('
            CONCAT_WS(
                \'<br/>\',
                CASE
                    WHEN %1$sco_projet_desc = \'\'
                    THEN NULL
                    ELSE TRIM(%1$sco_projet_desc)
                END,
                CASE
                    WHEN %1$sope_proj_desc = \'\'
                    THEN NULL
                    ELSE TRIM(%1$sope_proj_desc)
                END,
                CASE
                    WHEN %1$sam_projet_desc = \'\'
                    THEN NULL
                    ELSE TRIM(%1$sam_projet_desc)
                END,
                CASE
                    WHEN %1$sdm_projet_desc = \'\'
                    THEN NULL
                    ELSE TRIM(%1$sdm_projet_desc)
                END
            ) AS description_projet,
            CASE
                WHEN %1$ssu2_avt_shon1 IS NOT NULL
                    OR %1$ssu2_avt_shon2 IS NOT NULL
                    OR %1$ssu2_avt_shon3 IS NOT NULL
                    OR %1$ssu2_avt_shon4 IS NOT NULL
                    OR %1$ssu2_avt_shon5 IS NOT NULL
                    OR %1$ssu2_avt_shon6 IS NOT NULL
                    OR %1$ssu2_avt_shon7 IS NOT NULL
                    OR %1$ssu2_avt_shon8 IS NOT NULL
                    OR %1$ssu2_avt_shon9 IS NOT NULL
                    OR %1$ssu2_avt_shon10 IS NOT NULL
                    OR %1$ssu2_avt_shon11 IS NOT NULL
                    OR %1$ssu2_avt_shon12 IS NOT NULL
                    OR %1$ssu2_avt_shon13 IS NOT NULL
                    OR %1$ssu2_avt_shon14 IS NOT NULL
                    OR %1$ssu2_avt_shon15 IS NOT NULL
                    OR %1$ssu2_avt_shon16 IS NOT NULL
                    OR %1$ssu2_avt_shon17 IS NOT NULL
                    OR %1$ssu2_avt_shon18 IS NOT NULL
                    OR %1$ssu2_avt_shon19 IS NOT NULL
                    OR %1$ssu2_avt_shon20 IS NOT NULL
                    OR %1$ssu2_avt_shon21 IS NOT NULL
                    OR %1$ssu2_avt_shon22 IS NOT NULL
                    OR %1$ssu2_cstr_shon1 IS NOT NULL
                    OR %1$ssu2_cstr_shon2 IS NOT NULL
                    OR %1$ssu2_cstr_shon3 IS NOT NULL
                    OR %1$ssu2_cstr_shon4 IS NOT NULL
                    OR %1$ssu2_cstr_shon5 IS NOT NULL
                    OR %1$ssu2_cstr_shon6 IS NOT NULL
                    OR %1$ssu2_cstr_shon7 IS NOT NULL
                    OR %1$ssu2_cstr_shon8 IS NOT NULL
                    OR %1$ssu2_cstr_shon9 IS NOT NULL
                    OR %1$ssu2_cstr_shon10 IS NOT NULL
                    OR %1$ssu2_cstr_shon11 IS NOT NULL
                    OR %1$ssu2_cstr_shon12 IS NOT NULL
                    OR %1$ssu2_cstr_shon13 IS NOT NULL
                    OR %1$ssu2_cstr_shon14 IS NOT NULL
                    OR %1$ssu2_cstr_shon15 IS NOT NULL
                    OR %1$ssu2_cstr_shon16 IS NOT NULL
                    OR %1$ssu2_cstr_shon17 IS NOT NULL
                    OR %1$ssu2_cstr_shon18 IS NOT NULL
                    OR %1$ssu2_cstr_shon19 IS NOT NULL
                    OR %1$ssu2_cstr_shon20 IS NOT NULL
                    OR %1$ssu2_cstr_shon21 IS NOT NULL
                    OR %1$ssu2_cstr_shon22 IS NOT NULL
                    OR %1$ssu2_chge_shon1 IS NOT NULL
                    OR %1$ssu2_chge_shon2 IS NOT NULL
                    OR %1$ssu2_chge_shon3 IS NOT NULL
                    OR %1$ssu2_chge_shon4 IS NOT NULL
                    OR %1$ssu2_chge_shon5 IS NOT NULL
                    OR %1$ssu2_chge_shon6 IS NOT NULL
                    OR %1$ssu2_chge_shon7 IS NOT NULL
                    OR %1$ssu2_chge_shon8 IS NOT NULL
                    OR %1$ssu2_chge_shon9 IS NOT NULL
                    OR %1$ssu2_chge_shon10 IS NOT NULL
                    OR %1$ssu2_chge_shon11 IS NOT NULL
                    OR %1$ssu2_chge_shon12 IS NOT NULL
                    OR %1$ssu2_chge_shon13 IS NOT NULL
                    OR %1$ssu2_chge_shon14 IS NOT NULL
                    OR %1$ssu2_chge_shon15 IS NOT NULL
                    OR %1$ssu2_chge_shon16 IS NOT NULL
                    OR %1$ssu2_chge_shon17 IS NOT NULL
                    OR %1$ssu2_chge_shon18 IS NOT NULL
                    OR %1$ssu2_chge_shon19 IS NOT NULL
                    OR %1$ssu2_chge_shon20 IS NOT NULL
                    OR %1$ssu2_chge_shon21 IS NOT NULL
                    OR %1$ssu2_chge_shon22 IS NOT NULL
                    OR %1$ssu2_demo_shon1 IS NOT NULL
                    OR %1$ssu2_demo_shon2 IS NOT NULL
                    OR %1$ssu2_demo_shon3 IS NOT NULL
                    OR %1$ssu2_demo_shon4 IS NOT NULL
                    OR %1$ssu2_demo_shon5 IS NOT NULL
                    OR %1$ssu2_demo_shon6 IS NOT NULL
                    OR %1$ssu2_demo_shon7 IS NOT NULL
                    OR %1$ssu2_demo_shon8 IS NOT NULL
                    OR %1$ssu2_demo_shon9 IS NOT NULL
                    OR %1$ssu2_demo_shon10 IS NOT NULL
                    OR %1$ssu2_demo_shon11 IS NOT NULL
                    OR %1$ssu2_demo_shon12 IS NOT NULL
                    OR %1$ssu2_demo_shon13 IS NOT NULL
                    OR %1$ssu2_demo_shon14 IS NOT NULL
                    OR %1$ssu2_demo_shon15 IS NOT NULL
                    OR %1$ssu2_demo_shon16 IS NOT NULL
                    OR %1$ssu2_demo_shon17 IS NOT NULL
                    OR %1$ssu2_demo_shon18 IS NOT NULL
                    OR %1$ssu2_demo_shon19 IS NOT NULL
                    OR %1$ssu2_demo_shon20 IS NOT NULL
                    OR %1$ssu2_demo_shon21 IS NOT NULL
                    OR %1$ssu2_demo_shon22 IS NOT NULL
                    OR %1$ssu2_sup_shon1 IS NOT NULL
                    OR %1$ssu2_sup_shon2 IS NOT NULL
                    OR %1$ssu2_sup_shon3 IS NOT NULL
                    OR %1$ssu2_sup_shon4 IS NOT NULL
                    OR %1$ssu2_sup_shon5 IS NOT NULL
                    OR %1$ssu2_sup_shon6 IS NOT NULL
                    OR %1$ssu2_sup_shon7 IS NOT NULL
                    OR %1$ssu2_sup_shon8 IS NOT NULL
                    OR %1$ssu2_sup_shon9 IS NOT NULL
                    OR %1$ssu2_sup_shon10 IS NOT NULL
                    OR %1$ssu2_sup_shon11 IS NOT NULL
                    OR %1$ssu2_sup_shon12 IS NOT NULL
                    OR %1$ssu2_sup_shon13 IS NOT NULL
                    OR %1$ssu2_sup_shon14 IS NOT NULL
                    OR %1$ssu2_sup_shon15 IS NOT NULL
                    OR %1$ssu2_sup_shon16 IS NOT NULL
                    OR %1$ssu2_sup_shon17 IS NOT NULL
                    OR %1$ssu2_sup_shon18 IS NOT NULL
                    OR %1$ssu2_sup_shon19 IS NOT NULL
                    OR %1$ssu2_sup_shon20 IS NOT NULL
                    OR %1$ssu2_sup_shon21 IS NOT NULL
                    OR %1$ssu2_sup_shon22 IS NOT NULL
                THEN REGEXP_REPLACE(CONCAT(
                    CASE
                        WHEN %1$ssu2_cstr_shon1 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Exploitation agricole - \', %1$ssu2_cstr_shon1, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon2 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Exploitation forestière - \', %1$ssu2_cstr_shon2, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon3 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Logement - \', %1$ssu2_cstr_shon3, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon4 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Hébergement - \', %1$ssu2_cstr_shon4, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon5 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Artisanat et commerce de détail - \', %1$ssu2_cstr_shon5, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon6 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Restauration - \', %1$ssu2_cstr_shon6, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon7 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Commerce de gros - \', %1$ssu2_cstr_shon7, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon8 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Activités de services où s\'\'effectue l\'\'accueil d\'\'une clientèle - \', %1$ssu2_cstr_shon8, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon9 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Hébergement hôtelier et touristique - \', %1$ssu2_cstr_shon9, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon10 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Cinéma - \', %1$ssu2_cstr_shon10, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon21 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Hôtels - \', %1$ssu2_cstr_shon21, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon22 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Autres hébergements touristiques - \', %1$ssu2_cstr_shon22, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon11 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Locaux et bureaux accueillant du public des administrations publiques et assimilés - \', %1$ssu2_cstr_shon11, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon12 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Locaux techniques et industriels des administrations publiques et assimilés - \', %1$ssu2_cstr_shon12, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon13 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Établissements d\'\'enseignement, de santé et d\'\'action sociale - \', %1$ssu2_cstr_shon13, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon14 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Salles d\'\'art et de spectacles - \', %1$ssu2_cstr_shon14, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon15 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Équipements sportifs - \', %1$ssu2_cstr_shon15, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon16 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Autres équipements recevant du public - \', %1$ssu2_cstr_shon16, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon17 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Industrie - \', %1$ssu2_cstr_shon17, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon18 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Entrepôt - \', %1$ssu2_cstr_shon18, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon19 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Bureau - \', %1$ssu2_cstr_shon19, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu2_cstr_shon20 IS NULL
                        THEN \'\'
                        ELSE CONCAT (\'Centre de congrès et d\'\'exposition - \', %1$ssu2_cstr_shon20, \' m²\')
                    END
                ), \' <br/>$\', \'\')
                ELSE REGEXP_REPLACE(CONCAT(
                    CASE
                        WHEN %1$ssu_cstr_shon1 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Habitation - \', %1$ssu_cstr_shon1, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu_cstr_shon2 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Hébergement hôtelier - \', %1$ssu_cstr_shon2, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu_cstr_shon3 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Bureaux - \', %1$ssu_cstr_shon3, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu_cstr_shon4 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Commerce - \', %1$ssu_cstr_shon4, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu_cstr_shon5 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Artisanat - \', %1$ssu_cstr_shon5, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu_cstr_shon6 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Industrie - \', %1$ssu_cstr_shon6, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu_cstr_shon7 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Exploitation agricole ou forestière - \', %1$ssu_cstr_shon7, \' m² <br/>\')
                    END,
                    CASE
                        WHEN %1$ssu_cstr_shon8 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Entrepôt - \', %1$ssu_cstr_shon8, \' m² <br/>\')
                    END, 
                    CASE
                        WHEN %1$ssu_cstr_shon9 IS NULL
                        THEN \'\'
                        ELSE CONCAT(\'Service public ou d\'\'intérêt collectif - \', %1$ssu_cstr_shon9, \' m²\')
                    END
                ), \' <br/>$\', \'\')
            END as surface,
            %1$sco_tot_ind_nb as nombre_logement_crees_individuel,
            %1$sco_tot_coll_nb as nombre_logement_crees_collectif',
            'donnees_techniques.'
        );

        // Requête SQL de récupération des donnnées des DI en cours
        $query_di_in_progress = sprintf(
            'SELECT
                dossier.dossier,
                dossier.dossier_libelle,
                dossier_instruction_type.libelle as dit_libelle,
                etat.libelle as etat_dossier,
                CASE
                    WHEN demandeur_di.qualite = \'particulier\' THEN TRIM(
                        CONCAT_WS(
                            \' \',
                            civilite_di.code,
                            demandeur_di.particulier_nom,
                            demandeur_di.particulier_prenom
                        )
                    )
                    ELSE TRIM(
                        CONCAT_WS(
                            \' \',
                            demandeur_di.personne_morale_raison_sociale,
                            demandeur_di.personne_morale_denomination
                        )
                    )
                END as demandeur,
                CASE
                    WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE
                        THEN to_char(dossier.date_limite_incompletude, \'DD/MM/YYYY\')
                    ELSE to_char(dossier.date_limite, \'DD/MM/YYYY\')
                END as date_limite,
                (
                    SELECT
                        array_to_json(
                            array_agg(
                                CONCAT(
                                    lot.libelle,
                                    \'|\',
                                    CASE
                                        WHEN demandeur_lot.qualite = \'particulier\' THEN TRIM(
                                            CONCAT_WS(
                                                \' \',
                                                civilite_lot.code,
                                                demandeur_lot.particulier_nom,
                                                demandeur_lot.particulier_prenom
                                            )
                                        )
                                        ELSE TRIM(
                                            CONCAT_WS(
                                                \' \',
                                                demandeur_lot.personne_morale_raison_sociale,
                                                demandeur_lot.personne_morale_denomination
                                            )
                                        )
                                    END
                                )
                            )
                        )
                    FROM
                        %1$slot
                        LEFT JOIN %1$slien_lot_demandeur
                            ON lot.lot = lien_lot_demandeur.lot
                        LEFT JOIN %1$sdemandeur as demandeur_lot
                            ON lien_lot_demandeur.demandeur = demandeur_lot.demandeur
                            AND lien_lot_demandeur.petitionnaire_principal IS TRUE
                        LEFT JOIN %1$scivilite as civilite_lot
                            ON demandeur_lot.particulier_civilite = civilite_lot.civilite
                            OR demandeur_lot.personne_morale_civilite = civilite_lot.civilite
                    WHERE
                        lot.dossier = dossier.dossier
                ) as liste_lot %3$s
            FROM
                %1$sdossier
                INNER JOIN %1$setat
                    ON dossier.etat = etat.etat
                INNER JOIN %1$sdossier_instruction_type
                    ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                INNER JOIN %1$slien_dossier_demandeur
                    ON dossier.dossier = lien_dossier_demandeur.dossier
                INNER JOIN %1$sdemandeur as demandeur_di
                    ON lien_dossier_demandeur.demandeur = demandeur_di.demandeur
                    AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
                LEFT JOIN %1$scivilite as civilite_di
                    ON demandeur_di.particulier_civilite = civilite_di.civilite
                    OR demandeur_di.personne_morale_civilite = civilite_di.civilite
                INNER JOIN %1$sdonnees_techniques
                    ON dossier.dossier = donnees_techniques.dossier_instruction
            WHERE
                dossier.dossier_autorisation = \'%2$s\'
                AND etat.statut = \'encours\'
                AND dossier_instruction_type.sous_dossier IS NOT TRUE
            ORDER BY
                dossier.date_depot,
                dossier.dossier',
            DB_PREFIXE,
            $this->f->db->escapeSimple($idx),
            sprintf(', %s', $select_di_dt)
        );
        $res_di_in_progress = $this->f->get_all_results_from_db_query(
            $query_di_in_progress,
            array(
                "origin" => __METHOD__,
            )
        );

        printf("<div class=\"formulaire\"><form method=\"post\" id=\"dossier_autorisation\" action=\"#\" class=\"formEntete ui-corner-all\">");

        //Le formualaire n'a pas été validé
        $validation = 1;
        //
        $champs = array("dossier_autorisation","commune","dossier_autorisation_libelle",
            "type_detaille", "da_etat", "da_demandeur", "infos_localisation_terrain", 
            "depot_initial", "date_decision", "date_validite", 
            "date_depot_DAACT", "date_depot_DOC", "da_description_projet",
            "surface", "da_nombre_logement_crees_individuel",
            "da_nombre_logement_crees_collectif", "da_liste_lots", "histo_decisions", "donnees_techniques");

        // Champs des dossiers d'instruction en cours
        foreach ($res_di_in_progress['result'] as $key => $di_in_progress) {
            //
            $champs[] = sprintf('dossier_%s', $key);
            $champs[] = sprintf('dossier_libelle_%s', $key);
            $champs[] = sprintf('dit_libelle_%s', $key);
            $champs[] = sprintf('etat_%s', $key);
            $champs[] = sprintf('demandeur_%s', $key);
            $champs[] = sprintf('date_limite_%s', $key);
            $champs[] = sprintf('description_projet_%s', $key);
            $champs[] = sprintf('surface_%s', $key);
            $champs[] = sprintf('nombre_logement_crees_individuel_%s', $key);
            $champs[] = sprintf('nombre_logement_crees_collectif_%s', $key);
            $champs[] = sprintf('liste_lots_%s', $key);
        }

        //Création d'un nouvel objet de type formulaire
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => $validation,
            "maj" => 3,
            "champs" => $champs,
        ));

        //Configuration des types de champs
        foreach ($champs as $key) {
            $form->setType($key, 'static');
        }

        //Le numéro de dossier d'instruction est caché, on affiche celui
        //qui est formatté
        $form->setType('dossier_autorisation', 'hidden');

        //
        $form->setType('da_liste_lots', 'htmlstatic');
        $form->setType('histo_decisions', 'htmlstatic');
        $form->setType('donnees_techniques', 'htmlstatic');
        
        //Configuration des libellés
        $form->setLib("dossier_autorisation", _("dossier_autorisation"));
        $form->setLib("commune", __("commune"));
        $form->setLib("dossier_autorisation_libelle", _("No dossier autorisation"));
        $form->setLib("type_detaille", _("Type d'autorisation"));
        $form->setLib("da_etat", _("etat"));
        $form->setLib("da_demandeur", _("Demandeur principal"));
        $form->setLib("infos_localisation_terrain", _("localisation"));
        $form->setLib("depot_initial", _("Depot initial"));
        $form->setLib("date_decision", _("Decision initiale"));
        $form->setLib("date_validite", _("Date de validite"));
        $form->setLib("date_depot_DAACT", _("Date de depot de la DAACT"));
        $form->setLib("date_depot_DOC", _("Date de depot de la DOC"));
        $form->setLib("da_description_projet", _("description_projet"));
        $form->setLib("surface", _("Surface creee"));
        $form->setLib("da_nombre_logement_crees_individuel", _("nombre_logement_crees_individuel"));
        $form->setLib("da_nombre_logement_crees_collectif", _("nombre_logement_crees_collectif"));
        $form->setLib("da_liste_lots", "");
        $form->setLib("histo_decisions", "");
        $form->setLib("donnees_techniques", "");

        //Configuration des données
        $form->setVal("dossier_autorisation", $idx);
        $form->setVal("commune", $rowDonneesDA["commune_libelle"]);
        $form->setVal("dossier_autorisation_libelle", $rowDonneesDA["dossier_autorisation_libelle"]);
        $form->setVal("type_detaille", $rowDonneesDA["type_detaille"]);
        $form->setVal("da_etat", $rowDonneesDA["etat"]);
        $form->setVal("da_demandeur", $rowDonneesDA["demandeur"]);
        $form->setVal("infos_localisation_terrain", ($rowDonneesDA["infos_localisation_terrain"]!=="")?$rowDonneesDA["infos_localisation_terrain"]:"-");
        $form->setVal("depot_initial", ($rowDonneesDA["depot_initial"]!=="")?$rowDonneesDA["depot_initial"]:"-");
        $form->setVal("date_decision", ($rowDonneesDA["date_decision"]!=="")?$rowDonneesDA["date_decision"]:"-");
        //On met des valeurs par défaut dans ces deux champs
        $form->setVal("date_depot_DAACT", ($rowDonneesDA["date_achevement"]!=="")?$rowDonneesDA["date_achevement"]:"-");
        $form->setVal("date_depot_DOC", ($rowDonneesDA["date_chantier"]!=="")?$rowDonneesDA["date_chantier"]:"-");
        $form->setVal("da_description_projet", ($rowPrincDonneesTechniques["description_projet"]!=="")?$rowPrincDonneesTechniques["description_projet"]:"-");
        $form->setVal("surface",($rowPrincDonneesTechniques["surface"]!=="")?$rowPrincDonneesTechniques["surface"]:"-");
        $form->setVal("da_nombre_logement_crees_individuel", ($rowPrincDonneesTechniques["nombre_logement_crees_individuel"]!=="")?$rowPrincDonneesTechniques["nombre_logement_crees_individuel"]:"-");
        $form->setVal("da_nombre_logement_crees_collectif", ($rowPrincDonneesTechniques["nombre_logement_crees_collectif"]!=="")?$rowPrincDonneesTechniques["nombre_logement_crees_collectif"]:"-");
        $form->setVal("date_validite", ($rowDonneesDA["date_validite"]!=="")?$rowDonneesDA["date_validite"]:"-");
        // Gestion des lots
        $da_liste_lots ="<span class='no-value'>" .  __("Aucun lot lie a ce dossier d'autorisation.") . "</span>";
        if (is_array($res_da_list_lot['result']) === true && empty($res_da_list_lot['result']) !== true) {
            $style_line = 'even';
            $da_cell_lot = '';
            foreach($res_da_list_lot['result'] as $da_lot) {
                $style_line = ($style_line == 'even') ? 'odd' : 'even';
                $da_cell_lot .= sprintf($template_cell_lots, $style_line, $da_lot['libelle'], $da_lot['demandeur']);
            }
            $da_liste_lots = sprintf($template_table_lots, __('Libelle'), __('Demandeur'), $da_cell_lot);
        }
        $form->setVal("da_liste_lots", $da_liste_lots);
        $form->setVal("histo_decisions", $histo_decisions);
        $form->setVal("donnees_techniques", $donnees_techniques);

        // Initialisation des champs des dossiers d'instruction en cours
        foreach ($res_di_in_progress['result'] as $key => $di_in_progress) {
            // Gestion des lots
            $liste_lots = "<span class='no-value'>" .  __("Aucun lot lie a ce dossier d'instruction.") . "</span>"; ;
            $lots = (json_decode($di_in_progress['liste_lot']) != null ? json_decode($di_in_progress['liste_lot']) : array());
            if (empty($lots) !== true) {
                $style_line = 'even';
                $cell_lot = '';
                foreach ($lots as $lot) {
                    $lot_infos = explode('|', $lot);
                    $style_line = ($style_line == 'even') ? 'odd' : 'even';
                    $cell_lot .= sprintf($template_cell_lots, $style_line, $lot_infos[0], $lot_infos[1]);
                }
                $liste_lots = sprintf($template_table_lots, __('Libelle'), __('Demandeur'), $cell_lot);
            }
            //
            $form->setType(sprintf('dossier_%s', $key), 'hidden');
            $form->setType(sprintf('dossier_libelle_%s', $key), 'static');
            $form->setType(sprintf('dit_libelle_%s', $key), 'static');
            $form->setType(sprintf('etat_%s', $key), 'static');
            $form->setType(sprintf('demandeur_%s', $key), 'static');
            $form->setType(sprintf('date_limite_%s', $key), 'static');
            $form->setType(sprintf('description_projet_%s', $key), 'static');
            $form->setType(sprintf('surface_%s', $key), 'static');
            $form->setType(sprintf('nombre_logement_crees_individuel_%s', $key), 'static');
            $form->setType(sprintf('nombre_logement_crees_collectif_%s', $key), 'static');
            $form->setType(sprintf('liste_lots_%s', $key), 'htmlstatic');
            //
            $form->setLib(sprintf('dossier_%s', $key), _("dossier"));
            $form->setLib(sprintf('dossier_libelle_%s', $key), _("dossier_libelle"));
            $form->setLib(sprintf('dit_libelle_%s', $key), _("dit_libelle"));
            $form->setLib(sprintf('etat_%s', $key), _("etat"));
            $form->setLib(sprintf('demandeur_%s', $key), _("Demandeur principal"));
            $form->setLib(sprintf('date_limite_%s', $key), _("Date limite"));
            $form->setLib(sprintf('description_projet_%s', $key), _("description_projet"));
            $form->setLib(sprintf('surface_%s', $key), _("Surface creee"));
            $form->setLib(sprintf('nombre_logement_crees_individuel_%s', $key), _("nombre_logement_crees_individuel"));
            $form->setLib(sprintf('nombre_logement_crees_collectif_%s', $key), _("nombre_logement_crees_collectif"));
            $form->setLib(sprintf('liste_lots_%s', $key), "");
            //
            $form->setVal(sprintf('dossier_%s', $key), $di_in_progress["dossier"]);
            $form->setVal(sprintf('dossier_libelle_%s', $key), $di_in_progress["dossier_libelle"]);
            $form->setVal(sprintf('dit_libelle_%s', $key), $di_in_progress["dit_libelle"]);
            $form->setVal(sprintf('etat_%s', $key), $di_in_progress["etat_dossier"]);
            $form->setVal(sprintf('demandeur_%s', $key), $di_in_progress["demandeur"]);
            $form->setVal(sprintf('date_limite_%s', $key), $di_in_progress["date_limite"]);
            $form->setVal(sprintf('description_projet_%s', $key), ($di_in_progress["description_projet"]!=="")?$di_in_progress["description_projet"]:"-");
            $form->setVal(sprintf('surface_%s', $key),($di_in_progress["surface"]!=="")?$di_in_progress["surface"]:"-");
            $form->setVal(sprintf('nombre_logement_crees_individuel_%s', $key), ($di_in_progress["nombre_logement_crees_individuel"]!=="")?$di_in_progress["nombre_logement_crees_individuel"]:"-");
            $form->setVal(sprintf('nombre_logement_crees_collectif_%s', $key), ($di_in_progress["nombre_logement_crees_collectif"]!=="")?$di_in_progress["nombre_logement_crees_collectif"]:"-");
            $form->setVal(sprintf('liste_lots_%s', $key), $liste_lots);
        }

        // Affichage du dossier d'autorisation
        $form->setBloc("dossier_autorisation", "D", "", "enCoursValidité");

            // Fieldset des dossiers en cours de validité
            $form->setFieldset("dossier_autorisation", "D", _("En cours de validite"), "");

                //Données générales
                $form->setBloc("dossier_autorisation", "D", _("Donnees generales"), "donneesGenerales");;
                $form->setBloc("infos_localisation_terrain", "F");

                //Dates importantes
                $form->setBloc("depot_initial", "D", _("Dates importantes"), "datesImportantes");
                $form->setBloc("date_depot_DOC", "F");

                //Principales données techniques
                $form->setBloc("da_description_projet", "D", __("Principales données techniques / CERFA"), "cerfa");
                $form->setBloc("da_nombre_logement_crees_collectif", "F");

                //
                $form->setBloc("da_liste_lots", "DF", _("Liste des lots"), "listeLots");

                //
                $form->setBloc("histo_decisions", "DF", _("Historique des decisions"), "historiqueDecisions");

                if ($rowPrincDonneesTechniques['donnees_techniques'] != ''
                    && $display_cerfa === true
                    && $this->f->isAccredited(array('donnees_techniques', 'donnees_techniques_consulter'), 'OR') === true) {
                    //
                    $form->setBloc("donnees_techniques", "DF", _("Toutes les donnees du CERFA"), "donneesCerfa");
                    // Ferme le fieldset sur ce champ
                    $form->setFieldset("donnees_techniques", "F", "");
                    //
                    $form->setBloc("donnees_techniques", "F");
                } else {
                    // Sinon ferme le fieldset sur le champ précédent
                    $form->setFieldset("histo_decisions", "F", "");
                    //
                    $form->setBloc("histo_decisions", "F");
                }

        // Affichage des dossiers d'instruction en cours
        foreach ($res_di_in_progress['result'] as $key => $di_in_progress) {
            //
            $form->setBloc(sprintf('dossier_%s', $key), "D", "", "enCoursInstruction");
            $form->setFieldset(sprintf('dossier_%s', $key), "D", _("En cours d'instruction"), " ");
            $form->setBloc(sprintf('dossier_%s', $key), "D", _("Donnees generales"), "donneesGenerales");
            $form->setBloc(sprintf('demandeur_%s', $key), "F");
            if ($di_in_progress["etat_dossier"] != 'incomplet'
                && $di_in_progress["etat_dossier"] != 'incomplet_notifie') {
                //
                $form->setBloc(sprintf('date_limite_%s', $key), "D", _("Dates importantes"), "datesImportantes");
                $form->setBloc(sprintf('date_limite_%s', $key), "F");
            }
            $form->setBloc(sprintf('description_projet_%s', $key), "D", __("Principales données techniques / CERFA"), "cerfa");
            $form->setBloc(sprintf('nombre_logement_crees_collectif_%s', $key), "F");
            $form->setBloc(sprintf('liste_lots_%s', $key), "DF", _("Liste des lots"), "listeLots");
            $form->setFieldset(sprintf('liste_lots_%s', $key), "F", "");
            $form->setBloc(sprintf('liste_lots_%s', $key), "F");
        }

        //
        $form->afficher($champs, $validation, false, false);

        printf("</form>");

        if ($bouton_retour !== false) {
            //
            $bouton_retour_with_formcontrols = sprintf("<div class=\"formControls formControls-bottom\">%s</div>", $bouton_retour);
            printf("%s</div>", $bouton_retour_with_formcontrols);
        }
    }


    /**
     * VIEW - view_consulter
     * 
     * Cette vue permet d'afficher l'interface spécifique de consultation
     * des dossiers d'autorisation.
     *
     * @return void
     */
    function view_consulter() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        //
        $idx = $this->f->get_submitted_get_value('idx');
        $retour = $this->f->get_submitted_get_value('retour');
        $premier = $this->f->get_submitted_get_value('premier');
        $advs_id = $this->f->get_submitted_get_value('advs_id');
        $tricol = $this->f->get_submitted_get_value('tricol');
        $valide = $this->f->get_submitted_get_value('valide');
        $retourformulaire = $this->f->get_submitted_get_value('retourformulaire');
        
        $bouton_retour = "<a class=\"retour\" 
            href=\"".OM_ROUTE_TAB."&obj=dossier_autorisation&premier=".$premier."&tricol=".$tricol."&retourformulaire=".$retourformulaire.
            "&advs_id=".$advs_id."\">"._("Retour")."</a>";
        // Si l'identifiant du dossier d'autorisation a été fourni
        // Dans le mode MC on n'affiche pas les informations du DA
        if (is_null($idx) === false
            && $this->f->is_option_om_collectivite_entity_enabled($this->getVal('om_collectivite')) === false) {
            // Affiche la fiche complète du dossier d'autorisation
            $this->display_dossier_autorisation_data($idx, $bouton_retour);
        }
    }


    /**
     * Affiche la fiche du dossier d'autorisation pour les utilisateurs anonymes.
     *
     * @param boolean $content_only Affiche le contenu seulement.
     *
     * @return void
     */
    public function view_consulter_anonym($content_only = false) {

        // Par défaut on considère qu'on va afficher le formulaire
        $idx = 0;
        // Flag d'erreur
        $error = false;
        // Message d'erreur
        $message = '';

        // Paramètres POST
        $validation = $this->f->get_submitted_post_value('validation');
        //
        $dossier = $this->f->get_submitted_post_value('dossier');
        $dossier = preg_replace('/\s+/', '', $dossier);
        //
        $cle_acces_citoyen = $this->f->get_submitted_post_value('cle_acces_citoyen_complete');
        //
        $timestamp_generation_formulaire = $this->f->get_submitted_post_value('timestamp_generation_formulaire');

        // Si au moins un des champs n'est pas renseignés
        if ($error !== true
            && $validation !== null
            && (($dossier === null || $dossier == '')
                || ($cle_acces_citoyen === null || $cle_acces_citoyen == ''))) {
            //
            $message = _("Tous les champs doivent etre remplis.");
            $error = true;
        }

        // Si le formulaire est expiré
        if ($error !== true
            && $validation !== null
            && time() >= strtotime('+5 minutes', $timestamp_generation_formulaire)) {
            //
            $message = _("Le formulaire a expire. Veuillez recharger la page.");
            $error = true;
        }

        // Si les valeurs renseignées semblent correctes
        if ($error !== true
            && $validation !== null
            && (strlen($dossier) < 15 || strlen($cle_acces_citoyen) != 19)) {
            //
            $message = _("Le numero de dossier ou la cle d'acces n'est pas valide.");
            $error = true;
        }

        // S'il n'y a pas eu d'erreur
        if ($error !== true
            && $validation !== null) {
            // Vérifie le couple numéro de dossier et clé d'accès citoyen
            $idx = $this->verify_citizen_access_portal_credentials($dossier, $cle_acces_citoyen);

            // Si le couple n'est pas correct
            if ($idx === false) {
                //
                $message = _("Le numero de dossier ou la cle d'acces n'est pas valide.");
                $error = true;
            }
        }

        // S'il n'y a pas d'erreur et que le formulaire a été validé
        if ($error !== true && $validation !== null) {
            // On affiche la fiche d'information du dossier d'autorisation
            $this->display_dossier_autorisation_data($idx, false, false);
        } else {
            // Sinon on affiche le formulaire d'accès au portail citoyen
            $this->display_citizen_access_portal_form($message, $content_only);
        }
    }


    /**
     * Vérifie le couple dossier/clé d'accès dans la base de données.
     *
     * @param string $dossier            Le numéro du DI ou DA, sans espaces.
     * @param string $citizen_access_key La clé d'accès.
     *
     * @return string Identifiant du DA sinon 0.
     */
    public function verify_citizen_access_portal_credentials($dossier, $citizen_access_key) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation.dossier_autorisation
                FROM
                    %1$sdossier
                    LEFT JOIN %1$sdossier_autorisation
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                WHERE 
                    (dossier.dossier = \'%2$s\' OR
                        dossier_autorisation.dossier_autorisation = \'%2$s\') AND
                    dossier_autorisation.cle_acces_citoyen = \'%3$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier),
                $this->f->db->escapeSimple($citizen_access_key)
            ),
            array(
                "origin" => __METHOD__
            )
        );

        // Si aucun dossier n'existe avec la clé fournie, on renvoie faux
        if ($qres['result'] == null) {
            return false;
        }
        //
        return $qres['result'];
    }


    /**
     * Affiche le formulaire d'accès au portail citoyen.
     *
     * @param string  $message      Message d'erreur.
     * @param boolean $content_only Affiche le contenu seulement.
     *
     * @return void
     */
    public function display_citizen_access_portal_form($message, $content_only) {

        // Ajoute le paramètre content_only à l'url permettant de ne pas afficher
        // le header et le footer
        $param_get_content_only = '';
        if ($content_only === true) {
            $param_get_content_only = '?content_only=true';
        }

        // Affichage du message d'erreur
        if (isset($message) && $message != "") {
            printf('<div class="alert alert-danger" role="alert">%s</div>', $message);
        }

        // Ouverture du formulaire
        printf("<div class=\"formulaire\"><form class=\"form-signin\" method=\"POST\" id=\"acces_portail_citoyen\" action=\"citizen.php%s\">", $param_get_content_only);

        $champs = array('dossier', 'cle_acces_citoyen_split', 'timestamp_generation_formulaire', 'cle_acces_citoyen_complete');

        //
        $form = $this->f->get_inst__om_formulaire(array(
            "validation" => 0,
            "maj" => 0,
            "champs" => $champs,
        ));
        $form->setType('dossier', 'text');
        $form->setType('cle_acces_citoyen_split', 'citizen_access_key');
        $form->setType('cle_acces_citoyen_complete', 'hidden');
        $form->setType('timestamp_generation_formulaire', 'hidden');

        $form->setTaille("dossier", 30);
        $form->setTaille('cle_acces_citoyen_complete', 19);
        $form->setTaille('timestamp_generation_formulaire', 20);

        $form->setMax("dossier", 30);
        $form->setMax('cle_acces_citoyen_complete', 19);
        $form->setMax('timestamp_generation_formulaire', 20);

        $form->setLib('dossier', _('N° de dossier'));
        $form->setLib('cle_acces_citoyen_split', _('cle_acces'));
        $form->setLib('cle_acces_citoyen_complete', '');
        $form->setLib('timestamp_generation_formulaire', '');

        $form->setVal('timestamp_generation_formulaire', time());

        $form->setBloc("dossier", "D", "", "group");
        $form->setBloc("cle_acces_citoyen_split", "F");
        $form->afficher($champs, 0, false, false);

        // Bouton de validation
        echo "<div class=\"formControls formControls-bottom\">";
        echo "<input type=\"submit\" class=\"btn btn-lg btn-primary btn-block\" value=\""._("Valider")."\" name=\"validation\" />";
        echo "</div>";
        printf("</form>");

        // Fermeture du div formulaire
        printf("</div>");

    }


    /**
     *  Assure que la date passee par reference soit en
     *  format attendu par la fonction dateDB du fichier 
     *  core/om_dbform.class.php. Change le format de la
     *  date si necessaire.
     *  @param $string $field Le date dans format DB, ou
     *  celui attendu par setvalF
     */
    private function changeDateFormat(&$field) {
        if (preg_match('/([0-9]{4})-([0-9]{2})-([0-9]{2})/',
                    $field, $matches)) {
            $field = $matches[3].'/'.$matches[2].'/'.$matches[1];
        }        
    }
    
    function setvalF($val = array()) {
        // verifie que les dates envoyes au parent::setvalF sont ont
        // bon format, et change le format si necessaire
        $this->changeDateFormat($val['erp_date_ouverture']);
        $this->changeDateFormat($val['erp_date_arrete_decision']);
        
        parent::setvalF($val);
        
        // si la valeur d'erp_arrete_decision n'etait pas set, laisse elle a null
        if ($val['erp_arrete_decision'] == null) {
            $this->valF['erp_arrete_decision'] = null;
        }
        // si la valeur d'erp_ouvert n'etait pas set, laisse elle a null
        if ($val['erp_ouvert'] == null) {
            $this->valF['erp_ouvert'] = null;
        }
    }

    /**
     * Créer une séquence pour le numéro de dossier
     */
    function createSequenceNumeroDossier($table_name) {
        // on crée la séquence
        $res = $this->f->db->createSequence($table_name);
        $this->f->addToLog(__METHOD__.'(): db->createSequence("'.$table_name.'");',
                            VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true) === true) {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $res->getDebugInfo(),
                $res->getMessage(),
                'dossier_autorisation'
            );
            // Stop le traitement
            return false;
        }
        return true;
    }

    /**
     * Défini la valeur d'une séquence pour le numéro de dossier
     */
    function setSequenceValueNumeroDossier($sequence_name, $value) {
        // TODO : Utilisation de get_all pour setter une valeur, voir si
        // il n'y a pas une meilleure manière de gérer ce point
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT setval(\'%s\',%s);',
                $this->f->db->escapeSimple(strtolower($sequence_name)),
                intval($value)
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                'dossier_autorisation'
            );
            // Stop le traitement
            return false;
        }
        return true;
    }

    /**
     * Désactivation de cette fonction qui ne fait que vérifier qu'une clé primaire est définie et
     * non existante en base.
     * En effet la clé primaire sera définie plus tard, automatiquement lors de l'appel à la méthode
     * 'triggerajouter()'.
     */
    function verifierAjout($val = array(), &$dnu1 = null) {}

    /**
     * Méthode permettant de définir des valeurs à envoyer en base après
     * validation du formulaire d'ajout.
     * @param array $val tableau des valeurs retournées par le formulaire
     */
    function triggerajouter($id, &$dnu1 = null, $val = array(), $dnu2 = null) {

        // On récupère les paramètres de la collectivité concernée
        // par la demande.
        $collectivite_parameters = $this->f->getCollectivite($this->valF['om_collectivite']);

        // option des communes associées aux dossiers activée
        if ($this->f->is_option_dossier_commune_enabled($this->valF['om_collectivite'])) {

            // récupération de la date de demande
            $date_demande = 'NOW';
            $d_match = array();
            if (isset($this->valF["date_demande"])
                    && preg_match('/^([0-9]{2})\/([0-9]{2})\/([0-9]{4})$/',
                                  $this->valF["date_demande"], $d_match)) {
                $date_demande = $d_match[3].'-'.$d_match[2].'-'.$d_match[1];
            }
            $date_demande = new DateTime($date_demande);

            // la commune doit être définie
            $communeId = $this->valF['commune'];
            if (empty($communeId)) {
                $this->f->addToLog(__METHOD__."(): ERROR commune non spécifiée.", DEBUG_MODE);
                return false;
            }

            // la commune doit exister
            $communeObj = $this->f->findObjectById("commune", $communeId);
            if (empty($communeObj)) {
                $this->f->addToLog(__METHOD__."(): ERROR "
                                   .sprintf("commune '%d' non trouvée.", $communeId),
                                   DEBUG_MODE);
                return false;
            }

            // la commune doit être valide à la date de la demande
            elseif (! $communeObj->valid($date_demande)) {
                $this->f->addToLog(__METHOD__."(): ERROR "
                    .sprintf("impossible d'utiliser la commune '%s' (invalide à la date du '%s').",
                        $commune->getVal('libelle'), $date_demande->format('d/m/Y')),
                    DEBUG_MODE);
                return false;
            }
            // on récupère le code canton et le code de département
            $departement = strtoupper($communeObj->getVal('dep'));
            $commune = str_pad(preg_replace('/^'.$departement.'/', '', strtoupper($communeObj->getVal('com'))), 3, '0', STR_PAD_LEFT);
            $departement = str_pad($departement, 3, '0', STR_PAD_LEFT);
        }

        // option des communes associées aux dossiers désactivée
        else {
            // Le paramètre 'departement' est obligatoire si il n'est pas présent
            // dans le tableau des paramètres alors on stoppe le traitement.
            if (!isset($collectivite_parameters['departement'])) {
                $this->f->addToLog(
                __METHOD__."(): ERROR om_parametre 'departement' inexistant.",
                    DEBUG_MODE
                );
                return false;
            }
            $departement = $collectivite_parameters['departement'];

            // Le paramètre 'commune' est obligatoire si il n'est pas présent
            // dans le tableau des paramètres alors on stoppe le traitement.
            if (!isset($collectivite_parameters['commune'])) {
                $this->f->addToLog(
                __METHOD__."(): ERROR om_parametre 'commune' inexistant.",
                    DEBUG_MODE
                );
                return false;
            }
            $commune = $collectivite_parameters['commune'];
        }

        // Récupération du type de dossier ou série
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
                intval($val['dossier_autorisation_type_detaille'])
            ),
            array(
                "origin" => __METHOD__
            )
        );
        $da_type_code = $qres['result'];

        // Saisie manuelle du numéro complet du dossier
        $num_doss_comp = isset($val['numero_dossier_complet']) ? $val['numero_dossier_complet'] : null;

        if ($num_doss_comp !== null) {
            $num_urba = $this->f->numerotation_urbanisme($num_doss_comp);
            if (empty($num_urba['da']) === false) {
                $this->valF[$this->clePrimaire] = $num_urba['da'][0];
                $this->valF["dossier_autorisation_libelle"] = sprintf("%s %s%s %s %s%s",
                    $num_urba['da']['type'],
                    $num_urba['da']['departement'],
                    $num_urba['da']['commune'],
                    $num_urba['da']['annee'],
                    $num_urba['da']['division'],
                    $num_urba['da']['numero']
                );

                // Sauvegarde les valeurs composants la numérotation
                $this->valF["numerotation_type"] = $num_urba['da']['type'];
                $this->valF["numerotation_dep"] = $num_urba['da']['departement'];
                $this->valF["numerotation_com"] = $num_urba['da']['commune'];
                $this->valF["numerotation_division"] = $num_urba['da']['division'];
                $this->valF["numerotation_num"] = $num_urba['da']['numero'];
            }
            else {
                /// IDENTIFIANT DU DOSSIER D'AUTORISATION
                $this->valF[$this->clePrimaire] = $num_doss_comp;
                // Identifiant du dossier d'autorisation lisible
                $this->valF["dossier_autorisation_libelle"] = $num_doss_comp;
            }
        }
        else {
            // année
            $annee = date('y', strtotime($this->valF["depot_initial"]));

            // Récupération de la division de l'instructeur
            if (isset($val['division_instructeur'])) {
                $division_instructeur = $val['division_instructeur'];
            }
            else {
                $division_instructeur = $this->get_instructeur_division_for_numero_dossier();
            }

            // Saisie manuelle du numéro du dossier
            $num_doss_seq = isset($val['numero_dossier_seq']) ? $val['numero_dossier_seq'] : null;

            // récupère automatiquement (incrément) un nouveau numéro de dossier
            $numero_dossier = $this->createNumeroDossier(
                $da_type_code,
                $annee,
                $departement,
                $commune,
                $num_doss_seq
            );

            // en cas d'erreur
            if($numero_dossier === false) {
                return false;
            }

            /// IDENTIFIANT DU DOSSIER
            // PC 013 055 12 00001
            $this->valF[$this->clePrimaire] =
                $da_type_code.$departement.$commune.$annee.$division_instructeur.$numero_dossier;

            // Identifiant du dossier d'autorisation lisible
            // Ex : DP 013055 13 00002
            $this->valF["dossier_autorisation_libelle"] = 
                $da_type_code." ".$departement.$commune." ".$annee." ".$division_instructeur.$numero_dossier;

            // Sauvegarde les valeurs composants la numérotation
            $this->valF["numerotation_type"] = $da_type_code;
            $this->valF["numerotation_dep"] = $departement;
            $this->valF["numerotation_com"] = $commune;
            $this->valF["numerotation_division"] = $division_instructeur;
            $this->valF["numerotation_num"] = $numero_dossier;
        }

        // vérification de la clé primaire
        // TODO : A vérifier mais cette méthode fait la même chose que checkUniqueKey
        // qui est réaliser avant ajout du dossier. Donc le resultat ne peut jamais
        // être > 0 ?
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    count(*)
                FROM
                    %1$s%2$s
                WHERE
                    %3$s = \'%4$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->table),
                $this->f->db->escapeSimple($this->clePrimaire),
                $this->f->db->escapeSimple($this->valF[$this->clePrimaire])
            ),
            array(
                "origin" => __METHOD__
            )
        );
        // si on trouve au moins une clé existante
        if ($qres['result'] > 0) {
            $this->correct = false;
            $this->addToMessage( __("Dossier autorisation: numéro de dossier déjà existant.<br/>SAISIE NON ENREGISTRÉE."));
            return false;
        }

        //
        return true;
    }

    /**
     * Récupère le code de la division pour le numéro du dossier.
     * Par défaut retourne 0.
     *
     * @return mixed Division de l'instructeur ou 0
     */
    function get_instructeur_division_for_numero_dossier($datd = 0, $om_collectivite = 0, $commune_id = 0, $ref_cadas = '', $demande_type = 0) {

        if ($datd === 0 && isset($this->valF['dossier_autorisation_type_detaille']) === true) {
            $datd = intval($this->valF['dossier_autorisation_type_detaille']);
        }
        if ($demande_type === 0 && isset($this->valF['demande_type']) === true) {
            $demande_type = intval($this->valF['demande_type']);
        }
        if ($om_collectivite === 0 && isset($this->valF['om_collectivite']) === true) {
            $om_collectivite = intval($this->valF['om_collectivite']);
        }
        if ($commune_id === 0 && isset($this->valF['commune']) && $this->f->is_option_dossier_commune_enabled()) {
            $commune_id = intval($this->valF['commune']);
        }
        if (empty($ref_cadas) === true && isset($this->valF['terrain_references_cadastrales']) === true) {
            $ref_cadas = $this->valF['terrain_references_cadastrales'];
        }

        // Récupère le paramètre numero_dossier_division_instructeur
        $option = $this->f->is_option_instructeur_division_numero_dossier_enabled($om_collectivite);

        // Si l'option n'est pas activée
        if ($option != 'true') {

            // Retourne la valeur par défaut 0
            return 0;
        }

        // Instancie la classe dossier pour utiliser les fonctions de
        // récupération de l'instructeur automatiquement
        $dossier = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => 0,
        ));

        $quartier = 0;
        $arrondissement = 0;
        $section = '';

        // S'il y au moins une référence cadastrale
        if ($ref_cadas !== '') {
            // Récupère toutes les parcelles du dossier et sélectionne la première
            $list_parcelles = $this->f->parseParcelles($ref_cadas, $om_collectivite);
            if (count($list_parcelles) > 0) {
                $parcelle = $list_parcelles[0];

                // Récupère l'identifiant du quartier et de l'arrondissement
                $quartier_arrondissement = $dossier->get_quartier_arrondissement_by_code_impot($parcelle['quartier']);
                if ($quartier_arrondissement !== null
                    && is_array($quartier_arrondissement) === true
                    && isset($quartier_arrondissement['quartier']) === true
                    && isset($quartier_arrondissement['arrondissement']) === true) {
                    //
                    $quartier = $quartier_arrondissement['quartier'];
                    $arrondissement = $quartier_arrondissement['arrondissement'];
                }

                // On récupère la section
                $section = $parcelle['section'];
            }
        }

        // Récupère l'instructeur et la division qui seront affectés
        // automatiquement
        $instructeurDivision = $dossier->getInstructeurDivision(
            $quartier, $arrondissement, $section, $datd, $om_collectivite, $commune_id, $demande_type);

        // Si aucun instructeur est affecté automatiquement
        if (empty($instructeurDivision) === true) {

            // Retourne la valeur par défaut 0
            return 0;
        }

        // Récupère la division
        $division = $instructeurDivision['division'];

        // Récupère le code de la division
        $division_instance = $this->f->get_inst__om_dbform(array(
            "obj" => "division",
            "idx" => $division,
        ));
        $division_code = $division_instance->getVal("code");

        // Retourne le libellé de la division
        return $division_code;
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
    // }}}


    /**
     * Retourne 'true' si la séquence du numéro de dossier existe,
     * sinon 'false' si la séquence n'existe pas, et 'null' s'il y a une anomalie.
     */
    function doesNumeroDossierSequenceExists($sequence_name) {
        /**
         * On interroge la base de données pour vérifier si la séquence existe
         * ou non. Si il y a un retour à l'exécution de la requête alors la
         * séquence existe et si il n'y en a pas alors la séquence n'existe
         * pas.
         *
         * Cette requête particulière (car sur la table pg_class) nécessite
         * d'être exécutée sur le schéma public pour fonctionner correctement.
         * En effet, par défaut postgresql positionne search_path avec la
         * valeur '"$user", public' ce qui peut causer des mauvais effets de
         * bord si l'utilisateur et le schéma sont identiques.
         * On force donc le schéma public sur le search_path pour être sûr que
         * la requête suivante s'exécute correctement.
         */
        $res_search_path = $this->f->db->query("set search_path=public;");

        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    * 
                FROM 
                    pg_class 
                WHERE
                    relkind = \'S\' 
                    AND oid::regclass::text = \'%s\'
                ;',
                $this->f->db->escapeSimple(strtolower($sequence_name))
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                'dossier_autorisation'
            );
            return null;
        }

        return $qres['result'] !== null;
    }

    /**
     * Retourne le numéro de dossier le plus élevé pour ces DA.
     * Si aucun DA n'existe, alors retourne 0.
     * Si une erreur survient, alors retourne 'null'.
     *
     * @param string $datc  Code du type de dossier d'autorisation.
     * @param string $annee Année de la date de dépôt initial.
     * @param string $dep   Code département.
     * @param string $com   Code commune.
     *
     * @return mixed  int ou null.
     */
    function getMaxDANumeroDossier($datc = '', $annee = '', $dep = '', $com = '') {

        // Récupération du dernier DA pour ce typeDA, cette année de dépôt et ces codes
        // département et commune.
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    MAX(numerotation_num) AS max_da_num
                 FROM
                    %1$sdossier_autorisation
                 WHERE
                    dossier_autorisation ILIKE \'%2$s%3$s%4$s%5$s%%\'',
                DB_PREFIXE,
                // TODO utiliser les données du DA et comparer avec les champs associés à ces données
                //      plutôt qu'en recomposant le numéro de dossier
                $this->f->db->escapesimple($datc),
                $this->f->db->escapesimple(strtoupper($dep)),
                $this->f->db->escapesimple($com),
                $this->f->db->escapesimple($annee)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") { //PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                'dossier_autorisation'
            );
            return null;
        }

        return $qres['result'] !== null ? intval(substr($qres['result'], -4)) : 0;
    }

    /**
     * Retourne le numéro suivant de la séquence des DA identifiées par les
     * quatre paramètres (PC, 15, 013, 055).
     *
     * Il est possible qu'il existe une/des 'race conditions' dans le code de cette fonction!
     * TODO: check race conditions
     *
     * @param string $datc   Code du type de dossier d'autorisation.
     * @param string $annee  Année de la date de dépôt initial.
     * @param string $dep    Code département.
     * @param string $com    Code commune.
     * @param string $seq    Valeur "souhaitée" de la séquence du numéro dossier
     *
     * @return string numéro de dossier ou false.
     */
    function createNumeroDossier($datc, $annee, $dep, $com, $seq = null) {

        // Compose le nom de la séquence
        if(! ($sequence_name = $this->compose_sequence_name($datc, $annee, $dep, $com))) {
            // en cas d'erreur
            return false;
        }
        // Supprime la chaîne "_seq" à la fin du nom de la séquence
        if (strlen($sequence_name) < 4 && substr($sequence_name, -4) !== '_seq') {
            // en cas d'erreur
            return false;
        }
        $table_name = substr($sequence_name, 0, -4);

        // est-ce que la séquence existe?
        if(($sequence_exists = $this->doesNumeroDossierSequenceExists($sequence_name)) === null) {
            // en cas d'erreur
            return false;
        }

        // la séquence n'existe pas
        if (! $sequence_exists) {

            // on la crée
            if(! $this->createSequenceNumeroDossier($table_name)) {
                // en cas d'erreur
                return false;
            }
        }

        // si la séquence n'existait pas ou
        // si une valeur "manuelle" de '$seq" a été passée en paramètre et est numérique
        if (! $sequence_exists || is_numeric($seq)) {

            // la valeur courante de la séquence est supposée être le max() des numéros de dossiers
            // courant des DA, car la séquence est supposée suivre cette progression des id générés.

            // on récupère donc le max() des numéros de dossier des DA
            if(($maxDANumDossier = $this->getMaxDANumeroDossier($datc, $annee, $dep, $com)) === null) {
                // en cas d'erreur
                return false;
            }

            // prochaine valeur de la sequence
            // par défaut égale au max() des numéros de dossier des DA
            $seqval = $maxDANumDossier;

            // si la valeur "manuelle" de '$seq" passée en paramètre
            // est supérieure au max() des numéros de dossier des DA
            if (is_numeric($seq) && intval($seq) > $maxDANumDossier) {

                // la prochaine valeur de la séquence devra prendre cette valeur
                $seqval = intval($seq);
            }

            // si la prochaine valeur de la séquence est strictement positive et
            // si la séquence n'existait pas ou si la prochaine valeur de la séquence est supérieure
            // au max() des numéros de dossier des DA
            if ($seqval > 0 && (! $sequence_exists || $seqval > $maxDANumDossier)) {

                // on définit la valeur de la séquence par la valeur de '$seqval'
                if (! $this->setSequenceValueNumeroDossier($sequence_name, $seqval)) {
                    // en cas d'erreur
                    return false;
                }
            }
        }

        // si aucune valeur "manuelle" de '$seq" n'a été passée en paramètre
        if (! is_numeric($seq)) {

            // récupère le prochaine numéro de la séquence
            $nextID = $this->f->db->nextId($table_name, false);
            $this->addToLog(__METHOD__.'(): db->nextId("'.$table_name.'", false);', VERBOSE_MODE);


            // erreur
            if ($this->f->isDatabaseError($nextID, true) === true) {
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db(
                    $res_seq->getDebugInfo(),
                    $res_seq->getMessage(),
                    'dossier_autorisation'
                );
                return false;
            }
        }
        // sinon on affecte la valeur saisie à '$nextId'
        else {
            $nextID = intval($seq);
        }

        /**
         * On retourne le numéro du dossier sur quatre caractères complétés par des zéros.
         * Exemple : '0012'
         */
        $numero_dossier = str_pad($nextID, 4, "0", STR_PAD_LEFT);

        //
        if ($numero_dossier > 9999) {
            $this->addToMessage(__("Vous ne pouvez pas saisir un dossier dont la numérotation dépasse 9999."));
            return false;
        }

        return $numero_dossier;
    }

    /**
     * Retourne la liste des demandeurs liés à une demande, à un dossier d'instruction
     * ou à un dossier d'autorisation.
     *
     * @param  string $from Table liée : "demande", "dossier", dossier_autorisation"
     * @param  string $id   Identifiant (clé primaire de la table liée en question)
     *
     * @return array
     */
    public function get_list_demandeur($from, $id) {
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
                "origin" => __METHOD__,
            )
        );
        return $qres['result'];
    }

    /**
     * Méthode permettant de récupérer les id des demandeurs liés à la table
     * liée passée en paramètre
     *
     * @param string $from Table liée : "demande", "dossier", dossier_autorisation"
     * @param string $id Identifiant (clé primaire de la table liée en question)
     */
    function listeDemandeur($from, $id) {
        // Récupération et stockage en attribut des demandeurs
        foreach($this->get_list_demandeur($from, $id) as $demandeur) {
            $demandeur_type = $demandeur['type_demandeur'];
            if ($demandeur['petitionnaire_principal'] == 't'){
                $demandeur_type .= "_principal";
            }
            $this->valIdDemandeur[$demandeur_type][] = $demandeur['demandeur'];
        }
    }

    /**
     * Ajout de la liste des demandeurs
     */
    function formSpecificContent($maj) {
        if(!$this->correct AND $maj != 0) {
            $this->listeDemandeur("dossier_autorisation", $this->val[array_search('dossier_autorisation', $this->champs)]);
        }
        if($maj < 2 AND !$this->correct) {
            $linkable = true;
        } else {
            $linkable = false;
        }

        // Conteneur de la listes des demandeurs
        echo "<div id=\"liste_demandeur\" class=\"demande_hidden_bloc col_12\">";
        echo "<fieldset class=\"cadre ui-corner-all ui-widget-content\">";
        echo "  <legend class=\"ui-corner-all ui-widget-content ui-state-active\">"
                ._("Petitionnaire")."</legend>";
        // Si des demandeurs sont liés à la demande

            // Affichage du bloc pétitionnaire principal / délégataire
            // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
            echo "<div id=\"petitionnaire_principal_delegataire\">";
            // Affichage de la synthèse
            if (isset ($this->valIdDemandeur["petitionnaire_principal"]) AND
                !empty($this->valIdDemandeur["petitionnaire_principal"])) {
                $demandeur = $this->f->get_inst__om_dbform(array(
                    "obj" => "petitionnaire",
                    "idx" => $this->valIdDemandeur["petitionnaire_principal"],
                ));
                $demandeur -> afficherSynthese("petitionnaire_principal", $linkable);
                $demandeur -> __destruct();
            }
            // Si en édition de formulaire
            if($maj < 2) {
                // Bouton d'ajout du pétitionnaire principal
                // L'ID DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
                echo "<a href=\"#\" id=\"add_petitionnaire_principal\"
                    class=\"om-form-button add-16\">".
                    _("Saisir le petitionnaire principal").
                "</a>";
            }
            // Bouton d'ajout du delegataire
            // L'ID DU DIV ET DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
            echo "<div id=\"delegataire\">";
            if ($maj < 2 OR ($maj == 3 AND !empty($this->valIdDemandeur["delegataire"]))) {
                echo " <span class=\"om-icon om-icon-16 om-icon-fix arrow-right-16\">
                        <!-- -->
                    </span> ";
            }
            // Affichage de la synthèse
            if (isset ($this->valIdDemandeur["delegataire"]) AND
                !empty($this->valIdDemandeur["delegataire"])) {
                $demandeur = $this->f->get_inst__om_dbform(array(
                    "obj" => "delegataire",
                    "idx" => $this->valIdDemandeur["delegataire"],
                ));
                $demandeur -> afficherSynthese("delegataire", $linkable);
                $demandeur -> __destruct();
            }
            if($maj < 2) {
                echo "<a href=\"#\" id=\"add_delegataire\"
                        class=\"om-form-button add-16\">".
                        _("Saisir un autre correspondant").
                    "</a>";
            }
            echo "</div>";
            
            echo "</div>";
            // Bloc des pétitionnaires secondaires
            // L'ID DU DIV SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
            echo "<div id=\"listePetitionnaires\">";

             // Affichage de la synthèse
            if (isset ($this->valIdDemandeur["petitionnaire"]) AND
                !empty($this->valIdDemandeur["petitionnaire"])) {
                
                foreach ($this->valIdDemandeur["petitionnaire"] as $petitionnaire) {
                    $demandeur = $this->f->get_inst__om_dbform(array(
                        "obj" => "petitionnaire",
                        "idx" => $petitionnaire,
                    ));
                    $demandeur -> afficherSynthese("petitionnaire", $linkable);
                    $demandeur -> __destruct();
                }
                
            }
            if ($maj < 2) {
                // L'ID DE L'INPUT SUIVANT EST NECESSAIRE AU BON FONCTIONNEMENT DU JS
                echo "<a href=\"#\" id=\"add_petitionnaire\"
                        class=\"om-form-button add-16\">".
                        _("Ajouter un petitionnaire")
                    ."</a>";
            }
            echo "</div>";
        echo "</fieldset>";
        echo "</div>";
    }

    /**
     * Mise à jour de la localisation du dossier d'autorisation.
     * Concerne  le terrain, l'arrondissement et les parcelles (les références
     * cadastrales).
     *
     * @return boolean
     */
    function update_da_localisation($params = array()) {
        /*
         * Mise à jour des données (terrain, ref. cadastrales, demandeurs, lots)
         * si au moins un dossier a été accepté
         */

        // Dans le mode de suppression des données
        if ($params['delete'] === true) {
            // Toutes les valeurs concernant la localisation sont effacées
            $valF = array(
                'terrain_references_cadastrales' => null,
                'terrain_adresse_voie_numero' => null,
                'terrain_adresse_voie' => null,
                'terrain_adresse_lieu_dit' => null,
                'terrain_adresse_localite' => null,
                'terrain_adresse_code_postal' => null,
                'terrain_adresse_bp' => null,
                'terrain_adresse_cedex' => null,
                'terrain_superficie' => null,
                'arrondissement' => null,
                'adresse_normalisee' => null,
                'adresse_normalisee_json' => null,
            );
            $res = $this->f->db->autoExecute(
                sprintf('%s%s', DB_PREFIXE, $this->table),
                $valF,
                DB_AUTOQUERY_UPDATE,
                sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
            );
            $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                return false;
            }
            // On supprime toutes les lignes de la table 
            // dossier_autorisation_parcelle qui font référence au 
            // dossier d'autorisation
            $this->supprimer_dossier_autorisation_parcelle($this->getVal('dossier_autorisation'));

            //
            return true;
        }

        //terrain
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier.terrain_references_cadastrales,
                    dossier.terrain_adresse_voie_numero,
                    dossier.terrain_adresse_voie,
                    dossier.terrain_adresse_lieu_dit,
                    dossier.terrain_adresse_localite,
                    dossier.terrain_adresse_code_postal,
                    dossier.terrain_adresse_bp,
                    dossier.terrain_adresse_cedex,
                    dossier.terrain_superficie,
                    dossier.adresse_normalisee,
                    dossier.adresse_normalisee_json
                FROM
                    %1$sdossier
                %2$s',
                DB_PREFIXE,
                $params['query_where']
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                ''
            );
            $this->addToLog( __METHOD__.'() : '.$qres["message"], DEBUG_MODE);
            return false;
        }
        $row_terrain = array_shift($qres['result']);

        if ($row_terrain != null) {
            //On récupère l'arrondissement, si le code postal est renseigné dans
            //le dossier d'instruction
            if (isset($row_terrain['terrain_adresse_code_postal']) &&
                $row_terrain['terrain_adresse_code_postal'] !== "") {

                $qres = $this->f->get_one_result_from_db_query(
                    sprintf(
                        'SELECT
                            arrondissement
                        FROM
                            %1$sarrondissement
                        WHERE
                            code_postal = \'%2$s\'',
                        DB_PREFIXE,
                        $this->f->db->escapeSimple($row_terrain['terrain_adresse_code_postal'])
                    ),
                    array(
                        "origin" => __METHOD__
                    )
                );

                $row_terrain['arrondissement'] = $qres['result'];
            }

            // Tous les champs vides sont mis à NULL pour éviter les erreurs de base lors de l'update
            foreach ($row_terrain as $key => $champ) {
                if ($champ == "") {
                    $row_terrain[$key] = NULL;
                }
            }
            $res_update_terrain = $this->f->db->autoExecute(
                DB_PREFIXE."dossier_autorisation",
                $row_terrain,
                DB_AUTOQUERY_UPDATE,
                "dossier_autorisation = '".$this->getVal("dossier_autorisation")."'"
            );
            $this->addToLog(
                __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."dossier_autorisation\", ".print_r($row_terrain, true).", DB_AUTOQUERY_UPDATE, \"dossier_autorisation = '".$this->getVal("dossier_autorisation")."'\");",
                VERBOSE_MODE
            );
            if ($this->f->isDatabaseError($res_update_terrain)) { // PP
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db($res_update_terrain->getDebugInfo(), $res_update_terrain->getMessage(), '');
                $this->addToLog( __METHOD__.'() : '.$res_update_terrain->getMessage(), DEBUG_MODE);
                return false;
            }
        }

        // Si le champ des références cadastrales n'est pas vide
        if ( $params['force_calcul_parcelles'] === true || $this->getVal('terrain_references_cadastrales') 
            != $row_terrain['terrain_references_cadastrales']) {

            // On supprime toutes les lignes de la table 
            // dossier_autorisation_parcelle qui font référence au 
            // dossier d'autorisation en cours de suppression
            $this->supprimer_dossier_autorisation_parcelle(
                $this->getVal('dossier_autorisation')
            );

            // Ajout des parcelles dans la table dossier_autorisation_parcelle
            $this->ajouter_dossier_autorisation_parcelle(
                $this->getVal('dossier_autorisation'), 
                $row_terrain['terrain_references_cadastrales']
            );

        }
        //
        return true;
    }

    /**
     * Mise à jour des lots liés au dossier d'autorisation.
     *
     * @return boolean
     */
    function update_da_lot($params = array()) {
        // Dans le mode de suppression des données
        if ($params['delete'] === true) {
            // Toutes les valeurs concernant la localisation sont effacées
            $valF = array(
                'dossier_autorisation' => null,
            );
            $res = $this->f->db->autoExecute(
                sprintf('%s%s', DB_PREFIXE, 'lot'),
                $valF,
                DB_AUTOQUERY_UPDATE,
                sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
            );
            $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, 'lot')."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                return false;
            }

            //
            return true;
        }

        $valLot['dossier_autorisation'] = NULL;
        $res_update_lots = $this->f->db->autoexecute(
            DB_PREFIXE."lot",
            $valLot,
            DB_AUTOQUERY_UPDATE,
            "dossier_autorisation='".$this->getVal("dossier_autorisation")."'"
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."lot\", ".print_r($valLot, true).", DB_AUTOQUERY_UPDATE, \"dossier_autorisation='".$this->getVal("dossier_autorisation")."'\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res_update_lots)) { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res_update_terrain->getDebugInfo(), $res_update_terrain->getMessage(), '');
            $this->addToLog(__METHOD__.'() : '.$res_update_terrain->getMessage(), DEBUG_MODE);
            return false;
        }
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    lot.lot 
                FROM
                    %1$slot
                    LEFT JOIN %1$sdossier ON dossier.dossier = lot.dossier
                %2$s',
                DB_PREFIXE,
                $params['query_where']
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { //PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$qres["message"], DEBUG_MODE);
            return false;
        }
        // Définition du lien entre lot et dossier_autorisation pour chaque lot
        $valLotUpdate['dossier_autorisation'] = $this->getVal("dossier_autorisation");
        // XXX Sauvegarde des id des lots pour traitement ultérieur 
        // les lots ne devraient pas être liés au DA mais une copie de ces lots
        // devraient l'être.
        $liste_lots = array();
        // On lie chaque lot en définissant l'id du dossier d'autorisation
        foreach ($qres['result'] as $rowlot) {
            $liste_lots[] = $rowlot['lot'];
            $res_lots_update = $this->f->db->autoexecute(
                DB_PREFIXE."lot",
                $valLotUpdate,
                DB_AUTOQUERY_UPDATE,
                "lot=".$rowlot['lot']
            );
            $this->addToLog(
                __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."lot\", ".print_r($valLotUpdate, true).", DB_AUTOQUERY_UPDATE, \"lot=".$rowlot['lot']."\");",
                VERBOSE_MODE
            );
            if ($this->f->isDatabaseError($res_lots_update)) { // PP
                // Appel de la methode de recuperation des erreurs
                $this->erreur_db($res_lots_update->getDebugInfo(), $res_lots_update->getMessage(), '');
                $this->addToLog(__METHOD__.'() : '.$res_lots_update->getMessage(), DEBUG_MODE);
                return false;
            }
        }
        //
        return true;
    }

    /**
     * Mise à jour des demandeurs du dossier d'autorisation.
     *
     * @return boolean
     */
    function update_da_demandeur($params = array()) {
        // Dans le mode de suppression des données
        if ($params['delete'] === true) {
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        lien_dossier_autorisation_demandeur
                    FROM
                        %1$slien_dossier_autorisation_demandeur
                    WHERE
                        dossier_autorisation = \'%2$s\'',
                    DB_PREFIXE,
                    $this->getVal($this->clePrimaire)
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($qres['code'] !== 'OK') {
                return false;
            }
            foreach ($qres['result'] as $lien) {
                $inst_lien_da_demandeur = $this->f->get_inst__om_dbform(array(
                    "obj" => "lien_dossier_autorisation_demandeur",
                    "idx" => $lien['lien_dossier_autorisation_demandeur'],
                ));
                $inst_lien_da_demandeur->setParameter('maj', 2);
                $delete = $inst_lien_da_demandeur->supprimer(array_combine($inst_lien_da_demandeur->champs, $inst_lien_da_demandeur->val));
                if ($delete === false) {
                    return false;
                }
            }

            //
            return true;
        }

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    lien_dossier_demandeur.demandeur,
                    lien_dossier_demandeur.petitionnaire_principal,
                    lien_dossier_demandeur.lien_dossier_demandeur,
                    lien_dossier_demandeur.dossier
                FROM
                    %1$slien_dossier_demandeur
                    LEFT JOIN %1$sdossier ON lien_dossier_demandeur.dossier = dossier.dossier
                %2$s',
                DB_PREFIXE,
                $params['query_where']
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$qres["message"], DEBUG_MODE);
            return false;
        }
        $sql_delete_liens_da_demandeur = "DELETE FROM ".DB_PREFIXE."lien_dossier_autorisation_demandeur
                                            WHERE dossier_autorisation='".$this->getVal("dossier_autorisation")."'";
        $res_delete_liens_da_demandeur = $this->f->db->query($sql_delete_liens_da_demandeur);
        $this->addToLog(__METHOD__."(): db->query(\"".$sql_delete_liens_da_demandeur."\")", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res_delete_liens_da_demandeur)) { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res_delete_liens_da_demandeur->getDebugInfo(), $res_delete_liens_da_demandeur->getMessage(), '');
            $this->addToLog(__METHOD__.'() : '.$res_delete_liens_da_demandeur->getMessage(), DEBUG_MODE);
            return false;
        }
        // Définition de l'id du DA
        $valDemandeurUpdate["lien_dossier_autorisation_demandeur"] = NULL;
        $valDemandeurUpdate['dossier_autorisation'] = $this->getVal("dossier_autorisation");
        // Pour chaque demandeur on créer un lien avec le DA

        foreach ($qres['result'] as $rowDemandeur) {
            // Ajout de l'id du demandeur et du flag petitionnaire_principal
            // aux données à insérer
            $valDemandeurUpdate["demandeur"] = $rowDemandeur["demandeur"];
            $valDemandeurUpdate["petitionnaire_principal"] =
                $rowDemandeur["petitionnaire_principal"];
            // Instanciation d'un lien dossier_autorisation/demandeur en ajout
            $ldad = $this->f->get_inst__om_dbform(array(
                "obj" => "lien_dossier_autorisation_demandeur",
                "idx" => "]",
            ));
            // Ajout d'un enregistrement avec les données des liens
            $ldad->ajouter($valDemandeurUpdate);
        }
        //
        return true;
    }

    /**
     * Mise à jour de l'état du dossier d'autorisation.
     *
     * @return boolean
     */
    function update_da_etat($params = array()) {
        // Dans le mode de suppression des données
        if ($params['delete'] === true) {
            // Toutes les valeurs concernant la localisation sont effacées
            $valF = array(
                'etat_dernier_dossier_instruction_accepte' => null,
                'etat_dossier_autorisation' => null,
                'avis_decision' => null,
            );
            $res = $this->f->db->autoExecute(
                sprintf('%s%s', DB_PREFIXE, $this->table),
                $valF,
                DB_AUTOQUERY_UPDATE,
                sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
            );
            $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                return false;
            }

            //
            return true;
        }

        /**
         * Mise à jour de l'état
         */
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    avis_decision.typeavis,
                    avis_decision.avis_decision
                FROM
                    %1$sdossier
                    LEFT JOIN %1$savis_decision ON dossier.avis_decision = avis_decision.avis_decision
                %2$s',
                DB_PREFIXE,
                $params['query_where']
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$qres["message"], DEBUG_MODE);
            return false;
        }
        $row_etat = array_shift($qres['result']);
        $etatDA = array();

        // Cas initial : on défini les trois valeurs par défaut
        // (elles seront écrasées si $res_encours->numRows() > 1)

        // Correspondance entre typeavis et etat_dossier_autorisation
        switch ($row_etat['typeavis']) {
            case 'F':
                // typeavis F => Accordé
                $etatDA['etat_dernier_dossier_instruction_accepte'] = 2;
                $etatDA['etat_dossier_autorisation'] = 2;
                break;
            case 'D':
                // typeavis D => Refusé
                $etatDA['etat_dernier_dossier_instruction_accepte'] = 4;
                $etatDA['etat_dossier_autorisation'] = 4;
                break;
            case 'A':
                // typeavis A => Abandonné
                $etatDA['etat_dernier_dossier_instruction_accepte'] = 3;
                $etatDA['etat_dossier_autorisation'] = 3;
                break;
            default:
                // typeavis '' => En cours
                $etatDA['etat_dernier_dossier_instruction_accepte'] = null;
                $etatDA['etat_dossier_autorisation'] = 1;
                break;
        }
        $etatDA['avis_decision'] = $row_etat['avis_decision'];

        foreach($etatDA as $key=>$val) {
            if($val=="") {
                $etatDA[$key] = null;
            }
        }

        $res_update_etat = $this->f->db->autoexecute(
            DB_PREFIXE."dossier_autorisation",
            $etatDA,
            DB_AUTOQUERY_UPDATE,
            "dossier_autorisation = '".$this->getVal("dossier_autorisation")."'"
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."dossier_autorisation\", ".print_r($etatDA, true).", DB_AUTOQUERY_UPDATE, \"dossier_autorisation = '".$this->getVal("dossier_autorisation")."'\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res_update_etat)) { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $res_update_etat->getDebugInfo(),
                $res_update_etat->getMessage(),
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$res_update_etat->getMessage(), DEBUG_MODE);
            return false;
        }
        //
        return true;
    }

    /**
     * Mise à jour des dates initiales du dossier d'autorisation.
     * Concerne la date de dépôt et la date de décision.
     *
     * @return boolean
     */
    function update_da_date_init($params = array()) {
        // Dans le mode de suppression des données
        if ($params['delete'] === true) {
            // Toutes les valeurs concernant la localisation sont effacées
            $valF = array(
                'date_depot' => null,
                'date_decision' => null,
            );
            $res = $this->f->db->autoExecute(
                sprintf('%s%s', DB_PREFIXE, $this->table),
                $valF,
                DB_AUTOQUERY_UPDATE,
                sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
            );
            $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                return false;
            }

            //
            return true;
        }

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    date_depot,
                    date_decision
                FROM
                    %1$sdossier
                %2$s',
                DB_PREFIXE,
                $params['query_where']
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$qres["message"], DEBUG_MODE);
            return false;
        }
        $row_date = array_shift($qres['result']);
        // Si pas de date on remplace "" par NULL pour éviter
        // les erreurs de base de données
        foreach($row_date as $key => $date) {
            if($date == "") {
                $row_date[$key] = null;
            }
        }
        // Mise à jour du DA avec ces nouvelles dates
        $res_update_date = $this->f->db->autoexecute(
            DB_PREFIXE."dossier_autorisation",
            $row_date,
            DB_AUTOQUERY_UPDATE,
            "dossier_autorisation = '".$this->getVal("dossier_autorisation")."'"
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."dossier_autorisation\", ".print_r($row_date, true).", DB_AUTOQUERY_UPDATE, \"dossier_autorisation = '".$this->getVal("dossier_autorisation")."'\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res_update_date)) { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $res_update_date->getDebugInfo(),
                $res_update_date->getMessage(),
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$res_update_date->getMessage(), DEBUG_MODE);
            return false;
        }
        //
        return true;
    }

    /**
     * Mise à jour de la date de validité du dossier d'autorisation.
     *
     * @return boolean
     */
    function update_da_date_validite($params = array()) {
        // Dans le mode de suppression des données
        if ($params['delete'] === true) {
            // Toutes les valeurs concernant la localisation sont effacées
            $valF = array(
                'date_validite' => null,
            );
            $res = $this->f->db->autoExecute(
                sprintf('%s%s', DB_PREFIXE, $this->table),
                $valF,
                DB_AUTOQUERY_UPDATE,
                sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
            );
            $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                return false;
            }

            //
            return true;
        }

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    date_validite
                FROM
                    %1$sdossier
                %2$s',
                DB_PREFIXE,
                $params['query_where']
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$qres["message"], DEBUG_MODE);
            return false;
        }
        $row_date = array_shift($qres['result']);
        // Si pas de date on remplace "" par NULL pour éviter
        // les erreurs de base de données
        foreach($row_date as $key => $date) {
            if($date == "") {
                $row_date[$key] = null;
            }
        }
        // Mise à jour du DA avec ces nouvelles dates
        $res_update_date = $this->f->db->autoexecute(
            DB_PREFIXE."dossier_autorisation",
            $row_date,
            DB_AUTOQUERY_UPDATE,
            "dossier_autorisation = '".$this->getVal("dossier_autorisation")."'"
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."dossier_autorisation\", ".print_r($row_date, true).", DB_AUTOQUERY_UPDATE, \"dossier_autorisation = '".$this->getVal("dossier_autorisation")."'\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res_update_date)) { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $res_update_date->getDebugInfo(),
                $res_update_date->getMessage(),
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$res_update_date->getMessage(), DEBUG_MODE);
            return false;
        }
        //
        return true;
    }

    /**
     * Mise à jour de la date de déclaration d'ouverture de chantier du dossier
     * d'autorisation.
     *
     * @return boolean
     */
    function update_da_date_doc($params = array()) {
        // Dans le mode de suppression des données
        if ($params['delete'] === true) {
            // Toutes les valeurs concernant la localisation sont effacées
            $valF = array(
                'date_chantier' => null,
            );
            $res = $this->f->db->autoExecute(
                sprintf('%s%s', DB_PREFIXE, $this->table),
                $valF,
                DB_AUTOQUERY_UPDATE,
                sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
            );
            $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                return false;
            }

            //
            return true;
        }

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    date_chantier
                FROM
                    %1$sdossier
                %2$s',
                DB_PREFIXE,
                $params['query_where']
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$qres["message"], DEBUG_MODE);
            return false;
        }
        $row_date = array_shift($qres['result']);
        // Si pas de date on remplace "" par NULL pour éviter
        // les erreurs de base de données
        foreach($row_date as $key => $date) {
            if($date == "") {
                $row_date[$key] = null;
            }
        }
        // Mise à jour du DA avec ces nouvelles dates
        $res_update_date = $this->f->db->autoexecute(
            DB_PREFIXE."dossier_autorisation",
            $row_date,
            DB_AUTOQUERY_UPDATE,
            "dossier_autorisation = '".$this->getVal("dossier_autorisation")."'"
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."dossier_autorisation\", ".print_r($row_date, true).", DB_AUTOQUERY_UPDATE, \"dossier_autorisation = '".$this->getVal("dossier_autorisation")."'\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res_update_date)) { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $res_update_date->getDebugInfo(),
                $res_update_date->getMessage(),
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$res_update_date->getMessage(), DEBUG_MODE);
            return false;
        }
        //
        return true;
    }

    /**
     * Mise à jour de la date de déclaration d'achèvement et de conformité des
     * travaux du dossier d'autorisation.
     *
     * @return boolean
     */
    function update_da_date_daact($params = array()) {
        // Dans le mode de suppression des données
        if ($params['delete'] === true) {
            // Toutes les valeurs concernant la localisation sont effacées
            $valF = array(
                'date_achevement' => null,
            );
            $res = $this->f->db->autoExecute(
                sprintf('%s%s', DB_PREFIXE, $this->table),
                $valF,
                DB_AUTOQUERY_UPDATE,
                sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
            );
            $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
            if ($this->f->isDatabaseError($res, true) === true) {
                return false;
            }

            //
            return true;
        }

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    date_achevement
                FROM
                    %1$sdossier
                %2$s',
                DB_PREFIXE,
                $params['query_where']
            ),
            array(
                'origin' => __METHOD__
            )
        );
        if ($qres['code'] !== 'OK') { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$qres["message"], DEBUG_MODE);
            return false;
        }
        $row_date = array_shift($qres['result']);
        // Si pas de date on remplace "" par NULL pour éviter
        // les erreurs de base de données
        foreach($row_date as $key => $date) {
            if($date == "") {
                $row_date[$key] = null;
            }
        }
        // Mise à jour du DA avec ces nouvelles dates
        $res_update_date = $this->f->db->autoexecute(
            DB_PREFIXE."dossier_autorisation",
            $row_date,
            DB_AUTOQUERY_UPDATE,
            "dossier_autorisation = '".$this->getVal("dossier_autorisation")."'"
        );
        $this->addToLog(
            __METHOD__."(): db->autoexecute(\"".DB_PREFIXE."dossier_autorisation\", ".print_r($row_date, true).", DB_AUTOQUERY_UPDATE, \"dossier_autorisation = '".$this->getVal("dossier_autorisation")."'\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res_update_date)) { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $res_update_date->getDebugInfo(),
                $res_update_date->getMessage(),
                ''
            );
            $this->addToLog(__METHOD__.'() : '.$res_update_date->getMessage(), DEBUG_MODE);
            return false;
        }
        //
        return true;
    }

    /**
     * Mise à jour des données techniques du dossier d'autorisation.
     *
     * @return boolean
     */
    function update_da_dt($params = array()) {
        // Dans le cas d'une reprise de l'instruction du DI ou de la suppression
        // de celui-ci
        // Met à jour les données techniques du dossier d'autorisation en
        // fusionnant celles des dossiers d'instruction dans l'ordre de clôture
        // if ($params['di_reopened'] === true) {
        //     $query_da_list_di = sprintf('
        //         SELECT
        //             dossier.dossier,
        //             dossier.version_clos,
        //             donnees_techniques.donnees_techniques
        //         FROM %1$sdossier
        //         INNER JOIN %1$sdonnees_techniques
        //             ON dossier.dossier = donnees_techniques.dossier_instruction
        //         WHERE dossier.dossier_autorisation = \'%2$s\'
        //             AND dossier.version_clos IS NOT NULL
        //         ORDER BY dossier.version_clos ASC
        //         ',
        //         DB_PREFIXE,
        //         $this->getVal($this->clePrimaire)
        //     );
        //     $res_da_list_di = $this->f->get_all_results_from_db_query(
        //         $query_da_list_di,
        //         array(
        //             "origin" => __METHOD__,
        //             "force_return" => true,
        //         )
        //     );
        //     if ($res_da_list_di['code'] === 'KO') {
        //         return false;
        //     }
        //     // Il ne reste que le dossier d'instruction initial
        //     if (empty($res_da_list_di['result']) === false) {
        //         $res_dt_da_id = $this->f->get_one_result_from_db_query(
        //             sprintf(
        //                 'SELECT
        //                     donnees_techniques
        //                 FROM
        //                     %1$sdonnees_techniques
        //                 WHERE
        //                     dossier_autorisation = \'%2$s\'',
        //                 DB_PREFIXE,
        //                 $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
        //             ),
        //             array(
        //                 "origin" => __METHOD,
        //                 "force_return" => true,
        //             )
        //         );
        //         if ($res_dt_da_id["code"] !== "OK") {
        //             return false;
        //         }
        //         $dt_da = $this->f->get_inst__om_dbform(array(
        //             "obj" => "donnees_techniques",
        //             "idx" => $res_dt_da_id['result'],
        //         ));
        //         $dt_da_merged_from_di = array();
        //         foreach ($dt_da->champs as $champ) {
        //             $dt_da_merged_from_di[$champ] = '';
        //         }
        //         foreach ($res_da_list_di['result'] as $di) {
        //             $dt_di = $this->f->get_inst__om_dbform(array(
        //                 "obj" => "donnees_techniques",
        //                 "idx" => $di['donnees_techniques'],
        //             ));
        //             $dt_di_val = array_combine($dt_di->champs, $dt_di->val);
        //             $dt_di_val_diff = array_diff_assoc($dt_di_val, $dt_da_merged_from_di);
        //             foreach ($dt_di_val_diff as $dt_di_val_diff_key => $dt_di_val_diff_val) {
        //                 if ($dt_di_val_diff_val === '') {
        //                     unset($dt_di_val_diff[$dt_di_val_diff_key]);
        //                 }
        //             }
        //             $dt_da_merged_from_di = array_merge($dt_da_merged_from_di, $dt_di_val_diff);
        //         }
        //         $dt_da_merged_from_di["dossier_autorisation"] = $this->getVal($this->clePrimaire);
        //         $dt_da_merged_from_di["dossier_instruction"] = null;
        //         $dt_da_merged_from_di["lot"] = null;
        //         $dt_da_merged_from_di["donnees_techniques"] = $res_dt_da_id['result'];
        //         $dt_da->setParameter('maj', 1);
        //         if ($dt_da->modifier($dt_da_merged_from_di) === false) {
        //             $this->addToLog(__METHOD__."(): ".sprintf(__("Erreur à la mise à jour des données techniques du dossier d'autorisation : %s"), $dt_da->msg), DEBUG_MODE);
        //             return false;
        //         }
        //         return true;
        //     }
        // }

        // Dans le mode de suppression des données
        if ($params['delete'] === true) {
            $res_dt_da_id = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        donnees_techniques
                    FROM
                        %1$sdonnees_techniques
                    WHERE
                        dossier_autorisation = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($res_dt_da_id["code"] !== "OK") {
                return false;
            }
            $dt_da = $this->f->get_inst__om_dbform(array(
                "obj" => "donnees_techniques",
                "idx" => $res_dt_da_id["result"],
            ));
            $valF = array_combine($dt_da->champs, $dt_da->val);
            foreach ($valF as $key => $value) {
                if ($key !== 'donnees_techniques'
                    && $key !== 'dossier_autorisation'
                    && $key !== 'cerfa') {
                    //
                    $valF[$key] = '';
                }
            }
            $dt_da->setParameter('maj', 1);
            $delete = $dt_da->modifier($valF);
            if ($delete === false) {
                $this->addToLog(__METHOD__."(): ".sprintf(__("Erreur à la mise à jour des données techniques du dossier d'autorisation : %s"), $dt_da->msg), DEBUG_MODE);
                return false;
            }

            //
            return true;
        }

        // Récupération de l'id des données techniques du dossier d'instruction
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    donnees_techniques
                FROM
                    %1$sdonnees_techniques
                    INNER JOIN %1$sdossier
                        ON dossier.dossier = donnees_techniques.dossier_instruction
                %2$s',
                DB_PREFIXE,
                ! empty($params['query_where']) ? $params['query_where'] : ''
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") { // PP
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db(
                $qres["message"],
                $qres["message"],
                ''
            );
            $this->addToLog(__METHOD__.'() : '. $qres["message"], DEBUG_MODE);
            return false;
        }

        // Liaison des nouvelles données données techniques au DA
        $dti_id = $qres['result'];
        if ($dti_id === null) {
            $dti_id = "]";
        }
        $dti = $this->f->get_inst__om_dbform(array(
            "obj" => "donnees_techniques",
            "idx" => $dti_id,
        ));
        
        // Création du tableau de valeurs pour report des DT sur le DA
        $dti->setValFFromVal();

        // Récupération du JSON des données techniques initiales du dossier d’instruction
        $inst_di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $dti->valF["dossier_instruction"],
        ));

        // Comparer les différences entre les données techniques initiales et
        // les données techniques actuelles du DI
        $dt_json = $inst_di->getVal('initial_dt');
        $dt_init = json_decode($dt_json, true);
        $diff_dt = array_diff_assoc($dti->valF, $dt_init);

        // On récupère l'instance des DT du DA
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    donnees_techniques
                FROM
                    %1$sdonnees_techniques
                WHERE
                    dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        $dta_id = $qres['result'];

        // On instancie les données techniques
        if($dta_id === null) {
            $dta_id = "]";
        }
        $dta = $this->f->get_inst__om_dbform(array(
            "obj" => "donnees_techniques",
            "idx" => $dta_id,
        ));
        // Gestion de la fusion des données techniques du DA
        if ($dta_id !== "]") {
            // On associe les clés et les valeurs dans 1 seul tableau
            $dta_tab_dt = array_combine($dta->champs, $dta->val);
            // Mise à jour de ces valeurs différentes seulement sur le DA
            $dti->valF = array_merge($dta_tab_dt, $diff_dt);
        }
        // On lie se tableau de DT au DA
        $dti->valF["dossier_autorisation"] = $this->getVal($this->clePrimaire);
        // On délie les données du DI et lots
        $dti->valF["dossier_instruction"] = null;
        $dti->valF["lot"] = null;
        $dti->valF["donnees_techniques"] = $dta->getVal("donnees_techniques");
        if($dta_id != "]") {
            // On met à jour
            $dta->setParameter('maj',1);
            if($dta->modifier($dti->valF) === false) {
                return false;
            }
        } else {
            // On ajoute
            $dta->setParameter('maj',0);
            if($dta->ajouter($dti->valF) === false) {
                return false;
            }
        }
        //
        return true;
    }

    /**
     * Mise à jour de la date de dépôt et de la date de décision du dossier
     * d'autorisation en récupérant la plus récente parmis tous les dossiers
     * d'instruction liés.
     * Utilisé par l'import spécifique de dossier.
     *
     * @return boolean
     */
    function update_da_date_init_import($params = array()) {
        // Récupère la première date de dépôt parmis les dossiers d'instruction
        $date_depot = $this->get_date('date_depot', 'first');
        // En cas d'erreur lors de la récupération de la date renvoie false
        if ($date_depot === false) {
            return false;
        }

        // Récupère la première date de décision parmis les dossiers d'instruction
        $date_decision = $this->get_date('date_decision', 'first');
        // En cas d'erreur lors de la récupération de la date renvoie false
        if ($date_decision === false) {
            return false;
        }

        // Mise à jour du dossier d'autorisation
        $valF = array(
            'date_depot' => ($date_depot != '' ? $date_depot : null),
            'date_decision' => ($date_decision != '' ? $date_decision : null)
        );
        $table = sprintf('%1$s%2$s', DB_PREFIXE, "dossier_autorisation");
        $cle = sprintf('%s=\'%s\'', "dossier_autorisation", $this->getVal("dossier_autorisation"));
        //
        $res = $this->f->db->autoexecute(
            $table,
            $valF,
            DB_AUTOQUERY_UPDATE,
            $cle
        );
        $this->f->addToLog(
            __METHOD__."(): db->autoexecute(\"".$table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$cle."\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res, true) !== false) {
            return false;
        }
        return true;
    }

    /**
     * Mise à jour de la date de déclaration d'ouverture de chantier du dossier
     * d'autorisation en récupérant la plus récente parmis tous les dossiers
     * d'instruction liés.
     * Utilisé par l'import spécifique de dossier.
     *
     * @return boolean
     */
    function update_da_date_doc_import($params = array()) {
        // Récupère la dernière date de chantier parmis les dossiers d'instruction
        $date_chantier = $this->get_date('date_chantier', 'last');
        // En cas d'erreur lors de la récupération de la date renvoie false
        if ($date_chantier === false) {
            return false;
        }
        // Mise à jour du dossier d'autorisation
        $valF = array(
            'date_chantier' => ($date_chantier != '' ? $date_chantier : null),
        );
        $table = sprintf('%1$s%2$s', DB_PREFIXE, "dossier_autorisation");
        $cle = sprintf('%s=\'%s\'', "dossier_autorisation", $this->getVal("dossier_autorisation"));
        //
        $res = $this->f->db->autoexecute(
            $table,
            $valF,
            DB_AUTOQUERY_UPDATE,
            $cle
        );
        $this->f->addToLog(
            __METHOD__."(): db->autoexecute(\"".$table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$cle."\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res, true) !== false) {
            return false;
        }
        return true;
    }

    /**
     * 
     */
    protected function get_date(string $typeDate, $special_date = '') {
        if ($special_date == 'last') {
            $sqlSpecialDate = 'MAX';
        } elseif ($special_date == 'first') {
            $sqlSpecialDate = 'MIN';
        }
        // Récupération de la date souhaitée
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    %4$s(dossier.%3$s) as %3$s
                FROM
                    %1$sdossier
                    INNER JOIN %1$sdossier_autorisation
                        ON dossier.dossier_autorisation = dossier_autorisation.dossier_autorisation
                        AND dossier_autorisation.dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire)),
                $this->f->db->escapeSimple($typeDate),
                $sqlSpecialDate
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres["code"] !== "OK") {
            return false;
        }
        return $qres['result'];
    }

    /**
     * Mise à jour de la date de déclaration d'achèvement et de conformité des
     * travaux du dossier d'autorisation en récupérant la plus récente parmis
     * tous les dossiers d'instruction liés.
     * Utilisé par l'import spécifique de dossier.
     *
     * @return boolean
     */
    function update_da_date_daact_import($params = array()) {
        // Récupère la dernière date d'achevenement parmis les dossiers
        // d'instruction
        $date_achevement = $this->get_date('date_achevement', 'last');
        // En cas d'erreur lors de la récupération de la date renvoie false
        if ($date_achevement === false) {
            return false;
        }

        // Mise à jour du dossier d'autorisation
        $valF = array(
            'date_achevement' => ($date_achevement != '' ? $date_achevement : null),
        );
        $table = sprintf('%1$s%2$s', DB_PREFIXE, "dossier_autorisation");
        $cle = sprintf('%s=\'%s\'', "dossier_autorisation", $this->getVal("dossier_autorisation"));
        //
        $res = $this->f->db->autoexecute(
            $table,
            $valF,
            DB_AUTOQUERY_UPDATE,
            $cle
        );
        $this->f->addToLog(
            __METHOD__."(): db->autoexecute(\"".$table."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".$cle."\");",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res, true) !== false) {
            return false;
        }
        return true;
    }

    /**
     * TREATMENT - update_numero_version_clos
     *
     * @param integer $val Nouvelle valeur
     *
     * @return boolean
     */
    public function update_numero_version_clos($val) {
        //
        $this->begin_treatment(__METHOD__);
        //
        if ($val === '') {
            return $this->end_treatment(__METHOD__, false);
        }
        //
        $this->correct = true;
        $valF = array();
        $valF["numero_version_clos"] = $val;
        //
        $res = $this->f->db->autoExecute(
            sprintf('%s%s', DB_PREFIXE, $this->table),
            $valF,
            DB_AUTOQUERY_UPDATE,
            sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))
        );
        $this->f->addToLog(__METHOD__."(): db->autoexecute(\"".sprintf('%s%s', DB_PREFIXE, $this->table)."\", ".print_r($valF, true).", DB_AUTOQUERY_UPDATE, \"".sprintf("%s = '%s'", $this->clePrimaire, $this->getVal($this->clePrimaire))."\");", VERBOSE_MODE);
        if ($this->f->isDatabaseError($res, true) === true) {
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), '');
            $this->correct = false;
            return $this->end_treatment(__METHOD__, false);
        }
        return $this->end_treatment(__METHOD__, true);
    }

    /**
     * Récupère les mises à jour du dossier d'autorisation à appliquer depuis le
     * type du dossier d'instruction réalisant la mise à jour.
     *
     * @param integer $di_id Identifiant du dossier d'instruction réalisant la
     *                       mise à jour du dossier d'autorisation.
     *
     * @return array Liste des mises à jour à appliquer.
     */
    function get_dit_update_da($di_id) {
        $inst_di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $di_id,
        ));
        $inst_dit = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier_instruction_type",
            "idx" => $inst_di->getVal('dossier_instruction_type'),
        ));
        $res = array();
        $mask = 'maj_da_';
        foreach ($inst_dit->champs as $champ) {
            if (stripos($champ, $mask) !== false
                && $inst_dit->getVal($champ) === 't') {
                //
                $res[] = str_replace($mask, '', $champ);
            }
        }
        return $res;
    }

    /**
     * Méthode permettant de recalculer à tout moment les données en cours de
     * validité d'un dossier d'autorisation
     */
    function majDossierAutorisation($params = array()) {
        //
        $get_params_di = false;
        $get_last_close_di = false;
        $get_all_close_di = false;
        $di_id = (isset($params['di_id']) !== false) ? $params['di_id'] : null;
        $di_reopened = (isset($params['di_reopened']) !== false) ? $params['di_reopened'] : false;

        // Sélection de la méthode de récupération du ou des DI
        if (isset($params['mode_update']) === true) {
            if ($params['mode_update'] === 'get_all_close_di') {
                $get_all_close_di = true;
            } elseif ($params['mode_update'] === 'get_last_close_di') {
                $get_last_close_di = true;
            } elseif ($params['mode_update'] === 'get_params_di') {
                $get_params_di = true;
            }
        } else {
            if ($di_reopened === true) {
                //
                $get_all_close_di = true;
            }
            if ($get_all_close_di === false
                && ($di_id === null || $di_id === '')) {
                //
                $get_last_close_di = true;
            }
            if ($get_all_close_di === false && $get_last_close_di === false) {
                //
                $get_params_di = true;
            }
        }

        // Récupère le dossier d'instruction passé en paramètre
        if ($get_params_di === true) {
            //
            $inst_di = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $di_id,
            ));
            $inst_avis_decision = $this->f->get_inst__om_dbform(array(
                "obj" => "avis_decision",
                "idx" => $inst_di->getVal('avis_decision'),
            ));
            // Le dossier passé en paramètre doit être clôturé ou être l'initial
            if ($inst_di->getVal('version') != 0
                && ($inst_di->getVal('date_decision') === ''
                    || $inst_di->getVal('date_decision') !== null)
                && $inst_avis_decision->getVal('typeavis') !== 'F'
                && $inst_avis_decision->getVal('typeavis') !== 'A') {
                //
                return true;
            }
        }

        // Récupère tous les dossiers clôturés
        if ($get_all_close_di === true) {
            $qres = $this->f->get_all_results_from_db_query(
                sprintf(
                    'SELECT
                        dossier.dossier
                    FROM
                        %1$sdossier
                        INNER JOIN %1$sdonnees_techniques
                            ON dossier.dossier = donnees_techniques.dossier_instruction
                        INNER JOIN %1$savis_decision
                            ON dossier.avis_decision = avis_decision.avis_decision
                        INNER JOIN %1$sdossier_instruction_type
                            ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                    WHERE dossier.dossier_autorisation = \'%2$s\'
                        AND dossier.version_clos IS NOT NULL
                        AND dossier_instruction_type.maj_da_dt IS TRUE
                        AND (avis_decision.typeavis=\'%3$s\'
                            OR avis_decision.typeavis=\'%4$s\')
                    ORDER BY
                        dossier.version_clos ASC,
                        dossier.date_depot ASC',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($this->getVal($this->clePrimaire)),
                    'F',
                    'A'
                ),
                array(
                    "origin" => __METHOD__,
                    "force_return" => true,
                )
            );
            if ($qres['code'] !== 'OK') {
                return false;
            }
            // Dans le cas où il ne reste que le dossier d'instruction initial
            if ($qres['row_count'] === 0) {
                $get_last_close_di = true;
                $get_all_close_di = false;
            }
        }

        // Récupère le dernier dossier clôturé ou l'initial
        if ($get_last_close_di === true) {
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        dossier.dossier
                    FROM
                        %1$sdossier
                        LEFT JOIN %1$savis_decision 
                            ON dossier.avis_decision = avis_decision.avis_decision
                    WHERE
                        dossier.dossier_autorisation = \'%2$s\'
                        AND (dossier.version = 0
                            OR (dossier.date_decision IS NOT NULL
                                AND (avis_decision.typeavis=\'F\'
                                    OR avis_decision.typeavis=\'A\')))
                    ORDER BY
                        dossier.version_clos DESC,
                        dossier.date_depot DESC
                    LIMIT 1',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
                ),
                array(
                    'origin' => __METHOD__,
                    'force_return' => true
                )
            );
            if ($qres['code'] !== 'OK') {
                return false;
            }
            $di_id = $qres['result'];
        }

        // Paramètres commun pour la mise à jour des champs du dossier d'autorisation
        $handle_update_da_params = array(
            'di_reopened' => $di_reopened,
            'updates_da' => (isset($params['updates_da']) !== false) ? $params['updates_da'] : null,
            'force_calcul_parcelles' => (isset($params['force_calcul_parcelles']) !== false) ? $params['force_calcul_parcelles'] : null,
        );

        // Dans le cas de l'utilisation du DI en paramètre ou de la récupération
        // du dernier clôturé
        if ($get_params_di === true || $get_last_close_di === true) {
            //
            $handle_update_da_params['di_id'] = $di_id;
            $handle_update_da = $this->handle_update_da($handle_update_da_params);
            if ($handle_update_da !== true) {
                return false;
            }
        }

        // Dans le cas du recalcul de toutes les données du DA
        if ($get_all_close_di === true) {
            // Suppression de toutes les données du DA mise à jour par les DI
            // Exécute les méthodes de mise à jour du DA en mode suppression
            $updates_da = array(
                'localisation',
                'lot',
                'demandeur',
                'etat',
                'date_init',
                'date_validite',
                'date_doc',
                'date_daact',
                'dt',
            );
            foreach ($updates_da as $update_da) {
                $method = sprintf('update_da_%s', $update_da);
                if(method_exists($this, $method) === true) {
                    $res = $this->$method(array(
                        'delete' => true,
                    ));
                    if ($res !== true) {
                        return $res;
                    }
                }
            }

            // Parcours tous les DI clôturés pour mettre à jour les données du DA
            foreach ($qres['result'] as $di) {
                $handle_update_da_params['di_id'] = $di['dossier'];
                $handle_update_da = $this->handle_update_da($handle_update_da_params);
                if ($handle_update_da !== true) {
                    return false;
                }
            }
        }

        //
        return true;
    }

    /**
     * [handle_update_da description]
     *
     * @param array $params [description]
     *
     * @return [type] [description]
     */
    private function handle_update_da($params = array()) {
        // Condition pour les requêtes de récupération des données du DI dans
        // les différentes méthodes de mise à jour des données du DA
        $query_where = sprintf(
            ' WHERE dossier.dossier = \'%s\' ',
            $params['di_id']
        );

        // Récupération du type détaillé du dossier d'autorisation lié au
        // type du dossier d'instruction
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    datd.dossier_autorisation_type_detaille
                FROM
                    %1$sdossier_autorisation da
                    INNER JOIN %1$sdossier
                        ON da.dossier_autorisation = dossier.dossier_autorisation
                    INNER JOIN %1$sdossier_instruction_type ditype
                        ON ditype.dossier_instruction_type = dossier.dossier_instruction_type
                    INNER JOIN %1$sdossier_autorisation_type_detaille datd
                        ON ditype.dossier_autorisation_type_detaille = datd.dossier_autorisation_type_detaille
                WHERE
                    da.dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            return false;
        }
        $datd = $qres['result'];
        // Si le type de dossier d'autorisation est différent de celui lié
        // au dossier d'autorisation
        if ($datd != $this->getVal("dossier_autorisation_type_detaille")) {
            // Mise à jour du dossier d'autorisation avec nouveau le nouveau
            // datd
            $val = array(
                'dossier_autorisation_type_detaille' => $datd,
            );
            $cle = sprintf('%1$s = \'%2$s\'', 'dossier_autorisation', $this->getVal("dossier_autorisation"));
            $res_update_type = $this->f->db->autoExecute(
                sprintf('%1$s%2$s', DB_PREFIXE, "dossier_autorisation"),
                $val,
                DB_AUTOQUERY_UPDATE,
                $cle
            );
            $this->f->addToLog(
                __METHOD__."(): db->autoexecute(\"".sprintf('%1$s%2$s', DB_PREFIXE, "dossier_autorisation")."\", ".print_r($val, true).", DB_AUTOQUERY_UPDATE, \"".$cle."\");",
                VERBOSE_MODE
            );
            if ($this->f->isDatabaseError($res_update_type, true) === true) {
                return false;
            }
        }

        // Liste des mises à jour par défaut
        $updates_da = array(
            'localisation',
            'lot',
            'demandeur',
            'etat',
            'date_init',
            'date_validite',
            'date_doc',
            'date_daact',
            'dt',
        );
        if (isset($params['di_id']) === true
            && $params['di_id'] !== null) {
            // Récupère la liste des mises à jour depuis le type du dossier d'instruction
            $updates_da = $this->get_dit_update_da($params['di_id']);
        }
        if (isset($params['updates_da']) === true
            && is_array($params['updates_da']) === true) {
            // Récupère la liste des mises à jour passée en paramètre
            $updates_da = $params['updates_da'];
        }
        // Exécute les méthodes de mise à jour du DA
        foreach ($updates_da as $update_da) {
            $method = sprintf('update_da_%s', $update_da);
            if(method_exists($this, $method) === true) {
                $res = $this->$method(array(
                    'query_where' => $query_where,
                    'di_reopened' => (isset($params['di_reopened']) === true) ? $params['di_reopened'] : false,
                    'force_calcul_parcelles' => (isset($params['force_calcul_parcelles']) === true) ? $params['force_calcul_parcelles'] : false,
                    'delete' => false,
                ));
                if ($res !== true) {
                    return $res;
                }
            }
        }
        //
        return true;
    }


    /**
     * Ajoute les parcelles du dossier d'autorisation passé en paramètre.
     * 
     * @param string $dossier_autorisation           Identifiant du dossier
     * @param string $terrain_references_cadastrales Références cadastrales du 
     *                                                dossier
     */
    function ajouter_dossier_autorisation_parcelle(
        $dossier_autorisation,
        $terrain_references_cadastrales
    ) {

        // Parse les parcelles
        $list_parcelles = $this->f->parseParcelles($terrain_references_cadastrales, $this->getVal('om_collectivite'));

        // A chaque parcelle une nouvelle ligne est créée dans la table
        // dossier_parcelle
        foreach ($list_parcelles as $parcelle) {

            // Instance de la classe dossier_parcelle
            $dossier_autorisation_parcelle = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_autorisation_parcelle",
                "idx" => "]",
            ));

            // Valeurs à sauvegarder
            $value = array(
                'dossier_autorisation_parcelle' => '',
                'dossier_autorisation' => $dossier_autorisation,
                'parcelle' => '',
                'libelle' => $parcelle['quartier']
                                .$parcelle['section']
                                .$parcelle['parcelle']
            );

            // Ajout de la ligne
            $dossier_autorisation_parcelle->ajouter($value);
        }

    }

    /**
     * Supprime les parcelles du dossier d'autorisation passé en paramètre
     * @param  string $dossier_autorisation Identifiant du dossier
     */
    function supprimer_dossier_autorisation_parcelle($dossier_autorisation) {

        // Suppression des parcelles du dossier d'autorisation
        $sql = "DELETE FROM ".DB_PREFIXE."dossier_autorisation_parcelle
                WHERE dossier_autorisation='".$dossier_autorisation."'";
        $res = $this->f->db->query($sql);
        $this->addToLog(__METHOD__.": db->query(\"".$sql."\")", VERBOSE_MODE);
        $this->f->isDatabaseError($res);
    }

    /**
     * TRIGGER - triggerajouterapres.
     *
     * @return boolean
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // Si le champ des références cadastrales n'est pas vide
        if ($this->valF['terrain_references_cadastrales'] != '') {
            // Ajout des parcelles dans la table dossier_autorisation_parcelle
            $this->ajouter_dossier_autorisation_parcelle(
                $this->valF['dossier_autorisation'],
                $this->valF['terrain_references_cadastrales']
            );
        }

        /**
         * Gestion des tâches pour la dématérialisation
         */
        $inst_datd = $this->get_inst_dossier_autorisation_type_detaille($val['dossier_autorisation_type_detaille']);
        if (($inst_datd->getVal('dossier_platau') === 't' || $inst_datd->getVal('dossier_platau') === true)
            && $this->f->is_option_mode_service_consulte_enabled() !== true
            && (isset($val['source_depot']) === false || $val['source_depot'] !== PLATAU)
            && (isset($val['etat_transmission_platau']) === false || $val['etat_transmission_platau'] !== 'jamais_transmissible')) {
            //
            $inst_task = $this->f->get_inst__om_dbform(array(
                "obj" => "task",
                "idx" => 0,
            ));
            $task_val = array(
                'type' => 'creation_DA',
                'object_id' => $id,
                'dossier' => $id,
            );
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

        // TODO Lorsque la tâche modification_DA sera de nouveau gérée il faut gérer l'ajout de cette tâche
        // en fonction de la source_depot (comme modification_DI dans la classe dossier.class.php) 

        //
        return true;
    }

    /**
     * Surcharge du fil d'ariane en contexte formulaire.
     *
     * @param string $ent Chaîne initiale
     *
     * @return chaîne de sortie
     */
    function getFormTitle($ent) {
        //
        if (intval($this->getParameter("maj")) === 4) {
            // XXX - Manque demandeur
            $ent =  _("Autorisation")." -> "._("Dossier d'autorisation")." -> ".$this->getVal('dossier_autorisation_libelle');
        }
        //
        return $ent;
    }

    /**
     * Surcharge du fil d'ariane en contexte sous-formulaire.
     *
     * @param string $subent Chaîne initiale
     *
     * @return chaîne de sortie
     */
    function getSubFormTitle($subent) {
        //
        if (intval($this->getParameter("maj")) === 4) {
            // XXX - Manque demandeur
            $subent =  _("Autorisation")." -> "._("Dossier d'autorisation")." -> ".$this->getVal('dossier_autorisation_libelle');
        }
        //
        return $subent;
    }


    /**
     * Permet de générer une clé 4*4 chiffres, séparés par des "-".
     * Cette clé permet au citoyen de se connecter au portail pour consulter son
     * autorisation.
     * Exemple de clé générée : 0000-1111-2222-3333.
     *
     * @return string
     */
    public function generate_citizen_access_key() {
        // Initialisation d'un tableau
        $number_list = array();

        // Génération aléatoire d'un nombre sur 4 caractères, 4 fois
        for ($i = 0; $i < 4; $i++) { 
            $number_list[] = str_pad(mt_rand(0, 9999), 4, 0, STR_PAD_LEFT);
        }

        // Transformation en chaîne tout en séparant les nombres par un "-"
        $result = implode('-', $number_list);

        //
        return $result;
    }


    /**
     * Permet de modifier le dossier d'autorisation pour mettre à jour la clé
     * d'accès au portail citoyen, si celle-ci n'existe pas déjà.
     * Il est possible de forcer sa génération.
     *
     * @param boolean $force Force la génération de la clé.
     *
     * @return boolean
     */
    public function update_citizen_access_key($force = false) {
        // Si une clé d'accès citoyen existe déjà et que la génération n'est pas
        // forcée
        if ($force == false &&
            ($this->getVal('cle_acces_citoyen') != ""
            || $this->getVal('cle_acces_citoyen') != null)) {
            //
            return true;
        }

        // Génération de la clé d'accès au portail citoyen
        $citizen_access_key = $this->generate_citizen_access_key();

        // Valeurs à mettre à jour
        $valF = array();
        // Récupération la valeur des champs
        foreach($this->champs as $key => $champ) {
            //
            $valF[$champ] = $this->val[$key];
        }
        $valF["cle_acces_citoyen"] = $citizen_access_key;

        // Modification
        $update = $this->modifier($valF);

        // Si la modification échoue
        if ($update !== true) {
            //
            return false;
        }

        //
        return true;
    }

    /**
     * Récupère l'instance du type détaillé du dossier d'autorisation.
     *
     * @param integer $dossier_autorisation_type_detaille Identifiant
     *
     * @return object
     */
    function get_inst_dossier_autorisation_type_detaille($dossier_autorisation_type_detaille = null) {
        //
        if (is_null($this->inst_dossier_autorisation_type_detaille)) {
            //
            if (is_null($dossier_autorisation_type_detaille)) {
                //
                $dossier_autorisation_type_detaille = $this->getVal('dossier_autorisation_type_detaille');
            }
            //
            $this->inst_dossier_autorisation_type_detaille = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_autorisation_type_detaille",
                "idx" => $dossier_autorisation_type_detaille,
            ));
        }
        //
        return $this->inst_dossier_autorisation_type_detaille;
    }

    /**
     * Récupère l'instance du type du dossier d'autorisation.
     *
     * @param integer $dossier_autorisation_type Identifiant
     *
     * @return object
     */
    function get_inst_dossier_autorisation_type($dossier_autorisation_type = null) {
        //
        if (is_null($this->inst_dossier_autorisation_type)) {
            //
            if (is_null($dossier_autorisation_type)) {
                //
                $inst_datd = $this->get_inst_dossier_autorisation_type_detaille($this->getVal('dossier_autorisation_type_detaille'));
                $dossier_autorisation_type = $inst_datd->getVal('dossier_autorisation_type');
            }
            //
            $this->inst_dossier_autorisation_type = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier_autorisation_type",
                "idx" => $dossier_autorisation_type,
            ));
        }
        //
        return $this->inst_dossier_autorisation_type;
    }

    /**
     * CONDITION - is_dossier_autorisation_visible
     *
     * Permet de savoir si le type de DA lié au dossier d'instruction courant est visible.
     *
     * @return boolean true si le DA est visible, sinon false
     */
    public function is_dossier_autorisation_visible() {

        $inst_dat = $this->get_inst_dossier_autorisation_type();
        //
        if ($inst_dat->getVal('cacher_da') === 't') {
            return false;
        }
        return true;
    }

    /**
     * VIEW - redirect.
     *
     * Cette vue est appelée lorsque l'on souhaite consulter un DI/DA dont on ne connaît pas le groupe.
     * Ce fonctionnement est nécessaire car :
     *  - on consule le DA pour les DI d'urbanisme ;
     *  - on consulte le DI pour les DI du contentieux ;
     *  - les classes métier filles de 'dossier' sont relatives au groupe.
     *
     * Par exemple, depuis l'onglet "Dossiers Liés" du DI, le listing ne permet pas d'instancier chaque résultat
     * et par conséquent on n'a pas accès au groupe du dossier. L'action tableau consulter y est surchargée afin
     * d'amener à cette vue qui se charge de faire la redirection adéquate.
     *
     * @return void
     */
    public function redirect() {
        $idx_da = $this->getVal($this->clePrimaire);
        // Redirection DA si visible
        if ($this->is_dossier_autorisation_visible() === true) {
            $link = OM_ROUTE_FORM.'&obj=dossier_autorisation&action=3&idx='.$idx_da;
            if ($this->f->get_submitted_get_value('retourformulaire') !== null
                && $this->f->get_submitted_get_value('idxformulaire') !== null) {
                $link .= '&premier=0&tricol=&retourformulaire='.$this->f->get_submitted_get_value('retourformulaire');
                $link .= '&retour='.$this->f->get_submitted_get_value('idxformulaire');
            }
            header('Location: '.$link);
            exit();
        }
        // Sinon redirection vers la classe métier adéquate
        // du premier DI récupéré en base
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier
                FROM
                    %1$sdossier
                WHERE
                    dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($idx_da)
            ),
            array(
                "origin" => __METHOD__
            )
        );
        $di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $qres['result'],
        ));
        $di->redirect();
    }

    /**
     * CONDITION - is_confidentiel
     *
     * Permet de savoir si le type de dossier d'autorisation du dossier courant est
     * confidentiel.
     *
     * @return boolean true si le dossier est confidentiel, sinon false.
     * 
     */
    public function is_confidentiel() {
        //
        $inst_dossier_autorisation_type_detaille = $this->get_inst_dossier_autorisation_type_detaille();
        $inst_dossier_autorisation_type = $this->get_inst_dossier_autorisation_type($inst_dossier_autorisation_type_detaille->getVal('dossier_autorisation_type'));
        $confidentiel = $inst_dossier_autorisation_type->getVal('confidentiel');
        //
        if ($confidentiel === 't') {
            return true;
        }
        return false;
    }

    /**
     * Retourne le code du groupe du dossier d'instruction.
     *
     * @return string
     */
    public function get_groupe() {
        //
        if (isset($this->groupe) === true && $this->groupe !== null) {
            return $this->groupe;
        }

        // Récupère le code du groupe
        $inst_dossier_autorisation_type_detaille = $this->get_inst_dossier_autorisation_type_detaille();
        $inst_dossier_autorisation_type = $this->get_inst_dossier_autorisation_type($inst_dossier_autorisation_type_detaille->getVal('dossier_autorisation_type'));
        $inst_groupe = $this->get_inst_groupe($inst_dossier_autorisation_type->getVal('groupe'));
        $groupe = $inst_groupe->getVal('code');

        //
        $this->groupe = $groupe;
        //
        return $this->groupe;
    }

    /**
     * Récupère l'instance du groupe.
     *
     * @param string $groupe Identifiant du groupe.
     *
     * @return object
     */
    private function get_inst_groupe($groupe) {
        //
        return $this->get_inst_common("groupe", $groupe);
    }

    /**
     * CONDITION - can_user_access_dossier
     *
     * Effectue les vérifications suivantes :
     * - L'utilisateur doit avoir accès au groupe du dossier
     * - Si le dossier est confidentiel, l'utilisateur doit avoir accès aux dossiers
     * confidentiels de ce groupe
     *
     * @return boolean true si les conditions ci-dessus sont réunies, sinon false
     * 
     */
    public function can_user_access_dossier() {
        // Récupère le code du groupe
        $groupe_dossier = $this->get_groupe();

        // Le groupe doit être accessible par l'utilisateur ;
        if ($this->f->is_user_in_group($groupe_dossier) === false) {
            return false;
        }
        if ($this->is_confidentiel() === true) {
            //
            if ($this->f->can_user_access_dossiers_confidentiels_from_groupe($groupe_dossier) === false) {
                return false;
            }
        }
        return true;
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
        $parameters = $this->f->getCollectivite($this->getVal('om_collectivite'));
        $val['insee'] = $parameters['insee'];
        return $val;
    }

    public function get_parcelles($da = null) {
        if ($da === null) {
            $da = $this->getVal('dossier_autorisation');
        }
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    *
                FROM
                    %1$sdossier_autorisation_parcelle
                WHERE
                    dossier_autorisation = \'%2$s\'
                ORDER BY
                    dossier_autorisation_parcelle
                ',
                DB_PREFIXE,
                $this->f->db->escapeSimple($da)
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres['code'] !== 'OK') {
            return false;
        }
        return $qres['result'];
    }

    // Liste des dossiers d'instruction du DA
    public function get_list_dossier_instruction() {
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier.dossier
                FROM
                    %1$sdossier
                WHERE
                    dossier.dossier_autorisation = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal($this->clePrimaire))
            ),
            array(
                "origin" => __METHOD__,
                "force_return" => true,
            )
        );
        if ($qres['code'] !== 'OK') {
            return false;
        }
        return $qres['result'];
    }

}


