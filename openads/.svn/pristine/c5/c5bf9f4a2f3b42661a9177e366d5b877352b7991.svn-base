<?php
/**
 * DBFORM - 'taxe_amenagement' - Surcharge gen.
 *
 * Ce script permet de définir la classe 'taxe_amenagement'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../gen/obj/taxe_amenagement.class.php";

class taxe_amenagement extends taxe_amenagement_gen {

    /**
     * Instance de la classe om_collectivite.
     *
     * @var mixed
     */
    var $inst_om_collectivite = null;

    /**
     * Liste des champs nécessaires au calcul de l'imposition.
     *
     * @var array
     */
    var $list_fields_simulation = array(
            "tax_surf_tot_cstr",
            "tax_empl_ten_carav_mobil_nb_cr",
            "tax_empl_hll_nb_cr",
            "tax_sup_bass_pisc_cr",
            "tax_eol_haut_nb_cr",
            "tax_pann_volt_sup_cr",
            "tax_am_statio_ext_cr",
            "tax_su_princ_surf4",
            "tax_su_princ_surf3",
            "tax_su_heber_surf3",
            "tax_su_princ_surf1",
            "tax_su_princ_surf2",
            "tax_su_non_habit_surf2",
            "tax_su_non_habit_surf3",
            "tax_su_non_habit_surf4",
            "tax_su_parc_statio_expl_comm_surf",
            "mtn_exo_ta_part_commu",
            "mtn_exo_ta_part_depart",
            "mtn_exo_ta_part_reg",
            "tax_surf_loc_arch",
            "tax_surf_pisc_arch",
            "tax_am_statio_ext_arch",
            "mtn_exo_rap"
        );

    /**
     * Liste des champs nécessaires au calcul nominal de la TA et de la RAP.
     *
     * @var array
     */
    var $list_fields_simulation_cn_ta_rap = array(
            "tax_surf_tot_cstr",
            "tax_empl_ten_carav_mobil_nb_cr",
            "tax_empl_hll_nb_cr",
            "tax_sup_bass_pisc_cr",
            "tax_eol_haut_nb_cr",
            "tax_pann_volt_sup_cr",
            "tax_am_statio_ext_cr"
        );

    /**
     * Liste des champs de terrassement obligatoires pour le calcul de la RAP.
     *
     * @var array
     */
    var $list_fields_simulation_terr_rap = array(
            "tax_terrassement_arch",
        );

    /**
     * Permet de définir l’attribut “onchange” sur chaque champ.
     * 
     * @param object  $form Formumaire
     * @param integer $maj  Mode d'insertion
     */
    function setOnchange(&$form, $maj) {
        parent::setOnchange($form, $maj);
        $form->setOnchange('tx_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_1', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_2', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_3', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_4', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_5', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_6', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_7', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_8', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_9', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_10', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_11', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_12', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_13', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_14', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_15', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_16', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_17', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_18', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_19', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_comm_secteur_20', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_1_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_2_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_3_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_4_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_5_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_6_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_7_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_8_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_9_reg', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_1_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_2_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_3_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_4_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_5_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_6_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_7_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_8_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_9_depart', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_1_comm', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_2_comm', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_3_comm', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_4_comm', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_5_comm', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_6_comm', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_7_comm', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_8_comm', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_exo_facul_9_comm', 'VerifFloat(this, 2)');
        $form->setOnchange('tx_rap', 'VerifFloat(this, 2)');
    }


    /**
     * Définit s'il y a un seul secteur.
     *
     * @return boolean
     */
    function has_one_secteur() {
        // Il ne peut y avoir que 20 secteur maximum
        for ($i=2; $i < 21; $i++) {
            //
            $secteur = $this->getVal('tx_comm_secteur_'.$i);
            // Si un des secteurs de 2 à 20 n'est pas vide
            if (!empty($secteur)) {
                //
                return false;
            }
        }

        //
        return true;
    }


    /**
     * Formule de calcul de la taxe d'aménagement (TA).
     *
     * @param string $secteur Secteur communal.
     * @param array  $dt      Valeurs des données techniques.
     *
     * @return mixed Tableau des résultats ou NULL.
     */
    public function compute_ta($secteur, array $dt) {

        // Vérifie que les champs nécessaires au calcul nominal soient
        // renseignés
        $can_compute = false;
        //
        $list_fields_required = $this->get_list_fields_simulation("cn_ta_rap");
        foreach ($list_fields_required as $field) {
            // Au moins un des champs nécessaires doit être renseigné
            if ($dt[$field] !== '' && $dt[$field] !== null) {
                //
                $can_compute = true;
            }
        }
        //
        if ($can_compute === false) {
            //
            return null;
        }

        // Récupère la liste des valeurs forfaitaires et des taux depuis le
        // paramétrage des taxes :
        // Valeurs forfaitaires
        $vf = array();
        $vf['val_forf_surf_cstr'] = floatval($this->getVal('val_forf_surf_cstr'));
        $vf['val_forf_empl_tente_carav_rml'] = floatval($this->getVal('val_forf_empl_tente_carav_rml'));
        $vf['val_forf_empl_hll'] = floatval($this->getVal('val_forf_empl_hll'));
        $vf['val_forf_surf_piscine'] = floatval($this->getVal('val_forf_surf_piscine'));
        $vf['val_forf_nb_eolienne'] = floatval($this->getVal('val_forf_nb_eolienne'));
        $vf['val_forf_surf_pann_photo'] = floatval($this->getVal('val_forf_surf_pann_photo'));
        $vf['val_forf_nb_parking_ext'] = floatval($this->getVal('val_forf_nb_parking_ext'));
        // Taux
        $tx = array();
        $tx['commu'] = (floatval($this->getVal('tx_comm_secteur_'.$secteur)) / 100);
        $tx['depart'] = (floatval($this->getVal('tx_depart')) / 100);
        $tx['reg'] = (floatval($this->getVal('tx_reg')) / 100);

        // Calcul nominal
        $calc_tot = (floatval($dt['tax_surf_tot_cstr']) * $vf['val_forf_surf_cstr']) + (floatval($dt['tax_empl_ten_carav_mobil_nb_cr']) * $vf['val_forf_empl_tente_carav_rml']) + (floatval($dt['tax_empl_hll_nb_cr']) * $vf['val_forf_empl_hll']) + (floatval($dt['tax_sup_bass_pisc_cr']) * $vf['val_forf_surf_piscine']) + (floatval($dt['tax_eol_haut_nb_cr']) * $vf['val_forf_nb_eolienne']) + (floatval($dt['tax_pann_volt_sup_cr']) * $vf['val_forf_surf_pann_photo']) + (floatval($dt['tax_am_statio_ext_cr']) * $vf['val_forf_nb_parking_ext']);

        // Abattements
        $abat_1 = (floatval($dt['tax_su_princ_surf4']) + floatval($dt['tax_su_princ_surf3']) + floatval($dt['tax_su_heber_surf3'])) * ($vf['val_forf_surf_cstr'] / 2);
        //
        $abat_2 = 0;
        // Si l'abattement 1 ne s'applique pas, alors l'abattement 2 peut être
        // appliqué
        if ($abat_1 == 0) {
            //
            $surf_princ = floatval($dt['tax_su_princ_surf1']) + floatval($dt['tax_su_princ_surf2']);
            // S'applique seulement sur les 100 premiers m²
            if ($surf_princ > 100) {
                //
                $surf_princ = 100;
            }
            //
            $abat_2 = $surf_princ * ($vf['val_forf_surf_cstr'] / 2);
        }
        //
        $abat_3 = floatval($dt['tax_su_non_habit_surf2']) * ($vf['val_forf_surf_cstr'] / 2);
        //
        $abat_4 = floatval($dt['tax_su_non_habit_surf3']) * ($vf['val_forf_surf_cstr'] / 2);
        //
        $abat_5 = floatval($dt['tax_su_non_habit_surf4']) * ($vf['val_forf_surf_cstr'] / 2);
        //
        $abat_6 = floatval($dt['tax_su_parc_statio_expl_comm_surf']) * ($vf['val_forf_surf_cstr'] / 2);
        //
        $abat_tot = $abat_1 + $abat_2 + $abat_3 + $abat_4 + $abat_5 + $abat_6;

        // Initialisation du tableau des résultats
        $result = array();

        // Pour chaque part
        foreach ($tx as $key => $taux) {
            // Résultats avec et sans soustraction de l'exonération
            $result[$key] = (($calc_tot - $abat_tot) * $taux) - floatval($dt['mtn_exo_ta_part_'.$key]);
            $result[$key.'_ss_exo'] = ($calc_tot - $abat_tot) * $taux;
        }

        //
        return $result;
    }


    /**
     * Formule de calcul de la redevance d'archéologie préventive (RAP).
     *
     * @param array $dt Valeurs des données techniques.
     *
     * @return mixed Tableau des résultats ou NULL.
     */
    public function compute_rap(array $dt) {

        // Vérifie que la RAP peut être calculée
        $can_compute = false;
        // Les champs concernant le terrassement doivent obligatoirement être
        // renseignés
        $list_fields_required = $this->get_list_fields_simulation("terr_rap");
        foreach ($list_fields_required as $field) {
            // Au moins un des champs nécessaires doit être renseigné
            if ($dt[$field] !== '' && $dt[$field] !== null) {
                //
                $can_compute = true;
            }
        }
        //
        if ($can_compute === false) {
            //
            return null;
        }
        // Les champs composant le calcul nominal doicent également être
        // renseignés
        $list_fields_required = $this->get_list_fields_simulation("cn_ta_rap");
        $can_compute = false;
        foreach ($list_fields_required as $field) {
            // Au moins un des champs nécessaires doit être renseigné
            if ($dt[$field] !== '' && $dt[$field] !== null) {
                //
                $can_compute = true;
            }
        }
        //
        if ($can_compute === false) {
            //
            return null;
        }

        // Récupère la liste des valeurs forfaitaires et du taux depuis le
        // paramétrage des taxes :
        // Valeurs forfaitaires
        $vf = array();
        $vf['val_forf_surf_cstr'] = $this->getVal('val_forf_surf_cstr');
        $vf['val_forf_empl_tente_carav_rml'] = $this->getVal('val_forf_empl_tente_carav_rml');
        $vf['val_forf_empl_hll'] = $this->getVal('val_forf_empl_hll');
        $vf['val_forf_surf_piscine'] = $this->getVal('val_forf_surf_piscine');
        $vf['val_forf_nb_eolienne'] = $this->getVal('val_forf_nb_eolienne');
        $vf['val_forf_surf_pann_photo'] = $this->getVal('val_forf_surf_pann_photo');
        $vf['val_forf_nb_parking_ext'] = $this->getVal('val_forf_nb_parking_ext');
        // Taux
        $taux = floatval($this->getVal('tx_rap')) / 100;

        // Calcul nominal, seulement pour les constructions dont la profondeur
        // du terrassement excède les 0.5 mètres
        $calc_1 = 0;
        if ($dt['tax_terrassement_arch'] === "Oui" && is_numeric($dt['tax_surf_tot_cstr']) ){

            $calc_1 = intval($dt['tax_surf_tot_cstr']) * $vf['val_forf_surf_cstr'];
        }
        //
        $calc_2 = 0;
        if ($dt['tax_terrassement_arch'] === "Oui" && is_numeric($dt['tax_empl_ten_carav_mobil_nb_cr']) ){

            $calc_2 = intval($dt['tax_empl_ten_carav_mobil_nb_cr']) * $vf['val_forf_empl_tente_carav_rml'];
        }
        //
        $calc_3 = 0;
        if ($dt['tax_terrassement_arch'] === "Oui" && is_numeric($dt['tax_empl_hll_nb_cr']) ) {

            $calc_3 = intval($dt['tax_empl_hll_nb_cr']) * $vf['val_forf_empl_hll'];
        }
        //
        $calc_4 = 0;
        if ($dt['tax_terrassement_arch'] === "Oui" && is_numeric($dt['tax_sup_bass_pisc_cr']) ) {

            $calc_4 = intval($dt['tax_sup_bass_pisc_cr']) * $vf['val_forf_surf_piscine'];
        }
        //
        $calc_5 = 0;
        if ($dt['tax_terrassement_arch'] === "Oui" && is_numeric($dt['tax_am_statio_ext_cr'])) {

            $calc_5 = intval($dt['tax_am_statio_ext_cr']) * $vf['val_forf_nb_parking_ext'];
        }
        //
        $calc_tot = $calc_1 + $calc_2 + $calc_3 + $calc_4 + $calc_5;

        // Abattements
        $abat_tot = 0;
        //
        if ($dt['tax_terrassement_arch'] === "Oui") {
            //
            $abat_1_surf_tot = intval($dt['tax_su_princ_surf4']) + intval($dt['tax_su_princ_surf3']) + intval($dt['tax_su_heber_surf3']);
            if ($abat_1_surf_tot > 100) {
                //
                $abat_1_surf_tot = 100;
            }
            $abat_1 = $abat_1_surf_tot * ($vf['val_forf_surf_cstr'] / 2);
            //
            $abat_2 = 0;
            // Si l'abattement 1 ne s'applique pas, alors l'abattement 2 peut être
            // appliqué
            if ($abat_1 == 0) {
                //
                $abat_2_surf_tot = intval($dt['tax_su_princ_surf1']) + intval($dt['tax_su_princ_surf2']);
                if ($abat_2_surf_tot > 100) {
                    //
                    $abat_2_surf_tot = 100;
                }
                $abat_2 = $abat_2_surf_tot * ($vf['val_forf_surf_cstr'] / 2);
            }
            //
            $abat_3_surf_tot = intval($dt['tax_su_non_habit_surf2']) + intval($dt['tax_su_non_habit_surf3']) + intval($dt['tax_su_non_habit_surf4']) + intval($dt['tax_su_parc_statio_expl_comm_surf']);
            if ($abat_3_surf_tot > 100) {
                //
                $abat_3_surf_tot = 100;
            }
            $abat_3 = $abat_3_surf_tot * ($vf['val_forf_surf_cstr'] / 2);
            //
            $abat_tot = $abat_1 + $abat_2 + $abat_3;
        }

        // Initialisation du tableau des résultats
        $result = array();

        // Résultats avec et sans soustraction de l'exonération
        $result['rap'] = (($calc_tot - $abat_tot) * $taux) - floatval($dt['mtn_exo_rap']);
        $result['rap_ss_exo'] = ($calc_tot - $abat_tot) * $taux;

        //
        return $result;
    }


    /**
     * Permet de modifier le fil d'Ariane.
     * 
     * @param string $ent Fil d'Ariane
     *
     * @return string
     */
    function getFormTitle($ent) {

        // Si différent de l'ajout
        if ($this->getParameter("maj") != 0) {

            $ent .= " -> ".$this->get_om_collectivite_libelle();
        }

        // Change le fil d'Ariane
        return $ent;
    }

    /**
     * Récupère le libellé de la collectivité.
     *
     * @return string
     */
    function get_om_collectivite_libelle() {
        // Instance de om_collectivite
        $om_collectivite = $this->get_inst_om_collectivite();

        // Récupère la valeur du champ libelle
        $libelle = $om_collectivite->getVal('libelle');

        //
        return $libelle;
    }

    /**
     * Récupère l'instance de la collectivité.
     *
     * @param mixed $om_collectivite Identifiant de la om_collectivite
     *
     * @return object
     */
    function get_inst_om_collectivite($om_collectivite = null) {
        //
        if (is_null($this->inst_om_collectivite)) {
            //
            if (is_null($om_collectivite)) {
                $om_collectivite = $this->getVal('om_collectivite');
            }
            //
            $this->inst_om_collectivite = $this->f->get_inst__om_dbform(array(
                "obj" => "om_collectivite",
                "idx" => $om_collectivite,
            ));
        }
        //
        return $this->inst_om_collectivite;
    }


    /**
     * Récupère la liste des champs nécessaires au calcul de l'imposition.
     *
     * @param string $precision Permet de préciser la partie du calcul.
     *
     * @return [type] [description]
     */
    public function get_list_fields_simulation($precision = 'all') {

        // Retourne tous les champs nécesaires pour le calcul des taxes
        if ($precision === 'all') {
            //
            return $this->list_fields_simulation;
        }

        // Retourne tous les champs nécesaires au calcul nominal de la TA
        if ($precision === 'cn_ta_rap') {
            //
            return $this->list_fields_simulation_cn_ta_rap;
        }

        // Retourne tous les champs de terrassement obligatoires pour le calcul
        // de la RAP
        if ($precision === 'terr_rap') {
            //
            return $this->list_fields_simulation_terr_rap;
        }

        //
        return array();
    }


}


