<?php
/**
 * DBFORM - 'sous_dossier' - Surcharge dossier_instruction.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/dossier_instruction.class.php";

class sous_dossier extends dossier_instruction {

    protected $_absolute_class_name = "sous_dossier";

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        parent::init_class_actions();

        // ACTION - 7 - view_tab
        // Interface affichant les listings de sous-dossier
        $this->class_actions[7] = array(
            "identifier" => "view_tab",
            "view" => "view_tab",
            "permission_suffix" => "tab"
        );

        // ACTION - 8 - view_tab
        // Interface d'ajout de sous-dossier
        $this->class_actions[8] = array(
            "identifier" => "ajout_sous_dossier",
            "view" => "view_ajout_sous_dossier",
            "permission_suffix" => "consulter",
            "condition" => array("type_demande_existe")
        );

        // ACTION - 120 - geolocalisation
        // La géolocalisation des sous-dossiers n'est pas possible pour l'instant
        // et fera parti d'un developpement à part. En attendant, elle est désactivée.
        $this->class_actions[120] = array();
    }

    /**
     * Traitement spécifique pour la numérotation du dossier.
     *
     * Il n'y a pas de traitement spécifique pour les sous-dossiers. Cette surcharge
     * permet de ne pas avoir à gérer la numérotation des entités pour les sous dossiers.
     *
     * Renvoie un tableau contenant les valeurs à mettre à jour pour la numérotation.
     *
     * @param array tableau contenant les valeurs du formulaire.
     * @return array informations liées à la numérotation du dossier.
     */
    function traitementSpécifique($val = array()) {
        return array();
    }

    /**
     * Traitement du numéro de version d'un dossier.
     *
     * Renvoie le numéro de version.
     *
     * @param array tableau contenant les valeurs du formulaire
     * @return integer|null numero de version du dossier si il a pu être récupéré
     */
    protected function traitementNumeroVersion($val = array()) {
        // Récupération du numéro de version du dossier d'instruction
        return $this->getNumeroVersionSsDossier($val['dossier_parent']);
    }

    /**
     * Traitement automatique de la numérotation du dossier.
     * Renvoie un tableau contenant les valeurs nécessaires à la numérotation du
     * dossier.
     *
     * @param array tableau contenant les valeurs du formulaire.
     * @return array informations liées à la numérotation du dossier.
     */
    protected function traitementNumerotationDossierAuto($val = array()) {
        // GESTION DU SUFFIXE :
        // La version du suffixe est celle du type de sous dossier : à ne pas confondre avec celle du sous dossier lui même.
        // Exemple chronologique :
        // DI n° PC0130551600004M01SDA01 -> version 0
        // DI n° PC0130551600004M01SDA02 -> version 1
        // DI n° PC0130551600004MO1SDB01 -> version 2 !!";

        // L'option suffixe est obligatoirement active pour les sous-dossiers.
        // Récupération de la lettre associée au type de dossier d'instruction
        $code = $this->getCode($this->getDossierInstructionType());
        // Récupération du numéro de version en fonction du type de dossier d'instruction
        $numeroVersionTypeSsDossier = $this->getNumeroVersionTypeSsDossier(
            $val['dossier_parent'],
            $val['dossier_instruction_type']
        );
        // Construction du suffixe
        $suffixe = $code.$numeroVersionTypeSsDossier;

        // Récupération du dossier parent pour accèder à sa numérotation et à son libellé et les
        // recopier dans la numérotation du sous dossier
        $dossierParent = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $val['dossier_parent'],
        ));

        return array(
            'dossier' => $val['dossier_parent'].$suffixe,
            'dossier_libelle' => $dossierParent->getVal('dossier_libelle').' '.$suffixe,
            'numerotation_type' => ! empty($dossierParent->getVal("numerotation_type")) ?
                $dossierParent->getVal("numerotation_type") :
                null,
            'numerotation_dep' => ! empty($dossierParent->getVal("numerotation_dep")) ?
                $dossierParent->getVal("numerotation_dep") :
                null,
            'numerotation_com' => ! empty($dossierParent->getVal("numerotation_com")) ?
                $dossierParent->getVal("numerotation_com") :
                null,
            'numerotation_division' => ! empty($dossierParent->getVal("numerotation_division")) ?
                $dossierParent->getVal("numerotation_division") :
                null,
            'numerotation_num' => ! empty($dossierParent->getVal("numerotation_num")) ?
                $dossierParent->getVal("numerotation_num") :
                null,
            'numerotation_suffixe' => $code,
            'numerotation_num_suffixe' => $numeroVersionTypeSsDossier
        );
    }

    /**
     * Récupère le numéro de version d'un sous dossier (SD) à l'aide d'une
     * requête sql.
     * 
     * En cas d'erreur sur la requête arrête l'execution et affiche un message
     * d'erreur.
     *
     * @param string identifiant du dossier parent
     * @return integer numéro de version du SD
     */
    protected function getNumeroVersionSsDossier($dossierParent) {
        // Récupère le dernier numéro de version associé au dossier parent
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    MAX(version)
                FROM 
                    %1$sdossier
                WHERE 
                    dossier_parent = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossierParent)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Par défaut si le numéro de version est en erreur renvoie 0
        if ($qres["code"] !== "OK") {
            return 0;
        }
        // Si la requête ne renvoie rien c'est qu'il n'y a pas de sous dossier associé au
        // dossier parent, il s'agit donc du sous dossier de version 0.
        // Si la requête renvoie un 
        $numVersionSsDossier = ! isset($qres["result"]) || $qres["result"] === '' ?
            0 :
            intval($qres["result"]) + 1;
        return $numVersionSsDossier;
    }

    /**
     * Calcul le numéro de version d'un type de sous dossier.
     * A l'aide d'une requête compte le nombre de sous dossier de ce type déjà associé
     * au dossier parent. Renvoie le nombre obtenu en lui ajoutant 1 pour obtenir le
     * numéro de version.
     *
     * Si la requête échoue le nombre renvoyé est 00.
     *
     * @param string $dossierParent
     * @param integer $typeSsDossier
     * @return string numéro de version au format "01"
     */
    protected function getNumeroVersionTypeSsDossier($dossierParent, $typeSsDossier) {
        // Requête permettant de récupérer le nombre de sous dossier d'un type donné
        // rattaché à un dossier parent.
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT 
                    count(dossier) 
                FROM 
                    %1$sdossier
                WHERE
                    dossier.dossier_parent = \'%2$s\'
                    AND dossier.dossier_instruction_type = %3$s',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossierParent),
                intval($typeSsDossier)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Par défaut si le numéro de version est en erreur renvoie 0
        if ($qres["code"] !== "OK") {
            return '00';
        }
        return str_pad($qres["result"] + 1, 2, "0", STR_PAD_LEFT);
    }

    /**
     * Surcharge de la méthode d'affectation des dossiers.
     * Pour les sous-dossiers si aucun instructeur n'a été affecté au dossier
     * on récupère l'instructeur et la division du dossier parent.
     *
     * @param array valeurs récupérées à l'ajout du dossier
     * @return array tableau contenant l'affectation du dossier
     */
    protected function affectation_dossier($val) {
        // Traitement de l'affectation du dossier
        $affectation = parent::affectation_dossier($val);
        // Si le traitement n'a pas réussi à affecter le dossier on copie l'affectation du
        // dossier parent.
        if (empty($affectation['instructeur']) && ! empty($val['dossier_parent'])) {
            $dossierParent = $this->f->get_inst__om_dbform(array(
                "obj" => "dossier",
                "idx" => $val['dossier_parent']
            ));
            $instructeur = $dossierParent->getVal('instructeur');
            $division = $dossierParent->getVal('division');
            $instructeur_2 = $dossierParent->getVal('instructeur_2');
            $affectation['instructeur'] = empty($instructeur) ? null : $instructeur;
            $affectation['division'] = empty($division) ? null : $division;
            $affectation['instructeur_2'] = empty($instructeur_2) ? null : $instructeur_2;

            $affMsg = __("L'affectation du dossier parent a été reprise par défaut pour ce sous-dossier.");
            $this->addToMessage($affMsg);
        }

        return $affectation;
    }

    /**
     * VIEW - view_tab
     *
     * Vue d'affichage de l'onglet sous-dossier des dossiers d'instruction.
     *
     *
     *
     * @return void
     */
    function view_tab() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Si le paramètre 'idxformulaire' n'est pas vide
        // (idxformulaire est la valeur de la clé primaire du DI)
        if (! empty($this->f->get_submitted_get_value('idxformulaire'))) {
            // Initialisation des variables
            $idx = $this->f->get_submitted_get_value('idxformulaire');

            // Récupération du dossier et de son type
            $dossier = $this->get_inst_common("dossier_instruction", $idx);

            // Récupération de la liste de tous les sous-dossiers pouvant être associé au dossier
            $typesSsDossiers = $this->get_type_sous_dossier_par_type_DI($dossier->getVal('dossier_instruction_type'));
            if (empty($typesSsDossiers)) {
                $message = __("Aucun sous-dossier n'est associé à ce type de dossier.");
                $this->f->displayMessage('info', $message);
            }
            // Récupération du contexte du formulaire
            $retourformulaire = $this->f->get_submitted_get_value('retourformulaire');
            $retourformulaireBis = $this->f->get_submitted_get_value('?retourformulaire');
            $contexte = ! empty($retourformulaire) ? $retourformulaire : $retourformulaireBis;
            // Gestion des contextes particuliers
            if ($contexte === 'dossier_qualifier_qualificateur') {
                // Depuis l'onglet Qualification -> dossiers à qualifier on accède à des dossiers
                // d'instruction mais l'argument retourformulaire de l'url vaut :
                //    dossier_qualifier_qualificateur.
                // Cela pose un problème lors de la vérification du contexte d'ouverture du
                // sous-dossier et empêche son affichage. Pour éviter ça si le retour
                // on considère que l'objet de retour est dossier_instruction.
                $contexte = 'dossier_instruction';
            } elseif ($contexte == 'dossier_autorisation' && ! empty($retourformulaireBis)) {
                // Dans l'onglet Autorisation -> dossiers d'autorisation depuis un dossier
                // d'autorisation (DA) et on peut accéder à un dossier d'instruction (DI).
                // Dans ce cas le contexte enregistré est "dossier_autorisation" ce qui va poser
                // problème lors de l'ouverture du sous-dossier pour vérifier le contexte.
                // On cherche donc à récupérer le contexte d'ouverture du DI ouvert à partir du DA
                // (DI ou contentieux). Cette valeur est stocké dans l'attribut "?retourformulaire".
                $contexte = $retourformulaireBis;
            }
            $advsIdParent = $this->f->get_submitted_get_value('advs_id_parent');
            // Dans le contexte des widgets deux informations permettant de retourner dans
            // le contexte du listing du widget sont envoyées à l'url :
            //   - retour_widget
            //   - widget_recherche_id
            // Pour gérer la redirection dans le contexte des widgets on stocke ces paramètre
            $cplmtUrlWidget = '';
            $retourWidget = $this->f->get_submitted_get_value('retour_widget');
            $widgetRechercheId = $this->f->get_submitted_get_value('widget_recherche_id');
            if (! empty($retourWidget) && !empty($widgetRechercheId)) {
                $cplmtUrlWidget = '&retour_widget='.$retourWidget.
                    '&widget_recherche_id='.$widgetRechercheId;
            }

            // Affichage
            $contenuVue = '';
            $listeSsDossierEnErreur = '';
            // Affichage d'un listing par type de sous-dossier
            foreach ($typesSsDossiers as $typeSsDossiers) {
                if (! $this->type_demande_existe_et_est_unique($typeSsDossiers['dossier_instruction_type'])) {
                    $listeSsDossierEnErreur .= '<li>'.$typeSsDossiers['libelle'].'</li>';
                }
                $linkTabSsDossier = sprintf(
                    '%s&obj=sous_dossier&idxformulaire=%s&retour=tab&retourformulaire=%s&sous_dossier_type=%s&sous_dossier_type_lib=%s&advs_id=%s&%s',
                    OM_ROUTE_SOUSTAB,
                    $idx,
                    $contexte,
                    $typeSsDossiers['dossier_instruction_type'],
                    urlencode($typeSsDossiers['libelle']),
                    $advsIdParent,
                    $cplmtUrlWidget
                );

                $contenuVue .= sprintf(
                    '<div id="sousform-sous_dossier_%1$s">
                        <div class="soustab-message"></div>
                        <div class="soustab-container">
                            <script type="text/javascript" >
                                ajaxIt(\'sous_dossier_%1$s\', \'%2$s\');
                            </script>
                        </div>
                    </div>',
                    $typeSsDossiers['dossier_instruction_type'],
                    $linkTabSsDossier
                );
            }
            // Si il existe des sous-dossiers dont le paramétrage ne permet pas l'ajout, on
            // affiche un message pour indiquer lesquels et que tant que le paramétrage
            // n'aura pas été corrigé ce type de sous-dossier ne pourra pas être ajouté
            if (! empty($listeSsDossierEnErreur)) {
                $message = "Le paramétrage du(des) sous-dossier(s) suivant(s) n'est pas correct : ".
                    '<ul>'.$listeSsDossierEnErreur.'</ul>'.
                    __("Le paramétrage doit être corrigé pour que ce(s) sous-dossier(s) puisse(nt) être ajouté(s).").
                    __('Veuillez contactez votre administrateur.');
                $this->f->displayMessage('info', $message);
            }
            // Si le paramétrage a évolué, il est possible que certain type de sous-dossier ne soit
            // plus compatible avec le dossier en cours. Leur listing ne sera donc pas affiché.
            // Si des sous-dossiers de ce type ont été créé pour le dossier, ils ne seront plus
            // accessible.
            // Pour éviter ça on ajoute un listing supplémentaire qui affiche tous les sous dossiers
            // qui existe mais ne sont plus accessible. Si il n'y en a pas ce listing n'est pas
            // affiché
            $ssDossierHistorique = $this->get_sous_dossier_historique($idx);
            if (! empty($ssDossierHistorique)) {
                $linkTabSsDossier = sprintf(
                    '%s&obj=sous_dossier&idxformulaire=%s&retour=tab&retourformulaire=%s&sous_dossier_type=%s&sous_dossier_type_lib=%s&advs_id=%s',
                    OM_ROUTE_SOUSTAB,
                    $idx,
                    $contexte,
                    'sous_dossier_historique',
                    urlencode(__('sous dossier historique')),
                    $advsIdParent
                );

                $contenuVue .= sprintf(
                    '<div id="sousform-sous_dossier_%1$s">
                        <div class="soustab-message"></div>
                        <div class="soustab-container">
                            <script type="text/javascript" >
                                ajaxIt(\'sous_dossier_%1$s\', \'%2$s\');
                            </script>
                        </div>
                    </div>',
                    'sous_dossier_historique',
                    $linkTabSsDossier
                );
            }
            echo $contenuVue;
        }
    }

    /**
     * VIEW - view_ajout_sous_dossier
     *
     * Vue d'affichage de l'onglet sous-dossier des dossiers d'instruction.
     *
     *
     *
     * @return void
     */
    function view_ajout_sous_dossier() {

        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();
        // Récupération de l'identifiant du dossier parent
        $idDossierParent = $this->f->get_submitted_get_value('idxformulaire');
        $idTypeSsDossier = $this->f->get_submitted_get_value('sous_dossier_type');

        if (! empty($idDossierParent) && ! empty($idTypeSsDossier)) {
            // Récupération du type de demande servant à créer le dossier
            $demandeType = $this->get_types_demande_par_type_DI($idTypeSsDossier);
            // Le type de demande doit exister et être unique pour que le sous dossier
            // puisse être créé.
            if (empty($demandeType) || (! is_array($demandeType)) || (count($demandeType) > 1)) {
                $this->f->addToLog(
                    'Impossible de récupérer le type de demande permettant de créer le sous-dossier.',
                    DEBUG_MODE
                );
                return false;
            }
            // Récupération de l'identifiant du type de demande, puisqu'on a récupéré un seul
            // élément dans la liste des demandes le tableau obtenu a cette forme :
            //      $demandeType = array('0' => array('demande_type' => 'id_demande'));
            // Pour récupérer l'id on accède donc à la première entrée du tableau et on récupére
            // la valeur stockée dans la clé demande_type.
            // L'utilisation d'array_shift permet de sélectionner le première élément du tableau
            // quel que soit sa clé.
            $demandeType = (array_shift($demandeType))['demande_type'];
            // Récupération du dossier parent et de l'id du dossier d'autorisation lié au parent
            $diParent = $this->get_inst_common('dossier', $idDossierParent);
            $daParent = $diParent->getVal('dossier_autorisation');
            // Si l'option dossier commune est active on récupère la commune du dossier parent
            $commune = null;
            if ($this->f->is_option_dossier_commune_enabled()) {
                $commune = $diParent->getVal('commune');
            }

            // Cas des sous-dossiers : la plupart des informations sont issues du
            // dossier parent. Pour que la création de demande et de DI fonctionne
            // on simule le remplissage d'un formulaire en settant le tableau $this->valF
            // Du sous dossier on récupère :
            //   - l'identifiant du dossier parent,
            //   - la date de la demande,
            //   - le type de demande
            //   - le fait qu'il s'agisse d'un sous dossier
            // Du DI parent on récupère :
            //   - les paramétres de localisation
            //   - les infos du petitionnaire (ou autre)
            //   - les acteurs du dossier
            //   - la collectivité du dossier
            $valDemande = array(
                // Valeur issues du sous-dossier
                'demande_type' => $demandeType,
                'dossier_parent' => $diParent->getVal('dossier'),
                'date_demande' => (new DateTime())->format('d/m/Y'),
                'sous_dossier' => true,
                // Valeur définies par défaut
                'demande' => null,
                'dossier_autorisation_type_detaille' => $this->get_dossier_autorisation_da_type_detaille($daParent),
                'dossier_instruction' => $diParent->getVal('dossier'),
                'dossier_autorisation' => $daParent,
                'instruction_recepisse' => '',
                'autorisation_contestee' => '',
                'depot_electronique' => false,
                'commune' => $commune,
                'source_depot' => 'app',
                // Valeur issues du dossier
                'date_depot_mairie' => $diParent->getVal('date_depot_mairie'),
                'om_collectivite' => $diParent->getVal('om_collectivite'),
                'parcelle_temporaire' => $diParent->getVal('parcelle_temporaire'),
                'arrondissement' => '',
                'terrain_references_cadastrales' => $diParent->getVal('terrain_references_cadastrales'),
                'terrain_adresse_voie_numero' => $diParent->getVal('terrain_adresse_voie_numero'),
                'terrain_adresse_voie' => $diParent->getVal('terrain_adresse_voie'),
                'terrain_adresse_lieu_dit' => $diParent->getVal('terrain_adresse_lieu_dit'),
                'terrain_adresse_localite' => $diParent->getVal('terrain_adresse_localite'),
                'terrain_adresse_code_postal' => $diParent->getVal('terrain_adresse_code_postal'),
                'terrain_adresse_bp' => $diParent->getVal('terrain_adresse_bp'),
                'terrain_adresse_cedex' => $diParent->getVal('terrain_adresse_cedex'),
                'terrain_superficie' => $diParent->getVal('terrain_superficie'),
            );
            // Récupération des demandeurs du DI parent
            // utilisation d'un faux $_POST pour stocker les demandeurs de la demande
            $_POST = array();
            // Récupération des demandeurs du dossier parent
            $listDemandeurs = $diParent->get_demandeurs();
            // initialisation du tableau des valeurs du demandeur
            foreach ($listDemandeurs as $infoDemandeur) {
                $demandeurType = $infoDemandeur['type_demandeur'].
                    ($infoDemandeur['petitionnaire_principal'] == 't' ? '_principal' : '');
                // Si le type de demandeur n'existe pas dans le tableau alors on créé une
                // nouvelle clé dans laquelle on va stocker tous les id des demandeurs de ce
                // type a ajouté au dossier
                if (isset($_POST[$demandeurType]) === false) {
                    $_POST[$demandeurType] = array();
                }
                $_POST[$demandeurType][] = $infoDemandeur['demandeur'];
            }

            // Ajout de la demande
            $demande = $this->get_inst_common('demande', ']');
            // Prise en compte des faux POST pour permettre la liaison du dossier
            // avec les demandeurs
            $this->f->submitted_post_value = array();
            $this->f->set_submitted_value();
            $demande->getPostedValues();
            if (! $demande->ajouter($valDemande)) {
                $message = __("L'ajout de la demande du sous-dossier a echoué.").
                    ' '.
                    __("Veuillez contacter votre administrateur.");
                $this->f->addToLog($message, DEBUG_MODE);
                return false;
            }
            // redirection vers la page de consultation
            $idDossier = $demande->getVal('dossier_instruction');
            $url = 'Location: '.OM_ROUTE_FORM.'&obj=sous_dossier&action=3&idx='.$idDossier;
            header($url);
            return;
        }
        $message = __("Les paramètres permettant de gérer la demande n'ont pas pu être récupérés.");
        $this->f->addToLog(
            $message.' DI parent : '.$idDossierParent.', Type DI : '.$idTypeSsDossier,
            DEBUG_MODE
        );
        return false;
    }

    protected function get_type_sous_dossier_par_type_DI($typeDI) {
        $listeTypeSousDossier = array();
        // Si aucun type de dossier d'instruction n'a été passé en paramétre
        // on ne peut pas récupérer la liste des types de sous-dossier qui y sont
        // associé. On renvoie donc un tableau vide.
        if (empty($typeDI)) {
            return $listeTypeSousDossier;
        }
        $sql = sprintf(
            'SELECT
                dossier_instruction_type.dossier_instruction_type,
                dossier_instruction_type.libelle
            FROM
                %1$sdossier_instruction_type
                LEFT JOIN %1$slien_type_DI_type_DI
                    ON dossier_instruction_type.dossier_instruction_type = lien_type_DI_type_DI.dossier_instruction_type
            WHERE
                lien_type_DI_type_DI.type_DI_parent = %2$s
            ORDER BY
                dossier_instruction_type.libelle',
            DB_PREFIXE,
            $typeDI
        );
        $res = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        return $res['result'];
    }

    /**
     * Execute une requête pour récupérer la liste de tous les sous-dossiers
     * associé au dossier voulu mais dont le type n'est plus lié à celui du
     * dossier.
     *
     * Si aucun identifiant de dossier n'est passé en paramètre renvoie un
     * tableau vide.
     *
     * @param integer identifiant du dossier dont on chercher les sous-dossier
     * historique.
     * @return array liste de tous les sous-dossiers historique du dossier.
     */
    protected function get_sous_dossier_historique($idDossierParent) {
        // Si aucun identifiant de dossier d'instruction n'a été passé en paramétre
        // on ne peut pas récupérer la liste des sous-dossier historique.
        // On renvoie donc un tableau vide.
        if (empty($idDossierParent)) {
            return array();
        }
        $sql = sprintf(
            'SELECT
                dossier.dossier
            FROM
                %1$sdossier
                -- Récupère les sous-dossiers dont le type n est pas lié au type de dossier du dossier parent
                LEFT JOIN %1$sdossier_instruction_type
                    ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                        AND dossier.dossier_instruction_type NOT IN (
                        SELECT
                            lien_type_DI_type_DI.dossier_instruction_type
                        FROM
                            %1$sdossier
                            LEFT JOIN %1$sdossier_instruction_type
                                ON dossier.dossier_instruction_type = dossier_instruction_type.dossier_instruction_type
                            LEFT JOIN %1$slien_type_DI_type_DI
                                ON dossier_instruction_type.dossier_instruction_type = lien_type_DI_type_DI.type_di_parent
                        WHERE
                            dossier = \'%2$s\'
                    )
            WHERE
                -- Récupération uniquement des sous-dossier associé au dossier voulu
                dossier_instruction_type.sous_dossier IS TRUE
                AND dossier.dossier_parent = \'%2$s\'',
            DB_PREFIXE,
            $idDossierParent
        );
        $res = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        return $res['result'];
    }

    /**
     * Effectue une requête pour récupérer les types de demande
     * associés au type de dossier d'instruction (DI) passé en paramètre.
     * Renvoie l'identifiant des type de demande ou null si il n'a pas pu
     * être récupéré.
     *
     * @param integer $typeDI identifiant du type de DI
     * @return array identifiants des types de demande
     */
    protected function get_types_demande_par_type_DI($typeDI) {
        $idTypeDemande = null;
        // Si aucun type de dossier d'instruction n'a été passé en paramétre
        // on ne peut pas récupérer la liste des types de sous-dossier qui y sont
        // associé. On renvoie donc un tableau vide.
        if (empty($typeDI)) {
            return $idTypeDemande;
        }
        $sql = sprintf(
            'SELECT
                demande_type.demande_type
            FROM
                %1$sdemande_type
            WHERE
                demande_type.dossier_instruction_type = %2$s',
            DB_PREFIXE,
            $typeDI
        );
        $res = $this->f->get_all_results_from_db_query(
            $sql,
            array(
                "origin" => __METHOD__,
            )
        );
        return $res['result'];
    }

    /**
     * Vérifie si il existe un type de demande associé au type de
     * sous-dossier.
     *
     * Si le type de sous dossier passé en paramètre est vide cette méthode
     * renvoie false par défaut
     *
     * @param integer identifiant du type de sous dossier pour lequel on cherche à
     * vérifier si il existe un seul et unique type de demande
     * @return boolean
     */
    public function type_demande_existe_et_est_unique($idTypeSsDossier) {
        // Si le type de sous dossier n'est pas fourni alors on ne peut pas faire
        // la vérification et on renvoie false par défaut.
        if (empty($idTypeSsDossier)) {
            return false;
        }
        // Cherche un type de demande associée. Si rien n'a été récupéré alors
        // c'est qu'il n'y a pas de demande associée à ce type de dossier
        $idsTypeDemande = $this->get_types_demande_par_type_DI($idTypeSsDossier);
        return (! empty($idsTypeDemande))
            && is_array($idsTypeDemande)
            && (count($idsTypeDemande) == 1);
    }

    /**
     * (Surcharge) Retourne le type de formulaire : ADS, CTX RE, CTX IN ou DPC.
     *
     * Instancie le dossier parent et récupère son type d'affichage de formulaire.
     * Set le paramètre type_aff_form avec l'affichage du formulaire récupéré et
     * renvoie cette valeur.
     *
     * Si le paramètre type_aff_form a déjà une valeur alors on renvoie cette valeur
     * sans faire le traitement.
     *
     * @return mixed $type_aff_form Type de formulaire (string) ou false (bool) si erreur BDD.
     */
    function get_type_affichage_formulaire() {
        if (isset($this->type_aff_form) === true) {
            return $this->type_aff_form;
        }
        // Instanciation du dossier parent
        $idDossierParent = $this->getVal("dossier_parent");
        if ($this->getParameter('maj') == '0' OR $this->get_action_crud() === 'create') {
            $idDossierParent = $this->valF["dossier_parent"];
        }
        $dossierParent = $this->f->get_inst__om_dbform(array(
            'obj' => 'dossier',
            'idx' => $idDossierParent
        ));
        // Récupération du type d'affichage du formulaire du dossier parent
        $this->type_aff_form = $dossierParent->get_type_affichage_formulaire();
        return $this->type_aff_form;
    }

    /**
     * CONDITION - check_context
     *
     * Vérifie la correspondance groupes dossier/utilisateur.
     * Vérifie l'accès aux dossiers confidentiels.
     * Vérifie la correspondance groupe/classe.
     *
     * @return boolean
     */
    public function check_context() {
        // Le dossier doit être un objet valide
        $id = $this->getVal($this->clePrimaire);
        if ($id === 0 OR $id === '0' OR $id === '' OR $id === ']') {
            return false;
        }

        // Vérification que l'utilisateur a accès au dossier
        if ($this->can_user_access_dossier() === false) {
            return false;
        }
        // Vérification que la classe métier du parent est adéquate
        $objContexte = ! empty($_SESSION['contexte_sous_dossier']['obj_parent']) ?
            $_SESSION['contexte_sous_dossier']['obj_parent'] :
            $this->_absolute_class_name;
        return $this->is_class_dossier_corresponding_to_type_form($objContexte);
    }

    /**
     * Retourne le lien de retour (VIEW formulaire et VIEW sousformulaire).
     *
     * @param string $view Appel dans le contexte de la vue 'formulaire' ou de
     *                     la vue 'sousformulaire'.
     *
     * @return string
     */
    function get_back_link($view = "formulaire") {
        $contexte = $_SESSION['contexte_sous_dossier'];
        // Si on est pas sur le formulaire de consultation d'un sous_dossier ou que le contexte
        // n'a pas pu être récupéré affiche le lien de retour par défaut.
        $action = $this->f->get_submitted_get_value('action');
        if ((! empty($action) && $action != '3' && $action != '2') || empty($contexte)) {
            return parent::get_back_link($view);
        }
        $baseURL = OM_ROUTE_FORM;
        $paramsHref = array(
            'obj' => $contexte['obj_parent'],
            'action' => '3',
            'advs_id' => $contexte['advs_id_parent'],
            'direct_field' => 'dossier',
            'direct_form' => 'sous_dossier',
            'direct_action' => '7',
            'direct_idx' => $contexte['idxformulaire_parent'],
            'idx'=> $contexte['idxformulaire_parent']
        );
        $dossierParent = $this->f->get_inst__om_dbform(array(
            'obj' => $contexte['obj_parent'],
            'idx' => $contexte['idxformulaire_parent']
        ));
        $uid = $dossierParent->f->get_ui_tabs($contexte['obj_parent'], 'dossier', 'sous_dossier', '7', $contexte['idxformulaire_parent']);

        // Gestion du cas de retour vers un listing de widget
        if (! empty($contexte['retour_widget']) && ! empty($contexte['widget_recherche_id'])) {
            $paramsHref['retour_widget'] = $contexte['retour_widget'];
            $paramsHref['widget_recherche_id'] = $contexte['widget_recherche_id'];
        }

        // Construction du lien à partir des valeurs stockées dans le tableau
        $href = array_map(function ($key, $value) {
            return '&'.$key.'='.$value;
        }, array_keys($paramsHref), $paramsHref);
        $href = $baseURL.implode('', $href).'#ui-tabs-'.$uid;
        return $href;
    }


    /**
     * Permet de modifier le fil d'Ariane
     * @param string $ent Fil d'Ariane
     * @param array  $val Valeurs de l'objet
     * @param intger $maj Mode du formulaire
     */
    function getFormTitle($ent) {
        $ent = array(
            'termeGenerique' => __('instruction'),
            'libelleTypeDI' => __('sous-dossier'),
            'libelleParent' => '',
            'libelleSousDossier' => ''
        );

        // Si différent de l'ajout
        if ($this->getParameter('maj') != 0) {
            // Récupération du type de dossier pour afficher son libellé dans le
            // fil d'Ariane. Si rien n'est affiché on affiche le terme générique
            // sous-dossier
            $idTypeDI = $this->getVal('dossier_instruction_type');
            $typeDI = $this->f->get_inst__om_dbform(array(
                'obj' => 'dossier_instruction_type',
                'idx' => $idTypeDI
            ));
            $libelleTypeDI = $typeDI->getVal('libelle');
            $ent['libelleTypeDI'] = ! empty($libelleTypeDI) ? $libelleTypeDI : __('sous-dossier');

            // Si il y a un dossier parent associé, il est instancié pour accéder
            // à son libellé (identifiant découpé pour être plus lisible).
            // Vérifie si le libellé existeet si c'est le cas, il est intégré
            // au fil d'Ariane
            $idDossierParent = $this->getVal('dossier_parent');
            if (! empty($idDossierParent)) {
                $dossierParent = $this->f->get_inst__om_dbform(array(
                    'obj' => 'dossier',
                    'idx' => $idDossierParent
                ));
                $libelleParent = trim($dossierParent->getVal('dossier_libelle'));
                // Si le libellé n'a pas été récupérer on affiche l'identifiant à la place
                if (empty($libelleParent)) {
                    $libelleParent = $idDossierParent;
                }
                $ent['libelleParent'] = strtoupper($libelleParent);
            }
            // Récupération du numéro du sous-dossier en concatenant son suffixe et son
            // numéro de version
            $ent['libelleSousDossier'] = $this->getVal('numerotation_suffixe').
                str_pad($this->getVal('numerotation_num_suffixe'), 2, "0", STR_PAD_LEFT);
        }

        // Change le fil d'Ariane
        return implode(' -> ', $ent);
    }

    /**
     * CONDITION - is_last_di_of_da. (SURCHARGE)
     *
     * Vérifie que le sous-dossier courant est le plus récent de son
     * dossier d'instruction.
     *
     * @return boolean
     */
    function is_last_di_of_da() {
        // Récupère la plus haute version des DI du DA
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    MAX(version)
                FROM
                    %1$sdossier
                WHERE
                    dossier_parent = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($this->getVal('dossier_parent'))
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        // Si la version du dossier d'instruction courant est la dernière
        // version
        if ($qres["result"] === $this->getVal('version')) {
            return true;
        }
        return false;
    }

    /**
     * - Géolocalisation (copie dossier existant)
     */
    function triggerajouterapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        $this->addToLog(__METHOD__."(): start", EXTRA_VERBOSE_MODE);

        // si les étapes précédentes d'ajout on réussi
        if($res = parent::triggerajouterapres($id, $dnu1, $val, $dnu2)) {

            $di = $this->valF['dossier'];

            // récupération du DI qui vient d'être créé
            if (empty($di_inst = $this->f->findObjectById('dossier', $di))) {
                $this->addToMessage(sprintf(
                    __("Erreur lors de la récupération du DI %s (dossier non-trouvé)"),
                    $di));
                $this->correct = false;
                return false;
            }

            // s'il n'est pas déjà géolocalisé (la même fonction existe dans dossier::triggerajouterapres)
            if (empty($di_inst->getVal('geom'))) {

                $collectivite = $this->valF['om_collectivite'];
                $da = $val['dossier_autorisation'];
                $commune = $this->f->get_submitted_post_value("commune");
                $ref = $val['dossier_parent'];

                $ret = $di_inst->replicate_geolocalisation($di, $da, $collectivite, $commune, $ref);
                if (is_string($ret) || $ret === false) {
                    if (is_string($ret)) {
                        $this->addToMessage($ret);
                    }
                    $this->correct = false;
                    return false;
                }
            }
        }

        return $res;
    }
}
