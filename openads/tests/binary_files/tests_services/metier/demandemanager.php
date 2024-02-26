<?php
/**
 * Ce fichier permet de déclarer la classe DemandeManager, qui effectue les
 * traitements pour la ressource 'demande'.
 *
 * @package openfoncier
 * @version SVN : $Id: demandemanager.php 15835 2023-10-05 12:46:12Z softime $
 */

// Inclusion de la classe de base MetierManager
require_once("../services/metier/metiermanager.php");
require_once("../obj/demandeur.class.php");
require_once("../obj/demande.class.php");


/**
 * Cette classe hérite de MetierManager. Elle permet de créer des demandes, de
 * la même manière qu'une demande aurait été créée par l'interface : les dossiers
 * d'autorisation, dossiers d'instruction et demandeurs liés sont aussi créés (si 
 * applicable).
 * La gestion des codes d'erreur est volontairement succinte : on renvoie une
 * erreur 400 dès qu'on rencontre une erreur à n'importe quel moment de la
 * création de la demande. On procède de cette manière car il n'est pas possible
 * actuellement dans OM de savoir quelle est la raison de l'échec d'une méthode
 * comme ajouter(), erreur interne ou mauvaises données.
 */
class DemandeManager extends MetierManager {


    // Identifiant de la collectivité de la demande
    private $collectivite = array();


    /**
     * Méthode principale qui gère le processus entier de création de demande :
     *  - création du ou des demandeurs
     *  - création d'une nouvelle demande ou demande sur existant
     *
     * @param array $request_data Les données brutes de la demande sous forme
     * de tableau associatif :
     * array(
     *     'demande' => array(
     *         'demande_type' => '...',
     *         'date_demande' => '...',
     *         [...]
     *      ),
     *     'petitionnaire_principal' => array(
     *         'particulier_nom' => '...',
     *         [...]
     *      ),
     *     'autres_demandeurs' => array(...)
     * )
     * @return string Le résultat du traitement
     */
    public function create($request_data) {
        $this->f->disableLog();

        $_POST = array();

        if (array_key_exists("demande_type", $request_data['demande']) === false) {
            $this->setMessage(_("Le paramètre demande_type est obligatoire."));
            return $this->BAD_DATA;
        }

        if (isset($request_data["autre_demandeurs"]) === false || is_array($request_data["autre_demandeurs"]) === false) {
            $request_data["autre_demandeurs"] = array();
        }

        // Ajout de demande sur existant
        if (isset($request_data["dossier_instruction"]) === true && $request_data["dossier_instruction"] !== '') {
            // Retraitement spécifique des données de la demande sur existant
            $demande_values = $this->prepare_demande_existant_data($request_data);
            if ($demande_values === false) {
                $this->setMessage(_("Erreur lors de la création de la demande.") . " " . $this->getMessage());
                return $this->BAD_DATA;
            }
        }
        // Ajout d'une nouvelle demande
        else {
            // Retraitement spécifique des données de la nouvelle demande
            $demande_values = $this->prepare_new_demande_data($request_data);
            if ($demande_values === false) {
                $this->setMessage(_("Erreur lors de la création de la demande.") . " " . $this->getMessage());
                return $this->BAD_DATA;
            }

            // Les données vides saisies en RobotFramework peuvent être définies de
            // différentes manières : dictionnaire vide, ${EMPTY}, ${NULL}, null
            // On prend ici en compte tous les cas pour faciliter l'écriture des tests
            if ($request_data["petitionnaire_principal"] !== null
                && $request_data["petitionnaire_principal"] !== "null"
                && $request_data["petitionnaire_principal"] !== ""
                && $request_data["petitionnaire_principal"] !== array()) {
                $request_data["autre_demandeurs"]["petitionnaire_principal"] = $request_data["petitionnaire_principal"];
            }

            // Ajout des demandeurs
            foreach ($request_data["autre_demandeurs"] as $demandeur_type => $demandeur_valeur) {
                $demandeur_id = $this->creation_demandeur($demandeur_type, $demandeur_valeur);
                if ($demandeur_id === false) {
                    $this->setMessage(_("Erreur lors de l'ajout du ") . $demandeur_type . ". " . $this->getMessage());
                    return $this->BAD_DATA;
                }

                if (array_key_exists($demandeur_type, $_POST) == false) {
                    $_POST[$demandeur_type] = array();
                }
                $_POST[$demandeur_type][] = $demandeur_id;
            }
        }

        // Retraitement commun des données de la demande
        $demande_values = $this->prepare_demande_data($request_data, $demande_values);
        if ($demande_values === false) {
            $this->setMessage(_("Erreur lors de la création de la demande.") . " " . $this->getMessage());
            return $this->BAD_DATA;
        }

        $demande = $this->f->get_inst__om_dbform(array(
            "obj" => "demande",
            "idx" => "]",
        ));

        // Prise en compte des faux POST
        $this->f->set_submitted_value();
        $demande->getPostedValues();

        if ($demande->ajouter($demande_values) === false) {
            $this->setMessage(_("Erreur lors de la création de la demande.") . " " . $demande->msg);
            return $this->BAD_DATA;
        }

        $dossier_instruction_id = $demande->valF['dossier_instruction'];
        if ($dossier_instruction_id === false) {
            $this->setMessage(_("Erreur lors de la création de la demande.") . " " . $this->getMessage());
            return $this->BAD_DATA;
        }

        /*$match = preg_match("|^([A-Z]{2,3})\s{0,1}(\d{6})\s{0,1}(\d{2})\s{0,1}([[:alnum:]]{5}[A-Z]{0,5}\d{0,2})$|",
            $dossier_instruction_id, $return);

        if ($match != 1) {
            $this->setMessage("Erreur lors de la création de la demande. Le format du numéro de dossier créé n'est pas correct." . $dossier_libelle);
            return $this->BAD_DATA;
        }
        $dossier_libelle = $return[1] . " " . $return[2] . " " .$return[3] . " " . $return[4];*/

        $di = $this->f->get_inst__om_dbform(array(
            "obj" => "dossier",
            "idx" => "$dossier_instruction_id"
        ));

        $valF = array();
        foreach(array('latitude', 'longitude', 'rayon') as $key) {
            if(isset($request_data["demande"]["geoloc_$key"])) {
                $valF["geoloc_$key"] = $request_data["demande"]["geoloc_$key"];
            }
        }
        $mod = null;
        if (! empty($valF)) {
            //$di->setValFFromVal();
            $val = array();
            foreach ($di->champs as $champ) {
                $val[$champ] = $di->getVal($champ);
            }
            unset($val['dossier_autorisation_type_detaille']);
            if (isset($val['date_depot'])) {
                $val['date_depot'] = (DateTime::createFromFormat('Y-m-d', $val["date_depot"]))->format('d/m/Y');
            }
            $val = array_merge($val, $valF);
            if(! $di->modifier($val)) {
                $this->setMessage(preg_replace('/\<br(\s*)?\/?\>/i', ".\n", strip_tags($di->msg, '<br>')));
                return $this->BAD_DATA;
            }
        }

        $result = array(
            "dossier" => $di->getVal('dossier_libelle'),
        );
        $this->setMessage($result);
        return $this->OK;
    }

    /**
     * Cette méthode complète et reformate les données envoyées en paramétre
     * au web service, seulement dans le cas de la création d'une nouvelle
     * demande, puis fait appel à la méthode générique de création de demande.
     *
     * @param array $request_data Les données brutes de la demande sous forme
     * de tableau associatif.
     * @return array Les données de la demande reformatées et complétées sous
     * forme de tableau associatif.
     */
    private function prepare_new_demande_data($request_data) {

        $demande_values = array();
        $demande = $this->f->get_inst__om_dbform(array(
            "obj" => "demande",
            "idx" => "]",
        ));

        foreach($demande->champs as $value) {
            $demande_values[$value] = null;
        }
        foreach ($demande->champs as $value) {
            if (array_key_exists($value, $request_data['demande']) === true) {
                $demande_values[$value] = $request_data['demande'][$value];
            }
        }

        $demande_values['dossier_autorisation_type_detaille']
            = $this->get_dossier_autorisation_type_detaille($request_data["demande"]["dossier_autorisation_type_detaille"]);
        if ($demande_values['dossier_autorisation_type_detaille'] === false) {
            return false;
        }

        //
        return $demande_values;
    }

    /**
     * Cette méthode complète et reformate les données envoyées en paramétre
     * au web service, seulement dans le cas de la création d'une demande sur
     * existant.
     * 
     * @param array $request_data Les données brutes de la demande sous forme
     * de tableau associatif.
     * @return array Les données de la demande reformatées et complétées sous
     * forme de tableau associatif.
     */
    private function prepare_demande_existant_data($request_data) {
        $demande_values = array();
        $demande = $this->f->get_inst__om_dbform(array(
            "obj" => "demande",
            "idx" => "]",
        ));

        foreach($demande->champs as $value) {
            $demande_values[$value] = null;
        }

        $dossier_existant_id = str_replace(" ", "", $request_data["dossier_instruction"]);
        $dossier_existant_values = $this->get_values_dossier_existant($dossier_existant_id);
        if ($dossier_existant_values === false) {
            return false;
        }

        foreach ($dossier_existant_values as $colonne => $valeur) {
            $demande_values[$colonne] = $valeur;
        }

        foreach ($demande->champs as $value) {
            if (array_key_exists($value, $request_data['demande']) === true) {
                $demande_values[$value] = $request_data['demande'][$value];
            }
        }

        $demande_values['dossier_autorisation_type_detaille']
            = $this->get_dossier_autorisation_type_depuis_dossier($dossier_existant_id);
        if ($demande_values['dossier_autorisation_type_detaille'] === false) {
            return false;
        }

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    demandeur.demandeur,
                    lien_dossier_demandeur.petitionnaire_principal,
                    demandeur.type_demandeur
                FROM
                    %1$slien_dossier_demandeur
                    LEFT JOIN %1$sdemandeur
                        ON lien_dossier_demandeur.demandeur = demandeur.demandeur
                WHERE
                    lien_dossier_demandeur.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier_existant_id)
            ),
            array(
                "origin" => __METHOD__
            )
        );
        foreach ($qres['result'] as $row) {
            if ($row["petitionnaire_principal"] == 't') {
                $row["type_demandeur"] .= "_principal";
            }
            if (array_key_exists($row["type_demandeur"], $_POST) === false) {
                $_POST[$row["type_demandeur"]] = array();
            }
            $_POST[$row["type_demandeur"]][] = $row['demandeur'];
        }
        $_POST["idx_dossier"] = $dossier_existant_id;
        $demande_values["dossier_instruction"] = $dossier_existant_id;

        //
        return $demande_values;
    }


    /**
     * Cette méthode complète et reformate les paramètres de la nouvelle demande
     * envoyés au web service. Ces traitements sont communs aux nouvelles
     * demandes et aux demandes sur existant.
     *
     * @param array $request_data Les données brutes de la demande sous forme
     * de tableau associatif.
     * @param array $demande_values Les champs et valeurs de l'objet demande
     * @return array Les données de la demande reformatées et complétées sous
     * forme de tableau associatif.
     */
    private function prepare_demande_data($request_data, $demande_values) {

        // Si les références cadastrales sont récupérées des paramètres passés
        // en JSON, on les reformate
        // Si elles sont récupérées d'un dossier existant, on les garde telles
        // quelles
        if (array_key_exists("terrain_references_cadastrales", $request_data["demande"])
            && $demande_values["terrain_references_cadastrales"] !== null) {
            //
            $demande_values['terrain_references_cadastrales'] = "";
            foreach ($request_data["demande"]["terrain_references_cadastrales"] as $value) {
                $demande_values['terrain_references_cadastrales'] .= $value;
            }
            $demande_values['terrain_references_cadastrales'] = strtoupper($demande_values['terrain_references_cadastrales']) . ";";
        }

        if (array_key_exists("date_demande", $request_data["demande"])) {
            $demande_values['date_demande'] = $request_data["demande"]["date_demande"];
        }
        else {
            $demande_values['date_demande'] = (new DateTime())->format('d/m/Y');
        }

        if (array_key_exists("om_collectivite", $request_data["demande"]) === false
            && array_key_exists("dossier_instruction", $request_data) === false) {
            //
            $this->setMessage(_("Le paramètre om_collectivite est obligatoire pour la création d'un nouveau dossier."));
            return false;
        }

        if (isset($request_data["dossier_instruction"]) === true
            && array_key_exists("om_collectivite", $request_data["demande"])) {
            $demande_values['om_collectivite'] = $this->get_collectivite($request_data["demande"]["om_collectivite"]);
        }
        elseif (array_key_exists("om_collectivite", $request_data["demande"])) {
            $demande_values['om_collectivite'] = $this->get_collectivite($demande_values["om_collectivite"]);
        }
        if ($demande_values['om_collectivite'] === false) {
            return false;
        }

        $demande_values['demande_type'] = $this->get_demande_type($demande_values["demande_type"], $demande_values['dossier_autorisation_type_detaille']);
        if ($demande_values['demande_type'] === false) {
            return false;
        }

        if (array_key_exists("autorisation_contestee", $request_data["demande"]) === true) {
            $demande_values["autorisation_contestee"] = str_replace(" ", "", $demande_values["autorisation_contestee"]);
            $demande_values = $this->getAutorisationContestee($demande_values);
            if ($demande_values === false) {
                return false;
            }
        }

        $demande_values['depot_electronique'] = 'f';
        if (array_key_exists("depot_electronique", $request_data["demande"]) === true && $request_data["demande"]["depot_electronique"] === 'true') {
            $demande_values['depot_electronique'] = 't';
        }

        $demande_values['parcelle_temporaire'] = 'f';
        if (array_key_exists("parcelle_temporaire", $request_data["demande"]) === true && $request_data["demande"]["parcelle_temporaire"] === 'true') {
            $demande_values['parcelle_temporaire'] = 't';
        }

        $demande_values['source_depot'] = 'app';
        if (array_key_exists("source_depot", $request_data["demande"]) === true) {
            $demande_values['source_depot'] = $request_data["demande"]["source_depot"];
        }

        $demande_values['etat_transmission_platau'] = 'non_transmissible';
        if (array_key_exists("etat_transmission_platau", $request_data["demande"]) === true) {
            $demande_values['etat_transmission_platau'] = $request_data["demande"]["etat_transmission_platau"];
        }

        //
        return $demande_values;
    }

    /**
     * Cette methode prend un dossier d'instruction et retourne le type
     * de dossier d'autorisation détaillé.
     *
     * @param string $dossier_instruction_id Le numéro de dossier d'instruction
     * @return int l'identifiant du type de DA detaillé
     */
    private function get_dossier_autorisation_type_depuis_dossier($dossier_instruction_id) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    demande.dossier_autorisation_type_detaille
                FROM
                    %1$sdemande
                WHERE
                    demande.dossier_instruction = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier_instruction_id)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if ($qres["result"] == null) {
            $this->setMessage(_("Le dossier passé en paramètre n'existe pas."));
            return false;
        }
        return $qres["result"];
    }

    /**
     * Cette methode prend les valeurs du dossier et le complete avec
     * les données du dossier contesté
     *
     * @param array $demande_values Les champs remplis du dossier
     * @return array Les valeurs de la demande complétées
     */
    private function getAutorisationContestee($demande_values) {

        $autorisation_contestee_values = $this->get_values_dossier_existant($demande_values["autorisation_contestee"]);
        if ($autorisation_contestee_values === false) {
            return false;
        }

        foreach ($autorisation_contestee_values as $colonne => $valeur) {
            if ($colonne !== "dossier_autorisation" && $colonne !== "om_collectivite") {
                $demande_values[$colonne] = $valeur;
            }
        }

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    demandeur.demandeur,
                    demandeur.type_demandeur,
                    lien_dossier_demandeur.petitionnaire_principal
                FROM
                    %1$slien_dossier_demandeur
                    JOIN %1$sdemandeur 
                        ON demandeur.demandeur = lien_dossier_demandeur.demandeur 
                WHERE
                    lien_dossier_demandeur.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($demande_values["autorisation_contestee"])
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
        if ($qres['code'] !== 'OK') {
            $this->setMessage(_("Erreur de base de données."));
            return false;
        }

        $valIdDemandeur = array();
        foreach ($qres['result'] as $row) {
            $type = $row['type_demandeur'];
            if ($row['petitionnaire_principal'] == 't') {
                $type .= "_principal";
            }
            if (array_key_exists($type, $valIdDemandeur) === false) {
                $valIdDemandeur[$type] = array();
            }
            $valIdDemandeur[$type][] = $row['demandeur'];
        }
        
        foreach ($valIdDemandeur as $type => $demandeur_type_list) {
            foreach ($demandeur_type_list as $key => $demandeur_id) {
                $new_demandeur_id = $this->duplicate_demandeur($demandeur_id);
                if ($new_demandeur_id === false) {
                    return false;
                }
                if (array_key_exists($type, $_POST) === false) {
                    $_POST[$type] = array();
                }
                $_POST[$type][] = $new_demandeur_id;
            }
        }
        return $demande_values;
    }

    /**
     * Permet de dupliquer le demandeur dont l'identifiant est passé en
     * paramètre.
     * 
     * @param integer $idx Identifiant du demandeur à dupliquer.
     * 
     * @return integer Identifiant du demandeur dupliqué.   
     */
    private function duplicate_demandeur($idx) {
        require_once '../obj/demandeur.class.php';
        $demandeur = $this->f->get_inst__om_dbform(array(
            "obj" => "demandeur",
            "idx" => $idx,
        ));
        $demandeur->setValFFromVal();
        $valF = $demandeur->valF;
        $valF['demandeur'] = '';
        $valF['frequent'] = 'f';
        if ($demandeur->ajouter($valF) === true) {
            return $demandeur->valF[$demandeur->clePrimaire];
        }
        return false;
    }

    /**
     * Cette méthode permet de récupérer les données d'un dossier instruction
     * existant, soit dans le contexte de création de dossier sur existant, soit
     * dans le cas d'une autorisation contestée.
     * 
     * @param string $dossier_instruction_id Identifiant du dossier d'instruction.
     * @return int Tableau associatif contenant le nom des champs du dossier et
     * leur valeur.
     */
    private function get_values_dossier_existant($dossier_instruction_id) {

        $dossier_instruction_id = str_replace(" ", "", $dossier_instruction_id);

        $qres = $this->f->get_all_results_from_db_query(
            sprintf(
                'SELECT
                    dossier.dossier_autorisation,
                    dossier.om_collectivite,
                    dossier.terrain_references_cadastrales,
                    dossier.terrain_adresse_voie_numero,
                    dossier.terrain_adresse_voie,
                    dossier.terrain_superficie,
                    dossier.terrain_adresse_lieu_dit,
                    dossier.terrain_adresse_localite,
                    dossier.terrain_adresse_code_postal,
                    dossier.terrain_adresse_bp,
                    dossier.terrain_adresse_cedex
                FROM
                    %1$sdossier
                WHERE
                    dossier.dossier = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($dossier_instruction_id)
            ),
            array(
                'origin' => __METHOD__,
                'force_return' => true
            )
        );
    
        if ($qres['code'] !== 'OK') {
            $this->setMessage(_("Erreur de base de données."));
            return false;
        }
        $raw_dossier_instruction_values = array_shift($qres['result']);

        if ($raw_dossier_instruction_values === null) {
            $this->setMessage(_("Le dossier passé en paramètre n'existe pas."));
            return false;
        }

        foreach ($raw_dossier_instruction_values as $colonne => $valeur) {
            $dossier_instruction_values[$colonne] = $valeur;
        }
        return $dossier_instruction_values;
    }

    /**
     * Cette methode prend le type de demandeur et ces valeurs pour le créer
     * et renvoit l'identifiant du demandeur créer ou false
     *
     * @param string $demandeur_type Le type de demandeur.
     * @param array $demandeur_valeur Les champs renseignés du demandeur.
     * @return int L'identifiant du demandeur.
     */
    private function creation_demandeur($demandeur_type, $demandeur_valeur) {
        $demandeur = $this->f->get_inst__om_dbform(array(
            "obj" => "demandeur",
            "idx" => "]",
        ));
        $valAuto = array();

        foreach($demandeur->champs as $value) {
            $valAuto[$value] = null;
        }
        foreach ($demandeur_valeur as $colonne => $valeur) {
            $valAuto[$colonne] = $valeur;
        }
        if (array_key_exists("particulier_civilite", $demandeur_valeur) === true) {
            $valAuto['particulier_civilite'] = $this->get_civilite($demandeur_valeur['particulier_civilite']);
            if ($valAuto['particulier_civilite'] === false) {
                return false;
            }
        }
        if (array_key_exists("personne_morale_civilite", $demandeur_valeur) === true) {
            $valAuto['personne_morale_civilite'] = $this->get_civilite($demandeur_valeur['personne_morale_civilite']);
            if ($valAuto['personne_morale_civilite'] === false) {
                return false;
            }
        }
        if (array_key_exists("om_collectivite", $demandeur_valeur) === true) {
            $valAuto['om_collectivite'] = $this->get_collectivite($demandeur_valeur['om_collectivite']);
            if ($valAuto['om_collectivite'] === false) {
                return false;
            }
        }
        else {
            $this->setMessage(_("Le paramètre om_collectivite est obligatoire."));
            return false;
        }

        if (array_key_exists("frequent", $demandeur_valeur) === true) {
            $valAuto['frequent'] = true;
            if($demandeur_valeur["frequent"] === "false")
                $valAuto['frequent'] = false;
        }

        if (array_key_exists("qualite", $demandeur_valeur) === true) {
            $valAuto['qualite'] = str_replace(" ", "_", $demandeur_valeur['qualite']);
        }
        else {
            $valAuto['qualite'] = 'particulier';
        }
        $valAuto['type_demandeur'] = str_replace("_principal", "", $demandeur_type);

        if ($demandeur->ajouter($valAuto) === false) {
            return false;
        }
        return $demandeur->valF['demandeur'];
    }

    /**
     * Cette méthode prend le libellé de la collectivité et la transforme en
     * son identifiant en la trouvant dans la base de données et en la
     * sauvegardant pour réutilisation (ex: la même collectivité pour
     * le pétitionnaire que la demande)
     *
     * @param string $collectivite_libelle Libellé de la collectivité.
     * @return int L'identifiant de la collectivité.
     */
    private function get_collectivite($collectivite_libelle) {
        if (array_key_exists($collectivite_libelle, $this->collectivite) === false) {
            $qres = $this->f->get_one_result_from_db_query(
                sprintf(
                    'SELECT
                        om_collectivite
                    FROM
                        %1$som_collectivite
                    WHERE
                        om_collectivite.libelle = \'%2$s\'',
                    DB_PREFIXE,
                    $this->f->db->escapeSimple($collectivite_libelle)
                ),
                array(
                    "origin" => __METHOD__,
                )
            );
            if ($qres["result"] === null) {
                $this->setMessage(_("La collectivité passée en paramètre n'existe pas."));
                return false;
            }
            $this->collectivite[$collectivite_libelle] = $qres["result"];
        }
        return $this->collectivite[$collectivite_libelle];
    }

    /**
     * Cette methode prend libellé de la civilite et la transforme en
     * son identifiant en la trouvant dans la base de données et en la
     * sauvegardant pour réutilisation (ex: la même collectivité pour
     * le pétitionnaire que la demande)
     *
     * @param string $civilite_libelle Libellé de la civilité.
     * @return int L'identifiant de la civilité.
     */
    private function get_civilite($civilite_libelle) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    civilite
                FROM
                    %1$scivilite
                WHERE
                    civilite.libelle = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($civilite_libelle)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if ($qres["result"] === null) {
            $this->setMessage(_("La civilité passée en paramètre n'existe pas."));
            return false;
        }
        return $qres["result"];
    }

    /**
     * Cette methode prend en paramètre le libellé du type de demande et le
     * transforme en son identifiant en la trouvant dans la base de données en
     * vérifiant le type détaillé.
     * @param string $demande_type_libelle nom de la demande type.
     * @param string $datd_id Identifiant du type de dossier d'autorisation détaillé.
     * @return int Le résultat du traitement
     */
    private function get_demande_type($demande_type_libelle, $datd_id) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    demande_type
                FROM
                    %1$sdemande_type
                WHERE
                    demande_type.libelle = \'%2$s\'
                    AND demande_type.dossier_autorisation_type_detaille = %3$d',
                DB_PREFIXE,
                $this->f->db->escapeSimple($demande_type_libelle),
                intval($datd_id)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if ($qres["result"] === null) {
            $this->setMessage(_("Le type de demande passé en paramètre n'existe pas."));
            return false;
        }
        return $qres["result"];
    }

    /**
     * Cette methode prend le nom du dossier autorisation type detaillé
     *  et la transforme en son identifiant en la trouvant dans la base
     * de données
     *
     * @param string $datd_libelle Libellé du type de dossier d'autorisation detaillé
     * @return int Le résultat du traitement
     */
    private function get_dossier_autorisation_type_detaille($datd_libelle) {
        $qres = $this->f->get_one_result_from_db_query(
            sprintf(
                'SELECT
                    dossier_autorisation_type_detaille
                FROM
                    %1$sdossier_autorisation_type_detaille
                WHERE
                    dossier_autorisation_type_detaille.libelle = \'%2$s\'',
                DB_PREFIXE,
                $this->f->db->escapeSimple($datd_libelle)
            ),
            array(
                "origin" => __METHOD__,
            )
        );
        if ($qres["result"] === null) {
            $this->setMessage(_("Le type de dossier d'autorisation détaillé passé en paramètre n'existe pas."));
            return false;
        }
        return $qres["result"];
    }

}

?>
