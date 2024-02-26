<?php
/**
 * DBFORM - 'demande_avis' - Surcharge obj.
 *
 * Ce script permet de définir la classe 'demande_avis'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../obj/consultation.class.php";

class demande_avis extends consultation {

    /**
     *
     */
    protected $_absolute_class_name = "demande_avis";

    /**
     * Constructeur.
     */
    function __construct($id, &$dnu1 = null, $dnu2 = null) {
        //
        parent::__construct($id);
        //
        $this->setParameter("retourformulaire", "consultation");
    }

    var $required_field=array(
        "avis_consultation",
    );

    /**
     * Définition des actions disponibles sur la classe.
     *
     * @return void
     */
    function init_class_actions() {
        // ACTION - 003 - consulter
        // Fiche de consultation spécifique
        $this->class_actions[3] = array(
            "identifier" => "consulter",
            "permission_suffix" => "consulter",
            "crud" => "read",
            "view" => "view_synthese_demande_avis",
            "condition" => array(
                "exists",
                "is_from_good_service_or_tiers",
            ),
        );

        // ACTION - 004 - view_document_numerise
        // Interface spécifique du tableau des pièces
        $this->class_actions[4] = array(
            "identifier" => "view_document_numerise",
            "view" => "view_document_numerise",
            "permission_suffix" => "document_numerise",
        );

        // ACTION - 010 - view_consultation_tab
        // Listing des consultation du DI associé à la demande d'avis courante
        $this->class_actions[10] = array(
            "identifier" => "view_consultation_tab",
            "view" => "view_consultation_tab",
            "permission_suffix" => "consultation",
        );

        // ACTION - 080 - consulter_pdf
        // Pour qu'un cadre valide l'analyse
        $this->class_actions[80] = array(
            "identifier" => "consulter_pdf",
            "portlet" => array(
                "type" => "action-blank",
                "libelle" => _("Edition"),
                "order" => 50,
                "class" => "pdf-16",
            ),
            "view" => "view_consulter_pdf",
            "condition" => array("is_from_good_service"),
            "permission_suffix" => "consulter",
        );
    }

    /**
     * Clause select pour la requête de sélection des données de l'enregistrement.
     *
     * @return array
     */
    function get_var_sql_forminc__champs() {
        return array(
            "consultation.consultation as \"consultation\"",
            // Fieldset "Infos générales"
            // Fielsdet "Dossier"
            // 1ere ligne
            // 1ere colonne
            "consultation.dossier as \"dossier\"",
            "dossier.dossier_libelle as \"dossier_libelle\"",
            "division.chef as \"responsable\"",
            "etat.libelle as \"etat\"",
            // 2eme colonne
            "division.libelle as \"division\"",
            "concat(instructeur.nom,' tel. : '||instructeur.telephone) as \"instructeur\"",
            // 2eme ligne
            "to_char(dossier.date_depot ,'DD/MM/YYYY') as \"date_depot\"",
            "to_char(dossier.date_depot_mairie ,'DD/MM/YYYY') as \"date_depot_mairie\"",
            "to_char(dossier.date_dernier_depot ,'DD/MM/YYYY') as \"date_dernier_depot\"",
            "CASE WHEN dossier.incomplet_notifie IS TRUE AND dossier.incompletude IS TRUE 
                THEN to_char(dossier.date_limite_incompletude ,'DD/MM/YYYY') 
                ELSE to_char(dossier.date_limite ,'DD/MM/YYYY')
            END as \"dossier_date_limite\"",
            //"to_char(dossier.date_limite ,'DD/MM/YYYY') as \"dossier_date_limite\"",
            // 3eme ligne
            "dossier.autorite_competente as \"autorite_competente\"",
            // 4eme ligne
            'TRIM(CONCAT(personne_morale_denomination,\' \',personne_morale_nom,\' \',demandeur.particulier_nom)) as "petitionnaire"',
            "TRIM(CONCAT(demandeur.numero,' ',demandeur.voie,' ',demandeur.complement,
                  ' ',demandeur.lieu_dit,' ',demandeur.code_postal,' ',demandeur.localite,
                  ' ',demandeur.bp,' ',demandeur.cedex,' ',demandeur.pays)) as \"adresse_petitionnaire\"",
            "replace(dossier.terrain_references_cadastrales, ';', ' ') as \"parcelle\"",
            'TRIM(
                CASE
                    WHEN dossier.adresse_normalisee IS NULL
                        OR TRIM(dossier.adresse_normalisee) = \'\'
                    THEN
                        CONCAT_WS(
                            \' \',
                            dossier.terrain_adresse_voie_numero,
                            dossier.terrain_adresse_voie,
                            dossier.terrain_adresse_code_postal
                        )
                    ELSE
                        dossier.adresse_normalisee
                END
            ) as "terrain"',
            "public.ST_AsText(dossier.geom::geometry) as \"geom\"",
            // Fieldset "Demande d'avis"
            "to_char(consultation.date_envoi ,'DD/MM/YYYY') as \"date_envoi\"",
            "concat(service.delai,' ', 
                CASE 
                    WHEN 
                        service.delai_type = 'mois'
                    THEN 
                        '".__("mois")."'
                    ELSE
                        '".__("jour")."(s)'   
                END 
            ) as \"delai\"",
            "to_char(consultation.date_limite ,'DD/MM/YYYY') as \"date_limite\"",
            "consultation.date_retour as \"date_retour\"",
            "consultation.marque",
            // Fieldset "Avis rendu"
            "consultation.avis_consultation as \"avis_consultation\"",
            "consultation.motivation as \"motivation\"",
            "consultation.fichier as \"fichier\"",
            // Fermeture fieldset "Infos générales"
            // Fieldset "Principales caractéristiques du projet"
            "CONCAT_WS(
                '<br/>',
                CASE WHEN co_projet_desc = '' THEN
                    NULL
                ELSE
                    TRIM(co_projet_desc)
                END,
                CASE WHEN ope_proj_desc = '' THEN
                    NULL
                ELSE
                    TRIM(ope_proj_desc)
                END,
                CASE WHEN am_projet_desc = '' THEN
                    NULL
                ELSE
                    TRIM(am_projet_desc)
                END,
                CASE WHEN dm_projet_desc = '' THEN
                    NULL
                ELSE
                    TRIM(dm_projet_desc)
                END
            ) as \"description_projet\"",
            "donnees_techniques.su_tot_shon_tot||' m²' as \"surface_total_projet\"",
            "REGEXP_REPLACE(CONCAT(
                CASE
                    WHEN donnees_techniques.su_cstr_shon1 IS NULL
                    THEN ''
                    ELSE CONCAT('Habitation - ', donnees_techniques.su_cstr_shon1, ' m² <br/>')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon2 IS NULL
                    THEN ''
                    ELSE CONCAT('Hébergement hôtelier - ', donnees_techniques.su_cstr_shon2, ' m² <br/>')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon3 IS NULL
                    THEN ''
                    ELSE CONCAT('Bureaux - ', donnees_techniques.su_cstr_shon3, ' m² <br/>')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon4 IS NULL
                    THEN ''
                    ELSE CONCAT('Commerce - ', donnees_techniques.su_cstr_shon4, ' m² <br/>')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon5 IS NULL
                    THEN ''
                    ELSE CONCAT('Artisanat - ', donnees_techniques.su_cstr_shon5, ' m² <br/>')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon6 IS NULL
                    THEN ''
                    ELSE CONCAT('Industrie - ', donnees_techniques.su_cstr_shon6, ' m² <br/>')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon7 IS NULL
                    THEN ''
                    ELSE CONCAT('Exploitation agricole ou forestière - ', donnees_techniques.su_cstr_shon7, ' m² <br/>')
                END,
                CASE
                    WHEN donnees_techniques.su_cstr_shon8 IS NULL
                    THEN ''
                    ELSE CONCAT('Entrepôt - ', donnees_techniques.su_cstr_shon8, ' m² <br/>')
                END, 
                CASE
                    WHEN donnees_techniques.su_cstr_shon9 IS NULL
                    THEN ''
                    ELSE CONCAT('Service public ou d''intérêt collectif - ', donnees_techniques.su_cstr_shon9, ' m²')
                END
            ), ' <br/>$', '') as \"surface\"",
            "donnees_techniques.co_tot_ind_nb as \"nombre_logement_crees_individuel\"",
            "donnees_techniques.co_tot_coll_nb as \"nombre_logement_crees_collectif\"",
            "donnees_techniques.co_statio_apr_nb as \"nombre_places_parking\"",
            // Fermeture fieldset "Principales caractéristiques du projet"
            "consultation.service",
            "consultation.tiers_consulte",
            "consultation.motif_consultation",
            "consultation.categorie_tiers_consulte",
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
                LEFT JOIN %1$sdossier
                    ON consultation.dossier = dossier.dossier
                LEFT JOIN %1$sservice
                    ON service.service=consultation.service
                LEFT OUTER JOIN %1$sinstructeur
                    ON instructeur.instructeur=dossier.instructeur
                LEFT OUTER JOIN %1$sdivision
                    ON division.division=instructeur.division
                LEFT OUTER JOIN %1$savis_consultation 
                    ON consultation.avis_consultation=avis_consultation.avis_consultation 
                LEFT JOIN %1$sdonnees_techniques
                    ON donnees_techniques.dossier_instruction = dossier.dossier
                LEFT JOIN %1$slien_dossier_demandeur
                    ON dossier.dossier=lien_dossier_demandeur.dossier AND lien_dossier_demandeur.petitionnaire_principal IS TRUE
                LEFT JOIN %1$sdemandeur
                    ON demandeur.demandeur=lien_dossier_demandeur.demandeur
                LEFT JOIN %1$setat
                    ON dossier.etat = etat.etat',
            DB_PREFIXE,
            $this->table
        );
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_service() {
        return "SELECT service.service, service.abrege||' '||service.libelle FROM ".DB_PREFIXE."service WHERE ((service.om_validite_debut IS NULL AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE)) OR (service.om_validite_debut <= CURRENT_DATE AND (service.om_validite_fin IS NULL OR service.om_validite_fin > CURRENT_DATE))) ORDER BY service.abrege, service.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_service_by_id() {
        return "SELECT service.service, service.abrege||' '||service.libelle FROM ".DB_PREFIXE."service WHERE service = <idx>";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorite_competente() {
        return "SELECT autorite_competente.autorite_competente, autorite_competente.libelle FROM ".DB_PREFIXE."autorite_competente ORDER BY autorite_competente.libelle";
    }

    /**
     *
     * @return string
     */
    function get_var_sql_forminc__sql_autorite_competente_by_id() {
        return "SELECT autorite_competente.autorite_competente, autorite_competente.libelle FROM ".DB_PREFIXE."autorite_competente WHERE autorite_competente.autorite_competente = <idx>";
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
     * VIEW - view_consultation_tab.
     *
     * Tableau des consultations liés au dossier d'instruction de la demande
     * d'avis courante.
     *
     * On simule le contexte d'un DI afin d'avoir exactement le même onglet.
     *
     * @return void
     */
    public function view_consultation_tab() {
        // Vérification de l'accessibilité sur l'élément
        $this->checkAccessibility();

        // Récupère le numéro du dossier d'instruction
        $dossier = $this->getVal('dossier');

        // Redirige vers le soustab des consultations en simulant le contexte du
        // DI
        $link = sprintf(
            "Location: ".OM_ROUTE_SOUSTAB."&obj=consultation&retourformulaire=dossier_instruction&idxformulaire=%s",
            $dossier
        );
        header($link);
        exit();
    }


    function view_synthese_demande_avis() {
        // Concatenation des champs pour constitution de la clause select
        $listeChamp = implode(", ", $this->get_var_sql_forminc__champs());
        $tableSelect = $this->get_var_sql_forminc__tableSelect();
        // Concatenation de la requete de selection
        $sql = " select ".$listeChamp." from ".$tableSelect." ";
        //
        $sql .= "where consultation.consultation=".$this->getParameter("idx");

        // Execution de la requete
        $res = $this->f->db->limitquery($sql, 0, 1);
        $this->addToLog(
            __METHOD__."(): db->limitquery(\"".str_replace(",",", ",$sql)."\", 0, 1);",
            VERBOSE_MODE
        );
        if ($this->f->isDatabaseError($res, true) !== false) {
            // Appel de la methode de recuperation des erreurs
            $this->erreur_db($res->getDebugInfo(), $res->getMessage(), $tableSelect);
            return false;
        } else {
            $info = $res->tableInfo();
            // Initialisation de la cle a 0
            $i = 0;
            // Recuperation du nom de chaque champ dans l'attribut 'champs'
            foreach ($info as $elem) {
                $this->champs[$i++] = $elem['name'];
            }
            // Recuperation de l'enregistrement resultat de la requete
            while ($row =& $res->fetchRow()) {
                // Initialisation de la cle a 0
                $i = 0;
                // Recuperation de la valeur de chaque champ dans l'attribut 'val'
                foreach ($row as $elem) {
                    $this->val[$i++] = $elem;
                }
            }

            $this->formulaire();
        }
    }

    /**
     * TODO !!!
     *
     * @return boolean
     */
    function is_from_good_service() {
        // Si l'utilisateur est un utilisateur de service externe
        // on vérifie qu'il peut accéder à la consultation
        if ($this->f->isUserService()) {
            // On compare l'id du service de la consultation
            // aux id des services de utilisateur connecté
            foreach($this->f->om_utilisateur['service'] as $service) {

                if($this->val[array_search("service",$this->champs)]===$service['service']) {
                    
                    return true;
                }
            }
            //
            $this->f->addToLog("is_from_good_service(): utilisateur de service sur une consultation d'un autre service", EXTRA_VERBOSE_MODE);
        }
        return false;
    }

    /**
     * TODO !!!
     *
     * @return boolean
     */
    function is_from_good_tiers() {
        // Si l'utilisateur est un utilisateur de service externe
        // on vérifie qu'il peut accéder à la consultation
        if ($this->f->isUserTiers()) {
            // On compare l'id du service de la consultation
            // aux id des services de utilisateur connecté
            foreach ($this->f->om_utilisateur['tiers'] as $tiers) {

                if ($this->val[array_search("tiers_consulte", $this->champs)] === $tiers['tiers_consulte']) {
                    return true;
                }
            }
            //
            $this->f->addToLog("is_from_good_tiers(): utilisateur de tiers sur une consultation d'un autre tiers", EXTRA_VERBOSE_MODE);
        }
        return false;
    }

    /**
     * Cherche si la demande d'avis concerne un service ou un tiers et
     * fait appelle à la méthode correspondante.
     *
     * Par défaut si la bonne méthode n'a pas été récupérée renvoie false
     *
     * @return boolean
     */
    function is_from_good_service_or_tiers() {
        // Récupère le nom de la méthode selon le type de consultation
        $methodName = 'is_from_good_tiers';
        if ($this->getVal('service') != null && $this->getVal('service') != '') {
            $methodName = 'is_from_good_service';
        }
        // Fait appel à cette méthode si elle existe pour indiquer si l'utilisateur
        // peut accéder au service / tiers
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
        return false;
    }

    //==========================
    // Formulaire  [form]
    //==========================

    function setType(&$form, $maj) {
        parent::setType($form, $maj);
        //
        if($this->getParameter("maj") == 3) {
            $form->setType('consultation', 'hidden');
            $form->setType('service', 'hidden');
            $form->setType('categorie_tiers_consulte', 'hidden');
            $form->setType('tiers_consulte', 'hidden');
            $form->setType('motif_consultation', 'hidden');
            $form->setType('dossier', 'hidden');
            $form->setType('autorite_competente', 'selectstatic');
            $form->setType('date_depot', 'datestatic');
            $form->setType('date_depot_mairie', 'datestatic');
            $form->setType('date_envoi', 'datestatic');
            $form->setType('date_limite', 'datestatic');   
            $form->setType("date_retour", "hiddendate");
            $form->setType('zonages', 'datestatic');
            $form->setType('commune_quartier', 'hidden');
            $form->setType('autres_dispo', 'hidden');
            $form->setType('travaux', 'hidden');
            $form->setType('shon_total', 'hidden');
            $form->setType('terrain_surface', 'hidden');
            $form->setType('cu_operation', 'hidden');
            $form->setType('fichier', 'file');
            $form->setType('avis_consultation', 'selectstatic');
            $form->setType("motivation", "static");
            $form->setType("marque", "checkboxstatic");
        }
    }

    function setLib(&$form, $maj) {
        parent::setLib($form, $maj);

        if($this->getParameter("maj") == 3) {
            //libelle des champs
            $form->setLib('consultation', _('consultation'));
            $form->setLib('dossier', _('dossier'));
            $form->setLib('date_retour', _('date_retour'));
            $form->setLib('service', _('service'));
            $form->setLib('avis_consultation', _('avis_consultation'));
            $form->setLib('date_reception', _('date_reception'));
            $form->setLib('motivation', _('motivation'));
            $form->setLib('fichier', _('fichier'));
            $form->setLib('lu', _('lu'));
            $form->setLib('dossier_libelle', _('dossier_libelle'));
            $form->setLib('responsable', _('responsable'));
            $form->setLib('etat', _('etat'));
            $form->setLib('division', _('division'));
            $form->setLib('instructeur', _('instructeur'));
            $form->setLib('date_depot', _('date_depot'));
            $form->setLib('date_depot_mairie', _('date_depot_mairie'));
            $form->setLib('date_dernier_depot', _('date_dernier_depot'));
            $form->setLib('dossier_date_limite', _("date limite d'instruction"));
            $form->setLib('autorite_competente', _('autorite_competente'));
            $form->setLib('petitionnaire', _('demandeur'));
            $form->setLib('adresse_petitionnaire', _('adresse_demandeur'));
            $form->setLib('parcelle', _('parcelle'));
            $form->setLib('terrain', _('localisation'));
            $form->setLib('geom', _('geolocalisaion'));
            $form->setLib('date_envoi', _('date_envoi'));
            $form->setLib('delai', _('delai de reponse'));
            $form->setLib('date_limite', _('date limite de reponse'));
            $form->setLib('description_projet', _('description_projet'));
            $form->setLib('surface_total_projet', _('surface_total_projet'));
            $form->setLib('surface', _('surface creee par destination'));
            $form->setLib('nombre_logement_crees_collectif', _('nombre_logement_crees_collectif'));
            $form->setLib('nombre_logement_crees_individuel', _('nombre_logement_crees_individuel'));
            $form->setLib('nombre_places_parking', _('nombre_places_parking'));
        }
    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);
        //
        if ($this->getParameter("maj") == 3) {
            // avis_consultation
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "avis_consultation",
                $this->get_var_sql_forminc__sql("avis_consultation"),
                $this->get_var_sql_forminc__sql("avis_consultation_by_id"),
                true
            );
            // dossier
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "dossier",
                $this->get_var_sql_forminc__sql("dossier"),
                $this->get_var_sql_forminc__sql("dossier_by_id"),
                false
            );
            // service
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "service",
                $this->get_var_sql_forminc__sql("service"),
                $this->get_var_sql_forminc__sql("service_by_id"),
                true
            );
            // autorite_competente
            $this->init_select(
                $form,
                $this->f->db,
                $maj,
                null,
                "autorite_competente",
                $this->get_var_sql_forminc__sql("autorite_competente"),
                $this->get_var_sql_forminc__sql("autorite_competente_by_id"),
                false
            );
        }
    }// fin select

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        if ($this->getParameter("maj") == 3) {
            if ($this->getVal("geom") != ""
                && $this->f->getParameter("option_sig") == "sig_externe"
                && $this->f->issetSIGParameter($this->getVal("dossier")) === true) {
                //
                $form->setVal(
                    "geom",
                    sprintf(
                        '<a id="action-form-localiser" target="_SIG" href="%s"><span class="om-icon om-icon-16 om-icon-fix sig-16" title="Localiser">Localiser</span> %s </a>',
                        OM_ROUTE_FORM."&obj=dossier_instruction&idx=".$this->getVal("dossier")."&action=140",
                        $this->getVal("geom")
                    )
                );
            }
        }
    }

    /**
     * Mise en page du formulaire
     * @param om_formulaire $form
     * @param integer $maj
     */
    function setLayout(&$form, $maj){

        if($this->getParameter("maj") == 3) {
            // Fieldset 'Informations generales'
            $form->setFieldset('dossier', 'D', _('Informations generales'));
                
                // Fieldset 'Dossier'
                $form->setFieldset('dossier_libelle', 'D', _('Dossier'));
                    
                    // 1ere ligne
                    $form->setBloc('dossier_libelle', 'D', '', 'col_12');
                        // 1ere colonne
                        $form->setBloc('dossier_libelle', 'D', '', 'col_5');
                        $form->setBloc('etat', 'F');
                        // 2eme colonne
                        $form->setBloc('division', 'D', '', 'col_7');
                        $form->setBloc('instructeur', 'F');
                    $form->setBloc('instructeur', 'F');
                
                    // 2eme ligne
                    $form->setBloc('date_depot', 'D', '', 'col_12');
                        $form->setBloc('date_depot', 'D');
                            $form->setBloc('date_depot', 'D', '', 'col_4');
                            $form->setBloc('date_depot', 'F');

                            $form->setBloc('date_dernier_depot', 'D', '', 'col_4');
                            $form->setBloc('date_dernier_depot', 'F');

                            $form->setBloc('dossier_date_limite', 'D', '', 'col_4');
                            $form->setBloc('dossier_date_limite', 'F');

                        $form->setBloc('dossier_date_limite', 'F');
                    $form->setBloc('dossier_date_limite', 'F');

                    // 3eme ligne
                    $form->setBloc('autorite_competente', 'DF', '', 'col_12');

                    // 4eme ligne
                    $form->setBloc('petitionnaire', 'D', '', 'col_12');
                    $form->setBloc('geom', 'F');
                    
                // Fermeture fieldset 'Dossier'
                $form->setFieldset('geom', 'F', '');

                // Fieldset 'Demande d'avis'
                $form->setFieldset('date_envoi', 'D', _("Demande d'avis"));

                    // 1ere ligne
                    $form->setBloc('date_envoi', 'D', '', 'col_12');
                        $form->setBloc('date_envoi', 'D', '', 'col_4');
                        $form->setBloc('date_envoi', 'F');
                        $form->setBloc('delai', 'D', '', 'col_4');
                        $form->setBloc('delai', 'F');
                        $form->setBloc('date_limite', 'D', '', 'col_4');
                        $form->setBloc('date_limite', 'F');
                    $form->setBloc('marque', 'F');

                // Fermeture fieldset 'Demande d'avis'
                $form->setFieldset('marque', 'F', '');
                    
                // Fieldset 'Avis rendus'
                $form->setFieldset('avis_consultation', 'D', _("Avis"));
                // Fermeture fieldset 'Avis rendu'
                $form->setFieldset('fichier', 'F', '');

            // Fermeture fieldset 'Informations generales'
            $form->setFieldset('fichier', 'F', '');

            // Fieldset 'Principales caracteristiques du projet'
            $form->setFieldset('description_projet', 'D', _('Principales caracteristiques du projet'));
                $form->setBloc('description_projet', 'D', '', 'col_12');
                $form->setBloc('nombre_places_parking', 'F');
            // Fermeture fieldset 'Principales caracteristiques du projet'
            $form->setFieldset('nombre_places_parking', 'F');
        }
    }

    /**
     * Récupère la liste des contraintes d'un dossier.
     * @param string $dossier Identifiant du dossier
     * 
     * @return object          Résultat de la requête
     */
    function getListContrainte($dossier) {

        // Exécution de la requête SQL
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
                    lower(contrainte.sousgroupe) AS contrainte_sousgroupe
                FROM 
                    %1$scontrainte 
                    LEFT JOIN %1$sdossier_contrainte
                        ON dossier_contrainte.contrainte = contrainte.contrainte
                WHERE 
                    -- Filtrage sur les contraintes présentées aux services consultés
                    contrainte.service_consulte = \'t\'
                    AND dossier_contrainte.dossier = \'%2$s\'
                    %3$s
                ORDER BY 
                    contrainte_groupe DESC, 
                    contrainte_sousgroupe, 
                    contrainte.no_ordre, 
                    contrainte.libelle',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier),
                // Si le paramètre "option_contrainte_di" est définit
                ($this->f->getParameter('option_contrainte_di') != 'aucun') ?
                    $this->f->traitement_condition_contrainte($this->f->getParameter('option_contrainte_di')) :
                    ""
            ),
            array(
                "origin" => __METHOD__,
            )
        );

        // Retourne le résultat
        return $qres;
    }

    /**
     * Ajout de la liste des contraintes présentées aux services consultés
     */
    function formSpecificContent($maj) {

        $listContrainte = $this->getListContrainte($this->getVal('dossier'));

        // Si le dossier possède des contraintes
        if ($listContrainte['row_count'] != 0) {

            // Affiche du fieldset
            printf("<div id=\"liste_contrainte\" class=\"demande_hidden_bloc\">");
            printf("<fieldset class=\"cadre ui-corner-all ui-widget-content col_12 startClosed\">");
            printf("  <legend class=\"ui-corner-all ui-widget-content ui-state-active\"
                    id =\"fieldset_contraintes_liees\">"
                    ._('Caracteristiques principales du reglement en vigueur')."</legend>");
            printf("<div class=\"fieldsetContent\" style=\"display: none;\">");

            // Entête pour le groupe
            $groupeHeader = "
            <div class='dossier_contrainte_groupe'>
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
                    <th class='title col-0 firstcol contrainte_th_texte_complete'>
                        <span class='name'>
                            "._('texte_complete')."
                        </span>
                    </th>
                    <th class='title col-1 contrainte_th_reference'>
                        <span class='name'>
                            "._('reference')."
                        </span>
                    </th>
                    <th class='title col-2 contrainte_th_nature'>
                        <span class='name'>
                            "._('nature')."
                        </span>
                    </th>
                </tr>
            </thead>
            ";

            // Ligne de données
            $line = "
            <tr class='tab-data %s'>
                <td class='col-0 firstcol contrainte_th_texte_complete'>
                    %s
                </td>
                <td class='col-1 contrainte_th_reference'>
                    %s
                </td>
                <td class='col-2 contrainte_th_nature'>
                    %s
                </td>
            ";

            // Sauvegarde des données pour les comparer
            $lastRow = array();
            $lastRow['contrainte_groupe'] = 'empty';
            $lastRow['contrainte_sousgroupe'] = 'empty';

            // Tant qu'il y a des résultats
            foreach ($listContrainte['result'] as $row) {
                // Si l'identifiant du groupe de la contrainte présente et 
                // celle d'avant est différent
                if ($row['contrainte_groupe'] != $lastRow['contrainte_groupe']) {

                    // Si l'identifiant du groupe d'avant est vide
                    if ($lastRow['contrainte_groupe'] != 'empty') {
                        // Ferme le tableau
                        printf("</table>");
                        // Ferme le div
                        printf("</div>");
                        // Ferme le div
                        printf("</div>");
                    }

                    // Affiche le header du groupe
                    printf($groupeHeader, $row['contrainte_groupe']);
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
                            // Ferme le div
                            printf("</div>");
                        }
                    }

                    // Affiche le header du sous-groupe
                    printf($sousgroupeHeader, $row['contrainte_sousgroupe']);

                    // Ouvre le tableau
                    printf("<table id='sousgroupe_".$row['contrainte_sousgroupe']."' class='tab-tab dossier_contrainte_view'>");

                    // Affiche le header des données
                    printf($tableHeader);

                    // Définis le style des lignes
                    $style = 'odd';
                }

                // Si toujours dans la même groupe et même sous-groupe, 
                // on change le style de la ligne
                if ($row['contrainte_groupe'] == $lastRow['contrainte_groupe']
                    && $row['contrainte_sousgroupe'] == $lastRow['contrainte_sousgroupe']) {
                    // Définis le style
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

                // Affiche les données
                printf($line, $style, 
                    $row['dossier_contrainte_texte'], 
                    $contrainte_reference,
                    $row['contrainte_nature']
                );

                // Sauvegarde les données
                $lastRow['contrainte_groupe'] = $row['contrainte_groupe'];
                $lastRow['contrainte_sousgroupe'] = $row['contrainte_sousgroupe'];
                
            }
            // Ferme le tableau
            printf("</table>");
            // Ferme le sous-groupe
            printf("</div>");
            // Ferme le groupe
            printf("</div>");

            printf("</div>");

            printf("<div class=\"visualClear\"></div>");            
            // Ferme le fieldset content
            printf("</div>");
            printf("</fieldset>");
        }
    }

}


