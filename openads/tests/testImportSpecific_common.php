<?php
/**
 * Ce script contient la définition de la classe 'ImportSpecificCommon'.
 *
 * @package openads
 * @version SVN : $Id$
 */

require_once "../tests/resources/omtestcase.class.php";
require_once "../obj/import_specific.class.php";

/**
 * Tests unitaires des contrôles et manipulations des données récupérées
 * depuis le fichier CSV; dans l'import spécifique de CSV
 */
abstract class ImportSpecificCommon extends OMTestCase {

    /**
     * Méthode lancée en début de traitement
     */
    public function common_setUp() {
        parent::common_setUp();
        //
        $this->init_data_test();
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
     * Jeu de données : deux tableaux pour chaque test :
     * colonnes et valeurs.
     *
     * Les colonnes sont commentées par un exemple du CSV comme suit :
     * COL (débute à 0) - Libellé header
     */
    function init_data_test() {

        // check_required()
        $this->required_column = array(
            // COL 0 - Type
            "type" => array(
                "require" => true,
                "header" => "Type",
            ),
            // COL 1 - Numéro
            "numero" => array(
                "require" => true,
                "header" => "Numero",
            ),
            // COL 5 - INSEE
            "insee" => array(
                "require" => false,
                "header" => "INSEE",
            ),
        );
        $this->required_row_data = array(
            "type" => "",
            "numero" => "10",
            "insee" => "",
        );

        // check_type()
        $this->type_column = array(
            // COL 38 - Date envoi demande de pièces
            0 => array(
                "type" => "date",
                "header" => "Date envoi demande de pieces",
            ),
            1 => array(
                "type" => "date",
                "header" => "Date envoi demande de pieces",
            ),
            // COL 8 - Projet
            2 => array(
                "type" => "string",
                "header" => "Projet",
            ),
            3 => array(
                "type" => "string",
                "header" => "Projet",
            ),
            // COL 10 - Nb logements
            4 => array(
                "type" => "integer",
                "header" => "Nb logements",
            ),
            5 => array(
                "type" => "integer",
                "header" => "Nb logements",
            ),
            6 => array(
                "type" => "integer",
                "header" => "Nb logements",
            ),
            // COL 11 - Surface terrain
            7 => array(
                "type" => "float",
                "header" => "Surface terrain",
            ),
            8 => array(
                "type" => "float",
                "header" => "Surface terrain",
            ),
            // COL 24 - Lotissement
            9 => array(
                "type" => "boolean",
                "header" => "Lotissement",
            ),
            10 => array(
                "type" => "boolean",
                "header" => "Lotissement",
            ),
        );
        $this->type_row_data = array(
            0 => "10/10/2015",
            1 => "101/5/2015",
            2 => "chaîne valide",
            4 => "50",
            5 => "50a",
            6 => "50,5",
            7 => "50,5",
            8 => "50a",
            9 => "Oui",
            10 => "true",
        );

        $this->type_return_expected = array(
            // Cas 1 : date valide
            0 =>true,
            // Cas 2 : date invalide
            1 =>false,
            // Cas 3 : chaîne de caractères valide
            2 =>true,
            // Cas 5 : nombre entier valide
            4 =>true,
            // Cas 6 : nombre entier invalide
            5 =>false,
            // Cas 7 : nombre entier invalide
            6 =>false,
            // Cas 8 : nombre décimal valide
            7 =>true,
            // Cas 9 : nombre décimal invalide
            8 =>false,
            // Cas 10 : booléen valide
            9 =>true,
            // Cas 11 : booléen invalide
            10 =>false
        );

        // check_foreign_key()
        // TODO : correction temporaire
        // les clés étarngères ne sont plus récupérée de la même manière
        // la liste des valeurs possibles est définies dans la clé "link"
        // Les valeurs des clés étrangères sont récupérées via une requête
        // sql et stocké dans une variable de cache.
        $this->fk_column = array(
            // COL 0 - Type
            0 => array(
                "link" => array(
                    "PC MI" => "PI",
                    "PCMI"  => "PI",
                    "PCI"   => "PI",
                    "PA PC" => "PA",
                    "PC PD" => "PC",
                    "PA PD" => "PA",
                    "IA"    => "DIA",
                    ),
                "foreign_key" => array(
                    "id"    => "dossier_autorisation_type_detaille",
                    "table" => "dossier_autorisation_type_detaille",
                    "field" => "code",
                ),
                "header" => "Type",
            ),
            1 => array(
                "link" => array(
                    "PC MI" => "PI",
                    "PCMI"  => "PI",
                    "PCI"   => "PI",
                    "PA PC" => "PA",
                    "PC PD" => "PC",
                    "PA PD" => "PA",
                    "IA"    => "DIA",
                    ),
                "foreign_key" => array(
                    "id"    => "dossier_autorisation_type_detaille",
                    "table" => "dossier_autorisation_type_detaille",
                    "field" => "code",
                ),
                "header" => "Type",
            ),
        );

        /*
        $this->fk_column = array(
            // COL 0 - Type
            0 => array(
                "foreign_key" => array(
                    "sql"=>"SELECT dossier_autorisation_type_detaille FROM openads.dossier_autorisation_type_detaille WHERE code ='<value>'",
                    "table" => "dossier_autorisation_type_detaille",
                    "field" => "code",
                ),
                "header" => "Type",
            ),
            1 => array(
                "foreign_key" => array(
                    "sql"=>"SELECT dossier_autorisation_type_detaille FROM openads.dossier_autorisation_type_detaille WHERE code ='<value>'",
                    "table" => "dossier_autorisation_type_detaille",
                    "field" => "code",
                ),
                "header" => "Type",
            ),
        );*/
        $this->fk_row_data = array(
            0 => "PCI",
            1 => "lambda",
        );

        // set_linked_value()
        $this->linked_values_column = array(
            // COL 0 - Type
            0 => array(
                "link" => array(
                    "PC MI" => "PI",
                ),
                "header" => "Type",
            ),
            1 => array(
                "link" => array(
                    "PC MI" => "PI",
                ),
                "header" => "Type",
            ),
        );
        $this->linked_values_row_data = array(
            0 => "PCI",
            1 => "PC MI",
        );
    }

    /**
     * Teste la méthode check_required() de la classe import_specific.
     * Est-ce qu'il y a une valeur si champ obligatoire ?
     * 
     * @param   $key   [integer]  colonne du fichier CSV
     * @param   $value [string]   valeur à tester
     * @return         [string]   message d'erreur ou chaîne vide si succès
     */
    public function test_check_required() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $import_specific = new import_specific();
        // Message d'erreur
        $error = _("La colonne %s est obligatoire");
        // Utilisation du jeu de données
        $import_specific->column = $this->required_column;
        $import_specific->line = $this->required_row_data;
        // Cas 1 : champ requis vide
        $ret = $import_specific->check_required("type");
        $this->assertEquals($ret, false);
        // Cas 2 : champ requis renseigné
        $ret = $import_specific->check_required("numero");
        $this->assertEquals($ret, true);
        // Cas 3 : champ non requis vide
        $ret = $import_specific->check_required("insee");
        $this->assertEquals($ret, true);
        $import_specific->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Teste la méthode check_type() de la classe import_specific.
     * Est-ce que la valeur est valide pour le type attendu ?
     *
     * @param   $key   [integer]  colonne du fichier CSV
     * @param   $value [string]   valeur à tester
     * @return         [string]   message d'erreur ou chaîne vide si succès
     */
    public function test_check_type() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $import_specific = new import_specific();
        // Utilisation du jeu de données
        $import_specific->column = $this->type_column;
        $import_specific->line = $this->type_row_data;
        // Définition des résultats attendus
        $this->type_return_expected;
        // Pour chaque colonne testée
        foreach ($import_specific->line as $key => $value) {
            // Vérification du retour de la méthode
            $this->assertEquals(
                $import_specific->check_type($key),
                $this->type_return_expected[$key]
            );
        }
        $import_specific->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Teste la méthode get_foreign_key_id() de la classe import_specific.
     * Est-ce que la clé étrangère existe ?
     *
     * @param   $key   [integer]  colonne du fichier CSV
     * @return         [string]   message d'erreur ou chaîne vide si succès
     */
    public function test_get_foreign_key_id() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $import_specific = new import_specific();
        // Utilisation du jeu de données
        $import_specific->column = $this->fk_column;
        $import_specific->line = $this->fk_row_data;
        // Chargement du cache pour toutes les clés étrangères
        $import_specific->load_foreign_keys();
        // Cas 1 : clé étrangère valide
        $ret = $import_specific->get_foreign_key_id(0);
        $this->assertEquals($ret, true);
        // Cas 2 : clé étrangère invalide
        $ret = $import_specific->get_foreign_key_id(1);
        $this->assertEquals($ret, false);
        $import_specific->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Teste la méthode explode_address() de la classe import_specific.
     * Doit retourner un tableau d'éléments composant l'adresse fournie.
     *
     * @param   $value [string]  adresse complète
     * @return         [array]   tableau (numéro, rue, CP, ville, ...)
     */
    public function test_explode_address() {
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $import_specific = new import_specific();
        // Cas 1 : adresse 'normale' à transformer
        $adresse_complete1 = "27 bis Avenue Jules Cantini 13008 Marseille France";
        // Récupération de la transformation
        $adresse_triee1 = $import_specific->explode_address($adresse_complete1);
        // Vérification des éléments
        $this->assertEquals($adresse_triee1['numero'], '27bis');
        $this->assertEquals($adresse_triee1['voie'], 'Avenue Jules Cantini');
        $this->assertEquals($adresse_triee1['complement1'], '');
        $this->assertEquals($adresse_triee1['complement2'], '');
        $this->assertEquals($adresse_triee1['cp'], '13008');
        $this->assertEquals($adresse_triee1['ville'], 'Marseille');
        // Cas 2 : adresse longue (libellée voie supérieur à 30 caractères)
        $adresse_complete2 = "27 bis Avenue Jules Cantini Boulevard de la Blancarde 06001 Nice";
        // Récupération de la transformation
        $adresse_triee2 = $import_specific->explode_address($adresse_complete2);
        // Vérification des éléments
        $this->assertEquals($adresse_triee2['numero'], '27bis');
        $this->assertEquals($adresse_triee2['voie'], 'Avenue Jules Cantini Boulevard');
        $this->assertEquals($adresse_triee2['complement1'], 'de la Blancarde');
        $this->assertEquals($adresse_triee2['complement2'], '');
        $this->assertEquals($adresse_triee2['cp'], '06001');
        $this->assertEquals($adresse_triee2['ville'], 'Nice');
        // Cas 3 : adresse très longue (libellée voie supérieur à 60 caractères)
        // Numéro composé suivi d'une virgule
        $adresse_complete3 = "11-12, Place des grands hommes Boulevard du Panthéon Route de Paris 13380 Plan de Cuques";
        // Récupération de la transformation
        $adresse_triee3 = $import_specific->explode_address($adresse_complete3);
        // Vérification des éléments
        $this->assertEquals($adresse_triee3['numero'], '11-12');
        $this->assertEquals($adresse_triee3['voie'], 'Place des grands hommes');
        $this->assertEquals($adresse_triee3['complement1'], 'Boulevard du Panthéon Route');
        $this->assertEquals($adresse_triee3['complement2'], 'de Paris');
        $this->assertEquals($adresse_triee3['cp'], '13380');
        $this->assertEquals($adresse_triee3['ville'], 'Plan de Cuques');
        $import_specific->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }

    /**
     * Teste la méthode set_linked_value() qui subsitue les valeurs du CSV
     * par le paramétrage.
     *
     * @param   $key   [integer]  colonne du fichier CSV
     * @return  [void]
     */
    function test_set_linked_value(){
        // Instanciation de la classe *om_application*
        $f = $this->get_inst_om_application("admin", "admin");
        $f->disableLog();
        $import_specific = new import_specific();
        // Utilisation du jeu de données
        $import_specific->column = $this->linked_values_column;
        $import_specific->line = $this->linked_values_row_data;
        // Cas 1 : aucune correspondance
        // PCI reste PCI
        $import_specific->set_linked_value(0);
        $this->assertEquals($import_specific->line[0], "PCI");
        // Cas 2 : existance d'une correspondance
        // PC MI devient PI
        $import_specific->set_linked_value(1);
        $this->assertEquals($import_specific->line[1], "PI");
        $import_specific->__destruct();
        // Destruction de la classe *om_application*
        $f->__destruct();
    }
}
