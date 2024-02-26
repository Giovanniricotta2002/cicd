<?php
/**
 * DBFORM - 'demandeur' - Surcharge gen.
 *
 * Ce script définit la classe 'demandeur'.
 *
 * @package openads
 * @version SVN : $Id: demandeur.class.php 5056 2015-08-19 10:25:20Z nhaye $
 */

require_once ("../gen/obj/demandeur.class.php");

class demandeur extends demandeur_gen {

    var $required_tag = array("particulier_nom",
                                "personne_morale_denomination",
                                "personne_morale_raison_sociale"
                            );

    function init_class_actions() {
        parent::init_class_actions();

        //
        //
        $this->class_actions[998] = array(
            "identifier" => "json_data",
            "view" => "view_json_data",
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
            'demandeur',
            'type_demandeur',
            'qualite',
            'om_collectivite',
            'particulier_civilite', 'particulier_nom', 'particulier_prenom',
            'particulier_date_naissance', 'particulier_commune_naissance', 
            'particulier_departement_naissance', 'particulier_pays_naissance',
            'personne_morale_denomination', 
            'personne_morale_raison_sociale', 'personne_morale_siret',
            'personne_morale_categorie_juridique',
            'personne_morale_civilite', 'personne_morale_nom', 'personne_morale_prenom',
            'numero',
            'voie',
            'complement',
            'lieu_dit',
            'localite',
            'code_postal',
            'bp',
            'cedex',
            'pays',
            'division_territoriale',
            'telephone_fixe',
            'telephone_mobile',
            'indicatif',
            'fax',
            'courriel',
            'notification',
            'frequent',
            'num_inscription',
            'nom_cabinet',
            'conseil_regional',
            'titre_obt_diplo_spec',
            'date_obt_diplo_spec',
            'lieu_obt_diplo_spec',
        );
    }

    /**
     * Mise en page.
     *
     * @param formulaire $form Instance de la classe om_formulaire.
     * @param integer    $maj  Identifiant de l'action.
     */
    function setLayout(&$form, $maj){

        // Gestion recherche pétitionnaire fréquent
        $search_fields = '';
        if ($maj == 0 || $maj == 1) {
            if ($form->val['type_demandeur'] === 'petitionnaire' ||
                $form->val['type_demandeur'] === 'avocat' ||
                $form->val['type_demandeur'] === 'bailleur') {
                $search_fields = ' search_fields';
            }
        }
        // Container du formulaire
        $form->setBloc('qualite', 'D', '', 'formulaire-demandeur');
        
            // Container des fieldset Qualité et Collectivité
            $form->setBloc('qualite', 'D', '', 'formulaire-demandeur--qualite-collectivite');
                // Qualité
                $form->setFieldset('qualite','DF',_("Qualité"));
                // Collectivité
                // Renomme "collectivité" en "service" si l'option est activée
                $om_collectivite_libelle = __("Collectivité");
                if ($this->f->is_option_renommer_collectivite_enabled() === true) {
                    $om_collectivite_libelle = __("service");
                }
                $form->setFieldset('om_collectivite','DF', $om_collectivite_libelle, $search_fields);
            $form->setBloc('om_collectivite', 'F');
            // Fin - Container des fieldset Qualité et Collectivité    


            // Début - Etat civil Particulier
            $form->setFieldset('particulier_civilite','D',_("Etat civil"), "group particulier_fields");
                // Nom - prénom
                $form->setBloc('particulier_nom','D', "","group particulier--nom-prenom".$search_fields);
                $form->setBloc('particulier_prenom', 'F');
                // Date + Commune de naissance
                $form->setBloc('particulier_date_naissance','D',_("Date et Lieu de Naissance"),"group particulier--naissance");
                $form->setBloc('particulier_commune_naissance', 'F');
                // Dpt + Pays de naissance
                $form->setBloc('particulier_departement_naissance','D', '',"group particulier--naissance-dpt-pays");
                $form->setBloc('particulier_pays_naissance', 'F');
            $form->setFieldset('particulier_pays_naissance','F');
            // Fin - Etat civil Particulier


            // Début - État civil Personne morale 
        $form->setFieldset('personne_morale_denomination','D',("Personne morale"),"personne_morale_fields");
            // Denomination - Raison Sociale    
            $form->setBloc('personne_morale_denomination','D',"", "group personne_morale--denom-rs");
            $form->setBloc('personne_morale_raison_sociale', 'F');
            // SIRET - Cat. juridique
            $form->setBloc('personne_morale_siret','D',"","group personne_morale--siret-cj");
            $form->setBloc('personne_morale_categorie_juridique','F');
            // Civilité
            $form->setBloc('personne_morale_civilite', 'DF', "");
            // Nom - Prénom 
            $form->setBloc('personne_morale_nom', 'D', "", "group personne_morale--nom-prenom".$search_fields);
            $form->setBloc('personne_morale_prenom', 'F');
        $form->setFieldset('personne_morale_prenom', 'F');
        // Fin - État Civil - Personne morale 
        
        // Adresse
        $form->setFieldset('numero', 'D', _("Adresse"), "formulaire-demandeur--adresse");
        
            $form->setBloc('numero', 'D', "", "group adresse--num-voie");
            $form->setBloc('voie', 'F');
            
            $form->setBloc('complement', 'DF', "");
            
            $form->setBloc('lieu_dit', 'D', "", "group");
            $form->setBloc('localite', 'F');
            
            $form->setBloc('code_postal', 'D', "", "group");
            $form->setBloc('cedex', 'F');
            
            $form->setBloc('pays', 'D', "", "", "group");
            $form->setBloc('division_territoriale', 'F');
        $form->setFieldset('division_territoriale', 'F');

        // Coordonnées
        $form->setFieldset('telephone_fixe', 'D', _("Coordonnees"), "");
            // Fixe + mobile + Indicatif
            $form->setBloc('telephone_fixe', 'D', _("Téléphone"), "group");
            $form->setBloc('indicatif', 'F');
            // Fax
            $form->setBloc('fax', 'DF', "", "group");

            $form->setBloc('courriel', 'DF', '', "group");
            $form->setBloc('notification', 'DF');

        $form->setFieldset('notification', 'F');

        // Architecte
        $form->setFieldset('num_inscription', 'D', __("Architecte législation connexe"), "");
            $form->setBloc('num_inscription', 'D', "", "group");
            $form->setBloc('num_inscription', 'F');
            $form->setBloc('nom_cabinet', 'D', "", "group");
            $form->setBloc('nom_cabinet', 'F');
            $form->setBloc('conseil_regional', 'D', "", "group");
            $form->setBloc('conseil_regional', 'F');
            $form->setBloc('titre_obt_diplo_spec', 'D', __("Obtention du diplôme de spécialisation et d’approfondissement en architecture mention architecture et patrimoine ou équivalent"), "alignForm");
            $form->setBloc('lieu_obt_diplo_spec', 'F');
        $form->setFieldset('lieu_obt_diplo_spec', 'F');
        
        //Fin container
        $form->setBloc('lieu_obt_diplo_spec', 'F');

    }

    /**
     * SETTER_FORM - setVal (setVal).
     *
     * @return void
     */
    function setVal(&$form, $maj, $validation, &$dnu1 = null, $dnu2 = null) {
        parent::setVal($form, $maj, $validation);
        //
        if ($maj == 0) {
            $form->setVal("pays", "France");
        }
    }

    /**
     * Lbellé des champs
     */
    function setLib(&$form,$maj) {
        parent::setLib($form,$maj);
        $form->setLib('qualite', '');
        $form->setLib('om_collectivite', '');
        // État civil - Particulier
        $form->setLib('particulier_date_naissance', __("Date"));
        $form->setLib('particulier_commune_naissance', __("Commune"));
        $form->setLib('particulier_departement_naissance', __("Département"));
        $form->setLib('particulier_pays_naissance', __("Pays"));

        //Coordonnées
        $form->setLib('telephone_fixe', __("Fixe"));
        $form->setLib('telephone_mobile', __("Mobile"));
        $form->setLib('notification', __("Le demandeur accepte d'être notifié à l'adresse électronique communiquée"));

        // Dans le cas d’une intervention sur un immeuble classé au titre des monuments historiques
        $form->setLib('titre_obt_diplo_spec', __("Titre"));
        $form->setLib('date_obt_diplo_spec', __("Date"));
        $form->setLib('lieu_obt_diplo_spec', __("Établissement / ville / pays"));
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
             $form->setVal("pays", "France");
        }
        // XXX L'objectif de cette portion de code n'est pas de faire un setVal
        // Message d'information concernant la modification des demandeurs
        // fréquents
        if ($maj == 1 && $this->getVal("frequent") == "t") {
            switch ($this->getVal("type_demandeur")) {
                case "petitionnaire":
                    $type_demandeur = _("Pétitionnaire");
                    break;

                case "avocat":
                    $type_demandeur = _("Avocat");
                    break;

                case "bailleur":
                    $type_demandeur = _("Bailleur");
                    break;
            }
            $message = sprintf(_("%s fréquent non modifiable"), $type_demandeur);
            $this->f->displayMessage("info", $message);
        }
    }

    /**
     * @return void
     */
    function verifier($val = array(), &$dnu1 = null, $dnu2 = null) {
        parent::verifier($val);
        // le nom du particulier est obligatoire
        if($this->valF['qualite'] == "particulier" AND $this->valF['particulier_nom'] == "") {
            $this->correct = false;
            $this->addToMessage(_("Le champ")." <span class=\"bold\">".
                                _("particulier_nom")."</span> "._("est obligatoire."));
        }

        // la dénomination ou la raison sociale est obligatoire pour une personne morale
        if($this->valF['qualite'] == "personne_morale" 
           AND $this->valF['personne_morale_denomination'] == "" 
                AND $this->valF['personne_morale_raison_sociale'] == "") {
            $this->correct = false;
            $this->addToMessage(_("Un des champs")." <span class=\"bold\">".
                                _("personne_morale_denomination")."</span> ou <span class=\"bold\">".
                                _("personne_morale_raison_sociale")."</span> "._("doit etre rempli."));
        }

        // Le numéro de SIRET doit contenir obligatoirement 14 caractères
        if ($this->valF['qualite'] == "personne_morale"
            && $this->valF['personne_morale_siret'] != null
            && strlen($this->valF['personne_morale_siret']) != 14) {
            $this->correct = false;
            $this->addToMessage(_("Le champ")." <span class=\"bold\">".__("personne_morale_siret")."</span>".__(" doit contenir 14 caractères."));
        }

    }

    /**
     * Methode setTaille
     */
    function setTaille(&$form, $maj) {
        parent::setTaille($form, $maj);
        $form->setTaille("personne_morale_siret", 14);
    }

    /**
     * Methode setMax
     */
    function setMax(&$form, $maj) {
        parent::setMax($form, $maj);
        $form->setMax("personne_morale_siret", 14);
    }

    /*
     * Select pour les champs qualite et type_demandeur
     */
    function setType(&$form,$maj) {
        parent::setType($form,$maj);

        $form->setType('num_inscription', 'hidden');
        $form->setType('nom_cabinet', 'hidden');
        $form->setType('conseil_regional', 'hidden');
        $form->setType('titre_obt_diplo_spec', 'hidden');
        $form->setType('date_obt_diplo_spec', 'hidden');
        $form->setType('lieu_obt_diplo_spec', 'hidden');

        if ($maj < 2) { //ajouter et modifier
            
            $form->setType('type_demandeur', 'select');
            $form->setType('qualite', 'select');
            if ($this->f->is_option_mode_service_consulte_enabled() === false) {
                if ($maj == 1){
                    if ($this->get_dossier_from_link() !== false && $this->get_dossier_from_link() !== null) {
                        $id_dossier = null;
                        if (empty($this->get_dossier_from_link())) {
                            if ($this->f->get_submitted_get_value('idx_dossier') != null) {
                                $id_dossier = $this->f->get_submitted_get_value('idx_dossier');
                            }
                        } else {
                            $id_dossier=$this->get_dossier_from_link()[0]['dossier'];
                        }

                        $inst_dossier = $this->f->get_inst__om_dbform(array(
                            "obj" => "dossier",
                            "idx" => $id_dossier,
                        ));
                        if ($this->f->is_type_dossier_platau($inst_dossier->getVal('dossier_autorisation')) === true
                            && $inst_dossier->getVal('etat_transmission_platau') !== 'jamais_transmissible') {
                            //
                            $required_fields_platau = $inst_dossier->get_list_platau_required_fields_dossier();
                            foreach ($required_fields_platau as $required_field_platau) {
                                $champ = explode('.', $required_field_platau)[1];
                                if (in_array($champ, $this->champs)) {
                                    $form->setType($champ ,$form->type[$champ].'_demat_color');
                                }
                            }
                        }
                    }
                }
                if ($maj == 0) {
                    $inst_dossier = $this->f->get_inst__om_dbform(array(
                        "obj" => "dossier",
                        "idx" => $this->f->get_submitted_get_value('idx_dossier'),
                    ));
                    if ($this->f->is_type_dossier_platau($inst_dossier->getVal('dossier_autorisation')) === true
                        && $inst_dossier->getVal('etat_transmission_platau') !== 'jamais_transmissible') {
                        //
                        $required_fields_platau = $inst_dossier->get_list_platau_required_fields_dossier();
                        foreach ($required_fields_platau as $required_field_platau) {
                            $champ = explode('.', $required_field_platau)[1];
                            if (in_array($champ, $this->champs)) {
                                $form->setType($champ ,$form->type[$champ].'_demat_color');
                            }
                        }
                    }
                }
            }
            if($maj == 0 AND $this->getParameter("idx_demandeur") != "") {
                $form->setType('frequent','hidden');
                $form->setType('qualite','selectdisabled');
                $form->setType('particulier_nom','textdisabled');
                $form->setType('particulier_prenom','textdisabled');
                $form->setType('particulier_date_naissance','datedisabled');
                $form->setType('particulier_commune_naissance','textdisabled');
                $form->setType('particulier_departement_naissance','textdisabled');
                $form->setType('particulier_pays_naissance','textdisabled');
                $form->setType('personne_morale_denomination','textdisabled');
                $form->setType('personne_morale_raison_sociale','textdisabled');
                $form->setType('personne_morale_siret','textdisabled');
                $form->setType('personne_morale_categorie_juridique','textdisabled');
                $form->setType('personne_morale_nom','textdisabled');
                $form->setType('personne_morale_prenom','textdisabled');
                $form->setType('particulier_civilite','selectdisabled');
                $form->setType('personne_morale_civilite','selectdisabled');
                $form->setType('telephone_fixe','textdisabled');
                $form->setType('telephone_mobile','textdisabled');
                $form->setType('fax','textdisabled');
                $form->setType('indicatif','textdisabled');
                $form->setType('courriel','textdisabled');

            }
        }

        $form->setType('demandeur', 'hidden');

    }

    /**
     * SETTER_FORM - setSelect.
     *
     * @return void
     */
    function setSelect(&$form, $maj, &$dnu1 = null, $dnu2 = null) {
        parent::setSelect($form, $maj);

        // Type du demandeur
        $contenu=array();

        $contenu[0][0]="";
        $contenu[1][0]=_('choisir')." "._('type_demandeur');
        $contenu[0][2]="petitionnaire";
        $contenu[1][2]=_('petitionnaire');
        $contenu[0][1]="delegataire";
        $contenu[1][1]=_('autre correspondant');
        $contenu[0][3]="plaignant";
        $contenu[1][3]=_('Plaignant');
        $contenu[0][4]="contrevenant";
        $contenu[1][4]=_('Contrevenant');
        $contenu[0][5]="requerant";
        $contenu[1][5]=_('Requérant');
        $contenu[0][6]="avocat";
        $contenu[1][6]=_('Avocat');
        $contenu[0][7]="bailleur";
        $contenu[1][7]=_('Bailleur');
        $contenu[0][8] = "proprietaire";
        $contenu[1][8] = __('Propriétaire');
        $contenu[0][9] = "architecte_lc";
        $contenu[1][9] = __('Architecte législation connexe');
        $contenu[0][10] = "paysagiste";
        $contenu[1][10] = __('Concepteur-Paysagiste');
        
        $form->setSelect("type_demandeur", $contenu);
        
        // Qualité du demandeur
        $contenu=array();

        $contenu[0][0]="particulier";
        $contenu[1][0]=_('particulier');
        $contenu[0][1]="personne_morale";
        $contenu[1][1]=_('personne morale');
        
        $form->setSelect("qualite", $contenu);
    }
    
    /*
     * Ajoute l'action javascript sur le select de la qualité
     */
    function setOnchange(&$form,$maj){
        parent::setOnchange($form,$maj);
        
        $form->setOnchange("qualite","changeDemandeurType('qualite');");
    }

    /**
     * Ajout d'un champs caché permettant de linker l'id du demandeur
     * recement ajouté
     **/
    function sousFormSpecificContent($maj) {
        $id_demandeur = $this->getVal("demandeur");
        if(isset($this->valF["demandeur"]) AND !empty($this->valF["demandeur"])) {
            echo "<input id=\"id_retour\" name=\"idRetour\" type=\"hidden\" value=\"".
                    $this->valF["demandeur"]."\" />";
        } elseif (isset($id_demandeur) AND !empty($id_demandeur) AND $maj == 110) {
            echo "<input id=\"id_retour\" name=\"idRetour\" type=\"hidden\" value=\"".
                    $this->getVal("demandeur")."\" />";
        }
    }
    /**
     * Surcharge du lien de retour permettant de linker l'id du demandeur
     * recement ajouté
     **/
    function retoursousformulaire($idxformulaire = NULL, $retourformulaire = NULL, $val = NULL,
                                  $objsf = NULL, $premiersf = NULL, $tricolsf = NULL, $validation = NULL,
                                  $idx = NULL, $maj = NULL, $retour = NULL) {
        if($retourformulaire === "demande") {
            echo "\n<a class=\"retour\" ";
            echo "href=\"#\">";
            //
            echo _("Retour");
            //
            echo "</a>\n";
        } else {
            parent::retoursousformulaire($idxformulaire, $retourformulaire, $val,
                                  $objsf, $premiersf, $tricolsf, $validation,
                                  $idx, $maj, $retour);
        }
    }

    /**
     * Ajout du paramètre principal
     */
    function getDataSubmitSousForm() {
        /*Création du lien de validation du sous-formulaire*/
        $datasubmit = "";
        $datasubmit .= OM_ROUTE_SOUSFORM;
        $datasubmit .= "&obj=".$this->get_absolute_class_name();
        $datasubmit .= "&amp;validation=".$this->getParameter("validation");
        if ($this->getParameter("idx") != "]") {
            //
            if ($this->getParameter("maj") == 1) { // modifier
                $datasubmit .= "&amp;action=1";
                $datasubmit .= "&amp;idx=".$this->getParameter("idx");
            } else { // supprimer
                $datasubmit .= "&amp;action=2";
                $datasubmit .= "&amp;idx=".$this->getParameter("idx");
            }
        }
        $datasubmit .= "&amp;premiersf=".$this->getParameter("premiersf");
        $datasubmit .= "&amp;retourformulaire=".$this->getParameter("retourformulaire");
        $datasubmit .= "&amp;trisf=".$this->getParameter("tricolsf");
        $datasubmit .= "&amp;idxformulaire=".$this->getParameter("idxformulaire");
        $datasubmit .= "&amp;principal=".$this->getParameter("principal");
        //
        return $datasubmit;
    }

    /**
     * Synthèse des demandeurs pour le formulaire de la demande.
     *
     * @param string  $type     Type de demandeur.
     * @param boolean $linkable Affiche le lien d'édition.
     */
    function afficherSynthese($type, $linkable) {
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
                $legend = _("Contrevenant");
                break;
                
            case 'plaignant_principal':
                $legend = _("Plaignant principal");
                break;
            
            case 'plaignant':
                $legend = _("Plaignant");
                break;
                
            case 'requerant_principal':
                $legend = _("Requérant principal");
                break;
            
            case 'requerant':
                $legend = _("Requérant");
                break;
            
            case 'avocat_principal':
                $legend = _("Avocat principal");
                break;
            
            case 'avocat':
                $legend = _("Avocat");
                break;

            case 'bailleur_principal':
                $legend = _("Bailleur principal");
                break;
            
            case 'bailleur':
                $legend = _("Bailleur");
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
        
        // Initialisation de tous les éléments à afficher
        foreach ($this->champs as $champs) {
            ${$champs} = $this->val[array_search($champs, $this->champs)] != "" ?
                $this->val[array_search($champs, $this->champs)] :
                '';
            if ($champs == 'notification') {
                $notification = $this->val[array_search($champs, $this->champs)] == "t" ?
                    '(Accepte les couriels)' :
                    '';
            }
        }

        // Templates utilisés pour réaliser l'affichage
        $templateConteneurDemandeur =
            '<div class="%1$s col_6" id="%1$s_%2$s">
                <div class="legend_synthese_demandeur">
                    %3$s
                </div>
                <div class="synthese_demandeur">';

        $templateLienDemandeur =
            '<a href="#" onclick="removeDemandeur(\'%1$s_%2$s\'); return false;">
                <span class="demandeur_del om-icon om-icon-16 om-icon-fix delete-16" title="%3$s">
                    %3$s
                </span>
            </a>';

        $templateLienModifDemandeur =
            '<a class="edit_demandeur" href="#" onclick="editDemandeur(\'%1$s\',%2$s,\'%3$s\',%3$s_%2$s); return false;">';

        // Conteneur du demandeur
        printf(
            $templateConteneurDemandeur,
            $type,
            $demandeur,
            $legend
        );
        // Si le paramètre linkable est défini à true on ajoute les balises
        // de lien
        if ($linkable === true) {
            printf(
                $templateLienDemandeur,
                $type,
                $demandeur,
                _("Supprimer le demandeur")
            );
        }
        $input_name = $type.'[]';

        // Valeur de formulaire à retourner
        printf(
            "<input type=\"hidden\" class=\"demandeur_id\" name=\"%s\" value=\"%s\" />\n",
            $input_name,
            $this->val[array_search('demandeur', $this->champs)]
        );

        // Lien de modification du demandeur
        if ($linkable === true) {
            printf(
                $templateLienModifDemandeur,
                $type_demandeur,
                $demandeur,
                $type
            );
        }
        
        // Préparation des infos du demandeur qui seront affichées en les stockant dans un tableau
        // Chaque élement du tableau correspond a une ligne dans l'affichage
        $infosAffichage = array();
        if ($qualite == 'particulier') {
            $infosAffichage['particulier'] = $particulier_nom." ".$particulier_prenom;
            // S'il existe une civilité elle est ajoutée devant le nom du particulier
            if ( ! empty($particulier_civilite)) {
                $inst_civilite = $this->f->get_inst__om_dbform(array(
                    "obj" => "civilite",
                    "idx" => $particulier_civilite,
                ));
                $infosAffichage['particulier'] = $inst_civilite->getVal("libelle")." ".$particulier_nom." ".$particulier_prenom;
            }
        } else {
            $infosAffichage['personne_morale'] = $personne_morale_raison_sociale." ".$personne_morale_denomination;
            $infosAffichage['personne_morale_jur'] = $personne_morale_siret." ".$personne_morale_categorie_juridique;
            $infosAffichage['personne_morale_nom'] = $personne_morale_nom." ".$personne_morale_prenom;
            // S'il existe une civilité elle est ajoutée devant le nom de la personne morale
            if (! empty($personne_morale_civilite)) {
                $inst_civilite = $this->f->get_inst__om_dbform(array(
                    "obj" => "civilite",
                    "idx" => $personne_morale_civilite,
                ));
                $infosAffichage['personne_morale_nom'] = $inst_civilite->getVal("libelle")." ".$personne_morale_nom." ".$personne_morale_prenom;
            }
        }
        $infosAffichage['adresse_1'] = $numero." ".$voie." ".$complement;
        $infosAffichage['adresse_2'] = $lieu_dit;
        $infosAffichage['adresse_3'] = $code_postal." ".$localite." ".$bp." ".$cedex;
        $infosAffichage['adresse_4'] = $division_territoriale." ".$pays;
        $infosAffichage['telephones'] = $telephone_fixe." ".$telephone_mobile;
        $infosAffichage['courriel'] = $courriel." ".$notification;

        // Affichage de la date et du lieu de naissance sous la forme :
        //  - s'il existe une date et un lieu de naissance : né le XX/XX/XX à XXXX
        //  - s'il existe une date de naissance : né le XX/XX/XX
        //  - s'il existe juste un lieu de naissance : né à XXXX
        // Converti la date du format YYYY-MM-DD au format DD/MM/YYYY
        $particulier_date_naissance = $this->dateDBToForm($particulier_date_naissance);
        if ($qualite == 'particulier') {
            $lieuNaissance = trim($particulier_commune_naissance.' '.$particulier_departement_naissance.' '.$particulier_pays_naissance);
            if ($particulier_date_naissance != '' && $lieuNaissance != '') {
                $infosAffichage['naissance'] = sprintf(
                    'Né le %s à %s',
                    $particulier_date_naissance,
                    $lieuNaissance
                );
            } elseif ($particulier_date_naissance != '') {
                $infosAffichage['naissance'] = sprintf(
                    'Né le %s',
                    $particulier_date_naissance
                );
            } elseif ($lieuNaissance != '') {
                $infosAffichage['naissance'] = sprintf(
                    'Né à %s',
                    $lieuNaissance
                );
            }
        }

        // Permet de n'avoir de retour à la ligne que si des informations ont été affichées
        foreach ($infosAffichage as $info) {
            $info = trim($info);
            if ($info != '') {
                printf(
                    '%s<br/>',
                    $info
                );
            }
        }

        if ($linkable === true) {
            echo "</a>\n";
        }
        echo "</div>\n";
        echo "</div>\n";
    }

    /**
     *
     */
    function get_inst_civilite($civilite) {
        return $this->get_inst_common("civilite", $civilite);
    }

    /**
     * Retourne un tableau avec les données principales du demandeur.
     *
     * L'objectif est de mettre à disposition via un WS Reste un ensemble
     * de données exploitable par une autre application.
     */
    function get_datas() {

        /**
         *
         */
        $particulier_civilite = "";
        $personne_morale_civilite = "";
        if ($this->getVal('qualite') == 'particulier'
            && $this->getVal('particulier_civilite') !== '') {
            //
            $inst_civilite = $this->get_inst_civilite($this->getVal('particulier_civilite'));
            $particulier_civilite = $inst_civilite->getVal("libelle");
        } elseif ($this->getVal('qualite') == 'personne_morale'
            && $this->getVal('personne_morale_civilite') !== '') {
            //
            $inst_civilite = $this->get_inst_civilite($this->getVal('personne_morale_civilite'));
            $personne_morale_civilite = $inst_civilite->getVal("libelle");
        }

        /**
         *
         */
        //
        $datas = array(
            "demandeur" => $this->getVal($this->clePrimaire),
            "qualite" => $this->getVal("qualite"),
        );

        if ($this->getVal('qualite') == 'particulier') {
            $datas["particulier_civilite"] = $particulier_civilite;
            $datas["particulier_nom"] = $this->getVal("particulier_nom");
            $datas["particulier_prenom"] = $this->getVal("particulier_prenom");
            $datas["particulier_date_naissance"] = $this->getVal("particulier_date_naissance");
            $datas["particulier_commune_naissance"] = $this->getVal("particulier_commune_naissance");
            $datas["particulier_departement_naissance"] = $this->getVal("particulier_departement_naissance");
            $datas["particulier_pays_naissance"] = $this->getVal("particulier_pays_naissance");
        }
        if ($this->getVal('qualite') == 'personne_morale') {
            $datas["personne_morale_civilite"] = $personne_morale_civilite;
            $datas["personne_morale_denomination"] = $this->getVal("personne_morale_denomination");
            $datas["personne_morale_raison_sociale"] = $this->getVal("personne_morale_raison_sociale");
            $datas["personne_morale_siret"] = $this->getVal("personne_morale_siret");
            $datas["personne_morale_categorie_juridique"] = $this->getVal("personne_morale_categorie_juridique");
            $datas["personne_morale_nom"] = $this->getVal("personne_morale_nom");
            $datas["personne_morale_prenom"] = $this->getVal("personne_morale_prenom");
        }
        //
        $datas["numero"] = $this->getVal("numero");
        $datas["voie"] = $this->getVal("voie");
        $datas["complement"] = $this->getVal("complement");
        $datas["lieu_dit"] = $this->getVal("lieu_dit");
        $datas["localite"] = $this->getVal("localite");
        $datas["code_postal"] = $this->getVal("code_postal");
        $datas["bp"] = $this->getVal("bp");
        $datas["cedex"] = $this->getVal("cedex");
        $datas["pays"] = $this->getVal("pays");
        $datas["division_territoriale"] = $this->getVal("division_territoriale");
        $datas["telephone_fixe"] = $this->getVal("telephone_fixe");
        $datas["telephone_mobile"] = $this->getVal("telephone_mobile");
        $datas["indicatif"] = $this->getVal("indicatif");
        $datas["courriel"] = $this->getVal("courriel");
        $datas["fax"] = $this->getVal("fax");

        /**
         *
         */
        return $datas;
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
        if ($this->getParameter("retourformulaire") === 'demande') {
            //
            return false;
        }

        //
        return true;
    }

    public function get_dossier_from_link() {
        $query = sprintf('
            SELECT lien_dossier_demandeur.dossier
            FROM %1$slien_dossier_demandeur
            WHERE lien_dossier_demandeur.demandeur = \'%2$s\'
            ',
            DB_PREFIXE,
            $this->getVal($this->clePrimaire)
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
        return $res['result'];
    }

    public function triggermodifierapres($id, &$dnu1 = null, $val = array(), $dnu2 = null) {
        parent::triggermodifierapres($id, $dnu1, $val, $dnu2);
        if (count(array_diff_assoc($this->valF, array_combine($this->champs, $this->val))) > 0) {
            /**
             * Gestion des tâches pour la dématérialisation
             */
            $dossiers = $this->get_dossier_from_link();
            foreach ($dossiers as $dossier) {
                //
                $inst_dossier = $this->f->get_inst__om_dbform(array(
                    "obj" => "dossier",
                    "idx" => $dossier['dossier'],
                ));

                if ($this->f->is_option_mode_service_consulte_enabled() === false
                    && $this->f->is_type_dossier_platau($inst_dossier->getVal('dossier_autorisation')) === true
                    && $inst_dossier->getVal('etat_transmission_platau') !== 'jamais_transmissible') {

                    $trigger_platau_required_fields = $inst_dossier->trigger_platau_required_fields($dossier['dossier']);
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

                if ($this->f->is_type_dossier_platau($inst_dossier->getVal('dossier_autorisation'))
                    && $inst_dossier->getVal('etat_transmission_platau') !== 'jamais_transmissible'
                    && ($this->f->is_option_mode_service_consulte_enabled() !== true
                        || ($this->f->is_option_mode_service_consulte_enabled() === true
                        && ($inst_dossier->get_source_depot_from_demande() === PLATAU
                            || $inst_dossier->get_source_depot_from_demande() === PORTAL)))) {
                    //
                    $inst_task = $this->f->get_inst__om_dbform(array(
                        "obj" => "task",
                        "idx" => 0,
                    ));
                    $task_val = array(
                        'type' => 'modification_DI',
                        'object_id' => $dossier['dossier'],
                        'dossier' => $dossier['dossier'],
                    );
                    // Change l'état de la tâche de notification en fonction de l'état de
                    // transmission du dossier d'instruction
                    if ($this->f->is_option_mode_service_consulte_enabled() === false
                        && ($this->getVal('etat_transmission_platau') == 'non_transmissible' 
                        || $this->getVal('etat_transmission_platau') == 'transmis_mais_non_transmissible')) {
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
                    // XXX Les données du DA sont mises à jour seulement lors de l'ajout ou modification
                    // d'une instruction du DI initial et lors de la décision sur le DI non initial.
                    // Sachant ce comportement, voir si cette tâche modification_DA est bien située.
                    // $inst_task = $this->f->get_inst__om_dbform(array(
                    //     "obj" => "task",
                    //     "idx" => 0,
                    // ));
                    // $task_val = array(
                    //     'type' => 'modification_DA',
                    //     'object_id' => $inst_dossier->getVal('dossier_autorisation'),
                    //     'dossier' => $inst_dossier->getVal('dossier_autorisation'),
                    // );
                    // // Change l'état de la tâche de notification en fonction de l'état de
                    // // transmission du dossier d'instruction
                    // if ($this->f->is_option_mode_service_consulte_enabled() === false
                    //     && ($this->getVal('etat_transmission_platau') == 'non_transmissible' 
                    //     || $this->getVal('etat_transmission_platau') == 'transmis_mais_non_transmissible')) {
                    //     //
                    //     $task_val['state'] = $inst_task::STATUS_DRAFT;
                    // }
                    // $add_task = $inst_task->add_task(array('val' => $task_val));
                    // if ($add_task === false) {
                    //     $this->addToMessage(sprintf('%s %s',
                    //         __("Une erreur s'est produite lors de la création tâche."),
                    //         __("Veuillez contacter votre administrateur.")
                    //     ));
                    //     $this->correct = false;
                    //     return false;
                    // }
                }
            }
        }
        //
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
        return $val;
    }

}// fin classe

