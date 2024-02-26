<?php
/**
 * DBFORM - 'dossier_contrainte' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'dossier_contrainte'.
 *
 * @package openads
 * @version SVN : $Id: dossier_contrainte.class.php 6565 2017-04-21 16:14:15Z softime $
 */

require_once "../gen/obj/dossier_contrainte.class.php";

class dossier_contrainte extends dossier_contrainte_gen {

    /**
     * Constructeur.
     * ...
     *
     * @param string $id_dossier Identifiant du dossier.
     */
    function __construct($id, &$dnu1 = null, $dnu2 = null, $id_dossier = 0) {
        $this->constructeur($id);
        //On active les nouvelles actions
        ($this->f->get_submitted_get_value('idxformulaire')!==null ? $idxformulaire = 
        $this->f->get_submitted_get_value('idxformulaire') : $idxformulaire = "");

        // Liste des contraintes
        $getListContraintes = $this->getListContraintes($idxformulaire);

        // Tant qu'il y a des contraintes
        foreach ($getListContraintes as $rowListContraintes) {
            // Identifiant du champ
            $id_champ = 'contrainte_'.$rowListContraintes['contrainte_id'];
            // Ajoute les informations de la contrainte au tableau
            $this->listContraintes[$id_champ] = $rowListContraintes;
            // Ajoute la contrainte en tant que champ
            $this->setChamp($id_champ);
        }
    }

    /**
     * Cette variable permet de stocker le résultat de la méthode
     * getDivisionFromDossier() afin de ne pas effectuer le recalcul à chacun de
     * ces appels.
     * @var string Code de la division du dossier en cours
     */
    var $_division_from_dossier = NULL;
    
    /**
     * Liste des contraintes
     * @var array
     */
    var $listContraintes = array();

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        
        parent::init_class_actions();
        
        // ACTION - 000 - ajouter
        // Modifie la condition d'affichage du bouton ajouter
        $this->class_actions[0]["condition"] = array("is_addable", "can_user_access_dossier_contexte_ajout");

        // ACTION - 001 - modifier
        // Modifie la condition et le libellé du bouton modifier
        $this->class_actions[1]["condition"] = array("is_editable", "can_user_access_dossier_contexte_modification");
        
        // ACTION - 002 - supprimer
        // Modifie la condition et le libellé du bouton supprimer
        $this->class_actions[2]["condition"] = array("is_deletable", "can_user_access_dossier_contexte_modification");

        // ACTION - 003 - consulter
        // 
        $this->class_actions[3]["condition"] = "can_user_access_dossier_contexte_modification";


        // ACTION - 004 - view_tab
        // Interface spécifique de la liste des contraintes
        $this->class_actions[4] = array(
            "identifier" => "view_tab",
            "view" => "view_tab",
            "permission_suffix" => "tab",
            "condition" => "can_user_access_dossier_contexte_ajout",
        );

        // ACTION - 005 - view_tab
        // Interface spécifique de la vue du traitement d'ajout de contraintes
        $this->class_actions[5] = array(
            "identifier" => "view_add",
            "view" => "view_add",
            "permission_suffix" => "ajouter",
            "condition" => "can_user_access_dossier_contexte_ajout",
        );
        // ACTION - 6 - supprimer_contraintes_non_selectionnees
        $this->class_actions[6] = array(
            "identifier" => "supprimer_contraintes_non_selectionnees",
            "view" => "supprimer_contraintes_non_selectionnees",
            "permission_suffix" => "delete",
        );
    }

    /**
     * Il n'y a pas de libellé sur la table dossier_contrainte. On récupère donc
     * le libellé de la contrainte liée.
     * @return string
     */
    function get_default_libelle() {
        return $this->getVal($this->clePrimaire)."&nbsp;".$this->getLibelleFromContrainte($this->getVal("contrainte"));
    }

    /**
     * Vérifie à l'aide d'une requête si des contraintes du dossier ont des suggestions
     * d'instructions associées.
     *
     * @param string identifiant du dossier d'instruction
     * @return boolean
     */
    protected function has_suggested_instruction(string $id_dossier) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    COUNT(evenement_suggere_dossier)
                FROM
                    %1$sdossier
                    LEFT JOIN %1$sdossier_contrainte
                        ON dossier_contrainte.dossier = dossier.dossier
                    LEFT JOIN %1$scontrainte
                        ON dossier_contrainte.contrainte = contrainte.contrainte
                    LEFT JOIN %1$ssig_contrainte
                        ON contrainte.libelle = sig_contrainte.libelle
                    -- Jointures avec une sous requêtes servant à récupérer la liste des évènements suggérés par
                    -- contrainte, type de dossier et collectivité
                    LEFT JOIN (
                        SELECT
                            dossier.dossier,
                            sig_contrainte.sig_contrainte
                        FROM
                            %1$slien_sig_contrainte_evenement
                            JOIN %1$sevenement
                                ON lien_sig_contrainte_evenement.evenement = evenement.evenement
                            JOIN %1$ssig_contrainte
                                ON lien_sig_contrainte_evenement.sig_contrainte = sig_contrainte.sig_contrainte
                            JOIN %1$slien_sig_contrainte_dossier_instruction_type
                                ON sig_contrainte.sig_contrainte = lien_sig_contrainte_dossier_instruction_type.sig_contrainte
                            JOIN %1$slien_sig_contrainte_om_collectivite
                                ON sig_contrainte.sig_contrainte = lien_sig_contrainte_om_collectivite.sig_contrainte
                            JOIN %1$scontrainte
                                ON sig_contrainte.libelle = contrainte.libelle
                            JOIN %1$sdossier_contrainte
                                ON contrainte.contrainte = dossier_contrainte.contrainte
                            JOIN %1$sdossier
                                ON dossier_contrainte.dossier = dossier.dossier
                                    AND lien_sig_contrainte_dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type
                            JOIN %1$som_collectivite
                                ON lien_sig_contrainte_om_collectivite.om_collectivite = om_collectivite.om_collectivite
                                    AND (dossier.om_collectivite = om_collectivite.om_collectivite
                                        OR om_collectivite.niveau = \'2\')
                        GROUP BY
                            dossier.dossier,
                            sig_contrainte.sig_contrainte
                    ) AS evenement_suggere_dossier
                        ON dossier.dossier = evenement_suggere_dossier.dossier
                            AND sig_contrainte.sig_contrainte = evenement_suggere_dossier.sig_contrainte
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($id_dossier)
            ),
            array(
                "origin" => __METHOD__
            )
        );
        // Si on a un résultat n'étant pas 0 c'est que le dossier a des contraintes ayant instructions suggérées.
        return $qres['result'] > 0;
    }

    /**
     * Récupère à l'aide d'une requête la liste des contraintes du dossier
     * dont l'identifiant est passé en argument.
     *
     * @param string identifiant du dossier
     * @return array tableau contenant la liste des contraintes
     */
    protected function get_dossier_contraintes(string $id_dossier) {
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier_contrainte.dossier_contrainte AS dossier_contrainte_id,
                    dossier_contrainte.texte_complete AS dossier_contrainte_texte,
                    dossier_contrainte.reference AS dossier_contrainte_reference,
                    contrainte.libelle AS contrainte_libelle,
                    contrainte.nature AS contrainte_nature,
                    contrainte.texte AS contrainte_texte,
                    contrainte.reference AS contrainte_reference,
                    lower(contrainte.groupe) AS contrainte_groupe,
                    lower(contrainte.sousgroupe) AS contrainte_sousgroupe,
                    evenement_suggere_dossier.libelles_evenements_suggeres
                FROM
                    %1$sdossier
                    JOIN %1$sdossier_contrainte
                        ON dossier_contrainte.dossier = dossier.dossier
                    JOIN %1$scontrainte
                        ON dossier_contrainte.contrainte = contrainte.contrainte
                    LEFT JOIN %1$ssig_contrainte
                        ON contrainte.libelle = sig_contrainte.libelle
                    -- Jointures avec une sous requêtes servant à récupérer la liste des évènements suggérés par
                    -- contrainte, type de dossier et collectivité
                    LEFT JOIN (
                        SELECT
                            dossier.dossier,
                            sig_contrainte.sig_contrainte,
                            STRING_AGG(DISTINCT evenement.libelle, \',\' ORDER BY evenement.libelle ASC) AS libelles_evenements_suggeres
                        FROM
                            %1$slien_sig_contrainte_evenement
                            JOIN %1$sevenement
                                ON lien_sig_contrainte_evenement.evenement = evenement.evenement
                            JOIN %1$ssig_contrainte
                                ON lien_sig_contrainte_evenement.sig_contrainte = sig_contrainte.sig_contrainte
                            JOIN %1$slien_sig_contrainte_dossier_instruction_type
                                ON sig_contrainte.sig_contrainte = lien_sig_contrainte_dossier_instruction_type.sig_contrainte
                            JOIN %1$slien_sig_contrainte_om_collectivite
                                ON sig_contrainte.sig_contrainte = lien_sig_contrainte_om_collectivite.sig_contrainte
                            JOIN %1$scontrainte
                                ON sig_contrainte.libelle = contrainte.libelle
                            JOIN %1$sdossier_contrainte
                                ON contrainte.contrainte = dossier_contrainte.contrainte
                            JOIN %1$sdossier
                                ON dossier_contrainte.dossier = dossier.dossier
                                    AND lien_sig_contrainte_dossier_instruction_type.dossier_instruction_type = dossier.dossier_instruction_type
                            JOIN %1$som_collectivite
                                ON lien_sig_contrainte_om_collectivite.om_collectivite = om_collectivite.om_collectivite
                                    AND (dossier.om_collectivite = om_collectivite.om_collectivite
                                        OR om_collectivite.niveau = \'2\')
                        GROUP BY
                            dossier.dossier,
                            sig_contrainte.sig_contrainte
                    ) AS evenement_suggere_dossier
                        ON dossier.dossier = evenement_suggere_dossier.dossier
                            AND sig_contrainte.sig_contrainte = evenement_suggere_dossier.sig_contrainte
                WHERE
                    dossier.dossier = \'%2$s\'
                ORDER BY
                    contrainte_groupe DESC,
                    contrainte_sousgroupe,
                    contrainte.no_ordre,
                    contrainte.libelle',
                DB_PREFIXE,
                $this->f->db->escapeSimple($id_dossier)
            ),
            array(
                "origin" => __METHOD__
            )
        );
        return $qres['result'];
    }

    /**
     * Renvoie le html affichant l'icone de suggestion avec l'infobulle indiquant la
     * liste des éléments suggérés.
     *
     * @param array liste des libellés des évènements suggérés
     * @return string html d'affichage de l'icone de suggestion
     */
    protected function get_icon_suggested_instruction_html(array $evenements_suggeres) {
        // Change le format de la liste des instructions suggérées pour pouvoir l'afficher
        return sprintf(
            "<span class=\"suggestion-icon\" title=\"%s :\n- %s\">
                💡
            </span>",
            __('Instructions suggérées'),
            implode("\n- ", $evenements_suggeres)
        );
    }

    /**
     * VIEW - view_tab
     *
     * Cette vue permet d'afficher les contraintes rattachées à un dossier
     * dans un tableau organisé par les groupes et sous-groupes.
     *
     * @return void
     */
    function view_tab() {
        // Récupération des variables GET
        ($this->f->get_submitted_get_value('idxformulaire')!==null ? $idxformulaire = 
            $this->f->get_submitted_get_value('idxformulaire') : $idxformulaire = "");
        ($this->f->get_submitted_get_value('retourformulaire')!==null ? $retourformulaire = 
            $this->f->get_submitted_get_value('retourformulaire') : $retourformulaire = "");
        ($this->f->get_submitted_get_value('obj') !== null ? $obj = $this->f->get_submitted_get_value('obj') : $obj = "");
        // Récupèration du numéro du dossier
        $dossier = $idxformulaire;

        // Affichage du message d'information si des instructions suggérées sont disponibles
        if ($this->has_suggested_instruction($dossier)) {
            $this->f->displayMessage(
                'info',
                __("Des suggestions (💡) d'instruction en rapport avec les contraintes ci-dessous sont disponibles.")
            );
        }

        // Début affichage tableau
        printf("\n<div id=\"sousform-dossier_contrainte\">\n");
        printf("\n<!-- ########## START FORMULAIRE ########## -->\n");
        printf("<div class=\"formEntete ui-corner-all\">\n");



        // Initialisation des affichages des bouton modifier et supprimer
        $show_btn_edit = false;
        $show_btn_delete = false;
        $show_checkbox = false;
        // Si toutes les conditions pour afficher le bouton modifier sont remplis
        if ($this->is_editable() === true) {
            // Affiche le bouton
            $show_btn_edit = true;
        }
        // Si toutes les conditions pour afficher le bouton supprimer sont remplis
        if ($this->is_deletable() === true) {
            // Affiche le bouton
            $show_btn_delete = true;
            $show_checkbox = true;
        }


        // bouton pour gérer les contraintes
        $ajouter = "
        <p>
            <a id=\"action-soustab-dossier_contrainte-corner-ajouter\" onclick=\"ajaxIt('" . $obj . "','".OM_ROUTE_SOUSFORM."&obj=" . $obj . "&action=0&tri=&objsf=dossier_contrainte&premiersf=0&retourformulaire=".$retourformulaire."&idxformulaire=".$dossier."&trisf=&retour=tab');\" href='#'>
                <span class=\"om-prev-icon om-icon-16 add-16\" title=\""._("Ajouter des contraintes")."\">
                    "._("Ajouter des contraintes")."
                </span>
            </a>
        </p>
        ";
        // Case à cocher permettant de sélectionner / déselectionner toutes les contraintes
        $templateSelectAll =
        '<div>
            <input type="checkbox" name="%1$s" id="%2$s" %3$s="%4$s" class="%5$s" %6$s />
            <label for="%2$s">
                %7$s
            </label>
        </div>';

        // Case à cocher permettant de sélectionner / déselectionner toutes les contraintes d'un même groupe
        $templateSelectAllGroupe =
        '<div>
            <input type="checkbox" name="%1$s" id="%2$s" %3$s="%4$s" class="%5$s" %6$s />
            <label for="%2$s">
                %7$s
            </label>
        </div>';

        // Entête pour le groupe
        $groupeHeader = "
        <div id='%s' class='dossier_contrainte_groupe'>
            <div class='dossier_contrainte_groupe_header'>
                <span class='name'>
                    %s
                </span>
            </div>
        ";

        // Entête pour le sous-groupe
        $sousgroupeHeader = "
        <div class='dossier_contrainte_sousgroupe'>
            <div class='dossier_contrainte_sousgroupe_header'>
                <span class='name'>
                    %s
                </span>
            </div>
        ";
        // Titres des colonnes
        $tableHeader = "
        <thead>
            <tr class='ui-tabs-nav ui-accordion ui-state-default tab-title'>
                <th class='icons actions-max-1'>
                    <span class='name'>
                        %s
                    </span>
                </th>";
        // Si le retour formulaire est bon
        if ($retourformulaire == 'dossier' || $this->f->contexte_dossier_instruction()) {
            //
            if ($show_checkbox == true) {
                // Affiche le header de la colonne pour les checkbox
                $tableHeader .= "
                <th class='icons actions-max-1'>
                    <span class='name'>
                        %s
                    </span>
                </th>";
            }
            //
            if ($show_btn_edit == true) {
                // Affiche le header de la colonne pour le bouton
                $tableHeader .= "
                <th class='icons actions-max-1'>
                    <span class='name'>
                        %s
                    </span>
                </th>";
            }
            //
            if ($show_btn_delete == true) {
                // Affiche le header de la colonne pour le bouton
                $tableHeader .= "
                <th class='icons actions-max-1'>
                    <span class='name'>
                        %s
                    </span>
                </th>";
            }
        }
        $tableHeader .= "
                <th class='title col-0 firstcol'>
                    <span class='name'>
                        "._('libelle')."
                    </span>
                </th>
                <th class='title col-1'>
                    <span class='name'>
                        "._('texte_complete')."
                    </span>
                </th>
                <th class='title col-2'>
                    <span class='name'>
                        "._('reference')."
                    </span>
                </th>
                <th class='title col-3'>
                    <span class='name'>
                        "._('nature')."
                    </span>
                </th>
            </tr>
        </thead>
        ";

        // Case à cocher pour sélectionner les contraintes à conserver
        $templateCheckboxContrainte = '<input id="%1$s" class="checkbox-contrainte_conserve" type="checkbox" />';

        // Ligne de données
        $line = "
        <tr class='tab-data %s'>
            <td class='icons'>
                %s
            </td>";
        //      
        if ($retourformulaire == 'dossier' || $this->f->contexte_dossier_instruction()) {
            if ($show_checkbox == true) {
                // Affiche la cellule pour les checkbox
                $line .= "
                <td class='icons'>
                    %s
                </td>";
            }
            //
            if ($show_btn_edit == true) {
                // Affiche la cellule pour le bouton
                $line .= "
                <td class='icons'>
                    %s
                </td>";
            }
            //
            if ($show_btn_delete == true) {
                // Affiche la cellule pour le bouton
                $line .= "
                <td class='icons'>
                    %s
                </td>";
            }
        }
        $line .= "    
            <td class='col-0 firstcol'>
                %s%s
            </td>
            <td class='col-1'>
                %s
            </td>
            <td class='col-2'>
                %s
            </td>
            <td class='col-3'>
                %s
            </td>
        </tr>
        ";

        // Lien des données
        $link = "
        <a class='lienTable' onclick=\"ajaxIt('" . $obj . "','".OM_ROUTE_SOUSFORM."&obj=" . $obj . "&action=3&idx=%s&tri=&premier=0&objsf=dossier_contrainte&premiersf=0&retourformulaire=%s&idxformulaire=%s&trisf=&retour=tab');\" href='#'>
            %s
        </a>
        ";

        // 
        $button = '
        <a onclick=\'ajaxIt("' . $obj . '","'.OM_ROUTE_SOUSFORM.'&obj=' . $obj . '&amp;action=%1$s&amp;idx=%2$s&amp;tri=&amp;premier=0&amp;objsf=dossier_contrainte&amp;premiersf=0&amp;retourformulaire=%3$s&amp;idxformulaire=%4$s&amp;trisf=&amp;retour=tab");\' id="action-soustab-dossier_contrainte-corner-left-%5$s-%2$s" href="#">
            <span title="%5$s" class="om-icon om-icon-16 om-icon-fix %6$s-16">
                %5$s
            </span>
        </a>
        ';

        //Vérification des droits sur l'ajout
        // et que l'instructeur est de la bonne division
        if ($this->is_addable() === true) {

            // Affiche le bouton pour gérer les contraintes
            printf($ajouter);
        }

        $contraintes_data = $this->get_dossier_contraintes($dossier);
        // Si il n'y a pas de résultat on affiche "Aucun enregistrements"
        if (count($contraintes_data) == 0) {
            printf("<p class='noData'>"._("Aucun enregistrement")."<p>");
        } else {
            if ($show_checkbox == true) {
                printf(
                    $templateSelectAll,
                    'checkbox_select_all_none',
                    'checkbox_select_all_none',
                    'onclick',
                    'dossier_contrainte_checkbox_select_all_none(this);',
                    'checkbox_select_all_none',
                    '',
                    __('Tout sélectionner / désélectionner')
                );
            }
    
            // Sauvegarde des données pour les comparer
            $lastRow = array();
            $lastRow['contrainte_groupe'] = 'empty';
            $lastRow['contrainte_sousgroupe'] = 'empty';
    
            // Tant qu'il y a des résultats
            foreach($contraintes_data as $row) {
                // Si l'identifiant du groupe de la contrainte présente et 
                // celle d'avant est différent
                if ($row['contrainte_groupe'] != $lastRow['contrainte_groupe']) {
    
                    // Si l'identifiant du groupe d'avant est vide
                    if ($lastRow['contrainte_groupe'] != 'empty') {
                        // Ferme le tableau
                        printf("</table>");
                        //
                        printf("</div>");
                        //
                        printf("</div>");
                    }
    
                    // Affiche le header du groupe
                    printf($groupeHeader, str_replace(' ', '_', $row['contrainte_groupe']), $row['contrainte_groupe']);

                    if ($show_checkbox == true) {
                        printf(
                            $templateSelectAllGroupe,
                            'checkbox_select_all_groupe_'.str_replace(' ', '_', $row['contrainte_groupe']),
                            'checkbox_select_all_groupe_'.str_replace(' ', '_', $row['contrainte_groupe']),
                            'onclick',
                            'dossier_contrainte_checkbox_select_groupe(this);',
                            'checkbox_select_all_groupe_none',
                            '',
                            __('Tout sélectionner / désélectionner dans le groupe')
                        );
                    }
                }
    
                // Si l'identifiant du sous-groupe de la contrainte présente et 
                // celle d'avant est différent
                // Ou qu'ils soient identique mais n'appartiennent pas au même groupe
                if ($row['contrainte_sousgroupe'] != $lastRow['contrainte_sousgroupe']
                    || ($row['contrainte_sousgroupe'] == $lastRow['contrainte_sousgroupe']
                        && $row['contrainte_groupe'] != $lastRow['contrainte_groupe'])) {
    
                    //
                    if($row['contrainte_groupe'] == $lastRow['contrainte_groupe']) {
                        // Si l'identifiant de la sous-groupe d'avant est vide
                        if ($lastRow['contrainte_sousgroupe'] != 'empty') {
                            // Ferme le tableau
                            printf("</table>");
                            //
                            printf("</div>");
                        }
                    }
    
                    // Affiche le header du sous-groupe
                    printf($sousgroupeHeader, $row['contrainte_sousgroupe']);
    
                    // Ouvre le tableau
                    printf("<table id='sousgroupe_".$row['contrainte_sousgroupe']
                        ."' class='tab-tab dossier_contrainte_view'>");
    
                    // Affiche le header des données
                    if ($show_btn_edit == false
                        && $show_btn_delete == false
                        && $show_checkbox == false) {
                        //
                        printf($tableHeader, '');
                    }
                    //
                    if ($show_btn_edit == true
                        && $show_btn_delete == false
                        && $show_checkbox == false) {
                        //
                        printf($tableHeader, '', '');
                    }
                    //
                    if ($show_btn_edit == false
                        && $show_btn_delete == true
                        && $show_checkbox == false) {
                        //
                        printf($tableHeader, '', '');
                    }
                    //
                    if ($show_btn_edit == false
                        && $show_btn_delete == false
                        && $show_checkbox == true) {
                        //
                        printf($tableHeader, '', '');
                    }
                    //
                    if ($show_btn_edit == true
                        && $show_btn_delete == true
                        && $show_checkbox == false) {
                        //
                        printf($tableHeader, '', '', '');
                    }
                    //
                    if ($show_btn_edit == true
                        && $show_btn_delete == false
                        && $show_checkbox == true) {
                        //
                        printf($tableHeader, '', '', '');
                    }
                    //
                    if ($show_btn_edit == false
                        && $show_btn_delete == true
                        && $show_checkbox == true) {
                        //
                        printf($tableHeader, '', '', '');
                    }
                    //
                    if ($show_btn_edit == true
                        && $show_btn_delete == true
                        && $show_checkbox == true) {
                        //
                        printf($tableHeader, '', '', '', '');
                    }
    
                    // Définis le style des lignes
                    $style = 'odd';
                }
    
                // Si toujours dans la même groupe et même sous-groupe, 
                // on change le style de la ligne
                if ($row['contrainte_groupe'] == $lastRow['contrainte_groupe']
                    && $row['contrainte_sousgroupe'] == $lastRow['contrainte_sousgroupe']) {
                    //
                    $style = ($style=='even')?'odd':'even';
                }
                
                // Affiche "Oui" ou "Non" pour le bouléen
                if ($row['dossier_contrainte_reference'] == 1 
                    || $row['dossier_contrainte_reference'] == "t"
                    || $row['dossier_contrainte_reference'] == "Oui") {
                    //
                    $contrainte_reference = "Oui";
                } else {
                    //
                    $contrainte_reference = "Non";
                }
    
                // Transforme la liste des suggestions en tableau. Si il n'y a pas de suggestions
                // explode() renvoie un tableau de cette forme : array(0 => '') qui n'est pas considéré
                // comme vide et va afficher une suggestion. Pour éviter ce cas, si il n'y a pas
                // d'instruction suggérées on transforme la liste en tableau vide.
                $row['libelles_evenements_suggeres'] = ! empty($row['libelles_evenements_suggeres']) ?
                    explode(',', $row['libelles_evenements_suggeres']) :
                    array();
                // Affiche les données
                if ($retourformulaire == 'dossier' || $this->f->contexte_dossier_instruction()) {
                    //
                    if ($show_btn_edit == false
                        && $show_btn_delete == false
                        && $show_checkbox == false) {
                        //
                        printf($line, $style,
                            sprintf($button, '3', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Consulter'), 'consult'),
                            (! empty($row['libelles_evenements_suggeres']) ?
                                $this->get_icon_suggested_instruction_html($row['libelles_evenements_suggeres']) :
                                ''),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_libelle']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['dossier_contrainte_texte']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $contrainte_reference),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_nature']));
                    }
                    //
                    if ($show_btn_edit == true
                        && $show_btn_delete == false
                        && $show_checkbox == false) {
                        //
                        printf(
                            $line,
                            $style,
                            sprintf($button, '3', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Consulter'), 'consult'),
                            sprintf($button, '1', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Modifier'), 'edit'),
                            (! empty($row['libelles_evenements_suggeres']) ?
                                $this->get_icon_suggested_instruction_html($row['libelles_evenements_suggeres']) :
                                ''),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_libelle']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['dossier_contrainte_texte']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $contrainte_reference),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_nature']));
                    }
                    //
                    if ($show_btn_edit == false
                        && $show_btn_delete == true
                        && $show_checkbox == false) {
                        //
                        printf(
                            $line,
                            $style,
                            sprintf($button, '3', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Consulter'), 'consult'),
                            sprintf($button, '2', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Supprimer'), 'delete'),
                            (! empty($row['libelles_evenements_suggeres']) ?
                                $this->get_icon_suggested_instruction_html($row['libelles_evenements_suggeres']) :
                                ''),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_libelle']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['dossier_contrainte_texte']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $contrainte_reference),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_nature']));
                    }
                    if ($show_btn_edit == false
                        && $show_btn_delete == false
                        && $show_checkbox == true) {
                        //
                        printf($line, $style,
                            sprintf(
                                $templateCheckboxContrainte,
                                $row['dossier_contrainte_id']
                            ),
                            sprintf($button, '3', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Consulter'), 'consult'),
                            (! empty($row['libelles_evenements_suggeres']) ?
                                $this->get_icon_suggested_instruction_html($row['libelles_evenements_suggeres']) :
                                ''),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire,
                                $idxformulaire, $row['contrainte_libelle']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['dossier_contrainte_texte']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $contrainte_reference),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_nature']));
                    }
                    //
                    if ($show_btn_edit == true
                        && $show_btn_delete == true
                        && $show_checkbox == false) {
                        //
                        printf(
                            $line,
                            $style,
                            sprintf($button, '3', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Consulter'), 'consult'),
                            sprintf($button, '1', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Modifier'), 'edit'),
                            sprintf($button, '2', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Supprimer'), 'delete'),
                            (! empty($row['libelles_evenements_suggeres']) ? $this->get_icon_suggested_instruction_html(
                                $row['libelles_evenements_suggeres']) :
                                ''),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_libelle']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['dossier_contrainte_texte']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $contrainte_reference),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_nature']));
                    }
                    //
                    if ($show_btn_edit == true
                        && $show_btn_delete == false
                        && $show_checkbox == true) {
                        //
                        printf(
                            $line,
                            $style,
                            sprintf(
                                $templateCheckboxContrainte,
                                $row['dossier_contrainte_id']
                            ),
                            sprintf($button, '3', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Consulter'), 'consult'),
                            sprintf($button, '1', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Modifier'), 'edit'),
                            (! empty($row['libelles_evenements_suggeres']) ?
                                $this->get_icon_suggested_instruction_html($row['libelles_evenements_suggeres']) :
                                ''),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_libelle']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['dossier_contrainte_texte']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $contrainte_reference),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_nature']));
                    }
                    //
                    if ($show_btn_edit == false
                        && $show_btn_delete == true
                        && $show_checkbox == true) {
                        //
                        printf(
                            $line,
                            $style,
                            sprintf(
                                $templateCheckboxContrainte,
                                $row['dossier_contrainte_id']
                            ),
                            sprintf($button, '3', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Consulter'), 'consult'),
                            sprintf($button, '2', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Supprimer'), 'delete'),
                            (! empty($row['libelles_evenements_suggeres']) ?
                                $this->get_icon_suggested_instruction_html($row['libelles_evenements_suggeres']) :
                                ''),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_libelle']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['dossier_contrainte_texte']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $contrainte_reference),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_nature']));
                    }
                    //
                    if ($show_btn_edit == true
                        && $show_btn_delete == true
                        && $show_checkbox == true) {
                        //
                        printf(
                            $line,
                            $style,
                            sprintf(
                                $templateCheckboxContrainte,
                                $row['dossier_contrainte_id']
                            ),
                            sprintf($button, '3', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Consulter'), 'consult'),
                            sprintf($button, '1', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Modifier'), 'edit'),
                            sprintf($button, '2', $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, _('Supprimer'), 'delete'),
                            (! empty($row['libelles_evenements_suggeres']) ?
                                $this->get_icon_suggested_instruction_html($row['libelles_evenements_suggeres']) :
                                ''),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_libelle']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['dossier_contrainte_texte']), 
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $contrainte_reference),
                            sprintf($link, $row['dossier_contrainte_id'], $retourformulaire, 
                                $idxformulaire, $row['contrainte_nature']));
                    }
                }
            
                // Sauvegarde les données
                $lastRow['contrainte_groupe'] = $row['contrainte_groupe'];
                $lastRow['contrainte_sousgroupe'] = $row['contrainte_sousgroupe'];
            }
            // Ferme le tableau
            printf("</table>");
            // Ferme le sous-groupe
            printf("</div>");
            // Ferme le groupe
            printf("</div><br>");
            // Affichage du bouton permettant de ne conserver que les contraintes sélectionnées
            if ($show_checkbox == true) {
                $this->f->layout->display_form_button(array(
                    "name" => "supprimer_contraintes_non_selectionnees",
                    "value" => __("Conserver les contraintes sélectionnées"),
                    "onclick" => sprintf("supprimer_contraintes_non_selectionnees('%s','%s');", $idxformulaire, $obj)
                ));
            }
        }

        // Ferme la div
        printf("</div>");
        // Ferme la div
        printf("</div>");
    }

    /**
     * VIEW - supprimer_contraintes_non_selectionnees.
     *
     * Permet de supprimer toutes les contraintes non séléctionnées du tableau
     * des contraintes.
     *
     * @return void
     */
    function supprimer_contraintes_non_selectionnees(){
        $obj = get_class($this);
        $response = array();
        $response['msg_error'] = '';
        $response['msg_validation'] = __('Aucune contrainte supprimée.');
        // Récupération de la liste des contraintes à supprimer
        if ($this->f->get_submitted_post_value("contraintes_a_conserver") != null) {
            $dossierContraintes = $this->f->get_submitted_post_value("contraintes_a_conserver");
        }
        // Si ce n'est pas un tableau de références
        if (is_array($dossierContraintes) === false || $dossierContraintes === array()) {
            $response['msg_error'] = __("Aucune contraintes a supprimer.");
            $this->f->addToLog(__METHOD__."(): ".$response['msg_error'], VERBOSE_MODE);
            printf(json_encode($response));
            return;
        }
        
        // Suppression des contraintes
        $listContrainteSuppr = '';
        $listContrainteNonSuppr = '';
        foreach ($dossierContraintes as $dossierContrainte) {
            // Si la contrainte n'a pas été cochée alors elle est supprimée
            if ($dossierContrainte['val'] === false || $dossierContrainte['val'] === 'false') {
                $contrainteASupprimer = $this->f->get_inst__om_dbform(array(
                    'obj' => $obj,
                    'idx' => $dossierContrainte['id']
                ));
                // Récupération du libellé de la contrainte
                $libContrainte = $this->getLibelleFromContrainte($contrainteASupprimer->getVal('contrainte'));
                // Suppression des champs qui n'existe pas dans la BD
                $value = array();
                foreach ($contrainteASupprimer->champs as $key => $champ) {
                    // Terme à chercher
                    $search_field = 'contrainte_';
                    // Si dans le champ le terme est trouvé
                    if (strpos($champ, $search_field) !== false) {
                        // Supprime le champ
                        unset($contrainteASupprimer->champs[$key]);
                    } else {
                        // Récupère la valeur du champ
                        $value[$champ] = $contrainteASupprimer->val[$key];
                    }
                }
                $supprimer = $contrainteASupprimer->supprimer($value);
                // Si la suppression de la contrainte a réussi ajoute le libellé de la contrainte au tableau
                if ($supprimer == true) {
                    $listContrainteSuppr .= '<li>'.$libContrainte.'</li>';
                } else {
                    $listContrainteNonSuppr .= '<li>'.$libContrainte.'</li>';
                }
            }
        }

        // Message indiquant la liste des contraintes supprimées
        if ($listContrainteSuppr != '') {
            $response['msg_validation'] = sprintf(
                '%s : <ul>%s</ul>',
                __('Les contraintes suivantes ont été supprimées avec succès'),
                $listContrainteSuppr
            );
        }
        // Message indiquant la liste des contraintes pour lesquelles la suppression
        // a échouée
        if ($listContrainteNonSuppr != '') {
            $response['msg_error'] = sprintf(
                '%s : <ul>%s</ul>',
                __('La suppression des contraintes suivantes à échouée'),
                $listContrainteNonSuppr
            );
        }

        printf(json_encode($response), JSON_HEX_APOS);
    }

    /**
     * Permet d'ajouter des champs au formulaire.
     * @param string $champ Nom du champ
     */
    function setChamp($champ) {
        // Ajoute un champ
        $this->champs[] = $champ;
    }

    /**
     * Permet de définir le type des champs.
     * @param object  &$form Objet du formulaire
     * @param integer $maj   Mode du formulaire
     */
    function setType(&$form,$maj) {
        parent::setType($form, $maj);
        
        // Les champs à cacher
        $form->setType('dossier_contrainte', 'hidden');
        $form->setType('dossier', 'hidden');
        $form->setType('contrainte', 'hidden');
        $form->setType('reference', 'hidden');

        // En mode ajouté
        if ($maj == 0) {
            //
            $form->setType('texte_complete', 'hidden');
            // Pour chaque champ
            foreach ($this->champs as $key => $value) {
                // 
                $search_field = 'contrainte_';
                // Qui contient le mot 'contrainte_'
                if (strpos($value, $search_field) !== false) {
                    //
                    $form->setType($value, 'checkbox');
                }
            }
        }
    }

    /**
     * Permet de définir la taille des champs.
     * @param object  &$form Objet du formulaire
     * @param integer $maj   Mode du formulaire
     */
    function setTaille(&$form, $maj) {
        parent::setTaille($form, $maj);

        // En mode ajouté
        if ($maj == 0) {
            // Pour chaque champ
            foreach ($this->champs as $key => $value) {
                //
                $search_field = 'contrainte_';
                // Qui contient le mot 'contrainte_'
                if (strpos($value, $search_field) !== false) {
                    //
                    $form->setTaille($value, 1);
                }
            }
        }
    }

    /**
     * Permet de définir le nombre de caractères maximum des champs.
     * @param object  &$form Objet du formulaire
     * @param integer $maj   Mode du formulaire
     */
    function setMax(&$form, $maj) {
        //
        parent::setMax($form, $maj);
        // En mode ajouté
        if ($maj == 0) {
            // Pour chaque champ
            foreach ($this->champs as $key => $value) {
                //
                $search_field = 'contrainte_';
                // Qui contient le mot 'contrainte_'
                if (strpos($value, $search_field) !== false) {
                    //
                    $form->setMax($value, 1);
                }
            }
        }
    }

    /**
     * Permet de définir le libellé des champs.
     * @param object  &$form Objet du formulaire
     * @param integer $maj   Mode du formulaire
     */
    function setLib(&$form,$maj) {
        //
        parent::setLib($form, $maj);
        // En mode ajouté
        if ($maj == 0) {
            // Pour chaque champ
            foreach ($this->champs as $key => $value) {
                //
                $search_field = 'contrainte_';
                // Qui contient le mot 'contrainte_'
                if (strpos($value, $search_field) !== false) {
                    //
                    $form->setLib($value, 
                        $this->listContraintes[$value]['contrainte_lib']);
                }
            }
        }
    }

    /**
     * SETTER_FORM - setValsousformulaire (setVal).
     *
     * @return void
     */
    function setValsousformulaire(&$form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire, &$dnu1 = null, $dnu2 = null) {
        parent::setValsousformulaire($form, $maj, $validation, $idxformulaire, $retourformulaire, $typeformulaire);
        // En mode ajout
        if ($maj == 0) {
            // Si le formulaire principal est 'dossier_instruction'
            if ($this->f->contexte_dossier_instruction()) {
                // Valeur du dossier en cours
                $form->setVal("dossier", $idxformulaire);
            }
        }
        // XXX L'objectif de cette portion de code n'est pas de faire un setVal
        // Pas en mode ajout
        if ($maj != 0) {
            // Pour chaque champ
            foreach ($this->champs as $key => $value) {
                $search_field = 'contrainte_';
                // Qui contient le mot 'contrainte_'
                if (strpos($value, $search_field) !== false) {
                    unset($this->champs[$key]);
                }
            }
        }
    }

    /**
     * Récupère la liste des contraintes de la collectivité du dossier
     * et de la multicollectivité.
     * @return object Résultat de la requête
     */
    function getListContraintes($id_dossier = "") {
        $dossier_collectivite = "";
        if ($id_dossier != "") {
            // Récupération de la collectivité du dossier
            $dossier = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $id_dossier,
            ));
            $dossier_collectivite = $dossier->getVal("om_collectivite");
        }
        
        // Requête SQL
        $collectivity_filter = '';
        if (! empty($dossier_collectivite)) {
            $collectivity_filter = sprintf(
                "AND (om_collectivite.niveau = '2' 
                    OR contrainte.om_collectivite = '%d')",
                intval($dossier_collectivite)
            );
        }
        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT 
                    contrainte.contrainte as contrainte_id,
                    lower(contrainte.groupe) as contrainte_groupe, 
                    lower(contrainte.sousgroupe) as contrainte_sousgroupe,
                    contrainte.libelle as contrainte_lib,
                    contrainte.no_ordre as contrainte_ordre
                FROM 
                    %1$scontrainte
                    LEFT JOIN %1$som_collectivite
                        ON contrainte.om_collectivite = om_collectivite.om_collectivite
                WHERE 
                    (contrainte.om_validite_fin IS NULL
                        OR contrainte.om_validite_fin > CURRENT_DATE)
                    %2$s
                ORDER BY 
                    contrainte_groupe DESC, 
                    contrainte_sousgroupe, 
                    contrainte.no_ordre, 
                    contrainte.libelle',
                DB_PREFIXE,
                $collectivity_filter
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        // Résultat retourné
        return $qres['result'];
    }

    /**
     * Méthode de mise en page.
     * @param object  &$form Objet du formulaire
     * @param integer $maj   Mode du formulaire
     */
    function setLayout(&$form, $maj) {

        // En mode ajouté
        if ($maj == 0 ) {

            // Si la liste des contraintes n'est pas vide
            if (!empty($this->listContraintes)) {

                // Sauvegarde des données des contraintes pour les comparer
                $contrainte_before = array();
                $contrainte_before['contrainte_groupe'] = '';
                $contrainte_before['contrainte_sousgroupe'] = '';
                $contrainte_before['key'] = '';

                // Pour chaque contrainte
                foreach ($this->listContraintes as $key => $contrainte) {
                 
                    // Si l'identifiant du groupe de la contrainte présente et 
                    // celle d'avant est différent
                    if ($contrainte['contrainte_groupe'] 
                        != $contrainte_before['contrainte_groupe']) {
                        // Si l'identifiant du groupe d'avant est vide
                        if ($contrainte_before['contrainte_groupe'] != '') {
                            // Ferme le fieldset
                            $form->setFieldset($contrainte_before['key'], 'F');
                        }
                        // Ouvre le fieldset
                        $form->setFieldset($key, 'D', $contrainte['contrainte_groupe'], 
                            "startClosed text_capitalize");
                    }

                    // Si l'identifiant de la sous-catégorie de la contrainte présente 
                    // et celle d'avant est différent
                    if ($contrainte['contrainte_sousgroupe'] 
                        != $contrainte_before['contrainte_sousgroupe']) {
                        // Si l'identifiant de la sous-catégorie d'avant est vide
                        if ($contrainte_before['contrainte_sousgroupe'] != '') {
                            // Ferme le fieldset
                            $form->setFieldset($contrainte_before['key'], 'F');
                        }

                        // Si la contrainte a un sous-groupe
                        if ($contrainte['contrainte_sousgroupe'] != null) {
                            // Ouvre le fieldset
                            $form->setFieldset($key, 'D', 
                                $contrainte['contrainte_sousgroupe'], 
                                "startClosed text_capitalize");
                        }
                    }
                    //
                    $form->setBloc($key, 'DF', "", "");

                    // Sauvegarde les données de la contrainte
                    $contrainte_before['contrainte_groupe'] = 
                        $contrainte['contrainte_groupe'];
                    $contrainte_before['contrainte_sousgroupe'] = 
                        $contrainte['contrainte_sousgroupe'];
                    $contrainte_before['key'] = $key;
                }
                // Ferme le dernier fieldset
                $form->setFieldset($contrainte_before['key'], 'F');

            } 

            // Si la liste des contraintes est vide
            if (empty($this->listContraintes)) {
                // On affiche un message
                $form->setBloc('dossier_contrainte', 'D', _("Aucune contraintes."), 
                    "noDataForm");
            }

        }

        // Pas en mode ajout
        if ($maj != 0) {
            // Ouvre le fieldset
            $form->setFieldset('texte_complete', 'DF', _("dossier_contrainte"), "");
        }
        
    }

    /**
     * Permet de modifier l'affichage des boutons dans le sousformulaire.
     * @param string  $datasubmit Données a transmettre
     * @param integer $maj        Mode du formulaire
     * @param array   $val        Valeur du formulaire
     */
    function boutonsousformulaire($datasubmit, $maj, $val = null) {

        (isset($_GET['obj']) ? $obj = $this->f->get_submitted_get_value('obj') : $obj = "");
        ($this->f->get_submitted_get_value('idxformulaire') !== null ? $id_dossier = 
            $this->f->get_submitted_get_value('idxformulaire') : $id_dossier = "");
        //
        if (!$this->correct) {
            // Action par défaut
            $onclick =  "affichersform('".$this->get_absolute_class_name()."', 
                '$datasubmit', this.form);return false;";
            //
            switch ($maj) {
                case 0:
                    $bouton = _("Appliquer les changements");
                    // Action en mode ajouter
                    $onclick = "dossierContrainteValidationForm(".$this->get_absolute_class_name().", 
                        '".OM_ROUTE_FORM."&obj=" . $obj
                        . "&action=5"
                        . "&idx=0"
                        . "&idxformulaire=" . $id_dossier . "', 
                        this.form);return false;";
                    break;
                case 1:
                    $bouton = _("Modifier");
                    break;
                case 2:
                    $bouton = _("Supprimer");
                    break;
            }
            //
            $params = array(
                "value" => $bouton,
                "onclick" => $onclick,
            );
            //
            $this->f->layout->display_form_button($params);
        }
    }

    /**
     * Permet de modifier le bouton retour du sousformulaire.
     * @param mixed   $idxformulaire    Identifiant du formulaire parent
     * @param string  $retourformulaire Formulaire parent
     * @param array   $val              Valeurs du formulaire
     * @param string  $objsf            Objet du sousformulaire
     * @param integer $premiersf        Premier enregistrement affiché
     * @param string  $tricolsf         Colonne triée
     * @param integer $validation       Validation du formulaire
     * @param mixed   $idx              Identifiant de l'enregistrement
     * @param integer $maj              Mode du formulaire
     * @param srting  $retour           Retour du formulaire
     */
    function retoursousformulaire($idxformulaire = NULL, $retourformulaire = NULL, $val = NULL,
                                  $objsf = NULL, $premiersf = NULL, $tricolsf = NULL, $validation = NULL,
                                  $idx = NULL, $maj = NULL, $retour = NULL) {

        // Si le formulaire parent est dossier
        if($this->f->contexte_dossier_instruction()) {

            // bouton retour HTML
            echo sprintf("\n".
                '<a class="retour" href="#" id="sousform-action-%s-back-%s" data-href="%s">%s</a>'."\n",
                $objsf, uniqid(),
                sprintf(
                    OM_ROUTE_SOUSFORM."&obj=%s&action=%d&idx=%s&retourformulaire=%s&idxformulaire=%s",
                    $objsf, 4, $idxformulaire, $retourformulaire, $idxformulaire
                ),
                __('Retour')
            );

        } else {
            //
            parent::retoursousformulaire($idxformulaire, $retourformulaire, $val,
                                  $objsf, $premiersf, $tricolsf, $validation,
                                  $idx, $maj, $retour);
        }
    }

    /**
     * TRIGGER - triggermodifier.
     *
     * @return boolean
     */
    function triggermodifier($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);
        // Si le texte complété de la liaison venait du SIG et qu'il a été
        // modifié
        if ($this->valF['reference'] == 't'
            && $this->getVal('texte_complete') != $this->valF['texte_complete']) {
            // Indique que ce n'est pas le texte complété du SIG
            $this->valF['reference'] = 'f';
        }
    }

    /**
     * Recupère le libellé de la contrainte.
     * @param integer $contrainte Identifiant de la contrainte
     * 
     * @return string             Libellé de la contrainte
     */
    function getLibelleFromContrainte($contrainte) {
        $inst_contrainte = $this->f->get_inst__om_dbform(array(
            "obj" => "contrainte",
            "idx" => $contrainte,
        ));
        return $inst_contrainte->getVal("libelle");
    }

    /**
     * Récupère le texte de la contrainte.
     * @param integer $contrainte Identifiant de la contrainte
     * 
     * @return string             Texte de la contrainte
     */
    function getTexteFromContrainte($contrainte) {
        $inst_contrainte = $this->f->get_inst__om_dbform(array(
            "obj" => "contrainte",
            "idx" => $contrainte,
        ));
        return $inst_contrainte->getVal("texte");
    }

    /**
     * VIEW - view_add
     *
     * Cette vue permet de traiter les contraintes postées et d'afficher
     * le résultat de ce traitement en AJAX.
     *
     * @return void
     */
    function view_add() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Désactivation des logs cause AJAX
        $this->f->disableLog();
        // Récupération des POST
        $postedValue = $this->f->get_submitted_post_value();
        $decodedPost = array();
        foreach ($postedValue as $key => $value) {
            $decodedPost[$key] = utf8_decode($value);
        }

        // Identifiant du dossier
        $dossier = $decodedPost['dossier'];

        // Définition des variables pour le message retourné
        $listAddContrainte = array();
        // $listDeleteContrainte = array();
        $message = "";
        // Message pour les ajouts
        $messageAdd = _("La contrainte %s a ete ajoutee au dossier.");

        // Pour chaque champ récupéré
        foreach ($decodedPost as $key => $value) {
            // Mot-clés à rechercher
            $search_field = 'contrainte_';
            // Si le mot-clés est présent dans l'identifiant du champ
            if (strpos($key, $search_field) !== false) {
                // Récupération de l'identifiant de la contrainte
                $id_contrainte = str_replace('contrainte_', '', $key);
                // Si la valeur du champ est 'Oui'
                if ($value === 'Oui') {
                    // Instancie la classe dossier_contrainte
                    $dossier_contrainte = $this->f->get_inst__om_dbform(array(
                        "obj" => "dossier_contrainte",
                        "idx" => "]",
                    ));
                    // Définit les valeurs
                    $val = array(
                        'dossier_contrainte' => ']',
                        'dossier' => $dossier,
                        'contrainte' => $id_contrainte,
                        'texte_complete' => $this->getTexteFromContrainte($id_contrainte),
                        'reference' => false
                    );
                    // Ajoute l'enregistrement
                    $ajouter = $dossier_contrainte->ajouter($val);
                    // Si la contrainte est ajouté
                    if ($ajouter == true) {
                        // Ajoute le libellé de la contrainte au tableau
                        $listAddContrainte[] = $this->getLibelleFromContrainte($id_contrainte);
                    }
                }
            }
        }

        // Pour chaque libellé sauvegardé dans les tableaux on compose un message
        foreach ($listAddContrainte as $key => $value) {
            $message .= sprintf($messageAdd, "<b>".$value."</b>")."<br/>";
        }

        // Si le message à retourner est vide
        if ($message == "") {
            // Message par défaut
            $message = _("Aucune action effectuee.");
        }

        // Retourne le message
        echo json_encode($message);
    }
    
    /**
     * Si le dossier d'instruction auquel est rattachée la consultation est 
     * cloturé, on affiche pas les liens du portlet.
     *
     * @return boolean true si non cloturé false sinon
     */
    function is_dossier_instruction_not_closed() {
        $idxformulaire = $this->getParameter("idxformulaire");
        $retourformulaire = $this->getParameter("retourformulaire");
        //Si le dossier d'instruction auquel est rattachée la consultation est 
        //cloturé, on affiche pas les liens du portlet
        if ( $idxformulaire != '' && 
            ($retourformulaire == 'dossier'
                || $this->f->contexte_dossier_instruction())){
                
            //On récuppère le statut du dossier d'instruction        
            $statut = $this->f->getStatutDossier($idxformulaire);
            if ( $this->f->isUserInstructeur() && $statut == "cloture" ){
                return false;
            }
        }
        return true;
    }


    function is_addable(){
        if ($this->f->can_bypass($this->get_absolute_class_name(), "ajouter")){
            return true;
        }
        if ($this->is_dossier_instruction_not_closed() === true &&
            $this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        return false;
    }

    function is_editable(){
        
        if ($this->f->can_bypass($this->get_absolute_class_name(), "modifier")){
            return true;
        }
        
        if ($this->is_dossier_instruction_not_closed() === true &&
            $this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        return false;
    }
    
    function is_deletable(){
        
        if ($this->f->can_bypass($this->get_absolute_class_name(), "supprimer")){
            return true;
        }
        
        if ($this->is_dossier_instruction_not_closed() === true &&
            $this->is_instructeur_from_division_dossier() === true) {
            return true;
        }
        return false;
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
     * CONDITION - can_user_access_dossier
     *
     * Vérifie que l'utilisateur a bien accès au dossier lié à la contrainte instanciée.
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
        if ($crud === 'delete') {
            //
            return false;
        }
        //
        return true;
    }


}


