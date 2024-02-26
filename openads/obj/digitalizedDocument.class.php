<?php
/**
 * Ce script permet de définir la classe 'DigitalizedDocument'.
 *
 * @package openads
 * @version SVN : $Id
 */

/**
 * Cette classe permet d'effectuer les traitements sur les documents à incorporer dans l'application
 * 
 * Pour imorter les données depuis un dossier il faut utiliser run_import dans une boucle
 * qui parcourt le dossier qui abrite les répertoires des dossiers d'instructions
 * 
 * Pour purger les documents il faut utiliser la fonction run_purge dans une boucle
 * qui parcourt le dossier qui abrite les répertoires des dossiers d'instructions
 */
class DigitalizedDocument {

    /**
     * [$log_file description]
     * @var string
     */
    static protected $log_file = "digitalized_document.log";

    /**
     * @access static
     * @var string Messages utilisées pour l'écriture dans le log
     */
    var $NO_REP;
    var $NO_FILES;
    var $NO_FILE_EXIST;
    var $DOC_NO_CONFORME;
    var $NO_LINK;
    var $NO_MOVE;
    var $NO_DELETE_FOLDER;
    var $NO_DELETE_FILE;
    var $NO_IMPORT;
   
    /**
     * Instance de la classe utils
     * @var utils
     */
    var $f = NULL;

    /**
     * Instance du filestorage
     * @var storage
     */
    var $filestorage = NULL;
    
    /**
     * Nom des fichiers qui ne se sont pas importés
     * @var array
     */
    var $filenameError = array();

    /**
     * Constructeur
     */
    public function __construct($f) {

        //Set des attributs
        $this->NO_REP = _("Le dossier n'existe pas.");
        $this->NO_FILES = _("Le dossier est vide.");
        $this->NO_FILE_EXIST = _("Le fichier n'existe pas.");
        $this->DOC_NO_CONFORME = _("Le document n'est pas conforme a la regle RG2 : ");
        $this->NO_LINK = _("Le lien entre le document et le dossier d'instruction n'a pu etre etabli.");
        $this->NO_MOVE = _("Le fichier n'a pas pu etre deplace.");
        $this->NO_DELETE_FOLDER = _("Le dossier n'a pas pu etre supprime");
        $this->NO_DELETE_FILE = _("Le fichier n'a pas pu etre supprime : ");
        $this->NO_IMPORT = _("L'importation a été annulee.");

        //
        $this->f = $f;
        // Permet lors de l'instantiation d'objets métiers d'avoir accès à f
        $GLOBALS['f'] = $this->f;

        // initialise le msg attribute qui est utilise pour stocker les
        // messages de retour (reussite ou erreur)
        $this->msg = '';

        //Instance de filestorage
        $this->filestorage = $this->f->storage;

    }

    /**
     * Destructeur
     */
    public function __destruct() {

        //Détruit les instance de utils et filestorage
        unset($this->f);
        unset($this->filestorage);

        //Détruit la variable globale de 'f'
        unset($GLOBALS['f']);
    }

    /**
     * Récupère l'identifiant du type de document par rapport au code
     * @param  string $code Code du type de document
     * @return int       Identifiant du type de document
     */
    private function get_document_numerise_by_code($code) {
        // Recherche du type de document avec le code de la nomenclature externe
        // issu du nom du fichier
        // Dans le nom du fichier des "_" sont utilisés à la place des "-" pour éviter
        // la confusion entre le code de le pièce et son numéro de version. Pour
        // retrouver la pièce ils doivent être remplacé.
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    lien_document_n_type_d_i_t.document_numerise_type 
                FROM
                    %1$slien_document_n_type_d_i_t
                WHERE
                    lien_document_n_type_d_i_t.code LIKE \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple(str_replace('_', '-', $code))
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $document_numerise_type = $qres["result"];
        if (! empty($document_numerise_type) && is_numeric($document_numerise_type)) {
            return $document_numerise_type;
        }

        //Requête SQL
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    document_numerise_type 
                FROM
                    %1$sdocument_numerise_type 
                WHERE
                    code = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($code)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        $document_numerise_type = $qres["result"];
        return $document_numerise_type;
    }

    /**
     * Ajoute une chaine de caracteres dans le log.
     * @param string $message Le message qui doit etre ajouté dans le log.
     */
    protected function add_to_log($message, $debug = false) {
        //
        logger::instance()->log_to_file(self::$log_file, $message);
        if ($debug === true) {
            $this->f->addToLog($message, DEBUG_MODE);
        }
    }

    /**
     * Cette fonction permet de recupérer et de classer dans un tableau
     * la liste des documents présent dans le dossier passé en paramètre
     * @param string $path Le chemin vers le dossier
     * @return array Tableau des documents
     */
    public function listFiles($path) {
        
        //Tableau qui sera retourné en fin de traitement
        $listFiles = array();
        
        //Ouvre le répertoire
        $dir = opendir($path);

        //Si un dossier est ouvert
        if ($dir) {

            //Parcours le dossier
            while(false !== ($file = readdir($dir))) {

                //Si le document est bien un fichier de type pdf
                $autorisedExtension = explode(';', $this->f->config['upload_extension']);

                // $this->add_to_log(__METHOD__."(): file = ".$file."; extension ? = ".strstr($file, '.')."; tableau= ".var_export($autorisedExtension, true));
                if($file != '.' && $file != '..' && !is_dir($dir.$file)
                    && ! empty($autorisedExtension) && is_array($autorisedExtension)
                    && in_array(strtolower(strstr($file, '.')), $autorisedExtension, true) === true) {
                        
                // Alors il est ajouté dans le tableau
                    array_push($listFiles, $file);

                }

            }

            //Ferme le répertoire
            closedir($dir);

        } else {

            //Sinon renvoi null
            $this->add_to_log(__METHOD__."(): ".$path." : ".$this->NO_REP);
            return null;
        }

        //Si le tableau est vide on retourne null
        if (count($listFiles) == 0) {

            $this->add_to_log(__METHOD__."(): ".$path." : ".$this->NO_FILES);
            return null;

        }

        //Retourne le tableau des documents
        return $listFiles;
        
    }

    /**
     * Cette fonction permet de construire les métadonnées d'un document
     * à partir des informations du nom du fichier
     * @param string $filename Nom du fichier
     * @return array Tableau des metadonnées
     */
    public function extractMetadataFromFilename($filename) {

        //Tableau qui sera retourné en fin de traitement
        $metadata = array();
        
        //Récupération de l'année
        $year = substr($filename, 0, 4);
        //Récupération du mois 
        $month = substr($filename, 4, 2);
        //Récupération du jour
        $day = substr($filename, 6, 2);
        
        //Vérification que l'année, le mois et le jour sont des numériques
        if (is_numeric($year) && is_numeric($month) && is_numeric($day)) {

            //Vérification que cela correspond à une date possible
            if (checkdate($month, $day, $year)) {

                //Récupération du type de document
                //Si le séparateur '-' n'est pas présent
                if (strpos($filename, '-') === false) {

                    //On récupère le nom du fichier avant l'extension
                    $type_doc = substr(strstr($filename, '.', true), 8);

                } else {

                    //Sinon on récupère le nom du fichier avant le '-'
                    $type_doc = substr(strstr($filename, '-', true), 8);

                }

                //Si aucun type de document n'a pu être extrait
                if (empty($type_doc)) {

                    //On retourne null
                    $this->add_to_log(__METHOD__."(): ".$this->DOC_NO_CONFORME.$filename, true);
                    return null;

                } else {

                    //Sinon on ajoute le type de document dans les métadonnées
                    $metadata['title'] = $type_doc;

                }
                
                //Formate la date du document
                $metadata["dateEvenementDocument"] = date("d/m/Y", mktime(0, 0, 0, $month, $day, $year));

                //Si le tableau est vide on retourne null
                if (count($metadata) == 0) {

                    $this->add_to_log(__METHOD__."(): ".$this->DOC_NO_CONFORME.$filename, true);
                    return null;

                }

                //On retourne les métadonnées
                return $metadata;
            }
        }

        //Le nom du document n'est pas conforme
        $this->add_to_log(__METHOD__."(): ".$this->DOC_NO_CONFORME.$filename, true);
        return null;
    }

    /**
     * Cette fonction permet de récupérer des informations sur le fichier
     * nécessaire pour le filestorage
     * @param  string $path     Chemin du dossier
     * @param  string $filename Nom du fichier
     * @return array           Tableau des métadonnées
     */
    public function extractMetadataToFilestorage($path, $filename) {

        //Test si le fichier existe
        if (!file_exists($path.'/'.$filename)) {
            //
            $this->add_to_log(__METHOD__.'(): '.$path.'/'.$filename.' : '.$this->NO_FILE_EXIST, true);
            return null;
        }

        //Tableau qui sera retourné en fin de traitement
        $metadata = array();

        //Métadonnées nécessaire au filestorage
        $metadata["filename"] = $filename;
        $metadata["size"] = filesize($path.'/'.$filename);
        $metadata["mimetype"] = mime_content_type($path.'/'.$filename);

        //Si le tableau est vide on retourne null
        if (count($metadata) == 0) {

            $this->add_to_log(__METHOD__."(): ".$this->DOC_NO_CONFORME.$filename, true);
            return null;

        }    

        //Retourne le tableau des métadonnées
        return $metadata;
    }

    /**
     * Cette fonction permet de créer un document temporaire dans le filesystem
     * @param string $file_content Contenu du fichier
     * @param array $metadata Métadonnées du fichier
     * @return string $uid identifiant du document dans le filesystem
     */
    public function createFileTemporary($file_content, $metadata) {

        //Création du fichier sur le filestorage
        $uid = $this->filestorage->create_temporary($file_content, $metadata);

        //Retourne l'identifiant unique du fichier créé
        return $uid;
        
    }

    /**
     * Permet de lier le document importé à l'application et de le créer dans le filestorage
     * @param  object $document_numerise Instance de la classe document_numerise
     * @param  string $uid               Identifiant du fichier temporaire
     * @param  string $dossier           Identifiant du dossier d'instruction
     * @param  string $filename          Nom du document
     *
     * @return boolean                   Vrai ou faux
     */
    public function createDocumentNumerise($document_numerise, $uid, $dossier, $filename) {
        
        //Maj en ajout
        $document_numerise->setParameter("maj",0);

        //Extrait les informations du nom du document
        $metadataFromFilename = $this->extractMetadataFromFilename($filename);

        //Données
        // Récupèration d'une nature de document numérisé pour pouvoir utiliser
        // la méthode de récupèration de la valeur de la nature par défaut
        $docNumNature = $this->f->get_inst__om_dbform(array(
            'obj' => 'document_numerise_nature',
            'idx' => ']'
        ));

        $values = array(
            'document_numerise' => '',
            'uid' => 'tmp|'.$uid,
            'dossier' => $dossier,
            'nom_fichier' => $filename,
            'date_creation' => $metadataFromFilename['dateEvenementDocument'],
            'document_numerise_type' => $this->get_document_numerise_by_code($metadataFromFilename['title']),
            'uid_dossier_final' => '',
            'document_numerise_nature' => $docNumNature->get_default_select_value($dossier),
            'description_type' => '',
            'document_travail' => false,
            'uid_thumbnail' => null,
        );

        //Ajoute dans la table le lien
        $add = $document_numerise->ajouter($values);

        //Si le document n'est pas ajouté
        if ($add === false) {

            //Log d'erreur
            $this->add_to_log(__METHOD__."(): ".$dossier."/".$filename." : "._("Une erreur s'est produite lors de l'ajout du document ").$filename.".", true);
            $this->add_to_log(__METHOD__."(): ".$document_numerise->msg, true);
            return false;
        }

        return $document_numerise->valF['document_numerise'];
    }

    /**
     * Permet de déplacer les fichiers créés dans le filestorage vers le dossier 
     * des fichiers traités
     * @param  string $pathSrc     Chemin du dossier source
     * @param  string $pathDes     Chemin du dossier de destination
     * @param  string $filename    Nom du fichier
     * @return boolean Retourne true si le fichier à été déplacé sinon false 
     */
    public function moveDocumentNumerise($pathSrc, $pathDes, $filename) {

        //Si le dossier de destination n'existe pas, il est créé
        if (!file_exists($pathDes)) {
            mkdir($pathDes);
        }
        
        //Déplace le document
        $move = rename($pathSrc.'/'.$filename, $pathDes.'/'.$filename);

        //Si le déplacement à réussi
        if ($move === true) {
            return true;
        } else {
            $this->add_to_log(__METHOD__."(): ".$pathSrc."/".$filename." : ".$this->NO_MOVE, true);
            return false;
        }

        //Si le deplacement n'est pas fait on retourne false
        $this->add_to_log(__METHOD__."(): ".$pathSrc."/".$filename." : ".$this->NO_MOVE);
        return false;
    }

    /**
     * Cette fonction permet de vider un répertoire
     * Si la date d'import du fichier et le nombre de jour ne sont pas renseignés
     * alors les fichiers sont supprimés sans vérification sur la date
     * @param string $file Fichier traité
     * @param date $dateImport Date de l'importation du fichier
     * @param int $nbDay Nombre de jour à soustraite à la date du jour
     * @return boolean true si le traitement à été fait sinon false
     */
    public function purgeFiles($file, $dateImport = null, $nbDay = null) {

        //Si la date et le nombre de jour ne sont pas renseigné
        if (($nbDay == 'null' || $nbDay == null || $nbDay == '') 
            || ($dateImport == 'null' || $dateImport == null || $dateImport == '')) {

            //On supprime le fichier sans faire de test
            $delete_file = unlink($file);
            if ($delete_file === true) {
                return true;
            } else {
                $this->add_to_log(__METHOD__."(): ".$file." : ".$this->NO_DELETE_FILE.$file, true);
                return false;
            }

        //Si la date d'import et le nombre de jour sont renseignés
        } else {

            //Date d'import dans un format correct pour la comparaison
            $dateImport = new DateTime($dateImport);
            $dateImport = $dateImport->format('Ymd');

            //Date limite pour la suppresion des fichier (Date du jour - 60 jours)
            $dateLimit = date('d-m-Y', strtotime("- $nbDay day", strtotime(date('d-m-Y'))));
            $dateLimit = new DateTime($dateLimit);
            $dateLimit = $dateLimit->format('Ymd');

            //Si la date du fichier à dépassé la date limite
            if ($dateImport <= $dateLimit) {

                //on supprime le fichier
                $delete_file = unlink($file);
                if ($delete_file === true) {
                    return true;
                } else {
                    $this->add_to_log(__METHOD__."(): ".$file." : ".$this->NO_DELETE_FILE.$file, true);
                    return false;
                }

            }

        }

        //Si aucun traitement n'a été fait on retourne false
        $this->add_to_log(__METHOD__."(): ".$file." : ".$this->NO_DELETE_FILE.$file);
        return false;

    }

    /**
     * Cette fonction permet de supprimer un dossier
     * @param  string $path Chemin du dossier
     * @return boolean       Retourn vrai si le dossier à été supprimé sinon faux
     */
    public function deleteFolder($path) {

        //Si le fichier est supprimé on retourne true
        $delete_folder = rmdir($path);
        if ($delete_folder === true) {
            return true;
        } else {
            $this->add_to_log(__METHOD__."(): ".$path." : ".$this->NO_DELETE_FOLDER, true);
            return false;
        }

        //Si le fichier n'a pas été supprimé on retourne false
        $this->add_to_log(__METHOD__."(): ".$path." : ".$this->NO_DELETE_FOLDER);
        return false;

    }

    /**
     * Cette fonction permet de lancer toutes les fonctions utiles 
     * à l'importation des documents scannés
     * @param string $pathSrc Le chemin vers le dossier à traiter
     * @param string $pathDes Le chemin vers le dossier après le traitement
     * @param string $pathErr Le chemin vers le dossier des fichiers en erreur
     * 
     * @return boolean true si le traitement à été fait sinon false
     */
    function run_import($pathSrc, $pathDes, $pathErr = null) {

        //Récupération du nom du répertoire
        $foldername = substr(strrchr($pathSrc, "/"), 1);

        //Identifiant du dossier
        $dossier = str_replace('.', '', $foldername);

        //Vérifie si le numéro de dossier d'instruction est sur quatres chiffres
        if(preg_match('/[A-Za-z]{2,3}'.strtoupper($this->f->getParameter("departement")).
            $this->f->getParameter("commune").'[0-9]{2}[0-9]{4}[A-Za-z]{1,5}[0-9]{1,2}/', 
            $dossier)){
            
            //On modifie le nom du dossier d'instruction pour qu'il ait la numérotation
            //standard
            $tempDossier = preg_split('/([A-Za-z]{2,3}'.strtoupper($this->f->getParameter("departement")).
                $this->f->getParameter("commune").'[0-9]{2})/i', $dossier, 0, PREG_SPLIT_NO_EMPTY | 
                PREG_SPLIT_DELIM_CAPTURE);
            
            $dossier = $tempDossier[0]."0".$tempDossier[1];
        }
        
        //On vérifie que le dossier existe
        $inst_dossier_instruction = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => $dossier,
        ));
        // Si le dossier n'existe pas on verifie si le dossier existe avec un suffixe sur un seul caractère par exemple M1 au lieu de M01
        if (!$inst_dossier_instruction->exists()){
            $dossier = str_replace(' ', '', $dossier);
            $matches = array();
            // Cette expression reguliere permet de créer 3 groupe dans le numero de dossier afin 
            // de pouvoir supprimer le 0 du numero de suffixe grace a un intval
            // Ceci est fait pour pouvoir verifier si le dossier traité existe avec un numero de suffixe sur un seul caractère
            if (preg_match('/(?P<num_dossier_sans_suffix>^.*?)(?P<lettre_suffix>[A-Za-z]{1,5})(?P<num_suffix>[0-9]{1,2}$)/', $dossier, $matches) === 1) {
                $dossier = $matches["num_dossier_sans_suffix"] . $matches["lettre_suffix"] . intval($matches["num_suffix"]);
                $inst_dossier_instruction = $this->f->get_inst__om_dbform(array(
                    "obj" => "dossier",
                    "idx" => $dossier,
                ));
                if (!$inst_dossier_instruction->exists()){
                    $this->add_to_log(__METHOD__."(): ".$pathSrc."/ : "._("Le dossier d'instruction n'existe pas.")." ".$this->NO_IMPORT, true);
                    return false;
                }
            }
            else {
                $this->add_to_log(__METHOD__."(): ".$pathSrc."/ : "._("Le dossier d'instruction n'existe pas.")." ".$this->NO_IMPORT, true);
                return false;
            }
        }

        //Liste les documents contenus dans le dossier
        $listFiles = $this->listFiles($pathSrc);
        //Si il n'y a aucun document
        if ($listFiles === null) {
            //On annule l'importation
            $this->add_to_log(__METHOD__."(): ".$pathSrc."/ ".$this->NO_FILES." ".$this->NO_IMPORT);
            return false;
        }
        
        foreach ($listFiles as $key => $filename) {

            //Construit les métadonnées
            $metadata = array();
            //Données récupérées pour le filestorage
            $metadata = $this->extractMetadataToFilestorage($pathSrc, $filename);

            //S'il y a des métadonnées
            if ($metadata !== null) {

                //Recupère le contenu du fichier
                $file_content = file_get_contents($pathSrc.'/'.$filename);

                //Créer le fichier temporaire
                $uid = $this->createFileTemporary($file_content, $metadata);
                // On vide la mémoire utilisée par le fichier
                unset($file_content);
                //Si le fichier est créé
                if ($uid !== null) {

                    //Instancie la class document_numerise
                    $document_numerise = $this->f->get_inst__om_dbform(array(
                        "obj" => "document_numerise",
                        "idx" => "]",
                    ));
            
                    //Valeur retour formulaire
                    $document_numerise->setParameter("retourformulaire", "dossier_instruction");

                    //Créer le document sur le filestorage et dans la table document_numerise
                    $createFileStorage = $this->createDocumentNumerise($document_numerise, $uid, $dossier, $filename);

                    //Si le document est crée sur le filestorage
                    if ($createFileStorage !== false && $createFileStorage !== 'OP_FAILURE') {

                        //On déplace le document créé dans le filestorage
                        //du dossier des "à traiter" vers celui des "traités"
                        $this->moveDocumentNumerise($pathSrc, $pathDes, $filename);

                    }
                    else {
                        //On annule l'importation et on move dans le repertoire erreur
                        $this->moveDocumentNumerise($pathSrc, $pathErr, $filename);
                        $this->add_to_log(__METHOD__."(): ".$pathSrc." : "._("Une erreur s'est produite lors de l'ajout du document ").$filename.". ".$this->NO_IMPORT, true);
                        $this->filenameError[] = $filename;
                    }
                }
            }

        }//Fin foreach

        //Retourne true
        return true;

    }

    /**
     * Cette fonction permet de lancer toutes les fonctions utiles à la purge de dossier
     * @param string $path Le chemin vers le dossier
     * @param int $nbDay Nombre de jour à soustraite à la date du jour
     * @return boolean true si le traitement à été fait sinon false
     */
    function run_purge($path, $nbDay = null) {

        //Liste les documents contenus dans le dossier
        $listFiles = $this->listFiles($path);
        $count_purged_files = 0;

        if ($listFiles !== null) {

            //Parcours la liste des fichiers
            foreach ($listFiles as $key => $filename) {
                //Fichier
                $file = $path.'/'.$filename;
                //Si le nombre de jour est renseigné
                if ($nbDay !== null) {

                    //il faut renseigner la date d'import du fichier
                    $dateImport = date("Y-m-d", filemtime($file));

                } else {

                    //Sinon la date d'import est null
                    $dateImport = null;

                }
                
                //S'il n'y pas d'erreur on exécute la fonction purgeFiles
                if($this->purgeFiles($file, $dateImport, $nbDay)) {
                    unset($listFiles[$key]);
                    $count_purged_files++;
                }
                
            }

        }
        
        //Si il n'y a plus de document
        if (empty($listFiles)) {

            //on supprime le dossier
            $deleteFolder = $this->deleteFolder($path);
            //Si le dossier n'a pas été supprimé on retourne false
            if (!$deleteFolder) {

                return false;
            }
        }

        //Si il n'y a pas d'erreur on retourne true
        return $count_purged_files;
        
    }

}


