<?php
/**
 * Ce script contient la définition de la classe 'RESTCommon'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../tests/resources/omtestcase.class.php";

/**
 * Cette classe permet de faire des tests sur les requêtes REST
 *
 * Données utilisées :
 *
 * Fichiers dans binary_files/test_digitalizedDocument/Transfert_GED
 *
 * Les consultations 1 et 2
 *
 * Le dossier d'autorisation PC0130551200001
 *
 * Le dossier d'instruction PC0130551200001P0
 */
abstract class RESTCommon extends OMTestCase {

    var $base_url = '';
    var $f;
    
    /**
     * Méthode lancée en début de traitement
     */
    public function common_setUp() {
        parent::common_setUp();
        //
        $this->base_url = 'http://localhost/openads/';
    }

    /**
     * Méthode lancée en fin de traitement
     */
    public function common_tearDown() {
        parent::common_tearDown();

        //
        $this->clean_session();
    }

    /**
     * Initialisation pour session cURL
     * @param  string $url        Lien
     * @param  string $request    Mode de requête
     * @param  array $postfields  Données à envoyer
     * @return mixed              Session cURL
     */
    private function init_cURL($url, $request, $postfields) {

        // Initialisation session cURL
        $curl = curl_init();
        // Url de la page à récupérer
        curl_setopt($curl, CURLOPT_URL, $url);
        // Permet de récupérer le résultat au lieu de l'afficher
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // Démarrer un nouveau cookie de session
        curl_setopt($curl, CURLOPT_COOKIESESSION, true);
        // Requête REST à envoyer (par défaut à GET)
        switch ($request) {
            case 'POST':
                curl_setopt($curl, CURLOPT_POST, true);
                break;
            case 'PUT':
                curl_setopt($curl, CURLOPT_PUT, true);
                break;
        }
        
        // Si il y a des paramètres à envoyer
        if ($postfields != '') {

            // Informations à envoyer
            $postfields = $this->preparePostFields($curl, $postfields, $request);
        }

        // Retour de la session cURL
        $return = curl_exec($curl);
        // Ferme la session cURL
        curl_close($curl);

        // Message retourné par REST
        $message = $this->getReturnMessage($return, $request);

        // Retourne le message
        return $message;
    }

    /**
     * Prépare les paramètres à envoyer en cURL
     * @param  mixed  $curl     Session cURL
     * @param  array  $array    Tableau des paramètres
     * @param  string $request  Méthode utilisée (POST/PUT)
     */
    private function preparePostFields($curl, $array, $request) {
        
        // Si c'est une requête POST
        if ($request == 'POST') {
            
            // Génère une chaîne de requête en encodage URL
            $return = http_build_query($array);

            // Données passées en POST
            curl_setopt($curl, CURLOPT_POSTFIELDS, $return);

        // Sinon c'est une requête PUT
        } else {

            // Encode le tableau en json
            $return =  json_encode($array);

            // Crée un fichier temporaire
            $putData = tmpfile();
            // Ecrit la chaîne dans le fichier temporaire
            fwrite($putData, $return);
            // Place le curseur au début du fichier
            fseek($putData, 0);
            // Permet de retourner des données binaires
            curl_setopt($curl, CURLOPT_BINARYTRANSFER, true);
            // Le fichier lu par le transfert lors du chargement
            curl_setopt($curl, CURLOPT_INFILE, $putData);
            // Taille du fichier en octet attendue
            curl_setopt($curl, CURLOPT_INFILESIZE, strlen($return));

        }
        
    }

    /**
     * Retourne seulement le message du retour REST
     * @param  string $return Retour du REST
     * @return string         Message du retour
     */
    private function getReturnMessage($return, $request) {

        // Si c'est une requête GET
        if ($request == 'GET') {

            // Retraite la chaîne
            $return = substr($return,1,-1);
            $return = trim($return);
            $return = preg_replace("(\r\n|\n|\r)",'',$return);

            // On retourne directement le return
            return $return;
        }

        // Decode du json et crée un objet
        $return = json_decode($return);
        if ($return === null) {
            return "error";
        }
        // Retourne le message du retour REST
        return $return->message;
        
    }


    function enable_sig_externe($f) {
        // Activation du paramètre d'activation du sig
        $f->db->autoExecute(
            DB_PREFIXE."om_parametre",
            array('valeur' => 'sig_externe'),
            DB_AUTOQUERY_UPDATE,
            "libelle = 'option_sig' AND om_collectivite IN (1, 2)"
        );
    }

    function disable_sig_externe($f) {
        // Désactivation du paramètre d'activation du sig
        $f->db->autoExecute(
            DB_PREFIXE."om_parametre",
            array('valeur' => 'aucun'),
            DB_AUTOQUERY_UPDATE,
            "libelle = 'option_sig' AND om_collectivite IN (1, 2)"
        );
    }

    /**
     * Test le module consultation de maintenance
     */
    public function testMaintenanceConsultation() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->enable_sig_externe($f);
        // Lien à envoyer
        $url = $this->base_url.'services/rest_entry.php/maintenance';
        // Mode de la requête
        $request = 'POST';
        // Données à envoyer
        $postfields = array(
            'module' => 'consultation',
            'data' => 'NA',
        );

        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);
        
        // On vérifie le retour de la session cURL
        $this->assertEquals($message, '2 consultations mise(s) à jour.');

        //Deuxième jet pour autre message
        
        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);

        // On vérifie le retour de la session cURL
        $this->assertEquals($message, 'Aucune mise a jour.');
        $this->disable_sig_externe($f);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Test le module instruction de maintenance
     */
    public function testMaintenanceInstruction() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->enable_sig_externe($f);
        // Lien à envoyer
        $url = $this->base_url.'services/rest_entry.php/maintenance';
        // Mode de la requête
        $request = 'POST';
        // Données à envoyer
        $postfields = array(
            'module' => 'instruction',
            'data' => 'NA',
        );

        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);
        
        // On vérifie le retour de la session cURL
        $this->assertEquals($message, '1 dossier(s) mis à jour.');
        $this->disable_sig_externe($f);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }


    /**
     * Test le module d'import sans l'option de numérisation activée.
     *
     * @return void
     */
    public function test_maintenance_import_without_option_activated() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->enable_sig_externe($f);
        // Lien à envoyer
        $url = $this->base_url.'services/rest_entry.php/maintenance';
        // Mode de la requête
        $request = 'POST';
        // Données à  envoyer
        $postfields = array(
            'module' => 'import',
            'data' => array(
                'Todo' => '../var/digitalization/Todo',
                'Done' => '../var/digitalization/Done'
            ),
        );

        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);

        // On vérifie le retour de la session cURL
        $this->assertEquals($message, 'L\'option de numérisation des dossiers n\'est pas activée');
        $this->disable_sig_externe($f);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }


    /**
     * Test le module de purge sans l'option de numérisation activée.
     *
     * @return void
     */
    public function test_maintenance_purge_without_option_activated() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->enable_sig_externe($f);
        // Lien à envoyer
        $url = $this->base_url.'services/rest_entry.php/maintenance';
        // Mode de la requête
        $request = 'POST';
        // Données à envoyer
        $postfields = array(
            'module' => 'purge',
            'data' => array(
                'dossier' => '../var/digitalization/Done',
                'nombre_de_jour' => "20"
            ),
        );

        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);

        // On vérifie le retour de la session cURL
        $this->assertEquals($message, 'L\'option de numérisation des dossiers n\'est pas activée');
        $this->disable_sig_externe($f);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }


    /**
     * Active l'option de numérisation.
     *
     * @return void
     */
    public function test_activate_option_digitalization_folder() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->enable_sig_externe($f);
        // Ajoute les options nécessaires à la numérisation
        $config = file_get_contents('../dyn/config.inc.php');
        $pattern = '\?>';
        $replace = '$config["digitalization_folder_path"] = "../var/digitalization/";$config["option_digitalization_folder"] = true;?>';
        $output = preg_replace("/".$pattern."/", $replace, $config);
        $new_config = file_put_contents('../dyn/config.inc.php', $output);

        //
        $this->assertNotEquals(false, $new_config);
        $this->disable_sig_externe($f);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }


    /**
     * Test de non régression concernant une sur consomation de mémoire lors de 
     * l'import des documents numérisés.
     *
     * XXX Si ce test sort avec erreur : Trying to get property of non-object
     * c'est la consomation de mémoire qui explose
     */
    public function test_tnr_run_import_out_of_memory() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->enable_sig_externe($f);
        // Nom de dossier
        $pathSrc = "../var/digitalization/Todo/PA0130551200001";
        //Nom dossier destination
        $pathDes = "../var/digitalization/Done/PA0130551200001";
        exec("(dd if=/dev/zero of=binary_files/20101106AUTPCP.pdf bs=15485760 count=1) > /dev/null 2>&1");
        mkdir($pathSrc);
        chmod($pathSrc, 0777);

        mkdir($pathDes);
        chmod($pathDes, 0777);

        // Récupération du document
        for ($i=0; $i < 100; $i++) { 
            copy(
                'binary_files/20101106AUTPCP.pdf',
                $pathSrc.'/20101106AUTPCP-'.$i.'.pdf'
            );
        }
        
        // Lien à envoyer
        $url = $this->base_url.'services/rest_entry.php/maintenance';
        // Mode de la requête
        $request = 'POST';
        // Données à  envoyer
        $postfields = array(
            'module' => 'import',
            'data' => array(
                'Todo' => '../var/digitalization/Todo',
                'Done' => '../var/digitalization/Done'
            ),
        );

        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);
        
        // On vérifie le retour de la session cURL
        $this->assertEquals($message, 'Tous les documents ont été traités');

        //Deuxième jet pour autre message
        
        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);
        
        // On vérifie le retour de la session cURL
        $this->assertEquals($message, 'Aucun document à traiter');
        // Suppression des fichiers importés
        for ($i=0; $i < 100; $i++) { 
            // Suppression des documents créé
            unlink($pathDes.'/20101106AUTPCP-'.$i.'.pdf');
        }
        // Suppression du dossier PC0130551200005.P0
        rmdir($pathSrc);
        rmdir($pathDes);
        // Supprime le fichier de test de mémoire
        unlink("binary_files/20101106AUTPCP.pdf");
        $this->disable_sig_externe($f);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }


    /**
     * Test le module import de maintenance
     */
    public function testMaintenanceImport() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->enable_sig_externe($f);
        // Création du dossier PC0130551200001.P0 dans le dossier de 
        // numérisation
        mkdir('../var/digitalization/Todo/PC0130551200001.P0/');
        chmod('../var/digitalization/Todo/PC0130551200001.P0/', 0777);
        // Récupération du document
        copy('binary_files/20091106AUTPCP.pdf', '../var/digitalization/Todo/PC0130551200001.P0/20091106AUTPCP.pdf');

        // Lien à envoyer
        $url = $this->base_url.'services/rest_entry.php/maintenance';
        // Mode de la requête
        $request = 'POST';
        // Données à  envoyer
        $postfields = array(
            'module' => 'import',
            'data' => array(
                'Todo' => '../var/digitalization/Todo',
                'Done' => '../var/digitalization/Done'
            ),
        );

        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);
        
        // On vérifie le retour de la session cURL
        $this->assertEquals($message, 'Tous les documents ont été traités');

        //Deuxième jet pour autre message
        
        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);
        
        // On vérifie le retour de la session cURL
        $this->assertEquals($message, 'Aucun document à traiter');
        $this->disable_sig_externe($f);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Test le module purge de maintenance
     */
    public function testMaintenancePurge() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->enable_sig_externe($f);
        mkdir('../var/digitalization/Done/PC0130551200002.P0');
        touch('../var/digitalization/Done/PC0130551200002.P0/test.pdf');
        touch('../var/digitalization/Done/PC0130551200001.P0/20091106AUTPCP.pdf',strtotime('-1 month'));

        // Lien à envoyer
        $url = $this->base_url.'services/rest_entry.php/maintenance';
        // Mode de la requête
        $request = 'POST';
        // Données à envoyer
        $postfields = array(
            'module' => 'purge',
            'data' => array(
                'dossier' => '../var/digitalization/Done',
                'nombre_de_jour' => "20"
            ),
        );

        // Initialisation cURL
        $message = $this->init_cURL($url, $request, $postfields);
        
        // On vérifie le retour de la session cURL
        $this->assertEquals($message, '1 fichier(s) purgé(s) sur 2 dossier(s) traité(s)');

        // Supprime les dossiers créent pour les tests testMaintenanceImport()
        // et testMaintenancePurge()
        unlink ('../var/digitalization/Done/PC0130551200002.P0/test.pdf');
        rmdir('../var/digitalization/Todo/PC0130551200001.P0');
        rmdir('../var/digitalization/Done/PC0130551200002.P0');
        $this->disable_sig_externe($f);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }


    /**
     * Désactive l'option de numérisation.
     *
     * @return void
     */
    public function test_desactivate_option_digitalization_folder() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $this->enable_sig_externe($f);
        // Supprime les options nécessaires à la numérisation
        $config = file_get_contents('../dyn/config.inc.php');
        $search = '$config["digitalization_folder_path"] = "../var/digitalization/";$config["option_digitalization_folder"] = true;?>';
        $replace = "?>";
        $output = str_replace($search, $replace, $config);
        $new_config = file_put_contents('../dyn/config.inc.php', $output);

        //
        $this->assertNotEquals(false, $new_config);
        $this->disable_sig_externe($f);
        // Destruction de la classe *om_application*
        $f->__destruct();
    }
}
