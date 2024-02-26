<?php
/**
 * Ce script contient la définition de la classe 'GeneralCommon'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../tests/resources/omtestcase.class.php";

/**
 * Cette classe permet de tester unitairement les fonctions de l'application.
 */
abstract class GeneralCommon extends OMTestCase {

    /**
     * Méthode lancée en fin de traitement
     */
    public function common_tearDown() {
        parent::common_tearDown();
        //
        $this->clean_session();
    }

    /**
     * Test la fonction mois_date() de la classe Utils.
     */
    public function test_01_utils_mois_date() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application();
        $f->disableLog();
        // Avec des mois

        // Pour les additions
        // Initialisation des tableaux
        $tab_date_dep = array();
        $tab_delay = array();
        $tab_date_fin = array();
        
        // Tableau des date de départ
        $tab_date_dep = array(
            0 => "2013-12-31",
            1 => "2014-01-31",
            2 => "2014-01-01",
            3 => "2014-01-31",
            4 => "2015-12-31",
            5 => "",
            6 => "",
            7 => "",
            8 => "2015-12-31",
            9 => "2015-12-31",
            10 => "openADS",
            11 => "openADS",
            12 => "openADS",
        );
        // Tableau des delais
        $tab_delay = array(
            0 => "2",
            1 => "5",
            2 => "12",
            3 => "27",
            4 => "2",
            5 => "2",
            6 => "openads",
            7 => "",
            8 => "openADS",
            9 => "",
            10 => "2",
            11 => "openads",
            12 => "",
        );
        // Tableau des date résultat
        $tab_date_fin = array(
            0 => "2014-02-28",
            1 => "2014-06-30",
            2 => "2015-01-01",
            3 => "2016-04-30",
            4 => "2016-02-29",
            5 => null,
            6 => null,
            7 => null,
            8 => "2015-12-31",
            9 => "2015-12-31",
            10 => null,
            11 => null,
            12 => null,
        );

        // Pour chaque date
        foreach ($tab_date_dep as $key => $date_dep) {
            // Calcul la date résultat
            $date_fin = $f->mois_date($date_dep, $tab_delay[$key], "+");
            // Vérifie que la date résultat est correct
            $this->assertEquals($date_fin, $tab_date_fin[$key]);
        }

        // Pour les soustractions
        // Initialisation des tableaux
        $tab_date_dep = array();
        $tab_delay = array();
        $tab_date_fin = array();

        // Tableau des date de départ
        $tab_date_dep = array(
            0 => "2014-01-31",
        );
        // Tableau des delais
        $tab_delay = array(
            0 => "4",
        );
        // Tableau des date résultat
        $tab_date_fin = array(
            0 => "2013-09-30",
        );

        // Pour chaque date
        foreach ($tab_date_dep as $key => $date_dep) {
            // Calcul la date résultat
            $date_fin = $f->mois_date($date_dep, $tab_delay[$key], "-");
            // Vérifie que la date résultat est correct
            $this->assertEquals($date_fin, $tab_date_fin[$key]);
        }

        // Avec des jours

        // Pour les additions
        // Initialisation des tableaux
        $tab_date_dep = array();
        $tab_delay = array();
        $tab_date_fin = array();
        
        // Tableau des date de départ
        $tab_date_dep = array(
            0 => "2013-12-31",
            1 => "2014-01-31",
            2 => "2014-01-01",
            3 => "2014-01-31",
            4 => "2015-12-31",
            5 => "",
            6 => "",
            7 => "",
            8 => "2015-12-31",
            9 => "2015-12-31",
            10 => "openADS",
            11 => "openADS",
            12 => "openADS",
        );
        // Tableau des delais
        $tab_delay = array(
            0 => "2",
            1 => "5",
            2 => "12",
            3 => "27",
            4 => "2",
            5 => "2",
            6 => "openads",
            7 => "",
            8 => "openADS",
            9 => "",
            10 => "2",
            11 => "openads",
            12 => "",
        );
        // Tableau des dates résultats
        $tab_date_fin = array(
            0 => "2014-01-02",
            1 => "2014-02-05",
            2 => "2014-01-13",
            3 => "2014-02-27",
            4 => "2016-01-02",
            5 => null,
            6 => null,
            7 => null,
            8 => "2015-12-31",
            9 => "2015-12-31",
            10 => null,
            11 => null,
            12 => null,
        );

        // Pour chaque date
        foreach ($tab_date_dep as $key => $date_dep) {
            // Calcul la date résultat
            $date_fin = $f->mois_date($date_dep, $tab_delay[$key], "+", "jour");
            // Vérifie que la date résultat est correct
            $this->assertEquals($date_fin, $tab_date_fin[$key]);
        }

        // Pour les soustractions
        // Initialisation des tableaux
        $tab_date_dep = array();
        $tab_delay = array();
        $tab_date_fin = array();

        // Tableau des date de départ
        $tab_date_dep = array(
            0 => "2014-01-31",
        );
        // Tableau des delais
        $tab_delay = array(
            0 => "4",
        );
        // Tableau des date résultat
        $tab_date_fin = array(
            0 => "2014-01-27",
        );

        // Pour chaque date
        foreach ($tab_date_dep as $key => $date_dep) {
            // Calcul la date résultat
            $date_fin = $f->mois_date($date_dep, $tab_delay[$key], "-", "jour");
            // Vérifie que la date résultat est correct
            $this->assertEquals($date_fin, $tab_date_fin[$key]);
        }
        // Destruction de la classe *om_application*
        $f->__destruct();
    }


    /**
     * Vérification de la méthode permettant de selectionner le logo de la bonne
     * collectivité.
     */
    function test_02_TNR_selection_du_logo_dans_les_editions() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application();
        $f->disableLog();
        //
        $edition = $f->get_inst__om_edition();
        // Vérification du logo de collectivité mono dans le cas où :
        // - un logo multi actif est défini
        // - un logo actif pour la collectivité est défini
        $logo = $edition->get_logo_from_collectivite("logopdf.png", 2);
        // XXX le double // dans le path est nécessaire
        $logo_valid = array(
            "file" => "../var/filestorage//88/8815/88154c6f68d3a0e1928c84fc0187993d",
            "w" => 43.349333333333334,
            "h" => 43.349333333333334,
            "type" => "png",
        );
        // Le logo commune doit être retourné par la méthode
        $this->assertEquals($logo, $logo_valid);

        // Désactivation du logo de la commune
        $val_logo["actif"] = 'f';
        $f->db->autoExecute(DB_PREFIXE."om_logo", $val_logo, DB_AUTOQUERY_UPDATE, "om_logo=2");

        // Vérification du logo de collectivité mono dans le cas où :
        // - un logo multi actif est défini
        // - un logo la collectivité est inactif
        $logo = $edition->get_logo_from_collectivite("logopdf.png", 1);
        // XXX le double // dans le path est nécessaire
        $logo_valid = array(
            "file" => "../var/filestorage//d2/d20a/d20a5c36d3b83464bab63035a7f61901",
            "w" => 43.349333333333334,
            "h" => 43.349333333333334,
            "type" => "png",
        );
        // Le logo de la collectivité multi doit être retourné
        $this->assertEquals($logo, $logo_valid);

        // Désactivation du logo de la commune
        $val_logo["actif"] = 'f';
        $f->db->autoExecute(DB_PREFIXE."om_logo", $val_logo, DB_AUTOQUERY_UPDATE, "om_logo=6");

        // Vérification du logo de collectivité mono dans le cas où aucun logo
        // n'est activé
        $logo = $edition->get_logo_from_collectivite("logopdf.png", 1);
        $logo_valid = null;
        // Un valeur null doit être retournée
        $this->assertEquals($logo, $logo_valid);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Vérification de la méthode permettant de formater le corps du courriel
     * notifié.
     */
    function test_03_instruction_formater_modele() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("adminfonct", "adminfonct");
        $f->disableLog();
        // template du modèle
        $template = 'DI : <DOSSIER_INSTRUCTION><br/>
LIEN : <URL_INSTRUCTION><br/>
INSTRUCTION : <ID_INSTRUCTION><br/>
LIEN DOSSIER : [URL_DOSSIER]<br/>
LIEN TELECHARGEMENT DOCUMENT : [LIEN_TELECHARGEMENT_DOCUMENT]<br/>
LIEN TELECHARGEMENT ANNEXE : [LIEN_TELECHARGEMENT_ANNEXE]<br/>';
        // résultat attendu
        $di = 'PC0130551200001P0';
        $inst = 7;
        $urlInstr = 'http://localhost/openads/app/index.php?module=form&direct_link=true&obj=dossier_instruction&action=3'.
            '&direct_field=dossier&direct_form=instruction&direct_action=3&direct_idx='.
            $inst;
        $link = '<a href="'.$urlInstr.'">'.$urlInstr.'</a>';
        $urlDossier = 'http://localhost/openads/app/index.php?module=form&obj=dossier_instruction&action=3&idx='.
            $di.
            '&retour=tab';
        $expected = sprintf(
            'DI : %1$s<br/>
LIEN : %2$s<br/>
INSTRUCTION : %3$s<br/>
LIEN DOSSIER : %4$s<br/>
LIEN TELECHARGEMENT DOCUMENT : lien_telechargement_document<br/>
LIEN TELECHARGEMENT ANNEXE : lien_telechargement_annexe<br/>',
            $di,
            $link,
            $inst,
            $urlDossier
        );
        // Instance de la classe instruction
        $instrNotif = $f->get_inst__om_dbform(array(
            "obj" => "instruction_notification",
            "idx" => "]",
        ));
        // Tableau de valeur servant à formater le modèle
        $val = array(
            'instruction_notification' => array(
                'instruction' => $inst,
                'lien_telechargement_document' => 'lien_telechargement_document',
                'annexes' => array(
                    array(
                        'lien' => 'lien_telechargement_annexe'
                    )
                )
            ),
            'dossier' => array('dossier' => $di)
        );
        // Traitement
        $result = $instrNotif->get_message_notification($template, 'notification_commune', $val);
        // Vérification du traitement
        $this->assertEquals($expected, $result, "Les modèles sont différents.");
        // Destruction de la classe *om_application*
        $f->__destruct();
    }


    /**
     * TNR du bug de champs de fusion [*_correspondant] dans la om_requete n°7 "dossier".
     * Le test vérifie qu'une seule ligne est retournée par la requête et qu'elle contient
     *  bien le nom du pétitionnaire principal
     */
    function test_05_TNR_om_requete_dossier() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->assertTrue($f->authenticated, "Erreur d'authentification.");
        $f->disableLog();
        //
        $om_requete = $f->get_inst__om_dbform(array(
            "obj" => "om_requete",
            "idx" => 7,
        ));

        // récupération de la requête SQL
        $sql = $om_requete->getVal('requete');
        // remplacement des &idx par la valeur du dossier
        $sql = str_replace('&idx', "AT0130551300001P0", $sql);
        // définition du schéma
        $sql = str_replace('&DB_PREFIXE', DB_PREFIXE, $sql);
        // exécution de la requête
        $qres = $f->get_all_results_from_db_query($sql, array(
            'origin' => __METHOD__,
            'force_return' => true
        ));
        $this->assertEquals($qres['code'], 'OK', "Erreur de base de données");
        if ($qres['code'] !== 'OK') {
            // Destruction de la classe *om_application*
            $f->__destruct();
            return;
        }
        $count = $qres['row_count'];
        // La om_requete doit retourner une seule ligne
        $this->assertEquals(1, $count);
        // récupération du résultat de la om_requete
        $values = array_shift($qres['result']);
        // La valeur de la colonne nom_correspondant doit être le nom du pétitionnaire
        // principal
        $this->assertEquals("Dupont Jean", $values['nom_correspondant']);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * TNR de la methode factorisé de création de dossier_message 
     */
    function test_06_TNR_dossier_message() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("adminfonct", "adminfonct");
        $this->assertTrue($f->authenticated, "Erreur d'authentification.");
        $f->disableLog();
        // Instanciation de la classe *dossier_message*
        $dossier_message_factory = $f->get_inst__om_dbform(array(
            "obj" => "dossier_message",
            "idx" => 0,
        ));
        $dossier_message_val = array();

        $dossier_message_val['contenu'] = 'Test Success';
        $dossier_message_val['dossier'] = 'AT0130551200001P0';
        $dossier_message_val['type'] = _('Ajout de pièce(s)');
        $dossier_message_val['emetteur'] = 'instr';
        $dossier_message_val['login'] = 'instr';
        $dossier_message_val['date_emission'] = date('Y-m-d H:i:s');
        $add = $dossier_message_factory->add_notification_message($dossier_message_val);
        $this->assertEquals(true, $add);
        $this->assertEquals(true, isset($dossier_message_factory->valF[$dossier_message_factory->clePrimaire]));
        $dossier_message = $f->get_inst__om_dbform(array(
            "obj" => "dossier_message",
            "idx" => $dossier_message_factory->valF[$dossier_message_factory->clePrimaire],
        ));
        $this->assertEquals($dossier_message_val['dossier'], $dossier_message->getVal('dossier'));
        $this->assertEquals('t', $dossier_message->getVal('lu'));
        
        $dossier_message_val['contenu'] = 'Test Duplicata';
        $add = $dossier_message_factory->add_notification_message($dossier_message_val);
        $this->assertEquals(true, $add);
                
        $dossier_message_val['contenu'] = 'Test nouveau type même dossier';
        $dossier_message_val['type'] = _('Autorisation contestée');
        $add = $dossier_message_factory->add_notification_message($dossier_message_val);
        $this->assertEquals(true, $add);
        
        $dossier_message_val['contenu'] = 'Test message non lu';
        $dossier_message_val['dossier'] = 'AZ0130551200001P0';
        $dossier_message_val['emetteur'] = $f->get_connected_user_login_name();
        $dossier_message_val['login'] = $_SESSION['login'];
        $add = $dossier_message_factory->add_notification_message($dossier_message_val);
        $this->assertEquals(true, $add);
        $dossier_message = $f->get_inst__om_dbform(array(
            "obj" => "dossier_message",
            "idx" => $dossier_message_factory->valF[$dossier_message_factory->clePrimaire],
        ));
        $this->assertEquals('f', $dossier_message->getVal('lu'));
        // Destruction de la classe *om_application*
        $f->__destruct();
    }


    /**
    * TNR du suivi de notification
    *
    * Teste 3 cas :
    * 1- Vérifie, pour une instruction, qu'il n'y a que les tableaux de suivi de notification
    *    ayant des notifications associées qui sont affichés
    * 2- L'ajout d'une tâche ayant le même object_id qu'une notification, sans tâche associée,
    *    ne dois pas empêcher l'affichage du suivi de cette notification.
    * 3- L'ajout d'une tâche ayant le même object_id qu'une notification, sans tâche associée,
    *    ne dois pas empêcher la suppression de l'instruction notifiée
    */
    function test_07_TNR_suivi_notification() {
        // Instanciation de la classe *om_application* (connexion à l'application)
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        
        // PARAMÉTRAGE
        // Modification d'un événement existant pour autoriser toutes les notifications et donc
        // pouvoir afficher tous les suivis
        $f->execute_db_query(
            sprintf(
                "UPDATE %1\$sevenement
                SET (notification_service, notification, notification_tiers) = (true, 'notification_automatique', 'notification_manuelle')
                WHERE evenement = 89",
                DB_PREFIXE
            ),
            array(
            'origin' => __METHOD__
            )
        );
        // Ajout d'une instruction, lié à l'événement modifié précedemment, sur un dossier existant.
        $instruction = $f->get_inst__om_dbform(array(
            "obj" => "instruction",
            "idx" => "]"
        ));
        $val = array_combine($instruction->champs, $instruction->val);
        $dossier = 'PC0130551200001P0';
        $val['dossier'] = $dossier;
        $val['evenement'] = '89';
        $val['date_evenement'] = date('Y-m-d');
        $res = $instruction->ajouter($val);
        $this->assertEquals($res, true);

        // Ajout d'un notification de demandeur, sans tâche associée, sur cette instruction
        $instruction_notification = $f->get_inst__om_dbform(array(
            "obj" => "instruction_notification",
            "idx" => "]",
        ));
        $val = array(
            'instruction_notification' => null,
            'instruction' => $instruction->getVal($instruction->clePrimaire),
            'automatique' => false,
            'emetteur' => 'PHP UNIT',
            'date_envoi' => date("Y-m-d"),
            'destinataire' => 'testSuivi@test.fr',
            'date_premier_acces' => null,
            'statut' => 'envoyé',
            'commentaire' => null,
            'courriel' => 'testSuivi@test.fr'
        );
        $res = $instruction_notification->ajouter($val);
        $this->assertEquals($res, true);

        // Création d'une tâche ayant un object_id de même valeur que l'id de la notification
        // mais n'étant pas lié à la notification
        $task = $f->get_inst__om_dbform(array(
            "obj" => "task",
            "idx" => 0,
        ));
        $res = $task->add_task(array('val' => array(
            'stream' => 'input',
            'json_payload' => json_encode(
                array(
                    'external_uids' => array(
                        'dossier' => 'TST_PHP_UNIT'
                    )
                )
            ),
            'type' => 'TST_SUIVI_NOTIFICATION',
            'category' => 'platau',
            'object_id' => $instruction_notification->getVal($instruction_notification->clePrimaire)
        )));
        $this->assertEquals($res, true);

        // TEST
        // 1- Vérifie qu'il n'y a que le suivi des notifications des demandeurs qui est affiché
        $this->assertTrue($instruction->can_display_notification_demandeur());
        $this->assertFalse($instruction->can_display_notification_service());
        $this->assertFalse($instruction->can_display_notification_tiers());
        $this->assertFalse($instruction->can_display_notification_commune());
        // 2- Vérifie que le suivi de notification des demandeurs contiens bien la notification sans tâche
        $this->assertStringContainsString('testSuivi@test.fr', $instruction->get_json_suivi_notification(
            array(
                'notification_recepisse',
                'notification_instruction',
                'notification_decision',
            ),
            true
        ));
        // 3- Vérifie que l'instruction peut être supprimée
        $val = array_combine($instruction->champs, $instruction->val);
        $instruction->parameters['idxformulaire'] = $dossier;
        $res = $instruction->supprimer($val);
        $this->assertNotEquals(false, $res);

        // RÉTABLISSEMENT DU PARAMÉTRAGE
        // Suppression de la tâche
        $this->assertEquals($task->supprimer(array_combine($task->champs, $task->val)), true);
        // Réinitilisation de l'évènement
        $f->execute_db_query(
            sprintf(
                "UPDATE %1\$sevenement
                SET (notification_service, notification, notification_tiers) = (false, null, null)
                WHERE evenement = 89",
                DB_PREFIXE
            ),
            array(
                'origin' => __METHOD__
            )
        );
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * TNR : taxe_amenagement::compute_ta()
     *
     * Description :
     *  - Case 1 : if the required values are null the method should return null
     *  - Case 3 : if the required values are empty the method should return null
     *  - Case 4 : if the required values are set the method should return an array even
     *             if the other values are empty
     */
    function test_08_taxe_amenagement_compute_ta() {
        // PARAMÉTRAGE

        // Instanciation de la classe *om_application* (connexion à l'application)
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();

        $val_with_null_required_fields = array(
            "tax_surf_tot_cstr" => null,
            "tax_empl_ten_carav_mobil_nb_cr" => null,
            "tax_empl_hll_nb_cr" => null,
            "tax_sup_bass_pisc_cr" => null,
            "tax_eol_haut_nb_cr" => null,
            "tax_pann_volt_sup_cr" => null,
            "tax_am_statio_ext_cr" => null
        );

        $val_with_empty_values = array(
            'tax_surf_tot_cstr' => '',
            'tax_empl_ten_carav_mobil_nb_cr' => '',
            'tax_empl_hll_nb_cr' => '',
            'tax_sup_bass_pisc_cr' => '',
            'tax_eol_haut_nb_cr' => '',
            'tax_pann_volt_sup_cr' => '',
            'tax_am_statio_ext_cr' => '',
            'tx_comm_secteur_plop' => '',
            'tx_depart' => '',
            'tx_reg' => '',
            'tax_su_princ_surf1' => '',
            'tax_su_princ_surf2' => '',
            'tax_su_non_habit_surf2' => '',
            'tax_su_heber_surf3' => '',
            'tax_su_princ_surf3' => '',
            'tax_su_non_habit_surf3' => '',
            'tax_su_heber_surf3' => '',
            'tax_su_princ_surf4' => '',
            'tax_su_non_habit_surf4' => '',
            'tax_su_parc_statio_expl_comm_surf' => '',
            'mtn_exo_ta_part_commu' => '',
            'mtn_exo_ta_part_depart' => '',
            'mtn_exo_ta_part_reg' => '',
        );

        $taxe_amenagement = $f->get_inst__om_dbform(array(
            "obj" => "taxe_amenagement",
            "idx" => "]",
        ));

        // TEST
        // Case 1
        $this->assertEquals(null, $taxe_amenagement->compute_ta('plop', $val_with_null_required_fields));
        // Case 2
        $this->assertEquals(null, $taxe_amenagement->compute_ta('plop', $val_with_empty_values));

        $val_with_empty_values['tax_surf_tot_cstr'] = 1;
        $val_with_empty_values['tax_empl_ten_carav_mobil_nb_cr'] = 1;
        $val_with_empty_values['tax_empl_hll_nb_cr'] = 1;
        $val_with_empty_values['tax_sup_bass_pisc_cr'] = 1;
        $val_with_empty_values['tax_eol_haut_nb_cr'] = 1;
        $val_with_empty_values['tax_pann_volt_sup_cr'] = 1;
        $val_with_empty_values['tax_am_statio_ext_cr'] = 1;
        // Case 3
        $this->assertTrue(is_array($taxe_amenagement->compute_ta('plop', $val_with_empty_values)));

        // RÉTABLISSEMENT DU PARAMÉTRAGE
        $f->__destruct();
    }

    /**
     * TNR : taxe_amenagement::compute_rap()
     *
     * Description :
     *  - Case 1 : if the required "terr_rap" values are null the method should return null
     *  - Case 2 : if the required "cn_ta_rap" values are null the method should return null
     *  - Case 3 : if the required values are empty the method should return null
     *  - Case 4 : if the required values are set the method should return an array even
     *             if the other values are empty
     */
    function test_09_taxe_amenagement_compute_rap() {
        // PARAMÉTRAGE

        // Instanciation de la classe *om_application* (connexion à l'application)
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();

        $val_with_null_terr_rap_required_fields = array(
            "tax_terrassement_arch" => null
        );

        $val_with_null_cn_ta_rap_required_fields = array(
            "tax_terrassement_arch" => 'Oui',
            "tax_surf_tot_cstr" => null,
            "tax_empl_ten_carav_mobil_nb_cr" => null,
            "tax_empl_hll_nb_cr" => null,
            "tax_sup_bass_pisc_cr" => null,
            "tax_eol_haut_nb_cr" => null,
            "tax_pann_volt_sup_cr" => null,
            "tax_am_statio_ext_cr" => null
        );

        $val_with_empty_values = array(
            "tax_terrassement_arch" => '',
            'tax_surf_tot_cstr' => '',
            'tax_empl_ten_carav_mobil_nb_cr' => '',
            'tax_empl_hll_nb_cr' => '',
            'tax_sup_bass_pisc_cr' => '',
            'tax_eol_haut_nb_cr' => '',
            'tax_pann_volt_sup_cr' => '',
            'tax_am_statio_ext_cr' => '',
            'tx_comm_secteur_plop' => '',
            'tx_depart' => '',
            'tx_reg' => '',
            'tax_su_princ_surf1' => '',
            'tax_su_princ_surf2' => '',
            'tax_su_non_habit_surf2' => '',
            'tax_su_heber_surf3' => '',
            'tax_su_princ_surf3' => '',
            'tax_su_non_habit_surf3' => '',
            'tax_su_heber_surf3' => '',
            'tax_su_princ_surf4' => '',
            'tax_su_non_habit_surf4' => '',
            'tax_su_parc_statio_expl_comm_surf' => '',
            'mtn_exo_rap' => '',
        );

        $taxe_amenagement = $f->get_inst__om_dbform(array(
            "obj" => "taxe_amenagement",
            "idx" => "]",
        ));
        $val = array(
            'val_forf_surf_cstr' => 1,
            'val_forf_empl_tente_carav_rml' => 1,
            'val_forf_empl_hll' => 1,
            'val_forf_surf_piscine' => 1,
            'val_forf_nb_eolienne' => 1,
            'val_forf_surf_pann_photo' => 1,
            'val_forf_nb_parking_ext' => 1
        );
        // Remplissage des valeurs obligatoirement rempli lors du paramétrage de la taxe
        foreach ($val as $key => $value) {
            $taxe_amenagement->val[array_search($key, $taxe_amenagement->champs)] = $value;
        }

        // TEST
        // Case 1
        $this->assertEquals(null, $taxe_amenagement->compute_rap($val_with_null_terr_rap_required_fields));
        // Case 2
        $this->assertEquals(null, $taxe_amenagement->compute_rap($val_with_null_cn_ta_rap_required_fields));
        // Case 3
        $this->assertEquals(null, $taxe_amenagement->compute_rap($val_with_empty_values));

        $val_with_empty_values['tax_terrassement_arch'] = 'Oui';
        $val_with_empty_values['tax_surf_tot_cstr'] = 1;
        $val_with_empty_values['tax_empl_ten_carav_mobil_nb_cr'] = 1;
        $val_with_empty_values['tax_empl_hll_nb_cr'] = 1;
        $val_with_empty_values['tax_sup_bass_pisc_cr'] = 1;
        $val_with_empty_values['tax_eol_haut_nb_cr'] = 1;
        $val_with_empty_values['tax_pann_volt_sup_cr'] = 1;
        $val_with_empty_values['tax_am_statio_ext_cr'] = 1;
        // Case 4
        $this->assertTrue(is_array($taxe_amenagement->compute_rap($val_with_empty_values)));

        // RÉTABLISSEMENT DU PARAMÉTRAGE
        $f->__destruct();
    }
}
