<?php
/**
 * Ce script contient la définition de la classe 'DigitalizedDocumentCommon'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../tests/resources/omtestcase.class.php";
require_once "../obj/digitalizedDocument.class.php";


/**
 * Cette classe permet de faire des tests unitaires sur la classe DigitalizedDocument
 * 
 * La constante DEBUG doit être définis sur DEGUG_MODE ou PRODUCTION_MODE
 * 
 * Lors de l'envoi de la commande ajouter --bootstrap bootstrap.php
 *
 * Jeu de données utilisé :
 * Le dossier d'instruction PC0130551200001P0 et PC0130551200002P0 du jeu de données de
 * base, ainsi que les dossiers sans P0 PA0130551200001 et DP0130551200001
 * les dossiers et document présent dans binary_files/test_digitalizedDocument
 */
abstract class DigitalizedDocumentCommon extends OMTestCase {

    /**
     * Fonction lancée en début de classe
     */
    public static function common_setUpBeforeClass() {

        // Création des dossiers PC0130551200001.P0 et PC0130551200002 dans le 
        // dossier de numérisation
        mkdir('../var/digitalization/Todo/PC0130551200001.P0/');
        chmod('../var/digitalization/Todo/PC0130551200001.P0/', 0777);
        mkdir('../var/digitalization/Todo/PC0130551200002.P0/');
        chmod('../var/digitalization/Todo/PC0130551200002.P0/', 0777);
        // Récupération du document
        copy('binary_files/20091106AUTPCP.pdf', '../var/digitalization/Todo/PC0130551200001.P0/20091106AUTPCP.pdf');
        copy('binary_files/20091106AUTPCP-1.pdf', '../var/digitalization/Todo/PC0130551200001.P0/20091106AUTPCP-1.pdf');
        copy('binary_files/20121212PC31_1.pdf', '../var/digitalization/Todo/PC0130551200001.P0/20121212PC31_1.pdf');
        copy('binary_files/20121212PC31_1-1.pdf', '../var/digitalization/Todo/PC0130551200001.P0/20121212PC31_1-1.pdf');
        copy('binary_files/20130207F6.pdf', '../var/digitalization/Todo/PC0130551200001.P0/20130207F6.pdf');
        // Création des dossiers sans le suffixe P0
        mkdir('../var/digitalization/Todo/PA0130551200001/');
        chmod('../var/digitalization/Todo/PA0130551200001/', 0777);
        mkdir('../var/digitalization/Todo/DP0130551200001/');
        chmod('../var/digitalization/Todo/DP0130551200001/', 0777);
        // Récupération du document
        copy('binary_files/20091106AUTPCP.pdf', '../var/digitalization/Todo/PA0130551200001/20091106AUTPCP.pdf');
        copy('binary_files/20091106AUTPCP-1.pdf', '../var/digitalization/Todo/PA0130551200001/20091106AUTPCP-1.pdf');
        copy('binary_files/20121212PC31_1.pdf', '../var/digitalization/Todo/PA0130551200001/20121212PC31_1.pdf');
        copy('binary_files/20121212PC31_1-1.pdf', '../var/digitalization/Todo/PA0130551200001/20121212PC31_1-1.pdf');
        copy('binary_files/20130207F6.pdf', '../var/digitalization/Todo/PA0130551200001/20130207F6.pdf');
    }

    /**
     * Fonction lancée en fin de classe
     */
    public static function common_tearDownAfterClass() {
        // Suppression du document 20091106AUTPCP.pdf
        unlink('../var/digitalization/Todo/PC0130551200001.P0/20091106AUTPCP.pdf');
        unlink('../var/digitalization/Todo/PC0130551200001.P0/20091106AUTPCP-1.pdf');
        unlink('../var/digitalization/Todo/PA0130551200001/20091106AUTPCP.pdf');
        unlink('../var/digitalization/Todo/PA0130551200001/20091106AUTPCP-1.pdf');
        
        // Suppression des dossiers PC0130551200001.P0 et PC0130551200002.P0
        if(file_exists('../var/digitalization/Todo/PC0130551200001.P0')) {
            rmdir('../var/digitalization/Todo/PC0130551200001.P0');
        }
        if(file_exists('../var/digitalization/Todo/PC0130551200002.P0')) {
            rmdir('../var/digitalization/Todo/PC0130551200002.P0');
        }
        // Suppression des dossiers sans P0
        if(file_exists('../var/digitalization/Todo/PA0130551200001')) {
            rmdir('../var/digitalization/Todo/PA0130551200001');
        }
        if(file_exists('../var/digitalization/Todo/DP0130551200001')) {
            rmdir('../var/digitalization/Todo/DP0130551200001');
        }
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
     * Est-ce que l'uid passé en paramètre est lié à un enregistrement *document_numerise* ?
     * 
     * @param string $uid Identifiant d'un fichier dans le système de stockage.
     * 
     * @return boolean
     */
    private function checkLinkFile($f, $uid) {
        $qres = $f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    document_numerise
                FROM
                    %1$sdocument_numerise
                WHERE
                    uid = \'%2$s\'',
                DB_PREFIXE,
                $f->db->escapeSimple($uid)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if ($qres["result"]) {
            return true;
        }
        return false;
    }

    /**
     * Retourne l'identifant du fichier dans le système de stockage lié à l'enregistrement *document_numerise* passé en paramètre.
     *
     * @param integer $document_numerise Identifiant de l'enregistrement *document_numerise*.
     *
     * @return string|null
     */
    private function get_uid_by_id($f, $document_numerise) {
        $qres = $f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    uid
                FROM
                    %1$sdocument_numerise
                WHERE
                    document_numerise=%2$d',
                DB_PREFIXE,
                intval($document_numerise)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        return $qres["result"];
    }

    /**
     * Test la fonction listFiles
     */
    public function testListFiles() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $digitalizedDocument = new DigitalizedDocument($f);
        //Nom possible de dossier
        $path = "../var/digitalization/Todo/PC0130551200001.P0";
        $path_no_p0 = "../var/digitalization/Todo/PA0130551200001";

        //Retour de la fonction listFiles
        $listFiles = $digitalizedDocument->listFiles($path);
        $listFiles_no_p0 = $digitalizedDocument->listFiles($path_no_p0);
        //On vérifie les documents retourné
        $this->assertContains("20091106AUTPCP-1.pdf", $listFiles);
        $this->assertContains("20091106AUTPCP.pdf", $listFiles);
        $this->assertContains("20121212PC31_1.pdf", $listFiles);
        $this->assertContains("20121212PC31_1-1.pdf", $listFiles);
        $this->assertContains("20130207F6.pdf", $listFiles);
        // Même chose pour les dossiers sans P0
        $this->assertContains("20091106AUTPCP-1.pdf", $listFiles_no_p0);
        $this->assertContains("20091106AUTPCP.pdf", $listFiles_no_p0);
        $this->assertContains("20121212PC31_1.pdf", $listFiles_no_p0);
        $this->assertContains("20121212PC31_1-1.pdf", $listFiles_no_p0);
        $this->assertContains("20130207F6.pdf", $listFiles_no_p0);

        //Nom de dossier vide
        $path = "../var/digitalization/Todo/PC0130551200002.P0";
        $path_no_p0 = "../var/digitalization/Todo/DP0130551200001";
        //Retour de la fontion listFiles
        $listFiles = $digitalizedDocument->listFiles($path);
        $listFiles_no_p0 = $digitalizedDocument->listFiles($path_no_p0);
        //On vérifie que le tableau retourné est vide
        $this->assertEquals($listFiles, null);
        $this->assertEquals($listFiles_no_p0, null);
        $digitalizedDocument->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /*
     * Test la fonction extractMetadataFromFilename
     */
    public function testExtractMetadataFromFilename() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $digitalizedDocument = new DigitalizedDocument($f);
        //Nom possible de document
        $filename = "20091106AUTPCP.pdf";
        //Retour de la fonction extractMetadataFromFilename
        $extractMetadataFromFilename = $digitalizedDocument->extractMetadataFromFilename($filename);
        //On vérifie les données retournées
        $this->assertEquals($extractMetadataFromFilename["title"], "AUTPCP");
        $this->assertEquals($extractMetadataFromFilename["dateEvenementDocument"], "06/11/2009");
            
        //Nom possible de document avec version
        $filename = "20130420ART-1.pdf";
        //Retour de la fonction extractMetadataFromFilename
        $extractMetadataFromFilename = $digitalizedDocument->extractMetadataFromFilename($filename);
        //On vérifie les données retournées
        $this->assertEquals($extractMetadataFromFilename["title"], "ART");
        $this->assertEquals($extractMetadataFromFilename["dateEvenementDocument"], "20/04/2013");

        //Nom possible de document avec code de nomenclature externe
        $filename = "20121212PC31_1.pdf";
        //Retour de la fonction extractMetadataFromFilename
        $extractMetadataFromFilename = $digitalizedDocument->extractMetadataFromFilename($filename);
        //On vérifie les données retournées
        $this->assertEquals($extractMetadataFromFilename["title"], "PC31_1");
        $this->assertEquals($extractMetadataFromFilename["dateEvenementDocument"], "12/12/2012");

        //Nom possible de document avec code de nomenclature externe et version
        $filename = "20121212PC31_1-1.pdf";
        //Retour de la fonction extractMetadataFromFilename
        $extractMetadataFromFilename = $digitalizedDocument->extractMetadataFromFilename($filename);
        //On vérifie les données retournées
        $this->assertEquals($extractMetadataFromFilename["title"], "PC31_1");
        $this->assertEquals($extractMetadataFromFilename["dateEvenementDocument"], "12/12/2012");

        //Nom erroné de document
        $filename = "20591212.pdf";
        //Retour de la fonction extractMetadataFromFilename
        $extractMetadataFromFilename = $digitalizedDocument->extractMetadataFromFilename($filename);
        //On vérifie que le tableau retourné est vide
        $this->assertEquals($extractMetadataFromFilename, null);
        $digitalizedDocument->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Test la fonction extractMetadataToFilestorage
     */
    public function testExtractMetadataToFilestorage() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $digitalizedDocument = new DigitalizedDocument($f);
        //Nom possible de dossier
        $path = "../var/digitalization/Todo/PC0130551200001.P0";
        $path_no_p0 = "../var/digitalization/Todo/PA0130551200001";
        //Nom possible de document
        $filename = "20091106AUTPCP.pdf";
        //Retour de la fonction extractMetadataToFilestorage
        $extractMetadataToFilestorage = $digitalizedDocument->extractMetadataToFilestorage($path, $filename);
        $extractMetadataToFilestorage_no_p0 = $digitalizedDocument->extractMetadataToFilestorage($path_no_p0, $filename);
        //On vérifie les données retournées
        $this->assertEquals($extractMetadataToFilestorage['filename'], '20091106AUTPCP.pdf');
        $this->assertEquals($extractMetadataToFilestorage['size'], '17435');
        $this->assertEquals($extractMetadataToFilestorage['mimetype'], 'application/pdf');
        // Pour le dossier sans P0
        $this->assertEquals($extractMetadataToFilestorage_no_p0['filename'], '20091106AUTPCP.pdf');
        $this->assertEquals($extractMetadataToFilestorage_no_p0['size'], '17435');
        $this->assertEquals($extractMetadataToFilestorage_no_p0['mimetype'], 'application/pdf');

        //Nom possible de document avec une nomenclature externe
        $filename = "20121212PC31_1.pdf";
        //Retour de la fonction extractMetadataToFilestorage
        $extractMetadataToFilestorage = $digitalizedDocument->extractMetadataToFilestorage($path, $filename);
        $extractMetadataToFilestorage_no_p0 = $digitalizedDocument->extractMetadataToFilestorage($path_no_p0, $filename);
        //On vérifie les données retournées
        $this->assertEquals($extractMetadataToFilestorage['filename'], '20121212PC31_1.pdf');
        $this->assertEquals($extractMetadataToFilestorage['size'], '17435');
        $this->assertEquals($extractMetadataToFilestorage['mimetype'], 'application/pdf');
        // Pour le dossier sans P0
        $this->assertEquals($extractMetadataToFilestorage_no_p0['filename'], '20121212PC31_1.pdf');
        $this->assertEquals($extractMetadataToFilestorage_no_p0['size'], '17435');
        $this->assertEquals($extractMetadataToFilestorage_no_p0['mimetype'], 'application/pdf');

        //Chemin document erroné
        $path = "";
        $path_no_p0 = "";
        //Nom possible de document
        $filename = "20091106AUTPCP.pdf";
        //Retour de la fonction extractMetadataToFilestorage
        $extractMetadataToFilestorage = $digitalizedDocument->extractMetadataToFilestorage($path, $filename);
        $extractMetadataToFilestorage_no_p0 = $digitalizedDocument->extractMetadataToFilestorage($path_no_p0, $filename);
        //On vérifie que le retour est null
        $this->assertEquals($extractMetadataToFilestorage, null);
        $this->assertEquals($extractMetadataToFilestorage_no_p0, null);
        $digitalizedDocument->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }
    
    /**
     * Test la fonction createFileTemporary
     */
    public function testCreateFileTemporary() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $digitalizedDocument = new DigitalizedDocument($f);
        // XXX hack temporaire : la commande suivante permet de ne pas avoir d'erreurs de
        // permissions système dues à l'enchaînement des tests *testREST.php* et
        // *testDigitalizedDocument.php*
        exec("sudo chmod 777 -R ../var > /dev/null 2>&1");

        //Nom possible d'un répertoire
        $foldername = "PC0130551200001.P0";
        $foldername_no_p0 = "PA0130551200001";
        //Nom possible de dossier
        $path = "../var/digitalization/Todo/PC0130551200001.P0";
        $path_no_p0 = "../var/digitalization/Todo/PA0130551200001";
        //Nom possible de document
        $filename = "20091106AUTPCP.pdf";
        //Construit les métadonnées
        $metadata = array();
        //Données récupérées pour le filestorage
        $metadata = $digitalizedDocument->extractMetadataToFilestorage($path, $filename);
        $metadata_no_p0 = $digitalizedDocument->extractMetadataToFilestorage($path_no_p0, $filename);
        //Recupère le contenu du fichier
        $file_content = file_get_contents($path.'/'.$filename);
        $file_content_no_p0 = file_get_contents($path.'/'.$filename);
    
        //Retour de la fonction createFile
        $createFile = $digitalizedDocument->createFileTemporary($file_content, $metadata);
        $createFile_no_p0 = $digitalizedDocument->createFileTemporary($file_content_no_p0, $metadata_no_p0);
        //On vérifie que l'action s'est bien déroulée
        $file_exists_filestorage = $digitalizedDocument->filestorage->get_temporary($createFile);
        $file_exists_filestorage_no_p0 = $digitalizedDocument->filestorage->get_temporary($createFile_no_p0);
        $this->assertTrue($file_exists_filestorage != null);
        $this->assertTrue($file_exists_filestorage_no_p0 != null);
        $digitalizedDocument->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Test la fonction createDocumentNumerise
     */
    public function testCreateDocumentNumerise() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $digitalizedDocument = new DigitalizedDocument($f);
        //Nom possible d'un répertoire
        $foldername = "PC0130551200001.P0";
        $foldername_no_p0 = "PA0130551200001";
        //Identifiant du dossier
        $dossier = "PC0130551200001P0";
        $dossier_no_p0 = "PA0130551200001";
        //Nom possible de dossier
        $path = "../var/digitalization/Todo/PC0130551200001.P0";
        $path_no_p0 = "../var/digitalization/Todo/PA0130551200001";
        //Nom du document
        $filename = "20091106AUTPCP.pdf";
        //Création du fichier
        $newfile = "20091106RIPC05.pdf";
        copy($path.'/'.$filename, $path.'/'.$newfile);
        copy($path_no_p0.'/'.$filename, $path_no_p0.'/'.$newfile);
        //Instance document_numerise
        require_once "../obj/document_numerise.class.php";
        $document_numerise = new document_numerise("]", $f->db, NULL);

        //Construit les métadonnées
        $metadata = array();
        $metadata_no_p0 = array();
        //Données récupérées pour le filestorage
        $metadata = $digitalizedDocument->extractMetadataToFilestorage($path, $newfile);
        $metadata_no_p0 = $digitalizedDocument->extractMetadataToFilestorage($path_no_p0, $newfile);

        //Recupère le contenu du fichier
        $file_content = file_get_contents($path.'/'.$newfile);
        $file_content_no_p0 = file_get_contents($path_no_p0.'/'.$newfile);

        //Créer le fichier temporaire
        $uid = $digitalizedDocument->createFileTemporary($file_content, $metadata);
        $uid_no_p0 = $digitalizedDocument->createFileTemporary($file_content_no_p0, $metadata_no_p0);

        //Retour de la fonction createFileStorage
        $createDocumentNumerise = $digitalizedDocument->createDocumentNumerise($document_numerise, $uid, $dossier, $newfile, $f->db, NULL);
        $createDocumentNumerise_no_p0 = $digitalizedDocument->createDocumentNumerise($document_numerise, $uid_no_p0, $dossier_no_p0, $newfile, $f->db, NULL);

        //Supprime le fichier laissé dans le dossier Todo
        unlink($path.'/'.$newfile);
        unlink($path_no_p0.'/'.$newfile);

        //On vérifie que le fichier a bien été créé dans le filestorage
        $uid = $this->get_uid_by_id($f, $createDocumentNumerise);
        $uid_no_p0 = $this->get_uid_by_id($f, $createDocumentNumerise_no_p0);

        $file_exists_filestorage = $digitalizedDocument->filestorage->get($uid);
        $file_exists_filestorage_no_p0 = $digitalizedDocument->filestorage->get($uid_no_p0);

        $this->assertTrue($file_exists_filestorage != null);
        $this->assertTrue($file_exists_filestorage_no_p0 != null);

        //Uid pas présent dans la bdd
        $uid = uniqid();
        $uid_no_p0 = uniqid();
        //On vérifie que false est bien retourné
        $this->assertEquals($this->checkLinkFile($f, $uid), false);
        $this->assertEquals($this->checkLinkFile($f, $uid_no_p0), false);
        $digitalizedDocument->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Test la fonction moveDocumentNumerise
     */
    public function testMoveDocumentNumerise() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $digitalizedDocument = new DigitalizedDocument($f);
        //Dossier source
        $pathSrc = "../var/digitalization/Todo/PC0130551200001.P0";
        $pathSrc_no_p0 = "../var/digitalization/Todo/PA0130551200001";
        //Dossier de destination
        $pathDes = "../var/digitalization/Done/PC0130551200001.P0";
        $pathDes_no_p0 = "../var/digitalization/Done/PA0130551200001";
        //Nom du fichier
        $filename = "20091106AUTPCP.pdf";
        //Retour de la fonction moveDocumentNumerise
        $moveFile = $digitalizedDocument->moveDocumentNumerise($pathSrc, $pathDes, $filename);
        $moveFile_no_p0 = $digitalizedDocument->moveDocumentNumerise($pathSrc_no_p0, $pathDes_no_p0, $filename);
        //On vérifie que l'action s'est bien déroulée
        //Le document doit être présent dans la destination
        $file_exists_destination = file_exists($pathDes.'/'.$filename);
        $file_exists_destination_no_p0 = file_exists($pathDes_no_p0.'/'.$filename);
        $this->assertEquals($file_exists_destination, true);
        $this->assertEquals($file_exists_destination_no_p0, true);
        //Le document ne doit plus être présent dans la source
        $file_exists_source = file_exists($pathSrc.'/'.$filename);
        $file_exists_source_no_p0 = file_exists($pathSrc_no_p0.'/'.$filename);
        $this->assertEquals($file_exists_source, false);
        $this->assertEquals($file_exists_source_no_p0, false);
        
        //Remet le fichier dans todo pour les autres tests
        rename($pathDes.'/'.$filename, $pathSrc.'/'.$filename);
        rename($pathDes_no_p0.'/'.$filename, $pathSrc_no_p0.'/'.$filename);
        $digitalizedDocument->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Test la fonction purgeFiles
     */
    public function testPurgeFiles() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $digitalizedDocument = new DigitalizedDocument($f);
        //Dossier source
        $pathSrc = "../var/digitalization/Todo/PC0130551200001.P0";
        $pathSrc_no_p0 = "../var/digitalization/Todo/PA0130551200001";
        //Dossier de destination
        $pathDes = "../var/digitalization/Done/PC0130551200001.P0";
        $pathDes_no_p0 = "../var/digitalization/Done/PA0130551200001";
        //Création dossier
        if (!file_exists($pathDes)) {
            mkdir("../var/digitalization/Done/PC0130551200001.P0");
        }
        if (!file_exists($pathDes_no_p0)) {
            mkdir("../var/digitalization/Done/PA0130551200001");
        }
        //Nom du fichier
        $filename = "20091106AUTPCP.pdf";
        //Met le fichier dans Done
        copy($pathSrc.'/'.$filename, $pathDes.'/'.$filename);
        copy($pathSrc_no_p0.'/'.$filename, $pathDes_no_p0.'/'.$filename);

        //fichier
        $file = $pathDes.'/'.$filename;
        $file_no_p0 = $pathDes_no_p0.'/'.$filename;
        //Date de l'import du document
        $dateImport = "2012-01-01";
        //Nombre jour
        $nbDay = 60;
        //Retour de la fonction purge
        $purgeFiles = $digitalizedDocument->purgeFiles($file, $dateImport, $nbDay);
        //On vérifie que l'action s'est bien déroulée
        $this->assertEquals($purgeFiles, true);

        //Création du fichier
        $newfile = "20091106RIPC05.pdf";
        copy($pathSrc.'/'.$filename, $pathDes.'/'.$newfile);
        copy($pathSrc_no_p0.'/'.$filename, $pathDes_no_p0.'/'.$newfile);
        //fichier
        $file = $pathDes.'/'.$newfile;
        $file_no_p0 = $pathDes_no_p0.'/'.$newfile;
        //Retour de la fonction purge sans les paramètres de date
        $purgeFiles = $digitalizedDocument->purgeFiles($file);
        $purgeFiles_no_p0 = $digitalizedDocument->purgeFiles($file_no_p0);
        //On vérifie que l'action s'est bien déroulée
        $this->assertEquals($purgeFiles, true);
        $this->assertEquals($purgeFiles_no_p0, true);

        //Création du fichier
        $newfile = "20091106DGPC03.pdf";
        copy($pathSrc.'/'.$filename, $pathDes.'/'.$newfile);
        copy($pathSrc_no_p0.'/'.$filename, $pathDes_no_p0.'/'.$newfile);

        //fichier
        $file = $pathDes.'/'.$newfile;
        $file_no_p0 = $pathDes_no_p0.'/'.$newfile;
        //Date de l'import du document
        $dateImport = date('d-m-Y');
        //Nombre jour
        $nbDay = 60;
        //Retour de la fonction purge 
        $purgeFiles = $digitalizedDocument->purgeFiles($file, $dateImport, $nbDay);
        $purgeFiles_no_p0 = $digitalizedDocument->purgeFiles($file_no_p0, $dateImport, $nbDay);

        //On vérifie que l'action s'est bien déroulée
        $this->assertEquals($purgeFiles, false);
        $this->assertEquals($purgeFiles_no_p0, false);

        //Supprime le fichier laissé dans le dossier Done
        unlink($pathDes.'/'.$newfile);
        unlink($pathDes_no_p0.'/'.$newfile);
        $digitalizedDocument->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Test la fonction run_import
     */
    public function test_run_import() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $digitalizedDocument = new DigitalizedDocument($f);
        //Nom de dossier
        $pathSrc = "../var/digitalization/Todo/PC0130551200001.P0";
        $pathSrc_no_p0 = "../var/digitalization/Todo/PA0130551200001";
        //Nom dossier destination
        $pathDes = "../var/digitalization/Done/PC0130551200001.P0";
        $pathDes_no_p0 = "../var/digitalization/Done/PA0130551200001";
        //Renomme le fichier pdf
        $path = "../var/digitalization/Todo/PC0130551200001.P0";
        $listFiles = $digitalizedDocument->listFiles($pathSrc);
        $listFiles_no_p0 = $digitalizedDocument->listFiles($pathSrc_no_p0);
        //On vérifie les documents retourné
        rename($pathSrc.'/'."20091106AUTPCP.pdf", $pathSrc.'/'."20091106NDL.pdf");
        rename($pathSrc.'/'."20091106AUTPCP-1.pdf", $pathSrc.'/'."20091106NDL-1.pdf");
        rename($pathSrc_no_p0.'/'."20091106AUTPCP.pdf", $pathSrc_no_p0.'/'."20091106NDL.pdf");
        rename($pathSrc_no_p0.'/'."20091106AUTPCP-1.pdf", $pathSrc_no_p0.'/'."20091106NDL-1.pdf");
        
        //Retour de la fonction run_import
        $run_import = $digitalizedDocument->run_import($pathSrc, $pathDes);
        $run_import_no_p0 = $digitalizedDocument->run_import($pathSrc_no_p0, $pathDes_no_p0);
        //On vérifie que l'action s'est bien déroulée
        $this->assertEquals($run_import, true);
        $this->assertEquals($run_import_no_p0, true);
        $this->assertEquals(count($digitalizedDocument->filenameError), 0);

        //Replace les fichiers dans le fichier source
        copy($pathDes.'/'."20091106NDL.pdf", $pathSrc.'/'."20091106AUTPCP.pdf");
        copy($pathDes.'/'."20091106NDL-1.pdf", $pathSrc.'/'."20091106AUTPCP-1.pdf");
        copy($pathDes_no_p0.'/'."20091106NDL.pdf", $pathSrc_no_p0.'/'."20091106AUTPCP.pdf");
        copy($pathDes_no_p0.'/'."20091106NDL-1.pdf", $pathSrc_no_p0.'/'."20091106AUTPCP-1.pdf");
        $digitalizedDocument->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Test la fonction run_purge
     */
    public function test_run_purge() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $digitalizedDocument = new DigitalizedDocument($f);
        //
        copy('binary_files/20091106AUTPCP.pdf', '../var/digitalization/Todo/PC0130551200001.P0/20091106AUTPCP.pdf');
        copy('binary_files/20091106AUTPCP-1.pdf', '../var/digitalization/Todo/PC0130551200001.P0/20091106AUTPCP-1.pdf');
        copy('binary_files/20091106AUTPCP.pdf', '../var/digitalization/Todo/PA0130551200001/20091106AUTPCP.pdf');
        copy('binary_files/20091106AUTPCP-1.pdf', '../var/digitalization/Todo/PA0130551200001/20091106AUTPCP-1.pdf');
        //Dossier source
        $pathSrc = "../var/digitalization/Todo/PC0130551200001.P0";
        $pathSrc_no_p0 = "../var/digitalization/Todo/PA0130551200001";
        //Dossier de destination
        $pathDes = "../var/digitalization/Done/PC0130551200001.P0";
        $pathDes_no_p0 = "../var/digitalization/Done/PA0130551200001";
        //Création dossier
        if (!file_exists($pathDes)) {
            mkdir("../var/digitalization/Done/PC0130551200001.P0");
        }
        if (!file_exists($pathDes_no_p0)) {
            mkdir("../var/digitalization/Done/PA0130551200001");
        }
        //Nom du fichier
        $filename = "20091106AUTPCP.pdf";
        //Met le fichier 20091106AUTPCP dans Done
        copy($pathSrc.'/'.$filename, $pathDes.'/'.$filename);
        copy($pathSrc_no_p0.'/'.$filename, $pathDes_no_p0.'/'.$filename);
        //Création du fichier 20091106RIPC05
        $newfile = "20091106RIPC05.pdf";
        copy($pathSrc.'/'.$filename, $pathDes.'/'.$newfile);
        copy($pathSrc_no_p0.'/'.$filename, $pathDes_no_p0.'/'.$newfile);
        //Création du fichier 20091106DGPC03
        $newfile = "20091106DGPC03.pdf";
        copy($pathSrc.'/'.$filename, $pathDes.'/'.$newfile);
        copy($pathSrc_no_p0.'/'.$filename, $pathDes_no_p0.'/'.$newfile);

        //Retour de la fonction run_purge sans date
        $run_purge = $digitalizedDocument->run_purge($pathDes);
        $run_purge_no_p0 = $digitalizedDocument->run_purge($pathDes_no_p0);

        //On vérifie que l'action s'est bien déroulée
        $this->assertEquals($run_purge, true);
        $this->assertEquals($run_purge_no_p0, true);
        $digitalizedDocument->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }
}
